<?php

require_once("manage_login_session.php");

class HomeController
{
	public function homepage()
	{
		$sessionUser = manageSession();

		include("template/homepage.html");
	}
}