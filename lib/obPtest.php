<?php

/**
 * OutboardPayroll.php
 *
 * Calculates payroll periods for use in the timeclock report.
 *
 * 2005-02-17  Richard F. Feuerriegel (richardf@aces.edu)
 * 	- Initial creation
 *
 **/

require_once("lib/OutboardConfig.php");

Class OutboardPayroll extends OutboardConfig {

var $currentYear = null; // Current year in "yyyy" format
var $numPeriods  = null; // The number of date periods we generated
var $startDate   = null; // UNIX timestamp to begin period calculations
var $endDate     = null; // UNIX timestamp to end period calculations
var $currentPeriod = null; // Current pay period string;
var $periodName  = Array(); // Array of the period names
var $periodStart = Array(); // Array of the dates for period beginnings
var $periodEnd   = Array(); // Array of the dates for period endings
                         // EXAMPLE: $periodStart[] = "2005-09-04";  
			 //          $periodEnd[]   = "2005-09-17";


///////////////////////////////////////////////////////////////////////////////////

Function OutboardPayroll($startDate="",$endDate="") {
  $this->OutboardConfig();
  $this->currentYear = date("Y");
  $this->setStartDate($startDate);
  $this->setEndDate($endDate);
  $this->_createPeriods();
  $this->_setNumPeriods();
}

Function getNumPeriods() {
  return $this->numPeriods;
}

Function getPeriodNames() {
  return $this->periodName;
}

Function getPeriodStartDate($number) {
  if (isset($this->periodStart[$number])) {
    return $this->periodStart[$number];
  } else {
    return null;
  }
}

Function getPeriodEndDate($number) {
  if (isset($this->periodEnd[$number])) {
    return $this->periodEnd[$number];
  } else {
    return null;
  }
}

Function setStartDate($date) {
  if ($date == "") { $date = "0000-00-00"; }
  list($year,$month,$day) = split("-",$date);
  // get rid of leading zeros;
  $month = $month * 1; 
  $day = $day * 1; 
  if (checkdate($month,$day,$year)) { 
    $this->startDate = mktime(0,0,0,$month,$day,$year);
  } else {
    $this->startDate = mktime(0,0,0,1,1,$this->currentYear);
  }
}

Function getStartDate() {
  return $this->periodStart[0];
}

Function getEndDate() {
  $end = $this->numPeriods - 1;
  return $this->periodEnd[$end];
}

Function setEndDate($date) {
  if ($date == "") { $date = "0000-00-00"; }
  list($year,$month,$day) = split("-",$date);
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
Function getCurrentPeriod() {
  return $this->currentPeriod;
}

Function _setNumPeriods() {
  return $this->numPeriods = count($this->periodStart);
}

Function _createPeriods(){ 
  $sdate = date("Y-m-d",$this->startDate);
  list($year,$month,$day) = split("-",$sdate);
  $syear = $year;
  $smonth = $month * 1; 
  $sday = $day * 1; 
  $week = 60 * 60 * 24 * 7;   
  $period = $week * $this->getConfig('timeperiod'); 
  $numPeriods = floor(($this->endDate - $this->startDate) / $period); 
  $this->periodStart[] = date("Y-m-d",$this->startDate);
  $this->periodEnd[] = date("Y-m-d",$this->startDate + $period);
  $today_date = date("Y-m-d");
  list($cyear,$cmonth,$cday) = split("-",$today_date);
  
  $edate = date("Y-m-d",$this->endDate);
  list($eyear,$emonth,$eday) = split("-",$edate);
  $emonth = $emonth * 1; 
  $eday = $eday * 1; 
  
  //$endloop = date("Y-m-d",mktime(0,0,0,$emonth,$eday,$eyear));
 //do{
	for($year;$year<=$eyear;$year++){
	  $leapcheck = date("y",$eyear);
	  for($smonth;$smonth<=$emonth;$smonth++){
		  for($i=1;$i<=31;$i++){
			  //if($smonth < $month && $year == $syear) {$smonth = $month;}
			  //if($smonth == $emonth) { break; }
			  //if($endloop < $this->periodEnd[]) { goto bar;}
			  //if($i > $eday && $smonth > $emonth && $year == $eyear){ break; }
			  if($i == 1){
			    $this->periodStart[] = date("Y-m-d",mktime(0,0,0,$smonth,$i,$year));
			    $this->periodEnd[] = date("Y-m-d",mktime(0,0,0,$smonth,15,$year));
				//$checkloop = $this->periodEnd[];
			  }
			  if ($i == 16) {
				  $this->periodStart[] = date("Y-m-d",mktime(0,0,0,$smonth,$i,$year));

				  if ($smonth == 1 || $smonth == 3 || $smonth == 5 || $smonth == 7 || $smonth == 8 || $smonth == 10 || $smonth == 12) {$this->periodEnd[] = date("Y-m-d",mktime(0,0,0,$smonth,31,$year));}
				  else if ($smonth == 4 || $smonth == 6 || $smonth == 9 || $smonth == 11){$this->periodEnd[] = date("Y-m-d",mktime(0,0,0,$smonth,30,$year));}						
				  else if ($smonth == 2){
					  if($cyear %4 == 0) {$this->periodEnd[] = date("Y-m-d",mktime(0,0,0,$smonth,29,$year));}
					  elseif($cyear %4 != 0){$this->periodEnd[] = date("Y-m-d",mktime(0,0,0,$smonth,28,$year));}
				  }  
			  }		
		  }
	  }
  }
//} while($endloop < $this->periodEnd[]);
	//bar:
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

?>
