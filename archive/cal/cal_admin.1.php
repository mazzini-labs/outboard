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
	 <!--===============================================================================================-->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/core/main.min.css" integrity="sha512-IBfPhioJ2AoH2nST7c0jwU0A3RJ7hwIb3t+nYR4EJ5n9P6Nb/wclzcQNbTd4QFX1lgRAtTT+axLyK7VUCDtjWA==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/daygrid/main.min.css" integrity="sha512-CN6oL2X5VC0thwTbojxZ02e8CVs7rii0yhTLsgsdId8JDlcLENaqISvkSLFUuZk6NcPeB+FbaTfZorhbSqcRYg==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/timegrid/main.min.css" integrity="sha512-/Jnt6fX98n8zZyuCt4K81+1eQJhWQn/vyMph1UvHywyziYDbu9DFGcJoW8U73m/rkaQBIEAJeoEj+2Rrx4tFyw==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/list/main.min.css" integrity="sha512-tNMyUN1gVBvqtboKfcOFOiiDrDR2yNVwRDOD/O+N37mIvlJY5d5bZ0JeUydjqD8evWgE2cF48Gm4KvQzglN0fg==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/bootstrap/main.min.css" integrity="sha512-mK6wVf3xsmNcJnp0ZI+YORb6jQBsAIIwkOfMV47DHIiwvkSgR0t7GNCVBiotLQWWR8AND/LxWHAatnja1fU7kQ==" crossorigin="anonymous" />
	 <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/maintest.css?=v1.3">
	<link rel="stylesheet" type="text/css" href="css/fc_btn.css?v1.0.0.2">
<!--===============================================================================================-->
		<!-- Bootstrap core CSS -->
    <!-- <link href="WSB/stylesheet/bootstrap.min.css" rel="stylesheet"> -->
	<link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="WSB/stylesheet/offcanvas.css?v1" rel="stylesheet">
	<link href='https://use.fontawesome.com/releases/v5.0.6/css/all.css' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="css/fixed-action-button.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="css/glyphicons.css?v1.0.0.8">
<link rel="stylesheet" type="text/css" href="css/glyphicons.css?v1.0.0.8">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/core/main.min.js" integrity="sha512-bg9ZLPorHGcaLHI2lZEusTDKo0vHdaPOjVOONi4XLJ2N/c1Jn2RVI9qli4sNAziZImX42ecwywzIZiZEzZhokQ==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/daygrid/main.min.js" integrity="sha512-kebSy5Iu+ouq4/swjgEKwa217P2jf/hNYtFEHw7dT+8iLhOKB5PG5xaAMaVyxRK7OT/ddoGCFrg8tslo8SIMmg==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/list/main.min.js" integrity="sha512-Iw4G4+WD3E3F0M+wVZ95nlnifX1xk2JToaD4+AB537HmOImFi79BTtWma57mJeEnK2qNTOgZrYLtAHVsNazzqg==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/interaction/main.min.js" integrity="sha512-9M3YQ9E3hEtjRZSQdU1QADaOGxI+JAzq6bieArw7nIxQbPmn10M7TYxhvJZCuvSjlncJG24l+/e5d1bTRN3m4g==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/timegrid/main.min.js" integrity="sha512-APuj9Rm7J37dj8cRB1qwznH+zrWD7/vkaodDwJVxpdk72m5c9u8mbbdLHn6JnSw5M4AhV8Zb1HnLrNMGoOfR/g==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/moment/main.min.js" integrity="sha512-vRPhNmrqBLazLcQnrmaezKvTfLXlg91HMt830GlhNln3UcIk9Q/ruFkZLwOEIqwQNHBk3CftwtMJOgT9UOURjw==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/bootstrap/main.min.js" integrity="sha512-uuua5cS/LUZHEtZiY2s+SRn0h46TbLZjcaf7fztYqdzM+a0t81kw05yLZSjwF3l3lonm53GZ45rSSzAWAwA5Sg==" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>


  <script type="text/javascript" src="js/fixed-action-button.js"></script>
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
	width: 24px;
	height: 24px;
	color: white;
	stroke-width: 2;
	stroke-linecap: round;
	stroke-linejoin: round;
	fill: none;
}

</style>

<script>
   
   document.addEventListener('DOMContentLoaded', function() {
    var calendarE0 = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarE0, {
        plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'moment' ],
	  
      	header:{
			left:'prevYear,prev,today,next,nextYear',
			center:'title',
			right:'month,agendaWeek,agendaDay'
		},
		defaultView: 'dayGridMonth',
	editable:true,
	   //theme: 'darkly',
	//    navLinks: true, // can click day/week names to navigate views
	//    eventLimit: true, // allow "more" link when too many events
	// events: 'cal_load.php',
	eventSources: 
    [
        // your event source
        {
            url: '/cal_load.php',
        }
            
        // any other sources...
	],
    selectable:true,
	selectHelper:true,
	// allDay:true,
    dateClick: function(arg)
    {
        // date = calendar.getDate().toISOString();
        // console.log(date);
        // console.log(FullCalendar.formatDate(date, "Y-MM-DD"));
        $('#eventaddmodal').modal('show');  
        var m = FullCalendarMoment.toMoment(arg.date, calendar).format("YYYY-MM-DD"); // calendar is required
        $('#de').attr('data-date', m);
		// $('#de').attr('data-date', FullCalendar.formatDate(date, "Y-MM-DD"));
        $('#de').datepicker('update');
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
        $('#insert_form').on("submit", function(event){  
			
			event.preventDefault();  
			
			// console.log($('#cvn'));
			// console.log(drn);
			// console.log(slt);
			// console.log(ts );
			// console.log(te );
			// console.log(ade);

			if ($('#ade').is(":checked")) {
                $('#ade').val("true");
			} else { $('#ade').val("false"); }
			if($('#dev').val() == "")  
			{  
					alert("Date is required");  
			} 
			else if($('#cvn').val() == "")  
			{  
					alert("Title is required");  
			}
			else if($('#slt').val() == "")  
			{  
					alert("Type is required");  
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
						url:"insert.1.php",  
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
							calendar.refetchEvents();
							alert("Added Successfully");
						}  
					});  
			}
		 
		});  
	},
	editable:true,
    eventResize:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var id = event.id;
     $.ajax({
      url:"cal_update.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id},
      success:function(){
       calendar.refetchEvents();
       alert('Event Update');
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
      url:"cal_update.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id},
      success:function()
      {
       calendar.refetchEvents();
       alert("Event Updated");
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
			calendar.refetchEvents();
			alert("Event Deleted");
			}
			//$('#calendar').fullCalendar('removeEvents', event.id);
		});
		}
	},
	selectable:true,
	selectHelper:true,
	// allDay:true,
	eventPositioned: function (info) {
        // info.el.attr('id', info.event.id);
    // console.log(info.el);
    },
    // eventClick: function(info) {
    //     eventToEdit = $("#calendar").FullCalendar('clientEvents', info.event.id);
    //     showEditEventModal(info.event);
    //     $('.saveChanges').on('click',function(e){
    //         e.preventDefault();
    //         info.event.start = $('#eventStart').val();
    //         info.event.end = $('#eventEnd').val();
    //         info.event.title = $('#eventTitle').val();
    //         $('#calendar').FullCalendar('updateEvent', info.event);
    //     });
    // },
	eventClick:  function(info) {
        // $('#modalTitle').html(info.event.title);
        // $('#modalDescription').html(info.event.extendedProps.description);
        // console.log(info.event.title);
        // console.log(info.event.extendedProps.description);
        // $('#eventUrl').attr('href',event.url);
        // var event = calendar.getEventByID(info.event.id); 
        // console.log(event)
        // alert('Event ID: ' + info.event.id);
        // var id = $(info.event.id).attr("id");  
        // console.log(event.getResources()[0].id);

    //    showEditEventModal(info.event.id);
        // $('#id').html(info.event.id);  
        // $('#cvn').html(info.event.title);  
        // $('#drn').html(info.event.remarks); 
        // $('#ade').html(info.event.all_day)
        // $('#ts').html(moment(info.event.time_start).format("hh:mm:ss"));
        // $('#te').html(moment(info.event.time_end).format("hh:mm:ss"));
        // $('#de').attr('data-date', moment(info.event.time_start).format("YYYY-MM-DD"));
        // $('#de').datepicker('update');
        // $('#eventaddmodal').modal('show');  
        // console.log(info.event.id);
        // console.log(info.event.title);
        // console.log(info.event.extendedProps.remarks); 
        // console.log(info.event.extendedProps.all_day); 
        // console.log(info.event.extendedProps.time_start); 
        // console.log(info.event.extendedProps.time_end);
    $.ajax({  
        url:"cal_fetch.php",  
        method:"POST",  
        data:{id:info.event.id},  
        dataType:"json",  
        success:function(data){  
            $('#id').val(data[0].id);  
            $('#cvn').val(data[0].title);  
            $('#drn').val(data[0].remarks); 
            $('#ade').val(data[0].all_day)
            $('#ts').val(moment(data[0].time_start).format("hh:mm:ss"));
            $('#te').val(moment(data[0].time_end).format("hh:mm:ss"));
            $('#de').attr('data-date', moment(data[0].time_start).format("YYYY-MM-DD"));
            $('#de').datepicker('update');
            $('#id').html(data[0].id);  
            // $('#cvn').html(data[0].title);  
            // $('#drn').html(data[0].remarks); 
            // $('#ade').html(data[0].all_day)
            // $('#ts').html(moment(data[0].time_start).format("hh:mm:ss"));
            // $('#te').html(moment(data[0].time_end).format("hh:mm:ss"));
            // console.log(data[0].id);
            // console.log(data[0].title);
            // console.log(data[0].remarks); 
            // console.log(data[0].all_day); 
            // console.log(data[0].time_start); 
            // console.log(data[0].time_end);
            $('#insert').val("Update");  
            $('#eventaddmodal').modal('show');  
            if ($('#ade').val("false")) {
                $('#ade').is(":checked"); 
                $('#ts').prop('disabled', false);
                $('#te').prop('disabled', false);
            } else { 
                $('#ade').val("true");
                $('#ts').prop('disabled', true);
                $('#te').prop('disabled', true);
            }
        }  
    });
       $('#insert_form').on('submit',function(e){
           e.preventDefault();
           calendar.refetchEvents();
           
       });

                
        
    },
    // eventPositioned:function( info ) { 
    //     $(element).attr("id","event_id_"+info.event._id);
    // },
            
    });
    calendar.render();
    
    });
	  $(".eventContent").click(function() {
            $(".eventContent").css('display', 'none');
        });
		$("#calendarTrash").click(function() {
            alert("Drag events here to delete them!");
		});
		// Activate tooltip
		$('[data-toggle="tooltip"]').tooltip();
		// Insert/Edit/View DDR/DSR
		$('#add').click(function(){  
			$('#insert').val("Insert"); 
			$('#insert_form')[0].reset();
			$('#id').val('');
        });
        function cade(){
            if ($('#ade').is(":checked")) {
                $('#ade').val("false"); 
                $('#ts').prop('disabled', false);
                $('#te').prop('disabled', false);
			} else { 
                $('#ade').val("true");
                $('#ts').prop('disabled', true);
				$('#te').prop('disabled', true);
            }
        };
        $('#insert_btnform').on("submit", function(event){  
			
			event.preventDefault();  
			
			// console.log($('#cvn'));
			// console.log(drn);
			// console.log(slt);
			// console.log(ts );
			// console.log(te );
			// console.log(ade);

			if ($('#ade').is(":checked")) {
                $('#ade').val("true");
			} else { $('#ade').val("false"); }
			if($('#dev').val() == "")  
			{  
					alert("Date is required");  
			} 
			else if($('#cvn').val() == "")  
			{  
					alert("Title is required");  
			}
			else if($('#slt').val() == "")  
			{  
					alert("Type is required");  
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
						url:"insert.1.php",  
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
							alert("Added Successfully");
						}  
					});  
			}
		 
		});  

		$(document).on('click', '.edit_cal', function(){  
			var id = $(this).attr("id");  
			$.ajax({  
					url:"cal_fetch.php",  
					method:"POST",  
					data:{id:id},  
					dataType:"json",  
					success:function(data){  
						$('#id').val(data.id);  
						$('#cvn').val(data.title);  
                        $('#drn').val(data.remarks); 
                        $('#ade').val(data.all_day)
                        $('#ts').val(moment(data.time_start).format("hh:mm:ss"));
                        $('#te').val(moment(data.time_end).format("hh:mm:ss"));
                        $('#de').attr('data-date', moment(data.time_start).format("YYYY-MM-DD"));
                        $('#de').datepicker('update');

						$('#insert').val("Update");  
						$('#eventaddmodal').modal('show');  
                        if ($('#ade').val("false")) {
                            $('#ade').is(":checked"); 
                            $('#ts').prop('disabled', false);
                            $('#te').prop('disabled', false);
                        } else { 
                            $('#ade').val("true");
                            $('#ts').prop('disabled', true);
                            $('#te').prop('disabled', true);
                        }
					}  
			});  
		});
        // $('#switch-modal').bootstrapSwitch();
    function showEditEventModal(id){
        $.ajax({  
        		url:"cal_fetch.php",  
        		method:"POST",  
        		data:{id:id},  
        		dataType:"json",  
        		success:function(data){  
        			$('#id').val(data.id);  
        			$('#cvn').val(data.title);  
                    $('#drn').val(data.remarks); 
                    $('#ade').val(data.all_day)
                    $('#ts').val(moment(data.start).format("hh:mm:ss"));
                    $('#te').val(moment(data.start).format("hh:mm:ss"));
                    $('#de').attr('data-date', moment(data.start).format("YYYY-MM-DD"));
                    $('#de').datepicker('update');

        			$('#insert').val("Update");  
        			$('#eventaddmodal').modal('show');  
                    if ($('#ade').val("false")) {
                        $('#ade').is(":checked"); 
                        $('#ts').prop('disabled', false);
                        $('#te').prop('disabled', false);
                    } else { 
                        $('#ade').val("true");
                        $('#ts').prop('disabled', true);
                        $('#te').prop('disabled', true);
                    }
        		}  
        });  
    };

//   });
   
  </script>

<style>
#calendar {
	float: center;
	justify-content: center;
	align: center;
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
 <body>
<!--	 ##################################################################################################-->
<!--	 Add Modals for ADDING and UPDATING events -->
	 
<!--	 ##################################################################################################-->
<!--	 ##################################################################################################-->
<?php include 'header_extensions.php'; ?>
<!--	 Load calendars -->
	<div class="limiter">
		<div class="container-outboard100">
	 		<div class="wrap-login200">
			  <!--<div class="container"-->
				<h2 align="center">
					<a href="#">
						<img width=20% src="images/SOGLOGO-01.svg" alt="IMG" >
						<br />
					</a>
				</h2>
				  
				  <div class="justify-content-center" id="calendar" style='overflow: auto'></div><!-- <div id="listcal"></div> -->
			  <!-- </div> -->
		 	</div>
		</div>
	</div>
<!-- Fixed Action Button -->

<div class="fixed-action-btn" id="calendarTrash"  class="calendar-trash">
					<a class="trash btn btn-light btn-lg">
					<img src="image/trash-2.svg" data-toggle="tooltip" data-placement="left" title="Drag events to me to delete!"/>
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
				
				<form id="insert_form" action="insert.php" method="POST">
					<div class="modal-body">
						<div class="row">
							<div class="col">
							<div id="de" value="" required></div>
							<input type="hidden" id="dev">
							</div>
							<div class="col">
								<div class="form-group">
									<label for="ts">Start Time</label>
									<input type="time" value="08:00" step="600" class="ddr form-control" name="ts" id="ts" required>
								</div>					
								<div class="form-group">
									<label for="te">End Time</label>
									<input type="time" value="08:00" step="600" class="ddr form-control" name="te" id="te" required>
								</div>
								<div class="custom-control custom-switch">
									<input type="checkbox" class="custom-control-input" id="ade" value="">
									<label class="custom-control-label" onClick="cade()" for="ade">All Day Event?</label>
								</div>
							</div>
						</div>

						<div class="ddr-e input-group mb-3">
							<div class="ddr-e input-group-prepend">
								<span class="ddr-e input-group-text">Title</span>
							</div>
							<input name="cvn" id="cvn" type="text" class="ddr-e form-control" placeholder="Enter Title" required>
						</div>
						<div class="ddr-e input-group mb-3">
							<div class="ddr-e input-group-prepend">
								<span class="ddr-e input-group-text">Description</span>
							</div>
							<textarea name="drn" id="drn" class="ddr-e form-control" aria-label="With textarea" placeholder="(Optional)" required></textarea>
						</div>
						
							
						<div class="ddr-e input-group mb-3">
							<div class="ddr-e input-group-prepend">
									<span class="ddr-e input-group-text" for="slt">Type</span>
								</div>
							<!-- <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Type:</label> -->
							<select class="custom-select input-group input-group-sm" id="slt">
								<option selected>Choose...</option>
								<option value="17a2b8">Informational</option>
								<option value="28a745">Holiday</option>
								<option value="eab208">PTO Request</option>
                                <option value="0088cc">Approved PTO</option>
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
	 <!--PHP CRUD Bootstrap EDIT EVENTS Modal>
	 <div class="modal fade" id="eventeditmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
							<input type="text" name="title" class="form-control" placeholder="Enter Title">
						</div>
						<div class="form-group">
							<label>Date</label>
							<input type="text" name="date" class="form-control" placeholder="Enter Title">
						</div>
						<div class="form-group">
							<label>Start Time</label>
							<input type="text" name="stime" class="form-control" placeholder="Enter Title">
						</div>
						<div class="form-group">
							<label>End Time</label>
							<input type="text" name="etime" class="form-control" placeholder="Enter Title">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" name="insertdata" class="btn btn-primary">Save Data</button>
					</div>
					
				</form>
			</div>
		 </div>
	 </div>
<!--	 ##################################################################################################-->
	 
	 <!--	 ##################################################################################################-->
	 <!--TESTING FOR FULLCALENDAR - PHP CRUD Bootstrap EDIT EVENTS Modal-->
	 <div class="modal fade" id="eventeditmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
							<input type="text" name="title" class="form-control" placeholder="Enter Title">
						</div>
						<div class="form-group">
							<label>Date</label>
							<input type="text" name="date" class="form-control" placeholder="Enter Title">
						</div>
						<div class="form-group">
							<label>Start Time</label>
							<input type="text" name="stime" class="form-control" placeholder="Enter Title">
						</div>
						<div class="form-group">
							<label>End Time</label>
							<input type="text" name="etime" class="form-control" placeholder="Enter Title">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" name="insertdata" class="btn btn-primary">Save Data</button>
					</div>
					
				</form>
			</div>
		 </div>
	 </div>
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
</script>
 <!-- Icons -->
<script>
    feather.replace()
</script> 
</html>
