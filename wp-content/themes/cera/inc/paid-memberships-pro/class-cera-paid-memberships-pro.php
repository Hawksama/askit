<?php
/**
 * Cera Grimlock Class
 *
 * @package  cera
 * @author   Themosaurus
 * @since    1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Cera_Paid_Memberships_Pro' ) ) :
	/**
	 * The Cera Grimlock integration class
	 */
	class Cera_Paid_Memberships_Pro {
		/**
		 * Setup class.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			require_once get_template_directory() . '/inc/paid-memberships-pro/customizer/class-cera-paid-memberships-pro-button-customizer.php';
			require_once get_template_directory() . '/inc/paid-memberships-pro/customizer/class-cera-paid-memberships-pro-archive-customizer.php';
			require_once get_template_directory() . '/inc/paid-memberships-pro/customizer/class-cera-paid-memberships-pro-table-customizer.php';
		}
	}
endif;

return new Cera_Paid_Memberships_Pro();
