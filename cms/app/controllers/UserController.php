<?php 

namespace App\Controllers;
use PDO;
use App\Validation\Validator;
use Respect\Validation\Validator as v;


class UserController extends Controller{



	public function getIndex($request,$response){

		$posts = $this->container->post;
		$posts = $posts->findAll();

		return $this->container->view->render($response,'admin/partials/post/view_all_post.twig',['posts'=>$posts]);


	}


	public function getUserForm($request,$response){

		
		return $this->container->view->render($response,'admin/partials/user/add_user.twig');


	}

	public function postUser($request,$response){

		// $first_name= $request->getParam('first-name');
		// $last_name= $request->getParam('last-name');
		// $email= $request->getParam('email');
		// $password= $request->getParam('password');
		// $role_id= $request->getParam('role');

		

		$rules = [

				'first-name'=>v::notEmpty()->alpha()->length(5,10),
				'last-name'=>v::notEmpty()->alpha()->length(5,10),
				'email'=>v::notEmpty()->email(),
				'password'=>v::noWhiteSpace()->notEmpty()->length(5,10),
				


		];
		// $this->container->validator->t();
		$validation = $this->container->validator->validate($request,$rules);
		if($validation->failed()){
			return $this->container->view->render($response,'admin/partials/user/add_user.twig',['errors'=>$validation->getError()]);
			
		}

		$data =array();
		$data['first_name']= $request->getParam('first-name');
		$data['last_name']= $request->getParam('last-name');
		$data['email']= $request->getParam('email');
		$data['password']= password_hash($request->getParam('password'),PASSWORD_DEFAULT);
		$data['role_id']= $request->getParam('role');
		$this->container->user->create($data);
		return $this->container->view->render($response,'admin/partials/user/add_user.twig');


	}







}

















 ?>