<?php
if(isset($_POST['eng']))
{
    $table = "new_ddr";
    $t = "ddr";
    $department = "eng";
    $api = $_POST['api'];
    $d = $_POST['ddr_date'];
    $ts = $_POST['time_start'];
    $te = $_POST['time_end'];
    $deb = $_POST['data_entry_by'];

    $ec = $_POST['ec'];
    $eci = $_POST['eci'];
    $edr = $_POST['edr'];
    $edc = $_POST['eng_edc'];
    $ecc = $_POST['eng_ecc'];
    require_once (__DIR__ . "./../Model/inline.php");
    $inline = new inline();
    $result = $inline->addEngDDR($t, $d, $ts, $te, $ec, $eci, $edr, $edc, $ecc, $deb, $api);
}
elseif(isset($_POST['acct']))
{
    $table = "new_ddr";
    $t = "ddr";
    $department = "acct";
    $api = $_POST['api'];
    $d = $_POST['ddr_date'];
    $ts = $_POST['time_start'];
    $te = $_POST['time_end'];
    $deb = $_POST['data_entry_by'];

    $av = $_POST['av'];
    $ain = $_POST['ain'];
    $aid = $_POST['aid'];
    $aia = $_POST['aia'];
    $aai = $_POST['aai'];
    if($_POST['aad'] != "")
    {
        $aad = $_POST['aad'] . ", ";
        $_aad = "`acct_approval_date`,";
    }
    else 
    { 
        $aad = "";
        $_aad = ""; 
    }
    require_once (__DIR__ . "./../Model/inline.php");
    $inline = new inline();
    $result = $inline->addAcctDDR($t, $d, $ts, $te, $av, $ain, $aid, $aia, $aai, $aad, $deb, $api);
}
elseif(isset($_POST['vend']))
{
    $table = "new_ddr";
    $t = "ddr";
    $department = "vend";
    $api = $_POST['api'];
    $d = $_POST['ddr_date'];
    $ts = $_POST['time_start'];
    $te = $_POST['time_end'];
    $deb = $_POST['data_entry_by'];

    $vna = $_POST['vna'];
    $vs = $_POST['vs'];
    $vno = $_POST['vno'];

    if($_POST['vah'] != "")
    {
        $vah = $_POST['vah'] . ", ";
        $_vah = "`vend_adjust_hrs`,";
    }
    else 
    { 
        $vah = "";
        $_vah = ""; 
    }
    if($_POST['vac'] != "")
    {
        $vac = $_POST['vac'] . ", ";
        $_vac = "`vend_adjust_cost`,";
    }
    else 
    { 
        $vac = "";
        $_vac = ""; 
    }
    if($_POST['vet'] != "")
    {
        $vet = $_POST['vet'] . ", ";
        $_vet = "`vend_est_travel`,";
    }
    else 
    { 
        $vet = "";
        $_vet = ""; 
    }
    if($_POST['vtt'] != "")
    {
        $vtt = $_POST['vtt'] . ", ";
        $_vtt = "`vend_total_hours`,";
    }
    else 
    { 
        $vtt = "";
        $_vtt = ""; 
    }
    if($_POST['vtc'] != "")
    {
        $vtc = $_POST['vtc'] . ", ";
        $_vtc = "`vend_total_cost`,";
    }
    else 
    { 
        $vtc = "";
        $_vtc = ""; 
    }
    require_once (__DIR__ . "./../Model/inline.php");
    $inline = new inline();
    $result = $inline->addVendDDR($t, $d, $ts, $te, $vna, $vs, $vno, $vah, $vac, $vet, $vtt, $vtc, $_vah, $_vac, $_vet, $_vtt, $_vtc, $deb, $api);
        }
elseif(isset($_POST['field']))
{
    $table = "new_ddr";
    $t = "ddr";
    $department = "field";
    $api = $_POST['api'];
    $d = $_POST['ddr_date'];
    $ts = $_POST['time_start'];
    $te = $_POST['time_end'];
    $deb = $_POST['data_entry_by'];

    $fc = $_POST['fc'];
    $fci = $_POST['fci'];
    $fdr = $_POST['fdr'];
    $fdc = $_POST['fdc'];
    $fcc = $_POST['fcc'];
    require_once (__DIR__ . "./../Model/inline.php");
    $inline = new inline();
    $result = $inline->addFieldDDR($t, $d, $ts, $te, $fc, $fci, $fdr, $fdc, $fcc, $deb, $api);

}

?>