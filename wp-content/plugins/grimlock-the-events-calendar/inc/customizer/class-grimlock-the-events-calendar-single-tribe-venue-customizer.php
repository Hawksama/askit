<?php
/**
 * Grimlock_The_Events_Calendar_Single_Tribe_Venue_Customizer Class
 *
 * @author  Themosaurus
 * @since   1.0.0
 * @package grimlock
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The Grimlock Customizer class for the The Events Calendar single tribe_venue pages.
 */
class Grimlock_The_Events_Calendar_Single_Tribe_Venue_Customizer {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'grimlock_the_events_calendar_customizer_is_template', array( $this, 'is_template' ), 10, 1 );
	}

	/**
	 * Check if template is the template for the single tribe_venue page.
	 *
	 * @since 1.0.0
	 *
	 * @param  bool $default The default value for the check.
	 *
	 * @return bool          The filtered value for the check.
	 */
	public function is_template( $default = false ) {
		return is_singular( 'tribe_venue' ) || $default;
	}
}

return new Grimlock_The_Events_Calendar_Single_Tribe_Venue_Customizer();
