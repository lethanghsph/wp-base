<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>
	<?php if ( empty( $GLOBALS['wpbase_hidden_layout'] ) ) : ?>
		</div><!-- #layout -->
	<?php endif ?>

	</div><!-- #site-content -->
	<footer id="site-footer" role="contentinfo">
		<div class="wrap">


		</div><!-- .wrap -->
	</footer><!-- #site-footer -->
</div><!-- #page -->
<?php wp_footer(); ?>

</body>
</html>
