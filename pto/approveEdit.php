
<?php
include 'include/wsbFunctions.php';

require_once("lib/OutboardConfig.php");
require_once("lib/OutboardDatabase.php");
require_once("lib/OutboardAuth.php");

include_once("include/char_widths.php");
include_once("include/common.php");

include "include/mail_finalapproval.php";
//include "include/mail_confirmation.php";

$auth = new OutboardAuth();
$ob   = new OutboardDatabase();
$session = $auth->getSessionCookie();
$username = $ob->getSession($session);

// $name = $_REQUEST['name'];
if ($editPTO = getGetValue('editPTO')){
	$rowid = $editPTO;
	$ob->getPTOByID($rowid); //see if i can make one for getting data from pto_request?
	$row = $ob->getRow();
	$userid = $row['userid'];
	$start = $row['start_time'];
	$end = $row['end_time'];
	$name = $row['name'];
	$request = $row['requested_pto'];
	console_log($request);
	$options = $row['options'];
	$title = $row['title'];
	$department = $row['department'];
		$mailStartTime = date('n/j/y g:ia', strtotime($start));
		$mailEndTime = date('n/j/y g:ia', strtotime($end));
		$in_time = date('g:ia',strtotime($end));
		$out_time = date('g:ia',strtotime($start));
	$result = 0;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Edit PTO Request for <?php echo $name; ?></title>
<?php include 'include/dependencies.php'; ?>
</head>
<body style="background-color: #0e5092;">
<?php include 'include/header_extensions.php'; ?>
<?php

if (isset($_POST['submit']))
{
	$start = $_REQUEST['startdate'];
	$end = $_REQUEST['enddate'];
	$request = $_REQUEST['request'];
	
// 	$stmt = "UPDATE pto_request SET "
//   ."start_time='$start', end_time='$end', requested_pto='$request',"
//   ."WHERE rowid='$rowid'";
	$stmt = "UPDATE pto_request SET start_time='".$start."', end_time='".$end."', requested_pto='".$request."' WHERE id='$rowid'";
	
	$result = mysql_query($stmt) or die(mysql_error());

	echo '
	<div class="container-fluid">
	<div class="carded mt-5 mx-auto col-7 ">
		<div class="justify-content-center my-5">
		<div class="mx-auto row">
			<div class="col">User PTO Updated:</div>
			<div class="col">'.$name.'</div>
		</div>
		<div class="mx-auto row">
			<div class="col">Start Time:</div>
			<div class="col">'.$start.'</div>
		</div>
		<div class="mx-auto row">
			<div class="col">End Time:</div>
			<div class="col">'.$end.'</div>
		</div>
		<div class="mx-auto row">
			<div class="col">Requested Hours:</div>
			<div class="col">'.$request.'</div>
		</div>
		';
	if($_REQUEST['fromPTO'] > 0){ 
		echo "<div class=\"col\"><a class='btn btn-block btn-secondary' href=\"pto.php\">Return to PTO Requests</a></div>";
	} 
	else {
		echo '
		<div class="mx-auto row">
			<div class="col"><a href="approvePTO.php" class="btn btn-primary">Return to Approve PTO</a></div>
			<br />
			<div class="col"><a href="outboard.php" class="btn btn-secondary">Return to Outboard</a></div>
		</div>
		</div>
	</div>
</div>';
	}
	
} 
else {
?>
<form action="<?php echo $PHP_SELF?>" enctype="multipart/form-data" method="post" name="form">

<div class="container-fluid">
	<div class="carded mt-5 mx-auto col-7 ">
		<div class="justify-content-center my-5">
			<div class="row card-img-top mx-auto">
				<div class="col">
					<h2><img src="images/SOGLOGO-01.svg" alt="IMG" width="20%"> <br />
				Edit PTO Request for <?php echo $name; ?></h2>
				</div>
			</div>
			<label for="startdate">Start Date</label>
			<div class="input-group date">
				<input name="startdate" id="startdate" type="search" class="form-control" value="<?php echo $start ?>">
				<div class="input-group-addon">
					<span class="glyphicon glyphicon-calendar"></span>
				</div>
			</div>
			<br>

			<label for="enddate">End Date</label>
			<div class="input-group date">
				<input name="enddate" id="enddate" type="search" class="form-control" value="<?php echo $end ?>">
				<div class="input-group-addon">
					<span class="glyphicon glyphicon-calendar"></span>
				</div>
			</div>
			<br>
			<label for="request">Requested Hours</label>
			<div class="input-group">
				<input name="request" id="request" type="text" class="form-control" value="<?php echo $request ?>">
			</div>
			<br>
			<!-- <div class="mx-auto row">
				<div class="col">Start Time:</div>
				<div class="col"><input class="input200" type=text name=start placeholder="Start Time" size=20 maxlength=50 value="<?php echo $start ?>"></div>
			</div>
			<div class="mx-auto row">
				<div class="col">End Time:</div>
				<div class="col"><input class="input200" type=text name=end placeholder="End Time" size=20 maxlength=50 value="<?php echo $end ?>"></div>
			</div>
			<div class="mx-auto row">
				<div class="col">Requested Hours:</div>
				<div class="col"><input class="input200" type=text name=request placeholder="Requested Hours" size=20 maxlength=50 value="<?php echo $request ?>"></div>
			</div> -->
			
			<div class="mx-auto navbar">
				  <!-- <div class="col"><a href="approveDeny.php?rowid=<?php // echo $rowid ?>&choice=Approved" class='approve'>Approve</a></div> -->
				  <!-- <div class="col"><a href="approveDeny.php?rowid=<?php // echo $rowid ?>&choice=Denied" class='deny'>Deny</a></div>  -->
				  <!-- <div class="col"><a href="approveDeny.php?rowid=<?php //echo $rowid ?>&choice=Update&start=<?php// echo $start ?>&end=<?php //echo $end ?>&request=<?php //echo $request ?>" class='navbar'>Update</a></div>  -->
				<div class="col"><button class='btn btn-block btn-info' type="Submit" name="submit" value="update">Update</button></div>
				<?php if($_REQUEST['fromPTO'] > 0){ echo "<div class=\"col\"><a class='btn btn-block btn-secondary' href=\"pto.php\">Return to PTO Requests</a></div>";} else {echo "";} ?>
			</div>
		</div>
	</div>
</div>
</form>
	<?php 
		}
	?>
			

</body>
</html>