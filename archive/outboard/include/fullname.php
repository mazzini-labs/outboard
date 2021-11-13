<?php

// fullname.php
//
// If you have a method to get people's real/full names, put the
// code in this function. By default, it just returns the userid
// that it is sent.
// 
// 2005-02-17	Richard F. Feuerriegel	(richardf@aces.edu)
//
require_once("../lib/OutboardConfig.php");

Class OutboardDatabase extends OutboardConfig {
Function get_fullname($userid) { 
  $stmt = "SELECT DISTINCT fullname FROM $table "
         ."WHERE options is null or options NOT LIKE '%<READONLY>%' AND userid = $userid ORDER BY fullname";
  $this->_query($stmt);
  if (! $this->numRows()) { return null; }
  $user = "";
  while($row = $this->getRow()) {
    $user = $row['fullname'];
  } 
  return $user;
  // return $userid;

  /**** Example
  require_once("production/UserData.php");
  $u = new UserData();
  $info = $u->getInfo($userid);
  if (is_array($info)) {
    $name = ucwords(strtolower($info[2]." ".$info[1]));
    return($name);
  } else {
    return $userid;
  }
  ****/

}
}
?>
