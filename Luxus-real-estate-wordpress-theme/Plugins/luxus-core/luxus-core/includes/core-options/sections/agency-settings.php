<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

//-----------------------
// Agency Section Parent
//-----------------------
CSF::createSection( $prefix, array(
  'id'    => 'agency-section',
  'title' => esc_html__('Agency Setting', 'luxus-core'),
  'priority'  => 996,
) );

//---------------------------
// Agency Settings Section
//---------------------------
CSF::createSection( $prefix, array(
  'parent' => 'agency-section',
  'title'  => esc_html__('Agency General Setting', 'luxus-core'),
  'fields' => array(

    // Page Background Color
    array(
      'id'    => 'sl_agencies_page_bg_color',
      'type'  => 'color',
      'title' => esc_html__( 'Agencies Page Background Color', 'luxus' ),
      'output'  => '.page-content.agencies-page-content',
      'output_mode' => 'background-color',
    ),

    // Agency Page Enable Page Title
    array(
      'id'         => 'agency-enable-page-title',
      'type'       => 'switcher',
      'title'      => esc_html__('Enable Page Title', 'luxus-core'),
      'text_on'    => esc_html__('Enabled', 'luxus-core'),
      'text_off'   => esc_html__('Disabled', 'luxus-core'),
      'text_width' => 100,
      'default'    => true,
    ),

    // Agency Page Title Background
    array(
      'id'    => 'agency-page-header-bg',
      'type'  => 'background',
      'title' => esc_html__('Agency Page Title Background', 'luxus-core'),
      'output' => array( 'background' => '.agency-page-header' ),
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

    // Agency Page Title Typography
    array(
      'id'      => 'agency-page-title',
      'type'    => 'typography',
      'title'   => esc_html__('Agency Page Title Typography', 'luxus-core'),
      'output'  => '.agency-page-title',
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

    // Agency Page Title Padding Top
    array(
      'id'          => 'agency-page-header-pt',
      'type'        => 'number',
      'title'       => esc_html__('Agency Page Title Padding Top', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.agency-page-header',
      'output_important'  => true,
      'output_mode' => 'padding-top',
      'default'     => 60,
    ),

    // Agency Page Title Padding Bottom
    array(
      'id'          => 'agency-page-header-pb',
      'type'        => 'number',
      'title'       => esc_html__('Agency Page Title Padding Bottom', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.agency-page-header',
      'output_important'  => true,
      'output_mode' => 'padding-bottom',
      'default'     => 60,
    ),

    // Agency Page Title Margin Top
    array(
      'id'          => 'agency-page-header-mt',
      'type'        => 'number',
      'title'       => esc_html__('Agency Page Title Margin Top', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.agency-page-header',
      'output_important'  => true,
      'output_mode' => 'margin-top',
      'default'     => 0,
    ),

    // Agency Page Title Margin Bottom
    array(
      'id'          => 'agency-page-header-mb',
      'type'        => 'number',
      'title'       => esc_html__('Agency Page Title Margin Bottom', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.agency-page-header',
      'output_important'  => true,
      'output_mode' => 'margin-bottom',
      'default'     => 0,
    ),

    // Agency Page Enable Breadcrumb
    array(
      'id'         => 'agency-enable-breadcrumb',
      'type'       => 'switcher',
      'title'      => esc_html__('Agency Page Enable Breadcrumb', 'luxus-core'),
      'text_on'    => esc_html__('Enabled', 'luxus-core'),
      'text_off'   => esc_html__('Disabled', 'luxus-core'),
      'text_width' => 100,
      'default'    => true,
    ),

    // Breadcrumb Typography
    array(
      'dependency' => array(
        array( 'agency-enable-breadcrumb', '==', 'true' ),
      ),
      'id'      => 'agency-breadcrumb',
      'type'    => 'typography',
      'title'   => esc_html__('Agency Page Breadcrumb Typography', 'luxus-core'),
      'output'  => '.sl_breadcrumb.agency-breadcrumb, .sl_breadcrumb.agency-breadcrumb a',
      'default' => array(
        'color'          => '#ffffff',
        'font-family'    => 'Roboto',
        'font-size'      => '16',
        'font-weight'    => 400,
        'line-height'    => '28',
        'letter-spacing' => '0',
        'text-align'     => '',
        'text-transform' => '',
        'subset'         => '',
        'type'           => 'google',
        'unit'           => 'px',
      ),
    ),

    // Agencies Sidebar
    array(
      'id'        => 'agencies-sidebar-position',
      'type'      => 'image_select',
      'title'     => esc_html__('Agencies Page Sidebar Position', 'luxus-core'),
      'options'   => array(
        'left-sidebar' => esc_url(get_template_directory_uri()) . '/assets/images/options/left-sidebar.png',
        'right-sidebar' => esc_url(get_template_directory_uri()) . '/assets/images/options/right-sidebar.png',
      ),
      'default'   => 'right-sidebar'
    ),

    // Agencies Post Style
    array(
      'id'          => 'agencies-post-style',
      'type'        => 'select',
      'title'       => esc_html__('Agencies Post Style', 'luxus-core'),
      'options'     => array(
        'style-one'  => esc_html__('Style One', 'luxus-core'),
        'style-two'  => esc_html__('Style Two', 'luxus-core'),
      ),
      'default'     => 'style-one'

    ),
	  
	// Agency Post Excerpt
    array(
	  'dependency' => array(
        array( 'agencies-post-style', '==', 'style-one' ),
      ),
      'id'          => 'agency-excerpt-length',
      'type'        => 'number',
      'title'       => esc_html__('Agency Excerpt Length', 'luxus-core'),
      'default'     => 20,
    ),
	  
    // Agency Page show social icons
    array(
      'id'         => 'agency-enable-social-icons',
      'type'       => 'switcher',
      'title'      => esc_html__('Show Social Icons on Posts', 'luxus-core'),
      'text_on'    => esc_html__('Show', 'luxus-core'),
      'text_off'   => esc_html__('Hide', 'luxus-core'),
      'text_width' => 100,
      'default'    => true,
    ),

    // Number of Agencies
    array(
      'id'          => 'agencies-show',
      'type'        => 'number',
      'title'       => esc_html__('Number of Properties', 'luxus-core'),
      'default'     => 10,
    ),

  )
) );

//---------------------------
// Agencies Single Pages Settings Section
//---------------------------
CSF::createSection( $prefix, array(
  'parent' => 'agency-section',
  'title'  => esc_html__('Agency Single Page', 'luxus-core'),
  'fields' => array(

    // Page Background Color
    array(
      'id'    => 'sl_agency_single_bg_color',
      'type'  => 'color',
      'title' => esc_html__( 'Agency Single Page Background Color', 'luxus' ),
      'output'  => '.page-content.agency-single-content',
      'output_mode' => 'background-color',
    ),

    // Agency Archive Title Background
    array(
      'id'    => 'agency-single-title-bg',
      'type'  => 'background',
      'title' => esc_html__('Agency Single Title Background', 'luxus-core'),
      'output' => array( 'background' => '.agency-single-page-header' ),
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

    // Agency Single Title Typography
    array(
      'id'      => 'agency-single-title',
      'type'    => 'typography',
      'title'   => esc_html__('Agency Single Title Typography', 'luxus-core'),
      'output'  => '.agency-singel-title',
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

    // Agency Single Title Padding Top
    array(
      'id'          => 'agency-single-title-pt',
      'type'        => 'number',
      'title'       => esc_html__('Agency Single Title Padding Top', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.agency-single-page-header',
      'output_important'  => true,
      'output_mode' => 'padding-top',
      'default'     => 60,
    ),

    // Agency Single Title Padding Bottom
    array(
      'id'          => 'agency-single-title-pb',
      'type'        => 'number',
      'title'       => esc_html__('Agency Single Title Padding Bottom', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.agency-single-page-header',
      'output_important'  => true,
      'output_mode' => 'padding-bottom',
      'default'     => 180,
    ),

    // Agency Single Title Margin Top
    array(
      'id'          => 'agency-single-title-mt',
      'type'        => 'number',
      'title'       => esc_html__('Agency Single Title Margin Top', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.agency-single-page-header',
      'output_important'  => true,
      'output_mode' => 'margin-top',
      'default'     => 0,
    ),

    // Agency Single Title Margin Bottom
    array(
      'id'          => 'agency-single-title-mb',
      'type'        => 'number',
      'title'       => esc_html__('Agency Single Title Margin Bottom', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.agency-single-page-header',
      'output_important'  => true,
      'output_mode' => 'margin-bottom',
      'default'     => 0,
    ),

    // Agency Single Enable Address
    array(
      'id'         => 'agency-enable-address',
      'type'       => 'switcher',
      'title'      => esc_html__('Agency Single Enable Breadcrumb', 'luxus-core'),
      'text_on'    => esc_html__('Enabled', 'luxus-core'),
      'text_off'   => esc_html__('Disabled', 'luxus-core'),
      'text_width' => 100,
      'default'    => true,
    ),

    // Agency Single Address Typography
    array(
      'dependency' => array(
        array( 'agency-enable-address', '==', 'true' ),
      ),
      'id'      => 'agency-single-address',
      'type'    => 'typography',
      'title'   => esc_html__('Agency Single Address Typography', 'luxus-core'),
      'output'  => '.agency-single-page-header .address',
      'default' => array(
        'color'          => '#ffffff',
        'font-family'    => 'Roboto',
        'font-size'      => '16',
        'font-weight'    => 400,
        'line-height'    => '28',
        'letter-spacing' => '0',
        'text-align'     => '',
        'text-transform' => '',
        'subset'         => '',
        'type'           => 'google',
        'unit'           => 'px',
      ),
    ),

    // Agency Single Sidebar
    array(
      'id'        => 'agency-single-sidebar-position',
      'type'      => 'image_select',
      'title'     => esc_html__('Agency Single Sidebar Position', 'luxus-core'),
      'options'   => array(
        'left-sidebar' => esc_url(get_template_directory_uri()) . '/assets/images/options/left-sidebar.png',
        'right-sidebar' => esc_url(get_template_directory_uri()) . '/assets/images/options/right-sidebar.png',
      ),
      'default'   => 'left-sidebar'
    ),

    // Agency Single Properties Post View
    array(
      'id'        => 'agency-single-post-view',
      'type'      => 'image_select',
      'title'     => esc_html__('Agency Single Properties List/Grid View', 'luxus-core'),
      'options'   => array(
        'list-view' => esc_url(get_template_directory_uri()) . '/assets/images/options/list-view.png',
        'grid-view' => esc_url(get_template_directory_uri()) . '/assets/images/options/grid-view.png',
      ),
      'default'   => 'grid-view'
    ),

    // Agency Single Enable Reviews
    array(
      'id'         => 'agency-enable-reviews',
      'type'       => 'switcher',
      'title'      => esc_html__('Agency Single Enable Reviews', 'luxus-core'),
      'text_on'    => esc_html__('Enabled', 'luxus-core'),
      'text_off'   => esc_html__('Disabled', 'luxus-core'),
      'text_width' => 100,
      'default'    => true,
    ),

    // Agency Single Enable Map
    array(
      'id'         => 'agency-enable-map',
      'type'       => 'switcher',
      'title'      => esc_html__('Agency Single Enable Map', 'luxus-core'),
      'text_on'    => esc_html__('Enabled', 'luxus-core'),
      'text_off'   => esc_html__('Disabled', 'luxus-core'),
      'text_width' => 100,
      'default'    => true,
    ),

    // Agency Single Content Padding Top
    array(
      'id'          => 'agency-single-content-pt',
      'type'        => 'number',
      'title'       => esc_html__('Agency Single Content Padding Top', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.page-content.agency-single-content',
      'output_important'  => true,
      'output_mode' => 'padding-top',
      'default'     => 60,
    ),

    // Agency Single Content Padding Bottom
    array(
      'id'          => 'agency-single-content-pb',
      'type'        => 'number',
      'title'       => esc_html__('Agency Single Content Padding Bottom', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.page-content.agency-single-content',
      'output_important'  => true,
      'output_mode' => 'padding-bottom',
      'default'     => 60,
    ),

  )
) );