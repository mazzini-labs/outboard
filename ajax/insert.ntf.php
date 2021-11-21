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
    isset($_POST["injp"]) ? $_POST["injp"] !== '' ? $injp = $_POST["injp"] : $injp = null : $injp = null;
    isset($_POST["puon"]) ? $_POST["puon"] !== '00:00' ? $puon = $_POST["puon"] : $puon = null : $puon = null;
    isset($_POST["puoff"]) ? $_POST["puoff"] !== '00:00' ? $puoff = $_POST["puoff"] : $puoff = null : $puoff = null;

    isset($_POST["notes-addition"]) ? $_POST["notes-addition"] !== '' ? $na = $_POST["notes-addition"] : $na = null : $na = null;
    if($na == 'append'){
        $queryNotes = "SELECT notes FROM `list` WHERE api='$api'";
        // console_log("checklog sql:".$checklog);
        $getNotes = mysqli_query($connect, $queryNotes);
        while ($row = mysqli_fetch_assoc($getNotes))
        {
            $origNotes = $row['notes'];
        } 
        $newNotes = $origNotes . "<br>" . $drn;
        $notes_stmt = $connect->prepare("UPDATE list SET notes=? WHERE api = ?");
        $notes_stmt->bind_param('ss', $newNotes, $api);
        $notes_stmt->execute(); 
    }
    elseif($na == 'replace'){
        $notes_stmt = $connect->prepare("UPDATE list SET notes=? WHERE api = ?");
        $notes_stmt->bind_param('ss', $drn, $api);
        $notes_stmt->execute(); 
    }
    $vitals = 0;
    if($fl !== null || $ct !== null || $ftp !== null || $fcp !== null || $csi !== null || $rpj !== null || 
    $pmp !== null || $pms !== null || $pus !== null || $rsi !== null || $pusl !== null || $pmpa !== null || 
    $pmsa !== null || $sitp !== null || $sicp !== null || $chlr !== null || $injp !== null || $puon !== null || 
    $puoff !== null)
    {
        console_log("vitals were entered.");
        $vitals = 1;
        console_log($vitals);
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
        $stmt = $connect->prepare("UPDATE notes SET d=?, t=?, de=?, ts=?, te=?, deb=?, cvn=?, cin=?, drn=?, ai=?, ad=?, ec=?, edc=?, ecc=?, tt=?, dt=?, dc=?, at=?, ac=?, et=?, vb=? WHERE api = ? AND id = ?");
        $stmt->bind_param('sssssssssssiddddddddisi', $d, $t, $de, $ts, $te, $deb, $cvn, $cin, $drn, $ai, $ad, $ec, $edc, $ecc, $tt, $dt, $dc, $at, $ac, $et, $vitals, $api, $id);

        $logstmt = $connect->prepare("INSERT INTO notes_log (notes_id, d, t, de, ts, te, deb, sd, api, cvn, cin, drn, eb, ec, edc, ecc, tt, dt, dc, at, ac, et, ai, ad, vb) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $logstmt->bind_param('issssssssssssiddddddddssi', $id, $d, $t, $de, $ts, $te, $deb, $sd, $api, $cvn, $cin, $drn, $eb, $ec, $edc, $ecc, $tt, $dt, $dc, $at, $ac, $et, $ai, $ad, $vitals);

        $stmt->execute();
        $logstmt->execute();
        
        if($vitals > 0)
        {
            $vitalstmt = $connect->prepare("INSERT INTO vitals (ftp, fcp, sitp, sicp, chlr, pmp, fl, pms, ct, pus, rsi, pusl, csi, rpj, pmpa, pmsa, puon, puoff, api, d, notes_id, injp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"); 
            $vitalstmt->bind_param('ddddisdssdsdssiissssid', $ftp, $fcp, $sitp, $sicp, $chlr, $pmp, $fl, $pms, $ct, $pus, $rsi, $pusl, $csi, $rpj, $pmpa, $pmsa, $puon, $puoff, $api, $de, $id, $injp);
            
            $vitalstmt->execute();
        }
        console_log("its using the update statement");
    }
    else 
    {
        $stmt = $connect->prepare("INSERT INTO notes (d, t, de, ts, te, deb, api, cvn, cin, drn, ai, ad, edc, ecc, tt, dt, dc, at, ac, et, vb) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssssssssssddddddddi', $d, $t, $de, $ts, $te, $deb, $api, $cvn, $cin, $drn, $ai, $ad, $edc, $ecc, $tt, $dt, $dc, $at, $ac, $et, $vitals);
        
        // printf($stmt);
        
        $stmt->execute();
        printf("%d Row inserted.\n", $stmt->affected_rows);
        $last_id = mysqli_insert_id($connect);
        $logstmt = $connect->prepare("INSERT INTO notes_log (notes_id, d, t, de, ts, te, deb, sd, api, cvn, cin, drn, eb, ec, edc, ecc, tt, dt, dc, at, ac, et, ai, ad, vb) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $logstmt->bind_param('issssssssssssiddddddddssi', $last_id, $d, $t, $de, $ts, $te, $deb, $sd, $api, $cvn, $cin, $drn, $eb, $ec, $edc, $ecc, $tt, $dt, $dc, $at, $ac, $et, $ai, $ad, $vitals);

        $logstmt->execute();

        // if(($vitalsF != "") && ($vitalsV != ""))
        if($vitals > 0)
        {
            $vitalstmt = $connect->prepare("INSERT INTO vitals (ftp, fcp, sitp, sicp, chlr, pmp, fl, pms, ct, pus, rsi, pusl, csi, rpj, pmpa, pmsa, puon, puoff, api, d, notes_id, injp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"); 
            $vitalstmt->bind_param('ddddisdssdsdssiissssid', $ftp, $fcp, $sitp, $sicp, $chlr, $pmp, $fl, $pms, $ct, $pus, $rsi, $pusl, $csi, $rpj, $pmpa, $pmsa, $puon, $puoff, $api, $de, $last_id, $injp);
            
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
    
    
}  
?>
