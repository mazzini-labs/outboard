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

include 'WSB/includes.php';

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
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = connect_db();
$api = '"' . $_GET['api'] . '"';
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
	$sql = "SELECT * FROM `prod_data` where api =  $api ";
    $result = mysqli_query($mysqli, $sql);
	//console_log($result);
	//loop through the returned data
	while ($row = mysqli_fetch_array($result)) {
		//$prod_mo = $row['date'];
		$oilprod = round($row['oil_prod']);
		$gasprod = round($row['gas_wh_mcf']);
		$waterprod = round($row['water_prod']);
        $date = $date . '"'. $row['prod_mo'].'",';
		// $data1 = $data1 . '"'. $row['oil_prod'].'",';
        // $data2 = $data2 . '"'. $row['gas_wh_mcf'] .'",';
		// $data3 = $data3 . '"'. $row['water_prod'] .'",';
		$data1 = $data1 . '"'. $oilprod .'",';
        $data2 = $data2 . '"'. $gasprod .'",';
        $data3 = $data3 . '"'. $waterprod .'",';
        $cumoil = $cumoil + $oilprod;
        $cumgas = $cumgas + $gasprod;
        $cumwater = $cumwater + $waterprod;
	}
	
    $date = trim($date,",");
	$data1 = trim($data1,",");
    $data2 = trim($data2,",");
    $data3 = trim($data3,",");
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
    <script type="text/javascript" src="js/fixed-action-button.js"></script>
    <script type="text/javascript" src="/js/datatables.prod_data.js?v1.1"></script>
    <script type="text/javascript" src="./js/ddr.js"></script>
	<title><?php echo $well; ?></title>
</head>

<body class="bg-light" style="background-color: #0e5092;">
<?php include 'include/header_extensions.php'; ?>
<div class='limiter'>     
<main role="main" >
	<nav class="nav-scroller bg-white shadow-sm nav-underline" id="tabs" style="height: auto;" >
		<ul class="nav justify-content-center" id="myTab" role="tablist" style="position: relative; z-index: 1040; padding-bottom: 0px;">
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">Well Info</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link active" id="detail-tab" data-toggle="tab" href="#detail" role="tab" aria-controls="detail" aria-selected="true">Detailed Production</a>
			</li>
            <li class="nav-item" role="presentation">
				<a class="nav-link" id="ddr-tab" data-toggle="tab" href="#ddr" role="tab" aria-controls="ddr" aria-selected="false">DDR-D</a>
            </li>
            <li class="nav-item" role="presentation">
				<a class="nav-link" id="dsr-tab" data-toggle="tab" href="#dsr" role="tab" aria-controls="dsr" aria-selected="false">DSR-D</a>
			</li>

            <li class="nav-item" role="presentation">
				<a class="nav-link" id="t1-tab" data-toggle="tab" href="#t1" role="tab" aria-controls="t1" aria-selected="false">DDR 2015-2020</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="t2-tab" data-toggle="tab" href="#t2" role="tab" aria-controls="t2" aria-selected="false">DSR 2015-2020</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="t3-tab" data-toggle="tab" href="#t3" role="tab" aria-controls="t3" aria-selected="false">DDR Pre-2015</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="t4-tab" data-toggle="tab" href="#t4" role="tab" aria-controls="t4" aria-selected="false">DSR Pre-2015</a>
			</li>
        </ul> 
        </nav>
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade " id="info" role="tabpanel" aria-labelledby="info-tab" style="position: relative; z-index: 1040;">
                <!-- <div class="carded m-3 p-3 shadow-lg"> -->
                   
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
                                <div class="row">
                                    <hr>
                                </div>
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
                                    <!-- <div class="row"> -->
                                        <!-- <p>Last Produced: <?php echo $lastprod; ?></p> -->
                                        <!-- <p><smll>Produced for <?php //echo $monthsproduced; ?> months</smll></p> -->
                                    <!-- </div> -->
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
                            </div>
                        </div>
                        <div class="row justify-content-center bg-light">
                            <div class="p-3 col-11 " >
                                <div class="m-3 p-3 shadow-lg carded-body bg-white">
                                    <table id='notesTable' class='table bg-white'>
                                        <thead>
                                            <tr>
                                                <th>Date Updated</th>
                                                <th>General Notes</th>
                                                <th>S/I Notes</th>
                                                <th>Pumper</th>
                                            </tr>
                                        </thead>
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- </div> -->
			</div>
			
            <div class="tab-pane fade " id="ddr" role="tabpanel" aria-labelledby="ddr-tab" style="position: relative; z-index: 1040;">
                <div class="carded m-3 p-3 shadow-lg">
                    <div class="carded-header"><h1>DDR-D</h1></div>
                        <div class="carded-body">
                            <table id="ddrTable" class='table display table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-condensed table-sm smol table-hover' style="margin-top: 0px !important; width: 100% !important;" >
                                <thead class=" bg-sog ">
                                        <th style='<?php // echo $width1; ?>'>Department</th>
                                        <th style='<?php // echo $width1; ?>'>Date</th>
                                        <th style='<?php // echo $width2; ?>'>Time</th>
                                        <th style='<?php // echo $width2; ?>'>Vendor <br>Contact</a></th>
                                        <th style='<?php // echo $width4; ?>'>Invoice # <br>Contact Info</a></th>
                                        <th style='<?php // echo $width10; ?>'>Invoice Details <br>DDR</th>
                                        <th style='<?php // echo $width4; ?>'>$ <br>EDC</a></th>
                                        <th style='<?php // echo $width4; ?>'>Approvals <br> ECC</a></th>
                                        <th style='<?php // echo $width4; ?>'>Actions</th>
                                </thead>
                                <?php
                                /*
                                    $output .= '<tbody id="ddr_table">';
                                    $ddr = "ddr";
                                    $sub_date = "sd";
                                    $datasql = "SELECT * FROM `notes` WHERE api='$apino' ORDER BY de ASC";
                                    $dataresult = mysqli_query($mysqli, $datasql) or die(mysql_error());
                                    while($datarow = mysqli_fetch_array($dataresult)) 
                                    {
                                         $type = $datarow['t'];
                                         if($type != "s")
                                         {
                                              $i = 0;
                                              $d = $datarow['d'];
                                              $ddrID = $datarow['id'];
                                              switch($d)
                                              {
                                                   case "e":
                                                   $de = ($datarow['de'] != '') ? $datarow['de'] : " - ";
                                                   $ts = ($datarow['ts'] != '') ? $datarow['ts'] : " - ";
                                                   $te = ($datarow['te'] != '') ? $datarow['te'] : " - ";
                                                   $cvn = ($datarow['cvn'] != '') ? $datarow['cvn'] : " - ";
                                                   $cin = ($datarow['cin'] != '') ? $datarow['cin'] : " - ";
                                                   $drn = ($datarow['drn'] != '') ? $datarow['drn'] : " - ";
                                                   $edc = ($datarow['edc'] != '') ? "$" . $datarow['edc'] : " - ";
                                                   $ecc = ($datarow['ecc'] != '') ? "$" . $datarow['ecc'] : " - ";
                                                   $deb = ($datarow['deb'] != '') ? $datarow['deb'] : " - ";
                                                   $sd = ($datarow['sd'] != '') ? $datarow['sd'] : " - ";
                                                   $output .= '  
                                                             <tr>
                                                                  <td class="engineering" ' . $width2 . '><small>Engineering</small></td>
                                                                  <td class="engineering-date" ' . $width2 . '><small>' . $de . '</td ></small>
                                                                  <td class="engineering" ' . $width4 . '><small>' . $ts . ' - ' . $te . '</td ></small>
                                                                  <td class="engineering" ' . $width4 . '><small>' . $cvn . '</a></td ></small>
                                                                  <td class="engineering" ' . $width4 . '><small>' . $cin . '</td ></small>
                                                                  <td class="engineering" ' . $width10 . '><small>' . $drn . '</small> </td >
                                                                  <td class="engineering" ' . $width4 . '><small>' . $edc . '</td ></small>
                                                                  <td class="engineering" ' . $width4 . '><small>' . $ecc . '</td ></small>
                                                                  <td class="engineering" '.$width4.'>
                                                                       <input type="button" name="edit" value="Edit" id="'.$datarow["id"].'" class="btn btn-info btn-xs edit_data-'.$datarow["d"].'" />
                                                                       <input type="button" name="view" value="view" id="'.$datarow["id"].'" class="btn btn-info btn-xs view_data" />
                                                                  </td>
                                                             </tr>
                                                   '; 
                                                   break;
                                                   case "a":
                                                   $de = ($datarow['de'] != '') ? $datarow['de'] : " - ";
                                                   $ts = ($datarow['ts'] != '') ? $datarow['ts'] : "";
                                                   $te = ($datarow['te'] != '') ? $datarow['te'] : "";
                                                   $cvn = ($datarow['cvn'] != '') ? $datarow['cvn'] : " - ";
                                                   $cin = ($datarow['cin'] != '') ? $datarow['cin'] : " - ";
                                                   $drn = ($datarow['drn'] != '') ? $datarow['drn'] : " - ";
                                                   $edc = ($datarow['edc'] != '') ? "$" . $datarow['edc'] : " - ";
                                                   $ad = ($datarow['ad'] != '') ? $datarow['ad'] : " - ";
                                                   $ad = ($datarow['ad'] != '') ? $datarow['ad'] : " - ";
                                                   $deb = ($datarow['deb'] != '') ? $datarow['deb'] : " - ";
                                                   $sd = ($datarow['sd'] != '') ? $datarow['sd'] : " - ";
                                                   $time_dash = ($ts == "-" || $te == " - ") ? "" : "-";
                                                   $output .= '  
                                                             <tr>
                                                                  <td class="accounting" ' . $width2 . '><small>Accounting</small></td>
                                                                  <td class="accounting" ' . $width2 . '><small>' . $de . '</td ></small>
                                                                  <td class="accounting" ' . $width4 . '><small>' . $ts . ' - ' . $te . '</td ></small>
                                                                  <td class="accounting" ' . $width4 . '><small>' . $cvn . '</a></td ></small>
                                                                  <td class="accounting" ' . $width4 . '><small>' . $cin . '</td ></small>
                                                                  <td class="accounting" ' . $width10 . '><small>' . $drn . '</small> </td >
                                                                  <td class="accounting" ' . $width4 . '><small>' . $edc . '</td ></small>
                                                                  <td class="accounting" ' . $width4 . '><small>Approval Initials:' . $ai . ' <hr>Approval Date:' . $ad . '</td ></small>
                                                                  <td class="accounting" '.$width4.'>
                                                                       <input type="button" name="edit" value="Edit" id="'.$datarow["id"].'" class="btn btn-info btn-xs edit_data-'.$datarow["d"].'" />
                                                                       <input type="button" name="view" value="view" id="'.$datarow["id"].'" class="btn btn-info btn-xs view_data" />
                                                                  </td>
                                                             </tr> 
                                                   ';
                                                   break;
                                                   case "v":
                                                   $de = ($datarow['de'] != '') ? $datarow['de'] : " - ";
                                                   $cvn = ($datarow['cvn'] != '') ? $datarow['cvn'] : " - ";
                                                   //$cvn = $datarow['cvn'] != '') ?  : " - ";
                                                   $cin = ($datarow['cin'] != '') ? $datarow['cin'] : " - ";
                                                   $ts = ($datarow['ts'] != '') ? $datarow['ts'] : "";
                                                   $te = ($datarow['te'] != '') ? $datarow['te'] : "";
                                                   $edc = ($datarow['edc'] != '') ? $datarow['edc'] : " - ";
                                                   $ecc = ($datarow['ecc'] != '') ? $datarow['ecc'] : " - ";
                                                   $deb = ($datarow['deb'] != '') ? $datarow['deb'] : " - ";
                                                   $sd = ($datarow['sd'] != '') ? $datarow['sd'] : " - ";
                                                   $drn = ($datarow['drn'] != '') ? $datarow['drn'] : " - ";
                                                   if($datarow['tt'] != '' || $datarow['tt'] != '' || $datarow['tt'] != '' || $datarow['tt'] != '' || $datarow['tt'] != '' || $datarow['tt'] != '')
                                                   {
                                                        $drn .= '<br>';
                                                   }
                                                   
                                                   $drn .= ($datarow['dt'] != '') ? "Deducted Time:  " . $datarow['dt'] . "hours <br>" : "" ;
                                                   $drn .= ($datarow['dc'] != '') ? "Deducted Cost:  $" . $datarow['dc'] . "<br>" : "" ;
                                                   $drn .= ($datarow['at'] != '') ? "Adjusted Time:  " . $datarow['at'] . "hours <br>" : "" ;
                                                   $drn .= ($datarow['ac'] != '') ? "Adjusted Cost:  $" . $datarow['ac'] . "<br>" : "" ;
                                                   $drn .= ($datarow['et'] != '') ? "Estimated Time:  " . $datarow['et'] . "hours <br>" : "" ;
                                                   $drn .= ($datarow['tt'] != '') ? "    Total Time:  " . $datarow['tt'] . "hours" : "" ;
                          
                                                   $time_dash = ($ts == "-" || $te == "-") ? "" : " - ";
                                                   $output .= '
                                                             <tr>
                                                                  <td class="vendor" ' . $width2 . '><small>Vendor</small></td>
                                                                  <td class="vendor" ' . $width2 . '><small>' . $de . '</td ></small>
                                                                  <td class="vendor" ' . $width4 . '><small>' . $ts . ' - ' . $te . '</td ></small>
                                                                  <td class="vendor" ' . $width4 . '><small>' . $cvn . '</a></td ></small>
                                                                  <td class="vendor" ' . $width4 . '><small>' . $cin . '</td ></small>
                                                                  <td class="vendor" ' . $width10 . '><small>' . $drn . '</small> </td >                                       
                                                                  <td class="vendor" ' . $width4 . '><small>' . $edc . '</td ></small>
                                                                  <td class="vendor" ' . $width4 . '><small>' . $ecc . '</td ></small>
                                                                  <td class="vendor" '.$width4.'>
                                                                       <input type="button" name="edit" value="Edit" id="'.$datarow["id"].'" class="btn btn-info btn-xs edit_data-'.$datarow["d"].'" />
                                                                       <input type="button" name="view" value="view" id="'.$datarow["id"].'" class="btn btn-info btn-xs view_data" />
                                                                  </td>
                                                             </tr>
                                                   '; 
                                                   break;
                                                   default:
                                                   $de = ($datarow['de'] != '') ? $datarow['de'] : " - ";
                                                   $ts = ($datarow['ts'] != '') ? $datarow['ts'] : " - ";
                                                   $te = ($datarow['te'] != '') ? $datarow['te'] : " - ";
                                                   $cvn = ($datarow['cvn'] != '') ? $datarow['cvn'] : " - ";
                                                   $cin = ($datarow['cin'] != '') ? $datarow['cin'] : " - ";
                                                   $drn = ($datarow['drn'] != '') ? $datarow['drn'] : " - ";
                                                   $edc = ($datarow['edc'] != '') ? "$" . $datarow['edc'] : " - ";
                                                   $ecc = ($datarow['ecc'] != '') ? "$" . $datarow['ecc'] : " - ";
                                                   $output .= '
                                                             <tr>
                                                                  <td class="field" ' . $width2 . '><small>Field</small></td>
                                                                  <td class="field" ' . $width2 . '><small>' . $de . '</small></td >
                                                                  <td class="field" ' . $width4 . '><small>' . $ts . ' - ' . $te . '</small></td >
                                                                  <td class="field" ' . $width4 . '><small>' . $cvn . '</small></td >
                                                                  <td class="field" ' . $width4 . '><small>' . $cin . '</small></td >
                                                                  <td class="field" ' . $width10 . '><small>' . $drn . '</small></td >
                                                                  <td class="field" ' . $width4 . '><small>' . $edc . '</small></td >
                                                                  <td class="field" ' . $width4 . '><small>' . $ecc . '</small></td >
                                                                  <td class="field" '.$width4.'>
                                                                       <input type="button" name="edit" value="Edit" id="'.$datarow["id"].'" class="btn btn-info btn-xs edit_data-'.$datarow["d"].'" />
                                                                       <input type="button" name="view" value="view" id="'.$datarow["id"].'" class="btn btn-info btn-xs view_data" />
                                                                  </td>
                                                             </tr>
                                                   '; 
                                                   break;
                                              }
                                              $i++; 
                                         }
                                    } 
                                                              $output .= '</tbody>';
                                    

                                echo $output; 
                                */  
                                ?> 
                            
                            </table>
                        </div>
                    </div>
                </div>

            <div class="tab-pane fade " id="dsr" role="tabpanel" aria-labelledby="dsr-tab" style="position: relative; z-index: 1040;">
                <div class="carded m-3 p-3 shadow-lg">
                    <div class="carded-header"><h1>DSR-D</h1></div>
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

            <div class="tab-pane fade " id="t1" role="tabpanel" aria-labelledby="t1-tab" style="position: relative; z-index: 1040;">
				<div class="carded m-3 p-3 shadow-lg">
                    <div class="carded-header"><h1>DDR 2015-Present</h1></div>
                        <div class="carded-body">
                            <table id="ddr2015pres" class="table table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-sm table-hover" style="width=100%;">
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
            <div class="tab-pane fade " id="t2" role="tabpanel" aria-labelledby="t2-tab" style="position: relative; z-index: 1040;">
                <div class="carded m-3 p-3 shadow-lg"> 
                    <div class="carded-header"><h1>DSR 2015-Present</h1></div>
                        <div class="carded-body">  
                            <table id="dsr2015pres" class="table table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-sm table-hover" style="width=100%;">
                                <thead class="bg-sog">
                                    <tr>
                                        <th class="table-header">Date</th>
                                        <th class="table-header">&nbsp;</th>
                                        <th class="table-header">Daily Summary Report</th>
                                        <th class="table-header">EDC</th>
                                        <th class="table-header">&nbsp;</th>
                                        <th class="table-header">ECC</th>
                                        <th class="table-header">&nbsp;</th>
                                        <!--  <th class="table-header">&nbsp;</th>
                                        <th class="table-header">&nbsp;</th>
                                        <th class="table-header">&nbsp;</th>
                                        <th class="table-header">&nbsp;</th>
                                        <th class="table-header">&nbsp;</th> -->
                                        <!-- <th class="table-header">L</th>
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
                                        <!-- <th class="table-header">Y</th>
                                        <th class="table-header">Z</th> -->
                                        <!-- <th class="table-header">E</th>
                                        <th class="table-header">E</th> -->
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            <div class="tab-pane fade " id="t3" role="tabpanel" aria-labelledby="t3-tab" style="position: relative; z-index: 1040;">
                <div class="carded m-3 p-3 shadow-lg">
                    <div class="carded-header">
                        <h1>Before 2015 Detail Report</h1></div>
                        <div class="carded-body">
                            <table id="before2015detailrpt" class="table display table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-sm table-hover" style="width=100%;">
                                <thead class="bg-sog">
                                    <tr>
                                        <!-- <th class="table-header">&nbsp;</th> -->
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
                                        <th class="table-header">L</th>
                                        <!-- <th class="table-header">M</th>
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
                                        <!-- <th class="table-header">Y</th>
                                        <th class="table-header">Z</th> -->
                                        <!-- <th class="table-header">E</th>
                                        <th class="table-header">E</th> -->
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            <div class="tab-pane fade " id="t4" role="tabpanel" aria-labelledby="t4-tab" style="position: relative; z-index: 1040;">
                <div class="carded m-3 p-3 shadow-lg">
                    <div class="carded-header">
                        <h1>Before 2015 Summary Report</h1></div>
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
                                        <!-- <th class="table-header">L</th>
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
                                        <!-- <th class="table-header">Y</th>
                                        <th class="table-header">Z</th> -->
                                        <!-- <th class="table-header">E</th>
                                        <th class="table-header">E</th> -->
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
			<div class="tab-pane fade in show active" id="detail" role="tabpanel" aria-labelledby="detail-tab" style="position: relative; z-index: 1040;"> 
				<!-- <main role="main" class="col-sm-auto pt-5" style="top: 7.5vh;"> -->
				<div class="m-3 carded bg-light">
					<div class="row justify-content-center">
						<div class="col-6 m-3 p-3 shadow-lg carded-body bg-white">
							<h3 class="r-tooltip" data-tippy-content=""><?php echo $well; ?></h3>
                            
							<div class="chart-container">
								<canvas id="chart" style="width: 100%; height: 50vh;"></canvas> 
							</div>
						</div>
						<div class="col-5 m-3 p-3 shadow-lg carded-body bg-white">
							<h3 <?php echo $status ?>>Status: <?php echo $wellstatus; ?></h3>	
							<div id="mapid"></div>
						</div>
					</div>
					<?php
						$mapsql = "SELECT * FROM `list` where api =  $api ";
						$mapresult = mysqli_query($mysqli, $mapsql);
						console_log($mapresult);
						//loop through the returned data
						while ($row = mysqli_fetch_array($mapresult)) {
							$lat = $row['surface_latitude_wgs84'];
							console_log($lat);
							$lon = $row['surface_longitude_wgs84'];
							console_log($lon);
						}
						$zoom = 13;
						$xtile = floor((($lon + 180) / 360) * pow(2, $zoom));
						$xtile = truncateCoordinates($lon, 3);
						$ytile = floor((1 - log(tan(deg2rad($lat)) + 1 / cos(deg2rad($lat))) / pi()) /2 * pow(2, $zoom));
						$ytile = truncateCoordinates($lat, 3);
						$n = pow(2, $zoom);
						$lon_deg = 51.505 / $n * 360.0 - 180.0;
						$lat_deg = rad2deg(atan(sinh(pi() * (1 - 2 * (-0.09)) / $n)));
						console_log($xtile);
						console_log($ytile);
						?>
						<?php

						//$datasql = "SELECT * FROM $data WHERE api=$api ORDER BY $pm DESC";
							//console_log($datasql);
						//	$dataresult = mysqli_query($mysqli, $datasql) or die(mysql_error());
								//$result = mysql_query($connect, $sql);
								//$result = mysql_query($sql);
								//$row = mysqli_fetch_array($result);
							//console_log($dataresult);

						?>
					<div class="m-3 p-3 shadow-lg carded-body bg-white">
						<table id='productionTable' class='table bg-white'>
							<thead>
								<tr>
									<th>Month</th>
									<th>Days On</th>
									<th>Gas Production</th>
									<th>Oil Production</th>
									<th>Water Production</th>
									<th>Gas Sold</th>
									<th>Oil Sold</th>
									<th>Line Loss</th>
									<th>Flug</th>
									</tr>
							</thead>
							
						</table>
					</div>
				</div>
				<?php } else { ?>
				<div class="container d-flex justify-content-center">   
					<form action="<?php echo $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" method="post" name="form">
						<div class="form-row form-group">
							<div class="col"><b>Production Data</b></div>
							<div class="col">
								<select class="custom-select" name="api" size="1">
								<?php
									$table = "static_data";
									$sql = "SELECT api, well_lease, well_no FROM $table";// ORDER BY well_lease ASC";
									$result = mysqli_query($mysqli,$sql) or die(mysql_error());
								?>
								<option>Select Well:</option>
								<?php while ($row = mysqli_fetch_array($result)) {
									$wellname = $row['well_lease'] . "# " . $row['well_no']; ?>
								<option value="<?php echo $row['api']; ?>"><?php echo $wellname; //$row['api']; // . $row['well_no'];?></option> 
									<?php } ?>
								</select> 
							</div>
						</div>
						<div class="form-row form-group">
							<div class="col"><input class="btn button primary" type="submit" name="submit" value="Add"></div>
						</div>
					</form>	
									<?php } ?>
				</div>
				<!-- </main> -->
                <?php
                include 'chart_pd.php';
                include 'map_pd.php';
                ?> 
				
			</div>


		</div>
    <!-- </nav> -->
</main>
</div>
<?php include 'floating_action_button.php'; ?>
<!-- Floating Legend -->
<div id="cumulativeproduction" style="display: none;/* top: 11em; left: 50vw; z-index:1500; */">
    <h6>Cum Production on Graph:  </h6>
        <div class="row"><p style="color: #fff;">Oil: <?php echo $cumoil; ?> bbl</p></div>
        <div class="row"><p style="color: #fff;">Gas: <?php echo $cumgas; ?> mcf</p></div>
        <div class="row"><p style="color: #fff;">Water: <?php echo $cumwater; ?> bbl</p></div>
</div>
<!-- Floating Legend -->

<?php include 'ddr_edit_modal.php'; ?>
<?php include 'ddr_add_modal.php'; ?>
<?php include 'dsr_add_modal.php'; ?>
<script type="text/javascript" src="/js/dsr.js"></script>
</body>
<div class="toggle-btn"></div>
<?php 
include 'ddr_datepicker.php'; 
include 'ddr_doubleclick_js.php';
include 'scripts.php'; 
?>
		
<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>

<script>
    const cumprod = document.getElementById('cumulativeproduction');
    tippy('.r-tooltip', { 
          content: cumprod.innerHTML,
          allowHTML: true,
          placement: 'right',
          arrow: false 
        });
</script>


	</html>
