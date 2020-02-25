<?php
/*
 * Plugin name: Grimlock for bbPress
 * Plugin URI:  http://www.themosaurus.com
 * Description: Adds integration features for Grimlock and bbPress.
 * Author:      Themosaurus
 * Author URI:  http://www.themosaurus.com
 * Version:     1.0.3
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: grimlock-bbpress
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'GRIMLOCK_BBPRESS_VERSION',         '1.0.3' );
define( 'GRIMLOCK_BBPRESS_PLUGIN_FILE',     __FILE__ );
define( 'GRIMLOCK_BBPRESS_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'GRIMLOCK_BBPRESS_PLUGIN_DIR_URL',  plugin_dir_url( __FILE__ ) );

// Initialize update checker
require 'libs/plugin-update-checker/plugin-update-checker.php';
Puc_v4_Factory::buildUpdateChecker(
	'http://files.themosaurus.com/grimlock-bbpress/version.json',
	__FILE__,
	'grimlock-bbpress'
);

/**
 * Load plugin.
 */
function grimlock_bbpress_loaded() {
	require_once 'inc/class-grimlock-bbpress.php';

	global $grimlock_bbpress;
	$grimlock_bbpress = new Grimlock_bbPress();

	do_action( 'grimlock_bbpress_loaded' );
}
add_action( 'grimlock_loaded', 'grimlock_bbpress_loaded' );
