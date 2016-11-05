<?php
$post_id =  $_GET['p_id'];
$post = getPost($post_id);
$categories = getCategories();




if(isset($_POST['update-post'])){

	$formError=null;
  $title =$_POST['title'];
  $content =$_POST['content'];
  $cat_id =$_POST['category'];
  $tag =$_POST['tag'];
  $status =$_POST['status'];
  $post_id =  $_GET['p_id'];
  
 

  if(empty($title)){

  $formError.= "Please enter Title.<br>";
}

if(empty($content)){

  $formError .= "Please enter content.<br>";
}

if(!empty($title) && !empty($content)){

	 updatePost($post_id,$title,$content,$tag,$status,$cat_id);
      $feedback="Successfully added the post";
}
}
?>

<?php if(isset($formError)){ echo "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert' aria-hidden = 'true'>
      &times;
   </button>$formError</div>";}?>
<?php if(isset($feedback)){ echo "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert' aria-hidden = 'true'>
      &times;
   </button>$feedback</div>";}?>
<form method="post" enctype="multipart/form-data" action="">

  <div class="form-group">
    <label for="title">Title:</label>
    <input type="text" class="col-xs-6 form-control" id="title" name="title" value="<?php if(!empty($post)){ echo  $post['title']; }?>">
  </div>
  <div class="form-group">
    <label for="title">Category:</label>
    <select name ="category" class="form-control">
    <?php foreach ($categories as $cat){

      echo "<option value=".$cat['cat_id'].">".$cat['cat_title']."</option>";
      
    }?>
    </select>
  </div>
  <div class="form-group">
    <label for="pwd">Content:</label>
    <textarea type="text" class="form-control"  name="content" rows="15"><?php if(!empty($post)){ echo  $post['content']; }?></textarea>
    <div class="form-group">
    <label for="post_image">Image</label>
    <input type="file" class=""  name="post_image">
    <?php if(isset($imageError)){ echo "<p class='text-danger'>$imageError </p>";}?>
  </div>
  </div>
  <div class="form-group">
    <label for="tag">tags:</label>
    <input type="text" class="form-control" id="image" name="tag" value=<?php if(!empty($post)){ echo  $post['tags']; }?>>
  </div>
  <div class="form-group">
    <label for="status">status:</label>
    <select class="form-control" name="status">

    <option value="draft">Draft</option>
    <option value="publsihed">Published</option>


    </select>
  </div>
 
  <button type="submit" class="btn btn-success" name="update-post">Submit</button>
</form>











