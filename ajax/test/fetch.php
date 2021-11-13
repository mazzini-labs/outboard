
  <?php  
 //fetch.php
 $mysqli = mysqli_connect("localhost", "root", "devonian", "wells");  
 if(isset($_POST["ddr_id"]))  
 {  
 $api = '"' . $_POST['api'] . '"';
 $ddr = "new_ddr";
 $datasql = "SELECT * FROM $ddr WHERE api=$api AND id = '".$_POST["ddr_id"]."'";
 $dataresult = mysqli_query($mysqli, $datasql) or die(mysql_error());
 $row = mysqli_fetch_array($dataresult);  
   echo json_encode($row);  


 
 }  
 ?>
 