<?php

define("SRC_DIR", ROOT_DIR . "/src/");
define("CONTROLLER_DIR", "/controllers/");
define("MODEL_DIR", "/model/");

require_once SRC_DIR . CONTROLLER_DIR . "AuthenticationController.php";
require_once SRC_DIR . CONTROLLER_DIR . "UserController.php";
require_once SRC_DIR . CONTROLLER_DIR . "HomeController.php";
require_once SRC_DIR . MODEL_DIR . "DatabaseOperation.php";
require_once SRC_DIR . "/manage_login_session.php";