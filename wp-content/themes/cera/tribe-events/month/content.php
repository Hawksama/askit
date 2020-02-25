<?php
/**
 * Month View Content Template
 * The content template for the month view of events. This template is also used for
 * the response that is returned on month view ajax requests.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/month/content.php
 *
 * @package TribeEventsCalendar
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
} ?>

<div id="tribe-events-content" class="tribe-events-month">

	<!-- Month Title -->
	<?php do_action( 'tribe_events_before_the_title' ); ?>
	<div class="tribe-events-entry-header d-flex align-items-center mb-2">
		<h2 class="tribe-events-page-title mb-0"><?php tribe_events_title(); ?></h2>
		<div class="col-auto d-none d-md-block ml-auto pr-0">
			<?php do_action( 'tribe_events_after_footer' ); ?>
		</div>
	</div> <!-- .tribe-events-entry-header -->
	<?php do_action( 'tribe_events_after_the_title' ); ?>

	<!-- Notices -->
	<?php tribe_the_notices(); ?>

	<!-- Month Header -->
	<?php do_action( 'tribe_events_before_header' ); ?>
	<div id="tribe-events-header" <?php tribe_events_the_header_attributes(); ?>>

		<div class="post-navigation">
			<!-- Header Navigation -->
			<?php tribe_get_template_part( 'month/nav' ); ?>
		</div>

	</div>
	<!-- #tribe-events-header -->
	<?php do_action( 'tribe_events_after_header' ); ?>

	<!-- Month Grid -->
	<?php tribe_get_template_part( 'month/loop', 'grid' ); ?>

	<!-- Month Footer -->
	<?php do_action( 'tribe_events_before_footer' ); ?>
	<div class="post-navigation">
		<!-- Footer Navigation -->
		<?php do_action( 'tribe_events_before_footer_nav' ); ?>
		<?php tribe_get_template_part( 'month/nav' ); ?>
		<?php do_action( 'tribe_events_after_footer_nav' ); ?>
	</div>
	<!-- #tribe-events-footer -->

	<?php tribe_get_template_part( 'month/mobile' ); ?>
	<?php tribe_get_template_part( 'month/tooltip' ); ?>

</div><!-- #tribe-events-content -->
