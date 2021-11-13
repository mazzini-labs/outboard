<?php

// Simple function to find out what Operating System the user has. This is
// important because the Helvetica font on Unix is a lot smaller than the
// Helvetica/Arial font on MS-Windows, and thus we have to make up for it.

Function get_os() {
  Global $HTTP_USER_AGENT;
  $user_agent = $HTTP_USER_AGENT;
  $os = "win";
  if(preg_match("/Win/",$user_agent)) { $os = "win"; }
  elseif(eregi("linux",$user_agent)) { $os = "unix"; }
  elseif(eregi("unix",$user_agent)) { $os = "unix"; }
  return $os;
}

// Set the base font size to 10 on windows and 12 on Unix/Linux
if (get_os() == "win") { $bfs = $windows_bfs; } else { $bfs = $unix_bfs; }

if (get_os() == "win") { 
  $font_family = $roboto;
} else {
  $font_family = $unix_font_family;
}

?>

<STYLE>
//  body { font-family: <?php echo $font_family ?>; 
//         font-size: <?php echo $bfs ?>pt; 
//	 background-color: <?php echo $body_bg ?>;}
//  th { font-family: <?php echo $font_family ?>; 
//       font-size: <?php echo $bfs ?>pt; 
//       font-weight: bold; }
//  td { 
//     font-family: <?php echo $font_family ?>; 
//     font-size: <?php echo $bfs ?>pt; 
//     color: <?php echo $td_text ?>;
//     background-color: #3e94ec;
//     background-color: #c850c0;
//     background-color: #4158d0;
//     background-color: #000000;
//
//  }
  td.zebra1 {
	  background-color: #ffffff;
 }
  td.zebra2 {
	  background-color: #f0f0f0;
  }

/*  tr {
     font-family: <?php echo $font_family ?>; 
     font-size: <?php echo $bfs ?>pt; 
  }*/
//  tr.norm {
//	 background-color: #3e94ec;
//     background-color: <?php echo $td_bg ?>; 
//  }
  td.user {
//     background-color: <?php echo $td_user_bg ?>; 
/*  background: -webkit-linear-gradient(-135deg, #3e94ec, #000080);
  background: -o-linear-gradient(-135deg, #3e94ec, #000080);
  background: -moz-linear-gradient(-135deg, #3e94ec, #000080);
  background: linear-gradient(-135deg, #3e94ec, #000080);
*/
background-color: #000080;  
color: white;

  }
//  td.small {
//     font-size: <?php echo $bfs - 2 ?>pt; 
//     background-color: <?php echo $body_bg ?>; 
//  }
//  td.header { 
//     font-size: <?php echo $bfs ?>pt; 
//     font-weight: bold; 
//	 background-color: #4158d0;

//     background-color: <?php echo $body_bg ?>;
//  }
//  td.headernb { 
//     font-size: <?php echo $bfs ?>pt; 
//     background-color: <?php echo $body_bg ?>;
//  }

//  td.back { background-color: <?php echo $body_bg ?>;}
//	    box-radius: 50px; }
//  td.back { background-color: #4158d0;
//	    box-radius: 25px; }
//  A:link  { font-family: <?php echo $font_family ?>;  
//	    text-decoration: none; 
//	    color: <?php echo $link_text ?>}
//  .blue { color: #0000FF; }
//  .nobr { white-space: nowrap; }
//  A:visited  { font-family: <?php echo $font_family ?>;
//	       text-decoration: none; 
//	       color: <?php echo $link_text ?>}
  //A:hover  { font-family: <?php echo $font_family ?>; 
  //           text-decoration: underline; 
  //	     color: <?php echo $link_text ?>}
</STYLE>
