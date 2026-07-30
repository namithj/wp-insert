<?php
/**
 * Characterization tests for page-level ads and header/footer tracking codes.
 *
 * @package wp-insert
 */

class HeadFooterCodesTest extends WP_UnitTestCase {
	use AdFixtures;

	public function tear_down() {
		delete_option( 'wp_insert_pagelevelads' );
		delete_option( 'wp_insert_trackingcodes' );
		parent::tear_down();
	}

	public function test_pagelevel_ad_code_is_output_raw_in_head() {
		update_option(
			'wp_insert_pagelevelads',
			[ 'pl1' => self::full_ad_unit( [ 'primary_ad_code' => self::$ad_adsense ] ) ]
		);
		ob_start();
		wp_insert_pagelevelads_wp_head();
		$output = ob_get_clean();
		// Page-level ads are emitted raw: no wrapper div, byte-identical code.
		$this->assertSame( self::$ad_adsense, $output );
	}

	public function test_disabled_pagelevel_ad_outputs_nothing() {
		update_option(
			'wp_insert_pagelevelads',
			[ 'pl1' => self::full_ad_unit( [ 'status' => '' ] ) ]
		);
		ob_start();
		wp_insert_pagelevelads_wp_head();
		$this->assertSame( '', ob_get_clean() );
	}

	public function test_header_embed_code_is_output_unslashed() {
		update_option(
			'wp_insert_trackingcodes',
			[
				'header' => [
					'status' => '1',
					'code'   => self::$ad_inline_js,
				],
			]
		);
		ob_start();
		wp_insert_trackingcodes_header_wp_head();
		$this->assertSame( self::$ad_inline_js, ob_get_clean() );
	}

	public function test_footer_embed_code_is_output_unslashed() {
		$meta_pixel = "<script>\n!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod ? n.callMethod.apply(n,arguments) : n.queue.push(arguments)};}(window, document,'script','https://connect.facebook.net/en_US/fbevents.js');\nfbq('init', '1234567890');\nfbq('track', 'PageView');\n</script>";
		update_option(
			'wp_insert_trackingcodes',
			[
				'footer' => [
					'status' => '1',
					'code'   => $meta_pixel,
				],
			]
		);
		ob_start();
		wp_insert_trackingcodes_footer_wp_footer();
		$this->assertSame( $meta_pixel, ob_get_clean() );
	}

	public function test_disabled_embed_codes_output_nothing() {
		update_option(
			'wp_insert_trackingcodes',
			[
				'header' => [
					'status' => '',
					'code'   => 'HEADER',
				],
				'footer' => [
					'status' => '',
					'code'   => 'FOOTER',
				],
			]
		);
		ob_start();
		wp_insert_trackingcodes_header_wp_head();
		wp_insert_trackingcodes_footer_wp_footer();
		$this->assertSame( '', ob_get_clean() );
	}
}
