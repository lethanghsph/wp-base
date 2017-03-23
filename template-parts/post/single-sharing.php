<?php
/**
 * Template part for single sharing.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WPBase
 */

if ( ! $share = WPBase()->social->get_share() ) {
	return;
}
?>
<ul class="wpbase-social-sharing">
	<li>
		<span><i class="fa fa-share-alt" aria-hidden="true"></i></span>
	</li>
	<?php foreach ( $share as $key => $value ) : ?>
	<li>
		<a href="<?php echo esc_url( $value['link'] ) ?>" title="<?php echo esc_html( $value['name'] ) ?>" target="_blank"><i class="fa fa-<?php echo esc_html( $key ) ?>"></i></a>
	</li>
	<?php endforeach; ?>
</ul>
