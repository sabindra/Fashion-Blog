<?php 

use \App\Middleware\GuestMiddleware;
use \App\Middleware\AuthMiddleware;

/**
 * Page Routes
 */
$app->get('/t' ,function($request,$response){

	return phpInfo();
})->setName('home');
$app->get('/' ,'PageController:getIndex')->setName('home');
$app->get('/about' ,'PageController:getAbout')->setName('about');;
$app->get('/contact' ,'PageController:getContact')->setName('contact');
$app->post('/contact' ,'PageController:sendMessage');
$app->get('/test1' ,'PageController:test1');
$app->post('/test2' ,'PageController:test2');

$app->get('/post/{id}' ,'PageController:getPost')->setName('post.getPost');
$app->post('/post/{id}/comment','CommentController:postComment')->setName('admin.postComment');
$app->get('/post/category/{category}' ,'PageController:categoryPost')->setName('admin.postComment');

// $app->get('/admin' ,'PageController:index');


/**
 * Auth Routes
 */

$app->get('/manage/login' ,'AuthController:getSignin')->setName('admin.signin')->add(new GuestMiddleware($container));
$app->post('/manage/login' ,'AuthController:postSignin');
$app->get('/manage/signout' ,'AuthController:getSignout')->setName('admin.signout');






/**
 * Admin Routes /Protected Routes
 */

$app->group('/manage',function(){

	$this->get('/' ,'AuthController:getIndex')->setName('admin.dashboard');


	/** category */
	$this->get('/category','CategoryController:getIndex')->setName('admin.category');
	$this->post('/category','CategoryController:addCategory')->setName('admin.addCategory');
	$this->get('/category/{id}/delete','CategoryController:destroyCategory')->setName('admin.deleteCategory');
	$this->get('/category/{id}/edit','CategoryController:editCategory')->setName('admin.editCategory');
	$this->post('/category/{id}','CategoryController:updateCategory')->setName('admin.updateCategory');


	/** post **/
	$this->get('/posts','PostController:getIndex')->setName('admin.posts');
	$this->get('/post/new','PostController:getpostForm')->setName('admin.addPost');
	$this->post('/post','PostController:postPost')->setName('admin.postPost');
	$this->get('/post/{id}/edit','PostController:editPost')->setName('admin.editPost');
	$this->post('/post/{id}/update','PostController:updatePost')->setName('admin.editPost');
	$this->get('/post/{id}/delete','PostController:destroyPost');


	/** user **/
	$this->get('/users','UserController:getIndex')->setName('admin.users');
	$this->get('/user/new','UserController:getUserForm')->setName('admin.addUser');
	$this->post('/user','UserController:postUser')->setName('admin.postUser');;
	$this->get('/user/{id}/edit','UserController:editUser')->setName('admin.editUser');
	$this->post('/user/{id}/update','UserController:updateUser');
	$this->get('/user/{id}/delete','UserController:destroyUser');
	

	/** profile **/
	$this->get('/user/profile','UserController:getProfile')->setName('user.profile');
	$this->post('/user/profile','UserController:updateProfile')->setName('user.updateProfile');
	$this->get('/user/profile/changepassword','AuthController:getChangePassword')->setName('user.changePassword');
	$this->post('/user/profile/changepassword','AuthController:ChangePassword')->setName('user.updatePassword');


	/** comments  **/
	$this->get('/comments','CommentController:getIndex')->setName('admin.comments');
	$this->get('/comment/{comment_id}/approve','CommentController:approveComment');
	$this->get('/comment/{comment_id}/unapprove','CommentController:unapproveComment');
	$this->get('/comment/{comment_id}/delete','CommentController:deleteComment');
	

	

})->add(new AuthMiddleware($container));



 ?>