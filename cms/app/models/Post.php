<?php 

namespace App\Models;

use PDO;

class Post extends Model implements  \App\Inf\IModel{


	function __construct($connection){

		parent::__construct($connection);

		
	}

	/**
	 * [create create a post ]
	 * @return [void] 
	 */
	public function create($array){

		$statement = $this->connection->prepare("INSERT INTO posts(title,content,image_path,tags,author,status,cat_id,published) VALUES
												(:title,:content,:image_path,:tag,:author,:status,:cat_id,:published)";
		$statement = $dbh->prepare($query);
		$statement->execute(array(	"title"=>$array['title'],
									"content"=> $array['content'],
									"image_path"=>$array['image_path'],
									"tag"=>$array['tag'],
									"status"=>$array['status'],
									"author"=>$array['author'],
									"published"=>$array['published'],
									"cat_id"=>$array['cat_id'] ));


	}



	/**
	 * [findAll list all post]
	 * @return [void] 
	 */
	public function findAll(){

		$statement = $this->connection->prepare("SELECT * FROM posts ORDER BY post_id");
		$statement->execute();
		$posts = $statement->fetchAll(PDO::FETCH_ASSOC);	
		return $posts;
			
	}


	/**
	 * [find find a post by id]
	 * @param  [int] $id [post id]
	 * @return [array]   [return database result set in associative array]
	 */
	public function find($id){


		$statement = $this->connection->prepare("SELECT * FROM posts WHERE post_id=:id");
		$statement->execute(array('id'=>$id));
		$post=$statement->fetch();
		return $post;


	}


	/**
	 * [update post]
	 * @param  [int] $id [post id]
	 * @param  [associative array] $array [properties to be updated ]
	 * @return [void]     
	 */
	public function update($id,$array){

		$title = $array['title'];
		$stmt = $this->connection->prepare(" UPDATE posts SET title=:title,content=:content,tags=:tag,status=:status,cat_id=:cat_id WHERE post_id=:post_id ");
		$stmt->execute(array(	"title"=>$array['title'],
								"content"=> $array['content'],
								"tag"=>$array['tag'],
								"status"=>$array['status'],
								"cat_id"=>$array['cat_id'],
								"post_id"=>$array['post_id']);



	}


	/**
	 * [delete post]
	 * @param  [int] $id [post id]
	 * @return [void]   
	 */
	public function  delete($id){

		$statement = $dbh->prepare("DELETE  FROM posts WHERE post_id=:id");
		$statement->execute(array("id"=>$id));
	}
}




 ?>