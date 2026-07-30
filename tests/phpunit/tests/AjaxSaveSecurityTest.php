<?php
/**
 * AJAX save-pipeline tests: capability enforcement and lossless ad-code storage.
 *
 * Run with: vendor/bin/phpunit --group ajax
 *
 * @group ajax
 *
 * @package wp-insert
 */

class AjaxSaveSecurityTest extends WP_Ajax_UnitTestCase {
	use AdFixtures;

	public function tear_down() {
		delete_option( 'wp_insert_inpostads' );
		delete_option( 'wp_insert_trackingcodes' );
		remove_role( 'wp_insert_manager_no_html' );
		parent::tear_down();
	}

	/**
	 * Simulate the admin form posting an ad unit save request.
	 *
	 * Incoming values are wp_slash()ed exactly as WordPress does for real requests.
	 *
	 * @param string $ad_code    Ad code as the user typed it.
	 * @param string $identifier Unit identifier.
	 */
	protected function post_save_request( $ad_code, $identifier = 'testunit01' ) {
		$_POST['wp_insert_nonce']                                    = wp_create_nonce( 'wp-insert' );
		$_POST['wp_insert_type']                                     = 'inpostads';
		$_POST['wp_insert_identifier']                               = $identifier;
		$_POST['wp_insert_parameters']                               = [
			'wp_insert_inpostads_' . $identifier . '_title',
			'wp_insert_inpostads_' . $identifier . '_status',
			'wp_insert_inpostads_' . $identifier . '_location',
			'wp_insert_inpostads_' . $identifier . '_primary_ad_code',
		];
		$_POST[ 'wp_insert_inpostads_' . $identifier . '_title' ]    = 'Round Trip Unit';
		$_POST[ 'wp_insert_inpostads_' . $identifier . '_status' ]   = 'true';
		$_POST[ 'wp_insert_inpostads_' . $identifier . '_location' ] = 'above';
		$_POST[ 'wp_insert_inpostads_' . $identifier . '_primary_ad_code' ] = wp_slash( $ad_code );

		try {
			$this->_handleAjax( 'wp_insert_inpostads_save_ad_data' );
		} catch ( WPAjaxDieStopException $e ) {
			return $e->getMessage();
		} catch ( WPAjaxDieContinueException $e ) {
			return '';
		}
		return '';
	}

	/**
	 * @dataProvider data_ad_code_fixtures
	 */
	public function test_admin_save_round_trip_renders_byte_identical( $ad_code ) {
		$this->_setRole( 'administrator' );
		$this->post_save_request( $ad_code );

		$stored = get_option( 'wp_insert_inpostads' );
		$this->assertArrayHasKey( 'testunit01', $stored );
		// Stored slashed (legacy storage format), rendered back byte-identical.
		$this->assertSame( wp_slash( $ad_code ), $stored['testunit01']['primary_ad_code'] );
		$this->assertSame( $ad_code, wp_insert_get_ad_unit_code( $stored['testunit01'] ) );
	}

	public function data_ad_code_fixtures() {
		return self::ad_code_fixtures();
	}

	public function test_subscriber_cannot_save_ad_data() {
		$this->_setRole( 'subscriber' );
		$this->post_save_request( self::$ad_html );
		$this->assertFalse( get_option( 'wp_insert_inpostads' ), 'Subscriber save must not persist anything' );
	}

	public function test_editor_cannot_save_ad_data() {
		$this->_setRole( 'editor' );
		$this->post_save_request( self::$ad_html );
		$this->assertFalse( get_option( 'wp_insert_inpostads' ) );
	}

	public function test_manager_without_unfiltered_html_gets_kses_filtered_storage() {
		add_role(
			'wp_insert_manager_no_html',
			'Ad Manager (no unfiltered_html)',
			[
				'read'           => true,
				'manage_options' => true,
			]
		);
		$user_id = self::factory()->user->create( [ 'role' => 'wp_insert_manager_no_html' ] );
		wp_set_current_user( $user_id );
		$this->assertFalse( current_user_can( 'unfiltered_html' ) );

		$this->post_save_request( self::$ad_inline_js );
		$stored = get_option( 'wp_insert_inpostads' );
		$this->assertArrayHasKey( 'testunit01', $stored );
		$this->assertStringNotContainsString( '<script', $stored['testunit01']['primary_ad_code'] );
	}

	public function test_delete_requires_capability() {
		update_option( 'wp_insert_inpostads', [ 'u1' => self::full_ad_unit() ] );
		$this->_setRole( 'subscriber' );
		$_POST['wp_insert_nonce']      = wp_create_nonce( 'wp-insert' );
		$_POST['wp_insert_type']       = 'inpostads';
		$_POST['wp_insert_identifier'] = 'u1';
		try {
			$this->_handleAjax( 'wp_insert_inpostads_delete_ad_data' );
		} catch ( WPAjaxDieStopException $e ) {
			// Expected: blocked.
			unset( $e );
		} catch ( WPAjaxDieContinueException $e ) {
			unset( $e );
		}
		$this->assertArrayHasKey( 'u1', get_option( 'wp_insert_inpostads' ) );
	}

	public function test_save_rejects_unknown_unit_type() {
		$this->_setRole( 'administrator' );
		$_POST['wp_insert_nonce']      = wp_create_nonce( 'wp-insert' );
		$_POST['wp_insert_type']       = 'arbitrary_option';
		$_POST['wp_insert_identifier'] = 'u1';
		$_POST['wp_insert_parameters'] = [ 'wp_insert_arbitrary_option_u1_field' ];
		try {
			$this->_handleAjax( 'wp_insert_inpostads_save_ad_data' );
		} catch ( WPAjaxDieStopException $e ) {
			unset( $e );
		} catch ( WPAjaxDieContinueException $e ) {
			unset( $e );
		}
		$this->assertFalse( get_option( 'wp_insert_arbitrary_option' ) );
	}

	public function test_header_tracking_code_round_trip() {
		$this->_setRole( 'administrator' );
		$_POST['wp_insert_nonce']                       = wp_create_nonce( 'wp-insert' );
		$_POST['wp_insert_trackingcodes_header_status'] = 'true';
		$_POST['wp_insert_trackingcodes_header_code']   = wp_slash( self::$ad_inline_js );
		try {
			$this->_handleAjax( 'wp_insert_trackingcodes_header_form_save_action' );
		} catch ( WPAjaxDieStopException $e ) {
			unset( $e );
		} catch ( WPAjaxDieContinueException $e ) {
			unset( $e );
		}
		ob_start();
		wp_insert_trackingcodes_header_wp_head();
		$this->assertSame( self::$ad_inline_js, ob_get_clean() );
	}
}
