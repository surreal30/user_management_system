<?php
	require_once("check_login.php");
	if(!($_SESSION['privilege'] == 'admin' || $_SESSION['privilege'] == 'add_user'))
	{
		die('Access denied');
	}
	$serverName = getenv('MYSQL_HOST');
	$user = getenv('MYSQL_USER');
	$dbPassword = getenv('MYSQL_PASSWORD');
	$dbName = getenv('MYSQL_DATABASE');


	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	$mysqli = new mysqli($serverName, $user, $dbPassword, $dbName, 3306);
	if(!$mysqli)
	{
		die("<br> Could not connect to server");
	}

	if(!isset($_GET['id']))
	{
		header("location: list_user.php");
	}
	else
	{
		$id = $_GET['id'];
	}

	$editUserQuery = $mysqli->prepare("SELECT * FROM users where id = ?");
	$editUserQuery->bind_param("s", $id);
	$editUserQuery->execute();

	$result = $editUserQuery->get_result();

	$currentRow = $result->fetch_assoc();
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
		<h1>Edit user</h1>
	</p>
	<p style="margin-top: 50px; margin-left: 100px;">
		<table style="margin-left: 50px">
			<form action="edit_user.php?id=<?php echo $id ?>" method="post">
				<tr> <td> <label for="first_name"> First Name </label> </td>
				     <td> <input style="margin-top: 10px;" type="text" name="first_name" minlength="1" value= "<?php echo $currentRow['first_name'] ?>"> </td></tr>
				<tr> <td> <label for="last_name"> Last Name </label></td>
				     <td> <input style="margin-top: 10px;" type="text" name="last_name" minlength="1" value="<?php echo $currentRow['last_name'] ?>"></td></tr>
				<tr> <td> <label for="email"> Email</label> </td>
				     <td> <input style="margin-top: 10px;" type="email" name="email" minlength="1" value="<?php echo $currentRow['email'] ?>"></td></tr>
				<tr> <td> <label for="phone_no"> Phone Number</label> </td>
				     <td> <input style="margin-top: 10px;" type="text" name="phone_no" minlength="10" maxlength="10" value="<?php echo $currentRow['phone_no'] ?>"> </td></tr>
				<tr> <td> <input style="margin-top: 10px;" type="submit" name="submit" value="Update User"> </td></tr>
			</form>
		</table>
	</p>
	<?php
		if(isset($_POST['first_name']))
		{
			$firstName = $_POST['first_name'];
			$lastName = $_POST['last_name'];
			$email = $_POST['email'];
			$phoneNo = $_POST['phone_no'];	

			$editUserQuery = $mysqli->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, updated_at = NOW(), phone_no = ?  WHERE id = ?");

			try
			{
				$editUserQuery->bind_param("sssss", $firstName, $lastName, $email, $phoneNo, $id);
				$editUserQuery->execute();	
			}
			catch(\Throwable $e)
			{
				die("Error occured $e");
			}
			echo " <h3> User $firstName $lastName has been updated. </h3>";
		}
	?>
</body>
</html>