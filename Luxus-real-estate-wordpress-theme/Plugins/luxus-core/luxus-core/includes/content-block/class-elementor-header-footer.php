<?php
/**
 * Elementor class
 *
 * @package Luxus
 */

// If Elementor plugins doesn't exist then return.
if ( ! LUXUS_CORE_ELEMENTOR_ACTIVE
	&& version_compare( PHP_VERSION, '5.6', '>=' ) ) {
	return;
}

if ( ! class_exists( 'Luxus_Elementor_Header_Footer' ) ) {

	class Luxus_Elementor_Header_Footer {

		/**
		 * Setup class.
		 *
		 * @since 1.4.0
		 */
		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
			add_action( 'luxus_header', array( $this, 'luxus_header_template' ) );
			add_action( 'luxus_footer', array( $this, 'luxus_footer_template' ) );
		}

		/**
		 * Get the header ID.
		 *
		 * @since 1.4.0
		 */
		public static function get_header_id() {

			// Post ID
			$id_page_meta = !luxus_page_meta( '_page_header' ) == null ? luxus_page_meta( '_page_header' ) : null;

			if (function_exists('luxus_options')) {
			    $id_theme_opt = !luxus_options('site-header') == null ? luxus_options('site-header') : null;
			} else {
			    $id_theme_opt = "";
			}

			$id = !$id_page_meta == null ? $id_page_meta : $id_theme_opt;

			// If template is selected
			if ( ! empty( $id ) ) {

				return $id;
			}

			// Return
			return false;
			
		}

		/**
		 * Get the footer ID.
		 *
		 * @since 1.4.0
		 */
		public static function get_footer_id() {

			// Post ID
			$id_page_meta = !luxus_page_meta( '_page_footer' ) == null ? luxus_page_meta( '_page_footer' ) : null;
			if (function_exists('luxus_options')) {
			    $id_theme_opt = !luxus_options('site-footer') == null ? luxus_options('site-footer') : null;
			} else {
			    $id_theme_opt = "";
			}

			$id = !$id_page_meta == null ? $id_page_meta : $id_theme_opt;

			// If template is selected
			if ( ! empty( $id ) ) {
				
				return $id;
			}

			// Return
			return false;
			
		}

		/**
		 * Enqueue styles
		 *
		 * @since 1.4.0
		 */
		public static function enqueue_styles() {

			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {

				$header_id 	= self::get_header_id();
				$footer_id 	= self::get_footer_id();

				// Enqueue header css file
				if ( false != $header_id ) {
					$header_css = new \Elementor\Core\Files\CSS\Post( $header_id );
					$header_css->enqueue();
				}
				// Enqueue footer css file
				if ( false != $footer_id ) {
					$footer_css = new \Elementor\Core\Files\CSS\Post( $footer_id );
					$footer_css->enqueue();
				}

			}

		}

		/**
		 * Prints the header content.
		 *
		 * @since 1.4.0
		 */
		public static function get_header_content() {
			echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( self::get_header_id() );
		}

		/**
		 * Prints the footer content.
		 *
		 * @since 1.4.0
		 */
		public static function get_footer_content() {
			echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( self::get_footer_id() );
		}

		/**
		 * Luxus Header Template Location
		 * 'luxus_header' Action
		 */
		public static function luxus_header_template() {

			if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {

				// Custom Header ID
				// From Page Options
				$custom_header_opt = luxus_page_meta( '_page_header' );

				if (function_exists('luxus_options')) {
				    $site_header = luxus_options('site-header');
				} else {
				    $site_header = "";
				}

				$custom_header = !$custom_header_opt == null ? $custom_header_opt : $site_header;

				// Check if page is Elementor page.
				$elementor_page = get_post_meta( $custom_header, '_elementor_edit_mode', true );

				if ( $elementor_page ){

					self::get_header_content();

				}

			}

		}

		/**
		 * Luxus Footer Template Location
		 * 'luxus_footer' Action
		 */
		public static function luxus_footer_template() {

			if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {

				// Custom Footer ID
				// From Page Options
				$custom_footer_opt = luxus_page_meta( '_page_footer' );

				if (function_exists('luxus_options')) {
				    $site_footer = luxus_options('site-footer');
				} else {
				    $site_footer = "";
				}

				$custom_footer = !$custom_footer_opt == null ? $custom_footer_opt : $site_footer;

				// Check if page is Elementor page.
				$elementor_page = get_post_meta( $custom_footer, '_elementor_edit_mode', true );

				if ( $elementor_page ) {

					self::get_footer_content();

				}

			}

		}

	}

}

return new Luxus_Elementor_Header_Footer();