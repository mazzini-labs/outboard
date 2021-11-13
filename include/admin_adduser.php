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

$editthisuser = getGetValue('editthisuser');
if ($editthisuser > 0) {
  $title = "Editing a user";
  $ob->getDataByID($editthisuser);
  $row = $ob->getRow();
  $userid = $row['userid'];
  $password = $row['password'];
  $name = $row['name'];
  $options = $row['options'];
  $pto_eligible = $row['pto_eligible'];
  $start_date = $row['start_date'];
  $part_time = $row['part_time'];
  $hours = $row['hours'];
  if (preg_match("/<READONLY>/",$options)) { $rochecked = "CHECKED"; } else { $rochecked = ""; }
  if (preg_match("/<ADMIN>/",$options)) { $adminchecked = "CHECKED"; } else { $adminchecked = ""; }
	########## ACCOUNTING FLAGS ###########
  if (preg_match("/<AP>/", $options)) { $apchecked = "CHECKED"; } else { $apchecked = "";} //Accounts Payable
  if (preg_match("/<AP-SPR>/", $options)) { $apsprchecked = "CHECKED"; } else { $apsprchecked = "";} //AP Supervisor
  if (preg_match("/<ACCT1>/", $options)) { $acct1checked = "CHECKED"; } else { $acct1checked = "";} //Accounting Group 1
  if (preg_match("/<ACCT1-SPR>/", $options)) { $acct1sprchecked = "CHECKED"; } else { $acct1sprchecked = "";} //Accounting Group 1 Supervisor
  if (preg_match("/<ACCT2>/", $options)) { $acct2checked = "CHECKED"; } else { $acct2checked = "";} //Accounting Group 2
  if (preg_match("/<ACCT2-SPR>/", $options)) { $acct2sprchecked = "CHECKED"; } else { $acct2sprchecked = "";} //Accounting Group 2 Supervisor
	
	########## ENGINEERING FLAGS ###########
  if (preg_match("/<ENG1>/", $options)) { $eng1checked = "CHECKED"; } else { $eng1checked = "";} //Engineering Group 1
  if (preg_match("/<ENG1-SPR>/", $options)) { $eng1sprchecked = "CHECKED"; } else { $eng1sprchecked = "";} //Engineering Group 1 Supervisor
  if (preg_match("/<ENG2>/", $options)) { $eng2checked = "CHECKED"; } else { $eng2checked = "";} //Engineering Group 2
  if (preg_match("/<ENG2-SPR>/", $options)) { $eng2sprchecked = "CHECKED"; } else { $eng2sprchecked = "";} //Engineering Group 2 Supervisor
  
	########## LAND FLAGS ###########
  if (preg_match("/<LAND>/", $options)) { $landchecked = "CHECKED"; } else { $landchecked = "";} //Land Department
  if (preg_match("/<LAND-SPR>/", $options)) { $landsprchecked = "CHECKED"; } else { $landsprchecked = "";} //Land Department Supervisor

	########## LEGAL FLAGS ###########
  if (preg_match("/<LEGAL>/", $options)) { $legalchecked = "CHECKED"; } else { $legalchecked = "";} //Legal Department
  if (preg_match("/<LEGAL-SPR>/", $options)) { $legalsprchecked = "CHECKED"; } else { $legalsprchecked = "";} //Legal Department Supervisor

	########## GEOLOGY FLAGS ###########
  if (preg_match("/<GEO>/", $options)) { $geochecked = "CHECKED"; } else { $geochecked = "";} //Geology Department
  if (preg_match("/<GEO-SPR>/", $options)) { $geosprchecked = "CHECKED"; } else { $geosprchecked = "";} //Geology Department Supervisor
	
	########## ADMINISTRATIVE STAFF FLAGS ###########
  if (preg_match("/<ADSTAFF>/", $options)) { $adminstaffchecked = "CHECKED"; } else { $adminstaffchecked = "";} //Administrative Staff
  if (preg_match("/<ADSTAFF-SPR>/", $options)) { $adminstaffsprchecked = "CHECKED"; } else { $adminstaffsprchecked = "";} //Administrative Staff Supervisor
	
	########## HR FLAGS ###########
  if (preg_match("/<HR>/", $options)) { $hrchecked = "CHECKED"; } else { $hrchecked = "";} //HR

	
  if (preg_match("/<ELIGIBLE>/",$options)) { $ptoeligiblechecked = "CHECKED"; } else { $ptoeligiblechecked = ""; }
  if (preg_match("/<SUPERADMIN>/",$options)) { $superadminchecked = "CHECKED"; } else { $superadminchecked = ""; }
  $submit_button = 
    "<input type=hidden name=rowid value=$editthisuser>"
    . "<input class='navbar-btn' type=submit name=edituser value=\"Update\">";
} else {
  $title = "Adding a user to the outboard";
  $userid = "";
  $name = "";
  $password = "";
  $rochecked = "";
  $adminchecked = "";
  $parttimechecked = "";
  $ptoeligiblechecked = "";
  $superadminchecked = "";
  $hours = "";
  $start_date = "";
  $apchecked = "";
  $acct1checked = "";
  $acct2checked = "";
  $eng1checked = "";
  $eng2checked = "";
  $landchecked = "";
  $legalchecked = "";
  $geochecked = "";
  $adminstaffchecked = "";
	
  $apsprchecked = "";
  $acct1checked = "";
  $acct2checked = "";
  $eng1checked = "";
  $eng2checked = "";
  $landchecked = "";
  $legalchecked = "";
  $geochecked = "";
  $adminstaffchecked = "";

  $hrchecked ="";
		
  $submit_button = "<input class='navbar-btn' type=submit name=addnewuser value=\"Add User\">";
}

?>

<div class="container">
  <div class="row">
	  <div class="col"><b><?php echo $title ?>:</b></div>
  </div>
  <div>
  <div class="row">
      <div class="col">Username:</div>
      <div class="col"><input class="input200" type=text name=newusername placeholder="Username" size=20 maxlength=50 
	   value="<?php echo $userid ?>"></div>
  </div>
  <?php if (! $BasicAuthInUse) { ?>
  <div class="row">
      <div class="col">Password:</div>
      <div class="col"><input class="input200" type=password name=newuserpass placeholder="Password" size=20 maxlength=50
	   value="<?php echo $password ?>"></div>
  </div>
  <?php } else { ?>
      <input type=hidden name=newuserpass value="unused">
  <?php } ?>
  <div class="row">
      <div class="col">Screen Name:</div>
      <div class="col"><input class="input200" type=text name=newuservisible placeholder="Screen Name" size=20 maxlength=30
	   value="<?php echo $name ?>"></div>
  </div>
  <div class="row">
      <div class="col">Hours:</div>
      <div class="col"><input class="input200" type=text name=newuserhours placeholder="Hours" size=20 maxlength=30
	   value="<?php echo $hours ?>"></div>
  </div>
  <div class="row">
      <div class="col">Start Date:</div>
      <div class="col"><input class="input200" type=text name=newuserstartdate placeholder="YYYY-MM-DD" size=20 maxlength=30
	   value="<?php echo $start_date ?>"></div>
  </div>
  <tr>
  <div class="row">
      <div class="col">Options:</div>
      <div class="col">
          <input type=checkbox name=newuserro value="yes" 
	  <?php echo $rochecked ?>> Read Only<br>
          <input type=checkbox name=newuseradmin value="yes" 
	  <?php echo $adminchecked ?>> Admin<br>
	  <?php if ($ob->isSuperAdmin()) { ?>
      	  <input type=checkbox name=newuserptoeligible value="yes" <?php echo $ptoeligiblechecked ?>> PTO Eligible<br>
	  	  <input type=checkbox name=newusersuperadmin value="yes" <?php echo $superadminchecked ?>> Super Admin<br>
	  	  <input type=checkbox name=hr value="yes" <?php echo $hrchecked ?>> HR<br>
		  <div class='row'>
			  <div class='col'>
			  <input type=checkbox name=ap value="yes" <?php echo $apchecked ?>>Accounts Payable<br>
	  	  	  <input type=checkbox name=acct1 value="yes" <?php echo $acct1checked ?>>Accounting Group 1<br>
			  <input type=checkbox name=acct2 value="yes" <?php echo $acct2checked ?>>Accounting Group 2<br>
	  	  	  <input type=checkbox name=eng1 value="yes" <?php echo $eng1checked ?>>Engineering Group 1<br>
			  <input type=checkbox name=eng2 value="yes" <?php echo $eng2checked ?>>Engineering Group 2<br>
	  	  	  <input type=checkbox name=land value="yes" <?php echo $landchecked ?>>Land<br>
			  <input type=checkbox name=legal value="yes" <?php echo $legalchecked ?>>Legal<br>
	  	  	  <input type=checkbox name=geo value="yes" <?php echo $geochecked ?>>Geology<br>
	  	  	  <input type=checkbox name=adminstaff value="yes" <?php echo $adminstaffchecked ?>>Administrative Staff<br>
			  </div>
			  <div class='col'>
			  <input type=checkbox name=apspr value="yes" <?php echo $apsprchecked ?>>Accounts Payable Supervisor<br>
	  	  	  <input type=checkbox name=acct1spr value="yes" <?php echo $acct1sprchecked ?>>Accounting G1 Supervisor<br>
			  <input type=checkbox name=acct2spr value="yes" <?php echo $acct2sprchecked ?>>Accounting G2 Supervisor<br>
	  	  	  <input type=checkbox name=eng1spr value="yes" <?php echo $eng1sprchecked ?>>Engineering G1 Supervisor<br>
			  <input type=checkbox name=eng2spr value="yes" <?php echo $eng2sprchecked ?>>Engineering G2 Supervisor<br>
	  	  	  <input type=checkbox name=landspr value="yes" <?php echo $landsprchecked ?>>Land Supervisor<br>
			  <input type=checkbox name=legalspr value="yes" <?php echo $legalsprchecked ?>>Legal Supervisor<br>
	  	  	  <input type=checkbox name=geospr value="yes" <?php echo $geosprchecked ?>>Geology Supervisor<br>
	  	  	  <input type=checkbox name=adminstaffspr value="yes" <?php echo $adminstaffsprchecked ?>>AD Staff Supervisor<br>
			  </div>
		  </div>
  	  <?php } ?>
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
<hr>
</div>


<!--<table border=0>
  <tr><td colspan=2 align=center><b><?php // echo $title ?>:</b></td></tr>
  <tr>
      <td>Username:</td>
      <td><input class="input200" type=text name=newusername placeholder="Username" size=20 maxlength=50 
	   value="<?php // echo $userid ?>"></td>
  </tr>
  <?php // if (! $BasicAuthInUse) { ?>
  <tr>
      <td valign=top>Password:</td>
      <td><input class="input200" type=password name=newuserpass placeholder="Password" size=20 maxlength=50
	   value="<?php // echo $password ?>"></td>
      </td>
  </tr>
  <?php // } else { ?>
      <input type=hidden name=newuserpass value="unused">
  <?php // } ?>
  <tr>
      <td>Screen Name:</td>
      <td><input class="input200" type=text name=newuservisible placeholder="Screen Name" size=20 maxlength=30
	   value="<?php // echo $name ?>"></td>
      </td>
      </td>
  </tr>
  <tr>
      <td>Hours:</td>
      <td><input class="input200" type=text name=newuserhours placeholder="Hours" size=20 maxlength=30
	   value="<?php // echo $hours ?>"></td>
      </td>
      </td>
  </tr>
  <tr>
      <td>Start Date:</td>
      <td><input class="input200" type=text name=newuserstartdate placeholder="YYYY-MM-DD" size=20 maxlength=30
	   value="<?php // echo $start_date ?>"></td>
      </td>
      </td>
  </tr>
  <tr>
  <tr>
      <td valign=top>Options:</td>
      <td>
          <input type=checkbox name=newuserro value="yes" 
	  <?php // echo $rochecked ?>> Read Only<br>
          <input type=checkbox name=newuseradmin value="yes" 
	  <?php // echo $adminchecked ?>> Admin<br>
		  <input type=checkbox name=newuserptoeligible value="yes" 
	  <?php//  echo $ptoeligiblechecked ?>> PTO Eligible<br>
          <input type=checkbox name=newuserparttime value="yes" 
	  <?php /* echo $parttimechecked */ ?>> Part Time
      </td>
  </tr>
  <tr>
      <td><?php//  echo $submit_button ?></td>
      <td><input class="navbar-btn" type=submit name=cancel value="Cancel"></td>
  </tr>


</table>
 -->