<?php 

namespace App\Controllers;
use PDO;
use App\Validation\Validator;
use Respect\Validation\Validator as v;


class UserController extends Controller{


	/**
	 * [getIndex return all users]
	 * [HTTP request object] $request 
	 * @param  [HTTP response object] $response 
	 * @return [HTML]           [return all users]
	 */
	public function getIndex($request,$response){

		$user = $this->container->user;
		$admin_id = $this->container->auth->user()['user'];
		
		$users = $user->findAll($admin_id);
		
		return $this->container->view->render($response,'admin/partials/user/view_all_user.twig',['users'=>$users]);


	}

	/**
	 * [getUserForm description]
	 * [HTTP request object] $request 
	 * @param  [HTTP response object] $response 
	 * @return [type]           [description]
	 */
	public function getUserForm($request,$response){

		
		return $this->container->view->render($response,'admin/partials/user/add_user.twig');


	}

	/**
	 * [postUser description]
	 * [HTTP request object] $request 
	 * @param  [HTTP response object] $response 
	 * @return [type]           [description]
	 */
	public function postUser($request,$response){

		// respect validation rules
		$rules = [

				'first_name'=>v::notEmpty()->alpha()->length(5,10),
				'last_name'=>v::notEmpty()->alpha()->length(5,10),
				'email'=>v::notEmpty()->email(),
				'password'=>v::noWhiteSpace()->notEmpty()->length(5,10),
				


		];
		
		// @see App\Validation\Validator
		$validation = $this->container->validator->validate($request,$rules);
		if($validation->failed()){

			return $this->container->view->render($response,'admin/partials/user/add_user.twig',['errors'=>$validation->getError()]);
			
		}

		$data =array();
		$data['first_name']= $request->getParam('first_name');
		$data['last_name']= $request->getParam('last_name');
		$data['email']= $request->getParam('email');
		$data['password']= password_hash($request->getParam('password'),PASSWORD_DEFAULT);
		$data['role_id']= $request->getParam('role');

		$this->container->user->create($data);
		$this->container->flash->addMessage('success',"User added successfully !");
		return $response->withRedirect($this->container->router->pathFor('admin.addUser'));

	}

	/**
	 * [getUserForm description]
	 * [HTTP request object] $request 
	 * @param  [HTTP response object] $response 
	 * @return [type]           [description]
	 */
	public function editUser($request,$response,$args){

		$user_id = $args['id'];
		$user = $this->container->user->find($user_id);
		return $this->container->view->render($response,'admin/partials/user/edit_user.twig',['user'=>$user]);


	}

	/**
	 * [getUserForm description]
	 * [HTTP request object] $request 
	 * @param  [HTTP response object] $response 
	 * @return [type]           [description]
	 */
	public function updateUser($request,$response,$args){

		$user_id = $args['id'];

		// respect validation rules
		$rules = [

				'first_name'=>v::notEmpty()->alpha()->length(5,10),
				'last_name'=>v::notEmpty()->alpha()->length(5,10),
				'email'=>v::notEmpty()->email(),
				
		];

		// @see App\Validation\Validator
		$validation = $this->container->validator->validate($request,$rules);
		if($validation->failed()){

			$this->container->view->getEnvironment()->addGlobal('errors',$validation->getError());
			$this->container->flash->addMessage('fail',"Please enter required fields !");
			$user = $this->container->user->find($user_id);
			// return $this->container->view->render($response,'admin/partials/user/edit_user.twig',['user'=>$user]);
			return $response->withRedirect($this->container->router->pathFor('admin.editUser',['id'=>$user_id,'errors'=>$validation->getError()]));
		}


		$data =array();
		$data['first_name']= $request->getParam('first_name');
		$data['last_name']= $request->getParam('last_name');
		$data['user_email']= $request->getParam('email');
		$data['password']= password_hash($request->getParam('password'),PASSWORD_DEFAULT);
		$data['role_id']= $request->getParam('role');

		$user = $this->container->user->update($user_id,$data);
		$this->container->flash->addMessage('success',"User updated successfully !");
		return $response->withRedirect($this->container->router->pathFor('admin.users'));


	}




	/**
	 * [getUserForm description]
	 * [HTTP request object] $request 
	 * @param  [HTTP response object] $response 
	 * @return [type]           [description]
	 */
	public function destroyUser($request,$response,$args){

		$user_id = $args['id'];
		$this->container->user->delete($user_id);
		$this->container->flash->addMessage('success',"User Deleted successfully !");
		return $response->withRedirect($this->container->router->pathFor('admin.users'));


	}



	/**
	 * [getUserForm description]
	 * [HTTP request object] $request 
	 * @param  [HTTP response object] $response 
	 * @return [type]           [description]
	 */
	public function getProfile($request,$response){

		$user_id = $this->container->auth->user()['user'];
		$user=$this->container->user->find($user_id);
		return $this->container->view->render($response,'admin/partials/user/profile.twig',['user'=>$user]);


	}


	/**
	 * [getUserForm description]
	 * [HTTP request object] $request 
	 * @param  [HTTP response object] $response 
	 * @return [type]           [description]
	 */
	public function updateProfile($request,$response){

			// respect validation rules
		$rules = [

				'first_name'=>v::notEmpty()->alpha()->length(5,10),
				'last_name'=>v::notEmpty()->alpha()->length(5,10),
				'email'=>v::notEmpty()->email(),
				
		];

		$validation = $this->container->validator->validate($request,$rules);
		if($validation->failed()){

			$this->container->flash->addMessage('fail',"Please enter all fields!");
			return $response->withRedirect($this->container->router->pathFor('user.profile'));
		}

		$data =array();
		$data['first_name']= $request->getParam('first_name');
		$data['last_name']= $request->getParam('last_name');
		$data['user_email']= $request->getParam('email');
		$user_id = $this->container->auth->user()['user'];

		$user = $this->container->user->updateProfile($user_id,$data);
		$this->container->flash->addMessage('success',"Successfully update profile!");
		return $response->withRedirect($this->container->router->pathFor('user.profile'));


	}


}

















 ?>