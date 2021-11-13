<?php 
        include 'include/wsbFunctions.php';
        // include 'header.php';
        $query = "SELECT
                        `prod_data`.*,
                        `list`.*
                    FROM
                        prod_data,
                        list
                    WHERE
                        DATE_FORMAT(`prod_data`.`prod_mo`, '%y-%m') = DATE_FORMAT(`list`.`last_prod_date`, '%y-%m')
                        AND `prod_data`.`api` = `list`.`api`
                    ORDER BY
                        `list`.`api` ASC";
        $conn = connect_db();
        $results = mysqli_query($conn, $query);
        $num_records = mysqli_num_rows($results); 
        mysqli_close($conn);
        ?>
    <div class='container-fluid'>
        
        <main role="main" class="pt-5">
            <table id="productionTable" class='table table-striped table-bordered table-sm' >
                <thead>
                    <tr>
                        <td colspan=8></td>
                        <th colspan=3>Avg Daily Production</th>
                        <th colspan=3>Monthly Production</th>
                        <td colspan=4></td>
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
        	echo "<tbody >\n";
        while($row = $results -> fetch_assoc())
        //for ($i = $_GET['start']; $i < $_GET['end']; $i++)
        {
            $well_api = $row['api'];
            $well_lease = $row['well_lease'];
            $well_number = $row['well_no'];
            //$wellname = $well_lease . " " . $well_number;
            $wellname = $row['entity_common_name'];
            $state = $row['state'];
            $county = $row['county_parish'];
            $block = $row['block'];
            $compname = $row['entity_operator_code'];
            $wellstatus = $row['producing_status'];
            $productiontype = $row['production_type'];
            $actiondate = $row['last_prod_date'];
            $dayson = $row['days_on'];
            $gassold = $row['gas_sold'];
            $cur_prod_gas = $gassold;
            $cur_prod_oil = $row['oil_prod'];
            $cur_prod_water = $row['water_prod'];
            if(!$dayson == 0){
            $avg_prod_gas = $cur_prod_gas / $dayson;
            $avg_prod_oil = $cur_prod_oil / $dayson;
            $avg_prod_water = $cur_prod_water / $dayson; 
            }
            $lineloss = $row['gas_line_loss'];	
            $pumper = $row['pumper'];
            $wellcheck = $row['report_frequency'];
            $notes = $row['notes'];
            $notes_updated = $row['notes_update'];
            $datetime = new DateTime($notes_updated);
            $last_updated = $datetime->format('Y-m-d');
            //$priority = mysql_result($results, $i, "priority");
            if($wellstatus == 'Shut-in' || $wellstatus == 'Shut-In' || $wellstatus == 'INACTIVE'){
                //$status = "style='color:red;'><small";
                $status = "style='background-color: #F08080;'><small";
                $boldTagStart = "<strong>";
                $boldTagEnd = "</strong>";
            }else{
                $status = "><small";
                $boldTagStart = "";
                $boldTagEnd = "";
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
            echo "<td ><small>$pumper</small></td >\n";
            echo "<td ><small>$boldTagStart $notes $boldTagEnd</small> </td >\n";
            echo "<td ><small>$last_updated</small></td >\n";
            echo "</tr>\n"; 
        }
		echo "</tbody>\n";
        ?>
            </table>