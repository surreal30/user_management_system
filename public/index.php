<?php
	require_once("src/PageGenerator.php");

	$page = new PageGenerator();

	$url = parse_url($_SERVER['REQUEST_URI']);

	$urlMap = [
		"/admin"              => "/src/homepage.php",
		"/admin/login"        => "/src/login.php",
		"/admin/logout"       => "/src/logout.php",
	];

	if(str_contains($url['path'], "users"))
	{
		$urlArray = explode("/", $url['path']);

		$requestedPage = array_pop($urlArray);

		switch($requestedPage)
		{
			case 'users':
				$page->listUserPage();
				break;
			
			case 'add':
				$page->addUserPage();
				break;

			case 'edit':
				$page->editUserPage();
				break;

			case 'delete':
				$page->deleteUserPage();
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