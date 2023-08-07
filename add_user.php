<?php
	require_once("check_login.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add User</title>
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
			<li> <?php echo "Welcome ", $user; ?> </li>
			<li> <a href="logout.php"> Logout </a> </li>
		</ul>
	<hr>

	<p style="margin-top: 50px; margin-left: 100px;">
		<h1>Add user in the database</h1>
	</p>
	<p style="margin-top: 50px; margin-left: 100px;">
		<table style="margin-left: 50px">
			<form action="add_user.php" method="post">
				<tr> <td> <label for="first_name"> First Name </label>                                                                         </td>
				     <td> <input style="margin-top: 10px;" type="text" name="first_name" minlength="1" placeholder="John">                     </td></tr>
				<tr> <td> <label for="last_name"> Last Name </label>                                                                           </td>
				     <td> <input style="margin-top: 10px;" type="text" name="last_name" minlength="1" placeholder="Doe">                       </td></tr>
				<tr> <td> <label for="email"> Email</label>                                                                                    </td>
				     <td> <input style="margin-top: 10px;" type="email" name="email" minlength="1" placeholder="example@domain.com">           </td></tr>
				<tr> <td> <label for="password"> Password </label>                                                                             </td>
				     <td> <input style="margin-top: 10px;" type="password" name="password" minlength="1">                                      </td></tr>
				<tr> <td> <label for="phone_no"> Phone Number</label>                                                                          </td>
				     <td> <input style="margin-top: 10px;" type="text" name="phone_no" minlength="10" maxlength="10" placeholder="0123456789"> </td></tr>
				<tr> <td> <input style="margin-top: 10px;" type="submit" name="submit" value="Create User">                                    </td></tr>
			</form>
		</table>
	</p>

	<p>
		<?php

			$serverName = '127.0.0.1';
			$user = getenv('DATABASE_USER');
			$password = getenv('DATABASE_PASSWORD');
			$dbName = getenv('DATABASE_NAME');

			mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

			$mysqli = new mysqli($serverName, $user, $password, $dbName);
			if(!$mysqli)
			{
				die("\n Database not connected");
			}

			if(isset($_POST['first_name']))
			{
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

				echo " <h3> User $firstName $lastName has been created and added to database. </h3>";
			}
			
		?>
	</p>

</body>
</html>