<?php
/* Begin Signup Form */
add_action( 'wp_ajax_wp_insert_vi_signup_form_get_content', 'wp_insert_vi_signup_form_get_content' );
function wp_insert_vi_signup_form_get_content() {
	check_ajax_referer( 'wp-insert', 'wp_insert_nonce' );
	$signup_url = wp_insert_vi_api_get_signupurl();
	if ( ( false !== $signup_url ) && ( '' !== $signup_url ) ) {
		echo '<div class="wp_insert_popup_content_wrapper">';
			echo '<iframe src="' . esc_url( $signup_url . '?email=' . get_bloginfo( 'admin_email' ) . '&domain=' . wp_insert_get_domain_name_from_url( get_bloginfo( 'url' ) ) . '&aid=WP_insert' ) . '" style="width: 100%; max-width: 870px; min-height: 554px;"></iframe>';
			echo '<script type="text/javascript">';
				echo 'jQuery(".ui-dialog-buttonset").find("button").first().remove();';
				echo 'jQuery(".ui-dialog-buttonset").find("button").first().find("span:nth-child(2)").hide().after("<span class=\'ui-button-text\'>Close</span>");';
			echo '</script>';
		echo '</div>';
	} else {
		echo '<div class="wp_insert_popup_content_wrapper">';
			echo '<p>There was an error processing your request, our team was notified. Try clearing your browser cache, log out and log in again.</p>';
		echo '</div>';
	}
	die();
}
/* End Signup Form */

/* Begin Login Form */
add_action( 'wp_ajax_wp_insert_vi_login_form_get_content', 'wp_insert_vi_login_form_get_content' );
function wp_insert_vi_login_form_get_content() {
	check_ajax_referer( 'wp-insert', 'wp_insert_nonce' );
	echo '<div class="wp_insert_popup_content_wrapper">';
		echo '<div class="wp_insert_vi_loginform_wrapper">';
			wp_insert_vi_login_form_get_controls();
		echo '</div>';
		echo '<script type="text/javascript">';
			echo 'jQuery(".ui-dialog-buttonset").find("button").first().find("span:nth-child(2)").hide().after("<span class=\'ui-button-text\'>Login</span>");';
			echo 'jQuery(".ui-dialog-buttonset").find("button").first().find("span:nth-child(1)").attr("class", "ui-button-icon-primary ui-icon ui-icon-key");';
		echo '</script>';
	echo '</div>';
	die();
}

add_action( 'wp_ajax_wp_insert_vi_login_form_save_action', 'wp_insert_vi_login_form_save_action' );
function wp_insert_vi_login_form_save_action() {
	check_ajax_referer( 'wp-insert', 'wp_insert_nonce' );
	if ( isset( $_POST['wp_insert_vi_login_username'] ) && ( '' !== $_POST['wp_insert_vi_login_username'] ) && isset( $_POST['wp_insert_vi_login_password'] ) && ( '' !== $_POST['wp_insert_vi_login_password'] ) ) {
		$token = wp_insert_vi_api_login( $_POST['wp_insert_vi_login_username'], $_POST['wp_insert_vi_login_password'] );
		if ( is_array( $token ) && ( isset( $token['status'] ) ) && ( 'error' === $token['status'] ) ) {
			wp_insert_vi_login_form_get_controls();
			if ( 'WIVI008' === $token['errorCode'] ) {
				echo '<p class="wp_insert_vi_login_error">' . esc_html( $token['message'] ) . '</p>';
			} else {
				echo '<p class="wp_insert_vi_login_error">Error Code: ' . esc_html( $token['errorCode'] ) . '<br />Please contact support or try again later!</p>';
			}
		} else {
			echo '###SUCCESS###';
			wp_insert_vi_plugin_card_content( true, true );

			if ( function_exists( 'wp_insert_adstxt_adsense_admin_notice_reset' ) ) {
				wp_insert_adstxt_adsense_admin_notice_reset();
			}
		}
	}
	die();
}

function wp_insert_vi_login_form_get_controls() {
	$control        = new SmartlogixControls();
	$control->html .= '<p>Please log in with the received credentials to complete the integration:</p>';
	$control->add_control(
		[
			'type'  => 'text',
			'id'    => 'wp_insert_vi_login_username',
			'name'  => 'wp_insert_vi_login_username',
			'label' => 'Email',
			'value' => '',
		]
	);
	$control->add_control(
		[
			'type'  => 'password',
			'id'    => 'wp_insert_vi_login_password',
			'name'  => 'wp_insert_vi_login_password',
			'label' => 'Password',
			'value' => '',
		]
	);
	$control->create_section( 'Login' );
	echo wp_kses_post( $control->html );
}

add_action( 'wp_ajax_wp_insert_vi_update_adstxt', 'wp_insert_vi_update_adstxt' );
function wp_insert_vi_update_adstxt() {
	check_ajax_referer( 'wp-insert', 'wp_insert_nonce' );

	$adstxt_content      = wp_insert_adstxt_get_content();
	$adstxt_content_data = array_filter( explode( "\n", trim( $adstxt_content ) ), 'trim' );
	$vi_entry            = wp_insert_vi_api_get_adstxt_content();
	if ( strpos( str_replace( [ "\r", "\n", ' ' ], '', $adstxt_content ), str_replace( [ "\r", "\n", ' ' ], '', $vi_entry ) ) !== false ) {
		die();
	} else {
		$updated_adstxt_content = '';
		if ( strpos( $adstxt_content, '# 41b5eef6' ) !== false ) {
			foreach ( $adstxt_content_data as $line ) {
				if ( false === strpos( $line, '# 41b5eef6' ) ) {
					$updated_adstxt_content .= str_replace( [ "\r", "\n", ' ' ], '', $line ) . "\r\n";
				}
			}
			$updated_adstxt_content .= $vi_entry;
		} else {
			$updated_adstxt_content .= $adstxt_content . "\r\n" . $vi_entry;
		}

		if ( wp_insert_adstxt_update_content( $updated_adstxt_content ) ) {
			echo '###SUCCESS###';
			echo '<div class="notice notice-warning wp_insert_adsstxt_notice is-dismissible" style="padding: 5px 15px;">';
				echo '<div style="float: left; max-width: 875px; font-size: 14px; font-family: Arial; line-height: 18px; color: #232323;">';
					echo '<p><b>ADS.TXT has been added</b></p>';
					echo '<p>Wp-Insert has updated your ads.txt file with lines that declare video intelligence as a legitimate seller of your inventory and enables you to make more money through video intelligence. Read the <a target="_blank" href="https://www.vi.ai/frequently-asked-questions-vi-stories-for-wordpress/?utm_source=WordPress&utm_medium=Plugin%20FAQ&utm_campaign=WP%20Insert">FAQ</a>.</p>';
				echo '</div>';
				echo '<img style="float: right; margin-right: 20px; margin-top: 13px;" src="' . esc_url( WP_INSERT_URL . 'includes/assets/images/vi-big-logo.png?' . WP_INSERT_VERSION ) . '" />';
				echo '<div class="clear"></div>';
				echo '<button type="button" class="notice-dismiss" onclick="javascript:jQuery(this).parent().remove()"><span class="screen-reader-text">Dismiss this notice.</span></button>';
			echo '</div>';
		} else {
			echo '###FAIL###';
			echo '<div class="notice notice-error wp_insert_adsstxt_notice is-dismissible" style="padding: 5px 15px;">';
				echo '<div style="float: left; max-width: 875px; font-size: 14px; font-family: Arial; line-height: 18px; color: #232323;">';
					echo '<p><b>ADS.TXT couldn’t be added</b></p>';
					echo '<p>Important note: Wp-Insert hasn’t been able to update your ads.txt file. Please make sure that you enter the following lines manually:</p>';
					echo '<p><code style="display: block;">' . wp_kses_post( trim( str_replace( [ "\r\n", "\r", "\n" ], '<br />', $vi_entry ) ) ) . '</code><br />Only by doing so, you\'ll be able to make more money through video intelligence (vi.ai).</p>';
				echo '</div>';
				echo '<img style="float: right; margin-right: 20px; margin-top: 13px;" src="' . esc_url( WP_INSERT_URL . 'includes/assets/images/vi-big-logo.png?' . WP_INSERT_VERSION ) . '" />';
				echo '<div class="clear"></div>';
				echo '<button type="button" class="notice-dismiss" onclick="javascript:jQuery(this).parent().remove()"><span class="screen-reader-text">Dismiss this notice.</span></button>';
			echo '</div>';
		}
	}
	die();
}
/* End Login Form */

/* Begin Logout */
add_action( 'wp_ajax_wp_insert_vi_logout_action', 'wp_insert_vi_logout_action' );
function wp_insert_vi_logout_action() {
	check_ajax_referer( 'wp-insert', 'wp_insert_nonce' );
	wp_insert_vi_api_logout();
	echo '###SUCCESS###';
	wp_insert_vi_plugin_card_content( false, true );
	die();
}
/* End Logout */

/* Begin Configure vi Code */
add_action( 'wp_ajax_wp_insert_vi_customize_adcode_form_get_content', 'wp_insert_vi_customize_adcode_form_get_content' );
function wp_insert_vi_customize_adcode_form_get_content() {
	check_ajax_referer( 'wp-insert', 'wp_insert_nonce' );
	$vicode_settings         = get_option( 'wp_insert_vi_code_settings' );
	$control                 = new SmartlogixControls(
		[
			'optionIdentifier' => 'wp_insert_vi_code_settings',
			'values'           => $vicode_settings,
		]
	);
	$control->html           = '<div class="wp_insert_popup_content_wrapper">';
		$control->html      .= '<p>Use this form to customize the look of the video unit. Use the same parameters as your WordPress theme for a natural look on your site.<br />You can use <b>vi stories</b> for <i>In-Post Ads: Ad - Above Post Content</i> and <i>In-Post Ads: Ad - Middle of Post Content</i></p>';
		$control->html      .= '<div class="wp_insert_vi_popup_right_column">';
			$control->html  .= '<img style="margin: 0 auto; display: block;" src="' . WP_INSERT_URL . 'includes/assets/images/advertisement-preview.png?' . WP_INSERT_VERSION . '" />';
		$control->html      .= '</div>';
		$control->html      .= '<div class="wp_insert_vi_popup_left_column">';
			$control->html  .= '<p id="wp_insert_vi_customize_adcode_keywords_required_error" style="display: none;" class="viError">Keywords contains invalid characters, Some required fields are missing</p>';
			$control->html  .= '<p id="wp_insert_vi_customize_adcode_keywords_error" style="display: none;" class="viError">Keywords contains invalid characters</p>';
			$control->html  .= '<p id="wp_insert_vi_customize_adcode_required_error" style="display: none;" class="viError">Some required fields are missing</p>';
			$ad_unit_options = [
				[
					'text'  => 'vi stories',
					'value' => 'NATIVE_VIDEO_UNIT',
				],
			];
			$control->add_control(
				[
					'type'       => 'select',
					'label'      => ' Ad Unit*',
					'optionName' => 'ad_unit_type',
					'helpText'   => '</small><span class="tooltipWrapper"><span class="tooltip">- vi stories (video advertising + video content)</span></span><small>',
					'options'    => $ad_unit_options,
				]
			);/*<br />- out-stream (video advertising)*/
			$control->add_control(
				[
					'type'       => 'textarea',
					'label'      => 'Keywords',
					'optionName' => 'keywords',
					'helpText'   => '</small><span class="tooltipWrapper"><span class="tooltip">Comma separated values describing the content of the page e.g. \'cooking, grilling, pulled pork\'</span></span><small>',
				]
			);
			$iab_parent_categories = wp_insert_vi_get_constant_iab_parent_categories();
			$control->add_control(
				[
					'type'       => 'select',
					'label'      => 'IAB Category*',
					'optionName' => 'iab_category_parent',
					'helpText'   => '</small><a class="textTip" target="_blank" href="' . wp_insert_vi_api_get_iab_categories_url() . '">See Complete List</a><small>',
					'options'    => $iab_parent_categories,
				]
			);
			$iab_child_categories = wp_insert_vi_get_constant_iab_child_categories();
			$control->add_control(
				[
					'type'       => 'select',
					'label'      => '&nbsp;',
					'optionName' => 'iab_category_child',
					'helpText'   => '&nbsp;',
					'options'    => $iab_child_categories,
				]
			);
			$languages        = wp_insert_vi_api_get_languages();
			$language_options = [
				[
					'text'  => 'Select language',
					'value' => 'select',
				],
			];
			if ( false !== $languages ) {
				foreach ( $languages as $key => $value ) {
					$language_options[] = [
						'text'  => $value,
						'value' => $key,
					];
				}
			}
			$control->add_control(
				[
					'type'       => 'select',
					'label'      => 'Language*',
					'optionName' => 'language',
					'helpText'   => '&nbsp;',
					'options'    => $language_options,
				]
			);
			$control->add_control(
				[
					'type'       => 'minicolors',
					'label'      => 'Native Background color',
					'optionName' => 'native_bg_color',
					'helpText'   => '&nbsp;',
				]
			);
			$control->add_control(
				[
					'type'       => 'minicolors',
					'label'      => 'Native Text color',
					'optionName' => 'native_text_color',
					'helpText'   => '&nbsp;',
				]
			);
			$control->add_control(
				[
					'type'       => 'select',
					'label'      => ' Native Text Font Family',
					'optionName' => 'font_family',
					'helpText'   => '&nbsp;',
					'options'    => wp_insert_vi_get_constant_fonts(),
				]
			);
			$control->add_control(
				[
					'type'       => 'select',
					'label'      => 'Native Text Font Size',
					'optionName' => 'font_size',
					'helpText'   => '&nbsp;',
					'options'    => wp_insert_vi_get_constant_font_sizes(),
				]
			);
			$control->html .= '<p class="wp_insert_vi_delay_notice">vi Ad Changes might take some time to take into effect</p>';
			$control->html .= '</div>';
			$control->html .= '<div class="clear"></div>';
			$control->html .= '</div>';
			$control->create_section( ' vi stories: customize your video player ' );
			echo wp_kses_post( $control->html );
			$control->clear_controls();

			$control->html .= '<p>Enable GDPR Compliance confirmation notice on your site for visitors from EU.<br />If you disable this option make sure you are using a data usage authorization system on your website to remain GDPR complaint.</p>';
			$control->add_control(
				[
					'type'           => 'checkbox-button',
					'label'          => 'Status : Do not Show GDPR Authorization Popup',
					'checkedLabel'   => 'Status : Show GDPR Authorization Popup',
					'uncheckedLabel' => 'Status : Do not Show GDPR Authorization Popup',
					'optionName'     => 'show_gdpr_authorization',
				]
			);
			$control->create_section( ' vi stories: GDPR Compliance ' );
			echo wp_kses_post( $control->html );
			echo '<script type="text/javascript">';
			echo $control->js; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo 'wp_insert_vi_code_iab_category_parent_change();';
			echo '</script>';
			die();
}

add_action( 'wp_ajax_wp_insert_vi_customize_adcode_form_save_action', 'wp_insert_vi_customize_adcode_form_save_action' );
function wp_insert_vi_customize_adcode_form_save_action() {
	check_ajax_referer( 'wp-insert', 'wp_insert_nonce' );
	$vicode_settings                        = [];
	$vicode_settings['ad_unit_type']        = ( ( isset( $_POST['wp_insert_vi_code_settings_ad_unit_type'] ) ) ? $_POST['wp_insert_vi_code_settings_ad_unit_type'] : '' );
	$vicode_settings['keywords']            = ( ( isset( $_POST['wp_insert_vi_code_settings_keywords'] ) ) ? $_POST['wp_insert_vi_code_settings_keywords'] : '' );
	$vicode_settings['iab_category_parent'] = ( ( isset( $_POST['wp_insert_vi_code_settings_iab_category_parent'] ) ) ? $_POST['wp_insert_vi_code_settings_iab_category_parent'] : '' );
	$vicode_settings['iab_category_child']  = ( ( isset( $_POST['wp_insert_vi_code_settings_iab_category_child'] ) ) ? $_POST['wp_insert_vi_code_settings_iab_category_child'] : '' );
	$vicode_settings['language']            = ( ( isset( $_POST['wp_insert_vi_code_settings_language'] ) ) ? $_POST['wp_insert_vi_code_settings_language'] : '' );
	$vicode_settings['native_bg_color']     = ( ( isset( $_POST['wp_insert_vi_code_settings_native_bg_color'] ) ) ? $_POST['wp_insert_vi_code_settings_native_bg_color'] : '' );
	$vicode_settings['native_text_color']   = ( ( isset( $_POST['wp_insert_vi_code_settings_native_text_color'] ) ) ? $_POST['wp_insert_vi_code_settings_native_text_color'] : '' );
	$vicode_settings['font_family']         = ( ( isset( $_POST['wp_insert_vi_code_settings_font_family'] ) ) ? $_POST['wp_insert_vi_code_settings_font_family'] : '' );
	$vicode_settings['font_size']           = ( ( isset( $_POST['wp_insert_vi_code_settings_font_size'] ) ) ? $_POST['wp_insert_vi_code_settings_font_size'] : '' );

	$vicode_settings['show_gdpr_authorization'] = ( ( isset( $_POST['wp_insert_vi_code_settings_show_gdpr_authorization'] ) ) ? $_POST['wp_insert_vi_code_settings_show_gdpr_authorization'] : '' );
	update_option( 'wp_insert_vi_code_settings', $vicode_settings );
	$vi_code_status = wp_insert_vi_api_set_vi_code( $vicode_settings );
	if ( is_array( $vi_code_status ) && ( isset( $vi_code_status['status'] ) ) && ( 'error' === $vi_code_status['status'] ) ) {
		if ( 'WIVI108' === $vi_code_status['errorCode'] ) {
			echo '###FAIL###';
			echo '<p class="viError">' . esc_html( $vi_code_status['message'] ) . '</p>';
		} else {
			echo '###FAIL###';
			echo '<p class="viError">There was an error processing your request, our team was notified. Try clearing your browser cache, log out and log in again.</p>';
		}
	} else {
		echo '###SUCCESS###';
	}
	die();
}

function wp_insert_vi_customize_adcode_get_settings() {
	$vicode_settings = get_option( 'wp_insert_vi_code_settings' );

	$output = '';
	if ( isset( $vicode_settings ) && is_array( $vicode_settings ) ) {
		$output .= '<p class="wp_insert_vi_code_data_wrapper">';
		if ( isset( $vicode_settings['ad_unit_type'] ) && ( '' !== $vicode_settings['ad_unit_type'] ) && ( 'select' !== $vicode_settings['ad_unit_type'] ) ) {
			$output .= '<label>Ad Unit:</label><b>vi stories</b>';
		}

		if ( isset( $vicode_settings['keywords'] ) && ( '' !== $vicode_settings['keywords'] ) ) {
			$output .= '<label>Keywords:</label><b>' . $vicode_settings['keywords'] . '</b>';
		}

		if ( isset( $vicode_settings['iab_category_child'] ) && ( '' !== $vicode_settings['iab_category_child'] ) && ( 'select' !== $vicode_settings['iab_category_child'] ) ) {
			$iab_child_categories = wp_insert_vi_get_constant_iab_child_categories();
			foreach ( $iab_child_categories as $iab_child_category_item ) {
				if ( $vicode_settings['iab_category_child'] === $iab_child_category_item['value'] ) {
					$output .= '<label>IAB Category:</label><b>' . $iab_child_category_item['text'] . '</b>';
				}
			}
		}

		$languages = wp_insert_vi_api_get_languages();
		if ( isset( $vicode_settings['language'] ) && ( '' !== $vicode_settings['language'] ) && ( 'select' !== $vicode_settings['language'] ) ) {
			if ( false !== $languages ) {
				foreach ( $languages as $key => $value ) {
					if ( $vicode_settings['language'] === $key ) {
						$output .= '<label>Language:</label><b>' . $value . '</b>';
					}
				}
			}
		}

		if ( isset( $vicode_settings['native_bg_color'] ) && ( '' !== $vicode_settings['native_bg_color'] ) ) {
			$output .= '<label>Native Background color:</label><b>' . $vicode_settings['native_bg_color'] . '</b>';
		}

		if ( isset( $vicode_settings['native_text_color'] ) && ( '' !== $vicode_settings['native_text_color'] ) ) {
			$output .= '<label>Native Text color:</label><b>' . $vicode_settings['native_text_color'] . '</b>';
		}

		if ( isset( $vicode_settings['font_family'] ) && ( '' !== $vicode_settings['font_family'] ) && ( 'select' !== $vicode_settings['font_family'] ) ) {
			$font_family = wp_insert_vi_get_constant_fonts();
			foreach ( $font_family as $font_family_item ) {
				if ( $vicode_settings['font_family'] === $font_family_item['value'] ) {
					$output .= '<label>Native Text Font Family:</label><b>' . $font_family_item['text'] . '</b>';
				}
			}
		}

		if ( isset( $vicode_settings['font_size'] ) && ( '' !== $vicode_settings['font_size'] ) && ( 'select' !== $vicode_settings['font_size'] ) ) {
			$font_size = wp_insert_vi_get_constant_font_sizes();
			foreach ( $font_size as $font_size_item ) {
				if ( $vicode_settings['font_size'] === $font_size_item['value'] ) {
					$output .= '<label>Native Text Font Size:</label><b>' . $font_size_item['text'] . '</b>';
				}
			}
		}
		$output .= '</p>';
	}
	return $output;
}
/* End Configure vi Code */
