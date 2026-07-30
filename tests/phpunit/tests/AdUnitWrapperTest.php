<?php
/**
 * Characterization tests for wp_insert_get_ad_unit(): wrapper div, float styles
 * and the responsive <style> block.
 *
 * @package wp-insert
 */

class AdUnitWrapperTest extends WP_UnitTestCase {
	use AdFixtures;

	/**
	 * @dataProvider data_ad_code_fixtures
	 */
	public function test_wrapper_preserves_ad_code_byte_identical( $ad_code ) {
		$data   = self::full_ad_unit( [ 'primary_ad_code' => $ad_code ] );
		$parsed = self::parse_ad_unit( wp_insert_get_ad_unit( $data ) );
		$this->assertNotNull( $parsed, 'Rendered markup did not match the expected wrapper structure' );
		$this->assertSame( $ad_code, $parsed['code'] );
	}

	public function data_ad_code_fixtures() {
		return self::ad_code_fixtures();
	}

	public function test_empty_ad_code_renders_nothing() {
		$data = self::full_ad_unit( [ 'primary_ad_code' => '' ] );
		$this->assertSame( '', wp_insert_get_ad_unit( $data ) );
	}

	public function test_additional_styles_are_applied_to_wrapper() {
		$data   = self::full_ad_unit();
		$parsed = self::parse_ad_unit( wp_insert_get_ad_unit( $data, 'float: left;' ) );
		$this->assertNotNull( $parsed );
		$this->assertSame( 'float: left;', $parsed['style'] );
	}

	public function test_wrapper_class_is_unique_per_render() {
		$data     = self::full_ad_unit();
		$parsed_a = self::parse_ad_unit( wp_insert_get_ad_unit( $data ) );
		$parsed_b = self::parse_ad_unit( wp_insert_get_ad_unit( $data ) );
		$this->assertNotSame( $parsed_a['class'], $parsed_b['class'] );
	}

	public function test_custom_unit_styles_are_emitted_in_style_block() {
		$data   = self::full_ad_unit( [ 'styles' => 'margin: 10px auto; text-align: center;' ] );
		$parsed = self::parse_ad_unit( wp_insert_get_ad_unit( $data ) );
		$this->assertStringContainsString( '.' . $parsed['class'] . ' {' . "\r\n" . 'margin: 10px auto; text-align: center;', $parsed['styles'] );
	}

	public function test_default_breakpoints_are_used_when_unset() {
		$data   = self::full_ad_unit();
		$parsed = self::parse_ad_unit( wp_insert_get_ad_unit( $data ) );
		$this->assertStringContainsString( '@media screen and (min-width: 1201px)', $parsed['styles'] );
		$this->assertStringContainsString( '(min-width: 993px) and (max-width: 1200px)', $parsed['styles'] );
		$this->assertStringContainsString( '(min-width: 769px) and (max-width: 992px)', $parsed['styles'] );
		$this->assertStringContainsString( '@media screen and (max-width: 767px)', $parsed['styles'] );
	}

	public function test_device_exclusion_emits_display_none() {
		$data   = self::full_ad_unit( [ 'device_exclude_mobile' => 'true' ] );
		$parsed = self::parse_ad_unit( wp_insert_get_ad_unit( $data ) );
		$this->assertStringContainsString( "display: none;", $parsed['styles'] );
	}

	public function test_device_adwidth_emits_width_rule() {
		$data   = self::full_ad_unit( [ 'device_large_desktop_adwidth' => '728' ] );
		$parsed = self::parse_ad_unit( wp_insert_get_ad_unit( $data ) );
		$this->assertStringContainsString( 'width: 728px;', $parsed['styles'] );
	}

	/**
	 * @group php8-compat
	 */
	public function test_legacy_minimal_unit_renders_with_wrapper() {
		$parsed = self::parse_ad_unit( wp_insert_get_ad_unit( self::legacy_ad_unit() ) );
		$this->assertNotNull( $parsed );
		$this->assertSame( self::$ad_html, $parsed['code'] );
	}
}
