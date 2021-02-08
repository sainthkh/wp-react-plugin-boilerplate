<?php
/**
 * Generate SQL insert files for e2e-tests.
 *
 * @package WP React Plugin Boilerplate
 */

define( 'QUERY_FILE_ROOT', dirname( __DIR__ ) . '/test/e2e/query/' );
define( 'WP_ROOT', dirname( __DIR__ ) . '/../../../' );

// LOAD wpdb.
require_once WP_ROOT . 'wp-load.php';
global $wpdb;

$filename = $argv[1];
$raw = file_get_contents( QUERY_FILE_ROOT . $filename );
$statements = explode(';', $raw);

$content = '';

foreach($statements as $sql) {
	if (preg_match('/\S/', $sql)) {
		$content .= '-- ' . $sql . "\n";

		preg_match('/from\s+([^ ]+)/i', $sql, $m);
		$table_name = $m[1];

		$result = $wpdb->get_results($sql);

		foreach($result as $r) {
			$values = [];

			$maxlength = max(
				array_map(
					function ($c) {
						return strlen( $c );
					},
					array_keys ( get_object_vars( $r ) ) // Object keys.
				)
			);

			foreach($r as $column => $value) {
				$whitespace = str_repeat( ' ', $maxlength + 4 - strlen( $column ) );
				$values[] = "\t/* " . $column . " */" . $whitespace . "'" . $value . "'";
			}

			$content .= 'insert into ' . $table_name . ' values(' . "\n" .
				implode(",\n", $values) . "\n" .
				');' . "\n";
		}

		$content .= "\n";
	}
}

// SQL_FILE_ROOT is defined at /test/e2e/api/db.php
file_put_contents(SQL_FILE_ROOT . $filename, $content);
