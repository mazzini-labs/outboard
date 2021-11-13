<?php
namespace Phppot;

use Phppot\Model\FAQ;

$columnName = $_POST["column"];
$columnValue = $_POST["editval"];
$questionId = mysqli_real_escape_string($_POST["id"]);

require_once (__DIR__ . "./../Model/FAQ.1.php");
$faq = new FAQ();
$result = $faq->editRecord($columnName, $columnValue, $questionId);
?>