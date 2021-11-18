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

$tempUserHash = $ob->getNames();
$userHash = Array();

$userHash[$username] = $tempUserHash[$username];

// If we don't have a userid yet, use the username
if (! $userid = getPostValue('userid')) { $userid = $username; }

// Don't let non-admins use anyone else's userids.
if (! $ob->isAdmin()) { $userid = $username; }

if (isset($userHash[$userid])) {
  $fullname = $userHash[$userid];
} else {
  $fullname = "";
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

############# LOGGING ###############################
function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

//
############# LOGGING ###############################

$id = $_GET['id'];

$query = "SELECT * FROM pto_request where id like $id"; //may need to edit this

$result = mysql_query($query) or die(mysql_error());
		

while($row = mysql_fetch_array($result)){
$userid = $row['userid'];
  $start = $row['start_time'];
  $end = $row['end_time'];
  $request = $row['requested_pto'];
  $options = $row['options'];
 
/* //Failsafe to not mess up tables, make sure to keep uncommented until rest of code has been tested
 if (preg_match("/<APPROVED>/",$options)) {
    echo "This time off has already been approved.";
	 break;
  } 
  if (preg_match("/<DENIED>/",$options)) {
    echo "This time off has already been denied.";
	 break;
  } 
  */

}

if (! $ob->isAdmin()) { exit; }

$message = "";   // Stores status messages of admin actions

// Does user want to add or edit a user?
if (getPostValue('approvePTO')) {
	$ptoID = getGetValue('approvePTO');
	$ob->getPTOByID($ptoID); //see if i can make one for getting data from pto_request?
	$row = $ob->getRow();
	$userid = $row['userid'];
	$start = $row['start_time'];
	$end = $row['end_time'];
	$name = $row['name'];
	$request = $row['requested_pto'];
	$options = $row['options'];
	$title = $row['title'];

    if (getPostValue('approvePTO') > 0) { $options .= "<APPROVED>"; }
    $result = 0;
	
    if (getPostValue('approvePTO')) { 
		$result = $ob->updatePTOcal($id,$userid,$start_time,$end_time,$name,$options,$request); 
		$update = $ob->updatePTO($userid,$options,$request);
	} 
    if (! $result) {
      $message = "Error: PTO request not updated";
    } else {
      $message = "Success: PTO for user \"$name\" approved.";
    }
} 
elseif (getPostValue('denyPTO')) {
  $ptoID = getGetValue('denyPTO');
	$ob->getPTOByID($ptoID); //see if i can make one for getting data from pto_request?
	$row = $ob->getRow();
	$userid = $row['userid'];
	$start = $row['start_time'];
	$end = $row['end_time'];
	$name = $row['name'];
	$request = $row['requested_pto'];
	$options = $row['options'];
	$title = $row['title'];

    if (getPostValue('denyPTO') > 0) { $options .= "<DENIED>"; }
    $result = 0;
    if (getPostValue('denyPTO')) { 
		$result = $ob->updatePTOcal($id,$userid,$start_time,$end_time,$name,$options,$request); 
		$update = $ob->updatePTO($userid,$options,$request);
	} 
    if (! $result) {
      $message = "Error: PTO request not updated";
    } else {
      $message = "Success: PTO for user \"$name\" denied.";
    }
}



?>