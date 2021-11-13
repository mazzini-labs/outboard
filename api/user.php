<?php
// require PROJECT_ROOT_PATH . "/config/bootstrap.php";
require "../config/bootstrap.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$first = explode("?", $uri);
$and = explode("&", $uri);
$keywords = preg_split("/[\s,]+/", $uri);
$uri = explode( '/', $uri );

// if ((isset($uri[2]) && $uri[2] != 'user') || !isset($uri[3])) {
//     header("HTTP/1.1 404 Not Found");
//     exit();
// }
// foreach ($a as $k => $v) {
//     echo "\$a[$k] => $v.\n";
// }
// require PROJECT_ROOT_PATH . "/api/controller/UserController.php";
// foreach($test as &$i){
//     // print_r($test[$i] ." \n");
//     // print_r($i);
//     echo "$i $v.\n";
// }
// echo "$first[1] \n";
// echo "$and[1] \n";
// print_r("\n");
// print_r($uri);

require "controller/UserController.php";
$objFeedController = new UserController();
$strMethodName = $uri[3] . 'Action';
// $strMethodName = $_GET['action'] . 'Action';
$objFeedController->{$strMethodName}();
?>