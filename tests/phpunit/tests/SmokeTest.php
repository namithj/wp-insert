<?php
/**
 * Smoke test: the plugin loads inside the test suite.
 *
 * @package wp-insert
 */

class SmokeTest extends WP_UnitTestCase {
	public function test_plugin_loaded() {
		$this->assertTrue( defined( 'WP_INSERT_VERSION' ) );
		$this->assertTrue( function_exists( 'wp_insert_get_ad_unit' ) );
	}
}
