<?php
/**
 * Replies Loop - Single Reply
 *
 * @package bbPress
 * @subpackage Theme
 */

// @codingStandardsIgnoreFile
// Allow plugin text domain in theme and unescaped template tags.
?>

<div class="card card-static mt-3">

	<div class="card-body p-2 p-md-3" id="post-<?php bbp_reply_id(); ?>">

		<div <?php bbp_reply_class(); ?>>

			<div class="row">

				<div class="col-12">

					<div class="bbp-list-author row align-items-center mb-2">

						<div class="col-auto pr-0">
							<?php do_action( 'bbp_theme_before_reply_author_details' ); ?>

							<div class="d-flex d-sm-block align-items-center align-items-md-start bbp-list-author-holder">
								<?php bbp_reply_author_link( array( 'sep' => '', 'show_role' => false, 'type' => 'avatar' ) ); ?>
							</div>
						</div>

						<div class="col">

							<div class="bbp-list-author-meta">

								<div class="d-flex align-items-center">
									<?php bbp_reply_author_link( array( 'sep' => '', 'show_role' => true, 'type' => 'name' ) ); ?>
								</div>

								<div class="d-flex align-items-center mt-2">
									<?php do_action( 'bbp_theme_after_reply_author_details' ); ?>
									<?php if ( bbp_is_user_keymaster() ) : ?>

										<?php do_action( 'bbp_theme_before_reply_author_admin_details' ); ?>

										<div class="bbp-reply-ip d-none d-sm-inline-flex"><?php bbp_author_ip( bbp_get_reply_id() ); ?></div>

										<?php do_action( 'bbp_theme_after_reply_author_admin_details' ); ?>

									<?php endif; ?>
								</div>

							</div>

						</div>

					</div>

					<div class="bg-black-faded p-3 p-sm-4 rounded reply-content-bubble">

						<?php do_action( 'bbp_theme_before_reply_content' ); ?>

						<?php bbp_reply_content(); ?>

						<?php do_action( 'bbp_theme_after_reply_content' ); ?>

					</div>

				</div><!-- .bbp-reply-content -->

			</div>

			<div class="mt-2">

				<div class="bbp-reply-header mb-0 p-0">

					<div class="bbp-meta">

						<span class="bbp-reply-post-date"><?php bbp_reply_post_date(); ?></span>

						<?php if ( bbp_is_single_user_replies() ) : ?>

							<span class="bbp-header"><?php esc_html_e( 'in reply to: ', 'bbpress' ); ?><a class="bbp-topic-permalink" href="<?php bbp_topic_permalink( bbp_get_reply_topic_id() ); ?>"><?php bbp_topic_title( bbp_get_reply_topic_id() ); ?></a></span>

						<?php endif; ?>

						<a href="<?php bbp_reply_url(); ?>" class="bbp-reply-permalink">#<?php bbp_reply_id(); ?></a>

						<?php do_action( 'bbp_theme_before_reply_admin_links' ); ?>

						<?php bbp_reply_admin_links(); ?>

						<?php do_action( 'bbp_theme_after_reply_admin_links' ); ?>

					</div><!-- .bbp-meta -->

				</div><!-- #post-<?php bbp_reply_id(); ?> -->

			</div>  <!-- .card-footer -->

		</div> <!-- .reply -->

	</div> <!-- .card-body -->


</div>  <!-- .card -->
