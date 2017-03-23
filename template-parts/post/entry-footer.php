<?php
/**
 * Template part for entry footer posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WPBase
 */

?>
<div class="entry-footer-container clearfix">

	<a href="<?php echo esc_url( get_permalink() ); ?>" class="entry-more-link" rel="bookmark">
		<?php echo esc_html_e( 'Read more...', 'wpbase' ); ?>
	</a>

	<?php if ( $share = WPBase()->social->get_share() ) : ?>
	<div class="dropdown post-sharing">
		<button class="post-sharing-button" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fa fa-share-alt" data-toggle="tooltip" data-placement="top" title="<?php esc_attr_e( 'Share', 'wpbase' ) ?>" aria-hidden="true"></i>
		</button>
		<ul class="dropdown-menu">
			<?php foreach ( $share as $key => $value ) : ?>
			<li>
				<a href="<?php echo esc_url( $value['link'] ) ?>" title="<?php echo esc_html( $value['name'] ) ?>" target="_blank">
					<i class="fa fa-<?php echo esc_html( $key ) ?>" aria-hidden="true"></i>
					<span><?php echo esc_html( $value['name'] ) ?></span>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>
</div>

<?php the_tags( '<div class="post-tags mt-30">', ' ', '</div>' ); ?>

