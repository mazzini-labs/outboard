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
				url:  'editor/controllers/rest/create.full.php'
			},
			edit: {
				type: 'PUT',
				url:  'editor/controllers/rest/edit.full.php'
			},
			remove: {
				type: 'DELETE',
				url:  'editor/controllers/rest/remove.full.php'
			}
		},
		// data: data,
		table: "#productionTable",
		fields: [  {
                label: "Well",
                name: "entity_common_name"
            },{
                label: "API",
                name: "api"
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
				type: "select",
                label: "Company",
				name: "entity_operator_code",
				// options: data.options['entity_operator_code']
				options: [
                    { label: "SOG",			value: "SOG" },
                    { label: "SDC",         value: "SDC" },
                    { label: "MRV",         value: "MRV" },
                    { label: "NRG",         value: "NRG" },
					{ label: "PEV",  		value: "PEV" },
					{ label: "PPC",			value: "PPC" }
                ]
            }, {
				type: "select",
                label: "Status",
				name: "producing_status",
				// options: data.options['producing_status']
				// 'Active', 'Inactive', 'Down', 'S/I', 'TA', 'P&A'
				options: [
                    { label: "Active",			value: "Active" },
                    { label: "Inactive",        value: "Inactive" },
                    { label: "Down",         	value: "Down" },
                    { label: "S/I",         	value: "S/I" },
					{ label: "TA",  			value: "TA" },
					{ label: "P&A",				value: "P&A" },
					{ label: "N/A",				value: "N/A" }
                ]
            }, {
				type: "select",
                label: "Type",
				name: "production_type",
				// options: data.options['production_type']
				// 'Oil', 'Gas', 'SWD', 'Inj
				options: [
                    { label: "Oil",			value: "Oil" },
                    { label: "Gas",         value: "Gas" },
                    { label: "SWD",         value: "SWD" },
					{ label: "Inj",         value: "Inj" },
					{ label: "N/A",			value: "N/A" },
					{ label: "CP",			value: "CP"	 }
                ]
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
			}, 
			{ label: "First Prod.", name: "first_prod" },
			{ label: "Drill Type", name: "drill_type" },
			{ label: "Upper Perf.", name: "upper_perf" },
			{ label: "Lower Perf.", name: "lower_perf" },
			{ label: "Gas Gravity", name: "gas_gravity" },
			{ label: "Oil Gravity", name: "oil_gravity" },
			{ label: "Completion Date", name: "completion_date" },
			{ label: "Well Count", name: "well_count" },
			{ label: "Max Active Wells", name: "max_active_wells" },
			{ label: "Months Produced", name: "months_produced" },
			{ label: "Gas Gatherer", name: "gas_gatherer" },
			{ label: "Oil Gatherer", name: "oil_gatherer" },
			{ label: "Spud Date", name: "spud_date" },
			{ label: "Show on WSB", name: "show" },
			{ label: "MD", name: "measured_depth_td" },
			{ label: "TVD", name: "true_vertical_depth" },
			{ label: "Lat.", name: "surface_latitude_wgs84" },
			{ label: "Long.", name: "surface_longitude_wgs84" },
			{ label: "Field", name: "field" },
			{ label: "Reservoir", name: "reservoir" },
			{ label: "Report Frequency", name: "report_frequency" },
			{ label: "Well File Location", name: "well_file_location" },
			{ label: "Entity Type", name: "entity_type" },
			{
				label: "Last Updated",
				name: "notes_update"
			},
		],
		
	} );

	oTable = $('#productionTable').DataTable( {
		"sDom": 't',
		// "order": [],
		// order: [[ 0, 'asc' ]],
		scrollY: "87vh",
		scroller: true,
		searching: true,
		// "keys": true,
		ajax: "editor/controllers/rest/get.full.php",
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
			{ data: "first_prod", defaultContent: "" },
			{ data: "drill_type", defaultContent: "" },
			{ data: "upper_perf", defaultContent: "" },
			{ data: "lower_perf", defaultContent: "" },
			{ data: "gas_gravity", defaultContent: "" },
			{ data: "oil_gravity", defaultContent: "" },
			{ data: "completion_date", defaultContent: "" },
			{ data: "well_count", defaultContent: "" },
			{ data: "max_active_wells", defaultContent: "" },
			{ data: "months_produced", defaultContent: "" },
			{ data: "gas_gatherer", defaultContent: "" },
			{ data: "oil_gatherer", defaultContent: "" },
			{ data: "spud_date", defaultContent: "" },
			{ data: "show", defaultContent: "" },
			{ data: "measured_depth_td", defaultContent: "" },
			{ data: "true_vertical_depth", defaultContent: "" },
			{ data: "surface_latitude_wgs84", defaultContent: "" },
			{ data: "surface_longitude_wgs84", defaultContent: "" },
			{ data: "field", defaultContent: "" },
			{ data: "reservoir", defaultContent: "" },
			{ data: "report_frequency", defaultContent: "" },
			{ data: "well_file_location", defaultContent: "" },
			{ data: "entity_type", defaultContent: "" },
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
						var datanotes_update = oTable.cell(td,35).data(); 
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

			},
			{
				"targets": [ 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34 ],
				"visible": false,
				// "searchable": false
			},
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
	// oTable.columns ([ 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33 ]).visible(false);
	oTable.columns.adjust().draw;
	$('.toggle-vis').on( 'click', function (e) {
        // e.preventDefault();
 
        // Get the column API object
        var column = oTable.column( $(this).attr('data-column') );
 
        // Toggle the visibility
        column.visible( ! column.visible() );
	} );
	$('#new-well').click(function(){  
		$('#api').removeClass("hidden");
		$('#api-hide-spacer').removeClass("hidden");
		$('#api-hide-div').removeClass("hidden");
	});
	$('#insert_well_form').on("submit", function(event){
        event.preventDefault();
        
        if($('#api').val() == "")  
        {  
                alert("API No. is required");  
        }  
        else  
        {  
            var api = $('#api').val();
            $.ajax({
                url:"./ajax/insert.well.php",  
                method:"POST",  
                data:$('#insert_well_form').serialize(),  
                beforeSend:function(){  
                    $('#insert-well').val("Inserting");  
                },  
                success:function(data){  
                    $('#insert_well_form')[0].reset();  
                    $('#well_entry_Modal').modal('hide');
                    oTable.ajax.reload();
                    //$('#dsr_table').html(data);
                    // $.ajax({  
                    //     url:"./ajax/fetchwells.php",  
                    //     method:"POST",  
                    //     data:{api:api},  
                    //     dataType:"json",  
                    //     success:function(data){
							
                    //     }
                    // });     
                }  
            });  
        }
    });
	// var url = window.location.pathname;
	// if (url.indexOf("notes") === 1) {
    //   $('div#well-div').removeClass("hidden");
    //   console.log("notes conditional success " + url);
    // }
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
		cursor: url("/assets/images/crosshair.gif"), url("assets/images/crosshair.cur"), crosshair;
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
	.without_ampm::-webkit-datetime-edit-ampm-field {
	display: none;
	}
	input[type=time]::-webkit-clear-button {
	-webkit-appearance: none;
	-moz-appearance: none;
	-o-appearance: none;
	-ms-appearance:none;
	appearance: none;
	margin: -10px; 
	}
	.modal-dialog {
		position: fixed;
		top: -3vh;
		right: 0;
		bottom: 0;
		height: 100%;
		width: 100%;
		/* max-width: 800px; */
		z-index: 9999;
		overflow: auto;
		transition: transform 0.3s;
		will-change: transform;
		background-color: #fff;
		display: flex;
		flex-direction: column;
		-webkit-transform: translateX(103%);
		transform: translateX(103%); /* extra 3% because of box-shadow */
		-webkit-overflow-scrolling: touch; /* enables momentum scrolling in iOS overflow elements */
		box-shadow: 0 2px 6px #777;
	}
	.modal-content {
		position: relative;
		overflow-x: hidden;
		overflow-y: auto;
		height: 100%;
		flex-grow: 1;
		padding: 1.5rem;
	}

	.modal.is-active {
		display: block;
	}

	.modal.is-visible .modal-wrapper {
		-webkit-transform: translateX(0);
		transform: translateX(0);
	}

	.modal.is-visible .modal-overlay {
		opacity: 0.5;
	}
	.modal-overlay {
		position: fixed;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;
		width: 100%;
		z-index: 2000;
		opacity: 0;
		transition: opacity 0.3s;
		will-change: opacity;
		background-color: #000;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}
	/* .modal-body { z-index: 9999; } */
	/* TESTING SLIDE OUT SCREEN */
	.modal-dialog-edits {
		position: initial;
		top: -3vh;
		right: 46%;
		bottom: 0;
		height: 100%;
		width: 50%;
		max-width: 500px;
		z-index: 2100;
		overflow: auto;
		transition: transform 0.3s;
		will-change: transform;
		background-color: #fff;
		display: flex;
		flex-direction: column;
		-webkit-transform: translateX(103%);
		transform: translateX(103%); /* extra 3% because of box-shadow */
		-webkit-overflow-scrolling: touch; /* enables momentum scrolling in iOS overflow elements */
		box-shadow: 0 2px 6px #777;
	}

	.primnav expand:hover, .primnav li:hover {
	/* background-color: #343a40!important; */
	background-color: rgba(0, 0, 0, 0.4);
	}

	.primnav {
	position: fixed;
	height: 58px;
	width: 100vw;
	font-size: 0.8em;
	text-transform: uppercase;
	background-color: #f8f9fa!important;
	display: flex;
	flex-direction: column;
	transition: height 246ms 0.5s ease;
	/* padding-top: 58px; */
	overflow-x: hidden;
	overflow-y: hidden;
	box-sizing: border-box;
	z-index: 2200;
	/* box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important; */
	box-shadow: 0 2px 6px #777;
	}
	@media (min-width: 650px) {
	.primnav {
		position: fixed;
		bottom: 0;
		right: 42%;
		
		height: 100%;
		width: 4%;
		/* -webkit-animation-name: slideIn;
		-webkit-animation-duration: 0.4s;
		animation-name: slideIn; */
		/* animation-duration: 0.4s; */
		/* height: 100vh;
		width: 58px;*/
		transition: width 246ms 0.5s ease; 
	}
	}
	.primnav > ul {
	height: 100%;
	overflow-y: auto;
	overflow-x: hidden;
	background-color: rgba(0, 0, 0, 0.03);
	padding-top: 40vh;
	}
	.primnav li {
	font-weight: 400;
	position: relative;
	}
	.primnav li .tag {
	background-color: #343a40!important;
	/* background-color: rgba(0, 112, 204, 0.8); */
	color: rgba(255, 255, 255, 0.8);
	color: #e6e6e6;
	color: rgba(255, 255, 255, 0.9);
	padding: 0 0.5em;
	border-radius: 2em;
	margin-left: auto;
	margin-right: 0.75em;
	}
	.primnav li a {
	position: relative;
	display: flex;
	align-items: center;
	white-space: nowrap;
	color: white;
	color: rgba(255, 255, 255, 0.8);
	text-decoration: none;
	}
	.primnav .icon {
	height: 20px;
	flex-shrink: 0;
	width: 20px;
	padding: 19px;
	margin-right: 5px;
	padding-bottom: 15px;
	color: #e6e6e6;
	color: rgba(255, 255, 255, 0.9);
	}

	.drawer {
	display: none; /* Hidden by default */
	position: fixed; /* Stay in place */
	/*  z-index: 1; Sit on top */

		position: initial;
		top: 0vh;
		right: 46%;
		bottom: 0;
		height: 100%;
		width: 50%;
		max-width: 500px;
		z-index: 2100;
		overflow: auto;
		transition: transform 0.3s;
		will-change: transform;
		background-color: #fff;
		/* display: flex; */
		flex-direction: column;
		-webkit-transform: translateX(103%);
		transform: translateX(103%); /* extra 3% because of box-shadow */
		-webkit-overflow-scrolling: touch; /* enables momentum scrolling in iOS overflow elements */
		box-shadow: 0 2px 6px #777;
	}

	/* Modal Content */
	.drawer-content {
	position: fixed;
	bottom: 0;
	right: 0%;
	background-color: #fefefe;
	height: 100%;
	width: 100%;
	-webkit-animation-name: slideIn;
	-webkit-animation-duration: 0.4s;
	animation-name: slideIn;
	animation-duration: 0.4s
	}

	/* The Close Button */
	.drawer-close {
	color: white;
	float: right;
	font-size: 28px;
	font-weight: bold;
	}

	.drawer-close:hover,
	.drawer-close:focus {
	color: #000;
	text-decoration: none;
	cursor: pointer;
	}

	.drawer-header {
	padding: 2px 16px;
	background-color: #343a40;
	color: white;
	padding-right: 2px;
	}

	.drawer-body {padding: 2px 16px;}

	.drawer-footer {
	padding: 2px 16px;
	background-color: #343a40;
	color: white;
	}

	/* Add Animation */
	@-webkit-keyframes slideIn {
	from {right: -300px; opacity: 0} 
	to {right: 0%; opacity: 1}
	}

	@keyframes slideIn {
	from {right: -300px; opacity: 0}
	to {right: 0%; opacity: 1}
	}

	@-webkit-keyframes fadeIn {
	from {opacity: 0} 
	to {opacity: 1}
	}

	@keyframes fadeIn {
	from {opacity: 0} 
	to {opacity: 1}
	}
	hr.vertically {
            width: 0;
            height: 100%;
        }

</style>
</head>
<body>
<?php 
include 'include/header_extensions.php'; 
include 'modals/well_entry_modal.php'; 
?>
   
    
<main role='main' >
<!-- Settings Modal -->
<div class="modal right" id="notes_settings_Modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal--sm modal-side modal-top-right" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalPreviewLabel">Show/Hide Columns</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
			
	<div class="mx-auto row">
		<div class="col">
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="2" id="state" checked/><label class="custom-control-label" for="state">State</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="3" id="county" checked/><label class="custom-control-label" for="county">County</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="4" id="block" checked/><label class="custom-control-label" for="block">Block</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="5" id="company" checked/><label class="custom-control-label" for="company">Company</label></div>
		</div>
		<!-- <hr class="w-100"> -->
		<div class="col">
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="6" id="status" checked/><label class="custom-control-label" for="status">Status</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="7" id="type" checked/><label class="custom-control-label" for="type">Type</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="8" id="lastactive" checked/><label class="custom-control-label" for="lastactive">Last Active</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="9" id="pumper" checked/><label class="custom-control-label" for="pumper">Pumper</label></div>
		</div>
		<hr class="w-100">
		<div class="col">
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="10" id="notes" checked/><label class="custom-control-label" for="notes">Notes</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="11" id="si" checked/><label class="custom-control-label" for="si">S/I Notes</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="12" id="fp"/><label class="custom-control-label" for="fp">First Prod.</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="13" id="dt"/><label class="custom-control-label" for="dt">Drill Type</label></div>
		</div>
		<!-- <hr class="w-100"> -->
		<div class="col">
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="14" id="up"/><label class="custom-control-label" for="up">Upper Perforation</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="15" id="lp"/><label class="custom-control-label" for="lp">Lower Perfforation</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="16" id="gg"/><label class="custom-control-label" for="gg">Gas Gravity</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="17" id="og"/><label class="custom-control-label" for="og">Oil Gravity</label></div>
		</div>
		<hr class="w-100">
		<div class="col">
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="18" id="cd"/><label class="custom-control-label" for="cd">Completion Date</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="19" id="wc"/><label class="custom-control-label" for="wc">Well Count</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="20" id="maw"/><label class="custom-control-label" for="maw">Max Active Wells</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="21" id="mp"/><label class="custom-control-label" for="mp">Months Produced</label></div>
		</div>
		<!-- <hr class="w-100"> -->
		<div class="col">
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="22" id="gasg"/><label class="custom-control-label" for="gasg">Gas Gatherer</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="23" id="oilg"/><label class="custom-control-label" for="oilg">Oil Gatherer</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="24" id="spud"/><label class="custom-control-label" for="spud">Spud Date</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="25" id="show"/><label class="custom-control-label" for="show">Show on WSB?</label></div>
		</div>
		<hr class="w-100">
		<div class="col">
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="26" id="md"/><label class="custom-control-label" for="md">MD</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="27" id="tvd"/><label class="custom-control-label" for="tvd">TVD</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="28" id="lat"/><label class="custom-control-label" for="lat">Latitude WGS84</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="29" id="long"/><label class="custom-control-label" for="long">Longitude WGS84</label></div>
		</div>
		<!-- <hr class="w-100"> -->
		<div class="col">
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="30" id="field"/><label class="custom-control-label" for="field">Field</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="31" id="res"/><label class="custom-control-label" for="res">Reservoir</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="32" id="rf"/><label class="custom-control-label" for="rf">Report Frequency</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="33" id="wfl"/><label class="custom-control-label" for="wfl">Well File Location</label></div>
		</div>
		<hr class="w-100">
		<div class="col">
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="34" id="et"/><label class="custom-control-label" for="et">Entity Type</label></div>
			<!-- <div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="0" id="api"/><label class="custom-control-label" for="api">API</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="0" id="api"/><label class="custom-control-label" for="api">API</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="0" id="api"/><label class="custom-control-label" for="api">API</label></div> -->
		</div>
		<!-- <div class="col">
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="0" id="api"/><label class="custom-control-label" for="api">API</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="0" id="api"/><label class="custom-control-label" for="api">API</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="0" id="api"/><label class="custom-control-label" for="api">API</label></div>
			<div class="custom-control custom-checkbox"><input class="custom-control-input toggle-vis" type="checkbox" data-column="0" id="api"/><label class="custom-control-label" for="api">API</label></div>
		</div> -->
	</div>
	</div>
		</div>
	</div>
</div>
<!-- Settings Modal -->
<!-- Fixed Action Button -->
<div class="fixed-action-btn" style="bottom: 45px; right: 24px; z-index:1500; color: white;" name="add" id="add" href="#notes_settings_Modal" data-toggle="modal">
    <a class="btn-floating btn-lg btn-primary mx-auto" name="fab" id="fab" data-toggle="tooltip" data-placement="left" title="Select Columns" style="text-align: center!important;">
      <i class="lg-icon" data-feather="settings" ></i>
    </a>
    
  </div>
<!-- Fixed Action Button -->
<!-- Fixed Action Button - Add New Well -->
<div id="new-well">
<div class="fixed-action-btn" style="top: -2.75em; right: 45%; z-index:1500;" name="" id="" href="#well_entry_Modal" data-toggle="modal">
    <a class="btnfloating btn btn-primary mx-auto text-white btn-lg" name="" id="" data-toggle="tooltip" data-placement="left" title="Add Latest Production" style="text-align: center!important;">
      <!-- <i class="lg-icon" data-feather="plus-circle" >add</i> -->Add New Well
    </a>
    </div>
</div>


<!-- Fixed Action Button - Add New Well -->
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
				<th class="table-header">First Prod.</th>
				<th class="table-header">Drill Type</th>
				<th class="table-header">Upper Perf.</th>
				<th class="table-header">Lower Perf.</th>
				<th class="table-header">Gas Gravity</th>
				<th class="table-header">Oil Gravity</th>
				<th class="table-header">Completion Date</th>
				<th class="table-header">Well Count</th>
				<th class="table-header">Max Active Wells</th>
				<th class="table-header">Months Produced</th>
				<th class="table-header">Gas Gatherer</th>
				<th class="table-header">Oil Gatherer</th>
				<th class="table-header">Spud Date</th>
				<th class="table-header">Show on WSB</th>
				<th class="table-header">MD</th>
				<th class="table-header">TVD</th>
				<th class="table-header">Lat.</th>
				<th class="table-header">Long.</th>
				<th class="table-header">Field</th>
				<th class="table-header">Reservoir</th>
				<th class="table-header">Report Frequency</th>
				<th class="table-header">Well File Location</th>
				<th class="table-header">Enity Type</th>
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