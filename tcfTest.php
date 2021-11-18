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
*/
?>
<HTML>
<HEAD>
<TITLE>Timeclock Report: <?php echo $ob->getConfig('board_title') ?></TITLE>

<?php  include 'include/dependencies.php' ?>


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
    xmlhttp.open("POST", "allEmpTimeclockFunction.php?start=" + str, true);
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
		 function ajaxFunction(){
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
					
               var startchoice = document.getElementById('start').value;
               var endchoice = document.getElementById('end').value;
               var reportchoice = $(".message_pri:checked").val();
				   //document.getElementByName('hsd').value;
               var queryString = "?startchoice=" + startchoice ;
            
               queryString +=  "&endchoice=" + endchoice + "&reportchoice=" + reportchoice;
               ajaxRequest.open("GET", "include/allEmpTimeclockFunction.php" + queryString, true);
               ajaxRequest.send(null); 
            }
  </script>
  <?php include 'include/header_extensions.php'; ?>
<div class="container-fluid">
  <div class="carded mt-5 mx-auto col-7 ">
    <div class=" justify-content-center ">
      <div class="row card-img-top mx-auto">
        <h2><img src="images/SOGLOGO-01.svg" alt="IMG" width="20%"> <br />
          All Employees Timeclock Report</h2>
      </div>
      <FORM class="" NAME=timeclock METHOD=post ACTION="<?php echo $_SERVER['PHP_SELF'] ?>">
        <div class="carded-body  ">
          <div class="input-group date" data-provide="datepicker">
            <input name="startdate" id="start" type="text" class="form-control">
            <div class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
            </div>
          </div>
          <div class="input-group date" data-provide="datepicker">
            <input name="enddate" id="end" type="text" class="form-control">
            <div class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
            </div>
          </div>

          <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-primary">
            <input class="message_pri" type="radio" name="hsd" id="option" value="1" autocomplete="off"> Total Hours
            </label>
            <label class="btn btn-primary">
            <input class="message_pri" type="radio" name="hsd" id="option" value="2" autocomplete="off"> Summary
            </label>
            <label class="btn btn-primary">
            <input class="message_pri" type="radio" name="hsd" id="option" value="3" autocomplete="off"> Details
            </label>
          </div>
          <div> <br /> </div>
          <input type = 'button' class="btn btn-primary" onclick = 'ajaxFunction()' value = 'Results'/>
        </FORM>
      <div id='ajaxDiv'></div>	
		</div>
	</div>
</div>
</BODY>
<script>
var today = moment().format("MM/DD/YYYY");
    console.log(today);
    $('#start').val(today);
    $('#end').val(today);
</script>
<script src="/js/bottom_scripts.js?v1.0.0.1"></script>
</HTML>

