<?php
/**
 * SQL utils for e2e tests.
 *
 * @package WP React Plugin Boilerplate
 */

define( 'QUERY_FILE_ROOT', __DIR__ . '/../../query/' );

/**
 * Execute SQL files
 *
 * @param string[] $filenames SQL files to execute.
 */
function wp_react_execute_sql( $filenames ) {
	global $wpdb;

	foreach ( $filenames as $filename ) {
		$raw = file_get_contents( SQL_FILE_ROOT . $filename );

		// Reason for ignore:
		// Raw SQL file contains multiple SQL statements. It's necessary to use this function.
		$result = mysqli_multi_query( $wpdb->dbh, $raw ); // phpcs:ignore WordPress.DB.RestrictedFunctions.mysql_mysqli_multi_query

		// Reason for ignore:
		// Flush queries.
		// WordPress uses mysqli_query. When mysqli_query and mysqli_multi_query are used together,
		// they can cause commands out of sync error.
		// @see https://stackoverflow.com/a/66378950/1038927.
		while ( mysqli_next_result( $wpdb->dbh ) ); // phpcs:ignore WordPress.DB.RestrictedFunctions.mysql_mysqli_next_result

		if ( false === $result ) {
			// Reason for ignore:
			// It is necessary to use error function because we used error mysql function.
			echo 'Query Error: ' . mysqli_error( $wpdb->dbh ) . "\n"; // phpcs:ignore WordPress.DB.RestrictedFunctions.mysql_mysqli_error
		}
	}
}

/**
 * Generate SQL files
 *
 * @param string[] $filenames SQL insert files will be generated based on these files.
 */
function wp_react_generate_sql( $filenames ) {
	global $wpdb;

	foreach ( $filenames as $filename ) {
		$raw        = file_get_contents( QUERY_FILE_ROOT . $filename );
		$statements = explode( ';', $raw );

		$content = '';

		foreach ( $statements as $sql ) {
			if ( preg_match( '/\S/', $sql ) ) {
				$sql_lines   = explode( "\n", trim( $sql ) );
				$sql_comment = implode(
					"\n",
					array_map(
						function( $line ) {
							return '-- ' . $line;
						},
						$sql_lines
					)
				);
				$content    .= $sql_comment . "\n";

				preg_match( '/from\s+([^ \n]+)/i', $sql, $m );
				$table_name = $m[1];

				// Reason for ignore:
				// Executing raw SQL is necessary for test.
				// And this file is only included in the development version.
				$result = $wpdb->get_results( $sql ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

				foreach ( $result as $r ) {
					$values = array();

					$maxlength = max(
						array_map(
							function ( $c ) {
								return strlen( $c );
							},
							array_keys( get_object_vars( $r ) ) // Object keys.
						)
					);

					foreach ( $r as $column => $value ) {
						$whitespace = str_repeat( ' ', $maxlength + 4 - strlen( $column ) );
						// Reason for ignore:
						// It is necessary to escape serialized object.
						$values[] = "\t/* " . $column . ' */' . $whitespace . "'" . mysqli_real_escape_string( $wpdb->dbh, $value ) . "'"; // phpcs:ignore WordPress.DB.RestrictedFunctions.mysql_mysqli_real_escape_string
					}

					$content .= 'insert into ' . $table_name . ' values(' . "\n" .
						implode( ",\n", $values ) . "\n" .
						');' . "\n";
				}

				$content .= "\n";
			}
		}

		file_put_contents( SQL_FILE_ROOT . $filename, $content );
	}
}
