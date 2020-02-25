<?php
/**
 * Template hooks for Grimlock for Author Avatars
 *
 * @package grimlock-author-avatars/inc
 */

/**
 * Author Avatars Hooks.
 *
 * @see grimlock_author_avatars_userlist_template()
 * @see grimlock_author_avatars_user_template()
 *
 * @since 1.0.0
 */

add_action( 'aa_userlist_template', 'grimlock_author_avatars_userlist_template',  10, 1 );
add_action( 'aa_user_template',     'grimlock_author_avatars_user_template',      10, 1 );
