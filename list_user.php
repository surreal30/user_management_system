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
	<?php
		session_start();
		session_regenerate_id();
		if(!isset($_SESSION['user']))
		{
			header("location: login.php");
		}
	?>
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

		<?php
			$previous = "javascript:history.go(-1)";
			echo $previous;

			

			$serverName = '127.0.0.1';
			$user = getenv('DATABASE_USER');
			$password = getenv('DATABASE_PASSWORD');
			$dbName = getenv('DATABASE_NAME');

			mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

			$mysqli = new mysqli($serverName, $user, $password, $dbName);
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
							echo "<br> Email match found.";
							echo "<table border=1 style='border-collapse: collapse;' cellpadding=4>";
							echo "<tr> <th colspan=5> User Details </th> </tr>";
							echo "<b> <tr> <td> Name </td>", "<td> Email </td>", "<td> User Created At </td>", "<td> User Updated at </td>", "<td> Phone No </td> </tr> </b>";
							while ($currentRow = $results->fetch_assoc())
							{
								echo "<tr> <td>", $currentRow['first_name'], " ", $currentRow['last_name'], "</td> <td>", $currentRow['email'], "</td> <td>", $currentRow['created_at'], "</td> <td>", $currentRow['updated_at'], "</td> <td>", $currentRow['phone_no'], "</td> </tr>" ;
							}
							echo "</table> </center";
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


				$currentRows = ($currentPage - 1) * $limit;
				$selectRowQuery = $mysqli->prepare('SELECT * FROM users LIMIT ?, ?');
				$selectRowQuery->bind_param("ss", $currentRows, $limit);
				$selectRowQuery->execute();
				$results = $selectRowQuery->get_result();

				if(!empty($results))
				{

					echo "<center>";
					echo "<table border=1 style='border-collapse: collapse;' cellpadding=4>";
					echo "<tr> <th bgcolor='DimGray' colspan=5> User Details </th> </tr>";
					echo "<tr bgcolor='Silver'> <td> <b> Name </b> </td> ", "<td> <b> Email </b> </td>", "<td> <b> User Created At </b> </td>", "<td> <b> User Updated at </b> </td>", "<td> <b> Phone No </b> </td> </tr> </b>";

					while ($currentRow = $results->fetch_assoc())
					{
						echo "<tr> <td>", $currentRow['first_name'], " ", $currentRow['last_name'], "</td> <td>", $currentRow['email'], "</td> <td>", $currentRow['created_at'], "</td> <td>", $currentRow['updated_at'], "</td> <td>", $currentRow['phone_no'], "</td> </tr>" ;
					
					}

					echo "</table>";

					if($currentPage == 1)
					{
						$nextPage = $currentPage + 1;
						echo "<a style='margin-top: 80px;' href='list_user.php?page=", $nextPage, "&queryNo=", $limit, "'> <button> Next </button> </a>";
					}
					elseif($currentPage < $totalPages)
					{
						$backPage = $currentPage - 1;
						$nextPage = $currentPage + 1;
						echo "<a style='margin-top: 80px;' href='list_user.php?page=", $backPage, "&queryNo=", $limit, "'> <button> Back </button> </a>";
						echo " &nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;";
						echo "<a style='margin-top: 80px;' href='list_user.php?page=", $nextPage, "&queryNo=", $limit, "'> <button> Next </button> </a>";
					}
					elseif($currentPage == $totalPages)
					{
						$backPage = $currentPage - 1;
						echo "<a style='margin-top: 80px;' href='list_user.php?page=", $backPage, "&queryNo=", $limit, "'> <button> Back </button> </a>";
					}

					echo " </center>";
				}

			}

			// $timeout = 60*30;
			// $_SESSION['timeout'] = time() + $timeout;
			// if(time() > $_SESSION['timeout'])
			// {
			// 	session_destroy();
			// 	header("location: login.php");
			// }


		?>

    </p>
</body>
</html>
