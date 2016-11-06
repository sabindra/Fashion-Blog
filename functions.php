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
	$query = $dbh->prepare("SELECT * FROM categories");
	$query->execute();

			$categories = $query->fetchAll(PDO::FETCH_COLUMN,1);
			foreach	($categories as $item){

			$category[] = $item;
			}
			sort($category);
			return $category;
	
}


function getRecentPosts(){

try {
    $dbh = new PDO('mysql:host=localhost;dbname='.DB_NAME, USER, PASS);
    

} catch (PDOException $e) {
	
    echo "Error!: " , $e->getMessage() , "<br/>";
    die();
}
	$post=array();
	$query = $dbh->query("SELECT * FROM posts WHERE status='published' ORDER BY post_id DESC LIMIT 3");
	$query->execute();

			$posts = $query->fetchAll();
			foreach	($posts as $item){

			$post[] = $item;
			}
			
			return $posts;
	



}


function getPostList(){

try {
    $dbh = new PDO('mysql:host=localhost;dbname='.DB_NAME, USER, PASS);
    

} catch (PDOException $e) {
	
    echo "Error!: " , $e->getMessage() , "<br/>";
    die();
}
	$post=array();
	$query = $dbh->query("SELECT * FROM posts WHERE status='published' ORDER BY post_id DESC LIMIT 10");
	$query->execute();

			$posts = $query->fetchAll();
			foreach	($posts as $item){

			$post[] = $item;
			}
			
			return $posts;
	



}

function getPost($id){


try {
    $dbh = new PDO('mysql:host=localhost;dbname='.DB_NAME, USER, PASS);
    

} catch (PDOException $e) {
	
    echo "Error!: " , $e->getMessage() , "<br/>";
    die();
}
	
	
	
			$statement = $dbh->prepare("SELECT * FROM posts WHERE post_id=:id");
			$statement->execute(array('id'=>$id));
			$post=$statement->fetch();
			
			return $post;

}

function addComment($comment_post_id,$comment_author,$comment_author_email,$comment,$comment_date){

	try {
    $dbh = new PDO('mysql:host=localhost;dbname='.DB_NAME, USER, PASS);
    

} catch (PDOException $e) {
	
    echo "Error!: " , $e->getMessage() , "<br/>";
    die();
}


$query = "INSERT INTO comments(comment_post_id,comment_author,comment_author_email,comment,comment_status,comment_date) VALUES(:comment_post_id,:comment_author,:comment_author_email,:comment,:comment_status,:comment_date)";
$statement = $dbh->prepare($query);
$statement->execute(array("comment_post_id"=>$comment_post_id,
					"comment_author"=> $comment_author,
					"comment_author_email"=>$comment_author_email,
					"comment"=>$comment,
					"comment_status"=>"unapproved",
					"comment_date"=>$comment_date
 					));

}


 ?>

