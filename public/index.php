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
		$route = "/homepage.php";
	}
	elseif( count($requestURI) == 3 && $requestURI[1] == 'admin' && $requestURI[2] == 'login')
	{
		$route = "/login.php";
	}
	elseif( count($requestURI) == 3 && $requestURI[1] == 'admin' && $requestURI[2] == 'logout')
	{
		$route = "/logout.php";
	}
	elseif( count($requestURI) == 3 && $requestURI[1] == 'admin' && $requestURI[2] == 'users')
	{
		$route = "/list_user.php";
	}
	elseif( count($requestURI) == 3 && $requestURI[1] == 'admin' && str_contains($requestURI[2], "?"))
	{
		$route = "/list_user.php";
	}
	elseif( count($requestURI) == 4 && $requestURI[1] == 'admin' && $requestURI[2] == 'users' && $requestURI[3] == 'add')
	{
		$route = "/add_user.php";
	}
	elseif( count($requestURI) == 5 && $requestURI[1] == 'admin' && $requestURI[2] == 'users' && $requestURI[4] == 'edit')
	{
		$route = "/edit_user.php";
	}
	elseif( count($requestURI) == 5 && $requestURI[1] == 'admin' && $requestURI[2] == 'users' && $requestURI[4] == 'delete')
	{
		$route = "/delete_user.php";
	}
	else
	{
		$route = "/404.php";
	}

	require __DIR__ . $route;