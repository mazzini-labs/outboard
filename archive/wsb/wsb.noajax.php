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
    <link rel="stylesheet" type="text/css" href="css/tabs.css?v=1.0.0.0">
    <link rel="stylesheet" type="text/css" href="css/search.css">
	<!-- Bootstrap core CSS -->
    <!-- <link href="WSB/stylesheet/bootstrap.min.css" rel="stylesheet"> -->
    <!-- Custom styles for this template -->
	<link href="WSB/stylesheet/offcanvas.css?v=1.0.0.3" rel="stylesheet">
    <title>WSB</title>
    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css?v=1"/>
 
    <script type="text/javascript" src="datatables/datatables.min.js"></script>
<!--     
        <link rel="stylesheet" type="text/css" href="datatables/Foundation-6.4.3/css/foundation.min.css"/>
        <link rel="stylesheet" type="text/css" href="datatables/DataTables-1.10.21/css/dataTables.foundation.min.css"/>
        <link rel="stylesheet" type="text/css" href="datatables/Responsive-2.2.5/css/responsive.foundation.min.css"/>
        
        <script type="text/javascript" src="datatables/jQuery-3.3.1/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="datatables/Foundation-6.4.3/js/foundation.min.js"></script>
        <script type="text/javascript" src="datatables/DataTables-1.10.21/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="datatables/DataTables-1.10.21/js/dataTables.foundation.min.js"></script>
        <script type="text/javascript" src="datatables/Responsive-2.2.5/js/dataTables.responsive.min.js"></script>
        <script type="text/javascript" src="datatables/Responsive-2.2.5/js/responsive.foundation.min.js"></script>
        -->
    <!-- <script type="text/javascript" src="vendor/slim-scroll-1.3.3/dist/slimscroll.js"></script> -->
    <script type="text/javascript" class="init">
        // $.noConflict();
        $(function(){
            var click1 = 1;
            var click2, click3;
            $(document).ready(function() {
                if(click1 < 2){
                    click1++;
                
                    var oTable = $('#productionTable').DataTable( {
                            "order": [],
                            //"dom": '<"pull-left top"l>&lt"pull-right top"f>&lt"clear">t&lt"bottom"ip>&lt"clear">',
                            //"pageLength": 50,
                            //"fixedHeader": true,
                            // "scrollY":        "50vh",
                            //"scrollCollapse": true,
                            /* "fnInitComplete": function () {
                            var myCustomScrollbar = document.querySelector('#dt-vertical-scroll_wrapper .dataTables_scrollBody');
                            var ps = new PerfectScrollbar(myCustomScrollbar);
                            }, */
                            "paging": false,
                            "info": false,
                            "searching": true,
                            "sDom": 'd',
                            "autoWidth": false,
                            // scroller: true,
                            /*  "columns": [
                                { "width": "7%" },
                                { "width": "2%" },
                                { "width": "3%" },
                                { "width": "2%" },
                                { "width": "4%" },
                                { "width": "2%" },
                                { "width": "4%" },
                                { "width": "2%" },
                                { "width": "1%" },
                                { "width": "1%" },
                                { "width": "1%" },
                                { "width": "1%" },
                                { "width": "1%" },
                                { "width": "1%" },
                                { "width": "2%" },
                                { "width": "2%" },
                                { "width": "14%" },
                                { "width": "3%" } 
                            ]  */
                    } );
                };
            } );
            
            $('#daily-tab').click(function(){
                if(click2 < 1){
                    click2++;
                var iTable = $('#productionTable1').DataTable( {
                    "order": [],
                    //"dom": '<"pull-left top"l>&lt"pull-right top"f>&lt"clear">t&lt"bottom"ip>&lt"clear">',
                    //"pageLength": 50,
                    //"fixedHeader": true,
                    // "scrollY":        "50vh",
                    //"scrollCollapse": true,
                    /* "fnInitComplete": function () {
                    var myCustomScrollbar = document.querySelector('#dt-vertical-scroll_wrapper .dataTables_scrollBody');
                    var ps = new PerfectScrollbar(myCustomScrollbar);
                    }, */
                    "paging": false,
                    "info": false,
                    "searching": true,
                    "sDom": 'd',
                    "autoWidth": false,
                    // scroller: true,
                    /*  "columns": [
                        { "width": "7%" },
                        { "width": "2%" },
                        { "width": "3%" },
                        { "width": "2%" },
                        { "width": "4%" },
                        { "width": "2%" },
                        { "width": "4%" },
                        { "width": "2%" },
                        { "width": "1%" },
                        { "width": "1%" },
                        { "width": "1%" },
                        { "width": "1%" },
                        { "width": "1%" },
                        { "width": "1%" },
                        { "width": "2%" },
                        { "width": "2%" },
                        { "width": "14%" },
                        { "width": "3%" } 
                    ]  */
                } );
            }
            } );
            $('#shutin-tab').click(function(){
                if(click3 < 1){
                    click3++;
                var sTable = $('#shutinTable').DataTable( {
                    "order": [],
                    "paging": false,
                    "info": false,
                    "searching": true,
                    "sDom": 'd',
                    "autoWidth": false,
                } );
            }
            } );
            $('#searchProduction').keyup(function(){
                oTable.search($(this).val()).draw() ;
                iTable.search($(this).val()).draw() ;
                sTable.search($(this).val()).draw() ;
            })
            //$('#productionTable_filter').DataTable.search();
        } );
            
        
    </script>
    
</head>

<style>
body {
    /* top: 56px; */
  overflow: hidden; /* Hide scrollbars */
}  
/* thead {position: -webkit-sticky; position: sticky; top: 0px; z-index: 100;} */
/* /* thead {width: 100%; display: inline-table; height: auto; table-layout: fixed;} */
thead {
    font-style: normal!important;
    font-stretch: condensed!important;
    font-size: 12px;
}
tr {
width: 100%;
display: inline-table;
height:auto;
table-layout: fixed;
/* padding-left: 5%; */
}
td {
    padding-left: 1%!important;
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

</style>
<body class="bg-light">
    <?php 
        // echo $num= 7 + 1 + 4 + 2 + 2 + 2 + 2 + 2 + (1.5 * 6) + 2 + 2 + 14 + 3;
        include 'include/wsbFunctions.php';
        include 'include/header_extensions.php';
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
            </ul> 
            </nav>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="monthly-tab" style="position: relative; z-index: 1040;"> 
                    <table id="productionTable" class='table table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-sm' style="margin-top: 0px !important;" >
                        <thead class="bg-sog">
                            
                                <th <?php echo $width7; ?>>Well</th>
                                <th <?php echo $width2; ?>>ST</th>
                                <th <?php echo $width4; ?>>County</a></th>
                                <th <?php echo $width2; ?>>Block</a></th>
                                <th <?php echo $width2; ?>>Entity</a></th>
                                <th <?php echo $width2; ?>>Status</a></th>
                                <th <?php echo $width2; ?>>Prod</a></th>
                                <th <?php echo $width2; ?>>Active</a></th>
                                
                                <th <?php echo $width1; ?>>Gas</th>
                                <th <?php echo $width1; ?>>Oil</th>
                                <th <?php echo $width1; ?>>Water</th>
                                
                                <th <?php echo $width2; ?>>Loss</a></th>
                                <th <?php echo $width2; ?>>Pumper</a></th>
                                <th <?php echo $width14; ?>>Notes</th>
                                <th <?php echo $width3; ?>>Updated</a></th>
                            
                        </thead>
                        <?php
                        
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
                            
                            $productiontype = $row['production_type'];
                            $actiondate = $row['last_prod_date'];
                            $dayson = $row['days_on'];
                            $gassold = $row['gas_sold'];
                            $cur_prod_gas = $gassold;
                            $cur_prod_oil = $row['oil_prod'];
                            $cur_prod_water = $row['water_prod'];
                            /* if(!$dayson == 0){
                            $avg_prod_gas = $cur_prod_gas / $dayson;
                            $avg_prod_oil = $cur_prod_oil / $dayson;
                            $avg_prod_water = $cur_prod_water / $dayson; 
                            } else {
                                $avg_prod_gas = 0;
                                $avg_prod_oil = 0;
                                $avg_prod_water = 0; 
                            } */
                            $lineloss = $row['gas_line_loss'];	
                            $pumper = $row['pumper'];
                            $wellcheck = $row['report_frequency'];
                            $notes = $row['notes'];
                            $notes_updated = $row['notes_update'];
                            $datetime = new DateTime($notes_updated);
                            $last_updated = $datetime->format('Y-m-d');
                            //$priority = mysql_result($results, $i, "priority");
                            

                            
                            

                            echo "<tr >\n";
                            echo "<td $width7><small><a href='prod_data.php?api=$well_api'>$wellname | $well_api</td ></small>\n";
                            echo "<td $width2><small>$state</td ></small>\n";
                            echo "<td $width4><small>$county</a></td ></small>\n";
                            echo "<td $width2><small>$block</td ></small>\n";
                            echo "<td $width2><small>$compname</td ></small>\n";
                            echo "<td $status>$wellstatus</td ></small>\n";
                            echo "<td $width2><small>$productiontype</td ></small>\n";
                            echo "<td $width2><small>$actiondate</td ></small>\n";
                            /* echo "<td $width1><small>". truncate($avg_prod_gas) ." <sup>mcf</sup>/<sub>day</sub></small></td>\n";
                            echo "<td $width1><small>". truncate($avg_prod_oil) ." <sup>bbl</sup>/<sub>day</sub></small></td>\n";
                            echo "<td $width1><small>". truncate($avg_prod_water) ." <sup>bbl</sup>/<sub>day</sub></small></td>\n"; */
                            echo "<td $width1><small>". truncate($cur_prod_gas) ." mcf</small></td>\n";
                            echo "<td $width1><small>". truncate($cur_prod_oil) ." bbl</small></td>\n";
                            echo "<td $width1><small>". truncate($cur_prod_water) ." bbl</small></td>\n";
                            echo "<td $width2><small>". truncate($lineloss) ." mcf</small></td>\n";
                            echo "<td $width2><small>$pumper</small></td >\n";
                            echo "<td $width14><small>$boldTagStart $notes $boldTagEnd</small> </td >\n";
                            echo "<td $width3><small>$last_updated</small></td >\n";
                            echo "</tr>\n"; 
                        }
                        echo "</tbody>\n";
                        ?>
                    </table>
                </div>
                <div class="tab-pane fade " id="profile" role="tabpanel" aria-labelledby="daily-tab" style="position: relative; z-index: 1040;">
                    <table id="productionTable1" class='table table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-sm' style="margin-top: 0px !important;" >
                        <thead class="bg-sog">
                                <th <?php echo $width7; ?>>Well</th>
                                <th <?php echo $width2; ?>>ST</th>
                                <th <?php echo $width4; ?>>County</a></th>
                                <th <?php echo $width2; ?>>Block</a></th>
                                <th <?php echo $width2; ?>>Entity</a></th>
                                <th <?php echo $width2; ?>>Status</a></th>
                                <th <?php echo $width2; ?>>Prod</a></th>
                                <th <?php echo $width2; ?>>Active</a></th>
                                
                                <th <?php echo $width1; ?>>Gas</th>
                                <th <?php echo $width1; ?>>Oil</th>
                                <th <?php echo $width1; ?>>Water</th>
                                
                                <th <?php echo $width2; ?>>Loss</a></th>
                                <th <?php echo $width2; ?>>Pumper</a></th>
                                <th <?php echo $width14; ?>>Notes</th>
                                <th <?php echo $width3; ?>>Last Updated</a></th>
                        </thead>
                        <?php
                        $conn = connect_db();
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
                            /* echo "<td $width1><small>". truncate($cur_prod_gas) ." mcf</small></td>\n";
                            echo "<td $width1><small>". truncate($cur_prod_oil) ." bbl</small></td>\n";
                            echo "<td $width1><small>". truncate($cur_prod_water) ." bbl</small></td>\n"; */
                            echo "<td $width2><small>". truncate($lineloss) ." mcf</small></td>\n";
                            echo "<td $width2><small>$pumper</small></td >\n";
                            echo "<td $width14><small>$boldTagStart $notes $boldTagEnd</small> </td >\n";
                            echo "<td $width3><small>$last_updated</small></td >\n";
                            echo "</tr>\n"; 

                            
                            /* 
                            { "width": "1%" },
                            { "width": "1%" },
                            { "width": "1%" },
                            { "width": "1%" },
                            { "width": "1%" },
                            { "width": "1%" },
                            { "width": "2%" },
                            { "width": "2%" },
                            { "width": "14%" },
                            { "width": "3%" } */
                        }
                        echo "</tbody>\n";
                        
                        ?> 
                    
                    </table>
                </div>
                <?php 
                $query = "SELECT
                                `list`.*
                            FROM
                                list
                            WHERE
                                `list`.`producing_status` = 'Shut-In'  
                                OR `list`.`producing_status` = 'Shut-in'
                                OR `list`.`producing_status` = 'INACTIVE'
                                OR `list`.`producing_status` = 'SI'
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
                $width14 = "width=24%"; 
                ?>
                <div class="tab-pane fade " id="shutin" role="tabpanel" aria-labelledby="shutin-tab" style="position: relative; z-index: 1040;">
                    <table id="shutinTable" class='table table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-sm' style="margin-top: 0px !important;" >
                        <thead class="bg-sog">
                                <th <?php echo $width7; ?>>Well</th>
                                <th <?php echo $width2; ?>>ST</th>
                                <th <?php echo $width4; ?>>County</a></th>
                                <th <?php echo $width2; ?>>Block</a></th>
                                <th <?php echo $width2; ?>>Entity</a></th>
                                <!-- <th <?php //echo $width2; ?>>Status</a></th> -->
                                <!-- <th <?php echo $width2; ?>>Prod</a></th> -->
                                <!-- <th <?php echo $width2; ?>>Active</a></th> -->
                                
                                <!-- <th <?php echo $width1; ?>>Gas</th> -->
                                <!-- <th <?php echo $width1; ?>>Oil</th> -->
                                <!-- <th <?php echo $width1; ?>>Water</th> -->
                                
                                <!-- <th <?php echo $width2; ?>>Loss</a></th> -->
                                <!-- <th <?php echo $width2; ?>>Pumper</a></th> -->
                                <th <?php echo $width14; ?>>Shut-In Notes</th>
                                <!-- <th <?php echo $width3; ?>>Last Updated</a></th> -->
                        </thead>
                        <?php
                        $conn = connect_db();
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
                            // $wellstatus = $row['producing_status'];
                            // $productiontype = $row['production_type'];
                            // $actiondate = $row['last_prod_date'];
                            // $dayson = $row['days_on'];
                            // $gassold = $row['gas_sold'];
                            // $cur_prod_gas = $gassold;
                            // $cur_prod_oil = $row['oil_prod'];
                            // $cur_prod_water = $row['water_prod'];
                            /*if(!$dayson == 0){ 
                            $avg_prod_gas = $cur_prod_gas / $dayson;
                            $avg_prod_oil = $cur_prod_oil / $dayson;
                            $avg_prod_water = $cur_prod_water / $dayson; 
                            } else {
                                $avg_prod_gas = 0;
                                $avg_prod_oil = 0;
                                $avg_prod_water = 0; 
                            } */
                            // $lineloss = $row['gas_line_loss'];	
                            // $pumper = $row['pumper'];
                            // $wellcheck = $row['report_frequency'];
                            $notes = $row['si_notes'];
                            $notes_updated = $row['notes_update'];
                            // $datetime = new DateTime($notes_updated);
                            $last_updated = $datetime->format('Y-m-d');
                            //$priority = mysql_result($results, $i, "priority");
                            

                            /* if($wellstatus == 'Shut-in' || $wellstatus == 'Shut-In' || $wellstatus == 'INACTIVE'){
                                //$status = "style='color:red;'><small";
                                $status = "style='background-color: #F08080;' $width2><small";
                                $boldTagStart = "<strong>";
                                $boldTagEnd = "</strong>";
                            }else{
                                $status = "$width2><small";
                                $boldTagStart = "";
                                $boldTagEnd = "";
                            } */
                            

                            echo "<tr>\n";
                            echo "<td $width7><small><a href='prod_data.php?api=$well_api'>$wellname - $well_api</td ></small>\n";
                            echo "<td $width2><small>$state</td ></small>\n";
                            echo "<td $width4><small>$county</a></td ></small>\n";
                            echo "<td $width2><small>$block</td ></small>\n";
                            echo "<td $width2><small>$compname</td ></small>\n";
                            // echo "<td $status>$wellstatus</td ></small>\n";
                            // echo "<td $width2><small>$productiontype</td ></small>\n";
                            // echo "<td $width2><small>$actiondate</td ></small>\n";
                            // echo "<td $width1><small>". truncate($avg_prod_gas) ." <sup>mcf</sup>/<sub>day</sub></small></td>\n";
                            // echo "<td $width1><small>". truncate($avg_prod_oil) ." <sup>bbl</sup>/<sub>day</sub></small></td>\n";
                            // echo "<td $width1><small>". truncate($avg_prod_water) ." <sup>bbl</sup>/<sub>day</sub></small></td>\n";
                            /* echo "<td $width1><small>". truncate($cur_prod_gas) ." mcf</small></td>\n";
                            echo "<td $width1><small>". truncate($cur_prod_oil) ." bbl</small></td>\n";
                            echo "<td $width1><small>". truncate($cur_prod_water) ." bbl</small></td>\n"; */
                            // echo "<td $width2><small>". truncate($lineloss) ." mcf</small></td>\n";
                            // echo "<td $width2><small>$pumper</small></td >\n";
                            echo "<td $width14><small>$notes</small> </td >\n";
                            // echo "<td $width3><small>$last_updated</small></td >\n";
                            echo "</tr>\n"; 

                            
                            /* 
                            { "width": "1%" },
                            { "width": "1%" },
                            { "width": "1%" },
                            { "width": "1%" },
                            { "width": "1%" },
                            { "width": "1%" },
                            { "width": "2%" },
                            { "width": "2%" },
                            { "width": "14%" },
                            { "width": "3%" } */
                        }
                        echo "</tbody>\n";
                        
                        ?> 
                    
                    </table>
                </div>
            </div>
        <!-- </nav> -->
    <!-- </div> -->
	</main>
</div>
</body>
<script src="WSB/dashboard/popper.min.js.download"></script>
<script src="WSB/dashboard/bootstrap.min.js.download"></script>

<!-- Icons -->
<script src="WSB/dashboard/feather.min.js.download"></script>
<script>
    feather.replace()
</script>   
<!-- <script src="WSB/stylesheet/holder.min.js.download"></script> -->
<script src="WSB/stylesheet/offcanvas.js.download"></script>
</html>


