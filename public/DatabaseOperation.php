<?php
	class DatabaseOperation
	{
		// Create a database connection if the connection fails script stops running
		public function __construct()
		{
			$dbHostName = getenv('MYSQL_HOST');
			$dbUser = getenv('MYSQL_USER');
			$dbPassword = getenv('MYSQL_PASSWORD');
			$dbName = getenv('MYSQL_DATABASE');	
			$this->mysqli = new mysqli($dbHostName, $dbUser, $dbPassword, $dbName, 3306);
			if(!$this->mysqli)
			{
				die("Couldn't connect to database");
			}
		}

		// Add user in the database
		public function addUser ($firstName, $lastName, $email, $phoneNo, $password)
		{
			$insertUserDataQuery = $this->mysqli->prepare("INSERT INTO users (id, first_name, last_name, email, created_at, updated_at, phone_no, password) value (0, ?, ?, ?, NOW(), NOW(), ?, ?)");

			try
			{
				$insertUserDataQuery->bind_param("sssss", $firstName, $lastName, $email, $phoneNo, $password);
				$insertUserDataQuery->execute();
			}
			catch(Exception $e)
			{
				return false;
			}

			return true;
		}

		// Get user's information to prepopulate the edit user form
		public function getUser ($id)
		{
			$getUserInfo = $this->mysqli->prepare("SELECT * FROM users where id = ?");
			$getUserInfo->bind_param("s", $id);
			try
			{
				$getUserInfo->execute();
			}
			catch(Exception $e)
			{
				return false;
			}
			$result = $getUserInfo->get_result();
			if(mysqli_num_rows($result) == 0)
			{
				return 0;
			}
			return $result->fetch_assoc();
		}

		// Update user informatuon
		public function updateUser ($firstName, $lastName, $email, $phoneNo, $id)
		{
			// Prepare query statement
				$editUserQuery = $this->mysqli->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, updated_at = NOW(), phone_no = ?  WHERE id = ?");

				// Bind params and execute the query. If error occurs the script stops and error is displayed.
				try
				{
					$editUserQuery->bind_param("sssss", $firstName, $lastName, $email, $phoneNo, $id);
					$editUserQuery->execute();	
				}
				catch(Exception $e)
				{
					return false;
				}

				return true;
		}

		// Delete user
		public function deleteUser ($id)
		{
			// Prepare, bind param and execute query to delete user
			$deleteUserQuery = $this->mysqli->prepare("DELETE FROM users WHERE id = ?");
			$deleteUserQuery->bind_param("s", $id);

			try
			{
				$deleteUserQuery->execute();
			}
			catch(Exception $e)
			{
				return false;
			}
			return true;
		}

		// Search user by email
		public function searchUserByEmail($email)
		{
			$checkEmailQuery = $this->mysqli->prepare("SELECT * FROM users where email = ?");
			$checkEmailQuery->bind_param("s", $email);

			try
			{
				$checkEmailQuery->execute();
			}
			catch (Exception $e)
			{
				return false;	
			}
			return $checkEmailQuery->get_result();
		}

		// Count number of rows
		public function countUsers ()
		{
			try
			{
				$countQuery = $this->mysqli->query('SELECT COUNT(*) FROM users');
			}
			catch (Exception $e)
			{
				return false;
			}
			$totalRows = $countQuery->fetch_assoc();
			return $totalRows['COUNT(*)'];
		}

		// Lists all of the user by taking in the offset and the limit
		public function getUserDetails ($offset, $limit)
		{
			$selectRowQuery = $this->mysqli->prepare('SELECT * FROM users LIMIT ?, ?');
			$selectRowQuery->bind_param("ss", $offset, $limit);

			try
			{
				$selectRowQuery->execute();
			}
			catch (Exception $e)
			{
				return false;
			}
			return $selectRowQuery->get_result();
		}
	}