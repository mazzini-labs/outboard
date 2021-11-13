<?php
namespace Phppot;

use Phppot\Model\FAQ;

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
<!-- Bootstrap core CSS -->
<link href="./WSB/stylesheet/bootstrap.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="./WSB/stylesheet/offcanvas.css" rel="stylesheet">
<!-- <link href="./assets/CSS/style.css" type="text/css" rel="stylesheet" /> -->
<link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
<script type="text/javascript" src="datatables/datatables.min.js"></script>
<!-- <script src="./vendor/jquery/jquery-3.2.1.min.js"></script> -->
<script src="./assets/js/inlineEdit.1.js"></script>
    <?php include 'WSB/includes.php'; ?>
    <title>WSB</title>

    <script type="text/javascript" class="init">
    // $.noConflict();
    $(document).ready(function() {
        oTable = $('#productionTable').DataTable( {
                "order": [],
                
                //"pageLength": 50,
                //"fixedHeader": true,
                // "scrollY":        "50vh",
                //"scrollCollapse": true,
                /* "fnInitComplete": function () {
                var myCustomScrollbar = document.querySelector('#dt-vertical-scroll_wrapper .dataTables_scrollBody');
                var ps = new PerfectScrollbar(myCustomScrollbar);
                }, */
                "paging": false,
                "info": false,
                "searching": true,
                "sDom": 'd'
                /* scroller: true,
                "columns": [
                    { "width": "8%" },
                    { "width": "2%" },
                    { "width": "4%" },
                    { "width": "2%" },
                    { "width": "4%" },
                    { "width": "2%" },
                    { "width": "4%" },
                    { "width": "2%" },
                    { "width": "1%" },
                    { "width": "1%" },
                    { "width": "1%" },
                    { "width": "1%" },
                    { "width": "1%" },
                    { "width": "1%" },
                    { "width": "2%" },
                    { "width": "2%" },
                    { "width": "14%" },
                    { "width": "3%" }
                ] */
        } );
        $('#searchProduction').keyup(function(){
            oTable.search($(this).val()).draw() ;
        })
    } );
</script>
<style>
    .tbl-qa {
    /* width: 100%; 
    background-color: #f5f5f5;*/
}

.tbl-qa th.table-header {
    /* padding: 5px;
    text-align: left;
    padding: 10px; */
}

.tbl-qa .table-row td {
    /* padding: 8px 15px 10px 8px;
    background-color: #FDFDFD;
    vertical-align: top; */
    font-size: 11px;
}
tr {
width: 100%;
display: inline-table;
height:auto;
table-layout: fixed;
  
}

table{
 height:0%; 
 display: -moz-groupbox;
 overflow: hidden;
}
tbody{
  overflow-y: scroll;
  height: 85vh;
  width: auto;
  position: absolute;
}
.table > thead {
                font-style: normal!important;
                font-stretch: condensed!important;
                font-size: 12px;
            }
</style>
</head>
<body>
<?php include 'include/header_extensions.php'; ?>
   
    
<main role='main' >
		<div class=''>
		<table id="productionTable" class='tbl-qa table table-hover table-striped table-bordered' style="margin:0px!important;">
        <thead class=''>
            <tr>
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
        <tbody>
<?php
require_once ("Model/FAQ.1.php");
$faq = new FAQ();
$faqResult = $faq->getFAQ();

foreach ($faqResult as $k => $v) {
    ?>
		<tr class="table-row">
               <td contenteditable="true"
                    onBlur="saveToDatabase(this,'entity_common_name','<?php echo $faqResult[$k]["list_id"]; ?>')"
                    onClick="showEdit(this);"><?php echo $faqResult[$k]['entity_common_name']; ?></td>
               <td contenteditable="false"
                    onBlur="saveToDatabase(this,'state,'<?php echo $faqResult[$k]["list_id"]; ?>')"
                    onClick="showEdit(this);"><?php echo $faqResult[$k]['state']; ?></td>
			<td contenteditable="false"
                    onBlur="saveToDatabase(this,'county_parish','<?php echo $faqResult[$k]["list_id"]; ?>')"
                    onClick="showEdit(this);"><?php echo $faqResult[$k]['county_parish']; ?></td>
			<td contenteditable="true"
                    onBlur="saveToDatabase(this,'block','<?php echo $faqResult[$k]["list_id"]; ?>')"
                    onClick="showEdit(this);"><?php echo $faqResult[$k]['block']; ?></td>
			<td contenteditable="false"
                    onBlur="saveToDatabase(this,'entity_operator_code','<?php echo $faqResult[$k]["list_id"]; ?>')"
                    onClick="showEdit(this);"><?php echo $faqResult[$k]['entity_operator_code']; ?></td>
			<td contenteditable="true"
                    onBlur="saveToDatabase(this,'producing_status','<?php echo $faqResult[$k]["list_id"]; ?>')"
                    onClick="showEdit(this);"><?php echo $faqResult[$k]["producing_status"]; ?></td>
			<td contenteditable="false"
                    onBlur="saveToDatabase(this,'production_type','<?php echo $faqResult[$k]["list_id"]; ?>')"
                    onClick="showEdit(this);"><?php echo $faqResult[$k]["production_type"]; ?></td>
               <td contenteditable="true"
                    onBlur="saveToDatabase(this,'last_prod_date','<?php echo $faqResult[$k]["list_id"]; ?>')"
                    onClick="showEdit(this);"><?php echo $faqResult[$k]["last_prod_date"]; ?></td>
               <td contenteditable="true"
                    onBlur="saveToDatabase(this,'pumper','<?php echo $faqResult[$k]["list_id"]; ?>')"
                    onClick="showEdit(this);"><?php echo $faqResult[$k]["pumper"]; ?></td>
               <td contenteditable="true"
                    onBlur="saveToDatabase(this,'notes','<?php echo $faqResult[$k]["list_id"]; ?>')"
                    onClick="showEdit(this);"><?php echo $faqResult[$k]["notes"]; ?></td>
               <td contenteditable="true"
                    onBlur="saveToDatabase(this,'si_notes','<?php echo $faqResult[$k]["list_id"]; ?>')"
                    onClick="showEdit(this);"><?php echo $faqResult[$k]["si_notes"]; ?></td>
	  
           </tr>
	<?php
}
?>
		  </tbody>
    </table>
	</div>
		</div>
          </main>
          </body>
	<!-- <script src="dashboard/jquery-3.2.1.slim.min.js.download" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-3.2.1.slim.min.js"><\/script>')</script> -->
    <script src="WSB/dashboard/popper.min.js.download"></script>
    <script src="WSB/dashboard/bootstrap.min.js.download"></script>

    <!-- Icons -->
    <script src="WSB/dashboard/feather.min.js.download"></script>
    <script>
      feather.replace()
    </script>   
    <!-- <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script> -->
    <script src="WSB/stylesheet/holder.min.js.download"></script>
    <script src="WSB/stylesheet/offcanvas.js.download"></script>


</html>
