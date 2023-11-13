<?php
	// Check if user is logged in or not. Also checks for time out and HTTP_USER_AGENT
	require_once("manage_login_session.php");
	require_once("DatabaseOperation.php");

	// Checks authorisation
	if(!(in_array("list_user", $_SESSION['privilege'])))
	{
		die("Access Denied");
	}

	// Create database connection
	$databaseConnection = new DatabaseOperation();

	// Checks if the user submitted search by email 
	if(isset($_GET['email']))
	{
		// Assign value to variable 
		$userEmailInput = $_GET["email"];	
		if($userEmailInput)
		{
			// Check if it is a valid email address or not
			if(preg_match('/^[a-zA-Z0-9][a-zA-Z0-9]*([_#$+*&{}=%^\/\-.!]*[a-zA-Z0-9])*@\w[a-zA-Z]*\.\w[a-zA-Z]*\.?\w[a-zA-Z]*$/', $userEmailInput))
			{
				$users = $databaseConnection->searchUsersByEmail($userEmailInput);
				if(!empty($users))
				{
					// Print user table
					include("template/list_user.html");
				}

				else
				{
					echo "<br> Email not found";
				}
				
			}
		}
	}

	// Check if the user is on other page
	else
	{
		if(!isset($_GET['page']) || !(preg_match('<^\d[0-9]*$>', $_GET['page'])))
		{
			$currentPage = 1;
		}
		else
		{
			$currentPage = $_GET['page'];
		}

		// Sets limit to 5 if there is no count query param or in case count is anything other than a number. If there is numerical count query param then it is assigned to limit variable
		if(!isset($_GET['count']) || !(preg_match('<^\d[0-9]*$>' , $_GET['count'])))
		{
			$limit = 5;
		}
		else
		{
			$limit = $_GET['count'];
		}

		// Count the number of rows in the table for pagination
		$rowCount = $databaseConnection->countUsers();
		
		$totalPages = ceil($rowCount/$limit);

		// Checks if currentPage is more than total number of pages or currentPage is not a number then offset is set 0. Otherwise offset is set according to the current page
		if($currentPage > $totalPages || !(preg_match('<^\d[0-9]*$>', $currentPage)))
		{
			$offset = 0;
		}
		else
		{
			$offset = ($currentPage - 1) * $limit;
		}

		// Fetch user list based on the offset and limit
		$users = $databaseConnection->getUsers($offset, $limit);

		// Print table and data in it
		if(!empty($users))
		{
			include("template/list_user.html");
		}
	}