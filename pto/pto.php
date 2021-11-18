<?php
require_once("lib/OutboardAuth.php");
require_once("lib/OutboardTimeclock.php");
require_once("lib/obPtest.php");
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

/*$rolloverFullDate = mktime(0,0,0,date("Y")-1,7,1);
$rolloverDate = date("Y-m-d",$rolloverFullDate);
$pay = new OutboardPayroll($rolloverDate,$ob->getLogEndDate());

$periodCount = $pay->_setNumPeriods();
while ($row = $ob->getRow()) {
	$sdate = date("Y-m-d",$row['start_date']);
	$ptoIncrease = date("Y-m-d", mkdate(0,0,0,date("Y",$row['start_date'])+9,date("m",$row['start_date']),date("d",$row['start_date'])));
	list($year,$month,$day) = split("-",$sdate);
	if ($yearsWorked > $ptoIncrease){ 
	$ptoTotalHours = $periodCount * 5;}
}*/

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
?>
<HTML>
<HEAD>
<TITLE>Timeclock Report: <?php echo $ob->getConfig('board_title') ?></TITLE>

<!--?php include("include/reportstylesheet.php"); ?--
<--===============================================================================================--	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<--===============================================================================================--
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<--===============================================================================================--
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<--===============================================================================================--
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<--===============================================================================================--	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<--===============================================================================================--
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<--===============================================================================================--
	<link rel="stylesheet" type="text/css" href="assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">
	<--link rel="stylesheet" type="text/css" href="assets/css/bootstrap-datepicker.css"--
<--===============================================================================================--
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css"/>
-->
<?php include 'include/dependencies.php'; ?>
<SCRIPT>
//   $("#startdate").datepicker({daysOfWeekDisabled: '0,6'});
//   $("#enddate").datepicker({daysOfWeekDisabled: [0,6]});
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
<BODY style="background-color: #0e5092;">
<script language = "javascript" type = "text/javascript">
	 function ajaxPTOfull(){
		//    var ajaxRequest;  // The variable that makes Ajax possible!

		//    try {
		// 	  // Opera 8.0+, Firefox, Safari
		// 	  ajaxRequest = new XMLHttpRequest();
		//    }catch (e) {
		// 	  // Internet Explorer Browsers
		// 	  try {
		// 		 ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		// 	  }catch (e) {
		// 		 try{
		// 			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
		// 		 }catch (e){
		// 			// Something went wrong
		// 			alert("Your browser broke!");
		// 			return false;
		// 		 }
		// 	  }
		//    }

		//    // Create a function that will receive data 
		//    // sent from the server and will update
		//    // div section in the same page.

		//    ajaxRequest.onreadystatechange = function(){
		// 	  if(ajaxRequest.readyState == 4){
		// 		 var ajaxDisplay = document.getElementById('ajaxDiv');
		// 		 ajaxDisplay.innerHTML = ajaxRequest.responseText;
		// 	  }
		//    }

		//    // Now get the value from user and pass it to
		//    // server script.

		//    //var startchoice = document.getElementById('start').value;
		//    //var endchoice = document.getElementById('end').value;
		//    var reportchoice = $(".message_pri:checked").val();
		//    //var userid = document.getElementById('user').value;
		//    //var userid = $(".user:checked").val();
		// 	   //document.getElementByName('hsd').value;
		//    //var queryString = "?startchoice=" + startchoice ;

		//    //queryString +=  "&endchoice=" + endchoice + "&reportchoice=" + reportchoice;// + "&userid=" + userid;
		//  //switch (reportchoice) {
		// 	 //case 1:
		// 		 ajaxRequest.open("GET", "FD.php", true);
		// 		 ajaxRequest.send(null); 
		// 		 $("#startdate").datepicker({daysOfWeekDisabled: '06'});
		// 		$("#enddate").datepicker({daysOfWeekDisabled: [0,6]});
		// 	 //case 2:
		// 		 //ajaxRequest.open("GET", "EmpTimeclockFunction.php", true);
		// 		 //ajaxRequest.send(null); 
		//  //}  
			$.ajax({
					url: "FD.php", 
					success: function(result){
					$("#ajaxDiv").html(result);
					$.getScript("ajax/test.js", function(data, textStatus, jqxhr) {
					console.log(data); //data returned
					console.log(textStatus); //success
					console.log(jqxhr.status); //200
					console.log('Load was performed.');
					});
					}
				});
		}
	function ajaxPTOpart(){
		//    var ajaxRequest;  // The variable that makes Ajax possible!

		//    try {
		// 	  // Opera 8.0+, Firefox, Safari
		// 	  ajaxRequest = new XMLHttpRequest();
		//    }catch (e) {
		// 	  // Internet Explorer Browsers
		// 	  try {
		// 		 ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		// 	  }catch (e) {
		// 		 try{
		// 			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
		// 		 }catch (e){
		// 			// Something went wrong
		// 			alert("Your browser broke!");
		// 			return false;
		// 		 }
		// 	  }
		//    }

		//    // Create a function that will receive data 
		//    // sent from the server and will update
		//    // div section in the same page.

		//    ajaxRequest.onreadystatechange = function(){
		// 	  if(ajaxRequest.readyState == 4){
		// 		 var ajaxDisplay = document.getElementById('ajaxDiv');
		// 		 ajaxDisplay.innerHTML = ajaxRequest.responseText;
		// 	  }
		//    }

		//    // Now get the value from user and pass it to
		//    // server script.

		//    //var startchoice = document.getElementById('start').value;
		//    //var endchoice = document.getElementById('end').value;
		//    var reportchoice = $(".message_pri:checked").val();
		//    //var userid = document.getElementById('user').value;
		//    //var userid = $(".user:checked").val();
		// 	   //document.getElementByName('hsd').value;
		//    //var queryString = "?startchoice=" + startchoice ;

		//    //queryString +=  "&endchoice=" + endchoice + "&reportchoice=" + reportchoice;// + "&userid=" + userid;
		//  //switch (reportchoice) {
		// 	 //case 1:
		// 		 ajaxRequest.open("GET", "PD.php", true);
		// 		 ajaxRequest.send(null); 
		// 	 //case 2:
		// 		 //ajaxRequest.open("GET", "EmpTimeclockFunction.php", true);
		// 		 //ajaxRequest.send(null); 
		//  //}  
		$.ajax({
					url: "PD.php", 
					success: function(result){
					$("#ajaxDiv").html(result);
					$.getScript("ajax/test.js", function(data, textStatus, jqxhr) {
					console.log(data); //data returned
					console.log(textStatus); //success
					console.log(jqxhr.status); //200
					console.log('Load was performed.');
					});
					}
				});

		}
	function PD(){
	//    var ajaxRequest;  // The variable that makes Ajax possible!

	//    try {
	// 	  // Opera 8.0+, Firefox, Safari
	// 	  ajaxRequest = new XMLHttpRequest();
	//    }catch (e) {
	// 	  // Internet Explorer Browsers
	// 	  try {
	// 		 ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	// 	  }catch (e) {
	// 		 try{
	// 			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
	// 		 }catch (e){
	// 			// Something went wrong
	// 			alert("Your browser broke!");
	// 			return false;
	// 		 }
	// 	  }
	//    }

	//    // Create a function that will receive data 
	//    // sent from the server and will update
	//    // div section in the same page.

	//    ajaxRequest.onreadystatechange = function(){
	// 	  if(ajaxRequest.readyState == 4){
	// 		 var ajaxDisplay = document.getElementById('ajaxDiv');
	// 		 ajaxDisplay.innerHTML = ajaxRequest.responseText;
	// 	  }
	//    }

	//    // Now get the value from user and pass it to
	//    // server script.
	//    var userselect = document.getElementById('userselect').value;
	//    var startchoice = document.getElementById('start').value;
	//    var selecthours = document.getElementById('selecthours').value;
	//    var sst = document.getElementById('sst').value;

	//    //var endchoice = document.getElementById('end').value;
	//    //var reportchoice = $(".message_pri:checked").val();
	//    //var userid = document.getElementById('user').value;
	//    //var userid = $(".user:checked").val();
	// 	   //document.getElementByName('hsd').value;
	//    var queryString = "?startchoice=" + startchoice ;

	//    queryString +=  "&selecthours=" + selecthours + "&sst=" + sst + "&userselect=" + userselect; //+ "&reportchoice=" + reportchoice;// + "&userid=" + userid;
	//    //ajaxRequest.open("GET", "EmpTimeclockFunction.php" + queryString, true);
	//    ajaxRequest.open("GET", "ptoRT.php" + queryString, true);
	//    ajaxRequest.send(null); 
	$.ajax({
		url: "PD.php", 
		data: {
			startchoice: $("#startdate").val(),
			selecthours: $("#selecthours").val(),
			sst: $("#sst").val(),
			userselect: $("#userselect").val(),

		},
		success: function(result){
			$("#ajaxDiv").html(result);
		}
	});
	}
	function FD(){
	//    var ajaxRequest;  // The variable that makes Ajax possible!

	//    try {
	// 	  // Opera 8.0+, Firefox, Safari
	// 	  ajaxRequest = new XMLHttpRequest();
	//    }catch (e) {
	// 	  // Internet Explorer Browsers
	// 	  try {
	// 		 ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	// 	  }catch (e) {
	// 		 try{
	// 			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
	// 		 }catch (e){
	// 			// Something went wrong
	// 			alert("Your browser broke!");
	// 			return false;
	// 		 }
	// 	  }
	//    }

	//    // Create a function that will receive data 
	//    // sent from the server and will update
	//    // div section in the same page.

	//    ajaxRequest.onreadystatechange = function(){
	// 	  if(ajaxRequest.readyState == 4){
	// 		 var ajaxDisplay = document.getElementById('ajaxDiv');
	// 		 ajaxDisplay.innerHTML = ajaxRequest.responseText;
	// 	  }
	//    }

	//    // Now get the value from user and pass it to
	//    // server script.
	//    var userselect = document.getElementById('userselect').value;
	//    var startchoice = document.getElementById('start').value;
	//    var endchoice = document.getElementById('end').value;
	//    //var reportchoice = $(".message_pri:checked").val();
	//    //var userid = document.getElementById('user').value;
	//    //var userid = $(".user:checked").val();
	// 	   //document.getElementByName('hsd').value;
	//    var queryString = "?startchoice=" + startchoice ;

	//    queryString +=  "&endchoice=" + endchoice + "&userselect=" + userselect; // + "&reportchoice=" + reportchoice;// + "&userid=" + userid;
	//    ajaxRequest.open("GET", "ptoRT.php" + queryString, true);
	//    ajaxRequest.send(null); 
		$.ajax({
			url: "ptoRT.php", 
			data: {
				startchoice: $("#startdate").val(),
				endchoice: $("#enddate").val(),
				userselect: $("#userselect").val()

			},
			success: function(result){
				$("#ajaxDiv").html(result);
			}
		});
	}
	function ajaxPTOcheck(){
		$.ajax({
		url: "ptoRequestCheck.php", 
		data: {
			userselect: $("#userselect").val()
		},
		success: function(result){
			$("#ajaxDiv").html(result);
		}
		});
	}
</script>
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
			<div class="row card-img-top mx-auto">
				<div class="col">
					<input type = 'hidden' id ="userselect" value ="<?php echo $username; ?>">
					<input type = 'button' class="btn btn-secondary" onclick = 'ajaxPTOfull()' value = 'Full Day'/>
					<input type = 'button' class="btn btn-secondary" onclick = 'ajaxPTOpart()' value = 'Partial Day'/>
					<input type = 'button' class="btn btn-secondary" onclick = 'ajaxPTOcheck()' value = 'Check PTO Requests'/>
					<br />
					<h2>Instructions</h2><br />
					<p>Please select one of the options above. <br />
						For Full Day, please insert the range of days you would like to take off. <br />
						For Partial Day, please enter the day you wish to take PTO and the number of hours. 
						<br /> <br />
						Please enter just the number of hours (ie. 3 hours would be 3 while 3 & 1/2 hours would be 3.5)</p>
				</div>
				<div class="col mx-5">
					<div id='ajaxDiv'></div>
				</div>
			</div>
		<!-- <div> <br />  -->
		</div>
				
					
			
	</div>
</div>
</BODY>
<script src="/js/bottom_scripts.js?v1.0.0.1"></script>
</HTML>

