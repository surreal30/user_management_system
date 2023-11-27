<?php
require_once("manage_login_session.php");

$sessionUser = manageSession();

http_response_code(404);

include ("template/404.html");