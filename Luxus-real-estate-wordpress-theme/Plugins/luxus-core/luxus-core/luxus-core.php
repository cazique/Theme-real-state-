<?php

/**
 * This file includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wplistingthemes.com/
 * @since             1.0.0
 * @package           Luxus_Core
 *
 * @wordpress-plugin
 * Plugin Name:       Luxux Core
 * Plugin URI:        https://luxus.wplistingthemes.com/
 * Description:       The Luxus theme's primary functionality plugin.
 * Version:           1.1.0
 * Author:            wplistingthemes.com
 * Author URI:        https://wplistingthemes.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       luxus-core
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'LUXUS_CORE_VERSION', '1.1.0' );

if( !defined( 'SL_PLUGIN_DIR' ) )
    define( 'SL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
if( !defined( 'SL_PLUGIN_URL') )
    define( 'SL_PLUGIN_URL', plugins_url().'/luxus-core/' );
if ( ! defined( 'LUXUS_CORE_ELEMENTOR_ACTIVE' ) )
    define( 'LUXUS_CORE_ELEMENTOR_ACTIVE', class_exists( 'Elementor\Plugin' ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-luxus-core-activator.php
 */
function activate_luxus_core() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-luxus-core-activator.php';
	Luxus_Core_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-luxus-core-deactivator.php
 */
function deactivate_luxus_core() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-luxus-core-deactivator.php';
	Luxus_Core_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_luxus_core' );
register_deactivation_hook( __FILE__, 'deactivate_luxus_core' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-luxus-core.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_luxus_core() {

	$plugin = new Luxus_Core();
	$plugin->run();

}
run_luxus_core();
