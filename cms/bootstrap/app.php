<?php

/**
 * @Author: Ryan Basnet
 * @Date:   2016-11-07 09:33:39
 * @Last Modified by:   Rajesh Basnet
 * @Last Modified time: 2016-11-08 09:23:29
 */



require __DIR__ . '/../vendor/autoload.php';


/** Test */







/**
 * Configuration
 */

$config['displayErrorDetails'] = true;
$config['db'] = require __DIR__ . '/../config/db.php';

/**
 * Slim app instantiation
 * 
 */
$app = new \Slim\App($config);


/**
 * Dependency Injection Container
 */

$container = $app->getContainer();

/**
 * Database Conection Setup
 */



$container['connection'] = function($container) use($config){


	try {
		
		$connection = new PDO('mysql:host=localhost;dbname='.$config['db']['db_name'], $config['db']['user'], $config['db']['pass']);
		// $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		
		

		} catch (PDOException $e) {

			echo "Error!: " , $e->getMessage() , "<br/>";
				 die();
		}

	return $connection;

};







/**
 * Views Setup
 */

$container['view'] = function ($container){


	$view = new \Slim\Views\Twig(__DIR__ . '/../resources/views',[

		'cache' => false,

		]);

	// Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

	return $view;
};

/**
 * Controller Registration
 */


$container['PageController'] = function($container){

	return new \App\Controllers\PageController($container);
};



/**
 * Model Registration
 */

$container['category'] = function($container){

	$connection = $container->connection;

	return new \App\Models\Category($connection);
};





/**
 * Routes
 */

require __DIR__ .'/../app/routes.php';


?>