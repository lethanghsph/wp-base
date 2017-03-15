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
<?php
/**
 * Template for Navigation Menu
 *
 * @package Rent_a_hotel
 */

?>
<div id="side-slide" tabindex="-1" role="dialog">
	<div class="side-slide__icon">
		<div class="col-xs-12">
			<div class="item">
				<a href="#side-menu" class="header-icon__menu" data-toggle="modal" data-target="#side-menu">
					<i class="fa fa-times"></i>
				</a>
			</div>
			<div class="item">
				<a href="#side-search" class="header-icon__search"><i class="fa fa-search"></i></a>
			</div>
		</div>
	</div>
	<div class="side-slide__menu">
		<nav class="menu" role="navigation" aria-label="<?php esc_html__( 'Primary Menu Mobile', 'wpbase' ); ?>">
			<?php wp_nav_menu( array(
				'theme_location' => 'top',
				'menu_id'        => '',
				'menu_class'     => 'navs navs-vertical',
			) ); ?>
		</nav><!-- #site-navigation -->
	</div>
</div>
<div id="body_overlay"></div>
