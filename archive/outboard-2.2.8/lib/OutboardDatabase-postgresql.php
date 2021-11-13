<?php

/**
 * OutboardDatabase.php
 *
 * Controls all database access for the OutBoard.
 *
 * 2020-10-15	richardf - Added delayed connection feature
 * 2020-09-15 	richardf - Updated for PHP7.
 * 2005-02-15	Richard F. Feuerriegel	(richardf@aces.edu)
 *	- Initial creation
 *
 **/

require_once("lib/OutboardConfig.php");

class OutboardDatabase extends OutboardConfig {

private $dbh = null;           // Database handle
private $hostIP = null;        // IP address of the user's computer
private $operatingUser = null; // The username of the person using the OutBoard
private $readonly = null;      // Boolean. True if the board is in read-only mode.
private $admin = null;         // Boolean. True if the user is an OutBoard administrator.
private $session = null;       // The current session value used for authentication later
private $result = null;	   // The current query result handle


public function __construct() {
  // Call the superclass constructor
  parent::__construct();	
 
  $this->hostIP = $_SERVER['REMOTE_ADDR'];
  $this->setReadonly(false);
  $this->setAdmin(false);  
}

public function makeConnection() {
	 if (! function_exists("pg_pconnect")) {
	  trigger_error("The PgSQL libraries are not installed.");
	  }

	  // Open the database connection
	  $this->dbh = @pg_pconnect("host=" . $this->getConfig('dbhost')
					. " user=" . $this->getConfig('dbuser')
					. " dbname=" . $this->getConfig('db')
					. " password=" . $this->getConfig('dbpass')
				);
	  if (! $this->dbh) {
		trigger_error("Unable to connect to the database server.");
	  }
	  if ($this->dbh) $this->autoLogoutIdlers();
}

public function getOperatingUser() { return $this->operatingUser; }
public function setOperatingUser($username) { $this->operatingUser = $username; }

public function isReadonly() { return $this->readonly; }
public function setReadonly($boolean) { $this->readonly = $boolean; }

public function isAdmin() { return $this->admin; }
public function setAdmin($boolean) { $this->admin = $boolean; }

public function isChangeable($userid) {
  $level  = $this->getConfig('allow_change');
  $opuser = $this->getOperatingUser();
  if     ($level == "all") { return true; }
  elseif ($level == "user_only"  && $userid == $opuser) { return true; }
  elseif ($level == "admin_only" && $this->isAdmin() )  { return true; }
  elseif ($level == "user_admin" 
	  && ($this->isAdmin() || $userid == $opuser))  { return true; }
  else { return false; }
}


public function getSession($session_cookie) {
  $table = $this->getConfig('table');
  if ($session_cookie == "") { return null; }
  $stmt = "SELECT userid,name,options FROM $table WHERE session = '$session_cookie'";
  $this->_query($stmt);
  if ($this->numRows() != 1) {
    return null;
  } else {
    $row = $this->getRow();
    $this->setOperatingUser($row['userid']);
    $this->setReadonly(preg_match("/READONLY/",$row['options']));
    $this->setAdmin(preg_match("/ADMIN/",$row['options']));
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
  if ($this->_query($stmt)) {
    return $session;
  } else {
    return false;
  }
}


public function checkPassword($username,$password) {
  $table = $this->getConfig('table');
  $username = addslashes($username);
  $password = addslashes($password);
  $stmt = "SELECT userid FROM $table WHERE userid='$username' and password=md5('$password')";
  if ($this->_query($stmt)) {
    if ($this->numRows() == 1) {
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
	 ."date_part('year', timestamp) || '-' || date_part('month', timestamp) || '-' || date_part('day', timestamp) as changedate "
	 ."FROM $logtable ORDER BY rowid ASC limit 1";
  if ($this->_query($stmt)) {
    $row = $this->getRow();
    return $row['changedate'];
  } else {
    return null;
  }
}

public function getLogEndDate() {
  $logtable = $this->getConfig('logtable');
  $stmt = "SELECT timestamp,"
	 ."date_part('year', timestamp) || '-' || date_part('month', timestamp) || '-' || date_part('day', timestamp) as changedate "
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
public function getLogData($userid,$start,$end) {
  $logtable = $this->getConfig('logtable');
  $stmt =
    "SELECT rowid,userid,back,remarks,name,timestamp,
            date_part('hour', back) || ':' || date_part('minute', back) as backtime,
            date_part('year', timestamp) || '-' || date_part('month', timestamp) || '-' || date_part('day', timestamp) as changedate,
            date_part('hour', timestamp) || ':' || date_part('minute, timestamp) as changetime,
            date_part('day', timestamp) as day,
            date_part('epoch', timestamp) as timeinseconds
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
         ."WHERE options is null or options NOT LIKE '%READONLY%' ORDER BY name";
  $this->_query($stmt);
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
  $stmt = "select rowid, userid, name, options, date_part('epoch', back) as back, "
         ."remarks, last_change, timestamp "
         ."from $table order by name";
  if ($this->_query($stmt)) {
    return true;
  } else {
    return false;
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
	   ."(date_part('epoch',now()) - date_part('epoch',timestamp)) > $seconds";
    $this->_query($stmt);
  }
}

// Gets the data on a single person
public function getDataByID($rowid) {
  $table = $this->getConfig('table');
  $rowid = addslashes($rowid);
  $stmt = "select rowid, userid, password, name, options, "
         ."remarks, last_change, timestamp "
         ."from $table where rowid = '$rowid'";
  if ($this->_query($stmt)) {
    return true;
  } else {
    return false;
  }
}

public function isBoardMember($userid) {
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


public function setDotIn($userid) {
  return $this->_moveDot($userid,$this->getConfig('in')); 
}


public function setDotOut($userid) {
  return $this->_moveDot($userid,$this->getConfig('out')); 
}


public function setDotTime($userid,$hour) {
  $current = getdate();
  $return_datetime = mktime($hour,'00','00',$current['mon'],$current['mday'],$current['year']);
  $back = date('Y-m-d H:i:s',$return_datetime);
  return $this->_moveDot($userid,$back); 
}


private function _moveDot($userid,$back) {
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


private function _log($userid) {
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


// Edits an existing user if $rowid is set; adds otherwise.
public function saveUser($rowid,$name,$pass,$visible,$options) {
  $table = $this->getConfig('table');
  $rowid = addslashes($rowid);
  $name = addslashes($name);
  $pass = addslashes($pass);
  $visible = addslashes($visible); // name
  $options = addslashes($options);
  if ($rowid) {
    $this->getDataByID($rowid);
    $row = $this->getRow();
    // Only update the password if it changed on the form.
    if ($row['password'] != $pass) {
      $password = "md5('$pass')";
    } else {
      $password = "'$pass'";
    }
    $stmt = "UPDATE $table SET "
	   ."userid='$name',password=$password,"
	   ."name='$visible',options='$options' "
	   ."WHERE rowid='$rowid'";
  } else {
    $stmt = "INSERT INTO $table (userid,password,name,options) "
	   ."VALUES ('$name',md5('$pass'),'$visible','$options')";
  }
  return $this->_query($stmt);
}


// Delete the user from the OutBoard
public function deleteUser($rowid) {
  $table = $this->getConfig('table');
  $rowid = addslashes($rowid);
  if (! $rowid) { return null; }
  $stmt = "DELETE FROM $table WHERE rowid='$rowid'";
  return $this->_query($stmt);
}


private function _query($stmt) {
  if (! $this->dbh) $this->makeConnection();
  if (! $stmt) { return false; }
  if ($this->result = pg_query($stmt)) {
    return true;
  } else {
    trigger_error("Error in database query.");
    //print(pg_error());
    //print("stmt = ".$stmt);
    return false;
  }
}

public function numRows() {
  if (! $this->result) { return null; }
  return pg_num_rows($this->result);
}

public function getRow() {
  if (! $this->result) { return null; }
  if ($row = pg_fetch_array($this->result)) { 
    return $row;
  } else {
    return null;
  } 
}

}
