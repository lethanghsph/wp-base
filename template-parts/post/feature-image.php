<?php
/**
 * Template part for feature image post.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Rentahotel
 */

if ( ! is_single() && is_sticky() ) : ?>
	<span class="label-sticky"><i class="fa fa-star"></i></span>
<?php endif;

global $postdata;

/**
 * //
 *
 * @var array
 */
$parser_data = wp_parse_args( $postdata['data'], array(
	'output' => '',
	'shortcode' => '',
) );
/**
 * Display feature thumbnail
 */

if ( empty( $postdata['data']['shortcode'] ) ) :

	if ( has_post_thumbnail() ) : ?>
		<div class="rent-thumbnail">
			<?php if ( is_single() ) : ?>
			<span>
				<?php the_post_thumbnail( isset( $GLOBALS['thumbnail_size'] ) ? $GLOBALS['thumbnail_size'] : 'post-thumbnail' ); ?>
			</span>
			<?php else : ?>
			<a href="<?php echo esc_url( get_permalink() ); ?>">
				<?php the_post_thumbnail( isset( $GLOBALS['thumbnail_size'] ) ? $GLOBALS['thumbnail_size'] : 'post-thumbnail' ); ?>
			</a>
			<?php endif; ?>
		</div>

	<?php endif;

	return;
endif;

/**
 * Display post format feature
 */
switch ( $postdata['post_format'] ) {
	case 'audio':

		$audio_class = 'embed-responsive embed-responsive-audio embed-responsive-4by3';
		if ( isset( $parser_data['audiowp'] ) ) {
			$audio_class .= ' audio-embed-wp';
		}
		printf( '<div class="post-media"><div class="%1s">%2s</div></div>', $audio_class, $parser_data['output'] ); // WPCS: XSS OK.
		break;

	case 'video':

		if ( has_post_thumbnail() ) : ?>

		<div class="entry-media entry-media-oembed">
			<a href="<?php echo esc_url( $parser_data['link'] ); ?>" class="" target="_blank">
				<?php the_post_thumbnail( isset( $GLOBALS['thumbnail_size'] ) ? $GLOBALS['thumbnail_size'] : 'post-thumbnail' ); ?>

				<span class="rentahotel-play">
					<span class="sr-only"><?php echo esc_html__( 'Play', 'wpbase' ); ?></span>
					<i class="fa fa-play" aria-hidden="true"></i>
				</span>
			</a>
		</div><!-- /.entry-media -->

		<?php
		endif;

		printf( '<div class="embed-responsive embed-responsive-video">%s</div>', $parser_data['output'] ); // WPCS: XSS OK.
		break;

	case 'gallery':

		if ( empty( $parser_data['ids'] ) ) {
			return;
		}
		?>
		<div data-arrows="true" data-init="slick" data-dots="false" data-autoplay="false">
			<?php foreach ( $parser_data['ids'] as $id ) :
				$attachment_meta = wp_prepare_attachment_for_js( $id ); ?>
					<span>
					<?php echo wp_get_attachment_image( $id, isset( $GLOBALS['thumbnail_size'] ) ? $GLOBALS['thumbnail_size'] : 'post-thumbnail' ); ?>
					</span>
			<?php endforeach; ?>
		</div>
		<?php
		break;

	case 'quote':

		$style = '';
		if ( has_post_thumbnail() ) {
			$post_thumbnail_id = get_post_thumbnail_id();
			$style = sprintf( 'style="background-image: url( %1$s )"', wp_get_attachment_image_url( $post_thumbnail_id, 'full' ) );
		}
		?>
		<div class="entry-quote">
			<blockquote class="blockquote--dark" <?php print $style;// WPCS xss: ok.?>>
				<?php echo wp_kses_post( $parser_data['quote'] ); ?>

				<?php if ( $parser_data['cite'] ) : ?>
				<small><?php echo esc_html( $parser_data['cite'] ); ?></small>
				<?php endif;?>
			</blockquote>
		</div><!-- /.entry-quote -->
	
		<?php
		break;

	case 'link':

		$style = '';
		if ( has_post_thumbnail() ) {
			$post_thumbnail_id = get_post_thumbnail_id();
			$style = sprintf( 'style="background-image: url( %1$s )"', wp_get_attachment_image_url( $post_thumbnail_id, 'full' ) );
		}
		?>
		<div class="entry-link" <?php print $style; // Wpcs: xss ok.?>>
			<div class="link-icon">
				<i class="fa fa-link"></i>
			</div>
			<div class="post-link">
				<?php the_title( '<h3 class="entry-title">', '</h3>' ); ?>
			  	<?php print $parser_data['shortcode']; // WPCS xss: ok.?>
			</div>
		</div>
		<?php
		break;
}
