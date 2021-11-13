<?php
/*
Author: Javed Ur Rehman
Website: https://www.allphptricks.com/
*/
 
include 'wsbFunctions.php';
$con = connect_outboard();

$status = "";
if(isset($_POST['new']) && $_POST['new']==1)
{
$name =$_REQUEST['name'];
$title =$_REQUEST['title'];
$extension = $_REQUEST['extension'];
$email = $_REQUEST['email'];

$ins_query="insert into phoneextensions (`name`,`title`,`extension`,`email`) values ('$name','$title','$extension','$email')";
mysqli_query($con,$ins_query) or die(mysql_error());
$status = "New Record Inserted Successfully.</br></br><a href='admin_view.php'>View Inserted Record</a>";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Insert New Record</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<div class="form">
<p><a href="dashboard.php">Dashboard</a> | <a href="admin_view.php">View Records</a> | <a href="logout.php">Logout</a></p>

<div>
<h1>Insert New Record</h1>
<form name="form" method="post" action=""> 
<input type="hidden" name="new" value="1" />
<p><input type="text" name="name" placeholder="Enter Name" required /></p>
<p><input type="text" name="title" placeholder="Enter Title" required /></p>
<p><input type="text" name="extension" placeholder="Enter Extension" required /></p>
<p><input type="text" name="email" placeholder="Enter Email" required /></p>
<p><input name="submit" type="submit" value="Submit" /></p>
</form>
<p style="color:#FF0000;"><?php echo $status; ?></p>

<br /><br /><br /><br />
<a href="https://www.allphptricks.com/insert-view-edit-and-delete-record-from-database-using-php-and-mysqli/">Tutorial Link</a> <br /><br />
For More Web Development Tutorials Visit: <a href="https://www.allphptricks.com/">AllPHPTricks.com</a>
</div>
</div>
</body>
</html>
