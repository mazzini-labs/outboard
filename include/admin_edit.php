<?php
/*
Author: Javed Ur Rehman
Website: https://www.allphptricks.com/
*/
 
include 'wsbFunctions.php';
$con = connect_outboard();
$id=$_REQUEST['id'];
$query = "SELECT * from new_record where id='".$id."'"; 
$result = mysqli_query($con, $query) or die ( mysqli_error());
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Update Record</title>
<link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
<div class="form">
<p><a href="dashboard.php">Dashboard</a> | <a href="admin_insert.php">Insert New Record</a> | <a href="logout.php">Logout</a></p>
<h1>Update Record</h1>
<?php
$status = "";
if(isset($_POST['new']) && $_POST['new']==1)
{
$name =$_REQUEST['name'];
$title =$_REQUEST['title'];
$extension =$_REQUEST['extension'];
$email =$_REQUEST['email'];
$update="update phoneextensions set name='".$name."', title='".$title."', extension='".$extension."', email='".$email."'";
mysqli_query($con, $update) or die(mysqli_error());
$status = "Record Updated Successfully. </br></br><a href='admin_view.php'>View Updated Record</a>";
echo '<p style="color:#FF0000;">'.$status.'</p>';
}else {
?>
<div>
<form name="form" method="post" action=""> 
<input type="hidden" name="new" value="1" />
<p><input type="text" name="title" placeholder="Enter Name" required value="<?php echo $row['name'];?>" /></p>
<p><input type="text" name="title" placeholder="Enter Title" required value="<?php echo $row['title'];?>" /></p>
<p><input type="text" name="extension" placeholder="Enter Extension" required value="<?php echo $row['extension'];?>" /></p>
<p><input type="text" name="extension" placeholder="Enter Email" required value="<?php echo $row['email'];?>" /></p>

<p><input name="submit" type="submit" value="Update" /></p>
</form>
<?php } ?>

<br /><br /><br /><br />
<a href="https://www.allphptricks.com/insert-view-edit-and-delete-record-from-database-using-php-and-mysqli/">Tutorial Link</a> <br /><br />
For More Web Development Tutorials Visit: <a href="https://www.allphptricks.com/">AllPHPTricks.com</a>
</div>
</div>
</body>
</html>
