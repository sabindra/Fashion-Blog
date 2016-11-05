<?php
	 
	 include("functions.php");
	 $categories=getCategories();
	 $recentPosts = getRecentPosts();
	 $postList = getPostList();
	 include("partials/header.php");


	?>
	<body>
		<!-- Navigation -->
		<?php include("partials/navigation.php") ?>

		<div class="container">
		<header>
			<a href="index.html"><img src="images/logo.png"></a>
		</header>
		<section class="main-slider">
			<ul class="bxslider">
				<li><div class="slider-item"><img src="post_images/581da7440c14d_05-11-16.jpg" title="Funky roots" /><h2><a href="post.html" title="Vintage-Inspired Finds for Your Home">Vintage-Inspired Finds for Your Home</a></h2></div></li>
				<li><div class="slider-item"><img src="images/1140x500-1.jpg" title="Funky roots" /><h2><a href="post.html" title="Vintage-Inspired Finds for Your Home">Vintage-Inspired Finds for Your Home</a></h2></div></li>
				<li><div class="slider-item"><img src="images/1140x500-3.jpg" title="Funky roots" /><h2><a href="post.html" title="Vintage-Inspired Finds for Your Home">Vintage-Inspired Finds for Your Home</a></h2></div></li>
			</ul>
		</section>
		<section>
			<div class="row">
				<div class="col-md-8">

				<?php foreach ($recentPosts as $post): ?>

					<article class="blog-post">
						<div class="blog-post-image">
							<?php echo "<a href='post.php?id=".$post['post_id']."><img src='./post_images/".$post['image_path']."' alt=''></a>"; ?>
						</div>
						<div class="blog-post-body">
							<h2><a href="post.php?id=<?php echo $post['post_id']; ?>"><?php echo $post['title']; ?></a></h2>
							<div class="post-meta"><span>by <a href="#"><?php echo $post['author']; ?></a></span>/<span><i class="fa fa-clock-o"></i><?php echo $post['published']; ?></span>/<span><i class="fa fa-comment-o"></i> <a href="#"><?php echo $post['comments_count']; ?></a></span></div>
							<p><?php echo $post['content']; ?></p>
							<div class="read-more"><a href="#">Continue Reading</a></div>
						</div>
					</article>
					
					
				<?php endforeach ?>
					
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