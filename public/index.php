<?php
	$url = parse_url($_SERVER['REQUEST_URI']);

	$urlMap = [
		"/admin"              => "/src/homepage.php",
		"/admin/login"        => "/src/login.php",
		"/admin/logout"       => "/src/logout.php",
		"/admin/users"        => "/src/list_user.php",
		"/admin/users/add"    => "/src/add_user.php",
		"/admin/users/edit"   => "/src/edit_user.php",
		"/admin/users/delete" => "/src/delete_user_page.php",
	];

	$route = isset($urlMap[$url['path']]) ? $urlMap[$url['path']] : "/src/404.php";

	require __DIR__ . $route;