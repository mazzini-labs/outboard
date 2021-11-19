<!-- Add DDR Entry Modal -->
<!-- to return to normal modal behavior, add the "fade" class to 
the first <div> and remove all css from floating_action_button.php -->
<div class="modal right" id="add_data_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-side modal-top-right" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalPreviewLabel">DDR Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <div class="row mx-auto">
                    <h6>Type:</h6>
                </div> --> 
                <!-- <div class="row"> -->
                <ul class="nav nav-pills nav-fill mb-1" id="pills-tab" role="tablist">
                    <li class="nav-item" id="nav-item-e" role="presentation">
                        <a class="nav-link active" name="eng" id="pills-eng-tab" data-toggle="pill" href="#pills-eng" role="tab" aria-controls="pills-home" aria-selected="true">
                            Engineering</a>
                    </li>
                    <li class="nav-item" id="nav-item-a" role="presentation">
                        <a class="nav-link" name="acct" id="pills-acct-tab" data-toggle="pill" href="#pills-acct" role="tab" aria-controls="pills-profile" aria-selected="false">
                        Accounting</a>
                    </li>
                    <li class="nav-item" id="nav-item-v" role="presentation">
                        <a class="nav-link" name="vend" id="pills-vend-tab" data-toggle="pill" href="#pills-vend" role="tab" aria-controls="pills-contact" aria-selected="false">
                        Vendor</a>
                    </li>
                    <li class="nav-item" id="nav-item-f" role="presentation">
                        <a class="nav-link" name="field" id="pills-field-tab" data-toggle="pill" href="#pills-field" role="tab" aria-controls="pills-contact" aria-selected="false">
                        Field</a>
                    </li>
                </ul>
                <!-- </div> -->
            <!-- </div> -->
            <form id="insert_form" class="ddr" method="POST">
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
                                <span class="input-group-text">Date Entered</span>
                            </div>
                            <input id="de" name="de" type="search" autocomplete="off" class="ddr form-control date datepicker--input mt-4" value="" required>
                            <input name="deb" id="deb" type="hidden" autocomplete="off" class="ddr form-control" placeholder="Your Name" aria-label="Data Entry By" value="<?php echo $currentUser; ?>" required>
                            <!-- <div class="input-group-append">
                                <span class="input-group-text">Person Entering Data</span>
                            </div> -->
                            <div class="w-100"></div>
                            <div class="input-group-prepend mb-2">
                                <span class="input-group-text">Start Time</span>
                            </div>
                            <input type="time" value="08:00" class="ddr form-control" name="ts" id="ts" required>
                            <div class="w-100"></div>
                            <div class="input-group-prepend mb-2">
                                <span class="input-group-text">End Time</span>
                            </div>
                            <input type="time" value="08:00" class="ddr form-control" name="te" id="te"  required>
                        </div>
                        </div>
                        <div class="col-3">
                            <div id="dee" data-date="today"></div>
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
                <div class="modal-body mr--5">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade in show active" id="pills-eng" role="pillpanel">
                            <div class="row mx-auto">
                                <div class="ddr-e input-group input-group-sm mb-1">
                                    <div class="ddr-e input-group-prepend">
                                        <span class="ddr-e input-group-text">Contact Name</span>
                                    </div>
                                    <input name="cvn" id="cvn" type="search" autocomplete="off" class="ddr-e form-control" required>
                                    <input name="cin" id="cin" type="search" autocomplete="off" class="ddr-e form-control">
                                    <div class="ddr-e input-group-append">
                                        <span class="ddr-e input-group-text">Contact Info</span>
                                    </div>
                                </div>
                                <div class="ddr-e mb-1 btn-block">
                                    <label for="drn" class="col-form-label col-form-label-lg" >Daily Report</label>
                                    <!-- <div class="ddr-e input-group-prepend">
                                        <span class="ddr-e input-group-text">Daily Report</span>
                                    </div> -->
                                    <?php if(!isset($_REQUEST["testing"])){ ?>
                                        <!-- <textarea name="drn" id="drn" class="ddr-e form-control-lg" width="100%" aria-label="With textarea"></textarea> -->
                                        <div name="drn" id="drn" class="ddr-e"></div>
                                    <!-- <div data-inline-inject="true" name="drn" id="drn" class="ddr-e form-control"  style="height:12vh!important;"></div> -->
                                        <?php } elseif(isset($_REQUEST["testing"])) { ?>
                                            <!-- <textarea name="drn" id="drn" class="ddr-e form-control" aria-label="With textarea"></textarea> -->
                                            <!-- <div data-inline-inject="true" name="drn" id="drn" class="ddr-e form-control"  style="height:12vh!important;"></div> -->
                                            <div name="drn" id="drn"></div>
                                    <!-- <div data-inline-inject="true" role="textbox" name="drn" id="drn" class="ddr-e form-control" style="height:10vh!important;"></div> -->
                                    <?php } ?>
                                </div>
                                <div class="btn-group btn-group-toggle btn-block mb-2" data-toggle="buttons">
                                    <label class="btn btn-secondary btn-lg active" type="button" >
                                        <input type="radio" name="notes-addition" id="drn-e-none" autocomplete="off" value="none" checked> Do not put on WSB
                                    </label>
                                    <label class="btn btn-secondary btn-lg" type="button" data-toggle="collapse" data-target="#appendSection">
                                        <input type="radio" name="notes-addition" id="drn-e-add" autocomplete="off" value="append"> Append to WSB Notes
                                    </label>
                                    <label class="btn btn-secondary btn-lg" type="button" data-toggle="collapse" data-target="#replaceSection">
                                        <input type="radio" name="notes-addition" id="drn-e-replace" autocomplete="off" value="replace"> Replace WSB Notes
                                    </label>
                                </div>
                                <div class="input-group">
                                    <div id="appendSection" class="collapse btn-block" style="padding-left:0px;">
                                        <div class="alert alert-info" role="alert">
                                            This note will be <strong>appended</strong> to the current note on the WSB
                                        </div>
                                    </div>
                                    <div id="replaceSection" class="collapse btn-block" style="padding-left:0px;">
                                        <div class="alert alert-warning" role="alert">
                                            This note will <strong>replace</strong> the current note on the WSB
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="notes-addition" id="drn-e-add" value="append">
                                    <label class="form-check-label" for="inlineRadio1">Append to WSB Notes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="notes-addition" id="drn-e-replace" value="replace">
                                    <label class="form-check-label" for="inlineRadio2">Replace WSB Notes</label>
                                </div> -->
                                <div class="ddr-e input-group input-group-sm mb-1">
                                    <div class="ddr-e input-group-prepend">
                                        <span class="ddr-e input-group-text">$</span>
                                    </div>
                                    <input name="edc" id="edc" type="search" autocomplete="off" class="ddr-e form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="ddr-e input-group-append">
                                        <span class="ddr-e input-group-text">Estimated Daily Cost</span>
                                    </div>
                                    <div class="ddr-e input-group-prepend">
                                        <span class="ddr-e input-group-text">$</span>
                                    </div>
                                    <input name="ecc" id="ecc" type="search" autocomplete="off" class="ddr-e form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="ddr-e input-group-append">
                                        <span class="ddr-e input-group-text">Estimated Cumulative Cost</span>
                                    </div>
                                    
                                    <input type="hidden" name="d" id="d" class="ddr-e" value="e" />
                                    <input type="hidden" name="t" id="t" class="ddr-e" value="d" />                                  
                                </div>
                                <!-- <hr class="mb-3"> -->
                                <div class="w-100"></div>
                                <br>
                                <h5 class="mx-auto"><strong>Well Vitals</strong></h5>
                                <div class="w-100"></div>
                                <p class="mx-auto">Fill in information here as needed.</p>
                                <div class="w-100"></div>
                                <div class="col">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Flowing Tubing Pressure:</span>
                                        </div>
                                        <input name="ftp" id="ftp" type="search" autocomplete="off" class="form-control" >
                                        <div class="input-group-append">
                                            <span class="input-group-text">psi</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Flowing Casing Pressure:</span>
                                        </div>
                                        <input name="fcp" id="fcp" type="search" autocomplete="off" class="form-control" >
                                        <div class="input-group-append">
                                            <span class="input-group-text">psi</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-100"></div>
                                <div class="col">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Shut In Tubing Pressure:</span>
                                        </div>
                                        <input name="sitp" id="sitp" type="search" autocomplete="off" class="form-control" >
                                        <div class="input-group-append">
                                            <span class="input-group-text">psi</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Shut In Casing Pressure:</span>
                                        </div>
                                        <input name="sicp" id="sicp" type="search" autocomplete="off" class="form-control" >
                                        <div class="input-group-append">
                                            <span class="input-group-text">psi</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-100"></div>
                                
                                
                                <div class="col">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Primary PM</span>
                                        </div>
                                        <select name="pmp" id="pmp" class="form-control">
                                            <option value="">Select...</option>
                                            <option value="1">Pulled Well</option>
                                            <option value="2">Hot Oiled</option>
                                            <option value="3">Chemical Treatment</option>
                                            <option value="4">PM Type 4</option>
                                            <option value="5">PM Type 5</option>
                                            <option value="6">PM Type 6</option>
                                            <option value="7">PM Type 7</option>
                                            <option value="8">PM Type 8</option>
                                            <option value="9">PM Type 9</option>
                                            <option value="10">PM Type 10</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Secondary PM</span>
                                        </div>
                                        <select name="pms" id="pms" class="form-control">
                                            <option value="">Select...</option>
                                            <option value="1">Pulled Well</option>
                                            <option value="2">Hot Oiled</option>
                                            <option value="3">Chemical Treatment</option>
                                            <option value="4">PM Type 4</option>
                                            <option value="5">PM Type 5</option>
                                            <option value="6">PM Type 6</option>
                                            <option value="7">PM Type 7</option>
                                            <option value="8">PM Type 8</option>
                                            <option value="9">PM Type 9</option>
                                            <option value="10">PM Type 10</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="w-100"></div>
                                
                                <div class="col">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">P.PM Amount</span>
                                        </div>
                                        <input name="pmpa" id="pmpa" type="search" autocomplete="off" class="form-control" >
                                        <div class="input-group-append">
                                            <span class="input-group-text">unit</span>
                                        </div>
                                    </div>
                                        
                                </div>
                                <div class="col">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S.PM Amount</span>
                                        </div>
                                        <input name="pmsa" id="pmsa" type="search" autocomplete="off" class="form-control" >
                                        <div class="input-group-append">
                                            <span class="input-group-text">unit</span>
                                        </div>
                                    </div>
                                        
                                </div>
                                
                                <!-- </div> -->
                                <div class="w-100"></div>
                                
                                <div class="col">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                                <span class="input-group-text">Chemical Treatment</span>
                                        </div>
                                        <select name="ct" id="ct" class="form-control">
                                            <option value="">Select...</option>
                                            <option value="1">N/A</option>
                                            <option value="2">Batch</option>
                                            <option value="3">Drip</option>
                                        </select>
                                    </div>
                                    
                                </div>
                                <div class="col">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Pumping Unit Speed</span>
                                        </div>
                                        <input name="pus" id="pus" type="search" autocomplete="off" class="form-control" >
                                        <div class="input-group-append">
                                            <span class="input-group-text">stroke/min</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-100"></div>
                                <div class="col">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Reason for Shut In</span>
                                        </div>
                                        <select name="rsi" id="rsi" class="form-control">
                                            <option value="">Select...</option>
                                            <option value="1">Reason 1</option>
                                            <option value="2">Reason 2</option>
                                            <option value="3">Reason 3</option>
                                            <option value="4">Reason 4</option>
                                            <option value="5">Reason 5</option>
                                            <option value="6">Reason 6</option>
                                            <option value="7">Reason 7</option>
                                            <option value="8">Reason 8</option>
                                            <option value="9">Reason 9</option>
                                            <option value="10">Reason 10</option>
                                        </select>
                                    </div>
                                    
                                </div>
                                <div class="col">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Pumping Unit Stroke Length</span>
                                        </div>
                                        <input name="pusl" id="pusl" type="search" autocomplete="off" class="form-control" >
                                        <div class="input-group-append">
                                            <span class="input-group-text">in</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="w-100"></div>
                                <div class="col">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Comments on SI</span>
                                        </div>
                                        <textarea name="csi" id="csi" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="w-100"></div>
                                <div class="col">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Reason for Pull Job</span>
                                        </div>
                                        <textarea name="rpj" id="rpj" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="w-100"></div>
                                <div class="col">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Injection Pressure</span>
                                        </div>
                                        <input name="injp" id="injp" type="search" class="form-control"></input>
                                        <div class="input-group-append">
                                            <span class="input-group-text">psi</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-100"></div>
                                <div class="col">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Fluid Level</span>
                                        </div>
                                        <input name="fl" id="fl" type="search" autocomplete="off" class="form-control" >
                                        <div class="input-group-append">
                                            <span class="input-group-text">ft</span>
                                        </div>
                                    </div>
                                        
                                </div>
                                <div class="col">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Chlorides:</span>
                                        </div>
                                        <input name="chlr" id="chlr" type="search" autocomplete="off" class="form-control" >
                                        <div class="input-group-append">
                                            <span class="input-group-text">ppm</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-100"></div>
                                <div class="col">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Pumping Unit On Time</span>
                                        </div>
                                        <input name="puon" id="puon" type="hidden" autocomplete="off" value="00:00" class="form-control without_ampm" >
                                    </div>
                                        
                                </div>
                                <div class="col">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Pumping Unit Off Time:</span>
                                        </div>
                                        <input name="puoff" id="puoff" type="hidden" autocomplete="off" value="00:00" class="form-control without_ampm" >
                                    </div>
                                </div>
                                <!-- <div class="input-group-prepend mb-2">
                                    <span class="input-group-text">Pumping Unit On Time</span>
                                </div>
                                <input type="time" value="00:00" class="ddr form-control" name="puon" id="puon" required>
                                <div class="w-100"></div>
                                <div class="input-group-prepend mb-2">
                                    <span class="input-group-text">Pumping Unit Off Time</span>
                                </div>
                                <input type="time" value="00:00" class="ddr form-control" name="puoff" id="puoff"  required> -->
                                <!-- </div> -->

                                </div>
                                <hr class="ddr-e mb-0">
                                <div class="w-100"></div>
                                <div class="row mx-auto">
                                    <div class="ddr-e col input-group p-1">
                                        <input type="submit" name="insert" id="insert" value="Insert" class="ddr-e btn btn-primary btn-block m-3" />
                                    </div>
                                    <div class="ddr-e col p-1">
                                        <button type="button" class="ddr-e btn btn-secondary btn-block m-3" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                        </div>
                        <div class="tab-pane fade" id="pills-acct" role="tabpanel">
                            <div class="row mx-auto">
                                <div class="ddr-a input-group input-group-sm ">
                                    <div class="ddr-a input-group-prepend">
                                        <span class="ddr-a input-group-text">Vendor Name</span>
                                    </div>
                                    <input id="cvn" name="cvn" type="search" autocomplete="off" class="ddr-a form-control" placeholder="Vendor" aria-label="Vendor" required>
                                </div>    
                                <div class="ddr-a input-group input-group-sm">
                                    <div class="ddr-a input-group-prepend">
                                        <span class="ddr-a input-group-text">Invoice #</span>
                                    </div>
                                    <input id="cin" name="cin" type="search" autocomplete="off" class="ddr-a form-control" aria-label="Invoice #" required>
                                    <div class="ddr-a input-group-prepend">
                                        <span class="ddr-a input-group-text">$</span>
                                    </div>
                                    <input id="edc" name="edc" type="search" autocomplete="off" class="ddr-a form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="ddr-a input-group-append">
                                        <span class="ddr-a input-group-text">Invoice Amount</span>
                                    </div>
                                </div>
                                <div class="ddr-a input-group input-group-sm">
                                    <div class="ddr-a input-group-prepend">
                                        <span class="ddr-a input-group-text">Invoice Details</span>
                                    </div>
                                    <textarea id="drn" name="drn" class="ddr-a form-control" aria-label="With textarea"></textarea>
                                    <!-- <div name="drn" id="drn" class="ddr-a"></div> -->
                                </div>
                                <div class="ddr-a input-group input-group-sm">
                                    <div class="ddr-a input-group-prepend">
                                        <span class="ddr-a input-group-text">Approval Initials</span>
                                    </div>
                                    <input id="ai" name="ai" type="search" autocomplete="off" aria-label="Approval Initials" class="ddr-a form-control">
                                    <input id="ad" name="ad" name="acct_approval_date" type="search" autocomplete="off" class="ddr-a form-control date datepicker-input">
                                    <div class="ddr-a input-group-append">
                                        <span class="ddr-a input-group-text">Approval Date</span>
                                    </div>
                                    <input type="hidden" name="d" id="d" class="ddr-a" value="a" />
                                    <input type="hidden" name="t" id="t" class="ddr-a" value="d" />     
                                    
                                </div>
                                <div class="w-100"></div>
                                <div class="row mx-auto">
                                    <div class="ddr-a col input-group p-1">
                                        <input type="submit" name="insert" id="insert" value="Insert" class="ddr-a btn btn-primary btn-block m-3" />
                                    </div>
                                    <div class="ddr-a col p-1">
                                        <button type="button" class="ddr-a btn btn-secondary btn-block m-3" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-vend" role="tabpanel">	
                            <div class="row mx-auto">	
                            <!-- <form id="insert_form-v" method="POST"> -->
                                <div class="ddr-v input-group input-group-sm">
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">Vendor Name</span>
                                    </div>
                                    <input id="cvn" name="cvn" type="search" autocomplete="off" class="ddr-v form-control" required>
                                    <input id="cin" name="cin" type="search" autocomplete="off" class="ddr-v form-control" required>
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Vendor Service</span>
                                    </div>
                                </div>
                                <div class="ddr-v input-group input-group-sm">
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">Vendor Notes</span>
                                    </div>
                                    <!-- <textarea id="drn" name="drn" class="ddr-v form-control" aria-label="With textarea" required></textarea> -->
                                    <div name="drn" id="drn" class="ddr-v"></div>
                                </div>
                                <div class="ddr-v input-group input-group-sm">
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">$</span>
                                    </div>
                                    <input id="edc" name="edc" type="search" autocomplete="off" class="ddr-v form-control" aria-label="Vendor Adjusted Hours" required>
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">/Hour</span>
                                    </div>
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Vendor Rate</span>
                                    </div>
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">$</span>
                                    </div>
                                    <input id="ac" name="ac" type="search" autocomplete="off" class="ddr-v form-control" aria-label="Vendor Adjusted Hours">
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Adjusted Cost</span>
                                    </div>
                                </div>
                                <div class="ddr-v input-group input-group-sm">
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">$</span>
                                    </div>
                                    <input id="dc" name="dc" type="search" autocomplete="off" class="ddr-v form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Deducted Cost</span>
                                    </div>
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">$</span>
                                    </div>
                                    <input id="ecc" name="ecc" type="search" autocomplete="off" class="ddr-v form-control" aria-label="Amount (to the nearest dollar)"  required>
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Total Cost</span>
                                    </div>
                                </div>
                                <div class="ddr-v input-group input-group-sm">
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">Adjusted Time</span>
                                    </div>
                                    <input id="at" name="at" type="search" autocomplete="off" class="ddr-v form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Hour(s)</span>
                                    </div>
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">Estimated Travel</span>
                                    </div>
                                    <input id="et" name="et" type="search" autocomplete="off" class="ddr-v form-control" aria-label="Vendor Adjusted Hours">
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Hour(s)</span>
                                    </div>
                                </div>
                                <div class="ddr-v input-group input-group-sm">
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">Deducted Time</span>
                                    </div>
                                    <input id="dt" name="dt" type="search" autocomplete="off" class="ddr-v form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Hour(s)</span>
                                    </div>
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">Total Time</span>
                                    </div>
                                    <input id="tt" name="tt" type="search" autocomplete="off" class="ddr-v form-control" aria-label="Amount (to the nearest dollar)"  required>
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Hour(s)</span>
                                    </div>
                                    <input type="hidden" name="d" id="d" class="ddr-v" value="v" />
                                    <input type="hidden" name="t" id="t" class="ddr-v" value="d" />     
                                </div>
                                <div class="w-100"></div>
                                <div class="row mx-auto">
                                    <div class="ddr-v col input-group p-1">
                                        <input type="submit" name="insert" id="insert" value="Insert" class="ddr-v btn btn-primary btn-block m-3" />
                                    </div>
                                    <div class="ddr-v col p-1">
                                        <button type="button" class="ddr-v btn btn-secondary btn-block m-3" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-field" role="tabpanel">
                            <div class="row mx-auto">
                            <!-- <form id="insert_form-f" method="POST"> -->
                                <div class="ddr-f input-group input-group-sm">
                                    <div class="ddr-f input-group-prepend">
                                        <span class="ddr-f input-group-text">Contact Name</span>
                                    </div>
                                    <input id="cvn" name="cvn" type="search" autocomplete="off" class="ddr-f form-control" required>
                                    <input id="cin" name="cin" type="search" autocomplete="off" class="ddr-f form-control">
                                    <div class="ddr-f input-group-append">
                                        <span class="ddr-f input-group-text">Contact Info</span>
                                    </div>
                                </div>
                                <div class="ddr-f input-group input-group-sm">
                                    <div class="ddr-f input-group-prepend">
                                        <span class="ddr-f input-group-text">Daily Report</span>
                                    </div>
                                    <!-- <textarea id="drn" name="drn" class="ddr-f form-control" aria-label="With textarea" required></textarea> -->
                                    <div name="drn" id="drn" class="ddr-f"></div>
                                </div>
                                <div class="ddr-f input-group input-group-sm">
                                    <div class="ddr-f input-group-prepend">
                                        <span class="ddr-f input-group-text">$</span>
                                    </div>
                                    <input id="edc" name="edc" type="search" autocomplete="off" class="ddr-f form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="ddr-f input-group-append">
                                        <span class="ddr-f input-group-text">Estimated Daily Cost</span>
                                    </div>
                                    <div class="ddr-f input-group-prepend">
                                        <span class="ddr-f input-group-text">$</span>
                                    </div>
                                    <input id="ecc" name="ecc" type="search" autocomplete="off" class="ddr-f form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="ddr-f input-group-append">
                                        <span class="ddr-f input-group-text">Estimated Cumulative Cost</span>
                                    </div>
                                </div>
                                    <input type="hidden" name="d" id="d" class="ddr-f" value="f" />
                                    <input type="hidden" name="t" id="t" class="ddr-f" value="d" />     
                                    
                                <div class="w-100"></div>
                                <div class="row mx-auto">
                                    <div class="ddr-f col input-group p-1">
                                        <input type="submit" name="insert" id="insert" value="Insert" class="ddr-f btn btn-primary btn-block m-3" />
                                    </div>
                                    <div class="ddr-f col p-1">
                                        <button type="button" class="ddr-f btn btn-secondary btn-block m-3" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
    <div id="success" name="success" class="alert alert-primary fade" role="alert">
                        <h1>Your entry was input successfully.
                        </div>
                        <div id="error" name="error" class="alert alert-danger fade" role="alert">
                        An error occurred. Your entry was not input. 
                        <p id="e-details" class="mb-0"></p>
                        </div>
</div>
<!-- Add DDR Entry Modal -->
<script>
$(function(){
    $('#ts').on('input', function(){
    var ts = $('#ts').val();
    var te = $('#te').val();
    // var price = cost - (cost * (discount / 100));
    if(te < ts)
    {
    $('#te').val(ts);
    }

    })
});
</script>
<script type="text/javascript">
      $(function () {
          $('#puon').datetimepicker({
              inline: true,
              format: 'HH:mm'
          });
          $('#puoff').datetimepicker({
              inline: true,
              format: 'HH:mm',
          });
      });
    
   </script>
<?php if(isset($_REQUEST["ck"])) { ?>
   <style>
       :root {
    --ck-z-default: 100;
    --ck-z-modal: calc( var(--ck-z-default) + 999 );
}</style>
   <script>
const editor = InlineEditor
        .create( document.querySelector( '#drn' ), 
        {
            // toolbar: [ 'bold', 'italic', 'link', 'undo', 'redo', 'bulletedList', 'numberedList', 'blockQuote' ],
        } )
        .then( editor => {
                console.log( editor );
        } )
        .catch( error => {
                console.error( error );
        } );
        $( '#add_data_Modal' ).modal( {
    focus: false
} );
                </script>
<?php  } elseif(isset($_REQUEST["quill"])) { ?>

<script>

</script>

    <!-- <script>
$('#drn').wysiwyg({
    mode: 'source'
});
</script> -->
<?php } else { ?> 
    <!-- <script>var editor = new MediumEditor('#drn');</script> -->
    <!-- <style>
    .tox-tinymce-aux {
    position: relative !important;
    z-index: 1600;
}
.mce-menu {position:fixed !important}

.tox.tox-tinymce.tox-tinymce-inline.tox-tinymce--toolbar-sticky-off { z-index: 9999; }
</style> -->
   <!-- <script src='https://cdn.tiny.cloud/1/bjmod15e4rkx2edid4tsartmjlavpk87nhgl8wr63avtsy84/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
   <script src='https://cdn.tiny.cloud/1/bjmod15e4rkx2edid4tsartmjlavpk87nhgl8wr63avtsy84/tinymce/5/jquery.tinymce.min.js' referrerpolicy="origin"></script>
<script>tinymce.init({
    //selector: '#body',
    selector: "textarea",
    // selector: "#drn",
    width: '100%',
    // inline: true,
	// skin_url: '../ed/skins/ui/CUSTOM',
// 	images_upload_url: 'uploadhandler.php',
// 	images_upload_base_path: '../../images/community/',
// 	images_upload_credentials: true,
// 	images_upload_handler: function (blobInfo, success, failure) {
// 	var xhr, formData;

// 	xhr = new XMLHttpRequest();
// 	xhr.withCredentials = false;
// 	xhr.open('POST', 'uploadhandler.php');

// 	xhr.onload = function() {
// 	  var json;

// 	  if (xhr.status < 200 || xhr.status >= 300) {
// 		failure('HTTP Error: ' + xhr.status);
// 		return;
// 	  }

// 	  json = JSON.parse(xhr.responseText);

// 	  if (!json || typeof json.location != 'string') {
// 		failure('Invalid JSON: ' + xhr.responseText);
// 		return;
// 	  }

// 	  success(json.location);
// 	};

// 	formData = new FormData();
// 	//formData.append('file', blobInfo.blob(), fileName(blobInfo));
// 		formData.append('file', blobInfo.blob(), blobInfo.filename());
// 	xhr.send(formData);
//   },

	plugins: [
      'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
      'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
      'table emoticons template paste help quickbars'
    ],
	mobile: {
		plugins: 'print preview powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen image link media mediaembed template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker textpattern noneditable help formatpainter pageembed charmap mentions quickbars linkchecker emoticons advtable'
	  },
	toolbar:
    "insertfile code undo redo | bold italic | forecolor backcolor | template codesample | alignleft aligncenter alignright alignjustify | bullist numlist | link image tinydrive",
    toolbar_mode: 'floating',
	quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
});</script> -->
<script>


</script>
<?php } ?>
<!-- <script>
  
    tinymce.init({
            selector: '#drn',

            // Enables inline mode which edits the page's DOM directly.
            // You have to wire up the persistent storage yourself, for example
            // getting the editable area's DOM tree, serlialize it and send it
            // to the backend using a hidden inputfield.
            // https://www.tiny.cloud/docs/configure/editor-appearance/#inline
            inline: true,

            // Tip! To make TinyMCE leaner, only include the plugins you actually need.
            plugins: 'anchor autolink link code',

            // This option allows you to specify the buttons and the order that
            // they will appear on TinyMCE’s toolbar.
            // https://www.tiny.cloud/docs/configure/editor-appearance/#toolbar
            toolbar: 'formatselect | bold italic strikethrough backcolor link | code',

            // Toggle the menubar off to get a leaner visual experience
            // https://www.tiny.cloud/docs/configure/editor-appearance/#menubar
            menubar: false,

            // Text to show when the editor is empty
            // https://www.tiny.cloud/docs/configure/editor-appearance/#placeholder
            placeholder: 'Page body'
        });
        // Prevent Bootstrap dialog from blocking focusin


    </script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/autosize@4.0.2/dist/autosize.min.js" integrity="sha256-dW8u4dvEKDThJpWRwLgGugbARnA3O2wqBcVerlg9LMc=" crossorigin="anonymous"></script> -->