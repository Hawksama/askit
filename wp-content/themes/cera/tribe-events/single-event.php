<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @version  4.3
 */

// @codingStandardsIgnoreFile
// Allow plugin text domain in theme and unescaped template tags.

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural   = tribe_get_event_label_plural();
$event_id              = get_the_ID();
$venue                 = tribe_get_venue( get_the_ID() );
?>

<div id="tribe-events-content" class="tribe-events-single">

	<div class="single-post-back tribe-events-back">
		<a href="<?php echo esc_url( tribe_get_events_link() ); ?>">
			<?php
			/* translators: %s: Events plural label */
			printf( esc_html_x( 'All %s', '%s Events plural label', 'the-events-calendar' ), esc_html( $events_label_plural ) ); ?>
		</a>
		<span class="pl-1">• <strong class="pl-1"><?php the_title(); ?></strong></span>
	</div>

	<!-- Notices -->
	<?php tribe_the_notices(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<div class="tribe-events-entry-content pt-4">

				<div class="row">

					<div class="col-lg-8 col-xl-9">

						<div class="tribe-events-single-header mb-4">

							<div class="tribe-events-single-header-meta card card-static p-3">

								<?php if ( ! is_null( $venue ) ) : ?>
									<!-- Event labels -->
									<a href="<?php echo esc_url( get_the_permalink( tribe_get_venue_id() ) ); ?>" class="tribe-venue badge badge-primary"><i class="cera-icon cera-map-pin"></i> <?php echo esc_html( tribe_get_venue() ); ?></a>
								<?php endif; ?>

								<div class="row">
									<?php if ( has_post_thumbnail() ) : ?>
										<div class="col col-sm-3 col-lg-4">
											<?php echo tribe_event_featured_image( $event_id, 'large', false ); ?>
										</div>
									<?php endif; ?>
									<div class="col pl-sm-0">
										<div class="p-md-4 p-2">
											<h1 class="tribe-events-single-header-title h3">
												<?php the_title(); ?>
												<?php if ( tribe_get_cost() ) : ?>
													<span class="tribe-events-cost"><?php echo tribe_get_cost( null, true ); ?></span>
												<?php endif; ?>
											</h1><!-- .tribe-events-single-header-title -->

											<div class="tribe-events-single-header-schedule tribe-clearfix">
												<?php echo tribe_events_event_schedule_details( $event_id, '', '' ); ?>
											</div><!-- .tribe-events-schedule -->

											<?php echo tribe_get_event_categories(
												get_the_id(), array(
													'before'       => '',
													'sep'          => '',
													'after'        => '',
													'label'        => false,
													'label_before' => '<span class="tribe-events-single-categories-label">',
													'label_after'  => '</span>',
													'wrap_before'  => '<div class="tribe-events-single-categories mt-2">',
													'wrap_after'   => '</div>',
												)
											); ?>
										</div>
									</div>
								</div>

							</div><!-- .tribe-events-single-header-meta -->

						</div><!-- .tribe-events-single-header -->

						<?php do_action( 'tribe_events_single_event_before_the_content' ); ?>

						<div class="tribe-events-single-event-description tribe-events-content card card-static p-4">
							<?php the_content(); ?>
							<?php tribe_get_template_part( 'modules/meta/details' ); ?>
							<?php do_action( 'tribe_events_single_event_meta_primary_section_end' ); ?>
							<div class="tribe-events-single-after-event-description">
								<?php do_action( 'tribe_events_single_event_after_the_content' ); ?>
							</div>
						</div><!-- .tribe-events-single-event-description -->

						<div class="row pt-4">
							<div class="col-12">
								<?php do_action( 'tribe_events_single_event_after_the_meta' ); ?>
							</div><!-- .col-* -->
						</div><!-- .row -->

					</div><!-- .col-* -->

					<div id="secondary-right" class="col-lg-4 col-xl-3">
						<?php do_action( 'tribe_events_single_event_before_the_meta' ); ?>
						<?php tribe_get_template_part( 'modules/meta' ); ?>
					</div><!-- .col-* -->

				</div><!-- .row -->

			</div><!-- .tribe-events-entry-content -->

		</div> <!-- #post-x -->

		<?php
		if ( get_post_type() === Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) :
			comments_template();
		endif;

	endwhile; ?>

	<!-- Event footer -->
	<div class="post-navigation">
		<h3 class="tribe-events-visuallyhidden">
			<?php
			/* translators: %s: Events singular label */
			printf( esc_html__( '%s Navigation', 'the-events-calendar' ), esc_html( $events_label_singular ) ); ?>
		</h3>

		<ul class="tribe-events-sub-nav nav-links">
			<li class="tribe-events-nav-previous nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ); ?></li>
			<li class="tribe-events-nav-next nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ); ?></li>
		</ul><!-- .tribe-events-sub-nav -->
	</div> <!-- #tribe-events-footer -->

</div><!-- #tribe-events-content -->
