<?php

$pwd = explode("/", __DIR__);
$root = "/" . $pwd[1];
$Dir = "/src/";

require_once $root . $;

class HomeController
{
	public function homepage()
	{
		$sessionUser = manageSession();

		include("template/homepage.html");
	}

	public function catchAll()
	{
		$sessionUser = manageSession();

		http_response_code(404);

		include ("template/404.html");
	}
}