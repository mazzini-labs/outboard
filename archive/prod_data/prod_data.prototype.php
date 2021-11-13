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
	<!-- <meta charset="utf-8" />
	<meta http-equiv="x-ua-compatible" content="ie=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/maintest.css?=v1.2">
	<link rel="stylesheet" type="text/css" href="css/tabs.css?v1.0.0.4">
    <link rel="stylesheet" type="text/css" href="css/search.css">
    <link rel="stylesheet" type="text/css" href="css/fixed-action-button.css">
	<link href="WSB/stylesheet/offcanvas.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
	<script type="text/javascript" src="datatables/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css"/> -->
    <?php include 'dependencies.php'; ?>
    <script src="https://unpkg.com/feather-icons"></script>
    <script type="text/javascript" src="js/chart.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@0.7.7"></script>
    <script type="text/javascript" src="./assets/js/inlineEdit.js"></script>
    <script type="text/javascript" src="js/fixed-action-button.js"></script>
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
	integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
	crossorigin=""/>
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
	integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
	crossorigin=""></script>
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
            td:first-child.engineering-d {
                font-weight: bold;
            }
            .engineering {
                font-size: 12px;
            }
            .accounting {
                background-color: rgba(77,77,255,0.5); 
                color: white;
                /* color: #4d4dff; */
            }
            .accounting-text { 
                color: rgba(77,77,255,1);
                font-size: 12px;
            }	
            td:first-child.accounting-date {
                font-weight: bold;
            }	
            .vendor{
                /* background-color: gold; */
                font-size: 11px;
                background-color: rgba(255, 215, 0, 0.5);
            }
            .vendor > table.vendortable {
                background-color: rgba(204, 255, 204, 1)!important;
            }

            .vendortable {
                background-color: rgba(204, 255, 204, 1)!important;
            }
            .field {
                font-size: 12px;
                color: purple;
            }
            td:first-child.field-date { 
                font-weight: bold; 
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
            .text-wrap{
                white-space:normal!important;
            }
            .lg-icon {
                width: 1.625rem;
                height: 1.625rem;
                vertical-align: -webkit-baseline-middle;

            }
            .sm-icon {
                width: 1.25rem;
                height: 1.25rem;
                vertical-align: -webkit-baseline-middle;
                margin-top: 0.75rem;
            }
            .smol th,
            .smol td,
            .smol a,
            .smol p {
            padding-top: 0.3rem;
            padding-bottom: 0.3rem;
            font-size: 14px;
            }
            table.dataTable tbody td 
            {
            word-break: break-word;
            vertical-align: top;
            }
            .text-wrap
            {
                white-space:normal;
            }
            .svg 
            {
                width: 24px;
                height: 24px;
                color: white;
                stroke-width: 2;
                stroke-linecap: round;
                stroke-linejoin: round;
                fill: none;
            }
            .edit 
            {
                background-image: url("./image/edit-2.svg");
            }
            .view
            {
                background-image: url("./image/eye.svg");
            }
            .cumulativeproduction 
            {
                width: 13vw;
                /* height: 10em; */
                background-color: rbga(255,255,255,0.5);
                position: fixed;
                z-index: 1;
                display: inline-block;
                overflow: hidden;
                /* line-height: 1.5; */
            }
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
        <?php console_log($api); ?>
		<script type="text/javascript" class="init">
			$(function() {
                var api = <?php echo $api; ?>;
                var da = "ddr2015pres";
                var sa = "dsr2015pres";
                var db = "before2015detailrpt";
                var sb = "before2015sumrpt";
                var click = 1;
                var clickddr = 0;
                var clickdsr = 0;
                var clickt1 = 0;
                var clickt2 = 0;
                var clickt3 = 0;
                var clickt4 = 0;
                var clickt5 = 0;
                var oTable;
                var iTable;
                var sTable;
                var aDDRTable;
                var aDSRTable;
                var bDDRTable;
                var bDSRTable;
                
                $(document).ready(function() {
                    $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
                        $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
                        console.log('click: '+click+' clickddr: '+clickddr+' clickt1: '+clickt1+' clickt2: '+clickt2+' clickt3: '+clickt3+' clickt4: '+clickt4);
                    } );
     
                    if (click < 2){
                        click++;
                        oTable = $('#productionTable').DataTable( {
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
                            ],
                            
                                
                        } );
                    };
                });
                $('#ddr-tab').click(function(){
                    if(clickddr < 1){
                        clickddr++;
                    
                        iTable = $('#ddrTable').DataTable( {
                            "ajax": {
                                "url" : "ajax/prodnotes.ajax.php",
                                "data": 
                                {
                                    "api": api,
                                }
                            }, 
                            "sDom": 't',
                            "order": [],
                            
                            deferRender: true,
                            scrollY: 550,
                            scroller: true,
                            "searching": true,
                            "autoWidth": false, 
                            "columns": [
                                {
                                    // Change Department Enum to actual name
                                    "data": null, render: function ( data, type, row ) 
                                    {
                                      /*   if(data.d == 'e'){
                                            return 'Engineering';
                                        }
                                        else
                                        {
                                            return data.d;
                                        } */
                                        switch(data.d)
                                        {
                                            case 'e':
                                                return 'Engineering';
                                            break;
                                            case 'a':
                                                return 'Accounting';
                                            break;
                                            case 'v':
                                                return 'Vendor';
                                            break;
                                            default:
                                                return 'Field';
                                            break;
                                        }
                                    }, 
                                    //"data": "d",
                                    "defaultContent": ""
                                },
                                {
                                    // Date
                                    // TODO: get dates formatted as M-D-YYYY in select statement
                                    "data": "de", 
                                    "defaultContent": ""
                                },
                                {
                                    // Time (Start - End)
                                    // TODO: get times formatted as H:MM in select statement
                                    "data": null, render: function ( data, type, row ) 
                                    {
                                        return data.ts+' - '+data.te;
                                    },
                                    // "data": "ts",
                                    "defaultContent": "",
                                },
                                {
                                    // Vendor/Contact
                                    "data": "cvn", 
                                    "defaultContent": "",
                                },
                                {
                                    // Invoice # / Contact Info
                                    "data": "cin", 
                                    "defaultContent": "",
                                },
                                {
                                    // Invoice Details / DDR
                                    "data": null, render: function ( data, type, row ) 
                                    {
                                        switch(data.d)
                                        {
                                            case 'e':
                                                return data.drn;
                                            break;
                                            case 'a':
                                                return data.drn;
                                            break;
                                            case 'v':
                                                var rtn = data.drn;
                                                // These functions check to see if there is a value in the database. If there is not,
                                                // the table will print out one of the following: null, NaN, or infinity
                                                // My understanding of the actual logic behind it is that a null value cannot be divided
                                                // by itself, and will store 'undefined' as the value. Because it's undefined, it then cannot
                                                // equal to anything (including itself) because it's undefined. 
                                                var checkdt = data.dt / data.dt; 
                                                var checkdc = data.dc / data.dc;
                                                var checkat = data.at / data.at;
                                                var checkac = data.ac / data.ac;
                                                var checket = data.et / data.et;
                                                var checktt = data.tt / data.tt;
                                                if(checkdt == checkdt || checkdc == checkdc || checkat == checkat || checkac == checkac || checket == checket || checktt == checktt)
                                                {
                                                    rtn += '<table class="table vendortable" width="100%">';
                                                }
                                                if(checkdt == checkdt || checkdc == checkdc)
                                                {
                                                    rtn += '<tr><td class="vendortable"> Deducted Time:</td><td class="vendortable">  ' + data.dt + ' hours </td>'; 
                                                    rtn += '<td class="vendortable">Deducted Cost:</td><td class="vendortable">  $' + data.dc + '</td><tr>';
                                                }
                                                if(checkat == checkat || checkac == checkac)
                                                {
                                                    rtn += '<tr><td class="vendortable">Adjusted Time:</td><td class="vendortable">  ' + data.at + ' hours </td>';
                                                    rtn += '<td class="vendortable">Adjusted Cost:</td><td class="vendortable">  $' + data.ac + '</td><tr>';
                                                }
                                                if(checket == checket )
                                                {
                                                    rtn += '<tr><td class="vendortable">Estimated Time:</td><td class="vendortable">  ' + data.et + ' hours </td><tr>';
                                                }
                                                if(checktt == checktt )
                                                {
                                                    rtn += '<tr style="border-top: 1px solid rgba(0, 0, 0, 1);"><td class="vendortable">Total Time:</td><td class="vendortable">  ' + data.tt + ' hours</td><tr>';
                                                }
                                                if(checkdt == checkdt || checkdc == checkdc || checkat == checkat || checkac == checkac || checket == checket || checktt == checktt)
                                                {
                                                    rtn += '</table>';
                                                }
                                                return rtn;                                                                                
                                                
                                            break;
                                            default:
                                                return data.drn;
                                        }
                                    }, 
                                    "defaultContent": "",
                                    },
                                {
                                    // $ / EDC / 
                                    "data": null, render: function ( data, type, row ) 
                                    {
                                        switch(data.d){
                                            case 'a':
                                                return $.fn.dataTable.render.number( ',', '.', 2, '$').display(data.edc);
                                            break;
                                            case 'v':
                                                return $.fn.dataTable.render.number( ',', '.', 2, '$', '/hour').display(data.edc);
                                            break;
                                            default:
                                                return $.fn.dataTable.render.number( ',', '.', 2, '$').display(data.edc);
                                            
                                        }
                                        
                                    },
                                    "defaultContent": "",
                                },
                                {
                                    // Approvals / ECC
                                    "data": null, render: function ( data, type, row ) 
                                    {
                                        switch(data.d){
                                            case 'a':
                                                if(data.ai != null){
                                                    return 'Approval Initials: '+data.ai+'<hr>Approval Date: '+data.ad;
                                                }
                                                else
                                                {
                                                    return ' - ';
                                                }
                                            break;
                                            case 'v':
                                                return $.fn.dataTable.render.number( ',', '.', 2, '$').display(data.ecc);
                                            break;
                                            default:
                                                return $.fn.dataTable.render.number( ',', '.', 2, '$').display(data.ecc);
                                        }
                                    },
                                    "defaultContent": "",
                                },
                                {
                                    "data": null, render: function ( data, type, row ) 
                                    {
                                        return '<button name="edit" value="Edit" id="'+data.id+'" class="btn btn-info btn-sm edit_ddr-'+data.d+'" data-toggle="tooltip" title="Edit" /><img src=image/edit-2.svg border=0></button><button data-toggle="tooltip" title="View" name="view" value="view" id="'+data.id+'" class="btn btn-info btn-sm view_data" /><img src=image/eye.svg border=0></button>';
                                        //return '<input type="button" name="edit" value="Edit" id="'+data.id+'" class="btn btn-info btn-sm edit_ddr-'+data.d+'" /><input type="button" name="view" value="view" id="'+data.id+'" class="btn btn-info btn-sm view_data" />';
                                    },
                                    "defaultContent": "",
                                },
                            ],
                            "columnDefs": [
                                
                                { width: "5%", "targets": [0, 1, 2, 3, 4, 6, 7, 8] },
                                { width: "10%", "targets": [2, 3, 4, 6, 7, 8] },
                                { width: "30%", "targets": 5 },
                                // { className: "text-wrap", "targets":  4  },
                                { className: "text-wrap", "targets":  [3, 4, 5]  },

                                {
                                    targets: [0,1,2,3,4,5,6,7,8],
                                    "createdCell": function (td, cellData, rowData, row, col) {
                                        // "createdRow" : function (row, data, dataIndex) {
                                        {
                                            var check = iTable.cell(td,0).data(); 
                                            //var check = $(cells).html();
                                            console.log(iTable.cell(td,0).data());
                                            /* switch(check){
                                                case 'Vendor':
                                                    return $(td).css('background-color', '#F08080')
                                                    console.log('Vendor');
                                                    console.log($(cells).html());
                                                    console.log($(row).html());
                                                // break;
                                                case 'Engineering':
                                                    return $(row).css('background-color', '#8080F0')
                                                    console.log('Eng');
                                                    console.log($(cells).html());
                                                    console.log($(row).html());
                                                // break;
                                                default:
                                                $(td).css('background-color', '#80F080')
                                                console.log($(cells).html());
                                                console.log($(row).html());
                                                console.log(iTable.cell(row,0).data());
                                                console.log(iTable.cell(row, row.d).data());
                                            } */
                                            if ( check == 'e' ) { $(td).css('color', '#F08080'); console.log(iTable.cell(td,1).data()); }
                                            else if ( check == 'Engineering' ) { $(td).css('background-color', '#8080F0'); }
                                        }
                                    },
                                    
                                },

                                {
                                    targets: [4,5],
                                    "createdCell": function (td, cellData, rowData, row, col) {
                                        {
                                            var checkSI = iTable.cell(td,5).data(); 
                                            if ( checkSI == 'Shut-in' || checkSI == 'Shut-In' || checkSI  == 'INACTIVE' ) 
                                            {
                                                $(td).css('font-weight', 'bold')
                                            }
                                        }
                                    },

                                }                            
                            ],
                            "rowCallback": function( row, data, index ) 
                            {
                                switch(data.d)
                                {
                                    case 'e':
                                        $('td').eq(0).find('td').addClass('engineering');
                                        $('td:eq(1)', row).addClass('engineering-date');
                                        console.log($('td',1));
                                    break;
                                    case 'a':
                                        $('td', row).addClass('accounting');
                                    break;
                                    case 'v':
                                        $('td', row).addClass('vendor smol');
                                    break;
                                    default:
                                        $('td', row).addClass('field');
                                    break;
                                }
                            }
  
                        } );
                    };
                });
                $('#dsr-tab').click(function(){
                    if(clickdsr < 1){
                        clickdsr++;
                    
                        sTable = $('#dsrTable').DataTable( {
                            "ajax": {
                                "url" : "ajax/dsr.ajax.php",
                                "data": function ( d )  
                                {
                                    d.api = <?php echo $api; ?>;
                                }
                            }, 
                            "sDom": 't',
                            "order": [],
                            
                            deferRender: true,
                            scrollY: 500,
                            scroller: true,
                            "searching": true,
                            "autoWidth": false, 
                            "columns": [
                                {
                                    // Date
                                    "data": "de", 
                                    "defaultContent": ""
                                },
                                {
                                    // DSR
                                    "data":  "drn",
                                    "defaultContent": "",
                                },
                                {
                                    // EDC  
                                    "data": "edc",
                                    "defaultContent": "",
                                    render: $.fn.dataTable.render.number( ',', '.', 2, '$')
                                },
                                {
                                    // ECC
                                    "data": "ecc",
                                    "defaultContent": "",
                                    render: $.fn.dataTable.render.number( ',', '.', 2, '$')
                                },
                                {
                                    "data": null, render: function ( data, type, row ) 
                                    {
                                        return '<button name="edit" value="Edit" id="'+data.id+'" class="btn btn-info btn-sm edit_dsr" data-toggle="tooltip" title="Edit" /><img src=image/edit-2.svg border=0></button><button data-toggle="tooltip" title="View" name="view" value="view" id="'+data.id+'" class="btn btn-info btn-sm view_data" /><img src=image/eye.svg border=0></button>';
                                    },
                                    "defaultContent": "",
                                },
                            ],
                            "columnDefs": [
                                
                                { width: "2%", "targets": [0, 2, 3, 4] },
                                { width: "50%", "targets": 1 },
                                { className: "text-wrap", "targets":  1  },
                            ] 
  
                        } );
                    };
                });
                $('#t1-tab').click(function(){
                    if(clickt1 < 1){
                        clickt1++;
                        aDDRTable = $('#ddr2015pres').DataTable( {
                            "ajax": 
                            {
                                "url" : "ajax/ddrtest.1.php",
                                // "type" : "POST",
                                "data": 
                                {
                                    "api": <?php echo $api; ?>,
                                    // "sheet": "ddr2015pres"
                                }
                            },
                            "sDom": 't',
                            "order": [],
                            //deferRender: true,
                            scrollY: 600,
                            scroller: true,
                            "searching": true,
                            "autoWidth": "false",
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
                            ],
                            "columnDefs": [
                                { "width": "20%", "targets": 0 }
                            ],
                            "columnDefs": [
                            { className: "text-wrap", "targets":  [0,1,2,3,4,5,6]  }
                            ],
                            "rowCallback": function( row, data, index ) 
                            {
                                switch(data.t)
                                {
                                    case 'e':
                                        $('td', row).addClass('engineering-d');
                                        $('td:eq(1)', row).addClass('engineering-date');
                                        $('td', row).addClass('engineering');
                                        console.log($('td',1));
                                    break;
                                    case 'a':
                                        $('td', row).addClass('accounting-date');
                                        $('td', row).addClass('accounting-text');
                                    break;
                                    case 'v':
                                        $('td', row).addClass('vendor smol');
                                    break;
                                    default:
                                        $('td', row).addClass('field-date');
                                        $('td', row).addClass('field');
                                    break;
                                }
                            }

                        } );
                    };
                });

                // $('#t1-tab').click(function(){
                //     if(clickt1 < 1){
                //         clickt1++;
                //         aDDRTable = $('#ddr2015pres').DataTable( {
                //             "ajax": 
                //             {
                //                 "url" : "ajax/ddrtest.php",
                //                 // "type" : "POST",
                //                 "data": 
                //                 {
                //                     "api": <?php echo $api; ?>,
                //                     "sheet": "ddr2015pres"
                //                 }
                //             },
                //             "sDom": 't',
                //             "order": [],
                //             //deferRender: true,
                //             scrollY: 600,
                //             scroller: true,
                //             "searching": true,
                //             "autoWidth": "false",
                //             "columns": [
                //                 {
                //                 "data": "a", // can be null or undefined
                //                 "defaultContent": ""
                //                 },
                //                 {
                //                 "data": "b", // can be null or undefined
                //                 "defaultContent": ""
                //                 },
                //                 {
                //                 "data": "c", // can be null or undefined
                //                 "defaultContent": ""
                //                 },
                //                 {
                //                 "data": "d", // can be null or undefined
                //                 "defaultContent": ""
                //                 },
                //                 {
                //                 "data": "e", // can be null or undefined
                //                 "defaultContent": ""
                //                 },
                //                 {
                //                 "data": "f", // can be null or undefined
                //                 "defaultContent": ""
                //                 },
                //                 {
                //                 "data": "g", // can be null or undefined
                //                 "defaultContent": ""
                //                 },
                //             ],
                //             "columnDefs": [
                //                 { "width": "20%", "targets": 0 }
                //             ],
                //             "columnDefs": [
                //             { className: "text-wrap", "targets":  [0,1,2,3,4,5,6]  }
                //             ]
                //         } );
                //     };
                // });
                $('#t2-tab').click(function(){
                    if(clickt2 < 1){
                        clickt2++;
                        aDSRTable = $('#dsr2015pres').DataTable( {
                            "ajax": {
                            "url" : "ajax/ddrtest.php",
                            // "type" : "POST",
                            "data": {
                                "api": api,
                                "sheet": sa
                            }
                            },
                            "sDom": 't',
                            "order": [],
                            //deferRender: true,
                            scrollY: 600,
                            scroller: true,
                            "searching": true,
                            "autoWidth": false,
                            // "order": [],
                            // "paging": false,
                            // "info": false,
                            // "searching": true,
                            // "sDom": 'd',
                            // "autoWidth": false,
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
                            ],
                            "columnDefs": [
                            { className: "text-wrap", "targets":  [0,1,2,3,4,5,6]  }
                            ]
                        } );
                    };
                });
                $('#t3-tab').click(function(){
                    if(clickt3 < 1){
                        clickt3++;
                        bDDRTable = $('#before2015detailrpt').DataTable( {
                            "ajax": {
                            "url" : "ajax/ddrtest.php",
                            // "type" : "POST",
                            "data": {
                                "api": api,
                                "sheet": db
                            }
                            },
                            "sDom": 't',
                            "order": [],
                            //deferRender: true,
                            scrollY: 600,
                            scroller: true,
                            "searching": true,
                            "autoWidth": false,
                            // "order": [],
                            // "paging": false,
                            // "info": false,
                            // "searching": true,
                            // "sDom": 'd',
                            // "autoWidth": false,
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
                            ],
                            "columnDefs": [
                            { className: "text-wrap", "targets":  [0,1,2,3,4,5,6]  }
                            ]
                        } );
                    };
                });
                $('#t4-tab').click(function(){
                    if(clickt4 < 1){
                        clickt4++;
                    bDSRTable = $('#before2015sumrpt').DataTable( {
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
                        ],
                            "columnDefs": [
                            { className: "text-wrap", "targets":  [0-11]  }
                            ]
                        } );
                    };
                });
                $('#info-tab').click(function(){
                    if(clickt5 < 1){
                        clickt5++;
                    notesTable = $('#notesTable').DataTable( {
                        "ajax": {
                        "url" : "ajax/wellnotes.ajax.php",
                        // "type" : "POST",
                        "data": {
                            "api": api
                        }
                        },
                        "order": [],
                        "paging": true,
                        "info": false,
                        deferRender: true,
                        scrollY: "20vh",
                        scroller: true,
                        "searching": true,
                        "sDom": 't',
                        "autoWidth": true,
                        "columns": [
                            {
                            "data": "notes_update", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "notes", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "si_notes", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "pumper", // can be null or undefined
                            "defaultContent": ""
                            },
                             /*{
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
                            {
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
                        ],
                            // "columnDefs": [
                            // { className: "text-wrap", "targets":  [0, 1, 2, 3]  }
                            // ]
                        } );
                    };
                });
				$('#searchProduction').keyup(function(){
                        oTable.search($(this).val()).draw() ;
                        if(clickddr != 0){
                        iTable.search($(this).val()).draw() ;
                        }
                        if(clickdsr != 0){
                        sTable.search($(this).val()).draw() ;
                        }
                        if(clickt1 != 0){
                        aDDRTable.search($(this).val()).draw() ;
                        }
                        if(clickt2 != 0){
						aDSRTable.search($(this).val()).draw() ;
                        }
                        if(clickt3 != 0){
						bDDRTable.search($(this).val()).draw() ;
                        }
                        if(clickt4 != 0){
						bDSRTable.search($(this).val()).draw() ;
                        }
                    })
                    $("#searchProduction").keypress(function(e) {
                    //Enter key
                    if (e.which == 13) {
                        return false;
                    }
                    });
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
            // Insert/Edit/View DDR/DSR
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
                    $('#insert').val("Insert"); 
                    $('#insert_form')[0].reset();
                    $('#id').val('');
                    $('.ddr-a').prop('disabled', false);
                    $('.ddr-v').prop('disabled', false);
                    $('.ddr-f').prop('disabled', false);
                    $('.ddr-e').prop('disabled', false);
                });
                $('#pills-eng').click(function(){  
                    $('.ddr-a').prop('disabled', true);
                    $('.ddr-v').prop('disabled', true);
                    $('.ddr-f').prop('disabled', true);
                });
                $('#pills-acct').click(function(){  
                    $('.ddr-e').prop('disabled', true);
                    $('.ddr-v').prop('disabled', true);
                    $('.ddr-f').prop('disabled', true);
                });
                $('#pills-vend').click(function(){  
                    $('.ddr-e').prop('disabled', true);
                    $('.ddr-a').prop('disabled', true);
                    $('.ddr-f').prop('disabled', true);
                });
                $('#pills-field').click(function(){  
                    $('.ddr-e').prop('disabled', true);
                    $('.ddr-a').prop('disabled', true);
                    $('.ddr-v').prop('disabled', true);
                });
                $('#dsr-tab').click(function(){  
                    $('.ddr-e').prop('disabled', true);
                    $('.ddr-a').prop('disabled', true);
                    $('.ddr-v').prop('disabled', true);
                    $('.ddr-f').prop('disabled', true);
                });
                $('#insert_form.ddr').on("submit", function(event){  
                    event.preventDefault();  
                    if($('#de').val() == "")  
                    {  
                            alert("Date is required");  
                    }  
                    else  
                    {  
                            $.ajax({  
                                url:"./ddrtest/insert.ntf.php",  
                                method:"POST",  
                                data:$('#insert_form').serialize(),  
                                beforeSend:function(){  
                                    $('#insert').val("Inserting");  
                                },  
                                success:function(data){  
                                    $('#insert_form')[0].reset();  
                                    $('#add_data_Modal').modal('hide');  
                                    // $('#ddr_table').html(data);  
                                    iTable.ajax.reload();  
                                }  
                            });  
                    }  
                });  
                $('#insert_form.dsr').on("submit", function(event){  
                    event.preventDefault();  
                    if($('#de.dsr').val() == "")  
                    {  
                            alert("Date is required");  
                    }  
                    else  
                    {  
                            $.ajax({  
                                url:"./ddrtest/insert.ntf.php",  
                                method:"POST",  
                                data:$('#insert_form.dsr').serialize(),  
                                beforeSend:function(){  
                                    $('#insert.dsr').val("Inserting");  
                                },  
                                success:function(data){  
                                    $('#insert_form.dsr')[0].reset();  
                                    $('#add_data_dsr_Modal').modal('hide');
                                    sTable.ajax.reload();  
                                    //$('#dsr_table').html(data);  
                                }  
                            });  
                    }  
                });  
                $(document).on('click', '.edit_ddr-e', function(){  
                    var id = $(this).attr("id");  
                    $.ajax({  
                            url:"./ddrtest/fetch.php",  
                            method:"POST",  
                            data:{id:id},  
                            dataType:"json",  
                            success:function(data){  
                                $('#deb.ddr').val(data.deb);  
                                $('#t.ddr').val(data.t);  
                                $('#de.ddr').val(data.de);  
                                $('#ts.ddr').val(data.ts);  
                                $('#te.ddr').val(data.te);  
                                $('#id.ddr').val(data.id);  
                                $('#api.ddr').val(data.api);  
                                $('#d.ddr-e').val(data.d);  
                                $('#cvn.ddr-e').val(data.cvn);  
                                $('#cin.ddr-e').val(data.cin);  
                                $('#drn.ddr-e').val(data.drn); 
                                $('#edc.ddr-e').val(data.edc);  
                                $('#ecc.ddr-e').val(data.ecc);  
                                console.log(data.deb);  
                                console.log(data.t);  
                                console.log(data.de);  
                                console.log(data.ts);  
                                console.log(data.te);  
                                console.log(data.id);  
                                console.log(data.api);  
                                console.log(data.d);  
                                console.log(data.cvn);  
                                console.log(data.cin);  
                                console.log(data.drn); 
                                console.log(data.edc);  
                                console.log(data.ecc);
                                $('#insert.ddr-e').val("Update");  
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
                                $('.ddr-a').prop('disabled', true);
                                $('.ddr-v').prop('disabled', true);
                                $('.ddr-f').prop('disabled', true);
                                $('.ddr-e').prop('disabled', false);
                                
                            }  
                    });  
                });
                $(document).on('click', '.edit_ddr-a', function(){  
                    var id = $(this).attr("id");  
                    $.ajax({  
                            url:"./ddrtest/fetch.php",  
                            method:"POST",  
                            data:{id:id},  
                            dataType:"json",  
                            success:function(data){  
                                $('#deb.ddr').val(data.deb);  
                                $('#t.ddr').val(data.t);  
                                $('#de.ddr').val(data.de);  
                                $('#ts.ddr').val(data.ts);  
                                $('#te.ddr').val(data.te);  
                                $('#id.ddr').val(data.id);  
                                $('#api.ddr').val(data.api);  
                                $('#d.ddr-a').val(data.d);  
                                $('#cvn.ddr-a').val(data.cvn);  
                                $('#cin.ddr-a').val(data.cin);  
                                $('#drn.ddr-a').val(data.drn); 
                                $('#edc.ddr-a').val(data.edc);  
                                $('#ecc.ddr-a').val(data.ecc);  
                                $('#ad').val(data.ad); 

                                $('#insert.ddr-a').val("Update");  
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
                                $('.ddr-a').prop('disabled', false);
                                $('.ddr-v').prop('disabled', true);
                                $('.ddr-f').prop('disabled', true);
                                $('.ddr-e').prop('disabled', true);
                            }  
                    });  
                });    
                $(document).on('click', '.edit_ddr-v', function(){  
                    var id = $(this).attr("id");  
                    $.ajax({  
                            url:"./ddrtest/fetch.php",  
                            method:"POST",  
                            data:{id:id},  
                            dataType:"json",  
                            success:function(data){  
                                $('#deb.ddr').val(data.deb);  
                                $('#t.ddr').val(data.t);  
                                $('#de.ddr').val(data.de);  
                                $('#ts.ddr').val(data.ts);  
                                $('#te.ddr').val(data.te);  
                                $('#id.ddr').val(data.id);  
                                $('#api.ddr').val(data.api);  
                                $('#d.ddr-v').val(data.d);  
                                $('#cvn.ddr-v').val(data.cvn);  
                                $('#cin.ddr-v').val(data.cin);  
                                $('#drn.ddr-v').val(data.drn); 
                                $('#edc.ddr-v').val(data.edc);  
                                $('#ecc.ddr-v').val(data.ecc); 
                                $('#ac.ddr-v').val(data.ac);
                                $('#dc.ddr-v').val(data.dc);
                                $('#at.ddr-v').val(data.at); 
                                $('#et.ddr-v').val(data.et); 
                                $('#dt.ddr-v').val(data.dt); 
                                $('#tt.ddr-v').val(data.tt); 

                                $('#insert.ddr-v').val("Update");  
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
                                $('.ddr-a').prop('disabled', true);
                                $('.ddr-e').prop('disabled', true);
                                $('.ddr-f').prop('disabled', true);
                                $('.ddr-v').prop('disabled', false);
                            }  
                    });  
                });    
                $(document).on('click', '.edit_ddr-f', function(){  
                    var id = $(this).attr("id");  
                    $.ajax({  
                            url:"./ddrtest/fetch.php",  
                            method:"POST",  
                            data:{id:id},  
                            dataType:"json",  
                            success:function(data){  
                                $('#deb.ddr').val(data.deb);  
                                $('#t.ddr').val(data.t);  
                                $('#de.ddr').val(data.de);  
                                $('#ts.ddr').val(data.ts);  
                                $('#te.ddr').val(data.te);  
                                $('#id.ddr').val(data.id);  
                                $('#api.ddr').val(data.api);  
                                $('#d.ddr-f').val(data.d);  
                                $('#cvn.ddr-f').val(data.cvn);  
                                $('#cin.ddr-f').val(data.cin);  
                                $('#drn.ddr-f').val(data.drn); 
                                $('#edc.ddr-f').val(data.edc);  
                                $('#ecc.ddr-f').val(data.ecc);  

                                $('#insert.ddr-f').val("Update");  
                                
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
                                $('.ddr-a').prop('disabled', true);
                                $('.ddr-v').prop('disabled', true);
                                $('.ddr-e').prop('disabled', true);
                                $('.ddr-f').prop('disabled', false);
                            }  
                    });  
                });    
                $(document).on('click', '.edit_dsr', function(){  
                    var id = $(this).attr("id");  
                    $.ajax({  
                            url:"./ddrtest/fetch.php",  
                            method:"POST",  
                            data:{id:id},  
                            dataType:"json",  
                            success:function(data){  
                                $('#deb.dsr').val(data.deb);  
                                $('#t.dsr').val(data.t);  
                                $('#de.dsr').val(data.de);  
                                $('#ts.dsr').val(data.ts);  
                                $('#te.dsr').val(data.te);  
                                $('#id.dsr').val(data.id);  
                                $('#api.dsr').val(data.api);  
                                $('#d.dsr').val(data.d);  
                                $('#cvn.dsr').val(data.cvn);  
                                $('#cin.dsr').val(data.cin);  
                                $('#drn.dsr').val(data.drn); 
                                $('#edc.dsr').val(data.edc);  
                                $('#ecc.dsr').val(data.ecc);  

                                $('#insert.dsr').val("Update");  
                                $('#add_data_dsr_Modal').modal('show');  
                                
                                
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
                                $('.ddr-a').prop('disabled', true);
                                $('.ddr-v').prop('disabled', true);
                                $('.ddr-f').prop('disabled', true);
                                $('.ddr-e').prop('disabled', true);
                                
                            }  
                    });  
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
<!-- Fixed Action Button OLD
<div class="fixed-action-btn" style="bottom: 45px; right: 24px; z-index:1500;">
    <a class="btn-floating btn-lg btn-success" data-toggle="tooltip" data-placement="left" title="Add New Entry">
      <i class="lg-icon" data-feather="edit-3" >add</i>
    </a>
    <ul class="list-unstyled">
      <li name="add" id="add" href="#add_data_Modal" data-toggle="modal"><a class="btn-floating btn-info" data-toggle="tooltip" data-placement="left" title="DDR"><i class="sm-icon" data-feather="plus" ></i></a></li>
      <li name="add_dsr" id="add_dsr" href="#add_data_dsr_Modal" data-toggle="modal"><a class="btn-floating btn-secondary" data-toggle="tooltip" data-placement="left" title="DSR"><i class="sm-icon" data-feather="plus" ></i></a></li>
    </ul>
  </div>
OLD Fixed Action Button -->
<!-- Fixed Action Button -->
<div class="fixed-action-btn" style="bottom: 45px; right: 24px; z-index:1500;" name="add" id="add" href="#add_data_Modal" data-toggle="modal">
    <a class="btn-floating btn-lg btn-success" data-toggle="tooltip" data-placement="left" title="Add New Entry">
      <i class="lg-icon" data-feather="edit-3" >add</i>
    </a>
    
  </div>
<!-- Fixed Action Button -->
<!-- Floating Legend -->
<div id="cumulativeproduction" style="display: none;/* top: 11em; left: 50vw; z-index:1500; */">
    <h6>Cum Production on Graph:  </h6>
        <div class="row"><p style="color: #fff;">Oil: <?php echo $cumoil; ?> bbl</p></div>
        <div class="row"><p style="color: #fff;">Gas: <?php echo $cumgas; ?> mcf</p></div>
        <div class="row"><p style="color: #fff;">Water: <?php echo $cumwater; ?> bbl</p></div>
</div>
<!-- Floating Legend -->

<!-- Edit DDR Entry Modal -->
 <div id="dataModal" class="modal fade">  
      <div class="modal-dialog modal-lg" >  
           <div class="modal-content" id="ddr_detail" style="height:90vh!important;">  
                
                <!-- <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </div>   -->
           </div>  
      </div>  
 </div>
<!-- Add DDR Entry Modal -->
<div class="modal fade right" id="add_data_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-side modal-top-right" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalPreviewLabel">DDR Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <div class="row mx-auto">
                    <h6>Type:</h6>
                </div> -->
                <!-- <div class="row"> -->
                <ul class="nav nav-pills nav-fill mb-1" id="pills-tab" role="tablist">
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
                <!-- </div> -->
            </div>
            <form id="insert_form" class="ddr" method="POST">
                <div class="modal-body mr-5">
                    <div class="row mx-auto">
                        <div class="col">
                            <select class="custom-select custom-select-sm mb-3" name="api" size="1">
                            <?php
                                $table = "list";
                                $sql = "SELECT api, entity_common_name FROM $table";// ORDER BY well_lease ASC";
                                $result = mysqli_query($mysqli,$sql) or die(mysql_error());
                                    //console_log($result);
                                ?>
                                <!-- <option>Select Well:</option> -->
                                <?php 
                                while ($row = mysqli_fetch_array($result)) {
                                    // $wellname = $row['well_lease'] . "# " . $row['well_no']; 
                                    $wellname = $row['entity_common_name'];
                                    $conditional = ($row['api'] == $api) ?  '"' . $row['api'] . ' selected "' :  '"' . $row['api'] . '"';
                                    ?>
                                <option name="api" id="api" value=<?php echo $conditional;  ?>><?php echo $wellname; //$row['api']; // . $row['well_no'];?></option> 
                            <?php } ?>
                                </select> 
                                </div>
                        <div class="input-group input-group-sm mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Date Entered</span>
                            </div>
                            <input id="de" name="de" type="text" class="ddr form-control date datepicker-input" value="" required>
                            <input name="deb" id="deb" type="text" class="ddr form-control" placeholder="Your Name" aria-label="Data Entry By" required>
                            <div class="input-group-append">
                                <span class="input-group-text">Person Entering Data</span>
                            </div>
                        </div>
                        <div class="input-group input-group-sm mb-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Start Time</span>
                            </div>
                            <input type="time" value="08:00" step="600" class="ddr form-control" name="ts" id="ts" required>
                            <input type="time" value="08:00" step="600" class="ddr form-control" name="te" id="te" required>
                            <div class="input-group-append">
                                <span class="input-group-text">End Time</span>
                            </div>
                        </div>
                        <input type="hidden" name="id" id="id" class="ddr"/>
                        <!-- <input type="hidden" name="api" id="api" class="ddr" value=<?php //echo $api; ?> /> -->
                    </div>
                </div>
                <div class="modal-body mr-5">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade in show active" id="pills-eng" role="pillpanel">
                            <div class="row mx-auto">
                            <!-- <form id="insert_form-e" method="POST"> -->
                                <div class="ddr-e input-group input-group-sm mb-1">
                                    <div class="ddr-e input-group-prepend">
                                        <span class="ddr-e input-group-text">Contact Name</span>
                                    </div>
                                    <input name="cvn" id="cvn" type="text" class="ddr-e form-control" required>
                                    <input name="cin" id="cin" type="text" class="ddr-e form-control">
                                    <div class="ddr-e input-group-append">
                                        <span class="ddr-e input-group-text">Contact Info</span>
                                    </div>
                                </div>
                                <div class="ddr-e input-group input-group-sm mb-1">
                                    <div class="ddr-e input-group-prepend">
                                        <span class="ddr-e input-group-text">Daily Report</span>
                                    </div>
                                    <textarea name="drn" id="drn" class="ddr-e form-control" aria-label="With textarea" required></textarea>
                                </div>
                                <div class="ddr-e input-group input-group-sm mb-1">
                                    <div class="ddr-e input-group-prepend">
                                        <span class="ddr-e input-group-text">$</span>
                                    </div>
                                    <input name="edc" id="edc" type="text" class="ddr-e form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="ddr-e input-group-append">
                                        <span class="ddr-e input-group-text">Estimated Daily Cost</span>
                                    </div>
                                    <div class="ddr-e input-group-prepend">
                                        <span class="ddr-e input-group-text">$</span>
                                    </div>
                                    <input name="ecc" id="ecc" type="text" class="ddr-e form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="ddr-e input-group-append">
                                        <span class="ddr-e input-group-text">Estimated Cumulative Cost</span>
                                    </div>
                                    
                                    <input type="hidden" name="d" id="d" class="ddr-e" value="e" />
                                    <input type="hidden" name="t" id="t" class="ddr-e" value="d" />                                  
                                </div>
                                <!-- <hr class="mb-3"> -->
                                <div class="w-100"></div>
                                
                                <h5 class="mx-auto"><strong>NOT WORKING YET</strong></h5>
                                <div class="w-100"></div>
                                <p class="mx-auto">Vitals - Fill in information here as needed.</p>
                                <div class="w-100"></div>
                                    <div class="col">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Flowing Tubing Pressure:</span>
                                            </div>
                                            <input type="text" class="form-control" id="property_input" val=<?php echo $entop; ?>>
                                            <div class="input-group-append">
                                                <span class="input-group-text">psi</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Flowing Casing Pressure:</span>
                                            </div>
                                            <input type="text" class="form-control" id="property_input" val=<?php echo $entop; ?>>
                                            <div class="input-group-append">
                                                <span class="input-group-text">psi</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-100"></div>
                                    <div class="col">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Shut In Tubing Pressure:</span>
                                            </div>
                                            <input type="text" class="form-control" id="property_input" val=<?php echo $entop; ?>>
                                            <div class="input-group-append">
                                                <span class="input-group-text">psi</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Shut In Casing Pressure:</span>
                                            </div>
                                            <input type="text" class="form-control" id="property_input" val=<?php echo $entop; ?>>
                                            <div class="input-group-append">
                                                <span class="input-group-text">psi</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-100"></div>
                                    
                                    <div class="col">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Chlorides:</span>
                                            </div>
                                            <input type="text" class="form-control" id="property_input" val=<?php echo $entop; ?>>
                                            <div class="input-group-append">
                                                <span class="input-group-text">ppm</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Primary PM</span>
                                            </div>
                                            <select class="form-control">
                                                <option>Pulled Well</option>
                                                <option>Hot Oiled</option>
                                                <option>Chemical Treatment</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="w-100"></div>
                                    
                                    <div class="col">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Fluid Level</span>
                                            </div>
                                            <input type="text" class="form-control" id="property_input" val=<?php echo $entop; ?>>
                                            <div class="input-group-append">
                                                <span class="input-group-text">ft</span>
                                            </div>
                                        </div>
                                            
                                    </div>
                                    <div class="col">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Secondary PM</span>
                                            </div>
                                            <select class="form-control">
                                                <option>Pulled Well</option>
                                                <option>Hot Oiled</option>
                                                <option>Chemical Treatment</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- </div> -->
                                    <div class="w-100"></div>
                                    
                                    <div class="col">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                    <span class="input-group-text">Chemical Treatment</span>
                                            </div>
                                            <select class="form-control">
                                                <option>N/A</option>
                                                <option>Batch</option>
                                                <option>Drip</option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class="col">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Pumping Unit Speed</span>
                                            </div>
                                            <input type="text" class="form-control" id="property_input" val=<?php echo $entop; ?>>
                                            <div class="input-group-append">
                                                <span class="input-group-text">stroke/min</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-100"></div>
                                    <div class="col">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Reason for Shut In</span>
                                            </div>
                                            <select class="form-control">
                                                <option>Reason 1</option>
                                                <option>Reason 2</option>
                                                <option>Reason 3</option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class="col">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Pumping Unit Stroke Length</span>
                                            </div>
                                            <input type="text" class="form-control" id="property_input" val=<?php echo $entop; ?>>
                                            <div class="input-group-append">
                                                <span class="input-group-text">ft</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="w-100"></div>
                                    <div class="col">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Comments on SI</span>
                                            </div>
                                            <textarea class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="w-100"></div>
                                    <div class="col">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Reason for Pull Job</span>
                                            </div>
                                            <textarea class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <!-- </div> -->

                                </div>
                                <hr class="ddr-e mb-0">
                                <div class="ddr-e input-group p-1">
                                    <input type="submit" name="insert" id="insert" value="Insert" class="ddr-e btn btn-success m-3" />
                                    <button type="button" class="ddr-e btn btn-secondary m-3" data-dismiss="modal">Close</button>
                                </div>
                            <!-- </form> -->
                        </div>
                        <div class="tab-pane fade" id="pills-acct" role="tabpanel">
                            <div class="row mx-auto">
                            <!-- <form id="insert_form-a" method="POST"> -->
                                <div class="ddr-a input-group input-group-sm ">
                                    <div class="ddr-a input-group-prepend">
                                        <span class="ddr-a input-group-text">Vendor Name</span>
                                    </div>
                                    <input id="cvn" name="cvn" type="text" class="ddr-a form-control" placeholder="Vendor" aria-label="Vendor" required>
                                </div>    
                                <div class="ddr-a input-group input-group-sm">
                                    <div class="ddr-a input-group-prepend">
                                        <span class="ddr-a input-group-text">Invoice #</span>
                                    </div>
                                    <input id="cin" name="cin" type="text" class="ddr-a form-control" aria-label="Invoice #" required>
                                    <div class="ddr-a input-group-prepend">
                                        <span class="ddr-a input-group-text">$</span>
                                    </div>
                                    <input id="edc" name="edc" type="text" class="ddr-a form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="ddr-a input-group-append">
                                        <span class="ddr-a input-group-text">Invoice Amount</span>
                                    </div>
                                </div>
                                <div class="ddr-a input-group input-group-sm">
                                    <div class="ddr-a input-group-prepend">
                                        <span class="ddr-a input-group-text">Invoice Details</span>
                                    </div>
                                    <textarea id="drn" name="drn" class="ddr-a form-control" aria-label="With textarea"></textarea>
                                </div>
                                <div class="ddr-a input-group input-group-sm">
                                    <div class="ddr-a input-group-prepend">
                                        <span class="ddr-a input-group-text">Approval Initials</span>
                                    </div>
                                    <input id="ai" name="ai" type="text" aria-label="Approval Initials" class="ddr-a form-control">
                                    <input id="ad" name="ad" name="acct_approval_date" type="text" class="ddr-a form-control date datepicker-input">
                                    <div class="ddr-a input-group-append">
                                        <span class="ddr-a input-group-text">Approval Date</span>
                                    </div>
                                    <input type="hidden" name="d" id="d" class="ddr-a" value="a" />
                                    <input type="hidden" name="t" id="t" class="ddr-a" value="d" />     
                                    
                                </div>
                                
                                <hr class="ddr-a mb-0">
                                <div class="ddr-a input-group p-1">
                                    <input type="submit" name="insert" id="insert" value="Insert" class="ddr-a btn btn-success m-3" />
                                    <button type="button" class="ddr-a btn btn-secondary m-3" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-vend" role="tabpanel">	
                            <div class="row mx-auto">	
                            <!-- <form id="insert_form-v" method="POST"> -->
                                <div class="ddr-v input-group input-group-sm">
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">Vendor Name</span>
                                    </div>
                                    <input id="cvn" name="cvn" type="text" class="ddr-v form-control" required>
                                    <input id="cin" name="cin" type="text" class="ddr-v form-control" required>
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Vendor Service</span>
                                    </div>
                                </div>
                                <div class="ddr-v input-group input-group-sm">
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">Vendor Notes</span>
                                    </div>
                                    <textarea id="drn" name="drn" class="ddr-v form-control" aria-label="With textarea" required></textarea>
                                </div>
                                <div class="ddr-v input-group input-group-sm">
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">$</span>
                                    </div>
                                    <input id="edc" name="edc" type="text" class="ddr-v form-control" aria-label="Vendor Adjusted Hours" required>
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">/Hour</span>
                                    </div>
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Vendor Rate</span>
                                    </div>
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">$</span>
                                    </div>
                                    <input id="ac" name="ac" type="text" class="ddr-v form-control" aria-label="Vendor Adjusted Hours">
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Adjusted Cost</span>
                                    </div>
                                </div>
                                <div class="ddr-v input-group input-group-sm">
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">$</span>
                                    </div>
                                    <input id="dc" name="dc" type="text" class="ddr-v form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Deducted Cost</span>
                                    </div>
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">$</span>
                                    </div>
                                    <input id="ecc" name="ecc" type="text" class="ddr-v form-control" aria-label="Amount (to the nearest dollar)"  required>
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Total Cost</span>
                                    </div>
                                </div>
                                <div class="ddr-v input-group input-group-sm">
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">Adjusted Time</span>
                                    </div>
                                    <input id="at" name="at" type="text" class="ddr-v form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Hour(s)</span>
                                    </div>
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">Estimated Travel</span>
                                    </div>
                                    <input id="et" name="et" type="text" class="ddr-v form-control" aria-label="Vendor Adjusted Hours">
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Hour(s)</span>
                                    </div>
                                </div>
                                <div class="ddr-v input-group input-group-sm">
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">Deducted Time</span>
                                    </div>
                                    <input id="dt" name="dt" type="text" class="ddr-v form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Hour(s)</span>
                                    </div>
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">Total Time</span>
                                    </div>
                                    <input id="tt" name="tt" type="text" class="ddr-v form-control" aria-label="Amount (to the nearest dollar)"  required>
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Hour(s)</span>
                                    </div>
                                    <input type="hidden" name="d" id="d" class="ddr-v" value="v" />
                                    <input type="hidden" name="t" id="t" class="ddr-v" value="d" />     
                                </div>
                                <hr class="ddr-v mb-0">
                                <div class="ddr-v input-group p-1">
                                    <input type="submit" name="insert" id="insert" value="Insert" class="ddr-v btn btn-success m-3" />
                                    <button type="button" class="ddr-v btn btn-secondary m-3" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-field" role="tabpanel">
                            <div class="row mx-auto">
                            <!-- <form id="insert_form-f" method="POST"> -->
                                <div class="ddr-f input-group input-group-sm">
                                    <div class="ddr-f input-group-prepend">
                                        <span class="ddr-f input-group-text">Contact Name</span>
                                    </div>
                                    <input id="cvn" name="cvn" type="text" class="ddr-f form-control" required>
                                    <input id="cin" name="cin" type="text" class="ddr-f form-control">
                                    <div class="ddr-f input-group-append">
                                        <span class="ddr-f input-group-text">Contact Info</span>
                                    </div>
                                </div>
                                <div class="ddr-f input-group input-group-sm">
                                    <div class="ddr-f input-group-prepend">
                                        <span class="ddr-f input-group-text">Daily Report</span>
                                    </div>
                                    <textarea id="drn" name="drn" class="ddr-f form-control" aria-label="With textarea" required></textarea>
                                </div>
                                <div class="ddr-f input-group input-group-sm">
                                    <div class="ddr-f input-group-prepend">
                                        <span class="ddr-f input-group-text">$</span>
                                    </div>
                                    <input id="edc" name="edc" type="text" class="ddr-f form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="ddr-f input-group-append">
                                        <span class="ddr-f input-group-text">Estimated Daily Cost</span>
                                    </div>
                                    <div class="ddr-f input-group-prepend">
                                        <span class="ddr-f input-group-text">$</span>
                                    </div>
                                    <input id="ecc" name="ecc" type="text" class="ddr-f form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="ddr-f input-group-append">
                                        <span class="ddr-f input-group-text">Estimated Cumulative Cost</span>
                                    </div>
                                </div>
                                    <input type="hidden" name="d" id="d" class="ddr-f" value="f" />
                                    <input type="hidden" name="t" id="t" class="ddr-f" value="d" />     
                                    
                                <hr class="ddr-f mb-0">
                                <div class="ddr-f input-group p-1">
                                    <input type="submit" name="insert" id="insert" value="Insert" class="ddr-f btn btn-success m-3" />
                                    <button type="button" class="ddr-f btn btn-secondary m-3" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add DDR Entry Modal -->
<!-- Add DSR Entry Modal -->
<div class="modal fade right" id="add_data_dsr_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-side modal-top-right" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalPreviewLabel">DSR Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="insert_form" class="dsr" method="POST">
                <div class="modal-body">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Date</span>
                        </div>
                        <input id="de" name="de" type="text" class="dsr form-control date datepicker-input" value="" required>
                        <input name="deb" id="deb" type="text" class="dsr form-control" placeholder="Your Name" aria-label="Data Entry By">
                        <div class="input-group-append">
                            <span class="input-group-text">Person Entering Data</span>
                        </div>
                    </div>
                    <div class="dsr input-group input-group-sm">
                        <div class="dsr input-group input-group-sm">
                            <div class="dsr input-group-prepend">
                                <span class="dsr input-group-text">Daily Summary Report</span>
                            </div>
                            <textarea name="drn" id="drn" class="dsr form-control" aria-label="With textarea"></textarea>
                        </div>
                        <div class="dsr input-group input-group-sm">
                        <div class="dsr input-group-prepend">
                            <span class="dsr input-group-text">$</span>
                        </div>
                        <input name="edc" id="edc" type="text" class="dsr form-control" aria-label="Amount (to the nearest dollar)">
                        <div class="dsr input-group-append">
                            <span class="dsr input-group-text">Estimated Daily Cost</span>
                        </div>
                        <div class="dsr input-group-prepend">
                            <span class="dsr input-group-text">$</span>
                        </div>
                        <input name="ecc" id="ecc" type="text" class="dsr form-control" aria-label="Amount (to the nearest dollar)">
                        <div class="dsr input-group-append">
                            <span class="dsr input-group-text">Estimated Cumulative Cost</span>
                        </div>
                        <input type="hidden" name="id" id="id" class="dsr" />
                        <input type="hidden" name="api" id="api" class="dsr" value=<?php echo $api; ?> />
                        <input type="hidden" name="d" id="d" value="e" class="dsr" />
                        <input type="hidden" name="t" id="t" value="s" class="dsr" />     
                        <!-- </form> -->
                    </div>
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" name="insert" id="insert" value="Insert" class="dsr btn btn-success" />
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add DSR Entry Modal -->
 <script>  
 $(document).ready(function(){
    //$('#tabs li.disabled').find('a').removeAttr('data-toggle');  
     
    
      
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
           if($('#de-v').val() == "")  
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
           if($('#de-f').val() == "")  
           {  
                alert("Date is required");  
           } 
           if($('#ts-f').val() == "" || $('#te-f').val() == "")
           {
               alert("At least one time is required.");
           }
           if($('#ts-f').val() > $('#te-f').val() && $('#te-f').val() != "")
           {
               alert("The start time cannot be greater than the end time.");
           }
           if($('#cvn-f').val() == "")  
           {  
                alert("Contact name is required");  
           }
           if($('#cvn-f').val() != "" && $('#cin-f').val() == "")  
           {  
                alert("Please enter "+$('#cvn-f').val()+"'s contact information");  
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
      
 });  
 </script>
</body>
<div class="toggle-btn"></div>
    <script src="assets/js/datepicker-full.js"></script>
    <SCRIPT>
            $("#de").datepicker({
                format: "yyyy-mm-dd"
            });
            $("#de.dsr").datepicker({
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
		  <!-- <script type="text/javascript" src="WSB/dashboard/popper.min.js.download"></script> -->
          <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
          <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
<script type="text/javascript" src="WSB/dashboard/bootstrap.min.js.download"></script>

<!-- Icons -->
<script type="text/javascript" src="../WSB/dashboard/feather.min.js.download"></script>
<script>
    feather.replace()
    const cumprod = document.getElementById('cumulativeproduction');
    tippy('.r-tooltip', { 
          content: cumprod.innerHTML,
          allowHTML: true,
          placement: 'right',
          arrow: false 
        });
</script>   
<!-- <script type="text/javascript" src="WSB/stylesheet/holder.min.js.download"></script> -->
<script type="text/javascript" src="WSB/stylesheet/offcanvas.js.download"></script>


	</html>
