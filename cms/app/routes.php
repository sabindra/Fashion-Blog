<?php 


/**
 * Page Routes
 */

$app->get('/' ,'PageController:index');
$app->get('/about' ,'PageController:about');
$app->get('/contact' ,'PageController:contact');
// $app->get('/{category}' ,'PageController:category');
$app->get('/post/{id}' ,'PageController:post');

// $app->get('/admin' ,'PageController:index');


/**
 * Admin Routes
 */
$app->get('/manage' ,'AdminController:index');


 ?>