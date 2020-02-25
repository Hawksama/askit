<?php
/**
 * Cera_Grimlock_LearnDash_Customizer Class
 *
 * @author  Themosaurus
 * @since   1.0.0
 * @package grimlock
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The Cera Customizer class for BuddyPress.
 */
class Cera_Grimlock_LearnDash_Customizer extends Grimlock_LearnDash_Customizer {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		parent::__construct();
		add_filter( 'grimlock_learndash_customizer_defaults',  array( $this, 'change_defaults'    ), 20, 1 );
		add_filter( 'grimlock_single_args',                    array( $this, 'change_single_args' ), 20, 1 );
	}

	/**
	 * Change default values and control settings for the Customizer.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $defaults The array of default values for the Customizer controls.
	 *
	 * @return array           The updated array of default values for the Customizer controls.
	 */
	public function change_defaults( $defaults ) {
		$defaults['learndash_layout']                 = CERA_LEARNDASH_LAYOUT;
		$defaults['learndash_container_layout']       = CERA_LEARNDASH_CONTAINER_LAYOUT;
		return $defaults;
	}


	/**
	 * Change post arguments using to customize the LearnDash course.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args The default arguments to render the post.
	 *
	 * @return array      The arguments to render the post.
	 */
	public function change_single_args( $args ) {
		if ( $this->is_template() ) {
			$args['post_thumbnail_displayed'] = false;
		}
		return $args;
	}
}

return new Cera_Grimlock_LearnDash_Customizer();
