<?php
require_once("src/UserManager.php");

$user = new UserManager();

$url = parse_url($_SERVER['REQUEST_URI']);

$urlMap = [
	"/admin"                 => "/src/homepage.php",
	"/admin/login"           => "/src/login.php",
	"/admin/logout"          => "/src/logout.php"
];

$userFunctionMap = [
	"/admin/users"           => "listUser",
	"/admin/users/add"       => "addUser",
	"/admin/users/edit"      => "editUser",
	"/admin/users/delete"    => "deleteUser"
];

if(isset($userFunctionMap[$url['path']]))
{
	$route = $userFunctionMap[$url['path']];

	$user->$route();
}

else
{
	$route = isset($urlMap[$url['path']]) ? $urlMap[$url['path']] : "/src/404.php";

	require __dir__ . $route;

}