<?php 

namespace App\Controllers;
use PDO;

class PageController extends BaseController{



	public function index($request,$response){


		
		$query = $this->container->connection->prepare("SELECT * FROM categories");
	$query->execute();


			$categories = $query->fetchAll(PDO::FETCH_ASSOC);
			foreach	($categories as $item){

			$category[] = $item;
			}
			sort($category);
			
			
		return $this->container->view->render($response,'home.twig',['category'=>$category,'page'=>"Twig test"]);


	}


}




















 ?>