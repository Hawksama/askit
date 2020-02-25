<?php
/**
 * Cera_Grimlock_BuddyPress_Customizer Class
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
 * The Cera Customizer class for BuddyPress.
 */
class Cera_Grimlock_BuddyPress_Customizer {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'grimlock_buddypress_customizer_defaults',                                    array( $this, 'change_defaults'                                               ), 10, 1 );
		add_filter( 'grimlock_buddypress_friend_button_background_color_elements',                array( $this, 'remove_friend_button_background_color_elements'                ), 10, 1 );
		add_filter( 'grimlock_buddypress_message_button_background_color_elements',               array( $this, 'remove_message_button_background_color_elements'               ), 10, 1 );
		add_filter( 'grimlock_buddypress_success_button_background_color_outputs',                array( $this, 'add_success_button_background_color_outputs'                   ), 10, 1 );
		add_filter( 'grimlock_buddypress_success_button_background_color_elements',               array( $this, 'remove_success_button_background_color_elements'               ), 10, 1 );
		add_filter( 'grimlock_buddypress_delete_button_background_color_elements',                array( $this, 'remove_delete_button_background_color_elements'                ), 10, 1 );
		add_filter( 'grimlock_buddypress_miscellaneous_actions_button_color_elements',            array( $this, 'remove_miscellaneous_actions_button_color_elements'            ), 10, 1 );
		add_filter( 'grimlock_buddypress_miscellaneous_actions_button_background_color_elements', array( $this, 'remove_miscellaneous_actions_button_background_color_elements' ), 10, 1 );
		add_action( 'after_setup_theme',                                                          array( $this, 'remove_customizer_fields'                                      ), 30, 0 );
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
		$defaults['default_profile_cover_image'] = get_stylesheet_directory_uri() . '/assets/images/covers/member-cover.jpg';
		$defaults['default_group_cover_image']   = get_stylesheet_directory_uri() . '/assets/images/covers/group-cover.jpg';

		$defaults['friend_icons']                                  = 'heart';
		$defaults['member_actions_button_background_color']        = CERA_BUTTON_ACTION_BACKGROUND_COLOR;
		$defaults['friend_button_background_color']                = CERA_BUTTON_ACTION_LOVE_COLOR;
		$defaults['message_button_background_color']               = CERA_BUTTON_ACTION_MESSAGE_COLOR;
		$defaults['success_button_background_color']               = CERA_BUTTON_ACTION_SUCCESS_COLOR;
		$defaults['delete_button_background_color']                = CERA_BUTTON_ACTION_DANGER_COLOR;
		$defaults['miscellaneous_actions_button_background_color'] = CERA_BUTTON_ACTION_MISC_COLOR;

		$defaults['profile_header_background_color'] = CERA_GRAY_DARKEST;

		return $defaults;
	}

	/**
	 * Remove CSS selectors from the array of CSS selectors for the friend button.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors.
	 *
	 * @return array           The updated array of CSS selectors.
	 */
	public function remove_friend_button_background_color_elements( $elements ) {
		$elements[] = ".fake-cera-selector";
		return array_diff( $elements, array(
			'.widget_grimlock_nav_menu_section .menu .menu-item.primary .icon-wrapper:before',
			'.widget_grimlock_nav_menu_section .menu .menu-item.primary .icon-wrapper:after',
		) );
	}

	/**
	 * Remove CSS selectors from the array of CSS selectors for the message button.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors.
	 *
	 * @return array           The updated array of CSS selectors.
	 */
	public function remove_message_button_background_color_elements( $elements ) {
		$elements[] = ".fake-cera-selector";
		return array_diff( $elements, array(
			'.widget_grimlock_nav_menu_section .menu .menu-item.info .icon-wrapper:before',
			'.widget_grimlock_nav_menu_section .menu .menu-item.info .icon-wrapper:after',
		) );
	}

	/**
	 * Add style outputs for the success button.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors.
	 *
	 * @return array           The updated array of CSS selectors.
	 */
	public function add_success_button_background_color_outputs( $outputs ) {
		return array_merge( $outputs, array(
			array(
				'element'  => '.bp-card-list.bp-card-list--members .bp-card-list__item.is-online .card .card-img > a:before',
				'property' => 'border-color',
			)
		) );
	}

	/**
	 * Remove CSS selectors from the array of CSS selectors for the success button.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors.
	 *
	 * @return array           The updated array of CSS selectors.
	 */
	public function remove_success_button_background_color_elements( $elements ) {
		$elements[] = ".fake-cera-selector";
		return array_diff( $elements, array(
			'.widget_grimlock_nav_menu_section .menu .menu-item.success .icon-wrapper:before',
			'.widget_grimlock_nav_menu_section .menu .menu-item.success .icon-wrapper:after',
			'.bp-card-list.bp-card-list--members .bp-card-list__item.is-online .card:before',
		) );
	}

	/**
	 * Remove CSS selectors from the array of CSS selectors for the delete button.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors.
	 *
	 * @return array           The updated array of CSS selectors.
	 */
	public function remove_delete_button_background_color_elements( $elements ) {
		$elements[] = ".fake-cera-selector";
		return array_diff( $elements, array(
			'.widget_grimlock_nav_menu_section .menu .menu-item.danger .icon-wrapper:before',
			'.widget_grimlock_nav_menu_section .menu .menu-item.danger .icon-wrapper:after',
		) );
	}

	/**
	 * Remove CSS selectors from the array of CSS selectors for the misc button.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors.
	 *
	 * @return array           The updated array of CSS selectors.
	 */
	public function remove_miscellaneous_actions_button_color_elements( $elements ) {
		$elements[] = ".fake-cera-selector";
		return array_diff( $elements, array(
			'#buddypress:not(.youzer) #activity-stream.grimlock-buddypress-activity-list .activity-item .unfav',
			'#buddypress:not(.youzer) #activity-stream.grimlock-buddypress-activity-list .activity-item .fav',
			'#buddypress:not(.youzer) #activity-stream.grimlock-buddypress-activity-list .activity-item .unfav:before',
			'#buddypress:not(.youzer) #activity-stream.grimlock-buddypress-activity-list .activity-item .unfav:after',
			'#buddypress:not(.youzer) #activity-stream.grimlock-buddypress-activity-list .activity-item .fav:before',
			'#buddypress:not(.youzer) #activity-stream.grimlock-buddypress-activity-list .activity-item .fav:after',
			'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action.action--limited > div.dropdown.dropdown--more-actions > a:before',
		) );
	}

	/**
	 * Remove CSS selectors from the array of CSS selectors for the misc button.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors.
	 *
	 * @return array           The updated array of CSS selectors.
	 */
	public function remove_miscellaneous_actions_button_background_color_elements( $elements ) {
		$elements[] = ".fake-cera-selector";
		return array_diff( $elements, array(
			'.widget_grimlock_nav_menu_section .menu .menu-item .icon-wrapper:before',
			'.widget_grimlock_nav_menu_section .menu .menu-item .icon-wrapper:after',
		) );
	}

	/**
	 * Remove Customizer fields
	 */
	public function remove_customizer_fields() {
		if ( class_exists( 'Kirki' ) ) {
			Kirki::remove_control( 'members_actions_text_displayed' );
			Kirki::remove_control( 'groups_actions_text_displayed' );
			Kirki::remove_control( 'friend_icons' );
		}
	}

}

return new Cera_Grimlock_BuddyPress_Customizer();
