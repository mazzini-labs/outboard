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
    if(isset($_POST["edc"]) !== ''){$edc = mysqli_real_escape_string($connect, $_POST["edc"]); } else {$edc = null;}   # Daily cost (for e or f), invoice amount (for a), or $/hr (for v).
    if(isset($_POST["ecc"])){$ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); }    # Cumulative cost (for e or f) or total cost (for v).
    
    $d = $_POST["d"];
    $t = $_POST["t"];
    $de = $_POST["de"];
    $deb = $_POST["deb"];
    $ts = $_POST["ts"];
    $te = $_POST["te"];
    $api = $_POST["api"];
    $cvn = $_POST["cvn"];
    $cin = $_POST["cin"];
    $drn = $_POST["drn"];
    
    // Decimal values that do not like blank values being null:
    isset($_POST["edc"]) ? $_POST["edc"] !== '' ? $edc = $_POST["edc"] : $edc = null : $edc = null;  
    isset($_POST["ecc"]) ? $_POST["ecc"] !== '' ? $ecc = $_POST["ecc"] : $ecc = null : $ecc = null;  
    // isset($_POST["edc"]) !== '' ? $edc = $_POST["edc"] : $edc = null;
    // isset($_POST["ecc"]) !== '' ? $ecc = $_POST["ecc"] : $ecc = null;
    isset($_POST["tt"]) ? $_POST["tt"] !== '' ? $tt = $_POST["tt"] : $tt = null : $tt = null;
    isset($_POST["dt"]) ? $_POST["dt"] !== '' ? $dt = $_POST["dt"] : $dt = null : $dt = null;
    isset($_POST["dc"]) ? $_POST["dc"] !== '' ? $dc = $_POST["dc"] : $dc = null : $dc = null;
    isset($_POST["at"]) ? $_POST["at"] !== '' ? $at = $_POST["at"] : $at = null : $at = null;
    isset($_POST["ac"]) ? $_POST["ac"] !== '' ? $ac = $_POST["ac"] : $ac = null : $ac = null;
    isset($_POST["et"]) ? $_POST["et"] !== '' ? $et = $_POST["et"] : $et = null : $et = null;
    isset($_POST["ai"]) ? $_POST["ai"] !== '' ? $ai = $_POST["ai"] : $ai = null : $ai = null;
    isset($_POST["ad"]) ? $_POST["ad"] !== '' ? $ad = $_POST["ad"] : $ad = null : $ad = null;
    

    // Values for the 'Vitals' table
    isset($_POST["fl"]) ? $_POST["fl"] !== '' ? $fl = $_POST["fl"] : $fl = null : $fl = null;
    isset($_POST["ct"]) ? $_POST["ct"] !== '' ? $ct = $_POST["ct"] : $ct = null : $ct = null;
    isset($_POST["ftp"]) ? $_POST["ftp"] !== '' ? $ftp = $_POST["ftp"] : $ftp = null : $ftp = null;
    isset($_POST["fcp"]) ? $_POST["fcp"] !== '' ? $fcp = $_POST["fcp"] : $fcp = null : $fcp = null;
    isset($_POST["csi"]) ? $_POST["csi"] !== '' ? $csi = $_POST["csi"] : $csi = null : $csi = null;
    isset($_POST["rpj"]) ? $_POST["rpj"] !== '' ? $rpj = $_POST["rpj"] : $rpj = null : $rpj = null;
    isset($_POST["pmp"]) ? $_POST["pmp"] !== '' ? $pmp = $_POST["pmp"] : $pmp = null : $pmp = null;
    isset($_POST["pms"]) ? $_POST["pms"] !== '' ? $pms = $_POST["pms"] : $pms = null : $pms = null;
    isset($_POST["pus"]) ? $_POST["pus"] !== '' ? $pus = $_POST["pus"] : $pus = null : $pus = null;
    isset($_POST["rsi"]) ? $_POST["rsi"] !== '' ? $rsi = $_POST["rsi"] : $rsi = null : $rsi = null;
    isset($_POST["pusl"]) ? $_POST["pusl"] !== '' ? $pusl = $_POST["pusl"] : $pusl = null : $pusl = null;
    isset($_POST["pmpa"]) ? $_POST["pmpa"] !== '' ? $pmpa = $_POST["pmpa"] : $pmpa = null : $pmpa = null;
    isset($_POST["pmsa"]) ? $_POST["pmsa"] !== '' ? $pmsa = $_POST["pmsa"] : $pmsa = null : $pmsa = null;
    isset($_POST["sitp"]) ? $_POST["sitp"] !== '' ? $sitp = $_POST["sitp"] : $sitp = null : $sitp = null;
    isset($_POST["sicp"]) ? $_POST["sicp"] !== '' ? $sicp = $_POST["sicp"] : $sicp = null : $sicp = null;
    isset($_POST["chlr"]) ? $_POST["chlr"] !== '' ? $chlr = $_POST["chlr"] : $chlr = null : $chlr = null;

    if($fl !== '' || $ct !== '' || $ftp !== '' || $fcp !== '' || $csi!== '' || $rpj!== '' || 
    $pmp!== '' || $pms!== '' || $pus!== '' || $rsi!== '' || $pusl!== '' || $pmpa!== '' || 
    $pmsa!== '' || $sitp!== '' || $sicp!== '' || $chlr!== '')
    {
        $vitals = 1;
    }
    else 
    {
        $vitals = 0;
    }


    if(isset($_POST["ec"])){$ec = mysqli_real_escape_string($connect,$_POST["ec"]);}
    if(isset($_POST["eb"])){$eb = mysqli_real_escape_string($connect,$_POST["eb"]);}
    $id = mysqli_real_escape_string($connect, $_POST["id"]); 
    // if(isset($_POST["id"]) != '')
    if($id !== '')
    { 
        $id = mysqli_real_escape_string($connect, $_POST["id"]); 
        $checklog = "SELECT sd FROM `notes` WHERE api='$api' AND id='$id'";
        // console_log("checklog sql:".$checklog);
        $getSD = mysqli_query($connect, $checklog);
        while ($row = mysqli_fetch_assoc($getSD)) 
        {
                $sd = $row['sd'];
                console_log("row[sd] =" . $row['sd']);
        }
        $stmt = $connect->prepare("UPDATE notes SET d=?, t=?, de=?, ts=?, te=?, deb=?, cvn=?, cin=?, drn=?, ec=?, edc=?, ecc=? WHERE api = ? AND id = ?");
        $stmt->bind_param('sssssssssiddsi', $d, $t, $de, $ts, $te, $deb, $cvn, $cin, $drn, $ec, $edc, $ecc, $api, $id);

        $logstmt = $connect->prepare("INSERT INTO notes_log (notes_id, d, t, de, ts, te, deb, sd, api, cvn, cin, drn, eb, ec, edc, ecc) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $logstmt->bind_param('issssssssssssidd', $id, $d, $t, $de, $ts, $te, $deb, $sd, $api, $cvn, $cin, $drn, $eb, $ec, $edc, $ecc);

        $stmt->execute();
        $logstmt->execute();
        
        if(($vitalsF != "") && ($vitalsV != ""))
        {
            $vitalstmt = $connect->prepare("INSERT INTO vitals (ftp, fcp, sitp, sicp, chlr, pmp, fl, pms, ct, pus, rsi, pusl, csi, rpj, pmpa, pmsa, puon, puoff, api, d) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"); 
            $vitalstmt->bind_param('iiiiisissisissiissss', $ftp, $fcp, $sitp, $sicp, $chlr, $pmp, $fl, $pms, $ct, $pus, $rsi, $pusl, $csi, $rpj, $pmpa, $pmsa, $puon, $puoff, $api, $de);
            
            $vitalstmt->execute();
        }
        console_log("its using the update statement");
    }
    else 
    {
        $stmt = $connect->prepare("INSERT INTO notes (d, t, de, ts, te, deb, api, cvn, cin, drn, ai, ad, edc, ecc, tt, dt, dc, at, ac, et) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssssssssssdddddddd', $d, $t, $de, $ts, $te, $deb, $api, $cvn, $cin, $drn, $ai, $ad, $edc, $ecc, $tt, $dt, $dc, $at, $ac, $et);
        
        // printf($stmt);
        
        $stmt->execute();
        printf("%d Row inserted.\n", $stmt->affected_rows);
        $last_id = mysqli_insert_id($connect);
        $logstmt = $connect->prepare("INSERT INTO notes_log (notes_id, d, t, de, ts, te, deb, sd, api, cvn, cin, drn, eb, ec, edc, ecc, tt, dt, dc, at, ac, et, ai, ad) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $logstmt->bind_param('issssssssssssiddddddddss', $last_id, $d, $t, $de, $ts, $te, $deb, $sd, $api, $cvn, $cin, $drn, $eb, $ec, $edc, $ecc, $tt, $dt, $dc, $at, $ac, $et, $ai, $ad);

        $logstmt->execute();

        // if(($vitalsF != "") && ($vitalsV != ""))
        if($vitals > 0)
        {
            $vitalstmt = $connect->prepare("INSERT INTO vitals (ftp, fcp, sitp, sicp, chlr, pmp, fl, pms, ct, pus, rsi, pusl, csi, rpj, pmpa, pmsa, puon, puoff, api, d) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"); 
            $vitalstmt->bind_param('iiiiisissisissiissss', $ftp, $fcp, $sitp, $sicp, $chlr, $pmp, $fl, $pms, $ct, $pus, $rsi, $pusl, $csi, $rpj, $pmpa, $pmsa, $puon, $puoff, $api, $de);
            
            $vitalstmt->execute();
        }
        console_log("its using the correct statement");
    }
    

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
                    $ec++;
                    $fields = "notes_id, d, t, de, deb, sd, api, drn, edc, ecc, eb, ec";
                    $values = "'$id', '$d', '$t', '$de', '$deb', '$sd', '$api', '$drn', '$edc', '$ecc', '$eb', '$ec'";
                    $log_q = "INSERT INTO notes_log(".$fields.") VALUES(".$values.");";  
               }  
               else  
               {     
                    $query = "  
                        INSERT INTO notes(d, t, de, deb, api, drn, edc, ecc)  
                        VALUES('$d', '$t', '$de', '$deb', '$api', '$drn', '$edc', '$ecc');  
                        ";

                    $fields = "notes_id, d, t, de, deb, sd, api, drn, edc, ecc, eb, ec";
                    $values = "'$id', '$d', '$t', '$de', '$deb', '$sd', '$api', '$drn', '$edc', '$ecc', '$eb', '$ec'";
                    $log_q = "INSERT INTO notes_log(".$fields.") VALUES(".$values.");";  
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
                        // $logfield = "notes_id, ";
                        // $logvalue = "'$id', ";
                        $fields = 'd, t, de, ts, te, deb, api, cvn, cin, drn';
                        $values = "'$d', '$t', '$de', '$ts', '$te', '$deb', '$api', '$cvn', '$cin', '$drn'";
                        $extrasCount = 0;
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
                        if($_POST["dt"] != '')
                        { 
                            $fields .= ", ";
                            $values .= ", ";
                            $dt = mysqli_real_escape_string($connect, $_POST["dt"]); 
                            $values .= "'$dt'";
                            $fields .= 'dt';
                        } #
                        if($_POST["dc"] != '')
                        { 
                            $fields .= ", ";
                            $values .= ", ";
                            $dc = mysqli_real_escape_string($connect, $_POST["dc"]); 
                            $values .= "'$dc'";
                            $fields .= 'dc';
                        } #
                        if($_POST["at"] != '')
                        { 
                            $fields .= ", ";
                            $values .= ", ";
                            $at = mysqli_real_escape_string($connect, $_POST["at"]); 
                            $values .= "'$at'";
                            $fields .= 'at';
                        } #
                        if($_POST["ac"] != '')
                        { 
                            $fields .= ", ";
                            $values .= ", ";
                            $ac = mysqli_real_escape_string($connect, $_POST["ac"]); 
                            $values .= "'$ac'";
                            $fields .= 'ac';
                        } #
                        if($_POST["et"] != '')
                        { 
                            $fields .= ", ";
                            $values .= ", ";
                            $et = mysqli_real_escape_string($connect, $_POST["et"]); 
                            $values .= "'$et'";
                            $fields .= 'et';
                        } #
                        if($_POST["tt"] != '')
                        { 
                            $fields .= ", ";
                            $values .= ", ";
                            $tt = mysqli_real_escape_string($connect, $_POST["tt"]); 
                            $values .= "'$tt'";
                            $fields .= 'tt';
                        } # 
                        

                         // 
                         // $edc = ($edc != '') ? $edc : 
                        if($_POST["id"] != '')  
                        {  
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
                            // ecc = '$ecc',
                            // tt = '$tt',
                            // dt = '$dt',
                            // dc = '$dc',
                            // at = '$at',
                            // ac = '$ac',
                            // et = '$et'   
                            // WHERE api='$api'
                            // AND id='$id'";  
                            // $messte = 'Data Updated'; 
                            // $fields = 'd, t, de, ts, te, deb, api, cvn, cin, drn';
                            $ec++;
                            $fields = "notes_id, d, t, de, ts, te, deb, sd, api, cvn, cin, drn, eb, ec";
                            $values = "'$id', '$d', '$t', '$de', '$ts', '$te', '$deb', '$sd', '$api', '$cvn', '$cin', '$drn', '$eb', '$ec'";

                            // $update .= "notes_id = '$id', ";
                            // $update .= "sd = ''"
                            // $update .= "ec = '$eb', ";
                            // $update .= "ec = '$ec'";


                            $update = "d='$d', ";
                            $update .= "t='$t', ";
                            $update .= "de='$de', ";
                            $update .= "ts = '$ts', ";
                            $update .= "te = '$te', ";
                            $update .= "deb = '$deb', ";
                            $update .= "cvn = '$cvn', ";
                            $update .= "cin = '$cin', ";
                            $update .= "drn = '$drn', ";
                            $update .= "ec = '$ec'";
                            if($_POST["edc"] != '')
                            { 
                                $fields .= ", ";
                                $values .= ", ";
                                $update .= ", ";
                                $edc = mysqli_real_escape_string($connect, $_POST["edc"]); 
                                $update .= "edc = '$edc'";
                                $values .= "'$edc'";
                                $fields .= "edc";
                            } #
                            if($_POST["ecc"] != '')
                            { 
                                $fields .= ", ";
                                $values .= ", ";
                                $update .= ", ";
                                $ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); 
                                $update .= "ecc = '$ecc'";
                                $values .= "'$ecc'";
                                $fields .= "ecc";
                            }
                            if($_POST["dt"] != '')
                            { 
                                $fields .= ", ";
                                $values .= ", ";
                                $update .= ", ";
                                $dt = mysqli_real_escape_string($connect, $_POST["dt"]); 
                                
                                $update .= "dt = '$dt'";
                                $values .= "'$dt'";
                                $fields .= 'dt';
                            } #
                            if($_POST["dc"] != '')
                            { 
                                $fields .= ", ";
                                $values .= ", ";
                                $update .= ", ";
                                $dc = mysqli_real_escape_string($connect, $_POST["dc"]); 
                                $update .= "dc = '$dc'";
                                $values .= "'$dc'";
                                $fields .= 'dc';
                            } #
                            if($_POST["at"] != '')
                            { 
                                $fields .= ", ";
                                $values .= ", ";
                                $update .= ", ";
                                $at = mysqli_real_escape_string($connect, $_POST["at"]); 
                                $update .= "at = '$at'";
                                $values .= "'$at'";
                                $fields .= 'at';
                            } #
                            if($_POST["ac"] != '')
                            { 
                                $fields .= ", ";
                                $values .= ", ";
                                $update .= ", ";
                                $ac = mysqli_real_escape_string($connect, $_POST["ac"]); 
                                $update .= "ac = '$ac'";
                                $values .= "'$ac'";
                                $fields .= 'ac';
                            } #
                            if($_POST["et"] != '')
                            { 
                                $fields .= ", ";
                                $values .= ", ";
                                $update .= ", ";
                                $et = mysqli_real_escape_string($connect, $_POST["et"]); 
                                $update .= "et = '$et'";
                                $values .= "'$et'";
                                $fields .= 'et';
                            } #
                            if($_POST["tt"] != '')
                            { 
                                $fields .= ", ";
                                $values .= ", ";
                                $update .= ", ";
                                $tt = mysqli_real_escape_string($connect, $_POST["tt"]); 
                                $update .= "tt = '$tt'";
                                $values .= "'$tt'";
                                $fields .= 'tt';
                            } # 
                            $query = "UPDATE notes SET " . $update . " WHERE api='$api' AND id='$id'"; 
                            $log_q = "INSERT INTO notes_log(".$fields.") VALUES(".$values.");";  
                            mysqli_query($connect, $query);
                            mysqli_query($connect, $log_q);
                        }  
                        else  
                        {    
                            
                            
                            // $query = "  
                            //      INSERT INTO notes(d, t, de, ts, te, deb, api, cvn, cin, drn, edc, ecc)  
                            //      VALUES('$d', '$t', '$de', '$ts', '$te', '$deb', '$api', '$cvn', '$cin', '$drn', '$edc', '$ecc');  
                            //      ";  
                            $query = "INSERT INTO notes(".$fields.") VALUES(".$values.");";  
                            mysqli_query($connect, $query);
                            
                            
                            
                            $last_id = mysqli_insert_id($connect);
                            $logfield = "notes_id, ";
                            $logvalue = "'$last_id', ";
                            $log_q = "INSERT INTO notes_log(".$logfield.$fields.") VALUES(".$logvalue.$values.");";  
                            mysqli_query($connect, $log_q);
                            // $log_q = "INSERT INTO notes_log(".$logfield.$fields.") VALUES(".$logvalue.$values.");";  
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
                                $ec++;
                                $fields = "notes_id, d, t, de, ts, te, deb, sd, api, cvn, cin, drn, edc, ai, ad, eb, ec";
                                $values = "'$id', '$d', '$t', '$de', '$ts', '$te', '$deb', '$sd', '$api', '$cvn', '$cin', '$drn', '$edc', '$ai', '$ad', '$eb', '$ec'";
    
                                $update = "d='$d', ";
                                $update .= "t='$t', ";
                                $update .= "de='$de', ";
                                $update .= "ts = '$ts', ";
                                $update .= "te = '$te', ";
                                $update .= "deb = '$deb', ";
                                $update .= "cvn = '$cvn', ";
                                $update .= "cin = '$cin', ";
                                $update .= "drn = '$drn', ";
                                $update .= "edc = '$edc', ";
                                $update .= "ai = '$ai', ";  
                                $update .= "ad = '$ad', ";
                                $update .= "ec = '$ec'";
                                $query = "UPDATE notes SET " . $update . " WHERE api='$api' AND id='$id'"; 
                                $log_q = "INSERT INTO notes_log(".$fields.") VALUES(".$values.");";  
                                mysqli_query($connect, $query);
                                mysqli_query($connect, $log_q);
                                //    $query = "  
                                //    UPDATE notes   
                                //    SET 
                                //    t='$t',   
                                //    de='$de',   
                                //    ts = '$ts',   
                                //    te = '$te',
                                //    deb = '$deb',
                                //    cvn = '$cvn',
                                //    cin = '$cin',
                                //    drn = '$drn',
                                //    edc = '$edc',
                                //    ai = '$ai',  
                                //    ad =  '$ad'
                                //    WHERE api='$api'
                                //    AND id='$id'";  
                                //    $messte = 'Data Updated';  
                            }
                            else
                            {
                                $fields = "d, t, de, ts, te, deb, api, cvn, cin, drn, edc, ai, ad";
                                $values = "'$d', '$t', '$de', '$ts', '$te', '$deb', '$api', '$cvn', '$cin', '$drn', '$edc', '$ai', '$ad'";
                                $query = "INSERT INTO notes(".$fields.") VALUES(".$values.");";  
                                mysqli_query($connect, $query);
                            
                            
                            
                                $last_id = mysqli_insert_id($connect);
                                $logfield = "notes_id, ";
                                $logvalue = "'$last_id', ";
                                $log_q = "INSERT INTO notes_log(".$logfield.$fields.") VALUES(".$logvalue.$values.");";  
                                mysqli_query($connect, $log_q);

                                // $log_q = "INSERT INTO notes_log(".$logfield.$fields.") VALUES(".$logvalue.$values.");";  
                                $messte = 'Data Inserted';  
                            }
                        }  
                        else  
                        {     
                            if($_POST["id"] != '')
                            {
                                $ec++;
                                $fields = "notes_id, d, t, de, ts, te, deb, sd, api, cvn, cin, drn, eb, ec";
                                $values = "'$id', '$d', '$t', '$de', '$ts', '$te', '$deb', '$sd', '$api', '$cvn', '$cin', '$drn', '$eb', '$ec'";
    
                                $update = "d='$d', ";
                                $update .= "t='$t', ";
                                $update .= "de='$de', ";
                                $update .= "ts = '$ts', ";
                                $update .= "te = '$te', ";
                                $update .= "deb = '$deb', ";
                                $update .= "cvn = '$cvn', ";
                                $update .= "cin = '$cin', ";
                                $update .= "drn = '$drn', ";
                                if($_POST["edc"] != '')
                                { 
                                    $fields .= ", ";
                                    $values .= ", ";
                                    
                                    $edc = mysqli_real_escape_string($connect, $_POST["edc"]); 
                                    $update .= "edc = '$edc', ";
                                    $values .= "'$edc'";
                                    $fields .= "edc";
                                } #
                                $update .= "ec = '$ec'";
                                $query = "UPDATE notes SET " . $update . " WHERE api='$api' AND id='$id'"; 
                                $log_q = "INSERT INTO notes_log(".$fields.") VALUES(".$values.");";  
                                //    $query = "  
                                //    UPDATE notes   
                                //    SET d='$d',   
                                //    t='$t',   
                                //    de='$de',   
                                //    ts = '$ts',   
                                //    te = '$te',
                                //    deb = '$deb',
                                //    cvn = '$cvn',
                                //    cin = '$cin',
                                //    drn = '$drn',
                                //    edc = '$edc'
                                //    WHERE api='$api'
                                //    AND id='$id'";  
                                mysqli_query($connect, $query);
                                mysqli_query($connect, $log_q);
                                $messte = 'Data Updated';  
                            }
                            else
                            {
                                $fields = "d, t, de, ts, te, deb, api, cvn, cin, drn";
                                $values = "'$d', '$t', '$de', '$ts', '$te', '$deb', '$api', '$cvn', '$cin', '$drn'";

                                if($_POST["edc"] != '')
                                { 
                                    $fields .= ", ";
                                    $values .= ", ";
                                    $update .= ", ";
                                    $edc = mysqli_real_escape_string($connect, $_POST["edc"]); 
                                    $update .= "edc = '$edc'";
                                    $values .= "'$edc'";
                                    $fields .= "edc";
                                } #
                                $query = "INSERT INTO notes(".$fields.") VALUES(".$values.");";  
                                mysqli_query($connect, $query);
                            
                            
                            
                                $last_id = mysqli_insert_id($connect);
                                $logfield = "notes_id, ";
                                $logvalue = "'$last_id', ";
                                $log_q = "INSERT INTO notes_log(".$logfield.$fields.") VALUES(".$logvalue.$values.");";  
                                mysqli_query($connect, $log_q);
                                // $log_q = "INSERT INTO notes_log(".$logfield.$fields.") VALUES(".$logvalue.$values.");";  
                                $messte = 'Data Inserted';  
                            }
                        }           
                    break;
                    case 'e':
                        
                         // console_log($fields);
                        $vitalsF = "";
                        $vitalsV = "";
                        // $vitalsT = "";
                        if($_POST["ftp"] != '')
                        { 
                            
                            // $ftp = mysqli_real_escape_string($connect, $_POST["ftp"]); 
                            $vitalsV .= "'$ftp'";
                            $vitalsF .= "ftp";
                        } #
                        // if($_POST["fcp"] != '')
                        // { 
                        //     if(($vitalsF != "") && ($vitalsV != ""))
                        //     {
                        //         $vitalsF .= ", ";
                        //         $vitalsV .= ", ";
                        //     }
                        //     $fcp = mysqli_real_escape_string($connect, $_POST["fcp"]); 
                        //     $vitalsV .= "'$fcp'";
                        //     $vitalsF .= "fcp";
                        // }
                        // if($_POST["sitp"] != '')
                        // { 
                        //     if(($vitalsF != "") && ($vitalsV != ""))
                        //     {
                        //         $vitalsF .= ", ";
                        //         $vitalsV .= ", ";
                        //     }
                        //     $sitp = mysqli_real_escape_string($connect, $_POST["sitp"]); 
                        //     $vitalsV .= "'$sitp'";
                        //     $vitalsF .= "sitp";
                        // } #
                        // if($_POST["sicp"] != '')
                        // { 
                        //     if(($vitalsF != "") && ($vitalsV != ""))
                        //     {
                        //         $vitalsF .= ", ";
                        //         $vitalsV .= ", ";
                        //     }
                        //     $sicp = mysqli_real_escape_string($connect, $_POST["sicp"]); 
                        //     $vitalsV .= "'$sicp'";
                        //     $vitalsF .= 'sicp';
                        // } #
                        // if($_POST["chlr"] != '')
                        // { 
                        //     if(($vitalsF != "") && ($vitalsV != ""))
                        //     {
                        //         $vitalsF .= ", ";
                        //         $vitalsV .= ", ";
                        //     }
                        //     $chlr = mysqli_real_escape_string($connect, $_POST["chlr"]); 
                        //     $vitalsV .= "'$chlr'";
                        //     $vitalsF .= 'chlr';
                        // } #
                        // if($_POST["pmp"] != '')
                        // { 
                        //     if(($vitalsF != "") && ($vitalsV != ""))
                        //     {
                        //         $vitalsF .= ", ";
                        //         $vitalsV .= ", ";
                        //     }
                        //     $pmp = mysqli_real_escape_string($connect, $_POST["pmp"]); 
                        //     $vitalsV .= "'$pmp'";
                        //     $vitalsF .= 'pmp';
                        // } #
                        // if($_POST["fl"] != "")
                        // { 
                        //     if(($vitalsF != "") && ($vitalsV != ""))
                        //     {
                        //         $vitalsF .= ", ";
                        //         $vitalsV .= ", ";
                        //     }
                        //     $fl = mysqli_real_escape_string($connect, $_POST["fl"]); 
                        //     $vitalsV .= "'$fl'";
                        //     $vitalsF .= 'fl';
                        // } # 
                        // if($_POST["pms"] != '')
                        // { 
                        //     if(($vitalsF != "") && ($vitalsV != ""))
                        //     {
                        //         $vitalsF .= ", ";
                        //         $vitalsV .= ", ";
                        //     }
                        //     $pms = mysqli_real_escape_string($connect, $_POST["pms"]); 
                        //     $vitalsV .= "'$pms'";
                        //     $vitalsF .= "pms";
                        // } #
                        // if($_POST["ct"] != '')
                        // { 
                        //     if(($vitalsF != "") && ($vitalsV != ""))
                        //     {
                        //         $vitalsF .= ", ";
                        //         $vitalsV .= ", ";
                        //     }
                        //     $ct = mysqli_real_escape_string($connect, $_POST["ct"]); 
                        //     $vitalsV .= "'$ct'";
                        //     $vitalsF .= "ct";
                        // } #
                        // if($_POST["pus"] != '')
                        // { 
                        //     if(($vitalsF != "") && ($vitalsV != ""))
                        //     {
                        //         $vitalsF .= ", ";
                        //         $vitalsV .= ", ";
                        //     }
                        //     $pus = mysqli_real_escape_string($connect, $_POST["pus"]); 
                        //     $vitalsV .= "'$pus'";
                        //     $vitalsF .= 'pus';
                        // } #
                        // if($_POST["rsi"] != '')
                        // { 
                        //     if(($vitalsF != "") && ($vitalsV != ""))
                        //     {
                        //         $vitalsF .= ", ";
                        //         $vitalsV .= ", ";
                        //     }
                        //     $rsi = mysqli_real_escape_string($connect, $_POST["rsi"]); 
                        //     $vitalsV .= "'$rsi'";
                        //     $vitalsF .= 'rsi';
                        // } #
                        // if($_POST["pusl"] != '')
                        // { 
                        //     if(($vitalsF != "") && ($vitalsV != ""))
                        //     {
                        //         $vitalsF .= ", ";
                        //         $vitalsV .= ", ";
                        //     }
                        //     $pusl = mysqli_real_escape_string($connect, $_POST["pusl"]); 
                        //     $vitalsV .= "'$pusl'";
                        //     $vitalsF .= 'pusl';
                        // } #
                        // if($_POST["csi"] != '')
                        // { 
                        //     if(($vitalsF != "") && ($vitalsV != ""))
                        //     {
                        //         $vitalsF .= ", ";
                        //         $vitalsV .= ", ";
                        //     }
                        //     $csi = mysqli_real_escape_string($connect, $_POST["csi"]); 
                        //     $vitalsV .= "'$csi'";
                        //     $vitalsF .= 'csi';
                        // } #       
                        // if($_POST["rpj"] != '')
                        // { 
                        //     if(($vitalsF != "") && ($vitalsV != ""))
                        //     {
                        //         $vitalsF .= ", ";
                        //         $vitalsV .= ", ";
                        //     }
                        //     $rpj = mysqli_real_escape_string($connect, $_POST["rpj"]); 
                        //     $vitalsV .= "'$rpj'";
                        //     $vitalsF .= "rpj";
                        // } #
                        // if($_POST["pmpa"] != '')
                        // { 
                        //     if(($vitalsF != "") && ($vitalsV != ""))
                        //     {
                        //         $vitalsF .= ", ";
                        //         $vitalsV .= ", ";
                        //     }
                        //     $pmpa = mysqli_real_escape_string($connect, $_POST["pmpa"]); 
                        //     $vitalsV .= "'$pmpa'";
                        //     $vitalsF .= "pmpa";
                        // } #
                        // if($_POST["pmsa"] != '')
                        // { 
                        //     if(($vitalsF != "") && ($vitalsV != ""))
                        //     {
                        //         $vitalsF .= ", ";
                        //         $vitalsV .= ", ";
                        //     }
                        //     $pmsa = mysqli_real_escape_string($connect, $_POST["pmsa"]); 
                        //     $vitalsV .= "'$pmsa'";
                        //     $vitalsF .= 'pmsa';
                        // } #
                        // if($_POST["puon"] != '')
                        // { 
                        //     if(($vitalsF != "") && ($vitalsV != ""))
                        //     {
                        //         $vitalsF .= ", ";
                        //         $vitalsV .= ", ";
                        //     }
                        //     $puon = mysqli_real_escape_string($connect, $_POST["puon"]); 
                        //     $vitalsV .= "'$puon'";
                        //     $vitalsF .= 'puon';
                        // } #
                        // if($_POST["puoff"] != '')
                        // { 
                        //     if(($vitalsF != "") && ($vitalsV != ""))
                        //     {
                        //         $vitalsF .= ", ";
                        //         $vitalsV .= ", ";
                        //     }
                        //     $puoff = mysqli_real_escape_string($connect, $_POST["puoff"]); 
                        //     $vitalsV .= "'$puoff'";
                        //     $vitalsF .= 'puoff';
                        // } #
                        console_log($vitalsV);
                        console_log($vitalsF);
                        if($_POST["id"] != '')  
                        {  
                            
                            
                            $ec++;
                            $fields = "notes_id, d, t, de, ts, te, deb, sd, api, cvn, cin, drn, eb, ec";
                            $values = "'$id', '$d', '$t', '$de', '$ts', '$te', '$deb', '$sd', '$api', '$cvn', '$cin', '$drn', '$eb', '$ec'";
                            // $update .= "notes_id = '$id', ";
                            // $update .= "sd = ''"
                            // $update .= "ec = '$eb', ";
                            // $update .= "ec = '$ec'";
                            // $edc = mysqli_real_escape_string($connect, $_POST["edc"]); 
                            
                            $update = "d='$d', ";
                            $update .= "t='$t', ";
                            $update .= "de='$de', ";
                            $update .= "ts = '$ts', ";
                            $update .= "te = '$te', ";
                            $update .= "deb = '$deb', ";
                            $update .= "cvn = '$cvn', ";
                            $update .= "cin = '$cin', ";
                            $update .= "drn = '$drn', ";
                            $update .= "ec = '$ec'";

                            // if($_POST["edc"] != '')
                            // { 
                            //     $fields .= ", ";
                            //     $values .= ", ";
                            //     $update .= ", ";
                            //     $edc = mysqli_real_escape_string($connect, $_POST["edc"]); 
                            //     $update .= "edc = '$edc'";
                            //     $values .= "'$edc'";
                            //     $fields .= "edc";
                            // } #
                            // if($_POST["ecc"] != '')
                            // { 
                            //     $fields .= ", ";
                            //     $values .= ", ";
                            //     $update .= ", ";
                            //     $ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); 
                            //     $update .= "ecc = '$ecc'";
                            //     $values .= "'$ecc'";
                            //     $fields .= "ecc";
                            // }
                            $query = "UPDATE notes SET " . $update . " WHERE api='$api' AND id='$id'"; 
                            $log_q = "INSERT INTO notes_log(".$fields.") VALUES(".$values.");";
                            
                            // console_log($query);
                            // console_log($log_q);

                            // PREPARED STATEMENTS CODE
                            // ----This 'works' but it caused weird formatting issues again with the drn/notes field so I won't mess with this for now
                            // -----
                            // $edc = $_POST["edc"];
                            // $drn = $_POST["drn"];
                            $stmt = $connect->prepare("UPDATE notes SET d=?, t=?, de=?, ts=?, te=?, deb=?, cvn=?, cin=?, drn=?, ec=?, edc=?, ecc=? WHERE api = ? AND id = ?");
                            $stmt->bind_param('sssssssssiddsi', $d, $t, $de, $ts, $te, $deb, $cvn, $cin, $drn, $ec, $edc, $ecc, $api, $id);

                            $logstmt = $connect->prepare("INSERT INTO notes_log (notes_id, d, t, de, ts, te, deb, sd, api, cvn, cin, drn, eb, ec, edc, ecc) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                            $logstmt->bind_param('issssssssssssidd', $id, $d, $t, $de, $ts, $te, $deb, $sd, $api, $cvn, $cin, $drn, $eb, $ec, $edc, $ecc);

                            $stmt->execute();
                            $logstmt->execute();
                            // -----
                            // mysqli_query($connect, $query);
                            // mysqli_query($connect, $log_q);
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
                                $vitalstmt = $connect->prepare("INSERT INTO vitals (ftp, fcp, sitp, sicp, chlr, pmp, fl, pms, ct, pus, rsi, pusl, csi, rpj, pmpa, pmsa, puon, puoff, api, d) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"); 
                                $vitalstmt->bind_param('iiiiisissisissiissss', $ftp, $fcp, $sitp, $sicp, $chlr, $pmp, $fl, $pms, $ct, $pus, $rsi, $pusl, $csi, $rpj, $pmpa, $pmsa, $puon, $puoff, $api, $de);
                                
                                $vitalstmt->execute();
                                // $vitalsT = "Y"; 
                                // console_log($vitalsQ);
                                // console_log($vitalsT);
                                // mysqli_query($connect, $vitalsQ);

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
                            
                            // $fields = "d, t, de, ts, te, deb, api, cvn, cin, drn";
                            // $values = "'$d', '$t', '$de', '$ts', '$te', '$deb', '$api', '$cvn', '$cin', '$drn'";
                            // if($_POST["edc"] != '')
                            // { 
                            //     $fields .= ", ";
                            //     $values .= ", ";
                            //     $edc = mysqli_real_escape_string($connect, $_POST["edc"]); 
                            //     $values .= "'$edc'";
                            //     $fields .= "edc";
                            // } #
                            // if($_POST["ecc"] != '')
                            // { 
                            //     $fields .= ", ";
                            //     $values .= ", ";
                            //     $ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); 
                            //     $values .= "'$ecc'";
                            //     $fields .= "ecc";
                            // } #
                              // $query = "  
                              //      INSERT INTO notes(d, t, de, ts, te, deb, api, cvn, cin, drn, edc, ecc)  
                              //      VALUES('$d', '$t', '$de', '$ts', '$te', '$deb', '$api', '$cvn', '$cin', '$drn', '$edc', '$ecc');  
                              //      ";  
                            
                            $stmt = $connect->prepare("INSERT INTO notes (d, t, de, ts, te, deb, api, cvn, cin, drn, edc, ecc) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                            $stmt->bind_param('ssssssssssdd', $d, $t, $de, $ts, $te, $deb, $api, $cvn, $cin, $drn, $edc, $ecc);

                            
                            $stmt->execute();

                            $last_id = mysqli_insert_id($connect);
                            $logstmt = $connect->prepare("INSERT INTO notes_log (notes_id, d, t, de, ts, te, deb, sd, api, cvn, cin, drn, eb, ec, edc, ecc) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                            $logstmt->bind_param('issssssssssssidd', $last_id, $d, $t, $de, $ts, $te, $deb, $sd, $api, $cvn, $cin, $drn, $eb, $ec, $edc, $ecc);

                            $logstmt->execute();

                            // $query = "INSERT INTO notes(".$fields.") VALUES(".$values.");";  
                            // mysqli_query($connect, $query);
                            
                            
                            
                            // $last_id = mysqli_insert_id($connect);
                            // $logfield = "notes_id, ";
                            // $logvalue = "'$last_id', ";
                            // $log_q = "INSERT INTO notes_log(".$logfield.$fields.") VALUES(".$logvalue.$values.");";  
                            // mysqli_query($connect, $log_q);
                            
                            // console_log($query);
                            if(($vitalsF != "") && ($vitalsV != ""))
                            {
                                // $vitalsF .= ", ";
                                // $vitalsV .= ", ";
                                // $pmsa = mysqli_real_escape_string($connect, $_POST["de"]); 
                                // $vitalsV .= "'$de'";
                                // $vitalsF .= 'd';
                                // $vitalsF .= ", ";
                                // $vitalsV .= ", ";
                                // $pmsa = mysqli_real_escape_string($connect, $_POST["api"]); 
                                // $vitalsV .= "'$api'";
                                // $vitalsF .= 'api';
                                // $vitalsQ = "INSERT INTO vitals(".$vitalsF.") VALUES(".$vitalsV.");"; 
                                $vitalstmt = $connect->prepare("INSERT INTO vitals (ftp, fcp, sitp, sicp, chlr, pmp, fl, pms, ct, pus, rsi, pusl, csi, rpj, pmpa, pmsa, puon, puoff, api, d) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"); 
                                $vitalstmt->bind_param('iiiiisissisissiissss', $ftp, $fcp, $sitp, $sicp, $chlr, $pmp, $fl, $pms, $ct, $pus, $rsi, $pusl, $csi, $rpj, $pmpa, $pmsa, $puon, $puoff, $api, $de);
                                
                                $vitalstmt->execute();
                                // $vitalsT = "Y"; 
                                // console_log($vitalsQ);
                                // console_log($vitalsT);
                                // mysqli_query($connect, $vitalsQ);
                            }
                            
                            $messte = 'Data Inserted';

                        }           

                    break;
                    default:
                        if($_POST["id"] != '')  
                        {
                            $ec++;
                            $fields = "notes_id, d, t, de, ts, te, deb, sd, api, cvn, cin, drn, eb, ec";
                            $values = "'$id', '$d', '$t', '$de', '$ts', '$te', '$deb', '$sd', '$api', '$cvn', '$cin', '$drn', '$eb', '$ec'";

                            // $update .= "notes_id = '$id', ";
                            // $update .= "sd = ''"
                            // $update .= "ec = '$eb', ";
                            // $update .= "ec = '$ec'";


                            $update = "d='$d', ";
                            $update .= "t='$t', ";
                            $update .= "de='$de', ";
                            $update .= "ts = '$ts', ";
                            $update .= "te = '$te', ";
                            $update .= "deb = '$deb', ";
                            $update .= "cvn = '$cvn', ";
                            $update .= "cin = '$cin', ";
                            $update .= "drn = '$drn', ";
                            $update .= "ec = '$ec'";
                            if($_POST["edc"] != '')
                            { 
                                $fields .= ", ";
                                $values .= ", ";
                                $update .= ", ";
                                $edc = mysqli_real_escape_string($connect, $_POST["edc"]); 
                                $update .= "edc = '$edc'";
                                $values .= "'$edc'";
                                $fields .= "edc";
                            } #
                            if($_POST["ecc"] != '')
                            { 
                                $fields .= ", ";
                                $values .= ", ";
                                $update .= ", ";
                                $ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); 
                                $update .= "ecc = '$ecc'";
                                $values .= "'$ecc'";
                                $fields .= "ecc";
                            }
                            $query = "UPDATE notes SET " . $update . " WHERE api='$api' AND id='$id'"; 
                            $log_q = "INSERT INTO notes_log(".$fields.") VALUES(".$values.");";    
                            mysqli_query($connect, $query);
                            mysqli_query($connect, $log_q);
                            //   $query = "  
                            //   UPDATE notes   
                            //   SET d='$d',   
                            //   t='$t',   
                            //   de='$de',   
                            //   ts = '$ts',   
                            //   te = '$te',
                            //   deb = '$deb',
                            //   cvn = '$cvn',
                            //   cin = '$cin',
                            //   drn = '$drn',
                            //   edc = '$edc',
                            //   ecc = '$ecc'   
                            //   WHERE api='$api'
                            //   AND id='$id'";  
                            $messte = 'Data Updated';  
                        }  
                        else  
                        {
                            // $logfield = "notes_id, ";
                            // $logvalue = "'$id', ";
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
                            mysqli_query($connect, $query);
                            
                            
                            
                            $last_id = mysqli_insert_id($connect);
                            $logfield = "notes_id, ";
                            $logvalue = "'$last_id', ";
                            $log_q = "INSERT INTO notes_log(".$logfield.$fields.") VALUES(".$logvalue.$values.");";  
                            mysqli_query($connect, $log_q);
                            // $log_q = "INSERT INTO notes_log(".$logfield.$fields.") VALUES(".$logvalue.$values.");";       
                            $messte = 'Data Inserted';  
                        }           
                    break;
            } 
            $output = '';  
            $messte = '';  
            
            // mysqli_query($connect, $query);
            // mysqli_query($connect, $log_q);
            // if($vitalsT == "Y") { mysqli_query($connect, $vitalsQ); }
    }
}  
?>
