<?php

/**
 * OutboardConfig.php
 *
 * Controls getting and setting configuration options for the OutBoard.
 *
 * 2020-09-15 	richardf - Updated for PHP7.
 * 2005-02-15	Richard F. Feuerriegel	(richardf@aces.edu)
 *	- Initial creation
 *
 **/
// define("PROJECT_ROOT_PATH", __DIR__ . "/../");

class OutboardConfig {

private $config = array();

public function __construct() {
  // include("config/config.php");
  include PROJECT_ROOT_PATH . "config/config.php";
}

public function setConfig($name,$value) {
  if ($name != "") {
    $this->config[$name] = $value;
  }
}

public function getConfig($name) {
  if (isset($this->config[$name])) {
    return $this->config[$name];
  }
}

}
