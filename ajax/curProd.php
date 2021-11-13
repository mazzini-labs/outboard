<?php
include '../include/wsbFunctions.php';
// include '../header.php';
$query = "SELECT
                `prod_data`.*,
                `list`.*
            FROM
                prod_data,
                list
            WHERE
                DATE_FORMAT(`prod_data`.`prod_mo`, '%y-%m') = DATE_FORMAT(`list`.`last_prod_date`, '%y-%m')
                AND `prod_data`.`api` = `list`.`api`
            ORDER BY
                `list`.`api` ASC";
$conn = connect_db();
$results = mysqli_query($conn, $query);
$num_records = mysqli_num_rows($results); 
// console_log($conn);
// console_log($query);
// console_log($results);
mysqli_close($conn);

$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
 /* $columnIndex = $_POST['order'][0]['column']; // Column index
 $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
 $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc */
$searchValue = $_POST['search']['value']; // Search value

/* ## Search 
$searchQuery = " ";
if($searchValue != ''){
   $searchQuery = " and (emp_name like '%".$searchValue."%' or 
        email like '%".$searchValue."%' or 
        city like'%".$searchValue."%' ) ";
} */

/* ## Total number of records without filtering
$sel = mysqli_query($conn,"select count(*) as allcount from list");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysqli_query($conn,"select count(*) as allcount from list WHERE 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount']; */

$data = array();

## Fetch records
while($row = $results -> fetch_assoc())
{
    $notes_updated = $row['notes_update'];
    $datetime = new DateTime($notes_updated);
    $data[] = array(
        "wellname" => $row['entity_common_name'],
        "state" => $row['state'],
        "county" => $row['county_parish'],
        "block" => $row['block'],
        "compname" => $row['entity_operator_code'],
        "wellstatus" => $row['producing_status'],
        "productiontype" => $row['production_type'],
        "actiondate" => $row['last_prod_date'],
        // "dayson" => $row['days_on'],
        "cur_prod_gas" => $row['gas_sold'],
        //"cur_prod_gas" => $gassold,
        "cur_prod_oil" => $row['oil_prod'],
        "cur_prod_water" => $row['water_prod'],
        
        "lineloss" => $row['gas_line_loss'],	
        "pumper" => $row['pumper'],
        // "wellcheck" => $row['report_frequency'],
        "notes" => $row['notes'],
        
        "last_updated" => $datetime->format('Y-m-d')
    );
}
    /* if(!$row['days_on'] == 0){
        avg_prod_gas = $cur_prod_gas / $row['days_on'];
        avg_prod_oil = $cur_prod_oil / $row['days_on'];
        avg_prod_water = $cur_prod_water / $row['days_on']; 
        }
    */
//  echo json_encode($data);

## Response
 $response = array(
    "draw" => intval($draw),
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  ); 
  
  echo json_encode($response);
?>