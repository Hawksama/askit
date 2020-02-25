<?php
/**
 * Single Event Meta (Map) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/map.php
 *
 * @package TribeEventsCalendar
 * @version 4.4
 */

$event_map = tribe_get_embedded_map();

if ( empty( $event_map ) ) {
	return;
} ?>

<div class="tribe-events-single-venue-map rounded ov-h">
	<?php
	// Display the map.
	do_action( 'tribe_events_single_meta_map_section_start' );
	echo wp_kses_post( $event_map );
	do_action( 'tribe_events_single_meta_map_section_end' ); ?>
</div>
