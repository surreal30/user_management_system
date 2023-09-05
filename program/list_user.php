<?php
	// Check if user is logged in or not. Also checks for time out and HTTP_USER_AGENT
	require_once("check_login.php");

	// Checks authorisation
	if(!($_SESSION['privilege'] == 'admin' || str_contains($_SESSION['privilege'],'list_user')))
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
<body>

	<!-- navbar  -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
		<div class="collapse navbar-collapse d-flex align-items-center gap-3" id="navbarNavDropdown">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="http://localhost:8080/admin">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="http://localhost:8080/admin/users/add">Add User</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" href="http://localhost:8080/admin/users">List User</a>
				</li>
			</ul>
		</div>
		<div class="d-flex align-items-right gap-3">
			<ul class="navbar-nav">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php echo "Welcome, ", $user; ?>
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
						<a class="dropdown-item" href="http://localhost:8080/admin/logout">Logout</a>
					</div>
				</li>
			</ul>
		</div>
	</nav>

	<p>
		<div class="d-flex align-items-center justify-content-center pt-5">
			<div class="card d-flex align-items-center justify-content-center pt-4 border-primary" style="width: 25rem; border-radius: 1rem; margin-top: 1rem;"> 
			<form action="http://localhost:8080/admin/users" method="get" align="center">
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
				<form action="http://localhost:8080/admin/users" method="get" align="center">
					<label for="count"> Queries per page </label>
					<select class="select-label" name="count" id="count">
						<option value="5">5</option>
						<option value="10">10</option>
						<option value="20">20</option>
					</select>
					<button class='btn btn-primary' style='--bs-btn-padding-y: .20rem; --bs-btn-padding-x: 1rem;' type="submit">Search</button>
				</form>
			</div>
		</div>

		<?php
			// Assigns database secrets from environment
			$serverName = getenv('MYSQL_HOST');
			$user = getenv('MYSQL_USER');
			$dbPassword = getenv('MYSQL_PASSWORD');
			$dbName = getenv('MYSQL_DATABASE');

			mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

			// Create a database connection
			$mysqli = new mysqli($serverName, $user, $dbPassword, $dbName, 3306);
			// Checks if the the connection was established or not. If not then error is displayed and script stops 
			if(!$mysqli)
			{
				die("<br> Could not connect to server");
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
						// Prepare, bind param and execute the query
						$checkEmailQuery = $mysqli->prepare("SELECT * FROM users where email = ?");
						$checkEmailQuery->bind_param("s", $userEmailInput);
						$checkEmailQuery->execute();
						$results = $checkEmailQuery->get_result();
						if(!empty($results))
				{
					// Print table and data in it
					echo "<center>";
					echo "<table class='table table-striped table-hover text-center' style='width: 1200px; margin-top: 30px;'> <tbody>";
					echo "<tr class='table-dark ' scope='row'> <th scope='col' colspan='7'> User Details </th> </tr>";
					echo "<tr scope='row' class='table-dark text-center'> <td scope='col' > <b> Name </b> </td> ", "<td scope='col'> <b> Email </b> </td>", "<td scope='col'> <b> User Created At </b> </td>", "<td scope='col'> <b> User Updated at </b> </td>", "<td scope='col'> <b> Phone No </b> </td> <td scope='col'> Edit </td> <td scope='col'> Delete </td> </tr> </b>";

					while ($currentRow = $results->fetch_assoc())
					{
						echo "<tr class='text-center' scope='row'> <td>", $currentRow['first_name'], " ", $currentRow['last_name'], "</td> <td>", $currentRow['email'], "</td> <td>", $currentRow['created_at'], "</td> <td>", $currentRow['updated_at'], "</td> <td>", $currentRow['phone_no'], "</td> <td style='text-align: center' > <a href='http://localhost:8080/admin/users/", $currentRow['id'], "/edit' <span> <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'> <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/> <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/> </svg> </span> </a> </td> <td style='text-align: center'> <a href='http://localhost:8080/admin/users/", $currentRow['id'], "/delete' <span> <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='red' class='bi bi-trash' viewBox='0 0 16 16'> <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z'/> <path d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z'/> </svg> </span> </a> </td> </tr>" ;
					
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

			// Check if the user is on other page
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
				$countQuery = $mysqli->query('SELECT COUNT(*) FROM users');
				$totalRows = $countQuery->fetch_assoc();
				$rowCount = $totalRows['COUNT(*)'];

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

				// Prepare, bind param and execute the statement to extrace the data from the table
				$selectRowQuery = $mysqli->prepare('SELECT * FROM users LIMIT ?, ?');
				$selectRowQuery->bind_param("ss", $offset, $limit);
				$selectRowQuery->execute();
				$results = $selectRowQuery->get_result();

				// Print table and data in it
				if(!empty($results))
				{
					echo "<center>";
					echo "<table class='table table-striped table-hover text-center' style='width: 1200px; margin-top: 30px;'> <tbody>";
					echo "<tr class='table-dark ' scope='row'> <th scope='col' colspan='7'> User Details </th> </tr>";
					echo "<tr scope='row' class='table-dark text-center'> <td scope='col' > <b> Name </b> </td> ", "<td scope='col'> <b> Email </b> </td>", "<td scope='col'> <b> User Created At </b> </td>", "<td scope='col'> <b> User Updated at </b> </td>", "<td scope='col'> <b> Phone No </b> </td> <td scope='col'> Edit </td> <td scope='col'> Delete </td> </tr> </b>";

					while ($currentRow = $results->fetch_assoc())
					{
						echo "<tr class='text-center' scope='row'> <td>", $currentRow['first_name'], " ", $currentRow['last_name'], "</td> <td>", $currentRow['email'], "</td> <td>", $currentRow['created_at'], "</td> <td>", $currentRow['updated_at'], "</td> <td>", $currentRow['phone_no'], "</td> <td style='text-align: center' > <a href='http://localhost:8080/admin/users/", $currentRow['id'], "/edit'> <span> <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'> <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/> <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/> </svg> </span> </a> </td> <td style='text-align: center'> <a href='http://localhost:8080/admin/users/", $currentRow['id'], "/delete' <span> <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='red' class='bi bi-trash' viewBox='0 0 16 16'> <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z'/> <path d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z'/> </svg> </span> </a> </td> </tr>" ;
					}

					echo "</tbody></table>";
					echo "<nav>";
					echo "<div class='d-flex align-items-center justify-content-center gap-2'>";

					// Pagination. Checks if currentPage is more than total number of pages or currentPage is not a number then sets currentPage to 1
					if($currentPage > $totalPages || !(preg_match('<^\d[0-9]*$>', $currentPage)))
					{
						$currentPage = 1;
						$nextPage = $currentPage + 1;
						$thirdPage = $nextPage + 1;
						echo <<<PAGEINATION
							
								<ul class='pagination pagination-circle mb-0'>
									<li class='page-item disabled'>
										<a class='page-link' href='http://localhost:8080/admin/users?page=1&count=$limit' >First</a>
									</li> 
									<li class='page-item disabled'>
										<a class='page-link' href='http://localhost:8080/admin/users?page=1&count=$limit'><span aria-hidden="true">&laquo;</span></a>
									</li>
									<li class='page-item active'> 
										<a class='page-link' href='http://localhost:8080/admin/users?page=$currentPage&count=$limit'> $currentPage </a>
									</li>
									<li class='page-item'>
										<a class='page-link' href='http://localhost:8080/admin/users?page=$nextPage&count=$limit'> $nextPage </a>
									</li>
									<li class='page-item'>
										<a class='page-link' href='http://localhost:8080/admin/users?page=$thirdPage&count=$limit'> $thirdPage</a>
									</li>
									<li class='page-item'>
										<a class='page-link' href='http://localhost:8080/admin/users?page=$nextPage&count=$limit'><span aria-hidden="true">&raquo;</span></a>
									</li>
									<li class='page-item'>
										<a class='page-link' href='http://localhost:8080/admin/users?page=$totalPages&count=$limit'>Last</a>
									</li>
								</ul>
						PAGEINATION;	
					}
					elseif($currentPage == 1)
					{
						$nextPage = $currentPage + 1;
						$thirdPage = $nextPage + 1;
						echo <<<PAGEINATION
							
								<ul class='pagination pagination-circle mb-0'>
									<li class='page-item disabled'>
										<a class='page-link' href='http://localhost:8080/admin/users?page=1&count=$limit' >First</a>
									</li> 
									<li class='page-item disabled'>
										<a class='page-link' href='http://localhost:8080/admin/users?page=1&count=$limit'><span aria-hidden="true">&laquo;</span></a>
									</li>
									<li class='page-item active'> 
										<a class='page-link' href='http://localhost:8080/admin/users?page=$currentPage&count=$limit'> $currentPage </a>
									</li>
									<li class='page-item'>
										<a class='page-link' href='http://localhost:8080/admin/users?page=$nextPage&count=$limit'> $nextPage </a>
									</li>
									<li class='page-item'>
										<a class='page-link' href='http://localhost:8080/admin/users?page=$thirdPage&count=$limit'> $thirdPage</a>
									</li>
									<li class='page-item'>
										<a class='page-link' href='http://localhost:8080/admin/users?page=$nextPage&count=$limit'><span aria-hidden="true">&raquo;</span></a>
									</li>
									<li class='page-item'>
										<a class='page-link' href='http://localhost:8080/admin/users?page=$totalPages&count=$limit'>Last</a>
									</li>
								</ul>
						PAGEINATION;
					}

					elseif($currentPage < $totalPages )
					{
						$backPage = $currentPage - 1;
						$nextPage = $currentPage + 1;
						
						echo <<<PAGEINATION
								<ul class='pagination pagination-circle mb-0'>
									<li class='page-item'>
										<a class='page-link' href='http://localhost:8080/admin/users?page=1&count=$limit' >First</a>
									</li>
									<li class='page-item'>
										<a class='page-link' href='http://localhost:8080/admin/users?page=$backPage&count=$limit'><span aria-hidden="true">&laquo;</span></a>
									</li>
									<li class='page-item'> 
										<a class='page-link' href='http://localhost:8080/admin/users?page=$backPage&count=$limit'> $backPage </a>
									</li>
									<li class='page-item active'>
										<a class='page-link' href='http://localhost:8080/admin/users?page=$currentPage&count=$limit'> $currentPage </a>
									</li>
									<li class='page-item'>
										<a class='page-link' href='http://localhost:8080/admin/users?page=$nextPage&count=$limit'> $nextPage </a>
									</li>
									<li class='page-item'>
										<a class='page-link' href='http://localhost:8080/admin/users?page=$nextPage&count=$limit'><span aria-hidden="true">&raquo;</span></a>
									</li>
									<li class='page-item'>
										<a class='page-link' href='http://localhost:8080/admin/users?page=$totalPages&count=$limit'>Last</a>
									</li>
								</ul>
						PAGEINATION;
					}

					else
					{
						$backPage = $currentPage - 1;
						$lastThirdPage = $backPage - 1;
						
						echo <<<PAGEINATION
							
								<ul class='pagination pagination-circle mb-0'>
									<li class='page-item'>
										<a class='page-link' href='http://localhost:8080/admin/users?page=1&count=$limit' >First</a>
									</li>
									<li class='page-item'>
										<a class='page-link' href='http://localhost:8080/admin/users?page=$backPage&count=$limit'><span aria-hidden="true">&laquo;</span></a>
									</li>
									<li class='page-item'> 
										<a class='page-link' href='http://localhost:8080/admin/users?page=$lastThirdPage&count=$limit'> $lastThirdPage </a>
									</li>
									<li class='page-item '>
										<a class='page-link' href='http://localhost:8080/admin/users?page=$backPage&count=$limit'> $backPage </a>
									</li>
									<li class='page-item active'>
										<a class='page-link' href='http://localhost:8080/admin/users?page=$currentPage&count=$limit'> $currentPage</a>
									</li>
									<li class='page-item disabled'>
										<a class='page-link' href='http://localhost:8080/admin/users?page=$totalPages&count=$limit'><span aria-hidden="true">&raquo;</span></a>
									</li>
									<li class='page-item disabled'>
										<a class='page-link' href='http://localhost:8080/admin/users?page=$totalPages&count=$limit'>Last</a>
									</li>
								</ul>
						PAGEINATION;
					}
					echo "</div>";
					echo "</nav>";
					echo " </center>";
				}
			}
		?>
    </p>

    <!-- CDN links for bootstrap CSS -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>