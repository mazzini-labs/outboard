 
  <?php  
  /* require_once ("Model/FAQ.php");
  $faq = new FAQ();
  $faqResult = $faq->getFAQ(); */
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
 $connect = mysqli_connect("localhost", "root", "devonian", "wells");  
 if(!empty($_POST))  
 {  
      $output = '';  
      $messte = '';  
      $d = mysqli_real_escape_string($connect, $_POST["d-a"]);  
      $t = mysqli_real_escape_string($connect, $_POST["t-a"]);  
      $de = mysqli_real_escape_string($connect, $_POST["de-a"]);  
      $ts = mysqli_real_escape_string($connect, $_POST["ts-a"]);  
      $te = mysqli_real_escape_string($connect, $_POST["te-a"]);
      $deb = mysqli_real_escape_string($connect, $_POST["deb-a"]);  
    //   $sd = mysqli_real_escape_string($connect, $_POST["sd"]);  
      $api = mysqli_real_escape_string($connect, $_POST["api-a"]);  
      $cvn = mysqli_real_escape_string($connect, $_POST["cvn-a"]);  
      $cin = mysqli_real_escape_string($connect, $_POST["cin-a"]);
      $drn = mysqli_real_escape_string($connect, $_POST["drn-a"]);  
      $dc = mysqli_real_escape_string($connect, $_POST["dc-a"]);  
      $tc = mysqli_real_escape_string($connect, $_POST["tc-a"]);  
      $id = mysqli_real_escape_string($connect, $_POST["id-a"]); 
      $ad = mysqli_real_escape_string($connect, $_POST["ad"]); 

      if($id != '')  
      {  
          if($ad !='')
          {
               $ad = mysqli_real_escape_string($connect, $_POST["ad"]);
               $query = "UPDATE ddr SET d='$d', t='$t', de='$de', ts = '$ts', te = '$te', deb = '$deb', cvn = '$cvn', cin = '$cin', drn = '$drn', dc  = '$dc', tc  = '$tc', ad = '$ad' WHERE id='$id'";  
               $messte = 'Data Updated'; 
          }
          else
          {
               $query = "UPDATE ddr SET d='$d', t='$t', de='$de', ts = '$ts', te = '$te', deb = '$deb', cvn = '$cvn', cin = '$cin', drn = '$drn', dc  = '$dc', tc  = '$tc' WHERE id='$id'";  
               $messte = 'Data Updated'; 
          }
      }  
      else  
      {     
          if($ad !='')
          {
            $ad = mysqli_real_escape_string($connect, $_POST["ad"]);
           $query = "INSERT INTO ddr(d, t, de, ts, te, deb, api, cvn, cin, drn, dc, tc, ad)  
           VALUES('$d', '$t', '$de', '$ts', '$te', '$deb', '$api', '$cvn', '$cin', '$drn', '$dc', '$tc', '$ad');  
           ";  
           $messte = 'Data Inserted';  
          }
          else
          {
          $query = "INSERT INTO ddr(d, t, de, ts, te, deb, api, cvn, cin, drn, dc, tc)  
          VALUES('$d', '$t', '$de', '$ts', '$te', '$deb', '$api', '$cvn', '$cin', '$drn', '$dc', '$tc');  
          ";  
          $messte = 'Data Inserted';  
          }
      }  
      if(mysqli_query($connect, $query))  
      {  
          $width1 = "width=1%";
          $width2 = "width=2%";
          $width3 = "width=3%";
          $width4 = "width=4%";
          $width7 = "width=7%";
          $width10 = "width=22%";
          $width14 = "width=24%";
          
          // $output .= '<label class="text-success">' . $messte . '</label>';  
           
           /* $output .= '
           <div id="ddrTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"></div> 
           <table id="ddrTable" class="table display bg-sog table-striped table-borderless datatable-tab-correct datatable-tab-correct1 table-sm dataTable no-footer" style="margin-top: 0px !important; width: 100% !important;"> 
           
           <thead>
               <tr role="row">
                   <th' . $width2 . ' class="sorting" tabindex="0" aria-controls="ddrTable" rowspan="1" colspan="1">Department</th>
                   <th' . $width2 . ' class="sorting" tabindex="0" aria-controls="ddrTable" rowspan="1" colspan="1">Date</th>
                   <th' . $width4 . ' class="sorting" tabindex="0" aria-controls="ddrTable" rowspan="1" colspan="1">Time</th>
                   <th' . $width4 . ' class="sorting" tabindex="0" aria-controls="ddrTable" rowspan="1" colspan="1">Vendor / Contact</a></th>
                   <th' . $width4 . ' class="sorting" tabindex="0" aria-controls="ddrTable" rowspan="1" colspan="1">Invoice # / Contact Info</a></th>
                   <th' . $width10 . ' class="sorting" tabindex="0" aria-controls="ddrTable" rowspan="1" colspan="1">Invoice Details / DDR</th>
                   <th' . $width4 . ' class="sorting" tabindex="0" aria-controls="ddrTable" rowspan="1" colspan="1">$ / EDC</a></th>
                   <th' . $width4 . ' class="sorting" tabindex="0" aria-controls="ddrTable" rowspan="1" colspan="1">Approvals / ECC</a></th>
                   <th' . $width4 . ' class="sorting" tabindex="0" aria-controls="ddrTable" rowspan="1" colspan="1">Actions</th>
               </tr>
           </thead>
           <tbody>  
           ';   */
           $output .= '<tbody id="ddr_table">';
          $ddr = "ddr";
          
          $datasql = "SELECT * FROM $ddr WHERE api='$api' ORDER BY de ASC";
          $dataresult = mysqli_query($connect, $datasql) or die(mysql_error());
          while($datarow = mysqli_fetch_array($dataresult)) 
          {
               $type = $datarow['t'];
               if($type != "s")
               {
                    $i = 0;
                    $d = $datarow['d'];
                    $ddrID = $datarow['id'];
                    switch($d)
                    {
                         case "e":
                         $de = ($datarow['de'] != '') ? $datarow['de'] : " - ";
                         $ts = ($datarow['ts'] != '') ? $datarow['ts'] : " - ";
                         $te = ($datarow['te'] != '') ? $datarow['te'] : " - ";
                         $cvn = ($datarow['cvn'] != '') ? $datarow['cvn'] : " - ";
                         $cin = ($datarow['cin'] != '') ? $datarow['cin'] : " - ";
                         $drn = ($datarow['drn'] != '') ? $datarow['drn'] : " - ";
                         $dc = ($datarow['dc'] != '') ? $datarow['dc'] : " - ";
                         $tc = ($datarow['tc'] != '') ? $datarow['tc'] : " - ";
                         $deb = ($datarow['deb'] != '') ? $datarow['deb'] : " - ";
                         $sd = ($datarow['sd'] != '') ? $datarow['sd'] : " - ";
                         $output .= '  
                                   <tr>
                                        <td class="engineering" ' . $width2 . '><small>Engineering</small></td>
                                        <td class="engineering-date" ' . $width2 . '><small>' . $de . '</td ></small>
                                        <td class="engineering" ' . $width4 . '><small>' . $ts . ' - ' . $te . '</td ></small>
                                        <td class="engineering" ' . $width4 . '><small>' . $cvn . '</a></td ></small>
                                        <td class="engineering" ' . $width4 . '><small>' . $cin . '</td ></small>
                                        <td class="engineering" ' . $width10 . '><small>' . $drn . '</small> </td >
                                        <td class="engineering" ' . $width4 . '><small>' . $dc . '</td ></small>
                                        <td class="engineering" ' . $width4 . '><small>' . $tc . '</td ></small>
                                        <td class="engineering" '.$width4.'>
                                             <input type="button" name="edit" value="Edit" id="'.$datarow["id"].'" class="btn btn-info btn-xs edit_data-'.$datarow["d"].'" />
                                             <input type="button" name="view" value="view" id="'.$datarow["id"].'" class="btn btn-info btn-xs view_data" />
                                        </td>
                                   </tr>
                         '; 
                         break;
                         case "a":
                         $de = ($datarow['de'] != '') ? $datarow['de'] : " - ";
                         $ts = ($datarow['ts'] != '') ? $datarow['ts'] : "";
                         $te = ($datarow['te'] != '') ? $datarow['te'] : "";
                         $cvn = ($datarow['cvn'] != '') ? $datarow['cvn'] : " - ";
                         $cin = ($datarow['cin'] != '') ? $datarow['cin'] : " - ";
                         $drn = ($datarow['drn'] != '') ? $datarow['drn'] : " - ";
                         $dc = ($datarow['dc'] != '') ? $datarow['dc'] : " - ";
                         $tc = ($datarow['tc'] != '') ? $datarow['tc'] : " - ";
                         $ad = ($datarow['ad'] != '') ? $datarow['ad'] : " - ";
                         $deb = ($datarow['deb'] != '') ? $datarow['deb'] : " - ";
                         $sd = ($datarow['sd'] != '') ? $datarow['sd'] : " - ";
                         $time_dash = ($ts == "-" || $te == " - ") ? "" : "-";
                         $output .= '  
                                   <tr>
                                        <td class="accounting" ' . $width2 . '><small>Accounting</small></td>
                                        <td class="accounting" ' . $width2 . '><small>' . $de . '</td ></small>
                                        <td class="accounting" ' . $width4 . '><small>' . $ts . ' - ' . $te . '</td ></small>
                                        <td class="accounting" ' . $width4 . '><small>' . $cvn . '</a></td ></small>
                                        <td class="accounting" ' . $width4 . '><small>' . $cin . '</td ></small>
                                        <td class="accounting" ' . $width10 . '><small>' . $drn . '</small> </td >
                                        <td class="accounting" ' . $width4 . '><small>' . $dc . '</td ></small>
                                        <td class="accounting" ' . $width4 . '><small>Approval Initials:' . $tc . ' <hr>Approval Date:' . $ad . '</td ></small>
                                        <td class="accounting" '.$width4.'>
                                             <input type="button" name="edit" value="Edit" id="'.$datarow["id"].'" class="btn btn-info btn-xs edit_data-'.$datarow["d"].'" />
                                             <input type="button" name="view" value="view" id="'.$datarow["id"].'" class="btn btn-info btn-xs view_data" />
                                        </td>
                                   </tr> 
                         ';
                         break;
                         case "v":
                         $de = ($datarow['de'] != '') ? $datarow['de'] : " - ";
                         $cvn = ($datarow['cvn'] != '') ? $datarow['cvn'] : " - ";
                         //$cvn = $datarow['cvn'] != '') ?  : " - ";
                         $cin = ($datarow['cin'] != '') ? $datarow['cin'] : " - ";
                         $ts = ($datarow['ts'] != '') ? $datarow['ts'] : "";
                         $te = ($datarow['te'] != '') ? $datarow['te'] : "";
                         $vend_hours = ($datarow['vend_hours'] != '') ? $datarow['vend_hours'] : " - ";
                         $dc = ($datarow['dc'] != '') ? "Total Time: " . $datarow['dc'] : " - ";
                         $tc = ($datarow['tc'] != '') ? $datarow['tc'] : " - ";
                         $deb = ($datarow['deb'] != '') ? $datarow['deb'] : " - ";
                         $sd = ($datarow['sd'] != '') ? $datarow['sd'] : " - ";
                         $drn = ($datarow['drn'] != '') ? "Notes: " . $datarow['drn'] : " - ";
                        $output .= '
                                   <tr>
                                        <td class="vendor" ' . $width2 . '><small>Vendor</small></td>
                                        <td class="vendor" ' . $width2 . '><small>' . $de . '</td ></small>
                                        <td class="vendor" ' . $width4 . '><small>' . $ts . ' - ' . $te . '</td ></small>
                                        <td class="vendor" ' . $width4 . '><small>' . $cvn . '</a></td ></small>
                                        <td class="vendor" ' . $width4 . '><small>' . $cin . '</td ></small>
                                        <td class="vendor" ' . $width10 . '><small>' . $drn . '</small> </td >                                       
                                        <td class="vendor" ' . $width4 . '><small>' . $dc . '</td ></small>
                                        <td class="vendor" ' . $width4 . '><small>' . $tc . '</td ></small>
                                        <td class="vendor" '.$width4.'>
                                             <input type="button" name="edit" value="Edit" id="'.$datarow["id"].'" class="btn btn-info btn-xs edit_data-'.$datarow["d"].'" />
                                             <input type="button" name="view" value="view" id="'.$datarow["id"].'" class="btn btn-info btn-xs view_data" />
                                        </td>
                                   </tr>
                         '; 
                         break;
                         default:
                         $de = ($datarow['de'] != '') ? $datarow['de'] : " - ";
                         $ts = ($datarow['ts'] != '') ? $datarow['ts'] : " - ";
                         $te = ($datarow['te'] != '') ? $datarow['te'] : " - ";
                         $cvn = ($datarow['cvn'] != '') ? $datarow['cvn'] : " - ";
                         $cin = ($datarow['cin'] != '') ? $datarow['cin'] : " - ";
                         $drn = ($datarow['drn'] != '') ? $datarow['drn'] : " - ";
                         $dc = ($datarow['dc'] != '') ? $datarow['dc'] : " - ";
                         $tc = ($datarow['tc'] != '') ? $datarow['tc'] : " - ";
                         $output .= '
                                   <tr>
                                        <td class="field" ' . $width2 . '><small>Field</small></td>
                                        <td class="field" ' . $width2 . '><small>' . $de . '</small></td >
                                        <td class="field" ' . $width4 . '><small>' . $ts . ' - ' . $te . '</small></td >
                                        <td class="field" ' . $width4 . '><small>' . $cvn . '</small></td >
                                        <td class="field" ' . $width4 . '><small>' . $cin . '</small></td >
                                        <td class="field" ' . $width10 . '><small>' . $drn . '</small></td >
                                        <td class="field" ' . $width4 . '><small>' . $dc . '</small></td >
                                        <td class="field" ' . $width4 . '><small>' . $tc . '</small></td >
                                        <td class="field" '.$width4.'>
                                             <input type="button" name="edit" value="Edit" id="'.$datarow["id"].'" class="btn btn-info btn-xs edit_data-'.$datarow["d"].'" />
                                             <input type="button" name="view" value="view" id="'.$datarow["id"].'" class="btn btn-info btn-xs view_data" />
                                        </td>
                                   </tr>
                         '; 
                         break;
                    }
                    $i++; 
               }
          } 
          $output .= '</tbody>';
          
      }  
      echo $output;   
 }  
 ?>
 