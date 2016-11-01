<?php 
if(isset($_POST['submit'])){
$title =$_POST['title'];
$title =$_POST['content'];
$title =$_POST['category'];
$title =$_POST['tag'];
$title =$_POST['status'];
$author =$_POST['author'];
$date = date('d-m-Y');
echo $date;


// file upload
 $image = $_FILES['post_image']['name'];
 $image_size = $_FILES['post_image']['size'];
 $image_temp = $_FILES['post_image']['tmp_name'];
 if($_FILES['post_image']['name'])
{
 echo $image_size;
 echo $_FILES['post_image']['name'];
 echo $_FILES['post_image']['type'];
}
}
?>

<form method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="title">Title:</label>
    <input type="text" class="col-xs-6 form-control" id="title" name="title">
  </div>
  <div class="form-group">
    <label for="pwd">Content:</label>
    <textarea type="text" class="form-control" id="content" name="content" rows="15"></textarea>
    <div class="form-group">
    <label for="email">Image</label>
    <input type="file" class="" id="email" name="post_image">
  </div>
  </div>
  <div class="form-group">
    <label for="email">tags:</label>
    <input type="email" class="form-control" id="image" name="tag">
  </div>
  <div class="form-group">
    <label for="email">status:</label>
    <input type="email" class="form-control" id="email">
  </div>
 
  <button type="submit" class="btn btn-default" name="submit">Submit</button>
</form>



