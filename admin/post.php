<?php
include("admin_functions.php");

$allPosts = getPosts();


if(isset($_GET['delete'])){

    $id =$_GET['delete'];

    if(!empty($id)){

        deletePost($id);

        header('Location:post.php');
    }
}


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


                        			default:

                        			include('partials/view_all_post.php');
                        			break;
                        		}




                        }else{


                        		include('partials/view_all_post.php');

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
