<?php
/**
 * Cera_Grimlock_The_Events_Calendar_Typography_Customizer Class
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
 * The typography class for the Customizer.
 */
class Cera_Grimlock_The_Events_Calendar_Typography_Customizer {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'grimlock_typography_customizer_text_color_outputs',    array( $this, 'add_text_color_outputs'    ), 10, 1 );
		add_filter( 'grimlock_typography_customizer_heading_color_outputs', array( $this, 'add_heading_color_outputs' ), 10, 1 );
		add_filter( 'grimlock_typography_customizer_heading_font_outputs',  array( $this, 'add_heading_font_outputs'  ), 10, 1 );
		add_filter( 'grimlock_typography_customizer_link_color_elements',   array( $this, 'add_link_color_elements'   ), 10, 1 );
	}

	/**
	 * Add selectors and properties to the CSS rule-set for the heading color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $outputs The array of CSS selectors and properties for the heading color.
	 *
	 * @return array          The updated array of CSS selectors for the heading color.
	 */
	public function add_heading_color_outputs( $outputs ) {
		return array_merge( $outputs, array(
			array(
				'element'  => implode( ',', array(
					'div.type-tribe_events .card .entry-summary a.tribe-event-url',
				) ),
				'property' => 'color',
			),
			array(
				'element'  => implode( ',', array(
					'.tribe-this-week-widget-vertical .tribe-this-week-widget-header-date',
					'.tribe_mini_calendar_widget .tribe-mini-calendar-grid-wrapper table.tribe-mini-calendar .tribe-mini-calendar-nav tr:first-child td',
				) ),
				'property' => 'background-color',
				'suffix'   => '!important',
			),
		) );
	}

	/**
	 * Add CSS selectors to the array of CSS selectors for the link color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the link color.
	 *
	 * @return array           The updated array of CSS selectors for the link color.
	 */
	public function add_link_color_elements( $elements ) {
		return array_merge( $elements, array(
			'.tribe-block__venue .tribe-block__venue__meta .tribe-block__venue__address a',
			'.tribe-community-events-list .edit a:active',
			'.tribe-community-events-list .edit a:hover',
			'.tribe-community-events-list .edit a:visited',
			'.tribe-community-events-list .view a:active',
			'.tribe-community-events-list .view a:hover',
			'.tribe-community-events-list .view a:visited',
			'.tribe-community-events-list td .row-actions a:hover',
		) );
	}

	/**
	 * Add selectors and properties to the CSS rule-set for the text color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $outputs The array of CSS selectors and properties for the text color.
	 *
	 * @return array          The updated array of CSS selectors for the text color.
	 */
	public function add_text_color_outputs( $outputs ) {
		return array_merge( $outputs, array(
			array(
				'element'  => implode( ',', array(
					'.tribe-events-day-time-slot',
					'.tribe-events-list-separator-month',
					'#tribe-events-content .tribe-events-tooltip h4',

				) ),
				'property' => 'background-color',
			),
			array(
				'element'  => implode( ',', array(
					'.tribe-countdown-text > a:hover',
				) ),
				'property' => 'color',
				'suffix'   => '!important',
			),
			array(
				'element'  => implode( ',', array(
					'.tribe-countdown-text > a:hover',
				) ),
				'property' => 'border-color',
			),
		) );
	}

	/**
	 * Add selectors and properties to the CSS rule-set for the heading font.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $outputs The array of CSS selectors and properties for the heading font.
	 *
	 * @return array          The updated array of CSS selectors for the heading font.
	 */
	public function add_heading_font_outputs( $outputs ) {
		$elements_headings = array(
			'.tribe-events-tickets header',
			'.tribe-rsvp-list > li.tribe-item .list-attendee',
			'.tribe-tickets-list > li.tribe-item .list-attendee',
			'.tribe-events-style-full #tribe-events h1',
			'.tribe-events-style-full #tribe-events h2',
			'.tribe-events-style-full #tribe-events h3',
			'.tribe-events-style-full #tribe-events h4',
			'.tribe-events-style-full #tribe-events h5',
			'.tribe-events-style-full #tribe-events h6',
		);

		return array_merge( $outputs, array(
			array(
				'element'  => implode( ',', $elements_headings ),
				'property' => 'font-family',
				'choice'   => 'font-family',
			),
			array(
				'element'  => implode( ',', $elements_headings ),
				'property' => 'text-transform',
				'choice'   => 'text-transform',
			),
			array(
				'element'  => implode( ',', $elements_headings ),
				'property' => 'font-weight',
				'choice'   => 'font-weight',
			),
			array(
				'element'  => implode( ',', $elements_headings ),
				'property' => 'font-style',
				'choice'   => 'font-style',
			),
		) );
	}
}

return new Cera_Grimlock_The_Events_Calendar_Typography_Customizer();
