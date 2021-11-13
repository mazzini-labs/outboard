<?php
namespace Phppot;

use Phppot\Model\FAQ;

$columnName = $_POST["column"];
$columnValue = $_POST["editval"];
$questionId = $_POST["id"];

require_once (__DIR__ . "./../Model/notearchive.php");
$faq = new FAQ();
//$result = $faq->editRecord($columnName, $columnValue, "$questionId");
$archive = $faq->addRecord($columnName, $columnValue, "$questionId");
?>