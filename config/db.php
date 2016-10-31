<?php 


$db['db_host']="localhost";
$db['db_name']="fashion_blog_2016";
$db['user']="ryan@web";
$db['pass']="RajRadha88";



//define constants for db connections


foreach ($db as $key=>$value) {

	define(strtoupper($key),$value);
	var_dump(strtoupper($key));
}

try {
    $dbh = new PDO('mysql:host=localhost;dbname='.DB_NAME, USER, PASS);
    


    echo "Connected";
    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

?> 