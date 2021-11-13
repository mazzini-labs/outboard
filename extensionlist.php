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
    <TITLE>OutBoard: <?php echo $ob->getConfig('board_title') ?></TITLE> 
    <?php include 'dependencies.php'; ?>

    <style>
  #container {
    position: relative;
    width: 600px;
    height: 400px;
  }
</style>

<STYLE type="text/css">

.wrap-extensions1 {
    /* width: 70%; */
    background: #fff;
    border-radius: 10px;
    /* overflow: hidden; */
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-box;
    display: -ms-flexbox;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    
    /* justify-content: space-between; */
   
    padding: 33px 33px 33px 33px;
}

</STYLE>
	</HEAD>
<BODY style="background-color: #0e5092;">

<Script language="JavaScript1.2">
  function change_remark(remark,userid) {
    var newremark = prompt("Enter your remarks below:");
    if (newremark != null) {
      self.location="<?php echo $baseurl ?>?remarks="
		    + escape(newremark) + "&userid=" +userid + "#<?php echo $userid ?>";
    }
  }
  
</Script>
<script type="text/javascript" class="init">
        // $.noConflict();
        $(document).ready(function() {
            var oTable = $('#table').DataTable( {
                    "ajax": "ajax/extension.php",
                    "order": [],
                    "paging": true,
                    "info": false,
                    "searching": true,
                    "sDom": 't',
                    deferRender: true,
                    scrollY: "60vh",
                    scroller: true,
                    "autoWidth": false,
                    "columns": [
                        {
                        "data": "name", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "title", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "extension", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "email", // can be null or undefined
                        "defaultContent": ""
                        }
                    ]
            } );
            var mTable = $('#misc').DataTable( {
                    "ajax": "ajax/misc_ext.php",
                    "order": [],
                    "paging": false,
                    "info": false,
                    "searching": true,
                    "sDom": 'd',
                    "autoWidth": false,
                    "columns": [
                        {
                        "data": "misc", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "extension_or_other", // can be null or undefined
                        "defaultContent": ""
                        }
                    ]
            } );
            var iTable = $('#ca').DataTable( {
                    "ajax": "ajax/commonarea.php",
                    "order": [],
                    "paging": false,
                    "info": false,
                    "searching": true,
                    "sDom": 'd',
                    "autoWidth": false,
                    "columns": [
                        {
                        "data": "common_area", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "extension", // can be null or undefined
                        "defaultContent": ""
                        }
                    ]
            } );
            var eTable = $('#800').DataTable( {
                    "ajax": "ajax/phone_800_numbers.php",
                    "order": [],
                    "paging": false,
                    "info": false,
                    "searching": true,
                    "sDom": 'd',
                    "autoWidth": false,
                    "columns": [
                        {
                        "data": "company", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "phone", // can be null or undefined
                        "defaultContent": ""
                        }
                    ]
            } );
       
            
            $('#searchProduction').keyup(function(){
                oTable.search($(this).val()).draw() ;
                mTable.search($(this).val()).draw() ;
                iTable.search($(this).val()).draw() ;
                eTable.search($(this).val()).draw() ;
            })
            //$('#productionTable_filter').DataTable.search();
        } );
            
        
    </script>
<!-- top of page header w/logo-->
<div class="limiter">

   
    
    <!-- Modal --><!--TODO: Code Javascript to make modal work-->
<!-- buttons on top  -->

<?php include("include/header_extensions.php"); ?>
		<div class="container-fluid">


<div class="col-12">
<div class="row justify-content-center">
<!-- <main role="main" class="row justify-content-center" > -->
<!-- <TABLE id="table" class="datatables display"> -->
<!-- <div class="row"> -->
    <div class="col-6 m-2 p-3 shadow-lg card-body bg-light">
        <table id="table" class='table table-striped table-hover table-borderless table-sm smol' style="background-color: white !important; margin-top: 0px !important;" >
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Title</th>
                    <th>Extension</th>
                    <th>Email</th>
                </tr>
            </thead>
            </table>
    </div>
    <div class="col-5 ">
      <!-- <div class="row"> -->
      <div class="m-2 p-3 shadow-lg card-body bg-light">
        <!-- <div class="card-body"> -->
        <table id="misc" class='table table-striped table-borderless table-sm text-center smol' style="vertical-align: top!important; background-color: white !important; margin-top: 0px !important;" >
            <thead class="table-dark">
                <td class="text-center"><strong>Company</strong></td>
                <td class="text-center"><strong>Contact</strong></td>
            </thead>
        </table>
      <!-- </div> -->
      <!-- </div> -->
      </div>
      <br>
    <!-- <div class="row"> -->
    <div class="m-2 p-3 shadow-lg card-body bg-light">
        <!-- <div class="card-body"> -->
      <table id="ca" class='table table-striped table-borderless table-sm text-center  smol' style="vertical-align: top!important; background-color: white !important; margin-top: 0px !important;" >
        <thead class="table-dark" >
              <td class="text-center"><strong>Common Area Location</strong></td>
              
              <td class="text-center"><strong>Ext.</strong></td>
              
        </thead>

      </table>
      <!-- </div> -->
      <!-- </div> -->
      </div>
      <!-- <br> -->
    <!-- <div class="row"> -->
    <!-- <div class="card"> -->
        
    </table>
    </div>
    
    </div>
    <!-- </main> -->
    <!-- </div> -->
    <div class="row justify-content-center">
    <div class="col-11 m-3 p-3 shadow-lg card-body bg-light">
    <table id="800" class='table table-striped table-borderless table-sm text-center smol' style="vertical-align: top!important; background-color: white !important; margin-top: 0px !important;" >
      <thead class="table-dark">
        <!-- <th>Company</th>
        <th>800 Number</th> -->
        <td class="text-center"><strong>Company</strong></td>
            
            <td class="text-center"><strong>800 Phone Number</strong></td>
      </thead>
   
    </table>
    </div>
    </div>
    <!-- </div> -->


			</div>
    </div>
    <script> feather.replace(); </script>
      </body>
      </html>