<?php

include '../include/wsbFunctions.php';

$conn = connect_db();
//$sheet = 'ddr2015pres';
//$api = "42-077-33876";
//$table = $_GET['table'];
//$sheet = $_GET['sheet'];
$sql = "SELECT
`latest_prod_data`.`api`, 
date_format(`latest_prod_data`.`prod_date`,'%c-%e-%Y') as prod_mo,
`latest_prod_data`.`gas_wh_mcf`, 
`latest_prod_data`.`oil_prod`, 
`latest_prod_data`.`water_prod`,
`latest_prod_data`.`sd`,
`list`.`api`, 
`list`.`entity_common_name`, 
`list`.`state`, 
`list`.`county_parish`, 
`list`.`block`, 
`list`.`entity_operator_code`, 
`list`.`producing_status`, 
`list`.`production_type`, 
`list`.`pumper`, 
`list`.`report_frequency`, 
`list`.`notes`, 
`list`.`entity_type`,
`list`.`notes_update`,
date_format(`list`.`update_latest_prod_date`,'%c-%e-%Y') as update_latest_prod_date,
`list`.`lpd`,
concat(`list`.`lpd_sd`,' ',`list`.`lpd_st`) as lpdcheck
FROM
    latest_prod_data,
    list
WHERE
    DATE_FORMAT(`latest_prod_data`.`prod_date`, '%y-%m-%d') = DATE_FORMAT(`list`.`lpd`, '%y-%m-%d')
    AND `latest_prod_data`.`sd` = concat(`list`.`lpd_sd`,' ',`list`.`lpd_st`)
    AND `latest_prod_data`.`api` = `list`.`api`
    AND `list`.`show` = 1   
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

// was on line 30 ->    // date_format(`list`.`notes_update`,'%b %e, %Y <br> %l:%i %p') as notes_update,
?>