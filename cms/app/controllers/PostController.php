<?php 

namespace App\Controllers;
use PDO;
use Respect\Validation\Validator as v;
use App\Aws\AmazonService;
use App\Aws\Exceptions\S3Exception;


class PostController extends Controller{



	public function getIndex($request,$response){

    $role_id = $this->container->auth->user()['role_id'];
    $user_id = $this->container->auth->user()['user'];
    $post = $this->container->post;
    if($role_id!=1){

      $posts = $post->where('author',$user_id);

    }
    else{

      $posts = $posts->findAll();
    }

		
		

		return $this->container->view->render($response,'admin/partials/post/view_all_post.twig',['posts'=>$posts]);


	}


	public function getPostForm($request,$response){

		$categories = $this->container->category->findAll();
    
		return $this->container->view->render($response,'admin/partials/post/add_post.twig',['category'=>$categories]);


	}

	public function postPost($request,$response){

    // var_dump($request->getParams());
    // exit;



    $rules = [

      'post_title'=>v::notEmpty(),
        'post_content'=>v::notEmpty(),
        'post_tag'=>v::alpha(),

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
    $data['title'] = $request->getParam('post_title');
    $data['content'] = $request->getParam('post_content');
    $data['image_path'] = $imageName;
    $data['tags'] = $request->getParam('post_tag');
    $data['status'] = $request->getParam('post-status');
    $data['author'] = $user['user'];
    $data['cat_id'] = $request->getParam('category');

   
    $post = $this->container->post->create($data);
    

  $this->container->flash->addMessage('success',"post added successfully !");
   


    
     return $response->withRedirect($this->container->router->pathFor('admin.addPost'));




}

public function editPost($request,$response,$args){




  
  $post_id = $args['id'];
  $categories = $this->container->category->findAll();
   $post= $this->container->post->find($post_id);

   $current_user_id= $this->container->auth->user()['user'];
   $post_user_id = $post['author'];
   if($post_user_id!=$current_user_id){
$this->container->flash->addMessage('fail',"Not authorize to perform action !");
 return $response->withRedirect($this->container->router->pathFor('admin.posts'));

   }
return $this->container->view->render($response,'admin/partials/post/edit_post.twig',['category'=>$categories,'post'=>$post]);


}

public function updatePost($request,$response,$args){

  $post_id = $args['id'];
   $categories = $this->container->category->findAll();
  $rules = [

      'post_title'=>v::notEmpty(),
        'post_content'=>v::notEmpty(),
        'post_tag'=>v::alpha(),

    ];


$validation= $this->container->validator->validate($request,$rules);
if($validation->failed()){

  $this->container->flash->addMessage('fail',"Please enter all required field !");
 return $response->withRedirect($this->container->router->pathFor('admin.editPost',['id'=>$post_id]));
}


  $data = array();
  $data['title'] = $request->getParam('post_title');
    $data['content'] = $request->getParam('post_content');
   
    $data['tags'] = $request->getParam('post_tag');
    $data['status'] = $request->getParam('post_status');
    $data['cat_id'] = $request->getParam('category');

  $post= $this->container->post->update($post_id,$data);
$this->container->flash->addMessage('success',"post Deleted successfully !");
 return $response->withRedirect($this->container->router->pathFor('admin.posts'));
  



}


/**
   * [getUserForm description]
   * [HTTP request object] $request 
   * @param  [HTTP response object] $response 
   * @return [type]           [description]
   */
  public function destroyPost($request,$response,$args){

    $post_id = $args['id'];
    $post= $this->container->post->find($post_id);

     $current_user_id= $this->container->auth->user()['user'];
   $post_user_id = $post['author'];
   if($post_user_id!=$current_user_id){
$this->container->flash->addMessage('fail',"Not authorize to perform action !");
 return $response->withRedirect($this->container->router->pathFor('admin.posts'));

   }
    $this->container->post->delete($post_id);
    $this->container->flash->addMessage('success',"post Deleted successfully !");
    return $response->withRedirect($this->container->router->pathFor('admin.posts'));


  }


	}





















 ?>