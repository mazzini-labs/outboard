<?php
define("PROJECT_ROOT_PATH", __DIR__ . "/../");

// // include main configuration file
require_once PROJECT_ROOT_PATH . "/config/wells.config.php";

// // include the helper functions
include_once PROJECT_ROOT_PATH . "include/common.php"; 
// error_log(print_r(PROJECT_ROOT_PATH . "include/common.php",true));
// include the base controller file
require_once PROJECT_ROOT_PATH . "api/controller/BaseController.php";
// error_log(print_r(PROJECT_ROOT_PATH . "api/controller/BaseController.php",true));
// include the use model file
require_once PROJECT_ROOT_PATH . "api/model/WSBModel.php";

// include the authentication file
// require_once PROJECT_ROOT_PATH . "/Model/Auth.php";
?>