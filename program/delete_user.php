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
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
	<title>Add User</title>
</head>
<body style="background-color: #EAEAEA; padding-top: 4rem;">
	<nav class="navbar px-3 fixed-top" style="background-color: #B2B2B2">
		<div class="d-flex align-items-center gap-3">
			<button type="button" class="btn btn-secondary" style="background-color: #3C4048;  --bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;">
				<a href="index.php" class="link-light">Home</a>
			</button>
			<button type="button" class="btn btn-secondary" style="background-color: #3C4048;  --bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;">
				<a href="add_user.php" class="link-light">Add user</a>
			</button>
			<button type="button" class="btn btn-secondary" style="background-color: #EAEAEA;  --bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;">
				<a href="list_user.php" class="link-dark">List user</a>
			</button>
		</div>
		<div class="d-flex align-items-right gap-3">
			<div class="d-flex align-items-center">
				<?php echo "Welcome ", $user; ?>
			</div>
		
			<button type="button" class="btn btn-secondary" style="background-color: #3C4048;  --bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;">
				<a href="logout.php" class="link-light">Logout</a>
			</button>
		</div>
	</nav>
	<?php
		$deleteUserQuery = $mysqli->prepare("DELETE FROM users WHERE id = ?");
		$deleteUserQuery->bind_param("s", $id);

		try
		{
			$deleteUserQuery->execute();
		}
		catch(\Throwable $e)
		{
			die("Error caught $e");
		}

		echo "User", $currentRow['first_name'], " ", $currentRow['last_name'], " has been deleted.";
	?>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"></script>
</body>
</html>