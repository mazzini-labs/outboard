<?php include 'lib/obN.php'; 
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
  <?php  include 'dependencies.php'; ?>
  <link rel="stylesheet" type="text/css" href="/css/ob.css?v=1.0">
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
<body class="ob-bg">
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
<?php include 'include/header_extensions.php'; ?>
  <div class="container-fluid" >
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