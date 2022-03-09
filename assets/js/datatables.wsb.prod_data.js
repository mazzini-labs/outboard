$(function(){
    var click0 = 0;
    var click1 = 0;
    var click2 = 0;
    var click3 = 0;
    var click4 = 0;
    var lTable;
    var oTable;
    var iTable;
    var sTable;
    var da = "ddr2015pres";
    var sa = "dsr2015pres";
    var db = "before2015detailrpt";
    var sb = "before2015sumrpt";
    var click = 0;
    var clickddr = 0;
    var clickdsr = 0;
    var clickt1 = 0;
    var clickt2 = 0;
    var clickt3 = 0;
    var clickt4 = 0;
    var clickt5 = 0;
    var clickt6 = 0;
    var clickViewEdit = 0;
    var aDDRTable;
    var aDSRTable;
    var bDDRTable;
    var bDSRTable;
    var vTable;
    var editID;
    var drn_t = {
        btns: [
            ['viewHTML'],
            ['undo', 'redo'], // Only supported in Blink browsers
            ['formatting'],
            ['strong', 'em', 'del'],
            ['superscript', 'subscript'],
            ['foreColor', 'backColor'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['removeformat'],
            ['fullscreen']
        ],
        removeformatPasted: true
    };
    var notiflixLoader = {
        backgroundColor: 'rgba(0,0,0,0.8)',
        svgColor: '#035696',
        messageColor: '#DCDCDC',
        svgSize: '80px',
        messageFontSize: '15px'
    }
    $(document).ready(function() {
        // $(document).on( 'preInit.dt', function (e, settings) {
        //     Notiflix.Block.pulse('.tab-content', 'Loading...', notiflixLoader);
        // });
        var url = window.location.pathname;
        if (url.indexOf("prod_data")  !==-1 )
        {
            var bodyheightdifference = document.querySelector("body").scrollHeight - document.querySelector("body").offsetHeight;
                console.log(bodyheightdifference);
            var body = document.querySelector("body").offsetHeight;
            var nav = document.querySelector("body > nav").offsetHeight;
            var subnav = document.querySelector("#tabs").offsetHeight;
            var table_header = document.querySelector("#ddrTable").offsetHeight;
            var dt_scroller_height = body - nav - subnav - table_header - 5;
            var chart_size = body - nav - nav - subnav - 96;
            // document.querySelector(".chart-container").setAttribute('style','position:relative;width:100%;height:'+chart_size+'px;')
            console.log("prod_data conditional success " + url);
            $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
                $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
                console.log('click: '+click+' clickddr: '+clickddr+' clickt1: '+clickt1+' clickt2: '+clickt2+' clickt3: '+clickt3+' clickt4: '+clickt4);
            } );
    
            if (click < 1){
                click++;
                // Notiflix.Block.pulse('.tab-content', 'Loading...', notiflixLoader);
                oTable = $('#productionTable').DataTable( {
                    "ajax": {
                    "url" : "ajax/prodajax.php",
                    // "type" : "POST",
                    "data": {
                        "api": window.api,
                        //"sheet": "ddr2015pres"
                    }
                    },
                    "sDom": 't',
                    //"sDom": 'd',
                    "order": [],
                    //"paging": false,
                    //"info": false,
                    
                    deferRender: true,
                    scrollY: chart_size,
                    scroller: true,
                    "searching": true,
                    //
                    "autoWidth": false,
                    "columns": [
                        {
                        "data": "prod_mo", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "days_on", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "gas_wh_mcf", // can be null or undefined
                        "defaultContent": "",
                        render: $.fn.dataTable.render.number( ',', '.', 2, '', ' mcf' )
                        },
                        {
                        "data": "oil_prod", // can be null or undefined
                        "defaultContent": "",
                        render: $.fn.dataTable.render.number( ',', '.', 2, '', ' bbl' )
                        },
                        {
                        "data": "water_prod", // can be null or undefined
                        "defaultContent": "",
                        render: $.fn.dataTable.render.number( ',', '.', 2, '', ' bbl' )
                        },
                        {
                        "data": "gas_sold", // can be null or undefined
                        "defaultContent": "",
                        render: $.fn.dataTable.render.number( ',', '.', 2, '', ' mcf' )
                        },
                        {
                        "data": "oil_sold", // can be null or undefined
                        "defaultContent": "",
                        render: $.fn.dataTable.render.number( ',', '.', 2, '', ' bbl' )
                        },
                        {
                        "data": "gas_line_loss", // can be null or undefined
                        "defaultContent": "",
                        render: $.fn.dataTable.render.number( ',', '.', 2, '', ' mcf' )
                        },
                        {
                        "data": "flug", // can be null or undefined
                        "defaultContent": "",
                        render: $.fn.dataTable.render.number( ',', '.', 0, '', '%' )
                        },
                    ],
                    // "drawCallback": function(settings){ Notiflix.Block.remove('.tab-content',2000); }
                    
                        
                } );
            };
        
            $('#ddr-tab').on('shown.bs.tab', function (e) {
                // .click(function(){
                
                if(clickddr < 1){
                    clickddr++;
                    Notiflix.Block.pulse('.tab-content', 'Loading...', notiflixLoader);
                    var info;
                    iTable = $('#ddrTable').on('init.dt', function () {
                        feather.replace();
                        tippy('.r-tooltip', { 
                            arrow: false 
                        });
                        tippy('.hours', { 
                            placement: 'right',
                            arrow: false 
                        });
                        info = iTable.page.info().length;
                        iTable.scroller().scrollToRow(info);
                        window.scrollTo(0,document.querySelector(".dataTables_scrollBody").scrollHeight);
                    } 
                        ).DataTable( {
                        // "stateSave": true,
                        "ajax": {
                            "url" : "ajax/prodnotes.ajax.php",
                            "data": 
                            {
                                "api": api,
                            }
                        }, 
                        "sDom": 't',
                        //"order": [[0, 'desc'], [1, 'desc']],
                        "order": [[1, 'asc'], [2, 'asc']],
                        deferRender: false,
                        // scrollY: 550,
                        scrollY: dt_scroller_height,
                        scroller: {
                            loadingIndicator: true
                        },
                        "searching": true,
                        "autoWidth": false, 
                        // stateSave: true,
                        // "stateDuration": 0,
                        // stateLoadCallback: function (settings) {
                        //     var o;
                     
                        //     // Send an Ajax request to the server to get the data. Note that
                        //     // this is a synchronous request since the data is expected back from the
                        //     // function
                        //     $.ajax( {
                        //         url: '/state_load',
                        //         async: false,
                        //         dataType: 'json',
                        //         success: function (json) {
                        //             o = json;
                        //         }
                        //     } );
                     
                        //     return o;
                        // },
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
                                "data": null, render: function ( data, type, row ) 
                                {
                                    // "<i data-feather='edit-2' style='color: light-blue; height: 1.5em!important; width: 1.5em!important;'></i> Out to Lunch</a></span></div></div>"
                                    // <img class="img-fluid" src="assets/images/edit-2.svg" border=0>
                                    // return '<div class="row"><div class="col"><span class=\"r-tooltip\" data-tippy-content=\"Edit\" tabindex=\"0\"><a class="btn-sm btn-light shadow-lg edit_ddr-'+data.d+'" style="color:blue;" id="'+data.id+'" href="#'+data.id+'"><i data-feather="edit-2" style="color: blue; height: 1.5em!important; width: 1.5em!important;"></i></a></span>&ensp;<a style="color: gray; font-size:9;" id="'+data.id+'"></a><span class=\"r-tooltip\" data-tippy-content=\"View Entry\" tabindex=\"0\"><a class="btn-sm btn-secondary view_data" href="#'+data.id+'" id="'+data.id+'"><i data-feather="eye" style="color: light-blue; height: 1.5em!important; width: 1.5em!important;"></i></a></span><span class=\"r-tooltip\" data-tippy-content=\"Print Entry\" tabindex=\"0\"><a class="btn-sm btn-secondary view_data" href="#'+data.id+'" target="_blank" id="'+data.id+'"><i data-feather="print" style="color: light-blue; height: 1.5em!important; width: 1.5em!important;"></i></a></span></div></div>';
                                    var a = "false";
                                    if (data.sd !== null){ a = "true"}
                                    var buttons = "<button class='actionbtn' id=actionbtn"+data.id+" data-type="+data.d+" data-id="+data.id+" data-file="+a+">Actions</button>";
                                    buttons += '<span><span class="actionbtn1" id="action'+data.id+'" style="display:none!important;">'
                                    buttons += '<div class="row" style="padding: 0 0 0 0!important; margin-left:0px!important; margin-right:0px!important;">';
                                    buttons += '<div class="col" style="padding: 0 0 .5rem 0!important;">';
                                    // Edit Button HTML
                                    buttons += '<span class=\"r-tooltip\" data-tippy-content=\"Edit\" tabindex=\"0\">';
                                    buttons += '<a class="btn btn-sm btn-light shadow-lg edit_ddr-'+data.d+'" style="color:blue;" id="'+data.id+'" href="#'+data.id+'">';
                                    buttons += '<i data-feather="edit-2" style="color: blue; height: 1.5em!important; width: 1.5em!important;"></i></a></span>&ensp;';
                                    
                                    // buttons += '<a style="color: gray; font-size:9;" id="'+data.id+'"></a>';
                                    buttons += '</div>';
                                    buttons += '<div class="col" style="padding: 0 0 .5rem 0!important;>';

                                    // View Button HTML
                                    buttons += '<span class=\"r-tooltip\" data-tippy-content=\"View Entry\" tabindex=\"0\">';
                                    buttons += '<a class="btn btn-sm btn-secondary view_data" href="#'+data.id+'" id="'+data.id+'">';
                                    buttons += '<i data-feather="eye" style="color: light-blue; height: 1.5em!important; width: 1.5em!important;"></i></a></span>&ensp;';
                                    
                                    buttons += '</div></div>';
                                    buttons += '<div class="row" style="padding: 0 0 0 0!important; margin-left:0px!important; margin-right:0px!important;">';
                                    buttons += '<div class="col" style="padding: 0 0 0 0!important;">';
                                    
                                    buttons += '<span class=\"r-tooltip\" data-tippy-content=\"Print Entry\" tabindex=\"0\">';
                                    buttons += '<a class="btn btn-sm btn-info" href="ajax/printEntry.php?id='+data.id+'" target="_blank" id="'+data.id+'">';
                                    buttons += '<i data-feather="printer" style="color: light-blue; height: 1.5em!important; width: 1.5em!important;"></i></a></span>';
                                    buttons += '</div>';
                                    if (data.sd !== null){
                                        
                                        buttons += '<div class="col" style="padding: 0 0 0 0!important;">';
                                        buttons += '<span class=\"r-tooltip\" data-tippy-content=\"There are files attached to this entry.\" tabindex=\"0\">';
                                        // buttons += '<a class="btn-sm btn-info" href="ajax/printEntry.php?id='+data.id+'" target="_blank" id="'+data.id+'">';
                                        buttons += '<i data-feather="file" style="color: indigo; height: 1.5em!important; width: 1.5em!important;"></i></a></span>';
                                        buttons += '</div>';
                                    }
                                    buttons += '</div></span><span>';

                                    // var test;
                                    

                                    return buttons;
                                    // return '<button name="edit" value="Edit" id="'+data.id+'" class="btn btn-info btn-sm edit_ddr-'+data.d+'" data-toggle="tooltip" title="Edit" /><i data-feather="edit-2" style="color: light-blue; height: 1.5em!important; width: 1.5em!important;"></i></button><button data-toggle="tooltip" title="View" name="view" value="view" id="'+data.id+'" class="btn btn-info btn-sm view_data" /><img class="img-fluid" src="assets/images/eye.svg" border=0></button>'; target="_blank"
                                    //return '<input type="button" name="edit" value="Edit" id="'+data.id+'" class="btn btn-info btn-sm edit_ddr-'+data.d+'" /><input type="button" name="view" value="view" id="'+data.id+'" class="btn btn-info btn-sm view_data" />';
                                },
                                "defaultContent": "",
                            },
                            {
                                // Date
                                // TODO: get dates formatted as M-D-YYYY in select statement
                                "data": "de",  
                                "render": function(data, type) {
                                    return type === 'sort' ? data : moment(data).format('L') + ', ' + moment(data).format('ddd');
                                },
                                "defaultContent": ""
                            },
                            {
                                // Time (Start - End)
                                // TODO: get times formatted as H:MM in select statement
                                "data": null, render: function ( data, type, row ) 
                                {
                                    var time;
                                    // console.log(data.ts);
                                    if(data.d === 'a'){
                                        time = ""
                                    }
                                    else if(data.ts === data.te){
                                        console.log("same");
                                        time = (moment(data.ts, 'HH:mm:ss').format('hh:mm a'))
                                    } else {
                                        time = (moment(data.ts, 'HH:mm:ss').format('hh:mm a')+' <br> '+moment(data.te, 'HH:mm:ss').format('hh:mm a'))
                                    }
                                    return type === 'sort' ? data.ts : time;
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
                                                return 'OK - '+data.ai+'<br>'+data.ad;
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
                            
                        ],
                        "columnDefs": [
                            
                            // { width: "5%", "targets": [0, 1, 5, 6, 7] },
                            // { width: "10%", "targets": [2, 3] },
                            // { width: "30%", "targets": 4 },

                            { width: "2%", "targets": [0, 1, 2, 6, 7] },
                            { width: "5%", "targets": [3, 4] },
                            { width: "30%", "targets": 5 },
                            // { type: "time-ui", "targets":  1  },
                            // { className: "text-wrap", "targets":  [3, 4, 5]  },
                            { className: "text-wrap", "targets":  [0, 3, 4, 5, 7]  },
    
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
                                    // $('td').eq(0).find('td').addClass('engineering');
                                    // $('td:eq(1)', row).addClass('engineering-date');
                                    // $('td').eq(1).find('td').addClass('engineering');
                                    // $('td').eq(1).find('td').addClass('engineering-date');
                                    // $('td:eq(2)', row).addClass('engineering-date');
                                    $('td:eq(1)', row).addClass('engineering-date');
                                    // console.log($('td',1));
                                break;
                                case 'a':
                                    $('td', row).addClass('accounting');
                                    $('td:eq(1)', row).addClass('accounting-date');
                                    $('td:eq(7)', row).addClass('accounting-date');
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
                                tippy('.actionbtn', {
                                    trigger: "click",
                                    placment: "right",
                                    content(reference) {
                                        const id = "action" + reference.getAttribute('data-id');
                                        console.log(id);
                                        const template = document.getElementById(id);
                                        return template.innerHTML;
                                    }, interactive: true, inlinePositioning: true, allowHTML: true,
                                    onCreate(instance){
                                        feather.replace();
                                    }
                                });
                                $('.actionbtn').addClass("btn");
                                $('.actionbtn').addClass("btn-primary");
                                Notiflix.Block.remove('.tab-content',2000);
                            } 
            
    
                    } );
                    
                };
            });
            $('#dsr-tab').on('shown.bs.tab', function (e) {
                //.click(function(){
                if(clickdsr < 1){
                    clickdsr++;
Notiflix.Block.pulse('.tab-content', 'Loading...', notiflixLoader);
                
                    sTable = $('#dsrTable').DataTable( {
                        "ajax": {
                            "url" : "ajax/dsr.ajax.php",
                            "data": function ( d )  
                            {
                                d.api = window.api;
                            }
                        }, 
                        "sDom": 't',
                        "order": [],
                        
                        deferRender: true,
                        scrollY: dt_scroller_height,
                        scroller: true,
                        "searching": true,
                        "autoWidth": false, 
                        "columns": [
                            {
                                // Date
                                "data": "de", 
                                "defaultContent": ""
                            },
                            {
                                // DSR
                                "data":  "drn",
                                "defaultContent": "",
                            },
                            {
                                // EDC  
                                "data": "edc",
                                "defaultContent": "",
                                render: $.fn.dataTable.render.number( ',', '.', 2, '$')
                            },
                            {
                                // ECC
                                "data": "ecc",
                                "defaultContent": "",
                                render: $.fn.dataTable.render.number( ',', '.', 2, '$')
                            },
                            {
                                "data": null, render: function ( data, type, row ) 
                                {
                                    // var button = '<button name="edit" value="Edit" id="'+data.id+'" class="btn btn-info btn-sm edit_dsr" data-toggle="tooltip" title="Edit" />';
                                    // button += '<img src="assets/images/edit-2.svg border=0></button>';
                                    // button += '<button data-toggle="tooltip" title="View" name="view" value="view" id="'+data.id+'" class="btn btn-info btn-sm view_data" />';
                                    // button += '<img src="assets/images/eye.svg border=0></button>';
    
                                    var buttons = '<div class="row">';
                                    buttons += '<div class="col">';
                                    // Edit Button HTML
                                    buttons += '<span class=\"r-tooltip\" data-tippy-content=\"Edit\" tabindex=\"0\">';
                                    buttons += '<a class="btn-sm btn-light shadow-lg edit_dsr" name="edit" style="color:blue;" id="'+data.id+'" href="#'+data.id+'">';
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
                                    
                                },
                                "defaultContent": "",
                            },
                        ],
                        "columnDefs": [
                            
                            { width: "2%", "targets": [0, 2, 3, 4] },
                            { width: "50%", "targets": 1 },
                            { className: "text-wrap", "targets":  1  },
                        ] ,
                        "drawCallback": function(settings){
                            feather.replace();
                            tippy('.r-tooltip', { 
                                arrow: false 
                            });
                            tippy('.hours', { 
                                placement: 'right',
                                arrow: false 
                            });
                            Notiflix.Block.remove('.tab-content',2000);
                        }   
                    } );
                };
            });
            $('#t1-tab').on('shown.bs.tab', function (e) {
            // .click(function(){
                if(clickt1 < 1){
                    clickt1++;
Notiflix.Block.pulse('.tab-content', 'Loading...', notiflixLoader);
                    aDDRTable = $('#ddr2015pres').on( 'init.dt', function () {
                        aDDRTable.scroller().scrollToRow(100000);
                    } )
                    .DataTable( {
                        "ajax": 
                        {
                            "url" : "ajax/ddr.fetch.php",
                            // "type" : "POST",
                            "data": 
                            {
                                "api": window.api,
                                // "sheet": "ddr2015pres"
                            }
                        },
                        "sDom": 't',
                        "order": [],
                        //deferRender: true,
                        scrollY: dt_scroller_height,
                        scroller: true,
                        "searching": true,
                        "autoWidth": "false",
                        "columns": [
                            {
                            "data": "a", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "b", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "c", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "d", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "e", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "f", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "g", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "t",
                            "defaultContent": ""
                            },    
                        ],
                        "columnDefs": [
                            { "width": "20%", "targets": 0 }
                        ],
                        "columnDefs": [
                        { className: "text-wrap", "targets":  [0,1,2,3,4,5,6]  },
                        {
                            "targets": [ 7 ],
                            "visible": false,
                            "searchable": false
                        },
                        {
                            targets: [5],
                            "createdCell": function (td, cellData, rowData, row, col) {
                                {
                                    var str = aDDRTable.cell(td,4).data(); 
                                    var amt = aDDRTable.cell(td,5).data();
                                    var type = aDDRTable.cell(td,7).data();
                                    // console.log(type);
                                    // console.log(str);
                                    // console.log(str[0]);
                                    try {
                                        if(type == 'a' && str[0].toUpperCase() == str[0] && str[1].toUpperCase() == str[1])
                                        {
                                            // return commaSeparateNumber(amt);
                                            aDDRTable.cell(td,5).data("$" + formatMoney(amt));
                                            // console.log(formatMoney(amt));
                                            // $.fn.dataTable.render.number( ',', '.', 0, '', '%' );
                                        }
                                    }
                                    catch {
                                        console.log(str);
                                    }
                                }
                            },
    
                        }
                        ],
                        "rowCallback": function( row, data, index ) 
                        {
                            switch(data.t)
                            {
                                case 'e':
                                    $('td', row).addClass('engineering-d');
                                    $('td:eq(1)', row).addClass('engineering-date');
                                    $('td', row).addClass('engineering');
                                    // console.log($('td',1));
                                break;
                                case 'a':
                                    $('td', row).addClass('accounting-date');
                                    $('td', row).addClass('accounting-text');
                                break;
                                case 'v':
                                    $('td', row).addClass('vendor smol');
                                break;
                                default:
                                    $('td', row).addClass('field-date');
                                    $('td', row).addClass('field');
                                break;
                            }
                        },
                        "drawCallback": function( settings ) {
                            // Notiflix.Loading.remove(5000);
                            Notiflix.Block.remove('.tab-content',2000);
                        }
    
                    } );
                };
                
            });
            $('#vitals-tab').on('shown.bs.tab', function (e) {
            // .click(function(){
                if(clickt6 < 1){
                    clickt6++;
// Notiflix.Block.pulse('.tab-content', 'Loading...', notiflixLoader);
                    vitalsTable = $('#vitalsTable').DataTable( {
                        "ajax": 
                        {
                            "url" : "ajax/vitals.ajax.php",
                            // "type" : "POST",
                            "data": 
                            {
                                "api": window.api,
                                // "sheet": "ddr2015pres"
                            }
                        },
                        "sDom": 't',
                        "order": [],
                        deferRender: true,
                        scrollY: 150,
                        scroller: true,
                        "searching": false,
                        "autoWidth": true,
                        // 
                        // 
                        // 
                        // 
                        // 
                        // 
                        // 
                        // 
                        //
                        // 
                        // 
                        //
                        // 
                        // 
                        // 
                        // 
                        "columns": [
                            {
                            "name":"Date",
                            "data": "d", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "name":"FTP",
                            "data": "ftp", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "name":"FCP",
                            "data": "fcp", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "name":"SITP",
                            "data": "sitp", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "name":"SICP",
                            "data": "sicp", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "name":"FL",
                            "data": "fl", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "name":"Chlorides",
                            "data": "chlr", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "name":"Chem. Treat.",
                            "data": "ct", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "name":"Reason for Last Pull Job",
                            "data": "rpj", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "name":"General Reason for SI",
                            "data": "rsi", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "name":"Comments on SI",
                            "data": "csi", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "name":"P. PM",
                            // "data": "pmp", // can be null or undefined
                            "data": null, render: function ( data, type, row ) 
                                {
                                    var checkpmpa = data.pmpa / data.pmpa;
                                    if(checkpmpa == checkpmpa)
                                    {
                                        return data.pmp+' | Amount: -'+data.pmpa;
                                    }
                                    else if (data.pmp != '')
                                    {
                                        return data.pmp;
                                    }
                                    else 
                                    {
                                        return '';
                                    }
                                },
                            "defaultContent": ""
                            },
                            // {
                            // "data": "pmpa", // can be null or undefined
                            // "defaultContent": ""
                            // },
                            {
                            "name":"S. PM",
                            // "data": "pms", // can be null or undefined
                            "data": null, render: function ( data, type, row ) 
                                {
                                    var checkpmsa = data.pmsa / data.pmsa;
                                    if(checkpmsa == checkpmsa)
                                    {
                                        return data.pms+' | Amount: -'+data.pmsa;
                                    }
                                    else if (data.pms != '')
                                    {
                                        return data.pms;
                                    }
                                    else 
                                    {
                                        return '';
                                    }
                                    
                                },
                            "defaultContent": ""
                            },
                            // {
                            // "data": "pmsa", // can be null or undefined
                            // "defaultContent": ""
                            // },
                            {
                            "name":"PU Speed",
                            "data": "pus", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "name":"PU SL",
                            "data": "pusl", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "name":"PU On/Off",
                            "data": null, render: function ( data, type, row ) 
                                {
                                    console.log(moment(data.puon, 'HH:mm:ss').isValid());
                                    // console.log(moment(data.puon, 'HH:mm:ss').isValid.toDate());
                                    if(moment(data.puon, 'HH:mm:ss').isValid() || moment(data.puoff, 'HH:mm:ss').isValid())
                                    {
                                    return moment(data.puon, 'HH:mm:ss').format('HH:mm')+'-'+moment(data.puoff, 'HH:mm:ss').format('HH:mm');
                                    }
                                    else
                                    {
                                        return '';
                                    }
                                },
                            // "data": "puon",
                            "defaultContent": "",
                            },
    
                                                
                        ],
                        "columnDefs": [
                            { className: "smol text-wrap", "targets":  [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15]  },
                            // {
                            //     "targets": [ 17 ],
                            //     "visible": false 
                            // }
                        ],
                        // "drawCallback": function( settings ) {
                        //     // Notiflix.Loading.remove(5000);
                        //     Notiflix.Block.remove('.tab-content',2000);
                        // }
                    } );
                    pjTable = $('#pjTable').DataTable( {
                        "ajax": 
                        {
                            "url" : "ajax/vitals.ajax.php",
                            // "type" : "POST",
                            "data": 
                            {
                                "api": window.api,
                                // "sheet": "ddr2015pres"
                            }
                        },
                        "sDom": 't',
                        "order": [],
                        deferRender: true,
                        scrollY: 400,
                        scroller: true,
                        "searching": true,
                        "autoWidth": "false",
                        "columns": [
                            {
                            "data": "d", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "rpj", // can be null or undefined
                            "defaultContent": ""
                            },
                        ],
                        "columnDefs": [
                            { className: "smol text-wrap", "targets":  [0, 1]  },
                        ],
                        // "drawCallback": function( settings ) {
                        //     // Notiflix.Loading.remove(5000);
                        //     Notiflix.Block.remove('.tab-content',2000);
                        // }
                    } );
                
                    pmTable = $('#pmTable').DataTable( {
                        "ajax": 
                        {
                            "url" : "ajax/vitals.ajax.php",
                            // "type" : "POST",
                            "data": 
                            {
                                "api": window.api,
                                // "sheet": "ddr2015pres"
                            }
                        },
                        "sDom": 't',
                        "order": [],
                        deferRender: true,
                        scrollY: 400,
                        scroller: true,
                        "searching": true,
                        "autoWidth": "false",
                        "columns": [
                            {
                            "data": "d", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "pmp", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "pmpa", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "pms", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "pmsa", // can be null or undefined
                            "defaultContent": ""
                            },
                        ],
                        "columnDefs": [
                            { className: "smol text-wrap", "targets":  [0, 1, 2, 3, 4]  },
                        ],
                        // "drawCallback": function( settings ) {
                        //     // Notiflix.Loading.remove(5000);
                        //     Notiflix.Block.remove('.tab-content',2000);
                        // }
    
                    } );
            
                    siTable = $('#siTable').DataTable( {
                        "ajax": 
                        {
                            "url" : "ajax/vitals.ajax.php",
                            // "type" : "POST",
                            "data": 
                            {
                                "api": window.api,
                                // "sheet": "ddr2015pres"
                            }
                        },
                        "sDom": 't',
                        "order": [],
                        deferRender: true,
                        scrollY: 400,
                        scroller: true,
                        "searching": true,
                        "autoWidth": "false",
                        "columns": [
                            {
                            "data": "d", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "sitp", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "sicp", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "rsi", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "csi", // can be null or undefined
                            "defaultContent": ""
                            },
                        ],
                        "columnDefs": [
                            { className: "smol text-wrap", "targets":  [0, 1, 2, 3, 4]  },
                        ],
                        // "drawCallback": function( settings ) {
                        //     // Notiflix.Loading.remove(5000);
                        //     Notiflix.Block.remove('.tab-content',2000);
                        // }
                    } );
                };
            });
            $('#t2-tab').on('shown.bs.tab', function (e) {
                // .click(function(){
                if(clickt2 < 1){
                    clickt2++;
Notiflix.Block.pulse('.tab-content', 'Loading...', notiflixLoader);
                    aDSRTable = $('#dsr2015pres').on( 'init.dt', function () {
                        aDSRTable.scroller().scrollToRow(100000);
                    } )
                    .DataTable( {
                        "ajax": {
                        "url" : "ajax/ddr.fetchold.php",
                        // "type" : "POST",
                        "data": {
                            "api": api,
                            "sheet": sa
                        }
                        },
                        "sDom": 't',
                        "order": [],
                        //deferRender: true,
                        scrollY: dt_scroller_height,
                        scroller: true,
                        "searching": true,
                        "autoWidth": false,
                        // "order": [],
                        // "paging": false,
                        // "info": false,
                        // "searching": true,
                        // "sDom": 'd',
                        // "autoWidth": false,
                        "columns": [
                            {
                            "data": "a", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "b", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "c", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "d", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "e", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "f", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "g", // can be null or undefined
                            "defaultContent": ""
                            },
                        ],
                        "columnDefs": [
                        { className: "text-wrap", "targets":  [0,1,2,3,4,5,6]  }
                        ],
                        "rowCallback": function( row, data, index ) 
                        {
                            $('td', row).addClass('engineering');
                        },
                        "drawCallback": function( settings ) {
                            // Notiflix.Loading.remove(5000);
                            Notiflix.Block.remove('.tab-content',2000);
                        }
                    } );
                };
            });
            $('#t3-tab').on('shown.bs.tab', function (e) {
            // .click(function(){
                if(clickt3 < 1){
                    clickt3++;
Notiflix.Block.pulse('.tab-content', 'Loading...', notiflixLoader);
                    bDDRTable = $('#before2015detailrpt').on( 'init.dt', function () {
                        bDDRTable.scroller().scrollToRow(100000);
                    } )
                    .DataTable( {
                        "ajax": {
                        "url" : "ajax/ddr.fetchold.php",
                        // "type" : "POST",
                        "data": {
                            "api": api,
                            "sheet": db
                        }
                        },
                        "sDom": 't',
                        "order": [],
                        //deferRender: true,
                        scrollY: dt_scroller_height,
                        scroller: true,
                        "searching": true,
                        "autoWidth": false,
                        // "order": [],
                        // "paging": false,
                        // "info": false,
                        // "searching": true,
                        // "sDom": 'd',
                        // "autoWidth": false,
                        "columns": [
                            {
                            "data": "a", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "b", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "c", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "d", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "e", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "f", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "g", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "h", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "i", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "j", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "k", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "l", // can be null or undefined
                            "defaultContent": ""
                            },
                            /* {
                            "data": "m", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "n", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "o", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "p", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "q", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "r", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "s", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "t", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "u", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "v", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "w", // can be null or undefined
                            "defaultContent": ""
                            },
                            {
                            "data": "x", // can be null or undefined
                            "defaultContent": ""
                            }  */
                        ],
                        "columnDefs": [
                        { className: "text-wrap", "targets":  [0,1,2,3,4,5,6]  }
                        ],
                        "rowCallback": function( row, data, index ) 
                        {
                            $('td', row).addClass('engineering');
                        },
                        "drawCallback": function( settings ) {
                            // Notiflix.Loading.remove(5000);
                            Notiflix.Block.remove('.tab-content',2000);
                        }
                    } );
                };
            });
            $('#t4-tab').on('shown.bs.tab', function (e) {
                // .click(function(){
                if(clickt4 < 1){
                    clickt4++;
Notiflix.Block.pulse('.tab-content', 'Loading...', notiflixLoader);
                bDSRTable = $('#before2015sumrpt').on( 'init.dt', function () {
                    bDSRTable.scroller().scrollToRow(100000);
                    
                } )
                .DataTable( {
                    "ajax": {
                    "url" : "ajax/ddr.fetchold.php",
                    // "type" : "POST",
                    "data": {
                        "api": api,
                        "sheet": sb
                    }
                    },
                    "order": [],
                    "paging": false,
                    "info": false,
                    "searching": true,
                    "sDom": 'd',
                    "autoWidth": false,
                    "columns": [
                        {
                        "data": "a", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "b", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "c", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "d", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "e", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "f", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "g", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "h", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "i", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "j", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "k", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "l", // can be null or undefined
                        "defaultContent": ""
                        },
                        /* {
                        "data": "m", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "n", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "o", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "p", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "q", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "r", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "s", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "t", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "u", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "v", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "w", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "x", // can be null or undefined
                        "defaultContent": ""
                        }  */
                    ],
                        "columnDefs": [
                        { className: "text-wrap", "targets":  [0-11]  }
                        ],
                        "drawCallback": function( settings ) {
                            // Notiflix.Loading.remove(5000);
                            Notiflix.Block.remove('.tab-content',2000);
                        },
                        "rowCallback": function( row, data, index ) 
                        {
                            $('td', row).addClass('engineering');
                        }
                    } );
                };
            });
            $('#info-tab').on('shown.bs.tab', function (e) {
                // .click(function(){
                if(clickt5 < 1){
                    clickt5++;
// Notiflix.Block.pulse('.tab-content', 'Loading...', notiflixLoader);
                notesTable = $('#notesTable').DataTable( {
                    "ajax": {
                    "url" : "ajax/wellnotes.ajax.php",
                    // "type" : "POST",
                    "data": {
                        "api": api
                    }
                    },
                    "order": [],
                    "paging": true,
                    "info": false,
                    deferRender: true,
                    scrollY: "20vh",
                    scroller: true,
                    "searching": true,
                    "sDom": 't',
                    "autoWidth": true,
                    "columns": [
                        {
                        "data": "notes_update", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "notes", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "si_notes", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "pumper", // can be null or undefined
                        "defaultContent": ""
                        },
                            /*{
                        "data": "e", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "f", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "g", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "h", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "i", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "j", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "k", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "l", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "m", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "n", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "o", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "p", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "q", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "r", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "s", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "t", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "u", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "v", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "w", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "x", // can be null or undefined
                        "defaultContent": ""
                        }  */
                    ],
                        "columnDefs": [
                        { className: "text-wrap", "targets":  [0, 1, 2, 3]  }
                        ],
                        // "drawCallback": function( settings ) {
                        //     // Notiflix.Loading.remove(5000);
                        //     Notiflix.Block.remove('.tab-content',2000);
                        // }
                    } );
                };
            });
       
        
            $('#searchProduction').keyup(function(){
                var input, filter, ul, li, a, i;
                input = document.getElementById("searchProduction");
                filter = input.value.toUpperCase();
                div = document.getElementById("searchDropdown");
                a = div.getElementsByTagName("a");
                for (i = 0; i < a.length; i++) {
                    // if(i > 1){ 
                    //     $('#searchDropdown').dropdown('show')
                    // } else {
                    //     $('#searchDropdown').dropdown('hide')
                    // }
                    txtValue = a[i].textContent || a[i].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        a[i].style.display = "";
                        // $('#searchDropdown').dropdown('update')
                    } else {
                        a[i].style.display = "none";
                        // $('#searchDropdown').dropdown('update')
                    }
                }

                oTable.search($(this).val()).draw() ;
                if(clickddr != 0){
                iTable.search($(this).val()).draw() ;
                }
                if(clickdsr != 0){
                sTable.search($(this).val()).draw() ;
                }
                if(clickt1 != 0){
                aDDRTable.search($(this).val()).draw() ;
                }
                if(clickt2 != 0){
                aDSRTable.search($(this).val()).draw() ;
                }
                if(clickt3 != 0){
                bDDRTable.search($(this).val()).draw() ;
                }
                if(clickt4 != 0){
                bDSRTable.search($(this).val()).draw() ;
                }
            })
            $("#searchProduction").keypress(function(e) {
            //Enter key
            if (e.which == 13) {
                return false;
            }
            });
        }
        else if (url.indexOf("wsb")  !==-1 ){

            $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
                    $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
                } );

            if(click0 < 1){
                click0++;
Notiflix.Block.pulse('.tab-content', 'Loading...', notiflixLoader);
            
                lTable = $('#latestTable').on('init.dt', function () {
                    // Notiflix.Block.remove('.tab-content');
                } 
                    ).DataTable( {
                    stateSave: true,
                    "ajax": "./ajax/wsb.ajax.lpd.php",
                    "sDom": 't',
                    //"sDom": 'd',
                    "order": [],
                    //"paging": false,
                    //"info": false,
                    "keys": true,
                    // deferRender: true,
                    scrollY: 800,
                    // "scrollX": false,
                    scroller: true,
                    "searching": true,
                    //
                    // "autoWidth": false, 
                    
                    "columns": [
                        {
                            // Combine the Well and API into a single table field
                            // 181px
                            "data": null, render: function ( data, type, row ) 
                                {
                                    var cp;
                                    // console.log(data.entity_type);
                                    if(data.entity_type == "PIPE"){
                                        cp = ".cp";
                                        // return '<a href="prod_data.cp.php?api='+data.api+'">'+data.entity_common_name+' <br> '+data.api+'</a>';
                                    }
                                    else
                                    {
                                        cp = "";
                                        // return '<a href="prod_data.php?api='+data.api+'">'+data.entity_common_name+' <br> '+data.api+'</a>';
                                    }
                                    return '<a href="prod_data'+cp+'.php?api='+data.api+'">'+data.entity_common_name+' <br> '+data.api+'</a>';
                                }, 
                            "defaultContent": ""
                        },
                        /*
                        {
                            // State
                            // 14px
                            "data": "state", 
                            "defaultContent": ""
                        },
                        {
                            // County
                            // 69px
                            "data": "county_parish", 
                            "defaultContent": "",
                        },
                        {
                            // Block
                            // 85px
                            "data": "block", 
                            "defaultContent": "",
                        },
                        {
                            // 33
                            "data": "entity_operator_code", // Entity (Company)
                            "defaultContent": "",
                        },
                        */
                        {
                            // 39
                            "data": "producing_status", // Production Status
                            "defaultContent": "",
                        },
                        /*
                        {
                            // 27
                            "data": "production_type", // Production Type
                            "defaultContent": "",
                        },
                        */
                        {
                            // 44
                            "data": "update_latest_prod_date", // Last Active
                            /* render: function ( data, type, row ) 
                            {
                                var dateSplit = data.split('-');
                                return type === "display" || type === "filter" ?
                                    dateSplit[1] +'-'+ dateSplit[2] +'-'+ dateSplit[0] :
                                    data;
                            }, */
                            "defaultContent": "",
                        },
                        {
                            // 56
                            "data": "gas_wh_mcf", // Gas (mcf)
                            "defaultContent": "",
                            render: $.fn.dataTable.render.number( ',', '.', 0, '', '<small> mcf</small>' )
                        },
                        {
                            // 48
                            "data": "oil_prod", // Oil (bbl)
                            "defaultContent": "",
                            render: $.fn.dataTable.render.number( ',', '.', 0, '', '<small> bbl</small>' )
                        },
                        {
                            // 54
                            "data": "water_prod", // Water (bbl)
                            "defaultContent": "",
                            render: $.fn.dataTable.render.number( ',', '.', 0, '', '<small> bbl</small>' )
                        },
                        /*
                        {
                            // 56
                            "data": "gas_line_loss", // Gas Line Loss (mcf)
                            "defaultContent": "",
                            render: $.fn.dataTable.render.number( ',', '.', 0, '', '<small> mcf</small>' )
                        },
                        {
                            // 74
                            "data": "pumper", // Pumper
                            "defaultContent": "",
                        },
                        {
                                "data": null, render: function (data, type, row) 
                                {
                                    return "<div class='text-wrap width-200'>" + data.notes + "</div>";
                                },
                                "defaultContent": "",
                        },
                        */
                        {
                            // 56
                            "data": "report_frequency", // Gas Line Loss (mcf)
                            "defaultContent": "",
                            
                        },
                        {
                            // 91
                            "data": "notes_update", // Last Updated
                            /* render: function ( data, type, row ) 
                            {
                                var dateSplit = data.split('-');
                                return type === "display" || type === "filter" ?
                                    dateSplit[1] +'-'+ dateSplit[2] +'-'+ dateSplit[0] :
                                    data;
                            }, */
                            "render": function(data, type) {
                                // return type === 'sort' ? data : moment(data).format('LLL');
                                return type === 'sort' ? data : moment(data).format('MMM D YYYY') + " <br> " + moment(data).format('LT');
                            },
                            "defaultContent": "",
                        },
                    ],
                    "columnDefs": [
                        // { className: "text-wrap", "targets":  [ 12, 13 ]  },
                        // { width: "1%", "targets": 1 },
                        // { width: "3%", "targets": [4, 6] },
                        // { width: "4%", "targets": [5, 7, 9, 14] },
                        // { width: "5%", "targets": [8, 10, 11] },
                        // { width: "6%", "targets": 2 },
                        // { width: "7%", "targets": 12 },
                        // { width: "8%", "targets": [3] },
                        // { width: "17%", "targets": 0 },

                        // {
                        //     render: function (data, type, full, meta) {
                                
                        //         if ( data[5] == 'Shut-in' || data[5] =='Shut-In' || data[5]  == 'INACTIVE' )
                        //         {
                        //             return "<div class='text-wrap width-200 highlight'>" + data + "</div>";
                        //         }
                        //         else
                        //         {return "<div class='text-wrap width-200'>" + data + "</div>";}
                        //     },
                        //     targets: 13
                        // },

                        {
                            targets: 1,
                            "createdCell": function (td, cellData, rowData, row, col) {
                                {
                                    var checkSI = lTable.cell(td,1).data(); 
                                    if ( checkSI == 'Shut-in' || checkSI == 'Shut-In' || checkSI  == 'INACTIVE' || checkSI == 'Inactive' || checkSI == 'Down' || checkSI == 'TA'  || checkSI == 'P&A' || checkSI == 'S/I' ) 
                                    {
                                        $(td).css('background-color', '#F08080')
                                    }
                                    else if (checkSI == 'INJ' || checkSI == 'Injector' || checkSI == 'SWD' || checkSI == 'Inj')
                                    {
                                        $(td).css('background-color', '#8080F0')
                                    }
                                }
                            },
                            
                        },

                        // {
                        //     targets: 13,
                        //     "createdCell": function (td, cellData, rowData, row, col) {
                        //         {
                        //             var checkSI = oTable.cell(td,5).data(); 
                        //             if ( checkSI == 'Shut-in' || checkSI == 'Shut-In' || checkSI  == 'INACTIVE' || checkSI == 'Inactive' || checkSI == 'Down' || checkSI == 'TA'  || checkSI == 'P&A' || checkSI == 'S/I' ) 
                        //             {
                        //                 $(td).css('font-weight', 'bold')
                        //             }
                        //         }
                        //     },

                        // }
                        
                    ],
                    "drawCallback": function( settings ) {
                        // Notiflix.Loading.remove(5000);
                        Notiflix.Block.remove('.tab-content',2000);
                    }
                    // "rowCallback": function( row, data, index ) 
                    //     {
                    //         switch(data.notes)
                    //         {   
                    //             default:
                    //                 $('td', row).addClass('text-wrap');
                    //                 $('td:eq(13)', row).addClass('width-200');    
                    //         }
                    //     }
                            
                } );
            };
        
                if(click1 < 1){
                    click1++;
                    // Notiflix.Loading.pulse('Loading...');
                    Notiflix.Block.pulse('.tab-content', 'Loading...', notiflixLoader);
                    oTable = $('#productionTable').on('draw', function () {
                        
                    } 
                        ).DataTable( {
                        stateSave: true,
                        "ajax": "./ajax/wsb.ajax.php",
                        "sDom": 't',
                        "order": [],
                        "keys": true,
                        scrollY: 800,
                        scroller: true,
                        "searching": true,
                        "columns": [
                            {
                                // Combine the Well and API into a single table field
                                // 181px
                                "data": null, render: function ( data, type, row ) 
                                    {
                                        var cp;
                                        // console.log(data.entity_type);
                                        if(data.entity_type == "PIPE"){
                                            // cp = ".cp";
                                            cp = "";
                                            // return '<a href="prod_data.cp.php?api='+data.api+'">'+data.entity_common_name+' <br> '+data.api+'</a>';
                                        }
                                        else
                                        {
                                            cp = "";
                                            // return '<a href="prod_data.php?api='+data.api+'">'+data.entity_common_name+' <br> '+data.api+'</a>';
                                        }
                                        return '<a href="prod_data'+cp+'.php?api='+data.api+'">'+data.entity_common_name+' <br> '+data.api+'</a>';
                                    }, 
                                "defaultContent": ""
                            },
                            {
                                // State
                                // 14px
                                "data": "state", 
                                "defaultContent": ""
                            },
                            {
                                // County
                                // 69px
                                "data": "county_parish", 
                                "defaultContent": "",
                            },
                            {
                                // Block
                                // 85px
                                "data": "block", 
                                "defaultContent": "",
                            },
                            {
                                // 33
                                "data": "entity_operator_code", // Entity (Company)
                                "defaultContent": "",
                            },
                            {
                                // 39
                                "data": "producing_status", // Production Status
                                "defaultContent": "",
                            },
                            {
                                // 27
                                "data": "production_type", // Production Type
                                "defaultContent": "",
                            },
                            {
                                // 44
                                "data": "last_prod_date", // Last Active
                                "defaultContent": "",
                            },
                            {
                            // Gas (mcf)
                            "data": "gas_sold",
                            data: null,
                            render: function ( data, type, row ) {
                                var rn = $.fn.dataTable.render.number( ',', '.', 0, '', '<small> mcf</small>' ).display(data.gas_sold);
                                
                                var check = data.gas_sold / data.days_on;

                                if(check == check)
                                {
                                    return '<span class="daily">' + ( data.gas_sold / data.days_on ).toFixed(2)+' <sup>mcf</sup>/<sub>day</sub></span><span class="monthly">'+rn+'</span>';
                                }
                                else
                                {
                                    return '<span class="daily">' +data.gas_sold+' <sup>mcf</sup>/<sub>day</sub></span><span class="monthly">'+rn+'</span>';
                                }
                            }},
                            {
                            // Oil (bbl)
                            "data": "oil_prod",
                            data: null,
                            render: function ( data, type, row ) {
                                var rn = $.fn.dataTable.render.number( ',', '.', 0, '', '<small> bbl</small>' ).display(data.oil_prod);
                                
                                var check = data.oil_prod / data.days_on;
                            
                                if(check == check)
                                {
                                    return '<span class="daily">' + ( data.oil_prod / data.days_on ).toFixed(2)+' <sup>bbl</sup>/<sub>day</sub></span><span class="monthly">'+rn+'</span>';
                                }
                                else
                                {
                                    return '<span class="daily">' +data.oil_prod+' <sup>bbl</sup>/<sub>day</sub></span><span class="monthly">'+rn+'</span>';
                                }
                            }},
                            {
                            // Water (bbl)
                            "data": "water_prod",
                            data: null,
                            render: function ( data, type, row ) {
                                var rn = $.fn.dataTable.render.number( ',', '.', 0, '', '<small> bbl</small>' ).display(data.water_prod);
                                
                                var check = data.water_prod / data.days_on;
                            
                                if(check == check)
                                {
                                    return '<span class="daily">' + ( data.water_prod / data.days_on ).toFixed(2)+' <sup>bbl</sup>/<sub>day</sub></span><span class="monthly">'+rn+'</span>';
                                }
                                else
                                {
                                    return '<span class="daily">' +data.water_prod+' <sup>bbl</sup>/<sub>day</sub></span><span class="monthly">'+rn+'</span>';
                                }
                            }},
                            {
                            // Gas Line Loss (mcf)
                            "data": "gas_line_loss",
                            data: null,
                            render: function ( data, type, row ) {
                                var rn = $.fn.dataTable.render.number( ',', '.', 0, '', '<small> mcf</small>' ).display(data.gas_line_loss);
                                
                                var check = data.gas_line_loss / data.days_on;
                            
                                if(check == check)
                                {
                                    return '<span class="daily">' + ( data.gas_line_loss / data.days_on ).toFixed(2)+' <sup>mcf</sup>/<sub>day</sub></span><span class="monthly">'+rn+'</span>';
                                }
                                else
                                {
                                    return '<span class="daily">' +data.gas_line_loss+' <sup>mcf</sup>/<sub>day</sub></span><span class="monthly">'+rn+'</span>';
                                }
                            }},
                            {
                                // 74
                                "data": "pumper", // Pumper
                                "defaultContent": "",
                            },
                            {
                                    "data": null, render: function (data, type, row) 
                                    {
                                        return "<div class='text-wrap width-200'>" + data.notes + "</div>";
                                    },
                                    "defaultContent": "",
                            },
                            {
                                // 91
                                "data": "notes_update", // Last Updated
                                "render": function(data, type) {
                                    return type === 'sort' ? data : moment(data).format('MMM D YYYY') + " <br> " + moment(data).format('LT');
                                },
                                "defaultContent": "",
                            },
                        ],
                        "columnDefs": [
                            { className: "text-wrap dailymonthlytoggle", "targets":  [8, 9, 10, 11]  },
                            { className: "text-wrap", "targets":  [ 12, 13 ]  },
                            { width: "1%", "targets": 1 },
                            { width: "3%", "targets": [4, 6] },
                            { width: "4%", "targets": [5, 7, 9, 14] },
                            { width: "5%", "targets": [8, 10, 11] },
                            { width: "6%", "targets": 2 },
                            { width: "7%", "targets": 12 },
                            { width: "8%", "targets": [3] },
                            { width: "17%", "targets": 0 },
                            {
                                targets: 5,
                                "createdCell": function (td, cellData, rowData, row, col) {
                                    {
                                        var checkSI = oTable.cell(td,5).data(); 
                                        if ( checkSI == 'Shut-in' || checkSI == 'Shut-In' || checkSI  == 'INACTIVE' || checkSI == 'Inactive' || checkSI == 'Down' || checkSI == 'TA'  || checkSI == 'P&A' || checkSI == 'S/I' ) 
                                        {
                                            $(td).css('background-color', '#F08080')
                                        }
                                        else if (checkSI == 'INJ' || checkSI == 'Injector' || checkSI == 'SWD' || checkSI == 'Inj')
                                        {
                                            $(td).css('background-color', '#8080F0')
                                        }
                                    }
                                },
                                
                            },

                            {
                                targets: 13,
                                "createdCell": function (td, cellData, rowData, row, col) {
                                    {
                                        var checkSI = oTable.cell(td,5).data(); 
                                        if ( checkSI == 'Shut-in' || checkSI == 'Shut-In' || checkSI  == 'INACTIVE' || checkSI == 'Inactive' || checkSI == 'Down' || checkSI == 'TA'  || checkSI == 'P&A' || checkSI == 'S/I' ) 
                                        {
                                            $(td).css('font-weight', 'bold')
                                        }
                                    }
                                },

                            }
                            
                        ],
                        "drawCallback": function( settings ) {
                            // Notiflix.Loading.remove(5000);
                            Notiflix.Block.remove('.tab-content',2000);
                        }
                    } );
                };
            $('#shutin-tab').click(function(){
                if(click3 < 1){
                    click3++;
Notiflix.Block.pulse('.tab-content', 'Loading...', notiflixLoader);
                    sTable = $('#shutinTable').DataTable( {
                        stateSave: true,
                        "ajax": "ajax/si.ajax.php",
                        "sDom": 't',
                        //"sDom": 'd',
                        "order": [],
                        //"paging": false,
                        "info": true,
                        "keys": true,
                        deferRender: true,
                        scrollY: 800,
                        scroller: true,
                        "searching": true,
                        //
                        "autoWidth": false,
                        "columns": [
                            {
                            "data": null, render: function ( data, type, row ) 
                            {
                                // Combine the Well and API into a single table field
                                return '<a href="prod_data.php?api='+data.api+'">'+data.entity_common_name+' <br> '+data.api+'</a>';
                            }, 
                            "defaultContent": ""
                            },
                            {
                            "data": "state", // State
                            "defaultContent": ""
                            },
                            {
                            "data": "county_parish", // County
                            "defaultContent": "",
                            },
                            {
                            "data": "block", // Block
                            "defaultContent": "",
                            },
                            {
                            "data": "entity_operator_code", // Entity (Company)
                            "defaultContent": "",
                            },
                            {
                            "data": "si_notes", // Notes
                            "defaultContent": "",
                            },
                            {
                            "data": "notes_update", // Last Updated
                            // render: function ( data, type, row ) {
                            // var dateSplit = data.split('-');
                            // return type === "display" || type === "filter" ?
                            //     dateSplit[1] +'-'+ dateSplit[2] +'-'+ dateSplit[0] :
                            //     data;
                            // },
                            "defaultContent": "",
                            },
                        ],
                        "columnDefs": [
                            { className: "text-wrap", "targets":  5  },
                            { width: "1%", "targets": 1 },
                            { width: "3%", "targets": 4 },
                            { width: "6%", "targets": 2 },
                            { width: "8%", "targets": [3, 6] },
                            { width: "17%", "targets": 0 },
                            {
                                render: function (data, type, full, meta) {
                                    return "<div class='text-wrap width-200'>" + data + "</div>";
                                },
                                targets: 5
                            }
                        ],
                        "drawCallback": function( settings ) {
                            // Notiflix.Loading.remove(5000);
                            Notiflix.Block.remove('.tab-content',2000);
                        }
                                
                        } );
            }
            } );
            // .on( 'draw', function () {
            //     console.log( 'Redraw occurred at: '+new Date().getTime() );
            // } );
            $('#print-tab').click(function(){
                if(click4 < 1){
                    click4++;
                    $.fn.dataTable.ext.buttons.reload = {
                        extend: 'print',
                        text: 'Reload',
                        extend: 'print',
                        autoPrint: false,
                        exportOptions: {
                            stripHtml: false,
                            format: {
                                body: function ( inner, coldex, rowdex ) {
                                    if (inner.length <= 0) return inner;
                                    var el = $.parseHTML(inner);
                                    var result='';
                                    $.each( el, function (index, item) {
                                        if (item.nodeName == '#text') result = result + item.textContent;
                                        else if (item.nodeName == 'SUP') result = result + item.outerHTML;
                                        else if (item.nodeName == 'STRONG') result = result + item.outerHTML;
                                        else if (item.nodeName == 'IMG') result = result + item.outerHTML;
                                        else result = result + item.innerText;
                                    });
                                    return result;
                                }
                            }
                        },
                        action: function ( e, dt, node, config ) {
                            pTable.page.len( -1 ).draw();
                            pTable.on( 'draw', function () {
                                $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, node, config);
                            } );
                        }
                    };
                    pTable = $('#printTable').DataTable( {
                            "ajax": "./ajax/wsb.ajax.php",
                            "sDom": 'Btp',
                            "order": [],
                            
                            // deferRender: true,
                            // scrollY: 800,
                            // scrollCollapse: false,
                            // paging: true,
                            // scroller: true,
                            "searching": false,
                            "autoWidth": false, 
                            "buttons": [
                                'reload',
                                {
                                    extend: 'print',
                                    autoPrint: false,
                                    exportOptions: {
                                        stripHtml: false,
                                        format: {
                                            body: function ( inner, coldex, rowdex ) {
                                                if (inner.length <= 0) return inner;
                                                var el = $.parseHTML(inner);
                                                var result='';
                                                $.each( el, function (index, item) {
                                                    if (item.nodeName == '#text') result = result + item.textContent;
                                                    else if (item.nodeName == 'SUP') result = result + item.outerHTML;
                                                    else if (item.nodeName == 'STRONG') result = result + item.outerHTML;
                                                    else if (item.nodeName == 'IMG') result = result + item.outerHTML;
                                                    else result = result + item.innerText;
                                                });
                                                return result;
                                            }
                                        }
                                    }
                                },
                            ],
                            "columns": [
                                {
                                    "data": "entity_common_name",
                                    "defaultContent": ""
                                },
                                {
                                    "data": "pumper", // Pumper
                                    "defaultContent": "",
                                },
                                {
                                    // "data": "producing_status", // Production Status
                                    "data": null, render: function ( data, type, row ) 
                                    {
                                        if (data.producing_status == 'SWD'){
                                            return 'SWD';
                                        }
                                        else if (data.producing_status == 'SI' || data.producing_status == 'Shut-in' || data.producing_status == 'Shut-In' || data.producing_status  == 'INACTIVE')
                                        {
                                            return "SI "+data.last_prod_date;
                                        }
                                        else 
                                        {
                                            var result = '';
                                            var checkO = data.oil_prod / data.days_on;
                                            var checkW = data.water_prod / data.days_on;
                                            var checkG = data.gas_sold / data.days_on;
                                            var checkOil = checkO.toFixed(2);
                                            var checkWater = checkW.toFixed(2);
                                            var checkGas = checkG.toFixed(2);
                                            if (checkO == checkO && checkO >= 1) result = result + checkOil + " bopd "
                                            if (checkG == checkG && checkG >= 1) result = result + checkGas + " mcfpd "
                                            if (checkW == checkW && checkW >= 1) result = result + checkWater + " bwpd "
                                            return result;
                                        }
                                        
                                        
                                    }, 
                                    "defaultContent": "",
                                    },
                                {
                                    "data": null, render: function (data, type, row) 
                                    {
                                        return "<div class='text-wrap width-200'>" + data.notes + "</div>";
                                    },
                                    "defaultContent": "",
                                },
                                {
                                "data": "notes_update", // Last Updated
                                /* render: function ( data, type, row ) {
                                var dateSplit = data.split('-');
                                return type === "display" || type === "filter" ?
                                    dateSplit[1] +'-'+ dateSplit[2] +'-'+ dateSplit[0] :
                                    data;
                                }, */
                                "defaultContent": "",
                                },
                            ],
                        "columnDefs": [
                            { className: "text-wrap", "targets":  3  },
                            // { width: "1%", "targets": 1 },
                            // { width: "3%", "targets": [4, 6] },
                            // { width: "4%", "targets": [5, 7, 9, 14] },
                            // { width: "5%", "targets": [8, 10, 11] },
                            // { width: "6%", "targets": 2 },
                            // { width: "7%", "targets": 12 },
                            // { width: "8%", "targets": [3] },
                            // { width: "17%", "targets": 0 },

                            {
                                targets: 2,
                                "createdCell": function (td, cellData, rowData, row, col) {
                                    {
                                        var checkSI = pTable.cell(td,2).data(); 
                                        if ( checkSI == 'Shut-in' || checkSI == 'Shut-In' || checkSI  == 'INACTIVE' || checkSI == 'Inactive' || checkSI == 'Down' || checkSI == 'TA'  || checkSI == 'P&A' || checkSI == 'S/I' ) 
                                        {
                                            $(td).css('background-color', '#F08080')
                                        }
                                    }
                                },
                                
                            },

                            {
                                targets: 3,
                                "createdCell": function (td, cellData, rowData, row, col) {
                                    {
                                        var checkSI = pTable.cell(td,2).data(); 
                                        if ( checkSI == 'Shut-in' || checkSI == 'Shut-In' || checkSI  == 'INACTIVE' || checkSI == 'Inactive' || checkSI == 'Down' || checkSI == 'TA'  || checkSI == 'P&A' || checkSI == 'S/I' ) 
                                        {
                                            $(td).css('font-weight', 'bold')
                                        }
                                    }
                                },

                            }                            
                        ],
                        // "drawCallback": function( settings ) {
                        //     // Notiflix.Loading.remove(5000);
                        //     Notiflix.Block.remove('.tab-content',2000);
                        // }
                        } );
                };
            } );


            $('#searchProduction').keyup(function(e){
                
                // searchTextbox_keyup();
                // document.getElementById("searchDropdown").classList.toggle("show-dropdown");
                // $('#searchDropdown').dropdown('show')
                var input, filter, ul, li, a, i;
                input = document.getElementById("searchProduction");
                filter = input.value.toUpperCase();
                div = document.getElementById("searchDropdown");
                a = div.getElementsByTagName("a");
                for (i = 0; i < a.length; i++) {
                    // if(i > 1){ 
                    //     $('#searchDropdown').dropdown('show')
                    // } else {
                    //     $('#searchDropdown').dropdown('hide')
                    // }
                    txtValue = a[i].textContent || a[i].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        a[i].style.display = "";
                        // $('#searchDropdown').dropdown('update')
                    } else {
                        a[i].style.display = "none";
                        // $('#searchDropdown').dropdown('update')
                    }
                }
                // href = this.href;
                // console.log(href);
                if (e.which == 13) {
                    // return false;
                    href = $(this).href;
                    console.log(href);
                    href = $(document).activeElement.href;
                    console.log(href);
                    window.location = href;
                    // 
                }
                $(this).keypress(function(e) {
                    //         //Enter key
                            if (e.which == 13) {
                                // return false;
                                href = $(this).href;
                                console.log(href);
                                href = $(document).activeElement.href;
                                console.log(href);
                                window.location = href;
                                // 
                            }
                    });
                

               
                lTable.search($(this).val()).draw() ;
                oTable.search($(this).val()).draw() ;
                iTable.search($(this).val()).draw() ;
                sTable.search($(this).val()).draw() ;
            })
            function searchTextbox_keyup() {
                var $this = $(this);
                //In jQuery, I use $this as a reference to the jQuery-wrapped this object
                var $parent = $this.parent('.dropdown');
                //Similar naming convention as $this. this is the parent object of our element, wrapped in jquery
              
                if ($this.val().length > 0 && !$parent.hasClass('open')) {
                  //This if statement says:
                  //"If this value's length is gerater than 0
                  //AND the parent of this object does not have the 'open' class on it
                  //Continue with this code block:
                  $this.siblings('span.toggle-helper').dropdown('toggle');
                  //searches for a sibling-level element that matches the CSS query 'span.toggle-helper', and fires the dropdown toggle method (showing it)
                } else if ($this.val().length == 0) {
                  //If either one of those two requirements in the previous if is false, we end up here, where we only execute this code value's length is equal to 0.
                  $('#searchDropdown').empty();
                };
              
              };
              

        }
        function filterFunction() {
            document.getElementById("searchDropdown").classList.toggle("show");
            var input, filter, ul, li, a, i;
            input = document.getElementById("searchProduction");
            filter = input.value.toUpperCase();
            div = document.getElementById("searchDropdown");
            a = div.getElementsByTagName("a");
            for (i = 0; i < a.length; i++) {
              txtValue = a[i].textContent || a[i].innerText;
              if (txtValue.toUpperCase().indexOf(filter) > -1) {
                a[i].style.display = "";
              } else {
                a[i].style.display = "none";
              }
            }
          }
        $("#state").change(drop_down_list);

        
    } );
    $('#insert_latest_prod').on("submit", function(event){  
        event.preventDefault();  
        if($('#del').val() == "")  
        {  
                alert("Date is required");  
        }  
        else  
        {  
                $.ajax({  
                    url:"./ajax/insert.ntf.1.php",  
                    method:"POST",  
                    data:$('#insert_latest_prod').serialize(),  
                    beforeSend:function(){  
                        $('#insert').val("Inserting");  
                    },  
                    success:function(data){  
                        $('#insert_latest_prod')[0].reset();  
                        $('#add_latest_Modal').modal('hide');
                        lTable.ajax.reload();  
                        
                    }  
                });  
        }  
    }); 
    var checkbox = $('table tbody input[type="checkbox"]');
    $("#selectAll").click(function(){
        if(this.checked){
            checkbox.each(function(){
                this.checked = true;                        
            });
        } else{
            checkbox.each(function(){
                this.checked = false;                        
            });
        } 
    });
    checkbox.click(function(){
        if(!this.checked){
            $("#selectAll").prop("checked", false);
        }
    });
    $("#engShow").click(function(){
        $("#eng").show();
        $("#acct").hide();
        $("#vend").hide();
        $("#field").hide();
    });
    $("#acctShow").click(function(){
        $("#acct").show();
        $("#eng").hide();
        $("#vend").hide();
        $("#field").hide();
    });
    $("#vendShow").click(function(){
        $("#vend").show();
        $("#acct").hide();
        $("#eng").hide();
        $("#field").hide();
    });
    $("#fieldShow").click(function(){
        $("#field").show();
        $("#acct").hide();
        $("#vend").hide();
        $("#eng").hide();
    });
// Insert/Edit/View DDR/DSR
    $('#add').click(function(){  

        $('#pills-eng-tab').removeClass("disabled not-allowed");
        $('#pills-acct-tab').removeClass("active disabled not-allowed");
        $('#pills-vend-tab').removeClass("active disabled not-allowed");
        $('#pills-field-tab').removeClass("active disabled not-allowed");
        
        $('#pills-eng-tab').addClass("active");

        $('#pills-eng').addClass("in show active");
        $('#pills-acct').removeClass("in show active");
        $('#pills-vend').removeClass("in show active");
        $('#pills-field').removeClass("in show active");  
        $('#insert').val("Insert"); 
        $('#insert_form')[0].reset();
        $('#id').val('');
        $('.ddr-a').prop('disabled', false);
        $('.ddr-v').prop('disabled', false);
        $('.ddr-f').prop('disabled', false);
        $('.ddr-e').prop('disabled', false);
        $('#appendSection').removeClass("show");        
        $('#replaceSection').removeClass("show");
    });
    $('#add_dsr').click(function(){
        $('#insert.dsr').val("Insert"); 
        $('#insert_form.dsr')[0].reset();
        $('#id.dsr').val('');
    })
    $('#pills-eng').click(function(){  
        $('.ddr-a').prop('disabled', true);
        $('.ddr-v').prop('disabled', true);
        $('.ddr-f').prop('disabled', true);
        $('#drn.ddr-v').trumbowyg('destroy');
        $('#drn.ddr-f').trumbowyg('destroy');
    });
    $('#pills-acct').click(function(){  
        $('.ddr-e').prop('disabled', true);
        $('.ddr-v').prop('disabled', true);
        $('.ddr-f').prop('disabled', true);
        $('#drn.ddr-e').trumbowyg('destroy');
        $('#drn.ddr-v').trumbowyg('destroy');
        $('#drn.ddr-f').trumbowyg('destroy');
    });
    $('#pills-vend').click(function(){  
        $('.ddr-e').prop('disabled', true);
        $('.ddr-a').prop('disabled', true);
        $('.ddr-f').prop('disabled', true);
        $('#drn.ddr-e').trumbowyg('destroy');
        $('#drn.ddr-f').trumbowyg('destroy');
    });
    $('#pills-field').click(function(){  
        $('.ddr-e').prop('disabled', true);
        $('.ddr-a').prop('disabled', true);
        $('.ddr-v').prop('disabled', true);
        $('#drn.ddr-e').trumbowyg('destroy');
        $('#drn.ddr-v').trumbowyg('destroy');
    });
    $('#dsr-tab').click(function(){  
        $('.ddr-e').prop('disabled', true);
        $('.ddr-a').prop('disabled', true);
        $('.ddr-v').prop('disabled', true);
        $('.ddr-f').prop('disabled', true);
    });

      var filetype = document.getElementById('ft');

    var url = window.location.href;
        if (url.indexOf("prod_data?testing")  !==-1 ){
    $('#insert_form.ddr').on("submit", function(event){  
        event.preventDefault();  
        var formData = new FormData(this);
        
        // var fileInput = document.getElementById('files[]');
        // if(filetype !== "" && $('input[type="file"]').val()) {
        //     alert("File type must be set");
        // } else {
            $.ajax({
                // url: './ajax/insert.t.php',
                url: './api/notes/ddr',
                type: 'POST',
                beforeSend: function(){
                    
                    // if(filetype !== ""){
                    //     console.log("No input for filetype");
                    // }
                    // if(!$('input[type="file"]').val()){
                    //     console.log("Nothing uploaded for file");
                    // }
                },
                xhr: function() {
                    var my_xhr = $.ajaxSettings.xhr();
                    if (my_xhr.upload) {
                        mfl = $('div[class^="MultiFile-label"]');
                        mfl.children('span').append('<div class="progress hidden"><div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div></div>');
                        my_xhr.upload.addEventListener("progress", function(event) {
                            Progress(event.loaded, event.total);
                        });
                    }
                    return my_xhr;
                },
                success: function (data) {
                    // alert("Data Uploaded: "+data);
                    $('#success.alert').addClass('show');
                    
                    setTimeout(function() {  
                    
                    
                    // $('#lastid.ddr-id').html(data.last_id);
                    setTimeout(function() {
                        $('#success.alert').removeClass('show');
                        $('#add_data_Modal').modal('hide');
                        iTable.ajax.reload();  
                        $('#drn.ddr-e').trumbowyg('destroy');
                        $('#drn.ddr-v').trumbowyg('destroy');
                        $('#drn.ddr-a').trumbowyg('destroy');
                        $('#drn.ddr-f').trumbowyg('destroy');
                        $('#insert_form')[0].reset();
                    }, 3000);
                }, 500);
                },
                error: function(xhr, status, message) 
                {
                    // $("#err").html(e).fadeIn();
                    // alert(e);

                    $('#e-details.error-details').text(xhr.status + " " + status + " - " + message);
                    $('#error.alert').addClass('show');

                },        
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            });
            return false;
        // }
        // if($('#MultiFile1_F1').val()) {
        //     e.preventDefault();
        //     $('#progress').show();
        //     $(this).ajaxSubmit({ 
        //         target:   '#targetLayer', 
        //         beforeSubmit: function() {
        //             $(".progress-bar").width('0%');
        //         },
        //         uploadProgress: function (event, position, total, percentComplete){	
        //             $(".progress-bar").width(percentComplete + '%');
        //             $(".progress-bar").html(percentComplete +' %')
        //         },
        //         success:function (){
        //             $('#loader-icon').hide();
        //         },
        //         resetForm: true 
        //     }); 
        //     return false; 
        // }
        
        /*
        if($('#de').val() == "")  
        {  
                alert("Date is required");  
        }  
        else  
        {  
            // $.ajax({
            //     url: './ajax/insert.t.php', // <-- point to server-side PHP script 
            //     dataType: 'text',  // <-- what to expect back from the PHP script, if anything
            //     cache: false,
            //     contentType: false,
            //     processData: false,
            //     data: $('#insert_form'),                         
            //     type: 'post',
            //     success: function(data){
            //         alert("It worked!"); // <-- display response from the PHP script, if any
            //     }
            //     });
            $.ajax({  
                url:"./ajax/insert.t.php",  
                method:"POST",  
                data:$('#insert_form').serialize(),  
                beforeSend:function(){  
                    $('#insert').val("Inserting");  
                },  
                success:function(data){
                    $.ajax({
                        url: './ajax/insert.t.php', // <-- point to server-side PHP script 
                        dataType: 'text',  // <-- what to expect back from the PHP script, if anything
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: $('#insert_form'),                         
                        type: 'post',
                        success: function(data){
                            alert("It worked!"); // <-- display response from the PHP script, if any
                        }
                        });
                    $('#insert_form')[0].reset();  
                    $('#add_data_Modal').modal('hide');
                    //iTable.ajax.reload();  
                    $('#drn.ddr-e').trumbowyg('destroy');
                    $('#drn.ddr-v').trumbowyg('destroy');
                    // $('#drn.ddr-a').trumbowyg('destroy');
                    $('#drn.ddr-f').trumbowyg('destroy');
                    $('#lastid.ddr-id').html(data.last_id);
                },
                error: function(e) 
                {
                    // $("#err").html(e).fadeIn();
                    alert(e);

                }        
            });         
        }  
        */
    });
    } else {
        $('#insert_form.ddr').on("submit", function(event){  
            event.preventDefault();  
            var formData = new FormData(this);
            
            // var fileInput = document.getElementById('files[]');
            // if(filetype !== "" && $('input[type="file"]').val()) {
            //     alert("File type must be set");
            // } else {
                $.ajax({
                    url: './ajax/insert.t.php',
                    // url: './api/notes/ddr',
                    type: 'POST',
                    beforeSend: function(){
                        
                        // if(filetype !== ""){
                        //     console.log("No input for filetype");
                        // }
                        // if(!$('input[type="file"]').val()){
                        //     console.log("Nothing uploaded for file");
                        // }
                    },
                    xhr: function() {
                        var my_xhr = $.ajaxSettings.xhr();
                        if (my_xhr.upload) {
                            mfl = $('div[class^="MultiFile-label"]');
                            mfl.children('span').append('<div class="progress hidden"><div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div></div>');
                            my_xhr.upload.addEventListener("progress", function(event) {
                                Progress(event.loaded, event.total);
                            });
                        }
                        return my_xhr;
                    },
                    success: function (data) {
                        $('#success.alert').addClass('show');
                        
                        setTimeout(function() {  
                        
                        
                        setTimeout(function() {
                            $('#success.alert').removeClass('show');
                            $('#add_data_Modal').modal('hide');
                            iTable.ajax.reload(null, false);
 
                            $('#drn.ddr-e').trumbowyg('destroy');
                            $('#drn.ddr-v').trumbowyg('destroy');
                            $('#drn.ddr-a').trumbowyg('destroy');
                            $('#drn.ddr-f').trumbowyg('destroy');
                            $('#insert_form')[0].reset();
                        }, 3000);
                    }, 500);
                    },
                    error: function(xhr, status, message) 
                    {

    
                        $('#e-details.error-details').text(xhr.status + " " + status + " - " + message);
                        $('#error.alert').addClass('show');
    
                    },        
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                });
                return false;
        });
    }
    function Progress(current, total) {
        var percent = ((current / total) * 100).toFixed(0) + "%";
    
        $("div.progress").removeClass("hidden");
        $("div.progress-bar").width(percent);
        $("div.progress-bar").text(percent);
    
        if (percent == "100%") {
            Finished();
        }
    }
    function Finished() {
        setTimeout(function() {
            $("form#upload input[type='file']").val("");
            $("div.progress-bar").text("Upload Complete");
    
            setTimeout(function() {
                $("form#upload input[type='file']").val("");
                $("div.progress").addClass("hidden");
                $("div.progress-bar").width(0);
                $("div.progress-bar").text("0%");
            }, 3000);
        }, 500);
    }
    function getFileExtension(fname){
        return fname.slice((Math.max(0, fname.lastIndexOf(".")) || Infinity) + 1);
    }
    $( document ).ajaxSuccess(function( event, xhr, settings ) {
        if ( settings.url == "./ajax/insert.t.php" ) {
            console.log("Triggered ajaxSuccess handler. The Ajax response was: " +
            xhr.responseText );
        }
    });  
    $('#insert_form.dsr').on("submit", function(event){  
        event.preventDefault();  
        if($('#de.dsr').val() == "")  
        {  
                alert("Date is required");  
        }  
        else  
        {  
                $.ajax({  
                    url:"./ajax/insert.ntf.php",  
                    method:"POST",  
                    data:$('#insert_form.dsr').serialize(),  
                    beforeSend:function(){  
                        $('#insert.dsr').val("Inserting");  
                    },  
                    success:function(data){  
                        $('#insert_form.dsr')[0].reset();  
                        $('#add_data_dsr_Modal').modal('hide');
                        sTable.ajax.reload();  
                    }  
                });  
        }  
    });
    $('#insert_well_form').on("submit", function(event){
        event.preventDefault();
        
        if($('#api').val() == "")  
        {  
                alert("API No. is required");  
        }  
        else  
        {  
            var api = $('#api').val();
            $.ajax({
                url:"./ajax/insert.well.php",  
                method:"POST",  
                data:$('#insert_well_form').serialize(),  
                beforeSend:function(){  
                    $('#insert-well').val("Inserting");  
                },  
                success:function(data){  
                    $('#insert_well_form')[0].reset();  
                    $('#well_entry_Modal').modal('hide');
                    var url = window.location.pathname;
                    if (url.indexOf("prod_data")  !==-1 )
                    {
                        $.ajax({  
                            url:"./ajax/fetchwells.php",  
                            method:"POST",  
                            data:{api:api},  
                            dataType:"json",  
                            success:function(data){
                                $('#cn.wellinfo').html(data.entity_common_name);  
                                $('#an.wellinfo').html(data.api);  
                                $('#eo.wellinfo').html(data.entity_operator_code);  
                                $('#p.wellinfo').html(data.pumper);  
                                $('#s.wellinfo').html(data.state);  
                                $('#cp.wellinfo').html(data.county_parish);  
                                $('#b.wellinfo').html(data.block);
                                $('#lat.wellinfo').html(data.surface_latitude_wgs84);  
                                $('#long.wellinfo').html(data.surface_longitude_wgs84);
                                $('#ws.wellinfo').html(data.producing_status);
                                $('#pt.wellinfo').html(data.production_type);
                                $('#r.wellinfo').html(data.reservoir);
                                $('#f.wellinfo').html(data.field);
                                $('#md.wellinfo').html(data.measured_depth_td);
                                $('#tvd.wellinfo').html(data.true_vertical_depth);
                                $('#dt.wellinfo').html(data.drill_type);
                                $('#cd.wellinfo').html(data.completion_date);
                                $('#fpd.wellinfo').html(data.first_prod_date);
                                $('#ggr.wellinfo').html(data.gas_gatherer);
                                $('#ogr.wellinfo').html(data.oil_gatherer);
                                $('#up.wellinfo').html(data.upper_perforation);
                                $('#lp.wellinfo').html(data.lower_perforation);
                                $('#gg.wellinfo').html(data.gas_gravity);
                                $('#og.wellinfo').html(data.oil_gravity);
                                $('#sd.wellinfo').html(data.spud_date);
                                $('#lpd.wellinfo').html(data.last_prod_date);
                                $('#l.wellinfo').html(data.landowner);  
                                $('#gc.wellinfo').html(data.gatecombo);  
                                $('#ln.wellinfo').html(data.landowner_notes);
                            }
                        });   
                    }
                    else 
                    {
                        oTable.ajax.reload();
                    }  
                }  
            });  
        }
    });  
    $(document).on('click', '.edit_ddr-e', function(){  
        var id = $(this).attr("id");
        $('#drn.ddr-e').trumbowyg(drn_t);  
        $.ajax({  
                url:"./ajax/fetch.php",  
                method:"POST",  
                data:{id:id},  
                dataType:"json",  
                success:function(data){  
                    $('#deb.ddr').val(data.deb);  
                    $('#t.ddr').val(data.t);  
                    $('#de.ddr').val(data.de);  
                    $('#ts.ddr').val(data.ts);  
                    $('#te.ddr').val(data.te);  
                    $('#id.ddr').val(data.id);  
                    $('#api.ddr').val(data.api);
                    $('#ec.ddr').val(data.ec);  
                    $('#d.ddr-e').val(data.d);  
                    $('#cvn.ddr-e').val(data.cvn);  
                    $('#cin.ddr-e').val(data.cin);  
                    $('#ps.ddr-e').val(data.producing_status);
                    $('#drn.ddr-e').trumbowyg('html', data.drn);
                    $('#edc.ddr-e').val(data.edc);  
                    $('#ecc.ddr-e').val(data.ecc); 
                    $('#insert.ddr-e').val("Update");  
                    $('#add_data_Modal').modal('show');  
                    
                    
                    $('#pills-eng-tab').addClass("active");
                    $('#pills-eng-tab').removeClass("disabled not-allowed");

                    $('#pills-acct-tab').removeClass("active");
                    $('#pills-acct-tab').addClass("disabled not-allowed");

                    $('#pills-vend-tab').removeClass("active");
                    $('#pills-vend-tab').addClass("disabled not-allowed");

                    $('#pills-field-tab').removeClass("active");
                    $('#pills-field-tab').addClass("disabled not-allowed");

                    $('#pills-eng').addClass("in show active");
                    $('#pills-acct').removeClass("in show active");
                    $('#pills-vend').removeClass("in show active");
                    $('#pills-field').removeClass("in show active");
                    $('.ddr-a').prop('disabled', true);
                    $('.ddr-v').prop('disabled', true);
                    $('.ddr-f').prop('disabled', true);
                    $('.ddr-e').prop('disabled', false);
                    $('#appendSection').removeClass("show");        
                    $('#replaceSection').removeClass("show");
                    
                }  
        });  
    });
    $(document).on('click', '.edit_ddr-a', function(){
        $('#ad').datepicker('update', '');  
        var id = $(this).attr("id");
        $.ajax({  
                url:"./ajax/fetch.php",  
                method:"POST",  
                data:{id:id},  
                dataType:"json",  
                success:function(data){  
                    $('#deb.ddr').val(data.deb);  
                    $('#t.ddr').val(data.t);  
                    $('#de.ddr').val(data.de);  
                    $('#ts.ddr').val(data.ts);  
                    $('#te.ddr').val(data.te);  
                    $('#id.ddr').val(data.id);  
                    $('#api.ddr').val(data.api);
                    $('#ec.ddr').val(data.ec);    
                    $('#d.ddr-a').val(data.d);  
                    $('#cvn.ddr-a').val(data.cvn);  
                    $('#cin.ddr-a').val(data.cin);  
                    $('#drn.ddr-a').val(data.drn); 
                    $('#edc.ddr-a').val(data.edc);  
                    $('#ecc.ddr-a').val(data.ecc);  
                    $('#ad').val(data.ad); 

                    $('#insert.ddr-a').val("Update");  
                    $('#add_data_Modal').modal('show');  
                    
                    $('#pills-eng-tab').removeClass("active");
                    $('#pills-eng-tab').addClass("disabled not-allowed");

                    $('#pills-acct-tab').addClass("active");
                    $('#pills-acct-tab').removeClass("disabled not-allowed");

                    $('#pills-vend-tab').removeClass("active");
                    $('#pills-vend-tab').addClass("disabled not-allowed");

                    $('#pills-field-tab').removeClass("active");
                    $('#pills-field-tab').addClass("disabled not-allowed");

                    $('#pills-eng').removeClass("in show active");
                    $('#pills-acct').addClass("in show active");
                    $('#pills-vend').removeClass("in show active");
                    $('#pills-field').removeClass("in show active");
                    $('.ddr-a').prop('disabled', false);
                    $('.ddr-v').prop('disabled', true);
                    $('.ddr-f').prop('disabled', true);
                    $('.ddr-e').prop('disabled', true);
                }  
        });  
    });    
    $(document).on('click', '.edit_ddr-v', function(){  
        var id = $(this).attr("id");
        $('#drn.ddr-v').trumbowyg(drn_t);  
        $.ajax({  
                url:"./ajax/fetch.php",  
                method:"POST",  
                data:{id:id},  
                dataType:"json",  
                success:function(data){  
                    $('#deb.ddr').val(data.deb);  
                    $('#t.ddr').val(data.t);  
                    $('#de.ddr').val(data.de);  
                    $('#ts.ddr').val(data.ts);  
                    $('#te.ddr').val(data.te);  
                    $('#id.ddr').val(data.id);  
                    $('#api.ddr').val(data.api);
                    $('#ec.ddr').val(data.ec);    
                    $('#d.ddr-v').val(data.d);  
                    $('#cvn.ddr-v').val(data.cvn);  
                    $('#cin.ddr-v').val(data.cin);  
                    $('#drn.ddr-v').trumbowyg('html', data.drn); 
                    $('#edc.ddr-v').val(data.edc);  
                    $('#ecc.ddr-v').val(data.ecc); 
                    $('#ac.ddr-v').val(data.ac);
                    $('#dc.ddr-v').val(data.dc);
                    $('#at.ddr-v').val(data.at); 
                    $('#et.ddr-v').val(data.et); 
                    $('#dt.ddr-v').val(data.dt); 
                    $('#tt.ddr-v').val(data.tt); 

                    $('#insert.ddr-v').val("Update");  
                    $('#add_data_Modal').modal('show');  

                    $('#pills-eng-tab').removeClass("active");
                    $('#pills-eng-tab').addClass("disabled not-allowed");

                    $('#pills-acct-tab').removeClass("active");
                    $('#pills-acct-tab').addClass("disabled not-allowed");

                    $('#pills-vend-tab').addClass("active");
                    $('#pills-vend-tab').removeClass("disabled not-allowed");

                    $('#pills-field-tab').removeClass("active");
                    $('#pills-field-tab').addClass("disabled not-allowed");

                    $('#pills-eng').removeClass("in show active");
                    $('#pills-acct').removeClass("in show active");
                    $('#pills-vend').addClass("in show active");
                    $('#pills-field').removeClass("in show active");
                    $('.ddr-a').prop('disabled', true);
                    $('.ddr-e').prop('disabled', true);
                    $('.ddr-f').prop('disabled', true);
                    $('.ddr-v').prop('disabled', false);
                }  
        });  
    });    
    $(document).on('click', '.edit_ddr-f', function(){  
        var id = $(this).attr("id");  
        $('#drn.ddr-f').trumbowyg(drn_t);  
        $.ajax({  
                url:"./ajax/fetch.php",  
                method:"POST",  
                data:{id:id},  
                dataType:"json",  
                success:function(data){  
                    $('#deb.ddr').val(data.deb);  
                    $('#t.ddr').val(data.t);  
                    $('#de.ddr').val(data.de);  
                    $('#ts.ddr').val(data.ts);  
                    $('#te.ddr').val(data.te);  
                    $('#id.ddr').val(data.id);  
                    $('#api.ddr').val(data.api);
                    $('#ec.ddr').val(data.ec);    
                    $('#d.ddr-f').val(data.d);  
                    $('#cvn.ddr-f').val(data.cvn);  
                    $('#cin.ddr-f').val(data.cin);  
                    $('#drn.ddr-f').trumbowyg('html', data.drn); 
                    $('#edc.ddr-f').val(data.edc);  
                    $('#ecc.ddr-f').val(data.ecc);  

                    $('#insert.ddr-f').val("Update");  
                    
                    $('#add_data_Modal').modal('show');  
                    
                    $('#pills-eng-tab').removeClass("active");
                    $('#pills-eng-tab').addClass("disabled not-allowed");

                    $('#pills-acct-tab').removeClass("active");
                    $('#pills-acct-tab').addClass("disabled not-allowed");

                    $('#pills-vend-tab').removeClass("active");
                    $('#pills-vend-tab').addClass("disabled not-allowed");

                    $('#pills-field-tab').addClass("active");
                    $('#pills-field-tab').removeClass("disabled not-allowed");

                    $('#pills-eng').removeClass("in show active");
                    $('#pills-acct').removeClass("in show active");
                    $('#pills-vend').removeClass("in show active");
                    $('#pills-field').addClass("in show active");
                    $('.ddr-a').prop('disabled', true);
                    $('.ddr-v').prop('disabled', true);
                    $('.ddr-e').prop('disabled', true);
                    $('.ddr-f').prop('disabled', false);
                }  
        });  
    });    
    $(document).on('click', '.edit_dsr', function(){  
        var id = $(this).attr("id");  
        $('#drn.dsr').trumbowyg(drn_t); 
        $.ajax({  
                url:"./ajax/fetch.php",  
                method:"POST",  
                data:{id:id},  
                dataType:"json",  
                success:function(data){  
                    $('#deb.dsr').val(data.deb);  
                    $('#t.dsr').val(data.t);  
                    $('#de.dsr').val(data.de);  
                    $('#ts.dsr').val(data.ts);  
                    $('#te.dsr').val(data.te);  
                    $('#id.dsr').val(data.id);  
                    $('#api.dsr').val(data.api);
                    $('#ec.ddr').val(data.ec);    
                    $('#d.dsr').val(data.d);  
                    $('#cvn.dsr').val(data.cvn);  
                    $('#cin.dsr').val(data.cin);  
                    $('#drn.dsr').val(data.drn); 
                    $('#edc.dsr').val(data.edc);  
                    $('#ecc.dsr').val(data.ecc);  
                    $('#drn.dsr').trumbowyg('html', data.drn); 
                    $('#insert.dsr').val("Update");  
                    $('#add_data_dsr_Modal').modal('show');  
                    
                    
                    $('#pills-eng-tab').addClass("active");
                    $('#pills-eng-tab').removeClass("disabled not-allowed");

                    $('#pills-acct-tab').removeClass("active");
                    $('#pills-acct-tab').addClass("disabled not-allowed");

                    $('#pills-vend-tab').removeClass("active");
                    $('#pills-vend-tab').addClass("disabled not-allowed");

                    $('#pills-field-tab').removeClass("active");
                    $('#pills-field-tab').addClass("disabled not-allowed");

                    $('#pills-eng').addClass("in show active");
                    $('#pills-acct').removeClass("in show active");
                    $('#pills-vend').removeClass("in show active");
                    $('#pills-field').removeClass("in show active");
                    $('.ddr-a').prop('disabled', true);
                    $('.ddr-v').prop('disabled', true);
                    $('.ddr-f').prop('disabled', true);
                    $('.ddr-e').prop('disabled', true);
                    
                }  
        });  
    });
    var counter = 0;
    var editcounter = 0;
    var vitalcounter = 0;
    $(document).on('click', '.delete_data', function(){  
        var id = $(this).attr("id");  
        if(id != '')  
        {  
                $.ajax({  
                    url:"./ajax/delete.note.php",  
                    method:"POST",  
                    data:{id:id},  
                    success:function(data){  
                        $('#dataModal').modal('hide'); 
                        feather.replace();
                        $('#dataModal').on('hidden.bs.modal', function (e) {
                            iTable.ajax.reload();
                        })
                        
                    }  
                });  
        }            
    });
    $(document).on('click', '.edit-well-info', function(){  
        var api = $(this).attr("id");  
        $.ajax({  
                url:"./ajax/fetchwells.php",  
                method:"POST",  
                data:{api:api},  
                dataType:"json",  
                success:function(data){  
                    $('#entity-operator').val(data.entity_operator);  
                    $('#entity-operator-code').val(data.entity_operator_code);  
                    $('#well-lease').val(data.well_lease);  
                    $('#well-no').val(data.well_no);  
                    $('#entity-common-name').val(data.entity_common_name);  
                    $('#entity-type').val(data.entity_type);  
                    $('#reservoir').val(data.reservoir);  
                    $('#block').val(data.block);      
                    $('#efield').val(data.field);  
                    $('#production-type').val(data.production_type);  
                    $('#producing-status').val(data.producing_status);  
                    $('#drill-type').val(data.drill_type); 
                    $('#first-prod-date').val(data.first_prod_date);  
                    $('#last-prod-date').val(data.last_prod_date);
                    $('#upper-perforation').val(data.upper_perforation);  
                    $('#lower-perforation').val(data.lower_perforation);  
                    $('#gas-gravity').val(data.gas_gravity);  
                    $('#oil-gravity').val(data.oil_gravity);  
                    $('#completion-date').val(data.completion_date);  
                    $('#well-count').val(data.well_count); 
                    $('#max-active-wells').val(data.max_active_wells);  
                    $('#months-produced').val(data.months_produced);
                    $('#gas-gatherer').val(data.gas_gatherer);  
                    $('#oil-gatherer').val(data.oil_gatherer); 
                    $('#spud-date').val(data.spud_date);  
                    $('#measured-depth-td').val(data.measured_depth_td);  
                    $('#true-vertical-depth').val(data.true_vertical_depth);
                    $('#field').val(data.field);  
                    $('#state').val(data.state);  
                    $('#block').val(data.block);  
                    $('#surface-latitude-wgs84').val(data.surface_latitude_wgs84);  
                    $('#surface-longitude-wgs84').val(data.surface_longitude_wgs84);  
                    $('#notes').val(data.notes); 
                    $('#pumper').val(data.pumper);  
                    $('#report-frequency').val(data.report_frequency);
                    $('#show-data').val(data.show);  
                    $('#landowner').val(data.landowner);
                    $('#gatecombo').val(data.gatecombo);
                    $('textarea#landowner_notes').val(data.landowner_notes);
                    
                    $('#insert-well').val("Update");  
                    $('#well_entry_Modal').modal('show');  
                    $('#well_entry_Modal').on('shown.bs.modal', drop_down_list(data.county_parish));
                    
                    
                    
                }  
        });  
    });
    $(document).on('click', '#add.fixed-action-btn', function(){
        var now = moment();
        var curDate = now.format('YYYY-MM-DD');
        var curTime = now.format('HH:mm:ss');
        $('#de').val(curDate);
        $('#ts').val(curTime);
        $('#te').val(curTime);
        $('#dee').datepicker('update', curDate);
        
        $('#drn.ddr-e').trumbowyg('destroy');
        $('#drn.ddr-v').trumbowyg('destroy');
        $('#drn.ddr-f').trumbowyg('destroy');
        
        $('#drn.ddr-e').trumbowyg(drn_t);
        $('#drn.ddr-e').trumbowyg(drn_t);
        $('#drn.ddr-v').trumbowyg(drn_t);
        $('#drn.ddr-f').trumbowyg(drn_t);
        $('#de.dsr').val(curDate);
        $('#dee.dsr').datepicker('update', curDate);
    })
    $(document).on('click', '#add_dsr', function(){
        var now = moment();
        var curDate = now.format('YYYY-MM-DD');
        $('#de.dsr').val(curDate);
        $('#dee.dsr').datepicker('update', curDate);
        $('#drn.dsr').trumbowyg('destroy');
        $('#drn.dsr').trumbowyg(drn_t);
    })
    $(document).on('click', '#well_entry_Modal', function(){
        var now = moment();
        var curDate = now.format('YYYY-MM-DD');
        $('#spud-date').datepicker({defaultViewDate: today, format: "yyyy-mm-dd"});
        $('#completion-date').datepicker({defaultViewDate: today, format: "yyyy-mm-dd"});
        $('#first-prod-date').datepicker({defaultViewDate: today, format: "yyyy-mm-dd"});
        $('#last-prod-date').datepicker({defaultViewDate: today, format: "yyyy-mm-dd"});

    })
    function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
        }
        return val;
    }
    function formatMoney(number, decPlaces, decSep, thouSep) {
        decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
        decSep = typeof decSep === "undefined" ? "." : decSep;
        thouSep = typeof thouSep === "undefined" ? "," : thouSep;
        var sign = number < 0 ? "-" : "";
        var i = String(parseInt(number = Math.abs(Number(number) || 0).toFixed(decPlaces)));
        var j = (j = i.length) > 3 ? j % 3 : 0;
        
        return sign +
            (j ? i.substr(0, j) + thouSep : "") +
            i.substr(j).replace(/(\decSep{3})(?=\decSep)/g, "$1" + thouSep) +
            (decPlaces ? decSep + Math.abs(number - i).toFixed(decPlaces).slice(2) : "");
        }
    
    $('#drn-e-none').click(function(){  
    

        $('#appendSection').removeClass("show");        
        $('#replaceSection').removeClass("show");
    });

    $('#drn-e-add').click(function(){  
        

        $('#replaceSection').removeClass("show");        
    });
    $('#drn-e-replace').click(function(){  
        

        $('#appendSection').removeClass("show");        
    });
    function drop_down_list(c = "")
    {
        var state = $('#state').val();
        var cp = document.querySelector("#county_parish");
        if(state == 'AK' || state == 'DC') // Alaska and District Columbia have no counties
        {
        $('#county_drop_down').hide();
        $('#no_county_drop_down').show();
        }
        else
        {
        $('#loading_county_drop_down').show(); // Show the Loading...
        
        $('#county_drop_down').hide(); // Hide the drop down
        $('#no_county_drop_down').hide(); // Hide the "no counties" message (if it's the case)

        $.getScript("assets/js/states/"+ state.toLowerCase() +".js", function(){

        populate(cp);

        $('#loading_county_drop_down').hide(); // Hide the Loading...
        $('#county_drop_down').show(); // Show the drop down
        $('#county_parish').val(c);
        });
    }
    }
    
    
    /*  The below code allows for me to remove a full table (the daily average table) and place the values in the first table. 
    *   This code allows for the user to toggle between data on a click, so if they *want* to see the daily average, it will allow them to.
    *   However, if they want to see the monthly value again, they can click again (thus, a toggle).
    *   -- CMM, 03.09.22
    */
    $(document).on('click', '.dailymonthlytoggle', function(){  
        $('.daily', this).toggle();
        $('.monthly', this).toggle();
        // TODO: an alert (a small one), needs to fire saying if the daily is showing or if the monthly is showing.
        if($('.daily', this).css('display') == 'none'){
            Notiflix.Notify.info('Showing monthly production');
        }
        else if ($('.monthly', this).css('display') == 'none'){
            Notiflix.Notify.info('Showing daily production');
        }
    })
    
} );
        
