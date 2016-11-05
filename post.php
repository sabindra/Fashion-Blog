<?php
	 
	 include("functions.php");

	 $post_id = $_GET['id'];

	 if(!empty($post_id)){
	 $post = getPost($post_id);
	 $postList = getPostList();
	 $categories=getCategories();



	 }
	 else{

	 	header('Location:index.php');

	 }
	 
	 include("partials/header.php");


	?>
	<body>

	<!-- Navigation -->
		<?php include("partials/navigation.php") ?>
		<div class="container">
		<header>
			<a href="index.html"><img src="images/logo.png"></a>
		</header>
		<section>
			<div class="row">
				<div class="col-md-8">
					<article class="blog-post">
						<div class="blog-post-image">
							<a href="post.html"><img src="images/750x500-5.jpg" alt=""></a>
						</div>
						<div class="blog-post-body">
							<h2><?php echo $post['title']?></h2>
							<div class="post-meta"><span>by <a href="#">Jamie Mooze</a></span>/<span><i class="fa fa-clock-o"></i>March 14, 2015</span>/<span><i class="fa fa-comment-o"></i> <a href="#">343</a></span></div>
							<div class="blog-post-text"><p><?php echo $post['content'] ?></p>
							</div>
						</div>
					</article>
				</div>
				<div class="col-md-4 sidebar-gutter">
					<aside>
					<?php include("partials/sidebar.php") ?>
					</aside>
				</div>
			</div>
		</section>
		</div><!-- /.container -->

		<!-- Footer -->

		<?php include("partials/footer.php") ?>

		<!-- Bootstrap core JavaScript
			================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.bxslider.js"></script>
		<script src="js/mooz.scripts.min.js"></script>
	</body>
</html>