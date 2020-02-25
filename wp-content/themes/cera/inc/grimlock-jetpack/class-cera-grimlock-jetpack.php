<?php
/**
 * Cera_Grimlock_Jetpack Class
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
 * The Cera Grimlock Jetpack integration class.
 */
class Cera_Grimlock_Jetpack {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		require_once get_template_directory() . '/inc/grimlock-jetpack/customizer/class-cera-grimlock-jetpack-global-customizer.php';
		require_once get_template_directory() . '/inc/grimlock-jetpack/customizer/class-cera-grimlock-jetpack-typography-customizer.php';
	}
}

return new Cera_Grimlock_Jetpack();
