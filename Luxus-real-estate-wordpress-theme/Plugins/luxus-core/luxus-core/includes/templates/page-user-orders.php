<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * Template Name: User Orders Page
 */

//Redirect Subscriber to dashboard
if( current_user_can( 'subscriber' ) ) { wp_redirect( site_url( 'user-dashboard' ) ); }

// Custom Page Title
function luxus_user_orders_page_title() {
    return esc_html__('Orders', 'luxus-core') . ' - ' . get_bloginfo();
}
add_action( 'pre_get_document_title', 'luxus_user_orders_page_title' );

// Custom User Header
require dirname( __FILE__ ) . '/template-parts/header-user.php';

$current_user = wp_get_current_user();

?>

<!-- Main Content -->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="heading-one"><?php esc_html_e('Orders', 'luxus-core'); ?></h2>
            </div>
        </div>
    	<div class="row">
            <div class="col-xl-12">
                <div class="user-orders-container">
                <?php

                if ( class_exists( 'woocommerce' ) ) {
                    // Getting current customer orders
                    $user_orders = wc_get_orders( array(
                        'customer_id' => $current_user->ID,
                        'numberposts' => -1
                    ) );

                } else {
                    $user_orders = array();
                }

                if ( sizeof($user_orders) > 0 ) :

                // Loop through each customer WC_Order objects
                foreach( $user_orders as $order ) {

                    $order_id  = $order->get_id();
                    $order_status  = $order->get_status();
                    $order_created_date  = $order->get_date_created()->format ('Y-m-d');

                    $order_paid_date  = $order->get_date_paid();
                    $paid_date  = !$order_paid_date == null ? $order->get_date_paid()->format ('Y-m-d') : null;

                    $order_completed_date  = $order->get_date_completed();
                    $active_date = !$order_completed_date == null ? $order->get_date_completed()->format ('Y-m-d') : null;

                    $payment_method = $order->get_payment_method();

                    // Iterating through current orders items
                    foreach( $order->get_items() as $item_id => $item ){

                        // The corresponding product ID (Added Compatibility with WC 3+)
                        $product_id   = $item->get_product_id();
                        $package_name    = $item->get_name();

                        // $allmeta = $item->get_meta_data();
                        $package_duration = $item->get_meta( '_subscription_duration', true );

                    }

                    if ( $order_status == 'completed' ) {
                        $status = 'active';
                    } elseif ( $order_status == 'expired' ) {
                        $status = 'expired';
                    } else {
                        $status  = $order->get_status();
                    }

                    $expire_date = !$active_date == null ? date ( "Y-m-d", strtotime ( $active_date . "+" . $package_duration . " days" ) ) : null;

                    ?>
                    <div class="user-order <?php echo esc_attr($status); ?>">
                        <div class="order-id"><span><?php echo esc_html__('Order ID:', 'luxus-core') . esc_html($order_id); ?></span></div>
                        <div class="package-name"><a href="<?php echo esc_url(site_url('packages')); ?>"><?php echo esc_html($package_name); ?></a></div>
                        <div class="order-date"><span><?php echo esc_html__('Order Date:', 'luxus-core') .  esc_html($order_created_date); ?></span></div>
                        <?php if( !$expire_date == null ) : ?>
                            <div class="order-date"><span><?php echo esc_html__('Expire Date:', 'luxus-core') . esc_html($expire_date); ?></span></div>
                        <?php endif; ?>
                        <div class="right">
                            <div class="order-status <?php echo esc_attr($status); ?>"><span><?php echo esc_html(ucfirst($status)); ?></span></div>
                            <div class="order-view"><a href="<?php echo esc_url(home_url() . '/my-order/?id=' . $order_id); ?>"><i class="fa fa-eye"></i></a></div>
                        </div>
                    </div>
                <?php

                }

                else: ?>

                    <div class="alert-message alert-message-info">
                        <h6><?php esc_html_e('Orders not found.', 'luxus-core'); ?></h6>
                        <p><?php esc_html_e('Sorry! you do not subscribe any package. To subscribe please go to ', 'luxus-core'); ?> <a href="<?php echo esc_url(site_url() . '/packages'); ?>"><?php esc_html_e('Packages', 'luxus-core'); ?></a>.</p>
                    </div>

                <?php endif; ?>
                </div>
            </div>
    	</div>
    </div>
</div>
<!-- Main Content End -->

<?php

// Custom User Footer
require dirname( __FILE__ ) . '/template-parts/footer-user.php';
