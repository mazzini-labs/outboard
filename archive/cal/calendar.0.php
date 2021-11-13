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
  <link rel="stylesheet" href="fullcalendar/packages/core/main.css" />
  <link rel="stylesheet" href="fullcalendar/packages/daygrid/main.css"></link>
  <link rel="stylesheet" href="fullcalendar/packages/timegrid/main.css"></link>
  <link rel="stylesheet" href="fullcalendar/packages/list/main.css"></link>
  <link rel="stylesheet" href="fullcalendar/packages/bootstrap/main.css" />
	 <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/maintest.css?=v1.3">
	<link rel="stylesheet" type="text/css" href="css/fc_btn.css?v1.0.0.2">
<!--===============================================================================================-->
		<!-- Bootstrap core CSS -->
    <link href="WSB/stylesheet/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="WSB/stylesheet/offcanvas.css?v1" rel="stylesheet">
	<link href='https://use.fontawesome.com/releases/v5.0.6/css/all.css' rel='stylesheet'>
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="css/glyphicons.css?v1.0.0.8">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/core/main.min.js" integrity="sha512-bg9ZLPorHGcaLHI2lZEusTDKo0vHdaPOjVOONi4XLJ2N/c1Jn2RVI9qli4sNAziZImX42ecwywzIZiZEzZhokQ==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/daygrid/main.min.js" integrity="sha512-kebSy5Iu+ouq4/swjgEKwa217P2jf/hNYtFEHw7dT+8iLhOKB5PG5xaAMaVyxRK7OT/ddoGCFrg8tslo8SIMmg==" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/list/main.min.css" integrity="sha512-tNMyUN1gVBvqtboKfcOFOiiDrDR2yNVwRDOD/O+N37mIvlJY5d5bZ0JeUydjqD8evWgE2cF48Gm4KvQzglN0fg==" crossorigin="anonymous" /> -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
  <script src='fullcalendar/packages/core/main.js'></script>
  <script src='fullcalendar/packages/list/main.js'></script>
  <script src='fullcalendar/packages/interaction/main.js'></script>
  
  <script src='fullcalendar/packages/bootstrap/main.js'></script>

<!-- <link rel="stylesheet" href="https://unpkg.com/@fullcalendar/core@4.4.2/main.min.css">
  <link rel="stylesheet" href="https://unpkg.com/@fullcalendar/daygrid@4.4.2/main.min.css">
  <link rel="stylesheet" href="https://unpkg.com/@fullcalendar/timegrid@4.4.2/main.min.css"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css"/>
 

<script>
   
  $(document).ready(function() {
   var calendar = $('#calendar').fullCalendar({
    header:{
     left:'prevYear,prev,today,next,nextYear',
     center:'title',
     right:'month,agendaWeek,agendaDay'
	},
	editable:true,
	   //theme: 'darkly',
	    navLinks: true, // can click day/week names to navigate views
	    eventLimit: true, // allow "more" link when too many events
	// events: 'cal_load.php',
	eventSources: 
	[
	// your event source
		{
			url: '/cal_load_pto.php',
			method: 'POST',
			extraParams: 
			{
				hr: <?php echo "'".$hr."'"; ?>,
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
    selectable:true,
	selectHelper:true,
	allDay:true,
	eventClick:  function(event, jsEvent, view) {
                    $('#modalTitle').html(event.title);
                    $('#modalBody').html(event.description);
                    // $('#eventUrl').attr('href',event.url);
                    $('#fullCalModal').modal();
                    return false;
				},
				
   });

  });
   
  </script>
  <script type="text/javascript">
    $(function () {
        $("[rel='tooltip']").tooltip();
    });
</script>
<script>
// 	document.addEventListener('DOMContentLoaded', function() {
//     var calendarEl = document.getElementById('calendar');

//     var calendar = new FullCalendar.Calendar(calendarEl, {
//       plugins: [ 'dayGridPlugin' ],
		
		
//       header: {
//         left: 'prev,next',
//         center: 'title',
//         right: ''
//       },

//       // customize the button names,
//       // otherwise they'd all just say "list"
//       views: {
//         listDay: { buttonText: 'list day' },
//         listWeek: { buttonText: 'list week' }
//       },
	  
// 	  height: 'auto',
//     //   defaultView: 'dayGridMonth',
//       //defaultDate: '2020-02-12',
//       navLinks: true, // can click day/week names to navigate views
//       editable: true,
//       eventLimit: true, // allow "more" link when too many events
// 	//   events: 'cal_load.php',
// 		eventSources: 
// 		[
// 		// your event source
// 		{
// 			url: '/cal_load_pto.php',
// 			method: 'POST',
// 			extraParams: 
// 			{
// 				hr: <?php echo "'".$hr."'"; ?>,
// 				'ap': <?php echo $ap; ?>,
// 				'a1': <?php echo $a1; ?>,
// 				'a2': <?php echo $a2; ?>,
// 				'e1': <?php echo $e1; ?>,
// 				'e2': <?php echo $e2; ?>,
// 				'la': <?php echo $la; ?>,
// 				'le': <?php echo $le; ?>,
// 				'ge': <?php echo $ge; ?>,
// 				'ad': <?php echo $ad; ?>
// 				// hr : getElementById("hr"),
// 				// ap : getElementById("ap"),
// 				// a1 : getElementById("a1"),
// 				// a2 : getElementById("a2"),
// 				// e1 : getElementById("e1"),
// 				// e2 : getElementById("e2"),
// 				// la : getElementById("la"),
// 				// le : getElementById("le"),
// 				// ge : getElementById("ge"),
// 				// ad : getElementById("ad")
// 				// isSuper: 'something',
// 				// custom_param2: 'somethingelse'
// 			},
			
// 			failure: function() 
// 			{
// 				alert('there was an error while fetching events!');
// 			}
// 		},
// 		{
// 			url: '/cal_load.php',
// 		}
		
// 	// any other sources...
// 	],
//     });

//     calendar.render();
//   });	
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('listcal');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'list' ],
		
		
      header: {
        left: 'prev,next',
        center: 'title',
        right: ''
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
	  events: 'cal_load.php',
	  
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
<?php include 'include/header_extensions.php'; ?>
<!-- Hidden inputs for viewing -->
	<input type="hidden" id="hr" value="<?php echo $hr; ?>">
	<input type="hidden" id="ap" value="<?php echo $ap; ?>">
	<input type="hidden" id="a1" value="<?php echo $a1; ?>">
	<input type="hidden" id="a2" value="<?php echo $a2; ?>">
	<input type="hidden" id="e1" value="<?php echo $e1; ?>">
	<input type="hidden" id="e2" value="<?php echo $e2; ?>">
	<input type="hidden" id="la" value="<?php echo $la; ?>">
	<input type="hidden" id="le" value="<?php echo $le; ?>">
	<input type="hidden" id="ge" value="<?php echo $ge; ?>">
	<input type="hidden" id="ad" value="<?php echo $ad; ?>">

<!--	 Load calendars -->
	 <div class="limiter">
		<div class="container-outboard100">
			
	 		<div class="wrap-login200">
				
			  <div> <!--class="container"-->
				  <h2 align="center"><a href="#"><img width=20% src="images/SOGLOGO-01.svg" alt="IMG"> <br /></a></h2>
				  
			   <div class="justify-content-center" id="calendar" style='overflow: auto'></div><div id="listcal"></div>
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
<div id="fullCalModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
				<h4 id="modalTitle" class="modal-title"></h4>
                    <button type="button" class="close justify-content-right" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                    
                </div>
                <div id="modalBody" class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <!-- <a class="btn btn-primary" id="eventUrl" target="_blank">Event Page</a> -->
                </div>
            </div>
        </div>
    </div>
 </body>
</html>
