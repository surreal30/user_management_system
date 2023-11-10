<?php
	$url = parse_url($_SERVER['REQUEST_URI']);

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