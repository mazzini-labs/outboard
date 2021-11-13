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
  list($year,$month,$day) = preg_split("/-/",$date);
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
  list($year,$month,$day) = preg_split("/-/",$date);
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

public function _setNumPeriods() {
  return $this->numPeriods = count($this->periodStart);
}

public function _createPeriods(){ 
  $sdate = date("Y-m-d",$this->startDate);
  list($year,$month,$day) = preg_split("/-/",$sdate);
  $syear = $year;
  $month = $month * 1; 
  $day = $day * 1; 
  $week = 60 * 60 * 24 * 7;   
  $period = $week * $this->getConfig('timeperiod'); 
  $numPeriods = floor(($this->endDate - $this->startDate) / $period); 
  $this->periodStart[] = date("Y-m-d",$this->startDate);
  $this->periodEnd[] = date("Y-m-d",$this->startDate + $period);
  $today_date = date("Y-m-d");
  list($cyear,$cmonth,$cday) = preg_split("/-/",$today_date);
  
  list($eyear,$emonth,$eday) = preg_split("/-/",$this->endDate);
  $emonth = $emonth * 1; 
  $eday = $eday * 1; 
  $endloop = date("Y-m-d",mktime(0,0,0,$emonth,$eday,$eyear));
 //do{
	for($year;$year<=$cyear;$year++){
	  $leapcheck = date("y",$cyear);
	  for($j=1;$j<=12;$j++){
		  for($i=1;$i<=31;$i++){
			  if($j < $month && $year == $syear) {$j = $month;}
			  //if($j == $emonth) { break; }
			  //if($endloop < $this->periodEnd[]) { goto bar;}
			  //if($i > $eday && $j > $emonth && $year == $eyear){ break; }
			  if($i == 1){
			    $this->periodStart[] = date("Y-m-d",mktime(0,0,0,$j,$i,$year));
			    $this->periodEnd[] = date("Y-m-d",mktime(0,0,0,$j,15,$year));
				//$checkloop = $this->periodEnd[];
			  }
			  if ($i == 16) {
				  $this->periodStart[] = date("Y-m-d",mktime(0,0,0,$j,$i,$year));

				  if ($j == 1 || $j == 3 || $j == 5 || $j == 7 || $j == 8 || $j == 10 || $j == 12) {$this->periodEnd[] = date("Y-m-d",mktime(0,0,0,$j,31,$year));}
				  else if ($j == 4 || $j == 6 || $j == 9 || $j == 11){$this->periodEnd[] = date("Y-m-d",mktime(0,0,0,$j,30,$year));}						
				  else if ($j == 2){
					  if($cyear %4 == 0) {$this->periodEnd[] = date("Y-m-d",mktime(0,0,0,$j,29,$year));}
					  elseif($cyear %4 != 0){$this->periodEnd[] = date("Y-m-d",mktime(0,0,0,$j,28,$year));}
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
