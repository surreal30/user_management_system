<?php
	class DatabaseOperation
	{
		// Create a database connection if the connection fails script stops running
		public function __construct()
		{
			$hostName = getenv('MYSQL_HOST');
			$user = getenv('MYSQL_USER');
			$password = getenv('MYSQL_PASSWORD');
			$name = getenv('MYSQL_DATABASE');	
			$this->mysqli = new mysqli($hostName, $user, $password, $name, 3306);
			if(!$this->mysqli)
			{
				die("Couldn't connect to database");
			}
		}

		public function getAdmin($username) : bool|array
		{
			$query = $this->mysqli->prepare("SELECT * from admins where username = ? ");
			$query->bind_param("s", $username);
			$query->execute();			
			$result = $query->get_result();
			return $result->fetch_assoc();
		}

		// Add user in the database
		public function addUser($firstName, $lastName, $email, $phoneNo, $password) : bool
		{
			$query = $this->mysqli->prepare("INSERT INTO users (id, first_name, last_name, email, created_at, updated_at, phone_no, password) value (0, ?, ?, ?, NOW(), NOW(), ?, ?)");

			$query->bind_param("sssss", $firstName, $lastName, $email, $phoneNo, $password);
			$query->execute();
			return true;
		}

		// Get user's information to prepopulate the edit user form
		public function getUser($id) : bool|object
		{
			$query = $this->mysqli->prepare("SELECT * FROM users where id = ?");
			$query->bind_param("s", $id);
			$query->execute();
			return $query->get_result();
		}

		// Update user informatuon
		public function updateUser($firstName, $lastName, $email, $phoneNo, $id) : bool
		{
			// Prepare query statement
			$query = $this->mysqli->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, updated_at = NOW(), phone_no = ?  WHERE id = ?");
			$query->bind_param("sssss", $firstName, $lastName, $email, $phoneNo, $id);
			$query->execute();	
			return true;
		}

		// Delete user
		public function deleteUser($id) : bool
		{
			// Prepare, bind param and execute query to delete user
			$query = $this->mysqli->prepare("DELETE FROM users WHERE id = ?");
			$query->bind_param("s", $id);

			$query->execute();
			return true;
		}

		// Search user by email
		public function searchUserByEmail($email) : bool|object
		{
			$query = $this->mysqli->prepare("SELECT * FROM users where email = ?");
			$query->bind_param("s", $email);

			$query->execute();
			return $query->get_result();
		}

		// Count number of rows
		public function countUsers() : bool|int
		{
			$query = $this->mysqli->query('SELECT COUNT(*) FROM users');
			$totalRows = $query->fetch_assoc();
			return $totalRows['COUNT(*)'];
		}

		// Lists all of the user by taking in the offset and the limit
		public function getUserDetails($offset, $limit) : bool|object
		{
			$query = $this->mysqli->prepare('SELECT * FROM users LIMIT ?, ?');
			$query->bind_param("ss", $offset, $limit);

			$query->execute();
			return $query->get_result();
		}
	}