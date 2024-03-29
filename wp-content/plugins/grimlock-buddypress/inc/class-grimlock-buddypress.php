<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class Grimlock_BuddyPress
 *
 * @author  themoasaurus
 * @since   1.0.0
 * @package grimlock-buddypress/inc
 */
class Grimlock_BuddyPress {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		load_plugin_textdomain( 'grimlock-buddypress', false, 'grimlock-buddypress/languages' );

		add_action( 'bp_init', array( $this, 'register_bp_template_stack' ), 5 );

		add_action( 'after_setup_theme', array( $this, 'register_navbar_nav_menus' ), 10 );

		require_once GRIMLOCK_BUDDYPRESS_PLUGIN_DIR_PATH . 'inc/component/class-grimlock-buddypress-groups-section-component.php';
		require_once GRIMLOCK_BUDDYPRESS_PLUGIN_DIR_PATH . 'inc/component/class-grimlock-buddypress-navbar-nav-menu-component.php';

		add_action( 'grimlock_buddypress_groups_section',  array( $this, 'groups_section'              ), 10,  1 );
		add_action( 'grimlock_buddypress_navbar_nav_menu', array( $this, 'navbar_nav_menu'             ), 10,  1 );
		add_action( 'grimlock_navbar_nav_menu',            array( $this, 'add_navbar_nav_menu'         ), 110, 1 );
		add_action( 'grimlock_vertical_navbar_nav_menu',   array( $this, 'add_navbar_nav_menu'         ), 10,  1 );
		add_action( 'grimlock_hamburger_navbar_nav_menu',  array( $this, 'add_navbar_nav_menu'         ), 10,  1 );
		add_filter( 'grimlock_custom_header_displayed',    array( $this, 'has_custom_header_displayed' ), 10,  1 );

		require_once GRIMLOCK_BUDDYPRESS_PLUGIN_DIR_PATH . 'inc/widget/class-grimlock-buddypress-groups-section-widget.php';
		require_once GRIMLOCK_BUDDYPRESS_PLUGIN_DIR_PATH . 'inc/widget/fields/class-grimlock-buddypress-groups-section-widget-fields.php';

		add_action( 'widgets_init', array( $this, 'widgets_init' ), 10 );

		require_once GRIMLOCK_BUDDYPRESS_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-buddypress-customizer.php';
		require_once GRIMLOCK_BUDDYPRESS_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-buddypress-archive-customizer.php';
		require_once GRIMLOCK_BUDDYPRESS_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-buddypress-global-customizer.php';
		require_once GRIMLOCK_BUDDYPRESS_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-buddypress-navigation-customizer.php';
		require_once GRIMLOCK_BUDDYPRESS_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-buddypress-search-customizer.php';
		require_once GRIMLOCK_BUDDYPRESS_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-buddypress-table-customizer.php';
		require_once GRIMLOCK_BUDDYPRESS_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-buddypress-typography-customizer.php';
		require_once GRIMLOCK_BUDDYPRESS_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-buddypress-button-customizer.php';
		require_once GRIMLOCK_BUDDYPRESS_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-buddypress-control-customizer.php';
		require_once GRIMLOCK_BUDDYPRESS_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-buddypress-pagination-customizer.php';

		add_filter( 'theme_mod_navigation_position', array( $this, 'force_navigation_position' ), 10 );
		add_action( 'wp_enqueue_scripts',            array( $this, 'enqueue_scripts'           ), 10 );
		add_action( 'after_setup_theme',             array( $this, 'setup'                     ), 10 );
		add_filter( 'bp_get_theme_package_id',       array( $this, 'bp_get_theme_package_id'   ), 10 );
	}

	/**
	 * Register a new template location in the BuddyPress template stack
	 */
	public function register_bp_template_stack() {
		bp_register_template_stack( 'get_template_directory' );
		bp_register_template_stack( array( $this, 'get_bp_templates_location' ) );
	}

	/**
	 * Get the BuddyPress template location in the plugin
	 *
	 * @return string
	 */
	public function get_bp_templates_location() {
		return GRIMLOCK_BUDDYPRESS_PLUGIN_DIR_PATH . 'templates/';
	}

	/**
	 * Check if the custom header is displayed or not.
	 *
	 * @since 1.0.5
	 *
	 * @return bool True if the custom header is displayed, false otherwise.
	 */
	public function has_custom_header_displayed( $default ) {
		return ! ( function_exists( 'is_buddypress' ) && is_buddypress() ) && $default;
	}

	/**
	 * Register nav menus for the Grimlock Navbar component.
	 *
	 * @since 1.0.0
	 */
	public function register_navbar_nav_menus() {
		register_nav_menus( apply_filters( 'grimlock_buddypress_nav_menus', array(
			'user_logged_in'  => esc_html__( 'Logged In Users', 'grimlock-buddypress' ),
			'user_logged_out' => esc_html__( 'Logged Out Users', 'grimlock-buddypress' ),
		) ) );
	}

	/**
	 * Add BuddyPress navbar cart for the Grimlock Navbar.
	 *
	 * @since 1.0.0
	 *
	 * @param $args
	 */
	public function add_navbar_nav_menu( $args ) {
		$class = isset( $args['menu_class'] ) ? str_replace( 'main-menu', 'profile', $args['menu_class'] ) : '';
		do_action( 'grimlock_buddypress_navbar_nav_menu', array(
			'class' => $class,
		) );
	}

	/**
	 * Display the Grimlock BuddyPress Cart Component for the Navbar.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args
	 */
	public function navbar_nav_menu( $args = array() ) {
		$args      = apply_filters( 'grimlock_buddypress_navbar_nav_menu_args', wp_parse_args( $args, array(
			'id' => 'buddypress-navbar_nav_menu',
		) ) );
		$component = new Grimlock_BuddyPress_Navbar_Nav_Menu_Component( $args );
		$component->render();
	}

	/**
	 * Display the Grimlock BuddyPress Groups Section Component for the Widget.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args
	 */
	public function groups_section( $args = array() ) {
		$component = new Grimlock_BuddyPress_Groups_Section_Component( apply_filters( 'grimlock_buddypress_groups_section_args', $args ) );
		$component->render();
	}

	/**
	 * Register the custom widgets.
	 *
	 * @since 1.0.0
	 */
	public function widgets_init() {
		$sidebar_args = apply_filters( 'grimlock_buddypress_sidebar_args', array(
			'id'            => 'bp-sidebar',
			'name'          => esc_html__( 'BuddyPress', 'grimlock-buddypress' ),
			'description'   => esc_html__( 'The right hand area for BuddyPress pages.', 'grimlock-buddypress' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

		register_sidebar( $sidebar_args );

		register_widget( 'Grimlock_BuddyPress_Groups_Section_Widget' );
	}

	/**
	 * Force the navigation position on BuddyPress pages.
	 *
	 * @param  string $position The navigation position.
	 *
	 * @return string           The updated navigation position.
	 */
	public function force_navigation_position( $position ) {
		if ( is_buddypress() ) {
			return 'classic-top';
		}
		return $position;
	}

	/**
	 * Enqueue scripts
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_style( 'grimlock-buddypress', GRIMLOCK_BUDDYPRESS_PLUGIN_DIR_URL . 'assets/css/style.css', array(), GRIMLOCK_BUDDYPRESS_VERSION );

		wp_enqueue_script( 'jquery-effects-drop' );
		wp_enqueue_script( 'hammerjs', GRIMLOCK_BUDDYPRESS_PLUGIN_DIR_URL . 'assets/js/vendor/hammer.min.js', array(), '2.0.7', true );
		wp_enqueue_style( 'priority-nav', GRIMLOCK_BUDDYPRESS_PLUGIN_DIR_URL . 'assets/css/vendor/priority-nav-core.css', array(), '1.0.12' );
		wp_enqueue_script( 'priority-nav', GRIMLOCK_BUDDYPRESS_PLUGIN_DIR_URL . 'assets/js/vendor/priority-nav.min.js', array(), '1.0.12', true );

		wp_enqueue_script( 'grimlock-buddypress', GRIMLOCK_BUDDYPRESS_PLUGIN_DIR_URL . 'assets/js/main.js', array( 'jquery', 'priority-nav', 'jquery-effects-drop', 'hammerjs' ), GRIMLOCK_BUDDYPRESS_VERSION, true );
		wp_localize_script( 'grimlock-buddypress', 'grimlock_buddypress', array(
			'priority_nav_dropdown_label'            => esc_html_x( 'More', 'bp_profile_menu_label', 'grimlock-buddypress' ),
			'priority_nav_dropdown_breakpoint_label' => esc_html_x( 'Menu', 'bp_profile_menu_mobile_label', 'grimlock-buddypress' ),
			'ajax_url'                               => admin_url( 'admin-ajax.php' ),
		) );
	}

	/**
	 * BuddyPress setup function.
	 *
	 * @since 1.0.0
	 */
	public function setup() {
		// Add theme support for BuddyPress Legacy template pack.
		add_theme_support( 'buddypress-use-legacy' );
	}

	/**
	 * Use theme support values to get current bp package id if they are defined
	 *
	 * @param string $package_id The current package id
	 *
	 * @return string The bp package id
	 */
	public function bp_get_theme_package_id( $package_id ) {
		if ( current_theme_supports( 'buddypress-use-legacy' ) ) {
			return 'legacy';
		}
		elseif ( current_theme_supports( 'buddypress-use-nouveau' ) ) {
			return 'nouveau';
		}

		return $package_id;
	}
}
