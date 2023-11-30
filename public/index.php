<?php

require_once("src/UserController.php");
require_once("src/AuthenticationController.php");
require_once("src/HomeController.php");

$url = parse_url($_SERVER['REQUEST_URI']);

$urlMap = [
	"/admin"                  => ["HomeController", "homepage"],
	"/admin/login"            => ["AuthenticationController", "login"],
	"/admin/logout"           => ["AuthenticationController", "logout"],
	"/admin/users"            => ["UserController", "listUser"],
	"/admin/users/add"        => ["UserController", "addUser"],
	"/admin/users/edit"       => ["UserController", "editUser"],
	"/admin/users/delete"     => ["UserController", "deleteUser"]
];

if(isset($urlMap[$url['path']])) // and is_array($urlMap[$url['path']]))
{
	$controller = $urlMap[$url['path']][0];

	$user = new $controller();

	$function = $urlMap[$url['path']][1];

	$user->$function();
}

else
{
	require __dir__ . "/src/404.php";
}
