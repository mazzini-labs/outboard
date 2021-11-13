 
  <?php  
 //fetch.noper.php  
  $connect = mysqli_connect("localhost", "root", "devonian", "noper");  
 if(isset($_POST["id"]))  
 {  
      $query = "SELECT * FROM `properties` p LEFT JOIN `interest_information` i ON p.`property` = i.`property` WHERE p.`property` = '".$_POST["id"]."'";  
     //  echo $query;
      $result = mysqli_query($connect, $query);  
      $row = mysqli_fetch_array($result);  
      echo json_encode($row);  
 }  
 ?>
 