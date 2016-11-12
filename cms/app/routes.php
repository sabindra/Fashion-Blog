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
 * Admin Routes
 */

$app->get('/manage' ,'AuthController:getIndex')->setName('admin.dashboard')->add(new AuthMiddleware($container));
$app->get('/manage/post' ,'PostController:getIndex');
$app->get('/manage/post/new' ,'PostController:getpostForm');


$app->get('/manage/user/new' ,'UserController:getUserForm')->setName('admin.signup');
$app->post('/manage/user' ,'UserController:postUser')->setName('admin.signup');


 ?>