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

		<div class="wrap-outboard100">

		<h2>Timeclock Report: <?php echo $ob->getConfig('board_title') ?></h2>

		<FORM class="" NAME=timeclock METHOD=post ACTION="<?php echo $_SERVER['PHP_SELF'] ?>">



			<TABLE BORDER=0>

			<TR>
			<TD>User: <?php 
			   echo pull_down_from_hash("userid",getPostValue('userid'),$userHash); 
				
			?>&nbsp;</TD>

			<TD>Pay period: <?php 
			  $periodHash = $pay->getPeriodNames();
			  echo pull_down_from_hash("payperiod",$payperiod,$periodHash);
			  ?>&nbsp;</TD>
			<td><INPUT class="login100-form-btn"  TYPE=SUBMIT NAME="Show" Value="Show"></td>
			<div><a href="timeclockall.php" target=_blank>All Employee Times</a>
			</TR>

			<?php if ($show_data) {
			?>
 			<TR><TD COLSPAN=3>&nbsp;</TD></TR>
 			<TR>
 				<TD COLSPAN=3 align=center>
				   Timeclock data from the OutBoard log for <b><?php 
				   echo "$fullname ($userid)";
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
				 <TD colspan=3 align=center>Select a user and payperiod above, then press Show.</TD>
			 </TR>
			
			<?php } ?>
		
			</TABLE>
		  <!--TABLE BORDER=0>

			<TR>
			<TD>User: <?php 
			   echo pull_down_from_hash("userid",getPostValue('userid'),$userHash) 
			?>&nbsp;</TD>

			<TD>Pay period: <?php 
			  $periodHash = $pay->getPeriodNames();
			  echo pull_down_from_hash("payperiod",$payperiod,$periodHash);
			  ?>&nbsp;</TD>

			<TD><INPUT class="login100-form-btn"  TYPE=SUBMIT NAME="Show" Value="Show"></TD>
			<TD><a href="timeclockall.php" target=_blank>All Employee Times</a>
			</TR>

			<?php if ($show_data) {
			?>
 			<TR><TD COLSPAN=3><div  width="50%" VALIGN=TOP ALIGN=CENTER> Timeclock data from the OutBoard log for <b>
 			  <?php 
				   echo "$fullname ($userid)";
				   ?>
 			  </b>: </div></TD></TR>
 			<TR>
 				<TD  align=center>&nbsp;</TD>
 			</TR>
 
			<TR><TD >&nbsp;</TD></TR>
 			
			<div>
 				<div  ALIGN=CENTER VALIGN=CENTER class="col-12">
    					<INPUT class="login200-form-btn" TYPE=SUBMIT NAME="timesheet" Value="Create Timesheet"> (Takes a few seconds)</TD>
				 </div>
 			</div>
 
			<TR>
				 <TD ALIGN=CENTER>
				  <td BORDER=0 WIDTH=100%>
				   <TR>
					   <TD>
				    <div  width="50%" VALIGN=TOP ALIGN=CENTER><?php 
					    echo $timearray['summary'];
				    ?></div>
					  </TD><TD>
				    <div  width="50%" VALIGN=TOP ALIGN=CENTER><?php 
				    echo $timearray['details'];
				    ?></div>
					   </TD>
			 	    </TR>
				  </td>
				 </TD> 
			 </TR>

			<?php } else { ?>
 
			<TR>
 				<TR><TD COLSPAN=3>&nbsp;</TD></TR>
				 <TD colspan=3 align=center>Select a user and payperiod above, then press Show.</TD>
			 </TR>
			
			<?php } ?>
		
			</TABLE-->

		</FORM>
		</div>
	</div>
</div>
</BODY>
</HTML>

