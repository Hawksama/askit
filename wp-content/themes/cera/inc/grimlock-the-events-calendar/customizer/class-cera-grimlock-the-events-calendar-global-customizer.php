<?php
/**
 * Cera_Grimlock_The_Events_Calendar_Global_Customizer Class
 *
 * @author   Themosaurus
 * @since    1.0.0
 * @package grimlock
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The background image class for the Customizer.
 */
class Cera_Grimlock_The_Events_Calendar_Global_Customizer {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'grimlock_global_customizer_content_background_color_elements', array( $this, 'add_content_background_color_elements' ), 10, 1 );
		add_filter( 'grimlock_global_customizer_content_background_color_outputs',  array( $this, 'add_content_background_color_outputs'  ), 10, 1 );
	}

	/**
	 * Add CSS selectors to the array of CSS selectors for the content background color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the content background color.
	 *
	 * @return array           The updated array of CSS selectors for the content background color.
	 */
	public function add_content_background_color_elements( $elements ) {
		return array_merge( $elements, array(
			'.tribe-countdown-text > a:hover',
		) );
	}

	/**
	 * Add selectors and properties to the CSS rule-set for the content background color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $outputs The array of CSS selectors and properties for the content background color.
	 *
	 * @return array          The updated array of CSS selectors for the content background color.
	 */
	public function add_content_background_color_outputs( $outputs ) {
		return array_merge( $outputs, array(
			array(
				'element'  => implode( ',', array(
					'.tribe-events-day-time-slot',
					'.tribe-events-list-separator-month',
					'#tribe-events-content .tribe-events-tooltip h4',
					'.tribe-this-week-widget-vertical .tribe-this-week-widget-header-date',
					'.tribe_mini_calendar_widget .tribe-mini-calendar-grid-wrapper table.tribe-mini-calendar .tribe-mini-calendar-nav tr:first-child td',
				) ),
				'property' => 'color',
			),
		) );
	}
}

return new Cera_Grimlock_The_Events_Calendar_Global_Customizer();
