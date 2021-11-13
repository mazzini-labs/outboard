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
    <?php include 'dependencies.php'; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/trumbowyg.min.js" integrity="sha512-sffB9/tXFFTwradcJHhojkhmrCj0hWeaz8M05Aaap5/vlYBfLx5Y7woKi6y0NrqVNgben6OIANTGGlojPTQGEw==" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/cleanpaste/trumbowyg.cleanpaste.min.js" integrity="sha512-y7o2DGiZAj5/HOX10rSG1zuIq86mFfnqbus0AASAG1oU2WaF2OGwmkt2XsgJ3oYxJ69luyG7iKlQQ6wlZeV3KQ==" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/colors/trumbowyg.colors.min.js" integrity="sha512-iT7g30i1//3OBZsfoc5XmlULnKQKyxir582Z9fIFWI6+ohfrTdns118QYhCTt0d09aRGcE7IRvCFjw2wngaqRQ==" crossorigin="anonymous"></script>
            <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/highlight/trumbowyg.highlight.min.js" integrity="sha512-WqcaEGy8Pv/jIWsXE5a2T/RMO81LN12aGxFQl0ew50NAUQUiX9bNKEpLzwYxn+Ez1TaBBJf+23OX+K4KBcf6wg==" crossorigin="anonymous"></script> -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/history/trumbowyg.history.min.js" integrity="sha512-hvFEVvJ24BqT/WkRrbXdgbyvzMngskW3ROm8NB7sxJH6P4AEN77UexzW3Re5CigIAn2RZr8M6vQloD/JHtwB9A==" crossorigin="anonymous"></script>
            <script src="/js/tinymce/tinymce.min.js?v1"></script>
    <script src="/js/tinymce/jquery.tinymce.min.js"></script>
    <!-- <script type="text/javascript" class="init" src="/js/datatables.wsb.js?v1.0.0.23"></script> -->
    <script type="text/javascript" src="js/datatables.wsb.prod_data.js?v=1.0.3.37"></script>
    <!-- <script src="/js/wsb.ddr.js?v1.0.0.14"></script> -->
</head>

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
                    <a class="nav-link" id="daily-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="daily" aria-selected="false">Average Daily Production</a>
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
                <div class="tab-pane fade " id="profile" role="tabpanel" aria-labelledby="daily-tab" style="position: relative; z-index: 940;">
                    <!-- <table><tr><td><small>test</small></td></tr><hr><tr><td style="border-top: 1px solid #9ba0a5;"><small>day</small></td></tr></table> -->
                    <table id="productionTable1" class='table table-striped table-borderless datatable-tab-correct datatable-tab-correct1 smol' style="margin-top: 0px !important;" >
                        <thead class="bg-sog">
                                <th >Well</th>
                                <th >ST</th>
                                <th >County</a></th>
                                <th >Block</a></th>
                                <th >Entity</a></th>
                                <th >Status</a></th>
                                <th >Prod</a></th>
                                <th >Active</a></th>
                                
                                <th >Gas</th>
                                <th >Oil</th>
                                <th >Water</th>
                                
                                <th >Loss</a></th>
                                <th >Pumper</a></th>
                                <th >Notes</th>
                                <th >Last Updated</a></th>
                        </thead>
                        <!-- <?php 
                        /*     $conn = connect_db();
                            $results = mysqli_query($conn, $query);
                            $num_records = mysqli_num_rows($results); 
                            mysqli_close($conn);
                                // print the contents of the table
                                echo "<tbody >\n";
                            while($row = $results -> fetch_assoc())
                            //for ($i = $_GET['start']; $i < $_GET['end']; $i++)
                            {
                                $well_api = $row['api'];
                                $well_lease = $row['well_lease'];
                                $well_number = $row['well_no'];
                                //$wellname = $well_lease . " " . $well_number;
                                $wellname = $row['entity_common_name'];
                                $state = $row['state'];
                                $county = $row['county_parish'];
                                $block = $row['block'];
                                $compname = $row['entity_operator_code'];
                                $wellstatus = $row['producing_status'];
                                $productiontype = $row['production_type'];
                                $actiondate = $row['last_prod_date'];
                                $dayson = $row['days_on'];
                                $gassold = $row['gas_sold'];
                                $cur_prod_gas = $gassold;
                                $cur_prod_oil = $row['oil_prod'];
                                $cur_prod_water = $row['water_prod'];
                                if(!$dayson == 0){
                                $avg_prod_gas = $cur_prod_gas / $dayson;
                                $avg_prod_oil = $cur_prod_oil / $dayson;
                                $avg_prod_water = $cur_prod_water / $dayson; 
                                } else {
                                    $avg_prod_gas = 0;
                                    $avg_prod_oil = 0;
                                    $avg_prod_water = 0; 
                                }
                                $lineloss = $row['gas_line_loss'];	
                                $pumper = $row['pumper'];
                                $wellcheck = $row['report_frequency'];
                                $notes = $row['notes'];
                                $notes_updated = $row['notes_update'];
                                $datetime = new DateTime($notes_updated);
                                $last_updated = $datetime->format('Y-m-d');
                                //$priority = mysql_result($results, $i, "priority");
                                

                                if($wellstatus == 'Shut-in' || $wellstatus == 'Shut-In' || $wellstatus == 'INACTIVE'){
                                    //$status = "style='color:red;'><small";
                                    $status = "style='background-color: #F08080;' $width2><small";
                                    $boldTagStart = "<strong>";
                                    $boldTagEnd = "</strong>";
                                }else{
                                    $status = "$width2><small";
                                    $boldTagStart = "";
                                    $boldTagEnd = "";
                                }
                                

                                echo "<tr>\n";
                                echo "<td $width7><small><a href='prod_data.php?api=$well_api'>$wellname - $well_api</td ></small>\n";
                                echo "<td $width2><small>$state</td ></small>\n";
                                echo "<td $width4><small>$county</a></td ></small>\n";
                                echo "<td $width2><small>$block</td ></small>\n";
                                echo "<td $width2><small>$compname</td ></small>\n";
                                echo "<td $status>$wellstatus</td ></small>\n";
                                echo "<td $width2><small>$productiontype</td ></small>\n";
                                echo "<td $width2><small>$actiondate</td ></small>\n";
                                echo "<td $width1><small>". truncate($avg_prod_gas) ." <sup>mcf</sup>/<sub>day</sub></small></td>\n";
                                echo "<td $width1><small>". truncate($avg_prod_oil) ." <sup>bbl</sup>/<sub>day</sub></small></td>\n";
                                echo "<td $width1><small>". truncate($avg_prod_water) ." <sup>bbl</sup>/<sub>day</sub></small></td>\n";
                                
                                echo "<td $width2><small>". truncate($lineloss) ." mcf</small></td>\n";
                                echo "<td $width2><small>$pumper</small></td >\n";
                                echo "<td $width14><small>$boldTagStart $notes $boldTagEnd</small> </td >\n";
                                echo "<td $width3><small>$last_updated</small></td >\n";
                                echo "</tr>\n"; 

                                
                                
                            }
                            echo "</tbody>\n";
                             */
                            ?> -->
                    
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
    ?>
</div>

</body>
<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>   
<script src="/js/bottom_scripts.js?v1.0.0.1"></script>

</html>


