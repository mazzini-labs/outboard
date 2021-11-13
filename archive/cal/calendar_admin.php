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



?>
<!DOCTYPE html>
<html>
 <head>
  <title>Spindletop Calendar</title>
	 <!--===============================================================================================-->
  <link rel="stylesheet" href="fullcalendar/packages/core/main.css" />
  <link rel="stylesheet" href="fullcalendar/packages/bootstrap/main.css" />
	 <link rel="stylesheet" href="fullcalendar/packages/list/main.css" />
	 <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/maintest.css?=v1.2">
<!--===============================================================================================-->
		<!-- Bootstrap core CSS -->
    <link href="WSB/stylesheet/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="WSB/stylesheet/offcanvas.css?v1" rel="stylesheet">
	
<!--===============================================================================================-->
<link rel="stylesheet" href="https://unpkg.com/@fullcalendar/core@4.4.2/main.min.css">
  <link rel="stylesheet" href="https://unpkg.com/@fullcalendar/daygrid@4.4.2/main.min.css">
  <link rel="stylesheet" href="https://unpkg.com/@fullcalendar/timegrid@4.4.2/main.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css"/>
  <link rel="stylesheet" type="text/css" href="css/glyphicons.css?v1.0.0.7">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/fullcalendar.min.js"></script> -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
  <!-- <script src='https://unpkg.com/@fullcalendar/core/main.js'></script>
  <script src='https://unpkg.com/@fullcalendar/list/main.js'></script>
  <script src='https://unpkg.com/@fullcalendar/interaction/main.js'></script>
  <script src='https://unpkg.com/@fullcalendar/daygrid/main.js'></script>
  <script src='https://unpkg.com/@fullcalendar/bootstrap/main.js'></script> -->
 
  <script src='fullcalendar/packages/core/main.js'></script>
  <script src='fullcalendar/packages/list/main.js'></script>
  <script src='fullcalendar/packages/interaction/main.js'></script>
  <script src='fullcalendar/packages/daygrid/main.js'></script>
  <script src='fullcalendar/packages/bootstrap/main.js'></script>
<script>
   
   $(document).ready(function() {
    var calendar = $('#calendar').fullCalendar({
    editable:true,
    header:{
     left:'prev,next today',
     center:'title',
     right:'month,agendaWeek,agendaDay'
    },
	   //theme: 'darkly',
	   navLinks: true, // can click day/week names to navigate views
	   eventLimit: true, // allow "more" link when too many events
    events: 'cal_load.php',
    selectable:true,
    selectHelper:true,
    select: function(start, end, allDay)
    {
	 //var title = prompt("Enter Event Title");
	 $("#eventaddmodal").modal('show');
	 var title = $("#title").val();
	 var start = $("#start").val() + " " + $("#sst").val();
	 var end = $("#end").val() + " " + $("#est").val();
	 $('#insertdata').on('click', function(e) {
			e.preventDefault();
			$.ajax({
				url:"insert.php",
			type:"POST",
			data:{title:title, start:start, end:end},
			success:function()
			{
				//calendar.fullCalendar('refetchEvents');
				alert("Added Successfully");
				$("#eventaddmodal").modal('hide');
			},
				error: function() {
					alert('Error');
				}
			});
			return false;
		});
	 /* if(title)
     {
      $.ajax({
       url:"insert.php",
       type:"POST",
       data:{title:title, start:start, end:end},
       success:function()
       {
        //calendar.fullCalendar('refetchEvents');
		alert("Added Successfully");
		$("#eventaddmodal").modal('hide');
       }
      })
     } */
    },
    editable:true,
    eventResize:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var id = event.id;
     $.ajax({
      url:"update.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id},
      success:function(){
       calendar.fullCalendar('refetchEvents');
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
      url:"update.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id},
      success:function()
      {
       //calendar.fullCalendar('refetchEvents');
       alert("Event Updated");
      }
     });
    },
	   ///*
    /* eventClick:function(calEvent, jsEvent, view)
    {
		var stime = calEvent.start.format('MM/DD/YYYY, h:mm a');
		var etime = calEvent.end.format('MM/DD/YYYY, h:mm a');
		var eTitle = calEvent.title;
		var xpos = jsEvent.pageX;
		var ypos = jsEvent.pageY;
		$(".eventTitle").html(eTitle);
		$(".startTime").html(stime);
		$(".endTime").html(etime);
		$(".eventContent").css('display', 'block');
		$(".eventContent").css('left', '25%');
		$(".eventContent").css('top', '30%');
		return false;  */


		//TODO: js that will pull a popup with all of the info needed to create an event
		//pto after form submission send to calendar as REQUESTED PTO: nemployee then ADMIN=1 users can accept
		/*
     if(confirm("Are you sure you want to remove it?"))
     {
      var id = event.id;
      $.ajax({
       url:"delete.php",
       type:"POST",
       data:{id:id},
       success:function()
       {
        calendar.fullCalendar('refetchEvents');
        alert("Event Removed");
       }
      })
     }
	 */
     /* },  */
	   //*/
	   
   }); 
	  // $(".eventContent").click(function() {
        //    $(".eventContent").css('display', 'none');
        }); 
/* var calendarEl = document.getElementById('listcal');

    var calendarlist = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'list' ],
		 */
		/*
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'listDay,listWeek,dayGridMonth'
      },

      // customize the button names,
      // otherwise they'd all just say "list"
      views: {
        listDay: { buttonText: 'list day' },
        listWeek: { buttonText: 'list week' }
      },
	  */
/* 	  height: 'parent',
		//aspectRatio: .5,
      defaultView: 'listWeek',
      //defaultDate: '2020-02-12',
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      events: 'cal_load.php',
		//testing edit modal using eventClick
	eventClick:function(event)
    {
		 jQuery('#eventeditmodal').modal('show');
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var id = event.id;
     $.ajax({
      url:"update.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id},
      success:function()
      {
       calendar.fullCalendar('refetchEvents');
       alert("Event Updated");
      }
     });
    },
		
    });

    calendarlist.render();
	  //.editBtn would be a button class in HTML which allows a click on said button to activate it
	  $('.editBtn').on('click',function(){
		  $('#eventeditmodal').modal('show');
		  	$tr = $(this).closest('tr');
		  
		  var data= $tr.children("td").map(function() {
			  return $(this).text();
		  }).get();
		  console.log(data);
		  $('#update_id').val(data[0]);
		  $('#title').val(data[1]);
		  $('#date').val(data[2]);
		  $('#stime').val(data[3]);
		  $('#etime').val(data[4]);
	  });
	  
  }); */

  </script>
<!--
<script>
    $(document).ready(function () {

        //---------------------Full Calendar--------------------------------------
        /* $.post('cal_load.php',
                function (data) {

                    //alert(data); 
					var calendarEl = document.getElementById('#calendar');

    				var calendar = new FullCalendar.Calendar(calendarEl, {
                    //var calendar = $('#calendar').fullCalendar({
						// plugins: [ 'dayGrid' ],
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,agendaWeek,agendaDay,listMonth'
                        },

                        defaultDate: new Date(),
                        navLinks: true, // can click day/week names to navigate views
                        businessHours: true, // display business hours
                        editable: true,
                        //events: $.parseJSON(data),
						events: function(start, end, timezone, callback) {
							$.post('cal_load.php',
							{ "start": start.format("YYYY-MM-DD"), "end": end.format("YYYY-MM-DD") },
							function (data) {
								callback($.parseJSON(data));
							});
						},
                        dayClick: function (date, jsEvent, view) {

                            date_last_clicked = $(this);
                            $(this).css('background-color', '#bed7f3');
                            $('#eventaddmodal').modal();

                        },

                        minTime: "08:30:00",
                        maxTime: "23:00:00"

                    });


                }); */

        //--------------END  fullcalendar-----------------

        //---INSERT-----------------------------

        $("#btn_insert").click(function () {
			$("#eventaddmodal").modal('show');
			var title = $("#title").val();
			var start = $("#start").val() + " " + $("#sst").val();
			var end = $("#end").val() + " " + $("#est").val();
			


			$.ajax({
			url: "insert.php",
			type: 'post',
			data: {"title": title, "start": start, "end": end},
			success: function (response) {
				$("#eventaddmodal").modal('hide');
				//$("#modal_confirmar").modal('show');
				//render an event object direct to the calendar
				// $("#calendar").fullCalendar('renderEvent', { "id": id, "title": title, "start": start, "end": end});
			}
			});
		});

        //---END Insert-----------------------------

    });
</script>
-->
<script>
/*
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('listcal');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'list' ],
		
		/*
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'listDay,listWeek,dayGridMonth'
      },

      // customize the button names,
      // otherwise they'd all just say "list"
      views: {
        listDay: { buttonText: 'list day' },
        listWeek: { buttonText: 'list week' }
      },
	  
	  height: 'auto',
      defaultView: 'listWeek',
      //defaultDate: '2020-02-12',
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      events: 'load.php'
    });

    calendar.render();
  });	

/*
$(document).ready(function()) {
  var listcal = $('#listcal').fullCalendar(calendarEl, {
  plugins: [ 'list' ],
  defaultView: 'listWeek',
	events: 'load.php',
  eventRender: function(info) {
	if (info.event.extendedProps.status === 'done') {

	  // Change background color of row
	  info.el.style.backgroundColor = 'red';

	  // Change color of dot marker
	  var dotEl = info.el.getElementsByClassName('fc-event-dot')[0];
	  if (dotEl) {
		dotEl.style.backgroundColor = 'white';
	  }
	}
  }

  });
}
*/
	 
</script>
<style>
#calendar {
    float: left;
    width: 70%;
    margin: 20px;
  }	 
#listcal {
    float: left;
	width: 25%;
    margin: 0 20px 20px 0;
  }	 
</style>



 </head>
 <body style="background-color: #0e5092;">
<!--	 ##################################################################################################-->
<!--	 Add Modals for ADDING and UPDATING events -->
	 
<!--	 ##################################################################################################-->
<!--	 ##################################################################################################-->
<?php include 'include/headerAdmin.php'; ?>
<!--	 Load calendars -->
	 <div class="limiter">
		<div class="container-fluid">
			<div class="row justify-content-center">
	 		<div class="col-6 m-2 p-3 shadow-lg card-body bg-light">
				
			  <div> <!--class="container"-->
				  <h2 align="center"><a href="#"><img width=20% src="images/SOGLOGO-01.svg" alt="IMG"> <br /></a></h2><button class="btn btn-primary" id="#btn_insert">BUTTON</button>
			   <div class="justify-content-center" id="calendar" style='overflow: auto'></div><!-- <div id="listcal"></div> -->
			  </div>
</div>
		 </div>
		 </div>
	 </div>
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
	 <div class="modal fade" id="#eventeditmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
						<!-- <div class="form-group">
							<label>Date</label>
							<input type="text" name="date" class="form-control" placeholder="Enter Title">
						</div> -->
						<div class="form-group">
							<label>Start Time</label>
							<input type="text" name="start" class="form-control" placeholder="Enter Title">
						</div>
						<div class="form-group">
							<label>End Time</label>
							<input type="text" name="end" class="form-control" placeholder="Enter Title">
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
	 <!--PHP CRUD Bootstrap EDIT EVENTS Modal>-->
	 <div class="modal fade" id="eventaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	 	<div class="modal-dialog" role="document">
		 	<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Event Data</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				
				<form action="insert.php" method="POST">
					<div class="modal-body">
						<div class="form-group">
							<label>Title</label>
							<input type="text" name="title" class="form-control" placeholder="Enter Title">
						</div>
						<!-- <div class="form-group">
							<label>Date</label>
							<input type="text" name="date" class="form-control" placeholder="Enter Title">
						</div> -->
						<div class="form-row">
							<div class="col-6">
							<label for="start">Start Date</label>
								<div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
									<input name="startdate" id="start" type="text" class="form-control">
									<div class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
											<label for="sst">Start Time</label>
											<input type="time" value="08:00" step="600" class="form-control" id="sst"  placeholder="Start Time">

								</div>
							</div>
						</div>
						<br>
						<div class="form-row">
							<div class="col-6">
							<label for="end">End Date</label>
								<div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
									<input name="enddate" id="end" type="text" class="form-control">
									<div class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
											<label for="sst">Start Time</label>
											<input type="time" value="09:00" step="600" class="form-control" id="est"  placeholder="End Time">

								</div>
							</div>
						</div>	
						<!-- <div class="form-group">
							<label>Start Time</label>
							<input type="text" name="start" class="form-control" placeholder="Enter Title">
						</div>
						<div class="form-group">
							<label>End Time</label>
							<input type="text" name="end" class="form-control" placeholder="Enter Title">
						</div> -->
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" name="insertdata" class="btn btn-primary">Add Data</button>
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
					<h5 class="modal-title" id="exampleModalLabel">Edit Event Data</h5>
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
</html>
