<?php

define("ROOT_DIR", dirname(__DIR__));
$filePath = ROOT_DIR . "/src/";

require_once $filePath . "file_loader.php";

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