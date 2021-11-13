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
    // if(isset($_POST["del"])){ $del = mysqli_real_escape_string($connect, $_POST["d"]);    }      # Department. Enums are e = Engineering, a = Accounting, v = Vendor, f = Field, s = DSR
    // if(isset($_POST["deb"])){ $deb = mysqli_real_escape_string($connect, $_POST["t"]);    }      # Type. Enums are d = DDR, s = DSR, & n = Not Engineering.
    // if(isset($_POST["gp"])){ $de = mysqli_real_escape_string($connect, $_POST["de"]);  }     # Date of Entry
    // if(isset($_POST["op"])){ $deb = mysqli_real_escape_string($connect, $_POST["deb"]); }   # Data Entered By
    // if(isset($_POST["wp"])){ $ts = mysqli_real_escape_string($connect, $_POST["ts"]);  }     # Time (Start)
    // // if(isset($_POST["deel"])){ $te = mysqli_real_escape_string($connect, $_POST["te"]);  }     # Time (End)
    // if(isset($_POST["api"])){ $api = mysqli_real_escape_string($connect, $_POST["api"]); }   # API number. Used to identify which well the entry belongs to. 
    
    $del = $_POST["del"];
    $deb = $_POST["deb"];
    $gp = $_POST["gp"];
    $op = $_POST["op"];
    $wp = $_POST["wp"];
    $api = $_POST["api"];
    $sd = $_POST["sd"];
    
    // $cvn = $_POST["cvn"];
    // $cin = $_POST["cin"];
    // $drn = $_POST["drn"];
    
    
    $id = mysqli_real_escape_string($connect, $_POST["id"]); 
    // if(isset($_POST["id"]) != '')
    // if($id !== '')
    // { 
    //     $id = mysqli_real_escape_string($connect, $_POST["id"]); 
    //     $checklog = "SELECT sd FROM `notes` WHERE api='$api' AND id='$id'";
    //     // console_log("checklog sql:".$checklog);
    //     $getSD = mysqli_query($connect, $checklog);
    //     while ($row = mysqli_fetch_assoc($getSD)) 
    //     {
    //             $sd = $row['sd'];
    //             console_log("row[sd] =" . $row['sd']);
    //     }
    //     $stmt = $connect->prepare("UPDATE notes SET d=?, t=?, de=?, ts=?, te=?, deb=?, cvn=?, cin=?, drn=?, ai=?, ad=?, ec=?, edc=?, ecc=?, tt=?, dt=?, dc=?, at=?, ac=?, et=?, vb=? WHERE api = ? AND id = ?");
    //     $stmt->bind_param('sssssssssssiddddddddisi', $d, $t, $de, $ts, $te, $deb, $cvn, $cin, $drn, $ai, $ad, $ec, $edc, $ecc, $tt, $dt, $dc, $at, $ac, $et, $vitals, $api, $id);



    //     $logstmt = $connect->prepare("INSERT INTO notes_log (notes_id, d, t, de, ts, te, deb, sd, api, cvn, cin, drn, eb, ec, edc, ecc, tt, dt, dc, at, ac, et, ai, ad, vb) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    //     $logstmt->bind_param('issssssssssssiddddddddssi', $last_id, $d, $t, $de, $ts, $te, $deb, $sd, $api, $cvn, $cin, $drn, $eb, $ec, $edc, $ecc, $tt, $dt, $dc, $at, $ac, $et, $ai, $ad, $vitals);

    //     $stmt->execute();
    //     $logstmt->execute();
        
        
    // }
    // else 
    // {
        $stmt = $connect->prepare("INSERT INTO latest_prod_data (api, prod_date, gas_wh_mcf, oil_prod, water_prod, deb) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssddds', $api, $del, $gp, $op, $wp, $deb);
        
        // printf($stmt);
        
        $stmt->execute();
        printf("%d Row inserted.\n", $stmt->affected_rows);
        $last_id = mysqli_insert_id($connect);
        $query = "SELECT * FROM latest_prod_data WHERE prod_data_id = '".$last_id."'";  
        $result = mysqli_query($connect, $query);  
        $row = mysqli_fetch_array($result);  
        $sd = $row['sd'];
        $pattern = "/[ ]/";
        list($d, $t) = preg_split($pattern, $sd);
        print_r("Date: ".$d);
        print_r("Time: ".$t);
        $liststmt = $connect->prepare("UPDATE list SET lpd = ?, lpd_sd = ?, lpd_st = ? WHERE api = ?");
        $liststmt->bind_param('ssss', $del, $d, $t, $api);
        $liststmt->execute();
        // $last_id = mysqli_insert_id($connect);
        // $logstmt = $connect->prepare("INSERT INTO notes_log (notes_id, d, t, de, ts, te, deb, sd, api, cvn, cin, drn, eb, ec, edc, ecc, tt, dt, dc, at, ac, et, ai, ad, vb) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        // $logstmt->bind_param('issssssssssssiddddddddssi', $last_id, $d, $t, $de, $ts, $te, $deb, $sd, $api, $cvn, $cin, $drn, $eb, $ec, $edc, $ecc, $tt, $dt, $dc, $at, $ac, $et, $ai, $ad, $vitals);

        // $logstmt->execute();

        // if(($vitalsF != "") && ($vitalsV != ""))
        
    // }
    

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
