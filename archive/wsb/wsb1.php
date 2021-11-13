<?php
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
<?php

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
		<!-- Bootstrap core CSS -->
    <!-- <link href="WSB/stylesheet/bootstrap.min.css" rel="stylesheet"> -->
    <!-- Custom styles for this template -->
	<link href="WSB/stylesheet/offcanvas.css" rel="stylesheet">
    <title>WSB</title>
    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
 
    <script type="text/javascript" src="datatables/datatables.min.js"></script>
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/dt-1.10.21/af-2.3.5/b-1.6.2/b-colvis-1.6.2/b-print-1.6.2/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.4/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.0/sl-1.3.1/datatables.min.css"/>
 
   <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/dt-1.10.21/af-2.3.5/b-1.6.2/b-colvis-1.6.2/b-print-1.6.2/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.4/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.0/sl-1.3.1/datatables.min.js"></script> -->
     <!--     <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css"> -->
        <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
        <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
            <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>

        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script> -->
    <script type="text/javascript" class="init">
        // $.noConflict();
        $(document).ready(function() {
            $('#productionTable').DataTable( {
                    "order": [],
                    "pageLength": 50
            } );
        } );
    </script>
    </head>
	<style>

	</style>
    <body>

        <?php 
            include 'WSB/includes.php';
            include 'header.php';
            $sort = $_GET['sort'];
            $sorder = $_GET['sorder'];
            $start = $_GET['start'];
            $end = $_GET['end'];
            
            //print_header();
		            // execute the query:
            // default sort is to sort by the Action Date field
            if (!isset($sort)) {
                $table = "`list`";
                $sort = "`api`";
            }
            if ($_GET['sort'] == 'gas_sold' || $_GET['sort'] == 'oil_prod' || $_GET['sort'] == 'water_prod' || $_GET['sort'] == 'gas_line_loss' ){
                $table = "`prod_data`";
            } else { $table = "`list`";}
            // check the sort order (ASC or DESC)
            if ($_GET['sorder'] == "ASC") {
                $sorder = "DESC";
                $norder = "ASC";
            } else {
                $sorder = "ASC";
                $norder = "DESC";
            }
            /* $query = "SELECT `prod_data`.*, `list`.*,
            IF(
                $table.$sort IS NULL
                OR $table.$sort = '',
                1,
                0
                OR $table.$sort = '0000-00-00 00:00:00'
                OR $table.$sort = 'YYYY-MM-DD'
                OR $table.$sort = 'No'
                        
            ) AS isnull
            FROM prod_data, list
            WHERE `prod_data`.`prod_mo` = `list`.`last_prod_date` AND `prod_data`.`api` = `list`.`api` ORDER BY isnull $norder, $table.$sort $sorder"; */
            $query = "SELECT `prod_data`.*, `list`.*
            FROM prod_data, list
            WHERE DATE_FORMAT(`prod_data`.`prod_mo`, '%y-%m') = DATE_FORMAT(`list`.`last_prod_date`, '%y-%m') AND `prod_data`.`api` = `list`.`api`";
            $conn = connect_db();
            $results = mysqli_query($conn, $query);
            $num_records = mysqli_num_rows($results); 
            console_log($conn);
            console_log($query);
            console_log($results);
            mysqli_close($conn);
            
            // by default, only list 10 wells per page.
            if (!isset($_GET['start'])) {
                $_GET['start'] = 0;
            }

            if (!isset($_GET['end'])) {
                $_GET['end'] = 100;

            } 

            // if the user selects how many wells to list, change the end variable
            if (isset($_POST['numofwells'])) {
                $_GET['end'] = $_POST['numofwells'];
            }

            // tell the user how many total wells are in the database
            $disp_beg_val = $_GET['start'] + 1; // the db stores the first well as id 0, so we have to add 1 for the offset...?>

    <div class='container-fluid'>
      <div class='row'>
         <nav class="navbar fixed-bottom navbar-expand-lg navbar-dark bg-dark">
            <div class="collapse navbar-collapse justify-content-md-center">
        <ul class="navbar-nav mr-auto"><div class="row"><div class="col-4">
		  <li class='nav-item'>
				<?php 
			echo "<form class='form-inline' method='post' action='index.php?sort=well_name&sorder=ASC'>\n";
			  	  // set the field for the query to be sorted by
            if (isset($sort)) {
                $order = "&sort=$_GET[sort]";
            } else {
                $order = "";
            }

            // calculate the start and end range to cycle through remaing records...
            $next_start = $_GET['end'];
            $next_end = ($_GET['end'] - $_GET['start']) + $next_start;
            $prev_start = $_GET['start'] - ($_GET['end'] - $_GET['start']);
            $prev_end = $_GET['start'];

            // check your bounds...
            if ($prev_start < 0) {
                $prev_start = 0;
                $prev_end = $_GET['end'];
            }

            if ($next_end > $num_records) {
                $next_end = $num_records;
                $next_start = $_GET['end'];
            }

            $set_of_wells = $_GET['end'] - $_GET['start'];

            // you're at the end of the list, and there are fewer wells than 
            // what would be in a normal list
            if ($set_of_wells > ($num_records - $_GET['end'])) {
                $prev_set_of_wells = $set_of_wells;
                $set_of_wells = $num_records - $_GET['end'];
            }


            if ($set_of_wells == 0) {
                // just use JavaScript "go back" feature, and then PHP code
                // will kick-in again using the $_GET[start / end] values
                echo "<a class='btn btn-sm btn-primary' href=\"javascript:history.go(-1)\"> <span data-feather='arrow-left-circle'></span> Prev wells </a>";
                echo "<a class='btn btn-sm btn-primary disabled' href=\"wsb.php?start=$next_start&end=$next_end$order\">End of Well List<span data-feather='arrow-right-circle'></span></a>";
            } else {
                // print an option to show the next set...
                $prev_set_of_wells = $_GET['end'] - $_GET['start'];
                if ($_GET['start'] == 0) {
                    echo "<div class=col /><a class='btn btn-sm btn-primary disabled' href=\"wsb.php?start=$prev_start&end=$prev_end$order\"> <span data-feather='arrow-left-circle'></span> Prev $prev_set_of_wells wells &nbsp</a>";
                } else {
                    echo "<div class=col /><a class='btn btn-sm btn-primary' href=\"wsb.php?start=$prev_start&end=$prev_end$order\"> <span data-feather='arrow-left-circle'></span> Prev $prev_set_of_wells wells &nbsp</a>";
                }
                echo "<span>&nbsp;</span><a class='btn btn-sm btn-primary' href=\"wsb.php?start=$next_start&end=$next_end$order\">Next $set_of_wells wells <span data-feather='arrow-right-circle'></span> </a>";
            }
           
            echo "</li></form></div>";
            echo "<div class='col-6 justify-content-md-center ' style='color:white;'><span class='nav-text'>";
           
            echo "Showing wells <b>$disp_beg_val</b> through <b>$_GET[end]</b> out of a total of <b>$num_records</b> wells recorded in the database.</span></div>";

            //echo "<li class='nav-item'>";
            //echo "&nbsp;</li>";
            echo "<div class='col-2'><li class='nav-item active'>";
            echo "<form class='form-inline' method='post' action='wsb.php?sort=well_name&sorder=ASC'>\n";
            echo "<div class='justify-content form-group'>
            <select class='form-control form-control-sm form-control-dark' name='numofwells'>";

            //for ($j=1; $j < $num_records + 1; $j++)
            //{
            //	if ($_GET['end'] - $_GET['start'] == $j) { 
            //		$sel="SELECTED";
            //		$sel="SELECTED";
            //	} else { $sel = ""; }
            //	
            //	echo "<option value='$j' name='$j' $sel>$j</option>\n";
            //}
            echo "<option selected>Select the number of wells to display</option>";
            echo "<option value='1' name='1'>1</option>\n";
            echo "<option value='2' name='2'>2</option>\n";
            echo "<option value='3' name='3'>3</option>\n";
            echo "<option value='4' name='4'>4</option>\n";
            echo "<option value='5' name='5'>5</option>\n";
            echo "<option value='10' name='10'>10</option>\n";
            echo "<option value='15' name='15'>15</option>\n";
            echo "<option value='20' name='20'>20</option>\n";
            echo "<option value='25' name='25'>25</option>\n";
            echo "<option value='50' name='50'>50</option>\n";
            echo "<option value='$num_records' name='$num_records'>All</option>\n";
            echo "</select>\n";
            echo "<input class='btn btn-sm btn-outline-primary' type='submit' name='select' value='Update'></div>\n";
          
            echo "</form></li></div>";
            //echo "</form>";
            //echo "<p /><a href=\"index.php?start=0&end=$num_records$order\">Show All Wells</a>";
                ?>
            <!-- </span> -->

                    
        </ul>

        
      </div>
    </nav> 
        <?php


			
            echo "<form class='table-responsive' style='padding: 0 0 0 0;' method='post' action='wsb.php?sort=well_name&sorder=ASC'>\n";


            if (isset($_GET['start']) && isset($_GET['end'])) {
                $start_var = "&start=$_GET[start]";
                $end_var = "&end=$_GET[end]";
            } else {
                $start_var = "";
                $end_var = "";
            }

        ?>
<main role="main" class="col-sm-auto pt-5">
        <!-- <input class="form-control" type="text" id="searchInput" onkeyup="searchFunction()" placeholder="Search..."> -->
       <?php 
                $sorthref = "wsb.php?sort="; 
                $sorderhref = "&sorder="; 
                
                //TODO: fix the swapping table order
                //if()
            ?> 
<!--		 <div class='table-responsive'>-->
        <table id="productionTable" class='table table-striped table-bordered table-sm' >
            <!-- <thead><tr>
                <th rowspan=2><a href="<?php /*echo $sorthref . 'well_lease' . $sorderhref . $sorder . $start_var . $end_var; ?>">Well</a></th>
                <th rowspan=2 ><a href="<?php echo $sorthref . 'state' . $sorderhref . $sorder . $start_var . $end_var ?>">State</a></th>
                <th rowspan=2 ><a href="<?php echo $sorthref . 'county_parish' . $sorderhref . $sorder. $start_var . $end_var ?>">County</a></th>
                <th rowspan=2><a href="<?php echo $sorthref . 'block' . $sorderhref . $sorder. $start_var . $end_var ?>">Block</a></th>
                <th rowspan=2><a href="<?php echo $sorthref . 'entity_operator_code' . $sorderhref . $sorder. $start_var . $end_var ?>">Company</a></th>
                <th rowspan=2><a href="<?php echo $sorthref . 'producing_status' . $sorderhref . $sorder. $start_var . $end_var ?>">Well Status</a></th>
                <th rowspan=2><a href="<?php echo $sorthref . 'production_type' . $sorderhref . $sorder. $start_var . $end_var ?>">Primary Production</a></th>
                <th rowspan=2><a href="<?php echo $sorthref . 'prod_mo' . $sorderhref . $sorder. $start_var . $end_var ?>">Prod. Mo.</a></th>
                <th colspan=3>Avg Daily Production</th>
                <th colspan=3>Monthly Production</th>
                <th rowspan=2><a href="<?php echo $sorthref . 'gas_line_loss' . $sorderhref . $sorder. $start_var . $end_var ?>">Line Loss</a></th>
                <th rowspan=2><a href="<?php echo $sorthref . 'pumper' . $sorderhref . $sorder. $start_var . $end_var ?>">Pumper</a></th>
                <th rowspan=2>Notes</th>
                <th rowspan=2><a href="<?php echo $sorthref . 'notes_update' . $sorderhref . $sorder. $start_var . $end_var ?>">Last Updated</a></th>
            </tr>
            <tr>
                <th>Gas</th><th>Oil</th><th>Water</th>
                <th><a onclick="sortTable(0)" href="<?php //echo $sorthref . 'gas_sold' . $sorderhref . $sorder. $start_var . $end_var ?>">Gas</a></th>
                <th><a href="<?php echo $sorthref . 'oil_prod' . $sorderhref . $sorder. $start_var . $end_var ?>">Oil</a></th>
                <th><a href="<?php echo $sorthref . 'water_prod' . $sorderhref . $sorder. $start_var . $end_var */?>">Water</a></th>
            </tr>
            </thead> -->
            <thead>
            <tr>
                <th colspan=7></th>
                <th colspan=3>Avg Daily Production</th>
                <th colspan=3>Monthly Production</th>
                <th colspan=5></th>
            </tr>
            <tr>
                <th>Well</th>
                <th>State</th>
                <th>County</a></th>
                <th>Block</a></th>
                <th>Company</a></th>
                <th>Well Status</a></th>
                <th>Primary Production</a></th>
                <th>Prod. Mo.</a></th>
                
                <th>Gas</th><th>Oil</th><th>Water</th>
                <th>Gas</a></th>
                <th>Oil</a></th>
                <th>Water</a></th>
                <th>Line Loss</a></th>
                <th>Pumper</a></th>
                <th>Notes</th>
                <th>Last Updated</a></th>
            </tr>
            
            </thead>

        <?php

        // print the contents of the table
	echo "<tbody>\n";
        for ($i = $_GET['start']; $i < $_GET['end']; $i++)
        {
            $well_api = wsb_result($results, $i, "api");
            $well_lease = wsb_result($results, $i, "well_lease");
            $well_number = wsb_result($results, $i, "well_no");
            //$wellname = $well_lease . " " . $well_number;
            $wellname = wsb_result($results, $i, "entity_common_name");
            $state = wsb_result($results, $i, "state");
            $county = wsb_result($results, $i, "county_parish");
            $block = wsb_result($results, $i, "block");
            $compname = wsb_result($results, $i, "entity_operator_code");
            $wellstatus = wsb_result($results, $i, "producing_status");
            $productiontype = wsb_result($results, $i, "production_type");
            $actiondate = wsb_result($results, $i, "last_prod_date");
            $dayson = wsb_result($results, $i, "days_on");
            $gassold = wsb_result($results, $i, "gas_sold");
            $cur_prod_gas = $gassold;
            $cur_prod_oil = wsb_result($results, $i, "oil_prod");
            $cur_prod_water = wsb_result($results, $i, "water_prod");
            if(!$dayson == 0){
            $avg_prod_gas = $cur_prod_gas / $dayson;
            $avg_prod_oil = $cur_prod_oil / $dayson;
            $avg_prod_water = $cur_prod_water / $dayson; 
            }
            $lineloss = wsb_result($results, $i, "gas_line_loss");	
            $pumper = wsb_result($results, $i, "pumper");
            $wellcheck = wsb_result($results, $i, "report_frequency");
            $notes = wsb_result($results, $i, "notes");
            $notes_updated = wsb_result($results, $i, "notes_update");
            $datetime = new DateTime($notes_updated);

            $last_updated = $datetime->format('Y-m-d');
            //$priority = mysql_result($results, $i, "priority");

            // set the background color to grey of every even numbered row in the table
  /*          if ($i % 2 == 1) {
                echo "<tbody bgcolor=#C8C8C8 >\n";
            } else {	
                echo "<tbody>\n";
            }
*/			
            if($wellstatus == 'Shut-in' || $wellstatus == 'Shut-In' || $wellstatus == 'INACTIVE'){
                //$status = "style='color:red;'><small";
                $status = "style='background-color: #F08080;'><small";
            }else{
                $status = "><small";
            }
            echo "<tr>\n";
            echo "<td ><small><a href='prod_data.php?api=$well_api'>$wellname</td ></small>\n";
            echo "<td ><small>$state</td ></small>\n";
            echo "<td ><small>$county</a></td ></small>\n";
            echo "<td ><small>$block</td ></small>\n";
            echo "<td ><small>$compname</td ></small>\n";
            echo "<td $status>$wellstatus</td ></small>\n";
            echo "<td ><small>$productiontype</td ></small>\n";
            echo "<td ><small>$actiondate</td ></small>\n";
            echo "<td ><small>". truncate($avg_prod_gas) ." <sup>mcf</sup>/<sub>day</sub></small></td>\n";
            echo "<td ><small>". truncate($avg_prod_oil) ." <sup>bbl</sup>/<sub>day</sub></small></td>\n";
            echo "<td ><small>". truncate($avg_prod_water) ." <sup>bbl</sup>/<sub>day</sub></small></td>\n";
            echo "<td ><small>". truncate($cur_prod_gas) ." mcf</small></td>\n";
            echo "<td ><small>". truncate($cur_prod_oil) ." bbl</small></td>\n";
            echo "<td ><small>". truncate($cur_prod_water) ." bbl</small></td>\n";
            echo "<td ><small>". truncate($lineloss) ." mcf</small></td>\n";
            echo "<td ><small>$pumper</td ></small>\n";
            echo "<td ><small>$notes</td ></small>\n";
            echo "<td ><small>$last_updated</td ></small>\n";

            echo "</tr>\n"; 
        }
		echo "</tbody>\n";
        ?>
        </table>
        <?php
			 
      	echo "</form>\n";
        ?>
<!--		</div>-->
		  </main>
  </div>
</div>    </body>
	<!-- <script src="WSB/dashboard/jquery-3.2.1.slim.min.js.download" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <!-- <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery-3.2.1.slim.min.js"><\/script>')</script> -->
    <!-- <script src="WSB/dashboard/popper.min.js.download"></script> -->
    <!-- <script src="WSB/dashboard/bootstrap.min.js.download"></script> -->

    <!-- Icons -->
    <script src="WSB/dashboard/feather.min.js.download"></script>
    <script>
      feather.replace()
    </script>   
    <!-- <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery-slim.min.js"><\/script>')</script> -->
    <!-- <script src="WSB/stylesheet/holder.min.js.download"></script> -->
    <!-- <script src="WSB/stylesheet/offcanvas.js.download"></script> -->
    <!-- <script>
        const getCellValue = (tr, idx) => tr.children[idx].innerText || tr.children[idx].textContent;

        const comparer = (idx, asc) => (a, b) => ((v1, v2) => 
            v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) ? v1 - v2 : v1.toString().localeCompare(v2)
            )(getCellValue(asc ? a : b, idx), getCellValue(asc ? b : a, idx));

        // do the work...
        document.querySelectorAll('th').forEach(th => th.addEventListener('click', (() => {
            const table = th.closest('table');
            Array.from(table.querySelectorAll('tr:nth-child(n+2)'))
                .sort(comparer(Array.from(th.parentNode.children).indexOf(th), this.asc = !this.asc))
                .forEach(tr => table.appendChild(tr) );
        })));
    </script> -->
    <!-- <script>
    function searchFunction() {
    // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("productionTable");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
        }
    }
    }
    </script> -->
    <!-- <script>
        function sortTable(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("productionTable");
        switching = true;
        // Set the sorting direction to ascending:
        dir = "asc";
        /* Make a loop that will continue until
        no switching has been done: */
        while (switching) {
            // Start by saying: no switching is done:
            switching = false;
            rows = table.rows;
            /* Loop through all table rows (except the
            first, which contains table headers): */
            for (i = 1; i < (rows.length - 1); i++) {
            // Start by saying there should be no switching:
            shouldSwitch = false;
            /* Get the two elements you want to compare,
            one from current row and one from the next: */
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            /* Check if the two rows should switch place,
            based on the direction, asc or desc: */
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                // If so, mark as a switch and break the loop:
                shouldSwitch = true;
                break;
                }

            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                // If so, mark as a switch and break the loop:
                shouldSwitch = true;
                break;
                }
            }
            }
            if (shouldSwitch) {
            /* If a switch has been marked, make the switch
            and mark that a switch has been done: */
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            // Each time a switch is done, increase this count by 1:
            switchcount ++;
            } else {
            /* If no switching has been done AND the direction is "asc",
            set the direction to "desc" and run the while loop again. */
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
            }
        }
        }
    </script> -->
    
    <!-- <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> -->
    <!-- <script>$(document).ready( function () {
    $('#productionTable').DataTable();
} );</script> -->
</html>
