<?php
//index.php




?>
<!DOCTYPE html>
<html>
 <head>
  <title>Jquery Fullcalandar Integration with PHP and Mysql</title>
	 <link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	 <!--===============================================================================================-->
  <link rel="stylesheet" href="fullcalendar/packages/core/main.css" />
  <link rel="stylesheet" href="fullcalendar/packages/bootstrap/main.css" />
	 <link rel="stylesheet" href="fullcalendar/packages/list/main.css" />
  <!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	
<!--===============================================================================================-->
	 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
  <script src='fullcalendar/packages/core/main.js'></script>
  <script src='fullcalendar/packages/list/main.js'></script>
  <script src='fullcalendar/packages/interaction/main.js'></script>
  <script src='fullcalendar/packages/daygrid/main.js'></script>
  <script src='fullcalendar/packages/bootstrap/main.js'></script>
<script>
   
  $(document).ready(function () {
    // page is now ready, initialize the calendar...
     $('#calendar').fullCalendar({
        // put your options and callbacks here
        defaultView: 'agendaDay',
        eventBorderColor: "#de1f1f",

         header:
        {  
            left: 'prev,next,today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },

        editable: true,
        selectable: true,

        //When u select some space in the calendar do the following:
        select: function (start, end, allDay) {
            //do something when space selected
            //Show 'add event' modal
            $('#createEventModal').modal('show');
        },

        //When u drop an event in the calendar do the following:
        eventDrop: function (event, delta, revertFunc) {
            //do something when event is dropped at a new location
        },

        //When u resize an event in the calendar do the following:
        eventResize: function (event, delta, revertFunc) {
            //do something when event is resized
        },

        eventRender: function(event, element) {
            $(element).tooltip({title: event.title});             
        },

        //Activating modal for 'when an event is clicked'
        eventClick: function (event) {
            $('#modalTitle').html(event.title);
            $('#modalBody').html(event.description);
            $('#fullCalModal').modal();
        },
    })

      $('#submitButton').on('click', function(e){
            // We don't want this to act as a link so cancel the link action
            e.preventDefault();

            doSubmit();
          });

      function doSubmit(){
        $("#createEventModal").modal('hide');
        $("#calendar").fullCalendar('renderEvent',
            {
                title: $('#eventName').val(),
                start: new Date($('#eventDueDate').val()),

            },
            true);
       }
    });


});

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
<!--	 Load calendars -->
	 <div class="limiter">
		<div class="container-outboard100">
	 		<div class="wrap-login200">
			  <div> <!--class="container"-->
				  <h2 align="center"><a href="#"><img width=20% src="images/SOGLOGO-01.svg" alt="IMG"> <br /></a></h2>
			   <div id="calendar"></div>
			  </div>
		 </div>
		 </div>
	 </div>

<!--	 ##################################################################################################-->
	 <!--PHP CRUD Bootstrap ADD EVENTS Modal->
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
	 <div id="createEventModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span> <span class="sr-only">close</span></button>
                <h4>Add an Event</h4>
            </div>
            <div id="modalBody" class="modal-body">
               <div class="form-group">
                    <input class="form-control" type="text" placeholder="Event Name" id="eventName">
                </div>

                <div class="form-group form-inline">
                    <div class="input-group date" data-provide="datepicker">
                        <input type="text" id="eventDueDate" class="form-control" placeholder="Due Date mm/dd/yyyy">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <textarea class="form-control" type="text" rows="4" placeholder="Event Description" id= "eventDescription"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                <button type="submit" class="btn btn-primary" id="submitButton">Save</button>
            </div>
        </div>
    </div>
</div>
<!--	 ##################################################################################################-->
 </body>
</html>
