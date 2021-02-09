<?php
/**
 * Test SQL commands.
 *
 * @package WP React Plugin Boilerplate
 */

class SQL_Command_Test extends WP_UnitTestCase {

	/**
	 * Test exeucteSQL function
	 */
	function test_execute_sql() {
		global $wpdb;

		wp_react_executeSQL( array( 'post.sql', 'reset-posts.sql' ) );

		$results = $wpdb->get_results("select * from wp_posts");

		$this->assertEquals(count($results), 0);
	}

	/**
	 * Test generateSQL function
	 */
	function test_generate_sql() {
		wp_react_executeSQL( array( 'reset-posts.sql', 'post.sql' ) );

		copy( QUERY_FILE_ROOT . 'post.sql', QUERY_FILE_ROOT . 'post-test.sql' );

		wp_react_generateSQL( array( 'post-test.sql' ) );

		$generated = file_get_contents( SQL_FILE_ROOT . 'post-test.sql' );
		$original = file_get_contents( SQL_FILE_ROOT . 'post.sql' );

		unlink( QUERY_FILE_ROOT . 'post-test.sql' );
		unlink( SQL_FILE_ROOT . 'post-test.sql' );

		$this->assertEquals($generated, $original);
	}
}
