<?php
	// Check if user is logged in or not. Also checks for time out and HTTP_USER_AGENT
	require_once("manage_login_session.php");
	require_once("DatabaseOperation.php");

	// Checks authorisation
	if(!(in_array("edit_user", $_SESSION['privilege'])))
	{
		die("Access Denied");
	}

	// Takes user ID from the url
	if(isset($_GET['id']))
	{
		$id = $_GET['id'];
	}
	else
	{
		die("No id found. Please go back again.");
	}

	// Create a database connection
	$databaseConnection = new DatabaseOperation();

	// Checks if the id is number or not. If it is not error is displayed.
	if(!(preg_match('/^\d[0-9]*$/', $id)))
	{
		// invalidUser();
		include("template/message/user_invalid.html");
		exit();
	}

	// Checks if the form was submitted or not.
	if(isset($_POST['first_name']))
	{
		// Assigns value from header to variables
		$firstName = $_POST['first_name'];
		$lastName = $_POST['last_name'];
		$email = $_POST['email'];
		$phoneNo = $_POST['phone_no'];	

		$updateUser = $databaseConnection->updateUser($firstName, $lastName, $email, $phoneNo, $id);
	}

	// Get user information to prepopulate the edit user table
	$user = $databaseConnection->getUser($id);
	
	$userRow = $user->fetch_assoc();
	if($userRow == 0)
	{
		// userDoesNotExist();
		include("template/message/user_does_not_exist.html");
		exit();
	}

	include("template/edit_user.html");