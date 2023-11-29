<?php
require_once("manage_login_session.php");

$sessionUser = manageSession();

include("/app/template/homepage.php");