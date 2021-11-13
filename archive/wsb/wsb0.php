<?php

require_once("lib/OutboardDatabase.php");
require_once("lib/OutboardAuth.php");

//include_once("include/char_widths.php");
include_once("include/common.php");

// Create main objects;
$auth = new OutboardAuth();
$ob   = new OutboardDatabase();

// Set some simple variables used later in the page
$baseurl             = $_SERVER['PHP_SELF'];
$current             = getdate();

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
########## This crashes the browser!!!! Do not implement until cause is figured out. 
/* // Show the login screen if the user is not authenticated
if (! $username) {
  $auth->setSessionCookie("",$cookie_time_seconds);
  header("Location: outboard.php"); 
}

// if 'logout' is set, run the logout functions and go back
// to the login screen.
if (getGetValue('logout')) {
  $ob->setSession("");
  $auth->setSessionCookie("",$cookie_time_seconds);
  header("Location: outboard.php"); 
} */
##########

############# LOGGING ###############################
function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
############# LOGGING ###############################
?>
<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>

	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/maintest.css?=v1.2">
	<!-- Bootstrap core CSS -->
    <!-- <link href="WSB/stylesheet/bootstrap.min.css" rel="stylesheet"> -->
    <!-- Custom styles for this template -->
	<link href="WSB/stylesheet/offcanvas.css" rel="stylesheet">
    <title>WSB</title>
    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
 
    <script type="text/javascript" src="datatables/datatables.min.js"></script>
    <!-- <script type="text/javascript" src="datatables/FixedHeader-3.1.7/js/fixedHeader.bootstrap4.min.js"></script> -->
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/dt-1.10.21/af-2.3.5/b-1.6.2/b-colvis-1.6.2/b-print-1.6.2/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.4/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.0/sl-1.3.1/datatables.min.css"/>
 
   <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/dt-1.10.21/af-2.3.5/b-1.6.2/b-colvis-1.6.2/b-print-1.6.2/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.4/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.0/sl-1.3.1/datatables.min.js"></script> -->
     <!--     <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css"> -->
        <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
        <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
            <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>

        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script> -->
        
       
    <script type="text/javascript" src="vendor/slim-scroll-1.3.3/dist/slimscroll.js"></script>
    <script type="text/javascript" class="init">
        // $.noConflict();
        $(document).ready(function() {
            /* $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
                $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
            } );
            
            $('table.table').DataTable( {
                // ajax:           'ajax/curProd.php',
                scrollY:        200,
                scrollCollapse: true,
                paging:         false
            } );
        
            // Apply a search to the second table for the demo
            $('#myTable2').DataTable().search( 'New York' ).draw(); */
            var oTable = $('#productionTable').DataTable( {
                    "order": [],
                    "paging": false,
                    "info": false,
                    "searching": true,
                    "sDom": 'd'
            } );
            $('#searchProduction').keyup(function(){
                oTable.search($(this).val()).draw() ;
            })
            
        } );
    </script>
    
</head>

<style>
body {
  overflow: hidden; /* Hide scrollbars */
}  
/* thead {position: -webkit-sticky; position: sticky; top: 0px; z-index: 100;} */
/* /* thead {width: 100%; display: inline-table; height: auto; table-layout: fixed;} */
tr {
width: 100%;
display: inline-table;
height:auto;
table-layout: fixed;
  
}

table{
 height:0%; 
 display: -moz-groupbox;
 overflow: hidden;
}
tbody{
  overflow-y: scroll;
  height: 79vh;
  width: auto;
  position: absolute;
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
</style>
<body>

<?php 
include 'include/wsbFunctions.php';
include 'header.php';
?>
    <div class="ajaxDiv">
    <br><br>  
    <a class="btn btn-primary" onClick="ajaxSelect('current.php')">Current Production</a></div>
</body>
<!-- <script src="WSB/dashboard/popper.min.js.download"></script> -->
<!-- <script src="WSB/dashboard/bootstrap.min.js.download"></script> -->

<!-- Icons -->
<script src="WSB/dashboard/feather.min.js.download"></script>
<script>
    feather.replace()
</script>   
<!-- <script src="WSB/stylesheet/holder.min.js.download"></script> -->
<!-- <script src="WSB/stylesheet/offcanvas.js.download"></script> -->
<script>
function ajaxSelect(page){
var ajaxRequest;  // The variable that makes Ajax possible!
try { ajaxRequest = new XMLHttpRequest();// Opera 8.0+, Firefox, Safari
}catch (e) {// Internet Explorer Browsers
    try { ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
    }catch (e) { try{
        ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
        }catch (e){ // Something went wrong
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

var queryString = page;


        ajaxRequest.open("GET", queryString, true);
        ajaxRequest.send(null); 
    
}
</script>
</html>
