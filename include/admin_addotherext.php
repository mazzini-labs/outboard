<?php

// admin_adduser.php
//
// Adduser screen for admin user. Included by the admin.php script when
// the Add button is pressed. This screen is also used to edit existing
// users since the form is the same (just with filled in values).
// 
// 2002-04-11	richardf - Added note about basic auth and passwords
// 2001-06-11	Richard F. Feuerriegel  (richardf@acesag.auburn.edu)

if (! $ob->isAdmin()) { exit; }

$mainscreen = false;  // set to false b/c we are not on the 
		      // main admin screen

// Check to see if the admin user wants to edit an existing user

$editthisuser = getGetValue('caEdit');
$table = $_GET['table'];
$ob->console_log($table);
//$editthisuser = "'" . $editthisuser . "'";
//$editthisuser = "\"" . str_replace(" ", "%20", $editthisuser) . "\"";
$ob->console_log($editthisuser);
if (isset($editthisuser)) {
  if ($table == 1){
    $title = "Editing common area location phone extension";
    $table = "common_area_phones";
    $row = $ob->getRow();
    $name = $row['name'];
    $extension = $row['extension'];
    $submit_button = 
    "<input type=hidden name=rowid value=$editthisuser>"
    . "<input class='navbar-btn' type=submit name=editpe value=\"Update\">";
  } elseif ($table == 2){
    $title = "Editing company contact information";
    $table = "other_phones_and_misc";
    $row = $ob->getRow();
    $name = $row['name'];
    $extension = $row['extension'];
    $submit_button = 
    "<input type=hidden name=rowid value=$editthisuser>"
    . "<input class='navbar-btn' type=submit name=editpe value=\"Update\">";
  } elseif ($table == 3) {
    $title = "Editing company 800 phone number ";
    $table = "phone_800_numbers";
    $row = $ob->getRow();
    $name = $row['name'];
    $extension = $row['extension'];
    $submit_button = 
    "<input type=hidden name=rowid value=$editthisuser>"
    . "<input class='navbar-btn' type=submit name=editpe value=\"Update\">";
  } else {
      $ob->console_log("if loop doesn't work!");
  }
} else {
    if ($table == "1"){
        $title = "Adding new common area location phone extension to the outboard";
        $table = "common_area_phones";
        $submit_button = "<input class='navbar-btn' type=submit name=addnewca value=\"Add Phone Extension\">";
      } elseif ($table == "2"){
        $title = "Adding new company information to the outboard";
        $table = "other_phones_and_misc";
        $submit_button = "<input class='navbar-btn' type=submit name=addnewcomp value=\"Add Phone Extension\">";
      } elseif ($table == 3) {
        $title = "Adding new company 800 phone number to the outboard";
        $table = "phone_800_numbers";
        $submit_button = "<input class='navbar-btn' type=submit name=addnew800 value=\"Add Phone Extension\">";

      } else {
          echo "Didn't work!";
      }
  $name = "";
  $extension = "";
		
}

?>
<div class="container">
  <div class="row">
	  <div class="col"><b><?php echo $title ?>:</b></div>
  </div>
  <?php 
  if ($table == 1) {
  ?>
  <div class="row">
      <div class="col">Company:</div>
      <div class="col"><input class="input200" type=text name=newothername placeholder="Spindletop Phone" size=20 maxlength=50 
	   value="<?php echo $name ?>"></div>
  </div>
  <div class="row">
      <div class="col">Contact:</div>
      <div class="col"><input class="input200" type=text name=newotherextension placeholder="972-644-2581" size=20 maxlength=30
	   value="<?php echo $extension ?>"></div>
  </div>
  <?php 
  } elseif ($table == 2) {
  ?>
   <div class="row">
      <div class="col">Common Area Location:</div>
      <div class="col"><input class="input200" type=text name=newothername placeholder="Back Boardroom" size=20 maxlength=50 
	   value="<?php echo $name ?>"></div>
  </div>
  <div class="row">
      <div class="col">Ext:</div>
      <div class="col"><input class="input200" type=text name=newotherextension placeholder="293" size=20 maxlength=30
	   value="<?php echo $extension ?>"></div>
  </div>
  <?php 
  } elseif ($table == 3) {
  ?>
   <div class="row">
      <div class="col">Company:</div>
      <div class="col"><input class="input200" type=text name=newothername placeholder="SOG" size=20 maxlength=50 
	   value="<?php echo $name ?>"></div>
  </div>
  <div class="row">
      <div class="col">800 Phone Number:</div>
      <div class="col"><input class="input200" type=text name=newotherextension placeholder="800-555-5555" size=20 maxlength=30
	   value="<?php echo $extension ?>"></div>
  </div>
  <?php 
  } 
  ?>
  <tr>

	  <!--
          <input type=checkbox name=newuserparttime value="yes" 
	  <?php /* echo $parttimechecked */ ?>> Part Time
		--><div class="navbar">
				  <div class="col"><?php echo $submit_button ?></div>
				  <div class="col"><input class="navbar-btn" type=submit name=cancel value="Cancel"></div>
			  </div>
      </div>
	  
  </div>

  
</div>



<!--<table border=0>
  <tr><td colspan=2 align=center><b><?php echo $title ?>:</b></td></tr>
  <tr>
      <td>Username:</td>
      <td><input class="input200" type=text name=newusername placeholder="Username" size=20 maxlength=50 
	   value="<?php echo $userid ?>"></td>
  </tr>
  <?php if (! $BasicAuthInUse) { ?>
  <tr>
      <td valign=top>Password:</td>
      <td><input class="input200" type=password name=newuserpass placeholder="Password" size=20 maxlength=50
	   value="<?php echo $password ?>"></td>
      </td>
  </tr>
  <?php } else { ?>
      <input type=hidden name=newuserpass value="unused">
  <?php } ?>
  <tr>
      <td>Screen Name:</td>
      <td><input class="input200" type=text name=newuservisible placeholder="Screen Name" size=20 maxlength=30
	   value="<?php echo $name ?>"></td>
      </td>
      </td>
  </tr>
  <tr>
      <td>Hours:</td>
      <td><input class="input200" type=text name=newuserhours placeholder="Hours" size=20 maxlength=30
	   value="<?php echo $hours ?>"></td>
      </td>
      </td>
  </tr>
  <tr>
      <td>Start Date:</td>
      <td><input class="input200" type=text name=newuserstartdate placeholder="YYYY-MM-DD" size=20 maxlength=30
	   value="<?php echo $start_date ?>"></td>
      </td>
      </td>
  </tr>
  <tr>
  <tr>
      <td valign=top>Options:</td>
      <td>
          <input type=checkbox name=newuserro value="yes" 
	  <?php echo $rochecked ?>> Read Only<br>
          <input type=checkbox name=newuseradmin value="yes" 
	  <?php echo $adminchecked ?>> Admin<br>
		  <input type=checkbox name=newuserptoeligible value="yes" 
	  <?php echo $ptoeligiblechecked ?>> PTO Eligible<br>
          <input type=checkbox name=newuserparttime value="yes" 
	  <?php /* echo $parttimechecked */ ?>> Part Time
      </td>
  </tr>
  <tr>
      <td><?php echo $submit_button ?></td>
      <td><input class="navbar-btn" type=submit name=cancel value="Cancel"></td>
  </tr>


</table>
 -->