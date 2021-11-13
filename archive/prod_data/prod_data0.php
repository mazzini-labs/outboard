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
	<link href="WSB/stylesheet/bootstrap.min.css" type="text/css" rel="stylesheet">

	<!-- Custom styles for this template -->

	<link href="WSB/stylesheet/offcanvas.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
	integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
	crossorigin=""/>
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
	integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
	crossorigin=""></script>
		<!-- <script src="dashboard/jquery-3.2.1.slim.min.js.download" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
		<!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
		<link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>

		<script type="text/javascript" src="datatables/datatables.min.js"></script>
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
				 var aDDRTable = $('#ddr2015pres').DataTable( {
						"scrollY":        "50vh",
						"scrollX": true,
						"searching": true,
						"sDom": 'd'
				} );
				var aDSRTable = $('#dsr2015pres').DataTable( {
					"scrollY":        "50vh",
						"scrollX": true,
						"searching": true,
						"sDom": 'd'
						 dom: [
							"<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'>>" +
							"<'row'<'col-sm-12'tr>>" +
							"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
						]	 		
					} );
				 var bDDRTable = $('#before2015detailrpt').DataTable( {
					"scrollY":        "50vh",
						"scrollX": true,
						"searching": true,
						"sDom": 'd'			
					} ); 
				 var bDSRTable = $('#before2015sumrpt').DataTable( {
						"scrollY":        "50vh",
						"scrollX": true,
						"sDom": 'd'
				} ); 
				$('#searchProduction').keyup(function(){
						oTable.search($(this).val()).draw() ;
						aDDRTable.search($(this).val()).draw() ;
						aDSRTable.search($(this).val()).draw() ;
						bDDRTable.search($(this).val()).draw() ;
						bDSRTable.search($(this).val()).draw() ;
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
				<a class="nav-link active" id="monthly-tab" data-toggle="tab" href="#home" role="tab" aria-controls="monthly" aria-selected="true">Well Info</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="t1-tab" data-toggle="tab" href="#t1" role="tab" aria-controls="t1" aria-selected="false">DDR 2015-Present</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="t2-tab" data-toggle="tab" href="#t2" role="tab" aria-controls="t2" aria-selected="false">DSR 2015-Present</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="t3-tab" data-toggle="tab" href="#t3" role="tab" aria-controls="t3" aria-selected="false">Before 2015 Detail Report</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="t4-tab" data-toggle="tab" href="#t4" role="tab" aria-controls="t4" aria-selected="false">Before 2015 Summary Report</a>
			</li>
		</ul> 
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="monthly-tab" style="position: relative; z-index: 1040;"> 
				<!-- <main role="main" class="col-sm-auto pt-5" style="top: 7.5vh;"> -->
				<div class="container-fluid">
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
			<!-- </div> -->
			<?php
			$api = $_GET['api'];
			$sheet="ddr2015pres";
			//include 'wellnotes_test.php';
			?>
			<div class="tab-pane fade " id="t1" role="tabpanel" aria-labelledby="t1-tab" style="position: relative; z-index: 1040;">
				<h1>DDR 2015-Present</h1>
				<div class=container-fluid>
				<table id="ddr2015pres" class="table display nowrap" style="width=100%;">
					<thead>
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
							<th class="table-header">X</th>
							<!-- <th class="table-header">Y</th>
							<th class="table-header">Z</th> -->
							<!-- <th class="table-header">E</th>
							<th class="table-header">E</th> -->
						</tr>
					</thead>
					<tbody>
					<?php
					require_once ("Model/inline.php");
					$inline = new inline();
					$well = $inline->getwell($api);
					console_log($well);
					$inlineResult = $inline->getinline($api,$sheet);

					foreach ($inlineResult as $k => $v) {
						?>
						<tr class="table-row">
							<td><?php echo $k+1; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'a','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["a"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'b','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["b"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'c','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["c"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'d','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["d"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'e','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["e"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'f','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["f"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'g','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["g"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'h','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["h"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'i','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["i"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'j','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["j"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'k','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["k"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'l','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["l"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'m','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["m"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'n','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["n"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'o','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["o"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'p','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["p"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'q','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["q"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'r','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["r"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'s','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["s"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'t','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["t"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'u','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["u"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'v','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["v"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'w','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["w"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'x','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["x"]; ?></td>
							<!-- <td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'y','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["y"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'z','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["z"]; ?></td> -->
						</tr>
					<?php
					}
					?>
					</tbody>
				</table>
				</div>
			</div>
			<?php
			$api = $_GET['api'];
			$sheet="dsr2015pres";
			//include 'wellnotes_test.php';
			?>
			<div class="tab-pane fade " id="t2" role="tabpanel" aria-labelledby="t2-tab" style="position: relative; z-index: 1040;">
				<h1>DSR 2015-Present</h1>
				<table id="dsr2015pres" class="table display nowrap" style="width=100%;">
					<thead>
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
							<th class="table-header">X</th>
							<!-- <th class="table-header">Y</th>
							<th class="table-header">Z</th> -->
							<!-- <th class="table-header">E</th>
							<th class="table-header">E</th> -->
						</tr>
					</thead>
					<tbody>
					<?php
					require_once ("Model/inline.php");
					$inline = new inline();
					$well = $inline->getwell($api);
					console_log($well);
					$inlineResult = $inline->getinline($api,$sheet);

					foreach ($inlineResult as $k => $v) {
						?>
						<tr class="table-row">
							<td><?php echo $k+1; ?></td>
							<td contenteditable="true"
								onBlur="saveToDatabase(this,'a','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								onClick="showEdit(this);"><?php echo $inlineResult[$k]["a"]; ?></td>
							<td contenteditable="true"
								onBlur="saveToDatabase(this,'b','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								onClick="showEdit(this);"><?php echo $inlineResult[$k]["b"]; ?></td>
							<td contenteditable="true"
								onBlur="saveToDatabase(this,'c','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								onClick="showEdit(this);"><?php echo $inlineResult[$k]["c"]; ?></td>
							<td contenteditable="true"
								onBlur="saveToDatabase(this,'d','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								onClick="showEdit(this);"><?php echo $inlineResult[$k]["d"]; ?></td>
							<td contenteditable="true"
								onBlur="saveToDatabase(this,'e','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								onClick="showEdit(this);"><?php echo $inlineResult[$k]["e"]; ?></td>
							<td contenteditable="true"
								onBlur="saveToDatabase(this,'f','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								onClick="showEdit(this);"><?php echo $inlineResult[$k]["f"]; ?></td>
							<td contenteditable="true"
								onBlur="saveToDatabase(this,'g','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								onClick="showEdit(this);"><?php echo $inlineResult[$k]["g"]; ?></td>
							<td contenteditable="true"
								onBlur="saveToDatabase(this,'h','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								onClick="showEdit(this);"><?php echo $inlineResult[$k]["h"]; ?></td>
							<td contenteditable="true"
								onBlur="saveToDatabase(this,'i','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								onClick="showEdit(this);"><?php echo $inlineResult[$k]["i"]; ?></td>
							<td contenteditable="true"
								onBlur="saveToDatabase(this,'j','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								onClick="showEdit(this);"><?php echo $inlineResult[$k]["j"]; ?></td>
							<td contenteditable="true"
								onBlur="saveToDatabase(this,'k','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								onClick="showEdit(this);"><?php echo $inlineResult[$k]["k"]; ?></td>
							<td contenteditable="true"
								onBlur="saveToDatabase(this,'l','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								onClick="showEdit(this);"><?php echo $inlineResult[$k]["l"]; ?></td>
							<td contenteditable="true"
								onBlur="saveToDatabase(this,'m','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								onClick="showEdit(this);"><?php echo $inlineResult[$k]["m"]; ?></td>
							<td contenteditable="true"
								onBlur="saveToDatabase(this,'n','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								onClick="showEdit(this);"><?php echo $inlineResult[$k]["n"]; ?></td>
							<td contenteditable="true"
								onBlur="saveToDatabase(this,'o','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								onClick="showEdit(this);"><?php echo $inlineResult[$k]["o"]; ?></td>
							<td contenteditable="true"
								onBlur="saveToDatabase(this,'p','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								onClick="showEdit(this);"><?php echo $inlineResult[$k]["p"]; ?></td>
							<td contenteditable="true"
								onBlur="saveToDatabase(this,'q','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								onClick="showEdit(this);"><?php echo $inlineResult[$k]["q"]; ?></td>
							<td contenteditable="true"
								onBlur="saveToDatabase(this,'r','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								onClick="showEdit(this);"><?php echo $inlineResult[$k]["r"]; ?></td>
							<td contenteditable="true"
								onBlur="saveToDatabase(this,'s','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								onClick="showEdit(this);"><?php echo $inlineResult[$k]["s"]; ?></td>
							<td contenteditable="true"
								onBlur="saveToDatabase(this,'t','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								onClick="showEdit(this);"><?php echo $inlineResult[$k]["t"]; ?></td>
							<td contenteditable="true"
								onBlur="saveToDatabase(this,'u','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								onClick="showEdit(this);"><?php echo $inlineResult[$k]["u"]; ?></td>
							<td contenteditable="true"
								onBlur="saveToDatabase(this,'v','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								onClick="showEdit(this);"><?php echo $inlineResult[$k]["v"]; ?></td>
							<td contenteditable="true"
								onBlur="saveToDatabase(this,'w','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								onClick="showEdit(this);"><?php echo $inlineResult[$k]["w"]; ?></td>
							<td contenteditable="true"
								onBlur="saveToDatabase(this,'x','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								onClick="showEdit(this);"><?php echo $inlineResult[$k]["x"]; ?></td>
							<!-- <td contenteditable="true"
								onBlur="saveToDatabase(this,'y','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								onClick="showEdit(this);"><?php echo $inlineResult[$k]["y"]; ?></td>
							<td contenteditable="true"
								onBlur="saveToDatabase(this,'z','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								onClick="showEdit(this);"><?php echo $inlineResult[$k]["z"]; ?></td> -->
						</tr>
					<?php
					}
					?>
					</tbody>
				</table>
			</div>
			<?php
			$api = $_GET['api'];
			$sheet="before2015detailrpt";
			//include 'wellnotes_test.php';
			?>
			<div class="tab-pane fade " id="t3" role="tabpanel" aria-labelledby="t3-tab" style="position: relative; z-index: 1040;">
				<h1>Before 2015 Detail Report</h1>
				<table id="before2015detailrpt" class="table display nowrap" style="width=100%;">
					<thead>
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
							<th class="table-header">X</th>
							<!-- <th class="table-header">Y</th>
							<th class="table-header">Z</th> -->
							<!-- <th class="table-header">E</th>
							<th class="table-header">E</th> -->
						</tr>
					</thead>
					<tbody>
					<?php
					require_once ("Model/inline.php");
					$inline = new inline();
					$well = $inline->getwell($api);
					console_log($well);
					$inlineResult = $inline->getinline($api,$sheet);

					foreach ($inlineResult as $k => $v) {
						?>
						<tr class="table-row">
							<td><?php echo $k+1; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'a','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["a"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'b','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["b"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'c','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["c"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'d','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["d"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'e','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["e"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'f','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["f"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'g','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["g"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'h','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["h"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'i','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["i"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'j','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["j"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'k','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["k"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'l','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["l"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'m','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["m"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'n','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["n"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'o','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["o"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'p','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["p"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'q','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["q"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'r','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["r"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'s','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["s"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'t','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["t"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'u','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["u"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'v','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["v"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'w','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["w"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'x','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["x"]; ?></td>
							<!-- <td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'y','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["y"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'z','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["z"]; ?></td> -->
						</tr>
					<?php
					}
					?>
					</tbody>
				</table>
			</div>
			<?php
			$api = $_GET['api'];
			$sheet="before2015sumrpt";
			//include 'wellnotes_test.php';
			?>
			<div class="tab-pane fade " id="t4" role="tabpanel" aria-labelledby="t4-tab" style="position: relative; z-index: 1040;">
				<h1>Before 2015 Summary Report</h1>
				<table id="before2015sumrpt" class="table display nowrap" style="width=100%;">
					<thead>
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
							<th class="table-header">X</th>
							<!-- <th class="table-header">Y</th>
							<th class="table-header">Z</th> -->
							<!-- <th class="table-header">E</th>
							<th class="table-header">E</th> -->
						</tr>
					</thead>
					<tbody>
					<?php
					require_once ("Model/inline.php");
					$inline = new inline();
					$well = $inline->getwell($api);
					console_log($well);
					$inlineResult = $inline->getinline($api,$sheet);

					foreach ($inlineResult as $k => $v) {
						?>
						<tr class="table-row">
							<td><?php echo $k+1; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'a','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["a"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'b','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["b"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'c','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["c"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'d','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["d"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'e','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["e"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'f','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["f"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'g','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["g"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'h','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["h"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'i','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["i"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'j','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["j"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'k','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["k"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'l','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["l"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'m','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["m"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'n','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["n"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'o','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["o"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'p','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["p"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'q','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["q"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'r','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["r"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'s','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["s"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'t','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["t"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'u','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["u"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'v','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["v"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'w','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["w"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'x','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["x"]; ?></td>
							<!-- <td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'y','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["y"]; ?></td>
							<td class="inline" contentedtable="false"
								onBlur="saveToDatabase(this,'z','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
								><?php echo $inlineResult[$k]["z"]; ?></td> -->
						</tr>
					<?php
					}
					?>
					</tbody>
				</table>
			</div>
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
