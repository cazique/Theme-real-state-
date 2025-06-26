<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

// Control core classes for avoid errors
if( class_exists( 'CSF' ) ) {

  // Set a unique slug-like ID
  $prefix = 'luxus_options';

  // Property Settings Section
  require_once dirname( __FILE__ ) . '/sections/property-settings.php';

  // Agent Settings Section
  require_once dirname( __FILE__ ) . '/sections/agent-settings.php';

  // Agency Settings Section
  require_once dirname( __FILE__ ) . '/sections/agency-settings.php';

  // Forms Settings Section
  require_once dirname( __FILE__ ) . '/sections/forms-settings.php';

  // Agency Settings Section
  require_once dirname( __FILE__ ) . '/sections/dashboard-settings.php';
  
}