<?php

include '../include/wsbFunctions.php';
$conn = connect_db();
//$sheet = 'ddr2015pres';
//$api = "42-077-33876";
$api = $_GET['api'];
$sql = "SELECT * from `vitals` WHERE api like '" . $api . "' order by d desc";
$result = mysqli_query($conn, $sql);

$num_records = mysqli_num_rows($result); 
mysqli_close($conn);
$a= array();
while ($row = mysqli_fetch_assoc($result)) {
$a['data'][] = $row;
    }

    echo (json_encode($a));

?>