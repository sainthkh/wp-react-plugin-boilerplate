<?php
/**
 * E2E test DB APIs.
 *
 * @package WP React Plugin Boilerplate
 */

function wp_react_db_api() {
	register_rest_route(
		'wp-react/test/v1',
		'/reset-table',
		array(
			'methods'  => 'POST',
			'callback' => 'wp_react_plugin_reset_table',
			'permission_callback' => '__return_true',
		)
	);

	register_rest_route(
		'wp-react/test/v1',
		'/run-sql',
		array(
			'methods'  => 'POST',
			'callback' => 'wp_react_plugin_run_sql',
			'permission_callback' => '__return_true',
		)
	);
}

add_action( 'rest_api_init', 'wp_react_db_api' );

function wp_react_plugin_reset_table(WP_REST_Request $request) {
	global $wpdb;

	$tables = json_decode($request->get_body(), true);

	foreach($tables as $table) {
		$sql = $wpdb->prepare("DELETE FROM {$table}", array());
		$wpdb->query($sql);
	}

	return "Reset succeeded";
}

define( 'SQL_FILE_ROOT', dirname( __DIR__ ) . '/sql/' ); /* => test/e2e/sql */

function wp_react_plugin_run_sql(WP_REST_Request $request) {
	global $wpdb;

	$files = json_decode($request->get_body(), true);

	foreach($files as $file) {
		$raw_sql = file_get_contents( SQL_FILE_ROOT . $file );
		$sql = $wpdb->prepare($raw_sql, array());
		$wpdb->query($sql);
	}

	return "SQL run succeeded";
}
