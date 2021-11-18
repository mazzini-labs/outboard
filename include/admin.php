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
	$newuserhours = getPostValue('newuserhours');
	$start_date = getPostValue('newuserstartdate');
    $options = "";
	//$part_time = "";
	//$pto_eligible = "";
    if (getPostValue('newuserro') == "yes") { $options .= "<READONLY>"; }
    if (getPostValue('newuseradmin') == "yes") { $options .= "<ADMIN>"; }
	if (getPostValue('newusersuperadmin') == "yes") { $options .= "<SUPERADMIN>"; }
	if (getPostValue('newuserptoeligible') == "yes") { $options .= "<ELIGIBLE>"; }
	if (getPostValue('newuserparttime') == "yes") { $options .= "<PARTTIME>"; }
	
	if (getPostValue('ap') == "yes") { $options .= "<AP>"; }
	if (getPostValue('acct1') == "yes") { $options .= "<ACCT1>"; }
	if (getPostValue('acct2') == "yes") { $options .= "<ACCT2>"; }
	if (getPostValue('eng1') == "yes") { $options .= "<ENG1>"; }
	if (getPostValue('eng2') == "yes") { $options .= "<ENG2>"; }
	if (getPostValue('land') == "yes") { $options .= "<LAND>"; }
	if (getPostValue('legal') == "yes") { $options .= "<LEGAL>"; }
	if (getPostValue('geo') == "yes") { $options .= "<GEO>"; }
	if (getPostValue('adminstaff') == "yes") { $options .= "<ADSTAFF>"; }

	if (getPostValue('apspr') == "yes") { $options .= "<AP-SPR>"; }
	if (getPostValue('acct1spr') == "yes") { $options .= "<ACCT1-SPR>"; }
	if (getPostValue('acct2spr') == "yes") { $options .= "<ACCT2-SPR>"; }
	if (getPostValue('eng1spr') == "yes") { $options .= "<ENG1-SPR>"; }
	if (getPostValue('eng2spr') == "yes") { $options .= "<ENG2-SPR>"; }
	if (getPostValue('landspr') == "yes") { $options .= "<LAND-SPR>"; }
	if (getPostValue('legalspr') == "yes") { $options .= "<LEGAL-SPR>"; }
	if (getPostValue('geospr') == "yes") { $options .= "<GEO-SPR>"; }
	if (getPostValue('adminstaffspr') == "yes") { $options .= "<ADSTAFF-SPR>"; }

	if (getPostValue('hr') == "yes") { $options .= "<HR>"; }

    $result = 0;
    if ($newusername != "" and $newuserpass != "" and $newuservisible != "") {
      if (getPostValue('edituser')) {
	$result = $ob->saveUser($rowid,$newusername,$newuserpass,$newuservisible,$options,$start_date,$newuserhours);
	//$result = $ob->saveUser($rowid,$newusername,$newuserpass,$newuservisible,$options,$part_time,$start_date,$pto_eligible,$newuserhours);
      } else {
	// No rowid, so it will make a new user
	//$result = $ob->saveUser("",$newusername,$newuserpass,$newuservisible,$options,$part_time,$start_date,$pto_eligible,$newuserhours);
	$result = $ob->saveUser("",$newusername,$newuserpass,$newuservisible,$options,$start_date,$newuserhours);
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
if (getPostValue('addnewpe') or getPostValue('editpe')) {
	$newpename = getPostValue('newpename');
    $newpetitle = getPostValue('newpetitle');
    $newpeextension = getPostValue('newpeextension');
	$newpeemail = getPostValue('newpeemail');
	$table = "phoneextensions";
	$field1 = "email";
	$rowid = getPostValue('rowid');
	$result = 0;
    $result = $ob->savePE($newpename,$newpetitle,$newpeextension,$newpeemail,$table,$rowid);	
    if (! $result) {
      $message = "Error: User's Extension not added";
    } else {
      $message = "Success: Extension for user \"$newpename\" added/updated.";
    }
} elseif ($deletethisuser = getGetValue('deletethisext')) {
	$table = "phoneextensions";
	$field1 = "email";
  $result = $ob->deleteExt($field1,$deletethisuser,$table);
  if (! $result) {
    $message = "Error: user not deleted";
  } else {
    $message = "Success: user deleted.";
  }
}

if (getPostValue('addnewca') or getPostValue('editca')) {
	$field1 = "common_area";
	$field2 = "extension";
	$table = "common_area_phones";
	$value1 = getPostValue('newcaname');
    $value2 = getPostValue('newcaextension');
	$rowid = getPostValue('rowid');
	$result = 0;
	$result = $ob->saveExt($field1,$field2,$value1,$value2,$table,$rowid);
    if (! $result) {
      $message = "Error: Common Area Extension not added";
    } else {
      $message = "Success: Extension for Common Area \"$newpename\" added/updated.";
    }
} elseif ($deletethisuser = getGetValue('deletethisca')) {
	$table = "common_area_phones";
	$field1 = "common_area";
  $result = $ob->deleteExt($field1,$deletethisuser,$table);
  if (! $result) {
    $message = "Error: user not deleted";
  } else {
    $message = "Success: user deleted.";
  }
}
if (getPostValue('addnewcomp') or getPostValue('editcomp')) {
	$field1 = "misc";
	$field2 = "extension_or_other";
	$table = "other_phones_and_misc";
	$value1 = mysql_real_escape_string(getPostValue('newcompname'));
    $value2 = mysql_real_escape_string(getPostValue('newcompextension'));
	$rowid = getPostValue('rowid');
	$result = 0;
	$result = $ob->saveExt($field1,$field2,$value1,$value2,$table,$rowid);
    if (! $result) {
      $message = "Error: Company Contact Info not added";
    } else {
      $message = "Success: Company Contact Info \"$value1\" added/updated.";
    }
} elseif ($deletethisuser = getGetValue('deletethiscomp')) {
	$table = "other_phones_and_misc";
	$field1 = "misc";
  $result = $ob->deleteExt($field1,$deletethisuser,$table);
  if (! $result) {
    $message = "Error: user not deleted";
  } else {
    $message = "Success: user deleted.";
  }
}
if (getPostValue('addnew800') or getPostValue('edit800')) {
	$field1 = "company";
	$field2 = "phone";
	$table = "phone_800_numbers";
	$value1 = getPostValue('new800name');
    $value2 = getPostValue('new800extension');
	$result = 0;
	$result = $ob->saveExt($field1,$field2,$value1,$value2,$table);
    if (! $result) {
      $message = "Error: 800 number not added";
    } else {
      $message = "Success: 800 number for \"$value1\" added/updated.";
    }
} elseif ($deletethisuser = getGetValue('deletethis800')) {
	$table = "phone_800_numbers";
	$field1 = "company";
  $result = $ob->deleteExt($field1,$deletethisuser,$table);
  if (! $result) {
    $message = "Error: user not deleted";
  } else {
    $message = "Success: user deleted.";
  }
}
if (getPostValue('addnewprinter') or getPostValue('editprinter')) {
	$field1 = "name";
	$field2 = "location";
	$field3 = "ip_address";
	$table = "printers";
	$rowid = getPostValue('rowid');
	$value1 = getPostValue('newprintername');
	$value2 = getPostValue('newprinterlocation');
	$value3 = getPostValue('newprinteripaddress');
	$result = 0;
	$result = $ob->savePrinter($field1,$field2,$field3,$value1,$value2,$value3,$table,$rowid);
    if (! $result) {
      $message = "Error: Printer not added";
    } else {
      $message = "Success: Printer for \"$value1\" added/updated.";
    }
} elseif ($deletethisuser = getGetValue('deletethisprinter')) {
	$table = "printers";
	$field1 = "id";
  $result = $ob->deleteExt($field1,$deletethisuser,$table);
  if (! $result) {
    $message = "Error: printer not deleted";
  } else {
    $message = "Success: printer deleted.";
  }
}
/*
 if (getPostValue('approvePTO')){
	 $rowid = $_GET['rowid'];
echo $rowid;
//console_log($rowid);
//$rowid = 33;
$ob->getPTOByID($rowid); //see if i can make one for getting data from pto_request?
$row = $ob->getRow();
$userid = $row['userid'];
$start = $row['start_time'];
$end = $row['end_time'];
$name = $row['name'];
$request = $row['requested_pto'];
$options = $row['options'];
$title = $row['title'];

$options .= "<APPROVED>";
$result = 0;
##########################################

if (preg_match("/<PD>/",$row['options'])){
	if (preg_match("/<OA>/",$row['options'])){
		$updatetitle = "$name out at $out_time"; 
	}
	elseif (preg_match("/<IA>/",$row['options'])){
		$updatetitle = "$name in at $in_time";
	}
	else {
		$updatetitle = "$name out";
	}
}
elseif (preg_match("/<FD>/",$row['options'])) {
	$updatetitle = "$name out";
}

//$ptotable = $this->getConfig('ptotable');

$ptostmt = "UPDATE pto_request SET "
  ."title='$updatetitle', options='$options' "
  ."WHERE rowid='$rowid'";
$resulted = mysql_query($ptostmt) or die(mysql_error());
if ($userid) {
$getstmt = "SELECT * FROM $table where userid = '$userid'";
if ($row = mysql_fetch_array($getstmt)) { 
    return $row;
  }$usedPTO = $row['used_pto_hours'];
$requestedPTO = $row['requested_pto'];
if (preg_match("/<APPROVED>/",$options)){
	$newUsedPTO = $usedPTO + $request;
	$newRequestedPTO = $requestedPTO - $request;
}
elseif (preg_match("/<DENIED>/",$options)) {
	$newUsedPTO = $usedPTO;
	$newRequestedPTO = $requestedPTO - $request;
}
$stmt = "UPDATE outboard SET "
  ."used_pto_hours='$newUsedPTO', requested_pto='$newRequestedPTO' "
  ."WHERE userid='$userid'";
	}
$result = mysql_query($stmt) or die(mysql_error());
*/


#########################################
/*
if (getPostValue('approvePTO')) { 
	$result = $ob->updatePTOcal($rowid,$userid,$start_time,$end_time,$name,$options,$request); 
	$update = $ob->updatePTO($userid,$options,$request);
} 

//console_log($result);
if (! $result or ! $resulted) {
  $message = "Error: PTO request not updated";
} else {
  $message = "Success: PTO for user \"$name\" approved.";
}
echo $message;
echo "<div class='col'><input type = 'button' class='btn btn-secondary shadow-lg btn-block smol' onclick = 'ajaxPTOrequest()' value = 'Return to PTO requests'/></div>";
echo "<div class='col'><a href='outboard.php' class='btn btn-secondary shadow-lg btn-block smol'>Return to Outboard</a></div>";

//console_log($message);
 }
*/

?>

<HTML>
<HEAD>
<TITLE>OutBoard Administration</TITLE>
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="assets/css/maintest.css">
    <link href="WSB/stylesheet/bootstrap.min.css" rel="stylesheet">
	<link href="WSB/stylesheet/offcanvas.css?v1" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
  <script src='../fullcalendar/packages/core/main.js'></script>
  <script src='../fullcalendar/packages/list/main.js'></script>
  <script src='../fullcalendar/packages/interaction/main.js'></script>
  <script src='../fullcalendar/packages/daygrid/main.js'></script>
  <script src='../fullcalendar/packages/bootstrap/main.js'></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script> -->
<?php include 'include/dependencies.php'; ?>
</HEAD>
<style>
	.shadow-lg 
  {
      box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
  }
  .smol th,
.smol td,
.smol a,
.smol p,
.smol input {
  padding-top: 0.3rem;
  padding-bottom: 0.3rem;
  font-size: 12px!important;
}
</style>
<BODY style="background-color: #0e5092;">
<form class="" ACTION="<?php echo $baseurl ?>?adminscreen=1" METHOD=post autocomplete="off">
<?php include 'header_extensions.php'; ?>
	<div class="container-fluid">
		<div class="row justify-content-center" style="height:70vh;">
			<INPUT TYPE=HIDDEN NAME=adminscreen VALUE="1">
			<!--<div class="login100-pic js-tilt" data-tilt>
				<img src="images/SOGLOGO-01.svg" alt="IMG" >
			</div>-->
			<div class="col-3 mt-5 p-3 card-body bg-light justify-content-start shadow-lg ">	
			<h2 ><img class="mr-2" src="images/SOGLOGO-01.svg" alt="IMG"> <br />		OutBoard Administration</h2>
			
			<!--<span class="login100-form-title">
				OutBoard Administration
			</span>-->

		<div class=" mt-3 ">
			<div class="row justify-content-center">
				<div class="col-9">
					<div class="p-1">
					<?php
					
						if (! $adduser) {
						echo "<INPUT class='btn btn-primary shadow-lg btn-block smol' TYPE=submit NAME=adduser VALUE=\"Add A User\">";
						}
						?>
					<span class="focus-input100"></span>
					</div>

					<div class="p-1">
					<?php
						if (! $editusers and ! $editthisuser) {
							echo "<INPUT class='btn btn-primary btn btn-outline-primary shadow-lg btn-block smol' TYPE=submit NAME=editusers VALUE=\"View Users\">";
						}
					?>
					</div>
					
					<div class="p-1">
					<?php
						if (! $peAdd) {
							echo "<INPUT class='btn btn-secondary shadow-lg btn-block smol' TYPE=submit NAME=peAdd VALUE=\"Add Extension\">";
						}
					?>
					</div>
					<div class="p-1">
					<?php
						if (! $pe and ! $peEdit) {
							echo "<INPUT class='btn btn-outline-secondary shadow-lg btn-block smol' TYPE=submit NAME=pe VALUE=\"View Extensions\">";
						}
					?>
					</div>
					<div class="p-1">
					<?php
						if (! $caAdd) {
							echo "<INPUT class='btn btn-info shadow-lg btn-block smol' TYPE=submit NAME=caAdd VALUE=\"Add Common Area Extension\">";
						}
					?>
					</div>
					<div class="p-1">
					<?php
						if (! $ca and ! $caEdit) {
							echo "<INPUT class='btn btn-outline-info shadow-lg btn-block smol' TYPE=submit NAME=ca VALUE=\"View Common Area Extensions\">";
						}
					?>
					</div>
				</div>
					
				<div class="col-9">
					
					
					
					<div class="p-1">
					<?php
						if (! $compAdd) {
							echo "<INPUT class='btn btn-dark shadow-lg btn-block smol' TYPE=submit NAME=compAdd VALUE=\"Add Other Company Information\">";
						}
					?>
					</div>
					<div class="p-1">
					<?php
						if (! $comp and ! $compEdit) {
							echo "<INPUT class='btn btn-outline-dark shadow-lg btn-block smol' TYPE=submit NAME=comp VALUE=\"View Other Company Information\">";
						}
					?>
					</div>
					<div class="p-1">
					<?php
						if (! $_800Add) {
							echo "<INPUT class='btn btn-warning shadow-lg btn-block smol' TYPE=submit NAME=_800Add VALUE=\"Add Company 800 Numbers\">";
						}
					?>
					</div>
					<div class="p-1">
					<?php
						if (! $_800 and ! $_800Edit) {
							echo "<INPUT class='btn btn-outline-warning shadow-lg btn-block smol shadow-sm' TYPE=submit NAME=_800 VALUE=\"View Company 800 Numbers\">";
						}
					?>
					</div>
					<div class="p-1">
					<?php
						if (! $printerAdd) {
							echo "<INPUT class='btn btn-danger shadow-lg btn-block smol' TYPE=submit NAME=printerAdd VALUE=\"Add Printers\">";
						}
					?>
					</div>
					<div class="p-1">
					<?php
						if (! $printer and ! $printerEdit) {
							echo "<INPUT class='btn btn-outline-danger shadow-lg btn-block smol' TYPE=submit NAME=printer VALUE=\"View Printers\">";
						}
					?>
					</div>
				</div>
			</div>
			<hr>
			<div class="mt-3">
				<INPUT class="btn btn-primary shadow-lg btn-block smol" TYPE=submit NAME=exitadmin VALUE="Return to OutBoard">
			</div>
			</div>
			
					</div>
		<div class="pl-0 p-2 col-6 mt-5 shadow-lg  card-body bg-light">
			<div class="mt-5">
		<?php 
				if ($message != "") { echo "<br>$message<br><hr>"; }
				$mainscreen = true;     // Other screens change this
				if ($adduser = getPostValue('adduser'))      { include("include/admin_adduser.php");   }
				if ($editusers = getPostValue('editusers'))    { include("include/admin_editusers.php"); } 
				if ($editthisuser = getGetValue('editthisuser')) { include("include/admin_adduser.php"); }
			// if ($requests = getPostValue('requests')) { include("include/admin_ptorequests.php"); }
				if ($peAdd = getPostValue('peAdd'))      { include("include/admin_addpe.php");   }
				if ($pe = getPostValue('pe')) { include("include/admin_editphones.php"); }
				if ($peEdit = getGetValue('peEdit')) { include("include/admin_addpe.php"); }


				if ($compAdd = getPostValue('compAdd'))      { include("include/admin_addcompext.php");   }
				if ($comp = getPostValue('comp')) { include("include/admin_editcomp.php"); }
				if ($compEdit = getGetValue('compEdit')) { include("include/admin_addcompext.php"); }
				if ($caAdd = getPostValue('caAdd'))      { include("include/admin_addcaext.php");   }
				if ($ca = getPostValue('ca')) { include("include/admin_editca.php"); }
				if ($caEdit = getGetValue('caEdit')) { include("include/admin_addcaext.php"); }
				if ($_800Add = getPostValue('_800Add'))      { include("include/admin_add800ext.php");   }
				if ($_800 = getPostValue('_800')) { include("include/admin_edit800.php"); }
				if ($_800Edit = getGetValue('_800Edit')) { include("include/admin_add800ext.php"); }
				if ($printerAdd = getPostValue('printerAdd'))      { include("include/admin_addprinter.php");   }
				if ($printer = getPostValue('printer')) { include("include/admin_editprinter.php"); }
				if ($printerEdit = getGetValue('printerEdit')) { include("include/admin_addprinter.php"); }

			//  if ($cal = getPostValue('calendar')) { include("include/admin_cal.php"); }
			// Show correct buttons depending on the current screen
			if (! $mainscreen) { echo "<hr>"; }
				?>
		</div>
					</div>
					
	</div>
</div>
</form>
</BODY>
<script> feather.replace(); </script>
</HTML>

<?php
   exit; // exit since this is an include and we don't want to
         // go any farther in the calling script
?>
