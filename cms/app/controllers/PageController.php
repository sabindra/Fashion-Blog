<?php 

namespace App\Controllers;
use PDO;


class PageController extends Controller{



	public function index($request,$response){

		$category = $this->container->category;
		$categories = $category->findAll();
		$recentPosts = $this->container->post->findRecent();
		$featuredPosts = $this->container->post->findFeatured();
			
		return $this->container->view->render($response,'front/index.twig',['categories'=>$categories,'recentPosts'=>$recentPosts,'featuredPosts'=>$featuredPosts]);


	}





	public function about($request,$response){}

	
	public function contact($request,$response){}

	public function post($request,$response,$args){

		$id = $args['id'];
		$post = $this->container->post->find($id);
		$featuredPosts = $this->container->post->findFeatured();
		$categories = $this->container->category->findAll();
		
		return $this->container->view->render($response,'front/post.twig',['categories'=>$categories,'post'=>$post,'featuredPosts'=>$featuredPosts]);


	}



}
















 ?>