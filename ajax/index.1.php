<?php  
 $connect = mysqli_connect("localhost", "root", "devonian", "wells");  
 $query = "SELECT * FROM ddr ORDER BY de DESC";  
 $result = mysqli_query($connect, $query);  
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Webslesson Tutorial | PHP Ajax Update MySQL Data Through Bootstrap Modal</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
      </head>  
      <body>  
           <br /><br />  
           <div class="container" >  
                <h3 align="center">PHP Ajax Update MySQL Data Through Bootstrap Modal</h3>  
                <br />  
                <div class="table-responsive">  
                     <div align="right">  
                          <button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-warning">Add</button>  
                     </div>  
                     <br />  
                     <div id="ddr_table">  
                          <table class="table table-bordered">  
                               <tr>  
                                    <th>Department</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Contact/Vendor Name</th>
                                    <th>Contact Info/Invoice No./Vendor Service</th>
                                    <th>Daily Report/Invoice Details/Vendor Notes</th>
                                    <th>Daily Cost/Invoice Amount/Vendor Total Hours</th>
                                    <th>Cumulative Cost/Approval Initials/Vendor Total Hours</th>
                                    <th>Approval Date</th>
                                    <th>Submission Date</th>
                                    <th>Data Entered by:</th>
                               </tr>  
                               <?php  
                               while($row = mysqli_fetch_array($result))  
                               {  
                               ?>  
                               <tr>  
                                    <td><?php echo $row["d"]; ?></td>  
                                    <td><?php echo $row["de"]; ?></td>
                                    <td><?php echo $row["ts"]; ?> - <?php echo $row["te"]; ?></td>    
                                    <td><?php echo $row["cvn"]; ?></td>  
                                    <td><?php echo $row["cin"]; ?></td>  
                                    <td><?php echo $row["drn"]; ?></td>  
                                    <td><?php echo $row["dc"]; ?></td>  
                                    <td><?php echo $row["tc"]; ?></td>  
                                    <td><?php echo $row["ad"]; ?></td>  
                                    <td><?php echo $row["sd"]; ?></td>  
                                    <td><?php echo $row["deb"]; ?></td>  
                                    <td><input type="button" name="edit" value="Edit" id="<?php echo $row["id"]; ?>" class="btn btn-info btn-xs edit_data-<?php echo $row["d"]; ?>" /><input type="hidden" name="api" id="api" value="42-077-33876" /></td>  
                                    <td><input type="button" name="view" value="view" id="<?php echo $row["id"]; ?>" class="btn btn-info btn-xs view_data-<?php echo $row["d"]; ?>" /><input type="hidden" name="api" id="api" value="42-077-33876" /></td>  
                               </tr>  
                               <?php  
                               }  
                               ?>  
                          </table>  
                     </div>  
                </div>  
           </div>  
      </body>  
 </html>  
 <div id="dataModal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">Employee Details</h4>  
                </div>  
                <div class="modal-body" id="ddr_detail">  
                </div>  
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </div>  
           </div>  
      </div>  
 </div>
<!-- Add Entry Modal -->
<div class="modal fade right" id="add_data_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-side modal-top-right" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalPreviewLabel">Add New Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>Type:</h6>
                <ul class="nav nav-pills nav-fill mb-3" id="pills-tab" role="tablist">
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
            <div class="modal-body">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade active" id="pills-eng" role="pillpanel">
                        <form id="insert_form-e" method="POST">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Date Entered</span>
                                </div>
                                <input id="de-e" name="de-e" type="text" class="form-control date datepicker-input">
                                <input name="deb-e" id="deb-e" type="text" class="form-control" placeholder="Your Name" aria-label="Data Entry By">
                                <div class="input-group-append">
                                    <span class="input-group-text">Person Entering Data</span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Start Time / Vendor AOL</span>
                                </div>
                                <input type="time" value="08:00" step="600" class="form-control" name="ts-e" id="ts-e">
                                <input type="time" value="08:00" step="600" class="form-control" name="te-e" id="te-e">
                                <div class="input-group-append">
                                    <span class="input-group-text">End Time / Vendor LL</span>
                                </div>
                            </div>
                
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Contact Name</span>
                                </div>
                                <input name="cvn-e" id="cvn-e" type="text" class="form-control">
                                <input name="cin-e" id="cin-e" type="text" class="form-control">
                                <div class="input-group-append">
                                        <span class="input-group-text">Contact Info</span>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Daily Report</span>
                                    </div>
                                    <textarea name="drn-e" id="drn-e" class="form-control" aria-label="With textarea"></textarea>
                                </div>
                                <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input name="dc-e" id="dc-e" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="input-group-append">
                                    <span class="input-group-text">Estimated Daily Cost</span>
                                </div>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input name="tc-e" id="tc-e" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="input-group-append">
                                    <span class="input-group-text">Estimated Cumulative Cost</span>
                                </div>
                                <input type="hidden" name="id-e" id="id-e" />
                                <input type="hidden" name="api-e" id="api-e" value="42-077-33876" />
                                <input type="hidden" name="d-e" id="d-e" value="e" />
                                <input type="hidden" name="t-e" id="t-e" value="d" />     
                                <input type="submit" name="insert-e" id="insert-e" value="Insert" class="btn btn-success" />
                                <!-- </form> -->
                            </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <!-- <button type="submit" name="eng" class="btn btn-primary">Add Entry</button> -->
                            </div>
                            </div>
                        
                        
                        </form>
                        <div class="tab-pane fade" id="pills-acct" role="tabpanel">
                            <form id="insert_form-a" method="POST">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Date Entered</span>
                                    </div>
                                    <input id="de-a" name="de-a" type="text" class="form-control date datepicker-input">
                                    <input name="deb-a" id="deb-a" type="text" class="form-control" placeholder="Your Name" aria-label="Data Entry By">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Person Entering Data</span>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Start Time / Vendor AOL</span>
                                    </div>
                                    <input type="time" value="08:00" step="600" class="form-control" name="ts-a" id="ts-a">
                                    <input type="time" value="08:00" step="600" class="form-control" name="te-a" id="te-a">
                                    <div class="input-group-append">
                                        <span class="input-group-text">End Time / Vendor LL</span>
                                    </div>
                                </div>
                                <div class="input-group mb-3 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Vendor Name:</span>
                                    </div>
                                    <input id="cvn-a" name="cvn-a" type="text" class="form-control" placeholder="Vendor" aria-label="Vendor">
                                </div>    
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Invoice #</span>
                                    </div>
                                    <input id="cin-a" name="cin-a" type="text" class="form-control" aria-label="Invoice #">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input id="dc-a" name="dc-a" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Invoice Amount</span>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Invoice Details</span>
                                    </div>
                                    <textarea id="drn-a" name="drn-a" class="form-control" aria-label="With textarea"></textarea>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Approval Initials</span>
                                    </div>
                                    <input id="tc-a" name="tc-a" type="text" aria-label="Approval Initials" class="form-control">
                                    <input id="ad" name="ad" name="acct_approval_date" type="text" class="form-control date datepicker-input">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Approval Date</span>
                                    </div>
                                    <input type="hidden" name="id-a" id="id-a" />
                                    <input type="hidden" name="api-a" id="api-a" value="42-077-33876" />
                                    <input type="hidden" name="d-a" id="d-a" value="a" />
                                    <input type="hidden" name="t-a" id="t-a" value="d" />     
                                    <input type="submit" name="insert-a" id="insert-a" value="Insert" class="btn btn-success" />
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <!-- <button type="submit" name="acct" class="btn btn-primary">Add Entry</button> -->
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="pills-vend" role="tabpanel">		
                        <form id="insert_form-v" method="POST">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Date Entered</span>
                                </div>
                                <input id="de-v" name="de-v" type="text" class="form-control date datepicker-input">
                                <input name="deb-v" id="deb-v" type="text" class="form-control" placeholder="Your Name" aria-label="Data Entry By">
                                <div class="input-group-append">
                                    <span class="input-group-text">Person Entering Data</span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Start Time / Vendor AOL</span>
                                </div>
                                <input type="time" value="08:00" step="600" class="form-control" name="ts-v" id="ts-v">
                                <input type="time" value="08:00" step="600" class="form-control" name="te-v" id="te-v">
                                <div class="input-group-append">
                                    <span class="input-group-text">End Time / Vendor LL</span>
                                </div>
                            </div>			
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Vendor Name</span>
                                </div>
                                <input id="cvn-f" name="cvn-f" type="text" class="form-control">
                                <input id="cin-f" name="cin-f" type="text" class="form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">Vendor Service</span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Vendor Notes</span>
                                </div>
                                <textarea id="drn-f" name="drn-f" class="form-control" aria-label="With textarea"></textarea>
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
                                <input id="dc-f" name="dc-v" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
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
                                <input id="tc-v" name="tc-v" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                            <div class="input-group-append">
                                <span class="input-group-text">Hour(s)</span>
                                <input type="hidden" name="id-v" id="id-v" />
                                <input type="hidden" name="api-v" id="api-v" value="42-077-33876" />
                                <input type="hidden" name="d-v" id="d-v" value="v" />
                                <input type="hidden" name="t-v" id="t-v" value="d" />     
                                <input type="submit" name="insert-v" id="insert-v" value="Insert" class="btn btn-success" />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <!-- <button type="submit" name="vend" class="btn btn-primary">Add Entry</button> -->
                            </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="pills-field" role="tabpanel">
                        <form id="insert_form-f" method="POST">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Date Entered</span>
                                </div>
                                <input id="de-f" name="de-f" type="text" class="form-control date datepicker-input">
                                <input name="deb-f" id="deb-f" type="text" class="form-control" placeholder="Your Name" aria-label="Data Entry By">
                                <div class="input-group-append">
                                    <span class="input-group-text">Person Entering Data</span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Start Time / Vendor AOL</span>
                                </div>
                                <input type="time" value="08:00" step="600" class="form-control" name="ts-f" id="ts-f">
                                <input type="time" value="08:00" step="600" class="form-control" name="te-f" id="te-f">
                                <div class="input-group-append">
                                    <span class="input-group-text">End Time / Vendor LL</span>
                                </div>
                            </div>					
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Contact Name</span>
                                </div>
                                <input id="cvn-f" name="cvn-f" type="text" class="form-control">
                                <input id="cin-f" name="cin-f" type="text" class="form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">Contact Info</span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Daily Report</span>
                                </div>
                                <textarea id="drn-f" name="drn-f" class="form-control" aria-label="With textarea"></textarea>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input id="dc-f" name="dc-f" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="input-group-append">
                                    <span class="input-group-text">Estimated Daily Cost</span>
                                </div>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input id="tc-f" name="tc-f" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="input-group-append">
                                    <span class="input-group-text">Estimated Cumulative Cost</span>
                                </div>
                            </div>
                            <input type="hidden" name="id-f" id="id-f" />
                                <input type="hidden" name="api-f" id="api-f" value="42-077-33876" />
                                <input type="hidden" name="d-f" id="d-f" value="f" />
                                <input type="hidden" name="t-f" id="t-f" value="d" />     
                                <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" />
                            </form>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 <script>  
 $(document).ready(function(){  
      $('#add').click(function(){  
           $('#insert').val("Insert");  
           $('#insert_form-e')[0].reset();
           $('#insert_form-a')[0].reset();
           $('#insert_form-v')[0].reset();
           $('#insert_form-f')[0].reset();  
      });  
      $(document).on('click', '.edit_data-e', function(){  
           var id = $(this).attr("id");  
           $.ajax({  
                url:"fetch.php",  
                method:"POST",  
                data:{id:id},  
                dataType:"json",  
                success:function(data){  
                     $('#deb-e').val(data.deb);  
                     $('#t-e').val(data.t);  
                     $('#de-e').val(data.de);  
                     $('#ts-e').val(data.ts);  
                     $('#te-e').val(data.te);  
                     $('#id-e').val(data.id);  
                     $('#api-e').val(data.api);  
                     $('#d-e').val(data.d);  
                     $('#cvn-e').val(data.cvn);  
                     $('#cin-e').val(data.cin);  
                     $('#drn-e').val(data.drn); 
                     $('#dc-e').val(data.dc);  
                     $('#tc-e').val(data.tc);  

                     $('#insert-e').val("Update");  
                     $('#add_data_Modal').modal('show');  
                    
                    $('#nav-item-e').addClass("nav-item active");
                    $('#nav-item-a').removeClass("active");
                    $('#nav-item-v').removeClass("active");
                    $('#nav-item-f').removeClass("active");
                    $('#pills-eng').addClass("tab-pane fade active in");
                    $('#pills-acct').removeClass("active in");
                    $('#pills-vend').removeClass("active in");
                    $('#pills-field').removeClass("active in");
                }  
           });  
      });
      $(document).on('click', '.edit_data-a', function(){  
           var id = $(this).attr("id");  
           $.ajax({  
                url:"fetch.php",  
                method:"POST",  
                data:{id:id},  
                dataType:"json",  
                success:function(data){  
                     $('#deb-a').val(data.deb);  
                     $('#t-a').val(data.t);  
                     $('#de-a').val(data.de);  
                     $('#ts-a').val(data.ts);  
                     $('#te-a').val(data.te);  
                     $('#id-a').val(data.id);  
                     $('#api-a').val(data.api);  
                     $('#d-a').val(data.d);  
                     $('#cvn-a').val(data.cvn);  
                     $('#cin-a').val(data.cin);  
                     $('#drn-a').val(data.drn); 
                     $('#dc-a').val(data.dc);  
                     $('#tc-a').val(data.tc);  
                     $('#ad').val(data.ad); 

                      $('#insert-a').val("Update");  
                     $('#add_data_Modal').modal('show');  
                    $('#nav-item-a').addClass("nav-item active");
                     $('#nav-item-e').removeClass("active");
                    $('#nav-item-v').removeClass("active");
                    $('#nav-item-f').removeClass("active");
                    $('#pills-acct').addClass("tab-pane fade active in");
                    $('#pills-field').removeClass("active in");
                    $('#pills-vend').removeClass("active in");
                    $('#pills-eng').removeClass("active in");
                }  
           });  
      });    
      $(document).on('click', '.edit_data-v', function(){  
           var id = $(this).attr("id");  
           $.ajax({  
                url:"fetch.php",  
                method:"POST",  
                data:{id:id},  
                dataType:"json",  
                success:function(data){  
                     $('#deb-v').val(data.deb);  
                     $('#t-v').val(data.t);  
                     $('#de-v').val(data.de);  
                     $('#ts-v').val(data.ts);  
                     $('#te-v').val(data.te);  
                     $('#id-v').val(data.id);  
                     $('#api-v').val(data.api);  
                     $('#d-v').val(data.d);  
                     $('#cvn-v').val(data.cvn);  
                     $('#cin-v').val(data.cin);  
                     $('#drn-v').val(data.drn); 
                     $('#dc-v').val(data.dc);  
                     $('#tc-v').val(data.tc);  

                      $('#insert-v').val("Update");  
                     $('#add_data_Modal').modal('show');  
                    $('#nav-item-v').addClass("nav-item active");
                     $('#nav-item-a').removeClass("active");
                    $('#nav-item-e').removeClass("active");
                    $('#nav-item-f').removeClass("active");
                    $('#pills-vend').addClass("tab-pane fade active in");
                    $('#pills-acct').removeClass("active in");
                    $('#pills-field').removeClass("active in");
                    $('#pills-eng').removeClass("active in");
                    
                }  
           });  
      });    
      $(document).on('click', '.edit_data-f', function(){  
           var id = $(this).attr("id");  
           $.ajax({  
                url:"fetch.php",  
                method:"POST",  
                data:{id:id},  
                dataType:"json",  
                success:function(data){  
                     $('#deb-f').val(data.deb);  
                     $('#t-f').val(data.t);  
                     $('#de-f').val(data.de);  
                     $('#ts-f').val(data.ts);  
                     $('#te-f').val(data.te);  
                     $('#id-f').val(data.id);  
                     $('#api-f').val(data.api);  
                     $('#d-f').val(data.d);  
                     $('#cvn-f').val(data.cvn);  
                     $('#cin-f').val(data.cin);  
                     $('#drn-f').val(data.drn); 
                     $('#dc-f').val(data.dc);  
                     $('#tc-f').val(data.tc);  

                      $('#insert-f').val("Update");  
                     $('#add_data_Modal').modal('show');  
                    $('#nav-item-f').addClass("active");
                     $('#nav-item-a').removeClass("active");
                    $('#nav-item-v').removeClass("active");
                    $('#nav-item-e').removeClass("active");
                    $('#pills-field').addClass("active in");
                    $('#pills-acct').removeClass("active in");
                    $('#pills-vend').removeClass("active in");
                    $('#pills-eng').removeClass("active in");
                }  
           });  
      });    
      $('#insert_form-e').on("submit", function(event){  
           event.preventDefault();  
           if($('#de').val() == "")  
           {  
                alert("Date is required");  
           }  
           else  
           {  
                $.ajax({  
                     url:"insert.e.php",  
                     method:"POST",  
                     data:$('#insert_form-e').serialize(),  
                     beforeSend:function(){  
                          $('#insert-e').val("Inserting");  
                     },  
                     success:function(data){  
                          $('#insert_form-e')[0].reset();  
                          $('#add_data_Modal').modal('hide');  
                          $('#ddr_table').html(data);  
                     }  
                });  
           }  
      });  
      $('#insert_form-a').on("submit", function(event){  
           event.preventDefault();  
           if($('#de').val() == "")  
           {  
                alert("Date is required");  
           }  
           else  
           {  
                $.ajax({  
                     url:"insert.a.php",  
                     method:"POST",  
                     data:$('#insert_form-a').serialize(),  
                     beforeSend:function(){  
                          $('#insert-a').val("Inserting");  
                     },  
                     success:function(data){  
                          $('#insert_form-a')[0].reset();  
                          $('#add_data_Modal').modal('hide');  
                          $('#ddr_table').html(data);  
                     }  
                });  
           }  
      });  
      $('#insert_form-v').on("submit", function(event){  
           event.preventDefault();  
           if($('#de').val() == "")  
           {  
                alert("Date is required");  
           }  
           else  
           {  
                $.ajax({  
                     url:"insert.php",  
                     method:"POST",  
                     data:$('#insert_form-v').serialize(),  
                     beforeSend:function(){  
                          $('#insert-v').val("Inserting");  
                     },  
                     success:function(data){  
                          $('#insert_form-v')[0].reset();  
                          $('#add_data_Modal').modal('hide');  
                          $('#ddr_table').html(data);  
                     }  
                });  
           }  
      }); 
      $(document).on('click', '.view_data', function(){  
           var id = $(this).attr("id");  
           if(id != '')  
           {  
                $.ajax({  
                     url:"select.php",  
                     method:"POST",  
                     data:{id:id},  
                     success:function(data){  
                          $('#ddr_detail').html(data);  
                          $('#dataModal').modal('show');  
                     }  
                });  
           }            
      });  
 });  
 </script>