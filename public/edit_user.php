<?php
	// Check if user is logged in or not. Also checks for time out and HTTP_USER_AGENT
	require_once("manage_login_session.php");
	require_once("DatabaseOperation.php");

	// Checks authorisation
	if(!(in_array("edit_user", $_SESSION['privilege'])))
	{
		die("Access Denied");
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
					<a class="nav-link" href="http://localhost/admin">Home</a>
				</li>
				
				<li class="nav-item">
					<a class="nav-link" href="http://localhost/admin/users/add">Add User</a>
				</li>
				
				<li class="nav-item">
					<a class="nav-link active" href="http://localhost/admin/users">List User</a>
				</li>
			</ul>
		</div>
		<div class="d-flex align-items-right gap-3">
			<ul class="navbar-nav">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php echo "Welcome, ", $sessionUser; ?>
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
						<a class="dropdown-item" href="http://localhost/admin/logout">Logout</a>
					</div>
				</li>
			</ul>
		</div>
	</nav>

	<?php
		// Takes user ID from the url
		$pathComponents = explode('/', $_SERVER['REQUEST_URI']);
		$id=$pathComponents[3];

		// Create a database connection
		$database = new DatabaseOperation();

		// Checks if the id is number or not. If it is not error is displayed.
		if(!(preg_match('/^\d[0-9]*$/', $id)))
		{
			echo "<center><h4><a class='page-link' style='margin-top: 3rem;'> Invalid user ID! Please go back to list user page and select a valid user. </a></h4></center> ";
			exit();
		}

			// Checks if the form was submitted or not.
		if(isset($_POST['first_name']))
		{
			// Assigns value from header to variables
			$firstName = $_POST['first_name'];
			$lastName = $_POST['last_name'];
			$email = $_POST['email'];
			$phoneNo = $_POST['phone_no'];	

			$updateUser = $database->updateUser($firstName, $lastName, $email, $phoneNo, $id);
			if($updateUser == -1)
			{
				die("Some error occured");
			}
		}

		// Get user information to prepopulate the edit user table
		$currentRow = $database->getUser($id);
		if(is_int($currentRow))
		{
			if($currentRow == 0)
			{
				echo "<center><h4><a class='page-link' style='margin-top: 3rem;'> This user does not exist. Go back to list user page and select another user. </a></h4></center>";
				exit();
			}
			elseif ($currentRow == -1)
			{
				die("Some error occured");
			}
		}

	?>

	<!-- Edit user form with prepopulated data from database -->
	<section class="d-flex justify-content-center align-items-center" >
		<div class="container d-flex align-items-center justify-content-center py-5" style="margin-top: 5rem;">
	    	<div class=" d-flex justify-content-center align-items-center h-100" >
		    	<div class="">
		        	<div class="card border-primary" style="border-radius: 1rem; align-items-center">
		            	<div class="d-flex align-items-center" >
		            		<div class="p-4 p-lg-5 text-black d-flex align-items-center" style="align-items-center">
		                		<form action="http://localhost/admin/users/<?php echo $id;?>/edit" method="post">
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

		// Checks if the update_user function return 1 or not. If it is 1 then the user was updated
		if(isset($updateUser))
		{	
			if($updateUser == 1)
			{
				echo " <h3> User $firstName $lastName has been updated. </h3>";	
			}
		}
	?>

	<!-- CDN links for bootstrap CSS -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>