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

		$name= $request->getParam('email');
		return $response->withRedirect($this->container->router->pathFor('admin.dashboard'));
		
			
		//                             return $this->container->view->render($response,'admin/login.twig');


	}





}
















 ?>