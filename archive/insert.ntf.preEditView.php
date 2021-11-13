 
  <?php  
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
 $connect = mysqli_connect("localhost", "root", "devonian", "wells");  
 Function console_log($output, $with_script_tags = true) {
     $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
   ');';
     if ($with_script_tags) {
         $js_code = '<script>' . $js_code . '</script>';
     }
     echo $js_code;
   }
 if(!empty($_POST))  
 {  
      if(isset($_POST["d"])){ $d = mysqli_real_escape_string($connect, $_POST["d"]);    }      # Department. Enums are e = Engineering, a = Accounting, v = Vendor, f = Field, s = DSR
      if(isset($_POST["t"])){ $t = mysqli_real_escape_string($connect, $_POST["t"]);    }      # Type. Enums are d = DDR, s = DSR, & n = Not Engineering.
      if(isset($_POST["de"])){ $de = mysqli_real_escape_string($connect, $_POST["de"]);  }     # Date of Entry
      if(isset($_POST["deb"])){ $deb = mysqli_real_escape_string($connect, $_POST["deb"]); }   # Data Entered By
      if(isset($_POST["ts"])){ $ts = mysqli_real_escape_string($connect, $_POST["ts"]);  }     # Time (Start)
      if(isset($_POST["te"])){ $te = mysqli_real_escape_string($connect, $_POST["te"]);  }     # Time (End)
      if(isset($_POST["api"])){ $api = mysqli_real_escape_string($connect, $_POST["api"]); }   # API number. Used to identify which well the entry belongs to. 
      if(isset($_POST["cvn"])){ $cvn = mysqli_real_escape_string($connect, $_POST["cvn"]); }   # Contact name (for e or f) or vendor name (for a or v)
      if(isset($_POST["cin"])){ $cin = mysqli_real_escape_string($connect, $_POST["cin"]); }   # Contact info (for e or f), invoice number (for a), or vendor service (for v)
      if(isset($_POST["drn"])){ $drn = mysqli_real_escape_string($connect, $_POST["drn"]); }   # Daily report (for e or f), invoice details (for a), or vendor notes (for v). 
                                                                                               #    Note that vendor notes may include subtotal hours, deducted time/cost/reason, adjusted hours/time, & estimated travel time.
      if(isset($_POST["edc"]) !== ''){$edc = mysqli_real_escape_string($connect, $_POST["edc"]); } else {$edc = 0.00;}   # Daily cost (for e or f), invoice amount (for a), or $/hr (for v).
      if(isset($_POST["ecc"])){$ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); }    # Cumulative cost (for e or f) or total cost (for v).
      if(isset($_POST["id"])){ $id = mysqli_real_escape_string($connect, $_POST["id"]); }
     
      if(isset($_POST["ftp"])){$ftp  = mysqli_real_escape_string($connect,$_POST["ftp"]);}
      if(isset($_POST["fcp"])){$fcp  = mysqli_real_escape_string($connect,$_POST["fcp"]);}
      if(isset($_POST["sitp"])){$sitp = mysqli_real_escape_string($connect,$_POST["sitp"]);}
      if(isset($_POST["sicp"])){$sicp = mysqli_real_escape_string($connect,$_POST["sicp"]);}
      if(isset($_POST["chlr"])){$chlr  = mysqli_real_escape_string($connect,$_POST["chlr"]);}
      if(isset($_POST["pmp"])){$pmp  = mysqli_real_escape_string($connect,$_POST["pmp"]);}
      if(isset($_POST["fl"])){$fl   = mysqli_real_escape_string($connect,$_POST["fl"]);}
      if(isset($_POST["pms"])){$pms  = mysqli_real_escape_string($connect,$_POST["pms"]);}
      if(isset($_POST["ct"])){$ct   = mysqli_real_escape_string($connect,$_POST["ct"]);}
      if(isset($_POST["pus"])){$pus  = mysqli_real_escape_string($connect,$_POST["pus"]);}
      if(isset($_POST["rsi"])){$rsi  = mysqli_real_escape_string($connect,$_POST["rsi"]);}
      if(isset($_POST["pusl"])){$pusl = mysqli_real_escape_string($connect,$_POST["pusl"]);}
      if(isset($_POST["csi"])){$csi  = mysqli_real_escape_string($connect,$_POST["csi"]);}
      if(isset($_POST["rpj"])){$rpj  = mysqli_real_escape_string($connect,$_POST["rpj"]);}
      if(isset($_POST["pmpa"])){$pmpa = mysqli_real_escape_string($connect,$_POST["pmpa"]);}
      if(isset($_POST["pmsa"])){$pmsa = mysqli_real_escape_string($connect,$_POST["pmsa"]);}
      if(isset($_POST["puon"])){$puon = mysqli_real_escape_string($connect,$_POST["puoff"]);}
      if(isset($_POST["puoff"])){$puoff = mysqli_real_escape_string($connect,$_POST["puon"]);}
      // ftp 
      // fcp 
      // sitp
      // sicp
      // chlr 
      // pmp 
      // fl  
      // pms 
      // ct  
      // pus 
      // rsi 
      // pusl
      // csi 
      // rpj 
      // pmpa
      // pmsa
      switch($t)
      {
           case 's':
               if($_POST["id"] != '')  
               {  
                    $query = "  
                    UPDATE notes   
                    SET d='$d',   
                    t='$t',   
                    de='$de',   
                    deb = '$deb',
                    drn = '$drn',
                    edc = '$edc',
                    ecc = '$ecc'   
                    WHERE api='$api'
                    AND id='$id'";  
                    $messte = 'Data Updated';  
               }  
               else  
               {     
                    $query = "  
                         INSERT INTO notes(d, t, de, deb, api, drn, edc, ecc)  
                         VALUES('$d', '$t', '$de', '$deb', '$api', '$drn', '$edc', '$ecc');  
                         ";  
                    $messte = 'Data Inserted';  
               }
               if(mysqli_query($connect, $query))  
               {  
                   $output = '';
                   $output .= '<tbody id="dsr_table">';
                   $ddr = "notes";
                   
                   $datasql = "SELECT * FROM $ddr WHERE api='$api' and `t` like '%s%' ORDER BY de ASC";
                   $dataresult = mysqli_query($connect, $datasql) or die(mysql_error());
                   while($datarow = mysqli_fetch_array($dataresult)) 
                   {
                         $de = ($datarow['de'] != '') ? $datarow['de'] : " - ";
                         $drn = ($datarow['drn'] != '') ? $datarow['drn'] : " - ";
                         $edc = ($datarow['edc'] != '') ? "$" . $datarow['edc'] : " - ";
                         $ecc = ($datarow['ecc'] != '') ? "$" . $datarow['ecc'] : " - ";
                         $output .= '  
                                   <tr>
                                        <td class="engineering-date" ' . $width2 . '><small>' . $de . '</td ></small>
                                        <td class="engineering" ' . $width10 . '><small>' . $drn . '</small> </td >
                                        <td class="engineering" ' . $width4 . '><small>' . $edc . '</td ></small>
                                        <td class="engineering" ' . $width4 . '><small>' . $ecc . '</td ></small>
                                   </tr>
                         '; 
                   } 
                   $output .= '</tbody>';
                   
               }  
               echo $output;           
           break;
           default:
               switch($d)
               {
                    case 'v':
                         $fields = 'd, t, de, ts, te, deb, api, cvn, cin, drn, ';
                         $values = "'$d', '$t', '$de', '$ts', '$te', '$deb', '$api', '$cvn', '$cin', '$drn', ";

                         
                         if($_POST["dt"] != '')
                         { 
                              $dt = mysqli_real_escape_string($connect, $_POST["dt"]); 
                              $values .= "'$dt', ";
                              $fields .= 'dt, ';
                         } #
                         if($_POST["dc"] != '')
                         { 
                              $dc = mysqli_real_escape_string($connect, $_POST["dc"]); 
                              $values .= "'$dc', ";
                              $fields .= 'dc, ';
                         } #
                         if($_POST["at"] != '')
                         { 
                              $at = mysqli_real_escape_string($connect, $_POST["at"]); 
                              $values .= "'$at', ";
                              $fields .= 'at, ';
                         } #
                         if($_POST["ac"] != '')
                         { 
                              $ac = mysqli_real_escape_string($connect, $_POST["ac"]); 
                              $values .= "'$ac', ";
                              $fields .= 'ac, ';
                         } #
                         if($_POST["et"] != '')
                         { 
                              $et = mysqli_real_escape_string($connect, $_POST["et"]); 
                              $values .= "'$et', ";
                              $fields .= 'et, ';
                         } #
                         if($_POST["tt"] != '')
                         { 
                              $tt = mysqli_real_escape_string($connect, $_POST["tt"]); 
                              $values .= "'$tt'";
                              $fields .= 'tt';
                         } # 
                         

                         // 
                         // $edc = ($edc != '') ? $edc : 
                         if($_POST["id"] != '')  
                         {  
                              $query = "  
                              UPDATE notes   
                              SET d='$d',   
                              t='$t',   
                              de='$de',   
                              ts = '$ts',   
                              te = '$te',
                              deb = '$deb',
                              cvn = '$cvn',
                              cin = '$cin',
                              drn = '$drn',
                              edc = '$edc',
                              ecc = '$ecc',
                              tt = '$tt',
                              dt = '$dt',
                              dc = '$dc',
                              at = '$at',
                              ac = '$ac',
                              et = '$et'   
                              WHERE api='$api'
                              AND id='$id'";  
                              $messte = 'Data Updated';  
                         }  
                         else  
                         {    
                              
                              /* $query = "  
                                   INSERT INTO notes(d, t, de, ts, te, deb, api, cvn, cin, drn, edc, ecc, tt, dt, dc, at, ac, et)  
                                   VALUES('$d', '$t', '$de', '$ts', '$te', '$deb', '$api', '$cvn', '$cin', '$drn', '$edc', '$ecc', '$tt', '$dt', '$dc', '$at', '$ac', '$et');  
                                   "; */
                              $query = "  
                                   INSERT INTO notes($fields)  
                                   VALUES($values);  
                                   ";  
                              $messte = 'Data Inserted';  
                              
                         }           
                    break;
                    case 'a':
                         if($_POST["ad"] != '')  
                         {  
                              $ai = mysqli_real_escape_string($connect, $_POST["ai"]);
                              $ad = mysqli_real_escape_string($connect, $_POST["ad"]);
                              if($_POST["id"] != '')
                              {
                                   $query = "  
                                   UPDATE notes   
                                   SET d='$d',   
                                   t='$t',   
                                   de='$de',   
                                   ts = '$ts',   
                                   te = '$te',
                                   deb = '$deb',
                                   cvn = '$cvn',
                                   cin = '$cin',
                                   drn = '$drn',
                                   edc = '$edc',
                                   ai = '$ai',  
                                   ad =  '$ad'
                                   WHERE api='$api'
                                   AND id='$id'";  
                                   $messte = 'Data Updated';  
     
                              }
                              else
                              {
                                   $query = "  
                                   INSERT INTO notes(d, t, de, ts, te, deb, api, cvn, cin, drn, edc, ai, ad)  
                                   VALUES('$d', '$t', '$de', '$ts', '$te', '$deb', '$api', '$cvn', '$cin', '$drn', '$edc', '$ai', '$ad');  
                                   ";  
                                   $messte = 'Data Inserted';  

                              }
                         }  
                         else  
                         {     
                              if($_POST["id"] != '')
                              {
                                   $query = "  
                                   UPDATE notes   
                                   SET d='$d',   
                                   t='$t',   
                                   de='$de',   
                                   ts = '$ts',   
                                   te = '$te',
                                   deb = '$deb',
                                   cvn = '$cvn',
                                   cin = '$cin',
                                   drn = '$drn',
                                   edc = '$edc'
                                   WHERE api='$api'
                                   AND id='$id'";  
                                   $messte = 'Data Updated';  
                              }
                              else
                              {
                                   $query = "  
                                   INSERT INTO notes(d, t, de, ts, te, deb, api, cvn, cin, drn, edc)  
                                   VALUES('$d', '$t', '$de', '$ts', '$te', '$deb', '$api', '$cvn', '$cin', '$drn', '$edc');  
                                   ";  
                                   $messte = 'Data Inserted';  
                              }
                         }           
                    break;
                    case 'e':
                         
                         // console_log($fields);
                         $vitalsF = "";
                         $vitalsV = "";
                         $vitalsT = "";
                         if($_POST["ftp"] != '')
                         { 
                              
                              $ftp = mysqli_real_escape_string($connect, $_POST["ftp"]); 
                              $vitalsV .= "'$ftp'";
                              $vitalsF .= "ftp";
                         } #
                         if($_POST["fcp"] != '')
                         { 
                              if(($vitalsF != "") && ($vitalsV != ""))
                              {
                                   $vitalsF .= ", ";
                                   $vitalsV .= ", ";
                              }
                              $fcp = mysqli_real_escape_string($connect, $_POST["fcp"]); 
                              $vitalsV .= "'$fcp'";
                              $vitalsF .= "fcp";
                         }
                         if($_POST["sitp"] != '')
                         { 
                              if(($vitalsF != "") && ($vitalsV != ""))
                              {
                                   $vitalsF .= ", ";
                                   $vitalsV .= ", ";
                              }
                              $sitp = mysqli_real_escape_string($connect, $_POST["sitp"]); 
                              $vitalsV .= "'$sitp'";
                              $vitalsF .= "sitp";
                         } #
                         if($_POST["sicp"] != '')
                         { 
                              if(($vitalsF != "") && ($vitalsV != ""))
                              {
                                   $vitalsF .= ", ";
                                   $vitalsV .= ", ";
                              }
                              $sicp = mysqli_real_escape_string($connect, $_POST["sicp"]); 
                              $vitalsV .= "'$sicp'";
                              $vitalsF .= 'sicp';
                         } #
                         if($_POST["chlr"] != '')
                         { 
                              if(($vitalsF != "") && ($vitalsV != ""))
                              {
                                   $vitalsF .= ", ";
                                   $vitalsV .= ", ";
                              }
                              $chlr = mysqli_real_escape_string($connect, $_POST["chlr"]); 
                              $vitalsV .= "'$chlr'";
                              $vitalsF .= 'chlr';
                         } #
                         if($_POST["pmp"] != '')
                         { 
                              if(($vitalsF != "") && ($vitalsV != ""))
                              {
                                   $vitalsF .= ", ";
                                   $vitalsV .= ", ";
                              }
                              $pmp = mysqli_real_escape_string($connect, $_POST["pmp"]); 
                              $vitalsV .= "'$pmp'";
                              $vitalsF .= 'pmp';
                         } #
                         if($_POST["fl"] != "")
                         { 
                              if(($vitalsF != "") && ($vitalsV != ""))
                              {
                                   $vitalsF .= ", ";
                                   $vitalsV .= ", ";
                              }
                              $fl = mysqli_real_escape_string($connect, $_POST["fl"]); 
                              $vitalsV .= "'$fl'";
                              $vitalsF .= 'fl';
                         } # 
                         if($_POST["pms"] != '')
                         { 
                              if(($vitalsF != "") && ($vitalsV != ""))
                              {
                                   $vitalsF .= ", ";
                                   $vitalsV .= ", ";
                              }
                              $pms = mysqli_real_escape_string($connect, $_POST["pms"]); 
                              $vitalsV .= "'$pms'";
                              $vitalsF .= "pms";
                         } #
                         if($_POST["ct"] != '')
                         { 
                              if(($vitalsF != "") && ($vitalsV != ""))
                              {
                                   $vitalsF .= ", ";
                                   $vitalsV .= ", ";
                              }
                              $ct = mysqli_real_escape_string($connect, $_POST["ct"]); 
                              $vitalsV .= "'$ct'";
                              $vitalsF .= "ct";
                         } #
                         if($_POST["pus"] != '')
                         { 
                              if(($vitalsF != "") && ($vitalsV != ""))
                              {
                                   $vitalsF .= ", ";
                                   $vitalsV .= ", ";
                              }
                              $pus = mysqli_real_escape_string($connect, $_POST["pus"]); 
                              $vitalsV .= "'$pus'";
                              $vitalsF .= 'pus';
                         } #
                         if($_POST["rsi"] != '')
                         { 
                              if(($vitalsF != "") && ($vitalsV != ""))
                              {
                                   $vitalsF .= ", ";
                                   $vitalsV .= ", ";
                              }
                              $rsi = mysqli_real_escape_string($connect, $_POST["rsi"]); 
                              $vitalsV .= "'$rsi'";
                              $vitalsF .= 'rsi';
                         } #
                         if($_POST["pusl"] != '')
                         { 
                              if(($vitalsF != "") && ($vitalsV != ""))
                              {
                                   $vitalsF .= ", ";
                                   $vitalsV .= ", ";
                              }
                              $pusl = mysqli_real_escape_string($connect, $_POST["pusl"]); 
                              $vitalsV .= "'$pusl'";
                              $vitalsF .= 'pusl';
                         } #
                         if($_POST["csi"] != '')
                         { 
                              if(($vitalsF != "") && ($vitalsV != ""))
                              {
                                   $vitalsF .= ", ";
                                   $vitalsV .= ", ";
                              }
                              $csi = mysqli_real_escape_string($connect, $_POST["csi"]); 
                              $vitalsV .= "'$csi'";
                              $vitalsF .= 'csi';
                         } #       
                         if($_POST["rpj"] != '')
                         { 
                              if(($vitalsF != "") && ($vitalsV != ""))
                              {
                                   $vitalsF .= ", ";
                                   $vitalsV .= ", ";
                              }
                              $rpj = mysqli_real_escape_string($connect, $_POST["rpj"]); 
                              $vitalsV .= "'$rpj'";
                              $vitalsF .= "rpj";
                         } #
                         if($_POST["pmpa"] != '')
                         { 
                              if(($vitalsF != "") && ($vitalsV != ""))
                              {
                                   $vitalsF .= ", ";
                                   $vitalsV .= ", ";
                              }
                              $pmpa = mysqli_real_escape_string($connect, $_POST["pmpa"]); 
                              $vitalsV .= "'$pmpa'";
                              $vitalsF .= "pmpa";
                         } #
                         if($_POST["pmsa"] != '')
                         { 
                              if(($vitalsF != "") && ($vitalsV != ""))
                              {
                                   $vitalsF .= ", ";
                                   $vitalsV .= ", ";
                              }
                              $pmsa = mysqli_real_escape_string($connect, $_POST["pmsa"]); 
                              $vitalsV .= "'$pmsa'";
                              $vitalsF .= 'pmsa';
                         } #
                         if($_POST["puon"] != '')
                         { 
                              if(($vitalsF != "") && ($vitalsV != ""))
                              {
                                   $vitalsF .= ", ";
                                   $vitalsV .= ", ";
                              }
                              $puon = mysqli_real_escape_string($connect, $_POST["puon"]); 
                              $vitalsV .= "'$puon'";
                              $vitalsF .= 'puon';
                         } #
                         if($_POST["puoff"] != '')
                         { 
                              if(($vitalsF != "") && ($vitalsV != ""))
                              {
                                   $vitalsF .= ", ";
                                   $vitalsV .= ", ";
                              }
                              $puoff = mysqli_real_escape_string($connect, $_POST["puoff"]); 
                              $vitalsV .= "'$puoff'";
                              $vitalsF .= 'puoff';
                         } #
                         console_log($vitalsV);
                         console_log($vitalsF);
                         if($_POST["id"] != '')  
                         {  
                              
                              $update = "d='$d', ";
                              $update .= "t='$t', ";
                              $update .= "de='$de', ";
                              $update .= "ts = '$ts', ";
                              $update .= "te = '$te', ";
                              $update .= "deb = '$deb', ";
                              $update .= "cvn = '$cvn', ";
                              $update .= "cin = '$cin', ";
                              $update .= "drn = '$drn'";
                              if($_POST["edc"] != '')
                              { 

                                   $update .= ", ";
                                   $edc = mysqli_real_escape_string($connect, $_POST["edc"]); 
                                   $update .= "edc = '$edc'";
                              } #
                              if($_POST["ecc"] != '')
                              { 
                                   $update .= ", ";
                                   $ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); 
                                   $update .= "ecc = '$ecc'";
                              }

                              $query = "UPDATE notes SET " . $update . " WHERE api='$api' AND id='$id'"; 
                              console_log($query);
                              if(($vitalsF != "") && ($vitalsV != ""))
                              {
                                   $vitalsF .= ", ";
                                   $vitalsV .= ", ";
                                   $pmsa = mysqli_real_escape_string($connect, $_POST["de"]); 
                                   $vitalsV .= "'$de'";
                                   $vitalsF .= 'd';
                                   $vitalsF .= ", ";
                                   $vitalsV .= ", ";
                                   $pmsa = mysqli_real_escape_string($connect, $_POST["api"]); 
                                   $vitalsV .= "'$api'";
                                   $vitalsF .= 'api';
                                   $vitalsQ = "INSERT INTO vitals(".$vitalsF.") VALUES(".$vitalsV.");"; 
                                   $vitalsT = "Y"; 
                                   // console_log($vitalsQ);
                                   console_log($vitalsT);
                                   
                              }
                              // $query = "  
                              // UPDATE notes   
                              // SET d='$d',   
                              // t='$t',   
                              // de='$de',   
                              // ts = '$ts',   
                              // te = '$te',
                              // deb = '$deb',
                              // cvn = '$cvn',
                              // cin = '$cin',
                              // drn = '$drn',
                              // edc = '$edc',
                              // ecc = '$ecc'   
                              // WHERE api='$api'
                              // AND id='$id'";  
                              // $messte = 'Data Updated';  
                         }  
                         else
                         {     
                              #MOVED FROM LINE 271 / RIGHT AFTER CASE E
                              $fields = "d, t, de, ts, te, deb, api, cvn, cin, drn";
                              $values = "'$d', '$t', '$de', '$ts', '$te', '$deb', '$api', '$cvn', '$cin', '$drn'";
                              if($_POST["edc"] != '')
                              { 
                                   $fields .= ", ";
                                   $values .= ", ";
                                   $edc = mysqli_real_escape_string($connect, $_POST["edc"]); 
                                   $values .= "'$edc'";
                                   $fields .= "edc";
                              } #
                              if($_POST["ecc"] != '')
                              { 
                                   $fields .= ", ";
                                   $values .= ", ";
                                   $ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); 
                                   $values .= "'$ecc'";
                                   $fields .= "ecc";
                              } #
                              // $query = "  
                              //      INSERT INTO notes(d, t, de, ts, te, deb, api, cvn, cin, drn, edc, ecc)  
                              //      VALUES('$d', '$t', '$de', '$ts', '$te', '$deb', '$api', '$cvn', '$cin', '$drn', '$edc', '$ecc');  
                              //      ";  
                              $query = "INSERT INTO notes(".$fields.") VALUES(".$values.");";  
                              // console_log($query);
                              if(($vitalsF != "") && ($vitalsV != ""))
                              {
                                   $vitalsF .= ", ";
                                   $vitalsV .= ", ";
                                   $pmsa = mysqli_real_escape_string($connect, $_POST["de"]); 
                                   $vitalsV .= "'$de'";
                                   $vitalsF .= 'd';
                                   $vitalsF .= ", ";
                                   $vitalsV .= ", ";
                                   $pmsa = mysqli_real_escape_string($connect, $_POST["api"]); 
                                   $vitalsV .= "'$api'";
                                   $vitalsF .= 'api';
                                   $vitalsQ = "INSERT INTO vitals(".$vitalsF.") VALUES(".$vitalsV.");"; 
                                   $vitalsT = "Y"; 
                                   // console_log($vitalsQ);
                                   console_log($vitalsT);
                                   
                              }
                              
                              $messte = 'Data Inserted';

                         }           

                    break;
                    default:
                         if($_POST["id"] != '')  
                         {  
                              $query = "  
                              UPDATE notes   
                              SET d='$d',   
                              t='$t',   
                              de='$de',   
                              ts = '$ts',   
                              te = '$te',
                              deb = '$deb',
                              cvn = '$cvn',
                              cin = '$cin',
                              drn = '$drn',
                              edc = '$edc',
                              ecc = '$ecc'   
                              WHERE api='$api'
                              AND id='$id'";  
                              $messte = 'Data Updated';  
                         }  
                         else  
                         {     
                              $query = "  
                                   INSERT INTO notes(d, t, de, ts, te, deb, api, cvn, cin, drn, edc, ecc)  
                                   VALUES('$d', '$t', '$de', '$ts', '$te', '$deb', '$api', '$cvn', '$cin', '$drn', '$edc', '$ecc');  
                                   ";  
                              $messte = 'Data Inserted';  
                         }           
                    break;
               } 
               $output = '';  
               $messte = '';  
               
               mysqli_query($connect, $query);
               if($vitalsT == "Y") { mysqli_query($connect, $vitalsQ); }
               /* if())  
               {  
                   $width1 = "width=1%";
                   $width2 = "width=2%";
                   $width3 = "width=3%";
                   $width4 = "width=4%";
                   $width7 = "width=7%";
                   $width10 = "width=22%";
                   $width14 = "width=24%";
                   $output .= '<tbody id="ddr_table">';
                   $ddr = "notes";
                   
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
                                  $edc = ($datarow['edc'] != '') ? "$" . $datarow['edc'] : " - ";
                                  $ecc = ($datarow['ecc'] != '') ? "$" . $datarow['ecc'] : " - ";
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
                                                 <td class="engineering" ' . $width4 . '><small>' . $edc . '</td ></small>
                                                 <td class="engineering" ' . $width4 . '><small>' . $ecc . '</td ></small>
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
                                  $edc = ($datarow['edc'] != '') ? "$" . $datarow['edc'] : " - ";
                                  $ad = ($datarow['ad'] != '') ? $datarow['ad'] : " - ";
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
                                                 <td class="accounting" ' . $width4 . '><small>' . $edc . '</td ></small>
                                                 <td class="accounting" ' . $width4 . '><small>Approval Initials:' . $ai . ' <hr>Approval Date:' . $ad . '</td ></small>
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
                                  $edc = ($datarow['edc'] != '') ? $datarow['edc'] : " - ";
                                  $ecc = ($datarow['ecc'] != '') ? $datarow['ecc'] : " - ";
                                  $deb = ($datarow['deb'] != '') ? $datarow['deb'] : " - ";
                                  $sd = ($datarow['sd'] != '') ? $datarow['sd'] : " - ";
                                  $drn = ($datarow['drn'] != '') ? $datarow['drn'] : " - ";
                                  if($datarow['tt'] != '' || $datarow['tt'] != '' || $datarow['tt'] != '' || $datarow['tt'] != '' || $datarow['tt'] != '' || $datarow['tt'] != '')
                                  {
                                       $drn .= '<br>';
                                  }
                                  
                                  $drn .= ($datarow['dt'] != '') ? "Deducted Time:  " . $datarow['dt'] . "hours <br>" : "" ;
                                  $drn .= ($datarow['dc'] != '') ? "Deducted Cost:  $" . $datarow['dc'] . "<br>" : "" ;
                                  $drn .= ($datarow['at'] != '') ? "Adjusted Time:  " . $datarow['at'] . "hours <br>" : "" ;
                                  $drn .= ($datarow['ac'] != '') ? "Adjusted Cost:  $" . $datarow['ac'] . "<br>" : "" ;
                                  $drn .= ($datarow['et'] != '') ? "Estimated Time:  " . $datarow['et'] . "hours <br>" : "" ;
                                  $drn .= ($datarow['tt'] != '') ? "    Total Time:  " . $datarow['tt'] . "hours" : "" ;
         
                                  $time_dash = ($ts == "-" || $te == "-") ? "" : " - ";
                                  $output .= '
                                            <tr>
                                                 <td class="vendor" ' . $width2 . '><small>Vendor</small></td>
                                                 <td class="vendor" ' . $width2 . '><small>' . $de . '</td ></small>
                                                 <td class="vendor" ' . $width4 . '><small>' . $ts . ' - ' . $te . '</td ></small>
                                                 <td class="vendor" ' . $width4 . '><small>' . $cvn . '</a></td ></small>
                                                 <td class="vendor" ' . $width4 . '><small>' . $cin . '</td ></small>
                                                 <td class="vendor" ' . $width10 . '><small>' . $drn . '</small> </td >                                       
                                                 <td class="vendor" ' . $width4 . '><small>' . $edc . '</td ></small>
                                                 <td class="vendor" ' . $width4 . '><small>' . $ecc . '</td ></small>
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
                                  $edc = ($datarow['edc'] != '') ? "$" . $datarow['edc'] : " - ";
                                  $ecc = ($datarow['ecc'] != '') ? "$" . $datarow['ecc'] : " - ";
                                  $output .= '
                                            <tr>
                                                 <td class="field" ' . $width2 . '><small>Field</small></td>
                                                 <td class="field" ' . $width2 . '><small>' . $de . '</small></td >
                                                 <td class="field" ' . $width4 . '><small>' . $ts . ' - ' . $te . '</small></td >
                                                 <td class="field" ' . $width4 . '><small>' . $cvn . '</small></td >
                                                 <td class="field" ' . $width4 . '><small>' . $cin . '</small></td >
                                                 <td class="field" ' . $width10 . '><small>' . $drn . '</small></td >
                                                 <td class="field" ' . $width4 . '><small>' . $edc . '</small></td >
                                                 <td class="field" ' . $width4 . '><small>' . $ecc . '</small></td >
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
               echo $output;    */
      }
      
 }  
 ?>
  