<?php
/**
 * Login integration with CFC.
 *
 * @group cookies-for-logins
 */

// cookies for comments plugin doesn't exist, so stop!
if ( ! function_exists( 'get_cfc_key' ) ) {
	return;
}

// load up the cookie
if ( get_option( 'cfc_delivery' ) == 'css' ) {
	add_action( 'login_head',   'cfc_stylesheet_html' );
} else {
	add_action( 'login_header', 'cfc_img_html' );
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