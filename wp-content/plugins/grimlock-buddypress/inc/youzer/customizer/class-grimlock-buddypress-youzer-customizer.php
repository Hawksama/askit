<?php
/**
 * Grimlock_BuddyPress_Youzer_Customizer Class
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
 * The background image class for the Customizer.
 */
class Grimlock_BuddyPress_Youzer_Customizer {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		global $grimlock_buddypress_customizer;
		remove_action( 'grimlock_buddypress_member_xprofile_custom_fields', array( $grimlock_buddypress_customizer, 'add_member_custom_fields' ), 10    );
		add_action( 'grimlock_buddypress_member_xprofile_custom_fields',    array( $this,                           'add_member_custom_fields' ), 10, 1 );

		add_action( 'after_setup_theme',                                    array( $this, 'remove_customizer_fields'                           ), 30    );
	}

	/**
	 * Display xprofile fields in members using youzer function
	 *
	 * @param int $user_id The id of the user.
	 */
	public function add_member_custom_fields( $user_id ) {
		if ( empty( $user_id ) ) {
			$user_id = bp_get_member_user_id();
		}

		if ( empty( $user_id ) ) {
			$user_id = bp_displayed_user_id();
		}

		echo wp_kses( yz_get_md_user_meta( $user_id ), array_merge( wp_kses_allowed_html( 'user_description' ), array( 'i' => array( 'class' => true ) ) ) );
	}

	/**
	 * Remove Customizer fields
	 */
	public function remove_customizer_fields() {
		Kirki::remove_control( 'members_displayed_profile_fields' );
	}

}

return new Grimlock_BuddyPress_Youzer_Customizer();
