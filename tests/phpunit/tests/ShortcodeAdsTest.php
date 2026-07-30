<?php
/**
 * Characterization tests for the shortcode ad entry points.
 *
 * @package wp-insert
 */

class ShortcodeAdsTest extends WP_UnitTestCase {
	use AdFixtures;

	public function tear_down() {
		delete_option( 'wp_insert_shortcodeads' );
		delete_option( 'wp_insert_inpostads' );
		parent::tear_down();
	}

	/**
	 * @dataProvider data_ad_code_fixtures
	 */
	public function test_wpinsertshortcodead_renders_stored_code( $ad_code ) {
		update_option(
			'wp_insert_shortcodeads',
			[ 'sc1' => self::full_ad_unit( [ 'primary_ad_code' => $ad_code ] ) ]
		);
		$rendered = do_shortcode( '[wpinsertshortcodead id="sc1"]' );
		$parsed   = self::parse_ad_unit( $rendered );
		$this->assertNotNull( $parsed );
		$this->assertSame( $ad_code, $parsed['code'] );
	}

	public function data_ad_code_fixtures() {
		return self::ad_code_fixtures();
	}

	public function test_legacy_wpshortcodead_tag_still_works() {
		update_option(
			'wp_insert_shortcodeads',
			[ 'sc1' => self::full_ad_unit( [ 'primary_ad_code' => self::$ad_iframe ] ) ]
		);
		$parsed = self::parse_ad_unit( do_shortcode( '[wpshortcodead id="sc1"]' ) );
		$this->assertNotNull( $parsed );
		$this->assertSame( self::$ad_iframe, $parsed['code'] );
	}

	public function test_wpinsertinpostad_shortcode_renders_inpost_unit() {
		update_option(
			'wp_insert_inpostads',
			[ 'u1' => self::full_ad_unit( [ 'primary_ad_code' => self::$ad_adsense ] ) ]
		);
		$parsed = self::parse_ad_unit( do_shortcode( '[wpinsertinpostad id="u1"]' ) );
		$this->assertNotNull( $parsed );
		$this->assertSame( self::$ad_adsense, $parsed['code'] );
	}

	public function test_unknown_id_renders_nothing() {
		update_option(
			'wp_insert_shortcodeads',
			[ 'sc1' => self::full_ad_unit() ]
		);
		$this->assertSame( '', do_shortcode( '[wpinsertshortcodead id="nope"]' ) );
	}

	public function test_disabled_unit_renders_nothing() {
		update_option(
			'wp_insert_shortcodeads',
			[ 'sc1' => self::full_ad_unit( [ 'status' => '' ] ) ]
		);
		$this->assertSame( '', do_shortcode( '[wpinsertshortcodead id="sc1"]' ) );
	}
}
