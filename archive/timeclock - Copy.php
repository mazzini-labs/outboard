<?php
// Timeclock Report
//
// 2005-02-17 richardf - converted and updated for OutBoard 2.0 
// 2001-03-16 Richard F. Feuerriegel (richardf@acesag.auburn.edu)

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

?>
<HTML>
<HEAD>
<TITLE>Timeclock Report: <?php echo $ob->getConfig('board_title') ?></TITLE>

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
<!--===============================================================================================-->


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
<BODY>
<div class="limiter">
	<div class="container-outboard100">

		<div class="wrap-login100">

		<h2>Timeclock Report: <?php echo $ob->getConfig('board_title') ?></h2>

		<FORM class="" NAME=timeclock METHOD=post ACTION="<?php echo $_SERVER['PHP_SELF'] ?>">



			<TABLE BORDER=0>

			<TR>
			<TD>User: <?php 
				//$pNfH = pull_name_from_hash();
			   $pNfH = pull_down_from_hash("userid",getPostValue('userid'),$userHash); 
			   //echo pull_name_from_hash("userid",getPostValue('userid'),$userHash);
			   echo $pNfH;
				//echo tester();
				//$rv = "<option value ='All'>All</option>\n";
				$rv = "";
				//echo pull_name_from_hash("userid",getPostValue('userid'),$userHash)->$pNfH;
			?>&nbsp;</TD>

			<TD>Pay period: <?php 
			  $periodHash = $pay->getPeriodNames();
			  echo pull_down_from_hash("payperiod",$payperiod,$periodHash);
			  ?>&nbsp;</TD>

			<TD><INPUT class="login100-form-btn"  TYPE=SUBMIT NAME="Show" Value="Show"></TD>
			<TD><a class="login100-form-btn" href="timeclockfunction.php" target=_blank >All Employee Times</a>
			</TR>

			<?php if ($show_data) {
					//if (strcmp($pNfH,$rv) !== 1) {
					if ($pNfH !== tester()) {
					while ($row = $ob->getRow()) {
						echo "$fullname ($userid)";
						echo $timearray['summary'];
						$rowcount++;
					}
				?>
 			<TR><TD COLSPAN=3>&nbsp;</TD></TR>
 			<TR>
 				<TD COLSPAN=3 align=center>
				   Timeclock data from the OutBoard log for <b><?php 
				   echo "$fullname ($userid)";
					//	echo pull_name_from_hash();
				   ?></b>:
				 </TD>
 			</TR>
 
			<TR><TD COLSPAN=3>&nbsp;</TD></TR>
 			
			<TR>
 				<TD COLSPAN=3 ALIGN=CENTER VALIGN=CENTER>
    					<INPUT class="login200-form-btn" TYPE=SUBMIT NAME="timesheet" Value="Create Timesheet"> (Takes a few seconds)</TD>
				 </TD>
 			</TR>
 
			<TR>
				 <TD COLSPAN=3 ALIGN=CENTER>
				  <TABLE BORDER=0 WIDTH=100%>
				   <TR>
				    <TD VALIGN=TOP ALIGN=CENTER><?php 
					    echo $timearray['summary'];
				    ?></TD>
				    <TD VALIGN=TOP ALIGN=CENTER><?php 
				    echo $timearray['details'];
				    ?></TD>
			 	    </TR>
				  </TABLE>
				 </TD> 
			 </TR>

				<?php } else { ?>
						<TR>
						<TR><TD COLSPAN=3>&nbsp;</TD></TR>
						 <TD colspan=3 align=center>THE NESTED FOR LOOP WORKS!</TD>
						
					 	</TR>
				<?php	} }
			else { ?>
 
			<TR>
 				<TR><TD COLSPAN=3>&nbsp;</TD></TR>
				 <TD colspan=3 align=center>Select a user and payperiod above, then press Show.</TD>
			 </TR>
			
			<?php } ?>
		
			</TABLE>

		</FORM>
		</div>
	</div>
</div>
</BODY>
</HTML>

