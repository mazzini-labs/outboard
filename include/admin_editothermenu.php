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

?>
<div class="il-limiter">Which would you like to edit?
  <?php echo $header ?>
  <FORM action="<?php echo $baseurl ?>?otherEdit=1" method=post>
 
      <input class="navbar-btn" type=submit name=caEdit value="Edit Common Area Extensions">
  
  <FORM>
  <FORM action="<?php echo $baseurl ?>?otherEdit=2" method=post>
 
 <input class="navbar-btn" type=submit name=compEdit value="Edit Company Contact Information">

  <FORM>
  <FORM action="<?php echo $baseurl ?>?otherEdit=3" method=post>
  
  <input class="navbar-btn" type=submit name=_800Edit value="Edit Company 800 Numbers">

  <FORM>
</div>

<FORM action="<?php echo $baseurl ?>?editusers=1" method=post>
 
      <input class="navbar-btn" type=submit name=cancel value="Cancel">
  
<FORM>

<p>
<center>* Cannot delete admins</center>

