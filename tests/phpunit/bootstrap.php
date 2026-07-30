<?php
/**
 * PHPUnit bootstrap: loads the wp-phpunit core test library with wp-insert active.
 *
 * @package wp-insert
 */

require_once dirname( __DIR__, 2 ) . '/vendor/autoload.php';

if ( false === getenv( 'WP_PHPUNIT__TESTS_CONFIG' ) ) {
	putenv( 'WP_PHPUNIT__TESTS_CONFIG=' . __DIR__ . '/wp-tests-config.php' );
}

$wp_insert_tests_dir = getenv( 'WP_PHPUNIT__DIR' );
if ( false === $wp_insert_tests_dir ) {
	$wp_insert_tests_dir = dirname( __DIR__, 2 ) . '/vendor/wp-phpunit/wp-phpunit';
}

require_once $wp_insert_tests_dir . '/includes/functions.php';

tests_add_filter(
	'muplugins_loaded',
	static function () {
		require dirname( __DIR__, 2 ) . '/wp-insert.php';
	}
);

require $wp_insert_tests_dir . '/includes/bootstrap.php';

require_once __DIR__ . '/includes/AdFixtures.php';
