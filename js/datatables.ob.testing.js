$(document).ready(function() {
    var click = 0;
    const cs_user = document.querySelector('#csa');
    
    
    $("#alert").fadeTo(2000, 500).slideUp(500, function(){
    $("#alert").slideUp(500);
    });
    // function table_update(username)
    // {if (typeof username !== 'undefined' )
    //   {
    //       var userid = username;
    //   } 
    //   else 
    //   {
    //       var userid = cs_user.dataset.user;
    //   }
    //   $.ajax({
    //     // url: './ob.ajax.1.php',
    //     url: './ob.db.php',
    //     type: 'POST',
    //     dataType:"json",
    //     data: {userid:userid, out:1, update:1},
    //     success: function (data) { 
    //       update = data[0].updatebool;
    //       return window.update;
    //       // change = data[0].change;
    //       // console.log(data);
    //       // console.log(data[0].updatebool);
    //       // console.log(data[0].change);
    //       // update_view(update);
    //       // oTable.ajax.reload();
    //       // fab_content();
    //     }
    //   });}
    // table_update();
    var update = 0;
    var currentupdate = 0;
    function table_update(){
        var userid = cs_user.dataset.user;
        $.ajax({
            url: './ob.db.php',
            type: 'POST',
            dataType:"json",
            data: {userid:userid, out:1, update:1},
            success: function (data) { 
                update = data[0].updatebool;
                return window.update;
            }
        });
    }
    table_update();
    console.log(update);
    //*/
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
    var url = window.location.pathname;
        // if (url.indexOf("outboard")  !==-1 )
        // {
    // var parts = window.location.search.substr(1).split("&");
    // var $_GET = {};
    // for (var i = 0; i < parts.length; i++) {
    //     var temp = parts[i].split("=");
    //     $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
    // }
    // if (typeof $_GET['update'] !== 'undefined' )
    // {
    //     update = 1;
    // }
    // else if(typeof $_GET['noupdate'] !== 'undefined' )
    // {
    //     update = 0;
    // }
    // else
    // {
    //     update = 0;
    // }
    let changeStatus;
    var oTable = $('#table').on( 'init.dt', function () {
        console.log("change after dt init: " + changeStatus);
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
        "url" : "ob.ajax.1.php",
        data: function(d){
            d.noupdate = update;
        },
        // "data": {
        //     "noupdate": update,
        // }
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
                // return "<a href=\"outboard.php?in=1&userid="+data.uname+"&noupdate=1"+"\"><i class='hover-check' data-feather='check-circle' style='color: gray; height: 1.5em; width: 1.5em;'>in</i></a>";
                return "<button class='btn in-office' id=\""+data.uname+"\"><i class='hover-check' data-feather='check-circle' style='color: gray; height: 1.5em; width: 1.5em;'>in</i></button>";
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
                
                // return "<a href=\"outboard.php?rw=1&userid="+data.uname+"&noupdate=1"+"\"><i class='hover-check' data-feather='check' style='color: gray; height: 1.5em; width: 1.5em;'>rw</i></a>";
                return "<button class='btn in-remote' id=\""+data.uname+"\"><i class='hover-check' data-feather='check' style='color: gray; height: 1.5em; width: 1.5em;'>rw</i></button>";
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
                //   return "<a href=\"outboard.php?out=1&userid="+data.uname+"&noupdate=1"+"\"><i class='hover-x' data-feather='x-circle' style='color: gray; height: 1.5em; width: 1.5em;'>out</i></a>";
                  return "<button class='btn out-office' id=\""+data.uname+"\"><i class='hover-x' data-feather='x-circle' style='color: gray; height: 1.5em; width: 1.5em;'>out</i></button>";
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
                // return "<div class='row'><div class='col'>"+data.remarks+"</div><div class='col'><span class=\"r-tooltip\" data-tippy-content=\""+data.remarks+"\" tabindex=\"0\"><a class=\"btn-sm btn-primary\" href=\"javascript:this.change_remark(\"" + encodeURIComponent(data.remarks).replace(/[!'()*]/g, escape) + "\",'"+data.uname+"')\"><i data-feather='message-square' style='color: white; fill: white; height: 1.5em; width: 1.5em;'></i><span class='d-none d-xl-inline'> Change Remark</span></a></span>&ensp;<a style='color: gray; font-size:9;'></a><span class=\"r-tooltip\" data-tippy-content=\"Return from Lunch\" tabindex=\"0\"><a id="+data.uname+" class=\"btn-sm btn-primary returnfromlunch\" href=\"#\"><i data-feather='coffee' style='color: white; height: 1.5em; width: 1.5em;'></i><span class='d-none d-xl-inline'> Return from Lunch</span></a></span>&ensp;<span class=\"r-tooltip\" data-tippy-content=\"Clear Remarks\" tabindex=\"0\"><a class='btn-danger btn-sm' href=\"javascript:this.clear_remarks('" + data.remarks + "','"+data.uname+"')\"><i data-feather='delete' style='color: white; height: 1.5em!important; width: 1.5em!important;'></i><span class='d-none d-xl-inline'> Clear Remark</span></a></span></div></div>";
                return "<div class='row'><div class='col'>"+data.remarks+"</div><div class='col'><span class=\"r-tooltip\" data-tippy-content=\""+data.remarks+"\" tabindex=\"0\"><button class=\"btn btn-sm btn-primary change-remark\" data-user='" + data.uname + "' data-remark='" + encodeURIComponent(data.remarks).replace(/[!'()*]/g, escape) + "'><i data-feather='message-square' style='color: white; fill: white; height: 1.5em; width: 1.5em;'></i><span class='d-none d-xl-inline'> Change Remark</span></button></span>&ensp;<span class=\"r-tooltip\" data-tippy-content=\"Return from Lunch\" tabindex=\"0\"><button id="+data.uname+" class=\"btn btn-sm btn-primary returnfromlunch\"><i data-feather='coffee' style='color: white; height: 1.5em; width: 1.5em;'></i><span class='d-none d-xl-inline'> Return from Lunch</span></button></span>&ensp;<span class=\"r-tooltip\" data-tippy-content=\"Clear Remarks\" tabindex=\"0\"><button class='btn btn-danger btn-sm clear-remark' data-user='" + data.uname + "' data-remarks='" + data.remarks + "'><i data-feather='delete' style='color: white; height: 1.5em!important; width: 1.5em!important;'></i><span class='d-none d-xl-inline'> Clear Remark</span></button></span></div></div>";
                }
                else if (data.remarks != "")
                {
                //   return "<div class='row'><div class='col'>"+data.remarks+"</div><div class='col'><span class=\"r-tooltip\" data-tippy-content=\""+data.remarks+"\" tabindex=\"0\"><a class=\"btn-sm btn-primary\" style='color: light-blue;' href=\"javascript:this.change_remark('" + encodeURI(data.remarks) + "','"+data.uname+"')\"><i data-feather='message-square' style='color: white; fill: white; height: 1.5em; width: 1.5em;'></i><span class='d-none d-xl-inline'> Change Remark</span></a></span>&ensp;<a style='color: gray; font-size:9;'></a><span class=\"r-tooltip\" data-tippy-content=\"Out to Lunch\" tabindex=\"0\"><a id="+data.uname+" class=\"btn-sm btn-secondary outtolunch\" href=\"#\"><i data-feather='coffee' style='color: light-blue; height: 1.5em!important; width: 1.5em!important;'></i><span class='d-none d-xl-inline'> Out to Lunch</span></a></span>&ensp;<span class=\"r-tooltip\" data-tippy-content=\"Clear Remarks\" tabindex=\"0\"><a class='btn-danger btn-sm' href=\"javascript:this.clear_remarks('" + data.remarks + "','"+data.uname+"')\"><i data-feather='delete' style='color: white; height: 1.5em!important; width: 1.5em!important;'></i><span class='d-none d-xl-inline'> Clear Remark</span></a></span></div></div>";
                return "<div class='row'><div class='col'>"+data.remarks+"</div><div class='col'><span class=\"r-tooltip\" data-tippy-content=\""+data.remarks+"\" tabindex=\"0\"><button class=\"btn btn-sm btn-primary change-remark\" style='color: light-blue;' data-user='" + data.uname + "' data-remark='" + encodeURI(data.remarks) + "'><i data-feather='message-square' style='color: white; fill: white; height: 1.5em; width: 1.5em;'></i><span class='d-none d-xl-inline'> Change Remark</span></button></span>&ensp;</a><span class=\"r-tooltip\" data-tippy-content=\"Out to Lunch\" tabindex=\"0\"><button id="+data.uname+" class=\"btn btn-sm btn-secondary outtolunch\"><i data-feather='coffee' style='color: light-blue; height: 1.5em!important; width: 1.5em!important;'></i><span class='d-none d-xl-inline'> Out to Lunch</span></button></span>&ensp;<span class=\"r-tooltip\" data-tippy-content=\"Clear Remarks\" tabindex=\"0\"><button class='btn btn-danger btn-sm clear-remark' data-user='" + data.uname + "' data-remarks='" + data.remarks + "'><i data-feather='delete' style='color: white; height: 1.5em!important; width: 1.5em!important;'></i><span class='d-none d-xl-inline'> Clear Remark</span></button></span></div></div>";
                
                }
                else
                {
                  // return "<div class='row'><div class='col'>&nbsp;</div><div class='col'><span class=\"r-tooltip\" data-tippy-content=\"(no remark set)\" tabindex=\"0\"><a class=\"btn-sm btn-light shadow-lg\" style='color:blue;' href=\"javascript:this.change_remark('" + encodeURI(data.remarks) + "','"+data.uname+"')\"><i data-feather='message-square' style='color: blue; height: 1.5em!important; width: 1.5em!important;'>Set Remark</i> Set Remark</a></span>&ensp;<a style='color: gray; font-size:9;'></a><span class=\"r-tooltip\" data-tippy-content=\"Out to Lunch\" tabindex=\"0\"><a class=\"btn-sm btn-secondary\" href=\"javascript:this.out_to_lunch('" + data.remarks + "','"+data.uname+"')\"><i data-feather='coffee' style='color: light-blue; height: 1.5em!important; width: 1.5em!important;'></i> Out to Lunch</a></span></div></div>";
                  return "<div class='row'><div class='col'>&nbsp;</div><div class='col'><span class=\"r-tooltip\" data-tippy-content=\"(no remark set)\" tabindex=\"0\"><button class=\"btn btn-sm btn-light shadow-lg change-remark\" style='color:blue;' data-user='" + data.uname + "' data-remark='" + encodeURI(data.remarks) + "'><i data-feather='message-square' style='color: blue; height: 1.5em!important; width: 1.5em!important;'></i><span class='d-none d-xl-inline'> Set Remark</span></a></span>&ensp;<span class=\"r-tooltip\" data-tippy-content=\"Out to Lunch\" tabindex=\"0\"><button id="+data.uname+" class=\"btn btn-sm btn-secondary outtolunch\"><i data-feather='coffee' style='color: light-blue; height: 1.5em!important; width: 1.5em!important;'></i><span class='d-none d-xl-inline'> Out to Lunch</span></button></span></div></div>";
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
        changeStatus = data.change;
        console.log("change within dt: " + changeStatus);
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
    
    console.log("change outside dt: " + changeStatus);
    oTable.ajax.url( 'ob.ajax.1.php?noupdate='+update ).load();
    
    setInterval( function () {
        // oTable.ajax.reload();
        // if(update === 1)
        console.log("setInterval's currentupdate: " + currentupdate);
        oTable.on( 'draw', function () {
            console.log("change outside dt (draw): " + changeStatus);
            if(changeStatus == "false"){
                console.log("changeStatus: "+changeStatus + " currentupdate: " + currentupdate);
                currentupdate = 0;
                oTable.ajax.url( 'ob.ajax.1.php?noupdate='+currentupdate ).load();
                console.log(currentupdate);
            } else 
            {
                console.log("changeStatus: "+changeStatus + " currentupdate: " + currentupdate);
                oTable.ajax.url( 'ob.ajax.1.php?noupdate='+currentupdate ).load();
                currentupdate = 1;
                console.log(currentupdate);
            }
            
        } );
        
        console.log("after setInterval updates, currentupdate: " + currentupdate);
    }, 300000 );
    // oTable.on( 'xhr', function () {
    //     var data = oTable.ajax.params();
        
    //     console.log(data);
    //     console.log(data.noupdate);
    //     console.log(update);
    //     // if(data.noupdate === update){
    //     //     // currentupdate = data.noupdate;
    //     //     console.log(currentupdate);
    //     // }
    //     // alert( 'Search term was: '+data.search.value );
    // } );
// } else {
  // var fab_cs = document.querySelector("div.fixed-action-btn > a.cs");
  // var fab_vs = document.querySelector("div.fixed-action-btn > a.vs");
    var fab_cs = document.getElementById("cs");
    var fab_vs = document.getElementById("vs");
    var main_ob = document.getElementById("main-ob");
    var right_side = document.getElementById("right-side");
    //   var cs_user = document.querySelector('#csa');
    // toggle(fab_vs);
    var change;
    function update_view(update){
        if(update === 1){
        right_side.classList = "p-3 card-body right-side update";
        main_ob.classList = "col-9 m-3 p-3 shadow-lg card-body bg-light";
        fab_cs.classList = "fixed-action-btn fab-ob update";
        fab_vs.classList = "fixed-action-btn fab-ob";
        // currentupdate = 1;
        }
        else {
        right_side.classList = "p-3 card-body right-side";
        main_ob.classList = "col-4 m-3 p-3 shadow-lg card-body bg-light";
        fab_cs.classList = "fixed-action-btn fab-ob";
        fab_vs.classList = "fixed-action-btn fab-ob update";
        // currentupdate = 0;
        }
    }


    function change_remark(remark,userid) {
    // $(document).on('click', '.remark', function(){  
      // var userid = $(this).attr("id");
        $('#remark_form')[0].reset();  
        $('#setRemarkModal').modal('show');
        $('#remarkUser').val(userid);
        if (remark != ""){
            $('#remark').attr('placeholder',remark);
        }  
    // });
    // var newremark = prompt("Enter your remarks below:",remark);
    // if (newremark != null) {
    //   self.location="<?php echo $baseurl ?>?remarks="
		//     + escape(newremark) + "&userid=" +userid + "&update=1";
    // }
  }
  $(document).on('click', '.change-remark', function(){  
    // var remark_user = $(this).dataset.user;
    // var remark_content = $(this).dataset.remark;
    var remark_user = $(this).attr("data-user");
    var remark_content = $(this).attr("data-remark");
    // var remark_content = document.querySelector("#table > tbody > tr:nth-child("+rowid+") > td.text-wrap > div > div:nth-child(2) > span:nth-child(1) > a");
    console.log(remark_user);  
    console.log(remark_content);
    change_remark(remark_content, remark_user);
  });
  
    
  function out_to_lunch(remark,userid) {
    var newremark = prompt("Approximately what time will you return?");
    var rto = "OTL; will return around ";
    //ajax here
    // wait, are we even using this? This appears to be the old remark function
    /*
    $.ajax({
        url: './ob.db.php',
        type: 'POST',
        data: {userid:userid, remarks:newremark, update:1},
        success: function (data) { 
          oTable.ajax.reload();
        }
      });
    */
    if (newremark != null) {
      self.location="<?php echo $baseurl ?>?remarks=" + escape(rto) + ""
		    + escape(newremark) + "&out=1&userid=" +userid + "&noupdate=1";
    }
  }
  $(document).on('click', '.outtolunch', function(){  
    var userid = $(this).attr("id");  
    $('#takeLunchModal').modal('show');
    $('#otl').val(userid);  
  });
  function clear_remarks(userid) {
    // alert("Remark cleared.");
    var remark = "";
    $('#clearRemarkModal').modal('show');
    setTimeout(function(){
        $.ajax({
            url: './ob.ajax.1.php',
            data: {remarks:remark, userid:userid, update:1},
            success: function (data) { 
              update = 1;
              oTable.ajax.reload();
              table_update();
              update_view(update);
            }
          });
    //   self.location="<?php echo $baseurl ?>?remarks=" + "&userid=" +userid + "&update=1";
    },1000); // Gives the user a chance to see that the remark has been cleared.
  }
  $(document).on('click', '.clear-remark', function(){  
    // var remark_user = $(this).dataset.user;
    // var remark_content = $(this).dataset.remark;
    var remark_user = $(this).attr("data-user");
    // var remark_content = $(this).attr("data-remark");
    // var remark_content = document.querySelector("#table > tbody > tr:nth-child("+rowid+") > td.text-wrap > div > div:nth-child(2) > span:nth-child(1) > a");
    console.log(remark_user);  
    // console.log(remark_content);
    clear_remarks(remark_user);
  });
  function end_lunch_rw(userid) {
    //   var userid = $('#rtw').attr("value");  
        var emptyremarks = "";
      $('#lunchModal').modal('hide');
      //ajax here
      $.ajax({
        url: './ob.ajax.1.php',
        // type: 'POST',
        data: {userid:userid, rw:1, update:1, remarks:emptyremarks},
        success: function (data) { 
            update = 0;
            oTable.ajax.reload();
            table_update();
            update_view(update);
        }
      });
      // self.location="<?php echo $baseurl ?>?remarks=" + "&rw=1&userid=" +userid + "&update=1";
  }
  $(document).on('click', '#rtw', function(){  
    var userid = $('#rtw').attr("value");  
    console.log(userid);  
    end_lunch_rw(userid);
  });
  function end_lunch_in(userid) {
      
      $('#lunchModal').modal('hide');
      var emptyremarks = "";
      //ajax here
      $.ajax({
        url: './ob.ajax.1.php',
        // type: 'POST',
        data: {userid:userid, in:1, update:1, remarks:emptyremarks},
        success: function (data) { 
            update = 0;
            oTable.ajax.reload();
            table_update();
            update_view(update);
        }
      }); // end_lunch_in(), end_lunch_rw(), otl(), set_remark()
      // self.location="<?php echo $baseurl ?>?remarks=" + "&in=1&userid=" +userid + "&update=1";
  }
  $(document).on('click', '#itw', function(){  
    var userid = $('#itw').attr("value");  
    console.log(userid);  
    end_lunch_in(userid);
  });
  function in_office(userid){
    $.ajax({
      url: './ob.ajax.1.php',
    //   type: 'POST',
      data: {userid:userid, in:1, noupdate:1},
      success: function (data) { 
        update = 0;
        oTable.ajax.reload();
        table_update();
        update_view(update);
        
        // oTable.ajax.url( 'ob.ajax.1.php?noupdate='+update ).load();
      }
    });
  }
  $(document).on('click', '.in-office', function(){  
    var userid = $(this).attr("id");
    console.log(userid);  
    in_office(userid);
  });
  function in_remote(userid){
    $.ajax({
        url: './ob.ajax.1.php',
      data: {userid:userid, rw:1, noupdate:1},
      success: function (data) { 
        update = 0;
        oTable.ajax.reload();
        table_update();
        update_view(update);
      }
    });
  }
  $(document).on('click', '.in-remote', function(){  
    var userid = $(this).attr("id");
    console.log(userid);  
    in_remote(userid);
  });
  function out_office(userid){
    $.ajax({
        url: './ob.ajax.1.php',
        data: {userid:userid, out:1, noupdate:1},
        success: function (data) { 
            update = 0;
            oTable.ajax.reload();
            table_update();
            update_view(update);
      }
    });
  }
  $(document).on('click', '.out-office', function(){  
    var userid = $(this).attr("id");
    console.log(userid);  
    out_office(userid);
  });
  $(document).on('click', '.returnfromlunch', function(){  
    var userid = $(this).attr("id");  
    $('#lunchModal').modal('show');
    $('#rtw').val(userid);  
    $('#itw').val(userid);  
  });
  function otl(userid, time) {
    var rto = "OTL; will return around " + time; 
    $('#takeLunchModal').modal('hide');
    //ajax here
    $.ajax({
      url: './ob.ajax.1.php',
      // type: 'POST',
      data: {userid:userid, remarks:rto, noupdate:1, out:1},
      success: function (data) { 
        update = 0;
        oTable.ajax.reload();
        table_update();
        update_view(update);
      }
    });
    // self.location="<?php echo $baseurl ?>?remarks=" + escape(rto) + ""
        //   + "&out=1&userid=" +userid + "&noupdate=1";
}
$(document).on('click', '#otl', function(){  
    var userid = $('#otl').attr("value"); 
    var time = $('#lunchtime').attr("value");
    otl(userid,time); 
  });

  $('#setRemarkModal').on('show.bs.modal', function (event) {
    
    
  });
  $(document).on('click', '#remarkUser', function(){
    var userid = $('#remarkUser').attr("value"); 
    var newremark = $('#remark').val();
    set_remark(userid, newremark);
  })
  function set_remark(userid,newremark) {
    $('#setRemarkModal').modal('hide');
    //
    // TODO: Add a "prevent default" for the enter key, so that entering data doesn't refresh the page
    //
    //ajax here
    $.ajax({
      url: './ob.ajax.1.php',
    //   type: 'POST',
      data: {userid:userid, remarks:newremark, update:1},
      success: function (data) { 
        update = 0;
        oTable.ajax.reload();
        table_update();
        update_view(update);
      }
    });
    // self.location="<?php echo $baseurl ?>?remarks="
        //   + escape(newremark) + "&userid=" +userid + "&update=1";
}

  function cs(username){
    if (typeof username !== 'undefined' )
    {
        var userid = username;
    } 
    else 
    {
        var userid = cs_user.dataset.user;
    }
    $.ajax({
      // url: './ob.ajax.1.php',
      url: './ob.db.php',
      type: 'POST',
      dataType:"json",
      data: {userid:userid, out:1, update:1},
      success: function (data) { 
        let update = data[0].updatebool;
        change = data[0].change;
        console.log(data);
        console.log(data[0].updatebool);
        console.log(data[0].change);
        update_view(update);
        oTable.ajax.url( 'ob.ajax.1.php?noupdate='+update ).load();
        // toggle(fab_cs);
        // toggle(fab_vs);
        // fab_content();
      }
    });
    

  }
  function vs(){
    $.ajax({
      // url: './ob.ajax.1.php',
      url: './ob.db.php',
      type: 'POST',
      dataType:"json",
      data: {noupdate:1},
      success: function (data) { 
        update = data[0].updatebool;
        change = data[0].change;
        console.log(data);
        console.log()
        update_view(update);
        oTable.ajax.url( 'ob.ajax.1.php?noupdate='+update ).load();
        // toggle(fab_cs);
        // toggle(fab_vs);
        // fab_content();
      }
    });
  }

  // Idea of this function is that the button will change dynamically depending on the actions done
  // may have to add an id to the button, as we'll probably be adding and removing classes as well
  function fab_content(){
    if(!update && !readonly){
      $(".btn-floating.btn-lg.btn-info.bg-danger.cs").href(cs(username));
      
    }
    else if(!readonly){
      $(".btn-floating.btn-lg.btn-info.bg-sog.vs").href(vs());
    }
  }
  $(document).on('click', '.cs', function(){  
    cs(cs_user.dataset.user);
  })
  $(document).on('click', '.vs', function(){  
    vs();
  })

  // $(document).on('click', '.remark', function(){  
  //   var userid = $(this).attr("id");  
  //   $('#setRemarkModal').modal('show');
  //   $('#remarkUser').val(userid);  
  // });

  
// }
}); 