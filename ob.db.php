<?php

require_once("lib/OutboardDatabase.php");
require_once("lib/OutboardAuth.php");

include_once("include/common.php");
$ob   = new OutboardDatabase();
$auth = new OutboardAuth();


$session = $auth->getSessionCookie();

if ($ob->getConfig('authtype') == "internal") {
    $BasicAuthInUse = false;
    if ($username = getPostValue('username') and $password = getPostValue('password')) {
        $session = $ob->checkPassword($username,$password);
    }
} else {
$BasicAuthInUse = true;
if (! $session) {
    $username = $auth->checkBasic();
    if ($ob->isBoardMember($username)) {
    $ob->setOperatingUser($username);
    $session = $ob->setSession();
    }
}
}

$auth->setSessionCookie($session,$cookie_time_seconds);
$username = $ob->getSession($session);

// Get the owner of the dot we want to change (might be someone else's dot)
$userid = getPostValue('userid');

// The user wants to move the dot to the Out column
if ($out = getGetValue('out')) { $ob->setDotOut($userid); }

// The user wants to move the dot to the In column
if ($in = getGetValue('in')) { $ob->setDotIn($userid); }

if ($rw = getGetValue('rw')) { $ob->setDotRW($userid); }

// The user wants to move the dot to the specified "will return by" column. The
// return variable contains the hour in the day that the user will return.
if ($return = getGetValue('return')) { $ob->setDotTime($userid,$return); }

// The user wants to change the remarks. We have to use isset() here first
// to allow for empty remarks.
if (isset($_GET['remarks'])) {
    $remarks = getGetValue('remarks');
    $ob->setRemarks($userid,$remarks);
}


// Appropriately set the update flag.
if (getPostValue('update') == 1) { $update = 1; }
else { $update = 0; }
// if (getPostValue('noupdate') == 0) {
//     $update = 0;
// //    echo "HEY" . $update;
// if ($current['hours'] >= 6 && $current['hours'] <= 18 ) {
//     $update_msec = $ob->getConfig('reload_sec') * 1000;
// } else {
//     // Set the update rate to the "night rate" if between 6:00pm and 6:00am
//     $update_msec = $ob->getConfig('night_sec') * 1000;
// }
// } else {
//     $update = 1;
//     $update_msec = $ob->getConfig('update_sec') * 1000;
// }

if(isset($_REQUEST['update'])){
    $isChangeable = $ob->isChangeable($userid);
    if($isChangeable){ $change = true;}
    else { $change = false; }
}

$a[] = array(
    'userid'    => $userid,
    'username'  => $username,
    'updatebool'    => $update,
    'change'    => $change
);
echo json_encode($a);
?>