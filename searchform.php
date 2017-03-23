<?php
/**
 * Template for displaying search forms in Twenty Seventeen
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
?>

<?php $unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>


<div class="search">
	<form role="search" method="get" class="search__form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="search" id="<?php echo $unique_id; ?>" class="search__input" placeholder="<?php esc_attr_e( 'Search...', 'rentahotel' ); ?>"  value="<?php echo get_search_query(); ?>" name="s">

		<button type="submit" class="search__button"><i class="fa fa-search"></i><span class="screen-reader-text"><?php echo _x( 'Search', 'submit button', 'twentyseventeen' ); ?></span></button>
	</form>
</div>

