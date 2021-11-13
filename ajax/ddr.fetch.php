<?php

include '../include/wsbFunctions.php';
$conn = connect_db();
//$sheet = 'ddr2015pres';
//$api = "42-077-33876";
$api = "'" . $_GET['api'] . "'";
$sql = "SELECT * from `ddr_old` WHERE api like $api";
$result = mysqli_query($conn, $sql);

$num_records = mysqli_num_rows($result); 
mysqli_close($conn);
$a= array();
while ($row = mysqli_fetch_assoc($result)) {
$a['data'][] = $row;
    }

    echo (json_encode($a));

if (json_last_error() != JSON_ERROR_NONE) {
    printf("JSON Error: %s", json_last_error_msg());
    error_log("JSON Error: %s" . json_last_error_msg());
}
?>