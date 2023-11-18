<?php
class PageGenerator
{
	public function __construct()
	{
		require_once("DatabaseOperation.php");

		$this->databaseConnection = new DatabaseOperation;
	}

	public function deleteUserPage()
	{
		// Check if user is logged in or not. Also checks for time out and HTTP_USER_AGENT
		require_once("manage_login_session.php");

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

		include_once("template/delete_user.html");

		// Checks if the id is number or not. If it is not error is displayed.
		if(!(preg_match('/^[0-9]*$/', $id)))
		{
			// invalidUser();
			include("template/message/user_invalid.html");
			exit();
		}

		// Check if user exists or not
		$user = $this->databaseConnection->getUser($id);
		if($user === null)
		{
			// userDoesNotExist();
			include("template/message/user_does_not_exist.html");
			exit();
		}

		// Delete user
		$userDeleted = $this->databaseConnection->deleteUser($id);
		if($userDeleted === true)
		{
			// userDeleted();
			include("template/message/user_deleted.html");
		}
	}

	public function editUserPage()
	{
		// Check if user is logged in or not. Also checks for time out and HTTP_USER_AGENT
		require_once("manage_login_session.php");
		

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

			$updateUser = $this->databaseConnection->updateUser($firstName, $lastName, $email, $phoneNo, $id);
		}

		// Get user information to prepopulate the edit user table
		$user = $this->databaseConnection->getUser($id);
		
		if($user == 0)
		{
			// userDoesNotExist();
			include("template/message/user_does_not_exist.html");
			exit();
		}

		include("template/edit_user.html");
	}

	public function loginPage()
	{
		
		// Create a session
		session_start();
		// Create a new session ID. This helps in session hijacking. Everytime a new page is opened, new session ID is created.
		session_regenerate_id();

		// If user is already logged in then page is redirected to home page
		if(isset($_SESSION['user']))
		{
			header("location: http://localhost/admin");
			exit();
		}

		// Set session timeout of 30 mins
		$timeout = 60*30;
		$_SESSION['timeout'] = time() + $timeout;
		if(time() > $_SESSION['timeout'])
		{
			session_destroy();
			header("location: http://localhost/admin");
			exit();
		}

		// Assigns hashed value of HTTP_USER_AGENT from server environment to session environment
		$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);

		// Check if the user has submitted the login form
		if(isset($_POST['username']))
		{
			// Validation of username and password
			if(!(preg_match('/^[A-Za-z][a-zA-Z0-9!@#$%^&*\-_]+$/', $_POST['username']) && preg_match('/^[0-9a-zA-z\-+$%^*&_#@!]+$/', $_POST['password'])))
			{
				die("Please enter correct information");
			}

			// Assign username and password to variable
			$userInputUsername = $_POST['username'];
			$userInputPassword = $_POST['password'];

			// Check if user exists or not.
			$adminRow = $this->databaseConnection->getAdmin($userInputUsername);
			// var_dump($adminRow);
			if($adminRow == null)
			{
				$userExist = false;
			}
			else
			{
				// If user exists then verify if the password is correct or not.
				if(password_verify($userInputPassword, $adminRow['password']))
				{
					// If it then assign username to a session variable
					$_SESSION['user'] = $userInputUsername;
					// Splits the privilege string into a string and save it into a session variable
					$_SESSION['privilege'] = explode(', ', $adminRow['privilege']); 

					// Checks if the login page was redirected from any other page. If it was then it is redirected to the same page otherwise it is redirected to home page
					if(isset($_SESSION['referer_page']))
					{
						header("location:" . $_SESSION['referer_page']);
						exit();
					}
					else
					{
						header("location: http://localhost/admin");
						exit();
					}
				}

				// If password is wrong then set incorrectPassword variable to 1
				else
				{
					$incorrectPassword = true;
				}
			}
		}

		include("template/login.html");
	}

	public function listUserPage()
	{
		// Check if user is logged in or not. Also checks for time out and HTTP_USER_AGENT
		require_once("manage_login_session.php");
		

		// Checks authorisation
		if(!(in_array("list_user", $_SESSION['privilege'])))
		{
			die("Access Denied");
		}

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
					$users = $this->databaseConnection->searchUsersByEmail($userEmailInput);
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
			$rowCount = $this->databaseConnection->countUsers();
			
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
			$users = $this->databaseConnection->getUsers($offset, $limit);

			// Print table and data in it
			if(!empty($users))
			{
				include("template/list_user.html");
			}
		}
	}

	public function addUserPage()
	{
		// Check if user is logged in or not. Also checks for time out and HTTP_USER_AGENT
		require_once("manage_login_session.php");
		

		// Checks authorisation
		if(!(in_array("add_user", $_SESSION['privilege'])))
		{
			die("Access Denied");
		}

		// Checks if the form was submitted or not by checking if first_name exists in header or not
		if(isset($_POST['first_name']))
		{
			// Uses regex to check all the header value to ensure only valid plain text is entered. If valid information is not entered, error is displayed
			if(preg_match('/^[A-Z][a-z]+$/', $_POST['first_name']) && preg_match('/^[A-Z][a-z]+$/', $_POST['last_name']) && preg_match('/^[a-zA-Z0-9][a-zA-Z0-9]*([_#$+*&{}=%^\/\-.!]*[a-zA-Z0-9])*@[a-zA-Z]*\.\w[a-zA-Z]*\.?\w[a-zA-Z]*$/', $_POST['email']) && preg_match('/^[0-9a-zA-z\-+$%^*&_#@!]+$/', $_POST['password']) && preg_match('/^[0-9]+$/', $_POST['phone_no']))
			{
				$firstName = $_POST['first_name'];
				$lastName = $_POST['last_name'];
				$email = $_POST['email'];
				$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
				$phoneNo = $_POST['phone_no'];

				// Add user to the database by calling add_user function
				$userCreated = $this->databaseConnection->addUser($firstName, $lastName, $email, $phoneNo, $password);

			}
			else
			{
				die("Please enter correct information");
			}
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
						$bulkUserCreated = $this->databaseConnection->addUser($firstName, $lastName, $email, $phoneNo, $password);

					}

					// Create a variable to check if the user bulk upload was successful or not
					$bulkUserCreated = true;
				}	
			}	
		}

		include("template/add_user.html");

		// Checks if userCreated has been declared and initialized
		if(isset($userCreated) && $userCreated == true)
		{
			// userCreated($firstName, $lastName);
			include("template/message/user_created.html");
		}

		// Checks if bulkUserCreated has been declared and initialized
		if(isset($bulkUserCreated) && $bulkUserCreated == true)
		{
			include("template/message/bulk_user_created.html");
		}
	}

	public function homepagePage()
	{
		require_once("manage_login_session.php");

		include("template/homepage.html");
	}

	public function erorr404Page()
	{
		require_once("manage_login_session.php");
		http_response_code(404);
		include ("template/404.html");
	}

	public function logoutPage()
	{
		// Create a session
		session_start();
		// Create a new session ID. This helps in session hijacking. Everytime a new page is opened, new session ID is created.
		session_regenerate_id();

		// If user is logged in then session destroyed and redirected to login page. If not then user is redirected to login page.
		if(isset($_SESSION['user']))
		{
			session_destroy();
			header("location: http://localhost/admin/login");
			exit();
		}

		else
		{
			header("location: http://localhost/admin/login");
			exit();
		}
	}
}