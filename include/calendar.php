<?php
//index.php
require_once("../lib/OutboardDatabase.php");
require_once("../lib/OutboardAuth.php");

include_once("../include/char_widths.php");
include_once("../include/common.php");

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




?>
<!DOCTYPE html>
<html>
 <head>
  <title>Spindletop Calendar</title>
	 <link rel="stylesheet" type="text/css" href="../css/util.css">
	<link rel="stylesheet" type="text/css" href="../css/main.css">
	 <!--===============================================================================================-->
  <link rel="stylesheet" href="../fullcalendar/packages/core/main.css" />
  <!--link rel="stylesheet" href="../fullcalendar/packages/bootstrap/main.css" /-->
	 <link rel="stylesheet" href="../fullcalendar/packages/list/main.css" />
  <!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="../images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
<!--===============================================================================================-->
	
<!--===============================================================================================-->
	 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
  <script src='../fullcalendar/packages/core/main.js'></script>
  <script src='../fullcalendar/packages/list/main.js'></script>
  <script src='../fullcalendar/packages/interaction/main.js'></script>
  <script src='../fullcalendar/packages/daygrid/main.js'></script>
  <script src='../fullcalendar/packages/bootstrap/main.js'></script>
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
	allDay:true,
    select: function(start, end, allDay)
    {
     var title = prompt("Enter Event Title");
     if(title)
     {
      var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
	  //var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
	  //var all_day = "true";
      $.ajax({
       url:"cal_insert.php",
       type:"POST",
       data:{title:title, start:start, all_day:all_day},
       success:function()
       {
        //calendar.fullCalendar('refetchEvents');
        alert("Added Successfully");
       }
      })
     }
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
       calendar.fullCalendar('refetchEvents');
       alert("Event Updated");
      }
     });
    },
	   ///*
    eventClick:function(calEvent, jsEvent, view)
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
		return false;
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
    },
	   //*/
	   
   });
	  $(".eventContent").click(function() {
            $(".eventContent").css('display', 'none');
        });
var calendarEl = document.getElementById('listcal');

    var calendarlist = new FullCalendar.Calendar(calendarEl, {
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
	  */
	  height: 'parent',
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
		 $('#eventeditmodal').modal('show');
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
	  
  });
   
  </script>
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
 <body>
<!--	 ##################################################################################################-->
<!--	 Add Modals for ADDING and UPDATING events -->
	 
<!--	 ##################################################################################################-->
<!--	 ##################################################################################################-->
<!--	 Load calendars -->
	 <div class="limiter">
		<div class="container-outboard100">
			
	 		<div class="wrap-login200">
				
			  <div> <!--class="container"-->
				  <h2 align="center"><a href="#"><img width=20% src="images/SOGLOGO-01.svg" alt="IMG"> <br /></a></h2>
				  <!--	 Navbar -->
					<div class="navbar" align="center">
					<!--a class="active" href="#">Home</a-->

					  <?php if (! $BasicAuthInUse) { ?>
						 <a href="<?php echo $baseurl ?>?logout=1">Logout</a>
					  <?php } ?>

					  <?php if ($sched_url = $ob->getConfig('schedule_url')) { ?>
						<!--a href="javascript:void(0)"
							onClick="openWindow('scheduleWindow','<?php echo $sched_url ?>',550,600)"><?php echo $ob->getConfig('schedule_name'); ?></a-->
					  <?php } ?>
					  <?php if($ob->isReadonly()) { $readonly = true; } else { $readonly = false; }?>

					 
					  <a href="outboard.php" target=_blank>Outboard</a>

					  <?php if ($ob->isAdmin()) { ?>
						  <a href="approvePTO.php">Approve PTO</a>
					  <?php } ?>
					
					  <?php if ($ob->isEligible()) { ?>
						  <a href="pto.php">PTO Request</a>
					  <?php } else { ?>
						  <a href="to.php">PTO Request</a>
						<?php } ?>

					</div>
			   <div id="calendar"></div><div id="listcal"></div>
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
</html>
