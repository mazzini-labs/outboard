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

include 'WSB/includes.php';
include 'header.php';
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
	}
	
    $date = trim($date,",");
	$data1 = trim($data1,",");
    $data2 = trim($data2,",");
    $data3 = trim($data3,",");
	
		
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="x-ua-compatible" content="ie=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/maintest.css?=v1.2">
	<link rel="stylesheet" type="text/css" href="css/tabs.css">
	<link rel="stylesheet" type="text/css" href="css/search.css">
		<!-- Bootstrap core CSS -->
	<!-- <link href="WSB/stylesheet/bootstrap.min.css" type="text/css" rel="stylesheet"> -->

	<!-- Custom styles for this template -->

	<link href="WSB/stylesheet/offcanvas.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>

	<script type="text/javascript" src="datatables/datatables.min.js"></script>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
	integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
	crossorigin=""/>
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
	integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
	crossorigin=""></script>
		<!-- <script src="dashboard/jquery-3.2.1.slim.min.js.download" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
		<!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
		
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script> -->
		
		<script type="text/javascript" src="js/chart.js"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@0.7.7"></script>
		<script type="text/javascript" src="./assets/js/inlineEdit.js"></script>
		<style>
			#mapid { 
				/* width: 50%; */
				height: 50vh; 
			}
			body {
					/* top: 56px; */
				overflow-y: hidden; /* Hide scrollbars */
			} 	
			.production {
				width: 100%;
				display: inline-table;
				height:auto;
				table-layout: fixed;
				/* padding-left: 5%; */
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
		<style type="text/css" class="init">
			.borderLit{
				border-color: rgba(0,255,0,0.5);
			}
			div.dataTables_wrapper {
				width: 800px;
				margin: 0 auto;
			}
		</style>
		<script type="text/javascript" class="init">
			$(document).ready(function() {
				var oTable = $('#productionTable').DataTable( {
						"order": [],
						"scrollY":        "100px",
						"scrollCollapse": true,
						"paging":         false,
						"searching": true,
						"sDom": 'd'
				} );
				$('#searchProduction').keyup(function(){
						oTable.search($(this).val()).draw() ;
					})
			} );
		</script>

		
			
		<title><?php echo $well; ?></title>
</head>

<body>
<div class=' '>     
<main role="main" class="col-sm-auto pt-5" >
	<nav id="tabs">
		<ul class="nav nav-tabs justify-content-center pt-1" id="myTab" role="tablist" style="position: relative; z-index: 1040;">
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">Well Info</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link active" id="detail-tab" data-toggle="tab" href="#detail" role="tab" aria-controls="detail" aria-selected="true">Detailed Production</a>
			</li>
			<!-- <li class="nav-item" role="presentation">
				<a class="nav-link" id="t2-tab" data-toggle="tab" href="#t2" role="tab" aria-controls="t2" aria-selected="false">DSR 2015-Present</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="t3-tab" data-toggle="tab" href="#t3" role="tab" aria-controls="t3" aria-selected="false">Before 2015 Detail Report</a>
			</li> -->
		</ul> 
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade " id="info" role="tabpanel" aria-labelledby="info-tab" style="position: relative; z-index: 1040;">
				<!-- <div class="container-fluid" style="background-color:white;"> -->
					<div class="row">
						<div class="col-6">
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
								<p><small>Last updated: <?php echo $db_notes_update; ?></small></p>
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
						<div class="col-6">
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
							<div class="row">
								<p>Last Produced: <?php echo $lastprod; ?></p>
								<p><small>Produced for <?php echo $monthsproduced; ?> months</small></p>
							</div>
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
			<div class="tab-pane fade in show active" id="detail" role="tabpanel" aria-labelledby="detail-tab" style="position: relative; z-index: 1040;"> 
				<!-- <main role="main" class="col-sm-auto pt-5" style="top: 7.5vh;"> -->
				<div class="container-fluid" style="background-color:white;">
					<div class="row">
						<div class="col-6">
							<h3><?php echo $well; ?></h3>
							<div class="chart-container">
								<canvas id="chart" style="width: 100%; height: 50vh;"></canvas> 
							</div>
						</div>
						<div class="col-6">
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

						$datasql = "SELECT * FROM $data WHERE api=$api ORDER BY $pm DESC";
							//console_log($datasql);
							$dataresult = mysqli_query($mysqli, $datasql) or die(mysql_error());
								//$result = mysql_query($connect, $sql);
								//$result = mysql_query($sql);
								//$row = mysqli_fetch_array($result);
							//console_log($dataresult);

						?>
					<div class=" table-responsive">
						<table id='productionTable' class='table'>
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
							<tbody>
								<?php
									//echo "TESTING";
									while($datarow = mysqli_fetch_array($dataresult)){ 
									
											$daysOn = $datarow['days_on'];
											$month = $datarow['prod_mo'];
											$gas = $datarow['gas_wh_mcf'];
											$gasSold = $datarow['gas_sold'];
											$loss = $datarow['gas_line_loss'];
											$flug = $datarow['flug'] * 10;
											$oil = $datarow['oil_prod'];
											$oilSold = $datarow['oil_sold'];
											$water = $datarow['water_prod'];
										
										echo "<tr class='production'>";
											echo "<td>".$month."</td>";
											echo "<td>".$daysOn."</td>";
											echo "<td>".$gas." mcf</td>";
											echo "<td>".$oil." bbl</td>";
											echo "<td>".$water." bbl</td>";
											echo "<td>".$gasSold." mcf</td>";
											echo "<td>".$oilSold." bbl</td>";
											echo "<td>".$loss." mcf</td>";
											echo "<td>".$flug."%</td>";
											echo "</tr>";
										
										}
								?>
							</tbody>
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
				<script>
					let myScale = Chart.Scale.extend({
					/* extensions ... */
					});
					var ctx = document.getElementById("chart").getContext('2d');
					var myChart = new Chart(ctx, {
					type: 'line',
					data: {
						labels: [<?php echo $date; ?>],
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
			</div>
			<?php 
			// $ddr = "new_ddr";
			// $sub_date = "submission_date";
			// $datasql = "SELECT * FROM $ddr WHERE api=$api ORDER BY $sub_date DESC";
			// //console_log($datasql);
			// $dataresult = mysqli_query($mysqli, $datasql) or die(mysql_error());
			// while($datarow = mysqli_fetch_array($dataresult)){ 
									
			// 	$daysOn = $datarow['days_on'];
			// 	$month = $datarow['prod_mo'];
			// 	$gas = $datarow['gas_wh_mcf'];
			// 	$gasSold = $datarow['gas_sold'];
			// 	$loss = $datarow['gas_line_loss'];
			// 	$flug = $datarow['flug'] * 10;
			// 	$oil = $datarow['oil_prod'];
			// 	$oilSold = $datarow['oil_sold'];
			// 	$water = $datarow['water_prod'];
			
			// echo "<tr class='production'>";
			// 	echo "<td>".$month."</td>";
			// 	echo "<td>".$daysOn."</td>";
			// 	echo "<td>".$gas." mcf</td>";
			// 	echo "<td>".$oil." bbl</td>";
			// 	echo "<td>".$water." bbl</td>";
			// 	echo "<td>".$gasSold." mcf</td>";
			// 	echo "<td>".$oilSold." bbl</td>";
			// 	echo "<td>".$loss." mcf</td>";
			// 	echo "<td>".$flug."%</td>";
			// 	echo "</tr>";
			
			// }
                $query = "SELECT
                                `new_ddr`.*
                            FROM
                                new_ddr
                            WHERE
                                `new_ddr`.`api` = '$api'";
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
                    <table id="shutinTable" class='table bg-sog table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-sm' style="margin-top: 0px !important;" >
                        <thead>
								<th <?php echo $width2; ?>>Date</th>
								<th <?php echo $width7; ?>>Time</th>
                                <th <?php echo $width4; ?>>Vendor / Contact</a></th>
                                <th <?php echo $width14; ?>>Invoice Details / DDR/a></th>
                                <th <?php echo $width2; ?>>$ / EDC</a></th>
								<th <?php echo $width2; ?>>Approvals / ECC</a></th>
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
							$type = $row['type'];
							if($type != "dsr")
							{
								$department = $row['department'];
								
								switch($department)
								{
									case "eng":
										$ddr_date = $row['date'];
										$time_start = $row['time_start'];
										$time_end = $row['time_end'];
										$eng_contact = $row['eng_contact'];
										$eng_contact_info = $row['eng_contact_info'];
										$eng_daily_report = $row['eng_daily_report'];
										$eng_edc = $row['eng_edc'];
										$eng_ecc = $row['eng_ecc'];
										$data_entry_by = $row['data_entry_by'];
										$submission_date = $row['submission_date'];
										echo "<tr>\n";
										echo "<td $width2><small>$ddr_date</td ></small>\n";
										echo "<td $width7><small>$time_start - $time_end</td ></small>\n";
										echo "<td $width4><small>$eng_contact</a></td ></small>\n";
										echo "<td $width2><small>$eng_contact_info</td ></small>\n";
										echo "<td $width14><small>$eng_daily_report</small> </td >\n";
										echo "<td $width2><small>$eng_edc</td ></small>\n";
										echo "<td $width2><small>$eng_ecc</td ></small>\n";
										echo "</tr>\n"; 
									break;
									case "acct":
										$ddr_date = $row['date'];
										$time_start = $row['time_start'];
										$time_end = $row['time_end'];
										$acct_vendor = $row['acct_vendor'];
										$acct_invoice_no = $row['acct_invoice_no'];
										$acct_invoice_details = $row['acct_invoice_details'];
										$acct_invoice_amt = $row['acct_invoice_amt'];
										$acct_approval_initials = $row['acct_approval_initials'];
										$acct_approval_date = $row['acct_approval_date'];
										$data_entry_by = $row['data_entry_by'];
										$submission_date = $row['submission_date'];
										echo "<tr>\n";
										echo "<td $width2><small>$ddr_date</td ></small>\n";
										echo "<td $width7><small>$time_start - $time_end</td ></small>\n";
										echo "<td $width4><small>$acct_vendor</a></td ></small>\n";
										echo "<td $width2><small>$acct_invoice_no</td ></small>\n";
										echo "<td $width14><small>$eng_daily_report</small> </td >\n";
										echo "<td $width2><small>$eng_edc</td ></small>\n";
										echo "<td $width2><small>$eng_ecc</td ></small>\n";
										echo "</tr>\n"; 
									break;
									case "vendor":
										$vend_name = $row['vend_name'];
										$vend_service = $row['vend_service'];
										$vend_aol = $row['vend_aol'];
										$vend_ll = $row['vend_ll'];
										$vend_hours = $row['vend_hours'];
										$vend_deduct_time = $row['vend_deduct_time'];
										$vend_deduct_reason = $row['vend_deduct_reason'];
										$vend_adjust_hrs = $row['vend_adjust_hrs'];
										$vend_adjust_cost = $row['vend_adjust_cost'];
										$vend_est_travel = $row['vend_est_travel'];
										$vend_total_hours = $row['vend_total_hours'];
										$vend_total_cost = $row['vend_total_cost'];
										$vend_invoice_date = $row['vend_invoice_date'];
										$vend_invoice_received = $row['date_invoice_received'];
										$data_entry_by = $row['data_entry_by'];
										$submission_date = $row['submission_date'];
										echo "<tr>\n";
										echo "<td $width2><small>$ddr_date</td ></small>\n";
										echo "<td $width7><small>$vend_aol - $vend_ll</td ></small>\n";
										echo "<td $width4><small>$vend_name</a></td ></small>\n";
										echo "<td $width2><small>$vend_service</td ></small>\n";
										echo "<td $width14><small>Deduction Hrs: $vend_deduct_time | Deduction Reasons: $vend_deduct_reason</small> </td >\n";
										echo "<td $width2><small>Adjusted Hrs/$: $vend_adjust_hrs / $vend_adjust_cost</td ></small>\n";
										echo "<td $width2><small>Est. Travel Time: $vend_est_travel | Total Time: $vend_total_hours</td ></small>\n";
										echo "</tr>\n"; 
									break;
									default:
										$ddr_date = $row['date'];
										$time_start = $row['time_start'];
										$time_end = $row['time_end'];
										$eng_contact = $row['eng_contact'];
										$eng_contact_info = $row['eng_contact_info'];
										$eng_daily_report = $row['eng_daily_report'];
										$eng_edc = $row['eng_edc'];
										$eng_ecc = $row['eng_ecc'];
										echo "<tr>\n";
										echo "<td $width2><small>$ddr_date</td ></small>\n";
										echo "<td $width7><small>$time_start - $time_end</td ></small>\n";
										echo "<td $width4><small>$eng_contact</a></td ></small>\n";
										echo "<td $width2><small>$eng_contact_info</td ></small>\n";
										echo "<td $width14><small>$eng_daily_report</small> </td >\n";
										echo "<td $width2><small>$eng_edc</td ></small>\n";
										echo "<td $width2><small>$eng_ecc</td ></small>\n";
										echo "</tr>\n"; 
									break;
								}
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
                        }
                        echo "</tbody>\n";
                        
                        ?> 
                    
                    </table>
                </div>
			
			
			<!-- <div class="tab-pane fade " id="t2" role="tabpanel" aria-labelledby="t2-tab" style="position: relative; z-index: 1040;">
				
			</div>
			<div class="tab-pane fade " id="t3" role="tabpanel" aria-labelledby="t3-tab" style="position: relative; z-index: 1040;">
				
			</div> -->
		</div>
    </nav>
</main>
</div>
		  </body>

		  
		  <!-- <script>
			// $( "#t1" ).click(function() {
			// 	$( this ).load( "wellnotes_test.php " );
			// });
			/* $('#inline').click(function() {
				$('#inline').addClass('borderLit');
			}); */
			var selector = document.getElementById('inline');
			selector.addEventListener('click', clicks);


			// Global Scope variable we need this
			var clickCount = 0;
			// Our Timeout, modify it if you need
			var timeout = 500;
			// Copy this function and it should work
			function clicks() {
			// We modify clickCount variable here to check how many clicks there was
			
				clickCount++;
				if (clickCount == 1) {
					setTimeout(function(){
					if(clickCount == 1) {
						console.log('singleClick');
						$(this).addClass('borderLit');
						// Single click code, or invoke a function 
					} else {
						console.log('double click');
						// Double click code, or invoke a function 
						//showEdit(this);
					}
					clickCount = 0;
					}, timeout || 300);
				}
			}



			// Not important for your needs - pure JS stuff
			var button = document.getElementById('inlin');

			button.addEventListener('click', singleClick);
			button.addEventListener('dblclick', doubleClick);

			function singleClick() {
			console.log('single click');
			}

			function doubleClick() {
				console.log('single click');
				//showEdit(this);
			}
		</script> -->
		<script>
			var dblclick = false;

			//single click function
			$('td.inline').on('click',function(){
				setTimeout(function(){
					if($('td.inline').prop("disabled"))    return;
					console.log('singleClick');
					
					$('td.inline').prop("disabled", true);
					//some single click work.
					$('td.inline').prop("disabled", false);
				},1000); 
			});

			//double click function
			$('td.inline').on('dblclick',function(){       
				if($('td.inline').prop("disabled"))    return;
				$('td.inline').prop("disabled", true);
				console.log('doubleClick');
				showEdit(this);
				//some work    then enable single click again
				setTimeout(function(){
				$('td.inline').prop("disabled",false);
				},2000); 
			});
			</script>
		  <script type="text/javascript" src="WSB/dashboard/popper.min.js.download"></script>
<script type="text/javascript" src="WSB/dashboard/bootstrap.min.js.download"></script>

<!-- Icons -->
<script type="text/javascript" src="../WSB/dashboard/feather.min.js.download"></script>
<script>
    feather.replace()
</script>   
<script type="text/javascript" src="WSB/stylesheet/holder.min.js.download"></script>
<script type="text/javascript" src="WSB/stylesheet/offcanvas.js.download"></script>
	</html>
