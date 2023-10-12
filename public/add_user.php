<?php
	// Check if user is logged in or not. Also checks for time out and HTTP_USER_AGENT
	require_once("manage_login_session.php");
	require_once("DatabaseOperation.php");
	require_once("manage_html.php");
	
	define("PAGE", "addUser");
	define("TITLE", "Add User");

	// Checks authorisation
	if(!(in_array("add_user", $_SESSION['privilege'])))
	{
		die("Access Denied");
	}
	// Create a connection to the database
	$database = new DatabaseOperation();

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
			$userCreated = $database->addUser($firstName, $lastName, $email, $phoneNo, $password);

			if($userCreated == false)
			{
				die("Some error occured");
			}
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
					$bulkUserCreated = $database->addUser($firstName, $lastName, $email, $phoneNo, $password);
					if($bulkUserCreated == false)
					{
						die("Some error occured");
					}
				}

				// Create a variable to check if the user bulk upload was successful or not
				$bulkUserCreated = true;
			}	
		}
		
	}

	htmlBeginning(TITLE);

	navbar($sessionUser, PAGE);	

	$link = "http://localhost/admin/users/add";
	addUserForm($link);

	// Checks if userCreated has been declared and initialized
	if(isset($userCreated))
	{
		// Checks the value of userCreated. If it is 1 then the user was created and message is displayed
		if($userCreated == true)
		{
			userCreated($firstName, $lastName);
		}
	}

	// Checks if bulkUserCreated has been declared and initialized
	if(isset($bulkUserCreated))
	{
		// Checks the value of bulkUserCreated. If it 1 then the user was created and message is displayed
		if($bulkUserCreated == true)
		{
			bulkUserCreated();
		}
	}
	htmlEnding();