<?php
define("PROJECT_ROOT_PATH", __DIR__ . "/../");

// // include main configuration file
// require_once PROJECT_ROOT_PATH . "/config/db.config.php";

// include the helper functions
include_once PROJECT_ROOT_PATH . "include/common.php"; 

// include the base controller file
require_once PROJECT_ROOT_PATH . "/api/controller/BaseController.php";

// include the use model file
require_once PROJECT_ROOT_PATH . "/Model/UserModel.php";

// include the authentication file
require_once PROJECT_ROOT_PATH . "/Model/Auth.php";
?>