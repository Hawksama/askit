<?php
/**
 * Grimlock_bbPress_Single_Forum_Customizer Class
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
 * The Grimlock Customizer class for the posts page and the archive pages.
 */
class Grimlock_bbPress_Single_Forum_Customizer {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'grimlock_custom_header_args',                           array( $this, 'add_custom_header_args' ), 30, 1 );
		add_filter( 'grimlock_bbpress_archive_forum_customizer_is_template', array( $this, 'is_template'            ), 10, 1 );
	}

	/**
	 * @param $default
	 *
	 * @return bool
	 */
	public function is_template( $default = false ) {
		return function_exists( 'bbp_is_forum' ) && bbp_is_forum() ||
		       function_exists( 'bbp_is_single_forum' ) && bbp_is_single_forum() ||
		       function_exists( 'bbp_is_forum_edit' ) && bbp_is_forum_edit() ||
		       $default;
	}

	/**
	 * Change the title for the Custom Header.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $args The array of arguments for the Custom Header.
	 *
	 * @return array       The filtered array of arguments for the Custom Header.
	 */
	public function add_custom_header_args( $args ) {
		if ( $this->is_template() ) {
			$args['title'] = single_post_title( '', false );
			$_post         = get_queried_object();

			if ( ! empty( $_post ) && $_post instanceof WP_Post && isset( $_post->ID ) ) {
				$args['subtitle'] = '' !== $_post->post_excerpt ? "<span class='excerpt'>{$_post->post_excerpt}</span>" : '';
			}
		}
		return $args;
	}
}

return new Grimlock_bbPress_Single_Forum_Customizer();
