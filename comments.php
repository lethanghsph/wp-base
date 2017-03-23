<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WPBase
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( // WPCS: XSS OK.
					esc_html( _nx( '%1$s comment', '%1$s comments', get_comments_number(), 'comments title', 'wpbase' ) ),
					'<span>' . number_format_i18n( get_comments_number() ) . '</span>',
					'<span>' . get_the_title() . '</span>'
				);
			?>
		</h2>

		<ol class="comment-list mt-50 mb-70">
			<?php
			wp_list_comments( array(
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 70,
				'walker'    => new WPBase_Walker_Comment(),
			) );
			?>
		</ol><!-- /.comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'wpbase' ); ?></h2>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'wpbase' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'wpbase' ) ); ?></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-below -->
		<?php
		endif; // Check for comment navigation.

	endif; // Check for have_comments().


	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'wpbase' ); ?></p>
	<?php
	endif;

	// Comment form.
	comment_form( array(
		'class_submit'  => 'submit-button comment-submit-button',
		'label_submit'	=> esc_html__( 'Comment', 'wpbase' ),
		'submit_button' => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s</button>',
		'comment_field' => '<div class="form-group comment-form-comment"><label class="screen-reader-text" for="comment">' . esc_html__( 'Your Comment', 'wpbase' ) . '</label> <textarea id="comment" name="comment" cols="45" rows="8" required="required" placeholder="' . esc_html__( 'Your Comment', 'wpbase' ) . '"></textarea></div>',

		'comment_notes_before' => '',
		'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title text-uppercase mb-35">',
		'title_reply_after'    => '</h3>',

		'fields' => array(
			'author' => '<div class="form-group form-small comment-form-author pull-left"> <label class="screen-reader-text" for="author">' . esc_html__( 'Your Name', 'wpbase' ) . '</label> <input id="author" name="author" type="text" placeholder="' . esc_html__( 'Your Name', 'wpbase' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" required="required"></div>',
			'email'  => '<div class="form-group form-small comment-form-email pull-left"><label class="screen-reader-text" for="email">' . esc_html__( 'Your Email', 'wpbase' ) . '</label> <input id="email" name="email" type="email" placeholder="' . esc_html__( 'Your Email', 'wpbase' ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) . '" required="required"></div>',
			'url'    => '<div class="form-group form-small comment-form-url pull-right"><label class="screen-reader-text" for="url">' . esc_html__( 'Website', 'wpbase' ) . '</label> <input id="url" name="url" type="url" placeholder="' . esc_html__( 'Your Website', 'wpbase' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) . '" required="required"></div>',
		),
	) );
	?>

</div><!-- #comments -->
