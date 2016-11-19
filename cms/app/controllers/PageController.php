<?php 

namespace App\Controllers;
use PDO;
use App\Aws\AmazonService;
use App\Aws\Exceptions\S3Exception;
use App\Services\SendGrid\SendgridEmailService as SES;


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

	public function sendMessage(){

			$data['from'] = "rajesh2045@gmail.com";
			$data['to'] = "soniyaacharya38@gmail.com";
			$data['message'] = "Hello send grid";
			$data['subject']  ="Enquire test";
		$sendgridService = new SES();
		$sendgridService->sendEmail($data);

		
	}










public function  test1($request,$response){
	$id = uniqid('',TRUE);

	echo "ID :" .$id;
	echo "<br>";
	$eid = base64_encode($id);
	echo "Encode :". $eid;
	echo "<br>";
	echo "Decode :".base64_decode($eid);
	echo "<br>";
	// echo base64_encode($eid);

	exit;
}

public function  test2($request,$response){

	$a = new AmazonService();
	$awsClient = $a->getAWS();
	
	if(!empty($_FILES['post-image']['name'])){


	$image = $_FILES['post-image']['name'];
    $image_size = $_FILES['post-image']['size'];
    $image_temp = $_FILES['post-image']['tmp_name'];
    $imageType= ['PNG','JPEG','JPG',];
     $fileExt = strtolower(end(explode(".",$image)));
      
    


    if(!in_array(strtoupper(pathinfo($image,PATHINFO_EXTENSION)),$imageType)){

      $imageError ="Please upload valid image file.";
      echo $imageError;

      exit;

    }else{


	$fileName = md5(uniqid())."_".date("d-m-y").".".$fileExt;
      
     $imageLocation=__DIR__."/../../resources/tmp_image/$fileName";
     // temp file storage
     move_uploaded_file($image_temp,$imageLocation);
     echo $fileName;

     try {
     	$handle = fopen($imageLocation, 'rb');
$awsClient->putObject([

	'Bucket'=>getenv('AWS_BUCKET'),
	'Key'=>"post_images/{$fileName}",
	'Body'=>$handle,
	'ACL'=>'public-read'
	]);

fclose($handle);
unlink($imageLocation);


     	
     } catch (S3Exception $e) {
     	
     	var_dump($e);
     	exit;
     }
		}
	}else{

		echo "file is not uploaded";
		exit;
	}
}

}








 ?>