<?php
//include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }

//show message from add / edit page
if(isset($_GET['delpost'])){ 

	$stmt = $db->prepare('DELETE FROM blog_posts WHERE postID = :postID') ;
	$stmt->execute(array(':postID' => $_GET['delpost']));

	header('Location: profile.php?action=deleted');
	exit;
}

 if(isset($_SESSION["username"]))
	{
		$user = $_SESSION["username"];
		$stmt = $db->query('SELECT memberID from  blog_members  WHERE username = "'.$user.'"');
		$data=$stmt->fetch();
		$userID = $data['memberID'];
		
		$_SESSION['userID']= $userID;
		
	}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Profile</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
  <script language="JavaScript" type="text/javascript">
  function delpost(id, title)
  {
	  if (confirm("Are you sure you want to delete '" + title + "'"))
	  {
	  	window.location.href = 'profile.php?delpost=' + id;
	  }
  }
  </script>
</head>
<body>

	<div id="wrapper">

	<h1>Blog</h1>
	<h2>Welcome <?php echo $_SESSION['username']; ?></h2>
		<ul id='adminmenu'>
			<li><a href='profile.php'>Blog</a></li>
			<li><a href="../" target="_blank">View Website</a></li>
			<li><a href='logout.php'>Logout</a></li>
			<li><a href='add-post.php'>Add Post</a></li>
		</ul>
	<div class='clear'></div>
<hr />
	<?php 
	//show message from add / edit page
	if(isset($_GET['action'])){ 
		echo '<h3>Post '.$_GET['action'].'.</h3>'; 
	} 
	?>

	<table>
	<tr>
		<th>Title</th>
		<th>Date</th>
		<th>Action</th>
	</tr>
	<?php
		try {
			
			$stmt = $db->query('SELECT postID, postTitle, postDate  FROM blog_posts WHERE post_author_id = "'.$_SESSION['userID'].'" ORDER BY postID DESC');
			while($row = $stmt->fetch()){
				
				echo '<tr>';
				echo '<td>'.$row['postTitle'].'</td>';
				echo '<td>'.date('jS M Y', strtotime($row['postDate'])).'</td>';
				?>

				<td>
					<a href="edit-post.php?id=<?php echo $row['postID'];?>">Edit</a> | 
					<a href="javascript:delpost('<?php echo $row['postID'];?>','<?php echo $row['postTitle'];?>')">Delete</a>
				</td>
				
				<?php 
				echo '</tr>';

			}

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	</table>



</div>

</body>
</html>
