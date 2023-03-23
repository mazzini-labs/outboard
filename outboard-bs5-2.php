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
  <?php  include 'include/dependencies.bs5.php'; ?>
  <!-- <link rel="stylesheet" type="text/css" href="assets/css/ob.css?v=1.0"> -->
  <script Language="JavaScript">
    function myReload() {
      self.location = "/outboard?noupdate=1";
    }
    // t = setTimeout("myReload()",<?php echo $update_msec ?>);
  </script>

<!-- <script type="text/javascript" class="init" src="/assets/js/datatables.ob.js?v1.0.0.33">
// var update = <?php //echo $update; ?>
</script> -->
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
<link href="assets/css/sidebars.css" rel="stylesheet">
</head>
<body style="background-color: #0e5092;">

<script>
  var update = 0;
  var url = "ob.ajax.2.php";
  // Example POST method implementation:
  async function postData(url = '', data = {}) {
    // Default options are marked with *
    const response = await fetch(url, {
      method: 'POST', // *GET, POST, PUT, DELETE, etc.
      mode: 'cors', // no-cors, *cors, same-origin
      cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
      credentials: 'same-origin', // include, *same-origin, omit
      headers: {
        'Content-Type': 'application/json'
        // 'Content-Type': 'application/x-www-form-urlencoded',
      },
      redirect: 'follow', // manual, *follow, error
      referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
      body: JSON.stringify(data) // body data type must match "Content-Type" header
    });
    return response.json(); // parses JSON response into native JavaScript objects
    // return response;
  }
  async function getData(url = '', data = {}) {
    // Default options are marked with *
    const response = await fetch(url, {
      method: 'GET', // *GET, POST, PUT, DELETE, etc.
      mode: 'cors', // no-cors, *cors, same-origin
      cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
      credentials: 'same-origin', // include, *same-origin, omit
      headers: {
        'Content-Type': 'application/json'
        // 'Content-Type': 'application/x-www-form-urlencoded',
      },
      redirect: 'follow', // manual, *follow, error
      referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
    });
    return response.json(); // parses JSON response into native JavaScript objects
  }

  // postData(url, { update: 1 })
  //   .then(data => {
  //     console.log(data); // JSON data parsed by `data.json()` call
  //   });
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
    let user = document.querySelector('#rtw');
    let remarks = "clear";
    // var userid = $('#rtw').attr("value");  
    $('#lunchModal').modal('hide');
    postData(url, {
      "status": 2,
      "user": user.value,
      "update": 1,
      "remarks": remarks
    })
    // self.location="<?php echo $baseurl ?>?remarks=" + "&rw=1&userid=" +userid + "&update=1";
  }
  function end_lunch_in() {
    let user = document.querySelector('#itw');
    let remarks = "clear";
    // var userid = $('#itw').attr("value");  
    $('#lunchModal').modal('hide');
    postData(url, {
      "status": 1,
      "user": user.value,
      "update": 1,
      "remarks": remarks
    })
    // self.location="<?php echo $baseurl ?>?remarks=" + "&in=1&userid=" +userid + "&update=1";
  }
  $(document).on('click', '.returnfromlunch', function(){  
    var userid = $(this).attr("id");
    let user = this;
    let rtw = document.querySelector('#rtw');
    let itw = document.querySelector('#itw');
    let update = 1;
    rtw.value = user.id;
    itw.value = user.id;  
    Notiflix.Confirm.show(
    'Return from lunch',
    'Are you checking back into the office or remotely?',
    'In office',
    'Remotely',
    function inOfficeCb() {
      end_lunch_in();
      Notiflix.Report.success(
          'In Office',
          'You have been checked into the office.',
          'Close',
      );
      dataTableReload(update);
    },
    function remotelyCb() {
      end_lunch_rw();
      Notiflix.Report.success(
          'Remotely',
          'You have been checked in remotely.',
          'Close',
          {
            success: {
              svgColor: '#26c0d3',
              buttonBackground: '#26c0d3',
              backOverlayColor: 'rgba(38,192,211,0.2)',
            }
          },
      );
      dataTableReload(update);
    },
    {
      // svgColor: '#eebf31',
      cancelButtonBackground: '#26c0d3',
    },
    );
    
    // oTable.ajax.reload(function(d){
    //     d.update = update;
    // });

    // $('#lunchModal').modal('show');
    // $('#rtw').val(userid);  
    // $('#itw').val(userid);  
  });
  $(document).on('click', '.outtolunch', function(){  

    var userid = $(this).attr("id");  

    // <div class="bootstrap-datetimepicker-widget usetwentyfour bottom" style="inset: 0px auto auto 0px;"><ul class="list-unstyled"><li class="picker-switch accordion-toggle"><table class="table-condensed"><tbody><tr></tr></tbody></table></li><li><div class="timepicker"><div class="timepicker-picker"><table class="table-condensed"><tr><td><a href="#" tabindex="-1" title="Increment Hour" class="btn" data-action="incrementHours"><span class="glyphicon glyphicon-chevron-up"></span></a></td><td class="separator"></td><td><a href="#" tabindex="-1" title="Increment Minute" class="btn" data-action="incrementMinutes"><span class="glyphicon glyphicon-chevron-up"></span></a></td></tr><tr><td><span class="timepicker-hour" data-time-component="hours" title="Pick Hour" data-action="showHours">02</span></td><td class="separator">:</td><td><span class="timepicker-minute" data-time-component="minutes" title="Pick Minute" data-action="showMinutes">21</span></td></tr><tr><td><a href="#" tabindex="-1" title="Decrement Hour" class="btn" data-action="decrementHours"><span class="glyphicon glyphicon-chevron-down"></span></a></td><td class="separator"></td><td><a href="#" tabindex="-1" title="Decrement Minute" class="btn" data-action="decrementMinutes"><span class="glyphicon glyphicon-chevron-down"></span></a></td></tr></table></div><div class="timepicker-hours" style="display: none;"><table class="table-condensed"><tr><td data-action="selectHour" class="hour">00</td><td data-action="selectHour" class="hour">01</td><td data-action="selectHour" class="hour">02</td><td data-action="selectHour" class="hour">03</td></tr><tr><td data-action="selectHour" class="hour">04</td><td data-action="selectHour" class="hour">05</td><td data-action="selectHour" class="hour">06</td><td data-action="selectHour" class="hour">07</td></tr><tr><td data-action="selectHour" class="hour">08</td><td data-action="selectHour" class="hour">09</td><td data-action="selectHour" class="hour">10</td><td data-action="selectHour" class="hour">11</td></tr><tr><td data-action="selectHour" class="hour">12</td><td data-action="selectHour" class="hour">13</td><td data-action="selectHour" class="hour">14</td><td data-action="selectHour" class="hour">15</td></tr><tr><td data-action="selectHour" class="hour">16</td><td data-action="selectHour" class="hour">17</td><td data-action="selectHour" class="hour">18</td><td data-action="selectHour" class="hour">19</td></tr><tr><td data-action="selectHour" class="hour">20</td><td data-action="selectHour" class="hour">21</td><td data-action="selectHour" class="hour">22</td><td data-action="selectHour" class="hour">23</td></tr></table></div><div class="timepicker-minutes" style="display: none;"><table class="table-condensed"><tr><td data-action="selectMinute" class="minute">00</td><td data-action="selectMinute" class="minute">05</td><td data-action="selectMinute" class="minute">10</td><td data-action="selectMinute" class="minute">15</td></tr><tr><td data-action="selectMinute" class="minute">20</td><td data-action="selectMinute" class="minute">25</td><td data-action="selectMinute" class="minute">30</td><td data-action="selectMinute" class="minute">35</td></tr><tr><td data-action="selectMinute" class="minute">40</td><td data-action="selectMinute" class="minute">45</td><td data-action="selectMinute" class="minute">50</td><td data-action="selectMinute" class="minute">55</td></tr></table></div></div></li></ul></div>
    
    // Notiflix.Confirm.prompt(
    // 'Out to Lunch',
    // '<div class="input-group input-group-sm"><input name="lunchtime" id="lunchtime" type="hidden" autocomplete="off" value="00:00" class="form-control without_ampm" ></div>',
    // 'Awesome!',
    // 'Answer',
    // 'Cancel',
    // function okCb(clientAnswer) {
    // alert('Client answer is: ' + clientAnswer);
    // },
    // function cancelCb(clientAnswer) {
    // alert('Client answer was: ' + clientAnswer);
    // },
    // {
    // },
    // );
    $('#takeLunchModal').modal('show');
    // $('#NotiflixConfirmWrap').modal('show');
    $('#otl').val(userid);  
  });
  
  // $(document).on('click', '.remark', function(){  
  //   var userid = $(this).attr("id");  
  //   $('#setRemarkModal').modal('show');
  //   $('#remarkUser').val(userid);  
  // });
  function otl() {
    
      let user = document.querySelector('#otl');
      let time = document.querySelector('#lunchtime');
      let rto = "OTL; will return around " + time.value;
      let update = 0;
      let modal = '#takeLunchModal';
      // var userid = $('#otl').attr("value"); 
      // var time = $('#lunchtime').attr("value");
      // var rto = "OTL; will return around " + time; 

      postData(url, { 
        "user": user.value,
        "remarks": rto,
        "status": 3,
        "update": update
      }).then(dataTableHideModal(update, modal));
      // $('#takeLunchModal').modal('hide');

      // dataTableReload(update);
  }
  function set_remark() {
      // var userid = $('#remarkUser').attr("value"); 
      // var newremark = $('#remark').val();
      let user = document.querySelector('#remarkUser');
      let nr = document.querySelector("#remark");
      let update = 1;
      let modal = '#setRemarkModal';
      postData(url, {
      "remarks": nr.value,
      "user": user.value,
      "update": update
      }).then(dataTableHideModal(update, modal));
      // oTable.ajax.reload(function(d){
      //     d.update = update;
      // }).one( 'draw', function () {
      //   $('#setRemarkModal').modal('hide');
      // });
      
      // $('#setRemarkModal').modal('hide');
      // self.location="<?php echo $baseurl ?>?remarks="
		  //   + escape(newremark) + "&userid=" +userid + "&update=1";
      
  }
  $(document).on('click', '.remark', function(){
    let user = this.dataset.user;
    let remark = this.dataset.remark;
    if (remark == ""){
      remark = "Insert remarks..."
    }
    let update = 1;
    
    Notiflix.Confirm.prompt(
      'Remarks',
      'Please set your remarks below',
      remark,
      'Set Remark',
      'Cancel',
      function okCb(clientAnswer) {
        
        postData(url, {
          "remarks": clientAnswer,
          "user": user,
          "update": update
        }).then(dataTableSetRemark(update));
      // alert('Client answer is: ' + clientAnswer);
      },
      {
        // callback function for cancel button
      },
      {
        // other options
      },
    );
    // let rf = document.querySelector('#remark_form');
    // let r = document.querySelector("#remark");
    // rf.reset(); // $('#remark_form')[0].reset();  
    // rf.setAttribute('placeholder', "");
    // $('#setRemarkModal').modal('show');
    // document.querySelector('#remarkUser').value = user; // $('#remarkUser').val(userid);
    // if (remark != ""){
    //   r.setAttribute('placeholder', remark) // $('#remark').attr('placeholder',remark);
    // }  
    
  })
  $(document).ready(function() {
    var click = 0;
    $('#extensions-tab').on('shown.bs.tab', function (e) {
      // .click(function(){
      if(click < 1){
          click++;
          var extTable = $('#ext-table').DataTable( {
            "ajax": "ajax/extension.php",
            "order": [],
            "paging": true,
            "info": false,
            "searching": true,
            "sDom": 't',
            deferRender: true,
            scrollY: "60vh",
            scroller: true,
            "autoWidth": false,
            "columns": [
                {
                "data": "name", // can be null or undefined
                "defaultContent": ""
                },
                {
                "data": "title", // can be null or undefined
                "defaultContent": ""
                },
                {
                "data": "extension", // can be null or undefined
                "defaultContent": ""
                },
                {
                "data": "email", // can be null or undefined
                "defaultContent": ""
                }
            ]
          } );
      }
    });
    $(document).on('click', '.change', function(){  
      postData(url, {
        "status": this.dataset.status,
        "user": this.dataset.user,
        "update": this.dataset.update
      });
      let update = this.dataset.update;
      // dataTableReload(this.dataset.update);
      // oTable.ajax.reload(function(d){
      //     d.update = update;
      // });
      viewChangeStatus();
      console.log(this.dataset.status) // "3"
      console.log(this.dataset.user) // "12314"
      console.log(this.dataset.update) // "cars"
    });
    $(document).on('click', '.clear-remarks', function(){
      
      // $('#clearRemarkModal').modal('show');
      let user = this.dataset.user;
      let update = 1;
      let remarks = "clear";
      postData(url, {
        "remarks": remarks,
        "user": user,
        "update": 1
        });
      // oTable.ajax.reload(function(d){
      //     d.update = update;
      // });
      // Notiflix.Report.success(
      //     'Remark Cleared',
      //     'Your remark has been cleared.',
      //     'Close',
      //     );
      dataTableClearRemark(update);
    });
    dataTableReload = (data) => {
      oTable.ajax.reload(function(d){
          d.update = data;
      });
    }
    dataTableClearRemark = (data) => {
      oTable.ajax.reload(function(d){
          d.update = data;
      }).one( 'draw', function () {
        Notiflix.Report.success(
          'Remark Cleared',
          'Your remark has been cleared.',
          'Close',
          );
        
      } );
    }
    dataTableSetRemark = (data) => {
      oTable.ajax.reload(function(d){
          d.update = data;
      }).one( 'draw', function () {
        Notiflix.Report.success(
          'Remark Set',
          'Your remark has been set.',
          'Close',
          );
        
      } );
    }
    dataTableHideModal = (data, modal) => {
      oTable.ajax.reload(function(d){
          d.update = data;
      }).one( 'draw', function () {
        $(modal).modal('hide');
      } );
    }
  
    tabMove();
    // tabResize();

    
    $.fn.dataTable.ext.errMode = 'none';
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
        data: function(d){
            d.update = update;
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
                return "<a class=\"change fake-a\" data-status=1 data-user="+data.uname+" data-update=0><i class='hover-check' data-feather='check-circle' style='color: gray; height: 1.5em; width: 1.5em;'>in</i></a>";
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
                
                return "<a class=\"change fake-a\" data-status=2 data-user="+data.uname+" data-update=0><i class='hover-check' data-feather='check' style='color: gray; height: 1.5em; width: 1.5em;'>in</i></a>";
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
                  return "<a class=\"change fake-a\" data-status=3 data-user="+data.uname+" data-update=0><i class='hover-x' data-feather='x-circle' style='color: gray; height: 1.5em; width: 1.5em;'>out</i></a>";
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
                  return "<div class='row'><div class='col'>"+data.remarks+"</div><div class='col'><span class=\"r-tooltip\" data-tippy-content=\""+data.remarks+"\" tabindex=\"0\"><a class=\"btn-sm btn-primary remark fake-a text-white\" data-remark=\""+data.remarks+"\" data-user="+data.uname+" data-href=\"javascript:this.change_remark(\"" + encodeURIComponent(data.remarks).replace(/[!'()*]/g, escape) + "\",'"+data.uname+"')\"><i data-feather='message-square' style='color: white; fill: white; height: 1.5em; width: 1.5em;'></i><span class='d-none d-xl-inline'> Change Remark</span></a></span>&ensp;<a style='color: gray; font-size:9;'></a><span class=\"r-tooltip\" data-tippy-content=\"Return from Lunch\" tabindex=\"0\"><a id="+data.uname+" class=\"btn-sm btn-primary returnfromlunch fake-a text-white\"><i data-feather='coffee' style='color: white; height: 1.5em; width: 1.5em;'></i><span class='d-none d-xl-inline'> Return from Lunch</span></a></span>&ensp;<span class=\"r-tooltip\" data-tippy-content=\"Clear Remarks\" tabindex=\"0\"><a class='btn-danger btn-sm text-white clear-remarks fake-a' data-remarks=\""+data.remarks+"\" data-user="+data.uname+" data-href=\"javascript:this.clear_remarks('" + data.remarks + "','"+data.uname+"')\"><i data-feather='delete' style='color: white; height: 1.5em!important; width: 1.5em!important;'></i><span class='d-none d-xl-inline'> Clear Remark</span></a></span></div></div>";
                }
                else if (data.remarks != "")
                {
                  return "<div class='row'><div class='col'>"+data.remarks+"</div><div class='col'><span class=\"r-tooltip\" data-tippy-content=\""+data.remarks+"\" tabindex=\"0\"><a class=\"btn-sm btn-primary remark fake-a text-white\" style='color: light-blue;' data-remark=\""+data.remarks+"\" data-user="+data.uname+" data-href=\"javascript:this.change_remark('" + encodeURI(data.remarks) + "','"+data.uname+"')\"><i data-feather='message-square' style='color: white; fill: white; height: 1.5em; width: 1.5em;'></i><span class='d-none d-xl-inline'> Change Remark</span></a></span>&ensp;<a style='color: gray; font-size:9;'></a><span class=\"r-tooltip\" data-tippy-content=\"Out to Lunch\" tabindex=\"0\"><a id="+data.uname+" class=\"btn-sm btn-secondary outtolunch fake-a text-white\"><i data-feather='coffee' style='color: light-blue; height: 1.5em!important; width: 1.5em!important;'></i><span class='d-none d-xl-inline'> Out to Lunch</span></a></span>&ensp;<span class=\"r-tooltip\" data-tippy-content=\"Clear Remarks\" tabindex=\"0\"><a class='btn-danger btn-sm text-white clear-remarks fake-a' data-remarks=\""+data.remarks+"\" data-user="+data.uname+" data-href=\"javascript:this.clear_remarks('" + data.remarks + "','"+data.uname+"')\"><i data-feather='delete' style='color: white; height: 1.5em!important; width: 1.5em!important;'></i><span class='d-none d-xl-inline'> Clear Remark</span></a></span></div></div>";
                }
                else
                {
                  // return "<div class='row'><div class='col'>&nbsp;</div><div class='col'><span class=\"r-tooltip\" data-tippy-content=\"(no remark set)\" tabindex=\"0\"><a class=\"btn-sm btn-light shadow-lg\" style='color:blue;' href=\"javascript:this.change_remark('" + encodeURI(data.remarks) + "','"+data.uname+"')\"><i data-feather='message-square' style='color: blue; height: 1.5em!important; width: 1.5em!important;'>Set Remark</i> Set Remark</a></span>&ensp;<a style='color: gray; font-size:9;'></a><span class=\"r-tooltip\" data-tippy-content=\"Out to Lunch\" tabindex=\"0\"><a class=\"btn-sm btn-secondary\" href=\"javascript:this.out_to_lunch('" + data.remarks + "','"+data.uname+"')\"><i data-feather='coffee' style='color: light-blue; height: 1.5em!important; width: 1.5em!important;'></i> Out to Lunch</a></span></div></div>";
                  return "<div class='row'><div class='col'>&nbsp;</div><div class='col'><span class=\"r-tooltip\" data-tippy-content=\"(no remark set)\" tabindex=\"0\"><a class=\"btn-sm btn-light shadow-lg remark fake-a\" style='color:blue;' data-remark=\""+data.remarks+"\" data-user="+data.uname+" data-href=\"javascript:this.change_remark('" + encodeURI(data.remarks) + "','"+data.uname+"')\"><i data-feather='message-square' style='color: blue; height: 1.5em!important; width: 1.5em!important;'></i><span class='d-none d-xl-inline'> Set Remark</span></a></span>&ensp;<a style='color: gray; font-size:9;'></a><span class=\"r-tooltip\" data-tippy-content=\"Out to Lunch\" tabindex=\"0\"><a id="+data.uname+" class=\"btn-sm btn-secondary outtolunch fake-a text-white\"><i data-feather='coffee' style='color: light-blue; height: 1.5em!important; width: 1.5em!important;'></i><span class='d-none d-xl-inline'> Out to Lunch</span></a></span></div></div>";
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
    // setInterval( function () {
    //   oTable.ajax.reload();
    // }, 30000 );
    let delay = 300000;

    let timerId = setTimeout(function request() {
      // ...send request...
      oTable.ajax.reload();
      oTable.on( 'error.dt', function ( e, settings, techNote, message ) {
        console.log( 'An error has been reported by DataTables: ', message );
        delay *=2;
      } )
      // .DataTable();
      // if (oTable.on('error')) {
      //   // increase the interval to the next run
      //   delay *= 2;
      // }

      timerId = setTimeout(request, delay);

    }, delay);

    // $(document).on('click', '.vs', function(){ 
    //   update = 0;
    //   oTable.ajax.reload();
    // });
    // $(document).on('click', '.cs', function(){
    //   update = 1;
    //   oTable.ajax.reload();
    // });
    $(document).on('click', '#fixedActionButton', function(){
      viewChangeStatus();
      console.log('clicked');
    });
    viewChangeStatus = () => {
      // var fab = document.querySelector(".fixed-action-button");
      // var current = fab.firstChildElement;
      
      let current = document.querySelector("#fixedActionButton");
      let view = document.querySelector("#viewIcon");
      let change = document.querySelector("#changeIcon");
      let ob = document.querySelector("#ob-div");
      let rs = document.querySelector("#right-side");
      // let updateNoti = Notiflix.Notify.info('You are now in update mode.', { position: 'center-bottom', info: { background: '#ff5549', }, showOnlyTheLastOne: true,});
      if(current.classList.contains('cs')){
        ob.classList.remove("col-4");
        ob.classList.add("col-9");
        update = 1;
        oTable.ajax.reload(function(d){
            d.update = update;
        });
        // var filterResolve = function() {
        //   var defer = $.Deferred(),
        //     filtered = defer.then(function( value ) {
        //       return Notiflix.Notify.info('You are now in update mode.', { position: 'center-bottom', info: { background: '#ff5549', }, showOnlyTheLastOne: true,});
        //     });
        
        //   defer.resolve( 5 );
        //   filtered.done(function( value ) {
            
        //   });
        // };
        oTable.one( 'draw', function () {
          // console.log("event.data = " + event.data);
          rs.classList.add("update");
          
          // remove cs & bg-danger classes
          current.classList.remove("cs");
          current.classList.remove("bg-danger");
          // add bg-sog & vs classes
          current.classList.add("vs")
          current.classList.add("bg-sog");

          change.classList.add("d-none");
          view.classList.remove("d-none");
          // select child element below a 
          // change data-feather=eye
          // run feather script
          Notiflix.Notify.info('You are now in update mode.', { position: 'center-bottom', info: { background: '#ff5549', }, showOnlyTheLastOne: true,});
        } );
        
        
        
      }
      else 
      {
        ob.classList.add("col-4");
        ob.classList.remove("col-9");
        update = 0;
        oTable.ajax.reload(function(d){
            d.update = update;
        });
        oTable.one( 'draw', function () {
          rs.classList.remove("update");
          
          // <?php if (! $update && ! $readonly) { echo "col-4"; } else { echo "col-9"; } ?>
          // remove bg-sog & vs classes
          current.classList.remove("vs")
          current.classList.remove("bg-sog");
          
          // add cs & bg-danger classes
          current.classList.add("cs");
          current.classList.add("bg-danger");

          view.classList.add("d-none");
          change.classList.remove("d-none");
          // select child element below a 
          // change data-feather=edit-3
          // run feather script
          
          Notiflix.Notify.info('You are now in view only mode.', {
            position: 'center-bottom',
            showOnlyTheLastOne: true,
          });
        });
      }
    
    }
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




<?php //include 'modals/ob_lunch_modals.php'; ?>
<?php //include 'modals/ob_remark_modals.php'; ?>
<?php include 'include/header_extensions.php'; ?>
<main class="d-flex flex-nowrap">
<div class="d-flex flex-column flex-shrink-0 bg-light" style="width: 4.5rem;">
    <a href="/" class="d-block p-3 link-dark text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="right">
      <svg class="bi pe-none" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
      <span class="visually-hidden">Icon-only</span>
    </a>
    <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
      <li class="nav-item">
        <a href="#" class="nav-link active py-3 border-bottom rounded-0" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right">
          <svg class="bi pe-none" width="24" height="24" role="img" aria-label="Home"><use xlink:href="#home"></use></svg>
        </a>
      </li>
      <li>
        <a href="#" class="nav-link py-3 border-bottom rounded-0" data-bs-toggle="tooltip" data-bs-placement="right">
          <svg class="bi pe-none" width="24" height="24" role="img" aria-label="Dashboard"><use xlink:href="#speedometer2"></use></svg>
        </a>
      </li>
      <li>
        <a href="#" class="nav-link py-3 border-bottom rounded-0" data-bs-toggle="tooltip" data-bs-placement="right">
          <svg class="bi pe-none" width="24" height="24" role="img" aria-label="Orders"><use xlink:href="#table"></use></svg>
        </a>
      </li>
      <li>
        <a href="#" class="nav-link py-3 border-bottom rounded-0" data-bs-toggle="tooltip" data-bs-placement="right">
          <svg class="bi pe-none" width="24" height="24" role="img" aria-label="Products"><use xlink:href="#grid"></use></svg>
        </a>
      </li>
      <li>
        <a href="#" class="nav-link py-3 border-bottom rounded-0" data-bs-toggle="tooltip" data-bs-placement="right">
          <svg class="bi pe-none" width="24" height="24" role="img" aria-label="Customers"><use xlink:href="#people-circle"></use></svg>
        </a>
      </li>
    </ul>
    <div class="dropdown border-top">
      <a href="#" class="d-flex align-items-center justify-content-center p-3 link-dark text-decoration-none dropdown-toggle" id="dropdownUser3" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="https://github.com/mdo.png" alt="mdo" width="24" height="24" class="rounded-circle">
      </a>
      <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser3">
        <li><a class="dropdown-item" href="#">New project...</a></li>
        <li><a class="dropdown-item" href="#">Settings</a></li>
        <li><a class="dropdown-item" href="#">Profile</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="#">Sign out</a></li>
      </ul>
    </div>
  </div>
  <div class="container-fluid" >
    <div class="row justify-content-center" style="height:70vh;">
      <div id="ob-div" class="m-3 p-3 shadow-lg card-body bg-light col-4" >
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
        .fake-a {
          /* color: #fff!important; */
          cursor: pointer!important;
        }
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
      <div id="right-side" style="display: flex; flex-wrap: wrap; box-sizing: border-box; max-width: 50%;" class="m--3 p-3 shadow--lg card-body bg--light">
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
// include 'include/readupdate_fab.php'; 
// include 'scripts.php';
?>
<style>
.fab-ob {
  bottom: 45px; left: 24px; z-index:1500;
}
</style>
<!-- Fixed Action Button -->
<div class="fixed-action-btn" style="bottom: 45px; left: 24px; z-index:1500;">
<?php // if (! $update && ! $readonly) { ?>
  <a id="fixedActionButton" class="btn-floating btn-lg btn-info fake-a bg-danger cs"> 
  
<?php // } elseif (! $readonly) { ?>
  <!-- <a id="fixedActionButton" class="btn-floating btn-lg btn-info bg-sog vs" href="#"> -->
  <i id="viewIcon" class="lg-icon d-none" style="stroke:white;" data-feather="eye" ></i><i id="changeIcon" class="lg-icon" style="stroke:white;" data-feather="edit-3" ></i>
<?php // } else { echo "&nbsp;"; } ?>
  </a>
</div>
<!-- Fixed Action Button -->
<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>

<?php
// include 'floating_action_button.php';
// include 'ddr_add_modal.php';
include 'scripts.php';  
?>
</main>
</body>

</html>