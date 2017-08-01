<?php 
header('Access-Control-Allow-Origin: *');
require_once('config.php');

if(isset($_POST['action']))
{
	if($_POST['action'] == 1)
	
	{

				try {		
//					header("Content-type:application/json"); 		
		
					$stmt = $db->query('SELECT count(*) FROM blog_posts');
					$total = $stmt->fetchColumn();

					//break total records into pages
					$pages = ceil($total/$item_per_page);
					
					echo json_encode($pages);
					
					
					}catch(Exception $e) 
					{
						echo 0;
					}
		
	}
	
	if($_POST['action']==2 && isset($_POST['Pslug']))
	{
		$slug= $_POST['Pslug'];
		$stmt = $db->query('Select comments.comment , comments.date , blog_members.username from comments inner join blog_members on blog_members.memberID = comments.user_id where post_id = ( select post_id from blog_posts where postSlug= "'.$slug.'"');
				echo json_encode(stmt->fetch());
		
	}
	
			
		
}



			
			
	

	
	
	






?>