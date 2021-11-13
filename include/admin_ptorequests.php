<?php
if (! $ob->isAdmin()) { exit; }

$mainscreen = false;  // We are not on the main admin screen

$unique = uniqid("");  // Hack to get around I.E. caching. Trys to make
		       // sure that some URLs are different (enough).

$header = "
  <div class='row adminbar'>
  <div class='col'><p>Name</p></div>
  <div class='col'><p>Start Date</p></div>
  <div class='col-3'><p>End Date</p></div>
  <div class='col'><p>Hours Requested</p></div>
  <div class='col'><p>Approve</p></div>
  <div class='col'><p>Deny</p></div>
  </div>
";

?>

<SCRIPT Language="JavaScript1.2">
  function deleteConfirm(user,id,unique) {
    if (confirm("Delete OutBoard user "+user+"?")) {
      mylocation =
	"<?php echo $baseurl ?>?adminscreen=1&deletethisuser="
	  + id 
	  +"&unique=<?php echo $unique ?>";
      self.location = mylocation;
    }
  }
</SCRIPT>

<!--
<table border=0 cellpadding=1 cellspacing=1>
  <tr><th colspan=4 align=center><b>Editing Users</b></th></tr>
-->

<div class="il-limiter">PTO Approval
  <?php echo $header ?>
<?php
if ($ob->getPTOData()) { //could i make a function in outboard database to get the calendar data?
  while ($row = $ob->getRow()) {
    $count++;
    if ($count % 15 == 0) { echo $header; }
    $rowid = $row['rowid'];
    echo "<div class='row'>";
    echo "<div class='col'>".$row['name']."</div>";
    echo "<div class='col'>".$row['start_time']."</div>";
    echo "<div class='col'>".$row['end_time']."</div>";
	echo "<div class='col'>".$row['requested_pto']." Hours</div>";
	  if (preg_match("/<APPROVED>/",$row['options'])) {
		echo "<div class='col'>";
	  	echo "<input type = 'button' class='navbar-btn' disabled>Approved!</button>";
		echo "</div>";
	  }
	  elseif (preg_match("/<DENIED>/",$row['options'])) {
		echo "<div class='col'>";
	  	echo "<input type = 'button' class='navbar-btn' disabled>Denied.</button>";
		echo "</div>";
	  }
	  else {
		echo "<div class='col'>";
		echo "<a href=\"${baseurl}?adminscreen=1&approvePTO=$rowid\" class='navbar-btn'>Approve</a>";
		//echo "<input type='button' onclick='window.location.href = \"${baseurl}?adminscreen=1&approvePTO=$rowid\' class='navbar-btn' value = 'Approve'/>";
		//."<a href=\"${baseurl}?adminscreen=1&approvePTO=$rowid\">";
		echo "</div>";
		echo "<div class='col'>";
		echo "<a href=\"${baseurl}?adminscreen=1&denyPTO=$rowid\" class='navbar-btn'>Deny</a>";
		  //echo "<input type='button' onclick='window.location.href = \"${baseurl}?adminscreen=1&denyPTO=$rowid\" class='navbar-btn' value = 'Deny'/>";

		//echo "<input type = 'button' class='navbar-btn' value = 'Deny'/>"
		//."<a href=\"${baseurl}?adminscreen=1&denyPTO=$rowid\">";
		echo "</div>";
	  }
    
    echo "</div>\n";
  }
} else {
  echo "There are no PTO requests at this time.<p>";
}

?>