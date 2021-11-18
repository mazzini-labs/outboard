<?php
require_once("lib/OutboardAuth.php");
require_once("lib/OutboardTimeclock.php");
require_once("lib/obPtest.php");
require_once("lib/OutboardDatabase.php");

include_once("include/common.php");
include_once("include/html_helper.php");
include_once("include/html_helper_test.php");
include_once("include/fullname.php");
include "include/mail_requestpto.php";

// Get the session (if there is one)
$auth = new OutboardAuth();
$ob = new OutboardDatabase();
$session = $auth->getSessionCookie();
$username = $ob->getSession($session);

if (! $username) { exit; }

$tempUserHash = $ob->getFullNames();
$userHash = Array();

$userHash[$username] = $tempUserHash[$username];
// If we don't have a userid yet, use the username
if (! $userid = getPostValue('userid')) { $userid = $username; }

// Don't let non-admins use anyone else's userids.
if (! $ob->isAdmin()) { $userid = $username; }

$check = $_REQUEST['check'];

$query = "select * from outboard where userid = '".$username."'";
$result = mysql_query($query) or die(mysql_error());

$header = "<table class='table table-striped table-hover'>
	<thead>
	<th>Name</th>
	<th>Start Date</th>
	<th>End Date</th>
	<th>Hours Requested</th>
	<th>Edit</th>
    </thead><tbody>";
$department = "`userid` like \"$username\"";
// while($row = mysql_fetch_array($result)){ 
    if ($ob->getPTOData($department)) { //could i make a function in outboard database to get the calendar data?
        echo $header;
        while ($row = $ob->getRow()) {
            if ($row['requested_pto'] == 1){ $hourtext = "Hour";}
            else {$hourtext = "Hours";}
            $rowid = $row['id'];
            echo "<tr>";
            echo "<td>".$row['userid']."</td>";
            echo "<td>".$row['start_time']."</td>";
            echo "<td>".$row['end_time']."</td>";
            echo "<td>".$row['requested_pto']." $hourtext</td>";
            echo "<td>";
		
		echo "<a href=\"approveEdit.php?editPTO=$rowid&name=$username&fromPTO=1\">"
		."<img src="assets/images/edit.svg border=0></a>";
		echo "</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
    } else {
    echo "There are no PTO requests at this time.<p>";
    }