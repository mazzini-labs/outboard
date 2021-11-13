
<div class="modal fade right" id="editEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-side modal-top-right" role="document">
        <div class="modal-content">
            <form id="entryForm" action="./ajax/ddr_add.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalPreviewLabel">Add New Entry</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <input type="hidden" name="api" value=<?php echo $api; ?>>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Date Entered</span>
                            </div>
                            <input id="ddr_date" name="ddr_date" type="text" class="form-control date datepicker-input">
                            <input name="data_entry_by" type="text" class="form-control" placeholder="Your Name" aria-label="Data Entry By">
                            <div class="input-group-append">
                                <span class="input-group-text">Person Entering Data</span>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Start Time / Vendor AOL</span>
                            </div>
                            <input type="time" value="08:00" step="600" class="form-control" name="time_start">
                            <input type="time" value="08:00" step="600" class="form-control" name="time_end">
                            <div class="input-group-append">
                                <span class="input-group-text">End Time / Vendor LL</span>
                            </div>
                        </div>                       
                        <div class="tab-pane fade show active" id="pills-eng" role="pillpanel">					
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Contact Name</span>
                                </div>
                                <input name="ec" type="text" class="form-control">
                                <input name="eci" type="text" class="form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">Contact Info</span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Daily Report</span>
                                </div>
                                <textarea name="edr" class="form-control" aria-label="With textarea"></textarea>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input name="eng_edc" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="input-group-append">
                                    <span class="input-group-text">Estimated Daily Cost</span>
                                </div>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input name="eng_ecc"type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="input-group-append">
                                    <span class="input-group-text">Estimated Cumulative Cost</span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" name="eng" class="btn btn-primary">Add Entry</button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-acct" role="tabpanel">
                            <div class="input-group mb-3 ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Vendor Name:</span>
                                </div>
                                <input name="av" type="text" class="form-control" placeholder="Vendor" aria-label="Vendor">
                            </div>    
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Invoice #</span>
                                </div>
                                <input name="ain" type="text" class="form-control" aria-label="Invoice #">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input name="aia" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="input-group-append">
                                    <span class="input-group-text">Invoice Amount</span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Invoice Details</span>
                                </div>
                                <textarea name="aid" class="form-control" aria-label="With textarea"></textarea>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Approval Initials</span>
                                </div>
                                <input name="aai" type="text" aria-label="Approval Initials" class="form-control">
                                <input name="aad" name="acct_approval_date" type="text" class="form-control date datepicker-input">
                                <div class="input-group-append">
                                    <span class="input-group-text">Approval Date</span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" name="acct" class="btn btn-primary">Add Entry</button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-vend" role="tabpanel">					
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Vendor Name</span>
                                </div>
                                <input name="vna" type="text" class="form-control">
                                <input name="vs" type="text" class="form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">Vendor Service</span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Vendor Notes</span>
                                </div>
                                <textarea name="vno" class="form-control" aria-label="With textarea"></textarea>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input name="vac" type="text" class="form-control" aria-label="Vendor Adjusted Hours">
                                <div class="input-group-append">
                                    <span class="input-group-text">Vendor Adjusted Cost</span>
                                </div>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input name="vtc" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="input-group-append">
                                    <span class="input-group-text">Vendor Total Cost</span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                    <span class="input-group-text">Vendor Adjusted Time</span>
                                </div>
                                <input name="vah" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="input-group-append">
                                    <span class="input-group-text">Hour(s)</span>
                                </div>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Vendor Estimated Travel</span>
                                </div>
                                <input name="vet" type="text" class="form-control" aria-label="Vendor Adjusted Hours">
                                <div class="input-group-append">
                                    <span class="input-group-text">Hour(s)</span>
                                </div>
                            </div>
                            <div class="input-group-prepend">
                                    <span class="input-group-text">Vendor Total Time</span>
                                </div>
                                <input name="vtt" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="input-group-append">
                                    <span class="input-group-text">Hour(s)</span>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" name="vend" class="btn btn-primary">Add Entry</button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-field" role="tabpanel">					
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Contact Name</span>
                                </div>
                                <input name="fc" type="text" class="form-control">
                                <input name="fci" type="text" class="form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">Contact Info</span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Daily Report</span>
                                </div>
                                <textarea name="fdr" class="form-control" aria-label="With textarea"></textarea>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input name="fdc" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="input-group-append">
                                    <span class="input-group-text">Estimated Daily Cost</span>
                                </div>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input name="fcc"type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="input-group-append">
                                    <span class="input-group-text">Estimated Cumulative Cost</span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" name="field" class="btn btn-primary">Add Entry</button>
                            </div>
                        </div>                 
                    </div>
                </div>   
            </form>
        </div>
    </div>
</div>