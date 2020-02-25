<?php
/**
 * Cera_BbPress Class
 *
 * @author   Themosaurus
 * @since    1.0.0
 * @package  cera
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Cera_BbPress' ) ) :
	/**
	 * The main Cera_BbPress class.
	 */
	class Cera_BbPress {
		/**
		 * Setup class.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_filter( 'bbp_get_topic_author_avatar', array( $this, 'change_topic_author_avatar_size' ), 20, 3 );
			add_filter( 'bbp_get_reply_author_avatar', array( $this, 'change_reply_author_avatar_size' ), 20, 3 );
			add_filter( 'bbp_get_current_user_avatar', array( $this, 'change_current_user_avatar_size' ), 20, 2 );

			global $cera_grimlock;
			add_filter( 'grimlock_archive_forum_customizer_custom_header_layout_field_args', array( $cera_grimlock, 'change_layout_field_args' ), 10, 2 );
		}

		/**
		 * Increase bbPress avatar sizes for the topic author.
		 *
		 * @param string $author_avatar Avatar of the author of the topic.
		 * @param int    $topic_id      Optional. Topic id.
		 * @param int    $size          Optional. Avatar size. Defaults to 40.
		 *
		 * @return false|string
		 */
		public function change_topic_author_avatar_size( $author_avatar, $topic_id, $size ) {
			$topic_id = bbp_get_topic_id( $topic_id );

			if ( 14 === $size ) {
				$size = 50;
			} elseif ( 80 === $size ) {
				$size = 110;
			}

			if ( ! empty( $topic_id ) ) {
				if ( ! bbp_is_topic_anonymous( $topic_id ) ) {
					$author_avatar = get_avatar( bbp_get_topic_author_id( $topic_id ), $size );
				} else {
					$author_avatar = get_avatar( get_post_meta( $topic_id, '_bbp_anonymous_email', true ), $size );
				}
			}
			return $author_avatar;
		}

		/**
		 * Increase bbPress avatar sizes for the reply author.
		 *
		 * @param string $author_avatar Avatar of the author of the topic.
		 * @param int    $reply_id      Optional. Reply id.
		 * @param int    $size          Optional. Avatar size. Defaults to 40.
		 *
		 * @return false|string
		 */
		public function change_reply_author_avatar_size( $author_avatar, $reply_id, $size ) {
			$reply_id = bbp_get_reply_id( $reply_id );

			if ( 14 === $size ) {
				$size = 50;
			} elseif ( 80 === $size ) {
				$size = 110;
			}

			if ( ! empty( $reply_id ) ) {
				if ( ! bbp_is_reply_anonymous( $reply_id ) ) {
					$author_avatar = get_avatar( bbp_get_reply_author_id( $reply_id ), $size );
				} else {
					$author_avatar = get_avatar( get_post_meta( $reply_id, '_bbp_anonymous_email', true ), $size );
				}
			}
			return $author_avatar;
		}

		/**
		 * Increase bbPress avatars size for the current user.
		 *
		 * @param string $avatar Avatar of the author of the topic.
		 * @param int    $size   Optional. Avatar size. Defaults to 40.
		 *
		 * @return false|string
		 */
		public function change_current_user_avatar_size( $avatar, $size ) {
			if ( 14 === $size ) {
				$size = 50;
			} elseif ( 80 === $size ) {
				$size = 110;
			}

			$avatar = get_avatar( bbp_get_current_user_id(), $size );
			return $avatar;
		}
	}
endif;

return new Cera_BbPress();
