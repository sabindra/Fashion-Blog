<?php
namespace App\Middleware;


class AuthMiddleware extends Middleware {

	public function __construct($container){

		parent::__construct($container);
	}


	public function __invoke($request,$response,$next){

		if(!$this->container->auth->check()){

			$this->container->flash->addMessage('success','Please login to proceed.');
			return $response->withRedirect($this->container->router->pathFor('admin.signin'));
		}

		$response=$next($request,$response);
		return $response;
	}
}