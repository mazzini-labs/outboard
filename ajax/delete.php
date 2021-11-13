<?php
require_once("obcontroller.php");
$db_handle = new DBController();

if(!empty($_POST['id'])) {
	$id = $_POST['id'];
	$sql = "DELETE FROM  posts WHERE id = '$id' ";
	$db_handle->executeQuery($sql);
}
?>