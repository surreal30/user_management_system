<?php
	if($_SERVER['REQUEST_URI'][-1] == "/")
	{
		$URI = substr($_SERVER['REQUEST_URI'], 0, -1);
	}
	else
	{
		$URI = $_SERVER['REQUEST_URI'];
	}

	$requestURI = (isset($_SERVER['REQUEST_URI'])? explode('/', $URI) : null );

	if( count($requestURI) == 2 && in_array("admin", $requestURI))
	{
		$route = "/views/homepage.php";
	}
	elseif( count($requestURI) == 3 && in_array("login", $requestURI))
	{
		$route = "/views/login.php";
	}
	elseif( count($requestURI) == 3 && in_array("logout", $requestURI))
	{
		$route = "/views/logout.php";
	}
	elseif( count($requestURI) == 3 && in_array("users", $requestURI))
	{
		$route = "/views/list_user.php";
	}
	elseif( count($requestURI) == 3 && str_contains($requestURI[2], "?"))
	{
		$route = "/views/list_user.php";
	}
	elseif( count($requestURI) == 4 && in_array("add", $requestURI))
	{
		$route = "/views/add_user.php";
	}
	elseif( count($requestURI) == 5 && in_array("edit", $requestURI))
	{
		$route = "/views/edit_user.php";
	}
	elseif( count($requestURI) == 5 && in_array("delete", $requestURI))
	{
		$route = "/views/delete_user.php";
	}
	else
	{
		$route = "/views/404.php";
	}

	require __DIR__ . $route;