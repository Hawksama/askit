<?php
/**
 * Template functions for Grimlock for Author Avatars
 *
 * @package grimlock-author-avatars/inc
 */

/**
 * Display the template for the user list.
 *
 * @since 1.0.0
 *
 * @param $default string The default template for the user list.
 *
 * @return string The template for the user list.
 */
function grimlock_author_avatars_userlist_template( $default ) {
    return '<div class="grimlock-author-avatars__author-list author-list">{users}</div>';
}

/**
 * Display the template for the user.
 *
 * @since 1.0.0
 *
 * @param $default string The default template for the user.
 *
 * @return string The template for the user.
 */
function grimlock_author_avatars_user_template( $default ) {
	return '<div class="grimlock-author-avatars__user {class}">{user}</div>';
}
