<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wplistingthemes.com/
 * @since      1.0.0
 *
 * @package    Luxus_Core
 * @subpackage Luxus_Core/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Luxus_Core
 * @subpackage Luxus_Core/public
 * @author     https://wplistingthemes.com/ <info@wplistingthemes.com>
 */
class Luxus_Core_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Luxus_Core_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Luxus_Core_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// Fontawesome
		wp_enqueue_style( 'fontawesome', plugin_dir_url( __FILE__ ) . 'css/fontawesome.all.min.css', array(), '5.14.0', 'all' );

		if ( is_singular('property') ) {

			// Virtual Image
			wp_enqueue_style( 'photo-sphere-viewer', plugin_dir_url( __FILE__ ) . 'css/photo-sphere-viewer.min.css', array(), $this->version, 'all' );

			// Date Time Picker
			wp_enqueue_style( 'datetimepicker', plugin_dir_url( __FILE__ ) . 'css/jquery.datetimepicker.min.css', array(), $this->version, 'all' );
		}

		if ( is_singular(array( 'property', 'agency', 'agent')) || is_page_template(array( 'page-half-map.php' )) ) {
			// Leaflet Js Css
			wp_enqueue_style( 'leaflet', plugin_dir_url( __FILE__ ) . 'css/leaflet.min.css', array(), $this->version, 'all' );

			// Leaflet Js Cluster Css
			wp_enqueue_style( 'markercluster', plugin_dir_url( __FILE__ ) . 'css/MarkerCluster.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'markerclusterdefault', plugin_dir_url( __FILE__ ) . 'css/MarkerClusterDefault.css', array(), $this->version, 'all' );
		}

		// Toaster Notifications
		wp_enqueue_style( 'toastr', plugin_dir_url( __FILE__ ) . 'css/toastr.min.css', $this->version, 'all');

		// Luxus Core Css
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/luxus-core-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Luxus_Core_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Luxus_Core_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ( is_singular('property') ) {
			// Date Time Picker Js
			wp_enqueue_script( 'datetimepicker', plugin_dir_url( __FILE__ ) . 'js/jquery.datetimepicker.full.min.js', array( 'jquery' ), $this->version, true );
			
			// Dequeue and deregister dialog-lightbox-widget
			wp_dequeue_script( 'elementor-frontend-modules' );
			wp_deregister_script( 'elementor-frontend-modules' );

		}
 
		if ( is_singular(array( 'property', 'agency', 'agent')) || is_page_template(array( 'page-half-map.php' )) ) {
			// Leaflet Js
			wp_enqueue_script( 'leaflet', plugin_dir_url( __FILE__ ) . 'js/leaflet.min.js', array( 'jquery' ), $this->version, true );

			// Leaflet Js Cluster
			wp_enqueue_script( 'markercluster', plugin_dir_url( __FILE__ ) . 'js/leaflet.markercluster.js', array( 'jquery' ), $this->version, true );
		}

		// User Panel Js
		wp_enqueue_script( 'user-panel', plugin_dir_url( __FILE__ ) . 'js/user-panel.js', array( 'jquery' ), $this->version, true );
		
		// Luxux Core Ajax
		wp_enqueue_script( 'luxus-core-ajax', plugin_dir_url( __FILE__ ) . 'js/luxus-core-ajax.js', array( 'jquery' ), $this->version, false );

		// Toastr Notifications Js
		wp_enqueue_script( 'toastr', plugin_dir_url( __FILE__ ) . 'js/toastr.min.js', array( 'jquery' ), $this->version, false );

		// Luxus Core Js
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/luxus-core-public.js', array( 'jquery' ), $this->version, true );

	}

}
