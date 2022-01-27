<?php
/*
Plugin Name: Cookies for Logins and BuddyPress
Description: Sets a cookie that must exist in order to login or to register in BuddyPress. Requires the Cookies for Comments plugin.
Version: 0.1
Author: r-a-y
Author URI: http://profiles.wordpress.org/r-a-y
*/

/**
 * For logins.
 */
function ray_cfl_init() {
	// cookies for comments plugin doesn't exist, so stop!
	if ( ! function_exists( 'get_cfc_key' ) ) {
		return;
	}

	require_once __DIR__ . '/hooks/login.php';
}
add_action( 'login_init', 'ray_cfl_init' );

/**
 * For BuddyPress registrations.
 */
function ray_cfb_init() {
	// cookies for comments plugin doesn't exist, so stop!
	if ( ! function_exists( 'get_cfc_key' ) ) {
		return;
	}

	require_once __DIR__ . '/hooks/buddypress.php';
}
add_action( 'bp_signup_validate', 'ray_cfb_init' );
