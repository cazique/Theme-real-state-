<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

// Control core classes for avoid errors
if( class_exists( 'CSF' ) ) {

  // Set a unique slug-like ID
  $prefix = 'luxus_options';

  // Options Settings
  CSF::createOptions( $prefix, array(

    // Options title
    'framework_title'         => esc_html__( 'Luxus - Theme Options', 'luxus' ),
    'framework_class'         => '',

    // menu settings
    'menu_title'              => esc_html__( 'Theme Options', 'luxus' ),
    'menu_slug'               => 'theme-options',
    'menu_position'           => 3,

  ) );

  // General Settings Section
  require_once dirname( __FILE__ ) . '/sections/general-settings.php';

  // Header Settings Section
  require_once dirname( __FILE__ ) . '/sections/header-settings.php';

  // Pages Settings Section
  require_once dirname( __FILE__ ) . '/sections/pages-settings.php';

  // Typography Settings Section
  require_once dirname( __FILE__ ) . '/sections/typography-settings.php';

  // Footer Settings Section
  require_once dirname( __FILE__ ) . '/sections/footer-settings.php';

  // Backup Section
  CSF::createSection( $prefix, array(
    'title'  => 'Import / Export Opions',
    'priority'  => 999,
    'fields' => array(

      array(
        'type' => 'backup',
      ),

    )
  ));

}