<?php 

//$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
// echo $_SERVER['SERVER_NAME'];
// echo "<br>" . $_SERVER['REQUEST_URI'];
// echo $url;
$buttons = '<div class=row><div class=col>
<div class="btn-group btn-group-sm"><a class="nav-link btn btn-outline-danger btn-xs" href="outboard.php?logout=1">Log Out  <i data-feather="log-out"></i> </a></div></div></div>';
switch($url)
{
  case (preg_match("/notes.php/i", "$url")):
    $wsbactive = 'active';
    $search = 'Search wells...';
    $searchbar = '<form class="form-inline active-white active-white2">
                  <div class="md-form my-0">
                    <input class="form-control" id="searchProduction" type="text" placeholder="'.$search.'" aria-label="Search">
                    <i class="fas fa-search text-white ml-3 w-75" aria-hidden="true"></i>
                  </div>
                </form>
    ';
   
    
    
    
  break;
  case strpos($url, 'http://vprsrv2/outboard.php?adminscreen=1'):
    $adminactive = 'active';
  break;
  case strpos($url,'/outboard.php'):
    $outboardactive = 'active';
    #$changeupdate = '<li class="nav-item">';
    #if (! $update && ! $readonly) { $changeupdate .= "<a class=\"nav-link\" href=\"/outboard.php?update=1#".$username."\">Change Status<ALT=\"Switch to update mode\" TITLE=\"Switch to update mode\" BORDER=0></a>"; } 
    #elseif (! $readonly) { $changeupdate .= "<a class=\"nav-link\" href=\"/outboard.php?noupdate=1\">View Status<ALT=\"Switch to view only mode\" TITLE=\"Switch to view only mode\" BORDER=0></a>"; } 
    #else { echo "&nbsp;"; } 
    #$changeupdate .= "</li>";
  break;
  case strpos($url,'http://vprsrv2/outboard.dt.php'):
    $outboardactive = 'active';
    $searchbar = '<div class="bg-dark pr-4">
    <h5 class="text-white">Business Hours: 8AM–5PM</h5></div>';
    /* $searchbar = '<span class="navbar-text">
                  Navbar text with an inline element
                </span>'; */
  break;
  case strpos($url,'http://vprsrv2/calendar.php'):
    $calendaractive = 'active';
  break;
  case strpos($url,'http://vprsrv2/cal_admin'):
    $calendaractive = 'active';
    $buttons = '<div class=row><div class=col>
    <div class="btn-group btn-group-sm input-group">
      
      <a class="nav-link btn btn-outline-danger" href="outboard.php?logout=1">Log Out</a>
    </div>
    </div></div>';	
    // <a class="nav-link btn btn-info" name="add" id="add" href="#eventaddmodal" data-toggle="modal">Add Event [Not Functioning]</a>
  break;
  
  case strpos($url,'http://vprsrv2/tcfEmp.php'):
    $timesheetactive = 'active';
  break;
  case strpos($url,'http://vprsrv2/timeclock.php'):
    $timesheetactive = 'active';
  break;
  case strpos($url,'http://vprsrv2/tcfTest.php'):
    $timesheetactive = 'active';
  break;
  case (strpos($url,'http://vprsrv2/extensionlist.php')):
    $extensionactive = 'active';
    $search = 'Search extensions...';
    $searchbar = '<form class="form-inline active-white active-white2">
                  <div class="md-form my-0">
                    <input class="form-control" id="searchProduction" type="text" placeholder="'.$search.'" aria-label="Search">
                    <i class="fas fa-search text-white ml-3 w-75" aria-hidden="true"></i>
                  </div>
                </form>
    ';
  break;
  case (strpos($url,'http://vprsrv2/wsb.php')):
    $wsbactive = 'active';
    $search = 'Search wells...';
    $searchbar = '<form class="form-inline active-white active-white2">
                  <div class="md-form my-0">
                    <input class="form-control" id="searchProduction" type="text" placeholder="'.$search.'" aria-label="Search">
                    <i class="fas fa-search text-white ml-3 w-75" aria-hidden="true"></i>
                  </div>
                </form>
    ';
   
    if ($ob->isE1() || $ob->isE2() || $ob->isSuperAdmin() || $ob->isA2()) { 
      $buttons = '<div class=row><div class=col>
                     <div class="btn-group btn-group-sm">
                       <a class="nav-link btn btn-info" href="notes.php">Edit Notes</a>
                       <a class="nav-link btn btn-outline-danger btn-xs" href="outboard.php?logout=1">Log Out</a>
                     </div>
                     </div></div>';	}
    
    
  break;
  //case (strpos($url,'/notes.php')):
  
  case (strpos($url,'http://vprsrv2/prod_data.php')):
    $wsbactive = 'active';
    $search = 'Search...';
    $searchbar = '<form class="form-inline active-white active-white2">
                  <div class="md-form my-0">
                    <input class="form-control" id="searchProduction" type="text" placeholder="'.$search.'" aria-label="Search">
                    <i class="fas fa-search text-white ml-3 w-75" aria-hidden="true"></i>
                  </div>
                </form>
    ';
    if ($ob->isE1() || $ob->isE2() || $ob->isSuperAdmin() || $ob->isA2()) { 
      $buttons = '<div class=row><div class=col>
                     <div class="btn-group btn-group-sm input-group">
                       <a class="nav-link btn btn-info" href="WSB/notes.php">Edit Notes</a>
                       <a class="nav-link btn btn-outline-danger" href="outboard.php?logout=1">Log Out</a>
                     </div>
                     </div></div>';	}
    /* $wsbbuttons = '<div class=row><div class=col>
      <?php if ($ob->isE1() || $ob->isE2() || $ob->isSuperAdmin() || $ob->isA2()) { ?>
      
        <div class="btn-group btn-group-sm">
        <a name="add" id="add" href="#add_data_Modal" class="btn btn-success" data-toggle="modal"><span>Add New Entry</span></a>
        <a class="nav-link btn btn-info" href="WSB/notes.php">Edit Notes</a>
        </div>	
     <?php } ?>
     </div></div>
    <?php else
    { ?>
      <a class="nav-link btn btn-info" href="WSB/notes.php">Edit Notes</a>
      <?php } ?>
    '; */
  break;
  default:
    $outboardactive = 'active';
    #$changeupdate = '<li class="nav-item">';
    #if (! $update && ! $readonly) { $changeupdate .= "<a class=\"nav-link\" href=\"/outboard.php?update=1#".$username."\">Change Status<ALT=\"Switch to update mode\" TITLE=\"Switch to update mode\" BORDER=0></a>"; } 
    #elseif (! $readonly) { $changeupdate .= "<a class=\"nav-link\" href=\"/outboard.php?noupdate=1\">View Status<ALT=\"Switch to view only mode\" TITLE=\"Switch to view only mode\" BORDER=0></a>"; } 
    #else { echo "&nbsp;"; } 
    #$changeupdate .= "</li>";
break;
}
?>

<nav class="navbar navbar-expand-md navbar-scroller navbar-dark bg-dark shadow-lg"> 
	 <?php if($ob->isReadonly()) { $readonly = true; } else { $readonly = false; }?>
 	 <?php if(getGetValue('noupdate')) $update = 0;?>
      <img class="navbar-brand" src="images/Flame.svg" width=3% height=auto></img>
      <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item <?php echo $outboardactive; ?>">
            <a class="nav-link" href="/outboard.php">Outboard <span class="sr-only">(current)</span></a>
          </li>
          <!-- Timesheets -->
          <?php if ($ob->isAdmin() || $ob->isSuperAdmin()) { ?>
          <li class="nav-item dropdown <?php echo $timesheetactive; ?>">
          <a class="nav-link dropdown-toggle" href=# id="timesheetdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Timesheets</a>
            <div class="dropdown-menu" aria-labelledby="timesheetdropdown">
          <a class="dropdown-item" href="tcfEmp.php">Personal Timesheet</a>
          <a class="dropdown-item" href="timeclock.php">Select Employee</a>
          <a class="dropdown-item" href="tcfTest.php">All Employee Times</a>
          </div>
          </li>
        <?php } else { ?>
          <li class="nav-item <?php echo $timesheetactive; ?>">
          <a class="nav-link" href="tcfEmp.php">Timesheet</a>
          </li>
				<?php } ?>
          
          <!-- View/Update -->
          <?php echo $changeupdate; ?>
          
          <!-- PTO -->
          <!-- NOTE: LINES 139 AND 150 ARE TO BE REMOVED WHEN TESTING IS COMPLETE -->
          <?php if ($ob->isSuperAdmin()) { ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="http://example.com/" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">PTO</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
				  <?php if ($ob->isEligible()) { ?>
					  <a class="dropdown-item" href="pto.php">PTO Request</a>
				  <?php } ?> 
					<a class="dropdown-item" href="approvePTO.php">Approve PTO</a>
					<a class="dropdown-item" href="calendartest.php">Calendar</a>
            </div>
          </li>
          <?php } ?> 
          <!-- Admin -->
		 <li class="nav-item <?php echo $adminactive; ?>">
				  				<?php if ($ob->isAdmin()) { ?>
					  <a class="nav-link" href="/outboard.php?adminscreen=1">Admin</a>
				  <?php } ?>
      </li>
      <li class="nav-item <?php echo $extensionactive; ?>">
          <a class="nav-link" href="/extensionlist.php">Phone Extensions</a>
      </li>
      <!-- Calendar -->
      <?php if ($ob->isAdmin() || $ob->isSuperAdmin()) { ?>
          <li class="nav-item dropdown <?php echo $calendaractive; ?>">
          <a class="nav-link dropdown-toggle" href="#" id="calendardropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Calendar</a>
            <div class="dropdown-menu" aria-labelledby="calendardropdown">
          <a class="dropdown-item" href="calendar.php">Calendar</a>
          <a class="dropdown-item" href="cal_admin.php">Edit Calendar</a>
          </div>
          </li>
        <?php } else { ?>
          <li class="nav-item <?php echo $calendaractive; ?>">
          <a class="nav-link" href="/calendar.php">Calendar</a>
          </li>
				<?php } ?>
      <!-- WSB -->
		 <li class="nav-item <?php echo $wsbactive; ?>">
			  <?php //if ($ob->isE1() || $ob->isE2() || $ob->isSuperAdmin()) { ?>
           			 <a class="nav-link" href="wsb.php">Well Status Board</a>
  			 <?php //} ?>
          </li> 
          <!-- Log Out -->
          <li class="nav-item">
			  
          </li>
			
        </ul>
        <?php echo $searchbar; ?>
        <?php echo $buttons; ?>
        <!-- <div class=row><div class=col><?php if (! $BasicAuthInUse) { ?>
           			 <a class="nav-link btn btn-outline-danger btn-xs" href="<?php echo $baseurl ?>?logout=1">Log Out</a>
  			 <?php } ?></div></div> -->
			  <span class="navbar-text">

				   <div class="row no-gutters" ><h6><?php echo date($ob->getConfig('caldate_format')) ?>   </h6></div>
				   <div class="row no-gutters"><h6><?php echo date($ob->getConfig('time_format')) ?>   </h6></div>
				
				 
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
<script type="text/javascript">
    $(document).ready(function () {
        var url = window.location;
        $('ul.nav a[href="'+ url +'"]').parent().addClass('active');
        $('ul.nav a').filter(function() {
             return this.href == url;
        }).parent().addClass('active');
    });
</script> 