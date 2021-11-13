<?php

function pull_name_from_hash($select_name,$current_value,$option_hash,$choose_first=false,$js_fix=false) {
  $rv = "";
  $field_name = $select_name;
  if($js_fix) {
    $rv .= "<!-- javascript form field name fix -->"
          ."<INPUT TYPE=hidden NAME=\"js_fixed[$field_name]\" VALUE=\"$field_name\">";
  }
  $rv .= "<SELECT name=\"$field_name\" ";
  if (isset($option_hash['onChange'])) {
      $rv .= "onChange=\"" . $option_hash['onChange'] . "\"";
      unset($option_hash['onChange']);
  }
  $rv .= ">\n";
  $first_selected = "";
  if ($choose_first) { $first_selected = "SELECTED"; }
  $rv .= "<option value ='All'>All</option>\n";
  foreach ($option_hash as $key=>$value)
  // while ( list($key,$value) = each($option_hash) ) 
  {
    if (($key == $current_value) && ! $choose_first) {
      $selected = "SELECTED";
    } else {
      $selected = "";
    }
    $rv .= "<OPTION value=\"$key\" $selected $first_selected>"
          .htmlspecialchars($value)
          ."</OPTION>\n";
	
    $first_selected = "";
  }
  
  $rv .= "</SELECT>\n";
  return $rv;
}


function pullAll($s_name, $c_value, $o_hash){
	$f_name = $s_name;
  foreach ($o_hash as $key=>$c_value){
	// while ( list($key,$value) = each($option_hash) ) {
    if (($key == $c_value)) {
      $rv=$key;
    } else {
      $selected = "";
    }
  }
	return $rv;
}

function pull_date_from_hash($select_name,$current_value,$option_hash,$choose_first=false,$js_fix=false) {
  //need start date
	//need end date
	$rv = "";
  $field_name = $select_name;
  if($js_fix) {
    $rv .= "<!-- javascript form field name fix -->"
          ."<INPUT TYPE=hidden NAME=\"js_fixed[$field_name]\" VALUE=\"$field_name\">";
  }
	//
  $rv .= "<SELECT name=\"$field_name\" ";
  if (isset($option_hash['onChange'])) {
      $rv .= "onChange=\"" . $option_hash['onChange'] . "\"";
      unset($option_hash['onChange']);
  }
  $rv .= ">\n";
  $first_selected = "";
  if ($choose_first) { $first_selected = "SELECTED"; }
  $rv .= "<option value ='All'>All</option>\n";
  foreach ($option_hash as $key=>$value){
  // while ( list($key,$value) = each($option_hash) ) {
    if (($key == $current_value) && ! $choose_first) {
      $selected = "SELECTED";
    } else {
      $selected = "";
    }
    $rv .= "<OPTION value=\"$key\" $selected $first_selected>"
          .htmlspecialchars($value)
          ."</OPTION>\n";
	
    $first_selected = "";
  }
  
  $rv .= "</SELECT>\n";
  return $rv;
}

?>
