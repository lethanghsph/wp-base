<?php
/**
 * Twenty Seventeen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */

/**
 * Twenty Seventeen only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

/**
 * Implement the Custom Header feature.
 */
require get_parent_theme_file_path( '/inc/register-support.php' );

/**
 * Implement the Custom Header feature.
 */
require get_parent_theme_file_path( '/inc/register-assets.php' );

/**
 * Implement the Custom Header feature.
 */
require get_parent_theme_file_path( '/inc/config-sidebar.php' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

