<?php
require_once PROJECT_ROOT_PATH . "api/model/WellsDatabase.php";
function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
class BoardModel extends WellsDatabase
{
    // wsb datatables endpoints 
    // lTable(latesttable) - ajax/wsb.ajax.lpd.php
    public function getLatestProduction()
    {
        $sql = "SELECT
        `latest_prod_data`.`api`, 
        date_format(`latest_prod_data`.`prod_date`,'%c-%e-%Y') as prod_mo,
        `latest_prod_data`.`gas_wh_mcf`, 
        `latest_prod_data`.`oil_prod`, 
        `latest_prod_data`.`water_prod`,
        `latest_prod_data`.`sd`,
        `list`.`api`, 
        `list`.`entity_common_name`, 
        `list`.`state`, 
        `list`.`county_parish`, 
        `list`.`block`, 
        `list`.`entity_operator_code`, 
        `list`.`producing_status`, 
        `list`.`production_type`, 
        `list`.`pumper`, 
        `list`.`report_frequency`, 
        `list`.`notes`, 
        `list`.`entity_type`,
        `list`.`notes_update`,
        date_format(`list`.`update_latest_prod_date`,'%c-%e-%Y') as update_latest_prod_date,
        `list`.`lpd`,
        concat(`list`.`lpd_sd`,' ',`list`.`lpd_st`) as lpdcheck
        FROM
            latest_prod_data,
            list
        WHERE
            DATE_FORMAT(`latest_prod_data`.`prod_date`, '%y-%m-%d') = DATE_FORMAT(`list`.`lpd`, '%y-%m-%d')
            AND `latest_prod_data`.`sd` = concat(`list`.`lpd_sd`,' ',`list`.`lpd_st`)
            AND `latest_prod_data`.`api` = `list`.`api`
            AND `list`.`show` = 1   
        ORDER BY
            `list`.`api` ASC";
        return $this->select($sql);
    }

    // oTable(productiontable) - ajax/wsb.ajax.php
    // iTable(productiontable1) - ajax/wsb.ajax.php
    // pTable(printtable) - ajax/wsb.ajax.php
    public function getWells()
    {
        $sql = "SELECT
        `prod_data`.`api`, 
        `prod_data`.`days_on`, 
        date_format(`prod_data`.`prod_mo`,'%c-%e-%Y') as prod_mo,
        `prod_data`.`gas_sold`, 
        `prod_data`.`gas_wh_mcf`, 
        `prod_data`.`oil_prod`, 
        `prod_data`.`water_prod`,
        `prod_data`.`gas_line_loss`,
        `list`.`api`, 
        `list`.`entity_common_name`, 
        `list`.`state`, 
        `list`.`county_parish`, 
        `list`.`block`, 
        `list`.`entity_operator_code`, 
        `list`.`producing_status`, 
        `list`.`production_type`, 
        `list`.`pumper`, 
        `list`.`notes`, 
        `list`.`entity_type`,
        `list`.`notes_update`,
        date_format(`list`.`last_prod_date`,'%c-%e-%Y') as last_prod_date,
        concat(`list`.`de`, ' ', `list`.`ts`) as de
        FROM
            prod_data,
            list
        WHERE
            DATE_FORMAT(`prod_data`.`prod_mo`, '%y-%m') = DATE_FORMAT(`list`.`last_prod_date`, '%y-%m')
            AND `prod_data`.`api` = `list`.`api`
            AND `list`.`show` = 1   
        ORDER BY
            `list`.`api` ASC";
        return $this->select($sql);
    }
    // sTable(shutintable) - ajax/si.ajax.php
    public function getShutInWells()
    {
        $sql = "SELECT
        `list`.*,
        date_format(`list`.`notes_update`,'%b %e, %Y <br> %l:%i %p') as notes_update
        FROM
        list
        WHERE
        `list`.`producing_status` = 'Shut-In'  
        OR `list`.`producing_status` = 'Shut-in'
        OR `list`.`producing_status` = 'INACTIVE'
        OR `list`.`producing_status` = 'SI'
        ORDER BY
        `list`.`api` ASC";
    }



    // prod_data datatables endpoints
    // oTable(productiontable) - ajax/prodajax.php
    public function getWellProduction($api)
    {
        // error_log("WSBModel: " . var_dump($this->select("SELECT * FROM `prod_data` WHERE `api` LIKE ?",["s",$api]),true));
        return $this->select("SELECT * FROM `prod_data` WHERE `api` LIKE ?",["s",$api]);
    }
    // iTable(ddrtable) - ajax/prodnotes.ajax.php
    public function getDDR($api)
    {
        $sql = "SELECT DISTINCT
        n.id,
        n.d,
        n.t,
        n.de,
        n.ts,
        n.te,
        n.deb,
        n.sd,
        n.api,
        n.cvn,
        n.cin,
        n.drn,
        n.edc,
        n.ecc,
        n.tt,
        n.dt,
        n.dc,
        n.at,
        n.ac,
        n.et,
        n.ai,
        n.ad,
        n.ec,
        n.vb,
        n.producing_status,
        date_format(`de`, '%m-%d-%Y') as dee,
        date_format(`ad`, '%m-%d-%Y') as ad,
        f.sd 
        FROM notes n
        LEFT JOIN notes_files f
        ON n.id = f.note_id 
        WHERE n.api like ? and n.t like '%d%' ORDER BY de DESC";
        return $this->select($sql,["s",$api]);
    }
    // sTable(dsrtable) - ajax/dsr.ajax.php
    public function getDSR($api)
    {
        $sql = "SELECT
        *,
        date_format(`de`, '%m-%d-%Y') as de
        FROM `notes` 
        WHERE `api` 
        LIKE %?% AND `t` like '%s%' ORDER BY de ASC";
        return $this->select($sql,["s",$api]);
    }
    // aDDRTable(ddr2015pres) - ajax/ddr.fetch.php
    public function getExcelDDR($api)
    {
        $this->select("SELECT * from `ddr_old` WHERE api LIKE ?",["s",$api]);
    }
    // vitalstable(vitalstable) - ajax/vitals.ajax.php
    public function getVitals($api)
    {
        $this->select("SELECT * from `vitals` WHERE api LIKE ? ORDER BY d DESC",["s",$api]);
    }
    // aDSRTable(dsr2015pres) - ajax/ddr.fetchold.php
    // bDDRTable(before2015detailrpt) - ajax/ddr.fetchold.php
    // bDSRTable(before2015sumrpt) - ajax/ddr.fetchold.php
    public function convertToWell($api)
    {
        return $this->select("SELECT well from `000api_list` WHERE `api` like %?%",["s",$api]);
    }
    public function getOldExcel($api,$sheet)
    {
        $well = $this->convertToWell($api);
        return $this->select("SELECT * from `$well` WHERE sheet LIKE ?",["ss",$well,$sheet]);
    } 
    // notesTable(notestable) - ajax/wellnotes.ajax.php
    // Nevermind, this isn't implemented currently
    public function getWellInfo($api)
    {
        $sql = "SELECT
        *,
        date_format(`notes_update`, '%m-%d-%Y') as ne
        FROM `prod_review_notes` WHERE `api` LIKE %?% ORDER BY ne DESC";
        return $this->select($sql,["s",$api]);
    }

    // rest of endpoints 
    // insert_latest_prod - ajax/insert.ntf.1.php
    public function insertLatestProduction($api,$del,$gp,$op,$wp,$deb)
    {
        $this->select("INSERT INTO latest_prod_data (api, prod_date, gas_wh_mcf, oil_prod, water_prod, deb) VALUES (?, ?, ?, ?, ?, ?)",['ssddds', $api, $del, $gp, $op, $wp, $deb]);
        $last_id = $this->insert_id;
        // $query = "SELECT * FROM latest_prod_data WHERE prod_data_id = '".$last_id."'"; 
        $this->select("SELECT * FROM latest_prod_data WHERE prod_data_id = ?", ["i", $last_id]);
        $row = $this->fetch_array;
        $sd = $row['sd'];
        $pattern = "/[ ]/";
        list($d, $t) = preg_split($pattern, $sd);
        print_r("Date: ".$d);
        print_r("Time: ".$t);
        return $this->select("UPDATE list SET lpd = ?, lpd_sd = ?, lpd_st = ? WHERE api = ?",['ssss', $del, $d, $t, $api]);
    }
    // insert_form.ddr - ajax/insert.t.php 
    /**
     * Insert a new note into the DDR database.
     * @param int $id Note ID
     * @param string $na Note Append; uses a function to determind if notes should be appended to WSB, replace current notes, or not be placed on WSB.
     * @param string $api API number. Used to identify which well the entry belongs to. 
     * @param string $d Department. Enums are e = Engineering, a = Accounting, v = Vendor, f = Field, s = DSR
     * @param string $t Type. Enums are d = DDR, s = DSR, & n = Not Engineering.
     * @param string $de Date of Entry
     * @param string $ts Time (Start)
     * @param string $te Time (End)
     * @param string $deb Data Entered By
     * @param string $cvn Contact name (for e or f) or vendor name (for a or v)
     * @param string $cin Contact info (for e or f), invoice number (for a), or vendor service (for v)
     * @param string $drn Daily report (for e or f), invoice details (for a), or vendor notes (for v). 
     * Note that vendor notes may include subtotal hours, deducted time/cost/reason, adjusted hours/time, & estimated travel time. 
     * @param mixed $ai Approval initials (for a).
     * @param mixed $edc Daily cost (for e or f), invoice amount (for a), or $/hr (for v).
     * @param mixed $ecc Cumulative cost (for e or f) or total cost (for v).
     * @param mixed $tt Total time (hours) (for v).
     * @param mixed $dt Deducted time (hours) (for v).
     * @param mixed $dc Deducted cost (for v)
     * @param mixed $at Adjusted time (hours) (for v).
     * @param mixed $ac Adjusted cost (for v).
     * @param mixed $et Estimated travel time (for v).
     * 
     * @param mixed $ad Approval date (for a only).
     * @param string $ps Producing status -- status of well when note was made.
     * @param string $ft File type -- ie. is it for a lease road, well, generic document, etc.
     * @param double $fl Fluid level.
     * @param mixed $ct Chemical treatment (enum in DB)
     * @param double $ftp Flowing tubing pressure.
     * @param double $fcp Flowing casing pressure.
     * @param string $csi Comments on SI.
     * @param string $rpj Reason for pulling job.
     * @param mixed $pmp Preventative maintenance primary (enum in DB).
     * @param mixed $pms Preventative maintenance secondary (enum in DB).
     * @param double $pus Pumping unit speed.
     * @param string $rsi Reason for/cause of SI (enum in DB).
     * @param double $pusl Pumping unit sl?
     * @param int $pmpa Preventative maintenance primary amount.
     * @param int $pmsa Preventative maintenance secondary amount.
     * @param double $sitp SI tubing pressure.
     * @param double $sicp SI casing pressure.
     * @param int $chlr Chlorides levels.
     * @param double $injp Injection pressure.
     * @param mixed $puon Pumping unit "On" time.
     * @param mixed $puoff Pumping unit "Off" time.
     * @param mixed $ec Edit count.
     * @param mixed $eb Edited by (person).
     * @param mixed $wsbcat Category for files uploaded to WSB.
     */
    public function insertDDR($id=null,$na=null,$api,$d, $t, $de, $ts, $te, $deb, $cvn=null, $cin=null, $drn=null, $ai=null, $ad=null, $ec=null, 
    $edc=null, $ecc=null, $tt=null, $dt=null, $dc=null, $at=null, $ac=null, $et=null, $ps=null, $ft=null, $eb=null, $ftp=null, $fcp=null, $sitp=null, $sicp=null, 
    $chlr=null, $pmp=null, $fl=null, $pms=null, $ct=null, $pus=null, $rsi=null, $pusl=null, $csi=null, $rpj=null, $pmpa=null, $pmsa=null, 
    $puon=null, $puoff=null, $injp=null, $wsbcat="Not Categorized")
    // ($array = [])

    {
        // error_log(print_r("Breakpoint 1: ". $array,true));
        // console_log(print_r($array,true));
        // if($d == 'a' || $d == 'v') {
        //     $ts = '23:59:59';
        //     $te = '23:59:59';
        // }
        // error_log(print_r("Breakpoint 2",true));
        // $this->notesAppend($na,$api,$drn,$ps,$ts,$de);
        // $vitals = 0;
        // $vitals = $this->checkVitals($fl,$ct,$ftp,$fcp,$csi,$rpj,
        // $pmp,$pms,$pus,$rsi,$pusl,$pmpa,$pmsa,$sitp,$sicp,
        // $chlr,$injp,$puon,$puoff);
        error_log(print_r($id,true));
        if($id != '' || $id != null)
        {
            error_log(print_r("Breakpoint 4",true));
            $this->select("SELECT sd FROM `notes` WHERE api=? AND id=?",["si",$api,$id]);
            while($row = $this->fetch_assoc){ $sd = $row['sd']; }
            $stmt = "UPDATE notes SET d=?, t=?, de=?, ts=?, te=?, deb=?, cvn=?, cin=?, drn=?, ai=?, ad=?, ec=?, edc=?, ecc=?, tt=?, dt=?, dc=?, at=?, ac=?, et=?, vb=?, producing_status=? WHERE api = ? AND id = ?";
            $this->select($stmt,['sssssssssssiddddddddissi', $d, $t, $de, $ts, $te, $deb, $cvn, $cin, $drn, $ai, $ad, $ec, $edc, $ecc, $tt, $dt, $dc, $at, $ac, $et, $vitals, $ps, $api, $id]);
            // $last_id = $this->insert_id;
            $last_id = $id;
            $logstmt = "INSERT INTO notes_log (notes_id, d, t, de, ts, te, deb, sd, api, cvn, cin, drn, eb, ec, edc, ecc, tt, dt, dc, at, ac, et, ai, ad, vb, producing_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $this->select($logstmt,['issssssssssssiddddddddssis', $last_id, $d, $t, $de, $ts, $te, $deb, $sd, $api, $cvn, $cin, $drn, $eb, $ec, $edc, $ecc, $tt, $dt, $dc, $at, $ac, $et, $ai, $ad, $vitals, $ps]);
            if($vitals > 0)
            {
                $vitalstmt = "INSERT INTO vitals (ftp, fcp, sitp, sicp, chlr, pmp, fl, pms, ct, pus, rsi, pusl, csi, rpj, pmpa, pmsa, puon, puoff, api, d, notes_id, injp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; 
                $this->select($vitalstmt,['ddddisdssdsdssiissssid', $ftp, $fcp, $sitp, $sicp, $chlr, $pmp, $fl, $pms, $ct, $pus, $rsi, $pusl, $csi, $rpj, $pmpa, $pmsa, $puon, $puoff, $api, $de, $id, $injp]);
            }
        }
        else 
        {
            if($id == null) {error_log(print_r('its null', true)); }
            error_log(print_r('$id: ' . $id, true));
            error_log(print_r('$na: ' . $na, true));
            error_log(print_r('$api: ' . $api, true));
            error_log(print_r('$d: ' . $d, true));
            error_log(print_r('$t: ' . $t, true));
            error_log(print_r('$de: ' . $de, true));
            error_log(print_r('$ts: ' . $ts, true));
            error_log(print_r('$te: ' . $te, true));
            error_log(print_r('$deb: ' . $deb, true));
            error_log(print_r('$cvn: ' . $cvn, true));
            error_log(print_r('$cin: ' . $cin, true));
            error_log(print_r('$drn: ' . $drn, true));
            error_log(print_r('$ai: ' . $ai, true));
            error_log(print_r('$ad: ' . $ad, true));
            error_log(print_r('$ec: ' . $ec, true));
            error_log(print_r('$edc: ' . $edc, true));
            error_log(print_r('$ecc: ' . $ecc, true));
            error_log(print_r('$tt: ' . $tt, true));
            error_log(print_r('$dt: ' . $dt, true));
            error_log(print_r('$dc: ' . $dc, true));
            error_log(print_r('$at: ' . $at, true));
            error_log(print_r('$ac: ' . $ac, true));
            error_log(print_r('$et: ' . $et, true));
            error_log(print_r('$ps: ' . $ps, true));
            error_log(print_r('$ft: ' . $ft, true));
            error_log(print_r('$eb: ' . $eb, true));
            error_log(print_r('$ftp: ' . $ftp, true));
            error_log(print_r('$fcp: ' . $fcp, true));
            error_log(print_r('$sitp: ' . $sitp, true));
            error_log(print_r('$sicp: ' . $sicp, true));
            error_log(print_r('$chlr: ' . $chlr, true));
            error_log(print_r('$pmp: ' . $pmp, true));
            error_log(print_r('$fl: ' . $fl, true));
            error_log(print_r('$pms: ' . $pms, true));
            error_log(print_r('$ct: ' . $ct, true));
            error_log(print_r('$pus: ' . $pus, true));
            error_log(print_r('$rsi: ' . $rsi, true));
            error_log(print_r('$pusl: ' . $pusl, true));
            error_log(print_r('$csi: ' . $csi, true));
            error_log(print_r('$rpj: ' . $rpj, true));
            error_log(print_r('$pmpa: ' . $pmpa, true));
            error_log(print_r('$pmsa: ' . $pmsa, true));
            error_log(print_r('$puon: ' . $puon, true));
            error_log(print_r('$puoff: ' . $puoff, true));
            error_log(print_r('$injp: ' . $injp, true));
            error_log(print_r('$wsbcat: ' . $wsbcat, true));
            error_log(print_r("Breakpoint 5",true));
            $stmt = "INSERT INTO notes (d, t, de, ts, te, deb, api, cvn, cin, drn, ai, ad, edc, ecc, tt, dt, dc, at, ac, et, vb, producing_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            error_log(print_r("Breakpoint 5a",true));
            $this->select($stmt,['ssssssssssssddddddddis', $d, $t, $de, $ts, $te, $deb, $api, $cvn, $cin, $drn, $ai, $ad, $edc, $ecc, $tt, $dt, $dc, $at, $ac, $et, $vitals, $ps]);
            error_log(print_r("Breakpoint 5b",true));
            $last_id = $this->insert_id;
            error_log(print_r("Breakpoint 5c",true));
            $this->select("SELECT sd FROM `notes` WHERE api=? AND id=?",["si",$api,$last_id]);
            error_log(print_r("Breakpoint 5d",true));
            while($row = $this->fetch_assoc){ $sd = $row['sd']; }
            error_log(print_r("Breakpoint 5e",true));
            $logstmt = "INSERT INTO notes_log (notes_id, d, t, de, ts, te, deb, sd, api, cvn, cin, drn, eb, ec, edc, ecc, tt, dt, dc, at, ac, et, ai, ad, vb, producing_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            error_log(print_r("Breakpoint 5f",true));
            $this->select($logstmt, ['issssssssssssiddddddddssis', $last_id, $d, $t, $de, $ts, $te, $deb, $sd, $api, $cvn, $cin, $drn, $eb, $ec, $edc, $ecc, $tt, $dt, $dc, $at, $ac, $et, $ai, $ad, $vitals, $ps]);
            error_log(print_r("Breakpoint 5g",true));
            if($vitals > 0)
            {
                $vitalstmt = "INSERT INTO vitals (ftp, fcp, sitp, sicp, chlr, pmp, fl, pms, ct, pus, rsi, pusl, csi, rpj, pmpa, pmsa, puon, puoff, api, d, notes_id, injp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $this->select($vitalstmt,['ddddisdssdsdssiissssid', $ftp, $fcp, $sitp, $sicp, $chlr, $pmp, $fl, $pms, $ct, $pus, $rsi, $pusl, $csi, $rpj, $pmpa, $pmsa, $puon, $puoff, $api, $de, $last_id, $injp]);
            }
            error_log(print_r("Breakpoint 5h",true));
        }
        if($id == '') {
            $a = array("last_id" => $last_id);
        }
        else
        {
            $a = array("last_id" => $id);
        }
        echo json_encode($a);  
        

    }
    public function insertDDRe($d, $t, $de, $ts, $te, $deb, $api, $cvn, $cin, $drn, $eb, $ec, $edc, $ecc, $vitals, $ps)
    {
        $stmt = "INSERT INTO notes (d, t, de, ts, te, deb, api, cvn, cin, drn, edc, ecc, vb, producing_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->select($stmt,['ssssssssssddis', $d, $t, $de, $ts, $te, $deb, $api, $cvn, $cin, $drn, $edc, $ecc, $vitals, $ps]);
        $last_id = $this->insert_id;
        $this->select("SELECT sd FROM `notes` WHERE api=? AND id=?",["si",$api,$last_id]);
        while($row = $this->fetch_assoc){ $sd = $row['sd']; }
        
        // $logstmt = "INSERT INTO notes_log (notes_id, d, t, de, ts, te, deb, sd, api, cvn, cin, drn, eb, ec, edc, ecc, tt, dt, dc, at, ac, et, ai, ad, vb, producing_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        // $this->select($logstmt, ['issssssssssssiddddddddssis', $last_id, $d, $t, $de, $ts, $te, $deb, $sd, $api, $cvn, $cin, $drn, $eb, $ec, $edc, $ecc, $tt, $dt, $dc, $at, $ac, $et, $ai, $ad, $vitals, $ps]);

        $logstmt = "INSERT INTO notes_log (notes_id, d, t, de, ts, te, deb, sd, api, cvn, cin, drn, eb, ec, edc, ecc, vb, producing_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->select($logstmt,['issssssssssssiddis', $last_id, $d, $t, $de, $ts, $te, $deb, $sd, $api, $cvn, $cin, $drn, $eb, $ec, $edc, $ecc, $vitals, $ps]);
    }
    public function editDDRe($api, $id, $d, $t, $de, $ts, $te, $deb, $cvn, $cin, $drn, $ec, $edc, $ecc, $vitals, $ps, $eb){
        // error_log(print_r("Breakpoint 4",true));
        $this->select("SELECT sd FROM `notes` WHERE api=? AND id=?",["si",$api,$id]);
        while($row = $this->fetch_assoc){ $sd = $row['sd']; }
        $stmt = "UPDATE notes SET d=?, t=?, de=?, ts=?, te=?, deb=?, cvn=?, cin=?, drn=?, ec=?, edc=?, ecc=?, vb=?, producing_status=? WHERE api = ? AND id = ?";
        $this->select($stmt,['sssssssssiddissi', $d, $t, $de, $ts, $te, $deb, $cvn, $cin, $drn, $ec, $edc, $ecc, $vitals, $ps, $api, $id]);
        // $last_id = $this->insert_id;
        $last_id = $id;
        $logstmt = "INSERT INTO notes_log (notes_id, d, t, de, ts, te, deb, sd, api, cvn, cin, drn, eb, ec, edc, ecc, vb, producing_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->select($logstmt,['issssssssssssiddis', $last_id, $d, $t, $de, $ts, $te, $deb, $sd, $api, $cvn, $cin, $drn, $eb, $ec, $edc, $ecc, $vitals, $ps]);
    }
    public function newCategory($wsbcat,$wsbslug)
    {
        if($this->select("SELECT * FROM `wsbcategories` WHERE slug=?",["s",$wsbslug]) == 0)
        {
            $this->select("INSERT INTO wsbcategories (category, slug) VALUES (?, ?)",['ss', $wsbcat, $wsbslug]);
        }
    }
    public function uploadFile($id,$api,$wsbslug,$de,$ft)
    {
        ///////////////////////begin upload file//////////////////////////////////
        $file_name = $_REQUEST['files[]'];
        $root = $_SERVER["DOCUMENT_ROOT"];
        $targetDir = "/wsb_files/" . $api . "/" . $wsbslug . "/" . $de . "/"; 
        $fullDir= $root . $targetDir;
        $allowTypes = array('jpg','png','jpeg','gif','doc','docx','pdf','pptx','docx','dotx','xlsx','bmp','tiff','tif','ppt','xls'); 
        if(!is_dir($fullDir)){
            //Directory does not exist, so lets create it.
            mkdir($fullDir, 0755, true);
        }
        $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = ''; 
        $fileNames = array_filter($_FILES['files']['name']); 
        if(!empty($fileNames)){ 
            console_log($fileNames);
            foreach($_FILES['files']['name'] as $key=>$val){ 
                // File upload path 
                $fileName = basename($_FILES['files']['name'][$key]); 
                //$fileName = Slug($fileName);
                $fileData = pathinfo(basename($_FILES['files']['name'][$key]) );
                // $fileName = uniqid() . '.' . $fileData['extension'];
                list($fn, $ext) = preg_split("/\./",$fileName);
                $fn = Slug($fn);
                console_log("filename no ext: " . $fn);
                $fileName = $fn . '.' . uniqid() . '.' .  $fileData['extension'];
                $fullFilePath = $fullDir . $fileName;
                $targetFilePath = $targetDir . $fileName; 
                console_log($fileName);
                // Check whether file type is valid 
                $fileType = pathinfo($fullFilePath, PATHINFO_EXTENSION); 
                if(in_array($fileType, $allowTypes)){ 
                // Upload file to server 
                    if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $fullFilePath)){ 
                    // Image db insert sql 
                        // $insertValuesSQL .= "('".$api."', '".$id."', '".$fileName."', '".sprintf('%s',$this->real_escape_string($targetFilePath))."', NOW(), '".$ft."'),"; 
                        $insertValuesSQL .= "('".$api."', '".$id."', '".$fileName."', '".$targetFilePath."', NOW(), '".$ft."'),"; 
                        $sql = "INSERT INTO notes_files (`api`, `note_id`, `filename`, `filepath`, `sd`, `t`) VALUES (?, ?, ?, ?, NOW(), ?)";
                        $insert = $this->select($sql,["sisss",$api,$id,$fileName,$targetFilePath,$ft]);
                        if($insert){ 
                            $errorUpload = !empty($errorUpload)?'Upload Error: '.trim($errorUpload, ' | '):''; 
                            $errorUploadType = !empty($errorUploadType)?'File Type Error: '.trim($errorUploadType, ' | '):''; 
                            $errorMsg = !empty($errorUpload)?'<br/>'.$errorUpload.'<br/>'.$errorUploadType:'<br/>'.$errorUploadType; 
                            $statusMsg = "Files are uploaded successfully.".$errorMsg; 
                        }else{ 
                            $statusMsg = "Sorry, there was an error uploading your file."; 
                        } 
                    }else{ 
                        $errorUpload .= $_FILES['files']['name'][$key].' | '; 
                    } 
                }else{ 
                    $errorUploadType .= $_FILES['files']['name'][$key].' | '; 
                } 
            }
        }else{ 
            $statusMsg = 'No files uploaded.'; 
        } 
    }
    public function checkVitals($fl=null,$ct=null,$ftp=null,$fcp=null,$csi=null,$rpj=null,
    $pmp=null,$pms=null,$pus=null,$rsi=null,$pusl=null,$pmpa=null,$pmsa=null,$sitp=null,$sicp=null,
    $chlr=null,$injp=null,$puon=null,$puoff=null)
    {
        if($fl !== null || $ct !== null || $ftp !== null || $fcp !== null || $csi !== null || $rpj !== null || 
        $pmp !== null || $pms !== null || $pus !== null || $rsi !== null || $pusl !== null || $pmpa !== null || 
        $pmsa !== null || $sitp !== null || $sicp !== null || $chlr !== null || $injp !== null || $puon !== null || 
        $puoff !== null)
        {
            // return true;
            // $vitals = 1;
            return 1;
        }
        else 
        {
            // return false;
            // $vitals = 0;
            return 0;
        }
    }
    public function insertVitals($api,$id,$de,$fl=null,$ct=null,$ftp=null,$fcp=null,$csi=null,$rpj=null,
    $pmp=null,$pms=null,$pus=null,$rsi=null,$pusl=null,$pmpa=null,$pmsa=null,$sitp=null,$sicp=null,
    $chlr=null,$injp=null,$puon=null,$puoff=null)
    {
        $vitalstmt = "INSERT INTO vitals (ftp, fcp, sitp, sicp, chlr, pmp, fl, pms, ct, pus, rsi, pusl, csi, rpj, pmpa, pmsa, puon, puoff, api, d, notes_id, injp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; 
        $this->select($vitalstmt,['ddddisdssdsdssiissssid', $ftp, $fcp, $sitp, $sicp, $chlr, $pmp, $fl, $pms, $ct, $pus, $rsi, $pusl, $csi, $rpj, $pmpa, $pmsa, $puon, $puoff, $api, $de, $id, $injp]);
    }
    public function notesAppend($na,$api,$drn,$ps,$ts,$de)
    {
        if($na == 'append'){
            $this->select("SELECT notes FROM `list` WHERE api=?",["s",$api]);
            
            while ($row = $this->fetch_assoc)
            {
                $origNotes = $row['notes'];
            } 
            $newNotes = $origNotes . "<br>" . $drn;
            $this->select("UPDATE list SET producing_status=?, notes=?, ts=?, de=? WHERE api = ?",['sssss', $ps, $newNotes, $ts, $de, $api]);
        }
        elseif($na == 'replace'){
            $this->select("UPDATE list SET producing_status=?, notes=?, ts=?, de=? WHERE api = ?",['sssss', $ps, $drn, $ts, $de, $api]);
        }
    }
    // insert_form.dsr - ajax/insert.ntf.php 
    public function insertDSR($id=null, $api, $de, $deb, $drn, $ec=null, $edc, $ecc, $eb=null)
    {
        $d = 's';
        $t = 's';
        if($id !== '')
        {
            $this->select("SELECT sd FROM `notes` WHERE api=? AND id=?",["si",$api,$id]);
            while($row = $this->fetch_assoc){ $sd = $row['sd']; }
            $stmt = "UPDATE notes SET d=?, t=?, de=?, deb=?, drn=?, ec=?, edc=?, ecc=? WHERE api = ? AND id = ?";
            $this->select($stmt,['sssssiddsi', $d, $t, $de, $deb, $drn, $ec, $edc, $ecc, $api, $id]);
            // $last_id = $this->insert_id;
            $last_id = $id;
            $logstmt = "INSERT INTO notes_log (notes_id, d, t, de, deb, sd, api, drn, ec, edc, ecc) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $this->select($logstmt,['issssssssidd', $last_id, $d, $t, $de, $deb, $sd, $api, $drn, $eb, $ec, $edc, $ecc]);
        }
        else 
        {
            $stmt = "INSERT INTO notes (d, t, de, deb, api, drn, ec, edc, ecc) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $this->select($stmt,['ssssssidd', $d, $t, $de, $deb, $api, $drn, $ec, $edc, $ecc]);
            // $stmt = "INSERT INTO notes (d, t, de, ts, te, deb, api, cvn, cin, drn, ai, ad, edc, ecc, tt, dt, dc, at, ac, et, vb, producing_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            // $this->select($stmt,['ssssssssssssddddddddis', $d, $t, $de, $ts, $te, $deb, $api, $cvn, $cin, $drn, $ai, $ad, $edc, $ecc, $tt, $dt, $dc, $at, $ac, $et, $vitals, $ps]);
            $last_id = $this->insert_id;
            $this->select("SELECT sd FROM `notes` WHERE api=? AND id=?",["si",$api,$last_id]);
            while($row = $this->fetch_assoc){ $sd = $row['sd']; }
            $logstmt = "INSERT INTO notes_log (notes_id, d, t, de, deb, sd, api, drn, ec, edc, ecc) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $this->select($logstmt,['issssssssidd', $last_id, $d, $t, $de, $deb, $sd, $api, $drn, $eb, $ec, $edc, $ecc]);
            // $logstmt = "INSERT INTO notes_log (notes_id, d, t, de, ts, te, deb, sd, api, cvn, cin, drn, eb, ec, edc, ecc, tt, dt, dc, at, ac, et, ai, ad, vb, producing_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            // $this->select($logstmt, ['issssssssssssiddddddddssis', $last_id, $d, $t, $de, $ts, $te, $deb, $sd, $api, $cvn, $cin, $drn, $eb, $ec, $edc, $ecc, $tt, $dt, $dc, $at, $ac, $et, $ai, $ad, $vitals, $ps]);
        }
    }
    // insert_well_form - ajax/insert.well.php -> ajax/fetchwells.php 
    public function insertWell($id=null,$eo,$eoc,$s,$cp,$wl,$wn,$ecn,$et,$r,$pt,$ps,$dt,$sd,$cd,$fpd,$lpd,$up,$lp,$gg,$og,$wc,$maw,$mp,$ggr,$ogr,$md,$tvd,$lat,$long,$p,$rf,$l,$gc,$li,$show,$b,$f,$api)
    {
        $check = $this->numRows("SELECT * FROM list WHERE api = ?", ["s", $api]);
        if($check > 0)
        {
            $stmt = "UPDATE list SET 
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
                WHERE api = ?";
            
            return $this->select($stmt,['sssssssssssssiiddsiiisssiisssddssissss', 
            $eo, $eoc, $wl, $wn, $ecn, $et, $cp, $r, $pt, $ps, $dt, $fpd, $lpd, $up, $lp, $gg, $og, $cd, $wc, $maw, $mp, $ggr, $ogr, $sd, $md, $tvd, $f, $s, $b, $lat, $long, $p, $rf, $show, $l, $gc, $li, $api]);
        }
        else
        {
            $stmt = "INSERT INTO list ( 
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
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            return $this->select($stmt,['sssssssssssssiiddsiiisssiisssddssissss', 
            $eo, $eoc, $wl, $wn, $ecn, $et, $cp, $r, $pt, $ps, $dt, $fpd, $lpd, $up, $lp, $gg, $og, $cd, $wc, $maw, $mp, $ggr, $ogr, $sd, $md, $tvd, $f, $s, $b, $lat, $long, $p, $rf, $show, $l, $gc, $li, $api]);
        }

    }
    // click->.edit_ddr-e - ajax/fetch.php 
    // click->.edit_ddr-a - ajax/fetch.php 
    // click->.edit_ddr-v - ajax/fetch.php 
    // click->.edit_ddr-f - ajax/fetch.php 
    // click->.edit_dsr - ajax/fetch.php
    public function fetchNote($id)
    {
        return $this->select("SELECT * FROM notes WHERE id = ?",["s",$id]);
    }
    // click->.delete_data - ajax/delete.note.php
    public function deleteNote($id)
    {
        return $this->select("DELETE FROM notes WHERE id = ?",["s",$id]);
    }
    // click->.edit-well-info - ajax/fetchwells.php
    public function fetchWell($api)
    {
        return $this->select("SELECT * FROM list WHERE api = ?",["s",$api]);
    }


    public function getUsers($limit)
    {
        return $this->select("SELECT * FROM list LIMIT ?", ["i", $limit]);
    }

}