<?php
	$url = parse_url($_SERVER['REQUEST_URI']);

	$route = "/src/404.php";

	$urlMap = [
		"/admin"              => "/src/homepage.php",
		"/admin/login"        => "/src/login.php",
		"/admin/logout"       => "/src/logout.php",
		"/admin/users"        => "/src/list_user.php",
		"/admin/users/add"    => "/src/add_user.php",
		"/admin/users/edit"   => "/src/edit_user.php",
		"/admin/users/delete" => "/src/delete_user.php",
	];

	$route = array_key_exists($url['path'], $urlMap) ? $urlMap[$url['path']] : $route;

	require __DIR__ . $route;