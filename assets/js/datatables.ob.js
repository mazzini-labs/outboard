$(document).ready(function() {
    var click = 0;
    
    $("#alert").fadeTo(2000, 500).slideUp(500, function(){
    $("#alert").slideUp(500);
    });
    var update;
    
    
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
        if (url.indexOf("outboard")  !==-1 )
        {
          var parts = window.location.search.substr(1).split("&");
          var $_GET = {};
          for (var i = 0; i < parts.length; i++) {
              var temp = parts[i].split("=");
              $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
          }
          if (typeof $_GET['update'] !== 'undefined' )
          {
              update = 1;
          }
          else if(typeof $_GET['noupdate'] !== 'undefined' )
          {
              update = 0;
          }
          else
          {
              update = 0;
          }
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


} else {
  // var fab_cs = document.querySelector("div.fixed-action-btn > a.cs");
  // var fab_vs = document.querySelector("div.fixed-action-btn > a.vs");
  var fab_cs = document.getElementById("cs");
  var fab_vs = document.getElementById("vs");
  var main_ob = document.getElementById("main-ob");
  var right_side = document.getElementById("right-side");
  var cs_user = document.querySelector('#csa');
  // toggle(fab_vs);
  var change;
    function update_view(update){
      // if(update == "true"){}
      // console.log(update);
      // if(update === undefined && typeof update == 'undefined'){
      //   update = 1;
      //   change = 1;
      //   $('#main-ob').addClass("col-4");
      //   $('#main-ob').removeClass("col-9");
      //   $('#right-side').removeClass("update");
      //   // fab.className = "btn-floating btn-lg btn-info bg-danger cs";
      //   toggle(fab_cs);
      //   toggle(fab_vs);
      //   console.log("showing undefined");
      // }
      // else if(update > 0){
      //   change = 1;
      //   $('#main-ob').addClass("col-9");
      //   $('#main-ob').removeClass("col-4");
      //   $('#right-side').addClass("update");
      //   // document.querySelector("div.fixed-action-btn > a").removeClass("bg-danger cs");
      //   // fab.className = "btn-floating btn-lg btn-info bg-sog vs";
      //   // document.querySelector("div.fixed-action-btn > a").addClass("bg-sog vs");
      //   toggle(fab_cs);
      //   toggle(fab_vs);
      //   console.log("showing update page");
      // }
      // else {
      //   change = 0;
      //   $('#main-ob').addClass("col-4");
      //   $('#main-ob').removeClass("col-9");
      //   $('#right-side').removeClass("update");
      //   // fab.className = "btn-floating btn-lg btn-info bg-danger cs";
      //   toggle(fab_cs);
      //   toggle(fab_vs);
      //   // document.querySelector("div.fixed-action-btn > a").removeClass("bg-sog vs");
      //   // document.querySelector("div.fixed-action-btn > a").addClass("bg-danger cs");
      //   console.log("showing normal outboard");
      // }
      if(update === 1){
        right_side.classList = "p-3 card-body update";
        main_ob.classList = "m-3 p-3 shadow-lg card-body bg-light col-9";
        fab_cs.classList = "fixed-action-btn fab-ob update";
        fab_vs.classList = "fixed-action-btn fab-ob";
      }
      else {
        right_side.classList = "p-3 card-body";
        main_ob.classList = "m-3 p-3 shadow-lg card-body bg-light col-4";
        fab_cs.classList = "fixed-action-btn fab-ob";
        fab_vs.classList = "fixed-action-btn fab-ob update";
      }
    }
    function toggle(x) {
      x.classList.toggle("update");
      // if (x.style.display === "none") {
      //   x.style.display = "block";
      // } else {
      //   x.style.display = "none";
      // }
    }
    function toggle_vs(x){
      if (x.style.display === "none") {
        x.style.display = "block";
      } else {
        x.style.display = "none";
      }
    }
    update_view(update);
    console.log(update);
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
                    return "<a href=\""+in_office(data.uname)+"\"><i class='hover-check' data-feather='check-circle' style='color: gray; height: 1.5em; width: 1.5em;'>in</i></a>";
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
                    
                    return "<a href=\""+in_remote(data.uname)+"\"><i class='hover-check' data-feather='check' style='color: gray; height: 1.5em; width: 1.5em;'>in</i></a>";
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
                      return "<a href=\""+out_office(data.uname)+"\"><i class='hover-x' data-feather='x-circle' style='color: gray; height: 1.5em; width: 1.5em;'>out</i></a>";
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
  function clear_remarks(remark,userid) {
    // alert("Remark cleared.");
    $('#clearRemarkModal').modal('show');
    setTimeout(function(){
      self.location="<?php echo $baseurl ?>?remarks=" + "&userid=" +userid + "&update=1";
    },1000); // Gives the user a chance to see that the remark has been cleared.
  }
  function end_lunch_rw() {
      var userid = $('#rtw').attr("value");  
      $('#lunchModal').modal('hide');
      //ajax here
      $.ajax({
        url: './ob.db.php',
        type: 'POST',
        data: {userid:userid, rw:1, update:1},
        success: function (data) { 
          oTable.ajax.reload();
        }
      });
      // self.location="<?php echo $baseurl ?>?remarks=" + "&rw=1&userid=" +userid + "&update=1";
  }
  function end_lunch_in() {
      var userid = $('#itw').attr("value");  
      $('#lunchModal').modal('hide');
      //ajax here
      $.ajax({
        url: './ob.db.php',
        type: 'POST',
        data: {userid:userid, in:1, update:1},
        success: function (data) { 
          oTable.ajax.reload();
        }
      }); // end_lunch_in(), end_lunch_rw(), otl(), set_remark()
      // self.location="<?php echo $baseurl ?>?remarks=" + "&in=1&userid=" +userid + "&update=1";
  }
  function in_office(userid){
    $.ajax({
      url: './ob.db.php',
      type: 'POST',
      data: {userid:userid, in:1, noupdate:1},
      success: function (data) { 
        oTable.ajax.reload();
      }
    });
  }
  function in_remote(userid){
    $.ajax({
      url: './ob.db.php',
      type: 'POST',
      data: {userid:userid, rw:1, noupdate:1},
      success: function (data) { 
        oTable.ajax.reload();
      }
    });
  }
  function out_office(userid){
    $.ajax({
      url: './ob.db.php',
      type: 'POST',
      data: {userid:userid, out:1, noupdate:1},
      success: function (data) { 
        oTable.ajax.reload();
      }
    });
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
  
  function cs(username){
    $.ajax({
      // url: './ob.ajax.1.php',
      url: './ob.db.php',
      type: 'POST',
      dataType:"json",
      data: {userid:username, out:1, update:1},
      success: function (data) { 
        update = data[0].updatebool;
        change = data[0].change;
        console.log(data);
        console.log(data[0].updatebool);
        console.log(data[0].change);
        update_view(update);
        oTable.ajax.reload();
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
        update = data.updatebool;
        change = data.change;
        console.log(data);
        console.log()
        update_view(update);
        oTable.ajax.reload();
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
    
    
// The following would also work:
// const article = document.getElementById("electric-cars")

     // "3"
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
  function otl() {
      var userid = $('#otl').attr("value"); 
      var time = $('#lunchtime').attr("value");
      var rto = "OTL; will return around " + time; 
      $('#takeLunchModal').modal('hide');
      //ajax here
      $.ajax({
        url: './ob.db.php',
        type: 'POST',
        data: {userid:userid, remarks:rto, noupdate:1, out:1},
        success: function (data) { 
          oTable.ajax.reload();
        }
      });
      // self.location="<?php echo $baseurl ?>?remarks=" + escape(rto) + ""
		  //   + "&out=1&userid=" +userid + "&noupdate=1";
  }
  function set_remark() {
      var userid = $('#remarkUser').attr("value"); 
      var newremark = $('#remark').val();
      $('#setRemarkModal').modal('hide');
      // console.log("<?php echo $baseurl ?>?remarks="
		  //   + escape(newremark) + "&userid=" +userid + "&update=1");
      //ajax here
      $.ajax({
        url: './ob.db.php',
        type: 'POST',
        data: {userid:userid, remarks:newremark, update:1},
        success: function (data) { 
          oTable.ajax.reload();
        }
      });
      // self.location="<?php echo $baseurl ?>?remarks="
		  //   + escape(newremark) + "&userid=" +userid + "&update=1";
  }
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
}
}); 