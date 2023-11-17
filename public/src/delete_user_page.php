<?php
	function deleteUserPage()
	{
		// Check if user is logged in or not. Also checks for time out and HTTP_USER_AGENT
		require_once("manage_login_session.php");
		require_once("DatabaseOperation.php");

		// Checks authorisation
		if(!(in_array("delete_user", $_SESSION['privilege'])))
		{
			die("Access Denied");
		}

		// Takes user ID from url
		if(isset($_GET['id']))
		{
			$id = $_GET['id'];
		}
		else
		{
			die("No id found. Please go back again.");
		}
		$databaseConnection = new DatabaseOperation();

		include_once("template/delete_user.html");

		// Checks if the id is number or not. If it is not error is displayed.
		if(!(preg_match('/^[0-9]*$/', $id)))
		{
			// invalidUser();
			include("template/message/user_invalid.html");
			exit();
		}

		// Check if user exists or not
		$user = $databaseConnection->getUser($id);
		if($user === null)
		{
			// userDoesNotExist();
			include("template/message/user_does_not_exist.html");
			exit();
		}

		// Delete user
		$userDeleted = $databaseConnection->deleteUser($id);
		if($userDeleted === true)
		{
			// userDeleted();
			include("template/message/user_deleted.html");
		}
	}

	deleteUserPage();