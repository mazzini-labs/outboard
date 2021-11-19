<?php

// require_once("/lib/OutboardAuth.php");
// require_once("/lib/OutboardTimeclock.php");
// require_once("/lib/obP.php");
// require_once("/lib/OutboardDatabase.php");

// include_once("/include/common.php");
// include_once("/include/html_helper.php");
// include_once("/include/html_helper_test.php");
// include_once("/include/fullname.php");

define("PROJECT_ROOT_PATH", __DIR__ . "/../");
// define("PROJECT_ROOT_PATH", $_SERVER['DOCUMENT_ROOT']);
// define("PROJECT_ROOT_PATH","https://" . $_SERVER["HTTP_HOST"]);
require_once PROJECT_ROOT_PATH . "/lib/OutboardAuth.php";
require_once PROJECT_ROOT_PATH . "/lib/OutboardTimeclock.php";
require_once PROJECT_ROOT_PATH . "/lib/obP.php";
require_once PROJECT_ROOT_PATH . "/lib/OutboardDatabase.php"; 
include_once PROJECT_ROOT_PATH . "/include/common.php";
include_once PROJECT_ROOT_PATH . "/include/html_helper.php";
include_once PROJECT_ROOT_PATH . "/include/html_helper_test.php";
include_once PROJECT_ROOT_PATH . "/include/fullname.php";

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
  $fullname = get_fullname($userid);
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

// $query = "SELECT userid FROM outboard"; 

// $result = mysql_query($query) or die(mysql_error());
$r = $ob->allUserSelect();
// $row = $ob->getData();
// $row = $ob->getRow();
$arr_length = $ob->countUsers();
// $arr_length = count($row);

// error_log(print_r($cu,true));
// error_log(print_r($row,true));
// echo $ob->getRow();
while($row=$r->fetch_assoc()){
// foreach($result as $row)
// 	{
// for($i=0;$i<$arr_length;$i++) { 
// 	$ob->userSelect();
// 	$row = $ob->getRow();
	$userid = $row['userid'];

	// $userid = $row[$i];
	// error_log(print_r($userid,true));
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
	///*
	if ($start == "1969-12-31 00:00:00" || $end == "1969-12-31"){
		echo "<h1>Please enter a valid date range</h1>";
		break;
	}
	elseif ($reportchoice == "undefined"){
		echo "<h1>Please select one of the options above.</h1>";
		break;
	}
	//*/
	else {
		switch($reportchoice){
			case "1":
				//echo $fullname. " - ". $totalHoursWorked;
				$display_string = "<div class='container'>\n";
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
				$display_string .= "<TR WIDTH=50%>".$fullname."</TR>";
				$display_string .= "<TR WIDTH=50%>".$timearray['summary']."</TR>";
				break;
			case "3":
				//echo $fullname. " - ". $timearray['details'];
				$display_string = "<br />";
				$display_string = "<br />";
				$display_string .= "<TR WIDTH=50%>".$fullname."</TR>";
				$display_string .= "<TR WIDTH=50%>".$timearray['details']."</TR>";
				break;
			default: 
				//echo $fullname. " - ". $totalHoursWorked;
				//echo "Please select one of the options above.";
				break;
		}
	///*	
		
		
	}
	//*/
	$display_string .= "<br />";
	echo $display_string;
}

//Uncomment to debug (if values aren't correct or radio buttons aren't working)
/*
echo "<br />";
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
*/
?>