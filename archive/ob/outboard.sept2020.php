<?php include 'lib/ob.php'; ?>
<html>
<head>
  <title>OutBoard: <?php echo $ob->getConfig('board_title') ?></title> 
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
  <link rel="stylesheet" type="text/css" href="css/util.css">
  <link rel="stylesheet" type="text/css" href="css/maintest.css?=v1.2">
  <!-- Bootstrap core CSS -->
  <link href="WSB/stylesheet/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="WSB/stylesheet/offcanvas.css?v1" rel="stylesheet">
  <script Language="JavaScript">
    function openWindow( window_name, url, width, height ) {
      locX = (screen.width / 2) - (width / 2);
      locY = (screen.height / 2) - (height / 2);
      window_name = window.open(url, window_name,
        "dependent=yes,resizable=yes,scrollbars=yes,screenX=" + locX
        + ",screenY=" + locY + ",width=" + width + ",height=" + height);
      window_name.focus();
    }
    function myReload() {
      self.location = "<?php echo $baseurl ?>?noupdate=1";
    }
    t = setTimeout("myReload()",<?php echo $update_msec ?>);
  </script>

  <?php if ($launch = getGetValue('launch')) { ?>
    <Script Language="JavaScript"> window.focus(); </Script>
  <?php } ?>
  <style>
    #container {
      position: relative;
      width: 600px;
      height: 400px;
    }
  </style>
  <link rel="stylesheet" href="css/perfect-scrollbar.css">
  <script src="dist/perfect-scrollbar.js"></script>
  <script>
    const container = document.querySelector('#container');
    const ps = new PerfectScrollbar(container);
    ps.update();
    // or just with selector string
    const ps = new PerfectScrollbar('#container');
    const container = document.querySelector('#container');
    container.scrollTop = 0;
  </script>
  <style type="text/css">
    /* body {
      overflow: hidden; /* Hide scrollbars */
    /* } */ 
    /* .table-fixed tbody {
        height: 700px;
        overflow-y: auto;
        width: 100%;
    }

    .table-fixed thead,
    .table-fixed tbody,
    .table-fixed tr,
    .table-fixed td,
    .table-fixed th {
        display: block;
    }

    .table-fixed tbody td,
    .table-fixed tbody th,
    .table-fixed thead > tr > th {
        float: left;
        position: relative;

        &::after {
            content: '';
            clear: both;
            display: block;
        }
    } */

    /* body {
      padding-top: 56px;
    } */
    td.user {    

    background-color: #3e94ec;
    //color: ffffff;

      }
    #outboard{
    //  background-color: #3e94ec;
    //  background-color: #6699cc;
      font-family: "Roboto", "Trebuchet MS", Arial, Helvetica, sans-serif;
      font-size: 14px;
      text-rendering: optimizeLegibility;
      border-collapse: collapse;
      border-left: 1px solid #3e94ec;
      border-radius: 30px;
      width: 100%;
      font-weight: normal;
      text-shadow: 0 1px 1px rgba(256, 256, 256, 0.1);
      box-shadow:  0 6px 20px 0 rgba(0, 0, 0, 0.19);
      text-align: left;
    }

    #outboard td, #outboard th {
      
      border-style: solid;
      border-width: 0px 2px 0px 2px;
      border-color: #343a40;
      text-align: center;
    }


    #outboard tr:nth-child(even){background-color: #f0f0f0;}
    #outboard tr:nth-child(odd){background-color: #ffffff;}



    #outboard th {
      padding-top: 12px;
      padding-bottom: 12px;

      background-color: #343a40;
      //border-radius: 8px;  
      color: white;
    }

    #header {
      font-family: Roboto, "Trebuchet MS", Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 70%;
      top:80;
    }

    #header {
      padding-top: 1px;
      padding-bottom: 1px;
      text-align: left;
      color: #000000;
    }
    h1.thick {
    text-align: center;
    font-weight: bold;
    }
    div {
      /* display: flex; */
      justify-content: flex-end;
      align-items: flex-end;
    }
    .fixed-under-top{
      /* position:fixed; */
      top:100;
      
      /* width:70%; */
      /*right:-800;
      left:400;*/
      }
    .table-collapse {
        position: fixed;
        top: 56px; /* Height of navbar */
        bottom: 0;
        width: 100%;
        padding-right: 1rem;
        padding-left: 1rem;
        /* overflow-y: auto; */
        background-color: var(--gray-dark);
        transition: -webkit-transform .3s ease-in-out;
        transition: transform .3s ease-in-out;
        transition: transform .3s ease-in-out, -webkit-transform .3s ease-in-out;
        -webkit-transform: translateX(100%);
        transform: translateX(100%);
      }
    .sticky-table {
      /* position: fixed; */
      top: 25%;
      width: 100%;
    }

    .sticky-table + .content {
      padding-top: 95px;
    }
      
      .col-ob-2, .col-ob-8, .col-ob-12, .col-ob-55 {
      position: relative;
      
      min-height: 1px;
      padding-right: 15px;
      padding-left: 15px;
    }
      .col-ob-2 {
      -ms-flex: 0 0 2%;
          flex: 0 0 2%;
      max-width: 2%;
    }

    .col-ob-8 {
      -ms-flex: 0 0 8%;
          flex: 0 0 8%;
      max-width: 8%;
    }

    .col-ob-12 {
      -ms-flex: 0 0 12%;
          flex: 0 0 12%;
      max-width: 12%;
    }

    .col-ob-55 {
      -ms-flex: 0 0 55%;
          flex: 0 0 55%;
      max-width: 55%;
    }

  </style>
</head>
<body>

<script language="JavaScript1.2">
  function change_remark(remark,userid) {
    var newremark = prompt("Enter your remarks below:");
    if (newremark != null) {
      self.location="<?php echo $baseurl ?>?remarks="
		    + escape(newremark) + "&userid=" +userid + "#<?php echo $userid ?>";
    }
  }
  
</script>
<div style="display:flex;position:fixed;right:25;bottom:25;left:0;z-index:1030"> 
  <?php if (! $update && ! $readonly) { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      <strong>You are now in view only mode.</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  <!-- <div class="alert alert-primary" role="alert">  You are now in view only mode</div> -->
  <?php } elseif (! $readonly) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>You are now in update mode.</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?php } else { echo "&nbsp;"; } ?>
</div>
<!-- top of page header w/logo-->
<div class="limiter">
  <?php include 'include/header_extensions.php'; ?>
  <div class=container-outboard100>
    <div class="card text-white bg-dark mb-3 justify-content-center" style="width:70%;">
      <div class="card-body" style="width:70%;display:contents;">
        <table class="fixed-under-top" BORDER=0 WIDth=100% ALIGN=CENTER>
          <tr>
            <td CLASS=back>
              <table class="sticky-header" ID=outboard BORDER=0 WIDth=95% ALIGN=CENTER>
                <tr>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th colspan=10>Will return by this time:</th>
                  <th></th>
                  <th>Business Hours: 8AM-5PM</th>
                </tr>
                <?php  
                $header = 
                "<tr>
                  <th>Name</th>
                  <th>Core Hours</th>
                  <th>In</th>
                  <th>8</th>
                  <th>9</th>
                  <th>10</th>
                  <th>11</th>
                  <th>12</th>
                  <th>1</th>
                  <th>2</th>
                  <th>3</th>
                  <th>4</th>
                  <th>5</th>
                  <th>Out</th>
                  <th>Remarks</th>
                </tr>";
                //echo $header;
                // Get the latest outboard information from the database
                $ob->getData();

                $rowcount = 0;
                $zebra = 0;
                $username = urlencode($username);

                while($row = $ob->getRow()) {
                  $isChangeable = $ob->isChangeable($row['userid']);
                  $row['userid'] = urlencode($row['userid']);
                  if (! preg_match("/<READONLY>/",$row['options'])) {
                    $datetime = getdate($row['back']);
                    if ($row['last_change'] != "") {
                      list($uname,$ip) = explode(",",$row['last_change']);
                      $lastup = "Last updated by $uname from $ip on " .  $row['timestamp'] . "";
                      $alt = "ALT=\"$lastup\" TITLE=\"$lastup\"";
                    } else {
                      $alt = "";
                    }
                    $in = "<img src=$image_dir/$in_image $alt>";
                    //$in = "<th style = 'background-color: #00FF00; height: '10px';'>";
                    if ($datetime['year'] > $current['year']) {
                      $out = "<img src=$image_dir/$out_image $alt>";
                      if ($update && $isChangeable) {
                      $in= "<a href=\"$baseurl?in=1&userid=".$row['userid']."#".$row['userid']."\">"
                          ."<img src=$image_dir/$empty_image BORDER=0></a>";
                      } else {
                      $in= "<img src=$image_dir/$empty_image>";
                      }
                    } else {
                      if ($update && $isChangeable) {
                      $out= "<a href=\"$baseurl?out=1&userid=".$row['userid']."#".$row['userid']."\">"
                          ."<img src=$image_dir/$empty_image BORDER=0></a>";
                      } else {
                      $out= "<img src=$image_dir/$empty_image>";
                      }
                    }
                  for ($i = 8; $i <= 17; $i++) {
                    if ( $datetime['hours'] == $i ) {
                      $back[$i] = "<img src=$image_dir/$dot_image $alt>";
                      // $back[$i] = "<th style = 'background-color: #00FF00; height: '10px';'>";
                      if ($update && $isChangeable) {
                      $in= "<a href=\"$baseurl?in=1&userid=".$row['userid']."#".$row['userid']."\">"
                      ."<img src=$image_dir/$empty_image BORDER=0></a>";
                      } else {
                      $in= "<img src=$image_dir/$empty_image>";
                      }
                    } else {
                      if ($update && $isChangeable) {
                      $back[$i] = "<a href=\"$baseurl?return=$i&userid=".$row['userid']."#".$row['userid']."\">"
                        ."<img src=$image_dir/$empty_image BORDER=0></a>";
                      } else {
                      $back[$i] = "<img src=$image_dir/$empty_image>";
                      }
                    }
                  }
                  if ($ob->getConfig('zebra_stripe') != 0) {
                    if ($rowcount % $ob->getConfig('zebra_stripe') == 0) {
                      if ($zebra == 1) { $zebra = 2; } else { $zebra = 1; }
                    }
                    $user_bg = "class=zebra".$zebra;
                  } else {
                    $user_bg = "";
                  }
                  if ($row['userid'] == $username && $update && $isChangeable) {
                    $user_bg = "class=user";
                  }
                    if ($rowcount % $ob->getConfig('reprint_header') == 0) { echo $header; }
                    echo "<tr class=norm>";
                    echo "<td WIDth=8% $user_bg><A class=\"nobr\" name=\"".$row['userid']."\">".$row['name']."</A></td>";
                    echo "<td WIDth=12% $user_bg><A class=\"nobr\" name=\"".$row['userid']."\">".$row['hours']."</A></td>";
                    echo "<td WIDth=2% $user_bg>$in</td>";
                    echo "<td WIDth=2% $user_bg>".$back['8']."</td>";
                    echo "<td WIDth=2% $user_bg>".$back['9']."</td>";
                    echo "<td WIDth=2% $user_bg>".$back['10']."</td>";
                    echo "<td WIDth=2% $user_bg>".$back['11']."</td>";
                    echo "<td WIDth=2% $user_bg>".$back['12']."</td>";
                    echo "<td WIDth=2% $user_bg>".$back['13']."</td>";
                    echo "<td WIDth=2% $user_bg>".$back['14']."</td>";
                    echo "<td WIDth=2% $user_bg>".$back['15']."</td>";
                    echo "<td WIDth=2% $user_bg>".$back['16']."</td>";
                    echo "<td WIDth=2% $user_bg>".$back['17']."</td>";
                    echo "<td WIDth=2% $user_bg>$out</td>";
                    if ($row['remarks'] == "") {
                      if ($update) {
                      $print_remarks = "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; "
                      ."&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; "
                      ."&nbsp; &nbsp; &nbsp; &nbsp;";
                      } else {
                      $print_remarks = "&nbsp;";
                      }
                    } else {
                      $visible = trim_visible($row['remarks'],$max_visible_length);
                      if ($visible != $row['remarks']) {
                      $rem = $row['remarks'];
                        $alt = "ALT=\"$rem\" TITLE=\"$rem\"";
                      $print_remarks = htmlspecialchars($visible)
                                    . "<img src=$image_dir/$right_arrow BORDER=0 $alt>";
                      } else {
                      $print_remarks = htmlspecialchars($visible);
                      }
                    }
                    if ($update && $isChangeable) {
                      echo "<td width='55%' $user_bg'><a href=\"javascript:this.change_remark('"
                      . addslashes(htmlspecialchars($row['remarks']))
                      . addslashes($row['remarks'])
                      . "','".$row['userid']."')\">$print_remarks</a></td>";
                    } else {
                      echo "<td width='55%' $user_bg'>$print_remarks</td>";
                    }
                    echo "</tr>\n";
                  $rowcount++;
                  } // end if
                } // end while
                //*/
                ?>
          
                <tr>
                  <th>Name</th>
                  <th>Hours</th>
                  <th>In</th>
                  <th>8</th>
                  <th>9</th>
                  <th>10</th>
                  <th>11</th>
                  <th>12</th>
                  <th>1</th>
                  <th>2</th>
                  <th>3</th>
                  <th>4</th>
                  <th>5</th>
                  <th>Out</th>
                  <th>Remarks</th>
                </tr>
                <tr>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th colspan=10>Will return by this time:</th>
                  <th></th>
                  <th>Business Hours: 8AM-5PM</th>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>
<script src="WSB/stylesheet/jquery-3.2.1.slim.min.js.download" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
<script src="WSB/stylesheet/popper.min.js.download"></script>
<script src="WSB/stylesheet/bootstrap.min.js.download"></script>
<script src="WSB/stylesheet/holder.min.js.download"></script>
<script src="WSB/stylesheet/offcanvas.js.download"></script>
  

<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" preserveAspectRatio="none" style="display: none; visibility: hidden; position: absolute; top: -100%; left: -100%;"><defs><style type="text/css"></style></defs><text x="0" y="2" style="font-weight:bold;font-size:2pt;font-family:Arial, Helvetica, Open Sans, sans-serif">32x32</text></svg></body></html>
<!-- Modal --><!--TODO: Code Javascript to make modal work-->
<!-- <div class="modal fade" id="remarkModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Remarks</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <textarea class="form-control" id="message-text"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div> -->
<!-- Modal --><!--TODO: Code Javascript to make modal work-->
</body>
</html>