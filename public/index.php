<?php
	if($_SERVER['REQUEST_URI'][-1] == "/")
	{
		$URI = substr($_SERVER['REQUEST_URI'], 0, -1);
	}
	else
	{
		$URI = $_SERVER['REQUEST_URI'];
	}

	$URL = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . $URI;
	$URL = parse_url($URL);

	$route = "/src/404.php";

	switch ($URL["path"])
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