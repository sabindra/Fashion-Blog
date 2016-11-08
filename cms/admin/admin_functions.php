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
	$stmt->execute(array(':title'=>$title,':id'=>$id));


}

function deleteCategory($id){
	echo "inside function";

	try {
    $dbh = new PDO('mysql:host=localhost;dbname='.DB_NAME, USER, PASS);
    

} catch (PDOException $e) {
	
    echo "Error!: " , $e->getMessage() , "<br/>";
    die();
}

	$query = $dbh->prepare("DELETE  FROM categories WHERE cat_id=:id");
	$query->execute(array("id"=>$id));
	
	




 
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




function addPost($title,$content,$image_path,$tag=null,$status,$author,$published,$cat_id){

	if(!isset($tag)){

		$tag="";

	}

		try {
    $dbh = new PDO('mysql:host=localhost;dbname='.DB_NAME, USER, PASS);
    

} catch (PDOException $e) {
	
    echo "Error!: " , $e->getMessage() , "<br/>";
    die();
}

$query = "INSERT INTO posts(title,content,image_path,tags,author,status,cat_id,published) VALUES(:title,:content,:image_path,:tag,:author,:status,:cat_id,:published)";
$statement = $dbh->prepare($query);
$statement->execute(array("title"=>$title,
					"content"=> $content,
					"image_path"=>$image_path,
					"tag"=>$tag,
					"status"=>$status,
					"author"=>$author,
					"published"=>$published,
					"cat_id"=>$cat_id
 					));





}
function updatePost ($post_id,$title,$content,$tag=null,$status,$cat_id){

	if(!isset($tag)){

		$tag="";

	}

		try {
    $dbh = new PDO('mysql:host=localhost;dbname='.DB_NAME, USER, PASS);
    

} catch (PDOException $e) {
	
    echo "Error!: " , $e->getMessage() , "<br/>";
    die();
}

$query = "Update posts SET title=:title,content=:content,tags=:tag,status=:status,cat_id=:cat_id WHERE post_id=:post_id";
$statement = $dbh->prepare($query);
$statement->execute(array("title"=>$title,
					"content"=> $content,
					"tag"=>$tag,
					"status"=>$status,
					"cat_id"=>$cat_id,
					"post_id"=>$post_id
 					));





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




function getComments(){
	try {
    $dbh = new PDO('mysql:host=localhost;dbname='.DB_NAME, USER, PASS);
    

} catch (PDOException $e) {
	
    echo "Error!: " , $e->getMessage() , "<br/>";
    die();
}
	
	
	
			$statement = $dbh->prepare("SELECT * FROM comments ORDER BY comment_id");
			$statement->execute();
			$comments = $statement->fetchAll(PDO::FETCH_ASSOC); 
			
			return $comments;
	
}







function deleteComment($id){

	try {
    $dbh = new PDO('mysql:host=localhost;dbname='.DB_NAME, USER, PASS);
    

} catch (PDOException $e) {
	
    echo "Error!: " , $e->getMessage() , "<br/>";
    die();
}

	$query = $dbh->prepare("DELETE  FROM comments WHERE comment_id=$id");
	$query->execute();
	
	




 
}


function approveComment($comment_id){



	try {
    $dbh = new PDO('mysql:host=localhost;dbname='.DB_NAME, USER, PASS);
    

} catch (PDOException $e) {
	
    echo "Error!: " , $e->getMessage() , "<br/>";
    die();
}

	$stmt = $dbh->prepare("UPDATE comments SET comment_status='approved' WHERE comment_id=:comment_id");
	$stmt->execute(array(':comment_id'=>$comment_id));


}


function unapproveComment($comment_id){



	try {
    $dbh = new PDO('mysql:host=localhost;dbname='.DB_NAME, USER, PASS);
    

} catch (PDOException $e) {
	
    echo "Error!: " , $e->getMessage() , "<br/>";
    die();
}

	$stmt = $dbh->prepare("UPDATE comments SET comment_status='unapproved' WHERE comment_id=:comment_id");
	$stmt->execute(array(':comment_id'=>$comment_id));


}








?>