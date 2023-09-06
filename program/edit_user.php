<?php
	// Check if user is logged in or not. Also checks for time out and HTTP_USER_AGENT
	require_once("check_login.php");

	// Checks authorisation
	if(!(in_array("admin_perm", $_SESSION['privilege']) || in_array("edit_user", $_SESSION['privilege'])))
	{
		$denyAccess = 1;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
	<title>Add User</title>
</head>
<body>

	<!-- navbar using bootstrap css -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
		<div class="collapse navbar-collapse d-flex align-items-center gap-3" id="navbarNavDropdown">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="http://localhost:8080/admin">Home</a>
				</li>
				
				<li class="nav-item">
					<a class="nav-link" href="http://localhost:8080/admin/users/add">Add User</a>
				</li>
				
				<li class="nav-item">
					<a class="nav-link active" href="http://localhost:8080/admin/users">List User</a>
				</li>
			</ul>
		</div>
		<div class="d-flex align-items-right gap-3">
			<ul class="navbar-nav">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php echo "Welcome, ", $user; ?>
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
						<a class="dropdown-item" href="http://localhost:8080/admin/logout">Logout</a>
					</div>
				</li>
			</ul>
		</div>
	</nav>

	<?php
		// Checks if the denyAccess variable was declared and initialized. If it was and it's value is 1 then exit the script
		if(isset($denyAccess))
		{
			if($denyAccess == 1)
			{
				die("<center><h4 style='padding-top: 2rem'>Access Denied</h4></center>");
			}
		}

		// Takes user ID from the url
		$pathComponents = explode('/', $_SERVER['REQUEST_URI']);
		$id=$pathComponents[3];

		// Checks if the id is number or not. If it is not error is displayed.
		if(!(preg_match('/^\d[0-9]*$/', $id)))
		{
			echo "<center><h4><a class='page-link' style='margin-top: 3rem;'> Invalid user ID! Please go back to list user page and select a valid user. </a></h4></center> ";
			exit();
		}

		// Assigns database secrets from environment
		$serverName = getenv('MYSQL_HOST');
		$dbUser = getenv('MYSQL_USER');
		$dbPassword = getenv('MYSQL_PASSWORD');
		$dbName = getenv('MYSQL_DATABASE');

		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

		// Create a database connection
		$mysqli = new mysqli($serverName, $dbUser, $dbPassword, $dbName, 3306);

		// Checks if the the connection was established or not. If not then error is displayed and script stops 
		if(!$mysqli)
		{
			die("<br> Could not connect to server");
		}

		$editUserQuery = $mysqli->prepare("SELECT * FROM users where id = ?");
		$editUserQuery->bind_param("s", $id);
		$editUserQuery->execute();
		$result = $editUserQuery->get_result();
		if(mysqli_num_rows($result) == 0)
		{
			echo "<center><h4><a class='page-link' style='margin-top: 3rem;'> This user does not exist. Go back to list user page and select another user. </a></h4></center>";
			exit();
		}
		$currentRow = $result->fetch_assoc();
	?>

	<!-- Edit user form with prepopulated data from database -->
	<section class="d-flex justify-content-center align-items-center" >
		<div class="container d-flex align-items-center justify-content-center py-5" style="margin-top: 5rem;">
	    	<div class=" d-flex justify-content-center align-items-center h-100" >
		    	<div class="">
		        	<div class="card border-primary" style="border-radius: 1rem; align-items-center">
		            	<div class="d-flex align-items-center" >
		            		<div class="p-4 p-lg-5 text-black d-flex align-items-center" style="align-items-center">
		                		<form action="edit_user.php" method="post">
				                	<div class="d-flex justify-content-center mb-3 pb-1">
				                    	<span class="h1 fw-bold mb-0">Update user</span>
				                	</div>
		                  
				                	<div class="form-outline mb-3">
				                  		<div class="row mb-4">
						                  	<div class="col">
							                    <input type="text" placeholder="First Name" id="first_name" name="first_name" minlength="1" value= "<?php echo $currentRow['first_name'] ?>" class="form-control form-control-lg" >
							                </div>
					                		
					                		<div class="col">
					                    		<input type="text" placeholder="Last Name" id="last_name" name="last_name" minlength="1" value="<?php echo $currentRow['last_name'] ?>" class="form-control form-control-lg" >
						                	</div>
					            		</div>

					                	<div class="form-outline mb-3">
					                    	<input type="email" placeholder="Email ID" id="email" name="email" minlength="1" value="<?php echo $currentRow['email'] ?>" class="form-control form-control-lg" >
						            	</div>

					                	<div class="form-outline mb-3">
					                    	<input type="text" placeholder="Phone No" id="phone_no" name="phone_no" minlength="10" maxlength="10" value="<?php echo $currentRow['phone_no'] ?>" class="form-control form-control-lg" >
					                	</div>

					                	<div class="d-flex pt-1 mb-4 justify-content-center align-items-center">
				                    		<button class="btn btn-primary btn-lg btn-block" style="width: 15rem" type="submit">Update user</button>
						              	</div>
						            </div>
				            	</form>
					    	</div>
		    			</div>
		    		</div>
				</div>
			</div>
		</div>
	</section>

	<?php

		// Checks if the form was submitted or not.
		if(isset($_POST['first_name']))
		{
			// Assigns value from header to variables
			$firstName = $_POST['first_name'];
			$lastName = $_POST['last_name'];
			$email = $_POST['email'];
			$phoneNo = $_POST['phone_no'];	

			// Prepare query statement
			$editUserQuery = $mysqli->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, updated_at = NOW(), phone_no = ?  WHERE id = ?");

			// Bind params and execute the query. If error occurs the script stops and error is displayed.
			try
			{
				$editUserQuery->bind_param("sssss", $firstName, $lastName, $email, $phoneNo, $id);
				$editUserQuery->execute();	
			}
			catch(\Throwable $e)
			{
				die("Error occured $e");
			}

			// Display that user has been successfully updated
			echo " <h3> User $firstName $lastName has been updated. </h3>";
		}
	?>

	<!-- CDN links for bootstrap CSS -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>