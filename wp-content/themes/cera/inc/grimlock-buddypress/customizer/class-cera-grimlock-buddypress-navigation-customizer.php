<?php
/**
 * Cera_Grimlock_BuddyPress_Navigation_Customizer Class
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
 * The navigation class for the Customizer.
 */
class Cera_Grimlock_BuddyPress_Navigation_Customizer {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'grimlock_navigation_customizer_stick_to_top_background_color_elements', array( $this, 'remove_stick_to_top_background_color_elements' ), 10, 1 );
		add_filter( 'grimlock_navigation_customizer_stick_to_top_background_color_outputs',  array( $this, 'add_stick_to_top_background_color_outputs'     ), 10, 1 );
		add_filter( 'grimlock_navigation_customizer_background_color_outputs',               array( $this, 'add_background_color_outputs'                  ), 10, 1 );
	}

	/**
	 * Add selectors and properties to the CSS rule-set for the navigation background color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $outputs The array of CSS selectors and properties for the navigation background color.
	 *
	 * @return array          The updated array of CSS selectors for the navigation background color.
	 */
	public function add_background_color_outputs( $outputs ) {
		foreach ( $outputs as $key => $output ) {
			if ( isset( $output['property'] ) && $output['property'] === 'border-color' ) {
				$elements = explode( ',', $output['element'] );
				$elements[] = ".fake-cera-selector";
				$elements = array_diff( $elements, array(
					'.main-navigation .navbar-nav.navbar-nav--buddypress.logged-out .menu-item--profile:after',
				) );
				$outputs[ $key ]['element'] = implode( ',', $elements );
			}

			if ( isset( $output['property'] ) && $output['property'] === 'box-shadow' ) {
				$elements = explode( ',', $output['element'] );
				$elements[] = ".fake-cera-selector";
				$elements = array_diff( $elements, array(
					'.main-navigation .navbar-nav.navbar-nav--buddypress .bubble-count',
				) );
				$outputs[ $key ]['element'] = implode( ',', $elements );
			}
		}

		return array_merge( $outputs, array(
			array(

			),
		) );
	}

	/**
	 * Remove CSS selectors from the array of CSS selectors for the sticky navigation background color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the sticky navigation background color.
	 *
	 * @return array           The updated array of CSS selectors for the sticky navigation background color.
	 */
	public function remove_stick_to_top_background_color_elements( $elements ) {
		$elements[] = ".fake-cera-selector";
		return array_diff( $elements, array(
			'body:not(.grimlock--custom_header-displayed):not(.bbp-user-page):not(.group-home):not(.group-admin) .grimlock-navigation:not(.vertical-navbar)',
			'body.bbp-user-page[class*="yz-"][class*="-scheme"]:not(.grimlock--custom_header-displayed):not(.group-home):not(.group-admin) .grimlock-navigation:not(.vertical-navbar)',
			'body.activity.bp-user.activity-permalink .grimlock-navigation:not(.vertical-navbar)',
			'body.single-item.groups[class*="yz-"][class*="-scheme"]:not(.grimlock--custom_header-displayed) .grimlock-navigation:not(.vertical-navbar)',
		) );
	}

	/**
	 * Add selectors and properties to the CSS rule-set for the sticky navigation background color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $outputs The array of CSS selectors and properties for the sticky navigation background color.
	 *
	 * @return array          The updated array of CSS selectors for the sticky navigation background color.
	 */
	public function add_stick_to_top_background_color_outputs( $outputs ) {
		foreach ( $outputs as $key => $output ) {
			if ( isset( $output['property'] ) && $output['property'] === 'border-color' ) {
				$elements = explode( ',', $output['element'] );
				$elements[] = ".fake-cera-selector";
				$elements = array_diff( $elements, array(
					'body:not(.grimlock--custom_header-displayed):not(.bbp-user-page):not(.group-home):not(.group-admin) .grimlock-navigation:not(.vertical-navbar) .bubble-count',
					'body:not(.grimlock--custom_header-displayed):not(.bbp-user-page):not(.group-home):not(.group-admin) .grimlock-navigation:not(.vertical-navbar) .logged-out .menu-item--profile:after',
					'.grimlock--navigation-stick-to-top .main-navigation .navbar-nav.navbar-nav--buddypress .bubble-count',
					'.grimlock--navigation-stick-to-top .main-navigation .navbar-nav.navbar-nav--buddypress.logged-out .menu-item--profile:after',
				) );
				$outputs[ $key ]['element'] = implode( ',', $elements );
			}
		}

		return array_merge( $outputs, array(
			array(
				'element'  => implode( ',', array(
					'.main-navigation .navbar-nav.navbar-nav--buddypress.logged-out .menu-item--profile:after',
				) ),
				'property' => 'border-color',
			),
		) );
	}
}

return new Cera_Grimlock_BuddyPress_Navigation_Customizer();
