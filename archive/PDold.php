<!--
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
</body>
</html>-->
<script language = "javascript" type = "text/javascript">
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

	   var startchoice = document.getElementById('start').value;
	   var endchoice = document.getElementById('end').value;
	   var reportchoice = $(".message_pri:checked").val();
	   //var userid = document.getElementById('user').value;
	   //var userid = $(".user:checked").val();
		   //document.getElementByName('hsd').value;
	   var queryString = "?startchoice=" + startchoice ;

	   queryString +=  "&endchoice=" + endchoice + "&reportchoice=" + reportchoice;// + "&userid=" + userid;
	   ajaxRequest.open("GET", "EmpTimeclockFunction.php" + queryString, true);
	   ajaxRequest.send(null); 
	}
</script>

<FORM class="" NAME=timeclock METHOD=post ACTION="<?php echo $_SERVER['PHP_SELF'] ?>">
	<div class="input-group date" data-provide="datepicker">
		<input name="startdate" id="start" type="text" class="form-control">
		<div class="input-group-addon">
			<span class="glyphicon glyphicon-calendar"></span>
		</div>
	</div>
<!--
	<div class="input-group date" data-provide="datepicker">
		<input name="enddate" id="end" type="text" class="form-control">
		<div class="input-group-addon">
			<span class="glyphicon glyphicon-calendar"></span>
		</div>
	</div>
-->
	<div class="col">
		<input class="input100" name="partHours" id="hours" type="hours" placeholder="Requested Hours"> 
		<input type = 'button' class="navbar-btn" onclick = 'PD()' value = 'Request'/>
	</div>
</FORM>
	<div id='ajaxDiv'></div>		