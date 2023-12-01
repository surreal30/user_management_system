<?php

require_once("manage_login_session.php");

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