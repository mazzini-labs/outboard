<?php

// fullname.php
//
// If you have a method to get people's real/full names, put the
// code in this function. By default, it just returns the userid
// that it is sent.
// 
// 2005-02-17	Richard F. Feuerriegel	(richardf@aces.edu)
//

Function get_fullname($userid) {
  return $userid;

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

?>
