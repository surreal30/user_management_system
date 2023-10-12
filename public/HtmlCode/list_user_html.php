<?php

	// Create search user by email form
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

	// Create Query per page form
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

	// Create table to dislay users
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

	// Create pagination
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
	