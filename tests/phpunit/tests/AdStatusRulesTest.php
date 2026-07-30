<?php
/**
 * Characterization tests for wp_insert_get_ad_status() rules gating.
 *
 * @package wp-insert
 */

class AdStatusRulesTest extends WP_UnitTestCase {
	use AdFixtures;

	public function tear_down() {
		global $wpInsertPostInstance;
		$wpInsertPostInstance = '';
		wp_set_current_user( 0 );
		parent::tear_down();
	}

	public function test_enabled_unit_is_active_on_single_post() {
		$post_id = self::factory()->post->create();
		$this->go_to( get_permalink( $post_id ) );
		$this->assertTrue( wp_insert_get_ad_status( self::full_ad_unit() ) );
	}

	public function test_disabled_status_deactivates_unit() {
		$post_id = self::factory()->post->create();
		$this->go_to( get_permalink( $post_id ) );
		$this->assertFalse( wp_insert_get_ad_status( self::full_ad_unit( [ 'status' => '' ] ) ) );
	}

	public function test_logged_in_exclusion() {
		$post_id = self::factory()->post->create();
		$this->go_to( get_permalink( $post_id ) );
		$rules = self::full_ad_unit( [ 'rules_exclude_loggedin' => 'true' ] );

		$this->assertTrue( wp_insert_get_ad_status( $rules ), 'Anonymous visitors should see the ad' );

		wp_set_current_user( self::factory()->user->create( [ 'role' => 'subscriber' ] ) );
		$this->assertFalse( wp_insert_get_ad_status( $rules ), 'Logged-in users should not see the ad' );
	}

	public function test_home_exclusion() {
		$this->go_to( '/' );
		$this->assertFalse( wp_insert_get_ad_status( self::full_ad_unit( [ 'rules_exclude_home' => 'true' ] ) ) );
		$this->assertTrue( wp_insert_get_ad_status( self::full_ad_unit() ) );
	}

	public function test_page_exclusion_with_exceptions() {
		$page_id  = self::factory()->post->create( [ 'post_type' => 'page' ] );
		$other_id = self::factory()->post->create( [ 'post_type' => 'page' ] );

		$this->go_to( get_permalink( $page_id ) );
		$exclude_all = self::full_ad_unit( [ 'rules_exclude_page' => 'true' ] );
		$this->assertFalse( wp_insert_get_ad_status( $exclude_all ) );

		$with_exception = self::full_ad_unit(
			[
				'rules_exclude_page'    => 'true',
				'rules_page_exceptions' => [ (string) $page_id ],
			]
		);
		$this->assertTrue( wp_insert_get_ad_status( $with_exception ), 'Excepted page should still show the ad' );

		$this->go_to( get_permalink( $other_id ) );
		$this->assertFalse( wp_insert_get_ad_status( $with_exception ), 'Non-excepted page stays excluded' );
	}

	public function test_page_exceptions_without_global_exclusion_hide_listed_pages() {
		$page_id = self::factory()->post->create( [ 'post_type' => 'page' ] );
		$this->go_to( get_permalink( $page_id ) );
		$rules = self::full_ad_unit( [ 'rules_page_exceptions' => [ (string) $page_id ] ] );
		$this->assertFalse( wp_insert_get_ad_status( $rules ) );
	}

	public function test_post_exclusion_via_exceptions_list() {
		$post_id = self::factory()->post->create();
		$this->go_to( get_permalink( $post_id ) );
		$rules = self::full_ad_unit( [ 'rules_post_exceptions' => [ (string) $post_id ] ] );
		$this->assertFalse( wp_insert_get_ad_status( $rules ) );
	}

	public function test_post_category_exclusion() {
		$cat_id  = self::factory()->category->create();
		$post_id = self::factory()->post->create( [ 'post_category' => [ $cat_id ] ] );
		$this->go_to( get_permalink( $post_id ) );
		$rules = self::full_ad_unit( [ 'rules_post_categories_exceptions' => [ (string) $cat_id ] ] );
		$this->assertFalse( wp_insert_get_ad_status( $rules ) );
	}

	public function test_404_exclusion() {
		$this->go_to( '/?p=999999999' );
		$this->assertFalse( wp_insert_get_ad_status( self::full_ad_unit( [ 'rules_exclude_404' => 'true' ] ) ) );
		$this->assertTrue( wp_insert_get_ad_status( self::full_ad_unit() ) );
	}

	/**
	 * @group php8-compat
	 */
	public function test_legacy_minimal_unit_defaults_to_active() {
		$post_id = self::factory()->post->create();
		$this->go_to( get_permalink( $post_id ) );
		$this->assertTrue( wp_insert_get_ad_status( self::legacy_ad_unit() ) );
	}
}
