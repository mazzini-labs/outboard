<?php

/*
 * Example PHP implementation used for the index.html example
 */

// DataTables PHP library
include( "lib/DataTables.php" );

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
Editor::inst( $db, 'list', 'list_id' )
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
		Field::inst( 'entity_operator_code' ),
		Field::inst( 'producing_status' ),
		Field::inst( 'production_type' ),
		Field::inst( 'last_prod_date' )
			->validator( Validate::dateFormat( 'Y-m-d' ) )
			->getFormatter( Format::dateSqlToFormat( 'Y-m-d' ) )
            ->setFormatter( Format::dateFormatToSql('Y-m-d' ) ),
        Field::inst( 'pumper' ),
        Field::inst( 'notes'),
        Field::inst( 'si_notes'),
	)
	->process( $_POST )
	->json();

    ?>