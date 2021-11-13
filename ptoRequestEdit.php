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

//not sure i need this?
//$pay = new OutboardPayroll($ob->getConfig('periodstart'),$ob->getLogEndDate());

// If we don't have a userid yet, use the username
if (! $userid = getPostValue('userid')) { $userid = $username; }

// Don't let non-admins use anyone else's userids.
if (! $ob->isAdmin()) { $userid = $username; }

if (isset($userHash[$userid])) {
  $fullname = $userHash[$userid];
} else {
  $fullname = "";
}
/*

if (! $payperiod = getPostValue('payperiod')) {
  $payperiod = $pay->getCurrentPeriod();
}
*/

/*list($paystart,$payend) = explode("|",$payperiod);
$log = $ob->getLogDataArray($userid,$paystart,$payend);
$tc = new OutboardTimeclock($log,$userid,$paystart,$payend);
if (getPostValue('timesheet')) { $tc->setPDF(true); }
$tc->calculate();
$totalHoursWorked = $tc->getTotalHoursWorked();
$timearray['details'] = $tc->getDetails();
$timearray['summary'] = $tc->getsummary();*/

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
############# REQUESTING PTO ###############################/*
///*
//while ($row = $ob->getRow()) {
//	//$sdate = date("Y-m-d",$row['start_date']);
//	$sdate = date("Y-m-d","2008-12-01"); //TEST DATE ...didnt work
//	//maybe try date diff?
//	//conditional would be:
//	//if date diff > 9 then add 6.67 hours to pto else add 5 hours to pto
//	$nineYears = new DateTime(date("Y",$row['start_date'])+9,date("m",$row['start_date']),date("d",$row['start_date']));
//	$ptoIncrease = date("Y-m-d",$nineYears);
//	list($syear,$smonth,$sday) = split("-",$sdate);
//	list($nyear,$nmonth,$nday) = split("-",$ptoIncrease);
//	$syear = $syear * 1;
//	$nyear = $nyear * 1;
//	if ($syear >= $nyear){ 
//	$ptoTotalHours = $periodCount * 6.67;
//	} else { 
//	$ptoTotalHours = $periodCount * 5;
//	}
//}*/

############# REQUESTING PTO ###############################


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
//$query = "SELECT * FROM outboard WHERE 'userid' like $userselect"; 
//$query = "SELECT * FROM outboard WHERE 'userid' like %matt%"; //testing
$query = "select * from `outboard` where `userid` like '%dchivvis%' limit 0,25";
//$query = "SELECT * FROM outboard"; //select all users

$result = mysql_query($query) or die(mysql_error());

while($row = mysql_fetch_array($result)){ 
	
	$userid = $row['userid'];
	//$userid = $_GET['userid'];
	
	########from attendance code, do i need?
	/*
	$fullname = $userHash[$userid];
	//getLogData($userid, $start, $end);
	$log = $ob->getLogDataArray($userid, $start, $end);
	$tc = new OutboardTimeclock($log,$userid,$start,$end);
	$tc->calculate();
	$totalHoursWorked = $tc->getTotalHoursWorked();
	$timearray['details'] = $tc->getDetails();
	$timearray['summary'] = $tc->getsummary();
	
	//$reportchoice = $_POST['hsd'];
	$reportchoice = $_GET['reportchoice'];
	*/
	########from attendance code, do i need?
	// /*
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

	if ($cmonth < 7) { 
		$ryear = $cyear;// - 1; 
		//$rolloverDate = new DateTime();
		//$rolloverDate->setDate($ryear, 7, 1);
		//$rolloverDate->format('Y-m-d');
		$rolloverDate = "$ryear-1-1";
		$ptoVDate = date('Y-m-d', strtotime($rolloverDate));
		
		//$ptoVDate = date('Y-m-d', strtotime('$ryear-7-1'));
		$validPTO = new OutboardPayroll($ptoVDate,$ob->getLogEndDate());
	} elseif ($cmonth >= 7){ 
		$calyearDate = "$cyear-1-1";
		$ptoVDate = (date('Y-m-d', strtotime($calyearDate)));
		$validPTO = new OutboardPayroll($ptoVDate,$ob->getLogEndDate());
	}
			$periodCount = $validPTO->_setNumPeriods();

//	echo $ptoVDate;
//	echo $ob->getLogEndDate();
	//rollover PTO time cutoff
	
		//mktime(0,0,0,date("Y")-1,07,01);
	//$rolloverDate = new DateTime($rolloverFullDate);
	
	//$datediff = date_diff($startdate,$currentdate); //not working correctly both startdate and currentdate passing as strings instead of datetime objects
	//$datediff = date_diff($d2,$d1);
	//$datediff = $d1->diff($d2);
	//echo $datediff->format('%a days');
	###################Roll Over Hours Calculation#####################
	$rolloverDate = "$ryear-1-1";
	$calyearDate = "$cyear-1-1";
	$roDate = date('Y-m-d', strtotime($rolloverDate));
	$caDate = (date('Y-m-d', strtotime($calyearDate)));
	
	if (strcmp($roDate, $caDate) == 0){
		
		
	}
	###################Roll Over Hours Calculation#####################

	
	$ptoTotalHours = $row['total_pto_hours'];
	
	if($d2 > $probation){
		if ($d2 > $ptoIncrease) { //3318 days is approximately 109 months
			//TODO for loop for calculating semi-monthly pay periods since 6/30/19
			echo "9 years of service TEST";
			//$row['total_pto_hours'] = $row['total_pto_hours'] + 6.67;
			$ptoTotalHours = $ptoTotalHours + ($periodCount * 6.67);
		} else {
			echo "Under 9 years of service TEST";
			$ptoTotalHours = $ptoTotalHours + ($periodCount * 5);
			//$row['total_pto_hours'] = $row['total_pto_hours'] + 5;
		}
	} else {
		echo "You have not reached the required number of days to request PTO.";
	}
	
	//
	/*
	//calendar coding
	if ($start == "1969-12-31 00:00:00" || $end == "1969-12-31"){
		echo "<h1>Please enter a valid date range</h1>";
		break;
	}
	elseif ($reportchoice == "undefined"){
		echo "<h1>Please select one of the options above.</h1>";
		break;
	}
	else{
	// *deletetocomment/
		switch($reportchoice){
			case "1": //partial day pto
				//echo $fullname. " - ". $totalHoursWorked;
				$ptoHours = $_GET['selectedTime'];
				break;
			case "2": //full day pto
				//echo $fullname. " - ". $timearray['summary'];
				$display_string = "<br />";
				$display_string .= "<br />";
				$display_string .= "<TR WIDTH=50%>".$fullname."</TR>";
				$display_string .= "<TR WIDTH=50%>".$timearray['summary']."</TR>";
				break;
			default: 
				//echo $fullname. " - ". $totalHoursWorked;
				//echo "Please select one of the options above.";
				break;
		}
		
		
	// *deletetocomment/	
	}
	// */
	//$display_string .= "<br />";
	//echo $display_string;
}

//Uncomment to debug (if values aren't correct or radio buttons aren't working)
///*
echo "<br />";
echo "<br />";


/*
echo "<br />";
echo "\$rolloverDate: ";
var_dump($rolloverDate);
echo "<br />";
print_r($rolloverDate);
echo "<br />";
echo $rolloverDate;
echo "<br />";

echo "<br />";
echo "\$rolloverFullDate: ";
var_dump($rolloverFullDate);
echo "<br />";
print_r($rolloverFullDate);
echo "<br />";
echo $rolloverDate;
echo "<br />";

echo "<br />";
echo "\$startdate: ";
var_dump($startdate);
echo "<br />";
print_r($startdate);
echo "<br />";
echo $startdate;
echo "<br />";

echo "<br />";
echo "\$currentdate: ";
var_dump($currentdate);
echo "<br />";
print_r($currentdate);
echo "<br />";
echo $currentdate;
echo "<br />";

echo "<br />";
echo "\$datediff: ";
var_dump($datediff);
echo "<br />";
print_r($datediff);
echo "<br />";
echo $datediff;
echo "<br />";
*/
echo "<br />";
echo "\$periodCount: ";
var_dump($periodCount);
echo "<br />";
print_r($periodCount);
echo "<br />";
echo $periodCount;
echo "<br />";

echo "<br />";
echo "\$ptoTotalHours: ";
var_dump($ptoTotalHours);
echo "<br />";
print_r($ptoTotalHours);
echo "<br />";
echo $ptoTotalHours;
echo "<br />";

echo "<br />";
echo "\$ptoVDate: ";
var_dump($ptoVDate);
echo "<br />";
print_r($ptoVDate);
echo "<br />";
echo $ptoVDate;
echo "<br />";

echo "<br />";
echo "\$validPTO: ";
var_dump($validPTO);
echo "<br />";
print_r($validPTO);
echo "<br />";
echo $validPTO;
echo "<br />";

/*
echo $start;
echo "<br />";
echo $startchoice;
echo "<br />";
echo $end;
echo "<br />";
echo $endchoice;
echo "<br />";
echo $reportchoice;
echo "<br />";
//*/

?>