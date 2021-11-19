<!-- Add DDR Entry Modal -->
<!-- to return to normal modal behavior, add the "fade" class to 
the first <div> and remove all css from floating_action_button.php -->
<div class="modal right" id="add_latest_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-side modal-top-right" role="document">
    <div id="success" name="success" class="alert alert-primary btn-block fade" style="position: absolute;z-index: 1;bottom: 0px;" role="alert"><h1>Your entry was input successfully.</h1></div>
        <div id="error" name="error" class="alert alert-danger fade" style="position: absolute;z-index: 1;bottom: 0px;" role="alert">An error occurred. Your entry was not input.<p id="e-details" class="error-details mb-0"></p></div>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalPreviewLabel">Latest Production Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <div class="row mx-auto">
                    <h6>Type:</h6>
                </div> --> 
                <!-- <div class="row"> -->
                <!-- </div> -->
            <!-- </div> -->
            <form id="insert_latest_prod" class="" method="POST">
                <div class="modal-body mr-5">
                    <div class="row mx-auto">
                        <div class="form-group mx-auto">
                            <select id="add_data_select" class="ddr selectpicker form-control" data-live-search="true" data-width="auto" data-size="5" name="api" size="1" title="Select Well..." data-style="btn-primary btn-lg">
                            <!-- <option>Select Well:</option> -->
                            <?php
                                
                                $table = "list";
                                $sql = "SELECT api, entity_common_name FROM $table";// ORDER BY well_lease ASC";
                                $result = mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
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
                        <div class="input-group input-group-sm">
                            
                            <div class="input-group-prepend mt-4 mb-2">
                                <span class="input-group-text">Production Date</span>
                            </div>
                            <!-- <input id="del" name="del" type="search" autocomplete="off" class="ddr form-control mt-4" value="" required> -->
                            <input id="del" name="del" type="search" autocomplete="off" class="ddr form-control date datepicker--input mt-4" value="" required>
                            <input name="debl" id="debl" type="hidden" autocomplete="off" class="ddr form-control" placeholder="Your Name" aria-label="Data Entry By" value="<?php echo $currentUser; ?>" required>
                            <!-- <div class="input-group-append">
                                <span class="input-group-text">Person Entering Data</span>
                            </div> -->
                            <div class="w-100"></div>
                            <div class="input-group-prepend mb-2">
                                <span class="input-group-text">Gas Produced</span>
                            </div>
                            <input type="search" class="ddr form-control" name="gp" id="gp" required>
                            <div class="w-100"></div>
                            <div class="input-group-prepend mb-2">
                                <span class="input-group-text">Oil Produced</span>
                            </div>
                            <input type="search" class="ddr form-control" name="op" id="op"  required>
                            <div class="w-100"></div>
                            <div class="input-group-prepend mb-2">
                                <span class="input-group-text">Water Produced</span>
                            </div>
                            <input type="search" class="ddr form-control" name="wp" id="wp"  required>
                        </div>
                        </div>
                        <div class="col-3">
                            <div id="deel" data-date="today"></div>
                        </div>
                        <!-- <div class="input-group input-group-sm mb-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Start Time</span>
                            </div>
                            <input type="time" value="08:00" step="100" class="ddr form-control" name="ts" id="ts" required>
                            <input type="time" value="08:00" step="100" class="ddr form-control" name="te" id="te" required>
                            <div class="input-group-append">
                                <span class="input-group-text">End Time</span>
                            </div>
                        </div> -->
                        <input type="search" name="id" id="id" class="ddr" style="display: none;"/>
                        <input type="hidden" name="eb" id="eb" class="ddr" value="<?php echo $currentUser; ?>"/>
                        <input type="search" name="ec" id="ec" class="ddr" value="0" style="display: none;"/>
                        <!-- <input type="hidden" name="api" id="api" class="ddr" value=<?php //echo $api; ?> /> -->
                    </div>
                </div>
                <div class="modal-footer mr-5">
                    <div class="row mx-auto">
                        <div class="ddr-f col input-group p-1">
                            <input type="submit" name="insert" id="insert" value="Insert" class="ddr-f btn btn-primary btn-block m-3" />
                        </div>
                        <div class="ddr-f col p-1">
                            <button type="button" class="ddr-f btn btn-secondary btn-block m-3" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
    <!-- <div id="success" name="success" class="alert alert-primary fade" role="alert">
                        <h1>Your entry was input successfully.
                        </div>
                        <div id="error" name="error" class="alert alert-danger fade" role="alert">
                        An error occurred. Your entry was not input. 
                        <p id="e-details" class="mb-0"></p>
                        </div> -->
</div>
<!-- Add DDR Entry Modal -->
<script>
// $(function(){
//     $('#ts').on('input', function(){
//     var ts = $('#ts').val();
//     var te = $('#te').val();
//     // var price = cost - (cost * (discount / 100));
//     if(te < ts)
//     {
//     $('#te').val(ts);
//     }

//     })
// });
</script>
<script type="text/javascript">
    //   $(function () {
    //       $('#puon').datetimepicker({
    //           inline: true,
    //           format: 'HH:mm'
    //       });
    //       $('#puoff').datetimepicker({
    //           inline: true,
    //           format: 'HH:mm',
    //       });
    //   });
    
   </script>
