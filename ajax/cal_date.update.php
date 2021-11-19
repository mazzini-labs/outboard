<?php

//update.php

$connect = new PDO('mysql:host=localhost;dbname=outboard', 'outuser', 'outpass');

if(isset($_POST["id"]))
{
 $query = "
 UPDATE pto_request 
 SET title=:title, start=:start_event, end=:end_event 
 WHERE id=:id
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':title'  => $_POST['title'],
   ':start_event' => $_POST['start'],
   ':end_event' => $_POST['end'],
   ':id'   => $_POST['id']
  )
 );
}

?>
