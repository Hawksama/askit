<?php
/**
 * Grimlock_Login_Customizer Class
 *
 * @author  Themosaurus
 * @since   1.0.3
 * @package grimlock
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The Grimlock Customizer class for the single product.
 */
class Grimlock_Login_Customizer extends Grimlock_Base_Customizer {
	/**
	 * Setup class.
	 *
	 * @since 1.0.3
	 */
	public function __construct() {
		$this->id      = 'login';
		$this->section = 'grimlock_login_customizer_section';
		$this->title   = esc_html__( 'Login', 'grimlock-login' );

		add_action( 'after_setup_theme',                   array( $this, 'add_customizer_fields'                                     ), 20    );

		add_filter( 'body_class',                          array( $this, 'add_body_classes'                                          ), 10, 1 );
		add_filter( 'login_body_class',                    array( $this, 'add_login_body_classes'                                    ), 10, 1 );
		add_filter( 'grimlock_login_navbar_nav_menu_args', array( $this, 'add_navbar_nav_menu_login_register_buttons_displayed_args' ), 10, 1 );
		add_filter( 'grimlock_login_form_modal_args',      array( $this, 'add_navbar_nav_menu_login_register_buttons_displayed_args' ), 10, 1 );

		add_action( 'login_enqueue_scripts',               array( $this, 'add_dynamic_css'                                           ), 20    );
	}

	/**
	 * Register default values, settings and custom controls for the Theme Customizer.
	 *
	 * @since 1.0.3
	 */
	public function add_customizer_fields() {
		$this->defaults = apply_filters( 'grimlock_login_customizer_defaults', array(
			'navbar_nav_menu_login_register_buttons_displayed' => false,
			'login_layout'                                     => 'classic',
			'login_background_image'                           => '',
		) );

		$this->add_section();

		$this->add_navbar_nav_menu_login_register_buttons_displayed_field( array( 'priority' => 10  ) );
		$this->add_layout_field( array( 'priority' => 20 ) );
		$this->add_background_image_field( array( 'priority' => 30 ) );
	}

	/**
	 * Add custom classes to body when the login and register buttons are displayed.
	 *
	 * @param $classes
	 * @since 1.0.3
	 *
	 * @return array
	 */
	public function add_body_classes( $classes ) {
		if ( ! empty( $this->get_theme_mod( 'navbar_nav_menu_login_register_buttons_displayed' ) ) && ! is_user_logged_in() ) {
			$classes[] = 'grimlock--navigation-login-displayed';
		}

		return $classes;
	}

	/**
	 * Add custom classes to the login page body.
	 *
	 * @param $classes
	 * @since 1.0.9
	 *
	 * @return array
	 */
	public function add_login_body_classes( $classes ) {
		$classes[] = "grimlock-login--{$this->get_theme_mod( 'login_layout' )}";

		return $classes;
	}

	/**
	 * Add a Kirki checkbox field to set the login and register buttons display in the Customizer.
	 *
	 * @param array $args
	 * @since 1.0.3
	 */
	public function add_navbar_nav_menu_login_register_buttons_displayed_field( $args = array() ) {
		if ( class_exists( 'Kirki') ) {
			$args = wp_parse_args( $args, array(
				'type'        => 'checkbox',
				'label'       => esc_html__( 'Display login and register buttons in the navbar', 'grimlock-login' ),
				'description' => esc_html__( 'The buttons are only visible for logged out users. Therefore it will not show in the preview.', 'grimlock-login' ),
				'section'     => $this->section,
				'settings'    => 'navbar_nav_menu_login_register_buttons_displayed',
				'default'     => $this->get_default( 'navbar_nav_menu_login_register_buttons_displayed' ),
				'priority'    => 10,
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_login_customizer_navbar_nav_menu_login_register_buttons_displayed_field_args', $args ) );
		}
	}

	/**
	 * Add a Kirki image field to set the background image for the region in the Customizer.
	 *
	 * @param array $args
	 * @since 1.0.9
	 */
	protected function add_background_image_field( $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			$args = wp_parse_args( $args, array(
				'type'     => 'image',
				'section'  => $this->section,
				'label'    => esc_html__( 'Background Image', 'grimlock' ),
				'settings' => 'login_background_image',
				'default'  => $this->get_default( 'login_background_image' ),
				'priority' => 10,
			) );

			Kirki::add_field( 'grimlock', apply_filters( "grimlock_login_customizer_background_image_field_args", $args ) );
		}
	}

	/**
	 * Add a Kirki radio-image field to set the layout in the Customizer.
	 *
	 * @param array $args
	 * @since 1.0.9
	 */
	protected function add_layout_field( $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			$args = wp_parse_args( $args, array(
				'type'     => 'radio-image',
				'section'  => $this->section,
				'label'    => esc_html__( 'Layout', 'grimlock-login' ),
				'settings' => 'login_layout',
				'default'  => $this->get_default( 'login_layout' ),
				'priority' => 10,
				'choices'  => array(
					'classic'          => GRIMLOCK_PLUGIN_DIR_URL . 'assets/images/global-boxed.png',
					'fullscreen-left'  => GRIMLOCK_PLUGIN_DIR_URL . 'assets/images/custom_header-6-6-cols-left-reverse-modern.png',
					'fullscreen-right' => GRIMLOCK_PLUGIN_DIR_URL . 'assets/images/custom_header-6-6-cols-left-modern.png',
				),
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_login_customizer_layout_field_args', $args ) );
		}
	}

	/**
	 * Add arguments using theme mods to display login and register buttons in the navbar and login form modal when clicking the login button
	 *
	 * @since 1.0.3
	 *
	 * @param array $args The default arguments to render the component
	 *
	 * @return array      The arguments to render the component.
	 */
	public function add_navbar_nav_menu_login_register_buttons_displayed_args( $args ) {
		$args['displayed'] = $this->get_theme_mod( 'navbar_nav_menu_login_register_buttons_displayed' );
		return $args;
	}

	/**
	 * Add custom styles based on theme mods.
	 *
	 * @since 1.0.9
	 */
	public function add_dynamic_css() {
		$background_image_url = $this->get_theme_mod( 'login_background_image' );

		if ( ! empty( $background_image_url ) ) {
			$styles = "
			body.login {
				background-image: url('{$background_image_url}');
			}
			body.login:after {
				opacity: 1;
			}
			body.login #login #backtoblog {
				color: #fff !important;
			}
			body.login #login {
				border: 0 !important;
			}
			body.login:before {
				border: 0 !important;
			}
			body.login .privacy-policy-page-link a,
			 body.login .privacy-policy-page-link a:hover {
				color: #fff !important;
			}";
			wp_add_inline_style( 'grimlock-login', $styles );
		}
	}
}

return new Grimlock_Login_Customizer();
