<?php 

namespace App\Controllers;
use PDO;
use \App\Models\User as User;

class PageController extends Controller{



	public function index($request,$response){

		$user = $this->container->category;
		$category = $user->findAll();
			
		return $this->container->view->render($response,'home.twig',['category'=>$category,'page'=>"Twig test"]);


	}


}




















 ?>