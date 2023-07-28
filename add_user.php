<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add User</title>
</head>
<body>
	<p style="margin-top: 50px; margin-left: 100px;">
		<h1>Add user in the database</h1>
	</p>
	<p style="margin-top: 50px; margin-left: 100px;">
		<table style="margin-left: 50px">
			<form action="/add_in_db.php" method="post">
				<tr>   <td>   <label for="first_name"> First Name </label>                                                                </td>
				       <td>   <input style="margin-top: 10px;" type="text" name="first_name" minlength="1" placeholder="John">            </td>   </tr>
				<tr>   <td>   <label for="last_name"> Last Name </label>                                                                  </td>
				       <td>   <input style="margin-top: 10px;" type="text" name="last_name" minlength="1" placeholder="Doe">              </td>   </tr>
				<tr>   <td>   <label for="email"> Email</label>                                                                           </td>
				       <td>   <input style="margin-top: 10px;" type="email" name="email" minlength="1" placeholder="example@domain.com">  </td>   </tr>
				<tr>   <td>   <label for="password"> Password </label>                                                                    </td>
				       <td>   <input style="margin-top: 10px;" type="password" name="password" minlength="1">                             </td>   </tr>
				<tr>   <td>   <label for="phone_no"> Phone Number</label>                                                                 </td>
				       <td>   <input style="margin-top: 10px;" type="text" name="phone_no" minlength="1" placeholder="0123456789">        </td>   </tr>
				<tr>   <td>   <input style="margin-top: 10px;" type="submit" name="submit" value="Create User">                           </td>   </tr>
			</form>
		</table>
	</p>

</body>
</html>