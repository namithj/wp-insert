<?php
/* Begin UI Functions */
add_action( 'wp_insert_plugin_card', 'wp_insert_adwidgets_plugin_card', 30 );
function wp_insert_adwidgets_plugin_card() {
	wp_insert_get_plugin_card(
		'Ad Widgets',
		'<p>Ads shown inside widget enabled areas.</p>',
		'adwidgets',
		'Ad Widget'
	);
}

add_action( 'wp_ajax_wp_insert_adwidgets_get_ad_form', 'wp_insert_get_ad_form' );
add_action( 'wp_ajax_wp_insert_adwidgets_save_ad_data', 'wp_insert_save_ad_data' );
add_action( 'wp_ajax_wp_insert_adwidgets_delete_ad_data', 'wp_insert_delete_ad_data' );

add_filter( 'wp_insert_adwidgets_form_accordion_tabs', 'wp_insert_form_accordion_tabs_adcode', 20, 3 );
add_filter( 'wp_insert_adwidgets_form_accordion_tabs', 'wp_insert_form_accordion_tabs_rules', 30, 3 );
add_filter( 'wp_insert_adwidgets_form_accordion_tabs', 'wp_insert_form_accordion_tabs_geo_targeting', 40, 3 );
add_filter( 'wp_insert_adwidgets_form_accordion_tabs', 'wp_insert_form_accordion_tabs_devices_styles', 50, 3 );
add_filter( 'wp_insert_adwidgets_form_accordion_tabs', 'wp_insert_form_accordion_tabs_notes', 60, 3 );
/* End UI Functions */

/* Begin Ad Widget Insertion */
require_once __DIR__ . '/class-wpinsertadwidget.php';

add_action(
	'widgets_init',
	function () {
		return register_widget( 'wpInsertAdWidget' );
	}
);
/* End Ad Widget Insertion */
