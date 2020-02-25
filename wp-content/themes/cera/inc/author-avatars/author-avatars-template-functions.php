<?php
/**
 * Cera template functions for Author Avatars
 *
 * @package cera
 */

if ( ! function_exists( 'cera_author_avatars_user_name_template' ) ) :
	/**
	 * Prints the HTML for the BP member xprofile fields.
	 *
	 * @since 1.0.0
	 *
	 * @param string $html The sprintf template.
	 * @param string $name The value (users name) passed into the span.
	 * @param object $user The user object.
	 *
	 * @return string The extra HTML for the user.
	 */
	function cera_author_avatars_user_name_template( $html, $name, $user ) {
		ob_start(); ?>
		<div class="bp-member-xprofile-custom-fields px-2">
			<?php do_action( 'grimlock_buddypress_member_xprofile_custom_fields', $user->user_id ); ?>
		</div>
		<?php $html .= ob_get_clean();

		return $html;
	}
endif;
