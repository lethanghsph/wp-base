<?php
/**
 * WPBase register assets.
 *
 * @package WPBase
 * @since 1.0
 */

/**
 * Register custom fonts.
 */
function wpbase_fonts_url() {
	$fonts_url = '';

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Libre Franklin, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	if ( 'off' !== _x( 'on', 'Poppins font: on or off', 'wpbase' ) ) {
		$fonts[] = 'Poppins';
	}
	if ( 'off' !== _x( 'on', 'Comfortaa font: on or off', 'wpbase' ) ) {
		$fonts[] = 'Comfortaa';
	}
	if ( 'off' !== _x( 'on', 'Source Code Pro font: on or off', 'wpbase' ) ) {
		$fonts[] = 'Source Code Pro:400,500';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return esc_url( $fonts_url );
}

/**
 * Enqueue scripts and styles.
 */
function wpbase_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'wpbase-fonts', wpbase_fonts_url(), array(), null );
	wp_enqueue_style( 'fonts-awesome', get_template_directory_uri() . '/assets/css/lib/font-awesome.css', array(), '4.7.0' );
	wp_enqueue_style( 'slick', get_template_directory_uri() . '/assets/css/lib/slick.css', array(), '1.6.0' );

	// Theme stylesheet.
	wp_enqueue_style( 'wpbase-style', get_stylesheet_uri() );
	wp_enqueue_style( 'wpbase', get_template_directory_uri() . '/assets/css/main.css' );

	wp_enqueue_script( 'tl-menu', get_template_directory_uri() . '/assets/js/plugins/menu.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/plugins/bootstrap.min.js', array( 'jquery' ), '3.3.7', true );
	wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/js/plugins/slick.min.js', array( 'jquery' ), '1.6.0', true );
	wp_enqueue_script( 'main', get_template_directory_uri() . '/assets/js/scripts.js', array( 'jquery' ), '1.0.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wpbase_scripts' );
