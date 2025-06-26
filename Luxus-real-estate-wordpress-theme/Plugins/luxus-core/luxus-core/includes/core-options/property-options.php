<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

// CPT Property Options

// Control core classes for avoid errors
if( class_exists( 'CSF' ) ) {

  // Set a unique slug-like ID
  $prefix = 'sl_property_options';
  $meta_prefix = '_';

  // Create a metabox
  CSF::createMetabox( $prefix, array(
    'title'     => esc_html__('Property Information', 'luxus-core'),
    'post_type' => 'property',
    'data_type'      => 'unserialize',
  ) );

  // Create a section
  CSF::createSection( $prefix, array(
    'title'  => esc_html__('General Information', 'luxus-core'),
    'fields' => array(

      // Enable Page Title
      array(
        'id'         => $meta_prefix . 'property_label',
        'type'       => 'switcher',
        'title'      => esc_html__('Property Label', 'luxus-core'),
        'text_on'    => esc_html__('Featured', 'luxus-core'),
        'text_off'   => esc_html__('Normal', 'luxus-core'),
        'text_width' => 100,
        'default'    => false,
      ),

      // Featured Property Expiry Date
      array(
        'id'    => $meta_prefix . 'property_label_expiry',
        'type'  => 'date',
        'title' => esc_html__('Featured Expiry', 'luxus-core'),
        'settings' => array(
          'dateFormat'      => 'yy-mm-dd',
        )
      ),

      // Property Type
      array(
        'id'          => $meta_prefix . 'property_type',
        'type'        => 'select',
        'title'       => esc_html__('Property Type', 'luxus-core'),
        'placeholder' => esc_html__('Select Property Type', 'luxus-core'),
        'options'     => 'categories',
        'query_args'  => array(
          'taxonomy'  => 'property_type',
        ),
      ),

      // Property Status
      array(
        'id'          => $meta_prefix . 'property_status',
        'type'        => 'select',
        'title'       => esc_html__('Property Status', 'luxus-core'),
        'placeholder' => esc_html__('Select Property Status', 'luxus-core'),
        'options'     => 'categories',
        'query_args'  => array(
          'taxonomy'  => 'property_status',
        ),
      ),

      // Property Price
      array(
        'id'      => $meta_prefix . 'property_price',
        'type'    => 'text',
        'title'   => esc_html__('Property Price', 'luxus-core'),
      ),

      // Price Prefix
      array(
        'id'      => $meta_prefix . 'property_price_prefix',
        'type'    => 'text',
        'title'   => esc_html__('Price Prefix', 'luxus-core'),
      ),

      // Price Postfix
      array(
        'id'      => $meta_prefix . 'property_price_postfix',
        'type'    => 'text',
        'title'   => esc_html__('Price Postfix', 'luxus-core'),
      ),

      // Bedrooms
      array(
        'id'      => $meta_prefix . 'property_bedrooms',
        'type'    => 'text',
        'title'   => esc_html__('Bedrooms', 'luxus-core'),
      ),

      // Bathrooms
      array(
        'id'      => $meta_prefix . 'property_bathrooms',
        'type'    => 'text',
        'title'   => esc_html__('Bathrooms', 'luxus-core'),
      ),

      // Parking Size
      array(
        'id'      => $meta_prefix . 'property_parking',
        'type'    => 'text',
        'title'   => esc_html__('Parking Size', 'luxus-core'),
      ),

      // Build Year
      array(
        'id'      => $meta_prefix . 'property_build',
        'type'    => 'text',
        'title'   => esc_html__('Build Year', 'luxus-core'),
      ),

      // Area
      array(
        'id'      => $meta_prefix . 'property_area',
        'type'    => 'text',
        'title'   => esc_html__('Area', 'luxus-core'),
      ),

      // Area Postfix
      array(
        'id'      => $meta_prefix . 'property_area_postfix',
        'type'    => 'text',
        'title'   => esc_html__('Area Postfix', 'luxus-core'),
      ),

      // Land Area
      array(
        'id'      => $meta_prefix . 'property_larea',
        'type'    => 'text',
        'title'   => esc_html__('Land Area', 'luxus-core'),
      ),

      // Land Area Postfix
      array(
        'id'      => $meta_prefix . 'property_larea_postfix',
        'type'    => 'text',
        'title'   => esc_html__('Land Area Postfix', 'luxus-core'),
      ),

      // Property Additional Features
      array(
        'id'      => $meta_prefix . 'property_add_features',
        'type'      => 'repeater',
        'title'     => esc_html__('Additional Features', 'luxus-core'),
        'fields'    => array(

          array(
            'id'    => 'add_feature_label',
            'type'  => 'text',
            'title' => esc_html__('Feature Label', 'luxus-core'),
          ),

          array(
            'id'    => 'add_feature_value',
            'type'  => 'text',
            'title' => esc_html__('Feature Value', 'luxus-core'),
          ),

        ),
      ),

    )
  ) );

  // Create a section
  CSF::createSection( $prefix, array(
    'title'  => esc_html__('Property Media', 'luxus-core'),
    'fields' => array(

      // Property Gallery
      array(
        'id'          => $meta_prefix . 'property_gallery',
        'type'        => 'gallery',
        'title'       => esc_html__('Property Gallery', 'luxus-core'),
        'add_title'   => esc_html__('Add Images', 'luxus-core'),
        'edit_title'  => esc_html__('Edit Images', 'luxus-core'),
        'clear_title' => esc_html__('Remove Images', 'luxus-core'),
      ),

      // Property Video
      array(
        'id'      => $meta_prefix . 'property_video',
        'type'    => 'text',
        'title'   => esc_html__('Property Video URL (youtube/vimeo)', 'luxus-core'),
      ),

      // 360 Panorama Image
      array(
        'id'    => $meta_prefix . 'property_panorama',
        'type'  => 'media',
        'title' => esc_html__('360 Panorama Image', 'luxus-core'),
      ),

    )
  ) );

  // Create a section
  CSF::createSection( $prefix, array(
    'title'  => esc_html__('Property Location', 'luxus-core'),
    'fields' => array(

      // Property Near By
      array(
        'id'      => $meta_prefix . 'property_nearby',
        'type'    => 'text',
        'title'   => esc_html__('Near By', 'luxus-core'),
      ),

      // Property Street Address
      array(
        'id'      => $meta_prefix . 'property_st_address',
        'type'    => 'text',
        'title'   => esc_html__('Street Address', 'luxus-core'),
      ),

      // Property City
      array(
        'id'          => $meta_prefix . 'property_city',
        'type'        => 'select',
        'title'       => esc_html__('City', 'luxus-core'),
        'placeholder' => esc_html__('Select City', 'luxus-core'),
        'options'     => 'categories',
        'query_args'  => array(
          'taxonomy'  => 'property_city',
        ),
      ),

      // Property State
      array(
        'id'          => $meta_prefix . 'property_state',
        'type'        => 'select',
        'title'       => esc_html__('State', 'luxus-core'),
        'placeholder' => esc_html__('Select State', 'luxus-core'),
        'options'     => 'categories',
        'query_args'  => array(
          'taxonomy'  => 'property_province',
        ),
      ),

      // Property Zip / Postal Code
      array(
        'id'      => $meta_prefix . 'property_zip',
        'type'    => 'text',
        'title'   => esc_html__('Zip / Postal Code', 'luxus-core'),
      ),

      // Property Country
      array(
        'id'          => $meta_prefix . 'property_country',
        'type'        => 'select',
        'title'       => esc_html__('Country', 'luxus-core'),
        'placeholder' => esc_html__('Select Country', 'luxus-core'),
        'options'     => 'categories',
        'query_args'  => array(
          'taxonomy'  => 'property_country',
        ),
      ),

      array(
        'id'    => $meta_prefix . 'property_map',
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

// Control core classes for avoid errors
if( class_exists( 'CSF' ) ) {

  //
  // Set a unique slug-like ID
  $prefix = 'property_status_options';

  //
  // Create taxonomy options
  CSF::createTaxonomyOptions( $prefix, array(
    'taxonomy'  => 'property_status',
    'data_type' => 'serialize', // The type of the database save options. `serialize` or `unserialize`
  ) );

  //
  // Create a section
  CSF::createSection( $prefix, array(
    'fields' => array(

      array(
        'id'    => 'status_color',
        'type'  => 'color',
        'title' => esc_html__('Status Color', 'luxus-core'),
      ),

    )
  ) );

}


// Control core classes for avoid errors
if( class_exists( 'CSF' ) ) {

  //
  // Set a unique slug-like ID
  $prefix = 'property_type_options';

  //
  // Create taxonomy options
  CSF::createTaxonomyOptions( $prefix, array(
    'taxonomy'  => 'property_type',
    'data_type' => 'serialize', // The type of the database save options. `serialize` or `unserialize`
  ) );

  //
  // Create a section
  CSF::createSection( $prefix, array(
    'fields' => array(

      array(
        'id'    => 'type_color',
        'type'  => 'color',
        'title' => esc_html__('Type Color', 'luxus-core'),
      ),

    )
    
  ) );

}