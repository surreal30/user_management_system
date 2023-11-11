<?php
	// Create a session
	session_start();
	// Create a new session ID. This helps in session hijacking. Everytime a new page is opened, new session ID is created.
	session_regenerate_id();

	// If user is logged in then session destroyed and redirected to login page. If not then user is redirected to login page.
	if(isset($_SESSION['user']))
	{
		session_destroy();
		header("location: http://localhost/admin/login");
		exit();
	}

	else
	{
		header("location: http://localhost/admin/login");
		exit();
	}