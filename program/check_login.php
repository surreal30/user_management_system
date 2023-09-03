<?php
	session_start();
	session_regenerate_id();
	if(!isset($_SESSION['user']))
	{
		$_SESSION['referer_page'] = $_SERVER['REQUEST_URI'];
		header("location: http://localhost:8080/admin/login");
		exit();
	}
	$user = $_SESSION['user'];

	if(isset($_SESSION['timeout']))
	{
		if(time() > $_SESSION['timeout'])
		{
			session_destroy();
			header("location: http://localhost:8080/admin/login");
			exit();
		}
	}

	if(isset($_SESSION['HTTP_USER_AGENT']))
	{
		if($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT']))
		{
			die("User not identified");
		}
	}