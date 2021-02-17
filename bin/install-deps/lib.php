<?php
/**
 * Functions for installing WordPress dependencies
 *
 * @package WP React Plugin Boilerplate
 */

define('WP_DEPS_PLUGINS', WP_DEPS_ROOT . 'plugins/' );
define('WP_DEPS_THEMES', WP_DEPS_ROOT . 'themes/');
define('WP_ENV_PATH', __DIR__ . '/../../.wp-env.json');
define('WP_ENV_OVERRIDE_PATH', __DIR__ . '/../../.wp-env.override.json');
define('WP_PLUGINS_ROOT', "https://downloads.wordpress.org/plugin/" );

$zip = new ZipArchive;

/**
 * Install plugins
 *
 * @param object $deps WordPress dependencies.
 */
function install_plugins($deps) {
	global $zip;

	if (count(get_object_vars( $deps->plugins )) > 0) {
		if (!file_exists(WP_DEPS_PLUGINS)) {
			mkdir(WP_DEPS_PLUGINS);
		}

		foreach ($deps->plugins as $name => $version) {
			$url = strpos($version, "://") !== false
				? $version
				: WP_PLUGINS_ROOT . $name . "." . $version . ".zip";

			$filename = WP_DEPS_PLUGINS . $name . '.zip';
			$raw = @file_get_contents($url);
			if ($raw === false) {
				$raw = @file_get_contents(WP_PLUGINS_ROOT . $name . '.zip');

				if ($raw === false) {
					echo "Failed downloading " . $name . "\n";
					continue;
				}

				echo "Downloaded " . $name . " " . $version . "\n";
			}

			file_put_contents($filename, $raw);

			// extract file.
			$res = $zip->open($filename);

			if($res === TRUE) {
				// Check if the root directory of the plugin is included.
				$plugin_path = $zip->locateName($name . '/') !== false
					? WP_DEPS_PLUGINS
					: WP_DEPS_PLUGINS . $name;

				$zip->extractTo(WP_DEPS_PLUGINS);
				$zip->close();
				echo "Extracted " . $name . "\n";
			} else {
				echo "Failed unzipping " . $name . "\n";
			}

			unlink($filename);
		}
	}
}

/**
 * Install themes
 *
 * @param object $deps WordPress dependencies.
 */
function install_themes($deps) {
	global $zip;

	if (count(get_object_vars( $deps->themes )) > 0) {
		if (!file_exists(WP_DEPS_THEMES)) {
			mkdir(WP_DEPS_THEMES);
		}

		foreach ($deps->themes as $name => $version) {
			$url = strpos($version, "://") !== false
				? $version
				: "https://downloads.wordpress.org/theme/" . $name . "." . $version . ".zip";

			$filename = WP_DEPS_THEMES . $name . '.zip';

			$raw = @file_get_contents($url);
			if ($raw !== false) {
				echo "Downloaded " . $name . " " . $version . "\n";
			} else {
				echo "Failed downloading " . $name . "\n";
				continue;
			}
			file_put_contents($filename, $raw );

			// extract file.
			$res = $zip->open($filename);

			if($res === TRUE) {
				// Check if the root directory of the plugin is included.
				$plugin_path = $zip->locateName($name . '/') !== false
					? WP_DEPS_THEMES
					: WP_DEPS_THEMES . $name;

				$zip->extractTo(WP_DEPS_THEMES);
				$zip->close();
				echo "Extracted " . $name . "\n";
			} else {
				echo "Failed unzipping " . $name . "\n";
			}

			unlink($filename);
		}
	}
}

/**
 * Generate wp-env.override.json for test.
 *
 * @param object $deps WordPress dependencies.
 */
function generate_wp_env_override_json($deps) {
	$wp_env = json_decode( file_get_contents(WP_ENV_PATH) );
	$wp_deps = array();

	$deps_plugins = $deps->plugins
		? array_keys( get_object_vars($deps->plugins))
		: array();

	$wp_deps['plugins'] = array_merge(
		$wp_env->plugins,
		array_map(
			function ($name) {
				return "./wp-deps/plugins/" . $name;
			},
			$deps_plugins
		)
	);

	$env_themes = $wp_env->themes ? $wp_env->themes : array();
	$deps_themes = $deps->themes
		? array_keys( get_object_vars($deps->themes))
		: array();

	$wp_deps['themes'] = array_merge(
		$env_themes,
		array_map(
			function ($name) {
				return "./wp-deps/themes/" . $name;
			},
			$deps_themes
		)
	);

	$json = json_encode($wp_deps, JSON_PRETTY_PRINT );

	file_put_contents(WP_ENV_OVERRIDE_PATH, $json);
}
