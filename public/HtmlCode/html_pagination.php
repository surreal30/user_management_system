<?php
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
	