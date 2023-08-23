<?php
	require_once("check_login.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
		<title>User Management System</title>
	</head>
	<body style="background-color: #EAEAEA; padding-top: 4rem;">

		<nav class="navbar px-3 fixed-top" style="background-color: #B2B2B2">
			<div class="d-flex align-items-center gap-3">
				<button type="button" class="btn btn-secondary" style="background-color: #EAEAEA;  --bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;">
					<a href="index.php" class="link-dark">Home</a>
				</button>
				<button type="button" class="btn btn-secondary" style="background-color: #3C4048;  --bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;">
					<a href="add_user.php" class="link-light">Add user</a>
				</button>
				<button type="button" class="btn btn-secondary" style="background-color: #3C4048;  --bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;">
					<a href="list_user.php" class="link-light">List user</a>
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

		<p class="text-dark" style="margin-top: 5rem;"> <center> <h1>Welcome to User Management System.</h1> </center> </p>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"></script>
	</body>
</html>