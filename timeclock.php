<?php
// Timeclock Report
//
// 2005-02-17 richardf - converted and updated for OutBoard 2.0 
// 2001-03-16 Richard F. Feuerriegel (richardf@acesag.auburn.edu)

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

//if (! $username) { exit; }

//--------- Protected Area --------

$tempUserHash = $ob->getNames();
$userHash = Array();

// Show all users for Admins, and only a users's own name otherwise
if ($ob->isAdmin()) {
  $userHash = $tempUserHash;
} else {
  $userHash[$username] = $tempUserHash[$username];
}

$pay = new OutboardPayroll($ob->getConfig('periodstart'),$ob->getLogEndDate());
// error_log(print_r($ob->getConfig('periodstart'),true));
// error_log(print_r($ob->getLogEndDate(),true));
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
###### PTO TEST CODE #####
// $rolloverFullDate = mktime(0,0,0,date("Y")-1,7,1);
// $rolloverDate = date("Y-m-d",$rolloverFullDate);
// $ryear = 2019;
// $rolloverDate = "$ryear-7-1";
// $ptoVDate = date('Y-m-d', strtotime($rolloverDate));
// $rolloverOB = new OutboardPayroll($ptoVDate,$ob->getLogEndDate());

// $periodCount = $rolloverOB->_setNumPeriods();
// while ($row = $ob->getRow()) {
// 	//$sdate = date("Y-m-d",$row['start_date']);
// 	$sdate = date("Y-m-d","2008-12-01"); //TEST DATE ...didnt work
// 	//maybe try date diff?
// 	//conditional would be:
// 	//if date diff > 9 then add 6.67 hours to pto else add 5 hours to pto
// 	$nineYears = new DateTime(date("Y",$row['start_date'])+9,date("m",$row['start_date']),date("d",$row['start_date']));
// 	$ptoIncrease = date("Y-m-d",$nineYears);
// 	list($syear,$smonth,$sday) = split("-",$sdate);
// 	list($nyear,$nmonth,$nday) = split("-",$ptoIncrease);
// 	$syear = $syear * 1;
// 	$nyear = $nyear * 1;
// 	if ($syear >= $nyear){ 
// 	$ptoTotalHours = $periodCount * 6.67;
// 	} else { 
// 	$ptoTotalHours = $periodCount * 5;
// 	}
// }


?>
<HTML>
<HEAD>
<TITLE>Timeclock Report: <?php echo $ob->getConfig('board_title') ?></TITLE>

<?php  include 'dependencies.php' ?>
<SCRIPT Language="JavaScript1.2">
  function showData(form) {
    form.show_button_clicked.value = "1";
    form.submit();
  }

  function createTimesheet(form) {
    form.timesheet_button_clicked.value = "1";
    form.submit();
    form.timesheet_button_clicked.value = "0";
  }
</SCRIPT>

</HEAD>
<BODY style="background-color: #0e5092;">
<?php include 'include/header_extensions.php'; ?>
<div class="container-fluid">
  <div class="carded mt-5 mx-auto col-7">
    <div class="m-3 justify-content-center ">

		<h2 align="center">Timeclock Report: <?php echo $ob->getConfig('board_title') ?></h2>

		<FORM class="" NAME=timeclock METHOD=post ACTION="<?php echo $_SERVER['PHP_SELF'] ?>">
		
			<div class='container'>

			  <div class='row'>
				<div class='col'>
				  User: <?php 
				//$pNfH = pull_name_from_hash();
			   $pNfH = pull_down_from_hash("userid",getPostValue('userid'),$userHash); 
			   //echo pull_name_from_hash("userid",getPostValue('userid'),$userHash);
			   echo $pNfH;
				//echo tester();
				//$rv = "<option value ='All'>All</option>\n";
				$rv = "";
				//echo pull_name_from_hash("userid",getPostValue('userid'),$userHash)->$pNfH;
			?>&nbsp;
				</div>
				  <div class='col'>
					  <?php 
/*
					  echo "$periodCount"; 
					  echo "<br />";
					  echo "<br />";
					  echo "$ptoTotalHours"; 
					  echo "<br />";
					  echo "<br />";
					  var_dump($nineYears);
					  echo "<br />";
					  echo "<br />";
					  print_r($nineYears);
*/
					  ?>
				  </div>
				<div class='col'>
				  Pay period: <?php 
			  $periodHash = $pay->getPeriodNames();
			  error_log(print_r(pull_down_from_hash("payperiod",$payperiod,$periodHash),true));
			  echo pull_down_from_hash("payperiod",$payperiod,$periodHash);
			  ?>&nbsp;
				</div>
				<div class='col'>

				</div>
				<div class='col'>
				  <INPUT class="btn btn-primary"  TYPE=SUBMIT NAME="Show" Value="Show">
				</div>
			  </div> 

			   <div class='row'>
				<div class='col'>
				  <?php if ($show_data) {	?>
					Timeclock data from the OutBoard log for <b><?php 
				   echo "$fullname ($userid)";
	
				echo $ptoIncrease;
				echo"<br>";
				echo $sdate;
				
					//echo "$pay";
					//echo "$payperiod";
					//	echo pull_name_from_hash();
				   ?>
				</div>
				</div>

			  <div class='row'>
				<div class='col'>
					
					
					<INPUT class="btn btn-primary" TYPE=SUBMIT NAME="timesheet" Value="Create Timesheet"> (Takes a few seconds)
				</div>  
				<div class='row'>
				  <div class='col'><?php 
					    echo $timearray['summary'];
				    ?></div>
					<div class='col'><?php 
				    echo $timearray['details']; }
				    ?></div>
			  </div>  
			</div>
				   </div>
		
		</FORM>
		</div>
	</div>
</div>
</BODY>
<script src="/js/bottom_scripts.js?v1.0.0.1"></script>
</HTML>

