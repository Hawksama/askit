<?php
/**
 * Cera template functions for Grimlock for BuddyPress.
 *
 * @package cera
 */

if ( ! function_exists( 'cera_grimlock_buddypress_actions_dropdown' ) ) :
	/**
	 * Output a dropdown with BP actions.
	 *
	 * @since 1.0.0
	 */
	function cera_grimlock_buddypress_actions_dropdown() { ?>
		<div class="dropdown dropdown--more-actions dropdown--more-actions-list generic-button">
			<a href="#" class="dropdown-toggle mr-0" id="dropdownMoreActions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="0,15">
				<?php echo esc_html_x( 'More', 'Cera text button more', 'cera' ); ?>
			</a> <!-- .dropdown--toggle -->
			<div class="dropdown-menu" aria-labelledby="dropdownMoreActions">
				<?php do_action( 'bp_directory_members_actions' ); ?>
			</div> <!-- .dropdown-menu -->
		</div> <!-- .dropdown--more-actions -->
	<?php }
endif;

if ( ! function_exists( 'cera_grimlock_buddypress_actions_dropdown_profile' ) ) :
	/**
	 * Output a dropdown with BP actions.
	 *
	 * @since 1.0.0
	 */
	function cera_grimlock_buddypress_actions_dropdown_profile() { ?>
		<div class="dropdown dropdown--more-actions dropdown--more-actions-profile generic-button">
			<a href="#" class="dropdown-toggle mr-0" id="dropdownMoreActions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="0,15">
				<?php echo esc_html_x( 'More', 'Cera text button more', 'cera' ); ?>
			</a> <!-- .dropdown--toggle -->
			<div class="dropdown-menu" aria-labelledby="dropdownMoreActions">
				<?php do_action( 'bp_member_header_actions' ); ?>
			</div> <!-- .dropdown-menu -->
		</div> <!-- .dropdown--more-actions -->
	<?php }
endif;
