<?php 

namespace App\Controllers;
use PDO;


class PostController extends Controller{



	public function getIndex($request,$response){

		$posts = $this->container->post;
		$posts = $posts->findAll();

		return $this->container->view->render($response,'admin/partials/post/view_all_post.twig',['posts'=>$posts]);


	}


	public function getPostForm($request,$response){

		
		return $this->container->view->render($response,'admin/partials/post/add_post.twig');


	}






}

















 ?>