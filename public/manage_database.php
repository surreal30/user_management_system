<?php
	// Assigns database secrets from environment
	$dbHostName = getenv('MYSQL_HOST');
	$dbUser = getenv('MYSQL_USER');
	$dbPassword = getenv('MYSQL_PASSWORD');
	$dbName = getenv('MYSQL_DATABASE');

	// Error handling for mysqli
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	// Create a database connection
	$mysqli = new mysqli($dbHostName, $dbUser, $dbPassword, $dbName, 3306);

	// Checks if the the connection was established or not. If not then error is displayed and script stops 
	if(!$mysqli)
	{
		die("\n Database not connected");
	}

	// Add user in the database
	function add_user ($firstName, $lastName, $email, $phoneNo, $password)
	{
		global $mysqli;
		$insertUserDataQuery = $mysqli->prepare("INSERT INTO users (id, first_name, last_name, email, created_at, updated_at, phone_no, password) value (0, ?, ?, ?, NOW(), NOW(), ?, ?)");

		try
		{
			$insertUserDataQuery->bind_param("sssss", $firstName, $lastName, $email, $phoneNo, $password);
			$insertUserDataQuery->execute();
		}
		catch(\Throwable $e)
		{
			die("Error occured $e");
		}
	}

	// Get user's information to prepopulate the edit user form
	function get_user_info ($id)
	{
		global $mysqli;
		$getUserInfo = $mysqli->prepare("SELECT * FROM users where id = ?");
		$getUserInfo->bind_param("s", $id);
		$getUserInfo->execute();
		$result = $getUserInfo->get_result();
		if(mysqli_num_rows($result) == 0)
		{
			echo "<center><h4><a class='page-link' style='margin-top: 3rem;'> This user does not exist. Go back to list user page and select another user. </a></h4></center>";
			exit();
		}
		return $result->fetch_assoc();
	}

	// Update user informatuon
	function update_user ($firstName, $lastName, $email, $phoneNo, $id)
	{
		global $mysqli;
		// Prepare query statement
			$editUserQuery = $mysqli->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, updated_at = NOW(), phone_no = ?  WHERE id = ?");

			// Bind params and execute the query. If error occurs the script stops and error is displayed.
			try
			{
				$editUserQuery->bind_param("sssss", $firstName, $lastName, $email, $phoneNo, $id);
				$editUserQuery->execute();	
			}
			catch(\Throwable $e)
			{
				die("Error occured $e");
			}

			// Display that user has been successfully updated
			// echo " <h3> User $firstName $lastName has been updated. </h3>";
			return 1;
	}

	// Delete user
	function delete_user ($id)
	{
		global $mysqli;
		// Prepare, bind param and execute query to delete user
		$deleteUserQuery = $mysqli->prepare("DELETE FROM users WHERE id = ?");
		$deleteUserQuery->bind_param("s", $id);

		try
		{
			$deleteUserQuery->execute();
		}
		catch(\Throwable $e)
		{
			die("Error caught $e");
		}

		// Print user deleted
		echo "<center><h4 class='pt-3'> User has been deleted. </h4></center";
	}

	// Search user by email
	function search_user_email($email)
	{
		global $mysqli;
		$checkEmailQuery = $mysqli->prepare("SELECT * FROM users where email = ?");
		$checkEmailQuery->bind_param("s", $email);
		$checkEmailQuery->execute();
		return $checkEmailQuery->get_result();
	}

	// Count number of rows
	function count_row ()
	{
		global $mysqli;
		$countQuery = $mysqli->query('SELECT COUNT(*) FROM users');
		$totalRows = $countQuery->fetch_assoc();
		return $totalRows['COUNT(*)'];
	}

	// 
	function get_user_list ($offset, $limit)
	{
		global $mysqli;
		$selectRowQuery = $mysqli->prepare('SELECT * FROM users LIMIT ?, ?');
		$selectRowQuery->bind_param("ss", $offset, $limit);
		$selectRowQuery->execute();
		return $selectRowQuery->get_result();
	}