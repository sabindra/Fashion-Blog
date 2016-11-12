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



}
















 ?>