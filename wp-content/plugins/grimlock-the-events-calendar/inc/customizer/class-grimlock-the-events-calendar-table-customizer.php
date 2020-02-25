<?php
/**
 * Grimlock_The_Events_Calendar_Table_Customizer Class
 *
 * @author  Themosaurus
 * @since   1.0.0
 * @package grimlock
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The Grimlock WooCommerce Customizer style class.
 */
class Grimlock_The_Events_Calendar_Table_Customizer {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'grimlock_table_customizer_striped_background_color_elements', array( $this, 'add_striped_background_color_elements' ), 10,  1 );
	}

	/**
	 * @param $elements
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function add_striped_background_color_elements( $elements ) {
		return array_merge( $elements, array(
			'.tribe_mini_calendar_widget .tribe-mini-calendar-grid-wrapper table.tribe-mini-calendar thead',
		) );
	}
}

return new Grimlock_The_Events_Calendar_Table_Customizer();
