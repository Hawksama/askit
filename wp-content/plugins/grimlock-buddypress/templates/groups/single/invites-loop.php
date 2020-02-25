<?php
/**
 * BuddyPress - Group Invites Loop
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

// @codingStandardsIgnoreFile
// Allow plugin text domain in theme.
?>

<div class="row">

	<div class="left-menu col-sm-4 col-md-3 m-0 mb-sm-4">

		<div id="invite-list" class="mb-4">

			<ul>
				<?php bp_new_group_invite_friend_list(); ?>
			</ul>

			<?php wp_nonce_field( 'groups_invite_uninvite_user', '_wpnonce_invite_uninvite_user' ); ?>

		</div>

	</div><!-- .left-menu -->

	<div class="main-column col-sm-8 col-md-9 m-0">

		<?php do_action( 'bp_before_group_send_invites_list' ); ?>

		<?php if ( bp_group_has_invites( bp_ajax_querystring( 'invite' ) . '&per_page=10' ) ) : ?>

			<h4 class="mb-3 text-center text-sm-left"><?php bp_group_invite_pagination_count(); ?></h4>

			<?php /* The ID 'friend-list' is important for AJAX support. */ ?>
			<ul id="friend-list" class="bp-card-list bp-card-list--members bp-card-list--4 loading-list">

				<?php while ( bp_group_invites() ) : bp_group_the_invite(); ?>

					<li id="<?php bp_group_invite_item_id(); ?>" class="bp-card-list__item bp-card-list--members__item has-post-thumbnail element-animated fade-in short element-animated-delay element-animated-both">

						<div class="card">

							<div class="ov-h">

								<div class="card-img">
									<?php bp_group_invite_user_avatar(); ?>
								</div>

								<div class="card-body pt-1 pb-4 pl-2 pr-2">

									<div class="card-body-actions action">
										<div class="generic-button">
											<a class="button remove remove-invite" href="<?php bp_group_invite_user_remove_invite_url(); ?>" id="<?php bp_group_invite_item_id(); ?>" data-toggle="tooltip" title="<?php esc_html_e( 'Remove Invite', 'buddypress' ); ?>"><?php esc_html_e( 'Remove Invite', 'buddypress' ); ?></a>
										</div>
										<?php do_action( 'bp_group_send_invites_item_action' ); ?>
									</div>

									<header class="card-body-header entry-header clearfix">
										<h2 class="entry-title">
											<?php bp_group_invite_user_link(); ?>
										</h2>
									</header>

								</div>

							</div>

						</div>

						<?php do_action( 'bp_group_send_invites_item' ); ?>

					</li>

				<?php endwhile; ?>

			</ul><!-- #friend-list -->

		<?php else : ?>

			<div id="message" class="info">
				<p><?php esc_html_e( 'Select friends to invite.', 'buddypress' ); ?></p>
			</div>

		<?php endif; ?>

		<?php do_action( 'bp_after_group_send_invites_list' ); ?>

	</div><!-- .main-column -->
</div><!-- .row -->
