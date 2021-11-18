<?php
// namespace Outboard;
// OutboardTimeclock.php
//
// Calculates and displays timeclock information
//
// 2005-02-17	richardf - Introduced in, and updated for, OutBoard 2.0
// 2001-03-16	Richard F. Feuerriegel	(richardf@acesag.auburn.edu)
//

define("PROJECT_ROOT_PATH", $_SERVER['DOCUMENT_ROOT']);
require_once(PROJECT_ROOT_PATH . "/lib/OutboardConfig.php");
// require_once("lib/OutboardConfig.php");

class OutboardTimeclock extends OutboardConfig {

  private $forPDF = null;  // Boolean true if the output is for PDF.
  private $log = array();     // The log data array generated by $ob->getLogDataArray
  private $userid = null;  // The userid of the person for this calculation
  private $start = null;   // The start date for the calculation
  private $end = null;     // The end date for the calculation
  private $totalHoursWorked = null; 
  private $details = null; // The HTML output of the timeclock details;
  private $summary = null; // The HTML output of the timeclock summary;
  var $hours = null;
  var $minutes = null;
  var $seconds = null;
  var $num = null;
  var $dec = null;
  public function __construct($log,$userid,$start,$end) {
    parent::__construct();
    if ($log) $this->log = $log;
    $this->userid = $userid;
    $this->start = $start;
    $this->end = $end;
  }
  
  public function setPDF($boolean) {
    $this->forPDF = $boolean;
  }




public function getTotalHoursWorked() {
  return $this->totalHoursWorked;
}

public function getDetails() {
  return $this->details;
}

public function getSummary() {
  return $this->summary;
}


public function isIn($value) {
  if ($value == $this->getConfig('in')) 
  { 
    return true; 
  } 
  elseif ($value == $this->getConfig('rw'))
  {
    return true;
  }
  else 
  {
    return false;
  }
}


public function dateToName($datetime) {
  if ($this->isIn($datetime)) { 
    return "IN";
  } elseif ($datetime == $this->getConfig('out')) {
    return "OUT";
  } else {
    return $datetime;
  }
}




public function convertTime($dec)
{
    function lz($num) // lz = leading zero
    {
        return (strlen($num) < 2) ? "0{$num}" : $num;
    }
    // start by converting to seconds
    $seconds = ($dec * 3600);
    // we're given hours, so let's get those the easy way
    $hours = floor($dec);
    // since we've "calculated" hours, let's remove them from the seconds variable
    $seconds -= $hours * 3600;
    // calculate minutes left
    $minutes = floor($seconds / 60);
    // remove those from seconds as well
    $seconds -= $minutes * 60;
    // return the time formatted HH:MM:SS
    return lz($hours).":".lz($minutes).":".lz($seconds);
}


public function calculate() {

  $DEBUG = false;  // Set to 'true' to turn on debugging

  $rv = "";

  // 2004-04-05	richardf - added for Jonathan
  if ($this->start == "first") { $start = "0000-00-00"; }
  if ($this->end == "last") { $end = "2030-01-01"; }

  $work_count = 0;
  $time_first_in = "";

  //----------------------------------------------
  // Go through all the log data for this person
  //
  $total_time = 0;
  $work_time = array();
  $work_date = null;
  $work_start = null;
  $work_end = null;
  $day_first_in = null;
  $date_first_in = null;
  $time_first_in = null;
  $time_in_seconds = null;

  if (count($this->log) > 0) {
    foreach($this->log as $row) {
      $changetime = $row['changetime'];
      $timeinseconds = $row['timeinseconds'];
      $day = $row['day'];
      $changedate = $row['changedate'];
      $back = $row['back'];
      if ($this->isIn($back)) {                 // Is the dot IN?
        if ($time_first_in == "") {            // If it has not been IN yet:
          if ($DEBUG) { echo "[in]"; }
                $time_first_in = $changetime;
                $time_in_seconds = $timeinseconds;
                $day_first_in = $day;
                $date_first_in = $changedate;
        } else {                              // We have seen an IN already.
                if ($day != $day_first_in) {   // If not same day, Invalidate the time.
                if ($DEBUG) { echo "[in p.i]"; }
                $work_date[$work_count] = $date_first_in;
                $work_start[$work_count] = $time_first_in;
                $work_end[$work_count] = "?";
                $work_time[$work_count] = "0";
                $work_count++;
                $time_first_in = $changetime;
                $time_in_seconds = $timeinseconds;
                $day_first_in = $day;
                $date_first_in = $changedate;
          }
        }
      } else {                                // This is not an IN time.
        if ($time_first_in != "") {           // If the dot was IN already
          if ($day == $day_first_in) {   // and this is the same day:
                  $time_diff_seconds       = $timeinseconds - $time_in_seconds; // current - past
            $work_date[$work_count]  = $changedate;
            $work_start[$work_count] = $time_first_in;
            $work_end[$work_count]   = $changetime;
            $work_time[$work_count]  = sprintf("%4.2f",($time_diff_seconds / 60) / 60);
            $total_time += $work_time[$work_count];
            $work_count++;
          } else {
            $work_date[$work_count] = $date_first_in;
            $work_start[$work_count] = $time_first_in;
            $work_end[$work_count] = "?";
            $work_time[$work_count] = "0";
            $work_count++;
          }
          $time_first_in = "";                // Empty the temp variables
	        $day_first_in = "";                 // to start a new timing block.
          $date_first_in = "";
	        if ($DEBUG) { echo "[out]"; }
	      }
      }
    }

    $dec = $total_time; //total time in HH:MM:SS format
    $seconds = ($dec * 3600);
    $hours = floor($dec);
    $seconds -= $hours * 3600;
    $minutes = floor($seconds / 60);
    $seconds -= $minutes * 60;
    $seconds = floor($seconds);
    $hhmmss = $hours .":". $minutes .":". $seconds;

    if ($this->isIn($back)) {   // Catch a last record that is IN
      $currenttime = time();
      $time_diff_seconds       = $currenttime - $time_in_seconds; // current - past
      $work_date[$work_count] = $date_first_in;
      $work_start[$work_count] = $time_first_in;
      $work_end[$work_count] = "?";
      // $work_end[$work_count] = $time_in_seconds;
      $work_time[$work_count]  = sprintf("%4.2f",($time_diff_seconds / 60) / 60);
      // $work_time[$work_count] = "0";
    }

  } // 2004-03-29 - richardf
    // moved the table outside of the while loop so that it shows up even
    // for 0 hours.

    if ($this->forPDF) {
      $border = "1";
    } else {
      $border = "0";
    }

    //----------------------------------------------
    // Generate the table of time worked (summary)
    //
    if (! $this->forPDF) { 
      $rv .= "<div class='container'>\n";
    }
    $rv .= "<table class='table table-sm table-striped table-borderless table-hover caption-top' style='font-size:0.75rem;'><caption>Timeclock Summary</caption><thead class='thead-light'>";
    $rv .= "<th>Date</th>";
    $rv .= "<th>In</th>";
    $rv .= "<th>Out</th>";
    $rv .= "<th>Time</th>";
    $rv .= "</thead><tbody>\n";
    // in PHP8, count() requires that the $value is explicitly defined as an array [ so count(array($value)) ]
    // apparently not as that ran the for loop only once. removing it now allows for it to work.
    // lol okay so it works for the single user but not multi user?
    $arr_length = count($work_time);
    // for($i=0;$i<count($work_time);$i++) { 
    for($i=0;$i<$arr_length;$i++) { 
      
      $rv .= "<tr>";
      $rv .= "<td>" .date("M j, Y", strtotime($work_date[$i])) ."</td>";
      $rv .= "<td>" .date("g:i a", strtotime($work_start[$i])) ."</td>";
      $rv .= "<td>";
      ($work_end[$i] == '?') ? $rv .= /*date("g:i a", time())*/$work_end[$i] : $rv .= date("g:i a", strtotime($work_end[$i]));
      $rv .= "</td>";
      $rv .= "<td>";
      $rv .= $work_time[$i];
      $rv .= "</td>";
      $rv .= "</tr>\n";

    }
    $rv .= "</tbody><tfoot><tr>";
	  $rv .= "<td></td>";
    $rv .= "<td></td>";
    $rv .= "<td>Total:</td>";
    $rv .= "<td><strong>" . $total_time ." hours </strong></tr></td></tfoot>";

    $rv .= "</table>\n";
    $rv .= "</div>\n";



  $this->summary = $rv;

  $rv = ""; 

  $this->totalHoursWorked = $total_time; // = ($this->totalHoursWorked == 0) ? "0" : gmdate("g:i", floor($this->totalHoursWorked * 3600));

  //-----------------------------------------------
  // If we want details, show them
  //
  if (count($this->log) > 0) {
    reset($this->log);
	  $rv .= "<table class='table table-sm table-striped table-borderless table-hover' style='font-size:0.75rem;'><caption>Outboard Details</caption><thead>\n";
    $rv .= "<th>Date</th>";
    $rv .= "<th>Dot</th>";
    $rv .= "<th>Change</th>";
    $rv .= "<th>Remarks</th>";
    $rv .= "</thead>\n";
    $rowcount = 0;
    $previous_remarks = "";
    foreach($this->log as $row) {
      $rowcount++;
      if ($this->forPDF and ($rowcount > 20) and 0) {
        $rv .= "</TABLE><p>\n";
        $rv .= "<!--NewPage-->\n";
        $rv .= "<HR class=PAGE-BREAK>\n";
        $rv .= "Details continued...<p>\n";
        $rv .= "<TABLE BORDER=$border CELLPADDING=3 CELLSPACING=1>\n";
        $rv .= "<tr><th colspan=4>Outboard Details for ".$this->userid."</th></tr>\n";
        $rv .= "<tr>";
        $rv .= "<th>Date</th>";
        $rv .= "<th>Dot</th>";
        $rv .= "<th>Change</th>";
        $rv .= "<th>Remarks</th>";
        $rv .= "</tr>\n";
        $rowcount = 0;
      }
      $rv .= "<tr>";
      $rv .= "<td>".date("M j, Y", strtotime($row['changedate']))."</td>";
      $back = $this->dateToName($row['back']);
      if ($back != "IN" && $back != "OUT") {
        $back = $row['backtime'];
      } 
      $rv .= "<td>$back</td>";
      $rv .= "<td>".date("g:i a", strtotime($row['changetime']))."</td>";
      if ($row['remarks'] != $previous_remarks) { 
        $previous_remarks = $row['remarks'];
	      $row['remarks'] = htmlspecialchars($row['remarks']); 
        $rv .= "<td>".$row['remarks']."</td>";
      } else {
        $rv .= "<td><small>(no remark)</small></td>";
      }
      $rv .= "</tr\n";
    }
    $rv .= "</TD></TR></TABLE>\n";
  }
  $this->details = $rv;

  if ($this->details != "" and $this->summary != "") {
    return true;
  } else {
    return false;
  }
}

}

?>
