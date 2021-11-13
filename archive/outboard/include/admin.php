<?php

// admin.php
// 
// The Administration screen for the admin user. This script is automatically
// included by the outboard.php script if the admin user is logged in.
//
// 2005-02-16	Richard F. Feuerriegel (richardf@acesag.auburn.edu)
//	- Changed to work with OutBoard 2.0
// 2001-06-11	Richard F. Feuerriegel (richardf@acesag.auburn.edu)
//	- Initial creation

if (! $ob->isAdmin()) { exit; }

$message = "";   // Stores status messages of admin actions

// Does user want to add or edit a user?
if (getPostValue('addnewuser') or getPostValue('edituser')) {
    $newusername = getPostValue('newusername');
    $newuserpass = getPostValue('newuserpass');
    $newuservisible = getPostValue('newuservisible');
    $rowid = getPostValue('rowid');
    $options = "";
    if (getPostValue('newuserro') == "yes") { $options .= "<READONLY>"; }
    if (getPostValue('newuseradmin') == "yes") { $options .= "<ADMIN>"; }
    $result = 0;
    if ($newusername != "" and $newuserpass != "" and $newuservisible != "") {
      if (getPostValue('edituser')) {
	$result = $ob->saveUser($rowid,$newusername,$newuserpass,$newuservisible,$options);
      } else {
	// No rowid, so it will make a new user
	$result = $ob->saveUser("",$newusername,$newuserpass,$newuservisible,$options);
      }
    }
    if (! $result) {
      $message = "Error: user not added";
    } else {
      $message = "Success: user \"$newusername\" added/updated.";
    }
} elseif ($deletethisuser = getGetValue('deletethisuser')) {
  $result = $ob->deleteUser($deletethisuser);
  if (! $result) {
    $message = "Error: user not deleted";
  } else {
    $message = "Success: user deleted.";
  }
}

?>

<HTML>
<HEAD>
<TITLE>OutBoard Administration</TITLE>
<!--?php include("include/stylesheet.php"); ?-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</HEAD>
<BODY>
<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<INPUT TYPE=HIDDEN NAME=adminscreen VALUE="1">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/SOGLOGO-01.svg" alt="IMG" >
				</div>

			<form class="login100-form" ACTION="<?php echo $baseurl ?>?adminscreen=1" METHOD=post>
				<span class="login100-form-title">
					OutBoard Administration
				</span>

				<?php 
 				 if ($message != "") { echo "<br>$message<br><hr>"; }
 				 $mainscreen = true;     // Other screens change this
				 if ($adduser = getPostValue('adduser'))      { include("include/admin_adduser.php");   }
  				 if ($editusers = getPostValue('editusers'))    { include("include/admin_editusers.php"); } 
  				 if ($editthisuser = getGetValue('editthisuser')) { include("include/admin_adduser.php"); }
				 ?>
						
				<div class="wrap-input100">
				<?php
				// Show correct buttons depending on the current screen
 				 if (! $mainscreen) { echo "<hr>"; } else { echo "<br>"; }
 				 if (! $adduser) {
   				 echo "<INPUT class='login100-form-btn' TYPE=submit NAME=adduser VALUE=\"Add A User\">";
 				 }
				 ?>
				<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100">
				<?php
				  if (! $editusers and ! $editthisuser) {
					 echo "<INPUT class='login100-form-btn' TYPE=submit NAME=editusers VALUE=\"Edit Users\">";
 				 }
				?>
				</div>

				<div class="container-login100-form-btn">
					<INPUT class="login100-form-btn" TYPE=submit NAME=exitadmin VALUE="Return to OutBoard">
				</div>
			</form>	
		</div>
	</div>
</div>
</BODY>
</HTML>

<?php
   exit; // exit since this is an include and we don't want to
         // go any farther in the calling script
?>
