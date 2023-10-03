<?php
	class DatabaseOperation
	{
		// Create a database connection if the connection fails script stops running
		public function databaseConnection ()
		{
			$dbHostName = getenv('MYSQL_HOST');
			$dbUser = getenv('MYSQL_USER');
			$dbPassword = getenv('MYSQL_PASSWORD');
			$dbName = getenv('MYSQL_DATABASE');	
			$mysqli = new mysqli($dbHostName, $dbUser, $dbPassword, $dbName, 3306);
			if(!$mysqli)
			{
				return -1;
			}
			return $mysqli;
		}

		// Add user in the database
		public function addUser ($mysqli, $firstName, $lastName, $email, $phoneNo, $password)
		{
			$insertUserDataQuery = $mysqli->prepare("INSERT INTO users (id, first_name, last_name, email, created_at, updated_at, phone_no, password) value (0, ?, ?, ?, NOW(), NOW(), ?, ?)");

			try
			{
				$insertUserDataQuery->bind_param("sssss", $firstName, $lastName, $email, $phoneNo, $password);
				$insertUserDataQuery->execute();
			}
			catch(\Throwable $e)
			{
				return -1;
			}

			return 1;
		}

		// Get user's information to prepopulate the edit user form
		public function getUser ($mysqli, $id)
		{
			$getUserInfo = $mysqli->prepare("SELECT * FROM users where id = ?");
			$getUserInfo->bind_param("s", $id);
			try
			{
				$getUserInfo->execute();
			}
			catch(\Throwable $e)
			{
				return -1;
			}
			$result = $getUserInfo->get_result();
			if(mysqli_num_rows($result) == 0)
			{
				return 0;
			}
			return $result->fetch_assoc();
		}

		// Update user informatuon
		public function updateUser ($mysqli, $firstName, $lastName, $email, $phoneNo, $id)
		{
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
					return -1;
				}

				return 1;
		}

		// Delete user
		public function deleteUser ($mysqli, $id)
		{
			// Prepare, bind param and execute query to delete user
			$deleteUserQuery = $mysqli->prepare("DELETE FROM users WHERE id = ?");
			$deleteUserQuery->bind_param("s", $id);

			try
			{
				$deleteUserQuery->execute();
			}
			catch(\Throwable $e)
			{
				return -1;
			}
			return 1;
		}

		// Search user by email
		public function searchUserByEmail($mysqli, $email)
		{
			$checkEmailQuery = $mysqli->prepare("SELECT * FROM users where email = ?");
			$checkEmailQuery->bind_param("s", $email);

			try
			{
				$checkEmailQuery->execute();
			}
			catch (Exception $e)
			{
				return -1;	
			}
			return $checkEmailQuery->get_result();
		}

		// Count number of rows
		public function countUsers ($mysqli)
		{
			try
			{
				$countQuery = $mysqli->query('SELECT COUNT(*) FROM users');
			}
			catch (Exception $e)
			{
				return -1;
			}
			$totalRows = $countQuery->fetch_assoc();
			return $totalRows['COUNT(*)'];
		}

		// Lists all of the user by taking in the offset and the limit
		public function getUserDetails ($mysqli, $offset, $limit)
		{
			$selectRowQuery = $mysqli->prepare('SELECT * FROM users LIMIT ?, ?');
			$selectRowQuery->bind_param("ss", $offset, $limit);

			try
			{
				$selectRowQuery->execute();
			}
			catch (Exception $e)
			{
				return -1;
			}
			return $selectRowQuery->get_result();
		}
	}