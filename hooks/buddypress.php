<?php
/**
 * BuddyPress registration integration with CFC.
 *
 * @group cookies-for-logins
 */

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
	$msg = '<p>' . __( 'Sorry! We cannot allow you to register on the site!', 'ray_cfx' ) . '</p>';
	wp_die( $msg );
}