<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

//-----------------------
// Pages Section Parent
//-----------------------
CSF::createSection( $prefix, array(
  'id'    => 'pages-section',
  'title' => esc_html__( 'Pages Setting', 'luxus' ),
) );

//---------------------------
// Pages Settings Section
//---------------------------
CSF::createSection( $prefix, array(
  'parent' => 'pages-section',
  'title'  => esc_html__( 'Pages General Setting', 'luxus' ),
  'fields' => array(

    // Enable Page Title
    array(
      'id'         => 'enable-page-title',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Enable Page Title', 'luxus' ),
      'text_on'    => esc_html__( 'Enabled', 'luxus' ),
      'text_off'   => esc_html__( 'Disabled', 'luxus' ),
      'text_width' => 100,
      'default'    => true,
    ),

    // Page Header Background
    array(
      'dependency' => array( 'enable-page-title', '==', 'true' ),
      'id'    => 'page-header-bg',
      'type'  => 'background',
      'title' => esc_html__( 'Page Title Background', 'luxus' ),
      'output' => array( 'background' => '.page-header' ),
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

   // Page Title Typography
    array(
      'dependency' => array( 'enable-page-title', '==', 'true' ),
      'id'      => 'page-title',
      'type'    => 'typography',
      'title'   => esc_html__( 'Page Title Typography', 'luxus' ),
      'output'  => '.page-title',
      'default' => array(
        'color'          => '#ffffff',
        'font-family'    => 'Inter',
        'font-size'      => '34',
        'font-weight'    => 700,
        'line-height'    => '44',
        'letter-spacing' => '0',
        'text-align'     => 'left',
        'text-transform' => '',
        'subset'         => '',
        'type'           => 'google',
        'unit'           => 'px',
      ),
    ),

    // Page Header Padding Top
    array(
      'dependency' => array( 'enable-page-title', '==', 'true' ),
      'id'          => 'page-header-pt',
      'type'        => 'number',
      'title'       => esc_html__( 'Page Title Padding Top', 'luxus' ),
      'unit'        => 'px',
      'output'      => '.page-header',
      'output_mode' => 'padding-top',
      'default'     => 60,
    ),

    // Page Header Padding Bottom
    array(
      'dependency' => array( 'enable-page-title', '==', 'true' ),
      'id'          => 'page-header-pb',
      'type'        => 'number',
      'title'       => esc_html__( 'Page Title Padding Bottom', 'luxus' ),
      'unit'        => 'px',
      'output'      => '.page-header',
      'output_mode' => 'padding-bottom',
      'default'     => 60,
    ),

    // Page Header Margin Top
    array(
      'dependency' => array( 'enable-page-title', '==', 'true' ),
      'id'          => 'page-header-mt',
      'type'        => 'number',
      'title'       => esc_html__( 'Page Title Margin Top', 'luxus' ),
      'unit'        => 'px',
      'output'      => '.page-header',
      'output_mode' => 'margin-top',
      'default'     => 0,
    ),

    // Page Header Margin Bottom
    array(
      'dependency' => array( 'enable-page-title', '==', 'true' ),
      'id'          => 'page-header-mb',
      'type'        => 'number',
      'title'       => esc_html__( 'Page Title Margin Bottom', 'luxus' ),
      'unit'        => 'px',
      'output'      => '.page-header',
      'output_mode' => 'margin-bottom',
      'default'     => 0,
    ),

    // Enable Breadcrumb
    array(
      'dependency' => array( 'enable-page-title', '==', 'true' ),
      'id'         => 'enable-breadcrumb',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Enable Breadcrumb', 'luxus' ),
      'text_on'    => esc_html__( 'Enabled', 'luxus' ),
      'text_off'   => esc_html__( 'Disabled', 'luxus' ),
      'text_width' => 100,
      'default'    => true,
    ),

    // Breadcrumb Typography
    array(
      'dependency' => array(
        array( 'enable-page-title', '==', 'true' ),
        array( 'enable-breadcrumb', '==', 'true' ),
      ),
      'id'      => 'sl_breadcrumb',
      'type'    => 'typography',
      'title'   => esc_html__( 'Breadcrumb Typography', 'luxus' ),
      'output'  => '.sl_breadcrumb, .sl_breadcrumb a',
      'default' => array(
        'color'          => '#ffffff',
        'font-family'    => 'Roboto',
        'font-size'      => '14',
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

    // Page Background Color
    array(
      'id'    => 'sl_page_bg_color',
      'type'  => 'color',
      'title' => esc_html__( 'Default Page Background Color', 'luxus' ),
      'output'  => '.page-content.blog-page-content, .page-content.blog-single-content, .page-content.archive-page-content, .page-content.properties-page-content, .property-single, .page-content.properties-archive, .page-content.agencies-page-content, .page-content.agency-single-content, .page-content.agents-page-content, .page-content.agent-single-content, .halfmap-page-content, .page-content.search-page-content, .page-content.fzf-page-content, .compare-content',
      'output_mode' => 'background-color',
    ),

    // Page Padding Top
    array(
      'id'          => 'sl_page_pt',
      'type'        => 'number',
      'title'       => esc_html__( 'Page Padding Top', 'luxus' ),
      'unit'        => 'px',
      'output'      => '.page-content',
      'output_mode' => 'padding-top',
      'default'     => 60,
    ),

    // Page Padding Bottom
    array(
      'id'          => 'sl_page_pb',
      'type'        => 'number',
      'title'       => esc_html__( 'Page Padding Bottom', 'luxus' ),
      'unit'        => 'px',
      'output'      => '.page-content',
      'output_mode' => 'padding-bottom',
      'default'     => 60,
    ),
    
  )
) );

//---------------------------
// Blog Pages Settings Section
//---------------------------
CSF::createSection( $prefix, array(
  'parent' => 'pages-section',
  'title'  => esc_html__( 'Blog Settings', 'luxus' ),
  'fields' => array(

    // Blog Page Background Color
    array(
      'id'    => 'sl_blog_page_bg_color',
      'type'  => 'color',
      'title' => esc_html__( 'Blog Page Background Color', 'luxus' ),
      'output'  => '.page-content.blog-page-content',
      'output_mode' => 'background-color',
    ),
	  
    // Blog Sidebar
    array(
      'id'        => 'sidebar-position',
      'type'      => 'image_select',
      'title'     => esc_html__( 'Sidebar Position', 'luxus' ),
      'options'   => array(
        'left-sidebar' => esc_url(get_template_directory_uri()) . '/assets/images/options/left-sidebar.png',
        'right-sidebar' => esc_url(get_template_directory_uri()) . '/assets/images/options/right-sidebar.png',
      ),
      'default'   => 'right-sidebar'
    ),

    // Blog Post View
    array(
      'id'        => 'post-view',
      'type'      => 'image_select',
      'title'     => esc_html__( 'Post Columns', 'luxus' ),
      'options'   => array(
        'list-view' => esc_url(get_template_directory_uri()) . '/assets/images/options/list-view.png',
        'grid-view' => esc_url(get_template_directory_uri()) . '/assets/images/options/grid-view.png',
      ),
      'default'   => 'grid-view'
    ),

    // Masonry Posts
    array(
      "dependency" => ["post-view", "==", "grid-view"],
      'id'         => 'masonry-view',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Masonry Posts', 'luxus' ),
      'text_on'    => esc_html__( 'Enabled', 'luxus' ),
      'text_off'   => esc_html__( 'Disabled', 'luxus' ),
      'text_width' => 100,
      'default'    => true,
    ),

    // Blog Post View
    array(
      'id'          => 'post-style',
      'type'        => 'select',
      'title'       => esc_html__( 'Post Style', 'luxus' ),
      'options'     => array(
        'style-one'  => esc_html__( 'Style One', 'luxus' ),
        'style-two'  => esc_html__( 'Style Two', 'luxus' ),
      ),
      'default'     => 'style-one'

    ),

    // Post Excerpt
    array(
      'id'          => 'post-excerpt-length',
      'type'        => 'number',
      'title'       => esc_html__( 'Post Excerpt Length', 'luxus' ),
      'default'     => 200,
    ),

    // A Heading
    array(
      'type'    => 'subheading',
      'content' => esc_html__( 'Blog Single Page Settings', 'luxus' ),
    ),
	  
    // Blog Single Background Color
    array(
      'id'    => 'sl_blog_single_bg_color',
      'type'  => 'color',
      'title' => esc_html__( 'Blog Single Background Color', 'luxus' ),
      'output'  => '.page-content.blog-single-content',
      'output_mode' => 'background-color',
    ),

	// Blog Single Sidebar
    array(
      'id'         => 'blog-single-sidebar',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Show Blog Single Sidebar', 'luxus' ),
      'text_on'    => esc_html__( 'Enabled', 'luxus' ),
      'text_off'   => esc_html__( 'Disabled', 'luxus' ),
      'text_width' => 100,
      'default'    => true,
    ),

    // Post Title Background
    array(
      'id'    => 'post-header-bg',
      'type'  => 'background',
      'title' => esc_html__( 'Post Title Background', 'luxus' ),
      'output' => array( 'background' => '.single-post .blog-header' ),
      'background_gradient' => true,
      'default'                         => array(
        'background-color'              => '#00bbff',
        'background-gradient-color'     => 'rgba(72,12,168,0.9)',
        'background-gradient-direction' => '135deg',
        'background-size'               => 'cover',
        'background-position'           => 'center center',
        'background-repeat'             => 'no-repeat',
      )
    ),

   // Post Title Typography
    array(
      'id'      => 'post-title',
      'type'    => 'typography',
      'title'   => esc_html__( 'Page Title Typography', 'luxus' ),
      'output'  => '.single-post .blog-header .post-title',
      'default' => array(
        'color'          => '#ffffff',
        'font-family'    => 'Inter',
        'font-size'      => '34',
        'font-weight'    => 700,
        'line-height'    => '44',
        'letter-spacing' => '0',
        'text-align'     => 'left',
        'text-transform' => '',
        'subset'         => '',
        'type'           => 'google',
        'unit'           => 'px',
      ),
    ),

    // Post Title Padding Top
    array(
      'id'          => 'post-header-pt',
      'type'        => 'number',
      'title'       => esc_html__( 'Post Title Padding Top', 'luxus' ),
      'unit'        => 'px',
      'output'      => '.single-post .blog-header',
      'output_mode' => 'padding-top',
      'default'     => 60,
    ),

    // Post Title Padding Bottom
    array(
      'id'          => 'post-header-pb',
      'type'        => 'number',
      'title'       => esc_html__( 'Post Title Padding Bottom', 'luxus' ),
      'unit'        => 'px',
      'output'      => '.single-post .blog-header',
      'output_mode' => 'padding-bottom',
      'default'     => 60,
    ),

    // Blog Archive Page Background Color
    array(
      'id'    => 'sl_blog_archive_bg_color',
      'type'  => 'color',
      'title' => esc_html__( 'Search/Archive Page Background Color', 'luxus' ),
      'output'  => '.page-content.archive-page-content, .page-content.search-page-content',
      'output_mode' => 'background-color',
    ),

  )
) );