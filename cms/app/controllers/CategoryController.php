<?php 

namespace App\Controllers;
use PDO;


class CategoryController extends Controller{



	public function index($request,$response){

		$category = $this->container->category->findAll();

		return $this->container->view->render($response,'admin/partials/category/view_all_post.twig',['posts'=>$posts]);


	}


	public function post($request,$response){

		
		return $this->container->view->render($response,'admin/partials/post/add_post.twig');


	}






}

















 ?>