<?php

	// Add user form
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

	// Display user is created for individual user
	function userCreated($firstName, $lastName)
	{
		echo "<center><h4 class='px-4' style='padding- right: 5rem; padding-bottom: 1rem;'> $firstName $lastName has been created and added to database</h4></center>";
	}

	// Display users created for bulk upload
	function bulkUserCreated()
	{
		echo "<center><h4 style='padding-right: 5rem; padding-bottom: 1rem; padding-left: 1rem;'>The users have been created and added to database</h4></center>";
	}