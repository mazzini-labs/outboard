<?php

/*
 * Example PHP implementation used for the REST 'get' interface
 */

include( "wells.list.php" );

$editor
	->process($_POST)
	->json();

