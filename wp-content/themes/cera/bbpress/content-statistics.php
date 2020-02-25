<?php
/**
 * Statistics Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

// @codingStandardsIgnoreFile
// Allow plugin text domain in theme.

// Get the statistics.
$stats = bbp_get_statistics(); ?>

<?php do_action( 'bbp_before_statistics' ); ?>

	<div class="widget_display_stats">

		<div class="row stats_list">

			<div class="col-12 stats_list_item mb-2">
				<div class="bg-black-faded rounded-card p-2 h-100">
					<div class="row align-items-center">
						<div class="col-auto text-center d-flex pr-0 align-items-center justify-content-center">
							<i class="cera-icon cera-users text-primary fa-2x p-3 card"></i>
						</div>
						<div class="col">
							<h3 class="mb-0"><?php echo esc_html( $stats['user_count'] ); ?></h3>
							<h5 class="text-muted text-uppercase small font-weight-bold mb-0"><?php esc_html_e( 'Registered Users', 'bbpress' ); ?></h5>
						</div>
					</div>
				</div>
			</div>

			<div class="col-12 stats_list_item mb-2">
				<div class="bg-black-faded rounded-card p-2 h-100">
					<div class="row align-items-center">
						<div class="col-auto text-center d-flex pr-0 align-items-center justify-content-center">
							<i class="cera-icon cera-message-square text-primary fa-2x p-3 card"></i>
						</div>
						<div class="col">
							<h3 class="mb-0"><?php echo esc_html( $stats['forum_count'] ); ?></h3>
							<h5 class="text-muted text-uppercase small font-weight-bold mb-0"><?php esc_html_e( 'Forums', 'bbpress' ); ?></h5>
						</div>
					</div>
				</div>
			</div>

			<div class="col-12 stats_list_item mb-2">
				<div class="bg-black-faded rounded-card p-2 h-100">
					<div class="row align-items-center">
						<div class="col-auto text-center d-flex pr-0 align-items-center justify-content-center">
							<i class="cera-icon cera-alert-circle text-primary fa-2x p-3 card"></i>
						</div>
						<div class="col">
							<h3 class="mb-0"><?php echo esc_html( $stats['topic_count'] ); ?></h3>
							<h5 class="text-muted text-uppercase small font-weight-bold mb-0"><?php esc_html_e( 'Topics', 'bbpress' ); ?></h5>
						</div>
					</div>
				</div>
			</div>

			<div class="col-12 stats_list_item mb-2">
				<div class="bg-black-faded rounded-card p-2 h-100">
					<div class="row align-items-center">
						<div class="col-auto text-center d-flex pr-0 align-items-center justify-content-center">
							<i class="cera-icon cera-radio text-primary fa-2x p-3 card"></i>
						</div>
						<div class="col">
							<h3 class="mb-0"><?php echo esc_html( $stats['reply_count'] ); ?></h3>
							<h5 class="text-muted text-uppercase small font-weight-bold mb-0"><?php esc_html_e( 'Replies', 'bbpress' ); ?></h5>
						</div>
					</div>
				</div>
			</div>

		</div>

	</div><!-- .widget_display_stats -->

<?php do_action( 'bbp_after_statistics' ); ?>

<?php unset( $stats );
