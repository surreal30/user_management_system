<?php
	require_once("src/UserManager.php");
	require_once("src/manage_login_session.php");

	$user = new UserManager();

	$url = parse_url($_SERVER['REQUEST_URI']);

	$urlMap = [
		"/admin"              => "/src/homepage.php",
		"/admin/login"        => "/src/login.php",
		"/admin/logout"       => "/src/logout.php",
	];

	if(str_contains($url['path'], "/admin/users"))
	{
		$sessionUser = manageSession();

		$urlArray = explode("/", $url['path']);

		$requestPage = lcfirst(array_pop($urlArray)) . "User";

		if($requestPage === "usersUser")
		{
			// calls listUser().
			$user->listUser($sessionUser);
		}

		elseif(method_exists('UserManager', $requestPage))
		{
			$user->$requestPage($sessionUser);
		}

		else
		{
			require __dir__ . "/src/404.php";
		}
	}

	else
	{
		// $sessionUser = manageSession();

		$route = isset($urlMap[$url['path']]) ? $urlMap[$url['path']] : "/src/404.php";

		require __dir__ . $route;
	}