<!DOCTYPE html>
<html>
 <head>
  <title>Spindletop Calendar</title>
	 <!--===============================================================================================-->
  <!-- <link rel="stylesheet" href="fullcalendar/packages/core/main.css" /> -->
  <!--link rel="stylesheet" href="fullcalendar/packages/bootstrap/main.css" /-->
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
      function PD(){
	   var ajaxRequest;  // The variable that makes Ajax possible!

	   try {
		  // Opera 8.0+, Firefox, Safari
		  ajaxRequest = new XMLHttpRequest();
	   }catch (e) {
		  // Internet Explorer Browsers
		  try {
			 ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		  }catch (e) {
			 try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			 }catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			 }
		  }
	   }

	   // Create a function that will receive data 
	   // sent from the server and will update
	   // div section in the same page.

	   ajaxRequest.onreadystatechange = function(){
		  if(ajaxRequest.readyState == 4){
			 var ajaxDisplay = document.getElementById('ajaxDiv');
			 ajaxDisplay.innerHTML = ajaxRequest.responseText;
		  }
	   }

	   // Now get the value from user and pass it to
	   // server script.

	   var start = document.getElementById('start').value;
	   var sst = document.getElementById('sst').value;

       var end = document.getElementById('end').value;
       var est = document.getElementById('sst').value;
	   //var reportchoice = $(".message_pri:checked").val();
	   //var userid = document.getElementById('user').value;
	   //var userid = $(".user:checked").val();
           //document.getElementByName('hsd').value;
           var title = document.getElementById('title').value;
          /*  var start = document.getElementById('start').value + " " + document.getElementById('sst').value;
           var end = document.getElementById('end').value + " " + document.getElementById('est').value; */
	   //var queryString = "?startchoice=" + startchoice ;

	   var queryString =  "?title=" + title + "&start=" + start + "&end=" + end + "&sst=" + sst + "&est=" + est;
	   //ajaxRequest.open("GET", "EmpTimeclockFunction.php" + queryString, true);
	   ajaxRequest.open("POST", "insert.php" + queryString, true);
	   ajaxRequest.send(null); 
    }
</script>
  <body>
      <div id="ajaxDiv"></div>
  <div class="modal fade" id="eventaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	 	<div class="modal-dialog" role="document">
		 	<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Event Data</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				
				
			</div>
		 </div>
  </div>
  <form action="test_insert.php" method="POST">
					<div class="modal-body">
						<div class="form-group">
							<label>Title</label>
							<input type="text" id="title" name="title" class="form-control" placeholder="Enter Title">
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
						<button type="button" class="btn btn-primary" onclick="PD()">Add Data</button>
					</div>
					
				</form>
     </body>
</html>
