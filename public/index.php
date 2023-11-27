<?php
require_once("src/UserController.php");

$url = parse_url($_SERVER['REQUEST_URI']);

$urlMap = [
	"/admin"                 => ["/src/homepage.php", null],
	"/admin/login"           => ["/src/login.php", null],
	"/admin/logout"          => ["/src/logout.php", null],
	"/admin/users"           => [null, "listUser"],
	"/admin/users/add"       => [null, "addUser"],
	"/admin/users/edit"      => [null, "editUser"],
	"/admin/users/delete"    => [null, "deleteUser"]
];

if(isset($urlMap[$url['path']][1]))
{
	$user = new UserController();
	
	$function = $urlMap[$url['path']][1];

	$user->$function();
}

else
{
	$route = isset($urlMap[$url['path']][0]) ? $urlMap[$url['path']][0] : "/src/404.php";

	require __dir__ . $route;
}