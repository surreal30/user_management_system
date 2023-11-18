<?php
	require_once("src/PageGenerator.php");

	$page = new PageGenerator();

	$url = parse_url($_SERVER['REQUEST_URI']);

	$urlMap = [
		"/admin"              => "homepagePage",
		"/admin/login"        => "loginPage",
		"/admin/logout"       => "logoutPage",
		"/admin/users"        => "listUserPage",
		"/admin/users/add"    => "addUserPage",
		"/admin/users/edit"   => "editUserPage",
		"/admin/users/delete" => "deleteUserPage"
	];

	$route = isset($urlMap[$url['path']]) ? $urlMap[$url['path']] : "error404Page";

	$page->$route();