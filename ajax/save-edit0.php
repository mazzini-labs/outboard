<?php
// namespace Phppot;

// use Phppot\Model\FAQ;

$columnName = $_POST["column"];
$columnValue = $_POST["editval"];
$rowId = $_POST["id"];
$api = $_REQUEST["api"];
$sheet = $_REQUEST["sheet"];
require_once (__DIR__ . "./../Model/inline.php");
$inline = new inline();
$result = $inline->editRecord($api, $sheet, $columnName, $columnValue, $rowId);
?>