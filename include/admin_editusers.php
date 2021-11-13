<?php

// admin_editusers.php
//
// Shows a list of the users on the OutBoard, and lets the admin user
// edit or delete them. Included from admin.php script at appropriate
// time.
// 
// 2005-02-16  richardf - updated to work with OutBoard 2.0
// 2002-04-11  richardf - changed mt_rand() for $unique to uniqid("")
// 2001-06-11  Richard F. Feuerriegel  (richardf@acesag.auburn.edu)

if (! $ob->isAdmin()) { exit; }

$mainscreen = false;  // We are not on the main admin screen

$unique = uniqid("");  // Hack to get around I.E. caching. Trys to make
		       // sure that some URLs are different (enough).

$header = "
  <div class='row adminbar'>
  <div class='col'><p>Del.</p></div>
  <div class='col'><p>Name</p></div>
  <div class='col-3'><p>Hours</p></div>
  <div class='col'><p>User ID</p></div>
  <div class='col'><p>Options</p></div>
  <div class='col'><p>PTO</p></div>
  <!--div class='col'><p>Part Time</p></div-->
  <div class='col'><p>Edit</p></div>
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

<div class="">Editing Users
  <?php echo $header ?>
  <div>
<?php

$count = 0;
if ($ob->getData()) {
  while ($row = $ob->getRow()) {
    $count++;
    if ($count % 15 == 0) { echo $header; }
    $rowid = $row['rowid'];
    echo "<div class='row'>";
    echo "<div class='col'>";
    if (! preg_match("/<ADMIN>/",$row['options'])) {
      $userid = addslashes($row['userid']);
      echo "<a href=\"javascript:deleteConfirm('$userid','$rowid')\">"
	   ."<img src=$image_dir/trash-2.svg border=0></a>";
    } else {
      echo "*";
    }
    echo "</div>";
    echo "<div class='col'>".$row['name']."</div>";
    echo "<div class='col-3'>".$row['hours']."</div>";
    echo "<div class='col'>".$row['userid']."</div>";
    echo "<div class='col'>";
    if (preg_match("/<READONLY>/",$row['options'])) {
      echo "RO |";
    }
    if (preg_match("/<ADMIN>/",$row['options'])) {
      if (preg_match("/<SUPERADMIN>/",$row['options'])){ 
		  echo "Super";
	  } else { echo "Admin "; }
    } else { echo "-------";}
	
	  
    echo "</div>";
	echo "<div class='col'>";
	  if (preg_match("/<ELIGIBLE>/",$row['options'])) {
      echo "Eligible <br />";
    } else { echo "-------";}
	echo "</div>";
	/*echo "<div class='col'>";
	if (preg_match("/<PARTTIME>/",$row['options'])) {
      echo "Part Time <br />";
    }
	echo "</div>";*/
    echo "<div class='col'>";
    echo "<a href=\"${baseurl}?adminscreen=1&editthisuser=$rowid\">"
	 ."<img src=$image_dir/edit.svg border=0></a>";
    echo "</div>";
    echo "</div>\n";
  }
} else {
  // This shouldn't happen because we have an admin user
  echo "There are no users at this time.<p>";
}

?>

<!--</table>-->
</div>
<hr>
<div>
<FORM action="<?php echo $baseurl ?>?editusers=1" method=post>
 
      <input class="navbar-btn" type=submit name=cancel value="Cancel">
  
<FORM>

<p>
<center>* Cannot delete admins</center>

