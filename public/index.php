<?php

$position = strrpos(__DIR__, "/");
$dirPath = substr(__DIR__, 0, $position);
define("DIR_PATH", $dirPath);

$controllersDir = "/src/controllers/";

require_once DIR_PATH . $controllersDir . "AuthenticationController.php";
require_once DIR_PATH . $controllersDir . "UserController.php";
require_once DIR_PATH . $controllersDir . "HomeController.php";

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

