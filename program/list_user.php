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
<<<<<<< Updated upstream
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
		$pageBox {
			border: 1px;
			width: 100px;
			height: 60px;
			text-align: center;
			padding: 10px;
			background-color: black;
			position: relative;
		}
	</style>
	
	<hr>
		<ul>
			<li> <a href="index.php"> Home </a> </li>
			<li> <a href="add_user.php"> Add user </a> </li>
			<li> <a href="list_user.php"> list user </a> </li>
			<li> <?php echo "Welcome ", $_SESSION['user']; ?> </li>
			<li> <a href="logout.php"> Logout </a> </li>

		</ul>
	<hr>

	<p> 
		<form action="list_user.php" method="get" align="center">
			<input type="text" name="email" id="email" placeholder="example@domain.com" maxlength="30" minlength="1"> <br> <br>
			<input type="submit" name="Submit"> <br><br>
		</form>

		<form action="list_user.php" method="get" align="center">
			<label for="queryNo"> Queries per page </label>
			<select name="queryNo" id="queryNo">
				<option value="5">5</option>
				<option value="10">10</option>
				<option value="20">20</option>
			</select>
			<input type="submit" name="submit">
		</form>
=======
<body style="background-color: #EAEAEA; padding-top: 4rem;">
	<nav class="navbar px-3 fixed-top " style="background-color: #B2B2B2">
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
				<b><?php echo "Welcome ", $user; ?></b>
			</div>
		
			<button type="button" class="btn btn-secondary" style="background-color: #3C4048;  --bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;">
				<a href="logout.php" class="link-light">Logout</a>
			</button>
		</div>
	</nav>

	<p>
		<div class="d-flex align-items-center justify-content-center pt-5">
			<div class="card d-flex align-items-center justify-content-center pt-4" style="width: 25rem; border-radius: 1rem;"> 
			<form action="list_user.php" method="get" align="center">
				<div class="form-outline mb-3" style="width: 350px;">
					<input type="text" name="email" id="email" placeholder="example@domain.com" maxlength="30" minlength="1" class="form-control form-control-lg" >
		        </div>
				<div class="pt-1 mb-4">
	            	<button class="btn btn-dark btn-lg btn-block" type="submit">Search</button>
	        	</div>
			</form>
			</div>
		</div>
		<div class="d-flex align-items-center justify-content-center pt-2">
			<div class="card d-flex align-items-center justify-content-center py-4" style="width: 25rem; border-radius: 1rem;">
				<form action="list_user.php" method="get" align="center">
					<label for="count"> Queries per page </label>
					<select class="select-label" name="count" id="count">
						<option value="5">5</option>
						<option value="10">10</option>
						<option value="20">20</option>
					</select>
					<button class='btn btn-dark' style='background-color: #3C4048;  --bs-btn-padding-y: .20rem; --bs-btn-padding-x: 1rem;' type="submit" name="submit">Search</button>
				</form>
			</div>
		</div>
>>>>>>> Stashed changes

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
<<<<<<< Updated upstream
						{
							echo "<center>";
							echo "<br> Email match found.";
							echo "<table border=1 style='border-collapse: collapse;' cellpadding=4>";
							echo "<tr> <th colspan=5> User Details </th> </tr>";
							echo "<b> <tr> <td> Name </td>", "<td> Email </td>", "<td> User Created At </td>", "<td> User Updated at </td>", "<td> Phone No </td> </tr> </b>";
							while ($currentRow = $results->fetch_assoc())
							{
								echo "<tr> <td>", $currentRow['first_name'], " ", $currentRow['last_name'], "</td> <td>", $currentRow['email'], "</td> <td>", $currentRow['created_at'], "</td> <td>", $currentRow['updated_at'], "</td> <td>", $currentRow['phone_no'], "</td> </tr>" ;
							}
							echo "</table> </center";
=======
				{
					echo "<center>";
					echo "<table class='table table-striped table-hover text-center' style='width: 1200px; margin-top: 30px;'> <tbody>";
					echo "<tr class='table-dark ' scope='row'> <th scope='col' colspan='7'> User Details </th> </tr>";
					echo "<tr scope='row' class='table-dark text-center'> <td scope='col' > <b> Name </b> </td> ", "<td scope='col'> <b> Email </b> </td>", "<td scope='col'> <b> User Created At </b> </td>", "<td scope='col'> <b> User Updated at </b> </td>", "<td scope='col'> <b> Phone No </b> </td> <td scope='col'> Edit </td> <td scope='col'> Delete </td> </tr> </b>";

					while ($currentRow = $results->fetch_assoc())
					{
						echo "<tr class='text-center' scope='row'> <td>", $currentRow['first_name'], " ", $currentRow['last_name'], "</td> <td>", $currentRow['email'], "</td> <td>", $currentRow['created_at'], "</td> <td>", $currentRow['updated_at'], "</td> <td>", $currentRow['phone_no'], "</td> <td style='text-align: center' > <a href='edit_user.php?id=", $currentRow['id'], "' <span> &#9999;&#65039; </span> </a> </td> <td style='text-align: center'> <a href='delete_user.php?id=", $currentRow['id'], "' <span> &#10060; </span> </a> </td> </tr>" ;
					
					}

					echo "</tbody></table>";
>>>>>>> Stashed changes
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
				$rowCount = $totalRows['COUNT(*)'] - 1;

				if(!isset($_GET['queryNo']))
				{
					$limit = 5;
				}
				else
				{
					$limit = $_GET['queryNo'];
				}

				$totalPages = ceil($rowCount/$limit);

<<<<<<< Updated upstream
				$currentRows = ($currentPage - 1) * $limit;
=======

				$offset = ($currentPage - 1) * $limit;
>>>>>>> Stashed changes
				$selectRowQuery = $mysqli->prepare('SELECT * FROM users LIMIT ?, ?');
				$selectRowQuery->bind_param("ss", $currentRows, $limit);
				$selectRowQuery->execute();
				$results = $selectRowQuery->get_result();

				if(!empty($results))
				{
					echo "<center>";
<<<<<<< Updated upstream
					echo "<table border=1 style='border-collapse: collapse;' cellpadding=4>";
					echo "<tr> <th bgcolor='DimGray' colspan=5> User Details </th> </tr>";
					echo "<tr bgcolor='Silver'> <td> <b> Name </b> </td> ", "<td> <b> Email </b> </td>", "<td> <b> User Created At </b> </td>", "<td> <b> User Updated at </b> </td>", "<td> <b> Phone No </b> </td> </tr> </b>";

					while ($currentRow = $results->fetch_assoc())
					{
						echo "<tr> <td>", $currentRow['first_name'], " ", $currentRow['last_name'], "</td> <td>", $currentRow['email'], "</td> <td>", $currentRow['created_at'], "</td> <td>", $currentRow['updated_at'], "</td> <td>", $currentRow['phone_no'], "</td> </tr>" ;
=======
					echo "<table class='table table-striped table-hover text-center' style='width: 1200px; margin-top: 30px;'> <tbody>";
					echo "<tr class='table-dark ' scope='row'> <th scope='col' colspan='7'> User Details </th> </tr>";
					echo "<tr scope='row' class='table-dark text-center'> <td scope='col' > <b> Name </b> </td> ", "<td scope='col'> <b> Email </b> </td>", "<td scope='col'> <b> User Created At </b> </td>", "<td scope='col'> <b> User Updated at </b> </td>", "<td scope='col'> <b> Phone No </b> </td> <td scope='col'> Edit </td> <td scope='col'> Delete </td> </tr> </b>";

					while ($currentRow = $results->fetch_assoc())
					{
						echo "<tr class='text-center' scope='row'> <td>", $currentRow['first_name'], " ", $currentRow['last_name'], "</td> <td>", $currentRow['email'], "</td> <td>", $currentRow['created_at'], "</td> <td>", $currentRow['updated_at'], "</td> <td>", $currentRow['phone_no'], "</td> <td style='text-align: center' > <a href='edit_user.php?id=", $currentRow['id'], "' <span> &#9999;&#65039; </span> </a> </td> <td style='text-align: center'> <a href='delete_user.php?id=", $currentRow['id'], "' <span> &#10060; </span> </a> </td> </tr>" ;
>>>>>>> Stashed changes
					
					}

					echo "</tbody></table>";
					echo "<nav>";
					echo "<div class='d-flex align-items-center justify-content-center gap-2'>";
					if($currentPage == 1)
					{
						$nextPage = $currentPage + 1;
<<<<<<< Updated upstream
						echo "<a style='margin-top: 80px;' href='list_user.php?page=", $nextPage, "&queryNo=", $limit, "'> <button> Next </button> </a>";
=======
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
						echo "<button class='btn' style='background-color: #3C4048;  --bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;'> <a class='link-light' href='list_user.php?page=", $nextPage, "&count=", $limit, "'> Next </a> </button>";
>>>>>>> Stashed changes
					}
					elseif($currentPage == 2)
					{
						$backPage = $currentPage - 1;
						$nextPage = $currentPage + 1;
<<<<<<< Updated upstream
						echo "<a style='margin-top: 80px;' href='list_user.php?page=", $backPage, "&queryNo=", $limit, "'> <button> Back </button> </a>";
						echo " &nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;";
						echo "<a style='margin-top: 80px;' href='list_user.php?page=", $nextPage, "&queryNo=", $limit, "'> <button> Next </button> </a>";
=======
						$thirdPage = $nextPage + 1;
						echo "<button class='btn' style='background-color: #3C4048;  --bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;'><a class='link-light' href='list_user.php?page=", $backPage, "&count=", $limit, "'>Back</a></button>";
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
						echo "<button class='btn' style='background-color: #3C4048;  --bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;'> <a class='link-light' href='list_user.php?page=", $nextPage, "&count=", $limit, "'> Next </a> </button>";
					}
					elseif($currentPage < $totalPages - 1)
					{
						$backPage = $currentPage - 1;
						$nextPage = $currentPage + 1;
						echo "<button class='btn' style='background-color: #3C4048;  --bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;'><a class='link-light' href='list_user.php?page=", $backPage, "&count=", $limit, "'>Back</a></button>";
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
						echo "<button class='btn' style='background-color: #3C4048;  --bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;'> <a class='link-light' href='list_user.php?page=", $nextPage, "&count=", $limit, "'> Next </a> </button>";
					}
					elseif($currentPage == $totalPages - 1)
					{
						$backPage = $currentPage - 1;
						$nextPage = $currentPage + 1;
						$lastThirdPage = $backPage - 1;
						$lastFourthPage = $lastThirdPage - 1;
						echo "<button class='btn' style='background-color: #3C4048;  --bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;'><a class='link-light' href='list_user.php?page=", $backPage, "&count=", $limit, "'>Back</a></button>";
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
						echo "<button class='btn' style='background-color: #3C4048;  --bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;'> <a class='link-light' href='list_user.php?page=", $nextPage, "&count=", $limit, "'> Next </a> </button>";
>>>>>>> Stashed changes
					}
					elseif($currentPage == $totalPages)
					{
						$backPage = $currentPage - 1;
<<<<<<< Updated upstream
						echo "<a style='margin-top: 80px;' href='list_user.php?page=", $backPage, "&queryNo=", $limit, "'> <button> Back </button> </a>";
=======
						$lastThirdPage = $backPage - 1;
						
						echo "<button class='btn' style='background-color: #3C4048;  --bs-btn-padding-y: .40rem; --bs-btn-padding-x: 1rem;'><a class='link-light' href='list_user.php?page=", $backPage, "&count=", $limit, "'>Back</a></button>";
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
>>>>>>> Stashed changes
					}
					echo "</div>";
					echo "</nav>";
					echo " </center>";
				}
			}
		?>
    </p>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"></script>
</body>
</html>