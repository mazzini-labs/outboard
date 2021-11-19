 
  <?php  
  include '../include/wsbFunctions.php';
 if(isset($_REQUEST["id"]))  
 {  
          $output = '<div class="modal-dialog modal-lg" >  
          <div class="modal-content" id="ddr_detail_orig" style="height:90vh!important;">';
//       $output = '<div id="vitals-drawer" class="drawer">
//       <!-- Vitals content -->
//       <div class="drawer-content">
//            <!-- <div class="drawer-dialog modal-lg" >   -->
//                 <div class="drawer-content" id="vitals_detail">
//                 <span class="vitals-drawer-close drawer-close"><i data-feather="x" style="height:28px; width:28px;vertical-align:middle;"></i></span>
//                      <div class="drawer-header">  
//                           <h4 class="modal-title">Vitals Entry Details</h4>   
//                      </div>    
//                 </div>  
//                 </div>  
//            <!-- </div> -->
//       </div>
//  <div id="edit-drawer" class="drawer">
//       <!-- Edit content -->
//       <div class="drawer-content">
//            <!-- <div class="modal-dialog modal-lg" >   -->
//                 <div class="drawer-content" id="edit_detail">
//                 <span class="edit-drawer-close drawer-close"><i data-feather="x" style="height:28px; width:28px;vertical-align:middle;padding-right:2px;"></i></span>
//                      <div class="drawer-header">  
//                           <h4 class="modal-title">Edit Entry Details</h4>  
//                           <button type="button" class="close drawer-close" data-dismiss="modal"><i data-feather="x"></i></button> 
//                      </div>      
//                 </div>  
//            </div>  
//       <!-- </div> -->
//  </div>';  
      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      $connect = mysqli_connect("localhost", "root", "devonian", "wells");  
      $query = "SELECT * FROM notes WHERE id = '".$_POST["id"]."' LIMIT 1";  
      $result = mysqli_query($connect, $query);  
      $output .= '';
      if(isset($_REQUEST["p"]))
      {
           $close = '<p>Printed on  '. date("F j, Y") . '<br> at '. date("h:i:sa").'</p>';
           $col_auto = '-auto';
           $fontS = ' style="font-size: smaller"';
           $fontXL = ' style="font-size: larger"';
      }
      else
      {
           $close = '<button type="button" class="close" style="opacity:1;" data-dismiss="modal"><i data-feather="x" style="height:3vh; width:3vh; stroke:white;"></i></button> ';
           $col_auto = '-auto';
           $fontS = '';
           $fontXL = '';
      }
      while($row = mysqli_fetch_array($result))  
      {  
          $id = $row["id"];
          $d = $row["d"];
          $t = $row["t"];
          $de = $row["de"];
          $deb = $row["deb"];
          $sd = $row["sd"];
          $ts = $row["ts"];
          $te = $row["te"];
          $api = $row["api"];
          $cvn = $row["cvn"];
          $cin = $row["cin"];
          $drn  = preg_replace('/[[:cntrl:]]/', '<br>', $row['drn']);
          $edc = $row["edc"];
          $ecc = $row["ecc"];
          $tt = $row["tt"];   
          $dt = $row["dt"]; 
          $dc = $row["dc"];  
          $at = $row["at"];  
          $ac = $row["ac"];  
          $et = $row["et"]; 
          $ai = $row["ai"]; 
          $ad = $row["ad"]; 
          $ec = $row["ec"];
          if($row['ec'] > 0){
               $checklog = "SELECT eb,ed FROM `notes_log` WHERE api='$api' AND notes_id='$id' ORDER BY ec DESC LIMIT 1";
               $getSD = mysqli_query($connect, $checklog);
               while ($row = mysqli_fetch_assoc($getSD)) 
               {
                    $eb = $row['eb'];
                    
                    $ed = $row['ed'];
                    
               }
               $editinfo = '<tr>  
                                                                      
               </tr>
               <tr>  
                    <td width="40%"><label>Times Edited:</label></td>  
                    <td width="60%">'.$ec.'</td>  
               </tr>
               <tr>  
                    <td width="40%"><label>Last Edited By:</label></td>  
                    <td width="60%">'.$eb.'</td>  
               </tr>
               <tr>  
                    <td width="40%"><label>Date Edited:</label></td>  
                    <td width="60%">'.$ed.'</td>  
               </tr>
               <tr>  
                    <td width="40%"><label></label></td>  
                    <td width="60%">
               
                    
                    </td>
               </tr>
               ';
               $editButton = '<h5 class="btn btn-lg btn-primary" name="view-edits" id="view-edits" value="'.$id.'" type="button" data-toggle="collapse" data-target="#editsSection" aria-expanded="false" aria-controls="collapseExample">
               View Edits
               </h5>';
               $editTable = '<div class="row mx-auto">';
               $editTable = '
               <div id="editsSection" class="collapse text-muted bg-light" style="padding-left:0px;">
                    <table id="editsTable" class="table display table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-condensed table-sm smol table-hover" style="margin-top: 0px !important; width: 100% !important;" >
                         <thead class="smol bg-sog ">
                              <th class="table-header" >Date</th>
                              <th class="table-header" >Time</th>
                              <th class="table-header" >Vendor/Contact</a></th>
                              <th class="table-header" >Invoice #/Contact Info</a></th>
                              <th class="table-header" >Invoice Details/DDR</th>
                              <th class="table-header" >$/EDC</a></th>
                              <th class="table-header" >Approvals/ECC</a></th>
                              <th class="table-header" >Actions</th>
                         </thead>
                    </table>
               </div>';
               $editTable .= '</div>';

               // $editTable
          }
          else 
          {
               $editinfo = "";
               $editTable = "";
          }
          $deleteButton ='<div class="w-100"></div><div class=""><span class="r-tooltip" data-tippy-content="Delete Entry?" tabindex="0">
           <a class="btn btn-warning btn-lg btn-block" data-toggle="collapse" data-target="#collapseDelete">
           <i data-feather="alert-triangle" style="color: black; height: 1.5em!important; width: 1.5em!important;"></i><strong> Delete Entry </strong></a></span></div>
           <div class="collapse" id="collapseDelete" role="alert">
               <div class="alert alert-danger mt-1">
                    <h5 class="alert-heading">Are you sure you want to delete this?<hr class"mb-0"> </h5>
                    <div class="row">
                         <div class="col-auto"><h4><strong class="mb-0">This action cannot be undone:</strong></h4></div>
                         <div class="col"><a class="btn-danger delete_data btn-lg mt-1 break" href="#'.$id.'" id="'.$id.'" style="white-space: normal;"><i data-feather="x" class="feather-lb" style="color: white; height: 1.5em!important; width: 2.5em!important;"></i> Delete Entry </a></div></div>
               </div>
          </div>';
          try
          {
               $queryVitals = "SELECT * FROM `vitals` WHERE api='$api' AND notes_id='$id' ORDER BY d ASC";
               $getVitals = mysqli_query($connect, $queryVitals);
               (mysqli_num_rows($getVitals) > 0) ? $checkVitals = 1 : $checkVitals = 0;
               print_r($checkVitals);
               while ($row = mysqli_fetch_assoc($getVitals))
               {
                    $vitalsInfo = '<div class="table-responsive" >
               <table class="table table-vitals table-light">
                    <tr>
                    </tr>';
                    # General Section
                    $ftp = $row['ftp'];
                    $fcp = $row['fcp'];
                    $injp = $row['injp'];
                    $chlr = $row['chlr'];
                    $fl = $row['fl'];
                    
                    # Maintenance Section
                    $rpj = $row['rpj'];
                    $pmp = $row['pmp'];
                    $pmpa = $row['pmpa'];
                    $pms = $row['pms'];
                    $pmsa = $row['pmsa'];
                    $ct = $row['ct'];

                    # S/I Section
                    $csi = $row['csi'];
                    $rsi = $row['rsi'];
                    $sitp = $row['sitp'];
                    $sicp = $row['sicp'];

                    # Pumping Unit Section
                    $pus = $row['pus'];
                    $pusl = $row['pusl'];
                    $puon = $row['puon'];
                    $puoff = $row['puoff'];
                    $puonoff = $puon.'/'.$puoff;
                    
                    
               } 
               $vitalsButton = '<h5 class="btn btn-primary" name="view-vitals" id="view-vitals" value="'.$id.'" type="button" data-toggle="collapse" data-target="#viewVitalsCollapse" aria-expanded="false" aria-controls="collapseExample">
               View vitals from this entry
               </h5>';
               
               if($ftp != ''){
                    $vitalsInfo .= '<tr>  
                    <td width="40%"><label>Flowing Tubing Pressure</label></td>  
                    <td width="60%">'.$ftp.' psi</td>  
               </tr>';
               }
               
               if($fcp != ''){
                    $vitalsInfo .= '<tr>  
                    <td width="40%"><label>Flowing Casing Pressure</label></td>  
                    <td width="60%">'.$fcp.' psi</td>  
               </tr>';
               }
               
               if($injp != ''){
                    $vitalsInfo .= '<tr>  
                    <td width="40%"><label>Injection Pressure</label></td>  
                    <td width="60%">'.$injp.' psi</td>
               </tr>';
               }
               
               if($chlr != ''){
                    $vitalsInfo .= '<tr>  
                    <td width="40%"><label>Chlorides</label></td>  
                    <td width="60%">'.$chlr.' ppm</td>
               </tr>';
               }
              
               if($fl != ''){
                    $vitalsInfo .= '<tr>  
                    <td><label>Fluid Level</label></td>  
                    <td>'.$fl.' ft</td>  
               </tr>';
               }
               if($rpj != ''){
                    $vitalsInfo .= '<tr>  
                    <td width="40%"><label>Reason for Pull Job</label></td>  
                    <td width="60%">'.$rpj.'</td>
               </tr>';
               }
               
               if($pmp != ''){
                    $vitalsInfo .= '<tr>  
                    <td width="40%"><label>Primary Preventative Maintenance</label></td>  
                    <td width="60%">'.$pmp.'</td>
               </tr>
               ';
               }
               if($pmpa != ''){
                    $vitalsInfo .= '<tr>  
                    <td width="40%"><label>Primary Preventative Maintenance Amount</label></td>  
                    <td width="60%">'.$pmpa.'</td>
               </tr>';
               }
               if($pms != ''){
                    $vitalsInfo .= '<tr>  
                    <td width="40%"><label>Secondary Preventative Maintenance</label></td>  
                    <td width="60%">'.$pms.'</td>
               </tr>';
               }
               if($pmsa != ''){
                    $vitalsInfo .= '<tr>  
                    <td width="40%"><label>Secondary Preventative Maintenance Amount</label></td>  
                    <td width="60%">'.$pmsa.'</td>
               </tr>';
               }
               if($ct != ''){
                    $vitalsInfo .= '<tr>  
                    <td width="40%"><label>Chemical Treatment</label></td>  
                    <td width="60%">'.$ct.'</td>
               </tr>';
               }
               if($csi != ''){
                    $vitalsInfo .= '<tr>  
                    <td width="40%"><label>Cause of S/I</label></td>  
                    <td width="60%">'.$csi.'</td>
               </tr>';
               }
               if($rsi != ''){
                    $vitalsInfo .= '<tr>  
                    <td width="40%"><label>Detailed Reasoning for S/I</label></td>  
                    <td width="60%">'.$rsi.'</td>
               </tr>';
               }
               if($sitp != ''){
                    $vitalsInfo .= '<tr>  
                    <td width="40%"><label>S/I Tubing Pressure</label></td>  
                    <td width="60%">'.$sitp.' psi</td>
               </tr>';
               }
               if($sicp != ''){
                    $vitalsInfo .= '<tr>  
                    <td width="40%"><label>S/I Casing Pressure</label></td>  
                    <td width="60%">'.$sicp.' psi</td>
               </tr>';
               }
               if($pus != ''){
                    $vitalsInfo .= '<tr>  
                    <td width="40%"><label>Pumping Unit Speed</label></td>  
                    <td width="60%">'.$pus.' strokes/min</td>
               </tr>';
               }
               if($pusl != ''){
                    $vitalsInfo .= '<tr>  
                    <td width="40%"><label>Pumping Unit Stroke Length</label></td>  
                    <td width="60%">'.$pusl.' in</td>
               </tr>';
               }
               if($puon != '' || $puoff != ''){
                    $vitalsInfo .= '<tr>  
                    <td width="40%"><label>Pumping Unit On/Off Time</label></td>  
                    <td width="60%">'.$puonoff.' (hr:min)</td>
               </tr>';
               }
               $vitalsInfo .= '
                    </table>  
               </div>
               ';

               // $vitalsInfo = "";
          }
          catch(Exception $e){
               $vitalsButton ="";
               $vitalsInfo = "";
          }
          // try
          // {
               $queryFiles = "SELECT * FROM `notes_files` WHERE api='$api' AND note_id='$id'";
               $getFiles = mysqli_query($connect, $queryFiles);
          if(mysqli_num_rows($getFiles) > 0){ 
               $filesGallery = '<h3 class="text-muted border-bottom">Gallery</h3><div class="file-uploaded-images">';
               $imageCarousel = '<div id="image_carousel" class="carousel slide" data-ride="carousel"><ol class="carousel-indicators">';
               $imageGallery = '</ol><div class="carousel-inner">';
               $i = 0; //image counter
               $j = 0; //microsoft file counter
               $k = 0; //pdf counter

               while ($row = mysqli_fetch_assoc($getFiles))
               {
                    
                    // $photo = $row['file_name'];
                    // $photoFilePath =  "../images/" . $editthis . "/" . $photo;
                    $root = $_SERVER["DOCUMENT_ROOT"];
                    $filePath = $root . $row['filepath'];
                    $type = mime_content_type($filePath);
                    $file = $row['filename'];
                    list($fn, $ext) = preg_split("/./",$file);
                    // if (mime_content_type($filePath) != 'png' || mime_content_type($filePath) != 'jpe' || mime_content_type($filePath) != 'jpeg' 
                    // || mime_content_type($filePath) != 'jpg' || mime_content_type($filePath) != 'gif' 
                    // || mime_content_type($filePath) != 'bmp' || mime_content_type($filePath) != 'ico' 
                    // || mime_content_type($filePath) != 'tiff' || mime_content_type($filePath) != 'tif'){
                    //      $filesGallery .= '<div><a href="'.$row['filepath'].'"></a></div>';
                    //      print_r("Type: " . $type);
                    // }
                    
                    // else { $filesGallery .= '<div class="image"><img src="'.$filePath.'" alt=""></div>'; }
                    // $filesGallery .= '<a href="'.$filePath.'" data-fslightbox="gallery" alt=""></a>';
                    console_log(mime_content_type($filePath));
                    $allowed_images = array (  'image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/tiff', 'image/svg+xml');
                    $allowed_ms = array ('application/msword', 'application/vnd.ms-excel', 'application/vnd.ms-powerpoint', 'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
                    $allowed_msx = array ("application/zip", "application/x-zip", "application/x-zip-compressed");
                    $allowed_other = array ('application/pdf');
                    $msx_extensions = array(".pptx", ".docx", ".dotx", ".xlsx");
                    if(in_array(mime_content_type($filePath), $allowed_images)){
                         $filesGallery .= '<div class="image"><a href="#image_Modal" data-toggle="modal"><img class="rounded" src="'.$row['filepath'].'" alt=""></a></div>';
                         ($i < 1) ? $imageCarousel .= '<li data-target="#image_carousel" data-slide-to="'.$i.'" class="active"></li>' : $imageCarousel .= '<li data-target="#image_carousel" data-slide-to="'.$i.'"></li>';
                         ($i < 1) ? $imageGallery .=  '<div class="carousel-item active"><img src="'.$row['filepath'].'" class="d-block w-100" alt="..."></div>' : $imageGallery .=  '<div class="carousel-item"><img src="'.$row['filepath'].'" class="d-block w-100" alt="..."></div>';
                         // $imageGallery .= '<img class="img-fluid" src="'.$row['filepath'].'"';
                         // $filesGallery .= '<picture><source srcset="'.$row['filepath'].'" type="'.mime_content_type($filePath).'"><img src="'.$row['filepath'].'" class="img-fluid img-thumbnail" alt="..."></picture>';
                         $i++;
                    }
                    elseif(in_array(mime_content_type($filePath), $allowed_ms)){
                         // console_log('File: ' . $file . ' | elseif: ' . mime_content_type($filePath));
                         switch(mime_content_type($filePath))
                         {
                              case 'application/vnd.ms-powerpoint':
                              case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
                                   // $filesGallery .= '<div class="btn btn-secondary powerpoint-select" id="powerpoint'.$j.'" data-file="'.$file.'" data-path="'.$row['filepath'].'" href="'.$row['filepath'].'">View Powerpoint File</div>';
                                   $filesGallery .= '<div class="btn btn-powerpoint powerpoint-select" id="powerpoint'.$j.'" data-file="'.$file.'" data-path="'.$row['filepath'].'" href="'.$row['filepath'].'"><i class="fas fa-file-powerpoint fa-2x"></i> View '.$file.'</div>';
                                   // file-powerpoint
                                   $j++;
                                   break;
                              case 'application/vnd.ms-excel':
                              case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                                   // $filesGallery .= '<div class="btn btn-secondary excel-select" id="excel'.$j.'" data-file="'.$file.'" data-path="'.$row['filepath'].'" href="'.$row['filepath'].'">View Excel File</div>';
                                   $filesGallery .= '<div class="btn btn-excel excel-select" id="excel'.$j.'" data-file="'.$file.'" data-path="'.$row['filepath'].'" href="'.$row['filepath'].'"><i class="fas fa-file-excel fa-2x"></i> View '.$file.'</div>';
                                   // file-excel
                                   $j++;
                                   break;
                              case 'application/msword':
                              case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                                   // $filesGallery .= '<div class="btn btn-secondary word-select" id="word'.$j.'" data-file="'.$file.'" data-path="'.$row['filepath'].'" href="'.$row['filepath'].'">View Word File</div>';
                                   $filesGallery .= '<div class="btn btn-word word-select" id="word'.$j.'" data-file="'.$file.'" data-path="'.$row['filepath'].'" href="'.$row['filepath'].'"><i class="fas fa-file-word fa-2x"></i> View '.$file.'</div>';
                                   // file-word
                                   $j++;
                                   break;
                              default:
                                   $filesGallery .= '<div class="btn btn-word word-select" id="word'.$j.'" data-file="'.$file.'" data-path="'.$row['filepath'].'" href="'.$row['filepath'].'"><i class="fas fa-file-alt fa-2x"></i> View '.$file.'</div>';
                                   $j++;
                                   break;
                         }
                         // $filesGallery .= '<div><a href="'.$row['filepath'].'"></a></div>';
                         // $filesGallery .= '<div><a class="btn btn-secondary" id="excel" data-path="'.$row['filepath'].'" href="'.$row['filepath'].'">View Excel File</a></div>';
                         
                    }
                    elseif(in_array(mime_content_type($filePath), $allowed_msx)){
                         $original_extension = (false === $pos = strrpos($filePath, '.')) ? '' : substr($filePath, $pos);
                         console_log("original extension: " . $original_extension);
                         $finfo = new finfo(FILEINFO_MIME);
                         $type = $finfo->file($filePath);
                         console_log("type: " . $type);
                         if (in_array($type, $allowed_msx) && in_array($original_extension, $msx_extensions))
                         {
                              $filesGallery .= '<div class="btn btn-excel excel-select" id="excel'.$j.'" data-file="'.$file.'" data-path="'.$row['filepath'].'" href="'.$row['filepath'].'">View Excel File</div>';
                              $j++;
                              console_log("Type: " . mime_content_type($filePath));
                              console_log("Extension: " . mime_content_type($ext));
                              return $original_extension;
                         }
                         else
                         {
                              $filesGallery .= '<div class="btn btn-secondary excel-select" id="excel'.$j.'" data-file="'.$file.'" data-path="'.$row['filepath'].'" href="'.$row['filepath'].'">View Excel File</div>';
                              $j++;
                              console_log("Type: " . mime_content_type($filePath));
                              console_log("Extension: " . mime_content_type($ext));
                         }
                    }
                    elseif(in_array(mime_content_type($filePath), $allowed_other)){
                         $filesGallery .= '<div class="btn btn-lg btn-pdf pdf-select" id="pdf'.$k.'" data-file="'.$file.'" data-path="'.$row['filepath'].'" href="'.$row['filepath'].'"><i class="fas fa-file-pdf fa-2x"></i> View '.$file.'</div>';
                         $k++;
                    }
                    else{
                         $filesGallery .= '<div><a href="'.$row['filepath'].'"></a></div>';
                         // console_log("Type: " . mime_content_type($filePath));
                         // console_log("Extension: " . mime_content_type($ext));
                    }
                    // $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
                    // $detected_type = finfo_file( $fileInfo, $filePath );
                    // if ( !in_array($detected_type, $allowed_types) ) {
                    // die ( 'Please upload a pdf or an image ' );
                    // }
                    // finfo_close( $fileInfo );
               }


               $filesGallery .= "</div>";
          }
          else 
          {
               $filesGallery = "<div class='w-100'></div><p>There are no files attached to this entry.</p>";
          }
          // }
          
          // catch(Exception $e){
          //      $filesGallery = "";
          //      // $vitalsInfo = "";
          // }
          switch($t)
          {
               case 's':
                    $dName = "Daily Summary Report";
                    $drnName  = "Summary Report";
                    $edcName = "Daily Cost";
                    
                    $class = "";
                    $output .= '<div class="modal-header '.$class.'">  
                                   <h4 class="modal-title">'.$dName .' Entry Details</h4>  
                                   '.$close.'
                                   </div>  
                                   <div class="modal-body">
                                        <div class="row">
                                             <div class="col'.$col_auto.'"'.$fontS.'>  
                                                  <div class="table-responsive">  
                                                       <table class="table">
                                                            <tr>  
                                                                 <td width="40%"><label>Date</label></td>  
                                                                 <td width="60%">'.$de.'</td>  
                                                            </tr>  
                                                            <tr>  
                                                                 <td width="40%"><label>'.$edcName.'</label></td>  
                                                                 <td width="60%">'.$edc.'</td>  
                                                            </tr>
                                                            <tr>  
                                                                 <td width="40%"><label>Cumulative Cost</label></td>  
                                                                 <td width="60%">'.$ecc.'</td>  
                                                            </tr>            
                                                            <tr>  
                                                                 <td width="40%"><label>Submission Date</label></td>  
                                                                 <td width="60%">'.$sd.'</td>  
                                                            </tr>
                                                            <tr>  
                                                                 <td width="40%"><label>Data Entered by:</label></td>  
                                                                 <td width="60%">'.$deb.'</td>  
                                                            </tr>
                                                       </table>  
                                                  </div>  
                                             </div>
                                             <div class="col"'.$fontXL.'>
                                             <strong>'.$drnName .'</strong>
                                             <br>
                                             '.$drn .'
                                             </div>  
                                        </div>
                                        '.$deleteButton.'
                                   </div> ';
               break;
               default:
                    switch($d)
                         {
                         case "e":
                              $dName = "Engineering";
                              $cvnName  = "Contact Name";
                              $cinName  = "Contact Info";
                              $drnName  = "Daily Report";
                              $edcName = "Daily Cost";
                              
                              $class = "red";
                              $output .= '<div class="modal-header '.$class.'">  
                                             <h4 class="modal-title">'.$dName .' Entry Details</h4>  
                                             '.$close.'
                                        </div>  
                                        <div class="modal-body">
                                             <div class="row">
                                                  <div class="col'.$col_auto.'"'.$fontS.'>  
                                                       <div class="table-responsive">  
                                                            <table class="table">
                                                                 <tr>  
                                                                      <td width="40%"><label>Department</label></td>  
                                                                      <td width="60%">'.$dName .'</td>  
                                                                 </tr>  
                                                                 <tr>  
                                                                      <td width="40%"><label>Date</label></td>  
                                                                      <td width="60%">'.$de.'</td>  
                                                                 </tr>  
                                                                 <tr>  
                                                                      <td width="40%"><label>Time</label></td>  
                                                                      <td width="60%">'.$ts.' - '.$te.'</td>  
                                                                 </tr>  
                                                                 <tr>  
                                                                      <td width="40%"><label>'.$cvnName .'</label></td>  
                                                                      <td width="60%">'.$cvn.'</td>  
                                                                 </tr>  
                                                                 <tr>  
                                                                      <td width="40%"><label>'.$cinName .'</label></td>  
                                                                      <td width="60%">'.$cin.'</td>  
                                                                 </tr>  
                                                                  
                                                                 <tr>  
                                                                      <td width="40%"><label>'.$edcName.'</label></td>  
                                                                      <td width="60%">'.$edc.'</td>  
                                                                 </tr>
                                                                 <tr>  
                                                                      <td width="40%"><label>Cumulative Cost</label></td>  
                                                                      <td width="60%">'.$ecc.'</td>  
                                                                 </tr>            
                                                                 <tr>  
                                                                      <td width="40%"><label>Submission Date</label></td>  
                                                                      <td width="60%">'.$sd.'</td>  
                                                                 </tr>
                                                                 <tr>  
                                                                      <td width="40%"><label>Data Entered by:</label></td>  
                                                                      <td width="60%">'.$deb.'</td>  
                                                                 </tr>
                                                                 '.$editinfo.'    
                                                            </table>  
                                                       </div>  
                                                  </div>
                                                  <div class="col"'.$fontXL.'>
                                                  <strong>'.$drnName .'</strong>
                                                  <br>
                                                  '.$drn .'
                                                  <br>
                                                  '.$filesGallery.'
                                                  </div>
                                                  
                                             </div>
                                             '.$deleteButton.'

                                        </div>';
                         break;
                         case "a":
                              $dName  = "Accounting";
                              $cvnName  = "Vendor Name";
                              $cinName  = "Invoice No.";
                              $drnName  = "Invoice Details";
                              $edcName = "Invoice Amount";
                              $class = "blue";
                              $output .= '<div class="modal-header '.$class.'">  
                                             <h4 class="modal-title">'.$dName .' Entry Details</h4>  
                                             '.$close.'
                                             </div>  
                                        <div class="modal-body">  
                                             <div class="row">
                                                  <div class="col'.$col_auto.'"'.$fontS.'>  
                                                       <div class="table-responsive">  
                                                            <table class="table">
                                                            <tr>  
                                                                 <td width="40%"><label>Department</label></td>  
                                                                 <td width="60%">'.$dName .'</td>  
                                                            </tr>  
                                                            <tr>  
                                                                 <td width="40%"><label>Date</label></td>  
                                                                 <td width="60%">'.$de.'</td>  
                                                            </tr>  
                                                            <tr>  
                                                                 <td width="40%"><label>Time</label></td>  
                                                                 <td width="60%">'.$ts.' - '.$te.'</td>  
                                                            </tr>  
                                                            <tr>  
                                                                 <td width="40%"><label>'.$cvnName .'</label></td>  
                                                                 <td width="60%">'.$cvn.'</td>  
                                                            </tr>  
                                                            <tr>  
                                                                 <td width="40%"><label>'.$cinName .'</label></td>  
                                                                 <td width="60%">'.$cin.'</td>  
                                                            </tr>  
                                                            
                                                            <tr>  
                                                                 <td width="40%"><label>'.$edcName.'</label></td>  
                                                                 <td width="60%">'.$edc.'</td>  
                                                            </tr>
                                                            <tr>  
                                                                 <td width="40%"><label>Approval Date</label></td>  
                                                                 <td width="60%">'.$ad.'</td>  
                                                            </tr>
                                                            <tr>  
                                                                 <td width="40%"><label>Approval Initials</label></td>  
                                                                 <td width="60%">'.$ai.'</td>  
                                                            </tr>
                                                            <tr>  
                                                                 <td width="40%"><label>Submission Date</label></td>  
                                                                 <td width="60%">'.$sd.'</td>  
                                                            </tr>
                                                            <tr>  
                                                                 <td width="40%"><label>Data Entered by:</label></td>  
                                                                 <td width="60%">'.$deb.'</td>  
                                                            </tr>         
                                                            '.$editinfo.'
                                                            </table>  
                                                       </div>  
                                                  </div>
                                                  <div class="col"'.$fontXL.'>
                                                  <strong>'.$drnName .'</strong>
                                                  <br>
                                                  '.$drn .'
                                                  </div>  
                                             </div>
                                             '.$deleteButton.'
                                        </div> 
                                       ';

                         break;
                         case "v":
                              $dName  = "Vendor";
                              $cvnName  = "Vendor Name";
                              $cinName  = "Vendor Service";
                              $drnName  = "Vendor Notes";
                              $class = "gold";
                              $output .= '<div class="modal-header '.$class.'">  
                                             <h4 class="modal-title">'.$dName .' Entry Details</h4>  
                                             '.$close.'
                                             </div>  
                                        <div class="modal-body container-fluid">  
                                             <div class="row mb-3">
                                                  <div class="col'.$col_auto.'"'.$fontS.'>  
                                                       <div class="table-responsive">  
                                                            <table class="table table-sm table-striped table-hover">
                                                                 <tr>  
                                                                      <td width="40%"><label>Department</label></td>  
                                                                      <td width="60%">'.$dName .'</td>  
                                                                 </tr>  
                                                                 <tr>  
                                                                      <td width="40%"><label>Date</label></td>  
                                                                      <td width="60%">'.$de.'</td>  
                                                                 </tr>  
                                                                 <tr>  
                                                                      <td width="40%"><label>Time</label></td>  
                                                                      <td width="60%">'.$ts.' - '.$te.'</td>  
                                                                 </tr>  
                                                                 <tr>  
                                                                      <td width="40%"><label>'.$cvnName .'</label></td>  
                                                                      <td width="60%">'.$cvn.'</td>  
                                                                 </tr>  
                                                                 <tr>  
                                                                      <td width="40%"><label>'.$cinName .'</label></td>  
                                                                      <td width="60%">'.$cin.'</td>  
                                                                 </tr>
                                                                 <tr>  
                                                                      <td width="40%"><label>Submission Date</label></td>  
                                                                      <td width="60%">'.$sd.'</td>  
                                                                 </tr>
                                                                 <tr>  
                                                                      <td width="40%"><label>Data Entered by:</label></td>  
                                                                      <td width="60%">'.$deb.'</td>  
                                                                 </tr>
                                                                 '.$editinfo.'  
                                                            </table>  
                                                       </div>  
                                                  </div>
                                                  <div class="col"'.$fontXL.'>
                                                  <strong>'.$drnName .'</strong>
                                                  <br>
                                                  '.$drn .'
                                                  </div>
                                             </div>
                                             <div class="row">
                                                  <div class="col">
                                                       <div class="table-responsive">  
                                                            <table class="table">
                                                                 <tr>  
                                                                      <td width="15%"><label>Deducted Hours</label></td>  
                                                                      <td width="35%">'.$dt.'</td>
                                                                      <td width="15%"><label>Deducted Cost</label></td>  
                                                                      <td width="35%">'.$dc.'</td>    
                                                                 </tr>
                                                                 <tr>  
                                                                      <td width="15%"><label>Adjusted Hours</label></td>  
                                                                      <td width="35%">'.$at.'</td>  
                                                                      <td width="15%"><label>Adjusted Cost</label></td>  
                                                                      <td width="35%">'.$ac.'</td>  
                                                                 </tr>
                                                                 <tr>  
                                                                      <td width="15%"><label>Estimated Travel Time</label></td>  
                                                                      <td width="35%">'.$et.'</td>
                                                                      <td width="15%"><label>$/Hour</label></td>  
                                                                      <td width="35%">'.$edc.'</td>  
                                                                 </tr>
                                                                 <tr>  
                                                                      <td width="15%"><label>Total Hours</label></td>  
                                                                      <td width="35%"><strong>'.$tt.'</strong></td>
                                                                      <td width="15%"><label>Total Cost</label></td>  
                                                                      <td width="35%"><strong>'.$ecc.'</strong></td>  
                                                                 </tr>
                                                                 <tr>  
                                                                 </tr>
                                                                 <tr>  
                                                                      
                                                                 </tr>
                                                                 <tr>  
                                                                 </tr>
                                                                 <tr>  
                                                                 </tr> 
                                                                 '.$editinfo.'     
                                                            </table>
                                                       </div>  
                                                  </div>  
                                             </div> 
                                             '.$deleteButton.'
                                        </div>';

                         break;
                         default:
                              $dName  = "Field";
                              $cvnName  = "Contact Name";
                              $cinName  = "Contact Info";
                              $drnName  = "Daily Report";
                              $edcName = "Daily Cost";
                              $class = "purple";
                              $output .= '<div class="modal-header '.$class.'">  
                                             <h4 class="modal-title">'.$dName .' Entry Details</h4>  
                                             '.$close.'
                                             </div>  
                                        <div class="modal-body">
                                             <div class="row">
                                                  <div class="col'.$col_auto.'"'.$fontS.'>  
                                                       <div class="table-responsive">  
                                                            <table class="table">
                                                                 <tr>  
                                                                      <td width="40%"><label>Department</label></td>  
                                                                      <td width="60%">'.$dName .'</td>  
                                                                 </tr>  
                                                                 <tr>  
                                                                      <td width="40%"><label>Date</label></td>  
                                                                      <td width="60%">'.$de.'</td>  
                                                                 </tr>  
                                                                 <tr>  
                                                                      <td width="40%"><label>Time</label></td>  
                                                                      <td width="60%">'.$ts.' - '.$te.'</td>  
                                                                 </tr>  
                                                                 <tr>  
                                                                      <td width="40%"><label>'.$cvnName .'</label></td>  
                                                                      <td width="60%">'.$cvn.'</td>  
                                                                 </tr>  
                                                                 <tr>  
                                                                      <td width="40%"><label>'.$cinName .'</label></td>  
                                                                      <td width="60%">'.$cin.'</td>  
                                                                 </tr>  
                                                                  
                                                                 <tr>  
                                                                      <td width="40%"><label>'.$edcName.'</label></td>  
                                                                      <td width="60%">'.$edc.'</td>  
                                                                 </tr>
                                                                 <tr>  
                                                                      <td width="40%"><label>Cumulative Cost</label></td>  
                                                                      <td width="60%">'.$ecc.'</td>  
                                                                 </tr>            
                                                                 <tr>  
                                                                      <td width="40%"><label>Submission Date</label></td>  
                                                                      <td width="60%">'.$sd.'</td>  
                                                                 </tr>
                                                                 <tr>  
                                                                      <td width="40%"><label>Data Entered by:</label></td>  
                                                                      <td width="60%">'.$deb.'</td>  
                                                                 </tr>
                                                                 '.$editinfo.'         
                                                            </table>  
                                                       </div>  
                                                  </div>
                                                  <div class="col"'.$fontXL.'>
                                                  <strong>'.$drnName .'</strong>
                                                  <br>
                                                  '.$drn .'
                                                  </div>  
                                             </div>
                                             '.$deleteButton.'
                                        </div>';
                         break;
               }
          }
          
          if($editinfo != '' && $checkVitals > 0){ $tippy = 'View Edits & Vitals'; $hamburger = '<i data-feather="activity" style="color: white; height: 1.5em!important; width: 1.5em!important;"></i> + <i data-feather="edit-3" style="color: white; height: 1.5em!important; width: 1.5em!important;"></i>'; }
          elseif($editinfo != ''){ $tippy = 'View Edits'; $hamburger = '<i data-feather="edit-3" style="color: white; height: 1.5em!important; width: 1.5em!important;"></i>'; }
          elseif($checkVitals > 0){ $tippy = 'View Vitals'; $hamburger = '<i data-feather="activity" style="color: white; height: 1.5em!important; width: 1.5em!important;"></i>'; }
          if($editinfo != '' || $checkVitals > 0)
          {
               // $extras = '
               // </div>  
               // </div> 
               $extras = '
               <div class="menu-wrap">
                    <input type="checkbox" class="toggler">
                    
                    <div class="hamburger"><h2><i data-feather="plus" style="color: white; height: 1.5em!important; width: 1.5em!important;"></i></h2><div></div></div>
                    <div class="menu" >
                    <div class="card menu-opaque">
                         <div class="card-body text-white" style="width: inherit;">
                              <h5 class="card-title">Extra Information for this entry</h5>
                              <h6 class="card-subtitle mb-2">'.$dName.' entry originally submitted on '.$sd.'</h6>
                              
                              
                         
                         
                              <!-- <ul>
                              <li><a href="#">Home</a></li>
                              <li><a href="#">CSS</a></li>
                              <li><a href="#">Script</a></li>
                              <li><a href="#">Com</a></li>
                              </ul> -->
                              ';
               if($editinfo != '' && $checkVitals > 0){
                    $extras .= '
               
                              <div class="justify-content-center mb-2">
                                   <h5 class="btn btn-lg btn-primary card-link" data-toggle="collapse" href="#viewVitalsCollapse" role="button" aria-expanded="false" aria-controls="viewVitalsCollapse">
                                   Vitals from this entry
                                   </h5>
                                   '.$editButton.'
                              </div>
                              '.$editTable;
                    $extras .= '<div class="collapse" id="viewVitalsCollapse">
                                        '.$vitalsInfo.'
                                   </div>
                                   
                                        
                                   
                              </div>
                         
                         </div>';
               }
               elseif($editinfo != ''){
                    $extras .= '
               
                    <div class="justify-content-center">
                         '.$editButton.'
                    </div>
                    '.$editTable;
               }
               elseif($checkVitals > 0) {
                    $extras .= '<div class="justify-content-center">
                                   <h5 class="btn btn-lg btn-primary card-link" data-toggle="collapse" href="#viewVitalsCollapse" role="button" aria-expanded="false" aria-controls="viewVitalsCollapse">
                                   Vitals from this entry
                                   </h5>
                              </div>
                              <div class="collapse" id="viewVitalsCollapse">
                                        '.$vitalsInfo.'
                                   </div>
                                   
                                        
                                   
                              </div>
                         
                         </div>';
               }
                              
          }
     }  
     $imageGallery .= '<a class="carousel-control-prev" href="#image_carousel" role="button" data-slide="prev">
     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
     <span class="sr-only">Previous</span>
   </a>
   <a class="carousel-control-next" href="#image_carousel" role="button" data-slide="next">
     <span class="carousel-control-next-icon" aria-hidden="true"></span>
     <span class="sr-only">Next</span>
   </a>
 </div>';
      $output .= '</div>  
      </div> 
      ';
      $output .= $extras;  
      $output .= '<div class="modal" id="image_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">  
      <div class="modal-backdrop-white modal-lg" role="document">
          <div class="modal-content">
              <div class="m-xl-n1 modal-header">
                  <h5 class="modal-title" id="exampleModalPreviewLabel">File Gallery</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body" id="image_body">
              '.$imageCarousel.$imageGallery.'
              </div>
              </div>
          </div>
          </div>
          ';
      echo $output;  
 }  
 ?>
 