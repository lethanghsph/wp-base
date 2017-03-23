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
	/**
	 * Initialize.
	 */
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
		$classes[] = isset( $GLOBALS['wpbase_container_class'] ) ? $GLOBALS['wpbase_container_class'] : 'container';

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
		}

		$classes = apply_filters( 'event2_layout_class', $classes );

		echo 'class="' . esc_attr( join( ' ', $classes ) ) . '"';
	}

	/**
	 * WPBase get site logo
	 *
	 * @param  string  $logo       Logo type to get.
	 * @param  boolean $echo       Echo output.
	 * @param  boolean $with_link  Display site logo with link.
	 * @param  string  $before     Before output logo.
	 * @param  string  $after      After output logo.
	 * @return string
	 */
	function wpbase_site_logo( $logo = 'site_logo', $echo = true, $with_link = true, $before = '', $after = '' ) {
		$output = '';

		if ( $site_logo = wpbase_option( $logo ) ) {
			if ( is_int( $site_logo ) ) {
				$site_logo = wp_get_attachment_image_url( $site_logo, 'full' );
			}

			$image = sprintf( '<img src="%1$s" class="site-logo-img" alt="%2$s">', $site_logo, get_bloginfo( 'name' ) );

			if ( $with_link ) {
				$image = sprintf( '<a class="site-logo site-logo--link %3$s" href="%1$s" rel="home">%2$s</a>', esc_url( home_url( '/' ) ), $image, $logo );
			} else {
				$image = sprintf( '<span class="site-logo %2$s">%1$s</span>', $image, $logo );
			}

			$output  = $before . $image . $after;
		}

		/**
		 * Apply filter to site logo hooks.
		 *
		 * @var string
		 */
		$output = apply_filters( 'wpbase_site_logo', $output, $logo, $with_link, $before, $after );

		if ( ! $echo ) {
			return $output;
		}

		print $output; // WPCS: XSS OK.
	}

	/**
	 * Small function to display site copyright.
	 *
	 * @param  string $before Before output copyright.
	 * @param  string $after  After output copyright.
	 * @param  bool   $echo   Echo or return output.
	 */
	function wpbase_site_copyright( $before = '', $after = '', $echo = true ) {
		if ( ! $copyright = wpbase_option( 'copyright' ) ) {
			return;
		}

		$theme  = wp_get_theme();
		$search = array(
			'{c}',
			'{year}',
			'{sitename}',
			'{theme}',
			'{author}',
		);

		$replace = array(
			' &copy; ',
			date( 'Y' ),
			get_bloginfo( 'name' ),
			sprintf( esc_html__( '%1$s by %2$s', 'wpbase' ), $theme->name, $theme->display( 'Author' ) ),
			$theme->display( 'Author' ),
		);

		$output  = $before;
		$output .= str_replace( $search, $replace, $copyright );
		$output .= $after;

		/**
		 * Fire a filter $output.
		 *
		 * @var string
		 */
		$output = apply_filters( 'wpbase_site_copyright', $output );

		if ( ! $echo ) {
			return $output;
		}

		print $output; // WPCS: XSS OK.
	}

	/**
	 * Display site pager.
	 */
	function wpbase_pager() {
		print '<nav>';

		$paginate_links = paginate_links( array(
			'type'      => 'list',
			'prev_text' => sprintf( '<span class="screen-reader-text">%s</span> <i class="previous %s"></i>', esc_html__( 'Previous', 'wpbase' ), esc_attr( apply_filters( 'wpbase_next_icon', 'fa fa-angle-left' ) ) ),
			'next_text' => sprintf( '<span class="screen-reader-text">%s</span> <i class="next %s"></i>', esc_html__( 'Next', 'wpbase' ), esc_attr( apply_filters( 'wpbase_next_icon', 'fa fa-angle-right' ) ) ),
		) );

		printf( '%s', $paginate_links ); // WPCS: XSS OK.

		print '</nav>';
	}

	/**
	 * Returns true if a blog has more than 1 category.
	 *
	 * @return bool
	 */
	public function wpbase_categorized_blog() {
		if ( false === ( $all_the_cool_cats = get_transient( 'wpbase_categories' ) ) ) {
			// Create an array of all the categories that are attached to posts.
			$all_the_cool_cats = get_categories( array(
				'fields'     => 'ids',
				'hide_empty' => 1,
				// We only need to know if there is more than one category.
				'number'     => 2,
			) );

			// Count the number of categories that are attached to the posts.
			$all_the_cool_cats = count( $all_the_cool_cats );

			set_transient( 'wpbase_categories', $all_the_cool_cats );
		}

		if ( $all_the_cool_cats > 1 ) {
			// This blog has more than 1 category so wpbase_categorized_blog should return true.
			return true;
		} else {
			// This blog has only 1 category so wpbase_categorized_blog should return false.
			return false;
		}
	}

	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	public function wpbase_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}

}
