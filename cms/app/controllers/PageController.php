<?php 

namespace App\Controllers;


use stdClass;
use PDO;
use App\Aws\AmazonService;
use App\Aws\Exceptions\S3Exception;
use App\Services\Paginator as Paginator;
use App\Services\SendGrid\SendgridEmailService;
use Respect\Validation\Validator as v;

use Sendgrid;


class PageController extends Controller{



	/**
	 * [getIndex return homepage
	 * ]
	 * @param  [type] $request  [description]
	 * @param  [type] $response [description]
	 * @return [type]           [description]
	 */
	public function getIndex($request,$response){

		
		$recentPosts = $this->container->post->findRecent();
		
		$featuredPosts = $this->container->post->findFeatured();
		
		$categories = $this->container->category->findAll();
		
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

			
		return $this->container
					->view
					->render($response,'front/partials/index.twig',['categories'=>$newCategories,'recentPosts'=>$p,'featuredPosts'=>$featuredPosts]);


	}




	/**
	 * [getAbout description]
	 * @param  [type] $request  [description]
	 * @param  [type] $response [description]
	 * @return [type]           [description]
	 */
	public function getAbout($request,$response){

		
		$categories = $this->container->category->findAll();
		$newCategories = array();
		foreach($categories as $cat) {
			
			$ct = $cat;
			$cat_title =$cat['cat_title'];
			$ct['url'] = strtolower(str_replace(" ","_",$cat_title));
			array_push($newCategories, $ct);

		}

		return $this->container->view->render($response,'front/partials/about.twig',['categories'=>$newCategories]);

	}

	
	/**
	 * [getContact return contact page]
	 * @param  [type] $request  [description]
	 * @param  [type] $response [description]
	 * @return [type]           [description]
	 */
	public function getContact($request,$response){

	
		$categories = $this->container->category->findAll();
		
		$newCategories = array();
		foreach($categories as $cat) {
			
			$ct = $cat;
			$cat_title =$cat['cat_title'];
			$ct['url'] = strtolower(str_replace(" ","_",$cat_title));
			array_push($newCategories, $ct);

		}

		return $this->container->view->render($response,'front/partials/contact.twig',['categories'=>$newCategories]);

	}


	/**
	 * [getPost get blog post]
	 * @param  [type] $request  [description]
	 * @param  [type] $response [description]
	 * @param  [type] $args     [description]
	 * @return [type]           [description]
	 */
	public function getPost($request,$response,$args){

		$id = $args['id'];

		$post = $this->container->post->find($id);
		
		$featuredPosts = $this->container->post->findFeatured();
		
		$comments = $this->container->comment->findAll($id);
		
		$categories = $this->container->category->findAll();
		
		$newCategories = array();
		foreach($categories as $cat) {
			
			$ct = $cat;
			$cat_title =$cat['cat_title'];
			$ct['url'] = strtolower(str_replace(" ","_",$cat_title));
			array_push($newCategories, $ct);

		}

		return $this->container
					->view
					->render($response,'front/partials/post.twig',['categories'=>$newCategories,'post'=>$post,'featuredPosts'=>$featuredPosts,'comments'=>$comments]);


	}


	/**
	 * [categoryPost get category page]
	 * @param  [type] $request  [description]
	 * @param  [type] $response [description]
	 * @param  [type] $args     [description]
	 * @return [type]           [description]
	 */
	public function categoryPost($request,$response,$args){

		
		$categoryTitle = $args['category'];

		$formattedCategory = strtolower(str_replace("_"," ",$categoryTitle));
		$category_id = $this->container->category->findByTitle($formattedCategory)['cat_id'];

		$featuredPosts = $this->container->post->findFeatured();
		$categories = $this->container->category->findAll();
		
		
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


	/**
	 * [sendMessage send contact message]
	 * @param  [type] $request  [description]
	 * @param  [type] $response [description]
	 * @return [type]           [description]
	 */
	public function sendMessage($request,$response){

	    $rules = [

	      'name'=>v::notEmpty(),
	        'email'=>v::notEmpty(),
	        'message'=>v::notEmpty(),

	    ];


	    $validation =$this->container->validator->validate($request,$rules);
	    
	    if($validation->failed()){
	    	
	    	$this->container
         		 ->flash
         		->addMessage('fail',"Please enter all required fields !");
   
    	 return $response->withRedirect($this->container->router->pathFor('contact'));
	    }


		$data['from'] = $request->getParam('email');
		$data['to'] = "rajesh2045@gmail.com";
		$data['message'] = $request->getParam('message');;
		$data['subject']  ="Blog message from ".$request->getParam('name');
		
		$sendgridService 	= new SendGridEmailService();
		$status = $sendgridService->sendEmail($data);

			
		if($status===202){

			$this->container
				 ->flash
				 ->addMessage('success', 'Thank you for contacting us,we will get back to you soon.');
		}else{

			$this->container
			 		 ->flash
			 		->addMessage('fail', 'Account doesnot exist with email provided.');

		}

		return $response->withRedirect($this->container->router->pathFor('contact'));

}

public function test(){


	$from = new SendGrid\Email(null, "rajesh2045@gmail.com");
$subject = "Hello World from the SendGrid PHP Library!";
$to = new SendGrid\Email(null, "ryandbasnet@gmail.com");
$content = new SendGrid\Content("text/plain", "Hello, Email!");
$mail = new SendGrid\Mail($from, $subject, $to, $content);

$apiKey = getenv('SENDGRID_API_KEY');
$sg = new \SendGrid($apiKey);
    $response = $sg->client->mail()->send()->post($mail);


echo $response->statusCode();
exit;
    return $response->statusCode();
}


}



 ?>