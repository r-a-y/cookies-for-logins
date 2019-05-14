<?php

/**
 * Set the Cookies for Comments image in the middle of the document.
 *
 * Fall back to wp_footer() if have_posts() isn't used in the theme template.
 */
class Ray_CFC_Img {
	/**
	 * Our marker.
	 *
	 * @type bool
	 */
	private $set = false;

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( ! function_exists( 'cfc_img_html' ) ) {
			return;
		}
	
		if ( get_option( 'cfc_delivery' ) === 'css' ) {
			return;
		}
	
		// Remove default CFC img hook in footer.
		remove_action( 'wp_footer', 'cfc_img_html' );
	
		// Add CFC img in the middle of the document.
		add_action( 'loop_start',      array( $this, 'set_image' ) );
		add_action( 'loop_no_results', array( $this, 'set_image' ) );
		add_action( 'wp_footer',       array( $this, 'set_image' ) );
	}

	/**
	 * Set the CFC image by checking our marker so the image is only added once.
	 */
	public function set_image() {
		if ( false === $this->set ) {
			cfc_img_html();
			$this->set = true;
		}
	}
}