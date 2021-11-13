<?php

/**
 * OutboardPayroll.php
 *
 * Calculates payroll periods for use in the timeclock report.
 *
 * 2020-09-15  richardf - Updated for PHP7. 
 * 2005-02-17  Richard F. Feuerriegel (richardf@aces.edu)
 * 	- Initial creation
 *
 **/

require_once("lib/OutboardConfig.php");

class OutboardPayroll extends OutboardConfig {

private $currentYear = null; // Current year in "yyyy" format
private $numPeriods  = null; // The number of date periods we generated
private $startDate   = null; // UNIX timestamp to begin period calculations
private $endDate     = null; // UNIX timestamp to end period calculations
private $currentPeriod = null; // Current pay period string;
private $periodName  = Array(); // Array of the period names
private $periodStart = Array(); // Array of the dates for period beginnings
private $periodEnd   = Array(); // Array of the dates for period endings
                         // EXAMPLE: $periodStart[] = "2005-09-04";  
			 //          $periodEnd[]   = "2005-09-17";


///////////////////////////////////////////////////////////////////////////////////

public function __construct($startDate="",$endDate="") {
  parent::__construct();
  $this->currentYear = date("Y");
  $this->setStartDate($startDate);
  $this->setEndDate($endDate);
  $this->_createPeriods();
  //$this->_setNumPeriods();
}

public function getNumPeriods() {
  return $this->numPeriods;
}

public function getPeriodNames() {
  return $this->periodName;
}

public function getPeriodStartDate($number) {
  if (isset($this->periodStart[$number])) {
    return $this->periodStart[$number];
  } else {
    return null;
  }
}

public function getPeriodEndDate($number) {
  if (isset($this->periodEnd[$number])) {
    return $this->periodEnd[$number];
  } else {
    return null;
  }
}

public function setStartDate($date) {
  if ($date == "") { $date = "0000-00-00"; }
  list($year,$month,$day) = explode("-",$date);
  // get rid of leading zeros;
  $month = $month * 1; 
  $day = $day * 1; 
  if (checkdate($month,$day,$year)) { 
    $this->startDate = mktime(0,0,0,$month,$day,$year);
  } else {
    $this->startDate = mktime(0,0,0,1,1,$this->currentYear);
  }
}

public function getStartDate() {
  return $this->periodStart[0];
}

public function getEndDate() {
  $end = $this->numPeriods - 1;
  return $this->periodEnd[$end];
}

public function setEndDate($date) {
  if ($date == "") { $date = "0000-00-00"; }
  list($year,$month,$day) = explode("-",$date);
  // get rid of leading zeros;
  $month = $month * 1; 
  $day = $day * 1; 
  if (checkdate($month,$day,$year)) { 
    $this->endDate = mktime(0,0,0,$month,$day,$year);
  } else {
    $this->endDate = mktime(23,59,59,12,31,$this->currentYear + 1);
  }
}

// find the current pay period
public function getCurrentPeriod() {
  return $this->currentPeriod;
}

private function _setNumPeriods() {
  $this->numPeriods = count($this->periodStart);
}

private function _createPeriods() {
  $week = 60 * 60 * 24 * 7;   // sec * min * hours * days
  $period = $week * $this->getConfig('timeperiod');
  $numPeriods = floor(($this->endDate - $this->startDate) / $period);
  $this->periodStart[] = date("Y-m-d",$this->startDate);
  $this->periodEnd[] = date("Y-m-d",$this->startDate + $period);
  for($i=1;$i<=$numPeriods;$i++) {
    $this->periodStart[] = date("Y-m-d",$this->startDate + ($period * $i));
    // 86400 is one day in seconds
    $this->periodEnd[] = date("Y-m-d",$this->startDate - 86400 + ($period * ($i + 1)));
  }
  $today_date = date("Y-m-d");
  for($i=0;$i<=$numPeriods;$i++) {
    $name = $this->periodStart[$i]."|".$this->periodEnd[$i];
    $this->periodName[$name] = $this->periodStart[$i]." to ".$this->periodEnd[$i];
    if (! $this->currentPeriod 
	and $today_date >= $this->periodStart[$i] 
	and $today_date <= $this->periodEnd[$i]) {
      $this->currentPeriod = $name; 
    }
  }
}


}
