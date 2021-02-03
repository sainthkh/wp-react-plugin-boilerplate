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
