<?php
/**
 * Grimlock_The_Events_Calendar_Button_Customizer Class
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
class Grimlock_The_Events_Calendar_Button_Customizer {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'grimlock_button_customizer_elements',                          array( $this, 'add_elements'                          ), 10, 1 );
		add_filter( 'grimlock_button_customizer_primary_elements',                  array( $this, 'add_primary_elements'                  ), 10, 1 );
		add_filter( 'grimlock_button_customizer_primary_background_color_elements', array( $this, 'add_primary_background_color_elements' ), 10, 1 );
		add_filter( 'grimlock_button_customizer_primary_background_color_outputs',  array( $this, 'add_primary_background_color_outputs'  ), 10, 1 );
		add_filter( 'grimlock_button_customizer_primary_color_outputs',             array( $this, 'add_primary_color_outputs'             ), 10, 1 );
		add_filter( 'grimlock_button_customizer_border_radius_elements',            array( $this, 'add_border_radius_elements'            ), 10, 1 );
	}


	/**
	 * @param $elements
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function add_elements( $elements ) {
		return array_merge( $elements, array(
			'#tribe-events .button',
		) );
	}

	/**
	 * @param $elements
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function add_primary_elements( $elements ) {
		return array_merge( $elements, array(
			'#tribe-events .button',
			'#tribe-events .button.alt',
			'#tribe-events .tribe-events-button',
			'#tribe-events .tribe-events-button.tribe-active',
			'.type-tribe_events .tribe-mini-calendar-event .list-date .list-daynumber',
			'.tribe_mini_calendar_widget .tribe-mini-calendar-grid-wrapper table.tribe-mini-calendar td.tribe-events-present a.tribe-mini-calendar-day-link',
			'.tribe_mini_calendar_widget .tribe-mini-calendar-grid-wrapper table.tribe-mini-calendar td.tribe-events-present a.tribe-mini-calendar-day-link:hover',
			'.tribe_mini_calendar_widget .tribe-mini-calendar-grid-wrapper table.tribe-mini-calendar td.tribe-mini-calendar-today a.tribe-mini-calendar-day-link',
			'.tribe_mini_calendar_widget .tribe-mini-calendar-grid-wrapper table.tribe-mini-calendar td.tribe-mini-calendar-today a.tribe-mini-calendar-day-link:hover',
			'.tribe_mini_calendar_widget .tribe-mini-calendar-grid-wrapper table.tribe-mini-calendar td a.tribe-mini-calendar-day-link:hover',
			'.tribe-events-list .tribe-events-loop .tribe-event-featured .tribe-button',
			'.tribe-events-list .tribe-events-loop .tribe-event-featured .tribe-events-event-cost .tribe-button',
			'#tribe_events_filters_wrapper input[type="submit"]',
			'#tribe-bar-form .tribe-bar-submit input[type="submit"]',
		) );
	}

	/**
	 * @param $outputs
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function add_primary_color_outputs( $outputs ) {
		return array_merge( $outputs, array(
			array(
				'element'  => implode( ',', array(
					'.type-tribe_events .tribe-mini-calendar-event .list-date .list-dayname',
					'.tribe_mini_calendar_widget .tribe-mini-calendar-grid-wrapper table.tribe-mini-calendar td.tribe-events-present a.tribe-mini-calendar-day-link:before',
					'.tribe_mini_calendar_widget .tribe-mini-calendar-grid-wrapper table.tribe-mini-calendar td a.tribe-mini-calendar-day-link:hover:before',
					'.tribe_mini_calendar_widget .tribe-mini-calendar-grid-wrapper table.tribe-mini-calendar td.tribe-mini-calendar-today a.tribe-mini-calendar-day-link:before',
					'.tribe_mini_calendar_widget .tribe-mini-calendar-grid-wrapper table.tribe-mini-calendar td.tribe-mini-calendar-today a.tribe-mini-calendar-day-link:hover:before',
				) ),
				'property' => 'background-color',
			),
		) );
	}

	/**
	 * @param $elements
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function add_primary_background_color_elements( $elements ) {
		return array_merge( $elements, array(
			'.type-tribe_events .tribe-mini-calendar-event .list-date',
			'.tribe_mini_calendar_widget .tribe-mini-calendar-grid-wrapper table.tribe-mini-calendar td.tribe-events-present a.tribe-mini-calendar-day-link',
			'.tribe_mini_calendar_widget .tribe-mini-calendar-grid-wrapper table.tribe-mini-calendar td.tribe-events-present a.tribe-mini-calendar-day-link:hover',
			'.tribe_mini_calendar_widget .tribe-mini-calendar-grid-wrapper table.tribe-mini-calendar td.tribe-mini-calendar-today a.tribe-mini-calendar-day-link',
			'.tribe_mini_calendar_widget .tribe-mini-calendar-grid-wrapper table.tribe-mini-calendar td.tribe-mini-calendar-today a.tribe-mini-calendar-day-link:hover',
			'.tribe_mini_calendar_widget .tribe-mini-calendar-grid-wrapper table.tribe-mini-calendar td a.tribe-mini-calendar-day-link:hover',
		) );
	}

	/**
	 * @param $elements
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function add_border_radius_elements( $elements ) {
		return array_merge( $elements, array(
			'#tribe-bar-form .tribe-bar-submit input[type="submit"]',
			'.tribe-events-day-time-slot',
			'.tribe-events-list-separator-month',
			'.tribe-grid-allday .tribe-event-featured.tribe-events-week-allday-single',
			'.tribe-grid-allday .tribe-event-featured.tribe-events-week-hourly-single',
			'.tribe-grid-body .tribe-event-featured.tribe-events-week-allday-single',
			'.tribe-grid-body .tribe-event-featured.tribe-events-week-hourly-single',
		) );
	}


	/**
	 * @param $outputs
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function add_primary_background_color_outputs( $outputs ) {
		return array_merge( $outputs, array(
			array(
				'element'  => '.type-tribe_events .tribe-mini-calendar-event .list-date .list-dayname',
				'property' => 'color',
			),
			array(
				'element'  => '#tribe-events .button',
				'property' => 'background',
			),
		) );
	}
}

return new Grimlock_The_Events_Calendar_Button_Customizer();
