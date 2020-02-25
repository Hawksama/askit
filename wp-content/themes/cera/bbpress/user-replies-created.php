<?php
/**
 * User Replies Created
 *
 * @package bbPress
 * @subpackage Theme
 */

// @codingStandardsIgnoreFile
// Allow plugin text domain in theme.
?>

<?php do_action( 'bbp_template_before_user_replies' ); ?>

<div id="bbp-user-replies-created" class="bbp-user-replies-created">
	<h2 class="entry-title sr-only"><?php esc_html_e( 'Forum Replies Created', 'bbpress' ); ?></h2>
	<div class="bbp-user-section">

		<?php if ( bbp_get_user_replies_created() ) : ?>

			<?php bbp_get_template_part( 'loop',       'replies' ); ?>

			<?php bbp_get_template_part( 'pagination', 'replies' ); ?>

		<?php else : ?>
			<div class="alert alert-info">
				<?php bbp_is_user_home() ? esc_html_e( 'You have not replied to any topics.', 'bbpress' ) : esc_html_e( 'This user has not replied to any topics.', 'bbpress' ); ?>
			</div>

		<?php endif; ?>

	</div>
</div><!-- #bbp-user-replies-created -->

<?php do_action( 'bbp_template_after_user_replies' ); ?>
