<?php
/**
 * Cera_Grimlock_Pagination_Customizer Class
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
 * The pagination class for the Customizer.
 */
class Cera_Grimlock_Pagination_Customizer {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'grimlock_pagination_customizer_defaults',       array( $this, 'change_defaults'    ), 10, 1 );
		add_filter( 'grimlock_pagination_customizer_elements',       array( $this, 'add_elements'       ), 10, 1 );
		add_filter( 'grimlock_pagination_customizer_hover_elements', array( $this, 'add_hover_elements' ), 10, 1 );
	}

	/**
	 * Change default values and control settings for the Customizer.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $defaults The array of default values for the Customizer controls.
	 *
	 * @return array           The updated array of default values for the Customizer controls.
	 */
	public function change_defaults( $defaults ) {
		$defaults['pagination_background_color']       = CERA_PAGINATION_BACKGROUND_COLOR;
		$defaults['pagination_hover_background_color'] = CERA_PAGINATION_HOVER_BACKGROUND_COLOR;
		$defaults['pagination_color']                  = CERA_PAGINATION_COLOR;
		$defaults['pagination_hover_color']            = CERA_PAGINATION_HOVER_COLOR;
		$defaults['pagination_border_width']           = CERA_BORDER_WIDTH;
		$defaults['pagination_border_color']           = CERA_PAGINATION_BORDER_COLOR;
		$defaults['pagination_hover_border_color']     = CERA_PAGINATION_HOVER_BORDER_COLOR;
		$defaults['pagination_padding_y']              = .6; // px.
		$defaults['pagination_padding_x']              = 1; // px.
		$defaults['pagination_border_radius']          = CERA_BORDER_RADIUS;
		return $defaults;
	}

	/**
	 * Add CSS selectors to the array of CSS selectors for the pagination.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the pagination.
	 *
	 * @return array           The updated array of CSS selectors for the pagination.
	 */
	public function add_hover_elements( $elements ) {
		return array_merge( $elements, array(
			'.post-navigation .nav-links a:hover',
			'.post-navigation .nav-links a:focus',
			'.post-navigation .nav-links a:active',
			'.page-links > span.current',
		) );
	}

	/**
	 * Add CSS selectors to the array of CSS selectors for the pagination.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the pagination.
	 *
	 * @return array           The updated array of CSS selectors for the pagination.
	 */
	public function add_elements( $elements ) {
		return array_merge( $elements, array(
			'.learndash-pager',
		) );
	}
}

return new Cera_Grimlock_Pagination_Customizer();
