<!-- sidebar-widget -->
					<div class="sidebar-widget">
						<h3 class="sidebar-title">About Me</h3>
						<div class="widget-container widget-about">
							<a href="post.html"><img src="images/author1.jpg" alt=""></a>
							<h4>Soniya Acharya</h4>
							<div class="author-title">Blogger/Enrolled Nurse</div>
							<p>While everyone’s eyes are glued to the runway, it’s hard to ignore that there are major fashion moments on the front row too.</p>
						</div>
					</div>
					<!-- sidebar-widget -->
					<div class="sidebar-widget">
						<h3 class="sidebar-title">Recent Posts</h3>
						<div class="widget-container">
							<?php foreach ($postList as $item): ?>

								<article class="widget-post">
								<div class="post-image">
									<?php echo "<a href='post.php?id=".$item['post_id']."><img src='./post_images/".$item['image_path']."' alt=''></a>"; ?>
								</div>
								<div class="post-body">
									<h2><a href="post.php?id=<?php echo $item['post_id']?>"><?php echo $item['title']; ?></a></h2>
									<div class="post-meta">
										<span><i class="fa fa-clock-o"></i><?php echo $item['published']; ?></span> <span><a href="post.php?id=<?php echo $item['post_id']?>"><i class="fa fa-comment-o"></i><?php echo $item['comments_count']; ?></a></span>
									</div>
								</div>
							</article>
								
							<?php endforeach ?>
						</div>
					</div>
					<!-- sidebar-widget -->
					<div class="sidebar-widget">
						<h3 class="sidebar-title">Socials</h3>
						<div class="widget-container">
							<div class="widget-socials">
								<a href="#"><i class="fa fa-facebook"></i></a>
								<a href="#"><i class="fa fa-twitter"></i></a>
								<a href="#"><i class="fa fa-instagram"></i></a>
								<a href="#"><i class="fa fa-google-plus"></i></a>
								<a href="#"><i class="fa fa-pinterest"></i></a>
								<a href="#"><i class="fa fa-reddit"></i></a>
							</div>
						</div>
					</div>
					<!-- sidebar-widget -->
					<div class="sidebar-widget">
						<h3 class="sidebar-title">Categories</h3>
						<div class="widget-container">
							<ul>
								<?php foreach ($categories as $menu) {
								echo "<li><a href=''>$menu</a></li>";
								}?>
							</ul>
						</div>
					</div>
					</div>