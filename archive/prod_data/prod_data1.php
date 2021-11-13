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
		$well = $row['well_lease'] . " " . $row['well_no'];
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
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>

		<script type="text/javascript" src="datatables/datatables.min.js"></script>
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script> -->
		
		<script type="text/javascript" src="js/chart.js"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@0.7.7"></script>
		<style>
			#mapid { 
				/* width: 50%; */
				height: 50vh; }
			
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
<main role="main" class="col-sm-auto pt-5" style="top: 7.5vh;">
<div class="container-fluid">
	<div class="row"><div class="col-6"><h3><?php echo $well; ?></h3>
	
<div class="chart-container">
<canvas id="chart" style="width: 100%; height: 50vh;"></canvas> 


</div></div><div class="col-6"><h3 <?php echo $status ?>>Status: <?php echo $wellstatus; ?></h3>
<div id="mapid"></div></div></div>
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
<div class="table-responsive">
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
		
		echo "<tr>";
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
<!--<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>-->
<div class="container d-flex justify-content-center">   
<form action="<?php echo $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" method="post" name="form">
<div class="form-row form-group">
      
	<div class="col"><b>Production Data</b></div>
      <div class="col"><select class="custom-select" name="api" size="1">
	  <?php
		$table = "static_data";
		$sql = "SELECT api, well_lease, well_no FROM $table";// ORDER BY well_lease ASC";
    	$result = mysqli_query($mysqli,$sql) or die(mysql_error());
			  //console_log($result);
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
	<!--	 
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-3.2.1.slim.min.js"><\/script>')</script>
    <script src="dashboard/popper.min.js.download"></script>
    <script type="text/javascript" src="dashboard/bootstrap.min.js.download"></script>

     Icons
    <script src="dashboard/feather.min.js.download"></script>
    <script>
      feather.replace()
    </script>   
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="stylesheet/holder.min.js.download"></script>
    <script src="stylesheet/offcanvas.js.download"></script> -->
		  
<?php
		  }

/*
include 'includes.php';

$id = $_GET[id];
$status = $_GET[status];

$query = "SELECT * FROM wells WHERE `wells`.`well_id` = '$id'";

$conn = connect_db();
$results = mysql_query($query);
$record = mysql_fetch_array($results, MYSQL_BOTH);


$query = "select * from outboard where userid = '".$userselect."'";
//$query = "select * from `outboard` where `userid` like '%$userselect%' limit 0,25";
//$query = "select * from outboard where userid = '$userselect'";
//console_log($query);
$result = mysql_query($query) or die(mysql_error());

while($row = mysql_fetch_array($result)){ 
	$api = array(
		
	) 



}




*/
//mysqli_close($conn);

//echo $record[$status];

?>

		</div>
</main>
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
/* var geojsonFeature = {
    "type": "Feature",
    "properties": {
        "name": "Coors Field",
        "amenity": "Baseball Stadium",
        "popupContent": "This is where the Rockies play!"
    },
    "geometry": {
        "type": "Point",
        "coordinates": [-104.99404, 39.75621]
    }
}.geoJSON(geojsonFeature).addTo(mymap); */
</script>
		  </body>
	</html>
