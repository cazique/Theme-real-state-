<?php if (!defined("ABSPATH")) {
    die();
} // Cannot access directly.


// Getting Custome Headers
function luxus_get_page_headers() {

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

// Getting Custome Footers
function luxus_get_page_footers() {

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

// Control core classes for avoid errors
if (class_exists("CSF")) {
    // Set a unique slug-like ID
    $prefix = "sl_page_options";
    $meta_prefix = "_";

    // Create a metabox
    CSF::createMetabox($prefix, [
        "title" => esc_html__( "Custom Options", "luxus" ),
        "post_type" => "page",
        "data_type" => "serialize",
    ]);

    // Create a section
    CSF::createSection($prefix, [
        "title" => esc_html__( "General Settings", "luxus" ),
        "fields" => [

            // Page Header
            [
                "id" => $meta_prefix . "page_header",
                "type" => "select",
                "title" => esc_html__( "Select Header", "luxus" ),
                "placeholder" => esc_html__( "Select Header", "luxus" ),
                "options" => "luxus_get_page_headers"
            ],

            // Page Logo Classic
            [
                "dependency" => ["_page_header", "==", "classic-header"],
                "id" => $meta_prefix . "page_logo",
                "type" => "media",
                "title" => esc_html__( "Upload Logo", "luxus" ),
            ],

            // Header Background Color
            [
                "dependency" => ["_page_header", "==", "classic-header"],
                "id" => $meta_prefix . "header_bg_color",
                "type" => "color",
                "title" => esc_html__( "Header Background Color", "luxus" ),
                "output" => ["background" => ".theme-header.desktop .classic-header"],
            ],

            // Menu Color
            [
                "dependency" => ["_page_header", "==", "classic-header"],
                "id" => $meta_prefix . "menu_color",
                "type" => "link_color",
                "title" => esc_html__( "Menu Color", "luxus" ),
                'output'  => '.theme-header.desktop .stellarnav.desktop ul li a',
            ],

            // Active Menu Color
            [
                "dependency" => ["_page_header", "==", "classic-header"],
                "id" => $meta_prefix . "active_menu_color",
                "type" => "color",
                "title" => esc_html__( "Active Menu Color", "luxus" ),
                'output' => '.theme-header.desktop .stellarnav.desktop .current-menu-item > a, .theme-header.desktop .stellarnav.desktop .current-menu-ancestor > a, .theme-header.desktop .stellarnav.desktop ul.sub-menu .current-menu-item > a, .theme-header.desktop .stellarnav.desktop ul.sub-menu .current-menu-ancestor > a',
            ],

            // User Avatar Text Color
            [
                "dependency" => ["_page_header", "==", "classic-header"],
                "id" => $meta_prefix . "avatar_text_color",
                "type" => "link_color",
                "title" => esc_html__( "Avatar Text Color", "luxus" ),
                "output" => ".theme-header.desktop a.sl-ajax-login",
            ],

            // Enable Sticky Header
            [
                "id"         => $meta_prefix . "sticky_header",
                "type"       => "switcher",
                "title"      => esc_html__( "Enable Sticky Header", "luxus" ),
                "text_on"    => esc_html__( "Enabled", "luxus" ),
                "text_off"   => esc_html__( "Disabled", "luxus" ),
                "text_width" => 100,
                "default"    => true,
            ],

            // Page Logo Sticky
            [
                "dependency" => ["_page_header|_sticky_header", "==|==", "classic-header|true"],
                "id" => $meta_prefix . "page_sticky_logo",
                "type" => "media",
                "title" => esc_html__( "Upload Sticky Logo", "luxus" ),
            ],

            // Sticky User Avatar Text Color
            [
                "dependency" => ["_page_header|_sticky_header", "==|==", "classic-header|true"],
                "id" => $meta_prefix . "avatar_text_color_sticky",
                "type" => "link_color",
                "title" => esc_html__( "Sticky Header Avatar Text Color", "luxus" ),
                "output" => ".theme-header.desktop.sticky-top a.sl-ajax-login",
            ],

            // Page Padding Top
            [
                "id" => $meta_prefix . "page_pt",
                "type" => "number",
                "title" => esc_html__( "Page Padding Top", "luxus" ),
                "unit" => "px",
                "output" => ".page-content",
                "output_mode" => "padding-top",
            ],

            // Page Padding Bottom
            [
                "id" => $meta_prefix . "page_pb",
                "type" => "number",
                "title" => esc_html__( "Pag Padding Bottom", "luxus" ),
                "unit" => "px",
                "output" => ".page-content",
                "output_mode" => "padding-bottom",
            ],

            // Page Footer
            [
                "id" => $meta_prefix . "page_footer",
                "type" => "select",
                "title" => esc_html__( "Select Footer", "luxus" ),
                "placeholder" => esc_html__( "Select Footer", "luxus" ),
                "options" => "luxus_get_page_footers"
            ],

            // A Notice
            [
                "type" => "notice",
                "style" => "info",
                "content" => esc_html__( "Background Color: Only for default page template", "luxus" ),
            ],

            // Page Background Color
            [
                "id" => $meta_prefix . "background_color",
                "type" => "color",
                "title" => esc_html__( "Background Color", "luxus" ),
                "output" => ".page-content",
                "output_mode" => "background-color",
                'output_important'  => true,
            ],
        ],
    ]);

    // Create a section
    CSF::createSection($prefix, [
        "title" => esc_html__( "Page Title Settings", "luxus" ),
        "fields" => [
            // A Notice
            [
                "type" => "notice",
                "style" => "info",
                "content" => esc_html__( "Page Title Settings: Only for default page template", "luxus" ),
            ],

            // Enable Page Title
            [
                "id" => $meta_prefix . "enable_page_title",
                "type" => "switcher",
                "title" => esc_html__( "Enable Page Title", "luxus" ),
                "text_on" => esc_html__( "Enabled", "luxus" ),
                "text_off" => esc_html__( "Disabled", "luxus" ),
                "text_width" => 100,
                "default" => true,
            ],

            // Custom Page Title
            [
                "dependency" => ["_enable_page_title", "==", "true"],
                "id" => $meta_prefix . "custom_page_title",
                "type" => "text",
                "title" => esc_html__( "Page Title Text", "luxus" ),
            ],

            // Page Title Background
            [
                "dependency" => ["_enable_page_title", "==", "true"],
                "id" => $meta_prefix . "page_title_bg",
                "type" => "background",
                "title" => esc_html__( "Page Title Background", "luxus" ),
                "output" => ["background" => ".page-header"],
                "background_gradient" => true,
                "default" => [
                    "background-color" => "",
                    "background-gradient-color" => "",
                    "background-gradient-direction" => "",
                    "background-size" => "",
                    "background-position" => "",
                    "background-repeat" => "",
                ],
            ],

            // Page Title Typography
            [
                "dependency" => ["_enable_page_title", "==", "true"],
                "id" => $meta_prefix . "page_title_typo",
                "type" => "typography",
                "title" => esc_html__( "Page Title Typography", "luxus" ),
                "output" => ".page-title",
                "default" => [
                    "color" => "#ffffff",
                    "font-family" => "Inter",
                    "font-size" => "34",
                    "font-weight" => 700,
                    "line-height" => "44",
                    "letter-spacing" => "0",
                    "text-align" => "",
                    "text-transform" => "",
                    "subset" => "",
                    "type" => "google",
                    "unit" => "px",
                ],
            ],

            // Page Title Padding Top
            [
                "dependency" => ["_enable_page_title", "==", "true"],
                "id" => $meta_prefix . "page_title_pt",
                "type" => "number",
                "title" => esc_html__( "Page Title Padding Top", "luxus" ),
                "unit" => "px",
                "output" => ".page-header",
                "output_mode" => "padding-top",
                "default" => 60,
            ],

            // Page Title Padding Bottom
            [
                "dependency" => ["_enable_page_title", "==", "true"],
                "id" => $meta_prefix . "page_title_pb",
                "type" => "number",
                "title" => esc_html__( "Page Title Padding Bottom", "luxus" ),
                "unit" => "px",
                "output" => ".page-header",
                "output_mode" => "padding-bottom",
                "default" => 60,
            ],

            // Page Title Margin Top
            [
                "dependency" => ["_enable_page_title", "==", "true"],
                "id" => $meta_prefix . "page_title_mt",
                "type" => "number",
                "title" => esc_html__( "Page Title Margin Top", "luxus" ),
                "unit" => "px",
                "output" => ".page-header",
                "output_mode" => "margin-top",
                "default" => 0,
            ],

            // Page Title Margin Bottom
            [
                "dependency" => ["_enable_page_title", "==", "true"],
                "id" => $meta_prefix . "page_title_mb",
                "type" => "number",
                "title" => esc_html__( "Page Title Margin Bottom", "luxus" ),
                "unit" => "px",
                "output" => ".page-header",
                "output_mode" => "margin-bottom",
                "default" => 0,
            ],

            // Enable Breadcrumb
            [
                "dependency" => ["_enable_page_title", "==", "true"],
                "id" => $meta_prefix . "enable_breadcrumb",
                "type" => "switcher",
                "title" => esc_html__( "Enable Breadcrumb", "luxus" ),
                "text_on" => esc_html__( "Enabled", "luxus" ),
                "text_off" => esc_html__( "Disabled", "luxus" ),
                "text_width" => 100,
                "default" => true,
            ],

            // Breadcrumb Typography
            [
                "dependency" => [
                    ["_enable_page_title", "==", "true"],
                    ["_enable_breadcrumb", "==", "true"],
                ],
                "id" => $meta_prefix . "breadcrumb_typo",
                "type" => "typography",
                "title" => esc_html__( "Breadcrumb Typography", "luxus" ),
                "output" => ".sl_breadcrumb, .sl_breadcrumb a",
                "default" => [
                    "color" => "#ffffff",
                    "font-family" => "Roboto",
                    "font-size" => "15",
                    "font-weight" => 400,
                    "line-height" => "28",
                    "letter-spacing" => "0",
                    "text-align" => "",
                    "text-transform" => "",
                    "subset" => "",
                    "type" => "google",
                    "unit" => "px",
                ],
            ],
        ],
    ]);
}