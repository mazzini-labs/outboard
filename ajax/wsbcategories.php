<?php
// include 'include/wsbFunctions.php';

$mysqli = connect_db();
$table = "wsbcategories";
$sql = "SELECT category, slug FROM $table";// ORDER BY well_lease ASC";
$result = mysqli_query($mysqli,$sql) or die(mysql_error());
while ($row = mysqli_fetch_array($result)) {
    // $wellname = $row['well_lease'] . "# " . $row['well_no']; 
    $category = $row['category'];
    $slug = $row['slug'];
    // $array[] = array(
    //     "id" => "wsbcategory",
    //     "text" => $category
        
    // );
    $array[] = array(
        "id" => $slug,
        "text" => $category
        
    );

    // $conditional = ($row['api'] == $apino) ?  '"' . $row['api'] . '" selected' :  '"' . $row['api'] . '"';

?>
<option><?php echo $category; //$row['api']; // . $row['well_no'];?></option>
<?php
    } 
// $select2 = json_encode($array);
// echo $select2;
// echo json_encode($array);

?>