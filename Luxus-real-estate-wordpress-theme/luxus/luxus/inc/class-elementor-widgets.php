<?php
namespace SLElementorWidgets;

/**
 * Class SLElementor_Widgets
 *
 * @package Luxus
 */

// If Elementor plugins doesn't exist then return.
if ( ! LUXUS_ELEMENTOR_ACTIVE
	&& version_compare( PHP_VERSION, '5.6', '>=' ) ) {
	return;
}

if ( ! class_exists( 'SLElementor_Widgets' ) ) {

	class SLElementor_Widgets {

		/**
		 * Instance
		 *
		 * @since 1.2.0
		 * @access private
		 * @static
		 *
		 * @var SLElementor_Widgets The single instance of the class.
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
		 * @return SLElementor_Widgets An instance of the class.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function widget_styles() {
			
			wp_enqueue_style( 'luxus-theme-widgets', get_template_directory_uri() . '/inc/widgets/assets/css/luxus-theme-widgets.css' );

		}

		public	function widget_icons_inline_style() {

			$widgets = array(
				'blog-grid',
				'info-box',
				'nav-menu',
				'user-login',
				'pricing-table',
				'team',
				'text-image',
				'video-popup',
				'user-avatar',
				'scroll-down',
			);

			$style = apply_filters( 'luxus_theme_elementor_inline_style', $style = '' );

			if ( ! empty( $widgets ) && is_array( $widgets ) ) {

				foreach ($widgets as $widget) {

					$widget_name = $widget;

					$sl_icon_path = get_template_directory_uri() . '/inc/widgets/assets/images/' . esc_attr( $widget_name ) . '.png';

					$style .= '.sl-theme-widget-icon.' . $widget_name . '{
								background-image: url("' . $sl_icon_path . '") !important;
							}';

				}

			}

			if ( ! empty( $style ) ) {
				wp_add_inline_style( 'luxus-theme-widgets', $style );
			}
		}

		// Adding Custom Categorie to Elementor Widgets Area
	    public function luxus_widget_category( $elements_manager ) {

	        $categories = [];
	        $categories['luxus-widgets'] =
	            [
	                'title' => esc_html__( 'Luxus Widgets', 'luxus' ),
	                'icon'  => 'fa fa-plug'
	            ];

	        $elementor_categories = $elements_manager->get_categories();
	        $categories = array_merge($categories, $elementor_categories);

	        $set_categories = function ( $categories ) {
	            $this->categories = $categories;
	        };

	        $set_categories->call( $elements_manager, $categories );

	    }

		/**
		 * Include Widgets files
		 *
		 * Load widgets files
		 *
		 * @since 1.2.0
		 * @access private
		 */
		private function include_widgets_files() {

			require_once get_template_directory() . '/inc/widgets/nav-menu.php';
			require_once get_template_directory() . '/inc/widgets/user-login.php';
			require_once get_template_directory() . '/inc/widgets/blog-grid.php';
			require_once get_template_directory() . '/inc/widgets/pricing-table.php';
			require_once get_template_directory() . '/inc/widgets/text-image.php';
			require_once get_template_directory() . '/inc/widgets/info-box.php';
			require_once get_template_directory() . '/inc/widgets/video-popup.php';
			require_once get_template_directory() . '/inc/widgets/team.php';
			require_once get_template_directory() . '/inc/widgets/scroll-down.php';

		}

		/**
		 * Register Widgets
		 *
		 * Register new Elementor widgets.
		 *
		 * @since 1.2.0
		 * @access public
		 */
		public function register_widgets() {
			// Its is now safe to include Widgets files
			$this->include_widgets_files();

			// Register Widgets
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Luxus_Nav_Menu() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Luxus_User_Login() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Luxus_Blog_Grid() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Luxus_Pricing_Table() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Luxus_Text_Image() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Luxus_Info_Box() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Luxus_Video_Popup() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Luxus_Team() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Luxus_Scroll_Down() );
		}

		/**
		 * SLElementor_Widgets class constructor
		 *
		 * Register SLElementor_Widgets action hooks and filters
		 *
		 * @since 1.2.0
		 * @access public
		 */
		public function __construct() {

			// Add Widget Custom Category
			add_action( 'elementor/elements/categories_registered', [ $this, 'luxus_widget_category' ] );

			// Register widget Styles
			add_action( 'elementor/editor/before_enqueue_styles', [ $this, 'widget_styles' ] );
			add_action( 'elementor/editor/before_enqueue_styles', [ $this, 'widget_icons_inline_style' ] );

			// Register widgets
			add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
		}
	}
	
}

// Instantiate SLElementor_Widgets Class
SLElementor_Widgets::instance();