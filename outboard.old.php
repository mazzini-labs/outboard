<?php 
include 'include/variables.php';
if(isset($_REQUEST['pdo'])){ include 'lib/obN.php';} else { include 'lib/ob.php';}
$readonly = ""; 
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
  <link rel="stylesheet" type="text/css" href="assets/css/ob.css?v=1.0">
  <script Language="JavaScript">
    function myReload() {
      self.location = "<?php echo $baseurl ?>?noupdate=1";
    }
    // t = setTimeout("myReload()",<?php echo $update_msec ?>);
  </script>

<script type="text/javascript" class="init" src="/assets/js/datatables.ob.js?v1.0.0.34">
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
      nowIndicator: true,
      slotMinTime: "07:00:00",
      slotMaxTime: "19:00:00",
      loading: function( isLoading, view ) {
            if(isLoading) {// isLoading gives boolean value
                //show your loader here 
            } else {
                //hide your loader here
            }
        },
      if(allDayDidMount){
        console.log("did mount");
      }
    });
    
    calendar.render();
    
  });	
  
</script>

</head>
<body style="background-color: #0e5092;">
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
    // function(){
        
    // }​
  function change_remark(remark,userid) {
      $('#remark_form')[0].reset();  
      $('#setRemarkModal').modal('show');
      $('#remarkUser').val(userid);
      if (remark != ""){
        $('#remark').attr('placeholder',remark);
        }  
  }
  function out_to_lunch(remark,userid) {
    var newremark = prompt("Approximately what time will you return?");
    var rto = "OTL; will return around ";
    if (newremark != null) {
      self.location="<?php echo $baseurl ?>?remarks=" + escape(rto) + ""
		    + escape(newremark) + "&out=1&userid=" +userid + "&noupdate=1";
    }
  }
  function clear_remarks(remark,userid) {
    // alert("Remark cleared.");
    $('#clearRemarkModal').modal('show');
    setTimeout(function(){
      self.location="<?php echo $baseurl ?>?remarks=" + "&userid=" +userid + "&update=1";
    },1000);
  }
  function end_lunch_rw() {
      var userid = $('#rtw').attr("value");  
      $('#lunchModal').modal('hide');
      
      self.location="<?php echo $baseurl ?>?remarks=" + "&rw=1&userid=" +userid + "&update=1";
  }
  function end_lunch_in() {
      var userid = $('#itw').attr("value");  
      $('#lunchModal').modal('hide');
      self.location="<?php echo $baseurl ?>?remarks=" + "&in=1&userid=" +userid + "&update=1";
  }
  $(document).on('click', '.returnfromlunch', function(){  
    var userid = $(this).attr("id");  
    $('#lunchModal').modal('show');
    $('#rtw').val(userid);  
    $('#itw').val(userid);  
  });
  $(document).on('click', '.outtolunch', function(){  
    var userid = $(this).attr("id");  
    $('#takeLunchModal').modal('show');
    $('#otl').val(userid);  
  });
  // $(document).on('click', '.remark', function(){  
  //   var userid = $(this).attr("id");  
  //   $('#setRemarkModal').modal('show');
  //   $('#remarkUser').val(userid);  
  // });
  function otl() {
      var userid = $('#otl').attr("value"); 
      var time = $('#lunchtime').attr("value");
      var rto = "OTL; will return around " + time; 
      $('#takeLunchModal').modal('hide');
      self.location="<?php echo $baseurl ?>?remarks=" + escape(rto) + ""
		    + "&out=1&userid=" +userid + "&noupdate=1";
  }
  function set_remark() {
      var userid = $('#remarkUser').attr("value"); 
      var newremark = $('#remark').val();
      $('#setRemarkModal').modal('hide');
      // console.log("<?php echo $baseurl ?>?remarks="
		  //   + escape(newremark) + "&userid=" +userid + "&update=1");
      self.location="<?php echo $baseurl ?>?remarks="
		    + escape(newremark) + "&userid=" +userid + "&update=1";
  }
  $(document).ready(function() {
    tabMove();
    // tabResize();
    var oTable = $('#table').on( 'init.dt', function () {
        console.log(update);
        feather.replace();
        tippy('.r-tooltip', { 
          arrow: false 
        });
        tippy('.hours', { 
          placement: 'right',
          arrow: false 
        });
    } ).DataTable( {
      hideEmptyCols: true,
      "ajax": {
        "url" : url,
        "data": {
            "update": update,
        }
      },
      "sDom": 't',
      "order": [],
      deferRender: true,
      scrollY: "70vh",
      scroller: true,
      "searching": true,
      "autoWidth": false,
      retrieve: true,
      "columns": [
          {
            "title": "Name",
            "data": null, render: function (data,type,row)
            {
              return "<span class=\"hours\" data-tippy-content=\"Core Hours: "+data.hours+"\" tabindex=\"0\">"+data.name+"</span>";
            },
            "defaultContent": ""
          },
          {
            "title": "<span class=\"r-tooltip\" data-tippy-content=\"In Office\" tabindex=\"0\">In</span>",
            // "data": "in",
            "data": null, render: function (data,type,row)
            {
              if(data.in == "in")
              {
                return "<span class=\"r-tooltip\" data-tippy-content=\""+data.lastup+"\" tabindex=\"0\"><i data-feather='check-circle' style='color: #28a745; height: 1.5em; width: 1.5em;'>in</i></span>";
              }
              else if(data.change == "true" && data.in == "empty")
              {
                return "<a href=\"outboard.php?in=1&userid="+data.uname+"&noupdate=1"+"\"><i class='hover-check' data-feather='check-circle' style='color: gray; height: 1.5em; width: 1.5em;'>in</i></a>";
              }                            
            },
            "defaultContent": "",
          },
          {
            "title": "<span class=\"r-tooltip\" data-tippy-content=\"Remotely Working\" tabindex=\"0\">Remote</span>",
            "data": null, render: function (data,type,row)
            {
              if(data.rw == "rw")
              {
                return "<span class=\"r-tooltip\" data-tippy-content=\""+data.lastup+"\" tabindex=\"0\"><i class='align-center' data-feather='check' style='color: blue; height: 1.5em; width: 1.5em;'>remote</i></span>";
              }
              else if(data.change == "true" && data.rw == "empty")
              {
                
                return "<a href=\"outboard.php?rw=1&userid="+data.uname+"&noupdate=1"+"\"><i class='hover-check' data-feather='check' style='color: gray; height: 1.5em; width: 1.5em;'>in</i></a>";
              }            
            },
            "defaultContent": "",
          },
          {
            "title": "<span class=\"r-tooltip\" data-tippy-content=\"Out of Office\" tabindex=\"0\">Out</span>",
            "data": null, render: function (data,type,row)
            {
              if(data.out == "out" && (data.remarks.includes("OTL") || data.remarks.includes("otl")))
              {
                return "<span class=\"r-tooltip\" data-tippy-content=\""+data.lastup+"\" tabindex=\"0\"><i data-feather='coffee' style='color: orange; height: 1.5em; width: 1.5em;'>out</i></span>";
              }
              else if(data.out == "out")
              {
                return "<span class=\"r-tooltip\" data-tippy-content=\""+data.lastup+"\" tabindex=\"0\"><i data-feather='x-circle' style='color: red; height: 1.5em; width: 1.5em;'>out</i></span>";
              }
              else
              {
                if(data.change == "true" && data.out == "empty")
                {
                  return "<a href=\"outboard.php?out=1&userid="+data.uname+"&noupdate=1"+"\"><i class='hover-x' data-feather='x-circle' style='color: gray; height: 1.5em; width: 1.5em;'>out</i></a>";
                }
              }
            },
            "defaultContent": "",
          },
          {
            "title": "Remarks",
            "data": null, render: function (data,type,row)
            {
              if(data.change == "true")
              {
                data.remarks = data.remarks.replace('\'', '&quot;');
                if(data.remarks != "" && (data.remarks.includes("OTL") || data.remarks.includes("otl")))
                {
                  return "<div class='row'><div class='col'>"+data.remarks+"</div><div class='col'><span class=\"r-tooltip\" data-tippy-content=\""+data.remarks+"\" tabindex=\"0\"><a class=\"btn-sm btn-primary\" href=\"javascript:this.change_remark(\"" + encodeURIComponent(data.remarks).replace(/[!'()*]/g, escape) + "\",'"+data.uname+"')\"><i data-feather='message-square' style='color: white; fill: white; height: 1.5em; width: 1.5em;'></i><span class='d-none d-xl-inline'> Change Remark</span></a></span>&ensp;<a style='color: gray; font-size:9;'></a><span class=\"r-tooltip\" data-tippy-content=\"Return from Lunch\" tabindex=\"0\"><a id="+data.uname+" class=\"btn-sm btn-primary returnfromlunch\" href=\"#\"><i data-feather='coffee' style='color: white; height: 1.5em; width: 1.5em;'></i><span class='d-none d-xl-inline'> Return from Lunch</span></a></span>&ensp;<span class=\"r-tooltip\" data-tippy-content=\"Clear Remarks\" tabindex=\"0\"><a class='btn-danger btn-sm' href=\"javascript:this.clear_remarks('" + data.remarks + "','"+data.uname+"')\"><i data-feather='delete' style='color: white; height: 1.5em!important; width: 1.5em!important;'></i><span class='d-none d-xl-inline'> Clear Remark</span></a></span></div></div>";
                }
                else if (data.remarks != "")
                {
                  return "<div class='row'><div class='col'>"+data.remarks+"</div><div class='col'><span class=\"r-tooltip\" data-tippy-content=\""+data.remarks+"\" tabindex=\"0\"><a class=\"btn-sm btn-primary\" style='color: light-blue;' href=\"javascript:this.change_remark('" + encodeURI(data.remarks) + "','"+data.uname+"')\"><i data-feather='message-square' style='color: white; fill: white; height: 1.5em; width: 1.5em;'></i><span class='d-none d-xl-inline'> Change Remark</span></a></span>&ensp;<a style='color: gray; font-size:9;'></a><span class=\"r-tooltip\" data-tippy-content=\"Out to Lunch\" tabindex=\"0\"><a id="+data.uname+" class=\"btn-sm btn-secondary outtolunch\" href=\"#\"><i data-feather='coffee' style='color: light-blue; height: 1.5em!important; width: 1.5em!important;'></i><span class='d-none d-xl-inline'> Out to Lunch</span></a></span>&ensp;<span class=\"r-tooltip\" data-tippy-content=\"Clear Remarks\" tabindex=\"0\"><a class='btn-danger btn-sm' href=\"javascript:this.clear_remarks('" + data.remarks + "','"+data.uname+"')\"><i data-feather='delete' style='color: white; height: 1.5em!important; width: 1.5em!important;'></i><span class='d-none d-xl-inline'> Clear Remark</span></a></span></div></div>";
                }
                else
                {
                  // return "<div class='row'><div class='col'>&nbsp;</div><div class='col'><span class=\"r-tooltip\" data-tippy-content=\"(no remark set)\" tabindex=\"0\"><a class=\"btn-sm btn-light shadow-lg\" style='color:blue;' href=\"javascript:this.change_remark('" + encodeURI(data.remarks) + "','"+data.uname+"')\"><i data-feather='message-square' style='color: blue; height: 1.5em!important; width: 1.5em!important;'>Set Remark</i> Set Remark</a></span>&ensp;<a style='color: gray; font-size:9;'></a><span class=\"r-tooltip\" data-tippy-content=\"Out to Lunch\" tabindex=\"0\"><a class=\"btn-sm btn-secondary\" href=\"javascript:this.out_to_lunch('" + data.remarks + "','"+data.uname+"')\"><i data-feather='coffee' style='color: light-blue; height: 1.5em!important; width: 1.5em!important;'></i> Out to Lunch</a></span></div></div>";
                  return "<div class='row'><div class='col'>&nbsp;</div><div class='col'><span class=\"r-tooltip\" data-tippy-content=\"(no remark set)\" tabindex=\"0\"><a class=\"btn-sm btn-light shadow-lg\" style='color:blue;' href=\"javascript:this.change_remark('" + encodeURI(data.remarks) + "','"+data.uname+"')\"><i data-feather='message-square' style='color: blue; height: 1.5em!important; width: 1.5em!important;'></i><span class='d-none d-xl-inline'> Set Remark</span></a></span>&ensp;<a style='color: gray; font-size:9;'></a><span class=\"r-tooltip\" data-tippy-content=\"Out to Lunch\" tabindex=\"0\"><a id="+data.uname+" class=\"btn-sm btn-secondary outtolunch\" href=\"#\"><i data-feather='coffee' style='color: light-blue; height: 1.5em!important; width: 1.5em!important;'></i><span class='d-none d-xl-inline'> Out to Lunch</span></a></span></div></div>";
                }
              }
              else
              {
                if (data.remarks != "")
                {
                  return data.remarks;
                }
                else
                {
                  return "&nbsp;";
                }
              }
            },
            "defaultContent": "&nbsp;",
          },
      ],
      "columnDefs": 
      [ 
        { className: "text-wrap", "targets":  4  },
        { className: "align-middle", "targets":  [0,1,2,3,4]  }
      ],
      "rowCallback": function( row, data, index ) 
      {
        if(data.change == "true" && data.uname == data.user)
        {
          $('td', row).addClass('you');
        }
        if(data.remarks.includes("OTL") || data.remarks.includes("otl"))
        {
          $('td:eq(1)', row).addClass('otl');
          $('td', row).addClass('lunch');
        }
      },
      "drawCallback": function(settings){
        feather.replace();
        tippy('.r-tooltip', { 
            arrow: false 
        });
        tippy('.hours', { 
            placement: 'right',
            arrow: false 
        });
      } 
    });
    setInterval( function () {
      oTable.ajax.reload();
  }, 30000 );
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
<div style="display:flex;position:fixed;width:100%;left:1.5em;bottom:0em;z-index:1030"> 
  <?php if (! $update && ! $readonly) { ?>
    <div id="alert" style="width:96%;" class="alert alert-primary fade show" role="alert">
      <strong>You are now in view only mode.</strong>
    </div>
  <?php } elseif (! $readonly) { ?>
    <div id="alert" style="width:96%;" class="alert alert-danger fade show" role="alert">
      <strong>You are now in update mode.</strong>
    </div>
    <?php } else { echo "&nbsp;"; } ?>
</div>

<?php include 'modals/ob_lunch_modals.php'; ?>
<?php include 'modals/ob_remark_modals.php'; ?>
<?php include 'include/header_extensions.php'; ?>
  <div class="container-fluid" >
    <div class="row justify-content-center" style="height:70vh;">
      <div class="<?php if (! $update && ! $readonly) { echo "col-4"; } else { echo "col-9"; } ?>  m-3 p-3 shadow-lg card-body bg-light" >
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
        .nav-pills:not(.nav-link.active), .nav-pills:not(.show>.nav-link) {
          color: #212529;
          background-color: #f8f9fa;
        }
        .nav-link-white{
          color: #212529;
          background-color: #f8f9fa;
          border-radius: 0rem!important;
        }
      </style>
      <div id="right-side" style="display: flex; flex-wrap: wrap; box-sizing: border-box; max-width: 50%;" class="m--3 p-3 shadow--lg card-body bg--light <?php if ($update && ! $readonly) { echo "update"; } ?>">
        <div id="pills-vert" class="cole-1 mr-e5" style="position: fixed;">
          <nav class="" id="tabs" style="height: auto;" >
            <ul class="nav flex-column nav-pills" id="myTab" role="tablist" style="z-index: 940; padding-bottom: 0px;">
              <li class="nav-item " role="presentation">
                <a class="nav-link nav-link-white active" id="calendar-tab" data-toggle="tab" href="#caldiv" role="tab" aria-controls="detail" aria-selected="true"><i class="far fa-calendar-alt"></i></a>
              </li>
              <li class="nav-item " role="presentation">
                <a class="nav-link nav-link-white" id="extensions-tab" data-toggle="tab" href="#ext" role="tab" aria-controls="detail" aria-selected="false"><i data-feather='phone' ></i></a>
              </li>
              <li class="nav-item " role="presentation">
                <a class="nav-link nav-link-white" id="timesheet-tab" data-toggle="tab" href="#time" role="tab" aria-controls="detail" aria-selected="false"><i data-feather='clock' ></i></a>
              </li>
            </ul>
          </nav>
        </div>
        <div id="object-div" class="col--10 shadow-lg card-body bg-light">
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade in show active" id="caldiv" role="tabpanel" aria-labelledby="calendar-tab" style="position: relative; z-index: 940;">
              <div id="calendar"></div>
            </div>
            <div class="tab-pane fade " id="ext" role="tabpanel" aria-labelledby="calendar-tab" style="position: relative; z-index: 940;">
              <div class="col--6 m--2 p--3 shadow--lg card--body bg--light">
                <table id="ext-table" class='table table-striped table-hover table-borderless table-sm smol' style="background-color: white !important; margin-top: 0px !important;" >
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
            <div class="tab-pane fade " id="time" role="tabpanel" aria-labelledby="time-tab" style="position: relative; z-index: 940;">
              <iframe src="tcfEmp-iFrame.php" height="90%" width="100%" sandbox="allow-same-origin allow-scripts"></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php 
include 'include/eventpopup.php';
include 'include/readupdate_fab.php'; 
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