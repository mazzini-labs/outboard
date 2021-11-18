<?php
include 'lib/ob.php';
include 'include/wsbFunctions.php';



?>
<!DOCTYPE html>
<html>
<head>
	
	<meta charset="utf-8" />
	<meta http-equiv="x-ua-compatible" content="ie=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, user-scalable=no">
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<title>Edit Well Notes</title>
	<!-- <link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/maintest.css?=v1.2">
	<link rel="stylesheet" type="text/css" href="css/search.css">
	<link rel="stylesheet" type="text/css" href="css/tabs.css">
	
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
	
	<style type="text/css" class="init">
	
	</style>
	<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script> -->
	<?php include 'include/dependencies.php'; ?>

	<style type="text/css" class="init">
	
	div.DTE_Inline input {
		border: none;
		background-color: transparent;
		padding: 0 !important;
		font-size: 90%;
		white-space:normal!important;
		overflow-wrap: break-word;
	}

	div.DTE_Inline input:focus {
		outline: none;
		background-color: transparent;
		white-space:normal!important;
		overflow-wrap: break-word;
	}

	</style>
	<link rel="stylesheet" type="text/css" href="editor/css/editor.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="/editor/css/editor.bootstrap4.css">
	<script type="text/javascript" language="javascript" src="editor/js/dataTables.editor.min.js"></script>
	
<!-- <script type="text/javascript" src="datatables/datatables.min.js"></script> -->
<!-- <script type="text/javascript" src="/editor/js/dataTables.editor.js"></script> -->
<script type="text/javascript" src="/editor/js/editor.bootstrap4.min.js?v=1"></script>
	<!-- <script type="text/javascript" language="javascript" src="../resources/syntax/shCore.js"></script>
	<script type="text/javascript" language="javascript" src="../resources/demo.js"></script>
	<script type="text/javascript" language="javascript" src="../resources/editor-demo.js"></script> -->
	<script type="text/javascript" language="javascript" class="init">
	


var editor; // use a global for the submit and return data rendering in the examples
var oTable;
$(document).ready(function() {
	editor = new $.fn.dataTable.Editor( {
		ajax: {
			create: {
				type: 'POST',
				url:  'editor/controllers/rest/create.php'
			},
			edit: {
				type: 'PUT',
				url:  'editor/controllers/rest/edit.php'
			},
			remove: {
				type: 'DELETE',
				url:  'editor/controllers/rest/remove.php'
			}
		},
		table: "#productionTable",
		fields: [ {
                label: "API",
                name: "api"
            }, {
                label: "Well",
                name: "entity_common_name"
            }, {
                label: "State",
                name: "state"
            }, {
                label: "County",
                name: "county_parish"
            }, {
                label: "Block",
                name: "block"
            }, {
                label: "Company",
                name: "entity_operator_code",
            }, {
                label: "Status",
                name: "producing_status"
            }, {
                label: "Type",
                name: "production_type"
            }, {
                label: "Last Active",
                name: "last_prod_date"
            }, {
                label: "Pumper",
                name: "pumper"
            }, {
                label: "Notes",
                name: "notes"
            }, {
                label: "S/I Notes",
                name: "si_notes"
			}, {
				label: "Last Updated",
				name: "notes_update"
			}
			

        ]
	} );

	oTable = $('#productionTable').DataTable( {
		"sDom": 't',
		// "order": [],
		order: [[ 0, 'asc' ]],
		scrollY: "87vh",
		scroller: true,
		searching: true,
		// "keys": true,
		ajax: "editor/controllers/rest/get.php",
		columns: [
            { 
                data: "api",
                defaultContent: ""
            },
            {
				data: "entity_common_name",
				defaultContent: ""
            },
            {
				data: "state", // State
				defaultContent: ""
            },
            {
				data: "county_parish", // County
				defaultContent: "",
            },
            {
				data: "block", // Block
				defaultContent: "",
            },
            {
				data: "entity_operator_code", // Entity (Company)
				defaultContent: "",
            },
            {
				data: "producing_status", // Production Status
				defaultContent: "",
            },
            {
                data: "production_type", // Production Type
                defaultContent: "",
            },
            {
                data: "last_prod_date", // Last Active
                defaultContent: "",
            },
            {
                data: "pumper", // Pumper
                defaultContent: "",
            },
            {
                data: "notes",
				// data: null, render: function ( data, type, row ) 
				// {
				// 	var today = moment();
				// 	var oneWeekRemind = moment(data.notes_update).add(7, 'days');
				// 	var twoWeekRemind = moment(data.notes_update).add(14, 'days');
				// 	var oneMonthRemind = moment(data.notes_update).add(1, 'months');
				// 	var sixMonthRemind = moment(data.notes_update).add(6, 'months');
				// 	var oneYearRemind  = moment(data.notes_update).add(1, 'years');
				// 	var areWeStillUpdating = moment(data.notes_update).add(1, 'years').add(6, 'months');
				// 	// console.log(reminder);
				// 	console.log(today);
				// 	if(today > areWeStillUpdating){
				// 		return "<div class='areWeStillUpdating'>" + data.notes + "</div>";
				// 	}
				// 	else if(today > oneYearRemind){
				// 		return "<div class='oneYearRemind'>" + data.notes + "</div>";
				// 	}
				// 	if(today > sixMonthRemind){
				// 		return "<div class='sixMonthRemind'>" + data.notes + "</div>";
				// 	}
				// 	if(today > oneMonthRemind){
				// 		return "<div class='oneMonthRemind'>" + data.notes + "</div>";
				// 	}
				// 	if(today > twoWeekRemind){
				// 		return "<div class='twoWeekRemind'>" + data.notes + "</div>";
				// 	}
				// 	if(today > oneWeekRemind){
				// 		return "<div class='oneWeekRemind'>" + data.notes + "</div>";
				// 	}
				// 	else {
				// 		return data.notes;
				// 	}

					
				// },
				defaultContent: "",
            },
            {
				data: "si_notes", // Last Updated
				defaultContent: "",
			},
			{
				data: "notes_update",
				defaultContent: ""
			}
        ],
		// select: true,
		autoFill: {
			columns: ':not(:first-child)',
			editor:  editor
		},
		keys: {
			columns: ':not(:first-child)',
			editor:  editor
		},
		select: {
			style:    'os',
			selector: 'td:first-child',
			blurable: true
		},
		buttons: [
			{ extend: "create", editor: editor },
			{ extend: "edit",   editor: editor },
			{ extend: "remove", editor: editor }
		],
        'columnDefs': [
            { className: "text-wrap notes", "targets":  [10, 11]  },
			{ className: "notes", "targets":  [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]  },
			{ width: "5%", "targets": [0, 2, 4, 6, 7] },
			{ width: "6%", "targets": [3] },
			{ width: "9%", "targets": [5] },
			{ width: "10%", "targets": [1, 8, 9] },
			{ width: "17%", "targets": [10, 11] },
			{
				targets: 10,
				"createdCell": function (td, cellData, rowData, row, col) {
					{
						var datanotes_update = oTable.cell(td,12).data(); 
						// console.log(datanotes_update);
						var today = moment();
						var oneWeekRemind = moment(datanotes_update).add(7, 'days');
						var twoWeekRemind = moment(datanotes_update).add(14, 'days');
						var oneMonthRemind = moment(datanotes_update).add(1, 'months');
						var sixMonthRemind = moment(datanotes_update).add(6, 'months');
						var oneYearRemind  = moment(datanotes_update).add(1, 'years');
						var areWeStillUpdating = moment(datanotes_update).add(1, 'years').add(6, 'months');
						// // Maybe I'm confusing myself?
						// var oneWeekRemind = today.subtract(7, 'days');
						// var twoWeekRemind = today.subtract(14, 'days');
						// var oneMonthRemind = today.subtract(1, 'months');
						// var sixMonthRemind = today.subtract(6, 'months');
						// var oneYearRemind  = today.subtract(1, 'years');
						// var areWeStillUpdating = today.subtract(1, 'years').add(6, 'months');
						// console.log(oneWeekRemind);
						// console.log(twoWeekRemind);
						// console.log(oneMonthRemind);
						// console.log(sixMonthRemind);
						// console.log(oneYearRemind);
						// console.log(areWeStillUpdating);
						if(today > areWeStillUpdating){
							$(td).addClass('areWeStillUpdating');
						}
						else if(today > oneYearRemind){
							$(td).addClass('oneYearRemind');
						}
						else if(today > sixMonthRemind){
							$(td).addClass('sixMonthRemind');
						}
						else if(today > oneMonthRemind){
							$(td).addClass('oneMonthRemind');
						}
						else if(today > twoWeekRemind){
							$(td).addClass('twoWeekRemind');
						}
						else if(today > oneWeekRemind){
							$(td).addClass('oneWeekRemind');
						}
					}
				},

			}
		],
		
		"drawCallback": function(settings)
		{
			feather.replace();
			tippy('.areWeStillUpdating', { 
				hideOnClick: true,
				// showOnCreate: true,
				theme: 'defcon',
				allowHTML: true,
				arrow: true,
				sticky: false,
				appendTo: 'parent',
				placement: 'left',
				content: '<h1>Do we still own this well????</h1>' 
			});
			tippy('.oneYearRemind', { 
				hideOnClick: true,
				// showOnCreate: true,
				theme: 'danger',
				allowHTML: true,
				arrow: true,
				sticky: false,
				appendTo: 'parent',
				placement: 'left',
				content: '<h2>It has been over <b>a year</b> since this has been updated.</h2>' 
			});
			tippy('.sixMonthRemind', { 
				hideOnClick: true,
				// showOnCreate: true,
				theme: 'critical',
				allowHTML: true,
				arrow: true,
				sticky: false,
				appendTo: 'parent',
				placement: 'left',
				content: '<h3>It\'s been half a year since this well was updated.</h3>' 
			});
			tippy('.oneMonthRemind', { 
				hideOnClick: true,
				// showOnCreate: true,
				theme: 'major',
				allowHTML: true,
				arrow: true,
				// sticky: true,
				// inlinePositioning: true,
				appendTo: 'parent',
				// interactive: true,
				// appendTo: document.body,
				
				// popperOptions: {
				// 	strategy: 'fixed',
				// },
				placement: 'left',
				content: '<h6>This <b>really</b> needs to be updated.</h6> <br> (No update in over a month)' 
			});
			tippy('.twoWeekRemind', { 
				hideOnClick: true,
				// showOnCreate: true,
				theme: 'minor',
				allowHTML: true,
				arrow: true,
				sticky: false,
				appendTo: 'parent',
				placement: 'left',
				content: 'This needs to be updated. <br> <small>(No update in over two weeks)</small>' 
			});
			tippy('.oneWeekRemind', { 
				hideOnClick: true,
				// showOnCreate: true,
				theme: 'info',
				allowHTML: true,
				arrow: true,
				sticky: false,
				appendTo: 'parent',
				placement: 'left',
				content: 'General reminder to update this well! <br> <small>(It appears this well hasn\'t been updated this week)</small>' 
			});
		} 
	} );
	$('#searchProduction').keyup(function(){
		oTable.search($(this).val()).draw() ;
	})
	oTable.columns.adjust().draw;
} );



	</script>
<style>
.selected {
    background-color: #343a40;
	color: #fff;
}
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
p, td {
    cursor: url("./images/crosshair.gif"), url("./images/crosshair.cur"), crosshair;
}
td:focus { cursor: text; }

.tippy-box[data-theme~='info'] {
  background-color: #17a2b8;
  /* color: yellow; */
}
.tippy-box[data-theme~='minor'] {
  background-color: #e4606d;
  /* color: yellow; */
}
.tippy-box[data-theme~='major'] {
  background-color: #661244;
  /* color: yellow; */
}
.tippy-box[data-theme~='danger'] {
  background-color: #dc3545;
  /* color: yellow; */
}
.tippy-box[data-theme~='critical'] {
  background-color: #bd2130;
  /* color: yellow; */
}
.tippy-box[data-theme~='defcon'] {
  background-color: #a71d2a;
  /* color: yellow; */
}
.areWeStillUpdating { 
	background-color: #a71d2a; 
	color: white;
}
.oneYearRemind {
	background-color: #a71d2a; 
	color: white;
}
.sixMonthRemind {
	background-color: #dc3545; 
	color: white;
}
.oneMonthRemind {
	background-color: #661244; 
	color: white;
}
.twoWeekRemind {
	background-color: #e4606d; 
	color: white;
}
.oneWeekRemind {
	background-color: #17a2b8; 
	color: white;
}


</style>
</head>
<body>
<?php include 'include/header_extensions.php'; ?>
   
    
<main role='main' >
	<div class=''>
		<table id="productionTable" class='table table-hover table-striped table-bordered table-sm smol' style="margin:0px!important; border-collapse: collapse!important;">
            <thead class='bg-sog table-borderless' style="border: 3px solid rgb(100,150,225)!important; border-color: rgb(100,150,225)!important; border-collapse: collapse!important;">
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
				<th class="table-header">Last Updated</th>
                </tr>
            </thead>
        </table>
	</div>
</main>
<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
</body>
</html>