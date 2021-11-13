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
 
</script>

<FORM class="" NAME=timeclock METHOD=post ACTION="<?php echo $_SERVER['PHP_SELF'] ?>">
	<label for="start">PTO Date</label>
	<div class="input-group date">
		
		<input name="startdate" id="startdate" type="text" class="form-control">
		<div class="input-group-addon">
			<span class="glyphicon glyphicon-calendar"></span>
		</div>
	</div>
<br>

		<div class="form-group">
					<label for="sst">PTO Start Time</label>
<!--					<input type="time" value="08:00" min="8:00" max="17:00" step="600" class="form-control" id="sst"  placeholder="Start Time">-->
					<input type="time" value="08:00" step="600" class="form-control" id="sst"  placeholder="Start Time">

		</div>

		<div class="form-group">
					<label for="selecthours">Requested Hours</label>
<!--					<input type="hours" class="form-control" id="selecthours" placeholder="Start Time">-->
					<select class="form-control form-control-lg" id="selecthours" type="text" placeholder=".form-control-lg">
					  <option>1</option>
					  <option>1.5</option>
					  <option>2</option>
					  <option>2.5</option>
					  <option>3</option>
					  <option>3.5</option>
					  <option>4</option>
					  <option>4.5</option>
					  <option>5</option>
					  <option>5.5</option>
					  <option>6</option>
					  <option>6.5</option>
					  <option>7</option>
					  <option>7.5</option>
					</select>
		</div>
<!--		<input class="input100" name="partHours" id="selecthours" type="hours" placeholder="Requested Hours"> -->
		
		<input type = 'button' class="navbar-btn" onclick = 'PD()' value = 'Request'/>
	</div>
</FORM>
	<div id='ajaxDiv'></div>		