<?php
/**
 * Template part for single tags.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WPBase
 */

print( '<div class="clearfix mb-15">' );
the_post_navigation( array(
	'prev_text' => '<i class="fa fa-angle-left"></i><span class="screen-reader-text">' . __( 'Previous Post', 'wpbase' ) . '</span><span aria-hidden="true" class="nav-subtitle" data-toggle="tooltip" title="%title">' . __( 'Previous Post', 'wpbase' ) . '</span>',
	'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'wpbase' ) . '</span><span aria-hidden="true" class="nav-subtitle"  data-toggle="tooltip" title="%title">' . __( 'Next Post', 'wpbase' ) . '</span><i class="fa fa-angle-right"></i>',
) );
print( '</div>' );
