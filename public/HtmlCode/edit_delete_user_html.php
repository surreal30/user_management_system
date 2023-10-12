<?php

	// Create edit user form
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

	// Display user updated message
	function userUpdated($firstName, $lastName)
	{
		echo "<center> <h3> User $firstName $lastName has been updated. </h3> </center>";	
	}

	// Display invalid user message
	function invalidUser()
	{
		echo "<center><h4><a class='page-link' style='margin-top: 3rem;'> Invalid user ID! Please go back to list user page and select a valid user. </a></h4></center> ";
	}

	// Display user does not exist message
	function userDoesNotExist()
	{
		echo "<center><h4><a class='page-link' style='margin-top: 3rem;'> This user does not exist. Go back to list user page and select another user. </a></h4></center>";
	}

	// Display user deleted message
	function userDeleted()
	{
		echo "<center><h4 class='pt-3'> User has been deleted. </h4></center";
	}