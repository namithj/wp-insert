<?php
/* Begin Include Files */
require_once __DIR__ . '/adunit.php';
require_once __DIR__ . '/adcode.php';
require_once __DIR__ . '/device-styles.php';
if ( ! class_exists( 'iriven\\GeoIPCountry' ) ) {
	require_once __DIR__ . '/GeoIp/GeoIPCountry.php';
}
require_once __DIR__ . '/geo-targeting.php';
require_once __DIR__ . '/notes.php';
require_once __DIR__ . '/rules.php';
/* End Include Files */

/* Begin Add Assets */
add_action( 'wp_insert_modules_js', 'wp_insert_module_adform_js', 0 );
function wp_insert_module_adform_js() {
	wp_register_script( 'wp-insert-module-adform-js', WP_INSERT_URL . 'includes/modules/core/units/js/module.js', [ 'wp-insert-js' ], WP_INSERT_VERSION . ( ( WP_INSERT_DEBUG ) ? wp_rand( 0, 9999 ) : '' ), true );
	wp_enqueue_script( 'wp-insert-module-adform-js' );
}
/* End Add Assets */

/* Begin Get Admin Panel Card*/
function wp_insert_get_plugin_card( $title, $description, $type, $preTitle ) {
	echo '<div class="plugin-card">';
		echo '<div class="plugin-card-top">';
			echo '<h4>' . esc_html( $title ) . '</h4>';
			echo wp_kses_post( $description );
		echo '</div>';
		echo '<div class="plugin-card-bottom">';
			$data = get_option( 'wp_insert_' . $type );
	if ( isset( $data ) && is_array( $data ) ) {
		foreach ( $data as $key => $value ) {
			/* Begin Workaround for migrating old users to new system (can be removed in a later version) */
			$title = $key;
			if ( ! isset( $value['title'] ) || ( $value['title'] == '' ) ) {
				switch ( $key ) {
					case 'above':
						$title = 'Above Post Content';
						break;
					case 'middle':
						$title = 'Middle of Post Content';
						break;
					case 'below':
						$title = 'Below Post Content';
						break;
					case 'left':
						$title = 'To the Left of Post Content';
						break;
					case 'right':
						$title = 'To the Right of Post Content';
						break;
				}
			} else {
				$title = $value['title'];
			}
			$title = sanitize_text_field( $title );
			/* End Workaround for migrating old users to new system (can be removed in a later version) */
			// Titles and keys are interpolated into inline JS handler arguments,
			// so they are escaped for a JS string context, not just for HTML.
			$jsTitle = esc_js( $title );
			$jsKey   = esc_js( $key );
			$jsType  = esc_js( $type );
			echo '<p>';
				echo '<a class="wp_insert_ad_unit_title" title="Edit Ad Unit" id="wp_insert_' . esc_attr( $type . '_ad_' . $key ) . '" href="javascript:;" data-pre-title="' . esc_attr( $preTitle ) . '" onclick="wp_insert_ads_click_handler(\'' . esc_attr( $jsType ) . '\', \'' . esc_attr( $jsKey ) . '\', \'' . esc_attr( $jsTitle ) . '\', false)">' . esc_html( $preTitle . ' : ' . $title ) . '</a>';
				echo '<span class="dashicons dashicons-no wp_insert_delete_icon" title="Delete Ad Unit" onclick="wp_insert_ad_delete_handler(\'' . esc_attr( $jsType ) . '\', \'' . esc_attr( $jsKey ) . '\')"></span>';
				echo '<span class="dashicons dashicons-format-gallery wp_insert_duplicate_icon" title="Duplicate Ad Unit" onclick="wp_insert_ads_click_handler(\'' . esc_attr( $jsType ) . '\', \'###DUPLICATE###' . esc_attr( $jsKey ) . '\', \'' . esc_attr( $jsTitle ) . ' Duplicate\', true)"></span>';
			echo '</p>';
		}
	}
			echo '<p style="text-align: center; padding: 20px 0 10px;"><a id="wp_insert_' . esc_attr( $type ) . '_ad_new" data-pre-title="' . esc_attr( $preTitle ) . '" href="#" class="button-secondary" onclick="wp_insert_ads_click_handler(\'' . esc_attr( esc_js( $type ) ) . '\', \'new\', \'Add New\', true)">Add New</a></p>';
		echo '</div>';
	echo '</div>';
}
/* End Get Admin Panel Card*/

/* Begin Get Ad Form */
function wp_insert_get_ad_form( $script = '' ) {
	check_ajax_referer( 'wp-insert', 'wp_insert_nonce' );
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( -1, 403 );
	}
	if ( isset( $_POST['wp_insert_identifier'] ) && isset( $_POST['wp_insert_type'] ) ) {
		$type = sanitize_key( wp_unslash( $_POST['wp_insert_type'] ) );
		if ( ! in_array( $type, wp_insert_get_ad_unit_types(), true ) ) {
			wp_die( -1, 400 );
		}
		$requestIdentifier = sanitize_text_field( wp_unslash( $_POST['wp_insert_identifier'] ) );
		$data              = get_option( 'wp_insert_' . $type );

		$identifier     = substr( str_shuffle( str_repeat( 'abcdefghijklmnopqrstuvwxyz', 5 ) ), 0, 5 ) . uniqid();
		$dataIdentifier = $identifier;
		if ( strpos( $requestIdentifier, '###DUPLICATE###' ) !== false ) {
			$dataIdentifier = sanitize_key( str_replace( '###DUPLICATE###', '', $requestIdentifier ) );
			if ( isset( $data[ $dataIdentifier ] ) ) {
				$data[ $dataIdentifier ]['title'] = ( $data[ $dataIdentifier ]['title'] ?? '' ) . ' (Duplicate)';
			}
		} elseif ( $requestIdentifier != 'new' ) {
			$identifier     = sanitize_key( $requestIdentifier );
			$dataIdentifier = $identifier;
		}

		echo '<div class="wp_insert_popup_content_wrapper">';
			$control = new smartlogixControls(
				[
					'optionIdentifier' => 'wp_insert_' . $type . '[' . $identifier . ']',
					'values'           => ( ( isset( $data[ $dataIdentifier ] ) && is_array( $data[ $dataIdentifier ] ) ) ? $data[ $dataIdentifier ] : [] ),
				]
			);
			$control->add_control(
				[
					'type'       => 'ipCheckbox',
					'className'  => 'wp_insert_' . $type . '_status',
					'optionName' => 'status',
				]
			);
			$control->add_control(
				[
					'type'       => 'hidden',
					'className'  => 'wp_insert_' . $type . '_identifier',
					'optionName' => 'identifier',
					'value'      => $identifier,
				]
			);
			wp_insert_echo_html( $control->HTML );
			$control->clear_controls();
			echo '<div id="wp_insert_' . esc_attr( $type . '_' . $identifier ) . '_accordion">';
				$control = apply_filters( 'wp_insert_' . $type . '_form_accordion_tabs', $control, $identifier, $type );
			echo '</div>';
			echo '<script type="text/javascript">';
				wp_insert_echo_html( $control->JS );
				echo 'jQuery("#wp_insert_' . esc_js( $type . '_' . $identifier ) . '_accordion").accordion({ icons: { header: "ui-icon-circle-arrow-e", activeHeader: "ui-icon-circle-arrow-s" }, heightStyle: "auto" });';
		if ( $script != '' ) {
			// $script is a plugin-authored JS snippet (module.php literals only);
			// the identifier substituted into it is sanitize_key()'d above.
			wp_insert_echo_html( str_replace( '###IDENTIFIER###', $identifier, $script ) );
		}
			echo '</script>';
		echo '</div>';
	}
	wp_die();
}
/* End Get Ad Form */

/* Begin Save Ad Data */
function wp_insert_save_ad_data() {
	check_ajax_referer( 'wp-insert', 'wp_insert_nonce' );
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( -1, 403 );
	}
	$type       = ( isset( $_POST['wp_insert_type'] ) ? sanitize_key( wp_unslash( $_POST['wp_insert_type'] ) ) : '' );
	$identifier = ( isset( $_POST['wp_insert_identifier'] ) ? sanitize_key( wp_unslash( $_POST['wp_insert_identifier'] ) ) : '' );
	if ( ( $identifier != '' ) && in_array( $type, wp_insert_get_ad_unit_types(), true ) && ( isset( $_POST['wp_insert_parameters'] ) && is_array( $_POST['wp_insert_parameters'] ) ) ) {
		$parameters = array_map( 'sanitize_key', wp_unslash( $_POST['wp_insert_parameters'] ) );
		$data       = get_option( 'wp_insert_' . $type );
		if ( ! is_array( $data ) ) {
			$data = [];
		}
		foreach ( $parameters as $parameter ) {
			$field = str_replace( [ 'wp_insert_', $type . '_', $identifier . '_' ], '', $parameter );
			// Ad code must reach the option table unmodified for unfiltered_html
			// users; wp_insert_sanitize_ad_field() handles the per-field rules.
			// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.ValidatedSanitizedInput.MissingUnslash
			$data[ $identifier ][ $field ] = wp_insert_sanitize_ad_field( $field, ( ( isset( $_POST[ $parameter ] ) ) ? $_POST[ $parameter ] : '' ) );
		}
		update_option( 'wp_insert_' . $type, $data );

		if ( function_exists( 'wp_insert_adstxt_adsense_admin_notice_reset' ) ) {
			wp_insert_adstxt_adsense_admin_notice_reset();
		}
	}
	wp_die();
}
/* End Save Ad Data */

/* Begin Delete Ad Data */
function wp_insert_delete_ad_data() {
	check_ajax_referer( 'wp-insert', 'wp_insert_nonce' );
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( -1, 403 );
	}
	$type       = ( isset( $_POST['wp_insert_type'] ) ? sanitize_key( wp_unslash( $_POST['wp_insert_type'] ) ) : '' );
	$identifier = ( isset( $_POST['wp_insert_identifier'] ) ? sanitize_key( wp_unslash( $_POST['wp_insert_identifier'] ) ) : '' );
	if ( ( $identifier != '' ) && in_array( $type, wp_insert_get_ad_unit_types(), true ) ) {
		$data = get_option( 'wp_insert_' . $type );
		unset( $data[ $identifier ] );
		update_option( 'wp_insert_' . $type, $data );

		if ( function_exists( 'wp_insert_adstxt_adsense_admin_notice_reset' ) ) {
			wp_insert_adstxt_adsense_admin_notice_reset();
		}
	}
	wp_die();
}
/* End Delete Ad Data */
