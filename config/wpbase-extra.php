<?php
/**
 * Extra controller.
 *
 * @package wpbase
 */

/**
 * //
 */
class WPBase_Extra {
	// Initialize.
	public function __construct() {
		add_filter( 'body_class', array( $this, 'wpbase_body_classes' ) );
	}

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	public function wpbase_body_classes( $classes ) {
		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		return $classes;
	}

	/**
	 * Site container classes.
	 *
	 * @param array $classes Classes for the layout element.
	 */
	public function wpbase_content_class( $classes = '' ) {
		global $template;

		$classes = (array) $classes;

		$classes[] = 'site-content';
		$classes[] = basename( $template, '.php' );
		$classes[] = isset( $GLOBALS['container_class'] ) ? $GLOBALS['container_class'] : 'container';

		$classes = apply_filters( 'wpbase_container_class', $classes );

		echo 'class="' . esc_attr( join( ' ', $classes ) ) . '"';
	}

	/**
	 * Site layout classes (Sidebar...).
	 *
	 * @param array $classes Classes for the layout element.
	 */
	function wpbase_layout_class( $classes = '' ) {
		$classes = (array) $classes;
		$classes[] = 'site-layout';

		if ( class_exists( 'WPBase_Sidebar' ) ) {

			if ( WPBase_Sidebar::has_sidebar() ) {
				$classes[] = sprintf( 'sidebar-%s', WPBase_Sidebar::get_sidebar_area() );
			} else {
				$classes[] = 'sidebar-none';
			}
		} else {
			$classes[] = 'sidebar-right';
		}

		$classes = apply_filters( 'event2_layout_class', $classes );

		echo 'class="' . esc_attr( join( ' ', $classes ) ) . '"';
	}

}
