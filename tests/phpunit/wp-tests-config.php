<?php
/**
 * Test suite configuration for the wp-phpunit core test library.
 *
 * Every value is environment driven so the same config works in the local ddev
 * container and on CI. The defaults reproduce the ddev setup, where the plugin
 * lives inside a WordPress checkout at /var/www/html/public and a dedicated
 * `wpinsert_tests` database keeps the dev site untouched.
 *
 * Recognised environment variables:
 *   WP_TESTS_ABSPATH  Path to the WordPress core checkout to test against.
 *   WP_TESTS_DB_NAME / _DB_USER / _DB_PASSWORD / _DB_HOST
 *
 * @package wp-insert
 */

/**
 * Read an environment variable, falling back to a default when it is unset or empty.
 *
 * @param string $name    Variable name.
 * @param string $default Value to use when the variable is not provided.
 * @return string
 */
function wp_insert_tests_env( $name, $default ) {
	$value = getenv( $name );
	return ( false === $value || '' === $value ) ? $default : $value;
}

$wp_insert_tests_abspath = wp_insert_tests_env( 'WP_TESTS_ABSPATH', '/var/www/html/public' );
define( 'ABSPATH', rtrim( $wp_insert_tests_abspath, '/\\' ) . '/' );

if ( ! file_exists( ABSPATH . 'wp-settings.php' ) ) {
	echo 'No WordPress core found at ' . ABSPATH . PHP_EOL
		. 'Set WP_TESTS_ABSPATH to a WordPress checkout (see bin/install-wp-core.sh).' . PHP_EOL;
	exit( 1 );
}

define( 'DB_NAME', wp_insert_tests_env( 'WP_TESTS_DB_NAME', 'wpinsert_tests' ) );
define( 'DB_USER', wp_insert_tests_env( 'WP_TESTS_DB_USER', 'root' ) );
define( 'DB_PASSWORD', wp_insert_tests_env( 'WP_TESTS_DB_PASSWORD', 'root' ) );
define( 'DB_HOST', wp_insert_tests_env( 'WP_TESTS_DB_HOST', 'db' ) );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

// phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited -- Required by the WP test bootstrap.
$table_prefix = 'wptests_';

define( 'WP_TESTS_DOMAIN', 'example.org' );
define( 'WP_TESTS_EMAIL', 'admin@example.org' );
define( 'WP_TESTS_TITLE', 'Wp-Insert Test Suite' );

define( 'WP_PHP_BINARY', 'php' );
define( 'WP_DEBUG', true );

define( 'AUTH_KEY', 'wp-insert-tests' );
define( 'SECURE_AUTH_KEY', 'wp-insert-tests' );
define( 'LOGGED_IN_KEY', 'wp-insert-tests' );
define( 'NONCE_KEY', 'wp-insert-tests' );
define( 'AUTH_SALT', 'wp-insert-tests' );
define( 'SECURE_AUTH_SALT', 'wp-insert-tests' );
define( 'LOGGED_IN_SALT', 'wp-insert-tests' );
define( 'NONCE_SALT', 'wp-insert-tests' );
