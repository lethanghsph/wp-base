<?php
/**
 * Template for header
 *
 * @package wpbase
 */
$test = WPBase_WooCoomerce::get_instance();
?>

<header id="site-header" class="site-header" data-spy="affix" data-offset-top="150">
	<div class="container">
		<div class="header-logo">
			<h1 class="h2"><a href="<?php echo esc_url( home_url( '/' ) ) ?>"><?php esc_html_e( 'BASE', 'wpbase' ) ?></a></h1>
		</div>
		<div class="header-icon">
			<div class="item">
				<a href="#side-menu" class="header-icon__menu" data-toggle="modal" data-target="#side-menu">
					<i class="fa fa-bars"></i>
				</a>
				<?php get_template_part( 'template-parts/navigation/primary', 'mobile' ); ?>
			</div>
			<div class="item">
				<a href="#side-search" class="header-icon__search"><i class="fa fa-search"></i></a>
				<div class="hide">
				<?php get_search_form(); ?>
				</div>
			</div>
			<div class="item dropdown">
				
				<?php echo $test->header_minicart_link() ?>
					<div class="dropdown-menu">
						
					
				<?php echo $test->header_minicart() ?>
</div>
			</div>
		</div>
		<?php if ( has_nav_menu( 'top' ) ) : ?>
			<div class="header-menu">
				
				<?php get_template_part( 'template-parts/navigation/primary', 'desktop' ); ?>
			</div><!-- .wrap -->

		<?php endif; ?>

	</div>
</header><!-- #masthead -->
