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

		$categories = $this->container->category->findAll();
		return $this->container->view->render($response,'admin/partials/post/add_post.twig',['category'=>$categories]);


	}

	public function addPost($request,$response){

		// var_dump($request->getParams());
		if($_FILES['post_image']['name']){

     $image = $_FILES['post_image']['name'];
    $image_size = $_FILES['post_image']['size'];
    $image_temp = $_FILES['post_image']['tmp_name'];

    $imageType= ['PNG','JPEG','JPG',];
     $fileExt = end(explode(".",$image));
      $fileName = uniqid()."_".date("d-m-y").".".$fileExt;
      
     $imageLocation=__DIR__."/../../public/post_images/$fileName";
    


    if(!in_array(strtoupper(pathinfo($image,PATHINFO_EXTENSION)),$imageType)){

      $imageError ="Please upload valid image file.";

    }else{

     

      $copyFile =  move_uploaded_file($image_temp,$imageLocation);

      if(!$copyFile){

      $imageError="Could not upload image";
      echo $_FILES["post_image"]["error"];
      

      }

  


    }

}


	}






}

















 ?>