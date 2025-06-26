<?php
/**
 * Enqueue scripts and styles.
 */

// Luxus Google Fonts
function luxus_google_fonts_url() {
	$fonts_url = '';
	 
	/* Translators: If there are characters in your language that are not
	* supported by Inter, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$inter = _x( 'on', 'Inter font: on or off', 'luxus' );
	 
	/* Translators: If there are characters in your language that are not
	* supported by Roboto Sans, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$roboto = _x( 'on', 'Roboto Sans font: on or off', 'luxus' );
	 
	if ( 'off' !== $inter || 'off' !== $roboto ) {
		$font_families = array();
		 
		if ( 'off' !== $inter ) {
			$font_families[] = 'Inter:200,300,400,500,60,700';
		}
		 
		if ( 'off' !== $roboto ) {
			$font_families[] = 'Roboto:300,400,500,700';
		}
		 
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		 
		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	}
	 
	return esc_url_raw( $fonts_url );
}


// Enqueue Scripts
function luxus_scripts_styles() {

	// Google Fonts
	if ( !class_exists( 'CSF' ) ) {
		wp_enqueue_style( 'luxus-google-fonts', luxus_google_fonts_url(), array(), LUXUS_VERSION );
	}

	// Style Sheets
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css','5.1.3', 'all' );
	wp_enqueue_style( 'slick-carousel', get_template_directory_uri() . '/assets/css/slick.min.css','1.8.0', 'all' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/fontawesome.all.min.css', '5.14.0', 'all' );
	wp_enqueue_style( 'fontello', get_template_directory_uri() . '/assets/css/fontello.min.css', '1.0.0', 'all' );
	wp_enqueue_style( 'select2', get_template_directory_uri() . '/assets/css/select2.min.css', '4.1.0', 'all' );
	wp_enqueue_style('luxus', get_template_directory_uri() . '/assets/css/luxus.css', LUXUS_VERSION, 'all' );

	// RTL Styles
	if ( is_rtl() ) {
	  wp_enqueue_style('luxus-rtl', get_template_directory_uri() . '/assets/css/luxus-rtl.css', LUXUS_VERSION, 'all' );
	}

	// WooCommerce Styles
	if ( class_exists( 'woocommerce' ) ) {
		wp_enqueue_style('luxus-woo', get_template_directory_uri() . '/assets/css/luxus-woo.css', LUXUS_VERSION, 'all' );
	}
	
	wp_enqueue_style( 'style', get_stylesheet_uri(), array(), LUXUS_VERSION );

	// Scripts
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array(), '5.1.3', true );
	wp_enqueue_script( 'select2', get_template_directory_uri() . '/assets/js/select2.min.js', array( 'jquery' ), '4.1.0', true );
	
	if ( !is_front_page() ) {
		wp_enqueue_script( 'resize-sensor', get_template_directory_uri() . '/assets/js/ResizeSensor.min.js', array(), '1.0.0', true );
		wp_enqueue_script( 'sticky-sidebar', get_template_directory_uri() . '/assets/js/theia-sticky-sidebar.min.js', array(), '1.7.0', true );
	}

	// Masonry View
	if ( is_home() || is_page('blog') || is_archive() || is_search() || is_page_template('page-blog.php') ) {

		$masonry_view = luxus_options('masonry-view');

		if ( !is_null($masonry_view) ) {

			if ( $masonry_view == 1 ) {
				wp_enqueue_script( 'masonry');
			}

		} else {

			wp_enqueue_script( 'masonry');

		}
	}

	// Scripts
	
	wp_enqueue_script( 'elementor-widgets', get_template_directory_uri() . '/assets/js/elementor-widgets.js', array('jquery'), '1.8.0', true );
	wp_enqueue_script( 'slick-carousel', get_template_directory_uri() . '/assets/js/slick.min.js', array('jquery'), '1.8.0', true );
	wp_enqueue_script( 'stellarnav', get_template_directory_uri() . '/assets/js/stellarnav.min.js', array('jquery'), '4.0', true );
	wp_enqueue_script( 'jquery.preloader', get_template_directory_uri() . '/assets/js/jquery.preloader.min.js', array(), '1.0', true );
	wp_enqueue_script( 'luxus-script', get_template_directory_uri() . '/assets/js/luxus.js', array(), '1.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'luxus_scripts_styles' );

// Editor Styles
add_theme_support( 'editor-styles' );
add_action('admin_init', 'luxus_add_editor_styles');

function luxus_add_editor_styles() {
   add_editor_style( get_template_directory_uri() . '/assets/css/style-editor.css' );
}

// JQuery Migrations
add_action('wp_default_scripts', function ($scripts) {
    if (!empty($scripts->registered['jquery'])) {
        $scripts->registered['jquery']->deps = array_diff($scripts->registered['jquery']->deps, ['jquery-migrate']);
    }
});