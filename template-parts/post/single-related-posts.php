<?php
/**
 * Template part for single related posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WPBase
 */

// Set required arguments.
$args = array();
$args['post__not_in'] = array( get_the_ID() );
$args['ignore_sticky_posts'] = true;
$args['posts_per_page'] = WPBase()->options->wpbase_option( 'related_post_count' );

// Tags.
$tag_ids = array();
$tags = wp_get_post_tags( get_the_ID() );
foreach ( $tags as $individual_tag ) {
	$tag_ids[] = $individual_tag->term_id;
}
$args['tag__in'] = $tag_ids;
$related_query = new WP_Query( $args );

?>
<?php if ( $related_query->have_posts() ) : ?>

	<section class="wpbase-related-posts">
		<h3><?php esc_html_e( 'You might also like', 'wpbase' ); ?></h3>

		<div class="row row-eq-height">
			<?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
			<div class="col-md-6 col-xs-12 mb-10">
				<div <?php post_class( 'related-posts' ); ?>>
					<?php if ( get_the_post_thumbnail() ) : ?>
						<div class="related-posts__image">
							<?php the_post_thumbnail( 'wpbase-medium' ); ?>
						</div>
					<?php endif; ?>

					<div class="related-posts__content">
						<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );?>

						<ul class="entry-meta-list">
							<li>
								<?php WPBase()->extra->wpbase_posted_on(); ?>
							</li>
						</ul><!-- /.entry-meta -->
						<a href="<?php echo esc_url( get_permalink() ); ?>" class="entry-more-link" rel="bookmark">
							<?php echo esc_html_e( 'Read more...', 'wpbase' ); ?>
						</a>
					</div>
				</div>
			</div>
			<?php endwhile; ?>
		</div>
	</section>
<?php endif ?>

<?php wp_reset_postdata(); ?>
