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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
  <!-- Outboard CSS -->
  <link rel="stylesheet" type="text/css" href="/css/util.css">
	<link rel="stylesheet" type="text/css" href="/css/tabs.css?v1.0.0.4">
  <link rel="stylesheet" type="text/css" href="/css/search.css">
  <link rel="stylesheet" type="text/css" href="/css/fixed-action-button.css?v1.0.0.0">
	<!-- Bootstrap core CSS -->
  <link href="WSB/stylesheet/bootstrap.min.css?v1" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="/css/maintest.css?=v1.0.0.6.9">
  <link href="WSB/stylesheet/offcanvas.css?v1" rel="stylesheet">
	<link href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' rel='stylesheet'>
  <link rel="stylesheet" type="text/css" href="css/glyphicons.css?v1.0.0.8">
  <!-- JQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <!-- DataTables -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/af-2.3.5/b-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/af-2.3.5/b-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.js"></script>
  <!-- FullCalendar -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.2.0/main.min.css" integrity="sha256-uq9PNlMzB+1h01Ij9cx7zeE2OR2pLAfRw3uUUOOPKdA=" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.2.0/main.min.js" integrity="sha256-izRz5kNrZijklla/aBIkhdoxtbRpqQzHaaABtK0Tqe4=" crossorigin="anonymous"></script>
  <!-- Bootstrap Core JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <!-- Bootstrap Datepicker JS-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
  <!-- BootBox JS -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js" integrity="sha512-8vfyGnaOX2EeMypNMptU+MwwK206Jk1I/tMQV4NkhOz+W8glENoMhGyU6n/6VgQUhQcJH8NqQgHhMtZjJJBv3A==" crossorigin="anonymous"></script> -->
  <!-- Popper.js -->
  <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
  <!-- Tippy.js -->
  <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
  <!-- Bootstrap Datepicker CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css"/>
  <!-- Feather Icons JS -->
  <script src="https://unpkg.com/feather-icons"></script>
  <!-- Hide Empty Columns DataTables Custom Function -->
  <script src="/js/dataTables.hideEmptyColumns.js"></script>
  <script src="https://kit.fontawesome.com/634c08e21e.js" crossorigin="anonymous"></script>
  <script Language="JavaScript">
    function myReload() {
      self.location = "<?php echo $baseurl ?>?noupdate=1";
    }
    t = setTimeout("myReload()",<?php echo $update_msec ?>);
  </script>
<script type="text/javascript" class="init">
  $(document).ready(function() {
    $("#alert").fadeTo(2000, 500).slideUp(500, function(){
    $("#alert").slideUp(500);
    });
    var update = <?php echo $update; ?>;
    var oTable = $('#table').on( 'init.dt', function () {
        console.log( 'Table initialisation complete: '+new Date().getTime() );
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
        "url" : "ob.ajax.1.php",
        "data": {
            "noupdate": update,
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
                return "<a href=\"outboard.php?in=1&userid="+data.uname+"#"+data.uname+"\"><i class='hover-check' data-feather='check-circle' style='color: gray; height: 1.5em; width: 1.5em;'>in</i></a>";
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
                
                return "<a href=\"outboard.php?rw=1&userid="+data.uname+"#"+data.uname+"\"><i class='hover-check' data-feather='check' style='color: gray; height: 1.5em; width: 1.5em;'>in</i></a>";
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
                  return "<a href=\"outboard.php?out=1&userid="+data.uname+"#"+data.uname+"\"><i class='hover-x' data-feather='x-circle' style='color: gray; height: 1.5em; width: 1.5em;'>out</i></a>";
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
                  return "<div class='row'><div class='col'>"+data.remarks+"</div><div class='col'><span class=\"r-tooltip\" data-tippy-content=\""+data.remarks+"\" tabindex=\"0\"><a class=\"btn-sm btn-primary\" href=\"javascript:this.change_remark(\"" + encodeURIComponent(data.remarks).replace(/[!'()*]/g, escape) + "\",'"+data.uname+"')\"><i data-feather='message-square' style='color: white; fill: white; height: 1.5em; width: 1.5em;'>Change Remark</i> Change Remark</a></span>&ensp;<a style='color: gray; font-size:9;'></a><span class=\"r-tooltip\" data-tippy-content=\"Return from Lunch\" tabindex=\"0\"><a id="+data.uname+" class=\"btn-sm btn-primary returnfromlunch\" href=\"#\"><i data-feather='coffee' style='color: white; height: 1.5em; width: 1.5em;'></i> Return from Lunch</a></span>&ensp;<span class=\"r-tooltip\" data-tippy-content=\"Clear Remarks\" tabindex=\"0\"><a class='btn-danger btn-sm' href=\"javascript:this.clear_remarks('" + data.remarks + "','"+data.uname+"')\"><i data-feather='delete' style='color: white; height: 1.5em!important; width: 1.5em!important;'></i> Clear Remark</a></span></div></div>";
                }
                else if (data.remarks != "")
                {
                  return "<div class='row'><div class='col'>"+data.remarks+"</div><div class='col'><span class=\"r-tooltip\" data-tippy-content=\""+data.remarks+"\" tabindex=\"0\"><a class=\"btn-sm btn-primary\" style='color: light-blue;' href=\"javascript:this.change_remark('" + encodeURI(data.remarks) + "','"+data.uname+"')\"><i data-feather='message-square' style='color: white; fill: white; height: 1.5em; width: 1.5em;'>Change Remark</i> Change Remark</a></span>&ensp;<a style='color: gray; font-size:9;'></a><span class=\"r-tooltip\" data-tippy-content=\"Out to Lunch\" tabindex=\"0\"><a class=\"btn-sm btn-secondary\" href=\"javascript:this.out_to_lunch('" + data.remarks + "','"+data.uname+"')\"><i data-feather='coffee' style='color: light-blue; height: 1.5em!important; width: 1.5em!important;'></i> Out to Lunch</a></span>&ensp;<span class=\"r-tooltip\" data-tippy-content=\"Clear Remarks\" tabindex=\"0\"><a class='btn-danger btn-sm' href=\"javascript:this.clear_remarks('" + data.remarks + "','"+data.uname+"')\"><i data-feather='delete' style='color: white; height: 1.5em!important; width: 1.5em!important;'></i> Clear Remark</a></span></div></div>";
                }
                else
                {
                  return "<div class='row'><div class='col'>&nbsp;</div><div class='col'><span class=\"r-tooltip\" data-tippy-content=\"(no remark set)\" tabindex=\"0\"><a class=\"btn-sm btn-light shadow-lg\" style='color:blue;' href=\"javascript:this.change_remark('" + encodeURI(data.remarks) + "','"+data.uname+"')\"><i data-feather='message-square' style='color: blue; height: 1.5em!important; width: 1.5em!important;'>Set Remark</i> Set Remark</a></span>&ensp;<a style='color: gray; font-size:9;'></a><span class=\"r-tooltip\" data-tippy-content=\"Out to Lunch\" tabindex=\"0\"><a class=\"btn-sm btn-secondary\" href=\"javascript:this.out_to_lunch('" + data.remarks + "','"+data.uname+"')\"><i data-feather='coffee' style='color: light-blue; height: 1.5em!important; width: 1.5em!important;'></i> Out to Lunch</a></span></div></div>";
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
      }
    });
  });
</script>
<?php if ($launch = getGetValue('launch')) { ?>
<Script Language="JavaScript"> window.focus(); </Script>
<?php } ?>
<style type="text/css">
  main > div { display: block!important;}
  #listob {
    float: left;
    width: 25%;
    margin: 0 20px 20px 0;
  }	 
  .table > thead {
    font-style: normal!important;
    font-stretch: condensed!important;
    font-size: 12px;
  }
  thead, tbody, a {
  }
  table.dataTable tbody td {
    word-break: break-word;
    vertical-align: top;
  }
  .text-wrap{
      white-space:normal!important;
  }
  .lg-icon {
    width: 1.625rem;
    height: 1.625rem;
    vertical-align: -webkit-baseline-middle;
  }
  .btn-group-lg>.btn,.btn-lg {
    padding: 1rem!important;
    font-size: 1.25rem;
    line-height: 1.5!important;
    border-radius: .3rem;
  }
  .fc-more-popover > .fc-widget-header > span.fc-title { color: black!important; }
  span.fc-title { color: white!important;  }
  .user 
  {
      background-color: #17a2b8;
  }
  .h-75 { height: 75%!important;}
  .fc-daygrid-event { line-height:1!important; }
  .shadow-lg 
  {
      box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
  }
  .poppins 
  {
    font-family: "Poppins-Regular";
    font-size: 14px;
    font-weight: 400;
  }
  .hover-check:hover { color: green!important; }
  .hover-x:hover { color: red!important; }
  .you { background-color: #ABCDEF!important;}
  .lunch { background-color: rgba(255, 220, 40, 0.15)!important;}
</style>
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
      events: 'cal_load.php',
    });
    calendar.render();
  });	
</script>
<style>
  #calendar {
      height: 80vh;
      width: auto;
    }	 
  #listcal {
      float: right;
    width: 25%;
      margin: 0 20px 20px 0;
    }	 
    th.dt-center, td.dt-center, .align-middle { text-align: center; }
    .update { display: none;}
</style>
</head>
<body style="background-color: #0e5092;">
<script language="JavaScript1.2">
  function change_remark(remark,userid) {
    var newremark = prompt("Enter your remarks below:",remark);
    if (newremark != null) {
      self.location="<?php echo $baseurl ?>?remarks="
		    + escape(newremark) + "&userid=" +userid + "#<?php echo $userid ?>";
    }
  }
  function out_to_lunch(remark,userid) {
    var newremark = prompt("Approximately what time will you return?");
    var rto = "OTL; will return around ";
    if (newremark != null) {
      self.location="<?php echo $baseurl ?>?remarks=" + escape(rto) + ""
		    + escape(newremark) + "&out=1&userid=" +userid + "#<?php echo $userid ?>";
    }
  }
  function clear_remarks(remark,userid) {
    alert("Remark cleared.");
    self.location="<?php echo $baseurl ?>?remarks=" + "&userid=" +userid + "#<?php echo $userid ?>";
  }
  function end_lunch_rw() {
      var userid = $('#rtw').attr("value");  
      $('#lunchModal').modal('hide');
      self.location="<?php echo $baseurl ?>?remarks=" + "&rw=1&userid=" +userid + "#<?php echo $userid ?>";
  }
  function end_lunch_in() {
      var userid = $('#itw').attr("value");  
      $('#lunchModal').modal('hide');
      self.location="<?php echo $baseurl ?>?remarks=" + "&in=1&userid=" +userid + "#<?php echo $userid ?>";
  }
  $(document).on('click', '.returnfromlunch', function(){  
    var userid = $(this).attr("id");  
    $('#lunchModal').modal('show');
    $('#rtw').val(userid);  
    $('#itw').val(userid);  
  });
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
        <button id="rtw" type="button" onclick="end_lunch_rw();" value="usr" class="btn btn-primary">Check in remotely</button>
        <button id="itw" type="button" onclick="end_lunch_in();" value="usr" class="btn btn-success">Check in office</button>
      </div>
    </div>
  </div>
</div>
<!-- top of page header w/logo-->
<?php include 'header_extensions.php'; ?>
  <div class="container-fluid" >
    <div class="row justify-content-center" style="height:70vh;">
      <div class="<?php if (! $update && ! $readonly) { echo "col-4"; } else { echo "col-9"; } ?>  m-3 p-3 shadow-lg card-body bg-light" >
        <table id="table" class="table table-striped table-hover table-borderless smol" >
        <thead><tr>
            <th>Name</th>
            <!-- <th>Core Hours</th> -->
            <th>In</th>
            <th><span data-tippy-content="Remote Work" tabindex="0">RW</span></th>
            <th>Out</th>
            <th>Remarks</th>
          </tr></thead>
          <tr>
            <th>Name</th>
            <!-- <th>Hours</th> -->
            <th>In</th>
            <th>RW</th>
            <th>Out</th>
            <th>Remarks</th>
          </tr> 
        </table>
      </div>
      <div class="col-6 m-3 p-3 shadow-lg card-body bg-light <?php if ($update && ! $readonly) { echo "update"; } ?>"><div id="calendar"></div></div>
    </div>
  </div>
<!--	 ##################################################################################################-->
	 <!-- Event popup with info-->
	 <div id="eventContent" class="eventContent" style="display: none; border: 1px solid #005eb8; position: absolute; background: #fcf8e3; width: 30%; opacity: 1.0; padding: 4px; color: #005eb8; z-index: 2000; line-height: 1.1em;">
    <a style="float: right;"><i class="fa fa-times closeEvent" aria-hidden="true"></i></a><br />
    Event: <span id="eventTitle" class="eventTitle"></span><br />
    Start: <span id="startTime" class="startTime"></span><br />
    End: <span id="endTime" class="endTime"></span><br /><br />
	</div>
<!--	 ##################################################################################################-->
<!-- Fixed Action Button -->
<div class="fixed-action-btn" style="bottom: 45px; left: 24px; z-index:1500;">
<?php if (! $update && ! $readonly) { ?>
  <a class="btn-floating btn-lg btn-info bg-danger cs" href="/outboard.php?update=1#<?php echo $username ?>"> <!-- data-toggle="tooltip" data-placement="left" title="Change Status"> -->
  <i class="lg-icon" data-feather="edit-3" ></i>
<?php } elseif (! $readonly) { ?>
  <a class="btn-floating btn-lg btn-info bg-sog vs" href="/outboard.php?noupdate=1"> <!-- data-toggle="tooltip" data-placement="left" title="View Status"> -->
  <i class="lg-icon" data-feather="eye" ></i>
<?php } else { echo "&nbsp;"; } ?>
  </a>
</div>
  <!-- Fixed Action Button -->
<script>
tippy('.cs', { 
  content: "Change Status",
  theme: 'light',
  placement: 'left',
  arrow: false
})
tippy('.vs', { 
  content: "View Status",
  theme: 'light',
  placement: 'left',
  arrow: false })
</script>
</body>
</html>