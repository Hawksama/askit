<?php
/**
 * Template functions for Grimlock for Author Avatars
 *
 * @package grimlock-author-avatars/inc
 */

if ( ! function_exists( 'cera_grimlock_author_avatars_userlist_template' ) ) :
	/**
	 * Display the template for the user list.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $default The default template for the user list.
	 *
	 * @return string          The template for the user list.
	 */
	function cera_grimlock_author_avatars_userlist_template( $default ) {
		return '<ol class="grimlock-author-avatars__author-list bp-card-list bp-card-list--members author-list">{users}</ol>';
	}
endif;

if ( ! function_exists( 'cera_grimlock_author_avatars_user_template' ) ) :
	/**
	 * Display the template for the user.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $default The default template for the user.
	 *
	 * @return string          The template for the user.
	 */
	function cera_grimlock_author_avatars_user_template( $default ) {
		return '<li class="grimlock-author-avatars__user bp-card-list__item bp-card-list--members__item has-post-thumbnail {class}"><div class="card"><div class="ov-h">{user}</div></div></li>';
	}
endif;
