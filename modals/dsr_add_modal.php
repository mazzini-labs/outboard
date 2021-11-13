<!-- Add DSR Entry Modal -->
<!-- to return to normal modal behavior, add the "fade" class to 
the first <div> and remove all css from floating_action_button.php -->
<div class="modal right" id="add_data_dsr_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-side modal-top-right" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalPreviewLabel">DSR Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="insert_form" class="dsr" method="POST">
                <div class="modal-body">
                    <div class="row mx-auto">
                        <div class="form-group mx-auto">
                            <select id="add_data_select" class="dsr selectpicker form-control" data-live-search="true" data-width="auto" data-size="5" name="api" size="1" title="Select Well..." data-style="btn-primary btn-lg">
                            <!-- <option>Select Well:</option> -->
                            <?php
                                
                                $table = "list";
                                $sql = "SELECT api, entity_common_name FROM $table";// ORDER BY well_lease ASC";
                                $result = mysqli_query($mysqli,$sql) or die(mysql_error());
                                    //console_log($result);
                                ?>
                                <!-- <option>Select Well:</option> -->
                                <?php 
                                while ($row = mysqli_fetch_array($result)) {
                                    // $wellname = $row['well_lease'] . "# " . $row['well_no']; 
                                    $wellname = $row['entity_common_name'];
                                    $conditional = ($row['api'] == $apino) ?  '"' . $row['api'] . '" selected' :  '"' . $row['api'] . '"';
                                    ?>
                                <option name="api" id="api" value=<?php echo $conditional;  ?> data-token=<?php echo $conditional;  ?>><?php echo $wellname; //$row['api']; // . $row['well_no'];?></option> 
                            <?php } ?>
                                </select> 
                        </div>
                    </div>
                    <div class="row mx-auto">
                        <div class="col-7">
                            <div class="input-group mx-auto">
                                <div class="input-group-prepend mt-4 mb-2">
                                    <span class="input-group-text">Date Entered</span>
                                </div>
                                <input id="de" name="de" type="search" class="dsr form-control date datepicker--input mt-4" value="" required>
                                <input name="deb" id="deb" type="hidden" class="dsr form-control" placeholder="Your Name" aria-label="Data Entry By">
                            </div>
                        </div>
                        <div class="col-3">
                            <div id="dee" class="dsr" data-date="today"></div>
                        </div>
                    </div>
                    <div class="row mx-auto mt-4">
                        <div class="dsr input-group mx-auto">
                            
                            <div class="dsr input-group mx-auto">
                                <div class="dsr input-group-prepend">
                                    <span class="dsr input-group-text">$</span>
                                </div>
                                <input name="edc" id="edc" type="text" class="dsr form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="dsr input-group-append">
                                    <span class="dsr input-group-text">Estimated Daily Cost</span>
                                </div>
                                <div class="w-100 mt-2"></div>
                                <div class="dsr input-group-prepend">
                                    <span class="dsr input-group-text">$</span>
                                </div>
                                <input name="ecc" id="ecc" type="text" class="dsr form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="dsr input-group-append">
                                    <span class="dsr input-group-text">Estimated Cumulative Cost</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-auto mt-4">
                        <!-- <div class="dsr input-group mx-auto">
                            <div class="dsr input-group-prepend">
                                <span class="dsr input-group-text">Daily Summary Report</span>
                            </div>
                            <textarea name="drn" id="drn" class="dsr form-control" aria-label="With textarea"></textarea>
                        </div> -->
                        <div class="mb-1 btn-block dsr">
                            <label for="drn" class="col-form-label col-form-label-lg" >Daily Summary Report</label>
                            
                                <div name="drn" id="drn" class="dsr"></div>
                            
                        </div>
                        <input type="hidden" name="id" id="id" class="dsr" />
                        <!-- <input type="hidden" name="api" id="api" class="dsr" value=<?php echo $api; ?> /> -->
                        <input type="hidden" name="d" id="d" value="e" class="dsr" />
                        <input type="hidden" name="t" id="t" value="s" class="dsr" />
                        <input type="search" name="ec" id="ec" class="ddr" value="0" style="display: none;"/>     
                        <!-- </form> -->
                    </div>
                </div>
                <!-- <div class="modal-footer"> -->
                <div class="w-100"></div>
                    <div class="row mx-auto">
                        <div class="col input-group p-1">
                            <input type="submit" name="insert" id="insert" value="Insert" class="dsr btn btn-primary btn-block m-3" />
                        </div>
                        <div class="col p-1">
                            <button type="button" class="btn btn-secondary btn-block m-3" data-dismiss="modal">Close</button>
                        </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add DSR Entry Modal -->