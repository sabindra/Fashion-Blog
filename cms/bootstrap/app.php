<?php

/**
 * @Author: Ryan Basnet
 * @Date:   2016-11-07 09:33:39
 * @Last Modified by:   Ryan Basnet
 * @Last Modified time: 2016-11-13 11:38:46
 */

session_start();

require __DIR__ . '/../vendor/autoload.php';


/** Test */







/**
 * Configuration
 */

$config['settings']['displayErrorDetails'] = true;
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
 * Service Provider Registration
 */

/** Flash Message */
$container['flash'] = function ($container){

	return new \Slim\Flash\Messages();
};


$container['view'] = function ($container){


	$view = new \Slim\Views\Twig(__DIR__ . '/../resources/views',[

		'cache' => false,
		'debug'=>true,

		]);

	// Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));
    
    $view->addExtension(new Twig_Extension_Debug());
    $view->getEnvironment()->addGlobal('flash',$container->flash->getMessages());
    $view->getEnvironment()->addGlobal('user',$container->auth->user());
    $view->getEnvironment()->addGlobal('isLoggedIn',$container->auth->check());
	return $view;
};


/** Validator  */
$container['validator'] = function ($container){

	return new App\Validation\Validator();
};


/** Auth Middleware */

$container['auth'] = function($container){

	return new \App\Auth\Auth($container);
};



/**
 * Controller Registration
 */

$container['PageController'] = function($container){

	return new \App\Controllers\PageController($container);
};

$container['AuthController'] = function($container){

	return new \App\Controllers\Auth\AuthController($container);
};

$container['PostController'] = function($container){

	return new \App\Controllers\PostController($container);
};

$container['UserController'] = function($container){

	return new \App\Controllers\UserController($container);
};

$container['CategoryController'] = function($container){

	return new \App\Controllers\CategoryController($container);
};

$container['CommentController'] = function($container){

	return new \App\Controllers\CommentController($container);
};



/**
 * Model Registration
 */

$container['category'] = function($container){

	$connection = $container->connection;
	return new \App\Models\Category($connection);
};

$container['post'] = function($container){

	$connection = $container->connection;
	return new \App\Models\Post($connection);
};

$container['user'] = function($container){

	$connection = $container->connection;
	return new \App\Models\User($connection);
};



/**
 * Routes
 */

require __DIR__ .'/../app/routes.php';


?>