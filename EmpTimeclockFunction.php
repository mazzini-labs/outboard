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

$tempUserHash = $ob->getFullNames();
$userHash = Array();

// Show all users for Admins, and only a users's own name otherwise
if ($ob->isAdmin()) {
  $userHash = $tempUserHash;
} else {
  $userHash[$username] = $tempUserHash[$username];
}

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
if (getPostValue('Show') || count($userHash) == 1) {
  $show_data = true;
} else {
  $show_data = false;
}

if (getPostValue('timesheet')) {
//   $fullname = get_fullname($userid);
  $fullname = $userHash[$userid];
  echo $fullname;
  include_once("include/timesheet.php");
  exit;
}

#########################
$startchoice = $_GET['startchoice'];
$endchoice = $_GET['endchoice'];
//$reportchoice = $_GET['reportchoice'];
$start = (date('Y-m-d', strtotime($startchoice)));
//$start = '2020-03-01';
$start .= ' 00:00:00';
$end = (date('Y-m-d',strtotime($endchoice)));

$currentDateArrayS = explode("/", $startchoice);
$currentDateArrayE = explode("/", $endchoice);
$endMonth = $currentDateArrayE[0];
if ($endMonth == '04' || $endMonth == '06' || $endMonth == '09' || $endMonth == '11') { $endDay = "-30-"; }
elseif ($endMonth == '02') { $endDay = "-28-"; }
else { $endDay = "-31-"; }
($currentDateArrayS[1] < 15)? $paystart = $currentDateArrayS[0] . "-1-" . $currentDateArrayS[2] : $paystart = $currentDateArrayS[0] . "-15-" . $currentDateArrayS[2];
($currentDateArrayE[1] < 15)? $payend = $currentDateArrayE[0] . "-15-" . $currentDateArrayE[2] : $payend = $currentDateArrayE[0] . $endDay . $currentDateArrayE[2];

$result = $ob->test();

//while($row = mysql_fetch_array($result)){
	//$userid = $row['userid'];
	//$userid = $_GET['userid'];
	
	$fullname = $userHash[$userid];
	// $fullname = get_fullname($userid);
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
		//break;
	}
	elseif ($reportchoice == "undefined"){
		echo "<h1>Please select one of the options above.</h1>";
		//break;
	}
	elseif ($reportchoice == "timesheet"){
		include_once("include/timesheet.php");
		exit;
	}
	else{
	// */
		switch($reportchoice){
			case "1":
				//echo $fullname. " - ". $totalHoursWorked;
				$display_string = "<br />";
				$display_string = "<br />";
				$display_string .= "<div class='container'>\n";
				$display_string .= "<div class='row'>\n";
				$display_string .= "<div class='col'>".$fullname."</div>";

				$display_string .= "<div class='col'>".$totalHoursWorked." Hours</div>";
				$display_string .= "</div>";
				$display_string .= "</div>";
				break;
			case "2":
				//echo $fullname. " - ". $timearray['summary'];
				$display_string = "<br />";
				$display_string .= "<br />";
				$display_string .= "<TR>".$fullname."</TR>";
				$display_string .= "<TR>".$timearray['summary']."</TR>";
				break;
			case "3":
				//echo $fullname. " - ". $timearray['details'];
				$display_string = "<br />";
				$display_string .= "<br />";
				$display_string .= "<TR>".$fullname."</TR>";
				$display_string .= "<TR >".$timearray['details']."</TR>";
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