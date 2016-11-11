<?php 

namespace App\Auth;


class Auth{

protected $container;

public function __construct($container)
{
	$this->container=$container;
}



public function attempt($email,$password){



	$user = $this->container->user->userExist($email);

	if(!$user){

				//set session
				return false;
		}

		if(password_verify($password,$user['password'])){


			$_SESSION['user'] =$user['user_id'];
			return true;
		}

		return false;
}


public function logout(){

	session_unset();
}


public function user(){

	$user = $this->container->user->find($_SESSION['user']);

	return ['user'=>$user['user_id'],'firstName'=>$user['first_name'],'lastName'=>$user['last_name']];
}

public function check(){

	return isset($_SESSION['user']);
}













}