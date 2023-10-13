<?php
	require_once("manage_login_session.php");
	require_once("html/manage_html.php");

	define("TITLE", "User Management System");

	htmlBeginning(TITLE);

	define("PAGE", "index");
	navbar($sessionUser, PAGE);

	welcomeMessage();

	htmlEnding();