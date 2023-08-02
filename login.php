<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
</head>
<body>
	<form action="/login.php" method="post">
		<label for="username"> Username </label>
		<input style="margin-top: 10px;" type="text" name="username" minlength="1"> <br>
		<label for="password"> Password </label>
		<input style="margin-top: 10px;" type="password" name="password" minlength="8"> <br>
		<input style="margin-top: 10px;" type="submit" name="submit" value="Login"> 
	</form>

	<?php
		session_start();
		session_regenerate_id();
		if(isset($_SESSION['user']))
		{
			echo "true";
			header("location: index.php");
		}

		$timeout = 60*30;
		$_SESSION['timeout'] = time() + $timeout;
		if(time() > $_SESSION['timeout'])
		{
			session_destroy();
			header("location: login.php");
		}

		$serverName = '127.0.0.1';
		$user = getenv('DATABASE_USER');
		$dbPassword = getenv('DATABASE_PASSWORD');
		$dbName = getenv('DATABASE_NAME');

		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		$mysqli = new mysqli($serverName, $user, $dbPassword, $dbName);
		if(!$mysqli)
		{
			die("<br> Could not connect to server");
		}

		if(isset($_POST['username']))
		{
			$inputUsername = $_POST['username'];
			$inputPassword = $_POST['password'];

			$adminQuery = $mysqli->prepare("SELECT * from admin_table where username = ? ");
			$adminQuery->bind_param("s", $inputUsername);
			$adminQuery->execute();
			$results = $adminQuery->get_result();
			if(empty($results))
			{
				echo "User not found";
			}
			else
			{
				$adminRow = $results->fetch_assoc();

				if(password_verify($inputPassword, $adminRow['password']))
				{
					$_SESSION['user'] = $inputUsername;
					
					if(isset($_SESSION['referer_page']))
					{
						echo $_SESSION['referer_page'];
						header("location:" . $_SESSION['referer_page']);
					}
					else
					{
						header("location: index.php");
					}
				}
				else
				{
					echo("Incorrect password");
				}
			}
		}
	?>
</body>
</html>