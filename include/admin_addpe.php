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

$editthisuser = getGetValue('peEdit');
$ob->console_log($editthisuser);
//$editthisuser = "'" . $editthisuser . "'";
//$editthisuser = "\"" . str_replace(" ", "%20", $editthisuser) . "\"";
$ob->console_log($editthisuser);
if (isset($editthisuser)) {
  $title = "Editing a user's phone extension";
  $table = "phoneextensions";
  $getget = $ob->getPEByID($editthisuser,$table);
  //$ob->console_log($getget);
  $row = $ob->getRow();
  $name = $row['name'];
  $ob->console_log($name);
  $etitle = $row['title'];
  $extension = $row['extension'];
  $email = $row['email'];
  $submit_button = 
    "<input type=hidden name=rowid value=$editthisuser>"
    . "<input class='navbar-btn' type=submit name=editpe value=\"Update\">";
} else {
  $title = "Adding a user's phone extension to the outboard";
  $name = "";
  $etitle = "";
  $extension = "";
  $email = "";
		
  $submit_button = "<input class='navbar-btn' type=submit name=addnewpe value=\"Add Phone Extension\">";
}

?>
<div class="container">
  <div class="row">
	  <div class="col"><b><?php echo $title ?>:</b></div>
  </div>
  <div class="row">
      <div class="col">Name:</div>
      <div class="col"><input class="input200" type=text name=newpename placeholder="John/Jane Doe" size=20 maxlength=50 
	   value="<?php echo $name ?>"></div>
  </div>
  <div class="row">
      <div class="col">Title:</div>
      <div class="col"><input class="input200" type=text name=newpetitle placeholder="Administrative Assistant" size=20 maxlength=30
	   value="<?php echo $etitle ?>"></div>
  </div>
  <div class="row">
      <div class="col">Extension:</div>
      <div class="col"><input class="input200" type=text name=newpeextension placeholder="222" size=20 maxlength=30
	   value="<?php echo $extension ?>"></div>
  </div>
  <div class="row">
      <div class="col">Email:</div>
      <div class="col"><input class="input200" type=text name=newpeemail placeholder="email@spindletopoil.com" size=20 maxlength=30
	   value="<?php echo $email ?>"></div>
  </div>
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