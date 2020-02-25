<?php
/**
 * BuddyPress - Private Message Content.
 *
 * This template is used in /messages/single.php during the message loop to
 * display each message and when a new message is created via AJAX.
 *
 * @since 2.4.0
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

?>

<div class="message-box bg-black-faded p-2 mt-2 rounded-card <?php bp_the_thread_message_css_class(); ?>">

	<div class="message-metadata">

		<?php do_action( 'bp_before_message_meta' ); ?>

		<?php bp_the_thread_message_sender_avatar( 'type=thumb&width=30&height=30' ); ?>

		<?php if ( bp_get_the_thread_message_sender_link() ) : ?>

			<strong><a href="<?php bp_the_thread_message_sender_link(); ?>"><?php bp_the_thread_message_sender_name(); ?></a></strong>

		<?php else : ?>

			<strong><?php bp_the_thread_message_sender_name(); ?></strong>

		<?php endif; ?>

		<span class="activity"><?php bp_the_thread_message_time_since(); ?></span>

		<?php if ( bp_is_active( 'messages', 'star' ) ) : ?>
			<div class="message-star-actions">
				<?php bp_the_message_star_action_link(); ?>
			</div>
		<?php endif; ?>

		<?php do_action( 'bp_after_message_meta' ); ?>

	</div><!-- .message-metadata -->

	<?php do_action( 'bp_before_message_content' ); ?>

	<div class="message-content">
		<?php bp_the_thread_message_content(); ?>
	</div><!-- .message-content -->

	<?php do_action( 'bp_after_message_content' ); ?>

	<div class="clear"></div>

</div><!-- .message-box -->
