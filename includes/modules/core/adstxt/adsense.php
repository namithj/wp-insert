<?php
/* Begin Admin Notice */
add_action( 'init', 'wp_insert_adstxt_adsense_admin_notice_reactivate' );
function wp_insert_adstxt_adsense_admin_notice_reactivate() {
	if ( isset( $_GET['wp_insert_adstxt_adsense_reset'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		wp_insert_adstxt_adsense_admin_notice_reset();
		wp_safe_redirect( esc_url( admin_url( '/admin.php?page=wp-insert' ) ) );
		exit;
	}
}

function wp_insert_adstxt_adsense_admin_notice_reset() {
	delete_option( 'wp_insert_adstxt_adsense_admin_notice_dismissed' );
	delete_transient( 'wp_insert_adstxt_adsense_autocheck_content' );
}

add_action( 'admin_notices', 'wp_insert_adstxt_adsense_admin_notice' );
function wp_insert_adstxt_adsense_admin_notice() {
	if ( current_user_can( 'manage_options' ) ) {
		if ( ! get_option( 'wp_insert_adstxt_adsense_admin_notice_dismissed' ) ) {
			$adstxt_new_adsense_entries = get_transient( 'wp_insert_adstxt_adsense_autocheck_content' );
			if ( '###CHECKED###' !== $adstxt_new_adsense_entries ) {
				if ( false === $adstxt_new_adsense_entries ) {
					$adstxt_new_adsense_entries = wp_insert_adstxt_adsense_get_status();
				}
				if ( false !== $adstxt_new_adsense_entries ) {
					set_transient( 'wp_insert_adstxt_adsense_autocheck_content', $adstxt_new_adsense_entries, DAY_IN_SECONDS );
					echo '<div class="notice notice-error wp_insert_adstxt_adsense_notice is-dismissible" style="padding: 15px;">';
					echo '<p><b>Wp-Insert</b> had detected that your ads.txt file does not have all your Google Adsense Publisher IDs.<br />This will severely impact your adsense earnings and your immediate attention is required.</p>';
					echo '<p>Your recommended google entries for ads.txt is as given below.<br />You can manually copy this to your ads.txt file or ';
					$screen = get_current_screen();
					if ( 'toplevel_page_wp-insert' !== $screen->id ) {
						echo '<a href="' . esc_url( admin_url( '/admin.php?page=wp-insert#wp_insert_adstxt_adsense_auto_update' ) ) . '">CLICK HERE</a>';
					} else {
						echo '<a href="javascript:;" onclick="wp_insert_adstxt_adsense_auto_update()">CLICK HERE</a>';
					}
					echo ' to instruct Wp-Insert to try and add the entries automatically.</p>';
					echo wp_kses_post( '<p><code style="display: block; padding: 2px 10px;">' . implode( '<br />', $adstxt_new_adsense_entries ) . '</code></p>' );
					echo '<p><small><i><b>We recommend you not to dismiss this notice for continued daily ads.txt monitoring.  This notice will stop appearing automatically once Wp-Insert detects correct entries in ads.txt (rechecked daily).</b></i></small></p>';
					echo '<div class="clear"></div>';
					echo '<input type="hidden" id="wp_insert_adstxt_adsense_admin_notice_nonce" name="wp_insert_adstxt_adsense_admin_notice_nonce" value="' . esc_attr( wp_create_nonce( 'wp-insert-adstxt-adsense-admin-notice' ) ) . '" />';
					echo '<input type="hidden" id="wp_insert_adstxt_adsense_admin_notice_ajax" name="wp_insert_adstxt_adsense_admin_notice_ajax" value="' . esc_url( admin_url( 'admin-ajax.php' ) ) . '" />';
					echo '</div>';
				} else {
					set_transient( 'wp_insert_adstxt_adsense_autocheck_content', '###CHECKED###', DAY_IN_SECONDS );
				}
			}
		}
	}
}

add_action( 'wp_ajax_wp_insert_adstxt_adsense_admin_notice_dismiss', 'wp_insert_adstxt_adsense_admin_notice_dismiss' );
function wp_insert_adstxt_adsense_admin_notice_dismiss() {
	check_ajax_referer( 'wp-insert-adstxt-adsense-admin-notice', 'wp_insert_adstxt_adsense_admin_notice_nonce' );
	update_option( 'wp_insert_adstxt_adsense_admin_notice_dismissed', 'true' );
	die();
}
/* End Admin Notice */

/* Begin Auto Update Ads.txt (Adsense) */
add_action( 'wp_ajax_wp_insert_adstxt_adsense_auto_update', 'wp_insert_adstxt_adsense_auto_update' );
function wp_insert_adstxt_adsense_auto_update() {
	check_ajax_referer( 'wp-insert-adstxt-adsense-admin-notice', 'wp_insert_adstxt_adsense_admin_notice_nonce' );
	$adstxt_new_adsense_entries = wp_insert_adstxt_adsense_get_status();
	if ( false !== $adstxt_new_adsense_entries ) {
		$adstxt_content         = wp_insert_adstxt_get_content();
		$adstxt_content_data    = array_filter( explode( "\n", trim( $adstxt_content ) ), 'trim' );
		$adstxt_updated_content = array_filter( array_merge( $adstxt_content_data, $adstxt_new_adsense_entries ), 'trim' );
	}

	if ( isset( $adstxt_updated_content ) && is_array( $adstxt_updated_content ) && ( count( $adstxt_updated_content ) > 0 ) ) {
		$adstxt_updated_content = implode( "\n", $adstxt_updated_content );
		if ( wp_insert_adstxt_update_content( $adstxt_updated_content ) ) {
			echo '###SUCCESS###';
		} else {
			echo wp_kses_post( wp_insert_adstxt_updation_failed_message( $adstxt_updated_content ) );
		}
	}
	die();
}
/* End Auto Update Ads.txt (Adsense) */

/* Begin ads.txt Adsense Check */
function wp_insert_adstxt_adsense_get_status() {
	if ( wp_insert_adstxt_file_exists() ) {
		$adsense_publisher_ids           = wp_insert_adstxt_adsense_get_publisherids();
		$adstxt_content                  = wp_insert_adstxt_get_content();
		$adstxt_content_data             = array_filter( explode( "\n", trim( $adstxt_content ) ), 'trim' );
		$adstxt_existing_adsense_entries = [];
		foreach ( $adstxt_content_data as $line ) {
			if ( false !== strpos( $line, 'google.com' ) ) {
				$adstxt_existing_adsense_entries[] = $line;
			}
		}

		$adstxt_new_adsense_entries = [];
		if ( count( $adstxt_existing_adsense_entries ) === 0 ) {
			if ( is_array( $adsense_publisher_ids ) && ( count( $adsense_publisher_ids ) > 0 ) ) {
				foreach ( $adsense_publisher_ids as $adsense_publisher_id ) {
					$adstxt_new_adsense_entries[] = 'google.com, ' . $adsense_publisher_id . ', DIRECT, f08c47fec0942fa0';
				}
			}
		} elseif ( is_array( $adsense_publisher_ids ) && ( count( $adsense_publisher_ids ) > 0 ) ) {
			foreach ( $adsense_publisher_ids as $adsense_publisher_id ) {
				$entry_exists = false;
				foreach ( $adstxt_existing_adsense_entries as $adstxt_existing_adsense_entry ) {
					if ( false !== strpos( $adstxt_existing_adsense_entry, $adsense_publisher_id ) ) {
						$entry_exists = true;
					}
				}
				if ( false === $entry_exists ) {
					$adstxt_new_adsense_entries[] = 'google.com, ' . $adsense_publisher_id . ', DIRECT, f08c47fec0942fa0';
				}
			}
		}
	}
	if ( isset( $adstxt_new_adsense_entries ) && count( $adstxt_new_adsense_entries ) > 0 ) {
		return $adstxt_new_adsense_entries;
	}
	return false;
}
/* End ads.txt Adsense Check */

/* Begin Extract Publisher Ids from Ads */
function wp_insert_adstxt_adsense_get_publisherids() {
	$adsense_publisher_ids = [];
	$data                  = get_option( 'wp_insert_inpostads' );
	if ( isset( $data ) && is_array( $data ) ) {
		foreach ( $data as $ad_unit ) {
			$temp = wp_insert_adstxt_adsense_extract_publisherids( $ad_unit );
			if ( false !== $temp ) {
				$adsense_publisher_ids = array_merge( $adsense_publisher_ids, $temp );
			}
		}
	}

	$data = get_option( 'wp_insert_adwidgets' );
	if ( isset( $data ) && is_array( $data ) ) {
		foreach ( $data as $ad_unit ) {
			$temp = wp_insert_adstxt_adsense_extract_publisherids( $ad_unit );
			if ( false !== $temp ) {
				$adsense_publisher_ids = array_merge( $adsense_publisher_ids, $temp );
			}
		}
	}

	$data = get_option( 'wp_insert_inthemeads' );
	if ( isset( $data ) && is_array( $data ) ) {
		foreach ( $data as $ad_unit ) {
			$temp = wp_insert_adstxt_adsense_extract_publisherids( $ad_unit );
			if ( false !== $temp ) {
				$adsense_publisher_ids = array_merge( $adsense_publisher_ids, $temp );
			}
		}
	}

	$data = get_option( 'wp_insert_shortcodeads' );
	if ( isset( $data ) && is_array( $data ) ) {
		foreach ( $data as $ad_unit ) {
			$temp = wp_insert_adstxt_adsense_extract_publisherids( $ad_unit );
			if ( false !== $temp ) {
				$adsense_publisher_ids = array_merge( $adsense_publisher_ids, $temp );
			}
		}
	}

	$data = get_option( 'wp_insert_pagelevelads' );
	if ( isset( $data ) && is_array( $data ) ) {
		foreach ( $data as $ad_unit ) {
			$temp = wp_insert_adstxt_adsense_extract_publisherids( $ad_unit );
			if ( false !== $temp ) {
				$adsense_publisher_ids = array_merge( $adsense_publisher_ids, $temp );
			}
		}
	}
	$adsense_publisher_ids = array_unique( $adsense_publisher_ids );

	if ( count( $adsense_publisher_ids ) > 0 ) {
		return $adsense_publisher_ids;
	}
	return false;
}

function wp_insert_adstxt_adsense_extract_publisherids( $ad_unit ) {
	$publisher_ids = [];
	if ( isset( $ad_unit['primary_ad_code'] ) && ( '' !== $ad_unit['primary_ad_code'] ) ) {
		if ( preg_match( '/googlesyndication.com/', $ad_unit['primary_ad_code'] ) ) {
			if ( preg_match( '/data-ad-client=/', $ad_unit['primary_ad_code'] ) ) { //ASYNS AD CODE
				$ad_code_parts = explode( 'data-ad-client', $ad_unit['primary_ad_code'] );
			} else {
				$ad_code_parts = explode( 'google_ad_client', $ad_unit['primary_ad_code'] ); //ORDINARY AD CODE
			}
			if ( isset( $ad_code_parts[1] ) && ( '' !== $ad_code_parts[1] ) ) {
				preg_match( '#"([a-zA-Z0-9-\s]+)"#', stripslashes( $ad_code_parts[1] ), $matches );
				if ( isset( $matches[1] ) && ( '' !== $matches[1] ) ) {
					$publisher_ids[] = str_replace( [ '"', ' ', 'ca-' ], [ '' ], $matches[1] );
				}
			}
		}
	}
	if ( isset( $ad_unit['secondary_ad_code'] ) && ( '' !== $ad_unit['secondary_ad_code'] ) ) {
		if ( preg_match( '/googlesyndication.com/', $ad_unit['secondary_ad_code'] ) ) {
			if ( preg_match( '/data-ad-client=/', $ad_unit['secondary_ad_code'] ) ) { //ASYNS AD CODE
				$ad_code_parts = explode( 'data-ad-client', $ad_unit['secondary_ad_code'] );
			} else {
				$ad_code_parts = explode( 'google_ad_client', $ad_unit['secondary_ad_code'] ); //ORDINARY AD CODE
			}
			if ( isset( $ad_code_parts[1] ) && ( '' !== $ad_code_parts[1] ) ) {
				preg_match( '#"([a-zA-Z0-9-\s]+)"#', stripslashes( $ad_code_parts[1] ), $matches );
				if ( isset( $matches[1] ) && ( '' !== $matches[1] ) ) {
					$publisher_ids[] = str_replace( [ '"', ' ', 'ca-' ], [ '' ], $matches[1] );
				}
			}
		}
	}
	if ( isset( $ad_unit['tertiary_ad_code'] ) && ( '' !== $ad_unit['tertiary_ad_code'] ) ) {
		if ( preg_match( '/googlesyndication.com/', $ad_unit['tertiary_ad_code'] ) ) {
			if ( preg_match( '/data-ad-client=/', $ad_unit['tertiary_ad_code'] ) ) { //ASYNS AD CODE
				$ad_code_parts = explode( 'data-ad-client', $ad_unit['tertiary_ad_code'] );
			} else {
				$ad_code_parts = explode( 'google_ad_client', $ad_unit['tertiary_ad_code'] ); //ORDINARY AD CODE
			}
			if ( isset( $ad_code_parts[1] ) && ( '' !== $ad_code_parts[1] ) ) {
				preg_match( '#"([a-zA-Z0-9-\s]+)"#', stripslashes( $ad_code_parts[1] ), $matches );
				if ( isset( $matches[1] ) && ( '' !== $matches[1] ) ) {
					$publisher_ids[] = str_replace( [ '"', ' ', 'ca-' ], [ '' ], $matches[1] );
				}
			}
		}
	}
	if ( count( $publisher_ids ) > 0 ) {
		return $publisher_ids;
	}
	return false;
}
/* End Extract Publisher Ids from Ads */
