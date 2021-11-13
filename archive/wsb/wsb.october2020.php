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
    <title>WSB</title>
    <?php include 'dependencies.php'; ?>
    <!-- <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>

	<link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/maintest.css?=v1.0.0.0">
    <link rel="stylesheet" type="text/css" href="css/tabs.css?v=1.0.0.0">
    <link rel="stylesheet" type="text/css" href="css/search.css">
	<link href="WSB/stylesheet/offcanvas.css?v=1.0.0.4" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/dt-1.10.21/af-2.3.5/b-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/dt-1.10.21/af-2.3.5/b-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.js"></script> -->
    <script type="text/javascript" class="init" src="/js/datatables.wsb.js"></script>
    <script src="/js/ddr.js"></script>
</head>

<style>

.smol th,
.smol td,
.smol a,
.smol p {
  padding-top: 0.3rem;
  padding-bottom: 0.3rem;
  font-size: 12px;
}
table.dataTable tbody td {
  word-break: break-word;
  vertical-align: top;
}
.text-wrap{
    white-space:normal;
}
.shutin {background-color: #F08080;}
td.highlight { font-weight: bold; }
.lg-icon {
                width: 1.625rem;
                height: 1.625rem;
                vertical-align: -webkit-baseline-middle;

            }
</style>
<body class="bg-light">
    <?php 
        // echo $num= 7 + 1 + 4 + 2 + 2 + 2 + 2 + 2 + (1.5 * 6) + 2 + 2 + 14 + 3;
        
        include 'header_extensions.php';
        $query = "SELECT
                        `prod_data`.*,
                        `list`.*
                    FROM
                        prod_data,
                        list
                    WHERE
                        DATE_FORMAT(`prod_data`.`prod_mo`, '%y-%m') = DATE_FORMAT(`list`.`last_prod_date`, '%y-%m')
                        AND `prod_data`.`api` = `list`.`api`  
                    ORDER BY
                        `list`.`api` ASC";
                        /*OR `list`.`show?` = 1 */ 
        $conn = connect_db();
        $results = mysqli_query($conn, $query);
        $num_records = mysqli_num_rows($results); 
        console_log($conn);
        console_log($query);
        console_log($results);
        mysqli_close($conn);
/*
        $width1 = "";
        $width2 = "";
        $width3 = "";
        $width4 = "";
        $width7 = "";
        $width14 = "";
         */
        $width1 = "width=2%";
        $width2 = "width=2%";
        $width3 = "width=3%";
        $width4 = "width=4%";
        $width7 = "width=7%";
        $width14 = "width=14%"; 
        ?>
<div class=' '>      
    <main role="main" class="">
        <nav class="nav-scroller bg-white shadow-sm nav-underline" style="height: auto; ">
            <ul class="nav justify-content-center" id="myTab" role="tablist" style="position: relative; z-index: 1040; padding-bottom:0px;">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="monthly-tab" data-toggle="tab" href="#home" role="tab" aria-controls="monthly" aria-selected="true">Monthly Production </a>
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
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="monthly-tab" style="position: relative; z-index: 1040;"> 
                    <table id="productionTable" class='table table-striped table-borderless smol display' style="margin-top: 0px !important;" >
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
                                <th >Updated</a></th>
                            
                        </thead>
                    </table>
                </div>
                <div class="tab-pane fade " id="profile" role="tabpanel" aria-labelledby="daily-tab" style="position: relative; z-index: 1040;">
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
                <div class="tab-pane fade " id="shutin" role="tabpanel" aria-labelledby="shutin-tab" style="position: relative; z-index: 1040;">
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
                <div class="tab-pane fade " id="print" role="tabpanel" aria-labelledby="print-tab" style="position: relative; z-index: 1040;">
                    <table id="printTable" class='table table-striped table-borderless datatable-tab-correct datatable-tab-correct1 smol' style="margin-top: 0px !important;" >
                        <thead class="bg-sog">
                                <th >Well</th><th >Pumper</th><th >Status/Production</th> <th >Notes</th><th >Last Updated</th>
                                
                               
                        </thead>
                    </table>
                </div>
            </div>
        <!-- </nav> -->
    <!-- </div> -->
	</main>
    <?php include 'floating_action_button.php'; ?>
    <?php include 'ddr_add_modal.php'; ?>
</div>
</body>
<!-- <script src="WSB/dashboard/popper.min.js.download"></script> -->
<!-- <script src="WSB/dashboard/bootstrap.min.js.download"></script> -->

<!-- Icons -->
<!-- <script src="WSB/dashboard/feather.min.js.download"></script> -->
<script>
    feather.replace()
</script>   
<!-- <script src="WSB/stylesheet/holder.min.js.download"></script> -->
<!-- <script src="WSB/stylesheet/offcanvas.js.download"></script> -->
</html>


