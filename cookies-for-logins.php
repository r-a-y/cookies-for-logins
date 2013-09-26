<?php
/*
Plugin Name: Cookies for Logins and BuddyPress
Description: Sets a cookie that must exist to login or to register in BuddyPress. Requires the Cookies for Comments plugin.
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

	// load up the cookie
	if ( get_option( 'cfc_delivery' ) == 'css' ) {
		add_action( 'login_head',   'cfc_stylesheet_html' );
	} else {
		add_action( 'login_footer', 'cfc_img_html' );
	}

	$action = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : 'login';

	switch ( $action ) {
		case 'login' :
		case 'register' :
		case 'lostpassword' :
		case 'retrievepassword' :
			$http_post = ( 'POST' == $_SERVER['REQUEST_METHOD'] );

			if ( empty( $http_post ) ) {
				return;
			}

			$cfc_key = get_cfc_key();

			if ( ! $cfc_key ) {
				return;
			}

			if ( isset( $_COOKIE[ $cfc_key ] ) ) {
				$spam = 0;

				// might need to adjust the time limit for login actions separately
				// in the meantime, keep this here and add a filter
				$cfc_speed = (int) apply_filters( 'cfl_speed', get_site_option( 'cfc_speed' ) );
				if ( $cfc_speed > 0 && $_COOKIE[ $cfc_key ] > 1 && ( time() - $_COOKIE[ $cfc_key ] ) < $cfc_speed ) {
					$spam = 1;
				}

			} else {
				$spam = 1;
			}

			if ( $spam == 1 ) {
				$msg = '<p>' . __( 'Sorry! We cannot allow you to do that!', 'ray_cfx' ) . '</p>';
				wp_die( $msg );
			}


			break;
	}

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

	$cfc_key = get_cfc_key();

	if ( ! $cfc_key ) {
		return;
	}

	if ( isset( $_COOKIE[ $cfc_key ] ) ) {
		$spam = 0;

		// might need to adjust the time limit for BP registrations separately
		// in the meantime, keep this here
		$cfc_speed = (int) apply_filters( 'cfb_speed', get_site_option( 'cfc_speed' ) );
		if ( $cfc_speed > 0 && $_COOKIE[ $cfc_key ] > 1 && ( time() - $_COOKIE[ $cfc_key ] ) < $cfc_speed ) {
			$spam = 1;
		}

	} else {
		$spam = 1;
	}

	if ( $spam == 1 ) {
		$msg = '<p>' . __( 'Sorry! We cannot you to register on this site!', 'ray_cfx' ) . '</p>';
		wp_die( $msg );
	}
}
add_action( 'bp_signup_validate', 'ray_cfb_init' );
