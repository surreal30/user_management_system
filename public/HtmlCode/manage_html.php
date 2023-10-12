<?php
	function htmlBeginning($title)
	{
		echo <<<HTMLBEGINNING
			<!DOCTYPE html>
			<html>
			<head>
				<meta charset="utf-8">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
				<title>$title</title>
			</head>
			<body>
		HTMLBEGINNING;
	}

	function welcomeMessage()
	{
		echo "<p class='text-dark' style='margin-top: 5rem;'> <center> <h1>Welcome to User Management System.</h1> </center> </p>";
	}

	function htmlEnding()
	{
		echo <<<HTMLENDING
				<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
				<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
				<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
			</body>
			</html>
		HTMLENDING;
	}

	function navbar($user, $page)
	{
		echo "<nav class='navbar navbar-expand-lg navbar-light bg-light px-4'>
				<div class='collapse navbar-collapse d-flex align-items-center gap-3' id='navbarNavDropdown'>
				<ul class='navbar-nav'>";
		switch ($page)
		{
			case 'index':
				echo <<<ACTIVELINKS
					<li class="nav-item">
						<a class="nav-link active" href="http://localhost/admin">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="http://localhost/admin/users/add">Add User</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="http://localhost/admin/users">List User</a>
					</li>
				ACTIVELINKS;
				break;
			
			case 'addUser':
				echo <<<ACTIVELINKS
					<li class="nav-item">
						<a class="nav-link" href="http://localhost/admin">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="http://localhost/admin/users/add">Add User</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="http://localhost/admin/users">List User</a>
					</li>
				ACTIVELINKS;
				break;

			case 'listUser':
				echo <<<ACTIVELINKS
					<li class="nav-item">
						<a class="nav-link" href="http://localhost/admin">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="http://localhost/admin/users/add">Add User</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="http://localhost/admin/users">List User</a>
					</li>
				ACTIVELINKS;
				break;

			case 'editUser':
				echo <<<ACTIVELINKS
					<li class="nav-item">
						<a class="nav-link" href="http://localhost/admin">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="http://localhost/admin/users/add">Add User</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="http://localhost/admin/users">List User</a>
					</li>
				ACTIVELINKS;
				break;

			case 'deleteUser':
				echo <<<ACTIVELINKS
					<li class="nav-item">
						<a class="nav-link" href="http://localhost/admin">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="http://localhost/admin/users/add">Add User</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="http://localhost/admin/users">List User</a>
					</li>
				ACTIVELINKS;
				break;
		}
		echo <<<NAVBAR
			</ul>
				</div>
				<div class="d-flex align-items-right gap-3">
					<ul class="navbar-nav">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Welcome $user
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
								<a class="dropdown-item" href="http://localhost/admin/logout">Logout</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>
		NAVBAR;
	}

	function searchByEmailForm($actionLink)
	{

		echo <<<SEARCHBYEMAILFORM
			<div class="d-flex align-items-center justify-content-center pt-5">
				<div class="card d-flex align-items-center justify-content-center pt-4 border-primary" style="width: 25rem; border-radius: 1rem; margin-top: 1rem;"> 
				<form action="$actionLink" method="get" align="center">
					<div class="form-outline mb-3" style="width: 350px;">
						<input type="text" name="email" id="email" placeholder="example@domain.com" maxlength="30" minlength="1" class="form-control form-control-lg" >
			        </div>
					<div class="pt-1 mb-4">
		            	<button class="btn btn-primary btn-lg btn-block" type="submit">Search</button>
		        	</div>
				</form>
				</div>
			</div>
		SEARCHBYEMAILFORM;
	}

	function queryPerPageForm($actionLink)
	{
		echo <<<QUERYPERPAGEFORM
			<div class="d-flex align-items-center justify-content-center pt-2">
				<div class="card d-flex align-items-center justify-content-center py-4 border-primary" style="width: 25rem; border-radius: 1rem;">
					<form action="$actionLink" method="get" align="center">
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
		QUERYPERPAGEFORM;
	}

	function userTable($user)
	{
		echo "<center>";
		echo "<table class='table table-striped table-hover text-center' style='width: 1200px; margin-top: 30px;'> <tbody>";
		echo "<tr class='table-dark ' scope='row'> <th scope='col' colspan='7'> User Details </th> </tr>";
		echo "<tr scope='row' class='table-dark text-center'> <td scope='col' > <b> Name </b> </td> ", "<td scope='col'> <b> Email </b> </td>", "<td scope='col'> <b> User Created At </b> </td>", "<td scope='col'> <b> User Updated at </b> </td>", "<td scope='col'> <b> Phone No </b> </td> <td scope='col'> Edit </td> <td scope='col'> Delete </td> </tr> </b>";
		while ($userRow = $user->fetch_assoc())
		{
			echo "<tr class='text-center' scope='row'> <td>", $userRow['first_name'], " ", $userRow['last_name'], "</td> <td>", $userRow['email'], "</td> <td>", $userRow['created_at'], "</td> <td>", $userRow['updated_at'], "</td> <td>", $userRow['phone_no'], "</td> <td style='text-align: center' > <a href='http://localhost/admin/users/", $userRow['id'], "/edit'> <span> <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'> <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/> <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/> </svg> </span> </a> </td> <td style='text-align: center'> <a href='http://localhost/admin/users/", $userRow['id'], "/delete' <span> <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='red' class='bi bi-trash' viewBox='0 0 16 16'> <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z'/> <path d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z'/> </svg> </span> </a> </td> </tr>" ;
		}
		echo "</tbody></table></center>";

	}

	function pagination($currentPage, $totalPages, $limit)
	{
		echo "<center><nav><div class='d-flex align-items-center justify-content-center gap-2'>";

		if($currentPage > $totalPages || !(preg_match('<^\d[0-9]*$>', $currentPage)))
		{
			$currentPage = 1;
			$nextPage = $currentPage + 1;
			$thirdPage = $nextPage + 1;
			echo <<<PAGEINATION
				<ul class='pagination pagination-circle mb-0'>
					<li class='page-item disabled'>
						<a class='page-link' href='http://localhost/admin/users?page=1&count=$limit' >First</a>
					</li> 
					<li class='page-item disabled'>
						<a class='page-link' href='http://localhost/admin/users?page=1&count=$limit'><span aria-hidden="true">&laquo;</span></a>
					</li>
					<li class='page-item active'> 
						<a class='page-link' href='http://localhost/admin/users?page=$currentPage&count=$limit'> $currentPage </a>
					</li>
					<li class='page-item'>
						<a class='page-link' href='http://localhost/admin/users?page=$nextPage&count=$limit'> $nextPage </a>
					</li>
					<li class='page-item'>
						<a class='page-link' href='http://localhost/admin/users?page=$thirdPage&count=$limit'> $thirdPage</a>
					</li>
					<li class='page-item'>
						<a class='page-link' href='http://localhost/admin/users?page=$nextPage&count=$limit'><span aria-hidden="true">&raquo;</span></a>
					</li>
					<li class='page-item'>
						<a class='page-link' href='http://localhost/admin/users?page=$totalPages&count=$limit'>Last</a>
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
						<a class='page-link' href='http://localhost/admin/users?page=1&count=$limit' >First</a>
					</li> 
					<li class='page-item disabled'>
						<a class='page-link' href='http://localhost/admin/users?page=1&count=$limit'><span aria-hidden="true">&laquo;</span></a>
					</li>
					<li class='page-item active'> 
						<a class='page-link' href='http://localhost/admin/users?page=$currentPage&count=$limit'> $currentPage </a>
					</li>
					<li class='page-item'>
						<a class='page-link' href='http://localhost/admin/users?page=$nextPage&count=$limit'> $nextPage </a>
					</li>
					<li class='page-item'>
						<a class='page-link' href='http://localhost/admin/users?page=$thirdPage&count=$limit'> $thirdPage</a>
					</li>
					<li class='page-item'>
						<a class='page-link' href='http://localhost/admin/users?page=$nextPage&count=$limit'><span aria-hidden="true">&raquo;</span></a>
					</li>
					<li class='page-item'>
						<a class='page-link' href='http://localhost/admin/users?page=$totalPages&count=$limit'>Last</a>
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
						<a class='page-link' href='http://localhost/admin/users?page=1&count=$limit' >First</a>
					</li>
					<li class='page-item'>
						<a class='page-link' href='http://localhost/admin/users?page=$backPage&count=$limit'><span aria-hidden="true">&laquo;</span></a>
					</li>
					<li class='page-item'> 
						<a class='page-link' href='http://localhost/admin/users?page=$backPage&count=$limit'> $backPage </a>
					</li>
					<li class='page-item active'>
						<a class='page-link' href='http://localhost/admin/users?page=$currentPage&count=$limit'> $currentPage </a>
					</li>
					<li class='page-item'>
						<a class='page-link' href='http://localhost/admin/users?page=$nextPage&count=$limit'> $nextPage </a>
					</li>
					<li class='page-item'>
						<a class='page-link' href='http://localhost/admin/users?page=$nextPage&count=$limit'><span aria-hidden="true">&raquo;</span></a>
					</li>
					<li class='page-item'>
						<a class='page-link' href='http://localhost/admin/users?page=$totalPages&count=$limit'>Last</a>
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
						<a class='page-link' href='http://localhost/admin/users?page=1&count=$limit' >First</a>
					</li>
					<li class='page-item'>
						<a class='page-link' href='http://localhost/admin/users?page=$backPage&count=$limit'><span aria-hidden="true">&laquo;</span></a>
					</li>
					<li class='page-item'> 
						<a class='page-link' href='http://localhost/admin/users?page=$lastThirdPage&count=$limit'> $lastThirdPage </a>
					</li>
					<li class='page-item '>
						<a class='page-link' href='http://localhost/admin/users?page=$backPage&count=$limit'> $backPage </a>
					</li>
					<li class='page-item active'>
						<a class='page-link' href='http://localhost/admin/users?page=$currentPage&count=$limit'> $currentPage</a>
					</li>
					<li class='page-item disabled'>
						<a class='page-link' href='http://localhost/admin/users?page=$totalPages&count=$limit'><span aria-hidden="true">&raquo;</span></a>
					</li>
					<li class='page-item disabled'>
						<a class='page-link' href='http://localhost/admin/users?page=$totalPages&count=$limit'>Last</a>
					</li>
				</ul>
			PAGEINATION;
		}	

		echo "</div></nav></center";	
	}

	function invalidUser()
	{
		echo "<center><h4><a class='page-link' style='margin-top: 3rem;'> Invalid user ID! Please go back to list user page and select a valid user. </a></h4></center> ";
	}

	function userDoesNotExist()
	{
		echo "<center><h4><a class='page-link' style='margin-top: 3rem;'> This user does not exist. Go back to list user page and select another user. </a></h4></center>";
	}

	function userDeleted()
	{
		echo "<center><h4 class='pt-3'> User has been deleted. </h4></center";
	}

	function editUserForm($id, $userRow, $actionLink)
	{
		echo <<<EDITUSERFORM
			<section class="d-flex justify-content-center align-items-center" >
				<div class="container d-flex align-items-center justify-content-center py-5" style="margin-top: 5rem;">
			    	<div class=" d-flex justify-content-center align-items-center h-100" >
				    	<div class="">
				        	<div class="card border-primary" style="border-radius: 1rem; align-items-center">
				            	<div class="d-flex align-items-center" >
				            		<div class="p-4 p-lg-5 text-black d-flex align-items-center" style="align-items-center">
				                		<form action="$actionLink" method="post">
						                	<div class="d-flex justify-content-center mb-3 pb-1">
						                    	<span class="h1 fw-bold mb-0">Update user</span>
						                	</div>
				                  
						                	<div class="form-outline mb-3">
						                  		<div class="row mb-4">
								                  	<div class="col">
									                    <input type="text" placeholder="First Name" id="first_name" name="first_name" minlength="1" value= "{$userRow['first_name']}" class="form-control form-control-lg" >
									                </div>
							                		
							                		<div class="col">
							                    		<input type="text" placeholder="Last Name" id="last_name" name="last_name" minlength="1" value="{$userRow['last_name']}" class="form-control form-control-lg" >
								                	</div>
							            		</div>

							                	<div class="form-outline mb-3">
							                    	<input type="email" placeholder="Email ID" id="email" name="email" minlength="1" value="{$userRow['email']}" class="form-control form-control-lg" >
								            	</div>

							                	<div class="form-outline mb-3">
							                    	<input type="text" placeholder="Phone No" id="phone_no" name="phone_no" minlength="10" maxlength="10" value="{$userRow['phone_no']}" class="form-control form-control-lg" >
							                	</div>

							                	<div class="d-flex pt-1 mb-4 justify-content-center align-items-center">
						                    		<button class="btn btn-primary btn-lg btn-block" style="width: 15rem" type="submit">Update user</button>
								              	</div>
								            </div>
						            	</form>
							    	</div>
				    			</div>
				    		</div>
						</div>
					</div>
				</div>
			</section>
		EDITUSERFORM;
	}

	function userUpdated($firstName, $lastName)
	{
		echo "<center> <h3> User $firstName $lastName has been updated. </h3> </center>";	
	}

	function addUserForm($actionLink)
	{
		echo <<<ADDUSERFORM
			<section class="d-flex justify-content-center align-items-center">
				<div class="container d-flex align-items-center justify-content-center pt-5" style="margin-top: 5rem;">
					<div class=" d-flex justify-content-center align-items-center h-100" >
		    			<div class="">
							<div class="card border-primary" style="border-radius: 1rem; align-items-center">
								<div class="d-flex align-items-center" >
									<div class="pt-4 px-4 text-black d-flex align-items-center" style="align-items-center">
										<form action= "$actionLink" method="post">
											<div class="d-flex justify-content-center mb-3 pb-1">
												<span class="h1 fw-bold mb-0">Add user</span>
											</div>
		                  
											<div class="form-outline mb-3">
												<div class="row mb-4">
													<div class="col">
														<input type="text" placeholder="First Name" id="first_name" name="first_name" minlength="1" class="form-control form-control-lg" >
													</div>
													<div class="col">
														<input type="text" placeholder="Last Name" id="last_name" name="last_name" minlength="1" class="form-control form-control-lg" >
													</div>
												</div>

												<div class="form-outline mb-3">
													<input type="email" placeholder="Email ID" id="email" name="email" minlength="1" class="form-control form-control-lg" >
												</div>

												<div class="form-outline mb-3">
													<input type="password" placeholder="Password" id="password" name="password" minlength="8" class="form-control form-control-lg" >
												</div>

												<div class="form-outline mb-3">
													<input type="text" placeholder="Phone No" id="phone_no" name="phone_no" minlength="10" maxlength="10" class="form-control form-control-lg" >
												</div>

												<div class="d-flex pt-1 mb-4 justify-content-center align-items-center">
													<button class="btn btn-primary btn-lg btn-block" style="width: 15rem" name="submit" type="submit">Add user</button>
												</div>
											</div>
										</form>
									</div>
								</div>

								<center>
									<hr class="hr hr-blurry" style="width: 28rem">
										<h5 style="padding-right: 5rem; padding-top: 1rem;">
											Bulk upload
										</h5>
								</center>
								<div class="form-outline mb-4 d-flex align-items-center justify-content-center gap-5">
									<form action="http://localhost/admin/users/add" method="post" enctype="multipart/form-data">
										<input class="btn btn-outline-dark" type="file" name="data">
										<button class="btn btn-primary btn-lg btn-block" type="submit" name="bulk_upload" value="Upload">Upload</button>
									</form>
								</div>

								<center><h6 style="padding-right: 5rem; padding-bottom: 1rem;">Upload only JSON format</h6></center>
							</div>
						</div>
					</div>
				</div>
			</section>
		ADDUSERFORM;

	}

	function userCreated($firstName, $lastName)
	{
		echo "<center><h4 class='px-4' style='padding- right: 5rem; padding-bottom: 1rem;'> $firstName $lastName has been created and added to database</h4></center>";
	}

	function bulkUserCreated()
	{
		echo "<center><h4 style='padding-right: 5rem; padding-bottom: 1rem; padding-left: 1rem;'>The users have been created and added to database</h4></center>";
	}

	function loginForm($actionLink)
	{
		echo <<<LOGINFORM
			<section class="d-flex justify-content-center align-items-center" >
				<div class="container d-flex align-items-center justify-content-center py-5" style="margin-top: 2rem">
			    	<div class=" d-flex justify-content-center align-items-center h-100" >
			    		<div class="">
			        		<div class="card border-primary" style="border-radius: 1rem; align-items-center">
			            		<div class="d-flex align-items-center" >
			            			<div class="p-4 p-lg-5 text-black d-flex align-items-center" style="align-items-center">

			            			<!-- login form -->
			                		<form action="http://localhost/admin/login" method="post">
					                	<div class="d-flex justify-content-center mb-3 pb-1">
					                    	<span class="h1 fw-bold mb-0">User Management System</span>
					                	</div>

					                	<h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Login into your account</h5>

					                	<div class="form-outline mb-3">
					                    	<input type="text" placeholder="Username" id="username" name="username" minlength="1" class="form-control form-control-lg" >
					                	</div>

					                	<div class="form-outline mb-3">
					                    	<input type="password" placeholder="Password" id="password" name="password" minlength="8" class="form-control form-control-lg" >
					                	</div>

					                	<div class="pt-1 mb-4">
					                    	<button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
					                	</div>
										
					                </form>
			            			</div>
			            		</div>
				    		</div>
				    	</div>
					</div>
				</div>
			</section>
		LOGINFORM;
	}

	function incorrectPassword()
	{
    	echo "<center> <div class='pt-1 mb-4'> <h4>Incorrect password</h4> </div> </center>";	
	}