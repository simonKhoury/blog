<?php require('includes/config.php'); 
$url = $_SERVER['REQUEST_URI'];
$pos = strrpos($url, '/');
$slug = $pos === false ? $url : substr($url, $pos + 1);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="favicon.ico">
		<title>UBlog</title>
		<!-- Bootstrap core CSS -->
		<link href="../style/normalize.css" type="text/css" rel="stylesheet">
		<link href="../style/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" type="text/css">
		<!-- Custom styles for this template -->
		<link href="../style/jquery.bxslider.css" rel="stylesheet" type="text/css" rel="stylesheet">
		<link href="../style/style.css" rel="stylesheet" type="text/css">
</head>
<body>
	<!-- Navigation -->
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li class="active"><a href="../">Home</a></li>
					
					</ul>

					<ul class="nav navbar-nav navbar-right">
						<li><a href="#"><i class="fa fa-facebook"></i></a></li>
						<li><a href="#"><i class="fa fa-twitter"></i></a></li>
						<li><a href="#"><i class="fa fa-instagram"></i></a></li>
						<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
						<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
						<li><a href="#"><i class="fa fa-reddit"></i></a></li>
					</ul>

				</div>
				<!--/.nav-collapse -->
			</div>
		</nav>

		<div class="container">
		<header>
<!--			<a href="index.html"><img src="images/logo.png" alt="a"></a>-->
		</header>
<!--
		<section class="main-slider">
			<ul class="bxslider">
				<li><div class="slider-item"><img src="images/1140x500-2.jpg" title="Funky roots" /><h2><a href="post.html" title="Vintage-Inspired Finds for Your Home">Vintage-Inspired Finds for Your Home</a></h2></div></li>
				<li><div class="slider-item"><img src="images/1140x500-1.jpg" title="Funky roots" /><h2><a href="post.html" title="Vintage-Inspired Finds for Your Home">Vintage-Inspired Finds for Your Home</a></h2></div></li>
				<li><div class="slider-item"><img src="images/1140x500-3.jpg" title="Funky roots" /><h2><a href="post.html" title="Vintage-Inspired Finds for Your Home">Vintage-Inspired Finds for Your Home</a></h2></div></li>
			</ul>
		</section>
-->
		<section>
			<div class="row">
				<div class="col-md-8" >
				<p><a href="../">Back To Main</a></p>
				<?php 
					$stmt = $db->prepare('SELECT  blog_posts.postID, blog_posts.postTitle, blog_posts.postCont, blog_posts.likes,blog_posts.postDate, blog_posts.post_img ,blog_posts.post_audio_url ,blog_members.name  FROM blog_posts INNER JOIN blog_members on post_author_id = blog_members.memberID WHERE blog_posts.postSlug = :postSlug');
					$stmt->execute(array(':postSlug' => $slug ));
					while($row = $stmt->fetch())
					{
							
					echo '<article class="blog-post">';
					
					if($row['post_img'] != null){echo '<div class="blog-post-image"><a href="viewpost.php?id='.$row['postID'].'"><img src="images/750x500-1.jpg" alt="image"></a></div>';}
					elseif($row['post_audio_url'] != null){echo '<div class="blog-post-video">'.$row['post_audio_url'].'</div>';}
					else{}
						
					
							echo '<div class="blog-post-body">';
							echo '<h1><a href="#">'.$row['postTitle'].'</a></h1>';
							echo '<div class="post-meta"><a href="#"><span>Posted by '.$row['name'].'</span>/<span><i class="fa fa-clock-o"></i>'.date('jS M Y H:i:s', strtotime($row['postDate'])).'</span>/<span><i class="fa fa-comment-o"></i></span>/<span><i class="fa fa-heart-o" aria-hidden="true">'.$row['likes'].'</i></span></a></div>';
							echo '<p>'.$row['postCont'].'</p>';

						
							echo '</div>';
							
							echo '</article>';
			
					}
					?>
				
				</div>
				<?php if(isset($_SESSION['username']))
				{
	 				$user = $_SESSION['username'];
					echo '<div class="col-md-4 sidebar-gutter">';
					echo '<aside>';
					
					
					echo '<div class="sidebar-widget">';
						echo '<h3 class="sidebar-title">Top  Posts from '.$user.'</h3>';
						echo '<div class="widget-container">';
							
							try{
	$stmt = $db->query('SELECT blog_posts.postID, blog_posts.postTitle,blog_posts.num_comments, blog_posts.postDate,blog_posts.postSlug ,blog_posts.likes  FROM blog_posts INNER JOIN blog_members on post_author_id = blog_members.memberID and blog_members.username ="'.$user.'"  ORDER BY num_comments DESC ,likes DESC limit 5');
				while($row = $stmt->fetch()){
					
								echo '	<article class="widget-post">';

								echo '<div class="post-body">';
								echo '<h2><a href="viewpost.php/'.$row['postSlug'].'">'.$row['postTitle'].'</a></h2>';
							
								echo '<div class="post-meta">';
								echo '<a href="viewpost.php/'.$row['postSlug'].'"><span><i class="fa fa-clock-o"></i> on '.date('jS M Y H:i:s', strtotime($row['postDate'])).'</span><br /><span><i class="fa fa-comment-o">'.$row['num_comments'].'</i>Comments</span><br /><span><i class="fa fa-heart-o" aria-hidden="true">'.$row['likes'].'</i>Likes</span></a>';
								echo'</div>';
								
								echo '</div>';
								
								echo '</article>';
				
						}
	
	
}

			 catch(PDOException $e) {
			    echo $e->getMessage();
			}
		}
 ?>
							
						</div>
					</div>
					
						
					</aside>
				</div>
			</div>
<?php if(isset($_SESSION['username'])){
	echo '<div class="row">';
	echo '<div class="col-md-12 ">';
	
	echo		'<form class="form-inline" role="form" method="post">';
	echo		'<div class="col-md-10">';
	echo	'<div class="form-group" id="comment_box_2" >';
	echo	'<input class="form-control"  id="comment_box_1" type="textarea" placeholder="Your comments"/>';
	echo			'</div>';
	echo			'</div>';
	echo			'<div class="col-md-2">';
	echo			'<div class="form-group">';
	echo				'<button class="btn btn-default" >Add</button>';
	echo			'</div>';
	echo			'</div>';
    echo    	'</form>';
	echo	'</div>';
	echo '</div>';
} ?>

<div class="container" style="height: 500px;overflow-y: scroll" id="comments_box">


	
	


	
	
	</section>
</div><!-- /.container -->

		<footer class="footer">

			<div class="footer-socials">
				<a href="#"><i class="fa fa-facebook"></i></a>
				<a href="#"><i class="fa fa-twitter"></i></a>
				<a href="#"><i class="fa fa-instagram"></i></a>
				<a href="#"><i class="fa fa-google-plus"></i></a>
				<a href="#"><i class="fa fa-dribbble"></i></a>
				<a href="#"><i class="fa fa-reddit"></i></a>
			</div>

			<div class="footer-bottom">
				<i class="fa fa-copyright"></i> Copyright 2015. All rights reserved.<br>
				Theme made by <a href="http://www.moozthemes.com">MOOZ Themes</a>
			</div>
		</footer>

		<!-- Bootstrap core JavaScript
			================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<script src="../js/jquery.bxslider.js"></script>
		<script src="../js/mooz.scripts.min.js"></script>
		<script src="../js/url.min.js"></script>
	<script src="../js/post.js" type="text/javascript"></script>
	</body>
</html>
