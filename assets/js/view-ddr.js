$(document).on('click', '.view_data', function(){  
    var id = $(this).attr("id");  
    if(id != '')  
    {  
            $.ajax({  
                url:"./ajax/select.php",  
                method:"POST",  
                data:{id:id},  
                success:function(data){  
                    $('#ddr_detail').html(data);  
                    $('#dataModal').modal('show'); 
                    feather.replace();
                    // $('.carousel').carousel({
                    //     interval: 2000
                    // });

                    tippy('.r-tooltip', { 
                        arrow: false 
                    });
                    $('#view-edits').click(function(){
                        editID = $('#view-edits').val();
                        // if(clickViewEdit < 1){
                        //     clickViewEdit++;
                        
                            vTable = $('#editsTable').on('init.dt', function () {
                                feather.replace();
                                tippy('.r-tooltip', { 
                                    arrow: false 
                                });
                                tippy('.hours', { 
                                    placement: 'right',
                                    arrow: false 
                                });
                                } 
                                ).DataTable( {
                                "destroy": true,
                                "ajax": {
                                    "url" : "ajax/viewEdit.ajax.php",
                                    "data": 
                                    {
                                        "api": api,
                                        "id": id
                                    }
                                }, 
                                "sDom": 't',
                                "order": [[0, 'desc'], [1, 'desc']],
                                
                                deferRender: true,
                                scrollY: 550,
                                scroller: true,
                                "searching": true,
                                "autoWidth": false, 
                                "columns": [
                                    // {
                                    //     // Change Department Enum to actual name
                                    //     "data": null, render: function ( data, type, row ) 
                                    //     {
                                    //         switch(data.d)
                                    //         {
                                    //             case 'e':
                                    //                 return 'Engineering';
                                    //             break;
                                    //             case 'a':
                                    //                 return 'Accounting';
                                    //             break;
                                    //             case 'v':
                                    //                 return 'Vendor';
                                    //             break;
                                    //             default:
                                    //                 return 'Field';
                                    //             break;
                                    //         }
                                    //     }, 
                                    //     //"data": "d",
                                    //     "defaultContent": ""
                                    // },
                                    {
                                        // Date
                                        // TODO: get dates formatted as M-D-YYYY in select statement
                                        "data": "de",  
                                        "render": function(data, type) {
                                            return type === 'sort' ? data : moment(data).format('L');
                                        },
                                        "defaultContent": ""
                                    },
                                    {
                                        // Time (Start - End)
                                        // TODO: get times formatted as H:MM in select statement
                                        "data": null, render: function ( data, type, row ) 
                                        {
                                            console.log(data.ts);
                                            return type === 'sort' ? data.ts : (moment(data.ts, 'HH:mm:ss').format('hh:mm a')+' - '+moment(data.te, 'HH:mm:ss').format('hh:mm a'));
                                        },
                                        // "data": "ts",
                                        "defaultContent": "",
                                    },
                                    {
                                        // Vendor/Contact
                                        "data": "cvn", 
                                        "defaultContent": "",
                                    },
                                    {
                                        // Invoice # / Contact Info
                                        "data": "cin", 
                                        "defaultContent": "",
                                    },
                                    {
                                        // Invoice Details / DDR
                                        "data": null, render: function ( data, type, row ) 
                                        {
                                            switch(data.d)
                                            {
                                                case 'e':
                                                    // IMPORTANT: The top regex will only do one carriage return
                                                    // let str = data.drn.replace(/(?:\r\n|\r|\n|\\r\\n|\\r|\\n)/g, '<br>');
                                                    let str = data.drn.replace(/(?:\r\n|\r|\n|\\r|\\n)/g, '<br>');
                                                    
                                                    return str;
                                                break;
                                                case 'a':
                                                    return data.drn;
                                                break;
                                                case 'v':
                                                    var rtn = data.drn;
                                                    // These functions check to see if there is a value in the database. If there is not,
                                                    // the table will print out one of the following: null, NaN, or infinity
                                                    // My understanding of the actual logic behind it is that a null value cannot be divided
                                                    // by itself, and will store 'undefined' as the value. Because it's undefined, it then cannot
                                                    // equal to anything (including itself) because it's undefined. 
                                                    var checkdt = data.dt / data.dt; 
                                                    var checkdc = data.dc / data.dc;
                                                    var checkat = data.at / data.at;
                                                    var checkac = data.ac / data.ac;
                                                    var checket = data.et / data.et;
                                                    var checktt = data.tt / data.tt;
                                                    if(checkdt == checkdt || checkdc == checkdc || checkat == checkat || checkac == checkac || checket == checket || checktt == checktt)
                                                    {
                                                        rtn += '<table class="table vendortable" width="100%">';
                                                    }
                                                    if(checkdt == checkdt || checkdc == checkdc)
                                                    {
                                                        rtn += '<tr><td class="vendortable"> Deducted Time:</td><td class="vendortable">  ' + data.dt + ' hours </td>'; 
                                                        rtn += '<td class="vendortable">Deducted Cost:</td><td class="vendortable">  $' + data.dc + '</td><tr>';
                                                    }
                                                    if(checkat == checkat || checkac == checkac)
                                                    {
                                                        rtn += '<tr><td class="vendortable">Adjusted Time:</td><td class="vendortable">  ' + data.at + ' hours </td>';
                                                        rtn += '<td class="vendortable">Adjusted Cost:</td><td class="vendortable">  $' + data.ac + '</td><tr>';
                                                    }
                                                    if(checket == checket )
                                                    {
                                                        rtn += '<tr><td class="vendortable">Estimated Time:</td><td class="vendortable">  ' + data.et + ' hours </td><tr>';
                                                    }
                                                    if(checktt == checktt )
                                                    {
                                                        rtn += '<tr style="border-top: 1px solid rgba(0, 0, 0, 1);"><td class="vendortable">Total Time:</td><td class="vendortable">  ' + data.tt + ' hours</td><tr>';
                                                    }
                                                    if(checkdt == checkdt || checkdc == checkdc || checkat == checkat || checkac == checkac || checket == checket || checktt == checktt)
                                                    {
                                                        rtn += '</table>';
                                                    }
                                                    return rtn;                                                                                
                                                    
                                                break;
                                                default:
                                                    return data.drn;
                                            }
                                        }, 
                                        "defaultContent": "",
                                        },
                                    {
                                        // $ / EDC / 
                                        "data": null, render: function ( data, type, row ) 
                                        {
                                            switch(data.d){
                                                case 'a':
                                                    return $.fn.dataTable.render.number( ',', '.', 2, '$').display(data.edc);
                                                break;
                                                case 'v':
                                                    return $.fn.dataTable.render.number( ',', '.', 2, '$', '/hour').display(data.edc);
                                                break;
                                                default:
                                                    return $.fn.dataTable.render.number( ',', '.', 2, '$').display(data.edc);
                                                
                                            }
                                            
                                        },
                                        "defaultContent": "",
                                    },
                                    {
                                        // Approvals / ECC
                                        "data": null, render: function ( data, type, row ) 
                                        {
                                            switch(data.d){
                                                case 'a':
                                                    if(data.ai != null){
                                                        return 'Approval Initials: '+data.ai+'<hr>Approval Date: '+data.ad;
                                                    }
                                                    else
                                                    {
                                                        return ' - ';
                                                    }
                                                break;
                                                case 'v':
                                                    return $.fn.dataTable.render.number( ',', '.', 2, '$').display(data.ecc);
                                                break;
                                                default:
                                                    return $.fn.dataTable.render.number( ',', '.', 2, '$').display(data.ecc);
                                            }
                                        },
                                        "defaultContent": "",
                                    },
                                    {
                                        "data": null, render: function ( data, type, row ) 
                                        {
                                            // "<i data-feather='edit-2' style='color: light-blue; height: 1.5em!important; width: 1.5em!important;'></i> Out to Lunch</a></span></div></div>"
                                            // <img class="img-fluid" src="assets/images/edit-2.svg" border=0>
                                            // return '<div class="row"><div class="col"><span class=\"r-tooltip\" data-tippy-content=\"Edit\" tabindex=\"0\"><a class="btn-sm btn-light shadow-lg edit_ddr-'+data.d+'" style="color:blue;" id="'+data.id+'" href="#'+data.id+'"><i data-feather="edit-2" style="color: blue; height: 1.5em!important; width: 1.5em!important;"></i></a></span>&ensp;<a style="color: gray; font-size:9;" id="'+data.id+'"></a><span class=\"r-tooltip\" data-tippy-content=\"View Entry\" tabindex=\"0\"><a class="btn-sm btn-secondary view_data" href="#'+data.id+'" id="'+data.id+'"><i data-feather="eye" style="color: light-blue; height: 1.5em!important; width: 1.5em!important;"></i></a></span><span class=\"r-tooltip\" data-tippy-content=\"Print Entry\" tabindex=\"0\"><a class="btn-sm btn-secondary view_data" href="#'+data.id+'" target="_blank" id="'+data.id+'"><i data-feather="print" style="color: light-blue; height: 1.5em!important; width: 1.5em!important;"></i></a></span></div></div>';
                                            
                                            var buttons = '<div class="row">';
                                            buttons += '<div class="col">';
                                            // Edit Button HTML
                                            buttons += '<span class=\"r-tooltip\" data-tippy-content=\"Edit\" tabindex=\"0\">';
                                            buttons += '<a class="btn-sm btn-light shadow-lg edit_ddr-'+data.d+'" style="color:blue;" id="'+data.id+'" href="#'+data.id+'">';
                                            buttons += '<i data-feather="edit-2" style="color: blue; height: 1.5em!important; width: 1.5em!important;"></i></a></span>&ensp;';
                                            
                                            // buttons += '<a style="color: gray; font-size:9;" id="'+data.id+'"></a>';

                                            // View Button HTML
                                            buttons += '<span class=\"r-tooltip\" data-tippy-content=\"View Entry\" tabindex=\"0\">';
                                            buttons += '<a class="btn-sm btn-secondary view_data" href="#'+data.id+'" id="'+data.id+'">';
                                            buttons += '<i data-feather="eye" style="color: light-blue; height: 1.5em!important; width: 1.5em!important;"></i></a></span>&ensp;';
                                            
                                            buttons += '<span class=\"r-tooltip\" data-tippy-content=\"Print Entry\" tabindex=\"0\">';
                                            buttons += '<a class="btn-sm btn-info" href="ajax/printEntry.php?id='+data.id+'" target="_blank" id="'+data.id+'">';
                                            buttons += '<i data-feather="printer" style="color: light-blue; height: 1.5em!important; width: 1.5em!important;"></i></a></span>';

                                            buttons += '</div></div>';
                                            return buttons;
                                            // return '<button name="edit" value="Edit" id="'+data.id+'" class="btn btn-info btn-sm edit_ddr-'+data.d+'" data-toggle="tooltip" title="Edit" /><i data-feather="edit-2" style="color: light-blue; height: 1.5em!important; width: 1.5em!important;"></i></button><button data-toggle="tooltip" title="View" name="view" value="view" id="'+data.id+'" class="btn btn-info btn-sm view_data" /><img class="img-fluid" src="assets/images/eye.svg" border=0></button>'; target="_blank"
                                            //return '<input type="button" name="edit" value="Edit" id="'+data.id+'" class="btn btn-info btn-sm edit_ddr-'+data.d+'" /><input type="button" name="view" value="view" id="'+data.id+'" class="btn btn-info btn-sm view_data" />';
                                        },
                                        "defaultContent": "",
                                    },
                                ],
                                "columnDefs": [
                                    
                                    { width: "5%", "targets": [0, 1, 5, 6, 7] },
                                    { width: "10%", "targets": [2, 3] },
                                    { width: "30%", "targets": 4 },
                                    // { type: "time-ui", "targets":  1  },
                                    { className: "text-wrap", "targets":  [3, 4, 5]  },

                                    {
                                        targets: [0,1,2,3,4,5,6,7],
                                        "createdCell": function (td, cellData, rowData, row, col) {
                                            // "createdRow" : function (row, data, dataIndex) {
                                            {
                                                var check = iTable.cell(td,0).data(); 
                                                //var check = $(cells).html();
                                                // console.log(iTable.cell(td,0).data());
                                                /* switch(check){
                                                    case 'Vendor':
                                                        return $(td).css('background-color', '#F08080')
                                                        console.log('Vendor');
                                                        console.log($(cells).html());
                                                        console.log($(row).html());
                                                    // break;
                                                    case 'Engineering':
                                                        return $(row).css('background-color', '#8080F0')
                                                        console.log('Eng');
                                                        console.log($(cells).html());
                                                        console.log($(row).html());
                                                    // break;
                                                    default:
                                                    $(td).css('background-color', '#80F080')
                                                    console.log($(cells).html());
                                                    console.log($(row).html());
                                                    console.log(iTable.cell(row,0).data());
                                                    console.log(iTable.cell(row, row.d).data());
                                                } */
                                                if ( check == 'e' ) { 
                                                    $(td).css('color', '#F08080'); 
                                                    // console.log(iTable.cell(td,1).data()); 
                                                }
                                                else if ( check == 'Engineering' ) { $(td).css('background-color', '#8080F0'); }
                                            }
                                        },
                                        
                                    },

                                    {
                                        targets: [4,5],
                                        "createdCell": function (td, cellData, rowData, row, col) {
                                            {
                                                var checkSI = iTable.cell(td,5).data(); 
                                                if ( checkSI == 'Shut-in' || checkSI == 'Shut-In' || checkSI  == 'INACTIVE' ) 
                                                {
                                                    $(td).css('font-weight', 'bold')
                                                }
                                            }
                                        },

                                    }                            
                                ],
                                "rowCallback": function( row, data, index ) 
                                {
                                    switch(data.d)
                                    {
                                        case 'e':
                                            $('td').eq(0).find('td').addClass('engineering');
                                            $('td:eq(1)', row).addClass('engineering-date');
                                            // console.log($('td',1));
                                        break;
                                        case 'a':
                                            $('td', row).addClass('accounting');
                                        break;
                                        case 'v':
                                            $('td', row).addClass('vendor smol');
                                        break;
                                        default:
                                            $('td', row).addClass('field');
                                        break;
                                    }
                                },
                                // "initComplete": function(settings, json){
                                //     feather.replace();
                                //     tippy('.r-tooltip', { 
                                //         arrow: false 
                                //     });
                                //     tippy('.hours', { 
                                //         placement: 'right',
                                //         arrow: false 
                                //     });
                                // }, 
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
                    

                            } ); // };
                    });
                    // While the below code works, there's an easier method (using Microsoft's Web Office Viewer); keeping this just in case
                    // $('.excel-select').click(function(){
                    //     // var grid = canvasDatagrid({
                    //     //     parentNode: document.getElementById('grid'),
                    //     //     data: []
                    //     // });
                    //     // grid.style.height = '100%';
                    //     // grid.style.width = '100%';
                    //     // var X = new DropSheet();
                        
                    //     $('#file_Modal').modal('show');
                    //     // $('#pdfcanvas').addClass('hidden');
                    //     // var url = "http://oss.sheetjs.com/test_files/formula_stress_test.xlsx";
                    //     var url = $(this).attr("data-path");
                    //     // var filename = $(this).attr("data-file");
                    //     /* set up async GET request */
                    //     var request = new XMLHttpRequest();
                    //     request.open("GET", url, true);
                        
                    //     request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
                    //     // request.responseType = 'blob';
                    //     request.responseType = "arraybuffer";
                    //     request.onload = function(e) {
                    //         if (this.status === 200) {
                    //             var DropSheet = function DropSheet(opts,file) {
                    //                 if(!opts) opts = {};
                    //                 var nullfunc = function(){};
                    //                 if(!opts.errors) opts.errors = {};
                    //                 if(!opts.errors.badfile) opts.errors.badfile = nullfunc;
                    //                 if(!opts.errors.pending) opts.errors.pending = nullfunc;
                    //                 if(!opts.errors.failed) opts.errors.failed = nullfunc;
                    //                 if(!opts.errors.large) opts.errors.large = nullfunc;
                    //                 if(!opts.on) opts.on = {};
                    //                 if(!opts.on.workstart) opts.on.workstart = nullfunc;
                    //                 if(!opts.on.workend) opts.on.workend = nullfunc;
                    //                 if(!opts.on.sheet) opts.on.sheet = nullfunc;
                    //                 if(!opts.on.wb) opts.on.wb = nullfunc;
                                
                    //                 var rABS = typeof FileReader !== 'undefined' && FileReader.prototype && FileReader.prototype.readAsBinaryString;
                    //                 // var useworker = typeof Worker !== 'undefined';
                    //                 var useworker = false;
                    //                 var pending = false;
                    //                 function fixdata(data) {
                    //                     var o = "", l = 0, w = 10240;
                    //                     for(; l<data.byteLength/w; ++l)
                    //                     o+=String.fromCharCode.apply(null,new Uint8Array(data.slice(l*w,l*w+w)));
                    //                     o+=String.fromCharCode.apply(null, new Uint8Array(data.slice(o.length)));
                    //                     return o;
                    //                 }
                                
                    //                 function sheetjsw(data, cb, readtype) {
                    //                     pending = true;
                    //                     opts.on.workstart();
                    //                     var scripts = document.getElementsByTagName('script');
                    //                     var dropsheetPath;
                    //                     for (var i = 0; i < scripts.length; i++) {
                    //                         if (scripts[i].src.indexOf('dropsheet') != -1) {
                    //                         dropsheetPath = scripts[i].src.split('dropsheet.js')[0];
                    //                         }
                    //                     }
                    //                     // var blob = new Blob([
                    //                     //     document.querySelector('#worker1').textContent
                    //                     //   ], { type: "text/javascript" })
                    //                       // Note: window.webkitURL.createObjectURL() in Chrome 10+.
                    //                         // var worker = new Worker(window.URL.createObjectURL(blob));
                    //                         // worker.onmessage = function(e) {
                    //                         //     console.log("Received: " + e.data);
                    //                         // }
                    //                         // worker.postMessage("hello"); // Start the worker.
                    //                     var worker = new Worker(dropsheetPath + 'sheetjsw.js');
                    //                     worker.onmessage = function(e) {
                    //                         switch(e.data.t) {
                    //                         case 'ready': break;
                    //                         case 'e': pending = false; console.error(e.data.d); break;
                    //                         case 'xlsx':
                    //                             pending = false;
                    //                             opts.on.workend();
                    //                             cb(JSON.parse(e.data.d)); break;
                    //                     }
                    //                     };
                    //                     worker.postMessage({d:data,b:readtype,t:'xlsx'});
                    //                 }
                                
                    //                 var last_wb;
                                
                    //                 function to_json(workbook) {
                    //                     if(useworker && workbook.SSF) XLSX.SSF.load_table(workbook.SSF);
                    //                     var result = {};
                    //                     workbook.SheetNames.forEach(function(sheetName) {
                    //                         var roa = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], {raw:false, header:1});
                    //                         if(roa.length > 0) result[sheetName] = roa;
                    //                     });
                    //                     return result;
                    //                 }
                                
                    //                 function choose_sheet(sheetidx) { process_wb(last_wb, sheetidx); }  
                    //                 function process_wb(wb, sheetidx) {
                    //                     last_wb = wb;
                    //                     opts.on.wb(wb, sheetidx);
                    //                     var sheet = wb.SheetNames[sheetidx||0];
                    //                     var json = to_json(wb)[sheet];
                    //                     opts.on.sheet(json, wb.SheetNames, choose_sheet);
                    //                 }
                                
                    //                 function handleDrop(e) {
                    //                     e.stopPropagation();
                    //                     e.preventDefault();
                    //                     if(pending) return opts.errors.pending();
                    //                     var files = e.dataTransfer.files;
                    //                     var i,f;
                    //                     for (i = 0, f = files[i]; i != files.length; ++i) {
                    //                         var reader = new FileReader();
                    //                         var name = f.name;
                    //                         reader.onload = function(e) {
                    //                         var data = e.target.result;
                    //                         var wb, arr;
                    //                         var readtype = {type: rABS ? 'binary' : 'base64' };
                    //                         if(!rABS) {
                    //                             arr = fixdata(data);
                    //                             data = btoa(arr);
                    //                         }
                    //                         function doit() {
                    //                             try {
                    //                             if(useworker) { sheetjsw(data, process_wb, readtype); return; }
                    //                             wb = XLSX.read(data, readtype);
                    //                             process_wb(wb);
                    //                             } catch(e) { console.log(e); opts.errors.failed(e); }
                    //                         }
                                    
                    //                         if(e.target.result.length > 1e6) opts.errors.large(e.target.result.length, function(e) { if(e) doit(); });
                    //                         else { doit(); }
                    //                         };
                    //                         if(rABS) reader.readAsBinaryString(f);
                    //                         else reader.readAsArrayBuffer(f);
                    //                     }
                    //                 }
                                
                    //                 function handleDragover(e) {
                    //                     e.stopPropagation();
                    //                     e.preventDefault();
                    //                     e.dataTransfer.dropEffect = 'copy';
                    //                 }
                                
                    //                 // if(opts.drop.addEventListener) {
                    //                 //     opts.drop.addEventListener('dragenter', handleDragover, false);
                    //                 //     opts.drop.addEventListener('dragover', handleDragover, false);
                    //                 //     opts.drop.addEventListener('drop', handleDrop, false);
                    //                 // }
                                
                    //                 // function handleFile(e) {
                    //                 var hi = function(e) {
                    //                     if(pending) return opts.errors.pending();
                    //                     // var files = e.target.files;
                    //                     var files = file.files;
                    //                     var i,f;
                    //                     for (i = 0, f = files[i]; i != files.length; ++i) {
                    //                         var reader = new FileReader();
                    //                         var name = f.name;
                    //                         reader.onload = function(e) {
                    //                         var data = e.target.result;
                                
                    //                         var wb, arr;
                    //                         var readtype = {type: rABS ? 'binary' : 'base64' };
                    //                         if(!rABS) {
                    //                             arr = fixdata(data);
                    //                             data = btoa(arr);
                    //                         }
                    //                         function doit() {
                    //                             try {
                    //                             if(useworker) { sheetjsw(data, process_wb, readtype); return; }
                    //                             wb = XLSX.read(data, readtype);
                    //                             process_wb(wb);
                    //                             } catch(e) { console.log(e); opts.errors.failed(e); }
                    //                         }
                                    
                    //                         if(e.target.result.length > 1e6) opts.errors.large(e.target.result.length, function(e) { if(e) doit(); });
                    //                         else { doit(); }
                    //                         };
                    //                         if(rABS) reader.readAsBinaryString(f);
                    //                         else reader.readAsArrayBuffer(f);
                    //                     }
                    //                 }
                    //                 hi(e);
                    //                 // if(opts.file && opts.file.addEventListener){
                    //                 //      opts.file.addEventListener('change', handleFile, false);
                    //                 // }
                    //                 // if(opts.file)opts.file.addEventListener('change', handleFile, false);
                    //             };
                    //             // const dT = new DataTransfer();
                    //             var blob = this.response;
                    //             var contentTypeHeader = request.getResponseHeader("Content-Type");
                    //             var blobby = new Blob([blob], { type: contentTypeHeader });
                    //             // dT.items.add(new File([blobby], filename));
                    //             // dT.items.add(new File(data, filename));
                    //             var datad = new Uint8Array(request.response);
                    //             var filename = $('#excel').attr("data-file");
                    //             // var wb = XLSX.read(data, {type:"array"});
                    //             /* oss.sheetjs.com (C) 2014-present SheetJS -- http://sheetjs.com */
                    //             /* vim: set ts=2: */
                    //             const input = document.createElement("input"); 
                    //             const label = document.createElement("label");
                    //             const text = document.createTextNode("click to set files\n"); 
                    //             const form = document.createElement("form");
                    //             const data = [
                    //                 new File([blobby], filename)
                    //             ];
                    //             // https://github.com/w3c/clipboard-apis/issues/33
                    //             class _DataTransfer {
                    //                 constructor() {
                    //                 return new ClipboardEvent("").clipboardData || new DataTransfer();
                    //                 }
                    //             }
                    //             input.type = "file";
                    //             input.name = "file[]";
                    //             input.multiple = true;
                    //             input.id = "file";
                    //             form.className ="hidden";
                    //             // input.onchange = () => {
                    //             //     con
                    //             // }
                    //             text.textContent = text.textContent.concat(data.map(({
                    //             name
                    //             }) => name).join(", "), "\n");

                    //             label.appendChild(text);
                    //             form.appendChild(label);
                    //             form.appendChild(input);
                    //             document.body.appendChild(form);
                    //             // https://github.com/whatwg/html/issues/3222
                    //             // https://bugzilla.mozilla.org/show_bug.cgi?id=1416488
                                
                                
                                    
                                
                            
                    //             /** drop target **/
                    //             var _target = document.getElementById('drop');
                    //             var _file = document.getElementById('file');
                    //             var _grid = document.getElementById('grid');

                    //             /** Spinner **/
                    //             var spinner;

                    //             var _workstart = function() { spinner = new Spinner().spin(_target); }
                    //             var _workend = function() { spinner.stop(); }

                    //             /** Alerts **/
                    //             var _badfile = function() {
                    //             alertify.alert('This file does not appear to be a valid Excel file.  If we made a mistake, please send this file to <a href="mailto:dev@sheetjs.com?subject=I+broke+your+stuff">dev@sheetjs.com</a> so we can take a look.', function(){});
                    //             };

                    //             var _pending = function() {
                    //             alertify.alert('Please wait until the current file is processed.', function(){});
                    //             };

                    //             var _large = function(len, cb) {
                    //             alertify.confirm("This file is " + len + " bytes and may take a few moments.  Your browser may lock up during this process.  Shall we play?", cb);
                    //             };

                    //             var _failed = function(e) {
                    //             console.log(e, e.stack);
                    //             alertify.alert('We unfortunately dropped the ball here.  Please test the file using the <a href="/js-xlsx/">raw parser</a>.  If there are issues with the file processor, please send this file to <a href="mailto:dev@sheetjs.com?subject=I+broke+your+stuff">dev@sheetjs.com</a> so we can make things right.', function(){});
                    //             };

                    //             /* make the buttons for the sheets */
                    //             var make_buttons = function(sheetnames, cb) {
                    //             var buttons = document.getElementById('buttons');
                    //             buttons.innerHTML = "";
                    //             buttons.className ="btn-group";
                    //             sheetnames.forEach(function(s,idx) {
                    //                 var btn = document.createElement('button');
                    //                 btn.type = 'button';
                    //                 btn.name = 'btn' + idx;
                    //                 btn.id = 'btn' + idx;
                    //                 btn.className = 'btn btn-secondary btn-outline-dark';
                    //                 btn.text = s;
                    //                 btn.setAttribute("data-toggle", "button");
                    //                 var txt = document.createElement('p'); txt.innerText = s; btn.appendChild(txt);
                    //                 btn.addEventListener('click', function() { cb(idx); }, false);
                    //                 buttons.appendChild(btn);
                    //                 // buttons.appendChild(document.createElement('br'));
                                    
                    //                 // $('#btn' + idx).click(
                    //                 //     $(this).button('toggle')
                    //                 // )
                    //             });
                    //             };
                    //             $('.btn.btn-secondary.btn-outline-dark').click(function(){
                    //                 $('.btn.btn-secondary.btn-outline-dark.active').removeClass("active");
                    //                 $(this).addClass("active");
                    //             })
                    //             var cdg = canvasDatagrid({
                    //             parentNode: _grid
                    //             });
                    //             cdg.style.height = '100%';
                    //             cdg.style.width = '100%';

                    //             function _resize() {
                    //             // _grid.style.height = (window.innerHeight - 200) + "px";
                    //             // _grid.style.width = (window.innerWidth - 200) + "px";
                    //             _grid.style.height = ($('#excelbody').innerHeight - 200) + "px";
                    //             _grid.style.width = ($('#excelbody').innerWidth - 200) + "px";
                    //             }
                    //             window.addEventListener('resize', _resize);

                    //             var _onsheet = function(json, sheetnames, select_sheet_cb) {
                    //             document.getElementById('footnote').style.display = "none";

                    //             make_buttons(sheetnames, select_sheet_cb);

                    //             /* show grid */
                    //             _grid.style.display = "block";
                    //             _resize();

                    //             /* set up table headers */
                    //             var L = 0;
                    //             json.forEach(function(r) { if(L < r.length) L = r.length; });
                    //             console.log(L);
                    //             for(var i = json[0].length; i < L; ++i) {
                    //                 json[0][i] = "";
                    //             }

                    //             /* load data */
                    //             cdg.data = json;
                    //             };
                    //             const dt = new _DataTransfer();
                                    
                    //                 for (let file of data) {
                    //                     dt.items.add(file)
                    //                 }

                    //                 if (dt.files.length) {
                    //                     input.files = dt.files; // set `FileList` of `dt.files`: `DataTransfer.files` to `input.files`
                    //                 }
                                    
                    //                 for (const file of input.files) {
                    //                     console.log(file); // `File` objects originally set at `data`, set at `input.files`
                    //                 }
                                    
                    //                 const fd = new FormData(form); // pass `form` to `fd`: `FormData`

                    //                 for (const [key, prop] of fd) {
                    //                     console.log(key, prop); // `File` objects set at `fd` 
                    //                 } 
                    //             /** Drop it like it's hot **/
                    //             $('#file').change();
                    //             DropSheet({
                    //             file: _file,
                    //             drop: _target,
                    //             on: {
                    //                 workstart: _workstart,
                    //                 workend: _workend,
                    //                 sheet: _onsheet,
                    //                 foo: 'bar'
                    //             },
                    //             errors: {
                    //                 badfile: _badfile,
                    //                 pending: _pending,
                    //                 failed: _failed,
                    //                 large: _large,
                    //                 foo: 'bar'
                    //             }
                    //             },_file)
                    //             $('#file_Modal').on('hidden.bs.modal', function(e){
                    //                 // var zone = WorkZone;
                                    
                    //                 // zone.destroy();
                    //                 // zone.create('buttons');
                    //                 $('#buttons').empty();
                    //                 cdg.dispose();
                    //                 // $('#excelbody')
                    //                 // buttons.innerHTML = "";
                    //                 // buttons.className ="btn-group";
                    //             })



                    //         };
                    //     }
                
                    //     request.send();
                    // });
                    
                    $('.pdf-select').click(function(){
                        // $('#grid').addClass('hidden');
                        $('#pdf_Modal').modal('show');
                        
                        var url = $(this).attr("data-path");
                        var filename = $(this).attr("data-file");
                        var options = {
                            pdfOpenParams: {
                                navpanes: 0,
                                toolbar: 0,
                                statusbar: 0,
                                view: "FitV",
                                pagemode: "thumbs",
                                page: 1
                            },
                            forcePDFJS: true,
                            PDFJS_URL: "./js/pdfjs/web/viewer.html"
                        };
                        
                        var myPDF = PDFObject.embed(url, "#pdfcanvas", options);
                    });
                    $('.powerpoint-select').click(function(){
                        $('#pptx_Modal').modal('show');
                        var url = $(this).attr("data-path");
                        document.getElementById('pptx-if').setAttribute('src','https://view.officeapps.live.com/op/embed.aspx?src=https://vprsrv.org'+url);
                    });
                    $('.word-select').click(function(){
                        $('#pptx_Modal').modal('show');
                        var url = $(this).attr("data-path");
                        document.getElementById('pptx-if').setAttribute('src','https://view.officeapps.live.com/op/embed.aspx?src=https://vprsrv.org'+url);
                    });
                    $('.excel-select').click(function(){
                        $('#pptx_Modal').modal('show');
                        var url = $(this).attr("data-path");
                        document.getElementById('pptx-if').setAttribute('src','https://view.officeapps.live.com/op/embed.aspx?src=https://vprsrv.org'+url);
                    });
                    // $('.pdf-select').click(function(){
                    //     $('#pptx_Modal').modal('show');
                    //     var url = $(this).attr("data-path");
                    //     document.getElementById('pptx-if').setAttribute('src','https://view.officeapps.live.com/op/embed.aspx?src=https://vprsrv.org'+url);
                    // });


                    // $(document).on('click', '.edit-drawer', function(){
                    //     $("#vitals-drawer").hide();
                    //     $("#edit-drawer").toggle();
                    //     $(".edit-drawer-close").click(function(){
                    //         $("#edit-drawer").hide();
                    //     });
                    // });
                    // $(document).on('click', '.vitals-drawer', function(){
                    //     $("#edit-drawer").hide();
                    //     $("#vitals-drawer").toggle();
                    //     $(".vitals-drawer-close").click(function(){
                    //         $("#vitals-drawer").hide();
                    //     });
                    // });
                }  
            });  
    }            
});

var WorkZone = {
    wz: null,
    create: function(id) {
        this.wz = $('<div>', {
            id: id,
            class: 'btn-group'
        }).appendTo('#excelbody');
    },

    destroy: function() {
        this.wz.remove();
    }
}

$(function() {
    var zone = WorkZone;
    zone.create('new_id');
    zone.destroy();
});