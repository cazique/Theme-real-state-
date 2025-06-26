<?php
/**
 * Luxus functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Luxus
 */

if ( ! defined( 'LUXUS_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'LUXUS_VERSION', '1.0.1' );
}

if ( ! defined( 'LUXUS_ELEMENTOR_ACTIVE' ) ) {
	define( 'LUXUS_ELEMENTOR_ACTIVE', class_exists( 'Elementor\Plugin' ) );
}

// Custom function for get an option
if ( ! function_exists( 'luxus_options' ) ) {

  function luxus_options( $option = '', $default = null ) {
    $options = get_option( 'luxus_options' ); // Unique id of the framework
    return ( isset( $options[$option] ) ) ? $options[$option] : $default;
  }

}

// Custom function for get page meta
if ( ! function_exists( 'luxus_page_meta' ) ) {

  function luxus_page_meta( $key = '', $default = null ) {
  	$meta = get_post_meta( get_the_ID(), 'sl_page_options', true );
    return ( isset( $meta[$key] ) ) ? $meta[$key] : $default;
  }

}

// Custom function for get post meta
if ( ! function_exists( 'luxus_post_meta' ) ) {

  function luxus_post_meta( $key = '', $id = '', $default = null ) {
    $get_the_id = ( !empty( $id ) ? $id : get_the_ID() );
    $meta = get_post_meta( $get_the_id, $key, true );
    return ( isset( $meta ) ) ? $meta : $default;
  }

}

// Functions which enhance the theme by hooking into WordPress.
require get_template_directory() . '/inc/template-functions.php';

// Required Plugins Activation.
require get_template_directory() . '/inc/tgm-plugin-activation/install-plugins.php';

// Implement Luxus Widgets.
require get_template_directory() . '/inc/class-elementor-widgets.php';

// Implement Luxus Widgets Style and Scripts.
if ( defined('ELEMENTOR_VERSION') ) {
  require_once get_template_directory() .'/inc/widgets/custom-css.php';
}

// Implement Luxus Style and Scripts.
require get_template_directory() . '/inc/enqueue-scripts-styles.php';

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

// Theme Styles.
require get_template_directory() . '/inc/template-styles.php';

// Comments Template.
require get_template_directory() . '/inc/comments-template.php';

// Theme Options.
require get_template_directory() . '/inc/theme-options/theme-options.php';
require get_template_directory() . '/inc/theme-options/page-options.php';

// Theme Demo Content.
require get_template_directory() . '/inc/demo-content.php';

// Woocommerce
require get_template_directory() . '/inc/woocommerce-init.php';

// Load Jetpack compatibility file.
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
