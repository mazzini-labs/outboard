<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
</body>
</html>

<?php
require_once("lib/OutboardAuth.php");
require_once("lib/OutboardTimeclock.php");
require_once("lib/obP.php");
require_once("lib/OutboardDatabase.php");

include_once("include/common.php");
include_once("include/html_helper.php");
include_once("include/html_helper_test.php");
include_once("include/fullname.php");

// Get the session (if there is one)
$auth = new OutboardAuth();
$ob = new OutboardDatabase();
$session = $auth->getSessionCookie();
$username = $ob->getSession($session);

if (! $username) { exit; }

//--------- Protected Area --------

$tempUserHash = $ob->getNames();
$userHash = Array();

$userHash[$username] = $tempUserHash[$username];

// If we don't have a userid yet, use the username
if (! $userid = getPostValue('userid')) { $userid = $username; }

// Don't let non-admins use anyone else's userids.
if (! $ob->isAdmin()) { $userid = $username; }

if (isset($userHash[$userid])) {
  $fullname = $userHash[$userid];
} else {
  $fullname = "";
}

if (getPostValue('Show') || count($userHash) == 1) {
  $show_data = true;
} else {
  $show_data = false;
}

if (getPostValue('timesheet')) {
  $fullname = get_fullname($userid);
  include_once("include/timesheet.php");
  exit;
}

include 'include/wsbFunctions.php';

$startchoice = $_GET['startchoice'];
/*$endchoice = $_GET['endchoice'];
//$reportchoice = $_GET['reportchoice'];
$start = (date('Y-m-d', strtotime($startchoice)));
//$start = '2020-03-01';
$start .= ' 00:00:00';
$end = (date('Y-m-d',strtotime($endchoice)));
$datesSelected = date_diff($start, $end);
*/


//to make this work for specific users, make a dropdown and pull its value to put into comment code below
//$userselect = $_GET['userselect'];
$userselect = 'matt';
//$query = "SELECT * FROM outboard WHERE 'userid' like '%$userselect%'"; 
$query = "select * from outboard where userid like '".$userselect."';";

$result = mysql_query($query) or die(mysql_error());
console_log($userselect);
console_log($query);
console_log($result);
while($row = mysql_fetch_array($result)){ 
	$userid = $row['userid'];
	//$userid = $_GET['userid'];
		console_log($userid);

	$startstring = $row['start_date'];
	$currentdate = date('Y-m-d');
	
	//if above start date doesn't give proper results, try changing it to $startstring and uncommenting line below
	$startdate = (date('Y-m-d', strtotime($startstring)));
	$d1 = new DateTime($startdate);
	$d2 = new DateTime($currentdate);
	
	$probation = new DateTime($startdate);
	$probation->add(new DateInterval('P30D'));
	
	$ptoIncrease = new DateTime($startdate);
	$ptoIncrease->add(new DateInterval('P109M'));

	//list($syear,$smonth,$sday) = split("-",$startstring);
	list($cyear,$cmonth,$cday) = split("-",$currentdate);
	$cmonth = $cmonth * 1;
	
	####################
	if ($d2 > $ptoIncrease) { 
		$addPTO = 6.67; //PTO hours earned per pay period
		$maxRO = 160; //maximum PTO hours that roll over 
		$maxPTO = 160; //maximum annual PTO accrual
	} else { 
		$addPTO = 5; //PTO hours earned per pay period
		$maxRO = 160; //maximum PTO hours that roll over 
		$maxPTO = 160; //maximum annual PTO accrual
	}
	console_log($addPTO);
	console_log($maxRO);
	console_log($maxPTO);

	
	//need to somehow incorportate start date into the pto calculations
	//i guess would it be that date if it's less than the rollover date?
	
	if($d2 < $probation){ echo "You have not completed the probationary period."; break; }
	$calyearDate = "$cyear-1-1";
	$ptoSDate = date('Y-m-d', strtotime($calyearDate));
	if($startdate > $ptoSDate) {$ptoSDate = $startdate;}
	$ptoEDate = $currentdate;
	$validPTO = new OutboardPayroll($ptoSDate,$ptoEDate);
	$periodCount = $validPTO->_setNumPeriods();
	$annualaccrual = $row['annual_accrual'];
	if(maxPTO <= $maxPTO){
		$annualaccrual = $annualaccrual + ($periodCount * $addPTO);
	} else { $annualaccrual = $maxPTO; }
	$addAA = "UPDATE outboard SET annual_accrual = ".$annualaccrual." WHERE userid like '".$userselect."'";
	$AAresult = mysql_query($addAA) or die(mysql_error());
	
	###############ROLLOVER#####################
	if ($cmonth < 7) { //if current month is prior to July
		$ryear = $cyear - 1; 
		$rolloverSDate = "$ryear-1-1";
		$roSDate = date('Y-m-d', strtotime($rolloverSDate));
		if($startdate > $roSDate) {$roSDate = $startdate;}
		$rolloverEDate = "$ryear-12-31";
		$roEDate = date('Y-m-d', strtotime($rolloverEDate));
		$validPTO = new OutboardPayroll($roSDate,$roEDate);
		$periodCount = $validPTO->_setNumPeriods();
		
		$rolloverPTO = $row['rollover_pto'];
		$ptoTotalHours = $row['total_pto_hours'];
		if ($rolloverPTO <= $maxRO){ 
			$updateRO = "UPDATE outboard SET rollover_pto_hours = ".$rolloverPTO." WHERE userid like '".$userselect."'"; 
			$rolloverResult = mysql_query($updateRO) or die(mysql_error());

		} else { 
			$rolloverPTO = $maxRO;
			$updateRO = "UPDATE outboard SET rollover_pto_hours = ".$maxRO." WHERE userid like '".$userselect."'"; 
			$rolloverResult = mysql_query($updateRO) or die(mysql_error());

		}
		
	} elseif ($cmonth >= 7){ //if current month is past July
		$rolloverPTO = 0;
		$updateRO = "UPDATE outboard SET rollover_pto_hours = ".$maxRO." WHERE userid like '".$userselect."'"; 
		$rolloverResult = mysql_query($updateRO) or die(mysql_error());
	}
	########### PTO USED HOURS #########################
	$usedPTO = $rows['used_pto_hours'];
	
	
	########### PTO TOTAL HOURS ########################
	$ptoTotalHours = $annualaccrual + $rolloverPTO;
	$updateTotal = "UPDATE outboard SET total_pto_hours = ".$ptoTotalHours." WHERE userid like '".$userselect."'"; 
	$totalResult = mysql_query($updateTotal) or die(mysql_error());
	
	$ptoAvailableHours = $ptoTotalHours - $usedPTO;
	$addAvail = "UPDATE outboard SET pto_hours = ".$ptoAvailableHours." WHERE userid like '".$userselect."'"; 
	$availResult = mysql_query($updateAvail) or die(mysql_error());
	
}


?>