 
  <?php  
 if(isset($_POST["id"]))  
 {  
      $output = '';  
      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      $connect = mysqli_connect("localhost", "root", "devonian", "wells");  
      $query = "SELECT * FROM notes WHERE id = '".$_POST["id"]."' LIMIT 1";  
      $result = mysqli_query($connect, $query);  
      $output .= '';  
      while($row = mysqli_fetch_array($result))  
      {  
          switch($row["d"])
          {
              case "e":
                $d = "Engineering";
                $class = "red";
              break;
              case "a":
                $d = "Accounting";
                $class = "blue";
              break;
              case "v":
                $d = "Vendor";
                $class = "gold";
              break;
              case 'f':
                $d = "Field";
                $class = "purple";
               default:
                $d = "DSR";
                $class = "";
            break;
          }
          $output .= '<div class="modal-header '.$class.'">  
                              <h4 class="modal-title">'.$d.' Entry Details</h4>  
                              <button type="button" class="close" data-dismiss="modal">&times;</button>  
                         </div>  
                         <div class="modal-body">  
                    
                    <div class="table-responsive">  
                    <table class="table">';
           $output .= '  
                <tr>  
                     <td width="30%"><label>Department</label></td>  
                     <td width="70%">'.$d.'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Date</label></td>  
                     <td width="70%">'.$row["de"].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Time</label></td>  
                     <td width="70%">'.$row["ts"].' - '.$row["te"].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Contact/Vendor Name</label></td>  
                     <td width="70%">'.$row["cvn"].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Contact Info/Invoice No./Vendor Service</label></td>  
                     <td width="70%">'.$row["cin"].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Daily Report/Invoice Details/Vendor Notes</label></td>  
                     <td width="70%">'.$row["drn"].'</td>  
                </tr> 
                <tr>  
                     <td width="30%"><label>Daily Cost/Invoice Amount/Vendor Total Hours</label></td>  
                     <td width="70%">'.$row["dc"].'</td>  
                </tr>
                <tr>  
                     <td width="30%"><label>Cumulative Cost/Approval Initials/Vendor Total Hours</label></td>  
                     <td width="70%">'.$row["tc"].'</td>  
                </tr>
                <tr>  
                     <td width="30%"><label>Approval Date</label></td>  
                     <td width="70%">'.$row["ad"].'</td>  
                </tr>
                <tr>  
                     <td width="30%"><label>Submission Date</label></td>  
                     <td width="70%">'.$row["sd"].'</td>  
                </tr>
                <tr>  
                     <td width="30%"><label>Data Entered by:</label></td>  
                     <td width="70%">'.$row["deb"].'</td>  
                </tr>                        
           ';  
      }  
      $output .= '
               </div>  
           </table>  
      </div>  
      ';  
      echo $output;  
 }  
 ?>
 