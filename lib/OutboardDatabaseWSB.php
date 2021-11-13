<?php

/**
 * OutboardDatabase.php
 *
 * Controls all database access for the OutBoard.
 *
 * 2005-02-15	Richard F. Feuerriegel	(richardf@aces.edu)
 *	- Initial creation
 *
 **/

require_once("../lib/OutboardConfig.php");

Class OutboardDatabase extends OutboardConfig {

var $dbh = null;           // Database handle
var $hostIP = null;        // IP address of the user's computer
var $operatingUser = null; // The username of the person using the OutBoard
var $readonly = null;      // Boolean. True if the board is in read-only mode.
var $superadmin = null;	   // Boolean. True if the user is an OutBoard superadministrator.
var $admin = null;         // Boolean. True if the user is an OutBoard administrator.
var $eligible = null;	   // Boolean. True if the user is eligible for PTO.
var $hr = null;			   // Boolean. True if the user is apart of HR.
	
var $ap = null;      		// Boolean. True if the user is apart of Accounts Payable.  
var $acct1 = null;	   		// Boolean. True if the user is apart of Accounting Group 1.  
var $acct2 = null;          // Boolean. True if the user is apart of Accounting Group 2.  
var $eng1 = null;	   		// Boolean. True if the user is apart of Engineering Group 1.  
var $eng2 = null;      		// Boolean. True if the user is apart of Engineering Group 2.  
var $land = null;	   		// Boolean. True if the user is apart of Land.  
var $legal = null;     		// Boolean. True if the user is apart of Legal.  
var $geo = null;	   		// Boolean. True if the user is apart of Geology.  
var $adstaff = null;		// Boolean. True if the user is apart of Administrative Support Staff.  

var $apspr = null;      	// Boolean. True if the user is a supervisor of Accounts Payable.  
var $acct1spr = null;	   	// Boolean. True if the user is a supervisor of Accounting Group 1.  
var $acct2spr = null;       // Boolean. True if the user is a supervisor of Accounting Group 2.  
var $eng1spr = null;	   	// Boolean. True if the user is a supervisor of Engineering Group 1.  
var $eng2spr = null;      	// Boolean. True if the user is a supervisor of Engineering Group 2.  
var $landspr = null;	   	// Boolean. True if the user is a supervisor of Land.  
var $legalspr = null;     	// Boolean. True if the user is a supervisor of Legal.  
var $geospr = null;	   		// Boolean. True if the user is a supervisor of Geology.  
var $adstaffspr = null;		// Boolean. True if the user is a supervisor of Administrative Support Staff.  

var $session = null;        // The current session value used for authentication later
var $result = null;	        // The current query result handle


Function OutboardDatabase() {
  // Call the superclass constructor
  $this->OutboardConfig();
  
  if (! function_exists("mysql_pconnect")) {
	  trigger_error("The MySQL libraries are not installed.");
  }

  // Open the database connection
  $this->dbh = @mysql_pconnect($this->getConfig('dbhost'),
			      $this->getConfig('dbuser'),
			      $this->getConfig('dbpass'));
  if (! $this->dbh) {
    trigger_error("Unable to connect to the database server.");
  }
  if (! @mysql_select_db($this->getConfig('db'),$this->dbh)) {
    trigger_error("Unable to open the OutBoard database.");
  }
  $this->hostIP = $_SERVER['REMOTE_ADDR'];
  $this->setReadonly(false);
  $this->setSuperAdmin(false);
  $this->setAdmin(false);
  $this->setEligible(false);
  $this->setHR(false);
  $this->setAPspr(false);
  $this->setA1spr(false);
  $this->setA2spr(false);
  $this->setE1spr(false);
  $this->setE2spr(false);
  $this->setLandspr(false);
  $this->setLegalspr(false);
  $this->setGeospr(false);
  $this->setADstaffspr(false);
  $this->setAP(false);
  $this->setA1(false);
  $this->setA2(false);
  $this->setE1(false);
  $this->setE2(false);
  $this->setLand(false);
  $this->setLegal(false);
  $this->setGeo(false);
  $this->setADstaff(false);
  $this->autoLogoutIdlers();
}


Function getOperatingUser() { return $this->operatingUser; }
Function setOperatingUser($username) { $this->operatingUser = $username; }

Function isReadonly() { return $this->readonly; }
Function setReadonly($boolean) { $this->readonly = $boolean; }

Function isSuperAdmin() { return $this->superadmin; }
Function setSuperAdmin($boolean) { $this->superadmin = $boolean; }
	
Function isAdmin() { return $this->admin; }
Function setAdmin($boolean) { $this->admin = $boolean; }
	
Function isEligible() { return $this->eligible; }
Function setEligible($boolean) { $this->eligible = $boolean; }

Function isHR() { return $this->hr; }
Function setHR($boolean) { $this->hr = $boolean; }

Function isAPspr() { return $this->apspr; }
Function setAPspr($boolean) { $this->apspr = $boolean; }

Function isA1spr() { return $this->acct1spr; }
Function setA1spr($boolean) { $this->acct1spr = $boolean; }
	
Function isA2spr() { return $this->acct2spr; }
Function setA2spr($boolean) { $this->acct2spr = $boolean; }
	
Function isE1spr() { return $this->eng1spr; }
Function setE1spr($boolean) { $this->eng1spr = $boolean; }
	
Function isE2spr() { return $this->eng2spr; }
Function setE2spr($boolean) { $this->eng2spr = $boolean; }
	
Function isLandspr() { return $this->landspr; }
Function setLandspr($boolean) { $this->landspr = $boolean; }

Function isLegalspr() { return $this->legalspr; }
Function setLegalspr($boolean) { $this->legalspr = $boolean; }
	
Function isGeospr() { return $this->geospr; }
Function setGeospr($boolean) { $this->geospr = $boolean; }
	
Function isADstaffspr() { return $this->adstaffspr; }
Function setADstaffspr($boolean) { $this->adstaffspr = $boolean; }

Function isAP() { return $this->ap; }
Function setAP($boolean) { $this->ap = $boolean; }

Function isA1() { return $this->acct1; }
Function setA1($boolean) { $this->acct1 = $boolean; }
	
Function isA2() { return $this->acct2; }
Function setA2($boolean) { $this->acct2 = $boolean; }
	
Function isE1() { return $this->eng1; }
Function setE1($boolean) { $this->eng1 = $boolean; }
	
Function isE2() { return $this->eng2; }
Function setE2($boolean) { $this->eng2 = $boolean; }
	
Function isLand() { return $this->land; }
Function setLand($boolean) { $this->land = $boolean; }

Function isLegal() { return $this->legal; }
Function setLegal($boolean) { $this->legal = $boolean; }
	
Function isGeo() { return $this->geo; }
Function setGeo($boolean) { $this->geo = $boolean; }
	
Function isADstaff() { return $this->adstaff; }
Function setADstaff($boolean) { $this->adstaff = $boolean; }

	
Function isChangeable($userid) {
  $level  = $this->getConfig('allow_change');
  $opuser = $this->getOperatingUser();
  if     ($level == "all") { return true; }
  elseif ($level == "user_only"  && $userid == $opuser) { return true; }
  elseif ($level == "admin_only" && $this->isAdmin() )  { return true; }
  elseif ($level == "admin_only" && $this->isSuperAdmin() )  { return true; }
  elseif ($level == "user_admin" 
	  && ($this->isAdmin() || $userid == $opuser))  { return true; }
  else { return false; }
}


Function getSession($session_cookie) {
  $table = $this->getConfig('table');
  if ($session_cookie == "") { return null; }
  $stmt = "SELECT userid,name,options FROM $table WHERE session = '$session_cookie'";
  $this->_query($stmt);
  if ($this->numRows() != 1) {
    return null;
  } else {
    $row = $this->getRow();
    $this->setOperatingUser($row['userid']);
    $this->setReadonly(preg_match("/<READONLY>/",$row['options']));
	$this->setSuperAdmin(preg_match("/<SUPERADMIN>/",$row['options']));
    $this->setAdmin(preg_match("/<ADMIN>/",$row['options']));
	$this->setEligible(preg_match("/<ELIGIBLE>/",$row['options']));
	$this->setHR(preg_match("/<HR>/",$row['options']));
	$this->setAPspr(preg_match("/<AP-SPR>/",$row['options']));
	$this->setA1spr(preg_match("/<ACCT1-SPR>/",$row['options']));
    $this->setA2spr(preg_match("/<ACCT2-SPR>/",$row['options']));
	$this->setE1spr(preg_match("/<ENG1-SPR>/",$row['options']));
	$this->setE2spr(preg_match("/<ENG2-SPR>/",$row['options']));
	$this->setLandspr(preg_match("/<LAND-SPR>/",$row['options']));
    $this->setLegalspr(preg_match("/<LEGAL-SPR>/",$row['options']));
	$this->setGeospr(preg_match("/<GEO-SPR>/",$row['options']));
	$this->setADstaffspr(preg_match("/<ADSTAFF-SPR>/",$row['options']));
	$this->setAP(preg_match("/<AP>/",$row['options']));
	$this->setA1(preg_match("/<ACCT1>/",$row['options']));
    $this->setA2(preg_match("/<ACCT2>/",$row['options']));
	$this->setE1(preg_match("/<ENG1>/",$row['options']));
	$this->setE2(preg_match("/<ENG2>/",$row['options']));
	$this->setLand(preg_match("/<LAND>/",$row['options']));
    $this->setLegal(preg_match("/<LEGAL>/",$row['options']));
	$this->setGeo(preg_match("/<GEO>/",$row['options']));
	$this->setADstaff(preg_match("/<ADSTAFF>/",$row['options']));
    return $this->getOperatinguser();
  } 
}


Function setSession($session = "NONE") {
  $table = $this->getConfig('table');
  if (! $userid = $this->getOperatingUser()) { return false; }
  if ($session == "NONE") {
    mt_srand((double)microtime()*1000000); 
    $session = mt_rand(1,10000000) . uniqid(""); 
    $this->session = $session;
  }
  $stmt = "UPDATE $table SET session='$session' WHERE userid='$userid'";
  if ($this->_query($stmt)) {
    return $session;
  } else {
    return false;
  }
}


Function checkPassword($username,$password) {
  $table = $this->getConfig('table');
  $username = addslashes($username);
  $password = addslashes($password);
  $stmt = "SELECT userid FROM $table WHERE userid='$username' and password=password('$password')";
  if ($this->_query($stmt)) {
    if ($this->numRows() == 1) {
      $row = $this->getRow();
      $this->setOperatingUser($row['userid']);
      return $this->setSession(); 
    }
  }
  return false;
}


Function getLogStartDate() {
  $logtable = $this->getConfig('logtable');
  $stmt = "SELECT timestamp,"
	 ."date_format(timestamp, '%Y-%m-%d') as changedate "
	 ."FROM $logtable ORDER BY rowid ASC limit 1";
  if ($this->_query($stmt)) {
    $row = $this->getRow();
    return $row['changedate'];
  } else {
    return null;
  }
}

Function getLogEndDate() {
  $logtable = $this->getConfig('logtable');
  $stmt = "SELECT timestamp,"
	 ."date_format(timestamp, '%Y-%m-%d') as changedate "
	 ."FROM $logtable timestamp ORDER BY rowid DESC limit 1";
  if ($this->_query($stmt)) {
    $row = $this->getRow();
    return $row['changedate'];
  } else {
    return null;
  }
}


// Gets all the rows/data from the log table for a specific user 
// and data range. $start and $end are in the form 'yyyy-mm-dd'.
Function getLogData($userid,$start,$end) {
  $logtable = $this->getConfig('logtable');
  $stmt =
    "SELECT rowid,userid,back,remarks,name,timestamp,
            date_format(back, '%H:%i') as backtime,
            date_format(timestamp, '%Y-%m-%d') as changedate,
            date_format(timestamp, '%H:%i') as changetime,
            date_format(timestamp, '%d') as day,
            unix_timestamp(timestamp) as timeinseconds
     FROM $logtable
     WHERE timestamp >= '$start'
       AND timestamp <= '$end 23:59:59'
       AND userid = '$userid'
     ORDER BY timestamp
    ";
  if ($this->_query($stmt)) {
    return true;
  } else {
    return false;
  }
}

// Gets the log data and converts it into an array;
Function getLogDataArray($userid,$start,$end) {
  if ($this->getLogData($userid,$start,$end)) {
    if (! $this->numRows()) { return null; }
    $ld = Array();
    while($row = $this->getRow()) {
      $ld[] = $row;
    }
    return $ld;
  } else {
    return null;
  }
}


Function getNames() {
  $table = $this->getConfig('table');
  $stmt = "SELECT DISTINCT userid,name FROM $table "
         ."WHERE options is null or options NOT LIKE '%<READONLY>%' ORDER BY name";
  $this->_query($stmt);
  if (! $this->numRows()) { return null; }
  $userArray = Array();
  while($row = $this->getRow()) {
    $userArray[$row['userid']] = $row['name'];
  } 
  return $userArray;
}

Function getEligible() {
  $table = $this->getConfig('table');
  $stmt = "SELECT DISTINCT userid,name FROM $table "
         ."WHERE options LIKE '%<ELIGIBLE>%' ORDER BY name";
  $this->_query($stmt);
  if (! $this->numRows()) { return null; }
  $userArray = Array();
  while($row = $this->getRow()) {
    $userArray[$row['userid']] = $row['name'];
  } 
  return $userArray;
}

Function getInEligible() {
  $table = $this->getConfig('table');
  $stmt = "SELECT DISTINCT userid,name FROM $table "
         ."WHERE options NOT LIKE '%<ELIGIBLE>%' ORDER BY name";
  $this->_query($stmt);
  if (! $this->numRows()) { return null; }
  $userArray = Array();
  while($row = $this->getRow()) {
    $userArray[$row['userid']] = $row['name'];
  } 
  return $userArray;
}
Function getAP() {
  $table = $this->getConfig('table');
  $stmt = "SELECT DISTINCT userid,name FROM $table "
         ."WHERE options LIKE '%<AP>%' ORDER BY name";
  $this->_query($stmt);
  if (! $this->numRows()) { return null; }
  $userArray = Array();
  while($row = $this->getRow()) {
    $userArray[$row['userid']] = $row['name'];
  } 
  return $userArray;
}
Function getAG1() {
  $table = $this->getConfig('table');
  $stmt = "SELECT DISTINCT userid,name FROM $table "
         ."WHERE options LIKE '%<ACCT1>%' ORDER BY name";
  $this->_query($stmt);
  if (! $this->numRows()) { return null; }
  $userArray = Array();
  while($row = $this->getRow()) {
    $userArray[$row['userid']] = $row['name'];
  } 
  return $userArray;
}
Function getAG2() {
  $table = $this->getConfig('table');
  $stmt = "SELECT DISTINCT userid,name FROM $table "
         ."WHERE options LIKE '%<ACCT2>%' ORDER BY name";
  $this->_query($stmt);
  if (! $this->numRows()) { return null; }
  $userArray = Array();
  while($row = $this->getRow()) {
    $userArray[$row['userid']] = $row['name'];
  } 
  return $userArray;
}
Function getE1() {
  $table = $this->getConfig('table');
  $stmt = "SELECT DISTINCT userid,name FROM $table "
         ."WHERE options LIKE '%<ENG1>%' ORDER BY name";
  $this->_query($stmt);
  if (! $this->numRows()) { return null; }
  $userArray = Array();
  while($row = $this->getRow()) {
    $userArray[$row['userid']] = $row['name'];
  } 
  return $userArray;
}
Function getE2() {
  $table = $this->getConfig('table');
  $stmt = "SELECT DISTINCT userid,name FROM $table "
         ."WHERE options LIKE '%<ENG2>%' ORDER BY name";
  $this->_query($stmt);
  if (! $this->numRows()) { return null; }
  $userArray = Array();
  while($row = $this->getRow()) {
    $userArray[$row['userid']] = $row['name'];
  } 
  return $userArray;
}
Function getLand() {
  $table = $this->getConfig('table');
  $stmt = "SELECT DISTINCT userid,name FROM $table "
         ."WHERE options LIKE '%<LAND>%' ORDER BY name";
  $this->_query($stmt);
  if (! $this->numRows()) { return null; }
  $userArray = Array();
  while($row = $this->getRow()) {
    $userArray[$row['userid']] = $row['name'];
  } 
  return $userArray;
}
Function getLegal() {
  $table = $this->getConfig('table');
  $stmt = "SELECT DISTINCT userid,name FROM $table "
         ."WHERE options LIKE '%<LEGAL>%' ORDER BY name";
  $this->_query($stmt);
  if (! $this->numRows()) { return null; }
  $userArray = Array();
  while($row = $this->getRow()) {
    $userArray[$row['userid']] = $row['name'];
  } 
  return $userArray;
}
Function getGeo() {
  $table = $this->getConfig('table');
  $stmt = "SELECT DISTINCT userid,name FROM $table "
         ."WHERE options LIKE '%<GEO>%' ORDER BY name";
  $this->_query($stmt);
  if (! $this->numRows()) { return null; }
  $userArray = Array();
  while($row = $this->getRow()) {
    $userArray[$row['userid']] = $row['name'];
  } 
  return $userArray;
}
Function getADstaff() {
  $table = $this->getConfig('table');
  $stmt = "SELECT DISTINCT userid,name FROM $table "
         ."WHERE options LIKE '%<ADSTAFF>%' ORDER BY name";
  $this->_query($stmt);
  if (! $this->numRows()) { return null; }
  $userArray = Array();
  while($row = $this->getRow()) {
    $userArray[$row['userid']] = $row['name'];
  } 
  return $userArray;
}
	
	
	
// Gets all the rows/data from the main Outboard table
Function getData() {
  $table = $this->getConfig('table');
  $stmt = "select rowid, userid, name, options, unix_timestamp(back) as back, "
	  	 ."part_time, start_date, pto_eligible, hours,"
         ."remarks, last_change, date_format(timestamp, '%m/%d, %l:%i %p') as timestamp "
         ."from $table order by name";
  if ($this->_query($stmt)) {
    return true;
  } else {
    return false;
  }
}
	
Function getPTOData($group) {
  
  $table = $this->getConfig('ptotable');

 // $stmt = "SELECT * FROM pto_request order by rowid desc";

/*
	$stmt = "select
			  rowid,
			  userid,
			  date_format(start_time, '%m/%d, %h:%i %p') as start_time,
			  date_format(end_time, '%m/%d, %h:%i %p') as end_time,
			  name,
			  title,
			  options,
			  requested_pto
			from
			  pto_request
			order by
			   rowid  DESC";
*/
 	$stmt = "select
			  rowid,
			  userid,
			  date_format(start_time, '%m/%d, %h:%i %p') as start_time,
			  date_format(end_time, '%m/%d, %h:%i %p') as end_time,
			  name,
			  title,
			  options,
			  requested_pto
			from
			  pto_request
			where
			  $group
			order by
			   rowid  DESC";



  if ($this->_query($stmt)) {
    return true;
    //return mysql_query($stmt) or die(mysql_error());
  } else {
    return mysql_query($stmt) or die(mysql_error());
  }

}

// Moves the dots to Out after a specified idle time (in seconds).
Function autoLogoutIdlers() {
  $seconds = abs(floor($this->getConfig('max_idle_seconds')));
  if ($seconds > 0) {
    $table = $this->getConfig('table');
    $out = $this->getConfig('out');
    $stmt = "UPDATE $table "
	   ."SET back='$out',last_change='auto-logout,0.0.0.0' "
	   ."WHERE back != '$out' AND "
	   ."(unix_timestamp(now()) - unix_timestamp(timestamp)) > $seconds";
    $this->_query($stmt);
  }
}

// Gets the data on a single person
Function getDataByID($rowid) {
  $table = $this->getConfig('table');
  $rowid = addslashes($rowid);
  $stmt = "select rowid, userid, password, name, options, "
	      ."part_time, start_date, pto_eligible, hours,"
         ."remarks, last_change, date_format(timestamp, '%m/%d, %l:%i %p') as timestamp "
	     
         ."from $table where rowid = '$rowid'";
  if ($this->_query($stmt)) {
    return true;
  } else {
    return false;
  }
}

Function getPTOByID($rowid) {
  $table = $this->getConfig('ptotable');
  $rowid = addslashes($rowid);
	$stmt = "select * from $table where rowid = '$rowid'";
/*
  $stmt = "select rowid, userid, date_format(start_time, '%m/%d, %l:%i %p') as start_time,"
	  	."date_format(end_time, '%m/%d, %l:%i %p') as end_time, name, title, options, requested_pto"	     
         ."from $table where rowid = '$rowid'";
*/
  if ($this->_query($stmt)) {
    return true;
  } else {
    return false;
  }
}
Function getOutboardPTOByUID($userid) {
  $table = $this->getConfig('table');
  $userid = addslashes($userid);
  
 $stmt = "SELECT * FROM $table where userid = '$userid'";
 
  if ($this->_query($stmt)) {
    return true;
  } else {
    return false;
  }
}
	
Function isBoardMember($userid) {
  $table = $this->getConfig('table');
  $userid = addslashes($userid);
  $stmt = "select rowid from $table where userid = '$userid'";
  $this->_query($stmt);
  if ($this->numRows() == 1) {
    return true;
  } else {
    return false;
  }
}


Function setDotIn($userid) {
  return $this->_moveDot($userid,$this->getConfig('in')); 
}


Function setDotOut($userid) {
  return $this->_moveDot($userid,$this->getConfig('out')); 
}


Function setDotTime($userid,$hour) {
  $current = getdate();
  $return_datetime = mktime($hour,'00','00',$current['mon'],$current['mday'],$current['year']);
  $back = date('Y-m-d H:i:s',$return_datetime);
  return $this->_moveDot($userid,$back); 
}


Function _moveDot($userid,$back) {
  if ($this->isReadonly()) { return true; }
  if (! $this->isChangeable($userid)) { return true; }
  $table = $this->getConfig('table');
  $hostIP = $this->hostIP;
  $operatingUser = $this->operatingUser;
  $stmt = "update $table "
	 ."set back='$back',last_change='$operatingUser,$hostIP' "
	 ."where userid = '$userid'";
  if($this->_query($stmt)) {
    return $this->_log($userid);
  }
}


Function setRemarks($userid,$remarks) {
  if ($this->isReadonly()) { return true; }
  if (! $this->isChangeable($userid)) { return true; }
  $table = $this->getConfig('table');
  $hostIP = $this->hostIP;
  $operatingUser = $this->operatingUser;
  $remarks = trim($remarks);
  $stmt = "update $table "
	 ."set remarks='".addslashes($remarks)."',last_change='$operatingUser,$hostIP' "
	 ."where userid = '$userid'";
  if($this->_query($stmt)) {
    return $this->_log($userid);
  }
}


Function _log($userid) {
  $table = $this->getConfig('table');
  $logtable = $this->getConfig('logtable');
  $stmt = "select * from $table where userid = '$userid'";
  $this->_query($stmt); 
  $row = $this->getRow();
  $r_remarks = addslashes($row['remarks']);
  $r_userid = $row['userid'];
  $r_back = $row['back'];
  $r_name = $row['name'];
  $r_last_change = $row['last_change'];
  $stmt = "INSERT INTO $logtable (userid,back,remarks,name,last_change) "
         ."VALUES ('$r_userid','$r_back','$r_remarks','$r_name','$r_last_change')";
  return $this->_query($stmt);
}
/* //function for pto requests TEST
Function _pto($userid) {
  $table = $this->getConfig('table');
  $ptotable = $this->getConfig('ptotable');
  $stmt = "select * from $table where userid = '$userid'";
  $this->_query($stmt); 
  $row = $this->getRow();
  $r_remarks = addslashes($row['remarks']);
  $r_userid = $row['userid'];
  $r_start = $row['start_time'];
  $r_end = $row['end_time'];
  $r_pto = $row['requested_pto'];
  $r_name = $row['name'];
  $r_last_change = $row['last_change'];
  $stmt = "INSERT INTO $ptotable (userid,start_time,end_time,requested_pto,name,last_change) "
         ."VALUES ('$r_userid','$r_back','$r_remarks','$r_name','$r_last_change')";
  return $this->_query($stmt);
}
*/
// Edits an existing user if $rowid is set; adds otherwise.
Function saveUser($rowid,$name,$pass,$visible,$options,$start_date,$hours) {//$part_time,$start_date,$pto_eligible,$hours) {
  $table = $this->getConfig('table');
  $rowid = addslashes($rowid);
  $name = addslashes($name);
  $pass = addslashes($pass);
  $visible = addslashes($visible); // name
  $options = addslashes($options);
  $part_time = addslashes($part_time);
  $start_date = addslashes($start_date);
  $pto_eligible = addslashes($pto_eligible);
  $hours = addslashes($hours);
  if ($rowid) {
    $this->getDataByID($rowid);
    $row = $this->getRow();
    // Only update the password if it changed on the form.
    if ($row['password'] != $pass) {
      $password = "password('$pass')";
    } else {
      $password = "'$pass'";
    }
    $stmt = "UPDATE $table SET "
	   ."userid='$name',password=$password,"
	   ."name='$visible',options='$options',start_date='$start_date',hours='$hours' "
		//."name='$visible',options='$options',part_time='$part_time',start_date='$start_date',pto_eligible='$pto_eligible',hours='$hours' "
	   ."WHERE rowid='$rowid'";
  } else {
    //$stmt = "INSERT INTO $table (userid,password,name,options,part_time,start_date,pto_eligible,hours) "
	$stmt = "INSERT INTO $table (userid,password,name,options,start_date,hours) "
	   //."VALUES ('$name',password('$pass'),'$visible','$options','$part_time'.'$start_date','$pto_eligible','$hours')";
	  ."VALUES ('$name',password('$pass'),'$visible','$options','$start_date','$hours')";
  }
  return $this->_query($stmt);
}

Function updatePTOcal($rowid,$userid,$start_time,$end_time,$name,$options,$request) {//$part_time,$start_date,$pto_eligible,$hours) {
  $table = $this->getConfig('table');
  $ptotable = $this->getConfig('ptotable');
  $rowid = addslashes($rowid);
  $userid = addslashes($userid);
 
 
  $start_time = addslashes($start_time); 
  $end_time = addslashes($end_time);
	$in_time = date('H A',$end_time);
	$out_time = date('H A',$start_time);
  $name = addslashes($name);
  $options = addslashes($options);
  $request = addslashes($request);
  $updatetitle = $name;
	
	
	
	
  if ($rowid) {
    $this->getPTOByID($rowid);
    $row = $this->getRow();
	 if (preg_match("/<PD>/",$row['options'])){
		if (preg_match("/<OA>/",$row['options'])){
			$updatetitle = "$name out at $out_time"; 
		}
		elseif (preg_match("/<IA>/",$row['options'])){
			$updatetitle = "$name in at $in_time";
		}
		else {
			$updatetitle = "$name out";
		}
	}
	elseif (preg_match("/<FD>/",$row['options'])) {
		$updatetitle = "$name out";
	}
	$ptostmt = "UPDATE $ptotable SET "
	  ."title='$updatetitle'"
	  ."WHERE rowid='$rowid'";
	//	$stmt = "INSERT INTO pto_request (userid,password,name,options,start_date,hours) "
	//  ."VALUES ('$name',password('$pass'),'$visible','$options','$start_date','$hours')";
    
	  /*$stmt = "UPDATE $table SET "
	   ."userid='$name',password=$password,"
	   ."name='$visible',options='$options',start_date='$start_date',hours='$hours' "
		//."name='$visible',options='$options',part_time='$part_time',start_date='$start_date',pto_eligible='$pto_eligible',hours='$hours' "
	   ."WHERE rowid='$rowid'";*/
  } 
  return $this->_query($ptostmt);
}
	
Function updatePTO($userid,$options,$request) {//$part_time,$start_date,$pto_eligible,$hours) {
  $table = $this->getConfig('table');
  $ptotable = $this->getConfig('ptotable');
  
  $userid = $userid;
  
  $options = $options;
  $request = $request;
  $updatetitle = $name;
	
	
	
  if ($userid) {
	$this->getOutboardPTOByUID($userid);
	$row = $this->getRow();
	$usedPTO = $row['used_pto_hours'];
	$requestedPTO = $row['requested_pto'];
	if (preg_match("/<APPROVED>/",$options)){
		$newUsedPTO = $usedPTO + $request;
		$newRequestedPTO = $requestedPTO - $request;
	}
	elseif (preg_match("/<DENIED>/",$options)) {
		$newUsedPTO = $usedPTO;
		$newRequestedPTO = $requestedPTO - $request;
	}
	$stmt = "UPDATE $table SET "
	  ."used_pto_hours='$newUsedPTO',requested_pto='$newRequestedPTO'"
	  ."WHERE userid='$userid'";
  } 
  return $this->_query($stmt); 
}

// Delete the user from the OutBoard
Function deleteUser($rowid) {
  $table = $this->getConfig('table');
  $rowid = addslashes($rowid);
  if (! $rowid) { return null; }
  $stmt = "DELETE FROM $table WHERE rowid='$rowid'";
  return $this->_query($stmt);
}


Function _query($stmt) {
  if (! $stmt) { return false; }
  if ($this->result = mysql_query($stmt)) {
    return true;
  } else {
    trigger_error("Error in database query.");
    //print(mysql_error());
    //print("stmt = ".$stmt);
    return false;
  }
}

Function numRows() {
  if (! $this->result) { return null; }
  return mysql_num_rows($this->result);
}

Function getRow() {
  if (! $this->result) { return null; }
  if ($row = mysql_fetch_array($this->result)) { 
    return $row;
  } else {
    return null;
  } 
}

}

?>
