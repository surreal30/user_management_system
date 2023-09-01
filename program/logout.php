<?php
	session_start();
	session_regenerate_id();

	if(isset($_SESSION['user']))
	{
		session_destroy();
		header("location: http://localhost:8080/admin/login");
		exit();
	}

	else
	{
		header("location: http://localhost:8080/admin/login");
		exit();
	}