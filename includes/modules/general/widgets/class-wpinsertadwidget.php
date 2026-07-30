<?php
/**
 * Wp-Insert ad widget.
 *
 * @package wp-insert
 */

class wpInsertAdWidget extends WP_Widget {
	public function __construct() {
		parent::__construct( 'wp_insert_ad_widget', 'Wp-Insert Ad Widget', [ 'description' => 'Wp-Insert Ad Widget' ] );
	}

	public function widget( $args, $instance ) {
		$title     = apply_filters( 'widget_title', ( isset( $instance['title'] ) ? $instance['title'] : '' ) );
		$adwidgets = get_option( 'wp_insert_adwidgets' );
		if ( isset( $instance['instance'], $adwidgets[ $instance['instance'] ] ) && is_array( $adwidgets[ $instance['instance'] ] ) ) {
			if ( wp_insert_get_ad_status( $adwidgets[ $instance['instance'] ] ) ) {
				// Theme-supplied wrappers are trusted markup, matching core widget behavior.
				wp_insert_echo_html( $args['before_widget'] ?? '' );
				if ( ! empty( $title ) ) {
					wp_insert_echo_html( ( $args['before_title'] ?? '' ) . esc_html( $title ) . ( $args['after_title'] ?? '' ) );
				}
				wp_insert_echo_ad_code( wp_insert_get_ad_unit( $adwidgets[ $instance['instance'] ] ) );
				wp_insert_echo_html( $args['after_widget'] ?? '' );
			}
		}
	}

	public function update( $new_opts, $old_opts ) {
		$opts             = [];
		$opts['title']    = sanitize_text_field( $new_opts['title'] ?? '' );
		$opts['instance'] = sanitize_key( $new_opts['instance'] ?? '' );
		return $opts;
	}

	public function form( $instance ) {
		$adwidgets = get_option( 'wp_insert_adwidgets' );
		echo '<p>';
			echo '<label for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">' . esc_html__( 'Title:', 'wp-insert' ) . '</label>';
			echo '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" type="text" value="' . esc_attr( $instance['title'] ?? '' ) . '" />';
		echo '</p>';
		echo '<p>';
		if ( is_array( $adwidgets ) && ( count( $adwidgets ) > 0 ) ) {
			echo '<label for="' . esc_attr( $this->get_field_id( 'instance' ) ) . '">' . esc_html__( 'Select Ad-Widget:', 'wp-insert' ) . '</label>';
			echo '<select class="widefat" id="' . esc_attr( $this->get_field_id( 'instance' ) ) . '" name="' . esc_attr( $this->get_field_name( 'instance' ) ) . '">';
			foreach ( $adwidgets as $identifier => $adwidget ) {
				echo '<option value="' . esc_attr( $identifier ) . '" ' . selected( $identifier, ( $instance['instance'] ?? '' ), false ) . '>' . esc_html( 'Ad Widget : ' . ( $adwidget['title'] ?? '' ) ) . '</option>';
			}
				echo '</select>';
		} else {
			printf(
				/* translators: %s: URL of the Wp-Insert settings page. */
				esc_html__( 'Please %s to Proceed.', 'wp-insert' ),
				'<a href="' . esc_url( admin_url( 'admin.php?page=wp-insert' ) ) . '">' . esc_html__( 'Configure an Ad-Widget', 'wp-insert' ) . '</a>'
			);
			echo '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'instance' ) ) . '" name="' . esc_attr( $this->get_field_name( 'instance' ) ) . '" type="hidden" value="" />';
		}
		echo '</p>';
	}
}
