
<?php

/*// Timeclock Report
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

if (! $username) { exit; }

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

if (getPostValue('Show') || count($userHash) == 0) {
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
*/

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

if (! $username) { exit; }

//--------- Protected Area --------
/*
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
/*
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
*/
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
<div class="wrap-outboard100">

<!--Main OutBoard table header-->
<TABLE BORDER=0 WIDTH=100% ALIGN=CENTER>
<TR>
<TD CLASS=back>
<TABLE ID=outboard BORDER=0 WIDTH=95% ALIGN=CENTER>
<TR><TH></TH><TH></TH><TH colspan=10>Hours:</TH><TH></TH><TH>Business Hours: 8AM-5PM</TH></TR>

<?php

// Get the latest outboard information from the database
$ob->getData();

$rowcount = 0;
$zebra = 0;
//$username = urlencode($username);

while($row = $ob->getRow()) {


  $isChangeable = $ob->isChangeable($row['userid']);
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
  $query = "select userid from outboard order by name asc";
  $result = mysql_query($query);
  $row['userid']=mysql_fetch_array($result);
  //$row['userid'] = urlencode($row['userid']);
       //$query = "select userid from outboard";
     echo "<TR class=norm>";
      //echo "<TD WIDTH=20% $user_bg><A class=\"nobr\" name=\"".$query."\"</A></TD>";
      //echo "<TD WIDTH=20% $user_bg><A class=\"nobr\" name=\"".$query."\">".$totalHoursWorked."</A></TD>";
     echo "<TD WIDTH=20% $user_bg><A class=\"nobr\" name=\"".$row['userid']."\">".$fullname."</A></TD>";
     //echo "<TD WIDTH=20% $user_bg><A class=\"nobr\" name=\"".$row['userid']."</A></TD>";
     echo "<TD WIDTH=20% $user_bg><A class=\"nobr\" name=\"".$userHash['userid']."\">".$totalHoursWorked."</A></TD>";
     //echo "<TD VALIGN=TOP ALIGN=CENTER>".$totalHoursWorked;"</TD>";
     //echo "<TD VALIGN=TOP ALIGN=CENTER>".$totalHoursWorked;"</TD>";
     //$userid = getPostValue('userid'));
     //echo "<TD VALIGN=TOP ALIGN=CENTER>".$timearray['summary'];"</TD>";
     //echo "<TD VALIGN=TOP ALIGN=CENTER>".$timearray['details'];"</TD>";
     echo "<TD WIDTH=20% $user_bg><A class=\"nobr\" name=\"".$row['userid']."\">".$row['name']."</A></TD>";
     echo "<TD VALIGN=TOP ALIGN=CENTER>".$totalHoursWorked;"</TD>";
    echo "</TR>\n";
      $userid++;
      $rowcount++;
      $userHash++;
        //$row++;
        //$rowcount['userid']++;
} // end while

?>

</TABLE>

		</div>
	</div>
</div>
</BODY>
</HTML>
