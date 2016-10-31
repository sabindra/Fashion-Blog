<?php
	 include("config/db.php");
	$query = $dbh->prepare("SELECT * FROM categories");
	$query->execute();

			$categories = $query->fetchAll(PDO::FETCH_COLUMN,1);
			foreach	($categories as $item){

			$category[] = $item;
			}
			sort($category);
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
				<li><div class="slider-item"><img src="images/1140x500-2.jpg" title="Funky roots" /><h2><a href="post.html" title="Vintage-Inspired Finds for Your Home">Vintage-Inspired Finds for Your Home</a></h2></div></li>
				<li><div class="slider-item"><img src="images/1140x500-1.jpg" title="Funky roots" /><h2><a href="post.html" title="Vintage-Inspired Finds for Your Home">Vintage-Inspired Finds for Your Home</a></h2></div></li>
				<li><div class="slider-item"><img src="images/1140x500-3.jpg" title="Funky roots" /><h2><a href="post.html" title="Vintage-Inspired Finds for Your Home">Vintage-Inspired Finds for Your Home</a></h2></div></li>
			</ul>
		</section>
		<section>
			<div class="row">
				<div class="col-md-8">
					<article class="blog-post">
						<div class="blog-post-image">
							<a href="post.html"><img src="images/750x500-1.jpg" alt=""></a>
						</div>
						<div class="blog-post-body">
							<h2><a href="post.html">Vintage-Inspired Finds for Your Home</a></h2>
							<div class="post-meta"><span>by <a href="#">Jamie Mooze</a></span>/<span><i class="fa fa-clock-o"></i>March 14, 2015</span>/<span><i class="fa fa-comment-o"></i> <a href="#">343</a></span></div>
							<p>ew months ago, we found ridiculously cheap plane tickets for Boston and off we went. It was our first visit to the city and, believe it or not, Stockholm in February was more pleasant than Boston in March. It probably has a lot to do with the fact that we arrived completely unprepared. That I, in my converse and thin jacket, did not end up with pneumonia is honestly not even fair.</p>
							<div class="read-more"><a href="#">Continue Reading</a></div>
						</div>
					</article>
					<!-- article -->
					<article class="blog-post">
						<div class="blog-post-image">
							<a href="post.html"><img src="images/750x500-2.jpg" alt=""></a>
						</div>
						<div class="blog-post-body">
							<h2><a href="post.html">The Best Street Style Looks of London Fashion Week</a></h2>
							<div class="post-meta"><span>by <a href="#">Jamie Mooze</a></span>/<span><i class="fa fa-clock-o"></i>March 14, 2015</span>/<span><i class="fa fa-comment-o"></i> <a href="#">343</a></span></div>
							<p>Few months ago, we found ridiculously cheap plane tickets for Boston and off we went. It was our first visit to the city and, believe it or not, Stockholm in February was more pleasant than Boston in March. It probably has a lot to do with the fact that we arrived completely unprepared.</p>
							<div class="read-more"><a href="#">Continue Reading</a></div>
						</div>
					</article>
					<!-- article -->
					<article class="blog-post">
						<div class="blog-post-image">
							<a href="post.html"><img src="images/750x500-3.jpg" alt=""></a>
						</div>
						<div class="blog-post-body">
							<h2><a href="post.html">Front Row Style: Our Favorite A-List Moments of Fashion Week</a></h2>
							<div class="post-meta"><span>by <a href="#">Jamie Mooze</a></span>/<span><i class="fa fa-clock-o"></i>March 14, 2015</span>/<span><i class="fa fa-comment-o"></i> <a href="#">343</a></span></div>
							<p>It was our first visit to the city and, believe it or not, Stockholm in February was more pleasant than Boston in March. It probably has a lot to do with the fact that we arrived completely unprepared. Few months ago, we found ridiculously cheap plane tickets for Boston and off we went.</p>
							<div class="read-more"><a href="#">Continue Reading</a></div>
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