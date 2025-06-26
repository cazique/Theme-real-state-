<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * The template for displaying all single posts of 'property post type'
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package luxus
 */

global $wpdb;

// Contact Form / Schedule Tour Form
$author_id = get_post_field ( 'post_author', get_the_ID() );
$current_user_id = $current_user->ID;
$current_user_name = $current_user->display_name;
$current_user_email = $current_user->user_email;

$user_id = '';
$get_user_data = '';

if(is_user_logged_in())
{
    // Loged in User Id
    $user_id    =  get_current_user_id();
    // User Meta
    $get_user_data = get_user_meta( $user_id, '_luxus_user_favourite_properties', TRUE);
}

$luxus_panorama_img = luxus_post_meta( '_property_panorama');

if( $luxus_panorama_img != NULL ){
    wp_enqueue_script( 'three-min', SL_PLUGIN_URL . 'public/js/three.min.js', array( 'jquery' ), true );
    wp_enqueue_script( 'browser-min', SL_PLUGIN_URL . 'public/js/browser.min.js', array( 'jquery' ), true );
    wp_enqueue_script( 'photo-sphere', SL_PLUGIN_URL . 'public/js/photo-sphere-viewer.min.js', array( 'jquery' ), true );
}

get_header();

// Theme Option Sidebar
$sidebar_position = luxus_options('property-single-sidebar-position');
$enable_video = luxus_options('property-single-enable-video');
$enable_virtual_tour = luxus_options('property-single-enable-virtual-tour');
$enable_map = luxus_options('property-single-enable-map');
$enable_schedule_tour = luxus_options('property-single-enable-schedule-tour');
$enable_contact_form = luxus_options('property-single-enable-contact');
$enable_relative_posts = luxus_options('property-single-enable-relative');
$enable_reviews = luxus_options('property-single-enable-reviews');

// Property Meta Boxes
$_property_type = luxus_post_meta('_property_type');
$property_type = !empty( $_property_type ) ? get_term( $_property_type ) : null;
$_property_status = luxus_post_meta('_property_status');
$property_status = !empty( $_property_status ) ? get_term( $_property_status ) : null;

$property_price = luxus_post_meta( '_property_price' );
$property_price_prefix = luxus_post_meta( '_property_price_prefix' );
$property_price_postfix = luxus_post_meta( '_property_price_postfix' );
$property_bedrooms = luxus_post_meta( '_property_bedrooms' );
$property_bathrooms = luxus_post_meta( '_property_bathrooms' );
$property_parking = luxus_post_meta( '_property_parking' );
$property_build = luxus_post_meta( '_property_build' );
$property_area = luxus_post_meta( '_property_area' );
$property_area_postfix = luxus_post_meta( '_property_area_postfix' );
$property_larea = luxus_post_meta( '_property_larea' );
$property_larea_postfix = luxus_post_meta( '_property_larea_postfix' );
$property_features = get_the_terms( get_the_ID(), 'property_feature' );
$property_add_features = luxus_post_meta( '_property_add_features' );

$property_video = luxus_post_meta( '_property_video' );
$property_gallery = luxus_post_meta( '_property_gallery' );
$property_panorama = luxus_post_meta( '_property_panorama');

$property_nearby = luxus_post_meta( '_property_nearby' );
$property_st_address = luxus_post_meta( '_property_st_address' );
$_property_city = luxus_post_meta( '_property_city' );
$property_city = !empty( $_property_city ) ? get_term( $_property_city ) : null;
$_property_state = luxus_post_meta( '_property_state' );
$property_state = !empty( $_property_state ) ? get_term( $_property_state ) : null;
$property_zip_code = luxus_post_meta( '_property_zip' );
$_property_country = luxus_post_meta( '_property_country' );
$property_country = !empty( $_property_country ) ? get_term( $_property_country ) : null;

$propery_address = ( !empty( $property_st_address ) ? $property_st_address . ', ' : null ) . ( isset( $property_city->name ) ? $property_city->name . ', ' : null ) . ( !empty( $property_zip_code ) ? $property_zip_code . ', ' : null ) . ( isset( $property_state->name ) ? $property_state->name . ', ' : null ) . ( isset( $property_country->name ) ? $property_country->name : null );

if ( $enable_map == true ){

    $property_map = luxus_post_meta( '_property_map');
}

if( $property_gallery != NULL || $property_video != NULL ){
    wp_enqueue_script( 'magnific-popup', esc_url(get_template_directory_uri()) . '/assets/js/jquery.magnific-popup.min.js', array(), '1.0', true );
}

$property_single_style = 'one';

if ($property_single_style == 'one') {

	// Property Single Template Parts
    require dirname( __FILE__ ) . '/template-parts/property-single-one.php';

} elseif ($property_single_style == 'two' ) {

	// Property Single Template Parts
    require dirname( __FILE__ ) . '/template-parts/property-single-two.php';

} else {

	// Property Single Template Parts
    require dirname( __FILE__ ) . '/template-parts/property-single-one.php';
}

// Print Property Script
wp_register_script( 'luxus-print-property', '', array(), '', true );
wp_enqueue_script( 'luxus-print-property'  );

wp_add_inline_script( 'luxus-print-property', '
    function sl_print(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
');

get_footer();
