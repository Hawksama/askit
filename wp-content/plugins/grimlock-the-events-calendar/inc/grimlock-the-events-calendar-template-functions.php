<?php
/**
 * Grimlock The Events Calendar template functions.
 *
 * @package grimlock-the-events-calendar
 */

function grimlock_the_events_calendar_tribe_events_template( $args ) {
	?>
	<div class="card tribe-event__card">
		<?php
		/**
		 * Hook: grimlock_the_events_calendar_tribe_events_before_card_body
		 *
		 * @hooked grimlock_post_thumbnail - 10
		 */
		do_action( 'grimlock_the_events_calendar_tribe_events_before_card_body', $args ); ?>

		<div class="card-body">
			<?php
			/**
			 * Hook: grimlock_the_events_calendar_tribe_events_card_body
			 *
			 * @hooked grimlock_the_events_calendar_tribe_events_header  - 10
			 * @hooked grimlock_the_events_calendar_tribe_events_content - 20
			 * @hooked grimlock_the_events_calendar_tribe_events_footer  - 30
			 */
			do_action( 'grimlock_the_events_calendar_tribe_events_card_body', $args ); ?>
		</div><!-- .card-body -->

		<?php
		/**
		 * Hook: grimlock_the_events_calendar_tribe_events_card_body
		 */
		do_action( 'grimlock_the_events_calendar_tribe_events_after_card_body', $args ); ?>
	</div><!-- .card -->
	<?php
}

function grimlock_the_events_calendar_tribe_events_header( $args ) {
	?>
	<header class="entry-header clearfix">
		<?php
		/**
		 * Hook: grimlock_the_events_calendar_tribe_events_header
		 *
		 * @hooked grimlock_post_title                                  - 10
		 * @hooked grimlock_the_events_calendar_tribe_events_start_date - 20
		 */
		do_action( 'grimlock_the_events_calendar_tribe_events_header', $args ); ?>
	</header>
	<?php
}

function grimlock_the_events_calendar_tribe_events_start_date() {

	if ( function_exists( 'tribe_is_recurring_event' ) && tribe_is_recurring_event() ) {
		$event                    = get_post( get_the_ID() );
		$inner                    = '<span class="tribe-event-date-start">';
		$date_without_year_format = tribe_get_date_format();
		$date_with_year_format    = tribe_get_date_format( true );

		/**
		 * If a yearless date format should be preferred.
		 *
		 * By default, this will be true if the event starts and ends in the current year.
		 *
		 * @param bool    $use_yearless_format
		 * @param WP_Post $event
		 */
		$use_yearless_format = apply_filters( 'tribe_events_event_schedule_details_use_yearless_format',
				(
						tribe_get_start_date( $event, false, 'Y' ) === date_i18n( 'Y' )
						&& tribe_get_end_date( $event, false, 'Y' ) === date_i18n( 'Y' )
				),
				$event
		);

		$format = $use_yearless_format ? $date_without_year_format : $date_with_year_format;

		$inner      .= tribe_get_start_date( $event, false, $format );
		$recurrences = tribe_get_recurrence_start_dates();
		$last_date   = strtotime( end( $recurrences ) );
		$inner      .= ' - ';
		$inner      .= tribe_format_date( $last_date, false, $format );
		$inner      .= '</span>';

		/**
		 * Provides an opportunity to modify the *inner* schedule details HTML (ie before it is
		 * wrapped).
		 *
		 * @param string $inner_html  the output HTML
		 * @param int    $event_id    post ID of the event we are interested in
		 */
		echo apply_filters( 'tribe_events_event_schedule_details_inner', $inner, $event->ID );
	}
	elseif ( function_exists( 'tribe_events_event_schedule_details' ) ) {
		echo tribe_events_event_schedule_details();
	}
}

function grimlock_the_events_calendar_tribe_events_footer( $args ) {
	?>
	<footer class="entry-footer clearfix">
		<?php
		/**
		 * Hook: grimlock_the_events_calendar_tribe_events_footer
		 *
		 * @hooked grimlock_edit_post_link - 10
		 */
		do_action( 'grimlock_the_events_calendar_tribe_events_footer', $args ) ?>
	</footer><!-- .entry-footer -->
	<?php
}
