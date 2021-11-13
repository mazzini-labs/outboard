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
  //$this->_setNumPeriods();
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
  // get rid of leading zeros
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
  $this->numPeriods = count($this->periodStart);
}


/*Function _createPeriods() {
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
}*/

	//outboardPayroll takes two variables, $ob->getConfig('periodstart') & $ob->getLogEndDate()
	//first variable correlates to the outboard start date (2007-12-30) while getLogEndDate  
	//selects the last date outboard_log has recorded.
	//in timeclock, those values are then put into getCurrentPeriod()...which returns $name from the _createPeriods() function?
	//so $payperiod in timeclock = $name from _createPeriods() function
	
	
Function _createPeriods(){ //was _createSMPeriods(), changed for testing
	###

  list($year,$month,$day) = split("-","2008-01-01");
  // get rid of leading zeros;
  $month = $month * 1; 
  $day = $day * 1; 
  /*if (checkdate($month,$day,$year)) { 
    $this->startDate = mktime(0,0,0,$month,$day,$year);
  } else {
    $this->startDate = mktime(0,0,0,1,1,$this->currentYear);
  }
  */
	###
	$day = 60 * 60 * 24;
  $week = 60 * 60 * 24 * 7;   // sec * min * hours * days //weeks in seconds
	/*$dayconvert = date("d",$this->startDate);
	$dayconvert = $dayconvert * 1;
	$monthconvert = date("m",$this->startDate);
	$monthconvert = $monthconvert * 1;
	if ($dayconvert == 1) {
		$period = 60 * 60 * 24 * 15;
	} elseif ($dayconvert == 16) {
		if ($monthconvert == 1 || $monthconvert == 3 || $monthconvert == 5 || $monthconvert == 7 || $monthconvert == 8 || $monthconvert == 10 || $monthconvert == 12) {
			$period = 60 * 60 * 24 * 16;
		} else if ($monthconvert == 4 || $monthconvert == 6 || $monthconvert == 9 || $monthconvert == 11){
			$period = 60 * 60 * 24 * 15;
		} else if ($monthconvert = 2){
			$period = 60 * 60 * 24 * 14;
		}
	}
	*/
  $period = $week * $this->getConfig('timeperiod'); //period = weeks (in seconds) X timeperiod set in config file (2)
  										//in this case it's 1209600 seconds
  $numPeriods = floor(($this->endDate - $this->startDate) / $period); //number of periods = endDate - startDate / 1209600
  //trying to make number of periods 24 per year
  //$startYear = new Blar_DateTime($this->startDate);
  //$endYear = new Blar_DateTime($this->endDate);
  //$period = 24;	
  //$numPeriods = floor(($startYear->getAge($this->endDate)) * $period); //number of periods = endDate - startDate / 1209600

  $this->periodStart[] = date("Y-m-d",$this->startDate);
  $this->periodEnd[] = date("Y-m-d",$this->startDate + $period);
  for($i=1;$i<=$numPeriods;$i++) {
	  //$dateconvert = date("d",$this->startDate + ($period * $i));
		$dayconvert = date("d",$this->startDate + ($i)); //($period * $i));
		$dayconvert = $dayconvert * 1; 
		$monthconvert = date("m",$this->startDate + ($i));//($period * $i));
		$monthconvert = $monthconvert * 1;
		if ($dayconvert == 1) {
			$SMperiod = 60 * 60 * 24 * 15;
			$this->periodStart[] = date("Y-m-d",$this->startDate + ($SMperiod * $i));
			// 86400 is one day in seconds
			$this->periodEnd[] = date("Y-m-d",$this->startDate - 86400 + ($SMperiod * ($i + 1)));
		} elseif ($dayconvert == 16) {
			if ($monthconvert == 1 || $monthconvert == 3 || $monthconvert == 5 || $monthconvert == 7 || $monthconvert == 8 || $monthconvert == 10 || $monthconvert == 12) {
				$SMperiod = 60 * 60 * 24 * 17;
				$this->periodStart[] = date("Y-m-d",$this->startDate + ($SMperiod * $i));
				//$this->periodStart[] = date("Y-m-d", periodStart[$i] + ($SMperiod));
				//$this->periodEnd[] = date("Y-m-d",$this->startDate - 86400 + ($SMperiod * ($i + 1)));
				$this->periodEnd[] = date("Y-m-d",$this->startDate + ($SMperiod * ($i + 1)));

			} else if ($monthconvert == 4 || $monthconvert == 6 || $monthconvert == 9 || $monthconvert == 11){
				$SMperiod = 60 * 60 * 24 * 15;
				//$this->periodStart[] = date("Y-m-d", periodStart[$i] + ($SMperiod));

				$this->periodStart[] = date("Y-m-d",$this->startDate + ($SMperiod * $i));
				// 86400 is one day in seconds
				//$this->periodEnd[] = date("Y-m-d",$this->startDate - 86400 + ($SMperiod * ($i + 1)));
				$this->periodEnd[] = date("Y-m-d",$this->startDate + ($SMperiod * ($i + 1)));
			} else if ($monthconvert = 2){
				$SMperiod = 60 * 60 * 24 * 14;
				//$this->periodStart[] = date("Y-m-d", periodStart[$i] + ($SMperiod));

				$this->periodStart[] = date("Y-m-d",$this->startDate + ($SMperiod * $i));
				// 86400 is one day in seconds
				$this->periodEnd[] = date("Y-m-d",$this->startDate + ($SMperiod * ($i + 1)));
				//$this->periodEnd[] = date("Y-m-d",$this->startDate - 86400 + ($SMperiod * ($i + 1)));
			}
		}
	/*$this->periodStart[] = date("Y-m-d",$this->startDate + ($SMperiod * $i));
    // 86400 is one day in seconds
    $this->periodEnd[] = date("Y-m-d",$this->startDate - 86400 + ($SMperiod * ($i + 1)));*/
  }
	$today_date = date("Y-m-d");
  /*	list($cyear,$cmonth,$cday) = split("-",$today_date);
	//$this->periodStart[] = date("Y-m-d",mktime(0,0,0,1,1,2008));
	//$this->periodEnd[] = use same period calculation as above?
	//for($k=1;$k<=$numPeriods;$k++) {
		for($year;$year<=$cyear; $cyear++){
			for($j=1; $j<=31; $j++){
				for($i=1; $i<=31; $i++){
					if($i == 1){
					//$SMperiod = 60 * 60 * 24 * $i;
					//$this->periodStart[] = date("Y-m-d",$this->startDate + ($SMperiod * $i));
					//$this->periodEnd[] = date("Y-m-d",$this->startDate - 86400 + ($SMperiod * ($i + 1)));
					$this->periodStart[] = date("Y-m-d",mktime(0,0,0,$j,$i,$cyear));
					$this->periodStart[] = date("Y-m-d",mktime(0,0,0,$j,15,$cyear));
						
					}
					if ($i == 16) {
						$this->periodStart[] = date("Y-m-d",mktime(0,0,0,$j,$i,$cyear));
						
						if ($j == 1 || $j == 3 || $j == 5 || $j == 7 || $j == 8 || $j == 10 || $j == 12) {
						$this->periodEnd[] = date("Y-m-d",mktime(0,0,0,$j,31,$cyear));
							
						} else if ($j == 4 || $j == 6 || $j == 9 || $j == 11){
						$this->periodEnd[] = date("Y-m-d",mktime(0,0,0,$j,30,$cyear));
							
						} else if ($j = 2){
						$this->periodEnd[] = date("Y-m-d",mktime(0,0,0,$j,29,$cyear));
							
						}
						
					}		
				}
			}
		}
	//}
	*/
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
	

//}

  
  
  /*
  get start date
  get current date
  
  
  
  for ($i=1;$<=24;$i++){ //for 1st pay period to 24th pay period
  	//odd pay periods would start on first, even on 16th
	if($i % 2 == 0){
		//even
		//leapcheck = date(year but only last two digits)
		for ($leap)
		if current date day == 1 {
			periodStart[1]
			}
	} else {
		//odd
	
	}
	
  }
	*/
?>
