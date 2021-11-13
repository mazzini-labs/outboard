<?php

include '../include/wsbFunctions.php';

$conn = connect_db();
//$sheet = 'ddr2015pres';
//$api = "42-077-33876";
$api = $_GET['api'];
//$table = $_GET['table'];
//$sheet = $_GET['sheet'];
//$sql = "SELECT * FROM `notes` WHERE `api` like \"%".$api."%\" ORDER BY de ASC";
/* $sql = "SELECT
`id`, 
`d`
`t`,
date_format(`de`,'%c-%e-%Y') as de,
time_format(`ts`, '%l:%i %p') as ts, 
time_format(`te`, '%l:%i %p') as te, 
`deb`,
`sd`,
`api`,
`cvn`,
`cin`,
`drn`,
`edc`,
`ecc`,
`tt`,
`dt`,
`dc`,
`at`,
`ac`,
`et`,
`ai`,
date_format(`ad`, '%c-%e-%Y') as de
FROM `notes` WHERE `api` like \"%".$api."%\" ORDER BY de ASC"; */
$sql = "SELECT
*,
date_format(`notes_update`, '%m-%d-%Y') as ne
FROM `prod_review_notes` WHERE `api` like \"%".$api."%\" ORDER BY ne DESC";
$result = mysqli_query($conn, $sql);

$num_records = mysqli_num_rows($result); 
mysqli_close($conn);
$a= array();
while ($row = mysqli_fetch_assoc($result)) {
    if($generalnotes != $row['notes'] || $shutinnotes != $row['si_notes'] || $pumper != $row['pumper'])
    {
        $a['data'][] = $row;
        
    }
    if ($notesupdate != null) {$notesupdate = $row['ne'];}
    if ($generalnotes != null) {$generalnotes = $row['notes'];}
    if ($shutinnotes != null) {$shutinnotes = $row['si_notes'];}
    if ($pumper != null) {$pumper = $row['pumper'];}
    }

    echo (json_encode($a));

?>