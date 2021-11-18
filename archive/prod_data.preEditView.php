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
        $proddate = $proddate . '"'. $row['prod_mo'].'",';
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
	
    $proddate = trim($proddate,",");
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

    
	$chartsql = "SELECT * FROM `vitals` where api =  $api order by d asc";
    $chartresult = mysqli_query($mysqli, $chartsql);
    // console_log($chartresult);
	//console_log($result);
	//loop through the returned data
	while ($row = mysqli_fetch_array($chartresult)) {
		//$prod_mo = $row['date'];
		$ftp = $row['ftp'];
		$fcp = $row['fcp'];
        $sitp = $row['sitp'];
        $sicp = $row['sicp'];
		$pmp = $row['pmp'];
        $pms = $row['pms'];
        $pmpa = $row['pmpa'];
		$pmsa = $row['pmsa'];
		$ct = $row['ct'];
        $pus = $row['pus'];
		$pusl = $row['pusl'];
		$rsi = $row['rsi'];
        $csi = $row['csi'];
		$rpj = $row['rpj'];
		$fl = $row['fl'];
        $chlr = $row['chlr'];
        $date = $row['d'];
        if($ftp != '')
        {
            $ftpData = $ftpData . '"'. $ftp .'",';
            $ftpDate = $ftpDate . '"'. $date .'",';
            $ftpLastDate = $date;
            $ftpLast = $ftp;
        }
        if($fcp != '')
        {
            $fcpData = $fcpData . '"'. $fcp .'",';
            $fcpDate = $fcpDate . '"'. $date .'",';
            $fcpLastDate = $date;
            $fcpLast = $fcp;
        }
        if($sitp != '')
        {
            $sitpData = $sitpData . '"'. $sitp .'",';
            $sitpDate = $sitpDate . '"'. $date .'",';
            $sitpLastDate = $date;
            $sitpLast = $sitp;
        }
        if($sicp != '')
        {
            $sicpData = $sicpData . '"'. $sicp .'",';
            $sicpDate = $sicpDate . '"'. $date .'",';
            $sicpLastDate = $date;
            $sicpLast = $sicp;
        }
        if($pmp != '')
        {
            $pmpData = $pmpData . '"'. $pmp .'",';
            $pmpDate = $pmpDate . '"'. $date .'",';
            $pmpLastDate = $date;
            $pmpLast = $pmp;
        }
        if($pms != '')
        {
            $pmsData = $pmsData . '"'. $pms .'",';
            $pmsDate = $pmsDate . '"'. $date .'",';
            $pmsLastDate = $date;
            $pmsLast = $pms;
        }
        if($pmpa != '')
        {
            $pmpaData = $pmpaData . '"'. $pmpa .'",';
            $pmpaDate = $pmpaDate . '"'. $date .'",';
            $pmpaLastDate = $date;
            $pmpaLast = $pmpa;
        }
        if($pmsa != '')
        {
            $pmsaData = $pmsaData . '"'. $pmsa .'",';
            $pmsaDate = $pmsaDate . '"'. $date .'",';
            $pmsaLastDate = $date;
            $pmsaLast = $pmsa;
        }
        if($ct != '')
        {
            $ctData = $ctData . '"'. $ct .'",';
            $ctDate = $ctDate . '"'. $date .'",';
            $ctLastDate = $date;
            $ctLast = $ct;
        }
        if($pus != '')
        {
            $pusData = $pusData . '"'. $pus .'",';
            $pusDate = $pusDate . '"'. $date .'",';
            $pusLastDate = $date;
            $pusLast = $pus;
        }
        if($pusl != '')
        {
            $puslData = $puslData . '"'. $pusl .'",';
            $puslDate = $puslDate . '"'. $date .'",';
            $puslLastDate = $date;
            $puslLast = $pusl;
        }
        if($rsi != '')
        {
            $rsiData = $rsiData . '"'. $rsi .'",';
            $rsiDate = $rsiDate . '"'. $date .'",';
            $rsiLastDate = $date;
            $rsiLast = $rsi;
        }
        if($csi != '')
        {
            $csiData = $csiData . '"'. $csi .'",';
            $csiDate = $csiDate . '"'. $date .'",';
            $csiLastDate = $date;
            $csiLast = $csi;
        }
        if($rpj != '')
        {
            $rpjData = $rpjData . '"'. $rpj .'",';
            $rpjDate = $rpjDate . '"'. $date .'",';
            $rpjLastDate = $date;
            $rpjLast = $rpj;
        }
        if($fl != '')
        {
            $flData = $flData . '"'. $fl .'",';
            $flDate = $flDate . '"'. $date .'",';
            $flLastDate = $date;
            $flLast = $fl;
        }
        if($chlr != '')
        {
            $chlrData = $chlrData . '"'. $chlr .'",';
            $chlrDate = $chlrDate . '"'. $date .'",';
            $chlrLastDate = $date;
            $chlrLast = $chlr;
        }


	}
    // console_log($ftp);
    // console_log($fcpDate);
    $ftpData = trim($ftpData,",");
	$ftpDate = trim($ftpDate,",");
    $fcpData = trim($fcpData,",");
    $fcpDate = trim($fcpDate,",");
    $sitpData = trim($sitpData,",");
	$sitpDate = trim($sitpDate,",");
    $sicpData = trim($sicpData,",");
    $sicpDate = trim($sicpDate,",");	
    $pmpData = trim($pmpData,",");
	$pmpDate = trim($pmpDate,",");
    $pmsData = trim($pmsData,",");
    $pmsDate = trim($pmsDate,",");
    $pmpaData = trim($pmpaData,",");
	$pmpaDate = trim($pmpaDate,",");
    $pmsaData = trim($pmsaData,",");
    $pmsaDate = trim($pmsaDate,",");	
    $ctData = trim($ctData,",");
	$ctDate = trim($ctDate,",");
    $pusData = trim($pusData,",");
    $pusDate = trim($pusDate,",");
    $puslData = trim($puslData,",");
	$puslDate = trim($puslDate,",");
    $rsiData = trim($rsiData,",");
    $rsiDate = trim($rsiDate,",");	
    $csiData = trim($csiData,",");
	$csiDate = trim($csiDate,",");
    $rpjData = trim($rpjData,",");
    $rpjDate = trim($rpjDate,",");
    $flData = trim($flData,",");
	$flDate = trim($flDate,",");
    $chlrData = trim($chlrData,",");
    $chlrDate = trim($chlrDate,",");
    // console_log($fcpData);
    // console_log($fcpDate);
    if($ftpLast == ''){ $ftpLast = "Never Recorded";} else { $ftpLast = $ftpLast . " psi";}	
    if($fcpLast == ''){ $fcpLast = "Never Recorded";} else { $fcpLast = $fcpLast . " psi";}	
    if($sitpLast == ''){ $sitpLast = "Never Recorded";} else { $sitpLast = $sitpLast . " psi";}	
    if($sicpLast == ''){ $sicpLast = "Never Recorded";} else { $sicpLast = $sicpLast . " psi";}	
    if($pmpLast == ''){ $pmpLast = "Never Recorded";} 	
    if($pmsLast == ''){ $pmsLast = "Never Recorded";} 	
    if($pmpaLast == ''){ $pmpaLast = "Never Recorded";} else { $pmpaLast = $pmpaLast . " bbl";}	
    if($pmsaLast == ''){ $pmsaLast = "Never Recorded";} else { $pmsaLast = $pmsaLast . " bbl";}	
    if($ctLast == ''){ $ctLast = "Never Recorded";} 	
    if($pusLast == ''){ $pusLast = "Never Recorded";} else { $pusLast = $pusLast . " stroke/min";}	
    if($puslLast == ''){ $puslLast = "Never Recorded";} else { $puslLast = $puslLast . " ft";}	
    if($rsiLast == ''){ $rsiLast = "Never Recorded";} 
    if($csiLast == ''){ $csiLast = "Never Recorded";} 	
    if($rpjLast == ''){ $rpjLast = "Never Recorded";} else { $rpjLast = $rpjLast . " psi";}	
    if($flLast == ''){ $flLast = "Never Recorded";} else { $flLast = $flLast . " ft";}	
    if($chlrLast == ''){ $chlrLast = "Never Recorded";} else { $chlrLast = $chlrLast . " ppm";}	
    
    ## The following creates a check variable for each of the old well notes.
    ## This is used to either show or not show the tabs based on whether the check is 1 or 0.
    $ddr20sql = "SELECT * from `ddr_old` WHERE api like $api";
    $ddr20result = mysqli_query($mysqli, $ddr20sql);
    if(mysqli_num_rows($ddr20result) > 0){
        $ddr20check = 1;
    } else {
        $ddr20check = 0;
    }
    $connWellNotes = connect_wellNotes();
    $convert = "SELECT well from `000api_list` WHERE `api` like \"%".$apiNoQuot."%\"";
    $wellResult = mysqli_query($connWellNotes, $convert);
    while ($row = mysqli_fetch_array($wellResult)) {
        $wellCheck = $row['well'];
    }
    $dsr20sql = "SELECT * from `$wellCheck` WHERE sheet like 'dsr2015pres'";
    $dsr15sql = "SELECT * from `$wellCheck` WHERE sheet like 'before2015sumrpt'";
    $ddr15sql = "SELECT * from `$wellCheck` WHERE sheet like 'before2015detailrpt'";
    try {
        $dsr20result = mysqli_query($connWellNotes, $dsr20sql);
        if(mysqli_num_rows($dsr20result) > 0){
            $dsr20check = 1;
        } else {
            $dsr20check = 0;
        }
        $dsr15result = mysqli_query($connWellNotes, $dsr15sql);
        if(mysqli_num_rows($dsr15result) > 0){
            $dsr15check = 1;
        } else {
            $dsr15check = 0;
        }
        $ddr15result = mysqli_query($connWellNotes, $ddr15sql);
        if(mysqli_num_rows($ddr15result) > 0){
            $ddr15check = 1;
        } else {
            $ddr15check = 0;
        }
    }
    catch (Exception $e) {
        $dsr20check = 0;
        $dsr15check = 0;
        $ddr15check = 0;
    }
    mysqli_close($connWellNotes);
?>
<!doctype html>
<html lang="en">
<head>
    <?php include 'include/dependencies.php'; ?>
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
        <script type="text/javascript" src="js/datatables.prod_data.js?v=1.0.0.53"></script>
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
            <li class="nav-item" role="presentation">
				<a class="nav-link" id="vitals-tab" data-toggle="tab" href="#vitals" role="tab" aria-controls="vitals" aria-selected="false">Vitals</a>
			</li>
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
            <?php if($ddr20check === 1) { ?>
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
                if($ddr15check === 1) { 
            ?>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="t3-tab" data-toggle="tab" href="#t3" role="tab" aria-controls="t3" aria-selected="false">DDR Pre-2015</a>
			</li>
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
			<div class="tab-pane fade " id="info" role="tabpanel" aria-labelledby="info-tab" style="position: relative; z-index: 940;">
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
                        <div class="row justify-content-center bg-light">
                            <div class="p-3 col-11 " >
                                <div class="m-3 p-3 shadow-lg carded-body bg-white">
                                    <table id='notesTable' class='table bg-white table-sm smol'>
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

            <div class="tab-pane fade " id="dsr" role="tabpanel" aria-labelledby="dsr-tab" style="position: relative; z-index: 940;">
                <div class="carded m-3 p-3 shadow-lg">
                    <div class="carded-header">
                    <h1>DSR-D</h1>
                    <div class="mx-auto" name="add_dsr" id="add_dsr" href="#add_data_dsr_Modal" data-toggle="modal"><a class="btn btn-primary btn-lg" id=<?php echo $api; ?> href="#">Add DSR Entry</a></div>
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
            <div class="tab-pane fade " id="t2" role="tabpanel" aria-labelledby="t2-tab" style="position: relative; z-index: 940;">
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
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            <div class="tab-pane fade " id="t3" role="tabpanel" aria-labelledby="t3-tab" style="position: relative; z-index: 940;">
                <div class="carded m-3 p-3 shadow-lg">
                    <div class="carded-header">
                        <h1>Before 2015 Detail Report</h1></div>
                        <div class="carded-body">
                            <table id="before2015detailrpt" class="table display table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-sm table-hover" style="width=100%;">
                                <thead class="bg-sog">
                                    <tr>
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
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            <div class="tab-pane fade " id="t4" role="tabpanel" aria-labelledby="t4-tab" style="position: relative; z-index: 940;">
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
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
			<div class="tab-pane fade in show active" id="detail" role="tabpanel" aria-labelledby="detail-tab" style="position: relative; z-index: 940;"> 
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
						// console_log($mapresult);
						//loop through the returned data
						while ($row = mysqli_fetch_array($mapresult)) {
							$lat = $row['surface_latitude_wgs84'];
							// console_log($lat);
							$lon = $row['surface_longitude_wgs84'];
							// console_log($lon);
						}
						$zoom = 13;
						$xtile = floor((($lon + 180) / 360) * pow(2, $zoom));
						$xtile = truncateCoordinates($lon, 3);
						$ytile = floor((1 - log(tan(deg2rad($lat)) + 1 / cos(deg2rad($lat))) / pi()) /2 * pow(2, $zoom));
						$ytile = truncateCoordinates($lat, 3);
						$n = pow(2, $zoom);
						$lon_deg = 51.505 / $n * 360.0 - 180.0;
						$lat_deg = rad2deg(atan(sinh(pi() * (1 - 2 * (-0.09)) / $n)));
						// console_log($xtile);
						// console_log($ytile);
						?>
					<div class="m-3 p-3 shadow-lg carded-body bg-white">
						<table id='productionTable' class='table bg-white table-sm smol'>
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
				<script>
					let myScale = Chart.Scale.extend({
					/* extensions ... */
					});
					var ctx = document.getElementById("chart").getContext('2d');
					var myChart = new Chart(ctx, {
					type: 'line',
					data: {
						labels: [<?php echo $proddate; ?>],
						datasets: 
						[{
							label: 'Oil',
							data: [<?php echo $data1; ?>],
							backgroundColor: 'transparent',
							//backgroundColor: 'rgba(255,99,132)',
							borderColor:'rgba(132,255,99)',
							//borderColor: 'transparent',
							borderWidth: 1,
							pointBackgroundColor: 'rgba(0, 0, 0, 0)',
							pointBorderColor: 'rgba(0, 0, 0, 0)',
							pointBorderWidth: 1,
							//steppedLine = 'before'
							//steppedLine: true,
							yAxisID: 'bbl-y-axis'
						},
						{
							label: 'Gas',
							data: [<?php echo $data2; ?>],
							backgroundColor: 'transparent',
							borderColor:'rgba(255,99,132)',
							borderWidth: 1,
							pointBackgroundColor: 'rgba(0, 0, 0, 0)',
							pointBorderColor: 'rgba(0, 0, 0, 0)',
							pointBorderWidth: 1,
							yAxisID: 'mcf-y-axis'	
						},
						{
							label: 'Water',
							data: [<?php echo $data3; ?>],
							backgroundColor: 'transparent',
							borderColor:'rgba(99,132,255)',
							borderWidth: 1,
							pointBackgroundColor: 'rgba(0, 0, 0, 0)',
							pointBorderColor: 'rgba(0, 0, 0, 0)',
							pointBorderWidth: 1,
							yAxisID: 'bbl-y-axis'
						}]
					},
				
					options: {
						responsive: true,
						scales: {
							xAxes: [{
								display: true,
							}],
							yAxes: [{
								id: 'bbl-y-axis',
								display: true,
								type: 'logarithmic',
								position: 'left',
								// ticks: {
								//     callback: function(label, index, labels) {
								//         return index;
								// 	},
								//  },
								scaleLabel: {
									display: true,
									labelString: 'Oil (bbl); Water (bbl)'
								}
							}, {
								id: 'mcf-y-axis',
								display: true,
								type: 'logarithmic',
								position: 'right',
								//ticks: label,
								// ticks: {
								// callback: function(label, index, labels) {
								//         return index;
								// 	},
								// }, 
								scaleLabel: {
									display: true,
									labelString: 'Gas (mcf)'
								}
							}]
							/* scales:{
								yAxes: [{
									beginAtZero: false, 
									display: true, 
									type: 'logarithmic',
								}], 
								xAxes: [{
									autoskip: true, 
									maxTicketsLimit: 20
								}]
							} */
						},
						tooltips:{mode: 'index'},
						legend:{display: true, position: 'top', labels: {fontColor: 'rgb(0,0,0)', fontSize: 16}},
						plugins: {
							zoom: {
								pan: {
								
									enabled: true,

									mode: 'x',
									// xScale0: {
									// 					max: 1e4
									// 				},
									
								},
								zoom: {			
									enabled: true,
									drag: false,
									mode: 'x',
								}
							}
						}
					}
					});
				</script> 
				<script>
					var mymap = L.map('mapid').setView([<?php echo $ytile; ?>,<?php echo $xtile; ?>], 13<?php //echo $zoom; ?>);

					L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
						attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
						maxZoom: 18,
						id: 'mapbox/streets-v11',
						tileSize: 512,
						zoomOffset: -1,
						accessToken: 'pk.eyJ1IjoiaHlkcm9jYXJib24iLCJhIjoiY2thYThrdjZnMGxieDJxbjV0ZW9jZTJ0bSJ9.8kj2dNLDSlNU0IMGoTRZ4g'
					}).addTo(mymap);
					var circle = L.circle([<?php echo $ytile; ?>,<?php echo $xtile; ?>], {
						color: 'red',
						fillColor: '#f03',
						fillOpacity: 0.5,
						radius: 500
					}).addTo(mymap);
				</script>
			<!-- </div> -->
            <div class="tab-pane fade" id="vitals" role="tabpanel" aria-labelledby="vitals-tab" style="position: relative; z-index: 940;"> 
				<div class="carded bg-light">
                    
                    <div class="row justify-content-center">
                        <div class="col-6 m-3">
                            <div class="carded-header" style="padding: 0rem 0rem!important; background-color:transparent;">
                                <ul class="nav nav-tabs" >
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#ftp">Tubing Pressure</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#fcp">Casing Pressure</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sitp">SI Tubing Pressure</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sicp">SI Casing Pressure</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pu">Pumping Unit</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#fl">Fluid Level</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#chlr">Chlorides</a></li>
                                </ul>
                            </div>
                            <div class="p-3 shadow-lg carded-body bg-white">
                                <div class="tab-content">
                                    <div id="ftp" class="tab-pane fade in show active">
                                        <h3 class="carded-title">Flowing Tubing Pressure</h3>
                                        <div class="chart-container">
                                            <canvas id="ftp-chart" style="width: 100%; height: 50vh;"></canvas> 
                                        </div>
                                    </div>
                                    <div id="fcp" class="tab-pane fade">
                                        <h3 class="carded-title">Flowing Casing Pressure</h3>
                                        <div class="chart-container">
                                            <canvas id="fcp-chart" style="width: 100%; height: 50vh;"></canvas> 
                                        </div>
                                    </div>
                                    <div id="sitp" class="tab-pane fade">
                                        <h3 class="carded-title">SI Tubing Pressure</h3>
                                        <div class="chart-container">
                                            <canvas id="sitp-chart" style="width: 100%; height: 50vh;"></canvas> 
                                        </div>
                                    </div>
                                    <div id="sicp" class="tab-pane fade">
                                        <h3 class="carded-title">SI Casing Pressure</h3>
                                        <div class="chart-container">
                                            <canvas id="sicp-chart" style="width: 100%; height: 50vh;"></canvas> 
                                        </div>
                                    </div>
                                    <div id="pu" class="tab-pane fade">
                                        <h3 class="carded-title">Pumping Unit</h3>
                                        <div class="chart-container">
                                            <canvas id="pu-chart" style="width: 100%; height: 50vh;"></canvas> 
                                        </div>
                                    </div>
                                    <div id="fl" class="tab-pane fade">
                                        <h3 class="carded-title">Fluid Level</h3>
                                        <div class="chart-container">
                                            <canvas id="fl-chart" style="width: 100%; height: 50vh;"></canvas> 
                                        </div>
                                    </div>
                                    <div id="chlr" class="tab-pane fade">
                                        <h3 class="carded-title">Chlorides</h3>
                                        <div class="chart-container">
                                            <canvas id="chlr-chart" style="width: 100%; height: 50vh;"></canvas> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-5 m-3">
                            <div class="carded-header" style="padding: 0rem 0rem!important; background-color:transparent;">
                            
                                <ul class="nav nav-tabs">
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#last">Last Update</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sihist">Shut In History</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pmhist">Preventative Maintenance History</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pjhist">Pull Job History</a></li>
                                </ul>
                            </div>
                            <div class="p-3 shadow-lg carded-body bg-white">
                                <div class="tab-content">
                                    <div id="last" class="tab-pane fade in show active">
                                        <div class="row justify-content-center ">
                                            <h3 class="carded-title"><strong>Last Updated Well Vitals</strong></h5>
                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Vital Statistic:</p>
                                            </div>
                                            <div class="col">
                                                <p>&nbsp;</p>
                                            </div>
                                            <div class="col">
                                                <p>Last Updated:</p>
                                            </div>

                                            
                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Flowing Tubing Pressure:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $ftpLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $ftpLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Flowing Casing Pressure:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $fcpLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $fcpLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>SI Tubing Pressure:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $sitpLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $sitpLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>SI Casing Pressure:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $sicpLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $sicpLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Fluid Level:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $flLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $flLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Chlorides:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $chlrLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $chlrLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Type of Chemical Treatment:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $ctLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $ctLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Reason for Last Pull Job:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $rpjLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $rpjLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>General Reason for SI:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $rsiLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $rsiLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Comments on SI:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $csiLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $csiLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Primary PM:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $pmpLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $pmpLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Primary PM Amount:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $pmpaLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $pmpaLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Secondary PM:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $pmsLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $pmsLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Secondary PM Amount:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $pmsaLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $pmsaLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Pumping Unit Speed:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $pusLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $pusLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Pumping Unit Stroke Length:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $puslLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $puslLastDate; ?></p>
                                            </div>
                                            <div class="w-100"></div>

                                            
                                        </div>
                                    </div>
                                    <div id="sihist" class="row justify-content-center tab-pane fade">
                                        <h3 class="carded-title">SI History</h3>
                                        <table id='siTable' class='table bg-white table-sm smol'>
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>SI Tubing Pressure</th>
                                                    <th>SI Casing Pressure</th>
                                                    <th>General Reason for SI</th>
                                                    <th>Comments on SI</th>    
                                                </tr>
                                            </thead>                                       
                                        </table>
                                    </div>
                                    <div id="pmhist" class="row justify-content-center tab-pane fade">
                                        <h3 class="carded-title">Preventative Maintenance History</h3>
                                        <table id='pmTable' class='table bg-white table-sm smol'>
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>P. PM</th>
                                                    <th>P. PM Amount</th>
                                                    <th>S. PM</th>
                                                    <th>S. PM Amount</th>
                                                </tr>
                                            </thead>
                                            
                                        </table>
                                    </div>
                                    <div id="pjhist" class="row justify-content-center tab-pane fade">
                                        <h3 class="carded-title">Pull Job History</h3>
                                        <table id='pjTable' class='table bg-white table-sm smol'>
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Reason for Last Pull Job</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>    
                            </div>
                        </div>
					</div>
					<div class="m-3 p-3 shadow-lg carded-body bg-white">
                        <h3 class="carded-title">Full Vitals History</h3>
						<table id='vitalsTable' class='table bg-white table-sm smol'>
							<thead>
									<th>Date</th>
									<th>FTP</th>
									<th>FCP</th>
									<th>SITP</th>
									<th>SICP</th>
									<th>FL</th>
									<th>Chlorides</th>
									<th>Chem. Treat.</th>
									<th>Reason for Last Pull Job</th>
                                    <th>General Reason for SI</th>
                                    <th>Comments on SI</th>
                                    <th>P. PM</th>
                                   
                                    <th>S. PM</th>
                                   
                                    <th>PU Speed</th>
                                    <th>PU SL</th>
                                    <th>PU On/Off</th>
									
							</thead>
							
						</table>
					</div>
                    
				</div>
		</div>
</main>
<script>
    var pu_ctx = document.getElementById("pu-chart").getContext('2d');
    var pu_chart = new Chart(pu_ctx, {
    type: 'line',
    data: {
        labels: [<?php echo $pusDate; ?>],
        datasets: 
        [{
            label: 'Pumping Unit Speed',
            data: [<?php echo $pusData; ?>],
            backgroundColor: 'transparent',
            //backgroundColor: 'rgba(255,99,132)',
            borderColor:'rgba(132,255,99)',
            //borderColor: 'transparent',
            borderWidth: 1,
            pointBackgroundColor: 'rgba(0, 0, 0, 0)',
            pointBorderColor: 'rgba(0, 0, 0, 0)',
            pointBorderWidth: 1,
            //steppedLine = 'before'
            //steppedLine: true,
            yAxisID: 'speed-y-axis'
        },
        {
            label: 'Pumping Unit Stroke Length',
            data: [<?php echo $puslData; ?>],
            backgroundColor: 'transparent',
            borderColor:'rgba(255,99,132)',
            borderWidth: 1,
            pointBackgroundColor: 'rgba(0, 0, 0, 0)',
            pointBorderColor: 'rgba(0, 0, 0, 0)',
            pointBorderWidth: 1,
            yAxisID: 'length-y-axis'	
        },
        // {
        //     label: 'Water',
        //     data: [<?php //echo $data3; ?>],
        //     backgroundColor: 'transparent',
        //     borderColor:'rgba(99,132,255)',
        //     borderWidth: 1,
        //     pointBackgroundColor: 'rgba(0, 0, 0, 0)',
        //     pointBorderColor: 'rgba(0, 0, 0, 0)',
        //     pointBorderWidth: 1,
        //     yAxisID: 'bbl-y-axis'
        // }
        ]
    },

    options: {
        responsive: true,
        scales: {
            xAxes: [{
                display: true,
            }],
            yAxes: [{
                id: 'speed-y-axis',
                display: true,
                // type: 'logarithmic',
                position: 'left',
                // ticks: {
                //     callback: function(label, index, labels) {
                //         return index;
                // 	},
                //  },
                scaleLabel: {
                    display: true,
                    labelString: 'Speed (stroke/min)'
                }
            }, {
                id: 'length-y-axis',
                display: true,
                type: 'logarithmic',
                position: 'right',
                //ticks: label,
                // ticks: {
                // callback: function(label, index, labels) {
                //         return index;
                // 	},
                // }, 
                scaleLabel: {
                    display: true,
                    labelString: 'Stroke Length (ft)'
                }
            }]
            /* scales:{
                yAxes: [{
                    beginAtZero: false, 
                    display: true, 
                    type: 'logarithmic',
                }], 
                xAxes: [{
                    autoskip: true, 
                    maxTicketsLimit: 20
                }]
            } */
        },
        tooltips:{mode: 'index'},
        legend:{display: true, position: 'top', labels: {fontColor: 'rgb(0,0,0)', fontSize: 16}},
        plugins: {
            zoom: {
                pan: {
                
                    enabled: true,

                    mode: 'x',
                    // xScale0: {
                    // 					max: 1e4
                    // 				},
                    
                },
                zoom: {			
                    enabled: true,
                    drag: false,
                    mode: 'x',
                }
            }
        }
    }
    });
    

    var fcp_ctx = document.getElementById('fcp-chart').getContext('2d');
    var fcp_chart = new Chart(fcp_ctx, {
    type: 'line',
    data: {
        labels: [<?php echo $fcpDate; ?>],
        datasets: 
        [{
            label: 'Flowing Casing Pressure',
            data: [<?php echo $fcpData; ?>],
            backgroundColor: 'transparent',
            //backgroundColor: 'rgba(255,99,132)',
            borderColor:'rgba(132,255,99)',
            //borderColor: 'transparent',
            borderWidth: 1,
            pointBackgroundColor: 'rgba(0, 0, 0, 0)',
            pointBorderColor: 'rgba(0, 0, 0, 0)',
            pointBorderWidth: 1,
            //steppedLine = 'before'
            //steppedLine: true,
            yAxisID: 'bbl-y-axis'
        },
    ]
    },

    options: {
        responsive: true,
        scales: {
            xAxes: [{
                display: true,
            }],
            yAxes: [{
                id: 'bbl-y-axis',
                display: true,
                // type: 'logarithmic',
                position: 'left',
                scaleLabel: {
                    display: true,
                    labelString: 'Pressure (psi)'
                }
            }]
        },
        tooltips:{mode: 'index'},
        legend:{display: true, position: 'top', labels: {fontColor: 'rgb(0,0,0)', fontSize: 16}},
        plugins: {
            zoom: {
                pan: {
                
                    enabled: true,

                    mode: 'x',
                    
                },
                zoom: {			
                    enabled: true,
                    drag: false,
                    mode: 'x',
                }
            }
        }
    }
    });
    var sitp_ctx = document.getElementById('sitp-chart').getContext('2d');
    var sitp_chart = new Chart(sitp_ctx, {
    type: 'line',
    data: {
        labels: [<?php echo $sitpDate; ?>],
        datasets: 
        [{
            label: 'SI Tubing Pressure',
            data: [<?php echo $sitpData; ?>],
            backgroundColor: 'transparent',
            //backgroundColor: 'rgba(255,99,132)',
            borderColor:'rgba(132,255,99)',
            //borderColor: 'transparent',
            borderWidth: 1,
            pointBackgroundColor: 'rgba(0, 0, 0, 0)',
            pointBorderColor: 'rgba(0, 0, 0, 0)',
            pointBorderWidth: 1,
            //steppedLine = 'before'
            //steppedLine: true,
            yAxisID: 'bbl-y-axis'
        },
    ]
    },

    options: {
        responsive: true,
        scales: {
            xAxes: [{
                display: true,
            }],
            yAxes: [{
                id: 'bbl-y-axis',
                display: true,
                // type: 'logarithmic',
                position: 'left',
                scaleLabel: {
                    display: true,
                    labelString: 'Pressure (psi)'
                }
            }]
        },
        tooltips:{mode: 'index'},
        legend:{display: true, position: 'top', labels: {fontColor: 'rgb(0,0,0)', fontSize: 16}},
        plugins: {
            zoom: {
                pan: {
                
                    enabled: true,

                    mode: 'x',
                    
                },
                zoom: {			
                    enabled: true,
                    drag: false,
                    mode: 'x',
                }
            }
        }
    }
    });
    var sicp_ctx = document.getElementById('sicp-chart').getContext('2d');
    var sicp_chart = new Chart(sicp_ctx, {
    type: 'line',
    data: {
        labels: [<?php echo $sicpDate; ?>],
        datasets: 
        [{
            label: 'SI Casing Pressure',
            data: [<?php echo $sicpData; ?>],
            backgroundColor: 'transparent',
            //backgroundColor: 'rgba(255,99,132)',
            borderColor:'rgba(132,255,99)',
            //borderColor: 'transparent',
            borderWidth: 1,
            pointBackgroundColor: 'rgba(0, 0, 0, 0)',
            pointBorderColor: 'rgba(0, 0, 0, 0)',
            pointBorderWidth: 1,
            //steppedLine = 'before'
            //steppedLine: true,
            yAxisID: 'bbl-y-axis'
        },
    ]
    },

    options: {
        responsive: true,
        scales: {
            xAxes: [{
                display: true,
            }],
            yAxes: [{
                id: 'bbl-y-axis',
                display: true,
                // type: 'logarithmic',
                position: 'left',
                scaleLabel: {
                    display: true,
                    labelString: 'Pressure (psi)'
                }
            }]
        },
        tooltips:{mode: 'index'},
        legend:{display: true, position: 'top', labels: {fontColor: 'rgb(0,0,0)', fontSize: 16}},
        plugins: {
            zoom: {
                pan: {
                
                    enabled: true,

                    mode: 'x',
                    
                },
                zoom: {			
                    enabled: true,
                    drag: false,
                    mode: 'x',
                }
            }
        }
    }
    });
    var fl_ctx = document.getElementById('fl-chart').getContext('2d');
    var fl_chart = new Chart(fl_ctx, {
    type: 'line',
    data: {
        labels: [<?php echo $flDate; ?>],
        datasets: 
        [{
            label: 'Fluid Level',
            data: [<?php echo $flData; ?>],
            backgroundColor: 'transparent',
            //backgroundColor: 'rgba(255,99,132)',
            borderColor:'rgba(132,255,99)',
            //borderColor: 'transparent',
            borderWidth: 1,
            pointBackgroundColor: 'rgba(0, 0, 0, 0)',
            pointBorderColor: 'rgba(0, 0, 0, 0)',
            pointBorderWidth: 1,
            //steppedLine = 'before'
            //steppedLine: true,
            yAxisID: 'bbl-y-axis'
        },
    ]
    },

    options: {
        responsive: true,
        scales: {
            xAxes: [{
                display: true,
            }],
            yAxes: [{
                id: 'bbl-y-axis',
                display: true,
                // type: 'logarithmic',
                position: 'left',
                scaleLabel: {
                    display: true,
                    labelString: 'Height (ft)'
                }
            }]
        },
        tooltips:{mode: 'index'},
        legend:{display: true, position: 'top', labels: {fontColor: 'rgb(0,0,0)', fontSize: 16}},
        plugins: {
            zoom: {
                pan: {
                
                    enabled: true,

                    mode: 'x',
                    
                },
                zoom: {			
                    enabled: true,
                    drag: false,
                    mode: 'x',
                }
            }
        }
    }
    });
    var chlr_ctx = document.getElementById('chlr-chart').getContext('2d');
    var chlr_chart = new Chart(chlr_ctx, {
    type: 'line',
    data: {
        labels: [<?php echo $chlrDate; ?>],
        datasets: 
        [{
            label: 'Chlorides',
            data: [<?php echo $chlrData; ?>],
            backgroundColor: 'transparent',
            //backgroundColor: 'rgba(255,99,132)',
            borderColor:'rgba(132,255,99)',
            //borderColor: 'transparent',
            borderWidth: 1,
            pointBackgroundColor: 'rgba(0, 0, 0, 0)',
            pointBorderColor: 'rgba(0, 0, 0, 0)',
            pointBorderWidth: 1,
            //steppedLine = 'before'
            //steppedLine: true,
            yAxisID: 'bbl-y-axis'
        },
    ]
    },

    options: {
        responsive: true,
        scales: {
            xAxes: [{
                display: true,
            }],
            yAxes: [{
                id: 'bbl-y-axis',
                display: true,
                // type: 'logarithmic',
                position: 'left',
                scaleLabel: {
                    display: true,
                    labelString: 'Chlorides (ppm)'
                }
            }]
        },
        tooltips:{mode: 'index'},
        legend:{display: true, position: 'top', labels: {fontColor: 'rgb(0,0,0)', fontSize: 16}},
        plugins: {
            zoom: {
                pan: {
                
                    enabled: true,

                    mode: 'x',
                    
                },
                zoom: {			
                    enabled: true,
                    drag: false,
                    mode: 'x',
                }
            }
        }
    }
    });
    var ftp_ctx = document.getElementById('ftp-chart').getContext('2d');
    var ftp_chart = new Chart(ftp_ctx, {
    type: 'line',
    data: {
        labels: [<?php echo $ftpDate; ?>],
        datasets: 
        [{
            label: 'Flowing Tubing Pressure',
            data: [<?php echo $ftpData; ?>],
            backgroundColor: 'transparent',
            //backgroundColor: 'rgba(255,99,132)',
            borderColor:'rgba(132,255,99)',
            //borderColor: 'transparent',
            borderWidth: 1,
            pointBackgroundColor: 'rgba(0, 0, 0, 0)',
            pointBorderColor: 'rgba(0, 0, 0, 0)',
            pointBorderWidth: 1,
            //steppedLine = 'before'
            //steppedLine: true,
            yAxisID: 'bbl-y-axis'
        },
    ]
    },

    options: {
        responsive: true,
        scales: {
            xAxes: [{
                display: true,
            }],
            yAxes: [{
                id: 'bbl-y-axis',
                display: true,
                // type: 'logarithmic',
                position: 'left',
                scaleLabel: {
                    display: true,
                    labelString: 'Pressure (psi)'
                }
            }]
        },
        tooltips:{mode: 'index'},
        legend:{display: true, position: 'top', labels: {fontColor: 'rgb(0,0,0)', fontSize: 16}},
        plugins: {
            zoom: {
                pan: {
                
                    enabled: true,

                    mode: 'x',
                    
                },
                zoom: {			
                    enabled: true,
                    drag: false,
                    mode: 'x',
                }
            }
        }
    }
    });
	
</script> 

</div>

<!-- Floating Legend -->
<div id="cumulativeproduction" style="display: none;/* top: 11em; left: 50vw; z-index:1500; */">
    <h6>Cum Production on Graph:  </h6>
        <div class="row"><p style="color: #fff;">Oil: <?php echo $cumoil; ?> bbl</p></div>
        <div class="row"><p style="color: #fff;">Gas: <?php echo $cumgas; ?> mcf</p></div>
        <div class="row"><p style="color: #fff;">Water: <?php echo $cumwater; ?> bbl</p></div>
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
    const cumprod = document.getElementById('cumulativeproduction');
    tippy('.r-tooltip', { 
          content: cumprod.innerHTML,
          allowHTML: true,
          placement: 'right',
          arrow: false 
        });
</script>   
<script type="text/javascript" src="WSB/stylesheet/offcanvas.js.download"></script>


	</html>
