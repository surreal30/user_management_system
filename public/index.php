<?php

require_once("src/UserController.php");
require_once("src/AuthenticationController.php");

$url = parse_url($_SERVER['REQUEST_URI']);

$urlMap = [
	"/admin"                 => ["version" => "v1", "value" => "/src/homepage.php"],
	"/admin/login"           => ["version" => "v2", "value" => ["AuthenticationController", "login"]],
	"/admin/logout"          => ["version" => "v2", "value" => ["AuthenticationController", "logout"]],
	"/admin/users"           => ["version" => "v2", "value" => ["UserController", "listUser"]],
	"/admin/users/add"       => ["version" => "v2", "value" => ["UserController", "addUser"]],
	"/admin/users/edit"      => ["version" => "v2", "value" => ["UserController", "editUser"]],
	"/admin/users/delete"    => ["version" => "v2", "value" => ["UserController", "deleteUser"]],
];

if(isset($urlMap[$url['path']]))
{
	if($urlMap[$url['path']]['version'] == "v1")
	{
		require __dir__ . $urlMap[$url['path']]['value']; // $route;
	}

	elseif($urlMap[$url['path']]['version'] == "v2")
	{
		$controller = $urlMap[$url['path']]['value'][0];
		
		$user = new $controller();

		$function = $urlMap[$url['path']]['value'][1];

		$user->$function();
	}
}

else
{
	require __dir__ . "/src/404.php";
}