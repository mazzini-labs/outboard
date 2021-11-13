
<nav class="navbar navbar-expand-md fixed-top navbar-dark bg-dark">
	 <?php if($ob->isReadonly()) { $readonly = true; } else { $readonly = false; }?>
 	 <?php if(getGetValue('noupdate')) $update = 0;?>
      <img class="navbar-brand" src="images/Flame.svg" width=3% height=auto></img>
      <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="outboard.php">Outboard</a>
          </li>
          <!-- Timesheets -->
          <li class="nav-item">
			  <?php if ($ob->isAdmin()) { ?>
				  <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href=# id="timesheetdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Timesheets</a>
            <div class="dropdown-menu" aria-labelledby="timesheetdropdown">
          <a class="dropdown-item" href="tcfEmp.php">Personal Timesheet</a>
          <a class="dropdown-item" href="timeclock.php">Select Employee</a>
          <a class="dropdown-item" href="tcfTest.php">All Employee Times</a>
          </div>
          </li>
				<?php } else { ?>
				  <a class="nav-link" href="tcfEmp.php">Timesheet</a>
				<?php } ?>
          </li>
          <!-- View/Update -->
          <li class="nav-item">
			  <?php if (! $update && ! $readonly) { ?>
			  <a class="nav-link" href="outboard.php?update=1#<?php echo $username ?>">Change Status<ALT="Switch to update mode" TITLE="Switch to update mode" BORDER=0></a>
        
			  <?php } elseif (! $readonly) { ?>
			   <a class="nav-link" href="outboard.php?noupdate=1">View Status<ALT="Switch to view only mode" TITLE="Switch to view only mode" BORDER=0></a>
			  <?php } else { echo "&nbsp;"; } ?>
          </li>
          <!-- PTO 
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">PTO</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
				  <?php if ($ob->isEligible()) { ?>
					  <a class="dropdown-item" href="pto.php">PTO Request</a>
				  <?php } ?> 
					<a class="dropdown-item" href="approvePTO.php">Approve PTO</a>
					<a class="dropdown-item" href="calendartest.php">Calendar</a>
            </div>
          </li>-->
          <!-- Admin -->
		 <li class="nav-item">
				  				<?php if ($ob->isAdmin()) { ?>
					  <a class="nav-link" href="outboard.php?adminscreen=1">Admin</a>
				  <?php } ?>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="extensionlist.php">Phone Extensions</a>
      </li>
      <!-- Calendar -->
      <?php if ($ob->isAdmin() || $ob->isSuperAdmin()) { ?>
          <li class="nav-item dropdown ">
          <a class="nav-link dropdown-toggle" href="#" id="calendardropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Calendar</a>
            <div class="dropdown-menu" aria-labelledby="calendardropdown">
          <a class="dropdown-item" href="calendar.php">Calendar</a>
          <a class="dropdown-item" href="cal_admin.php">Edit Calendar</a>
          </div>
          </li>
        <?php } else { ?>
          <li class="nav-item">
          <a class="nav-link" href="calendar.php">Calendar</a>
          </li>
				<?php } ?>
      <!-- WSB -->
		<li class="nav-item active">
			  
           			 <a class="nav-link" href="wsb.php">Well Status Board<span class="sr-only">(current)</span></a>
  			
          </li>
          <!-- Log Out -->
          <!-- <li class="nav-item">
			  
          </li> -->
			
        </ul>
        <form class="form-inline active-white active-white2">
          <div class="md-form my-0">
            <input class="form-control" id="searchProduction" type="text" placeholder="Search wells..." aria-label="Search">
            <i class="fas fa-search text-white ml-3 w-75" aria-hidden="true"></i>
          </div>
        </form>
        <div class=row><div class=col><?php// if (! $BasicAuthInUse) { ?>
          <?php if ($ob->isE1() || $ob->isE2() || $ob->isSuperAdmin() || $ob->isA2()) { ?>
          <a class="nav-link btn btn-info" href="WSB/notes.php">Edit Notes</a>
           			 <!-- <a class="nav-link btn btn-outline-danger" href="<?php echo $baseurl ?>?logout=1">Log Out</a> -->
         <?php } ?>
         <?php // } ?></div></div>
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
   
    