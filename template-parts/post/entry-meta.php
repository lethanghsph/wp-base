<?php
/**
 * Template part for entry meta posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Rent a hotel
 */

$category_exists = WPBase()->extra->wpbase_categorized_blog();

?>
<ul class="entry-meta-list">
	<?php

	/**
	 * Before entry meta template
	 */
	do_action( 'rentahotel_before_entry_meta' );
	?>
	
	<?php if ( 'post' === get_post_type() && $category_exists && empty( $GLOBALS['hidden_post_categories'] ) ) : ?>
		<li>
			<?php
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'rentahotel' ) );
			if ( $categories_list && $category_exists ) {
				printf( '<span class="cat-links">' . esc_html__( ' In %1$s', 'rentahotel' ) . '</span>', $categories_list ); // WPCS: xss ok.
			}
			?>
		</li>
	<?php endif;	?>
	

	<li>
		<?php WPBase()->extra->wpbase_posted_on(); ?>
	</li>

	<li>
		<?php
			printf(
				esc_html_x( 'by %s', 'post author', 'rentahotel' ),
				'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
			); // WPCS: xss ok.
		?>
	</li>

	<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) && empty( $GLOBALS['hidden_post_comments'] ) ) : ?>
		<li class="comment-link">
			<?php comments_popup_link( esc_html__( 'Leave a comment', 'rentahotel' ), apply_filters( 'rentahotel_comment_icon', '<i class="fa fa-comment-o" aria-hidden="true"></i>1' ), apply_filters( 'rentahotel_comment_icon', '<i class="fa fa-comment-o" aria-hidden="true"></i>%' ), 'el-link' ); ?>
		</li>
	<?php endif; ?>

	<?php

	/**
	 * After entry meta template
	 */
	do_action( 'rentahotel_after_entry_meta' );

	/**
	 * Edit post link
	 */
	$edit_text = sprintf(
		/* translators: %s: Name of current post */
		esc_html__( 'Edit %s', 'rentahotel' ),
		the_title( '<span class="screen-reader-text">"', '"</span>', false )
	);
	edit_post_link( $edit_text, '<li class="edit-link">', '</li>', 0, 'el-link' );

	?>
</ul><!-- /.entry-meta -->
