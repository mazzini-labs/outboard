<?php

/*
 * Example PHP implementation used for the REST example.
 * This file defines a DTEditor class instance which can then be used, as
 * required, by the CRUD actions.
 */

// DataTables PHP library
include( dirname(__FILE__)."/../../lib/DataTables.php" );

// Alias Editor classes so they are easy to use

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
    DataTables\Editor\Field,
    DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate,
	DataTables\Editor\ValidateOptions;

// Build our Editor instance and process the data coming from _POST
$editor = Editor::inst( $db, 'list', 'list_id' )
	->fields(
		Field::inst( 'api' )
			->validator( Validate::notEmpty( ValidateOptions::inst()
				->message( 'A unique API number is required' )	
			) ),
		Field::inst( 'entity_common_name' )
			->validator( Validate::notEmpty( ValidateOptions::inst()
				->message( 'A well\'s common name is required' )	
			) ),
        Field::inst( 'state' )
            ->validator( Validate::notEmpty( ValidateOptions::inst()
                ->message( 'Please enter the state for this well' )	
            ) ),
        Field::inst( 'county_parish' )
            ->validator( Validate::notEmpty( ValidateOptions::inst()
				->message( 'Please enter the county or parish for this well' )	
			) ),
		Field::inst( 'block' )
			->validator( Validate::notEmpty( ValidateOptions::inst()
				->message( 'Please enter the block for this well' )	
			) ),
		Field::inst( 'entity_operator_code' )
			->validator( Validate::values( array('SOG', 'SDC', 'MRV', 'NRG', 'PEV', 'PPC') ) ),
		Field::inst( 'producing_status' )
			->validator( Validate::values( array('Active', 'Inactive', 'Down', 'S/I', 'TA', 'P&A', 'N/A') ) ),
		Field::inst( 'production_type' )
			->validator( Validate::values( array('Oil', 'Gas', 'SWD', 'Inj', 'N/A', 'CP') ) ),
		Field::inst( 'last_prod_date' )
			->validator( Validate::dateFormat( 'Y-m-d' ) )
			->getFormatter( Format::dateSqlToFormat( 'Y-m-d' ) )
			->setFormatter( Format::dateFormatToSql('Y-m-d' ) ),
		Field::inst( 'pumper' ),
		Field::inst( 'notes'),
		Field::inst( 'si_notes'),
		Field::inst( 'notes_update')
	);
	// ->process( $_POST )
	// ->json();

