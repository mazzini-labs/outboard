<?php
/*
Author: Javed Ur Rehman
Website: https://www.allphptricks.com/
*/
if (! $ob->isAdmin()) { exit; }

$mainscreen = false;  // We are not on the main admin screen

$unique = uniqid(""); 
include 'wsbFunctions.php';
$con = connect_outboard();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>View Records</title>
<link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
<div class="form">
<p><a href="index.php">Home</a> | <a href="admin_insert.php">Insert New Record</a> | <a href="logout.php">Logout</a></p>
<h2>View Records</h2>
<table width="100%" border="1" style="border-collapse:collapse;">
<thead>
<tr><th><strong>S.No</strong></th><th><strong>Name</strong></th><th><strong>Age</strong></th><th><strong>Edit</strong></th><th><strong>Delete</strong></th></tr>
</thead>
<tbody>
<?php
$count=1;
$sel_query="Select * from phoneextensions;";
$result = mysqli_query($con,$sel_query);
while($row = mysqli_fetch_assoc($result)) { ?>
<tr><td align="center"><?php echo $row["name"]; ?></td><td align="center"><?php echo $row["title"]; ?></td><td align="center"><?php echo $row["extension"]; ?></td><td align="center"><?php echo $row["email"]; ?></td><td align="center"><a href="admin_edit.php?id=<?php echo $row["name"]; ?>">Edit</a></td><td align="center"><a href="admin_delete.php?id=<?php echo $row["name"]; ?>">Delete</a></td></tr>
<?php $count++; } ?>
</tbody>
</table>

<br /><br /><br /><br />
<a href="https://www.allphptricks.com/insert-view-edit-and-delete-record-from-database-using-php-and-mysqli/">Tutorial Link</a> <br /><br />
For More Web Development Tutorials Visit: <a href="https://www.allphptricks.com/">AllPHPTricks.com</a>
</div>
</body>
</html>
