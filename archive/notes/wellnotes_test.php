<?php

$api = $_GET['api'];
//$api = '"' . $_GET['api'] . '"';
//$sheet = '"' . "ddr2015pres" . '"';
$sheet = "ddr2015pres";
function console_log($output, $with_script_tags = true) {
     $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
 ');';
     if ($with_script_tags) {
         $js_code = '<script>' . $js_code . '</script>';
     }
     echo $js_code;
 }
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="x-ua-compatible" content="ie=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/maintest.css?=v1.2">
	<link rel="stylesheet" type="text/css" href="css/tabs.css">
		<!-- Bootstrap core CSS -->
	<link href="WSB/stylesheet/bootstrap.min.css" type="text/css" rel="stylesheet">

	<!-- Custom styles for this template -->

	<link href="WSB/stylesheet/offcanvas.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
	integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
	crossorigin=""/>
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
	integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
	crossorigin=""></script>
		<!-- <script src="dashboard/jquery-3.2.1.slim.min.js.download" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
		<!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
		<link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>

		<script type="text/javascript" src="datatables/datatables.min.js"></script>
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script> -->
		
		<script type="text/javascript" src="js/chart.js"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@0.7.7"></script>
          <script type="text/javascript" src="./assets/js/inlineEdit.js"></script>
          <style type="text/css" class="init">
			.borderLit{
				border-color: rgba(0,255,0,0.5);
			}
			div.dataTables_wrapper {
				width: 800px;
				margin: 0 auto;
			}
          </style>
          <script type="text/javascript" class="init">
			$(document).ready(function() {
                    var bDSRTable = $('#before2015sumrpt').DataTable( {
						"scrollY":        "100px",
						"scrollX": true	
                    } );
               } );
		</script>
</head> 
<body>
    <table class="tbl-qa">
        <thead>
            <tr>
                <th class="table-header">&nbsp;</th>
                <th class="table-header">A</th>
                <th class="table-header">B</th>
                <th class="table-header">C</th>
                <th class="table-header">D</th>
                <th class="table-header">E</th>
                <th class="table-header">F</th>
                <th class="table-header">G</th>
                <th class="table-header">H</th>
                <th class="table-header">I</th>
                <th class="table-header">J</th>
                <th class="table-header">K</th>
                <th class="table-header">L</th>
                <th class="table-header">M</th>
                <th class="table-header">N</th>
                <th class="table-header">O</th>
                <th class="table-header">P</th>
                <th class="table-header">Q</th>
                <th class="table-header">R</th>
                <th class="table-header">S</th>
                <th class="table-header">T</th>
                <th class="table-header">U</th>
                <th class="table-header">V</th>
                <th class="table-header">W</th>
                <th class="table-header">X</th>
                <th class="table-header">Y</th>
                <th class="table-header">Z</th>
                <!-- <th class="table-header">E</th>
                <th class="table-header">E</th> -->
            </tr>
        </thead>
        <tbody>
<?php
require_once ("Model/inline.php");
$inline = new inline();
$well = $inline->getwell($api);
console_log($well);
$inlineResult = $inline->getinline($api,$sheet);

foreach ($inlineResult as $k => $v) {
    ?>
			  <tr class="table-row">
                <td><?php echo $k+1; ?></td>
                <td contenteditable="true"
                    onBlur="saveToDatabase(this,'a','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
                    onClick="showEdit(this);"><?php echo $inlineResult[$k]["a"]; ?></td>
                <td contenteditable="true"
                    onBlur="saveToDatabase(this,'b','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
                    onClick="showEdit(this);"><?php echo $inlineResult[$k]["b"]; ?></td>
				<td contenteditable="true"
                    onBlur="saveToDatabase(this,'c','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
                    onClick="showEdit(this);"><?php echo $inlineResult[$k]["c"]; ?></td>
				<td contenteditable="true"
                    onBlur="saveToDatabase(this,'d','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
                    onClick="showEdit(this);"><?php echo $inlineResult[$k]["d"]; ?></td>
				<td contenteditable="true"
                    onBlur="saveToDatabase(this,'e','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
                    onClick="showEdit(this);"><?php echo $inlineResult[$k]["e"]; ?></td>
				<td contenteditable="true"
                    onBlur="saveToDatabase(this,'f','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
                    onClick="showEdit(this);"><?php echo $inlineResult[$k]["f"]; ?></td>
				<td contenteditable="true"
                    onBlur="saveToDatabase(this,'g','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
                    onClick="showEdit(this);"><?php echo $inlineResult[$k]["g"]; ?></td>
				<td contenteditable="true"
                    onBlur="saveToDatabase(this,'h','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
                    onClick="showEdit(this);"><?php echo $inlineResult[$k]["h"]; ?></td>
                <td contenteditable="true"
                    onBlur="saveToDatabase(this,'i','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
                    onClick="showEdit(this);"><?php echo $inlineResult[$k]["i"]; ?></td>
				<td contenteditable="true"
                    onBlur="saveToDatabase(this,'j','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
                    onClick="showEdit(this);"><?php echo $inlineResult[$k]["j"]; ?></td>
				<td contenteditable="true"
                    onBlur="saveToDatabase(this,'k','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
                    onClick="showEdit(this);"><?php echo $inlineResult[$k]["k"]; ?></td>
				<td contenteditable="true"
                    onBlur="saveToDatabase(this,'l','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
                    onClick="showEdit(this);"><?php echo $inlineResult[$k]["l"]; ?></td>
				<td contenteditable="true"
                    onBlur="saveToDatabase(this,'m','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
                    onClick="showEdit(this);"><?php echo $inlineResult[$k]["m"]; ?></td>
				<td contenteditable="true"
                    onBlur="saveToDatabase(this,'n','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
                    onClick="showEdit(this);"><?php echo $inlineResult[$k]["n"]; ?></td>
				<td contenteditable="true"
                    onBlur="saveToDatabase(this,'o','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
                    onClick="showEdit(this);"><?php echo $inlineResult[$k]["o"]; ?></td>
                <td contenteditable="true"
                    onBlur="saveToDatabase(this,'p','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
                    onClick="showEdit(this);"><?php echo $inlineResult[$k]["p"]; ?></td>
				<td contenteditable="true"
                    onBlur="saveToDatabase(this,'q','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
                    onClick="showEdit(this);"><?php echo $inlineResult[$k]["q"]; ?></td>
				<td contenteditable="true"
                    onBlur="saveToDatabase(this,'r','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
                    onClick="showEdit(this);"><?php echo $inlineResult[$k]["r"]; ?></td>
				<td contenteditable="true"
                    onBlur="saveToDatabase(this,'s','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
                    onClick="showEdit(this);"><?php echo $inlineResult[$k]["s"]; ?></td>
				<td contenteditable="true"
                    onBlur="saveToDatabase(this,'t','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
                    onClick="showEdit(this);"><?php echo $inlineResult[$k]["t"]; ?></td>
				<td contenteditable="true"
                    onBlur="saveToDatabase(this,'u','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
                    onClick="showEdit(this);"><?php echo $inlineResult[$k]["u"]; ?></td>
				<td contenteditable="true"
                    onBlur="saveToDatabase(this,'v','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
                    onClick="showEdit(this);"><?php echo $inlineResult[$k]["v"]; ?></td>
                <td contenteditable="true"
                    onBlur="saveToDatabase(this,'w','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
                    onClick="showEdit(this);"><?php echo $inlineResult[$k]["w"]; ?></td>
				<td contenteditable="true"
                    onBlur="saveToDatabase(this,'x','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
                    onClick="showEdit(this);"><?php echo $inlineResult[$k]["x"]; ?></td>
				<td contenteditable="true"
                    onBlur="saveToDatabase(this,'y','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
                    onClick="showEdit(this);"><?php echo $inlineResult[$k]["y"]; ?></td>
				<td contenteditable="true"
                    onBlur="saveToDatabase(this,'z','<?php echo $inlineResult[$k]["id"]; ?>','<?php echo $api; ?>', '<?php echo $sheet; ?>')"
                    onClick="showEdit(this);"><?php echo $inlineResult[$k]["z"]; ?></td>
            </tr>
		<?php
}
?>
		  </tbody>
    </table>
</body>
</html>
