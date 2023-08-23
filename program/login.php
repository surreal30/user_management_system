<?php
	session_start();
	session_regenerate_id();
	if(isset($_SESSION['user']))
	{
		header("location: index.php");
	}

	$timeout = 60*30;
	$_SESSION['timeout'] = time() + $timeout;
	if(time() > $_SESSION['timeout'])
	{
		session_destroy();
		header("location: login.php");
	}

	$serverName = getenv('MYSQL_HOST');
	$user = getenv('MYSQL_USER');
	$dbPassword = getenv('MYSQL_PASSWORD');
	$dbName = getenv('MYSQL_DATABASE');

	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$mysqli = new mysqli($serverName, $user, $dbPassword, $dbName, 3306);
	if(!$mysqli)
	{
		die("<br> Could not connect to server");
	}


	if(isset($_POST['username']))
	{
		$inputUsername = $_POST['username'];
		$inputPassword = $_POST['password'];

		$adminQuery = $mysqli->prepare("SELECT * from admin_table where username = ? ");
		$adminQuery->bind_param("s", $inputUsername);
		$adminQuery->execute();
		$results = $adminQuery->get_result();
		if(empty($results))
		{
			die("User not found");
		}
		else
		{
			$adminRow = $results->fetch_assoc();

			if(password_verify($inputPassword, $adminRow['password']))
			{
				$_SESSION['user'] = $inputUsername;
				// $_SESSION['privilege'] = $adminRow['privilege']; 

				if(isset($_SESSION['referer_page']))
				{
					header("location:" . $_SESSION['referer_page']);
				}
				else
				{
					header("location: index.php");
				}
			}
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
<body style="background-color: #EAEAEA;">
	<section class="d-flex justify-content-center align-items-center" style="background-color: #9E9FA5; height: 100vh;">
		<div class="container d-flex align-items-center justify-content-center py-5">
	    	<div class=" d-flex justify-content-center align-items-center h-100" >
	    		<div class="">
	        		<div class="card" style="border-radius: 1rem; align-items-center">
	            		<div class="d-flex align-items-center" >
	            			<div class="p-4 p-lg-5 text-black d-flex align-items-center" style="align-items-center">

	                		<form action="/login.php" method="post">
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
			                    	<button class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
			                	</div>
								<div class="pt-1 mb-4">
				                <?php 
					                if(isset($incorrectPassword))
					                {
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

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"></script>
</body>
</html>