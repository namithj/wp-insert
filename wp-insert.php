<?php
/**
 * Plugin Name: Wp-Insert
 * Plugin URI: https://wpinsert.smartlogix.co.in/
 * Description: WP-INSERT by SMARTLOGIX :  The Ultimate Adsense / Ad-Management Plugin for WordPress
 * Requires at least: 6.3
 * Requires PHP: 7.4
 * Version: 2.5.1
 * Author: namithjawahar
 * Author URI: http://www.smartlogix.co.in/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: wp-insert
 *
 * @package wp-insert
 */

/*Definitions*/
if ( ! defined( 'WP_INSERT_URL' ) ) {
	define( 'WP_INSERT_URL', plugin_dir_url( __FILE__ ) );
}
if ( ! defined( 'WP_INSERT_DIR' ) ) {
	define( 'WP_INSERT_DIR', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'WP_INSERT_VERSION' ) ) {
	define( 'WP_INSERT_VERSION', '2.5.1' );
}
if ( ! defined( 'WP_INSERT_DEBUG' ) ) {
	define( 'WP_INSERT_DEBUG', false );
}
/*Includes*/

require_once __DIR__ . '/includes/modules/core/modules.php';
require_once __DIR__ . '/includes/modules/general/modules.php';
