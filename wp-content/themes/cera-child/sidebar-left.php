<?php
/**
 * The sidebar containing the widget area for the leftside of the page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package cera
 */

if (is_singular('ht_kb')) {
    return;
}

do_action( 'cera_sidebar_left' );
