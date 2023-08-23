<?php
	require_once("check_login.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add User</title>
</head>
<body>

	<style>
		a{
			color: #FFFFFF;
		}
		ul{
			background-color: #000000;
		}
		li{
			color: #FFFFFF;
			display: inline;
			margin: 30px;
		}
	</style>

	

	<hr>
		<ul>
			<li> <a href="index.php"> Home </a> </li>
			<li> <a href="add_user.php"> Add user </a> </li>
			<li> <a href="list_user.php"> list user </a> </li>
			<li> <?php echo "Welcome ", $user; ?> </li>
			<li> <a href="logout.php"> Logout </a> </li>
		</ul>
	<hr>

	<p style="margin-top: 50px; margin-left: 100px;">
		<h1>Add user in the database</h1>
	</p>
	<p style="margin-top: 50px; margin-left: 100px;">
		<table style="margin-left: 50px">
			<form action="add_user.php" method="post">
				<tr> <td> <label for="first_name"> First Name </label>                                                                         </td>
				     <td> <input style="margin-top: 10px;" type="text" name="first_name" minlength="1" placeholder="John">                     </td></tr>
				<tr> <td> <label for="last_name"> Last Name </label>                                                                           </td>
				     <td> <input style="margin-top: 10px;" type="text" name="last_name" minlength="1" placeholder="Doe">                       </td></tr>
				<tr> <td> <label for="email"> Email</label>                                                                                    </td>
				     <td> <input style="margin-top: 10px;" type="email" name="email" minlength="1" placeholder="example@domain.com">           </td></tr>
				<tr> <td> <label for="password"> Password </label>                                                                             </td>
				     <td> <input style="margin-top: 10px;" type="password" name="password" minlength="1">                                      </td></tr>
				<tr> <td> <label for="phone_no"> Phone Number</label>                                                                          </td>
				     <td> <input style="margin-top: 10px;" type="text" name="phone_no" minlength="10" maxlength="10" placeholder="0123456789"> </td></tr>
				<tr> <td> <input style="margin-top: 10px;" type="submit" name="submit" value="Create User">                                    </td></tr>
			</form>
		</table>
	</p>

	<p>
		<?php
	if(!($_SESSION['privilege'] == 'admin' || $_SESSION['privilege'] == 'add_user'))
	{
		die('Access denied');
	}
?>
<?php

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
					// echo " <h3> User $firstName $lastName has been created and added to database. </h3>";	
				}
				catch(\Throwable $e)
				{
					die("Error occured $e");
				}

				echo " <h3> User $firstName $lastName has been created and added to database. </h3>";
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
	<nav class="navbar fixed-top px-3" style="background-color: #B2B2B2;">
		<div class="d-flex align-items-center gap-3">
			<button type="button" class="btn btn-secondary" style="background-color: #3C4048;  --bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;">
				<a href="index.php" class="link-light">Home</a>
			</button>
			<button type="button" class="btn btn-secondary" style="background-color: #EAEAEA;  --bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;">
				<a href="add_user.php" class="link-dark">Add user</a>
			</button>
			<button type="button" class="btn btn-secondary" style="background-color: #3C4048;  --bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;">
				<a href="list_user.php" class="link-light">List user</a>
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
		<div class="container d-flex align-items-center justify-content-center pt-5">
			<div class=" d-flex justify-content-center align-items-center h-100" >
    			<div class="">
					<div class="card" style="border-radius: 1rem; align-items-center">
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
											<button class="btn btn-dark btn-lg btn-block" style="width: 15rem" name="submit" type="submit">Add user</button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<center><h5 style="padding-right: 5rem;">Bulk upload</h5></center>
						<div class="form-outline mb-4 d-flex align-items-center justify-content-center gap-5">
							<form action="add_user.php" method="post" enctype="multipart/form-data">
								<input class="btn btn-outline-dark" type="file" name="data">
								<button class="btn btn-dark btn-lg btn-block" type="submit" name="bulk_upload" value="Upload">Upload</button>
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

	<p>
		
	</p>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"></script>
</body>
</html>