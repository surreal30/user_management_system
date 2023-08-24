<?php
	require_once("check_login.php");
	if(!($_SESSION['privilege'] == 'admin' || $_SESSION['privilege'] == 'add_user'))
	{
		die('Access denied');
	}
	$serverName = getenv('MYSQL_HOST');
	$dbUser = getenv('MYSQL_USER');
	$dbPassword = getenv('MYSQL_PASSWORD');
	$dbName = getenv('MYSQL_DATABASE');

	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	$mysqli = new mysqli($serverName, $dbUser, $dbPassword, $dbName, 3306);
	if(!$mysqli)
	{
		die("<br> Could not connect to server");
	}

	if(!isset($_GET['id']))
	{
		header("location: list_user.php");
	}
	else
	{
		$id = $_GET['id'];
	}

	$editUserQuery = $mysqli->prepare("SELECT * FROM users where id = ?");
	$editUserQuery->bind_param("s", $id);
	$editUserQuery->execute();
	$result = $editUserQuery->get_result();
	$currentRow = $result->fetch_assoc();
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
	<nav class="navbar px-3 fixed-top" >
			<div class="d-flex align-items-center gap-3">
				<a href="index.php" class="btn btn-primary" role="button" data-bs-toggle="button">Home</a>
				<a href="add_user.php" class="btn btn-primary" role="button" data-bs-toggle="button">Add user</a>
				<a href="list_user.php" class="btn btn-outline-primary" role="button" data-bs-toggle="button">List user</a>
			</div>

			<div class="d-flex align-items-right gap-3">
				<div class="dropdown">
					<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
							<?php echo "Welcome ", $user; ?>
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item" href="logout.php">Logout &nbsp; <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/> <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/> </svg></a>

					</div>
				</div>
			</div>
		</nav> 

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

	</p>
	<?php
		if(isset($_POST['first_name']))
		{
			$firstName = $_POST['first_name'];
			$lastName = $_POST['last_name'];
			$email = $_POST['email'];
			$phoneNo = $_POST['phone_no'];	

			$editUserQuery = $mysqli->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, updated_at = NOW(), phone_no = ?  WHERE id = ?");

			try
			{
				$editUserQuery->bind_param("sssss", $firstName, $lastName, $email, $phoneNo, $id);
				$editUserQuery->execute();	
			}
			catch(\Throwable $e)
			{
				die("Error occured $e");
			}
			echo " <h3> User $firstName $lastName has been updated. </h3>";
		}
	?>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>