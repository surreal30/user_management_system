<?php

$position = strrpos(__DIR__, "/");
$dirPath = substr(__DIR__, 0, $position);

$modelDir = "/model/";

require_once $dirPath . $modelDir . "DatabaseOperation.php";
require_once $dirPath . "/manage_login_session.php";

class UserController
{
	public function deleteUser()
	{
		$sessionUser = manageSession();

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

		include_once("/app/template/delete_user.php");

		$databaseConnection = new DatabaseOperation;

		// Check if user exists or not
		$user = $databaseConnection->getUser($id);
		if($user === null)
		{
			// userDoesNotExist();
			include("/app/template/user_does_not_exist.php");
			exit();
		}

		// Delete user
		$userDeleted = $databaseConnection->deleteUser($id);
		if($userDeleted === true)
		{
			// userDeleted();
			include("/app/template/user_deleted.php");
		}
	}

	public function editUser()
	{
		$sessionUser = manageSession();

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

		// Checks if the id is number or not. If it is not error is displayed.
		if(!(preg_match('/^\d[0-9]*$/', $id)))
		{
			// invalidUser();
			include("/app/template/user_invalid.php");
			exit();
		}

		$databaseConnection = new DatabaseOperation;

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
		
		if($user == 0)
		{
			// userDoesNotExist();
			include("/app/template/user_does_not_exist.php");
			exit();
		}

		include("/app/template/edit_user.php");
	}

	public function listUser()
	{
		$sessionUser = manageSession();
		
		// Checks authorisation
		if(!(in_array("list_user", $_SESSION['privilege'])))
		{
			die("Access Denied");
		}

		$databaseConnection = new DatabaseOperation;

		// Checks if the user submitted search by email 
		if(isset($_GET['email']))
		{
			// Assign value to variable 
			$userEmailInput = $_GET["email"];	
			if($userEmailInput)
			{
				$users = $databaseConnection->searchUsersByEmail($userEmailInput);
				if(!empty($users))
				{
					// Print user table
					include("/app/template/list_user.php");
				}

				else
				{
					echo "<br> Email not found";
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

			$rowCount = $databaseConnection->countUsers();

			// Count the number of rows in the table for pagination
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
				include("/app/template/list_user.php");
			}
		}
	}

	public function addUser()
	{
		$sessionUser = manageSession();

		// Checks authorisation
		if(!(in_array("add_user", $_SESSION['privilege'])))
		{
			die("Access Denied");
		}

		$databaseConnection = new DatabaseOperation;

		// Checks if the form was submitted or not by checking if first_name exists in header or not
		if(isset($_POST['first_name']))
		{
			$firstName = $_POST['first_name'];
			$lastName = $_POST['last_name'];
			$email = $_POST['email'];
			$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
			$phoneNo = $_POST['phone_no'];

			// Add user to the database by calling add_user function
			$userCreated = $databaseConnection->addUser($firstName, $lastName, $email, $phoneNo, $password);
		}

		// Checks if user opted for bulk upload
		if(isset($_POST['bulk_upload']))
		{
			// checks if the file has been or uploaded or not
			if(is_uploaded_file($_FILES['data']['tmp_name']))
			{
				// Checks the file type of uploaded file. Only JSON is allowed
				if($_FILES['data']['type'] == 'application/json')
				{
					// Data of the file is transferred into a local variable
					$userFile = $_FILES['data']['tmp_name'];
					$fileContent = file_get_contents($userFile);

					// Decodes json file. If error occurs script stops.
					try
					{
						$fileData = json_decode($fileContent, TRUE);
					}
					catch(Throwable $e)
					{
						die("Error occured $e. Check if uploaded file is valid json file or not.");
					}

					// Loop to enter users in the database one by one.
					foreach ($fileData as $userData)
					{
						$firstName = $userData['first_name'];
						$lastName = $userData['last_name'];
						$email = $userData['email_id'];
						$password = password_hash($userData['password'], PASSWORD_DEFAULT);
						$phoneNo = $userData['mobile_no']; 

						// Add user to the database by calling add_user function
						$bulkUserCreated = $databaseConnection->addUser($firstName, $lastName, $email, $phoneNo, $password);

					}

					// Create a variable to check if the user bulk upload was successful or not
					$bulkUserCreated = true;
				}	
			}	
		}

		include("/app/template/add_user.php");

		// Checks if userCreated has been declared and initialized
		if(isset($userCreated) && $userCreated == true)
		{
			// userCreated($firstName, $lastName);
			include("/app/template/user_created.php");
		}

		// Checks if bulkUserCreated has been declared and initialized
		if(isset($bulkUserCreated) && $bulkUserCreated == true)
		{
			include("/app/template/bulk_user_created.php");
		}
	}
}