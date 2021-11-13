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
function datepickerLoad() {
// $("#startdate").datepicker({daysOfWeekDisabled: '06'});
// $("#enddate").datepicker({daysOfWeekDisabled: [0,6]});
}
</script>
<FORM class="" onload="datepickerLoad()" NAME=timeclock METHOD=post ACTION="<?php echo $_SERVER['PHP_SELF'] ?>">
	<label for="start">PTO Start Date</label>
	<!-- <div class="input-group date" data-provide="datepicker" data-date-disabled="0,6"> -->
	<div class="input-group date">
		<input name="startdate" id="startdate" type="text" class="form-control">
		<div class="input-group-addon">
			<span class="glyphicon glyphicon-calendar"></span>
		</div>
	</div>
	<br>

	<label for="start">PTO End Date</label>
	<div class="input-group date">
		<input name="enddate" id="enddate" type="text" class="form-control">
		<div class="input-group-addon">
			<span class="glyphicon glyphicon-calendar"></span>
		</div>
	</div>
	<br>

	<input type = 'button' class="navbar-btn" onclick = 'FD()' value = 'Request'/>
</FORM>

	<div id='ajaxDiv'></div>		