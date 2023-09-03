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
		die("\n Database not connected");
	}

	if(isset($_POST['first_name']))
	{
		if(preg_match('/^[A-Z][a-z]+$/', $_POST['first_name']) && preg_match('/^[A-Z][a-z]+$/', $_POST['last_name']) && preg_match('/^[a-zA-Z0-9][a-zA-Z0-9]*([_#$+*&{}=%^\/\-.!]*[a-zA-Z0-9])*@[a-zA-Z]*\.\w[a-zA-Z]*\.?\w[a-zA-Z]*$/', $_POST['email']) && preg_match('/^[0-9a-zA-z\-+$%^*&_#@!]+$/', $_POST['password']) && preg_match('/^[0-9]+$/', $_POST['phone_no']))
		{
			$queryStatement = $mysqli->prepare("INSERT INTO users (id, first_name, last_name, email, created_at, updated_at, phone_no, password) value (0, ?, ?, ?, NOW(), NOW(), ?, ?)");
			$firstName = $_POST['first_name'];
			$lastName = $_POST['last_name'];
			$email = $_POST['email'];
			$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
			$phoneNo = $_POST['phone_no'];

			try
			{
				$queryStatement->bind_param("sssss", $firstName, $lastName, $email, $phoneNo, $password);
				$queryStatement->execute();
			}
			catch(\Throwable $e)
			{
				die("Error occured $e");
			}
			$userCreated = 1;
		}
		else
		{
			die("Please enter correct information");
		}
		
	}

	if(isset($_POST['bulk_upload']))
	{
		if(is_uploaded_file($_FILES['data']['tmp_name']))
		{
			if($_FILES['data']['type'] == 'application/json')
			{
				$userFile = $_FILES['data']['tmp_name'];
				$fileContent = file_get_contents($userFile);
				try
				{
					$fileData = json_decode($fileContent, TRUE);
				}
				catch(\Throwable $e)
				{
					die("Error occured $e. Check if uploaded file is valid json file or not.");
				}

				foreach ($fileData as $user)
				{
					$firstName = $user['first_name'];
					$lastName = $user['last_name'];
					$email = $user['email_id'];
					$password = password_hash($user['password'], PASSWORD_DEFAULT);
					$phoneNo = $user['mobile_no'];

					$queryStatement = $mysqli->prepare("INSERT INTO users (id, first_name, last_name, email, created_at, updated_at, phone_no, password) value (0, ?, ?, ?, NOW(), NOW(), ?, ?)");

					try
					{
						$queryStatement->bind_param("sssss", $firstName, $lastName, $email, $phoneNo, $password);
						$queryStatement->execute();
					}
					catch(\Throwable $e)
					{
						die("Error occured $e");
					}
				}
				$bulkUserCreated = 1;
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
	<title>Add User</title>
</head>
<body >
	<nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
		<div class="collapse navbar-collapse d-flex align-items-center gap-3" id="navbarNavDropdown">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="http://localhost:8080/admin">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" href="http://localhost:8080/admin/users/add">Add User</a>
				</li>
				<li class="nav-item">
					<a class="nav-link " href="http://localhost:8080/admin/users">List User</a>
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


	<section class="d-flex justify-content-center align-items-center">
		<div class="container d-flex align-items-center justify-content-center pt-5" style="margin-top: 5rem;">
			<div class=" d-flex justify-content-center align-items-center h-100" >
    			<div class="">
					<div class="card border-primary" style="border-radius: 1rem; align-items-center">
						<div class="d-flex align-items-center" >
							<div class="pt-4 px-4 text-black d-flex align-items-center" style="align-items-center">
								<form action="add_user.php" method="post">
									<div class="d-flex justify-content-center mb-3 pb-1">
										<span class="h1 fw-bold mb-0">Add user</span>
									</div>
                  
									<div class="form-outline mb-3">
										<div class="row mb-4">
											<div class="col">
												<input type="text" placeholder="First Name" id="first_name" name="first_name" minlength="1" class="form-control form-control-lg" >
											</div>
											<div class="col">
												<input type="text" placeholder="Last Name" id="last_name" name="last_name" minlength="1" class="form-control form-control-lg" >
											</div>
										</div>

										<div class="form-outline mb-3">
											<input type="email" placeholder="Email ID" id="email" name="email" minlength="1" class="form-control form-control-lg" >
										</div>

										<div class="form-outline mb-3">
											<input type="password" placeholder="Password" id="password" name="password" minlength="8" class="form-control form-control-lg" >
										</div>

										<div class="form-outline mb-3">
											<input type="text" placeholder="Phone No" id="phone_no" name="phone_no" minlength="10" maxlength="10" class="form-control form-control-lg" >
										</div>

										<div class="d-flex pt-1 mb-4 justify-content-center align-items-center">
											<button class="btn btn-primary btn-lg btn-block" style="width: 15rem" name="submit" type="submit">Add user</button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<center>
							<hr class="hr hr-blurry" style="width: 28rem">
								<h5 style="padding-right: 5rem; padding-top: 1rem;">
									Bulk upload
								</h5>
						</center>
						<div class="form-outline mb-4 d-flex align-items-center justify-content-center gap-5">
							<form action="add_user.php" method="post" enctype="multipart/form-data">
								<input class="btn btn-outline-dark" type="file" name="data">
								<button class="btn btn-primary btn-lg btn-block" type="submit" name="bulk_upload" value="Upload">Upload</button>
							</form>
						</div>
						<center><h6 style="padding-right: 5rem; padding-bottom: 1rem;">Upload only JSON format</h6></center>

						<?php
							if(isset($userCreated))
							{
								if($userCreated == 1)
								{
									echo "<center><h4 class='px-4' style='padding- right: 5rem; padding-bottom: 1rem;'> $firstName $lastName has been created and added to database</h4></center>";
								}
							}

							if(isset($bulkUserCreated))
							{
								if($bulkUserCreated)
								{
									echo "<center><h4 style='padding-right: 5rem; padding-bottom: 1rem;'>The users have been created and added to database</h4></center>";
								}
							}
						?>

					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>