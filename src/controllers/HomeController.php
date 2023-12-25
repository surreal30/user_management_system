<?php

class HomeController
{
	public function __construct()
	{
		$this->templatePath = ROOT_DIR . "/template/";
	}
	
	public function homepage()
	{
		$sessionUser = manageSession();

		include $this->templatePath . "homepage.php";
	}

	public function catchAll()
	{
		$sessionUser = manageSession();

		http_response_code(404);

		include $this->templatePath . "404.php";
	}
}