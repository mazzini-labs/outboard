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
    <link href="WSB/stylesheet/offcanvas.css?v1" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css?v=1"/>
 
    <script type="text/javascript" src="datatables/datatables.min.js"></script>
    <script type="text/javascript" src="datatables/editor.js"></script>
    <style>
  #container {
    position: relative;
    width: 600px;
    height: 400px;
  }
</style>

<STYLE type="text/css">
  /* body {
    overflow: hidden; /* Hide scrollbars */
  /* } */ 
  /* .table-fixed tbody {
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
  } */

  /* body {
    padding-top: 56px;
  } */
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
    
    border-style: solid;
    border-width: 0px 2px 0px 2px;
    border-color: #343a40;
    text-align: center;
  }


  #outboard tr:nth-child(even){background-color: #f0f0f0;}
  #outboard tr:nth-child(odd){background-color: #ffffff;}



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

  .fixed-under-top{
    /* position:fixed; */
    top:100;
    
    /* width:70%; */
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
    /* position: fixed; */
    top: 25%;
    width: 100%;
  }

  .sticky-table + .content {
    padding-top: 95px;
  }
    
    .col-ob-2, .col-ob-8, .col-ob-12, .col-ob-55 {
    position: relative;
    
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

  .col-ob-55 {
    -ms-flex: 0 0 55%;
        flex: 0 0 55%;
    max-width: 55%;
  }
  .wrap-extensions {
      /* width: 70%; */
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      display: -webkit-box;
      display: -webkit-flex;
      display: -moz-box;
      display: -ms-flexbox;
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      
      /* justify-content: space-between; */
    
      padding: 50px 33px 33px 95px;
  }
  .active-white2 input.form-control[type=text]:focus:not([readonly]) {
                background-color: rgba(0,0,0,0)!important;
                border-bottom: 1px solid #fff!important;
                box-shadow: 0 1px 0 0 #fff!important;
                border-radius: 0!important;
                border: 0 0 0 1px!important;
                border-right-color: rgba(0,0,0,0)!important;
                border-left-color: rgba(0,0,0,0)!important;
                border-top-color: rgba(0,0,0,0)!important;
              }
  .active-white input.form-control[type=text] {
      background-color: rgba(0,0,0,0)!important;
                border-bottom: 1px solid #fff!important;
                box-shadow: 0 1px 0 0 #fff!important;
                border-radius: 0!important;
                border-right-color: rgba(0,0,0,0)!important;
                border-left-color: rgba(0,0,0,0)!important;
                border-top-color: rgba(0,0,0,0)!important;
  }
  .active-white-2 input[type=text]:focus:not([readonly]) {
      background-color: rgba(0,0,0,0)!important;
                border-bottom: 1px solid #fff!important;
                box-shadow: 0 1px 0 0 #fff!important;
                color: #fff!important;
              }
  .active-white input[type=text] {
      background-color: rgba(0,0,0,0)!important;
      
                border-bottom: 1px solid #fff!important;
                box-shadow: 0 1px 0 0 #fff!important;
                color: #fff!important;
  }
  .active-white .fa, .active-white-2 .fa {
                color: #fff!important;
              }
              
  .active-white input.form-control[type=text]::-ms-input-placeholder { /* Most modern browsers support this now. */
    color:    #f0f0f0;
  }
  .active-white input.form-control[type=text]::-webkit-input-placeholder { /* Most modern browsers support this now. */
    color:    #f0f0f0;
  }
  .active-white input.form-control[type=text]::placeholder { /* Most modern browsers support this now. */
    color:    #f0f0f0;
  }
  .active-white input.form-control[type=text]:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
    color:    #f0f0f0;
    opacity:  1;
  }
  .active-white input.form-control[type=text]::-moz-placeholder { /* Mozilla Firefox 19+ */
    color:    #f0f0f0;
    opacity:  1;
  }
  .active-white input.form-control[type=text]:-ms-input-placeholder { /* Internet Explorer 10-11 */
    color:    #f0f0f0;
  }
  .active-white2 input.form-control[type=text]:focus:not([readonly])::-ms-input-placeholder { /* Most modern browsers support this now. */
    color:    #fff;
  }
  .active-white2 input.form-control[type=text]:focus:not([readonly])::-webkit-input-placeholder { /* Most modern browsers support this now. */
    color:    #fff;
  }
  .active-white2 input.form-control[type=text]:focus:not([readonly])::placeholder { /* Most modern browsers support this now. */
    color:    #fff;
  }
  .active-white2 input.form-control[type=text]:focus:not([readonly]):-moz-placeholder { /* Mozilla Firefox 4 to 18 */
    color:    #fff;
    opacity:  1;
  }
  .active-white2 input.form-control[type=text]:focus:not([readonly])::-moz-placeholder { /* Mozilla Firefox 19+ */
    color:    #fff;
    opacity:  1;
  }
  .active-white2 input.form-control[type=text]:focus:not([readonly]):-ms-input-placeholder { /* Internet Explorer 10-11 */
    color:    #fff;
  }
  ::-ms-input-placeholder { /* Most modern browsers support this now. */
    color:    #fff;
  }
  ::-webkit-input-placeholder { /* Most modern browsers support this now. */
    color:    #fff;
  }
  ::placeholder { /* Most modern browsers support this now. */
    color:    #fff;
  }
  :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
    color:    #fff;
    opacity:  1;
  }
  ::-moz-placeholder { /* Mozilla Firefox 19+ */
    color:    #fff;
    opacity:  1;
  }
  :-ms-input-placeholder { /* Internet Explorer 10-11 */
    color:    #fff;
  }
</STYLE>
	</HEAD>
<BODY>

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
        var editor;
        // $.noConflict();
        $(document).ready(function() {
          var api = "42-077-33876";
          var sheet = "ddr2015pres";
           var oTable = $('#table').DataTable( {
                    // "processing" : true,
                    // "serverSide" : true,
                    "ajax": {
                      "url" : "ajax/ddrtest.php",
                      // "type" : "POST",
                      "data": {
                        "api": api,
                        "sheet": sheet
                      }
                    },
                    
                    "order": [],
                    "paging": false,
                    "info": false,
                    "searching": true,
                    "sDom": 'd',
                    "autoWidth": false,
                    "columns": [
                        {
                        "data": "a", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "b", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "c", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "d", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "e", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "f", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "g", // can be null or undefined
                        "defaultContent": ""
                        },
                        /* {
                        "data": "h", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "i", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "j", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "k", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "l", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "m", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "n", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "o", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "p", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "q", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "r", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "s", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "t", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "u", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "v", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "w", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "x", // can be null or undefined
                        "defaultContent": ""
                        } */
                    ]
            } );
            /* editor = new $.fn.DataTable.Editor( {
  "ajax": {
                      "url" : "ajax/ddrtest.php",
                      // "type" : "POST",
                      "data": {
                        "api": api,
                        "sheet": sheet
                      }
                    },
        table: "#example",
        fields: [ {
                label: "First name:",
                name: "first_name"
            }, {
                label: "Last name:",
                name: "last_name"
            }, {
                label: "Position:",
                name: "position"
            }, {
                label: "Office:",
                name: "office"
            }, {
                label: "Extension:",
                name: "extn",
                multiEditable: false
            }, {
                label: "Start date:",
                name: "start_date",
                type: "datetime"
            }, {
                label: "Salary:",
                name: "salary"
            }
        ]
    } );
 
    $('#example').DataTable( {
        dom: "Bfrtip",
        "ajax": {
                      "url" : "ajax/ddrtest.php",
                      // "type" : "POST",
                      "data": {
                        "api": api,
                        "sheet": sheet
                      }
                    },
        columns: [
            { data: null, render: function ( data, type, row ) {
                // Combine the first and last names into a single table field
                return data.first_name+' '+data.last_name;
            } },
            { data: "position" },
            { data: "office" },
            { data: "extn" },
            { data: "start_date" },
            { data: "salary", render: $.fn.dataTable.render.number( ',', '.', 0, '$' ) }
        ],
        select: true,
        buttons: [
            { extend: "create", editor: editor },
            { extend: "edit",   editor: editor },
            { extend: "remove", editor: editor }
        ]
    } );*/
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

<?php include("header_extensions.php"); ?>
		<div class=container-outboard100>



<div class='wrap-extensions pt-5'>
<main role="main" class="pt-5">
<!-- <TABLE id="table" class="datatables display"> -->
<input type="hidden" id="sheet" value="ddr2015pres">
<table id="table" class='table table-striped table-borderless table-sm ' style="background-color: white !important; margin-top: 0px !important;" >
            <thead class="table-dark">
                <tr>
                  <th class="table-header">Date</th>
                  <th class="table-header">Time</th>
                  <th class="table-header">Vendor/Contact</th>
                  <th class="table-header">Invoice #/Contact Info</th>
                  <th class="table-header">Invoice Details/DDR</th>
                  <th class="table-header">$/EDC</th>
                  <th class="table-header">Approvals/ECC</th>
                  <!-- <th class="table-header">H</th>
                  <th class="table-header">I</th>
                  <th class="table-header">J</th>
                  <th class="table-header">K</th>
                  <th class="table-header">L</th>
                  <th class="table-header">M</th>
                  <th class="table-header">N</th>
                  <th class="table-header">O</th>
                  <th class="table-header">P</th>
                  <th class="table-header">Q</th>
                  <th class="table-header">R</th>
                  <th class="table-header">S</th>
                  <th class="table-header">T</th>
                  <th class="table-header">U</th>
                  <th class="table-header">V</th>
                  <th class="table-header">W</th>
                  <th class="table-header">X</th> -->
                </tr>
            </thead>
            </table>
    </main>
</div>
			</div>
		</div>

 	<!-- <script src="WSB/stylesheet/jquery-3.2.1.slim.min.js.download" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <!-- <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script> -->
    <!-- <script src="WSB/stylesheet/popper.min.js.download"></script> -->
    <!-- <script src="WSB/stylesheet/bootstrap.min.js.download"></script> -->
    <!-- <script src="WSB/stylesheet/holder.min.js.download"></script> -->
    <!-- <script src="WSB/stylesheet/offcanvas.js.download"></script> -->
  

<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" preserveAspectRatio="none" style="display: none; visibility: hidden; position: absolute; top: -100%; left: -100%;"><defs><style type="text/css"></style></defs><text x="0" y="2" style="font-weight:bold;font-size:2pt;font-family:Arial, Helvetica, Open Sans, sans-serif">32x32</text></svg></body></html>
