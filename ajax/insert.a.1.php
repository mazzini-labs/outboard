 
  <?php  
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
      

      if($_POST["id"] != '')  
      {  
           $query = "  
           UPDATE ddr   
           SET d='$d',   
           t='$t',   
           de='$de',   
           ts = '$ts',   
           te = '$te'   
           WHERE api='".$_POST["api-a"]."'
           AND id='".$_POST["id-a"]."'";  
           $messte = 'Data Updated';  
      }  
      else  
      {     
          if(isset($_POST["ad-a"]))
          {
            $ad = mysqli_real_escape_string($connect, $_POST["ad-a"]);
           $query = "  
           INSERT INTO ddr(d, t, de, ts, te, deb, api, cvn, cin, drn, dc, tc, ad)  
           VALUES('$d', '$t', '$de', '$ts', '$te', '$deb', '$api', '$cvn', '$cin', '$drn', '$dc', '$tc', '$ad');  
           ";  
           $messte = 'Data Inserted';  
          }
          else
          {
          $query = "  
          INSERT INTO ddr(d, t, de, ts, te, deb, api, cvn, cin, drn, dc, tc)  
          VALUES('$d', '$t', '$de', '$ts', '$te', '$deb', '$api', '$cvn', '$cin', '$drn', '$dc', '$tc');  
          ";  
          $messte = 'Data Inserted';  
          }
      }  
      if(mysqli_query($connect, $query))  
      {  
           $output .= '<label class="text-success">' . $messte . '</label>';  
           $select_query = "SELECT * FROM ddr WHERE api = '$api' ORDER BY de DESC";  
           $result = mysqli_query($connect, $select_query);  
           $output .= '  
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
           ';  
           while($row = mysqli_fetch_array($result))  
           {  
                $output .= '  
                     <tr>  
                          <td>' . $row["d"] . '</td>  
                          <td>' . $row["de"] . '</td>
                          <td>' . $row["ts"] . ' - ' .$row["te"] . '</td>    
                          <td>' . $row["cvn"] . '</td>  
                          <td>' . $row["cin"] . '</td>  
                          <td>' . $row["drn"] . '</td>  
                          <td>' . $row["dc"] . '</td>  
                          <td>' . $row["tc"] . '</td>  
                          <td>' . $row["ad"] . '</td>  
                          <td>' . $row["sd"] . '</td>  
                          <td>' . $row["deb"] . '</td>  
                          <td><input type="button" d="edit" value="Edit" id="'.$row["id"] .'" class="btn btn-info btn-xs edit_data" /></td>  
                          <td><input type="button" d="view" value="view" id="' . $row["id"] . '" class="btn btn-info btn-xs view_data" /></td>  
                     </tr>  
                ';  
           }  
           $output .= '</table>';  
      }  
      echo $output;  
 }  
 ?>
 