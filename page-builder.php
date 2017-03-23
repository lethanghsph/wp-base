<?php
/**
 * Template Name: Page Builder
 * Description: Template for page builder.
 *
 * @package Brilliant
 */

$GLOBALS['wpbase_hidden_layout'] = true;

get_header(); ?>

	<main id="main" class="site-main">
		<?php while ( have_posts() ) : the_post(); ?>

			<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php the_content(); ?>
			</div><!-- #post-## -->

		<?php endwhile; ?>
	</main><!-- #main -->

<?php get_footer(); ?>
