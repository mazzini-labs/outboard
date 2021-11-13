<!-- Edit Well Entry Modal -->

<section class="drawer" id="drawer-name" data-drawer-target>
    <div class="drawer__overlay" data-drawer-close tabindex="-1"></div>
    <div class="drawer__wrapper">
        <div class="drawer__header">
        <div class="drawer__title">
            Well Entry
        </div>
        <button class="drawer__close" data-drawer-close aria-label="Close Drawer"></button>
    </div>
    <div class="drawer__content">
        <form id="insert_well_form" name="insert_well_form" class="" method="POST">
            <div class="modal-body mr-5">
                <div class="row mx-auto">
                    <div class="w-100"></div>
                    <h5 class="mx-auto"><strong>Well Information</strong></h5>
                    <div class="w-100"></div>
                    <p class="mx-auto">Fill in information here as needed.</p>
                    <div class="w-100"></div>
                    <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Entity Operator</span>
                                </div>
                                <select name="entity-operator" id="entity-operator" class="form-control">
                                    <option value="">Select...</option>
                                    <option value="SPINDLETOP OIL & GAS COMPANY">Spindletop Oil & Gas</option>
                                    <option value="SPINDLETOP DRILLING CO.">Spindletop Drilling Company</option>
                                    <option value="GIANT NRG CO., LP">Giant NRG Co., LP</option>
                                    <option value="M-R VENTURES LLC">MRV</option>
                                    <!-- <option value="PPC">PPC</option> -->
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Entity Operator Code</span>
                                </div>
                                <select name="entity-operator-code" id="entity-operator-code" class="form-control">
                                    <option value="">Select...</option>
                                    <option value="SOG">SOG</option>
                                    <option value="SDC">SDC</option>
                                    <option value="NRG">NRG</option>
                                    <option value="MRV">MRV</option>
                                    <!-- <option value="PPC">PPC</option> -->
                                </select>
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">State</span>
                                </div>
                                <select id="state" name="state" class="form-control">
                                    <option value="AL">Alabama</option>
                                    <option value="AK">Alaska</option>
                                    <option value="AZ">Arizona</option>
                                    <option value="AR">Arkansas</option>
                                    <option value="CA">California</option>
                                    <option value="CO">Colorado</option>
                                    <option value="CT">Connecticut</option>
                                    <option value="DE">Delaware</option>
                                    <option value="DC">District of Columbia</option>
                                    <option value="FL">Florida</option>
                                    <option value="GA">Georgia</option>
                                    <option value="HI">Hawaii</option>
                                    <option value="ID">Idaho</option>
                                    <option value="IL">Illinois</option>
                                    <option value="IN">Indiana</option>
                                    <option value="IA">Iowa</option>
                                    <option value="KS">Kansas</option>
                                    <option value="KY">Kentucky</option>
                                    <option value="LA">Louisiana</option>
                                    <option value="ME">Maine</option>
                                    <option value="MD">Maryland</option>
                                    <option value="MA">Massachusetts</option>
                                    <option value="MI">Michigan</option>
                                    <option value="MN">Minnesota</option>
                                    <option value="MS">Mississippi</option>
                                    <option value="MO">Missouri</option>
                                    <option value="MT">Montana</option>
                                    <option value="NE">Nebraska</option>
                                    <option value="NV">Nevada</option>
                                    <option value="NH">New Hampshire</option>
                                    <option value="NJ">New Jersey</option>
                                    <option value="NM">New Mexico</option>
                                    <option value="NY">New York</option>
                                    <option value="NC">North Carolina</option>
                                    <option value="ND">North Dakota</option>
                                    <option value="OH">Ohio</option>
                                    <option value="OK">Oklahoma</option>
                                    <option value="OR">Oregon</option>
                                    <option value="PA">Pennsylvania</option>
                                    <option value="RI">Rhode Island</option>
                                    <option value="SC">South Carolina</option>
                                    <option value="SD">South Dakota</option>
                                    <option value="TN">Tennessee</option>
                                    <option value="TX">Texas</option>
                                    <option value="UT">Utah</option>
                                    <option value="VT">Vermont</option>
                                    <option value="VA">Virginia</option>
                                    <option value="WA">Washington</option>
                                    <option value="WV">West Virginia</option>
                                    <option value="WI">Wisconsin</option>
                                    <option value="WY">Wyoming</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div id="county_drop_down" class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">County</span>
                                </div>
                                <select name="county_parish" id="county_parish" class="form-control">
                                    <!-- <option value="">County...</option> -->
                                </select>

                            </div>
                            <span id="loading_county_drop_down" style="display: none;"><i data-feather="loader">&nbsp;Loading...</i></span>
                            <div id="no_county_drop_down">This state has no counties.</div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Lease Name:</span>
                                </div>
                                <input name="well-lease" id="well-lease" type="text" class="form-control" >
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Well No:</span>
                                </div>
                                <input name="well-no" id="well-no" type="text" class="form-control" >
                            </div>
                        </div>
                        <div class="w-100"></div>
                        
                        
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Entity Common Name</span>
                                </div>
                                <input name="entity-common-name" id="entity-common-name" type="text" class="form-control" >
                                
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Entity Type</span>
                                </div>
                                
                                <select name="entity-type" id="entity-type" class="form-control">
                                    <option value="">Select...</option>
                                    <option value="WELL">Well</option>
                                    <option value="LEASE">Lease</option>
                                    <option value="OTHER">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="w-100"></div>
                        
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">County or Parish</span>
                                </div>
                                <input name="county-parish" id="county-parish" type="text" class="form-control" >
                            </div>
                                
                        </div>
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Reservoir</span>
                                </div>
                                <input name="reservoir" id="Reservoir" type="text" class="form-control" >
                            </div>
                                
                        </div>
                        
                        <!-- </div> -->
                        <div class="w-100"></div>
                        
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                        <span class="input-group-text">Production Type</span>
                                </div>
                                <select name="production-type" id="production-type" class="form-control">
                                    <option value="">Select...</option>
                                    <option value="OIL">Oil</option>
                                    <option value="GAS">Gas</option>
                                    <option value="OTHER">Other</option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Producing Status</span>
                                </div>
                                <select name="producing-status" id="producing-status" class="form-control">
                                    <option value="">Select...</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Shut-in">Shut-in</option>
                                    <option value="TA">Temporarily Abandoned</option>
                                    <option value="PA">Plugged & Abandoned</option>
                                </select>
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Drilling Type</span>
                                </div>
                                <select name="drill-type" id="drill-type" class="form-control">
                                    <option value="">Select...</option>
                                    <option value="V">Vertical</option>
                                    <option value="H">Horizontal</option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="w-100"></div>
                        <div class="col">
                            <div class="input-group input-group-sm mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Spud Date</span>
                                </div>
                                <input id="spud-date" name="spud-date" type="text" class="form-control date datepicker-input" value="">
                                
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group input-group-sm mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Completion Date</span>
                                </div>
                                <input id="completion-date" name="completion-date" type="text" class="form-control date datepicker-input" value="">
                                
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col">
                            <div class="input-group input-group-sm mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">First Production Date</span>
                                </div>
                                <input id="first-prod-date" name="first-prod-date" type="text" class="form-control date datepicker-input" value="">
                                
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group input-group-sm mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Most Recent Production Date</span>
                                </div>
                                <input id="last-prod-date" name="last-prod-date" type="text" class="form-control date datepicker-input" value="">
                            </div>
                        </div>
                        
                        <div class="w-100"></div>
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Upper Perforation</span>
                                </div>
                                <input name="upper-perforation" id="upper-perforation" type="text" class="form-control" >
                                <div class="input-group-append">
                                    <span class="input-group-text">ft</span>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Lower Perforation</span>
                                </div>
                                <input name="lower-perforation" id="lower-perforation" type="text" class="form-control" >
                                <div class="input-group-append">
                                    <span class="input-group-text">ft</span>
                                </div>
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Gas Gravity</span>
                                </div>
                                <input name="gas-gravity" id="gas-gravity" type="text" class="form-control" >
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Oil Gravity</span>
                                </div>
                                <input name="oil-gravity" id="oil-gravity" type="text" class="form-control" >
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"># of Active Wells</span>
                                </div>
                                <input name="well-count" id="well-count" type="text" class="form-control" >
                                <div class="input-group-append">
                                    <span class="input-group-text">wells</span>
                                </div>
                            </div>
                                
                        </div>
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Maximum Active Wells:</span>
                                </div>
                                <input name="max-active-wells" id="max-active-wells" type="text" class="form-control" >
                                <div class="input-group-append">
                                    <span class="input-group-text">wells</span>
                                </div>
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Total Months Produced</span>
                                </div>
                                <input name="months-produced" id="months-produced" type="text" class="form-control" >
                                <div class="input-group-append">
                                    <span class="input-group-text">months</span>
                                </div>
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Gas Gatherer</span>
                                </div>
                                <input name="gas-gatherer" id="gas-gatherer" type="text" class="form-control" >
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Oil Gatherer</span>
                                </div>
                                <input name="oil-gatherer" id="oil-gatherer" type="text" class="form-control" >
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Measured Depth</span>
                                </div>
                                <input name="measured-depth-td" id="measured-depth-td" type="text" class="form-control" >
                                <div class="input-group-append">
                                    <span class="input-group-text">ft</span>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">True Vertical Depth</span>
                                </div>
                                <input name="true-vertical-depth" id="true-vertical-depth" type="text" class="form-control" >
                                <div class="input-group-append">
                                    <span class="input-group-text">ft</span>
                                </div>
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Surface Latitude (WGS84)</span>
                                </div>
                                <input name="surface-latitude-wgs84" id="surface-latitude-wgs84" type="text" class="form-control" >
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Surface Longitude (WGS84)</span>
                                </div>
                                <input name="surface-longitude-wgs84" id="surface-longitude-wgs84" type="text" class="form-control" >
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Pumper</span>
                                </div>
                                <input name="pumper" id="pumper" type="text" class="form-control" >
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Report Frequency</span>
                                </div>
                                <input name="report-frequency" id="report-frequency" type="text" class="form-control" >
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Show on WSB?</span>
                                </div>
                                <select name="show-data" id="show-data" class="form-control">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="ddr-e input-group p-1">
                        <input type="submit" name="insert-well" id="insertwell" value="Insert" class="btn btn-success m-3" />
                        <button type="button" class="ddr-e btn btn-secondary m-3" data-dismiss="modal">Close</button>
                    </div>

                    <input type="hidden" name="id" id="id" class=""/>
                    <input type="hidden" name="api" id="api" class="" value=<?php echo $api; ?> />
                </div>
            </div>
        </form>
    </div>
  </div>
</section>
<!-- <div class="modal fade right" id="well_entry_Modal" name="well_entry_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-side modal-top-right" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalPreviewLabel">Well Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
        </div>
    </div>
</div> -->
<!-- <script src="/js/dropdown.js?v=1.0.0.1"></script> -->
<!-- Well Entry Modal -->