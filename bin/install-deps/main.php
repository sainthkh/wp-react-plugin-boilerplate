<?php
/**
 * Install WordPress dependencies (plugins, themes)
 *
 * @package WP React Plugin Boilerplate
 */

define('WP_DEPS_FILE', __DIR__ . '/../../wp-deps.json');
define('WP_DEPS_ROOT', __DIR__ . '/../../wp-deps/');

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/lib.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// Step 1. Check wp-deps.json exists.

if (!file_exists(WP_DEPS_FILE)) {
	echo "wp-deps.json file doesn't exist.\n";
	exit;
}

// Step 2. Create wp-deps folder.

if (!file_exists(WP_DEPS_ROOT)) {
	mkdir(WP_DEPS_ROOT);
}

// Step 3. Download files and unzip them.

$raw = file_get_contents(WP_DEPS_FILE);
$deps = json_decode($raw);

install_plugins($deps->plugins);
install_themes($deps->themes);

// Step 4. Generate wp-env.override.json.

generate_wp_env_override_json($deps);
