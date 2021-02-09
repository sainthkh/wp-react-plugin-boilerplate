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

require_once dirname ( __DIR__ ) . '/test/e2e/api/lib/sql.php';

$filenames = array_filter( $argv, function ($name, $i) {
	return $i > 0;
}, ARRAY_FILTER_USE_BOTH );

wp_react_executeSQL( $filenames );
