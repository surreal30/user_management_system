<?php
	require_once("src/UserManager.php");

	$user = new UserManager();

	$url = parse_url($_SERVER['REQUEST_URI']);

	$urlMap = [
		"/admin"              => "/src/homepage.php",
		"/admin/login"        => "/src/login.php",
		"/admin/logout"       => "/src/logout.php",
	];

	if(str_contains($url['path'], "/admin/users"))
	{
		$urlArray = explode("/", $url['path']);

		$requestPage = lcfirst(array_pop($urlArray)) . "User";

		if($requestPage === "usersUser")
		{
			// calls listUser().
			$user->listUser();
		}

		elseif(method_exists('UserManager', $requestPage))
		{
			$user->$requestPage();
		}

		else
		{
			require __dir__ . "/src/404.php";
		}
	}

	else
	{
		$route = isset($urlMap[$url['path']]) ? $urlMap[$url['path']] : "/src/404.php";

		require __dir__ . $route;
	}