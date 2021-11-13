
<?php

//insert.php

 $connect = new PDO('mysql:host=localhost;dbname=outboard', 'outuser', 'outpass');

/* if(isset($_POST["title"]))
{
 $query = "
 INSERT INTO events 
 (title, start_event, end_event) 
 VALUES (:title, :start_event, :end_event)
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':title'  => $_POST['title'],
   ':start_event' => $_POST['start'],
   ':end_event' => $_POST['end']
  )
 );
} */

 $query = "
 INSERT INTO pto_request 
 (title, start_time) 
 VALUES (:title, :start_event)
 ";
 
 mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':title'  => $_POST['title'],
   ':start_event' => $_POST['start'],
//    ':all_day' => $_POST['allDay'],
  )
 );
echo $_POST['start'];


?>
