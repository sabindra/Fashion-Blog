<?php 

namespace App\Controllers;
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


		//input validation
		if(empty($email)){

			$error['email'] = "Please enter email.";
			
		}else{

			if(!filter_var($email,FILTER_VALIDATE_EMAIL)){

			$error['email'] = "Please enter valid email.";

			}
		}

		if(empty($password)){

			$error['password'] = "Please enter password.";
		}
		 
		if(!empty($error)){
			
			
			$this->container->flash->addMessage('failed',"Sorry Could not signed in");
			
			// return $response->withRedirect($this->container->router->pathFor('admin.signIn',['error'=>$error]));
			return $this->container->view->render($response,'admin/login.twig',['error'=>$error]);

		}

		

		return $response->withRedirect($this->container->router->pathFor('admin.dashboard'));
		
			
		//                             return $this->container->view->render($response,'admin/login.twig');


	}





}
















 ?>