<?php 
function active($correct_page){
  $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
  $url = end($url_array);  
  if(preg_match("/$correct_page/", "$url")){
      // echo 'active'; //class name in css 
      return true;
  } 
}
//$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
// echo $_SERVER['SERVER_NAME'];
// echo "<br>" . $_SERVER['REQUEST_URI'];
// echo $url;
$buttons = '<div class="row mr-1"><div class=col>
<div class="btn-group btn-group-sm"><a class="nav-link btn btn-outline-danger btn-xs" href="outboard.php?logout=1">Log Out  <i data-feather="log-out"></i> </a></div></div></div>';
switch($url)
{
  case (active('notes.REST.full.php')):
    $wsbactive = 'active';
    $search = 'Search wells...';
    $searchbar = '<form class="form-inline active-white active-white2">
                  <div class="md-form my-0">
                    <input class="form-control" id="searchProduction" type="text" placeholder="'.$search.'" aria-label="Search">
                    <i class="fas fa-search text-white" aria-hidden="true"></i></input>
                  </div>
                </form>
    ';
   
    
    
    
  break;
  case (active('outboard.php?adminscreen=1')):
  // case strpos($url, 'http://vprsrv2/outboard.php?adminscreen=1'):
    $adminactive = 'active';
  break;
  case (active('outboard.php')):
  // case strpos($url,'/outboard.php'):
    $outboardactive = 'active';
    $outboardactive = 'active';
    $searchbar = '<div class="bg-dark pr-4">
    <h5 class="text-white">Business Hours: 8AM–5PM</h5></div>';
    #$changeupdate = '<li class="nav-item">';
    #if (! $update && ! $readonly) { $changeupdate .= "<a class=\"nav-link\" href=\"/outboard.php?update=1#".$username."\">Change Status<ALT=\"Switch to update mode\" TITLE=\"Switch to update mode\" BORDER=0></a>"; } 
    #elseif (! $readonly) { $changeupdate .= "<a class=\"nav-link\" href=\"/outboard.php?noupdate=1\">View Status<ALT=\"Switch to view only mode\" TITLE=\"Switch to view only mode\" BORDER=0></a>"; } 
    #else { echo "&nbsp;"; } 
    #$changeupdate .= "</li>";
  break;
  case (active('outboard.dt.php')):
  // case strpos($url,'http://vprsrv2/outboard.dt.php'):
    $outboardactive = 'active';
    $searchbar = '<div class="bg-dark pr-4">
    <h5 class="text-white">Business Hours: 8AM–5PM</h5></div>';
    /* $searchbar = '<span class="navbar-text">
                  Navbar text with an inline element
                </span>'; */
  break;
  case (active('calendar.php')):
  // case strpos($url,'http://vprsrv2/calendar.php'):
    $calendaractive = 'active';
  break;
  case (active('cal_admin.php')):
  // case strpos($url,'http://vprsrv2/cal_admin'):
    $calendaractive = 'active';
    $buttons = '<div class=row><div class=col>
    <div class="btn-group btn-group-sm input-group">
      
      <a class="nav-link btn btn-outline-danger" href="outboard.php?logout=1">Log Out</a>
    </div>
    </div></div>';	
    // <a class="nav-link btn btn-info" name="add" id="add" href="#eventaddmodal" data-toggle="modal">Add Event [Not Functioning]</a>
  break;
  case (active('tcfEmp.php')):
  // case strpos($url,'http://vprsrv2/tcfEmp.php'):
    $timesheetactive = 'active';
  break;
  case (active('timeclock.php')):
  // case strpos($url,'http://vprsrv2/timeclock.php'):
    $timesheetactive = 'active';
  break;
  case (active('tcfTest.php')):
  // case strpos($url,'http://vprsrv2/tcfTest.php'):
    $timesheetactive = 'active';
  break;
  case (active('vault.vprsrv.org')):
    // case strpos($url,'http://vprsrv2/tcfTest.php'):
      $vaultactive = 'active';
    break;
  case (active('wiki.vprsrv.org')):
    // case strpos($url,'http://vprsrv2/tcfTest.php'):
      $wikiactive = 'active';
  break;
  case (active('extensionlist.php')):
  // case (strpos($url,'http://vprsrv2/extensionlist.php')):
    $extensionactive = 'active';
    $search = 'Search extensions...';
    $searchbar = '<form class="form-inline active-white active-white2">
                  <div class="md-form my-0">
                    <input class="form-control" id="searchProduction" type="text" placeholder="'.$search.'" aria-label="Search">
                    <i class="fas fa-search text-white mr-3" aria-hidden="true"></i>
                  </div>
                </form>
    ';
  break;
  case (active('wsb.old.php')):
  // case (strpos($url,'wsb.php')):
    $wsbactive = 'active';
    $search = 'Search wells...';
    $searchbar = '<form class="form-inline active-white active-white2">
                  <div class="md-form my-0">
                    <input class="form-control" id="searchProduction" type="text" placeholder="'.$search.'" aria-label="Search">
                    <i class="fas fa-search text-white mr-3" aria-hidden="true"></i></input>
                  </div>
                </form>
    ';
   
    if ($ob->isE1() || $ob->isE2() || $ob->isSuperAdmin() || $ob->isA2()) { 
      $buttons = '<div class=row><div class=col>
                     <div class="btn-group btn-group-sm">
                       <a class="nav-link btn btn-info" href="notes.REST.full.php">Edit Notes</a>
                       <a class="nav-link btn btn-outline-danger btn-xs" href="outboard.php?logout=1">Log Out</a>
                     </div>
                     </div></div>';	}
    
    
  break;
  case (active('wsb.php')):
    $table = "list";
    $sql = "SELECT api, entity_common_name FROM $table";// ORDER BY well_lease ASC";
    $result = mysqli_query($mysqli,$sql) or die(mysql_error());
    $wsbactive = 'active';
    $search = 'Search wells...';
    $searchbar = '<form class="form-inline active-white active-white2">
                  <div class="md-form my-0 dropdown" >
                    <input class="form-control" id="searchProduction" type="text" placeholder="'.$search.'" aria-label="Search" data-toggle="dropdown">
                    <i class="fas fa-search text-white mr-3" aria-hidden="true"></i></input>
                    <div id="searchDropdown" class="dropdown-menu bg-dark"  style="left:auto!important;">';
                    // <li class="dropdown">
    // $searchbar .= '<select id="searchProduction" class="ddr selectpicker form-control" data-live-search="true" data-width="auto" data-size="5" name="api" size="1" title="Search Wells...">';
    while ($row = mysqli_fetch_array($result)) {
      // $wellname = $row['well_lease'] . "# " . $row['well_no']; 
      $wellname = $row['entity_common_name'];
      $conditional = ($row['api'] == $apino) ?  '"' . $row['api'] . '" selected' :  '"' . $row['api'] . '"';
      $wellapi = $row['api'];
      // $searchbar .= "<option name='api' id='api' value=$conditional data-token=$conditional href=\"prod_data.php?api=$conditional\">$wellname</option>"; 
      $searchbar .= "<a class=\"text-primary dropdown-item\" href=\"prod_data.php?api=$wellapi\">$wellname</a>";
    }
                    
    // $searchbar .=   '</select>
    //                 <i class="fas fa-search text-white mr-3" aria-hidden="true"></i></input>
    //               </div>
    //             </form>
    // ';
    // </li>
    $searchbar .=   '</div>
                  </div>
                </form>
    ';
    // $searchbar = '<form class="form-inline active-white active-white2">
    //               <div class="md-form my-0">
    //                 <input class="form-control" id="searchProduction" type="text" placeholder="'.$search.'" aria-label="Search">
    //                 <i class="fas fa-search text-white mr-3" aria-hidden="true"></i></input>
    //                 <span class="toggle-helper" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown">hi</span>
    //                 <ul id="searchDropdown" class="dropdown-menu" style="left:auto!important;">';
    // while ($row = mysqli_fetch_array($result)) {
    //   $wellname = $row['entity_common_name'];
    //   $conditional = ($row['api'] == $apino) ?  '"' . $row['api'] . '" selected' :  '"' . $row['api'] . '"';
    //   $wellapi = $row['api'];
    //   $searchbar .= "<li ><a class=\"\" href=\"prod_data.php?api=$wellapi\">$wellname</a></li>";
    // }

    // $searchbar .=   '</ul>
    //               </div>
    //             </form>
    // ';
    break;
  //case (strpos($url,'/notes.php')):
  case (active('prod_data.php')):
  // case (strpos($url,'http://vprsrv2/prod_data.php')):
    $table = "list";
    $sql = "SELECT api, entity_common_name FROM $table";// ORDER BY well_lease ASC";
    $result = mysqli_query($mysqli,$sql) or die(mysql_error());
    $wsbactive = 'active';
    $search = 'Search...';
    // $searchbar = '<form class="form-inline active-white active-white2">
    //               <div class="md-form my-0">
    //                 <input class="form-control" id="searchProduction" type="text" placeholder="'.$search.'" aria-label="Search">
    //                 <i class="fas fa-search text-white mr-3" aria-hidden="true"></i>
    //               </div>
    //             </form>
    // ';
    $searchbar = '<form class="form-inline active-white active-white2">
                  <div class="md-form my-0 dropdown" >
                    <input class="form-control" id="searchProduction" type="text" placeholder="'.$search.'" aria-label="Search" data-toggle="dropdown">
                    <i class="fas fa-search text-white mr-3" aria-hidden="true"></i></input>
                    <div id="searchDropdown" class="dropdown-menu bg-dark"  style="left:auto!important;">';
    while ($row = mysqli_fetch_array($result)) {
      $wellname = $row['entity_common_name'];
      $conditional = ($row['api'] == $apino) ?  '"' . $row['api'] . '" selected' :  '"' . $row['api'] . '"';
      $wellapi = $row['api'];
      // $searchbar .= "<option name='api' id='api' value=$conditional data-token=$conditional href=\"prod_data.php?api=$conditional\">$wellname</option>"; 
      $searchbar .= "<a class=\"text-primary dropdown-item\" href=\"prod_data.php?api=$wellapi\">$wellname</a>";
    }
    $searchbar .=   '</div>
                  </div>
                </form>
    ';
    if ($ob->isE1() || $ob->isE2() || $ob->isSuperAdmin() || $ob->isA2()) { 
      $buttons = '<div class=row><div class=col>
                     <div class="btn-group btn-group-sm input-group">
                       <a class="nav-link btn btn-info" href="notes.REST.full.php">Edit Notes</a>
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
  case (active('prod_data.cp.php')):
    // case (strpos($url,'http://vprsrv2/prod_data.php')):
      $wsbactive = 'active';
      $search = 'Search...';
      $searchbar = '<form class="form-inline active-white active-white2">
                    <div class="md-form my-0">
                      <input class="form-control" id="searchProduction" type="text" placeholder="'.$search.'" aria-label="Search">
                      <i class="fas fa-search text-white mr-3" aria-hidden="true"></i>
                    </div>
                  </form>
      ';
      if ($ob->isE1() || $ob->isE2() || $ob->isSuperAdmin() || $ob->isA2()) { 
        $buttons = '<div class=row><div class=col>
                       <div class="btn-group btn-group-sm input-group">
                         <a class="nav-link btn btn-info" href="notes.REST.full.php">Edit Notes</a>
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
<div class="app-sidebar menu-fixed" data-background-color="black" data-scroll-to-active="true" style="touch-action: none; user-select: none; background-image: none;">
    <!-- main menu header-->
    <!-- Sidebar Header starts-->
    <div class="sidebar-header">
      <div class="logo clearfix">
        <a class="logo-text float-left" href="index.html">
          <div class="logo-img">
            <img class="navbar-brand" src="images/Flame.svg" width=auto height=auto>
          </div>
        </a>
        <a class="nav-toggle d-none d-lg-none d-xl-block" id="sidebarToggle" href="javascript:;">
          <i class="toggle-icon ft-toggle-left" data-toggle="expanded"></i>
        </a>
        <a class="nav-close d-block d-lg-block d-xl-none" id="sidebarClose" href="javascript:;"><i class="ft-x"></i></a>
      </div>
    </div>
    <!-- Sidebar Header Ends-->
    <!-- / main menu header-->
    <!-- main menu content-->
    <div class="sidebar-content main-menu-content ps ps--active-y" style="height: 869px;">
      <div class="nav-container">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
          <li class="nav-item <?php echo $outboardactive; ?>">
            <a class="nav-link" href="/outboard.php?noupdate=1">Outboard <span class="sr-only">(current)</span></a>
          </li>
          <li class="divider-vertical">&nbsp;</li>
          <!-- Timesheets -->
          <?php if ($ob->isAdmin() || $ob->isSuperAdmin()) { ?>
          <li class="nav-item dropdown <?php echo $timesheetactive; ?>">
          <a class="nav-link dropdown-toggle" href=# id="timesheetdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i data-feather='clock'></i> Timesheets</a>
            <div class="dropdown-menu" aria-labelledby="timesheetdropdown">
          <a class="dropdown-item" href="tcfEmp.php">
          <i data-feather='user' style='height: 1.5em; width: 1.5em;'></i> Personal Timesheet</a>
          <a class="dropdown-item" href="timeclock.php">
          <i data-feather='user-plus' style='height: 1.5em; width: 1.5em;'></i> Select Employee</a>
          <a class="dropdown-item" href="tcfTest.php">
          <i data-feather='users' style='height: 1.5em; width: 1.5em;'></i> All Employee Times</a>
          </div>
          </li>
        <?php } else { ?>
          <li class="nav-item <?php echo $timesheetactive; ?>">
          <a class="nav-link" href="tcfEmp.php">
          <i data-feather='clock'></i> Timesheet</a>
          </li>
				<?php } ?>
          
          <!-- View/Update -->
          <?php echo $changeupdate; ?>
          
          <!-- PTO -->
          <!-- NOTE: LINES 139 AND 150 ARE TO BE REMOVED WHEN TESTING IS COMPLETE -->
          <?php if ($ob->isSuperAdmin()) { ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="http://example.com/" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i data-feather='sun'></i> PTO</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
            <?php if ($ob->isEligible()) { ?>
              <a class="dropdown-item" href="pto.php">
              <i data-feather='briefcase' style='height: 1.5em; width: 1.5em;'></i> PTO Request</a>
            <?php } ?> 
					<a class="dropdown-item" href="approvePTO.php">
          <i data-feather='user-check' style='height: 1.5em; width: 1.5em;'></i> Approve PTO</a>
            </div>
          </li>
          <?php } ?> 
          
      <li class="nav-item <?php echo $extensionactive; ?>">
          <a class="nav-link" href="/extensionlist.php">
          <i data-feather='phone' >Phone</i> Extensions</a>
      </li>
      <!-- Calendar -->
      <?php if ($ob->isAdmin() || $ob->isSuperAdmin()) { ?>
          <li class="nav-item dropdown <?php echo $calendaractive; ?>">
          <a class="nav-link dropdown-toggle" href="#" id="calendardropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i data-feather='calendar'></i> Calendar</a>
            <div class="dropdown-menu" aria-labelledby="calendardropdown">
          <a class="dropdown-item" href="calendar.php"><i class="far fa-calendar-alt"></i> Calendar</a>
          <a class="dropdown-item" href="cal_admin.php"><i class="far fa-calendar-plus"></i> Edit Calendar</a>
          </div>
          </li>
        <?php } else { ?>
          <li class="nav-item <?php echo $calendaractive; ?>">
          <a class="nav-link" href="/calendar.php">
          <i data-feather='calendar'></i> Calendar</a>
          </li>
				<?php } ?>
        <li class="divider-vertical">&nbsp;</li>
      <!-- WSB -->
		      <li class="nav-item <?php echo $wsbactive; ?>">
           			 <a class="nav-link" href="wsb.php">
                  <i data-feather='file-text'></i> Well Status Board</a>
          </li> 
          <!-- Log Out -->
          <li class="nav-item">
			  
          </li>
        
        </ul>
        <ul class="navbar-nav ml-auto">
        <!-- Wiki -->
          <?php if ($ob->isAdmin() || $ob->isSuperAdmin()) { ?>
            <li class="nav-item <?php echo $wikiactive; ?>">
           			 <a class="nav-link" target="_blank" href="https://wiki.vprsrv.org">
                  <i data-feather='book-open'></i> Wiki</a>
          </li> 
        <?php } ?>
        <!-- Vault -->
        <?php if ($ob->isSuperAdmin()) { ?>
            <li class="nav-item <?php echo $vaultactive; ?>">
			      <?php //if ($ob->isE1() || $ob->isE2() || $ob->isSuperAdmin()) { ?>
           			 <a class="nav-link" target="_blank" href="https://vault.vprsrv.org">
                  <i data-feather='lock'></i> Vault</a>
  			    <?php //} ?>
          </li> 
        <?php } ?>
        
      <!-- Admin -->
      
      <?php if ($ob->isSuperAdmin()) { ?>
          <li class="nav-item dropdown <?php echo $adminactive; ?>">
          <a class="nav-link dropdown-toggle" href=# id="admindropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i data-feather='settings'></i> Admin</a>
            <div class="dropdown-menu" aria-labelledby="admindropdown">
          <!-- <a class="dropdown-item" href="/outboard.php?adminscreen=1"><i data-feather='user' style='height: 1.5em; width: 1.5em;'></i> Outboard Administration</a> -->
          <!-- <a class="dropdown-item" href="https://eset.vprsrv.org/era/webconsole/" target="_blank"><i data-feather='activity' style='height: 1.5em; width: 1.5em;'></i> ESET Security Management Center</a> -->
          <a class="dropdown-item" href="/outboard.php?adminscreen=1"><i class="fas fa-cog fa-lg" style='height: 1em; width: 1em;'></i> Outboard Administration</a>
          <a class="dropdown-item" href="https://eset.vprsrv.org/era/webconsole/" target="_blank"><i class="fas fa-fingerprint fa-lg" style='height: 1em; width: 1em;'></i> ESET Security Management Center</a>
          <a class="dropdown-item" href="https://admin.exchange.microsoft.com" target="_blank"><i class="fas fa-envelope-square fa-lg" style='height: 1em; width: 1em;'></i>  Exchange Admin Center</a>
          <a class="dropdown-item" href="https://admin.microsoft.com" target="_blank"><i class="fab fa-microsoft fa-lg" style='height: 1em; width: 1em;'></i> Microsoft 365 Admin Center</a>
          <a class="dropdown-item" href="https://webmin.vprsrv.org" target="_blank"><i class="fas fa-server fa-lg" style='height: 1em; width: 1em;'></i> Webmin vprsrv2 Server Access</a>
          <a class="dropdown-item" href="https://pfsense.vprsrv.org" target="_blank"><i class="fas fa-ethernet fa-lg" style='height: 1em; width: 1em;'></i> pfSense Firewall/Router Access</a>
          <!-- <a class="dropdown-item" href="tcfTest.php"><i data-feather='users' style='height: 1.5em; width: 1.5em;'></i> All Employee Times</a> -->
          </div>
          </li>
        <?php } elseif ($ob->isAdmin()) { ?>
          <li class="nav-item <?php echo $adminactive; ?>">
					  <a class="nav-link" href="/outboard.php?adminscreen=1">
            <i data-feather='settings'></i> Admin</a>
          </li>
				<?php } ?>
      <li class="divider-vertical">&nbsp;</li>
      
        </ul>
        <?php echo $searchbar; ?>
        <?php echo $buttons; ?>
        <!-- <div class=row><div class=col><?php if (! $BasicAuthInUse) { ?>
           			 <a class="nav-link btn btn-outline-danger btn-xs" href="<?php echo $baseurl ?>?logout=1">Log Out</a>
  			 <?php } ?></div></div> -->
        <div class="divider-vertical" style="margin-left:1em; margin-right:1em;"></div>
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
        </div>
        </div>
<script type="text/javascript">
    $(document).ready(function () {
        var url = window.location;
        $('ul.nav a[href="'+ url +'"]').parent().addClass('active');
        $('ul.nav a').filter(function() {
             return this.href == url;
        }).parent().addClass('active');
    });
</script> 