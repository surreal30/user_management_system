<?php
	require_once("manage_login_session.php");

	$sessionUser = manageSession();

	include("template/homepage.html");