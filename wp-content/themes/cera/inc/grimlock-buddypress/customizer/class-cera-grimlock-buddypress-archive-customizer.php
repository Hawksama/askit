<?php
/**
 * Cera_Grimlock_BuddyPress_Archive_Customizer Class
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
class Cera_Grimlock_BuddyPress_Archive_Customizer {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'grimlock_archive_customizer_elements',                       array( $this, 'add_elements'                          ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_background_color_elements', array( $this, 'add_post_background_color_elements'    ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_background_color_outputs',  array( $this, 'add_post_background_color_outputs'     ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_border_radius_elements',    array( $this, 'add_post_border_radius_elements'       ), 10, 1 );
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
			'div.grimlock-buddypress-groups-section ul#groups-list > li',
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
			'.bp-card-list.bp-card-list--members .bp-card-list__item.is-online .card .card-img > a:before',
			'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action.action--limited',
			'.widget_bp_birthday_widget ul.birthday-members-list li .emoji',
			'.bp-better-messages-list .tabs-content > div.active',
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
				'element'       => implode( ',', array(
					'.bp-card-list--groups__item img.avatar',
				) ),
				'property'      => 'border',
				'value_pattern' => '6px solid $',
				'suffix'        => '!important',
			),
			array(
				'element'       => implode( ',', array(
					'.bp-card-list--groups__item img.avatar',
				) ),
				'property'      => 'background-color',
			),
			array(
				'element'       => implode( ',', array(
					'.bp-card-list.bp-card-list--members .bp-card-list__item.is-online .card .card-img > a:before',
				) ),
				'property'      => 'box-shadow',
				'value_pattern' => '0 0 0 5px $',
			),
		) );
	}

	/**
	 * Add CSS selectors from the array of CSS selectors for the archive post border radius.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the archive post border radius.
	 *
	 * @return array           The updated array of CSS selectors for the archive post border radius.
	 */
	public function add_post_border_radius_elements( $elements ) {
		return array_merge( $elements, array(
			'#buddypress:not(.youzer) .activity-item .activity-inner',
		) );
	}
}

return new Cera_Grimlock_BuddyPress_Archive_Customizer();
