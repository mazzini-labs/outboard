<?php
namespace Phppot;

use Phppot\Model\inline;

$columnName = $_POST["column"];
$columnValue = $_POST["editval"];
$rowId = $_POST["id"];

require_once (__DIR__ . "./../Model/FAQ.php");
$inline = new inline();
$result = $inline->editRecord($columnName, $columnValue, $rowId);
?>