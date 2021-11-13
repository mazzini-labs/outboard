<?php
include 'lib/ob.php';
############# LOGGING ###############################
function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
############# LOGGING ###############################


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<link rel="stylesheet" type="text/css" href="css/util.css">
<link rel="stylesheet" type="text/css" href="css/maintest.css?=v1.2">
<link rel="stylesheet" type="text/css" href="css/search.css">
<link rel="stylesheet" type="text/css" href="css/tabs.css">
<!-- Bootstrap core CSS -->
<link href="./WSB/stylesheet/bootstrap.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="./WSB/stylesheet/offcanvas.css" rel="stylesheet">
<!-- <link href="./assets/CSS/style.css" type="text/css" rel="stylesheet" /> -->
<link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
<script type="text/javascript" src="datatables/datatables.min.js"></script>
<!-- <script src="./vendor/jquery/jquery-3.2.1.min.js"></script> -->
<script src="./assets/js/inlineEditNotes.js?v=1.0.0.0"></script>


    <?php include 'WSB/includes.php'; ?>
    <title>WSB</title>

    <script type="text/javascript" class="init">
    window.index = 0;
    $(document).ready(function() {
        
        oTable = $('#productionTable').DataTable( {
            "ajax": {url:"ajax/notes.ajax.php",dataSrc:""},
            "sDom": 't',
            "order": [],
            scrollY: 850,
            scroller: true,
            "searching": true,
            "keys": true,
        "columns": [
            {
                "data": "api",
                "defaultContent": ""
            },
            {
            "data": "entity_common_name",
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
                "defaultContent": "",
            },
            {
                "data": "pumper", // Pumper
                "defaultContent": "",
            },
            {
                "data": "notes",
                "defaultContent": "",
            },
            {
            "data": "si_notes", // Last Updated
            "defaultContent": "",
            },
        ],
        'columnDefs': [
            { className: "text-wrap notes", "targets":  [10, 11]  },
            { className: "notes", "targets":  [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]  },
            { width: "17%", "targets": [10, 11] },

            {
                'targets': [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                'createdCell': function (td, cellData, rowData, row, col) {
                    {
                        
                        // console.log(row);
                        // console.log(col);
                        
                        var check = oTable.cell(td,0).data(); 
                        
                        
                        switch(col)
                        {   
                            case 0:
                                $(td).attr('id',window.index);
                                $(td).attr('contenteditable', 'false');
                                $(td).attr('onBlur', 'saveToDatabase(this, \'api\',\'' + check + '\')');
                                // $(td).attr('dblClick', 'showEdit(this)');
                            break;
                            case 1:
                                // $(td).attr('contenteditable', 'true');
                                $(td).attr('id',window.index);
                                $(td).attr('onBlur', 'saveToDatabase(this, \'entity_common_name\',\'' + check + '\')');
                                // $(td).attr('onClick', 'showEdit(this)');
                                $(td).attr('onClick', 'this.contentEditable=true;');
                                
                                // $(td).attr('id', check);
                                // $(td).attr('name', 'entity_common_name');
                                // $(td).attr('contentEditable', 'true');
                                // // $(td).attr('onClick', 'console.log(this);');
                            break;
                            case 2:
                                // $(td).attr('contenteditable', 'true');
                                $(td).attr('id',window.index);
                                $(td).attr('onBlur', 'saveToDatabase(this, \'state\',\'' + check + '\')');
                                // $(td).attr('onClick', 'showEdit(this)');
                                $(td).attr('onClick', 'this.contentEditable=true;');
                            break;
                            case 3:
                                // $(td).attr('contenteditable', 'true');
                                $(td).attr('id',window.index);
                                $(td).attr('onBlur', 'saveToDatabase(this, \'county_parish\',\'' + check + '\')');
                                // $(td).attr('onClick', 'showEdit(this)');
                                $(td).attr('onClick', 'this.contentEditable=true;');
                            break;
                            case 4:
                                // $(td).attr('contenteditable', 'true');
                                $(td).attr('id',window.index);
                                $(td).attr('onBlur', 'saveToDatabase(this, \'block\',\'' + check + '\')');
                                // $(td).attr('onClick', 'showEdit(this)');
                                $(td).attr('onClick', 'this.contentEditable=true;');
                            break;
                            case 5:
                                // $(td).attr('contenteditable', 'true');
                                $(td).attr('id',window.index);
                                $(td).attr('onBlur', 'saveToDatabase(this, \'entity_operator_code\',\'' + check + '\')');
                                // $(td).attr('onClick', 'showEdit(this)');
                                $(td).attr('onClick', 'this.contentEditable=true;');
                            break;
                            case 6:
                                // $(td).attr('contenteditable', 'true');
                                $(td).attr('id',window.index);
                                $(td).attr('onBlur', 'saveToDatabase(this, \'producing_status\',\'' + check + '\')');
                                // $(td).attr('onClick', 'showEdit(this)');
                                $(td).attr('onClick', 'this.contentEditable=true;');
                            break;
                            case 7:
                                // $(td).attr('contenteditable', 'true');
                                $(td).attr('id',window.index);
                                $(td).attr('onBlur', 'saveToDatabase(this, \'production_type\',\'' + check + '\')');
                                // $(td).attr('onClick', 'showEdit(this)');
                                $(td).attr('onClick', 'this.contentEditable=true;');
                            break;
                            case 8:
                                // $(td).attr('contenteditable', 'true');
                                $(td).attr('id',window.index);
                                $(td).attr('onBlur', 'saveToDatabase(this, \'last_prod_date\',\'' + check + '\')');
                                // $(td).attr('onClick', 'showEdit(this)');
                                $(td).attr('onClick', 'this.contentEditable=true;');
                            break;
                            case 9:
                                // $(td).attr('contenteditable', 'true');
                                $(td).attr('id',window.index);
                                $(td).attr('onBlur', 'saveToDatabase(this, \'pumper\',\'' + check + '\')');
                                // $(td).attr('onClick', 'showEdit(this)');
                                $(td).attr('onClick', 'this.contentEditable=true;');
                            break;
                            case 10:
                                // $(td).attr('contenteditable', 'true');
                                $(td).attr('id',window.index);
                                $(td).attr('onBlur', 'saveToDatabase(this, \'notes\',\'' + check + '\')');
                                // $(td).attr('dblClick', 'showEdit(this)');
                                $(td).attr('onClick', 'this.contentEditable=true;');
                            break;
                            default:
                                // $(td).attr('contenteditable', 'true');
                                $(td).attr('id',window.index);
                                $(td).attr('onBlur', 'saveToDatabase(this, \'si_notes\',\'' + check + '\')');
                                $(td).attr('onClick', 'this.contentEditable=true;');
                        }
                        window.index++;
                    }
                },
                    
            },

     		
          ],
          "createdRow": function( row, data, dataIndex ) {
                // if ( data[4] == "A" ) {
                $(row).addClass( 'excel' );
                // }
            }
        } );
        $('#searchProduction').keyup(function(){
            oTable.search($(this).val()).draw() ;
        })
        // $("td").keyup(function(e) {
        //         //Enter key
        //         var enter = this;
        //         if (e.which == 13) {
        //             $(this).next('input').focus();
        //             showEdit(enter);
        //             alert("Enter key pressed");
        //             // $(e.target).trigger({
        //             //     type: "keydown",
        //             //     which: 40
                        
        //             // });
        //             e.preventDefault();
        //             return;
        //     }
        // });
        
        $( "td" ).dblclick(function() {
            showEdit(this);
            console.log(this);
        });
        $("td").on('click', function() {
            window.thecurrentcell = this;
        })
        // $.fn.excel = $( "td" ).dblclick(function() {
        //         showEdit(this);
        //         alert( "Handler for .dblclick() called." );
        // });
        
        // $("body").keypress(function(e){
        //     if ( e.which === 13 || e.which === 47 ) {
        //         e.preventDefault();
        //         $(e.target).trigger({
        //             type: "keypress",
        //             which: 40
        //         });
                
        //     }
        // });
        oTable.on( 'key', function ( e, datatable, key, cell, originalEvent ) {
            if ( key === 13 ) { // return
                // originalEvent.preventDefault();
                // $(this).unbind('key');
                key = 0;
                var cellRow = cell.index().row;
                var cellCol = cell.index().column;
                var focusCell = oTable.cell(cellRow, cellCol).node();
                var id = $(oTable.cell(cellRow, cellCol).node()).attr('id');
                var name = $(oTable.cell(cellRow, cellCol).node()).attr('name');
                console.log(id+ " " + name);
                // var focusCell = oTable.cell(eq(this)).node();
                var enterKey = key;
                setTimeout( function() {
                    
                    focusCell.focus();
                }, 100 );
                if (key === 13){
                    focusCell.blur();

                    // $(this).unbind('key');
                    // setTimeout( function(){oTable.keys.move('down')}), 500;
                }
                // setTimeout( function(){
                //     if (key === 13) { 
                //         focusCell.blur(); 
                //         oTable.on( 'key-blur', function ( e, datatable, cell ) {
                //             console.log("Cell "+cellRow+", "+cellCol+" blurred.");
                //             $(oTable.keys.move('down'));
                //         } );
                        
                //     }
                // }), 5000;
                
                oTable
                    .on( 'key-focus', function ( e, datatable, cell) {
                        // var rowData = datatable.row( cell.index().row ).data();
                        console.log("Cell "+cellRow+", "+cellCol+" focused."); 
                        console.log(enterKey);
                        console.log(key);
                        var cellRowNew = cell.index().row;
                        var cellColNew = cell.index().column;
                        var focusCellNew = oTable.cell(cellRowNew, cellColNew).node();
                        if ( enterKey === 13 ) { // return
                            focusCell.focus();
                        }
                        // console.log($('#details').html( 'Cell in '+rowData[0]+' focused' ));
                    } )
                    .on( 'key-blur', function ( e, datatable, cell ) {
                        // console.log("Cell "+cellRow+", "+cellCol+" blurred.");
                        // focusCell.blur();
                        // saveToDatabase(focusCell, name, id);
                        keys.move('down');

                    } );
                // oTable.on( 'key-focus', function ( e, datatable, key, cell, originalEvent ) {
                //     var cellRow = cell.index().row;
                //     var cellCol = cell.index().column;
                //     var focusCell = oTable.cell(cellRow, cellCol).node();
                //     focusCell.blur();
                
                // })
                // oTable.on( 'key-blur', function ( e, datatable, key, cell, originalEvent ) {
                //     var cellRow = cell.index().row;
                //     var cellCol = cell.index().column;
                //     var focusCell = oTable.cell(cellRow, cellCol).node();
                //     // focusCell.focus();
                
                // })



                // if($(oTable.cell(cellRow, cellCol).node()).hasClass('focus') == true)
                // {
                    
                //     // originalEvent.keyCode = 8;
                //     var cellRow = cell.index().row;
                //     var cellCol = cell.index().column;
                //     var focusCell = oTable.cell(cellRow, cellCol).node();
                //     focusCell.blur();
                //     // if ( key === 13 ) { focusCell.blur(); }
                //     // console.log(this);
                    
                    
                // }
                // else if($(oTable.cell(cellRow, cellCol).node()).hasClass('focus') == false)
                // {
                //     // originalEvent.preventDefault();
                //     var cellRow = cell.index().row;
                //     var cellCol = cell.index().column;
                //     var focusCell = oTable.cell(cellRow, cellCol).node();
                //     focusCell.focus();
                    
                //     console.log($(oTable.cell(cellRow, cellCol).node()).hasClass('focus'));
                // }
                // return false;
                
            }
        });
        // oTable
        //     .on( 'key-focus', function ( e, datatable, key, cell, originalEvent ) {
        //         // var rowData = datatable.row( cell.index().row ).data();
        //         if ( key === 13 ) { // return
        //             console.log("this registers");
        //             var cellRow = cell.index().row;
        //             var cellCol = cell.index().column;
        //             var focusCell = oTable.cell(cellRow, cellCol).node();
        //             focusCell.focus();
        //         }
        //         // console.log($('#details').html( 'Cell in '+rowData[0]+' focused' ));
        //     } )
        //     .on( 'key-blur', function ( e, datatable, cell ) {
        //         $('#details').html( 'No cell selected' );
        //     } );
        // oTable.on( 'key-focus', function ( e, datatable, key, cell, originalEvent ) {
        //     if ( key === 13 ) { // return
        //         console.log("this registers");
        //         var cellRow = cell.index().row;
        //         var cellCol = cell.index().column;
        //         var focusCell = oTable.cell(cellRow, cellCol).node();
        //         focusCell.blur();
        //     }
        // });
//     } );
// var o = {
//     38: 'up',
//     40: 'bottom',
//     37: 'prev',
//     39: 'next'
// }


// $(document).on('keyup', function (e) {
//     var dir = o[e.which];
//     // var $active = $('.active'),
//         // i = $date.index($active);
//     if (e.which == 13) {
//         // $('.selected').removeClass('selected');
//         // $active.addClass('selected');
//         showEdit(this);
//         return;
//     }
    // if (!$active.length) {
    //     $date.first().addClass('active');
    //     return;
    // } else {
    //     if (dir === 'next' || dir === 'prev') {
    //         $active.removeClass('active')[dir]().addClass('active');
    //     } else {
    //         var p = dir === 'up' ? (i - 7) : (i + 7);
    //         $date.removeClass('active').eq(p).addClass('active');
    //     }
    // }

})
// document.getElementById("#1").focus();
// document.getElementById('"#'+window.index+'"').onkeypress = function (e) {
//     document.getElementById("#1").onkeypress = function (e) {
//     if (e.which === 13) {
//         document.getElementById(window.index+10).click();
//         return false;
//     }
// };

</script>
<!-- <script>
    var position = { x: 0, y: 0 };
    var calendarMap = [];

    $(document).ready(function () {
        $('tr.excel').each(function () {
            calendarMap.push([]);
            $('.notes', this).each(function () {
                calendarMap[calendarMap.length - 1].push($(this));
            });
        });
        highlightCell();
    });

    $(window).on('keydown', function (e) {
        if (e.keyCode === 37) // left
            moveLeft();
        else if (e.keyCode === 38) // up
            moveUp();
        else if (e.keyCode === 39) // right
            moveRight();
        else if (e.keyCode === 40) // down
            moveDown();
        highlightCell();
    });

    function moveLeft() {
        position.x--;
        if (position.x < 0)
            position.x = 0;
    }

    function moveUp() {
        position.y--;
        if (position.y < 0)
            position.y = 0;
    }

    function moveRight() {
        position.x++;
        if (position.x >= calendarMap[0].length)
            position.x = calendarMap[0].length - 1;
    }

    function moveDown() {
        position.y++;
        if (position.y >= calendarMap.length)
            position.y = calendarMap.length - 1;
    }

    function highlightCell() {
        $('.notes').removeClass('selected');
        calendarMap[position.y][position.x].addClass('selected');
    }
</script> -->
<style>
.selected {
    background-color: #343a40;
	color: #fff;
}
.smol th,
.smol td,
.smol a,
.smol p {
  padding-top: 0.3rem;
  padding-bottom: 0.3rem;
  font-size: 12px!important;
}
table.dataTable tbody td {
  word-break: break-word!important;
  vertical-align: top;
} 
.text-wrap{
    white-space:normal!important;
}
p, td {
    cursor: url("./images/crosshair.gif"), url("./images/crosshair.cur"), crosshair;
}
td:focus { cursor: text; }
</style>
</head>
<body>
<?php include 'include/header_extensions.php'; ?>
   
    
<main role='main' >
	<div class=''>
		<table id="productionTable" class='tbl-qa table table-hover table-striped table-bordered table-sm smol' style="margin:0px!important; border-collapse: collapse!important;">
            <thead class='bg-sog table-borderless'style="border: 3px solid rgb(100,150,225)!important; border-color: rgb(100,150,225)!important; border-collapse: collapse!important;">
                <tr>
                <th class="table-header">API</th>
                    <th class="table-header">Well</th>
                    <th class="table-header">State</th>
                    <th class="table-header">County</th>
                    <th class="table-header">Block</th>
                    <th class="table-header">Company</th>
                    <th class="table-header">Status</th>
                    <th class="table-header">Type</th>
                    <th class="table-header">Last Active</th>
                    <th class="table-header">Pumper</th>
                    <th class="table-header">Notes</th>
                    <th class="table-header">S/I Notes</th>
                </tr>
            </thead>
        </table>
	</div>
</main>
</body>
<script src="./assets/js/tablenavigator-master/dist/jquery.tablenavigator.js"></script>

</html>
