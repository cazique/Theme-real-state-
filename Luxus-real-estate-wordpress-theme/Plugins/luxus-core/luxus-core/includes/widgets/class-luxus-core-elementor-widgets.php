<?php
namespace SLElementorWidgets;

/**
 * Class Luxus_Core_Elementor_Widgets
 *
 * @package Luxus
 */

// If Elementor plugins doesn't exist then return.
if ( ! LUXUS_CORE_ELEMENTOR_ACTIVE
	&& version_compare( PHP_VERSION, '5.6', '>=' ) ) {
	return;
}

if ( ! class_exists( 'Luxus_Core_Elementor_Widgets' ) ) {

	class Luxus_Core_Elementor_Widgets {

		/**
		 * Instance of Elemenntor Frontend class.
		 *
		 * @var \Elementor\Frontend()
		 */
		private static $elementor_instance;

		/**
		 * Instance
		 *
		 * @since 1.2.0
		 * @access private
		 * @static
		 *
		 * @var Luxus_Core_Elementor_Widgets The single instance of the class.
		 */
		private static $_instance = null;

		/**
		 * Instance
		 *
		 * Ensures only one instance of the class is loaded or can be loaded.
		 *
		 * @since 1.2.0
		 * @access public
		 *
		 * @return Luxus_Core_Elementor_Widgets An instance of the class.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function luxus_core_widget_styles() {

			wp_enqueue_style( 'luxus-widgets', plugin_dir_url( __FILE__ ) . 'elementor-widgets/assets/css/luxus-widgets.css' );

		}

		public	function luxus_core_widget_icons_style() {

			$widgets = array( 
				'blog-carousel',
				'testimonial-carousel',
				'advance-search',
				'agency-grid',
				'agent-grid',
				'property-carousel',
				'property-category',
				'property-grid',
				'property-featured-grid',
				'property-map',
				'property-osmap',
				'content-block',
			);

			$style      = apply_filters( 'luxus_elementor_inline_style', $style = '' );

			if ( ! empty( $widgets ) && is_array( $widgets ) ) {

				foreach ($widgets as $widget) {

					$widget_name = $widget;

					$sl_icon_path = plugin_dir_url( __FILE__ ) . 'elementor-widgets/assets/images/' . esc_attr( $widget_name ) . '.png';

					$style .= '.sl-widget-icon.' . $widget_name . '{
								background-image: url("' . $sl_icon_path . '") !important;
							}';

				}

			}

			if ( ! empty( $style ) ) {
				wp_add_inline_style( 'luxus-widgets', $style );
			}
		}

		/**
		 * Callback to shortcode.
		 *
		 * @param array $atts attributes for shortcode.
		 */
		public function luxus_render_content_block( $atts ) {
			$atts = shortcode_atts(
				[
					'id' => '',
				],
				$atts,
				'luxus_content_block'
			);

			$id = ! empty( $atts['id'] ) ? apply_filters( 'luxus_content_block_id', intval( $atts['id'] ) ) : '';

			if ( empty( $id ) ) {
				return '';
			}

			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				$css_file = new \Elementor\Core\Files\CSS\Post( $id );
			} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
				// Load elementor styles.
				$css_file = new \Elementor\Post_CSS_File( $id );
			}
				$css_file->enqueue();

			return self::$elementor_instance->frontend->get_builder_content_for_display( $id );
		}

		/**
		 * Include Widgets files
		 *
		 * Load widgets files
		 *
		 * @since 1.2.0
		 * @access private
		 */
		private function luxus_core_include_widgets_files() {
			require_once( __DIR__ . '/elementor-widgets/blog-carousel.php' );
			require_once( __DIR__ . '/elementor-widgets/testimonial-carousel.php' );
			require_once( __DIR__ . '/elementor-widgets/property-grid.php' );
			require_once( __DIR__ . '/elementor-widgets/property-grid-featured.php' );
			require_once( __DIR__ . '/elementor-widgets/property-slider.php' );
			require_once( __DIR__ . '/elementor-widgets/property-carousel.php' );
			require_once( __DIR__ . '/elementor-widgets/property-carousel-featured.php' );
			require_once( __DIR__ . '/elementor-widgets/property-category.php' );
			require_once( __DIR__ . '/elementor-widgets/advance-search.php' );
			require_once( __DIR__ . '/elementor-widgets/agency-grid.php' );
			require_once( __DIR__ . '/elementor-widgets/agent-grid.php' );
			require_once( __DIR__ . '/elementor-widgets/property-gmap.php' );
			require_once( __DIR__ . '/elementor-widgets/property-map-osm.php' );
			require_once( __DIR__ . '/elementor-widgets/content-block.php' );
		}

		/**
		 * Register Widgets
		 *
		 * Register new Elementor widgets.
		 *
		 * @since 1.2.0
		 * @access public
		 */
		public function luxus_core_register_widgets() {
			// include Widgets files
			$this->luxus_core_include_widgets_files();

			self::$elementor_instance = \Elementor\Plugin::instance();
			add_shortcode( 'luxus_content_block', [ $this, 'luxus_render_content_block' ] );

			// Register Widgets
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Luxus_Blog_Carousel() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Luxus_Testimonial_Carousel() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Luxus_Property_Grid() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Luxus_Property_Grid_Featured() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Luxus_Property_Slider() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Luxus_Property_Carousel() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Luxus_Property_Carousel_Featured() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Luxus_Property_Category() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Luxus_Advance_Search() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Luxus_Agency_Grid() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Luxus_Agent_Grid() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Luxus_Property_Gmap() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Luxus_Property_Map_OSM() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Luxus_Content_Block() );
		}

		/**
		 * Luxus_Core_Elementor_Widgets class constructor
		 *
		 * Register Luxus_Core_Elementor_Widgets action hooks and filters
		 *
		 * @since 1.2.0
		 * @access public
		 */
		public function __construct() {

			// Register widget Styles
			add_action( 'elementor/editor/before_enqueue_styles', [ $this, 'luxus_core_widget_styles' ] );
			add_action( 'elementor/editor/before_enqueue_styles', [ $this, 'luxus_core_widget_icons_style' ] );

			// Register widgets
			add_action( 'elementor/widgets/widgets_registered', [ $this, 'luxus_core_register_widgets' ] );
		}
	}
}

// Instantiate Luxus_Core_Elementor_Widgets Class
Luxus_Core_Elementor_Widgets::instance();
