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

$controller = isset($urlMap[$url['path']]) ? $urlMap[$url['path']][0] : "HomeController";

$user = new $controller();

$function = isset($urlMap[$url['path']]) ? $urlMap[$url['path']][1] : "catchAll";

$user->$function();