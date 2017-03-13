<?php
/**
 * Displays top navigation
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>
<nav id="site-navigation" class="main-navigation pull-right" role="navigation" aria-label="<?php _e( 'Top Menu', 'wpbase' ); ?>">
	<?php wp_nav_menu( array(
		'theme_location' => 'top',
		'menu_id'        => 'top-menu',
		'menu_class'     => 'navs',
	) ); ?>

</nav><!-- #site-navigation -->
