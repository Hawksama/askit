<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Grimlock_bbPress
 *
 * @author  octopix
 * @since   1.0.0
 * @package grimlock-bbpress/inc
 */
class Grimlock_bbPress {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		load_plugin_textdomain( 'grimlock-bbpress', false, 'grimlock-bbpress/languages' );

		require_once GRIMLOCK_BBPRESS_PLUGIN_DIR_PATH . 'inc/grimlock-bbpress-template-functions.php';
		require_once GRIMLOCK_BBPRESS_PLUGIN_DIR_PATH . 'inc/grimlock-bbpress-template-hooks.php';

		require_once GRIMLOCK_BBPRESS_PLUGIN_DIR_PATH . 'inc/component/class-grimlock-bbpress-forum-component.php';
		require_once GRIMLOCK_BBPRESS_PLUGIN_DIR_PATH . 'inc/component/class-grimlock-bbpress-topic-component.php';
		require_once GRIMLOCK_BBPRESS_PLUGIN_DIR_PATH . 'inc/component/class-grimlock-bbpress-reply-component.php';

		add_action( 'grimlock_query_forum', array( $this, 'query_forum' ), 10, 1 );
		add_action( 'grimlock_query_topic', array( $this, 'query_topic' ), 10, 1 );
		add_action( 'grimlock_query_reply', array( $this, 'query_reply' ), 10, 1 );

		require_once GRIMLOCK_BBPRESS_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-bbpress-button-customizer.php';
		require_once GRIMLOCK_BBPRESS_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-bbpress-pagination-customizer.php';
		require_once GRIMLOCK_BBPRESS_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-bbpress-archive-forum-customizer.php';
		require_once GRIMLOCK_BBPRESS_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-bbpress-single-forum-customizer.php';
		require_once GRIMLOCK_BBPRESS_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-bbpress-archive-topic-customizer.php';
		require_once GRIMLOCK_BBPRESS_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-bbpress-single-topic-customizer.php';
		require_once GRIMLOCK_BBPRESS_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-bbpress-single-reply-customizer.php';
		require_once GRIMLOCK_BBPRESS_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-bbpress-single-view-customizer.php';
		require_once GRIMLOCK_BBPRESS_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-bbpress-single-user-customizer.php';
		require_once GRIMLOCK_BBPRESS_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-bbpress-search-customizer.php';
	}

	/**
	 * Display the forum component.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args
	 */
	public function query_forum( $args = array() ) {
		$component = new Grimlock_bbPress_Forum_Component( apply_filters( 'grimlock_query_forum_args', $args ) );
		$component->render();
	}

	/**
	 * Display the topic component.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args
	 */
	public function query_topic( $args = array() ) {
		$component = new Grimlock_bbPress_Topic_Component( apply_filters( 'grimlock_query_topic_args', $args ) );
		$component->render();
	}

	/**
	 * Display the reply component.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args
	 */
	public function query_reply( $args = array() ) {
		$component = new Grimlock_bbPress_Reply_Component( apply_filters( 'grimlock_query_reply_args', $args ) );
		$component->render();
	}
}
