<?php 

namespace App\Controllers\Auth;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;
use PDO;


class AuthController extends Controller{



	public function getIndex($request,$response){

			
		return $this->container->view->render($response,'admin/index_admin.twig');


	}



	public function getSignIn($request,$response){
		
		return $this->container->view->render($response,'admin/login.twig');


	}



	public function postSignIn($request,$response){

		$email= filter_var($request->getParam('email'),FILTER_SANITIZE_EMAIL);
		$password= filter_var($request->getParam('password'),FILTER_SANITIZE_STRING);
		$error = array();


		$rules = [

				'email'=>v::notEmpty()->email(),
				'password'=>v::notEmpty(),
				
		];
		// $this->container->validator->t();
		$validation = $this->container->validator->validate($request,$rules);
		// var_dump($validation->getError());
		// exit;
		if($validation->failed()){
			$this->container->view->render($response,'admin/login.twig',['error'=>$validation->getError()]);
			
		}
		// //input validation
		// if(empty($email)){

		// 	$error['email'] = "Please enter email.";
			
		// }else{

		// 	if(!filter_var($email,FILTER_VALIDATE_EMAIL)){

		// 	$error['email'] = "Please enter valid email.";

		// 	}
		// }

		// if(empty($password)){

		// 	$error['password'] = "Please enter password.";
		// }
		 
		// if(!empty($error)){
			
			
			
		// 	// return $response->withRedirect($this->container->router->pathFor('admin.signIn',['error'=>$error]));
		// 	return $this->container->view->render($response,'admin/login.twig',['error'=>$error]);

		// }

		


				$auth= $this->container->auth->attempt($email,$password);
				

				if(!$auth){

					$this->container->flash->addMessage('fail',"Sorry Could not signed in");
			
					return $response->withRedirect($this->container->router->pathFor('admin.signIn'));
				}

				$this->container->flash->addMessage('success',"Welcome Rajesh");
				return $response->withRedirect($this->container->router->pathFor('admin.dashboard'));

		

	
		
			
		//                             return $this->container->view->render($response,'admin/login.twig');


	}





}
















 ?>