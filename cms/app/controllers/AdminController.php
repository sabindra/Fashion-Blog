<?php 

namespace App\Controllers;
use PDO;


class AdminController extends Controller{



	public function index($request,$response){

		// return "Admin";
		// $category = $this->container->category;
		// $categories = $category->findAll();
		// $recentPosts = $this->container->post->findRecent();
		// $featuredPosts = $this->container->post->findFeatured();
			
		return $this->container->view->render($response,'admin/index.twig');


	}






}
















 ?>