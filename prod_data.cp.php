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
$image_dir           = $ob->getConfig('image_dir');
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



// include 'WSB/includes.php';
include 'include/wsbFunctions.php';

$cp = 1;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = connect_db();
$api = '"' . $_GET['api'] . '"';
$apiNoQuot = $_GET['api'];
//console_log($api);
if ( isset( $_POST['submit'] ) || isset( $api) )
{ 
	//$api = mysql_real_escape_string($_POST['api']);
	if ( ! isset( $api) ) { $api = '"' . $_POST['api'] . '"'; }
	//console_log($api);
	/*$sql = "SELECT * 
		FROM $dbTableName, $dbTableNameCat 
		WHERE categoryid=$dbTableNameCat.id 
		ORDER BY $dbTableName.id DESC LIMIT 1";*/
	$data = "prod_data";
	$pm = "prod_mo";
	
	
	$wellsql = "SELECT * FROM `list` where api =  $api ";
	$wellResult = mysqli_query($mysqli, $wellsql);
	while ($row = mysqli_fetch_array($wellResult)) {
		$well = $row['well_lease'] . " " . $row['well_no'] . " | " . $row['api'];
		$apino = $row['api'];
		$wellstatus = $row['producing_status'];
		$entop = $row['entity_operator_code'];
		$common_name = $row['entity_common_name'];
		$countyparish = $row['county_parish'];
		$reservoir = $row['reservoir'];
		$prod_type = $row['production_type'];
		$drill_type = $row['drill_type'];
		$firstprod = $row['first_prod_date'];
		$lastprod = $row['last_prod_date'];
		$upper_perf = $row['upper_perforation'];
		$lower_perf = $row['lower_perforation'];
		$gas_gravity = $row['gas_gravity'];
		$oil_gravity = $row['oil_gravity'];
		$complete_date = $row['completion_date'];
		$monthsproduced = $row['months_produced'];
		$gas_gather = $row['gas_gatherer'];
		$oil_gather = $row['oil_gatherer'];
		$spud = $row['spud_date'];
		$md = $row['meausred_depth_td'];
		$tvd = $row['true_vertical_depth'];
		$db_field = $row['field'];
		$db_state = $row['state'];
		$db_block = $row['block'];
		$db_lat = $row['surface_latitude_wgs84'] * 1.000000;
		$db_long = $row['surface_longitude_wgs84'] * 1.000000;
		$db_notes = $row['notes'];
		$db_notes_update = $row['notes_update'];
		$db_pumper = $row['pumper'];
		$wellfilelocation = $row['well_file_location'];
        $landowner = $row['landowner'];
        $gatecombo = $row['gatecombo'];
        $landowner_notes = $row['landowner_notes'];
	}
	if($wellstatus == 'Shut-in' || $wellstatus == 'Shut-In' || $wellstatus == 'INACTIVE'){
		$status = "style='color:red;'";
		//$status = "style='background-color: #F08080;'><small";
	}else{
		$status = "";
	}
	$date = '';
	$data1 = '';
    $data2 = '';
	$data3 = '';
	//$sql = "SELECT `list`.*, `prod_data`.*
    //         FROM list, prod_data
    //         WHERE `api` = $api AND `list`.`api` = `prod_data`.`api`
    //       "; 
	
        /*
    $width1 = "";
    $width2 = "";
    $width3 = "";
    $width4 = "";
    $width7 = "";
    $width14 = "";
        */
    $width1 = "width=1%";
    $width2 = "width=2%";
    $width3 = "width=3%";
    $width4 = "width=4%";
    $width7 = "width=7%";
    $width10 = "width=22%";
    $width14 = "width=24%";

    
	
    ## The following creates a check variable for each of the old well notes.
    ## This is used to either show or not show the tabs based on whether the check is 1 or 0.
    $connCPNotes = connect_cpNotes();
    $ddr20sqlC = "SELECT * from `ddr_old` WHERE api like $api AND s like 'compressor'";
    $ddr20resultC = mysqli_query($connCPNotes, $ddr20sqlC);
    if(mysqli_num_rows($ddr20resultC) > 0){
        $ddr20checkC = 1;
    } else {
        $ddr20checkC = 0;
    }
    $ddr20sqlD = "SELECT * from `ddr_old` WHERE api like $api AND s like 'dehydrator'";
    $ddr20resultD = mysqli_query($connCPNotes, $ddr20sqlD);
    if(mysqli_num_rows($ddr20resultD) > 0){
        $ddr20checkD = 1;
    } else {
        $ddr20checkD = 0;
    }
    $ddr20sqlS = "SELECT * from `ddr_old` WHERE api like $api AND s like 'smh'";
    $ddr20resultS = mysqli_query($connCPNotes, $ddr20sqlS);
    if(mysqli_num_rows($ddr20resultS) > 0){
        $ddr20checkS = 1;
    } else {
        $ddr20checkS = 0;
    }
    // $connWellNotes = connect_wellNotes();
    $convert = "SELECT well from `000api_list` WHERE `api` like \"%".$apiNoQuot."%\"";
    $wellResult = mysqli_query($connCPNotes, $convert);
    while ($row = mysqli_fetch_array($wellResult)) {
        $wellCheck = $row['well'];
    }
    $smh_sql = "SELECT * from `$wellCheck` WHERE sheet like 'smh'";
    $dehysql = "SELECT * from `$wellCheck` WHERE sheet like 'dehydrator'";
    $compsql = "SELECT * from `$wellCheck` WHERE sheet like 'compressor'";
    $txdotsql = "SELECT * from `$wellCheck` WHERE sheet like 'txdot'";
    $dsr20sql = "SELECT * from `$wellCheck` WHERE sheet like 'adsr'";
    $dsr15sql = "SELECT * from `$wellCheck` WHERE sheet like 'bdsr'";
    try {
        $smh_sqlresult = mysqli_query($connCPNotes, $smh_sql);
        if(mysqli_num_rows($smh_sqlresult) > 0){
            $smhcheck = 1;
        } else {
            $smhcheck = 0;
        }
    }
    catch (Exception $e) {
        $smhcheck = 0;
    }
    try {
        $dehyresult = mysqli_query($connCPNotes, $dehysql);
        if(mysqli_num_rows($dehyresult) > 0){
            $dehycheck = 1;
        } else {
            $dehycheck = 0;
        }
    }
    catch (Exception $e) {
        $dehycheck = 0;
    }
    try {
        $compresult = mysqli_query($connCPNotes, $compsql);
        if(mysqli_num_rows($compresult) > 0){
            $compcheck = 1;
        } else {
            $compcheck = 0;
        }
    }
    catch (Exception $e) {
        $compcheck = 0;
    }
    try {
        $txdotresult = mysqli_query($connCPNotes, $txdotsql);
        if(mysqli_num_rows($txdotresult) > 0){
            $txdotcheck = 1;
        } else {
            $txdotcheck = 0;
        }
    }
    catch (Exception $e) {
        $txdotcheck = 0;
    }
    try {
        $dsr20result = mysqli_query($connCPNotes, $dsr20sql);
        if(mysqli_num_rows($dsr20result) > 0){
            $dsr20check = 1;
        } else {
            $dsr20check = 0;
        }
    }
    catch (Exception $e) {
        $dsr20check = 0;
    }
    try {
        $dsr15result = mysqli_query($connCPNotes, $dsr15sql);
        if(mysqli_num_rows($dsr15result) > 0){
            $dsr15check = 1;
        } else {
            $dsr15check = 0;
        }
    }
    catch (Exception $e) {
        $dsr15check = 0;
    }
    // mysqli_close($connCPNotes);
?>
<!doctype html>
<html lang="en">
<head>
    <?php include 'dependencies.php'; ?>
    <!-- <script src="https://unpkg.com/feather-icons"></script> -->
    <script type="text/javascript" src="js/chart.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@0.7.7"></script>
    <script type="text/javascript" src="./assets/js/inlineEdit.js"></script>
    <!-- <script type="text/javascript" src="js/fixed-action-button.js"></script> -->
    
    <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
	integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
	crossorigin=""/>
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
	integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
	crossorigin=""></script> -->
    <script src="/js/dropdown.js?v=1.0.0.3"></script>
        <?php 
        // console_log($api); 
        ?>
        <script type="text/javascript">
            window.api = <?php echo $api; ?>;
        </script>
        <?php if(isset($_REQUEST['testing'])){ ?>
        <script type="text/javascript" src="js/datatables.prod_data.testing.js?v=1.0.0.0"></script>
        <?php } else { ?>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/trumbowyg.min.js" integrity="sha512-sffB9/tXFFTwradcJHhojkhmrCj0hWeaz8M05Aaap5/vlYBfLx5Y7woKi6y0NrqVNgben6OIANTGGlojPTQGEw==" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/cleanpaste/trumbowyg.cleanpaste.min.js" integrity="sha512-y7o2DGiZAj5/HOX10rSG1zuIq86mFfnqbus0AASAG1oU2WaF2OGwmkt2XsgJ3oYxJ69luyG7iKlQQ6wlZeV3KQ==" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/colors/trumbowyg.colors.min.js" integrity="sha512-iT7g30i1//3OBZsfoc5XmlULnKQKyxir582Z9fIFWI6+ohfrTdns118QYhCTt0d09aRGcE7IRvCFjw2wngaqRQ==" crossorigin="anonymous"></script>
            <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/highlight/trumbowyg.highlight.min.js" integrity="sha512-WqcaEGy8Pv/jIWsXE5a2T/RMO81LN12aGxFQl0ew50NAUQUiX9bNKEpLzwYxn+Ez1TaBBJf+23OX+K4KBcf6wg==" crossorigin="anonymous"></script> -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/history/trumbowyg.history.min.js" integrity="sha512-hvFEVvJ24BqT/WkRrbXdgbyvzMngskW3ROm8NB7sxJH6P4AEN77UexzW3Re5CigIAn2RZr8M6vQloD/JHtwB9A==" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/datatables.cp.js?v=1.0.0.31"></script>
        <?php } ?>
        
        <!-- DDR.JS IS NOT INCLUDED DUE TO DUPLICATION OF ENTRIES -->
        <!-- <script type="text/javascript" src="js/wsb.ddr.js?v=1.0.0.2"></script> -->

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
       var variableOne = "categoryid";
	   var variableTwo = "link";
	   var variableThree = "name";
	   var valueOne = document.getElementById('categoryid').value;
	   var valueTwo = document.getElementById('link').value;
	   var valueThree = document.getElementById('name').value;
	   var finalString = page + "?" + variableOne + "=" + valueOne
							+ "&" + variableTwo + "=" + valueTwo
							+ "&" + variableThree + "=" + valueThree;
	   
			 ajaxRequest.open("GET", queryString, true);
			 ajaxRequest.send(null); 
		 
	}
	</script>
    <title><?php echo $well; ?></title>
    <!-- <script type="text/javascript">
        // Unused, but this code will allow for a specific tab to load based on the url
        // For example, url.php#t1 will load the t1 tab instead of the default detail tab
        $(document).ready(function() {
            var url = window.location.href;
            var activeTab = url.substring(url.indexOf("#") + 1);
            $('a[href="#'+ activeTab +'"]').tab('show')
            $(".tab-pane").removeClass("active in");
        });
    </script> -->
</head>

<body class="bg-light" style="background-color: #0e5092;">
    <?php include 'include/header_extensions.php'; ?>
<div class='limiter'>     
<main role="main" >
	<nav class="nav-scroller bg-white shadow-sm nav-underline" id="tabs" style="height: auto;" >
		<ul class="nav justify-content-center" id="myTab" role="tablist" style="position: relative; z-index: 940; padding-bottom: 0px;">
            <!-- <li class="nav-item" role="presentation">
				<a class="nav-link" id="vitals-tab" data-toggle="tab" href="#vitals" role="tab" aria-controls="vitals" aria-selected="false">Vitals</a>
			</li> -->
			<li class="nav-item" role="presentation">
				<a class="nav-link active" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="true">Info</a>
			</li>
			<!-- <li class="nav-item" role="presentation">
				<a class="nav-link active" id="detail-tab" data-toggle="tab" href="#detail" role="tab" aria-controls="detail" aria-selected="true">Detailed Production</a>
			</li> -->
            <li class="nav-item" role="presentation">
				<a class="nav-link" id="ddr-tab" data-toggle="tab" href="#ddr" role="tab" aria-controls="ddr" aria-selected="false">DDR-D</a>
            </li>
            <li class="nav-item" role="presentation">
				<a class="nav-link" id="dsr-tab" data-toggle="tab" href="#dsr" role="tab" aria-controls="dsr" aria-selected="false">DSR-D</a>
			</li>
            <?php 
                if($ddr20checkC === 1 || $ddr20checkD === 1 || $ddr20checkS === 1) {
            ?>
            <li class="nav-item" role="presentation">
				<a class="nav-link" id="t1-tab" data-toggle="tab" href="#t1" role="tab" aria-controls="t1" aria-selected="false">DDR 2015-2020</a>
			</li>
            <?php
                }
                if($dsr20check === 1) { 
            ?>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="t2-tab" data-toggle="tab" href="#t2" role="tab" aria-controls="t2" aria-selected="false">DSR 2015-2020</a>
            </li>
            <?php 
                }
                if($compcheck === 1 || $dehycheck === 1 || $smhcheck === 1 || $txdotcheck === 1) { 
            ?>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="t3-tab" data-toggle="tab" href="#t3" role="tab" aria-controls="t3" aria-selected="false">DDR Pre-2015</a>
			</li>
            <?php 
                }
                if($dehycheck === 1) { 
            ?>
			<!-- <li class="nav-item" role="presentation">
				<a class="nav-link" id="dehy-tab" data-toggle="tab" href="#dehy" role="tab" aria-controls="dehy" aria-selected="false">Dehy. DDR Pre-2015</a>
			</li> -->
            <?php 
                }
                if($smhcheck === 1) { 
            ?>
			<!-- <li class="nav-item" role="presentation">
				<a class="nav-link" id="smh-tab" data-toggle="tab" href="#smh" role="tab" aria-controls="smh" aria-selected="false">SMH DDR Pre-2015</a>
            </li> -->
            <?php 
                }
                if($txdotcheck === 1) { 
            ?>
			<!-- <li class="nav-item" role="presentation">
				<a class="nav-link" id="txdot-tab" data-toggle="tab" href="#txdot" role="tab" aria-controls="txdot" aria-selected="false">TXDOT DDR Pre-2015</a>
			</li> -->
            <?php 
                }
                if($dsr15check === 1) { 
            ?>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="t4-tab" data-toggle="tab" href="#t4" role="tab" aria-controls="t4" aria-selected="false">DSR Pre-2015</a>
			</li>
            <?php 
                }
            ?>
        </ul> 
    </nav>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade in show active" id="info" role="tabpanel" aria-labelledby="info-tab" style="position: relative; z-index: 940;">
            <div class="carded m-3 ">
                <div class="row justify-content-center bg-light">
                    <div class="carded-body m-3 p-3 shadow-lg col-5 bg-white" style="box-shadow: 0 .5rem 1rem rgba(0,0,0,.175)!important;">
                        <div class="row">
                            <h3><?php echo $common_name; ?></h3>
                        </div>
                        <div class="row">
                            <h3><?php echo $apino; ?></h3>
                        </div>
                        <div class="row">
                            <p>Company: <?php echo $entop; ?></p>
                        </div>
                        <div class="row">
                            <p>Pumper: <?php echo $db_pumper; ?></p>
                        </div>
                        <div class="row">
                            <p>State: <?php echo $db_state; ?></p>
                        </div>
                        <div class="row">
                            <p>County/Parish: <?php echo $countyparish; ?></p>
                        </div>
                        <div class="row">
                            <p>Block: <?php echo $db_block; ?></p>
                        </div>
                        <div class="row">
                            <p>Notes: <?php echo $db_notes; ?></p>
                            <p><smll>Last updated: <?php echo $db_notes_update; ?></smll></p>
                        </div>
                        <div class="row">
                            <p>Latitude (WGS84): <?php echo $db_lat; ?></p>
                        </div>
                        <div class="row">
                            <p>Longitude (WGS84): <?php echo $db_long; ?></p>
                        </div>
                            <hr>
                        <div class="row">
                            <p><strong>Well File Location: <?php echo $wellfilelocation; ?></strong></p>
                        </div>
                    </div>
                    <div class="row carded-body m-3 p-3 shadow-lg col-5 bg-white" style="box-shadow: 0 .5rem 1rem rgba(0,0,0,.175)!important;">
                        <div class="col">    
                            <div class="row">
                                <h3 <?php echo $status ?>>Status: <?php echo $wellstatus; ?></h3>	
                            </div>
                            <div class="row">
                                <h3>Production Type: <?php echo $prod_type; ?></h3>
                            </div>
                            <div class="row">
                                <p>Reservoir: <?php echo $reservoir; ?></p>
                            </div>
                            <div class="row">
                                <p>Field: <?php echo $db_field; ?></p>
                            </div>
                            <div class="row">
                                <p>MD: <?php echo $md; ?> ft</p>
                            </div>
                            <div class="row">
                                <p>TVD: <?php echo $tvd; ?> ft</p>
                            </div>
                            <div class="row">
                                <p>Drill Type: <?php echo $drill_type; ?></p>
                            </div>
                            <div class="row">
                                <p>Completed: <?php echo $complete_date; ?></p>
                            </div>
                            <div class="row">
                                <p>First Produced: <?php echo $firstprod; ?></p>
                            </div>
                        </div>
                        <div class="col mt-5">
                            <div class="row">
                                <p>Gas Gatherer: <?php echo $gas_gather; ?></p>
                            </div>
                            <div class="row">
                            <p>Oil Gatherer: <?php echo $oil_gather; ?></p>
                                </div>
                            <div class="row">
                                <p>Upper Perforation: <?php echo $upper_perf; ?></p>
                            </div>
                            <div class="row">
                                <p>Lower Perforation: <?php echo $lower_perf; ?></p>
                            </div>
                            <div class="row">
                                <p>Gas Gravity: <?php echo $gas_gravity; ?></p>
                            </div>
                            <div class="row">
                                <p>Oil Gravity: <?php echo $oil_gravity; ?></p>
                            </div>
                            <div class="row">
                                <p>Spud Date: <?php echo $spud; ?></p>
                            </div>
                            <div class="row">
                                <p>Last Produced: <?php echo $lastprod; ?></p>
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <hr class="w-100">
                        <div class="mx-auto"><a class="btn btn-primary btn-lg edit-well-info" id=<?php echo $api; ?> href="#">Edit Well Info</a></div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center bg-light">
                <div class="carded-body m-3 p-3 shadow-lg col-5 bg-white" style="box-shadow: 0 .5rem 1rem rgba(0,0,0,.175)!important;">
                    <div class="row">
                        <div class="col">
                            <h3>Landowner:</h3><h4 id="l"><?php echo $landowner; ?></h4>
                        </div>
                        <div class="col">
                            <h3>Gate Combo:</h3><h4 id="gc"><?php echo $gatecombo; ?></h4>
                        </div>
                    </div>
                    <hr>
                    <div class="w-100"></div>
                    <div class="row">
                        <div class="col-12">
                            <p><strong>Landowner notes:</strong></p><p class="wellinfo" id="ln"><?php echo $landowner_notes; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade " id="ddr" role="tabpanel" aria-labelledby="ddr-tab" style="position: relative; z-index: 940;">
            <div class="carded m-3 p-3 shadow-lg">
                <div class="carded-header"><h1>DDR-D</h1></div>
                    <div class="carded-body">
                        <table id="ddrTable" class='table display table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-condensed table-sm smol table-hover' style="margin-top: 0px !important; width: 100% !important;" >
                            <thead class="smol bg-sog ">
                                    <th class="table-header" style='<?php echo $width2; ?> '>Date</th>
                                    <th class="table-header" style='<?php echo $width2; ?> '>Time</th>
                                    <th class="table-header" style='<?php echo $width2; ?> '>Vendor/Contact</a></th>
                                    <th class="table-header" style='<?php echo $width7; ?> '>Invoice #/Contact Info</a></th>
                                    <th class="table-header" style='<?php echo $width14; ?>'>Invoice Details/DDR</th>
                                    <th class="table-header" style='<?php echo $width2; ?> '>$/EDC</a></th>
                                    <th class="table-header" style='<?php echo $width2; ?> '>Approvals/ECC</a></th>
                                    <th class="table-header" style='<?php echo $width2; ?>'>Actions</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        <!-- </div> -->
        <div class="tab-pane fade " id="dsr" role="tabpanel" aria-labelledby="dsr-tab" style="position: relative; z-index: 940;">
            <div class="carded m-3 p-3 shadow-lg">
                <div class="carded-header">
                    <h1>DSR-D</h1>
                    <div class="mx-auto" name="add_dsr" id="add_dsr" href="#add_data_dsr_Modal" data-toggle="modal">
                        <a class="btn btn-primary btn-lg" id=<?php echo $api; ?> href="#">Add DSR Entry</a>
                    </div>
                </div>
                <div class="carded-body">
                    <table id="dsrTable" class='table display table-striped table-borderless datatable-tab-correct datatable-tab-correct1 smol table-hover' style="margin-top: 0px !important; width: 100% !important;" >
                        <thead class=" bg-sog ">
                            <th <?php // echo $width2; ?>>Date</th>
                            <th <?php // echo $width10; ?>>DSR</th>
                            <th <?php // echo $width4; ?>>$ / EDC</a></th>
                            <th <?php // echo $width4; ?>>Approvals / ECC</a></th>
                            <th <?php // echo $width4; ?>>Actions</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade " id="t1" role="tabpanel" aria-labelledby="t1-tab" style="position: relative; z-index: 940;">
            <nav class="nav-scroller bg-white shadow-sm nav-underline" id="tabs1" style="height: auto;" >
                <ul class="nav justify-content-center" id="myTab1" role="tablist" style="position: relative; z-index: 940; padding-bottom: 0px;">
                <?php if($ddr20checkC === 1) { ?>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="c-tab" data-toggle="tab" href="#c" role="tab" aria-controls="c" aria-selected="false">Compressor</a>
                    </li>
                    <?php 
                        }
                        if($ddr20checkD === 1) { ?>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="d-tab" data-toggle="tab" href="#d" role="tab" aria-controls="d" aria-selected="false">Dehydrator</a>
                    </li>
                    <?php 
                        }
                        if($ddr20checkS === 1) { ?>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="s-tab" data-toggle="tab" href="#s" role="tab" aria-controls="s" aria-selected="false">System Maintenance History</a>
                    </li>
                    <?php 
                        }
                    ?>
                </ul>
            </nav>
            <div class="tab-content" id="myTabContent1">
                <div class="tab-pane fade in show active" id="c" role="tabpanel" aria-labelledby="c-tab" style="position: relative; z-index: 940;">
                    <div class="carded m-3 p-3 shadow-lg">
                        <div class="carded-header"><h1>Compressor DDR 2015-2020</h1></div>
                            <div class="carded-body">
                                <table id="cTable" class="table table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-sm table-hover" style="width=100%;">
                                    <thead class="bg-sog">
                                        <tr>
                                            <th <?php echo $width2; ?> class="table-header">Date</th>
                                            <th <?php echo $width2; ?> class="table-header">Time</th>
                                            <th <?php echo $width2; ?> class="table-header">Vendor/Contact</th>
                                            <th <?php echo $width7; ?> class="table-header">Invoice #/Contact Info</th>
                                            <th <?php echo $width14; ?> class="table-header">Invoice Details/DDR</th>
                                            <th <?php echo $width2; ?> class="table-header">$/EDC</th>
                                            <th <?php echo $width2; ?> class="table-header">Approvals/ECC</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                <!-- </div> -->
                
                <div class="tab-pane fade in " id="d" role="tabpanel" aria-labelledby="d-tab" style="position: relative; z-index: 940;">
                    <div class="carded m-3 p-3 shadow-lg">
                        <div class="carded-header"><h1>Dehydrator DDR 2015-2020</h1></div>
                            <div class="carded-body">
                                <table id="dTable" class="table table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-sm table-hover" style="width=100%;">
                                    <thead class="bg-sog">
                                        <tr>
                                            <th <?php echo $width2; ?> class="table-header">Date</th>
                                            <th <?php echo $width2; ?> class="table-header">Time</th>
                                            <th <?php echo $width2; ?> class="table-header">Vendor/Contact</th>
                                            <th <?php echo $width7; ?> class="table-header">Invoice #/Contact Info</th>
                                            <th <?php echo $width14; ?> class="table-header">Invoice Details/DDR</th>
                                            <th <?php echo $width2; ?> class="table-header">$/EDC</th>
                                            <th <?php echo $width2; ?> class="table-header">Approvals/ECC</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                <!-- </div> -->
                <div class="tab-pane fade in " id="s" role="tabpanel" aria-labelledby="s-tab" style="position: relative; z-index: 940;">
                    <div class="carded m-3 p-3 shadow-lg">
                        <div class="carded-header"><h1>SMH DDR 2015-2020</h1></div>
                            <div class="carded-body">
                                <table id="sTable" class="table table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-sm table-hover" style="width=100%;">
                                    <thead class="bg-sog">
                                        <tr>
                                            <th <?php echo $width2; ?> class="table-header">Date</th>
                                            <th <?php echo $width2; ?> class="table-header">Time</th>
                                            <th <?php echo $width2; ?> class="table-header">Vendor/Contact</th>
                                            <th <?php echo $width7; ?> class="table-header">Invoice #/Contact Info</th>
                                            <th <?php echo $width14; ?> class="table-header">Invoice Details/DDR</th>
                                            <th <?php echo $width2; ?> class="table-header">$/EDC</th>
                                            <th <?php echo $width2; ?> class="table-header">Approvals/ECC</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                <!-- </div> -->
            </div>
        </div>
        <div class="tab-pane fade " id="t2" role="tabpanel" aria-labelledby="t2-tab" style="position: relative; z-index: 940;">
            <div class="carded m-3 p-3 shadow-lg">
                <div class="carded-header"><h1>DSR 2015-2020</h1>
                </div>
                <div class="carded-body">
                    <table id="dsr2015pres" class='table display table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-condensed table-sm smol table-hover' style="margin-top: 0px !important; width: 100% !important;" >
                        <thead class="smol bg-sog ">
                            <th class="table-header">Date</th>
                            <th class="table-header">&nbsp;</th>
                            <th class="table-header">Daily Summary Report</th>
                            <th class="table-header">EDC</th>
                            <th class="table-header">&nbsp;</th>
                            <th class="table-header">ECC</th>
                            <th class="table-header">&nbsp;</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade " id="t3" role="tabpanel" aria-labelledby="t1-tab" style="position: relative; z-index: 940;">
            <nav class="nav-scroller bg-white shadow-sm nav-underline" id="tabs1" style="height: auto;" >
                <ul class="nav justify-content-center" id="myTab2" role="tablist" style="position: relative; z-index: 940; padding-bottom: 0px;">
                <?php if($compcheck === 1) { ?>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="comp-tab" data-toggle="tab" href="#comp" role="tab" aria-controls="comp" aria-selected="false">Compressor</a>
                    </li>
                    <?php 
                        }
                        if($dehycheck === 1) { ?>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="dehy-tab" data-toggle="tab" href="#dehy" role="tab" aria-controls="dehy" aria-selected="false">Dehydrator</a>
                    </li>
                    <?php 
                        }
                        if($smhcheck === 1) { ?>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="smh-tab" data-toggle="tab" href="#smh" role="tab" aria-controls="smh" aria-selected="false">System Maintenance History</a>
                    </li>
                    <?php 
                        }
                        if($txdotcheck === 1) { ?>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="txdot-tab" data-toggle="tab" href="#txdot" role="tab" aria-controls="txdot" aria-selected="false">TXDOT</a>
                    </li>
                    <?php 
                        }
                    ?>
                </ul>
            </nav>
            <div class="tab-content" id="myTabContent2">
                <div class="tab-pane fade in show active" id="comp" role="tabpanel" aria-labelledby="comp-tab" style="position: relative; z-index: 940;">
                    <div class="carded m-3 p-3 shadow-lg">
                        <div class="carded-header">
                            <h1>Compressor | Pre-2015 DDR</h1>
                        </div>
                        <div class="carded-body">
                            <table id="compTable" class="table table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-sm table-hover" style="width=100%;">
                                <thead class="bg-sog">
                                    <tr>
                                        <th class="table-header">&nbsp;</th>
                                        <th class="table-header">A</th>
                                        <th class="table-header">B</th>
                                        <th class="table-header">C</th>
                                        <th class="table-header">D</th>
                                        <th class="table-header">E</th>
                                        <th class="table-header">F</th>
                                        <th class="table-header">G</th>
                                        <th class="table-header">H</th>
                                        <th class="table-header">I</th>
                                        <th class="table-header">J</th>
                                        <!-- <th class="table-header">K</th> -->
                                        <!-- <th class="table-header">L</th> -->
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="tab-pane fade in " id="dehy" role="tabpanel" aria-labelledby="dehy-tab" style="position: relative; z-index: 940;">
                    <div class="carded m-3 p-3 shadow-lg">
                        <div class="carded-header">
                            <h1>Dehydrator | Pre-2015 DDR</h1>
                        </div>
                        <div class="carded-body">
                            <table id="dehyTable" class="table table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-sm table-hover" style="width=100%;">
                                <thead class="bg-sog">
                                    <tr>
                                        <th class="table-header">&nbsp;</th>
                                        <th class="table-header">A</th>
                                        <th class="table-header">B</th>
                                        <th class="table-header">C</th>
                                        <th class="table-header">D</th>
                                        <th class="table-header">E</th>
                                        <th class="table-header">F</th>
                                        <th class="table-header">G</th>
                                        <th class="table-header">H</th>
                                        <th class="table-header">I</th>
                                        <th class="table-header">J</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade in " id="smh" role="tabpanel" aria-labelledby="smh-tab" style="position: relative; z-index: 940;">
                    <div class="carded m-3 p-3 shadow-lg">
                        <div class="carded-header">
                            <h1>System Maintenance History | Pre-2015 DDR</h1>
                        </div>
                        <div class="carded-body">
                            <table id="smhTable" class="table table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-sm table-hover" style="width=100%;">
                                <thead class="bg-sog">
                                    <tr>
                                        <th class="table-header">&nbsp;</th>
                                        <th class="table-header">A</th>
                                        <th class="table-header">B</th>
                                        <th class="table-header">C</th>
                                        <th class="table-header">D</th>
                                        <th class="table-header">E</th>
                                        <th class="table-header">F</th>
                                        <th class="table-header">G</th>
                                        <th class="table-header">H</th>
                                        <th class="table-header">I</th>
                                        <th class="table-header">J</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade in " id="txdot" role="tabpanel" aria-labelledby="txdot-tab" style="position: relative; z-index: 940;">
                    <div class="carded m-3 p-3 shadow-lg">
                        <div class="carded-header">
                            <h1>TXDOT | Pre-2015 DDR</h1>
                        </div>
                        <div class="carded-body">
                            <table id="txdotTable" class="table table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-sm table-hover" style="width=100%;">
                                <thead class="bg-sog">
                                    <tr>
                                        <th class="table-header">&nbsp;</th>
                                        <th class="table-header">A</th>
                                        <th class="table-header">B</th>
                                        <th class="table-header">C</th>
                                        <th class="table-header">D</th>
                                        <th class="table-header">E</th>
                                        <th class="table-header">F</th>
                                        <th class="table-header">G</th>
                                        <th class="table-header">H</th>
                                        <th class="table-header">I</th>
                                        <th class="table-header">J</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade " id="t4" role="tabpanel" aria-labelledby="t4-tab" style="position: relative; z-index: 940;">
            <div class="carded m-3 p-3 shadow-lg">
                <div class="carded-header">
                    <h1>Before 2015 Summary Report</h1>
                </div>
                <div class="carded-body">
                    <table id="before2015sumrpt" class="table display table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-sm table-hover" style="width=100%;">
                        <thead class="bg-sog">
                            <tr>
                                <th class="table-header">&nbsp;</th>
                                <th class="table-header">A</th>
                                <th class="table-header">B</th>
                                <th class="table-header">C</th>
                                <th class="table-header">D</th>
                                <th class="table-header">E</th>
                                <th class="table-header">F</th>
                                <th class="table-header">G</th>
                                <th class="table-header">H</th>
                                <th class="table-header">I</th>
                                <th class="table-header">J</th>
                                <th class="table-header">K</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

</div>

<!-- Floating Legend -->
<?php 
include 'modals/well_entry_modal.php'; 
include 'modals/ddr_edit_modal.php';
include 'include/floating_action_button.php';
include 'modals/ddr_add_modal.php'; 
include 'modals/dsr_add_modal.php';
include 'include/ddr_datepicker.php'; 
?>

</body>
<div class="toggle-btn"></div>
<?php 

?>
    

          <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
          <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
          <script src="/js/bottom_scripts.js?v1.0.0.1"></script>
<!-- <script type="text/javascript" src="WSB/dashboard/bootstrap.min.js.download"></script> -->

<!-- Icons -->
<!-- <script type="text/javascript" src="../WSB/dashboard/feather.min.js.download"></script> -->
<script>
    // feather.replace()
    // const cumprod = document.getElementById('cumulativeproduction');
    // tippy('.r-tooltip', { 
    //       content: cumprod.innerHTML,
    //       allowHTML: true,
    //       placement: 'right',
    //       arrow: false 
    //     });
</script>   
<!-- <script type="text/javascript" src="WSB/stylesheet/offcanvas.js.download"></script> -->


	</html>
    <?php } ?>