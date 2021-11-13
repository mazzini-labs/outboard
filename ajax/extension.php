<?php

include '../include/wsbFunctions.php';
$sql = "SELECT * FROM phoneextensions";
$conn = connect_outboard();
$result = mysqli_query($conn, $sql);
$num_records = mysqli_num_rows($result); 
mysqli_close($conn);
$a= array();
while ($row = mysqli_fetch_assoc($result)) {
$a['data'][] = $row;
    }

    echo (json_encode($a));

?>