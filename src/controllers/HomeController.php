<?php

$position = strrpos(__DIR__, "/");
$dirPath = substr(__DIR__, 0, $position);

require_once $dirPath . "/manage_login_session.php";

class HomeController
{
	public function homepage()
	{
		$sessionUser = manageSession();

		include("/app/template/homepage.php");
	}

	public function catchAll()
	{
		$sessionUser = manageSession();

		http_response_code(404);

		include ("/app/template/404.php");
	}
}