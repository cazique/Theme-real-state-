<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Luxus
 */

if ( ! function_exists( 'luxus_after_setup_theme' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function luxus_after_setup_theme() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Luxus, use a find and replace
		 * to change 'luxus' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'luxus', get_template_directory() . '/languages' );

		// Theme Support
		add_theme_support( 'custom-header' );
		add_theme_support( 'custom-background' );
		add_theme_support( 'align-wide' );
		add_theme_support( "responsive-embeds" );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		add_image_size( 'luxus-thumb-lg', 1280, 854, true );
		add_image_size( 'luxus-thumb-md', 640, 427, true );
		add_image_size( 'luxus-agent-thumb', 500, 500, true );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'luxus_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'               => 50,
				'width'                => 150,
				'flex-height'          => true,
				'flex-width'           => true,
				'header-text'          => array( 'site-title', 'site-description' ),
				'unlink-homepage-logo' => true, 
			)
		);

		// Theme Primary Menu
		register_nav_menus(
			array(
				'primary-menu' => esc_html__( 'Primary Menu', 'luxus' ),
			)
		);

		if ( class_exists('Luxus_Core') ) {
			// Theme User Dashboard Menu
			register_nav_menus(
				array(
					'dashboard-menu' => esc_html__( 'Dashboard Menu', 'luxus' ),
				)
			);
		}
	}
endif;
add_action( 'after_setup_theme', 'luxus_after_setup_theme' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function luxus_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'luxus_content_width', 640 );
}
add_action( 'after_setup_theme', 'luxus_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function luxus_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'luxus' ),
			'id'            => 'template-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'luxus' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h6 class="widget-title">',
			'after_title'   => '</h6>',
		)
	);

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget 1', 'luxus' ),
		'id'            => 'footer-widget-one',
		'description'   => esc_html__( 'Add widgets here.', 'luxus' ),
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h6 class="widget-title">',
		'after_title'   => '</h6>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget 2', 'luxus' ),
		'id'            => 'footer-widget-two',
		'description'   => esc_html__( 'Add widgets here.', 'luxus' ),
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h6 class="widget-title">',
		'after_title'   => '</h6>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget 3', 'luxus' ),
		'id'            => 'footer-widget-three',
		'description'   => esc_html__( 'Add widgets here.', 'luxus' ),
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h6 class="widget-title">',
		'after_title'   => '</h6>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget 4', 'luxus' ),
		'id'            => 'footer-widget-four',
		'description'   => esc_html__( 'Add widgets here.', 'luxus' ),
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h6 class="widget-title">',
		'after_title'   => '</h6>',
	) );
}
add_action( 'widgets_init', 'luxus_widgets_init' );

// Widgets Post Count
function luxus_widgets_post_count ($count) {
   $count = str_replace('(', '<span class="post_count">(', $count);
   $count = str_replace(')', ')</span>', $count);
   return $count;
}
add_filter('wp_list_categories','luxus_widgets_post_count');
add_filter('get_archives_link','luxus_widgets_post_count');


// Exclude other post types from default search
function luxus_exclude_all_pages_search($query) {
    if (
        ! is_admin()
        && $query->is_main_query()
        && $query->is_search
    )
        $query->set( 'post_type', 'post' );
}
add_action('pre_get_posts','luxus_exclude_all_pages_search');

//Breadcrumb.
function luxus_get_breadcrumb() {
    echo '<a href="'. esc_url(home_url()) .'" rel="nofollow">'. esc_html__('Home', 'luxus') .'</a>';
    if (is_category() || is_single()) {
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
        the_category(' &bull; ');
            if (is_single()) {
                echo " &nbsp;&nbsp;&#187;&nbsp;&nbsp; ";
                the_title();
            }
    } elseif (is_page()) {
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
        echo the_title();
    }
}

// Luxus Related Posts
function luxus_get_related_posts( $post_id, $related_count, $args = array() ) {
	$terms = get_the_terms( $post_id, 'category' );
	
	if ( empty( $terms ) ) $terms = array();
	
	$term_list = wp_list_pluck( $terms, 'slug' );
	
	$related_args = array(
		'post_type' => 'post',
		'posts_per_page' => $related_count,
		'post_status' => 'publish',
		'post__not_in' => array( $post_id ),
		'orderby' => 'rand',
		'tax_query' => array(
			array(
				'taxonomy' => 'category',
				'field' => 'slug',
				'terms' => $term_list
			)
		),
		'meta_query' => array(
			array(
				'key'     => '_thumbnail_id',
				'compare' => 'EXISTS'
			)
		)
	);

	return new WP_Query( $related_args );
}

// Pagination
if ( !function_exists( 'luxus_pagination' ) ) {
	
	function luxus_pagination() {

		$prev_arrow = is_rtl() ? '<i class="sl-icon sl-next-arrow"></i>' : '<i class="sl-icon sl-back-arrow"></i>';
		$next_arrow = is_rtl() ? '<i class="sl-icon sl-back-arrow"></i>' : '<i class="sl-icon sl-next-arrow"></i>';
		
		global $wp_query;
		$total_pages = $wp_query->max_num_pages;
		$big = 999999999;
		if( $total_pages > 1 )  {

			echo '<div class="custom-pagination"><div class="sl-pagination">';

			 if( !$current_page = get_query_var('paged') )
				 $current_page = 1;
			 if( get_option('permalink_structure') ) {
				 $format = 'page/%#%/';
			 } else {
				 $format = '&paged=%#%';
			 }
			echo paginate_links(array(
				'base'			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'		=> $format,
				'current'		=> max( 1, get_query_var('paged') ),
				'total' 		=> $total_pages,
				'mid_size'		=> 3,
				'type' 			=> 'plain',
				'prev_text'		=> $prev_arrow,
				'next_text'		=> $next_arrow,
			 ) );

			echo '</div></div>';
		}

	}
	
}

// Pagination for Plugin Templates
if ( !function_exists( 'luxus_pagination_bar' ) ) {
	
	function luxus_pagination_bar( $custom_query ) {

		$prev_arrow = is_rtl() ? '<i class="sl-icon sl-next-arrow"></i>' : '<i class="sl-icon sl-back-arrow"></i>';
		$next_arrow = is_rtl() ? '<i class="sl-icon sl-back-arrow"></i>' : '<i class="sl-icon sl-next-arrow"></i>';
		
		$total_pages = $custom_query->max_num_pages;
   		$big = 999999999;

		if( $total_pages > 1 )  {

			echo '<div class="custom-pagination"><div class="sl-pagination">';

			 if( !$current_page = get_query_var('paged') )
				 $current_page = 1;
			 if( get_option('permalink_structure') ) {
				 $format = 'page/%#%/';
			 } else {
				 $format = '&paged=%#%';
			 }
			echo paginate_links(array(
				'base'			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'		=> $format,
				'current'		=> max( 1, get_query_var('paged') ),
				'total' 		=> $total_pages,
				'mid_size'		=> 3,
				'type' 			=> 'plain',
				'prev_text'		=> $prev_arrow,
				'next_text'		=> $next_arrow,
			 ) );

			echo '</div></div>';
		}
	}	
}

/**
 * Filter the upload size limit for non-administrators.
 *
 * @param string $size Upload size limit (in bytes).
 * @return int (maybe) Filtered size limit.
 */
function luxus_upload_size_limit( $size ) {
    // Set the upload size limit to 60 MB for users lacking the 'manage_options' capability.
    if ( ! current_user_can( 'manage_options' ) ) {
        // 60 MB.
        $size = 60 * 1024 * 1024;
    }
    return $size;
}
add_filter( 'upload_size_limit', 'luxus_upload_size_limit', 20 );

// Ajax Login Script
function luxus_ajax_login_init(){
    wp_register_script('ajax-login-script', get_template_directory_uri() . '/assets/js/ajax-login-script.js', array('jquery') ); 
    wp_enqueue_script('ajax-login-script');
    wp_localize_script( 'ajax-login-script', 'ajax_login_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'redirecturl' => get_admin_url(),
        'loadingmessage' => __('Sending user info, please wait ...', 'luxus')
    ));

    // Enable the user with no privileges to run luxus_ajax_login() in AJAX
    add_action( 'wp_ajax_nopriv_ajaxlogin', 'luxus_ajax_login' );
}

// Execute the action only if the user isn't logged in
if ( !is_user_logged_in() ) {
    add_action('init', 'luxus_ajax_login_init');
}

// Ajax Login
function luxus_ajax_login(){
    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, true );
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.', 'luxus')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...', 'luxus')));
    }

    die();
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function luxus_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'luxus_body_classes' );

function luxus_after_setup_theme_supported_features() {
    add_theme_support( 'editor-color-palette', array(
        array(
            'name' => __( 'strong blue', 'luxus' ),
            'slug' => 'strong-blue',
            'color' => '#00bbff',
        ),
        array(
            'name' => __( 'light grayish blue', 'luxus' ),
            'slug' => 'light-grayish-blue',
            'color' => '#e7f7fe',
        ),
        array(
            'name' => __( 'very light gray', 'luxus' ),
            'slug' => 'very-light-gray',
            'color' => '#eee',
        ),
        array(
            'name' => __( 'very dark gray', 'luxus' ),
            'slug' => 'very-dark-gray',
            'color' => '#444',
        ),
    ) );

    remove_theme_support( 'widgets-block-editor' );
}
add_action( 'after_setup_theme', 'luxus_after_setup_theme_supported_features' );

/**
 * Header Actions
 */
function luxus_header_actions() {
	// Add a pingback url auto-discovery header for single posts, pages, or attachments.
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'luxus_header_actions' );

/**
 * Register Sticky Header Script
 */
function luxus_enqueue_sticky_header_script() {

	// Options Logos
	$brand_logo_opt = luxus_options('brand-logo');
	$brand_logo_url = !empty($brand_logo_opt) && !empty($brand_logo_opt['url']) ? $brand_logo_opt['url'] : null;
	$sticky_logo_opt = luxus_options('sticky-logo');
	$sticky_logo_url = !empty($sticky_logo_opt) && !empty($sticky_logo_opt['url']) ? $sticky_logo_opt['url'] : $brand_logo_url;

	// Page Logos
	$brand_logo_meta = luxus_page_meta( '_page_logo' );
	$brand_logo_meta_url = !empty($brand_logo_meta) && !empty($brand_logo_meta['url']) ? $brand_logo_meta['url'] : null;
	$sticky_logo_meta = luxus_page_meta( '_page_sticky_logo' );
	$sticky_logo_meta_url = !empty($sticky_logo_meta) && !empty($sticky_logo_meta['url']) ? $sticky_logo_meta['url'] : null;

	// Logos Url
	$brand_logo = !is_null($brand_logo_meta_url) ? $brand_logo_meta_url : $brand_logo_url;
	$sticky_brand_logo = !is_null($sticky_logo_meta_url) ? $sticky_logo_meta_url : $sticky_logo_url;

	wp_register_script( 'luxus-sticky-header', '', array("jquery"), '', true );
	wp_enqueue_script( 'luxus-sticky-header'  );

	wp_add_inline_script( 'luxus-sticky-header', "
		(function($){

	    	$(window).scroll(function() {

	    		var brandLogo = '{$brand_logo}';
				var stickyLogo = '{$sticky_brand_logo}';

				var height = $(window).scrollTop();

				// Site Header

				if(height > 300) {
					$('.theme-header').addClass('sticky-top');
					$('.brand-logo').attr('src', stickyLogo);

				} else if (height < 1) {
					$('.theme-header').removeClass('sticky-top');
					$('.brand-logo').attr('src', brandLogo);
				}

			});

	   })(jQuery);
	");
}

/**
 * Sticky Header Script
 */
function luxus_sticky_header_script() {

	if( class_exists('CSF') ) {

		$sticky_header = luxus_options('sticky-header');

		if ( $sticky_header == true ) {

			$_sticky_header = luxus_page_meta( '_sticky_header' );

			if ( !is_null($_sticky_header) && $_sticky_header == true ) {

				luxus_enqueue_sticky_header_script();

			} else if ( !is_null($_sticky_header) && $_sticky_header == false ) {

				// If Sticky Header Is Disabled, Disable Sticky Header

			} else {

				luxus_enqueue_sticky_header_script();
			}

		}
	}
}
add_action( 'wp_enqueue_scripts', 'luxus_sticky_header_script' );

/**
 * Ajax Login Model
 */
function luxus_ajax_login_model() {
	// Ajax Login Form Signup URL
	$signup_form_slug = !luxus_options('sl-signup-slug') == null ? luxus_options('sl-signup-slug') : 'wp-login.php?action=register';
	$signup_form_url = home_url( $signup_form_slug );
	?>
	<!-- Ajax Login Model Popup -->
	<div id="sl-login-model">
	    <div id="sl-login-model-content">
	        <i class="sl-icon sl-cross-t close"></i>
	        <h5 class="heading"><?php esc_html_e('User Login', 'luxus'); ?></h5>
	          <form id="login" action="login" method="post">
	            <p class="status"> </p>
	            <div class="form-floating">
				  <input type="text" name="username" class="form-control" id="username" placeholder="<?php esc_attr_e('johndoe', 'luxus'); ?>">
				  <label for="username"><?php esc_html_e('Username*', 'luxus'); ?></label>
				</div>
				<div class="form-floating">
				  <input type="password" name="password" class="form-control" id="password" placeholder="<?php esc_attr_e('**********', 'luxus'); ?>">
				  <label for="password"><?php esc_html_e('Password*', 'luxus'); ?></label>
				</div>
	            <div class="d-grid">
	            	<input class="ajax-login-btn btn" type="submit" value="<?php esc_attr_e('Login', 'luxus'); ?>" name="submit">
	            </div>
	            <div>
	            	<a class="lost" href="<?php echo esc_url(home_url('wp-login.php?action=lostpassword' )); ?>"><?php esc_html_e('Lost your password?', 'luxus'); ?></a>
	            </div>
	            <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
	        </form>
	        <p class="signup-link"><?php esc_html_e('Don\'t have an account?', 'luxus'); ?> <a href="<?php echo esc_url($signup_form_url); ?>"><?php esc_html_e('Sign Up', 'luxus'); ?></a></p>
	    </div>
	</div>
	<?php
}
add_action( 'wp_footer', 'luxus_ajax_login_model' );

/**
 * Preloader
 */
function luxus_preloader() {

	if ( class_exists('CSF') ) {
		$enable_preloader = luxus_options('enable-preloader');
		if( $enable_preloader == true ) {
			$preloader_icon_ph = get_template_directory_uri() . '/assets/images/preloader.svg';
			$preloader_icon_opt = luxus_options('preloader-icon');
			$preloader_icon_url = !$preloader_icon_opt == null ? $preloader_icon_opt['url'] : null;
			$preloader_icon = !$preloader_icon_url == null ? $preloader_icon_url : $preloader_icon_ph;
		    echo '<div id="sl-preloader"><div id="sl-preloader-inner"><img src="'.esc_url($preloader_icon).'" alt="preloader"></div></div>';
		}
	}
}
add_action( 'wp_body_open', 'luxus_preloader' );

/**
 * Back to top
 */
function luxus_back_to_top_btn() {

	if ( class_exists('CSF') ) {
		$back_to_top = luxus_options('back-to-top');
		if( $back_to_top == true ) {
		    echo '<div id="backtoTop"><i class="sl-icon sl-angle-up"></i></div>';
		}
	} else {
		echo '<div id="backtoTop"><i class="sl-icon sl-angle-up"></i></div>';
	}
}
add_action( 'wp_footer', 'luxus_back_to_top_btn' );

/**
 * Cart Popup
 */
function luxus_cart_popup() {

	if ( class_exists( 'woocommerce' ) ) {
		$cart_img = get_template_directory_uri() . '/assets/images/shopping-cart.svg';

		?>
			<div class="sl-cart-popup">
			    <a class="sl-cart-icon" href="<?php echo esc_url(wc_get_cart_url()); ?>">
			        <img src="<?php echo esc_url( $cart_img ); ?>" alt="Cart">
			        <span class="sl-cart-count"><?php echo sprintf ( _n( '%d', '%d', WC()->cart->get_cart_contents_count(), 'luxus' ), WC()->cart->get_cart_contents_count() ); ?></span>
			    </a>
			</div>
		<?php
	}
}
add_action( 'wp_footer', 'luxus_cart_popup' );

/**
 * Ratting Star Field For CPT
 */
if ( class_exists('Luxus_Core') ) {

	//Create the rating field.
	function luxus_reviews_rating_field() {
		if ( is_singular( array( 'property', 'agency', 'agent' ) ) ) : ?>
		    <h6 class="rating-label" for="rating"><?php esc_html_e('Rating', 'luxus'); ?><span class="required">*</span></h6>
		    <fieldset class="comments-rating">
		        <span class="rating-container">
		            <?php for ( $i = 5; $i >= 1; $i-- ) : ?>
		                <input type="radio" id="rating-<?php echo esc_attr( $i ); ?>" name="rating" value="<?php echo esc_attr( $i ); ?>" /><label for="rating-<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $i ); ?></label>
		            <?php endfor; ?>
		            <input type="radio" id="rating-0" class="rating-star" name="rating" value="1" /><label for="rating-0">0</label>
		        </span>
		    </fieldset>
		<?php else: ?>
		    <input type="hidden" name="rating" value="5" />
		<?php endif;
	}
	add_action( 'comment_form_logged_in_after', 'luxus_reviews_rating_field' );
	add_action( 'comment_form_after_fields', 'luxus_reviews_rating_field' );

	//Save the rating submitted by the user.
	function luxus_reviews_save_rating( $comment_id ) {
        if ( ( isset( $_POST['rating'] ) ) && ( '' !== $_POST['rating'] ) ) {
	        $rating = intval( $_POST['rating'] );
	        add_comment_meta( $comment_id, 'rating', $rating );
        }
	}
	add_action( 'comment_post', 'luxus_reviews_save_rating' );

	//Make the rating required.
	function luxus_reviews_require_rating( $commentdata ) {
	    if ( !is_admin() && (!isset($_POST['rating']) || 0 === intval($_POST['rating'])) ) {
	    	wp_die( __( 'Error: You did not add a rating. Hit the Back button on your Web browser and resubmit your comment with a rating.', 'luxus' ) );
	    }
	    return $commentdata;
	}
	add_filter( 'preprocess_comment', 'luxus_reviews_require_rating' );

}

// Luxus Remove Actions
function luxus_remove_actions(){
    remove_action('wp_head', 'icon');
    remove_action('wp_head', 'apple-touch-icon');
	remove_action( 'wp_head', 'wc_gallery_noscript' );
}
add_action( 'init', 'luxus_remove_actions' );

// Custom Search Form
function luxus_custom_search_form( $form ) {
  $form = '<form method="get" id="searchform" class="search-form" action="' . esc_url(home_url( '/' )) . '" >
    <div class="custom-search-form"><label class="screen-reader-text" for="s">' . __( 'Search:', 'luxus' ) . '</label>
    <input type="text" placeholder="'. __( 'Search ...', 'luxus' ) .'" value="' . esc_attr(get_search_query()) . '" name="s" id="s" class="search-field" />
    <button type="submit" value="Search">'. __( 'Search', 'luxus' ) .'</button>
  </div>
  </form>';

  return $form;
}
add_filter( 'get_search_form', 'luxus_custom_search_form', 100 );

// Luxus Template Redirect
function luxus_template_redirect() { 
	ob_start( function( $buffer ){
		$buffer = str_replace( array( ' type="text/css"', " type='text/css'" ), '', $buffer );
		$buffer = str_replace( array( ' type="text/javascript"', " type='text/javascript'" ), '', $buffer );        
		return $buffer;
	});
}
add_action( 'template_redirect', 'luxus_template_redirect' );


/**
 * Adding custom icon to icon control in Elementor
 */

if ( LUXUS_ELEMENTOR_ACTIVE ) {

	// Luxus Carousel Widgets Script
	function luxus_carousel_widgets_script() {

		wp_register_script( 'luxus-elementor', '', array("jquery"), '', true );
		wp_enqueue_script( 'luxus-elementor'  );

		wp_add_inline_script( 'luxus-elementor', "
			jQuery(document).ready(function(e) {
				jQuery('.luxus-carousel').parents('section.elementor-section').css({overflow: 'hidden'});
			});
		");

	}
	add_action( 'wp_enqueue_scripts', 'luxus_carousel_widgets_script' );

	// 	Custom Icons
	function luxus_elementor_custom_icons_tab( $tabs = array() ) {

		$icons_url = esc_url(get_template_directory_uri()) . '/assets/css/fontello.min.css';

		// Append new icons
		$new_icons = array(
			'bedroom',
			'bathroom',
			'car',
			'garage',
			'swimming',
			'focus',
			'area-o',
			'area',
			'image',
			'pin',
			'flash-outline',
			'location',
			'heart',
			'like',
			'heart-fill',
			'like-fill',
			'compare',
			'upload',
			'download',
			'play',
			'play-o',
			'image-o',
			'camera',
			'flash-o',
			'quote-right-alt',
			'verified',
			'blueprint',
			'right-arrows-couple',
			'paper-plane',
			'quote-left-alt',
			'grid-view',
			'flash',
			'user-setting',
			'chat',
			'chat-o',
			'next-arrow',
			'place',
			'eye',
			'diagram',
			'comment',
			'verified-o',
			'calendar',
			'calendar-o',
			'video',
			'tick-o',
			'user-o',
			'avatar',
			'cross-o',
			'search-o',
			'thumb',
			'tick',
			'user',
			'avatar-o',
			'back-arrow',
			'cross',
			'map',
			'check-t',
			'check-o',
			'search',
			'shar',
			'share-t',
			'share-o',
			'villa',
			'camera-t',
			'add-property',
			'plus',
			'plus-o',
			'user-t',
			'play-t',
			'print',
			'print-o',
			'print-t',
			'basket',
			'garden',
			'list-view',
			'pin-o',
			'apartment',
			'apartment-o',
			'3d',
			'star',
			'star-o',
			'star-t',
			'next',
			'down',
			'left',
			'right-quote',
			'left-quote',
			'building',
			'ruler',
			'ruler-o',
			'list',
			'list-o',
			'award-badge',
			'grid-o',
			'fullscreen',
			'cancel',
			'checked',
			'condo',
			'list-view-o',
			'grid-view-o',
			'tick-t',
			'cross-t',
			'settings',
			'clock',
			'clock-o',
			'cog',
			'contract',
			'draft',
			'published',
			'pending',
			'contract-o',
			'target',
			'trash',
			'contract-t',
			'document',
			'email-t',
			'enterprise',
			'home',
			'house',
			'house-badge',
			'house-care',
			'house-check',
			'location-o',
			'love-trust',
			'new-home',
			'office',
			'office-o',
			'realtor',
			'rent-contract',
			'report',
			'sale-property',
			'sale-sign',
			'search-property',
			'search-property-o',
			'search-property-t',
			'shop',
			'shop-o',
			'sketch',
			'subscription',
			'success-star',
			'target-arrow',
			'trust-love',
			'user-ratings',
			'rent-house',
			'add-property-o',
			'house-key',
			'sweet-home',
			'buy-home',
			'mortgage',
			'mortgage-o',
			'property-deal',
			'property-invest',
			'property-listings',
			'property-savings',
			'property-view',
			'calendar-t-1',
			'phone-o',
			'phone-t',
			'world',
			'mail',
			'mail-o',
			'phone',
			'fax',
			'search-house',
			'secure-shield',
			'logout',
			'dashboard',
			'folder',
			'folder-o',
			'website',
			'quote-left',
			'quote-right',
			'quotes',
			'user-th',
			'attach',
			'logout-o',
			'tag',
			'note',
			'doc',
			'comment-o',
			'calendar-t',
			'attach-o',
			'link-o',
			'plus-t',
			'shopping-cart-o',
			'shopping-basket',
			'shopping-cart',
			'shopping-bag',
			'shopping-cart-t',
			'sticky-note-o',
			'sticky-note',
			'link',
			'check-empty',
			'angle-left',
			'angle-right',
			'angle-up',
			'angle-down',
			'circle-empty',
			'circle',
			'check',
			'dot-circled',
			'circle-empty-o',
		);
		
		$tabs['my-custom-icons'] = array(
			'name'          => 'luxus-custom-icons',
			'label'         => esc_html__( 'Luxus Icons', 'luxus' ),
			'labelIcon'     => 'fas fa-star',
			'prefix'        => 'sl-',
			'displayPrefix' => 'sl-icons',
			'url'           => $icons_url,
			'icons'         => $new_icons,
			'ver'           => '1.0.0',
		);

		return $tabs;
	}

	add_filter( 'elementor/icons_manager/additional_tabs', 'luxus_elementor_custom_icons_tab' );
	
	/**
	 * Filters divider widgets and change their content.
	 *
	 * @since 1.0.0
	 * @param string $widget_content The widget HTML output.
	 * @param \Elementor\Widget_Base $widget The widget instance.
	 */
	function luxus_change_divider_span( $widget_content, $widget ) {

		if ( 'divider' === $widget->get_name() ) {

			//Changing span to div <span class="elementor-divider-separator">
			$template_span = '<span class="elementor-divider-separator">';
			$template_span_close = '</span>';
			$template_div = '<div class="elementor-divider-separator">';
			$template_div_close = '</div>';

			$widget_content = str_replace( $template_span, $template_div, $widget_content );
			$widget_content = str_replace( $template_span_close, $template_div_close, $widget_content );

		}

		return $widget_content;

	}
	
	add_filter( 'elementor/widget/render_content', 'luxus_change_divider_span', 10, 2 );
}

/**
 * Proper ob_end_flush() for all levels
 *
 * This replaces the WordPress `wp_ob_end_flush_all()` function
 * with a replacement that doesn't cause PHP notices.
 */
remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );
add_action( 'shutdown', function() {
   while ( @ob_end_flush() );
} );