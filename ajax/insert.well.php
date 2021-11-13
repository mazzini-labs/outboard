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
    $eo = $_POST["entity-operator"];
    $eoc = $_POST["entity-operator-code"];
    $s = $_POST["state"];
    $cp = $_POST["county_parish"];
    $wl = $_POST["well-lease"];
    $wn = $_POST["well-no"];
    $ecn = $_POST["entity-common-name"];
    $et = $_POST["entity-type"];
    $r = $_POST["reservoir"];
    $pt = $_POST["production-type"];
    $ps = $_POST["producing-status"];
    $dt = $_POST["drill-type"];
    $sd = $_POST["spud-date"];
    $cd = mysqli_real_escape_string($connect, $_POST["completion-date"]);
    $fpd = mysqli_real_escape_string($connect, $_POST["first-prod-date"]);
    $lpd = mysqli_real_escape_string($connect, $_POST["last-prod-date"]);
    $up = mysqli_real_escape_string($connect, $_POST["upper-perforation"]);
    $lp = $_POST["lower-perforation"];
    $gg = $_POST["gas-gravity"];
    $og = $_POST["oil-gravity"];
    $wc = $_POST["well-count"];
    $maw = $_POST["max-active-wells"];
    $mp = $_POST["months-produced"];
    $ggr = $_POST["gas-gatherer"];
    $ogr = $_POST["oil-gatherer"];
    $md = $_POST["measured-depth-td"];
    $tvd = $_POST["true-vertical-depth"];
    $lat = $_POST["surface-latitude-wgs84"];
    $long = $_POST["surface-longitude-wgs84"];
    $p = $_POST["pumper"];
    $rf = $_POST["report-frequency"];
    $l = $_POST["landowner"];
    $gc = $_POST["gatecombo"];
    $li = $_POST["landowner_notes"];
    $show = $_POST["show-data"];
    $b = $_POST["block"];
    $f = $_POST["efield"];

    $api = $_POST["api"];  

    ($fpd == null)? $fpd = "2000-01-01": $fpd;
    ($sd == null)? $sd = "2000-01-01": $sd;
    ($lpd == null)? $lpd = "2000-01-01": $lpd;
    ($cd == null)? $cd = "2000-01-01": $cd;

    // if(isset($_POST["entity-operator"])){ $eo = mysqli_real_escape_string($connect, $_POST["entity-operator"]);    }      # Department. Enums are e = Engineering, a = Accounting, v = Vendor, f = Field, s = DSR
    // if(isset($_POST["entity-operator-code"])){ $t = mysqli_real_escape_string($connect, $_POST["t"]);    }      # Type. Enums are d = DDR, s = DSR, & n = Not Engineering.
    // if(isset($_POST["state"])){ $de = mysqli_real_escape_string($connect, $_POST["de"]);  }     # Date of Entry
    // if(isset($_POST["county_parish"])){ $deb = mysqli_real_escape_string($connect, $_POST["deb"]); }   # Data Entered By
    // if(isset($_POST["well-lease"])){ $ts = mysqli_real_escape_string($connect, $_POST["ts"]);  }     # Time (Start)
    // if(isset($_POST["well-no"])){ $te = mysqli_real_escape_string($connect, $_POST["te"]);  }     # Time (End)
    // if(isset($_POST["entity-common-name"])){ $api = mysqli_real_escape_string($connect, $_POST["api"]); }   # API number. Used to identify which well the entry belongs to. 
    // if(isset($_POST["entity-type"])){ $cvn = mysqli_real_escape_string($connect, $_POST["cvn"]); }   # Contact name (for e or f) or vendor name (for a or v)
    // if(isset($_POST["reservoir"])){ $cin = mysqli_real_escape_string($connect, $_POST["cin"]); }   # Contact info (for e or f), invoice number (for a), or vendor service (for v)
    // if(isset($_POST["production-type"])){ $drn = mysqli_real_escape_string($connect, $_POST["drn"]); }   # Daily report (for e or f), invoice details (for a), or vendor notes (for v). 
    //                                                                                         #    Note that vendor notes may include subtotal hours, deducted time/cost/reason, adjusted hours/time, & estimated travel time.
    // if(isset($_POST["producing-status"]) !== ''){$edc = mysqli_real_escape_string($connect, $_POST["edc"]); } else {$edc = null;}   # Daily cost (for e or f), invoice amount (for a), or $/hr (for v).
    // if(isset($_POST["drill-type"])){$ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); }    # Cumulative cost (for e or f) or total cost (for v).
    // if(isset($_POST["spud-date"])){$ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); }
    // if(isset($_POST["completion-date"])){$ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); }
    // if(isset($_POST["first-prod-date"])){$ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); }
    // if(isset($_POST["last-prod-date"])){$ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); }
    // if(isset($_POST["upper-perforation"])){$ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); }
    // if(isset($_POST["lower-perforation"])){$ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); }
    // if(isset($_POST["gas-gravity"])){$ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); }
    // if(isset($_POST["oil-gravity"])){$ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); }
    // if(isset($_POST["well-count"])){$ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); }
    // if(isset($_POST["max-active-wells"])){$ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); }
    // if(isset($_POST["months-produced"])){$ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); }
    // if(isset($_POST["gas-gatherer"])){$ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); }
    // if(isset($_POST["oil-gatherer"])){$ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); }
    // if(isset($_POST["measured-depth-td"])){$ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); }
    // if(isset($_POST["true-vertical-depth"])){$ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); }
    // if(isset($_POST["surface-latitude-wgs84"])){$ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); }
    // if(isset($_POST["surface-longitude-wgs84"])){$ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); }
    // if(isset($_POST["pumper"])){$ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); }
    // if(isset($_POST["report-frequency"])){$ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); }
    // if(isset($_POST["landowner"])){$ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); }
    // if(isset($_POST["gatecombo"])){$ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); }
    // if(isset($_POST["landowner_info"])){$ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); }
    // if(isset($_POST["show-data"])){$ecc = mysqli_real_escape_string($connect, $_POST["ecc"]); }

    // $cvn = $_POST["cvn"];
    // $cin = $_POST["cin"];
    // $drn = $_POST["drn"];
    
    // // Decimal values that do not like blank values being null:
    // isset($_POST["edc"]) ? $_POST["edc"] !== '' ? $edc = $_POST["edc"] : $edc = null : $edc = null;  
    // isset($_POST["ecc"]) ? $_POST["ecc"] !== '' ? $ecc = $_POST["ecc"] : $ecc = null : $ecc = null;  
    // // isset($_POST["edc"]) !== '' ? $edc = $_POST["edc"] : $edc = null;
    // // isset($_POST["ecc"]) !== '' ? $ecc = $_POST["ecc"] : $ecc = null;
    // isset($_POST["tt"]) ? $_POST["tt"] !== '' ? $tt = $_POST["tt"] : $tt = null : $tt = null;
    // isset($_POST["dt"]) ? $_POST["dt"] !== '' ? $dt = $_POST["dt"] : $dt = null : $dt = null;
    // isset($_POST["dc"]) ? $_POST["dc"] !== '' ? $dc = $_POST["dc"] : $dc = null : $dc = null;
    // isset($_POST["at"]) ? $_POST["at"] !== '' ? $at = $_POST["at"] : $at = null : $at = null;
    // isset($_POST["ac"]) ? $_POST["ac"] !== '' ? $ac = $_POST["ac"] : $ac = null : $ac = null;
    // isset($_POST["et"]) ? $_POST["et"] !== '' ? $et = $_POST["et"] : $et = null : $et = null;
    // isset($_POST["ai"]) ? $_POST["ai"] !== '' ? $ai = $_POST["ai"] : $ai = null : $ai = null;
    // isset($_POST["ad"]) ? $_POST["ad"] !== '' ? $ad = $_POST["ad"] : $ad = null : $ad = null;
    

    // // Values for the 'Vitals' table
    // isset($_POST["fl"]) ? $_POST["fl"] !== '' ? $fl = $_POST["fl"] : $fl = null : $fl = null;
    // isset($_POST["ct"]) ? $_POST["ct"] !== '' ? $ct = $_POST["ct"] : $ct = null : $ct = null;
    // isset($_POST["ftp"]) ? $_POST["ftp"] !== '' ? $ftp = $_POST["ftp"] : $ftp = null : $ftp = null;
    // isset($_POST["fcp"]) ? $_POST["fcp"] !== '' ? $fcp = $_POST["fcp"] : $fcp = null : $fcp = null;
    // isset($_POST["csi"]) ? $_POST["csi"] !== '' ? $csi = $_POST["csi"] : $csi = null : $csi = null;
    // isset($_POST["rpj"]) ? $_POST["rpj"] !== '' ? $rpj = $_POST["rpj"] : $rpj = null : $rpj = null;
    // isset($_POST["pmp"]) ? $_POST["pmp"] !== '' ? $pmp = $_POST["pmp"] : $pmp = null : $pmp = null;
    // isset($_POST["pms"]) ? $_POST["pms"] !== '' ? $pms = $_POST["pms"] : $pms = null : $pms = null;
    // isset($_POST["pus"]) ? $_POST["pus"] !== '' ? $pus = $_POST["pus"] : $pus = null : $pus = null;
    // isset($_POST["rsi"]) ? $_POST["rsi"] !== '' ? $rsi = $_POST["rsi"] : $rsi = null : $rsi = null;
    // isset($_POST["pusl"]) ? $_POST["pusl"] !== '' ? $pusl = $_POST["pusl"] : $pusl = null : $pusl = null;
    // isset($_POST["pmpa"]) ? $_POST["pmpa"] !== '' ? $pmpa = $_POST["pmpa"] : $pmpa = null : $pmpa = null;
    // isset($_POST["pmsa"]) ? $_POST["pmsa"] !== '' ? $pmsa = $_POST["pmsa"] : $pmsa = null : $pmsa = null;
    // isset($_POST["sitp"]) ? $_POST["sitp"] !== '' ? $sitp = $_POST["sitp"] : $sitp = null : $sitp = null;
    // isset($_POST["sicp"]) ? $_POST["sicp"] !== '' ? $sicp = $_POST["sicp"] : $sicp = null : $sicp = null;
    // isset($_POST["chlr"]) ? $_POST["chlr"] !== '' ? $chlr = $_POST["chlr"] : $chlr = null : $chlr = null;
    // isset($_POST["injp"]) ? $_POST["injp"] !== '' ? $injp = $_POST["injp"] : $injp = null : $injp = null;
    // isset($_POST["puon"]) ? $_POST["puon"] !== '00:00' ? $puon = $_POST["puon"] : $puon = null : $puon = null;
    // isset($_POST["puoff"]) ? $_POST["puoff"] !== '00:00' ? $puoff = $_POST["puoff"] : $puoff = null : $puoff = null;



    // if(isset($_POST["ec"])){$ec = mysqli_real_escape_string($connect,$_POST["ec"]);}
    // if(isset($_POST["eb"])){$eb = mysqli_real_escape_string($connect,$_POST["eb"]);}
    $id = mysqli_real_escape_string($connect, $_POST["id"]); 
    // if(isset($_POST["id"]) != '')
    $stmt = $connect->prepare("SELECT * from list WHERE api = ?");
    $stmt->bind_param('s', $api);
    $stmt->execute();
    $stmt->store_result();
    // mysqli_num_rows($connect);
    // printf("Number of rows: %d.\n", $stmt->num_rows);
    $check = $stmt->num_rows;
    // printf("Number of rows: %d.\n", $test);
    if($check > 0){
        /*
        if($api !== '')
        { 
            */
            //$id = mysqli_real_escape_string($connect, $_POST["id"]); 
            // $checklog = "SELECT sd FROM `list` WHERE api='$api' AND id='$id'";
            // // console_log("checklog sql:".$checklog);
            // $getSD = mysqli_query($connect, $checklog);
            // while ($row = mysqli_fetch_assoc($getSD)) 
            // {
            //         $sd = $row['sd'];
            //         console_log("row[sd] =" . $row['sd']);
            // }
            // $stmt = $connect->prepare("UPDATE list SET d=?, t=?, de=?, ts=?, te=?, deb=?, cvn=?, cin=?, drn=?, ai=?, ad=?, ec=?, edc=?, ecc=?, tt=?, dt=?, dc=?, at=?, ac=?, et=?, vb=? WHERE api = ? AND id = ?");
            // $stmt->bind_param('sssssssssssiddddddddisi', $d, $t, $de, $ts, $te, $deb, $cvn, $cin, $drn, $ai, $ad, $ec, $edc, $ecc, $tt, $dt, $dc, $at, $ac, $et, $vitals, $api, $id);
            printf("Updating...");
            printf("Date values: $fpd, $lpd, $sd, $cd");
            $stmt = $connect->prepare("UPDATE list SET 
            entity_operator=?,
            entity_operator_code=?,
            well_lease=?,
            well_no=?,
            entity_common_name=?,
            entity_type=?,
            county_parish=?,
            reservoir=?,
            production_type=?,
            producing_status=?,
            drill_type=?,
            first_prod_date=?,
            last_prod_date=?,
            upper_perforation=?,
            lower_perforation=?,
            gas_gravity=?,
            oil_gravity=?,
            completion_date=?,
            well_count=?,
            max_active_wells=?,
            months_produced=?,
            gas_gatherer=?,
            oil_gatherer=?,
            spud_date=?,
            measured_depth_td=?,
            true_vertical_depth=?,
            field=?,
            state=?,
            block=?,
            surface_latitude_wgs84=?,
            surface_longitude_wgs84=?,
            pumper=?,
            report_frequency=?,
            `show`=?,
            landowner=?,
            gatecombo=?,
            landowner_notes=? 
            WHERE api = ?");
            $stmt->bind_param('sssssssssssssiiddsiiisssiisssddssissss', 
            $eo, $eoc, $wl, $wn, $ecn, $et, $cp, $r, $pt, $ps, $dt, $fpd, $lpd, $up, $lp, $gg, $og, $cd, $wc, $maw, $mp, $ggr, $ogr, $sd, $md, $tvd, $f, $s, $b, $lat, $long, $p, $rf, $show, $l, $gc, $li, $api);
            $stmt->execute();
            // console_log("its using the well update statement");
            // console_log("Affected rows (UPDATE): %d\n", $connect->affected_rows);
            printf("Affected rows (UPDATE): %d\n", mysqli_affected_rows($connect));
            /*
        }
        else 
        {
            $stmt = $connect->prepare("INSERT INTO list (d, t, de, ts, te, deb, api, cvn, cin, drn, ai, ad, edc, ecc, tt, dt, dc, at, ac, et, vb) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('ssssssssssssddddddddi', $d, $t, $de, $ts, $te, $deb, $api, $cvn, $cin, $drn, $ai, $ad, $edc, $ecc, $tt, $dt, $dc, $at, $ac, $et, $vitals);
            
            // printf($stmt);
            
            $stmt->execute();
            printf("%d Row inserted.\n", $stmt->affected_rows);
            
            console_log("its using the insert statement");
        }
        */
    } else {
        /*
        if($api !== '')
        { 
            //$id = mysqli_real_escape_string($connect, $_POST["id"]); 
            // $checklog = "SELECT sd FROM `list` WHERE api='$api' AND id='$id'";
            // // console_log("checklog sql:".$checklog);
            // $getSD = mysqli_query($connect, $checklog);
            // while ($row = mysqli_fetch_assoc($getSD)) 
            // {
            //         $sd = $row['sd'];
            //         console_log("row[sd] =" . $row['sd']);
            // }
            // $stmt = $connect->prepare("UPDATE list SET d=?, t=?, de=?, ts=?, te=?, deb=?, cvn=?, cin=?, drn=?, ai=?, ad=?, ec=?, edc=?, ecc=?, tt=?, dt=?, dc=?, at=?, ac=?, et=?, vb=? WHERE api = ? AND id = ?");
            // $stmt->bind_param('sssssssssssiddddddddisi', $d, $t, $de, $ts, $te, $deb, $cvn, $cin, $drn, $ai, $ad, $ec, $edc, $ecc, $tt, $dt, $dc, $at, $ac, $et, $vitals, $api, $id);
            console_log("Affected rows (UPDATE): %d\n");
            $stmt = $connect->prepare("UPDATE list SET 
            entity_operator=?,
            entity_operator_code=?,
            well_lease=?,
            well_no=?,
            entity_common_name=?,
            entity_type=?,
            county_parish=?,
            reservoir=?,
            production_type=?,
            producing_status=?,
            drill_type=?,
            upper_perforation=?,
            lower_perforation=?,
            gas_gravity=?,
            oil_gravity=?,
            well_count=?,
            max_active_wells=?,
            months_produced=?,
            gas_gatherer=?,
            oil_gatherer=?,
            measured_depth_td=?,
            true_vertical_depth=?,
            field=?,
            state=?,
            block=?,
            surface_latitude_wgs84=?,
            surface_longitude_wgs84=?,
            pumper=?,
            report_frequency=?,
            `show`=?,
            landowner=?,
            gatecombo=?,
            landowner_notes=? 
            WHERE api = ?");
            $stmt->bind_param('sssssssssssiiddiiissiisssddssissss', 
            $eo, $eoc, $wl, $wn, $ecn, $et, $cp, $r, $pt, $ps, $dt, $up, $lp, $gg, $og, $wc, $maw, $mp, $ggr, $ogr, $md, $tvd, $f, $s, $b, $lat, $long, $p, $rf, $show, $l, $gc, $li, $api);
            $stmt->execute();
            // console_log("its using the well update statement");
            // console_log("Affected rows (UPDATE): %d\n", $connect->affected_rows);
            printf("Affected rows (UPDATE): %d\n", mysqli_affected_rows($connect));
        }
        else 
        {
            */
            printf("Inserting...");
            printf("Date values: $fpd, $lpd, $sd, $cd");
            $stmt = $connect->prepare("INSERT INTO list ( 
            entity_operator,
            entity_operator_code,
            well_lease,
            well_no,
            entity_common_name,
            entity_type,
            county_parish,
            reservoir,
            production_type,
            producing_status,
            drill_type,
            first_prod_date,
            last_prod_date,
            upper_perforation,
            lower_perforation,
            gas_gravity,
            oil_gravity,
            completion_date,
            well_count,
            max_active_wells,
            months_produced,
            gas_gatherer,
            oil_gatherer,
            spud_date,
            measured_depth_td,
            true_vertical_depth,
            field,
            state,
            block,
            surface_latitude_wgs84,
            surface_longitude_wgs84,
            pumper,
            report_frequency,
            `show`,
            landowner,
            gatecombo,
            landowner_notes, 
            api) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('sssssssssssssiiddsiiisssiisssddssissss', 
            $eo, $eoc, $wl, $wn, $ecn, $et, $cp, $r, $pt, $ps, $dt, $fpd, $lpd, $up, $lp, $gg, $og, $cd, $wc, $maw, $mp, $ggr, $ogr, $sd, $md, $tvd, $f, $s, $b, $lat, $long, $p, $rf, $show, $l, $gc, $li, $api);
            // $stmt = $connect->prepare("INSERT INTO list (d, t, de, ts, te, deb, api, cvn, cin, drn, ai, ad, edc, ecc, tt, dt, dc, at, ac, et, vb) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            // $stmt->bind_param('ssssssssssssddddddddi', $d, $t, $de, $ts, $te, $deb, $api, $cvn, $cin, $drn, $ai, $ad, $edc, $ecc, $tt, $dt, $dc, $at, $ac, $et, $vitals);
            
            // printf($stmt);
            
            $stmt->execute();
            printf("%d Row inserted.\n", $stmt->affected_rows);
            
            console_log("its using the insert statement");
            /*
        }
        */
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
