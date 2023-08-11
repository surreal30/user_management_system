<?php
	session_start();
	session_regenerate_id();

	if(isset($_SESSION['user']))
	{
		session_destroy();
		header("location: login.php");
	}

	else
	{
		header("location: login.php");
	}