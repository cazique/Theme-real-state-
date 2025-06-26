<?php
/**
 * Theme Header
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Luxus
 */

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php

	wp_body_open();

	// Page Header
	$page_header = luxus_page_meta( '_page_header' );

	// Geting Custom Header IDs
    if ( post_type_exists( 'luxus_content_block' ) ) {
	
        // Get All Custom Header Ids
    	$custom_header_ids = get_posts(array(
            'post_type' => 'luxus_content_block',
            'post_status'    => 'publish',
            'fields'          => 'ids',
            'posts_per_page'  => -1,
            'meta_key'  => 'luxus_content_block_type',
            'meta_value'  => 'header',
        ));
    }

    // Header Breakpoint
	if ( class_exists('CSF') ) {
		$header_breakpoint_opt = luxus_options('mob-header-breakpoint');
		$header_breakpoint = !empty($header_breakpoint_opt) ? $header_breakpoint_opt : 1200;
	} else {
		$header_breakpoint = 1200;
	}

    // Theme Header
    echo '<header class="luxus-header theme-header" data-breakpoint="'.esc_attr($header_breakpoint).'">';

	    if ( !empty($page_header) ) {

			if ( post_type_exists('luxus_content_block') && in_array($page_header, $custom_header_ids) ) {

				echo '<div class="custom-header">';
						do_action( 'luxus_header' );
				echo '</div>';

			} else {

				get_template_part('template-parts/header/header', 'classic');

			}

		} else {

			$site_header = luxus_options('site-header');

			if ( post_type_exists('luxus_content_block') && in_array($site_header, $custom_header_ids) ) {

				echo '<div class="custom-header">';
						do_action('luxus_header');
				echo '</div>';

			} else {

				get_template_part('template-parts/header/header', 'classic');
				
			}
		}

	echo '</header>';

?>

<!-- Page Starts -->
<div id="page" class="site">
	