<?php
	require_once("src/UserManager.php");

	$user = new UserManager();

	$url = parse_url($_SERVER['REQUEST_URI']);

	$urlMap = [
		"/admin"              => "/src/homepage.php",
		"/admin/login"        => "/src/login.php",
		"/admin/logout"       => "/src/logout.php",
	];

	if(str_contains($url['path'], "users") && str_contains($url['path'], "admin"))
	{
		$urlArray = explode("/", $url['path']);

		$requestedPage = array_pop($urlArray);

		switch($requestedPage)
		{
			case 'users':
				$user->listUser();
				break;
			
			case 'add':
				$user->addUser();
				break;

			case 'edit':
				$user->editUser();
				break;

			case 'delete':
				$user->deleteUser();
				break;

			default:
				require __dir__ . "/src/404.php";
				break;
		}
	}

	else
	{
		$route = isset($urlMap[$url['path']]) ? $urlMap[$url['path']] : "/src/404.php";
		require __dir__ . $route;
	}