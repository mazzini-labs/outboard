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

<link rel="stylesheet" href="https://unpkg.com/x-data-spreadsheet@latest/dist/xspreadsheet.css">
<script src="https://unpkg.com/x-data-spreadsheet@latest/dist/xspreadsheet.js"></script>


<style>
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
</style>
</head>
<body>
<?php include 'header_extensions.php'; ?>
   
<div id="demo"></div>
<script>
    x_spreadsheet('#demo');
   const myData = [{
      name: 'sheet-test-1',
      freeze: 'B3',
      styles: [
        {
          bgcolor: '#f4f5f8',
          textwrap: true,
          color: '#900b09',
          border: {
            top: ['thin', '#0366d6'],
            bottom: ['thin', '#0366d6'],
            right: ['thin', '#0366d6'],
            left: ['thin', '#0366d6'],
          },
        },
      ],
      merges: [
        'C3:D4',
      ],
      rows: {
        1: {
          cells: {
            0: { text: 'testingtesttestetst' },
            2: { text: 'testing' },
          },
        },
        2: {
          cells: {
            0: { text: 'render', style: 0 },
            1: { text: 'Hello' },
            2: { text: 'haha', merge: [1, 1] },
          }
        },
        8: {
          cells: {
            8: { text: 'border test', style: 0 },
          }
        }
      },
    }, 
    { name: 'sheet-test' }
]
// const mySpreadSheet = new Spreadsheet(document.getElementById('demo')).loadData(myData);
const mySpreadSheet = new Spreadsheet(document.getElementById('demo'),{
        mode: 'edit', // edit | read
        showToolbar: true,
        showGrid: true,
        showContextmenu: true,
        view: {
          height: () => document.documentElement.clientHeight,
          width: () => document.documentElement.clientWidth,
        },
        row: {
          len: 100,
          height: 25,
        },
        col: {
          len: 26,
          width: 100,
          indexWidth: 60,
          minWidth: 60,
        },
        style: {
          bgcolor: '#ffffff',
          align: 'left',
          valign: 'middle',
          textwrap: false,
          strike: false,
          underline: false,
          color: '#0a0a0a',
          font: {
            name: 'Helvetica',
            size: 10,
            bold: false,
            italic: false,
          },
        }
})
mySpreadSheet.change(data => {
  // save data to db
});
mySpreadSheet.validate();
// fired after selected
mySpreadSheet.on('cell-selected', (cell, ri, ci) => {});
mySpreadSheet.on('cells-selected', (cell, { sri, sci, eri, eci }) => {});
// fired after edited
mySpreadSheet.on('cell-edited', (text, ri, ci) => {});
</script>
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
