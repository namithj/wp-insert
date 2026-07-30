<?php
/* Begin Add Card in Admin Panel */
add_action( 'wp_insert_plugin_card', 'wp_insert_abtesting_plugin_card', 90 );
function wp_insert_abtesting_plugin_card() {
	echo '<div class="plugin-card">';
		echo '<div class="plugin-card-top">';
			echo '<h4>Multiple Ad Networks / A-B Testing</h4>';
			echo '<p>Multiple Ad Networks can be setup to display ads from different networks without infringing the terms of any network.';
			echo 'At a time only ads from one network (Randomly Choosen) will be shown.';
			echo 'This feature can also be used to randomly display different sized Ads from the same network.';
			echo 'Please note that this option is global and applied to In-Post Ads, Ad Widgets and In-Theme Ads.</p>';
		echo '</div>';
		echo '<div class="plugin-card-bottom">';
			echo '<p><a id="wp_insert_abtesting_configuration" href="javascript:;">Configuration</a></p>';
		echo '</div>';
	echo '</div>';
}
/* End Add Card in Admin Panel */

/* Begin AB Testing Content */
add_action( 'wp_ajax_wp_insert_abtesting_configuration_form_get_content', 'wp_insert_abtesting_configuration_form_get_content' );
function wp_insert_abtesting_configuration_form_get_content() {
	check_ajax_referer( 'wp-insert', 'wp_insert_nonce' );

	$abtestingMode  = get_option( 'wp_insert_abtesting_mode', 1 );
	$abtestingModes = [
		[
			'value' => '1',
			'text'  => 'Primary Ad Network',
		],
		[
			'value' => '2',
			'text'  => 'Primary and Secondary Ad Networks',
		],
		[
			'value' => '3',
			'text'  => 'All Ad Networks',
		],
	];
	echo '<div class="wp_insert_popup_content_wrapper">';
		$control = new smartlogixControls(
			[
				'type'    => 'radio-group',
				'id'      => 'wp_insert_abtesting_mode',
				'name'    => 'wp_insert_abtesting_mode',
				'label'   => 'Select the Ad Network Setup that best suits you',
				'value'   => $abtestingMode,
				'options' => $abtestingModes,
			]
		);
		$control->add_control();
		wp_insert_echo_html( $control->HTML );
		echo '<p>';
			echo '<b>Recommended Ad Networks</b><br /><br />';
			echo '<a href="http://google.com/adsense" target="_blank"><img src="' . esc_url( WP_INSERT_URL . '/includes/assets/images/adsense-logo.png' ) . '" alt="Google AdSense" /></a>';
		echo '</p>';
	echo '</div>';
	wp_die();
}

add_action( 'wp_ajax_wp_insert_abtesting_configuration_form_save_action', 'wp_insert_abtesting_configuration_form_save_action' );
function wp_insert_abtesting_configuration_form_save_action() {
	check_ajax_referer( 'wp-insert', 'wp_insert_nonce' );

	if ( isset( $_POST['wp_insert_abtesting_mode'] ) ) {
		$abtestingMode = sanitize_key( wp_unslash( $_POST['wp_insert_abtesting_mode'] ) );
		if ( in_array( $abtestingMode, [ '1', '2', '3' ], true ) ) {
			update_option( 'wp_insert_abtesting_mode', $abtestingMode );
		}
	}
	wp_die();
}
/* End AB Testing Content */
