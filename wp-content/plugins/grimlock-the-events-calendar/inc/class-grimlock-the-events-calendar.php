<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Grimlock_The_Events_Calendar
 *
 * @author  themosaurus
 * @since   1.0.0
 * @package grimlock-the-events-calendar
 */
class Grimlock_The_Events_Calendar {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		load_plugin_textdomain( 'grimlock-the-events-calendar', false, 'grimlock-the-events-calendar/languages' );

		require_once GRIMLOCK_THE_EVENTS_CALENDAR_PLUGIN_DIR_PATH . 'inc/grimlock-the-events-calendar-template-functions.php';
		require_once GRIMLOCK_THE_EVENTS_CALENDAR_PLUGIN_DIR_PATH . 'inc/grimlock-the-events-calendar-template-hooks.php';

		require_once GRIMLOCK_THE_EVENTS_CALENDAR_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-the-events-calendar-customizer.php';
		require_once GRIMLOCK_THE_EVENTS_CALENDAR_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-the-events-calendar-single-tribe-events-customizer.php';
		require_once GRIMLOCK_THE_EVENTS_CALENDAR_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-the-events-calendar-single-tribe-venue-customizer.php';
		require_once GRIMLOCK_THE_EVENTS_CALENDAR_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-the-events-calendar-single-tribe-organizer-customizer.php';
		require_once GRIMLOCK_THE_EVENTS_CALENDAR_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-the-events-calendar-button-customizer.php';
		require_once GRIMLOCK_THE_EVENTS_CALENDAR_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-the-events-calendar-pagination-customizer.php';
		require_once GRIMLOCK_THE_EVENTS_CALENDAR_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-the-events-calendar-table-customizer.php';

		// Initialize widgets.
		require_once GRIMLOCK_THE_EVENTS_CALENDAR_PLUGIN_DIR_PATH . 'inc/widget/class-grimlock-the-events-calendar-tribe-events-section-widget.php';
		require_once GRIMLOCK_THE_EVENTS_CALENDAR_PLUGIN_DIR_PATH . 'inc/widget/fields/class-grimlock-the-events-calendar-tribe-events-section-widget-fields.php';

		add_action( 'widgets_init',          array( $this, 'widgets_init'          ), 10 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 10 );

		// Initialize components.
		require_once GRIMLOCK_THE_EVENTS_CALENDAR_PLUGIN_DIR_PATH . 'inc/component/class-grimlock-the-events-calendar-tribe-events-component.php';
		add_action( 'grimlock_query_tribe_events', array( $this, 'query_tribe_events' ), 10, 1 );
	}

	/**
	 * Register the custom widgets.
	 *
	 * @since 1.0.0
	 */
	public function widgets_init() {
		register_widget( 'Grimlock_The_Events_Calendar_Tribe_Events_Section_Widget' );
	}

	/**
	 * Enqueue scripts and stylesheets in admin pages for the widgets.
	 *
	 * @since 1.0.0
	 */
	public function admin_enqueue_scripts() {
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'grimlock-the-events-calendar-widgets', GRIMLOCK_THE_EVENTS_CALENDAR_PLUGIN_DIR_URL . 'assets/js/widgets.js', array( 'jquery', 'jquery-ui-datepicker' ), GRIMLOCK_THE_EVENTS_CALENDAR_VERSION, true );
	}

	/**
	 * Display the event component.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args
	 */
	public function query_tribe_events( $args = array() ) {
		$component = new Grimlock_The_Events_Calendar_Tribe_Events_Component( apply_filters( 'grimlock_query_tribe_events_args', $args ) );
		$component->render();
	}
}
