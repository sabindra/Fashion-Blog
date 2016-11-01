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


function addCategory($category){

$message=array();
try {
    $dbh = new PDO('mysql:host=localhost;dbname='.DB_NAME, USER, PASS);
    

} catch (PDOException $e) {
	
    echo "Error!: " , $e->getMessage() , "<br/>";
    die();
}
	
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


?>