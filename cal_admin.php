<?php
//index.php
require_once("lib/OutboardDatabase.php");
require_once("lib/OutboardAuth.php");

include_once("include/char_widths.php");
include_once("include/common.php");

// Create main objects;
$auth = new OutboardAuth();
$ob   = new OutboardDatabase();

$baseurl             = $_SERVER['PHP_SELF'];
$current             = getdate();
$version             = $ob->getConfig('version');
$version_date        = $ob->getConfig('version_date');
$max_visible_length  = $ob->getConfig('max_visible_length');
$cookie_time_seconds = $ob->getConfig('cookie_time_seconds');
$body_bg             = $ob->getConfig('body_bg');
$td_bg               = $ob->getConfig('td_bg');
$td_zebra1           = $ob->getConfig('td_zebra1');
$td_zebra2           = $ob->getConfig('td_zebra2');
$zebra_stripe		 = $ob->getConfig('zebra_stripe');
$td_user_bg          = $ob->getConfig('td_user_bg');
$td_text             = $ob->getConfig('td_text');
$td_lines            = $ob->getConfig('td_lines');
$link_text           = $ob->getConfig('link_text');
$windows_font_family = $ob->getConfig('windows_font_family');
$unix_font_family    = $ob->getConfig('unix_font_family');
$windows_bfs         = $ob->getConfig('windows_bfs');
$unix_bfs            = $ob->getConfig('unix_bfs');
$image_dir           = $ob->getConfig('image_dir');
$change_image        = $ob->getConfig('change_image');
$view_image          = $ob->getConfig('view_image');
$empty_image         = $ob->getConfig('empty_image');
$in_image            = $ob->getConfig('in_image');
$out_image           = $ob->getConfig('out_image');
$dot_image           = $ob->getConfig('dot_image');
$right_arrow         = $ob->getConfig('right_arrow');

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

if (! $ob->isAdmin()) { exit; }
$hr = 0;
$ap = 0;
$a1 = 0;
$a2 = 0;
$e1 = 0;
$e2 = 0;
$la = 0;
$le = 0;
$ge = 0;
$ad = 0;

if ($ob->isHR()) { 
	$hr = true;
} 
if ($ob->isAPspr()) {
	$ap = true;
} 
if ($ob->isA1spr()) { 
	$a1 = true;
} 
if ($ob->isA2spr()) { 
	$a2 = true;
} 
if ($ob->isE1spr()) { 
	$e1 = true;
} 
if ($ob->isE2spr()) { 
	$e2 = true;
} 
if ($ob->isLandspr()) { 
	$la = true;
} 
if ($ob->isLegalspr()) { 
	$le = true;
} 
if ($ob->isGeospr()) { 
	$ge = true;
} 
if ($ob->isADstaffspr()) { 
	$ad = true;
}

?>
<!DOCTYPE html>
<html>
 <head>
 <title>Spindletop Calendar</title>
 <!-- <?php //include 'include/dependencies.php'; ?> -->
  <link rel="stylesheet" href="fullcalendar/packages/core/main.css?" />
  <link rel="stylesheet" href="fullcalendar/packages/daygrid/main.css"></link>
  <link rel="stylesheet" href="fullcalendar/packages/timegrid/main.css"></link>
  <link rel="stylesheet" href="fullcalendar/packages/list/main.css"></link>
  <link rel="stylesheet" href="fullcalendar/packages/bootstrap/main.css" />
	 <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="assets/css/maintest.css?=v1.3">
	<link rel="stylesheet" type="text/css" href="assets/css/fc_btn.css?v1.0.0.2">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="/assets/css/offcanvas.css?v1.0.0.0" rel="stylesheet">
	<link href='https://use.fontawesome.com/releases/v5.0.6/css/all.css' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="assets/css/fixed-action-button.css">
<link rel="stylesheet" type="text/css" href="assets/css/glyphicons.css?v1.0.0.8">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
  <script src='fullcalendar/packages/core/main.js'></script>
  <script src='fullcalendar/packages/list/main.js'></script>
  <script src='fullcalendar/packages/interaction/main.js'></script>
  <script src='fullcalendar/packages/bootstrap/main.js'></script>
  <script type="text/javascript" src="/assets/js/fixed-action-button.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js" integrity="sha512-8vfyGnaOX2EeMypNMptU+MwwK206Jk1I/tMQV4NkhOz+W8glENoMhGyU6n/6VgQUhQcJH8NqQgHhMtZjJJBv3A==" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css"/>
  <script src="https://unpkg.com/feather-icons"></script>
  


<style>
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

.svg 
{
	width: 16px;
	height: 16px;
	color: white;
	stroke-width: 2;
	stroke-linecap: round;
	stroke-linejoin: round;
	fill: none;
}

</style>

<script>
   
$(document).ready(function() {

   var calendar = $('#calendar').fullCalendar({
		header:{
		left:'prevYear,prev,today,next,nextYear',
		center:'title',
		right:'month,agendaWeek,agendaDay'
		},
		editable:true,
		events: 'ajax/cal_load.php',
		
		selectable:true,
		selectHelper:true,
		select: function(start, end, allDay)
		{
			$('#eventaddmodal').modal('show');  
			$('#de').attr('data-date', $.fullCalendar.formatDate(start, "Y-MM-DD"));
			$('#de').datepicker('update');
			// if ($('#ade').is(":checked")) {
			// 	$('#ade').val("false"); 
			// 	$('#ts').prop('disabled', false);
			// 	$('#te').prop('disabled', false);
			// 	} else { 
			// 	$('#ade').val("true");
			// 	$('#ts').prop('disabled', true);
			// 	$('#te').prop('disabled', true);
			// 	}
		// // $('#de').val($.fullCalendar.formatDate(start, "Y-MM-DD"));
		// console.log($('#de').val);
		// var cvn = $('#cvn').val;
		// var drn = $('#drn').val;
		// var slt = $('#slt').val;
		// var ts  = $('#ts').val;
		// var te  = $('#te').val;
		// var ade = $('#ade').val; 

		// var title = prompt("Enter Event Title");
		// if(title)
		// {
			
		// 	var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
			
		// 	//var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
		// 	//var all_day = "true";
		// 	$.ajax({
		// 		url:"insert.php",
		// 		type:"POST",
		// 		data:{title:title, start:start},
		// 		success:function()
		// 		{
		// 			calendar.fullCalendar('refetchEvents');
		// 			alert("Added Successfully");
		// 		}
		// 	})
		// }
		},
		editable:true,
		eventResize:function(event)
		{
		var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
		var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
		var title = event.title;
		var id = event.id;
		$.ajax({
		url:"ajax/cal_date.update.php",
		type:"POST",
		data:{title:title, start:start, end:end, id:id},
		success:function(){
		calendar.fullCalendar('refetchEvents');
		bootbox.alert('Event Update');
		}
		})
		},

		eventDrop:function(event)
		{
		var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
		var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
		var title = event.title;
		var id = event.id;
		$.ajax({
		url:"ajax/cal_date.update.php",
		type:"POST",
		data:{title:title, start:start, end:end, id:id},
		success:function()
		{
		calendar.fullCalendar('refetchEvents');
		bootbox.alert("Event Updated");
		}
		});
		},
		eventDragStop: function(event,jsEvent) {

			var trashEl = jQuery('#calendarTrash');
			var ofs = trashEl.offset();

			var x1 = ofs.left;
			var x2 = ofs.left + trashEl.outerWidth(true);
			var y1 = ofs.top;
			var y2 = ofs.top + trashEl.outerHeight(true);

			if (jsEvent.pageX >= x1 && jsEvent.pageX<= x2 &&
				jsEvent.pageY >= y1 && jsEvent.pageY <= y2) {
				
				var id = event.id;
				$.ajax({
				url:"ajax/cal_delete.php",
				type:"POST",
				data:{id:id},
				success:function()
				{
				calendar.fullCalendar('refetchEvents');
				bootbox.alert("Event Deleted");
				}
				//$('#calendar').fullCalendar('removeEvents', event.id);
			});
			}
		},
		eventRender: function(event, jsEvent, view)
		{
			$(event.el).attr('id', event.id);
		},
		eventClick: function(calEvent, jsEvent, view) {
			eventToEdit = $("#calendar").fullCalendar('clientEvents', calEvent.id);
			console.log($.fullCalendar.formatDate(calEvent.start, "Y-MM-DD"));
			// $('#ede').attr('data-date', $.fullCalendar.formatDate(calEvent.start, "Y-MM-DD"));
			showEditEventModal(calEvent.id, calEvent.start);
			$('.saveChanges').on('click',function(e){
				e.preventDefault();
				calEvent.start = $('#eventStart').val();
				calEvent.end = $('#eventEnd').val();
				calEvent.title = $('#eventTitle').val();
				$('#calendar').fullCalendar('updateEvent', calEvent);
			});
		},

	});
	function showEditEventModal(id, startdate){
			var request = $.ajax({  
        		url:"ajax/cal_fetch_edit.php",  
        		method:"POST",  
        		data:{id:id},  
        		dataType:"json",  
        		success:function(data){
					console.log(data[0].start);
					// var obj = JSON.parse(this.responseText);  
					// console.log(obj.start);
					var start = moment(data[0].start).format("HH:mm:ss");
					var end = moment(data[0].end).format("HH:mm:ss");
					// var start = data[0].start;
					// var end = data[0].end;
					var date = moment(data[0].start).format("YYYY-MM-DD");
					if(start == end || (start == "08:00:00" && end == "Invalid date")){ $('#ade.ecal').is(":checked"); }
					// $('#ede').attr('data-date', $.fullCalendar.formatDate(start, "Y-MM-DD"));
					console.log(start);
					console.log(end);
					console.log(date);
					console.log($('#eid').val());
        			$('#eid').val(data[0].id);  
        			$('#ecvn.ecal').val(data[0].title);  
                    $('#edrn.ecal').val(data[0].description); 
                    $('#eade.ecal').val(data[0].allDay)
                    $('#ets.ecal').val(start);
                    $('#ete.ecal').val(end);
					$('#ede').attr('data-date', date);
					console.log(data[0].color);
					$('#eslt.ecal').val(data[0].color);
                    $('#ede').datepicker('update');
					console.log(data[0].id);  
					console.log(data[0].title);
					console.log(data[0].description);
					console.log(data[0].allDay);
        			$('#insert.ecal').val("Update");  
        			$('#eventeditmodal').modal('show');  
					if ($('#eade.ecal').val() == "false" || $('#eade.ecal').val() == 0) {
						
						$('#ets.ecal').prop('disabled', false);
						$('#ete.ecal').prop('disabled', false);
					} 
					else { 
						// $('#eade.ecal').val("true");
						// $('.ecade').is(":checked"); 
						// $('.ecade').removeClass('custom-control-input:focus:not(:checked)~.custom-control-label::before');
						// $('.ecade').addClass('active');
						$('#eade').prop('checked',true)
                        $('#ets.ecal').prop('disabled', true);
                        $('#ete.ecal').prop('disabled', true);
                    }
        		}  
			});
			request.done(function(msg) {
				console.log( msg );
			});

			request.fail(function(jqXHR, textStatus) {
				console.log( "Request failed: " + textStatus );
			});	
		};
	$(".eventContent").click(function() {
		$(".eventContent").css('display', 'none');
	});
	$("#calendarTrash").click(function() {
		bootbox.alert("Drag events here to delete them!");
	});
	// Activate tooltip
	$('[data-toggle="tooltip"]').tooltip();
	// Insert/Edit/View DDR/DSR
	$('#add').click(function(){  
		$('#insert').val("Insert"); 
		$('#insert_form')[0].reset();
		$('#id').val('');
	});
	$(document).on('click', '#eade', function(){ 
		if ($('#eade').is(":checked")) {
			$('#eade').val("1");
			$('#ets').prop('disabled', true);
			$('#ete').prop('disabled', true);
		} else { 
			$('#eade').val("0"); 
			$('#ets').prop('disabled', false);
			$('#ete').prop('disabled', false);
		}		
	});
	$(document).on('click', '#ade', function(){
		if ($('#ade').is(":checked")) {
			$('#ade').val("1"); 
			$('#ts').prop('disabled', true);
			$('#te').prop('disabled', true);
		} else { 
			$('#ade').val("0");
			$('#ts').prop('disabled', false);
			$('#te').prop('disabled', false);
		}
	});
	$(document).on('click', '.trashcan', function(){
		var id = $('#eid').val();
		$.ajax({
				url:"ajax/cal_delete.php",
				type:"POST",
				data:{id:id},
				success:function()
				{
					calendar.fullCalendar('refetchEvents');
					$('#eventeditmodal').modal('hide');
					bootbox.alert("Event Deleted");
				}
		});
	});
	$('#insert_form').on("submit", function(event){  
		
		event.preventDefault();  
		
		// console.log($('#cvn'));
		// console.log(drn);
		// console.log(slt);
		// console.log(ts );
		// console.log(te );
		// console.log(ade);

		if ($('#ade').is(":checked")) {
			$('#ade').val("1");
		} else { $('#ade').val("0"); }
		if($('#dev').val() == "")  
		{  
				bootbox.alert("Date is required");  
		} 
		else if($('#cvn').val() == "")  
		{  
				bootbox.alert("Title is required");  
		}
		else if($('#slt').val() == "")  
		{  
				bootbox.alert("Type is required");  
		}
				
		else  
		{  
			var cvn = $('#cvn').val();
			var drn = $('#drn').val();
			var slt = $('#slt').val();
			var ts  = $('#dev').val() + " " + $('#ts').val();
			var te  = $('#dev').val() + " " + $('#te').val();
			var ade = $('#ade').val(); 
				$.ajax({  
					url:"ajax/cal_insert.php",  
					method:"POST",
					data: {cvn:cvn, ts:ts, te:te, drn:drn, ade:ade, type:slt},  
					// data: {cvn:$('#cvn').val, ts:$('#ts').val, te:$('#te').val, drn:$('#drn').val, ade:$('#ade').val, type:$('#slt').val},

					// data: $('#insert_form').serialize(),
					beforeSend:function(){  
						$('#insert').val("Inserting");  
					},  
					success:function(data){  
						$('#insert_form')[0].reset();  
						$('#eventaddmodal').modal('hide');  
						calendar.fullCalendar('refetchEvents');
						bootbox.alert("Added Successfully");
					}  
				});  
		}
		
	});
	$('#einsert_form').on("submit", function(event){  
		
		event.preventDefault();  
		
		// console.log($('#cvn'));
		// console.log(drn);
		// console.log(slt);
		// console.log(ts );
		// console.log(te );
		// console.log(ade);

		if ($('#eade').is(":checked")) {
			$('#eade').val("1");
		} else { $('#eade').val("0"); }
		if($('#edev').val() == "")  
		{  
				bootbox.alert("Date is required");  
		} 
		else if($('#ecvn').val() == "")  
		{  
				bootbox.alert("Title is required");  
		}
		else if($('#eslt').val() == "")  
		{  
				bootbox.alert("Type is required");  
		}
				
		else  
		{  
			var id = $('#eid').val();
			var cvn = $('#ecvn').val();
			var drn = $('#edrn').val();
			var slt = $('#eslt').val();
			var ts  = $('#edev').val() + " " + $('#ets').val();
			var te  = $('#edev').val() + " " + $('#ete').val();
			var ade = $('#eade').val(); 
				$.ajax({  
					url:"ajax/cal_full.update.php",  
					method:"POST",
					data: {id:id, cvn:cvn, ts:ts, te:te, drn:drn, ade:ade, type:slt},  
					beforeSend:function(){  
						$('#insert').val("Updating...");  
					},  
					success:function(data){  
						$('#einsert_form')[0].reset();  
						$('#eventeditmodal').modal('hide');  
						calendar.fullCalendar('refetchEvents');
						bootbox.alert("Updated Successfully");
					}  
				});  
		}
		
	});    
	function deleteEvent(){
		$.ajax({
				url:"ajax/cal_delete.php",
				type:"POST",
				data:{id:id},
				success:function()
				{
				calendar.fullCalendar('refetchEvents');
				$('#eventeditmodal').modal('hide');
				bootbox.alert("Event Deleted");
				  
				}
			});
	};

  });
   
  </script>
<!-- FullCalendar v5 Script in progress -->
<script>
	/*
		document.addEventListener('DOMContentLoaded', function() {
    var calendarE0 = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarE0, {
      headerToolbar:{
        left:'prevYear,prev,today,next,nextYear',
        center:'title',
        right:'dayGridMonth,timeGridWeek,timeGridDay'
      },
      initialView: 'dayGridMonth',
      themeSystem: 'bootstrap',
      height: "70vh",
	  dayMaxEventRows: true, // allow "more" link when too many events
	//   events: 'cal_load.php',
	  eventSources: 
		[
		// your event source
		{
			url: '/cal_load_pto.php',
			method: 'POST',
			extraParams: 
			{
				hr: <?php echo $hr; ?>,
				'ap': <?php echo $ap; ?>,
				'a1': <?php echo $a1; ?>,
				'a2': <?php echo $a2; ?>,
				'e1': <?php echo $e1; ?>,
				'e2': <?php echo $e2; ?>,
				'la': <?php echo $la; ?>,
				'le': <?php echo $le; ?>,
				'ge': <?php echo $ge; ?>,
				'ad': <?php echo $ad; ?>
				// hr : getElementById("hr"),
				// ap : getElementById("ap"),
				// a1 : getElementById("a1"),
				// a2 : getElementById("a2"),
				// e1 : getElementById("e1"),
				// e2 : getElementById("e2"),
				// la : getElementById("la"),
				// le : getElementById("le"),
				// ge : getElementById("ge"),
				// ad : getElementById("ad")
				// isSuper: 'something',
				// custom_param2: 'somethingelse'
			},
			
			failure: function() 
			{
				alert('there was an error while fetching events!');
			}
		},
		{
			url: '/cal_load.php',
		}
		
	  // any other sources...
	  ],
	  select: function(start, end, allDay)
		{
			$('#eventaddmodal').modal('show');  
			$('#de').attr('data-date', $.fullCalendar.formatDate(start, "Y-MM-DD"));
			$('#de').datepicker('update');
		},
		editable:true,
		eventResize:function(event)
		{
		var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
		var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
		var title = event.title;
		var id = event.id;
		$.ajax({
		url:"cal_date.update.php",
		type:"POST",
		data:{title:title, start:start, end:end, id:id},
		success:function(){
		calendar.fullCalendar('refetchEvents');
		bootbox.alert('Event Update');
		}
		})
		},

		eventDrop:function(event)
		{
		var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
		var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
		var title = event.title;
		var id = event.id;
		$.ajax({
		url:"cal_date.update.php",
		type:"POST",
		data:{title:title, start:start, end:end, id:id},
		success:function()
		{
		calendar.fullCalendar('refetchEvents');
		bootbox.alert("Event Updated");
		}
		});
		},
		eventDragStop: function(event,jsEvent) {

			var trashEl = jQuery('#calendarTrash');
			var ofs = trashEl.offset();

			var x1 = ofs.left;
			var x2 = ofs.left + trashEl.outerWidth(true);
			var y1 = ofs.top;
			var y2 = ofs.top + trashEl.outerHeight(true);

			if (jsEvent.pageX >= x1 && jsEvent.pageX<= x2 &&
				jsEvent.pageY >= y1 && jsEvent.pageY <= y2) {
				
				var id = event.id;
				$.ajax({
				url:"cal_delete.php",
				type:"POST",
				data:{id:id},
				success:function()
				{
				calendar.fullCalendar('refetchEvents');
				bootbox.alert("Event Deleted");
				}
				//$('#calendar').fullCalendar('removeEvents', event.id);
			});
			}
		},
		eventRender: function(event, jsEvent, view)
		{
			$(event.el).attr('id', event.id);
		},
		eventClick: function(calEvent, jsEvent, view) {
			eventToEdit = $("#calendar").fullCalendar('clientEvents', calEvent.id);
			console.log($.fullCalendar.formatDate(calEvent.start, "Y-MM-DD"));
			// $('#ede').attr('data-date', $.fullCalendar.formatDate(calEvent.start, "Y-MM-DD"));
			showEditEventModal(calEvent.id, calEvent.start);
			$('.saveChanges').on('click',function(e){
				e.preventDefault();
				calEvent.start = $('#eventStart').val();
				calEvent.end = $('#eventEnd').val();
				calEvent.title = $('#eventTitle').val();
				$('#calendar').fullCalendar('updateEvent', calEvent);
			});
		},
    });
    calendar.render();
  });	
	*/
</script>
<style>
#calendar {
	float: center;
	justify-content: center;
	/* align: center; */
	/* width: 70%; */
	max-width: 900 px;
	display: table-cell;
    /* margin: 20px; */
  }	 
#listcal {
    float: left;
	width: 25%;
    margin: 0 20px 20px 0;
  }	 
/* .trash {
	background-image: url("image/trash-2.svg");
} */
</style>



 </head>
 <body style="background-color: #0e5092;">
<!--	 ##################################################################################################-->
<!--	 Add Modals for ADDING and UPDATING events -->
	 
<!--	 ##################################################################################################-->
<!--	 ##################################################################################################-->
<?php include 'include/header_extensions.php'; ?>
<!--	 Load calendars -->
	<!-- <div class="limiter"> -->
		<div class="container-fluid">
		<div class="row justify-content-center">
	 		<div class="col-6 m-2 p-3 shadow-lg card-body bg-light" style="height:80vh;">
				<!-- <h2 align="center">
					<a href="#">
						<img width=20% src="images/SOGLOGO-01.svg" alt="IMG" >
						<br />
					</a>
				</h2> -->
				  
				  <div class="justify-content-center" id="calendar" style='overflow: auto'></div><!-- <div id="listcal"></div> -->
			  <!-- </div> -->
		 	</div>
		</div>
	<!-- </div> -->
<!-- Fixed Action Button -->

<div class="fixed-action-btn" id="calendarTrash"  class="calendar-trash">
					<a class="trash btn btn-light btn-lg">
					<img src="assets/images/trash-2.svg" data-toggle="tooltip" data-placement="left" title="Drag events to me to delete!"/></a>
				  </div>
<!-- Fixed Action Button -->
<!--	 ##################################################################################################-->
	 <!--popup with info-->
	 <div id="eventContent" class="eventContent" style="display: none; border: 1px solid #005eb8; position: absolute; background: #fcf8e3; width: 30%; opacity: 1.0; padding: 4px; color: #005eb8; z-index: 2000; line-height: 1.1em;">
    <a style="float: right;"><i class="fa fa-times closeEvent" aria-hidden="true"></i></a><br />
    Event: <span id="eventTitle" class="eventTitle"></span><br />
    Start: <span id="startTime" class="startTime"></span><br />
    End: <span id="endTime" class="endTime"></span><br /><br />
	</div>
<!--	 ##################################################################################################-->
	 
<!--	 comes from this video https://www.youtube.com/watch?v=mh4MVFiMZTM-->
	 <!--PHP CRUD Bootstrap ADD EVENTS Modal-->
	 <div class="modal fade" id="eventaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	 	<div class="modal-dialog" role="document">
		 	<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Event Data</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				
				<form id="insert_form" method="POST">
					<div class="modal-body">
						<div class="row">
							<div class="col">
							<div id="de" value="" required></div>
							<input type="hidden" id="dev">
							</div>
							<div class="col">
								<div class="form-group">
									<label for="ts">Start Time</label>
									<input type="time" value="08:00" step="300" class="ddr form-control" name="ts" id="ts" required>
								</div>					
								<div class="form-group">
									<label for="te">End Time</label>
									<input type="time" value="08:00" step="300" class="ddr form-control" name="te" id="te" required>
								</div>
								<div class="custom-control custom-switch">
									<input type="checkbox" class="custom-control-input" id="ade" value="">
									<label class="cade custom-control-label" for="ade">All Day Event?</label>
								</div>
							</div>
						</div>

						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">Title</span>
							</div>
							<input name="cvn" id="cvn" type="text" class="form-control" placeholder="Enter Title" required>
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">Description</span>
							</div>
							<textarea name="drn" id="drn" class="form-control" aria-label="With textarea" placeholder="(Optional)"></textarea>
						</div>
						
							
						<div class="input-group mb-3">
							<div class="input-group-prepend">
									<span class="input-group-text" for="slt">Type</span>
								</div>
							<!-- <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Type:</label> -->
							<select class="custom-select input-group input-group-sm" id="slt" required>
								<option value="" disabled selected hidden>Choose...</option>
								<option value="#17a2b8">Informational</option>
								<option value="#28a745">Holiday</option>
								<option value="#eab208">Time Off Request</option>
                                <option value="#0088cc">Approved Time Off</option>
							</select>
						</div>
						
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" name="insert" id="insert" value="Insert" class="btn btn-primary">Save Data</button>
					</div>
					
				</form>
			</div>
		 </div>
	 </div>
<!--	 ##################################################################################################-->
	 
<!--	 ##################################################################################################-->
	 <!--PHP CRUD Bootstrap EDIT EVENTS Modal-->
	 <div class="ecal modal fade" id="eventeditmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	 	<div class="ecal modal-dialog" role="document">
		 	<div class="ecal modal-content">
				<div class="ecal modal-header">
					<h5 class="ecal modal-title" id="exampleModalLabel">Edit Event Data</h5>
					<button type="button" class="ecal close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					
					
				</div>
				
				<form id="einsert_form" method="POST">
				<input type="hidden" value="" id="eid">
					<div class="ecal modal-body">
						<div class="ecal row">
							<div class="ecal col">
							<div id="ede" value="" required></div>
							<input type="hidden" id="edev">
							</div>
							<div class="ecal col">
								<div class="ecal form-group">
									<label for="ets">Start Time</label>
									<input type="time" value="08:00" step="300" class="ecal ddr form-control" name="ets" id="ets" required>
								</div>					
								<div class="ecal form-group">
									<label for="ete">End Time</label>
									<input type="time" value="08:00" step="300" class="ecal ddr form-control" name="ete" id="ete" required>
								</div>
								<div class="ecal custom-control custom-switch">
									<input type="checkbox" class="ecal custom-control-input" id="eade" value="">
									<label class="ecal ecade custom-control-label" for="eade">All Day Event?</label>
								</div>
							</div>
						</div>

						<div class="ecal input-group mb-3">
							<div class="ecal input-group-prepend">
								<span class="ecal input-group-text">Title</span>
							</div>
							<input name="cvn" id="ecvn" type="text" class="ecal form-control" placeholder="Enter Title" required>
						</div>
						<div class="ecal input-group mb-3">
							<div class="ecal input-group-prepend">
								<span class="ecal input-group-text">Description</span>
							</div>
							<textarea name="drn" id="edrn" class="ecal form-control" aria-label="With textarea" placeholder="(Optional)"></textarea>
						</div>
						
							
						<div class="ecal input-group mb-3">
							<div class="ecal input-group-prepend">
									<span class="ecal input-group-text" for="slt">Type</span>
								</div>
							<!-- <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Type:</label> -->
							<select class="ecal custom-select input-group input-group-sm" id="eslt" required>
								<option value="" disabled selected hidden>Choose...</option>
								<option value="#17a2b8">Informational</option>
								<option value="#28a745">Holiday</option>
								<option value="#eab208">Time Off Request</option>
                                <option value="#0088cc">Approved Time Off</option>
							</select>
							<div class="invalid-feedback">
								Please select a type.
							</div>
						</div>
						
						
					</div>
					<div class="ecal modal-footer">
						<button type="button" class="trash trashcan btn btn-danger btn-lg">
							<!-- <img src="assets/images/trash-2.svg" data-toggle="tooltip" data-placement="left" title="Drag events to me to delete!"/> -->
							<i data-feather="trash-2"></i>
						</button>
						<button type="button" class="ecal btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" name="einsert" id="einsert" value="Insert" class="ecal btn btn-primary">Save Data</button>
					</div>
					
				</form>
			</div>
		 </div>
	 </div>
<!--	 ##################################################################################################--><!--	 ##################################################################################################-->
	 
	 <!--	 ##################################################################################################-->
	 <!--TESTING FOR FULLCALENDAR - PHP CRUD Bootstrap EDIT EVENTS Modal-->
	 <!-- <div class="modal fade" id="eventedidtmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	 	<div class="modal-dialog" role="document">
		 	<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Event Data</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					
				</div>
				
				<form action="update.php" method="POST">
					<div class="modal-body">
						<div class="form-group">
							<label>Title</label>
							<input type="text" name="title" class="form-control" placeholder="Enter Title" required>
						</div>
						<div class="form-group">
							<label>Date</label>
							<input type="text" name="date" class="form-control" placeholder="Enter Date" required>
						</div>
						<div class="form-group">
							<label>Start Time</label>
							<input type="text" name="stime" class="form-control" placeholder="Start Time" required>
						</div>
						<div class="form-group">
							<label>End Time</label>
							<input type="text" name="etime" class="form-control" placeholder="End Time" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" name="insertdata" class="btn btn-primary">Save Data</button>
					</div>
					
				</form>
			</div>
		 </div>
	 </div> -->
<!--	 ##################################################################################################-->
 </body>
 <div class="toggle-btn"></div>
 <script src="assets/js/datepicker-full.js"></script>
<script>
$("#de").datepicker({
	format: "yyyy-mm-dd"
});
$('#de').on('changeDate', function() {
	$('#dev').val(
		$('#de').datepicker('getFormattedDate')
	);
	
});
$("#ede").datepicker({
	format: "yyyy-mm-dd"
});
$('#ede').on('changeDate', function() {
	$('#edev').val(
		$('#ede').datepicker('getFormattedDate')
	);
	
});
</script>
 <!-- Icons -->
<script>
    feather.replace()
</script> 
</html>
