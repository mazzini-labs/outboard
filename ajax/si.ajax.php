<?php

include '../include/wsbFunctions.php';

$conn = connect_db();
//$sheet = 'ddr2015pres';
//$api = "42-077-33876";
//$table = $_GET['table'];
//$sheet = $_GET['sheet'];
$sql = "SELECT
`list`.*,
date_format(`list`.`notes_update`,'%b %e, %Y <br> %l:%i %p') as notes_update
FROM
list
WHERE
`list`.`producing_status` = 'Shut-In'  
OR `list`.`producing_status` = 'Shut-in'
OR `list`.`producing_status` = 'INACTIVE'
OR `list`.`producing_status` = 'SI'
ORDER BY
`list`.`api` ASC";
$result = mysqli_query($conn, $sql);

$num_records = mysqli_num_rows($result); 
mysqli_close($conn);
$a= array();
while ($row = mysqli_fetch_assoc($result)) {
$a['data'][] = $row;
    }

    echo (json_encode($a));


?>