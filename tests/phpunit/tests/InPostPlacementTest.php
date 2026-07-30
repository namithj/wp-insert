<?php
/**
 * Characterization tests for the `the_content` in-post ad placements.
 *
 * @package wp-insert
 */

class InPostPlacementTest extends WP_UnitTestCase {
	use AdFixtures;

	protected static $paragraphs = "Paragraph one lorem ipsum dolor sit amet.\n\nParagraph two consectetur adipiscing elit.\n\nParagraph three sed do eiusmod tempor.\n\nParagraph four ut labore et dolore magna.";

	public function set_up() {
		parent::set_up();
		delete_option( 'wp_insert_inpostads' );
	}

	public function tear_down() {
		global $wpInsertPostInstance, $wpInsertABTestingMode;
		$wpInsertPostInstance  = '';
		$wpInsertABTestingMode = null;
		delete_option( 'wp_insert_inpostads' );
		parent::tear_down();
	}

	/**
	 * Create a post, visit it and return its filtered content.
	 *
	 * @param string $content Raw post content.
	 * @return string
	 */
	protected function render_post( $content = null ) {
		$content = ( null === $content ) ? self::$paragraphs : $content;
		$post_id = self::factory()->post->create( [ 'post_content' => $content ] );
		$this->go_to( get_permalink( $post_id ) );
		$GLOBALS['post'] = get_post( $post_id );
		setup_postdata( $GLOBALS['post'] );
		return apply_filters( 'the_content', $GLOBALS['post']->post_content );
	}

	protected function set_units( array $units ) {
		update_option( 'wp_insert_inpostads', $units );
	}

	/**
	 * @dataProvider data_ad_code_fixtures
	 */
	public function test_above_placement_prepends_ad_unit( $ad_code ) {
		$unit = self::full_ad_unit(
			[
				'location'                => 'above',
				'primary_ad_code'         => $ad_code,
				'minimum_character_count' => '',
				'paragraph_buffer_count'  => '',
			]
		);
		$this->set_units( [ 'u1' => $unit ] );
		$rendered = self::normalize_ad_classes( $this->render_post() );
		$expected = self::normalize_ad_classes( wp_insert_get_ad_unit( $unit ) );
		$this->assertStringStartsWith( $expected, $rendered );
		$this->assertSame( 1, substr_count( $rendered, $ad_code ) );
	}

	public function data_ad_code_fixtures() {
		return self::ad_code_fixtures();
	}

	public function test_below_placement_appends_ad_unit() {
		$unit = self::full_ad_unit(
			[
				'location'                => 'below',
				'primary_ad_code'         => self::$ad_iframe,
				'minimum_character_count' => '',
				'paragraph_buffer_count'  => '',
			]
		);
		$this->set_units( [ 'u1' => $unit ] );
		$rendered = self::normalize_ad_classes( $this->render_post() );
		$expected = self::normalize_ad_classes( wp_insert_get_ad_unit( $unit ) );
		$this->assertStringEndsWith( $expected, $rendered );
	}

	public function test_middle_placement_inserts_after_second_paragraph() {
		$unit = self::full_ad_unit(
			[
				'location'                => 'middle',
				'primary_ad_code'         => self::$ad_html,
				'minimum_character_count' => '',
				'paragraph_buffer_count'  => '',
			]
		);
		$this->set_units( [ 'u1' => $unit ] );
		$rendered = self::normalize_ad_classes( $this->render_post() );
		$this->assertMatchesRegularExpression( '#adipiscing elit\.</p><div class="ADCLS"\s*>#', $rendered );
		$this->assertSame( 1, substr_count( $rendered, self::$ad_html ) );
	}

	public function test_middle_placement_honors_paragraph_buffer_count() {
		$unit = self::full_ad_unit(
			[
				'location'                => 'middle',
				'primary_ad_code'         => self::$ad_html,
				'minimum_character_count' => '',
				'paragraph_buffer_count'  => '3',
			]
		);
		$this->set_units( [ 'u1' => $unit ] );
		$rendered = self::normalize_ad_classes( $this->render_post() );
		$this->assertMatchesRegularExpression( '#eiusmod tempor\.</p><div class="ADCLS"\s*>#', $rendered );
	}

	public function test_middle_placement_respects_minimum_character_count() {
		$unit = self::full_ad_unit(
			[
				'location'                => 'middle',
				'primary_ad_code'         => self::$ad_html,
				'minimum_character_count' => '100000',
				'paragraph_buffer_count'  => '',
			]
		);
		$this->set_units( [ 'u1' => $unit ] );
		$this->assertStringNotContainsString( self::$ad_html, $this->render_post() );
	}

	public function test_left_and_right_placements_float_the_wrapper() {
		$left  = self::full_ad_unit(
			[
				'location'                => 'left',
				'primary_ad_code'         => 'LEFTAD',
				'minimum_character_count' => '',
				'paragraph_buffer_count'  => '',
			]
		);
		$right = self::full_ad_unit(
			[
				'location'                => 'right',
				'primary_ad_code'         => 'RIGHTAD',
				'minimum_character_count' => '',
				'paragraph_buffer_count'  => '',
			]
		);
		$this->set_units(
			[
				'u1' => $left,
				'u2' => $right,
			]
		);
		$rendered = $this->render_post();
		$this->assertStringContainsString( 'style="float: left;">LEFTAD</div>', $rendered );
		$this->assertStringContainsString( 'style="float: right;">RIGHTAD</div>', $rendered );
	}

	public function test_paragraphtop_placement_inserts_after_nth_paragraph_from_top() {
		$unit = self::full_ad_unit(
			[
				'location'                => 'paragraphtop',
				'paragraphtopposition'    => '1',
				'primary_ad_code'         => self::$ad_html,
				'minimum_character_count' => '',
				'paragraph_buffer_count'  => '',
			]
		);
		$this->set_units( [ 'u1' => $unit ] );
		$rendered = self::normalize_ad_classes( $this->render_post() );
		$this->assertMatchesRegularExpression( '#dolor sit amet\.</p><div class="ADCLS"\s*>#', $rendered );
	}

	public function test_paragraphbottom_placement_inserts_counting_from_bottom() {
		$unit = self::full_ad_unit(
			[
				'location'                => 'paragraphbottom',
				'paragraphbottomposition' => '1',
				'primary_ad_code'         => self::$ad_html,
				'minimum_character_count' => '',
				'paragraph_buffer_count'  => '',
			]
		);
		$this->set_units( [ 'u1' => $unit ] );
		$rendered = self::normalize_ad_classes( $this->render_post() );
		$this->assertMatchesRegularExpression( '#eiusmod tempor\.</p><div class="ADCLS"\s*>#', $rendered );
	}

	/**
	 * @group php8-compat
	 */
	public function test_legacy_keyed_units_derive_location_from_key() {
		$this->set_units(
			[
				'above' => self::legacy_ad_unit( [ 'primary_ad_code' => 'LEGACY-ABOVE' ] ),
				'below' => self::legacy_ad_unit( [ 'primary_ad_code' => 'LEGACY-BELOW' ] ),
			]
		);
		$rendered = self::normalize_ad_classes( $this->render_post() );
		$this->assertMatchesRegularExpression( '#^<div class="ADCLS"\s*>LEGACY-ABOVE</div>#', $rendered );
		$this->assertStringContainsString( 'LEGACY-BELOW', $rendered );
	}

	/**
	 * @group php8-compat
	 */
	public function test_legacy_middle_unit_without_positioning_fields_uses_midpoint() {
		$this->set_units( [ 'middle' => self::legacy_ad_unit( [ 'primary_ad_code' => self::$ad_html ] ) ] );
		$rendered = self::normalize_ad_classes( $this->render_post() );
		$this->assertMatchesRegularExpression( '#adipiscing elit\.</p><div class="ADCLS"\s*>#', $rendered );
	}

	public function test_disabled_unit_is_not_rendered() {
		$unit = self::full_ad_unit(
			[
				'location'                => 'above',
				'status'                  => '',
				'primary_ad_code'         => self::$ad_html,
				'minimum_character_count' => '',
				'paragraph_buffer_count'  => '',
			]
		);
		$this->set_units( [ 'u1' => $unit ] );
		$this->assertStringNotContainsString( self::$ad_html, $this->render_post() );
	}

	public function test_shortcode_placed_unit_is_not_auto_inserted() {
		$unit = self::full_ad_unit(
			[
				'location'                => 'above',
				'primary_ad_code'         => self::$ad_html,
				'minimum_character_count' => '',
				'paragraph_buffer_count'  => '',
			]
		);
		$this->set_units( [ 'u1' => $unit ] );
		$content  = "Intro paragraph.\n\n[wpinsertinpostad id=\"u1\"]\n\nOutro paragraph.";
		$rendered = $this->render_post( $content );
		// Rendered exactly once — via the shortcode, not the auto placement.
		// (Core's wp_filter_content_tags may decorate the <img>, so match on a
		// stable substring rather than the full fixture.)
		$this->assertSame( 1, substr_count( $rendered, 'banner-728x90.png' ) );
		$this->assertSame( 1, substr_count( $rendered, 'class="my-banner"' ) );
		$this->assertStringNotContainsString( 'wpinsertinpostad', $rendered );
		// Not prepended above the content.
		$this->assertMatchesRegularExpression( '#^\s*<p>Intro paragraph\.#', $rendered );
	}

	public function test_feed_requests_are_untouched() {
		$unit = self::full_ad_unit(
			[
				'location'                => 'above',
				'primary_ad_code'         => self::$ad_html,
				'minimum_character_count' => '',
				'paragraph_buffer_count'  => '',
			]
		);
		$this->set_units( [ 'u1' => $unit ] );
		$post_id = self::factory()->post->create( [ 'post_content' => self::$paragraphs ] );
		$this->go_to( '/?feed=rss2' );
		$GLOBALS['post'] = get_post( $post_id );
		$rendered        = apply_filters( 'the_content', $GLOBALS['post']->post_content );
		$this->assertStringNotContainsString( self::$ad_html, $rendered );
	}
}
