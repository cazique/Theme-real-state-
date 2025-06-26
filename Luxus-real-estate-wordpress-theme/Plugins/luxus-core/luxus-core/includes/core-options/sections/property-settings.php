<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

//-----------------------
// Property Section Parent
//-----------------------
CSF::createSection( $prefix, array(
  'id'    => 'property-section',
  'title' => esc_html__('Property Setting', 'luxus-core'),
  'priority'  => 995,
) );

//---------------------------
// Property Settings Section
//---------------------------
CSF::createSection( $prefix, array(
  'parent' => 'property-section',
  'title'  => esc_html__('Property General Setting', 'luxus-core'),
  'fields' => array(

    // Page Background Color
    array(
      'id'    => 'sl_props_page_bg_color',
      'type'  => 'color',
      'title' => esc_html__( 'Properties Page Background Color', 'luxus' ),
      'output'  => '.page-content.properties-page-content',
      'output_mode' => 'background-color',
    ),

    // Page Header Background
    array(
      'id'    => 'search-box-bg',
      'type'  => 'background',
      'title' => esc_html__('Search Box Background', 'luxus-core'),
      'output' => array( 'background' => '.properties-page-header' ),
      'background_gradient' => true,
      'default'                         => array(
        'background-color'              => '#00bbff',
        'background-gradient-color'     => 'rgba(62,42,211,0.9)',
        'background-gradient-direction' => '135deg',
        'background-size'               => 'cover',
        'background-position'           => 'center center',
        'background-repeat'             => 'no-repeat',
      )
    ),

    // Page Header Padding Top
    array(
      'id'          => 'search-box-pt',
      'type'        => 'number',
      'title'       => esc_html__('Search Box Padding Top', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.properties-page-header',
      'output_important'  => true,
      'output_mode' => 'padding-top',
      'default'     => 60,
    ),

    // Page Header Padding Bottom
    array(
      'id'          => 'search-box-pb',
      'type'        => 'number',
      'title'       => esc_html__('Search Box Padding Bottom', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.properties-page-header',
      'output_important'  => true,
      'output_mode' => 'padding-bottom',
      'default'     => 60,
    ),

    // Page Header Margin Top
    array(
      'id'          => 'search-box-mt',
      'type'        => 'number',
      'title'       => esc_html__('Search Box Margin Top', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.properties-page-header',
      'output_important'  => true,
      'output_mode' => 'margin-top',
      'default'     => 0,
    ),

    // Page Header Margin Bottom
    array(
      'id'          => 'search-box-mb',
      'type'        => 'number',
      'title'       => esc_html__('Search Box Margin Bottom', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.properties-page-header',
      'output_important'  => true,
      'output_mode' => 'margin-bottom',
      'default'     => 0,
    ),

    // Properties Sidebar
    array(
      'id'        => 'properties-sidebar-position',
      'type'      => 'image_select',
      'title'     => esc_html__('Properties Page Sidebar Position', 'luxus-core'),
      'options'   => array(
        'left-sidebar' => esc_url(get_template_directory_uri()) . '/assets/images/options/left-sidebar.png',
        'right-sidebar' => esc_url(get_template_directory_uri()) . '/assets/images/options/right-sidebar.png',
      ),
      'default'   => 'right-sidebar'
    ),

    // Properties Post View
    array(
      'id'        => 'properties-post-view',
      'type'      => 'image_select',
      'title'     => esc_html__('Properties List/Grid View', 'luxus-core'),
      'options'   => array(
        'list-view' => esc_url(get_template_directory_uri()) . '/assets/images/options/list-view.png',
        'grid-view' => esc_url(get_template_directory_uri()) . '/assets/images/options/grid-view.png',
      ),
      'default'   => 'grid-view'
    ),

    // Number of Properties
    array(
      'id'          => 'properties-show',
      'type'        => 'number',
      'title'       => esc_html__('Number of Properties', 'luxus-core'),
      'default'     => 10,
    ),

    // Currency Sign
    array(
      'id'      => 'property-currency',
      'type'    => 'text',
      'title'   => esc_html__( 'Currency Symbol', 'luxus-core' ),
      'default' => esc_html__( '$', 'luxus-core' ),
    ),

    // Area Sign
    array(
      'id'      => 'property-area-units',
      'type'    => 'text',
      'title'   => esc_html__( 'Area Units', 'luxus-core' ),
      'default' => esc_html__( 'm²', 'luxus-core' ),
    ),

    // Enable Save Search
    array(
      'id'         => 'enable-save-search',
      'type'       => 'switcher',
      'title'      => esc_html__('Enable Save Search', 'luxus-core'),
      'text_on'    => esc_html__('Enabled', 'luxus-core'),
      'text_off'   => esc_html__('Disabled', 'luxus-core'),
      'text_width' => 100,
      'default'    => true,
    ),

    // A Heading
    array(
      'type'    => 'heading',
      'content' => esc_html__('User Properties', 'luxus-core'),
    ),

    // Enable or Disable Frontend Property Posting
    array(
      'id'         => 'frontend-property-posting',
      'type'       => 'switcher',
      'title'      => esc_html__('Frontend Property Posting', 'luxus-core'),
      'text_on'    => esc_html__('Enabled', 'luxus-core'),
      'text_off'   => esc_html__('Disabled', 'luxus-core'),
      'text_width' => 100,
      'default'    => true,
    ),

    // Who Can Post From Dashboard
    array(
      'id'         => 'can-posts-from-dashboard',
      'type'       => 'radio',
      'title'      => esc_html__('Who Can Post Property From Fronted Dashboard?', 'luxus-core'),
      'options'    => array(
        'free'     => esc_html__('Anyone Can Post Property', 'luxus-core'),
        'premium'  => esc_html__('Only Premium User Can Post Property', 'luxus-core'),
      ),
      'default'    => 'free',
      'dependency' => array( 'frontend-property-posting', '==', 'true' ),
    ),

    // Number of Posts can Publish
    array(
      'id'          => 'can-post-props',
      'type'        => 'number',
      'title'       => esc_html__('Number Of Posts User Can Publish', 'luxus-core'),
      'default'     => 10,
      'dependency' => array( 'frontend-property-posting|can-posts-from-dashboard', '==|==', 'true|free' ),
    ),

    // User Post Status
    array(
      'id'         => 'user-post-status',
      'type'       => 'radio',
      'title'      => esc_html__('User Post Status', 'luxus-core'),
      'options'    => array(
        'pending' => esc_html__('Pending', 'luxus-core'),
        'draft' => esc_html__('Draft', 'luxus-core'),
        'publish' => esc_html__('Publish', 'luxus-core'),
      ),
      'default'    => 'pending',
      'dependency' => array( 'frontend-property-posting', '==', 'true' ),
    ),

  )
) );

//---------------------------
// Map Pages Settings Section
//---------------------------
CSF::createSection( $prefix, array(
  'parent' => 'property-section',
  'title'  => esc_html__('Half Map Settings', 'luxus-core'),
  'fields' => array(

    // Page Background Color
    array(
      'id'    => 'sl_halfmap_page_bg_color',
      'type'  => 'color',
      'title' => esc_html__( 'Half Map Page Background Color', 'luxus' ),
      'output'  => '.halfmap-page-content',
      'output_mode' => 'background-color',
    ),

    // Half Map Properties Post View
    array(
      'id'        => 'half-map-properties-post-view',
      'type'      => 'image_select',
      'title'     => esc_html__('Properties List/Grid View', 'luxus-core'),
      'options'   => array(
        'list-view' => esc_url(get_template_directory_uri()) . '/assets/images/options/list-view.png',
        'grid-view' => esc_url(get_template_directory_uri()) . '/assets/images/options/grid-view.png',
      ),
      'default'   => 'grid-view'
    ),

    // Half Map Number of Properties
    array(
      'id'          => 'half-map-properties-show',
      'type'        => 'number',
      'title'       => esc_html__('Number of Properties', 'luxus-core'),
      'default'     => 10,
    ),

    // Half Map Enable Save Search
    array(
      'id'         => 'half-map-enable-save-search',
      'type'       => 'switcher',
      'title'      => esc_html__('Enable Save Search', 'luxus-core'),
      'text_on'    => esc_html__('Enabled', 'luxus-core'),
      'text_off'   => esc_html__('Disabled', 'luxus-core'),
      'text_width' => 100,
      'default'    => true,
    ),

    // Half Map Map Possition
    array(
      'id'        => 'half-map-possition',
      'type'      => 'image_select',
      'title'     => esc_html__('Map Possition', 'luxus-core'),
      'options'   => array(
        'left' => esc_url(get_template_directory_uri()) . '/assets/images/options/left-map.png',
        'right' => esc_url(get_template_directory_uri()) . '/assets/images/options/right-map.png',
      ),
      'default'   => 'right'
    ),

    // Half Map Map
    array(
      'id'          => 'half-map-map',
      'type'        => 'select',
      'title'       => esc_html__('Select Map', 'luxus-core'),
      'options'     => array(
        'osmap'  => esc_html__('Open Street Map', 'luxus-core'),
        'gmap'   => esc_html__('Google Map', 'luxus-core'),
      ),
      'default'     => 'osmap'
    ),

    // Half Map Center Latitude
    array(
      'id'          => 'half-map-lat',
      'type'        => 'text',
      'title'       => esc_html__('Map Center Latitude', 'luxus-core'),
    ),

    // Half Map Center Longtitude
    array(
      'id'          => 'half-map-lng',
      'type'        => 'text',
      'title'       => esc_html__('Map Center Longtitude', 'luxus-core'),
    ),

    // Half Map zoom
    array(
      'id'          => 'half-map-zoom',
      'type'        => 'text',
      'title'       => esc_html__('Map Zoom', 'luxus-core'),
    ),

    array(
      'id'    => 'half-map-marker',
      'type'  => 'media',
      'title' => esc_html__('Marker Image', 'luxus-core'),
    ),

    // Marker Image Width
    array(
      'id'          => 'marker-img-width',
      'type'        => 'number',
      'title'       => esc_html__('Marker Image Width', 'luxus-core'),
    ),

    // Marker Image Height
    array(
      'id'          => 'marker-img-height',
      'type'        => 'number',
      'title'       => esc_html__('Marker Image Height', 'luxus-core'),
    ),

    array(
      'id'          => 'half-map-show-mobile',
      'type'        => 'select',
      'title'       => esc_html__('Show Map On Mobile', 'luxus-core'),
      'options'     => array(
        'yes'  => esc_html__('Yes', 'luxus-core'),
        'no'   => esc_html__('No', 'luxus-core'),
      ),
      'default'     => 'yes',
      'text_width' => 100,
    ),

  )
) );

//---------------------------
// Property Single Pages Settings Section
//---------------------------
CSF::createSection( $prefix, array(
  'parent' => 'property-section',
  'title'  => esc_html__('Single Pages Settings', 'luxus-core'),
  'fields' => array(

    // Page Background Color
    array(
      'id'    => 'sl_props_single_bg_color',
      'type'  => 'color',
      'title' => esc_html__( 'Property Single Page Background Color', 'luxus' ),
      'output'  => '.property-single',
      'output_mode' => 'background-color',
    ),

    // Property Single Page Sidebar
    array(
      'id'        => 'property-single-sidebar-position',
      'type'      => 'image_select',
      'title'     => esc_html__('Property Single Sidebar Position', 'luxus-core'),
      'options'   => array(
        'left-sidebar' => esc_url(get_template_directory_uri()) . '/assets/images/options/left-sidebar.png',
        'right-sidebar' => esc_url(get_template_directory_uri()) . '/assets/images/options/right-sidebar.png',
      ),
      'default'   => 'right-sidebar'
    ),

    // Property Single Page Video
    array(
      'id'         => 'property-single-enable-video',
      'type'       => 'switcher',
      'title'      => esc_html__('Property Video', 'luxus-core'),
      'text_on'    => esc_html__('Enabled', 'luxus-core'),
      'text_off'   => esc_html__('Disabled', 'luxus-core'),
      'text_width' => 100,
      'default'    => true,
    ),

    // Property Single Page Virtual Tour
    array(
      'id'         => 'property-single-enable-virtual-tour',
      'type'       => 'switcher',
      'title'      => esc_html__('Property Virtual Tour', 'luxus-core'),
      'text_on'    => esc_html__('Enabled', 'luxus-core'),
      'text_off'   => esc_html__('Disabled', 'luxus-core'),
      'text_width' => 100,
      'default'    => true,
    ),

    // Property Single Page Map
    array(
      'id'         => 'property-single-enable-map',
      'type'       => 'switcher',
      'title'      => esc_html__('Property Map', 'luxus-core'),
      'text_on'    => esc_html__('Enabled', 'luxus-core'),
      'text_off'   => esc_html__('Disabled', 'luxus-core'),
      'text_width' => 100,
      'default'    => true,
    ),

    // Property Single Page Contact Form
    array(
      'id'         => 'property-single-enable-contact',
      'type'       => 'switcher',
      'title'      => esc_html__('Property Contact Form', 'luxus-core'),
      'text_on'    => esc_html__('Enabled', 'luxus-core'),
      'text_off'   => esc_html__('Disabled', 'luxus-core'),
      'text_width' => 100,
      'default'    => true,
    ),

    // Property Single Page Schedule Tour
    array(
      'id'         => 'property-single-enable-schedule-tour',
      'type'       => 'switcher',
      'title'      => esc_html__('Property Schedule Tour', 'luxus-core'),
      'text_on'    => esc_html__('Enabled', 'luxus-core'),
      'text_off'   => esc_html__('Disabled', 'luxus-core'),
      'text_width' => 100,
      'default'    => true,
    ),

    // Property Single Page Related Properties
    array(
      'id'         => 'property-single-enable-relative',
      'type'       => 'switcher',
      'title'      => esc_html__('Related Properties', 'luxus-core'),
      'text_on'    => esc_html__('Enabled', 'luxus-core'),
      'text_off'   => esc_html__('Disabled', 'luxus-core'),
      'text_width' => 100,
      'default'    => true,
    ),

    // Property Single Page Reviews
    array(
      'id'         => 'property-single-enable-reviews',
      'type'       => 'switcher',
      'title'      => esc_html__('Property Reviews', 'luxus-core'),
      'text_on'    => esc_html__('Enabled', 'luxus-core'),
      'text_off'   => esc_html__('Disabled', 'luxus-core'),
      'text_width' => 100,
      'default'    => true,
    ),

    // Property Single Padding Top
    array(
      'id'          => 'property-single-pt',
      'type'        => 'number',
      'title'       => esc_html__('Property Single Padding Top', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.property-single',
      'output_mode' => 'padding-top',
      'default'     => 0,
    ),

    // Property Single Padding Bottom
    array(
      'id'          => 'property-single-pb',
      'type'        => 'number',
      'title'       => esc_html__('Property Single Padding Bottom', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.property-single',
      'output_mode' => 'padding-bottom',
      'default'     => 60,
    ),


  )
) );

//---------------------------
// Property Archive Pages Settings Section
//---------------------------
CSF::createSection( $prefix, array(
  'parent' => 'property-section',
  'title'  => esc_html__('Archive Pages Settings', 'luxus-core'),
  'fields' => array(

    // Page Background Color
    array(
      'id'    => 'sl_props_archive_bg_color',
      'type'  => 'color',
      'title' => esc_html__( 'Properties Archive Page Background Color', 'luxus' ),
      'output'  => '.page-content.properties-archive',
      'output_mode' => 'background-color',
    ),

    // Property Archive Title Background
    array(
      'id'    => 'property-archive-title-bg',
      'type'  => 'background',
      'title' => esc_html__('Property Archive Title Background', 'luxus-core'),
      'output' => array( 'background' => '.property-archive-page-header' ),
      'background_gradient' => true,
      'default'                         => array(
        'background-color'              => '#00bbff',
        'background-gradient-color'     => 'rgba(62,42,211,0.9)',
        'background-gradient-direction' => '135deg',
        'background-size'               => 'cover',
        'background-position'           => 'center center',
        'background-repeat'             => 'no-repeat',
      )
    ),

    // Property Archive Title Typography
    array(
      'id'      => 'property-archive-title',
      'type'    => 'typography',
      'title'   => esc_html__('Property Archive Title Typography', 'luxus-core'),
      'output'  => '.property-archive-title',
      'default' => array(
        'color'          => '#ffffff',
        'font-family'    => 'Roboto',
        'font-size'      => '40',
        'font-weight'    => 700,
        'line-height'    => '50',
        'letter-spacing' => '0',
        'text-align'     => '',
        'text-transform' => '',
        'subset'         => '',
        'type'           => 'google',
        'unit'           => 'px',
      ),
    ),

    // Property Archive Title Padding Top
    array(
      'id'          => 'property-archive-title-pt',
      'type'        => 'number',
      'title'       => esc_html__('Property Archive Title Padding Top', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.property-archive-page-header',
      'output_important'  => true,
      'output_mode' => 'padding-top',
      'default'     => 60,
    ),

    // Property Archive Title Padding Bottom
    array(
      'id'          => 'property-archive-title-pb',
      'type'        => 'number',
      'title'       => esc_html__('Property Archive Title Padding Bottom', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.property-archive-page-header',
      'output_important'  => true,
      'output_mode' => 'padding-bottom',
      'default'     => 60,
    ),

    // Property Archive Title Margin Top
    array(
      'id'          => 'property-archive-title-mt',
      'type'        => 'number',
      'title'       => esc_html__('Property Archive Title Margin Top', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.property-archive-page-header',
      'output_important'  => true,
      'output_mode' => 'margin-top',
      'default'     => 0,
    ),

    // Property Archive Title Margin Bottom
    array(
      'id'          => 'property-archive-title-mb',
      'type'        => 'number',
      'title'       => esc_html__('Property Archive Title Margin Bottom', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.property-archive-page-header',
      'output_important'  => true,
      'output_mode' => 'margin-bottom',
      'default'     => 0,
    ),

    // Property Archive Sidebar
    array(
      'id'        => 'property-archive-sidebar-position',
      'type'      => 'image_select',
      'title'     => esc_html__('Property Archive Sidebar Position', 'luxus-core'),
      'options'   => array(
        'left-sidebar' => esc_url(get_template_directory_uri()) . '/assets/images/options/left-sidebar.png',
        'right-sidebar' => esc_url(get_template_directory_uri()) . '/assets/images/options/right-sidebar.png',
      ),
      'default'   => 'right-sidebar'
    ),

    // Property Archive Properties Post View
    array(
      'id'        => 'property-archive-post-view',
      'type'      => 'image_select',
      'title'     => esc_html__('Property Archive Posts List/Grid View', 'luxus-core'),
      'options'   => array(
        'list-view' => esc_url(get_template_directory_uri()) . '/assets/images/options/list-view.png',
        'grid-view' => esc_url(get_template_directory_uri()) . '/assets/images/options/grid-view.png',
      ),
      'default'   => 'list-view'
    ),

    // Property Archive Page Padding Top
    array(
      'id'          => 'property-archive-pt',
      'type'        => 'number',
      'title'       => esc_html__('Property Archive Page Padding Top', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.page-content.properties-archive',
      'output_mode' => 'padding-top',
      'default'     => 60,
    ),

    // Property Archive Page Padding Bottom
    array(
      'id'          => 'property-archive-pb',
      'type'        => 'number',
      'title'       => esc_html__('Property Archive Page Padding Bottom', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.page-content.properties-archive',
      'output_mode' => 'padding-bottom',
      'default'     => 60,
    ),

  )
) );
