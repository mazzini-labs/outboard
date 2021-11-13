<!-- Add DDR Entry Modal -->
<!-- to return to normal modal behavior, add the "fade" class to 
the first <div> and remove all css from floating_action_button.php -->
<div class="modal right" id="add_data_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    
    <div class="modal-dialog modal-lg modal-side modal-top-right" role="document">
        <div id="success" name="success" class="alert alert-primary btn-block fade" style="position: absolute;z-index: 1;bottom: 0px;" role="alert"><h1>Your entry was input successfully.</h1></div>
        <div id="error" name="error" class="alert alert-danger fade" style="position: absolute;z-index: 1;bottom: 0px;" role="alert">An error occurred. Your entry was not input.<p id="e-details" class="error-details mb-0"></p></div>
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
            <form id="insert_form" class="ddr" method="POST" enctype="multipart/form-data">
                <div class="modal-body mr-5">
                    <div class="row mx-auto">
                        <div class="form-group mx-auto">
                            <select id="add_data_select" class="ddr selectpicker form-control" data-live-search="true" data-width="auto" data-size="5" name="api" size="1" title="Select Well..." data-style="btn-primary btn-lg">
                            <!-- <select id="add_data_select" class="ddr form-control"> -->
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
                            <input type="time" value="08:00:00" step="1" class="ddr form-control" name="ts" id="ts" required>
                            <div class="w-100"></div>
                            <div class="input-group-prepend mb-2">
                                <span class="input-group-text">End Time</span>
                            </div>
                            <input type="time" value="08:00:00" step="1" class="ddr form-control" name="te" id="te"  required>
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
                                    <div class="ddr-e input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Producing Status</span>
                                        </div>
                                        <select name="ps" id="ps" class="form-control custom-select ddr-e" required>
                                            <option value="">Select...</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                            <option value="Shut-in">Shut-in</option>
                                            <option value="TA">Temporarily Abandoned</option>
                                            <option value="PA">Plugged & Abandoned</option>
                                        </select>
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
                                            <div name="drn" id="drn" class="ddr-e"></div>
                                    <!-- <div data-inline-inject="true" role="textbox" name="drn" id="drn" class="ddr-e form-control" style="height:10vh!important;"></div> -->
                                    <?php } ?>
                                </div>
                                <div class="btn-group btn-group-toggle btn-block mb-2" data-toggle="buttons">
                                    <label class="btn btn-secondary btn-lg active" type="button" data-toggle="collapse" data-target="#noSection">
                                        <input type="radio" name="notes-addition" id="drn-e-none" autocomplete="off" value="none" checked> Do not put on WSB
                                    </label>
                                    <!-- <label class="btn btn-secondary btn-lg" type="button" data-toggle="collapse" data-target="#appendSection">
                                        <input type="radio" name="notes-addition" id="drn-e-add" autocomplete="off" value="append"> Append to WSB Notes
                                    </label> -->
                                    <label class="btn btn-secondary btn-lg" type="button" data-toggle="collapse" data-target="#replaceSection">
                                        <input type="radio" name="notes-addition" id="drn-e-replace" autocomplete="off" value="replace"> Replace WSB Notes
                                    </label>
                                </div>
                                <div class="input-group">
                                    <div id="noSection" class="collapse btn-block" style="padding-left:0px;">
                                        <div class="alert alert-info" role="alert">
                                            This note will <strong>not</strong> be added to the WSB!
                                        </div>
                                    </div>
                                    <!-- <div id="appendSection" class="collapse btn-block" style="padding-left:0px;">
                                        <div class="alert alert-info" role="alert">
                                            This note will be <strong>appended</strong> to the current note on the WSB
                                        </div>
                                    </div> -->
                                    <div id="replaceSection" class="collapse btn-block" style="padding-left:0px;">
                                        <div class="alert alert-warning" role="alert">
                                            This note will <strong>replace</strong> the current note on the WSB!
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
                                <!-- <div class="row mx-auto">
                                    <div class="col input-group p-1"><button class="btn btn-primary btn-block m-3" type="button" data-toggle="collapse" data-target="#fileUpload" aria-expanded="false" aria-controls="multiCollapseExample2">File Upload</button></div>
                                    <div class="col input-group p-1"><button class="btn btn-primary btn-block m-3" type="button" data-toggle="collapse" data-target="#vitalsSection" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2">Vitals Upload</button></div>
                                </div> -->
                                <div class="row w-100"><div class="col">
                                    <div class="input-group p-1"><button class="btn btn-primary btn-block m-3 collapsed" type="button" data-toggle="collapse" data-target="#fileUpload" aria-expanded="false" aria-controls="multiCollapseExample2">File Upload</button></div></div><div class="col">
                                    <div class="input-group p-1"><button class="btn btn-primary btn-block m-3 collapsed" type="button" data-toggle="collapse" data-target="#vitalsSection" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2">Vitals Upload</button></div>
                                </div></div>
                                
                                <div class="w-100"></div>
                                <br>
                                <div class="input-group">
                                    <div id="fileUpload" class="collapse btn-block" style="padding-left:0px;">
                                        <h5 class="mx-auto"><strong>File Uploads</strong></h5>
                                        <div class="row mx-auto">
                                            <div class="form-group mx-auto">
                                                <label for="add_wsb_category">Category of files
                                                <!-- <input type="search" class="ddr-e form-control" name="ft" id="ft"> -->
                                                <input type="text" list="category" id="wsbcategory" name="wsbcategory" class="custom-select" />
                                                    <datalist id="category">
                                                    <?php include 'ajax/wsbcategories.php'; ?>
                                                    </datalist>
                                                    <div class="w-100"></div>
                                                    <script>

                                                        // $("#add_wsb_category").select2({
                                                        //     id: "add_wsb_category",
                                                        //     class: "ddr selectpicker form-control",
                                                        //     data-live-search:true,
                                                        //     data-width:"auto",
                                                        //     data-size: "5",
                                                        //     name:"wsbcategory",
                                                        //     size:"1",
                                                        //     title:"Select Category...",
                                                        //     data-style:"btn-primary btn-lg",
                                                        //     placeholder: "Select Category...",
                                                        //     tags: true
                                                        // });
                                                        // $(".wsbcategories").select2({
                                                        //     data-live-search:true,
                                                        //     data-width:"auto",
                                                        //     tags: true
                                                        // });
                                                        // function formatState (state) {
                                                        // if (!state.id) {
                                                        //     return state.text;
                                                        // }

                                                        // var baseUrl = "/user/pages/images/flags";
                                                        // var $state = $(
                                                        //     '<span><img class="img-flag" /> <span></span></span>'
                                                        // );

                                                        // // Use .text() instead of HTML string concatenation to avoid script injection issues
                                                        // $state.find("span").text(state.text);
                                                        // $state.find("img").attr("src", baseUrl + "/" + state.element.value.toLowerCase() + ".png");

                                                        // return $state;
                                                        // };

                                                        // $(".js-example-templating").select2({
                                                        // templateSelection: formatState
                                                        // });
                                                        // $('.wsbcategories').select2({
                                                        // createTag: function (params) {
                                                        //     var term = $.trim(params.term);

                                                        //     if (term === '') {
                                                        //     return null;
                                                        //     }

                                                        //     return {
                                                        //     id: term,
                                                        //     text: term,
                                                        //     newTag: true // add additional parameters
                                                        //     }
                                                        // }
                                                        // });
                                                        </script>
                                                <!-- <select id="wsbcategory" class="ddr form-control wsbcategories" data-live-search="true" data-width="auto" data-size="5" name="api" size="1" title="Select Category..." data-style="btn-primary btn-lg" data-tags="true"> -->
                                                <!-- <select id="add_wsb_category" class="selectpicker form-control wsbcategories"> -->
                                                <!-- <option>Select Well:</option> -->
                                                <?php
                                                    
                                                    $table = "wsbcategories";
                                                    $sql = "SELECT category, slug FROM $table";// ORDER BY well_lease ASC";
                                                    $result = mysqli_query($mysqli,$sql) or die(mysql_error());
                                                        //console_log($result);
                                                    ?>
                                                    <!-- <option>Select Well:</option> -->
                                                    <?php 
                                                    // $a= array();
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        // $wellname = $row['well_lease'] . "# " . $row['well_no']; 
                                                        $category = $row['category'];
                                                        $slug = $row['slug'];
                                                        $array[] = array(
                                                            "id" => "wsbcategory",
                                                            "text" => $category
                                                            
                                                        );
                                                        console_log($array);
                                                        // $conditional = ($row['api'] == $apino) ?  '"' . $row['api'] . '" selected' :  '"' . $row['api'] . '"';
                                                        
                                                        ?>
                                                    <!-- <option name="wsbcategory" id="wsbcategory" value=<?php echo $slug;  ?> data-token=<?php echo $slug;  ?>><?php echo $category; //$row['api']; // . $row['well_no'];?></option>  -->
                                                <?php 
                                            } 
                                            $select2 = json_encode($array);
                                            console_log($array);
                                            console_log($select2);
                                            ?>
                                                    </select> 
                                                    </label>
                                                    
                                                    <div class="w-100"></div>
                                                    <small>This could be an invoice, photos of the well, documents, screenshots...etc</small>
                                            </div>
                                        </div>
                                        <div class="w-100"></div>
                                        <div class="file-upload-previews"></div>
                                        <div class="file-upload">
                                            <input type="file" name="files[]" class="file-upload-input with-preview" multiple="true" title="Click to add files" accept="gif|jpg|png|JPG|jpeg|JPEG|PNG|GIF|doc|docx|pdf|DOC|DOCX|PDF|xls|xlsx|ppt|pptx|bmp|tif|tiff|psd">
                                            <span><i class="fa fa-plus-circle"></i>Click or drag files here</span>
                                            <input type="hidden" name="lastid" id="lastid" class="ddr-id">
                                            
                                        </div>
                                        <!-- <div class="custom-file-container" data-upload-id="files">
                                            <label
                                                >Upload File
                                                <a
                                                    href="javascript:void(0)"
                                                    class="custom-file-container__image-clear"
                                                    title="Clear Image"
                                                    >&times;</a
                                                ></label
                                            >
                                            <label class="custom-file-container__custom-file">
                                                <input
                                                    type="file"
                                                    class="custom-file-container__custom-file__custom-file-input"
                                                    accept="*"
                                                    multiple
                                                    aria-label="Choose File"
                                                    id="files"
                                                />
                                                <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                                <span
                                                    class="custom-file-container__custom-file__custom-file-control"
                                                ></span>
                                            </label>
                                            <div class="custom-file-container__image-preview"></div>
                                        </div> -->
                                        <!-- <div class="ddr-e input-group input-group-sm mb-1">                                          
                                            <div class="form-group">
                                                <label for="ft">Category of files</label>
                                               
                                                <input type="text" list="category" id="ft" name="ft" class="custom-select" />
                                                    <datalist id="category">
                                                    <option value="invoice">Invoice</option>
                                                    <option value="well_photos">Well Photos</option>
                                                    <option value="well_documents">Well Documents</option>
                                                    <option value="miscellaneous">Miscellaneous</option>
                                                    </datalist>
                                                <small>This could be an invoice, photos of the well, documents, screenshots...etc</small>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div id="vitalsSection" class="collapse row" style="padding-left:0px;">
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
        //   $(".wsbcategories").select2({
        //       debug: true,
        //     ajax: {
        //         url: 'https://vprsrv.org/ajax/wsbcategories.php',
        //         // data: function (params) {
        //         //     var query = {
        //         //         search: params.term,
        //         //         type: 'public'
        //         //     }

        //         //     // Query parameters will be ?search=[term]&type=public
        //         //     return query;
        //         //     },
        //         dataType: 'json'
        //     },
        //     //data: [<?php echo $select2; ?>],
        //     placeholder: 'Select a category...',
        //     theme: 'bootstrap4',
        //     tags: true,
        //     createTag: function(params) {
        //         var term = $.trim(params.term);
        //         if (term === '') {
        //         return null;
        //         }
        //         return {
        //         id: term,
        //         text: term
        //         }
        //     }
        // });
        // $("#add_data_category").selectpicker({
        //     liveSearch: true,
        //     width:"auto",
        //     size: 'auto',
        //     name:"wsbcategory",
        //     size:"1",
        //     title:"Select Category...",
        //     style:"btn-primary btn-lg",
        // });
      });
    
   </script>
<style>
.btn-excel {
    color: #fff;
    background-color: #107a40;
    border-color: #107a40;
}
.btn-word {
    color: #fff;
    background-color: #185abd;
    border-color: #185abd;
}
.btn-powerpoint {
    color: #fff;
    background-color: #c43f1d;
    border-color: #c43f1d;
}
.btn-pdf {
    color: #fff;
    background-color: #f40f02;
    border-color: #f40f02;
}
</style>
<script src="js/jquery.MultiFile.js?v=1.0.0.8"></script>
<!-- <script src="js/jQuery.MultiFile.min.js"></script> -->
<script src="js/custom.js?v=1"></script>
