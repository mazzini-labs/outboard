<?php

/*
 * Example PHP implementation used for the REST 'get' interface
 */

include( "wells.list.full.php" );

$editor
	->process($_POST)
	->json();

