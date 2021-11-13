<?php

/*
 * Example PHP implementation used for the REST 'delete' interface.
 */

include( "wells.list.full.php" );

$editor
	->process( $_GET )
	->json();

