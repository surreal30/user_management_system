<?php
	require_once("check_login.php");
	if(!($_SESSION['privilege'] == 'admin' || $_SESSION['privilege'] == 'add_user'))
	{
		die('Access denied');
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
	<nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
		<div class="collapse navbar-collapse d-flex align-items-center gap-3" id="navbarNavDropdown">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="http://localhost:8080/admin">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link " href="http://localhost:8080/admin/users/add">Add User</a>
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
						<a class="dropdown-item" href="logout.php">Logout</a>
					</div>
				</li>
			</ul>
		</div>
	</nav> 

	<?php

		$pathComponents = explode('/', $_SERVER['REQUEST_URI']);
		$id=$pathComponents[3];
		if(!(preg_match('/^[0-9]*$/', $id)))
		{
			echo "<center><h4><a class='page-link' style='margin-top: 3rem;'> Invalid user ID! Please go back to list user page and select a valid user. </a></h4></center> ";
			exit();
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

		$selectUserQuery = $mysqli->prepare("SELECT * FROM users where id = ?");
		$selectUserQuery->bind_param("s", $id);
		$selectUserQuery->execute();

		$result = $selectUserQuery->get_result();
		if(mysqli_num_rows($result) == 0)
		{
			echo "<center><h4><a class='page-link' style='margin-top: 3rem;'> This user does not exist. Go back to list user page and select another user. </a></h4></center>";
			exit();

		}

		$deleteUserQuery = $mysqli->prepare("DELETE FROM users WHERE id = ?");
		$deleteUserQuery->bind_param("s", $id);

		try
		{
			$deleteUserQuery->execute();
		}
		catch(\Throwable $e)
		{
			die("Error caught $e");
		}

		echo "<h4 class='pt-3'> User ", $currentRow['first_name'], " ", $currentRow['last_name'], " has been deleted. </h4>";
	?>
	
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>