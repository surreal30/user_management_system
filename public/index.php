<?php
	require_once("check_login.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
	<title>User Management System</title>
</head>
<body>
	<!-- Navbar using bootstrap CSS -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
		<div class="collapse navbar-collapse d-flex align-items-center gap-3" id="navbarNavDropdown">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link active" href="http://localhost:8080/admin">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link " href="http://localhost:8080/admin/users/add">Add User</a>
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

	<p class="text-dark" style="margin-top: 5rem;"> <center> <h1>Welcome to User Management System.</h1> </center> </p>

	<!-- CDN links for bootstrap CSS -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	
</body>
</html>