<?php
/**
 * Cera_Grimlock_LearnDash_Grimlock_BuddyPress_Customizer Class
 *
 * @package cera
 * @author  Themosaurus
 * @since   1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The Cera Grimlock for LearnDash integration class.
 */
class Cera_Grimlock_LearnDash_Grimlock_BuddyPress_Customizer {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'cera_grimlock_buddypress_member_actions_button_background_color_outputs',        array( $this, 'add_member_actions_button_background_color_outputs'        ) );
		add_filter( 'cera_grimlock_buddypress_success_button_background_color_elements',              array( $this, 'add_success_button_background_color_elements'              ) );
		add_filter( 'cera_grimlock_buddypress_miscellaneous_actions_button_background_color_outputs', array( $this, 'add_miscellaneous_actions_button_background_color_outputs' ) );
	}

	/**
	 * Add selectors and properties to the CSS rule-set for the member actions button background color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $outputs The array of CSS selectors and properties for the archive post border color.
	 *
	 * @return array          The updated array of CSS selectors for the archive post border color.
	 */
	public function add_member_actions_button_background_color_outputs( $outputs ) {
		return array_merge( $outputs, array(
			array(
				'element'  => implode( ',', array(
					'.ld_course_grid > .thumbnail.course .ld_course_grid_price',
				) ),
				'property' => 'color',
				'suffix'   => '!important',
			),
		) );
	}

	/**
	 * Add CSS selectors from the array of CSS selectors for the success button background color
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the archive post background color.
	 *
	 * @return array           The updated array of CSS selectors for the archive post background color.
	 */
	public function add_success_button_background_color_elements( $elements ) {
		return array_merge( $elements, array(
			'.ld_course_grid > .thumbnail.course .ld_course_grid_price',
		) );
	}

	/**
	 * Add selectors and properties to the CSS rule-set for the misc actions button background color
	 *
	 * @since 1.0.0
	 *
	 * @param  array $outputs The array of CSS selectors and properties for the archive post border color.
	 *
	 * @return array          The updated array of CSS selectors for the archive post border color.
	 */
	public function add_miscellaneous_actions_button_background_color_outputs( $outputs ) {
		return array_merge( $outputs, array(
			array(
				'element'  => implode( ',', array(
					'.ld_course_grid > .thumbnail.course .ld_course_grid_price.ribbon-enrolled',
					'.ld_course_grid > .thumbnail.course .ld_course_grid_price.free',
				) ),
				'property' => 'background',
				'suffix'   => '!important',
			),
		) );
	}
}

return new Cera_Grimlock_LearnDash_Grimlock_BuddyPress_Customizer();
