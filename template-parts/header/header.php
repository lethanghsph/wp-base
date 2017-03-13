<?php
/**
 * Template for header
 *
 * @package wpbase
 */

?>

<header id="masthead" class="site-header">
	<div class="container">
		<div class="header-logo">
			<h1 class="h2"><?php _e( 'BASE' ) ?></h1>
		</div>
		<div class="header-icon">
			<div class="header__search">
				<a href="#" class="header__search-toggle pull-right"><i class="fa fa-search"></i></a>
				<div class="hide">
				<?php get_search_form(); ?>
				</div>
			</div>		
		</div>
		<?php if ( has_nav_menu( 'top' ) ) : ?>
			<div class="header-menu">
				<a href="#side-menu" class="hide" data-toggle="modal" data-target="#side-menu">
					<i class="fa fa-bars"></i>
				</a>
				<?php get_template_part( 'template-parts/navigation/primary', 'desktop' ); ?>
			</div><!-- .wrap -->

		<?php endif; ?>

	</div>
</header><!-- #masthead -->
