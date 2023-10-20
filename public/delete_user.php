<?php
	// Check if user is logged in or not. Also checks for time out and HTTP_USER_AGENT
	require_once("manage_login_session.php");
	require_once("DatabaseOperation.php");

	// Checks authorisation
	if(!(in_array("delete_user", $_SESSION['privilege'])))
	{
		die("Access Denied");
	}

	// Takes user ID from url
	$pathComponents = explode('/', $_SERVER['REQUEST_URI']);
	$id=$pathComponents[3];

	// Create database connection
	$databaseConnection = new DatabaseOperation();

	include("template/delete_user.html");

	// Checks if the id is number or not. If it is not error is displayed.
	if(!(preg_match('/^[0-9]*$/', $id)))
	{
		// invalidUser();
		include("template/message/user_invalid.html");
		exit();
	}

	// Check if user exists or not
	$user = $databaseConnection->getUser($id);
	if($user == false)
	{
		die("Some error occured");
	}	
	
	$userRow = $user->fetch_assoc();
	if($userRow == 0)
	{
		// userDoesNotExist();
		include("template/message/user_does_not_exist.html");
		exit();
	}

	// Delete user
	$userDeleted = $databaseConnection->deleteUser($id);
	if($userDeleted == false)
	{
		die("Some error occured");
	}
	elseif($userDeleted == true)
	{
		// userDeleted();
		include("template/message/user_deleted.html");
	}