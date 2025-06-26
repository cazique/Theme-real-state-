<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * Template Name: User Orders Detail Page
 */

//Redirect Subscriber to dashboard
if( current_user_can( 'subscriber' ) ) { wp_redirect( site_url( 'user-dashboard' ) ); }

// Custom Page Title
function luxus_order_detail_page_title() {
    return esc_html__('Order Detail', 'luxus-core') . ' - ' . get_bloginfo();
}
add_action( 'pre_get_document_title', 'luxus_order_detail_page_title' );

if ( isset( $_GET['id'] ) ) {
    $order_id = $_GET['id'];
}else{
    $order_id = null;
} 

$current_user = wp_get_current_user();

if ( !$order_id == null) {

// Custom User Header
require dirname( __FILE__ ) . '/template-parts/header-user.php';

?>

<!-- Main Content -->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="heading-one"><?php esc_html_e('Order Detail', 'luxus-core'); ?></h2>
            </div>
        </div>
    	<div class="row">
        <?php 

        $order = wc_get_order( $order_id );

        $order_user_id = $order->get_customer_id();
        $user_id = $order_user_id == $current_user->ID ? true : false;

        if ( $user_id ) { ?>
            <div class="col-xl-12">
                <div class="user-orders-container">
                <?php
                    $order = wc_get_order( $order_id );
                    $order_status  = $order->get_status(); 
                    $order_created_date  = $order->get_date_created()->format ('Y-m-d');
                    $order_paid_date  = $order->get_date_paid();
                    $paid_date  = !$order_paid_date == null ? $order->get_date_paid()->format ('Y-m-d') : null;
                    $order_completed_date  = $order->get_date_completed();
                    $active_date = !$order_completed_date == null ? $order->get_date_completed()->format ('Y-m-d') : null;
                    $order_currency = $order->get_currency();
                    $order_total_discount = $order->get_total_discount();
                    $order_total_tax = $order->get_total_tax();
                    $order_subtotal = $order->get_subtotal();
                    $order_total = $order->get_total();

                    // Iterating through current orders items
                    foreach( $order->get_items() as $item_id => $item ){

                        // The corresponding product ID (Added Compatibility with WC 3+)
                        $product_id = $item->get_product_id();
                        $package_name = $item->get_name();
                        $quantity = $item->get_quantity();

                        // Get Package Duration from Package
                        $package_duration = $item->get_meta( '_subscription_duration', true );
                        $no_of_posts = $item->get_meta( '_subscription_number_of_posts', true );
                        $no_of_featured_posts = $item->get_meta( '_subscription_number_of_featured_posts', true );
                        $featured_posts_duration = $item->get_meta( '_subscription_featured_posts_duration', true );
                    }

                    if ($order_status == 'completed') {
                        $status = 'active';
                        $thead = 'bg-success';
                    } elseif ($order_status == 'expired') {
                        $status = 'expired';
                        $thead = 'bg-danger';
                    } else {
                        $status  = $order->get_status();
                        $thead = 'bg-primary';
                    }
                    
                    $expire_date = !$active_date == null ? date ( "Y-m-d", strtotime ( $active_date . "+" . $package_duration . " days" ) ) : null;
                ?>
                </div>
                <table class="order-detail table table-bordered table-hover">
                    <thead class="<?php echo esc_attr($thead); ?>">
                        <tr>
                            <th scope="col"><?php esc_html_e('Order ID: ', 'luxus-core'); ?> <span class="order-id"><?php echo esc_html($order_id); ?></span></th>
                            <th scope="col"><?php esc_html_e('Order Status: ', 'luxus-core'); ?> <span class="order-status"><?php echo esc_html(ucfirst($status)); ?></span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row"><?php esc_html_e('Package', 'luxus-core'); ?></th>
                            <td><?php echo esc_html($package_name); ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php esc_html_e('Quantity', 'luxus-core'); ?></th>
                            <td><?php echo esc_html($quantity); ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php esc_html_e('Order Date', 'luxus-core'); ?></th>
                            <td><?php echo esc_html($order_created_date); ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php esc_html_e('Paid Date', 'luxus-core'); ?></th>
                            <td><?php echo esc_html($paid_date); ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php esc_html_e('Active Date', 'luxus-core'); ?></th>
                            <td><?php echo esc_html($active_date); ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php esc_html_e('Expire Date', 'luxus-core'); ?></th>
                            <td><?php echo esc_html($expire_date); ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php esc_html_e('Package Duration', 'luxus-core'); ?></th>
                            <td><?php echo esc_html($package_duration) . ' ' . esc_html__('Day(s)', 'luxus-core'); ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php esc_html_e('No Of Posts', 'luxus-core'); ?></th>
                            <td><?php echo esc_html($no_of_posts) . ' ' . esc_html__('Post(s)', 'luxus-core'); ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php esc_html_e('No Of Featured Posts', 'luxus-core'); ?></th>
                            <td><?php echo esc_html($no_of_featured_posts != null ? $no_of_featured_posts : '0') . ' ' . esc_html__('Post(s)', 'luxus-core'); ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php esc_html_e('Featured Posts Duration', 'luxus-core'); ?></th>
                            <td><?php echo esc_html($featured_posts_duration != null ? $featured_posts_duration : '0') . ' ' . esc_html__('Day(s)', 'luxus-core'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-xl-12">
                <div class="order-review">
                    <p><strong><?php esc_html_e('Quantity:', 'luxus-core'); ?> </strong> <span><?php echo esc_html($quantity); ?></span></p>

                    <p><strong><?php esc_html_e('Total Discount:', 'luxus-core'); ?> </strong> <span><?php echo esc_html($order_total_discount); ?></span></p>

                    <p><strong><?php esc_html_e('Total Tax:', 'luxus-core'); ?> </strong><span><?php echo esc_html($order_total_tax); ?></span></p>

                    <p><strong><?php esc_html_e('Subtotal:', 'luxus-core'); ?> </strong><span><?php echo esc_html($order_subtotal); ?></span></p>

                    <p class="total"><strong><?php esc_html_e('Total:', 'luxus-core'); ?> </strong><span><?php echo esc_html($order_currency) . '(' . get_woocommerce_currency_symbol() . ') ' . esc_html($order_total) ; ?></span></p>
                </div>
            </div>
        <?php } else {

            $url = esc_url( home_url() . '/my-orders' );
            echo '<div class="col-xl-12">';
            echo "<h5>". esc_html__('Nothing Found!', 'luxus-core') ."</h5>";
            echo "<a href='$url' class='sl-btn'>". esc_html__('Back to My Orders', 'luxus-core') ."</a>";
            echo '</div>';
        }?>
    	</div>
    </div>
</div>
<!-- Main Content End -->
<?php
}else{

   wp_redirect( home_url('/my-orders') ); exit;
}

// Custom User Footer
require dirname( __FILE__ ) . '/template-parts/footer-user.php';
