<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

//-----------------------
// Agent Section Parent
//-----------------------
CSF::createSection( $prefix, array(
  'id'    => 'agent-section',
  'title' => esc_html__('Agent Setting', 'luxus-core'),
  'priority'  => 997,
) );

//---------------------------
// Agent Settings Section
//---------------------------
CSF::createSection( $prefix, array(
  'parent' => 'agent-section',
  'title'  => esc_html__('Agent General Setting', 'luxus-core'),
  'fields' => array(

    // Page Background Color
    array(
      'id'    => 'sl_agents_page_bg_color',
      'type'  => 'color',
      'title' => esc_html__( 'Agents Page Background Color', 'luxus' ),
      'output'  => '.page-content.agents-page-content',
      'output_mode' => 'background-color',
    ),

    // Agent Page Enable Page Title
    array(
      'id'         => 'agent-enable-page-title',
      'type'       => 'switcher',
      'title'      => esc_html__('Enable Page Title', 'luxus-core'),
      'text_on'    => esc_html__('Enabled', 'luxus-core'),
      'text_off'   => esc_html__('Disabled', 'luxus-core'),
      'text_width' => 100,
      'default'    => true,
    ),

    // Agent Page Title Background
    array(
      'dependency' => array( 'agent-enable-page-title', '==', 'true' ),
      'id'    => 'agent-page-header-bg',
      'type'  => 'background',
      'title' => esc_html__('Agent Page Title Background', 'luxus-core'),
      'output' => array( 'background' => '.agent-page-header' ),
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

    // Agent Page Title Typography
    array(
      'dependency' => array( 'agent-enable-page-title', '==', 'true' ),
      'id'      => 'agent-page-title',
      'type'    => 'typography',
      'title'   => esc_html__('Agent Page Title Typography', 'luxus-core'),
      'output'  => '.agent-page-title',
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

    // Agent Page Title Padding Top
    array(
      'dependency' => array( 'agent-enable-page-title', '==', 'true' ),
      'id'          => 'agent-page-header-pt',
      'type'        => 'number',
      'title'       => esc_html__('Agent Page Title Padding Top', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.agent-page-header',
      'output_important'  => true,
      'output_mode' => 'padding-top',
      'default'     => 60,
    ),

    // Agent Page Title Padding Bottom
    array(
      'dependency' => array( 'agent-enable-page-title', '==', 'true' ),
      'id'          => 'agent-page-header-pb',
      'type'        => 'number',
      'title'       => esc_html__('Agent Page Title Padding Bottom', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.agent-page-header',
      'output_important'  => true,
      'output_mode' => 'padding-bottom',
      'default'     => 60,
    ),

    // Agent Page Title Margin Top
    array(
      'dependency' => array( 'agent-enable-page-title', '==', 'true' ),
      'id'          => 'agent-page-header-mt',
      'type'        => 'number',
      'title'       => esc_html__('Agent Page Title Margin Top', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.agent-page-header',
      'output_important'  => true,
      'output_mode' => 'margin-top',
      'default'     => 0,
    ),

    // Agent Page Title Margin Bottom
    array(
      'dependency' => array( 'agent-enable-page-title', '==', 'true' ),
      'id'          => 'agent-page-header-mb',
      'type'        => 'number',
      'title'       => esc_html__('Agent Page Title Margin Bottom', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.agent-page-header',
      'output_important'  => true,
      'output_mode' => 'margin-bottom',
      'default'     => 0,
    ),

    // Agent Page Enable Breadcrumb
    array(
      'dependency' => array( 'agent-enable-page-title', '==', 'true' ),
      'id'         => 'agent-enable-breadcrumb',
      'type'       => 'switcher',
      'title'      => esc_html__('Agent Page Enable Breadcrumb', 'luxus-core'),
      'text_on'    => esc_html__('Enabled', 'luxus-core'),
      'text_off'   => esc_html__('Disabled', 'luxus-core'),
      'text_width' => 100,
      'default'    => true,
    ),

    // Breadcrumb Typography
    array(
      'dependency' => array(
        array( 'agent-enable-page-title', '==', 'true' ),
        array( 'agent-enable-breadcrumb', '==', 'true' ),
      ),
      'id'      => 'agent-breadcrumb',
      'type'    => 'typography',
      'title'   => esc_html__('Agent Page Breadcrumb Typography', 'luxus-core'),
      'output'  => '.agent-breadcrumb, .agent-breadcrumb a',
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

    // Agents Sidebar
    array(
      'id'        => 'agents-sidebar-position',
      'type'      => 'image_select',
      'title'     => esc_html__('Agents Page Sidebar Position', 'luxus-core'),
      'options'   => array(
        'left-sidebar' => esc_url(get_template_directory_uri()) . '/assets/images/options/left-sidebar.png',
        'right-sidebar' => esc_url(get_template_directory_uri()) . '/assets/images/options/right-sidebar.png',
      ),
      'default'   => 'right-sidebar'
    ),

    // Agents Post Style
    array(
      'id'          => 'agents-post-style',
      'type'        => 'select',
      'title'       => esc_html__('Agents Post Style', 'luxus-core'),
      'options'     => array(
        'style-one'  => esc_html__('Style One', 'luxus-core'),
        'style-two'  => esc_html__('Style Two', 'luxus-core'),
      ),
      'default'     => 'style-one'

    ),

    // Agent Page show social icons
    array(
      'id'         => 'agent-enable-social-icons',
      'type'       => 'switcher',
      'title'      => esc_html__('Show Social Icons on Posts', 'luxus-core'),
      'text_on'    => esc_html__('Show', 'luxus-core'),
      'text_off'   => esc_html__('Hide', 'luxus-core'),
      'text_width' => 100,
      'default'    => true,
    ),

    // Number of Agents
    array(
      'id'          => 'agents-show',
      'type'        => 'number',
      'title'       => esc_html__('Number of Posts', 'luxus-core'),
      'default'     => 10,
    ),

  )
) );


//---------------------------
// Agencies Single Pages Settings Section
//---------------------------
CSF::createSection( $prefix, array(
  'parent' => 'agent-section',
  'title'  => esc_html__('Agent Single Page', 'luxus-core'),
  'fields' => array(

    // Page Background Color
    array(
      'id'    => 'sl_agent_single_bg_color',
      'type'  => 'color',
      'title' => esc_html__( 'Agent Single Page Background Color', 'luxus' ),
      'output'  => '.page-content.agent-single-content',
      'output_mode' => 'background-color',
    ),

    // Agent Single Title Background
    array(
      'id'    => 'agent-single-title-bg',
      'type'  => 'background',
      'title' => esc_html__('Agent Single Title Background', 'luxus-core'),
      'output' => array( 'background' => '.agent-single-page-header' ),
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

    // Agent Single Title Typography
    array(
      'id'      => 'agent-single-title',
      'type'    => 'typography',
      'title'   => esc_html__('Agent Single Title Typography', 'luxus-core'),
      'output'  => '.agent-singel-title',
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

    // Agent Single Title Padding Top
    array(
      'id'          => 'agent-single-title-pt',
      'type'        => 'number',
      'title'       => esc_html__('Agent Single Title Padding Top', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.agent-single-page-header',
      'output_important'  => true,
      'output_mode' => 'padding-top',
      'default'     => 60,
    ),

    // Agent Single Title Padding Bottom
    array(
      'id'          => 'agent-single-title-pb',
      'type'        => 'number',
      'title'       => esc_html__('Agent Single Title Padding Bottom', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.agent-single-page-header',
      'output_important'  => true,
      'output_mode' => 'padding-bottom',
      'default'     => 60,
    ),

    // Agent Single Title Margin Top
    array(
      'id'          => 'agent-single-title-mt',
      'type'        => 'number',
      'title'       => esc_html__('Agent Single Title Margin Top', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.agent-single-page-header',
      'output_important'  => true,
      'output_mode' => 'margin-top',
      'default'     => 0,
    ),

    // Agent Single Title Margin Bottom
    array(
      'id'          => 'agent-single-title-mb',
      'type'        => 'number',
      'title'       => esc_html__('Agent Single Title Margin Bottom', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.agent-single-page-header',
      'output_important'  => true,
      'output_mode' => 'margin-bottom',
      'default'     => 0,
    ),

    // Agent Single Enable Address
    array(
      'id'         => 'agent-enable-address',
      'type'       => 'switcher',
      'title'      => esc_html__('Agent Single Enable Breadcrumb', 'luxus-core'),
      'text_on'    => esc_html__('Enabled', 'luxus-core'),
      'text_off'   => esc_html__('Disabled', 'luxus-core'),
      'text_width' => 100,
      'default'    => true,
    ),

    // Agent Single Address Typography
    array(
      'dependency' => array(
        array( 'agent-enable-address', '==', 'true' ),
      ),
      'id'      => 'agent-single-address',
      'type'    => 'typography',
      'title'   => esc_html__('Agent Single Address Typography', 'luxus-core'),
      'output'  => '.agent-single-page-header .address',
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

    // Agent Single Sidebar
    array(
      'id'        => 'agent-single-sidebar-position',
      'type'      => 'image_select',
      'title'     => esc_html__('Agent Single Sidebar Position', 'luxus-core'),
      'options'   => array(
        'left-sidebar' => esc_url(get_template_directory_uri()) . '/assets/images/options/left-sidebar.png',
        'right-sidebar' => esc_url(get_template_directory_uri()) . '/assets/images/options/right-sidebar.png',
      ),
      'default'   => 'left-sidebar'
    ),

    // Agent Single Properties Post View
    array(
      'id'        => 'agent-single-post-view',
      'type'      => 'image_select',
      'title'     => esc_html__('Agent Single Properties List/Grid View', 'luxus-core'),
      'options'   => array(
        'list-view' => esc_url(get_template_directory_uri()) . '/assets/images/options/list-view.png',
        'grid-view' => esc_url(get_template_directory_uri()) . '/assets/images/options/grid-view.png',
      ),
      'default'   => 'grid-view'
    ),

    // Agent Single Enable Reviews
    array(
      'id'         => 'agent-enable-reviews',
      'type'       => 'switcher',
      'title'      => esc_html__('Agent Single Enable Reviews', 'luxus-core'),
      'text_on'    => esc_html__('Enabled', 'luxus-core'),
      'text_off'   => esc_html__('Disabled', 'luxus-core'),
      'text_width' => 100,
      'default'    => true,
    ),

    // Agent Single Enable Map
    array(
      'id'         => 'agent-enable-map',
      'type'       => 'switcher',
      'title'      => esc_html__('Agent Single Enable Map', 'luxus-core'),
      'text_on'    => esc_html__('Enabled', 'luxus-core'),
      'text_off'   => esc_html__('Disabled', 'luxus-core'),
      'text_width' => 100,
      'default'    => true,
    ),

    // Agent Single Content Padding Top
    array(
      'id'          => 'agent-single-content-pt',
      'type'        => 'number',
      'title'       => esc_html__('Agent Single Content Padding Top', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.page-content.agent-single-content',
      'output_important'  => true,
      'output_mode' => 'padding-top',
      'default'     => 60,
    ),

    // Agent Single Content Padding Bottom
    array(
      'id'          => 'agent-single-content-pb',
      'type'        => 'number',
      'title'       => esc_html__('Agent Single Content Padding Bottom', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.page-content.agent-single-content',
      'output_important'  => true,
      'output_mode' => 'padding-bottom',
      'default'     => 60,
    ),

  )
) );
