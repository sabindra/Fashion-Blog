<?php  

namespace App\Controllers\Auth;


use App\Controllers\Controller;
use Respect\Validation\Validator as v;
use App\Services\SendGrid\SendgridEmailService;
use PDO;
use DateTime;
use DateInterval;
/**
 * 
 * @package App\Controller\Auth
 * @access public
 * @author Ryan Basnet
 * @license sprouttech
 */
class PasswordController extends Controller{




	/**
	 * [getChangePassword return password change form]
	 * [HTTP request object] $request 
	 * @param  [HTTP response object] $response 
	 * @return [HTML]           [return form for password change]
	 */
	public function getChangePassword($request,$response){

		return $this->container
					->view
					->render($response,'admin/partials/auth/change_password.twig');
	}


	/**
	 * [changePassword post password change form]
	 * [HTTP request object] $request 
	 * @param  [HTTP response object] $response 
	 * @return [HTML]           [redirects to login form form with flash message]
	 */
	public function changePassword($request,$response){

		$user_id 			= 	$this->container->auth->user()['user'];
		$user 				= 	$this->container->user->find($user_id);
		$old_password 		= 	$request->getParam('old-password');
		$new_password		=	$request->getParam('new-password');
		$confirm_password 	= 	$request->getParam('confirm-password');

		// respect validation rules
		$rules = [

				'old-password'		=>v::notEmpty()->length(5,10),
				'new-password'		=>v::notEmpty()->length(5,10),
				'confirm-password'	=>v::notEmpty()->length(5,10)
				
		];


		$validation = $this->container
						   ->validator
						   ->validate($request,$rules);

		if($validation->failed()){

			return $this->container
						->view
						->render($response,'admin/partials/auth/change_password.twig',['errors'=>$validation->getError()]);
		}

		if(!v::equals($new_password)->validate($confirm_password)){

			$errors['password'] = ["New Password and confirm password must match"];
			
			return $this->container
						->view
						->render($response,'admin/partials/auth/change_password.twig',['errors'=>$errors]);

		}


		if(!password_verify($old_password,$user['password'])){

					$error['password'] = ["Old password is incorrect."];
					
					return $this->container
								->view
								->render($response,'admin/partials/auth/change_password.twig',['errors'=>$error]);
				}
		
		//update password
		$this->container
			 ->user
			 ->updatePassword($user_id,password_hash($request->getParam('new-password'),PASSWORD_DEFAULT));
		
		//set flash message
		$this->container
			 ->flash
			 ->addMessage('success',"Successfully update password!");

		//log out
		$this->container
			 ->auth
			 ->logout();

		//redirect for login
		return $response->withRedirect($this->container->router->pathFor('admin.signin'));


	}


	/**
	 * [getPasswordForgot return password reset request form]
	 * [HTTP request object] $request 
	 * @param  [HTTP response object] $response 
	 * @return [HTML]           [return form for password change]
	 */
	public function getForgotPassword($request,$response){

		return $this->container
					->view
					->render($response,'admin/partials/auth/forgot_password.twig');
	}

	/**
	 * [getPasswordForgot post password forgot request]
	 * [HTTP request object] $request 
	 * @param  [HTTP response object] $response 
	 * @return [HTML]           [redirects to forgot-password form]
	 */
	public function postForgotPassword($request,$response){

		// respect validation rules
		$rules = [

				'recovery-email'	=>v::notEmpty()->email()
				
		];


		$validation = $this->container
						   ->validator
						   ->validate($request,$rules);

		if($validation->failed()){

			return $this->container
						->view
						->render($response,'admin/partials/auth/forgot_password.twig',['errors'=>$validation->getError()]);
		}

		//email
		$recoveryEmail = $request->getParam('recovery-email');
		
		//password reset attributes
		$passwordResetToken	= strtoupper(base64_encode(md5(uniqid('',true))));
		$date 				= new DateTime('NOW');
		$currentDate 		= $date->format('Y-m-d H:i:s');
		$expiryDate 		= $date->add(new DateInterval('PT5H'))->format('Y-m-d H:i:s');


		$passwordResetUrl 	= "com.cms.local/account/reset-password/{$passwordResetToken}";
		$sendgridService 	= new SendGridEmailService();

		//password rest template ---TEMPORARY [USE SENDGRID LATER]
		//
		$html = "<p>Please visit <a href='$passwordResetUrl'>password reset link</a> to reset password</p>";

		$data['from']		= $recoveryEmail; 
		$data['to']			= 'rajesh2045@gmail.com'; 
		$data['subject']	= 'sNC Password Reset';
		$data['message']	= $html; 

		$status = $sendgridService->passwordReset($data);
		
		if($status===202){

			$user = $this->container->user->userExist($recoveryEmail);
			
			if(!empty($user)){

				$userId 		= $user['user_id'];
				$encodedToken 	= $passwordResetToken;
				

				$statement = $this->container
								  ->connection
								  ->prepare("INSERT INTO password_reset(user_id,reset_token,token_expiry,is_valid)
												 		 VALUES(:user_id,:encoded_token,:token_expiry,:is_valid)");
		
				$statement->execute(array("user_id"=>$userId,
									"encoded_token"=> $encodedToken,
									"token_expiry"=>$expiryDate,
									"is_valid"=>1
									 ));

				$this->container
			 		 ->flash
			 		->addMessage('success', 'Please check your email for password reset.');
		
				return $response->withRedirect($this->container->router->pathFor('admin.forgotPassword'));
			} //end user check

		}
	}


	/**
	 * [getResetPassword return password reset form]
	 * [HTTP request object] $request 
	 * @param  [HTTP response object] $response 
	 * @return [HTML]           [return form for password reset]
	 */
	public function getResetPassword($request,$response,$args){

		$passwordResetToken =  $args['passwordResetUrl'];


		
		$statement = $this->container
								  ->connection
								  ->prepare("SELECT * FROM password_reset WHERE reset_token=:password_reset_token AND is_valid = 1 AND token_expiry < NOW()");
								  
								   $statement->execute(array("password_reset_token"=>$passwordResetToken));
								   $st = $statement->fetch(PDO::FETCH_ASSOC);

								  if($st){

								  	return $this->container
						->view
						->render($response,'admin/partials/auth/reset_password.twig');
								  }else{

								  	$this->container
			 		 ->flash
			 		->addMessage('fail', 'Please reset link is invalid, please request a new reset email.');

return $response->withRedirect($this->container->router->pathFor('admin.forgotPassword'));

								  }

		

	}


	public function resetPassword(){

		return $this->container
					->view
					->render($response,'admin/partials/auth/reset_password.twig');
	}

}


?>