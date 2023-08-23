<?php
	require_once("check_login.php");
	if(!($_SESSION['privilege'] == 'admin' || $_SESSION['privilege'] == 'add_user'))
	{
		die('Access denied');
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
<body style="background-color: #EAEAEA; padding-top: 4rem;">
	<nav class="navbar px-3 fixed-top" style="background-color: #B2B2B2">
		<div class="d-flex align-items-center gap-3">
			<button type="button" class="btn btn-secondary" style="background-color: #3C4048;  --bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;">
				<a href="index.php" class="link-light">Home</a>
			</button>
			<button type="button" class="btn btn-secondary" style="background-color: #3C4048;  --bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;">
				<a href="add_user.php" class="link-light">Add user</a>
			</button>
			<button type="button" class="btn btn-secondary" style="background-color: #EAEAEA;  --bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;">
				<a href="list_user.php" class="link-dark">List user</a>
			</button>
		</div>
		<div class="d-flex align-items-right gap-3">
			<div class="d-flex align-items-center">
				<?php echo "Welcome ", $user; ?>
			</div>
		
			<button type="button" class="btn btn-secondary" style="background-color: #3C4048;  --bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;">
				<a href="logout.php" class="link-light">Logout</a>
			</button>
		</div>
	</nav>



	<section class="d-flex justify-content-center align-items-center" style="background-color: #EAEAEA; height: 100vh;">
		<div class="container d-flex align-items-center justify-content-center py-5">
	    	<div class=" d-flex justify-content-center align-items-center h-100" >
		    	<div class="">
		        	<div class="card" style="border-radius: 1rem; align-items-center">
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
				                    		<button class="btn btn-dark btn-lg btn-block" style="width: 15rem" type="submit">Update user</button>
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
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"></script>
</body>
</html>