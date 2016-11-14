<?php 

namespace App\Controllers;
use PDO;


class PageController extends Controller{



	public function getIndex($request,$response){

		
		$recentPosts = $this->container->post->findRecent();
		$featuredPosts = $this->container->post->findFeatured();
		$category = $this->container->category;
		$categories = $category->findAll();
		$newCategories = array();
		foreach($categories as $cat) {
			$ct = $cat;
			$cat_title =$cat['cat_title'];
			$ct['url'] = strtolower(str_replace(" ","_",$cat_title));
			array_push($newCategories, $ct);

		}

			
		return $this->container->view->render($response,'front/partials/index.twig',['categories'=>$newCategories,'recentPosts'=>$recentPosts,'featuredPosts'=>$featuredPosts]);


	}





	public function getAbout($request,$response){

		$categories = $this->container->category->findAll();

		return $this->container->view->render($response,'front/partials/about.twig',['categories'=>$categories]);

	}

	
	public function getContact($request,$response){

		$categories = $this->container->category->findAll();

		return $this->container->view->render($response,'front/partials/contact.twig',['categories'=>$categories]);

	}

	public function getPost($request,$response,$args){

		$id = $args['id'];
		$post = $this->container->post->find($id);
		$featuredPosts = $this->container->post->findFeatured();
		$comments = $this->container->comment->findAll($id);
		$category = $this->container->category;
		$categories = $category->findAll();
		$newCategories = array();
		foreach($categories as $cat) {
			$ct = $cat;
			$cat_title =$cat['cat_title'];
			$ct['url'] = strtolower(str_replace(" ","_",$cat_title));
			array_push($newCategories, $ct);
		}

		return $this->container->view->render($response,'front/partials/post.twig',['categories'=>$newCategories,'post'=>$post,'featuredPosts'=>$featuredPosts,'comments'=>$comments]);


	}

	public function categoryPost($request,$response,$args){

		
		$categoryTitle = $args['category'];
		$formattedCategory = strtolower(str_replace("_"," ",$categoryTitle));
		$category_id = $this->container->category->findByTitle($formattedCategory)['cat_id'];
		$posts = $this->container->post->findByCategory($category_id);
		$featuredPosts = $this->container->post->findFeatured();
		$categories = $this->container->category->findAll();
		$newCategories = array();
		foreach($categories as $cat) {
			$ct = $cat;
			$cat_title =$cat['cat_title'];
			$ct['url'] = strtolower(str_replace(" ","_",$cat_title));
			array_push($newCategories, $ct);

		}
		// var_dump($category_id);
		// var_dump($posts);
		// exit;
		// $categories = $this->container->category->findAll();
		
		return $this->container->view->render($response,'front/partials/category.twig',['categories'=>$newCategories,'posts'=>$posts,'featuredPosts'=>$featuredPosts]);
		

	}



}
















 ?>