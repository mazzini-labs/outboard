<?php
/*
Author: Javed Ur Rehman
Website: https://www.allphptricks.com/
*/

include 'wsbFunctions.php';
$con = connect_outboard();
$name=$_REQUEST['name'];
$query = "DELETE FROM phoneextensions WHERE name=$name"; 
$result = mysqli_query($con,$query) or die ( mysqli_error());
header("Location: admin_view.php"); 
?>