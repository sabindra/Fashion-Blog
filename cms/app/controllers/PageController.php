<?php 

namespace App\Controllers;
use PDO;
use stdClass;
use App\Aws\AmazonService;
use App\Aws\Exceptions\S3Exception;
use App\Services\SendGrid\SendgridEmailService as SES;
use App\Services\Paginator as Paginator;


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


			$page =$request->getParam('page');
			$paginator =  new Paginator($this->container->connection);
			$paginator->setQuery("SELECT * FROM posts WHERE status = 'published' ORDER BY post_id DESC");
			$results = $paginator->paginate(3,$page);
			$p = $results->data;

			
		return $this->container->view->render($response,'front/partials/index.twig',['categories'=>$newCategories,'recentPosts'=>$p,'featuredPosts'=>$featuredPosts]);


	}





	public function getAbout($request,$response){

		$category = $this->container->category;
		$categories = $category->findAll();
		$newCategories = array();
		foreach($categories as $cat) {
			$ct = $cat;
			$cat_title =$cat['cat_title'];
			$ct['url'] = strtolower(str_replace(" ","_",$cat_title));
			array_push($newCategories, $ct);

		}

		return $this->container->view->render($response,'front/partials/about.twig',['categories'=>$newCategories]);

	}

	
	public function getContact($request,$response){

	
		$category = $this->container->category;
		$categories = $category->findAll();
		$newCategories = array();
		foreach($categories as $cat) {
			$ct = $cat;
			$cat_title =$cat['cat_title'];
			$ct['url'] = strtolower(str_replace(" ","_",$cat_title));
			array_push($newCategories, $ct);

		}

		return $this->container->view->render($response,'front/partials/contact.twig',['categories'=>$newCategories]);

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

		$featuredPosts = $this->container->post->findFeatured();
		$categories = $this->container->category->findAll();
		// $posts = $this->container->post->findByCategory($category_id);
		
		$newCategories = array();
		
		foreach($categories as $cat) {
			$ct = $cat;
			$cat_title =$cat['cat_title'];
			$ct['url'] = strtolower(str_replace(" ","_",$cat_title));
			array_push($newCategories, $ct);
		}
		


		$page =$request->getParam('page');
		
		$paginator =  new Paginator($this->container->connection);
		$paginator->setQuery("SELECT * FROM posts WHERE cat_id=$category_id AND status = 'published'");
		$results = $paginator->paginate(2,$page);
		$posts = $results->data;
		
		$paginationLinks=(array)$paginator->paginationLinks("/post/category/$categoryTitle","pagination-btn");
	
		
		return $this->container->view->render($response,'front/partials/category.twig',['categories'=>$newCategories,'posts'=>$posts,'featuredPosts'=>$featuredPosts,'paginationLinks'=>$paginationLinks]);
		

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









public function  test3($request,$response,$args){

	$cat = $args['cat'];
	$page =$request->getParam('page');
	$paginator =  new Paginator($this->container->connection);
	$paginator->setQuery("SELECT * FROM posts WHERE status = 'published'");
	$results = $paginator->paginate(3,$page);
	$paginator->paginationLinks("/pagi/$cat");
	exit;

	// //initial setup
	// $perPage = 6;

	// //get page from request
	// $pageNum = (int)$request->getParam('page');
	// $pageNum = (!empty($pageNum) && $pageNum >= 1 )?$pageNum:1;

	// //get total pages
	// $totalItem = $this->container->post->where('cat_id','4');
	// $pages = ceil(count($totalItem)/$perPage);

	// //reset page num if invalid
	// $pageNum =($pages>=$pageNum)?$pageNum : $pages;
	// $start = ($pageNum-1)*$perPage;

	// $paginate = $this->container->post->paginate($start,$perPage);

	// echo 'Total Items :'.count($totalItem);
	// echo "<br>";
	
	// echo 'total pages :'.$pages;
	// echo "<br>";
	// echo 'page Num :'.$pageNum;
	// 	echo "<br>";
	// // echo count($totalItem);
	// // var_dump( $paginate);
	// foreach ($paginate as $v) {
	// 	echo $v['post_id'];
	// 		echo "<br>";
	// }
	// exit;


	// exit;
	// 
	
}


}






 ?>