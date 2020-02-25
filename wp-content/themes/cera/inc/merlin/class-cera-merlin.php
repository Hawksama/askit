<?php
/**
 * Cera_Merlin Class
 *
 * @author  Themosaurus
 * @since   1.0.0
 * @package cera
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Cera_Merlin' ) ) :
	/**
	 * The Cera Merlin Activation class
	 */
	class Cera_Merlin {

		/**
		 * Setup class.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			if ( is_admin() && class_exists( 'TGM_Plugin_Activation' ) && isset( $_GET['demo'] ) ) {
				add_filter( 'cera_tgm_plugin_activation_register_plugins', array( $this, 'add_tgmpa_demo_plugins' ) );
				add_filter( 'import_start',                                array( $this, 'import_start'           ) );
			}

			$theme = wp_get_theme();

			add_filter( 'merlin_import_files', array( $this, 'merlin_import_files' ) );
			add_action( 'merlin_after_all_import', array( $this, 'merlin_after_import_setup' ) );
			add_filter( "{$theme->template}_merlin_steps", array( $this, 'change_merlin_steps' ) );

			// Prevent WooCommerce from messing with the plugins installation step
			add_filter( 'woocommerce_prevent_automatic_wizard_redirect', '__return_true' );

			// Prevent Elementor from messing with the plugins installation step
			add_action( 'init', array( $this, 'prevent_elementor_redirect' ) );

			$this->init();
		}

		/**
		 * Get the demo setups arguments that will be sent to Merlin WP
		 *
		 * @return array
		 */
		private function get_demo_setups_args() {
			return apply_filters( 'cera_demo_setups_args', array(
				'intranet'      => array(
					'import_file_name'           => 'Cera Intranet Demo',
					'import_file_url'            => 'https://files.themosaurus.com/cera/demos/intranet/demo-content.xml',
					'import_widget_file_url'     => 'https://files.themosaurus.com/cera/demos/intranet/widgets.wie',
					'import_customizer_file_url' => 'https://files.themosaurus.com/cera/demos/intranet/customizer.dat',
					'import_file_screenshot'     => get_template_directory_uri() . '/assets/images/screenshots/intranet.jpg',
					'import_notice'              => esc_html__( 'Visit doc.themosaurus.com to get the full documentation for the theme', 'cera' ),
					'preview_url'                => 'http://intranet.cera-theme.com/',
					'tgmpa'                      => array(
						array(
							'name'     => 'Author Avatars List',
							'slug'     => 'author-avatars',
							'required' => false,
						),
						array(
							'name'     => 'bbP Topic Count',
							'slug'     => 'bbp-topic-count',
							'required' => false,
						),
						array(
							'name'     => 'bbPress',
							'slug'     => 'bbpress',
							'required' => false,
						),
						array(
							'name'     => 'BP Better Messages',
							'slug'     => 'bp-better-messages',
							'required' => false,
						),
						array(
							'name'     => 'BP Birthday Greetings',
							'slug'     => 'bp-birthday-greetings',
							'required' => false,
						),
						array(
							'name'     => 'BP Profile Search',
							'slug'     => 'bp-profile-search',
							'required' => false,
						),
						array(
							'name'     => 'BuddyPress',
							'slug'     => 'buddypress',
							'required' => true,
						),
						array(
							'name'     => 'BuddyPress Docs',
							'slug'     => 'buddypress-docs',
							'required' => false,
						),
						array(
							'name'     => 'BuddyPress Global Search',
							'slug'     => 'buddypress-global-search',
							'required' => false,
						),
						array(
							'name'     => 'BuddyPress Notifications Widget',
							'slug'     => 'buddypress-notifications-widget',
							'required' => false,
						),
						array(
							'name'     => 'CoBlocks',
							'slug'     => 'coblocks',
							'required' => false,
						),
						array(
							'name'     => 'JetPack',
							'slug'     => 'jetpack',
							'required' => false,
						),
						array(
							'name'     => 'Menu Image',
							'slug'     => 'menu-image',
							'required' => false,
						),
						array(
							'name'     => 'Paid Memberships Pro',
							'slug'     => 'paid-memberships-pro',
							'required' => false,
						),
						array(
							'name'     => 'Paid Memberships Pro - BuddyPress Add On',
							'slug'     => 'pmpro-buddypress',
							'required' => false,
						),
						array(
							'name'     => 'rtMedia for WordPress, BuddyPress and bbPress',
							'slug'     => 'buddypress-media',
							'required' => false,
						),
						array(
							'name'     => 'Social Articles',
							'slug'     => 'social-articles',
							'required' => false,
						),
						array(
							'name'     => 'The Events Calendar',
							'slug'     => 'the-events-calendar',
							'required' => false,
						),
						array(
							'name'     => 'WordPress Popular Posts',
							'slug'     => 'wordpress-popular-posts',
							'required' => false,
						),
						array(
							'name'     => 'Yoast SEO',
							'slug'     => 'wordpress-seo',
							'required' => false,
						),
						array(
							'name'         => 'Grimlock for Author Avatars List',
							'slug'         => 'grimlock-author-avatars',
							'source'       => 'http://files.themosaurus.com/grimlock-author-avatars/grimlock-author-avatars.zip',
							'required'     => false,
							'external_url' => 'https://www.themosaurus.com/',
						),
						array(
							'name'         => 'Grimlock for bbPress',
							'slug'         => 'grimlock-bbpress',
							'source'       => 'http://files.themosaurus.com/grimlock-bbpress/grimlock-bbpress.zip',
							'required'     => false,
							'external_url' => 'https://www.themosaurus.com/',
						),
						array(
							'name'         => 'Grimlock for BuddyPress',
							'slug'         => 'grimlock-buddypress',
							'source'       => 'http://files.themosaurus.com/grimlock-buddypress/grimlock-buddypress.zip',
							'required'     => true,
							'external_url' => 'https://www.themosaurus.com/',
						),
						array(
							'name'         => 'Grimlock for Jetpack',
							'slug'         => 'grimlock-jetpack',
							'source'       => 'http://files.themosaurus.com/grimlock-jetpack/grimlock-jetpack.zip',
							'required'     => false,
							'external_url' => 'https://www.themosaurus.com/',
						),
						array(
							'name'         => 'Grimlock for The Events Calendar',
							'slug'         => 'grimlock-the-events-calendar',
							'source'       => 'http://files.themosaurus.com/grimlock-the-events-calendar/grimlock-the-events-calendar.zip',
							'required'     => false,
							'external_url' => 'https://www.themosaurus.com/',
						),
						array(
							'name'         => 'Grimlock for Yoast SEO',
							'slug'         => 'grimlock-wordpress-seo',
							'source'       => 'http://files.themosaurus.com/grimlock-wordpress-seo/grimlock-wordpress-seo.zip',
							'required'     => false,
							'external_url' => 'https://www.themosaurus.com/',
						),
						array(
							'name'         => 'Grimlock Isotope',
							'slug'         => 'grimlock-isotope',
							'source'       => 'http://files.themosaurus.com/grimlock-isotope/grimlock-isotope.zip',
							'required'     => false,
							'external_url' => 'https://www.themosaurus.com/',
						),
					),
				),
				'intranet_dark' => array(
					'import_file_name'           => 'Cera Intranet Dark Demo',
					'import_file_url'            => 'https://files.themosaurus.com/cera/demos/intranet-dark/demo-content.xml',
					'import_widget_file_url'     => 'https://files.themosaurus.com/cera/demos/intranet-dark/widgets.wie',
					'import_customizer_file_url' => 'https://files.themosaurus.com/cera/demos/intranet-dark/customizer.dat',
					'import_file_screenshot'     => get_template_directory_uri() . '/assets/images/screenshots/intranet-dark.jpg',
					'import_notice'              => esc_html__( 'Visit doc.themosaurus.com to get the full documentation for the theme', 'cera' ),
					'preview_url'                => 'http://intranet.cera-theme.com/',
					'tgmpa'                      => array(
						array(
							'name'     => 'Author Avatars List',
							'slug'     => 'author-avatars',
							'required' => false,
						),
						array(
							'name'     => 'bbP Topic Count',
							'slug'     => 'bbp-topic-count',
							'required' => false,
						),
						array(
							'name'     => 'bbPress',
							'slug'     => 'bbpress',
							'required' => false,
						),
						array(
							'name'     => 'BP Better Messages',
							'slug'     => 'bp-better-messages',
							'required' => false,
						),
						array(
							'name'     => 'BP Birthday Greetings',
							'slug'     => 'bp-birthday-greetings',
							'required' => false,
						),
						array(
							'name'     => 'BP Profile Search',
							'slug'     => 'bp-profile-search',
							'required' => false,
						),
						array(
							'name'     => 'BuddyPress',
							'slug'     => 'buddypress',
							'required' => true,
						),
						array(
							'name'     => 'BuddyPress Docs',
							'slug'     => 'buddypress-docs',
							'required' => false,
						),
						array(
							'name'     => 'BuddyPress Global Search',
							'slug'     => 'buddypress-global-search',
							'required' => false,
						),
						array(
							'name'     => 'BuddyPress Notifications Widget',
							'slug'     => 'buddypress-notifications-widget',
							'required' => false,
						),
						array(
							'name'     => 'CoBlocks',
							'slug'     => 'coblocks',
							'required' => false,
						),
						array(
							'name'     => 'JetPack',
							'slug'     => 'jetpack',
							'required' => false,
						),
						array(
							'name'     => 'Menu Image',
							'slug'     => 'menu-image',
							'required' => false,
						),
						array(
							'name'     => 'Paid Memberships Pro',
							'slug'     => 'paid-memberships-pro',
							'required' => false,
						),
						array(
							'name'     => 'Paid Memberships Pro - BuddyPress Add On',
							'slug'     => 'pmpro-buddypress',
							'required' => false,
						),
						array(
							'name'     => 'rtMedia for WordPress, BuddyPress and bbPress',
							'slug'     => 'buddypress-media',
							'required' => false,
						),
						array(
							'name'     => 'Social Articles',
							'slug'     => 'social-articles',
							'required' => false,
						),
						array(
							'name'     => 'The Events Calendar',
							'slug'     => 'the-events-calendar',
							'required' => false,
						),
						array(
							'name'     => 'WordPress Popular Posts',
							'slug'     => 'wordpress-popular-posts',
							'required' => false,
						),
						array(
							'name'     => 'Yoast SEO',
							'slug'     => 'wordpress-seo',
							'required' => false,
						),
						array(
							'name'         => 'Grimlock for Author Avatars List',
							'slug'         => 'grimlock-author-avatars',
							'source'       => 'http://files.themosaurus.com/grimlock-author-avatars/grimlock-author-avatars.zip',
							'required'     => false,
							'external_url' => 'https://www.themosaurus.com/',
						),
						array(
							'name'         => 'Grimlock for bbPress',
							'slug'         => 'grimlock-bbpress',
							'source'       => 'http://files.themosaurus.com/grimlock-bbpress/grimlock-bbpress.zip',
							'required'     => false,
							'external_url' => 'https://www.themosaurus.com/',
						),
						array(
							'name'         => 'Grimlock for BuddyPress',
							'slug'         => 'grimlock-buddypress',
							'source'       => 'http://files.themosaurus.com/grimlock-buddypress/grimlock-buddypress.zip',
							'required'     => true,
							'external_url' => 'https://www.themosaurus.com/',
						),
						array(
							'name'         => 'Grimlock for Jetpack',
							'slug'         => 'grimlock-jetpack',
							'source'       => 'http://files.themosaurus.com/grimlock-jetpack/grimlock-jetpack.zip',
							'required'     => false,
							'external_url' => 'https://www.themosaurus.com/',
						),
						array(
							'name'         => 'Grimlock for The Events Calendar',
							'slug'         => 'grimlock-the-events-calendar',
							'source'       => 'http://files.themosaurus.com/grimlock-the-events-calendar/grimlock-the-events-calendar.zip',
							'required'     => false,
							'external_url' => 'https://www.themosaurus.com/',
						),
						array(
							'name'         => 'Grimlock for Yoast SEO',
							'slug'         => 'grimlock-wordpress-seo',
							'source'       => 'http://files.themosaurus.com/grimlock-wordpress-seo/grimlock-wordpress-seo.zip',
							'required'     => false,
							'external_url' => 'https://www.themosaurus.com/',
						),
						array(
							'name'         => 'Grimlock Isotope',
							'slug'         => 'grimlock-isotope',
							'source'       => 'http://files.themosaurus.com/grimlock-isotope/grimlock-isotope.zip',
							'required'     => false,
							'external_url' => 'https://www.themosaurus.com/',
						),
					),
				),
				'youzer'        => array(
					'import_file_name'           => 'Cera Youzer Demo',
					/* translators: 1: Opening <a> tag 2: Closing <a> tag 3: Opening <strong> tag 4: Closing <strong> tag */
					'import_file_warning'        => '<strong>' . esc_html__( 'Heads up!', 'gwangi' ) . '</strong><p>' . sprintf( esc_html__( 'This demo is based on the %1$sYouzer%2$s plugin. This is a paid plugin and it is not included with Gwangi. We recommend that you manually install it %3$safter%4$s importing this demo.', 'gwangi' ), '<a target="_blank" href="https://youzer.kainelabs.com/">', '</a>', '<strong>', '</strong>' ) . '</p>',
					'import_file_url'            => 'https://files.themosaurus.com/cera/demos/youzer/demo-content.xml',
					'import_widget_file_url'     => 'https://files.themosaurus.com/cera/demos/youzer/widgets.wie',
					'import_customizer_file_url' => 'https://files.themosaurus.com/cera/demos/youzer/customizer.dat',
					'import_file_screenshot'     => get_template_directory_uri() . '/assets/images/screenshots/youzer.jpg',
					'import_notice'              => esc_html__( 'Visit doc.themosaurus.com to get the full documentation for the theme', 'cera' ),
					'import_finished_warning'    => '<strong>' . esc_html__( 'Heads up!', 'cera' ) . '</strong><p>' . sprintf( esc_html__( 'To complete this demo setup, don\'t forget to install the %1$sYouzer%2$s plugin.', 'cera' ), '<a href="https://youzer.kainelabs.com/" target="_blank">', '</a>' ) . '</p>',
					'preview_url'                => 'http://youzer.cera-theme.com/',
					'tgmpa'                      => array(
						array(
							'name'     => 'Author Avatars List',
							'slug'     => 'author-avatars',
							'required' => false,
						),
						array(
							'name'     => 'bbP Topic Count',
							'slug'     => 'bbp-topic-count',
							'required' => false,
						),
						array(
							'name'     => 'bbPress',
							'slug'     => 'bbpress',
							'required' => false,
						),
						array(
							'name'     => 'BP Better Messages',
							'slug'     => 'bp-better-messages',
							'required' => false,
						),
						array(
							'name'     => 'BP Birthday Greetings',
							'slug'     => 'bp-birthday-greetings',
							'required' => false,
						),
						array(
							'name'     => 'BP Profile Search',
							'slug'     => 'bp-profile-search',
							'required' => false,
						),
						array(
							'name'     => 'BuddyPress',
							'slug'     => 'buddypress',
							'required' => true,
						),
						array(
							'name'     => 'BuddyPress Global Search',
							'slug'     => 'buddypress-global-search',
							'required' => false,
						),
						array(
							'name'     => 'BuddyPress Notifications Widget',
							'slug'     => 'buddypress-notifications-widget',
							'required' => false,
						),
						array(
							'name'     => 'CoBlocks',
							'slug'     => 'coblocks',
							'required' => false,
						),
						array(
							'name'     => 'JetPack',
							'slug'     => 'jetpack',
							'required' => false,
						),
						array(
							'name'     => 'Menu Image',
							'slug'     => 'menu-image',
							'required' => false,
						),
						array(
							'name'     => 'Paid Memberships Pro',
							'slug'     => 'paid-memberships-pro',
							'required' => false,
						),
						array(
							'name'     => 'Paid Memberships Pro - BuddyPress Add On',
							'slug'     => 'pmpro-buddypress',
							'required' => false,
						),
						array(
							'name'     => 'WordPress Popular Posts',
							'slug'     => 'wordpress-popular-posts',
							'required' => false,
						),
						array(
							'name'     => 'Yoast SEO',
							'slug'     => 'wordpress-seo',
							'required' => false,
						),
						array(
							'name'         => 'Grimlock for Author Avatars List',
							'slug'         => 'grimlock-author-avatars',
							'source'       => 'http://files.themosaurus.com/grimlock-author-avatars/grimlock-author-avatars.zip',
							'required'     => false,
							'external_url' => 'https://www.themosaurus.com/',
						),
						array(
							'name'         => 'Grimlock for bbPress',
							'slug'         => 'grimlock-bbpress',
							'source'       => 'http://files.themosaurus.com/grimlock-bbpress/grimlock-bbpress.zip',
							'required'     => false,
							'external_url' => 'https://www.themosaurus.com/',
						),
						array(
							'name'         => 'Grimlock for BuddyPress',
							'slug'         => 'grimlock-buddypress',
							'source'       => 'http://files.themosaurus.com/grimlock-buddypress/grimlock-buddypress.zip',
							'required'     => true,
							'external_url' => 'https://www.themosaurus.com/',
						),
						array(
							'name'         => 'Grimlock for Jetpack',
							'slug'         => 'grimlock-jetpack',
							'source'       => 'http://files.themosaurus.com/grimlock-jetpack/grimlock-jetpack.zip',
							'required'     => false,
							'external_url' => 'https://www.themosaurus.com/',
						),
						array(
							'name'         => 'Grimlock for Yoast SEO',
							'slug'         => 'grimlock-wordpress-seo',
							'source'       => 'http://files.themosaurus.com/grimlock-wordpress-seo/grimlock-wordpress-seo.zip',
							'required'     => false,
							'external_url' => 'https://www.themosaurus.com/',
						),
						array(
							'name'         => 'Grimlock Isotope',
							'slug'         => 'grimlock-isotope',
							'source'       => 'http://files.themosaurus.com/grimlock-isotope/grimlock-isotope.zip',
							'required'     => false,
							'external_url' => 'https://www.themosaurus.com/',
						),
						array(
							'name'         => 'Grimlock Hero',
							'slug'         => 'grimlock-hero',
							'source'       => 'http://files.themosaurus.com/grimlock-hero/grimlock-hero.zip',
							'required'     => false,
							'external_url' => 'https://www.themosaurus.com/',
						),
					),
				),
				'learn'         => array(
					'import_file_name'           => 'Cera Learn Demo',
					/* translators: 1: Opening <a> tag 2: Closing <a> tag 3: Opening <strong> tag 4: Closing <strong> tag */
					'import_file_warning'        => '<strong>' . esc_html__( 'Heads up!', 'gwangi' ) . '</strong><p>' . sprintf( esc_html__( 'This demo is based on the %1$sLearnDash%2$s plugin. This is a paid plugin and it is not included with Gwangi. We recommend that you manually install it %3$sbefore%4$s importing this demo.', 'gwangi' ), '<a target="_blank" href="https://www.learndash.com/">', '</a>', '<strong>', '</strong>' ) . '</p>',
					'import_file_url'            => 'https://files.themosaurus.com/cera/demos/learn/demo-content.xml',
					'import_widget_file_url'     => 'https://files.themosaurus.com/cera/demos/learn/widgets.wie',
					'import_customizer_file_url' => 'https://files.themosaurus.com/cera/demos/learn/customizer.dat',
					'import_file_screenshot'     => get_template_directory_uri() . '/assets/images/screenshots/learn.jpg',
					'import_notice'              => esc_html__( 'Visit doc.themosaurus.com to get the full documentation for the theme', 'cera' ),
					'import_finished_warning'    => '<strong>' . esc_html__( 'Heads up!', 'gwangi' ) . '</strong><p>' . sprintf( esc_html__( 'To complete this demo setup, don\'t forget to install the %1$sLearnDash%2$s plugin if you haven\'t already.', 'gwangi' ), '<a href="https://www.learndash.com/" target="_blank">', '</a>' ) . '</p>',
					'preview_url'                => 'http://learn.cera-theme.com/',
					'tgmpa'                      => array(
						array(
							'name'     => 'Author Avatars List',
							'slug'     => 'author-avatars',
							'required' => false,
						),
						array(
							'name'     => 'bbP Topic Count',
							'slug'     => 'bbp-topic-count',
							'required' => false,
						),
						array(
							'name'     => 'bbPress',
							'slug'     => 'bbpress',
							'required' => false,
						),
						array(
							'name'     => 'BP Better Messages',
							'slug'     => 'bp-better-messages',
							'required' => false,
						),
						array(
							'name'     => 'BP Profile Search',
							'slug'     => 'bp-profile-search',
							'required' => false,
						),
						array(
							'name'     => 'BuddyPress',
							'slug'     => 'buddypress',
							'required' => true,
						),
						array(
							'name'     => 'BuddyPress Docs',
							'slug'     => 'buddypress-docs',
							'required' => false,
						),
						array(
							'name'     => 'BuddyPress for LearnDash',
							'slug'     => 'buddypress-learndash',
							'required' => false,
						),
						array(
							'name'     => 'BuddyPress Global Search',
							'slug'     => 'buddypress-global-search',
							'required' => false,
						),
						array(
							'name'     => 'BuddyPress Notifications Widget',
							'slug'     => 'buddypress-notifications-widget',
							'required' => false,
						),
						array(
							'name'     => 'CoBlocks',
							'slug'     => 'coblocks',
							'required' => false,
						),
						array(
							'name'     => 'JetPack',
							'slug'     => 'jetpack',
							'required' => false,
						),
						array(
							'name'     => 'Menu Image',
							'slug'     => 'menu-image',
							'required' => false,
						),
						array(
							'name'     => 'Paid Memberships Pro',
							'slug'     => 'paid-memberships-pro',
							'required' => false,
						),
						array(
							'name'     => 'Paid Memberships Pro - BuddyPress Add On',
							'slug'     => 'pmpro-buddypress',
							'required' => false,
						),
						array(
							'name'     => 'rtMedia for WordPress, BuddyPress and bbPress',
							'slug'     => 'buddypress-media',
							'required' => false,
						),
						array(
							'name'     => 'WordPress Popular Posts',
							'slug'     => 'wordpress-popular-posts',
							'required' => false,
						),
						array(
							'name'     => 'Yoast SEO',
							'slug'     => 'wordpress-seo',
							'required' => false,
						),
						array(
							'name'         => 'Grimlock for Author Avatars List',
							'slug'         => 'grimlock-author-avatars',
							'source'       => 'http://files.themosaurus.com/grimlock-author-avatars/grimlock-author-avatars.zip',
							'required'     => false,
							'external_url' => 'https://www.themosaurus.com/',
						),
						array(
							'name'         => 'Grimlock for bbPress',
							'slug'         => 'grimlock-bbpress',
							'source'       => 'http://files.themosaurus.com/grimlock-bbpress/grimlock-bbpress.zip',
							'required'     => false,
							'external_url' => 'https://www.themosaurus.com/',
						),
						array(
							'name'         => 'Grimlock for BuddyPress',
							'slug'         => 'grimlock-buddypress',
							'source'       => 'http://files.themosaurus.com/grimlock-buddypress/grimlock-buddypress.zip',
							'required'     => true,
							'external_url' => 'https://www.themosaurus.com/',
						),
						array(
							'name'         => 'Grimlock for Jetpack',
							'slug'         => 'grimlock-jetpack',
							'source'       => 'http://files.themosaurus.com/grimlock-jetpack/grimlock-jetpack.zip',
							'required'     => false,
							'external_url' => 'https://www.themosaurus.com/',
						),
						array(
							'name'         => 'Grimlock for Yoast SEO',
							'slug'         => 'grimlock-wordpress-seo',
							'source'       => 'http://files.themosaurus.com/grimlock-wordpress-seo/grimlock-wordpress-seo.zip',
							'required'     => false,
							'external_url' => 'https://www.themosaurus.com/',
						),
						array(
							'name'         => 'Grimlock Isotope',
							'slug'         => 'grimlock-isotope',
							'source'       => 'http://files.themosaurus.com/grimlock-isotope/grimlock-isotope.zip',
							'required'     => false,
							'external_url' => 'https://www.themosaurus.com/',
						),
					),
				),
			) );
		}

		/**
		 * Dynamically add plugins to TGMPA depending on the selected demo during import
		 *
		 * @param $plugins
		 *
		 * @return array
		 */
		public function add_tgmpa_demo_plugins( $plugins ) {
			$demo_setups = array_values( $this->get_demo_setups_args() ); // Turn into non-associative to make sure we have the same indexes as Merlin's import_files property
			if ( ! empty( $demo_setups[ $_GET['demo'] ] ) ) {
				if ( ! empty( $demo_setups[ $_GET['demo'] ]['tgmpa'] ) ) {
					$plugins = array_merge( $plugins, $demo_setups[ $_GET['demo'] ]['tgmpa'] );
				}

				if ( ! empty( $_GET['use-elementor'] ) ) {
					$plugins[] = array(
						'name'     => 'Elementor',
						'slug'     => 'elementor',
						'required' => true,
					);
					$plugins[] = array(
						'name'     => 'Grimlock for Elementor',
						'slug'     => 'grimlock-elementor',
						'required' => true,
					);
				}
			}

			return $plugins;
		}

		public function import_start() {
			$this->activate_bp_components();

			// Update the permalink structure
			update_option( 'permalink_structure', '/%postname%/' );
			flush_rewrite_rules();
		}

		/**
		 * Setup demo import files list for Merlin
		 *
		 * @param $args
		 *
		 * @return array
		 */
		public function merlin_import_files( $args ) {
			return array_merge( $args, $this->get_demo_setups_args() );
		}

		/**
		 * Process adjustments after demo import
		 */
		public function merlin_after_import_setup() {
			// Process demo specific adjustments
			if ( isset( $_GET['demo'] ) ) {
				if ( ! empty( $_GET['use-elementor'] ) ) {
					$this->setup_elementor();
				}

				switch ( $_GET['demo'] ) {
					case 0: // Intranet demo
					case 1: // Intranet Dark demo
						$this->after_import_intranet();
						break;
					case 2: // Youzer demo
						$this->after_import_youzer();
						break;
					case 3: // Learn demo
						$this->after_import_learn();
						break;
				}
			}

			flush_rewrite_rules();
		}

		/**
		 * After import logic for the Intranet demo
		 */
		public function after_import_intranet() {
			$dashboard_page = get_page_by_title( 'Dashboard' );
			$news_page      = get_page_by_title( 'News' );

			update_option( 'show_on_front', 'page' );
			if ( ! empty( $dashboard_page ) ) {
				update_option( 'page_on_front', $dashboard_page->ID );
			}
			if ( ! empty( $news_page ) ) {
				update_option( 'page_for_posts', $news_page->ID );
			}

			$this->delete_duplicate_pages();

			$primary_menu    = get_term_by( 'name', 'Primary', 'nav_menu' );
			$logged_in_menu  = get_term_by( 'name', 'User - Logged In', 'nav_menu' );
			$logged_out_menu = get_term_by( 'name', 'User - Logged Out', 'nav_menu' );
			$features_menu   = get_term_by( 'name', 'Features', 'nav_menu' );
			$footer_menu     = get_term_by( 'name', 'Footer', 'nav_menu' );

			$primary_menu_items   = wp_get_nav_menu_items( $primary_menu );
			$logged_in_menu_items = wp_get_nav_menu_items( $logged_in_menu );
			$features_menu_items  = wp_get_nav_menu_items( $features_menu );
			$footer_menu_items    = wp_get_nav_menu_items( $footer_menu );

			// Assign menus to their locations.
			set_theme_mod(
				'nav_menu_locations', array(
					'primary'         => $primary_menu->term_id,
					'user_logged_in'  => $logged_in_menu->term_id,
					'user_logged_out' => $logged_out_menu->term_id,
				)
			);

			$primary_menu_icons_class = $_GET['demo'] === 1 ? 'cera-icon' : 'cera-icon text-primary';

			// Adjust Primary menu items
			foreach ( $primary_menu_items as $menu_item ) {
				switch ( $menu_item->title ) {
					case 'Dashboard':
						$menu_item->title = '<i class="' . $primary_menu_icons_class . ' cera-grid"></i> <span>Dashboard</span>';
						break;
					case 'Homepage':
						$menu_item->title = '<i class="' . $primary_menu_icons_class . ' cera-layout"></i> <span>Homepage</span>';
						break;
					case 'Social wall':
						$menu_item->title = '<i class="' . $primary_menu_icons_class . ' cera-heart"></i> <span>Social wall</span>';
						break;
					case 'Members':
						$menu_item->title = '<i class="' . $primary_menu_icons_class . ' cera-globe"></i> <span>Members</span>';
						break;
					case 'Groups':
						$menu_item->title = '<i class="' . $primary_menu_icons_class . ' cera-users"></i> <span>Groups</span>';
						break;
					case 'Forums':
						$menu_item->title = '<i class="' . $primary_menu_icons_class . ' cera-message-square"></i> <span>Forums</span>';
						break;
					case 'Documents New':
						$menu_item->title = '<i class="' . $primary_menu_icons_class . ' cera-folder"></i> <span>Documents</span> <ins>New</ins>';
						break;
					case 'Calendar':
						$menu_item->title = '<i class="' . $primary_menu_icons_class . ' cera-calendar"></i> <span>Calendar</span>';
						break;
					case 'Events Cards':
						if ( class_exists( 'Tribe__Events__Pro__Main' ) ) {
							$menu_item->title = '<i class="' . $primary_menu_icons_class . ' cera-layers"></i> <span>Events Cards</span>';
						}
						else {
							wp_delete_post( $menu_item->db_id );
						}
						break;
					case 'Events Map':
						if ( class_exists( 'Tribe__Events__Pro__Main' ) ) {
							$menu_item->title = '<i class="' . $primary_menu_icons_class . ' cera-map"></i> <span>Events Map</span>';
						}
						else {
							wp_delete_post( $menu_item->db_id );
						}
						break;
					case 'Today\'s events':
						$menu_item->title = '<i class="' . $primary_menu_icons_class . ' cera-sun"></i> <span>Today\'s events</span>';
						break;
					case 'Events List':
						$menu_item->title = '<i class="' . $primary_menu_icons_class . ' cera-list"></i> <span>Events List</span>';
						break;
					case 'Venues':
						$menu_item->title = '<i class="' . $primary_menu_icons_class . ' cera-home"></i> <span>Venues</span>';
						break;
					case 'Organizers':
						$menu_item->title = '<i class="' . $primary_menu_icons_class . ' cera-smile"></i> <span>Organizers</span>';
						break;
					case 'Pricing plans New':
						$menu_item->title = '<i class="' . $primary_menu_icons_class . ' cera-dollar-sign"></i> <span>Pricing plans</span><ins class="bg-pink">New</ins>';
						break;
					case 'Restricted content':
						$menu_item->title = '<i class="' . $primary_menu_icons_class . ' cera-x-octagon"></i> <span>Restricted content</span>';
						break;
					case 'News Hot':
						$menu_item->title = '<i class="' . $primary_menu_icons_class . ' cera-alert-circle"></i> <span>News</span><ins class="bg-success">Hot</ins>';
						break;
					case 'Wiki Soon':
						$menu_item->title = '<i class="' . $primary_menu_icons_class . ' cera-life-buoy"></i> <span>Wiki</span> <ins>Soon</ins>';
						break;
					case 'Pages':
						$menu_item->title = '<i class="' . $primary_menu_icons_class . ' cera-file"></i> <span>Pages</span>';
						break;
					case 'Log out':
						$menu_item->title = '<i class="' . $primary_menu_icons_class . ' cera-log-out"></i> <span>Log out</span>';
						break;
				}

				$this->update_menu_item( $primary_menu->term_id, $menu_item );
			}
			$this->convert_relative_menu_items_urls( $primary_menu, $primary_menu_items );

			// Adjust Features menu items
			foreach ( $features_menu_items as $menu_item ) {
				switch ( $menu_item->title ) {
					case 'Your team gathered':
						$menu_item->title = '<span class="icon-wrapper"><i class="cera-icon cera-users"></i><span class="h5">Your team gathered</span></span>';
						break;
					case 'Share documents':
						$menu_item->title = '<span class="icon-wrapper"><i class="cera-icon cera-hard-drive"></i><span class="h5">Share documents</span></span>';
						break;
					case 'Discuss your projects':
						$menu_item->title = '<span class="icon-wrapper"><i class="cera-icon cera-message-circle"></i><span class="h5">Discuss your projects</span></span>';
						break;
				}

				$this->update_menu_item( $features_menu->term_id, $menu_item );
			}

			// Adjust Footer menu items
			foreach ( $footer_menu_items as $menu_item ) {
				switch ( $menu_item->url ) {
					case 'https://facebook.com/':
						$menu_item->title = '<i class="fa fa-facebook"></i>';
						break;
					case 'https://twitter.com/':
						$menu_item->title = '<i class="fa fa-twitter"></i>';
						break;
					case 'https://slack.com/':
						$menu_item->title = '<i class="fa fa-slack"></i>';
						break;
				}

				$this->update_menu_item( $footer_menu->term_id, $menu_item );
			}

			// Adjust User - Logged In menu items
			foreach ( $logged_in_menu_items as $menu_item ) {
				switch ( $menu_item->title ) {
					case 'Dashboard':
						$menu_item->title = '<i class="cera-icon cera-grid"></i> Dashboard';
						break;
					case 'Activity':
						$menu_item->title = '<i class="cera-icon cera-alert-circle"></i> Activity';
						break;
					case 'Notifications':
						$menu_item->title = '<i class="cera-icon cera-bell"></i> Notifications';
						break;
					case 'Messages':
						$menu_item->title = '<i class="cera-icon cera-message-circle"></i> Messages';
						break;
					case 'Friends':
						$menu_item->title = '<i class="cera-icon cera-heart"></i> Friends';
						break;
					case 'Groups':
						$menu_item->title = '<i class="cera-icon cera-users"></i> Groups';
						break;
					case 'Forums':
						$menu_item->title = '<i class="cera-icon cera-message-square"></i> Forums';
						break;
					case 'Articles':
						$menu_item->title = '<i class="cera-icon cera-edit-2"></i> Articles';
						break;
					case 'Profile':
						$menu_item->title = '<i class="cera-icon cera-user"></i> Profile';
						break;
					case 'Settings':
						$menu_item->title = '<i class="cera-icon cera-settings"></i> Settings';
						break;
					case 'Log out':
						$menu_item->title = '<i class="cera-icon cera-log-out"></i> Log out';
						break;
				}

				$this->update_menu_item( $logged_in_menu->term_id, $menu_item );
			}
			$this->convert_relative_menu_items_urls( $logged_in_menu, $logged_in_menu_items );

			// Assign pages to custom sidebars
			$this->update_custom_sidebar( 'Dashboard', $dashboard_page->ID );

			$organizers_page = get_page_by_title( 'Organizers' );
			$this->update_custom_sidebar( 'Organizers', $organizers_page->ID );

			$search_members_page = get_page_by_title( 'Search members' );
			$this->update_custom_sidebar( 'Search members', $search_members_page->ID );

			$venues_page = get_page_by_title( 'Venues' );
			$this->update_custom_sidebar( 'Venues', $venues_page->ID );

			// BuddyPress adjustments
			if ( class_exists( 'BuddyPress' ) ) {
				// Enable registrations
				update_option( 'users_can_register', 1 );

				// Force "legacy" template pack
				bp_update_option( '_bp_theme_package_id', 'legacy' );

				// Generate profile fields in the "Base" tab
				$this->generate_base_xprofile_fields();

				// Generate profile fields in the "Details" tab
				$this->generate_details_profile_fields();

				// Get ids of component pages (directories pages, register page, etc...)
				$directory_pages = bp_get_option( 'bp-pages' );

				// Fix members directory search form
				if ( ! empty( $directory_pages['members'] ) ) {
					$this->fix_bps_form( 'Search directory', array(
						'field_' . xprofile_get_field_id_from_name( 'Name' ),
						'field_any',
						'field_' . xprofile_get_field_id_from_name( 'Position' ),
						'field_' . xprofile_get_field_id_from_name( 'Birthdate' ),
					), $directory_pages['members'] );
				}

				// Fix home search form
				$this->fix_bps_form( 'Search home', array(
					'field_' . xprofile_get_field_id_from_name( 'Name' ),
					'field_' . xprofile_get_field_id_from_name( 'Birthdate' ),
					'field_' . xprofile_get_field_id_from_name( 'Position' ),
				), $directory_pages['members'] );
			}

			// Assign PMPro pages
			$this->assign_pmpro_pages();

			$this->adjust_yoast_options();

			$this->activate_jetpack_components();
		}

		/**
		 * After import logic for the Youzer demo
		 */
		public function after_import_youzer() {
			$news_page      = get_page_by_title( 'News' );
			if ( ! empty( $news_page ) ) {
				update_option( 'page_for_posts', $news_page->ID );
			}

			$this->delete_duplicate_pages();

			$primary_menu    = get_term_by( 'name', 'Primary', 'nav_menu' );
			$logged_in_menu  = get_term_by( 'name', 'User - Logged In', 'nav_menu' );
			$logged_out_menu = get_term_by( 'name', 'User - Logged Out', 'nav_menu' );
			$features_menu   = get_term_by( 'name', 'Features', 'nav_menu' );
			$footer_1_menu   = get_term_by( 'name', 'Footer 1', 'nav_menu' );
			$social_menu     = get_term_by( 'name', 'Social', 'nav_menu' );

			$primary_menu_items   = wp_get_nav_menu_items( $primary_menu );
			$logged_in_menu_items = wp_get_nav_menu_items( $logged_in_menu );
			$features_menu_items  = wp_get_nav_menu_items( $features_menu );
			$footer_1_menu_items  = wp_get_nav_menu_items( $footer_1_menu );
			$social_menu_items    = wp_get_nav_menu_items( $social_menu );

			// Assign menus to their locations.
			set_theme_mod(
				'nav_menu_locations', array(
					'primary'         => $primary_menu->term_id,
					'user_logged_in'  => $logged_in_menu->term_id,
					'user_logged_out' => $logged_out_menu->term_id,
				)
			);

			// Adjust Primary menu items
			foreach ( $primary_menu_items as $menu_item ) {
				switch ( $menu_item->title ) {
					case 'Social wall':
						$menu_item->title = '<i class="cera-icon cera-heart text-primary"></i> <span>Social wall</span>';
						break;
					case 'Members':
						$menu_item->title = '<i class="cera-icon cera-globe text-primary"></i> <span>Members</span>';
						break;
					case 'Groups':
						$menu_item->title = '<i class="cera-icon cera-users text-primary"></i> <span>Groups</span>';
						break;
					case 'Forums':
						$menu_item->title = '<i class="cera-icon cera-message-square text-primary"></i> <span>Forums</span>';
						break;
					case 'Pricing plans':
						$menu_item->title = '<i class="cera-icon cera-dollar-sign text-primary"></i> <span>Pricing plans</span>';
						break;
					case 'Restricted content':
						$menu_item->title = '<i class="cera-icon cera-x-octagon text-primary"></i> <span>Restricted content</span>';
						break;
				}

				$this->update_menu_item( $primary_menu->term_id, $menu_item );
			}
			$this->convert_relative_menu_items_urls( $primary_menu, $primary_menu_items );

			// Adjust Features menu items
			foreach ( $features_menu_items as $menu_item ) {
				switch ( $menu_item->title ) {
					case 'Bring members together':
						$menu_item->title = '<span class="icon-wrapper"><i class="cera-icon cera-users"></i><span class="h5">Bring members together</span></span>';
						break;
					case 'Share documents':
						$menu_item->title = '<span class="icon-wrapper"><i class="cera-icon cera-hard-drive"></i><span class="h5">Share documents</span></span>';
						break;
					case 'Create relationships':
						$menu_item->title = '<span class="icon-wrapper"><i class="cera-icon cera-message-circle"></i><span class="h5">Create relationships</span></span>';
						break;
				}

				$this->update_menu_item( $features_menu->term_id, $menu_item );
			}

			// Adjust Social menu items
			foreach ( $social_menu_items as $menu_item ) {
				switch ( $menu_item->url ) {
					case 'https://www.instagram.com/':
						$menu_item->title = '<i class="fa fa-instagram"></i>';
						break;
					case 'https://twitter.com/':
						$menu_item->title = '<i class="fa fa-twitter"></i>';
						break;
					case 'https://www.facebook.com/':
						$menu_item->title = '<i class="fa fa-facebook"></i>';
						break;
				}

				$this->update_menu_item( $social_menu->term_id, $menu_item );
			}

			// Adjust Footer 1 menu items
			$this->convert_relative_menu_items_urls( $footer_1_menu, $footer_1_menu_items );

			// Adjust User - Logged In menu items
			foreach ( $logged_in_menu_items as $menu_item ) {
				switch ( $menu_item->title ) {
					case 'Dashboard':
						$menu_item->title = '<i class="cera-icon cera-grid"></i> Dashboard';
						break;
					case 'Activity':
						$menu_item->title = '<i class="cera-icon cera-alert-circle"></i> Activity';
						break;
					case 'Notifications':
						$menu_item->title = '<i class="cera-icon cera-bell"></i> Notifications';
						break;
					case 'Messages':
						$menu_item->title = '<i class="cera-icon cera-message-circle"></i> Messages';
						break;
					case 'Friends':
						$menu_item->title = '<i class="cera-icon cera-heart"></i> Friends';
						break;
					case 'Groups':
						$menu_item->title = '<i class="cera-icon cera-users"></i> Groups';
						break;
					case 'Forums':
						$menu_item->title = '<i class="cera-icon cera-message-square"></i> Forums';
						break;
					case 'Articles':
						$menu_item->title = '<i class="cera-icon cera-edit-2"></i> Articles';
						break;
					case 'Profile':
						$menu_item->title = '<i class="cera-icon cera-user"></i> Profile';
						break;
					case 'Settings':
						$menu_item->title = '<i class="cera-icon cera-settings"></i> Settings';
						break;
					case 'Log out':
						$menu_item->title = '<i class="cera-icon cera-log-out"></i> Log out';
						break;
				}

				$this->update_menu_item( $logged_in_menu->term_id, $menu_item );
			}
			$this->convert_relative_menu_items_urls( $logged_in_menu, $logged_in_menu_items );

			// Assign pages to custom sidebars
			$dashboard_page = get_page_by_title( 'Dashboard' );
			$this->update_custom_sidebar( 'Dashboard', $dashboard_page->ID );

			$search_members_page = get_page_by_title( 'Search members' );
			$this->update_custom_sidebar( 'Search members', $search_members_page->ID );

			// BuddyPress adjustments
			if ( class_exists( 'BuddyPress' ) ) {
				// Enable registrations
				update_option( 'users_can_register', 1 );

				// Force "legacy" template pack
				bp_update_option( '_bp_theme_package_id', 'legacy' );

				// Generate profile fields in the "Base" tab
				$this->generate_base_xprofile_fields();

				// Generate profile fields in the "Details" tab
				$this->generate_details_profile_fields();

				// Get ids of component pages (directories pages, register page, etc...)
				$directory_pages = bp_get_option( 'bp-pages' );

				// Fix members directory search form
				if ( ! empty( $directory_pages['members'] ) ) {
					$this->fix_bps_form( 'Search directory', array(
						'field_' . xprofile_get_field_id_from_name( 'Name' ),
						'field_any',
						'field_' . xprofile_get_field_id_from_name( 'Position' ),
						'field_' . xprofile_get_field_id_from_name( 'Birthdate' ),
					), $directory_pages['members'] );
				}

				// Fix home search form
				$this->fix_bps_form( 'Search home', array(
					'field_' . xprofile_get_field_id_from_name( 'Name' ),
					'field_' . xprofile_get_field_id_from_name( 'Birthdate' ),
					'field_' . xprofile_get_field_id_from_name( 'Position' ),
				), $directory_pages['members'] );
			}

			// Assign PMPro pages
			$this->assign_pmpro_pages();

			$this->adjust_yoast_options();

			$this->activate_jetpack_components();
		}

		/**
		 * After import logic for the Learn demo
		 */
		public function after_import_learn() {
			$news_page = get_page_by_title( 'News' );

			if ( ! empty( $news_page ) ) {
				update_option( 'page_for_posts', $news_page->ID );
			}

			$this->delete_duplicate_pages();

			$primary_menu       = get_term_by( 'name', 'Primary', 'nav_menu' );
			$secondary_menu     = get_term_by( 'name', 'Secondary', 'nav_menu' );
			$logged_in_menu     = get_term_by( 'name', 'User - Logged In', 'nav_menu' );
			$logged_out_menu    = get_term_by( 'name', 'User - Logged Out', 'nav_menu' );
			$features_menu      = get_term_by( 'name', 'Features', 'nav_menu' );
			$footer_social_menu = get_term_by( 'name', 'Footer Social', 'nav_menu' );
			$footer_1_menu      = get_term_by( 'name', 'Footer 1', 'nav_menu' );

			$primary_menu_items       = wp_get_nav_menu_items( $primary_menu );
			$secondary_menu_items     = wp_get_nav_menu_items( $secondary_menu );
			$logged_in_menu_items     = wp_get_nav_menu_items( $logged_in_menu );
			$features_menu_items      = wp_get_nav_menu_items( $features_menu );
			$footer_social_menu_items = wp_get_nav_menu_items( $footer_social_menu );
			$footer_1_menu_items      = wp_get_nav_menu_items( $footer_1_menu );

			// Assign menus to their locations.
			set_theme_mod(
				'nav_menu_locations', array(
					'primary'         => $primary_menu->term_id,
					'secondary'       => $secondary_menu->term_id,
					'user_logged_in'  => $logged_in_menu->term_id,
					'user_logged_out' => $logged_out_menu->term_id,
				)
			);

			// Adjust Primary menu items
			foreach ( $primary_menu_items as $menu_item ) {
				switch ( $menu_item->title ) {
					case 'My Dashboard':
						$menu_item->title = '<i class="cera-icon cera-grid"></i> <span>My Dashboard</span>';
						break;
					case 'My Courses':
						$menu_item->title = '<i class="cera-icon cera-feather"></i> <span>My Courses</span>';
						break;
					case 'My Docs New':
						$menu_item->title = '<i class="cera-icon cera-folder"></i> <span>My Docs</span> <ins class="bg-info">New</ins>';
						break;
					case 'My Feed':
						$menu_item->title = '<i class="cera-icon cera-rss"></i> <span>My Feed</span>';
						break;
					case 'My Messages':
						$menu_item->title = '<i class="cera-icon cera-message-circle"></i> <span>My Messages</span>';
						break;
					case 'My Forums':
						$menu_item->title = '<i class="cera-icon cera-message-square"></i> <span>My Forums</span>';
						break;
					case 'My Groups':
						$menu_item->title = '<i class="cera-icon cera-users"></i> <span>My Groups</span> <ins class="bg-pink">Ready</ins>';
						break;
					case 'My Connections':
						$menu_item->title = '<i class="cera-icon cera-heart"></i> <span>My Connections</span>';
						break;
					case 'Log out':
						$menu_item->title = '<i class="cera-icon cera-log-out"></i> <span>Log out</span>';
						break;
				}

				$this->update_menu_item( $primary_menu->term_id, $menu_item );
			}
			$this->convert_relative_menu_items_urls( $primary_menu, $primary_menu_items );

			// Adjust Secondary menu items
			$this->convert_relative_menu_items_urls( $secondary_menu, $secondary_menu_items );

			// Adjust Features menu items
			foreach ( $features_menu_items as $menu_item ) {
				switch ( $menu_item->title ) {
					case 'Learning Community':
						$menu_item->title = '<span class="icon-wrapper"><i class="cera-icon cera-users"></i><span class="h5">Learning Community</span></span>';
						break;
					case 'Share documents':
						$menu_item->title = '<span class="icon-wrapper"><i class="cera-icon cera-hard-drive"></i><span class="h5">Share documents</span></span>';
						break;
					case 'Discuss your projects':
						$menu_item->title = '<span class="icon-wrapper"><i class="cera-icon cera-message-circle"></i><span class="h5">Discuss your projects</span></span>';
						break;
				}

				$this->update_menu_item( $features_menu->term_id, $menu_item );
			}

			// Adjust Footer 1 menu items
			$this->convert_relative_menu_items_urls( $footer_1_menu, $footer_1_menu_items );

			// Adjust Footer Social menu items
			foreach ( $footer_social_menu_items as $menu_item ) {
				switch ( $menu_item->url ) {
					case 'https://facebook.com/':
						$menu_item->title = '<i class="fa fa-facebook"></i> Facebook';
						break;
					case 'https://twitter.com/':
						$menu_item->title = '<i class="fa fa-twitter"></i> Twitter';
						break;
					case 'https://slack.com/':
						$menu_item->title = '<i class="fa fa-slack"></i> Slack';
						break;
				}

				$this->update_menu_item( $footer_social_menu->term_id, $menu_item );
			}

			// Adjust User - Logged In menu items
			foreach ( $logged_in_menu_items as $menu_item ) {
				switch ( $menu_item->title ) {
					case 'Notifications':
						$menu_item->title = '<i class="cera-icon cera-bell"></i> Notifications';
						break;
					case 'Profile':
						$menu_item->title = '<i class="cera-icon cera-user"></i> Profile';
						break;
					case 'Settings':
						$menu_item->title = '<i class="cera-icon cera-settings"></i> Settings';
						break;
					case 'Log out':
						$menu_item->title = '<i class="cera-icon cera-log-out"></i> Log out';
						break;
				}

				$this->update_menu_item( $logged_in_menu->term_id, $menu_item );
			}
			$this->convert_relative_menu_items_urls( $logged_in_menu, $logged_in_menu_items );

			// Assign pages to custom sidebars
			$dashboard_page = get_page_by_title( 'Dashboard' );
			$this->update_custom_sidebar( 'Dashboard', $dashboard_page->ID );

			$search_members_page = get_page_by_title( 'Search members' );
			$this->update_custom_sidebar( 'Search members', $search_members_page->ID );

			// BuddyPress adjustments
			if ( class_exists( 'BuddyPress' ) ) {
				// Enable registrations
				update_option( 'users_can_register', 1 );

				// Force "legacy" template pack
				bp_update_option( '_bp_theme_package_id', 'legacy' );

				// Generate profile fields in the "Base" tab
				$this->generate_base_xprofile_fields();

				// Generate profile fields in the "Details" tab
				$this->generate_details_profile_fields();

				// Get ids of component pages (directories pages, register page, etc...)
				$directory_pages = bp_get_option( 'bp-pages' );

				// Fix members directory search form
				if ( ! empty( $directory_pages['members'] ) ) {
					$this->fix_bps_form( 'Search directory', array(
						'field_' . xprofile_get_field_id_from_name( 'Name' ),
						'field_any',
						'field_' . xprofile_get_field_id_from_name( 'Position' ),
						'field_' . xprofile_get_field_id_from_name( 'Birthdate' ),
					), $directory_pages['members'] );
				}

				// Fix home search form
				$this->fix_bps_form( 'Search home', array(
					'field_' . xprofile_get_field_id_from_name( 'Name' ),
					'field_' . xprofile_get_field_id_from_name( 'Birthdate' ),
					'field_' . xprofile_get_field_id_from_name( 'Position' ),
				), $directory_pages['members'] );
			}

			// Assign PMPro pages
			$this->assign_pmpro_pages();

			// Change BuddyPress for LearnDash option
			$bp_lms_options = get_site_option( 'buddypress_learndash_plugin_options', array() );
			$bp_lms_options['courses_visibility'] = 'on';
			update_site_option( 'buddypress_learndash_plugin_options', $bp_lms_options );

			$this->adjust_yoast_options();

			$this->activate_jetpack_components();
		}

		/**
		 * Replace pages with their Elementor template counterpart
		 */
		public function setup_elementor() {
			if ( ! class_exists( 'Elementor\Plugin' ) ) {
				return;
			}

			update_option( 'elementor_disable_color_schemes', 'yes' );
			update_option( 'elementor_disable_typography_schemes', 'yes' );
			update_option( 'elementor_container_width', '1400' );
			update_option( 'elementor_space_between_widgets', '0' );
			update_option( 'elementor_viewport_lg', '992' );
			update_option( 'elementor_viewport_md', '768' );
			update_option( 'elementor_page_title_selector', '#custom_header' );
			update_option( 'elementor_load_fa4_shim', 'yes' );

			$elementor = Elementor\Plugin::instance();

			$pages = get_posts( array(
				'post_type' => 'page',
				'posts_per_page' => -1,
			) );

			foreach ( $pages as $page ) {
				$elementor_template = get_page_by_title( $page->post_title, 'OBJECT', 'elementor_library' );

				if ( ! empty( $elementor_template ) ) {
					$template_data = $elementor->templates_manager->get_template_data( array(
						'display'       => true,
						'edit_mode'     => true,
						'page_settings' => true,
						'source'        => "local",
						'template_id'   => $elementor_template->ID,
					) );

					$elementor_page_template = 'elementor_header_footer';

					if ( ! empty( $template_data['page_settings'] ) ) {
						update_post_meta( $page->ID, '_elementor_page_settings', $template_data['page_settings'] );

						if ( ! empty( $template_data['page_settings']['template'] ) ) {
							$elementor_page_template = $template_data['page_settings']['template'];
						}
					}

					update_post_meta( $page->ID, '_wp_page_template', $elementor_page_template );
					update_post_meta( $page->ID, '_elementor_edit_mode', 'builder' );

					if ( ! empty( $template_data['content'] ) ) {
						update_post_meta( $page->ID, '_elementor_data', $template_data['content'] );
					}
				}
			}
		}

		private function delete_duplicate_pages() {
			$duplicate_pages = array(
				'duplicate_members_page'  => get_page_by_path( 'members-2' ),
				'duplicate_activity_page' => get_page_by_path( 'activity-2' ),
				'duplicate_activate_page' => get_page_by_path( 'activate-2' ),
				'duplicate_groups_page'   => get_page_by_path( 'groups-2' ),
				'duplicate_register_page' => get_page_by_path( 'register-2' ),
				'duplicate_sample_page'   => get_page_by_path( 'sample-2' ),
			);

			foreach ( $duplicate_pages as $duplicate_page ) {
				if ( ! empty( $duplicate_page ) ) {
					wp_delete_post( $duplicate_page->ID );
				}
			}
		}

		/**
		 * Activate "groups", "friends" and "messages" components in BuddyPress
		 */
		private function activate_bp_components() {
			if ( !function_exists( 'buddypress' ) ) {
				return;
			}

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			require_once( buddypress()->plugin_dir . '/bp-core/admin/bp-core-admin-schema.php' );

			$bp_active_components             = bp_get_option( 'bp-active-components', array() );
			$bp_active_components['groups']   = 1;
			$bp_active_components['friends']  = 1;
			$bp_active_components['messages'] = 1;

			// Generate necessary pages and emails for newly activated components
			bp_core_install( $bp_active_components );
			bp_update_option( 'bp-active-components', $bp_active_components );
			bp_core_add_page_mappings( $bp_active_components );
			bp_core_install_emails();
		}

		/**
		 * Generate profile fields in the "Base" tab
		 */
		private function generate_base_xprofile_fields() {
			// Generate First and Last name fields
			$this->generate_xprofile_field( 'First Name', 'textbox', 1, true );
			$this->generate_xprofile_field( 'Last Name', 'textbox', 1, true );

			// Generate Birthdate field.
			$this->generate_xprofile_field( 'Birthdate', 'datebox', 1, true );

			// Generate Gender field.
			$this->generate_xprofile_field( 'Gender', 'selectbox', 1, true, array(
				'Male',
				'Female',
				'Other',
			) );
		}

		/**
		 * Generate profile fields in the "Details" tab
		 */
		private function generate_details_profile_fields() {
			xprofile_insert_field_group( array(
				'field_group_id' => 2,
				'name'           => 'Details',
				'description'    => '',
				'can_delete'     => true
			) );

			// Generate Connection field.
			$this->generate_xprofile_field( 'Biographical Info', 'textarea', 2, true );

			$this->generate_xprofile_field( 'Passion', 'selectbox', 2, false, array(
				'Sport',
				'Travel',
				'Cooking',
				'Cinema',
				'Music',
				'Tatoo',
				'Books',
				'Gaming',
				'History',
			) );

			$this->generate_xprofile_field( 'Position', 'selectbox', 2, false, array(
				'Account manager',
				'Business analyst',
				'Chief brand officer',
				'Managing director',
				'Founder CEO',
				'Corporate development',
				'Chief solutions officer',
				'Systems analyst',
				'Purchasing manager',
			) );
		}

		/**
		 * Fix BP Profile Search form after import
		 *
		 * @param string $name The form name
		 * @param array $fields The form fields in the same order as the demo
		 * @param string|int $results_page The results page id
		 */
		private function fix_bps_form( $name, $fields, $results_page ) {
			$form = get_page_by_title( $name, 'OBJECT', 'bps_form' );

			if ( ! empty( $form ) ) {
				$bps_options = get_post_meta( $form->ID, 'bps_options', true );

				$bps_options['field_code'] = $fields;

				$bps_options['action'] = strval( $results_page );

				update_post_meta( $form->ID, 'bps_options', $bps_options );
			}
		}

		/**
		 * Assign Paid Memberships Pro pages in settings
		 */
		private function assign_pmpro_pages() {
			if ( function_exists( 'pmpro_init' ) ) {
				$account_page = get_page_by_title( 'Membership Account' );
				pmpro_setOption( 'account_page_id', $account_page->ID, 'intval' );
				$billing_page = get_page_by_title( 'Membership Billing' );
				pmpro_setOption( 'billing_page_id', $billing_page->ID, 'intval' );
				$cancel_page = get_page_by_title( 'Membership Cancel' );
				pmpro_setOption( 'cancel_page_id', $cancel_page->ID, 'intval' );
				$checkout_page = get_page_by_title( 'Membership Checkout' );
				pmpro_setOption( 'checkout_page_id', $checkout_page->ID, 'intval' );
				$confirmation_page = get_page_by_title( 'Membership Confirmation' );
				pmpro_setOption( 'confirmation_page_id', $confirmation_page->ID, 'intval' );
				$invoice_page = get_page_by_title( 'Membership Invoice' );
				pmpro_setOption( 'invoice_page_id', $invoice_page->ID, 'intval' );
				$pricing_page = get_page_by_title( 'Pricing & Plans' );
				pmpro_setOption( 'levels_page_id', $pricing_page->ID, 'intval' );
				$restricted_page = get_page_by_title( 'Access Restricted' );
				pmpro_setOption( 'pmprobp_restricted_page_id', $restricted_page->ID, 'intval' );
			}
		}

		/**
		 * Activate Jetpack components
		 */
		private function activate_jetpack_components() {
			if ( class_exists( 'Jetpack' ) ) {
				Jetpack::activate_module( 'tiled-gallery' );
				Jetpack::activate_module( 'infinite-scroll' );
				Jetpack::activate_module( 'carousel' );
			}
		}

		private function adjust_yoast_options() {
			if ( function_exists( 'yoast_breadcrumb' ) ) {
				$yoast_titles_options = get_option( 'wpseo_titles', array() );
				$yoast_titles_options['breadcrumbs-enable'] = 'on';
				$yoast_titles_options['breadcrumbs-sep'] = '•';
				$yoast_titles_options['separator'] = 'sc-bull';

				update_option( 'wpseo_titles', $yoast_titles_options );
			}
		}

		/**
		 * Generate a new xprofile field if it doesn't already exists
		 *
		 * @param string $name The field name
		 * @param string $type The field type
		 * @param int $field_group The field group (tab)
		 * @param bool $required Whether the field is required
		 * @param array $choices Choices for selectbox fields
		 * @param string $description The field description
		 */
		private function generate_xprofile_field( $name, $type = 'textbox', $field_group = 1, $required = true, $choices = array(), $description = '' ) {
			$slug = str_replace( ' ', '_', strtolower( $name ) );

			if ( function_exists( 'xprofile_get_field_id_from_name' ) && ! xprofile_get_field_id_from_name( $name ) ) {
				$profile_field_id = xprofile_insert_field( apply_filters( "cera_merlin_xprofile_{$slug}_field", array(
					'field_group_id' => $field_group,
					'name'           => $name,
					'description'    => $description,
					'is_required'    => $required,
					'type'           => $type,
					'can_delete'     => 1,
				) ) );

				if ( ( 'selectbox' === $type || 'checkbox' === $type ) && $profile_field_id ) {
					$choices = apply_filters( "cera_merlin_xprofile_{$slug}", $choices );

					foreach ( $choices as $i => $choice ) {
						xprofile_insert_field( array(
							'field_group_id' => $field_group,
							'parent_id'      => $profile_field_id,
							'type'           => $type,
							'name'           => $choice,
							'option_order'   => $i + 1,
						) );
					}
				}
			}
		}

		/**
		 * Convert relative urls in menu items into absolute urls
		 *
		 * @param WP_Term $menu The menu object
		 * @param array $menu_items The menu items associated with the menu
		 */
		private function convert_relative_menu_items_urls( $menu, $menu_items ) {
			foreach ( $menu_items as $menu_item ) {
				switch ( $menu_item->url ) {
					case '/members/elia':
					case '/members/elia/':
						wp_delete_post( $menu_item->db_id );
						break;
					case '/groups/tatoo':
					case '/groups/tatoo/':
						wp_delete_post( $menu_item->db_id );
						break;
				}

				if ( class_exists( 'BuddyPress' ) ) {
					$directory_pages = bp_get_option( 'bp-pages' );

					if ( strpos( $menu_item->url, '/register' ) ) {
						$menu_item->url = esc_url( get_permalink( $directory_pages['register'] ) );
						$this->update_menu_item( $menu->term_id, $menu_item );
					}
				}

				if ( $menu_item->url[0] === '/' ) {
					$menu_item->url = home_url( $menu_item->url );
					$this->update_menu_item( $menu->term_id, $menu_item );
				}
			}
		}

		/**
		 * Update a menu item
		 *
		 * @param $menu_id int
		 * @param $menu_item WP_Post
		 *
		 * @return int|bool|WP_Error
		 */
		private function update_menu_item( $menu_id, $menu_item ) {
			if ( empty( $menu_id ) || empty( $menu_item ) ) {
				return false;
			}

			return wp_update_nav_menu_item( $menu_id, $menu_item->db_id, array(
				'menu-item-db-id'       => $menu_item->db_id,
				'menu-item-object-id'   => $menu_item->object_id,
				'menu-item-object'      => $menu_item->object,
				'menu-item-url'         => $menu_item->url,
				'menu-item-parent-id'   => $menu_item->menu_item_parent,
				'menu-item-position'    => $menu_item->menu_order,
				'menu-item-type'        => $menu_item->type,
				'menu-item-title'       => $menu_item->title,
				'menu-item-description' => $menu_item->description,
				'menu-item-attr-title'  => false,
				'menu-item-target'      => $menu_item->target,
				'menu-item-classes'     => is_array( $menu_item->classes ) ? implode( ' ', $menu_item->classes ) : $menu_item->classes,
				'menu-item-xfn'         => $menu_item->xfn,
				'menu-item-status'      => $menu_item->post_status,
			) );
		}

		/**
		 * Update a custom sidebar by assigning the given sidebar attachment id (e.g. page id) to the custom sidebar
		 *
		 * @param string $sidebar_title Title of the sidebar to update
		 * @param int $sidebar_attachment_id Id of the page to assign to the sidebar
		 * @param int $sidebar_attachment_index Index of the sidebar attachment that needs to be updated
		 */
		private function update_custom_sidebar( $sidebar_title, $sidebar_attachment_id, $sidebar_attachment_index = 0 ) {
			$sidebar = get_page_by_title( $sidebar_title, OBJECT, 'sidebar_instance' );
			$sidebar_attachments = get_post_meta( $sidebar->ID, 'sidebar_attachments', true );
			$sidebar_attachments[$sidebar_attachment_index]['menu-item-db-id'] = $sidebar_attachment_id;
			$sidebar_attachments[$sidebar_attachment_index]['menu-item-object-id'] = $sidebar_attachment_id;
			update_post_meta( $sidebar->ID, 'sidebar_attachments', $sidebar_attachments );
		}

		/**
		 * Prevent Elementor from messing with the plugins installation step
		 */
		public function prevent_elementor_redirect() {
			delete_transient( 'elementor_activation_redirect' );
		}

		/**
		 * Remove the "child theme" step from Merlin
		 *
		 * @param $steps
		 *
		 * @return mixed
		 */
		public function change_merlin_steps( $steps ) {
			unset( $steps['child'] );

			return $steps;
		}

		/**
		 * Set directory locations, text strings, and settings for Merlin
		 */
		public function init() {
			new Merlin(
				$config  = array(
					'directory'            => 'libs/merlin', // Location / directory where Merlin WP is placed in your theme.
					'merlin_url'           => 'merlin', // The wp-admin page slug where Merlin WP loads.
					'parent_slug'          => 'themes.php', // The wp-admin parent page slug for the admin menu item.
					'capability'           => 'manage_options', // The capability required for this menu to be displayed to the user.
					'child_action_btn_url' => 'https://codex.wordpress.org/child_themes', // URL for the 'child-action-link'.
					'dev_mode'             => true, // Enable development mode for testing.
					'license_step'         => false, // EDD license activation step.
					'license_required'     => false, // Require the license activation step.
					'license_help_url'     => '', // URL for the 'license-tooltip'.
					'edd_remote_api_url'   => '', // EDD_Theme_Updater_Admin remote_api_url.
					'edd_item_name'        => '', // EDD_Theme_Updater_Admin item_name.
					'edd_theme_slug'       => '', // EDD_Theme_Updater_Admin item_slug.
					'ready_big_button_url' => home_url(), // Link for the big button on the ready step.
				),
				$strings = array(
					'admin-menu'               => esc_html__( 'Theme Setup', 'cera' ),
					/* translators: 1: Title Tag 2: Theme Name 3: Closing Title Tag */
					'title%s%s%s%s'            => esc_html__( '%1$s%2$s Themes &lsaquo; Theme Setup: %3$s%4$s', 'cera' ),
					'return-to-dashboard'      => esc_html__( 'Return to the dashboard', 'cera' ),
					'ignore'                   => esc_html__( 'Disable this wizard', 'cera' ),
					'btn-skip'                 => esc_html__( 'Skip', 'cera' ),
					'btn-next'                 => esc_html__( 'Next', 'cera' ),
					'btn-start'                => esc_html__( 'Start', 'cera' ),
					'btn-no'                   => esc_html__( 'Cancel', 'cera' ),
					'btn-plugins-install'      => esc_html__( 'Install', 'cera' ),
					'btn-child-install'        => esc_html__( 'Install', 'cera' ),
					'btn-content-install'      => esc_html__( 'Install', 'cera' ),
					'btn-import'               => esc_html__( 'Import', 'cera' ),
					'btn-license-activate'     => esc_html__( 'Activate', 'cera' ),
					'btn-license-skip'         => esc_html__( 'Later', 'cera' ),
					/* translators: Theme Name */
					'license-header%s'         => esc_html__( 'Activate %s', 'cera' ),
					/* translators: Theme Name */
					'license-header-success%s' => esc_html__( '%s is Activated', 'cera' ),
					/* translators: Theme Name */
					'license%s'                => esc_html__( 'Enter your license key to enable remote updates and theme support.', 'cera' ),
					'license-label'            => esc_html__( 'License key', 'cera' ),
					'license-success%s'        => esc_html__( 'The theme is already registered, so you can go to the next step!', 'cera' ),
					'license-json-success%s'   => esc_html__( 'Your theme is activated! Remote updates and theme support are enabled.', 'cera' ),
					'license-tooltip'          => esc_html__( 'Need help?', 'cera' ),
					/* translators: Theme Name */
					'welcome-header%s'         => esc_html__( 'Welcome to %s', 'cera' ),
					'welcome-header-success%s' => esc_html__( 'Hi. Welcome back', 'cera' ),
					'welcome%s'                => esc_html__( 'This wizard will set up your theme, install plugins, and import content. It is optional & should take only a few minutes.', 'cera' ),
					'welcome-success%s'        => esc_html__( 'You may have already run this theme setup wizard. If you would like to proceed anyway, click on the "Start" button below.', 'cera' ),
					'child-header'             => esc_html__( 'Install Child Theme', 'cera' ),
					'child-header-success'     => esc_html__( 'You\'re good to go!', 'cera' ),
					'child'                    => esc_html__( 'Let\'s build & activate a child theme so you may easily make theme changes.', 'cera' ),
					'child-success%s'          => esc_html__( 'Your child theme has already been installed and is now activated, if it wasn\'t already.', 'cera' ),
					'child-action-link'        => esc_html__( 'Learn about child themes', 'cera' ),
					'child-json-success%s'     => esc_html__( 'Awesome. Your child theme has already been installed and is now activated.', 'cera' ),
					'child-json-already%s'     => esc_html__( 'Awesome. Your child theme has been created and is now activated.', 'cera' ),
					'demo-header'              => esc_html__( 'Select Your Demo', 'cera' ),
					'demo'                     => esc_html__( 'You can import some demo content to help you get started with the theme.', 'cera' ),
					'plugins-header'           => esc_html__( 'Install Plugins', 'cera' ),
					'plugins-header-success'   => esc_html__( 'You\'re up to speed!', 'cera' ),
					'plugins'                  => esc_html__( 'Let\'s install some essential WordPress plugins to get your site up to speed.', 'cera' ),
					'plugins-success%s'        => esc_html__( 'The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.', 'cera' ),
					'plugins-action-link'      => esc_html__( 'Advanced', 'cera' ),
					'import-header'            => esc_html__( 'Import Content', 'cera' ),
					'import'                   => esc_html__( 'Let\'s import content to your website, to help you get familiar with the theme.', 'cera' ),
					'import-action-link'       => esc_html__( 'Advanced', 'cera' ),
					'ready-header'             => esc_html__( 'All done. Have fun!', 'cera' ),
					/* translators: Theme Author */
					'ready%s'                  => esc_html__( 'Your theme has been all set up. Enjoy your new theme by %s.', 'cera' ),
					'ready-action-link'        => esc_html__( 'More links', 'cera' ),
					'ready-big-button'         => esc_html__( 'View your website', 'cera' ),
					'ready-link-1'             => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://doc.themosaurus.com/cera', esc_html__( 'Documentation', 'cera' ) ),
					'ready-link-2'             => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://support.themosaurus.com/', esc_html__( 'Theme Support', 'cera' ) ),
					'ready-link-3'             => sprintf( '<a href="%1$s">%2$s</a>', admin_url( 'customize.php' ), esc_html__( 'Start Customizing', 'cera' ) ),
				)
			);
		}
	}
endif;

return new Cera_Merlin();
