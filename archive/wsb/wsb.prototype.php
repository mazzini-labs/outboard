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
// include 'WSB/includes.php';
include 'include/wsbFunctions.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = connect_db();
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
    <title>WSB</title>
    <?php include 'dependencies.php'; ?>
    <!-- <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>

	<link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/maintest.css?=v1.0.0.0">
    <link rel="stylesheet" type="text/css" href="css/tabs.css?v=1.0.0.0">
    <link rel="stylesheet" type="text/css" href="css/search.css">
	<link href="WSB/stylesheet/offcanvas.css?v=1.0.0.4" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/dt-1.10.21/af-2.3.5/b-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/dt-1.10.21/af-2.3.5/b-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.js"></script> -->
    <script type="text/javascript" class="init">
        // $.noConflict();
        $(function(){
            var click1 = 1;
            var click2 = 0;
            var click3 = 0;
            var click4 = 0;
            var oTable;
            var iTable;
            var sTable;
            $(document).ready(function() {
                 $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
                         $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
                     } );

                if(click1 < 2){
                    click1++;
                
                    oTable = $('#productionTable').DataTable( {
                        "ajax": "./ajax/wsb.ajax.php",
                        "sDom": 't',
                        //"sDom": 'd',
                        "order": [],
                        //"paging": false,
                        //"info": false,
                        "keys": true,
                        // deferRender: true,
                        scrollY: 800,
                        // "scrollX": false,
                        scroller: true,
                        "searching": true,
                        //
                        // "autoWidth": false, 
                        
                        "columns": [
                            {
                                // Combine the Well and API into a single table field
                                // 181px
                                "data": null, render: function ( data, type, row ) 
                                    {
                                        
                                        return '<a href="prod_data.php?api='+data.api+'">'+data.entity_common_name+' <br> '+data.api+'</a>';
                                    }, 
                                "defaultContent": ""
                            },
                            {
                                // State
                                // 14px
                                "data": "state", 
                                "defaultContent": ""
                            },
                            {
                                // County
                                // 69px
                                "data": "county_parish", 
                                "defaultContent": "",
                            },
                            {
                                // Block
                                // 85px
                                "data": "block", 
                                "defaultContent": "",
                            },
                            {
                                // 33
                                "data": "entity_operator_code", // Entity (Company)
                                "defaultContent": "",
                            },
                            {
                                // 39
                                "data": "producing_status", // Production Status
                                "defaultContent": "",
                            },
                            {
                                // 27
                                "data": "production_type", // Production Type
                                "defaultContent": "",
                            },
                            {
                                // 44
                                "data": "last_prod_date", // Last Active
                                /* render: function ( data, type, row ) 
                                {
                                    var dateSplit = data.split('-');
                                    return type === "display" || type === "filter" ?
                                        dateSplit[1] +'-'+ dateSplit[2] +'-'+ dateSplit[0] :
                                        data;
                                }, */
                                "defaultContent": "",
                            },
                            {
                                // 56
                                "data": "gas_sold", // Gas (mcf)
                                "defaultContent": "",
                                render: $.fn.dataTable.render.number( ',', '.', 0, '', '<small> mcf</small>' )
                            },
                            {
                                // 48
                                "data": "oil_prod", // Oil (bbl)
                                "defaultContent": "",
                                render: $.fn.dataTable.render.number( ',', '.', 0, '', '<small> bbl</small>' )
                            },
                            {
                                // 54
                                "data": "water_prod", // Water (bbl)
                                "defaultContent": "",
                                render: $.fn.dataTable.render.number( ',', '.', 0, '', '<small> bbl</small>' )
                            },
                            {
                                // 56
                                "data": "gas_line_loss", // Gas Line Loss (mcf)
                                "defaultContent": "",
                                render: $.fn.dataTable.render.number( ',', '.', 0, '', '<small> mcf</small>' )
                            },
                            {
                                // 74
                                "data": "pumper", // Pumper
                                "defaultContent": "",
                            },
                            {
                                    "data": null, render: function (data, type, row) 
                                    {
                                        return "<div class='text-wrap width-200'>" + data.notes + "</div>";
                                    },
                                    "defaultContent": "",
                            },
                            {
                                // 91
                                "data": "notes_update", // Last Updated
                                /* render: function ( data, type, row ) 
                                {
                                    var dateSplit = data.split('-');
                                    return type === "display" || type === "filter" ?
                                        dateSplit[1] +'-'+ dateSplit[2] +'-'+ dateSplit[0] :
                                        data;
                                }, */
                                "defaultContent": "",
                            },
                        ],
                        "columnDefs": [
                            { className: "text-wrap", "targets":  13  },
                            { width: "1%", "targets": 1 },
                            { width: "3%", "targets": [4, 6] },
                            { width: "4%", "targets": [5, 7, 9, 14] },
                            { width: "5%", "targets": [8, 10, 11] },
                            { width: "6%", "targets": 2 },
                            { width: "7%", "targets": 12 },
                            { width: "8%", "targets": [3] },
                            { width: "17%", "targets": 0 },
                            // {
                            //     render: function (data, type, full, meta) {
                                    
                            //         if ( data[5] == 'Shut-in' || data[5] =='Shut-In' || data[5]  == 'INACTIVE' )
                            //         {
                            //             return "<div class='text-wrap width-200 highlight'>" + data + "</div>";
                            //         }
                            //         else
                            //         {return "<div class='text-wrap width-200'>" + data + "</div>";}
                            //     },
                            //     targets: 13
                            // },

                            {
                                targets: 5,
                                "createdCell": function (td, cellData, rowData, row, col) {
                                    {
                                        var checkSI = oTable.cell(td,5).data(); 
                                        if ( checkSI == 'Shut-in' || checkSI == 'Shut-In' || checkSI  == 'INACTIVE' ) 
                                        {
                                            $(td).css('background-color', '#F08080')
                                        }
                                        else if (checkSI == 'INJ' || checkSI == 'Injector' || checkSI == 'SWD')
                                        {
                                            $(td).css('background-color', '#8080F0')
                                        }
                                    }
                                },
                                
                            },

                            {
                                targets: 13,
                                "createdCell": function (td, cellData, rowData, row, col) {
                                    {
                                        var checkSI = oTable.cell(td,5).data(); 
                                        if ( checkSI == 'Shut-in' || checkSI == 'Shut-In' || checkSI  == 'INACTIVE' ) 
                                        {
                                            $(td).css('font-weight', 'bold')
                                        }
                                    }
                                },

                            }
                            
                        ],
                        // "rowCallback": function( row, data, index ) 
                        //     {
                        //         switch(data.notes)
                        //         {   
                        //             default:
                        //                 $('td', row).addClass('text-wrap');
                        //                 $('td:eq(13)', row).addClass('width-200');    
                        //         }
                        //     }
                                
                    } );
                };
            } );
            
            $('#daily-tab').click(function(){
                if(click2 < 1){
                    click2++;
                    iTable = $('#productionTable1').DataTable( {
                            "ajax": "./ajax/wsb.ajax.php",
                            "sDom": 't',
                            "order": [],
                            "keys": true,
                            deferRender: true,
                            scrollY: 800,
                            scroller: true,
                            "searching": true,
                            "autoWidth": false, 
                            "columns": [
                                {
                                "data": null, render: function ( data, type, row ) {
                                    // Combine the Well and API into a single table field
                                    return '<a href="prod_data.php?api='+data.api+'">'+data.entity_common_name+' <br> '+data.api+'</a>';
                                }, 
                                "defaultContent": ""
                                },
                                {
                                "data": "state", // State
                                "defaultContent": ""
                                },
                                {
                                "data": "county_parish", // County
                                "defaultContent": "",
                                },
                                {
                                "data": "block", // Block
                                "defaultContent": "",
                                },
                                {
                                "data": "entity_operator_code", // Entity (Company)
                                "defaultContent": "",
                                },
                                {
                                    "data": "producing_status", // Production Status
                                    "defaultContent": "",
                                    },
                                {
                                    "data": "production_type", // Production Type
                                    "defaultContent": "",
                                },
                                {
                                    "data": "last_prod_date", // Last Active
                                    /* render: function ( data, type, row ) 
                                    {
                                        var dateSplit = data.split('-');
                                        return type === "display" || type === "filter" ?
                                            dateSplit[1] +'-'+ dateSplit[2] +'-'+ dateSplit[0] :
                                            data;
                                    }, */
                                    "defaultContent": "",
                                },
                                {
                                // Gas (mcf)
                                "data": "gas_sold",
                                data: null,
                                render: function ( data, type, row ) {
                                    var check = data.gas_sold / data.days_on;

                                    if(check == check)
                                    {
                                        return ( data.gas_sold / data.days_on ).toFixed(2)+' <sup>mcf</sup>/<sub>day</sub>';
                                    }
                                    else
                                    {
                                        return data.gas_sold+' <sup>mcf</sup>/<sub>day</sub>';
                                    }
                                },
                                },
                                {
                                "data": "oil_prod", // Oil (bbl)
                                data: null,
                                render: function ( data, type, row ) {
                                    var check = data.oil_prod / data.days_on;

                                    if(check == check)
                                    {
                                        return ( data.oil_prod / data.days_on ).toFixed(2)+' <sup>bbl</sup>/<sub>day</sub>';
                                    }
                                    else
                                    {
                                        return data.oil_prod+' <sup>bbl</sup>/<sub>day</sub>';
                                    }
                                }},
                                {
                                "data": "water_prod", // Water (bbl)
                                "defaultContent": "",
                                data: null,
                                render: function ( data, type, row ) {
                                    var check = data.water_prod / data.days_on;

                                    if(check == check)
                                    {
                                        return ( data.water_prod / data.days_on ).toFixed(2)+' <sup>bb;</sup>/<sub>day</sub>';
                                    }
                                    else
                                    {
                                        return data.water_prod+' <sup>bbl</sup>/<sub>day</sub>';
                                    }
                                }},
                                {
                                "data": "gas_line_loss", // Gas Line Loss (mcf)
                                "defaultContent": "",
                                data: null,
                                render: function ( data, type, row ) {
                                    var check = data.gas_line_loss / data.days_on;

                                    if(check == check)
                                    {
                                        return ( data.gas_line_loss / data.days_on ).toFixed(2)+' <sup>mcf</sup>/<sub>day</sub>';
                                    }
                                    else
                                    {
                                        return data.gas_line_loss+' <sup>mcf</sup>/<sub>day</sub>';
                                    }
                                }},
                                {
                                    "data": "pumper", // Pumper
                                    "defaultContent": "",
                                },
                                {
                                    "data": null, render: function (data, type, row) 
                                    {
                                        return "<div class='text-wrap width-200'>" + data.notes + "</div>";
                                    },
                                    "defaultContent": "",
                                },
                                {
                                "data": "notes_update", // Last Updated
                                /* render: function ( data, type, row ) {
                                var dateSplit = data.split('-');
                                return type === "display" || type === "filter" ?
                                    dateSplit[1] +'-'+ dateSplit[2] +'-'+ dateSplit[0] :
                                    data;
                                }, */
                                "defaultContent": "",
                                },
                            ],
                        "columnDefs": [
                            { className: "text-wrap", "targets":  13  },
                            { width: "1%", "targets": 1 },
                            { width: "3%", "targets": [4, 6] },
                            { width: "4%", "targets": [5, 7, 9, 14] },
                            { width: "5%", "targets": [8, 10, 11] },
                            { width: "6%", "targets": 2 },
                            { width: "7%", "targets": 12 },
                            { width: "8%", "targets": [3] },
                            { width: "17%", "targets": 0 },
                            // {
                            //     render: function (data, type, full, meta) {
                                    
                            //         if ( data[5] == 'Shut-in' || data[5] =='Shut-In' || data[5]  == 'INACTIVE' )
                            //         {
                            //             return "<div class='text-wrap width-200 highlight'>" + data + "</div>";
                            //         }
                            //         else
                            //         {return "<div class='text-wrap width-200'>" + data + "</div>";}
                            //     },
                            //     targets: 13
                            // },

                            {
                                targets: 5,
                                "createdCell": function (td, cellData, rowData, row, col) {
                                    {
                                        var checkSI = iTable.cell(td,5).data(); 
                                        if ( checkSI == 'Shut-in' || checkSI == 'Shut-In' || checkSI  == 'INACTIVE' ) 
                                        {
                                            $(td).css('background-color', '#F08080')
                                        }
                                        else if (checkSI == 'INJ' || checkSI == 'Injector' || checkSI == 'SWD')
                                        {
                                            $(td).css('background-color', '#8080F0')
                                        }
                                    }
                                },
                                
                            },

                            {
                                targets: 13,
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
                        ]
                        } );
                 };
            } );
            $('#shutin-tab').click(function(){
                if(click3 < 1){
                    click3++;
                    sTable = $('#shutinTable').DataTable( {
                        "ajax": "ajax/si.ajax.php",
                        "sDom": 't',
                        //"sDom": 'd',
                        "order": [],
                        //"paging": false,
                        "info": true,
                        "keys": true,
                        deferRender: true,
                        scrollY: 800,
                        scroller: true,
                        "searching": true,
                        //
                        "autoWidth": false,
                        "columns": [
                            {
                            "data": null, render: function ( data, type, row ) 
                            {
                                // Combine the Well and API into a single table field
                                return '<a href="prod_data.php?api='+data.api+'">'+data.entity_common_name+' <br> '+data.api+'</a>';
                            }, 
                            "defaultContent": ""
                            },
                            {
                            "data": "state", // State
                            "defaultContent": ""
                            },
                            {
                            "data": "county_parish", // County
                            "defaultContent": "",
                            },
                            {
                            "data": "block", // Block
                            "defaultContent": "",
                            },
                            {
                            "data": "entity_operator_code", // Entity (Company)
                            "defaultContent": "",
                            },
                            {
                            "data": "si_notes", // Notes
                            "defaultContent": "",
                            },
                            {
                            "data": "notes_update", // Last Updated
                            // render: function ( data, type, row ) {
                            // var dateSplit = data.split('-');
                            // return type === "display" || type === "filter" ?
                            //     dateSplit[1] +'-'+ dateSplit[2] +'-'+ dateSplit[0] :
                            //     data;
                            // },
                            "defaultContent": "",
                            },
                        ],
                        "columnDefs": [
                            { className: "text-wrap", "targets":  5  },
                            { width: "1%", "targets": 1 },
                            { width: "3%", "targets": 4 },
                            { width: "6%", "targets": 2 },
                            { width: "8%", "targets": [3, 6] },
                            { width: "17%", "targets": 0 },
                            {
                                render: function (data, type, full, meta) {
                                    return "<div class='text-wrap width-200'>" + data + "</div>";
                                },
                                targets: 5
                            }
                        ]
                                
                        } );
            }
            } );
                 
            $('#print-tab').click(function(){
                if(click4 < 1){
                    click4++;
                    $.fn.dataTable.ext.buttons.reload = {
                        extend: 'print',
                        text: 'Reload',
                        extend: 'print',
                        autoPrint: false,
                        exportOptions: {
                            stripHtml: false,
                            format: {
                                body: function ( inner, coldex, rowdex ) {
                                    if (inner.length <= 0) return inner;
                                    var el = $.parseHTML(inner);
                                    var result='';
                                    $.each( el, function (index, item) {
                                        if (item.nodeName == '#text') result = result + item.textContent;
                                        else if (item.nodeName == 'SUP') result = result + item.outerHTML;
                                        else if (item.nodeName == 'STRONG') result = result + item.outerHTML;
                                        else if (item.nodeName == 'IMG') result = result + item.outerHTML;
                                        else result = result + item.innerText;
                                    });
                                    return result;
                                }
                            }
                        },
                        action: function ( e, dt, node, config ) {
                            pTable.page.len( -1 ).draw();
                            pTable.on( 'draw', function () {
                                $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, node, config);
                            } );
                        }
                    };
                    pTable = $('#printTable').DataTable( {
                            "ajax": "./ajax/wsb.ajax.php",
                            "sDom": 'Btp',
                            "order": [],
                            
                            // deferRender: true,
                            // scrollY: 800,
                            // scrollCollapse: false,
                            // paging: true,
                            // scroller: true,
                            "searching": false,
                            "autoWidth": false, 
                            "buttons": [
                                'reload',
                                {
                                    extend: 'print',
                                    autoPrint: false,
                                    exportOptions: {
                                        stripHtml: false,
                                        format: {
                                            body: function ( inner, coldex, rowdex ) {
                                                if (inner.length <= 0) return inner;
                                                var el = $.parseHTML(inner);
                                                var result='';
                                                $.each( el, function (index, item) {
                                                    if (item.nodeName == '#text') result = result + item.textContent;
                                                    else if (item.nodeName == 'SUP') result = result + item.outerHTML;
                                                    else if (item.nodeName == 'STRONG') result = result + item.outerHTML;
                                                    else if (item.nodeName == 'IMG') result = result + item.outerHTML;
                                                    else result = result + item.innerText;
                                                });
                                                return result;
                                            }
                                        }
                                    }
                                },
                            ],
                            "columns": [
                                {
                                    "data": "entity_common_name",
                                    "defaultContent": ""
                                },
                                {
                                    "data": "pumper", // Pumper
                                    "defaultContent": "",
                                },
                                {
                                    // "data": "producing_status", // Production Status
                                    "data": null, render: function ( data, type, row ) 
                                    {
                                        if (data.producing_status == 'SWD'){
                                            return 'SWD';
                                        }
                                        else if (data.producing_status == 'SI' || data.producing_status == 'Shut-in' || data.producing_status == 'Shut-In' || data.producing_status  == 'INACTIVE')
                                        {
                                            return "SI "+data.last_prod_date;
                                        }
                                        else 
                                        {
                                            var result = '';
                                            var checkO = data.oil_prod / data.days_on;
                                            var checkW = data.water_prod / data.days_on;
                                            var checkG = data.gas_sold / data.days_on;
                                            var checkOil = checkO.toFixed(2);
                                            var checkWater = checkW.toFixed(2);
                                            var checkGas = checkG.toFixed(2);
                                            if (checkO == checkO && checkO >= 1) result = result + checkOil + " bopd "
                                            if (checkG == checkG && checkG >= 1) result = result + checkGas + " mcfpd "
                                            if (checkW == checkW && checkW >= 1) result = result + checkWater + " bwpd "
                                            return result;
                                        }
                                        
                                        
                                    }, 
                                    "defaultContent": "",
                                    },
                                {
                                    "data": null, render: function (data, type, row) 
                                    {
                                        return "<div class='text-wrap width-200'>" + data.notes + "</div>";
                                    },
                                    "defaultContent": "",
                                },
                                {
                                "data": "notes_update", // Last Updated
                                /* render: function ( data, type, row ) {
                                var dateSplit = data.split('-');
                                return type === "display" || type === "filter" ?
                                    dateSplit[1] +'-'+ dateSplit[2] +'-'+ dateSplit[0] :
                                    data;
                                }, */
                                "defaultContent": "",
                                },
                            ],
                        "columnDefs": [
                            { className: "text-wrap", "targets":  3  },
                            // { width: "1%", "targets": 1 },
                            // { width: "3%", "targets": [4, 6] },
                            // { width: "4%", "targets": [5, 7, 9, 14] },
                            // { width: "5%", "targets": [8, 10, 11] },
                            // { width: "6%", "targets": 2 },
                            // { width: "7%", "targets": 12 },
                            // { width: "8%", "targets": [3] },
                            // { width: "17%", "targets": 0 },

                            {
                                targets: 2,
                                "createdCell": function (td, cellData, rowData, row, col) {
                                    {
                                        var checkSI = pTable.cell(td,2).data(); 
                                        if ( checkSI == 'Shut-in' || checkSI == 'Shut-In' || checkSI  == 'INACTIVE' ) 
                                        {
                                            $(td).css('background-color', '#F08080')
                                        }
                                    }
                                },
                                
                            },

                            {
                                targets: 3,
                                "createdCell": function (td, cellData, rowData, row, col) {
                                    {
                                        var checkSI = pTable.cell(td,2).data(); 
                                        if ( checkSI == 'Shut-in' || checkSI == 'Shut-In' || checkSI  == 'INACTIVE' ) 
                                        {
                                            $(td).css('font-weight', 'bold')
                                        }
                                    }
                                },

                            }                            
                        ]
                        } );
                 };
            } );


            $('#searchProduction').keyup(function(){
                oTable.search($(this).val()).draw() ;
                iTable.search($(this).val()).draw() ;
                sTable.search($(this).val()).draw() ;
            })
            //$('#productionTable_filter').DataTable.search();
            $("#searchProduction").keypress(function(e) {
                    //Enter key
                    if (e.which == 13) {
                        return false;
                    }
            });
            // DDR ENTRY MODAL JS
            // Not able to get it to work from a js file yet
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
        
    </script>
</head>

<style>

.smol th,
.smol td,
.smol a,
.smol p {
  padding-top: 0.3rem;
  padding-bottom: 0.3rem;
  font-size: 12px;
}
table.dataTable tbody td {
  word-break: break-word;
  vertical-align: top;
}
.text-wrap{
    white-space:normal;
}
.shutin {background-color: #F08080;}
td.highlight { font-weight: bold; }
.lg-icon {
                width: 1.625rem;
                height: 1.625rem;
                vertical-align: -webkit-baseline-middle;

            }
</style>
<body class="bg-light">
    <?php 
        // echo $num= 7 + 1 + 4 + 2 + 2 + 2 + 2 + 2 + (1.5 * 6) + 2 + 2 + 14 + 3;
        
        include 'header_extensions.php';
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
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="print-tab" data-toggle="tab" href="#print" role="tab" aria-controls="print" aria-selected="false">Print Prod. Review Meeting Notes</a>
                </li>
            </ul> 
            </nav>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="monthly-tab" style="position: relative; z-index: 1040;"> 
                    <table id="productionTable" class='table table-striped table-borderless smol display' style="margin-top: 0px !important;" >
                        <thead class="bg-sog">
                            
                                <th >Well</th>
                                <th >ST</th>
                                <th >County</a></th>
                                <th >Block</a></th>
                                <th >Entity</a></th>
                                <th >Status</a></th>
                                <th >Prod</a></th>
                                <th >Active</a></th>
                                
                                <th >Gas</th>
                                <th >Oil</th>
                                <th >Water</th>
                                
                                <th >Loss</a></th>
                                <th >Pumper</a></th>
                                <th >Notes</th>
                                <th >Updated</a></th>
                            
                        </thead>
                    </table>
                </div>
                <div class="tab-pane fade " id="profile" role="tabpanel" aria-labelledby="daily-tab" style="position: relative; z-index: 1040;">
                    <table id="productionTable1" class='table table-striped table-borderless datatable-tab-correct datatable-tab-correct1 smol' style="margin-top: 0px !important;" >
                        <thead class="bg-sog">
                                <th >Well</th>
                                <th >ST</th>
                                <th >County</a></th>
                                <th >Block</a></th>
                                <th >Entity</a></th>
                                <th >Status</a></th>
                                <th >Prod</a></th>
                                <th >Active</a></th>
                                
                                <th >Gas</th>
                                <th >Oil</th>
                                <th >Water</th>
                                
                                <th >Loss</a></th>
                                <th >Pumper</a></th>
                                <th >Notes</th>
                                <th >Last Updated</a></th>
                        </thead>
                        <!-- <?php 
                        /*     $conn = connect_db();
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
                                
                                echo "<td $width2><small>". truncate($lineloss) ." mcf</small></td>\n";
                                echo "<td $width2><small>$pumper</small></td >\n";
                                echo "<td $width14><small>$boldTagStart $notes $boldTagEnd</small> </td >\n";
                                echo "<td $width3><small>$last_updated</small></td >\n";
                                echo "</tr>\n"; 

                                
                                
                            }
                            echo "</tbody>\n";
                             */
                            ?> -->
                    
                    </table>
                </div>
                <div class="tab-pane fade " id="shutin" role="tabpanel" aria-labelledby="shutin-tab" style="position: relative; z-index: 1040;">
                    <table id="shutinTable" class='table table-striped table-borderless datatable-tab-correct datatable-tab-correct1 smol' style="margin-top: 0px !important;" >
                        <thead class="bg-sog">
                                <th >Well</th>
                                <th >ST</th>
                                <th >County</a></th>
                                <th >Block</a></th>
                                <th >Entity</a></th>
                                <th >Shut-In Notes</th>
                                <th >Last Updated</th>
                        </thead>
                    </table>
                </div>
                <div class="tab-pane fade " id="print" role="tabpanel" aria-labelledby="print-tab" style="position: relative; z-index: 1040;">
                    <table id="printTable" class='table table-striped table-borderless datatable-tab-correct datatable-tab-correct1 smol' style="margin-top: 0px !important;" >
                        <thead class="bg-sog">
                                <th >Well</th><th >Pumper</th><th >Status/Production</th> <th >Notes</th><th >Last Updated</th>
                                
                               
                        </thead>
                    </table>
                </div>
            </div>
        <!-- </nav> -->
    <!-- </div> -->
	</main>
</div>

<?php include 'floating_action_button.php'; ?>
<?php include 'ddr_add_modal.php'; ?>

</body>
<!-- <script src="WSB/dashboard/popper.min.js.download"></script> -->
<!-- <script src="WSB/dashboard/bootstrap.min.js.download"></script> -->

<!-- Icons -->
<!-- <script src="WSB/dashboard/feather.min.js.download"></script> -->

<script>
    feather.replace()

</script>   
<!-- <script src="WSB/stylesheet/holder.min.js.download"></script> -->
<!-- <script src="WSB/stylesheet/offcanvas.js.download"></script> -->
</html>


