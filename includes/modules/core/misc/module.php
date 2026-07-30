<?php
/* Begin AJAX Capability Guard */
add_action( 'check_ajax_referer', 'wp_insert_ajax_capability_guard', 10, 1 );
function wp_insert_ajax_capability_guard( $handlerAction ) {
	$adminOnlyActions = [ 'wp-insert', 'wp-insert-admin-notice', 'wp-insert-adstxt-adsense-admin-notice' ];
	if ( in_array( $handlerAction, $adminOnlyActions, true ) && ! current_user_can( 'manage_options' ) ) {
		wp_die( -1, 403 );
	}
	if ( ( 'wp-insert-gutenberg' === $handlerAction ) && ! current_user_can( 'edit_posts' ) ) {
		wp_die( -1, 403 );
	}
}
/* End AJAX Capability Guard */

/* Begin Ad Unit Types */
function wp_insert_get_ad_unit_types() {
	return [ 'inpostads', 'adwidgets', 'shortcodeads', 'inthemeads', 'pagelevelads' ];
}

function wp_insert_get_ad_code_fields() {
	return [ 'primary_ad_code', 'secondary_ad_code', 'tertiary_ad_code', 'geo_group1_adcode', 'geo_group2_adcode' ];
}

/**
 * Sanitize a single ad unit field on save.
 *
 * Ad code fields are stored raw (slashed, matching the legacy storage format the
 * render pipeline expects) for users with the `unfiltered_html` capability; other
 * users get wp_kses_post filtering. All remaining fields receive standard
 * WordPress sanitization.
 *
 * @param string       $field Field name (without prefixes).
 * @param string|array $value Raw (slashed) request value.
 * @return string|array
 */
function wp_insert_sanitize_ad_field( $field, $value ) {
	if ( in_array( $field, wp_insert_get_ad_code_fields(), true ) ) {
		if ( current_user_can( 'unfiltered_html' ) ) {
			return $value;
		}
		return wp_slash( wp_kses_post( wp_unslash( $value ) ) );
	}
	if ( is_array( $value ) ) {
		return array_map( 'sanitize_text_field', $value );
	}
	if ( ( 'styles' === $field ) || ( 'notes' === $field ) || ( '_styles' === substr( $field, -7 ) ) ) {
		return sanitize_textarea_field( $value );
	}
	return sanitize_text_field( $value );
}
/* End Ad Unit Types */

/* Begin Version Upgrade */
add_action( 'init', 'wp_insert_upgrade_version', 0 );
function wp_insert_upgrade_version() {
	$databaseVersion = get_option( 'wp_insert_version' );
	if ( $databaseVersion != WP_INSERT_VERSION ) {
		do_action( 'wp_insert_upgrade_database' );
		update_option( 'wp_insert_version', WP_INSERT_VERSION );
	}
}
/* End Version Upgrade */

/* Begin Misc Functions */
function wp_insert_add_ordinal_number_suffix( $num ) {
	if ( ! in_array( ( $num % 100 ), [ 11, 12, 13 ] ) ) {
		switch ( $num % 10 ) {
			case 1:
				return $num . 'st';
			case 2:
				return $num . 'nd';
			case 3:
				return $num . 'rd';
		}
	}
	return $num . 'th';
}

function wp_insert_get_domain_name_from_url( $url ) {
	$pieces = parse_url( $url );
	$domain = isset( $pieces['host'] ) ? $pieces['host'] : '';
	if ( preg_match( '/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs ) ) {
		return $regs['domain'];
	}
	return false;
}
/* End Misc Functions */
