<?php
include("includes/config.php"); //include config file

//sanitize post value
if(isset($_POST["page"])){
	$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
	if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
}else{
	$page_number = 1;
}

//get current starting point of records
$position = (($page_number-1) * $item_per_page);

//Limit our results within a specified range. 
try{
	$stmt = $db->query('SELECT blog_posts.postID, blog_posts.postTitle,blog_posts.num_comments, blog_posts.postDesc, blog_posts.postDate,blog_posts.postSlug, blog_posts.post_img ,blog_posts.post_audio_url ,blog_members.name,blog_posts.likes  FROM blog_posts INNER JOIN blog_members on post_author_id = blog_members.memberID  ORDER BY postID DESC LIMIT '.$position.', '.$item_per_page.'');
				while($row = $stmt->fetch()){
					echo'<article class="blog-post">';
					echo '<div class="blog-post-body">';
						echo '<h1><a href="viewpost.php/'.$row['postSlug'].'">'.$row['postTitle'].'</a></h1>';
						echo '<div class="post-meta"><a href="#"><span>Posted by '.$row['name'].'</span>/<span><i class="fa fa-clock-o"></i> on '.date('jS M Y H:i:s', strtotime($row['postDate'])).'</span>/<span><i class="fa fa-comment-o">'.$row['num_comments'].'</i></span>/<span><i class="fa fa-heart-o" aria-hidden="true">'.$row['likes'].'</i></span></a></div>';
						if($row['post_audio_url'] != null)
							{
								echo '<div>'.$row['post_audio_url'].'</div>';
							}
						
								echo '<p>'.$row['postDesc'].'</p>';
					
								echo '<div class="read-more"><a href="viewpost.php/'.$row['postSlug'].'">Continue Reading</a></div>';				
								echo '</div>';
								echo '</article>';

				}
	
	
}

			 catch(PDOException $e) {
			    echo $e->getMessage();
			}

		?>

