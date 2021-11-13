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
$mysqli = connect_noper();
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
</head>

<body class="bg-light" style="background-color: #0e5092;">
    <?php include 'include/header_extensions.php'; ?>
<div class='limiter'>     
<main role="main" >
<script type="text/javascript">
    $(document).ready(function() {
        

            
        // $("#add_data_select").selectpicker().change(function() {
        $('#add_data_select').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
            var id = $('#add_data_select').selectpicker('val');
            console.log(id);
            // $('#drn.ddr-a').trumbowyg(drn_t);  
            $.ajax({  
                    url:"./ajax/fetch.noper.php",  
                    method:"POST",  
                    data:{id:id},  
                    dataType:"json",  
                    success:function(data){  
                        $('#property').val(data.property);  
                        $('#sec').val(data.section);  
                        $('#twp').val(data.township);  
                        $('#rge').val(data.range);  
                        $('#county').val(data.county);  
                        $('#state').val(data.state);  
                        $('#location').val(data.location);
                        $('#company').val(data['sog-sdc-gec']);    
                        $('#interest').val(data.interest_type);  
                        $('#wp_id').val(data.wp_id);  
                        $('#ep_id').val(data.energy_id);  
                        $('#acct_type').val(data.accounting); 
                        $('#operator').val(data.operator);
                        $('#joa').val(data.joa_in_land_file);  
                        $('#pref_right').val(data.preferential_right);  
                        $('#wp_status').val(data.wolfpack_status); 

                        $('#well_status').val(data.well_status); 
                        $('#asof').val(data['sold-pa_eff_date']);
                        // $('#gas_ib').val(data.gas_imbalance);
                        if (data.gas_imbalance == 1){ $('#gas_ib').val("Yes"); }
                        if (data.gas_imbalance == 0){ $('#gas_ib').val("No"); }
                        $('#wi').val(data.gwi);
                        $('#ri').val(data.ri);
                        $('#nri').val(data.nri);
                        $('#orri').val(data.orri);

                        // $('#add_data_Modal').modal('show');  
                        
                        // $('#pills-eng-tab').removeClass("active");
                        // $('#pills-eng-tab').addClass("disabled not-allowed");

                        // $('#pills-acct-tab').addClass("active");
                        // $('#pills-acct-tab').removeClass("disabled not-allowed");

                        // $('#pills-vend-tab').removeClass("active");
                        // $('#pills-vend-tab').addClass("disabled not-allowed");

                        // $('#pills-field-tab').removeClass("active");
                        // $('#pills-field-tab').addClass("disabled not-allowed");

                        // $('#pills-eng').removeClass("in show active");
                        // $('#pills-acct').addClass("in show active");
                        // $('#pills-vend').removeClass("in show active");
                        // $('#pills-field').removeClass("in show active");
                        // $('.ddr-a').prop('disabled', false);
                        // $('.ddr-v').prop('disabled', true);
                        // $('.ddr-f').prop('disabled', true);
                        // $('.ddr-e').prop('disabled', true);
                        
                    }  
            });
        });
    });
</script>
<div class="carded m-3 ">
    <div class="row justify-content-center bg-light">
        <div class="p-3 col-10 " >
            <div class="m-3 p-3 shadow-lg carded-body bg-white">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><h5>Enter well name:</h5></span>
                    </div>
                    <!-- <select class="form-control">
                    <option>1</option>
                    </select> -->
                    <select id="add_data_select" class="ddr selectpicker form-control" data-live-search="true" data-width="auto" data-size="5" name="api" size="1" title="Select Well..." data-style="btn-primary btn-lg">
                    <!-- <option>Select Well:</option> -->
                    <?php
                        $entop = '"test"';
                        $table = "`T-PROPERTIES`";
                        $sql = "SELECT Property FROM $table";// ORDER BY well_lease ASC";
                        $result = mysqli_query($mysqli,$sql) or die(mysql_error());
                            //console_log($result);
                        ?>
                        <!-- <option>Select Well:</option> -->
                        <?php 
                        while ($row = mysqli_fetch_array($result)) {
                            // $wellname = $row['well_lease'] . "# " . $row['well_no']; 
                            $wellname = $row['Property'];
                            // $conditional = ($row['api'] == $apino) ?  '"' . $row['api'] . '" selected' :  '"' . $row['property'] . '"';
                            $conditional = '"' . $row['Property'] . '"';
                            
                            ?>
                        <option name="api" id="<?php echo $row['Property']; ?>" class="well" value=<?php echo $conditional;  ?> data-token=<?php echo $conditional;  ?>><?php echo $wellname; //$row['api']; // . $row['well_no'];?></option> 
                    <?php } ?>
                    </select> 
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center bg-light">
        <div class="container carded-body m-3 p-3 pr-5 shadow-lg col-3 bg-white" style="box-shadow: 0 .5rem 1rem rgba(0,0,0,.175)!important;">
            <div class="row mx-auto">
                <div class="col">
                    <div class="input-group input-group-sm m-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Property:</span>
                        </div>
                        <input type="text" class="form-control" id="property">
                        
                    </div>
                    
                </div>
                <div class="w-100"></div>

                <div class="col">
                    <div class="input-group input-group-sm m-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Sec:</span>
                        </div>
                        <input type="text" class="form-control" id="sec">
                        <div class="input-group-prepend ml-3">
                            <span class="input-group-text">Twp:</span>
                        </div>
                        <input type="text" class="form-control" id="twp">
                        <div class="input-group-prepend ml-3">
                            <span class="input-group-text">Rge:</span>
                        </div>
                        <input type="text" class="form-control" id="rge">
                    </div>
                    
                </div>
                <div class="w-100"></div>

                <div class="col">
                    <div class="input-group input-group-sm m-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">County:</span>
                        </div>
                        <input type="text" class="form-control" id="county">
                        <div class="input-group-prepend ml-5">
                            <span class="input-group-text">State:</span>
                        </div>
                        <input type="text" class="form-control" id="state">
                        
                    </div>
                </div>
                <div class="w-100"></div>

                <div class="col">
                    <div class="input-group input-group-sm m-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Location:</span>
                        </div>
                        <input type="text" class="form-control" id="location">
                    </div>
                </div>
            </div>
        </div>
        <div class="container carded-body m-3 p-3 pr-5 shadow-lg col-2 bg-white" style="box-shadow: 0 .5rem 1rem rgba(0,0,0,.175)!important;">
            <div class="row mx-auto">
                <div class="col">
                    <div class="form-group">
                        <label for="company">Company:</label>
                        <select id="company" class="form-control">
                            <option></option>
                            <option val="SOG">SOG</option>
                            <option val="SDC">SDC</option>
                            <option val="GEC">GEC</option>
                            <option val="SOG/SDC">SOG/SDC</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mx-auto">
                <div class="col">
                    <div class="form-group">
                        <label for="interest">Interest Type:</label>
                        <select id="interest" class="form-control">
                            <option></option>
                            <option val="WI">WI</option>
                            <option val="RI">RI</option>
                            <option val="ORRI">ORRI</option>
                            <option val="BIAPO-WI">BIAPO-WI</option>
                            <option val="CONVERTIBLE ORRI">CONVERTIBLE ORRI</option>
                            <option val="WI-WBO">WI-WBO</option>
                            <option val="Multiple Interests">Multiple Interests</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="container carded-body m-3 p-3 pr-5 shadow-lg col-4 bg-white" style="box-shadow: 0 .5rem 1rem rgba(0,0,0,.175)!important;">
            <div class="row mx-auto">
                <div class="col">
                    <div class="form-group">
                        <label for="wp_id">WolfePak ID:</label>
                        <input type="text" class="form-control" id="wp_id">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="ep_id">Energy Plus ID:</label>
                        <input type="text" class="form-control" id="ep_id">
                    </div>
                </div>
            </div>
            <div class="row mx-auto">
                <div class="col">
                    <div class="form-group">
                        <label for="acct_type">Accounting Type:</label>
                        <select id="acct_type" class="form-control">
                            <option val="OPERATED">OPERATED</option>
                            <option val="NONOPERATED">NONOPERATED</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center bg-light">
        <div class="container carded-body m-3 p-3 pr-5 shadow-lg col-5 bg-white" style="box-shadow: 0 .5rem 1rem rgba(0,0,0,.175)!important;">
            
            <div class="row mx-auto">
                <div class="input-group input-group-sm m-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Current Operator:</span>
                    </div>
                    <input type="text" class="form-control" id="operator">
                </div>
                
            </div>
            <div class="row mx-auto">
                <div class="justify-content-center">
                    <button class="btn btn-primary btn-primary-sm">View Operator Information</button>
                </div>
            </div>
<!-- THIS BUTTON SHOULD BRING UP A MODAL WITH THE OPERATOR INFORMATION -->
<!-- Operator information is located in the operator-vendor table & Access Form F-OPERATOR INFO LINK -->
            <hr>
            <div class="row mx-auto">
                <div class="input-group input-group-sm m-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">JOA in Land File:</span>
                    </div>
                    <select id="joa" class="form-control">
                        <option></option>
                        <option val="0">No</option>
                        <option val="1">Yes</option>
                    </select>
                    <div class="input-group-prepend ml-5">
                        <span class="input-group-text">Preferential Right:</span>
                    </div>
                    <select id="pref_right" class="form-control">
                        <option></option>
                        <option val="0">No</option>
                        <option val="1">Yes</option>
                    </select>
                    
                </div>
            </div>
            <div class="row mx-auto">
                <div class="justify-content-center m-3">
                    <button class="btn btn-primary btn-primary-sm">View Property Comments</button>
<!-- THIS BUTTON SHOULD BRING UP A MODAL WITH THE PROPERTY COMMENTS AND ABILITY TO ADD NEW/EDIT THEM  -->
<!-- property comments are located in the status_comments table & Access Form F-STATUS COMMENTS VIEW -->
                    <button class="btn btn-primary btn-primary-sm ml-5">View Property History</button>
<!-- THIS BUTTON SHOULD BRING UP A MODAL WITH THE PROPERTY HISTORY INFORMATION -->
<!-- Property history is located in the property_history table & Access Form F-PROPERTY HISTORY VIEW -->
                </div>
            </div>
            <div class="row mx-auto">
                <div class="justify-content-center m-3">
                    <button class="btn btn-primary btn-primary-sm">Print all comments for File</button>
<!-- THIS BUTTON SHOULD BRING UP A MODAL WITH THE PROPERTY COMMENTS AND THEN THE PRINT DIALOG -->
                </div>
            </div>
            <div class="row mx-auto">
                <div class="justify-content-center m-3">
                    <button class="btn btn-primary btn-primary-sm">Print this page/record</button>
<!-- THIS BUTTON SHOULD BRING UP THE PRINT DIALOG -->
                </div>
            </div>
                
            
        </div>
    
        <div class="container carded-body m-3 p-3 pr-5 shadow-lg col-5 bg-white" style="box-shadow: 0 .5rem 1rem rgba(0,0,0,.175)!important;">
            <div class="row">
                <h6 class="mx-auto">Status Info</h6>
            </div>
           <hr>
            <div class="row mx-auto">
                <div class="col">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">WolfePak Status:</span>
                        </div>
                        <select id="wp_status" class="form-control">
                        <option></option>
                        <option val="Active">Active</option>
                        <option val="Dormant">Dormant</option>
                        <option val="Extinct">Extinct</option>
                        <option val="Unknown">Unknown</option>
                    
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">WI:</span>
                        </div>
                        <input type="text" class="form-control" id="wi">
                    </div>
                </div>
                <div class="w-100"></div>
                <div class="col">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Well Status:</span>
                        </div>
                        <select id="well_status" class="form-control">
                        <option></option>
                        <option val="P/A">P/A</option>
                        <option val="Shut-in">Shut-in</option>
                        <option val="Producing">Producing</option>
                        <option val="Sold">Sold</option>
                        <option val="Sold-WBO">Sold-WBO</option>
                        <option val="Other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                                <span class="input-group-text">RI:</span>
                            </div>
                            <input type="text" class="form-control" id="ri">
                        </div>
                    </div>
                <!-- </div> -->
                <div class="w-100"></div>
                <div class="col">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">As of:</span>
                        </div>
                        <input type="text" class="form-control" id="asof">
                    </div>
                </div>
                <div class="col">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                                <span class="input-group-text">NRI:</span>
                        </div>
                        <input type="text" id="nri" class="form-control">
                    </div>
                    
                </div>
                <div class="w-100"></div>
                <div class="col">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Gas Imbalance:</span>
                        </div>
                        <select class="form-control" id="gas_ib">
                            <option></option>
                            <option val="0">No</option>
                            <option val="1">Yes</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">ORRI:</span>
                        </div>
                        <input type="text" class="form-control" id="orri">
                    </div>
                    
                </div>
                
            </div>
            
            <div class="row mx-auto">
                <div class="justify-content-center m-3">
                    <button class="btn btn-primary btn-primary-sm">View GB Information</button>
<!-- THIS BUTTON SHOULD BRING UP A MODAL WITH THE GAS BALANCE INFORMATION -->
<!-- gas balance info is located in the gb_comments table & Access Form F-GAS IMBALANCE VIEW -->
                    <button class="btn btn-primary btn-primary-sm ml-5">GB Statement Info</button>
<!-- THIS BUTTON SHOULD BRING UP A MODAL WITH THE GAS BALANCE STATEMENT INFO -->
<!-- gas balance is located in the gas_imbalance_input table (except for the GB Stment Interest Reflected input) & Access Query Q-GB MCF INFO -->
<!-- Fields for view are -->
<!-- Prod Mnth | Entitlement | Sales | Current Month Imbalance | Cumulative Imbalance | GB Stment Interest Reflected  -->
<!-- Values for view are -->
<!-- Production Month | Entitlement | Sales Mcf | Current Month Imbalance | Cumulative Imbalance | Settlement Mcf  -->
                    <button class="btn btn-primary btn-primary-sm ml-5">View Purchaser Info</button>
<!-- THIS BUTTON SHOULD BRING UP A MODAL WITH THE PURCHASER INFO -->
<!-- purchaser info is located in the ?? table & Access Form F-WI/NRI INFORMATION SUBFORM -->
                </div>
            </div>
           
            
            
            
                
            
        </div>
    </div>
</div>

</main>
</div>
</body>

<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
          <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
<!-- <script type="text/javascript" src="WSB/dashboard/bootstrap.min.js.download"></script> -->

<!-- Icons -->
<!-- <script type="text/javascript" src="../WSB/dashboard/feather.min.js.download"></script> -->
<!-- <script>
    feather.replace()
    const cumprod = document.getElementById('cumulativeproduction');
    tippy('.r-tooltip', { 
          content: cumprod.innerHTML,
          allowHTML: true,
          placement: 'right',
          arrow: false 
        });
</script>    -->
<!-- <script type="text/javascript" src="WSB/stylesheet/holder.min.js.download"></script> -->
<!-- <script type="text/javascript" src="WSB/stylesheet/offcanvas.js.download"></script> -->


	</html>
