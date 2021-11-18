<?php

//load.php  
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$connect = new PDO('mysql:host=localhost;dbname=outboard', 'outuser', 'outpass');

$data = array();
$query = "SELECT * FROM pto_request where is_pto = 0 ORDER BY id";
$query = "SELECT
id, 
title, 
date_format(start,'%Y-%m-%dT%T') as start,
allDay, 
date_format(end,'%Y-%m-%dT%T') as end,
color, 
description
FROM
    pto_request
WHERE
    is_pto = 0   
ORDER BY
    id";
//$query = "SELECT * FROM events ORDER BY id";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
//$result = mysql_query($query) or die(mysql_error());
if(isset($_REQUEST['test'])){
    echo json_encode($result);
    exit;
}
foreach($result as $row)
{
    // if($row["all_day"] == "true")?
 $data[] = array(
  'id'   => $row["id"],
  'allDay'   => $row['allDay'],
  'title'   => $row["title"],
  'start'   => $row["start"],
  'end'   => $row["end"],
  
  'color'   => $row["color"],
  'description' => $row["description"]
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
// $data = preg_replace('/"([a-zA-Z]+[a-zA-Z0-9_]*)":/','$1:',$data);
header('Content-type:application/json;charset=utf-8');
echo json_encode($data);

?>
