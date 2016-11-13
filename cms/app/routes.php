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

$app->get('/manage/login' ,'AuthController:getSignin')->setName('admin.signin')->add(new GuestMiddleware($container));
$app->post('/manage/login' ,'AuthController:postSignin');
$app->get('/manage/signout' ,'AuthController:getSignout')->setName('admin.signout');






/**
 * Admin Routes /Protected Routes
 */

$app->group('/manage',function(){

	$this->get('/' ,'AuthController:getIndex')->setName('admin.dashboard');

	$this->get('/post' ,'PostController:getIndex')->setName('admin.posts');
	$this->get('/post/new' ,'PostController:getpostForm')->setName('admin.newPost');
	$this->post('/post' ,'PostController:getpostForm')->setName('admin.addPost');

	$this->get('/users' ,'UserController:getIndex')->setName('admin.users');
	$this->get('/user/new' ,'UserController:getUserForm')->setName('admin.addUser');
	$this->post('/user' ,'UserController:postUser');
	$this->get('/user/edit/{id}' ,'UserController:editUser')->setName('admin.editUser');
	$this->post('/user/update/{id}' ,'UserController:updateUser');
	$this->get('/user/delete/{id}' ,'UserController:destroyUser');

})->add(new AuthMiddleware($container));



 ?>