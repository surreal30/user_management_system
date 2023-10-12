<?php

	// HTML code for login form
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
			                		<form action="$actionLink" method="post">
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

	// Display incorrent password error
	function incorrectPassword()
	{
    	echo "<center> <div class='pt-1 mb-4'> <h4>Incorrect password</h4> </div> </center>";	
	}