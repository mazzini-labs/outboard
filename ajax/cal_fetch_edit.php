 
<?php  
//fetch.php  
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$connect = new PDO('mysql:host=localhost;dbname=outboard', 'outuser', 'outpass');

$data = array();
 if(isset($_POST["id"]))  
 {  
     $query = "SELECT * FROM pto_request WHERE id = '".$_POST["id"]."'";  
     $statement = $connect->prepare($query);
     $statement->execute();
     $result = $statement->fetchAll();
     //$result = mysql_query($query) or die(mysql_error());
     foreach($result as $row)
     {
          $data[] = array(
               'id'   => $row["id"],
               'title'   => $row["title"],
               'start'   => $row["start_time"],
               'end'   => $row["end_time"],
               'allDay'   => $row["all_day"],
               'color'   => $row["color"],
               'description' => $row["remarks"]
          );
     } 
      echo json_encode($data);  
 }  
 ?>
 