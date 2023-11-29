<?php

require_once("src/UserController.php");
require_once("src/AuthenticationController.php");

$url = parse_url($_SERVER['REQUEST_URI']);

$urlMap = [
	"/admin"                  => "/src/homepage.php",
	"/admin/login"            => ["AuthenticationController", "login"],
	"/admin/logout"           => ["AuthenticationController", "logout"],
	"/admin/users"            => ["UserController", "listUser"],
	"/admin/users/add"        => ["UserController", "addUser"],
	"/admin/users/edit"       => ["UserController", "editUser"],
	"/admin/users/delete"     => ["UserController", "deleteUser"]
];

if(isset($urlMap[$url['path']]) and is_array($urlMap[$url['path']]))
{
	$controller = $urlMap[$url['path']][0];

	$user = new $controller();

	$function = $urlMap[$url['path']][1];

	$user->$function();
}

else
{
	$route = isset($urlMap[$url['path']]) ? $urlMap[$url['path']] : "/src/404.php";

	require __dir__ . $route;
}
