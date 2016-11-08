<?php 

namespace App\Controllers;
use PDO;


class UserController extends Controller{



	public function getIndex($request,$response){

		$posts = $this->container->post;
		$posts = $posts->findAll();

		return $this->container->view->render($response,'admin/partials/post/view_all_post.twig',['posts'=>$posts]);


	}


	public function getUserForm($request,$response){

		
		return $this->container->view->render($response,'admin/partials/user/add_user.twig');


	}

		public function postUser($request,$response){

		$name= $request->getParam('last-name');
		return $name;
		return $this->container->view->render($response,'admin/partials/user/add_user.twig');


	}







}

















 ?>