<?php

include '../include/wsbFunctions.php';
$conn = connect_wellNotes();
//$sheet = 'ddr2015pres';
//$api = "42-077-33876";
$sheet = $_GET['sheet'];
$api = $_GET['api'];
$convert = "SELECT well from `000api_list` WHERE `api` like \"%".$api."%\"";
$wellResult = mysqli_query($conn, $convert);
while ($row = mysqli_fetch_array($wellResult)) {
    $well = $row['well'];
}
$sql = "SELECT * from `$well` WHERE sheet like '" . $sheet . "'";
$result = mysqli_query($conn, $sql);

$num_records = mysqli_num_rows($result); 
mysqli_close($conn);
$a= array();
while ($row = mysqli_fetch_assoc($result)) {
$a['data'][] = $row;
    }

    echo (json_encode($a));

?>