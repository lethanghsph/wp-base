<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WPBase
 * @since 1.0
 * @version 1.0
 */

if ( isset( $GLOBALS['hidden_blog_sidebar'] ) && true == $GLOBALS['hidden_blog_sidebar'] ) {
	return;
}

if ( ! is_active_sidebar( $sidebar_name = WPBase()->sidebar->get_sidebar() ) ) {
	return;
}

?>

<aside id="secondary" class="widget-area">
	<?php dynamic_sidebar( $sidebar_name ); ?>
</aside><!-- #secondary -->


