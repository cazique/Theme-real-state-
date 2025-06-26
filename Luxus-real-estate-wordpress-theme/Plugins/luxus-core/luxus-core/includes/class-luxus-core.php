<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wplistingthemes.com/
 * @since      1.0.0
 *
 * @package    Luxus_Core
 * @subpackage Luxus_Core/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Luxus_Core
 * @subpackage Luxus_Core/includes
 * @author     https://wplistingthemes.com/ <info@wplistingthemes.com>
 */
class Luxus_Core {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Luxus_Core_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'LUXUS_CORE_VERSION' ) ) {
			$this->version = LUXUS_CORE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'luxus-core';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Luxus_Core_Loader. Orchestrates the hooks of the plugin.
	 * - Luxus_Core_i18n. Defines internationalization functionality.
	 * - Luxus_Core_Admin. Defines all hooks for the admin area.
	 * - Luxus_Core_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-luxus-core-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-luxus-core-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-luxus-core-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-luxus-core-public.php';

		$this->loader = new Luxus_Core_Loader();

		// Luxus Core Options
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core-options/core-options.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core-options/profile-options.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core-options/property-options.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core-options/agency-options.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core-options/agent-options.php';
		
		// Luxus Content Block
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/content-block/content-block.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/content-block/class-elementor-header-footer.php';
				
		// Luxus Property CPTs
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/custom-post-types/luxus-properties.php';

		// Luxus Templates
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/templates/templates.php';

		// Luxus Widgets
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/register-widget-area.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-luxus-core-elementor-widgets.php';

		// Luxus Custom Users Settings
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/users/user-controls.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/users/custom-registration.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/users/luxus-wc-subscription.php';

		// Luxus Core Functions
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core-functions/luxus-core-functions.php';

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Luxus_Core_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Luxus_Core_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Luxus_Core_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Luxus_Core_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Luxus_Core_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
