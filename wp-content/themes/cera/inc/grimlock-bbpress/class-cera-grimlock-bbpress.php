<?php
/**
 * Cera_Grimlock_bbPress Class
 *
 * @package  cera
 * @author   Themosaurus
 * @since    1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The Cera Grimlock bbPress integration class
 */
class Cera_Grimlock_bbPress {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'add_support_for_forums' ), 10 );
		require_once get_template_directory() . '/inc/grimlock-bbpress/customizer/class-cera-grimlock-bbpress-archive-forum-customizer.php';
		require_once get_template_directory() . '/inc/grimlock-bbpress/customizer/class-cera-grimlock-bbpress-button-customizer.php';
		require_once get_template_directory() . '/inc/grimlock-bbpress/customizer/class-cera-grimlock-bbpress-archive-customizer.php';
		require_once get_template_directory() . '/inc/grimlock-bbpress/customizer/class-cera-grimlock-bbpress-table-customizer.php';
	}

	/**
	 * Enables the Excerpt meta box in Page edit screen.
	 *
	 * @since 1.0.0
	 */
	public function add_support_for_forums() {
		add_post_type_support( 'forum', array( 'thumbnail', 'excerpt' ));
	}
}

return new Cera_Grimlock_bbPress();
