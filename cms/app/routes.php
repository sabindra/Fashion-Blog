<?php 

use \App\Middleware\GuestMiddleware;
use \App\Middleware\AuthMiddleware;

/**
 * Page Routes
 */

$app->get('/' ,'PageController:getIndex')->setName('home');
$app->get('/about' ,'PageController:getAbout')->setName('about');;
$app->get('/contact' ,'PageController:getContact')->setName('contact');;

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

	$this->get('/' ,'UserController:getIndex')->setName('admin.dashboard');

	/** post **/
	$this->get('/posts','PostController:getIndex')->setName('admin.posts');
	$this->get('/post/new','PostController:getpostForm')->setName('admin.addPost');
	$this->post('/post','PostController:addPost')->setName('admin.postPost');


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
	

	

})->add(new AuthMiddleware($container));



 ?>