<?php include 'lib/ob.php'; 
$hr = 0;
$ap = 0;
$a1 = 0;
$a2 = 0;
$e1 = 0;
$e2 = 0;
$la = 0;
$le = 0;
$ge = 0;
$ad = 0;
if ($ob->isHR()) { $hr = true; } 
if ($ob->isAPspr()) {$ap = true; } 
if ($ob->isA1spr()) { $a1 = true; } 
if ($ob->isA2spr()) { $a2 = true; } 
if ($ob->isE1spr()) { $e1 = true; } 
if ($ob->isE2spr()) { $e2 = true; } 
if ($ob->isLandspr()) { $la = true; } 
if ($ob->isLegalspr()) { $le = true; } 
if ($ob->isGeospr()) { $ge = true; } 
if ($ob->isADstaffspr()) { $ad = true; }
?>
<html>
<head>
  <title>OutBoard: <?php echo $ob->getConfig('board_title') ?></title> 
  <?php  include 'include/dependencies.php'; ?>
  <link rel="stylesheet" type="text/css" href="/css/ob.css?v=1.0">
  <!-- <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900%7CMontserrat:300,400,500,600,700,800,900"> -->
  <link rel="stylesheet" type="text/css" href="https://pixinvent.com/apex-angular-4-bootstrap-admin-template/app-assets/fonts/feather/style.min.css">
  <link rel="stylesheet" type="text/css" href="https://pixinvent.com/apex-angular-4-bootstrap-admin-template/app-assets/fonts/simple-line-icons/style.min.css">
  <link rel="stylesheet" type="text/css" href="https://pixinvent.com/apex-angular-4-bootstrap-admin-template/app-assets/fonts/font-awesome/css/font-awesome.min.css">
  <!-- <link rel="stylesheet" type="text/css" href="https://pixinvent.com/apex-angular-4-bootstrap-admin-template/app-assets/vendors/css/perfect-scrollbar.min.css"> -->
  <!-- <link rel="stylesheet" type="text/css" href="https://pixinvent.com/apex-angular-4-bootstrap-admin-template/app-assets/vendors/css/prism.min.css">
  <link rel="stylesheet" type="text/css" href="https://pixinvent.com/apex-angular-4-bootstrap-admin-template/app-assets/vendors/css/switchery.min.css">
  <link rel="stylesheet" type="text/css" href="https://pixinvent.com/apex-angular-4-bootstrap-admin-template/app-assets/vendors/css/chartist.min.css">
  <link rel="stylesheet" type="text/css" href="https://pixinvent.com/apex-angular-4-bootstrap-admin-template/app-assets/css/bootstrap.min.css">-->
  <link rel="stylesheet" type="text/css" href="https://pixinvent.com/apex-angular-4-bootstrap-admin-template/app-assets/css/bootstrap-extended.min.css"> 
  <!-- <link rel="stylesheet" type="text/css" href="https://pixinvent.com/apex-angular-4-bootstrap-admin-template/app-assets/css/colors.min.css"> -->
  <link rel="stylesheet" type="text/css" href="https://pixinvent.com/apex-angular-4-bootstrap-admin-template/app-assets/css/components.min.css">
  <!-- <link rel="stylesheet" type="text/css" href="https://pixinvent.com/apex-angular-4-bootstrap-admin-template/app-assets/css/themes/layout-dark.min.css"> -->
  <!-- <link rel="stylesheet" type="text/css" href="https://pixinvent.com/apex-angular-4-bootstrap-admin-template/app-assets/css/plugins/switchery.min.css">
  <link rel="stylesheet" type="text/css" href="https://pixinvent.com/apex-angular-4-bootstrap-admin-template/app-assets/css/pages/dashboard1.min.css">
  <link rel="stylesheet" type="text/css" href="https://pixinvent.com/apex-angular-4-bootstrap-admin-template/assets/css/style.css"> -->
  <!-- <link rel="stylesheet" type="text/css" href="/css/apex_css/css.css"> -->
  <!-- <link rel="stylesheet" type="text/css" href="/css/apex_css/style.1.min.css"> -->
  <!-- <link rel="stylesheet" type="text/css" href="/css/apex_css/style.min.css.css"> -->
  <!-- <link rel="stylesheet" type="text/css" href="/css/apex_css/perfect-scrollbar.min.css">
  <link rel="stylesheet" type="text/css" href="/css/apex_css/prism.min.css">
  <link rel="stylesheet" type="text/css" href="/css/apex_css/switchery.1.min.css">
  <link rel="stylesheet" type="text/css" href="/css/apex_css/chartist.min.css">
  <link rel="stylesheet" type="text/css" href="/css/apex_css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="/css/apex_css/bootstrap-extended.min.css">
  <link rel="stylesheet" type="text/css" href="/css/apex_css/colors.min.css">
  <link rel="stylesheet" type="text/css" href="/css/apex_css/components.min.css">
  <link rel="stylesheet" type="text/css" href="/css/apex_css/layout-dark.min.css">
  <link rel="stylesheet" type="text/css" href="/css/apex_css/switchery.min.css">
  <link rel="stylesheet" type="text/css" href="/css/apex_css/dashboard1.min.css">
  <link rel="stylesheet" type="text/css" href="/css/apex_css/style.css"> -->
  <link rel="stylesheet" type="text/css" href="/css/apex_css/horizontal-menu.min.css?">
  <script src="https://pixinvent.com/apex-angular-4-bootstrap-admin-template/app-assets/js/core/app-menu.min.js"></script>
  <script src="https://pixinvent.com/apex-angular-4-bootstrap-admin-template/app-assets/js/core/app.min.js"></script>
  <script src="https://pixinvent.com/apex-angular-4-bootstrap-admin-template/app-assets/js/customizer.min.js"></script>
  <script src="https://pixinvent.com/apex-angular-4-bootstrap-admin-template/app-assets/js/dashboard1.min.js"></script>
  <script src="https://pixinvent.com/apex-angular-4-bootstrap-admin-template/app-assets/js/notification-sidebar.min.js"></script>
  <script src="https://pixinvent.com/apex-angular-4-bootstrap-admin-template/app-assets/js/scroll-top.min.js"></script>
  <script src="/js/union.js"></script>
  <script src="/js/sliding-menu.js"></script>
  <script src="/js/screenfull-5.js"></script>
  <script src="/js/pace-1.0.2.js"></script>
  <script Language="JavaScript">
    function myReload() {
      self.location = "<?php echo $baseurl ?>?noupdate=1";
    }
    // t = setTimeout("myReload()",<?php echo $update_msec ?>);
  </script>

<script type="text/javascript" class="init" src="/js/datatables.ob.testing.js?v1.0.1.76"> 
// var update = <?php //echo $update; ?>
</script>
<?php if ($launch = getGetValue('launch')) { ?>
<Script Language="JavaScript"> window.focus(); </Script>
<?php } ?>

<script>
	document.addEventListener('DOMContentLoaded', function() {
    var calendarE0 = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarE0, {
      headerToolbar:{
        left:'prevYear,prev,today,next,nextYear',
        center:'title',
        right:'dayGridMonth,timeGridWeek,timeGridDay'
      },
      initialView: 'timeGridWeek',
      themeSystem: 'bootstrap',
      height: "70vh",
	    dayMaxEventRows: true, // allow "more" link when too many events
      events: 'ajax/cal_load.php',
      loading: function( isLoading, view ) {
            if(isLoading) {// isLoading gives boolean value
                //show your loader here 
            } else {
                //hide your loader here
            }
        }
    });
    
    calendar.render();
    
  });	
  
</script>

</head>
<!-- <body class="ob-bg"> -->
<body class="nav-collapsed ob-bg horizontal-layout" data-menu="vertical-menu" data-col="2-columns">
<!-- <body class="ob-bg vertical-layout vertical-menu 2-columns navbar-static layout-dark pace-done nav-collapsed" data-menu="vertical-menu" data-col="2-columns"><div class="pace  pace-inactive"><div class="pace-progress" style="transform: translate3d(100%, 0px, 0px);" data-progress-text="100%" data-progress="99"> -->


<nav class="navbar navbar-expand-lg navbar-light header-navbar navbar-static navbar-brand-center" data-nav="brand-center">
      <div class="container-fluid navbar-wrapper">
        <div class="navbar-header d-flex">
          <div class="navbar-toggle menu-toggle d-xl-none d-block float-left align-items-center justify-content-center" data-toggle="collapse"><i class="ft-menu font-medium-3"></i></div>
          <ul class="navbar-nav">
            <li class="nav-item mr-2 d-none d-lg-block"><a class="nav-link apptogglefullscreen" id="navbar-fullscreen" href="javascript:;"><i class="ft-maximize font-medium-3"></i></a></li>
            <li class="nav-item nav-search"><a class="nav-link nav-link-search" href="javascript:"><i class="ft-search font-medium-3"></i></a>
              <div class="search-input">
                <div class="search-input-icon"><i class="ft-search font-medium-3"></i></div>
                <input class="input" type="text" placeholder="Explore Apex..." tabindex="0" data-search="template-search">
                <div class="search-input-close"><i class="ft-x font-medium-3"></i></div>
                <ul class="search-list"></ul>
              </div>
            </li>
          </ul>
          <div class="navbar-brand-center">
            <div class="navbar-header">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <div class="logo"><a class="logo-text" href="index.html">
                      <div class="logo-img"><img class="logo-img" alt="Apex logo" src="../app-assets/img/logo-dark.png"></div><span class="text">APEX</span></a></div>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="navbar-container">
          <div class="collapse navbar-collapse d-block" id="navbarSupportedContent">
            <ul class="navbar-nav">
              <li class="i18n-dropdown dropdown nav-item mr-2"><a class="nav-link d-flex align-items-center dropdown-toggle dropdown-language" id="dropdown-flag" href="javascript:;" data-toggle="dropdown"><img class="langimg selected-flag" src="../app-assets/img/flags/us.png" alt="flag"><span class="selected-language d-md-flex d-none">English</span></a>
                <div class="dropdown-menu dropdown-menu-right text-left" aria-labelledby="dropdown-flag"><a class="dropdown-item" href="javascript:;" data-language="en"><img class="langimg mr-2" src="../app-assets/img/flags/us.png" alt="flag"><span class="font-small-3">English</span></a><a class="dropdown-item" href="javascript:;" data-language="es"><img class="langimg mr-2" src="../app-assets/img/flags/es.png" alt="flag"><span class="font-small-3">Spanish</span></a><a class="dropdown-item" href="javascript:;" data-language="pt"><img class="langimg mr-2" src="../app-assets/img/flags/pt.png" alt="flag"><span class="font-small-3">Portuguese</span></a><a class="dropdown-item" href="javascript:;" data-language="de"><img class="langimg mr-2" src="../app-assets/img/flags/de.png" alt="flag"><span class="font-small-3">German</span></a></div>
              </li>
              <li class="dropdown nav-item"><a class="nav-link dropdown-toggle dropdown-notification p-0 mt-2" id="dropdownBasic1" href="javascript:;" data-toggle="dropdown"><i class="ft-bell font-medium-3"></i><span class="notification badge badge-pill badge-danger">4</span></a>
                <ul class="notification-dropdown dropdown-menu dropdown-menu-media dropdown-menu-right m-0 overflow-hidden">
                  <li class="dropdown-menu-header">
                    <div class="dropdown-header d-flex justify-content-between m-0 px-3 py-2 white bg-primary">
                      <div class="d-flex"><i class="ft-bell font-medium-3 d-flex align-items-center mr-2"></i><span class="noti-title">7 New Notification</span></div><span class="text-bold-400 cursor-pointer">Mark all as read</span>
                    </div>
                  </li>
                  <li class="scrollable-container ps"><a class="d-flex justify-content-between" href="javascript:void(0)">
                      <div class="media d-flex align-items-center">
                        <div class="media-left">
                          <div class="mr-3"><img class="avatar" src="../app-assets/img/portrait/small/avatar-s-20.png" alt="avatar" width="45" height="45"></div>
                        </div>
                        <div class="media-body">
                          <h6 class="m-0"><span>Kate Young</span><small class="grey lighten-1 font-italic float-right">5 mins ago</small></h6><small class="noti-text">Commented on your photo</small>
                          <h6 class="noti-text font-small-3 m-0">Great Shot John! Really enjoying the composition on this piece.</h6>
                        </div>
                      </div></a><a class="d-flex justify-content-between" href="javascript:void(0)">
                      <div class="media d-flex align-items-center">
                        <div class="media-left">
                          <div class="mr-3"><img class="avatar" src="../app-assets/img/portrait/small/avatar-s-11.png" alt="avatar" width="45" height="45"></div>
                        </div>
                        <div class="media-body">
                          <h6 class="m-0"><span>Andrew Watts</span><small class="grey lighten-1 font-italic float-right">49 mins ago</small></h6><small class="noti-text">Liked your album: UI/UX Inspo</small>
                        </div>
                      </div></a><a class="d-flex justify-content-between read-notification" href="javascript:void(0)">
                      <div class="media d-flex align-items-center py-0 pr-0">
                        <div class="media-left">
                          <div class="mr-3"><img src="../app-assets/img/icons/sketch-mac-icon.png" alt="avatar" width="45" height="45"></div>
                        </div>
                        <div class="media-body">
                          <h6 class="m-0">Update</h6><small class="noti-text">MyBook v2.0.7</small>
                        </div>
                        <div class="media-right">
                          <div class="border-left">
                            <div class="px-4 py-2 border-bottom">
                              <h6 class="m-0 text-bold-600">Update</h6>
                            </div>
                            <div class="px-4 py-2 text-center">
                              <h6 class="m-0">Close</h6>
                            </div>
                          </div>
                        </div>
                      </div></a><a class="d-flex justify-content-between read-notification" href="javascript:void(0)">
                      <div class="media d-flex align-items-center">
                        <div class="media-left">
                          <div class="avatar bg-primary bg-lighten-3 mr-3 p-1"><span class="avatar-content font-medium-2">LD</span></div>
                        </div>
                        <div class="media-body">
                          <h6 class="m-0"><span>Registration done</span><small class="grey lighten-1 font-italic float-right">6 hrs ago</small></h6>
                        </div>
                      </div></a>
                    <div class="cursor-pointer">
                      <div class="media d-flex align-items-center justify-content-between">
                        <div class="media-left">
                          <div class="media-body">
                            <h6 class="m-0">New Offers</h6>
                          </div>
                        </div>
                        <div class="media-right">
                          <div class="custom-control custom-switch">
                            <input class="switchery" type="checkbox" checked="" id="notificationSwtich" data-size="sm" style="display: none;" data-switchery="true"><span class="switchery switchery-small switchery-default" style="background-color: rgb(151, 90, 255); border-color: rgb(151, 90, 255); box-shadow: rgb(151, 90, 255) 0px 0px 0px 0px inset; transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;"><small style="left: 12px; background-color: rgb(255, 255, 255); transition: background-color 0.4s ease 0s, left 0.2s ease 0s;"></small></span>
                            <label for="notificationSwtich"></label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex justify-content-between cursor-pointer read-notification">
                      <div class="media d-flex align-items-center">
                        <div class="media-left">
                          <div class="avatar bg-danger bg-lighten-4 mr-3 p-1"><span class="avatar-content font-medium-2"><i class="ft-heart text-danger"></i></span></div>
                        </div>
                        <div class="media-body">
                          <h6 class="m-0"><span>Application approved</span><small class="grey lighten-1 font-italic float-right">18 hrs ago</small></h6>
                        </div>
                      </div>
                    </div><a class="d-flex justify-content-between read-notification" href="javascript:void(0)">
                      <div class="media d-flex align-items-center">
                        <div class="media-left">
                          <div class="mr-3"><img class="avatar" src="../app-assets/img/portrait/small/avatar-s-6.png" alt="avatar" width="45" height="45"></div>
                        </div>
                        <div class="media-body">
                          <h6 class="m-0"><span>Anna Lee</span><small class="grey lighten-1 font-italic float-right">27 hrs ago</small></h6><small class="noti-text">Commented on your photo</small>
                          <h6 class="noti-text font-small-3 text-bold-500 m-0">Woah!Loving these colors! Keep it up</h6>
                        </div>
                      </div></a>
                    <div class="d-flex justify-content-between cursor-pointer read-notification">
                      <div class="media d-flex align-items-center">
                        <div class="media-left">
                          <div class="avatar bg-info bg-lighten-4 mr-3 p-1">
                            <div class="avatar-content font-medium-2"><i class="ft-align-left text-info"></i></div>
                          </div>
                        </div>
                        <div class="media-body">
                          <h6 class="m-0"><span>Report generated</span><small class="grey lighten-1 font-italic float-right">35 hrs ago</small></h6>
                        </div>
                      </div>
                    </div><a class="d-flex justify-content-between read-notification" href="javascript:void(0)">
                      <div class="media d-flex align-items-center">
                        <div class="media-left">
                          <div class="mr-3"><img class="avatar" src="../app-assets/img/portrait/small/avatar-s-7.png" alt="avatar" width="45" height="45"></div>
                        </div>
                        <div class="media-body">
                          <h6 class="m-0"><span>Oliver Wright</span><small class="grey lighten-1 font-italic float-right">2 days ago</small></h6><small class="noti-text">Liked your album: UI/UX Inspo</small>
                        </div>
                      </div></a>
                  <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></li>
                  <li class="dropdown-menu-footer">
                    <div class="noti-footer text-center cursor-pointer primary border-top text-bold-400 py-1">Read All Notifications</div>
                  </li>
                </ul>
              </li>
              <li class="dropdown nav-item mr-1"><a class="nav-link dropdown-toggle user-dropdown d-flex align-items-end" id="dropdownBasic2" href="javascript:;" data-toggle="dropdown">
                  <div class="user d-md-flex d-none mr-2"><span class="text-right">John Doe</span><span class="text-right text-muted font-small-3">Available</span></div><img class="avatar" src="../app-assets/img/portrait/small/avatar-s-1.png" alt="avatar" width="35" height="35"></a>
                <div class="dropdown-menu text-left dropdown-menu-right m-0 pb-0" aria-labelledby="dropdownBasic2"><a class="dropdown-item" href="app-chat.html">
                    <div class="d-flex align-items-center"><i class="ft-message-square mr-2"></i><span>Chat</span></div></a><a class="dropdown-item" href="page-user-profile.html">
                    <div class="d-flex align-items-center"><i class="ft-edit mr-2"></i><span>Edit Profile</span></div></a><a class="dropdown-item" href="app-email.html">
                    <div class="d-flex align-items-center"><i class="ft-mail mr-2"></i><span>My Inbox</span></div></a>
                  <div class="dropdown-divider"></div><a class="dropdown-item" href="auth-login.html">
                    <div class="d-flex align-items-center"><i class="ft-power mr-2"></i><span>Logout</span></div></a>
                </div>
              </li>
              <li class="nav-item d-none d-lg-block mr-2 mt-1"><a class="nav-link notification-sidebar-toggle" href="javascript:;"><i class="ft-align-right font-medium-3"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
    <!-- Navbar (Header) Ends-->
<!-- <script>
$(function(){
    $('form input').data('val',  $('form input').val() ); // save value
    $('form input').change(function() { // works when input will be blured and the value was changed
        // console.log('input value changed');
        $('.log').append(' change');
    });
    $('form input').keyup(function() { // works immediately when user press button inside of the input
        if( $('form input').val() != $('form input').data('val') ){ // check if value changed
            $('form input').data('val',  $('form input').val() ); // save new value
            $(this).change(); // simulate "change" event
        }
    });
});
</script> -->
<script language="JavaScript1.2">
  $(document).ready(function() {
    tabMove();
    // tabResize();
  });
  window.addEventListener("resize", tabMove);
  function tabMove(){
    var pillgroup = document.querySelector("#pills-vert").offsetWidth;
    document.querySelector("#object-div").setAttribute('style', 'left:' + pillgroup + 'px; position: relative;');
    var cal = document.querySelector("#right-side").scrollWidth;
    var totalwidth = cal + pillgroup - 1;
    // document.querySelector("#pills-vert").setAttribute('style', 'left:' + pillgroup + 'px; position: relative;');
  }
  function tabResize() {
    $('#object-div').affix({
      offset: {
        left: function() { return $('#pills-vert').width(); }
      }
    });
  }
  // so need to make an ajax call
  // url = outboard.php
  // variables remarks, out, userid, update, noupdate

</script>
<!-- Alerts -->
<div class="ob-alert"> 
  <?php if (! $update && ! $readonly) { ?>
    <div id="alert" class="alert alert-primary fade show w-96" role="alert">
      <strong>You are now in view only mode.</strong>
    </div>
  <?php } elseif (! $readonly) { ?>
    <div id="alert" class="alert alert-danger fade show w-96" role="alert">
      <strong>You are now in update mode.</strong>
    </div>
    <?php } else { echo "&nbsp;"; } ?>
</div>

<?php //include 'modals/ob_lunch_modals.php'; ?>
<!-- Modal -->
<div class="modal fade" id="lunchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ending Lunch</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="user" class="modal-body" val="">
        Would you like to check back in remotely or physically?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="rtw" type="button" value="usr" class="btn btn-primary">Check in remotely</button>
        <button id="itw" type="button" value="usr" class="btn btn-success">Check in office</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="takeLunchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Taking Lunch</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="user" class="modal-body" val="">
        <div class="col">
          What time will you be returning?
        </div>
        
        <div class="col">
            <div class="input-group input-group-sm">
                <input name="lunchtime" id="lunchtime" type="hidden" autocomplete="off" value="00:00" class="form-control without_ampm" >
                <!-- <input name="otl" id="otl" type="hidden" value="usr"> -->
            </div>
                
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="otl" type="button" value="usr" class="btn btn-primary">Submit</button>
        <!-- <button id="itw" type="button" onclick="otl();" value="usr" class="btn btn-success">Check in office</button> -->

      </div>
    </div>
  </div>
</div>
<script>
var today = moment().format("hh:mm");
    console.log(today);
    $('#lunchtime').val(today);
    $('#end').val(today);
    // $('#dee').datepicker({defaultViewDate: today, format: "yyyy-mm-dd"});
    // $('#dee').on('changeDate', function() {
    //     $('#start').val(
    //         $('#dee').datepicker('getFormattedDate')
    //     );
    // });
    // log(today);
    // $('#def').datepicker({defaultViewDate: today, format: "yyyy-mm-dd"});
    // $('#def').on('changeDate', function() {
    //     $('#end').val(
    //         $('#def').datepicker('getFormattedDate')
    //     );
    // });
  
</script>
<script type="text/javascript">
      $(function () {
          $('#lunchtime').datetimepicker({
              inline: true,
              format: 'hh:mm'
          });
          // $('#lunchtime').on('change', function() {
          //   $('#otl').val(
          //     $('#lunchtime').data("DateTimePicker").viewDate();
          //   )
          // });
      });
    
   </script>
<?php //include 'modals/ob_remark_modals.php'; ?>
<!-- Modal -->
<div class="modal fade" id="clearRemarkModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Remarks</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="user" class="modal-body" val="">
        Remark cleared.
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="rtw" type="button" onclick="end_lunch_rw();" value="usr" class="btn btn-primary">Check in remotely</button>
        <button id="itw" type="button" onclick="end_lunch_in();" value="usr" class="btn btn-success">Check in office</button>
      </div> -->
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="setRemarkModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Remarks</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="user" class="modal-body" val="">
        <!-- Previous Remark:
        <p id=olddRemark> -->
        Please set your remark below:
        <!-- <input id="oldRemark"> -->
        <!-- <div class="input-group input-group-sm mb-1"> -->
        <form id="remark_form">
            <input id="remark" name="oldRemark" type="text" class="form-control" placeholder="Insert remarks...">
        </form>
            <input type="hidden" value="curRemark">
        <!-- </div> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="remarkUser" type="button" value="usr" class="btn btn-primary">Submit</button>
        <!-- <button id="itw" type="button" onclick="end_lunch_in();" value="usr" class="btn btn-success">Check in office</button> -->
      </div>
    </div>
  </div>
</div>
<?php include 'include/header_extensions.1.php'; ?>
<div class="container-fluid" >
  
              
      </div>
    <div class="row justify-content-center h-70vh">
      
      <div id="main-ob" class="col-4 m-3 p-3 shadow-lg card-body bg-light" >
        <table id="table" class="table table-striped table-hover table-borderless smol" >
        <thead><tr>
            <th>Name</th>
            <th>In</th>
            <th><span data-tippy-content="Remote Work" tabindex="0">RW</span></th>
            <th>Out</th>
            <th>Remarks</th>
          </tr></thead>
          <tr>
            <th>Name</th>
            <th>In</th>
            <th>RW</th>
            <th>Out</th>
            <th>Remarks</th>
          </tr> 
        </table>
      </div>
      <style>
        .ob-style.nav-pills:not(.nav-link.active), .ob-pills.nav-pills:not(.show>.nav-link) {
          color: #212529;
          background-color: #f8f9fa;
        }
        .ob-style.nav-link-white{
          color: #212529;
          background-color: #f8f9fa;
          border-radius: 0rem!important;
        }
        .right-side {
            display: flex; flex-wrap: wrap; box-sizing: border-box; max-width: 50%;
        }
        .fixed {
          position: fixed;
        }
        .relative {
          position: relative;
        }
        .ob-bg {
          background-color: #0e5092;
        }
        .ext-table {
          background-color: white !important; 
          margin-top: 0px !important;
        }
        .ob-alert {
          display:flex;
          position:fixed;
          width:100%;
          left:1.5em;
          bottom:0em;
          z-index:1030;
        }
        .w-96 {
          width: 96%;
        }
        .h-70vh {
          height: 70vh;
        }
      </style>
      <div id="right-side" class="p-3 card-body right-side">
        <div id="pills-vert" class="cole-1 mr-e5 fixed">
          <nav class="h-auto" id="tabs">
            <ul class="nav flex-column nav-pills pb-0 ob-style" id="myTab" role="tablist">
              <li class="nav-item " role="presentation">
                <a class="nav-link nav-link-white ob-style active" id="calendar-tab" data-toggle="tab" href="#caldiv" role="tab" aria-controls="detail" aria-selected="true"><i class="far fa-calendar-alt"></i></a>
              </li>
              <li class="nav-item " role="presentation">
                <a class="nav-link nav-link-white ob-style" id="extensions-tab" data-toggle="tab" href="#ext" role="tab" aria-controls="detail" aria-selected="false"><i data-feather='phone' ></i></a>
              </li>
              <li class="nav-item " role="presentation">
                <a class="nav-link nav-link-white ob-style" id="timesheet-tab" data-toggle="tab" href="#time" role="tab" aria-controls="detail" aria-selected="false"><i data-feather='clock' ></i></a>
              </li>
            </ul>
          </nav>
        </div>
        <div id="object-div" class="col--10 shadow-lg card-body bg-light">
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade in show active relative" id="caldiv" role="tabpanel" aria-labelledby="calendar-tab">
              <div id="calendar"></div>
            </div>
            <div class="tab-pane fade " id="ext" role="tabpanel" aria-labelledby="calendar-tab">
              <div class="col--6 m--2 p--3 shadow--lg card--body bg--light">
                <table id="ext-table" class='table table-striped table-hover table-borderless table-sm smol'  >
                  <thead class="table-dark">
                      <tr>
                          <th>Name</th>
                          <th>Title</th>
                          <th>Extension</th>
                          <th>Email</th>
                      </tr>
                  </thead>
                </table>
              </div>
            </div>
            <div class="tab-pane fade " id="time" role="tabpanel" aria-labelledby="time-tab">
              <iframe src="tcfEmp-iFrame.php" height="90%" width="100%" sandbox="allow-same-origin allow-scripts"></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php 
include 'eventpopup.php';
include 'readupdate_fab.php'; 
// include 'scripts.php';
?>
<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>

<?php
// include 'floating_action_button.php';
// include 'ddr_add_modal.php';
include 'scripts.php';  
?>

</body>

</html>