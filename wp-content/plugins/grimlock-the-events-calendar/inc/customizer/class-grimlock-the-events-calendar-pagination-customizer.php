<?php
/**
 * Grimlock_The_Events_Calendar_Pagination_Customizer Class
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
class Grimlock_The_Events_Calendar_Pagination_Customizer {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'grimlock_pagination_customizer_elements', array( $this, 'add_elements' ), 10,  1 );
	}

	/**
	 * Add The Events Calendar CSS elements for the pagination.
	 *
	 * @param array $elements The array of already registered elements
	 * @since 1.0.0
	 *
	 * @return array The array of CSS elements
	 */
	public function add_elements( $elements ) {
		return array_merge( $elements, array(
			'.tribe-events-sub-nav > li.tribe-events-nav-next > a',
			'.tribe-events-sub-nav > li.tribe-events-nav-previous > a',
			'.tribe-events-sub-nav > li.tribe-this-week-nav-link > a',
		) );
	}
}

return new Grimlock_The_Events_Calendar_Pagination_Customizer();
