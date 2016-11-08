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





	public function about($request,$response){

		$categories = $this->container->category->findAll();

		return $this->container->view->render($response,'front/about.twig',['categories'=>$categories]);

	}

	
	public function contact($request,$response){

		$categories = $this->container->category->findAll();

		return $this->container->view->render($response,'front/contact.twig',['categories'=>$categories]);

	}

	public function post($request,$response,$args){

		$id = $args['id'];
		$post = $this->container->post->find($id);
		$featuredPosts = $this->container->post->findFeatured();
		$categories = $this->container->category->findAll();

		return $this->container->view->render($response,'front/post.twig',['categories'=>$categories,'post'=>$post,'featuredPosts'=>$featuredPosts]);


	}

	public function caegory($request,$response,$args){

		$category = $args['category'];
		// $post = $this->container->post->find($id);
		// $featuredPosts = $this->container->post->findFeatured();
		// $categories = $this->container->category->findAll();
		
		// return $this->container->view->render($response,'front/post.twig',['categories'=>$categories,'post'=>$post,'featuredPosts'=>$featuredPosts]);
		return $category;

	}



}
















 ?>