<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'wpbase' ); ?></a>

	<?php print( WPBase()->header->actionHeader() ); // WPCS: XSS OK. ?>

	<div id="site-content" <?php WPBase()->extra->wpbase_content_class() ?>>

	<?php if ( empty( $GLOBALS['hidden_layout'] ) ) : ?>
		<div id="layout" <?php WPBase()->extra->wpbase_layout_class( isset( $GLOBALS['layout_class'] ) ? $GLOBALS['layout_class'] : '' ) ?>>
	<?php endif ?>
