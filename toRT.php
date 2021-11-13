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
require_once("lib/obPtest.php");
require_once("lib/OutboardDatabase.php");

include_once("include/common.php");
include_once("include/html_helper.php");
include_once("include/html_helper_test.php");
include_once("include/fullname.php");
include_once("include/wsbFunctions.php");
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



$startchoice = $_GET['startchoice'];
$endchoice = $_GET['endchoice'];
$selecthours = $_GET['selecthours'];
$start = (date('Y-m-d', strtotime($startchoice)));
//$start = '2020-03-01';
$start .= ' 00:00:00';
$end = (date('Y-m-d',strtotime($endchoice)));


//to make this work for specific users, make a dropdown and pull its value to put into comment code below
//$userselect = $_GET['userselect'];
$userselect = 'matt';
//$query = "SELECT * FROM outboard WHERE 'userid' like '%$userselect%'"; 
$query = "select * from outboard where userid = '".$userselect."'";
//$query = "select * from `outboard` where `userid` like '%$userselect%' limit 0,25";
//$query = "select * from outboard where userid = '$userselect'";
//console_log($query);
$result = mysql_query($query) or die(mysql_error());

while($row = mysql_fetch_array($result)){ 
	$userid = $row['userid'];
	//$userid = $_GET['userid'];
	$fullname = $userHash[$userid];
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
		$maxRO = 120; //maximum PTO hours that roll over 
		$maxPTO = 120; //maximum annual PTO accrual
	}
	
	//need to somehow incorportate start date into the pto calculations
	//i guess would it be that date if it's less than the rollover date?
	
	if($d2 < $probation){ echo "You have not completed the probationary period."; break; }
	$calyearDate = "$cyear-1-1";
	$ptoSDate = date('Y-m-d', strtotime($calyearDate));
	if($startdate > $ptoSDate) {$ptoSDate = $startdate;}
	$ptoEDate = $currentdate;
	$validPTO = new OutboardPayroll($ptoSDate,$ptoEDate);
	//$validPTO = new OutboardPayroll($ptoSDate, $ob->getLogEndDate());
	$periodCount = $validPTO->_setNumPeriods();
	$annualaccrual = $row['annual_accrual'];
	
	
	$annualaccrual = ($periodCount * $addPTO);
	if($annualaccrual > $maxPTO){ $annualaccrual = $maxPTO; }
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
		
		$rolloverPTO = $periodCount * $addPTO; 
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
	
	########### PTO REQUESTED HOURS #########################
    $requestedPTO = $row['requested_pto'];

	
	########### PTO TOTAL HOURS ########################
	$ptoTotalHours = $annualaccrual + $rolloverPTO;
	$updateTotal = "UPDATE outboard SET total_pto_hours = ".$ptoTotalHours." WHERE userid like '".$userselect."'"; 
	$totalResult = mysql_query($updateTotal) or die(mysql_error());
	$ptoAvailableHours = $ptoTotalHours - $usedPTO;
	$updateAvail = "UPDATE outboard SET pto_hours = ".$ptoAvailableHours." WHERE userid like '".$userselect."'"; 
	$availResult = mysql_query($updateAvail) or die(mysql_error());

	$startDateForCal = (date('Y-m-d', strtotime($startchoice)));
	$endDateForCal = (date('Y-m-d',strtotime($endchoice)));
	
	//
	if ($end == "1969-12-31"){$timerequest = "PD";}
	else {$timerequest = "FD"; }
	
	//calendar coding

	
	switch($timerequest){
		case "PD":
			if ($start == "1969-12-31 00:00:00"){
				echo "<h1>Please enter a valid date.</h1>";
				break;
			}
			elseif ($start < $currentdate){
				echo "<h1>Please enter a valid date.</h1>";
				break;
			}
			elseif (! is_numeric($selecthours)){
				echo "<h1>Please enter a valid number.</h1>";
				break;
			}
			if ($selecthours > $ptoAvailableHours){
				echo "You do not have enough hours to request PTO for $startDateForCal.";
			} elseif ($requestedPTO > $ptoAvailableHours){
				echo "You have too many outstanding PTO requests. Please get them approved before trying again.";
			}
			else {
				$connect = new PDO('mysql:host=localhost;dbname=outboard', 'outuser', 'outpass');
				$title = "[PTO REQUEST] $fullname for $startDateForCal";
				$start_event = $startDateForCal;
				$end_event = $endDateForCal;
				$query = "
				 INSERT INTO events 
				 (title, start_event, end_event) 
				 VALUES (:title, :start_event, :end_event)
				 ";
				 $statement = $connect->prepare($query);
				 $statement->execute(
				  array(
				   ':title'  => $title,
				   ':start_event' => $start_event,
				   ':end_event' => $end_event
				  )
				 );
				$requestedPTO = $selecthours;
				$updateRequest = "UPDATE outboard SET requested_pto = ".$requestedPTO." WHERE userid like '".$userselect."'"; 
				$requestResult = mysql_query($updateRequest) or die(mysql_error());
				echo "Your request has been submitted!";
				//send email to supervisor
				//send email to hr@spindletopoil.com
			}
		case "FD":
			if ($start == "1969-12-31 00:00:00" || $end == "1969-12-31"){
				echo "<h1>Please enter a valid date.</h1>";
				break;
			}
			elseif ($start < $currentdate || $end < $currentdate){
				echo "<h1>Please enter a valid date.</h1>";
				break;
			}
			$startDT = new DateTime($startDateForCal);
			$endDT = new DateTime($endDateForCal);
			$datesSelected = date_diff($startDT, $endDT);
			$requestInterval = $datesSelected->d;
			$selecthours = 8;
			$enoughTime = $selecthours * $requestInterval;
			if($enoughTime > $ptoAvailableHours){
				echo "You do not have enough hours to request PTO for $startDateForCal to $endDateForCal.";
			} elseif ($requestedPTO > $ptoAvailableHours){
				echo "You have too many outstanding PTO requests. Please get them approved before trying again.";
			} 
			else {
				$connect = new PDO('mysql:host=localhost;dbname=outboard', 'outuser', 'outpass');
				$title = "[PTO REQUEST] $fullname from $startDateForCal to $endDateForCal";
				$start_event = $startDateForCal;
				$end_event = $endDateForCal;
				$query = "
				 INSERT INTO events 
				 (title, start_event, end_event) 
				 VALUES (:title, :start_event, :end_event)
				 ";
				 $statement = $connect->prepare($query);
				 $statement->execute(
				  array(
				   ':title'  => $title,
				   ':start_event' => $start_event,
				   ':end_event' => $end_event
				  )
				 );
				$requestedPTO = $enoughTime;
				$updateRequest = "UPDATE outboard SET requested_pto = ".$requestedPTO." WHERE userid like '".$userselect."'"; 
				$requestResult = mysql_query($updateRequest) or die(mysql_error());
				echo "Your request has been submitted!";
			}


	// *deletetocomment/
		
	}
		
		
	// *deletetocomment/	
	
	// */
	//$display_string .= "<br />";
	//echo $display_string;

}


?>