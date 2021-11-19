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

$tempUserHash = $ob->getEligible();
$userHash = Array();

// Show all users for Admins, and only a users's own name otherwise
if ($ob->isAdmin()) {
  $userHash = $tempUserHash;
} else {
  $userHash[$username] = $tempUserHash[$username];
}

// If we don't have a userid yet, use the username
if (! $userid = getPostValue('userid')) { $userid = $username; }

// Don't let non-admins use anyone else's userids.
if (! $ob->isAdmin()) { $userid = $username; }

if (isset($userHash[$userid])) {
  $fullname = $userHash[$userid];
} else {
  $fullname = "";
}

//if (! $payperiod = getPostValue('payperiod')) {
//  $payperiod = $pay->getCurrentPeriod();
//}
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

$rolloverFullDate = mktime(0,0,0,date("Y")-1,7,1);
$rolloverDate = date("Y-m-d",$rolloverFullDate);
$pay = new OutboardPayroll($rolloverDate,$ob->getLogEndDate());

$periodCount = $pay->_setNumPeriods();
while ($row = $ob->getRow()) {
	$sdate = date("Y-m-d",$row['start_date']);
	$ptoIncrease = date("Y-m-d", mkdate(0,0,0,date("Y",$row['start_date'])+9,date("m",$row['start_date']),date("d",$row['start_date'])));
	list($year,$month,$day) = split("-",$sdate);
	if ($yearsWorked > $ptoIncrease){ 
	$ptoTotalHours = $periodCount * 5;}
}

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
?>
<!doctype html>

<HTML>
<HEAD>
<TITLE>Approve PTO: <?php echo $ob->getConfig('board_title') ?></TITLE>
<?php include 'include/dependencies.php'; ?>


<SCRIPT>
  $("#startdate").datepicker();
  $("#enddate").datepicker();
  function showData(form) {
    form.show_button_clicked.value = "1";
    //form.submit();
	if (form.show_button_clicked.value == "1") {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("startdate").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("POST", "ptoRequest.php?start=" + str, true);
    xmlhttp.send();
    }
  }

  function createTimesheet(form) {
    form.timesheet_button_clicked.value = "1";
    form.submit();
    form.timesheet_button_clicked.value = "0";
  }  
</SCRIPT>
</HEAD>
<script language = "javascript" type = "text/javascript">
 function ajaxApprove(){
	   var ajaxRequest;  // The variable that makes Ajax possible!

	   try {
		  // Opera 8.0+, Firefox, Safari
		  ajaxRequest = new XMLHttpRequest();
	   }catch (e) {
		  // Internet Explorer Browsers
		  try {
			 ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		  }catch (e) {
			 try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			 }catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			 }
		  }
	   }

	   // Create a function that will receive data 
	   // sent from the server and will update
	   // div section in the same page.

	   ajaxRequest.onreadystatechange = function(){
		  if(ajaxRequest.readyState == 4){
			 var ajaxDisplay = document.getElementById('ajaxDiv');
			 ajaxDisplay.innerHTML = ajaxRequest.responseText;
		  }
	   }

	   // Now get the value from user and pass it to
	   // server script.

	   //var startchoice = document.getElementById('start').value;
	   //var endchoice = document.getElementById('end').value;
	   //var id = $("navbar-btn").val();
	   var id= document.getElementById('Approve').value;
	   //var id= document.getElementByName('id').value;
	   
		   //document.getElementByName('hsd').value;
	   var queryString = "?id=" + id ;

	   //queryString +=  "&endchoice=" + endchoice + "&reportchoice=" + reportchoice;// + "&userid=" + userid;
	 //switch (reportchoice) {
		 //case 1:
			 ajaxRequest.open("GET", "approveDeny.php", true);
			 ajaxRequest.send(null); 
		 //case 2:
			 //ajaxRequest.open("GET", "EmpTimeclockFunction.php", true);
			 //ajaxRequest.send(null); 
	 //}  

	}
 function ajaxDeny(){
	   var ajaxRequest;  // The variable that makes Ajax possible!

	   try {
		  // Opera 8.0+, Firefox, Safari
		  ajaxRequest = new XMLHttpRequest();
	   }catch (e) {
		  // Internet Explorer Browsers
		  try {
			 ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		  }catch (e) {
			 try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			 }catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			 }
		  }
	   }

	   // Create a function that will receive data 
	   // sent from the server and will update
	   // div section in the same page.

	   ajaxRequest.onreadystatechange = function(){
		  if(ajaxRequest.readyState == 4){
			 var ajaxDisplay = document.getElementById('ajaxDiv');
			 ajaxDisplay.innerHTML = ajaxRequest.responseText;
		  }
	   }

	   // Now get the value from user and pass it to
	   // server script.

	   //var startchoice = document.getElementById('start').value;
	   //var endchoice = document.getElementById('end').value;
	   var id = $("navbar-btn").val();
	   //var userid = document.getElementById('user').value;
	   //var userid = $(".user:checked").val();
		   //document.getElementByName('hsd').value;
	   var queryString = "?id=" + id ;

	   //queryString +=  "&endchoice=" + endchoice + "&reportchoice=" + reportchoice;// + "&userid=" + userid;
	 //switch (reportchoice) {
		 //case 1:
			 ajaxRequest.open("GET", "approveDeny.php", true);
			 ajaxRequest.send(null); 
		 //case 2:
			 //ajaxRequest.open("GET", "EmpTimeclockFunction.php", true);
			 //ajaxRequest.send(null); 
	 //}  

	}
</script>

<BODY onload='ajaxPTOrequest()' style="background-color: #0e5092;">
<?php include 'include/header_extensions.php'; ?>
<div class="container-fluid">
	<div class="carded mt-5 mx-auto col-77 ">
		<div class="justify-content-center my-5">
			<div class="row card-img-top mx-auto">
				<div class="col">
					<h2><img src="images/SOGLOGO-01.svg" alt="IMG" width="20%"> <br />
					PTO Request</h2>
				</div>
			</div>
<!--
				<div class="row">
					<div class="col">Name</div>
					<div class="col">Start Date</div>
					<div class="col">End Date</div>
					<div class="col">Hours Requested</div>
					<div class="col">Approve</div>
					<div class="col">Deny</div>
				</div>
-->
<!--				<input type = 'button' class='navbar-btn' onclick = 'ajaxPTOrequest()' value = 'View PTO Requests'/>-->
			<?php 
/*
			$query = "SELECT * FROM pto_request order by id desc"; //may need to edit this

			$result = mysql_query($query) or die(mysql_error());
			$approve_button = 
				"<input type=hidden name=id value=$approve>"
				. "<input class='navbar-btn' type=submit name=approvePTO value=\"Update\">";

			while($row = mysql_fetch_array($result)){
				$id = $row['id'];
				$userid = $row['userid'];
				$fullname = $userHash[$userid];
				$start = $row['start_time'];
				$end = $row['end_time'];
				$request = $row['requested_pto'];
				echo "<div class='row'>";
				echo "<div class='col'>$fullname</div>";
				echo "<div class='col'>$start</div>";
				echo "<div class='col'>$end</div>";
				echo "<div class='col'>$request</div>";
				echo "<div class='col'><input type = 'button' class='navbar-btn' onclick = 'ajaxApproval()' value = 'Approve'/></div>";
				echo "<div class='col'><input type = 'button' class='navbar-btn' onclick = 'ajaxDenied()' value = 'Deny'/></div>";
				echo "</div>";
			}
*/
			?>
				<div id='ajaxDiv'></div>
			
			
				<!-- <br> -->
				<!-- <div class="row mx-auto">
					<div class="col">
					<a href='outboard.php' class='btn btn-primary'>Return to Outboard</a>
					</div>
				</div> -->
				
			</div>		
			
	</div>
</div>
</BODY>
	<script language = "javascript" type = "text/javascript">
 function ajaxPTOrequest(){
	   var ajaxRequest;  // The variable that makes Ajax possible!

	   try {
		  // Opera 8.0+, Firefox, Safari
		  ajaxRequest = new XMLHttpRequest();
	   }catch (e) {
		  // Internet Explorer Browsers
		  try {
			 ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		  }catch (e) {
			 try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			 }catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			 }
		  }
	   }

	   // Create a function that will receive data 
	   // sent from the server and will update
	   // div section in the same page.

	   ajaxRequest.onreadystatechange = function(){
		  if(ajaxRequest.readyState == 4){
			 var ajaxDisplay = document.getElementById('ajaxDiv');
			 ajaxDisplay.innerHTML = ajaxRequest.responseText;
		  }
	   }

	   // Now get the value from user and pass it to
	   // server script.

	   //var startchoice = document.getElementById('start').value;
	   //var endchoice = document.getElementById('end').value;
	   var reportchoice = $(".message_pri:checked").val();
	   //var userid = document.getElementById('user').value;
	   //var userid = $(".user:checked").val();
		   //document.getElementByName('hsd').value;
	   //var queryString = "?startchoice=" + startchoice ;

	   //queryString +=  "&endchoice=" + endchoice + "&reportchoice=" + reportchoice;// + "&userid=" + userid;
	 //switch (reportchoice) {
		 //case 1:
			 ajaxRequest.open("GET", "apr.php", true);
			 ajaxRequest.send(null); 
		 //case 2:
			 //ajaxRequest.open("GET", "EmpTimeclockFunction.php", true);
			 //ajaxRequest.send(null); 
	 //}  

	}
</script>
<script src="/assets/js/bottom_scripts.js?v1.0.0.1"></script>
</HTML>
