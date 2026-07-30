<?php
/**
 * Characterization tests for wp_insert_get_ad_unit_code(): the stored ad code
 * must come back byte-identical (after the documented stripslashes pass).
 *
 * @package wp-insert
 */

class AdUnitCodeTest extends WP_UnitTestCase {
	use AdFixtures;

	public function tear_down() {
		global $wpInsertABTestingMode, $wpInsertGeoLocation;
		$wpInsertABTestingMode = null;
		$wpInsertGeoLocation   = null;
		remove_shortcode( 'wp_insert_test_sc' );
		parent::tear_down();
	}

	/**
	 * @dataProvider data_ad_code_fixtures
	 */
	public function test_primary_ad_code_renders_byte_identical( $ad_code ) {
		$data = self::full_ad_unit( [ 'primary_ad_code' => $ad_code ] );
		$this->assertSame( $ad_code, wp_insert_get_ad_unit_code( $data ) );
	}

	public function data_ad_code_fixtures() {
		return self::ad_code_fixtures();
	}

	public function test_shortcodes_inside_ad_code_are_expanded() {
		add_shortcode(
			'wp_insert_test_sc',
			static function () {
				return '<span>EXPANDED</span>';
			}
		);
		$data = self::full_ad_unit( [ 'primary_ad_code' => 'before [wp_insert_test_sc] after' ] );
		$this->assertSame( 'before <span>EXPANDED</span> after', wp_insert_get_ad_unit_code( $data ) );
	}

	public function test_slashed_storage_is_unslashed_at_render() {
		// Legacy behavior: render pipeline applies stripslashes() to stored code.
		$stored = "<script>var msg = \\'hello\\';</script>";
		$data   = self::full_ad_unit( [ 'primary_ad_code' => $stored ] );
		$this->assertSame( "<script>var msg = 'hello';</script>", wp_insert_get_ad_unit_code( $data ) );
	}

	public function test_ab_mode_2_serves_secondary_code() {
		global $wpInsertABTestingMode;
		$wpInsertABTestingMode = 2;
		$data                  = self::full_ad_unit(
			[
				'primary_ad_code'   => 'PRIMARY',
				'secondary_ad_code' => self::$ad_iframe,
			]
		);
		$this->assertSame( self::$ad_iframe, wp_insert_get_ad_unit_code( $data ) );
	}

	public function test_ab_mode_3_serves_tertiary_code() {
		global $wpInsertABTestingMode;
		$wpInsertABTestingMode = 3;
		$data                  = self::full_ad_unit(
			[
				'primary_ad_code'  => 'PRIMARY',
				'tertiary_ad_code' => self::$ad_adsense,
			]
		);
		$this->assertSame( self::$ad_adsense, wp_insert_get_ad_unit_code( $data ) );
	}

	public function test_unset_ab_mode_falls_back_to_primary() {
		global $wpInsertABTestingMode;
		$wpInsertABTestingMode = null;
		$data                  = self::full_ad_unit( [ 'primary_ad_code' => self::$ad_inline_js ] );
		$this->assertSame( self::$ad_inline_js, wp_insert_get_ad_unit_code( $data ) );
	}

	/**
	 * @group php8-compat
	 */
	public function test_geo_group1_code_served_for_matching_country() {
		global $wpInsertGeoLocation;
		$wpInsertGeoLocation = 'IN';
		$data                = self::full_ad_unit(
			[
				'primary_ad_code'      => 'PRIMARY',
				'geo_group1_countries' => [ 'IN', 'US' ],
				'geo_group1_adcode'    => self::$ad_iframe,
			]
		);
		$this->assertSame( self::$ad_iframe, wp_insert_get_ad_unit_code( $data ) );
	}

	/**
	 * @group php8-compat
	 */
	public function test_geo_group2_code_served_for_matching_country() {
		global $wpInsertGeoLocation;
		$wpInsertGeoLocation = 'DE';
		$data                = self::full_ad_unit(
			[
				'primary_ad_code'      => 'PRIMARY',
				'geo_group2_countries' => [ 'DE' ],
				'geo_group2_adcode'    => self::$ad_html,
			]
		);
		$this->assertSame( self::$ad_html, wp_insert_get_ad_unit_code( $data ) );
	}

	/**
	 * @group php8-compat
	 */
	public function test_geo_non_matching_country_falls_back_to_primary() {
		global $wpInsertGeoLocation;
		$wpInsertGeoLocation = 'FR';
		$data                = self::full_ad_unit(
			[
				'primary_ad_code'      => self::$ad_html,
				'geo_group1_countries' => [ 'IN' ],
				'geo_group1_adcode'    => 'GEO1',
			]
		);
		$this->assertSame( self::$ad_html, wp_insert_get_ad_unit_code( $data ) );
	}

	/**
	 * @group php8-compat
	 */
	public function test_legacy_minimal_unit_renders_primary_code() {
		$data = self::legacy_ad_unit( [ 'primary_ad_code' => self::$ad_adsense ] );
		$this->assertSame( self::$ad_adsense, wp_insert_get_ad_unit_code( $data ) );
	}
}
