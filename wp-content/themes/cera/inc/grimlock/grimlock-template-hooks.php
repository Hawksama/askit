<?php
/**
 * Cera template Hooks for Grimlock.
 *
 * @package cera
 */

/**
 * Before Site Hooks.
 *
 * @see cera_grimlock_before_site()
 *
 * @since 1.0.0
 */
remove_action( 'cera_before_site', 'cera_before_site',  10 );
add_action( 'cera_before_site', 'cera_grimlock_before_site', 10 );

/**
 * Header Hooks.
 *
 * @see cera_header()
 * @see cera_grimlock_header()
 * @see cera_grimlock_before_content()
 *
 * @since 1.0.0
 */
remove_action( 'cera_header', 'cera_header',                  10 );
add_action(    'cera_header', 'cera_grimlock_header',         10 );
add_action(    'cera_header', 'cera_grimlock_before_content', 20 );

/**
 * Navigation Hooks.
 *
 * @see cera_grimlock_navbar_nav_menu()
 * @see cera_grimlock_vertical_navbar_nav_menu()
 *
 * @since 1.0.0
 */
add_action( 'grimlock_navbar_nav_menu',                'cera_grimlock_navbar_nav_menu',           10,  1 );
add_action( 'grimlock_vertical_navbar_nav_menu',       'cera_grimlock_vertical_navbar_nav_menu',  10,  1 );
add_action( 'cera_grimlock_navbar_secondary_nav_menu', 'cera_grimlock_navbar_secondary_nav_menu',  1,  1 );

/**
 * Footer Hooks.
 *
 * @see cera_footer()
 * @see cera_grimlock_footer()
 * @see cera_grimlock_after_content()
 *
 * @since 1.0.0
 */
remove_action( 'cera_footer', 'cera_footer',                 10 );
add_action(    'cera_footer', 'cera_grimlock_after_content', 10 );
add_action(    'cera_footer', 'cera_grimlock_footer',        20 );

/**
 * After Site Hooks.
 *
 * @see cera_grimlock_after_site()
 *
 * @since 1.0.0
 */
add_action( 'cera_after_site', 'cera_grimlock_after_site', 10 );

/**
 * Sidebar Hooks
 *
 * @see cera_sidebar_left()
 * @see cera_sidebar_right()
 * @see cera_grimlock_sidebar_left()
 * @see cera_grimlock_sidebar_right()
 *
 * @since 1.0.0
 */
remove_action( 'cera_sidebar_left', 'cera_sidebar_left',          10 );
add_action(    'cera_sidebar_left', 'cera_grimlock_sidebar_left', 10 );

remove_action( 'cera_sidebar_right', 'cera_sidebar_right',          10 );
add_action(    'cera_sidebar_right', 'cera_grimlock_sidebar_right', 10 );

/**
 * Before Posts Hooks.
 *
 * @see cera_before_posts()
 * @see cera_before_search_posts()
 * @see cera_grimlock_before_posts()
 *
 * @since 1.0.0
 */
remove_action( 'cera_before_posts', 'cera_before_posts',                 10 );
remove_action( 'cera_before_search_posts', 'cera_before_search_posts',   10 );
add_action(    'cera_before_posts', 'cera_grimlock_before_posts',        10 );
add_action(    'cera_before_search_posts', 'cera_grimlock_before_posts', 10 );

/**
 * After Posts Hooks.
 *
 * @see cera_after_posts()
 * @see cera_grimlock_after_posts()
 *
 * @since 1.0.0
 */
remove_action( 'cera_after_posts', 'cera_after_posts',          10 );
add_action(    'cera_after_posts', 'cera_grimlock_after_posts', 10 );

/**
 * Post Hooks.
 *
 * @see cera_post()
 * @see cera_grimlock_post()
 * @see cera_grimlock_the_post_thumbnail()
 * @see cera_grimlock_post_thumbnail_size()
 * @see cera_grimlock_the_excerpt()
 * @see cera_the_date()
 * @see cera_the_author()
 * @see cera_the_category_list()
 * @see cera_the_tag_list()
 * @see cera_the_post_format()
 * @see cera_the_sticky_mark()
 * @see cera_get_more_link_text()
 * @see cera_comments_link()
 *
 * @since 1.0.0
 */
remove_action( 'cera_post', 'cera_post',           10 );
add_action(    'cera_post', 'cera_grimlock_post',  10 );

add_action( 'grimlock_post_thumbnail',      'cera_grimlock_the_post_thumbnail',  10, 2 );
add_action( 'grimlock_post_excerpt',        'cera_grimlock_the_excerpt',         10, 1 );
add_action( 'grimlock_post_date',           'cera_the_date',                     10    );
add_action( 'grimlock_post_author',         'cera_the_author',                   10    );
add_action( 'grimlock_category_list',       'cera_the_category_list',            10    );
add_action( 'grimlock_post_tag_list',       'cera_the_tag_list',                 10    );
add_action( 'grimlock_post_format',         'cera_the_post_format',              10    );
add_action( 'grimlock_post_format',         'cera_the_sticky_mark',              10    );
add_filter( 'grimlock_post_more_link_text', 'cera_get_more_link_text',           10, 1 );
add_action( 'grimlock_comments_link',       'cera_comments_link',                10    );

/**
 * Search Hooks.
 *
 * @see cera_search_post()
 * @see cera_grimlock_search_post()
 *
 * @since 1.0.0
 */
remove_action( 'cera_search_post', 'cera_search_post',          10 );
add_action(    'cera_search_post', 'cera_grimlock_search_post', 10 );

/**
 * Single Post Hooks.
 *
 * @see cera_single()
 * @see cera_the_author_biography()
 * @see cera_grimlock_single()
 * @see cera_grimlock_the_post_navigation()
 *
 * @since 1.0.0
 */

remove_action( 'cera_single', 'cera_single',          10 );
add_action(    'cera_single', 'cera_grimlock_single', 10 );

remove_action( 'cera_the_post_navigation', 'the_post_navigation',                 10 );
add_action(    'cera_the_post_navigation', 'cera_grimlock_the_post_navigation', 10 );

remove_action( 'grimlock_single_content', 'grimlock_single_author_biography',     30 );
add_action( 'grimlock_single_content',    'cera_grimlock_the_author_biography', 30 );

/**
 * Page Hooks.
 *
 * @see cera_page()
 * @see cera_grimlock_page()
 *
 * @since 1.0.0
 */
remove_action( 'cera_page', 'cera_page',          10 );
add_action(    'cera_page', 'cera_grimlock_page', 10 );

/**
 * 404 Hooks.
 *
 * @see cera_404()
 * @see cera_grimlock_404()
 *
 * @since 1.1.8
 */
remove_action( 'cera_404', 'cera_404',          10 );
add_action(    'cera_404', 'cera_grimlock_404', 10 );

/**
 * Homepage Hooks.
 *
 * @see cera_grimlock_homepage()
 *
 * @since 1.0.0
 */
add_action( 'cera_homepage', 'cera_grimlock_homepage', 10 );

/**
 * Other Hooks.
 *
 * @see cera_grimlock_remove_actions()
 *
 * @since 1.0.0
 */
remove_filter( 'nav_menu_css_class',   'cera_nav_menu_css_class',   10 );
remove_filter( 'body_class',           'cera_body_classes',         10 );
remove_filter( 'theme_page_templates', 'cera_theme_page_templates', 10 );

add_action( 'template_redirect', 'cera_grimlock_remove_actions', 10 );
