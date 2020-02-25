<?php
/*
 * Plugin name: Grimlock for The Events Calendar
 * Plugin URI:  http://www.themosaurus.com
 * Description: Adds integration features for Grimlock and The Events Calendar.
 * Author:      Themosaurus
 * Author URI:  http://www.themosaurus.com
 * Version:     1.1.3
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: grimlock-the-events-calendar
 * Domain Path: /languages
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GRIMLOCK_THE_EVENTS_CALENDAR_VERSION',         '1.1.3' );
define( 'GRIMLOCK_THE_EVENTS_CALENDAR_PLUGIN_FILE',     __FILE__ );
define( 'GRIMLOCK_THE_EVENTS_CALENDAR_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'GRIMLOCK_THE_EVENTS_CALENDAR_PLUGIN_DIR_URL',  plugin_dir_url( __FILE__ ) );

// Initialize update checker
require 'libs/plugin-update-checker/plugin-update-checker.php';
Puc_v4_Factory::buildUpdateChecker(
	'http://files.themosaurus.com/grimlock-the-events-calendar/version.json',
	__FILE__,
	'grimlock-the-events-calendar'
);

/**
 * Load plugin.
 */
function grimlock_the_events_calendar_loaded() {
	require_once 'inc/class-grimlock-the-events-calendar.php';

	global $grimlock_the_events_calendar;
	$grimlock_the_events_calendar = new Grimlock_The_Events_Calendar();

	do_action( 'grimlock_the_events_calendar_loaded' );
}
add_action( 'grimlock_loaded', 'grimlock_the_events_calendar_loaded' );

// Disable The Events Calendar Customizer features.
add_filter( 'tribe_customizer_is_active', '__return_false', 10, 1 );
