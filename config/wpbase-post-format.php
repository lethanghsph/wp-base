<?php
/**
 * A tiny class parser content by post format.
 *
 * @package WPBase
 */

if ( ! class_exists( 'WPBase_Post_Format' ) ) :
	/**
	 * WPBase_Post_Format class.
	 */
	class WPBase_Post_Format {

		/**
		 * //
		 *
		 * @param  string $content Content of the current post.
		 * @return array
		 */
		public static function parse_post_content( $content ) {
			$post_format = get_post_format();
			$callback = sprintf( 'parse_%s', $post_format );

			$class = new static;
			$results = array();

			if ( method_exists( $class, $callback ) ) {
				$results = call_user_func_array( array( $class, $callback ), array( $content ) );

				if ( ! empty( $results['shortcode'] ) ) {
					$content = str_replace( $results['shortcode'], '', $content );
				}
			}

			/**
			 * Filter the post content.
			 *
			 * @param string $content Content of the current post.
			 */
			$content = apply_filters( 'the_content', $content );
			$content = str_replace( ']]>', ']]&gt;', $content );

			/**
			 * //
			 *
			 * @var array
			 */
			$return = apply_filters( 'wpbase_parse_post_content', array(
				'data' => $results,
				'content' => $content,
				'post_format' => $post_format,
			) );

			return $return;
		}

		/**
		 * //
		 *
		 * <blockquote cite="Source">
		 * 		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
		 * 		<cite>Source</cite>
		 * </blockquote>
		 *
		 * @param  string $content Content of the current post to parser.
		 * @return array
		 */
		public function parse_quote( $content ) {
			if ( ! preg_match( '/<blockquote.*?>((.|\n)*?)<\/blockquote>/', $content, $matches ) ) {
				return;
			}

			$shortcode = $matches[0];
			$cite = '';

			if ( preg_match( '/cite=["|\'](.*)["|\']/', $shortcode, $cites ) ||
				preg_match( '/<cite.*?>(.*)<\/cite>/', $shortcode, $cites ) ) {
				$cite = strip_tags( $cites[1] );
			}

			$quote = strip_tags( $matches[1] );
			$quote = str_replace( $cite, '', $quote );
			$quote = trim( $quote );

			return array(
				'cite' => $cite,
				'quote' => $quote,
				'output' => $shortcode,
				'shortcode' => $shortcode,
			);
		}

		/**
		 * //
		 *
		 * @param  string $content Content of the current post to parser.
		 * @return array
		 */
		public function parse_gallery( $content ) {
			if ( ! preg_match( '/\[gallery.+?\]/', $content, $matches ) ) {
				return;
			}

			$shortcode = $matches[0];
			preg_match( '/ids=["|\'](.*)["|\']/', $shortcode, $ids );

			if ( ! empty( $ids[1] ) ) {
				$ids = explode( ',', $ids[1] );
				$ids = array_filter( $ids, array( __CLASS__, 'is_valid_id' ) );
			}

			return array(
				'ids' => $ids,
				'output' => do_shortcode( $shortcode ),
				'shortcode' => $shortcode,
			);
		}

		/**
		 * //
		 *
		 * @param  string $content Content of the current post to parser.
		 * @return array
		 */
		public function parse_audio( $content ) {
			if ( preg_match( '/(\[audio.+?\])(\[\/audio\])?/', $content, $matches ) ) {
				return array(
					'output' => do_shortcode( $matches[0] ),
					'shortcode' => $matches[0],
					'audiowp' => true,
				);
			}

			return static::parse_oembed( $content );
		}

		/**
		 * //
		 *
		 * @param  string $content Content of the current post to parser.
		 * @return array
		 */
		public function parse_video( $content ) {
			if ( preg_match( '/(\[video.+?\])(\[\/video\])?/', $content, $matches ) ) {
				return array(
					'output' => do_shortcode( $matches[0] ),
					'shortcode' => $matches[0],
				);
			}

			return static::parse_oembed( $content );
		}

		/**
		 * //
		 *
		 * @param  string $content Content of the current post to parser.
		 * @return array
		 */
		public function parse_oembed( $content ) {
			global $wp_embed;

			if ( preg_match( '/\[embed.+?\]/', $content, $matches ) ) {
				$shortcode = $matches[0];

				if ( $embed = $wp_embed->run_shortcode( $shortcode ) ) {
					return array(
						'output' => do_shortcode( $embed ),
						'shortcode' => $shortcode,
					);
				}
			}

			if ( ! preg_match( '/^\s*(https?:\/\/[^\s"]+)\s*$/im', $content, $matches ) ) {
				return;
			}

			return array(
				'link' => $matches[1],
				'output' => wp_oembed_get( $matches[1] ),
				'shortcode' => $matches[1],
			);
		}

		/**
		 * //
		 *
		 * @param  string $content Content of the current post to parser.
		 * @return array
		 */
		public function parse_link( $content ) {
			if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', $content, $matches ) ) {
				return;
			}
			$shortcode = '';
			if ( preg_match( '%(<a[^>]*>.*?</a>)%i', $content, $regs ) ) {
			    $shortcode = $regs[1];
			}
			$link = esc_url_raw( $matches[1] );
			return array(
				'link' => $link,
				'output' => $link,
				'shortcode' => $shortcode,
			);
		}

		/**
		 * //
		 *
		 * @param  integet $id //.
		 * @return boolean
		 */
		public static function is_valid_id( $id ) {
			return is_numeric( $id );
		}
	}
endif;

if ( ! class_exists( 'WPBase_Post_Template_Tag' ) ) :
	/**
	 * WPBase_Post_Template_Tag class.
	 */
	class WPBase_Post_Template_Tag {
		/**
		 * Instance of self.
		 *
		 * @var [object].
		 */
		public static $instance;

		/**
		 * Gets the instance via lazy initialization.
		 *
		 * @return self
		 */
		public static function get_instance() {
			if ( null === static::$instance ) {
				static::$instance = new static;
			}
			return static::$instance;
		}
		/**
		 * Initialization.
		 */
		private function __construct() {
			add_action( 'wpbase_single_after_content', array( $this, 'wpbase_render_navigation' ), 10 );
			add_action( 'wpbase_single_after_content', array( $this, 'wpbase_render_sharing' ), 20 );
			add_action( 'wpbase_single_after_content', array( $this, 'wpbase_render_tags' ), 30 );
			add_action( 'wpbase_single_after_content', array( $this, 'wpbase_render_related_posts' ), 40 );
		}

		/**
		 * Render navigation single post.
		 */
		public function wpbase_render_navigation() {
			get_template_part( 'template-parts/post/single-navigations' );
		}

		/**
		 * Render sharing single post.
		 */
		public function wpbase_render_sharing() {
			get_template_part( 'template-parts/post/single-sharing' );
		}

		/**
		 * Render tags single post.
		 */
		public function wpbase_render_tags() {
			get_template_part( 'template-parts/post/single-tags' );
		}

		/**
		 * Render tags single post.
		 */
		public function wpbase_render_related_posts() {
			get_template_part( 'template-parts/post/single-related-posts' );
		}
	}

endif;

if ( ! class_exists( 'WPBase_Walker_Comment' ) ) {
	class WPBase_Walker_Comment extends Walker_Comment {
		/**
		 * Outputs a comment in the HTML5 format.
		 *
		 * @since 3.6.0
		 * @access protected
		 *
		 * @see wp_list_comments()
		 *
		 * @param WP_Comment $comment Comment to display.
		 * @param int        $depth   Depth of the current comment.
		 * @param array      $args    An array of arguments.
		 */
		protected function html5_comment( $comment, $depth, $args ) {
			$tag = ( 'div' === $args['style'] ) ? 'div' : 'li'; ?>

			<<?php echo esc_html( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>

			<article id="div-comment-<?php comment_ID(); ?>" class="comment__body">
				<?php if ( 0 != $args['avatar_size'] ) : ?>
					<div class="comment__avatar">
						<a href="<?php echo esc_url( get_comment_author_url() ); ?>" title="<?php echo esc_attr( get_comment_author() ); ?>">
							<?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
						</a>
					</div><!-- /.comment__avatar -->
				<?php endif ?>

				<div class="comment__container">
					<div class="comment-metadata comment__meta">
						<h4 class="comment-author comment__author h5">
							<?php echo get_comment_author_link(); ?>
						</h4><!-- /.comment__author -->

						<span class="comment__metadata">
							<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
								<time datetime="<?php comment_time( 'c' ); ?>">
									<?php printf( esc_html__( '%1$s at %2$s', 'rentahotel' ), get_comment_date( '', $comment ), get_comment_time() ); ?>
								</time>
							</a>
						</span>

						<?php if ( '0' == $comment->comment_approved ) : ?>
							<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'rentahotel' ); ?></p>
						<?php endif; ?>
					</div><!-- /.comment-metadata -->

					<div class="comment__content entry-content">
						<?php comment_text(); ?>
					</div><!-- /.comment__content -->

					<div class="comment__action">
						<?php comment_reply_link( array_merge( $args, array(
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'add_below' => 'div-comment',
						) ) ); ?>

						<?php edit_comment_link( esc_html__( 'Edit', 'rentahotel' ) ); ?>
					</div><!-- /.comment__action -->
				</div><!-- /.comment__container -->

			</article><!-- /.comment_body --><?php
			// Note: No close tag is here.
		}
	}
}