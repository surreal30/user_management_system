<?php
	// Create a session
	session_start();
	// Create a new session ID. This helps in session hijacking. Everytime a new page is opened, new session ID is created.
	session_regenerate_id();

	// If user is already logged in then page is redirected to home page
	if(isset($_SESSION['user']))
	{
		header("location: http://localhost/admin");
		exit();
	}

	// Set session timeout of 30 mins
	$timeout = 60*30;
	$_SESSION['timeout'] = time() + $timeout;
	if(time() > $_SESSION['timeout'])
	{
		session_destroy();
		header("location: http://localhost/admin");
		exit();
	}

	// Assigns hashed value of HTTP_USER_AGENT from server environment to session environment
	$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);

	// Assign database secrets from environment to variables
	$dbHostName = getenv('MYSQL_HOST');
	$dbUser = getenv('MYSQL_USER');
	$dbPassword = getenv('MYSQL_PASSWORD');
	$dbName = getenv('MYSQL_DATABASE');

	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	// Create a database connection
	$mysqli = new mysqli($dbHostName, $dbUser, $dbPassword, $dbName, 3306);
	// Checks if the the connection was established or not. If not then error is displayed and script stops 
	if(!$mysqli)
	{
		die("<br> Could not connect to server");
	}

	// Check if the user has submitted the login form
	if(isset($_POST['username']))
	{
		// Validation of username and password
		if(!(preg_match('/^[A-Za-z][a-zA-Z0-9!@#$%^&*\-_]+$/', $_POST['username']) && preg_match('/^[0-9a-zA-z\-+$%^*&_#@!]+$/', $_POST['password'])))
		{
			die("Please enter correct information");
		}

		// Assign username and password to variable
		$userInputUsername = $_POST['username'];
		$userInputPassword = $_POST['password'];

		// Prepare, bind and execute query to check if user exists or not.
		$checkAdminQuery = $mysqli->prepare("SELECT * from admins where username = ? ");
		$checkAdminQuery->bind_param("s", $userInputUsername);
		$checkAdminQuery->execute();
		$results = $checkAdminQuery->get_result();
		if(empty($results))
		{
			die("User not found");
		}
		else
		{
			$adminRow = $results->fetch_assoc();

			// If user exists then verify if the password is correct or not.
			if(password_verify($userInputPassword, $adminRow['password']))
			{
				// If it then assign username to a session variable
				$_SESSION['user'] = $userInputUsername;
				// Splits the privilege string into a string and save it into a session variable
				$_SESSION['privilege'] = explode(', ', $adminRow['privilege']); 

				// Checks if the login page was redirected from any other page. If it was then it is redirected to the same page otherwise it is redirected to home page
				if(isset($_SESSION['referer_page']))
				{
					header("location:" . $_SESSION['referer_page']);
					exit();
				}
				else
				{
					header("location: http://localhost/admin");
					exit();
				}
			}
			// If password is wrong then set incorrectPassword variable to 1
			else
			{
				$incorrectPassword = 1;
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
	<title>Login</title>
</head>
<body>
	<!-- login page card -->
	<section class="d-flex justify-content-center align-items-center" >
		<div class="container d-flex align-items-center justify-content-center py-5" style="margin-top: 2rem">
	    	<div class=" d-flex justify-content-center align-items-center h-100" >
	    		<div class="">
	        		<div class="card border-primary" style="border-radius: 1rem; align-items-center">
	            		<div class="d-flex align-items-center" >
	            			<div class="p-4 p-lg-5 text-black d-flex align-items-center" style="align-items-center">

	            			<!-- login form -->
	                		<form action="http://localhost/admin/login" method="post">
			                	<div class="d-flex justify-content-center mb-3 pb-1">
			                    	<span class="h1 fw-bold mb-0">User Management System</span>
			                	</div>

			                	<h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Login into your account</h5>

			                	<div class="form-outline mb-3">
			                    	<input type="text" placeholder="Username" id="username" name="username" minlength="1" class="form-control form-control-lg" >
			                	</div>

			                	<div class="form-outline mb-3">
			                    	<input type="password" placeholder="Password" id="password" name="password" minlength="8" class="form-control form-control-lg" >
			                	</div>

			                	<div class="pt-1 mb-4">
			                    	<button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
			                	</div>
								<div class="pt-1 mb-4">
				                <?php 
				                	// if incorrectPassword was declred and initialised
					                if(isset($incorrectPassword))
					                {
					                	// If the value of incorrectPassword is 1 then incorrect password is incorrect
						                if ($incorrectPassword == 1)
						                {
						                	echo "<h4>Incorrect password</h4>";	
						                }
						            }
				                ?>
			                	</div>
			                </form>
	            			</div>
	            		</div>
		    		</div>
		    	</div>
			</div>
		</div>
	</section>

	<!-- CDN links for bootstrap -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>