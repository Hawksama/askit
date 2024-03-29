<?php
/**
 * Grimlock_Login_Button_Customizer Class
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
 * The Grimlock Login Button Customizer class.
 */
class Grimlock_Login_Button_Customizer extends Grimlock_Button_Customizer {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		parent::__construct();
		add_action( 'login_enqueue_scripts', array( $this, 'enqueue_styles' ), 10    );
		add_filter( 'grimlock_login_fonts',  array( $this, 'add_fonts'      ), 10, 1 );
	}

	/**
	 * Enqueue custom styles based on theme mods.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles() {
		$button_font = $this->get_theme_mod( 'button_font' );
		$styles      = "
		.login .button,
		.wp-core-ui .button-group.button-large .button,
		.wp-core-ui .button.button-large,
		#jetpack-sso-wrap__action .jetpack-sso.button {
			padding-top: {$this->get_theme_mod( 'button_padding_y' )}rem;
			padding-bottom: {$this->get_theme_mod( 'button_padding_y' )}rem;
			padding-left: {$this->get_theme_mod( 'button_padding_x' )}rem;
			padding-right: {$this->get_theme_mod( 'button_padding_x' )}rem;
			font-family: {$button_font['font-family']};
			font-size: {$button_font['font-size']};
			font-weight: {$button_font['font-weight']};
		    letter-spacing: {$button_font['letter-spacing']};
		    line-height: {$button_font['line-height']};
		    text-transform: {$button_font['text-transform']};
		    border-radius: {$this->get_theme_mod( 'button_border_radius' )}rem;
		    border-width: {$this->get_theme_mod( 'button_border_width' )}px;
		}
		
		.login #login_error,
		.login .message,
		.login .success {
	        border-radius: calc( {$this->get_theme_mod( 'archive_post_border_radius' )}rem / 3 );
	    }
		
		#login input[type=checkbox]:checked:before {
			color: {$this->get_theme_mod( 'button_primary_background_color' )};
		}
		
		.login #login > h1 {
			background-color: {$this->get_theme_mod( 'button_primary_background_color' )};
		}
		
		.login .button-primary,
		#jetpack-sso-wrap__action .jetpack-sso.button {
			background-color: {$this->get_theme_mod( 'button_primary_background_color' )};
			border-color: {$this->get_theme_mod( 'button_primary_border_color' )};
			color: {$this->get_theme_mod( 'button_primary_color' )};
		}
		
		.login .button-primary:hover,
		.login .button-primary:focus, 
		.login .button-primary:active,
		#jetpack-sso-wrap__action .jetpack-sso.button {
			background-color: {$this->get_theme_mod( 'button_primary_hover_background_color' )};
			border-color: {$this->get_theme_mod( 'button_primary_hover_border_color' )};
			color: {$this->get_theme_mod( 'button_primary_hover_color' )};
		}
		.login:before {
			background-color: {$this->get_theme_mod( 'button_primary_background_color' )};
		}";
		wp_add_inline_style( 'grimlock-login', $styles );
	}

	/**
	 * Add new fonts to fetch from Google Fonts API.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $fonts The array of fonts.
	 *
	 * @return array       The updated array of fonts.
	 */
	public function add_fonts( $fonts ) {
		$fonts[] = $this->get_theme_mod( 'button_font' );
		return $fonts;
	}
}

return new Grimlock_Login_Button_Customizer();
