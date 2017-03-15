<?php
/**
 * Displays top navigation
 *
 * @package WordPress
 * @subpackage Twenty_Seventeenp
 * @since 1.0
 * @version 1.0
 */

?>
<nav role="navigation" aria-label="<?php esc_html__( 'Primary Menu Desktop', 'wpbase' ); ?>">
	<?php wp_nav_menu( array(
		'theme_location' => 'top',
		'menu_id'        => '',
		'menu_class'     => '',
	) ); ?>

</nav><!-- #site-navigation -->
