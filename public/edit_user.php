<?php
	// Check if user is logged in or not. Also checks for time out and HTTP_USER_AGENT
	require_once("manage_login_session.php");
	require_once("DatabaseOperation.php");
	require_once("HtmlCode/manage_html.php");
	require_once("HtmlCode/edit_delete_user_html.php");

	define("PAGE", "editUser");
	define("TITLE", "Edit User");

	// Checks authorisation
	if(!(in_array("edit_user", $_SESSION['privilege'])))
	{
		die("Access Denied");
	}

	htmlBeginning(TITLE);

	navbar($sessionUser, PAGE);

	// Takes user ID from the url
	$pathComponents = explode('/', $_SERVER['REQUEST_URI']);
	$id = $pathComponents[3];

	// Create a database connection
	$databaseConnection = new DatabaseOperation();

	// Checks if the id is number or not. If it is not error is displayed.
	if(!(preg_match('/^\d[0-9]*$/', $id)))
	{
		invalidUser();
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
		if($updateUser == false)
		{
			die("Some error occured");
		}
	}

	// Get user information to prepopulate the edit user table
	$user = $databaseConnection->getUser($id);
	if($user == false)
	{
		die("Some error occured");
	}
	
	$userRow = $user->fetch_assoc();
	if($userRow == 0)
	{
		userDoesNotExist();
		exit();
	}

	// Edit user form with prepopulated data from database
	$link = "http://localhost/admin/users/$id/edit";
	editUserForm($id, $userRow, $link);

	// Checks if the update_user function return 1 or not. If it is 1 then the user was updated
	if(isset($updateUser))
	{	
		if($updateUser == 1)
		{
			userUpdated($firstName, $lastName);
		}
	}

	htmlEnding();