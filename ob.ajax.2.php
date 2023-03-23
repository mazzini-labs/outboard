<?php  
require_once("lib/OutboardDatabase.php");
require_once("lib/OutboardAuth.php");

include_once("include/char_widths.php");
include_once("include/common.php");

// Create main objects;
$auth = new OutboardAuth();
$ob   = new OutboardDatabase();

// Set some simple variables used later in the page
$baseurl             = $_SERVER['PHP_SELF'];
$current             = getdate();
$version             = $ob->getConfig('version');
$version_date        = $ob->getConfig('version_date');
$max_visible_length  = $ob->getConfig('max_visible_length');
$cookie_time_seconds = $ob->getConfig('cookie_time_seconds');
$body_bg             = $ob->getConfig('body_bg');
$td_bg               = $ob->getConfig('td_bg');
$td_zebra1           = $ob->getConfig('td_zebra1');
$td_zebra2           = $ob->getConfig('td_zebra2');
$zebra_stripe		 = $ob->getConfig('zebra_stripe');
$td_user_bg          = $ob->getConfig('td_user_bg');
$td_text             = $ob->getConfig('td_text');
$td_lines            = $ob->getConfig('td_lines');
$link_text           = $ob->getConfig('link_text');
$windows_font_family = $ob->getConfig('windows_font_family');
$unix_font_family    = $ob->getConfig('unix_font_family');
$windows_bfs         = $ob->getConfig('windows_bfs');
$unix_bfs            = $ob->getConfig('unix_bfs');
$image_dir           = $ob->getConfig('image_dir');
$change_image        = $ob->getConfig('change_image');
$view_image          = $ob->getConfig('view_image');
$empty_image         = $ob->getConfig('empty_image');
$in_image            = $ob->getConfig('in_image');
$out_image           = $ob->getConfig('out_image');
$dot_image           = $ob->getConfig('dot_image');
$right_arrow         = $ob->getConfig('right_arrow');

// Run the installation script if the config says to
if ($ob->getConfig('installtables')) { include("include/install.php"); }


// Get the session (if there is one)
$session = $auth->getSessionCookie();
error_log($session);
// Trying to figure out a way to send a 'log out signal' if there's no session
// if(!$session){
//   // error_log('this works');
//   // $b= array();
//   // $b['data'][] = array(
//   //   'session'    => 'logged out'
//   // );
//   // echo(json_encode($b));
  
// }
// else{
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

// Show the login screen if the user is not authenticated
if (! $username) {
  $auth->setSessionCookie("",$cookie_time_seconds);
  include("include/loginscreen.php");
}

// if 'logout' is set, run the logout functions and go back
// to the login screen.
if (getGetValue('logout')) {
  $ob->setSession("");
  $auth->setSessionCookie("",$cookie_time_seconds);
  include("include/loginscreen.php");
}

if (getPostValue('exitadmin')) {
  // trick the page into noupdate mode
  $_GET['noupdate'] = 1;
} elseif (getGetValue('adminscreen') and $ob->isAdmin() ) {
  include("include/admin.php");
}
$request = file_get_contents('php://input');
$rdata = json_decode($request);
// error_log(($request));
// error_log(($rdata->update));
if(!empty($rdata)){

    // Get the owner of the dot we want to change (might be someone else's dot)
    $userid = $rdata->user;
    if($rdata->status){
        switch($rdata->status){
        case 3:
            $ob->setDotOut($userid);
            break;
        case 1: 
            $ob->setDotIn($userid);
            break;
        case 2:
            $ob->setDotRW($userid);
            break;
        default:
            
        }
    }
    

    // // The user wants to move the dot to the Out column
    // if ($rdata->out) { $ob->setDotOut($userid); }

    // // The user wants to move the dot to the In column
    // if ($rdata->in) { $ob->setDotIn($userid); }

    // if ($rdata->rw) { $ob->setDotRW($userid); }

    // The user wants to move the dot to the specified "will return by" column. The
    // return variable contains the hour in the day that the user will return.
    if ($rdata->return) { $ob->setDotTime($userid,$rdata->return); }

    // The user wants to change the remarks. We have to use isset() here first
    // to allow for empty remarks.
    if ($rdata->remarks) {
        if($rdata->remarks == 'clear'){
            $ob->setRemarks($userid,"");
        }
        else {
            $ob->setRemarks($userid,$rdata->remarks);
        }
    // $remarks = getGetValue('remarks');
    
    }

    switch($rdata->update){
    case 1:
        $update = 1;
        $update_msec = $ob->getConfig('update_sec') * 1000;
        break;
    default:
        $update = 0;
        if ($current['hours'] >= 6 && $current['hours'] <= 18 ) {
            $update_msec = $ob->getConfig('reload_sec') * 1000;
        } else {
            // Set the update rate to the "night rate" if between 6:00pm and 6:00am
            $update_msec = $ob->getConfig('night_sec') * 1000;
        }
    }
}
else 
{
    // Get the owner of the dot we want to change (might be someone else's dot)
    $userid = getGetValue('userid');

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

    // echo (getPostValue('update'));
    // echo (getGetValue('update'));

    // $a['data'][] = array(
    //     'postUpdate'    => getPostValue('update'),
    //     'getUpdate'   => getGetValue('update'),
    // );
    // json_encode($a);

    // Appropriately set the update flag.
    // if ((getGetValue('noupdate') == 0) || (getPostValue('update') == 0)) {
    //   $update = 1;
    // //   echo $update;
    //   if ($current['hours'] >= 6 && $current['hours'] <= 18 ) {
    //     $update_msec = $ob->getConfig('reload_sec') * 1000;
    //   } else {
    //     // Set the update rate to the "night rate" if between 6:00pm and 6:00am
    //     $update_msec = $ob->getConfig('night_sec') * 1000;
    //   }
    // } 
    // elseif (getPostValue('update') == 1) {
    //     $update = 1;
    //   $update_msec = $ob->getConfig('update_sec') * 1000;
    // }
    // else {
    //   $update = 1;
    //   $update_msec = $ob->getConfig('update_sec') * 1000;
    // }
    $get = getGetValue('update');
    switch($get){
        case 0:
            $update = 0;
            if ($current['hours'] >= 6 && $current['hours'] <= 18 ) {
                $update_msec = $ob->getConfig('reload_sec') * 1000;
            } else {
                // Set the update rate to the "night rate" if between 6:00pm and 6:00am
                $update_msec = $ob->getConfig('night_sec') * 1000;
            }
        break;
        case 1:
        $update = 1;
        $update_msec = $ob->getConfig('update_sec') * 1000;
        break;
        default:
            $update = 0;
            if ($current['hours'] >= 6 && $current['hours'] <= 18 ) {
                $update_msec = $ob->getConfig('reload_sec') * 1000;
            } else {
                // Set the update rate to the "night rate" if between 6:00pm and 6:00am
                $update_msec = $ob->getConfig('night_sec') * 1000;
            }
    }
}

$header = 
"";
// Get the latest outboard information from the database
$ob->getData();

$rowcount = 0;
$zebra = 0;
$username = urlencode($username);
$a= array();
// $hours= array();

while($row = $ob->getRow()) {
    $hours="";
    $change="";
    $lastup="";
    $in="";
    $out="";
    $rw="";
    
    # isChangeable just checks who can move dots 
    # there's four options:
    //    all         - Any user (non-readonly) can change anyone's info
    //    user_only   - Only the user can change his info (not even the admin)
    //    admin_only  - Only the admins can change anyone's info
    //    user_admin  - Only the user (and admins) can change a user's info
    # as we have it set for user_admin, this checks every user 
    # versus the operating user and allows a change or not
    $isChangeable = $ob->isChangeable($row['userid']);
    $row['userid'] = urlencode($row['userid']);
    if (! preg_match("/<READONLY>/",$row['options'])) 
    {
        $datetime = getdate($row['back']);
        if ($row['last_change'] != "") 
        {
            list($uname,$ip) = explode(",",$row['last_change']);
            $lastup = "Last updated by $uname from $ip on " .  $row['timestamp'] . "";
            $alt = "ALT=\"$lastup\" TITLE=\"$lastup\"";
            $alt2 = "data-tippy-content=\"$lastup\" tabindex=\"0\"";
        } 
        else 
        {
            $alt = "";
        }
        if (getGetValue('in') == 1) 
        {
            $in = "in";
            $rw= "empty";
        }
        elseif (getGetValue('rw') == 1) 
        {
            $rw = "rw";
            $in = "empty";
        }
        else 
        {
            $in = "in";
            $rw = "empty";
        }
        //$in= "in";
        
        //echo "year:" . $datetime['year'] . "<br>";
        //echo "hours:" . $datetime['hours'] . "<br>";
        //echo "seconds:" . $datetime['seconds'] . "<br>";
        if ($datetime['year'] > $current['year']) 
        {
            $out= "out";
            # so now this checks for if the user
            # a) is attempting to update their status.
            # b) is either the user or an admin. if they're not an admin, then 
            # is changeable (and the code) always returns false for other users
            if ($update && $isChangeable) 
            {
                $in= "empty";
                $rw= "empty";
            } 
            else 
            {
                $in= "empty";
                $rw= "empty";
            }
        } 
        elseif ($datetime['seconds'] == 1)//($update && $isChangeable && $rw == "rw") 
        {
            $rw= "rw";
            if ($update && $isChangeable) 
            {
                $out= "empty";
                $in ="empty";
                
            } 
            else 
            {
                $out= "empty";
                $in= "empty";
            }
        }
        else
        {
            if ($update && $isChangeable) 
            {
                $out= "empty";
                $rw= "empty";
            } 
            else 
            {
                $out= "empty";
                $rw= "empty";
            }
        }
        //echo $in. "<br>";
        //echo $out. "<br>";
        //echo $rw. "<br>";
    for ($i = 8; $i <= 17; $i++) {
        if ( $datetime['hours'] == $i ) {
        $back[$i] = "<img src=$image_dir/$dot_image $alt>";
        // $back[$i] = "<th style = 'background-color: #00FF00; height: '10px';'>";
        if ($update && $isChangeable) {
        // $in= "<a href=\"$baseurl?in=1&userid=".$row['userid']."#".$row['userid']."\">"
        // ."<img src=$image_dir/$empty_image BORDER=0></a>";
        $in= "<a href=\"$baseurl?in=1&userid=".$row['userid']."#".$row['userid']."\">"
            ."<i data-feather='check-circle' style='color: green;'></i></a>";
        } else {
        $in= "<img src=$image_dir/$empty_image>";
        }
        } else {
        if ($update && $isChangeable) {
        $back[$i] = "<a href=\"$baseurl?return=$i&userid=".$row['userid']."#".$row['userid']."\">"
            ."<img src=$image_dir/$empty_image BORDER=0></a>";
        } else {
        $back[$i] = "<img src=$image_dir/$empty_image>";
        }
        }
    }
    if ($ob->getConfig('zebra_stripe') != 0) {
        if ($rowcount % $ob->getConfig('zebra_stripe') == 0) {
        if ($zebra == 1) { $zebra = 2; } else { $zebra = 1; }
        }
        $user_bg = "class=zebra".$zebra;
    } else {
        $user_bg = "";
    }
    if ($row['userid'] == $username && $update && $isChangeable) {
        $user_bg = "class=user ";
    }
    if ($rowcount % $ob->getConfig('reprint_header') == 0) { echo $header; }
    // echo "<tr class=".$uname.">";
    // echo "<td WIDth=8% $user_bg><A class=\"nobr\" name=\"".$row['userid']."\">".$row['name']."</A></td>";
    // echo "<td WIDth=12% $user_bg><A class=\"nobr\" name=\"".$row['userid']."\">".$row['hours']."</A></td>";
    // echo "<td WIDth=2% $user_bg>$in</td>";
    // echo "<td WIDth=2% $user_bg>$out</td>";
    if ($row['remarks'] == "") 
    {
        if ($update) 
        {
            $print_remarks = "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; "
            ."&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; "
            ."&nbsp; &nbsp; &nbsp; &nbsp;";
        } 
        else 
        {
            $print_remarks = "&nbsp;";
        }
    } 
    else 
    {
        $mvl = 40;
        if(strlen($row['remarks']) > $mvl)
        {
            // $user_bg = "class=text-wrap";
        }
        $visible = trim_visible($row['remarks'],$max_visible_length);
        if ($visible != $row['remarks']) 
        {
            $rem = $row['remarks'];
                $alt = "ALT=\"$rem\" TITLE=\"$rem\"";
            $print_remarks = htmlspecialchars($visible)
                            . "<img src=$image_dir/$right_arrow BORDER=0 $alt>";
        } 
        else 
        {
            $print_remarks = htmlspecialchars($visible);
        }
    }
    
    if ($update && $isChangeable) 
    {
        $change = "true";
        // $hours = @($row["hours"]);
        $hours = $row["hours"];
        // echo "<td $user_bg'><a style='color: black;' href=\"javascript:this.change_remark('"
        // . addslashes(htmlspecialchars($row['remarks']))
        // . addslashes($row['remarks'])
        // . "','".$row['userid']."')\">$print_remarks</a></td>";
    } 
    elseif(isset($_GET['']))
    {
        $change = "false"; // was true but changed to false
        $hours = $row["hours"];
    }
    $hours = $row["hours"];
    // else 
    // {
    //     $change = "false";
    //     $hours = $row["hours"];
    //     // echo "<td $user_bg>$print_remarks</td>";
    // }
    
    // while ($row = mysqli_fetch_assoc($result)) 
    // {
    //     $a['data'][] = $row;
    // }
    $a['data'][] = array(
        'lastup'    => $lastup,
        'name'   => "" . $row["name"],
        'hours'   => "" . $hours,
        'in'   => "" . $in,
        'out'   => "" . $out,
        'remarks'   => "" . $row["remarks"],
        'user_bg'   => "" . $user_bg,
        'change'    => "" . $change,
        'uname'     => "" . $row["userid"],
        'baseurl'   => "" . $baseurl,
        'user'      => "" . $username,
        'rw'        => "" . $rw,
        'back'      => "" . $row["back"],
        'udate'     => "" . $update,
        'm'     => "" . $row["m_hr"],
        't'     => "" . $row["t_hr"],
        'w'     => "" . $row["w_hr"],
        'th'     => "" . $row["th_hr"],
        'f'     => "" . $row["f_hr"],
        's'     => "" . $row["s_hr"],
        'ss'     => "" . $row["ss_hr"]
        
    );
    
    $rowcount++;
    } // end if
} // end while
    //*/
    echo (json_encode($a));
// } // end else
    ?>
