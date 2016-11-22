<?php 

namespace App\Auth;

/**
 * Auth 
 */
class Auth{

	protected $container;

	/**
	 * [__construct description]
	 * @param [type] $container [description]
	 */
	public function __construct($container){
		
		$this->container=$container;
	}

	/**
	 * [attempt description]
	 * @param  [type] $email    [description]
	 * @param  [type] $password [description]
	 * @return [type]           [description]
	 */
	public function attempt($email,$password){

		$user = $this->container->user->userExist($email);

		if(!$user){

				return false;
		}

		if(password_verify($password,$user['password'])){

			$_SESSION['user'] =$user['user_id'];
			return true;
		}

		return false;
	}


	/**
	 * [logout description]
	 * @return [type] [description]
	 */
	public function logout(){

		session_unset();
	}


	/**
	 * [user description]
	 * @return [type] [description]
	 */
	public function user(){
		
		if(isset($_SESSION['user'])){

			$user = $this->container->user->find($_SESSION['user']);
			return ['user'=>$user['user_id'],
					'first_name'=>$user['first_name'],
					'last_name'=>$user['last_name'],
					'role_id'=>$user['role_id'],
					'image_path'=>$user['image_path']];
		}
	}

	
	/**
	 * [check description]
	 * @return [type] [description]
	 */
	public function check(){

		return isset($_SESSION['user']);
	}


	/**
	 * [role description]
	 * @return [type] [description]
	 */
	public function role(){

		$user = $this->container->user->find($_SESSION['user_id']);
	}











}