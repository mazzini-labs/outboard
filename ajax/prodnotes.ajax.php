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
$sql = "SELECT DISTINCT
n.id,
n.d,
n.t,
n.de,
n.ts,
n.te,
n.deb,
n.sd,
n.api,
n.cvn,
n.cin,
n.drn,
n.edc,
n.ecc,
n.tt,
n.dt,
n.dc,
n.at,
n.ac,
n.et,
n.ai,
n.ad,
n.ec,
n.vb,
n.producing_status,
date_format(`de`, '%m-%d-%Y') as dee,
date_format(`ad`, '%m-%d-%Y') as ad,
f.sd 
FROM notes n
LEFT JOIN notes_files f
ON n.id = f.note_id 
WHERE n.api like \"%".$api."%\" and n.t like '%d%' ORDER BY de DESC";
// $sql = "SELECT
// *,
// date_format(`de`, '%m-%d-%Y') as dee,
// date_format(`ad`, '%m-%d-%Y') as ad
// FROM `notes` WHERE `api` like \"%".$api."%\" and `t` like '%d%' ORDER BY de DESC";
$result = mysqli_query($conn, $sql);

$num_records = mysqli_num_rows($result); 
mysqli_close($conn);
$a= array();
while ($row = mysqli_fetch_assoc($result)) {
// $a['data'][] = $row;
$drn = preg_replace('/[[:cntrl:]]/', '<br>', $row['drn']);

$a['data'][] = array(
    'id'  => $row["id"],
    'd'   => $row['d'],
    't'   => $row['t'],
    'de'  => $row['de'],
    'ts'  => $row['ts'],
    'te'  => $row['te'],
    'deb' => $row['deb'],
    'sd'  => $row['sd'],
    'api' => $row['api'],
    'cvn' => $row['cvn'],
    'cin' => $row['cin'],
    'drn' => $drn,
    // 'drn' => nl2br($row['drn']),
    'edc' => $row['edc'],
    'ecc' => $row['ecc'],
    'tt'  => $row['tt'],
    'dt'  => $row['dt'],
    'dc'  => $row['dc'],
    'at'  => $row['at'],
    'ac'  => $row['ac'],
    'et'  => $row['et'],
    'ai'  => $row['ai'],
    'ad'  => $row['ad'],
    'dee' => $row['dee'],
    'sd' => $row['sd']
);
    }

    echo (json_encode($a));

?>