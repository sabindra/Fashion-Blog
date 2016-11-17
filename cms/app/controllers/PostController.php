<?php 

namespace App\Controllers;
use PDO;
use Respect\Validation\Validator as v;
use App\Aws\AmazonService;
use App\Aws\Exceptions\S3Exception;

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

	public function postPost($request,$response){



    $rules = [

      'post-title'=>v::notEmpty(),
        'post-content'=>v::notEmpty(),
        'post-tag'=>v::alpha(),

    ];

    $validation =$this->container->validator->validate($request,$rules);

   
    $fileType= ['png','jpeg','jpg',];


    $file['image'] = $_FILES['post-image']['name'];
    $file['size'] = $_FILES['post-image']['size'];

    $imageRules = [ 

       
        'fileType'=>$fileType,
        'fileSize'=>'10000000'


          ];
     
  $validation->validateImage($request,$file,$imageRules);


    

    if($validation->failed()){

      $categories = $this->container->category->findAll();

      return $this->container->view->render($response,'admin/partials/post/add_post.twig',['category'=>$categories,'errors'=>$validation->getError()]);
    
    }


    //upload image
    $fileExt = strtolower(end(explode(".",$file['image'])));
    $imageName = md5(uniqid())."_".date("d-m-y").".".$fileExt;
    $image_temp = $_FILES['post-image']['tmp_name'];

    $tempLocation=__DIR__."/../../resources/tmp_image/$imageName";
    move_uploaded_file($image_temp,$tempLocation);
    $a = new AmazonService();
  $awsClient = $a->getAWS();
     try {
      
      $handle = fopen($tempLocation, 'rb');
      $awsClient->putObject([

        'Bucket'=>getenv('AWS_BUCKET'),
        'Key'=>"post_images/{$imageName}",
        'Body'=>$handle,
        'ACL'=>'public-read'
        ]);

      fclose($handle);
      unlink($tempLocation);


     } catch (S3Exception $e) {
      
      $error = ['image'=>['Sorry, image could not be uploaded.'] ];
       return $this->container->view->render($response,'admin/partials/post/add_post.twig',['category'=>$categories,'errors'=>$error]);
     }

    $user = $this->container->auth->user();
    $data =array();
    $data['title'] = $request->getParam('post-title');
    $data['content'] = $request->getParam('post-content');
    $data['image_path'] = $imageName;
    $data['tags'] = $request->getParam('post-tag');
    $data['status'] = $request->getParam('post-status');
    $data['author'] = $user['first_name'];
    $data['cat_id'] = $request->getParam('category');

   
    $post = $this->container->post->create($data);
    

  $this->container->flash->addMessage('success',"post added successfully !");
   


    
     return $response->withRedirect($this->container->router->pathFor('admin.addPost'));




}

public function editPost($request,$response,$args){

  $post_id = $args['id'];
  $categories = $this->container->category->findAll();

  $post_id = $args['id'];

  // $this->container->get()

  



}

/**
   * [getUserForm description]
   * [HTTP request object] $request 
   * @param  [HTTP response object] $response 
   * @return [type]           [description]
   */
  public function destroyPost($request,$response,$args){

    $post_id = $args['id'];
    $this->container->post->delete($post_id);
    $this->container->flash->addMessage('success',"post Deleted successfully !");
    return $response->withRedirect($this->container->router->pathFor('admin.posts'));


  }


	}





















 ?>