<?php 

use \App\Middleware\GuestMiddleware;
use \App\Middleware\AuthMiddleware;

/**
 * Page Routes
 */

$app->get('/' ,'PageController:getIndex');
$app->get('/about' ,'PageController:getAbout');
$app->get('/contact' ,'PageController:getContact');
// $app->get('/{category}' ,'PageController:category');
$app->get('/post/{id}' ,'PageController:getPost');

// $app->get('/admin' ,'PageController:index');


/**
 * Auth Routes
 */

$app->get('/manage/login' ,'AuthController:getSignin')->setName('user.signin')->add(new GuestMiddleware($container));
$app->post('/manage/login' ,'AuthController:postSignin');
$app->get('/manage/signout' ,'AuthController:getSignout')->setName('user.signout');






/**
 * Admin Routes /Protected Routes
 */

$app->group('/manage',function(){

	$this->get('/' ,'AuthController:getIndex')->setName('admin.dashboard');

	/** post **/
	$this->get('/posts','PostController:getIndex')->setName('admin.posts');
	$this->get('/post/new','PostController:getpostForm')->setName('admin.newPost');
	$this->post('/post','PostController:getpostForm')->setName('admin.addPost');


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
	$this->get('/user/profile/changepassword','UserController:getChangePassword')->setName('user.changePassword');
	$this->post('/user/profile/changepassword','UserController:ChangePassword')->setName('user.updatePassword');


	

})->add(new AuthMiddleware($container));



 ?>