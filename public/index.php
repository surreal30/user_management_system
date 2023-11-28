<?php

require_once("/app/src/UserController.php");
require_once("/app/src/AuthenticationController.php");

$url = parse_url($_SERVER['REQUEST_URI']);

$urlMap = [
	"/admin"                  => "/app/src/homepage.php",
	"/admin/login"            => "AuthenticationController|login",
	"/admin/logout"           => "AuthenticationController|logout",
	"/admin/users"            => "UserController|listUser",
	"/admin/users/add"        => "UserController|addUser",
	"/admin/users/edit"       => "UserController|editUser",
	"/admin/users/delete"     => "UserController|deleteUser",
];

if(isset($urlMap[$url['path']]) and str_contains($urlMap[$url['path']], "|"))
{
	$controllerArray = explode("|", $urlMap[$url['path']]);

	$controller = array_shift($controllerArray);

	$user = new $controller();

	$function = array_shift($controllerArray);

	$user->$function();
}

else
{
	$route = isset($urlMap[$url['path']]) ? $urlMap[$url['path']] : "/app/src/404.php";

	require $route;
}