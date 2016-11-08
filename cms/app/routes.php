<?php 


/**
 * Page Routes
 */
$app->get('/' ,'PageController:index');
$app->get('/post/{id}' ,'PageController:post');
// $app->get('/post/{category}'PageController:post'');

 ?>