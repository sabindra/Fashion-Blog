<?php 


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
 * Aduth Routes
 */

$app->get('/manage/login' ,'AuthController:getSignIn');
$app->post('/manage/login' ,'AuthController:postSignIn');






/**
 * Admin Routes
 */

$app->get('/manage' ,'AuthController:getIndex')->setName('admin.dashboard');
$app->get('/manage/post' ,'PostController:getIndex');
$app->get('/manage/post/new' ,'PostController:getpostForm');


$app->get('/manage/user/new' ,'UserController:getUserForm');
$app->post('/manage/user' ,'UserController:postUser');


 ?>