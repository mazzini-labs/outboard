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

// Get the owner of the dot we want to change (might be someone else's dot)
$userid = getGetValue('userid');

// The user wants to move the dot to the Out column
if ($out = getGetValue('out')) { $ob->setDotOut($userid); }

// The user wants to move the dot to the In column
if ($in = getGetValue('in')) { $ob->setDotIn($userid); }

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
if (getGetValue('noupdate')) {
  $update = 0;
  if ($current['hours'] >= 6 && $current['hours'] <= 18 ) {
    $update_msec = $ob->getConfig('reload_sec') * 1000;
  } else {
    // Set the update rate to the "night rate" if between 6:00pm and 6:00am
    $update_msec = $ob->getConfig('night_sec') * 1000;
  }
} else {
  $update = 1;
  $update_msec = $ob->getConfig('update_sec') * 1000;
}


?>

<HTML>
<HEAD>

<SCRIPT Language="JavaScript">
  function openWindow( window_name, url, width, height ) {
    locX = (screen.width / 2) - (width / 2);
    locY = (screen.height / 2) - (height / 2);
    window_name = window.open(url, window_name,
      "dependent=yes,resizable=yes,scrollbars=yes,screenX=" + locX
       + ",screenY=" + locY + ",width=" + width + ",height=" + height);
    window_name.focus();
  }
  function myReload() {
    self.location = "<?php echo $baseurl ?>?noupdate=1";
  }
  t = setTimeout("myReload()",<?php echo $update_msec ?>);
</SCRIPT>

<?php if ($launch = getGetValue('launch')) { ?>
  <Script Language="JavaScript"> window.focus(); </Script>
<?php } ?>

<TITLE>OutBoard: <?php echo $ob->getConfig('board_title') ?></TITLE> 
<!--?php include("include/stylesheet.php"); ?-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================>
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================>
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================>
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================>	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================>
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================>
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/maintest.css">
<!--===============================================================================================-->
		<!-- Bootstrap core CSS -->
    <link href="WSB/dashboard/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="WSB/dashboard/dashboard.css" rel="stylesheet">

 </HEAD>

<BODY>

<Script language="JavaScript1.2">
  function change_remark(remark,userid) {
    var newremark = prompt("Enter your remarks below:",remark);
    if (newremark != null) {
      self.location="<?php echo $baseurl ?>?remarks="
		    + escape(newremark) + "&userid=" +userid + "#<?php echo $userid ?>";
    }
  }
</Script>


<!-- buttons on top  -->
	<?php if($ob->isReadonly()) { $readonly = true; } else { $readonly = false; }?>
 	 <?php if(getGetValue('noupdate')) $update = 0;?>
<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">			
<a class="navbar-brand col-md-2 mr-0" href="outboard.php"><img src=images/SpindletopAlt.svg></img></a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <?php if (! $BasicAuthInUse) { ?>
           			 <a class="nav-link" href="<?php echo $baseurl ?>?logout=1">Log Out</a>
  			 <?php } ?>
    </li>
  </ul>
</nav>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">
              <span data-feather="home"></span>
              Dashboard
            </a>
          </li>
          <li class="nav-item">                   
			<?php if ($ob->isAdmin()) { ?>
			  <a class="nav-link" href="tc.php" target=_blank><span data-feather="file"></span>Timesheet</a>
			<?php } else { ?>
			  <a class="nav-link" href="tcfEmp.php" target=_blank><span data-feather="file"></span>Timesheet</a>
			<?php } ?>
           
          </li>
          <li class="nav-item">
			  <?php if (! $update && ! $readonly) { ?>
			  <a class="nav-link" href="<?php echo $baseurl ?>?update=1#<?php echo $username ?>"><span data-feather="shopping-cart"></span>Change Status<ALT="Switch to update mode" TITLE="Switch to update mode" BORDER=0></a>
			  <?php } elseif (! $readonly) { ?>
			   <a class="nav-link" href="<?php echo $baseurl ?>?noupdate=1"><span data-feather="shopping-cart"></span>View Status<ALT="Switch to view only mode" TITLE="Switch to view only mode" BORDER=0></a>
			  <?php } else { echo "&nbsp;"; } ?>
            <a class="nav-link" href="#">
              
             
            
          </li>
          <li class="nav-item">
            <a class="nav-link dropdown-toggle" href="http://example.com/" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">PTO</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
				  <?php if ($ob->isEligible()) { ?>
					  <a class="dropdown-item" href="pto.php"><span data-feather="users"></span>PTO Request</a>
				  <?php } ?> 
					<a class="dropdown-item" href="approvePTO.php" target=_blank><span data-feather="users"></span>Approve PTO</a>
					<a class="dropdown-item" href="calendartest.php" target=_blank><span data-feather="users"></span>Calendar</a>
            </div>
          </li>
          <li class="nav-item">
			<?php if ($ob->isAdmin()) { ?>
			  <a class="nav-link" href="<?php echo $baseurl ?>?adminscreen=1"><span data-feather="bar-chart-2"></span>Admin</a>
			  <?php } ?>
            
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="layers"></span>
              Integrations
            </a>
          </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Saved reports</span>
          <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
            <span data-feather="plus-circle"></span>
          </a>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Current month
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Last quarter
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Social engagement
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Year-end sale
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <span class="navbar-text">
				   <div class="row no-gutters" ><h5><?php echo date($ob->getConfig('caldate_format')) ?>   </h5></div>
				   <div class="row no-gutters"><h5><?php echo date($ob->getConfig('time_format')) ?>   </h5></div>
   			  </span>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar"></span>
            This week
          </button>
        </div>
      </div>


<div class="table responsive">
<TABLE class="table table-striped table-sm">
<TR><TD CLASS=back>
<TABLE>
<thead><TH></TH><TH></TH><TH></TH><TH colspan=10>Will return by this time:</TH><TH></TH><TH>Business Hours: 8AM-5PM</TH></thead>
		
  <h2>Section title</h2>

        
     


<!--Main OutBoard table header-->
<!--<TABLE BORDER=0 WIDTH=100% ALIGN=CENTER>
<TR><TD CLASS=back>
<TABLE ID=outboard BORDER=0 WIDTH=95% ALIGN=CENTER>
<TR><TH></TH><TH></TH><TH></TH><TH colspan=10>Will return by this time:</TH><TH></TH><TH>Business Hours: 8AM-5PM</TH></TR>-->

<?php $header = "<TR><TH>Name</TH><TH>Core Hours</TH><TH>In</TH>
<TH>8</TH><TH>9</TH><TH>10</TH><TH>11</TH><TH>12</TH><TH>1</TH><TH>2</TH><TH>3</TH>
<TH>4</TH><TH>5</TH><TH>Out</TH><TH>Remarks</TH></TR>";
//echo $header;
?>

<?php

// Get the latest outboard information from the database
$ob->getData();

$rowcount = 0;
$zebra = 0;
$username = urlencode($username);

while($row = $ob->getRow()) {
  $isChangeable = $ob->isChangeable($row['userid']);
  $row['userid'] = urlencode($row['userid']);
  if (! preg_match("/<READONLY>/",$row['options'])) {
     $datetime = getdate($row['back']);
     if ($row['last_change'] != "") {
       list($uname,$ip) = explode(",",$row['last_change']);
       $lastup = "Last updated by $uname from $ip on " .  $row['timestamp'] . "";
       $alt = "ALT=\"$lastup\" TITLE=\"$lastup\"";
     } else {
       $alt = "";
     }
     $in = "<span data-feather=check-circle></span>";
     //$in = "<th style = 'background-color: #00FF00; height: '10px';'>";
     if ($datetime['year'] > $current['year']) {
       $out = "<span data-feather=x-circle></span>";
       if ($update && $isChangeable) {
	     $in= "<a href=\"$baseurl?in=1&userid=".$row['userid']."#".$row['userid']."\">"
	         ."<img src=$image_dir/$empty_image BORDER=0></a>";
       } else {
	     $in= "<img src=$image_dir/$empty_image>";
       }
     } else {
       if ($update && $isChangeable) {
	     $out= "<a href=\"$baseurl?out=1&userid=".$row['userid']."#".$row['userid']."\">"
		      ."<img src=$image_dir/$empty_image BORDER=0></a>";
       } else {
	     $out= "<img src=$image_dir/$empty_image>";
       }
     }
	 for ($i = 8; $i <= 17; $i++) {
		 if ( $datetime['hours'] == $i ) {
		   $back[$i] = "<span data-feather=circle></span>";
	 	  // $back[$i] = "<th style = 'background-color: #00FF00; height: '10px';'>";
		   if ($update && $isChangeable) {
			 $in= "<a href=\"$baseurl?in=1&userid=".$row['userid']."#".$row['userid']."\">"
			 ."<img src=$image_dir/$empty_image BORDER=0></a>";
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
		 $user_bg = "class=user";
	 }
     if ($rowcount % $ob->getConfig('reprint_header') == 0) { echo $header; }
     echo "<TR class=norm>";
     echo "<TD WIDTH=8% $user_bg><A class=\"nobr\" name=\"".$row['userid']."\">".$row['name']."</A></TD>";
	 echo "<TD WIDTH=12% $user_bg><A class=\"nobr\" name=\"".$row['userid']."\">".$row['hours']."</A></TD>";
     echo "<TD WIDTH=2% $user_bg>$in</TD>";
     echo "<TD WIDTH=2% $user_bg>".$back['8']."</TD>";
     echo "<TD WIDTH=2% $user_bg>".$back['9']."</TD>";
     echo "<TD WIDTH=2% $user_bg>".$back['10']."</TD>";
     echo "<TD WIDTH=2% $user_bg>".$back['11']."</TD>";
     echo "<TD WIDTH=2% $user_bg>".$back['12']."</TD>";
     echo "<TD WIDTH=2% $user_bg>".$back['13']."</TD>";
     echo "<TD WIDTH=2% $user_bg>".$back['14']."</TD>";
     echo "<TD WIDTH=2% $user_bg>".$back['15']."</TD>";
     echo "<TD WIDTH=2% $user_bg>".$back['16']."</TD>";
     echo "<TD WIDTH=2% $user_bg>".$back['17']."</TD>";
     echo "<TD WIDTH=2% $user_bg>$out</TD>";
     if ($row['remarks'] == "") {
       if ($update) {
	     $print_remarks = "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; "
			 ."&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; "
			 ."&nbsp; &nbsp; &nbsp; &nbsp;";
       } else {
	     $print_remarks = "&nbsp;";
       }
     } else {
       $visible = trim_visible($row['remarks'],$max_visible_length);
       if ($visible != $row['remarks']) {
	     $rem = $row['remarks'];
         $alt = "ALT=\"$rem\" TITLE=\"$rem\"";
	     $print_remarks = htmlspecialchars($visible)
	                  . "<img src=$image_dir/$right_arrow BORDER=0 $alt>";
       } else {
	     $print_remarks = htmlspecialchars($visible);
       }
     }
     if ($update && $isChangeable) {
       echo "<TD WIDTH=\"55%\" $user_bg><a href=\"javascript:this.change_remark('"
	    . addslashes(htmlspecialchars($row['remarks']))
	    . addslashes($row['remarks'])
	    . "','".$row['userid']."')\">$print_remarks</a></TD>";
     } else {
       echo "<TD WIDTH=\"55%\" $user_bg>$print_remarks</TD>";
     }
     echo "</TR>\n";
	 $rowcount++;
   } // end if
} // end while

?>
<TR><TH>Name</TH><TH>Hours</TH><TH>In</TH>
<TH>8</TH><TH>9</TH><TH>10</TH><TH>11</TH><TH>12</TH><TH>1</TH><TH>2</TH><TH>3</TH>
<TH>4</TH><TH>5</TH><TH>Out</TH><TH>Remarks</TH></TR>
<TR><TH><TH></TH></TH><TH></TH><TH colspan=10>Will return by this time:</TH><TH></TH><TH>Business Hours: 8AM-5PM</TH></TR>

</TABLE>
</TD></TR>
</TABLE>
</div>
		  
 </div>
    </div>



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="WSB/dashboard/jquery-3.2.1.slim.min.js.download" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="WSB/dashboard/popper.min.js.download"></script>
    <script src="WSB/dashboard/bootstrap.min.js.download"></script>

    <!-- Icons -->
    <script src="WSB/dashboard/feather.min.js.download"></script>
    <script>
      feather.replace()
    </script>


<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" preserveAspectRatio="none" style="display: none; visibility: hidden; position: absolute; top: -100%; left: -100%;"><defs><style type="text/css"></style></defs><text x="0" y="2" style="font-weight:bold;font-size:2pt;font-family:Arial, Helvetica, Open Sans, sans-serif">32x32</text></svg></body></html>
