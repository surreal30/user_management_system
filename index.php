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

	
	<?php
		session_start();
		session_regenerate_id();
		if(!isset($_SESSION['user']))
		{
			header("location: login.php");
		}
		$user = $_SESSION['user'];
	?>

	<hr>
		<ul>
			<li> <a href="index.php"> Home </a> </li>
			<li> <a href="add_user.php"> Add user </a> </li>
			<li> <a href="list_user.php"> list user </a> </li>
			<li> <?php echo "Welcome ", $user; ?> </li>
			<li> <a href="logout.php"> Logout </a> </li>

		</ul>
	<hr>

	<p style="margin-top: 40px;"> <center> <h1>Welcome to User Management System.</h1> </center> </p>

</body>
</html>