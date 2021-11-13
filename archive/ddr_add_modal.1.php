
<section class="drawer" id="add_data_Modal" data-drawer-target>
    <div class="drawer__overlay" data-drawer-close tabindex="-1"></div>
    <div class="drawer__wrapper">
        <div class="drawer__header">
        <div class="drawer__title">
            Well Entry
        </div>
        <button class="drawer__close" data-drawer-close aria-label="Close Drawer"></button>
    </div>
    <div class="drawer__content">
        <div class="modal-body">
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

        </div>
        <form id="insert_form" class="ddr" method="POST">
            <div class="modal-body mr-5">
                <div class="row mx-auto">
                    <div class="form-group mx-auto">
                        <select id="add_data_select" class="ddr selectpicker form-control" data-live-search="true" data-width="auto" data-size="5" name="api" size="1" title="Select Well..." data-style="btn-primary btn-lg">
                        <?php
                            
                            $table = "list";
                            $sql = "SELECT api, entity_common_name FROM $table";// ORDER BY well_lease ASC";
                            $result = mysqli_query($mysqli,$sql) or die(mysql_error());
                                //console_log($result);
                            ?>
                            <?php 
                            while ($row = mysqli_fetch_array($result)) {
                                $wellname = $row['entity_common_name'];
                                $conditional = ($row['api'] == $apino) ?  '"' . $row['api'] . '" selected' :  '"' . $row['api'] . '"';
                                
                                ?>
                            <option name="api" id="api" value=<?php echo $conditional;  ?> data-token=<?php echo $conditional;  ?>><?php echo $wellname; //$row['api']; // . $row['well_no'];?></option> 
                        <?php } ?>
                            </select> 
                    </div>
                    <div class="input-group input-group-sm mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Date Entered</span>
                        </div>
                        <input id="de" name="de" type="text" class="ddr form-control date datepicker-input" value="" required>
                        <input name="deb" id="deb" type="text" class="ddr form-control" placeholder="Your Name" aria-label="Data Entry By" required>
                        <div class="input-group-append">
                            <span class="input-group-text">Person Entering Data</span>
                        </div>
                    </div>
                    <div class="input-group input-group-sm mb-0">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Start Time</span>
                        </div>
                        <input type="time" value="08:00" step="600" class="ddr form-control" name="ts" id="ts" required>
                        <input type="time" value="08:00" step="600" class="ddr form-control" name="te" id="te" required>
                        <div class="input-group-append">
                            <span class="input-group-text">End Time</span>
                        </div>
                    </div>
                    <input type="hidden" name="id" id="id" class="ddr"/>
                </div>
            </div>
            <div class="modal-body mr-5">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade in show active" id="pills-eng" role="pillpanel">
                        <div class="row mx-auto">
                            <div class="ddr-e input-group input-group-sm mb-1">
                                <div class="ddr-e input-group-prepend">
                                    <span class="ddr-e input-group-text">Contact Name</span>
                                </div>
                                <input name="cvn" id="cvn" type="text" class="ddr-e form-control" required>
                                <input name="cin" id="cin" type="text" class="ddr-e form-control">
                                <div class="ddr-e input-group-append">
                                    <span class="ddr-e input-group-text">Contact Info</span>
                                </div>
                            </div>
                            <div class="ddr-e input-group input-group-sm mb-1">
                                <div class="ddr-e input-group-prepend">
                                    <span class="ddr-e input-group-text">Daily Report</span>
                                </div>
                                <textarea name="drn" id="drn" class="ddr-e form-control" aria-label="With textarea" required></textarea>
                            </div>
                            <div class="ddr-e input-group input-group-sm mb-1">
                                <div class="ddr-e input-group-prepend">
                                    <span class="ddr-e input-group-text">$</span>
                                </div>
                                <input name="edc" id="edc" type="text" class="ddr-e form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="ddr-e input-group-append">
                                    <span class="ddr-e input-group-text">Estimated Daily Cost</span>
                                </div>
                                <div class="ddr-e input-group-prepend">
                                    <span class="ddr-e input-group-text">$</span>
                                </div>
                                <input name="ecc" id="ecc" type="text" class="ddr-e form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="ddr-e input-group-append">
                                    <span class="ddr-e input-group-text">Estimated Cumulative Cost</span>
                                </div>
                                
                                <input type="hidden" name="d" id="d" class="ddr-e" value="e" />
                                <input type="hidden" name="t" id="t" class="ddr-e" value="d" />                                  
                            </div>
                            <div class="w-100"></div>
                            
                            <h5 class="mx-auto"><strong>Well Vitals</strong></h5>
                            <div class="w-100"></div>
                            <p class="mx-auto">Fill in information here as needed.</p>
                            <div class="w-100"></div>
                                <div class="col">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Flowing Tubing Pressure:</span>
                                        </div>
                                        <input name="ftp" id="ftp" type="text" class="form-control" >
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
                                        <input name="fcp" id="fcp" type="text" class="form-control" >
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
                                        <input name="sitp" id="sitp" type="text" class="form-control" >
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
                                        <input name="sicp" id="sicp" type="text" class="form-control" >
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
                                        <input name="pmpa" id="pmpa" type="text" class="form-control" >
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
                                        <input name="pmsa" id="pmsa" type="text" class="form-control" >
                                        <div class="input-group-append">
                                            <span class="input-group-text">unit</span>
                                        </div>
                                    </div>
                                        
                                </div>
                                
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
                                        <input name="pus" id="pus" type="text" class="form-control" >
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
                                        <input name="pusl" id="pusl" type="text" class="form-control" >
                                        <div class="input-group-append">
                                            <span class="input-group-text">ft</span>
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
                                            <span class="input-group-text">Fluid Level</span>
                                        </div>
                                        <input name="fl" id="fl" type="text" class="form-control" >
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
                                        <input name="chlr" id="chlr" type="text" class="form-control" >
                                        <div class="input-group-append">
                                            <span class="input-group-text">ppm</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr class="ddr-e mb-0">
                            <div class="ddr-e input-group p-1">
                                <input type="submit" name="insert" id="insert" value="Insert" class="ddr-e btn btn-success m-3" />
                                <button type="button" class="ddr-e btn btn-secondary m-3" data-dismiss="modal">Close</button>
                            </div>
                    </div>
                    <div class="tab-pane fade" id="pills-acct" role="tabpanel">
                        <div class="row mx-auto">
                            <div class="ddr-a input-group input-group-sm ">
                                <div class="ddr-a input-group-prepend">
                                    <span class="ddr-a input-group-text">Vendor Name</span>
                                </div>
                                <input id="cvn" name="cvn" type="text" class="ddr-a form-control" placeholder="Vendor" aria-label="Vendor" required>
                            </div>    
                            <div class="ddr-a input-group input-group-sm">
                                <div class="ddr-a input-group-prepend">
                                    <span class="ddr-a input-group-text">Invoice #</span>
                                </div>
                                <input id="cin" name="cin" type="text" class="ddr-a form-control" aria-label="Invoice #" required>
                                <div class="ddr-a input-group-prepend">
                                    <span class="ddr-a input-group-text">$</span>
                                </div>
                                <input id="edc" name="edc" type="text" class="ddr-a form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="ddr-a input-group-append">
                                    <span class="ddr-a input-group-text">Invoice Amount</span>
                                </div>
                            </div>
                            <div class="ddr-a input-group input-group-sm">
                                <div class="ddr-a input-group-prepend">
                                    <span class="ddr-a input-group-text">Invoice Details</span>
                                </div>
                                <textarea id="drn" name="drn" class="ddr-a form-control" aria-label="With textarea"></textarea>
                            </div>
                            <div class="ddr-a input-group input-group-sm">
                                <div class="ddr-a input-group-prepend">
                                    <span class="ddr-a input-group-text">Approval Initials</span>
                                </div>
                                <input id="ai" name="ai" type="text" aria-label="Approval Initials" class="ddr-a form-control">
                                <input id="ad" name="ad" name="acct_approval_date" type="text" class="ddr-a form-control date datepicker-input">
                                <div class="ddr-a input-group-append">
                                    <span class="ddr-a input-group-text">Approval Date</span>
                                </div>
                                <input type="hidden" name="d" id="d" class="ddr-a" value="a" />
                                <input type="hidden" name="t" id="t" class="ddr-a" value="d" />     
                                
                            </div>
                            
                            <hr class="ddr-a mb-0">
                            <div class="ddr-a input-group p-1">
                                <input type="submit" name="insert" id="insert" value="Insert" class="ddr-a btn btn-success m-3" />
                                <button type="button" class="ddr-a btn btn-secondary m-3" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-vend" role="tabpanel">	
                        <div class="row mx-auto">	
                            <div class="ddr-v input-group input-group-sm">
                                <div class="ddr-v input-group-prepend">
                                    <span class="ddr-v input-group-text">Vendor Name</span>
                                </div>
                                <input id="cvn" name="cvn" type="text" class="ddr-v form-control" required>
                                <input id="cin" name="cin" type="text" class="ddr-v form-control" required>
                                <div class="ddr-v input-group-append">
                                    <span class="ddr-v input-group-text">Vendor Service</span>
                                </div>
                            </div>
                            <div class="ddr-v input-group input-group-sm">
                                <div class="ddr-v input-group-prepend">
                                    <span class="ddr-v input-group-text">Vendor Notes</span>
                                </div>
                                <textarea id="drn" name="drn" class="ddr-v form-control" aria-label="With textarea" required></textarea>
                            </div>
                            <div class="ddr-v input-group input-group-sm">
                                <div class="ddr-v input-group-prepend">
                                    <span class="ddr-v input-group-text">$</span>
                                </div>
                                <input id="edc" name="edc" type="text" class="ddr-v form-control" aria-label="Vendor Adjusted Hours" required>
                                <div class="ddr-v input-group-append">
                                    <span class="ddr-v input-group-text">/Hour</span>
                                </div>
                                <div class="ddr-v input-group-append">
                                    <span class="ddr-v input-group-text">Vendor Rate</span>
                                </div>
                                <div class="ddr-v input-group-prepend">
                                    <span class="ddr-v input-group-text">$</span>
                                </div>
                                <input id="ac" name="ac" type="text" class="ddr-v form-control" aria-label="Vendor Adjusted Hours">
                                <div class="ddr-v input-group-append">
                                    <span class="ddr-v input-group-text">Adjusted Cost</span>
                                </div>
                            </div>
                            <div class="ddr-v input-group input-group-sm">
                                <div class="ddr-v input-group-prepend">
                                    <span class="ddr-v input-group-text">$</span>
                                </div>
                                <input id="dc" name="dc" type="text" class="ddr-v form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="ddr-v input-group-append">
                                    <span class="ddr-v input-group-text">Deducted Cost</span>
                                </div>
                                <div class="ddr-v input-group-prepend">
                                    <span class="ddr-v input-group-text">$</span>
                                </div>
                                <input id="ecc" name="ecc" type="text" class="ddr-v form-control" aria-label="Amount (to the nearest dollar)"  required>
                                <div class="ddr-v input-group-append">
                                    <span class="ddr-v input-group-text">Total Cost</span>
                                </div>
                            </div>
                            <div class="ddr-v input-group input-group-sm">
                                <div class="ddr-v input-group-prepend">
                                    <span class="ddr-v input-group-text">Adjusted Time</span>
                                </div>
                                <input id="at" name="at" type="text" class="ddr-v form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="ddr-v input-group-append">
                                    <span class="ddr-v input-group-text">Hour(s)</span>
                                </div>
                                <div class="ddr-v input-group-prepend">
                                    <span class="ddr-v input-group-text">Estimated Travel</span>
                                </div>
                                <input id="et" name="et" type="text" class="ddr-v form-control" aria-label="Vendor Adjusted Hours">
                                <div class="ddr-v input-group-append">
                                    <span class="ddr-v input-group-text">Hour(s)</span>
                                </div>
                            </div>
                            <div class="ddr-v input-group input-group-sm">
                                <div class="ddr-v input-group-prepend">
                                    <span class="ddr-v input-group-text">Deducted Time</span>
                                </div>
                                <input id="dt" name="dt" type="text" class="ddr-v form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="ddr-v input-group-append">
                                    <span class="ddr-v input-group-text">Hour(s)</span>
                                </div>
                                <div class="ddr-v input-group-prepend">
                                    <span class="ddr-v input-group-text">Total Time</span>
                                </div>
                                <input id="tt" name="tt" type="text" class="ddr-v form-control" aria-label="Amount (to the nearest dollar)"  required>
                                <div class="ddr-v input-group-append">
                                    <span class="ddr-v input-group-text">Hour(s)</span>
                                </div>
                                <input type="hidden" name="d" id="d" class="ddr-v" value="v" />
                                <input type="hidden" name="t" id="t" class="ddr-v" value="d" />     
                            </div>
                            <hr class="ddr-v mb-0">
                            <div class="ddr-v input-group p-1">
                                <input type="submit" name="insert" id="insert" value="Insert" class="ddr-v btn btn-success m-3" />
                                <button type="button" class="ddr-v btn btn-secondary m-3" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-field" role="tabpanel">
                        <div class="row mx-auto">
                            <div class="ddr-f input-group input-group-sm">
                                <div class="ddr-f input-group-prepend">
                                    <span class="ddr-f input-group-text">Contact Name</span>
                                </div>
                                <input id="cvn" name="cvn" type="text" class="ddr-f form-control" required>
                                <input id="cin" name="cin" type="text" class="ddr-f form-control">
                                <div class="ddr-f input-group-append">
                                    <span class="ddr-f input-group-text">Contact Info</span>
                                </div>
                            </div>
                            <div class="ddr-f input-group input-group-sm">
                                <div class="ddr-f input-group-prepend">
                                    <span class="ddr-f input-group-text">Daily Report</span>
                                </div>
                                <textarea id="drn" name="drn" class="ddr-f form-control" aria-label="With textarea" required></textarea>
                            </div>
                            <div class="ddr-f input-group input-group-sm">
                                <div class="ddr-f input-group-prepend">
                                    <span class="ddr-f input-group-text">$</span>
                                </div>
                                <input id="edc" name="edc" type="text" class="ddr-f form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="ddr-f input-group-append">
                                    <span class="ddr-f input-group-text">Estimated Daily Cost</span>
                                </div>
                                <div class="ddr-f input-group-prepend">
                                    <span class="ddr-f input-group-text">$</span>
                                </div>
                                <input id="ecc" name="ecc" type="text" class="ddr-f form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="ddr-f input-group-append">
                                    <span class="ddr-f input-group-text">Estimated Cumulative Cost</span>
                                </div>
                            </div>
                                <input type="hidden" name="d" id="d" class="ddr-f" value="f" />
                                <input type="hidden" name="t" id="t" class="ddr-f" value="d" />     
                                
                            <hr class="ddr-f mb-0">
                            <div class="ddr-f input-group p-1">
                                <input type="submit" name="insert" id="insert" value="Insert" class="ddr-f btn btn-success m-3" />
                                <button type="button" class="ddr-f btn btn-secondary m-3" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
  </div>
</section>
<!-- Add DDR Entry Modal -->
<!-- <div class="modal fade right" id="add_data_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-side modal-top-right" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalPreviewLabel">DDR Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
            </div>
            <form id="insert_form" class="ddr" method="POST">
                <div class="modal-body mr-5">
                    <div class="row mx-auto">
                        <div class="form-group mx-auto">
                            <select id="add_data_select" class="ddr selectpicker form-control" data-live-search="true" data-width="auto" data-size="5" name="api" size="1" title="Select Well..." data-style="btn-primary btn-lg">
                            <?php
                                
                                $table = "list";
                                $sql = "SELECT api, entity_common_name FROM $table";// ORDER BY well_lease ASC";
                                $result = mysqli_query($mysqli,$sql) or die(mysql_error());
                                    //console_log($result);
                                ?>
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
                        <div class="input-group input-group-sm mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Date Entered</span>
                            </div>
                            <input id="de" name="de" type="text" class="ddr form-control date datepicker-input" value="" required>
                            <input name="deb" id="deb" type="text" class="ddr form-control" placeholder="Your Name" aria-label="Data Entry By" required>
                            <div class="input-group-append">
                                <span class="input-group-text">Person Entering Data</span>
                            </div>
                        </div>
                        <div class="input-group input-group-sm mb-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Start Time</span>
                            </div>
                            <input type="time" value="08:00" step="600" class="ddr form-control" name="ts" id="ts" required>
                            <input type="time" value="08:00" step="600" class="ddr form-control" name="te" id="te" required>
                            <div class="input-group-append">
                                <span class="input-group-text">End Time</span>
                            </div>
                        </div>
                        <input type="hidden" name="id" id="id" class="ddr"/>
                    </div>
                </div>
                <div class="modal-body mr-5">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade in show active" id="pills-eng" role="pillpanel">
                            <div class="row mx-auto">
                                <div class="ddr-e input-group input-group-sm mb-1">
                                    <div class="ddr-e input-group-prepend">
                                        <span class="ddr-e input-group-text">Contact Name</span>
                                    </div>
                                    <input name="cvn" id="cvn" type="text" class="ddr-e form-control" required>
                                    <input name="cin" id="cin" type="text" class="ddr-e form-control">
                                    <div class="ddr-e input-group-append">
                                        <span class="ddr-e input-group-text">Contact Info</span>
                                    </div>
                                </div>
                                <div class="ddr-e input-group input-group-sm mb-1">
                                    <div class="ddr-e input-group-prepend">
                                        <span class="ddr-e input-group-text">Daily Report</span>
                                    </div>
                                    <textarea name="drn" id="drn" class="ddr-e form-control" aria-label="With textarea" required></textarea>
                                </div>
                                <div class="ddr-e input-group input-group-sm mb-1">
                                    <div class="ddr-e input-group-prepend">
                                        <span class="ddr-e input-group-text">$</span>
                                    </div>
                                    <input name="edc" id="edc" type="text" class="ddr-e form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="ddr-e input-group-append">
                                        <span class="ddr-e input-group-text">Estimated Daily Cost</span>
                                    </div>
                                    <div class="ddr-e input-group-prepend">
                                        <span class="ddr-e input-group-text">$</span>
                                    </div>
                                    <input name="ecc" id="ecc" type="text" class="ddr-e form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="ddr-e input-group-append">
                                        <span class="ddr-e input-group-text">Estimated Cumulative Cost</span>
                                    </div>
                                    
                                    <input type="hidden" name="d" id="d" class="ddr-e" value="e" />
                                    <input type="hidden" name="t" id="t" class="ddr-e" value="d" />                                  
                                </div>
                                <div class="w-100"></div>
                                
                                <h5 class="mx-auto"><strong>Well Vitals</strong></h5>
                                <div class="w-100"></div>
                                <p class="mx-auto">Fill in information here as needed.</p>
                                <div class="w-100"></div>
                                    <div class="col">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Flowing Tubing Pressure:</span>
                                            </div>
                                            <input name="ftp" id="ftp" type="text" class="form-control" >
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
                                            <input name="fcp" id="fcp" type="text" class="form-control" >
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
                                            <input name="sitp" id="sitp" type="text" class="form-control" >
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
                                            <input name="sicp" id="sicp" type="text" class="form-control" >
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
                                            <input name="pmpa" id="pmpa" type="text" class="form-control" >
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
                                            <input name="pmsa" id="pmsa" type="text" class="form-control" >
                                            <div class="input-group-append">
                                                <span class="input-group-text">unit</span>
                                            </div>
                                        </div>
                                            
                                    </div>
                                    
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
                                            <input name="pus" id="pus" type="text" class="form-control" >
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
                                            <input name="pusl" id="pusl" type="text" class="form-control" >
                                            <div class="input-group-append">
                                                <span class="input-group-text">ft</span>
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
                                                <span class="input-group-text">Fluid Level</span>
                                            </div>
                                            <input name="fl" id="fl" type="text" class="form-control" >
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
                                            <input name="chlr" id="chlr" type="text" class="form-control" >
                                            <div class="input-group-append">
                                                <span class="input-group-text">ppm</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <hr class="ddr-e mb-0">
                                <div class="ddr-e input-group p-1">
                                    <input type="submit" name="insert" id="insert" value="Insert" class="ddr-e btn btn-success m-3" />
                                    <button type="button" class="ddr-e btn btn-secondary m-3" data-dismiss="modal">Close</button>
                                </div>
                        </div>
                        <div class="tab-pane fade" id="pills-acct" role="tabpanel">
                            <div class="row mx-auto">
                                <div class="ddr-a input-group input-group-sm ">
                                    <div class="ddr-a input-group-prepend">
                                        <span class="ddr-a input-group-text">Vendor Name</span>
                                    </div>
                                    <input id="cvn" name="cvn" type="text" class="ddr-a form-control" placeholder="Vendor" aria-label="Vendor" required>
                                </div>    
                                <div class="ddr-a input-group input-group-sm">
                                    <div class="ddr-a input-group-prepend">
                                        <span class="ddr-a input-group-text">Invoice #</span>
                                    </div>
                                    <input id="cin" name="cin" type="text" class="ddr-a form-control" aria-label="Invoice #" required>
                                    <div class="ddr-a input-group-prepend">
                                        <span class="ddr-a input-group-text">$</span>
                                    </div>
                                    <input id="edc" name="edc" type="text" class="ddr-a form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="ddr-a input-group-append">
                                        <span class="ddr-a input-group-text">Invoice Amount</span>
                                    </div>
                                </div>
                                <div class="ddr-a input-group input-group-sm">
                                    <div class="ddr-a input-group-prepend">
                                        <span class="ddr-a input-group-text">Invoice Details</span>
                                    </div>
                                    <textarea id="drn" name="drn" class="ddr-a form-control" aria-label="With textarea"></textarea>
                                </div>
                                <div class="ddr-a input-group input-group-sm">
                                    <div class="ddr-a input-group-prepend">
                                        <span class="ddr-a input-group-text">Approval Initials</span>
                                    </div>
                                    <input id="ai" name="ai" type="text" aria-label="Approval Initials" class="ddr-a form-control">
                                    <input id="ad" name="ad" name="acct_approval_date" type="text" class="ddr-a form-control date datepicker-input">
                                    <div class="ddr-a input-group-append">
                                        <span class="ddr-a input-group-text">Approval Date</span>
                                    </div>
                                    <input type="hidden" name="d" id="d" class="ddr-a" value="a" />
                                    <input type="hidden" name="t" id="t" class="ddr-a" value="d" />     
                                    
                                </div>
                                
                                <hr class="ddr-a mb-0">
                                <div class="ddr-a input-group p-1">
                                    <input type="submit" name="insert" id="insert" value="Insert" class="ddr-a btn btn-success m-3" />
                                    <button type="button" class="ddr-a btn btn-secondary m-3" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-vend" role="tabpanel">	
                            <div class="row mx-auto">	
                                <div class="ddr-v input-group input-group-sm">
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">Vendor Name</span>
                                    </div>
                                    <input id="cvn" name="cvn" type="text" class="ddr-v form-control" required>
                                    <input id="cin" name="cin" type="text" class="ddr-v form-control" required>
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Vendor Service</span>
                                    </div>
                                </div>
                                <div class="ddr-v input-group input-group-sm">
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">Vendor Notes</span>
                                    </div>
                                    <textarea id="drn" name="drn" class="ddr-v form-control" aria-label="With textarea" required></textarea>
                                </div>
                                <div class="ddr-v input-group input-group-sm">
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">$</span>
                                    </div>
                                    <input id="edc" name="edc" type="text" class="ddr-v form-control" aria-label="Vendor Adjusted Hours" required>
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">/Hour</span>
                                    </div>
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Vendor Rate</span>
                                    </div>
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">$</span>
                                    </div>
                                    <input id="ac" name="ac" type="text" class="ddr-v form-control" aria-label="Vendor Adjusted Hours">
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Adjusted Cost</span>
                                    </div>
                                </div>
                                <div class="ddr-v input-group input-group-sm">
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">$</span>
                                    </div>
                                    <input id="dc" name="dc" type="text" class="ddr-v form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Deducted Cost</span>
                                    </div>
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">$</span>
                                    </div>
                                    <input id="ecc" name="ecc" type="text" class="ddr-v form-control" aria-label="Amount (to the nearest dollar)"  required>
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Total Cost</span>
                                    </div>
                                </div>
                                <div class="ddr-v input-group input-group-sm">
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">Adjusted Time</span>
                                    </div>
                                    <input id="at" name="at" type="text" class="ddr-v form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Hour(s)</span>
                                    </div>
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">Estimated Travel</span>
                                    </div>
                                    <input id="et" name="et" type="text" class="ddr-v form-control" aria-label="Vendor Adjusted Hours">
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Hour(s)</span>
                                    </div>
                                </div>
                                <div class="ddr-v input-group input-group-sm">
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">Deducted Time</span>
                                    </div>
                                    <input id="dt" name="dt" type="text" class="ddr-v form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Hour(s)</span>
                                    </div>
                                    <div class="ddr-v input-group-prepend">
                                        <span class="ddr-v input-group-text">Total Time</span>
                                    </div>
                                    <input id="tt" name="tt" type="text" class="ddr-v form-control" aria-label="Amount (to the nearest dollar)"  required>
                                    <div class="ddr-v input-group-append">
                                        <span class="ddr-v input-group-text">Hour(s)</span>
                                    </div>
                                    <input type="hidden" name="d" id="d" class="ddr-v" value="v" />
                                    <input type="hidden" name="t" id="t" class="ddr-v" value="d" />     
                                </div>
                                <hr class="ddr-v mb-0">
                                <div class="ddr-v input-group p-1">
                                    <input type="submit" name="insert" id="insert" value="Insert" class="ddr-v btn btn-success m-3" />
                                    <button type="button" class="ddr-v btn btn-secondary m-3" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-field" role="tabpanel">
                            <div class="row mx-auto">
                                <div class="ddr-f input-group input-group-sm">
                                    <div class="ddr-f input-group-prepend">
                                        <span class="ddr-f input-group-text">Contact Name</span>
                                    </div>
                                    <input id="cvn" name="cvn" type="text" class="ddr-f form-control" required>
                                    <input id="cin" name="cin" type="text" class="ddr-f form-control">
                                    <div class="ddr-f input-group-append">
                                        <span class="ddr-f input-group-text">Contact Info</span>
                                    </div>
                                </div>
                                <div class="ddr-f input-group input-group-sm">
                                    <div class="ddr-f input-group-prepend">
                                        <span class="ddr-f input-group-text">Daily Report</span>
                                    </div>
                                    <textarea id="drn" name="drn" class="ddr-f form-control" aria-label="With textarea" required></textarea>
                                </div>
                                <div class="ddr-f input-group input-group-sm">
                                    <div class="ddr-f input-group-prepend">
                                        <span class="ddr-f input-group-text">$</span>
                                    </div>
                                    <input id="edc" name="edc" type="text" class="ddr-f form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="ddr-f input-group-append">
                                        <span class="ddr-f input-group-text">Estimated Daily Cost</span>
                                    </div>
                                    <div class="ddr-f input-group-prepend">
                                        <span class="ddr-f input-group-text">$</span>
                                    </div>
                                    <input id="ecc" name="ecc" type="text" class="ddr-f form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="ddr-f input-group-append">
                                        <span class="ddr-f input-group-text">Estimated Cumulative Cost</span>
                                    </div>
                                </div>
                                    <input type="hidden" name="d" id="d" class="ddr-f" value="f" />
                                    <input type="hidden" name="t" id="t" class="ddr-f" value="d" />     
                                    
                                <hr class="ddr-f mb-0">
                                <div class="ddr-f input-group p-1">
                                    <input type="submit" name="insert" id="insert" value="Insert" class="ddr-f btn btn-success m-3" />
                                    <button type="button" class="ddr-f btn btn-secondary m-3" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> -->
<!-- Add DDR Entry Modal -->
