<?php
/**
 * Test suite configuration for the wp-phpunit core test library.
 *
 * Uses a dedicated `wpinsert_tests` database so the ddev dev site is untouched.
 *
 * @package wp-insert
 */

define( 'ABSPATH', '/var/www/html/public/' );

define( 'DB_NAME', 'wpinsert_tests' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', 'root' );
define( 'DB_HOST', 'db' );
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
