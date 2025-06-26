<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * Template Name: Reviews Page
 */

// Custom Page Title
function luxus_packages_page_title() {
    return esc_html__('Packages', 'luxus-core') . ' - ' . get_bloginfo();
}
add_action( 'pre_get_document_title', 'luxus_packages_page_title' );

// Custom User Header
require dirname( __FILE__ ) . '/template-parts/header-user.php';

?>

<!-- Main Content -->
<div class="packages-container main-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="heading-one"><?php esc_html_e('Packages', 'luxus-core'); ?></h2>
            </div>
        </div>
    	<div class="row sl-packages">
            <?php

            $free_premium_opt = luxus_options('can-posts-from-dashboard');
            $free_premium = $free_premium_opt != NULL ? $free_premium_opt : 'free';

            if ( $free_premium == 'premium' ) {

                if ( class_exists( 'woocommerce' ) ) {

                    $products = wc_get_products( array(

                        'status' => 'publish',
                        'type' => 'subscription',  
                    ) );

                } else { 
                    $products = array();
                }

                if ( sizeof($products) > 0 ) :

                    foreach ( $products as $product ) {

                        $product_id = $product->get_id();
                        $product_slug = $product->get_slug();;
                        $product_name = $product->get_name();
                        $currency = get_woocommerce_currency_symbol();
                        $regular_price = $product->get_regular_price();
                        $sale_price = $product->get_sale_price();
                        $description = $product->get_description();
                        $short_description = $product->get_short_description();
                        $add_to_cart_url = $product->add_to_cart_url();

                        $number_of_posts = get_post_meta( $product_id, '_subscription_number_of_posts', true );
                        $number_of_featured_posts = get_post_meta( $product_id, '_subscription_number_of_featured_posts', true );
                        $duration = get_post_meta( $product_id, '_subscription_duration', true );
                        $months = floor( $duration / 30 );
                        $days = $duration - ( $months*30 );

                    ?>

                    <div class="col-lg-4">
                        <div class="package-one">
                            <div class="header">
                                <div class="title">
                                    <h2><?php echo $product_name; ?></h2>
                                </div>
                                <?php if( !$sale_price == null ) { ?>
                                    <div class="price regular-price"><?php echo esc_html($currency) . esc_html($regular_price); ?></div>
                                    <div class="price sales"><?php echo esc_html($currency) . esc_html($sale_price); ?></div>
                                <?php } else { ?>
                                    <div class="price">
                                        <?php echo esc_html(!$regular_price == 0 ? $currency . $regular_price : 'Free'); ?> 
                                    </div>
                                <?php } ?>
                                <div class="description">
                                <?php
                                    echo  esc_html(!$months == 0 ? $months . ' ' . ( $months > 1 ? __('Months', 'luxus-core') : __('Month', 'luxus-core') ) : null) . ' ';
                                    echo  esc_html(!$days == 0 ? $days . ' ' . ( $days > 1 ? __('Days', 'luxus-core') : __('Day', 'luxus-core') ) : null);
                                ?> 
                                </div>
                                <div class="border-img">
                                    <img src="<?php echo esc_url(SL_PLUGIN_URL . 'public/images/pricing-header-border2.png'); ?>">
                                </div>
                            </div>
                            <div class="features">
                                <?php
                                    if ( !$description == null ) {
                                        echo $description;
                                    } else { ?>
                                        <ul>
                                            <li><?php echo esc_html__('Number Of Posts: ', 'luxus-core') . esc_html($number_of_posts); ?></li>
                                            <li><?php echo esc_html__('Number Of Featured Posts: ', 'luxus-core') . esc_html($number_of_featured_posts); ?> </li>
                                        </ul>
                                <?php  } ?>
                            </div>
                            <div class="action">
                                <?php

                                //Restrict Subscriber
                                if( current_user_can( 'subscriber' ) ) : ?>

                                    <p class="packages-msg"><?php esc_html_e('You are registered as Subscriber/Guest user, Please upgrade your account to Agent or Agency for subscribe package.', 'luxus-core'); ?></p>

                                <?php else: ?>
                                    <a rel="nofollow" href="<?php echo esc_url($add_to_cart_url); ?>" data-quantity="1" data-product_id="<?php echo esc_attr($product_id); ?>" data-product_sku="" class="add_to_cart_button ajax_add_to_cart"><?php esc_html_e('Subscribe', 'luxus-core'); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php

                }

                else: ?>
                    <div class="col-xl-12">
                        <div class="alert-message alert-message-info">
                            <h6><?php esc_html_e('Packages not found.', 'luxus-core'); ?></h6>
                            <p><?php esc_html_e('Sorry! no packages found.', 'luxus-core'); ?></p>
                        </div>
                    </div>

                <?php endif;


            }

            ?>

    	</div>
    </div>
</div>
<!-- Main Content End -->

<?php

// Custom User Footer
require dirname( __FILE__ ) . '/template-parts/footer-user.php';
