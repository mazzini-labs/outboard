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
require_once("lib/OutboardPayroll.php");
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

$pay = new OutboardPayroll($ob->getConfig('periodstart'),$ob->getLogEndDate());

// If we don't have a userid yet, use the username
if (! $userid = getPostValue('userid')) { $userid = $username; }

// Don't let non-admins use anyone else's userids.
if (! $ob->isAdmin()) { $userid = $username; }

if (isset($userHash[$userid])) {
  $fullname = $userHash[$userid];
} else {
  $fullname = "";
}

if (! $payperiod = getPostValue('payperiod')) {
  $payperiod = $pay->getCurrentPeriod();
}

list($paystart,$payend) = explode("|",$payperiod);
$log = $ob->getLogDataArray($userid,$paystart,$payend);
$tc = new OutboardTimeclock($log,$userid,$paystart,$payend);
if (getPostValue('timesheet')) { $tc->setPDF(true); }
$tc->calculate();
$totalHoursWorked = $tc->getTotalHoursWorked();
$timearray['details'] = $tc->getDetails();
$timearray['summary'] = $tc->getsummary();

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


$startdate = $row['start_date'];
//if above start date doesn't give proper results, try changing it to $startstring and uncommenting line below
//$startdate = (date('Y-m-d', strtotime($startstring)));
$currentdate = date('Y-m-d');
$datediff = date_diff($startdate,$currentdate);

if($datediff > 30){
	if ($currentdate - $startdate > 3318) { //3318 days is approximately 109 months
		//TODO for loop for calculating semi-monthly pay periods since 6/30/19
		$row['total_pto_hours'] = $row['total_pto_hours'] + 6.67;
	} else {
		$row['total_pto_hours'] = $row['total_pto_hours'] + 5;
	}
} else {
	echo "You have not reached the required number of days to request PTO.";
	
}



############# REQUESTING PTO ###############################
$startchoice = $_GET['startchoice'];
$endchoice = $_GET['endchoice'];
//$reportchoice = $_GET['reportchoice'];
$start = (date('Y-m-d', strtotime($startchoice)));
//$start = '2020-03-01';
$start .= ' 00:00:00';
$end = (date('Y-m-d',strtotime($endchoice)));
$datesSelected = date_diff($start, $end);
$query = "SELECT userid FROM outboard"; 

$result = mysql_query($query) or die(mysql_error());

//while($row = mysql_fetch_array($result)){
	//$userid = $row['userid'];
	//$userid = $_GET['userid'];
	
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
	// /*
	if ($start == "1969-12-31 00:00:00" || $end == "1969-12-31"){
		echo "<h1>Please enter a valid date range</h1>";
		break;
	}
	elseif ($reportchoice == "undefined"){
		echo "<h1>Please select one of the options above.</h1>";
		break;
	}
	else{
	// */
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
		
		
	// */	
	}
	// */
	$display_string .= "<br />";
	echo $display_string;
//}

//Uncomment to debug (if values aren't correct or radio buttons aren't working)
/*
echo "<br />";
var_dump($userid);
echo "<br />";
print_r($userid);
echo "<br />";
echo $userid;
echo "<br />";


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