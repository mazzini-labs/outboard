<?php

//load.php  
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$connect = new PDO('mysql:host=localhost;dbname=wells', 'root', 'devonian');

$data = array();
$query = "SELECT * from `list`";// order by api asc";
$statement = $connect->prepare($query);
$statement->execute();
$count = 1;
$result = $statement->fetchAll();
foreach($result as $row)
{
 $data[] = array(
    'rowKey'  => $row["list_id"],
  'well_common_name'   => $row["entity_common_name"],
  'state'   => $row["state"],
  'county'   => $row["county_parish"],
  'block'   => $row["block"],
  'company'  => $row["entity_operator_code"],
  'status'   => $row["producing_status"],
  'type'   => $row["production_type"],
  'last_produced' => $row["last_prod_date"],
  'pumper' => $row["pumper"],
  'notes' => $row["notes"],
  'si_notes' => $row["si_notes"]
  
 );
}

echo json_encode($data);

?>