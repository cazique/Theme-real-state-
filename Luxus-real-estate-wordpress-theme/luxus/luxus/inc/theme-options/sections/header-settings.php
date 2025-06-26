<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

// Getting Custome Headers
function luxus_get_headers() {

  $headers = array(
    'classic-header' => esc_html__( 'Classic Header', 'luxus' ),
  );

  if ( post_type_exists('luxus_content_block') ) {

    $header_args = array(
      'post_type' => 'luxus_content_block',
      'meta_key'   => 'luxus_content_block_type',
      'meta_value' => 'header'
    );

    $custom_headers = get_posts( $header_args );

    if ( $custom_headers ) {
      foreach ( $custom_headers as $header ) :
        setup_postdata( $header );

        $headers[$header->ID] = $header->post_title;

      endforeach; 
      wp_reset_postdata();
    }

  }

  return $headers;
}

//-----------------
// Header Section Parent
//-----------------
CSF::createSection( $prefix, array(
  'id'    => 'header-section',
  'title' => esc_html__( 'Header Settings', 'luxus' ),
) );

//-----------------
// Header Section
//-----------------
CSF::createSection( $prefix, array(
  'parent'      => 'header-section',
  'title'  => esc_html__( 'Header', 'luxus' ),
  'fields' => array(

    // Select Site Header
    array(
      'id'          => 'site-header',
      'type'        => 'select',
      'title'       => esc_html__( 'Select Site Header', 'luxus' ),
      'options'     => 'luxus_get_headers',
      'default'     => 'classic-header',
    ),

     // A Notice
    array(
      'type'    => 'notice',
      'style'   => 'info',
      'content' => esc_html__( 'Only the Classic Header will be affected by the following options.', 'luxus' ),
    ),

    // Brand Logo
    array(
      'id'    => 'brand-logo',
      'type'  => 'media',
      'title' => esc_html__( 'Upload Brand Logo', 'luxus' ),
    ),

    // Brand Logo Width
    array(
      'id'          => 'brand-logo-width',
      'type'        => 'number',
      'title'       => esc_html__( 'Logo Width', 'luxus' ),
      'unit'        => 'px',
      'output'      => '.theme-header.desktop .brand img',
      'output_important'  => true,
      'output_mode' => 'width',
      'default'     => 150,
    ),

    // Header Width
    array(
      'id'          => 'header-width',
      'type'        => 'select',
      'title'       => esc_html__( 'Header Width', 'luxus' ),
      'options'     => array(
        'container' => esc_html__( 'Boxed', 'luxus' ),
        'container-fluid'  => esc_html__( 'Full Width', 'luxus' ),
      ),
      'default'     => 'container'

    ),

    // Header Line Height
    array(
      'id'          => 'site-header-line-height',
      'type'        => 'number',
      'title'       => esc_html__( 'Header Line Height', 'luxus' ),
      'unit'        => 'px',
      'output'      => '.theme-header.desktop .classic-header-inner, .theme-header.desktop .classic-header-inner .stellarnav.desktop>ul>li>a',
      'output_important'  => true,
      'output_mode' => 'line-height',
      'default'     => 100,
    ),

    // Header Background Color
    array(
      'id'    => 'header-bg-color',
      'type'  => 'color',
      'title' => esc_html__( 'Header Background Color', 'luxus' ),
      'output' => array( 'background' => '.theme-header.desktop .classic-header' ),
    ),

    // A Subheading
    array(
      'type'    => 'subheading',
      'content' => 'Main Menu Settings',
    ),

    // Main Menu Position
    array(
      'id'          => 'main-menu-position',
      'type'        => 'select',
      'title'       => esc_html__( 'Main Menu Position', 'luxus' ),
      'options'     => array(
        'left'    => 'Left',
        'center'  => 'Center',
        'right'   => 'Right',
      ),
      'default'   => 'center'
    ),

    // Main Menu Font
    array(
      'id'      => 'main-menu-font',
      'type'    => 'typography',
      'title'   => esc_html__( 'Main Menu Font', 'luxus' ),
      'output'  => '.theme-header.desktop .stellarnav.desktop ul li a',
      'output_important'  => true,
      'default' => array(
        'font-family'    => 'Inter',
        'font-size'      => '16',
        'font-weight'    => 500,
        'type'           => 'google',
        'unit'           => 'px',
      ),
      'color'          => false,
      'line_height'    => false,
      'letter_spacing' => false,
      'text_align'     => false,
      'subset'         => false,
    ),

    // Main Menu Color
    array(
      'id'      => 'main-menu-color',
      'type'    => 'link_color',
      'title'   => esc_html__( 'Main Menu Color', 'luxus' ),
      'output'  => '.theme-header.desktop .stellarnav.desktop ul li a',
    ),

    // Sub Menu Color
    array(
      'id'      => 'sub-menu-color',
      'type'    => 'link_color',
      'title'   => esc_html__( 'Sub Menu Color', 'luxus' ),
      'output'  => '.theme-header.desktop .stellarnav.desktop ul li ul.sub-menu li a',
    ),

    // Active Menu Color
    array(
      'id'    => 'active-menu-color',
      'type'  => 'color',
      'title' => esc_html__( 'Active Menu Color', 'luxus' ),
      'output' => '.theme-header.desktop .stellarnav.desktop .current-menu-item > a, .theme-header.desktop .stellarnav.desktop .current-menu-ancestor > a, .theme-header.desktop .stellarnav.desktop ul.sub-menu .current-menu-item > a, .theme-header.desktop .stellarnav.desktop ul.sub-menu .current-menu-ancestor > a',
    ),

    // Sub Menu Background
    array(
      'id'    => 'sub-menu-bg',
      'type'  => 'color',
      'title' => esc_html__( 'Sub Menu Background', 'luxus' ),
      'default' => '#ffffff',
      'output' => array( 'background' => '.theme-header.desktop .stellarnav.desktop ul li ul.sub-menu, .theme-header.desktop .stellarnav.desktop>ul>li>ul.sub-menu:before' ),
    ),

    // Sub Menu Link Background
    array(
      'id'    => 'sub-menu-link-bg',
      'type'  => 'color',
      'title' => esc_html__( 'Sub Menu Links Background', 'luxus' ),
      'default' => '#ffffff',
      'output' => array( 'background' => '.theme-header.desktop .stellarnav.desktop li.has-sub>ul.sub-menu li a' ),
    ),

    // Sub Menu Hover Background
    array(
      'id'    => 'sub-menu-bg-h',
      'type'  => 'color',
      'title' => esc_html__( 'Sub Menu Links Hover Background', 'luxus' ),
      'default' => '#e7f7fe',
      'output' => array( 'background' => '.theme-header.desktop .stellarnav.desktop li.has-sub>ul.sub-menu li a:hover' ),
    ),

    // A Subheading
    array(
      'type'    => 'subheading',
      'content' => 'Sticky Header Settings',
    ),

    // Enable Sticky Header
    array(
      'id'         => 'sticky-header',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Enable Sticky Header', 'luxus' ),
      'text_on'    => esc_html__( 'Enabled', 'luxus' ),
      'text_off'   => esc_html__( 'Disabled', 'luxus' ),
      'text_width' => 100,
      // 'default'    => true,
    ),

    // Sticky Brand Logo
    array(
      'dependency' => array( 'sticky-header', '==', 'true' ),
      'id'    => 'sticky-logo',
      'type'  => 'media',
      'title' => esc_html__( 'Upload Sticky Header Logo', 'luxus' ),
    ),

    // Header Background Color
    array(
	  'dependency' => array( 'sticky-header', '==', 'true' ),
      'id'    => 'sticky-header-bg-color',
      'type'  => 'color',
      'default' => '#00072D',
      'title' => esc_html__( 'Sticky Header Background Color', 'luxus' ),
      'output' => array( 'background' => '.theme-header.desktop.sticky-top .classic-header' ),
    ),

    // Sticky Main Menu Color
    array(
      'dependency' => array( 'sticky-header', '==', 'true' ),
      'id'      => 'sticky-menu-color',
      'type'    => 'link_color',
      'title'   => esc_html__( 'Sticky Header Menu Color', 'luxus' ),
      'output'  => '.theme-header.desktop.sticky-top .stellarnav.desktop ul li a',
      'default' => array(
        'color' => '#ffffff',
        'hover' => '',
      ),
    ),

    // Sticky Sub Menu Color
    array(
      'dependency' => array( 'sticky-header', '==', 'true' ),
      'id'      => 'sticky-sub-menu-color',
      'type'    => 'link_color',
      'title'   => esc_html__( 'Sticky Header Sub Menu Color', 'luxus' ),
      'output'  => '.theme-header.desktop.sticky-top .stellarnav.desktop ul li ul.sub-menu li a',
    ),

    // Sticky Active Menu Color
    array(
      'dependency' => array( 'sticky-header', '==', 'true' ),
      'id'    => 'sticky-active-menu-color',
      'type'  => 'color',
      'title' => esc_html__( 'Sticky Active Menu Color', 'luxus' ),
      'output' => '.theme-header.desktop.sticky-top .stellarnav.desktop .current-menu-item > a, .theme-header.desktop.sticky-top .stellarnav.desktop .current-menu-ancestor > a, .theme-header.desktop.sticky-top .stellarnav.desktop ul.sub-menu .current-menu-item > a, .theme-header.desktop.sticky-top .stellarnav.desktop ul.sub-menu .current-menu-ancestor > a',
    ),

    // Sticky Sub Menu Background
    array(
      'dependency' => array( 'sticky-header', '==', 'true' ),
      'id'    => 'sticky-sub-menu-bg',
      'type'  => 'color',
      'title' => esc_html__( 'Sticky Sub Menu Background', 'luxus' ),
      'output' => array( 'background' => '.theme-header.desktop.sticky-top .stellarnav.desktop ul li ul.sub-menu, .theme-header.desktop.sticky-top .stellarnav.desktop>ul>li>ul.sub-menu:before' ),
    ),

    // Sticky Sub Menu Link Background
    array(
      'dependency' => array( 'sticky-header', '==', 'true' ),
      'id'    => 'sticky-sub-menu-link-bg',
      'type'  => 'color',
      'title' => esc_html__( 'Sticky Sub Menu Links Background', 'luxus' ),
      'output' => array( 'background' => '.theme-header.desktop.sticky-top .stellarnav.desktop li.has-sub>ul.sub-menu li a' ),
    ),


    // Sticky Sub Menu Link Hover Background
    array(
      'dependency' => array( 'sticky-header', '==', 'true' ),
      'id'    => 'sticky-sub-menu-link-bg-h',
      'type'  => 'color',
      'title' => esc_html__( 'Sticky Sub Menu Links Hover Background', 'luxus' ),
      'output' => array( 'background' => '.theme-header.desktop.sticky-top .stellarnav.desktop li.has-sub>ul.sub-menu li a:hover' ),
    ),

    // A Subheading
    array(
      'type'    => 'subheading',
      'content' => 'Header Right Settings',
    ),

    // Enable User Avatar
    array(
      'id'         => 'user-avatar',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Enable User Avatar', 'luxus' ),
      'text_on'    => esc_html__( 'Enabled', 'luxus' ),
      'text_off'   => esc_html__( 'Disabled', 'luxus' ),
      'text_width' => 100,
      // 'default'    => true,
    ),

    // User Avatar Text
    array(
      'id'      => 'user-avatar-text',
      'type'    => 'text',
      'title'   => esc_html__( 'User Avatar Text', 'luxus' ),
      'default' => esc_html__( 'Login', 'luxus' ),
      'dependency' => array( 'user-avatar', '==', 'true' ),
    ),
	  
    // User Avatar Text Color
    array(
      'id'    => 'user-avatar-text-color',
      'type'  => 'link_color',
      'title' => esc_html__( 'User Avatar Text Color', 'luxus' ),
      'output' => '.theme-header.desktop a.sl-ajax-login',
		  'dependency' => array( 'user-avatar', '==', 'true' ),
    ),
	  
    // Sticky User Avatar Text Color
    array(
      'id'    => 'user-avatar-text-color-sticky',
      'type'  => 'link_color',
      'title' => esc_html__( 'Sticky User Avatar Text Color', 'luxus' ),
      'output' => '.theme-header.desktop.sticky-top a.sl-ajax-login',
		  'dependency' => array( 'user-avatar', '==', 'true' ),
    ),

    // Enable Right Button
    array(
      'id'         => 'right-btn',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Enable Right Button', 'luxus' ),
      'text_on'    => esc_html__( 'Enabled', 'luxus' ),
      'text_off'   => esc_html__( 'Disabled', 'luxus' ),
      'text_width' => 100,
      // 'default'    => true,
    ),

    // Right Button Text
    array(
      'id'      => 'right-btn-text',
      'type'    => 'text',
      'title'   => esc_html__( 'Right Button Text', 'luxus' ),
      'default' => esc_html__( 'Get Started', 'luxus' ),
      'dependency' => array( 'right-btn', '==', 'true' ),
    ),

    // Right Button Link
    array(
      'id'      => 'right-btn-link',
      'type'    => 'text',
      'title'   => esc_html__( 'Right Button Link', 'luxus' ),
      'default' => '#',
      'dependency' => array( 'right-btn', '==', 'true' ),
    ),

    // Right Button Text Color
    array(
      'id'      => 'right-btn-text-color',
      'type'    => 'link_color',
      'title'   => esc_html__( 'Right Button Text Color', 'luxus' ),
      'output'  => '.classic-header-inner .right-btn',
      'dependency' => array( 'right-btn', '==', 'true' ),
    ),

    // Right Button Border
    array(
      'id'     => 'right-btn-border',
      'type'   => 'border',
      'title'  => esc_html__( 'Right Button Border', 'luxus' ),
      'output' => '.classic-header-inner .right-btn',
      'default' => array(
        'unit'   => 'px',
      ),
      'dependency' => array( 'right-btn', '==', 'true' ),

    ),

    // Right Button Border Hover
    array(
      'id'     => 'right-btn-border-h',
      'type'   => 'border',
      'title'  => esc_html__( 'Right Button Hover Border', 'luxus' ),
      'output' => '.classic-header-inner .right-btn:hover',
      'default' => array(
        'unit'   => 'px',
      ),
      'dependency' => array( 'right-btn', '==', 'true' ),

    ),

    // Right Button Border Radius
    array(
      'id'          => 'right-btn-border-r',
      'type'        => 'number',
      'title'       => esc_html__( 'Right Button Border Radius', 'luxus' ),
      'unit'        => 'px',
      'output'      => '.classic-header-inner .right-btn',
      'output_mode' => 'border-radius',
      'default'     => 3,
      'dependency' => array( 'right-btn', '==', 'true' ),
    ),

    // Right Button Background
    array(
      'id'    => 'right-btn-bg',
      'type'  => 'color',
      'title' => esc_html__( 'Right Button Background', 'luxus' ),
      'output' => array( 'background-color' => '.classic-header-inner .right-btn' ),
      'dependency' => array( 'right-btn', '==', 'true' ),
    ),

    // Right Button Hover Background
    array(
      'id'    => 'right-btn-bg-h',
      'type'  => 'color',
      'title' => esc_html__( 'Right Button Hover Background', 'luxus' ),
      'output' => array( 'background-color' => '.classic-header-inner .right-btn:hover' ),
      'dependency' => array( 'right-btn', '==', 'true' ),
    ),
  )
) );

//-----------------
// Mobile Header Section
//-----------------
CSF::createSection( $prefix, array(
  'parent'      => 'header-section',
  'title'  => esc_html__( 'Mobile Header', 'luxus' ),
  'fields' => array(

    // Header Break Point
    array(
      'id'          => 'mob-header-breakpoint',
      'type'        => 'number',
      'title'       => esc_html__( 'Mobile Header Breakpoint', 'luxus' ),
      'subtitle'       => esc_html__( 'Only Number eg:1200', 'luxus' ),
      'default'     => 1200,
    ),

    // A Notice
    array(
      'type'    => 'notice',
      'style'   => 'info',
      'content' => esc_html__( 'Only the Classic Header will be affected by the following options.', 'luxus' ),
    ),

    // Mobile Brand Logo Width
    array(
      'id'          => 'mob-brand-logo-width',
      'type'        => 'number',
      'title'       => esc_html__( 'Logo Width', 'luxus' ),
      'unit'        => 'px',
      'output'      => '.theme-header.mobile .brand img',
      'output_mode' => 'width',
      'default'     => 120,
    ),

    // Header Line Height
    array(
      'id'          => 'mob-header-line-height',
      'type'        => 'number',
      'title'       => esc_html__( 'Header Line Height', 'luxus' ),
      'unit'        => 'px',
      'output'      => '.theme-header.mobile .classic-header-inner, .theme-header.mobile .classic-header-inner .stellarnav.desktop>ul>li>a',
      'output_mode' => 'line-height',
      'default'     => 60,
    ),

    // Mobile Header Background Color
    array(
      'id'    => 'mob-header-bg',
      'type'  => 'color',
      'title' => esc_html__( 'Header Background Color', 'luxus' ),
      'default' => '#00072D',
      'output' => array( 'background' => '.theme-header.mobile .classic-header' ),
    ),
	   
	// Mobile Menu Avatar Color
    array(
      'id'    => 'mob-menu-avatar-color',
      'type'  => 'color',
      'title' => esc_html__( 'Avatar Text Color', 'luxus' ),
      'default' => '#ffffff',
      'output' => array( 'color' => '.theme-header.mobile a.sl-ajax-login' ),
    ),
	  
	// Mobile Menu Breadcrumb Color
    array(
      'id'    => 'mob-menu-breadcrumb-color',
      'type'  => 'color',
      'title' => esc_html__( 'Breadcrumb Color', 'luxus' ),
      'default' => '#00bbff',
      'output' => array( 'background-color' => '.theme-header.mobile .stellarnav.mobile .menu-toggle span.bars span' ),
    ),

    // Mobile Menu Breadcrumb Hover Color
    array(
      'id'    => 'mob-menu-breadcrumb-hcolor',
      'type'  => 'color',
      'title' => esc_html__( 'Breadcrumb Hover Color', 'luxus' ),
      'default' => '#00bbff',
      'output' => array( 'background-color' => '.theme-header.mobile .stellarnav.mobile .menu-toggle span.bars:hover span' ),
    ),

    // Mobile Menu Font
    array(
      'id'      => 'mob-menu-font',
      'type'    => 'typography',
      'title'   => esc_html__( 'Menu Font', 'luxus' ),
      'output'  => '.theme-header.mobile .stellarnav.mobile li a, .theme-header.mobile .stellarnav.mobile a',
      'default' => array(
        'font-family'    => 'Inter',
        'font-size'      => '16',
        'font-weight'    => 400,
        'type'           => 'google',
        'unit'           => 'px',
        'color'           => '#ffffff',
      ),
      'line_height'    => false,
      'letter_spacing' => false,
      'text_align'     => false,
      'subset'         => false,
    ),

    // Mobile Menu Hover Color
    array(
      'id'    => 'mob-menu-font-hcolor',
      'type'  => 'color',
      'title' => esc_html__( 'Menu Hover Color', 'luxus' ),
      'default' => '#ffffff',
      'output' => '.theme-header.mobile .stellarnav.mobile li a:hover, .theme-header.mobile .stellarnav.mobile a:hover',
    ),

    // Mobile Menu Active Color
    array(
      'id'    => 'mob-menu-font-acolor',
      'type'  => 'color',
      'title' => esc_html__( 'Menu Active Color', 'luxus' ),
      'default' => '#ffffff',
      'output' => '.theme-header.mobile .stellarnav.mobile .current-menu-item > a, .theme-header.mobile .stellarnav.mobile .current-menu-ancestor > a, .theme-header.mobile .stellarnav.mobile ul.sub-menu .current-menu-item > a, .theme-header.mobile .stellarnav.mobile ul.sub-menu .current-menu-ancestor > a',
    ),

    // Mobile Menu Icons Color
    array(
      'id'    => 'mob-menu-ico',
      'type'  => 'color',
      'title' => esc_html__( 'Menu Icons Color', 'luxus' ),
      'default' => '#ffffff',
      'output' => array( 'border-color' => '.stellarnav.mobile .icon-close:before, .stellarnav.mobile .icon-close:after, .stellarnav.mobile a.dd-toggle .icon-plus:before, .stellarnav.mobile a.dd-toggle .icon-plus:after' ),
    ),

    // Mobile Menu Icons Hover Color
    array(
      'id'    => 'mob-menu-ico-hcolor',
      'type'  => 'color',
      'title' => esc_html__( 'Menu Icons Hover Color', 'luxus' ),
      'default' => '#ffffff',
      'output' => array( 'border-color' => '.stellarnav.mobile .icon-close:hover:before, .stellarnav.mobile .icon-close:hover:after, .stellarnav.mobile a.dd-toggle:hover .icon-plus:before, .stellarnav.mobile a.dd-toggle:hover .icon-plus:after' ),
    ),

    // Mobile Menu Background
    array(
      'id'    => 'mob-menu-bg',
      'type'  => 'color',
      'title' => esc_html__( 'Menu Background', 'luxus' ),
      'default' => '#000',
      'output' => array( 'background' => '.stellarnav.mobile.dark ul' ),
    ),

  )
) );