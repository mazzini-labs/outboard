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
// require_once('../config/settings.config.php');
require_once("lib/OutboardConfig.php");

Class OutboardDatabase extends OutboardConfig {

var $dbh = null;           // Database handle
var $pdh = null;           // PTO DB handle
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

public function Connect(){
  $this->OutboardConfig();
  $connect = mysqli_connect($this->getConfig('dbhost'), $this->getConfig('dbuser'),$this->getConfig('dbpass'), $this->getConfig('db'));
  return $connect;
}
public function OutboardDatabase() {
  // Call the superclass constructor
  $this->OutboardConfig();
  // $localhost = 
  $this->dbh = new OutboardConfig($this->getConfig('localhost'));
  if (! function_exists("mysqli_connect")) {
	  trigger_error("The MySQL libraries are not installed.");
  }

  // Open the database connection
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
  // $this->dbh = @mysqli_connect($this->getConfig('dbhost'),
	// 		      $this->getConfig('dbuser'),
	// 		      $this->getConfig('dbpass'), $this->getConfig('db'));
  // $connect = mysqli_connect($this->getConfig('dbhost'), $this->getConfig('dbuser'),
  // $this->getConfig('dbpass'), $this->getConfig('db'));
  if (! $this->dbh) {
    trigger_error("Unable to connect to the database server.");
  }
  if (! @mysqli_select_db($this->getConfig('db'),$this->dbh)) {
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


public function getOperatingUser() { return $this->operatingUser; }
public function setOperatingUser($username) { $this->operatingUser = $username; }

public function isReadonly() { return $this->readonly; }
public function setReadonly($boolean) { $this->readonly = $boolean; }

public function isSuperAdmin() { return $this->superadmin; }
public function setSuperAdmin($boolean) { $this->superadmin = $boolean; }
	
public function isAdmin() { return $this->admin; }
public function setAdmin($boolean) { $this->admin = $boolean; }
	
public function isEligible() { return $this->eligible; }
public function setEligible($boolean) { $this->eligible = $boolean; }

public function isHR() { return $this->hr; }
public function setHR($boolean) { $this->hr = $boolean; }

public function isAPspr() { return $this->apspr; }
public function setAPspr($boolean) { $this->apspr = $boolean; }

public function isA1spr() { return $this->acct1spr; }
public function setA1spr($boolean) { $this->acct1spr = $boolean; }
	
public function isA2spr() { return $this->acct2spr; }
public function setA2spr($boolean) { $this->acct2spr = $boolean; }
	
public function isE1spr() { return $this->eng1spr; }
public function setE1spr($boolean) { $this->eng1spr = $boolean; }
	
public function isE2spr() { return $this->eng2spr; }
public function setE2spr($boolean) { $this->eng2spr = $boolean; }
	
public function isLandspr() { return $this->landspr; }
public function setLandspr($boolean) { $this->landspr = $boolean; }

public function isLegalspr() { return $this->legalspr; }
public function setLegalspr($boolean) { $this->legalspr = $boolean; }
	
public function isGeospr() { return $this->geospr; }
public function setGeospr($boolean) { $this->geospr = $boolean; }
	
public function isADstaffspr() { return $this->adstaffspr; }
public function setADstaffspr($boolean) { $this->adstaffspr = $boolean; }

public function isAP() { return $this->ap; }
public function setAP($boolean) { $this->ap = $boolean; }

public function isA1() { return $this->acct1; }
public function setA1($boolean) { $this->acct1 = $boolean; }
	
public function isA2() { return $this->acct2; }
public function setA2($boolean) { $this->acct2 = $boolean; }
	
public function isE1() { return $this->eng1; }
public function setE1($boolean) { $this->eng1 = $boolean; }
	
public function isE2() { return $this->eng2; }
public function setE2($boolean) { $this->eng2 = $boolean; }
	
public function isLand() { return $this->land; }
public function setLand($boolean) { $this->land = $boolean; }

public function isLegal() { return $this->legal; }
public function setLegal($boolean) { $this->legal = $boolean; }
	
public function isGeo() { return $this->geo; }
public function setGeo($boolean) { $this->geo = $boolean; }
	
public function isADstaff() { return $this->adstaff; }
public function setADstaff($boolean) { $this->adstaff = $boolean; }

	
public function isChangeable($userid) {
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


public function getSession($session_cookie) {
  $table = $this->getConfig('table');
  if ($session_cookie == "") { return null; }
  $stmt = "SELECT userid,name,options FROM $table WHERE session = '$session_cookie'";
  $r = $this->dbh->getQuery($stmt);
// $this->_query($stmt)

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


public function setSession($session = "NONE") {
  $table = $this->getConfig('table');
  if (! $userid = $this->getOperatingUser()) { return false; }
  if ($session == "NONE") {
    mt_srand((double)microtime()*1000000); 
    $session = mt_rand(1,10000000) . uniqid(""); 
    $this->session = $session;
  }
  $stmt = "UPDATE $table SET session='$session' WHERE userid='$userid'";
  if($this->dbh->runQuery($stmt)){
// if ($this->_query($stmt)) {
    return $session;
  } else {
    return false;
  }
}


public function checkPassword($username,$password) {
  $table = $this->getConfig('table');
  $username = addslashes($username);
  $password = addslashes($password);
  $stmt = "SELECT userid FROM $table WHERE userid='$username' and password=password('$password')";
  if($q = $this->dbh->getQuery($stmt)){
// if ($this->_query($stmt)) {
  $count = $q->rowCount;
  // print_r
    // if ($this->numRows() == 1) {
  if($count == 1){
      $row = $this->getRow();
      $this->setOperatingUser($row['userid']);
      return $this->setSession(); 
    }
  }
  return false;
}


public function getLogStartDate() {
  $logtable = $this->getConfig('logtable');
  $stmt = "SELECT timestamp,"
	 ."date_format(timestamp, '%Y-%m-%d') as changedate "
	 ."FROM $logtable ORDER BY rowid ASC limit 1";
  if($this->dbh->runQuery($stmt)){
// if ($this->_query($stmt)) {
    $row = $this->getRow();
    return $row['changedate'];
  } else {
    return null;
  }
}

public function getLogEndDate() {
  $logtable = $this->getConfig('logtable');
  $stmt = "SELECT timestamp,"
	 ."date_format(timestamp, '%Y-%m-%d') as changedate "
	 ."FROM $logtable timestamp ORDER BY rowid DESC limit 1";
  if($this->dbh->runQuery($stmt)){
// if ($this->_query($stmt)) {
    $row = $this->getRow();
    return $row['changedate'];
  } else {
    return null;
  }
}


// Gets all the rows/data from the log table for a specific user 
// and data range. $start and $end are in the form 'yyyy-mm-dd'.
public function getLogData($userid,$start,$end) {
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
  if($this->dbh->runQuery($stmt)){
// if ($this->_query($stmt)) {
    return true;
  } else {
    return false;
  }
}

// Gets the log data and converts it into an array;
public function getLogDataArray($userid,$start,$end) {
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


public function getNames() {
  $table = $this->getConfig('table');
  $stmt = "SELECT DISTINCT userid,name FROM $table "
         ."WHERE options is null or options NOT LIKE '%<READONLY>%' ORDER BY name";
  $this->dbh->getQuery($stmt);
// $this->_query($stmt)
  if (! $this->numRows()) { return null; }
  $userArray = Array();
  while($row = $this->getRow()) {
    $userArray[$row['userid']] = $row['name'];
  } 
  return $userArray;
}

public function getFullNames() {
  $table = $this->getConfig('table');
  $stmt = "SELECT DISTINCT userid,fullname FROM $table "
         ."WHERE options is null or options NOT LIKE '%<READONLY>%' ORDER BY fullname";
  $this->dbh->getQuery($stmt);
// $this->_query($stmt)
  if (! $this->numRows()) { return null; }
  $userArray = Array();
  while($row = $this->getRow()) {
    $userArray[$row['userid']] = $row['fullname'];
  } 
  return $userArray;
}

public function getEligible() {
  $table = $this->getConfig('table');
  $stmt = "SELECT DISTINCT userid,name FROM $table "
         ."WHERE options LIKE '%<ELIGIBLE>%' ORDER BY name";
  $this->dbh->getQuery($stmt);
// $this->_query($stmt)
  if (! $this->numRows()) { return null; }
  $userArray = Array();
  while($row = $this->getRow()) {
    $userArray[$row['userid']] = $row['name'];
  } 
  return $userArray;
}

public function getInEligible() {
  $table = $this->getConfig('table');
  $stmt = "SELECT DISTINCT userid,name FROM $table "
         ."WHERE options NOT LIKE '%<ELIGIBLE>%' ORDER BY name";
  $this->dbh->getQuery($stmt);
// $this->_query($stmt)
  if (! $this->numRows()) { return null; }
  $userArray = Array();
  while($row = $this->getRow()) {
    $userArray[$row['userid']] = $row['name'];
  } 
  return $userArray;
}
public function getAP() {
  $table = $this->getConfig('table');
  $stmt = "SELECT DISTINCT userid,name FROM $table "
         ."WHERE options LIKE '%<AP>%' ORDER BY name";
  $this->dbh->getQuery($stmt);
// $this->_query($stmt)
  if (! $this->numRows()) { return null; }
  $userArray = Array();
  while($row = $this->getRow()) {
    $userArray[$row['userid']] = $row['name'];
  } 
  return $userArray;
}
public function getAG1() {
  $table = $this->getConfig('table');
  $stmt = "SELECT DISTINCT userid,name FROM $table "
         ."WHERE options LIKE '%<ACCT1>%' ORDER BY name";
  $this->dbh->getQuery($stmt);
// $this->_query($stmt)
  if (! $this->numRows()) { return null; }
  $userArray = Array();
  while($row = $this->getRow()) {
    $userArray[$row['userid']] = $row['name'];
  } 
  return $userArray;
}
public function getAG2() {
  $table = $this->getConfig('table');
  $stmt = "SELECT DISTINCT userid,name FROM $table "
         ."WHERE options LIKE '%<ACCT2>%' ORDER BY name";
  $this->dbh->getQuery($stmt);
// $this->_query($stmt)
  if (! $this->numRows()) { return null; }
  $userArray = Array();
  while($row = $this->getRow()) {
    $userArray[$row['userid']] = $row['name'];
  } 
  return $userArray;
}
public function getE1() {
  $table = $this->getConfig('table');
  $stmt = "SELECT DISTINCT userid,name FROM $table "
         ."WHERE options LIKE '%<ENG1>%' ORDER BY name";
  $this->dbh->getQuery($stmt);
// $this->_query($stmt)
  if (! $this->numRows()) { return null; }
  $userArray = Array();
  while($row = $this->getRow()) {
    $userArray[$row['userid']] = $row['name'];
  } 
  return $userArray;
}
public function getE2() {
  $table = $this->getConfig('table');
  $stmt = "SELECT DISTINCT userid,name FROM $table "
         ."WHERE options LIKE '%<ENG2>%' ORDER BY name";
  $this->dbh->getQuery($stmt);
// $this->_query($stmt)
  if (! $this->numRows()) { return null; }
  $userArray = Array();
  while($row = $this->getRow()) {
    $userArray[$row['userid']] = $row['name'];
  } 
  return $userArray;
}
public function getLand() {
  $table = $this->getConfig('table');
  $stmt = "SELECT DISTINCT userid,name FROM $table "
         ."WHERE options LIKE '%<LAND>%' ORDER BY name";
  $this->dbh->getQuery($stmt);
// $this->_query($stmt)
  if (! $this->numRows()) { return null; }
  $userArray = Array();
  while($row = $this->getRow()) {
    $userArray[$row['userid']] = $row['name'];
  } 
  return $userArray;
}
public function getLegal() {
  $table = $this->getConfig('table');
  $stmt = "SELECT DISTINCT userid,name FROM $table "
         ."WHERE options LIKE '%<LEGAL>%' ORDER BY name";
  $this->dbh->getQuery($stmt);
// $this->_query($stmt)
  if (! $this->numRows()) { return null; }
  $userArray = Array();
  while($row = $this->getRow()) {
    $userArray[$row['userid']] = $row['name'];
  } 
  return $userArray;
}
public function getGeo() {
  $table = $this->getConfig('table');
  $stmt = "SELECT DISTINCT userid,name FROM $table "
         ."WHERE options LIKE '%<GEO>%' ORDER BY name";
  $this->dbh->getQuery($stmt);
// $this->_query($stmt)
  if (! $this->numRows()) { return null; }
  $userArray = Array();
  while($row = $this->getRow()) {
    $userArray[$row['userid']] = $row['name'];
  } 
  return $userArray;
}
public function getADstaff() {
  $table = $this->getConfig('table');
  $stmt = "SELECT DISTINCT userid,name FROM $table "
         ."WHERE options LIKE '%<ADSTAFF>%' ORDER BY name";
  $this->dbh->getQuery($stmt);
// $this->_query($stmt)
  if (! $this->numRows()) { return null; }
  $userArray = Array();
  while($row = $this->getRow()) {
    $userArray[$row['userid']] = $row['name'];
  } 
  return $userArray;
}
	
	
	
// Gets all the rows/data from the main Outboard table
public function getData() {
  $table = $this->getConfig('table');
  $stmt = "select rowid, userid, name, options, unix_timestamp(back) as back, "
	  	 ."part_time, start_date, pto_eligible, hours,"
         ."remarks, last_change, date_format(timestamp, '%m/%d, %l:%i %p') as timestamp "
         ."from $table order by name";
  if($this->dbh->runQuery($stmt)){
// if ($this->_query($stmt)) {
    return true;
  } else {
    return false;
  }
}
public function getPEData() {
  $table = "phoneextensions";
  $stmt = "select * "
         ."from $table";
  if($this->dbh->runQuery($stmt)){
// if ($this->_query($stmt)) {
    return true;
  } else {
    return false;
  }
}
public function getCAData() {
  $table = "common_area_phones";
  $stmt = "select * "
         ."from $table";
  if($this->dbh->runQuery($stmt)){
// if ($this->_query($stmt)) {
    return true;
  } else {
    return false;
  }
}
public function getOEData() {
  $table = "other_phones_and_misc";
  $stmt = "select * "
         ."from $table";
  if($this->dbh->runQuery($stmt)){
// if ($this->_query($stmt)) {
    return true;
  } else {
    return false;
  }
}
public function get8EData() {
  $table = "phone_800_numbers";
  $stmt = "select * "
         ."from $table";
  if($this->dbh->runQuery($stmt)){
// if ($this->_query($stmt)) {
    return true;
  } else {
    return false;
  }
}
public function getDataTest($table) {
  $stmt = "select * "
         ."from $table";
  if($this->dbh->runQuery($stmt)){
// if ($this->_query($stmt)) {
    return true;
  } else {
    return false;
  }
}
public function getPTOData($group) {
  
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
			  id,
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
			   id DESC";


  // return $stmt;
  if($this->dbh->runQuery($stmt)){
// if ($this->_query($stmt)) {
    return true;
    //return mysql_query($stmt) or die(mysql_error());
  } else {
    $dbh = mysqli_connect($this->getConfig('dbhost'),
    $this->getConfig('dbuser'),
    $this->getConfig('dbpass'), $this->getConfig('db'));
    return mysqli_query($dbh, $stmt) or die(mysqli_error($dbh));
  }

}

// Moves the dots to Out after a specified idle time (in seconds).
public function autoLogoutIdlers() {
  $seconds = abs(floor($this->getConfig('max_idle_seconds')));
  if ($seconds > 0) {
    $table = $this->getConfig('table');
    $out = $this->getConfig('out');
    $stmt = "UPDATE $table "
	   ."SET back='$out',last_change='auto-logout,0.0.0.0' "
	   ."WHERE back != '$out' AND "
	   ."(unix_timestamp(now()) - unix_timestamp(timestamp)) > $seconds";
    $this->dbh->runQuery($stmt);
// $this->_query($stmt)
  }
}

// Gets the data on a single person
public function getDataByID($rowid) {
  $table = $this->getConfig('table');
  $rowid = addslashes($rowid);
  $stmt = "select rowid, userid, password, name, options, "
	      ."part_time, start_date, pto_eligible, hours,"
         ."remarks, last_change, date_format(timestamp, '%m/%d, %l:%i %p') as timestamp "
	     
         ."from $table where rowid = '$rowid'";
  if($this->dbh->runQuery($stmt)){
// if ($this->_query($stmt)) {
    return true;
  } else {
    return false;
  }
}

public function getPEByID($rowid,$table) {
  //$rowid = addslashes($rowid);
  //$table = addslashes($table);
  //$table = "phoneextensions";
  $stmt = "select * from $table where email = '$rowid'";
  if($this->dbh->runQuery($stmt)){
// if ($this->_query($stmt)) {
    return true;
  } else {
    return false;
  }
}

public function getOEByID($rowid,$table,$field) {
  //$rowid = addslashes($rowid);
  //$table = addslashes($table);
  //$table = "phoneextensions";
  $stmt = "select * from $table where $field = '$rowid'";
  if($this->dbh->runQuery($stmt)){
// if ($this->_query($stmt)) {
    return true;
  } else {
    return false;
  }
}

public function getPTOByID($rowid) {
  $table = $this->getConfig('ptotable');
  $rowid = addslashes($rowid);
	$stmt = "select * from $table where id = '$rowid'";
/*
  $stmt = "select rowid, userid, date_format(start_time, '%m/%d, %l:%i %p') as start_time,"
	  	."date_format(end_time, '%m/%d, %l:%i %p') as end_time, name, title, options, requested_pto"	     
         ."from $table where rowid = '$rowid'";
*/
  if($this->dbh->runQuery($stmt)){
// if ($this->_query($stmt)) {
    return true;
  } else {
    return false;
  }
}
public function getOutboardPTOByUID($userid) {
  $table = $this->getConfig('table');
  $userid = addslashes($userid);
  
 $stmt = "SELECT * FROM $table where userid = '$userid'";
 
  if($this->dbh->runQuery($stmt)){
// if ($this->_query($stmt)) {
    return true;
  } else {
    return false;
  }
}
	
public function isBoardMember($userid) {
  $table = $this->getConfig('table');
  $userid = addslashes($userid);
  $stmt = "select rowid from $table where userid = '$userid'";
  $this->dbh->getQuery($stmt);
// $this->_query($stmt)
  if ($this->numRows() == 1) {
    return true;
  } else {
    return false;
  }
}


public function setDotIn($userid) {
  return $this->_moveDot($userid,$this->getConfig('in')); 
}


public function setDotOut($userid) {
  return $this->_moveDot($userid,$this->getConfig('out')); 
}

public function setDotRW($userid) {
  return $this->_moveDot($userid,$this->getConfig('rw')); 
}


public function setDotTime($userid,$hour) {
  $current = getdate();
  $return_datetime = mktime($hour,'00','00',$current['mon'],$current['mday'],$current['year']);
  $back = date('Y-m-d H:i:s',$return_datetime);
  return $this->_moveDot($userid,$back); 
}


public function _moveDot($userid,$back) {
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


public function setRemarks($userid,$remarks) {
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
// NOT IMPLEMENTED AS OF 07.16.20 
// Will need to add to outboard.php...can I get it to run at a certain time?
public function setTimeOffRemarks() {
  $table = $this->getConfig('table');
  $cdate = date("Y-m-d"); // Note that I may need to change the format to get the checkstmt to work
  $checkstmt = "select * from pto_request where start_time = ".$cdate."";
  if($checkDate = $this->_query($checkstmt)) 
  {
    while ($checkRow = $this->getRow()){
      $userid = $checkRow['userid'];
      $remarks = $checkRow['remarks'];
      $stmt = "update $table "
      ."set remarks='".addslashes($remarks)."',last_change='OutboardPTO,192.168.1.3' "
      ."where userid = '$userid'";
      $this->dbh->runQuery($stmt);
// $this->_query($stmt)
      $this->_log($userid);
    }
  }
}

public function _log($userid) {
  $table = $this->getConfig('table');
  $logtable = $this->getConfig('logtable');
  $stmt = "select * from $table where userid = '$userid'";
  $this->dbh->getQuery($stmt);
// $this->_query($stmt) 
  $row = $this->getRow();
  $r_remarks = addslashes($row['remarks']);
  $r_userid = $row['userid'];
  $r_back = $row['back'];
  $r_name = $row['name'];
  $r_last_change = $row['last_change'];
  $stmt = "INSERT INTO $logtable (userid,back,remarks,name,last_change) "
         ."VALUES ('$r_userid','$r_back','$r_remarks','$r_name','$r_last_change')";
  return $this->dbh->runQuery($stmt);
//  return $this->_query($stmt);
}
/* //function for pto requests TEST
public function _pto($userid) {
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
  return $this->dbh->runQuery($stmt);
//  return $this->_query($stmt);
}
*/
// Edits an existing user if $rowid is set; adds otherwise.
public function saveUser($rowid,$name,$pass,$visible,$options,$start_date,$hours) {//$part_time,$start_date,$pto_eligible,$hours) {
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
  return $this->dbh->runQuery($stmt);
//  return $this->_query($stmt);
}

public function savePE($name,$title,$extension,$email,$table,$rowid) {//$part_time,$start_date,$pto_eligible,$hours) {
  $table = "phoneextensions";
  $name = addslashes($name);
  $title = addslashes($title);
  $extension = addslashes($extension); // name
  $email = addslashes($email);
  if ($rowid) {
    $stmt = "UPDATE $table SET "
	   ."name='$name',title='$title',"
	   ."extension='$extension',email='$email' "
	   ."WHERE id=$rowid";
  } else {
    $stmt = "INSERT INTO $table (name,title,extension,email) "
      ."VALUES ('$name','$title','$extension','$email')";
  }
  return $this->dbh->runQuery($stmt);
//  return $this->_query($stmt);
}

public function saveExt($field1,$field2,$value1,$value2,$table,$rowid) {//$part_time,$start_date,$pto_eligible,$hours) {
  $value1 = addslashes($value1);
  $value2 = addslashes($value2);
  if ($rowid) {
    $stmt = "UPDATE $table SET "
	   ."$field1='$value1',$field2='$value2' "
	   ."WHERE id=$rowid";
  } else {
    $stmt = "INSERT INTO `$table` ($field1,$field2) "
    ."VALUES ('$value1','$value2')";
  }
  return $this->dbh->runQuery($stmt);
//  return $this->_query($stmt);
}
public function savePrinter($field1,$field2,$field3,$value1,$value2,$value3,$table,$rowid) {//$part_time,$start_date,$pto_eligible,$hours) {
  $value1 = addslashes($value1);
  $value2 = addslashes($value2);
  $value3 = addslashes($value3);
  if ($rowid) {
    $stmt = "UPDATE $table SET "
	   ."$field1='$value1',$field2='$value2',"
	   ."$field3='$value3' "
	   ."WHERE id=$rowid";
  } else {
	  $stmt = "INSERT INTO $table ($field1,$field2,$field3) "
    ."VALUES ('$value1','$value2','$value3')";
  }
  
  return $this->dbh->runQuery($stmt);
//  return $this->_query($stmt);
}

public function updatePTOcal($rowid,$userid,$start_time,$end_time,$name,$options,$request) {//$part_time,$start_date,$pto_eligible,$hours) {
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
	
public function updatePTO($userid,$options,$request) {//$part_time,$start_date,$pto_eligible,$hours) {
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
  return $this->dbh->runQuery($stmt);
//  return $this->_query($stmt); 
}

// Delete the user from the OutBoard
public function deleteUser($rowid) {
  $table = $this->getConfig('table');
  $rowid = addslashes($rowid);
  if (! $rowid) { return null; }
  $stmt = "DELETE FROM $table WHERE rowid='$rowid'";
  return $this->dbh->runQuery($stmt);
//  return $this->_query($stmt);
}

public function deleteExt($field,$value,$table) {
  $value = addslashes($value);
  $field = addslashes($field);
  $table = addslashes($table);
  if (! $value) { return null; }
  $stmt = "DELETE FROM $table WHERE $field='$value'";
  return $this->dbh->runQuery($stmt);
//  return $this->_query($stmt);
}

public function _query($stmt) {
  if (! $stmt) { return false; }
  // $connect = $this->dbh;
  // $connect = Connect();
  
  // $this->OutboardConfig();
  // $connect = mysqli_connect($this->getConfig('dbhost'), $this->getConfig('dbuser'),$this->getConfig('dbpass'), $this->getConfig('db'));
  // $stmt = mysqli_real_escape_string($connect, $stmt);
  // if ($this->result = mysqli_query($connect, $stmt)) {
  if($stmt){
    // return true;
    return $this->dbh->runQuery($stmt);
  } else {
    trigger_error("Error in database query.");
    print(mysqli_error($connect));
    print(" stmt = ".$stmt);
    return false;
  }
}

public function numRows() {
  if (! $this->result) { return null; }
  return mysqli_num_rows($this->result);
}

public function getRow() {
  if (! $this->result) { return null; }
  if ($row = mysqli_fetch_array($this->result)) { 
    return $row;
  } else {
    return null;
  } 
}
public function console_log($output, $with_script_tags = true) {
  $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
  if ($with_script_tags) {
      $js_code = '<script>' . $js_code . '</script>';
  }
  echo $js_code;
}

}

?>
