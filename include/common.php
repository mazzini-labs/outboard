<?php

// common.php
//
// Common functions
// 
// 2005-02-17  Richard F. Feuerriegel  (richardf@aces.edu)

Function getGetValue($variable) {
  if (isset($_GET[$variable])) {
    return $_GET[$variable];
  }
}

Function getPostValue($variable) {
  if (isset($_POST[$variable])) {
    return $_POST[$variable];
  }
}

Function getPostVariable($variable) {
  if (isset($_POST[$variable]) && $_POST[$variable] !== '') {
    return $x = $_POST[$variable];
  }
  else { return $x = null; }
}

Function tester() {
$rv = "";
$rv .= "<SELECT name= ";
$rv .= ">\n";
//$rv .= "<OPTION value=\"\" >";
	//."</OPTION>\n";
$rv .= "<option value ='All'>All</option>\n";
$rv .= "</SELECT>\n";
  return $rv;

}

?>
