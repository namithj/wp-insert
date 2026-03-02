<?php
$wp_insert_post_instance;
$wp_insert_a_b_testing_mode;
$wp_insert_v_i_ad_displayed = false;
$wp_insert_geo_location;

/* Begin Ad Unit */
function wp_insert_get_ad_unit( $data, $additional_styles = '' ) {
	/* Begin Ad Styles */
	$adunit_class   = substr( str_shuffle( str_repeat( 'abcdefghijklmnopqrstuvwxyz', 5 ) ), 0, 5 ) . uniqid();
	$ad_unit_styles = wp_insert_get_ad_unit_styles( $data, $adunit_class );
	$ad_unit_code   = wp_insert_get_ad_unit_code( $data );
	if ( '' !== $ad_unit_code ) {
		return '<div class="' . $adunit_class . '" ' . ( ( '' !== $additional_styles ) ? 'style="' . $additional_styles . '"' : '' ) . '>' . $ad_unit_code . '</div>' . $ad_unit_styles;
	}
	return '';
}
/* End Ad Unit */

/* Begin Ad Unit Styles */
function wp_insert_get_ad_unit_styles( $data, $adunit_class ) {
	$ad_breakpoints = [
		'device_large_desktop_width'  => (int) ( ( ! isset( $data['device_large_desktop_width'] ) || ( '' === $data['device_large_desktop_width'] ) ) ? '1200' : $data['device_large_desktop_width'] ),
		'device_medium_desktop_width' => (int) ( ( ! isset( $data['device_medium_desktop_width'] ) || ( '' === $data['device_medium_desktop_width'] ) ) ? '992' : $data['device_medium_desktop_width'] ),
		'device_tablet_width'         => (int) ( ( ! isset( $data['device_tablet_width'] ) || ( '' === $data['device_tablet_width'] ) ) ? '768' : $data['device_tablet_width'] ),
		'device_mobile_width'         => (int) ( ( ! isset( $data['device_mobile_width'] ) || ( '' === $data['device_mobile_width'] ) ) ? '480' : $data['device_mobile_width'] ),
	];
	$ad_unit_styles = '<style type="text/css">' . "\r\n";
	if ( isset( $data['styles'] ) && ( '' !== $data['styles'] ) ) {
		$ad_unit_styles .= '.' . $adunit_class . ' {' . "\r\n";
		$ad_unit_styles .= $data['styles'] . "\r\n";
		$ad_unit_styles .= '}' . "\r\n";
	}
	$ad_unit_styles .= '@media screen and (min-width: ' . ( $ad_breakpoints['device_large_desktop_width'] + 1 ) . 'px) {' . "\r\n";
	$ad_unit_styles .= '.' . $adunit_class . ' {' . "\r\n";
	if ( isset( $data['device_exclude_large_desktop'] ) && wp_validate_boolean( $data['device_exclude_large_desktop'] ) ) {
		$ad_unit_styles .= 'display: none;' . "\r\n";
	} else {
		$ad_unit_styles .= 'display: block;' . "\r\n";
		if ( isset( $data['device_large_desktop_adwidth'] ) && ( '' !== $data['device_large_desktop_adwidth'] ) && ( '0' !== $data['device_large_desktop_adwidth'] ) ) {
			$ad_unit_styles .= 'width: ' . $data['device_large_desktop_adwidth'] . 'px;' . "\r\n";
		}
		if ( isset( $data['device_large_desktop_styles'] ) && ( '' !== $data['device_large_desktop_styles'] ) ) {
			$ad_unit_styles .= $data['device_large_desktop_styles'] . "\r\n";
		}
	}
	$ad_unit_styles .= '}' . "\r\n";
	$ad_unit_styles .= '}' . "\r\n";
	$ad_unit_styles .= '@media screen and (min-width: ' . ( $ad_breakpoints['device_medium_desktop_width'] + 1 ) . 'px) and (max-width: ' . $ad_breakpoints['device_large_desktop_width'] . 'px) {' . "\r\n";
	$ad_unit_styles .= '.' . $adunit_class . ' {' . "\r\n";
	if ( isset( $data['device_exclude_medium_desktop'] ) && wp_validate_boolean( $data['device_exclude_medium_desktop'] ) ) {
		$ad_unit_styles .= 'display: none;' . "\r\n";
	} else {
		$ad_unit_styles .= 'display: block;' . "\r\n";
		if ( isset( $data['device_medium_desktop_adwidth'] ) && ( '' !== $data['device_medium_desktop_adwidth'] ) && ( '0' !== $data['device_medium_desktop_adwidth'] ) ) {
			$ad_unit_styles .= 'width: ' . $data['device_medium_desktop_adwidth'] . 'px;' . "\r\n";
		}
		if ( isset( $data['device_medium_desktop_styles'] ) && ( '' !== $data['device_medium_desktop_styles'] ) ) {
			$ad_unit_styles .= $data['device_medium_desktop_styles'] . "\r\n";
		}
	}
	$ad_unit_styles .= '}' . "\r\n";
	$ad_unit_styles .= '}' . "\r\n";
	$ad_unit_styles .= '@media screen and (min-width: ' . ( $ad_breakpoints['device_tablet_width'] + 1 ) . 'px) and (max-width: ' . $ad_breakpoints['device_medium_desktop_width'] . 'px) {' . "\r\n";
	$ad_unit_styles .= '.' . $adunit_class . ' {' . "\r\n";
	if ( isset( $data['device_exclude_tablet'] ) && wp_validate_boolean( $data['device_exclude_tablet'] ) ) {
		$ad_unit_styles .= 'display: none;' . "\r\n";
	} else {
		$ad_unit_styles .= 'display: block;' . "\r\n";
		if ( isset( $data['device_tablet_adwidth'] ) && ( '' !== $data['device_tablet_adwidth'] ) && ( '0' !== $data['device_tablet_adwidth'] ) ) {
			$ad_unit_styles .= 'width: ' . $data['device_tablet_adwidth'] . 'px;' . "\r\n";
		}
		if ( isset( $data['device_tablet_styles'] ) && ( '' !== $data['device_tablet_styles'] ) ) {
			$ad_unit_styles .= $data['device_tablet_styles'] . "\r\n";
		}
	}
	$ad_unit_styles .= '}' . "\r\n";
	$ad_unit_styles .= '}' . "\r\n";
	$ad_unit_styles .= '@media screen and (min-width: ' . $ad_breakpoints['device_tablet_width'] . 'px) and (max-width: ' . $ad_breakpoints['device_tablet_width'] . 'px) {' . "\r\n";
	$ad_unit_styles .= '.' . $adunit_class . ' {' . "\r\n";
	if ( isset( $data['device_exclude_mobile'] ) && wp_validate_boolean( $data['device_exclude_mobile'] ) ) {
		$ad_unit_styles .= 'display: none;' . "\r\n";
	} else {
		$ad_unit_styles .= 'display: block;' . "\r\n";
		if ( isset( $data['device_mobile_adwidth'] ) && ( '' !== $data['device_mobile_adwidth'] ) && ( '0' !== $data['device_mobile_adwidth'] ) ) {
			$ad_unit_styles .= 'width: ' . $data['device_mobile_adwidth'] . 'px;' . "\r\n";
		}
		if ( isset( $data['device_mobile_styles'] ) && ( '' !== $data['device_mobile_styles'] ) ) {
			$ad_unit_styles .= $data['device_mobile_styles'] . "\r\n";
		}
	}
	$ad_unit_styles .= '}' . "\r\n";
	$ad_unit_styles .= '}' . "\r\n";
	$ad_unit_styles .= '@media screen and (max-width: ' . ( $ad_breakpoints['device_tablet_width'] - 1 ) . 'px) {' . "\r\n";
	$ad_unit_styles .= '.' . $adunit_class . ' {' . "\r\n";
	if ( isset( $data['device_exclude_small_mobile'] ) && wp_validate_boolean( $data['device_exclude_small_mobile'] ) ) {
		$ad_unit_styles .= 'display: none;' . "\r\n";
	} else {
		$ad_unit_styles .= 'display: block;' . "\r\n";
		if ( isset( $data['device_small_mobile_adwidth'] ) && ( '' !== $data['device_small_mobile_adwidth'] ) && ( '0' !== $data['device_small_mobile_adwidth'] ) ) {
			$ad_unit_styles .= 'width: ' . $data['device_small_mobile_adwidth'] . 'px;' . "\r\n";
		}
		if ( isset( $data['device_small_mobile_styles'] ) && ( '' !== $data['device_small_mobile_styles'] ) ) {
			$ad_unit_styles .= $data['device_small_mobile_styles'] . "\r\n";
		}
	}
	$ad_unit_styles .= '}' . "\r\n";
	$ad_unit_styles .= '}' . "\r\n";
	$ad_unit_styles .= '</style>' . "\r\n";
	return $ad_unit_styles;
}
/* End Ad Unit Styles */

/* Begin Ad Unit Code */
function wp_insert_get_ad_unit_code( $data ) {
	global $wp_insert_a_b_testing_mode;
	global $wp_insert_v_i_ad_displayed;
	global $wp_insert_geo_location;

	$ad_unit_code = '';
	if ( ( false !== $wp_insert_geo_location ) && ( '' !== $wp_insert_geo_location ) && ( ( is_array( $data['geo_group1_countries'] ) && ( count( $data['geo_group1_countries'] ) > 0 ) ) || ( is_array( $data['geo_group2_countries'] ) && ( count( $data['geo_group2_countries'] ) > 0 ) ) ) ) {
		if ( ( '' !== $data['geo_group1_adcode'] ) && in_array( $wp_insert_geo_location, $data['geo_group1_countries'], true ) ) {
			$ad_unit_code = do_shortcode( stripslashes( $data['geo_group1_adcode'] ) );
		}
		if ( ( '' !== $data['geo_group2_adcode'] ) && in_array( $wp_insert_geo_location, $data['geo_group2_countries'], true ) ) {
			$ad_unit_code = do_shortcode( stripslashes( $data['geo_group2_adcode'] ) );
		}
	}
	if ( '' === $ad_unit_code ) {
		switch ( $wp_insert_a_b_testing_mode ) {
			case 1:
				if ( isset( $data['primary_ad_code_type'] ) && ( 'vicode' === $data['primary_ad_code_type'] ) ) {
					if ( true !== $wp_insert_v_i_ad_displayed ) {
						$wp_insert_v_i_ad_displayed = true;
						$ad_unit_code               = '<div id="wp_insert_vi_ad">' . wp_insert_vi_api_get_vi_code( 'wp_insert_vi_code_settings' ) . '</div>';
					} else {
						$ad_unit_code = '';
					}
				} else {
					$ad_unit_code = do_shortcode( stripslashes( $data['primary_ad_code'] ) );
				}
				break;
			case 2:
				$ad_unit_code = do_shortcode( stripslashes( $data['secondary_ad_code'] ) );
				break;
			case 3:
				$ad_unit_code = do_shortcode( stripslashes( $data['tertiary_ad_code'] ) );
				break;
			default:
				$ad_unit_code = do_shortcode( stripslashes( $data['primary_ad_code'] ) );
		}
	}
	return $ad_unit_code;
}
/* End Ad Unit Code */

/* Begin Assign Instance Identifier */
add_action( 'the_content', 'wp_insert_track_post_instance', 1 );
function wp_insert_track_post_instance( $content ) {
	global $wp_insert_post_instance;
	if ( is_main_query() ) {
		if ( '' === $wp_insert_post_instance ) {
			$wp_insert_post_instance = 1;
		} else {
			++$wp_insert_post_instance;
		}
	}
	return $content;
}
/* End Assign Instance Identifier */

/* Begin Assign AB Testing Mode */
add_action( 'wp', 'wp_insert_track_ad_instance', 1 );
function wp_insert_track_ad_instance() {
	global $wp_insert_a_b_testing_mode;
	$abtesting_mode = get_option( 'wp_insert_abtesting_mode' );
	if ( isset( $abtesting_mode ) ) {
		$wp_insert_a_b_testing_mode = wp_rand( 1, floatval( $abtesting_mode ) );
	} else {
		$wp_insert_a_b_testing_mode = 1;
	}
}
/* End Assign AB Testing Mode */

/* Begin Get Current Page Type */
function wp_insert_get_page_details() {
	global $post;
	$page_details = [
		'type' => 'POST',
		'ID'   => ( isset( $post->ID ) ? $post->ID : '' ),
	];
	if ( is_home() || is_front_page() ) {
		$page_details['type'] = 'HOME';
	} elseif ( is_category() ) {
		$page_details['type'] = 'CATEGORY';
		$page_details['ID']   = get_query_var( 'cat' );
	} elseif ( is_archive() ) {
		$page_details['type'] = 'ARCHIVE';
	} elseif ( is_search() ) {
		$page_details['type'] = 'SEARCH';
	} elseif ( is_page() ) {
		$page_details['type'] = 'PAGE';
	} elseif ( is_single() ) {
		if ( is_singular( 'post' ) ) {
			$page_details['type']       = 'POST';
			$page_details['categories'] = wp_get_post_categories( $page_details['ID'] );
		} else {
			$page_details['type']      = 'CUSTOM';
			$page_details['type_name'] = $post->post_type;
		}
	} elseif ( is_404() ) {
		$page_details['type'] = '404';
	}
	return $page_details;
}
/* End Get Current Page Type */

/* Begin Get Ad Status */
function wp_insert_get_ad_status( $rules ) {
	if ( ! isset( $rules ) ) {
		return false; }

	if ( ! wp_validate_boolean( $rules['status'] ) ) {
		return false;
	}

	if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
		return false;
	}

	if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
		return false;
	}

	if ( isset( $rules['rules_exclude_loggedin'] ) && wp_validate_boolean( $rules['rules_exclude_loggedin'] ) && is_user_logged_in() ) {
		return false;
	}

	if ( isset( $rules['rules_exclude_mobile_devices'] ) && wp_validate_boolean( $rules['rules_exclude_mobile_devices'] ) && wp_is_mobile() ) {
		return false;
	}

	global $wp_insert_post_instance;
	$page_details = wp_insert_get_page_details();
	switch ( $page_details['type'] ) {
		case 'HOME':
			if ( isset( $rules['rules_exclude_home'] ) && wp_validate_boolean( $rules['rules_exclude_home'] ) ) {
				return false;
			} elseif ( isset( $rules['rules_home_instances'] ) && is_array( $rules['rules_home_instances'] ) && ( in_array( $wp_insert_post_instance, $rules['rules_home_instances'], true ) ) ) {
				return false;
			}
			break;
		case 'ARCHIVE':
			if ( isset( $rules['rules_exclude_archives'] ) && wp_validate_boolean( $rules['rules_exclude_archives'] ) ) {
				return false;
			} elseif ( isset( $rules['rules_archives_instances'] ) && is_array( $rules['rules_archives_instances'] ) && ( in_array( $wp_insert_post_instance, $rules['rules_archives_instances'], true ) ) ) {
				return false;
			}
			break;
		case 'SEARCH':
			if ( isset( $rules['rules_exclude_search'] ) && wp_validate_boolean( $rules['rules_exclude_search'] ) ) {
				return false;
			} elseif ( isset( $rules['rules_search_instances'] ) && is_array( $rules['rules_search_instances'] ) && ( in_array( $wp_insert_post_instance, $rules['rules_search_instances'], true ) ) ) {
				return false;
			}
			break;
		case 'PAGE':
			if ( isset( $rules['rules_exclude_page'] ) && wp_validate_boolean( $rules['rules_exclude_page'] ) ) {
				if ( ( ! isset( $rules['rules_page_exceptions'] ) ) || ( ! is_array( $rules['rules_page_exceptions'] ) ) || ( ! in_array( $page_details['ID'], $rules['rules_page_exceptions'], true ) ) ) {
					return false;
				}
			} elseif ( isset( $rules['rules_page_exceptions'] ) && is_array( $rules['rules_page_exceptions'] ) && ( in_array( $page_details['ID'], $rules['rules_page_exceptions'], true ) ) ) {
				return false;
			}
			break;
		case 'POST':
			if ( isset( $rules['rules_exclude_post'] ) && wp_validate_boolean( $rules['rules_exclude_post'] ) ) {
				if ( ( ! isset( $rules['rules_post_exceptions'] ) ) || ( ! is_array( $rules['rules_post_exceptions'] ) ) || ( ! in_array( $page_details['ID'], $rules['rules_post_exceptions'], true ) ) ) {
					return false;
				} elseif ( ( ! isset( $rules['rules_post_categories_exceptions'] ) ) || ( ! is_array( $rules['rules_post_categories_exceptions'] ) ) || ( ! isset( $page_details['categories'] ) ) || ( ! is_array( $page_details['categories'] ) ) || ( ! ( count( array_intersect( $page_details['categories'], $rules['rules_post_categories_exceptions'] ) ) > 0 ) ) ) {
					return false;
				}
			} elseif ( isset( $rules['rules_post_exceptions'] ) && is_array( $rules['rules_post_exceptions'] ) && ( in_array( $page_details['ID'], $rules['rules_post_exceptions'], true ) ) ) {
				return false;
			} elseif ( isset( $rules['rules_post_categories_exceptions'] ) && isset( $page_details['categories'] ) && is_array( $rules['rules_post_categories_exceptions'] ) && is_array( $page_details['categories'] ) && ( count( array_intersect( $page_details['categories'], $rules['rules_post_categories_exceptions'] ) ) > 0 ) ) {
				return false;
			}
			break;
		case 'CATEGORY':
			if ( isset( $rules['rules_exclude_categories'] ) && wp_validate_boolean( $rules['rules_exclude_categories'] ) ) {
				if ( ( ! isset( $rules['rules_categories_exceptions'] ) ) || ( ! is_array( $rules['rules_categories_exceptions'] ) ) || ( ! in_array( $page_details['ID'], $rules['rules_categories_exceptions'], true ) ) ) {
					return false;
				}
			} elseif ( isset( $rules['rules_categories_exceptions'] ) && is_array( $rules['rules_categories_exceptions'] ) && ( in_array( $page_details['ID'], $rules['rules_categories_exceptions'], true ) ) ) {
				return false;
			} elseif ( isset( $rules['rules_categories_instances'] ) && is_array( $rules['rules_categories_instances'] ) && ( in_array( $wp_insert_post_instance, $rules['rules_categories_instances'], true ) ) ) {
				return false;
			}
			break;
		case '404':
			if ( isset( $rules['rules_exclude_404'] ) && wp_validate_boolean( $rules['rules_exclude_404'] ) ) {
				return false;
			}
			break;
		case 'CUSTOM':
			if ( isset( $rules[ 'rules_exclude_cpt_' . $page_details['type_name'] ] ) && wp_validate_boolean( $rules[ 'rules_exclude_cpt_' . $page_details['type_name'] ] ) ) {
				return false;
			}
			break;
	}
	return true;
}
/* End Get Ad Status */
