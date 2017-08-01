<?php
//include config
require_once('../includes/config.php');


//check if already logged in
if( $user->is_logged_in() ){ header('Location: index.php'); } 
?>



<!DOCTYPE html>

<html lang="en"> 
    <head>
       <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>UBlog</title>
		
		<!-- Custom CSS -->
		<link href="../style/Formstyle.css" rel='stylesheet' type='text/css' />
		<!-- font CSS --><!--
		<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
		<link href="//fonts.googleapis.com/css?family=Archivo+Black" rel="stylesheet">-->
		
		<link href="//fonts.googleapis.com/css?family=Signika:300,400,700" rel="stylesheet">
		<link href="//fonts.googleapis.com/css?family=Roboto+Condensed:400,700" rel="stylesheet">
    </head>

	<body class="dashboard-page">
		<div class="main-grid">
			<div class="agile-grids">	
				<!-- validation -->
				<div class="grids">
					<div class="progressbar-heading grids-heading">
						<h2>UBLOG</h2>
					</div>
					
					<div class="forms-grids">
						<div class="forms3">
						<div class="w3agile-validation w3ls-validation">
							<div class="panel panel-widget agile-validation register-form">
								<div class="validation-grids widget-shadow" data-example-id="basic-forms"> 
									<div class="input-info">
										<h3>Register Form :</h3>
									</div>
									<div class="form-body form-body-info">
										
										<form data-toggle="validator" novalidate="" action='#' method='POST'>
											<div class="form-group valid-form">
												<input type="text" class="form-control"  name="User_name" placeholder="fullname" required="">
												
												
											</div>
											<div class="form-group valid-form">
												<input type="text" class="form-control" id="inputName" name="Username" placeholder="Username" required="">
												
											</div>
											<div class="form-group has-feedback">
												<input type="email" class="form-control inputEmail" name="UEmail" placeholder="Email" data-error="That email address is invalid" required="">
												<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
												<span class="help-block with-errors">Please enter a valid email address</span>
											</div>
											<div class="form-group">
											  <input type="password" data-toggle="validator" data-minlength="6" class="form-control inputPassword" name="Upassword" placeholder="Password" required="">
											  <span class="help-block">Minimum of 6 characters</span>
											</div>
											<div class="form-group">
											  <input type="password" class="form-control" id="inputPasswordConfirm" data-match=".inputPassword" data-match-error="Whoops, these don't match" name="Confirm password" placeholder="Confirm password" required="">
											  <div class="help-block with-errors"></div>
											</div>
											
												<?php
																$message='';
																//process login form if submitted
																if(isset($_POST['submit']))
																{
																	
																	$usr = trim($_POST['Username']);
																	
																					
																	
																	// check if the user already exsist in database 
																	if(!$user->check_exsistence($usr))
																	{ 
																	
																		// extract all submited fields
																			$usr = trim($_POST['Username']);
																			$name =trim( $_POST['User_name']);
																			$email=trim($_POST['UEmail']);
																			$password=trim($_POST['Upassword']);
																					
																	
																		
																		$hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);
																		
																		//Now begin Registration Process
																		$user->register($name,$usr,$hashedpassword,$email);
																		
																		
																		
																		
																		
																	
																		
																		
																		
																		
																		
																	} 
																	//in this case the user already  exsist and a message will be shown to the user
																	else {
																		 $message = '<p class="error">user already exsist</p>';
																		echo $message;
																	}

																}//end if submit
															
															
														
														?>	
											
												<input type="submit" name="submit" value="register" />
											
										</form>
									</div>
								</div>
							</div>
							
							<div class="panel panel-widget agile-validation">
								<div class="validation-grids validation-grids-right login-form">
									<div class="widget-shadow login-form-shadow" data-example-id="basic-forms"> 
										<div class="input-info">
											<h3>Login form :</h3>
										</div>
										<div class="form-body form-body-info">
											<form data-toggle="validator" action="#" method="post">
												<div class="form-group has-feedback">
													<input type="text" class="form-control inputEmail" name="Login_usr" placeholder="Enter You Username" data-error="Please enter username" required="">
													<div class="help-block with-errors"></div>
												</div>
												<div class="form-group">
													<input type="password" data-toggle="validator"  class="form-control inputPassword" name="Login_pwd" placeholder="Password" data-error="Please enter password" required="">
													<div class="help-block with-errors"></div>
												</div>
												<div class="bottom">
													
													<div class="form-group">
														<?php
																$message='';
																//process login form if submitted
																if(isset($_POST['do_login'])){

																	$username = trim($_POST['Login_usr']);
																	$password = trim($_POST['Login_pwd']);

																	if($user->login($username,$password))
																	{ 
																		//logged in return to index page
																		$_SESSION["username"]= $username;
																		//logged in return to index page
																		if($username == 'demo') {header('Location: index.php');}
																		else {header('Location: profile.php');}
																		exit;

																		
																		
																		
																	} else {
																		$message = '<p class="error">Wrong username or password</p>';
																	}

																}//end if submit
																else {$message='';}

																if(isset($message)){ echo $message; }
														?>
														
														<input type="submit" name="do_login" value="login" />
														
													</div><br />
													<a class="anonymous" href="../index.php">Continue as anonymos</a>
													<div class="clearfix"> </div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="clear"> </div>
						</div>
					</div>
				</div>
				<!-- //validation -->
			</div>
		</div>
		
		<script type="text/javascript" src="../js/jquery.min.js"></script>
		<script type="text/javascript" src="../js/valida.2.1.6.min.js"></script>
		<script type="text/javascript" >

			$(document).ready(function() {

				// show Valida's version.
				$('#version').valida( 'version' );

				// Exemple 1
			$('.valida').valida();

				// Exemple 2
				
//				$('.valida').valida({
//
//					// basic settings
//					validate: 'novalidate',
//					autocomplete: 'off',
//					tag: 'p',
//
//					// default messages
//					messages: {
//						submit: 'Wait ...',
//						required: 'Este campo é obrigatório',
//						invalid: 'Field with invalid data',
//						textarea_help: 'Digitados <span class="at-counter">{0}</span> de {1}'
//					},
//
//					// filters & callbacks
//					use_filter: true,
//
//					// a callback function that will be called right before valida runs.
//					// it must return a boolan value (true for good results and false for errors)
//					before_validate: null,
//
//					// a callback function that will be called right after valida runs.
//					// it must return a boolan value (true for good results and false for errors)
//					after_validate: null
//
//				});
				

        // setup the partial validation
				$('#partial-1').on('click', function( ev ) {
					ev.preventDefault();
					$('#res-1').click(); // clear form error msgs
					$('form').valida('partial', '#field-1'); // validate only field-1
					$('form').valida('partial', '#field-1-3'); // validate only field-1-3
				});
				$(".error").fadeOut( 5000 );

			});

		</script>
		<!-- //input-forms -->
		<!--validator js-->
		<script src="../js/validator.min.js"></script>
		<!--//validator js-->
		
	</body>
</html>