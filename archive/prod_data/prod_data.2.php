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
	<meta charset="utf-8" />
	<meta http-equiv="x-ua-compatible" content="ie=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/maintest.css?=v1.2">
	<link rel="stylesheet" type="text/css" href="css/tabs.css?v1.0.0.1">
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css"/>
        <!-- <link rel="stylesheet" href="css/datepicker-bs4.css"/> -->
        

		<style>
			#mapid { 
				/* width: 50%; */
				height: 50vh; 
			}
			body {
					/* top: 56px; */
				/* overflow-y: hidden; Hide scrollbars */
			} 	
			.production {
				width: 100%;
				display: inline-table;
				height:auto;
				table-layout: fixed;
				/* padding-left: 5%; */
			}
			/* table{
				height:0%; 
				display: -moz-groupbox;
				overflow: hidden;
			}
			tbody{
				overflow-y: scroll;
				height: 79vh;
				width: auto;
				position: absolute;
			} */
            /* table{
            height:0%; 
            display: -moz-groupbox;
            overflow: hidden;
            } */
            .table > thead {
                font-style: normal!important;
                font-stretch: condensed!important;
                font-size: 12px;
            }
            /* .table > thead > tr {
            width: 100%;
            display: inline-table;
            height:auto;
            table-layout: fixed;
            }
            .table > tbody > tr {
            width: 100%;
            display: inline-table;
            height:auto;
            table-layout: fixed;
            }
            .table > thead > tr > td{
                padding-left: 1%!important;
            }
            .table > tbody > tr > td{
                padding-left: 1%!important;
            }
            
            table.table > tbody{
            overflow-y: scroll;
            height: 70vh;
            width: auto;
            position: fixed;
            } */

			.engineering-date {
                color: #ff4d4d;
                font-weight: 900;
                
            }
            .engineering {
                font-weight: bold;
            }
            .accounting {
                /* background-color: rgba(30,30,100,0.5); 
                color: white; */
                color: #4d4dff;
            }		
            .vendor {
                background-color: gold;
            }
            .field {
                color: purple;
            }
            #eng { display: none; }
            #acct { display: none; }
            #vend { display: none; }
            #field { display: none; }
            .not-allowed { cursor: not-allowed; }
            .gold { background-color: gold; }
            .red { background-color: #ff4d4d; }
            .purple { background-color: purple; color: white; }
            .blue { background-color: #4d4dff; color: white; }
        </style>
        <style>
            /* .datepicker {
            z-index: 1600 !important; 
            position: absolute;
            top: 378px;
            left: 1128.53px;
            z-index: 1000;
            float: left;
            display: block;
            min-width: 160px;
            list-style: none;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border: 1px solid rgba(0, 0, 0, 0.2);
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            -webkit-background-clip: padding-box;
            -moz-background-clip: padding;
            background-clip: padding-box;
            *border-right-width: 2px;
            *border-bottom-width: 2px;
            color: #333333;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 13px;
            line-height: 20px;
            } 
            .datepicker-dropdown.datepicker-orient-top:before {
                top: -7px;
            }
            .datepicker-dropdown.datepicker-orient-left:before {
                left: 6px;
            }
            .datepicker-dropdown:before {
                content: '';
                display: inline-block;
                border-left: 7px solid transparent;
                border-right: 7px solid transparent;
                border-bottom: 7px solid #ccc;
                border-top: 0;
                border-bottom-color: rgba(0, 0, 0, 0.2);
                position: absolute;
            }
            :before, :after {
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }
            *, ::after, ::before {
                box-sizing: inherit;
            }
            .datepicker-dropdown.datepicker-orient-top:after {
                top: -6px;
            }
            .datepicker-dropdown.datepicker-orient-left:after {
                left: 7px;
            }
            .datepicker-dropdown:after {
                content: '';
                display: inline-block;
                border-left: 6px solid transparent;
                border-right: 6px solid transparent;
                border-bottom: 6px solid #ffffff;
                border-top: 0;
                position: absolute;
            }
            :before, :after {
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }

            *, ::after, ::before {
                box-sizing: inherit;
            }*/
        </style>
		<!-- <style type="text/css" class="init">
			.borderLit{
				border-color: rgba(0,255,0,0.5);
			}
			div.dataTables_wrapper {
				width: 800px;
				margin: 0 auto;
			}
		</style> -->
		<script type="text/javascript" class="init">
			
                var api = <?php echo $api; ?>;
                var da = "ddr2015pres";
                var sa = "dsr2015pres";
                var db = "before2015detailrpt";
                var sb = "before2015sumrpt";
                var click = 1;
                var clickddr = 0;
                var clickt1 = 0;
                var clickt2 = 0;
                var clickt3 = 0;
                var clickt4 = 0;
                $('#ddr2015pres')
                .on( 'init.dt', function () {
                    console.log( 'Table initialisation complete: '+new Date().getTime() );
                } )
                .dataTable();
                $(document).ready(function() {
                    $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
                        $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
                } );
                var oTable = $('#productionTable').DataTable( {
                    "ajax": {
                    "url" : "ajax/prodajax.php",
                    // "type" : "POST",
                    "data": {
                        "api": <?php echo $api; ?>,
                        //"sheet": "ddr2015pres"
                    }
                    },
                    "sDom": 't',
                    //"sDom": 'd',
                    "order": [],
                    //"paging": false,
                    //"info": false,
                    deferRender: true,
                    scrollY: 300,
                    scroller: true,
                    "searching": true,
                    //
                    "autoWidth": false,
                    "columns": [
                        {
                        "data": "prod_mo", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "days_on", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "gas_wh_mcf", // can be null or undefined
                        "defaultContent": "",
                        render: $.fn.dataTable.render.number( ',', '.', 2, '', ' mcf' )
                        },
                        {
                        "data": "oil_prod", // can be null or undefined
                        "defaultContent": "",
                        render: $.fn.dataTable.render.number( ',', '.', 2, '', ' bbl' )
                        },
                        {
                        "data": "water_prod", // can be null or undefined
                        "defaultContent": "",
                        render: $.fn.dataTable.render.number( ',', '.', 2, '', ' bbl' )
                        },
                        {
                        "data": "gas_sold", // can be null or undefined
                        "defaultContent": "",
                        render: $.fn.dataTable.render.number( ',', '.', 2, '', ' mcf' )
                        },
                        {
                        "data": "oil_sold", // can be null or undefined
                        "defaultContent": "",
                        render: $.fn.dataTable.render.number( ',', '.', 2, '', ' bbl' )
                        },
                        {
                        "data": "gas_line_loss", // can be null or undefined
                        "defaultContent": "",
                        render: $.fn.dataTable.render.number( ',', '.', 2, '', ' mcf' )
                        },
                        {
                        "data": "flug", // can be null or undefined
                        "defaultContent": "",
                        render: $.fn.dataTable.render.number( ',', '.', 0, '', '%' )
                        },
                    ]
                        
                } );
                    
                
                var iTable = $('#ddrTable').DataTable( {
                    "order": [],
                    "scrollY":        "100px",
                    "scrollCollapse": true,
                    "paging":         false,
                    "searching": true,
                    "sDom": 'd',
                    "autoWidth": false,
                } );
                
                
                var aDDRTable = $('#ddr2015pres').DataTable( {
                    "ajax": {
                    "url" : "ajax/ddrtest.php",
                    // "type" : "POST",
                    "data": {
                        "api": <?php echo $api; ?>,
                        "sheet": "ddr2015pres"
                    }
                    },
                    "order": [],
                    "paging": false,
                    "info": false,
                    "searching": true,
                    "sDom": 'd',
                    "autoWidth": false,
                    "columns": [
                        {
                        "data": "a", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "b", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "c", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "d", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "e", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "f", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "g", // can be null or undefined
                        "defaultContent": ""
                        },
                    ]
                } );
                    
                
                var aDSRTable = $('#dsr2015pres').DataTable( {
                    "ajax": {
                    "url" : "ajax/ddrtest.php",
                    // "type" : "POST",
                    "data": {
                        "api": api,
                        "sheet": sa
                    }
                    },
                    "order": [],
                    "paging": false,
                    "info": false,
                    "searching": true,
                    "sDom": 'd',
                    "autoWidth": false,
                    "columns": [
                        {
                        "data": "a", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "b", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "c", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "d", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "e", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "f", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "g", // can be null or undefined
                        "defaultContent": ""
                        },
                    ]
                } );
                    
                
                var bDDRTable = $('#before2015detailrpt').DataTable( {
                    "ajax": {
                    "url" : "ajax/ddrtest.php",
                    // "type" : "POST",
                    "data": {
                        "api": api,
                        "sheet": db
                    }
                    },
                    "order": [],
                    "paging": false,
                    "info": false,
                    "searching": true,
                    "sDom": 'd',
                    "autoWidth": false,
                    "columns": [
                        {
                        "data": "a", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "b", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "c", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "d", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "e", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "f", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "g", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "h", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "i", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "j", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "k", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "l", // can be null or undefined
                        "defaultContent": ""
                        },
                        /* {
                        "data": "m", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "n", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "o", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "p", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "q", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "r", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "s", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "t", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "u", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "v", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "w", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "x", // can be null or undefined
                        "defaultContent": ""
                        }  */
                    ]
                } );
            
        
            var bDSRTable = $('#before2015sumrpt').DataTable( {
                "ajax": {
                "url" : "ajax/ddrtest.php",
                // "type" : "POST",
                "data": {
                    "api": api,
                    "sheet": sb
                }
                },
                "order": [],
                "paging": false,
                "info": false,
                "searching": true,
                "sDom": 'd',
                "autoWidth": false,
                "columns": [
                    {
                    "data": "a", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "b", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "c", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "d", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "e", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "f", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "g", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "h", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "i", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "j", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "k", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "l", // can be null or undefined
                    "defaultContent": ""
                    },
                    /* {
                    "data": "m", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "n", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "o", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "p", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "q", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "r", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "s", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "t", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "u", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "v", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "w", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "x", // can be null or undefined
                    "defaultContent": ""
                    }  */
                ]
                } );
                    
				
				$('#searchProduction').keyup(function(){
                        oTable.search($(this).val()).draw() ;
                        iTable.search($(this).val()).draw() ;
                        aDDRTable.search($(this).val()).draw() ;
						aDSRTable.search($(this).val()).draw() ;
						bDDRTable.search($(this).val()).draw() ;
						bDSRTable.search($(this).val()).draw() ;
                    })
                // Activate tooltip
                $('[data-toggle="tooltip"]').tooltip();
                
                // Select/Deselect checkboxes
                var checkbox = $('table tbody input[type="checkbox"]');
                $("#selectAll").click(function(){
                    if(this.checked){
                        checkbox.each(function(){
                            this.checked = true;                        
                        });
                    } else{
                        checkbox.each(function(){
                            this.checked = false;                        
                        });
                    } 
                });
                checkbox.click(function(){
                    if(!this.checked){
                        $("#selectAll").prop("checked", false);
                    }
                });
                $("#engShow").click(function(){
                    $("#eng").show();
                    $("#acct").hide();
                    $("#vend").hide();
                    $("#field").hide();
                });
                $("#acctShow").click(function(){
                    $("#acct").show();
                    $("#eng").hide();
                    $("#vend").hide();
                    $("#field").hide();
                });
                $("#vendShow").click(function(){
                    $("#vend").show();
                    $("#acct").hide();
                    $("#eng").hide();
                    $("#field").hide();
                });
                $("#fieldShow").click(function(){
                    $("#field").show();
                    $("#acct").hide();
                    $("#vend").hide();
                    $("#eng").hide();
                });

              /*   $("#entryForm").submit(function(e) {

                e.preventDefault(); // avoid to execute the actual submit of the form.

                var form = $(this);
                var url = form.attr('action');

                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(), // serializes the form's elements.
                    success: function(data)
                    {
                        alert(data); // show response from the php script.
                    }
                    });


                });  */

                // $("#editAcct").click(function(e)) {

                // }

			} );
        </script>

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

        <!-- <script>
        $(document).ready(function(){
            // Activate tooltip
            $('[data-toggle="tooltip"]').tooltip();
            
            // Select/Deselect checkboxes
            var checkbox = $('table tbody input[type="checkbox"]');
            $("#selectAll").click(function(){
                if(this.checked){
                    checkbox.each(function(){
                        this.checked = true;                        
                    });
                } else{
                    checkbox.each(function(){
                        this.checked = false;                        
                    });
                } 
            });
            checkbox.click(function(){
                if(!this.checked){
                    $("#selectAll").prop("checked", false);
                }
            });
        });
        </script> -->
			
		<title><?php echo $well; ?></title>
</head>

<body class="bg-light">
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
			</li><!--
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="ddr-tab" data-toggle="tab" href="#ddr" role="tab" aria-controls="ddr" aria-selected="false">DDR</a>
			</li>
			 <li class="nav-item" role="presentation">
				<a class="nav-link" id="t3-tab" data-toggle="tab" href="#t3" role="tab" aria-controls="t3" aria-selected="false">Before 2015 Detail Report</a>
			</li> -->
        </ul> 
        </nav>
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade " id="info" role="tabpanel" aria-labelledby="info-tab" style="position: relative; z-index: 1040;">
				<div class="container-fluid mt-3">
					<div class="row justify-content-center">
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
								<p><smll>Produced for <?php echo $monthsproduced; ?> months</smll></p>
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
			</div>
			
            <div class="tab-pane fade " id="ddr" role="tabpanel" aria-labelledby="ddr-tab" style="position: relative; z-index: 1040;">
                <div class="container-fluid mt-3" > <!-- <div class="container-fluid" style="background-color:white;"> -->
                    <h1>DDR-D</h1>
                    <table id="ddrTable" class='table display  bg-sog table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-sm' style="margin-top: 0px !important; width: 100% !important;" >
                        <thead>
                                <th <?php echo $width2; ?>>Department</th>
                                <th <?php echo $width2; ?>>Date</th>
                                <th <?php echo $width4; ?>>Time</th>
                                <th <?php echo $width4; ?>>Vendor / Contact</a></th>
                                <th <?php echo $width4; ?>>Invoice # / Contact Info</a></th>
                                <th <?php echo $width10; ?>>Invoice Details / DDR</th>
                                <th <?php echo $width4; ?>>$ / EDC</a></th>
                                <th <?php echo $width4; ?>>Approvals / ECC</a></th>
                                <th <?php echo $width4; ?>>Actions</th>
                        </thead>
                        <?php
                        $output .= '<tbody id="ddr_table">';
                        /* $output .= '
                        <table id="ddrTable" class="table display  bg-sog table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-sm" style="margin-top: 0px !important; width: 100% !important;" >
                        <thead>
                                <th' . $width2 .'>Department</th>
                                <th' . $width2 .'>Date</th>
                                <th' . $width4 .'>Time</th>
                                <th' . $width4 .'>Vendor / Contact</a></th>
                                <th' . $width4 .'>Invoice # / Contact Info</a></th>
                                <th' . $width10 .'>Invoice Details / DDR</th>
                                <th' . $width4 .'>$ / EDC</a></th>
                                <th' . $width4 .'>Approvals / ECC</a></th>
                                <th' . $width4 .'>Actions</th>
                        </thead>
                        '; */
                        $ddr = "ddr";
                        $sub_date = "sd";
                        $datasql = "SELECT * FROM `ddr` WHERE api='$apino' ORDER BY de ASC";
                        $dataresult = mysqli_query($mysqli, $datasql) or die(mysql_error());
                        //echo $apino;
                        //echo $datasql;
                        while($datarow = mysqli_fetch_array($dataresult)) 
                        {
                           
                             $type = $datarow['t'];
                             if($type != "dsr")
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
                                       $dc = ($datarow['dc'] != '') ? $datarow['dc'] : " - ";
                                       $tc = ($datarow['tc'] != '') ? $datarow['tc'] : " - ";
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
                                                      <td class="engineering" ' . $width4 . '><small>' . $dc . '</td ></small>
                                                      <td class="engineering" ' . $width4 . '><small>' . $tc . '</td ></small>
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
                                       $dc = ($datarow['dc'] != '') ? $datarow['dc'] : " - ";
                                       $tc = ($datarow['tc'] != '') ? $datarow['tc'] : " - ";
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
                                                      <td class="accounting" ' . $width4 . '><small>' . $dc . '</td ></small>
                                                      <td class="accounting" ' . $width4 . '><small>Approval Initials:' . $tc . ' <hr>Approval Date:' . $ad . '</td ></small>
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
                                       $vend_hours = ($datarow['vend_hours'] != '') ? $datarow['vend_hours'] : " - ";
                                       $dc = ($datarow['dc'] != '') ? "Total Time: " . $datarow['dc'] : " - ";
                                       $tc = ($datarow['tc'] != '') ? $datarow['tc'] : " - ";
                                       $deb = ($datarow['deb'] != '') ? $datarow['deb'] : " - ";
                                       $sd = ($datarow['sd'] != '') ? $datarow['sd'] : " - ";
                                       $drn = ($datarow['drn'] != '') ? "Notes: " . $datarow['drn'] : " - ";
                                       $time_dash = ($ts == "-" || $te == "-") ? "" : " - ";
                                       $vend_adj_hr = ($vend_adjust_hrs != "" && $vend_adjust_cost != "") ? " <hr> " : " - ";
                                       $vend_deduct_hr = ($vend_deduct_time != " - " && $vend_deduct_reason != " - ") ? " <hr> " : " - ";
                                       $output .= '
                                                 <tr>
                                                      <td class="vendor" ' . $width2 . '><small>Vendor</small></td>
                                                      <td class="vendor" ' . $width2 . '><small>' . $de . '</td ></small>
                                                      <td class="vendor" ' . $width4 . '><small>' . $ts . ' - ' . $te . '</td ></small>
                                                      <td class="vendor" ' . $width4 . '><small>' . $cvn . '</a></td ></small>
                                                      <td class="vendor" ' . $width4 . '><small>' . $cin . '</td ></small>
                                                      <td class="vendor" ' . $width10 . '><small>' . $drn . '</small> </td >                                       
                                                      <td class="vendor" ' . $width4 . '><small>' . $dc . '</td ></small>
                                                      <td class="vendor" ' . $width4 . '><small>' . $tc . '</td ></small>
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
                                       $dc = ($datarow['dc'] != '') ? $datarow['dc'] : " - ";
                                       $tc = ($datarow['tc'] != '') ? $datarow['tc'] : " - ";
                                       $output .= '
                                                 <tr>
                                                      <td class="field" ' . $width2 . '><small>Field</small></td>
                                                      <td class="field" ' . $width2 . '><small>' . $de . '</small></td >
                                                      <td class="field" ' . $width4 . '><small>' . $ts . ' - ' . $te . '</small></td >
                                                      <td class="field" ' . $width4 . '><small>' . $cvn . '</small></td >
                                                      <td class="field" ' . $width4 . '><small>' . $cin . '</small></td >
                                                      <td class="field" ' . $width10 . '><small>' . $drn . '</small></td >
                                                      <td class="field" ' . $width4 . '><small>' . $dc . '</small></td >
                                                      <td class="field" ' . $width4 . '><small>' . $tc . '</small></td >
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
                        ?> 
                    
                    </table>
                </div>
            </div>
            <div class="tab-pane fade " id="t1" role="tabpanel" aria-labelledby="t1-tab" style="position: relative; z-index: 1040;">
				<div class="container-fluid mt-3">
                    <h1>DDR 2015-Present</h1>
                    <table id="ddr2015pres" class="table bg-sog table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-sm" style="width=100%;">
                        <thead>
                            <tr>
                                <th class="table-header">Date</th>
                                <th class="table-header">Time</th>
                                <th class="table-header">Vendor/Contact</th>
                                <th class="table-header">Invoice #/Contact Info</th>
                                <th class="table-header">Invoice Details/DDR</th>
                                <th class="table-header">$/EDC</th>
                                <th class="table-header">Approvals/ECC</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade " id="t2" role="tabpanel" aria-labelledby="t2-tab" style="position: relative; z-index: 1040;">
                <div class="mt-3"> 
                    <h1>DSR 2015-Present</h1>
                    <table id="dsr2015pres" class="table bg-sog table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-sm " style="width=100%;">
                        <thead>
                            <tr>
                                <th class="table-header">Date</th>
                                <th class="table-header">&nbsp;</th>
                                <th class="table-header">Daily Summary Report</th>
                                <th class="table-header">EDC</th>
                                <th class="table-header">&nbsp;</th>
                                <th class="table-header">ECC</th>
                                <th class="table-header">&nbsp;</th>
                                <th class="table-header">&nbsp;</th>
                                <th class="table-header">&nbsp;</th>
                                <th class="table-header">&nbsp;</th>
                                <th class="table-header">&nbsp;</th>
                                <th class="table-header">&nbsp;</th>
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
            <div class="tab-pane fade " id="t3" role="tabpanel" aria-labelledby="t3-tab" style="position: relative; z-index: 1040;">
                <div class="mt-3">
                    <h1>Before 2015 Detail Report</h1>
                    <table id="before2015detailrpt" class="table bg-sog display table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-sm" style="width=100%;">
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
            <div class="tab-pane fade " id="t4" role="tabpanel" aria-labelledby="t4-tab" style="position: relative; z-index: 1040;">
                <div class="mt-3">
                    <h1>Before 2015 Summary Report</h1>
                    <table id="before2015sumrpt" class="table bg-sog display table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-sm" style="width=100%;">
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
			<div class="tab-pane fade in show active" id="detail" role="tabpanel" aria-labelledby="detail-tab" style="position: relative; z-index: 1040;"> 
				<!-- <main role="main" class="col-sm-auto pt-5" style="top: 7.5vh;"> -->
				<div class="container-fluid mt-3">
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

						//$datasql = "SELECT * FROM $data WHERE api=$api ORDER BY $pm DESC";
							//console_log($datasql);
						//	$dataresult = mysqli_query($mysqli, $datasql) or die(mysql_error());
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


		</div>
    <!-- </nav> -->
</main>
</div>
 <div id="dataModal" class="modal fade">  
      <div class="modal-dialog modal-lg" >  
           <div class="modal-content" id="ddr_detail" style="height:90vh!important;">  
                
                <!-- <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </div>   -->
           </div>  
      </div>  
 </div>
<!-- Add Entry Modal -->
<div class="modal fade right" id="add_data_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-side modal-top-right" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalPreviewLabel">Add New Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>Type:</h6>
                <ul class="nav nav-pills nav-fill mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" id="nav-item-e" role="presentation">
                        <a class="nav-link active" name="eng" id="pills-eng-tab" data-toggle="pill" href="#pills-eng" role="tab" aria-controls="pills-home" aria-selected="true">
                            Engineering</a>
                    </li>
                    <li class="nav-item" id="nav-item-a" role="presentation">
                        <a class="nav-link" name="acct" id="pills-acct-tab" data-toggle="pill" href="#pills-acct" role="tab" aria-controls="pills-profile" aria-selected="false">
                        Accounting</a>
                    </li>
                    <li class="nav-item" id="nav-item-v" role="presentation">
                        <a class="nav-link" name="vend" id="pills-vend-tab" data-toggle="pill" href="#pills-vend" role="tab" aria-controls="pills-contact" aria-selected="false">
                        Vendor</a>
                    </li>
                    <li class="nav-item" id="nav-item-f" role="presentation">
                        <a class="nav-link" name="field" id="pills-field-tab" data-toggle="pill" href="#pills-field" role="tab" aria-controls="pills-contact" aria-selected="false">
                        Field</a>
                    </li>
                </ul>
            </div>
            <div class="modal-body">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade in show active" id="pills-eng" role="pillpanel">
                        <form id="insert_form-e" method="POST">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Date Entered</span>
                                </div>
                                <input id="de-e" name="de-e" type="text" class="form-control date datepicker-input" value="">
                                <input name="deb-e" id="deb-e" type="text" class="form-control" placeholder="Your Name" aria-label="Data Entry By">
                                <div class="input-group-append">
                                    <span class="input-group-text">Person Entering Data</span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Start Time / Vendor AOL</span>
                                </div>
                                <input type="time" value="08:00" step="600" class="form-control" name="ts-e" id="ts-e">
                                <input type="time" value="08:00" step="600" class="form-control" name="te-e" id="te-e">
                                <div class="input-group-append">
                                    <span class="input-group-text">End Time / Vendor LL</span>
                                </div>
                            </div>
                
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Contact Name</span>
                                </div>
                                <input name="cvn-e" id="cvn-e" type="text" class="form-control">
                                <input name="cin-e" id="cin-e" type="text" class="form-control">
                                <div class="input-group-append">
                                        <span class="input-group-text">Contact Info</span>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Daily Report</span>
                                    </div>
                                    <textarea name="drn-e" id="drn-e" class="form-control" aria-label="With textarea"></textarea>
                                </div>
                                <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input name="dc-e" id="dc-e" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="input-group-append">
                                    <span class="input-group-text">Estimated Daily Cost</span>
                                </div>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input name="tc-e" id="tc-e" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="input-group-append">
                                    <span class="input-group-text">Estimated Cumulative Cost</span>
                                </div>
                                <input type="hidden" name="id-e" id="id-e" />
                                <input type="hidden" name="api-e" id="api-e" value=<?php echo $api; ?> />
                                <input type="hidden" name="d-e" id="d-e" value="e" />
                                <input type="hidden" name="t-e" id="t-e" value="d" />     
                                <input type="submit" name="insert-e" id="insert-e" value="Insert" class="btn btn-success" />
                                <!-- </form> -->
                            </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <!-- <button type="submit" name="eng" class="btn btn-primary">Add Entry</button> -->
                            </div>
                            </div>
                        
                        
                        </form>
                        <div class="tab-pane fade" id="pills-acct" role="tabpanel">
                            <form id="insert_form-a" method="POST">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Date Entered</span>
                                    </div>
                                    <input id="de-a" name="de-a" type="text" class="form-control date datepicker-input">
                                    <input name="deb-a" id="deb-a" type="text" class="form-control" placeholder="Your Name" aria-label="Data Entry By">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Person Entering Data</span>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Start Time / Vendor AOL</span>
                                    </div>
                                    <input type="time" value="08:00" step="600" class="form-control" name="ts-a" id="ts-a">
                                    <input type="time" value="08:00" step="600" class="form-control" name="te-a" id="te-a">
                                    <div class="input-group-append">
                                        <span class="input-group-text">End Time / Vendor LL</span>
                                    </div>
                                </div>
                                <div class="input-group mb-3 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Vendor Name:</span>
                                    </div>
                                    <input id="cvn-a" name="cvn-a" type="text" class="form-control" placeholder="Vendor" aria-label="Vendor">
                                </div>    
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Invoice #</span>
                                    </div>
                                    <input id="cin-a" name="cin-a" type="text" class="form-control" aria-label="Invoice #">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input id="dc-a" name="dc-a" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Invoice Amount</span>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Invoice Details</span>
                                    </div>
                                    <textarea id="drn-a" name="drn-a" class="form-control" aria-label="With textarea"></textarea>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Approval Initials</span>
                                    </div>
                                    <input id="tc-a" name="tc-a" type="text" aria-label="Approval Initials" class="form-control">
                                    <input id="ad" name="ad" name="acct_approval_date" type="text" class="form-control date datepicker-input">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Approval Date</span>
                                    </div>
                                    <input type="hidden" name="id-a" id="id-a" />
                                    <input type="hidden" name="api-a" id="api-a" value=<?php echo $api; ?> />
                                    <input type="hidden" name="d-a" id="d-a" value="a" />
                                    <input type="hidden" name="t-a" id="t-a" value="d" />     
                                    <input type="submit" name="insert-a" id="insert-a" value="Insert" class="btn btn-success" />
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <!-- <button type="submit" name="acct" class="btn btn-primary">Add Entry</button> -->
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="pills-vend" role="tabpanel">		
                        <form id="insert_form-v" method="POST">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Date Entered</span>
                                </div>
                                <input id="de-v" name="de-v" type="text" class="form-control date datepicker-input">
                                <input name="deb-v" id="deb-v" type="text" class="form-control" placeholder="Your Name" aria-label="Data Entry By">
                                <div class="input-group-append">
                                    <span class="input-group-text">Person Entering Data</span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Start Time / Vendor AOL</span>
                                </div>
                                <input type="time" value="08:00" step="600" class="form-control" name="ts-v" id="ts-v">
                                <input type="time" value="08:00" step="600" class="form-control" name="te-v" id="te-v">
                                <div class="input-group-append">
                                    <span class="input-group-text">End Time / Vendor LL</span>
                                </div>
                            </div>			
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Vendor Name</span>
                                </div>
                                <input id="cvn-v" name="cvn-v" type="text" class="form-control">
                                <input id="cin-v" name="cin-v" type="text" class="form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">Vendor Service</span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Vendor Notes</span>
                                </div>
                                <textarea id="drn-v" name="drn-v" class="form-control" aria-label="With textarea"></textarea>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input name="vac" type="text" class="form-control" aria-label="Vendor Adjusted Hours">
                                <div class="input-group-append">
                                    <span class="input-group-text">Vendor Adjusted Cost</span>
                                </div>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input id="dc-v" name="dc-v" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="input-group-append">
                                    <span class="input-group-text">Vendor Total Cost</span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                    <span class="input-group-text">Vendor Adjusted Time</span>
                                </div>
                                <input name="vah" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="input-group-append">
                                    <span class="input-group-text">Hour(s)</span>
                                </div>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Vendor Estimated Travel</span>
                                </div>
                                <input name="vet" type="text" class="form-control" aria-label="Vendor Adjusted Hours">
                                <div class="input-group-append">
                                    <span class="input-group-text">Hour(s)</span>
                                </div>
                            </div>
                            <div class="input-group-prepend">
                                    <span class="input-group-text">Vendor Total Time</span>
                                </div>
                                <input id="tc-v" name="tc-v" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                            <div class="input-group-append">
                                <span class="input-group-text">Hour(s)</span>
                                <input type="hidden" name="id-v" id="id-v" />
                                <input type="hidden" name="api-v" id="api-v" value=<?php echo $api; ?> />
                                <input type="hidden" name="d-v" id="d-v" value="v" />
                                <input type="hidden" name="t-v" id="t-v" value="d" />     
                                <input type="submit" name="insert-v" id="insert-v" value="Insert" class="btn btn-success" />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <!-- <button type="submit" name="vend" class="btn btn-primary">Add Entry</button> -->
                            </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="pills-field" role="tabpanel">
                        <form id="insert_form-f" method="POST">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Date Entered</span>
                                </div>
                                <input id="de-f" name="de-f" type="text" class="form-control date datepicker-input">
                                <input name="deb-f" id="deb-f" type="text" class="form-control" placeholder="Your Name" aria-label="Data Entry By">
                                <div class="input-group-append">
                                    <span class="input-group-text">Person Entering Data</span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Start Time / Vendor AOL</span>
                                </div>
                                <input type="time" value="08:00" step="600" class="form-control" name="ts-f" id="ts-f">
                                <input type="time" value="08:00" step="600" class="form-control" name="te-f" id="te-f">
                                <div class="input-group-append">
                                    <span class="input-group-text">End Time / Vendor LL</span>
                                </div>
                            </div>					
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Contact Name</span>
                                </div>
                                <input id="cvn-f" name="cvn-f" type="text" class="form-control">
                                <input id="cin-f" name="cin-f" type="text" class="form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">Contact Info</span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Daily Report</span>
                                </div>
                                <textarea id="drn-f" name="drn-f" class="form-control" aria-label="With textarea"></textarea>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input id="dc-f" name="dc-f" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="input-group-append">
                                    <span class="input-group-text">Estimated Daily Cost</span>
                                </div>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input id="tc-f" name="tc-f" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="input-group-append">
                                    <span class="input-group-text">Estimated Cumulative Cost</span>
                                </div>
                            </div>
                            <input type="hidden" name="id-f" id="id-f" />
                                <input type="hidden" name="api-f" id="api-f" value=<?php echo $api; ?> />
                                <input type="hidden" name="d-f" id="d-f" value="f" />
                                <input type="hidden" name="t-f" id="t-f" value="d" />     
                                <input type="submit" name="insert-f" id="insert-f" value="Insert" class="btn btn-success" />
                            </form>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 <script>  
 $(document).ready(function(){
    //$('#tabs li.disabled').find('a').removeAttr('data-toggle');  
      $('#add').click(function(){  
           

           $('#pills-eng-tab').removeClass("disabled not-allowed");
           $('#pills-acct-tab').removeClass("active disabled not-allowed");
           $('#pills-vend-tab').removeClass("active disabled not-allowed");
           $('#pills-field-tab').removeClass("active disabled not-allowed");
           
           $('#pills-eng-tab').addClass("active");

           $('#pills-eng').addClass("in show active");
           $('#pills-acct').removeClass("in show active");
           $('#pills-vend').removeClass("in show active");
           $('#pills-field').removeClass("in show active");  
           $('#insert-e').val("Insert"); 
           $('#insert-a').val("Insert"); 
           $('#insert-v').val("Insert"); 
           $('#insert-f').val("Insert"); 
           $('#insert_form-e')[0].reset();
           $('#insert_form-a')[0].reset();
           $('#insert_form-v')[0].reset();
           $('#insert_form-f')[0].reset();
           $('#id-e').val('');
           $('#id-a').val('');
           $('#id-v').val('');
           $('#id-f').val('');
      });  
      $(document).on('click', '.edit_data-e', function(){  
           var id = $(this).attr("id");  
           $.ajax({  
                url:"./ddrtest/fetch.php",  
                method:"POST",  
                data:{id:id},  
                dataType:"json",  
                success:function(data){  
                     $('#deb-e').val(data.deb);  
                     $('#t-e').val(data.t);  
                     $('#de-e').val(data.de);  
                     $('#ts-e').val(data.ts);  
                     $('#te-e').val(data.te);  
                     $('#id-e').val(data.id);  
                     $('#api-e').val(data.api);  
                     $('#d-e').val(data.d);  
                     $('#cvn-e').val(data.cvn);  
                     $('#cin-e').val(data.cin);  
                     $('#drn-e').val(data.drn); 
                     $('#dc-e').val(data.dc);  
                     $('#tc-e').val(data.tc);  

                     $('#insert-e').val("Update");  
                     $('#add_data_Modal').modal('show');  
                     
                     
                    $('#pills-eng-tab').addClass("active");
                    $('#pills-eng-tab').removeClass("disabled not-allowed");

                    $('#pills-acct-tab').removeClass("active");
                    $('#pills-acct-tab').addClass("disabled not-allowed");

                    $('#pills-vend-tab').removeClass("active");
                    $('#pills-vend-tab').addClass("disabled not-allowed");

                    $('#pills-field-tab').removeClass("active");
                    $('#pills-field-tab').addClass("disabled not-allowed");

                    $('#pills-eng').addClass("in show active");
                    $('#pills-acct').removeClass("in show active");
                    $('#pills-vend').removeClass("in show active");
                    $('#pills-field').removeClass("in show active");
                    
                    
                }  
           });  
      });
      $(document).on('click', '.edit_data-a', function(){  
           var id = $(this).attr("id");  
           $.ajax({  
                url:"./ddrtest/fetch.php",  
                method:"POST",  
                data:{id:id},  
                dataType:"json",  
                success:function(data){  
                     $('#deb-a').val(data.deb);  
                     $('#t-a').val(data.t);  
                     $('#de-a').val(data.de);  
                     $('#ts-a').val(data.ts);  
                     $('#te-a').val(data.te);  
                     $('#id-a').val(data.id);  
                     $('#api-a').val(data.api);  
                     $('#d-a').val(data.d);  
                     $('#cvn-a').val(data.cvn);  
                     $('#cin-a').val(data.cin);  
                     $('#drn-a').val(data.drn); 
                     $('#dc-a').val(data.dc);  
                     $('#tc-a').val(data.tc);  
                     $('#ad').val(data.ad); 

                      $('#insert-a').val("Update");  
                     $('#add_data_Modal').modal('show');  
                    
                     $('#pills-eng-tab').removeClass("active");
                    $('#pills-eng-tab').addClass("disabled not-allowed");

                    $('#pills-acct-tab').addClass("active");
                    $('#pills-acct-tab').removeClass("disabled not-allowed");

                    $('#pills-vend-tab').removeClass("active");
                    $('#pills-vend-tab').addClass("disabled not-allowed");

                    $('#pills-field-tab').removeClass("active");
                    $('#pills-field-tab').addClass("disabled not-allowed");

                    $('#pills-eng').removeClass("in show active");
                    $('#pills-acct').addClass("in show active");
                    $('#pills-vend').removeClass("in show active");
                    $('#pills-field').removeClass("in show active");
                }  
           });  
      });    
      $(document).on('click', '.edit_data-v', function(){  
           var id = $(this).attr("id");  
           $.ajax({  
                url:"./ddrtest/fetch.php",  
                method:"POST",  
                data:{id:id},  
                dataType:"json",  
                success:function(data){  
                     $('#deb-v').val(data.deb);  
                     $('#t-v').val(data.t);  
                     $('#de-v').val(data.de);  
                     $('#ts-v').val(data.ts);  
                     $('#te-v').val(data.te);  
                     $('#id-v').val(data.id);  
                     $('#api-v').val(data.api);  
                     $('#d-v').val(data.d);  
                     $('#cvn-v').val(data.cvn);  
                     $('#cin-v').val(data.cin);  
                     $('#drn-v').val(data.drn); 
                     $('#dc-v').val(data.dc);  
                     $('#tc-v').val(data.tc);  

                      $('#insert-v').val("Update");  
                     $('#add_data_Modal').modal('show');  

                    $('#pills-eng-tab').removeClass("active");
                    $('#pills-eng-tab').addClass("disabled not-allowed");

                    $('#pills-acct-tab').removeClass("active");
                    $('#pills-acct-tab').addClass("disabled not-allowed");

                    $('#pills-vend-tab').addClass("active");
                    $('#pills-vend-tab').removeClass("disabled not-allowed");

                    $('#pills-field-tab').removeClass("active");
                    $('#pills-field-tab').addClass("disabled not-allowed");

                    $('#pills-eng').removeClass("in show active");
                    $('#pills-acct').removeClass("in show active");
                    $('#pills-vend').addClass("in show active");
                    $('#pills-field').removeClass("in show active");
                    
                }  
           });  
      });    
      $(document).on('click', '.edit_data-f', function(){  
           var id = $(this).attr("id");  
           $.ajax({  
                url:"./ddrtest/fetch.php",  
                method:"POST",  
                data:{id:id},  
                dataType:"json",  
                success:function(data){  
                     $('#deb-f').val(data.deb);  
                     $('#t-f').val(data.t);  
                     $('#de-f').val(data.de);  
                     $('#ts-f').val(data.ts);  
                     $('#te-f').val(data.te);  
                     $('#id-f').val(data.id);  
                     $('#api-f').val(data.api);  
                     $('#d-f').val(data.d);  
                     $('#cvn-f').val(data.cvn);  
                     $('#cin-f').val(data.cin);  
                     $('#drn-f').val(data.drn); 
                     $('#dc-f').val(data.dc);  
                     $('#tc-f').val(data.tc);  

                    $('#insert-f').val("Update");  
                    
                    $('#add_data_Modal').modal('show');  
                    
                    $('#pills-eng-tab').removeClass("active");
                    $('#pills-eng-tab').addClass("disabled not-allowed");

                    $('#pills-acct-tab').removeClass("active");
                    $('#pills-acct-tab').addClass("disabled not-allowed");

                    $('#pills-vend-tab').removeClass("active");
                    $('#pills-vend-tab').addClass("disabled not-allowed");

                    $('#pills-field-tab').addClass("active");
                    $('#pills-field-tab').removeClass("disabled not-allowed");

                    $('#pills-eng').removeClass("in show active");
                    $('#pills-acct').removeClass("in show active");
                    $('#pills-vend').removeClass("in show active");
                    $('#pills-field').addClass("in show active");

                }  
           });  
      });    
      $('#insert_form-e').on("submit", function(event){  
           event.preventDefault();  
           if($('#de').val() == "")  
           {  
                alert("Date is required");  
           }  
           else  
           {  
                $.ajax({  
                     url:"./ddrtest/insert.e.php",  
                     method:"POST",  
                     data:$('#insert_form-e').serialize(),  
                     beforeSend:function(){  
                          $('#insert-e').val("Inserting");  
                     },  
                     success:function(data){  
                          $('#insert_form-e')[0].reset();  
                          $('#add_data_Modal').modal('hide');  
                          $('#ddr_table').html(data);  
                     }  
                });  
           }  
      });  
      $('#insert_form-a').on("submit", function(event){  
           event.preventDefault();  
           if($('#de').val() == "")  
           {  
                alert("Date is required");  
           }  
           else  
           {  
                $.ajax({  
                     url:"./ddrtest/insert.a.php",  
                     method:"POST",  
                     data:$('#insert_form-a').serialize(),  
                     beforeSend:function(){  
                          $('#insert-a').val("Inserting");  
                     },  
                     success:function(data){  
                          $('#insert_form-a')[0].reset();  
                          $('#add_data_Modal').modal('hide');  
                          $('#ddr_table').html(data);  
                     }  
                });  
           }  
      });  
      $('#insert_form-v').on("submit", function(event){  
           event.preventDefault();  
           if($('#de').val() == "")  
           {  
                alert("Date is required");  
           }  
           else  
           {  
                $.ajax({  
                     url:"./ddrtest/insert.v.php",  
                     method:"POST",  
                     data:$('#insert_form-v').serialize(),  
                     beforeSend:function(){  
                          $('#insert-v').val("Inserting");  
                     },  
                     success:function(data){  
                          $('#insert_form-v')[0].reset();  
                          $('#add_data_Modal').modal('hide');  
                          $('#ddr_table').html(data);  
                     }  
                });  
           }  
      }); 
      $('#insert_form-f').on("submit", function(event){  
           event.preventDefault();  
           if($('#de').val() == "")  
           {  
                alert("Date is required");  
           }  
           else  
           {  
                $.ajax({  
                     url:"./ddrtest/insert.f.php",  
                     method:"POST",  
                     data:$('#insert_form-f').serialize(),  
                     beforeSend:function(){  
                          $('#insert-f').val("Inserting");  
                     },  
                     success:function(data){  
                          $('#insert_form-f')[0].reset();  
                          $('#add_data_Modal').modal('hide');  
                          $('#ddr_table').html(data);  
                     }  
                });  
           }  
      }); 

      $(document).on('click', '.view_data', function(){  
           var id = $(this).attr("id");  
           if(id != '')  
           {  
                $.ajax({  
                     url:"./ddrtest/select.php",  
                     method:"POST",  
                     data:{id:id},  
                     success:function(data){  
                          $('#ddr_detail').html(data);  
                          $('#dataModal').modal('show');  
                     }  
                });  
           }            
      });  
 });  
 </script>
</body>
<div class="toggle-btn"></div>
    <script src="assets/js/datepicker-full.js"></script>
    <SCRIPT>
            $("#de-e").datepicker({
                format: "yyyy-mm-dd"
            });
            $("#de-a").datepicker({
                format: "yyyy-mm-dd"
            });
            $("#ad").datepicker({
                format: "yyyy-mm-dd"
            });
            $("#de-v").datepicker({
                format: "yyyy-mm-dd"
            });
            $("#de-f").datepicker({
                format: "yyyy-mm-dd"
            });
            // const picker1 = new SimplePicker('startdate');
            // const picker2 = new SimplePicker('enddate');
            /* 
            const elem0 = document.querySelector('input[name="de-e"]');
            const datepickerE = new Datepicker(elem0, {
            buttonClass: 'btn',
            format: 'yyyy-mm-dd',
            });

            const elem1 = document.querySelector('input[name="de-a"]');
            const datepickerA = new Datepicker(elem1, {
            buttonClass: 'btn',
            format: 'yyyy-mm-dd',
            });

            const elem2 = document.querySelector('input[name="ad"]');
            const datepickerAD = new Datepicker(elem2, {
            buttonClass: 'btn',
            format: 'yyyy-mm-dd',
            });

            const elem3 = document.querySelector('input[name="de-v"]');
            const datepickerV = new Datepicker(elem3, {
            buttonClass: 'btn',
            format: 'yyyy-mm-dd',
            });

            const elem4 = document.querySelector('input[name="de-f"]');
            const datepickerF = new Datepicker(elem4, {
            buttonClass: 'btn',
            format: 'yyyy-mm-dd',
            }); */
            // const elem2 = document.getElementById('inline');
            // const datepicker2 = new Datepicker(elem2, {
            //   buttonClass: 'btn',
            // });
            // const elem3 = document.getElementById('range');
            // const datepicker3 = new DateRangePicker(elem3, {
            //   buttonClass: 'btn',
            // });
    </SCRIPT>
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
<!-- <script type="text/javascript" src="WSB/stylesheet/holder.min.js.download"></script> -->
<script type="text/javascript" src="WSB/stylesheet/offcanvas.js.download"></script>


	</html>
