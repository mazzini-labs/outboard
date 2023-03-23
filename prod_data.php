<?php
require_once("lib/OutboardDatabase.php");
require_once("lib/OutboardAuth.php");

//include_once("include/char_widths.php");
include_once("include/common.php");

include 'include/variables.php';

// Create main objects;
$auth = new OutboardAuth();
$ob   = new OutboardDatabase();

// Set some simple variables used later in the page
$baseurl             = $_SERVER['PHP_SELF'];
$current             = getdate();
$image_dir           = $ob->getConfig('image_dir');
// Get the session (if there is one)
$session = $auth->getSessionCookie();

if ($ob->getConfig('authtype') == "internal") {
  $BasicAuthInUse = false;
  if ($username = getPostValue('username') and $password = getPostValue('password')) {
    $session = $ob->checkPassword($username,$password);
  }
} else {
  $BasicAuthInUse = true;
  if (! $session) {
    $username = $auth->checkBasic();
    if ($ob->isBoardMember($username)) {
      $ob->setOperatingUser($username);
      $session = $ob->setSession();
    }
  }
}

$auth->setSessionCookie($session,$cookie_time_seconds);
$username = $ob->getSession($session);



// include 'WSB/includes.php';
include 'include/wsbFunctions.php';

$cp = 0;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = connect_db();
$api = '"' . $_GET['api'] . '"';
$apiNoQuot = $_GET['api'];
//console_log($api);
if ( isset( $_POST['submit'] ) || isset( $api) )
{ 
	//$api = mysql_real_escape_string($_POST['api']);
	if ( ! isset( $api) ) { $api = '"' . $_POST['api'] . '"'; }
	//console_log($api);
	/*$sql = "SELECT * 
		FROM $dbTableName, $dbTableNameCat 
		WHERE categoryid=$dbTableNameCat.id 
		ORDER BY $dbTableName.id DESC LIMIT 1";*/
	$data = "prod_data";
	$pm = "prod_mo";
	
	
	$wellsql = "SELECT * FROM `list` where api =  $api ";
	$wellResult = mysqli_query($mysqli, $wellsql);
	while ($row = mysqli_fetch_array($wellResult)) {
		$well = $row['well_lease'] . " " . $row['well_no'] . " | " . $row['api'];
        $welllease = $row['well_lease'];
		$apino = $row['api'];
		$wellstatus = $row['producing_status'];
		$entop = $row['entity_operator_code'];
		$common_name = $row['entity_common_name'];
		$countyparish = $row['county_parish'];
		$reservoir = $row['reservoir'];
		$prod_type = $row['production_type'];
		$drill_type = $row['drill_type'];
		$firstprod = $row['first_prod_date'];
		$lastprod = $row['last_prod_date'];
		$upper_perf = $row['upper_perforation'];
		$lower_perf = $row['lower_perforation'];
		$gas_gravity = $row['gas_gravity'];
		$oil_gravity = $row['oil_gravity'];
		$complete_date = $row['completion_date'];
		$monthsproduced = $row['months_produced'];
		$gas_gather = $row['gas_gatherer'];
		$oil_gather = $row['oil_gatherer'];
		$spud = $row['spud_date'];
		$md = $row['measured_depth_td'];
		$tvd = $row['true_vertical_depth'];
		$db_field = $row['field'];
		$db_state = $row['state'];
		$db_block = $row['block'];
		$db_lat = $row['surface_latitude_wgs84'] * 1.000000;
		$db_long = $row['surface_longitude_wgs84'] * 1.000000;
		$db_notes = $row['notes'];
		$db_notes_update = $row['notes_update'];
		$db_pumper = $row['pumper'];
		$wellfilelocation = $row['well_file_location'];
        $landowner = $row['landowner'];
        $gatecombo = $row['gatecombo'];
        $landowner_notes = $row['landowner_notes'];
	}
	if($wellstatus == 'Shut-in' || $wellstatus == 'Shut-In' || $wellstatus == 'INACTIVE'){
		$status = "style='color:red;'";
		//$status = "style='background-color: #F08080;'><small";
	}else{
		$status = "style='color:green;'";
	}
	$date = '';
	$data1 = '';
    $data2 = '';
	$data3 = '';
	//$sql = "SELECT `list`.*, `prod_data`.*
    //         FROM list, prod_data
    //         WHERE `api` = $api AND `list`.`api` = `prod_data`.`api`
    //       "; 
	$sql = "SELECT * FROM `prod_data` where api =  $api ";
    $result = mysqli_query($mysqli, $sql);
	//console_log($result);
	//loop through the returned data
	while ($row = mysqli_fetch_array($result)) {
		//$prod_mo = $row['date'];
		$oilprod = round($row['oil_prod']);
		$gasprod = round($row['gas_wh_mcf']);
		$waterprod = round($row['water_prod']);
        $proddate = $proddate . '"'. $row['prod_mo'].'",';
		// $data1 = $data1 . '"'. $row['oil_prod'].'",';
        // $data2 = $data2 . '"'. $row['gas_wh_mcf'] .'",';
		// $data3 = $data3 . '"'. $row['water_prod'] .'",';
		$data1 = $data1 . '"'. $oilprod .'",';
        $data2 = $data2 . '"'. $gasprod .'",';
        $data3 = $data3 . '"'. $waterprod .'",';
        $cumoil = $cumoil + $oilprod;
        $cumgas = $cumgas + $gasprod;
        $cumwater = $cumwater + $waterprod;
	}
	
    $proddate = trim($proddate,",");
	$data1 = trim($data1,",");
    $data2 = trim($data2,",");
    $data3 = trim($data3,",");
        /*
    $width1 = "";
    $width2 = "";
    $width3 = "";
    $width4 = "";
    $width7 = "";
    $width14 = "";
        */
    $width1 = "width=1%";
    $width2 = "width=2%";
    $width3 = "width=3%";
    $width4 = "width=4%";
    $width7 = "width=7%";
    $width10 = "width=22%";
    $width14 = "width=24%";

    
	$chartsql = "SELECT * FROM `vitals` where api =  $api order by d asc";
    $chartresult = mysqli_query($mysqli, $chartsql);
    // console_log($chartresult);
	//console_log($result);
	//loop through the returned data
	while ($row = mysqli_fetch_array($chartresult)) {
		//$prod_mo = $row['date'];
		$ftp = $row['ftp'];
		$fcp = $row['fcp'];
        $sitp = $row['sitp'];
        $sicp = $row['sicp'];
		$pmp = $row['pmp'];
        $pms = $row['pms'];
        $pmpa = $row['pmpa'];
		$pmsa = $row['pmsa'];
		$ct = $row['ct'];
        $pus = $row['pus'];
		$pusl = $row['pusl'];
		$rsi = $row['rsi'];
        $csi = $row['csi'];
		$rpj = $row['rpj'];
		$fl = $row['fl'];
        $chlr = $row['chlr'];
        $date = $row['d'];
        if($ftp != '')
        {
            $ftpData = $ftpData . '"'. $ftp .'",';
            $ftpDate = $ftpDate . '"'. $date .'",';
            $ftpLastDate = $date;
            $ftpLast = $ftp;
        }
        if($fcp != '')
        {
            $fcpData = $fcpData . '"'. $fcp .'",';
            $fcpDate = $fcpDate . '"'. $date .'",';
            $fcpLastDate = $date;
            $fcpLast = $fcp;
        }
        if($sitp != '')
        {
            $sitpData = $sitpData . '"'. $sitp .'",';
            $sitpDate = $sitpDate . '"'. $date .'",';
            $sitpLastDate = $date;
            $sitpLast = $sitp;
        }
        if($sicp != '')
        {
            $sicpData = $sicpData . '"'. $sicp .'",';
            $sicpDate = $sicpDate . '"'. $date .'",';
            $sicpLastDate = $date;
            $sicpLast = $sicp;
        }
        if($pmp != '')
        {
            $pmpData = $pmpData . '"'. $pmp .'",';
            $pmpDate = $pmpDate . '"'. $date .'",';
            $pmpLastDate = $date;
            $pmpLast = $pmp;
        }
        if($pms != '')
        {
            $pmsData = $pmsData . '"'. $pms .'",';
            $pmsDate = $pmsDate . '"'. $date .'",';
            $pmsLastDate = $date;
            $pmsLast = $pms;
        }
        if($pmpa != '')
        {
            $pmpaData = $pmpaData . '"'. $pmpa .'",';
            $pmpaDate = $pmpaDate . '"'. $date .'",';
            $pmpaLastDate = $date;
            $pmpaLast = $pmpa;
        }
        if($pmsa != '')
        {
            $pmsaData = $pmsaData . '"'. $pmsa .'",';
            $pmsaDate = $pmsaDate . '"'. $date .'",';
            $pmsaLastDate = $date;
            $pmsaLast = $pmsa;
        }
        if($ct != '')
        {
            $ctData = $ctData . '"'. $ct .'",';
            $ctDate = $ctDate . '"'. $date .'",';
            $ctLastDate = $date;
            $ctLast = $ct;
        }
        if($pus != '')
        {
            $pusData = $pusData . '"'. $pus .'",';
            $pusDate = $pusDate . '"'. $date .'",';
            $pusLastDate = $date;
            $pusLast = $pus;
        }
        if($pusl != '')
        {
            $puslData = $puslData . '"'. $pusl .'",';
            $puslDate = $puslDate . '"'. $date .'",';
            $puslLastDate = $date;
            $puslLast = $pusl;
        }
        if($rsi != '')
        {
            $rsiData = $rsiData . '"'. $rsi .'",';
            $rsiDate = $rsiDate . '"'. $date .'",';
            $rsiLastDate = $date;
            $rsiLast = $rsi;
        }
        if($csi != '')
        {
            $csiData = $csiData . '"'. $csi .'",';
            $csiDate = $csiDate . '"'. $date .'",';
            $csiLastDate = $date;
            $csiLast = $csi;
        }
        if($rpj != '')
        {
            $rpjData = $rpjData . '"'. $rpj .'",';
            $rpjDate = $rpjDate . '"'. $date .'",';
            $rpjLastDate = $date;
            $rpjLast = $rpj;
        }
        if($fl != '')
        {
            $flData = $flData . '"'. $fl .'",';
            $flDate = $flDate . '"'. $date .'",';
            $flLastDate = $date;
            $flLast = $fl;
        }
        if($chlr != '')
        {
            $chlrData = $chlrData . '"'. $chlr .'",';
            $chlrDate = $chlrDate . '"'. $date .'",';
            $chlrLastDate = $date;
            $chlrLast = $chlr;
        }


	}
    // console_log($ftp);
    // console_log($fcpDate);
    $ftpData = trim($ftpData,",");
	$ftpDate = trim($ftpDate,",");
    $fcpData = trim($fcpData,",");
    $fcpDate = trim($fcpDate,",");
    $sitpData = trim($sitpData,",");
	$sitpDate = trim($sitpDate,",");
    $sicpData = trim($sicpData,",");
    $sicpDate = trim($sicpDate,",");	
    $pmpData = trim($pmpData,",");
	$pmpDate = trim($pmpDate,",");
    $pmsData = trim($pmsData,",");
    $pmsDate = trim($pmsDate,",");
    $pmpaData = trim($pmpaData,",");
	$pmpaDate = trim($pmpaDate,",");
    $pmsaData = trim($pmsaData,",");
    $pmsaDate = trim($pmsaDate,",");	
    $ctData = trim($ctData,",");
	$ctDate = trim($ctDate,",");
    $pusData = trim($pusData,",");
    $pusDate = trim($pusDate,",");
    $puslData = trim($puslData,",");
	$puslDate = trim($puslDate,",");
    $rsiData = trim($rsiData,",");
    $rsiDate = trim($rsiDate,",");	
    $csiData = trim($csiData,",");
	$csiDate = trim($csiDate,",");
    $rpjData = trim($rpjData,",");
    $rpjDate = trim($rpjDate,",");
    $flData = trim($flData,",");
	$flDate = trim($flDate,",");
    $chlrData = trim($chlrData,",");
    $chlrDate = trim($chlrDate,",");
    // console_log($fcpData);
    // console_log($fcpDate);
    if($ftpLast == ''){ $ftpLast = "Never Recorded";} else { $ftpLast = $ftpLast . " psi";}	
    if($fcpLast == ''){ $fcpLast = "Never Recorded";} else { $fcpLast = $fcpLast . " psi";}	
    if($sitpLast == ''){ $sitpLast = "Never Recorded";} else { $sitpLast = $sitpLast . " psi";}	
    if($sicpLast == ''){ $sicpLast = "Never Recorded";} else { $sicpLast = $sicpLast . " psi";}	
    // if($pmpLast == ''){ $pmpLast = "Never Recorded";} 	
    switch($pmpLast){
        case 1: 
            $pmpLast = "Pulled Well";
            break;
        case 2: 
            $pmpLast = "Hot Oiled";
            break;
        case 3: 
            $pmpLast = "Chemical Treatment";
            break;
        case 4:
            $pmpLast = "Not yet set";
            break;
        case 5:
            $pmpLast = "Not yet set";
            break;
        case 6:
            $pmpLast = "Not yet set";
            break;
        case 7:
            $pmpLast = "Not yet set";
            break;
        case 8:
            $pmpLast = "Not yet set";
            break;
        case 9:
            $pmpLast = "Not yet set";
            break;
        case 10:
            $pmpLast = "Not yet set";
            break;
        default:
            $pmpLast = "Never Recorded";
    }
    // if($pmsLast == ''){ $pmsLast = "Never Recorded";} 	
    switch($pmsLast){
        case 1: 
            $pmsLast = "Pulled Well";
            break;
        case 2: 
            $pmsLast = "Hot Oiled";
            break;
        case 3: 
            $pmsLast = "Chemical Treatment";
            break;
        case 4:
            $pmsLast = "Not yet set";
            break;
        case 5:
            $pmsLast = "Not yet set";
            break;
        case 6:
            $pmsLast = "Not yet set";
            break;
        case 7:
            $pmsLast = "Not yet set";
            break;
        case 8:
            $pmsLast = "Not yet set";
            break;
        case 9:
            $pmsLast = "Not yet set";
            break;
        case 10:
            $pmsLast = "Not yet set";
            break;
        default:
            $pmsLast = "Never Recorded";
    }
    if($pmpaLast == ''){ $pmpaLast = "Never Recorded";} else { $pmpaLast = $pmpaLast . " bbl";}	
    if($pmsaLast == ''){ $pmsaLast = "Never Recorded";} else { $pmsaLast = $pmsaLast . " bbl";}	
    // if($ctLast == ''){ $ctLast = "Never Recorded";}
    switch($ctLast){
        case 1: 
            $ctLast = "N/A";
            break;
        case 2: 
            $ctLast = "Batch";
            break;
        case 3: 
            $ctLast = "Drip";
            break;
        // case 4:
        //     $ctLast = "Not yet set";
        //     break;
        // case 5:
        //     $ctLast = "Not yet set";
        //     break;
        // case 6:
        //     $ctLast = "Not yet set";
        //     break;
        // case 7:
        //     $ctLast = "Not yet set";
        //     break;
        // case 8:
        //     $ctLast = "Not yet set";
        //     break;
        // case 9:
        //     $ctLast = "Not yet set";
        //     break;
        // case 10:
        //     $ctLast = "Not yet set";
        //     break;
        default:
            $ctLast = "Never Recorded";
    } 	
    if($pusLast == ''){ $pusLast = "Never Recorded";} else { $pusLast = $pusLast . " stroke/min";}	
    if($puslLast == ''){ $puslLast = "Never Recorded";} else { $puslLast = $puslLast . " ft";}	
    // if($rsiLast == ''){ $rsiLast = "Never Recorded";} 
    switch($rsiLast){
        case 1: 
            $rsiLast = "Not yet set";
            break;
        case 2: 
            $rsiLast = "Not yet set";
            break;
        case 3: 
            $rsiLast = "Not yet set";
            break;
        case 4:
            $rsiLast = "Not yet set";
            break;
        case 5:
            $rsiLast = "Not yet set";
            break;
        case 6:
            $rsiLast = "Not yet set";
            break;
        case 7:
            $rsiLast = "Not yet set";
            break;
        case 8:
            $rsiLast = "Not yet set";
            break;
        case 9:
            $rsiLast = "Not yet set";
            break;
        case 10:
            $rsiLast = "Not yet set";
            break;
        default:
            $rsiLast = "Never Recorded";
    }
    if($csiLast == ''){ $csiLast = "Never Recorded";} 	
    if($rpjLast == ''){ $rpjLast = "Never Recorded";} else { $rpjLast = $rpjLast . " psi";}	
    if($flLast == ''){ $flLast = "Never Recorded";} else { $flLast = $flLast . " ft";}	
    if($chlrLast == ''){ $chlrLast = "Never Recorded";} else { $chlrLast = $chlrLast . " ppm";}	
    
    ## The following creates a check variable for each of the old well notes.
    ## This is used to either show or not show the tabs based on whether the check is 1 or 0.
    $ddr20sql = "SELECT * from `ddr_old` WHERE api like $api";
    $ddr20result = mysqli_query($mysqli, $ddr20sql);
    if(mysqli_num_rows($ddr20result) > 0){
        $ddr20check = 1;
    } else {
        $ddr20check = 0;
    }
    $connWellNotes = connect_wellNotes();
    $convert = "SELECT well from `000api_list` WHERE `api` like \"%".$apiNoQuot."%\"";
    $wellResult = mysqli_query($connWellNotes, $convert);
    while ($row = mysqli_fetch_array($wellResult)) {
        $wellCheck = $row['well'];
    }
    $dsr20sql = "SELECT * from `$wellCheck` WHERE sheet like 'dsr2015pres'";
    $dsr15sql = "SELECT * from `$wellCheck` WHERE sheet like 'before2015sumrpt'";
    $ddr15sql = "SELECT * from `$wellCheck` WHERE sheet like 'before2015detailrpt'";
    try {
        $dsr20result = mysqli_query($connWellNotes, $dsr20sql);
        if(mysqli_num_rows($dsr20result) > 0){
            $dsr20check = 1;
        } else {
            $dsr20check = 0;
        }
        $dsr15result = mysqli_query($connWellNotes, $dsr15sql);
        if(mysqli_num_rows($dsr15result) > 0){
            $dsr15check = 1;
        } else {
            $dsr15check = 0;
        }
        $ddr15result = mysqli_query($connWellNotes, $ddr15sql);
        if(mysqli_num_rows($ddr15result) > 0){
            $ddr15check = 1;
        } else {
            $ddr15check = 0;
        }
    }
    catch (Exception $e) {
        $dsr20check = 0;
        $dsr15check = 0;
        $ddr15check = 0;
    }
    mysqli_close($connWellNotes);
?>
<!doctype html>
<html lang="en">
<head>
    <?php include 'include/dependencies.php'; ?>
    <!-- <script src="https://unpkg.com/feather-icons"></script> -->
    <script type="text/javascript" src="/assets/js/chart.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@0.7.7"></script>
    <script type="text/javascript" src="./assets/js/inlineEdit.js"></script>
    <style>
  .file-upload{position:relative;height:8rem;margin-bottom:2rem;margin-top:2rem}.file-upload .file-upload-input{border-radius:.25rem;width:100%;border:.125rem dashed rgba(0,0,0,.2);height:8rem;text-align:center;cursor:pointer;position:relative;display:inline-block;padding:8rem 0 0 0;overflow:hidden;z-index:1;transition:.3s ease}.file-upload .file-upload-input:hover{border-color:rgba(0,0,0,.4);background-color:rgba(0,0,0,.05)}.file-upload span{position:absolute;top:0;bottom:0;line-height:8rem;width:100%;text-align:center;margin:auto;z-index:0;left:0;color:rgba(0,0,0,.5)}.file-upload span i{color:#00f;margin-right:1rem}.file-upload-previews>.MultiFile-label{border-radius:.1875rem;background-color:rgba(0,0,0,.03);display:inline-block;border:.125rem solid rgba(0,0,0,.1);padding:1rem;position:relative;margin-right:1rem;margin-bottom:1rem;width:100%}.file-upload-previews span.MultiFile-label{position:relative;text-align:center;margin:1rem}.file-upload-previews span.MultiFile-label .MultiFile-subtitle{background-color:rgba(0,0,0,.4);color:#fff;padding:1rem;bottom:0;font-size:.75rem;text-align:center;width:100%;border-radius:.5rem}.file-upload-previews span.MultiFile-label .MultiFile-title{color:#fff;padding:1rem;bottom:0;font-size:.75rem;text-align:center;width:100%;border-radius:.5rem}.file-upload-previews span.MultiFile-label .MultiFile-preview{max-width:14rem!important;max-height:7rem!important}.file-uploaded-images .image{height:15rem;display:inline-block;margin-bottom:1.8rem;margin-right:1.5rem;position:relative}.file-uploaded-images .image figure{box-shadow:0 .125rem .3125rem rgba(0,0,0,.1);border-radius:50%;cursor:pointer;background-color:red;width:2rem;height:2rem;position:absolute;right:-1rem;top:-1rem;content:"";text-align:center;line-height:1.5rem}.file-uploaded-images .image figure i{color:#fff;font-size:1rem}.file-uploaded-images .image img{height:100%}.file-uploaded-images .image{box-shadow:0 .125rem .3125rem rgba(0,0,0,.1);height:10rem;display:inline-block;margin-bottom:1rem;margin-right:1rem;position:relative}.file-uploaded-images .image figure{box-shadow:0 .125rem .3125rem rgba(0,0,0,.1);border-radius:50%;cursor:pointer;background-color:red;width:1.5rem;height:1.5rem;position:absolute;right:-0.75rem;top:-0.75rem;content:"";text-align:center;line-height:1.375rem}.file-uploaded-images .image figure i{color:#fff;font-size:.75rem}.file-uploaded-images .image img{height:100%}.MultiFile-remove{line-height:.625rem!important}.fs-1{font-size:1px}.fs-2{font-size:2px}.fs-3{font-size:3px}.fs-4{font-size:4px}.fs-5{font-size:5px}.fs-6{font-size:6px}.fs-7{font-size:7px}.fs-8{font-size:8px}.fs-9{font-size:9px}.fs-10{font-size:10px}.fs-11{font-size:11px}.fs-12{font-size:12px}.fs-13{font-size:13px}.fs-14{font-size:14px}.fs-15{font-size:15px}.fs-16{font-size:16px}.fs-17{font-size:17px}.fs-18{font-size:18px}.fs-19{font-size:19px}.fs-20{font-size:20px}.fs-21{font-size:21px}.fs-22{font-size:22px}.fs-23{font-size:23px}.fs-24{font-size:24px}.fs-25{font-size:25px}.fs-26{font-size:26px}.fs-27{font-size:27px}.fs-28{font-size:28px}.fs-29{font-size:29px}.fs-30{font-size:30px}.fs-31{font-size:31px}.fs-32{font-size:32px}.fs-33{font-size:33px}.fs-34{font-size:34px}.fs-35{font-size:35px}.fs-36{font-size:36px}.fs-37{font-size:37px}.fs-38{font-size:38px}.fs-39{font-size:39px}.fs-40{font-size:40px}.fs-41{font-size:41px}.fs-42{font-size:42px}.fs-43{font-size:43px}.fs-44{font-size:44px}.fs-45{font-size:45px}.fs-46{font-size:46px}.fs-47{font-size:47px}.fs-48{font-size:48px}.fs-49{font-size:49px}.fs-50{font-size:50px}.fs-51{font-size:51px}.fs-52{font-size:52px}.fs-53{font-size:53px}.fs-54{font-size:54px}.fs-55{font-size:55px}.fs-56{font-size:56px}.fs-57{font-size:57px}.fs-58{font-size:58px}.fs-59{font-size:59px}.fs-60{font-size:60px}.fs-61{font-size:61px}.fs-62{font-size:62px}.fs-63{font-size:63px}.fs-64{font-size:64px}.fs-65{font-size:65px}.fs-66{font-size:66px}.fs-67{font-size:67px}.fs-68{font-size:68px}.fs-69{font-size:69px}.fs-70{font-size:70px}.fs-71{font-size:71px}.fs-72{font-size:72px}.fs-73{font-size:73px}.fs-74{font-size:74px}.fs-75{font-size:75px}.fs-76{font-size:76px}.fs-77{font-size:77px}.fs-78{font-size:78px}.fs-79{font-size:79px}.fs-80{font-size:80px}.fs-81{font-size:81px}.fs-82{font-size:82px}.fs-83{font-size:83px}.fs-84{font-size:84px}.fs-85{font-size:85px}.fs-86{font-size:86px}.fs-87{font-size:87px}.fs-88{font-size:88px}.fs-89{font-size:89px}.fs-90{font-size:90px}.fs-91{font-size:91px}.fs-92{font-size:92px}.fs-93{font-size:93px}.fs-94{font-size:94px}.fs-95{font-size:95px}.fs-96{font-size:96px}.fs-97{font-size:97px}.fs-98{font-size:98px}.fs-99{font-size:99px}.fs-100{font-size:100px}.fs-101{font-size:101px}.fs-102{font-size:102px}.fs-103{font-size:103px}.fs-104{font-size:104px}.fs-105{font-size:105px}.fs-106{font-size:106px}.fs-107{font-size:107px}.fs-108{font-size:108px}.fs-109{font-size:109px}.fs-110{font-size:110px}.fs-111{font-size:111px}.fs-112{font-size:112px}.fs-113{font-size:113px}.fs-114{font-size:114px}.fs-115{font-size:115px}.fs-116{font-size:116px}.fs-117{font-size:117px}.fs-118{font-size:118px}.fs-119{font-size:119px}.fs-120{font-size:120px}.fs-121{font-size:121px}.fs-122{font-size:122px}.fs-123{font-size:123px}.fs-124{font-size:124px}.fs-125{font-size:125px}.fs-126{font-size:126px}.fs-127{font-size:127px}.fs-128{font-size:128px}.fs-129{font-size:129px}.fs-130{font-size:130px}.fs-131{font-size:131px}.fs-132{font-size:132px}.fs-133{font-size:133px}.fs-134{font-size:134px}.fs-135{font-size:135px}.fs-136{font-size:136px}.fs-137{font-size:137px}.fs-138{font-size:138px}.fs-139{font-size:139px}.fs-140{font-size:140px}.fs-141{font-size:141px}.fs-142{font-size:142px}.fs-143{font-size:143px}.fs-144{font-size:144px}.fs-145{font-size:145px}.fs-146{font-size:146px}.fs-147{font-size:147px}.fs-148{font-size:148px}.fs-149{font-size:149px}.fs-150{font-size:150px}.fs-151{font-size:151px}.fs-152{font-size:152px}.fs-153{font-size:153px}.fs-154{font-size:154px}.fs-155{font-size:155px}.fs-156{font-size:156px}.fs-157{font-size:157px}.fs-158{font-size:158px}.fs-159{font-size:159px}.fs-160{font-size:160px}.fs-161{font-size:161px}.fs-162{font-size:162px}.fs-163{font-size:163px}.fs-164{font-size:164px}.fs-165{font-size:165px}.fs-166{font-size:166px}.fs-167{font-size:167px}.fs-168{font-size:168px}.fs-169{font-size:169px}.fs-170{font-size:170px}.fs-171{font-size:171px}.fs-172{font-size:172px}.fs-173{font-size:173px}.fs-174{font-size:174px}.fs-175{font-size:175px}.fs-176{font-size:176px}.fs-177{font-size:177px}.fs-178{font-size:178px}.fs-179{font-size:179px}.fs-180{font-size:180px}.fs-181{font-size:181px}.fs-182{font-size:182px}.fs-183{font-size:183px}.fs-184{font-size:184px}.fs-185{font-size:185px}.fs-186{font-size:186px}.fs-187{font-size:187px}.fs-188{font-size:188px}.fs-189{font-size:189px}.fs-190{font-size:190px}.fs-191{font-size:191px}.fs-192{font-size:192px}.fs-193{font-size:193px}.fs-194{font-size:194px}.fs-195{font-size:195px}.fs-196{font-size:196px}.fs-197{font-size:197px}.fs-198{font-size:198px}.fs-199{font-size:199px}.fs-200{font-size:200px}.p-t-0{padding-top:0}.p-t-1{padding-top:1px}.p-t-2{padding-top:2px}.p-t-3{padding-top:3px}.p-t-4{padding-top:4px}.p-t-5{padding-top:5px}.p-t-6{padding-top:6px}.p-t-7{padding-top:7px}.p-t-8{padding-top:8px}.p-t-9{padding-top:9px}.p-t-10{padding-top:10px}.p-t-11{padding-top:11px}.p-t-12{padding-top:12px}.p-t-13{padding-top:13px}.p-t-14{padding-top:14px}.p-t-15{padding-top:15px}.p-t-16{padding-top:16px}.p-t-17{padding-top:17px}.p-t-18{padding-top:18px}.p-t-19{padding-top:19px}.p-t-20{padding-top:20px}.p-t-21{padding-top:21px}.p-t-22{padding-top:22px}.p-t-23{padding-top:23px}.p-t-24{padding-top:24px}.p-t-25{padding-top:25px}.p-t-26{padding-top:26px}.p-t-27{padding-top:27px}.p-t-28{padding-top:28px}.p-t-29{padding-top:29px}.p-t-30{padding-top:30px}.p-t-31{padding-top:31px}.p-t-32{padding-top:32px}.p-t-33{padding-top:33px}.p-t-34{padding-top:34px}.p-t-35{padding-top:35px}.p-t-36{padding-top:36px}.p-t-37{padding-top:37px}.p-t-38{padding-top:38px}.p-t-39{padding-top:39px}.p-t-40{padding-top:40px}.p-t-41{padding-top:41px}.p-t-42{padding-top:42px}.p-t-43{padding-top:43px}.p-t-44{padding-top:44px}.p-t-45{padding-top:45px}.p-t-46{padding-top:46px}.p-t-47{padding-top:47px}.p-t-48{padding-top:48px}.p-t-49{padding-top:49px}.p-t-50{padding-top:50px}.p-t-51{padding-top:51px}.p-t-52{padding-top:52px}.p-t-53{padding-top:53px}.p-t-54{padding-top:54px}.p-t-55{padding-top:55px}.p-t-56{padding-top:56px}.p-t-57{padding-top:57px}.p-t-58{padding-top:58px}.p-t-59{padding-top:59px}.p-t-60{padding-top:60px}.p-t-61{padding-top:61px}.p-t-62{padding-top:62px}.p-t-63{padding-top:63px}.p-t-64{padding-top:64px}.p-t-65{padding-top:65px}.p-t-66{padding-top:66px}.p-t-67{padding-top:67px}.p-t-68{padding-top:68px}.p-t-69{padding-top:69px}.p-t-70{padding-top:70px}.p-t-71{padding-top:71px}.p-t-72{padding-top:72px}.p-t-73{padding-top:73px}.p-t-74{padding-top:74px}.p-t-75{padding-top:75px}.p-t-76{padding-top:76px}.p-t-77{padding-top:77px}.p-t-78{padding-top:78px}.p-t-79{padding-top:79px}.p-t-80{padding-top:80px}.p-t-81{padding-top:81px}.p-t-82{padding-top:82px}.p-t-83{padding-top:83px}.p-t-84{padding-top:84px}.p-t-85{padding-top:85px}.p-t-86{padding-top:86px}.p-t-87{padding-top:87px}.p-t-88{padding-top:88px}.p-t-89{padding-top:89px}.p-t-90{padding-top:90px}.p-t-91{padding-top:91px}.p-t-92{padding-top:92px}.p-t-93{padding-top:93px}.p-t-94{padding-top:94px}.p-t-95{padding-top:95px}.p-t-96{padding-top:96px}.p-t-97{padding-top:97px}.p-t-98{padding-top:98px}.p-t-99{padding-top:99px}.p-t-100{padding-top:100px}.p-t-101{padding-top:101px}.p-t-102{padding-top:102px}.p-t-103{padding-top:103px}.p-t-104{padding-top:104px}.p-t-105{padding-top:105px}.p-t-106{padding-top:106px}.p-t-107{padding-top:107px}.p-t-108{padding-top:108px}.p-t-109{padding-top:109px}.p-t-110{padding-top:110px}.p-t-111{padding-top:111px}.p-t-112{padding-top:112px}.p-t-113{padding-top:113px}.p-t-114{padding-top:114px}.p-t-115{padding-top:115px}.p-t-116{padding-top:116px}.p-t-117{padding-top:117px}.p-t-118{padding-top:118px}.p-t-119{padding-top:119px}.p-t-120{padding-top:120px}.p-t-121{padding-top:121px}.p-t-122{padding-top:122px}.p-t-123{padding-top:123px}.p-t-124{padding-top:124px}.p-t-125{padding-top:125px}.p-t-126{padding-top:126px}.p-t-127{padding-top:127px}.p-t-128{padding-top:128px}.p-t-129{padding-top:129px}.p-t-130{padding-top:130px}.p-t-131{padding-top:131px}.p-t-132{padding-top:132px}.p-t-133{padding-top:133px}.p-t-134{padding-top:134px}.p-t-135{padding-top:135px}.p-t-136{padding-top:136px}.p-t-137{padding-top:137px}.p-t-138{padding-top:138px}.p-t-139{padding-top:139px}.p-t-140{padding-top:140px}.p-t-141{padding-top:141px}.p-t-142{padding-top:142px}.p-t-143{padding-top:143px}.p-t-144{padding-top:144px}.p-t-145{padding-top:145px}.p-t-146{padding-top:146px}.p-t-147{padding-top:147px}.p-t-148{padding-top:148px}.p-t-149{padding-top:149px}.p-t-150{padding-top:150px}.p-t-151{padding-top:151px}.p-t-152{padding-top:152px}.p-t-153{padding-top:153px}.p-t-154{padding-top:154px}.p-t-155{padding-top:155px}.p-t-156{padding-top:156px}.p-t-157{padding-top:157px}.p-t-158{padding-top:158px}.p-t-159{padding-top:159px}.p-t-160{padding-top:160px}.p-t-161{padding-top:161px}.p-t-162{padding-top:162px}.p-t-163{padding-top:163px}.p-t-164{padding-top:164px}.p-t-165{padding-top:165px}.p-t-166{padding-top:166px}.p-t-167{padding-top:167px}.p-t-168{padding-top:168px}.p-t-169{padding-top:169px}.p-t-170{padding-top:170px}.p-t-171{padding-top:171px}.p-t-172{padding-top:172px}.p-t-173{padding-top:173px}.p-t-174{padding-top:174px}.p-t-175{padding-top:175px}.p-t-176{padding-top:176px}.p-t-177{padding-top:177px}.p-t-178{padding-top:178px}.p-t-179{padding-top:179px}.p-t-180{padding-top:180px}.p-t-181{padding-top:181px}.p-t-182{padding-top:182px}.p-t-183{padding-top:183px}.p-t-184{padding-top:184px}.p-t-185{padding-top:185px}.p-t-186{padding-top:186px}.p-t-187{padding-top:187px}.p-t-188{padding-top:188px}.p-t-189{padding-top:189px}.p-t-190{padding-top:190px}.p-t-191{padding-top:191px}.p-t-192{padding-top:192px}.p-t-193{padding-top:193px}.p-t-194{padding-top:194px}.p-t-195{padding-top:195px}.p-t-196{padding-top:196px}.p-t-197{padding-top:197px}.p-t-198{padding-top:198px}.p-t-199{padding-top:199px}.p-t-200{padding-top:200px}.p-t-201{padding-top:201px}.p-t-202{padding-top:202px}.p-t-203{padding-top:203px}.p-t-204{padding-top:204px}.p-t-205{padding-top:205px}.p-t-206{padding-top:206px}.p-t-207{padding-top:207px}.p-t-208{padding-top:208px}.p-t-209{padding-top:209px}.p-t-210{padding-top:210px}.p-t-211{padding-top:211px}.p-t-212{padding-top:212px}.p-t-213{padding-top:213px}.p-t-214{padding-top:214px}.p-t-215{padding-top:215px}.p-t-216{padding-top:216px}.p-t-217{padding-top:217px}.p-t-218{padding-top:218px}.p-t-219{padding-top:219px}.p-t-220{padding-top:220px}.p-t-221{padding-top:221px}.p-t-222{padding-top:222px}.p-t-223{padding-top:223px}.p-t-224{padding-top:224px}.p-t-225{padding-top:225px}.p-t-226{padding-top:226px}.p-t-227{padding-top:227px}.p-t-228{padding-top:228px}.p-t-229{padding-top:229px}.p-t-230{padding-top:230px}.p-t-231{padding-top:231px}.p-t-232{padding-top:232px}.p-t-233{padding-top:233px}.p-t-234{padding-top:234px}.p-t-235{padding-top:235px}.p-t-236{padding-top:236px}.p-t-237{padding-top:237px}.p-t-238{padding-top:238px}.p-t-239{padding-top:239px}.p-t-240{padding-top:240px}.p-t-241{padding-top:241px}.p-t-242{padding-top:242px}.p-t-243{padding-top:243px}.p-t-244{padding-top:244px}.p-t-245{padding-top:245px}.p-t-246{padding-top:246px}.p-t-247{padding-top:247px}.p-t-248{padding-top:248px}.p-t-249{padding-top:249px}.p-t-250{padding-top:250px}.p-b-0{padding-bottom:0}.p-b-1{padding-bottom:1px}.p-b-2{padding-bottom:2px}.p-b-3{padding-bottom:3px}.p-b-4{padding-bottom:4px}.p-b-5{padding-bottom:5px}.p-b-6{padding-bottom:6px}.p-b-7{padding-bottom:7px}.p-b-8{padding-bottom:8px}.p-b-9{padding-bottom:9px}.p-b-10{padding-bottom:10px}.p-b-11{padding-bottom:11px}.p-b-12{padding-bottom:12px}.p-b-13{padding-bottom:13px}.p-b-14{padding-bottom:14px}.p-b-15{padding-bottom:15px}.p-b-16{padding-bottom:16px}.p-b-17{padding-bottom:17px}.p-b-18{padding-bottom:18px}.p-b-19{padding-bottom:19px}.p-b-20{padding-bottom:20px}.p-b-21{padding-bottom:21px}.p-b-22{padding-bottom:22px}.p-b-23{padding-bottom:23px}.p-b-24{padding-bottom:24px}.p-b-25{padding-bottom:25px}.p-b-26{padding-bottom:26px}.p-b-27{padding-bottom:27px}.p-b-28{padding-bottom:28px}.p-b-29{padding-bottom:29px}.p-b-30{padding-bottom:30px}.p-b-31{padding-bottom:31px}.p-b-32{padding-bottom:32px}.p-b-33{padding-bottom:33px}.p-b-34{padding-bottom:34px}.p-b-35{padding-bottom:35px}.p-b-36{padding-bottom:36px}.p-b-37{padding-bottom:37px}.p-b-38{padding-bottom:38px}.p-b-39{padding-bottom:39px}.p-b-40{padding-bottom:40px}.p-b-41{padding-bottom:41px}.p-b-42{padding-bottom:42px}.p-b-43{padding-bottom:43px}.p-b-44{padding-bottom:44px}.p-b-45{padding-bottom:45px}.p-b-46{padding-bottom:46px}.p-b-47{padding-bottom:47px}.p-b-48{padding-bottom:48px}.p-b-49{padding-bottom:49px}.p-b-50{padding-bottom:50px}.p-b-51{padding-bottom:51px}.p-b-52{padding-bottom:52px}.p-b-53{padding-bottom:53px}.p-b-54{padding-bottom:54px}.p-b-55{padding-bottom:55px}.p-b-56{padding-bottom:56px}.p-b-57{padding-bottom:57px}.p-b-58{padding-bottom:58px}.p-b-59{padding-bottom:59px}.p-b-60{padding-bottom:60px}.p-b-61{padding-bottom:61px}.p-b-62{padding-bottom:62px}.p-b-63{padding-bottom:63px}.p-b-64{padding-bottom:64px}.p-b-65{padding-bottom:65px}.p-b-66{padding-bottom:66px}.p-b-67{padding-bottom:67px}.p-b-68{padding-bottom:68px}.p-b-69{padding-bottom:69px}.p-b-70{padding-bottom:70px}.p-b-71{padding-bottom:71px}.p-b-72{padding-bottom:72px}.p-b-73{padding-bottom:73px}.p-b-74{padding-bottom:74px}.p-b-75{padding-bottom:75px}.p-b-76{padding-bottom:76px}.p-b-77{padding-bottom:77px}.p-b-78{padding-bottom:78px}.p-b-79{padding-bottom:79px}.p-b-80{padding-bottom:80px}.p-b-81{padding-bottom:81px}.p-b-82{padding-bottom:82px}.p-b-83{padding-bottom:83px}.p-b-84{padding-bottom:84px}.p-b-85{padding-bottom:85px}.p-b-86{padding-bottom:86px}.p-b-87{padding-bottom:87px}.p-b-88{padding-bottom:88px}.p-b-89{padding-bottom:89px}.p-b-90{padding-bottom:90px}.p-b-91{padding-bottom:91px}.p-b-92{padding-bottom:92px}.p-b-93{padding-bottom:93px}.p-b-94{padding-bottom:94px}.p-b-95{padding-bottom:95px}.p-b-96{padding-bottom:96px}.p-b-97{padding-bottom:97px}.p-b-98{padding-bottom:98px}.p-b-99{padding-bottom:99px}.p-b-100{padding-bottom:100px}.p-b-101{padding-bottom:101px}.p-b-102{padding-bottom:102px}.p-b-103{padding-bottom:103px}.p-b-104{padding-bottom:104px}.p-b-105{padding-bottom:105px}.p-b-106{padding-bottom:106px}.p-b-107{padding-bottom:107px}.p-b-108{padding-bottom:108px}.p-b-109{padding-bottom:109px}.p-b-110{padding-bottom:110px}.p-b-111{padding-bottom:111px}.p-b-112{padding-bottom:112px}.p-b-113{padding-bottom:113px}.p-b-114{padding-bottom:114px}.p-b-115{padding-bottom:115px}.p-b-116{padding-bottom:116px}.p-b-117{padding-bottom:117px}.p-b-118{padding-bottom:118px}.p-b-119{padding-bottom:119px}.p-b-120{padding-bottom:120px}.p-b-121{padding-bottom:121px}.p-b-122{padding-bottom:122px}.p-b-123{padding-bottom:123px}.p-b-124{padding-bottom:124px}.p-b-125{padding-bottom:125px}.p-b-126{padding-bottom:126px}.p-b-127{padding-bottom:127px}.p-b-128{padding-bottom:128px}.p-b-129{padding-bottom:129px}.p-b-130{padding-bottom:130px}.p-b-131{padding-bottom:131px}.p-b-132{padding-bottom:132px}.p-b-133{padding-bottom:133px}.p-b-134{padding-bottom:134px}.p-b-135{padding-bottom:135px}.p-b-136{padding-bottom:136px}.p-b-137{padding-bottom:137px}.p-b-138{padding-bottom:138px}.p-b-139{padding-bottom:139px}.p-b-140{padding-bottom:140px}.p-b-141{padding-bottom:141px}.p-b-142{padding-bottom:142px}.p-b-143{padding-bottom:143px}.p-b-144{padding-bottom:144px}.p-b-145{padding-bottom:145px}.p-b-146{padding-bottom:146px}.p-b-147{padding-bottom:147px}.p-b-148{padding-bottom:148px}.p-b-149{padding-bottom:149px}.p-b-150{padding-bottom:150px}.p-b-151{padding-bottom:151px}.p-b-152{padding-bottom:152px}.p-b-153{padding-bottom:153px}.p-b-154{padding-bottom:154px}.p-b-155{padding-bottom:155px}.p-b-156{padding-bottom:156px}.p-b-157{padding-bottom:157px}.p-b-158{padding-bottom:158px}.p-b-159{padding-bottom:159px}.p-b-160{padding-bottom:160px}.p-b-161{padding-bottom:161px}.p-b-162{padding-bottom:162px}.p-b-163{padding-bottom:163px}.p-b-164{padding-bottom:164px}.p-b-165{padding-bottom:165px}.p-b-166{padding-bottom:166px}.p-b-167{padding-bottom:167px}.p-b-168{padding-bottom:168px}.p-b-169{padding-bottom:169px}.p-b-170{padding-bottom:170px}.p-b-171{padding-bottom:171px}.p-b-172{padding-bottom:172px}.p-b-173{padding-bottom:173px}.p-b-174{padding-bottom:174px}.p-b-175{padding-bottom:175px}.p-b-176{padding-bottom:176px}.p-b-177{padding-bottom:177px}.p-b-178{padding-bottom:178px}.p-b-179{padding-bottom:179px}.p-b-180{padding-bottom:180px}.p-b-181{padding-bottom:181px}.p-b-182{padding-bottom:182px}.p-b-183{padding-bottom:183px}.p-b-184{padding-bottom:184px}.p-b-185{padding-bottom:185px}.p-b-186{padding-bottom:186px}.p-b-187{padding-bottom:187px}.p-b-188{padding-bottom:188px}.p-b-189{padding-bottom:189px}.p-b-190{padding-bottom:190px}.p-b-191{padding-bottom:191px}.p-b-192{padding-bottom:192px}.p-b-193{padding-bottom:193px}.p-b-194{padding-bottom:194px}.p-b-195{padding-bottom:195px}.p-b-196{padding-bottom:196px}.p-b-197{padding-bottom:197px}.p-b-198{padding-bottom:198px}.p-b-199{padding-bottom:199px}.p-b-200{padding-bottom:200px}.p-b-201{padding-bottom:201px}.p-b-202{padding-bottom:202px}.p-b-203{padding-bottom:203px}.p-b-204{padding-bottom:204px}.p-b-205{padding-bottom:205px}.p-b-206{padding-bottom:206px}.p-b-207{padding-bottom:207px}.p-b-208{padding-bottom:208px}.p-b-209{padding-bottom:209px}.p-b-210{padding-bottom:210px}.p-b-211{padding-bottom:211px}.p-b-212{padding-bottom:212px}.p-b-213{padding-bottom:213px}.p-b-214{padding-bottom:214px}.p-b-215{padding-bottom:215px}.p-b-216{padding-bottom:216px}.p-b-217{padding-bottom:217px}.p-b-218{padding-bottom:218px}.p-b-219{padding-bottom:219px}.p-b-220{padding-bottom:220px}.p-b-221{padding-bottom:221px}.p-b-222{padding-bottom:222px}.p-b-223{padding-bottom:223px}.p-b-224{padding-bottom:224px}.p-b-225{padding-bottom:225px}.p-b-226{padding-bottom:226px}.p-b-227{padding-bottom:227px}.p-b-228{padding-bottom:228px}.p-b-229{padding-bottom:229px}.p-b-230{padding-bottom:230px}.p-b-231{padding-bottom:231px}.p-b-232{padding-bottom:232px}.p-b-233{padding-bottom:233px}.p-b-234{padding-bottom:234px}.p-b-235{padding-bottom:235px}.p-b-236{padding-bottom:236px}.p-b-237{padding-bottom:237px}.p-b-238{padding-bottom:238px}.p-b-239{padding-bottom:239px}.p-b-240{padding-bottom:240px}.p-b-241{padding-bottom:241px}.p-b-242{padding-bottom:242px}.p-b-243{padding-bottom:243px}.p-b-244{padding-bottom:244px}.p-b-245{padding-bottom:245px}.p-b-246{padding-bottom:246px}.p-b-247{padding-bottom:247px}.p-b-248{padding-bottom:248px}.p-b-249{padding-bottom:249px}.p-b-250{padding-bottom:250px}.p-l-0{padding-left:0}.p-l-1{padding-left:1px}.p-l-2{padding-left:2px}.p-l-3{padding-left:3px}.p-l-4{padding-left:4px}.p-l-5{padding-left:5px}.p-l-6{padding-left:6px}.p-l-7{padding-left:7px}.p-l-8{padding-left:8px}.p-l-9{padding-left:9px}.p-l-10{padding-left:10px}.p-l-11{padding-left:11px}.p-l-12{padding-left:12px}.p-l-13{padding-left:13px}.p-l-14{padding-left:14px}.p-l-15{padding-left:15px}.p-l-16{padding-left:16px}.p-l-17{padding-left:17px}.p-l-18{padding-left:18px}.p-l-19{padding-left:19px}.p-l-20{padding-left:20px}.p-l-21{padding-left:21px}.p-l-22{padding-left:22px}.p-l-23{padding-left:23px}.p-l-24{padding-left:24px}.p-l-25{padding-left:25px}.p-l-26{padding-left:26px}.p-l-27{padding-left:27px}.p-l-28{padding-left:28px}.p-l-29{padding-left:29px}.p-l-30{padding-left:30px}.p-l-31{padding-left:31px}.p-l-32{padding-left:32px}.p-l-33{padding-left:33px}.p-l-34{padding-left:34px}.p-l-35{padding-left:35px}.p-l-36{padding-left:36px}.p-l-37{padding-left:37px}.p-l-38{padding-left:38px}.p-l-39{padding-left:39px}.p-l-40{padding-left:40px}.p-l-41{padding-left:41px}.p-l-42{padding-left:42px}.p-l-43{padding-left:43px}.p-l-44{padding-left:44px}.p-l-45{padding-left:45px}.p-l-46{padding-left:46px}.p-l-47{padding-left:47px}.p-l-48{padding-left:48px}.p-l-49{padding-left:49px}.p-l-50{padding-left:50px}.p-l-51{padding-left:51px}.p-l-52{padding-left:52px}.p-l-53{padding-left:53px}.p-l-54{padding-left:54px}.p-l-55{padding-left:55px}.p-l-56{padding-left:56px}.p-l-57{padding-left:57px}.p-l-58{padding-left:58px}.p-l-59{padding-left:59px}.p-l-60{padding-left:60px}.p-l-61{padding-left:61px}.p-l-62{padding-left:62px}.p-l-63{padding-left:63px}.p-l-64{padding-left:64px}.p-l-65{padding-left:65px}.p-l-66{padding-left:66px}.p-l-67{padding-left:67px}.p-l-68{padding-left:68px}.p-l-69{padding-left:69px}.p-l-70{padding-left:70px}.p-l-71{padding-left:71px}.p-l-72{padding-left:72px}.p-l-73{padding-left:73px}.p-l-74{padding-left:74px}.p-l-75{padding-left:75px}.p-l-76{padding-left:76px}.p-l-77{padding-left:77px}.p-l-78{padding-left:78px}.p-l-79{padding-left:79px}.p-l-80{padding-left:80px}.p-l-81{padding-left:81px}.p-l-82{padding-left:82px}.p-l-83{padding-left:83px}.p-l-84{padding-left:84px}.p-l-85{padding-left:85px}.p-l-86{padding-left:86px}.p-l-87{padding-left:87px}.p-l-88{padding-left:88px}.p-l-89{padding-left:89px}.p-l-90{padding-left:90px}.p-l-91{padding-left:91px}.p-l-92{padding-left:92px}.p-l-93{padding-left:93px}.p-l-94{padding-left:94px}.p-l-95{padding-left:95px}.p-l-96{padding-left:96px}.p-l-97{padding-left:97px}.p-l-98{padding-left:98px}.p-l-99{padding-left:99px}.p-l-100{padding-left:100px}.p-l-101{padding-left:101px}.p-l-102{padding-left:102px}.p-l-103{padding-left:103px}.p-l-104{padding-left:104px}.p-l-105{padding-left:105px}.p-l-106{padding-left:106px}.p-l-107{padding-left:107px}.p-l-108{padding-left:108px}.p-l-109{padding-left:109px}.p-l-110{padding-left:110px}.p-l-111{padding-left:111px}.p-l-112{padding-left:112px}.p-l-113{padding-left:113px}.p-l-114{padding-left:114px}.p-l-115{padding-left:115px}.p-l-116{padding-left:116px}.p-l-117{padding-left:117px}.p-l-118{padding-left:118px}.p-l-119{padding-left:119px}.p-l-120{padding-left:120px}.p-l-121{padding-left:121px}.p-l-122{padding-left:122px}.p-l-123{padding-left:123px}.p-l-124{padding-left:124px}.p-l-125{padding-left:125px}.p-l-126{padding-left:126px}.p-l-127{padding-left:127px}.p-l-128{padding-left:128px}.p-l-129{padding-left:129px}.p-l-130{padding-left:130px}.p-l-131{padding-left:131px}.p-l-132{padding-left:132px}.p-l-133{padding-left:133px}.p-l-134{padding-left:134px}.p-l-135{padding-left:135px}.p-l-136{padding-left:136px}.p-l-137{padding-left:137px}.p-l-138{padding-left:138px}.p-l-139{padding-left:139px}.p-l-140{padding-left:140px}.p-l-141{padding-left:141px}.p-l-142{padding-left:142px}.p-l-143{padding-left:143px}.p-l-144{padding-left:144px}.p-l-145{padding-left:145px}.p-l-146{padding-left:146px}.p-l-147{padding-left:147px}.p-l-148{padding-left:148px}.p-l-149{padding-left:149px}.p-l-150{padding-left:150px}.p-l-151{padding-left:151px}.p-l-152{padding-left:152px}.p-l-153{padding-left:153px}.p-l-154{padding-left:154px}.p-l-155{padding-left:155px}.p-l-156{padding-left:156px}.p-l-157{padding-left:157px}.p-l-158{padding-left:158px}.p-l-159{padding-left:159px}.p-l-160{padding-left:160px}.p-l-161{padding-left:161px}.p-l-162{padding-left:162px}.p-l-163{padding-left:163px}.p-l-164{padding-left:164px}.p-l-165{padding-left:165px}.p-l-166{padding-left:166px}.p-l-167{padding-left:167px}.p-l-168{padding-left:168px}.p-l-169{padding-left:169px}.p-l-170{padding-left:170px}.p-l-171{padding-left:171px}.p-l-172{padding-left:172px}.p-l-173{padding-left:173px}.p-l-174{padding-left:174px}.p-l-175{padding-left:175px}.p-l-176{padding-left:176px}.p-l-177{padding-left:177px}.p-l-178{padding-left:178px}.p-l-179{padding-left:179px}.p-l-180{padding-left:180px}.p-l-181{padding-left:181px}.p-l-182{padding-left:182px}.p-l-183{padding-left:183px}.p-l-184{padding-left:184px}.p-l-185{padding-left:185px}.p-l-186{padding-left:186px}.p-l-187{padding-left:187px}.p-l-188{padding-left:188px}.p-l-189{padding-left:189px}.p-l-190{padding-left:190px}.p-l-191{padding-left:191px}.p-l-192{padding-left:192px}.p-l-193{padding-left:193px}.p-l-194{padding-left:194px}.p-l-195{padding-left:195px}.p-l-196{padding-left:196px}.p-l-197{padding-left:197px}.p-l-198{padding-left:198px}.p-l-199{padding-left:199px}.p-l-200{padding-left:200px}.p-l-201{padding-left:201px}.p-l-202{padding-left:202px}.p-l-203{padding-left:203px}.p-l-204{padding-left:204px}.p-l-205{padding-left:205px}.p-l-206{padding-left:206px}.p-l-207{padding-left:207px}.p-l-208{padding-left:208px}.p-l-209{padding-left:209px}.p-l-210{padding-left:210px}.p-l-211{padding-left:211px}.p-l-212{padding-left:212px}.p-l-213{padding-left:213px}.p-l-214{padding-left:214px}.p-l-215{padding-left:215px}.p-l-216{padding-left:216px}.p-l-217{padding-left:217px}.p-l-218{padding-left:218px}.p-l-219{padding-left:219px}.p-l-220{padding-left:220px}.p-l-221{padding-left:221px}.p-l-222{padding-left:222px}.p-l-223{padding-left:223px}.p-l-224{padding-left:224px}.p-l-225{padding-left:225px}.p-l-226{padding-left:226px}.p-l-227{padding-left:227px}.p-l-228{padding-left:228px}.p-l-229{padding-left:229px}.p-l-230{padding-left:230px}.p-l-231{padding-left:231px}.p-l-232{padding-left:232px}.p-l-233{padding-left:233px}.p-l-234{padding-left:234px}.p-l-235{padding-left:235px}.p-l-236{padding-left:236px}.p-l-237{padding-left:237px}.p-l-238{padding-left:238px}.p-l-239{padding-left:239px}.p-l-240{padding-left:240px}.p-l-241{padding-left:241px}.p-l-242{padding-left:242px}.p-l-243{padding-left:243px}.p-l-244{padding-left:244px}.p-l-245{padding-left:245px}.p-l-246{padding-left:246px}.p-l-247{padding-left:247px}.p-l-248{padding-left:248px}.p-l-249{padding-left:249px}.p-l-250{padding-left:250px}.p-r-0{padding-right:0}.p-r-1{padding-right:1px}.p-r-2{padding-right:2px}.p-r-3{padding-right:3px}.p-r-4{padding-right:4px}.p-r-5{padding-right:5px}.p-r-6{padding-right:6px}.p-r-7{padding-right:7px}.p-r-8{padding-right:8px}.p-r-9{padding-right:9px}.p-r-10{padding-right:10px}.p-r-11{padding-right:11px}.p-r-12{padding-right:12px}.p-r-13{padding-right:13px}.p-r-14{padding-right:14px}.p-r-15{padding-right:15px}.p-r-16{padding-right:16px}.p-r-17{padding-right:17px}.p-r-18{padding-right:18px}.p-r-19{padding-right:19px}.p-r-20{padding-right:20px}.p-r-21{padding-right:21px}.p-r-22{padding-right:22px}.p-r-23{padding-right:23px}.p-r-24{padding-right:24px}.p-r-25{padding-right:25px}.p-r-26{padding-right:26px}.p-r-27{padding-right:27px}.p-r-28{padding-right:28px}.p-r-29{padding-right:29px}.p-r-30{padding-right:30px}.p-r-31{padding-right:31px}.p-r-32{padding-right:32px}.p-r-33{padding-right:33px}.p-r-34{padding-right:34px}.p-r-35{padding-right:35px}.p-r-36{padding-right:36px}.p-r-37{padding-right:37px}.p-r-38{padding-right:38px}.p-r-39{padding-right:39px}.p-r-40{padding-right:40px}.p-r-41{padding-right:41px}.p-r-42{padding-right:42px}.p-r-43{padding-right:43px}.p-r-44{padding-right:44px}.p-r-45{padding-right:45px}.p-r-46{padding-right:46px}.p-r-47{padding-right:47px}.p-r-48{padding-right:48px}.p-r-49{padding-right:49px}.p-r-50{padding-right:50px}.p-r-51{padding-right:51px}.p-r-52{padding-right:52px}.p-r-53{padding-right:53px}.p-r-54{padding-right:54px}.p-r-55{padding-right:55px}.p-r-56{padding-right:56px}.p-r-57{padding-right:57px}.p-r-58{padding-right:58px}.p-r-59{padding-right:59px}.p-r-60{padding-right:60px}.p-r-61{padding-right:61px}.p-r-62{padding-right:62px}.p-r-63{padding-right:63px}.p-r-64{padding-right:64px}.p-r-65{padding-right:65px}.p-r-66{padding-right:66px}.p-r-67{padding-right:67px}.p-r-68{padding-right:68px}.p-r-69{padding-right:69px}.p-r-70{padding-right:70px}.p-r-71{padding-right:71px}.p-r-72{padding-right:72px}.p-r-73{padding-right:73px}.p-r-74{padding-right:74px}.p-r-75{padding-right:75px}.p-r-76{padding-right:76px}.p-r-77{padding-right:77px}.p-r-78{padding-right:78px}.p-r-79{padding-right:79px}.p-r-80{padding-right:80px}.p-r-81{padding-right:81px}.p-r-82{padding-right:82px}.p-r-83{padding-right:83px}.p-r-84{padding-right:84px}.p-r-85{padding-right:85px}.p-r-86{padding-right:86px}.p-r-87{padding-right:87px}.p-r-88{padding-right:88px}.p-r-89{padding-right:89px}.p-r-90{padding-right:90px}.p-r-91{padding-right:91px}.p-r-92{padding-right:92px}.p-r-93{padding-right:93px}.p-r-94{padding-right:94px}.p-r-95{padding-right:95px}.p-r-96{padding-right:96px}.p-r-97{padding-right:97px}.p-r-98{padding-right:98px}.p-r-99{padding-right:99px}.p-r-100{padding-right:100px}.p-r-101{padding-right:101px}.p-r-102{padding-right:102px}.p-r-103{padding-right:103px}.p-r-104{padding-right:104px}.p-r-105{padding-right:105px}.p-r-106{padding-right:106px}.p-r-107{padding-right:107px}.p-r-108{padding-right:108px}.p-r-109{padding-right:109px}.p-r-110{padding-right:110px}.p-r-111{padding-right:111px}.p-r-112{padding-right:112px}.p-r-113{padding-right:113px}.p-r-114{padding-right:114px}.p-r-115{padding-right:115px}.p-r-116{padding-right:116px}.p-r-117{padding-right:117px}.p-r-118{padding-right:118px}.p-r-119{padding-right:119px}.p-r-120{padding-right:120px}.p-r-121{padding-right:121px}.p-r-122{padding-right:122px}.p-r-123{padding-right:123px}.p-r-124{padding-right:124px}.p-r-125{padding-right:125px}.p-r-126{padding-right:126px}.p-r-127{padding-right:127px}.p-r-128{padding-right:128px}.p-r-129{padding-right:129px}.p-r-130{padding-right:130px}.p-r-131{padding-right:131px}.p-r-132{padding-right:132px}.p-r-133{padding-right:133px}.p-r-134{padding-right:134px}.p-r-135{padding-right:135px}.p-r-136{padding-right:136px}.p-r-137{padding-right:137px}.p-r-138{padding-right:138px}.p-r-139{padding-right:139px}.p-r-140{padding-right:140px}.p-r-141{padding-right:141px}.p-r-142{padding-right:142px}.p-r-143{padding-right:143px}.p-r-144{padding-right:144px}.p-r-145{padding-right:145px}.p-r-146{padding-right:146px}.p-r-147{padding-right:147px}.p-r-148{padding-right:148px}.p-r-149{padding-right:149px}.p-r-150{padding-right:150px}.p-r-151{padding-right:151px}.p-r-152{padding-right:152px}.p-r-153{padding-right:153px}.p-r-154{padding-right:154px}.p-r-155{padding-right:155px}.p-r-156{padding-right:156px}.p-r-157{padding-right:157px}.p-r-158{padding-right:158px}.p-r-159{padding-right:159px}.p-r-160{padding-right:160px}.p-r-161{padding-right:161px}.p-r-162{padding-right:162px}.p-r-163{padding-right:163px}.p-r-164{padding-right:164px}.p-r-165{padding-right:165px}.p-r-166{padding-right:166px}.p-r-167{padding-right:167px}.p-r-168{padding-right:168px}.p-r-169{padding-right:169px}.p-r-170{padding-right:170px}.p-r-171{padding-right:171px}.p-r-172{padding-right:172px}.p-r-173{padding-right:173px}.p-r-174{padding-right:174px}.p-r-175{padding-right:175px}.p-r-176{padding-right:176px}.p-r-177{padding-right:177px}.p-r-178{padding-right:178px}.p-r-179{padding-right:179px}.p-r-180{padding-right:180px}.p-r-181{padding-right:181px}.p-r-182{padding-right:182px}.p-r-183{padding-right:183px}.p-r-184{padding-right:184px}.p-r-185{padding-right:185px}.p-r-186{padding-right:186px}.p-r-187{padding-right:187px}.p-r-188{padding-right:188px}.p-r-189{padding-right:189px}.p-r-190{padding-right:190px}.p-r-191{padding-right:191px}.p-r-192{padding-right:192px}.p-r-193{padding-right:193px}.p-r-194{padding-right:194px}.p-r-195{padding-right:195px}.p-r-196{padding-right:196px}.p-r-197{padding-right:197px}.p-r-198{padding-right:198px}.p-r-199{padding-right:199px}.p-r-200{padding-right:200px}.p-r-201{padding-right:201px}.p-r-202{padding-right:202px}.p-r-203{padding-right:203px}.p-r-204{padding-right:204px}.p-r-205{padding-right:205px}.p-r-206{padding-right:206px}.p-r-207{padding-right:207px}.p-r-208{padding-right:208px}.p-r-209{padding-right:209px}.p-r-210{padding-right:210px}.p-r-211{padding-right:211px}.p-r-212{padding-right:212px}.p-r-213{padding-right:213px}.p-r-214{padding-right:214px}.p-r-215{padding-right:215px}.p-r-216{padding-right:216px}.p-r-217{padding-right:217px}.p-r-218{padding-right:218px}.p-r-219{padding-right:219px}.p-r-220{padding-right:220px}.p-r-221{padding-right:221px}.p-r-222{padding-right:222px}.p-r-223{padding-right:223px}.p-r-224{padding-right:224px}.p-r-225{padding-right:225px}.p-r-226{padding-right:226px}.p-r-227{padding-right:227px}.p-r-228{padding-right:228px}.p-r-229{padding-right:229px}.p-r-230{padding-right:230px}.p-r-231{padding-right:231px}.p-r-232{padding-right:232px}.p-r-233{padding-right:233px}.p-r-234{padding-right:234px}.p-r-235{padding-right:235px}.p-r-236{padding-right:236px}.p-r-237{padding-right:237px}.p-r-238{padding-right:238px}.p-r-239{padding-right:239px}.p-r-240{padding-right:240px}.p-r-241{padding-right:241px}.p-r-242{padding-right:242px}.p-r-243{padding-right:243px}.p-r-244{padding-right:244px}.p-r-245{padding-right:245px}.p-r-246{padding-right:246px}.p-r-247{padding-right:247px}.p-r-248{padding-right:248px}.p-r-249{padding-right:249px}.p-r-250{padding-right:250px}.m-t-0{margin-top:0}.m-t-1{margin-top:1px}.m-t-2{margin-top:2px}.m-t-3{margin-top:3px}.m-t-4{margin-top:4px}.m-t-5{margin-top:5px}.m-t-6{margin-top:6px}.m-t-7{margin-top:7px}.m-t-8{margin-top:8px}.m-t-9{margin-top:9px}.m-t-10{margin-top:10px}.m-t-11{margin-top:11px}.m-t-12{margin-top:12px}.m-t-13{margin-top:13px}.m-t-14{margin-top:14px}.m-t-15{margin-top:15px}.m-t-16{margin-top:16px}.m-t-17{margin-top:17px}.m-t-18{margin-top:18px}.m-t-19{margin-top:19px}.m-t-20{margin-top:20px}.m-t-21{margin-top:21px}.m-t-22{margin-top:22px}.m-t-23{margin-top:23px}.m-t-24{margin-top:24px}.m-t-25{margin-top:25px}.m-t-26{margin-top:26px}.m-t-27{margin-top:27px}.m-t-28{margin-top:28px}.m-t-29{margin-top:29px}.m-t-30{margin-top:30px}.m-t-31{margin-top:31px}.m-t-32{margin-top:32px}.m-t-33{margin-top:33px}.m-t-34{margin-top:34px}.m-t-35{margin-top:35px}.m-t-36{margin-top:36px}.m-t-37{margin-top:37px}.m-t-38{margin-top:38px}.m-t-39{margin-top:39px}.m-t-40{margin-top:40px}.m-t-41{margin-top:41px}.m-t-42{margin-top:42px}.m-t-43{margin-top:43px}.m-t-44{margin-top:44px}.m-t-45{margin-top:45px}.m-t-46{margin-top:46px}.m-t-47{margin-top:47px}.m-t-48{margin-top:48px}.m-t-49{margin-top:49px}.m-t-50{margin-top:50px}.m-t-51{margin-top:51px}.m-t-52{margin-top:52px}.m-t-53{margin-top:53px}.m-t-54{margin-top:54px}.m-t-55{margin-top:55px}.m-t-56{margin-top:56px}.m-t-57{margin-top:57px}.m-t-58{margin-top:58px}.m-t-59{margin-top:59px}.m-t-60{margin-top:60px}.m-t-61{margin-top:61px}.m-t-62{margin-top:62px}.m-t-63{margin-top:63px}.m-t-64{margin-top:64px}.m-t-65{margin-top:65px}.m-t-66{margin-top:66px}.m-t-67{margin-top:67px}.m-t-68{margin-top:68px}.m-t-69{margin-top:69px}.m-t-70{margin-top:70px}.m-t-71{margin-top:71px}.m-t-72{margin-top:72px}.m-t-73{margin-top:73px}.m-t-74{margin-top:74px}.m-t-75{margin-top:75px}.m-t-76{margin-top:76px}.m-t-77{margin-top:77px}.m-t-78{margin-top:78px}.m-t-79{margin-top:79px}.m-t-80{margin-top:80px}.m-t-81{margin-top:81px}.m-t-82{margin-top:82px}.m-t-83{margin-top:83px}.m-t-84{margin-top:84px}.m-t-85{margin-top:85px}.m-t-86{margin-top:86px}.m-t-87{margin-top:87px}.m-t-88{margin-top:88px}.m-t-89{margin-top:89px}.m-t-90{margin-top:90px}.m-t-91{margin-top:91px}.m-t-92{margin-top:92px}.m-t-93{margin-top:93px}.m-t-94{margin-top:94px}.m-t-95{margin-top:95px}.m-t-96{margin-top:96px}.m-t-97{margin-top:97px}.m-t-98{margin-top:98px}.m-t-99{margin-top:99px}.m-t-100{margin-top:100px}.m-t-101{margin-top:101px}.m-t-102{margin-top:102px}.m-t-103{margin-top:103px}.m-t-104{margin-top:104px}.m-t-105{margin-top:105px}.m-t-106{margin-top:106px}.m-t-107{margin-top:107px}.m-t-108{margin-top:108px}.m-t-109{margin-top:109px}.m-t-110{margin-top:110px}.m-t-111{margin-top:111px}.m-t-112{margin-top:112px}.m-t-113{margin-top:113px}.m-t-114{margin-top:114px}.m-t-115{margin-top:115px}.m-t-116{margin-top:116px}.m-t-117{margin-top:117px}.m-t-118{margin-top:118px}.m-t-119{margin-top:119px}.m-t-120{margin-top:120px}.m-t-121{margin-top:121px}.m-t-122{margin-top:122px}.m-t-123{margin-top:123px}.m-t-124{margin-top:124px}.m-t-125{margin-top:125px}.m-t-126{margin-top:126px}.m-t-127{margin-top:127px}.m-t-128{margin-top:128px}.m-t-129{margin-top:129px}.m-t-130{margin-top:130px}.m-t-131{margin-top:131px}.m-t-132{margin-top:132px}.m-t-133{margin-top:133px}.m-t-134{margin-top:134px}.m-t-135{margin-top:135px}.m-t-136{margin-top:136px}.m-t-137{margin-top:137px}.m-t-138{margin-top:138px}.m-t-139{margin-top:139px}.m-t-140{margin-top:140px}.m-t-141{margin-top:141px}.m-t-142{margin-top:142px}.m-t-143{margin-top:143px}.m-t-144{margin-top:144px}.m-t-145{margin-top:145px}.m-t-146{margin-top:146px}.m-t-147{margin-top:147px}.m-t-148{margin-top:148px}.m-t-149{margin-top:149px}.m-t-150{margin-top:150px}.m-t-151{margin-top:151px}.m-t-152{margin-top:152px}.m-t-153{margin-top:153px}.m-t-154{margin-top:154px}.m-t-155{margin-top:155px}.m-t-156{margin-top:156px}.m-t-157{margin-top:157px}.m-t-158{margin-top:158px}.m-t-159{margin-top:159px}.m-t-160{margin-top:160px}.m-t-161{margin-top:161px}.m-t-162{margin-top:162px}.m-t-163{margin-top:163px}.m-t-164{margin-top:164px}.m-t-165{margin-top:165px}.m-t-166{margin-top:166px}.m-t-167{margin-top:167px}.m-t-168{margin-top:168px}.m-t-169{margin-top:169px}.m-t-170{margin-top:170px}.m-t-171{margin-top:171px}.m-t-172{margin-top:172px}.m-t-173{margin-top:173px}.m-t-174{margin-top:174px}.m-t-175{margin-top:175px}.m-t-176{margin-top:176px}.m-t-177{margin-top:177px}.m-t-178{margin-top:178px}.m-t-179{margin-top:179px}.m-t-180{margin-top:180px}.m-t-181{margin-top:181px}.m-t-182{margin-top:182px}.m-t-183{margin-top:183px}.m-t-184{margin-top:184px}.m-t-185{margin-top:185px}.m-t-186{margin-top:186px}.m-t-187{margin-top:187px}.m-t-188{margin-top:188px}.m-t-189{margin-top:189px}.m-t-190{margin-top:190px}.m-t-191{margin-top:191px}.m-t-192{margin-top:192px}.m-t-193{margin-top:193px}.m-t-194{margin-top:194px}.m-t-195{margin-top:195px}.m-t-196{margin-top:196px}.m-t-197{margin-top:197px}.m-t-198{margin-top:198px}.m-t-199{margin-top:199px}.m-t-200{margin-top:200px}.m-t-201{margin-top:201px}.m-t-202{margin-top:202px}.m-t-203{margin-top:203px}.m-t-204{margin-top:204px}.m-t-205{margin-top:205px}.m-t-206{margin-top:206px}.m-t-207{margin-top:207px}.m-t-208{margin-top:208px}.m-t-209{margin-top:209px}.m-t-210{margin-top:210px}.m-t-211{margin-top:211px}.m-t-212{margin-top:212px}.m-t-213{margin-top:213px}.m-t-214{margin-top:214px}.m-t-215{margin-top:215px}.m-t-216{margin-top:216px}.m-t-217{margin-top:217px}.m-t-218{margin-top:218px}.m-t-219{margin-top:219px}.m-t-220{margin-top:220px}.m-t-221{margin-top:221px}.m-t-222{margin-top:222px}.m-t-223{margin-top:223px}.m-t-224{margin-top:224px}.m-t-225{margin-top:225px}.m-t-226{margin-top:226px}.m-t-227{margin-top:227px}.m-t-228{margin-top:228px}.m-t-229{margin-top:229px}.m-t-230{margin-top:230px}.m-t-231{margin-top:231px}.m-t-232{margin-top:232px}.m-t-233{margin-top:233px}.m-t-234{margin-top:234px}.m-t-235{margin-top:235px}.m-t-236{margin-top:236px}.m-t-237{margin-top:237px}.m-t-238{margin-top:238px}.m-t-239{margin-top:239px}.m-t-240{margin-top:240px}.m-t-241{margin-top:241px}.m-t-242{margin-top:242px}.m-t-243{margin-top:243px}.m-t-244{margin-top:244px}.m-t-245{margin-top:245px}.m-t-246{margin-top:246px}.m-t-247{margin-top:247px}.m-t-248{margin-top:248px}.m-t-249{margin-top:249px}.m-t-250{margin-top:250px}.m-b-0{margin-bottom:0}.m-b-1{margin-bottom:1px}.m-b-2{margin-bottom:2px}.m-b-3{margin-bottom:3px}.m-b-4{margin-bottom:4px}.m-b-5{margin-bottom:5px}.m-b-6{margin-bottom:6px}.m-b-7{margin-bottom:7px}.m-b-8{margin-bottom:8px}.m-b-9{margin-bottom:9px}.m-b-10{margin-bottom:10px}.m-b-11{margin-bottom:11px}.m-b-12{margin-bottom:12px}.m-b-13{margin-bottom:13px}.m-b-14{margin-bottom:14px}.m-b-15{margin-bottom:15px}.m-b-16{margin-bottom:16px}.m-b-17{margin-bottom:17px}.m-b-18{margin-bottom:18px}.m-b-19{margin-bottom:19px}.m-b-20{margin-bottom:20px}.m-b-21{margin-bottom:21px}.m-b-22{margin-bottom:22px}.m-b-23{margin-bottom:23px}.m-b-24{margin-bottom:24px}.m-b-25{margin-bottom:25px}.m-b-26{margin-bottom:26px}.m-b-27{margin-bottom:27px}.m-b-28{margin-bottom:28px}.m-b-29{margin-bottom:29px}.m-b-30{margin-bottom:30px}.m-b-31{margin-bottom:31px}.m-b-32{margin-bottom:32px}.m-b-33{margin-bottom:33px}.m-b-34{margin-bottom:34px}.m-b-35{margin-bottom:35px}.m-b-36{margin-bottom:36px}.m-b-37{margin-bottom:37px}.m-b-38{margin-bottom:38px}.m-b-39{margin-bottom:39px}.m-b-40{margin-bottom:40px}.m-b-41{margin-bottom:41px}.m-b-42{margin-bottom:42px}.m-b-43{margin-bottom:43px}.m-b-44{margin-bottom:44px}.m-b-45{margin-bottom:45px}.m-b-46{margin-bottom:46px}.m-b-47{margin-bottom:47px}.m-b-48{margin-bottom:48px}.m-b-49{margin-bottom:49px}.m-b-50{margin-bottom:50px}.m-b-51{margin-bottom:51px}.m-b-52{margin-bottom:52px}.m-b-53{margin-bottom:53px}.m-b-54{margin-bottom:54px}.m-b-55{margin-bottom:55px}.m-b-56{margin-bottom:56px}.m-b-57{margin-bottom:57px}.m-b-58{margin-bottom:58px}.m-b-59{margin-bottom:59px}.m-b-60{margin-bottom:60px}.m-b-61{margin-bottom:61px}.m-b-62{margin-bottom:62px}.m-b-63{margin-bottom:63px}.m-b-64{margin-bottom:64px}.m-b-65{margin-bottom:65px}.m-b-66{margin-bottom:66px}.m-b-67{margin-bottom:67px}.m-b-68{margin-bottom:68px}.m-b-69{margin-bottom:69px}.m-b-70{margin-bottom:70px}.m-b-71{margin-bottom:71px}.m-b-72{margin-bottom:72px}.m-b-73{margin-bottom:73px}.m-b-74{margin-bottom:74px}.m-b-75{margin-bottom:75px}.m-b-76{margin-bottom:76px}.m-b-77{margin-bottom:77px}.m-b-78{margin-bottom:78px}.m-b-79{margin-bottom:79px}.m-b-80{margin-bottom:80px}.m-b-81{margin-bottom:81px}.m-b-82{margin-bottom:82px}.m-b-83{margin-bottom:83px}.m-b-84{margin-bottom:84px}.m-b-85{margin-bottom:85px}.m-b-86{margin-bottom:86px}.m-b-87{margin-bottom:87px}.m-b-88{margin-bottom:88px}.m-b-89{margin-bottom:89px}.m-b-90{margin-bottom:90px}.m-b-91{margin-bottom:91px}.m-b-92{margin-bottom:92px}.m-b-93{margin-bottom:93px}.m-b-94{margin-bottom:94px}.m-b-95{margin-bottom:95px}.m-b-96{margin-bottom:96px}.m-b-97{margin-bottom:97px}.m-b-98{margin-bottom:98px}.m-b-99{margin-bottom:99px}.m-b-100{margin-bottom:100px}.m-b-101{margin-bottom:101px}.m-b-102{margin-bottom:102px}.m-b-103{margin-bottom:103px}.m-b-104{margin-bottom:104px}.m-b-105{margin-bottom:105px}.m-b-106{margin-bottom:106px}.m-b-107{margin-bottom:107px}.m-b-108{margin-bottom:108px}.m-b-109{margin-bottom:109px}.m-b-110{margin-bottom:110px}.m-b-111{margin-bottom:111px}.m-b-112{margin-bottom:112px}.m-b-113{margin-bottom:113px}.m-b-114{margin-bottom:114px}.m-b-115{margin-bottom:115px}.m-b-116{margin-bottom:116px}.m-b-117{margin-bottom:117px}.m-b-118{margin-bottom:118px}.m-b-119{margin-bottom:119px}.m-b-120{margin-bottom:120px}.m-b-121{margin-bottom:121px}.m-b-122{margin-bottom:122px}.m-b-123{margin-bottom:123px}.m-b-124{margin-bottom:124px}.m-b-125{margin-bottom:125px}.m-b-126{margin-bottom:126px}.m-b-127{margin-bottom:127px}.m-b-128{margin-bottom:128px}.m-b-129{margin-bottom:129px}.m-b-130{margin-bottom:130px}.m-b-131{margin-bottom:131px}.m-b-132{margin-bottom:132px}.m-b-133{margin-bottom:133px}.m-b-134{margin-bottom:134px}.m-b-135{margin-bottom:135px}.m-b-136{margin-bottom:136px}.m-b-137{margin-bottom:137px}.m-b-138{margin-bottom:138px}.m-b-139{margin-bottom:139px}.m-b-140{margin-bottom:140px}.m-b-141{margin-bottom:141px}.m-b-142{margin-bottom:142px}.m-b-143{margin-bottom:143px}.m-b-144{margin-bottom:144px}.m-b-145{margin-bottom:145px}.m-b-146{margin-bottom:146px}.m-b-147{margin-bottom:147px}.m-b-148{margin-bottom:148px}.m-b-149{margin-bottom:149px}.m-b-150{margin-bottom:150px}.m-b-151{margin-bottom:151px}.m-b-152{margin-bottom:152px}.m-b-153{margin-bottom:153px}.m-b-154{margin-bottom:154px}.m-b-155{margin-bottom:155px}.m-b-156{margin-bottom:156px}.m-b-157{margin-bottom:157px}.m-b-158{margin-bottom:158px}.m-b-159{margin-bottom:159px}.m-b-160{margin-bottom:160px}.m-b-161{margin-bottom:161px}.m-b-162{margin-bottom:162px}.m-b-163{margin-bottom:163px}.m-b-164{margin-bottom:164px}.m-b-165{margin-bottom:165px}.m-b-166{margin-bottom:166px}.m-b-167{margin-bottom:167px}.m-b-168{margin-bottom:168px}.m-b-169{margin-bottom:169px}.m-b-170{margin-bottom:170px}.m-b-171{margin-bottom:171px}.m-b-172{margin-bottom:172px}.m-b-173{margin-bottom:173px}.m-b-174{margin-bottom:174px}.m-b-175{margin-bottom:175px}.m-b-176{margin-bottom:176px}.m-b-177{margin-bottom:177px}.m-b-178{margin-bottom:178px}.m-b-179{margin-bottom:179px}.m-b-180{margin-bottom:180px}.m-b-181{margin-bottom:181px}.m-b-182{margin-bottom:182px}.m-b-183{margin-bottom:183px}.m-b-184{margin-bottom:184px}.m-b-185{margin-bottom:185px}.m-b-186{margin-bottom:186px}.m-b-187{margin-bottom:187px}.m-b-188{margin-bottom:188px}.m-b-189{margin-bottom:189px}.m-b-190{margin-bottom:190px}.m-b-191{margin-bottom:191px}.m-b-192{margin-bottom:192px}.m-b-193{margin-bottom:193px}.m-b-194{margin-bottom:194px}.m-b-195{margin-bottom:195px}.m-b-196{margin-bottom:196px}.m-b-197{margin-bottom:197px}.m-b-198{margin-bottom:198px}.m-b-199{margin-bottom:199px}.m-b-200{margin-bottom:200px}.m-b-201{margin-bottom:201px}.m-b-202{margin-bottom:202px}.m-b-203{margin-bottom:203px}.m-b-204{margin-bottom:204px}.m-b-205{margin-bottom:205px}.m-b-206{margin-bottom:206px}.m-b-207{margin-bottom:207px}.m-b-208{margin-bottom:208px}.m-b-209{margin-bottom:209px}.m-b-210{margin-bottom:210px}.m-b-211{margin-bottom:211px}.m-b-212{margin-bottom:212px}.m-b-213{margin-bottom:213px}.m-b-214{margin-bottom:214px}.m-b-215{margin-bottom:215px}.m-b-216{margin-bottom:216px}.m-b-217{margin-bottom:217px}.m-b-218{margin-bottom:218px}.m-b-219{margin-bottom:219px}.m-b-220{margin-bottom:220px}.m-b-221{margin-bottom:221px}.m-b-222{margin-bottom:222px}.m-b-223{margin-bottom:223px}.m-b-224{margin-bottom:224px}.m-b-225{margin-bottom:225px}.m-b-226{margin-bottom:226px}.m-b-227{margin-bottom:227px}.m-b-228{margin-bottom:228px}.m-b-229{margin-bottom:229px}.m-b-230{margin-bottom:230px}.m-b-231{margin-bottom:231px}.m-b-232{margin-bottom:232px}.m-b-233{margin-bottom:233px}.m-b-234{margin-bottom:234px}.m-b-235{margin-bottom:235px}.m-b-236{margin-bottom:236px}.m-b-237{margin-bottom:237px}.m-b-238{margin-bottom:238px}.m-b-239{margin-bottom:239px}.m-b-240{margin-bottom:240px}.m-b-241{margin-bottom:241px}.m-b-242{margin-bottom:242px}.m-b-243{margin-bottom:243px}.m-b-244{margin-bottom:244px}.m-b-245{margin-bottom:245px}.m-b-246{margin-bottom:246px}.m-b-247{margin-bottom:247px}.m-b-248{margin-bottom:248px}.m-b-249{margin-bottom:249px}.m-b-250{margin-bottom:250px}.m-l-0{margin-left:0}.m-l-1{margin-left:1px}.m-l-2{margin-left:2px}.m-l-3{margin-left:3px}.m-l-4{margin-left:4px}.m-l-5{margin-left:5px}.m-l-6{margin-left:6px}.m-l-7{margin-left:7px}.m-l-8{margin-left:8px}.m-l-9{margin-left:9px}.m-l-10{margin-left:10px}.m-l-11{margin-left:11px}.m-l-12{margin-left:12px}.m-l-13{margin-left:13px}.m-l-14{margin-left:14px}.m-l-15{margin-left:15px}.m-l-16{margin-left:16px}.m-l-17{margin-left:17px}.m-l-18{margin-left:18px}.m-l-19{margin-left:19px}.m-l-20{margin-left:20px}.m-l-21{margin-left:21px}.m-l-22{margin-left:22px}.m-l-23{margin-left:23px}.m-l-24{margin-left:24px}.m-l-25{margin-left:25px}.m-l-26{margin-left:26px}.m-l-27{margin-left:27px}.m-l-28{margin-left:28px}.m-l-29{margin-left:29px}.m-l-30{margin-left:30px}.m-l-31{margin-left:31px}.m-l-32{margin-left:32px}.m-l-33{margin-left:33px}.m-l-34{margin-left:34px}.m-l-35{margin-left:35px}.m-l-36{margin-left:36px}.m-l-37{margin-left:37px}.m-l-38{margin-left:38px}.m-l-39{margin-left:39px}.m-l-40{margin-left:40px}.m-l-41{margin-left:41px}.m-l-42{margin-left:42px}.m-l-43{margin-left:43px}.m-l-44{margin-left:44px}.m-l-45{margin-left:45px}.m-l-46{margin-left:46px}.m-l-47{margin-left:47px}.m-l-48{margin-left:48px}.m-l-49{margin-left:49px}.m-l-50{margin-left:50px}.m-l-51{margin-left:51px}.m-l-52{margin-left:52px}.m-l-53{margin-left:53px}.m-l-54{margin-left:54px}.m-l-55{margin-left:55px}.m-l-56{margin-left:56px}.m-l-57{margin-left:57px}.m-l-58{margin-left:58px}.m-l-59{margin-left:59px}.m-l-60{margin-left:60px}.m-l-61{margin-left:61px}.m-l-62{margin-left:62px}.m-l-63{margin-left:63px}.m-l-64{margin-left:64px}.m-l-65{margin-left:65px}.m-l-66{margin-left:66px}.m-l-67{margin-left:67px}.m-l-68{margin-left:68px}.m-l-69{margin-left:69px}.m-l-70{margin-left:70px}.m-l-71{margin-left:71px}.m-l-72{margin-left:72px}.m-l-73{margin-left:73px}.m-l-74{margin-left:74px}.m-l-75{margin-left:75px}.m-l-76{margin-left:76px}.m-l-77{margin-left:77px}.m-l-78{margin-left:78px}.m-l-79{margin-left:79px}.m-l-80{margin-left:80px}.m-l-81{margin-left:81px}.m-l-82{margin-left:82px}.m-l-83{margin-left:83px}.m-l-84{margin-left:84px}.m-l-85{margin-left:85px}.m-l-86{margin-left:86px}.m-l-87{margin-left:87px}.m-l-88{margin-left:88px}.m-l-89{margin-left:89px}.m-l-90{margin-left:90px}.m-l-91{margin-left:91px}.m-l-92{margin-left:92px}.m-l-93{margin-left:93px}.m-l-94{margin-left:94px}.m-l-95{margin-left:95px}.m-l-96{margin-left:96px}.m-l-97{margin-left:97px}.m-l-98{margin-left:98px}.m-l-99{margin-left:99px}.m-l-100{margin-left:100px}.m-l-101{margin-left:101px}.m-l-102{margin-left:102px}.m-l-103{margin-left:103px}.m-l-104{margin-left:104px}.m-l-105{margin-left:105px}.m-l-106{margin-left:106px}.m-l-107{margin-left:107px}.m-l-108{margin-left:108px}.m-l-109{margin-left:109px}.m-l-110{margin-left:110px}.m-l-111{margin-left:111px}.m-l-112{margin-left:112px}.m-l-113{margin-left:113px}.m-l-114{margin-left:114px}.m-l-115{margin-left:115px}.m-l-116{margin-left:116px}.m-l-117{margin-left:117px}.m-l-118{margin-left:118px}.m-l-119{margin-left:119px}.m-l-120{margin-left:120px}.m-l-121{margin-left:121px}.m-l-122{margin-left:122px}.m-l-123{margin-left:123px}.m-l-124{margin-left:124px}.m-l-125{margin-left:125px}.m-l-126{margin-left:126px}.m-l-127{margin-left:127px}.m-l-128{margin-left:128px}.m-l-129{margin-left:129px}.m-l-130{margin-left:130px}.m-l-131{margin-left:131px}.m-l-132{margin-left:132px}.m-l-133{margin-left:133px}.m-l-134{margin-left:134px}.m-l-135{margin-left:135px}.m-l-136{margin-left:136px}.m-l-137{margin-left:137px}.m-l-138{margin-left:138px}.m-l-139{margin-left:139px}.m-l-140{margin-left:140px}.m-l-141{margin-left:141px}.m-l-142{margin-left:142px}.m-l-143{margin-left:143px}.m-l-144{margin-left:144px}.m-l-145{margin-left:145px}.m-l-146{margin-left:146px}.m-l-147{margin-left:147px}.m-l-148{margin-left:148px}.m-l-149{margin-left:149px}.m-l-150{margin-left:150px}.m-l-151{margin-left:151px}.m-l-152{margin-left:152px}.m-l-153{margin-left:153px}.m-l-154{margin-left:154px}.m-l-155{margin-left:155px}.m-l-156{margin-left:156px}.m-l-157{margin-left:157px}.m-l-158{margin-left:158px}.m-l-159{margin-left:159px}.m-l-160{margin-left:160px}.m-l-161{margin-left:161px}.m-l-162{margin-left:162px}.m-l-163{margin-left:163px}.m-l-164{margin-left:164px}.m-l-165{margin-left:165px}.m-l-166{margin-left:166px}.m-l-167{margin-left:167px}.m-l-168{margin-left:168px}.m-l-169{margin-left:169px}.m-l-170{margin-left:170px}.m-l-171{margin-left:171px}.m-l-172{margin-left:172px}.m-l-173{margin-left:173px}.m-l-174{margin-left:174px}.m-l-175{margin-left:175px}.m-l-176{margin-left:176px}.m-l-177{margin-left:177px}.m-l-178{margin-left:178px}.m-l-179{margin-left:179px}.m-l-180{margin-left:180px}.m-l-181{margin-left:181px}.m-l-182{margin-left:182px}.m-l-183{margin-left:183px}.m-l-184{margin-left:184px}.m-l-185{margin-left:185px}.m-l-186{margin-left:186px}.m-l-187{margin-left:187px}.m-l-188{margin-left:188px}.m-l-189{margin-left:189px}.m-l-190{margin-left:190px}.m-l-191{margin-left:191px}.m-l-192{margin-left:192px}.m-l-193{margin-left:193px}.m-l-194{margin-left:194px}.m-l-195{margin-left:195px}.m-l-196{margin-left:196px}.m-l-197{margin-left:197px}.m-l-198{margin-left:198px}.m-l-199{margin-left:199px}.m-l-200{margin-left:200px}.m-l-201{margin-left:201px}.m-l-202{margin-left:202px}.m-l-203{margin-left:203px}.m-l-204{margin-left:204px}.m-l-205{margin-left:205px}.m-l-206{margin-left:206px}.m-l-207{margin-left:207px}.m-l-208{margin-left:208px}.m-l-209{margin-left:209px}.m-l-210{margin-left:210px}.m-l-211{margin-left:211px}.m-l-212{margin-left:212px}.m-l-213{margin-left:213px}.m-l-214{margin-left:214px}.m-l-215{margin-left:215px}.m-l-216{margin-left:216px}.m-l-217{margin-left:217px}.m-l-218{margin-left:218px}.m-l-219{margin-left:219px}.m-l-220{margin-left:220px}.m-l-221{margin-left:221px}.m-l-222{margin-left:222px}.m-l-223{margin-left:223px}.m-l-224{margin-left:224px}.m-l-225{margin-left:225px}.m-l-226{margin-left:226px}.m-l-227{margin-left:227px}.m-l-228{margin-left:228px}.m-l-229{margin-left:229px}.m-l-230{margin-left:230px}.m-l-231{margin-left:231px}.m-l-232{margin-left:232px}.m-l-233{margin-left:233px}.m-l-234{margin-left:234px}.m-l-235{margin-left:235px}.m-l-236{margin-left:236px}.m-l-237{margin-left:237px}.m-l-238{margin-left:238px}.m-l-239{margin-left:239px}.m-l-240{margin-left:240px}.m-l-241{margin-left:241px}.m-l-242{margin-left:242px}.m-l-243{margin-left:243px}.m-l-244{margin-left:244px}.m-l-245{margin-left:245px}.m-l-246{margin-left:246px}.m-l-247{margin-left:247px}.m-l-248{margin-left:248px}.m-l-249{margin-left:249px}.m-l-250{margin-left:250px}.m-r-0{margin-right:0}.m-r-1{margin-right:1px}.m-r-2{margin-right:2px}.m-r-3{margin-right:3px}.m-r-4{margin-right:4px}.m-r-5{margin-right:5px}.m-r-6{margin-right:6px}.m-r-7{margin-right:7px}.m-r-8{margin-right:8px}.m-r-9{margin-right:9px}.m-r-10{margin-right:10px}.m-r-11{margin-right:11px}.m-r-12{margin-right:12px}.m-r-13{margin-right:13px}.m-r-14{margin-right:14px}.m-r-15{margin-right:15px}.m-r-16{margin-right:16px}.m-r-17{margin-right:17px}.m-r-18{margin-right:18px}.m-r-19{margin-right:19px}.m-r-20{margin-right:20px}.m-r-21{margin-right:21px}.m-r-22{margin-right:22px}.m-r-23{margin-right:23px}.m-r-24{margin-right:24px}.m-r-25{margin-right:25px}.m-r-26{margin-right:26px}.m-r-27{margin-right:27px}.m-r-28{margin-right:28px}.m-r-29{margin-right:29px}.m-r-30{margin-right:30px}.m-r-31{margin-right:31px}.m-r-32{margin-right:32px}.m-r-33{margin-right:33px}.m-r-34{margin-right:34px}.m-r-35{margin-right:35px}.m-r-36{margin-right:36px}.m-r-37{margin-right:37px}.m-r-38{margin-right:38px}.m-r-39{margin-right:39px}.m-r-40{margin-right:40px}.m-r-41{margin-right:41px}.m-r-42{margin-right:42px}.m-r-43{margin-right:43px}.m-r-44{margin-right:44px}.m-r-45{margin-right:45px}.m-r-46{margin-right:46px}.m-r-47{margin-right:47px}.m-r-48{margin-right:48px}.m-r-49{margin-right:49px}.m-r-50{margin-right:50px}.m-r-51{margin-right:51px}.m-r-52{margin-right:52px}.m-r-53{margin-right:53px}.m-r-54{margin-right:54px}.m-r-55{margin-right:55px}.m-r-56{margin-right:56px}.m-r-57{margin-right:57px}.m-r-58{margin-right:58px}.m-r-59{margin-right:59px}.m-r-60{margin-right:60px}.m-r-61{margin-right:61px}.m-r-62{margin-right:62px}.m-r-63{margin-right:63px}.m-r-64{margin-right:64px}.m-r-65{margin-right:65px}.m-r-66{margin-right:66px}.m-r-67{margin-right:67px}.m-r-68{margin-right:68px}.m-r-69{margin-right:69px}.m-r-70{margin-right:70px}.m-r-71{margin-right:71px}.m-r-72{margin-right:72px}.m-r-73{margin-right:73px}.m-r-74{margin-right:74px}.m-r-75{margin-right:75px}.m-r-76{margin-right:76px}.m-r-77{margin-right:77px}.m-r-78{margin-right:78px}.m-r-79{margin-right:79px}.m-r-80{margin-right:80px}.m-r-81{margin-right:81px}.m-r-82{margin-right:82px}.m-r-83{margin-right:83px}.m-r-84{margin-right:84px}.m-r-85{margin-right:85px}.m-r-86{margin-right:86px}.m-r-87{margin-right:87px}.m-r-88{margin-right:88px}.m-r-89{margin-right:89px}.m-r-90{margin-right:90px}.m-r-91{margin-right:91px}.m-r-92{margin-right:92px}.m-r-93{margin-right:93px}.m-r-94{margin-right:94px}.m-r-95{margin-right:95px}.m-r-96{margin-right:96px}.m-r-97{margin-right:97px}.m-r-98{margin-right:98px}.m-r-99{margin-right:99px}.m-r-100{margin-right:100px}.m-r-101{margin-right:101px}.m-r-102{margin-right:102px}.m-r-103{margin-right:103px}.m-r-104{margin-right:104px}.m-r-105{margin-right:105px}.m-r-106{margin-right:106px}.m-r-107{margin-right:107px}.m-r-108{margin-right:108px}.m-r-109{margin-right:109px}.m-r-110{margin-right:110px}.m-r-111{margin-right:111px}.m-r-112{margin-right:112px}.m-r-113{margin-right:113px}.m-r-114{margin-right:114px}.m-r-115{margin-right:115px}.m-r-116{margin-right:116px}.m-r-117{margin-right:117px}.m-r-118{margin-right:118px}.m-r-119{margin-right:119px}.m-r-120{margin-right:120px}.m-r-121{margin-right:121px}.m-r-122{margin-right:122px}.m-r-123{margin-right:123px}.m-r-124{margin-right:124px}.m-r-125{margin-right:125px}.m-r-126{margin-right:126px}.m-r-127{margin-right:127px}.m-r-128{margin-right:128px}.m-r-129{margin-right:129px}.m-r-130{margin-right:130px}.m-r-131{margin-right:131px}.m-r-132{margin-right:132px}.m-r-133{margin-right:133px}.m-r-134{margin-right:134px}.m-r-135{margin-right:135px}.m-r-136{margin-right:136px}.m-r-137{margin-right:137px}.m-r-138{margin-right:138px}.m-r-139{margin-right:139px}.m-r-140{margin-right:140px}.m-r-141{margin-right:141px}.m-r-142{margin-right:142px}.m-r-143{margin-right:143px}.m-r-144{margin-right:144px}.m-r-145{margin-right:145px}.m-r-146{margin-right:146px}.m-r-147{margin-right:147px}.m-r-148{margin-right:148px}.m-r-149{margin-right:149px}.m-r-150{margin-right:150px}.m-r-151{margin-right:151px}.m-r-152{margin-right:152px}.m-r-153{margin-right:153px}.m-r-154{margin-right:154px}.m-r-155{margin-right:155px}.m-r-156{margin-right:156px}.m-r-157{margin-right:157px}.m-r-158{margin-right:158px}.m-r-159{margin-right:159px}.m-r-160{margin-right:160px}.m-r-161{margin-right:161px}.m-r-162{margin-right:162px}.m-r-163{margin-right:163px}.m-r-164{margin-right:164px}.m-r-165{margin-right:165px}.m-r-166{margin-right:166px}.m-r-167{margin-right:167px}.m-r-168{margin-right:168px}.m-r-169{margin-right:169px}.m-r-170{margin-right:170px}.m-r-171{margin-right:171px}.m-r-172{margin-right:172px}.m-r-173{margin-right:173px}.m-r-174{margin-right:174px}.m-r-175{margin-right:175px}.m-r-176{margin-right:176px}.m-r-177{margin-right:177px}.m-r-178{margin-right:178px}.m-r-179{margin-right:179px}.m-r-180{margin-right:180px}.m-r-181{margin-right:181px}.m-r-182{margin-right:182px}.m-r-183{margin-right:183px}.m-r-184{margin-right:184px}.m-r-185{margin-right:185px}.m-r-186{margin-right:186px}.m-r-187{margin-right:187px}.m-r-188{margin-right:188px}.m-r-189{margin-right:189px}.m-r-190{margin-right:190px}.m-r-191{margin-right:191px}.m-r-192{margin-right:192px}.m-r-193{margin-right:193px}.m-r-194{margin-right:194px}.m-r-195{margin-right:195px}.m-r-196{margin-right:196px}.m-r-197{margin-right:197px}.m-r-198{margin-right:198px}.m-r-199{margin-right:199px}.m-r-200{margin-right:200px}.m-r-201{margin-right:201px}.m-r-202{margin-right:202px}.m-r-203{margin-right:203px}.m-r-204{margin-right:204px}.m-r-205{margin-right:205px}.m-r-206{margin-right:206px}.m-r-207{margin-right:207px}.m-r-208{margin-right:208px}.m-r-209{margin-right:209px}.m-r-210{margin-right:210px}.m-r-211{margin-right:211px}.m-r-212{margin-right:212px}.m-r-213{margin-right:213px}.m-r-214{margin-right:214px}.m-r-215{margin-right:215px}.m-r-216{margin-right:216px}.m-r-217{margin-right:217px}.m-r-218{margin-right:218px}.m-r-219{margin-right:219px}.m-r-220{margin-right:220px}.m-r-221{margin-right:221px}.m-r-222{margin-right:222px}.m-r-223{margin-right:223px}.m-r-224{margin-right:224px}.m-r-225{margin-right:225px}.m-r-226{margin-right:226px}.m-r-227{margin-right:227px}.m-r-228{margin-right:228px}.m-r-229{margin-right:229px}.m-r-230{margin-right:230px}.m-r-231{margin-right:231px}.m-r-232{margin-right:232px}.m-r-233{margin-right:233px}.m-r-234{margin-right:234px}.m-r-235{margin-right:235px}.m-r-236{margin-right:236px}.m-r-237{margin-right:237px}.m-r-238{margin-right:238px}.m-r-239{margin-right:239px}.m-r-240{margin-right:240px}.m-r-241{margin-right:241px}.m-r-242{margin-right:242px}.m-r-243{margin-right:243px}.m-r-244{margin-right:244px}.m-r-245{margin-right:245px}.m-r-246{margin-right:246px}.m-r-247{margin-right:247px}.m-r-248{margin-right:248px}.m-r-249{margin-right:249px}.m-r-250{margin-right:250px}.m-l-r-auto{margin-left:auto;margin-right:auto}.m-l-auto{margin-left:auto}.m-r-auto{margin-right:auto}.text-white{color:white}.text-black{color:black}.text-hov-white:hover{color:white}.text-up{text-transform:uppercase}.text-center{text-align:center}.text-left{text-align:left}.text-right{text-align:right}.text-middle{vertical-align:middle}.lh-1-0{line-height:1.0}.lh-1-1{line-height:1.1}.lh-1-2{line-height:1.2}.lh-1-3{line-height:1.3}.lh-1-4{line-height:1.4}.lh-1-5{line-height:1.5}.lh-1-6{line-height:1.6}.lh-1-7{line-height:1.7}.lh-1-8{line-height:1.8}.lh-1-9{line-height:1.9}.lh-2-0{line-height:2.0}.lh-2-1{line-height:2.1}.lh-2-2{line-height:2.2}.lh-2-3{line-height:2.3}.lh-2-4{line-height:2.4}.lh-2-5{line-height:2.5}.lh-2-6{line-height:2.6}.lh-2-7{line-height:2.7}.lh-2-8{line-height:2.8}.lh-2-9{line-height:2.9}.dis-none{display:none}.dis-block{display:block}.dis-inline{display:inline}.dis-inline-block{display:inline-block}.dis-flex{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex}.pos-relative{position:relative}.pos-absolute{position:absolute}.pos-fixed{position:fixed}.float-l{float:left}.float-r{float:right}.sizefull{width:100%;height:100%}.w-full{width:100%}.h-full{height:100%}.max-w-full{max-width:100%}.max-h-full{max-height:100%}.min-w-full{min-width:100%}.min-h-full{min-height:100%}.top-0{top:0}.bottom-0{bottom:0}.left-0{left:0}.right-0{right:0}.top-auto{top:auto}.bottom-auto{bottom:auto}.left-auto{left:auto}.right-auto{right:auto}.op-0-0{opacity:0}.op-0-1{opacity:.1}.op-0-2{opacity:.2}.op-0-3{opacity:.3}.op-0-4{opacity:.4}.op-0-5{opacity:.5}.op-0-6{opacity:.6}.op-0-7{opacity:.7}.op-0-8{opacity:.8}.op-0-9{opacity:.9}.op-1-0{opacity:1}.bgwhite{background-color:white}.bgblack{background-color:black}.wrap-pic-w img{width:100%}.wrap-pic-max-w img{max-width:100%}.wrap-pic-h img{height:100%}.wrap-pic-max-h img{max-height:100%}.wrap-pic-cir{border-radius:50%;overflow:hidden}.wrap-pic-cir img{width:100%}.hov-pointer:hover{cursor:pointer}.hov-img-zoom{display:block;overflow:hidden}.hov-img-zoom img{width:100%;-webkit-transition:all .6s;-o-transition:all .6s;-moz-transition:all .6s;transition:all .6s}.hov-img-zoom:hover img{-webkit-transform:scale(1.1);-moz-transform:scale(1.1);-ms-transform:scale(1.1);-o-transform:scale(1.1);transform:scale(1.1)}.bo-cir{border-radius:50%}.of-hidden{overflow:hidden}.visible-false{visibility:hidden}.visible-true{visibility:visible}.trans-0-1{-webkit-transition:all .1s;-o-transition:all .1s;-moz-transition:all .1s;transition:all .1s}.trans-0-2{-webkit-transition:all .2s;-o-transition:all .2s;-moz-transition:all .2s;transition:all .2s}.trans-0-3{-webkit-transition:all .3s;-o-transition:all .3s;-moz-transition:all .3s;transition:all .3s}.trans-0-4{-webkit-transition:all .4s;-o-transition:all .4s;-moz-transition:all .4s;transition:all .4s}.trans-0-5{-webkit-transition:all .5s;-o-transition:all .5s;-moz-transition:all .5s;transition:all .5s}.trans-0-6{-webkit-transition:all .6s;-o-transition:all .6s;-moz-transition:all .6s;transition:all .6s}.trans-0-9{-webkit-transition:all .9s;-o-transition:all .9s;-moz-transition:all .9s;transition:all .9s}.trans-1-0{-webkit-transition:all 1s;-o-transition:all 1s;-moz-transition:all 1s;transition:all 1s}.flex-w{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-wrap:wrap;-moz-flex-wrap:wrap;-ms-flex-wrap:wrap;-o-flex-wrap:wrap;flex-wrap:wrap}.flex-l{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:flex-start}.flex-r{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:flex-end}.flex-c{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:center}.flex-sa{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:space-around}.flex-sb{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:space-between}.flex-t{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-ms-align-items:flex-start;align-items:flex-start}.flex-b{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-ms-align-items:flex-end;align-items:flex-end}.flex-m{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-ms-align-items:center;align-items:center}.flex-str{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-ms-align-items:stretch;align-items:stretch}.flex-row{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:row;-moz-flex-direction:row;-ms-flex-direction:row;-o-flex-direction:row;flex-direction:row}.flex-row-rev{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:row-reverse;-moz-flex-direction:row-reverse;-ms-flex-direction:row-reverse;-o-flex-direction:row-reverse;flex-direction:row-reverse}.flex-col{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;-o-flex-direction:column;flex-direction:column}.flex-col-rev{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column-reverse;-moz-flex-direction:column-reverse;-ms-flex-direction:column-reverse;-o-flex-direction:column-reverse;flex-direction:column-reverse}.flex-c-m{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:center;-ms-align-items:center;align-items:center}.flex-c-t{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:center;-ms-align-items:flex-start;align-items:flex-start}.flex-c-b{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:center;-ms-align-items:flex-end;align-items:flex-end}.flex-c-str{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:center;-ms-align-items:stretch;align-items:stretch}.flex-l-m{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:flex-start;-ms-align-items:center;align-items:center}.flex-r-m{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:flex-end;-ms-align-items:center;align-items:center}.flex-sa-m{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:space-around;-ms-align-items:center;align-items:center}.flex-sb-m{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:space-between;-ms-align-items:center;align-items:center}.flex-col-l{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;-o-flex-direction:column;flex-direction:column;-ms-align-items:flex-start;align-items:flex-start}.flex-col-r{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;-o-flex-direction:column;flex-direction:column;-ms-align-items:flex-end;align-items:flex-end}.flex-col-c{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;-o-flex-direction:column;flex-direction:column;-ms-align-items:center;align-items:center}.flex-col-l-m{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;-o-flex-direction:column;flex-direction:column;-ms-align-items:flex-start;align-items:flex-start;justify-content:center}.flex-col-r-m{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;-o-flex-direction:column;flex-direction:column;-ms-align-items:flex-end;align-items:flex-end;justify-content:center}.flex-col-c-m{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;-o-flex-direction:column;flex-direction:column;-ms-align-items:center;align-items:center;justify-content:center}.flex-col-str{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;-o-flex-direction:column;flex-direction:column;-ms-align-items:stretch;align-items:stretch}.flex-col-sb{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;-o-flex-direction:column;flex-direction:column;justify-content:space-between}.flex-col-rev-l{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column-reverse;-moz-flex-direction:column-reverse;-ms-flex-direction:column-reverse;-o-flex-direction:column-reverse;flex-direction:column-reverse;-ms-align-items:flex-start;align-items:flex-start}.flex-col-rev-r{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column-reverse;-moz-flex-direction:column-reverse;-ms-flex-direction:column-reverse;-o-flex-direction:column-reverse;flex-direction:column-reverse;-ms-align-items:flex-end;align-items:flex-end}.flex-col-rev-c{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column-reverse;-moz-flex-direction:column-reverse;-ms-flex-direction:column-reverse;-o-flex-direction:column-reverse;flex-direction:column-reverse;-ms-align-items:center;align-items:center}.flex-col-rev-str{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column-reverse;-moz-flex-direction:column-reverse;-ms-flex-direction:column-reverse;-o-flex-direction:column-reverse;flex-direction:column-reverse;-ms-align-items:stretch;align-items:stretch}.ab-c-m{position:absolute;top:50%;left:50%;-webkit-transform:translate(-50%,-50%);-moz-transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%);-o-transform:translate(-50%,-50%);transform:translate(-50%,-50%)}.ab-c-t{position:absolute;top:0;left:50%;-webkit-transform:translateX(-50%);-moz-transform:translateX(-50%);-ms-transform:translateX(-50%);-o-transform:translateX(-50%);transform:translateX(-50%)}.ab-c-b{position:absolute;bottom:0;left:50%;-webkit-transform:translateX(-50%);-moz-transform:translateX(-50%);-ms-transform:translateX(-50%);-o-transform:translateX(-50%);transform:translateX(-50%)}.ab-l-m{position:absolute;left:0;top:50%;-webkit-transform:translateY(-50%);-moz-transform:translateY(-50%);-ms-transform:translateY(-50%);-o-transform:translateY(-50%);transform:translateY(-50%)}.ab-r-m{position:absolute;right:0;top:50%;-webkit-transform:translateY(-50%);-moz-transform:translateY(-50%);-ms-transform:translateY(-50%);-o-transform:translateY(-50%);transform:translateY(-50%)}.ab-t-l{position:absolute;left:0;top:0}.ab-t-r{position:absolute;right:0;top:0}.ab-b-l{position:absolute;left:0;bottom:0}.ab-b-r{position:absolute;right:0;bottom:0}@media only screen and (max-width:600px){.smol th,.smol td,.smol a,.smol p{padding-top:.3rem;padding-bottom:.3rem;font-size:.6rem!important;font-family:"Poppins-Regular"}body{font-size:.6rem!important}}@media only screen and (min-width:600px){.smol th,.smol td,.smol a,.smol p{padding-top:.1rem;padding-bottom:.1rem;font-size:.65rem!important;font-family:"Poppins-Regular"}body{font-size:.65rem!important}}@media only screen and (min-width:768px){.smol th,.smol td,.smol a,.smol p{padding-top:.2rem;padding-bottom:.2rem;font-size:.7rem!important;font-family:"Poppins-Regular"}body{font-size:.7rem!important}}@media only screen and (min-width:1440px){.smol th,.smol td,.smol a,.smol p{padding-top:.3rem;padding-bottom:.3rem;font-size:.75rem!important;font-family:"Poppins-Regular"}body{font-size:.75rem!important}}@media only screen and (min-width:1910px){.smol th,.smol td,.smol a,.smol p{padding-top:.3rem;padding-bottom:.3rem;font-size:.85rem!important;font-family:"Poppins-Regular"}body{font-size:.85rem!important}}.datatable-tab-correct{margin-top:0!important}.datatable-tab-correct1{margin-top:0!important}.nav-tabs{border-bottom:1px solid #dee2e6;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#6496e1!important}.nav-tabs .nav-item.show .nav-link,.nav-tabs .nav-link.active{color:#fff!important;background-color:#6496e1!important;border-color:#6496e1!important}.nav-tabs .nav-link:focus,.nav-tabs .nav-link:hover{border-color:#e9ecef #e9ecef #dee2e6}.nav-tabs .nav-link{border:1px solid transparent;border-top-left-radius:.25rem;border-top-right-radius:.25rem;color:#fff!important;background-color:#000080!important}.nav-link:focus,.nav-link:hover{text-decoration:none}.bg-sog{background-color:#6496e1!important}thead.bg-sog{background-color:#6496e1!important}a.bg-sog:focus,a.bg-sog:hover,button.bg-sog:focus,button.bg-sog:hover{background-color:#6496e1!important}.carded{position:relative;display:-ms-flexbox;display:flex;-ms-flex-direction:column;flex-direction:column;min-width:0;word-wrap:break-word;background-color:#fff;background-clip:border-box}.carded-body{-ms-flex:1 1 auto;flex:1 1 auto;padding:1.25rem}.carded-title{margin-bottom:.75rem}.carded-subtitle{margin-top:-0.375rem;margin-bottom:0}.carded-text:last-child{margin-bottom:0}.carded-link:hover{text-decoration:none}.carded-link+.carded-link{margin-left:1.25rem}.carded-header{padding:.75rem 1.25rem;margin-bottom:0;background-color:rgba(0,0,0,0.03);border-bottom:1px solid rgba(0,0,0,0.125)}.carded-footer{padding:.75rem 1.25rem;background-color:rgba(0,0,0,0.03);border-top:1px solid rgba(0,0,0,0.125)}.carded-header-tabs{margin-right:-0.625rem;margin-bottom:-0.75rem;margin-left:-0.625rem;border-bottom:0}.carded-header-pills{margin-right:-0.625rem;margin-left:-0.625rem}.carded-img-overlay{position:absolute;top:0;right:0;bottom:0;left:0;padding:1.25rem}.carded-img{width:100%}.carded-img-top{width:100%;border-top-left-radius:calc(0.25rem - 1px);border-top-right-radius:calc(0.25rem - 1px)}.carded-img-bottom{width:100%;border-bottom-right-radius:calc(0.25rem - 1px);border-bottom-left-radius:calc(0.25rem - 1px)}@media(min-width:576px){.carded-deck{display:-ms-flexbox;display:flex;-ms-flex-flow:row wrap;flex-flow:row wrap;margin-right:-15px;margin-left:-15px}.carded-deck .carded{display:-ms-flexbox;display:flex;-ms-flex:1 0 0;flex:1 0 0;-ms-flex-direction:column;flex-direction:column;margin-right:15px;margin-left:15px}}@media(min-width:576px){.carded-group{display:-ms-flexbox;display:flex;-ms-flex-flow:row wrap;flex-flow:row wrap}.carded-group .carded{-ms-flex:1 0 0;flex:1 0 0}.carded-group .carded+.carded{margin-left:0;border-left:0}.carded-group .carded:first-child{border-top-right-radius:0;border-bottom-right-radius:0}.carded-group .carded:first-child .carded-img-top{border-top-right-radius:0}.carded-group .carded:first-child .carded-img-bottom{border-bottom-right-radius:0}.carded-group .carded:last-child{border-top-left-radius:0;border-bottom-left-radius:0}.carded-group .carded:last-child .carded-img-top{border-top-left-radius:0}.carded-group .carded:last-child .carded-img-bottom{border-bottom-left-radius:0}.carded-group .carded:not(:first-child):not(:last-child){border-radius:0}.carded-group .carded:not(:first-child):not(:last-child) .carded-img-top,.carded-group .carded:not(:first-child):not(:last-child) .carded-img-bottom{border-radius:0}}.carded-columns .carded{margin-bottom:.75rem}@media(min-width:576px){.carded-columns{-webkit-column-count:3;column-count:3;-webkit-column-gap:1.25rem;column-gap:1.25rem}.carded-columns .carded{display:inline-block;width:100%}}.nav-underline .active{font-weight:500;color:white;background-color:#343a40!important;box-shadow:0rem 0rem 1rem 0rem rgba(0,0,0,.175) inset!important}.nav-pills .nav-link{border-radius:0 0 .25rem .25rem!important}.btn-floating{position:relative;z-index:1;display:inline-block;padding:0;margin:10px;overflow:hidden;vertical-align:middle;cursor:pointer;border-radius:50%!important;-webkit-box-shadow:0 5px 11px 0 rgba(0,0,0,0.18),0 4px 15px 0 rgba(0,0,0,0.15);box-shadow:0 5px 11px 0 rgba(0,0,0,0.18),0 4px 15px 0 rgba(0,0,0,0.15);-webkit-transition:all .2s ease-in-out;transition:all .2s ease-in-out;width:47px;height:47px}.btn-floating i{font-size:1.25rem;line-height:47px}.btn-floating i{display:inline-block;width:inherit;color:#fff;text-align:center}.btn-floating:hover{-webkit-box-shadow:0 8px 17px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);box-shadow:0 8px 17px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19)}.btn-floating:before{border-radius:0}.btn-floating.btn-sm{width:36.15385px;height:36.15385px}.btn-floating.btn-sm i{font-size:.96154rem;line-height:36.15385px}.btn-floating.btn-lg{width:61.1px;height:61.1px}.btn-floating.btn-lg i{font-size:1.625rem;line-height:61.1px}.fixed-action-btn{position:fixed;bottom:35px;z-index:998;margin-bottom:0;overflow:hidden;height:110px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:end;-ms-flex-align:end;align-items:flex-end;padding:15px 15px 15px 15px;padding-bottom:15px;padding-left:15px;padding-right:15px;-webkit-transition:height 400ms;transition:height 400ms}.fixed-action-btn ul{position:absolute;right:0;bottom:64px;left:0;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;height:0;padding:0;margin:0 0 15px;text-align:center;-webkit-transition:400ms all;transition:400ms all;opacity:0;margin-bottom:0}.fixed-action-btn ul li{z-index:0;display:-webkit-box;display:-ms-flexbox;display:flex;margin-right:auto;margin-bottom:15px;margin-left:auto}.fixed-action-btn ul a.btn-floating{opacity:0;-webkit-transition-duration:.4s;transition-duration:.4s;-webkit-transform:scale(0.4) translate(0);transform:scale(0.4) translate(0)}.fixed-action-btn ul a.btn-floating.shown{opacity:1;-webkit-transform:scale(1) translate(0);transform:scale(1) translate(0)}.fixed-action-btn.active ul{height:10rem;margin-bottom:40px;opacity:1}.fixed-action-btn.active{height:500px}.btn-floating.btn-flat{padding:0;color:#fff;background:#4285f4}.btn-floating.btn-flat:hover{-webkit-box-shadow:none;box-shadow:none}.btn-floating.btn-flat:hover,.btn-floating.btn-flat:focus{background-color:#5a95f5}.btn-floating.btn-flat.active{background-color:#0b51c5;-webkit-box-shadow:0 5px 11px 0 rgba(0,0,0,0.18),0 4px 15px 0 rgba(0,0,0,0.15);box-shadow:0 5px 11px 0 rgba(0,0,0,0.18),0 4px 15px 0 rgba(0,0,0,0.15)}html{overflow:overlay}table,.dataTables_wrapper,.dataTables_scrollBody{overflow:overlay!important}::-webkit-scrollbar{width:8px}::-webkit-scrollbar-track{background:rgba(0,0,0,0);border-radius:0;display:none;scrollbar-width:none}::-webkit-scrollbar-thumb{background:rgba(33,37,41,0.5);border-radius:10px;box-shadow:0 0 6px rgba(0,0,0,0.5)}::-webkit-scrollbar-track:hover+::-webkit-scrollbar-thumb{background:rgba(33,37,41,1);border-radius:10px;box-shadow:0 0 6px rgba(0,0,0,0.5)}
  :root{--blue:#007bff;--indigo:#6610f2;--purple:#6f42c1;--pink:#e83e8c;--red:#dc3545;--orange:#fd7e14;--yellow:#ffc107;--green:#28a745;--teal:#20c997;--cyan:#17a2b8;--white:#fff;--gray:#6c757d;--gray-dark:#343a40;--primary:#007bff;--secondary:#6c757d;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#dc3545;--light:#f8f9fa;--dark:#343a40;--breakpoint-xs:0;--breakpoint-sm:576px;--breakpoint-md:768px;--breakpoint-lg:992px;--breakpoint-xl:1200px;--font-family-sans-serif:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";--font-family-monospace:SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace}*,::after,::before{box-sizing:border-box}html{font-family:sans-serif;line-height:1.15;-webkit-text-size-adjust:100%;-webkit-tap-highlight-color:transparent}article,aside,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}body{margin:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";font-size:1rem;font-weight:400;line-height:1.5;color:#212529;text-align:left;background-color:#fff}[tabindex="-1"]:focus:not(:focus-visible){outline:0!important}hr{box-sizing:content-box;height:0;overflow:visible}h1,h2,h3,h4,h5,h6{margin-top:0;margin-bottom:.5rem}p{margin-top:0;margin-bottom:1rem}abbr[data-original-title],abbr[title]{text-decoration:underline;-webkit-text-decoration:underline dotted;text-decoration:underline dotted;cursor:help;border-bottom:0;-webkit-text-decoration-skip-ink:none;text-decoration-skip-ink:none}address{margin-bottom:1rem;font-style:normal;line-height:inherit}dl,ol,ul{margin-top:0;margin-bottom:1rem}ol ol,ol ul,ul ol,ul ul{margin-bottom:0}dt{font-weight:700}dd{margin-bottom:.5rem;margin-left:0}blockquote{margin:0 0 1rem}b,strong{font-weight:bolder}small{font-size:80%}sub,sup{position:relative;font-size:75%;line-height:0;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}a{color:#007bff;text-decoration:none;background-color:transparent}a:hover{color:#0056b3;text-decoration:underline}a:not([href]){color:inherit;text-decoration:none}a:not([href]):hover{color:inherit;text-decoration:none}code,kbd,pre,samp{font-family:SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;font-size:1em}pre{margin-top:0;margin-bottom:1rem;overflow:auto;-ms-overflow-style:scrollbar}figure{margin:0 0 1rem}img{vertical-align:middle;border-style:none}svg{overflow:hidden;vertical-align:middle}table{border-collapse:collapse}caption{padding-top:.75rem;padding-bottom:.75rem;color:#6c757d;text-align:left;caption-side:bottom}th{text-align:inherit}label{display:inline-block;margin-bottom:.5rem}button{border-radius:0}button:focus{outline:1px dotted;outline:5px auto -webkit-focus-ring-color}button,input,optgroup,select,textarea{margin:0;font-family:inherit;font-size:inherit;line-height:inherit}button,input{overflow:visible}button,select{text-transform:none}[role=button]{cursor:pointer}select{word-wrap:normal}[type=button],[type=reset],[type=submit],button{-webkit-appearance:button}[type=button]:not(:disabled),[type=reset]:not(:disabled),[type=submit]:not(:disabled),button:not(:disabled){cursor:pointer}[type=button]::-moz-focus-inner,[type=reset]::-moz-focus-inner,[type=submit]::-moz-focus-inner,button::-moz-focus-inner{padding:0;border-style:none}input[type=checkbox],input[type=radio]{box-sizing:border-box;padding:0}textarea{overflow:auto;resize:vertical}fieldset{min-width:0;padding:0;margin:0;border:0}legend{display:block;width:100%;max-width:100%;padding:0;margin-bottom:.5rem;font-size:1.5rem;line-height:inherit;color:inherit;white-space:normal}progress{vertical-align:baseline}[type=number]::-webkit-inner-spin-button,[type=number]::-webkit-outer-spin-button{height:auto}[type=search]{outline-offset:-2px;-webkit-appearance:none}[type=search]::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{font:inherit;-webkit-appearance:button}output{display:inline-block}summary{display:list-item;cursor:pointer}template{display:none}[hidden]{display:none!important}.h1,.h2,.h3,.h4,.h5,.h6,h1,h2,h3,h4,h5,h6{margin-bottom:.5rem;font-weight:500;line-height:1.2}.h1,h1{font-size:2.5rem}.h2,h2{font-size:2rem}.h3,h3{font-size:1.75rem}.h4,h4{font-size:1.5rem}.h5,h5{font-size:1.25rem}.h6,h6{font-size:1rem}.lead{font-size:1.25rem;font-weight:300}.display-1{font-size:6rem;font-weight:300;line-height:1.2}.display-2{font-size:5.5rem;font-weight:300;line-height:1.2}.display-3{font-size:4.5rem;font-weight:300;line-height:1.2}.display-4{font-size:3.5rem;font-weight:300;line-height:1.2}hr{margin-top:1rem;margin-bottom:1rem;border:0;border-top:1px solid rgba(0,0,0,.1)}.small,small{font-size:80%;font-weight:400}.mark,mark{padding:.2em;background-color:#fcf8e3}.list-unstyled{padding-left:0;list-style:none}.list-inline{padding-left:0;list-style:none}.list-inline-item{display:inline-block}.list-inline-item:not(:last-child){margin-right:.5rem}.initialism{font-size:90%;text-transform:uppercase}.blockquote{margin-bottom:1rem;font-size:1.25rem}.blockquote-footer{display:block;font-size:80%;color:#6c757d}.blockquote-footer::before{content:"\2014\00A0"}.img-fluid{max-width:100%;height:auto}.img-thumbnail{padding:.25rem;background-color:#fff;border:1px solid #dee2e6;border-radius:.25rem;max-width:100%;height:auto}.figure{display:inline-block}.figure-img{margin-bottom:.5rem;line-height:1}.figure-caption{font-size:90%;color:#6c757d}code{font-size:87.5%;color:#e83e8c;word-wrap:break-word}a>code{color:inherit}kbd{padding:.2rem .4rem;font-size:87.5%;color:#fff;background-color:#212529;border-radius:.2rem}kbd kbd{padding:0;font-size:100%;font-weight:700}pre{display:block;font-size:87.5%;color:#212529}pre code{font-size:inherit;color:inherit;word-break:normal}.pre-scrollable{max-height:340px;overflow-y:scroll}.container{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}@media(min-width:576px){.container{max-width:540px}}@media(min-width:768px){.container{max-width:720px}}@media(min-width:992px){.container{max-width:960px}}@media(min-width:1200px){.container{max-width:1140px}}.container-fluid,.container-lg,.container-md,.container-sm,.container-xl{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}@media(min-width:576px){.container,.container-sm{max-width:540px}}@media(min-width:768px){.container,.container-md,.container-sm{max-width:720px}}@media(min-width:992px){.container,.container-lg,.container-md,.container-sm{max-width:960px}}@media(min-width:1200px){.container,.container-lg,.container-md,.container-sm,.container-xl{max-width:1140px}}.row{display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px}.no-gutters{margin-right:0;margin-left:0}.no-gutters>.col,.no-gutters>[class*=col-]{padding-right:0;padding-left:0}.col,.col-1,.col-10,.col-11,.col-12,.col-2,.col-3,.col-4,.col-5,.col-6,.col-7,.col-8,.col-9,.col-auto,.col-lg,.col-lg-1,.col-lg-10,.col-lg-11,.col-lg-12,.col-lg-2,.col-lg-3,.col-lg-4,.col-lg-5,.col-lg-6,.col-lg-7,.col-lg-8,.col-lg-9,.col-lg-auto,.col-md,.col-md-1,.col-md-10,.col-md-11,.col-md-12,.col-md-2,.col-md-3,.col-md-4,.col-md-5,.col-md-6,.col-md-7,.col-md-8,.col-md-9,.col-md-auto,.col-sm,.col-sm-1,.col-sm-10,.col-sm-11,.col-sm-12,.col-sm-2,.col-sm-3,.col-sm-4,.col-sm-5,.col-sm-6,.col-sm-7,.col-sm-8,.col-sm-9,.col-sm-auto,.col-xl,.col-xl-1,.col-xl-10,.col-xl-11,.col-xl-12,.col-xl-2,.col-xl-3,.col-xl-4,.col-xl-5,.col-xl-6,.col-xl-7,.col-xl-8,.col-xl-9,.col-xl-auto{position:relative;width:100%;padding-right:15px;padding-left:15px}.col{-ms-flex-preferred-size:0;flex-basis:0;-ms-flex-positive:1;flex-grow:1;min-width:0;max-width:100%}.row-cols-1>*{-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%}.row-cols-2>*{-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%}.row-cols-3>*{-ms-flex:0 0 33.333333%;flex:0 0 33.333333%;max-width:33.333333%}.row-cols-4>*{-ms-flex:0 0 25%;flex:0 0 25%;max-width:25%}.row-cols-5>*{-ms-flex:0 0 20%;flex:0 0 20%;max-width:20%}.row-cols-6>*{-ms-flex:0 0 16.666667%;flex:0 0 16.666667%;max-width:16.666667%}.col-auto{-ms-flex:0 0 auto;flex:0 0 auto;width:auto;max-width:100%}.col-1{-ms-flex:0 0 8.333333%;flex:0 0 8.333333%;max-width:8.333333%}.col-2{-ms-flex:0 0 16.666667%;flex:0 0 16.666667%;max-width:16.666667%}.col-3{-ms-flex:0 0 25%;flex:0 0 25%;max-width:25%}.col-4{-ms-flex:0 0 33.333333%;flex:0 0 33.333333%;max-width:33.333333%}.col-5{-ms-flex:0 0 41.666667%;flex:0 0 41.666667%;max-width:41.666667%}.col-6{-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%}.col-7{-ms-flex:0 0 58.333333%;flex:0 0 58.333333%;max-width:58.333333%}.col-8{-ms-flex:0 0 66.666667%;flex:0 0 66.666667%;max-width:66.666667%}.col-9{-ms-flex:0 0 75%;flex:0 0 75%;max-width:75%}.col-10{-ms-flex:0 0 83.333333%;flex:0 0 83.333333%;max-width:83.333333%}.col-11{-ms-flex:0 0 91.666667%;flex:0 0 91.666667%;max-width:91.666667%}.col-12{-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%}.order-first{-ms-flex-order:-1;order:-1}.order-last{-ms-flex-order:13;order:13}.order-0{-ms-flex-order:0;order:0}.order-1{-ms-flex-order:1;order:1}.order-2{-ms-flex-order:2;order:2}.order-3{-ms-flex-order:3;order:3}.order-4{-ms-flex-order:4;order:4}.order-5{-ms-flex-order:5;order:5}.order-6{-ms-flex-order:6;order:6}.order-7{-ms-flex-order:7;order:7}.order-8{-ms-flex-order:8;order:8}.order-9{-ms-flex-order:9;order:9}.order-10{-ms-flex-order:10;order:10}.order-11{-ms-flex-order:11;order:11}.order-12{-ms-flex-order:12;order:12}.offset-1{margin-left:8.333333%}.offset-2{margin-left:16.666667%}.offset-3{margin-left:25%}.offset-4{margin-left:33.333333%}.offset-5{margin-left:41.666667%}.offset-6{margin-left:50%}.offset-7{margin-left:58.333333%}.offset-8{margin-left:66.666667%}.offset-9{margin-left:75%}.offset-10{margin-left:83.333333%}.offset-11{margin-left:91.666667%}@media(min-width:576px){.col-sm{-ms-flex-preferred-size:0;flex-basis:0;-ms-flex-positive:1;flex-grow:1;min-width:0;max-width:100%}.row-cols-sm-1>*{-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%}.row-cols-sm-2>*{-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%}.row-cols-sm-3>*{-ms-flex:0 0 33.333333%;flex:0 0 33.333333%;max-width:33.333333%}.row-cols-sm-4>*{-ms-flex:0 0 25%;flex:0 0 25%;max-width:25%}.row-cols-sm-5>*{-ms-flex:0 0 20%;flex:0 0 20%;max-width:20%}.row-cols-sm-6>*{-ms-flex:0 0 16.666667%;flex:0 0 16.666667%;max-width:16.666667%}.col-sm-auto{-ms-flex:0 0 auto;flex:0 0 auto;width:auto;max-width:100%}.col-sm-1{-ms-flex:0 0 8.333333%;flex:0 0 8.333333%;max-width:8.333333%}.col-sm-2{-ms-flex:0 0 16.666667%;flex:0 0 16.666667%;max-width:16.666667%}.col-sm-3{-ms-flex:0 0 25%;flex:0 0 25%;max-width:25%}.col-sm-4{-ms-flex:0 0 33.333333%;flex:0 0 33.333333%;max-width:33.333333%}.col-sm-5{-ms-flex:0 0 41.666667%;flex:0 0 41.666667%;max-width:41.666667%}.col-sm-6{-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%}.col-sm-7{-ms-flex:0 0 58.333333%;flex:0 0 58.333333%;max-width:58.333333%}.col-sm-8{-ms-flex:0 0 66.666667%;flex:0 0 66.666667%;max-width:66.666667%}.col-sm-9{-ms-flex:0 0 75%;flex:0 0 75%;max-width:75%}.col-sm-10{-ms-flex:0 0 83.333333%;flex:0 0 83.333333%;max-width:83.333333%}.col-sm-11{-ms-flex:0 0 91.666667%;flex:0 0 91.666667%;max-width:91.666667%}.col-sm-12{-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%}.order-sm-first{-ms-flex-order:-1;order:-1}.order-sm-last{-ms-flex-order:13;order:13}.order-sm-0{-ms-flex-order:0;order:0}.order-sm-1{-ms-flex-order:1;order:1}.order-sm-2{-ms-flex-order:2;order:2}.order-sm-3{-ms-flex-order:3;order:3}.order-sm-4{-ms-flex-order:4;order:4}.order-sm-5{-ms-flex-order:5;order:5}.order-sm-6{-ms-flex-order:6;order:6}.order-sm-7{-ms-flex-order:7;order:7}.order-sm-8{-ms-flex-order:8;order:8}.order-sm-9{-ms-flex-order:9;order:9}.order-sm-10{-ms-flex-order:10;order:10}.order-sm-11{-ms-flex-order:11;order:11}.order-sm-12{-ms-flex-order:12;order:12}.offset-sm-0{margin-left:0}.offset-sm-1{margin-left:8.333333%}.offset-sm-2{margin-left:16.666667%}.offset-sm-3{margin-left:25%}.offset-sm-4{margin-left:33.333333%}.offset-sm-5{margin-left:41.666667%}.offset-sm-6{margin-left:50%}.offset-sm-7{margin-left:58.333333%}.offset-sm-8{margin-left:66.666667%}.offset-sm-9{margin-left:75%}.offset-sm-10{margin-left:83.333333%}.offset-sm-11{margin-left:91.666667%}}@media(min-width:768px){.col-md{-ms-flex-preferred-size:0;flex-basis:0;-ms-flex-positive:1;flex-grow:1;min-width:0;max-width:100%}.row-cols-md-1>*{-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%}.row-cols-md-2>*{-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%}.row-cols-md-3>*{-ms-flex:0 0 33.333333%;flex:0 0 33.333333%;max-width:33.333333%}.row-cols-md-4>*{-ms-flex:0 0 25%;flex:0 0 25%;max-width:25%}.row-cols-md-5>*{-ms-flex:0 0 20%;flex:0 0 20%;max-width:20%}.row-cols-md-6>*{-ms-flex:0 0 16.666667%;flex:0 0 16.666667%;max-width:16.666667%}.col-md-auto{-ms-flex:0 0 auto;flex:0 0 auto;width:auto;max-width:100%}.col-md-1{-ms-flex:0 0 8.333333%;flex:0 0 8.333333%;max-width:8.333333%}.col-md-2{-ms-flex:0 0 16.666667%;flex:0 0 16.666667%;max-width:16.666667%}.col-md-3{-ms-flex:0 0 25%;flex:0 0 25%;max-width:25%}.col-md-4{-ms-flex:0 0 33.333333%;flex:0 0 33.333333%;max-width:33.333333%}.col-md-5{-ms-flex:0 0 41.666667%;flex:0 0 41.666667%;max-width:41.666667%}.col-md-6{-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%}.col-md-7{-ms-flex:0 0 58.333333%;flex:0 0 58.333333%;max-width:58.333333%}.col-md-8{-ms-flex:0 0 66.666667%;flex:0 0 66.666667%;max-width:66.666667%}.col-md-9{-ms-flex:0 0 75%;flex:0 0 75%;max-width:75%}.col-md-10{-ms-flex:0 0 83.333333%;flex:0 0 83.333333%;max-width:83.333333%}.col-md-11{-ms-flex:0 0 91.666667%;flex:0 0 91.666667%;max-width:91.666667%}.col-md-12{-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%}.order-md-first{-ms-flex-order:-1;order:-1}.order-md-last{-ms-flex-order:13;order:13}.order-md-0{-ms-flex-order:0;order:0}.order-md-1{-ms-flex-order:1;order:1}.order-md-2{-ms-flex-order:2;order:2}.order-md-3{-ms-flex-order:3;order:3}.order-md-4{-ms-flex-order:4;order:4}.order-md-5{-ms-flex-order:5;order:5}.order-md-6{-ms-flex-order:6;order:6}.order-md-7{-ms-flex-order:7;order:7}.order-md-8{-ms-flex-order:8;order:8}.order-md-9{-ms-flex-order:9;order:9}.order-md-10{-ms-flex-order:10;order:10}.order-md-11{-ms-flex-order:11;order:11}.order-md-12{-ms-flex-order:12;order:12}.offset-md-0{margin-left:0}.offset-md-1{margin-left:8.333333%}.offset-md-2{margin-left:16.666667%}.offset-md-3{margin-left:25%}.offset-md-4{margin-left:33.333333%}.offset-md-5{margin-left:41.666667%}.offset-md-6{margin-left:50%}.offset-md-7{margin-left:58.333333%}.offset-md-8{margin-left:66.666667%}.offset-md-9{margin-left:75%}.offset-md-10{margin-left:83.333333%}.offset-md-11{margin-left:91.666667%}}@media(min-width:992px){.col-lg{-ms-flex-preferred-size:0;flex-basis:0;-ms-flex-positive:1;flex-grow:1;min-width:0;max-width:100%}.row-cols-lg-1>*{-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%}.row-cols-lg-2>*{-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%}.row-cols-lg-3>*{-ms-flex:0 0 33.333333%;flex:0 0 33.333333%;max-width:33.333333%}.row-cols-lg-4>*{-ms-flex:0 0 25%;flex:0 0 25%;max-width:25%}.row-cols-lg-5>*{-ms-flex:0 0 20%;flex:0 0 20%;max-width:20%}.row-cols-lg-6>*{-ms-flex:0 0 16.666667%;flex:0 0 16.666667%;max-width:16.666667%}.col-lg-auto{-ms-flex:0 0 auto;flex:0 0 auto;width:auto;max-width:100%}.col-lg-1{-ms-flex:0 0 8.333333%;flex:0 0 8.333333%;max-width:8.333333%}.col-lg-2{-ms-flex:0 0 16.666667%;flex:0 0 16.666667%;max-width:16.666667%}.col-lg-3{-ms-flex:0 0 25%;flex:0 0 25%;max-width:25%}.col-lg-4{-ms-flex:0 0 33.333333%;flex:0 0 33.333333%;max-width:33.333333%}.col-lg-5{-ms-flex:0 0 41.666667%;flex:0 0 41.666667%;max-width:41.666667%}.col-lg-6{-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%}.col-lg-7{-ms-flex:0 0 58.333333%;flex:0 0 58.333333%;max-width:58.333333%}.col-lg-8{-ms-flex:0 0 66.666667%;flex:0 0 66.666667%;max-width:66.666667%}.col-lg-9{-ms-flex:0 0 75%;flex:0 0 75%;max-width:75%}.col-lg-10{-ms-flex:0 0 83.333333%;flex:0 0 83.333333%;max-width:83.333333%}.col-lg-11{-ms-flex:0 0 91.666667%;flex:0 0 91.666667%;max-width:91.666667%}.col-lg-12{-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%}.order-lg-first{-ms-flex-order:-1;order:-1}.order-lg-last{-ms-flex-order:13;order:13}.order-lg-0{-ms-flex-order:0;order:0}.order-lg-1{-ms-flex-order:1;order:1}.order-lg-2{-ms-flex-order:2;order:2}.order-lg-3{-ms-flex-order:3;order:3}.order-lg-4{-ms-flex-order:4;order:4}.order-lg-5{-ms-flex-order:5;order:5}.order-lg-6{-ms-flex-order:6;order:6}.order-lg-7{-ms-flex-order:7;order:7}.order-lg-8{-ms-flex-order:8;order:8}.order-lg-9{-ms-flex-order:9;order:9}.order-lg-10{-ms-flex-order:10;order:10}.order-lg-11{-ms-flex-order:11;order:11}.order-lg-12{-ms-flex-order:12;order:12}.offset-lg-0{margin-left:0}.offset-lg-1{margin-left:8.333333%}.offset-lg-2{margin-left:16.666667%}.offset-lg-3{margin-left:25%}.offset-lg-4{margin-left:33.333333%}.offset-lg-5{margin-left:41.666667%}.offset-lg-6{margin-left:50%}.offset-lg-7{margin-left:58.333333%}.offset-lg-8{margin-left:66.666667%}.offset-lg-9{margin-left:75%}.offset-lg-10{margin-left:83.333333%}.offset-lg-11{margin-left:91.666667%}}@media(min-width:1200px){.col-xl{-ms-flex-preferred-size:0;flex-basis:0;-ms-flex-positive:1;flex-grow:1;min-width:0;max-width:100%}.row-cols-xl-1>*{-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%}.row-cols-xl-2>*{-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%}.row-cols-xl-3>*{-ms-flex:0 0 33.333333%;flex:0 0 33.333333%;max-width:33.333333%}.row-cols-xl-4>*{-ms-flex:0 0 25%;flex:0 0 25%;max-width:25%}.row-cols-xl-5>*{-ms-flex:0 0 20%;flex:0 0 20%;max-width:20%}.row-cols-xl-6>*{-ms-flex:0 0 16.666667%;flex:0 0 16.666667%;max-width:16.666667%}.col-xl-auto{-ms-flex:0 0 auto;flex:0 0 auto;width:auto;max-width:100%}.col-xl-1{-ms-flex:0 0 8.333333%;flex:0 0 8.333333%;max-width:8.333333%}.col-xl-2{-ms-flex:0 0 16.666667%;flex:0 0 16.666667%;max-width:16.666667%}.col-xl-3{-ms-flex:0 0 25%;flex:0 0 25%;max-width:25%}.col-xl-4{-ms-flex:0 0 33.333333%;flex:0 0 33.333333%;max-width:33.333333%}.col-xl-5{-ms-flex:0 0 41.666667%;flex:0 0 41.666667%;max-width:41.666667%}.col-xl-6{-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%}.col-xl-7{-ms-flex:0 0 58.333333%;flex:0 0 58.333333%;max-width:58.333333%}.col-xl-8{-ms-flex:0 0 66.666667%;flex:0 0 66.666667%;max-width:66.666667%}.col-xl-9{-ms-flex:0 0 75%;flex:0 0 75%;max-width:75%}.col-xl-10{-ms-flex:0 0 83.333333%;flex:0 0 83.333333%;max-width:83.333333%}.col-xl-11{-ms-flex:0 0 91.666667%;flex:0 0 91.666667%;max-width:91.666667%}.col-xl-12{-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%}.order-xl-first{-ms-flex-order:-1;order:-1}.order-xl-last{-ms-flex-order:13;order:13}.order-xl-0{-ms-flex-order:0;order:0}.order-xl-1{-ms-flex-order:1;order:1}.order-xl-2{-ms-flex-order:2;order:2}.order-xl-3{-ms-flex-order:3;order:3}.order-xl-4{-ms-flex-order:4;order:4}.order-xl-5{-ms-flex-order:5;order:5}.order-xl-6{-ms-flex-order:6;order:6}.order-xl-7{-ms-flex-order:7;order:7}.order-xl-8{-ms-flex-order:8;order:8}.order-xl-9{-ms-flex-order:9;order:9}.order-xl-10{-ms-flex-order:10;order:10}.order-xl-11{-ms-flex-order:11;order:11}.order-xl-12{-ms-flex-order:12;order:12}.offset-xl-0{margin-left:0}.offset-xl-1{margin-left:8.333333%}.offset-xl-2{margin-left:16.666667%}.offset-xl-3{margin-left:25%}.offset-xl-4{margin-left:33.333333%}.offset-xl-5{margin-left:41.666667%}.offset-xl-6{margin-left:50%}.offset-xl-7{margin-left:58.333333%}.offset-xl-8{margin-left:66.666667%}.offset-xl-9{margin-left:75%}.offset-xl-10{margin-left:83.333333%}.offset-xl-11{margin-left:91.666667%}}.table{width:100%;margin-bottom:1rem;color:#212529}.table td,.table th{padding:.75rem;vertical-align:top;border-top:1px solid #dee2e6}.table thead th{vertical-align:bottom;border-bottom:2px solid #dee2e6}.table tbody+tbody{border-top:2px solid #dee2e6}.table-sm td,.table-sm th{padding:.3rem}.table-bordered{border:1px solid #dee2e6}.table-bordered td,.table-bordered th{border:1px solid #dee2e6}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-borderless tbody+tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0}.table-striped tbody tr:nth-of-type(odd){background-color:rgba(0,0,0,.05)}.table-hover tbody tr:hover{color:#212529;background-color:rgba(0,0,0,.075)}.table-primary,.table-primary>td,.table-primary>th{background-color:#b8daff}.table-primary tbody+tbody,.table-primary td,.table-primary th,.table-primary thead th{border-color:#7abaff}.table-hover .table-primary:hover{background-color:#9fcdff}.table-hover .table-primary:hover>td,.table-hover .table-primary:hover>th{background-color:#9fcdff}.table-secondary,.table-secondary>td,.table-secondary>th{background-color:#d6d8db}.table-secondary tbody+tbody,.table-secondary td,.table-secondary th,.table-secondary thead th{border-color:#b3b7bb}.table-hover .table-secondary:hover{background-color:#c8cbcf}.table-hover .table-secondary:hover>td,.table-hover .table-secondary:hover>th{background-color:#c8cbcf}.table-success,.table-success>td,.table-success>th{background-color:#c3e6cb}.table-success tbody+tbody,.table-success td,.table-success th,.table-success thead th{border-color:#8fd19e}.table-hover .table-success:hover{background-color:#b1dfbb}.table-hover .table-success:hover>td,.table-hover .table-success:hover>th{background-color:#b1dfbb}.table-info,.table-info>td,.table-info>th{background-color:#bee5eb}.table-info tbody+tbody,.table-info td,.table-info th,.table-info thead th{border-color:#86cfda}.table-hover .table-info:hover{background-color:#abdde5}.table-hover .table-info:hover>td,.table-hover .table-info:hover>th{background-color:#abdde5}.table-warning,.table-warning>td,.table-warning>th{background-color:#ffeeba}.table-warning tbody+tbody,.table-warning td,.table-warning th,.table-warning thead th{border-color:#ffdf7e}.table-hover .table-warning:hover{background-color:#ffe8a1}.table-hover .table-warning:hover>td,.table-hover .table-warning:hover>th{background-color:#ffe8a1}.table-danger,.table-danger>td,.table-danger>th{background-color:#f5c6cb}.table-danger tbody+tbody,.table-danger td,.table-danger th,.table-danger thead th{border-color:#ed969e}.table-hover .table-danger:hover{background-color:#f1b0b7}.table-hover .table-danger:hover>td,.table-hover .table-danger:hover>th{background-color:#f1b0b7}.table-light,.table-light>td,.table-light>th{background-color:#fdfdfe}.table-light tbody+tbody,.table-light td,.table-light th,.table-light thead th{border-color:#fbfcfc}.table-hover .table-light:hover{background-color:#ececf6}.table-hover .table-light:hover>td,.table-hover .table-light:hover>th{background-color:#ececf6}.table-dark,.table-dark>td,.table-dark>th{background-color:#c6c8ca}.table-dark tbody+tbody,.table-dark td,.table-dark th,.table-dark thead th{border-color:#95999c}.table-hover .table-dark:hover{background-color:#b9bbbe}.table-hover .table-dark:hover>td,.table-hover .table-dark:hover>th{background-color:#b9bbbe}.table-active,.table-active>td,.table-active>th{background-color:rgba(0,0,0,.075)}.table-hover .table-active:hover{background-color:rgba(0,0,0,.075)}.table-hover .table-active:hover>td,.table-hover .table-active:hover>th{background-color:rgba(0,0,0,.075)}.table .thead-dark th{color:#fff;background-color:#343a40;border-color:#454d55}.table .thead-light th{color:#495057;background-color:#e9ecef;border-color:#dee2e6}.table-dark{color:#fff;background-color:#343a40}.table-dark td,.table-dark th,.table-dark thead th{border-color:#454d55}.table-dark.table-bordered{border:0}.table-dark.table-striped tbody tr:nth-of-type(odd){background-color:rgba(255,255,255,.05)}.table-dark.table-hover tbody tr:hover{color:#fff;background-color:rgba(255,255,255,.075)}@media(max-width:575.98px){.table-responsive-sm{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch}.table-responsive-sm>.table-bordered{border:0}}@media(max-width:767.98px){.table-responsive-md{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch}.table-responsive-md>.table-bordered{border:0}}@media(max-width:991.98px){.table-responsive-lg{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch}.table-responsive-lg>.table-bordered{border:0}}@media(max-width:1199.98px){.table-responsive-xl{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch}.table-responsive-xl>.table-bordered{border:0}}.table-responsive{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch}.table-responsive>.table-bordered{border:0}.form-control{display:block;width:100%;height:calc(1.5em+.75rem+2px);padding:.375rem .75rem;font-size:1rem;font-weight:400;line-height:1.5;color:#495057;background-color:#fff;background-clip:padding-box;border:1px solid #ced4da;border-radius:.25rem;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out}@media(prefers-reduced-motion:reduce){.form-control{transition:none}}.form-control::-ms-expand{background-color:transparent;border:0}.form-control:-moz-focusring{color:transparent;text-shadow:0 0 0 #495057}.form-control:focus{color:#495057;background-color:#fff;border-color:#80bdff;outline:0;box-shadow:0 0 0 .2rem rgba(0,123,255,.25)}.form-control::-webkit-input-placeholder{color:#6c757d;opacity:1}.form-control::-moz-placeholder{color:#6c757d;opacity:1}.form-control:-ms-input-placeholder{color:#6c757d;opacity:1}.form-control::-ms-input-placeholder{color:#6c757d;opacity:1}.form-control::placeholder{color:#6c757d;opacity:1}.form-control:disabled,.form-control[readonly]{background-color:#e9ecef;opacity:1}input[type=date].form-control,input[type=datetime-local].form-control,input[type=month].form-control,input[type=time].form-control{-webkit-appearance:none;-moz-appearance:none;appearance:none}select.form-control:focus::-ms-value{color:#495057;background-color:#fff}.form-control-file,.form-control-range{display:block;width:100%}.col-form-label{padding-top:calc(.375rem+1px);padding-bottom:calc(.375rem+1px);margin-bottom:0;font-size:inherit;line-height:1.5}.col-form-label-lg{padding-top:calc(.5rem+1px);padding-bottom:calc(.5rem+1px);font-size:1.25rem;line-height:1.5}.col-form-label-sm{padding-top:calc(.25rem+1px);padding-bottom:calc(.25rem+1px);font-size:.875rem;line-height:1.5}.form-control-plaintext{display:block;width:100%;padding:.375rem 0;margin-bottom:0;font-size:1rem;line-height:1.5;color:#212529;background-color:transparent;border:solid transparent;border-width:1px 0}.form-control-plaintext.form-control-lg,.form-control-plaintext.form-control-sm{padding-right:0;padding-left:0}.form-control-sm{height:calc(1.5em+.5rem+2px);padding:.25rem .5rem;font-size:.875rem;line-height:1.5;border-radius:.2rem}.form-control-lg{height:calc(1.5em+1rem+2px);padding:.5rem 1rem;font-size:1.25rem;line-height:1.5;border-radius:.3rem}select.form-control[multiple],select.form-control[size]{height:auto}textarea.form-control{height:auto}.form-group{margin-bottom:1rem}.form-text{display:block;margin-top:.25rem}.form-row{display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-5px;margin-left:-5px}.form-row>.col,.form-row>[class*=col-]{padding-right:5px;padding-left:5px}.form-check{position:relative;display:block;padding-left:1.25rem}.form-check-input{position:absolute;margin-top:.3rem;margin-left:-1.25rem}.form-check-input:disabled~.form-check-label,.form-check-input[disabled]~.form-check-label{color:#6c757d}.form-check-label{margin-bottom:0}.form-check-inline{display:-ms-inline-flexbox;display:inline-flex;-ms-flex-align:center;align-items:center;padding-left:0;margin-right:.75rem}.form-check-inline .form-check-input{position:static;margin-top:0;margin-right:.3125rem;margin-left:0}.valid-feedback{display:none;width:100%;margin-top:.25rem;font-size:80%;color:#28a745}.valid-tooltip{position:absolute;top:100%;z-index:5;display:none;max-width:100%;padding:.25rem .5rem;margin-top:.1rem;font-size:.875rem;line-height:1.5;color:#fff;background-color:rgba(40,167,69,.9);border-radius:.25rem}.is-valid~.valid-feedback,.is-valid~.valid-tooltip,.was-validated :valid~.valid-feedback,.was-validated :valid~.valid-tooltip{display:block}.form-control.is-valid,.was-validated .form-control:valid{border-color:#28a745;padding-right:calc(1.5em+.75rem);background-image:url("data:image/svg+xml,%3csvgxmlns='http://www.w3.org/2000/svg'width='8'height='8'viewBox='0088'%3e%3cpathfill='%2328a745'd='M2.36.73L.64.53c-.4-1.04.46-1.41.1-.8l1.11.43.4-3.8c.6-.631.6-.271.2.7l-44.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");background-repeat:no-repeat;background-position:right calc(.375em+.1875rem) center;background-size:calc(.75em+.375rem) calc(.75em+.375rem)}.form-control.is-valid:focus,.was-validated .form-control:valid:focus{border-color:#28a745;box-shadow:0 0 0 .2rem rgba(40,167,69,.25)}.was-validated textarea.form-control:valid,textarea.form-control.is-valid{padding-right:calc(1.5em+.75rem);background-position:top calc(.375em+.1875rem) right calc(.375em+.1875rem)}.custom-select.is-valid,.was-validated .custom-select:valid{border-color:#28a745;padding-right:calc(.75em+2.3125rem);background:url("data:image/svg+xml,%3csvgxmlns='http://www.w3.org/2000/svg'width='4'height='5'viewBox='0045'%3e%3cpathfill='%23343a40'd='M20L02h4zm05L03h4z'/%3e%3c/svg%3e") no-repeat right .75rem center/8px 10px,url("data:image/svg+xml,%3csvgxmlns='http://www.w3.org/2000/svg'width='8'height='8'viewBox='0088'%3e%3cpathfill='%2328a745'd='M2.36.73L.64.53c-.4-1.04.46-1.41.1-.8l1.11.43.4-3.8c.6-.631.6-.271.2.7l-44.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e") #fff no-repeat center right 1.75rem/calc(.75em+.375rem) calc(.75em+.375rem)}.custom-select.is-valid:focus,.was-validated .custom-select:valid:focus{border-color:#28a745;box-shadow:0 0 0 .2rem rgba(40,167,69,.25)}.form-check-input.is-valid~.form-check-label,.was-validated .form-check-input:valid~.form-check-label{color:#28a745}.form-check-input.is-valid~.valid-feedback,.form-check-input.is-valid~.valid-tooltip,.was-validated .form-check-input:valid~.valid-feedback,.was-validated .form-check-input:valid~.valid-tooltip{display:block}.custom-control-input.is-valid~.custom-control-label,.was-validated .custom-control-input:valid~.custom-control-label{color:#28a745}.custom-control-input.is-valid~.custom-control-label::before,.was-validated .custom-control-input:valid~.custom-control-label::before{border-color:#28a745}.custom-control-input.is-valid:checked~.custom-control-label::before,.was-validated .custom-control-input:valid:checked~.custom-control-label::before{border-color:#34ce57;background-color:#34ce57}.custom-control-input.is-valid:focus~.custom-control-label::before,.was-validated .custom-control-input:valid:focus~.custom-control-label::before{box-shadow:0 0 0 .2rem rgba(40,167,69,.25)}.custom-control-input.is-valid:focus:not(:checked)~.custom-control-label::before,.was-validated .custom-control-input:valid:focus:not(:checked)~.custom-control-label::before{border-color:#28a745}.custom-file-input.is-valid~.custom-file-label,.was-validated .custom-file-input:valid~.custom-file-label{border-color:#28a745}.custom-file-input.is-valid:focus~.custom-file-label,.was-validated .custom-file-input:valid:focus~.custom-file-label{border-color:#28a745;box-shadow:0 0 0 .2rem rgba(40,167,69,.25)}.invalid-feedback{display:none;width:100%;margin-top:.25rem;font-size:80%;color:#dc3545}.invalid-tooltip{position:absolute;top:100%;z-index:5;display:none;max-width:100%;padding:.25rem .5rem;margin-top:.1rem;font-size:.875rem;line-height:1.5;color:#fff;background-color:rgba(220,53,69,.9);border-radius:.25rem}.is-invalid~.invalid-feedback,.is-invalid~.invalid-tooltip,.was-validated :invalid~.invalid-feedback,.was-validated :invalid~.invalid-tooltip{display:block}.form-control.is-invalid,.was-validated .form-control:invalid{border-color:#dc3545;padding-right:calc(1.5em+.75rem);background-image:url("data:image/svg+xml,%3csvgxmlns='http://www.w3.org/2000/svg'width='12'height='12'fill='none'stroke='%23dc3545'viewBox='001212'%3e%3ccirclecx='6'cy='6'r='4.5'/%3e%3cpathstroke-linejoin='round'd='M5.83.6h.4L66.5z'/%3e%3ccirclecx='6'cy='8.2'r='.6'fill='%23dc3545'stroke='none'/%3e%3c/svg%3e");background-repeat:no-repeat;background-position:right calc(.375em+.1875rem) center;background-size:calc(.75em+.375rem) calc(.75em+.375rem)}.form-control.is-invalid:focus,.was-validated .form-control:invalid:focus{border-color:#dc3545;box-shadow:0 0 0 .2rem rgba(220,53,69,.25)}.was-validated textarea.form-control:invalid,textarea.form-control.is-invalid{padding-right:calc(1.5em+.75rem);background-position:top calc(.375em+.1875rem) right calc(.375em+.1875rem)}.custom-select.is-invalid,.was-validated .custom-select:invalid{border-color:#dc3545;padding-right:calc(.75em+2.3125rem);background:url("data:image/svg+xml,%3csvgxmlns='http://www.w3.org/2000/svg'width='4'height='5'viewBox='0045'%3e%3cpathfill='%23343a40'd='M20L02h4zm05L03h4z'/%3e%3c/svg%3e") no-repeat right .75rem center/8px 10px,url("data:image/svg+xml,%3csvgxmlns='http://www.w3.org/2000/svg'width='12'height='12'fill='none'stroke='%23dc3545'viewBox='001212'%3e%3ccirclecx='6'cy='6'r='4.5'/%3e%3cpathstroke-linejoin='round'd='M5.83.6h.4L66.5z'/%3e%3ccirclecx='6'cy='8.2'r='.6'fill='%23dc3545'stroke='none'/%3e%3c/svg%3e") #fff no-repeat center right 1.75rem/calc(.75em+.375rem) calc(.75em+.375rem)}.custom-select.is-invalid:focus,.was-validated .custom-select:invalid:focus{border-color:#dc3545;box-shadow:0 0 0 .2rem rgba(220,53,69,.25)}.form-check-input.is-invalid~.form-check-label,.was-validated .form-check-input:invalid~.form-check-label{color:#dc3545}.form-check-input.is-invalid~.invalid-feedback,.form-check-input.is-invalid~.invalid-tooltip,.was-validated .form-check-input:invalid~.invalid-feedback,.was-validated .form-check-input:invalid~.invalid-tooltip{display:block}.custom-control-input.is-invalid~.custom-control-label,.was-validated .custom-control-input:invalid~.custom-control-label{color:#dc3545}.custom-control-input.is-invalid~.custom-control-label::before,.was-validated .custom-control-input:invalid~.custom-control-label::before{border-color:#dc3545}.custom-control-input.is-invalid:checked~.custom-control-label::before,.was-validated .custom-control-input:invalid:checked~.custom-control-label::before{border-color:#e4606d;background-color:#e4606d}.custom-control-input.is-invalid:focus~.custom-control-label::before,.was-validated .custom-control-input:invalid:focus~.custom-control-label::before{box-shadow:0 0 0 .2rem rgba(220,53,69,.25)}.custom-control-input.is-invalid:focus:not(:checked)~.custom-control-label::before,.was-validated .custom-control-input:invalid:focus:not(:checked)~.custom-control-label::before{border-color:#dc3545}.custom-file-input.is-invalid~.custom-file-label,.was-validated .custom-file-input:invalid~.custom-file-label{border-color:#dc3545}.custom-file-input.is-invalid:focus~.custom-file-label,.was-validated .custom-file-input:invalid:focus~.custom-file-label{border-color:#dc3545;box-shadow:0 0 0 .2rem rgba(220,53,69,.25)}.form-inline{display:-ms-flexbox;display:flex;-ms-flex-flow:row wrap;flex-flow:row wrap;-ms-flex-align:center;align-items:center}.form-inline .form-check{width:100%}@media(min-width:576px){.form-inline label{display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;-ms-flex-pack:center;justify-content:center;margin-bottom:0}.form-inline .form-group{display:-ms-flexbox;display:flex;-ms-flex:0 0 auto;flex:0 0 auto;-ms-flex-flow:row wrap;flex-flow:row wrap;-ms-flex-align:center;align-items:center;margin-bottom:0}.form-inline .form-control{display:inline-block;width:auto;vertical-align:middle}.form-inline .form-control-plaintext{display:inline-block}.form-inline .custom-select,.form-inline .input-group{width:auto}.form-inline .form-check{display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;-ms-flex-pack:center;justify-content:center;width:auto;padding-left:0}.form-inline .form-check-input{position:relative;-ms-flex-negative:0;flex-shrink:0;margin-top:0;margin-right:.25rem;margin-left:0}.form-inline .custom-control{-ms-flex-align:center;align-items:center;-ms-flex-pack:center;justify-content:center}.form-inline .custom-control-label{margin-bottom:0}}.btn{display:inline-block;font-weight:400;color:#212529;text-align:center;vertical-align:middle;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;background-color:transparent;border:1px solid transparent;padding:.375rem .75rem;font-size:1rem;line-height:1.5;border-radius:.25rem;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out}@media(prefers-reduced-motion:reduce){.btn{transition:none}}.btn:hover{color:#212529;text-decoration:none}.btn.focus,.btn:focus{outline:0;box-shadow:0 0 0 .2rem rgba(0,123,255,.25)}.btn.disabled,.btn:disabled{opacity:.65}.btn:not(:disabled):not(.disabled){cursor:pointer}a.btn.disabled,fieldset:disabled a.btn{pointer-events:none}.btn-primary{color:#fff;background-color:#007bff;border-color:#007bff}.btn-primary:hover{color:#fff;background-color:#0069d9;border-color:#0062cc}.btn-primary.focus,.btn-primary:focus{color:#fff;background-color:#0069d9;border-color:#0062cc;box-shadow:0 0 0 .2rem rgba(38,143,255,.5)}.btn-primary.disabled,.btn-primary:disabled{color:#fff;background-color:#007bff;border-color:#007bff}.btn-primary:not(:disabled):not(.disabled).active,.btn-primary:not(:disabled):not(.disabled):active,.show>.btn-primary.dropdown-toggle{color:#fff;background-color:#0062cc;border-color:#005cbf}.btn-primary:not(:disabled):not(.disabled).active:focus,.btn-primary:not(:disabled):not(.disabled):active:focus,.show>.btn-primary.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(38,143,255,.5)}.btn-secondary{color:#fff;background-color:#6c757d;border-color:#6c757d}.btn-secondary:hover{color:#fff;background-color:#5a6268;border-color:#545b62}.btn-secondary.focus,.btn-secondary:focus{color:#fff;background-color:#5a6268;border-color:#545b62;box-shadow:0 0 0 .2rem rgba(130,138,145,.5)}.btn-secondary.disabled,.btn-secondary:disabled{color:#fff;background-color:#6c757d;border-color:#6c757d}.btn-secondary:not(:disabled):not(.disabled).active,.btn-secondary:not(:disabled):not(.disabled):active,.show>.btn-secondary.dropdown-toggle{color:#fff;background-color:#545b62;border-color:#4e555b}.btn-secondary:not(:disabled):not(.disabled).active:focus,.btn-secondary:not(:disabled):not(.disabled):active:focus,.show>.btn-secondary.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(130,138,145,.5)}.btn-success{color:#fff;background-color:#28a745;border-color:#28a745}.btn-success:hover{color:#fff;background-color:#218838;border-color:#1e7e34}.btn-success.focus,.btn-success:focus{color:#fff;background-color:#218838;border-color:#1e7e34;box-shadow:0 0 0 .2rem rgba(72,180,97,.5)}.btn-success.disabled,.btn-success:disabled{color:#fff;background-color:#28a745;border-color:#28a745}.btn-success:not(:disabled):not(.disabled).active,.btn-success:not(:disabled):not(.disabled):active,.show>.btn-success.dropdown-toggle{color:#fff;background-color:#1e7e34;border-color:#1c7430}.btn-success:not(:disabled):not(.disabled).active:focus,.btn-success:not(:disabled):not(.disabled):active:focus,.show>.btn-success.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(72,180,97,.5)}.btn-info{color:#fff;background-color:#17a2b8;border-color:#17a2b8}.btn-info:hover{color:#fff;background-color:#138496;border-color:#117a8b}.btn-info.focus,.btn-info:focus{color:#fff;background-color:#138496;border-color:#117a8b;box-shadow:0 0 0 .2rem rgba(58,176,195,.5)}.btn-info.disabled,.btn-info:disabled{color:#fff;background-color:#17a2b8;border-color:#17a2b8}.btn-info:not(:disabled):not(.disabled).active,.btn-info:not(:disabled):not(.disabled):active,.show>.btn-info.dropdown-toggle{color:#fff;background-color:#117a8b;border-color:#10707f}.btn-info:not(:disabled):not(.disabled).active:focus,.btn-info:not(:disabled):not(.disabled):active:focus,.show>.btn-info.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(58,176,195,.5)}.btn-warning{color:#212529;background-color:#ffc107;border-color:#ffc107}.btn-warning:hover{color:#212529;background-color:#e0a800;border-color:#d39e00}.btn-warning.focus,.btn-warning:focus{color:#212529;background-color:#e0a800;border-color:#d39e00;box-shadow:0 0 0 .2rem rgba(222,170,12,.5)}.btn-warning.disabled,.btn-warning:disabled{color:#212529;background-color:#ffc107;border-color:#ffc107}.btn-warning:not(:disabled):not(.disabled).active,.btn-warning:not(:disabled):not(.disabled):active,.show>.btn-warning.dropdown-toggle{color:#212529;background-color:#d39e00;border-color:#c69500}.btn-warning:not(:disabled):not(.disabled).active:focus,.btn-warning:not(:disabled):not(.disabled):active:focus,.show>.btn-warning.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(222,170,12,.5)}.btn-danger{color:#fff;background-color:#dc3545;border-color:#dc3545}.btn-danger:hover{color:#fff;background-color:#c82333;border-color:#bd2130}.btn-danger.focus,.btn-danger:focus{color:#fff;background-color:#c82333;border-color:#bd2130;box-shadow:0 0 0 .2rem rgba(225,83,97,.5)}.btn-danger.disabled,.btn-danger:disabled{color:#fff;background-color:#dc3545;border-color:#dc3545}.btn-danger:not(:disabled):not(.disabled).active,.btn-danger:not(:disabled):not(.disabled):active,.show>.btn-danger.dropdown-toggle{color:#fff;background-color:#bd2130;border-color:#b21f2d}.btn-danger:not(:disabled):not(.disabled).active:focus,.btn-danger:not(:disabled):not(.disabled):active:focus,.show>.btn-danger.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(225,83,97,.5)}.btn-light{color:#212529;background-color:#f8f9fa;border-color:#f8f9fa}.btn-light:hover{color:#212529;background-color:#e2e6ea;border-color:#dae0e5}.btn-light.focus,.btn-light:focus{color:#212529;background-color:#e2e6ea;border-color:#dae0e5;box-shadow:0 0 0 .2rem rgba(216,217,219,.5)}.btn-light.disabled,.btn-light:disabled{color:#212529;background-color:#f8f9fa;border-color:#f8f9fa}.btn-light:not(:disabled):not(.disabled).active,.btn-light:not(:disabled):not(.disabled):active,.show>.btn-light.dropdown-toggle{color:#212529;background-color:#dae0e5;border-color:#d3d9df}.btn-light:not(:disabled):not(.disabled).active:focus,.btn-light:not(:disabled):not(.disabled):active:focus,.show>.btn-light.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(216,217,219,.5)}.btn-dark{color:#fff;background-color:#343a40;border-color:#343a40}.btn-dark:hover{color:#fff;background-color:#23272b;border-color:#1d2124}.btn-dark.focus,.btn-dark:focus{color:#fff;background-color:#23272b;border-color:#1d2124;box-shadow:0 0 0 .2rem rgba(82,88,93,.5)}.btn-dark.disabled,.btn-dark:disabled{color:#fff;background-color:#343a40;border-color:#343a40}.btn-dark:not(:disabled):not(.disabled).active,.btn-dark:not(:disabled):not(.disabled):active,.show>.btn-dark.dropdown-toggle{color:#fff;background-color:#1d2124;border-color:#171a1d}.btn-dark:not(:disabled):not(.disabled).active:focus,.btn-dark:not(:disabled):not(.disabled):active:focus,.show>.btn-dark.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(82,88,93,.5)}.btn-outline-primary{color:#007bff;border-color:#007bff}.btn-outline-primary:hover{color:#fff;background-color:#007bff;border-color:#007bff}.btn-outline-primary.focus,.btn-outline-primary:focus{box-shadow:0 0 0 .2rem rgba(0,123,255,.5)}.btn-outline-primary.disabled,.btn-outline-primary:disabled{color:#007bff;background-color:transparent}.btn-outline-primary:not(:disabled):not(.disabled).active,.btn-outline-primary:not(:disabled):not(.disabled):active,.show>.btn-outline-primary.dropdown-toggle{color:#fff;background-color:#007bff;border-color:#007bff}.btn-outline-primary:not(:disabled):not(.disabled).active:focus,.btn-outline-primary:not(:disabled):not(.disabled):active:focus,.show>.btn-outline-primary.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(0,123,255,.5)}.btn-outline-secondary{color:#6c757d;border-color:#6c757d}.btn-outline-secondary:hover{color:#fff;background-color:#6c757d;border-color:#6c757d}.btn-outline-secondary.focus,.btn-outline-secondary:focus{box-shadow:0 0 0 .2rem rgba(108,117,125,.5)}.btn-outline-secondary.disabled,.btn-outline-secondary:disabled{color:#6c757d;background-color:transparent}.btn-outline-secondary:not(:disabled):not(.disabled).active,.btn-outline-secondary:not(:disabled):not(.disabled):active,.show>.btn-outline-secondary.dropdown-toggle{color:#fff;background-color:#6c757d;border-color:#6c757d}.btn-outline-secondary:not(:disabled):not(.disabled).active:focus,.btn-outline-secondary:not(:disabled):not(.disabled):active:focus,.show>.btn-outline-secondary.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(108,117,125,.5)}.btn-outline-success{color:#28a745;border-color:#28a745}.btn-outline-success:hover{color:#fff;background-color:#28a745;border-color:#28a745}.btn-outline-success.focus,.btn-outline-success:focus{box-shadow:0 0 0 .2rem rgba(40,167,69,.5)}.btn-outline-success.disabled,.btn-outline-success:disabled{color:#28a745;background-color:transparent}.btn-outline-success:not(:disabled):not(.disabled).active,.btn-outline-success:not(:disabled):not(.disabled):active,.show>.btn-outline-success.dropdown-toggle{color:#fff;background-color:#28a745;border-color:#28a745}.btn-outline-success:not(:disabled):not(.disabled).active:focus,.btn-outline-success:not(:disabled):not(.disabled):active:focus,.show>.btn-outline-success.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(40,167,69,.5)}.btn-outline-info{color:#17a2b8;border-color:#17a2b8}.btn-outline-info:hover{color:#fff;background-color:#17a2b8;border-color:#17a2b8}.btn-outline-info.focus,.btn-outline-info:focus{box-shadow:0 0 0 .2rem rgba(23,162,184,.5)}.btn-outline-info.disabled,.btn-outline-info:disabled{color:#17a2b8;background-color:transparent}.btn-outline-info:not(:disabled):not(.disabled).active,.btn-outline-info:not(:disabled):not(.disabled):active,.show>.btn-outline-info.dropdown-toggle{color:#fff;background-color:#17a2b8;border-color:#17a2b8}.btn-outline-info:not(:disabled):not(.disabled).active:focus,.btn-outline-info:not(:disabled):not(.disabled):active:focus,.show>.btn-outline-info.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(23,162,184,.5)}.btn-outline-warning{color:#ffc107;border-color:#ffc107}.btn-outline-warning:hover{color:#212529;background-color:#ffc107;border-color:#ffc107}.btn-outline-warning.focus,.btn-outline-warning:focus{box-shadow:0 0 0 .2rem rgba(255,193,7,.5)}.btn-outline-warning.disabled,.btn-outline-warning:disabled{color:#ffc107;background-color:transparent}.btn-outline-warning:not(:disabled):not(.disabled).active,.btn-outline-warning:not(:disabled):not(.disabled):active,.show>.btn-outline-warning.dropdown-toggle{color:#212529;background-color:#ffc107;border-color:#ffc107}.btn-outline-warning:not(:disabled):not(.disabled).active:focus,.btn-outline-warning:not(:disabled):not(.disabled):active:focus,.show>.btn-outline-warning.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(255,193,7,.5)}.btn-outline-danger{color:#dc3545;border-color:#dc3545}.btn-outline-danger:hover{color:#fff;background-color:#dc3545;border-color:#dc3545}.btn-outline-danger.focus,.btn-outline-danger:focus{box-shadow:0 0 0 .2rem rgba(220,53,69,.5)}.btn-outline-danger.disabled,.btn-outline-danger:disabled{color:#dc3545;background-color:transparent}.btn-outline-danger:not(:disabled):not(.disabled).active,.btn-outline-danger:not(:disabled):not(.disabled):active,.show>.btn-outline-danger.dropdown-toggle{color:#fff;background-color:#dc3545;border-color:#dc3545}.btn-outline-danger:not(:disabled):not(.disabled).active:focus,.btn-outline-danger:not(:disabled):not(.disabled):active:focus,.show>.btn-outline-danger.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(220,53,69,.5)}.btn-outline-light{color:#f8f9fa;border-color:#f8f9fa}.btn-outline-light:hover{color:#212529;background-color:#f8f9fa;border-color:#f8f9fa}.btn-outline-light.focus,.btn-outline-light:focus{box-shadow:0 0 0 .2rem rgba(248,249,250,.5)}.btn-outline-light.disabled,.btn-outline-light:disabled{color:#f8f9fa;background-color:transparent}.btn-outline-light:not(:disabled):not(.disabled).active,.btn-outline-light:not(:disabled):not(.disabled):active,.show>.btn-outline-light.dropdown-toggle{color:#212529;background-color:#f8f9fa;border-color:#f8f9fa}.btn-outline-light:not(:disabled):not(.disabled).active:focus,.btn-outline-light:not(:disabled):not(.disabled):active:focus,.show>.btn-outline-light.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(248,249,250,.5)}.btn-outline-dark{color:#343a40;border-color:#343a40}.btn-outline-dark:hover{color:#fff;background-color:#343a40;border-color:#343a40}.btn-outline-dark.focus,.btn-outline-dark:focus{box-shadow:0 0 0 .2rem rgba(52,58,64,.5)}.btn-outline-dark.disabled,.btn-outline-dark:disabled{color:#343a40;background-color:transparent}.btn-outline-dark:not(:disabled):not(.disabled).active,.btn-outline-dark:not(:disabled):not(.disabled):active,.show>.btn-outline-dark.dropdown-toggle{color:#fff;background-color:#343a40;border-color:#343a40}.btn-outline-dark:not(:disabled):not(.disabled).active:focus,.btn-outline-dark:not(:disabled):not(.disabled):active:focus,.show>.btn-outline-dark.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(52,58,64,.5)}.btn-link{font-weight:400;color:#007bff;text-decoration:none}.btn-link:hover{color:#0056b3;text-decoration:underline}.btn-link.focus,.btn-link:focus{text-decoration:underline}.btn-link.disabled,.btn-link:disabled{color:#6c757d;pointer-events:none}.btn-group-lg>.btn,.btn-lg{padding:.5rem 1rem;font-size:1.25rem;line-height:1.5;border-radius:.3rem}.btn-group-sm>.btn,.btn-sm{padding:.25rem .5rem;font-size:.875rem;line-height:1.5;border-radius:.2rem}.btn-block{display:block;width:100%}.btn-block+.btn-block{margin-top:.5rem}input[type=button].btn-block,input[type=reset].btn-block,input[type=submit].btn-block{width:100%}.fade{transition:opacity .15s linear}@media(prefers-reduced-motion:reduce){.fade{transition:none}}.fade:not(.show){opacity:0}.collapse:not(.show){display:none}.collapsing{position:relative;height:0;overflow:hidden;transition:height .35s ease}@media(prefers-reduced-motion:reduce){.collapsing{transition:none}}.dropdown,.dropleft,.dropright,.dropup{position:relative}.dropdown-toggle{white-space:nowrap}.dropdown-toggle::after{display:inline-block;margin-left:.255em;vertical-align:.255em;content:"";border-top:.3em solid;border-right:.3em solid transparent;border-bottom:0;border-left:.3em solid transparent}.dropdown-toggle:empty::after{margin-left:0}.dropdown-menu{position:absolute;top:100%;left:0;z-index:1000;display:none;float:left;min-width:10rem;padding:.5rem 0;margin:.125rem 0 0;font-size:1rem;color:#212529;text-align:left;list-style:none;background-color:#fff;background-clip:padding-box;border:1px solid rgba(0,0,0,.15);border-radius:.25rem}.dropdown-menu-left{right:auto;left:0}.dropdown-menu-right{right:0;left:auto}@media(min-width:576px){.dropdown-menu-sm-left{right:auto;left:0}.dropdown-menu-sm-right{right:0;left:auto}}@media(min-width:768px){.dropdown-menu-md-left{right:auto;left:0}.dropdown-menu-md-right{right:0;left:auto}}@media(min-width:992px){.dropdown-menu-lg-left{right:auto;left:0}.dropdown-menu-lg-right{right:0;left:auto}}@media(min-width:1200px){.dropdown-menu-xl-left{right:auto;left:0}.dropdown-menu-xl-right{right:0;left:auto}}.dropup .dropdown-menu{top:auto;bottom:100%;margin-top:0;margin-bottom:.125rem}.dropup .dropdown-toggle::after{display:inline-block;margin-left:.255em;vertical-align:.255em;content:"";border-top:0;border-right:.3em solid transparent;border-bottom:.3em solid;border-left:.3em solid transparent}.dropup .dropdown-toggle:empty::after{margin-left:0}.dropright .dropdown-menu{top:0;right:auto;left:100%;margin-top:0;margin-left:.125rem}.dropright .dropdown-toggle::after{display:inline-block;margin-left:.255em;vertical-align:.255em;content:"";border-top:.3em solid transparent;border-right:0;border-bottom:.3em solid transparent;border-left:.3em solid}.dropright .dropdown-toggle:empty::after{margin-left:0}.dropright .dropdown-toggle::after{vertical-align:0}.dropleft .dropdown-menu{top:0;right:100%;left:auto;margin-top:0;margin-right:.125rem}.dropleft .dropdown-toggle::after{display:inline-block;margin-left:.255em;vertical-align:.255em;content:""}.dropleft .dropdown-toggle::after{display:none}.dropleft .dropdown-toggle::before{display:inline-block;margin-right:.255em;vertical-align:.255em;content:"";border-top:.3em solid transparent;border-right:.3em solid;border-bottom:.3em solid transparent}.dropleft .dropdown-toggle:empty::after{margin-left:0}.dropleft .dropdown-toggle::before{vertical-align:0}.dropdown-menu[x-placement^=bottom],.dropdown-menu[x-placement^=left],.dropdown-menu[x-placement^=right],.dropdown-menu[x-placement^=top]{right:auto;bottom:auto}.dropdown-divider{height:0;margin:.5rem 0;overflow:hidden;border-top:1px solid #e9ecef}.dropdown-item{display:block;width:100%;padding:.25rem 1.5rem;clear:both;font-weight:400;color:#212529;text-align:inherit;white-space:nowrap;background-color:transparent;border:0}.dropdown-item:focus,.dropdown-item:hover{color:#16181b;text-decoration:none;background-color:#f8f9fa}.dropdown-item.active,.dropdown-item:active{color:#fff;text-decoration:none;background-color:#007bff}.dropdown-item.disabled,.dropdown-item:disabled{color:#6c757d;pointer-events:none;background-color:transparent}.dropdown-menu.show{display:block}.dropdown-header{display:block;padding:.5rem 1.5rem;margin-bottom:0;font-size:.875rem;color:#6c757d;white-space:nowrap}.dropdown-item-text{display:block;padding:.25rem 1.5rem;color:#212529}.btn-group,.btn-group-vertical{position:relative;display:-ms-inline-flexbox;display:inline-flex;vertical-align:middle}.btn-group-vertical>.btn,.btn-group>.btn{position:relative;-ms-flex:1 1 auto;flex:1 1 auto}.btn-group-vertical>.btn:hover,.btn-group>.btn:hover{z-index:1}.btn-group-vertical>.btn.active,.btn-group-vertical>.btn:active,.btn-group-vertical>.btn:focus,.btn-group>.btn.active,.btn-group>.btn:active,.btn-group>.btn:focus{z-index:1}.btn-toolbar{display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-ms-flex-pack:start;justify-content:flex-start}.btn-toolbar .input-group{width:auto}.btn-group>.btn-group:not(:first-child),.btn-group>.btn:not(:first-child){margin-left:-1px}.btn-group>.btn-group:not(:last-child)>.btn,.btn-group>.btn:not(:last-child):not(.dropdown-toggle){border-top-right-radius:0;border-bottom-right-radius:0}.btn-group>.btn-group:not(:first-child)>.btn,.btn-group>.btn:not(:first-child){border-top-left-radius:0;border-bottom-left-radius:0}.dropdown-toggle-split{padding-right:.5625rem;padding-left:.5625rem}.dropdown-toggle-split::after,.dropright .dropdown-toggle-split::after,.dropup .dropdown-toggle-split::after{margin-left:0}.dropleft .dropdown-toggle-split::before{margin-right:0}.btn-group-sm>.btn+.dropdown-toggle-split,.btn-sm+.dropdown-toggle-split{padding-right:.375rem;padding-left:.375rem}.btn-group-lg>.btn+.dropdown-toggle-split,.btn-lg+.dropdown-toggle-split{padding-right:.75rem;padding-left:.75rem}.btn-group-vertical{-ms-flex-direction:column;flex-direction:column;-ms-flex-align:start;align-items:flex-start;-ms-flex-pack:center;justify-content:center}.btn-group-vertical>.btn,.btn-group-vertical>.btn-group{width:100%}.btn-group-vertical>.btn-group:not(:first-child),.btn-group-vertical>.btn:not(:first-child){margin-top:-1px}.btn-group-vertical>.btn-group:not(:last-child)>.btn,.btn-group-vertical>.btn:not(:last-child):not(.dropdown-toggle){border-bottom-right-radius:0;border-bottom-left-radius:0}.btn-group-vertical>.btn-group:not(:first-child)>.btn,.btn-group-vertical>.btn:not(:first-child){border-top-left-radius:0;border-top-right-radius:0}.btn-group-toggle>.btn,.btn-group-toggle>.btn-group>.btn{margin-bottom:0}.btn-group-toggle>.btn input[type=checkbox],.btn-group-toggle>.btn input[type=radio],.btn-group-toggle>.btn-group>.btn input[type=checkbox],.btn-group-toggle>.btn-group>.btn input[type=radio]{position:absolute;clip:rect(0,0,0,0);pointer-events:none}.input-group{position:relative;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-ms-flex-align:stretch;align-items:stretch;width:100%}.input-group>.custom-file,.input-group>.custom-select,.input-group>.form-control,.input-group>.form-control-plaintext{position:relative;-ms-flex:1 1 auto;flex:1 1 auto;width:1%;min-width:0;margin-bottom:0}.input-group>.custom-file+.custom-file,.input-group>.custom-file+.custom-select,.input-group>.custom-file+.form-control,.input-group>.custom-select+.custom-file,.input-group>.custom-select+.custom-select,.input-group>.custom-select+.form-control,.input-group>.form-control+.custom-file,.input-group>.form-control+.custom-select,.input-group>.form-control+.form-control,.input-group>.form-control-plaintext+.custom-file,.input-group>.form-control-plaintext+.custom-select,.input-group>.form-control-plaintext+.form-control{margin-left:-1px}.input-group>.custom-file .custom-file-input:focus~.custom-file-label,.input-group>.custom-select:focus,.input-group>.form-control:focus{z-index:3}.input-group>.custom-file .custom-file-input:focus{z-index:4}.input-group>.custom-select:not(:last-child),.input-group>.form-control:not(:last-child){border-top-right-radius:0;border-bottom-right-radius:0}.input-group>.custom-select:not(:first-child),.input-group>.form-control:not(:first-child){border-top-left-radius:0;border-bottom-left-radius:0}.input-group>.custom-file{display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center}.input-group>.custom-file:not(:last-child) .custom-file-label,.input-group>.custom-file:not(:last-child) .custom-file-label::after{border-top-right-radius:0;border-bottom-right-radius:0}.input-group>.custom-file:not(:first-child) .custom-file-label{border-top-left-radius:0;border-bottom-left-radius:0}.input-group-append,.input-group-prepend{display:-ms-flexbox;display:flex}.input-group-append .btn,.input-group-prepend .btn{position:relative;z-index:2}.input-group-append .btn:focus,.input-group-prepend .btn:focus{z-index:3}.input-group-append .btn+.btn,.input-group-append .btn+.input-group-text,.input-group-append .input-group-text+.btn,.input-group-append .input-group-text+.input-group-text,.input-group-prepend .btn+.btn,.input-group-prepend .btn+.input-group-text,.input-group-prepend .input-group-text+.btn,.input-group-prepend .input-group-text+.input-group-text{margin-left:-1px}.input-group-prepend{margin-right:-1px}.input-group-append{margin-left:-1px}.input-group-text{display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;padding:.375rem .75rem;margin-bottom:0;font-size:1rem;font-weight:400;line-height:1.5;color:#495057;text-align:center;white-space:nowrap;background-color:#e9ecef;border:1px solid #ced4da;border-radius:.25rem}.input-group-text input[type=checkbox],.input-group-text input[type=radio]{margin-top:0}.input-group-lg>.custom-select,.input-group-lg>.form-control:not(textarea){height:calc(1.5em+1rem+2px)}.input-group-lg>.custom-select,.input-group-lg>.form-control,.input-group-lg>.input-group-append>.btn,.input-group-lg>.input-group-append>.input-group-text,.input-group-lg>.input-group-prepend>.btn,.input-group-lg>.input-group-prepend>.input-group-text{padding:.5rem 1rem;font-size:1.25rem;line-height:1.5;border-radius:.3rem}.input-group-sm>.custom-select,.input-group-sm>.form-control:not(textarea){height:calc(1.5em+.5rem+2px)}.input-group-sm>.custom-select,.input-group-sm>.form-control,.input-group-sm>.input-group-append>.btn,.input-group-sm>.input-group-append>.input-group-text,.input-group-sm>.input-group-prepend>.btn,.input-group-sm>.input-group-prepend>.input-group-text{padding:.25rem .5rem;font-size:.875rem;line-height:1.5;border-radius:.2rem}.input-group-lg>.custom-select,.input-group-sm>.custom-select{padding-right:1.75rem}.input-group>.input-group-append:last-child>.btn:not(:last-child):not(.dropdown-toggle),.input-group>.input-group-append:last-child>.input-group-text:not(:last-child),.input-group>.input-group-append:not(:last-child)>.btn,.input-group>.input-group-append:not(:last-child)>.input-group-text,.input-group>.input-group-prepend>.btn,.input-group>.input-group-prepend>.input-group-text{border-top-right-radius:0;border-bottom-right-radius:0}.input-group>.input-group-append>.btn,.input-group>.input-group-append>.input-group-text,.input-group>.input-group-prepend:first-child>.btn:not(:first-child),.input-group>.input-group-prepend:first-child>.input-group-text:not(:first-child),.input-group>.input-group-prepend:not(:first-child)>.btn,.input-group>.input-group-prepend:not(:first-child)>.input-group-text{border-top-left-radius:0;border-bottom-left-radius:0}.custom-control{position:relative;display:block;min-height:1.5rem;padding-left:1.5rem}.custom-control-inline{display:-ms-inline-flexbox;display:inline-flex;margin-right:1rem}.custom-control-input{position:absolute;left:0;z-index:-1;width:1rem;height:1.25rem;opacity:0}.custom-control-input:checked~.custom-control-label::before{color:#fff;border-color:#007bff;background-color:#007bff}.custom-control-input:focus~.custom-control-label::before{box-shadow:0 0 0 .2rem rgba(0,123,255,.25)}.custom-control-input:focus:not(:checked)~.custom-control-label::before{border-color:#80bdff}.custom-control-input:not(:disabled):active~.custom-control-label::before{color:#fff;background-color:#b3d7ff;border-color:#b3d7ff}.custom-control-input:disabled~.custom-control-label,.custom-control-input[disabled]~.custom-control-label{color:#6c757d}.custom-control-input:disabled~.custom-control-label::before,.custom-control-input[disabled]~.custom-control-label::before{background-color:#e9ecef}.custom-control-label{position:relative;margin-bottom:0;vertical-align:top}.custom-control-label::before{position:absolute;top:.25rem;left:-1.5rem;display:block;width:1rem;height:1rem;pointer-events:none;content:"";background-color:#fff;border:#adb5bd solid 1px}.custom-control-label::after{position:absolute;top:.25rem;left:-1.5rem;display:block;width:1rem;height:1rem;content:"";background:no-repeat 50%/50% 50%}.custom-checkbox .custom-control-label::before{border-radius:.25rem}.custom-checkbox .custom-control-input:checked~.custom-control-label::after{background-image:url("data:image/svg+xml,%3csvgxmlns='http://www.w3.org/2000/svg'width='8'height='8'viewBox='0088'%3e%3cpathfill='%23fff'd='M6.564.75l-3.593.612-1.538-1.55L04.26l2.9742.99L82.193z'/%3e%3c/svg%3e")}.custom-checkbox .custom-control-input:indeterminate~.custom-control-label::before{border-color:#007bff;background-color:#007bff}.custom-checkbox .custom-control-input:indeterminate~.custom-control-label::after{background-image:url("data:image/svg+xml,%3csvgxmlns='http://www.w3.org/2000/svg'width='4'height='4'viewBox='0044'%3e%3cpathstroke='%23fff'd='M02h4'/%3e%3c/svg%3e")}.custom-checkbox .custom-control-input:disabled:checked~.custom-control-label::before{background-color:rgba(0,123,255,.5)}.custom-checkbox .custom-control-input:disabled:indeterminate~.custom-control-label::before{background-color:rgba(0,123,255,.5)}.custom-radio .custom-control-label::before{border-radius:50%}.custom-radio .custom-control-input:checked~.custom-control-label::after{background-image:url("data:image/svg+xml,%3csvgxmlns='http://www.w3.org/2000/svg'width='12'height='12'viewBox='-4-488'%3e%3ccircler='3'fill='%23fff'/%3e%3c/svg%3e")}.custom-radio .custom-control-input:disabled:checked~.custom-control-label::before{background-color:rgba(0,123,255,.5)}.custom-switch{padding-left:2.25rem}.custom-switch .custom-control-label::before{left:-2.25rem;width:1.75rem;pointer-events:all;border-radius:.5rem}.custom-switch .custom-control-label::after{top:calc(.25rem+2px);left:calc(-2.25rem+2px);width:calc(1rem - 4px);height:calc(1rem - 4px);background-color:#adb5bd;border-radius:.5rem;transition:background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-transform .15s ease-in-out;transition:transform .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:transform .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-transform .15s ease-in-out}@media(prefers-reduced-motion:reduce){.custom-switch .custom-control-label::after{transition:none}}.custom-switch .custom-control-input:checked~.custom-control-label::after{background-color:#fff;-webkit-transform:translateX(.75rem);transform:translateX(.75rem)}.custom-switch .custom-control-input:disabled:checked~.custom-control-label::before{background-color:rgba(0,123,255,.5)}.custom-select{display:inline-block;width:100%;height:calc(1.5em+.75rem+2px);padding:.375rem 1.75rem .375rem .75rem;font-size:1rem;font-weight:400;line-height:1.5;color:#495057;vertical-align:middle;background:#fff url("data:image/svg+xml,%3csvgxmlns='http://www.w3.org/2000/svg'width='4'height='5'viewBox='0045'%3e%3cpathfill='%23343a40'd='M20L02h4zm05L03h4z'/%3e%3c/svg%3e") no-repeat right .75rem center/8px 10px;border:1px solid #ced4da;border-radius:.25rem;-webkit-appearance:none;-moz-appearance:none;appearance:none}.custom-select:focus{border-color:#80bdff;outline:0;box-shadow:0 0 0 .2rem rgba(0,123,255,.25)}.custom-select:focus::-ms-value{color:#495057;background-color:#fff}.custom-select[multiple],.custom-select[size]:not([size="1"]){height:auto;padding-right:.75rem;background-image:none}.custom-select:disabled{color:#6c757d;background-color:#e9ecef}.custom-select::-ms-expand{display:none}.custom-select:-moz-focusring{color:transparent;text-shadow:0 0 0 #495057}.custom-select-sm{height:calc(1.5em+.5rem+2px);padding-top:.25rem;padding-bottom:.25rem;padding-left:.5rem;font-size:.875rem}.custom-select-lg{height:calc(1.5em+1rem+2px);padding-top:.5rem;padding-bottom:.5rem;padding-left:1rem;font-size:1.25rem}.custom-file{position:relative;display:inline-block;width:100%;height:calc(1.5em+.75rem+2px);margin-bottom:0}.custom-file-input{position:relative;z-index:2;width:100%;height:calc(1.5em+.75rem+2px);margin:0;opacity:0}.custom-file-input:focus~.custom-file-label{border-color:#80bdff;box-shadow:0 0 0 .2rem rgba(0,123,255,.25)}.custom-file-input:disabled~.custom-file-label,.custom-file-input[disabled]~.custom-file-label{background-color:#e9ecef}.custom-file-input:lang(en)~.custom-file-label::after{content:"Browse"}.custom-file-input~.custom-file-label[data-browse]::after{content:attr(data-browse)}.custom-file-label{position:absolute;top:0;right:0;left:0;z-index:1;height:calc(1.5em+.75rem+2px);padding:.375rem .75rem;font-weight:400;line-height:1.5;color:#495057;background-color:#fff;border:1px solid #ced4da;border-radius:.25rem}.custom-file-label::after{position:absolute;top:0;right:0;bottom:0;z-index:3;display:block;height:calc(1.5em+.75rem);padding:.375rem .75rem;line-height:1.5;color:#495057;content:"Browse";background-color:#e9ecef;border-left:inherit;border-radius:0 .25rem .25rem 0}.custom-range{width:100%;height:1.4rem;padding:0;background-color:transparent;-webkit-appearance:none;-moz-appearance:none;appearance:none}.custom-range:focus{outline:0}.custom-range:focus::-webkit-slider-thumb{box-shadow:0 0 0 1px #fff,0 0 0 .2rem rgba(0,123,255,.25)}.custom-range:focus::-moz-range-thumb{box-shadow:0 0 0 1px #fff,0 0 0 .2rem rgba(0,123,255,.25)}.custom-range:focus::-ms-thumb{box-shadow:0 0 0 1px #fff,0 0 0 .2rem rgba(0,123,255,.25)}.custom-range::-moz-focus-outer{border:0}.custom-range::-webkit-slider-thumb{width:1rem;height:1rem;margin-top:-.25rem;background-color:#007bff;border:0;border-radius:1rem;-webkit-transition:background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;-webkit-appearance:none;appearance:none}@media(prefers-reduced-motion:reduce){.custom-range::-webkit-slider-thumb{-webkit-transition:none;transition:none}}.custom-range::-webkit-slider-thumb:active{background-color:#b3d7ff}.custom-range::-webkit-slider-runnable-track{width:100%;height:.5rem;color:transparent;cursor:pointer;background-color:#dee2e6;border-color:transparent;border-radius:1rem}.custom-range::-moz-range-thumb{width:1rem;height:1rem;background-color:#007bff;border:0;border-radius:1rem;-moz-transition:background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;-moz-appearance:none;appearance:none}@media(prefers-reduced-motion:reduce){.custom-range::-moz-range-thumb{-moz-transition:none;transition:none}}.custom-range::-moz-range-thumb:active{background-color:#b3d7ff}.custom-range::-moz-range-track{width:100%;height:.5rem;color:transparent;cursor:pointer;background-color:#dee2e6;border-color:transparent;border-radius:1rem}.custom-range::-ms-thumb{width:1rem;height:1rem;margin-top:0;margin-right:.2rem;margin-left:.2rem;background-color:#007bff;border:0;border-radius:1rem;-ms-transition:background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;appearance:none}@media(prefers-reduced-motion:reduce){.custom-range::-ms-thumb{-ms-transition:none;transition:none}}.custom-range::-ms-thumb:active{background-color:#b3d7ff}.custom-range::-ms-track{width:100%;height:.5rem;color:transparent;cursor:pointer;background-color:transparent;border-color:transparent;border-width:.5rem}.custom-range::-ms-fill-lower{background-color:#dee2e6;border-radius:1rem}.custom-range::-ms-fill-upper{margin-right:15px;background-color:#dee2e6;border-radius:1rem}.custom-range:disabled::-webkit-slider-thumb{background-color:#adb5bd}.custom-range:disabled::-webkit-slider-runnable-track{cursor:default}.custom-range:disabled::-moz-range-thumb{background-color:#adb5bd}.custom-range:disabled::-moz-range-track{cursor:default}.custom-range:disabled::-ms-thumb{background-color:#adb5bd}.custom-control-label::before,.custom-file-label,.custom-select{transition:background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out}@media(prefers-reduced-motion:reduce){.custom-control-label::before,.custom-file-label,.custom-select{transition:none}}.nav{display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;padding-left:0;margin-bottom:0;list-style:none}.nav-link{display:block;padding:.5rem 1rem}.nav-link:focus,.nav-link:hover{text-decoration:none}.nav-link.disabled{color:#6c757d;pointer-events:none;cursor:default}.nav-tabs{border-bottom:1px solid #dee2e6}.nav-tabs .nav-item{margin-bottom:-1px}.nav-tabs .nav-link{border:1px solid transparent;border-top-left-radius:.25rem;border-top-right-radius:.25rem}.nav-tabs .nav-link:focus,.nav-tabs .nav-link:hover{border-color:#e9ecef #e9ecef #dee2e6}.nav-tabs .nav-link.disabled{color:#6c757d;background-color:transparent;border-color:transparent}.nav-tabs .nav-item.show .nav-link,.nav-tabs .nav-link.active{color:#495057;background-color:#fff;border-color:#dee2e6 #dee2e6 #fff}.nav-tabs .dropdown-menu{margin-top:-1px;border-top-left-radius:0;border-top-right-radius:0}.nav-pills .nav-link{border-radius:.25rem}.nav-pills .nav-link.active,.nav-pills .show>.nav-link{color:#fff;background-color:#007bff}.nav-fill .nav-item{-ms-flex:1 1 auto;flex:1 1 auto;text-align:center}.nav-justified .nav-item{-ms-flex-preferred-size:0;flex-basis:0;-ms-flex-positive:1;flex-grow:1;text-align:center}.tab-content>.tab-pane{display:none}.tab-content>.active{display:block}.navbar{position:relative;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-ms-flex-align:center;align-items:center;-ms-flex-pack:justify;justify-content:space-between;padding:.5rem 1rem}.navbar .container,.navbar .container-fluid,.navbar .container-lg,.navbar .container-md,.navbar .container-sm,.navbar .container-xl{display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-ms-flex-align:center;align-items:center;-ms-flex-pack:justify;justify-content:space-between}.navbar-brand{display:inline-block;padding-top:.3125rem;padding-bottom:.3125rem;margin-right:1rem;font-size:1.25rem;line-height:inherit;white-space:nowrap}.navbar-brand:focus,.navbar-brand:hover{text-decoration:none}.navbar-nav{display:-ms-flexbox;display:flex;-ms-flex-direction:column;flex-direction:column;padding-left:0;margin-bottom:0;list-style:none}.navbar-nav .nav-link{padding-right:0;padding-left:0}.navbar-nav .dropdown-menu{position:static;float:none}.navbar-text{display:inline-block;padding-top:.5rem;padding-bottom:.5rem}.navbar-collapse{-ms-flex-preferred-size:100%;flex-basis:100%;-ms-flex-positive:1;flex-grow:1;-ms-flex-align:center;align-items:center}.navbar-toggler{padding:.25rem .75rem;font-size:1.25rem;line-height:1;background-color:transparent;border:1px solid transparent;border-radius:.25rem}.navbar-toggler:focus,.navbar-toggler:hover{text-decoration:none}.navbar-toggler-icon{display:inline-block;width:1.5em;height:1.5em;vertical-align:middle;content:"";background:no-repeat center center;background-size:100% 100%}@media(max-width:575.98px){.navbar-expand-sm>.container,.navbar-expand-sm>.container-fluid,.navbar-expand-sm>.container-lg,.navbar-expand-sm>.container-md,.navbar-expand-sm>.container-sm,.navbar-expand-sm>.container-xl{padding-right:0;padding-left:0}}@media(min-width:576px){.navbar-expand-sm{-ms-flex-flow:row nowrap;flex-flow:row nowrap;-ms-flex-pack:start;justify-content:flex-start}.navbar-expand-sm .navbar-nav{-ms-flex-direction:row;flex-direction:row}.navbar-expand-sm .navbar-nav .dropdown-menu{position:absolute}.navbar-expand-sm .navbar-nav .nav-link{padding-right:.5rem;padding-left:.5rem}.navbar-expand-sm>.container,.navbar-expand-sm>.container-fluid,.navbar-expand-sm>.container-lg,.navbar-expand-sm>.container-md,.navbar-expand-sm>.container-sm,.navbar-expand-sm>.container-xl{-ms-flex-wrap:nowrap;flex-wrap:nowrap}.navbar-expand-sm .navbar-collapse{display:-ms-flexbox!important;display:flex!important;-ms-flex-preferred-size:auto;flex-basis:auto}.navbar-expand-sm .navbar-toggler{display:none}}@media(max-width:767.98px){.navbar-expand-md>.container,.navbar-expand-md>.container-fluid,.navbar-expand-md>.container-lg,.navbar-expand-md>.container-md,.navbar-expand-md>.container-sm,.navbar-expand-md>.container-xl{padding-right:0;padding-left:0}}@media(min-width:768px){.navbar-expand-md{-ms-flex-flow:row nowrap;flex-flow:row nowrap;-ms-flex-pack:start;justify-content:flex-start}.navbar-expand-md .navbar-nav{-ms-flex-direction:row;flex-direction:row}.navbar-expand-md .navbar-nav .dropdown-menu{position:absolute}.navbar-expand-md .navbar-nav .nav-link{padding-right:.5rem;padding-left:.5rem}.navbar-expand-md>.container,.navbar-expand-md>.container-fluid,.navbar-expand-md>.container-lg,.navbar-expand-md>.container-md,.navbar-expand-md>.container-sm,.navbar-expand-md>.container-xl{-ms-flex-wrap:nowrap;flex-wrap:nowrap}.navbar-expand-md .navbar-collapse{display:-ms-flexbox!important;display:flex!important;-ms-flex-preferred-size:auto;flex-basis:auto}.navbar-expand-md .navbar-toggler{display:none}}@media(max-width:991.98px){.navbar-expand-lg>.container,.navbar-expand-lg>.container-fluid,.navbar-expand-lg>.container-lg,.navbar-expand-lg>.container-md,.navbar-expand-lg>.container-sm,.navbar-expand-lg>.container-xl{padding-right:0;padding-left:0}}@media(min-width:992px){.navbar-expand-lg{-ms-flex-flow:row nowrap;flex-flow:row nowrap;-ms-flex-pack:start;justify-content:flex-start}.navbar-expand-lg .navbar-nav{-ms-flex-direction:row;flex-direction:row}.navbar-expand-lg .navbar-nav .dropdown-menu{position:absolute}.navbar-expand-lg .navbar-nav .nav-link{padding-right:.5rem;padding-left:.5rem}.navbar-expand-lg>.container,.navbar-expand-lg>.container-fluid,.navbar-expand-lg>.container-lg,.navbar-expand-lg>.container-md,.navbar-expand-lg>.container-sm,.navbar-expand-lg>.container-xl{-ms-flex-wrap:nowrap;flex-wrap:nowrap}.navbar-expand-lg .navbar-collapse{display:-ms-flexbox!important;display:flex!important;-ms-flex-preferred-size:auto;flex-basis:auto}.navbar-expand-lg .navbar-toggler{display:none}}@media(max-width:1199.98px){.navbar-expand-xl>.container,.navbar-expand-xl>.container-fluid,.navbar-expand-xl>.container-lg,.navbar-expand-xl>.container-md,.navbar-expand-xl>.container-sm,.navbar-expand-xl>.container-xl{padding-right:0;padding-left:0}}@media(min-width:1200px){.navbar-expand-xl{-ms-flex-flow:row nowrap;flex-flow:row nowrap;-ms-flex-pack:start;justify-content:flex-start}.navbar-expand-xl .navbar-nav{-ms-flex-direction:row;flex-direction:row}.navbar-expand-xl .navbar-nav .dropdown-menu{position:absolute}.navbar-expand-xl .navbar-nav .nav-link{padding-right:.5rem;padding-left:.5rem}.navbar-expand-xl>.container,.navbar-expand-xl>.container-fluid,.navbar-expand-xl>.container-lg,.navbar-expand-xl>.container-md,.navbar-expand-xl>.container-sm,.navbar-expand-xl>.container-xl{-ms-flex-wrap:nowrap;flex-wrap:nowrap}.navbar-expand-xl .navbar-collapse{display:-ms-flexbox!important;display:flex!important;-ms-flex-preferred-size:auto;flex-basis:auto}.navbar-expand-xl .navbar-toggler{display:none}}.navbar-expand{-ms-flex-flow:row nowrap;flex-flow:row nowrap;-ms-flex-pack:start;justify-content:flex-start}.navbar-expand>.container,.navbar-expand>.container-fluid,.navbar-expand>.container-lg,.navbar-expand>.container-md,.navbar-expand>.container-sm,.navbar-expand>.container-xl{padding-right:0;padding-left:0}.navbar-expand .navbar-nav{-ms-flex-direction:row;flex-direction:row}.navbar-expand .navbar-nav .dropdown-menu{position:absolute}.navbar-expand .navbar-nav .nav-link{padding-right:.5rem;padding-left:.5rem}.navbar-expand>.container,.navbar-expand>.container-fluid,.navbar-expand>.container-lg,.navbar-expand>.container-md,.navbar-expand>.container-sm,.navbar-expand>.container-xl{-ms-flex-wrap:nowrap;flex-wrap:nowrap}.navbar-expand .navbar-collapse{display:-ms-flexbox!important;display:flex!important;-ms-flex-preferred-size:auto;flex-basis:auto}.navbar-expand .navbar-toggler{display:none}.navbar-light .navbar-brand{color:rgba(0,0,0,.9)}.navbar-light .navbar-brand:focus,.navbar-light .navbar-brand:hover{color:rgba(0,0,0,.9)}.navbar-light .navbar-nav .nav-link{color:rgba(0,0,0,.5)}.navbar-light .navbar-nav .nav-link:focus,.navbar-light .navbar-nav .nav-link:hover{color:rgba(0,0,0,.7)}.navbar-light .navbar-nav .nav-link.disabled{color:rgba(0,0,0,.3)}.navbar-light .navbar-nav .active>.nav-link,.navbar-light .navbar-nav .nav-link.active,.navbar-light .navbar-nav .nav-link.show,.navbar-light .navbar-nav .show>.nav-link{color:rgba(0,0,0,.9)}.navbar-light .navbar-toggler{color:rgba(0,0,0,.5);border-color:rgba(0,0,0,.1)}.navbar-light .navbar-toggler-icon{background-image:url("data:image/svg+xml,%3csvgxmlns='http://www.w3.org/2000/svg'width='30'height='30'viewBox='003030'%3e%3cpathstroke='rgba%280,0,0,0.5%29'stroke-linecap='round'stroke-miterlimit='10'stroke-width='2'd='M47h22M415h22M423h22'/%3e%3c/svg%3e")}.navbar-light .navbar-text{color:rgba(0,0,0,.5)}.navbar-light .navbar-text a{color:rgba(0,0,0,.9)}.navbar-light .navbar-text a:focus,.navbar-light .navbar-text a:hover{color:rgba(0,0,0,.9)}.navbar-dark .navbar-brand{color:#fff}.navbar-dark .navbar-brand:focus,.navbar-dark .navbar-brand:hover{color:#fff}.navbar-dark .navbar-nav .nav-link{color:rgba(255,255,255,.5)}.navbar-dark .navbar-nav .nav-link:focus,.navbar-dark .navbar-nav .nav-link:hover{color:rgba(255,255,255,.75)}.navbar-dark .navbar-nav .nav-link.disabled{color:rgba(255,255,255,.25)}.navbar-dark .navbar-nav .active>.nav-link,.navbar-dark .navbar-nav .nav-link.active,.navbar-dark .navbar-nav .nav-link.show,.navbar-dark .navbar-nav .show>.nav-link{color:#fff}.navbar-dark .navbar-toggler{color:rgba(255,255,255,.5);border-color:rgba(255,255,255,.1)}.navbar-dark .navbar-toggler-icon{background-image:url("data:image/svg+xml,%3csvgxmlns='http://www.w3.org/2000/svg'width='30'height='30'viewBox='003030'%3e%3cpathstroke='rgba%28255,255,255,0.5%29'stroke-linecap='round'stroke-miterlimit='10'stroke-width='2'd='M47h22M415h22M423h22'/%3e%3c/svg%3e")}.navbar-dark .navbar-text{color:rgba(255,255,255,.5)}.navbar-dark .navbar-text a{color:#fff}.navbar-dark .navbar-text a:focus,.navbar-dark .navbar-text a:hover{color:#fff}.card{position:relative;display:-ms-flexbox;display:flex;-ms-flex-direction:column;flex-direction:column;min-width:0;word-wrap:break-word;background-color:#fff;background-clip:border-box;border:1px solid rgba(0,0,0,.125);border-radius:.25rem}.card>hr{margin-right:0;margin-left:0}.card>.list-group{border-top:inherit;border-bottom:inherit}.card>.list-group:first-child{border-top-width:0;border-top-left-radius:calc(.25rem - 1px);border-top-right-radius:calc(.25rem - 1px)}.card>.list-group:last-child{border-bottom-width:0;border-bottom-right-radius:calc(.25rem - 1px);border-bottom-left-radius:calc(.25rem - 1px)}.card-body{-ms-flex:1 1 auto;flex:1 1 auto;min-height:1px;padding:1.25rem}.card-title{margin-bottom:.75rem}.card-subtitle{margin-top:-.375rem;margin-bottom:0}.card-text:last-child{margin-bottom:0}.card-link:hover{text-decoration:none}.card-link+.card-link{margin-left:1.25rem}.card-header{padding:.75rem 1.25rem;margin-bottom:0;background-color:rgba(0,0,0,.03);border-bottom:1px solid rgba(0,0,0,.125)}.card-header:first-child{border-radius:calc(.25rem - 1px) calc(.25rem - 1px) 0 0}.card-header+.list-group .list-group-item:first-child{border-top:0}.card-footer{padding:.75rem 1.25rem;background-color:rgba(0,0,0,.03);border-top:1px solid rgba(0,0,0,.125)}.card-footer:last-child{border-radius:0 0 calc(.25rem - 1px) calc(.25rem - 1px)}.card-header-tabs{margin-right:-.625rem;margin-bottom:-.75rem;margin-left:-.625rem;border-bottom:0}.card-header-pills{margin-right:-.625rem;margin-left:-.625rem}.card-img-overlay{position:absolute;top:0;right:0;bottom:0;left:0;padding:1.25rem}.card-img,.card-img-bottom,.card-img-top{-ms-flex-negative:0;flex-shrink:0;width:100%}.card-img,.card-img-top{border-top-left-radius:calc(.25rem - 1px);border-top-right-radius:calc(.25rem - 1px)}.card-img,.card-img-bottom{border-bottom-right-radius:calc(.25rem - 1px);border-bottom-left-radius:calc(.25rem - 1px)}.card-deck .card{margin-bottom:15px}@media(min-width:576px){.card-deck{display:-ms-flexbox;display:flex;-ms-flex-flow:row wrap;flex-flow:row wrap;margin-right:-15px;margin-left:-15px}.card-deck .card{-ms-flex:1 0 0;flex:1 0 0;margin-right:15px;margin-bottom:0;margin-left:15px}}.card-group>.card{margin-bottom:15px}@media(min-width:576px){.card-group{display:-ms-flexbox;display:flex;-ms-flex-flow:row wrap;flex-flow:row wrap}.card-group>.card{-ms-flex:1 0 0;flex:1 0 0;margin-bottom:0}.card-group>.card+.card{margin-left:0;border-left:0}.card-group>.card:not(:last-child){border-top-right-radius:0;border-bottom-right-radius:0}.card-group>.card:not(:last-child) .card-header,.card-group>.card:not(:last-child) .card-img-top{border-top-right-radius:0}.card-group>.card:not(:last-child) .card-footer,.card-group>.card:not(:last-child) .card-img-bottom{border-bottom-right-radius:0}.card-group>.card:not(:first-child){border-top-left-radius:0;border-bottom-left-radius:0}.card-group>.card:not(:first-child) .card-header,.card-group>.card:not(:first-child) .card-img-top{border-top-left-radius:0}.card-group>.card:not(:first-child) .card-footer,.card-group>.card:not(:first-child) .card-img-bottom{border-bottom-left-radius:0}}.card-columns .card{margin-bottom:.75rem}@media(min-width:576px){.card-columns{-webkit-column-count:3;-moz-column-count:3;column-count:3;-webkit-column-gap:1.25rem;-moz-column-gap:1.25rem;column-gap:1.25rem;orphans:1;widows:1}.card-columns .card{display:inline-block;width:100%}}.accordion>.card{overflow:hidden}.accordion>.card:not(:last-of-type){border-bottom:0;border-bottom-right-radius:0;border-bottom-left-radius:0}.accordion>.card:not(:first-of-type){border-top-left-radius:0;border-top-right-radius:0}.accordion>.card>.card-header{border-radius:0;margin-bottom:-1px}.breadcrumb{display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;padding:.75rem 1rem;margin-bottom:1rem;list-style:none;background-color:#e9ecef;border-radius:.25rem}.breadcrumb-item{display:-ms-flexbox;display:flex}.breadcrumb-item+.breadcrumb-item{padding-left:.5rem}.breadcrumb-item+.breadcrumb-item::before{display:inline-block;padding-right:.5rem;color:#6c757d;content:"/"}.breadcrumb-item+.breadcrumb-item:hover::before{text-decoration:underline}.breadcrumb-item+.breadcrumb-item:hover::before{text-decoration:none}.breadcrumb-item.active{color:#6c757d}.pagination{display:-ms-flexbox;display:flex;padding-left:0;list-style:none;border-radius:.25rem}.page-link{position:relative;display:block;padding:.5rem .75rem;margin-left:-1px;line-height:1.25;color:#007bff;background-color:#fff;border:1px solid #dee2e6}.page-link:hover{z-index:2;color:#0056b3;text-decoration:none;background-color:#e9ecef;border-color:#dee2e6}.page-link:focus{z-index:3;outline:0;box-shadow:0 0 0 .2rem rgba(0,123,255,.25)}.page-item:first-child .page-link{margin-left:0;border-top-left-radius:.25rem;border-bottom-left-radius:.25rem}.page-item:last-child .page-link{border-top-right-radius:.25rem;border-bottom-right-radius:.25rem}.page-item.active .page-link{z-index:3;color:#fff;background-color:#007bff;border-color:#007bff}.page-item.disabled .page-link{color:#6c757d;pointer-events:none;cursor:auto;background-color:#fff;border-color:#dee2e6}.pagination-lg .page-link{padding:.75rem 1.5rem;font-size:1.25rem;line-height:1.5}.pagination-lg .page-item:first-child .page-link{border-top-left-radius:.3rem;border-bottom-left-radius:.3rem}.pagination-lg .page-item:last-child .page-link{border-top-right-radius:.3rem;border-bottom-right-radius:.3rem}.pagination-sm .page-link{padding:.25rem .5rem;font-size:.875rem;line-height:1.5}.pagination-sm .page-item:first-child .page-link{border-top-left-radius:.2rem;border-bottom-left-radius:.2rem}.pagination-sm .page-item:last-child .page-link{border-top-right-radius:.2rem;border-bottom-right-radius:.2rem}.badge{display:inline-block;padding:.25em .4em;font-size:75%;font-weight:700;line-height:1;text-align:center;white-space:nowrap;vertical-align:baseline;border-radius:.25rem;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out}@media(prefers-reduced-motion:reduce){.badge{transition:none}}a.badge:focus,a.badge:hover{text-decoration:none}.badge:empty{display:none}.btn .badge{position:relative;top:-1px}.badge-pill{padding-right:.6em;padding-left:.6em;border-radius:10rem}.badge-primary{color:#fff;background-color:#007bff}a.badge-primary:focus,a.badge-primary:hover{color:#fff;background-color:#0062cc}a.badge-primary.focus,a.badge-primary:focus{outline:0;box-shadow:0 0 0 .2rem rgba(0,123,255,.5)}.badge-secondary{color:#fff;background-color:#6c757d}a.badge-secondary:focus,a.badge-secondary:hover{color:#fff;background-color:#545b62}a.badge-secondary.focus,a.badge-secondary:focus{outline:0;box-shadow:0 0 0 .2rem rgba(108,117,125,.5)}.badge-success{color:#fff;background-color:#28a745}a.badge-success:focus,a.badge-success:hover{color:#fff;background-color:#1e7e34}a.badge-success.focus,a.badge-success:focus{outline:0;box-shadow:0 0 0 .2rem rgba(40,167,69,.5)}.badge-info{color:#fff;background-color:#17a2b8}a.badge-info:focus,a.badge-info:hover{color:#fff;background-color:#117a8b}a.badge-info.focus,a.badge-info:focus{outline:0;box-shadow:0 0 0 .2rem rgba(23,162,184,.5)}.badge-warning{color:#212529;background-color:#ffc107}a.badge-warning:focus,a.badge-warning:hover{color:#212529;background-color:#d39e00}a.badge-warning.focus,a.badge-warning:focus{outline:0;box-shadow:0 0 0 .2rem rgba(255,193,7,.5)}.badge-danger{color:#fff;background-color:#dc3545}a.badge-danger:focus,a.badge-danger:hover{color:#fff;background-color:#bd2130}a.badge-danger.focus,a.badge-danger:focus{outline:0;box-shadow:0 0 0 .2rem rgba(220,53,69,.5)}.badge-light{color:#212529;background-color:#f8f9fa}a.badge-light:focus,a.badge-light:hover{color:#212529;background-color:#dae0e5}a.badge-light.focus,a.badge-light:focus{outline:0;box-shadow:0 0 0 .2rem rgba(248,249,250,.5)}.badge-dark{color:#fff;background-color:#343a40}a.badge-dark:focus,a.badge-dark:hover{color:#fff;background-color:#1d2124}a.badge-dark.focus,a.badge-dark:focus{outline:0;box-shadow:0 0 0 .2rem rgba(52,58,64,.5)}.jumbotron{padding:2rem 1rem;margin-bottom:2rem;background-color:#e9ecef;border-radius:.3rem}@media(min-width:576px){.jumbotron{padding:4rem 2rem}}.jumbotron-fluid{padding-right:0;padding-left:0;border-radius:0}.alert{position:relative;padding:.75rem 1.25rem;margin-bottom:1rem;border:1px solid transparent;border-radius:.25rem}.alert-heading{color:inherit}.alert-link{font-weight:700}.alert-dismissible{padding-right:4rem}.alert-dismissible .close{position:absolute;top:0;right:0;padding:.75rem 1.25rem;color:inherit}.alert-primary{color:#004085;background-color:#cce5ff;border-color:#b8daff}.alert-primary hr{border-top-color:#9fcdff}.alert-primary .alert-link{color:#002752}.alert-secondary{color:#383d41;background-color:#e2e3e5;border-color:#d6d8db}.alert-secondary hr{border-top-color:#c8cbcf}.alert-secondary .alert-link{color:#202326}.alert-success{color:#155724;background-color:#d4edda;border-color:#c3e6cb}.alert-success hr{border-top-color:#b1dfbb}.alert-success .alert-link{color:#0b2e13}.alert-info{color:#0c5460;background-color:#d1ecf1;border-color:#bee5eb}.alert-info hr{border-top-color:#abdde5}.alert-info .alert-link{color:#062c33}.alert-warning{color:#856404;background-color:#fff3cd;border-color:#ffeeba}.alert-warning hr{border-top-color:#ffe8a1}.alert-warning .alert-link{color:#533f03}.alert-danger{color:#721c24;background-color:#f8d7da;border-color:#f5c6cb}.alert-danger hr{border-top-color:#f1b0b7}.alert-danger .alert-link{color:#491217}.alert-light{color:#818182;background-color:#fefefe;border-color:#fdfdfe}.alert-light hr{border-top-color:#ececf6}.alert-light .alert-link{color:#686868}.alert-dark{color:#1b1e21;background-color:#d6d8d9;border-color:#c6c8ca}.alert-dark hr{border-top-color:#b9bbbe}.alert-dark .alert-link{color:#040505}@-webkit-keyframes progress-bar-stripes{from{background-position:1rem 0}to{background-position:0 0}}@keyframes progress-bar-stripes{from{background-position:1rem 0}to{background-position:0 0}}.progress{display:-ms-flexbox;display:flex;height:1rem;overflow:hidden;line-height:0;font-size:.75rem;background-color:#e9ecef;border-radius:.25rem}.progress-bar{display:-ms-flexbox;display:flex;-ms-flex-direction:column;flex-direction:column;-ms-flex-pack:center;justify-content:center;overflow:hidden;color:#fff;text-align:center;white-space:nowrap;background-color:#007bff;transition:width .6s ease}@media(prefers-reduced-motion:reduce){.progress-bar{transition:none}}.progress-bar-striped{background-image:linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);background-size:1rem 1rem}.progress-bar-animated{-webkit-animation:progress-bar-stripes 1s linear infinite;animation:progress-bar-stripes 1s linear infinite}@media(prefers-reduced-motion:reduce){.progress-bar-animated{-webkit-animation:none;animation:none}}.media{display:-ms-flexbox;display:flex;-ms-flex-align:start;align-items:flex-start}.media-body{-ms-flex:1;flex:1}.list-group{display:-ms-flexbox;display:flex;-ms-flex-direction:column;flex-direction:column;padding-left:0;margin-bottom:0;border-radius:.25rem}.list-group-item-action{width:100%;color:#495057;text-align:inherit}.list-group-item-action:focus,.list-group-item-action:hover{z-index:1;color:#495057;text-decoration:none;background-color:#f8f9fa}.list-group-item-action:active{color:#212529;background-color:#e9ecef}.list-group-item{position:relative;display:block;padding:.75rem 1.25rem;background-color:#fff;border:1px solid rgba(0,0,0,.125)}.list-group-item:first-child{border-top-left-radius:inherit;border-top-right-radius:inherit}.list-group-item:last-child{border-bottom-right-radius:inherit;border-bottom-left-radius:inherit}.list-group-item.disabled,.list-group-item:disabled{color:#6c757d;pointer-events:none;background-color:#fff}.list-group-item.active{z-index:2;color:#fff;background-color:#007bff;border-color:#007bff}.list-group-item+.list-group-item{border-top-width:0}.list-group-item+.list-group-item.active{margin-top:-1px;border-top-width:1px}.list-group-horizontal{-ms-flex-direction:row;flex-direction:row}.list-group-horizontal>.list-group-item:first-child{border-bottom-left-radius:.25rem;border-top-right-radius:0}.list-group-horizontal>.list-group-item:last-child{border-top-right-radius:.25rem;border-bottom-left-radius:0}.list-group-horizontal>.list-group-item.active{margin-top:0}.list-group-horizontal>.list-group-item+.list-group-item{border-top-width:1px;border-left-width:0}.list-group-horizontal>.list-group-item+.list-group-item.active{margin-left:-1px;border-left-width:1px}@media(min-width:576px){.list-group-horizontal-sm{-ms-flex-direction:row;flex-direction:row}.list-group-horizontal-sm>.list-group-item:first-child{border-bottom-left-radius:.25rem;border-top-right-radius:0}.list-group-horizontal-sm>.list-group-item:last-child{border-top-right-radius:.25rem;border-bottom-left-radius:0}.list-group-horizontal-sm>.list-group-item.active{margin-top:0}.list-group-horizontal-sm>.list-group-item+.list-group-item{border-top-width:1px;border-left-width:0}.list-group-horizontal-sm>.list-group-item+.list-group-item.active{margin-left:-1px;border-left-width:1px}}@media(min-width:768px){.list-group-horizontal-md{-ms-flex-direction:row;flex-direction:row}.list-group-horizontal-md>.list-group-item:first-child{border-bottom-left-radius:.25rem;border-top-right-radius:0}.list-group-horizontal-md>.list-group-item:last-child{border-top-right-radius:.25rem;border-bottom-left-radius:0}.list-group-horizontal-md>.list-group-item.active{margin-top:0}.list-group-horizontal-md>.list-group-item+.list-group-item{border-top-width:1px;border-left-width:0}.list-group-horizontal-md>.list-group-item+.list-group-item.active{margin-left:-1px;border-left-width:1px}}@media(min-width:992px){.list-group-horizontal-lg{-ms-flex-direction:row;flex-direction:row}.list-group-horizontal-lg>.list-group-item:first-child{border-bottom-left-radius:.25rem;border-top-right-radius:0}.list-group-horizontal-lg>.list-group-item:last-child{border-top-right-radius:.25rem;border-bottom-left-radius:0}.list-group-horizontal-lg>.list-group-item.active{margin-top:0}.list-group-horizontal-lg>.list-group-item+.list-group-item{border-top-width:1px;border-left-width:0}.list-group-horizontal-lg>.list-group-item+.list-group-item.active{margin-left:-1px;border-left-width:1px}}@media(min-width:1200px){.list-group-horizontal-xl{-ms-flex-direction:row;flex-direction:row}.list-group-horizontal-xl>.list-group-item:first-child{border-bottom-left-radius:.25rem;border-top-right-radius:0}.list-group-horizontal-xl>.list-group-item:last-child{border-top-right-radius:.25rem;border-bottom-left-radius:0}.list-group-horizontal-xl>.list-group-item.active{margin-top:0}.list-group-horizontal-xl>.list-group-item+.list-group-item{border-top-width:1px;border-left-width:0}.list-group-horizontal-xl>.list-group-item+.list-group-item.active{margin-left:-1px;border-left-width:1px}}.list-group-flush{border-radius:0}.list-group-flush>.list-group-item{border-width:0 0 1px}.list-group-flush>.list-group-item:last-child{border-bottom-width:0}.list-group-item-primary{color:#004085;background-color:#b8daff}.list-group-item-primary.list-group-item-action:focus,.list-group-item-primary.list-group-item-action:hover{color:#004085;background-color:#9fcdff}.list-group-item-primary.list-group-item-action.active{color:#fff;background-color:#004085;border-color:#004085}.list-group-item-secondary{color:#383d41;background-color:#d6d8db}.list-group-item-secondary.list-group-item-action:focus,.list-group-item-secondary.list-group-item-action:hover{color:#383d41;background-color:#c8cbcf}.list-group-item-secondary.list-group-item-action.active{color:#fff;background-color:#383d41;border-color:#383d41}.list-group-item-success{color:#155724;background-color:#c3e6cb}.list-group-item-success.list-group-item-action:focus,.list-group-item-success.list-group-item-action:hover{color:#155724;background-color:#b1dfbb}.list-group-item-success.list-group-item-action.active{color:#fff;background-color:#155724;border-color:#155724}.list-group-item-info{color:#0c5460;background-color:#bee5eb}.list-group-item-info.list-group-item-action:focus,.list-group-item-info.list-group-item-action:hover{color:#0c5460;background-color:#abdde5}.list-group-item-info.list-group-item-action.active{color:#fff;background-color:#0c5460;border-color:#0c5460}.list-group-item-warning{color:#856404;background-color:#ffeeba}.list-group-item-warning.list-group-item-action:focus,.list-group-item-warning.list-group-item-action:hover{color:#856404;background-color:#ffe8a1}.list-group-item-warning.list-group-item-action.active{color:#fff;background-color:#856404;border-color:#856404}.list-group-item-danger{color:#721c24;background-color:#f5c6cb}.list-group-item-danger.list-group-item-action:focus,.list-group-item-danger.list-group-item-action:hover{color:#721c24;background-color:#f1b0b7}.list-group-item-danger.list-group-item-action.active{color:#fff;background-color:#721c24;border-color:#721c24}.list-group-item-light{color:#818182;background-color:#fdfdfe}.list-group-item-light.list-group-item-action:focus,.list-group-item-light.list-group-item-action:hover{color:#818182;background-color:#ececf6}.list-group-item-light.list-group-item-action.active{color:#fff;background-color:#818182;border-color:#818182}.list-group-item-dark{color:#1b1e21;background-color:#c6c8ca}.list-group-item-dark.list-group-item-action:focus,.list-group-item-dark.list-group-item-action:hover{color:#1b1e21;background-color:#b9bbbe}.list-group-item-dark.list-group-item-action.active{color:#fff;background-color:#1b1e21;border-color:#1b1e21}.close{float:right;font-size:1.5rem;font-weight:700;line-height:1;color:#000;text-shadow:0 1px 0 #fff;opacity:.5}.close:hover{color:#000;text-decoration:none}.close:not(:disabled):not(.disabled):focus,.close:not(:disabled):not(.disabled):hover{opacity:.75}button.close{padding:0;background-color:transparent;border:0}a.close.disabled{pointer-events:none}.toast{max-width:350px;overflow:hidden;font-size:.875rem;background-color:rgba(255,255,255,.85);background-clip:padding-box;border:1px solid rgba(0,0,0,.1);box-shadow:0 .25rem .75rem rgba(0,0,0,.1);-webkit-backdrop-filter:blur(10px);backdrop-filter:blur(10px);opacity:0;border-radius:.25rem}.toast:not(:last-child){margin-bottom:.75rem}.toast.showing{opacity:1}.toast.show{display:block;opacity:1}.toast.hide{display:none}.toast-header{display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;padding:.25rem .75rem;color:#6c757d;background-color:rgba(255,255,255,.85);background-clip:padding-box;border-bottom:1px solid rgba(0,0,0,.05)}.toast-body{padding:.75rem}.modal-open{overflow:hidden}.modal-open .modal{overflow-x:hidden;overflow-y:auto}.modal{position:fixed;top:0;left:0;z-index:1050;display:none;width:100%;height:100%;overflow:hidden;outline:0}.modal-dialog{position:relative;width:auto;margin:.5rem;pointer-events:none}.modal.fade .modal-dialog{transition:-webkit-transform .3s ease-out;transition:transform .3s ease-out;transition:transform .3s ease-out,-webkit-transform .3s ease-out;-webkit-transform:translate(0,-50px);transform:translate(0,-50px)}@media(prefers-reduced-motion:reduce){.modal.fade .modal-dialog{transition:none}}.modal.show .modal-dialog{-webkit-transform:none;transform:none}.modal.modal-static .modal-dialog{-webkit-transform:scale(1.02);transform:scale(1.02)}.modal-dialog-scrollable{display:-ms-flexbox;display:flex;max-height:calc(100% - 1rem)}.modal-dialog-scrollable .modal-content{max-height:calc(100vh - 1rem);overflow:hidden}.modal-dialog-scrollable .modal-footer,.modal-dialog-scrollable .modal-header{-ms-flex-negative:0;flex-shrink:0}.modal-dialog-scrollable .modal-body{overflow-y:auto}.modal-dialog-centered{display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;min-height:calc(100% - 1rem)}.modal-dialog-centered::before{display:block;height:calc(100vh - 1rem);height:-webkit-min-content;height:-moz-min-content;height:min-content;content:""}.modal-dialog-centered.modal-dialog-scrollable{-ms-flex-direction:column;flex-direction:column;-ms-flex-pack:center;justify-content:center;height:100%}.modal-dialog-centered.modal-dialog-scrollable .modal-content{max-height:none}.modal-dialog-centered.modal-dialog-scrollable::before{content:none}.modal-content{position:relative;display:-ms-flexbox;display:flex;-ms-flex-direction:column;flex-direction:column;width:100%;pointer-events:auto;background-color:#fff;background-clip:padding-box;border:1px solid rgba(0,0,0,.2);border-radius:.3rem;outline:0}.modal-backdrop{position:fixed;top:0;left:0;z-index:1040;width:100vw;height:100vh;background-color:#000}.modal-backdrop.fade{opacity:0}.modal-backdrop.show{opacity:.5}.modal-header{display:-ms-flexbox;display:flex;-ms-flex-align:start;align-items:flex-start;-ms-flex-pack:justify;justify-content:space-between;padding:1rem 1rem;border-bottom:1px solid #dee2e6;border-top-left-radius:calc(.3rem - 1px);border-top-right-radius:calc(.3rem - 1px)}.modal-header .close{padding:1rem 1rem;margin:-1rem -1rem -1rem auto}.modal-title{margin-bottom:0;line-height:1.5}.modal-body{position:relative;-ms-flex:1 1 auto;flex:1 1 auto;padding:1rem}.modal-footer{display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-ms-flex-align:center;align-items:center;-ms-flex-pack:end;justify-content:flex-end;padding:.75rem;border-top:1px solid #dee2e6;border-bottom-right-radius:calc(.3rem - 1px);border-bottom-left-radius:calc(.3rem - 1px)}.modal-footer>*{margin:.25rem}.modal-scrollbar-measure{position:absolute;top:-9999px;width:50px;height:50px;overflow:scroll}@media(min-width:576px){.modal-dialog{max-width:500px;margin:1.75rem auto}.modal-dialog-scrollable{max-height:calc(100% - 3.5rem)}.modal-dialog-scrollable .modal-content{max-height:calc(100vh - 3.5rem)}.modal-dialog-centered{min-height:calc(100% - 3.5rem)}.modal-dialog-centered::before{height:calc(100vh - 3.5rem);height:-webkit-min-content;height:-moz-min-content;height:min-content}.modal-sm{max-width:300px}}@media(min-width:992px){.modal-lg,.modal-xl{max-width:800px}}@media(min-width:1200px){.modal-xl{max-width:1140px}}.tooltip{position:absolute;z-index:1070;display:block;margin:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";font-style:normal;font-weight:400;line-height:1.5;text-align:left;text-align:start;text-decoration:none;text-shadow:none;text-transform:none;letter-spacing:normal;word-break:normal;word-spacing:normal;white-space:normal;line-break:auto;font-size:.875rem;word-wrap:break-word;opacity:0}.tooltip.show{opacity:.9}.tooltip .arrow{position:absolute;display:block;width:.8rem;height:.4rem}.tooltip .arrow::before{position:absolute;content:"";border-color:transparent;border-style:solid}.bs-tooltip-auto[x-placement^=top],.bs-tooltip-top{padding:.4rem 0}.bs-tooltip-auto[x-placement^=top] .arrow,.bs-tooltip-top .arrow{bottom:0}.bs-tooltip-auto[x-placement^=top] .arrow::before,.bs-tooltip-top .arrow::before{top:0;border-width:.4rem .4rem 0;border-top-color:#000}.bs-tooltip-auto[x-placement^=right],.bs-tooltip-right{padding:0 .4rem}.bs-tooltip-auto[x-placement^=right] .arrow,.bs-tooltip-right .arrow{left:0;width:.4rem;height:.8rem}.bs-tooltip-auto[x-placement^=right] .arrow::before,.bs-tooltip-right .arrow::before{right:0;border-width:.4rem .4rem .4rem 0;border-right-color:#000}.bs-tooltip-auto[x-placement^=bottom],.bs-tooltip-bottom{padding:.4rem 0}.bs-tooltip-auto[x-placement^=bottom] .arrow,.bs-tooltip-bottom .arrow{top:0}.bs-tooltip-auto[x-placement^=bottom] .arrow::before,.bs-tooltip-bottom .arrow::before{bottom:0;border-width:0 .4rem .4rem;border-bottom-color:#000}.bs-tooltip-auto[x-placement^=left],.bs-tooltip-left{padding:0 .4rem}.bs-tooltip-auto[x-placement^=left] .arrow,.bs-tooltip-left .arrow{right:0;width:.4rem;height:.8rem}.bs-tooltip-auto[x-placement^=left] .arrow::before,.bs-tooltip-left .arrow::before{left:0;border-width:.4rem 0 .4rem .4rem;border-left-color:#000}.tooltip-inner{max-width:200px;padding:.25rem .5rem;color:#fff;text-align:center;background-color:#000;border-radius:.25rem}.popover{position:absolute;top:0;left:0;z-index:1060;display:block;max-width:276px;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";font-style:normal;font-weight:400;line-height:1.5;text-align:left;text-align:start;text-decoration:none;text-shadow:none;text-transform:none;letter-spacing:normal;word-break:normal;word-spacing:normal;white-space:normal;line-break:auto;font-size:.875rem;word-wrap:break-word;background-color:#fff;background-clip:padding-box;border:1px solid rgba(0,0,0,.2);border-radius:.3rem}.popover .arrow{position:absolute;display:block;width:1rem;height:.5rem;margin:0 .3rem}.popover .arrow::after,.popover .arrow::before{position:absolute;display:block;content:"";border-color:transparent;border-style:solid}.bs-popover-auto[x-placement^=top],.bs-popover-top{margin-bottom:.5rem}.bs-popover-auto[x-placement^=top]>.arrow,.bs-popover-top>.arrow{bottom:calc(-.5rem - 1px)}.bs-popover-auto[x-placement^=top]>.arrow::before,.bs-popover-top>.arrow::before{bottom:0;border-width:.5rem .5rem 0;border-top-color:rgba(0,0,0,.25)}.bs-popover-auto[x-placement^=top]>.arrow::after,.bs-popover-top>.arrow::after{bottom:1px;border-width:.5rem .5rem 0;border-top-color:#fff}.bs-popover-auto[x-placement^=right],.bs-popover-right{margin-left:.5rem}.bs-popover-auto[x-placement^=right]>.arrow,.bs-popover-right>.arrow{left:calc(-.5rem - 1px);width:.5rem;height:1rem;margin:.3rem 0}.bs-popover-auto[x-placement^=right]>.arrow::before,.bs-popover-right>.arrow::before{left:0;border-width:.5rem .5rem .5rem 0;border-right-color:rgba(0,0,0,.25)}.bs-popover-auto[x-placement^=right]>.arrow::after,.bs-popover-right>.arrow::after{left:1px;border-width:.5rem .5rem .5rem 0;border-right-color:#fff}.bs-popover-auto[x-placement^=bottom],.bs-popover-bottom{margin-top:.5rem}.bs-popover-auto[x-placement^=bottom]>.arrow,.bs-popover-bottom>.arrow{top:calc(-.5rem - 1px)}.bs-popover-auto[x-placement^=bottom]>.arrow::before,.bs-popover-bottom>.arrow::before{top:0;border-width:0 .5rem .5rem .5rem;border-bottom-color:rgba(0,0,0,.25)}.bs-popover-auto[x-placement^=bottom]>.arrow::after,.bs-popover-bottom>.arrow::after{top:1px;border-width:0 .5rem .5rem .5rem;border-bottom-color:#fff}.bs-popover-auto[x-placement^=bottom] .popover-header::before,.bs-popover-bottom .popover-header::before{position:absolute;top:0;left:50%;display:block;width:1rem;margin-left:-.5rem;content:"";border-bottom:1px solid #f7f7f7}.bs-popover-auto[x-placement^=left],.bs-popover-left{margin-right:.5rem}.bs-popover-auto[x-placement^=left]>.arrow,.bs-popover-left>.arrow{right:calc(-.5rem - 1px);width:.5rem;height:1rem;margin:.3rem 0}.bs-popover-auto[x-placement^=left]>.arrow::before,.bs-popover-left>.arrow::before{right:0;border-width:.5rem 0 .5rem .5rem;border-left-color:rgba(0,0,0,.25)}.bs-popover-auto[x-placement^=left]>.arrow::after,.bs-popover-left>.arrow::after{right:1px;border-width:.5rem 0 .5rem .5rem;border-left-color:#fff}.popover-header{padding:.5rem .75rem;margin-bottom:0;font-size:1rem;background-color:#f7f7f7;border-bottom:1px solid #ebebeb;border-top-left-radius:calc(.3rem - 1px);border-top-right-radius:calc(.3rem - 1px)}.popover-header:empty{display:none}.popover-body{padding:.5rem .75rem;color:#212529}.carousel{position:relative}.carousel.pointer-event{-ms-touch-action:pan-y;touch-action:pan-y}.carousel-inner{position:relative;width:100%;overflow:hidden}.carousel-inner::after{display:block;clear:both;content:""}.carousel-item{position:relative;display:none;float:left;width:100%;margin-right:-100%;-webkit-backface-visibility:hidden;backface-visibility:hidden;transition:-webkit-transform .6s ease-in-out;transition:transform .6s ease-in-out;transition:transform .6s ease-in-out,-webkit-transform .6s ease-in-out}@media(prefers-reduced-motion:reduce){.carousel-item{transition:none}}.carousel-item-next,.carousel-item-prev,.carousel-item.active{display:block}.active.carousel-item-right,.carousel-item-next:not(.carousel-item-left){-webkit-transform:translateX(100%);transform:translateX(100%)}.active.carousel-item-left,.carousel-item-prev:not(.carousel-item-right){-webkit-transform:translateX(-100%);transform:translateX(-100%)}.carousel-fade .carousel-item{opacity:0;transition-property:opacity;-webkit-transform:none;transform:none}.carousel-fade .carousel-item-next.carousel-item-left,.carousel-fade .carousel-item-prev.carousel-item-right,.carousel-fade .carousel-item.active{z-index:1;opacity:1}.carousel-fade .active.carousel-item-left,.carousel-fade .active.carousel-item-right{z-index:0;opacity:0;transition:opacity 0s .6s}@media(prefers-reduced-motion:reduce){.carousel-fade .active.carousel-item-left,.carousel-fade .active.carousel-item-right{transition:none}}.carousel-control-next,.carousel-control-prev{position:absolute;top:0;bottom:0;z-index:1;display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;-ms-flex-pack:center;justify-content:center;width:15%;color:#fff;text-align:center;opacity:.5;transition:opacity .15s ease}@media(prefers-reduced-motion:reduce){.carousel-control-next,.carousel-control-prev{transition:none}}.carousel-control-next:focus,.carousel-control-next:hover,.carousel-control-prev:focus,.carousel-control-prev:hover{color:#fff;text-decoration:none;outline:0;opacity:.9}.carousel-control-prev{left:0}.carousel-control-next{right:0}.carousel-control-next-icon,.carousel-control-prev-icon{display:inline-block;width:20px;height:20px;background:no-repeat 50%/100% 100%}.carousel-control-prev-icon{background-image:url("data:image/svg+xml,%3csvgxmlns='http://www.w3.org/2000/svg'fill='%23fff'width='8'height='8'viewBox='0088'%3e%3cpathd='M5.250l-44441.5-1.5L4.254l2.5-2.5L5.250z'/%3e%3c/svg%3e")}.carousel-control-next-icon{background-image:url("data:image/svg+xml,%3csvgxmlns='http://www.w3.org/2000/svg'fill='%23fff'width='8'height='8'viewBox='0088'%3e%3cpathd='M2.750l-1.51.5L3.754l-2.52.5L2.758l4-4-4-4z'/%3e%3c/svg%3e")}.carousel-indicators{position:absolute;right:0;bottom:0;left:0;z-index:15;display:-ms-flexbox;display:flex;-ms-flex-pack:center;justify-content:center;padding-left:0;margin-right:15%;margin-left:15%;list-style:none}.carousel-indicators li{box-sizing:content-box;-ms-flex:0 1 auto;flex:0 1 auto;width:30px;height:3px;margin-right:3px;margin-left:3px;text-indent:-999px;cursor:pointer;background-color:#fff;background-clip:padding-box;border-top:10px solid transparent;border-bottom:10px solid transparent;opacity:.5;transition:opacity .6s ease}@media(prefers-reduced-motion:reduce){.carousel-indicators li{transition:none}}.carousel-indicators .active{opacity:1}.carousel-caption{position:absolute;right:15%;bottom:20px;left:15%;z-index:10;padding-top:20px;padding-bottom:20px;color:#fff;text-align:center}@-webkit-keyframes spinner-border{to{-webkit-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes spinner-border{to{-webkit-transform:rotate(360deg);transform:rotate(360deg)}}.spinner-border{display:inline-block;width:2rem;height:2rem;vertical-align:text-bottom;border:.25em solid currentColor;border-right-color:transparent;border-radius:50%;-webkit-animation:spinner-border .75s linear infinite;animation:spinner-border .75s linear infinite}.spinner-border-sm{width:1rem;height:1rem;border-width:.2em}@-webkit-keyframes spinner-grow{0%{-webkit-transform:scale(0);transform:scale(0)}50%{opacity:1;-webkit-transform:none;transform:none}}@keyframes spinner-grow{0%{-webkit-transform:scale(0);transform:scale(0)}50%{opacity:1;-webkit-transform:none;transform:none}}.spinner-grow{display:inline-block;width:2rem;height:2rem;vertical-align:text-bottom;background-color:currentColor;border-radius:50%;opacity:0;-webkit-animation:spinner-grow .75s linear infinite;animation:spinner-grow .75s linear infinite}.spinner-grow-sm{width:1rem;height:1rem}.align-baseline{vertical-align:baseline!important}.align-top{vertical-align:top!important}.align-middle{vertical-align:middle!important}.align-bottom{vertical-align:bottom!important}.align-text-bottom{vertical-align:text-bottom!important}.align-text-top{vertical-align:text-top!important}.bg-primary{background-color:#007bff!important}a.bg-primary:focus,a.bg-primary:hover,button.bg-primary:focus,button.bg-primary:hover{background-color:#0062cc!important}.bg-secondary{background-color:#6c757d!important}a.bg-secondary:focus,a.bg-secondary:hover,button.bg-secondary:focus,button.bg-secondary:hover{background-color:#545b62!important}.bg-success{background-color:#28a745!important}a.bg-success:focus,a.bg-success:hover,button.bg-success:focus,button.bg-success:hover{background-color:#1e7e34!important}.bg-info{background-color:#17a2b8!important}a.bg-info:focus,a.bg-info:hover,button.bg-info:focus,button.bg-info:hover{background-color:#117a8b!important}.bg-warning{background-color:#ffc107!important}a.bg-warning:focus,a.bg-warning:hover,button.bg-warning:focus,button.bg-warning:hover{background-color:#d39e00!important}.bg-danger{background-color:#dc3545!important}a.bg-danger:focus,a.bg-danger:hover,button.bg-danger:focus,button.bg-danger:hover{background-color:#bd2130!important}.bg-light{background-color:#f8f9fa!important}a.bg-light:focus,a.bg-light:hover,button.bg-light:focus,button.bg-light:hover{background-color:#dae0e5!important}.bg-dark{background-color:#343a40!important}a.bg-dark:focus,a.bg-dark:hover,button.bg-dark:focus,button.bg-dark:hover{background-color:#1d2124!important}.bg-white{background-color:#fff!important}.bg-transparent{background-color:transparent!important}.border{border:1px solid #dee2e6!important}.border-top{border-top:1px solid #dee2e6!important}.border-right{border-right:1px solid #dee2e6!important}.border-bottom{border-bottom:1px solid #dee2e6!important}.border-left{border-left:1px solid #dee2e6!important}.border-0{border:0!important}.border-top-0{border-top:0!important}.border-right-0{border-right:0!important}.border-bottom-0{border-bottom:0!important}.border-left-0{border-left:0!important}.border-primary{border-color:#007bff!important}.border-secondary{border-color:#6c757d!important}.border-success{border-color:#28a745!important}.border-info{border-color:#17a2b8!important}.border-warning{border-color:#ffc107!important}.border-danger{border-color:#dc3545!important}.border-light{border-color:#f8f9fa!important}.border-dark{border-color:#343a40!important}.border-white{border-color:#fff!important}.rounded-sm{border-radius:.2rem!important}.rounded{border-radius:.25rem!important}.rounded-top{border-top-left-radius:.25rem!important;border-top-right-radius:.25rem!important}.rounded-right{border-top-right-radius:.25rem!important;border-bottom-right-radius:.25rem!important}.rounded-bottom{border-bottom-right-radius:.25rem!important;border-bottom-left-radius:.25rem!important}.rounded-left{border-top-left-radius:.25rem!important;border-bottom-left-radius:.25rem!important}.rounded-lg{border-radius:.3rem!important}.rounded-circle{border-radius:50%!important}.rounded-pill{border-radius:50rem!important}.rounded-0{border-radius:0!important}.clearfix::after{display:block;clear:both;content:""}.d-none{display:none!important}.d-inline{display:inline!important}.d-inline-block{display:inline-block!important}.d-block{display:block!important}.d-table{display:table!important}.d-table-row{display:table-row!important}.d-table-cell{display:table-cell!important}.d-flex{display:-ms-flexbox!important;display:flex!important}.d-inline-flex{display:-ms-inline-flexbox!important;display:inline-flex!important}@media(min-width:576px){.d-sm-none{display:none!important}.d-sm-inline{display:inline!important}.d-sm-inline-block{display:inline-block!important}.d-sm-block{display:block!important}.d-sm-table{display:table!important}.d-sm-table-row{display:table-row!important}.d-sm-table-cell{display:table-cell!important}.d-sm-flex{display:-ms-flexbox!important;display:flex!important}.d-sm-inline-flex{display:-ms-inline-flexbox!important;display:inline-flex!important}}@media(min-width:768px){.d-md-none{display:none!important}.d-md-inline{display:inline!important}.d-md-inline-block{display:inline-block!important}.d-md-block{display:block!important}.d-md-table{display:table!important}.d-md-table-row{display:table-row!important}.d-md-table-cell{display:table-cell!important}.d-md-flex{display:-ms-flexbox!important;display:flex!important}.d-md-inline-flex{display:-ms-inline-flexbox!important;display:inline-flex!important}}@media(min-width:992px){.d-lg-none{display:none!important}.d-lg-inline{display:inline!important}.d-lg-inline-block{display:inline-block!important}.d-lg-block{display:block!important}.d-lg-table{display:table!important}.d-lg-table-row{display:table-row!important}.d-lg-table-cell{display:table-cell!important}.d-lg-flex{display:-ms-flexbox!important;display:flex!important}.d-lg-inline-flex{display:-ms-inline-flexbox!important;display:inline-flex!important}}@media(min-width:1200px){.d-xl-none{display:none!important}.d-xl-inline{display:inline!important}.d-xl-inline-block{display:inline-block!important}.d-xl-block{display:block!important}.d-xl-table{display:table!important}.d-xl-table-row{display:table-row!important}.d-xl-table-cell{display:table-cell!important}.d-xl-flex{display:-ms-flexbox!important;display:flex!important}.d-xl-inline-flex{display:-ms-inline-flexbox!important;display:inline-flex!important}}@media print{.d-print-none{display:none!important}.d-print-inline{display:inline!important}.d-print-inline-block{display:inline-block!important}.d-print-block{display:block!important}.d-print-table{display:table!important}.d-print-table-row{display:table-row!important}.d-print-table-cell{display:table-cell!important}.d-print-flex{display:-ms-flexbox!important;display:flex!important}.d-print-inline-flex{display:-ms-inline-flexbox!important;display:inline-flex!important}}.embed-responsive{position:relative;display:block;width:100%;padding:0;overflow:hidden}.embed-responsive::before{display:block;content:""}.embed-responsive .embed-responsive-item,.embed-responsive embed,.embed-responsive iframe,.embed-responsive object,.embed-responsive video{position:absolute;top:0;bottom:0;left:0;width:100%;height:100%;border:0}.embed-responsive-21by9::before{padding-top:42.857143%}.embed-responsive-16by9::before{padding-top:56.25%}.embed-responsive-4by3::before{padding-top:75%}.embed-responsive-1by1::before{padding-top:100%}.flex-row{-ms-flex-direction:row!important;flex-direction:row!important}.flex-column{-ms-flex-direction:column!important;flex-direction:column!important}.flex-row-reverse{-ms-flex-direction:row-reverse!important;flex-direction:row-reverse!important}.flex-column-reverse{-ms-flex-direction:column-reverse!important;flex-direction:column-reverse!important}.flex-wrap{-ms-flex-wrap:wrap!important;flex-wrap:wrap!important}.flex-nowrap{-ms-flex-wrap:nowrap!important;flex-wrap:nowrap!important}.flex-wrap-reverse{-ms-flex-wrap:wrap-reverse!important;flex-wrap:wrap-reverse!important}.flex-fill{-ms-flex:1 1 auto!important;flex:1 1 auto!important}.flex-grow-0{-ms-flex-positive:0!important;flex-grow:0!important}.flex-grow-1{-ms-flex-positive:1!important;flex-grow:1!important}.flex-shrink-0{-ms-flex-negative:0!important;flex-shrink:0!important}.flex-shrink-1{-ms-flex-negative:1!important;flex-shrink:1!important}.justify-content-start{-ms-flex-pack:start!important;justify-content:flex-start!important}.justify-content-end{-ms-flex-pack:end!important;justify-content:flex-end!important}.justify-content-center{-ms-flex-pack:center!important;justify-content:center!important}.justify-content-between{-ms-flex-pack:justify!important;justify-content:space-between!important}.justify-content-around{-ms-flex-pack:distribute!important;justify-content:space-around!important}.align-items-start{-ms-flex-align:start!important;align-items:flex-start!important}.align-items-end{-ms-flex-align:end!important;align-items:flex-end!important}.align-items-center{-ms-flex-align:center!important;align-items:center!important}.align-items-baseline{-ms-flex-align:baseline!important;align-items:baseline!important}.align-items-stretch{-ms-flex-align:stretch!important;align-items:stretch!important}.align-content-start{-ms-flex-line-pack:start!important;align-content:flex-start!important}.align-content-end{-ms-flex-line-pack:end!important;align-content:flex-end!important}.align-content-center{-ms-flex-line-pack:center!important;align-content:center!important}.align-content-between{-ms-flex-line-pack:justify!important;align-content:space-between!important}.align-content-around{-ms-flex-line-pack:distribute!important;align-content:space-around!important}.align-content-stretch{-ms-flex-line-pack:stretch!important;align-content:stretch!important}.align-self-auto{-ms-flex-item-align:auto!important;align-self:auto!important}.align-self-start{-ms-flex-item-align:start!important;align-self:flex-start!important}.align-self-end{-ms-flex-item-align:end!important;align-self:flex-end!important}.align-self-center{-ms-flex-item-align:center!important;align-self:center!important}.align-self-baseline{-ms-flex-item-align:baseline!important;align-self:baseline!important}.align-self-stretch{-ms-flex-item-align:stretch!important;align-self:stretch!important}@media(min-width:576px){.flex-sm-row{-ms-flex-direction:row!important;flex-direction:row!important}.flex-sm-column{-ms-flex-direction:column!important;flex-direction:column!important}.flex-sm-row-reverse{-ms-flex-direction:row-reverse!important;flex-direction:row-reverse!important}.flex-sm-column-reverse{-ms-flex-direction:column-reverse!important;flex-direction:column-reverse!important}.flex-sm-wrap{-ms-flex-wrap:wrap!important;flex-wrap:wrap!important}.flex-sm-nowrap{-ms-flex-wrap:nowrap!important;flex-wrap:nowrap!important}.flex-sm-wrap-reverse{-ms-flex-wrap:wrap-reverse!important;flex-wrap:wrap-reverse!important}.flex-sm-fill{-ms-flex:1 1 auto!important;flex:1 1 auto!important}.flex-sm-grow-0{-ms-flex-positive:0!important;flex-grow:0!important}.flex-sm-grow-1{-ms-flex-positive:1!important;flex-grow:1!important}.flex-sm-shrink-0{-ms-flex-negative:0!important;flex-shrink:0!important}.flex-sm-shrink-1{-ms-flex-negative:1!important;flex-shrink:1!important}.justify-content-sm-start{-ms-flex-pack:start!important;justify-content:flex-start!important}.justify-content-sm-end{-ms-flex-pack:end!important;justify-content:flex-end!important}.justify-content-sm-center{-ms-flex-pack:center!important;justify-content:center!important}.justify-content-sm-between{-ms-flex-pack:justify!important;justify-content:space-between!important}.justify-content-sm-around{-ms-flex-pack:distribute!important;justify-content:space-around!important}.align-items-sm-start{-ms-flex-align:start!important;align-items:flex-start!important}.align-items-sm-end{-ms-flex-align:end!important;align-items:flex-end!important}.align-items-sm-center{-ms-flex-align:center!important;align-items:center!important}.align-items-sm-baseline{-ms-flex-align:baseline!important;align-items:baseline!important}.align-items-sm-stretch{-ms-flex-align:stretch!important;align-items:stretch!important}.align-content-sm-start{-ms-flex-line-pack:start!important;align-content:flex-start!important}.align-content-sm-end{-ms-flex-line-pack:end!important;align-content:flex-end!important}.align-content-sm-center{-ms-flex-line-pack:center!important;align-content:center!important}.align-content-sm-between{-ms-flex-line-pack:justify!important;align-content:space-between!important}.align-content-sm-around{-ms-flex-line-pack:distribute!important;align-content:space-around!important}.align-content-sm-stretch{-ms-flex-line-pack:stretch!important;align-content:stretch!important}.align-self-sm-auto{-ms-flex-item-align:auto!important;align-self:auto!important}.align-self-sm-start{-ms-flex-item-align:start!important;align-self:flex-start!important}.align-self-sm-end{-ms-flex-item-align:end!important;align-self:flex-end!important}.align-self-sm-center{-ms-flex-item-align:center!important;align-self:center!important}.align-self-sm-baseline{-ms-flex-item-align:baseline!important;align-self:baseline!important}.align-self-sm-stretch{-ms-flex-item-align:stretch!important;align-self:stretch!important}}@media(min-width:768px){.flex-md-row{-ms-flex-direction:row!important;flex-direction:row!important}.flex-md-column{-ms-flex-direction:column!important;flex-direction:column!important}.flex-md-row-reverse{-ms-flex-direction:row-reverse!important;flex-direction:row-reverse!important}.flex-md-column-reverse{-ms-flex-direction:column-reverse!important;flex-direction:column-reverse!important}.flex-md-wrap{-ms-flex-wrap:wrap!important;flex-wrap:wrap!important}.flex-md-nowrap{-ms-flex-wrap:nowrap!important;flex-wrap:nowrap!important}.flex-md-wrap-reverse{-ms-flex-wrap:wrap-reverse!important;flex-wrap:wrap-reverse!important}.flex-md-fill{-ms-flex:1 1 auto!important;flex:1 1 auto!important}.flex-md-grow-0{-ms-flex-positive:0!important;flex-grow:0!important}.flex-md-grow-1{-ms-flex-positive:1!important;flex-grow:1!important}.flex-md-shrink-0{-ms-flex-negative:0!important;flex-shrink:0!important}.flex-md-shrink-1{-ms-flex-negative:1!important;flex-shrink:1!important}.justify-content-md-start{-ms-flex-pack:start!important;justify-content:flex-start!important}.justify-content-md-end{-ms-flex-pack:end!important;justify-content:flex-end!important}.justify-content-md-center{-ms-flex-pack:center!important;justify-content:center!important}.justify-content-md-between{-ms-flex-pack:justify!important;justify-content:space-between!important}.justify-content-md-around{-ms-flex-pack:distribute!important;justify-content:space-around!important}.align-items-md-start{-ms-flex-align:start!important;align-items:flex-start!important}.align-items-md-end{-ms-flex-align:end!important;align-items:flex-end!important}.align-items-md-center{-ms-flex-align:center!important;align-items:center!important}.align-items-md-baseline{-ms-flex-align:baseline!important;align-items:baseline!important}.align-items-md-stretch{-ms-flex-align:stretch!important;align-items:stretch!important}.align-content-md-start{-ms-flex-line-pack:start!important;align-content:flex-start!important}.align-content-md-end{-ms-flex-line-pack:end!important;align-content:flex-end!important}.align-content-md-center{-ms-flex-line-pack:center!important;align-content:center!important}.align-content-md-between{-ms-flex-line-pack:justify!important;align-content:space-between!important}.align-content-md-around{-ms-flex-line-pack:distribute!important;align-content:space-around!important}.align-content-md-stretch{-ms-flex-line-pack:stretch!important;align-content:stretch!important}.align-self-md-auto{-ms-flex-item-align:auto!important;align-self:auto!important}.align-self-md-start{-ms-flex-item-align:start!important;align-self:flex-start!important}.align-self-md-end{-ms-flex-item-align:end!important;align-self:flex-end!important}.align-self-md-center{-ms-flex-item-align:center!important;align-self:center!important}.align-self-md-baseline{-ms-flex-item-align:baseline!important;align-self:baseline!important}.align-self-md-stretch{-ms-flex-item-align:stretch!important;align-self:stretch!important}}@media(min-width:992px){.flex-lg-row{-ms-flex-direction:row!important;flex-direction:row!important}.flex-lg-column{-ms-flex-direction:column!important;flex-direction:column!important}.flex-lg-row-reverse{-ms-flex-direction:row-reverse!important;flex-direction:row-reverse!important}.flex-lg-column-reverse{-ms-flex-direction:column-reverse!important;flex-direction:column-reverse!important}.flex-lg-wrap{-ms-flex-wrap:wrap!important;flex-wrap:wrap!important}.flex-lg-nowrap{-ms-flex-wrap:nowrap!important;flex-wrap:nowrap!important}.flex-lg-wrap-reverse{-ms-flex-wrap:wrap-reverse!important;flex-wrap:wrap-reverse!important}.flex-lg-fill{-ms-flex:1 1 auto!important;flex:1 1 auto!important}.flex-lg-grow-0{-ms-flex-positive:0!important;flex-grow:0!important}.flex-lg-grow-1{-ms-flex-positive:1!important;flex-grow:1!important}.flex-lg-shrink-0{-ms-flex-negative:0!important;flex-shrink:0!important}.flex-lg-shrink-1{-ms-flex-negative:1!important;flex-shrink:1!important}.justify-content-lg-start{-ms-flex-pack:start!important;justify-content:flex-start!important}.justify-content-lg-end{-ms-flex-pack:end!important;justify-content:flex-end!important}.justify-content-lg-center{-ms-flex-pack:center!important;justify-content:center!important}.justify-content-lg-between{-ms-flex-pack:justify!important;justify-content:space-between!important}.justify-content-lg-around{-ms-flex-pack:distribute!important;justify-content:space-around!important}.align-items-lg-start{-ms-flex-align:start!important;align-items:flex-start!important}.align-items-lg-end{-ms-flex-align:end!important;align-items:flex-end!important}.align-items-lg-center{-ms-flex-align:center!important;align-items:center!important}.align-items-lg-baseline{-ms-flex-align:baseline!important;align-items:baseline!important}.align-items-lg-stretch{-ms-flex-align:stretch!important;align-items:stretch!important}.align-content-lg-start{-ms-flex-line-pack:start!important;align-content:flex-start!important}.align-content-lg-end{-ms-flex-line-pack:end!important;align-content:flex-end!important}.align-content-lg-center{-ms-flex-line-pack:center!important;align-content:center!important}.align-content-lg-between{-ms-flex-line-pack:justify!important;align-content:space-between!important}.align-content-lg-around{-ms-flex-line-pack:distribute!important;align-content:space-around!important}.align-content-lg-stretch{-ms-flex-line-pack:stretch!important;align-content:stretch!important}.align-self-lg-auto{-ms-flex-item-align:auto!important;align-self:auto!important}.align-self-lg-start{-ms-flex-item-align:start!important;align-self:flex-start!important}.align-self-lg-end{-ms-flex-item-align:end!important;align-self:flex-end!important}.align-self-lg-center{-ms-flex-item-align:center!important;align-self:center!important}.align-self-lg-baseline{-ms-flex-item-align:baseline!important;align-self:baseline!important}.align-self-lg-stretch{-ms-flex-item-align:stretch!important;align-self:stretch!important}}@media(min-width:1200px){.flex-xl-row{-ms-flex-direction:row!important;flex-direction:row!important}.flex-xl-column{-ms-flex-direction:column!important;flex-direction:column!important}.flex-xl-row-reverse{-ms-flex-direction:row-reverse!important;flex-direction:row-reverse!important}.flex-xl-column-reverse{-ms-flex-direction:column-reverse!important;flex-direction:column-reverse!important}.flex-xl-wrap{-ms-flex-wrap:wrap!important;flex-wrap:wrap!important}.flex-xl-nowrap{-ms-flex-wrap:nowrap!important;flex-wrap:nowrap!important}.flex-xl-wrap-reverse{-ms-flex-wrap:wrap-reverse!important;flex-wrap:wrap-reverse!important}.flex-xl-fill{-ms-flex:1 1 auto!important;flex:1 1 auto!important}.flex-xl-grow-0{-ms-flex-positive:0!important;flex-grow:0!important}.flex-xl-grow-1{-ms-flex-positive:1!important;flex-grow:1!important}.flex-xl-shrink-0{-ms-flex-negative:0!important;flex-shrink:0!important}.flex-xl-shrink-1{-ms-flex-negative:1!important;flex-shrink:1!important}.justify-content-xl-start{-ms-flex-pack:start!important;justify-content:flex-start!important}.justify-content-xl-end{-ms-flex-pack:end!important;justify-content:flex-end!important}.justify-content-xl-center{-ms-flex-pack:center!important;justify-content:center!important}.justify-content-xl-between{-ms-flex-pack:justify!important;justify-content:space-between!important}.justify-content-xl-around{-ms-flex-pack:distribute!important;justify-content:space-around!important}.align-items-xl-start{-ms-flex-align:start!important;align-items:flex-start!important}.align-items-xl-end{-ms-flex-align:end!important;align-items:flex-end!important}.align-items-xl-center{-ms-flex-align:center!important;align-items:center!important}.align-items-xl-baseline{-ms-flex-align:baseline!important;align-items:baseline!important}.align-items-xl-stretch{-ms-flex-align:stretch!important;align-items:stretch!important}.align-content-xl-start{-ms-flex-line-pack:start!important;align-content:flex-start!important}.align-content-xl-end{-ms-flex-line-pack:end!important;align-content:flex-end!important}.align-content-xl-center{-ms-flex-line-pack:center!important;align-content:center!important}.align-content-xl-between{-ms-flex-line-pack:justify!important;align-content:space-between!important}.align-content-xl-around{-ms-flex-line-pack:distribute!important;align-content:space-around!important}.align-content-xl-stretch{-ms-flex-line-pack:stretch!important;align-content:stretch!important}.align-self-xl-auto{-ms-flex-item-align:auto!important;align-self:auto!important}.align-self-xl-start{-ms-flex-item-align:start!important;align-self:flex-start!important}.align-self-xl-end{-ms-flex-item-align:end!important;align-self:flex-end!important}.align-self-xl-center{-ms-flex-item-align:center!important;align-self:center!important}.align-self-xl-baseline{-ms-flex-item-align:baseline!important;align-self:baseline!important}.align-self-xl-stretch{-ms-flex-item-align:stretch!important;align-self:stretch!important}}.float-left{float:left!important}.float-right{float:right!important}.float-none{float:none!important}@media(min-width:576px){.float-sm-left{float:left!important}.float-sm-right{float:right!important}.float-sm-none{float:none!important}}@media(min-width:768px){.float-md-left{float:left!important}.float-md-right{float:right!important}.float-md-none{float:none!important}}@media(min-width:992px){.float-lg-left{float:left!important}.float-lg-right{float:right!important}.float-lg-none{float:none!important}}@media(min-width:1200px){.float-xl-left{float:left!important}.float-xl-right{float:right!important}.float-xl-none{float:none!important}}.user-select-all{-webkit-user-select:all!important;-moz-user-select:all!important;-ms-user-select:all!important;user-select:all!important}.user-select-auto{-webkit-user-select:auto!important;-moz-user-select:auto!important;-ms-user-select:auto!important;user-select:auto!important}.user-select-none{-webkit-user-select:none!important;-moz-user-select:none!important;-ms-user-select:none!important;user-select:none!important}.overflow-auto{overflow:auto!important}.overflow-hidden{overflow:hidden!important}.position-static{position:static!important}.position-relative{position:relative!important}.position-absolute{position:absolute!important}.position-fixed{position:fixed!important}.position-sticky{position:-webkit-sticky!important;position:sticky!important}.fixed-top{position:fixed;top:0;right:0;left:0;z-index:1030}.fixed-bottom{position:fixed;right:0;bottom:0;left:0;z-index:1030}@supports((position:-webkit-sticky) or(position:sticky)){.sticky-top{position:-webkit-sticky;position:sticky;top:0;z-index:1020}}.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}.sr-only-focusable:active,.sr-only-focusable:focus{position:static;width:auto;height:auto;overflow:visible;clip:auto;white-space:normal}.shadow-sm{box-shadow:0 .125rem .25rem rgba(0,0,0,.075)!important}.shadow{box-shadow:0 .5rem 1rem rgba(0,0,0,.15)!important}.shadow-lg{box-shadow:0 1rem 3rem rgba(0,0,0,.175)!important}.shadow-none{box-shadow:none!important}.w-25{width:25%!important}.w-50{width:50%!important}.w-75{width:75%!important}.w-100{width:100%!important}.w-auto{width:auto!important}.h-25{height:25%!important}.h-50{height:50%!important}.h-75{height:75%!important}.h-100{height:100%!important}.h-auto{height:auto!important}.mw-100{max-width:100%!important}.mh-100{max-height:100%!important}.min-vw-100{min-width:100vw!important}.min-vh-100{min-height:100vh!important}.vw-100{width:100vw!important}.vh-100{height:100vh!important}.m-0{margin:0!important}.mt-0,.my-0{margin-top:0!important}.mr-0,.mx-0{margin-right:0!important}.mb-0,.my-0{margin-bottom:0!important}.ml-0,.mx-0{margin-left:0!important}.m-1{margin:.25rem!important}.mt-1,.my-1{margin-top:.25rem!important}.mr-1,.mx-1{margin-right:.25rem!important}.mb-1,.my-1{margin-bottom:.25rem!important}.ml-1,.mx-1{margin-left:.25rem!important}.m-2{margin:.5rem!important}.mt-2,.my-2{margin-top:.5rem!important}.mr-2,.mx-2{margin-right:.5rem!important}.mb-2,.my-2{margin-bottom:.5rem!important}.ml-2,.mx-2{margin-left:.5rem!important}.m-3{margin:1rem!important}.mt-3,.my-3{margin-top:1rem!important}.mr-3,.mx-3{margin-right:1rem!important}.mb-3,.my-3{margin-bottom:1rem!important}.ml-3,.mx-3{margin-left:1rem!important}.m-4{margin:1.5rem!important}.mt-4,.my-4{margin-top:1.5rem!important}.mr-4,.mx-4{margin-right:1.5rem!important}.mb-4,.my-4{margin-bottom:1.5rem!important}.ml-4,.mx-4{margin-left:1.5rem!important}.m-5{margin:3rem!important}.mt-5,.my-5{margin-top:3rem!important}.mr-5,.mx-5{margin-right:3rem!important}.mb-5,.my-5{margin-bottom:3rem!important}.ml-5,.mx-5{margin-left:3rem!important}.p-0{padding:0!important}.pt-0,.py-0{padding-top:0!important}.pr-0,.px-0{padding-right:0!important}.pb-0,.py-0{padding-bottom:0!important}.pl-0,.px-0{padding-left:0!important}.p-1{padding:.25rem!important}.pt-1,.py-1{padding-top:.25rem!important}.pr-1,.px-1{padding-right:.25rem!important}.pb-1,.py-1{padding-bottom:.25rem!important}.pl-1,.px-1{padding-left:.25rem!important}.p-2{padding:.5rem!important}.pt-2,.py-2{padding-top:.5rem!important}.pr-2,.px-2{padding-right:.5rem!important}.pb-2,.py-2{padding-bottom:.5rem!important}.pl-2,.px-2{padding-left:.5rem!important}.p-3{padding:1rem!important}.pt-3,.py-3{padding-top:1rem!important}.pr-3,.px-3{padding-right:1rem!important}.pb-3,.py-3{padding-bottom:1rem!important}.pl-3,.px-3{padding-left:1rem!important}.p-4{padding:1.5rem!important}.pt-4,.py-4{padding-top:1.5rem!important}.pr-4,.px-4{padding-right:1.5rem!important}.pb-4,.py-4{padding-bottom:1.5rem!important}.pl-4,.px-4{padding-left:1.5rem!important}.p-5{padding:3rem!important}.pt-5,.py-5{padding-top:3rem!important}.pr-5,.px-5{padding-right:3rem!important}.pb-5,.py-5{padding-bottom:3rem!important}.pl-5,.px-5{padding-left:3rem!important}.m-n1{margin:-.25rem!important}.mt-n1,.my-n1{margin-top:-.25rem!important}.mr-n1,.mx-n1{margin-right:-.25rem!important}.mb-n1,.my-n1{margin-bottom:-.25rem!important}.ml-n1,.mx-n1{margin-left:-.25rem!important}.m-n2{margin:-.5rem!important}.mt-n2,.my-n2{margin-top:-.5rem!important}.mr-n2,.mx-n2{margin-right:-.5rem!important}.mb-n2,.my-n2{margin-bottom:-.5rem!important}.ml-n2,.mx-n2{margin-left:-.5rem!important}.m-n3{margin:-1rem!important}.mt-n3,.my-n3{margin-top:-1rem!important}.mr-n3,.mx-n3{margin-right:-1rem!important}.mb-n3,.my-n3{margin-bottom:-1rem!important}.ml-n3,.mx-n3{margin-left:-1rem!important}.m-n4{margin:-1.5rem!important}.mt-n4,.my-n4{margin-top:-1.5rem!important}.mr-n4,.mx-n4{margin-right:-1.5rem!important}.mb-n4,.my-n4{margin-bottom:-1.5rem!important}.ml-n4,.mx-n4{margin-left:-1.5rem!important}.m-n5{margin:-3rem!important}.mt-n5,.my-n5{margin-top:-3rem!important}.mr-n5,.mx-n5{margin-right:-3rem!important}.mb-n5,.my-n5{margin-bottom:-3rem!important}.ml-n5,.mx-n5{margin-left:-3rem!important}.m-auto{margin:auto!important}.mt-auto,.my-auto{margin-top:auto!important}.mr-auto,.mx-auto{margin-right:auto!important}.mb-auto,.my-auto{margin-bottom:auto!important}.ml-auto,.mx-auto{margin-left:auto!important}@media(min-width:576px){.m-sm-0{margin:0!important}.mt-sm-0,.my-sm-0{margin-top:0!important}.mr-sm-0,.mx-sm-0{margin-right:0!important}.mb-sm-0,.my-sm-0{margin-bottom:0!important}.ml-sm-0,.mx-sm-0{margin-left:0!important}.m-sm-1{margin:.25rem!important}.mt-sm-1,.my-sm-1{margin-top:.25rem!important}.mr-sm-1,.mx-sm-1{margin-right:.25rem!important}.mb-sm-1,.my-sm-1{margin-bottom:.25rem!important}.ml-sm-1,.mx-sm-1{margin-left:.25rem!important}.m-sm-2{margin:.5rem!important}.mt-sm-2,.my-sm-2{margin-top:.5rem!important}.mr-sm-2,.mx-sm-2{margin-right:.5rem!important}.mb-sm-2,.my-sm-2{margin-bottom:.5rem!important}.ml-sm-2,.mx-sm-2{margin-left:.5rem!important}.m-sm-3{margin:1rem!important}.mt-sm-3,.my-sm-3{margin-top:1rem!important}.mr-sm-3,.mx-sm-3{margin-right:1rem!important}.mb-sm-3,.my-sm-3{margin-bottom:1rem!important}.ml-sm-3,.mx-sm-3{margin-left:1rem!important}.m-sm-4{margin:1.5rem!important}.mt-sm-4,.my-sm-4{margin-top:1.5rem!important}.mr-sm-4,.mx-sm-4{margin-right:1.5rem!important}.mb-sm-4,.my-sm-4{margin-bottom:1.5rem!important}.ml-sm-4,.mx-sm-4{margin-left:1.5rem!important}.m-sm-5{margin:3rem!important}.mt-sm-5,.my-sm-5{margin-top:3rem!important}.mr-sm-5,.mx-sm-5{margin-right:3rem!important}.mb-sm-5,.my-sm-5{margin-bottom:3rem!important}.ml-sm-5,.mx-sm-5{margin-left:3rem!important}.p-sm-0{padding:0!important}.pt-sm-0,.py-sm-0{padding-top:0!important}.pr-sm-0,.px-sm-0{padding-right:0!important}.pb-sm-0,.py-sm-0{padding-bottom:0!important}.pl-sm-0,.px-sm-0{padding-left:0!important}.p-sm-1{padding:.25rem!important}.pt-sm-1,.py-sm-1{padding-top:.25rem!important}.pr-sm-1,.px-sm-1{padding-right:.25rem!important}.pb-sm-1,.py-sm-1{padding-bottom:.25rem!important}.pl-sm-1,.px-sm-1{padding-left:.25rem!important}.p-sm-2{padding:.5rem!important}.pt-sm-2,.py-sm-2{padding-top:.5rem!important}.pr-sm-2,.px-sm-2{padding-right:.5rem!important}.pb-sm-2,.py-sm-2{padding-bottom:.5rem!important}.pl-sm-2,.px-sm-2{padding-left:.5rem!important}.p-sm-3{padding:1rem!important}.pt-sm-3,.py-sm-3{padding-top:1rem!important}.pr-sm-3,.px-sm-3{padding-right:1rem!important}.pb-sm-3,.py-sm-3{padding-bottom:1rem!important}.pl-sm-3,.px-sm-3{padding-left:1rem!important}.p-sm-4{padding:1.5rem!important}.pt-sm-4,.py-sm-4{padding-top:1.5rem!important}.pr-sm-4,.px-sm-4{padding-right:1.5rem!important}.pb-sm-4,.py-sm-4{padding-bottom:1.5rem!important}.pl-sm-4,.px-sm-4{padding-left:1.5rem!important}.p-sm-5{padding:3rem!important}.pt-sm-5,.py-sm-5{padding-top:3rem!important}.pr-sm-5,.px-sm-5{padding-right:3rem!important}.pb-sm-5,.py-sm-5{padding-bottom:3rem!important}.pl-sm-5,.px-sm-5{padding-left:3rem!important}.m-sm-n1{margin:-.25rem!important}.mt-sm-n1,.my-sm-n1{margin-top:-.25rem!important}.mr-sm-n1,.mx-sm-n1{margin-right:-.25rem!important}.mb-sm-n1,.my-sm-n1{margin-bottom:-.25rem!important}.ml-sm-n1,.mx-sm-n1{margin-left:-.25rem!important}.m-sm-n2{margin:-.5rem!important}.mt-sm-n2,.my-sm-n2{margin-top:-.5rem!important}.mr-sm-n2,.mx-sm-n2{margin-right:-.5rem!important}.mb-sm-n2,.my-sm-n2{margin-bottom:-.5rem!important}.ml-sm-n2,.mx-sm-n2{margin-left:-.5rem!important}.m-sm-n3{margin:-1rem!important}.mt-sm-n3,.my-sm-n3{margin-top:-1rem!important}.mr-sm-n3,.mx-sm-n3{margin-right:-1rem!important}.mb-sm-n3,.my-sm-n3{margin-bottom:-1rem!important}.ml-sm-n3,.mx-sm-n3{margin-left:-1rem!important}.m-sm-n4{margin:-1.5rem!important}.mt-sm-n4,.my-sm-n4{margin-top:-1.5rem!important}.mr-sm-n4,.mx-sm-n4{margin-right:-1.5rem!important}.mb-sm-n4,.my-sm-n4{margin-bottom:-1.5rem!important}.ml-sm-n4,.mx-sm-n4{margin-left:-1.5rem!important}.m-sm-n5{margin:-3rem!important}.mt-sm-n5,.my-sm-n5{margin-top:-3rem!important}.mr-sm-n5,.mx-sm-n5{margin-right:-3rem!important}.mb-sm-n5,.my-sm-n5{margin-bottom:-3rem!important}.ml-sm-n5,.mx-sm-n5{margin-left:-3rem!important}.m-sm-auto{margin:auto!important}.mt-sm-auto,.my-sm-auto{margin-top:auto!important}.mr-sm-auto,.mx-sm-auto{margin-right:auto!important}.mb-sm-auto,.my-sm-auto{margin-bottom:auto!important}.ml-sm-auto,.mx-sm-auto{margin-left:auto!important}}@media(min-width:768px){.m-md-0{margin:0!important}.mt-md-0,.my-md-0{margin-top:0!important}.mr-md-0,.mx-md-0{margin-right:0!important}.mb-md-0,.my-md-0{margin-bottom:0!important}.ml-md-0,.mx-md-0{margin-left:0!important}.m-md-1{margin:.25rem!important}.mt-md-1,.my-md-1{margin-top:.25rem!important}.mr-md-1,.mx-md-1{margin-right:.25rem!important}.mb-md-1,.my-md-1{margin-bottom:.25rem!important}.ml-md-1,.mx-md-1{margin-left:.25rem!important}.m-md-2{margin:.5rem!important}.mt-md-2,.my-md-2{margin-top:.5rem!important}.mr-md-2,.mx-md-2{margin-right:.5rem!important}.mb-md-2,.my-md-2{margin-bottom:.5rem!important}.ml-md-2,.mx-md-2{margin-left:.5rem!important}.m-md-3{margin:1rem!important}.mt-md-3,.my-md-3{margin-top:1rem!important}.mr-md-3,.mx-md-3{margin-right:1rem!important}.mb-md-3,.my-md-3{margin-bottom:1rem!important}.ml-md-3,.mx-md-3{margin-left:1rem!important}.m-md-4{margin:1.5rem!important}.mt-md-4,.my-md-4{margin-top:1.5rem!important}.mr-md-4,.mx-md-4{margin-right:1.5rem!important}.mb-md-4,.my-md-4{margin-bottom:1.5rem!important}.ml-md-4,.mx-md-4{margin-left:1.5rem!important}.m-md-5{margin:3rem!important}.mt-md-5,.my-md-5{margin-top:3rem!important}.mr-md-5,.mx-md-5{margin-right:3rem!important}.mb-md-5,.my-md-5{margin-bottom:3rem!important}.ml-md-5,.mx-md-5{margin-left:3rem!important}.p-md-0{padding:0!important}.pt-md-0,.py-md-0{padding-top:0!important}.pr-md-0,.px-md-0{padding-right:0!important}.pb-md-0,.py-md-0{padding-bottom:0!important}.pl-md-0,.px-md-0{padding-left:0!important}.p-md-1{padding:.25rem!important}.pt-md-1,.py-md-1{padding-top:.25rem!important}.pr-md-1,.px-md-1{padding-right:.25rem!important}.pb-md-1,.py-md-1{padding-bottom:.25rem!important}.pl-md-1,.px-md-1{padding-left:.25rem!important}.p-md-2{padding:.5rem!important}.pt-md-2,.py-md-2{padding-top:.5rem!important}.pr-md-2,.px-md-2{padding-right:.5rem!important}.pb-md-2,.py-md-2{padding-bottom:.5rem!important}.pl-md-2,.px-md-2{padding-left:.5rem!important}.p-md-3{padding:1rem!important}.pt-md-3,.py-md-3{padding-top:1rem!important}.pr-md-3,.px-md-3{padding-right:1rem!important}.pb-md-3,.py-md-3{padding-bottom:1rem!important}.pl-md-3,.px-md-3{padding-left:1rem!important}.p-md-4{padding:1.5rem!important}.pt-md-4,.py-md-4{padding-top:1.5rem!important}.pr-md-4,.px-md-4{padding-right:1.5rem!important}.pb-md-4,.py-md-4{padding-bottom:1.5rem!important}.pl-md-4,.px-md-4{padding-left:1.5rem!important}.p-md-5{padding:3rem!important}.pt-md-5,.py-md-5{padding-top:3rem!important}.pr-md-5,.px-md-5{padding-right:3rem!important}.pb-md-5,.py-md-5{padding-bottom:3rem!important}.pl-md-5,.px-md-5{padding-left:3rem!important}.m-md-n1{margin:-.25rem!important}.mt-md-n1,.my-md-n1{margin-top:-.25rem!important}.mr-md-n1,.mx-md-n1{margin-right:-.25rem!important}.mb-md-n1,.my-md-n1{margin-bottom:-.25rem!important}.ml-md-n1,.mx-md-n1{margin-left:-.25rem!important}.m-md-n2{margin:-.5rem!important}.mt-md-n2,.my-md-n2{margin-top:-.5rem!important}.mr-md-n2,.mx-md-n2{margin-right:-.5rem!important}.mb-md-n2,.my-md-n2{margin-bottom:-.5rem!important}.ml-md-n2,.mx-md-n2{margin-left:-.5rem!important}.m-md-n3{margin:-1rem!important}.mt-md-n3,.my-md-n3{margin-top:-1rem!important}.mr-md-n3,.mx-md-n3{margin-right:-1rem!important}.mb-md-n3,.my-md-n3{margin-bottom:-1rem!important}.ml-md-n3,.mx-md-n3{margin-left:-1rem!important}.m-md-n4{margin:-1.5rem!important}.mt-md-n4,.my-md-n4{margin-top:-1.5rem!important}.mr-md-n4,.mx-md-n4{margin-right:-1.5rem!important}.mb-md-n4,.my-md-n4{margin-bottom:-1.5rem!important}.ml-md-n4,.mx-md-n4{margin-left:-1.5rem!important}.m-md-n5{margin:-3rem!important}.mt-md-n5,.my-md-n5{margin-top:-3rem!important}.mr-md-n5,.mx-md-n5{margin-right:-3rem!important}.mb-md-n5,.my-md-n5{margin-bottom:-3rem!important}.ml-md-n5,.mx-md-n5{margin-left:-3rem!important}.m-md-auto{margin:auto!important}.mt-md-auto,.my-md-auto{margin-top:auto!important}.mr-md-auto,.mx-md-auto{margin-right:auto!important}.mb-md-auto,.my-md-auto{margin-bottom:auto!important}.ml-md-auto,.mx-md-auto{margin-left:auto!important}}@media(min-width:992px){.m-lg-0{margin:0!important}.mt-lg-0,.my-lg-0{margin-top:0!important}.mr-lg-0,.mx-lg-0{margin-right:0!important}.mb-lg-0,.my-lg-0{margin-bottom:0!important}.ml-lg-0,.mx-lg-0{margin-left:0!important}.m-lg-1{margin:.25rem!important}.mt-lg-1,.my-lg-1{margin-top:.25rem!important}.mr-lg-1,.mx-lg-1{margin-right:.25rem!important}.mb-lg-1,.my-lg-1{margin-bottom:.25rem!important}.ml-lg-1,.mx-lg-1{margin-left:.25rem!important}.m-lg-2{margin:.5rem!important}.mt-lg-2,.my-lg-2{margin-top:.5rem!important}.mr-lg-2,.mx-lg-2{margin-right:.5rem!important}.mb-lg-2,.my-lg-2{margin-bottom:.5rem!important}.ml-lg-2,.mx-lg-2{margin-left:.5rem!important}.m-lg-3{margin:1rem!important}.mt-lg-3,.my-lg-3{margin-top:1rem!important}.mr-lg-3,.mx-lg-3{margin-right:1rem!important}.mb-lg-3,.my-lg-3{margin-bottom:1rem!important}.ml-lg-3,.mx-lg-3{margin-left:1rem!important}.m-lg-4{margin:1.5rem!important}.mt-lg-4,.my-lg-4{margin-top:1.5rem!important}.mr-lg-4,.mx-lg-4{margin-right:1.5rem!important}.mb-lg-4,.my-lg-4{margin-bottom:1.5rem!important}.ml-lg-4,.mx-lg-4{margin-left:1.5rem!important}.m-lg-5{margin:3rem!important}.mt-lg-5,.my-lg-5{margin-top:3rem!important}.mr-lg-5,.mx-lg-5{margin-right:3rem!important}.mb-lg-5,.my-lg-5{margin-bottom:3rem!important}.ml-lg-5,.mx-lg-5{margin-left:3rem!important}.p-lg-0{padding:0!important}.pt-lg-0,.py-lg-0{padding-top:0!important}.pr-lg-0,.px-lg-0{padding-right:0!important}.pb-lg-0,.py-lg-0{padding-bottom:0!important}.pl-lg-0,.px-lg-0{padding-left:0!important}.p-lg-1{padding:.25rem!important}.pt-lg-1,.py-lg-1{padding-top:.25rem!important}.pr-lg-1,.px-lg-1{padding-right:.25rem!important}.pb-lg-1,.py-lg-1{padding-bottom:.25rem!important}.pl-lg-1,.px-lg-1{padding-left:.25rem!important}.p-lg-2{padding:.5rem!important}.pt-lg-2,.py-lg-2{padding-top:.5rem!important}.pr-lg-2,.px-lg-2{padding-right:.5rem!important}.pb-lg-2,.py-lg-2{padding-bottom:.5rem!important}.pl-lg-2,.px-lg-2{padding-left:.5rem!important}.p-lg-3{padding:1rem!important}.pt-lg-3,.py-lg-3{padding-top:1rem!important}.pr-lg-3,.px-lg-3{padding-right:1rem!important}.pb-lg-3,.py-lg-3{padding-bottom:1rem!important}.pl-lg-3,.px-lg-3{padding-left:1rem!important}.p-lg-4{padding:1.5rem!important}.pt-lg-4,.py-lg-4{padding-top:1.5rem!important}.pr-lg-4,.px-lg-4{padding-right:1.5rem!important}.pb-lg-4,.py-lg-4{padding-bottom:1.5rem!important}.pl-lg-4,.px-lg-4{padding-left:1.5rem!important}.p-lg-5{padding:3rem!important}.pt-lg-5,.py-lg-5{padding-top:3rem!important}.pr-lg-5,.px-lg-5{padding-right:3rem!important}.pb-lg-5,.py-lg-5{padding-bottom:3rem!important}.pl-lg-5,.px-lg-5{padding-left:3rem!important}.m-lg-n1{margin:-.25rem!important}.mt-lg-n1,.my-lg-n1{margin-top:-.25rem!important}.mr-lg-n1,.mx-lg-n1{margin-right:-.25rem!important}.mb-lg-n1,.my-lg-n1{margin-bottom:-.25rem!important}.ml-lg-n1,.mx-lg-n1{margin-left:-.25rem!important}.m-lg-n2{margin:-.5rem!important}.mt-lg-n2,.my-lg-n2{margin-top:-.5rem!important}.mr-lg-n2,.mx-lg-n2{margin-right:-.5rem!important}.mb-lg-n2,.my-lg-n2{margin-bottom:-.5rem!important}.ml-lg-n2,.mx-lg-n2{margin-left:-.5rem!important}.m-lg-n3{margin:-1rem!important}.mt-lg-n3,.my-lg-n3{margin-top:-1rem!important}.mr-lg-n3,.mx-lg-n3{margin-right:-1rem!important}.mb-lg-n3,.my-lg-n3{margin-bottom:-1rem!important}.ml-lg-n3,.mx-lg-n3{margin-left:-1rem!important}.m-lg-n4{margin:-1.5rem!important}.mt-lg-n4,.my-lg-n4{margin-top:-1.5rem!important}.mr-lg-n4,.mx-lg-n4{margin-right:-1.5rem!important}.mb-lg-n4,.my-lg-n4{margin-bottom:-1.5rem!important}.ml-lg-n4,.mx-lg-n4{margin-left:-1.5rem!important}.m-lg-n5{margin:-3rem!important}.mt-lg-n5,.my-lg-n5{margin-top:-3rem!important}.mr-lg-n5,.mx-lg-n5{margin-right:-3rem!important}.mb-lg-n5,.my-lg-n5{margin-bottom:-3rem!important}.ml-lg-n5,.mx-lg-n5{margin-left:-3rem!important}.m-lg-auto{margin:auto!important}.mt-lg-auto,.my-lg-auto{margin-top:auto!important}.mr-lg-auto,.mx-lg-auto{margin-right:auto!important}.mb-lg-auto,.my-lg-auto{margin-bottom:auto!important}.ml-lg-auto,.mx-lg-auto{margin-left:auto!important}}@media(min-width:1200px){.m-xl-0{margin:0!important}.mt-xl-0,.my-xl-0{margin-top:0!important}.mr-xl-0,.mx-xl-0{margin-right:0!important}.mb-xl-0,.my-xl-0{margin-bottom:0!important}.ml-xl-0,.mx-xl-0{margin-left:0!important}.m-xl-1{margin:.25rem!important}.mt-xl-1,.my-xl-1{margin-top:.25rem!important}.mr-xl-1,.mx-xl-1{margin-right:.25rem!important}.mb-xl-1,.my-xl-1{margin-bottom:.25rem!important}.ml-xl-1,.mx-xl-1{margin-left:.25rem!important}.m-xl-2{margin:.5rem!important}.mt-xl-2,.my-xl-2{margin-top:.5rem!important}.mr-xl-2,.mx-xl-2{margin-right:.5rem!important}.mb-xl-2,.my-xl-2{margin-bottom:.5rem!important}.ml-xl-2,.mx-xl-2{margin-left:.5rem!important}.m-xl-3{margin:1rem!important}.mt-xl-3,.my-xl-3{margin-top:1rem!important}.mr-xl-3,.mx-xl-3{margin-right:1rem!important}.mb-xl-3,.my-xl-3{margin-bottom:1rem!important}.ml-xl-3,.mx-xl-3{margin-left:1rem!important}.m-xl-4{margin:1.5rem!important}.mt-xl-4,.my-xl-4{margin-top:1.5rem!important}.mr-xl-4,.mx-xl-4{margin-right:1.5rem!important}.mb-xl-4,.my-xl-4{margin-bottom:1.5rem!important}.ml-xl-4,.mx-xl-4{margin-left:1.5rem!important}.m-xl-5{margin:3rem!important}.mt-xl-5,.my-xl-5{margin-top:3rem!important}.mr-xl-5,.mx-xl-5{margin-right:3rem!important}.mb-xl-5,.my-xl-5{margin-bottom:3rem!important}.ml-xl-5,.mx-xl-5{margin-left:3rem!important}.p-xl-0{padding:0!important}.pt-xl-0,.py-xl-0{padding-top:0!important}.pr-xl-0,.px-xl-0{padding-right:0!important}.pb-xl-0,.py-xl-0{padding-bottom:0!important}.pl-xl-0,.px-xl-0{padding-left:0!important}.p-xl-1{padding:.25rem!important}.pt-xl-1,.py-xl-1{padding-top:.25rem!important}.pr-xl-1,.px-xl-1{padding-right:.25rem!important}.pb-xl-1,.py-xl-1{padding-bottom:.25rem!important}.pl-xl-1,.px-xl-1{padding-left:.25rem!important}.p-xl-2{padding:.5rem!important}.pt-xl-2,.py-xl-2{padding-top:.5rem!important}.pr-xl-2,.px-xl-2{padding-right:.5rem!important}.pb-xl-2,.py-xl-2{padding-bottom:.5rem!important}.pl-xl-2,.px-xl-2{padding-left:.5rem!important}.p-xl-3{padding:1rem!important}.pt-xl-3,.py-xl-3{padding-top:1rem!important}.pr-xl-3,.px-xl-3{padding-right:1rem!important}.pb-xl-3,.py-xl-3{padding-bottom:1rem!important}.pl-xl-3,.px-xl-3{padding-left:1rem!important}.p-xl-4{padding:1.5rem!important}.pt-xl-4,.py-xl-4{padding-top:1.5rem!important}.pr-xl-4,.px-xl-4{padding-right:1.5rem!important}.pb-xl-4,.py-xl-4{padding-bottom:1.5rem!important}.pl-xl-4,.px-xl-4{padding-left:1.5rem!important}.p-xl-5{padding:3rem!important}.pt-xl-5,.py-xl-5{padding-top:3rem!important}.pr-xl-5,.px-xl-5{padding-right:3rem!important}.pb-xl-5,.py-xl-5{padding-bottom:3rem!important}.pl-xl-5,.px-xl-5{padding-left:3rem!important}.m-xl-n1{margin:-.25rem!important}.mt-xl-n1,.my-xl-n1{margin-top:-.25rem!important}.mr-xl-n1,.mx-xl-n1{margin-right:-.25rem!important}.mb-xl-n1,.my-xl-n1{margin-bottom:-.25rem!important}.ml-xl-n1,.mx-xl-n1{margin-left:-.25rem!important}.m-xl-n2{margin:-.5rem!important}.mt-xl-n2,.my-xl-n2{margin-top:-.5rem!important}.mr-xl-n2,.mx-xl-n2{margin-right:-.5rem!important}.mb-xl-n2,.my-xl-n2{margin-bottom:-.5rem!important}.ml-xl-n2,.mx-xl-n2{margin-left:-.5rem!important}.m-xl-n3{margin:-1rem!important}.mt-xl-n3,.my-xl-n3{margin-top:-1rem!important}.mr-xl-n3,.mx-xl-n3{margin-right:-1rem!important}.mb-xl-n3,.my-xl-n3{margin-bottom:-1rem!important}.ml-xl-n3,.mx-xl-n3{margin-left:-1rem!important}.m-xl-n4{margin:-1.5rem!important}.mt-xl-n4,.my-xl-n4{margin-top:-1.5rem!important}.mr-xl-n4,.mx-xl-n4{margin-right:-1.5rem!important}.mb-xl-n4,.my-xl-n4{margin-bottom:-1.5rem!important}.ml-xl-n4,.mx-xl-n4{margin-left:-1.5rem!important}.m-xl-n5{margin:-3rem!important}.mt-xl-n5,.my-xl-n5{margin-top:-3rem!important}.mr-xl-n5,.mx-xl-n5{margin-right:-3rem!important}.mb-xl-n5,.my-xl-n5{margin-bottom:-3rem!important}.ml-xl-n5,.mx-xl-n5{margin-left:-3rem!important}.m-xl-auto{margin:auto!important}.mt-xl-auto,.my-xl-auto{margin-top:auto!important}.mr-xl-auto,.mx-xl-auto{margin-right:auto!important}.mb-xl-auto,.my-xl-auto{margin-bottom:auto!important}.ml-xl-auto,.mx-xl-auto{margin-left:auto!important}}.stretched-link::after{position:absolute;top:0;right:0;bottom:0;left:0;z-index:1;pointer-events:auto;content:"";background-color:rgba(0,0,0,0)}.text-monospace{font-family:SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace!important}.text-justify{text-align:justify!important}.text-wrap{white-space:normal!important}.text-nowrap{white-space:nowrap!important}.text-truncate{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.text-left{text-align:left!important}.text-right{text-align:right!important}.text-center{text-align:center!important}@media(min-width:576px){.text-sm-left{text-align:left!important}.text-sm-right{text-align:right!important}.text-sm-center{text-align:center!important}}@media(min-width:768px){.text-md-left{text-align:left!important}.text-md-right{text-align:right!important}.text-md-center{text-align:center!important}}@media(min-width:992px){.text-lg-left{text-align:left!important}.text-lg-right{text-align:right!important}.text-lg-center{text-align:center!important}}@media(min-width:1200px){.text-xl-left{text-align:left!important}.text-xl-right{text-align:right!important}.text-xl-center{text-align:center!important}}.text-lowercase{text-transform:lowercase!important}.text-uppercase{text-transform:uppercase!important}.text-capitalize{text-transform:capitalize!important}.font-weight-light{font-weight:300!important}.font-weight-lighter{font-weight:lighter!important}.font-weight-normal{font-weight:400!important}.font-weight-bold{font-weight:700!important}.font-weight-bolder{font-weight:bolder!important}.font-italic{font-style:italic!important}.text-white{color:#fff!important}.text-primary{color:#007bff!important}a.text-primary:focus,a.text-primary:hover{color:#0056b3!important}.text-secondary{color:#6c757d!important}a.text-secondary:focus,a.text-secondary:hover{color:#494f54!important}.text-success{color:#28a745!important}a.text-success:focus,a.text-success:hover{color:#19692c!important}.text-info{color:#17a2b8!important}a.text-info:focus,a.text-info:hover{color:#0f6674!important}.text-warning{color:#ffc107!important}a.text-warning:focus,a.text-warning:hover{color:#ba8b00!important}.text-danger{color:#dc3545!important}a.text-danger:focus,a.text-danger:hover{color:#a71d2a!important}.text-light{color:#f8f9fa!important}a.text-light:focus,a.text-light:hover{color:#cbd3da!important}.text-dark{color:#343a40!important}a.text-dark:focus,a.text-dark:hover{color:#121416!important}.text-body{color:#212529!important}.text-muted{color:#6c757d!important}.text-black-50{color:rgba(0,0,0,.5)!important}.text-white-50{color:rgba(255,255,255,.5)!important}.text-hide{font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.text-decoration-none{text-decoration:none!important}.text-break{word-wrap:break-word!important}.text-reset{color:inherit!important}.visible{visibility:visible!important}.invisible{visibility:hidden!important}@media print{*,::after,::before{text-shadow:none!important;box-shadow:none!important}a:not(.btn){text-decoration:underline}abbr[title]::after{content:" (" attr(title) ")"}pre{white-space:pre-wrap!important}blockquote,pre{border:1px solid #adb5bd;page-break-inside:avoid}thead{display:table-header-group}img,tr{page-break-inside:avoid}h2,h3,p{orphans:3;widows:3}h2,h3{page-break-after:avoid}@page{size:a3}body{min-width:992px!important}.container{min-width:992px!important}.navbar{display:none}.badge{border:1px solid #000}.table{border-collapse:collapse!important}.table td,.table th{background-color:#fff!important}.table-bordered td,.table-bordered th{border:1px solid #dee2e6!important}.table-dark{color:inherit}.table-dark tbody+tbody,.table-dark td,.table-dark th,.table-dark thead th{border-color:#dee2e6}.table .thead-dark th{color:inherit;border-color:#dee2e6}}@font-face{font-family:Poppins-Regular;src:url('/assets/fonts/avenir/AvenirNextLTPro-Regular.otf')}@font-face{font-family:Poppins-Bold;src:url('/assets/fonts/avenir/AvenirNextLTPro-BoldCn.otf')}@font-face{font-family:Poppins-Medium;src:url('/assets/fonts/avenir/AvenirNextLTPro-MediumCn.otf')}@font-face{font-family:Montserrat-Bold;src:url('/assets/fonts/montserrat/Montserrat-Bold.ttf')}*{margin:0;padding:0;box-sizing:border-box}body,html{margin:0;height:100%;font-family:Poppins-Regular,sans-serif}a{margin:0;font-family:Poppins-Regular;line-height:1.7;color:#000;margin:0;transition:all .4s;-webkit-transition:all .4s;-o-transition:all .4s;-moz-transition:all .4s}a:focus{outline:none!important}a:hover{text-decoration:none;color:#57b846}h1,h2,h3,h4,h5,h6{margin:0}h1.thick{text-align:center;font-weight:bold}p{font-family:Poppins-Regular;font-size:14px;line-height:1.7;color:#000;margin:0}ul,li{margin:0;list-style-type:none}input{outline:0;border:0}textarea{outline:0;border:0}textarea:focus,input:focus{border-color:transparent!important}input:focus::-webkit-input-placeholder{color:transparent}input:focus:-moz-placeholder{color:transparent}input:focus::-moz-placeholder{color:transparent}input:focus:-ms-input-placeholder{color:transparent}textarea:focus::-webkit-input-placeholder{color:transparent}textarea:focus:-moz-placeholder{color:transparent}textarea:focus::-moz-placeholder{color:transparent}textarea:focus:-ms-input-placeholder{color:transparent}input::-webkit-input-placeholder{color:#999}input:-moz-placeholder{color:#999}input::-moz-placeholder{color:#999}input:-ms-input-placeholder{color:#999}textarea::-webkit-input-placeholder{color:#999}textarea:-moz-placeholder{color:#999}textarea::-moz-placeholder{color:#999}textarea:-ms-input-placeholder{color:#999}button{outline:none!important;border:0}button:hover{cursor:pointer}iframe{border:none!important}.txt1{font-family:Poppins-Regular;font-size:13px;line-height:1.5;color:#999}.txt2{font-family:Poppins-Regular;font-size:13px;line-height:1.5;color:#000}.limiter{width:100%;margin:0 auto}.il-limiter{width:100%;margin:0 auto;display:inline}.container-login100{margin:0;width:100%;min-height:100vh;display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;flex-wrap:wrap;justify-content:center;align-items:center;padding:15px;background:#5653c7;background:-webkit-linear-gradient(-135deg,#3e94ec,#000080);background:-o-linear-gradient(-135deg,#3e94ec,#000080);background:-moz-linear-gradient(-135deg,#3e94ec,#000080);background:linear-gradient(-135deg,#3e94ec,#000080)}.container-outboard100{margin:0;width:100%;min-height:100vh;display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;flex-wrap:wrap;justify-content:center;align-items:center;padding:15px;background:#5653c7;background:-webkit-linear-gradient(-135deg,#3e94ec,#000080);background:-o-linear-gradient(-135deg,#3e94ec,#000080);background:-moz-linear-gradient(-135deg,#3e94ec,#000080);background:linear-gradient(-135deg,#3e94ec,#000080)}.wrap-login100{width:960px;background:#fff;border-radius:10px;overflow:hidden;display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;flex-wrap:wrap;justify-content:space-between;padding:50px 130px 33px 95px}.wrap-login200{width:1280px;background:#fff;border-radius:10px;overflow:hidden;display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;flex-wrap:wrap;justify-content:space-between;padding:25px}.wrap-login300{width:1280px;background:#fff;border-radius:10px;overflow:hidden;display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;flex-wrap:wrap;justify-content:space-between;padding:50px 130px 33px 95px}.wrap-outboard100{width:70%;background:#fff;border-radius:10px;overflow:hidden;display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;flex-wrap:wrap;justify-content:center; }.wrap-outboard200{width:90%;background:#fff;border-radius:10px;overflow:hidden;display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;flex-wrap:wrap;justify-content:center;}.wrap-outboard300{width:90%;background:#fff;border-radius:10px;overflow:hidden;display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;flex-wrap:wrap;justify-content:center}.spacer{margin-bottom:5px}.login100-pic{width:316px}.login100-pic img{max-width:100%}.login100-form{width:290px}.login100-form-title{font-family:Poppins-Bold;font-size:24px;color:#333;line-height:1.2;text-align:center;width:100%;display:block;padding-bottom:54px}.wsbbar{width:100%;overflow:auto}.adminbar{background-color:rgba(171,205,239,0.3)}.navbar-btn{padding:12px;color:white;text-decoration:none;font-size:17px;text-align:center;display:inline-block;border-radius:5px;text-shadow:0 1px 1px rgba(256,256,256,0.1);box-shadow:0 6px 20px 0 rgba(0,0,0,0.19);background-color:#494949}.approve{padding:8px;color:white;text-decoration:none;font-size:12px;width:100%;text-align:center;display:block;border-radius:5px;text-shadow:0 1px 1px rgba(256,256,256,0.1);box-shadow:0 6px 20px 0 rgba(0,0,0,0.19);background-color:#2767cb}.deny{padding:8px;color:white;text-decoration:none;font-size:12px;width:100%;text-align:center;display:block;border-radius:5px;text-shadow:0 1px 1px rgba(256,256,256,0.1);box-shadow:0 6px 20px 0 rgba(0,0,0,0.19);background-color:#c34155}.approved{padding:8px;color:white;text-decoration:none;font-size:12px;width:100%;text-align:center;display:block;border-radius:5px;text-shadow:0 1px 1px rgba(256,256,256,0.1);box-shadow:0 6px 20px 0 rgba(0,0,0,0.19);background-color:#afbdd3}.denied{padding:8px;color:white;text-decoration:none;font-size:12px;width:100%;text-align:center;display:block;border-radius:5px;text-shadow:0 1px 1px rgba(256,256,256,0.1);box-shadow:0 6px 20px 0 rgba(0,0,0,0.19);background-color:#c48992}.wrap-input100{position:relative;width:100%;z-index:1;margin-bottom:10px}.wrap-input200{position:relative;width:100%;z-index:1;margin-bottom:5px}.input100{font-family:Poppins-Medium;font-size:15px;line-height:1.5;color:#000;display:block;width:100%;background:#e6e6e6;height:50px;border-radius:25px;padding:0 30px 0 68px}.input200{font-family:Poppins-Medium;font-size:15px;line-height:1.5;color:#000;display:block;width:100%;background:#e6e6e6;height:20px;border-radius:25px;padding:0 30px 0 30px}.focus-input100{display:block;position:absolute;border-radius:25px;bottom:0;left:0;z-index:-1;width:100%;height:100%;box-shadow:0;color:rgba(87,184,70,0.8)}.input100:focus+.focus-input100{-webkit-animation:anim-shadow .5s ease-in-out forwards;animation:anim-shadow .5s ease-in-out forwards}.focus-input200{display:block;position:absolute;border-radius:25px;bottom:0;left:0;z-index:-1;width:100%;height:100%;box-shadow:0;color:rgba(87,184,70,0.8)}.input200:focus+.focus-input200{-webkit-animation:anim-shadow .5s ease-in-out forwards;animation:anim-shadow .5s ease-in-out forwards}@-webkit-keyframes anim-shadow{to{box-shadow:0 0 70px 25px;opacity:0}}@keyframes anim-shadow{to{box-shadow:0 0 70px 25px;opacity:0}}.symbol-input100{font-size:15px;display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;align-items:center;position:absolute;border-radius:25px;bottom:0;left:0;width:100%;height:100%;padding-left:35px;pointer-events:none;color:#000;-webkit-transition:all .4s;-o-transition:all .4s;-moz-transition:all .4s;transition:all .4s}.input100:focus+.focus-input100+.symbol-input100{color:#3e94ec;padding-left:28px}.symbol-input200{font-size:15px;display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;align-items:center;position:absolute;border-radius:25px;bottom:0;left:0;width:100%;height:100%;padding-left:35px;pointer-events:none;color:#666;-webkit-transition:all .4s;-o-transition:all .4s;-moz-transition:all .4s;transition:all .4s}.input200:focus+.focus-input200+.symbol-input200{color:#3e94ec;padding-left:28px}.container-login100-form-btn{width:100%;display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;flex-wrap:wrap;justify-content:center;padding-top:20px}.login100-form-btn{font-family:Montserrat-Bold;font-size:15px;line-height:1.5;color:#fff;text-transform:uppercase;width:100%;height:50px;border-radius:25px;background:#3e94ec;display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:center;align-items:center;padding:0 25px;-webkit-transition:all .4s;-o-transition:all .4s;-moz-transition:all .4s;transition:all .4s}.login100-form-btn:hover{background:#333}.login200-form-btn{font-family:Montserrat-Bold;font-size:12px;line-height:1;color:#fff;text-transform:uppercase;overflow:hidden;width:50%;height:25px;border-radius:25px;background:#3e94ec;display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:center;align-items:center;padding:0 25px;margin:10px;-webkit-transition:all .4s;-o-transition:all .4s;-moz-transition:all .4s;transition:all .4s}.login200-form-btn:hover{background:#333}.radiocontainer{height:100%;min-height:100%;margin:0 auto}.button-wrap{position:relative;text-align:center;top:50%;margin-top:-2.5em}@media(max-width:40em){.button-wrap{margin-top:-1.5em}}.button-label{display:inline-block;padding:1em 2em;margin:.5em;cursor:pointer;color:#292929;border-radius:.25em;background:#efefef;box-shadow:0 3px 10px rgba(0,0,0,0.2),inset 0 -3px 0 rgba(0,0,0,0.22);-webkit-transition:.3s;transition:.3s;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.button-label h1{font-size:1em;font-family:"Lato",sans-serif}.button-label:hover{background:#d6d6d6;color:#101010;box-shadow:0 3px 10px rgba(0,0,0,0.2),inset 0 -3px 0 rgba(0,0,0,0.32)}.button-label:active{-webkit-transform:translateY(2px);transform:translateY(2px);box-shadow:0 3px 10px rgba(0,0,0,0.2),inset 0 -1px 0 rgba(0,0,0,0.22)}@media(max-width:40em){.button-label{padding:0 1em 3px;margin:.25em}}#primary-button:checked+.button-label{background:#2ecc71;color:#efefef}#primary-button:checked+.button-label:hover{background:#29b765;color:#e2e2e2}#secondary-button:checked+.button-label{background:#d91e18;color:#efefef}#secondary-button:checked+.button-label:hover{background:#c21b15;color:#e2e2e2}#tertiary-button:checked+.button-label{background:#4183d7;color:#efefef}#tertiary-button:checked+.button-label:hover{background:#2c75d2;color:#e2e2e2}.hidden{display:none!important}@media(max-width:992px){.wrap-login100{padding:177px 90px 33px 85px}.login100-pic{width:35%}.login100-form{width:50%}}@media(max-width:768px){.wrap-login100{padding:100px 80px 33px 80px}.login100-pic{display:none}.login100-form{width:100%}}@media(max-width:576px){.wrap-login100{padding:100px 15px 33px 15px}}.validate-input{position:relative}.alert-validate::before{content:attr(data-validate);position:absolute;max-width:70%;background-color:white;border:1px solid #c80000;border-radius:13px;padding:4px 25px 4px 10px;top:50%;-webkit-transform:translateY(-50%);-moz-transform:translateY(-50%);-ms-transform:translateY(-50%);-o-transform:translateY(-50%);transform:translateY(-50%);right:8px;pointer-events:none;font-family:Poppins-Medium;color:#c80000;font-size:13px;line-height:1.4;text-align:left;visibility:hidden;opacity:0;-webkit-transition:opacity .4s;-o-transition:opacity .4s;-moz-transition:opacity .4s;transition:opacity .4s}.alert-validate::after{content:"\f06a";font-family:FontAwesome;display:block;position:absolute;color:#c80000;font-size:15px;top:50%;-webkit-transform:translateY(-50%);-moz-transform:translateY(-50%);-ms-transform:translateY(-50%);-o-transform:translateY(-50%);transform:translateY(-50%);right:13px}.alert-validate:hover:before{visibility:visible;opacity:1}@media(max-width:992px){.alert-validate::before{visibility:visible;opacity:1}}.row{display:flex;flex-wrap:wrap;box-sizing:border-box}.row>*{box-sizing:border-box}.row.gtr-uniform>*>:last-child{margin-bottom:0}.row>.imp{order:-1}.row>.col-1{width:8.3333333333%}.row>.off-1{margin-left:8.3333333333%}.row>.col-2{width:16.6666666667%}.row>.off-2{margin-left:16.6666666667%}.row>.col-3{width:25%}.row>.off-3{margin-left:25%}.row>.col-4{width:33.3333333333%}.row>.off-4{margin-left:33.3333333333%}.row>.col-5{width:41.6666666667%}.row>.off-5{margin-left:41.6666666667%}.row>.col-6{width:50%}.row>.off-6{margin-left:50%}.row>.col-7{width:58.3333333333%}.row>.off-7{margin-left:58.3333333333%}.row>.col-8{width:66.6666666667%}.row>.off-8{margin-left:66.6666666667%}.row>.col-9{width:75%}.row>.off-9{margin-left:75%}.row>.col-10{width:83.3333333333%}.row>.off-10{margin-left:83.3333333333%}.row>.col-11{width:91.6666666667%}.row>.off-11{margin-left:91.6666666667%}.row>.col-12{width:100%}.row>.off-12{margin-left:100%}.row.gtr-0{margin-top:0;margin-left:0rem}.row.gtr-0>*{padding:0 0 0 0rem}.row.gtr-0.gtr-uniform{margin-top:0rem}.row.gtr-0.gtr-uniform>*{padding-top:0rem}.row.gtr-25{margin-top:0;margin-left:-0.75rem}.row.gtr-25>*{padding:0 0 0 .75rem}.row.gtr-25.gtr-uniform{margin-top:-0.75rem}.row.gtr-25.gtr-uniform>*{padding-top:.75rem}.row.gtr-50{margin-top:0;margin-left:-1.5rem}.row.gtr-50>*{padding:0 0 0 1.5rem}.row.gtr-50.gtr-uniform{margin-top:-1.5rem}.row.gtr-50.gtr-uniform>*{padding-top:1.5rem}.row{margin-top:0;margin-left:-3rem}.row>*{padding:0 0 0 3rem}.row.gtr-uniform{margin-top:-3rem}.row.gtr-uniform>*{padding-top:3rem}.row.gtr-150{margin-top:0;margin-left:-4.5rem}.row.gtr-150>*{padding:0 0 0 4.5rem}.row.gtr-150.gtr-uniform{margin-top:-4.5rem}.row.gtr-150.gtr-uniform>*{padding-top:4.5rem}.row.gtr-200{margin-top:0;margin-left:-6rem}.row.gtr-200>*{padding:0 0 0 6rem}.row.gtr-200.gtr-uniform{margin-top:-6rem}.row.gtr-200.gtr-uniform>*{padding-top:6rem}@media screen and (max-width:1680px){.row{display:flex;flex-wrap:wrap;box-sizing:border-box}.row>*{box-sizing:border-box}.row.gtr-uniform>*>:last-child{margin-bottom:0}.row>.imp-xlarge{order:-1}.row>.col-1-xlarge{width:8.3333333333%}.row>.off-1-xlarge{margin-left:8.3333333333%}.row>.col-2-xlarge{width:16.6666666667%}.row>.off-2-xlarge{margin-left:16.6666666667%}.row>.col-3-xlarge{width:25%}.row>.off-3-xlarge{margin-left:25%}.row>.col-4-xlarge{width:33.3333333333%}.row>.off-4-xlarge{margin-left:33.3333333333%}.row>.col-5-xlarge{width:41.6666666667%}.row>.off-5-xlarge{margin-left:41.6666666667%}.row>.col-6-xlarge{width:50%}.row>.off-6-xlarge{margin-left:50%}.row>.col-7-xlarge{width:58.3333333333%}.row>.off-7-xlarge{margin-left:58.3333333333%}.row>.col-8-xlarge{width:66.6666666667%}.row>.off-8-xlarge{margin-left:66.6666666667%}.row>.col-9-xlarge{width:75%}.row>.off-9-xlarge{margin-left:75%}.row>.col-10-xlarge{width:83.3333333333%}.row>.off-10-xlarge{margin-left:83.3333333333%}.row>.col-11-xlarge{width:91.6666666667%}.row>.off-11-xlarge{margin-left:91.6666666667%}.row>.col-12-xlarge{width:100%}.row>.off-12-xlarge{margin-left:100%}.row.gtr-0{margin-top:0;margin-left:0rem}.row.gtr-0>*{padding:0 0 0 0rem}.row.gtr-0.gtr-uniform{margin-top:0rem}.row.gtr-0.gtr-uniform>*{padding-top:0rem}.row.gtr-25{margin-top:0;margin-left:-0.75rem}.row.gtr-25>*{padding:0 0 0 .75rem}.row.gtr-25.gtr-uniform{margin-top:-0.75rem}.row.gtr-25.gtr-uniform>*{padding-top:.75rem}.row.gtr-50{margin-top:0;margin-left:-1.5rem}.row.gtr-50>*{padding:0 0 0 1.5rem}.row.gtr-50.gtr-uniform{margin-top:-1.5rem}.row.gtr-50.gtr-uniform>*{padding-top:1.5rem}.row{margin-top:0;margin-left:-3rem}.row>*{padding:0 0 0 3rem}.row.gtr-uniform{margin-top:-3rem}.row.gtr-uniform>*{padding-top:3rem}.row.gtr-150{margin-top:0;margin-left:-4.5rem}.row.gtr-150>*{padding:0 0 0 4.5rem}.row.gtr-150.gtr-uniform{margin-top:-4.5rem}.row.gtr-150.gtr-uniform>*{padding-top:4.5rem}.row.gtr-200{margin-top:0;margin-left:-6rem}.row.gtr-200>*{padding:0 0 0 6rem}.row.gtr-200.gtr-uniform{margin-top:-6rem}.row.gtr-200.gtr-uniform>*{padding-top:6rem}}@media screen and (max-width:1280px){.row{display:flex;flex-wrap:wrap;box-sizing:border-box}.row>*{box-sizing:border-box}.row.gtr-uniform>*>:last-child{margin-bottom:0}.row>.imp-large{order:-1}.row>.col-1-large{width:8.3333333333%}.row>.off-1-large{margin-left:8.3333333333%}.row>.col-2-large{width:16.6666666667%}.row>.off-2-large{margin-left:16.6666666667%}.row>.col-3-large{width:25%}.row>.off-3-large{margin-left:25%}.row>.col-4-large{width:33.3333333333%}.row>.off-4-large{margin-left:33.3333333333%}.row>.col-5-large{width:41.6666666667%}.row>.off-5-large{margin-left:41.6666666667%}.row>.col-6-large{width:50%}.row>.off-6-large{margin-left:50%}.row>.col-7-large{width:58.3333333333%}.row>.off-7-large{margin-left:58.3333333333%}.row>.col-8-large{width:66.6666666667%}.row>.off-8-large{margin-left:66.6666666667%}.row>.col-9-large{width:75%}.row>.off-9-large{margin-left:75%}.row>.col-10-large{width:83.3333333333%}.row>.off-10-large{margin-left:83.3333333333%}.row>.col-11-large{width:91.6666666667%}.row>.off-11-large{margin-left:91.6666666667%}.row>.col-12-large{width:100%}.row>.off-12-large{margin-left:100%}.row.gtr-0{margin-top:0;margin-left:0rem}.row.gtr-0>*{padding:0 0 0 0rem}.row.gtr-0.gtr-uniform{margin-top:0rem}.row.gtr-0.gtr-uniform>*{padding-top:0rem}.row.gtr-25{margin-top:0;margin-left:-0.375rem}.row.gtr-25>*{padding:0 0 0 .375rem}.row.gtr-25.gtr-uniform{margin-top:-0.375rem}.row.gtr-25.gtr-uniform>*{padding-top:.375rem}.row.gtr-50{margin-top:0;margin-left:-0.75rem}.row.gtr-50>*{padding:0 0 0 .75rem}.row.gtr-50.gtr-uniform{margin-top:-0.75rem}.row.gtr-50.gtr-uniform>*{padding-top:.75rem}.row{margin-top:0;margin-left:-1.5rem}.row>*{padding:0 0 0 1.5rem}.row.gtr-uniform{margin-top:-1.5rem}.row.gtr-uniform>*{padding-top:1.5rem}.row.gtr-150{margin-top:0;margin-left:-2.25rem}.row.gtr-150>*{padding:0 0 0 2.25rem}.row.gtr-150.gtr-uniform{margin-top:-2.25rem}.row.gtr-150.gtr-uniform>*{padding-top:2.25rem}.row.gtr-200{margin-top:0;margin-left:-3rem}.row.gtr-200>*{padding:0 0 0 3rem}.row.gtr-200.gtr-uniform{margin-top:-3rem}.row.gtr-200.gtr-uniform>*{padding-top:3rem}}@media screen and (max-width:980px){.row{display:flex;flex-wrap:wrap;box-sizing:border-box}.row>*{box-sizing:border-box}.row.gtr-uniform>*>:last-child{margin-bottom:0}.row>.imp-medium{order:-1}.row>.col-1-medium{width:8.3333333333%}.row>.off-1-medium{margin-left:8.3333333333%}.row>.col-2-medium{width:16.6666666667%}.row>.off-2-medium{margin-left:16.6666666667%}.row>.col-3-medium{width:25%}.row>.off-3-medium{margin-left:25%}.row>.col-4-medium{width:33.3333333333%}.row>.off-4-medium{margin-left:33.3333333333%}.row>.col-5-medium{width:41.6666666667%}.row>.off-5-medium{margin-left:41.6666666667%}.row>.col-6-medium{width:50%}.row>.off-6-medium{margin-left:50%}.row>.col-7-medium{width:58.3333333333%}.row>.off-7-medium{margin-left:58.3333333333%}.row>.col-8-medium{width:66.6666666667%}.row>.off-8-medium{margin-left:66.6666666667%}.row>.col-9-medium{width:75%}.row>.off-9-medium{margin-left:75%}.row>.col-10-medium{width:83.3333333333%}.row>.off-10-medium{margin-left:83.3333333333%}.row>.col-11-medium{width:91.6666666667%}.row>.off-11-medium{margin-left:91.6666666667%}.row>.col-12-medium{width:50%}.row>.off-12-medium{margin-left:100%}.row.gtr-0{margin-top:0;margin-left:0rem}.row.gtr-0>*{padding:0 0 0 0rem}.row.gtr-0.gtr-uniform{margin-top:0rem}.row.gtr-0.gtr-uniform>*{padding-top:0rem}.row.gtr-25{margin-top:0;margin-left:-0.375rem}.row.gtr-25>*{padding:0 0 0 .375rem}.row.gtr-25.gtr-uniform{margin-top:-0.375rem}.row.gtr-25.gtr-uniform>*{padding-top:.375rem}.row.gtr-50{margin-top:0;margin-left:-0.75rem}.row.gtr-50>*{padding:0 0 0 .75rem}.row.gtr-50.gtr-uniform{margin-top:-0.75rem}.row.gtr-50.gtr-uniform>*{padding-top:.75rem}.row{margin-top:0;margin-left:-1.5rem}.row>*{padding:0 0 0 1.5rem}.row.gtr-uniform{margin-top:-1.5rem}.row.gtr-uniform>*{padding-top:1.5rem}.row.gtr-150{margin-top:0;margin-left:-2.25rem}.row.gtr-150>*{padding:0 0 0 2.25rem}.row.gtr-150.gtr-uniform{margin-top:-2.25rem}.row.gtr-150.gtr-uniform>*{padding-top:2.25rem}.row.gtr-200{margin-top:0;margin-left:-3rem}.row.gtr-200>*{padding:0 0 0 3rem}.row.gtr-200.gtr-uniform{margin-top:-3rem}.row.gtr-200.gtr-uniform>*{padding-top:3rem}}@media screen and (max-width:736px){.row{display:flex;flex-wrap:wrap;box-sizing:border-box}.row>*{box-sizing:border-box}.row.gtr-uniform>*>:last-child{margin-bottom:0}.row>.imp-small{order:-1}.row>.col-1-small{width:8.3333333333%}.row>.off-1-small{margin-left:8.3333333333%}.row>.col-2-small{width:16.6666666667%}.row>.off-2-small{margin-left:16.6666666667%}.row>.col-3-small{width:25%}.row>.off-3-small{margin-left:25%}.row>.col-4-small{width:33.3333333333%}.row>.off-4-small{margin-left:33.3333333333%}.row>.col-5-small{width:41.6666666667%}.row>.off-5-small{margin-left:41.6666666667%}.row>.col-6-small{width:50%}.row>.off-6-small{margin-left:50%}.row>.col-7-small{width:58.3333333333%}.row>.off-7-small{margin-left:58.3333333333%}.row>.col-8-small{width:66.6666666667%}.row>.off-8-small{margin-left:66.6666666667%}.row>.col-9-small{width:75%}.row>.off-9-small{margin-left:75%}.row>.col-10-small{width:83.3333333333%}.row>.off-10-small{margin-left:83.3333333333%}.row>.col-11-small{width:91.6666666667%}.row>.off-11-small{margin-left:91.6666666667%}.row>.col-12-small{width:100%}.row>.off-12-small{margin-left:100%}.row.gtr-0{margin-top:0;margin-left:0rem}.row.gtr-0>*{padding:0 0 0 0rem}.row.gtr-0.gtr-uniform{margin-top:0rem}.row.gtr-0.gtr-uniform>*{padding-top:0rem}.row.gtr-25{margin-top:0;margin-left:-0.3125rem}.row.gtr-25>*{padding:0 0 0 .3125rem}.row.gtr-25.gtr-uniform{margin-top:-0.3125rem}.row.gtr-25.gtr-uniform>*{padding-top:.3125rem}.row.gtr-50{margin-top:0;margin-left:-0.625rem}.row.gtr-50>*{padding:0 0 0 .625rem}.row.gtr-50.gtr-uniform{margin-top:-0.625rem}.row.gtr-50.gtr-uniform>*{padding-top:.625rem}.row{margin-top:0;margin-left:-1.25rem}.row>*{padding:0 0 0 1.25rem}.row.gtr-uniform{margin-top:-1.25rem}.row.gtr-uniform>*{padding-top:1.25rem}.row.gtr-150{margin-top:0;margin-left:-1.875rem}.row.gtr-150>*{padding:0 0 0 1.875rem}.row.gtr-150.gtr-uniform{margin-top:-1.875rem}.row.gtr-150.gtr-uniform>*{padding-top:1.875rem}.row.gtr-200{margin-top:0;margin-left:-2.5rem}.row.gtr-200>*{padding:0 0 0 2.5rem}.row.gtr-200.gtr-uniform{margin-top:-2.5rem}.row.gtr-200.gtr-uniform>*{padding-top:2.5rem}}@media screen and (max-width:480px){.row{display:flex;flex-wrap:wrap;box-sizing:border-box}.row>*{box-sizing:border-box}.row.gtr-uniform>*>:last-child{margin-bottom:0}.row>.imp-xsmall{order:-1}.row>.col-1-xsmall{width:8.3333333333%}.row>.off-1-xsmall{margin-left:8.3333333333%}.row>.col-2-xsmall{width:16.6666666667%}.row>.off-2-xsmall{margin-left:16.6666666667%}.row>.col-3-xsmall{width:25%}.row>.off-3-xsmall{margin-left:25%}.row>.col-4-xsmall{width:33.3333333333%}.row>.off-4-xsmall{margin-left:33.3333333333%}.row>.col-5-xsmall{width:41.6666666667%}.row>.off-5-xsmall{margin-left:41.6666666667%}.row>.col-6-xsmall{width:50%}.row>.off-6-xsmall{margin-left:50%}.row>.col-7-xsmall{width:58.3333333333%}.row>.off-7-xsmall{margin-left:58.3333333333%}.row>.col-8-xsmall{width:66.6666666667%}.row>.off-8-xsmall{margin-left:66.6666666667%}.row>.col-9-xsmall{width:75%}.row>.off-9-xsmall{margin-left:75%}.row>.col-10-xsmall{width:83.3333333333%}.row>.off-10-xsmall{margin-left:83.3333333333%}.row>.col-11-xsmall{width:91.6666666667%}.row>.off-11-xsmall{margin-left:91.6666666667%}.row>.col-12-xsmall{width:100%}.row>.off-12-xsmall{margin-left:100%}.row.gtr-0{margin-top:0;margin-left:0rem}.row.gtr-0>*{padding:0 0 0 0rem}.row.gtr-0.gtr-uniform{margin-top:0rem}.row.gtr-0.gtr-uniform>*{padding-top:0rem}.row.gtr-25{margin-top:0;margin-left:-0.3125rem}.row.gtr-25>*{padding:0 0 0 .3125rem}.row.gtr-25.gtr-uniform{margin-top:-0.3125rem}.row.gtr-25.gtr-uniform>*{padding-top:.3125rem}.row.gtr-50{margin-top:0;margin-left:-0.625rem}.row.gtr-50>*{padding:0 0 0 .625rem}.row.gtr-50.gtr-uniform{margin-top:-0.625rem}.row.gtr-50.gtr-uniform>*{padding-top:.625rem}.row{margin-top:0;margin-left:-1.25rem}.row>*{padding:0 0 0 1.25rem}.row.gtr-uniform{margin-top:-1.25rem}.row.gtr-uniform>*{padding-top:1.25rem}.row.gtr-150{margin-top:0;margin-left:-1.875rem}.row.gtr-150>*{padding:0 0 0 1.875rem}.row.gtr-150.gtr-uniform{margin-top:-1.875rem}.row.gtr-150.gtr-uniform>*{padding-top:1.875rem}.row.gtr-200{margin-top:0;margin-left:-2.5rem}.row.gtr-200>*{padding:0 0 0 2.5rem}.row.gtr-200.gtr-uniform{margin-top:-2.5rem}.row.gtr-200.gtr-uniform>*{padding-top:2.5rem}}.divider-vertical{margin-left:5px;margin-right:1em;width:1px;height:2.5em;border-left:1px solid hsla(200,10%,50%,100);z-index:2}@media only screen and (max-width:600px){.smol th,.smol td,.smol a,.smol p,.btn{padding-top:.3rem;padding-bottom:.3rem;font-size:.6rem!important;font-family:"Poppins-Regular"}body{font-size:.6rem!important}}@media only screen and (min-width:600px){.smol th,.smol td,.smol a,.smol p,.btn{padding-top:.1rem;padding-bottom:.1rem;font-size:.65rem!important;font-family:"Poppins-Regular"}body{font-size:.65rem!important}}@media only screen and (min-width:768px){.smol th,.smol td,.smol a,.smol p,.btn{padding-top:.2rem;padding-bottom:.2rem;font-size:.7rem!important;font-family:"Poppins-Regular"}body{font-size:.7rem!important}}@media only screen and (min-width:1440px){.smol th,.smol td,.smol a,.smol p,.btn{padding-top:.3rem;padding-bottom:.3rem;font-size:.75rem!important;font-family:"Poppins-Regular"}body{font-size:.75rem!important}}@media only screen and (min-width:1910px){.smol th,.smol td,.smol a,.smol p,.btn{padding-top:.3rem;padding-bottom:.3rem;font-size:.85rem!important;font-family:"Poppins-Regular"}body{font-size:.85rem!important}}@media only screen and (max-width:600px){.smoller th,.smoller td,.smoller a,.smoller p,.btn{padding-top:0rem;padding-bottom:0rem;font-size:.6rem!important;font-family:"Poppins-Regular"}body{font-size:.6rem!important}}@media only screen and (min-width:600px){.smoller th,.smoller td,.smoller a,.smoller p,.btn{padding-top:0rem;padding-bottom:0rem;font-size:.65rem!important;font-family:"Poppins-Regular"}body{font-size:.65rem!important}}@media only screen and (min-width:768px){.smoller th,.smoller td,.smoller a:not(.actionbtn),.smoller p,.btn{padding-top:0rem;padding-bottom:0rem;font-size:.7rem!important;font-family:"Poppins-Regular"}body{font-size:.7rem!important}}@media only screen and (min-width:1440px){.smoller th,.smoller td,.smoller a,.smoller p,.btn{padding-top:0rem;padding-bottom:0rem;font-size:.75rem!important;font-family:"Poppins-Regular"}body{font-size:.75rem!important}}@media only screen and (min-width:1910px){.smoller th,.smoller td,.smoller a,.smoller p,.btn{padding-top:0rem;padding-bottom:0rem;font-size:.85rem!important;font-family:"Poppins-Regular"}body{font-size:.85rem!important}}@media(max-width:767.98px){.offcanvas-collapse{position:fixed;top:56px;bottom:0;width:100%;padding-right:1rem;padding-left:1rem;overflow-y:auto;background-color:var(--gray-dark);transition:-webkit-transform .3s ease-in-out;transition:transform .3s ease-in-out;transition:transform .3s ease-in-out,-webkit-transform .3s ease-in-out;-webkit-transform:translateX(100%);transform:translateX(100%)}.offcanvas-collapse.open{-webkit-transform:translateX(-1rem);transform:translateX(-1rem)}}.nav-scroller{position:relative;z-index:2;height:2.75rem;overflow-y:hidden}.nav-scroller .nav{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:nowrap;flex-wrap:nowrap;padding-bottom:1rem;margin-top:-1px;overflow-x:auto;color:rgba(255,255,255,.75);text-align:center;white-space:nowrap;-webkit-overflow-scrolling:touch}.nav-underline .nav-link{padding-top:.75rem;padding-bottom:.75rem;font-size:.875rem;color:var(--secondary)}.nav-underline .nav-link:hover{color:var(--blue)}.nav-underline .active{font-weight:500;color:var(--gray-dark)}.text-white-50{color:rgba(255,255,255,.5)}.bg-purple{background-color:var(--purple)}.border-bottom{border-bottom:1px solid #e5e5e5}.box-shadow{box-shadow:0 .25rem .75rem rgba(0,0,0,.05)}.lh-100{line-height:1}.lh-125{line-height:1.25}.lh-150{line-height:1.5}.feather{width:16px;height:16px;vertical-align:text-bottom}.sidebar{position:fixed;top:0;bottom:0;left:0;z-index:100;padding:48px 0 0;box-shadow:inset -1px 0 0 rgba(0,0,0,.1)}@media(max-width:767.98px){.sidebar{top:5rem}}.sidebar-sticky{position:relative;top:0;height:calc(100vh - 48px);padding-top:.5rem;overflow-x:hidden;overflow-y:auto}.sidebar .nav-link{font-weight:500;color:#333}.sidebar .nav-link .feather{margin-right:4px;color:#727272}.sidebar .nav-link.active{color:#007bff}.sidebar .nav-link:hover .feather,.sidebar .nav-link.active .feather{color:inherit}.sidebar-heading{font-size:.75rem;text-transform:uppercase}.form-control-dark{color:#fff;background-color:rgba(255,255,255,.1);border-color:rgba(255,255,255,.1)}.form-control-dark:focus{border-color:transparent;box-shadow:0 0 0 3px rgba(255,255,255,.25)}
  .fa,.fab,.fal,.far,.fas{-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;display:inline-block;font-style:normal;font-variant:normal;text-rendering:auto;line-height:1}.fa-lg{font-size:1.33333em;line-height:.75em;vertical-align:-.0667em}.fa-xs{font-size:.75em}.fa-sm{font-size:.875em}.fa-1x{font-size:1em}.fa-2x{font-size:2em}.fa-3x{font-size:3em}.fa-4x{font-size:4em}.fa-5x{font-size:5em}.fa-6x{font-size:6em}.fa-7x{font-size:7em}.fa-8x{font-size:8em}.fa-9x{font-size:9em}.fa-10x{font-size:10em}.fa-fw{text-align:center;width:1.25em}.fa-ul{list-style-type:none;margin-left:2.5em;padding-left:0}.fa-ul>li{position:relative}.fa-li{left:-2em;position:absolute;text-align:center;width:2em;line-height:inherit}.fa-border{border:.08em solid #eee;border-radius:.1em;padding:.2em .25em .15em}.fa-pull-left{float:left}.fa-pull-right{float:right}.fa.fa-pull-left,.fab.fa-pull-left,.fal.fa-pull-left,.far.fa-pull-left,.fas.fa-pull-left{margin-right:.3em}.fa.fa-pull-right,.fab.fa-pull-right,.fal.fa-pull-right,.far.fa-pull-right,.fas.fa-pull-right{margin-left:.3em}.fa-spin{animation:fa-spin 2s infinite linear}.fa-pulse{animation:fa-spin 1s infinite steps(8)}@keyframes fa-spin{0%{transform:rotate(0deg)}to{transform:rotate(1turn)}}.fa-rotate-90{filter:"progid:DXImageTransform.Microsoft.BasicImage(rotation=1)";-ms-filter:"progid:DXImageTransform.Microsoft.BasicImage(rotation=1)";transform:rotate(90deg)}.fa-rotate-180{filter:"progid:DXImageTransform.Microsoft.BasicImage(rotation=2)";-ms-filter:"progid:DXImageTransform.Microsoft.BasicImage(rotation=2)";transform:rotate(180deg)}.fa-rotate-270{filter:"progid:DXImageTransform.Microsoft.BasicImage(rotation=3)";-ms-filter:"progid:DXImageTransform.Microsoft.BasicImage(rotation=3)";transform:rotate(270deg)}.fa-flip-horizontal{filter:"progid:DXImageTransform.Microsoft.BasicImage(rotation=0, mirror=1)"; -ms-filter:"progid:DXImageTransform.Microsoft.BasicImage(rotation=0, mirror=1)";transform:scaleX(-1)}.fa-flip-vertical{transform:scaleY(-1)}.fa-flip-both,.fa-flip-horizontal.fa-flip-vertical,.fa-flip-vertical{filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=2, mirror=1)";-ms-filter:"progid:DXImageTransform.Microsoft.BasicImage(rotation=2, mirror=1)"}.fa-flip-both,.fa-flip-horizontal.fa-flip-vertical{transform:scale(-1)}:root .fa-flip-both,:root .fa-flip-horizontal,:root .fa-flip-vertical,:root .fa-rotate-90,:root .fa-rotate-180,:root .fa-rotate-270{filter:none}.fa-stack{display:inline-block;height:2em;line-height:2em;position:relative;vertical-align:middle;width:2.5em}.fa-stack-1x,.fa-stack-2x{left:0;position:absolute;text-align:center;width:100%}.fa-stack-1x{line-height:inherit}.fa-stack-2x{font-size:2em}.fa-inverse{color:#fff}.fa-500px:before{content:"\f26e"}.fa-accessible-icon:before{content:"\f368"}.fa-accusoft:before{content:"\f369"}.fa-acquisitions-incorporated:before{content:"\f6af"}.fa-ad:before{content:"\f641"}.fa-address-book:before{content:"\f2b9"}.fa-address-card:before{content:"\f2bb"}.fa-adjust:before{content:"\f042"}.fa-adn:before{content:"\f170"}.fa-adobe:before{content:"\f778"}.fa-adversal:before{content:"\f36a"}.fa-affiliatetheme:before{content:"\f36b"}.fa-air-freshener:before{content:"\f5d0"}.fa-algolia:before{content:"\f36c"}.fa-align-center:before{content:"\f037"}.fa-align-justify:before{content:"\f039"}.fa-align-left:before{content:"\f036"}.fa-align-right:before{content:"\f038"}.fa-alipay:before{content:"\f642"}.fa-allergies:before{content:"\f461"}.fa-amazon:before{content:"\f270"}.fa-amazon-pay:before{content:"\f42c"}.fa-ambulance:before{content:"\f0f9"}.fa-american-sign-language-interpreting:before{content:"\f2a3"}.fa-amilia:before{content:"\f36d"}.fa-anchor:before{content:"\f13d"}.fa-android:before{content:"\f17b"}.fa-angellist:before{content:"\f209"}.fa-angle-double-down:before{content:"\f103"}.fa-angle-double-left:before{content:"\f100"}.fa-angle-double-right:before{content:"\f101"}.fa-angle-double-up:before{content:"\f102"}.fa-angle-down:before{content:"\f107"}.fa-angle-left:before{content:"\f104"}.fa-angle-right:before{content:"\f105"}.fa-angle-up:before{content:"\f106"}.fa-angry:before{content:"\f556"}.fa-angrycreative:before{content:"\f36e"}.fa-angular:before{content:"\f420"}.fa-ankh:before{content:"\f644"}.fa-app-store:before{content:"\f36f"}.fa-app-store-ios:before{content:"\f370"}.fa-apper:before{content:"\f371"}.fa-apple:before{content:"\f179"}.fa-apple-alt:before{content:"\f5d1"}.fa-apple-pay:before{content:"\f415"}.fa-archive:before{content:"\f187"}.fa-archway:before{content:"\f557"}.fa-arrow-alt-circle-down:before{content:"\f358"}.fa-arrow-alt-circle-left:before{content:"\f359"}.fa-arrow-alt-circle-right:before{content:"\f35a"}.fa-arrow-alt-circle-up:before{content:"\f35b"}.fa-arrow-circle-down:before{content:"\f0ab"}.fa-arrow-circle-left:before{content:"\f0a8"}.fa-arrow-circle-right:before{content:"\f0a9"}.fa-arrow-circle-up:before{content:"\f0aa"}.fa-arrow-down:before{content:"\f063"}.fa-arrow-left:before{content:"\f060"}.fa-arrow-right:before{content:"\f061"}.fa-arrow-up:before{content:"\f062"}.fa-arrows-alt:before{content:"\f0b2"}.fa-arrows-alt-h:before{content:"\f337"}.fa-arrows-alt-v:before{content:"\f338"}.fa-artstation:before{content:"\f77a"}.fa-assistive-listening-systems:before{content:"\f2a2"}.fa-asterisk:before{content:"\f069"}.fa-asymmetrik:before{content:"\f372"}.fa-at:before{content:"\f1fa"}.fa-atlas:before{content:"\f558"}.fa-atlassian:before{content:"\f77b"}.fa-atom:before{content:"\f5d2"}.fa-audible:before{content:"\f373"}.fa-audio-description:before{content:"\f29e"}.fa-autoprefixer:before{content:"\f41c"}.fa-avianex:before{content:"\f374"}.fa-aviato:before{content:"\f421"}.fa-award:before{content:"\f559"}.fa-aws:before{content:"\f375"}.fa-baby:before{content:"\f77c"}.fa-baby-carriage:before{content:"\f77d"}.fa-backspace:before{content:"\f55a"}.fa-backward:before{content:"\f04a"}.fa-bacon:before{content:"\f7e5"}.fa-balance-scale:before{content:"\f24e"}.fa-ban:before{content:"\f05e"}.fa-band-aid:before{content:"\f462"}.fa-bandcamp:before{content:"\f2d5"}.fa-barcode:before{content:"\f02a"}.fa-bars:before{content:"\f0c9"}.fa-baseball-ball:before{content:"\f433"}.fa-basketball-ball:before{content:"\f434"}.fa-bath:before{content:"\f2cd"}.fa-battery-empty:before{content:"\f244"}.fa-battery-full:before{content:"\f240"}.fa-battery-half:before{content:"\f242"}.fa-battery-quarter:before{content:"\f243"}.fa-battery-three-quarters:before{content:"\f241"}.fa-bed:before{content:"\f236"}.fa-beer:before{content:"\f0fc"}.fa-behance:before{content:"\f1b4"}.fa-behance-square:before{content:"\f1b5"}.fa-bell:before{content:"\f0f3"}.fa-bell-slash:before{content:"\f1f6"}.fa-bezier-curve:before{content:"\f55b"}.fa-bible:before{content:"\f647"}.fa-bicycle:before{content:"\f206"}.fa-bimobject:before{content:"\f378"}.fa-binoculars:before{content:"\f1e5"}.fa-biohazard:before{content:"\f780"}.fa-birthday-cake:before{content:"\f1fd"}.fa-bitbucket:before{content:"\f171"}.fa-bitcoin:before{content:"\f379"}.fa-bity:before{content:"\f37a"}.fa-black-tie:before{content:"\f27e"}.fa-blackberry:before{content:"\f37b"}.fa-blender:before{content:"\f517"}.fa-blender-phone:before{content:"\f6b6"}.fa-blind:before{content:"\f29d"}.fa-blog:before{content:"\f781"}.fa-blogger:before{content:"\f37c"}.fa-blogger-b:before{content:"\f37d"}.fa-bluetooth:before{content:"\f293"}.fa-bluetooth-b:before{content:"\f294"}.fa-bold:before{content:"\f032"}.fa-bolt:before{content:"\f0e7"}.fa-bomb:before{content:"\f1e2"}.fa-bone:before{content:"\f5d7"}.fa-bong:before{content:"\f55c"}.fa-book:before{content:"\f02d"}.fa-book-dead:before{content:"\f6b7"}.fa-book-medical:before{content:"\f7e6"}.fa-book-open:before{content:"\f518"}.fa-book-reader:before{content:"\f5da"}.fa-bookmark:before{content:"\f02e"}.fa-bowling-ball:before{content:"\f436"}.fa-box:before{content:"\f466"}.fa-box-open:before{content:"\f49e"}.fa-boxes:before{content:"\f468"}.fa-braille:before{content:"\f2a1"}.fa-brain:before{content:"\f5dc"}.fa-bread-slice:before{content:"\f7ec"}.fa-briefcase:before{content:"\f0b1"}.fa-briefcase-medical:before{content:"\f469"}.fa-broadcast-tower:before{content:"\f519"}.fa-broom:before{content:"\f51a"}.fa-brush:before{content:"\f55d"}.fa-btc:before{content:"\f15a"}.fa-bug:before{content:"\f188"}.fa-building:before{content:"\f1ad"}.fa-bullhorn:before{content:"\f0a1"}.fa-bullseye:before{content:"\f140"}.fa-burn:before{content:"\f46a"}.fa-buromobelexperte:before{content:"\f37f"}.fa-bus:before{content:"\f207"}.fa-bus-alt:before{content:"\f55e"}.fa-business-time:before{content:"\f64a"}.fa-buysellads:before{content:"\f20d"}.fa-calculator:before{content:"\f1ec"}.fa-calendar:before{content:"\f133"}.fa-calendar-alt:before{content:"\f073"}.fa-calendar-check:before{content:"\f274"}.fa-calendar-day:before{content:"\f783"}.fa-calendar-minus:before{content:"\f272"}.fa-calendar-plus:before{content:"\f271"}.fa-calendar-times:before{content:"\f273"}.fa-calendar-week:before{content:"\f784"}.fa-camera:before{content:"\f030"}.fa-camera-retro:before{content:"\f083"}.fa-campground:before{content:"\f6bb"}.fa-canadian-maple-leaf:before{content:"\f785"}.fa-candy-cane:before{content:"\f786"}.fa-cannabis:before{content:"\f55f"}.fa-capsules:before{content:"\f46b"}.fa-car:before{content:"\f1b9"}.fa-car-alt:before{content:"\f5de"}.fa-car-battery:before{content:"\f5df"}.fa-car-crash:before{content:"\f5e1"}.fa-car-side:before{content:"\f5e4"}.fa-caret-down:before{content:"\f0d7"}.fa-caret-left:before{content:"\f0d9"}.fa-caret-right:before{content:"\f0da"}.fa-caret-square-down:before{content:"\f150"}.fa-caret-square-left:before{content:"\f191"}.fa-caret-square-right:before{content:"\f152"}.fa-caret-square-up:before{content:"\f151"}.fa-caret-up:before{content:"\f0d8"}.fa-carrot:before{content:"\f787"}.fa-cart-arrow-down:before{content:"\f218"}.fa-cart-plus:before{content:"\f217"}.fa-cash-register:before{content:"\f788"}.fa-cat:before{content:"\f6be"}.fa-cc-amazon-pay:before{content:"\f42d"}.fa-cc-amex:before{content:"\f1f3"}.fa-cc-apple-pay:before{content:"\f416"}.fa-cc-diners-club:before{content:"\f24c"}.fa-cc-discover:before{content:"\f1f2"}.fa-cc-jcb:before{content:"\f24b"}.fa-cc-mastercard:before{content:"\f1f1"}.fa-cc-paypal:before{content:"\f1f4"}.fa-cc-stripe:before{content:"\f1f5"}.fa-cc-visa:before{content:"\f1f0"}.fa-centercode:before{content:"\f380"}.fa-centos:before{content:"\f789"}.fa-certificate:before{content:"\f0a3"}.fa-chair:before{content:"\f6c0"}.fa-chalkboard:before{content:"\f51b"}.fa-chalkboard-teacher:before{content:"\f51c"}.fa-charging-station:before{content:"\f5e7"}.fa-chart-area:before{content:"\f1fe"}.fa-chart-bar:before{content:"\f080"}.fa-chart-line:before{content:"\f201"}.fa-chart-pie:before{content:"\f200"}.fa-check:before{content:"\f00c"}.fa-check-circle:before{content:"\f058"}.fa-check-double:before{content:"\f560"}.fa-check-square:before{content:"\f14a"}.fa-cheese:before{content:"\f7ef"}.fa-chess:before{content:"\f439"}.fa-chess-bishop:before{content:"\f43a"}.fa-chess-board:before{content:"\f43c"}.fa-chess-king:before{content:"\f43f"}.fa-chess-knight:before{content:"\f441"}.fa-chess-pawn:before{content:"\f443"}.fa-chess-queen:before{content:"\f445"}.fa-chess-rook:before{content:"\f447"}.fa-chevron-circle-down:before{content:"\f13a"}.fa-chevron-circle-left:before{content:"\f137"}.fa-chevron-circle-right:before{content:"\f138"}.fa-chevron-circle-up:before{content:"\f139"}.fa-chevron-down:before{content:"\f078"}.fa-chevron-left:before{content:"\f053"}.fa-chevron-right:before{content:"\f054"}.fa-chevron-up:before{content:"\f077"}.fa-child:before{content:"\f1ae"}.fa-chrome:before{content:"\f268"}.fa-church:before{content:"\f51d"}.fa-circle:before{content:"\f111"}.fa-circle-notch:before{content:"\f1ce"}.fa-city:before{content:"\f64f"}.fa-clinic-medical:before{content:"\f7f2"}.fa-clipboard:before{content:"\f328"}.fa-clipboard-check:before{content:"\f46c"}.fa-clipboard-list:before{content:"\f46d"}.fa-clock:before{content:"\f017"}.fa-clone:before{content:"\f24d"}.fa-closed-captioning:before{content:"\f20a"}.fa-cloud:before{content:"\f0c2"}.fa-cloud-download-alt:before{content:"\f381"}.fa-cloud-meatball:before{content:"\f73b"}.fa-cloud-moon:before{content:"\f6c3"}.fa-cloud-moon-rain:before{content:"\f73c"}.fa-cloud-rain:before{content:"\f73d"}.fa-cloud-showers-heavy:before{content:"\f740"}.fa-cloud-sun:before{content:"\f6c4"}.fa-cloud-sun-rain:before{content:"\f743"}.fa-cloud-upload-alt:before{content:"\f382"}.fa-cloudscale:before{content:"\f383"}.fa-cloudsmith:before{content:"\f384"}.fa-cloudversify:before{content:"\f385"}.fa-cocktail:before{content:"\f561"}.fa-code:before{content:"\f121"}.fa-code-branch:before{content:"\f126"}.fa-codepen:before{content:"\f1cb"}.fa-codiepie:before{content:"\f284"}.fa-coffee:before{content:"\f0f4"}.fa-cog:before{content:"\f013"}.fa-cogs:before{content:"\f085"}.fa-coins:before{content:"\f51e"}.fa-columns:before{content:"\f0db"}.fa-comment:before{content:"\f075"}.fa-comment-alt:before{content:"\f27a"}.fa-comment-dollar:before{content:"\f651"}.fa-comment-dots:before{content:"\f4ad"}.fa-comment-medical:before{content:"\f7f5"}.fa-comment-slash:before{content:"\f4b3"}.fa-comments:before{content:"\f086"}.fa-comments-dollar:before{content:"\f653"}.fa-compact-disc:before{content:"\f51f"}.fa-compass:before{content:"\f14e"}.fa-compress:before{content:"\f066"}.fa-compress-arrows-alt:before{content:"\f78c"}.fa-concierge-bell:before{content:"\f562"}.fa-confluence:before{content:"\f78d"}.fa-connectdevelop:before{content:"\f20e"}.fa-contao:before{content:"\f26d"}.fa-cookie:before{content:"\f563"}.fa-cookie-bite:before{content:"\f564"}.fa-copy:before{content:"\f0c5"}.fa-copyright:before{content:"\f1f9"}.fa-couch:before{content:"\f4b8"}.fa-cpanel:before{content:"\f388"}.fa-creative-commons:before{content:"\f25e"}.fa-creative-commons-by:before{content:"\f4e7"}.fa-creative-commons-nc:before{content:"\f4e8"}.fa-creative-commons-nc-eu:before{content:"\f4e9"}.fa-creative-commons-nc-jp:before{content:"\f4ea"}.fa-creative-commons-nd:before{content:"\f4eb"}.fa-creative-commons-pd:before{content:"\f4ec"}.fa-creative-commons-pd-alt:before{content:"\f4ed"}.fa-creative-commons-remix:before{content:"\f4ee"}.fa-creative-commons-sa:before{content:"\f4ef"}.fa-creative-commons-sampling:before{content:"\f4f0"}.fa-creative-commons-sampling-plus:before{content:"\f4f1"}.fa-creative-commons-share:before{content:"\f4f2"}.fa-creative-commons-zero:before{content:"\f4f3"}.fa-credit-card:before{content:"\f09d"}.fa-critical-role:before{content:"\f6c9"}.fa-crop:before{content:"\f125"}.fa-crop-alt:before{content:"\f565"}.fa-cross:before{content:"\f654"}.fa-crosshairs:before{content:"\f05b"}.fa-crow:before{content:"\f520"}.fa-crown:before{content:"\f521"}.fa-crutch:before{content:"\f7f7"}.fa-css3:before{content:"\f13c"}.fa-css3-alt:before{content:"\f38b"}.fa-cube:before{content:"\f1b2"}.fa-cubes:before{content:"\f1b3"}.fa-cut:before{content:"\f0c4"}.fa-cuttlefish:before{content:"\f38c"}.fa-d-and-d:before{content:"\f38d"}.fa-d-and-d-beyond:before{content:"\f6ca"}.fa-dashcube:before{content:"\f210"}.fa-database:before{content:"\f1c0"}.fa-deaf:before{content:"\f2a4"}.fa-delicious:before{content:"\f1a5"}.fa-democrat:before{content:"\f747"}.fa-deploydog:before{content:"\f38e"}.fa-deskpro:before{content:"\f38f"}.fa-desktop:before{content:"\f108"}.fa-dev:before{content:"\f6cc"}.fa-deviantart:before{content:"\f1bd"}.fa-dharmachakra:before{content:"\f655"}.fa-dhl:before{content:"\f790"}.fa-diagnoses:before{content:"\f470"}.fa-diaspora:before{content:"\f791"}.fa-dice:before{content:"\f522"}.fa-dice-d20:before{content:"\f6cf"}.fa-dice-d6:before{content:"\f6d1"}.fa-dice-five:before{content:"\f523"}.fa-dice-four:before{content:"\f524"}.fa-dice-one:before{content:"\f525"}.fa-dice-six:before{content:"\f526"}.fa-dice-three:before{content:"\f527"}.fa-dice-two:before{content:"\f528"}.fa-digg:before{content:"\f1a6"}.fa-digital-ocean:before{content:"\f391"}.fa-digital-tachograph:before{content:"\f566"}.fa-directions:before{content:"\f5eb"}.fa-discord:before{content:"\f392"}.fa-discourse:before{content:"\f393"}.fa-divide:before{content:"\f529"}.fa-dizzy:before{content:"\f567"}.fa-dna:before{content:"\f471"}.fa-dochub:before{content:"\f394"}.fa-docker:before{content:"\f395"}.fa-dog:before{content:"\f6d3"}.fa-dollar-sign:before{content:"\f155"}.fa-dolly:before{content:"\f472"}.fa-dolly-flatbed:before{content:"\f474"}.fa-donate:before{content:"\f4b9"}.fa-door-closed:before{content:"\f52a"}.fa-door-open:before{content:"\f52b"}.fa-dot-circle:before{content:"\f192"}.fa-dove:before{content:"\f4ba"}.fa-download:before{content:"\f019"}.fa-draft2digital:before{content:"\f396"}.fa-drafting-compass:before{content:"\f568"}.fa-dragon:before{content:"\f6d5"}.fa-draw-polygon:before{content:"\f5ee"}.fa-dribbble:before{content:"\f17d"}.fa-dribbble-square:before{content:"\f397"}.fa-dropbox:before{content:"\f16b"}.fa-drum:before{content:"\f569"}.fa-drum-steelpan:before{content:"\f56a"}.fa-drumstick-bite:before{content:"\f6d7"}.fa-drupal:before{content:"\f1a9"}.fa-dumbbell:before{content:"\f44b"}.fa-dumpster:before{content:"\f793"}.fa-dumpster-fire:before{content:"\f794"}.fa-dungeon:before{content:"\f6d9"}.fa-dyalog:before{content:"\f399"}.fa-earlybirds:before{content:"\f39a"}.fa-ebay:before{content:"\f4f4"}.fa-edge:before{content:"\f282"}.fa-edit:before{content:"\f044"}.fa-egg:before{content:"\f7fb"}.fa-eject:before{content:"\f052"}.fa-elementor:before{content:"\f430"}.fa-ellipsis-h:before{content:"\f141"}.fa-ellipsis-v:before{content:"\f142"}.fa-ello:before{content:"\f5f1"}.fa-ember:before{content:"\f423"}.fa-empire:before{content:"\f1d1"}.fa-envelope:before{content:"\f0e0"}.fa-envelope-open:before{content:"\f2b6"}.fa-envelope-open-text:before{content:"\f658"}.fa-envelope-square:before{content:"\f199"}.fa-envira:before{content:"\f299"}.fa-equals:before{content:"\f52c"}.fa-eraser:before{content:"\f12d"}.fa-erlang:before{content:"\f39d"}.fa-ethereum:before{content:"\f42e"}.fa-ethernet:before{content:"\f796"}.fa-etsy:before{content:"\f2d7"}.fa-euro-sign:before{content:"\f153"}.fa-exchange-alt:before{content:"\f362"}.fa-exclamation:before{content:"\f12a"}.fa-exclamation-circle:before{content:"\f06a"}.fa-exclamation-triangle:before{content:"\f071"}.fa-expand:before{content:"\f065"}.fa-expand-arrows-alt:before{content:"\f31e"}.fa-expeditedssl:before{content:"\f23e"}.fa-external-link-alt:before{content:"\f35d"}.fa-external-link-square-alt:before{content:"\f360"}.fa-eye:before{content:"\f06e"}.fa-eye-dropper:before{content:"\f1fb"}.fa-eye-slash:before{content:"\f070"}.fa-facebook:before{content:"\f09a"}.fa-facebook-f:before{content:"\f39e"}.fa-facebook-messenger:before{content:"\f39f"}.fa-facebook-square:before{content:"\f082"}.fa-fantasy-flight-games:before{content:"\f6dc"}.fa-fast-backward:before{content:"\f049"}.fa-fast-forward:before{content:"\f050"}.fa-fax:before{content:"\f1ac"}.fa-feather:before{content:"\f52d"}.fa-feather-alt:before{content:"\f56b"}.fa-fedex:before{content:"\f797"}.fa-fedora:before{content:"\f798"}.fa-female:before{content:"\f182"}.fa-fighter-jet:before{content:"\f0fb"}.fa-figma:before{content:"\f799"}.fa-file:before{content:"\f15b"}.fa-file-alt:before{content:"\f15c"}.fa-file-archive:before{content:"\f1c6"}.fa-file-audio:before{content:"\f1c7"}.fa-file-code:before{content:"\f1c9"}.fa-file-contract:before{content:"\f56c"}.fa-file-csv:before{content:"\f6dd"}.fa-file-download:before{content:"\f56d"}.fa-file-excel:before{content:"\f1c3"}.fa-file-export:before{content:"\f56e"}.fa-file-image:before{content:"\f1c5"}.fa-file-import:before{content:"\f56f"}.fa-file-invoice:before{content:"\f570"}.fa-file-invoice-dollar:before{content:"\f571"}.fa-file-medical:before{content:"\f477"}.fa-file-medical-alt:before{content:"\f478"}.fa-file-pdf:before{content:"\f1c1"}.fa-file-powerpoint:before{content:"\f1c4"}.fa-file-prescription:before{content:"\f572"}.fa-file-signature:before{content:"\f573"}.fa-file-upload:before{content:"\f574"}.fa-file-video:before{content:"\f1c8"}.fa-file-word:before{content:"\f1c2"}.fa-fill:before{content:"\f575"}.fa-fill-drip:before{content:"\f576"}.fa-film:before{content:"\f008"}.fa-filter:before{content:"\f0b0"}.fa-fingerprint:before{content:"\f577"}.fa-fire:before{content:"\f06d"}.fa-fire-alt:before{content:"\f7e4"}.fa-fire-extinguisher:before{content:"\f134"}.fa-firefox:before{content:"\f269"}.fa-first-aid:before{content:"\f479"}.fa-first-order:before{content:"\f2b0"}.fa-first-order-alt:before{content:"\f50a"}.fa-firstdraft:before{content:"\f3a1"}.fa-fish:before{content:"\f578"}.fa-fist-raised:before{content:"\f6de"}.fa-flag:before{content:"\f024"}.fa-flag-checkered:before{content:"\f11e"}.fa-flag-usa:before{content:"\f74d"}.fa-flask:before{content:"\f0c3"}.fa-flickr:before{content:"\f16e"}.fa-flipboard:before{content:"\f44d"}.fa-flushed:before{content:"\f579"}.fa-fly:before{content:"\f417"}.fa-folder:before{content:"\f07b"}.fa-folder-minus:before{content:"\f65d"}.fa-folder-open:before{content:"\f07c"}.fa-folder-plus:before{content:"\f65e"}.fa-font:before{content:"\f031"}.fa-font-awesome:before{content:"\f2b4"}.fa-font-awesome-alt:before{content:"\f35c"}.fa-font-awesome-flag:before{content:"\f425"}.fa-font-awesome-logo-full:before{content:"\f4e6"}.fa-fonticons:before{content:"\f280"}.fa-fonticons-fi:before{content:"\f3a2"}.fa-football-ball:before{content:"\f44e"}.fa-fort-awesome:before{content:"\f286"}.fa-fort-awesome-alt:before{content:"\f3a3"}.fa-forumbee:before{content:"\f211"}.fa-forward:before{content:"\f04e"}.fa-foursquare:before{content:"\f180"}.fa-free-code-camp:before{content:"\f2c5"}.fa-freebsd:before{content:"\f3a4"}.fa-frog:before{content:"\f52e"}.fa-frown:before{content:"\f119"}.fa-frown-open:before{content:"\f57a"}.fa-fulcrum:before{content:"\f50b"}.fa-funnel-dollar:before{content:"\f662"}.fa-futbol:before{content:"\f1e3"}.fa-galactic-republic:before{content:"\f50c"}.fa-galactic-senate:before{content:"\f50d"}.fa-gamepad:before{content:"\f11b"}.fa-gas-pump:before{content:"\f52f"}.fa-gavel:before{content:"\f0e3"}.fa-gem:before{content:"\f3a5"}.fa-genderless:before{content:"\f22d"}.fa-get-pocket:before{content:"\f265"}.fa-gg:before{content:"\f260"}.fa-gg-circle:before{content:"\f261"}.fa-ghost:before{content:"\f6e2"}.fa-gift:before{content:"\f06b"}.fa-gifts:before{content:"\f79c"}.fa-git:before{content:"\f1d3"}.fa-git-square:before{content:"\f1d2"}.fa-github:before{content:"\f09b"}.fa-github-alt:before{content:"\f113"}.fa-github-square:before{content:"\f092"}.fa-gitkraken:before{content:"\f3a6"}.fa-gitlab:before{content:"\f296"}.fa-gitter:before{content:"\f426"}.fa-glass-cheers:before{content:"\f79f"}.fa-glass-martini:before{content:"\f000"}.fa-glass-martini-alt:before{content:"\f57b"}.fa-glass-whiskey:before{content:"\f7a0"}.fa-glasses:before{content:"\f530"}.fa-glide:before{content:"\f2a5"}.fa-glide-g:before{content:"\f2a6"}.fa-globe:before{content:"\f0ac"}.fa-globe-africa:before{content:"\f57c"}.fa-globe-americas:before{content:"\f57d"}.fa-globe-asia:before{content:"\f57e"}.fa-globe-europe:before{content:"\f7a2"}.fa-gofore:before{content:"\f3a7"}.fa-golf-ball:before{content:"\f450"}.fa-goodreads:before{content:"\f3a8"}.fa-goodreads-g:before{content:"\f3a9"}.fa-google:before{content:"\f1a0"}.fa-google-drive:before{content:"\f3aa"}.fa-google-play:before{content:"\f3ab"}.fa-google-plus:before{content:"\f2b3"}.fa-google-plus-g:before{content:"\f0d5"}.fa-google-plus-square:before{content:"\f0d4"}.fa-google-wallet:before{content:"\f1ee"}.fa-gopuram:before{content:"\f664"}.fa-graduation-cap:before{content:"\f19d"}.fa-gratipay:before{content:"\f184"}.fa-grav:before{content:"\f2d6"}.fa-greater-than:before{content:"\f531"}.fa-greater-than-equal:before{content:"\f532"}.fa-grimace:before{content:"\f57f"}.fa-grin:before{content:"\f580"}.fa-grin-alt:before{content:"\f581"}.fa-grin-beam:before{content:"\f582"}.fa-grin-beam-sweat:before{content:"\f583"}.fa-grin-hearts:before{content:"\f584"}.fa-grin-squint:before{content:"\f585"}.fa-grin-squint-tears:before{content:"\f586"}.fa-grin-stars:before{content:"\f587"}.fa-grin-tears:before{content:"\f588"}.fa-grin-tongue:before{content:"\f589"}.fa-grin-tongue-squint:before{content:"\f58a"}.fa-grin-tongue-wink:before{content:"\f58b"}.fa-grin-wink:before{content:"\f58c"}.fa-grip-horizontal:before{content:"\f58d"}.fa-grip-lines:before{content:"\f7a4"}.fa-grip-lines-vertical:before{content:"\f7a5"}.fa-grip-vertical:before{content:"\f58e"}.fa-gripfire:before{content:"\f3ac"}.fa-grunt:before{content:"\f3ad"}.fa-guitar:before{content:"\f7a6"}.fa-gulp:before{content:"\f3ae"}.fa-h-square:before{content:"\f0fd"}.fa-hacker-news:before{content:"\f1d4"}.fa-hacker-news-square:before{content:"\f3af"}.fa-hackerrank:before{content:"\f5f7"}.fa-hamburger:before{content:"\f805"}.fa-hammer:before{content:"\f6e3"}.fa-hamsa:before{content:"\f665"}.fa-hand-holding:before{content:"\f4bd"}.fa-hand-holding-heart:before{content:"\f4be"}.fa-hand-holding-usd:before{content:"\f4c0"}.fa-hand-lizard:before{content:"\f258"}.fa-hand-middle-finger:before{content:"\f806"}.fa-hand-paper:before{content:"\f256"}.fa-hand-peace:before{content:"\f25b"}.fa-hand-point-down:before{content:"\f0a7"}.fa-hand-point-left:before{content:"\f0a5"}.fa-hand-point-right:before{content:"\f0a4"}.fa-hand-point-up:before{content:"\f0a6"}.fa-hand-pointer:before{content:"\f25a"}.fa-hand-rock:before{content:"\f255"}.fa-hand-scissors:before{content:"\f257"}.fa-hand-spock:before{content:"\f259"}.fa-hands:before{content:"\f4c2"}.fa-hands-helping:before{content:"\f4c4"}.fa-handshake:before{content:"\f2b5"}.fa-hanukiah:before{content:"\f6e6"}.fa-hard-hat:before{content:"\f807"}.fa-hashtag:before{content:"\f292"}.fa-hat-wizard:before{content:"\f6e8"}.fa-haykal:before{content:"\f666"}.fa-hdd:before{content:"\f0a0"}.fa-heading:before{content:"\f1dc"}.fa-headphones:before{content:"\f025"}.fa-headphones-alt:before{content:"\f58f"}.fa-headset:before{content:"\f590"}.fa-heart:before{content:"\f004"}.fa-heart-broken:before{content:"\f7a9"}.fa-heartbeat:before{content:"\f21e"}.fa-helicopter:before{content:"\f533"}.fa-highlighter:before{content:"\f591"}.fa-hiking:before{content:"\f6ec"}.fa-hippo:before{content:"\f6ed"}.fa-hips:before{content:"\f452"}.fa-hire-a-helper:before{content:"\f3b0"}.fa-history:before{content:"\f1da"}.fa-hockey-puck:before{content:"\f453"}.fa-holly-berry:before{content:"\f7aa"}.fa-home:before{content:"\f015"}.fa-hooli:before{content:"\f427"}.fa-hornbill:before{content:"\f592"}.fa-horse:before{content:"\f6f0"}.fa-horse-head:before{content:"\f7ab"}.fa-hospital:before{content:"\f0f8"}.fa-hospital-alt:before{content:"\f47d"}.fa-hospital-symbol:before{content:"\f47e"}.fa-hot-tub:before{content:"\f593"}.fa-hotdog:before{content:"\f80f"}.fa-hotel:before{content:"\f594"}.fa-hotjar:before{content:"\f3b1"}.fa-hourglass:before{content:"\f254"}.fa-hourglass-end:before{content:"\f253"}.fa-hourglass-half:before{content:"\f252"}.fa-hourglass-start:before{content:"\f251"}.fa-house-damage:before{content:"\f6f1"}.fa-houzz:before{content:"\f27c"}.fa-hryvnia:before{content:"\f6f2"}.fa-html5:before{content:"\f13b"}.fa-hubspot:before{content:"\f3b2"}.fa-i-cursor:before{content:"\f246"}.fa-ice-cream:before{content:"\f810"}.fa-icicles:before{content:"\f7ad"}.fa-id-badge:before{content:"\f2c1"}.fa-id-card:before{content:"\f2c2"}.fa-id-card-alt:before{content:"\f47f"}.fa-igloo:before{content:"\f7ae"}.fa-image:before{content:"\f03e"}.fa-images:before{content:"\f302"}.fa-imdb:before{content:"\f2d8"}.fa-inbox:before{content:"\f01c"}.fa-indent:before{content:"\f03c"}.fa-industry:before{content:"\f275"}.fa-infinity:before{content:"\f534"}.fa-info:before{content:"\f129"}.fa-info-circle:before{content:"\f05a"}.fa-instagram:before{content:"\f16d"}.fa-intercom:before{content:"\f7af"}.fa-internet-explorer:before{content:"\f26b"}.fa-invision:before{content:"\f7b0"}.fa-ioxhost:before{content:"\f208"}.fa-italic:before{content:"\f033"}.fa-itunes:before{content:"\f3b4"}.fa-itunes-note:before{content:"\f3b5"}.fa-java:before{content:"\f4e4"}.fa-jedi:before{content:"\f669"}.fa-jedi-order:before{content:"\f50e"}.fa-jenkins:before{content:"\f3b6"}.fa-jira:before{content:"\f7b1"}.fa-joget:before{content:"\f3b7"}.fa-joint:before{content:"\f595"}.fa-joomla:before{content:"\f1aa"}.fa-journal-whills:before{content:"\f66a"}.fa-js:before{content:"\f3b8"}.fa-js-square:before{content:"\f3b9"}.fa-jsfiddle:before{content:"\f1cc"}.fa-kaaba:before{content:"\f66b"}.fa-kaggle:before{content:"\f5fa"}.fa-key:before{content:"\f084"}.fa-keybase:before{content:"\f4f5"}.fa-keyboard:before{content:"\f11c"}.fa-keycdn:before{content:"\f3ba"}.fa-khanda:before{content:"\f66d"}.fa-kickstarter:before{content:"\f3bb"}.fa-kickstarter-k:before{content:"\f3bc"}.fa-kiss:before{content:"\f596"}.fa-kiss-beam:before{content:"\f597"}.fa-kiss-wink-heart:before{content:"\f598"}.fa-kiwi-bird:before{content:"\f535"}.fa-korvue:before{content:"\f42f"}.fa-landmark:before{content:"\f66f"}.fa-language:before{content:"\f1ab"}.fa-laptop:before{content:"\f109"}.fa-laptop-code:before{content:"\f5fc"}.fa-laptop-medical:before{content:"\f812"}.fa-laravel:before{content:"\f3bd"}.fa-lastfm:before{content:"\f202"}.fa-lastfm-square:before{content:"\f203"}.fa-laugh:before{content:"\f599"}.fa-laugh-beam:before{content:"\f59a"}.fa-laugh-squint:before{content:"\f59b"}.fa-laugh-wink:before{content:"\f59c"}.fa-layer-group:before{content:"\f5fd"}.fa-leaf:before{content:"\f06c"}.fa-leanpub:before{content:"\f212"}.fa-lemon:before{content:"\f094"}.fa-less:before{content:"\f41d"}.fa-less-than:before{content:"\f536"}.fa-less-than-equal:before{content:"\f537"}.fa-level-down-alt:before{content:"\f3be"}.fa-level-up-alt:before{content:"\f3bf"}.fa-life-ring:before{content:"\f1cd"}.fa-lightbulb:before{content:"\f0eb"}.fa-line:before{content:"\f3c0"}.fa-link:before{content:"\f0c1"}.fa-linkedin:before{content:"\f08c"}.fa-linkedin-in:before{content:"\f0e1"}.fa-linode:before{content:"\f2b8"}.fa-linux:before{content:"\f17c"}.fa-lira-sign:before{content:"\f195"}.fa-list:before{content:"\f03a"}.fa-list-alt:before{content:"\f022"}.fa-list-ol:before{content:"\f0cb"}.fa-list-ul:before{content:"\f0ca"}.fa-location-arrow:before{content:"\f124"}.fa-lock:before{content:"\f023"}.fa-lock-open:before{content:"\f3c1"}.fa-long-arrow-alt-down:before{content:"\f309"}.fa-long-arrow-alt-left:before{content:"\f30a"}.fa-long-arrow-alt-right:before{content:"\f30b"}.fa-long-arrow-alt-up:before{content:"\f30c"}.fa-low-vision:before{content:"\f2a8"}.fa-luggage-cart:before{content:"\f59d"}.fa-lyft:before{content:"\f3c3"}.fa-magento:before{content:"\f3c4"}.fa-magic:before{content:"\f0d0"}.fa-magnet:before{content:"\f076"}.fa-mail-bulk:before{content:"\f674"}.fa-mailchimp:before{content:"\f59e"}.fa-male:before{content:"\f183"}.fa-mandalorian:before{content:"\f50f"}.fa-map:before{content:"\f279"}.fa-map-marked:before{content:"\f59f"}.fa-map-marked-alt:before{content:"\f5a0"}.fa-map-marker:before{content:"\f041"}.fa-map-marker-alt:before{content:"\f3c5"}.fa-map-pin:before{content:"\f276"}.fa-map-signs:before{content:"\f277"}.fa-markdown:before{content:"\f60f"}.fa-marker:before{content:"\f5a1"}.fa-mars:before{content:"\f222"}.fa-mars-double:before{content:"\f227"}.fa-mars-stroke:before{content:"\f229"}.fa-mars-stroke-h:before{content:"\f22b"}.fa-mars-stroke-v:before{content:"\f22a"}.fa-mask:before{content:"\f6fa"}.fa-mastodon:before{content:"\f4f6"}.fa-maxcdn:before{content:"\f136"}.fa-medal:before{content:"\f5a2"}.fa-medapps:before{content:"\f3c6"}.fa-medium:before{content:"\f23a"}.fa-medium-m:before{content:"\f3c7"}.fa-medkit:before{content:"\f0fa"}.fa-medrt:before{content:"\f3c8"}.fa-meetup:before{content:"\f2e0"}.fa-megaport:before{content:"\f5a3"}.fa-meh:before{content:"\f11a"}.fa-meh-blank:before{content:"\f5a4"}.fa-meh-rolling-eyes:before{content:"\f5a5"}.fa-memory:before{content:"\f538"}.fa-mendeley:before{content:"\f7b3"}.fa-menorah:before{content:"\f676"}.fa-mercury:before{content:"\f223"}.fa-meteor:before{content:"\f753"}.fa-microchip:before{content:"\f2db"}.fa-microphone:before{content:"\f130"}.fa-microphone-alt:before{content:"\f3c9"}.fa-microphone-alt-slash:before{content:"\f539"}.fa-microphone-slash:before{content:"\f131"}.fa-microscope:before{content:"\f610"}.fa-microsoft:before{content:"\f3ca"}.fa-minus:before{content:"\f068"}.fa-minus-circle:before{content:"\f056"}.fa-minus-square:before{content:"\f146"}.fa-mitten:before{content:"\f7b5"}.fa-mix:before{content:"\f3cb"}.fa-mixcloud:before{content:"\f289"}.fa-mizuni:before{content:"\f3cc"}.fa-mobile:before{content:"\f10b"}.fa-mobile-alt:before{content:"\f3cd"}.fa-modx:before{content:"\f285"}.fa-monero:before{content:"\f3d0"}.fa-money-bill:before{content:"\f0d6"}.fa-money-bill-alt:before{content:"\f3d1"}.fa-money-bill-wave:before{content:"\f53a"}.fa-money-bill-wave-alt:before{content:"\f53b"}.fa-money-check:before{content:"\f53c"}.fa-money-check-alt:before{content:"\f53d"}.fa-monument:before{content:"\f5a6"}.fa-moon:before{content:"\f186"}.fa-mortar-pestle:before{content:"\f5a7"}.fa-mosque:before{content:"\f678"}.fa-motorcycle:before{content:"\f21c"}.fa-mountain:before{content:"\f6fc"}.fa-mouse-pointer:before{content:"\f245"}.fa-mug-hot:before{content:"\f7b6"}.fa-music:before{content:"\f001"}.fa-napster:before{content:"\f3d2"}.fa-neos:before{content:"\f612"}.fa-network-wired:before{content:"\f6ff"}.fa-neuter:before{content:"\f22c"}.fa-newspaper:before{content:"\f1ea"}.fa-nimblr:before{content:"\f5a8"}.fa-nintendo-switch:before{content:"\f418"}.fa-node:before{content:"\f419"}.fa-node-js:before{content:"\f3d3"}.fa-not-equal:before{content:"\f53e"}.fa-notes-medical:before{content:"\f481"}.fa-npm:before{content:"\f3d4"}.fa-ns8:before{content:"\f3d5"}.fa-nutritionix:before{content:"\f3d6"}.fa-object-group:before{content:"\f247"}.fa-object-ungroup:before{content:"\f248"}.fa-odnoklassniki:before{content:"\f263"}.fa-odnoklassniki-square:before{content:"\f264"}.fa-oil-can:before{content:"\f613"}.fa-old-republic:before{content:"\f510"}.fa-om:before{content:"\f679"}.fa-opencart:before{content:"\f23d"}.fa-openid:before{content:"\f19b"}.fa-opera:before{content:"\f26a"}.fa-optin-monster:before{content:"\f23c"}.fa-osi:before{content:"\f41a"}.fa-otter:before{content:"\f700"}.fa-outdent:before{content:"\f03b"}.fa-page4:before{content:"\f3d7"}.fa-pagelines:before{content:"\f18c"}.fa-pager:before{content:"\f815"}.fa-paint-brush:before{content:"\f1fc"}.fa-paint-roller:before{content:"\f5aa"}.fa-palette:before{content:"\f53f"}.fa-palfed:before{content:"\f3d8"}.fa-pallet:before{content:"\f482"}.fa-paper-plane:before{content:"\f1d8"}.fa-paperclip:before{content:"\f0c6"}.fa-parachute-box:before{content:"\f4cd"}.fa-paragraph:before{content:"\f1dd"}.fa-parking:before{content:"\f540"}.fa-passport:before{content:"\f5ab"}.fa-pastafarianism:before{content:"\f67b"}.fa-paste:before{content:"\f0ea"}.fa-patreon:before{content:"\f3d9"}.fa-pause:before{content:"\f04c"}.fa-pause-circle:before{content:"\f28b"}.fa-paw:before{content:"\f1b0"}.fa-paypal:before{content:"\f1ed"}.fa-peace:before{content:"\f67c"}.fa-pen:before{content:"\f304"}.fa-pen-alt:before{content:"\f305"}.fa-pen-fancy:before{content:"\f5ac"}.fa-pen-nib:before{content:"\f5ad"}.fa-pen-square:before{content:"\f14b"}.fa-pencil-alt:before{content:"\f303"}.fa-pencil-ruler:before{content:"\f5ae"}.fa-penny-arcade:before{content:"\f704"}.fa-people-carry:before{content:"\f4ce"}.fa-pepper-hot:before{content:"\f816"}.fa-percent:before{content:"\f295"}.fa-percentage:before{content:"\f541"}.fa-periscope:before{content:"\f3da"}.fa-person-booth:before{content:"\f756"}.fa-phabricator:before{content:"\f3db"}.fa-phoenix-framework:before{content:"\f3dc"}.fa-phoenix-squadron:before{content:"\f511"}.fa-phone:before{content:"\f095"}.fa-phone-slash:before{content:"\f3dd"}.fa-phone-square:before{content:"\f098"}.fa-phone-volume:before{content:"\f2a0"}.fa-php:before{content:"\f457"}.fa-pied-piper:before{content:"\f2ae"}.fa-pied-piper-alt:before{content:"\f1a8"}.fa-pied-piper-hat:before{content:"\f4e5"}.fa-pied-piper-pp:before{content:"\f1a7"}.fa-piggy-bank:before{content:"\f4d3"}.fa-pills:before{content:"\f484"}.fa-pinterest:before{content:"\f0d2"}.fa-pinterest-p:before{content:"\f231"}.fa-pinterest-square:before{content:"\f0d3"}.fa-pizza-slice:before{content:"\f818"}.fa-place-of-worship:before{content:"\f67f"}.fa-plane:before{content:"\f072"}.fa-plane-arrival:before{content:"\f5af"}.fa-plane-departure:before{content:"\f5b0"}.fa-play:before{content:"\f04b"}.fa-play-circle:before{content:"\f144"}.fa-playstation:before{content:"\f3df"}.fa-plug:before{content:"\f1e6"}.fa-plus:before{content:"\f067"}.fa-plus-circle:before{content:"\f055"}.fa-plus-square:before{content:"\f0fe"}.fa-podcast:before{content:"\f2ce"}.fa-poll:before{content:"\f681"}.fa-poll-h:before{content:"\f682"}.fa-poo:before{content:"\f2fe"}.fa-poo-storm:before{content:"\f75a"}.fa-poop:before{content:"\f619"}.fa-portrait:before{content:"\f3e0"}.fa-pound-sign:before{content:"\f154"}.fa-power-off:before{content:"\f011"}.fa-pray:before{content:"\f683"}.fa-praying-hands:before{content:"\f684"}.fa-prescription:before{content:"\f5b1"}.fa-prescription-bottle:before{content:"\f485"}.fa-prescription-bottle-alt:before{content:"\f486"}.fa-print:before{content:"\f02f"}.fa-procedures:before{content:"\f487"}.fa-product-hunt:before{content:"\f288"}.fa-project-diagram:before{content:"\f542"}.fa-pushed:before{content:"\f3e1"}.fa-puzzle-piece:before{content:"\f12e"}.fa-python:before{content:"\f3e2"}.fa-qq:before{content:"\f1d6"}.fa-qrcode:before{content:"\f029"}.fa-question:before{content:"\f128"}.fa-question-circle:before{content:"\f059"}.fa-quidditch:before{content:"\f458"}.fa-quinscape:before{content:"\f459"}.fa-quora:before{content:"\f2c4"}.fa-quote-left:before{content:"\f10d"}.fa-quote-right:before{content:"\f10e"}.fa-quran:before{content:"\f687"}.fa-r-project:before{content:"\f4f7"}.fa-radiation:before{content:"\f7b9"}.fa-radiation-alt:before{content:"\f7ba"}.fa-rainbow:before{content:"\f75b"}.fa-random:before{content:"\f074"}.fa-raspberry-pi:before{content:"\f7bb"}.fa-ravelry:before{content:"\f2d9"}.fa-react:before{content:"\f41b"}.fa-reacteurope:before{content:"\f75d"}.fa-readme:before{content:"\f4d5"}.fa-rebel:before{content:"\f1d0"}.fa-receipt:before{content:"\f543"}.fa-recycle:before{content:"\f1b8"}.fa-red-river:before{content:"\f3e3"}.fa-reddit:before{content:"\f1a1"}.fa-reddit-alien:before{content:"\f281"}.fa-reddit-square:before{content:"\f1a2"}.fa-redhat:before{content:"\f7bc"}.fa-redo:before{content:"\f01e"}.fa-redo-alt:before{content:"\f2f9"}.fa-registered:before{content:"\f25d"}.fa-renren:before{content:"\f18b"}.fa-reply:before{content:"\f3e5"}.fa-reply-all:before{content:"\f122"}.fa-replyd:before{content:"\f3e6"}.fa-republican:before{content:"\f75e"}.fa-researchgate:before{content:"\f4f8"}.fa-resolving:before{content:"\f3e7"}.fa-restroom:before{content:"\f7bd"}.fa-retweet:before{content:"\f079"}.fa-rev:before{content:"\f5b2"}.fa-ribbon:before{content:"\f4d6"}.fa-ring:before{content:"\f70b"}.fa-road:before{content:"\f018"}.fa-robot:before{content:"\f544"}.fa-rocket:before{content:"\f135"}.fa-rocketchat:before{content:"\f3e8"}.fa-rockrms:before{content:"\f3e9"}.fa-route:before{content:"\f4d7"}.fa-rss:before{content:"\f09e"}.fa-rss-square:before{content:"\f143"}.fa-ruble-sign:before{content:"\f158"}.fa-ruler:before{content:"\f545"}.fa-ruler-combined:before{content:"\f546"}.fa-ruler-horizontal:before{content:"\f547"}.fa-ruler-vertical:before{content:"\f548"}.fa-running:before{content:"\f70c"}.fa-rupee-sign:before{content:"\f156"}.fa-sad-cry:before{content:"\f5b3"}.fa-sad-tear:before{content:"\f5b4"}.fa-safari:before{content:"\f267"}.fa-sass:before{content:"\f41e"}.fa-satellite:before{content:"\f7bf"}.fa-satellite-dish:before{content:"\f7c0"}.fa-save:before{content:"\f0c7"}.fa-schlix:before{content:"\f3ea"}.fa-school:before{content:"\f549"}.fa-screwdriver:before{content:"\f54a"}.fa-scribd:before{content:"\f28a"}.fa-scroll:before{content:"\f70e"}.fa-sd-card:before{content:"\f7c2"}.fa-search:before{content:"\f002"}.fa-search-dollar:before{content:"\f688"}.fa-search-location:before{content:"\f689"}.fa-search-minus:before{content:"\f010"}.fa-search-plus:before{content:"\f00e"}.fa-searchengin:before{content:"\f3eb"}.fa-seedling:before{content:"\f4d8"}.fa-sellcast:before{content:"\f2da"}.fa-sellsy:before{content:"\f213"}.fa-server:before{content:"\f233"}.fa-servicestack:before{content:"\f3ec"}.fa-shapes:before{content:"\f61f"}.fa-share:before{content:"\f064"}.fa-share-alt:before{content:"\f1e0"}.fa-share-alt-square:before{content:"\f1e1"}.fa-share-square:before{content:"\f14d"}.fa-shekel-sign:before{content:"\f20b"}.fa-shield-alt:before{content:"\f3ed"}.fa-ship:before{content:"\f21a"}.fa-shipping-fast:before{content:"\f48b"}.fa-shirtsinbulk:before{content:"\f214"}.fa-shoe-prints:before{content:"\f54b"}.fa-shopping-bag:before{content:"\f290"}.fa-shopping-basket:before{content:"\f291"}.fa-shopping-cart:before{content:"\f07a"}.fa-shopware:before{content:"\f5b5"}.fa-shower:before{content:"\f2cc"}.fa-shuttle-van:before{content:"\f5b6"}.fa-sign:before{content:"\f4d9"}.fa-sign-in-alt:before{content:"\f2f6"}.fa-sign-language:before{content:"\f2a7"}.fa-sign-out-alt:before{content:"\f2f5"}.fa-signal:before{content:"\f012"}.fa-signature:before{content:"\f5b7"}.fa-sim-card:before{content:"\f7c4"}.fa-simplybuilt:before{content:"\f215"}.fa-sistrix:before{content:"\f3ee"}.fa-sitemap:before{content:"\f0e8"}.fa-sith:before{content:"\f512"}.fa-skating:before{content:"\f7c5"}.fa-sketch:before{content:"\f7c6"}.fa-skiing:before{content:"\f7c9"}.fa-skiing-nordic:before{content:"\f7ca"}.fa-skull:before{content:"\f54c"}.fa-skull-crossbones:before{content:"\f714"}.fa-skyatlas:before{content:"\f216"}.fa-skype:before{content:"\f17e"}.fa-slack:before{content:"\f198"}.fa-slack-hash:before{content:"\f3ef"}.fa-slash:before{content:"\f715"}.fa-sleigh:before{content:"\f7cc"}.fa-sliders-h:before{content:"\f1de"}.fa-slideshare:before{content:"\f1e7"}.fa-smile:before{content:"\f118"}.fa-smile-beam:before{content:"\f5b8"}.fa-smile-wink:before{content:"\f4da"}.fa-smog:before{content:"\f75f"}.fa-smoking:before{content:"\f48d"}.fa-smoking-ban:before{content:"\f54d"}.fa-sms:before{content:"\f7cd"}.fa-snapchat:before{content:"\f2ab"}.fa-snapchat-ghost:before{content:"\f2ac"}.fa-snapchat-square:before{content:"\f2ad"}.fa-snowboarding:before{content:"\f7ce"}.fa-snowflake:before{content:"\f2dc"}.fa-snowman:before{content:"\f7d0"}.fa-snowplow:before{content:"\f7d2"}.fa-socks:before{content:"\f696"}.fa-solar-panel:before{content:"\f5ba"}.fa-sort:before{content:"\f0dc"}.fa-sort-alpha-down:before{content:"\f15d"}.fa-sort-alpha-up:before{content:"\f15e"}.fa-sort-amount-down:before{content:"\f160"}.fa-sort-amount-up:before{content:"\f161"}.fa-sort-down:before{content:"\f0dd"}.fa-sort-numeric-down:before{content:"\f162"}.fa-sort-numeric-up:before{content:"\f163"}.fa-sort-up:before{content:"\f0de"}.fa-soundcloud:before{content:"\f1be"}.fa-sourcetree:before{content:"\f7d3"}.fa-spa:before{content:"\f5bb"}.fa-space-shuttle:before{content:"\f197"}.fa-speakap:before{content:"\f3f3"}.fa-spider:before{content:"\f717"}.fa-spinner:before{content:"\f110"}.fa-splotch:before{content:"\f5bc"}.fa-spotify:before{content:"\f1bc"}.fa-spray-can:before{content:"\f5bd"}.fa-square:before{content:"\f0c8"}.fa-square-full:before{content:"\f45c"}.fa-square-root-alt:before{content:"\f698"}.fa-squarespace:before{content:"\f5be"}.fa-stack-exchange:before{content:"\f18d"}.fa-stack-overflow:before{content:"\f16c"}.fa-stamp:before{content:"\f5bf"}.fa-star:before{content:"\f005"}.fa-star-and-crescent:before{content:"\f699"}.fa-star-half:before{content:"\f089"}.fa-star-half-alt:before{content:"\f5c0"}.fa-star-of-david:before{content:"\f69a"}.fa-star-of-life:before{content:"\f621"}.fa-staylinked:before{content:"\f3f5"}.fa-steam:before{content:"\f1b6"}.fa-steam-square:before{content:"\f1b7"}.fa-steam-symbol:before{content:"\f3f6"}.fa-step-backward:before{content:"\f048"}.fa-step-forward:before{content:"\f051"}.fa-stethoscope:before{content:"\f0f1"}.fa-sticker-mule:before{content:"\f3f7"}.fa-sticky-note:before{content:"\f249"}.fa-stop:before{content:"\f04d"}.fa-stop-circle:before{content:"\f28d"}.fa-stopwatch:before{content:"\f2f2"}.fa-store:before{content:"\f54e"}.fa-store-alt:before{content:"\f54f"}.fa-strava:before{content:"\f428"}.fa-stream:before{content:"\f550"}.fa-street-view:before{content:"\f21d"}.fa-strikethrough:before{content:"\f0cc"}.fa-stripe:before{content:"\f429"}.fa-stripe-s:before{content:"\f42a"}.fa-stroopwafel:before{content:"\f551"}.fa-studiovinari:before{content:"\f3f8"}.fa-stumbleupon:before{content:"\f1a4"}.fa-stumbleupon-circle:before{content:"\f1a3"}.fa-subscript:before{content:"\f12c"}.fa-subway:before{content:"\f239"}.fa-suitcase:before{content:"\f0f2"}.fa-suitcase-rolling:before{content:"\f5c1"}.fa-sun:before{content:"\f185"}.fa-superpowers:before{content:"\f2dd"}.fa-superscript:before{content:"\f12b"}.fa-supple:before{content:"\f3f9"}.fa-surprise:before{content:"\f5c2"}.fa-suse:before{content:"\f7d6"}.fa-swatchbook:before{content:"\f5c3"}.fa-swimmer:before{content:"\f5c4"}.fa-swimming-pool:before{content:"\f5c5"}.fa-synagogue:before{content:"\f69b"}.fa-sync:before{content:"\f021"}.fa-sync-alt:before{content:"\f2f1"}.fa-syringe:before{content:"\f48e"}.fa-table:before{content:"\f0ce"}.fa-table-tennis:before{content:"\f45d"}.fa-tablet:before{content:"\f10a"}.fa-tablet-alt:before{content:"\f3fa"}.fa-tablets:before{content:"\f490"}.fa-tachometer-alt:before{content:"\f3fd"}.fa-tag:before{content:"\f02b"}.fa-tags:before{content:"\f02c"}.fa-tape:before{content:"\f4db"}.fa-tasks:before{content:"\f0ae"}.fa-taxi:before{content:"\f1ba"}.fa-teamspeak:before{content:"\f4f9"}.fa-teeth:before{content:"\f62e"}.fa-teeth-open:before{content:"\f62f"}.fa-telegram:before{content:"\f2c6"}.fa-telegram-plane:before{content:"\f3fe"}.fa-temperature-high:before{content:"\f769"}.fa-temperature-low:before{content:"\f76b"}.fa-tencent-weibo:before{content:"\f1d5"}.fa-tenge:before{content:"\f7d7"}.fa-terminal:before{content:"\f120"}.fa-text-height:before{content:"\f034"}.fa-text-width:before{content:"\f035"}.fa-th:before{content:"\f00a"}.fa-th-large:before{content:"\f009"}.fa-th-list:before{content:"\f00b"}.fa-the-red-yeti:before{content:"\f69d"}.fa-theater-masks:before{content:"\f630"}.fa-themeco:before{content:"\f5c6"}.fa-themeisle:before{content:"\f2b2"}.fa-thermometer:before{content:"\f491"}.fa-thermometer-empty:before{content:"\f2cb"}.fa-thermometer-full:before{content:"\f2c7"}.fa-thermometer-half:before{content:"\f2c9"}.fa-thermometer-quarter:before{content:"\f2ca"}.fa-thermometer-three-quarters:before{content:"\f2c8"}.fa-think-peaks:before{content:"\f731"}.fa-thumbs-down:before{content:"\f165"}.fa-thumbs-up:before{content:"\f164"}.fa-thumbtack:before{content:"\f08d"}.fa-ticket-alt:before{content:"\f3ff"}.fa-times:before{content:"\f00d"}.fa-times-circle:before{content:"\f057"}.fa-tint:before{content:"\f043"}.fa-tint-slash:before{content:"\f5c7"}.fa-tired:before{content:"\f5c8"}.fa-toggle-off:before{content:"\f204"}.fa-toggle-on:before{content:"\f205"}.fa-toilet:before{content:"\f7d8"}.fa-toilet-paper:before{content:"\f71e"}.fa-toolbox:before{content:"\f552"}.fa-tools:before{content:"\f7d9"}.fa-tooth:before{content:"\f5c9"}.fa-torah:before{content:"\f6a0"}.fa-torii-gate:before{content:"\f6a1"}.fa-tractor:before{content:"\f722"}.fa-trade-federation:before{content:"\f513"}.fa-trademark:before{content:"\f25c"}.fa-traffic-light:before{content:"\f637"}.fa-train:before{content:"\f238"}.fa-tram:before{content:"\f7da"}.fa-transgender:before{content:"\f224"}.fa-transgender-alt:before{content:"\f225"}.fa-trash:before{content:"\f1f8"}.fa-trash-alt:before{content:"\f2ed"}.fa-trash-restore:before{content:"\f829"}.fa-trash-restore-alt:before{content:"\f82a"}.fa-tree:before{content:"\f1bb"}.fa-trello:before{content:"\f181"}.fa-tripadvisor:before{content:"\f262"}.fa-trophy:before{content:"\f091"}.fa-truck:before{content:"\f0d1"}.fa-truck-loading:before{content:"\f4de"}.fa-truck-monster:before{content:"\f63b"}.fa-truck-moving:before{content:"\f4df"}.fa-truck-pickup:before{content:"\f63c"}.fa-tshirt:before{content:"\f553"}.fa-tty:before{content:"\f1e4"}.fa-tumblr:before{content:"\f173"}.fa-tumblr-square:before{content:"\f174"}.fa-tv:before{content:"\f26c"}.fa-twitch:before{content:"\f1e8"}.fa-twitter:before{content:"\f099"}.fa-twitter-square:before{content:"\f081"}.fa-typo3:before{content:"\f42b"}.fa-uber:before{content:"\f402"}.fa-ubuntu:before{content:"\f7df"}.fa-uikit:before{content:"\f403"}.fa-umbrella:before{content:"\f0e9"}.fa-umbrella-beach:before{content:"\f5ca"}.fa-underline:before{content:"\f0cd"}.fa-undo:before{content:"\f0e2"}.fa-undo-alt:before{content:"\f2ea"}.fa-uniregistry:before{content:"\f404"}.fa-universal-access:before{content:"\f29a"}.fa-university:before{content:"\f19c"}.fa-unlink:before{content:"\f127"}.fa-unlock:before{content:"\f09c"}.fa-unlock-alt:before{content:"\f13e"}.fa-untappd:before{content:"\f405"}.fa-upload:before{content:"\f093"}.fa-ups:before{content:"\f7e0"}.fa-usb:before{content:"\f287"}.fa-user:before{content:"\f007"}.fa-user-alt:before{content:"\f406"}.fa-user-alt-slash:before{content:"\f4fa"}.fa-user-astronaut:before{content:"\f4fb"}.fa-user-check:before{content:"\f4fc"}.fa-user-circle:before{content:"\f2bd"}.fa-user-clock:before{content:"\f4fd"}.fa-user-cog:before{content:"\f4fe"}.fa-user-edit:before{content:"\f4ff"}.fa-user-friends:before{content:"\f500"}.fa-user-graduate:before{content:"\f501"}.fa-user-injured:before{content:"\f728"}.fa-user-lock:before{content:"\f502"}.fa-user-md:before{content:"\f0f0"}.fa-user-minus:before{content:"\f503"}.fa-user-ninja:before{content:"\f504"}.fa-user-nurse:before{content:"\f82f"}.fa-user-plus:before{content:"\f234"}.fa-user-secret:before{content:"\f21b"}.fa-user-shield:before{content:"\f505"}.fa-user-slash:before{content:"\f506"}.fa-user-tag:before{content:"\f507"}.fa-user-tie:before{content:"\f508"}.fa-user-times:before{content:"\f235"}.fa-users:before{content:"\f0c0"}.fa-users-cog:before{content:"\f509"}.fa-usps:before{content:"\f7e1"}.fa-ussunnah:before{content:"\f407"}.fa-utensil-spoon:before{content:"\f2e5"}.fa-utensils:before{content:"\f2e7"}.fa-vaadin:before{content:"\f408"}.fa-vector-square:before{content:"\f5cb"}.fa-venus:before{content:"\f221"}.fa-venus-double:before{content:"\f226"}.fa-venus-mars:before{content:"\f228"}.fa-viacoin:before{content:"\f237"}.fa-viadeo:before{content:"\f2a9"}.fa-viadeo-square:before{content:"\f2aa"}.fa-vial:before{content:"\f492"}.fa-vials:before{content:"\f493"}.fa-viber:before{content:"\f409"}.fa-video:before{content:"\f03d"}.fa-video-slash:before{content:"\f4e2"}.fa-vihara:before{content:"\f6a7"}.fa-vimeo:before{content:"\f40a"}.fa-vimeo-square:before{content:"\f194"}.fa-vimeo-v:before{content:"\f27d"}.fa-vine:before{content:"\f1ca"}.fa-vk:before{content:"\f189"}.fa-vnv:before{content:"\f40b"}.fa-volleyball-ball:before{content:"\f45f"}.fa-volume-down:before{content:"\f027"}.fa-volume-mute:before{content:"\f6a9"}.fa-volume-off:before{content:"\f026"}.fa-volume-up:before{content:"\f028"}.fa-vote-yea:before{content:"\f772"}.fa-vr-cardboard:before{content:"\f729"}.fa-vuejs:before{content:"\f41f"}.fa-walking:before{content:"\f554"}.fa-wallet:before{content:"\f555"}.fa-warehouse:before{content:"\f494"}.fa-water:before{content:"\f773"}.fa-weebly:before{content:"\f5cc"}.fa-weibo:before{content:"\f18a"}.fa-weight:before{content:"\f496"}.fa-weight-hanging:before{content:"\f5cd"}.fa-weixin:before{content:"\f1d7"}.fa-whatsapp:before{content:"\f232"}.fa-whatsapp-square:before{content:"\f40c"}.fa-wheelchair:before{content:"\f193"}.fa-whmcs:before{content:"\f40d"}.fa-wifi:before{content:"\f1eb"}.fa-wikipedia-w:before{content:"\f266"}.fa-wind:before{content:"\f72e"}.fa-window-close:before{content:"\f410"}.fa-window-maximize:before{content:"\f2d0"}.fa-window-minimize:before{content:"\f2d1"}.fa-window-restore:before{content:"\f2d2"}.fa-windows:before{content:"\f17a"}.fa-wine-bottle:before{content:"\f72f"}.fa-wine-glass:before{content:"\f4e3"}.fa-wine-glass-alt:before{content:"\f5ce"}.fa-wix:before{content:"\f5cf"}.fa-wizards-of-the-coast:before{content:"\f730"}.fa-wolf-pack-battalion:before{content:"\f514"}.fa-won-sign:before{content:"\f159"}.fa-wordpress:before{content:"\f19a"}.fa-wordpress-simple:before{content:"\f411"}.fa-wpbeginner:before{content:"\f297"}.fa-wpexplorer:before{content:"\f2de"}.fa-wpforms:before{content:"\f298"}.fa-wpressr:before{content:"\f3e4"}.fa-wrench:before{content:"\f0ad"}.fa-x-ray:before{content:"\f497"}.fa-xbox:before{content:"\f412"}.fa-xing:before{content:"\f168"}.fa-xing-square:before{content:"\f169"}.fa-y-combinator:before{content:"\f23b"}.fa-yahoo:before{content:"\f19e"}.fa-yandex:before{content:"\f413"}.fa-yandex-international:before{content:"\f414"}.fa-yarn:before{content:"\f7e3"}.fa-yelp:before{content:"\f1e9"}.fa-yen-sign:before{content:"\f157"}.fa-yin-yang:before{content:"\f6ad"}.fa-yoast:before{content:"\f2b1"}.fa-youtube:before{content:"\f167"}.fa-youtube-square:before{content:"\f431"}.fa-zhihu:before{content:"\f63f"}.sr-only{border:0;clip:rect(0,0,0,0);height:1px;margin:-1px;overflow:hidden;padding:0;position:absolute;width:1px}.sr-only-focusable:active,.sr-only-focusable:focus{clip:auto;height:auto;margin:0;overflow:visible;position:static;width:auto}@font-face{font-family:"Font Awesome 5 Brands";font-style:normal;font-weight:normal;font-display:auto;src:url(/assets/webfonts/fa-brands-400.eot);src:url(/assets/webfonts/fa-brands-400.eot?#iefix) format("embedded-opentype"),url(/assets/webfonts/fa-brands-400.woff2) format("woff2"),url(/assets/webfonts/fa-brands-400.woff) format("woff"),url(/assets/webfonts/fa-brands-400.ttf) format("truetype"),url(/assets/webfonts/fa-brands-400.svg#fontawesome) format("svg")}.fab{font-family:"Font Awesome 5 Brands"}@font-face{font-family:"Font Awesome 5 Free";font-style:normal;font-weight:400;font-display:auto;src:url(/assets/webfonts/fa-regular-400.eot);src:url(/assets/webfonts/fa-regular-400.eot?#iefix) format("embedded-opentype"),url(/assets/webfonts/fa-regular-400.woff2) format("woff2"),url(/assets/webfonts/fa-regular-400.woff) format("woff"),url(/assets/webfonts/fa-regular-400.ttf) format("truetype"),url(/assets/webfonts/fa-regular-400.svg#fontawesome) format("svg")}.far{font-weight:400}@font-face{font-family:"Font Awesome 5 Free";font-style:normal;font-weight:900;font-display:auto;src:url(/assets/webfonts/fa-solid-900.eot);src:url(/assets/webfonts/fa-solid-900.eot?#iefix) format("embedded-opentype"),url(/assets/webfonts/fa-solid-900.woff2) format("woff2"),url(/assets/webfonts/fa-solid-900.woff) format("woff"),url(/assets/webfonts/fa-solid-900.ttf) format("truetype"),url(/assets/webfonts/fa-solid-900.svg#fontawesome) format("svg")}.fa,.far,.fas{font-family:"Font Awesome 5 Free"}.fa,.fas{font-weight:900}@font-face{font-family:'Glyphicons Halflings';src:url(https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/fonts/glyphicons-halflings-regular.eot);src:url(https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/fonts/glyphicons-halflings-regular.eot?#iefix) format('embedded-opentype'),url(https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/fonts/glyphicons-halflings-regular.woff) format('woff'),url(https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/fonts/glyphicons-halflings-regular.ttf) format('truetype'),url(https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/fonts/glyphicons-halflings-regular.svg#glyphicons_halflingsregular) format('svg')}.glyphicon{position:relative;top:1px;display:inline-block;font-family:'Glyphicons Halflings';font-style:normal;font-weight:400;line-height:1;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.glyphicon-asterisk:before{content:"\2a"}.glyphicon-plus:before{content:"\2b"}.glyphicon-euro:before{content:"\20ac"}.glyphicon-minus:before{content:"\2212"}.glyphicon-cloud:before{content:"\2601"}.glyphicon-envelope:before{content:"\2709"}.glyphicon-pencil:before{content:"\270f"}.glyphicon-glass:before{content:"\e001"}.glyphicon-music:before{content:"\e002"}.glyphicon-search:before{content:"\e003"}.glyphicon-heart:before{content:"\e005"}.glyphicon-star:before{content:"\e006"}.glyphicon-star-empty:before{content:"\e007"}.glyphicon-user:before{content:"\e008"}.glyphicon-film:before{content:"\e009"}.glyphicon-th-large:before{content:"\e010"}.glyphicon-th:before{content:"\e011"}.glyphicon-th-list:before{content:"\e012"}.glyphicon-ok:before{content:"\e013"}.glyphicon-remove:before{content:"\e014"}.glyphicon-zoom-in:before{content:"\e015"}.glyphicon-zoom-out:before{content:"\e016"}.glyphicon-off:before{content:"\e017"}.glyphicon-signal:before{content:"\e018"}.glyphicon-cog:before{content:"\e019"}.glyphicon-trash:before{content:"\e020"}.glyphicon-home:before{content:"\e021"}.glyphicon-file:before{content:"\e022"}.glyphicon-time:before{content:"\e023"}.glyphicon-road:before{content:"\e024"}.glyphicon-download-alt:before{content:"\e025"}.glyphicon-download:before{content:"\e026"}.glyphicon-upload:before{content:"\e027"}.glyphicon-inbox:before{content:"\e028"}.glyphicon-play-circle:before{content:"\e029"}.glyphicon-repeat:before{content:"\e030"}.glyphicon-refresh:before{content:"\e031"}.glyphicon-list-alt:before{content:"\e032"}.glyphicon-lock:before{content:"\e033"}.glyphicon-flag:before{content:"\e034"}.glyphicon-headphones:before{content:"\e035"}.glyphicon-volume-off:before{content:"\e036"}.glyphicon-volume-down:before{content:"\e037"}.glyphicon-volume-up:before{content:"\e038"}.glyphicon-qrcode:before{content:"\e039"}.glyphicon-barcode:before{content:"\e040"}.glyphicon-tag:before{content:"\e041"}.glyphicon-tags:before{content:"\e042"}.glyphicon-book:before{content:"\e043"}.glyphicon-bookmark:before{content:"\e044"}.glyphicon-print:before{content:"\e045"}.glyphicon-camera:before{content:"\e046"}.glyphicon-font:before{content:"\e047"}.glyphicon-bold:before{content:"\e048"}.glyphicon-italic:before{content:"\e049"}.glyphicon-text-height:before{content:"\e050"}.glyphicon-text-width:before{content:"\e051"}.glyphicon-align-left:before{content:"\e052"}.glyphicon-align-center:before{content:"\e053"}.glyphicon-align-right:before{content:"\e054"}.glyphicon-align-justify:before{content:"\e055"}.glyphicon-list:before{content:"\e056"}.glyphicon-indent-left:before{content:"\e057"}.glyphicon-indent-right:before{content:"\e058"}.glyphicon-facetime-video:before{content:"\e059"}.glyphicon-picture:before{content:"\e060"}.glyphicon-map-marker:before{content:"\e062"}.glyphicon-adjust:before{content:"\e063"}.glyphicon-tint:before{content:"\e064"}.glyphicon-edit:before{content:"\e065"}.glyphicon-share:before{content:"\e066"}.glyphicon-check:before{content:"\e067"}.glyphicon-move:before{content:"\e068"}.glyphicon-step-backward:before{content:"\e069"}.glyphicon-fast-backward:before{content:"\e070"}.glyphicon-backward:before{content:"\e071"}.glyphicon-play:before{content:"\e072"}.glyphicon-pause:before{content:"\e073"}.glyphicon-stop:before{content:"\e074"}.glyphicon-forward:before{content:"\e075"}.glyphicon-fast-forward:before{content:"\e076"}.glyphicon-step-forward:before{content:"\e077"}.glyphicon-eject:before{content:"\e078"}.glyphicon-chevron-left:before{content:"\e079"}.glyphicon-chevron-right:before{content:"\e080"}.glyphicon-plus-sign:before{content:"\e081"}.glyphicon-minus-sign:before{content:"\e082"}.glyphicon-remove-sign:before{content:"\e083"}.glyphicon-ok-sign:before{content:"\e084"}.glyphicon-question-sign:before{content:"\e085"}.glyphicon-info-sign:before{content:"\e086"}.glyphicon-screenshot:before{content:"\e087"}.glyphicon-remove-circle:before{content:"\e088"}.glyphicon-ok-circle:before{content:"\e089"}.glyphicon-ban-circle:before{content:"\e090"}.glyphicon-arrow-left:before{content:"\e091"}.glyphicon-arrow-right:before{content:"\e092"}.glyphicon-arrow-up:before{content:"\e093"}.glyphicon-arrow-down:before{content:"\e094"}.glyphicon-share-alt:before{content:"\e095"}.glyphicon-resize-full:before{content:"\e096"}.glyphicon-resize-small:before{content:"\e097"}.glyphicon-exclamation-sign:before{content:"\e101"}.glyphicon-gift:before{content:"\e102"}.glyphicon-leaf:before{content:"\e103"}.glyphicon-fire:before{content:"\e104"}.glyphicon-eye-open:before{content:"\e105"}.glyphicon-eye-close:before{content:"\e106"}.glyphicon-warning-sign:before{content:"\e107"}.glyphicon-plane:before{content:"\e108"}.glyphicon-calendar:before{content:"\e109"}.glyphicon-random:before{content:"\e110"}.glyphicon-comment:before{content:"\e111"}.glyphicon-magnet:before{content:"\e112"}.glyphicon-chevron-up:before{content:"\e113"}.glyphicon-chevron-down:before{content:"\e114"}.glyphicon-retweet:before{content:"\e115"}.glyphicon-shopping-cart:before{content:"\e116"}.glyphicon-folder-close:before{content:"\e117"}.glyphicon-folder-open:before{content:"\e118"}.glyphicon-resize-vertical:before{content:"\e119"}.glyphicon-resize-horizontal:before{content:"\e120"}.glyphicon-hdd:before{content:"\e121"}.glyphicon-bullhorn:before{content:"\e122"}.glyphicon-bell:before{content:"\e123"}.glyphicon-certificate:before{content:"\e124"}.glyphicon-thumbs-up:before{content:"\e125"}.glyphicon-thumbs-down:before{content:"\e126"}.glyphicon-hand-right:before{content:"\e127"}.glyphicon-hand-left:before{content:"\e128"}.glyphicon-hand-up:before{content:"\e129"}.glyphicon-hand-down:before{content:"\e130"}.glyphicon-circle-arrow-right:before{content:"\e131"}.glyphicon-circle-arrow-left:before{content:"\e132"}.glyphicon-circle-arrow-up:before{content:"\e133"}.glyphicon-circle-arrow-down:before{content:"\e134"}.glyphicon-globe:before{content:"\e135"}.glyphicon-wrench:before{content:"\e136"}.glyphicon-tasks:before{content:"\e137"}.glyphicon-filter:before{content:"\e138"}.glyphicon-briefcase:before{content:"\e139"}.glyphicon-fullscreen:before{content:"\e140"}.glyphicon-dashboard:before{content:"\e141"}.glyphicon-paperclip:before{content:"\e142"}.glyphicon-heart-empty:before{content:"\e143"}.glyphicon-link:before{content:"\e144"}.glyphicon-phone:before{content:"\e145"}.glyphicon-pushpin:before{content:"\e146"}.glyphicon-usd:before{content:"\e148"}.glyphicon-gbp:before{content:"\e149"}.glyphicon-sort:before{content:"\e150"}.glyphicon-sort-by-alphabet:before{content:"\e151"}.glyphicon-sort-by-alphabet-alt:before{content:"\e152"}.glyphicon-sort-by-order:before{content:"\e153"}.glyphicon-sort-by-order-alt:before{content:"\e154"}.glyphicon-sort-by-attributes:before{content:"\e155"}.glyphicon-sort-by-attributes-alt:before{content:"\e156"}.glyphicon-unchecked:before{content:"\e157"}.glyphicon-expand:before{content:"\e158"}.glyphicon-collapse-down:before{content:"\e159"}.glyphicon-collapse-up:before{content:"\e160"}.glyphicon-log-in:before{content:"\e161"}.glyphicon-flash:before{content:"\e162"}.glyphicon-log-out:before{content:"\e163"}.glyphicon-new-window:before{content:"\e164"}.glyphicon-record:before{content:"\e165"}.glyphicon-save:before{content:"\e166"}.glyphicon-open:before{content:"\e167"}.glyphicon-saved:before{content:"\e168"}.glyphicon-import:before{content:"\e169"}.glyphicon-export:before{content:"\e170"}.glyphicon-send:before{content:"\e171"}.glyphicon-floppy-disk:before{content:"\e172"}.glyphicon-floppy-saved:before{content:"\e173"}.glyphicon-floppy-remove:before{content:"\e174"}.glyphicon-floppy-save:before{content:"\e175"}.glyphicon-floppy-open:before{content:"\e176"}.glyphicon-credit-card:before{content:"\e177"}.glyphicon-transfer:before{content:"\e178"}.glyphicon-cutlery:before{content:"\e179"}.glyphicon-header:before{content:"\e180"}.glyphicon-compressed:before{content:"\e181"}.glyphicon-earphone:before{content:"\e182"}.glyphicon-phone-alt:before{content:"\e183"}.glyphicon-tower:before{content:"\e184"}.glyphicon-stats:before{content:"\e185"}.glyphicon-sd-video:before{content:"\e186"}.glyphicon-hd-video:before{content:"\e187"}.glyphicon-subtitles:before{content:"\e188"}.glyphicon-sound-stereo:before{content:"\e189"}.glyphicon-sound-dolby:before{content:"\e190"}.glyphicon-sound-5-1:before{content:"\e191"}.glyphicon-sound-6-1:before{content:"\e192"}.glyphicon-sound-7-1:before{content:"\e193"}.glyphicon-copyright-mark:before{content:"\e194"}.glyphicon-registration-mark:before{content:"\e195"}.glyphicon-cloud-download:before{content:"\e197"}.glyphicon-cloud-upload:before{content:"\e198"}.glyphicon-tree-conifer:before{content:"\e199"}.glyphicon-tree-deciduous:before{content:"\e200"}.input-group-addon{padding:.5rem .75rem;margin-bottom:0;font-size:1rem;font-weight:400;line-height:1.25;color:#495057;text-align:center;background-color:#e9ecef;border:1px solid rgba(0,0,0,.15);border-radius:.25rem}.input-group-addon,.input-group-btn{white-space:nowrap;vertical-align:middle}.input-group .form-control,.input-group-addon,.input-group-btn{display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center}*{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}*{margin:0;padding:0;box-sizing:border-box}*,::after,::before{box-sizing:inherit}*{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}:before,:after{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}.form-control+.input-group-addon:not(:first-child){border-left:0}.input-group-addon:last-child{border-left:0}.input-group .form-control:last-child,.input-group-addon:last-child,.input-group-btn:last-child>.btn,.input-group-btn:last-child>.btn-group>.btn,.input-group-btn:last-child>.dropdown-toggle,.input-group-btn:first-child>.btn:not(:first-child),.input-group-btn:first-child>.btn-group:not(:first-child)>.btn{border-top-left-radius:0;border-bottom-left-radius:0}.input-group-addon{font-size:14px;font-weight:400;line-height:1;color:#555;text-align:center;background-color:#eee;border:1px solid #ccc;border-radius:4px}.input-group-addon,.input-group-btn{white-space:nowrap;vertical-align:middle}.input-group-addon,.input-group-btn,.input-group .form-control{display:table-cell}
</style>
    <!-- <script type="text/javascript" src="js/fixed-action-button.js"></script> -->
    
    <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
	integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
	crossorigin=""/>
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
	integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
	crossorigin=""></script> -->
    <!-- <script src="/assets/js/dropdown.js?v=1.0.0.3"></script> -->
        <?php 
        // console_log($api); 
        ?>
        <script type="text/javascript">
            window.api = <?php echo $api; ?>;
        </script>
        <?php if(isset($_REQUEST['dt'])){ ?>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/trumbowyg.min.js" integrity="sha512-sffB9/tXFFTwradcJHhojkhmrCj0hWeaz8M05Aaap5/vlYBfLx5Y7woKi6y0NrqVNgben6OIANTGGlojPTQGEw==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/cleanpaste/trumbowyg.cleanpaste.min.js" integrity="sha512-y7o2DGiZAj5/HOX10rSG1zuIq86mFfnqbus0AASAG1oU2WaF2OGwmkt2XsgJ3oYxJ69luyG7iKlQQ6wlZeV3KQ==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/colors/trumbowyg.colors.min.js" integrity="sha512-iT7g30i1//3OBZsfoc5XmlULnKQKyxir582Z9fIFWI6+ohfrTdns118QYhCTt0d09aRGcE7IRvCFjw2wngaqRQ==" crossorigin="anonymous"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/highlight/trumbowyg.highlight.min.js" integrity="sha512-WqcaEGy8Pv/jIWsXE5a2T/RMO81LN12aGxFQl0ew50NAUQUiX9bNKEpLzwYxn+Ez1TaBBJf+23OX+K4KBcf6wg==" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/history/trumbowyg.history.min.js" integrity="sha512-hvFEVvJ24BqT/WkRrbXdgbyvzMngskW3ROm8NB7sxJH6P4AEN77UexzW3Re5CigIAn2RZr8M6vQloD/JHtwB9A==" crossorigin="anonymous"></script>

        <!-- <script type="text/javascript" src="js/datatables.wsb.testing.js?v=1.0.0.57"></script> -->
        <!-- <script type="text/javascript" src="js/datatables.wsb.testing.3.js?v=1.0.0.51"></script>
        <script type="text/javascript" src="js/tester.js?v=1.0.0.76"></script> -->
        <script type="text/javascript" src="/assets/js/datatables.wsb.prod_data_TESTING.js"></script>
        <script type="text/javascript" src="/assets/js/view-ddr.js?v=1.0.0.76"></script>
        
        <?php } else { ?>
            <link type="stylesheet" href="/assets/css/wsb.style.css" />
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/trumbowyg.min.js" integrity="sha512-sffB9/tXFFTwradcJHhojkhmrCj0hWeaz8M05Aaap5/vlYBfLx5Y7woKi6y0NrqVNgben6OIANTGGlojPTQGEw==" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/cleanpaste/trumbowyg.cleanpaste.min.js" integrity="sha512-y7o2DGiZAj5/HOX10rSG1zuIq86mFfnqbus0AASAG1oU2WaF2OGwmkt2XsgJ3oYxJ69luyG7iKlQQ6wlZeV3KQ==" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/colors/trumbowyg.colors.min.js" integrity="sha512-iT7g30i1//3OBZsfoc5XmlULnKQKyxir582Z9fIFWI6+ohfrTdns118QYhCTt0d09aRGcE7IRvCFjw2wngaqRQ==" crossorigin="anonymous"></script>
            <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/highlight/trumbowyg.highlight.min.js" integrity="sha512-WqcaEGy8Pv/jIWsXE5a2T/RMO81LN12aGxFQl0ew50NAUQUiX9bNKEpLzwYxn+Ez1TaBBJf+23OX+K4KBcf6wg==" crossorigin="anonymous"></script> -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/history/trumbowyg.history.min.js" integrity="sha512-hvFEVvJ24BqT/WkRrbXdgbyvzMngskW3ROm8NB7sxJH6P4AEN77UexzW3Re5CigIAn2RZr8M6vQloD/JHtwB9A==" crossorigin="anonymous"></script>
            <!-- <script src="/assets/js/tinymce/tinymce.min.js?v1"></script>
            <script src="/assets/js/tinymce/jquery.tinymce.min.js"></script> -->
        <script type="text/javascript" src="/assets/js/datatables.wsb.prod_data.js?v=1.0.3.157"></script>
        <script type="text/javascript" src="/assets/js/view-ddr.js?v=1.0.0.78"></script>
        
        <?php } ?>
        <!-- DDR.JS IS NOT INCLUDED DUE TO DUPLICATION OF ENTRIES -->
        <!-- <script type="text/javascript" src="js/wsb.ddr.js?v=1.0.0.2"></script> -->

  <script>
	 function ajaxSelect(page){
	   var ajaxRequest;  // The variable that makes Ajax possible!
	   try { ajaxRequest = new XMLHttpRequest();// Opera 8.0+, Firefox, Safari
	   }catch (e) {// Internet Explorer Browsers
		  try { ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		  }catch (e) { try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			 }catch (e){ // Something went wrong
				alert("Your browser broke!");
				return false;
			 }
		  }
	   }

	   // Create a function that will receive data 
	   // sent from the server and will update
	   // div section in the same page.

	   ajaxRequest.onreadystatechange = function(){
		  if(ajaxRequest.readyState == 4){
			 var ajaxDisplay = document.getElementById('ajaxDiv');
			 ajaxDisplay.innerHTML = ajaxRequest.responseText;
		  }
	   }

	   // Now get the value from user and pass it to
	   // server script.
	   
	   var queryString = page;
       var variableOne = "categoryid";
	   var variableTwo = "link";
	   var variableThree = "name";
	   var valueOne = document.getElementById('categoryid').value;
	   var valueTwo = document.getElementById('link').value;
	   var valueThree = document.getElementById('name').value;
	   var finalString = page + "?" + variableOne + "=" + valueOne
							+ "&" + variableTwo + "=" + valueTwo
							+ "&" + variableThree + "=" + valueThree;
	   
			 ajaxRequest.open("GET", queryString, true);
			 ajaxRequest.send(null); 
		 
	}
	</script>
    <style>.nav-underline .active { font-weight:600!important; color: #e3f2fd!important; box-shadow: 0rem 0rem 0rem 0rem rgba(0,0,0,0) inset!important; background-color: #e3f2fd; }</style>
    <title><?php echo $well; ?></title>
    <!-- <script type="text/javascript">
        // Unused, but this code will allow for a specific tab to load based on the url
        // For example, url.php#t1 will load the t1 tab instead of the default detail tab
        $(document).ready(function() {
            var url = window.location.href;
            var activeTab = url.substring(url.indexOf("#") + 1);
            $('a[href="#'+ activeTab +'"]').tab('show')
            $(".tab-pane").removeClass("active in");
        });
    </script> -->
</head>
<style>
        /* #mapid { 
           
            height: 50vh; 
        } */
        /* body { */
                /* top: 56px; */
            /* overflow-y: hidden; Hide scrollbars */
        /* } 	 */
        .production {
            width: 100%;
            display: inline-table;
            height:auto;
            table-layout: fixed;
            /* padding-left: 5%; */
        }
        /* table{
            height:0%; 
            display: -moz-groupbox;
            overflow: hidden;
        }
        tbody{
            overflow-y: scroll;
            height: 79vh;
            width: auto;
            position: absolute;
        } */
        /* table{
        height:0%; 
        display: -moz-groupbox;
        overflow: hidden;
        } */
        .table > thead {
            font-style: normal!important;
            font-stretch: condensed!important;
            font-size: 12px;
        }
        /* .table > thead > tr {
        width: 100%;
        display: inline-table;
        height:auto;
        table-layout: fixed;
        }
        .table > tbody > tr {
        width: 100%;
        display: inline-table;
        height:auto;
        table-layout: fixed;
        }
        .table > thead > tr > td{
            padding-left: 1%!important;
        }
        .table > tbody > tr > td{
            padding-left: 1%!important;
        }
        
        table.table > tbody{
        overflow-y: scroll;
        height: 70vh;
        width: auto;
        position: fixed;
        } */

        .engineering-date {
            color: #ff4d4d;
            font-weight: 900;
            
        }
        td:first-child.engineering-d {
            font-weight: bold;
        }
        .engineering {
            font-size: 12px;
        }
        .accounting {
            /* background-color: rgba(77,77,255,0.5);  */
            /* color: white; */
            color: #4d4dff;
        }
        .accounting-text { 
            color: rgba(77,77,255,0);
            font-size: 12px;
        }	
        td:first-child.accounting-date {
            font-weight: bold;
        }	
        .vendor{
            /* background-color: gold; */
            font-size: 11px;
            background-color: rgba(255, 215, 0, 0.5);
        }
        .vendor > table.vendortable {
            background-color: rgba(204, 255, 204, 1)!important;
        }

        .vendortable {
            background-color: rgba(204, 255, 204, 1)!important;
        }
        .field {
            font-size: 12px;
            color: purple;
        }
        td:first-child.field-date { 
            font-weight: bold; 
        }	
        #eng { display: none; }
        #acct { display: none; }
        #vend { display: none; }
        #field { display: none; }
        .not-allowed { cursor: not-allowed; }
        .gold { background-color: gold; }
        .red { background-color: #ff4d4d; }
        .purple { background-color: purple; color: white; }
        .blue { background-color: #4d4dff; color: white; }
        .text-wrap{
            white-space:normal!important;
        }
        .lg-icon {
            width: 1.625rem;
            height: 1.625rem;
            vertical-align: -webkit-baseline-middle;

        }
        .sm-icon {
            width: 1.25rem;
            height: 1.25rem;
            vertical-align: -webkit-baseline-middle;
            margin-top: 0.75rem;
        }
        .smol th,
        .smol td,
        .smol a,
        .smol p {
        padding-top: 0.3rem;
        padding-bottom: 0.3rem;
        font-size: 14px;
        }
        table.dataTable tbody td 
        {
        word-break: break-word;
        vertical-align: top;
        }
        .text-wrap
        {
            white-space:normal;
        }
        .svg 
        {
            width: 24px;
            height: 24px;
            color: white;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
        }
        .edit 
        {
            background-image: url("./image/edit-2.svg");
        }
        .view
        {
            background-image: url("./image/eye.svg");
        }
        .cumulativeproduction 
        {
            width: 13vw;
            /* height: 10em; */
            background-color: rbga(255,255,255,0.5);
            position: fixed;
            z-index: 1;
            display: inline-block;
            overflow: hidden;
            /* line-height: 1.5; */
        }
    </style>
<body class="bg-light" style="background-color: #0e5092;">
    <?php include 'include/header_extensions.php'; ?>
    <!-- Couldn't control the zoom offset using MapBox's API -- have to edit JS file manually -->
    <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-minimap/v1.0.0/Control.MiniMap.js'></script>
    <!-- <script type="text/javascript" src='/assets/js/Control.MiniMap.js?v1.1'></script> -->
    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-minimap/v1.0.0/Control.MiniMap.css' rel='stylesheet' />
<div class='limiter'>     
<main role="main" >
	<nav class="nav-scroller bg-white shadow-sm nav-underline navbar-expand-md" id="tabs" style="height: auto; " >
        <div class="navbar-collapse offcanvas-collapse">
            <ul class="nav justify-content-start ml-auto p-0">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <span class="h6 mt-2 text-black"><?php echo $common_name; ?></span>
                            <div class="w-100"></div>
                            <span class="form-text text-muted mt-0"><?php echo $countyparish; ?> County, <?php echo $db_state; ?></span>
                        </div>
                        <div class="col-auto"><li class="divider-vertical h--auto mt--2 p-0 ml-auto">&nbsp;</li></div>
                        <div class="col">
                            <span class="text-black p-0 h5 h6"><?php echo $apino; ?></span>
                            <div class="w-100"></div>
                            <span class="h6 mt-0" <?php echo $status ?>>Status: <?php echo $wellstatus; ?></span>
                        </div>
                    </div>
                </div>
            </ul>
            <ul class="nav justify-content-end ml-auto nav-pills" id="myTab" role="tablist" style="position: relative; z-index: 940; padding-bottom: 0px;">
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="vitals-tab" data-toggle="tab" href="#vitals" role="tab" aria-controls="vitals" aria-selected="false">Vitals</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">Well Info</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="detail-tab" data-toggle="tab" href="#detail" role="tab" aria-controls="detail" aria-selected="true">Detailed Production</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="ddr-tab" data-toggle="tab" href="#ddr" role="tab" aria-controls="ddr" aria-selected="false">DDR-D</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="dsr-tab" data-toggle="tab" href="#dsr" role="tab" aria-controls="dsr" aria-selected="false">DSR-D</a>
                </li>
                <?php if($ddr20check === 1) { ?>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="t1-tab" data-toggle="tab" href="#t1" role="tab" aria-controls="t1" aria-selected="false">DDR 2015-2020</a>
                </li>
                <?php 
                    }
                    if($dsr20check === 1) { 
                ?>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="t2-tab" data-toggle="tab" href="#t2" role="tab" aria-controls="t2" aria-selected="false">DSR 2015-2020</a>
                </li>
                <?php 
                    }
                    if($ddr15check === 1) { 
                ?>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="t3-tab" data-toggle="tab" href="#t3" role="tab" aria-controls="t3" aria-selected="false">DDR Pre-2015</a>
                </li>
                <?php 
                    }
                    if($dsr15check === 1) { 
                ?>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="t4-tab" data-toggle="tab" href="#t4" role="tab" aria-controls="t4" aria-selected="false">DSR Pre-2015</a>
                </li>
                <?php 
                    }
                ?>
            </ul> 
        </div>
    </nav>
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade " id="info" role="tabpanel" aria-labelledby="info-tab" style="position: relative; z-index: 940;">
                    <div class="carded m-3 ">
                        <div class="row justify-content-center bg-light">
                            <div class="carded-body m-3 p-3 shadow-lg col-5 bg-white" style="box-shadow: 0 .5rem 1rem rgba(0,0,0,.175)!important;">
                                <div class="row">
                                    <h3 id="cn" class="wellinfo"><?php echo $common_name; ?></h3>
                                </div>
                                <div class="row">
                                    <h3 id="an" class="wellinfo"><?php echo $apino; ?></h3>
                                </div>
                                <div class="row">
                                    <p>Company:  </p>
                                    <p id="eo" class="wellinfo"> <?php echo $entop; ?></p>
                                </div>
                                <div class="row">
                                <p>Pumper:  </p>
                                    <p id="p" class="wellinfo"><?php echo $db_pumper; ?></p>
                                </div>
                                <div class="row">
                                <p>State:  </p>
                                    <p id="s" class="wellinfo"><?php echo $db_state; ?></p>
                                </div>
                                <div class="row">
                                <p>County/Parish:  </p>
                                    <p id="cp" class="wellinfo"><?php echo $countyparish; ?></p>
                                </div>
                                <div class="row">
                                <p>Block:  </p>
                                    <p id="b" class="wellinfo"><?php echo $db_block; ?></p>
                                </div>
                                <div class="row">
                                    <p>Notes: <?php echo $db_notes; ?></p>
                                    <p><smll>Last updated: <?php echo $db_notes_update; ?></smll></p>
                                </div>
                                <div class="row">
                                <p>Latitude (WGS84):  </p>
                                    <p id="lat" class="wellinfo"><?php echo $db_lat; ?></p>
                                </div>
                                <div class="row">
                                <p>Longitude (WGS84):  </p>
                                    <p id="long" class="wellinfo"><?php echo $db_long; ?></p>
                                </div>
                                    <hr>
                                <div class="row">
                                    <p id="wfl" class="wellinfo"><strong>Well File Location: <?php echo $wellfilelocation; ?></strong></p>
                                </div>
                            </div>
                            <div class="row carded-body m-3 p-3 shadow-lg col-5 bg-white" style="box-shadow: 0 .5rem 1rem rgba(0,0,0,.175)!important;">
                                <div class="col">    
                                    <div class="row">
                                    <p <?php echo $status ?>>Status:  </p>
                                        <h3 id="ws" <?php echo $status ?>><?php echo $wellstatus; ?></h3>	
                                    </div>
                                    <div class="row">
                                    <p>Production Type:  </p>
                                        <h3 id="pt" class="wellinfo"><?php echo $prod_type; ?></h3>
                                    </div>
                                    <div class="row">
                                    <p>Reservoir:  </p>
                                        <p id="r" class="wellinfo"><?php echo $reservoir; ?></p>
                                    </div>
                                    <div class="row">
                                    <p>Field:  </p>
                                        <p id="f" class="wellinfo"><?php echo $db_field; ?></p>
                                    </div>
                                    <div class="row">
                                    <p>MD:  </p>
                                        <p id="md" class="wellinfo"><?php echo $md; ?> ft</p>
                                    </div>
                                    <div class="row">
                                    <p>TVD:  </p>
                                        <p id="tvd" class="wellinfo"><?php echo $tvd; ?> ft</p>
                                    </div>
                                    <div class="row">
                                    <p>Drill Type:  </p>
                                        <p id="dt" class="wellinfo"><?php echo $drill_type; ?></p>
                                    </div>
                                    <div class="row">
                                    <p>Completed:  </p>
                                        <p id="cd" class="wellinfo"><?php echo $complete_date; ?></p>
                                    </div>
                                    <div class="row">
                                    <p>First Produced:  </p>
                                        <p id="fpd" class="wellinfo"><?php echo $firstprod; ?></p>
                                    </div>
                                </div>
                                <div class="col mt-5">
                                    <div class="row">
                                    <p>Gas Gatherer:  </p>
                                        <p id="ggr" class="wellinfo"><?php echo $gas_gather; ?></p>
                                    </div>
                                    <div class="row">
                                    <p>Oil Gatherer:  </p>
                                        <p id="ogr" class="wellinfo"><?php echo $oil_gather; ?></p>
                                        </div>
                                    <div class="row">
                                    <p>Upper Perforation:  </p>
                                        <p id="up" class="wellinfo"><?php echo $upper_perf; ?></p>
                                    </div>
                                    <div class="row">
                                    <p>Lower Perforation:  </p>
                                        <p id="lp" class="wellinfo"> <?php echo $lower_perf; ?></p>
                                    </div>
                                    <div class="row">
                                    <p>Gas Gravity:  </p>
                                        <p id="gg" class="wellinfo"> <?php echo $gas_gravity; ?></p>
                                    </div>
                                    <div class="row">
                                    <p>Oil Gravity:  </p>
                                        <p id="og" class="wellinfo"><?php echo $oil_gravity; ?></p>
                                    </div>
                                    <div class="row">
                                    <p>Spud Date:  </p>
                                        <p id="sd" class="wellinfo"><?php echo $spud; ?></p>
                                    </div>
                                    <div class="row">
                                        <p>Last Produced:  </p>
                                        <p id="lpd" class="wellinfo"><?php echo $lastprod; ?></p>
                                    </div>
                                </div>
                                <div class="w-100"></div>
                                <hr class="w-100">
                                <div class="mx-auto"><a class="btn btn-primary btn-lg edit-well-info" id=<?php echo $api; ?> href="#">Edit Well Info</a></div>
                            </div>
                        </div>
                        <!-- <div class="row justify-content-center bg-light">
                            <div class="p-3 col-11 " >
                                <div class="m-3 p-3 shadow-lg carded-body bg-white">
                                    <table id='notesTable' class='table bg-white table-sm smol'>
                                        <thead>
                                            <tr>
                                                <th>Date Updated</th>
                                                <th>General Notes</th>
                                                <th>S/I Notes</th>
                                                <th>Pumper</th>
                                            </tr>
                                        </thead>
                                        
                                    </table>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="row justify-content-center bg-light">
                            <div class="carded-body m-3 p-3 shadow-lg col-5 bg-white" style="box-shadow: 0 .5rem 1rem rgba(0,0,0,.175)!important;">
                                <div class="row">
                                    <div class="col">
                                        <h3>Landowner:</h3><h4 id="l"><?php echo $landowner; ?></h4>
                                    </div>
                                    <div class="col">
                                        <h3>Gate Combo:</h3><h4 id="gc"><?php echo $gatecombo; ?></h4>
                                    </div>
                                </div>
                                <hr>
                                <div class="w-100"></div>
                                <div class="row">
                                    <div class="col-12">
                                        <p><strong>Landowner notes:</strong></p><p class="wellinfo" id="ln"><?php echo $landowner_notes; ?></p>
                                    </div>
                                </div>
                            </div>
                    </div>
			</div>
			
            <div class="tab-pane fade " id="ddr" role="tabpanel" aria-labelledby="ddr-tab" style="position: relative; z-index: 940;">
                <div class="carde-d m--3 p--3 shadow--lg">
                    <!-- <div class="carded--header"><h1>DDR-D | <?php echo $common_name; ?></h1></div> -->
                        <div class="carded--body">
                            <table id="ddrTable" class='table display p-0 table--striped table--borderless table-bordered datatable-tab-correct datatable-tab-correct1 table-condensed table-sm smoller table-hover' style="margin-top: 0px !important; width: 100% !important;" >
                                <thead class="smol bg-sog ">
                                    <tr>
                                        <th rowspan="2">Actions</th>
                                        <th rowspan="2">Date</th>
                                        <th rowspan="2">Time</th>
                                        <th colspan="1" style='<?php echo $width2; ?>'>Vendor</th>
                                        <th colspan="1">Invoice #</th>
                                        <th colspan="1">Invoice Details</th>
                                        <th colspan="1">$</th>
                                        <th colspan="1">Approvals</th>
                                    </tr>
                                    <tr>
                                        <th style='<?php echo $width2; ?>'>Contact</th>
                                        <th>Contact Info</th>
                                        <th>DDR</th>
                                        <th>EDC</th>
                                        <th>ECC</th>
                                    </tr>
                                        <!-- <th class="table-header" style='<?php echo $width2; ?> '>Date</th>
                                        <th class="table-header" style='<?php echo $width2; ?> '>Time</th>
                                        <th class="table-header" style='<?php echo $width2; ?> '>Vendor/Contact</a></th>
                                        <th class="table-header" style='<?php echo $width7; ?> '>Invoice #/Contact Info</a></th>
                                        <th class="table-header" style='<?php echo $width14; ?>'>Invoice Details/DDR</th>
                                        <th class="table-header" style='<?php echo $width2; ?> '>$/EDC</a></th>
                                        <th class="table-header" style='<?php echo $width2; ?> '>Approvals/ECC</a></th>
                                        <th class="table-header" style='<?php echo $width2; ?>'>Actions</th> -->
                                        
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

            <div class="tab-pane fade " id="dsr" role="tabpanel" aria-labelledby="dsr-tab" style="position: relative; z-index: 940;">
                <div class="carde-d m--3 p--3 shadow--lg">
                    <!-- <div class="carded--header"><h1>DDR-D | <?php echo $common_name; ?></h1></div> -->
                        <div class="carded--body">
                            <table id="dsrTable" class='table display p-0 table--striped table--borderless table-bordered datatable-tab-correct datatable-tab-correct1 table-condensed table-sm smoller table-hover' style="margin-top: 0px !important; width: 100% !important;" >
                                <thead class="smol bg-sog ">
                                    <tr>
                                        <th rowspan="2">Actions</th>
                                        <th rowspan="2">Date</th>
                                        <th rowspan="2">DSR</th>
                                        <th colspan="1">$</th>
                                        <th colspan="1">Approvals</th>
                                    </tr>
                                    <tr>
                                        <!-- <th style='<?php echo $width2; ?>'>Contact</th>
                                        <th>Contact Info</th>
                                        <th>DDR</th> -->
                                        <th>EDC</th>
                                        <th>ECC</th>
                                    </tr>
                                    <!-- <tr>
                                        <th>Date</th>
                                        <th>DSR</th>
                                        <th>$ / EDC</a></th>
                                        <th>Approvals / ECC</a></th>
                                        <th>Actions</th>
                                    </tr>                                        -->
                                </thead>
                            </table>
                        </div>
                    </div>
            </div>
                <!-- <div class="carded m-3 p-3 shadow-lg">
                    <div class="carded-header">
                    <h1>DSR-D</h1>
                    <div class="mx-auto" name="add_dsr" id="add_dsr" href="#add_data_dsr_Modal" data-toggle="modal"><a class="btn btn-primary btn-lg" id=<?php echo $api; ?> href="#">Add DSR Entry</a></div>
                    </div>
                        <div class="carded-body">
                            <table id="dsrTable" class='table display table-striped table-borderless datatable-tab-correct datatable-tab-correct1 smol table-hover' style="margin-top: 0px !important; width: 100% !important;" >
                                <thead class=" bg-sog ">
                                        <th <?php // echo $width2; ?>>Date</th>
                                        <th <?php // echo $width10; ?>>DSR</th>
                                        <th <?php // echo $width4; ?>>$ / EDC</a></th>
                                        <th <?php // echo $width4; ?>>Approvals / ECC</a></th>
                                        <th <?php // echo $width4; ?>>Actions</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div> -->

            <div class="tab-pane fade " id="t1" role="tabpanel" aria-labelledby="t1-tab" style="position: relative; z-index: 940;">
				<div class="carde-d m--3 p--3 shadow--lg">
                    <!-- <div class="carded--header"><h1>DDR 2015-2020</h1></div> -->
                        <div class="carded--body">
                            <table id="ddr2015pres" class='table display p-0 table--striped table--borderless table-bordered datatable-tab-correct datatable-tab-correct1 table-condensed table-sm smoller table-hover' style="margin-top: 0px !important; width: 100% !important;" >
                                <thead class="bg-sog smol">
                                    <tr>
                                        <th rowspan="2">Date</th>
                                        <th rowspan="2">Time</th>
                                        <th colspan="1" style='<?php echo $width2; ?>'>Vendor</th>
                                        <th colspan="1">Invoice #</th>
                                        <th colspan="1">Invoice Details</th>
                                        <th colspan="1">$</th>
                                        <th colspan="1">Approvals</th>
                                    </tr>
                                    <tr>
                                        <th style='<?php echo $width2; ?>'>Contact</th>
                                        <th>Contact Info</th>
                                        <th>DDR</th>
                                        <th>EDC</th>
                                        <th>ECC</th>
                                    </tr>
                                    <!-- <tr>
                                        <th <?php echo $width2; ?> class="table-header">Date</th>
                                        <th <?php echo $width2; ?> class="table-header">Time</th>
                                        <th <?php echo $width2; ?> class="table-header">Vendor/Contact</th>
                                        <th <?php echo $width7; ?> class="table-header">Invoice #/Contact Info</th>
                                        <th <?php echo $width14; ?> class="table-header">Invoice Details/DDR</th>
                                        <th <?php echo $width2; ?> class="table-header">$/EDC</th>
                                        <th <?php echo $width2; ?> class="table-header">Approvals/ECC</th>
                                    </tr> -->
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            <div class="tab-pane fade " id="t2" role="tabpanel" aria-labelledby="t2-tab" style="position: relative; z-index: 940;">
                <div class="carde-d m--3 p--3 shadow--lg"> 
                    <!-- <div class="carded-header"><h1>DSR 2015-2020</h1></div> -->
                        <div class="carded--body">  
                            <table id="dsr2015pres" class='table display p-0 table--striped table--borderless table-bordered datatable-tab-correct datatable-tab-correct1 table-condensed table-sm smoller table-hover' style="margin-top: 0px !important; width: 100% !important;" >
                                <thead class="bg-sog smol">
                                    <!-- <tr>
                                        <th rowspan="2">Date</th>
                                        <th rowspan="2" colspan="2">Daily Summary Report</th>
                                        <th rowspan="2" colspan="2">EDC</th>
                                        <th rowspan="2" colspan="2">Approvals</th>
                                    </tr> -->
                                    <!-- <tr>
                                        <th style='<?php echo $width2; ?>'>Contact</th>
                                        <th>Contact Info</th>
                                        <th>DDR</th>
                                        <th>EDC</th>
                                        <th>ECC</th>
                                    </tr> -->
                                    <tr>
                                        <th class="table-header">Date</th>
                                        
                                        <th class="table-header">Daily Summary Report</th>
                                        
                                        <th class="table-header">EDC</th>
                                        
                                        <th class="table-header">ECC</th>
                                        <th class="table-header">&nbsp;</th>
                                        <th class="table-header">&nbsp;</th>
                                        <th class="table-header">&nbsp;</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            <div class="tab-pane fade " id="t3" role="tabpanel" aria-labelledby="t3-tab" style="position: relative; z-index: 940;">
                <div class="carde-d m--3 p--3 shadow--lg">
                    <!--<div class="carded--header"><h1>Before 2015 Detail Report</h1></div> -->
                        <div class="carded--body">
                            <table id="before2015detailrpt" class='table display p-0 table--striped table--borderless table-bordered datatable-tab-correct datatable-tab-correct1 table-condensed table-sm smoller table-hover' style="margin-top: 0px !important; width: 100% !important;" >
                                <thead class="bg-sog smol">
                                    <tr>
                                        <th class="table-header">A</th>
                                        <th class="table-header">B</th>
                                        <th class="table-header">C</th>
                                        <th class="table-header">D</th>
                                        <th class="table-header">E</th>
                                        <th class="table-header">F</th>
                                        <th class="table-header">G</th>
                                        <th class="table-header">H</th>
                                        <th class="table-header">I</th>
                                        <th class="table-header">J</th>
                                        <th class="table-header">K</th>
                                        <th class="table-header">L</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            <div class="tab-pane fade " id="t4" role="tabpanel" aria-labelledby="t4-tab" style="position: relative; z-index: 940;">
                <div class="carde-d m--3 p--3 shadow--lg">
                    <!--<div class="carded--header"><h1>Before 2015 Summary Report</h1></div> -->
                        <div class="carded--body">
                            <table id="before2015sumrpt" class='table display p-0 table--striped table--borderless table-bordered datatable-tab-correct datatable-tab-correct1 table-condensed table-sm smoller table-hover' style="margin-top: 0px !important; width: 100% !important;" >
                                <thead class="bg-sog smol">
                                    <tr>
                                        <th class="table-header">&nbsp;</th>
                                        <th class="table-header">A</th>
                                        <th class="table-header">B</th>
                                        <th class="table-header">C</th>
                                        <th class="table-header">D</th>
                                        <th class="table-header">E</th>
                                        <th class="table-header">F</th>
                                        <th class="table-header">G</th>
                                        <th class="table-header">H</th>
                                        <th class="table-header">I</th>
                                        <th class="table-header">J</th>
                                        <th class="table-header">K</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
			<div class="tab-pane fade in show active" id="detail" role="tabpanel" aria-labelledby="detail-tab" style="position: relative; z-index: 940;"> 
				<div class="m-3 carded bg-light">
					<div class="row justify-content-center">
                    
                        <div class="col-5 m-3 p-3 shadow-lg carded-body bg-white">
							
							<div id="mapid"></div>
						</div>
                            <script>
                                
                            </script>
                            
                        
                        <style>
                                .nav-pills:not(.nav-link.active), .nav-pills:not(.show>.nav-link) {
                                color: #212529;
                                background-color: #fff;
                                }
                                .nav-link-white{
                                color: #212529;
                                background-color: #fff;
                                border-radius: 0rem!important;
                                }
                            </style>
                            <div id="leftside" class="col-6 m--3 p-3">

						<!-- <div id="leftside" class="col-6 m-3 p-3 shadow-lg carded-body bg-white"> -->

                            

                            <div id="pills-vert" class="" style="position: fixed;">
                                <nav class="" id="infotabs" style="height: auto;" >
                                    <ul class="nav flex-column nav-pills" id="info-ul-tabs" role="tablist" style="z-index: 940; padding-bottom: 0px;">
                                        <li class="nav-item " role="presentation">
                                            <a class="nav-link nav-link-white active" id="productiongraph-tab" data-toggle="tab" href="#chartdiv" role="tab" aria-controls="detail" aria-selected="true"><i data-feather='activity' ></i></a>
                                        </li>
                                        <li class="nav-item " role="presentation">
                                            <a class="nav-link nav-link-white" id="productiontable-tab" data-toggle="tab" href="#proddiv" role="tab" aria-controls="detail" aria-selected="false"><i class="fas fa-table"></i></a>
                                        </li>
                                        <!-- <li class="nav-item " role="presentation">
                                            <a class="nav-link nav-link-white" id="timesheet-tab" data-toggle="tab" href="#time" role="tab" aria-controls="detail" aria-selected="false"><i data-feather='clock' ></i></a>
                                        </li> -->
                                    </ul>
                                </nav>
                            </div>
                            <div id="object-div" class="shadow-lg carded-body bg-white">
                                <div class="tab-content" id="infotabs-content">
                                    <div class="tab-pane fade in show active" id="chartdiv" role="tabpanel" aria-labelledby="calendar-tab" style="position: relative; z-index: 940;">
                                        <div class="row mx-auto" id="cumulativeproduction" >
                                            <!-- <div class="col">
                                                <h6 class="text-center"><?php echo $welllease; ?></h6>
                                            </div>
                                            <div class=w-100></div>
                                            <div class="col">
                                                <h6 class="text-center">Cumulative Production</h6>
                                            </div>
                                            <div class=w-100></div> -->
                                            <div class="col">
                                                <h6 class="text-center"><?php echo $welllease; ?> Cumulative Production</h6>
                                            </div>
                                            <div class=w-100></div>
                                            <div class="col text-center"><p>Oil</p><div class=w-100></div> <p><?php echo $cumoil; ?> bbl</p></div>
                                            <div class="col text-center"><p>Gas</p><div class=w-100></div> <p><?php echo $cumgas; ?> mcf</p></div>
                                            <div class="col text-center"><p>Water</p><div class=w-100></div> <p><?php echo $cumwater; ?> bbl</p></div>

                                            <!-- <div class="p-0">
                                                <div class="row"><p>Oil: <?php echo $cumoil; ?> bbl</p></div>
                                                <div class="row"><p>Gas: <?php echo $cumgas; ?> mcf</p></div>
                                                <div class="row"><p>Water: <?php echo $cumwater; ?> bbl</p></div>
                                            </div> -->
                                        </div>
                                    <!-- <h3 class="r-tooltip" data-tippy-content=""><?php echo $well; ?></h3> -->
                                        <div class="chart-container">
                                            <canvas id="chart"></canvas> 
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="proddiv" role="tabpanel" aria-labelledby="calendar-tab" style="position: relative; z-index: 940;">
                                    <h3 class="r-tooltip" data-tippy-content=""><?php echo $well; ?></h3>
                                        <table id='productionTable' class='table bg-white table-sm smol'>
                                            <thead>
                                                <tr>
                                                    <th>Month</th>
                                                    <th>Days On</th>
                                                    <th>Gas Production</th>
                                                    <th>Oil Production</th>
                                                    <th>Water Production</th>
                                                    <th>Gas Sold</th>
                                                    <th>Oil Sold</th>
                                                    <th>Line Loss</th>
                                                    <th>Flug</th>
                                                    </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>

                                        
							<!-- <div class="chart-container" style="position: relative; width: 100%; height: 50vh;">
								<canvas id="chart" ></canvas> 
							</div> -->
                            
						</div>
                        
						<!-- <div class="<?php echo $mapwidth ?> m-3 p-3 shadow-lg carded-body bg-white">
							
							<div id="mapid"></div>
						</div> -->
					</div>
					<?php
						$mapsql = "SELECT * FROM `list` where api =  $api ";
						$mapresult = mysqli_query($mysqli, $mapsql);
						// console_log($mapresult);
						//loop through the returned data
						while ($row = mysqli_fetch_array($mapresult)) {
							$lat = $row['surface_latitude_wgs84'];
							// console_log($lat);
							$lon = $row['surface_longitude_wgs84'];
							// console_log($lon);
						}
						$zoom = 13;
						$xtile = floor((($lon + 180) / 360) * pow(2, $zoom));
						$xtile = truncateCoordinates($lon, 3);
						$ytile = floor((1 - log(tan(deg2rad($lat)) + 1 / cos(deg2rad($lat))) / pi()) /2 * pow(2, $zoom));
						$ytile = truncateCoordinates($lat, 3);
						$n = pow(2, $zoom);
						$lon_deg = 51.505 / $n * 360.0 - 180.0;
						$lat_deg = rad2deg(atan(sinh(pi() * (1 - 2 * (-0.09)) / $n)));
						// console_log($xtile);
						// console_log($ytile);
						?>
                        
					<!-- <div class="m-3 p-3 shadow-lg carded-body bg-white">
						<table id='productionTable' class='table bg-white table-sm smol'>
							<thead>
								<tr>
									<th>Month</th>
									<th>Days On</th>
									<th>Gas Production</th>
									<th>Oil Production</th>
									<th>Water Production</th>
									<th>Gas Sold</th>
									<th>Oil Sold</th>
									<th>Line Loss</th>
									<th>Flug</th>
									</tr>
							</thead>
							
						</table>
					</div> -->
                    
				</div>
				<?php } else { ?>
				<div class="container d-flex justify-content-center">   
					<form action="<?php echo $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" method="post" name="form">
						<div class="form-row form-group">
							<div class="col"><b>Production Data</b></div>
							<div class="col">
								<select class="custom-select" name="api" size="1">
								<?php
									$table = "static_data";
									$sql = "SELECT api, well_lease, well_no FROM $table";// ORDER BY well_lease ASC";
									$result = mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
								?>
								<option>Select Well:</option>
								<?php while ($row = mysqli_fetch_array($result)) {
									$wellname = $row['well_lease'] . "# " . $row['well_no']; ?>
								<option value="<?php echo $row['api']; ?>"><?php echo $wellname; //$row['api']; // . $row['well_no'];?></option> 
									<?php } ?>
								</select> 
							</div>
						</div>
						<div class="form-row form-group">
							<div class="col"><input class="btn button primary" type="submit" name="submit" value="Add"></div>
						</div>
					</form>	
				<?php } ?>
				</div>
				<script>
                    var body = document.querySelector("body").offsetHeight;
                    var nav = document.querySelector("body > nav").offsetHeight;
                    var subnav = document.querySelector("#tabs").offsetHeight;
                    var table_header = document.querySelector("#ddrTable").offsetHeight;
                    var dt_scroller_height = body - nav - subnav - table_header - 5;
                    var chart_size = body - nav - nav - subnav - 96;
                    $(document).ready(function() {
                                    tabMove();
                                    
                                    // tabResize();
                    });
                    window.addEventListener("resize", tabMove);
                    function tabMove(){
                        var pillgroup = document.querySelector("#pills-vert").offsetWidth ;
                        
                        document.querySelector("#object-div").setAttribute('style', 'left:' + pillgroup + 'px; position: relative;');
                        document.querySelector("#leftside").setAttribute('style', 'right:' + pillgroup / 2 + 'px; position: relative;');
                        var body = document.querySelector("body").offsetHeight;
                    var nav = document.querySelector("body > nav").offsetHeight;
                    var subnav = document.querySelector("#tabs").offsetHeight;
                    var table_header = document.querySelector("#ddrTable").offsetHeight;
                    var dt_scroller_height = body - nav - subnav - table_header - 5;
                    var chart_size = body - nav - nav - subnav - 96;
                    document.querySelector(".chart-container").setAttribute('style','position:relative;width:100%;height:'+chart_size+'px;')
                    // myChart.resize();
                        // document.querySelector("#pills-vert").setAttribute('style', 'right:' + pillgroup * -1 + 'px; position: relative;');
                        // document.querySelector("#infotabs-content").setAttribute('style', 'left:' + pillgroup + 'px; position: relative;');
                        // document.querySelector("#leftside").setAttribute('style', 'right:' + pillgroup + 'px; position: relative;');
                        // var leftside = document.querySelector("#leftside").offsetWidth;
                        // document.querySelector("#pills-vert").setAttribute('style', 'left:' + leftside + 'px; position: relative;');


                        // var cal = document.querySelector("#right-side").scrollWidth;
                        // var totalwidth = cal + pillgroup - 1;
                        // document.querySelector("#pills-vert").setAttribute('style', 'left:' + pillgroup + 'px; position: relative;');
                    }
                    function tabResize() {
                        $('#object-div').affix({
                        offset: {
                            left: function() { return $('#pills-vert').width(); }
                        }
                        });
                    }
                    // var bodyheightdifference = document.querySelector("body").scrollHeight - document.querySelector("body").offsetHeight;
                    //     console.log(bodyheightdifference);
                    
                    document.querySelector(".chart-container").setAttribute('style','position:relative;width:100%;height:'+chart_size+'px;')
					let myScale = Chart.Scale.extend({
					/* extensions ... */
					});
					var ctx = document.getElementById("chart").getContext('2d');
          // console.log('data: ' <?php echo $data1; ?>)
					var myChart = new Chart(ctx, {
					type: 'line',
					data: {
						labels: [<?php echo $proddate; ?>],
						datasets: 
						[{
							label: 'Oil',
							data: [<?php echo $data1; ?>],
							backgroundColor: 'transparent',
							//backgroundColor: 'rgba(255,99,132)',
							borderColor:'rgba(132,255,99)',
							//borderColor: 'transparent',
							borderWidth: 1,
							pointBackgroundColor: 'rgba(0, 0, 0, 0)',
							pointBorderColor: 'rgba(0, 0, 0, 0)',
							pointBorderWidth: 1,
							//steppedLine = 'before'
							//steppedLine: true,
							yAxisID: 'bbl-y-axis'
						},
						{
							label: 'Gas',
							data: [<?php echo $data2; ?>],
							backgroundColor: 'transparent',
							borderColor:'rgba(255,99,132)',
							borderWidth: 1,
							pointBackgroundColor: 'rgba(0, 0, 0, 0)',
							pointBorderColor: 'rgba(0, 0, 0, 0)',
							pointBorderWidth: 1,
							yAxisID: 'mcf-y-axis'	
						},
						{
							label: 'Water',
							data: [<?php echo $data3; ?>],
							backgroundColor: 'transparent',
							borderColor:'rgba(99,132,255)',
							borderWidth: 1,
							pointBackgroundColor: 'rgba(0, 0, 0, 0)',
							pointBorderColor: 'rgba(0, 0, 0, 0)',
							pointBorderWidth: 1,
							yAxisID: 'bbl-y-axis'
						}]
					},
				
					options: {
						responsive: true,
                        maintainAspectRatio: false,
						scales: {
							xAxes: [{
								display: true,
							}],
							yAxes: [{
								id: 'bbl-y-axis',
								display: true,
								type: 'logarithmic',
								position: 'left',
								// ticks: {
								//     callback: function(label, index, labels) {
								//         return index;
								// 	},
								//  },
								scaleLabel: {
									display: true,
									labelString: 'Oil (bbl); Water (bbl)'
								}
							}, {
								id: 'mcf-y-axis',
								display: true,
								type: 'logarithmic',
								position: 'right',
								//ticks: label,
								// ticks: {
								// callback: function(label, index, labels) {
								//         return index;
								// 	},
								// }, 
								scaleLabel: {
									display: true,
									labelString: 'Gas (mcf)'
								}
							}]
							/* scales:{
								yAxes: [{
									beginAtZero: false, 
									display: true, 
									type: 'logarithmic',
								}], 
								xAxes: [{
									autoskip: true, 
									maxTicketsLimit: 20
								}]
							} */
						},
						tooltips:{mode: 'index'},
						legend:{display: true, position: 'top', labels: {fontColor: 'rgb(0,0,0)', fontSize: 16}},
						plugins: {
							zoom: {
								pan: {
								
									enabled: true,

									mode: 'x',
									// xScale0: {
									// 					max: 1e4
									// 				},
									
								},
								zoom: {			
									enabled: true,
									drag: false,
									mode: 'x',
								}
							}
						}
					}
					});
                    
                    // console.log(body);
                    // console.log(chart_size);
                    // // document.querySelector("#chart").style.height = chart_size;
                    // myChart.canvas.parentNode.style.height = chart_size + "px";
                    // myChart.canvas.parentNode.setAttribute('style','position:relative;width:100%;height:'+chartsize+'px;')
                    // chart_width = myChart.canvas.parentNode.style.width;
                    // myChart.resize(chart_width, chart_height)
				</script> 
				<script>
                    function getAbsoluteHeight(el) {
                    // Get the DOM Node if you pass in a string
                    el = (typeof el === 'string') ? document.querySelector(el) : el; 

                    var styles = window.getComputedStyle(el);
                    var margin = parseFloat(styles['marginTop']) +
                                parseFloat(styles['marginBottom']);

                    return Math.ceil(el.offsetHeight + margin);
                    }
                    // var body = document.querySelector("body").offsetHeight;
                    // var nav = document.querySelector("body > nav").offsetHeight;
                    // var subnav = document.querySelector("#tabs").offsetHeight;
                    // var table_header = document.querySelector("#ddrTable").offsetHeight;
                    // var dt_scroller_height = body - nav - subnav - table_header - 5;
                    // var chart_size = body - nav - nav - subnav - 96;
                    // chart_size = document.querySelector("#object-div").offsetHeight;
                    let bodyH = getAbsoluteHeight("body");
                    let navH = getAbsoluteHeight("body > nav");
                    let subnavH = getAbsoluteHeight("#tabs");
                    let chart_sizeH = bodyH - navH - subnavH;
                    console.log(chart_sizeH);
                    // col-5 m-3 p-3 shadow-lg carded-body bg-white
                    $(document).ready(function() {
                                    tabMove();
                                    
                                    // tabResize();
                    });
                    window.addEventListener("resize", tabMove);
                    function tabMove(){
                        var pillgroup = document.querySelector("#pills-vert").offsetWidth ;
                        
                        document.querySelector("#object-div").setAttribute('style', 'left:' + pillgroup + 'px; position: relative;');
                        document.querySelector("#leftside").setAttribute('style', 'right:' + pillgroup / 2 + 'px; position: relative;');
                        var body = document.querySelector("body").offsetHeight;
                    var nav = document.querySelector("body > nav").offsetHeight;
                    var subnav = document.querySelector("#tabs").offsetHeight;
                    var table_header = document.querySelector("#ddrTable").offsetHeight;
                    var dt_scroller_height = body - nav - subnav - table_header - 5;
                    var chart_size = body - nav - subnav - 96;
                    document.querySelector("#mapid").setAttribute('style','position:relative;width:100%;height:'+chart_size+'px;')
                    document.querySelector("ul.justify-content-start.ml-auto.nav.p-0").setAttribute('style', 'width:' + document.querySelector("#myTab").offsetLeft + 'px; position: relative;'); 
                    }
                    // document.addEventListener('DOMContentLoaded', function() {})
                        document.querySelector("#mapid").setAttribute('style','position:relative;width:100%;height:'+chart_sizeH+'px;')
                    
					var mymap = L.map('mapid').setView([<?php echo $ytile; ?>,<?php echo $xtile; ?>], 13<?php //echo $zoom; ?>);
                    accessToken = 'pk.eyJ1IjoiaHlkcm9jYXJib24iLCJhIjoiY2thYThrdjZnMGxieDJxbjV0ZW9jZTJ0bSJ9.8kj2dNLDSlNU0IMGoTRZ4g'; 
                    // styleURL = 'hydrocarbon/cktepchad12lb17l00dbrgz6b' // This is the Standard Oil style map 
                    styleURL = 'hydrocarbon/cky3hmdxx2e5o14o56xogaa8i' // This is the Satellite Streets style map
                    testX = "<?php echo $ytile; ?>"
                    testY = "<?php echo $xtile; ?>"
                    console.log(`xLon: ${testX} \n yLat: ${testY}`)
                    // console.log(`https://api.mapbox.com/styles/v1/${styleURL}/tiles/13/${testX}/${testY}?access_token=${accessToken}`);
                    // https://api.mapbox.com/styles/v1/hydrocarbon/cktepchad12lb17l00dbrgz6b?access_token=pk.eyJ1IjoiaHlkcm9jYXJib24iLCJhIjoiY2thYThrdjZnMGxieDJxbjV0ZW9jZTJ0bSJ9.8kj2dNLDSlNU0IMGoTRZ4g
					// L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
					// 	attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
					// 	maxZoom: 18,
					// 	id: 'mapbox/streets-v11',
					// 	tileSize: 512,
					// 	zoomOffset: -1,
					// 	accessToken: accessToken
					// }).addTo(mymap);
                    //https://api.mapbox.com/styles/v1/hydrocarbon/cktepchad12lb17l00dbrgz6b.html?fresh=true&title=view&access_token=
                    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
						attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
						maxZoom: 18,
						id: styleURL,
						tileSize: 512,
						zoomOffset: -1,
						accessToken: accessToken
					}).addTo(mymap);
                    var littleMap = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=' + accessToken, {
                            zoomLevelOffset: -6,
                            id: styleURL,
                            attribution: '© <a href="https://www.mapbox.com/feedback/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                    });
                    var miniMap = new L.Control.MiniMap(littleMap).addTo(mymap);
					var circle = L.circle([<?php echo $ytile; ?>,<?php echo $xtile; ?>], {
						color: 'red',
						fillColor: '#f03',
						fillOpacity: 0.5,
						radius: 500
					}).addTo(mymap);
                
				</script>
			<!-- </div> -->
            <div class="tab-pane fade" id="vitals" role="tabpanel" aria-labelledby="vitals-tab" style="position: relative; z-index: 940;"> 
				<div class="carded bg-light">
                    
                    <div class="row justify-content-center">
                        <div class="col-6 m-3">
                            <div class="carded-header" style="padding: 0rem 0rem!important; background-color:transparent;">
                                <ul class="nav nav-tabs" >
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#ftp">Tubing Pressure</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#fcp">Casing Pressure</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sitp">SI Tubing Pressure</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sicp">SI Casing Pressure</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pu">Pumping Unit</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#fl">Fluid Level</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#chlr">Chlorides</a></li>
                                </ul>
                            </div>
                            <div class="p-3 shadow-lg carded-body bg-white">
                                <div class="tab-content">
                                    <div id="ftp" class="tab-pane fade in show active">
                                        <h3 class="carded-title">Flowing Tubing Pressure</h3>
                                        <div class="chart-container">
                                            <canvas id="ftp-chart" style="width: 100%; height: 50vh;"></canvas> 
                                        </div>
                                    </div>
                                    <div id="fcp" class="tab-pane fade">
                                        <h3 class="carded-title">Flowing Casing Pressure</h3>
                                        <div class="chart-container">
                                            <canvas id="fcp-chart" style="width: 100%; height: 50vh;"></canvas> 
                                        </div>
                                    </div>
                                    <div id="sitp" class="tab-pane fade">
                                        <h3 class="carded-title">SI Tubing Pressure</h3>
                                        <div class="chart-container">
                                            <canvas id="sitp-chart" style="width: 100%; height: 50vh;"></canvas> 
                                        </div>
                                    </div>
                                    <div id="sicp" class="tab-pane fade">
                                        <h3 class="carded-title">SI Casing Pressure</h3>
                                        <div class="chart-container">
                                            <canvas id="sicp-chart" style="width: 100%; height: 50vh;"></canvas> 
                                        </div>
                                    </div>
                                    <div id="pu" class="tab-pane fade">
                                        <h3 class="carded-title">Pumping Unit</h3>
                                        <div class="chart-container">
                                            <canvas id="pu-chart" style="width: 100%; height: 50vh;"></canvas> 
                                        </div>
                                    </div>
                                    <div id="fl" class="tab-pane fade">
                                        <h3 class="carded-title">Fluid Level</h3>
                                        <div class="chart-container">
                                            <canvas id="fl-chart" style="width: 100%; height: 50vh;"></canvas> 
                                        </div>
                                    </div>
                                    <div id="chlr" class="tab-pane fade">
                                        <h3 class="carded-title">Chlorides</h3>
                                        <div class="chart-container">
                                            <canvas id="chlr-chart" style="width: 100%; height: 50vh;"></canvas> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-5 m-3">
                            <div class="carded-header" style="padding: 0rem 0rem!important; background-color:transparent;">
                            
                                <ul class="nav nav-tabs">
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#last">Last Update</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sihist">Shut In History</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pmhist">Preventative Maintenance History</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pjhist">Pull Job History</a></li>
                                </ul>
                            </div>
                            <div class="p-3 shadow-lg carded-body bg-white">
                                <div class="tab-content">
                                    <div id="last" class="tab-pane fade in show active">
                                        <div class="row justify-content-center ">
                                            <h3 class="carded-title"><strong>Last Updated Well Vitals</strong></h5>
                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Vital Statistic:</p>
                                            </div>
                                            <div class="col">
                                                <p>&nbsp;</p>
                                            </div>
                                            <div class="col">
                                                <p>Last Updated:</p>
                                            </div>

                                            
                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Flowing Tubing Pressure:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $ftpLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $ftpLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Flowing Casing Pressure:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $fcpLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $fcpLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>SI Tubing Pressure:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $sitpLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $sitpLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>SI Casing Pressure:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $sicpLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $sicpLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Fluid Level:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $flLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $flLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Chlorides:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $chlrLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $chlrLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Type of Chemical Treatment:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $ctLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $ctLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Reason for Last Pull Job:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $rpjLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $rpjLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>General Reason for SI:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $rsiLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $rsiLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Comments on SI:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $csiLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $csiLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Primary PM:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $pmpLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $pmpLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Primary PM Amount:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $pmpaLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $pmpaLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Secondary PM:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $pmsLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $pmsLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Secondary PM Amount:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $pmsaLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $pmsaLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Pumping Unit Speed:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $pusLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $pusLastDate; ?></p>
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col">
                                                <p>Pumping Unit Stroke Length:</p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $puslLast; ?></p>
                                            </div>
                                            <div class="col">
                                                <p><?php echo $puslLastDate; ?></p>
                                            </div>
                                            <div class="w-100"></div>

                                            
                                        </div>
                                    </div>
                                    <div id="sihist" class="row justify-content-center tab-pane fade">
                                        <h3 class="carded-title">SI History</h3>
                                        <table id='siTable' class='table bg-white table-sm smol'>
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>SI Tubing Pressure</th>
                                                    <th>SI Casing Pressure</th>
                                                    <th>General Reason for SI</th>
                                                    <th>Comments on SI</th>    
                                                </tr>
                                            </thead>                                       
                                        </table>
                                    </div>
                                    <div id="pmhist" class="row justify-content-center tab-pane fade">
                                        <h3 class="carded-title">Preventative Maintenance History</h3>
                                        <table id='pmTable' class='table bg-white table-sm smol'>
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>P. PM</th>
                                                    <th>P. PM Amount</th>
                                                    <th>S. PM</th>
                                                    <th>S. PM Amount</th>
                                                </tr>
                                            </thead>
                                            
                                        </table>
                                    </div>
                                    <div id="pjhist" class="row justify-content-center tab-pane fade">
                                        <h3 class="carded-title">Pull Job History</h3>
                                        <table id='pjTable' class='table bg-white table-sm smol'>
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Reason for Last Pull Job</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>    
                            </div>
                        </div>
					</div>
					<div class="m-3 p-3 shadow-lg carded-body bg-white">
                        <h3 class="carded-title">Full Vitals History</h3>
						<table id='vitalsTable' class='table bg-white table-sm smol'>
							<thead>
									<th>Date</th>
									<th>FTP</th>
									<th>FCP</th>
									<th>SITP</th>
									<th>SICP</th>
									<th>FL</th>
									<th>Chlorides</th>
									<th>Chem. Treat.</th>
									<th>Reason for Last Pull Job</th>
                                    <th>General Reason for SI</th>
                                    <th>Comments on SI</th>
                                    <th>P. PM</th>
                                   
                                    <th>S. PM</th>
                                   
                                    <th>PU Speed</th>
                                    <th>PU SL</th>
                                    <th>PU On/Off</th>
									
							</thead>
							
						</table>
					</div>
                    
				</div>
		</div>
</main>
<script>
    var pu_ctx = document.getElementById("pu-chart").getContext('2d');
    var pu_chart = new Chart(pu_ctx, {
    type: 'line',
    data: {
        labels: [<?php echo $pusDate; ?>],
        datasets: 
        [{
            label: 'Pumping Unit Speed',
            data: [<?php echo $pusData; ?>],
            backgroundColor: 'transparent',
            //backgroundColor: 'rgba(255,99,132)',
            borderColor:'rgba(132,255,99)',
            //borderColor: 'transparent',
            borderWidth: 1,
            pointBackgroundColor: 'rgba(0, 0, 0, 0)',
            pointBorderColor: 'rgba(0, 0, 0, 0)',
            pointBorderWidth: 1,
            //steppedLine = 'before'
            //steppedLine: true,
            yAxisID: 'speed-y-axis'
        },
        {
            label: 'Pumping Unit Stroke Length',
            data: [<?php echo $puslData; ?>],
            backgroundColor: 'transparent',
            borderColor:'rgba(255,99,132)',
            borderWidth: 1,
            pointBackgroundColor: 'rgba(0, 0, 0, 0)',
            pointBorderColor: 'rgba(0, 0, 0, 0)',
            pointBorderWidth: 1,
            yAxisID: 'length-y-axis'	
        },
        // {
        //     label: 'Water',
        //     data: [<?php //echo $data3; ?>],
        //     backgroundColor: 'transparent',
        //     borderColor:'rgba(99,132,255)',
        //     borderWidth: 1,
        //     pointBackgroundColor: 'rgba(0, 0, 0, 0)',
        //     pointBorderColor: 'rgba(0, 0, 0, 0)',
        //     pointBorderWidth: 1,
        //     yAxisID: 'bbl-y-axis'
        // }
        ]
    },

    options: {
        responsive: true,
        scales: {
            xAxes: [{
                display: true,
            }],
            yAxes: [{
                id: 'speed-y-axis',
                display: true,
                // type: 'logarithmic',
                position: 'left',
                // ticks: {
                //     callback: function(label, index, labels) {
                //         return index;
                // 	},
                //  },
                scaleLabel: {
                    display: true,
                    labelString: 'Speed (stroke/min)'
                }
            }, {
                id: 'length-y-axis',
                display: true,
                type: 'logarithmic',
                position: 'right',
                //ticks: label,
                // ticks: {
                // callback: function(label, index, labels) {
                //         return index;
                // 	},
                // }, 
                scaleLabel: {
                    display: true,
                    labelString: 'Stroke Length (ft)'
                }
            }]
            /* scales:{
                yAxes: [{
                    beginAtZero: false, 
                    display: true, 
                    type: 'logarithmic',
                }], 
                xAxes: [{
                    autoskip: true, 
                    maxTicketsLimit: 20
                }]
            } */
        },
        tooltips:{mode: 'index'},
        legend:{display: true, position: 'top', labels: {fontColor: 'rgb(0,0,0)', fontSize: 16}},
        plugins: {
            zoom: {
                pan: {
                
                    enabled: true,

                    mode: 'x',
                    // xScale0: {
                    // 					max: 1e4
                    // 				},
                    
                },
                zoom: {			
                    enabled: true,
                    drag: false,
                    mode: 'x',
                }
            }
        }
    }
    });
    

    var fcp_ctx = document.getElementById('fcp-chart').getContext('2d');
    var fcp_chart = new Chart(fcp_ctx, {
    type: 'line',
    data: {
        labels: [<?php echo $fcpDate; ?>],
        datasets: 
        [{
            label: 'Flowing Casing Pressure',
            data: [<?php echo $fcpData; ?>],
            backgroundColor: 'transparent',
            //backgroundColor: 'rgba(255,99,132)',
            borderColor:'rgba(132,255,99)',
            //borderColor: 'transparent',
            borderWidth: 1,
            pointBackgroundColor: 'rgba(0, 0, 0, 0)',
            pointBorderColor: 'rgba(0, 0, 0, 0)',
            pointBorderWidth: 1,
            //steppedLine = 'before'
            //steppedLine: true,
            yAxisID: 'bbl-y-axis'
        },
    ]
    },

    options: {
        responsive: true,
        scales: {
            xAxes: [{
                display: true,
            }],
            yAxes: [{
                id: 'bbl-y-axis',
                display: true,
                // type: 'logarithmic',
                position: 'left',
                scaleLabel: {
                    display: true,
                    labelString: 'Pressure (psi)'
                }
            }]
        },
        tooltips:{mode: 'index'},
        legend:{display: true, position: 'top', labels: {fontColor: 'rgb(0,0,0)', fontSize: 16}},
        plugins: {
            zoom: {
                pan: {
                
                    enabled: true,

                    mode: 'x',
                    
                },
                zoom: {			
                    enabled: true,
                    drag: false,
                    mode: 'x',
                }
            }
        }
    }
    });
    var sitp_ctx = document.getElementById('sitp-chart').getContext('2d');
    var sitp_chart = new Chart(sitp_ctx, {
    type: 'line',
    data: {
        labels: [<?php echo $sitpDate; ?>],
        datasets: 
        [{
            label: 'SI Tubing Pressure',
            data: [<?php echo $sitpData; ?>],
            backgroundColor: 'transparent',
            //backgroundColor: 'rgba(255,99,132)',
            borderColor:'rgba(132,255,99)',
            //borderColor: 'transparent',
            borderWidth: 1,
            pointBackgroundColor: 'rgba(0, 0, 0, 0)',
            pointBorderColor: 'rgba(0, 0, 0, 0)',
            pointBorderWidth: 1,
            //steppedLine = 'before'
            //steppedLine: true,
            yAxisID: 'bbl-y-axis'
        },
    ]
    },

    options: {
        responsive: true,
        scales: {
            xAxes: [{
                display: true,
            }],
            yAxes: [{
                id: 'bbl-y-axis',
                display: true,
                // type: 'logarithmic',
                position: 'left',
                scaleLabel: {
                    display: true,
                    labelString: 'Pressure (psi)'
                }
            }]
        },
        tooltips:{mode: 'index'},
        legend:{display: true, position: 'top', labels: {fontColor: 'rgb(0,0,0)', fontSize: 16}},
        plugins: {
            zoom: {
                pan: {
                
                    enabled: true,

                    mode: 'x',
                    
                },
                zoom: {			
                    enabled: true,
                    drag: false,
                    mode: 'x',
                }
            }
        }
    }
    });
    var sicp_ctx = document.getElementById('sicp-chart').getContext('2d');
    var sicp_chart = new Chart(sicp_ctx, {
    type: 'line',
    data: {
        labels: [<?php echo $sicpDate; ?>],
        datasets: 
        [{
            label: 'SI Casing Pressure',
            data: [<?php echo $sicpData; ?>],
            backgroundColor: 'transparent',
            //backgroundColor: 'rgba(255,99,132)',
            borderColor:'rgba(132,255,99)',
            //borderColor: 'transparent',
            borderWidth: 1,
            pointBackgroundColor: 'rgba(0, 0, 0, 0)',
            pointBorderColor: 'rgba(0, 0, 0, 0)',
            pointBorderWidth: 1,
            //steppedLine = 'before'
            //steppedLine: true,
            yAxisID: 'bbl-y-axis'
        },
    ]
    },

    options: {
        responsive: true,
        scales: {
            xAxes: [{
                display: true,
            }],
            yAxes: [{
                id: 'bbl-y-axis',
                display: true,
                // type: 'logarithmic',
                position: 'left',
                scaleLabel: {
                    display: true,
                    labelString: 'Pressure (psi)'
                }
            }]
        },
        tooltips:{mode: 'index'},
        legend:{display: true, position: 'top', labels: {fontColor: 'rgb(0,0,0)', fontSize: 16}},
        plugins: {
            zoom: {
                pan: {
                
                    enabled: true,

                    mode: 'x',
                    
                },
                zoom: {			
                    enabled: true,
                    drag: false,
                    mode: 'x',
                }
            }
        }
    }
    });
    var fl_ctx = document.getElementById('fl-chart').getContext('2d');
    var fl_chart = new Chart(fl_ctx, {
    type: 'line',
    data: {
        labels: [<?php echo $flDate; ?>],
        datasets: 
        [{
            label: 'Fluid Level',
            data: [<?php echo $flData; ?>],
            backgroundColor: 'transparent',
            //backgroundColor: 'rgba(255,99,132)',
            borderColor:'rgba(132,255,99)',
            //borderColor: 'transparent',
            borderWidth: 1,
            pointBackgroundColor: 'rgba(0, 0, 0, 0)',
            pointBorderColor: 'rgba(0, 0, 0, 0)',
            pointBorderWidth: 1,
            //steppedLine = 'before'
            //steppedLine: true,
            yAxisID: 'bbl-y-axis'
        },
    ]
    },

    options: {
        responsive: true,
        scales: {
            xAxes: [{
                display: true,
            }],
            yAxes: [{
                id: 'bbl-y-axis',
                display: true,
                // type: 'logarithmic',
                position: 'left',
                scaleLabel: {
                    display: true,
                    labelString: 'Height (ft)'
                }
            }]
        },
        tooltips:{mode: 'index'},
        legend:{display: true, position: 'top', labels: {fontColor: 'rgb(0,0,0)', fontSize: 16}},
        plugins: {
            zoom: {
                pan: {
                
                    enabled: true,

                    mode: 'x',
                    
                },
                zoom: {			
                    enabled: true,
                    drag: false,
                    mode: 'x',
                }
            }
        }
    }
    });
    var chlr_ctx = document.getElementById('chlr-chart').getContext('2d');
    var chlr_chart = new Chart(chlr_ctx, {
    type: 'line',
    data: {
        labels: [<?php echo $chlrDate; ?>],
        datasets: 
        [{
            label: 'Chlorides',
            data: [<?php echo $chlrData; ?>],
            backgroundColor: 'transparent',
            //backgroundColor: 'rgba(255,99,132)',
            borderColor:'rgba(132,255,99)',
            //borderColor: 'transparent',
            borderWidth: 1,
            pointBackgroundColor: 'rgba(0, 0, 0, 0)',
            pointBorderColor: 'rgba(0, 0, 0, 0)',
            pointBorderWidth: 1,
            //steppedLine = 'before'
            //steppedLine: true,
            yAxisID: 'bbl-y-axis'
        },
    ]
    },

    options: {
        responsive: true,
        scales: {
            xAxes: [{
                display: true,
            }],
            yAxes: [{
                id: 'bbl-y-axis',
                display: true,
                // type: 'logarithmic',
                position: 'left',
                scaleLabel: {
                    display: true,
                    labelString: 'Chlorides (ppm)'
                }
            }]
        },
        tooltips:{mode: 'index'},
        legend:{display: true, position: 'top', labels: {fontColor: 'rgb(0,0,0)', fontSize: 16}},
        plugins: {
            zoom: {
                pan: {
                
                    enabled: true,

                    mode: 'x',
                    
                },
                zoom: {			
                    enabled: true,
                    drag: false,
                    mode: 'x',
                }
            }
        }
    }
    });
    var ftp_ctx = document.getElementById('ftp-chart').getContext('2d');
    var ftp_chart = new Chart(ftp_ctx, {
    type: 'line',
    data: {
        labels: [<?php echo $ftpDate; ?>],
        datasets: 
        [{
            label: 'Flowing Tubing Pressure',
            data: [<?php echo $ftpData; ?>],
            backgroundColor: 'transparent',
            //backgroundColor: 'rgba(255,99,132)',
            borderColor:'rgba(132,255,99)',
            //borderColor: 'transparent',
            borderWidth: 1,
            pointBackgroundColor: 'rgba(0, 0, 0, 0)',
            pointBorderColor: 'rgba(0, 0, 0, 0)',
            pointBorderWidth: 1,
            //steppedLine = 'before'
            //steppedLine: true,
            yAxisID: 'bbl-y-axis'
        },
    ]
    },

    options: {
        responsive: true,
        scales: {
            xAxes: [{
                display: true,
            }],
            yAxes: [{
                id: 'bbl-y-axis',
                display: true,
                // type: 'logarithmic',
                position: 'left',
                scaleLabel: {
                    display: true,
                    labelString: 'Pressure (psi)'
                }
            }]
        },
        tooltips:{mode: 'index'},
        legend:{display: true, position: 'top', labels: {fontColor: 'rgb(0,0,0)', fontSize: 16}},
        plugins: {
            zoom: {
                pan: {
                
                    enabled: true,

                    mode: 'x',
                    
                },
                zoom: {			
                    enabled: true,
                    drag: false,
                    mode: 'x',
                }
            }
        }
    }
    });
	
</script> 

</div>


<!-- Floating Legend -->
<?php 
include 'modals/well_entry_modal.php'; 
include 'modals/ddr_edit_modal.php';
include 'include/floating_action_button.php';

if(isset($_REQUEST['testing'])){
    include 'modals/ddr_add_modal.php'; 
}
else{
    include 'modals/ddr_add_modal.php'; 
}

include 'modals/dsr_add_modal.php';
include 'include/ddr_datepicker.php';
include 'modals/file_modal.php';
?>
<?php if(isset($_REQUEST["testing"])) { ?>
   
    <script>
    // $('#drn').trumbowyg({
    //     btns: [
    //     ['viewHTML'],
    //     ['undo', 'redo'], // Only supported in Blink browsers
    //     ['formatting'],
    //     ['strong', 'em', 'del'],
    //     ['superscript', 'subscript'],
    //     ['foreColor', 'backColor'],
    //     // ['link'],
    //     //['insertImage'],
    //     ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
    //     //['unorderedList', 'orderedList'],
    //     //['horizontalRule'],
    //     ['removeformat'],
    //     ['fullscreen']
    //     ],
    //     removeformatPasted: true
    // });
    </script>

        <?php } ?>
<!-- <script type="text/javascript" src="WSB/dashboard/bootstrap.min.js.download"></script> -->

<!-- Icons -->
<!-- <script type="text/javascript" src="../WSB/dashboard/feather.min.js.download"></script> -->
<!-- Floating Legend -->


</body>
<div class="toggle-btn"></div>
<?php 

?>


          <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
          <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
          
          <script src="/assets/js/bottom_scripts.js?v1.0.0.1"></script>
          <!-- <script src="js/fslightbox.js"></script> -->

<script>
    // feather.replace()
    const cumprod = document.getElementById('cumulativeproduction');
    tippy('.r-tooltip', { 
          content: cumprod.innerHTML,
          allowHTML: true,
          placement: 'right',
          arrow: false 
        });
</script>   
<script src="assets/js/lightbox2-2.11.3/src/js/lightbox.js"></script>
<!-- <script type="text/javascript" src="WSB/stylesheet/offcanvas.js.download"></script> -->


	</html>
