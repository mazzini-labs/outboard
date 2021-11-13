<?php

require_once("lib/OutboardConfig.php");
require_once("lib/OutboardDatabase.php");
require_once("lib/OutboardAuth.php");

include_once("include/char_widths.php");
include_once("include/common.php");
################## LOGGING #########################
function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
################## LOGGING #########################

$auth = new OutboardAuth();
$ob   = new OutboardDatabase();
$session = $auth->getSessionCookie();
$username = $ob->getSession($session);
$group = null;
$department = "(";
//if (! $ob->isAdmin()) { exit; }
// if ($ob->isSuperAdmin()){
// 	$department .= "`department` like \"%\<ENG1\>%\"";
// }
if ($ob->isHR()) { 
	$department .= "`department` like \"HR\" or `department` like \"%AP%\" or `department` like \"%ACCT1%\" ";
	$department .= "or `department` like \"%ACCT2%\" or `department` like \"%ENG1%\" or `department` like \"%ENG2%\" ";
	$department .= "or `department` like \"%LAND%\" or `department` like \"%LEGAL%\" or `department` like \"%GEO%\" ";
	$department .= "or `department` like \"%ADSTAFF%\"";
} else { 
if ($ob->isAPspr()) {
	if ($ob->isHR()){ $department .= " or "; }
	$department .= "`department` like \"%AP%\" ";
} 
if ($ob->isA1spr()) { 
	if ($ob->isHR() || $ob->isAPspr()){ $department .= " or "; }
	$department .= "`department` like \"%ACCT1%\"";
} 
if ($ob->isA2spr()) { 
	if ($ob->isHR() || $ob->isAPspr() || $ob->isA1spr()){ $department .= " or "; }
	$department .= "`department` like \"%ACCT2%\"";
} 
if ($ob->isE1spr()) { 
	if ($ob->isHR() || $ob->isAPspr() || $ob->isA1spr() || $ob->isA2spr()){ $department .= " or "; }
	$department .= "`department` like \"%ENG1%\"";
} 
if ($ob->isE2spr()) { 
	if ($ob->isHR() || $ob->isAPspr() || $ob->isA1spr() || $ob->isA2spr() || $ob->isE1spr()){ $department .= " or "; }
	$department .= "`department` like \"%ENG2%\"";
} 
if ($ob->isLandspr()) { 
	if ($ob->isHR() || $ob->isAPspr() || $ob->isA1spr() || $ob->isA2spr() || $ob->isE1spr() || $ob->isE2spr()){ $department .= " or "; }
	$department .= "`department` like \"%LAND%\"";
} 
if ($ob->isLegalspr()) { 
	if ($ob->isHR() || $ob->isAPspr() || $ob->isA1spr() || $ob->isA2spr() || $ob->isE1spr() || $ob->isE2spr() || $ob->isLandspr()){ $department .= " or "; }
	$department .= "`department` like \"%LEGAL%\"";
} 
if ($ob->isGeospr()) { 
	if ($ob->isHR() || $ob->isAPspr() || $ob->isA1spr() || $ob->isA2spr() || $ob->isE1spr() || $ob->isE2spr() || $ob->isLandspr() || $ob->isLegalspr()){ $department .= " or "; }
	$department .= "`department` like \"%GEO%\"";
} 
if ($ob->isADstaffspr()) { 
	if ($ob->isHR() || $ob->isAPspr() || $ob->isA1spr() || $ob->isA2spr() || $ob->isE1spr() || $ob->isE2spr() || $ob->isLandspr() || $ob->isLegalspr() || $ob-isGeospr()){ $department .= " or "; }
	$department .= "`department` like \"%ADSTAFF%\"";
}
}

$department .= ")";
// echo $department;
console_log($department);
//$mainscreen = false;  // We are not on the main admin screen

$unique = uniqid("");  // Hack to get around I.E. caching. Trys to make
		       // sure that some URLs are different (enough).

$header = "
  <div class='row adminbar'>
  <div class='col'><p>Name</p></div>
  <div class='col'><p>Start Date</p></div>
  <div class='col'><p>End Date</p></div>
  <div class='col'><p>Hours Requested</p></div>
  <div class='col-2'><p>Approve</p></div>
  <div class='col-2'><p>Deny</p></div>
  <div class='col-auto'><p>Edit</p></div>
  </div>
  <br>
";

$header = "<table class='table table-striped table-hover'>
	<thead>
	<th>Name</th>
	<th>Start Date</th>
	<th>End Date</th>
	<th>Hours Requested</th>
	<th colspan='2'>Approve</th>
	<th colspan='2'>Deny</th>
	<th>Edit</th>
	</thead><tbody>";

?>

<!--
<table border=0 cellpadding=1 cellspacing=1>
<tr><th colspan=4 align=center><b>Editing Users</b></th></tr>
-->

<div class="container">PTO Approval
  <?php echo $header; ?>
<?php
if ($ob->getPTOData($department)) { //could i make a function in outboard database to get the calendar data?
	while ($row = $ob->getRow()) {
		$count++;
		// if ($count % 15 == 0) { echo $header; }
		if ($row['requested_pto'] == 1){ $hourtext = "Hour";}
		else {$hourtext = "Hours";}
		$rowid = $row['id'];
		// echo "<table class='table table-striped table-hover>";
		echo "<tr>";
		echo "<td>".$row['userid']."</td>";
		echo "<td>".$row['start_time']."</td>";
		echo "<td>".$row['end_time']."</td>";
		echo "<td>".$row['requested_pto']." $hourtext</td>";
		if (preg_match("/<APPROVED>/",$row['options'])) {
			echo "<td colspan='4'>";
			echo "<p class='approved'>Approved!</p>";
			echo "</td>";
		}
		elseif (preg_match("/<DENIED>/",$row['options'])) {
			echo "<td colspan='4'>";
			echo "<p class='denied'>Denied.</p>";
			echo "</td>";
		}
		else {
			echo "<td colspan='2'>";
			echo "<a href=\"approveDeny.php?id=$rowid&choice=Approved\" class='approve'>Approve</a>";
			echo "</td>";
			echo "<td colspan='2'>";
			echo "<a href=\"approveDeny.php?id=$rowid&choice=Denied\" class='deny'>Deny</a>";
			echo "</td>";
		}
		echo "<td>";
		
		echo "<a href=\"approveEdit.php?editPTO=$rowid\">"
		."<img src=image/edit.svg border=0></a>";
		echo "</td>";
		echo "</tr>\n";
    // echo "<div class='row'>";
    // echo "<div class='col'>".$row['name']."</div>";
    // echo "<div class='col'>".$row['start_time']."</div>";
    // echo "<div class='col'>".$row['end_time']."</div>";
	// echo "<div class='col'>".$row['requested_pto']." $hourtext</div>";
	//   if (preg_match("/<APPROVED>/",$row['options'])) {
	// 	echo "<div class='col-4'>";
	// 	echo "<p class='approved'>Approved!</p>";

	//   	//echo "<input type = 'button' class='navbar-btn' value='Approved!' disabled></button>";

	// 	echo "</div>";
	//   }
	//   elseif (preg_match("/<DENIED>/",$row['options'])) {
	// 	echo "<div class='col-4'>";
	// 	echo "<p class='denied'>Denied.</p>";
	//   	//echo "<input type = 'button' class='navbar-btn' value='Denied.' disabled></button>";
	// 	echo "</div>";
	//   }
	//   else {
	// 	 /*echo "<form name='form' action='approveDeny.php' method='post'>";
	// 	echo "<div class='col'>";
	// 	  echo "<input hidden name='approve' value='$rowid'/>";
	// 	echo "<input type = 'button' class='navbar-btn' Value='Approve'></button></div>";
	// 	  echo "</form>";
	// 	  echo "<form name='form' action='' method='post'>";
	// 	echo "<input name='deny' value='$rowid'/>";
	// 	echo "<input type = 'button' class='navbar-btn'>Deny</button></div>";;
	// 	  echo "</form>";*/
	// 	  echo "<div class='col-2'>";
	// 	  echo "<a href=\"approveDeny.php?id=$rowid&choice=Approved\" class='approve'>Approve</a>";
	// 	  echo "</div>";
	// 	  echo "<div class='col-2'>";
	// 	  echo "<a href=\"approveDeny.php?id=$rowid&choice=Denied\" class='deny'>Deny</a>";
	// 	  echo "</div>";
	// 	  /*echo  "<input type=hidden id='Approve' value=$rowid>"
	// 		  	. "<input class='navbar-btn' onclick = 'ajaxApprove()' type=submit name=edituser value=\"Approve\">";
	// 	  echo  "<input type=hidden name=rowid value=$rowid>"
	// 		  	. "<input class='navbar-btn' type=submit name=edituser value=\"Deny\">";*/
	// 	//echo "<div class='col'><input type = 'button' id='rowid' class='navbar-btn' onclick = 'ajaxApprove()' value='$rowid'>Approve</button></div>";
	// 	//echo "<div class='col'><input type = 'button' class='navbar-btn' onclick = 'ajaxDeny()' value='$rowid'>Deny</button></div>";


	// 	//echo "<div class='col'>";

	// 	//echo "<a href=\"${baseurl}?adminscreen=1&approvePTO=$rowid\" class='navbar-btn'>Approve</a>";
	// 	//echo "<input type='button' onclick='window.location.href = \"${baseurl}?adminscreen=1&approvePTO=$rowid\' class='navbar-btn' value = 'Approve'/>";
	// 	//."<a href=\"${baseurl}?adminscreen=1&approvePTO=$rowid\">";
	// 	//echo "</div>";
	// 	//echo "<div class='col'>";
	// 	//echo "<a href=\"approveDeny.php?rowid=$rowid\" class='navbar-btn'>Deny</a>";
	// 	  //echo "<input type='button' onclick='window.location.href = \"${baseurl}?adminscreen=1&denyPTO=$rowid\" class='navbar-btn' value = 'Deny'/>";

	// 	//echo "<input type = 'button' class='navbar-btn' value = 'Deny'/>"
	// 	//."<a href=\"${baseurl}?adminscreen=1&denyPTO=$rowid\">";
	// 	//echo "</div>";
	//   }
    // echo "<div class='col-auto'>";
    // echo "<a href=\"approveEdit.php?editPTO=$rowid\">"
	//  ."<img src=image/edit.svg border=0></a>";
    // echo "</div>";
    // echo "</div>\n";
	//   echo "<br>";
  }
  echo "</tbody></table>";
} else {
  echo "There are no PTO requests at this time.<p>";
}

?>