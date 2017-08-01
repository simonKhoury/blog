<?php //include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title> Add Post</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
  <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
  <script>
          tinymce.init({
              selector: "textarea",
			  force_br_newlines : true,
			  forced_root_block : 'p',
              plugins: [
                  "advlist autolink lists link image charmap print preview anchor",
                  "searchreplace visualblocks code fullscreen",
                  "insertdatetime media table contextmenu paste"
              ],
              toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
          });
  </script>
</head>
<body>

<div id="wrapper">

	<h1>Blog</h1>
	<ul id='adminmenu'>
	<li><a href='profile.php'>Blog</a></li>
	
	<li><a href="../" target="_blank">View Website</a></li>
	<li><a href='logout.php'>Logout</a></li>
	</ul>
<div class='clear'></div>
<hr />
	<p><a href="profile.php">Back to profile</a></p>
	
	<h2>Add Post</h2>

	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		$_POST = array_map( 'stripslashes', $_POST );

		//collect form data
		extract($_POST);

		//very basic validation
		if($postTitle ==''){
			$error[] = 'Please enter the title.';
		}

		if($postDesc ==''){
			$error[] = 'Please enter the description.';
		}

		if($postCont ==''){
			$error[] = 'Please enter the content.';
		}

		if(!isset($error)){

			try {
				$postSlug = slug($postTitle);

				//insert into database
				$stmt = $db->prepare('INSERT INTO blog_posts (postTitle,postDesc,postCont,postDate,postSlug,post_audio_url,post_author_id) VALUES (:postTitle, :postDesc, :postCont, :postDate, :postSlug, :post_audio_url, :post_author_id)') ;
				$stmt->execute(array(
					':postTitle' => $postTitle,
					':postDesc' => $postDesc,
					':postSlug' => $postSlug,
					':postCont' => $postCont,
					':post_audio_url' =>$audio,
					':post_author_id' =>$_SESSION['userID'],
					':postDate' => date('Y-m-d H:i:s')
				));

				//redirect to index page
				header('Location: profile.php?action=added');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo '<p class="error">'.$error.'</p>';
		}
	}
	?>
	
	
	<div class="container">
	
	<form action='' method='post' enctype="multipart/form-data" autocomplete="off" >
		
		<div class="row">
			<div class="cold-md-8-offset-2">
				<p><label>Title</label><br />
					<input type='text' name='postTitle' value='<?php if(isset($error)){ echo $_POST['postTitle'];}?>'></p>
			</div>
		</div>
<!--
		<div class="row">
			<div class="cold-md-8">
				
				<div class="avatar"><label>Select an image (Optional): </label><input type="file" name="avatar" accept="image/*"  /></div>
			</div>
		</div>
-->
	
		<div class="row">
			<div class="cold-md-8">
				<p><label>SoundCloud URL (embed) <code>this field is optional</code></label><br />
				<input type='text' name='audio' placeholder='<iframe>.......</iframe>'></p>
			</div>
		</div>			
		
		<div class="row">
			<div class="cold-md-8">
				<p><label>Description</label><br />
				<textarea name='postDesc' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postDesc'];}?></textarea></p>
			</div>
		</div>			
		<div class="row">
			<div class="cold-md-8">
				<p><label>Content</label><br />
				<textarea name='postCont' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postCont'];}?></textarea></p>
			</div>
		</div>
		<div class="row">
			<div class="cold-md-8">
				<input type='submit' name='submit' value='Submit' class="submit">
			</div>
		</div>
	</form>
		
	</div>

</div>
