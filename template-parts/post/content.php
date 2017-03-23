<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WPBase
 */

global $postdata, $wp_query;

/**
 * The content of the current post.
 *
 * @var string
 */
$the_content = get_the_content( sprintf(
	wp_kses( __( 'Read more %s', 'wpbase' ), array( 'span' => array( 'class' => array() ) ) ),
	the_title( '<span class="screen-reader-text">"', '"</span>', false )
) );

// Parse post content by post format.
$postdata = WPBase_Post_Format::parse_post_content( $the_content );

do_action( 'wpbase_open_tags_post_item' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php get_template_part( 'template-parts/post/feature-image' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-container">
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>

		<div class="entry-meta">
			<?php get_template_part( 'template-parts/post/entry-meta' ); ?>
		</div><!-- .entry-meta -->

		<?php
		endif; ?>

		<div class="entry-content">
			<?php
			if ( is_single() ) :
				/**
				 * Filter the post content.
				 *
				 * @param string $content Content of the current post.
				 */
				$content = apply_filters( 'the_content', $postdata['content'] );
				$content = str_replace( ']]>', ']]&gt;', $content );

				print apply_filters( 'wpbase_the_content', $content ); // WPCS: XSS OK.

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wpbase' ),
					'after'  => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				) );
			else :
				the_excerpt();
			endif;
			?>

		</div><!-- .entry-content -->
	</div><!-- .entry-container -->

	<?php if ( ! is_single() ) : ?>

	<footer class="entry-footer">
		<?php get_template_part( 'template-parts/post/entry-footer' ); ?>
	</footer><!-- .entry-footer -->

	<?php endif; ?>

</article><!-- #post-## -->
<?php do_action( 'wpbase_close_tags_post_item' ); ?>
