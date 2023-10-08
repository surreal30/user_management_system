<?php
	// Check if user is logged in or not. Also checks for time out and HTTP_USER_AGENT
	require_once("manage_login_session.php");
	require_once("DatabaseOperation.php");

	// Checks authorisation
	if(!(in_array("delete_user", $_SESSION['privilege'])))
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

	<!-- Navbar using bootstrap css -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
		<div class="collapse navbar-collapse d-flex align-items-center gap-3" id="navbarNavDropdown">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="http://localhost/admin">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link " href="http://localhost/admin/users/add">Add User</a>
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
						<a class="dropdown-item" href="logout.php">Logout</a>
					</div>
				</li>
			</ul>
		</div>
	</nav> 

	<?php
		// Takes user ID from url
		$pathComponents = explode('/', $_SERVER['REQUEST_URI']);
		$id=$pathComponents[3];

		// Create database connection
		$databaseConnection = new DatabaseOperation();

		// Checks if the id is number or not. If it is not error is displayed.
		if(!(preg_match('/^[0-9]*$/', $id)))
		{
			echo "<center><h4><a class='page-link' style='margin-top: 3rem;'> Invalid user ID! Please go back to list user page and select a valid user. </a></h4></center> ";
			exit();
		}

		// Check if user exists or not
		$user = $databaseConnection->getUser($id);
		if($user == false)
		{
			die("Some error occured");
		}	
		
		$userRow = $user->fetch_assoc();
		if($userRow == 0)
		{
			echo "<center><h4><a class='page-link' style='margin-top: 3rem;'> This user does not exist. Go back to list user page and select another user. </a></h4></center>";
			exit();
		}

		// Delete user
		$userDeleted = $databaseConnection->deleteUser($id);
		if($userDeleted == false)
		{
			die("Some error occured");
		}
		elseif($userDeleted == true)
		{
			echo "<center><h4 class='pt-3'> User has been deleted. </h4></center";
		}
	?>
	
	<!-- CDN links for bootstrap CSS -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>