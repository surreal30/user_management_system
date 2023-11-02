<?php
	if($_SERVER['REQUEST_URI'][-1] == "/")
	{
		$URI = substr($_SERVER['REQUEST_URI'], 0, -1);
	}
	else
	{
		$URI = $_SERVER['REQUEST_URI'];
	}

	$route = "/src/404.php";
 
	if( $URI == "/admin" )
	{
		$route = "/src/homepage.php";
	}
	elseif( $URI == "/admin/login" )
	{
		$route = "/src/login.php";
	}
	elseif( $URI == "/admin/logout" )
	{
		$route = "/src/logout.php";
	}
	elseif( $URI == "/admin/users" )
	{
		$route = "/src/list_user.php";
	}
	elseif( explode("?", $URI)[0] == "/admin/users" )
	{
		$route = "/src/list_user.php";
	}
	elseif( $URI == "/admin/users/add" )
	{
		$route = "/src/add_user.php";
	}
	elseif( explode("?", $URI)[0] == "/admin/users/edit")
	{
		$route = "/src/edit_user.php";
	}
	elseif( explode("?", $URI)[0] == "/admin/users/delete")
	{
		$route = "/src/delete_user.php";
	}


	require __DIR__ . $route;