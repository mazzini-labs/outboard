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
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/maintest.css?=v1.2">
<!--===============================================================================================-->
		<!-- Bootstrap core CSS -->
    <link href="WSB/stylesheet/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="WSB/stylesheet/offcanvas.css" rel="stylesheet">
	<link href="css/blog.css" rel="stylesheet">
<STYLE type="text/css">

.table-fixed tbody {
    height: 700px;
    overflow-y: auto;
    width: 100%;
}

.table-fixed thead,
.table-fixed tbody,
.table-fixed tr,
.table-fixed td,
.table-fixed th {
    display: block;
}

.table-fixed tbody td,
.table-fixed tbody th,
.table-fixed thead > tr > th {
    float: left;
    position: relative;

    &::after {
        content: '';
        clear: both;
        display: block;
    }
}


td.user {    

background-color: #3e94ec;
//color: ffffff;

  }
#outboard{
//  background-color: #3e94ec;
//  background-color: #6699cc;
  font-family: "Roboto", "Trebuchet MS", Arial, Helvetica, sans-serif;
  font-size: 14px;
  text-rendering: optimizeLegibility;
  border-collapse: collapse;
  border-left: 1px solid #3e94ec;
  border-radius: 30px;
  width: 100%;
  font-weight: normal;
  text-shadow: 0 1px 1px rgba(256, 256, 256, 0.1);
  box-shadow:  0 6px 20px 0 rgba(0, 0, 0, 0.19);
  text-align: left;
}

#outboard td, #outboard th {
  padding: 1px;
  border-style: solid;
  border-width: 0px 2px 0px 2px;
  border-color: #343a40;
  text-align: center;
}


#outboard tr:nth-child(even){background-color: #f0f0f0;}



#outboard th {
  padding-top: 12px;
  padding-bottom: 12px;

  background-color: #343a40;
  //border-radius: 8px;  
  color: white;
}

#header {
  font-family: Roboto, "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 70%;
	top:80;
}

#header {
  padding-top: 1px;
  padding-bottom: 1px;
  text-align: left;
  color: #000000;
}
 h1.thick {
 text-align: center;
 font-weight: bold;
}
div {
  display: flex;
  justify-content: flex-end;
  align-items: flex-end;
 }
.fixed-under-top{
	position:fixed;
	top:100;
	width:70%;
	/*right:-800;
	left:400;*/
	}
.table-collapse {
    position: fixed;
    top: 56px; /* Height of navbar */
    bottom: 0;
    width: 100%;
    padding-right: 1rem;
    padding-left: 1rem;
    overflow-y: auto;
    background-color: var(--gray-dark);
    transition: -webkit-transform .3s ease-in-out;
    transition: transform .3s ease-in-out;
    transition: transform .3s ease-in-out, -webkit-transform .3s ease-in-out;
    -webkit-transform: translateX(100%);
    transform: translateX(100%);
  }
.sticky-table {
  position: fixed;
  top: 0;
  width: 100%;
}

.sticky-table + .content {
  padding-top: 95px;
}
	
	.col-ob-2, .col-ob-8, .col-ob-12, .col-ob-20, .col-ob-24, .col-ob-55 {
  position: relative;
  width: 100%;
  min-height: 1px;
  padding-right: 15px;
  padding-left: 15px;
}
	.col-ob-2 {
  -ms-flex: 0 0 2%;
      flex: 0 0 2%;
  max-width: 2%;
}

.col-ob-8 {
  -ms-flex: 0 0 8%;
      flex: 0 0 8%;
  max-width: 8%;
}

.col-ob-12 {
  -ms-flex: 0 0 12%;
      flex: 0 0 12%;
  max-width: 12%;
}
.col-ob-20 {
  -ms-flex: 0 0 20%;
      flex: 0 0 20%;
  max-width: 20%;
}
.col-ob-24 {
  -ms-flex: 0 0 24%;
      flex: 0 0 24%;
  max-width: 24%;
}
.col-ob-55 {
  -ms-flex: 0 0 55%;
      flex: 0 0 55%;
  max-width: 55%;
}

</STYLE>
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

<!-- top of page header w/logo-->
<div class="limiter">
		<div class=container-outboard100>
<!-- buttons on top  -->
<nav class="navbar navbar-expand-md fixed-top navbar-dark bg-dark">
	 <?php if($ob->isReadonly()) { $readonly = true; } else { $readonly = false; }?>
 	 <?php if(getGetValue('noupdate')) $update = 0;?>
      <img class="navbar-brand" src="images/Flame.svg" width=3% height=auto></img>
      <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="vprsrv2/outboard.php">Outboard <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
			  <?php if ($ob->isAdmin()) { ?>
				  <a class="nav-link" href="tc.php" target=_blank>Timesheet</a>
				<?php } else { ?>
				  <a class="nav-link" href="tcfEmp.php" target=_blank>Timesheet</a>
				<?php } ?>
          </li>
          <li class="nav-item">
			  <?php if (! $update && ! $readonly) { ?>
			  <a class="nav-link" href="<?php echo $baseurl ?>?update=1#<?php echo $username ?>">Change Status<ALT="Switch to update mode" TITLE="Switch to update mode" BORDER=0></a>
			  <?php } elseif (! $readonly) { ?>
			   <a class="nav-link" href="<?php echo $baseurl ?>?noupdate=1">View Status<ALT="Switch to view only mode" TITLE="Switch to view only mode" BORDER=0></a>
			  <?php } else { echo "&nbsp;"; } ?>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="http://example.com/" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">PTO</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
				  <?php if ($ob->isEligible()) { ?>
					  <a class="dropdown-item" href="pto.php">PTO Request</a>
				  <?php } ?> 
					<a class="dropdown-item" href="approvePTO.php" target=_blank>Approve PTO</a>
					<a class="dropdown-item" href="calendartest.php" target=_blank>Calendar</a>
            </div>
          </li>
		 <li class="nav-item">
				  				<?php if ($ob->isAdmin()) { ?>
					  <a class="nav-link" href="<?php echo $baseurl ?>?adminscreen=1">Admin</a>
				  <?php } ?>
		  </li>
		<li class="nav-item">
			  <?php if ($ob->isE1() || $ob->isE2()) { ?>
           			 <a class="nav-link" href="WSB/">Well Status Board</a>
  			 <?php } ?>
          </li>
          <li class="nav-item">
			  <?php if (! $BasicAuthInUse) { ?>
           			 <a class="nav-link" href="<?php echo $baseurl ?>?logout=1">Log Out</a>
  			 <?php } ?>
          </li>
			
        </ul>
			  <span class="navbar-text">
				 
				   <div class="row no-gutters" ><h5><?php echo date($ob->getConfig('caldate_format')) ?>   </h5></div>
				   <div class="row no-gutters"><h5><?php echo date($ob->getConfig('time_format')) ?>   </h5></div>
				
				 
   			  </span>
		<!--<ul class="navbar-nav">
			<div class=container-fluid>
			<div class=row><div class=col><h4 class="nav-link active " ><?php echo date($ob->getConfig('caldate_format')) ?></h4></div></div>

			<div class=row><div class=col><h4 class="nav-link" ><?php echo date($ob->getConfig('time_format')) ?></h4></div></div>
			</div>
		</ul>
        -->
      </div>
		 
    </nav>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample08" aria-controls="navbarsExample08" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample08">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" aria-current="page" href="#">Centered nav only</a>
        </li>
		  <li class="nav-item active">
          <a class="nav-link" aria-current="page" href="#">Will return by this time:</a>
        </li>
		  <li class="nav-item active">
          <a class="nav-link" aria-current="page" href="#">Business Hours: 8AM - 5PM</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample08" aria-controls="navbarsExample08" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample08">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Centered nav only <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown08" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
        <div class="dropdown-menu" aria-labelledby="dropdown08">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
    </ul>
  </div>
</nav>

<header class="blog-header py-3">
    <div class="row flex-nowrap justify-content-between align-items-center">
      <div class="col-4 pt-1">
        <a class="text-muted" href="#">Subscribe</a>
      </div>
      <div class="col-4 text-center">
        <a class="blog-header-logo text-dark" href="#">Large</a>
      </div>
      <div class="col-4 d-flex justify-content-end align-items-center">
        <a class="text-muted" href="#" aria-label="Search">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="mx-3" role="img" viewBox="0 0 24 24" focusable="false"><title>Search</title><circle cx="10.5" cy="10.5" r="7.5"></circle><path d="M21 21l-5.2-5.2"></path></svg>
        </a>
        <a class="btn btn-sm btn-outline-secondary" href="#">Sign up</a>
      </div>
    </div>
  </header>

<div class="wrap-outboard100" >
<div class=container-fluid>


<?php  $header = "<div class=row>
	<div class=col-ob-8>Name</div>
	<div class=col-ob-12>Core Hours</div>
	<div class=col-ob-2>In</div>	
	<div class=col-ob-2>8</div>
	<div class=col-ob-2>9</div>
	<div class=col-ob-2>10</div>
	<div class=col-ob-2>11</div>
	<div class=col-ob-2>12</div>
	<div class=col-ob-2>1</div>
	<div class=col-ob-2>2</div>
	<div class=col-ob-2>3</div>
	<div class=col-ob-2>4</div>
	<div class=col-ob-2>5</div>
	<div class=col-ob-2>Out</div>
	<div class=col-ob-55>Remarks</div>
</div>
";
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
     $in = "<img src=$image_dir/$in_image $alt>";
     //$in = "<th style = 'background-color: #00FF00; height: '10px';'>";
     if ($datetime['year'] > $current['year']) {
       $out = "<img src=$image_dir/$out_image $alt>";
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
		   $back[$i] = "&ensp;<img src=$image_dir/$dot_image $alt>";
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
		$user_bg = "zebra".$zebra;
	 } else {
		$user_bg = "";
	 }
	 if ($row['userid'] == $username && $update && $isChangeable) {
		 $user_bg = "class=user";
	 }
     if ($rowcount % $ob->getConfig('reprint_header') == 0) { echo $header; }
     echo "<div class='row'>";
     echo "<div class='col-ob-8 $user_bg'><A class=\"nobr\" name=\"".$row['userid']."\">".$row['name']."</A></div>";
	 echo "<div class='col-ob-12 $user_bg'><A class=\"nobr\" name=\"".$row['userid']."\">".$row['hours']."</A></div>";
     echo "<div class='col-ob-2 $user_bg'>$in</div>";
     echo "<div class='col-ob-2 $user_bg'>".$back['8']."</div>";
     echo "<div class='col-ob-2 $user_bg'>".$back['9']."</div>";
     echo "<div class='col-ob-2 $user_bg'".$back['10']."</div>";
     echo "<div class='col-ob-2 $user_bg'".$back['11']."</div>";
     echo "<div class='col-ob-2 $user_bg'".$back['12']."</div>";
     echo "<div class='col-ob-2 $user_bg'".$back['13']."</div>";
     echo "<div class='col-ob-2 $user_bg'".$back['14']."</div>";
     echo "<div class='col-ob-2 $user_bg'".$back['15']."</div>";
     echo "<div class='col-ob-2 $user_bg'".$back['16']."</div>";
     echo "<div class='col-ob-2 $user_bg'".$back['17']."</div>";
     echo "<div class='col-ob-2 $user_bg'$out</div>";
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
       echo "<div class='col-ob-55 $user_bg'><a href=\"javascript:this.change_remark('"
	    . addslashes(htmlspecialchars($row['remarks']))
	    . addslashes($row['remarks'])
	    . "','".$row['userid']."')\">$print_remarks</a></div>";
     } else {
       echo "<div class='col-ob-55 $user_bg'>$print_remarks</div>";
     }
     echo "</TR>\n";
	 $rowcount++;
   } // end if
} // end while
//*/
?>
			

	</div>
</div>



			</div>
		</div>

 	<script src="WSB/stylesheet/jquery-3.2.1.slim.min.js.download" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="WSB/stylesheet/popper.min.js.download"></script>
    <script src="WSB/stylesheet/bootstrap.min.js.download"></script>
    <script src="WSB/stylesheet/holder.min.js.download"></script>
    <script src="WSB/stylesheet/offcanvas.js.download"></script>
  

<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" preserveAspectRatio="none" style="display: none; visibility: hidden; position: absolute; top: -100%; left: -100%;"><defs><style type="text/css"></style></defs><text x="0" y="2" style="font-weight:bold;font-size:2pt;font-family:Arial, Helvetica, Open Sans, sans-serif">32x32</text></svg></body></html>
