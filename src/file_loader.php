<?php

// $dirPath = dirname(__DIR__);
$dirPath = __DIR__;
$controllersDir = "/controllers/";
$modelDir = "/model/";

require_once $dirPath . $controllersDir . "AuthenticationController.php";
require_once $dirPath . $controllersDir . "UserController.php";
require_once $dirPath . $controllersDir . "HomeController.php";
require_once $dirPath . $modelDir . "DatabaseOperation.php";
require_once $dirPath . "/manage_login_session.php";