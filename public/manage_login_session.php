<?php
	// Create a session
	session_start();

	// Create a new session ID. This helps in session hijacking. Everytime a new page is opened, new session ID is created.
	session_regenerate_id();

	// Checks if the user is logged in or not. If the user is not logged in, then page redirects to login page.
	if(!isset($_SESSION['user']))
	{
		$_SESSION['referer_page'] = $_SERVER['REQUEST_URI'];
		header("location: http://localhost/admin/login");
		exit();
	}

	// User is assigned to a variable to be printed on navbar
	$sessionUser = $_SESSION['user'];

	// Checks if the session has been timed out or not. If it is timed out then session is destroyed and page is redirected to login page.
	if(isset($_SESSION['timeout']))
	{
		if(time() > $_SESSION['timeout'])
		{
			session_destroy();
			header("location: http://localhost/admin/login");
			exit();
		}
	}

	// Checks if the session HTTP_USER_AGENT exists or not. Session HTTP_USER_AGENT is assigned at the time of login, it is a hashed value. If it does, hash value of server's HTTP_USER_AGENT is matched against the value of session HTTP_USER_AGENT. If the user doesn't match, error is displayed.
	if(isset($_SESSION['HTTP_USER_AGENT']))
	{
		if($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT']))
		{
			die("User not identified");
		}
	}