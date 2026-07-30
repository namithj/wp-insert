<?php
/**
 * Characterization tests for the Wp-Insert ad widget.
 *
 * @package wp-insert
 */

class WidgetTest extends WP_UnitTestCase {
	use AdFixtures;

	public function tear_down() {
		delete_option( 'wp_insert_adwidgets' );
		parent::tear_down();
	}

	protected function render_widget( array $instance ) {
		ob_start();
		the_widget(
			'wpInsertAdWidget',
			$instance,
			[
				'before_widget' => '<section class="widget">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2>',
				'after_title'   => '</h2>',
			]
		);
		return ob_get_clean();
	}

	/**
	 * @dataProvider data_ad_code_fixtures
	 */
	public function test_widget_renders_selected_ad_unit( $ad_code ) {
		update_option(
			'wp_insert_adwidgets',
			[ 'w1' => self::full_ad_unit( [ 'primary_ad_code' => $ad_code ] ) ]
		);
		$output = $this->render_widget(
			[
				'title'    => 'Sponsored',
				'instance' => 'w1',
			]
		);
		$this->assertStringContainsString( '<section class="widget">', $output );
		$this->assertStringContainsString( '<h2>Sponsored</h2>', $output );
		$this->assertStringContainsString( $ad_code, $output );
		$this->assertStringEndsWith( '</section>', trim( $output ) );
	}

	public function data_ad_code_fixtures() {
		return self::ad_code_fixtures();
	}

	public function test_widget_without_title_omits_title_markup() {
		update_option(
			'wp_insert_adwidgets',
			[ 'w1' => self::full_ad_unit( [ 'primary_ad_code' => self::$ad_html ] ) ]
		);
		$output = $this->render_widget(
			[
				'title'    => '',
				'instance' => 'w1',
			]
		);
		$this->assertStringNotContainsString( '<h2>', $output );
		$this->assertStringContainsString( self::$ad_html, $output );
	}

	public function test_widget_with_disabled_unit_outputs_nothing() {
		update_option(
			'wp_insert_adwidgets',
			[ 'w1' => self::full_ad_unit( [ 'status' => '' ] ) ]
		);
		$output = $this->render_widget(
			[
				'title'    => 'Sponsored',
				'instance' => 'w1',
			]
		);
		$this->assertSame( '', $output );
	}
}
