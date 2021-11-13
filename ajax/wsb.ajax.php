<?php

include '../include/wsbFunctions.php';

$conn = connect_db();
//$sheet = 'ddr2015pres';
//$api = "42-077-33876";
//$table = $_GET['table'];
//$sheet = $_GET['sheet'];
$sql = "SELECT
`prod_data`.`api`, 
`prod_data`.`days_on`, 
date_format(`prod_data`.`prod_mo`,'%c-%e-%Y') as prod_mo,
`prod_data`.`gas_sold`, 
`prod_data`.`gas_wh_mcf`, 
`prod_data`.`oil_prod`, 
`prod_data`.`water_prod`,
`prod_data`.`gas_line_loss`,
`list`.`api`, 
`list`.`entity_common_name`, 
`list`.`state`, 
`list`.`county_parish`, 
`list`.`block`, 
`list`.`entity_operator_code`, 
`list`.`producing_status`, 
`list`.`production_type`, 
`list`.`pumper`, 
`list`.`notes`, 
`list`.`entity_type`,
`list`.`notes_update`,
date_format(`list`.`last_prod_date`,'%c-%e-%Y') as last_prod_date,
concat(`list`.`de`, ' ', `list`.`ts`) as de
FROM
    prod_data,
    list
WHERE
    DATE_FORMAT(`prod_data`.`prod_mo`, '%y-%m') = DATE_FORMAT(`list`.`last_prod_date`, '%y-%m')
    AND `prod_data`.`api` = `list`.`api`
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