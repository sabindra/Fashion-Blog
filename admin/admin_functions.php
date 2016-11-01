<?php 

$db['db_host']="localhost";
$db['db_name']="fashion_blog_2016";
$db['user']="ryan@web";
$db['pass']="RajRadha88";



//define constants for db connections


foreach ($db as $key=>$value) {

	define(strtoupper($key),$value);
	
}


//connect to db

try {
    $dbh = new PDO('mysql:host=localhost;dbname='.DB_NAME, USER, PASS);
    

} catch (PDOException $e) {
	
    echo "Error!: " , $e->getMessage() , "<br/>";
    die();
}

function getCategories(){
	try {
    $dbh = new PDO('mysql:host=localhost;dbname='.DB_NAME, USER, PASS);
    

} catch (PDOException $e) {
	
    echo "Error!: " , $e->getMessage() , "<br/>";
    die();
}
	$category=array();
	
	
			$categories = $dbh->query("SELECT * FROM categories ORDER BY cat_id");
			foreach	($categories as $item){

			$category[] = $item;
			}
			
			return $category;
	
}


function getCategory($id){
	try {
    $dbh = new PDO('mysql:host=localhost;dbname='.DB_NAME, USER, PASS);
    

} catch (PDOException $e) {
	
    echo "Error!: " , $e->getMessage() , "<br/>";
    die();
}
	$category=array();
	
	
			$query = $dbh->query("SELECT * FROM categories WHERE cat_id =$id");
			$category = $query->fetch();
			
			return $category;
	
}

function addCategory($category){

$message=array();
global $dbh;

	
	$query = $dbh->prepare("INSERT INTO categories(cat_title)
    VALUES(:title)");
	$query->execute(array(
    "title"=>$category
));

		if($query){

			$message['status']="Sucess fully added";
		}

		else{

			$message['error']="Sorry couldnot added,try again.";
		}

		return $message;
	



}


function updateCategory($id,$title){



	try {
    $dbh = new PDO('mysql:host=localhost;dbname='.DB_NAME, USER, PASS);
    

} catch (PDOException $e) {
	
    echo "Error!: " , $e->getMessage() , "<br/>";
    die();
}

	$stmt = $dbh->prepare("UPDATE categories SET cat_title=:title WHERE cat_id=:id");
	$stmt->execute(array('title'=>$title,'id'=>$id));


}

function deleteCategory($id){

	try {
    $dbh = new PDO('mysql:host=localhost;dbname='.DB_NAME, USER, PASS);
    

} catch (PDOException $e) {
	
    echo "Error!: " , $e->getMessage() , "<br/>";
    die();
}

	$query = $dbh->query("DELETE  FROM categories WHERE cat_id=$id");
	$query->execute();
	
	




 
}






function getPosts(){
	try {
    $dbh = new PDO('mysql:host=localhost;dbname='.DB_NAME, USER, PASS);
    

} catch (PDOException $e) {
	
    echo "Error!: " , $e->getMessage() , "<br/>";
    die();
}
	$post=array();
	
	
			$posts = $dbh->query("SELECT * FROM posts ORDER BY post_id");
			foreach	($posts as $item){

			$post[] = $item;
			}
			
			return $post;
	
}


function deletePost($id){

	try {
    $dbh = new PDO('mysql:host=localhost;dbname='.DB_NAME, USER, PASS);
    

} catch (PDOException $e) {
	
    echo "Error!: " , $e->getMessage() , "<br/>";
    die();
}

	$query = $dbh->query("DELETE  FROM posts WHERE post_id=$id");
	$query->execute();
	
	




 
}















?>