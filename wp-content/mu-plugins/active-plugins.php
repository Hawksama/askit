<?php
/**
 * @package active-plugins
 * @version 1.0
 *
 * Plugin Name: Deactivator plugin
 * Plugin URI: http://wordpress.org/extend/plugins/#
 * Description: This plugin is on the first plugin loaded that will escape loading other plugins for non logged users, such as grimlock 
 * Author: Carlo Daniele
 * Version: 1.0
 * Author URI: https://carlodaniele.it/
 */

// shortcode to list active plugins 
add_shortcode( 'activeplugins', function(){
	
	$active_plugins = get_option( 'active_plugins' );
	$plugins = "";
	if( count( $active_plugins ) > 0 ){
		$plugins = "<ul>";
		foreach ( $active_plugins as $plugin ) {
			$plugins .= "<li>" . $plugin . "</li>";
		}
		$plugins .= "</ul>";
	}
	return $plugins;
});

$request_uri = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );

$is_admin = strpos( $request_uri, '/wp-admin/' );

$logged_in = false;
if (count($_COOKIE)) {
	foreach ($_COOKIE as $key => $val) {
		if (preg_match("/wordpress_logged_in/i", $key)) {
			$logged_in = true;
		} else {
			$logged_in = false;
		}
	}
} else {
	$logged_in = false;
}

define('USERLOGGED', $logged_in);

if( false === $is_admin || !$logged_in ){

	// filter active plugins
	add_filter( 'option_active_plugins', function( $plugins ){

		global $request_uri;

		// change elements according to your needs
		$myplugins = array( 
			"wp-content/plugins/grimlock/grimlock.php" 
		);

        $plugins = array_diff( $plugins, $myplugins );
        
		return $plugins;

	} );
}