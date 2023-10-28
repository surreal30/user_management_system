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

	if( count($requestURI) == 2 && $requestURI[1] == 'admin')
	{
		$route = "/src/homepage.php";
	}
	elseif( count($requestURI) == 3 && $requestURI[1] == 'admin' && $requestURI[2] == 'login' )
	{
		$route = "/src/login.php";
	}
	elseif( count($requestURI) == 3 && $requestURI[1] == 'admin' && $requestURI[2] == 'logout' )
	{
		$route = "/src/logout.php";
	}
	elseif( count($requestURI) == 3 && $requestURI[1] == 'admin' && $requestURI[2] == 'users' )
	{
		$route = "/src/list_user.php";
	}
	elseif( count($requestURI) == 3 && $requestURI[1] == 'admin' && str_contains($requestURI[2], "?") )
	{
		$route = "/src/list_user.php";
	}
	elseif( count($requestURI) == 4 && $requestURI[1] == 'admin' && $requestURI[2] == 'users' && $requestURI[3] == 'add' )
	{
		$route = "/src/add_user.php";
	}
	elseif( count($requestURI) == 5 && $requestURI[1] == 'admin' && $requestURI[2] == 'users' && $requestURI[4] == 'edit' )
	{
		$route = "/src/edit_user.php";
	}
	elseif( count($requestURI) == 5 && $requestURI[1] == 'admin' && $requestURI[2] == 'users' && $requestURI[4] == 'delete' )
	{
		$route = "/src/delete_user.php";
	}
	else
	{
		$route = "/src/404.php";
	}

	require __DIR__ . $route;