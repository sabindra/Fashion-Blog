<?php
include("admin_functions.php");


if(isset($_GET['approve'])){

$comment_id=$_GET['approve'];
approveComment($comment_id);
  header('Location:comment.php');

}

if(isset($_GET['unapprove'])){
$comment_id=$_GET['unapprove'];
unapproveComment($comment_id);
 header('Location:comment.php');

  
}
if(isset($_GET['delete'])){

    $id =$_GET['delete'];

    if(!empty($id)){

        deleteComment($id);

        header('Location:comment.php');
    }
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
                            Blog Post
                            
                        </h1>
                        <?php 

                        if(isset($_GET['source'])){

                        		$source = $_GET['source'];

                        		switch($source){


                        			case 'add-post':

                        						include('partials/add_post.php');
                        						break;

                                    case 'edit_post':

                                                include('partials/edit_post.php');
                                                break;

                                    
                        			default:

                        			include('partials/comment/view_all_comments.php');
                        			break;
                        		}




                        }else{


                        		include('partials/comment/view_all_comments.php');

                        }


                        ?>
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
