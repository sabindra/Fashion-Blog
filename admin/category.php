<?php 
include("admin_functions.php");
$categories = getCategories();
if(isset($_POST['submit'])){


    $title=$_POST['title'];

  if(empty($title)){

    $error ="Pleaes enter the category name";

  }else{

    $message = addCategory($title);
    header('Location:category.php');
  }
  

	

}

if(isset($_GET['delete'])){

  $id = $_GET['delete'];

   if(!empty($id)){

  $query = deleteCategory($id);

  header('Location:category.php');

}

}



if(isset($_POST['update-category'])){

   $id = $_GET['edit'];
  $title = $_POST['title'];
   updateCategory($id, $title);
   header('Location:category.php');

}






?>

<?php

include("partials/admin_header.php");


?>
<body>

    <div id="wrapper">

        <!-- Navigation -->
       <?php include("partials/admin_navigation.php"); ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                           Category
                            
                            <small><?php if (isset($test) || isset($test) ){ echo $test;} ?></small>
                        </h1>

                        <div class="col-xs-6">
                        <?php if(isset($error)){ echo "<p class='text-danger'>$error</p>";} ?>
                        
                        <?php if(isset($message['success'])){ echo "<p class='text-success'>".$message['success']."</p>";} ?>
                        <?php if(isset($message['error'])){ echo "<p class='text-danger'>".$message['error']."</p>";} ?>

                        <form method="post" action="">
    <div class="form-group">
      <label for="email">Add Category</label>
      <input type="text" class="form-control" id="email" name="title" placeholder="Enter email">
    </div>
    
    <button type="submit" class="btn btn-success" name="submit">Add Category</button>
  </form>
<br>
  <?php
if(isset($_GET['edit'])){

  $cat_id = $_GET['edit'];
  
  if(isset($cat_id)){


$category = getCategory($cat_id);

$cat_title = $category['cat_title'];?>


 <form method="post" action="">
    <div class="form-group">
      <label for="email">Add Category</label>
      <input type="text" class="form-control" id="email" name="title" value="<?php echo $cat_title ?>" placeholder="Enter email">
    </div>
    
    <button type="submit" class="btn btn-primary" name="update-category">Update Category</button>
  </form>
  <?php }




  
  
   
} ?>
                        </div>

                        <div class="col-xs-6">
                         <table class="table table-brodered table-stripped table-hover">
    <thead class="thead-inverse">
      <tr>
        <th>Id</th>
        <th>Category</th>
      </tr>
    </thead>
    <tbody>
      
      <?php foreach ($categories as $item): ?>
      	<tr> 
        <td><?php echo $item['cat_id'];?></td>
        <td><?php echo $item['cat_title'];?></td>
        <td><a class ="btn btn-warning" href="category.php?edit=<?php echo $item['cat_id'];?>">Edit</a></td>
         <td><a class ="btn btn-danger" href="category.php?delete=<?php echo $item['cat_id'];?>">Delete</a></td>
      </tr>

      	
      <?php endforeach ?>
       
     
    </tbody>
  </table>
                        </div>
                       
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
