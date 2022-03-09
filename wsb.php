<?php

require_once("lib/OutboardDatabase.php");
require_once("lib/OutboardAuth.php");

//include_once("include/char_widths.php");
include_once("include/common.php");

include 'include/variables.php';

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
include 'include/wsbFunctions.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = connect_db();


?>
<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>WSB</title>
    <?php include 'include/dependencies.php'; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/trumbowyg.min.js" integrity="sha512-sffB9/tXFFTwradcJHhojkhmrCj0hWeaz8M05Aaap5/vlYBfLx5Y7woKi6y0NrqVNgben6OIANTGGlojPTQGEw==" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/cleanpaste/trumbowyg.cleanpaste.min.js" integrity="sha512-y7o2DGiZAj5/HOX10rSG1zuIq86mFfnqbus0AASAG1oU2WaF2OGwmkt2XsgJ3oYxJ69luyG7iKlQQ6wlZeV3KQ==" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/colors/trumbowyg.colors.min.js" integrity="sha512-iT7g30i1//3OBZsfoc5XmlULnKQKyxir582Z9fIFWI6+ohfrTdns118QYhCTt0d09aRGcE7IRvCFjw2wngaqRQ==" crossorigin="anonymous"></script>
            <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/highlight/trumbowyg.highlight.min.js" integrity="sha512-WqcaEGy8Pv/jIWsXE5a2T/RMO81LN12aGxFQl0ew50NAUQUiX9bNKEpLzwYxn+Ez1TaBBJf+23OX+K4KBcf6wg==" crossorigin="anonymous"></script> -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/history/trumbowyg.history.min.js" integrity="sha512-hvFEVvJ24BqT/WkRrbXdgbyvzMngskW3ROm8NB7sxJH6P4AEN77UexzW3Re5CigIAn2RZr8M6vQloD/JHtwB9A==" crossorigin="anonymous"></script>
            <!-- <script src="/assets/js/tinymce/tinymce.min.js?v1"></script> -->
    <!-- <script src="/assets/js/tinymce/jquery.tinymce.min.js"></script> -->
    <!-- <script type="text/javascript" class="init" src="/assets/js/datatables.wsb.js?v1.0.0.23"></script> -->
    <script type="text/javascript" src="/assets/js/datatables.wsb.prod_data.js?v=1.0.3.93"></script>
    <!-- <script src="/assets/js/wsb.ddr.js?v1.0.0.14"></script> -->
</head>
<style> .daily { display: none; } </style>
<body class="bg-light">
<?php  include 'include/header_extensions.php' ?>
<div class=' '>      
    <main role="main" class="">
        <nav class="nav-scroller bg-white shadow-sm nav-underline" style="height: auto; ">
            <ul class="nav justify-content-center" id="myTab" role="tablist" style="position: relative; z-index: 940; padding-bottom:0px;">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="monthly-tab" data-toggle="tab" href="#home" role="tab" aria-controls="monthly" aria-selected="true">Monthly Production </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="latest-tab" data-toggle="tab" href="#latest" role="tab" aria-controls="latest" aria-selected="true">Latest Daily Production [TESTING]</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="shutin-tab" data-toggle="tab" href="#shutin" role="tab" aria-controls="shutin" aria-selected="false">Shut In Well Notes</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="print-tab" data-toggle="tab" href="#print" role="tab" aria-controls="print" aria-selected="false">Print Prod. Review Meeting Notes</a>
                </li>
            </ul> 
            </nav>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade" id="latest" role="tabpanel" aria-labelledby="latest-tab" style="position: relative; z-index: 940;"> 
                    <table id="latestTable" class='table table-striped table-borderless smol display' style="margin-top: 0px !important;" >
                        <thead class="bg-sog">
                            
                                <th >Well</th>
                                <th >Status</a></th>
                                <th >Production As Of</a></th>
                                
                                <th >Gas</th>
                                <th >Oil</th>
                                <th >Water</th>
                                <th >Report Frequency</th>
                                <th >Updated</a></th>
                            
                        </thead>
                    </table>
                </div>
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="monthly-tab" style="position: relative; z-index: 940;"> 
                    <table id="productionTable" class='table table-striped table-borderless smol display' style="margin-top: 0px !important;" >
                        <thead class="bg-sog">
                            
                                <th >Well</th>
                                <th >ST</th>
                                <th >County</a></th>
                                <th >Block</a></th>
                                <th >Entity</a></th>
                                <th >Status</a></th>
                                <th >Type</a></th>
                                <th >Production As Of</a></th>
                                
                                <th >Gas</th>
                                <th >Oil</th>
                                <th >Water</th>
                                
                                <th >Loss</a></th>
                                <th >Pumper</a></th>
                                <th >Notes</th>
                                <th >Updated</a></th>
                            
                        </thead>
                    </table>
                </div>
                <div class="tab-pane fade " id="shutin" role="tabpanel" aria-labelledby="shutin-tab" style="position: relative; z-index: 940;">
                    <table id="shutinTable" class='table table-striped table-borderless datatable-tab-correct datatable-tab-correct1 smol' style="margin-top: 0px !important;" >
                        <thead class="bg-sog">
                                <th >Well</th>
                                <th >ST</th>
                                <th >County</a></th>
                                <th >Block</a></th>
                                <th >Entity</a></th>
                                <th >Shut-In Notes</th>
                                <th >Last Updated</th>
                        </thead>
                    </table>
                </div>
                <div class="tab-pane fade " id="print" role="tabpanel" aria-labelledby="print-tab" style="position: relative; z-index: 940;">
                    <table id="printTable" class='table table-striped table-borderless datatable-tab-correct datatable-tab-correct1 smol' style="margin-top: 0px !important;" >
                        <thead class="bg-sog">
                                <th >Well</th><th >Pumper</th><th >Status/Production</th> <th >Notes</th><th >Last Updated</th>
                                
                               
                        </thead>
                    </table>
                </div>
            </div>
	</main>
    <?php 
    include 'include/floating_action_button.php';
    include 'modals/ddr_add_modal.php'; 
    include 'include/ddr_datepicker.php'; 
    include 'modals/well_entry_modal.php';
    include 'modals/dsr_add_modal.php';
    include 'modals/prod_add_latest_modal.php';
    ?>
</div>

</body>
<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>   
<script src="/assets/js/bottom_scripts.js?v1.0.0.1"></script>

</html>


