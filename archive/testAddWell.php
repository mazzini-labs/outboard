<?php
include_once("include/common.php");

if (getPostValue('addwell')) {
	$wellID = getPostValue('WID');      
	$wellCN = getPostValue('WCN');      
	$state  = getPostValue('state');     
	$county = getPostValue('county');     
	$block  = getPostValue('block');    
	$lease  = getPostValue('lease');    
	$wellNo = getPostValue('WNo');     
	$api    = getPostValue('api');  
	$field  = getPostValue('field');    
	$zone   = getPostValue('zone');   
	$md     = getPostValue('md');   
	$td     = getPostValue('td');   
	$tvd    = getPostValue('tvd');   
	$hv      = getPostValue('hv');   
	$status  = getPostValue('status');   
	$rr       = getPostValue('rr');   
	$perfs      = getPostValue('perfs');   
	$completion = getPostValue('completion');   
	$qo             = getPostValue('qo');
	$qg            = getPostValue('qg');  
	$qw           = getPostValue('qw');  
	$oilCumProd   = getPostValue('oilcp'); 
	$gasCumProd   = getPostValue('gascp'); 
	$waterCumProd = getPostValue('watercp'); 
	$pt           = getPostValue('pt'); 
	$pc           = getPostValue('pc'); 
	$wi            = getPostValue('wi');
	$nri           = getPostValue('nri');
	$op            = getPostValue('op');
	$bhpi           = getPostValue('bhpi');
	$surfaceEquip    = getPostValue('se');
	$comments     = getPostValue('comments');
	$gasgather     = getPostValue('gasgather');
	$loe           = getPostValue('loe');
	$fileShareLink = getPostValue('fSL');
	$connect = new PDO('mysql:host=localhost;dbname=wells', 'root', 'devonian');
	$query = "
	 INSERT INTO wellstatusboard 
	 (wellID, wellCommonName, State, County, Block, Lease,
	 'Well No', API, Field, Zone, MD, TD, TVD, H/V, Status, RR, 'Perfs (ft)',
	 Completion, 'qo (bbl/d)', 'qg (mcf/d)', 'qw (bbl/d)', 'Qo (bbl)',  
	 'Qg (mcf)', 'Qw (bbl)', 'Pt (psi)', 'Pc (psi)', WI, NRI, OP, 'BHPi (psi)',
	 'Surface Equipment', Comments, 'Gas Gathering', 'LOEs ($/mo.)', fileShareLink
	 ) 
	 VALUES (:wellID, :wellCN, :state, :county, :block, :lease,
	 :wellNo, :api, :field, :zone, :md, :td, :tvd, :hv, :status, :rr, :perfs,
	 :completion, :qo, :qg, :qw, :oilCumProd,  
	 :gasCumProd, :waterCumProd, :pt, :pc, :wi, :nri, :op, :bhpi,
	 :surfaceEquip, :comments, :gasgather, :loe, :fileShareLink
	 )
	 ";
	 $statement = $connect->prepare($query);
	 $statement->execute(
	  array(
		  ':wellID' => $wellID,      
		  ':wellCN' => $wellCN,      
		  ':state' => $state,     
		  ':county' => $country,     
		  ':block' => $block,    
		  ':lease' => $lease,    
		  ':wellNo' => $wellNo,     
		  ':api' => $api,  
		  ':field' => $field,    
		  ':zone' => $zone,   
		  ':md' => $md,   
		  ':td' => $td,   
		  ':tvd' => $tvd,   
		  ':hv' => $hv,    
		  ':status' => $status,    
		  ':rr' => $rr,     
		  ':perfs' => $perfs,       
		  ':completion' => $completion, 
		  ':qo' => $qo,  
		  ':qg' => $qg,   
		  ':qw' => $qw,  
		  ':oilCumProd' => $oilCumProd, 
		  ':gasCumProd' => $gasCumProd, 
		  ':waterCumProd' => $waterCumProd, 
		  ':pt' => $pt, 
		  ':pc' => $pc, 
		  ':wi' => $wi, 
		  ':nri' => $nri,  
		  ':op' => $op,  
		  ':bhpi' => $bhpi,   
		  ':surfaceEquip' => $surfaceEquip,    
		  ':comments' => $comments, 
		  ':gasgather' => $gasgather,  
		  ':loe' => $loe,  
		  ':fileShareLink' => $fileShareLink 

	  )
	 ) or die(mysql_error());
}
?>
<!doctype html>
<html>
<head>
			<!-- Bootstrap core CSS -->
    <link href="stylesheet/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->

	<link href="stylesheet/offcanvas.css" rel="stylesheet">

<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
					<?php 
 				 if ($message != "") { echo "<br>$message<br><hr>"; }
 				 $mainscreen = true;     // Other screens change this
				 if ($addwell = getPostValue('addwell'))      { include("addwell_add.php");   }
				 ?>
						
				<?php
				// Show correct buttons depending on the current screen
 				 if (! $mainscreen) { echo "<hr>"; } else { echo "<br>"; }
 				 if (! $addwell) {
   				 echo "<INPUT class='navbar-btn' TYPE=submit NAME=addwell VALUE=\"Add A User\">";
 				 }
				 ?>
				<span class="focus-input100"></span>


</body>
		<script src="WSB/dashboard/jquery-3.2.1.slim.min.js.download" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="WSB/bootstrap-4.0.0/assets/js/vendor/jquery-3.2.1.slim.min.js"><\/script>')</script>
    <script src="WSB/dashboard/popper.min.js.download"></script>
    <script src="WSB/dashboard/bootstrap.min.js.download"></script>

    <!-- Icons -->
    <script src="WSB/dashboard/feather.min.js.download"></script>
    <script>
      feather.replace()
    </script>   
    <script>window.jQuery || document.write('<script src="WSB/bootstrap-4.0.0/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="WSB/stylesheet/holder.min.js.download"></script>
    <script src="WSB/stylesheet/offcanvas.js.download"></script>

</html>