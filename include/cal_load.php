<?php

//load.php

$connect = new PDO('mysql:host=localhost;dbname=outboard', 'outuser', 'outpass');

$data = array();
$query = "SELECT * FROM events_test ORDER BY id";
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
  'start'   => $row["start_event"],
  'end'   => $row["end_event"],
  'allDay'   => $row["all_day"]
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
