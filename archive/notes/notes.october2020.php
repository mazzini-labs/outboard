<?php
// namespace Phppot;

// use Phppot\Model\FAQ;

include 'lib/ob.php';
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
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<link rel="stylesheet" type="text/css" href="css/util.css">
<link rel="stylesheet" type="text/css" href="css/maintest.css?=v1.2">
<link rel="stylesheet" type="text/css" href="css/search.css">
<link rel="stylesheet" type="text/css" href="css/tabs.css">
<!-- Bootstrap core CSS -->
<link href="./WSB/stylesheet/bootstrap.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="./WSB/stylesheet/offcanvas.css" rel="stylesheet">
<!-- <link href="./assets/CSS/style.css" type="text/css" rel="stylesheet" /> -->
<link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
<script type="text/javascript" src="datatables/datatables.min.js"></script>
<!-- <script src="./vendor/jquery/jquery-3.2.1.min.js"></script> -->
<script src="./assets/js/inlineEdit.1.js"></script>
    <?php include 'WSB/includes.php'; ?>
    <title>WSB</title>

    <script type="text/javascript" class="init">
    // $.noConflict();
    $(document).ready(function() {
        oTable = $('#productionTable').DataTable( {
            "ajax": {url:"ajax/notes.ajax.php",dataSrc:""},
            "sDom": 't',
            "order": [],
            scrollY: 850,
            // "paging": false,
            scroller: true,
            "searching": true,
            "keys": true,
            //
            // "autoWidth": false, 
            // "columns": [
            //     // {
            //     //     "data": "list_id",
            //     //     "defaultContent":""
            //     // },
            //     {
            //         // Combine the Well and API into a single table field
            //         // 181px
            //         "data": null, render: function ( data, type, row ) 
            //         {
            //             return "<td contenteditable=\"true\" onBlur=\"saveToDatabase(this,'entity_common_name',"+data.list_id+")\" onClick=\"showEdit(this);\">"+data.entity_common_name+"</td>"                                      
            //         }, 
            //         "defaultContent": ""
            //     },
            //     {
            //         // State
            //         // 14px
            //         "data": null, render: function ( data, type, row ) 
            //         {
            //             return "<div contenteditable=\"false\" onBlur=\"saveToDatabase(this,'state,"+data.list_id+")\" onClick=\"showEdit(this);\">"+data.state+"</div>"
            //         },
            //         "defaultContent": ""
            //     },
            //     {
            //         // County
            //         // 69px
            //         "data": null, render: function ( data, type, row ) {
            //             return "<div contenteditable=\"false\" onBlur=\"saveToDatabase(this,'county_parish',"+data.list_id+")\" onClick=\"showEdit(this);\">"+data.county_parish+"</div>"
            //         },
            //         "defaultContent": "",
            //     },
            //     {
            //         // Block
            //         // 85px
            //         "data": null, render: function ( data, type, row ) {
            //             return "<div contenteditable=\"true\" onBlur=\"saveToDatabase(this,'block',"+data.list_id+")\" onClick=\"showEdit(this);\">"+data.block+"</div>"
            //         },
            //         "defaultContent": "",
            //     },
            //     {
            //         // 33
            //         "data": null, render: function ( data, type, row ) {// Entity (Company)
            //             return "<div contenteditable=\"false\" onBlur=\"saveToDatabase(this,'entity_operator_code',"+data.list_id+")\" onClick=\"showEdit(this);\">"+data.entity_operator_code+"</div>"
            //         },
            //         "defaultContent": "",
            //     },
            //     {
            //         // 39
            //         "data": null, render: function ( data, type, row ) {// Production Status
            //             return "<div contenteditable=\"true\" onBlur=\"saveToDatabase(this,'producing_status',"+data.list_id+")\" onClick=\"showEdit(this);\">"+data.producing_status+"</div>"
            //         },
            //         "defaultContent": "",
            //     },
            //     {
            //         // 27
            //         "data": null, render: function ( data, type, row ) {// Production Type
            //             return "<div contenteditable=\"false\" onBlur=\"saveToDatabase(this,'production_type',"+data.list_id+")\" onClick=\"showEdit(this);\">"+data.production_type+"</div>"
            //         },
            //         "defaultContent": "",
            //     },
            //     {
            //         // 44
            //         "data": null, render: function ( data, type, row ) {// Last Active
            //         /* render: function ( data, type, row ) 
            //         {
            //             var dateSplit = data.split('-');
            //             return type === "display" || type === "filter" ?
            //                 dateSplit[1] +'-'+ dateSplit[2] +'-'+ dateSplit[0] :
            //                 data;
            //         }, */
            //             return "<div contenteditable=\"true\" onBlur=\"saveToDatabase(this,'last_prod_date',"+data.list_id+")\" onClick=\"showEdit(this);\">"+data.last_prod_date+"</div>"
            //             },
            //         "defaultContent": "",
            //     },
            //     {
            //         // 74
            //         "data": null, render: function ( data, type, row ) {// Pumper
            //             return "<div contenteditable=\"true\" onBlur=\"saveToDatabase(this,'pumper',"+data.list_id+")\" onClick=\"showEdit(this);\">"+data.pumper+"</div>"
            //             },
            //         "defaultContent": "",
            //     },
            //     {
            //         "data": null, render: function (data, type, row) 
            //         {
            //             return "<div contenteditable=\"true\" onBlur=\"saveToDatabase(this,'notes',"+data.list_id+")\" onClick=\"showEdit(this);\">"+data.notes+"</div>"

                        
            //         },
            //         "defaultContent": "",
            //     },
            //     {
            //         // 91
            //         "data": null, render: function (data, type, row) 
            //             {
            //                 return "<div class='text-wrap width-200' contenteditable=\"true\" onBlur=\"saveToDatabase(this,data.si_notes,"+data.list_id+")\" onClick=\"showEdit(this);\">"+ data.si_notes+"</div>"
            //             },
            //         "defaultContent": "",
                    
            //     },
            // ],
        
        "columns": [
            {
                "data": "api",
                "defaultContent": ""
            },
            {
            // "data": null, render: function ( data, type, row ) {
            //     // Combine the Well and API into a single table field
            //     return data.entity_common_name;
            // }, 
            "data": "entity_common_name",
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
                "defaultContent": "",
            },
            {
                "data": "pumper", // Pumper
                "defaultContent": "",
            },
            {
                "data": "notes",
                // "data": null, render: function (data, type, row) 
                // {
                //     return "<div class='text-wrap width-200'>" + data.notes + "</div>";
                // },
                "defaultContent": "",
            },
            {
            "data": "si_notes", // Last Updated
            "defaultContent": "",
            },
        ],
        'columnDefs': [
     		// {
        	// 	'targets': 3,
        	// 	'createdCell':  function (td, cellData, rowData, row, col) {
            //            $(td).attr('id', 'cell-' + cellData); 
            //            $(td).attr('contenteditable', 'true');
            //            $(td).attr('onBlur', 'saveToDatabase(this,' + td + ',' + col + ')');
            //            $(td).attr('onClick', 'showEdit(this)');
            //         //    =\"true\" onBlur=\"saveToDatabase(this,'entity_common_name',"+data.list_id+")\" onClick=\"showEdit(this);\"
            // },
            { className: "text-wrap", "targets":  [10, 11]  },
            /*{ width: "1%", "targets": 1 },
            { width: "3%", "targets": [4, 6] },
            { width: "4%", "targets": [5, 7, 9, 14] },
            { width: "5%", "targets": [8, 10, 11] },
            { width: "6%", "targets": 2 },
            { width: "7 %", "targets": 12 },*/
            // { width: "18%", "targets": [3] },
            { width: "17%", "targets": [10, 11] },

            {
                'targets': [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                'createdCell': function (td, cellData, rowData, row, col) {
                    {
                        var check = oTable.cell(td,0).data(); 
                        switch(col)
                        {   
                            case 0:
                                $(td).attr('contenteditable', 'false');
                                $(td).attr('onBlur', 'saveToDatabase(this, \'api\',\'' + check + '\')');
                                $(td).attr('onClick', 'showEdit(this)');
                            break;
                            case 1:
                                $(td).attr('contenteditable', 'true');
                                $(td).attr('onBlur', 'saveToDatabase(this, \'entity_common_name\',\'' + check + '\')');
                                $(td).attr('onClick', 'showEdit(this)');
                            break;
                            case 2:
                                $(td).attr('contenteditable', 'true');
                                $(td).attr('onBlur', 'saveToDatabase(this, \'state\',\'' + check + '\')');
                                $(td).attr('onClick', 'showEdit(this)');
                            break;
                            case 3:
                                $(td).attr('contenteditable', 'true');
                                $(td).attr('onBlur', 'saveToDatabase(this, \'county_parish\',\'' + check + '\')');
                                $(td).attr('onClick', 'showEdit(this)');
                            break;
                            case 4:
                                $(td).attr('contenteditable', 'true');
                                $(td).attr('onBlur', 'saveToDatabase(this, \'block\',\'' + check + '\')');
                                $(td).attr('onClick', 'showEdit(this)');
                            break;
                            case 5:
                                $(td).attr('contenteditable', 'true');
                                $(td).attr('onBlur', 'saveToDatabase(this, \'entity_operator_code\',\'' + check + '\')');
                                $(td).attr('onClick', 'showEdit(this)');
                            break;
                            case 6:
                                $(td).attr('contenteditable', 'true');
                                $(td).attr('onBlur', 'saveToDatabase(this, \'producing_status\',\'' + check + '\')');
                                $(td).attr('onClick', 'showEdit(this)');
                            break;
                            case 7:
                                $(td).attr('contenteditable', 'true');
                                $(td).attr('onBlur', 'saveToDatabase(this, \'production_type\',\'' + check + '\')');
                                $(td).attr('onClick', 'showEdit(this)');
                            break;
                            case 8:
                                $(td).attr('contenteditable', 'true');
                                $(td).attr('onBlur', 'saveToDatabase(this, \'last_prod_date\',\'' + check + '\')');
                                $(td).attr('onClick', 'showEdit(this)');
                            break;
                            case 9:
                                $(td).attr('contenteditable', 'true');
                                $(td).attr('onBlur', 'saveToDatabase(this, \'pumper\',\'' + check + '\')');
                                $(td).attr('onClick', 'showEdit(this)');
                            break;
                            case 10:
                                $(td).attr('contenteditable', 'true');
                                $(td).attr('onBlur', 'saveToDatabase(this, \'notes\',\'' + check + '\')');
                                $(td).attr('onClick', 'showEdit(this)');
                            break;
                            default:
                                $(td).attr('contenteditable', 'true');
                                $(td).attr('onBlur', 'saveToDatabase(this, \'si_notes\',\'' + check + '\')');
                                $(td).attr('onClick', 'showEdit(this)');
                        }
                        // $(td).attr('onBlur', 'saveToDatabase(this,' + td + ',' + col + ')');
                        // if ( checkSI == 'Shut-in' || checkSI == 'Shut-In' || checkSI  == 'INACTIVE' ) 
                        // {
                        //     $(td).css('background-color', '#F08080')
                        // }
                    }
                },
                    
            },
     		
  		]
            // "rowCallback": function( row, data, index ) 
            //     {
            //         $('td', row).attr('contenteditable=\"true\" onBlur=\"saveToDatabase(this,'entity_common_name',"+data.list_id+")\" onClick=\"showEdit(this);\"');
            //         $('td:eq(13)', row).addClass('width-200');    
            //     }
                    
        } );
        $('#searchProduction').keyup(function(){
            oTable.search($(this).val()).draw() ;
        })
    } );
</script>
<style>
    /* .tbl-qa {
    /* width: 100%; 
    background-color: #f5f5f5;*/
/* } */

/* .tbl-qa th.table-header {
    /* padding: 5px;
    text-align: left;
    padding: 10px; 
} */

/* .tbl-qa .table-row td { */
    /* padding: 8px 15px 10px 8px;
    background-color: #FDFDFD;
    vertical-align: top; */
    /* font-size: 11px;
} */ 
/* tr {
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
  height: 85vh;
  width: auto;
  position: absolute;
} */
/* .table > thead {
                font-style: normal!important;
                font-stretch: condensed!important;
                font-size: 12px;
            } */
.smol th,
.smol td,
.smol a,
.smol p {
  padding-top: 0.3rem;
  padding-bottom: 0.3rem;
  font-size: 12px!important;
}
table.dataTable tbody td {
  word-break: break-word!important;
  vertical-align: top;
} 
.text-wrap{
    white-space:normal!important;
}
</style>
</head>
<body>
<?php include 'include/header_extensions.php'; ?>
   
    
<main role='main' >
	<div class=''>
		<table id="productionTable" class='tbl-qa table table-hover table-striped table-bordered table-sm smol' style="margin:0px!important; border-collapse: collapse!important;">
            <thead class='bg-sog table-borderless'style="border: 3px solid rgb(100,150,225)!important; border-color: rgb(100,150,225)!important; border-collapse: collapse!important;">
                <tr>
                <th class="table-header">API</th>
                    <th class="table-header">Well</th>
                    <th class="table-header">State</th>
                    <th class="table-header">County</th>
                    <th class="table-header">Block</th>
                    <th class="table-header">Company</th>
                    <th class="table-header">Status</th>
                    <th class="table-header">Type</th>
                    <th class="table-header">Last Active</th>
                    <th class="table-header">Pumper</th>
                    <th class="table-header">Notes</th>
                    <th class="table-header">S/I Notes</th>
                </tr>
            </thead>
        </table>
	</div>
</main>
</body>
	<!-- <script src="dashboard/jquery-3.2.1.slim.min.js.download" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-3.2.1.slim.min.js"><\/script>')</script> -->
    <!-- <script src="dashboard/popper.min.js.download"></script>
    <script src="dashboard/bootstrap.min.js.download"></script> -->

    <!-- Icons -->
    <!-- <script src="dashboard/feather.min.js.download"></script>
    <script>
      feather.replace()
    </script>    -->
    <!-- <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script> -->
    <!-- <script src="stylesheet/holder.min.js.download"></script>
    <script src="stylesheet/offcanvas.js.download"></script> -->


</html>
