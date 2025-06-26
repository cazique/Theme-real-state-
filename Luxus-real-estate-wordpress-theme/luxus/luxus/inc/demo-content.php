<?php

// Ref: https://github.com/awesomemotive/one-click-demo-import

// Demo Content
function luxus_demo_content() {
    return array(
        array(
            'import_file_name'             => 'Default Demo',
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/demo-content/demo-content.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demo-content/widgets.wie',
            'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'inc/demo-content/customizer.dat',

            'local_import_json' => array(
                array(
                    'file_path'     => trailingslashit( get_template_directory() ) . 'inc/demo-content/theme-options.json',
                    'option_name'   => 'luxus_options',
                ),
            ),
                 
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'inc/demo-content/preview.jpg',
            'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately.', 'luxus' ),
            'preview_url'                  => 'https://wplistingthemes.com/',
        ),

    );
}
add_filter( 'ocdi/import_files', 'luxus_demo_content' );

// Required Plugins Before Demo Import
function luxus_register_plugins( $plugins ) {
  $theme_plugins = [

    // Elementor Website Builder
    [
        'name'     => 'Elementor Website Builder',
        'slug'     => 'elementor',
        'required' => true,
        'preselected' => true,
    ],

    // Luxus Core
    [
        'name'     => 'Luxus Core',
        'slug'     => 'luxus-core',
        'source'   => get_stylesheet_directory() . '/lib/plugins/luxus-core.zip',
        'required' => true,
        'preselected' => true,
    ],

    // Codestar Framework
    [
        'name'     => 'Codestar Framework',
        'slug'     => 'codestar-framework',
        'source'   => get_stylesheet_directory() . '/lib/plugins/codestar-framework.zip',
        'required' => true,
        'preselected' => true,
    ],

    // WooCommerce
    [
        'name'     => 'WooCommerce',
        'slug'     => 'woocommerce',
        'required' => true,
        'preselected' => true,
    ],

    // Contact Form 7
    [
        'name'      => 'Contact Form 7',
        'slug'      => 'contact-form-7',
        'required'  => false,
        'preselected' => true,
    ],

    // Mailchimp Newsletter
    [
        'name'     => 'MC4WP: Mailchimp for WordPress',
        'slug'     => 'mailchimp-for-wp',
        'required'  => false,
        'preselected' => true,
    ],
    
  ];
 
  return array_merge( $plugins, $theme_plugins );
}
add_filter( 'ocdi/register_plugins', 'luxus_register_plugins' );

// Settings After Demo Import
function luxus_after_import_setup() {

    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
    $menus = array(
        'primary-menu' => $main_menu->term_id,
        'dashboard-menu'  => $main_menu->term_id,
    );

    set_theme_mod( 'nav_menu_locations', $menus );

    // Assign front page and posts page (blog page).
    $front_page = get_page_by_title( 'Home - Default' );
    $blog_page  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page->ID );
    update_option( 'page_for_posts', $blog_page->ID );

    // Update Elementor Settings
    update_option( 'elementor_disable_color_schemes', 'no' );
    update_option( 'elementor_disable_typography_schemes', 'no' );

    $elementor_cpt_support = get_option( 'elementor_cpt_support' );
    
    if( ! $elementor_cpt_support ) {

        $elementor_cpt_support = [ 'page', 'post', 'luxus_content_block' ];

        update_option( 'elementor_cpt_support', $elementor_cpt_support );

    } else if( ! in_array( 'luxus_content_block', $elementor_cpt_support ) ) {

        $elementor_cpt_support[] = 'luxus_content_block';

        update_option( 'elementor_cpt_support', $elementor_cpt_support );
    }

}
add_action( 'ocdi/after_import', 'luxus_after_import_setup' );

// Update Theme Options
if ( ! function_exists( 'luxus_after_content_import_execution' ) ) {
  function luxus_after_content_import_execution( $selected_import_files, $import_files, $selected_index ) {

    $downloader = new OCDI\Downloader();

    if( ! empty( $import_files[$selected_index]['import_json'] ) ) {

      foreach( $import_files[$selected_index]['import_json'] as $index => $import ) {
        $file_path = $downloader->download_file( $import['file_url'], 'demo-import-file-'. $index .'-'. date( 'Y-m-d__H-i-s' ) .'.json' );
        $file_raw  = OCDI\Helpers::data_from_file( $file_path );
        update_option( $import['option_name'], json_decode( $file_raw, true ) );
      }

    } else if( ! empty( $import_files[$selected_index]['local_import_json'] ) ) {

      foreach( $import_files[$selected_index]['local_import_json'] as $index => $import ) {
        $file_path = $import['file_path'];
        $file_raw  = OCDI\Helpers::data_from_file( $file_path );
        update_option( $import['option_name'], json_decode( $file_raw, true ) );
      }

    }

  }
  add_action('ocdi/after_content_import_execution', 'luxus_after_content_import_execution', 3, 99 );
}