<?php
/**
 * Cera_Grimlock_The_Events_Calendar_Archive_Customizer Class
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
 * The post archive page class for the Customizer.
 */
class Cera_Grimlock_The_Events_Calendar_Archive_Customizer {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'grimlock_archive_customizer_elements',                       array( $this, 'add_elements'                       ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_background_color_elements', array( $this, 'add_post_background_color_elements' ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_background_color_outputs',  array( $this, 'add_post_background_color_outputs'  ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_color_elements',            array( $this, 'add_post_color_elements'            ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_color_outputs',             array( $this, 'add_post_color_outputs'             ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_padding_elements',          array( $this, 'add_post_padding_elements'          ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_border_color_outputs',      array( $this, 'add_post_border_color_outputs'      ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_title_color_elements',      array( $this, 'add_post_title_color_elements'      ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_border_radius_elements',    array( $this, 'add_post_border_radius_elements'    ), 10, 1 );
	}

	/**
	 * Add CSS selectors from the array of CSS selectors for the archive post.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the archive post.
	 *
	 * @return array           The updated array of CSS selectors for the archive post.
	 */
	public function add_elements( $elements ) {
		return array_merge( $elements, array(
			'#tribe-bar-form',
			'.tribe-events-list .tribe-events-loop .type-tribe_events .card',
			'#tribe-geo-map-wrapper',
			'#rsvp-now',
			'#tribe-events-content form.cart',
			'.tribe-rsvp-list > .tribe-item',
			'.tribe-orders-list .tribe-tickets-list > .tribe-item',
			'#tribe-community-events',
			'.tribe-community-events-content > #tribe-events',
			'body[class*="tribe_community"] #tribe-events-pg-template #tribe-events',
			'.tribe-block__tickets__registration__event',
			'#tribe-events-report',
		) );
	}

	/**
	 * Add CSS selectors from the array of CSS selectors for the archive post background color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the archive post background color.
	 *
	 * @return array           The updated array of CSS selectors for the archive post background color.
	 */
	public function add_post_background_color_elements( $elements ) {
		return array_merge( $elements, array(
			'#tribe-events-content table.tribe-events-calendar',
			'#tribe-events-content .tribe-events-tooltip',
			'#tribe-bar-views .tribe-bar-views-list',
			'#tribe-bar-views .tribe-bar-views-list span[class^=tribe-icon-]',
		) );
	}

	/**
	 * Add CSS selectors from the array of CSS selectors for the archive post color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the archive post color.
	 *
	 * @return array           The updated array of CSS selectors for the archive post color.
	 */
	public function add_post_color_elements( $elements ) {
		return array_merge( $elements, array(
			'#tribe-events-content table.tribe-events-calendar',
			'#tribe-events-content .tribe-events-tooltip',
		) );
	}

	/**
	 * Add selectors and properties to the CSS rule-set for the archive post background color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $outputs The array of CSS selectors and properties for the archive post background color.
	 *
	 * @return array          The updated array of CSS selectors for the archive post background color.
	 */
	public function add_post_background_color_outputs( $outputs ) {
		return array_merge( $outputs, array(
			array(
				'element'  => implode( ',', array(
					'#tribe-bar-form',
					'.tribe-events-ajax-loading',
				) ),
				'property' => 'background',
				'suffix'   => '!important',
			),
		) );
	}

	/**
	 * Add selectors and properties to the CSS rule-set for the archive post color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $outputs The array of CSS selectors and properties for the archive post color.
	 *
	 * @return array          The updated array of CSS selectors for the archive post color.
	 */
	public function add_post_color_outputs( $outputs ) {
		return array_merge( $outputs, array(
			array(
				'element'  => implode( ',', array(
					'.recurringinfo .event-is-recurring',
				) ),
				'property' => 'color',
				'suffix'   => '!important',
			),
		) );
	}

	/**
	 * Add CSS selectors from the array of CSS selectors for the archive post padding.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the archive post padding.
	 *
	 * @return array           The updated array of CSS selectors for the archive post padding.
	 */
	public function add_post_padding_elements( $elements ) {
		return array_merge( $elements, array(
			'.tribe-events-list .tribe-events-loop .type-tribe_events .card .card-body',
		) );
	}

	/**
	 * Add selectors and properties to the CSS rule-set for the archive post border color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $outputs The array of CSS selectors and properties for the archive post border color.
	 *
	 * @return array          The updated array of CSS selectors for the archive post border color.
	 */
	public function add_post_border_color_outputs( $outputs ) {
		return array_merge( $outputs, array(
			array(
				'element'  => implode( ',', array(
					'.tribe-events-event-cost span',
				) ),
				'property' => 'border-color',
			),
		) );
	}

	/**
	 * Add CSS selectors from the array of CSS selectors for the archive post title color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the archive post title color.
	 *
	 * @return array           The updated array of CSS selectors for the archive post title color.
	 */
	public function add_post_title_color_elements( $elements ) {
		return array_merge( $elements, array(
			'#tribe-events-content table.tribe-events-calendar div[id*=tribe-events-event-] h3.tribe-events-month-event-title',
			'.tribe-community-events .tribe-section .tribe-section-header h3',
			'.tribe-events-ajax-loading',
			'div.tribe-this-week-widget-wrapper .entry-title',
			'.tribe-events-venue-widget .tribe-venue-widget-venue .tribe-venue-widget-venue-name',
		) );
	}

	/**
	 * Add CSS selectors from the array of CSS selectors for the archive post border radius.
	 *
	 * @since 1.0.0.tribe-this-week-widget-da
	 *
	 * @param  array $elements The array of CSS selectors for the archive post border radius.
	 *
	 * @return array           The updated array of CSS selectors for the archive post border radius.
	 */
	public function add_post_border_radius_elements( $elements ) {
		return array_merge( $elements, array(
			'#tribe-events-content .tribe-events-tooltip',
			'.tribe-link-view-attendee',
			'.tribe-attendees-list-container',
			'.tribe-tickets-attendees-list-optout',
			'.table-menu-wrapper .table-menu',
			'.tribe-this-week-widget-vertical .tribe-this-week-widget-header-date',
			'.tribe-mini-calendar',
			'.tribe-mini-calendar-list-wrapper .tribe-event-featured .tribe-mini-calendar-event .tribe-event-image',
			'.widget .tribe-event-image img',
			'.widget .tribe-venue-widget-thumbnail img',
			'.tribe-events-venue-widget .tribe-venue-widget-venue',
			'.tribe-countdown-text > a',
			'#tribe-events-content table.tribe-events-calendar div[id*=tribe-events-event-] h3.tribe-events-month-event-title a',
		) );
	}
}

return new Cera_Grimlock_The_Events_Calendar_Archive_Customizer();
