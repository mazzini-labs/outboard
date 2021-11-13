<?php
// Timesheet generation script for an HTML->PDF converter
//
// 2005-02-17 richardf - introduced and updated for OutBoard 2.0
// 2001-03-16 Richard F. Feuerriegel (richardf@acesag.auburn.edu)


$date = date("l, F dS Y, h:i:s A");
// $style_sheet = join('',file("include/reportstylesheet.php"));
// $style_sheet = join('',file("dependencies.php"));
$filename = "timesheet_for_${userid}_by_${username}";
$tmpfname = $ob->getConfig('temp_dir').$filename;
$fd = fopen($tmpfname,"w");
$summary_timeclock = $timearray['summary'];
$board = $ob->getConfig('board_title');

// fputs($fd,"<HTML>");
// fputs($fd,"<HEAD>");
// fputs($fd,$style_sheet);
// fputs($fd,"<TITLE>Timesheet for $userHash[$userid]</TITLE>");
// fputs($fd, '<style type="text/css">
//     h3 {
//       text-align: center;
//     }
//     .receipt {
//       height: 8.5in;
//       width: 33%;
//       float: left;
//       border: 1px solid black;
//     }
//     .output {
//       height;
//       8.5in;
//       width: 11in;
//       border: 1px solid red;
//       position: absolute;
//       top: 0px;
//       left: 0px;
//     }
//     @media print {
//       .output {
//         -ms-transform: rotate(270deg);
//         /* IE 9 */
//         -webkit-transform: rotate(270deg);
//         /* Chrome, Safari, Opera */
//         transform: rotate(270deg);
//         top: 1.5in;
//         left: -1in;
//       }
//     }
//   </style>');
// fputs($fd,"</HEAD>");
fputs($fd,"<style>@media print {
  #backButtonArea {
    display: none;
  }
}
@media print {
  .container {
    width: auto;
  }
}
@media print {
  .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
       float: left;
  }
  .col-sm-12 {
       width: 100%;
  }
  .col-sm-11 {
       width: 91.66666667%;
  }
  .col-sm-10 {
       width: 83.33333333%;
  }
  .col-sm-9 {
       width: 75%;
  }
  .col-sm-8 {
       width: 66.66666667%;
  }
  .col-sm-7 {
       width: 58.33333333%;
  }
  .col-sm-6 {
       width: 50%;
  }
  .col-sm-5 {
       width: 41.66666667%;
  }
  .col-sm-4 {
       width: 33.33333333%;
  }
  .col-sm-3 {
       width: 25%;
  }
  .col-sm-2 {
       width: 16.66666667%;
  }
  .col-sm-1 {
       width: 8.33333333%;
  }
}
</style>");
fputs($fd,"<div class='justify-content-center mx-auto'>");
fputs($fd, "<div class='output'>");
fputs($fd,"<CENTER>");
fputs($fd,"<TABLE class='table'>");
fputs($fd,"<TR>");
fputs($fd,"<TD class='px-5'>");
fputs($fd,"<H3>$board<br>Timeclock Report for: <u>$userHash[$userid]</u></H3>");
fputs($fd,"<H4>$date</H4>");
fputs($fd,"</TD>");
fputs($fd,"<TD class='px-5'>");
fputs($fd,"<b>Pay period:</b><br>Start: $paystart<br>End: $payend");
fputs($fd,"</TD>");
fputs($fd,"</TR>");
fputs($fd,"</TABLE>");
fputs($fd,"</CENTER>");

fputs($fd,"<hr>");

fputs($fd,"<div class='row justify-content-center'><div class='col-auto'>");
fputs($fd,"<table class='table table-borderless'>");
fputs($fd,"<TR><TD VALIGN=TOP COLSPAN=2>&nbsp;</TD></TR>");
fputs($fd,"<TR>");
  fputs($fd,"<TD class='w-75'>");
// fputs($fd, "<div class='container-fluid'>");
// fputs($fd, "<div class='row'>");
// fputs($fd, "<div class='col-4'>");
  fputs($fd,$summary_timeclock);
  fputs($fd,"</TD>");
  fputs($fd, "</div>");
  fputs($fd,"<TD class='w-25 px-5'>");
  // fputs($fd, "<div class='col-8'>");
  fputs($fd,"<h2>Total hours calculated: <u>".sprintf("%4.2f",$totalHoursWorked)."</u></h2>");
  fputs($fd,"<h2>Hours to be paid: <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></h2>"); 
  fputs($fd,"&nbsp;"); 
  fputs($fd,"Employee Signature:_______________________________________ Date:_____________");
  fputs($fd,"<br>");
  fputs($fd,"Supervisor Signature:_______________________________________ Date:_____________");
  fputs($fd,"<br>"); 
  fputs($fd,"NOTES:<br>");
  fputs($fd,"______________________________________________________________________<br>");
  fputs($fd,"______________________________________________________________________<br>");
  fputs($fd,"______________________________________________________________________<br>");
  fputs($fd,"______________________________________________________________________<br>");
  fputs($fd,"______________________________________________________________________<br>");
  fputs($fd,"______________________________________________________________________<br>");
  fputs($fd,"</TD>");
fputs($fd,"</TR>");
// fputs($fd, "</div></div></div>");
fputs($fd,"<TR><TD VALIGN=TOP COLSPAN=2>&nbsp;</TD></TR>");
fputs($fd,"</TABLE>");
fputs($fd,"</div></div>");
fputs($fd, "</div>");
/* This doesn't look right in the PDF
fputs($fd,"<TABLE BORDER=0 width=100%>");
fputs($fd,"<TR>");
  fputs($fd,"<TD VALIGN=TOP ALIGN=CENTER COLSPAN=2>");
  //fputs($fd,"<!--NewPage-->\n");
  //fputs($fd,"<HR class=PAGE-BREAK>\n");
  fputs($fd,$details_timeclock);
  fputs($fd,"</TD>");
fputs($fd,"</TR>");
fputs($fd,"</TABLE>");
*/


fputs($fd,"</div>");
fputs($fd,"<div id='backButtonArea' class='col'><hr><div class='row'><h6 class='text-monospace text-muted mx-auto'>Note: The printable area is above the line</h6></div><div class='row mt-5'>");
fputs($fd,"<div class='mx-auto'><button class='btn btn-primary' id='backButton' onClick='window.location.reload();'>Back to Timeclock Report</button>");
fputs($fd,"</div></div></div>");
// fputs($fd,"</HTML>");
fclose($fd);

if ($url = $ob->getConfig('pdf_writer')) {
  $key =  $ob->getConfig('pdf_writer_key');
  header("Location: ${url}?filename=".basename($tmpfname)."&key=${key}");
} else {
  echo join('',file($tmpfname));
}

?>
