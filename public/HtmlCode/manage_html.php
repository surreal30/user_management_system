<?php

	// HTML code for creating the HTML structure and CDN links of bootstrap CSS
	function htmlBeginning($title)
	{
		echo <<<HTMLBEGINNING
			<!DOCTYPE html>
			<html>
			<head>
				<meta charset="utf-8">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
				<title>$title</title>
			</head>
			<body>
		HTMLBEGINNING;
	}

	// Navbar which creates active current page link depending on the link
	function navbar($user, $page)
	{
		echo "<nav class='navbar navbar-expand-lg navbar-light bg-light px-4'>
				<div class='collapse navbar-collapse d-flex align-items-center gap-3' id='navbarNavDropdown'>
				<ul class='navbar-nav'>";
		switch ($page)
		{
			case 'index':
				echo <<<ACTIVELINKS
					<li class="nav-item">
						<a class="nav-link active" href="http://localhost/admin">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="http://localhost/admin/users/add">Add User</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="http://localhost/admin/users">List User</a>
					</li>
				ACTIVELINKS;
				break;
			
			case 'addUser':
				echo <<<ACTIVELINKS
					<li class="nav-item">
						<a class="nav-link" href="http://localhost/admin">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="http://localhost/admin/users/add">Add User</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="http://localhost/admin/users">List User</a>
					</li>
				ACTIVELINKS;
				break;

			case 'listUser':
				echo <<<ACTIVELINKS
					<li class="nav-item">
						<a class="nav-link" href="http://localhost/admin">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="http://localhost/admin/users/add">Add User</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="http://localhost/admin/users">List User</a>
					</li>
				ACTIVELINKS;
				break;

			case 'editUser':
				echo <<<ACTIVELINKS
					<li class="nav-item">
						<a class="nav-link" href="http://localhost/admin">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="http://localhost/admin/users/add">Add User</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="http://localhost/admin/users">List User</a>
					</li>
				ACTIVELINKS;
				break;

			case 'deleteUser':
				echo <<<ACTIVELINKS
					<li class="nav-item">
						<a class="nav-link" href="http://localhost/admin">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="http://localhost/admin/users/add">Add User</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="http://localhost/admin/users">List User</a>
					</li>
				ACTIVELINKS;
				break;
		}
		echo <<<NAVBAR
			</ul>
				</div>
				<div class="d-flex align-items-right gap-3">
					<ul class="navbar-nav">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Welcome $user
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
								<a class="dropdown-item" href="http://localhost/admin/logout">Logout</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>
		NAVBAR;
	}

	// Welcome message on home page
	function welcomeMessage()
	{
		echo "<p class='text-dark' style='margin-top: 5rem;'> <center> <h1>Welcome to User Management System.</h1> </center> </p>";
	}

	// HTML code for the end of the HTML structure and CDN links of bootstrap CSS
	function htmlEnding()
	{
		echo <<<HTMLENDING
				<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
				<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
				<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
			</body>
			</html>
		HTMLENDING;
	}