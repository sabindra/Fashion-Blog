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

?> 