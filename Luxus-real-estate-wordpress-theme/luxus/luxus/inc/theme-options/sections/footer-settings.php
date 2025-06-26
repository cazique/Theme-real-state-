<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

// Getting Custome Footers
function luxus_get_footers() {

  $footers = array(
    'classic-footer' => esc_html__( 'Classic Footer', 'luxus' ),
  );

  if ( post_type_exists('luxus_content_block') ) {

    $footer_args = array(
      'post_type' => 'luxus_content_block',
      'meta_key'   => 'luxus_content_block_type',
      'meta_value' => 'footer'
    );

    $custom_footers = get_posts( $footer_args );

    if ( $custom_footers ) {
      foreach ( $custom_footers as $footer ) :
        setup_postdata( $footer );

        $footers[$footer->ID] = $footer->post_title;

      endforeach; 
      wp_reset_postdata();
    }

  }

  return $footers;
}

//---------------------
// Footer Section
//---------------------
CSF::createSection( $prefix, array(
  'title'  => esc_html__( 'Footer', 'luxus' ),
  'fields' => array(

    // Select Site Footer
    array(
      'id'          => 'site-footer',
      'type'        => 'select',
      'title'       => esc_html__( 'Select Site Footer', 'luxus' ),
      'options'     => 'luxus_get_footers',
      'default'     => 'classic-footer'
    ),

    // A Notice
    array(
      'type'    => 'notice',
      'style'   => 'info',
      'content' => esc_html__( 'Only the Classic Footer will be affected by the following options.', 'luxus' ),
    ),

    array(
      'id'          => 'footer-columns',
      'type'        => 'select',
      'title'       => esc_html__( 'Number of Columns Show in Footer', 'luxus' ),
      'options'     => array(
        'one'  => esc_html__( '1 Column', 'luxus' ),
        'two'  => esc_html__( '2 Column', 'luxus' ),
        'three'  => esc_html__( '3 Column', 'luxus' ),
        'four'  => esc_html__( '4 Column', 'luxus' ),
      ),
      'default'     => 'four'
    ),

    // Footer Width
    array(
      'id'          => 'footer-width',
      'type'        => 'select',
      'title'       => esc_html__( 'Footer Width', 'luxus' ),
      'options'     => array(
        'container'  => esc_html__( 'Boxed', 'luxus' ),
        'container-fluid'  => esc_html__( 'Full Width', 'luxus' ),
      ),
      'default'     => 'container-fluid'

    ),

    // Footer Background
    array(
      'id'    => 'footer-bg',
      'type'  => 'background',
      'title' => esc_html__( 'Footer Background', 'luxus' ),
      'output' => array( 'background' => '.classic-footer' ),
      'background_gradient' => true,
      'default'                         => array(
        'background-color'              => '#00072D',
        'background-gradient-color'     => 'rgba(0,28,85,0.9)',
        'background-gradient-direction' => '135deg',
        'background-size'               => 'cover',
        'background-position'           => 'center center',
        'background-repeat'             => 'no-repeat',
      )
    ),

    // Enable Footer Bottom
    array(
      'id'         => 'enable-footer-bottom',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Enable Footer Bottom', 'luxus' ),
      'text_on'    => esc_html__( 'Enabled', 'luxus' ),
      'text_off'   => esc_html__( 'Disabled', 'luxus' ),
      'text_width' => 100,
      'default'    => true,
    ),

    // Footer Bottom Background
    array(
      'id'    => 'footer-bottom-bg',
      'type'  => 'color',
      'title' => esc_html__( 'Footer Bottom Background', 'luxus' ),
      'default' => '#000523',
      'output' => array( 'background' => '.footer-bottom' ),
      'dependency' => array( 'enable-footer-bottom', '==', 'true' ),
    ),

    // Footer Bottom
    array(
      'id'      => 'footer-bottom-text',
      'type'    => 'textarea',
      'title'   => esc_html__( 'Footer Bottom Textarea', 'luxus' ),
      'dependency' => array( 'enable-footer-bottom', '==', 'true' ),
      'default' => esc_html__( 'Copyright © All rights reserved - Luxus', 'luxus' ),
    ),
  )
) );