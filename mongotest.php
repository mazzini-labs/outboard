<?php

Class OutboardDatabase {
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

  Function OutboardDatabase() {
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
      
  }
}
//Config
$dbhost = 'localhost';
$dbname = 'outboard';

$m = new Mongo("mongodb://$dbhost");
$db = $m->$dbname;

// select the collection
$outboard = $db->outboard;
// $events = $db->pto_request;
//pull a cursor query
$cursor = $outboard->find();
// print_r($cursor);

// iterate data for each document
foreach($cursor as $document) {
  echo $document['userid'] . "\n";
  
}

// selecting a new collection (database)
// $wells = $dbname->wells

// creating a document (new entry)
/*
$entry = array(
  'field1' => 'this is a field',
  'field2' => 'this is the second field',
  'field3' => 'field three',
  'created_at' => new MongoDate()
);
$wells->insert($entry);
*/

// $results = $events->findOne(array('_id' => new MongoId($id)));
// $events = $dbname->pto_request;
// function cal_load(){
// $findEvents = $events->find([ "is_pto" =>  false ]);
print_r($findEvents);
foreach($findEvents as $row) {
  // var_dump($row);
  $data[] = array(
    'id' => $row['_id'],
    'allDay'   => $row['all_day'] == "true" ? 1 : 0,
    'title'   => $row["title"],
    'start'   => $row["start_time"],
    'end'   => $row["end_time"],
    
    'color'   => "#".$row["color"],
    'description' => $row["remarks"]
   );
}
header('Content-type:application/json;charset=utf-8');
return json_encode($data);
// }
// cal_load();
//Find one document from collection
// $results = $posts::findOne(array('_id' => new MongoId($id)));
// print_r($results);
// mysql to mongo queries
// SELECT userid FROM outboard
// db.outboard.find({
 
// },{
//    "userid": 1
// }
// );

// SELECT * FROM pto_request where id like $id
// db.pto_request.find({
//   "id " :  "%id%" 
//  });

// SELECT * FROM `list` where api =  $api
// SELECT * from `ddr_old` WHERE api like $api AND s like 'compressor'
// SELECT * from `ddr_old` WHERE api like $api AND s like 'dehydrator'
// SELECT * from `ddr_old` WHERE api like $api AND s like 'smh'
// SELECT well from `000api_list` WHERE `api` like \"%".$apiNoQuot."%\"
// SELECT * from `$wellCheck` WHERE sheet like 'smh'";
// SELECT * from `$wellCheck` WHERE sheet like 'dehydrator'";
// SELECT * from `$wellCheck` WHERE sheet like 'compressor'";
// SELECT * from `$wellCheck` WHERE sheet like 'txdot'";
// SELECT * from `$wellCheck` WHERE sheet like 'adsr'";
// SELECT * from `$wellCheck` WHERE sheet like 'bdsr'";
// SELECT * FROM `list` where api =  $api ";
// SELECT * FROM `prod_data` where api =  $api ";
// SELECT * FROM `vitals` where api =  $api order by d asc";
// SELECT * from `ddr_old` WHERE api like $api";
// SELECT well from `000api_list` WHERE `api` like \"%".$apiNoQuot."%\"";
// SELECT * from `$wellCheck` WHERE sheet like 'dsr2015pres'";
// SELECT * from `$wellCheck` WHERE sheet like 'before2015sumrpt'";
// SELECT * from `$wellCheck` WHERE sheet like 'before2015detailrpt'";
// SELECT * FROM `list` where api =  $api ";
// SELECT api, well_lease, well_no FROM $table";
// SELECT * FROM pto_request WHERE id = '".$_POST["id"]."'";  
// SELECT * FROM pto_request WHERE id = '".$_POST["id"]."'";  
// SELECT * FROM common_area_phones
// SELECT * from `ddr_old` WHERE api like $api and s like $s