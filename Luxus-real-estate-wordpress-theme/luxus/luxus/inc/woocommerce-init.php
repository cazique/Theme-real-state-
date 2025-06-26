<?php
/**
 * Functions which enhance the theme by hooking into woocommerce
 *
 * @package Luxus
 */

if ( class_exists( 'woocommerce' ) ) {

    // Woocommerce Integration
    add_action( 'after_setup_theme', 'luxus_add_woocommerce_support' );
    function luxus_add_woocommerce_support() {

        add_theme_support( 'woocommerce', array(
            'product_grid'          => array(
                'default_rows'    => 5,
                'min_rows'        => 5,
                'max_rows'        => 8,
                'default_columns' => 3,
                'min_columns'     => 3,
                'max_columns'     => 3,
            ),
        ) );

        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );

    }

    // Remove WooCommerce Actions
    add_action( 'init', 'luxus_woo_remove_actions' );
    function luxus_woo_remove_actions() {

        // Breadcrumbs
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
        // Remove Shop header
        add_filter('woocommerce_show_page_title', '__return_false');
        // Sidebar
        remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
        // Product Thumbnail
        remove_action( 'woocommerce_before_shop_loop_item_title','woocommerce_template_loop_product_thumbnail',10 );
        // Rating Stars
        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

    }

    // Opening div for our content wrapper
    add_action( 'woocommerce_before_main_content', 'luxus_woo_before_main_content', 5 );
    function luxus_woo_before_main_content() {

        // Page Header
        echo '<div class="page-header"><div class="container">';
            echo '<h2 class="page-title">';
                    woocommerce_page_title();
            echo '</h2>';
        echo '</div></div>';

        // Page container
        echo '<div class="page-content"><div class="container">';

    }

    // Closing div for our content wrapper
    add_action( 'woocommerce_after_main_content', 'luxus_woo_after_main_content', 50 );
    function luxus_woo_after_main_content() {
        echo '</div></div>';
    }

    // Product Thumbnail
    add_action( 'woocommerce_before_shop_loop_item_title','luxus_store_loop_product_thumbnail',20 );
    function luxus_store_loop_product_thumbnail() {
        echo '<div class="product-image">' . woocommerce_get_product_thumbnail() . '</div>';
    }

    // Woocommerce Cart Popup
    add_filter( 'woocommerce_add_to_cart_fragments', 'sl_add_to_cart_fragment' );
    function sl_add_to_cart_fragment( $fragments ) {
        global $woocommerce;
        
        ob_start();

        ?>
        <a class="sl-cart-icon" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php _e('View your shopping cart', 'luxus'); ?>">
            <i class="sl-icon sl-shopping-basket"></i>
            <span class="sl-cart-count"><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'luxus'), $woocommerce->cart->cart_contents_count);?></span>
        </a>
        <?php
        $fragments['a.sl-cart-icon'] = ob_get_clean();
        return $fragments;

    }

    // Woocommerce Pagination Icons
    add_filter( 'woocommerce_pagination_args',  'luxus_woo_pagination_icons' );
    function luxus_woo_pagination_icons( $args ) {

        $args['prev_text'] = '<i class="sl-icon sl-back-arrow"></i>';
        $args['next_text'] = '<i class="sl-icon sl-next-arrow"></i>';
        return $args;

    }

    // Return to packages page button in cart page
    add_action( 'woocommerce_cart_is_empty', 'luxus_return_to_packages' );
    function luxus_return_to_packages() {

        if ( class_exists( 'Luxus_Core') ) {

            echo '<p class="return-to-shop"><a class="button back-to-packages wc-backward" href="'. esc_url(home_url('/packages')) .'">'. __('Return to packages', 'luxus') .'</a></p>';
            
        } 

    }

    // Related products output
    add_filter( 'woocommerce_output_related_products_args', 'luxus_related_products', 20 );
      function luxus_related_products( $args ) {
        $args['posts_per_page'] = 3; // 3 related products
        $args['columns'] = 3; // arranged in 3 columns
        return $args;
    }

    // Product Quantity buttons
    add_action( 'woocommerce_after_quantity_input_field', 'luxus_quantity_plus_sign' ); 
    function luxus_quantity_plus_sign() {
        echo '<span class="quantity__button quantity__plus"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span>';
    }
     
    add_action( 'woocommerce_before_quantity_input_field', 'luxus_quantity_minus_sign' );
    function luxus_quantity_minus_sign() {
        echo '<span class="quantity__button quantity__minus"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg></span>';
    }

    // Product Quantity Script
    function luxus_product_quantity() {

        if ( is_cart() || is_product() ) {

            wp_register_script( 'luxus-product-quantity', '', array("jquery"), '', true );
            wp_enqueue_script( 'luxus-product-quantity'  );

            wp_add_inline_script( 'luxus-product-quantity', "
                jQuery(document).ready(function($) {   
                        
                    var forms = jQuery('.woocommerce-cart-form, form.cart');
                            forms.find('.quantity.hidden').prev( '.quantity__button' ).hide();
                            forms.find('.quantity.hidden').next( '.quantity__button' ).hide();

                    $(document).on( 'click', 'form.cart .quantity__button, .woocommerce-cart-form .quantity__button', function() {

                        var \$this = $(this);                    

                        var qty = \$this.closest( '.quantity' ).find( '.qty' );
                        var val = ( qty.val() == '' ) ? 0 : parseFloat(qty.val());
                        var max = parseFloat(qty.attr( 'max' ));
                        var min = parseFloat(qty.attr( 'min' ));
                        var step = parseFloat(qty.attr( 'step' ));

                        if ( \$this.is( '.quantity__plus' ) ) {
                            if ( max && ( max <= val ) ) {
                                qty.val( max ).change();
                            } 
                            else {
                                qty.val( val + step ).change();
                            }
                        } 
                        else {
                            if ( min && ( min >= val ) ) {
                                qty.val( min ).change();
                            } 
                            else if ( val >= 1 ) {
                                qty.val( val - step ).change();
                            }
                        }                           
                    });          
                });
            ");
        }
    }
    add_action( 'wp_enqueue_scripts', 'luxus_product_quantity' );

}