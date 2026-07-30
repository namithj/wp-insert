<?php
/**
 * Characterization tests for the theme-function ad entry points.
 *
 * @package wp-insert
 */

class InThemeAdsTest extends WP_UnitTestCase {
	use AdFixtures;

	public function tear_down() {
		delete_option( 'wp_insert_inthemeads' );
		parent::tear_down();
	}

	/**
	 * @dataProvider data_ad_code_fixtures
	 */
	public function test_wp_intheme_ad_echoes_stored_code( $ad_code ) {
		update_option(
			'wp_insert_inthemeads',
			[ 'theme1' => self::full_ad_unit( [ 'primary_ad_code' => $ad_code ] ) ]
		);
		ob_start();
		wp_intheme_ad( 'theme1' );
		$parsed = self::parse_ad_unit( ob_get_clean() );
		$this->assertNotNull( $parsed );
		$this->assertSame( $ad_code, $parsed['code'] );
	}

	public function data_ad_code_fixtures() {
		return self::ad_code_fixtures();
	}

	public function test_wp_template_ad_maps_to_templateads_prefix() {
		// Pre-2.x back-compat: wp_template_ad('x') reads unit 'templateads-x'.
		update_option(
			'wp_insert_inthemeads',
			[ 'templateads-old' => self::full_ad_unit( [ 'primary_ad_code' => self::$ad_html ] ) ]
		);
		ob_start();
		wp_template_ad( 'old' );
		$parsed = self::parse_ad_unit( ob_get_clean() );
		$this->assertNotNull( $parsed );
		$this->assertSame( self::$ad_html, $parsed['code'] );
	}

	public function test_unknown_identifier_outputs_nothing() {
		ob_start();
		wp_intheme_ad( 'missing' );
		$this->assertSame( '', ob_get_clean() );
	}
}
