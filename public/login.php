<?php
	require_once("HtmlCode/manage_html.php");
	require_once("HtmlCode/login_html.php");

	define("TITLE", "Login");

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

	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	// Create a database connection
	$mysqli = new mysqli($dbHostName, $dbUser, $dbPassword, $dbName, 3306);
	// Checks if the the connection was established or not. If not then error is displayed and script stops 
	if(!$mysqli)
	{
		die("<br> Could not connect to server");
	}

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

		// Prepare, bind and execute query to check if user exists or not.
		$checkAdminQuery = $mysqli->prepare("SELECT * from admins where username = ? ");
		$checkAdminQuery->bind_param("s", $userInputUsername);
		$checkAdminQuery->execute();
		$results = $checkAdminQuery->get_result();
		if(empty($results))
		{
			die("User not found");
		}
		else
		{
			$adminRow = $results->fetch_assoc();

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
				$incorrectPassword = 1;
			}
		}
	}

	htmlBeginning(TITLE);

	$link = "http://localhost/admin/login";
	loginForm($link);
    	// if incorrectPassword was declred and initialised
        if(isset($incorrectPassword))
        {
        	// If the value of incorrectPassword is 1 then incorrect password is incorrect
            if ($incorrectPassword == 1)
            {
            	incorrectPassword();	
            }
        }
    htmlEnding();