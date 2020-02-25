<?php
/**
 * Cera_Grimlock_bbPress_Button_Customizer Class
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
 * The button class for the Customizer.
 */
class Cera_Grimlock_bbPress_Button_Customizer {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'grimlock_button_customizer_primary_elements',                  array( $this, 'add_primary_elements'                  ), 10, 1 );
		add_filter( 'grimlock_button_customizer_primary_background_color_elements', array( $this, 'add_primary_background_color_elements' ), 10, 1 );
	}


	/**
	 * Add CSS selectors to the array of CSS selectors for the primary button.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the primary button.
	 *
	 * @return array           The updated array of CSS selectors for the primary button.
	 */
	public function add_primary_elements( $elements ) {
		return array_merge( $elements, array(
			'body:not([class*="yz-"]) #bbpress-forums > #subscription-toggle a',
			'body:not([class*="yz-"]) #bbpress-forums ul.bbp-replies li .bbp-list-author .bbp-author-role',
		) );
	}


	/**
	 * Add CSS selectors to the array of CSS selectors for the primary button background color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the primary button background color.
	 *
	 * @return array           The updated array of CSS selectors for the primary button background color.
	 */
	public function add_primary_background_color_elements( $elements ) {
		return array_merge( $elements, array(
			'.bbp-topics-front ul.super-sticky:before',
			'.bbp-topics ul.super-sticky:before',
			'.bbp-forum ul.super-sticky:before',
			'.bbp-forum ul.sticky:before',
			'.bbp-topics ul.sticky:before',
			'.bbp-forum-content ul.sticky:before',
		) );
	}
}

return new Cera_Grimlock_bbPress_Button_Customizer();
