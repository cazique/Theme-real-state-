<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

// CPT Agent Options

// Control core classes for avoid errors
if( class_exists( 'CSF' ) ) {

  // Set a unique slug-like ID
  $prefix = 'sl_agent_options';
  $meta_prefix = '_';

  // Create a metabox
  CSF::createMetabox( $prefix, array(
    'title'     => esc_html__('Agent Information', 'luxus-core'),
    'post_type' => 'agent',
    'data_type'      => 'unserialize',
  ) );

  // Create a section
  CSF::createSection( $prefix, array(
    'title'  => esc_html__('General Information', 'luxus-core'),
    'fields' => array(

      // Profile Image
      array(
        'id'      => $meta_prefix . 'user_profile_img',
        'type'    => 'media',
        'title'   => esc_html__('Profile Image', 'luxus-core'),
        'library' => 'image',
      ),

      // Designation
      array(
        'id'      => $meta_prefix . 'user_designation',
        'type'    => 'text',
        'title'   => esc_html__('Designation', 'luxus-core'),
      ),

      // License
      array(
        'id'      => $meta_prefix . 'user_license',
        'type'    => 'text',
        'title'   => esc_html__('License', 'luxus-core'),
      ),

      // Tax Number
      array(
        'id'      => $meta_prefix . 'user_tax_number',
        'type'    => 'text',
        'title'   => esc_html__('Tax Number', 'luxus-core'),
      ),

      // Phone Number
      array(
        'id'      => $meta_prefix . 'user_phone',
        'type'    => 'text',
        'title'   => esc_html__('Phone Number', 'luxus-core'),
      ),

      // Cell Number
      array(
        'id'      => $meta_prefix . 'user_cell',
        'type'    => 'text',
        'title'   => esc_html__('Cell Number', 'luxus-core'),
      ),

      // Fax Number
      array(
        'id'      => $meta_prefix . 'user_fax',
        'type'    => 'text',
        'title'   => esc_html__('Fax Number', 'luxus-core'),
      ),

      // Email
      array(
        'id'      => $meta_prefix . 'user_email',
        'type'    => 'text',
        'title'   => esc_html__('Email', 'luxus-core'),
      ),

      // Website
      array(
        'id'      => $meta_prefix . 'user_website',
        'type'    => 'text',
        'title'   => esc_html__('Website', 'luxus-core'),
      ),

    )
  ) );

  // Create a section
  CSF::createSection( $prefix, array(
    'title'  => esc_html__('Agent Social', 'luxus-core'),
    'fields' => array(


      // Facebook
      array(
        'id'      => $meta_prefix . 'user_facebook',
        'type'    => 'text',
        'title'   => esc_html__('Facebook', 'luxus-core'),
      ),

      // Twitter
      array(
        'id'      => $meta_prefix . 'user_twitter',
        'type'    => 'text',
        'title'   => esc_html__('Twitter', 'luxus-core'),
      ),

      // LinkedIn
      array(
        'id'      => $meta_prefix . 'user_linkedIn',
        'type'    => 'text',
        'title'   => esc_html__('LinkedIn', 'luxus-core'),
      ),

      // Instagram
      array(
        'id'      => $meta_prefix . 'user_instagram',
        'type'    => 'text',
        'title'   => esc_html__('Instagram', 'luxus-core'),
      ),

      // Pinterest
      array(
        'id'      => $meta_prefix . 'user_pinterest',
        'type'    => 'text',
        'title'   => esc_html__('Pinterest', 'luxus-core'),
      ),

      // VK
      array(
        'id'      => $meta_prefix . 'user_vk',
        'type'    => 'text',
        'title'   => esc_html__('VK', 'luxus-core'),
      ),

      // Youtube
      array(
        'id'      => $meta_prefix . 'user_youtube',
        'type'    => 'text',
        'title'   => esc_html__('Youtube', 'luxus-core'),
      ),

      // Vimeo
      array(
        'id'      => $meta_prefix . 'user_vimeo',
        'type'    => 'text',
        'title'   => esc_html__('Vimeo', 'luxus-core'),
      ),

    )
  ) );

  // Create a section
  CSF::createSection( $prefix, array(
    'title'  => esc_html__('Agent Location', 'luxus-core'),
    'fields' => array(

      // Agent Street Address
      array(
        'id'      => $meta_prefix . 'user_st_address',
        'type'    => 'text',
        'title'   => esc_html__('Street Address', 'luxus-core'),
      ),

      // Agent City
      array(
        'id'          => $meta_prefix . 'user_city',
        'type'        => 'select',
        'title'       => esc_html__('City', 'luxus-core'),
        'placeholder' => esc_html__('Select City', 'luxus-core'),
        'options'     => 'categories',
        'query_args'  => array(
          'taxonomy'  => 'agent_city',
        ),
      ),

      // Agent State
      array(
        'id'          => $meta_prefix . 'user_state',
        'type'        => 'select',
        'title'       => esc_html__('State', 'luxus-core'),
        'placeholder' => esc_html__('Select State', 'luxus-core'),
        'options'     => 'categories',
        'query_args'  => array(
          'taxonomy'  => 'agent_province',
        ),
      ),

      // Agent Zip / Postal Code
      array(
        'id'      => $meta_prefix . 'user_zip',
        'type'    => esc_html__( 'luxus-core'),'text',
        'title'   => 'Zip / Postal Code',
      ),

      // Agent State
      array(
        'id'          => $meta_prefix . 'user_country',
        'type'        => 'select',
        'title'       => esc_html__('City', 'luxus-core'),
        'placeholder' => esc_html__('Select Country', 'luxus-core'),
        'options'     => 'categories',
        'query_args'  => array(
          'taxonomy'  => 'agent_country',
        ),
      ),

      // Agent Map
      array(
        'id'    => $meta_prefix . 'user_map',
        'type'  => 'map',
        'title' => esc_html__('Map', 'luxus-core'),
        'height'   => '350px',
        'settings' => array(
          'scrollWheelZoom' => true,
          'zoom' => 4,
        )
      ),

    )
  ) );

}