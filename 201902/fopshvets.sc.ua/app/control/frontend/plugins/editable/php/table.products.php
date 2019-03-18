<?php

/*
 * Editor server script for DB table products
 * Created by http://editor.datatables.net/generator
 */

// DataTables PHP library and database connection
include( "lib/DataTables.php" );



// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate;

// The following statement can be removed after the first run (i.e. the database
// table has been created). It is a good idea to do this to help improve
// performance.
// $db->sql( "CREATE TABLE IF NOT EXISTS `products` (
// 	`id` int(10) NOT NULL auto_increment,
// 	`amoname` varchar(255),
// 	`url` varchar(255),
// 	PRIMARY KEY( `id` )
// );" );

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'products', 'id' )
	->fields(
		Field::inst( 'amoName' ),
		Field::inst( 'amoTags' ),
		Field::inst( 'URL' ),
		Field::inst( 'redirect' ),
		Field::inst( 'category' )
	)
	->process( $_POST )
	->json();
