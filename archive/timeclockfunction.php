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
Function timeAll(){
	while ($row = $ob->getRow()) { 
		pullAll("userid", getPostValue('userid'), $userHash); 
				//echo $timearray['summary'];
						
				
		list($paystart,$payend) = explode("|",$payperiod);
		$log = $ob->getLogDataArray($userid,$paystart,$payend);
		$tc = new OutboardTimeclock($log,$userid,$paystart,$payend);
		if (getPostValue('timesheet')) { $tc->setPDF(true); }
		$tc->calculate();
		$totalHoursWorked = $tc->getTotalHoursWorked();
		//$timearray['details'] = $tc->getDetails();
		//$timearray['summary'] = $tc->getsummary();
		$rowcount++;
		}
	return $totalHoursWorked;
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
	<!--link rel="stylesheet" type="text/css" href="css/bootstrap-datepicker.css"-->
<!--===============================================================================================-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css"/>


<SCRIPT Language="JavaScript1.2">
  $("#startdate").datepicker('update'){
	  autoclose:true
  };
  $("#enddate").datepicker('update'){
  	  autoclose: true
  };
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
				<!--
					  <label for="start">Pay Period Start Date:</label>
					  <input type="text" id="payp" name="start"><br><br>
					  <label for="end">Pay Period End Date:</label>
					  <input type="text" id="payp" name="end"><br><br>
					  <input type="submit" value="Submit">
				-->
				<!--
				<div class="input-group date" data-provide="datepicker">
					<input name="startdate" id="startdate" type="text" class="form-control" action="<?php $start ?>">
					<div class="input-group-addon">
						<span class="glyphicon glyphicon-th"></span>
					</div>
				</div>
				<div class="input-group date" data-provide="datepicker">
					<input name="enddate" id="enddate" type="text" class="form-control" action="<?php $end ?>">
					<div class="input-group-addon">
						<span class="glyphicon glyphicon-th"></span>
					</div>
				</div>
				-->
				<div class="btn-group btn-group-toggle" data-toggle="buttons">
				  <label class="btn btn-primary active">
					<input type="radio" name="hsd" id="option1" value="1" autocomplete="off" checked> Total Hours
				  </label>
				  <label class="btn btn-primary">
					<input type="radio" name="hsd" id="option2" value="2" autocomplete="off"> Summary
				  </label>
				  <label class="btn btn-primary">
					<input type="radio" name="hsd" id="option3" value="3" autocomplete="off"> Details
				  </label>
				</div>
				<?php /*
					// Make a MySQL Connection
					$startchoice = $_POST['startdate'];
					$endchoice = $_POST['enddate'];
					
					$start = (date('Y-m-d',$startchoice));
					echo $start;
					//$start = '2020-03-01';
					$start .= '00:00:00';
					$end = (date('Y-m-d',$endchoice));
					//$end = '2020-03-15';
					
					*/
					list($start,$end) = explode("|",$payperiod);
					?>
					
				<TR>Pay period: <?php /*echo $start; ?> to <?php $end; */?>
					<?php 
						
						
			  			$periodHash = $pay->getPeriodNames();
			  			echo pull_down_from_hash("payperiod",$payperiod,$periodHash);
						
			  		?>&nbsp;
					<br />
				

				
					
					<!--TR>
						<input type="radio" id="hours" name="hsd" value="1" checked="checked">
						<label for="hours">Total Hours</label><br>
					
						<input type="radio" id="summary" name="hsd" value="2">
  						<label for="summary">Summary</label><br>
					
						<input type="radio" id="details" name="hsd" value="3">
						<label for="details">Details</label><br>
					</TR-->
				</TR>
				<TR><INPUT class="login100-form-btn"  TYPE=SUBMIT NAME="Show" Value="Show"></TR>
				
				</TR>
				<?php
				if ($show_data) {
					/*
					$startchoice = $_POST['startdate'];
					$endchoice = $_POST['enddate'];
					
					$start = (date('Y-m-d',$startchoice));
					echo $start;
					//$start = '2020-03-01';
					$start .= '00:00:00';
					$end = (date('Y-m-d',$endchoice));
					*/
					$query = "SELECT userid FROM outboard"; 
	 
					$result = mysql_query($query) or die(mysql_error());


					while($row = mysql_fetch_array($result)){
						$userid = $row['userid'];
						$fullname = $userHash[$userid];
						//getLogData($userid, $start, $end);
						$log = $ob->getLogDataArray($userid, $start, $end);
						$tc = new OutboardTimeclock($log,$userid,$start,$end);
						$tc->calculate();
						$totalHoursWorked = $tc->getTotalHoursWorked();
						$timearray['details'] = $tc->getDetails();
						$timearray['summary'] = $tc->getsummary();
						$reportchoice = $_POST['hsd'];
						switch($reportchoice){
							case "1":
								//echo $fullname. " - ". $totalHoursWorked;
								echo "<TR WIDTH=50%>".$fullname."</TR>";
								echo "<TR WIDTH=50%>&nbsp;</TR>";
								echo "<TR WIDTH=50%>".$totalHoursWorked."</TR>";
								break;
							case "2":
								//echo $fullname. " - ". $timearray['summary'];
								echo "<br />";
								echo "<br />";
								echo "<TR WIDTH=50%>".$fullname."</TR>";
								echo "<TR WIDTH=50%>".$timearray['summary']."</TR>";
								break;
							case "3":
								//echo $fullname. " - ". $timearray['details'];
								echo "<br />";
								echo "<TR WIDTH=50%>".$fullname."</TR>";
								echo "<TR WIDTH=50%>".$timearray['details']."</TR>";
								break;
							default: 
								//echo $fullname. " - ". $totalHoursWorked;
								echo "<TR WIDTH=50%>".$fullname."</TR>";
								echo "<TR WIDTH=50%>".$totalHoursWorked."</TR>";
						}
						
						echo "<br />";
					}
				}
				?>
				
			<!--TD-->User: <?php /* 
				//$pNfH = pull_name_from_hash();
			   $pNfH = pull_name_from_hash("userid",getPostValue('userid'),$userHash); 
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
			</TR>

			<?php if ($show_data) {
					//if (strcmp($pNfH,$rv) !== 1) {
					if ($pNfH !== tester()) {
					
						echo "$fullname ($userid)";
						echo $timearray['summary'];
						$rowcount++;
					
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
			
			<?php } }*/?>
		
			</TABLE>

		</FORM>
		</div>
	</div>
</div>
</BODY>
</HTML>

