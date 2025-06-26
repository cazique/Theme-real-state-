<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

//-----------------------
// Dashboard Section Parent
//-----------------------
CSF::createSection( $prefix, array(
  'id'    => 'dashboard-section',
  'title' => esc_html__('Dashboard Setting', 'luxus-core'),
  'priority'  => 998,
) );

//---------------------------
// Dashboard Settings Section
//---------------------------
CSF::createSection( $prefix, array(
  'parent' => 'dashboard-section',
  'title'  => esc_html__('Dashboard General Setting', 'luxus-core'),
  'fields' => array(

    // Dashboard Header Background Color
    array(
      'id'    => 'dashboard-header-bg-color',
      'type'  => 'color',
      'title' => esc_html__('Header Background Color', 'luxus-core'),
      'default' => '#00072D',
      'output' => array( 'background' => '.user-header' ),
    ),

    // Dashboard Logo
    array(
      'id'    => 'dashboard-logo',
      'type'  => 'media',
      'title' => esc_html__('Brand Logo', 'luxus-core'),
    ),

    // Dashboard Logo Width
    array(
      'id'          => 'dashboard-logo-width',
      'type'        => 'number',
      'title'       => esc_html__('Logo Width', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.sidebar-brand img',
      'output_important'  => true,
      'output_mode' => 'width',
      'default'     => 175,
    ),

    // Dashboard Header Line Height
    array(
      'id'          => 'dashboard-header-line-height',
      'type'        => 'number',
      'title'       => esc_html__('Header Line Height', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.user-header .classic-header-inner, .user-header .classic-header-inner .stellarnav.desktop>ul>li>a',
      'output_important'  => true,
      'output_mode' => 'line-height',
      'default'     => 90,
    ),

    // A Subheading
    array(
      'type'    => 'subheading',
      'content' => 'Header Menu Settings',
    ),

    // Dashboard Header Main Menu Position
    array(
      'id'          => 'dash-main-menu-position',
      'type'        => 'select',
      'title'       => esc_html__( 'Header Menu Position', 'luxus' ),
      'options'     => array(
        'left'    => 'Left',
        'center'  => 'Center',
        'right'   => 'Right',
      ),
      'default'   => 'left'
    ),

    // Dashboard Header Menu Font
    array(
      'id'      => 'dashboard-main-menu-font',
      'type'    => 'typography',
      'title'   => esc_html__('Header Menu Font', 'luxus-core'),
      'output'  => '.user-header .main-menu ul li a',
      'output_important'  => true,
      'default' => array(
        'font-family'    => 'Rubik',
        'font-size'      => '16',
        'font-weight'    => 400,
        'type'           => 'google',
        'unit'           => 'px',
      ),
      'color'          => false,
      'line_height'    => false,
      'letter_spacing' => false,
      'text_align'     => false,
      'subset'         => false,
    ),

    // Dashboard Header Menu Color
    array(
      'id'      => 'dashboard-main-menu-color',
      'type'    => 'link_color',
      'title'   => esc_html__('Header Menu Color', 'luxus-core'),
      'output'  => '.user-header .stellarnav.desktop ul li a',
      'default' => array(
        'color' => '#ffffff',
        'hover' => '',
      ),
    ),

    // Dashboard Header Sub Menu Color
    array(
      'id'      => 'dashboard-sub-main-menu-color',
      'type'    => 'link_color',
      'title'   => esc_html__('Header Sub Menu Color', 'luxus-core'),
      'output'  => '.user-header .stellarnav.desktop li.has-sub>ul.sub-menu li a',
      'default' => array(
        'color' => '#6e7488',
        'hover' => '',
      ),
    ),

    // Dashboard Header Break Point
    array(
      'id'          => 'dash-mob-header-breakpoint',
      'type'        => 'number',
      'title'       => esc_html__( 'Mobile Header Breakpoint', 'luxus' ),
      'subtitle'       => esc_html__( 'Only Number eg:1200', 'luxus' ),
      'default'     => 1200,
    ),

    // Dashboard Header Breadcrumb Color
    array(
      'id'    => 'dash-mob-menu-breadcrumb-color',
      'type'  => 'color',
      'title' => esc_html__( 'Breadcrumb Color', 'luxus' ),
      'default' => '#00bbff',
      'output' => array( 'background-color' => '.user-header .stellarnav.mobile .menu-toggle span.bars span' ),
    ),

    // Dashboard Header Breadcrumb Hover Color
    array(
      'id'    => 'dash-mob-menu-breadcrumb-hcolor',
      'type'  => 'color',
      'title' => esc_html__( 'Breadcrumb Hover Color', 'luxus' ),
      'default' => '#00bbff',
      'output' => array( 'background-color' => '.user-header .stellarnav.mobile .menu-toggle span.bars:hover span' ),
    ),

    // A Subheading
    array(
      'type'    => 'subheading',
      'content' => 'Header Right Settings',
    ),

    // Enable User Avatar
    array(
      'id'         => 'dashboard-user-avatar',
      'type'       => 'switcher',
      'title'      => esc_html__('Enable Right Button', 'luxus-core'),
      'text_on'    => esc_html__('Enabled', 'luxus-core'),
      'text_off'   => esc_html__('Disabled', 'luxus-core'),
      'text_width' => 100,
      'default'    => true,
    ),

    // Dashboard User Avatar Size
    array(
      'id'       => 'dashboard-user-avatar-size',
      'type'     => 'dimensions',
      'title'    => esc_html__('User Avatar Dimensions', 'luxus-core'),
      'default'  => array(
        'width'  => '40',
        'height' => '40',
        'unit'   => 'px',
      ),
      'output' => '.user-header .user-loged-in img',
      'dependency' => array( 'dashboard-user-avatar', '==', 'true' ),
    ),

    // Dashboard User Avatar Radius
    array(
      'id'          => 'dashboard-user-avatar-border-r',
      'type'        => 'number',
      'title'       => esc_html__('User Avatar Border Radius', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.user-header .user-loged-in img',
      'output_important'  => true,
      'output_mode' => 'border-radius',
      'default'     => 3,
      'dependency' => array( 'dashboard-user-avatar', '==', 'true' ),
    ),

    // Enable Right Button
    array(
      'id'         => 'dashboard-right-btn',
      'type'       => 'switcher',
      'title'      => esc_html__('Enable Right Button', 'luxus-core'),
      'text_on'    => esc_html__('Enabled', 'luxus-core'),
      'text_off'   => esc_html__('Disabled', 'luxus-core'),
      'text_width' => 100,
      'default'    => true,
    ),

    // Right Button Text
    array(
      'id'      => 'dashboard-right-btn-text',
      'type'    => 'text',
      'title'   => esc_html__('Right Button Text ', 'luxus-core'),
      'default' => esc_html__('Add Property', 'luxus-core'),
      'dependency' => array( 'dashboard-right-btn', '==', 'true' ),
    ),

    // Right Button Link
    array(
      'id'      => 'dashboard-right-btn-link',
      'type'    => 'text',
      'title'   => esc_html__('Right Button Link ', 'luxus-core'),
      'default' => esc_url(home_url('/')) . 'add-property',
      'dependency' => array( 'dashboard-right-btn', '==', 'true' ),
    ),

    // Right Button Text Color
    array(
      'id'      => 'dashboard-right-btn-text-color',
      'type'    => 'link_color',
      'title'   => esc_html__('Right Button Text Color', 'luxus-core'),
      'output'  => '.user-header .right-btn',
      'output_important'  => true,
      'default' => array(
        'color' => '#ffffff',
        'hover' => '#ffffff',
      ),
      'dependency' => array( 'dashboard-right-btn', '==', 'true' ),
    ),

    // Right Button Border
    array(
      'id'     => 'dashboard-right-btn-border',
      'type'   => 'border',
      'title'  => esc_html__('Right Button Border', 'luxus-core'),
      'output' => '.user-header .right-btn',
      'output_important'  => true,
      // 'all'    => true,
      'default' => array(
        'top'    => '2',
        'right'  => '2',
        'bottom' => '2',
        'left'   => '2',
        'style'  => 'solid',
        'color'  => '#00BBFF',
        'unit'   => 'px',
      ),
      'dependency' => array( 'dashboard-right-btn', '==', 'true' ),
    ),

    // Right Button Border Hover
    array(
      'id'     => 'dashboard-right-btn-border-h',
      'type'   => 'border',
      'title'  => esc_html__('Right Button Hover Border', 'luxus-core'),
      'output' => '.user-header .right-btn:hover',
      'output_important'  => true,
      // 'all'    => true,
      'default' => array(
        'top'    => '2',
        'right'  => '2',
        'bottom' => '2',
        'left'   => '2',
        'style'  => 'solid',
        'color'  => '#dd3333',
        'unit'   => 'px',
      ),
      'dependency' => array( 'dashboard-right-btn', '==', 'true' ),
    ),

    // Right Button Border Radius
    array(
      'id'          => 'dashboard-right-btn-border-r',
      'type'        => 'number',
      'title'       => esc_html__('Right Button Border Radius', 'luxus-core'),
      'unit'        => 'px',
      'output'      => '.user-header .right-btn',
      'output_important'  => true,
      'output_mode' => 'border-radius',
      'default'     => 3,
      'dependency' => array( 'dashboard-right-btn', '==', 'true' ),
    ),

    // Right Button Background
    array(
      'id'    => 'dashboard-right-btn-bg',
      'type'  => 'color',
      'title' => esc_html__('Right Button Background', 'luxus-core'),
      'default' => '',
      'output' => array( 'background' => '.user-header .right-btn' ),
      'output_important'  => true,
      'dependency' => array( 'dashboard-right-btn', '==', 'true' ),
    ),

    // Right Button Hover Background
    array(
      'id'    => 'dashboard-right-btn-bg-h',
      'type'  => 'color',
      'title' => esc_html__('Right Button Hover Background', 'luxus-core'),
      'default' => '',
      'output' => array( 'background' => '.user-header .right-btn:hover' ),
      'output_important'  => true,
      'dependency' => array( 'dashboard-right-btn', '==', 'true' ),
    ),

    // A Subheading
    array(
      'type'    => 'subheading',
      'content' => 'Dashboard Other Pages Settings',
    ),

    // Number of My Properties
    array(
      'id'          => 'my-properties-show',
      'type'        => 'number',
      'title'       => esc_html__('Number of Properties', 'luxus-core'),
      'default'     => 10,
    ),

    // Number of Favourite Properties
    array(
      'id'          => 'fav-properties-show',
      'type'        => 'number',
      'title'       => esc_html__('Number of Favourite Properties', 'luxus-core'),
      'default'     => 10,
    ),

    // Number of Messages
    array(
      'id'          => 'messages-show',
      'type'        => 'number',
      'title'       => esc_html__('Number of Messages', 'luxus-core'),
      'default'     => 10,
    ),

  )
) );
