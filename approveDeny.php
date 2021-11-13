<?php
include 'include/wsbFunctions.php';

require_once("lib/OutboardConfig.php");
require_once("lib/OutboardDatabase.php");
require_once("lib/OutboardAuth.php");

include_once("include/char_widths.php");
include_once("include/common.php");

include "include/mail_finalapproval.php";
//include "include/mail_confirmation.php";

$auth = new OutboardAuth();
$ob   = new OutboardDatabase();
$session = $auth->getSessionCookie();
$username = $ob->getSession($session);

$department = "(";
//if (! $ob->isAdmin()) { exit; }


$rowid = $_GET['id'];
$choice = $_GET['choice'];
$start = $_GET['start'];
$end = $_GET['end'];
$request = $_GET['request'];

$ob->getPTOByID($rowid); //see if i can make one for getting data from pto_request?
$row = $ob->getRow();
$userid = $row['userid'];
if($start == null){
	$start = $row['start_time'];
}
if($end == null){
	$end = $row['end_time'];
}
$name = $row['name'];
if($request == null){
	$request = $row['requested_pto'];
}

console_log($request);
$options = $row['options'];
$title = $row['title'];
$department = $row['department'];
	$mailStartTime = date('n/j/y g:ia', strtotime($start));
	$mailEndTime = date('n/j/y g:ia', strtotime($end));
	$in_time = date('g:ia',strtotime($end));
	$out_time = date('g:ia',strtotime($start));
$result = 0;

##########################################
if (preg_match("/<HR>/",$department)) { 
	$department = "HR";
	$departmentemail = $ob->getConfig('hr');
} elseif (preg_match("/<AP>/",$department)) {
	$department = "Accounts Payable";
	$departmentemail = $ob->getConfig('ap');
} elseif (preg_match("/<ACCT1>/",$department)) { 
	$department = "Accouting Supervisor";
	$departmentemail = $ob->getConfig('a1');
} elseif (preg_match("/<ACCT2>/",$department)) { 
	$department = "Accounting Managers Supervisors";
	$departmentemail = $ob->getConfig('a2');
} elseif (preg_match("/<ENG1>/",$department)) { 
	$department = "Engineering Supervisor";
	$departmentemail = $ob->getConfig('e1');
} elseif (preg_match("/<ENG2>/",$department)) { 
	$department = "Engineering Supervisor";
	$departmentemail = $ob->getConfig('e2');
} elseif (preg_match("/<LAND>/",$department)) { 
	$department = "Land Supervisor";
	$departmentemail = $ob->getConfig('land');
} elseif (preg_match("/<LEGAL>/",$department)) { 
	$department = "Legal Supervisor";
	$departmentemail = $ob->getConfig('legal');
} elseif (preg_match("/<GEO>/",$department)) { 
	$department = "Geology Supervisor";
	$departmentemail = $ob->getConfig('geo');
} elseif (preg_match("/<ADSTAFF>/",$department)) { 
	$department = "Administrative Staff Supervisor";
	$departmentemail = $ob->getConfig('adstaff');
}
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
else { $updatetitle = $title;}

//$ptotable = $this->getConfig('ptotable');
if ($ob->isHR() and ($ob->isAPspr() || $ob->isA1spr() || $ob->isA2spr() || $ob->isE1spr() || $ob->isE2spr() || $ob->isLandspr() || $ob->isLegalspr() || $ob->isGeospr() || $ob->isADstaffspr())) { 
	if ($choice == "Approved"){$options .= "<PARTAPPROVE>";}
	if ($choice == "Denied"){$options .= "<DENIED>";}
	$ptostmt = "UPDATE pto_request SET "
		."options='$options' "
		."WHERE rowid='$rowid'";
	sendHRMail($name, $mailStartTime, $mailEndTime, $request);
} elseif ($ob->isAPspr() || $ob->isA1spr() || $ob->isA2spr() || $ob->isE1spr() || $ob->isE2spr() || $ob->isLandspr() || $ob->isLegalspr() || $ob->isGeospr() || $ob->isADstaffspr()) { 
	if ($choice == "Approved"){$options .= "<PARTAPPROVE>";}
	if ($choice == "Denied"){$options .= "<DENIED>";}
	$ptostmt = "UPDATE pto_request SET "
		."options='$options' "
		."WHERE rowid='$rowid'";
	sendHRMail($name, $mailStartTime, $mailEndTime, $request);
} elseif ($ob->isHR()) { 
	if ($choice == "Approved"){$options .= "<APPROVED>";}
	if ($choice == "Denied"){$options .= "<DENIED>";}
	$ptostmt = "UPDATE pto_request SET "
		."title='$updatetitle', options='$options' "
		."WHERE rowid='$rowid'";
	sendConfirmMail($name,$mailStartTime,$mailEndTime,$request,$department,$departmentemail,$userid);
}

$resulted = mysql_query($ptostmt) or die(mysql_error());
if ($userid) {
	$ob->getOutboardPTOByUID($userid);
	$row = $ob->getRow();
	$requestedPTO = $row['requested_pto'];
	$usedPTO = $row['used_pto_hours'];

if($usedPTO == null){ $usedPTO = 0;}
	
if (preg_match("/<APPROVED>/",$options)){
	
	$newUsedPTO = $usedPTO + $request;
	console_log($newUsedPTO);
	$newRequestedPTO = $requestedPTO - $request;
	console_log($newRequestedPTO);
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


#########################################
/*
if (getPostValue('approvePTO')) { 
	$result = $ob->updatePTOcal($rowid,$userid,$start_time,$end_time,$name,$options,$request); 
	$update = $ob->updatePTO($userid,$options,$request);
} 
*/
if (! $result or ! $resulted) {
  $message = "<h2>Error: PTO request not updated.</h2>";
} else {
  $message = "<h2>Success: PTO for user \"$name\" updated.</h2>";
}


 
/*
	$ob->getPTOByID($ptoID); //see if i can make one for getting data from pto_request?
	$row = $ob->getRow();
	$userid = $row['userid'];
	$start = $row['start_time'];
	$end = $row['end_time'];
	$name = $row['name'];
	$request = $row['requested_pto'];
	$options = $row['options'];
	$title = $row['title'];

    if (getPostValue('denyPTO') > 0) { $options .= "<DENIED>"; }
    $result = 0;
    if (getPostValue('denyPTO')) { 
		$result = $ob->updatePTOcal($rowid,$userid,$start_time,$end_time,$name,$options,$request); 
		$update = $ob->updatePTO($userid,$options,$request);
	} 
    if (! $result) {
      $message = "Error: PTO request not updated";
    } else {
      $message = "Success: PTO for user \"$name\" denied.";
    }

*/
//echo $message;
//echo "<div class='col'><a href='approvePTO.php' class='navbar-btn'>Return to PTO Requests</a></div>";

//echo "<div class='col'><a href='outboard.php' class='navbar-btn'>Return to Outboard</a></div>";
?>
<!doctype html>

<HTML>
<HEAD>
<TITLE>Approve PTO: <?php echo $ob->getConfig('board_title') ?></TITLE>

<!--?php include("include/reportstylesheet.php"); ?-->
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
	<!--link rel="stylesheet" type="text/css" href="css/bootstrap-datepicker.css"-->
<!--===============================================================================================-->
	
<body>
	
	<div class="container-login100">
		<div class="wrap-login200">
			<div class="container">
				<div class="row">
					<img width=20% src="images/SOGLOGO-01.svg" alt="IMG">
					 <br /><br />
				
				</div>
				<br />
				<div class='col'>
					
				<?php echo $message; ?>
					<br />
				<div class='col'><a href='approvePTO.php' class='navbar-btn'>Return to PTO Requests</a></div>
				<br />
				<div class='col'><a href='outboard.php' class='navbar-btn'>Return to Outboard</a></div>
				
				</div>
			</div>
			
				
				
					
			
	</div>
</div>	
	
	
</body>