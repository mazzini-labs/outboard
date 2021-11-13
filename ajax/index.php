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
                                    <td><input type="button" name="edit" value="Edit" id="<?php echo $row["id"]; ?>" class="btn btn-info btn-xs edit_data" /><input type="hidden" name="api" id="api" value="42-077-33876" /></td>  
                                    <td><input type="button" name="view" value="view" id="<?php echo $row["id"]; ?>" class="btn btn-info btn-xs view_data" /><input type="hidden" name="api" id="api" value="42-077-33876" /></td>  
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
            <!-- <form id="insert_form" method="POST"> -->
                <!-- <input type="hidden" name="ddr_id" id="ddr_id" />   -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalPreviewLabel">Add New Entry</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>Type:</h6>
                    <ul class="nav nav-pills nav-fill mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" name="eng" id="pills-eng-tab" data-toggle="pill" href="#pills-eng" role="tab" aria-controls="pills-home" aria-selected="true">
                                Engineering</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" name="acct" id="pills-acct-tab" data-toggle="pill" href="#pills-acct" role="tab" aria-controls="pills-profile" aria-selected="false">
                            Accounting</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" name="vend" id="pills-vend-tab" data-toggle="pill" href="#pills-vend" role="tab" aria-controls="pills-contact" aria-selected="false">
                            Vendor</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" name="field" id="pills-field-tab" data-toggle="pill" href="#pills-field" role="tab" aria-controls="pills-contact" aria-selected="false">
                            Field</a>
                        </li>
                    </ul>
                    <div class="modal-body">
                   
                        <!-- <input type="hidden" name="api" value=<?php //echo $api; ?>> -->
                        <form id="insert_form-e" method="POST">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Date Entered</span>
                            </div>
                            <input id="de" name="de" type="text" class="form-control date datepicker-input">
                            <input name="deb" id="deb" type="text" class="form-control" placeholder="Your Name" aria-label="Data Entry By">
                            <div class="input-group-append">
                                <span class="input-group-text">Person Entering Data</span>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Start Time / Vendor AOL</span>
                            </div>
                            <input type="time" value="08:00" step="600" class="form-control" name="ts" id="ts">
                            <input type="time" value="08:00" step="600" class="form-control" name="te" id="te">
                            <div class="input-group-append">
                                <span class="input-group-text">End Time / Vendor LL</span>
                            </div>
                        </div>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade active" id="pills-eng" role="pillpanel">					
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact Name</span>
                                    </div>
                                    <input name="cvn" id="cvn" type="text" class="form-control">
                                    <input name="cin" id="cin" type="text" class="form-control">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Contact Info</span>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Daily Report</span>
                                    </div>
                                    <textarea name="drn" id="drn" class="form-control" aria-label="With textarea"></textarea>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input name="dc" id="dc" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Estimated Daily Cost</span>
                                    </div>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input name="tc" id="tc" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Estimated Cumulative Cost</span>
                                    </div>
                                    <input type="hidden" name="id" id="id" />
                                    <input type="hidden" name="api" id="api" value="42-077-33876" />
                                    <input type="hidden" name="d" id="d" value="e" />
                                    <input type="hidden" name="t" id="t" value="d" />     
                                    <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" />
                                    <!-- </form> -->
                                </div>
                                <!-- <div class="modal-footer"> -->
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <!-- <button type="submit" name="eng" class="btn btn-primary">Add Entry</button> -->
                                <!-- </div> -->
                                </form>
                            </div>
                            <div class="tab-pane fade" id="pills-acct" role="tabpanel">
                                <div class="input-group mb-3 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Vendor Name:</span>
                                    </div>
                                    <input id="cvn" name="cvn" type="text" class="form-control" placeholder="Vendor" aria-label="Vendor">
                                </div>    
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Invoice #</span>
                                    </div>
                                    <input id="cin" name="cin" type="text" class="form-control" aria-label="Invoice #">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input id="dc" name="dc" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Invoice Amount</span>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Invoice Details</span>
                                    </div>
                                    <textarea id="drn" name="drn" class="form-control" aria-label="With textarea"></textarea>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Approval Initials</span>
                                    </div>
                                    <input id="tc" name="tc" type="text" aria-label="Approval Initials" class="form-control">
                                    <input id="ad" name="ad" name="acct_approval_date" type="text" class="form-control date datepicker-input">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Approval Date</span>
                                    </div>
                                    <input type="hidden" name="id" id="id" />
                                    <input type="hidden" name="api" id="api" value="42-077-33876" />
                                    <input type="hidden" name="d" id="d" value="a" />
                                    <input type="hidden" name="t" id="t" value="d" />     
                                    <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" />
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <!-- <button type="submit" name="acct" class="btn btn-primary">Add Entry</button> -->
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-vend" role="tabpanel">					
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Vendor Name</span>
                                    </div>
                                    <input id="cvn" name="cvn" type="text" class="form-control">
                                    <input id="cin" name="cin" type="text" class="form-control">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Vendor Service</span>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Vendor Notes</span>
                                    </div>
                                    <textarea id="drn" name="drn" class="form-control" aria-label="With textarea"></textarea>
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
                                    <input id="dc" name="dc" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Vendor Total Cost</span>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                        <span class="input-group-text">Vendor Adjusted Time</span>
                                    </div>
                                    <input id="vah" name="vah" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Hour(s)</span>
                                    </div>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Vendor Estimated Travel</span>
                                    </div>
                                    <input id="vet" name="vet" type="text" class="form-control" aria-label="Vendor Adjusted Hours">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Hour(s)</span>
                                    </div>
                                </div>
                                <div class="input-group-prepend">
                                        <span class="input-group-text">Vendor Total Time</span>
                                    </div>
                                    <input id="tc" name="tc" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="input-group-append">
                                    <span class="input-group-text">Hour(s)</span>
                                    <input type="hidden" name="id" id="id" />
                                    <input type="hidden" name="api" id="api" value="42-077-33876" />
                                    <input type="hidden" name="d" id="d" value="v" />
                                    <input type="hidden" name="t" id="t" value="d" />     
                                    <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" />
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <!-- <button type="submit" name="vend" class="btn btn-primary">Add Entry</button> -->
                                </div>
                            </div>

                            <form id="insert_form-f" method="POST">
                            <div class="tab-pane fade" id="pills-field" role="tabpanel">					
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact Name</span>
                                    </div>
                                    <input name="cvn" type="text" class="form-control">
                                    <input name="cin" type="text" class="form-control">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Contact Info</span>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Daily Report</span>
                                    </div>
                                    <textarea name="drn" class="form-control" aria-label="With textarea"></textarea>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input name="dc" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Estimated Daily Cost</span>
                                    </div>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input name="tc"type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Estimated Cumulative Cost</span>
                                    </div>
                                </div>
                                <input type="hidden" name="id" id="id" />
                                    <input type="hidden" name="api" id="api" value="42-077-33876" />
                                    <input type="hidden" name="d" id="d" value="f" />
                                    <input type="hidden" name="t" id="t" value="d" />     
                                    <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" />
                                </form>
                                <!-- <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                                    <!-- <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-primary">Add Entry</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- </form>   -->
            
        </div>
    </div>
</div>
 <!-- <div id="add_data_Modal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">PHP Ajax Update MySQL Data Through Bootstrap Modal</h4>  
                </div>  
                <div class="modal-body">  
                     <form method="post" id="insert_form">  
                          <label>Date</label>  
                          <input type="text" name="de" id="de" class="form-control" />  
                          <br />  
                          <label>Data Entered By</label>  
                          <textarea name="deb" id="deb" class="form-control"></textarea>  
                          <br />  
                          <label>Date</label>  
                          <select name="d" id="d" class="form-control">  
                               <option value="e">Engineering</option>  
                               <option value="a">Accounting</option>  
                          </select>  
                          <br />  
                          <label>Time Start</label>  
                          <input type="text" name="ts" id="ts" class="form-control" />  
                          <br />  
                          <label>Time End</label>  
                          <input type="text" name="te" id="te" class="form-control" />  
                          <br />  
                          <input type="hidden" name="id" id="id" />
                          <input type="hidden" name="api" id="api" value="42-077-33876" />    
                          <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" />  
                     </form>  
                </div>  
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </div>  
           </div>  
      </div>  
 </div>   -->
 <script>  
 $(document).ready(function(){  
      $('#add').click(function(){  
           $('#insert').val("Insert");  
           $('#insert_form-e')[0].reset();  
           $('#insert_form-f')[0].reset();  
      });  
      $(document).on('click', '.edit_data', function(){  
           var id = $(this).attr("id");  
           $.ajax({  
                url:"fetch.php",  
                method:"POST",  
                data:{id:id},  
                dataType:"json",  
                success:function(data){  
                     $('#deb').val(data.deb);  
                     $('#t').val(data.t);  
                     $('#de').val(data.de);  
                     $('#ts').val(data.ts);  
                     $('#te').val(data.te);  
                     $('#id').val(data.id);  
                     $('#api').val(data.api);  
                     $('#d').val(data.d);  
                     $('#cvn').val(data.cvn);  
                     $('#cin').val(data.cin);  
                     $('#drn').val(data.drn); 
                     $('#dc').val(data.dc);  
                     $('#tc').val(data.tc);  
                     $('#ad').val(data.ad); 

                     $('#insert').val("Update");  
                     $('#add_data_Modal').modal('show');  
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
                     url:"insert.php",  
                     method:"POST",  
                     data:$('#insert_form-e').serialize(),  
                     beforeSend:function(){  
                          $('#insert').val("Inserting");  
                     },  
                     success:function(data){  
                          $('#insert_form-e')[0].reset();  
                          $('#add_data_Modal').modal('hide');  
                          $('#ddr_table').html(data);  
                     }  
                });  
           }  
      });  
      $('#insert_form-f').on("submit", function(event){  
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
                     data:$('#insert_form-f').serialize(),  
                     beforeSend:function(){  
                          $('#insert').val("Inserting");  
                     },  
                     success:function(data){  
                          $('#insert_form-f')[0].reset();  
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