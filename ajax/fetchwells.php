 
  <?php  
 //fetchwells.php  
 $connect = mysqli_connect("localhost", "root", "devonian", "wells");  
 if(isset($_POST["api"]))  
 {  
      $query = "SELECT * FROM list WHERE api = '".$_POST["api"]."'";  
      $result = mysqli_query($connect, $query);  
      $row = mysqli_fetch_array($result);  
      echo json_encode($row);  
 }  
 ?>