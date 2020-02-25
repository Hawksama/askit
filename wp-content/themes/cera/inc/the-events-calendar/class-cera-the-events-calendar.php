<?php
/**
 * Cera_The_Events_Calendar Class
 *
 * @author   Themosaurus
 * @since    1.0.0
 * @package  cera
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Cera_The_Events_Calendar' ) ) :
	/**
	 * The main Cera_The_Events_Calendar class
	 */
	class Cera_The_Events_Calendar {
		/**
		 * Setup class.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'tribe_events_single_event_before_the_meta', array( 'Tribe__Events__iCal', 'single_event_links'   ), 100   );

			global $cera_grimlock;
			add_filter( 'grimlock_the_events_calendar_customizer_custom_header_layout_field_args', array( $cera_grimlock, 'change_layout_field_args' ), 10, 2 );
		}
	}
endif;

return new Cera_The_Events_Calendar();
