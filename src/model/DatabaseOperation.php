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

	public function getAdmin($username) : array
	{
		$sql = "SELECT
				  *
				FROM
				  admins
				WHERE
				  username = ? ";
		$query = $this->mysqli->prepare($sql);
		$query->bind_param("s", $username);
		$query->execute();			
		$result = $query->get_result();
		
		return $result->fetch_assoc();
	}

	// Add user in the database
	public function addUser($firstName, $lastName, $email, $phoneNo, $password) : bool
	{
		$sql = "INSERT INTO
				  users ( first_name, last_name, email, phone_no, password, created_at, updated_at)
				  value ( ?, ?, ?, ?, ?, NOW(), NOW())";
		$query = $this->mysqli->prepare($sql);
		$query->bind_param("sssss", $firstName, $lastName, $email, $phoneNo, $password);
		$query->execute();
		
		return true;
	}

	// Get user's information to prepopulate the edit user form
	public function getUser($id) : ?array
	{
		$sql = "SELECT
				  *
				FROM
				  users
				WHERE
				  id = ?";
		$query = $this->mysqli->prepare($sql);
		$query->bind_param("s", $id);
		$query->execute();
		$result = $query->get_result();
		
		return $result->fetch_assoc();
	}

	// Update user informatuon
	public function updateUser($firstName, $lastName, $email, $phoneNo, $id) : bool
	{
		$sql = "UPDATE 
				  users 
				SET 
				  first_name = ?, 
				  last_name = ?, 
				  email = ?, 
				  updated_at = NOW(), 
				  phone_no = ? 
				WHERE 
				  id = ?";

		$query = $this->mysqli->prepare($sql);

		$query->bind_param("sssss", $firstName, $lastName, $email, $phoneNo, $id);
		$query->execute();	
		
		return true;
	}

	// Delete user
	public function deleteUser($id) : bool
	{
		// Prepare, bind param and execute query to delete user
		$sql = "DELETE FROM
				  users
				WHERE
				  id = ?";

		$query = $this->mysqli->prepare($sql);
		$query->bind_param("s", $id);
		$query->execute();
		
		return true;
	}

	// Search user by email
	public function searchUsersByEmail($email) : array
	{
		$sql = "SELECT
				  *
				FROM
				  users
				WHERE
				  email = ?";

		$query = $this->mysqli->prepare($sql);
		$query->bind_param("s", $email);
		$query->execute();
		$result = $query->get_result();
		
		$users = [];

		while($user = $result->fetch_assoc())
		{
			$users[] = $user;
		}

		return $users;
	}

	// Count number of rows
	public function countUsers() : int
	{
		$sql = "SELECT
				  COUNT(*)
				FROM
				  users";

		$query = $this->mysqli->query($sql);
		$totalRows = $query->fetch_assoc();
		
		return $totalRows['COUNT(*)'];
	}

	// Lists all of the user by taking in the offset and the limit
	public function getUsers($offset, $limit) : array
	{
		$sql = "SELECT
				  *
				FROM
				  users
				LIMIT
				  ?, ?";

		$query = $this->mysqli->prepare($sql);
		$query->bind_param("ii", $offset, $limit);
		$query->execute();
		$result = $query->get_result();
		
		$users = [];

		while($user = $result->fetch_assoc())
		{
			$users[] = $user;
		}
	
		return $users;
	}
}