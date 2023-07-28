<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>User Management System</title>
</head>
<body>
	<style>
		a{
			color: #FFFFFF;
		}
		ul{
			background-color: #000000;
		}
		li{
			color: #FFFFFF;
			display: inline;
			margin: 30px;
		}
	</style>

	<hr>
		<ul>
			<li> <a href="index.php"> Home </a> </li>
			<li> <a href="add_user.php"> Add user </a> </li>
			<li> <a href="list_user.php"> list user </a> </li>
		</ul>
	<hr>

	<p style="margin-top: 50px;">
		<?php

			require_once('DotEnv.php');

			(new DotEnv(__DIR__ . '/../user_db/.env'))->load();

			$serverName = $_ENV['DATABASE_HOST'];
			$user = $_ENV['DATABASE_USER'];
			$password = $_ENV['DATABASE_PASSWORD'];
			$dbName = $_ENV['DATABASE_NAME'];

			// echo $serverName, $user, $password, $dbName;

			mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

			$mysqli = new mysqli($serverName, $user, $password, $dbName);
			if(!$mysqli)
			{
				die("\n Database not connected");
			}
			// else
			// {
			// 	echo "\n connected";
			// }

			$queryStatement = $mysqli->prepare("INSERT INTO users (id, first_name, last_name, email, created_at, updated_at, phone_no, password) value (0, ?, ?, ?, NOW(), NOW(), ?, ?)");
			$firstName = $_POST['first_name'];
			$lastName = $_POST['last_name'];
			$email = $_POST['email'];
			$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
			$phoneNo = $_POST['phone_no'];

			try
			{
				$queryStatement->bind_param("sssss", $firstName, $lastName, $email, $phoneNo, $password);
				$queryStatement->execute();
			}
			catch(\Throwable $e)
			{
				die("Error occured $e");
			}

			echo " <h3> User $firstName $lastName created and add to database. </h3>";
		?>
	</p>


</body>
</html>


