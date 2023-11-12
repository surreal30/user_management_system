<?php
	require_once("DatabaseOperation.php");
	// Create a session
	session_start();
	// Create a new session ID. This helps in session hijacking. Everytime a new page is opened, new session ID is created.
	session_regenerate_id();

	// If user is already logged in then page is redirected to home page
	if(isset($_SESSION['user']))
	{
		header("location: http://localhost/admin");
		exit();
	}

	// Set session timeout of 30 mins
	$timeout = 60*30;
	$_SESSION['timeout'] = time() + $timeout;
	if(time() > $_SESSION['timeout'])
	{
		session_destroy();
		header("location: http://localhost/admin");
		exit();
	}

	// Assigns hashed value of HTTP_USER_AGENT from server environment to session environment
	$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);

	// Assign database secrets from environment to variables
	$dbHostName = getenv('MYSQL_HOST');
	$dbUser = getenv('MYSQL_USER');
	$dbPassword = getenv('MYSQL_PASSWORD');
	$dbName = getenv('MYSQL_DATABASE');

	$database = new DatabaseOperation();

	// Check if the user has submitted the login form
	if(isset($_POST['username']))
	{
		// Validation of username and password
		if(!(preg_match('/^[A-Za-z][a-zA-Z0-9!@#$%^&*\-_]+$/', $_POST['username']) && preg_match('/^[0-9a-zA-z\-+$%^*&_#@!]+$/', $_POST['password'])))
		{
			die("Please enter correct information");
		}

		// Assign username and password to variable
		$userInputUsername = $_POST['username'];
		$userInputPassword = $_POST['password'];

		// Check if user exists or not.
		$adminRow = $database->getAdmin($userInputUsername);
		// var_dump($adminRow);
		if($adminRow == null)
		{
			$userExist = false;
		}
		else
		{
			// If user exists then verify if the password is correct or not.
			if(password_verify($userInputPassword, $adminRow['password']))
			{
				// If it then assign username to a session variable
				$_SESSION['user'] = $userInputUsername;
				// Splits the privilege string into a string and save it into a session variable
				$_SESSION['privilege'] = explode(', ', $adminRow['privilege']); 

				// Checks if the login page was redirected from any other page. If it was then it is redirected to the same page otherwise it is redirected to home page
				if(isset($_SESSION['referer_page']))
				{
					header("location:" . $_SESSION['referer_page']);
					exit();
				}
				else
				{
					header("location: http://localhost/admin");
					exit();
				}
			}
			// If password is wrong then set incorrectPassword variable to 1
			else
			{
				$incorrectPassword = true;
			}
		}
	}

	include("template/login.html");