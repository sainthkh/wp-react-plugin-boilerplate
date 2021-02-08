<?php
/**
 * Execute SQL files for e2e-tests.
 *
 * @package WP React Plugin Boilerplate
 */

define( 'WP_ROOT', dirname( __DIR__ ) . '/../../../' );

// LOAD wpdb.
require_once WP_ROOT . 'wp-load.php';
global $wpdb;

$filenames = array_filter( $argv, function ($name, $i) {
	return $i > 0;
}, ARRAY_FILTER_USE_BOTH );

foreach($filenames as $filename) {
	$wpdb->query(
		file_get_contents( SQL_FILE_ROOT . $filename )
	);
}
