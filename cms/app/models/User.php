<?php 

namespace App\Models;

use PDO;
use \App\Interfaces\IModel as IModel;

class User extends Model implements  Imodel{


	function __construct($connection){

		parent::__construct($connection);

		
	}

	/**
	 * [create create a category ]
	 * @return [void] 
	 */
	public function create($array){

		$statement = $this->connection->prepare("INSERT INTO users(,first_name,last_name,user_email,password,role_id) VALUES(:title)");
		$statement->execute(array( "title"=>$array['title']));

	}



	/**
	 * [findAll list all category]
	 * @return [voiarray['title']
	 */
	public function findAll(){

		$statement = $this->connection->prepare("SELECT * FROM categories");
		$statement->execute();
		$categories = $statement->fetchAll(PDO::FETCH_ASSOC);	
		return $categories;
			
	}


	/**
	 * [find find a category by id]
	 * @param  [int] $id [category id]
	 * @return [array]   [return database result set in associative array]
	 */
	public function find($id){


		$statement = $this->connection->prepare("SELECT * FROM categories WHERE user_id=:id");
		$statement->execute(array('id'=>$id));
		$user=$statement->fetch();
		return $user;


	}


	/**
	 * [update category]
	 * @param  [int] $id [category id]
	 * @param  [associative array] $array [properties to be updated ]
	 * @return [void]     
	 */
	public function update($id,$array){

		$title = $array['title'];
		$stmt = $this->connection->prepare("UPDATE categories SET cat_title=:title WHERE user_id=:id");
		$stmt->execute(array(':title'=>$title,':id'=>$id));


	}


	/**
	 * [delete category]
	 * @param  [int] $id [category id]
	 * @return [void]   
	 */
	public function  delete($id){

		$statement = $this->connection->prepare("DELETE  FROM categories WHERE user_id=:id");
		$statement->execute(array("id"=>$id));
	}
}


public function userExist($email){

	$statement = $this->connection->prepare("SELECT * FROM users WHERE user_email=:email");
		$statement->execute(array('email'=>$email));
		$user=$statement->fetch();
		return $user;
}

public function userVerify($email,$password){

	
}



 ?>