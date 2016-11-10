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
















}