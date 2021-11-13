<?php

//load.php
$hr = $_REQUEST["hr"];
$ap = $_REQUEST["ap"];
$a1 = $_REQUEST["a1"];
$a2 = $_REQUEST["a2"];
$e1 = $_REQUEST["e1"];
$e2 = $_REQUEST["e2"];
$la = $_REQUEST["la"];
$le = $_REQUEST["le"];
$ge = $_REQUEST["ge"];
$ad = $_REQUEST["ad"];
$hr = true;
$department = "(";
if ($hr) { 
    $department .= "`department` like \"%HR%\" or `department` like \"%AP%\" or `department` like \"%ACCT1%\" ";
	$department .= "or `department` like \"%ACCT2%\" or `department` like \"%ENG1%\" or `department` like \"%ENG2%\" ";
	$department .= "or `department` like \"%LAND%\" or `department` like \"%LEGAL%\" or `department` like \"%GEO%\" ";
	$department .= "or `department` like \"%ADSTAFF%\")";
} 
else { 
    if ($ap) {
        $department .= "`department` like \"%AP%\" ";
    } 
    if ($a1) { 
        if ($ap){ $department .= " or "; }
        $department .= "`department` like \"%ACCT1%\"";
    } 
    if ($a2) { 
        if ($ap || $a1){ $department .= " or "; }
        $department .= "`department` like \"%ACCT2%\"";
    } 
    if ($e1) { 
        if ($ap || $a1 || $a2){ $department .= " or "; }
        $department .= "`department` like \"%ENG1%\"";
    } 
    if ($e2) { 
        if ($ap || $a1 || $a2 || $e1){ $department .= " or "; }
        $department .= "`department` like \"%ENG2%\"";
    } 
    if ($la) { 
        if ($ap || $a1 || $a2 || $e1 || $e2){ $department .= " or "; }
        $department .= "`department` like \"%LAND%\"";
    } 
    if ($le) { 
        if ($ap || $a1 || $a2 || $e1 || $e2 || $la){ $department .= " or "; }
        $department .= "`department` like \"%LEGAL%\"";
    } 
    if ($ge) { 
        if ($ap || $a1 || $a2 || $e1 || $e2 || $la || $le){ $department .= " or "; }
        $department .= "`department` like \"%GEO%\"";
    } 
    if ($ad) { 
        if ($ap || $a1 || $a2 || $e1 || $e2 || $la || $le || $ge){ $department .= " or "; }
        $department .= "`department` like \"%ADSTAFF%\"";
    }
    $department .= ")";
}
if (!$hr && !$ap && !$a1 && !$a2 && !$e1 && !$e2 && !$la && !$le && !$ge && !$ad)
{
    $department = "";
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$connect = new PDO('mysql:host=localhost;dbname=outboard', 'outuser', 'outpass');

$data = array();
$query = "SELECT * FROM pto_request where $department AND is_pto = 1 ORDER BY id";
// echo $query;
//$query = "SELECT * FROM events ORDER BY id";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
//$result = mysql_query($query) or die(mysql_error());
foreach($result as $row)
{
 $data[] = array(
  'id'   => $row["id"],
  'title'   => $row["title"],
  'start'   => $row["start_time"],
  'end'   => $row["end_time"],
  'allDay'   => $row["all_day"],
  'color'   => "#".$row["color"],
  'description' => $row["remarks"]
 );
}
/*foreach($result as $row)
{
 $data[] = array(
  'id'   => $row["id"],
  'title'   => $row["title"],
  'start'   => $row["start_event"],
  'end'   => $row["end_event"]
 );
}*/

echo json_encode($data);

?>
