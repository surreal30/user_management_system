<?php
	require_once("check_login.php");
	if(!($_SESSION['privilege'] == 'admin' || $_SESSION['privilege'] == 'list_user'))
	{
		die('Access denied');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
	<title>User Management System</title>
</head>
<body >
	<nav class="navbar px-3 fixed-top" >
			<div class="d-flex align-items-center gap-3">
				<a href="index.php" class="btn btn-primary" role="button" data-bs-toggle="button">Home</a>
				<a href="add_user.php" class="btn btn-primary" role="button" data-bs-toggle="button">Add user</a>
				<a href="list_user.php" class="btn btn-outline-primary" role="button" data-bs-toggle="button">List user</a>
			</div>

			<div class="d-flex align-items-right gap-3">
				<div class="dropdown">
					<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
							<?php echo "Welcome ", $user; ?>
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item" href="logout.php">Logout &nbsp; <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/> <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/> </svg></a>

					</div>
				</div>
			</div>
		</nav>

	<p>
		<div class="d-flex align-items-center justify-content-center pt-5">
			<div class="card d-flex align-items-center justify-content-center pt-4 border-primary" style="width: 25rem; border-radius: 1rem; margin-top: 1rem;"> 
			<form action="list_user.php" method="get" align="center">
				<div class="form-outline mb-3" style="width: 350px;">
					<input type="text" name="email" id="email" placeholder="example@domain.com" maxlength="30" minlength="1" class="form-control form-control-lg" >
		        </div>
				<div class="pt-1 mb-4">
	            	<button class="btn btn-primary btn-lg btn-block" type="submit">Search</button>
	        	</div>
			</form>
			</div>
		</div>
		<div class="d-flex align-items-center justify-content-center pt-2">
			<div class="card d-flex align-items-center justify-content-center py-4 border-primary" style="width: 25rem; border-radius: 1rem;">
				<form action="list_user.php" method="get" align="center">
					<label for="count"> Queries per page </label>
					<select class="select-label" name="count" id="count">
						<option value="5">5</option>
						<option value="10">10</option>
						<option value="20">20</option>
					</select>
					<button class='btn btn-primary' style='--bs-btn-padding-y: .20rem; --bs-btn-padding-x: 1rem;' type="submit" name="submit">Search</button>
				</form>
			</div>
		</div>

		<?php
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

			if(isset($_GET['email']))
			{
				$userEmailInput = $_GET["email"];	

				if($userEmailInput)
				{
					if(preg_match('/^[a-zA-Z0-9][a-zA-Z0-9]*([_#$+*&{}=%^\/\-.!]*[a-zA-Z0-9])*@[a-zA-Z]*\.\w[a-zA-Z]*\.?\w[a-zA-Z]*$/', $userEmailInput))
					{
						$checkEmailQuery = $mysqli->prepare("SELECT * FROM users where email = ?");
						$checkEmailQuery->bind_param("s", $userEmailInput);
						$checkEmailQuery->execute();
						$results = $checkEmailQuery->get_result();
						if(!empty($results))
				{
					echo "<center>";
					echo "<table class='table table-striped table-hover text-center' style='width: 1200px; margin-top: 30px;'> <tbody>";
					echo "<tr class='table-dark ' scope='row'> <th scope='col' colspan='7'> User Details </th> </tr>";
					echo "<tr scope='row' class='table-dark text-center'> <td scope='col' > <b> Name </b> </td> ", "<td scope='col'> <b> Email </b> </td>", "<td scope='col'> <b> User Created At </b> </td>", "<td scope='col'> <b> User Updated at </b> </td>", "<td scope='col'> <b> Phone No </b> </td> <td scope='col'> Edit </td> <td scope='col'> Delete </td> </tr> </b>";

					while ($currentRow = $results->fetch_assoc())
					{
						echo "<tr class='text-center' scope='row'> <td>", $currentRow['first_name'], " ", $currentRow['last_name'], "</td> <td>", $currentRow['email'], "</td> <td>", $currentRow['created_at'], "</td> <td>", $currentRow['updated_at'], "</td> <td>", $currentRow['phone_no'], "</td> <td style='text-align: center' > <a href='edit_user.php?id=", $currentRow['id'], "' <span> <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'> <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/> <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/> </svg> </span> </a> </td> <td style='text-align: center'> <a href='delete_user.php?id=", $currentRow['id'], "' <span> <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'> <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z'/> <path d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z'/> </svg> </span> </a> </td> </tr>" ;
					
					}

					echo "</tbody></table>";
						}
						else
						{
							echo "<br> Email not found";
						}
						
					}
				}
			}

			else
			{
				if(!isset($_GET['page']))
				{
					$currentPage = 1;
				}
				else
				{
					$currentPage = $_GET['page'];
				}

				$countQuery = $mysqli->query('SELECT COUNT(*) FROM users');
				$totalRows = $countQuery->fetch_assoc();
				$rowCount = $totalRows['COUNT(*)'];

				if(!isset($_GET['count']))
				{
					$limit = 5;
				}
				else
				{
					$limit = $_GET['count'];
				}

				$totalPages = ceil($rowCount/$limit);


				$offset = ($currentPage - 1) * $limit;
				$selectRowQuery = $mysqli->prepare('SELECT * FROM users LIMIT ?, ?');
				$selectRowQuery->bind_param("ss", $offset, $limit);
				$selectRowQuery->execute();
				$results = $selectRowQuery->get_result();

				if(!empty($results))
				{
					echo "<center>";
					echo "<table class='table table-striped table-hover text-center' style='width: 1200px; margin-top: 30px;'> <tbody>";
					echo "<tr class='table-dark ' scope='row'> <th scope='col' colspan='7'> User Details </th> </tr>";
					echo "<tr scope='row' class='table-dark text-center'> <td scope='col' > <b> Name </b> </td> ", "<td scope='col'> <b> Email </b> </td>", "<td scope='col'> <b> User Created At </b> </td>", "<td scope='col'> <b> User Updated at </b> </td>", "<td scope='col'> <b> Phone No </b> </td> <td scope='col'> Edit </td> <td scope='col'> Delete </td> </tr> </b>";

					while ($currentRow = $results->fetch_assoc())
					{
						echo "<tr class='text-center' scope='row'> <td>", $currentRow['first_name'], " ", $currentRow['last_name'], "</td> <td>", $currentRow['email'], "</td> <td>", $currentRow['created_at'], "</td> <td>", $currentRow['updated_at'], "</td> <td>", $currentRow['phone_no'], "</td> <td style='text-align: center' > <a href='edit_user.php?id=", $currentRow['id'], "' <span> <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'> <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/> <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/> </svg> </span> </a> </td> <td style='text-align: center'> <a href='delete_user.php?id=", $currentRow['id'], "' <span> <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'> <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z'/> <path d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z'/> </svg> </span> </a> </td> </tr>" ;
					
					}

					echo "</tbody></table>";
					echo "<nav>";
					echo "<div class='d-flex align-items-center justify-content-center gap-2'>";
					if($currentPage == 1)
					{
						$nextPage = $currentPage + 1;
						$thirdPage = $nextPage + 1;
						echo <<<PAGEINATION
							
								<ul class='pagination pagination-circle mb-0'>
									<li class='page-item active'> 
										<a class='page-link' href='list_user.php?page=$currentPage&count=$limit'> $currentPage </a>
									</li>
									<li class='page-item'>
										<a class='page-link' href='list_user.php?page=$nextPage&count=$limit'> $nextPage </a>
									</li>
									<li class='page-item'>
										<a class='page-link' href='list_user.php?page=$thirdPage&count=$limit'> $thirdPage</a>
									</li>
									<li class='page-item'>
										<a class='page-link' href='list_user.php?page=$totalPages&count=$limit'> $totalPages</a>
									</li>
								</ul>
						PAGEINATION;
						echo "<button class='btn btn-primary' style='--bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;'> <a class='link-light' href='list_user.php?page=", $nextPage, "&count=", $limit, "'> Next </a> </button>";
					}
					elseif($currentPage == 2)
					{
						$backPage = $currentPage - 1;
						$nextPage = $currentPage + 1;
						$thirdPage = $nextPage + 1;
						echo "<button class='btn btn-primary' style='--bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;'><a class='link-light' href='list_user.php?page=", $backPage, "&count=", $limit, "'>Back</a></button>";
						echo " &nbsp;&nbsp&nbsp;&nbsp;&nbsp;";
						echo <<<PAGEINATION
							
								<ul class='pagination pagination-circle mb-0'>
									<li class='page-item'>
										<a class='page-link' href='list_user.php?page=1&count=$limit' > 1</a>
									</li>
									<li class='page-item active'> 
										<a class='page-link' href='list_user.php?page=$currentPage&count=$limit'> $currentPage </a>
									</li>
									<li class='page-item'>
										<a class='page-link' href='list_user.php?page=$nextPage&count=$limit'> $nextPage </a>
									</li>
									<li class='page-item'>
										<a class='page-link' href='list_user.php?page=$thirdPage&count=$limit'> $thirdPage</a>
									</li>

									<li class='page-item'>
										<a class='page-link' href='list_user.php?page=$totalPages&count=$limit'> $totalPages</a>
									</li>
								</ul>
						PAGEINATION;
						echo "<button class='btn btn-primary' style='--bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;'> <a class='link-light' href='list_user.php?page=", $nextPage, "&count=", $limit, "'> Next </a> </button>";
					}
					elseif($currentPage < $totalPages - 1)
					{
						$backPage = $currentPage - 1;
						$nextPage = $currentPage + 1;
						echo "<button class='btn btn-primary' style='--bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;'><a class='link-light' href='list_user.php?page=", $backPage, "&count=", $limit, "'>Back</a></button>";
						echo " &nbsp;&nbsp&nbsp;&nbsp;&nbsp;";
						
						echo <<<PAGEINATION
							
								<ul class='pagination pagination-circle mb-0'>
									<li class='page-item'>
										<a class='page-link' href='list_user.php?page=1&count=$limit' > 1</a>
									</li>
									<li class='page-item'> 
										<a class='page-link' href='list_user.php?page=$backPage&count=$limit'> $backPage </a>
									</li>
									<li class='page-item active'>
										<a class='page-link' href='list_user.php?page=$currentPage&count=$limit'> $currentPage </a>
									</li>
									<li class='page-item'>
										<a class='page-link' href='list_user.php?page=$nextPage&count=$limit'> $nextPage </a>
									</li>
									<li class='page-item'>
										<a class='page-link' href='list_user.php?page=$totalPages&count=$limit'> $totalPages</a>
									</li>
								</ul>
						PAGEINATION;
						echo " &nbsp;&nbsp&nbsp;&nbsp;&nbsp;";
						echo "<button class='btn btn-primary' style='--bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;'> <a class='link-light' href='list_user.php?page=", $nextPage, "&count=", $limit, "'> Next </a> </button>";
					}
					elseif($currentPage == $totalPages - 1)
					{
						$backPage = $currentPage - 1;
						$nextPage = $currentPage + 1;
						$lastThirdPage = $backPage - 1;
						$lastFourthPage = $lastThirdPage - 1;
						echo "<button class='btn btn-primary' style='--bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;'><a class='link-light' href='list_user.php?page=", $backPage, "&count=", $limit, "'>Back</a></button>";
						echo " &nbsp;&nbsp&nbsp;&nbsp;&nbsp;";
						
						echo <<<PAGEINATION
							
								<ul class='pagination pagination-circle mb-0'>
									<li class='page-item'>
										<a class='page-link' href='list_user.php?page=$1&count=$limit'> 1</a>
									</li>
									<li class='page-item'> 
										<a class='page-link' href='list_user.php?page=$lastFourthPage&count=$limit'> $lastFourthPage </a>
									</li>
									<li class='page-item'> 
										<a class='page-link' href='list_user.php?page=$backPage&count=$limit'> $backPage </a>
									</li>
									<li class='page-item active'>
										<a class='page-link' href='list_user.php?page=$currentPage&count=$limit'> $currentPage </a>
									</li>
									<li class='page-item'>
										<a class='page-link' href='list_user.php?page=$nextPage&count=$limit'> $nextPage </a>
									</li>
								</ul>
						PAGEINATION;
						echo " &nbsp;&nbsp&nbsp;&nbsp;&nbsp;";
						echo "<button class='btn btn-primary' style='--bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;'> <a class='link-light' href='list_user.php?page=", $nextPage, "&count=", $limit, "'> Next </a> </button>";
					}
					elseif($currentPage == $totalPages)
					{
						$backPage = $currentPage - 1;
						$lastThirdPage = $backPage - 1;
						
						echo "<button class='btn btn-primary' style='--bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;'><a class='link-light' href='list_user.php?page=", $backPage, "&count=", $limit, "'>Back</a></button>";
						echo <<<PAGEINATION
							
								<ul class='pagination pagination-circle mb-0'>
									<li class='page-item'>
										<a class='page-link' href='list_user.php?page=1&count=$limit'> 1</a>
									</li>
									
									<li class='page-item'> 
										<a class='page-link' href='list_user.php?page=$lastThirdPage&count=$limit'> $lastThirdPage </a>
									</li>
									<li class='page-item '>
										<a class='page-link' href='list_user.php?page=$backPage&count=$limit'> $backPage </a>
									</li>
									<li class='page-item active'>
										<a class='page-link' href='list_user.php?page=$currentPage&count=$limit'> $currentPage</a>
									</li>
								</ul>
						PAGEINATION;
					}
					echo "</div>";
					echo "</nav>";
					echo " </center> &#x1f600";
				}
			}
		?>
    </p>

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>