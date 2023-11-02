<?php
	if($_SERVER['REQUEST_URI'][-1] == "/")
	{
		$URI = substr($_SERVER['REQUEST_URI'], 0, -1);
	}
	else
	{
		$URI = $_SERVER['REQUEST_URI'];
	}
 
	if( $URI == "/admin" )
	{
		$route = "/src/homepage.php";
	}
	elseif( $URI == "/admin/login" )
	{
		$route = "/src/login.php";
	}
	elseif( $URI == "/admin/logout" )
	{
		$route = "/src/logout.php";
	}
	elseif( $URI == "/admin/users" )
	{
		$route = "/src/list_user.php";
	}
	elseif( explode("?", $URI)[0] == "/admin/users" )
	{
		$route = "/src/list_user.php";
	}
	elseif( $URI == "/admin/users/add" )
	{
		$route = "/src/add_user.php";
	}
	elseif( explode("?", $URI)[0] == "/admin/users/edit")
	{
		$route = "/src/edit_user.php";
	}
	elseif( explode("?", $URI)[0] == "/admin/users/delete")
	{
		$route = "/src/delete_user.php";
	}
	// elseif( count(explode("/", $URI)) == 5 )
	// {
	// 	$URIArray = explode("/", $URI);

	// 	// $URIArray[3] is id of the user. check whether the link is redirecting for edit or delete
	// 	if( $URIArray[1] . "/" . $URIArray[2] == "admin/users" && $URIArray[4] == "edit" )
	// 	{
	// 		$route = "/src/edit_user.php";
	// 	}
	// 	elseif( $URIArray[1] . "/" . $URIArray[2] == "admin/users" && $URIArray[4] == "delete" )
	// 	{
	// 		$route = "/src/delete_user.php";
	// 	}
	// 	else
	// 	{
	// 		$route = "/src/404.php";
	// 	}
	// }
	else
	{
		$route = "/src/404.php";
	}

	require __DIR__ . $route;