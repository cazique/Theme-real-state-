<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

//---------------------------
// General Settings Section
//---------------------------
CSF::createSection( $prefix, array(
  'title'  => esc_html__( 'General Settings', 'luxus' ),
  'fields' => array(

    // Theme Color
    array(
      'id'    => 'sl-theme-color',
      'type'  => 'color',
      'title' => esc_html__( 'Theme Color', 'luxus' ),
      'default' => '#00BBFF',
    ),

    // Secondary Color
    array(
      'id'    => 'sl-secondary-color',
      'type'  => 'color',
      'title' => esc_html__( 'Secondary Color', 'luxus' ),
      'default' => '#3E2AD3',
    ),

    // Light Color
    array(
      'id'    => 'sl-light-color',
      'type'  => 'color',
      'title' => esc_html__( 'Light Color', 'luxus' ),
      'default' => '#F2FBFF',
    ),

    // Dark Color
    array(
      'id'    => 'sl-dark-color',
      'type'  => 'color',
      'title' => esc_html__( 'Dark Color', 'luxus' ),
      'default' => '#00072D',
    ),

    // Text Color
    array(
      'id'    => 'sl-text-color',
      'type'  => 'color',
      'title' => esc_html__( 'Text Color', 'luxus' ),
      'default' => '#555555',
    ),

    // Button Color
    array(
      'id'    => 'sl-btn-color',
      'type'  => 'color',
      'title' => esc_html__( 'Button Color', 'luxus' ),
      'default' => '#00BBFF',
    ),

    // Button Hover Color
    array(
      'id'    => 'sl-btn-hcolor',
      'type'  => 'color',
      'title' => esc_html__( 'Button Hover Color', 'luxus' ),
      'default' => '#00ABEF',
    ),

    // Body Background Color
    array(
      'id'    => 'body-bg-color',
      'type'  => 'color',
      'title' => esc_html__( 'Body Background Color', 'luxus' ),
      'default' => '#ffffff',
      'output' => array( 'background' => 'body' ),
      'output_important'  => true,
    ),

    // Enable Back To Top
    array(
      'id'         => 'back-to-top',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Enable Back To Top', 'luxus' ),
      'text_on'    => esc_html__( 'Enabled', 'luxus' ),
      'text_off'   => esc_html__( 'Disabled', 'luxus' ),
      'text_width' => 100,
      'default'    => true,
    ),

    // Enable Preloader
    array(
      'id'         => 'enable-preloader',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Enable Preloader', 'luxus' ),
      'text_on'    => esc_html__( 'Enabled', 'luxus' ),
      'text_off'   => esc_html__( 'Disabled', 'luxus' ),
      'text_width' => 100,
      'default'    => true,
    ),

    // Preloader Background Color
    array(
      'id'    => 'preloader-bg-color',
      'type'  => 'color',
      'title' => esc_html__( 'Preloader Background Color', 'luxus' ),
      'default' => '#ffffff',
      'output' => array( 'background' => '#sl-preloader' ),
      'output_important'  => true,
    ),

    // Preloader Icon
    array(
      'id'    => 'preloader-icon',
      'type'  => 'media',
      'title' => esc_html__( 'Upload Preloader Icon', 'luxus' ),
    ),

    // Map API
    array(
      'id'      => 'sl-signup-slug',
      'type'    => 'text',
      'title'   => esc_html__( 'Signup Page Slug', 'luxus' ),
      'default' => 'wp-login.php?action=register',
    ),

    // Map API
    array(
      'id'      => 'sl-map-api',
      'type'    => 'text',
      'title'   => esc_html__( 'Google Map API', 'luxus' ),
    ),

  )
) );