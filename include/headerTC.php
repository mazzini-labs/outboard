<?php

########## This crashes the browser!!!! Do not implement until cause is figured out. 
/* // Show the login screen if the user is not authenticated
if (! $username) {
  $auth->setSessionCookie("",$cookie_time_seconds);
  header("Location: outboard.php"); 
}

// if 'logout' is set, run the logout functions and go back
// to the login screen.
if (getGetValue('logout')) {
  $ob->setSession("");
  $auth->setSessionCookie("",$cookie_time_seconds);
  header("Location: outboard.php"); 
} */
##########
?>
<nav class="navbar navbar-expand-md fixed-top navbar-dark bg-dark" style="margin-bottom: -20px;"> 
	 <?php if($ob->isReadonly()) { $readonly = true; } else { $readonly = false; }?>
 	 <?php if(getGetValue('noupdate')) $update = 0;?>
      <img class="navbar-brand" src="images/Flame.svg" width=3% height=auto></img>
      <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item ">
            <a class="nav-link" href="/outboard.php">Outboard <span class="sr-only">(current)</span></a>
          </li>
          <!-- Timesheets -->
          <?php if ($ob->isAdmin() || $ob->isSuperAdmin()) { ?>
          <li class="nav-item dropdown active">
          <a class="nav-link dropdown-toggle" href=# id="timesheetdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Timesheets</a>
            <div class="dropdown-menu" aria-labelledby="timesheetdropdown">
          <a class="dropdown-item" href="tcfEmp.php">Personal Timesheet</a>
          <a class="dropdown-item" href="timeclock.php">Select Employee</a>
          <a class="dropdown-item" href="tcfTest.php">All Employee Times</a>
          </div>
          </li>
        <?php } else { ?>
          <li class="nav-item active">
          <a class="nav-link" href="tcfEmp.php">Timesheet</a>
          </li>
				<?php } ?>
          
          <!-- PTO -->
          <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="http://example.com/" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">PTO</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
				  <?php if ($ob->isEligible()) { ?>
					  <a class="dropdown-item" href="pto.php">PTO Request</a>
				  <?php } ?> 
					<a class="dropdown-item" href="approvePTO.php">Approve PTO</a>
					<a class="dropdown-item" href="calendartest.php">Calendar</a>
            </div>
          </li> -->
          <!-- Admin -->
		 <li class="nav-item">
				  				<?php if ($ob->isAdmin()) { ?>
					  <a class="nav-link" href="<?php echo $baseurl ?>?adminscreen=1">Admin</a>
				  <?php } ?>
      </li>
      <!-- WSB -->
		 <li class="nav-item">
			  <?php if ($ob->isE1() || $ob->isE2() || $ob->isSuperAdmin()) { ?>
           			 <a class="nav-link" href="wsb.php">Well Status Board</a>
  			 <?php } ?>
          </li> 
          <!-- Log Out -->
          <li class="nav-item">
			  
          </li>
			
        </ul>
        <div class=row><div class=col><?php if (! $BasicAuthInUse) { ?>
           			 <a class="nav-link btn btn-outline-danger" href="<?php echo $baseurl ?>?logout=1">Log Out</a>
  			 <?php } ?></div></div>
			  <span class="navbar-text">

				   <div class="row no-gutters" ><h5><?php echo date($ob->getConfig('caldate_format')) ?>   </h5></div>
				   <div class="row no-gutters"><h5><?php echo date($ob->getConfig('time_format')) ?>   </h5></div>
				
				 
   			  </span>
		<!--<ul class="navbar-nav">
			<div class=container-fluid>
			<div class=row><div class=col><h4 class="nav-link active " ><?php echo date($ob->getConfig('caldate_format')) ?></h4></div></div>

			<div class=row><div class=col><h4 class="nav-link" ><?php echo date($ob->getConfig('time_format')) ?></h4></div></div>
			</div>
		</ul>
        -->
      </div>
		 
    </nav>
   
    