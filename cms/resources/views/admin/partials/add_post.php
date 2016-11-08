<?php 

  $categories = getCategories();


if(isset($_POST['submit'])){

  
  $title =$_POST['title'];
  $content =$_POST['content'];
  $cat_id =$_POST['category'];
  $tag =$_POST['tag'];
  $status =$_POST['status'];
  $author="soniya";
  $published=date("d-m-y");

 

  
//validating form
if(empty($title)){

  $formError.= "Please enter Title.<br>";
}

if(empty($content)){

  $formError .= "Please enter content.<br>";
}

if(!empty($title) && !empty($content)){

  //process image upload
  //
 
  



  if($_FILES['post_image']['name']){

     $image = $_FILES['post_image']['name'];
    $image_size = $_FILES['post_image']['size'];
    $image_temp = $_FILES['post_image']['tmp_name'];

    $imageType= ['PNG','JPEG','JPG',];
     $fileExt = end(explode(".",$image));
      $fileName = uniqid()."_".date("d-m-y").".".$fileExt;
      
     $imageLocation="../post_images/$fileName";


    if(!in_array(strtoupper(pathinfo($image,PATHINFO_EXTENSION)),$imageType)){

      $imageError ="Please upload valid image file.";

    }else{

     

      $copyFile =  move_uploaded_file($image_temp,$imageLocation);

      if(!$copyFile){

      $imageError="Could not upload image";
      echo $_FILES["post_image"]["error"];
      

      }

      addPost($title,$content,$fileName,$tag,$status,$author,$published,$cat_id);
      $feedback="Successfully added the post";



    }

}

  


} 

// file upload
 

 

}
?>

<form method="post" enctype="multipart/form-data" action="">
<?php if(isset($formError)){ echo "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert' aria-hidden = 'true'>
      &times;
   </button>$formError</div>";}?>
<?php if(isset($feedback)){ echo "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert' aria-hidden = 'true'>
      &times;
   </button>$feedback</div>";}?>
  <div class="form-group">
    <label for="title">Title:</label>
    <input type="text" class="col-xs-6 form-control" id="title" name="title" value="<?php if(!empty($title)){ echo  $title; }?>">
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
    <textarea type="text" class="form-control"  name="content" rows="15"><?php if(!empty($content)){ echo $content; }?></textarea>
    <div class="form-group">
    <label for="post_image">Image</label>
    <input type="file" class=""  name="post_image">
    <?php if(isset($imageError)){ echo "<p class='text-danger'>$imageError </p>";}?>
  </div>
  </div>
  <div class="form-group">
    <label for="tag">tags:</label>
    <input type="text" class="form-control" id="image" name="tag">
  </div>
  <div class="form-group">
    <label for="status">status:</label>
    <select class="form-control" name="status">

    <option value="draft">Draft</option>
    <option value="published">Published</option>


    </select>
  </div>
 
  <button type="submit" class="btn btn-success" name="submit">Submit</button>
</form>



