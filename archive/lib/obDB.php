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
  // Database Connection Configuration Parameters
  // array('driver' => 'mysql','host' => '','dbname' => '','username' => '','password' => '')
  protected $_config;

  // Database Connection
  public $dbc;

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

  /* function __construct
   * Opens the database connection
   * @param $config is an array of database connection parameters
   */
  public function __construct( array $config ) {
    $this->_config = $config;
    $this->getPDOConnection();
    $this->OutboardConfig();


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

  /* Function __destruct
  * Closes the database connection
  */
  public function __destruct() {
    $this->dbc = NULL;
  }

  /* Function getPDOConnection
  * Get a connection to the database using PDO.
  */
  private function getPDOConnection() {
    // Check if the connection is already established
    if ($this->dbc == NULL) {
        // Create the connection
        $dsn = "" .
            $this->_config['driver'] .
            ":host=" . $this->_config['host'] .
            ";dbname=" . $this->_config['dbname'];

        try {
            $this->dbc = new PDO( $dsn, $this->_config[ 'username' ], $this->_config[ 'password' ] );
        } catch( PDOException $e ) {
            echo __LINE__.$e->getMessage()." there was an error. ";
        }
    }
  }

  /* Function runQuery
  * Runs a insert, update or delete query
  * @param string sql insert update or delete statement
  * @return int count of records affected by running the sql statement.
  */
  public function runQuery( $sql ) {
    try {
      $count = $this->dbc->exec($sql) or print_r($this->dbc->errorInfo());
    } catch(PDOException $e) {
      echo __LINE__.$e->getMessage()." there was an error. ";
    }
    return $count;
  }

  /* Function getQuery
  * Runs a select query
  * @param string sql insert update or delete statement
  * @returns associative array
  */
  public function getQuery( $sql ) {
    $stmt = $this->dbc->query( $sql );
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

  return $stmt;
  }

  public function OutboardDatabase() {
    // Call the superclass constructor
    $this->OutboardConfig();


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
    // $row = $this->dbh->getQuery($stmt);
    $rows = $this->dbc->prepare($stmt);
    
    // $stmt->execute([':userid' => $username, ':pw' =>$password]);
    $rows->execute();
    $count = $rows->rowCount();
    if($count != 1){
  // $this->_query($stmt)
    // if ($this->numRows() != 1) {
      return null;
    } else {
      // $row = $this->getRow();
      foreach($rows as $row){
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
      $this->setADstaff(preg_match("/<ADSTAFF>/",$row['options']));}
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
    if($this->runQuery($stmt)){
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
    // $stmt = "SELECT count(*) FROM outboard WHERE userid='$username' password=PASSWORD('$password')";
    // $check = $this->dbc->prepare($stmt);
    // $count = $check->fetch(PDO::FETCH_ASSOC);
    // echo "\n".$count . "\n";
    $stmt = $this->dbc->prepare("SELECT userid FROM $table WHERE userid=:userid and password=PASSWORD(:pw)");
    
    $stmt->execute([':userid' => $username, ':pw' =>$password]);
   
    $check = $stmt->fetchAll();
    foreach($check as $row){
      if($row['userid']){
        $this->setOperatingUser($row['userid']);
        return $this->setSession(); 
      }
    }
    // $hash = $user['password'];

    
    // print_r(password_get_info($hash));
    // if (! function_exists("password_verify")) {
    //   trigger_error("The password libraries are not installed.");
    // } else {
    //   trigger_error("seems to be installed?");
    // }
    // if($hash == $hardcode_hash) 
    // {
    //    echo "success";
    //   } else {
    //     echo "failure";}
    // // if (password_verify($password, $user['password']))
    // if (password_verify($password, $hash))
    // {
    //     $this->setOperatingUser($row['userid']);
    //     return $this->setSession(); 
    // }
    // else {
    //   print_r("Password did not verify.");
    // }
    // print_r($user);
    // print_r(' password passed to php: '.$password);
    // // print_r(' password in the db: '.$user['password']);
    // print_r(' md5 hash '. md5($password));
    
    // print_r(' password verify: '.password_verify($password, $cp));
  //   if($row = $this->getQuery($stmt)){
  // // if ($this->_query($stmt)) {
  //   $count = $row->rowCount;
  //   // print_r
  //     // if ($this->numRows() == 1) {
  //   if($count == 1){
  //       // $row = $this->getRow();
  //       $this->setOperatingUser($row['userid']);
  //       return $this->setSession(); 
  //     }
  //     else {
  //       print_r($stmt);
  //     }
  //   }
    return false;
  }
  
  
  public function getLogStartDate() {
    $logtable = $this->getConfig('logtable');
    $stmt = "SELECT timestamp,"
     ."date_format(timestamp, '%Y-%m-%d') as changedate "
     ."FROM $logtable ORDER BY rowid ASC limit 1";
    if($row = $this->runQuery($stmt)){
  // if ($this->_query($stmt)) {
      // $row = $this->getRow();
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
    if($row = $this->getQuery($stmt)){
  // if ($this->_query($stmt)) {
      // $row = $this->getRow();
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
    if($row = $this->runQuery($stmt)){
  // if ($this->_query($stmt)) {
      // return true;
      return $row;
    } else {
      return false;
    }
  }

  // Gets the log data and converts it into an array;
  public function getLogDataArray($userid,$start,$end) {
    if ($row = $this->getLogData($userid,$start,$end)) {
      if (! $row) { return null; }
      $ld = Array();
      while($row) {
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
  $row = $this->getQuery($stmt);
// $this->_query($stmt)
  $count = $row->rowCount();
  if (! $count) { return null; }
  $userArray = Array();
  while($row) {
    $userArray[$row['userid']] = $row['name'];
  } 
  return $userArray;
}

public function getFullNames() {
  $table = $this->getConfig('table');
  $stmt = "SELECT DISTINCT userid,fullname FROM $table "
         ."WHERE options is null or options NOT LIKE '%<READONLY>%' ORDER BY fullname";
  $row = $this->getQuery($stmt);
  $count = $row->rowCount();
// $this->_query($stmt)
  if (! $count) { return null; }
  $userArray = Array();
  while($row) {
    $userArray[$row['userid']] = $row['fullname'];
  } 
  return $userArray;
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
  public function _log($userid) {
    $table = $this->getConfig('table');
    $logtable = $this->getConfig('logtable');
    $stmt = "select * from $table where userid = '$userid'";
    // $this->dbh->getQuery($stmt);
    $stmt->execute([':userid' => $userid]);
   
    $check = $stmt->fetchAll();
    foreach($check as $row){
  // $this->_query($stmt) 
    // $row = $this->getRow();
      $r_remarks = addslashes($row['remarks']);
      $r_userid = $row['userid'];
      $r_back = $row['back'];
      $r_name = $row['name'];
      $r_last_change = $row['last_change'];
      $stmt = "INSERT INTO $logtable (userid,back,remarks,name,last_change) "
            ."VALUES ('$r_userid','$r_back','$r_remarks','$r_name','$r_last_change')";
      return $this->dbh->runQuery($stmt);
    }
  //  return $this->_query($stmt);
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
      $this->runQuery($stmt);

    }
  }
}






