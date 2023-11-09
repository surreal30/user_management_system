<?php
	if($_SERVER['REQUEST_URI'][-1] == "/")
	{
		$uri = substr($_SERVER['REQUEST_URI'], 0, -1);
	}
	else
	{
		$uri = $_SERVER['REQUEST_URI'];
	}

	$url = parse_url($uri);

	$route = "/src/404.php";

	switch ($url["path"])
	{
		case '/admin':
			$route = "/src/homepage.php";
			break;
		
		case '/admin/login':
			$route = "/src/login.php";
			break;

		case '/admin/logout':
			$route = "/src/logout.php";
			break;

		case '/admin/users':
			$route = "/src/list_user.php";
			break;

		case '/admin/users/add':
			$route = "/src/add_user.php";
			break;

		case '/admin/users/edit':
			$route = "/src/edit_user.php";
			break;

		case '/admin/users/delete':
			$route = "/src/delete_user.php";
			break;
	}

	require __DIR__ . $route;