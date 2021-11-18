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
include "include/mail_requestpto.php";

// Get the session (if there is one)
$auth = new OutboardAuth();
$ob = new OutboardDatabase();
$session = $auth->getSessionCookie();
$username = $ob->getSession($session);

if (! $username) { exit; }

//--------- Protected Area --------

if ($ob->isHR()) { 
	$departmentFull = "HR";
	$department = "HR";
	$departmentemail = $ob->getConfig('hr');
} 
if ($ob->isAP()) {
	$departmentFull = "Accounts Payable";
	$department = "AP";
	$departmentemail = $ob->getConfig('ap');
} 
if ($ob->isA1()) { 
	$departmentFull = "Accouting Supervisor";
	$department = "ACCT1";
	$departmentemail = $ob->getConfig('a1');
} 
if ($ob->isA2()) { 
	$departmentFull = "Accounting Managers Supervisors";
	$department = "ACCT2";
	$departmentemail = $ob->getConfig('a2');
} 
if ($ob->isE1()) { 
	$departmentFull = "Engineering Supervisor";
	$department = "ENG1";
	$departmentemail = $ob->getConfig('e1');
} 
if ($ob->isE2()) { 
	$departmentFull = "Engineering Supervisor";
	$department = "ENG2";
	$departmentemail = $ob->getConfig('e2');
} 
if ($ob->isLand()) { 
	$departmentFull = "Land Supervisor";
	$department = "LAND";
	$departmentemail = $ob->getConfig('land');
} 
if ($ob->isLegal()) { 
	$departmentFull = "Legal Supervisor";
	$department = "LEGAL";
	$departmentemail = $ob->getConfig('legal');
} 
if ($ob->isGeo()) { 
	$departmentFull = "Geology Supervisor";
	$department = "GEO";
	$departmentemail = $ob->getConfig('geo');
} 
if ($ob->isADstaff()) { 
	$departmentFull = "Administrative Staff Supervisor";
	$department = "ADSTAFF";
	$departmentemail = $ob->getConfig('adstaff');
}

$tempUserHash = $ob->getFullNames();
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

$startchoice = $_REQUEST['startchoice'];
$endchoice = $_REQUEST['endchoice'];
$selecthours = $_GET['selecthours'];
$sst = $_GET['sst'];

list($scM,$scD,$scY) = split("/",$startchoice); //scM = start choice month, scD = start choice day, scY = start choice year
list($ecM,$ecD,$ecY) = split("/",$endchoice); //ecM = end choice month, ecD = end choice day, ecY = end choice year
list($stH,$stM,$stS) = split(":",$sst); //stH = start time hour, stM = start time minutes, stS = start time seconds
list($shH,$shM,$shS) = split(":",$selecthours); //shH = $selecthours hour, shM = $selecthours minutes, shS = $selecthours seconds
$etH = $stH + $shH; //etH = end time hour (for partial day database write out)
$etM = $stM + $shM; //etM = end time minutes
$etS = $stS + $shS; //etS = end time seconds

$iDTpd = date("Y-m-d H:i:s", mktime($stH,$stM,$stS,$scM,$scD,$scY)); //initial datetime partial day
$fDTpd = date("Y-m-d H:i:s", mktime($etH,$etM,$etS,$scM,$scD,$scY)); //final datetime partial day

$iDTfd = date("Y-m-d H:i:s", mktime(8,0,0,$scM,$scD,$scY)); //initial datetime full day
$fDTfd = date("Y-m-d H:i:s", mktime(17,0,0,$ecM,$ecD,$ecY)); //initial datetime full day

$DpdFC = date("Y-m-d", mktime($stH,$stM,$stS,$scM,$scD,$scY)); // date partial day for calendar

$iDfdFC = date("Y-m-d", mktime(8,0,0,$scM,$scD,$scY)); //initial date full day for calendar
$fDfdFC = date("Y-m-d", mktime(17,0,0,$ecM,$ecD,$ecY)); //final date full day for calendar
//echo $iDTpdFC;
//echo $selectstarttime;
$start = (date('Y-m-d', strtotime($startchoice)));
//$start = '2020-03-01';
$start .= ' ';
$start .= $selectstarttime;
$end = (date('Y-m-d',strtotime($endchoice)));


//to make this work for specific users, make a dropdown and pull its value to put into comment code below
$userselect = $_REQUEST['userselect']; 
// $userselect = 'matt';
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
	//$department = $row['options'];
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
	console_log($AAresult);
	###############TEMP PTO#####################
	//adding this section so that employees can request PTO that they will have on that date that they may not have currently

	$ptoAtStartDate = $start;
	$tempPTOHours = new OutboardPayroll($ptoSDate,$ptoAtStartDate);
	$tempperiodCount = $tempPTOHours->_setNumPeriods();
	$tempPTOAccrual = ($tempperiodCount * $addPTO);
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
	$usedPTO = $row['used_pto_hours'];

	########### PTO REQUESTED HOURS #########################
    $requestedPTO = $row['requested_pto'];
	
	########### PTO TOTAL HOURS ########################
	$ptoTotalHours = $annualaccrual + $rolloverPTO;
	$updateTotal = "UPDATE outboard SET total_pto_hours = ".$ptoTotalHours." WHERE userid like '".$userselect."'"; 
	$totalResult = mysql_query($updateTotal) or die(mysql_error());
	$ptoAvailableHours = $ptoTotalHours - $usedPTO;

	$updateAvail = "UPDATE outboard SET pto_hours = ".$ptoAvailableHours." WHERE userid like '".$userselect."'"; 
	$availResult = mysql_query($updateAvail) or die(mysql_error());

	$startDateForCal = (date('Y-m-d H:i:s', strtotime($startchoice)));
	$endDateForCal = (date('Y-m-d H:i:s',strtotime($endchoice)));
	
	$tempPTOTotalHours = $tempPTOAccrual + $rolloverPTO;
	$tempPTOAvailableHours = $tempPTOTotalHours - $usedPTO;
	//
	//if ($selecthours < 8){$timerequest = "PD";}
	if ($end == "1969-12-31"){$timerequest = "PD";}
	elseif ($selecthours > 8) {echo "You have selected too many hours for a single day. Please try again.";
							 break; }
	else {$timerequest = "FD"; }
	
	
	//calendar coding
	$options = "";
	
	switch($timerequest){
		case "PD":
			
			$options .= "<PD>"; 
			$temprequestPTO = $requestedPTO + $selecthours;
			$ptoAfterBalance = $ptoAvailableHours - $selecthours;
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
			elseif ($selecthours > $ptoAvailableHours){
				if ($selecthours > $tempPTOAvailableHours){
					echo "<h2>You do not have enough hours to request PTO for $startdate.</h2><br><br>";
					echo "<h3>Your current PTO balance is: $ptoAvailableHours hours.</h3><br><h3>You attempted to request $selectHours hours.</h3>";
					break;
				} else {
					$connect = new PDO('mysql:host=localhost;dbname=outboard', 'outuser', 'outpass');
					$title = "[PTO REQUEST] $fullname for $DpdFC";
					$start_time = $iDTpd;
					$end_time = $fDTpd;
					$requestedPTO = $selecthours;
					if ($stH == 8 && $stM == 0){
						$options .= "<IA>"; //IA = in at 
					} else {

						$options .= "<OA>"; //OA = out at 
					}
					$query = "
					 INSERT INTO pto_request 
					 (userid, start_time, end_time, requested_pto, name, title, options, department) 
					 VALUES (:userid, :start_time, :end_time, :requested_pto, :name, :title, :options, :department)
					 ";
					 $statement = $connect->prepare($query);
					 $statement->execute(
					  array(
					   ':userid'  => $userselect,
					   ':start_time'  => $start_time,
					   ':end_time' => $end_time,
					   ':requested_pto' => $requestedPTO,
					   ':name' => $fullname,
					   ':title' => $title,
					   ':options' => $options,
					   ':department' => $department
					  )
					 ) or die(mysql_error());
					$addtorequestPTO = $requestedPTO + $row['requested_pto'];
					$updateRequest = "UPDATE outboard SET requested_pto = ".$addtorequestPTO." WHERE userid like '".$userselect."'"; 
					$requestResult = mysql_query($updateRequest) or die(mysql_error());
					echo "<h3>Your request has been submitted!</h3><br><br>";
					echo "<h3>Starting PTO balance: $ptoAvailableHours</h3><br>";
					echo "<h3>PTO balance if request is approved: $ptoAfterBalance</h3><br>";
					//echo "$fullname, $DpdFC, $requestedPTO, $department, $departmentemail";
					sendMail($fullname,$DpdFC,$DpdFC,$requestedPTO,$departmentFull,$departmentemail);

					break;
				
				}
			} elseif ($temprequestPTO > $ptoAfterBalance){
				echo "<h2>You have too many outstanding PTO requests. Please get them approved before trying again.</h2>";
				echo "<h3>Your current PTO requests total $requestedPTO hours. 
				Your current request brings your requests to $temprequestPTO hours, 
				which is greater than your current balance of $ptoAvailableHours hours.</h3>";

				break;
			}
			else {
				$connect = new PDO('mysql:host=localhost;dbname=outboard', 'outuser', 'outpass');
				$title = "[PTO REQUEST] $fullname for $DpdFC";
				$start_time = $iDTpd;
				$end_time = $fDTpd;
				$requestedPTO = $selecthours;
				if ($stH == 8 && $stM == 0){
					$options .= "<IA>"; //IA = in at 
				} else {
					
					$options .= "<OA>"; //OA = out at 
				}
				$query = "
				 INSERT INTO pto_request 
				 (userid, start_time, end_time, requested_pto, name, title, options, department) 
				 VALUES (:userid, :start_time, :end_time, :requested_pto, :name, :title, :options, :department)
				 ";
				 $statement = $connect->prepare($query);
				 $statement->execute(
				  array(
				   ':userid'  => $userselect,
				   ':start_time'  => $start_time,
				   ':end_time' => $end_time,
				   ':requested_pto' => $requestedPTO,
				   ':name' => $fullname,
				   ':title' => $title,
				   ':options' => $options,
				   ':department' => $department
				  )
				 ) or die(mysql_error());
				$addtorequestPTO = $requestedPTO + $row['requested_pto'];
				$updateRequest = "UPDATE outboard SET requested_pto = ".$addtorequestPTO." WHERE userid like '".$userselect."'"; 
				$requestResult = mysql_query($updateRequest) or die(mysql_error());
				echo "<h3>Your request has been submitted!</h3><br><br>";
				echo "<h3>Starting PTO balance: $ptoAvailableHours</h3><br>";
				echo "<h3>PTO balance if request is approved: $ptoAfterBalance</h3><br>";
				//echo "$fullname, $DpdFC, $requestedPTO, $department, $departmentemail";
				sendMail($fullname,$DpdFC,$DpdFC,$requestedPTO,$departmentFull,$departmentemail);

				break;
				
				
				//send email to supervisor
				//send email to hr@spindletopoil.com
			}
		case "FD":
			$options .= "<FD>"; 
			$startDT = new DateTime($startDateForCal);
			$endDT = new DateTime($endDateForCal);
			$endDT->modify('+1 day'); // otherwise the  end date is excluded (bug?)
			$interval = $endDT->diff($startDT);
			$datesSelected = $interval->days;
			$period = new DatePeriod($startDT, new DateInterval('P1D'), $endDT); // create an iterateable period of date (P1D equates to 1 day)
			foreach($period as $dt) {
				$curr = $dt->format('D');
			
				// substract if Saturday or Sunday
				if ($curr == 'Sat' || $curr == 'Sun') {
					$datesSelected--;
				}
			}
			// $datesSelected = date_diff($startDT, $endDT);
			// $requestInterval = $datesSelected->d;
			$requestInterval = $datesSelected;
			$selecthours = 8;
			$enoughTime = $selecthours * ($requestInterval);
			$ptoAfterBalance = $ptoAvailableHours - $enoughTime;
			$temprequestPTO = $requestedPTO + $enoughTime;
			if ($start == "1969-12-31 00:00:00" || $end == "1969-12-31"){
				echo "<h1>Please enter a valid date.</h1>";
				break;
			}
			elseif ($start < $currentdate || $end < $currentdate){
				echo "<h1>Please enter a valid date.</h1>";
				break;
			}
			
		
			elseif($enoughTime > $ptoAvailableHours){
				if ($enoughTime > $tempPTOAvailableHours){
					echo "<h2>You do not have enough hours to request PTO for $iDfdFC to $fDfdFC.</h2><br><br>";
					echo "<h3>Your current PTO balance is: $ptoAvailableHours hours.</h3><br><h3>You attempted to request $enoughTime hours.</h3>";
					break;
				} else {
					$connect = new PDO('mysql:host=localhost;dbname=outboard', 'outuser', 'outpass');
					$title = "[PTO REQUEST] $fullname for $iDfdFC to $fDfdFC.";
					$start_time = $iDTfd;
					$end_time = $fDTfd;
					$requestedPTO = $enoughTime;
					$query = "
					INSERT INTO pto_request 
					(userid, start_time, end_time, requested_pto, name, title, options, department) 
					VALUES (:userid, :start_time, :end_time, :requested_pto, :name, :title, :options, :department)
					";
					 $statement = $connect->prepare($query);
					 $statement->execute(
					  array(
					   ':userid'  => $userselect,
					   ':start_time'  => $start_time,
					   ':end_time' => $end_time,
					   ':requested_pto' => $requestedPTO,
					   ':name' => $fullname,
					   ':title' => $title,
					   ':options' => $options,
					   ':department' => $department
					  )
					 ) or die(mysql_error());
					$addtorequestPTO = $requestedPTO + $row['requested_pto'];
					$updateRequest = "UPDATE outboard SET requested_pto = ".$addtorequestPTO." WHERE userid like '".$userselect."'"; 
					$requestResult = mysql_query($updateRequest) or die(mysql_error());
					echo "<h3>Your request has been submitted!</h3><br><br>";
					echo "<h3>Starting PTO balance: $ptoAvailableHours</h3><br>";
					echo "<h3>PTO balance if request is approved: $ptoAfterBalance</h3><br>";				
					sendMail($fullname,$iDfdFC,$fDfdFC,$requestedPTO,$departmentFull,$departmentemail);
					break;
				}
			} elseif ($temprequestPTO > $ptoAfterBalance){
				echo "<h2>You have too many outstanding PTO requests. Please get them approved before trying again.</h2>";
				echo "<h3>Your current PTO requests total $requestedPTO hours. 
				Your current request brings your requests to $temprequestPTO hours, 
				which is greater than your current balance of $ptoAfterBalance hours.</h3>";
				break;
			} 
			else {
				$connect = new PDO('mysql:host=localhost;dbname=outboard', 'outuser', 'outpass');
				$title = "[PTO REQUEST] $fullname for $iDfdFC to $fDfdFC.";
				$start_time = $iDTfd;
				$end_time = $fDTfd;
				$requestedPTO = $enoughTime;
				$query = "
				 INSERT INTO pto_request 
				 (userid, start_time, end_time, requested_pto, name, title, options, department) 
				 VALUES (:userid, :start_time, :end_time, :requested_pto, :name, :title, :options, :department)
				 ";
				 $statement = $connect->prepare($query);
				 $statement->execute(
				  array(
				   ':userid'  => $userselect,
				   ':start_time'  => $start_time,
				   ':end_time' => $end_time,
				   ':requested_pto' => $requestedPTO,
				   ':name' => $fullname,
				   ':title' => $title,
				   ':options' => $options,
				   ':department' => $department
				  )
				 ) or die(mysql_error());
				$addtorequestPTO = $requestedPTO + $row['requested_pto'];
				$updateRequest = "UPDATE outboard SET requested_pto = ".$addtorequestPTO." WHERE userid like '".$userselect."'"; 
				$requestResult = mysql_query($updateRequest) or die(mysql_error());
				echo "<h3>Your request has been submitted!</h3><br><br>";
				echo "<h3>Starting PTO balance: $ptoAvailableHours</h3><br>";
				echo "<h3>PTO balance if request is approved: $ptoAfterBalance</h3><br>";				
				sendMail($fullname,$iDfdFC,$fDfdFC,$requestedPTO,$departmentFull,$departmentemail);
				break;
			}


	// *deletetocomment/
		
	}
		
		
	// *deletetocomment/	
	
	// */
	//$display_string .= "<br />";
	//echo $display_string;

}


?>