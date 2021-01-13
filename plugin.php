<?php
/**
 * Plugin Name: WordPress React Plugin Boilerplate
 * Plugin URI: https://github.com/sainthkh/wp-react-plugin-boilerplate
 * Description: The good starting point for WordPress and React fans.
 * Requires at least: 5.3
 * Requires PHP: 5.6
 * Version: 1.0.0
 * Author: sainthkh
 * Text Domain: wp-react-plugin
 *
 * @package wp-react-plugin
 */

### BEGIN AUTO-GENERATED DEFINES
defined( 'WP_REACT_PLUGIN_DEVELOPMENT_MODE' ) or define( 'WP_REACT_PLUGIN_DEVELOPMENT_MODE', true );
### END AUTO-GENERATED DEFINES

add_shortcode('Hello', 'wp_react_plugin_hello_shortcode');

function wp_react_plugin_hello_shortcode() {
	return '<h1>Hello World</h1>';
}
