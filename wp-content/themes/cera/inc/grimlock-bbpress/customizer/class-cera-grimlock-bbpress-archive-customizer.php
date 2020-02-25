<?php
/**
 * Cera_Grimlock_bbPress_Archive_Customizer Class
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
class Cera_Grimlock_bbPress_Archive_Customizer {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'grimlock_archive_customizer_elements',                       array( $this, 'add_elements'                       ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_border_radius_elements',    array( $this, 'add_post_border_radius_elements'    ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_background_color_elements', array( $this, 'add_post_background_color_elements' ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_title_color_outputs',       array( $this, 'add_post_title_color_outputs'       ), 10, 1 );
	}

	/**
	 * Add CSS selectors from the array of CSS selectors for the archive post styles.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the archive post styles.
	 *
	 * @return array           The updated array of CSS selectors for the archive post styles.
	 */
	public function add_elements( $elements ) {
		return array_merge( $elements, array(
			'body:not([class*="yz-"]) #bbpress-forums #bbp-search-form',
			'#bbpress-forums #new-post .bbp-template-notice + div:not(.bbp-template-notice)',
		) );
	}

	/**
	 * Add selectors and properties to the CSS rule-set for the archive post border radius.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $outputs The array of CSS selectors and properties for the archive post border radius.
	 *
	 * @return array          The updated array of CSS selectors for the archive post border radius.
	 */
	public function add_post_title_color_outputs( $outputs ) {
		return array_merge( $outputs, array(
			array(
				'element'  => implode( ',', array(
					'ul.bbp-topics-widget .bbp-forum-title:not(:hover)',
					'ul.bbp-replies-widget .bbp-author-name:not(:hover)',
				) ),
				'property' => 'color',
				'suffix'   => '!important',
			),
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
			'#bbpress-forums div.odd',
			'#bbpress-forums ul.odd',
			'#bbpress-forums div.even',
			'#bbpress-forums ul.even',
		) );
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
	public function add_post_border_radius_elements( $elements ) {
		return array_merge( $elements, array(
			'ul.bbp-topics-widget li',
			'ul.bbp-replies-widget li',
			'#bbpress-forums #new-post legend + div:not(.bbp-template-notice)',
			'.bbp-topics-front ul.super-sticky:before',
			'.bbp-topics ul.super-sticky:before',
			'.bbp-forum ul.super-sticky:before',
			'.bbp-forum ul.sticky:before',
			'.bbp-topics ul.sticky:before',
			'.bbp-forum-content ul.sticky:before',
		) );
	}
}

return new Cera_Grimlock_bbPress_Archive_Customizer();
