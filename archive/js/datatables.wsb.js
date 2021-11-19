$(function(){
            var click1 = 1;
            var click2 = 0;
            var click3 = 0;
            var click4 = 0;
            var oTable;
            var iTable;
            var sTable;
            
            $(document).ready(function() {
                 $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
                         $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
                     } );

                if(click1 < 2){
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
                                // "data": "notes_update", // Last Updated
                                /* render: function ( data, type, row ) 
                                {
                                    var dateSplit = data.split('-');
                                    return type === "display" || type === "filter" ?
                                        dateSplit[1] +'-'+ dateSplit[2] +'-'+ dateSplit[0] :
                                        data;
                                }, */
                                "data": "de",
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
            } );
            
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
                                    /*
                                "data": "notes_update", // Last Updated
                                /* render: function ( data, type, row ) {
                                var dateSplit = data.split('-');
                                return type === "display" || type === "filter" ?
                                    dateSplit[1] +'-'+ dateSplit[2] +'-'+ dateSplit[0] :
                                    data;
                                }, 
                                "defaultContent": "",*/
                                // "data": null, render: function ( data, type, row ) {
                                //     // Combine the Well and API into a single table field
                                //     return data.de+' '+data.ts;
                                // }, 
                                "data":"de",
                                "render": function(data, type) {
                                    // return type === 'sort' ? data : moment(data).format('LLL');
                                    return type === 'sort' ? data : moment(data).format('MMM D YYYY') + " <br> " + moment(data).format('LT');
                                },
                                "defaultContent": ""
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

        } );
        
