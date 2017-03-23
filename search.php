<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WPBase
 * @since 1.0
 * @version 1.0
 */

$GLOBALS['wpbase_layout_class'] = 'pt-70 pb-100';
get_header(); ?>

	<div class="container">
		<header class="page-header">
			<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'wpbase' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
		</header><!-- .page-header -->
	</div>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php

		if ( have_posts() ) :

			/**
			 * Begin the loop hook.
			 */
			do_action( 'wpbase_begin_the_loop' );

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/post/content', get_post_format() );

			endwhile;

			/**
			 * End the loop hook.
			 */
			do_action( 'wpbase_end_the_loop' );

			WPBase()->extra->wpbase_pager();

		else :

			get_template_part( 'template-parts/post/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
