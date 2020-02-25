<?php
/**
 * Cera_Grimlock_Archive_Customizer Class
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
 * The post archive page class for the Customizer.
 */
class Cera_Grimlock_Archive_Customizer {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'grimlock_archive_customizer_defaults',                       array( $this, 'change_defaults'                    ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_thumbnail_size',            array( $this, 'change_post_thumbnail_size'         ), 10, 2 );
		add_filter( 'grimlock_archive_customizer_elements',                       array( $this, 'add_elements'                       ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_background_color_elements', array( $this, 'add_post_background_color_elements' ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_background_color_outputs',  array( $this, 'add_post_background_color_outputs'  ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_color_elements',            array( $this, 'add_post_color_elements'            ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_color_outputs',             array( $this, 'add_post_color_outputs'             ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_padding_outputs',           array( $this, 'add_post_padding_outputs'           ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_border_color_outputs',      array( $this, 'add_post_border_color_outputs'      ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_border_width_outputs',      array( $this, 'add_post_border_width_outputs'      ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_box_shadow_color_outputs',  array( $this, 'add_post_box_shadow_color_outputs'  ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_title_color_elements',      array( $this, 'add_post_title_color_elements'      ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_link_color_elements',       array( $this, 'add_post_link_color_elements'       ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_link_hover_color_elements', array( $this, 'add_post_link_hover_color_elements' ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_link_hover_color_outputs',  array( $this, 'add_post_link_hover_color_outputs'  ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_border_radius_elements',    array( $this, 'add_post_border_radius_elements'    ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_border_radius_outputs',     array( $this, 'add_post_border_radius_outputs'     ), 10, 1 );
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

		$defaults['archive_custom_header_displayed']        = true;
		$defaults['archive_custom_header_layout']           = CERA_ARCHIVE_CUSTOM_HEADER_LAYOUT;
		$defaults['archive_custom_header_container_layout'] = CERA_ARCHIVE_CUSTOM_HEADER_CONTAINER_LAYOUT;

		$defaults['archive_post_tag_terms_displayed']    = false;
		$defaults['archive_category_terms_displayed']    = true;
		$defaults['archive_post_format_terms_displayed'] = false;
		$defaults['archive_post_date_displayed']         = true;
		$defaults['archive_post_author_displayed']       = true;
		$defaults['archive_post_more_link_displayed']    = true;
		$defaults['archive_post_tag_displayed']          = false;
		$defaults['archive_category_displayed']          = true;
		$defaults['archive_post_format_displayed']       = true;
		$defaults['archive_post_thumbnail_displayed']    = true;
		$defaults['archive_post_content_displayed']      = false;
		$defaults['archive_post_excerpt_displayed']      = true;
		$defaults['archive_comments_link_displayed']     = true;

		$defaults['archive_post_padding']                 = CERA_CARD_PADDING;
		$defaults['archive_post_margin']                  = CERA_CARD_MARGIN;
		$defaults['archive_post_background_color']        = CERA_CARD_BACKGROUND;
		$defaults['archive_post_border_radius']           = CERA_CARD_BORDER_RADIUS;
		$defaults['archive_post_thumbnail_border_radius'] = CERA_CARD_BORDER_RADIUS;
		$defaults['archive_post_border_width']            = CERA_CARD_BORDER_WIDTH;
		$defaults['archive_post_border_color']            = CERA_CARD_BORDER_COLOR;

		$defaults['archive_post_border_color'] = CERA_CARD_BORDER_COLOR;

		$defaults['archive_post_box_shadow_x_offset']      = CERA_BOX_SHADOW_X_OFFSET;
		$defaults['archive_post_box_shadow_y_offset']      = CERA_BOX_SHADOW_Y_OFFSET;
		$defaults['archive_post_box_shadow_blur_radius']   = CERA_BOX_SHADOW_BLUR_RADIUS;
		$defaults['archive_post_box_shadow_spread_radius'] = CERA_BOX_SHADOW_SPREAD_RADIUS;
		$defaults['archive_post_box_shadow_color']         = CERA_BOX_SHADOW_COLOR;

		$defaults['archive_post_color']            = CERA_CARD_COLOR;
		$defaults['archive_post_title_color']      = CERA_CARD_TITLE_COLOR;
		$defaults['archive_post_link_color']       = CERA_CARD_LINK_COLOR;
		$defaults['archive_post_link_hover_color'] = CERA_CARD_LINK_HOVER_COLOR;

		$defaults['archive_layout']                 = CERA_ARCHIVE_LAYOUT;
		$defaults['archive_container_layout']       = CERA_ARCHIVE_CONTAINER_LAYOUT;
		$defaults['archive_posts_layout']           = CERA_ARCHIVE_POSTS_LAYOUT;
		$defaults['archive_posts_height_equalized'] = CERA_ARCHIVE_POSTS_HEIGHT_EQUALIZED;

		$defaults['archive_custom_header_padding_y'] = CERA_HEADER_PADDING_Y;
		$defaults['archive_content_padding_y']       = CERA_CONTENT_PADDING_Y;

		return $defaults;
	}

	/**
	 * Change default post thumbnail sizes for the archive.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $size         The size for the post thumbnail.
	 * @param  string $posts_layout The layout for the archive posts.
	 *
	 * @return string               The updated size for the post thumbnail.
	 */
	public function change_post_thumbnail_size( $size, $posts_layout ) {
		return "thumbnail-{$posts_layout}";
	}

	/**
	 * Add CSS selectors from the array of CSS selectors for the archive post.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the archive post.
	 *
	 * @return array           The updated array of CSS selectors for the archive post.
	 */
	public function add_elements( $elements ) {
		return array_merge( $elements, array(
			'.card',
			'.bg-card',
			'.comment-body',
			'.card.card-static',
			'.comment-respond',
			'.single .wp-playlist-light',
			'.wp-block-latest-posts li',
			'.wp-block-categories.wp-block-categories-list > li',
			'.wp-block-archives.wp-block-archives-list > li',
			'article[id*="post-"] > .entry-content > #loginform',
			'.modal .modal-content',
			'.grimlock-section.section--boxed.section_content_reveal .region__col--2 > div',
			'.grimlock--page-content',
			'.posts-filters',
			'.posts-filters .priority-nav__dropdown',
			'.posts-filters .priority-nav__dropdown',
			'#secondary-left .widget',
			'#secondary-right .widget',
			'.page-template-template-dashboard #main .widget-area .widget',
			// TODO: Migrate to BPS Class.
			'#buddypress > .pos-r  > .bps_form',
		) );
	}

	/**
	 * Add CSS selectors from the array of CSS selectors for the archive post background color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the archive post background color.
	 *
	 * @return array           The updated array of CSS selectors for the archive post background color.
	 */
	public function add_post_background_color_elements( $elements ) {
		return array_merge( $elements, array(
			'.testimonials-list .quote .testimonials-text',
			'.grimlock-section.section--boxed .region__col--2',
			'.list-group-item',
			'.widget_grimlock_nav_menu_section .grimlock-section:not(.region--8-4-cols-grid) .menu .menu-item > a:before',
			'ul.wpp-list li > a:not(.wpp-post-title):before',
		) );
	}

	/**
	 * Add CSS selectors from the array of CSS selectors for the archive post color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the archive post color.
	 *
	 * @return array           The updated array of CSS selectors for the archive post color.
	 */
	public function add_post_color_elements( $elements ) {
		return array_merge( $elements, array(
			'.card',
			'.grimlock-section.section--boxed .region__col--2',
			'.testimonials-list .quote .testimonials-text',
			'.list-group-item',
		) );
	}

	/**
	 * Add selectors and properties to the CSS rule-set for the archive post background color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $outputs The array of CSS selectors and properties for the archive post background color.
	 *
	 * @return array          The updated array of CSS selectors for the archive post background color.
	 */
	public function add_post_background_color_outputs( $outputs ) {
		return array_merge( $outputs, array(
			array(
				'element'  => implode( ',', array(
					'.card .card-body-labels .badge',
				) ),
				'property' => 'border-color',
				'suffix'   => '!important',
			),
			array(
				'element'  => implode( ',', array(
					// TODO: Migrate to LearnDash Class.
					'.learndash-wrapper .ld-course-navigation .ld-lesson-item-expanded::before',
				) ),
				'property' => 'border-top-color',
			),
			array(
				'element'  => implode( ',', array(
					'.grimlock--navigation-fixed-left .hamburger-navbar',
					'.grimlock--navigation-fixed-right .hamburger-navbar',
				) ),
				'property'    => 'background-color',
				'media_query' => '@media (min-width: 992px)',
				'suffix'      => '!important',
			),
			array(
				'element'       => implode( ',', array(
					'.hamburger-navbar.main-navigation .navbar-nav.navbar-nav--buddypress .bubble-count',
				) ),
				'property'      => 'box-shadow',
				'value_pattern' => '0 0 0 3px $',
			),
		) );
	}

	/**
	 * Add selectors and properties to the CSS rule-set for the archive post color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $outputs The array of CSS selectors and properties for the archive post color.
	 *
	 * @return array          The updated array of CSS selectors for the archive post color.
	 */
	public function add_post_color_outputs( $outputs ) {
		return array_merge( $outputs, array(
			array(
				'element'  => implode( ',', array(
					'.btn.btn-link:after',
				) ),
				'property' => 'background-color',
			),
			array(
				'element'  => implode( ',', array(
					'.grimlock--navigation-fixed-left .hamburger-navbar',
					'.grimlock--navigation-fixed-right .hamburger-navbar',
				) ),
				'property' => 'color',
				'suffix'   => '!important',
				'media_query' => '@media (min-width: 992px)',
			),
		) );
	}

	/**
	 * Add selectors and properties to the CSS rule-set for the archive post padding.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $outputs The array of CSS selectors and properties for the archive post padding.
	 *
	 * @return array          The updated array of CSS selectors for the archive post padding.
	 */
	public function add_post_padding_outputs( $outputs ) {
		return array_merge( $outputs, array(
			array(
				'element'       => implode( ',', array(
					'.card .card-footer',
				) ),
				'property'      => 'padding-top',
				'value_pattern' => 'calc($px / 1.5)',
				'suffix'        => '!important',
			),
			array(
				'element'       => implode( ',', array(
					'.card .card-footer',
				) ),
				'property'      => 'padding-bottom',
				'value_pattern' => 'calc($px / 1.5)',
				'suffix'        => '!important',
			),
			array(
				'element'  => implode( ',', array(
					'.card .card-footer',
				) ),
				'property' => 'padding-left',
				'units'    => 'px',

			),
			array(
				'element'  => implode( ',', array(
					'.card .card-footer',
				) ),
				'property' => 'padding-right',
				'units'    => 'px',
			),
		) );
	}

	/**
	 * Add selectors and properties to the CSS rule-set for the archive post border color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $outputs The array of CSS selectors and properties for the archive post border color.
	 *
	 * @return array          The updated array of CSS selectors for the archive post border color.
	 */
	public function add_post_border_color_outputs( $outputs ) {
		return array_merge( $outputs, array(
			array(
				'element'  => implode( ',', array(
					'.modal .modal-header',
				) ),
				'property' => 'border-bottom-color',
			),
		) );
	}

	/**
	 * Add selectors and properties to the CSS rule-set for the archive post border width.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $outputs The array of CSS selectors and properties for the archive post border width.
	 *
	 * @return array          The updated array of CSS selectors for the archive post border width.
	 */
	public function add_post_border_width_outputs( $outputs ) {
		return array_merge( $outputs, array(
			array(
				'element'  => implode( ',', array(
					'.login-footer',
				) ),
				'property' => 'border-top-width',
				'units'    => 'px',
			),
		) );
	}

	/**
	 * Add selectors and properties to the CSS rule-set for the archive post border width.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $outputs The array of CSS selectors and properties for the archive post border width.
	 *
	 * @return array          The updated array of CSS selectors for the archive post border width.
	 */
	public function add_post_box_shadow_color_outputs( $outputs ) {
		return array_merge( $outputs, array(
			array(
				'element'       => implode( ',', array(
					'.card:not(.card-static):hover',
				) ),
				'property'      => 'box-shadow',
				'value_pattern' => '0 20px 20px $',
				'media_query'   => '@media (min-width: 768px)',
			),
			array(
				'element'       => implode( ',', array(
					'.widget_grimlock_nav_menu_section .grimlock-section:not(.region--8-4-cols-grid) .menu .menu-item > a:before',
					'body.single.single-post [id^="post-"] > .post-thumbnail img',
					'body.page [id^="post-"] > .post-thumbnail img',
				) ),
				'property'      => 'box-shadow',
				'value_pattern' => '0 0 20px $',
			),
		) );
	}

	/**
	 * Add CSS selectors from the array of CSS selectors for the archive post title color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the archive post title color.
	 *
	 * @return array           The updated array of CSS selectors for the archive post title color.
	 */
	public function add_post_title_color_elements( $elements ) {
		return array_merge( $elements, array(
			'.card .entry-title',
			'.card .entry-title a',
			'.card h1',
			'.card h2',
			'.card h3',
			'.card h4',
			'.card h5',
			'.card h6',
			'.wp-block-latest-posts li',
			'#buddypress .bboss_search_page ul.item-list li .entry-title',
			'#buddypress .bboss_search_page ul.item-list li .item-title',
			'#buddypress .bboss_search_page ul.item-list li .item-title a',
			'#buddypress .activity-list .activity-content .activity-header',
			'#buddypress .activity-list .activity-content .comment-header',
			'body:not([class*="yz-"]) #bbpress-forums ul.bbp-replies li .bbp-list-author .bbp-author-name',
			'#bbpress-forums fieldset.bbp-form legend',
			'#secondary-left .widget-title',
			'#secondary-right .widget-title',
			'.page-template-template-dashboard #main .widget-area .widget .widget-title',
		) );
	}

	/**
	 * Add CSS selectors from the array of CSS selectors for the archive post link color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the archive post link color.
	 *
	 * @return array           The updated array of CSS selectors for the archive post link color.
	 */
	public function add_post_link_color_elements( $elements ) {
		return array_merge( $elements, array(
			'.card .entry-summary a:not(.btn):not(.button)',
			'.card .entry-footer a:not(.btn):not(.button)',
			'.card .entry-content a:not(.btn):not(.button)',
			'.sidebar .widget a:not(:hover)',
		) );
	}

	/**
	 * Add CSS selectors from the array of CSS selectors for the archive post link color on hover.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the archive post link color on hover.
	 *
	 * @return array           The updated array of CSS selectors for the archive post link color on hover.
	 */
	public function add_post_link_hover_color_elements( $elements ) {
		return array_merge( $elements, array(
			'.card .entry-summary a:not(.btn):not(.button):hover',
			'.card .entry-footer a:not(.btn):not(.button):hover',
			'.card .entry-content a:not(.btn):not(.button):hover',
			'.card .card-body h2.card-body-title a:hover',
		) );
	}

	/**
	 * Add selectors and properties to the CSS rule-set for the archive post link color on hover.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $outputs The array of CSS selectors and properties for the archive post link color on hover.
	 *
	 * @return array          The updated array of CSS selectors for the archive post link color on hover.
	 */
	public function add_post_link_hover_color_outputs( $outputs ) {
		return array_merge( $outputs, array(
			array(
				'element'  => implode( ',', array(
					'[class*="grimlock--navigation-fixed-"] .hamburger-navbar ul.navbar-nav--hamburger-secondary-menu > li.menu-item:hover > a',
					'[class*="grimlock--navigation-fixed-"] .hamburger-navbar ul.navbar-nav--hamburger-secondary-menu > li.menu-item > a:hover',
					'[class*="grimlock--navigation-fixed-"] .hamburger-navbar ul.navbar-nav--hamburger-secondary-menu > li.menu-item > a:active',
					'[class*="grimlock--navigation-fixed-"] .hamburger-navbar ul.navbar-nav--hamburger-secondary-menu > li.menu-item > a:focus',
					'[class*="grimlock--navigation-fixed-"] .hamburger-navbar ul.navbar-nav--hamburger-secondary-menu > li.menu-item.current-menu-item > a',
					'[class*="grimlock--navigation-fixed-"] .hamburger-navbar ul.navbar-nav--hamburger-secondary-menu > li.current-menu-parent > a',
					'[class*="grimlock--navigation-fixed-"] .hamburger-navbar ul.navbar-nav--hamburger-secondary-menu > li.current-menu-ancestor > a',
				) ),
				'property'    => 'color',
				'media_query' => '@media (min-width: 992px)',
			),
		) );
	}

	/**
	 * Add CSS selectors from the array of CSS selectors for the archive post border radius.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the archive post border radius.
	 *
	 * @return array           The updated array of CSS selectors for the archive post border radius.
	 */
	public function add_post_border_radius_elements( $elements ) {
		return array_merge( $elements, array(
			'.rounded-card',
			'.grimlock-hero.region--12-cols-center-boxed .section__content',
			'img.avatar',
			'.site-preheader .menu > .menu-item .sub-menu',
			'.site-preheader .menu > .menu-item .sub-menu .sub-menu',
			'.main-navigation .navbar-nav .menu-item .sub-menu',
			'.main-navigation .navbar-nav .menu-item .sub-menu .sub-menu',
			'.site-preheader .menu > .menu-item .sub-menu',
			'.grimlock-section.section--boxed .region__col--2',
			'.main-navigation .navbar-nav > .menu-item .sub-menu .menu-item a',
			'.topic-tag .bbp-breadcrumb',
			'.widget_grimlock_nav_menu_section .region--8-4-cols-grid .menu .menu-item > a',
			'.dropdown-classic .dropdown-menu',
			'.widget_grimlock_nav_menu_section .grimlock-section:not(.region--8-4-cols-grid) .menu .menu-item > a:before',
			'body.single.single-post [id^="post-"] > .post-thumbnail img',
			'body.page [id^="post-"] > .post-thumbnail img',
			'ul.wpp-list .wpp-thumbnail',
			'.wpp-no-data',
			// TODO: Migrate to LearnDash Class.
			'.ld-course-info-my-courses',
			'[class*="sfwd-courses-widget"] ul li',
			'[class*="sfwd-quiz-widget"] ul li',
			'[class*="sfwd-lessons-widget"] ul li',

			// Coblocks
			'.wp-block-coblocks-alert',
			// TODO: Migrate to PMPro Class.
			'.pmpro-body-level-required .entry-content .pmpro_content_message',
		) );
	}

	/**
	 * Add selectors and properties to the CSS rule-set for the archive post border radius.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $outputs The array of CSS selectors and properties for the archive post border radius.
	 *
	 * @return array          The updated array of CSS selectors for the archive post border radius.
	 */
	public function add_post_border_radius_outputs( $outputs ) {
		return array_merge( $outputs, array(
			array(
				'element'  => implode( ',', array(
					'.off-center-image img',
				) ),
				'property' => 'border-top-right-radius',
				'units'    => 'rem',
			),
			array(
				'element'  => implode( ',', array(
					'.off-center-image img',
				) ),
				'property' => 'border-bottom-right-radius',
				'units'    => 'rem',
			),
			array(
				'element'  => implode( ',', array(
					'#buddypress form#whats-new-form textarea',
					'.widget_grimlock_nav_menu_section .grimlock-section:not(.region--8-4-cols-grid) .menu .menu-item > a:before',
				) ),
				'property' => 'border-radius',
				'units'    => 'rem',
				'suffix'   => '!important',
			),
			array(
				'element' => implode( ',', array(
					'.widget_grimlock_nav_menu_section .region--8-4-cols-grid .menu > .menu-item > a:not([class*="image"])',
				) ),
				'property'      => 'border-radius',
				'units'         => 'rem',
			),
			array(
				'element' => implode( ',', array(
					'ul.wpp-list li > a:not(.wpp-post-title):before',
				) ),
				'property'      => 'border-top-left-radius',
				'units'         => 'rem',
			),
			array(
				'element' => implode( ',', array(
					'ul.wpp-list li > a:not(.wpp-post-title):before',
				) ),
				'property'      => 'border-bottom-right-radius',
				'units'         => 'rem',
			),
		) );
	}
}

return new Cera_Grimlock_Archive_Customizer();
