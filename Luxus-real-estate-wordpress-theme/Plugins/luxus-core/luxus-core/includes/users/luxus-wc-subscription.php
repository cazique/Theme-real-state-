<?php
/**
 * subscription Product Type
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Luxus
 */

//Check if WooCommerce is active
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) :

// Add New Product Type Class
add_action( 'woocommerce_init', 'luxus_create_product_type_subscription' );
function luxus_create_product_type_subscription() {
    class WC_Luxus_Subscription_Product extends WC_Product {
        public function __construct( $product ) {
            $this->product_type = 'subscription';
            parent::__construct( $product );
        }
    }
}

// Add New Product Type to Woocommerce Select Dropdown
add_filter( 'product_type_selector', 'luxus_add_product_type_subscription' );
function luxus_add_product_type_subscription( $types ){
    $types[ 'subscription' ] = 'Subscription';
    return $types;
}
 
// Load New Product Type Class
add_filter( 'woocommerce_product_class', 'luxus_woocommerce_product_class', 10, 2 );
function luxus_woocommerce_product_class( $classname, $product_type ) {
    if ( $product_type == 'subscription' ) { 
        $classname = 'WC_Luxus_Subscription_Product';
    }
    return $classname;
}

// Adding Price fields & inventory to subscription product type
add_action( 'admin_enqueue_scripts', 'luxus_subscription_product_script' );
function luxus_subscription_product_script() {
    if ( 'product' != get_post_type() ) {
        return;
    }

    wp_register_script( 'luxus-subscription-product', '', array("jquery"), '', true );
    wp_enqueue_script( 'luxus-subscription-product'  );

    wp_add_inline_script( 'luxus-subscription-product', "
        jQuery(document).ready(function () {
            //for Price tab
            jQuery('.options_group.pricing').addClass('show_if_subscription').show();
            //for Inventory tab
            jQuery('.inventory_options').addClass('show_if_subscription').show();
            jQuery('#inventory_product_data ._manage_stock_field').addClass('show_if_subscription').show();
            jQuery('#inventory_product_data ._sold_individually_field').parent().addClass('show_if_subscription').show();
            jQuery('#inventory_product_data ._sold_individually_field').addClass('show_if_subscription').show();
            //for Shippping tab
            jQuery('.shipping_options').addClass('hide_if_subscription').hide();
        });
    ");
}

// Add the settings under ‘General’ sub-menu
add_action( 'woocommerce_product_options_general_product_data', 'luxus_add_subscription_product_options' );
function luxus_add_subscription_product_options() {

    global $woocommerce, $post;

    echo '<div class="options_group">';

	    // Custom Product Type Meta
	    woocommerce_wp_text_input(
	      array(
	       'id'                => '_subscription_number_of_posts',
	       'label'             => __( 'Number of Posts', 'luxus-core' ),
	       'placeholder'       => __( 'Eg: 10', 'luxus-core' ),
	       'desc_tip'    => 'true',
	       'description'       => __( 'Num of Posts can Publish by Subscriber', 'luxus-core' ),
	       'type'              => 'text',
	       'wrapper_class' => 'show_if_subscription',
	    ));

	    woocommerce_wp_text_input(
	      array(
	       'id'                => '_subscription_number_of_featured_posts',
	       'label'             => __( 'Num of Featured Posts', 'luxus-core' ),
	       'placeholder'       => __( 'Eg: 10', 'luxus-core' ),
	       'desc_tip'    => 'true',
	       'description'       => __( 'Number of Featured Posts can Publish by Subscriber', 'luxus-core' ),
	       'type'              => 'text',
	       'wrapper_class' => 'show_if_subscription',
	    ));

	    woocommerce_wp_text_input(
	      array(
	       'id'                => '_subscription_featured_posts_duration',
	       'label'             => __( 'Featured Posts Duration', 'luxus-core' ),
	       'placeholder'       => __( 'In Days - Eg: 3', 'luxus-core' ),
	       'desc_tip'    => 'true',
	       'description'       => __( 'Featured Posts Duration', 'luxus-core' ),
	       'type'              => 'text',
	       'wrapper_class' => 'show_if_subscription',
	    ));

	    woocommerce_wp_text_input(
	      array(
	       'id'                => '_subscription_duration',
	       'label'             => __( 'Subscription Duration', 'luxus-core' ),
	       'placeholder'       => __( 'In Days - Eg: 30', 'luxus-core' ),
	       'desc_tip'    => 'true',
	       'description'       => __( 'Subscription Duration', 'luxus-core' ),
	       'type'              => 'text',
	       'wrapper_class' => 'show_if_subscription',
	    ));

    echo '</div>';
}

add_action( 'woocommerce_process_product_meta', 'luxus_save_subscription_product_options' );
function luxus_save_subscription_product_options( $post_id ) {

  $number_of_posts = isset( $_POST['_subscription_number_of_posts'] ) ? $_POST['_subscription_number_of_posts'] : '';

  $number_of_featured_posts = isset( $_POST['_subscription_number_of_featured_posts'] ) ? $_POST['_subscription_number_of_featured_posts'] : '';

  $featured_posts_duration = isset( $_POST['_subscription_featured_posts_duration'] ) ? $_POST['_subscription_featured_posts_duration'] : '';

  $subscription_duration = isset( $_POST['_subscription_duration'] ) ? $_POST['_subscription_duration'] : '';

  $product = wc_get_product( $post_id );
  $product->update_meta_data( '_subscription_number_of_posts', $number_of_posts );
  $product->update_meta_data( '_subscription_number_of_featured_posts', $number_of_featured_posts );
  $product->update_meta_data( '_subscription_featured_posts_duration', $featured_posts_duration );
  $product->update_meta_data( '_subscription_duration', $subscription_duration );

  $product->save();

}

// Displaying custom fields in the WooCommerce order and email confirmations
add_action('woocommerce_checkout_create_order_line_item', 'luxus_save_subscription_meta_in_order_item', 20, 4);
function luxus_save_subscription_meta_in_order_item($item, $cart_item_key, $values, $order) {
	
    $orr_number_of_posts = $values['data']->get_meta('_subscription_number_of_posts');
    $orr_number_of_featured_posts = $values['data']->get_meta('_subscription_number_of_featured_posts');
    $orr_featured_posts_duration = $values['data']->get_meta('_subscription_featured_posts_duration');
    $orr_subscription_duration = $values['data']->get_meta('_subscription_duration');

    if ( isset( $orr_number_of_posts ) ) {
        $item->update_meta_data( '_subscription_number_of_posts', $orr_number_of_posts );
    }

    if ( isset( $orr_number_of_featured_posts ) ) {
        $item->update_meta_data( '_subscription_number_of_featured_posts', $orr_number_of_featured_posts );
    }

    if ( isset( $orr_featured_posts_duration ) ) {
        $item->update_meta_data( '_subscription_featured_posts_duration', $orr_featured_posts_duration );
    }

    if ( isset( $orr_subscription_duration ) ) {
        $item->update_meta_data( '_subscription_duration', $orr_subscription_duration );
    }
}

// // Change Order Status to 'completed' during checkout
// Only triggered when an online payment methods & free products
// (not for "cheque", "bacs" or "cod" payment methods)
add_action( 'woocommerce_payment_complete_order_status', 'luxus_wc_auto_complete_paid_order', 10, 3 );
function luxus_wc_auto_complete_paid_order( $status, $order_id, $order ) {
    return 'completed';
}

// Woocommerce Register Custom Status Expired
add_action( 'init', 'luxus_register_order_status_expired' );
function luxus_register_order_status_expired() {
    register_post_status( 'wc-expired', array(
        'label'                     => __( 'Expired', 'luxus-core' ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Expired <span class="count">(%s)</span>', 'Expired <span class="count">(%s)</span>' )
    ) );
}

// Woocommerce Show Custom Status Expired in status list
add_filter( 'wc_order_statuses', 'luxus_order_status_expired');
function luxus_order_status_expired( $order_statuses ) {
    $order_statuses['wc-expired'] = _x( 'Expired', 'Order status', 'luxus-core' ); 
    return $order_statuses;
}

// Auto Expired Subscription
add_action('init', 'luxus_wp_auto_expire_subscription');
function luxus_wp_auto_expire_subscription(){

    // Getting Completed Orders
    $orders = wc_get_orders( array(
        'post_status' => 'wc-completed',
        'numberposts' => -1,
    ) );
    // Loop through each customer WC_Order objects
    if ( sizeof($orders) > 0 ) {
        $expired_text = __('The order is expired.', 'luxus-core');
        foreach( $orders as $order ){
            // Order ID (added WooCommerce 3+ compatibility)
            $order_id = method_exists( $order, 'get_id' ) ? $order->get_id() : $order->id;
            // Order Date
            $order_date = $order->get_date_paid()->format ('Y-m-d'); 
            // Iterating through current orders items (Packages)
            foreach( $order->get_items() as $item_id => $item ){
                // The corresponding product ID (Added Compatibility with WC 3+) 
                $product_id = method_exists( $item, 'get_product_id' ) ? $item->get_product_id() : $item['product_id'];
                // Get Subscription Duration from Order
                $package_duration = $item->get_meta( '_subscription_duration', true );
            }

            $duration_date = date ( "Y-m-d", strtotime ( $order_date . "+" . $package_duration . " days" ) );
            $today = date("Y-m-d");
            if( $duration_date < $today ){
                $order->update_status( 'wc-expired', $expired_text );
            }
        }
    }
}

// Update Featured Properties if Deauration and Order Expired
add_action( 'init', 'luxus_update_featured_posts' );
function luxus_update_featured_posts(){

    $args = array(
        'post_type' => 'property',
        'posts_per_page' => -1,
        'meta_key'      => '_property_label',
        'meta_value'    => '1',
        'meta_compare'  => '='
    );

    // Getting Featured Posts
    $featured_property = get_posts( $args );

    if( ! empty( $featured_property ) ) {
        foreach ( $featured_property as $property ) {

            $post_id = $property->ID;
            $post_author_id = $property->post_author;
            $current_date = date("Y-m-d");
            $expiry_date = get_post_meta( $post_id, "_property_label_expiry", true);
            $unfeatured = 0;
            $post_expired = ' ';

            $author_data = get_userdata( $post_author_id );

            if ( in_array( 'agent', $author_data->roles ) || in_array( 'agency', $author_data->roles ) ) {

                // Getting orders by featured post author id
                $user_orders = wc_get_orders( array(
                    'customer_id' => $post_author_id,
                    'post_status' => 'wc-completed',
                    'numberposts' => -1
                ) );

                if ( $current_date > $expiry_date || sizeof( $user_orders ) <= 0 ) {
                    update_post_meta( $post_id, '_property_label', $unfeatured );
                    update_post_meta( $post_id, '_property_label_expiry', $post_expired );
                }

            } else {

                if ( $current_date > $expiry_date ) {

                    update_post_meta( $post_id, '_property_label', $unfeatured );
                    update_post_meta( $post_id, '_property_label_expiry', $post_expired );
                }
            }
        }
    }
}

// Hide Subscriprion Products from Woocommerce Shop & Search Page
add_action( 'woocommerce_product_query', 'luxus_hide_subscriptions_from_query' );
function luxus_hide_subscriptions_from_query( $query ) {

    if ( ! is_admin() && ! $query->is_main_query() ) return;

    $products = wc_get_products( array(
        'status' => 'publish',
        'type' => 'subscription',  
    ) );

    if ( sizeof($products) > 0 ) {

        $product_ids = array();

        foreach ( $products as $product ) {

            $product_ids[] = $product->get_id();
        }

        if ( ! is_admin() || is_shop() || is_search() ) {

            $query->set( 'post__not_in', $product_ids );

        }
    }

    remove_action( 'woocommerce_product_query', 'luxus_hide_subscriptions_from_query' );
}

// Add Custom Column 'product_type' To Product List
add_filter( 'manage_edit-product_columns', 'luxus_add_product_column', 10, 1 );
function luxus_add_product_column( $columns ) {

    // Return Column and shift Possition
    return array_slice( $columns, 0, 3, true ) + array( 'product_type' => 'Type' ) + array_slice( $columns, 3, count( $columns ) - 3, true );

}

// Echo Custom Column 'product_type' To Product List
add_action( 'manage_product_posts_custom_column', 'luxus_add_product_column_content', 10, 2 );
function luxus_add_product_column_content( $column, $postid ) {
    if ( $column == 'product_type' ) {
        // Get product object
        $product = wc_get_product( $postid );

        // Get type
        $product_type = $product->get_type();
        
        // Output
        echo '<span>' .  ucfirst( $product_type ) . '</span>';
    }
}

// Remove Columns From Product List
add_filter( 'manage_edit-product_columns', 'luxus_products_columns_filter', 10, 1 );
function luxus_products_columns_filter( $columns ) {

    unset($columns['product_tag']);
    unset($columns['post_views']);

    return $columns;
}

endif;
// End Woocommerce Plugin is active