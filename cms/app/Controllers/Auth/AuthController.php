<?php 

namespace App\Controllers\Auth;


use App\Controllers\Controller;
use Respect\Validation\Validator as v;
use PDO;


class AuthController extends Controller{


	/**
	 * [getIndex description]
	 * @param  [type] $request  [description]
	 * @param  [type] $response [description]
	 * @return [type]           [description]
	 */
	public function getIndex($request,$response){

			
		return $this->container->view->render($response,'admin/index_admin.twig');
	}


	/**
	 * [getSignIn returns login view]
	 * @param  [HTTP request object] $request 
	 * @param  [HTTP response object] $response 
	 * @return [HTML] [return login form]
	 */
	public function getSignin($request,$response){
		
		return $this->container->view->render($response,'admin/login.twig');


	}


	/**
	 * [postSignin returns dashboard/redirect login view]
	 * @param  [HTTP request object] $request 
	 * @param  [HTTP response object] $response 
	 * @return [HTML] [return dashboard or redirect to login view]
	 */
	public function postSignin($request,$response){

		//sanitizing input data
		$email= filter_var($request->getParam('email'),FILTER_SANITIZE_EMAIL);
		$password= filter_var($request->getParam('password'),FILTER_SANITIZE_STRING);
		

		// rules for respect validation
		$rules = [

				'email'=>v::notEmpty()->email(),
				'password'=>v::notEmpty(),
				
		];

		// @see Validation\Validator
		$validation = $this->container->validator->validate($request,$rules);
		if($validation->failed()){
			
			$error= $validation->getError();
			return $this->container->view->render($response,'admin/login.twig',['error'=>$error]);
			
		}

	
		$auth= $this->container->auth->attempt($email,$password);
				
		if(!$auth){

			$this->container->flash->addMessage('success',"Sorry Could not signed in");
			return $response->withRedirect($this->container->router->pathFor('admin.signin'));
		}

		$user_name = $this->container->auth->user()['first_name'];
		$this->container->flash->addMessage('success',"Welcome $user_name");
		return $response->withRedirect($this->container->router->pathFor('admin.dashboard'));
	}


	/**
	 * [getSignout logs user out and redirect to  login view]
	 * @param  [HTTP request object] $request 
	 * @param  [HTTP response object] $response 
	 * @return [HTML] [ redirect to login view]
	 */
	public function getSignout($request,$response){

		// @see Auth\Auth
		$this->container->auth->logout();
		return $response->withRedirect($this->container->router->pathFor('admin.signin'));
	}






/**
	 * [getUserForm description]
	 * [HTTP request object] $request 
	 * @param  [HTTP response object] $response 
	 * @return [type]           [description]
	 */
	public function getChangePassword($request,$response){

		
		return $this->container->view->render($response,'admin/partials/auth/password_change.twig');


	}


	/**
	 * [getUserForm description]
	 * [HTTP request object] $request 
	 * @param  [HTTP response object] $response 
	 * @return [type]           [description]
	 */
	public function changePassword($request,$response){

		$user_id = $this->container->auth->user()['user'];
		$user = $this->container->user->find($user_id);
		$old_password = $request->getParam('old-password');
		$new_password=$request->getParam('new-password');
		$confirm_password = $request->getParam('confirm-password');

				// respect validation rules
		$rules = [

				'old-password'=>v::notEmpty()->length(5,10),
				'new-password'=>v::notEmpty()->length(5,10),
				'confirm-password'=>v::notEmpty()->length(5,10)
				
		];


		$validation = $this->container->validator->validate($request,$rules);

		if($validation->failed()){

		return $this->container->view->render($response,'admin/partials/auth/password_change.twig',['errors'=>$validation->getError()]);
		}

		if(!v::equals($new_password)->validate($confirm_password)){

			$error['password'] = ["New Password and confirm password must match"];
			return $this->container->view->render($response,'admin/partials/auth/password_change.twig',['errors'=>$error]);

		}


		if(!password_verify($old_password,$user['password'])){

					$error['password'] = ["Old password is incorrect."];
					return $this->container->view->render($response,'admin/partials/auth/password_change.twig',['errors'=>$error]);
				}
		

		$this->container->user->updatePassword($user_id,password_hash($request->getParam('new-password'),PASSWORD_DEFAULT));
		$this->container->flash->addMessage('success',"Successfully update password!");
		$this->container->auth->logout();
		return $response->withRedirect($this->container->router->pathFor('admin.signin'));


	}







}







 ?>