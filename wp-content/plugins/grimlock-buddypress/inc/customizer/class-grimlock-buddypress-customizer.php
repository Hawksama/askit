<?php
/**
 * Grimlock_BuddyPress_Customizer Class
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
 * The Grimlock Customizer class for BuddyPress.
 */
class Grimlock_BuddyPress_Customizer extends Grimlock_Base_Customizer {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->id      = 'buddypress';
		$this->section = 'grimlock_buddypress_section';
		$this->title   = esc_html__( 'BuddyPress', 'grimlock-buddypress' );

		add_filter( 'body_class',                           array( $this, 'add_body_classes'                ), 10, 1 );
		add_action( 'after_setup_theme',                    array( $this, 'add_customizer_fields'           ), 20    );
		add_filter( 'grimlock_customizer_controls_js_data', array( $this, 'add_customizer_controls_js_data' ), 10, 1 );

		add_filter( 'bp_before_xprofile_cover_image_settings_parse_args', array( $this, 'change_xprofile_cover_image_settings' ), 20, 1 );
		add_filter( 'grimlock_buddypress_member_displayed_name',          array( $this, 'member_displayed_name'                ), 10 );
		add_filter( 'bp_before_groups_cover_image_settings_parse_args',   array( $this, 'change_groups_cover_image_settings'   ), 20, 1 );
		add_filter( 'bp_ajax_querystring',                                array( $this, 'change_members_groups_per_page'       ), 100, 2 );
		add_filter( 'grimlock_buddypress_groups_per_page',                array( $this, 'groups_per_page'                      ), 10, 1 );
		add_filter( 'grimlock_buddypress_members_per_page',               array( $this, 'members_per_page'                     ), 10, 1 );

		add_action( 'grimlock_buddypress_member_xprofile_custom_fields',                array( $this, 'add_member_custom_fields'                        ), 10, 1 );
		add_filter( 'grimlock_buddypress_groups_actions_text_displayed',                array( $this, 'is_groups_actions_text_displayed'                ), 10, 1 );
		add_filter( 'grimlock_buddypress_members_actions_text_displayed',               array( $this, 'is_members_actions_text_displayed'               ), 10, 1 );
		add_filter( 'grimlock_buddypress_navbar_nav_menu_item_friends_displayed',       array( $this, 'is_navbar_nav_menu_item_friends_displayed'       ), 10, 1 );
		add_filter( 'grimlock_buddypress_navbar_nav_menu_item_groups_displayed',        array( $this, 'is_navbar_nav_menu_item_groups_displayed'        ), 10, 1 );
		add_filter( 'grimlock_buddypress_navbar_nav_menu_item_notifications_displayed', array( $this, 'is_navbar_nav_menu_item_notifications_displayed' ), 10, 1 );
		add_filter( 'grimlock_buddypress_navbar_nav_menu_item_messages_displayed',      array( $this, 'is_navbar_nav_menu_item_messages_displayed'      ), 10, 1 );
		add_filter( 'grimlock_buddypress_navbar_nav_menu_item_settings_displayed',      array( $this, 'is_navbar_nav_menu_item_settings_displayed'      ), 10, 1 );
	}

	/**
	 * Register default values, settings and custom controls for the Theme Customizer.
	 *
	 * @since 1.0.0
	 */
	public function add_customizer_fields() {
		$this->defaults = apply_filters( 'grimlock_buddypress_customizer_defaults', array(
			'members_per_page'                             => '24',
			'default_profile_cover_image'                  => '',
			'member_displayed_name'                        => 'username',
			'groups_per_page'                              => '24',
			'default_group_cover_image'                    => '',

			'navbar_nav_menu_item_friends_displayed'       => true,
			'navbar_nav_menu_item_groups_displayed'        => true,
			'navbar_nav_menu_item_notifications_displayed' => true,
			'navbar_nav_menu_item_messages_displayed'      => true,
			'navbar_nav_menu_item_settings_displayed'      => false,

			'members_actions_text_displayed'               => false,
			'members_displayed_profile_fields'             => array(),

			'groups_actions_text_displayed'                => false,

			'friend_icons'                                 => 'add',
			'member_actions_button_background_color'       => '#ffffff',
			'friend_button_background_color'               => '#004085',
			'message_button_background_color'              => '#0c5460',
			'success_button_background_color'              => '#155724',
			'delete_button_background_color'               => '#721c24',
			'miscellaneous_actions_button_background_color' => '#818182',

			'profile_header_background_color'              => GRIMLOCK_BRAND_PRIMARY,
			'profile_header_text_color'                    => '#ffffff',
		) );

		$this->add_section( array( 'priority' => 120 ) );

		// General Tab
		$this->add_navbar_nav_menu_item_friends_displayed_field(            array( 'priority' => 10  ) );
		$this->add_navbar_nav_menu_item_groups_displayed_field(             array( 'priority' => 20  ) );
		$this->add_navbar_nav_menu_item_notifications_displayed_field(      array( 'priority' => 30  ) );
		$this->add_navbar_nav_menu_item_messages_displayed_field(           array( 'priority' => 40  ) );
		$this->add_navbar_nav_menu_item_settings_displayed_field(           array( 'priority' => 50  ) );

		// Members Tab
		$this->add_members_per_page_field(                              array( 'priority' => 60  ) );
		$this->add_default_profile_cover_image_field(                   array( 'priority' => 70  ) );
		$this->add_member_displayed_name_field(                         array( 'priority' => 80  ) );
		$this->add_members_displayed_profile_fields_field(              array( 'priority' => 90  ) );
		$this->add_members_actions_text_displayed_field(                array( 'priority' => 100 ) );

		// Groups Tab
		$this->add_groups_per_page_field(                               array( 'priority' => 110 ) );
		$this->add_default_group_cover_image_field(                     array( 'priority' => 120 ) );
		$this->add_groups_actions_text_displayed_field(                 array( 'priority' => 130 ) );

		// Style Tab
		$this->add_friend_icons_field(                                  array( 'priority' => 140 ) );
		$this->add_member_actions_button_background_color_field(        array( 'priority' => 150 ) );
		$this->add_friend_button_background_color_field(                  array( 'priority' => 160 ) );
		$this->add_message_button_background_color_field(               array( 'priority' => 170 ) );
		$this->add_success_button_background_color_field(               array( 'priority' => 180 ) );
		$this->add_delete_button_background_color_field(                array( 'priority' => 190 ) );
		$this->add_miscellaneous_actions_button_background_color_field( array( 'priority' => 200 ) );

		$this->add_profile_header_background_color_field(               array( 'priority' => 210 ) );
		$this->add_profile_header_text_color_field(                     array( 'priority' => 220 ) );
	}

	/**
	 * Add tabs to the Customizer to group controls.
	 *
	 * @param  array $js_data The array of data for the Customizer controls.
	 *
	 * @return array          The filtered array of data for the Customizer controls.
	 */
	public function add_customizer_controls_js_data( $js_data ) {
		$js_data['tabs'][ $this->section ] = array(
			array(
				'label'    => esc_html__( 'General', 'grimlock-buddypress' ),
				'class'    => 'buddypress-general-tab',
				'controls' => array(
					'navbar_nav_menu_item_friends_displayed',
					'navbar_nav_menu_item_groups_displayed',
					'navbar_nav_menu_item_notifications_displayed',
					'navbar_nav_menu_item_messages_displayed',
					'navbar_nav_menu_item_settings_displayed',
				),
			),
			array(
				'label'    => esc_html__( 'Members', 'grimlock-buddypress' ),
				'class'    => 'buddypress-members-tab',
				'controls' => array(
					'members_per_page',
					'default_profile_cover_image',
					'member_displayed_name',
					'members_actions_text_displayed',
					'members_displayed_profile_fields',
				),
			),
			array(
				'label'    => esc_html__( 'Groups', 'grimlock-buddypress' ),
				'class'    => 'buddypress-groups-tab',
				'controls' => array(
					'groups_per_page',
					'default_group_cover_image',
					'groups_actions_text_displayed',
				),
			),
			array(
				'label'    => esc_html__( 'Style', 'grimlock-buddypress' ),
				'class'    => 'buddypress-style-tab',
				'controls' => array(
					'friend_icons',
					'member_actions_button_background_color',
					'friend_button_background_color',
					'message_button_background_color',
					'success_button_background_color',
					'delete_button_background_color',
					'miscellaneous_actions_button_background_color',
					'profile_header_background_color',
					'profile_header_text_color',
				),
			),
		);
		return $js_data;
	}

	/**
	 * Add a Kirki checkbox field in the Customizer to set whether the members action text is displayed.
	 *
	 * @since 1.0.5
	 *
	 * @param array $args The array of arguments for the Kirki field.
	 */
	protected function add_members_actions_text_displayed_field( $args = array() ) {
		if ( class_exists( 'Kirki') ) {
			$args = wp_parse_args( $args, array(
				'type'        => 'checkbox',
				'section'     => $this->section,
				'label'       => esc_html__( 'Display Members Actions Text', 'grimlock-buddypress' ),
				'description' => esc_html__( 'If this field is checked, BuddyPress action buttons for members lists will have a text in addition to the icon.', 'grimlock-buddypress' ),
				'settings'    => 'members_actions_text_displayed',
				'default'     => $this->get_default( 'members_actions_text_displayed' ),
				'priority'    => 20,
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_buddypress_members_actions_text_displayed_field_args', $args ) );
		}
	}

	/**
	 * Add a Kirki sortable field in the Customizer to choose which member fields are displayed on member cards
	 *
	 * @since 1.0.5
	 *
	 * @param array $args The array of arguments for the Kirki field.
	 */
	protected function add_members_displayed_profile_fields_field( $args = array() ) {
		if ( class_exists( 'Kirki' ) && function_exists( 'buddypress' ) && bp_is_active( 'xprofile' ) ) {

			// Initialize necessary BP components
			bp_setup_xprofile();
			$bp = buddypress();
			$bp->core->setup_globals();
			$bp->profile->setup_globals();

			// Get profile field groups
			$field_groups = bp_xprofile_get_groups( array(
				'profile_group_id'       => false,
				'user_id'                => false,
				'member_type'            => false,
				'hide_empty_groups'      => false,
				'hide_empty_fields'      => false,
				'fetch_fields'           => true,
				'fetch_field_data'       => false,
				'fetch_visibility_level' => false,
				'exclude_groups'         => false,
				'exclude_fields'         => false,
				'update_meta_cache'      => true,
			) );

			// Store fields in a key => value array
			$fields = array();
			foreach ( $field_groups as $field_group ) {
				foreach ( $field_group->fields as $field ) {
					$fields[ $field->id ] = $field->name;
				}
			}

			$args = wp_parse_args( $args, array(
				'type'     => 'sortable',
				'label'    => esc_html__( 'Members Displayed Profile Fields', 'grimlock-buddypress' ),
				'settings' => 'members_displayed_profile_fields',
				'section'  => $this->section,
				'default'  => array(),
				'choices'  => $fields,
				'priority' => 10,
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_buddypress_members_displayed_profile_fields_field_args', $args ) );
		}
	}

	/**
	 * Add a Kirki checkbox field in the Customizer to set whether the groups action text is displayed.
	 *
	 * @since 1.0.5
	 *
	 * @param array $args The array of arguments for the Kirki field.
	 */
	protected function add_groups_actions_text_displayed_field( $args = array() ) {
		if ( class_exists( 'Kirki') ) {
			$args = wp_parse_args( $args, array(
				'type'        => 'checkbox',
				'section'     => $this->section,
				'label'       => esc_html__( 'Display Groups Actions Text', 'grimlock-buddypress' ),
				'description' => esc_html__( 'If this field is checked, BuddyPress action buttons for group lists will have a text in addition to the icon.', 'grimlock-buddypress' ),
				'settings'    => 'groups_actions_text_displayed',
				'default'     => $this->get_default( 'groups_actions_text_displayed' ),
				'priority'    => 20,
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_buddypress_groups_actions_text_displayed_field_args', $args ) );
		}
	}

	/**
	 * Add a Kirki checkbox field in the Customizer to set whether the navbar friends icon
	 * need to be displayed or not.
	 *
	 * @since 1.1.0
	 *
	 * @param array $args The array of arguments for the Kirki field.
	 */
	protected function add_navbar_nav_menu_item_friends_displayed_field( $args = array() ) {
		if ( class_exists( 'Kirki') ) {
			$args = wp_parse_args( $args, array(
				'type'     => 'checkbox',
				'section'  => $this->section,
				'label'    => esc_html__( 'Display Navbar Friends Icon', 'grimlock-buddypress' ),
				'settings' => 'navbar_nav_menu_item_friends_displayed',
				'default'  => $this->get_default( 'navbar_nav_menu_item_friends_displayed' ),
				'priority' => 20,
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_buddypress_navbar_nav_menu_item_friends_displayed_field_args', $args ) );
		}
	}


	/**
	 * Add a Kirki checkbox field in the Customizer to set whether the navbar groups icon
	 * need to be displayed or not.
	 *
	 * @since 1.1.0
	 *
	 * @param array $args The array of arguments for the Kirki field.
	 */
	protected function add_navbar_nav_menu_item_groups_displayed_field( $args = array() ) {
		if ( class_exists( 'Kirki') ) {
			$args = wp_parse_args( $args, array(
				'type'     => 'checkbox',
				'section'  => $this->section,
				'label'    => esc_html__( 'Display Navbar Groups Icon', 'grimlock-buddypress' ),
				'settings' => 'navbar_nav_menu_item_groups_displayed',
				'default'  => $this->get_default( 'navbar_nav_menu_item_groups_displayed' ),
				'priority' => 20,
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_buddypress_navbar_nav_menu_item_groups_displayed_field_args', $args ) );
		}
	}


	/**
	 * Add a Kirki checkbox field in the Customizer to set whether the navbar notifications icon
	 * need to be displayed or not.
	 *
	 * @since 1.1.0
	 *
	 * @param array $args The array of arguments for the Kirki field.
	 */
	protected function add_navbar_nav_menu_item_notifications_displayed_field( $args = array() ) {
		if ( class_exists( 'Kirki') ) {
			$args = wp_parse_args( $args, array(
				'type'     => 'checkbox',
				'section'  => $this->section,
				'label'    => esc_html__( 'Display Navbar Notifications Icon', 'grimlock-buddypress' ),
				'settings' => 'navbar_nav_menu_item_notifications_displayed',
				'default'  => $this->get_default( 'navbar_nav_menu_item_notifications_displayed' ),
				'priority' => 20,
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_buddypress_navbar_nav_menu_item_notifications_displayed_field_args', $args ) );
		}
	}


	/**
	 * Add a Kirki checkbox field in the Customizer to set whether the navbar messages icon
	 * need to be displayed or not.
	 *
	 * @since 1.1.0
	 *
	 * @param array $args The array of arguments for the Kirki field.
	 */
	protected function add_navbar_nav_menu_item_messages_displayed_field( $args = array() ) {
		if ( class_exists( 'Kirki') ) {
			$args = wp_parse_args( $args, array(
				'type'     => 'checkbox',
				'section'  => $this->section,
				'label'    => esc_html__( 'Display Navbar Messages Icon', 'grimlock-buddypress' ),
				'settings' => 'navbar_nav_menu_item_messages_displayed',
				'default'  => $this->get_default( 'navbar_nav_menu_item_messages_displayed' ),
				'priority' => 20,
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_buddypress_navbar_nav_menu_item_messages_displayed_field_args', $args ) );
		}
	}


	/**
	 * Add a Kirki checkbox field in the Customizer to set whether the navbar settings icon
	 * need to be displayed or not.
	 *
	 * @since 1.1.0
	 *
	 * @param array $args The array of arguments for the Kirki field.
	 */
	protected function add_navbar_nav_menu_item_settings_displayed_field( $args = array() ) {
		if ( class_exists( 'Kirki') ) {
			$args = wp_parse_args( $args, array(
				'type'     => 'checkbox',
				'section'  => $this->section,
				'label'    => esc_html__( 'Display Navbar Settings Icon', 'grimlock-buddypress' ),
				'settings' => 'navbar_nav_menu_item_settings_displayed',
				'default'  => $this->get_default( 'navbar_nav_menu_item_settings_displayed' ),
				'priority' => 20,
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_buddypress_navbar_nav_menu_item_settings_displayed_field_args', $args ) );
		}
	}


	/**
	 * Add a Kirki radio-image field to set the icons for friend related buttons in the Customizer.
	 *
	 * @param array $args The array of arguments for the Kirki field.
	 * @since 1.0.5
	 */
	protected function add_friend_icons_field( $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			$args = wp_parse_args( $args, array(
				'type'     => 'radio-image',
				'section'  => $this->section,
				'label'    => esc_html__( 'Friend Icons', 'grimlock-buddypress' ),
				'settings' => 'friend_icons',
				'default'  => $this->get_default( 'friend_icons' ),
				'priority' => 10,
				'choices'  => array(
					'add'    => get_template_directory_uri() . '/assets/images/customizer/icons/icon-add.png',
					'person' => get_template_directory_uri() . '/assets/images/customizer/icons/icon-person.png',
					'heart'  => get_template_directory_uri() . '/assets/images/customizer/icons/icon-heart.png',
					'like'   => get_template_directory_uri() . '/assets/images/customizer/icons/icon-like.png',
					'smile'  => get_template_directory_uri() . '/assets/images/customizer/icons/icon-smile.png',
					'star'   => get_template_directory_uri() . '/assets/images/customizer/icons/icon-star.png',
				),
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_buddypress_friend_icons_field_args', $args ) );
		}
	}

	/**
	 * Add a Kirki color field to set the color in the Customizer.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args The array of arguments for the Kirki field.
	 */
	protected function add_member_actions_button_background_color_field( $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			$background_color_elements = apply_filters( 'grimlock_buddypress_member_actions_button_background_color_elements', array(
				'#buddypress:not(.youzer) div.action > a',
				'#buddypress:not(.youzer) div.action > div > a',
				'#buddypress:not(.youzer) #members-list div.action > a',
				'#buddypress:not(.youzer) #members-list div.action > div > a',
				'#buddypress:not(.youzer) #groups-list div.action > a',
				'#buddypress:not(.youzer) #groups-list div.action > div > a',
				'#buddypress:not(.youzer) #friend-list div.action > a',
				'#buddypress:not(.youzer) #friend-list div.action > div > a',
				'#buddypress:not(.youzer) #mods-list div.action > a',
				'#buddypress:not(.youzer) #mods-list div.action > div > a',
				'#buddypress:not(.youzer) #admins-list div.action > a',
				'#buddypress:not(.youzer) #admins-list div.action > div > a',
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action > a',
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action > div > a',
			) );

			$color_elements = apply_filters( 'grimlock_buddypress_member_actions_button_color_elements', array(
				'.buddypress.grimlock-buddypress--groups-actions-text-displayed #site #groups-list div.action > a',
				'.buddypress.grimlock-buddypress--groups-actions-text-displayed #site #groups-list div.action > div > a',
				'.buddypress.grimlock-buddypress--groups-actions-text-displayed #site div#item-header #profile-header #item-buttons.action a.group-button',

				'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #members-list div.action > a',
				'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #friend-list div.action > a',
				'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #members-list div.action > div > a',
				'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #friend-list div.action > div > a',

				'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #mods-list div.action > a',
				'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #admins-list div.action > a',
				'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #mods-list div.action > div > a',
				'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #admins-list div.action > div > a',

				'.buddypress.grimlock-buddypress--members-actions-text-displayed #site div#item-header #profile-header.profile-header--member #item-buttons.action > div > a',
			) );

			$outputs = apply_filters( 'grimlock_buddypress_member_actions_button_background_color_outputs', array(
				$this->get_css_var_output( 'member_actions_button_background_color' ),
				array(
					'element'  => implode( ',', $background_color_elements ),
					'property' => 'background',
					'suffix'   => '!important',
				),
				array(
					'element'  => implode( ',', $color_elements ),
					'property' => 'color',
					'suffix'   => '!important',
				),
			), $background_color_elements, $color_elements );

			$args = wp_parse_args( $args, array(
				'type'      => 'color',
				'label'     => esc_html__( 'Member Actions Buttons Background Color', 'grimlock-buddypress' ),
				'section'   => $this->section,
				'settings'  => 'member_actions_button_background_color',
				'default'   => $this->get_default( 'member_actions_button_background_color' ),
				'choices'   => array(
					'alpha'    => false,
					'palettes' => apply_filters( 'grimlock_color_field_palettes', array() ),
				),
				'priority'  => 10,
				'transport' => 'postMessage',
				'js_vars'   => $this->to_js_vars( $outputs ),
				'output'    => $outputs,
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_buddypress_member_actions_button_background_color_field_args', $args ) );
		}
	}

	/**
	 * Add a Kirki color field to set the color in the Customizer.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args The array of arguments for the Kirki field.
	 */
	protected function add_friend_button_background_color_field( $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			$color_elements = apply_filters( 'grimlock_buddypress_friend_button_color_elements', array(
				'#buddypress:not(.youzer) div.action a.friendship-button:before',
				'#buddypress:not(.youzer) div.action .friendship-button > a:before',
				'#buddypress:not(.youzer) div.action .friendship-button-ext > a:before',
				'#buddypress:not(.youzer) #members-list div.action a.friendship-button:before',
				'#buddypress:not(.youzer) #members-list div.action .friendship-button > a:before',
				'#buddypress:not(.youzer) #friend-list div.action a.friendship-button:before',
				'#buddypress:not(.youzer) #friend-list div.action .friendship-button > a:before',
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action a.friendship-button:before',
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action .friendship-button > a:before',
				'#buddypress:not(.youzer) div.action a.follow:before',
				'#buddypress:not(.youzer) #members-list div.action a.follow:before',
				'#buddypress:not(.youzer) #friend-list div.action a.follow:before',
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action a.follow:before',
				'#buddypress:not(.youzer) div.action a.friendship-button.requested.remove:before',
				'#buddypress:not(.youzer) div.action .friendship-button > a.requested.remove:before',
				'#buddypress:not(.youzer) #members-list div.action a.friendship-button.requested.remove:before',
				'#buddypress:not(.youzer) #members-list div.action .friendship-button > a.requested.remove:before',
			) );

			$background_color_elements = apply_filters( 'grimlock_buddypress_friend_button_background_color_elements', array(
				'.grimlock-nav-menu-section .menu .menu-item.primary i',
				'.grimlock-nav-menu-section .menu .menu-item.primary .icon-wrapper:before',
				'.grimlock-nav-menu-section .menu .menu-item.primary .icon-wrapper:after',
			) );

			$outputs = apply_filters( 'grimlock_buddypress_friend_button_background_color_outputs', array(
				$this->get_css_var_output( 'friend_button_background_color' ),
				array(
					'element'  => implode( ',', $color_elements ),
					'property' => 'color',
				),
				array(
					'element'  => implode( ',', $background_color_elements ),
					'property' => 'background-color',
				),
				array(
					'element'  => implode( ',', array(
						'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #buddypress:not(.youzer) .bp-card-list--members div.action a.friendship-button',
						'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #buddypress:not(.youzer) .bp-card-list--members div.action a.accept',
						'.buddypress.grimlock-buddypress--members-actions-text-displayed #site div#item-header #profile-header.profile-header--member #item-buttons.action > div > a.friendship-button',
					) ),
					'property' => 'background',
					'suffix'   => '!important',
				),
			), $background_color_elements, $color_elements );

			$args = wp_parse_args( $args, array(
				'type'      => 'color',
				'label'     => esc_html__( 'Friend Buttons Color', 'grimlock-buddypress' ),
				'section'   => $this->section,
				'settings'  => 'friend_button_background_color',
				'default'   => $this->get_default( 'friend_button_background_color' ),
				'choices'   => array(
					'alpha'    => false,
					'palettes' => apply_filters( 'grimlock_color_field_palettes', array() ),
				),
				'priority'  => 10,
				'transport' => 'postMessage',
				'js_vars'   => $this->to_js_vars( $outputs ),
				'output'    => $outputs,
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_buddypress_friend_button_background_color_field_args', $args ) );
		}
	}

	/**
	 * Add a Kirki color field to set the color in the Customizer.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args The array of arguments for the Kirki field.
	 */
	protected function add_message_button_background_color_field( $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			$color_elements = apply_filters( 'grimlock_buddypress_message_button_color_elements', array(
				'#buddypress:not(.youzer) div.action a.send-message:before',
				'#buddypress:not(.youzer) #members-list div.action a.send-message:before',
				'#buddypress:not(.youzer) #friend-list div.action a.send-message:before',
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action a.send-message:before',
			) );

			$background_color_elements = apply_filters( 'grimlock_buddypress_message_button_background_color_elements', array(
				'.grimlock-nav-menu-section .menu .menu-item.info i',
				'.grimlock-nav-menu-section .menu .menu-item.info .icon-wrapper:before',
				'.grimlock-nav-menu-section .menu .menu-item.info .icon-wrapper:after',
				'#buddypress:not(.youzer) #send_message_form ul.acfb-holder li.friend-tab',
			) );

			$outputs = apply_filters( 'grimlock_buddypress_message_button_background_color_outputs', array(
				$this->get_css_var_output( 'message_button_background_color' ),
				array(
					'element'  => implode( ',', $color_elements ),
					'property' => 'color',
				),
				array(
					'element'  => implode( ',', $background_color_elements ),
					'property' => 'background-color',
				),
				array(
					'element'  => implode( ',', array(
						'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #buddypress:not(.youzer) .bp-card-list--members div.action a.send-message',
						'.buddypress.grimlock-buddypress--members-actions-text-displayed #site div#item-header #profile-header.profile-header--member #item-buttons.action > div > a.send-message',
						'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #buddypress:not(.youzer) .bp-card-list--members div.action a.member-promote-to-mod',
						'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #buddypress:not(.youzer) .bp-card-list--members div.action a.member-promote-to-admin',
						'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #buddypress:not(.youzer) .bp-card-list--members div.action a.mod-promote-to-admin',
					) ),
					'property' => 'background',
					'suffix'   => '!important',
				),
			), $background_color_elements, $color_elements );

			$args = wp_parse_args( $args, array(
				'type'      => 'color',
				'label'     => esc_html__( 'Message Buttons Color', 'grimlock-buddypress' ),
				'section'   => $this->section,
				'settings'  => 'message_button_background_color',
				'default'   => $this->get_default( 'message_button_background_color' ),
				'choices'   => array(
					'alpha'    => false,
					'palettes' => apply_filters( 'grimlock_color_field_palettes', array() ),
				),
				'priority'  => 10,
				'transport' => 'postMessage',
				'js_vars'   => $this->to_js_vars( $outputs ),
				'output'    => $outputs,
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_buddypress_message_button_background_color_field_args', $args ) );
		}
	}

	/**
	 * Add a Kirki color field to set the color in the Customizer.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args The array of arguments for the Kirki field.
	 */
	protected function add_success_button_background_color_field( $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			$color_elements = apply_filters( 'grimlock_buddypress_success_button_color_elements', array(
				'#buddypress:not(.youzer) div.action [id="user_switching_switch_to"] a:before',
				'#buddypress:not(.youzer) #members-list div.action [id="user_switching_switch_to"] a:before',
				'#buddypress:not(.youzer) #friend-list div.action [id="user_switching_switch_to"] a:before',
				'#buddypress:not(.youzer) #mods-list div.action [id="user_switching_switch_to"] a:before',
				'#buddypress:not(.youzer) #admins-list div.action [id="user_switching_switch_to"] a:before',
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action [id="user_switching_switch_to"] a:before',
				'#buddypress:not(.youzer) div.action a.accept:before',
				'#buddypress:not(.youzer) #members-list div.action a.accept:before',
				'#buddypress:not(.youzer) #friend-list div.action a.accept:before',
				'#buddypress:not(.youzer) #mods-list div.action a.accept:before',
				'#buddypress:not(.youzer) #admins-list div.action a.accept:before',
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action a.accept:before',
				'#buddypress:not(.youzer) div.action a.accept-group:before',
				'#buddypress:not(.youzer) #members-list div.action a.accept-group:before',
				'#buddypress:not(.youzer) #groups-list div.action a.accept-group:before',
				'#buddypress:not(.youzer) #friend-list div.action a.accept-group:before',
				'#buddypress:not(.youzer) #mods-list div.action a.accept-group:before',
				'#buddypress:not(.youzer) #admins-list div.action a.accept-group:before',
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action a.accept-group:before',
				'#buddypress:not(.youzer) div.action a.group-button:before',
				'#buddypress:not(.youzer) #members-list div.action a.group-button:before',
				'#buddypress:not(.youzer) #groups-list div.action a.group-button:before',
				'#buddypress:not(.youzer) #friend-list div.action a.group-button:before',
				'#buddypress:not(.youzer) #mods-list div.action a.group-button:before',
				'#buddypress:not(.youzer) #admins-list div.action a.group-button:before',
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action a.group-button:before',
				'#buddypress:not(.youzer) div.action a.follow:hover:before',
				'#buddypress:not(.youzer) #members-list div.action a.follow:hover:before',
				'#buddypress:not(.youzer) #friend-list div.action a.follow:hover:before',
				'#buddypress:not(.youzer) #mods-list div.action a.follow:hover:before',
				'#buddypress:not(.youzer) #admins-list div.action a.follow:hover:before',
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action a.follow:hover:before',
				'#buddypress:not(.youzer) div.action a.unfollow:before',
				'#buddypress:not(.youzer) #members-list div.action a.unfollow:before',
				'#buddypress:not(.youzer) #friend-list div.action a.unfollow:before',
				'#buddypress:not(.youzer) #mods-list div.action a.unfollow:before',
				'#buddypress:not(.youzer) #admins-list div.action a.unfollow:before',
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action a.unfollow:before',
			) );

			$background_color_elements = apply_filters( 'grimlock_buddypress_success_button_background_color_elements', array(
				'.grimlock-nav-menu-section .menu .menu-item.success i',
				'.grimlock-nav-menu-section .menu .menu-item.success .icon-wrapper:before',
				'.grimlock-nav-menu-section .menu .menu-item.success .icon-wrapper:after',
				'.uppy-StatusBar.is-complete .uppy-StatusBar-progress',
				'.bp-card-list.bp-card-list--members .bp-card-list__item.is-online .card:before',
			) );

			$outputs = apply_filters( 'grimlock_buddypress_success_button_background_color_outputs', array(
				$this->get_css_var_output( 'success_button_background_color' ),
				array(
					'element'  => implode( ',', $color_elements ),
					'property' => 'color',
				),
				array(
					'element'  => '.bp-card-list.bp-card-list--groups .bp-card-list__item.is-member .card',
					'property' => 'border-bottom-color',
				),
				array(
					'element'  => implode( ',', $background_color_elements ),
					'property' => 'background-color',
				),
				array(
					'element'  => implode( ',', array(
						'.buddypress.grimlock-buddypress--groups-actions-text-displayed #site div.action a.group-button.join-group',
						'.buddypress.grimlock-buddypress--groups-actions-text-displayed #site #groups-list div.action a.group-button.join-group',
						'.buddypress.grimlock-buddypress--groups-actions-text-displayed #site div#item-header #profile-header #item-buttons.action a.group-button.join-group',
						'.buddypress.grimlock-buddypress--groups-actions-text-displayed #site div.action a.group-button.request-membership',
						'.buddypress.grimlock-buddypress--groups-actions-text-displayed #site #groups-list div.action a.group-button.request-membership',
						'.buddypress.grimlock-buddypress--groups-actions-text-displayed #site div#item-header #profile-header #item-buttons.action a.group-button.request-membership',

						'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #buddypress:not(.youzer) .bp-card-list--members div.action [id="user_switching_switch_to"] a',
						'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #buddypress:not(.youzer) .bp-card-list--members div.action a.accept-group',
						'.buddypress.grimlock-buddypress--members-actions-text-displayed #site div#item-header #profile-header.profile-header--member #item-buttons.action [id="user_switching_switch_to"] a',
						'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #buddypress:not(.youzer) .bp-card-list--members div.action a.member-unban',
						'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #groups-list div.action a.accept-group',
					) ),
					'property' => 'background',
					'suffix'   => '!important',
				),
			), $background_color_elements, $color_elements );

			$args = wp_parse_args( $args, array(
				'type'      => 'color',
				'label'     => esc_html__( 'Success Buttons Color', 'grimlock-buddypress' ),
				'section'   => $this->section,
				'settings'  => 'success_button_background_color',
				'default'   => $this->get_default( 'success_button_background_color' ),
				'choices'   => array(
					'alpha'    => false,
					'palettes' => apply_filters( 'grimlock_color_field_palettes', array() ),
				),
				'priority'  => 10,
				'transport' => 'postMessage',
				'js_vars'   => $this->to_js_vars( $outputs ),
				'output'    => $outputs,
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_buddypress_success_button_background_color_field_args', $args ) );
		}
	}

	/**
	 * Add a Kirki color field to set the color in the Customizer.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args The array of arguments for the Kirki field.
	 */
	protected function add_delete_button_background_color_field( $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			$color_elements = apply_filters( 'grimlock_buddypress_delete_button_color_elements', array(
				'#buddypress:not(.youzer) div.action a.reject:before',
				'#buddypress:not(.youzer) div.action a.remove:not(.is_friend):not(.pending_friend):before',
				'#buddypress:not(.youzer) #members-list div.action a.reject:before',
				'#buddypress:not(.youzer) #members-list div.action a.remove:not(.is_friend):before',
				'#buddypress:not(.youzer) #groups-list div.action a.reject:before',
				'#buddypress:not(.youzer) #groups-list div.action a.remove:not(.is_friend):not(.pending_friend):before',
				'#buddypress:not(.youzer) #friend-list div.action a.reject:before',
				'#buddypress:not(.youzer) #friend-list div.action a.remove:not(.is_friend):not(.pending_friend):before',
				'#buddypress:not(.youzer) #mods-list div.action a.reject:before',
				'#buddypress:not(.youzer) #mods-list div.action a.remove:not(.is_friend):not(.pending_friend):before',
				'#buddypress:not(.youzer) #admins-list div.action a.reject:before',
				'#buddypress:not(.youzer) #admins-list div.action a.remove:not(.is_friend):not(.pending_friend):before',
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action a.reject:before',
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action a.remove:not(.is_friend):not(.pending_friend):before',
				'#buddypress:not(.youzer) div.action a.friendship-button.requested:hover:before',
				'#buddypress:not(.youzer) div.action .friendship-button > a.requested:hover:before',
				'#buddypress:not(.youzer) #members-list div.action a.friendship-button.requested:hover:before',
				'#buddypress:not(.youzer) #members-list div.action .friendship-button > a.requested:hover:before',
				'#buddypress:not(.youzer) #friend-list div.action a.friendship-button.requested:hover:before',
				'#buddypress:not(.youzer) #friend-list div.action .friendship-button > a.requested:hover:before',
				'#buddypress:not(.youzer) #mods-list div.action a.friendship-button.requested:hover:before',
				'#buddypress:not(.youzer) #mods-list div.action .friendship-button > a.requested:hover:before',
				'#buddypress:not(.youzer) #admins-list div.action a.friendship-button.requested:hover:before',
				'#buddypress:not(.youzer) #admins-list div.action .friendship-button > a.requested:hover:before',
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action a.friendship-button.requested:hover:before',
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action .friendship-button > a.requested:hover:before',
				'#buddypress:not(.youzer) div.action a.group-button.leave-group:before',
				'#buddypress:not(.youzer) #groups-list div.action a.group-button.leave-group:before',
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action a.group-button.leave-group:before',
				'#buddypress:not(.youzer) div.action a.remove-invite:before',
				'#buddypress:not(.youzer) #members-list div.action a.remove-invite:before',
				'#buddypress:not(.youzer) #groups-list div.action a.remove-invite:before',
				'#buddypress:not(.youzer) #friend-list div.action a.remove-invite:before',
				'#buddypress:not(.youzer) #mods-list div.action a.remove-invite:before',
				'#buddypress:not(.youzer) #admins-list div.action a.remove-invite:before',
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action a.remove-invite:before',

				'#buddypress:not(.youzer) div.action a.unfollow:hover:before',
				'#buddypress:not(.youzer) #members-list div.action a.unfollow:hover:before',
				'#buddypress:not(.youzer) #friend-list div.action a.unfollow:hover:before',
				'#buddypress:not(.youzer) #mods-list div.action a.unfollow:hover:before',
				'#buddypress:not(.youzer) #admins-list div.action a.unfollow:hover:before',
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action a.unfollow:hover:before',

				'#buddypress:not(.youzer) div.action a.bpmts-report-button:before',
				'#buddypress:not(.youzer) #members-list div.action a.bpmts-report-button:before',
				'#buddypress:not(.youzer) #friend-list div.action a.bpmts-report-button:before',
				'#buddypress:not(.youzer) #mods-list div.action a.bpmts-report-button:before',
				'#buddypress:not(.youzer) #admins-list div.action a.bpmts-report-button:before',
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action a.bpmts-report-button:before',

				'.card-body-meta .banned',

				'#buddypress:not(.youzer) div.action .bptk-block-profile a:before',
				'#buddypress:not(.youzer) div.action .bptk-block-list a:before',
				'#buddypress:not(.youzer) #members-list div.action .bptk-block-profile a:before',
				'#buddypress:not(.youzer) #members-list div.action .bptk-block-list a:before',
				'#buddypress:not(.youzer) #friend-list div.action .bptk-block-profile a:before',
				'#buddypress:not(.youzer) #friend-list div.action .bptk-block-list a:before',
				'#buddypress:not(.youzer) #mods-list div.action .bptk-block-profile a:before',
				'#buddypress:not(.youzer) #mods-list div.action .bptk-block-list a:before',
				'#buddypress:not(.youzer) #admins-list div.action .bptk-block-profile a:before',
				'#buddypress:not(.youzer) #admins-list div.action .bptk-block-list a:before',
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action .bptk-block-profile a:before',
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action .bptk-block-list a:before',
			) );

			$background_color_elements = apply_filters( 'grimlock_buddypress_delete_button_background_color_elements', array(
				'.grimlock-nav-menu-section .menu .menu-item.danger i',
				'.grimlock-nav-menu-section .menu .menu-item.danger .icon-wrapper:before',
				'.grimlock-nav-menu-section .menu .menu-item.danger .icon-wrapper:after',
			) );

			$outputs = apply_filters( 'grimlock_buddypress_delete_button_background_color_outputs', array(
				$this->get_css_var_output( 'delete_button_background_color' ),
				array(
					'element'  => implode( ',', $color_elements ),
					'property' => 'color',
				),
				array(
					'element'  => implode( ',', $background_color_elements ),
					'property' => 'background-color',
				),
				array(
					'element'  => implode( ',', array(
						'.buddypress.grimlock-buddypress--groups-actions-text-displayed #site div.action a.group-button.leave-group',
						'.buddypress.grimlock-buddypress--groups-actions-text-displayed #site #groups-list div.action a.group-button.leave-group',
						'.buddypress.grimlock-buddypress--groups-actions-text-displayed #site div#item-header #profile-header #item-buttons.action a.group-button.leave-group',
						'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #buddypress:not(.youzer) .bp-card-list--members div.action a.reject',
						'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #buddypress:not(.youzer) .bp-card-list--members div.action a.is_friend.remove:hover',
						'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #buddypress:not(.youzer) .bp-card-list--members div.action a.admin-demote-to-member',
						'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #buddypress:not(.youzer) .bp-card-list--members div.action a.mod-demote-to-member',
						'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #buddypress:not(.youzer) .bp-card-list--members div.action a.remove:not(.is_friend)',
						'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #buddypress:not(.youzer) .bp-card-list--members div.action a.friendship-button.requested:hover',
						'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #buddypress:not(.youzer) .bp-card-list--members div.action a.remove-invite',
						'.buddypress.grimlock-buddypress--members-actions-text-displayed #site div#item-header #profile-header.profile-header--member #item-buttons.action a.reject',
						'.buddypress.grimlock-buddypress--members-actions-text-displayed #site div#item-header #profile-header.profile-header--member #item-buttons.action a.remove:not(.is_friend)',
						'.buddypress.grimlock-buddypress--members-actions-text-displayed #site div#item-header #profile-header.profile-header--member #item-buttons.action a.friendship-button.requested:hover',
						'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #groups-list div.action a.reject',
					) ),
					'property' => 'background',
					'suffix'   => '!important',
				),
			), $background_color_elements, $color_elements );

			$args = wp_parse_args( $args, array(
				'type'      => 'color',
				'label'     => esc_html__( 'Delete Buttons Color', 'grimlock-buddypress' ),
				'section'   => $this->section,
				'settings'  => 'delete_button_background_color',
				'default'   => $this->get_default( 'delete_button_background_color' ),
				'choices'   => array(
					'alpha'    => false,
					'palettes' => apply_filters( 'grimlock_color_field_palettes', array() ),
				),
				'priority'  => 10,
				'transport' => 'postMessage',
				'js_vars'   => $this->to_js_vars( $outputs ),
				'output'    => $outputs,
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_buddypress_delete_button_background_color_field_args', $args ) );
		}
	}

	/**
	 * Add a Kirki color field to set the color in the Customizer.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args The array of arguments for the Kirki field.
	 */
	protected function add_miscellaneous_actions_button_background_color_field( $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			$color_elements = apply_filters( 'grimlock_buddypress_miscellaneous_actions_button_color_elements', array(
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action > div > a',
				'#buddypress:not(.youzer) #activity-stream.grimlock-buddypress-activity-list .activity-item .unfav',
				'#buddypress:not(.youzer) #activity-stream.grimlock-buddypress-activity-list .activity-item .fav',
				'#buddypress:not(.youzer) #activity-stream.grimlock-buddypress-activity-list .activity-item .unfav:before',
				'#buddypress:not(.youzer) #activity-stream.grimlock-buddypress-activity-list .activity-item .unfav:after',
				'#buddypress:not(.youzer) #activity-stream.grimlock-buddypress-activity-list .activity-item .fav:before',
				'#buddypress:not(.youzer) #activity-stream.grimlock-buddypress-activity-list .activity-item .fav:after',
				'#buddypress:not(.youzer) div.action a.mention:before',
				'#buddypress:not(.youzer) #members-list div.action a.mention:before',
				'#buddypress:not(.youzer) #friend-list div.action a.mention:before',
				'#buddypress:not(.youzer) #mods-list div.action a.mention:before',
				'#buddypress:not(.youzer) #admins-list div.action a.mention:before',
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action a.mention:before',
				'#buddypress:not(.youzer) div.action .loading a:after',
				'#buddypress:not(.youzer) div.action a.loading:after',
				'#buddypress:not(.youzer) a.poke-user-button:before',
				'#buddypress:not(.youzer) a.add-review:before',
				'#buddypress:not(.youzer) .card-body-actions.action div > a',
				'#buddypress:not(.youzer) div.action a.follow:focus:before',
				'#buddypress:not(.youzer) div.action a.unfollow:focus:before',
				'#buddypress:not(.youzer) #members-list div.action a.follow:focus:before',
				'#buddypress:not(.youzer) #members-list div.action a.unfollow:focus:before',
				'#buddypress:not(.youzer) #friend-list div.action a.follow:focus:before',
				'#buddypress:not(.youzer) #friend-list div.action a.unfollow:focus:before',
				'#buddypress:not(.youzer) #mods-list div.action a.follow:focus:before',
				'#buddypress:not(.youzer) #mods-list div.action a.unfollow:focus:before',
				'#buddypress:not(.youzer) #admins-list div.action a.follow:focus:before',
				'#buddypress:not(.youzer) #admins-list div.action a.unfollow:focus:before',
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action a.follow:focus:before',
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action a.unfollow:focus:before',
				'#buddypress:not(.youzer) div.action a.group-button.membership-requested:before',
				'#buddypress:not(.youzer) #groups-list div.action a.group-button.membership-requested:before',
				'#buddypress:not(.youzer) div#item-header #profile-header #item-buttons.action a.group-button.membership-requested:before',
			) );

			$background_color_elements = apply_filters( 'grimlock_buddypress_miscellaneous_actions_button_background_color_elements', array(
				'.grimlock-nav-menu-section .menu .menu-item i',
				'.grimlock-nav-menu-section .menu .menu-item .icon-wrapper:before',
				'.grimlock-nav-menu-section .menu .menu-item .icon-wrapper:after',
			) );

			$background_elements = apply_filters( 'grimlock_buddypress_miscellaneous_actions_button_background_elements', array(
				'.buddypress.grimlock-buddypress--groups-actions-text-displayed #site div.action a.group-button',
				'.buddypress.grimlock-buddypress--groups-actions-text-displayed #site div.action a.group-button.membership-requested',
				'.buddypress.grimlock-buddypress--groups-actions-text-displayed #site #groups-list div.action a.group-button.membership-requested',
				'.buddypress.grimlock-buddypress--groups-actions-text-displayed #site div#item-header #profile-header #item-buttons.action a.group-button.membership-requested',

				'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #buddypress:not(.youzer) .bp-card-list--members div.action a',
				'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #buddypress:not(.youzer) .bp-card-list--members div.action a.add-review',
				'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #buddypress:not(.youzer) .bp-card-list--members div.action a.follow',
				'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #buddypress:not(.youzer) .bp-card-list--members div.action a.unfollow',
				'.buddypress.grimlock-buddypress--members-actions-text-displayed #site div#item-header #profile-header.profile-header--member #item-buttons.action a',
				'.buddypress.grimlock-buddypress--members-actions-text-displayed #site div#item-header #profile-header.profile-header--member #item-buttons.action a.follow',
				'.buddypress.grimlock-buddypress--members-actions-text-displayed #site div#item-header #profile-header.profile-header--member #item-buttons.action a.unfollow',
				'.buddypress.grimlock-buddypress--members-actions-text-displayed #site div#item-header #profile-header.profile-header--member #item-buttons.action a.mention',
				'.buddypress.grimlock-buddypress--members-actions-text-displayed #site div#item-header #profile-header.profile-header--member #item-buttons.action a.poke-user-button',
				'.buddypress.grimlock-buddypress--members-actions-text-displayed #site div#item-header #profile-header.profile-header--member #item-buttons.action a.add-review',
				'.buddypress.grimlock-buddypress--members-actions-text-displayed #site #buddypress:not(.youzer) .bp-card-list--members div.action a.member-ban',

			) );

			$outputs = apply_filters( 'grimlock_buddypress_miscellaneous_actions_button_background_color_outputs', array(
				$this->get_css_var_output( 'miscellaneous_actions_button_background_color' ),
				array(
					'element'  => implode( ',', $color_elements ),
					'property' => 'color',
				),
				array(
					'element'  => implode( ',', $background_color_elements ),
					'property' => 'background-color',
				),
				array(
					'element'  => implode( ',', $background_elements ),
					'property' => 'background',
					'suffix'   => '!important',
				),
			), $background_color_elements, $color_elements, $background_elements );

			$args = wp_parse_args( $args, array(
				'type'      => 'color',
				'label'     => esc_html__( 'Miscellaneous Buttons Color', 'grimlock-buddypress' ),
				'section'   => $this->section,
				'settings'  => 'miscellaneous_actions_button_background_color',
				'default'   => $this->get_default( 'miscellaneous_actions_button_background_color' ),
				'choices'   => array(
					'alpha'    => false,
					'palettes' => apply_filters( 'grimlock_color_field_palettes', array() ),
				),
				'priority'  => 10,
				'transport' => 'postMessage',
				'js_vars'   => $this->to_js_vars( $outputs ),
				'output'    => $outputs,
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_buddypress_miscellaneous_actions_button_background_color_field_args', $args ) );
		}
	}

	/**
	 * Add a Kirki color field to set the background color of the profile header in the Customizer.
	 *
	 * @param array $args
	 * @since 1.0.0
	 */
	protected function add_profile_header_background_color_field( $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			$elements = apply_filters( 'grimlock_buddypress_background_color_elements', array(
				'#buddypress #header-cover-image',
			) );

			$outputs = apply_filters( 'grimlock_buddypress_background_color_outputs', array(
				$this->get_css_var_output( 'profile_header_background_color' ),
				array(
					'element'  => implode( ',', $elements ),
					'property' => 'background-color',
					'suffix'   => '!important',
				),
				array(
					'element'       => implode( ',', array(
						'.buddypress.groups.single-item .entry-content > #buddypress:not(.youzer):after',
						'.buddypress.bp-user:not(.activity-permalink) .entry-content > #buddypress:not(.youzer):after',
					) ),
					'property'      => 'background-image',
					'value_pattern' => 'linear-gradient(15deg, $ 50%, rgba(255,255,255,0) 100%)',
					'suffix'        => '!important',
				),
			), $elements );

			$args = wp_parse_args( $args, array(
				'type'      => 'color',
				'label'     => esc_html__( 'Profile Header Background Color', 'grimlock-buddypress' ),
				'section'   => $this->section,
				'settings'  => 'profile_header_background_color',
				'default'   => $this->get_default( 'profile_header_background_color' ),
				'choices'   => array(
					'alpha'    => true,
					'palettes' => apply_filters( 'grimlock_color_field_palettes', array() ),
				),
				'priority'  => 10,
				'transport' => 'postMessage',
				'js_vars'   => $this->to_js_vars( $outputs ),
				'output'    => $outputs,
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_buddypress_background_color_field_args', $args ) );
		}
	}

	/**
	 * Add a Kirki color field to set the color of the profile header text in the Customizer.
	 *
	 * @since 1.0.6
	 *
	 * @param array $args
	 */
	protected function add_profile_header_text_color_field( $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			$elements = apply_filters( 'grimlock_buddypress_profile_header_text_color_elements', array(
				'#buddypress:not(.youzer) div#item-header #profile-header',
			) );

			$outputs = apply_filters( 'grimlock_buddypress_profile_header_text_color_outputs', array(
				$this->get_css_var_output( 'profile_header_text_color' ),
				array(
					'element'  => $elements,
					'property' => 'color',
					'suffix'   => '!important',
				),
				array(
					'element'  => implode( ',', array(
						'.pmpro_bp_show_level_on_bp_profile > strong',
					) ),
					'property' => 'background-color',
				),
				array(
					'element'  => implode( ',', array(
						'#buddypress:not(.youzer) #members-following-personal-li > a',
						'#buddypress:not(.youzer) #members-followers-personal-li > a',
						'#buddypress:not(.youzer) #members-following-personal-li > a:hover',
						'#buddypress:not(.youzer) #members-followers-personal-li > a:hover',
					) ),
					'property'    => 'color',
					'suffix'      => '!important',
					'media_query' => '@media (min-width: 992px)',
				),
			), $elements );

			$args = wp_parse_args( $args, array(
				'type'      => 'color',
				'label'     => esc_html__( 'Profile Header Text Color', 'grimlock-buddypress' ),
				'section'   => $this->section,
				'settings'  => 'profile_header_text_color',
				'default'   => $this->get_default( 'profile_header_text_color' ),
				'choices'   => array(
					'alpha'    => true,
					'palettes' => apply_filters( 'grimlock_color_field_palettes', array() ),
				),
				'priority'  => 10,
				'transport' => 'postMessage',
				'js_vars'   => $this->to_js_vars( $outputs ),
				'output'    => $outputs,
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_buddypress_profile_header_text_color_field_args', $args ) );
		}
	}

	/**
	 * Add a Kirki section in the Customizer.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args The array of arguments for the Kirki section.
	 */
	protected function add_section( $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			Kirki::add_section( $this->section, apply_filters( "{$this->section}_args", array(
				'title'    => $this->title,
				'priority' => isset( $args['priority'] ) ? $args['priority'] : 10,
			) ) );
		}
	}

	/**
	 * Add a Kirki select control to change the members per page
	 *
	 * @param array $args
	 * @since 1.0.8
	 */
	protected function add_members_per_page_field( $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			$args = wp_parse_args( $args, array(
				'type'      => 'select',
				'section'   => $this->section,
				'label'     => esc_html__( 'Members per Page', 'grimlock-buddypress' ),
				'settings'  => 'members_per_page',
				'default'   => $this->get_default( 'members_per_page' ),
				'priority'  => 10,
				'transport' => 'refresh',
				'choices'   => array(
					'12' => '12',
					'24' => '24',
					'36' => '36',
					'48' => '48',
				),
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_buddypress_customizer_members_per_page_field_args', $args ) );
		}
	}

	/**
	 * Add a Kirki image field to set the default cover image for the BuddyPress groups
	 *
	 * @param array $args
	 * @since 1.0.6
	 */
	protected function add_default_profile_cover_image_field( $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			$args = wp_parse_args( $args, array(
				'type'     => 'image',
				'section'  => $this->section,
				'label'    => esc_html__( 'Default Profile Cover', 'grimlock-buddypress' ),
				'settings' => 'default_profile_cover_image',
				'default'  => $this->get_default( 'default_profile_cover_image' ),
				'priority' => 10,
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_buddypress_customizer_default_profile_cover_image_field_args', $args ) );
		}
	}

	/**
	 * Add a Kirki select control to change the name format displayed in members profiles
	 *
	 * @param array $args
	 * @since 1.0.6
	 */
	protected function add_member_displayed_name_field( $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			$args = wp_parse_args( $args, array(
				'type'     => 'select',
				'section'  => $this->section,
				'label'    => esc_html__( 'Displayed Name on Profile', 'grimlock-buddypress' ),
				'settings' => 'member_displayed_name',
				'default'  => $this->get_default( 'member_displayed_name' ),
				'priority' => 10,
				'choices'  => array(
					'fullname'          => esc_html__( 'Full Name', 'grimlock-buddypress' ),
					'username'          => esc_html__( 'Username', 'grimlock-buddypress' ),
					'fullname_username' => esc_html__( 'Full Name + Username', 'grimlock-buddypress' ),
				),
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_buddypress_customizer_member_displayed_name_field_args', $args ) );
		}
	}

	/**
	 * Add a Kirki select control to change the groups per page
	 *
	 * @param array $args
	 * @since 1.0.8
	 */
	protected function add_groups_per_page_field( $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			$args = wp_parse_args( $args, array(
				'type'      => 'select',
				'section'   => $this->section,
				'label'     => esc_html__( 'Groups per Page', 'grimlock-buddypress' ),
				'settings'  => 'groups_per_page',
				'default'   => $this->get_default( 'groups_per_page' ),
				'priority'  => 10,
				'transport' => 'refresh',
				'choices'   => array(
					'12' => '12',
					'20' => '20',
					'24' => '24',
					'36' => '36',
					'48' => '48',
				),
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_buddypress_customizer_groups_per_page_field_args', $args ) );
		}
	}

	/**
	 * Add a Kirki image field to set the default cover image for the BuddyPress groups
	 *
	 * @param array $args
	 * @since 1.0.6
	 */
	protected function add_default_group_cover_image_field( $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			$args = wp_parse_args( $args, array(
				'type'     => 'image',
				'section'  => $this->section,
				'label'    => esc_html__( 'Default Group Cover', 'grimlock-buddypress' ),
				'settings' => 'default_group_cover_image',
				'default'  => $this->get_default( 'default_group_cover_image' ),
				'priority' => 10,
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_buddypress_customizer_default_group_cover_image_field_args', $args ) );
		}
	}

	/**
	 * Change the settings for the BuddyPress cover image.
	 *
	 * @param array $settings The array of default settings for the BuddyPress cover image.
	 *
	 * @return array           The array of settings for the BuddyPress cover image.
	 */
	public function change_xprofile_cover_image_settings( $settings = array() ) {
		$settings['default_cover'] = $this->get_theme_mod( 'default_profile_cover_image' );
		$settings['width']         = get_custom_header()->width;
		$settings['height']        = get_custom_header()->height;
		return $settings;
	}

	/**
	 * Return the type of name that should be displayed on BuddyPress profiles
	 *
	 * @return string The type of name that should be displayed
	 */
	public function member_displayed_name() {
		return $this->get_theme_mod( 'member_displayed_name' );
	}

	/**
	 * Change the settings for the BuddyPress group cover image.
	 *
	 * @param  array $settings The array of default settings for the BuddyPress cover image.
	 *
	 * @return array           The array of settings for the BuddyPress cover image.
	 */
	public function change_groups_cover_image_settings( $settings = array() ) {
		$settings['default_cover'] = $this->get_theme_mod( 'default_group_cover_image' );
		$settings['width']         = get_custom_header()->width;
		$settings['height']        = get_custom_header()->height;
		return $settings;
	}

	/**
	 * Change members/groups per page using customizer value
	 *
	 * @param string $query_string The query string used by BuddyPress to build the members/groups query
	 * @param string $object       Whether this query is for members or groups
	 *
	 * @return string The modified query string
	 */
	public function change_members_groups_per_page( $query_string, $object ) {
		switch( $object ) {
			case 'members':
			case 'groups':
				$per_page = $this->get_theme_mod( "{$object}_per_page" );
				break;
			default:
				return $query_string;
		}

		if ( ! empty( $per_page ) ) {
			$query_args = explode( '&', $query_string );

			foreach ( $query_args as $key => $query_arg ) {
				if ( strpos( $query_arg, 'per_page' ) !== false ) {
					unset( $query_args[ $key ] );
				}
			}

			$query_args[] = "per_page={$per_page}";

			$query_string = implode( '&', $query_args );
		}

		return $query_string;
	}

	/**
	 * Return groups per page
	 */
	public function groups_per_page() {
		return $this->get_theme_mod( 'groups_per_page' );
	}

	/**
	 * Return members per page
	 */
	public function members_per_page() {
		return $this->get_theme_mod( 'members_per_page' );
	}

	/**
	 * Add custom classes to body to modify friend icons.
	 *
	 * @since 1.0.5
	 * @param array $classes The array of body classes.
	 *
	 * @return array The updated array of body classes.
	 */
	public function add_body_classes( $classes ) {
		$members_actions_text_displayed = $this->get_theme_mod( 'members_actions_text_displayed' );
		$groups_actions_text_displayed  = $this->get_theme_mod( 'groups_actions_text_displayed' );

		if ( ! empty( $members_actions_text_displayed ) ) {
			$classes[] = 'grimlock-buddypress--members-actions-text-displayed';
		}

		if ( ! empty( $groups_actions_text_displayed ) ) {
			$classes[] = 'grimlock-buddypress--groups-actions-text-displayed';
		}

		$classes[] = "grimlock-buddypress--friend-icons-{$this->get_theme_mod( 'friend_icons' )}";
		return $classes;
	}

	/**
	 * Display xprofile fields in members using theme mods
	 *
	 * @param int $user_id The id of the user.
	 */
	public function add_member_custom_fields( $user_id ) {
		if ( function_exists( 'buddypress' ) && bp_is_active( 'xprofile' ) ) {
			$field_ids = $this->get_theme_mod( 'members_displayed_profile_fields' );

			if ( empty( $user_id ) ) {
				$user_id = bp_get_member_user_id();
			}

			if ( empty( $user_id ) ) {
				$user_id = bp_displayed_user_id();
			}

			$allowed_html = array(
				'a' => array(
					'href' => array(),
					'rel'  => array(),
				),
			);

			foreach ( $field_ids as $field_id ) {
				$field = xprofile_get_field( $field_id, $user_id, false );

				if ( ! empty( $field ) ) {

					$visibility = xprofile_get_field_visibility_level( $field->id, $user_id );

					$is_visible =
						'public' === $visibility ||
						get_current_user_id() === intval( $user_id ) ||
						current_user_can( 'administrator' ) ||
						( 'loggedin' === $visibility && is_user_logged_in() ) ||
						( bp_is_active( 'friends' ) && 'friends' === $visibility && friends_check_friendship( $user_id, get_current_user_id() ) );

					if ( ! $is_visible ) {
						continue;
					}

					$value = xprofile_get_field_data( $field->id, $user_id, 'comma' );

					switch ( $field->type ) {
						case 'datebox':
							$date_field_settings = BP_XProfile_Field_Type_Datebox::get_field_settings( $field->id );

							if ( 'elapsed' !== $date_field_settings['date_format'] ) :
								$date_object = DateTime::createFromFormat( $date_field_settings['date_format'], $value );
								if ( ! empty( $date_object ) ) :
									$value = $date_object->diff( new DateTime( 'now' ) )->y;
								endif;
							endif;
							break;
					}

					if ( ! empty( $value ) ) {
						echo '<div class="bp-member-xprofile-custom-field bp-member-' . esc_attr( $field->name ) . '">' . wp_kses( $value, $allowed_html ) . '</div>';
					}
				}
			}
		}
	}

	/**
	 * Check whether BP group action text need to be displayed.
	 *
	 * @since 1.0.5
	 *
	 * @param  bool $default The value for the text display.
	 *
	 * @return bool          True if the text needs to be displayed, false otherwise.
	 */
	public function is_groups_actions_text_displayed( $default ) {
		return (bool) $this->get_theme_mod( 'groups_actions_text_displayed' );
	}

	/**
	 * Check whether BP member action text need to be displayed.
	 *
	 * @since 1.0.5
	 *
	 * @param  bool $default The value for the text display.
	 *
	 * @return bool          True if the text needs to be displayed, false otherwise.
	 */
	public function is_members_actions_text_displayed( $default ) {
		return (bool) $this->get_theme_mod( 'members_actions_text_displayed' );
	}

	/**
	 * Check whether navbar friends icon need to be displayed.
	 *
	 * @since 1.1.0
	 *
	 * @param  bool $default The value for the icon display.
	 *
	 * @return bool          True if the icon needs to be displayed, false otherwise.
	 */
	public function is_navbar_nav_menu_item_friends_displayed( $default ) {
		return (bool) $this->get_theme_mod( 'navbar_nav_menu_item_friends_displayed' );
	}

	/**
	 * Check whether navbar groups icon need to be displayed.
	 *
	 * @since 1.1.0
	 *
	 * @param  bool $default The value for the icon display.
	 *
	 * @return bool          True if the icon needs to be displayed, false otherwise.
	 */
	public function is_navbar_nav_menu_item_groups_displayed( $default ) {
		return (bool) $this->get_theme_mod( 'navbar_nav_menu_item_groups_displayed' );
	}

	/**
	 * Check whether navbar notifications icon need to be displayed.
	 *
	 * @since 1.1.0
	 *
	 * @param  bool $default The value for the icon display.
	 *
	 * @return bool          True if the icon needs to be displayed, false otherwise.
	 */
	public function is_navbar_nav_menu_item_notifications_displayed( $default ) {
		return (bool) $this->get_theme_mod( 'navbar_nav_menu_item_notifications_displayed' );
	}

	/**
	 * Check whether navbar messages icon need to be displayed.
	 *
	 * @since 1.1.0
	 *
	 * @param  bool $default The value for the icon display.
	 *
	 * @return bool          True if the icon needs to be displayed, false otherwise.
	 */
	public function is_navbar_nav_menu_item_messages_displayed( $default ) {
		return (bool) $this->get_theme_mod( 'navbar_nav_menu_item_messages_displayed' );
	}

	/**
	 * Check whether navbar settings icon need to be displayed.
	 *
	 * @since 1.1.0
	 *
	 * @param  bool $default The value for the icon display.
	 *
	 * @return bool          True if the icon needs to be displayed, false otherwise.
	 */
	public function is_navbar_nav_menu_item_settings_displayed( $default ) {
		return (bool) $this->get_theme_mod( 'navbar_nav_menu_item_settings_displayed' );
	}
}

return new Grimlock_BuddyPress_Customizer();
