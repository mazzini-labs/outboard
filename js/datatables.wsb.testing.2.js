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
    var editor;
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
    var editor;
    var drn = {
        selector: '#drn1',
        skin: "bs",
        // skin: 'oxide-dark',
        content_css: "//vprsrv.org/js/tinymce/skins/ui/bs",
        menubar: false,
        // inline: true,
        plugins: [
            'lists',
            'quickbars',
            'help',
            'autoresize'
        ],
        toolbar: true,
        quickbars_insert_toolbar: 'codesample',
        quickbars_selection_toolbar: "bold italic underline strikethrough forecolor backcolor formatpainter | alignleft aligncenter alignright alignjustify | outdent indent removeformat | code | checklist | casechange",
        // numlist bullist 
        contextmenu: 'copy pastetext | undo redo | help',
        powerpaste_word_import: 'clean',
        powerpaste_html_import: 'clean',
    };
    editor = tinymce.init(drn);
    // editor_remove = tinymce.remove();
    $(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
        e.stopImmediatePropagation();
    }
    });
    var drn_t = {
        btns: [
            ['viewHTML'],
            ['undo', 'redo'], // Only supported in Blink browsers
            ['formatting'],
            ['strong', 'em', 'del'],
            ['superscript', 'subscript'],
            ['foreColor', 'backColor'],
            // ['link'],
            //['insertImage'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            //['unorderedList', 'orderedList'],
            //['horizontalRule'],
            ['removeformat'],
            ['fullscreen']
        ],
        removeformatPasted: true
    };
            
    $(document).ready(function() {
        var url = window.location.pathname;
        if (url.indexOf("prod_data")  !==-1 )
        {
            // $('a#fab.btn-floating.btn-lg.btn-primary').css("padding-top","inherit");
            // $('a#fab.btn-floating.btn-lg.btn-success').addClass("");
            console.log("prod_data conditional success " + url);
            $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
                $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
                console.log('click: '+click+' clickddr: '+clickddr+' clickt1: '+clickt1+' clickt2: '+clickt2+' clickt3: '+clickt3+' clickt4: '+clickt4);
            } );
    
            if (click < 1){
                click++;
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
                    scrollY: 300,
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
                    
                        
                } );
            };
        
            $('#ddr-tab').on('shown.bs.tab', function (e) {
                // .click(function(){
                if(clickddr < 1){
                    clickddr++;
                
                    iTable = $('#ddrTable').on('init.dt', function () {
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
                        "ajax": {
                            "url" : "ajax/prodnotes.ajax.php",
                            "data": 
                            {
                                "api": api,
                            }
                        }, 
                        "sDom": 't',
                        //"order": [[0, 'desc'], [1, 'desc']],
                        "order": [[1, 'desc'], [2, 'desc']],
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
                                "data": null, render: function ( data, type, row ) 
                                {
                                    // "<i data-feather='edit-2' style='color: light-blue; height: 1.5em!important; width: 1.5em!important;'></i> Out to Lunch</a></span></div></div>"
                                    // <img class="img-fluid" src="image/edit-2.svg" border=0>
                                    // return '<div class="row"><div class="col"><span class=\"r-tooltip\" data-tippy-content=\"Edit\" tabindex=\"0\"><a class="btn-sm btn-light shadow-lg edit_ddr-'+data.d+'" style="color:blue;" id="'+data.id+'" href="#'+data.id+'"><i data-feather="edit-2" style="color: blue; height: 1.5em!important; width: 1.5em!important;"></i></a></span>&ensp;<a style="color: gray; font-size:9;" id="'+data.id+'"></a><span class=\"r-tooltip\" data-tippy-content=\"View Entry\" tabindex=\"0\"><a class="btn-sm btn-secondary view_data" href="#'+data.id+'" id="'+data.id+'"><i data-feather="eye" style="color: light-blue; height: 1.5em!important; width: 1.5em!important;"></i></a></span><span class=\"r-tooltip\" data-tippy-content=\"Print Entry\" tabindex=\"0\"><a class="btn-sm btn-secondary view_data" href="#'+data.id+'" target="_blank" id="'+data.id+'"><i data-feather="print" style="color: light-blue; height: 1.5em!important; width: 1.5em!important;"></i></a></span></div></div>';
                                    
                                    var buttons = '<div class="row" style="padding: 0 0 0 0!important; margin-left:0px!important; margin-right:0px!important;">';
                                    buttons += '<div class="col" style="padding: 0 0 .5rem 0!important;">';
                                    // Edit Button HTML
                                    buttons += '<span class=\"r-tooltip\" data-tippy-content=\"Edit\" tabindex=\"0\">';
                                    buttons += '<a class="btn-sm btn-light shadow-lg edit_ddr-'+data.d+'" style="color:blue;" id="'+data.id+'" href="#'+data.id+'">';
                                    buttons += '<i data-feather="edit-2" style="color: blue; height: 1.5em!important; width: 1.5em!important;"></i></a></span>&ensp;';
                                    
                                    // buttons += '<a style="color: gray; font-size:9;" id="'+data.id+'"></a>';
                                    buttons += '</div>';
                                    buttons += '<div class="col" style="padding: 0 0 .5rem 0!important;>';

                                    // View Button HTML
                                    buttons += '<span class=\"r-tooltip\" data-tippy-content=\"View Entry\" tabindex=\"0\">';
                                    buttons += '<a class="btn-sm btn-secondary view_data" href="#'+data.id+'" id="'+data.id+'">';
                                    buttons += '<i data-feather="eye" style="color: light-blue; height: 1.5em!important; width: 1.5em!important;"></i></a></span>&ensp;';
                                    
                                    buttons += '</div></div>';
                                    buttons += '<div class="row" style="padding: 0 0 0 0!important; margin-left:0px!important; margin-right:0px!important;">';
                                    buttons += '<div class="col" style="padding: 0 0 0 0!important;">';
                                    
                                    buttons += '<span class=\"r-tooltip\" data-tippy-content=\"Print Entry\" tabindex=\"0\">';
                                    buttons += '<a class="btn-sm btn-info" href="ajax/printEntry.php?id='+data.id+'" target="_blank" id="'+data.id+'">';
                                    buttons += '<i data-feather="printer" style="color: light-blue; height: 1.5em!important; width: 1.5em!important;"></i></a></span>';
                                    buttons += '</div>';
                                    if (data.sd !== null){
                                        
                                        buttons += '<div class="col" style="padding: 0 0 0 0!important;">';
                                        buttons += '<span class=\"r-tooltip\" data-tippy-content=\"There are files attached to this entry.\" tabindex=\"0\">';
                                        // buttons += '<a class="btn-sm btn-info" href="ajax/printEntry.php?id='+data.id+'" target="_blank" id="'+data.id+'">';
                                        buttons += '<i data-feather="file" style="color: indigo; height: 1.5em!important; width: 1.5em!important;"></i></a></span>';
                                        buttons += '</div>';
                                    }
                                    buttons += '</div>';

                                    return buttons;
                                    // return '<button name="edit" value="Edit" id="'+data.id+'" class="btn btn-info btn-sm edit_ddr-'+data.d+'" data-toggle="tooltip" title="Edit" /><i data-feather="edit-2" style="color: light-blue; height: 1.5em!important; width: 1.5em!important;"></i></button><button data-toggle="tooltip" title="View" name="view" value="view" id="'+data.id+'" class="btn btn-info btn-sm view_data" /><img class="img-fluid" src="image/eye.svg" border=0></button>'; target="_blank"
                                    //return '<input type="button" name="edit" value="Edit" id="'+data.id+'" class="btn btn-info btn-sm edit_ddr-'+data.d+'" /><input type="button" name="view" value="view" id="'+data.id+'" class="btn btn-info btn-sm view_data" />';
                                },
                                "defaultContent": "",
                            },
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
                            
                        ],
                        "columnDefs": [
                            
                            { width: "5%", "targets": [0, 1, 5, 6, 7] },
                            { width: "10%", "targets": [2, 3] },
                            { width: "30%", "targets": 4 },
                            // { type: "time-ui", "targets":  1  },
                            // { className: "text-wrap", "targets":  [3, 4, 5]  },
                            { className: "text-wrap", "targets":  [0, 3, 4, 5]  },
    
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
                                    $('td').eq(1).find('td').addClass('engineering');
                                    $('td:eq(2)', row).addClass('engineering-date');
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
            
    
                    } );
                };
            });
            $('#dsr-tab').on('shown.bs.tab', function (e) {
                //.click(function(){
                if(clickdsr < 1){
                    clickdsr++;
                
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
                        scrollY: 500,
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
                                    // button += '<img src=image/edit-2.svg border=0></button>';
                                    // button += '<button data-toggle="tooltip" title="View" name="view" value="view" id="'+data.id+'" class="btn btn-info btn-sm view_data" />';
                                    // button += '<img src=image/eye.svg border=0></button>';
    
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
                        } 
    
                    } );
                };
            });
            $('#t1-tab').on('shown.bs.tab', function (e) {
            // .click(function(){
                if(clickt1 < 1){
                    clickt1++;
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
                        scrollY: 600,
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
                        }
    
                    } );
                };
                
            });
            $('#vitals-tab').on('shown.bs.tab', function (e) {
            // .click(function(){
                if(clickt6 < 1){
                    clickt6++;
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
    
                    } );
                };
            });
            $('#t2-tab').on('shown.bs.tab', function (e) {
                // .click(function(){
                if(clickt2 < 1){
                    clickt2++;
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
                        scrollY: 600,
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
                        }
                    } );
                };
            });
            $('#t3-tab').on('shown.bs.tab', function (e) {
            // .click(function(){
                if(clickt3 < 1){
                    clickt3++;
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
                        scrollY: 600,
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
                        }
                    } );
                };
            });
            $('#t4-tab').on('shown.bs.tab', function (e) {
                // .click(function(){
                if(clickt4 < 1){
                    clickt4++;
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
                        ]
                    } );
                };
            });
       
        
            $('#searchProduction').keyup(function(){
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
            
                lTable = $('#latestTable').DataTable( {
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
        
            $('#monthly-tab').click(function(){
                if(click1 < 1){
                    click1++;
                
                    oTable = $('#productionTable').DataTable( {
                        "ajax": "./ajax/wsb.ajax.php",
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
                                "data": "gas_sold", // Gas (mcf)
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
                            { className: "text-wrap", "targets":  [ 12, 13 ]  },
                            { width: "1%", "targets": 1 },
                            { width: "3%", "targets": [4, 6] },
                            { width: "4%", "targets": [5, 7, 9, 14] },
                            { width: "5%", "targets": [8, 10, 11] },
                            { width: "6%", "targets": 2 },
                            { width: "7%", "targets": 12 },
                            { width: "8%", "targets": [3] },
                            { width: "17%", "targets": 0 },
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
            });
            $('#daily-tab').click(function(){
                if(click2 < 1){
                    click2++;
                    iTable = $('#productionTable1').DataTable( {
                            "ajax": "./ajax/wsb.ajax.php",
                            "sDom": 't',
                            "order": [],
                            "keys": true,
                            deferRender: true,
                            scrollY: 800,
                            scroller: true,
                            "searching": true,
                            "autoWidth": false, 
                            "columns": [
                                {
                                "data": null, render: function ( data, type, row ) {
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
                                    "data": "producing_status", // Production Status
                                    "defaultContent": "",
                                    },
                                {
                                    "data": "production_type", // Production Type
                                    "defaultContent": "",
                                },
                                {
                                    "data": "last_prod_date", // Last Active
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
                                // Gas (mcf)
                                "data": "gas_sold",
                                data: null,
                                render: function ( data, type, row ) {
                                    var check = data.gas_sold / data.days_on;

                                    if(check == check)
                                    {
                                        return ( data.gas_sold / data.days_on ).toFixed(2)+' <sup>mcf</sup>/<sub>day</sub>';
                                    }
                                    else
                                    {
                                        return data.gas_sold+' <sup>mcf</sup>/<sub>day</sub>';
                                    }
                                },
                                },
                                {
                                "data": "oil_prod", // Oil (bbl)
                                data: null,
                                render: function ( data, type, row ) {
                                    var check = data.oil_prod / data.days_on;

                                    if(check == check)
                                    {
                                        return ( data.oil_prod / data.days_on ).toFixed(2)+' <sup>bbl</sup><small>/</small><sub>day</sub>';
                                        // return ( data.oil_prod / data.days_on ).toFixed(2)+' <table><tr style="background-color: rgba(0,0,0,0)!important;"><td><small>test</small></td></tr><tr><td style="border-top: 1px solid #9ba0a5;"><small>day</small></td></tr></table>';
                                    }
                                    else
                                    {
                                        return data.oil_prod+' <sup>bbl</sup>/<sub>day</sub>';
                                    }
                                }},
                                {
                                "data": "water_prod", // Water (bbl)
                                "defaultContent": "",
                                data: null,
                                render: function ( data, type, row ) {
                                    var check = data.water_prod / data.days_on;

                                    if(check == check)
                                    {
                                        return ( data.water_prod / data.days_on ).toFixed(2)+' <sup>bb;</sup>/<sub>day</sub>';
                                    }
                                    else
                                    {
                                        return data.water_prod+' <sup>bbl</sup>/<sub>day</sub>';
                                    }
                                }},
                                {
                                "data": "gas_line_loss", // Gas Line Loss (mcf)
                                "defaultContent": "",
                                data: null,
                                render: function ( data, type, row ) {
                                    var check = data.gas_line_loss / data.days_on;

                                    if(check == check)
                                    {
                                        return ( data.gas_line_loss / data.days_on ).toFixed(2)+' <sup>mcf</sup>/<sub>day</sub>';
                                    }
                                    else
                                    {
                                        return data.gas_line_loss+' <sup>mcf</sup>/<sub>day</sub>';
                                    }
                                }},
                                {
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
                            { className: "text-wrap", "targets":  [8, 9, 10, 11, 12, 13]  },
                            { width: "1%", "targets": 1 },
                            { width: "3%", "targets": [4, 6] },
                            { width: "4%", "targets": [5, 7, 9, 14] },
                            { width: "5%", "targets": [8, 10, 11] },
                            { width: "6%", "targets": 2 },
                            { width: "7%", "targets": 12 },
                            { width: "8%", "targets": [3] },
                            { width: "17%", "targets": 0 },
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
                                targets: 5,
                                "createdCell": function (td, cellData, rowData, row, col) {
                                    {
                                        var checkSI = iTable.cell(td,5).data(); 
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
                                        var checkSI = iTable.cell(td,5).data(); 
                                        if ( checkSI == 'Shut-in' || checkSI == 'Shut-In' || checkSI  == 'INACTIVE' || checkSI == 'Inactive' || checkSI == 'Down' || checkSI == 'TA'  || checkSI == 'P&A' || checkSI == 'S/I' ) 
                                        {
                                            $(td).css('font-weight', 'bold')
                                        }
                                    }
                                },

                            }                            
                        ]
                        } );
                };
            } );
            $('#shutin-tab').click(function(){
                if(click3 < 1){
                    click3++;
                    sTable = $('#shutinTable').DataTable( {
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
                        ]
                                
                        } );
            }
            } );
                
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
                        ]
                        } );
                };
            } );


            $('#searchProduction').keyup(function(){
                lTable.search($(this).val()).draw() ;
                oTable.search($(this).val()).draw() ;
                iTable.search($(this).val()).draw() ;
                sTable.search($(this).val()).draw() ;
            })
            //$('#productionTable_filter').DataTable.search();
            $("#searchProduction").keypress(function(e) {
                    //Enter key
                    if (e.which == 13) {
                        return false;
                    }
            });
        }
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
                        // lTable.reload();
                        
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
        
        // editor_remove;
        // editor;
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
    $('#insert_form.ddr').on("submit", function(event){  
        event.preventDefault();  
        var formData = new FormData(this);
        $.ajax({
            url: './ajax/insert.t.php',
            type: 'POST',
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
                $('#insert_form')[0].reset();
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
        return false;
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
                // $("div#alert").hide();
            }, 3000);
        }, 500);
    }
    $( document ).ajaxSuccess(function( event, xhr, settings ) {
        if ( settings.url == "./ajax/insert.t.php" ) {
        //   $( ".log" ).text( "Triggered ajaxSuccess handler. The Ajax response was: " +
        //     xhr.responseText );
            console.log("Triggered ajaxSuccess handler. The Ajax response was: " +
            xhr.responseText );

            // $.ajax({  
            //     url:"./ajax/file_upload.php",  
            //     method:"POST",
            //     // data:  new FormData(this),
            //     data:$('#insert_form').serialize(),
            //     contentType: false,
            //     cache: false,
            //     processData:false,
            //     success: function(data)
            //     {
            //         console.log("File upload ajax worked!")
            //     }
            // });
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
                        //$('#dsr_table').html(data);  
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
                    //$('#dsr_table').html(data);
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
                    // $('#drn.ddr-e').val(data.drn);
                    $('#ps.ddr-e').val(data.producing_status);
                    $('#drn.ddr-e').trumbowyg('html', data.drn);
                    // quill.insertText(data.drn);
                    // $('#drn_ifr.ddr-e').val(data.drn);
                    // editor.insertContent(data.drn); 
                    // tinymce.get('drn').setContent(data.drn);
                    // CKEDITOR.editor.setData(data.drn);
                    // CKEDITOR.editor.insertText(data.drn);
                    // CKEDITOR.editor.insertHTML(data.drn);
                    $('#edc.ddr-e').val(data.edc);  
                    $('#ecc.ddr-e').val(data.ecc); 
                    // console.log(data.deb);  
                    // console.log(data.t);  
                    // console.log(data.de);  
                    // console.log(data.ts);  
                    // console.log(data.te);  
                    // console.log(data.id);  
                    // console.log(data.api);  
                    // console.log(data.d);  
                    // console.log(data.cvn);  
                    // console.log(data.cin);  
                    // console.log(data.drn); 
                    // console.log(data.edc);  
                    // console.log(data.ecc);
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
        // $('#drn.ddr-a').trumbowyg(drn_t);  
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
                    // $('#drn.ddr-a').trumbowyg('html', data.drn);
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
                    // $('#drn.ddr-v').val(data.drn);
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
                    // $('#drn.ddr-f').val(data.drn);
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
    // const lightbox = new FsLightbox();
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
                        // lightbox.refreshFsLightbox();
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
                                                // <img class="img-fluid" src="image/edit-2.svg" border=0>
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
                                                // return '<button name="edit" value="Edit" id="'+data.id+'" class="btn btn-info btn-sm edit_ddr-'+data.d+'" data-toggle="tooltip" title="Edit" /><i data-feather="edit-2" style="color: light-blue; height: 1.5em!important; width: 1.5em!important;"></i></button><button data-toggle="tooltip" title="View" name="view" value="view" id="'+data.id+'" class="btn btn-info btn-sm view_data" /><img class="img-fluid" src="image/eye.svg" border=0></button>'; target="_blank"
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
                        $('#excel').click(function(){
                            // var grid = canvasDatagrid({
                            //     parentNode: document.getElementById('grid'),
                            //     data: []
                            // });
                            // grid.style.height = '100%';
                            // grid.style.width = '100%';
                            // var X = new DropSheet();
                            
                            $('#file_Modal').modal('show');
                            // var url = "http://oss.sheetjs.com/test_files/formula_stress_test.xlsx";
                            var url = $(this).attr("data-path");
                            // var filename = $(this).attr("data-file");
                            /* set up async GET request */
                            var request = new XMLHttpRequest();
                            request.open("GET", url, true);
                            
                            request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
                            // request.responseType = 'blob';
                            request.responseType = "arraybuffer";
                            request.onload = function(e) {
                                if (this.status === 200) {
                                    var _target = document.getElementById('drop');
                                    var _file = document.getElementById('file');
                                    var _grid = document.getElementById('grid');
                                    /** Spinner **/
                                    var spinner;

                                    var _workstart = function() { spinner = new Spinner().spin(_target); }
                                    var _workend = function() { spinner.stop(); }

                                    /** Alerts **/
                                    var _badfile = function() {
                                    alertify.alert('This file does not appear to be a valid Excel file.  If we made a mistake, please send this file to <a href="mailto:dev@sheetjs.com?subject=I+broke+your+stuff">dev@sheetjs.com</a> so we can take a look.', function(){});
                                    };

                                    var _pending = function() {
                                    alertify.alert('Please wait until the current file is processed.', function(){});
                                    };

                                    var _large = function(len, cb) {
                                    alertify.confirm("This file is " + len + " bytes and may take a few moments.  Your browser may lock up during this process.  Shall we play?", cb);
                                    };

                                    var _failed = function(e) {
                                    console.log(e, e.stack);
                                    alertify.alert('We unfortunately dropped the ball here.  Please test the file using the <a href="/js-xlsx/">raw parser</a>.  If there are issues with the file processor, please send this file to <a href="mailto:dev@sheetjs.com?subject=I+broke+your+stuff">dev@sheetjs.com</a> so we can make things right.', function(){});
                                    };
                                    var _onsheet = function(json, sheetnames, select_sheet_cb) {
                                        document.getElementById('footnote').style.display = "none";
                                    
                                        make_buttons(sheetnames, select_sheet_cb);
                                    
                                        /* show grid */
                                        _grid.style.display = "block";
                                        _resize();
                                    
                                        /* set up table headers */
                                        var L = 0;
                                        json.forEach(function(r) { if(L < r.length) L = r.length; });
                                        console.log(L);
                                        for(var i = json[0].length; i < L; ++i) {
                                            json[0][i] = "";
                                        }
                                    
                                        /* load data */
                                        cdg.data = json;
                                        };
                                        /* make the buttons for the sheets */
                                        var make_buttons = function(sheetnames, cb) {
                                            var buttons = document.getElementById('buttons');
                                            buttons.innerHTML = "";
                                            sheetnames.forEach(function(s,idx) {
                                                var btn = document.createElement('button');
                                                btn.type = 'button';
                                                btn.name = 'btn' + idx;
                                                btn.text = s;
                                                var txt = document.createElement('h3'); txt.innerText = s; btn.appendChild(txt);
                                                btn.addEventListener('click', function() { cb(idx); }, false);
                                                buttons.appendChild(btn);
                                                buttons.appendChild(document.createElement('br'));
                                            });
                                            };
                                        
                                            var cdg = canvasDatagrid({
                                            parentNode: _grid
                                            });
                                            cdg.style.height = '100%';
                                            cdg.style.width = '100%';
                                        
                                            function _resize() {
                                            _grid.style.height = (window.innerHeight - 200) + "px";
                                            _grid.style.width = (window.innerWidth - 200) + "px";
                                            }
                                            window.addEventListener('resize', _resize);
                                    var filename = $('#excel').attr("data-file");
                                    // var blob = this.response;
                                    var data = new Uint8Array(request.response);
                                    // if(window.navigator.msSaveOrOpenBlob) {
                                    //     window.navigator.msSaveBlob(blob, fileName);
                                    // }
                                    // else{
                                    const dT = new DataTransfer();
                                    var contentTypeHeader = request.getResponseHeader("Content-Type");
                                    // var blobby = new Blob([blob], { type: contentTypeHeader });
                                    // dT.items.add(new File([blobby], filename));
                                    dT.items.add(new File(data, filename));
                                    // var data = dT.files;
                                        // var downloadLink = window.document.createElement('a');
                                        
                                        // downloadLink.href = window.URL.createObjectURL();
                                        // downloadLink.download = fileName;
                                        // document.body.appendChild(downloadLink);
                                        // downloadLink.click();
                                        // document.body.removeChild(downloadLink);
                                       
                                //    }

                            // do_file(e.dataTransfer.files);
                            
                            // var data = request.response;
                            // do_file(data);
                            
                            
                            // inp.files = dT.files;
                            
                            // var workbook = XLSX.read(data, {type:"array"});
                            DropSheet({
                                file: dT.files,
                                drop: _target,
                                on: {
                                    workstart: _workstart,
                                    workend: _workend,
                                    sheet: _onsheet,
                                    foo: 'bar'
                                },
                                errors: {
                                    badfile: _badfile,
                                    pending: _pending,
                                    failed: _failed,
                                    large: _large,
                                    foo: 'bar'
                                }
                                })
                            }
                            // process_wb(workbook);
                            // grid.data = XLSX.utils.sheet_to_json(ws, {header:1});
                            // DropSheet.handleFile(workbook);
                            /* DO SOMETHING WITH workbook HERE */
                            }
                    
                            request.send();
                        });
                        $('#excell').click(function(){
                            var url = $(this).attr("data-path");
                            var filename = $(this).attr("data-file");
                            const dT = new DataTransfer();
                            
                            var data = dT.files;
                            $.ajax({  
                                url:url,  
                                method:"GET",  
                                success:function(data){
                                    dT.items.add(new File(filename, data));
                                    _file.files = dT.files;  
                                    DropSheet({
                                        file: _file,
                                        drop: _target,
                                        on: {
                                            workstart: _workstart,
                                            workend: _workend,
                                            sheet: _onsheet,
                                            foo: 'bar'
                                        },
                                        errors: {
                                            badfile: _badfile,
                                            pending: _pending,
                                            failed: _failed,
                                            large: _large,
                                            foo: 'bar'
                                        }
                                        })
                                    
                                }  
                            });
                        })
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
                    // drop_down_list();
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
                    // $('#county_parish').val(data.county_parish);
                    
                    
                    
                }  
        });  
    });
    $(document).on('click', '#add.fixed-action-btn', function(){
        var now = moment();
        var curDate = now.format('YYYY-MM-DD');
        var curTime = now.format('HH:mm');
        $('#de').val(curDate);
        $('#ts').val(curTime);
        $('#te').val(curTime);
        // $('.datepicker').datepicker('destroy');
        $('#dee').datepicker('update', curDate);
        $('#drn.ddr-e').trumbowyg('destroy');
        $('#drn.ddr-v').trumbowyg('destroy');
        // $('#drn.ddr-a').trumbowyg('destroy');
        $('#drn.ddr-f').trumbowyg('destroy');
        $('#drn.ddr-e').trumbowyg(drn_t);
        $('#drn.ddr-v').trumbowyg(drn_t);
        // $('#drn.ddr-a').trumbowyg(drn_t);
        $('#drn.ddr-f').trumbowyg(drn_t);
    })
    $('#add_data_Modal').on('show.bs.modal', function (e) {
        // var date = new Date();
        // var currentDate = date.toISOString().slice(0,10);
        // var currentTime = date.getHours() + ':' + date.getMinutes();
        // editor = InlineEditor
        //         .create( document.querySelector( '#drn' ), 
        //         {
        //             // toolbar: [ 'bold', 'italic', 'link', 'undo', 'redo', 'bulletedList', 'numberedList', 'blockQuote' ],
        //         } )
        //         .then( editor => {
        //                 console.log( editor );
        //         } )
        //         .catch( error => {
        //                 console.error( error );
        //         } );
        //         $( '#add_data_Modal' ).modal( {
        //     focus: false
        // } );
        
        // editor = new MediumEditor('#drn');
    })
    $('#add_data_Modal').on('hidden.bs.modal', function (e) {
        // editor.destroy();
    });
    // $('edit-drawer-btn').click(function(){
    
    // $(document).on('click', '#edit-drawer-btn', function(){
    //     $('#editsModal').modal('show'); 
    //     $("#editsModal").on("show.bs.modal", function(event) {
    //         // $('#edit-close.close').on('click', function(){
    //         //     $('#editsModal').modal('hide');
    //         // });
    //         // ajax call to data
    //     });
    // });
    // $('.modal').on('show.bs.modal', function (event) {
    //     var idx = $('.modal:visible').length;
    //     $(this).css('z-index', 1040 + (10 * idx));
    // });
    // $('.modal').on('shown.bs.modal', function (event) {
    //     var idx = ($('.modal:visible').length) - 1; // raise backdrop after animation.
    //     $('.modal-backdrop').not('.stacked').css('z-index', 1039 + (10 * idx));
    //     $('.modal-backdrop').not('.stacked').addClass('stacked');
    // });
    // $(document).on('click', '#edit-drawer', function(){
    //     $('#vitalsModal').modal('show'); 
    //     $("#vitalsModal").on("show.bs.modal", function(event) {
    //         // ajax call to data
    //     });
    // });
    // $(document).on('click', '#edit-drawer-btn', function(){
    //     // Get the modal
    //     var drawer = document.getElementById("edit-drawer");
        
    //     // Get the button that opens the modal
    //     var btn = document.getElementById("edit-drawer-btn");
        
    //     // Get the <span> element that closes the modal
    //     var span = document.getElementsByClassName("edit-drawer-close")[0];
        
    //     // When the user clicks the button, open the modal 
    //     btn.onclick = function() {
    //         drawer.style.display = "block";
    //     }
        
    //     // When the user clicks on <span> (x), close the modal
    //     span.onclick = function() {
    //         drawer.style.display = "none";
    //     }
        
    //     // When the user clicks anywhere outside of the modal, close it
    //     window.onclick = function(event) {
    //         if (event.target == drawer) {
    //             drawer.style.display = "none";
    //         }
    //     }
    // });
        
    // $(document).on('click', '#vitals-drawer-btn', function(){
    //     // Get the modal
    //     var drawer = document.getElementById("vitals-drawer");
        
    //     // Get the button that opens the modal
    //     var btn = document.getElementById("vitals-drawer-btn");
        
    //     // Get the <span> element that closes the modal
    //     var span = document.getElementsByClassName("vitals-drawer-close")[0];
        
    //     // When the user clicks the button, open the modal 
    //     btn.onclick = function() {
    //     // $(this).on('click', function(){
    //         drawer.style.display = "block";
    //     }
        
    //     // When the user clicks on <span> (x), close the modal
    //     span.onclick = function() {
    //         drawer.style.display = "none";
    //     }
        
    //     // When the user clicks anywhere outside of the modal, close it
    //     window.onclick = function(event) {
    //         if (event.target == drawer) {
    //             drawer.style.display = "none";
    //         }
    //     }
    // });
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
        // $('#removeSection').addClass("active");
    });
    $('#drn-e-replace').click(function(){  
        

        $('#appendSection').removeClass("show");        
        // $('#removeSection').addClass("active");
    });
    function drop_down_list(c = "")
    {
        var state = $('#state').val();

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

        $.getScript("js/states/"+ state.toLowerCase() +".js", function(){

        populate(document.insert_well_form.county_parish);

        $('#loading_county_drop_down').hide(); // Hide the Loading...
        $('#county_drop_down').show(); // Show the drop down
        $('#county_parish').val(c);
        });
    }
    }

    $(document).ready(function(){
    $("#state").change(drop_down_list);
    });
    
    // var X = XLSX;

    // var cDg;

    // var process_wb = (function() {
    //     // var XPORT = document.getElementById('xport');
    //     var HTMLOUT = document.getElementById('grid');

    //     return function process_wb(wb) {
    //         /* get data */
    //         var ws = wb.Sheets[wb.SheetNames[0]];
    //         var data = XLSX.utils.sheet_to_json(ws, {header:0});

    //         /* update canvas-datagrid */
    //         if(!cDg) cDg = canvasDatagrid({ parentNode:HTMLOUT, data:data });
    //         cDg.style.height = '100%';
    //         cDg.style.width = '100%';
    //         cDg.data = data;
    //         // XPORT.disabled = false;

    //         /* create schema (for A,B,C column headings) */
    //         // var range = XLSX.utils.decode_range(ws['!ref']);
    //         // for(var i = range.s.c; i <= range.e.c; ++i) cDg.schema[i - range.s.c].title = XLSX.utils.encode_col(i);

    //         HTMLOUT.style.height = (window.innerHeight - 400) + "px";
    //         HTMLOUT.style.width = (window.innerWidth - 50) + "px";

    //         if(typeof console !== 'undefined') console.log("output", new Date());
    //     };
    // })();
    // var do_file = (function() {
    //     var rABS = typeof FileReader !== "undefined" && (FileReader.prototype||{}).readAsBinaryString;
    //     var domrabs = document.getElementsByName("userabs")[0];
    //     if(!rABS) domrabs.disabled = !(domrabs.checked = false);
    
    //     return function do_file(files) {
    //         rABS = domrabs.checked;
    //         var f = files[0];
    //         var reader = new FileReader();
    //         reader.onload = function(e) {
    //             if(typeof console !== 'undefined') console.log("onload", new Date(), rABS);
    //             var data = e.target.result;
    //             if(!rABS) data = new Uint8Array(data);
    //             process_wb(X.read(data, {type: rABS ? 'binary' : 'array'}));
    //         };
    //         if(rABS) reader.readAsBinaryString(f);
    //         else reader.readAsArrayBuffer(f);
    //     };
    // })();
    /* oss.sheetjs.com (C) 2014-present SheetJS -- http://sheetjs.com */
    /* vim: set ts=2: */

    var DropSheet = function DropSheet(opts) {
        if(!opts) opts = {};
        var nullfunc = function(){};
        if(!opts.errors) opts.errors = {};
        if(!opts.errors.badfile) opts.errors.badfile = nullfunc;
        if(!opts.errors.pending) opts.errors.pending = nullfunc;
        if(!opts.errors.failed) opts.errors.failed = nullfunc;
        if(!opts.errors.large) opts.errors.large = nullfunc;
        if(!opts.on) opts.on = {};
        if(!opts.on.workstart) opts.on.workstart = nullfunc;
        if(!opts.on.workend) opts.on.workend = nullfunc;
        if(!opts.on.sheet) opts.on.sheet = nullfunc;
        if(!opts.on.wb) opts.on.wb = nullfunc;
    
        var rABS = typeof FileReader !== 'undefined' && FileReader.prototype && FileReader.prototype.readAsBinaryString;
        var useworker = typeof Worker !== 'undefined';
        var pending = false;
        function fixdata(data) {
        var o = "", l = 0, w = 10240;
        for(; l<data.byteLength/w; ++l)
            o+=String.fromCharCode.apply(null,new Uint8Array(data.slice(l*w,l*w+w)));
        o+=String.fromCharCode.apply(null, new Uint8Array(data.slice(o.length)));
        return o;
        }
    
        function sheetjsw(data, cb, readtype) {
        pending = true;
        opts.on.workstart();
        var scripts = document.getElementsByTagName('script');
        var dropsheetPath;
        for (var i = 0; i < scripts.length; i++) {
            if (scripts[i].src.indexOf('dropsheet') != -1) {
            dropsheetPath = scripts[i].src.split('dropsheet.js')[0];
            }
        }
        var worker = new Worker(dropsheetPath + 'sheetjsw.js');
        worker.onmessage = function(e) {
            switch(e.data.t) {
            case 'ready': break;
            case 'e': pending = false; console.error(e.data.d); break;
            case 'xlsx':
                pending = false;
                opts.on.workend();
                cb(JSON.parse(e.data.d)); break;
            }
        };
        worker.postMessage({d:data,b:readtype,t:'xlsx'});
        }
    
        var last_wb;
    
        function to_json(workbook) {
        if(useworker && workbook.SSF) XLSX.SSF.load_table(workbook.SSF);
        var result = {};
        workbook.SheetNames.forEach(function(sheetName) {
            var roa = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], {raw:false, header:1});
            if(roa.length > 0) result[sheetName] = roa;
        });
        return result;
        }
    
        function choose_sheet(sheetidx) { process_wb(last_wb, sheetidx); }
    
        function process_wb(wb, sheetidx) {
        last_wb = wb;
        opts.on.wb(wb, sheetidx);
        var sheet = wb.SheetNames[sheetidx||0];
        var json = to_json(wb)[sheet];
        opts.on.sheet(json, wb.SheetNames, choose_sheet);
        }
    
        function handleDrop(e) {
        e.stopPropagation();
        e.preventDefault();
        if(pending) return opts.errors.pending();
        var files = e.dataTransfer.files;
        // var files = e;
        var i,f;
        for (i = 0, f = files[i]; i != files.length; ++i) {
            var reader = new FileReader();
            var name = f.name;
            reader.onload = function(e) {
            var data = e.target.result;
            var wb, arr;
            var readtype = {type: rABS ? 'binary' : 'base64' };
            if(!rABS) {
                arr = fixdata(data);
                data = btoa(arr);
            }
            function doit() {
                try {
                if(useworker) { sheetjsw(data, process_wb, readtype); return; }
                wb = XLSX.read(data, readtype);
                process_wb(wb);
                } catch(e) { console.log(e); opts.errors.failed(e); }
            }
    
            if(e.target.result.length > 1e6) opts.errors.large(e.target.result.length, function(e) { if(e) doit(); });
            else { doit(); }
            };
            if(rABS) reader.readAsBinaryString(f);
            else reader.readAsArrayBuffer(f);
        }
        }
    
        function handleDragover(e) {
        e.stopPropagation();
        e.preventDefault();
        e.dataTransfer.dropEffect = 'copy';
        }
    
        // if(opts.drop.addEventListener) {
        // opts.drop.addEventListener('dragenter', handleDragover, false);
        // opts.drop.addEventListener('dragover', handleDragover, false);
        // opts.drop.addEventListener('drop', handleDrop, false);
        // }
    
        function handleFile(e) {
        if(pending) return opts.errors.pending();
        var files = e.target.files;
        var i,f;
        for (i = 0, f = files[i]; i != files.length; ++i) {
            var reader = new FileReader();
            var name = f.name;
            reader.onload = function(e) {
            var data = e.target.result;
            var wb, arr;
            var readtype = {type: rABS ? 'binary' : 'base64' };
            if(!rABS) {
                arr = fixdata(data);
                data = btoa(arr);
            }
            function doit() {
                try {
                if(useworker) { sheetjsw(data, process_wb, readtype); return; }
                wb = XLSX.read(data, readtype);
                process_wb(wb);
                } catch(e) { console.log(e); opts.errors.failed(e); }
            }
    
            if(e.target.result.length > 1e6) opts.errors.large(e.target.result.length, function(e) { if(e) doit(); });
            else { doit(); }
            };
            if(rABS) reader.readAsBinaryString(f);
            else reader.readAsArrayBuffer(f);
        }
        }
    
        if(opts.file && opts.file.addEventListener) opts.file.addEventListener('change', handleFile, false);
    };
    // opts.file.addEventListener('')
    /* oss.sheetjs.com (C) 2014-present SheetJS -- http://sheetjs.com */
    /* vim: set ts=2: */

    /** drop target **/
    // var _target = document.getElementById('drop');
    // var _target = document.getElementById('drop');
    // var _file = document.getElementById('file');
    // var _grid = document.getElementById('grid');

    

    

    
    
    /** Drop it like it's hot **/
    // DropSheet({
    // file: _file,
    // drop: _target,
    // on: {
    //     workstart: _workstart,
    //     workend: _workend,
    //     sheet: _onsheet,
    //     foo: 'bar'
    // },
    // errors: {
    //     badfile: _badfile,
    //     pending: _pending,
    //     failed: _failed,
    //     large: _large,
    //     foo: 'bar'
    // }
    // })

} );
        
