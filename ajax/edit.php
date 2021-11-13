<?php
require_once("obcontroller.php");
$db_handle = new DBController();
$sql = "UPDATE posts set " . $_POST["column"] . " = '".$_POST["editval"]."' WHERE  id=".$_POST["id"];
$result = $db_handle->executeUpdate($sql);
?>
