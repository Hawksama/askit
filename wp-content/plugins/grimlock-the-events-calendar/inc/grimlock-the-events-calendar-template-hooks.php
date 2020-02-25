<?php
/**
 * Grimlock The Events Calendar template hooks.
 *
 * @package grimlock-the-events-calendar
 */

/**
 * Tribe events component hooks
 *
 * @see grimlock_the_events_calendar_tribe_events_template
 *
 * @see grimlock_post_thumbnail
 *
 * @see grimlock_the_events_calendar_tribe_events_header
 * @see grimlock_the_events_calendar_tribe_events_content
 * @see grimlock_the_events_calendar_tribe_events_excerpt
 * @see grimlock_the_events_calendar_tribe_events_footer
 *
 * @see grimlock_post_title
 * @see grimlock_the_events_calendar_tribe_events_start_date
 * 
 * @see grimlock_edit_post_link
 */
add_action( 'grimlock_the_events_calendar_tribe_events_template',         'grimlock_the_events_calendar_tribe_events_template',   10, 1 );

add_action( 'grimlock_the_events_calendar_tribe_events_before_card_body', 'grimlock_post_thumbnail',                              10, 1 );

add_action( 'grimlock_the_events_calendar_tribe_events_card_body',        'grimlock_the_events_calendar_tribe_events_header',     10, 1 );
add_action( 'grimlock_the_events_calendar_tribe_events_card_body',        'grimlock_post_content',                                20, 1 );
add_action( 'grimlock_the_events_calendar_tribe_events_card_body',        'grimlock_post_excerpt',                                30, 1 );
add_action( 'grimlock_the_events_calendar_tribe_events_card_body',        'grimlock_the_events_calendar_tribe_events_footer',     40, 1 );

add_action( 'grimlock_the_events_calendar_tribe_events_header',           'grimlock_post_title',                                  10, 1 );
add_action( 'grimlock_the_events_calendar_tribe_events_header',           'grimlock_the_events_calendar_tribe_events_start_date', 20, 1 );

add_action( 'grimlock_the_events_calendar_tribe_events_footer',           'grimlock_edit_post_link',                              10, 1 );
