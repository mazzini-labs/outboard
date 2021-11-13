<!-- $uri = $_SERVER['REQUEST_URI']; -->
<style>
.fab-ob {
  bottom: 45px; left: 24px; z-index:1500;
}
</style>
<?php 
if($url == active('obd.php')){
?>
<!-- Fixed Action Button -->
<div id="cs" class="fixed-action-btn fab-ob" style="">
  <a id="csa" data-user="<?php echo $username ?>" class="btn-floating btn-lg btn-info bg-danger cs" href="#"> 
    <i class="lg-icon" data-feather="edit-3" ></i>
  </a>
</div>
<div id="vs" class="fixed-action-btn fab-ob update">
  <a id="vsa" class="btn-floating btn-lg btn-info bg-sog vs" href="#"> 
    <i class="lg-icon" data-feather="eye" ></i>
  </a>
</div>
<!-- Fixed Action Button -->
<?php
} 
switch($url)
{
  case (active('obd.php')):
?>

<?php 
break;
default:
?>
<!-- Fixed Action Button -->
<div class="fixed-action-btn" style="bottom: 45px; left: 24px; z-index:1500;">
<?php if (! $update && ! $readonly) { ?>
  <a class="btn-floating btn-lg btn-info bg-danger cs" href="/outboard.php?update=1"> <!-- data-toggle="tooltip" data-placement="left" title="Change Status"> -->
  <i class="lg-icon" data-feather="edit-3" ></i>
<?php } elseif (! $readonly) { ?>
  <a class="btn-floating btn-lg btn-info bg-sog vs" href="/outboard.php?noupdate=1"> <!-- data-toggle="tooltip" data-placement="left" title="View Status"> -->
  <i class="lg-icon" data-feather="eye" ></i>
<?php } else { echo "&nbsp;"; } ?>
  </a>
</div>
<!-- Fixed Action Button -->
<?php 
break;
}
?>