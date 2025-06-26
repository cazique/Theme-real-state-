<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * Template Name: Add Property
 */

//Redirect Subscriber to dashboard
if( current_user_can( 'subscriber' ) ) { wp_redirect( site_url( 'user-dashboard' ) ); }

// Custom Page Title
function luxus_add_property_page_title() {
    return esc_html__('Add Property', 'luxus-core') . ' - ' . get_bloginfo();
} 
add_action( 'pre_get_document_title', 'luxus_add_property_page_title' );

// Enqueue Scripts
function luxus_add_property_enqueue() {
	
	// Media
    wp_enqueue_media();
    wp_register_script('mediaelement', plugins_url('wp-mediaelement.min.js', __FILE__), array('jquery'), '4.8.2', true);
    wp_enqueue_script('mediaelement');
    wp_enqueue_script('media-property', SL_PLUGIN_URL . 'public/js/media-property.js', array('jquery'), '1.0', true);
	
	// Leaflet Js
	wp_enqueue_script( 'leaflet', SL_PLUGIN_URL . 'public/js/leaflet.min.js', array( 'jquery' ), '1.7.1', true );
	
	// Leaflet Js Css
	wp_enqueue_style( 'leaflet', SL_PLUGIN_URL . 'public/css/leaflet.min.css', array(), '1.7.1', 'all' );
	
}
add_action('wp_enqueue_scripts', 'luxus_add_property_enqueue'); 

$current_user = wp_get_current_user();

// Theme Options
$enable_frontend_posting_opt = luxus_options('frontend-property-posting');
$enable_frontend_posting = $enable_frontend_posting_opt != NULL ? $enable_frontend_posting_opt : true;

$free_premium_opt = luxus_options('can-posts-from-dashboard');
$free_premium = $free_premium_opt != NULL ? $free_premium_opt : 'free';

$user_post_status_opt = luxus_options('user-post-status');
$user_post_status = $user_post_status_opt != NULL ? $user_post_status_opt : 'pending';

if ( $enable_frontend_posting ) {

    if ( $free_premium == 'premium' ) {

        // Number of posts user can
        $number_of_posts = array();

        if ( class_exists( 'woocommerce' ) ) {
            // Getting current customer orders
            $user_orders = wc_get_orders( array(
                'customer_id' => $current_user->ID,
                'post_status' => 'wc-completed',
                'numberposts' => -1
            ) );

            // Loop through each customer WC_Order objects
            foreach( $user_orders as $order ){
                
                // Iterating through current orders items
                foreach( $order->get_items() as $item_id => $item ){
                    
                    // Get Value from Order
                    $item_quantity = $item->get_quantity(); 
                    $item_number_of_posts  = $item->get_meta( '_subscription_number_of_posts', true );
                    $total_number_of_posts  = $item_number_of_posts * $item_quantity;

                    $number_of_posts[]  = $total_number_of_posts;
                }
            }
        }

        // Total Number of Posts from Orders
        $user_can_posts = $number_of_posts != NULL ? array_sum($number_of_posts) : 0;

    } else {

        $can_post_props_opt = luxus_options('can-post-props');
        $can_post_props = $can_post_props_opt != NULL ? $can_post_props_opt : 10;

        // Total Number of Posts from Theme Options
        $user_can_posts = $can_post_props;

    }

    // Count Published Properties
    $user_published_posts = count_user_posts( $current_user->ID , 'property' );

    // Remaining Posts
    $remaining_posts = $user_can_posts - $user_published_posts;

    // Count Draft Properties
    $draft_properties = count( get_posts( array( 
        'post_type' => 'property', 
        'author'    => $current_user->ID, 
        'post_status'=> 'draft',
    ) ) );
    $user_draft_properties = $draft_properties != NULL ? $draft_properties : 0 ;

    // Count Pending Properties
    $pending_properties = count( get_posts( array( 
        'post_type' => 'property', 
        'author'    => $current_user->ID, 
        'post_status'=> 'pending',
    ) ) );
    $user_pending_properties = $pending_properties != NULL ? $pending_properties : 0 ;

    $luxus_error = array();

    $map_marker = SL_PLUGIN_URL . 'public/images/map-pin.png';

    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'new-property' )
    {

        // Getting Values From Form
        $title = $_POST['title'];
        $content = $_POST['description'];
        $thumbnail = $_POST['property_thumbnail_id'];
        $panorama = isset( $_POST['property_three'] ) ? $_POST['property_three'] : '';
        $label = $_POST['label'];
        $type = $_POST['type'];
        $status = $_POST['status'];
        $build_year = $_POST['build_year'];
        $price_prefix = $_POST['price_prefix'];
        $price = $_POST['price'];
        $price_postfix = $_POST['price_postfix'];
        $bedrooms = $_POST['bedrooms'];
        $bathrooms = $_POST['bathrooms'];
        $parking = $_POST['parking'];
        $area_size = $_POST['area_size'];
        $area_postfix = $_POST['area_postfix'];
        $land_area = $_POST['land_area'];
        $land_area_postfix = $_POST['land_area_postfix'];
        $property_video = $_POST['property_video'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip = $_POST['zip'];
        $address = $_POST['address'];
        $nearby = $_POST['nearby'];
        $country = $_POST['country'];
        $property_gallery = isset( $_POST['property_images_ids'] ) ? $_POST['property_images_ids'] : '';
        $property_gallery_str = !empty( $property_gallery ) ? implode( ',', $property_gallery ) : '';
        $features = isset( $_POST['features'] ) ? $_POST['features'] : '';
        $features_values = isset( $_POST['features'] ) ? array_values( $_POST['features'] ) : array();
        $property_add_features = $_POST['additional_feature'];
        $additional_features_array = array_map('array_filter', $property_add_features);
        $additional_features = array_filter($additional_features_array);
        $property_map = $_POST['property_map'];

        // Form Validation
        global $luxus_error;
        $luxus_error = new WP_Error;

        if ( empty( $title ) ) {
            $luxus_error->add( 'title', __('Please Enter your post title.' , 'luxus-core') );
        }
        if ( empty( $type ) ) {
            $luxus_error->add( 'type', __('Please Select Property Type.' , 'luxus-core') );
        }
        if ( empty( $status ) ) {
            $luxus_error->add( 'status', __('Please Select Property Status.' , 'luxus-core') );
        }
        if ( empty( $price ) ) {
            $luxus_error->add( 'price', __('Please Enter Price.' , 'luxus-core') );
        }
        if ( empty( $area_size ) ) {
            $luxus_error->add( 'area_size', __('Please Enter Area Size.' , 'luxus-core') );
        }
        if ( empty( $city ) ) {
            $luxus_error->add( 'city', __('Please Select Property City.' , 'luxus-core') );
        }
        if ( empty( $state ) ) {
            $luxus_error->add( 'state', __('Please Select Property State/Province.' , 'luxus-core') );
        }
        if ( empty( $country ) ) {
            $luxus_error->add( 'country', __('Please Select Property Country.' , 'luxus-core') );
        }
        if ( ! wp_verify_nonce( $_POST['add_property_nonce'], 'add_property_action' ) ) {
            $luxus_error->add( 'nonce', __('Something is wrong, Please try again.' , 'luxus-core') );
        }

        // If No Errors Insert Post
        if ( 1 > count( $luxus_error->get_error_messages() ) ) {

            $post_id = wp_insert_post(array (
                'post_type' => 'property',
                'post_title' => sanitize_text_field( $title ),
                'post_content' => sanitize_textarea_field( $content ),
                'post_status' => $user_post_status,
            ));

            // insert post taxonomies
            wp_set_post_terms( $post_id, $features, 'property_feature' );
            wp_set_post_terms( $post_id, $type, 'property_type' );
            wp_set_post_terms( $post_id, $status, 'property_status');
            wp_set_post_terms( $post_id, $city, 'property_city');
            wp_set_post_terms( $post_id, $state, 'property_province');
            wp_set_post_terms( $post_id, $country, 'property_country');

            // insert post meta
            add_post_meta( $post_id, '_property_type', sanitize_text_field( $type ) );
            add_post_meta( $post_id, '_property_status', sanitize_text_field( $status ) );
            add_post_meta( $post_id, '_property_city', sanitize_text_field( $city ) );
            add_post_meta( $post_id, '_property_state', sanitize_text_field( $state ) );
            add_post_meta( $post_id, '_property_country', sanitize_text_field( $country ) );

            // insert post meta
            add_post_meta( $post_id, '_thumbnail_id', sanitize_text_field( $thumbnail ) );
            add_post_meta( $post_id, '_property_panorama', sanitize_text_field( $panorama ) );
            add_post_meta( $post_id, '_property_build', sanitize_text_field( $build_year ) );
            add_post_meta( $post_id, '_property_price_prefix', sanitize_text_field( $price_prefix ) );
            add_post_meta( $post_id, '_property_price', sanitize_text_field( $price ) );
            add_post_meta( $post_id, '_property_price_postfix', sanitize_text_field( $price_postfix ) );
            add_post_meta( $post_id, '_property_bedrooms', sanitize_text_field( $bedrooms ) );
            add_post_meta( $post_id, '_property_bathrooms', sanitize_text_field( $bathrooms ) );
            add_post_meta( $post_id, '_property_parking', sanitize_text_field( $parking ) );
            add_post_meta( $post_id, '_property_area', sanitize_text_field( $area_size ) );
            add_post_meta( $post_id, '_property_area_postfix', sanitize_text_field( $area_postfix ) );
            add_post_meta( $post_id, '_property_larea', sanitize_text_field( $land_area ) );
            add_post_meta( $post_id, '_property_larea_postfix', sanitize_text_field( $land_area_postfix ) );
            add_post_meta( $post_id, '_property_video', esc_url_raw( $property_video ) );
            add_post_meta( $post_id, '_property_zip', sanitize_text_field( $zip ) );
            add_post_meta( $post_id, '_property_st_address', sanitize_text_field( $address ) );
            add_post_meta( $post_id, '_property_nearby', sanitize_text_field( $nearby ) );
            add_post_meta( $post_id, '_property_add_features', $additional_features );
            add_post_meta( $post_id, '_property_map', $property_map );
            add_post_meta( $post_id, '_property_gallery', $property_gallery_str );

            // Redirect to Current Page
            wp_redirect( get_bloginfo('url').'/add-property/');
            exit;
        }

    } else {
        $type = '';
        $status = '';
        $city = '';
        $state = '';
        $country = '';
        $features_values = array();
        $property_add_features = array();
        $property_map = array(
            "address" => '',
            "latitude" => 0,
            "longitude" => 0,
            "zoom" => 5
        );              
    }

}

// Custom User Header
require dirname( __FILE__ ) . '/template-parts/header-user.php';

?>

<!-- Main Content -->
<div class="main-content">
<?php if ( $enable_frontend_posting ) { ?>
    <div class="container">
        <!-- Quick Ovewview -->
        <div class="quick-overview">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <a href="<?php echo esc_url(site_url().'/published-properties'); ?>">
                        <div class="card-counter sl-gra-blue">
                            <i class="sl-icon sl-published"></i>
                            <span class="count-numbers"><?php echo esc_html($user_published_posts !== null ? $user_published_posts : '0'); ?></span>
                            <span class="count-name"><?php esc_html_e('Published Posts', 'luxus-core'); ?></span>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="<?php echo esc_url(site_url().'/add-property'); ?>">
                        <div class="card-counter sl-gra-yellow">
                            <i class="sl-icon sl-target"></i>
                            <span class="count-numbers"><?php echo esc_html($remaining_posts !== null && $remaining_posts >= 0 ? $remaining_posts : '0'); ?></span>
                            <span class="count-name"><?php esc_html_e('Remaining Posts', 'luxus-core'); ?></span>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="<?php echo site_url().'/pending-properties'; ?>">
                        <div class="card-counter sl-gra-purple">
                            <i class="sl-icon sl-pending"></i>
                            <span class="count-numbers"><?php echo esc_html($user_pending_properties !== null ? $user_pending_properties : '0'); ?></span>
                            <span class="count-name"><?php esc_html_e('Pending Posts', 'luxus-core'); ?></span>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="<?php echo site_url().'/draft-properties'; ?>">
                        <div class="card-counter sl-gra-red">
                            <i class="sl-icon sl-draft"></i>
                            <span class="count-numbers"><?php echo esc_html($user_draft_properties !== null ? $user_draft_properties : '0'); ?></span>
                            <span class="count-name"><?php esc_html_e('Draft Posts', 'luxus-core'); ?></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <h2 class="heading-one"><?php esc_html_e('Add New Property', 'luxus-core'); ?></h2>
        <?php

            if( $free_premium == 'premium' && $remaining_posts <= 0 ) {

            ?>

            <div class="sl-box">
                <div class="alert-message alert-message-info">
                    <h6><?php esc_html_e('Your can not post property.', 'luxus-core'); ?></h6>
                     <p><?php esc_html_e('Please Subscribe to submit new properties. To subscribe please go to ', 'luxus-core'); ?> <a href="<?php echo esc_url(site_url() . '/packages'); ?>"><?php esc_html_e('Packages', 'luxus-core'); ?></a>.</p>
                </div>
            </div>

            <?php


            } else {

                if( $remaining_posts <= 0 ) {

                ?>

                <div class="sl-box">
                    <div class="alert-message alert-message-info">
                        <h6><?php esc_html_e('Your can not post property.', 'luxus-core'); ?></h6>
                        <p><?php esc_html_e('You have exceeded the maximum posting limit.', 'luxus-core'); ?></p>
                    </div>
                </div>

                <?php

                }

            }

            // Print Errors
            if ( is_wp_error( $luxus_error ) ) {
                echo '<div class="errors sl-box">';
                foreach ( $luxus_error->get_error_messages() as $error ) {
                    echo '<strong class="text-danger">Error: </strong>';
                    echo $error . '<br/>';
                }
                echo '</div>';
            }

        ?>
        <form class="property-submit-form" method="post" action="<?php esc_url(get_bloginfo('url').'/add-property/') ?>" enctype="multipart/form-data">
            <div class="sl-box">
                <div class="col-lg-12">
                    <h6 class="heading"><?php esc_html_e('General Information', 'luxus-core'); ?></h6>
                </div>
                <div class="col-lg-12 ">
                    <label for="title"><?php esc_html_e('Property Title', 'luxus-core'); ?></label>
                    <input type="text" class="form-control" name="title" value="<?php echo esc_attr(isset($title) ? $title : ''); ?>" id="title" placeholder="<?php esc_attr_e('Enter property title.', 'luxus-core'); ?>">
                </div>
                <div class="col-lg-12">
                    <label for="description"><?php esc_html_e('Property Description', 'luxus-core'); ?></label>
                    <textarea class="form-control" name="description" id="description" rows="7" placeholder="<?php esc_attr_e('Enter property description.', 'luxus-core'); ?>"><?php echo esc_html(isset($content) ? $content : ''); ?></textarea>
                </div>
                <div class="col-lg-12">
                    <div class="row gx-3">
                        <div class="col-lg-3">
                            <!-- Property laabel Hidden Field -->
                            <input type="hidden" name="label" value="0">

                            <?php
                                //Property Type Taxonomy
                                $property_types = get_terms( array( 'taxonomy' => 'property_type', 'hide_empty' => false ) );
                            ?>
                            <label for="type"><?php esc_html_e('Property Type', 'luxus-core'); ?></label>
                            <div class="sl-select">
                                <select name="type" class="form-control"  id="type">
                                        <option value=""><?php esc_html_e('Select Property Type', 'luxus-core'); ?></option>
                                    <?php
                                        if( $property_types != NULL ):
                                            foreach($property_types as $p_type) { ?>
                                                <option value="<?php echo esc_attr($p_type->term_id); ?>" <?php echo esc_attr( $type == $p_type->term_id ? 'selected' : '' ); ?>>
                                                    <?php echo esc_html($p_type->name); ?>   
                                                </option>
                                        <?php } else: ?>
                                        <option value="none"><?php esc_html_e('None', 'luxus-core'); ?></option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                        	<?php
                                //Property Status Taxonomy
                                $property_status = get_terms( array( 'taxonomy' => 'property_status', 'hide_empty' => false ) );
                            ?>
                            <label for="status"><?php esc_html_e('Property Status', 'luxus-core'); ?></label>
                            <div class="sl-select">
                                <select name="status" class="form-control"  id="status">
                                	<option value=""><?php esc_html_e('Select Property Status', 'luxus-core'); ?></option>
                                    <?php
                                        if( $property_status != NULL ):
                                            foreach($property_status as $p_status) { ?>
                                            <option value="<?php echo esc_attr($p_status->term_id); ?>" <?php echo esc_attr( $status == $p_status->term_id ? 'selected' : '' ); ?>>
                                                <?php echo esc_html($p_status->name); ?> 
                                            </option>
                                        <?php } else: ?>
                                            <option value="none"><?php esc_html_e('None', 'luxus-core'); ?></option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label for="area_size"><?php esc_html_e('Area Size', 'luxus-core'); ?> (<?php echo luxus_area_units(); ?>)</label>
                            <input type="text" class="form-control" name="area_size" value="<?php echo esc_attr(isset($area_size) ? $area_size : ''); ?>" id="area_size" placeholder="<?php esc_attr_e('eg. 140', 'luxus-core'); ?>">
                            <input type="hidden" name="area_postfix" value="Sqft" id="area_postfix">
                        </div>
                        <div class="col-lg-3">
                            <label for="land_area"><?php esc_html_e('Land Area', 'luxus-core'); ?> (<?php echo luxus_area_units(); ?>)</label>
                            <input type="text" class="form-control" name="land_area" value="<?php echo esc_attr(isset($land_area) ? $land_area : ''); ?>" id="land_area" placeholder="<?php esc_attr_e('eg. 160', 'luxus-core'); ?>">
                            <input type="hidden" name="land_area_postfix" value="Sqft" id="land_area_postfix">
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="row gx-3">
                        <div class="col-lg-3">
                            <label for="price_prefix"><?php esc_html_e('Price Prefix', 'luxus-core'); ?></label>
                            <input type="text" class="form-control" name="price_prefix" value="<?php echo esc_attr(isset($price_prefix) ? $price_prefix : ''); ?>" id="price_prefix">
                        </div>
                        <div class="col-lg-3">
                            <label for="price"><?php esc_html_e('Price', 'luxus-core'); ?> (<?php echo luxus_currency_symbol(); ?>)</label>
                            <input type="text" class="form-control" name="price" value="<?php echo esc_attr(isset($price) ? $price : ''); ?>" id="price" placeholder="<?php esc_attr_e('eg. 15000000', 'luxus-core'); ?>">
                        </div>
                        <div class="col-lg-3">
                            <label for="price_postfix"><?php esc_html_e('Price Postfix', 'luxus-core'); ?></label>
                            <input type="text" class="form-control" name="price_postfix" value="<?php echo esc_attr(isset($price_postfix) ? $price_postfix : ''); ?>" id="price_postfix" placeholder="<?php esc_attr_e('eg. MO, YE, OT', 'luxus-core'); ?>">
                        </div>
                        <div class="col-lg-3">
                            <label for="build_year"><?php esc_html_e('Build Year', 'luxus-core'); ?></label>
                            <input type="text" class="form-control" name="build_year" value="<?php echo esc_attr(isset($build_year) ? $build_year : ''); ?>" id="build_year" placeholder="<?php esc_attr_e('eg. 2015', 'luxus-core'); ?>">
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="row gx-3">
                        <div class="col-lg-3">
                            <label for="bedrooms"><?php esc_html_e('Bedrooms', 'luxus-core'); ?></label>
                            <input type="text" class="form-control" name="bedrooms" value="<?php echo esc_attr(isset($bedrooms) ? $bedrooms : ''); ?>" id="bedrooms" placeholder="<?php esc_attr_e('eg. 5', 'luxus-core'); ?>">
                        </div>
                        <div class="col-lg-3">
                            <label for="bathrooms"><?php esc_html_e('Bathrooms', 'luxus-core'); ?></label>
                            <input type="text" class="form-control" name="bathrooms" value="<?php echo esc_attr(isset($bathrooms) ? $bathrooms : ''); ?>" id="bathrooms" placeholder="<?php esc_attr_e('eg. 2', 'luxus-core'); ?>">
                        </div>
                        <div class="col-lg-3">
                            <label for="parking"><?php esc_html_e('Parking', 'luxus-core'); ?></label>
                            <input type="text" class="form-control" name="parking" value="<?php echo esc_attr(isset($parking) ? $parking : ''); ?>" id="parking" placeholder="<?php esc_attr_e('eg. 1', 'luxus-core'); ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="sl-box">
                <div class="col-lg-12">
                    <h6 class="heading"><?php esc_html_e('Property Features', 'luxus-core'); ?></h6>
                </div>
                <div class="col-lg-12">
                <?php
                    //Property Features Taxonomy
                    $property_feature = get_terms( array( 'taxonomy' => 'property_feature', 'hide_empty' => false ) );

                    if( $property_feature != NULL ): ?>
                        <ul class="frontend_features">
                                <?php foreach($property_feature as $feature) : ?>
                                <li>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="features[]" value="<?php echo esc_attr($feature->term_id); ?>" id="feature-<?php echo esc_attr($feature->term_id); ?>" <?php echo esc_attr(in_array( $feature->term_id, $features_values ) ? "checked='checked'" : NULL); ?>>
                                <label class="custom-control-label" for="feature-<?php echo esc_attr($feature->term_id); ?>"> <?php echo esc_html($feature->name); ?> </label>
                            </div>
                                </li>
                                <?php endforeach; ?>
                        </ul>
                    <?php endif;
                ?>
                </div>
            </div>
            <div class="sl-box">
                <div class="additional-features">
                    <div class="row">
                        <div class="col-lg-12">
                            <h6 class="heading"><?php esc_html_e('Additional Features', 'luxus-core'); ?></h6>
                        </div>
                    </div>
                    <?php $index = 0;

                    if ( !empty($property_add_features) ) :
                        foreach($property_add_features as $key => $value):
                        $index++;
                    ?>
                    <div class="row">
                        <div class="col-lg-5">
                            <input type="text" name="additional_feature[<?php echo esc_attr($index); ?>][add_feature_label]" id="feature_title" class="form-control" value="<?php echo esc_attr($value['add_feature_label']); ?>">
                        </div>
                        <div class="col-lg-5">
                            <input type="text" name="additional_feature[<?php echo esc_attr($index); ?>][add_feature_value]"  id="feature_value" class="form-control" value="<?php echo esc_attr($value['add_feature_value']); ?>">
                        </div>
                        <div class="col-lg-2">
                            <button class="btn btn-danger remove form-control" type="button"><i class="glyphicon glyphicon-remove"></i> <?php esc_html_e('Remove', 'luxus-core'); ?></button>
                        </div>
                    </div>
                    <?php
                        endforeach;
                    else: ?>
                        <input type="hidden" name="additional_feature[0][add_feature_label]" id="feature_title" class="form-control">
                        <input type="hidden" name="additional_feature[0][add_feature_value]" id="feature_value" class="form-control">
                    <?php
                    endif;
                    ?>
                </div>
                <div class="row additional-features-add-btn">
                    <div class="col-lg-2">
                        <button class="btn btn-success add-more" type="button"><i class="fa fa-plus"></i> <?php esc_html_e('Add More', 'luxus-core'); ?></button>
                    </div>
                </div>
            </div>
            <div class="sl-box">
                <div class="row">
                    <div class="col-lg-12">
                        <h6 class="heading"><?php esc_html_e('Property Media', 'luxus-core'); ?></h6>
                    </div>
                    <div class="col-lg-12">
                        <label for="property_video"><?php esc_html_e('Property Video URL:', 'luxus-core'); ?></label>
                        <input type="text" class="form-control" name="property_video" value="<?php echo esc_attr(isset($property_video) ? $property_video : ''); ?>" id="property_video">
                    </div>
                    <div class="col-lg-6">
                        <?php
                        if ( !empty( $thumbnail ) ) {
                            $placeholder_upload_thumb = wp_get_attachment_url( $thumbnail );
                        } else {
                            $placeholder_upload_thumb = SL_PLUGIN_URL . 'public/images/placholder-upload-thumb.jpg';
                        }
                        ?>
                        <div id='property-thumbnail-preview-wrapper' style="background-image: url('<?php echo esc_url($placeholder_upload_thumb); ?>'); ">
                        </div>
                        <input id="upload_property_thumbnail" type="button" class="button form-control" value="<?php esc_attr_e( 'Upload Property Thumbnail', 'luxus-core' ); ?>"/>
                        <input type="hidden" name="property_thumbnail_id" id="property_thumbnail_id" value="<?php echo esc_attr(!empty( $thumbnail ) ? $thumbnail : ''); ?>">
                    </div>
                    <div class="col-lg-6">
                        <?php
                        if ( !empty( $panorama['url'] ) ){
                            $placeholder_upload_vr = $panorama['url'];
                        } else {
                            $placeholder_upload_vr = SL_PLUGIN_URL . 'public/images/placholder-upload-vr.jpg';
                        }
                        ?>
                        <div id='property-three-preview-wrapper' style="background-image: url('<?php echo esc_url($placeholder_upload_vr); ?>'); ">
                        </div>
                        <input id="upload_property_three" type="button" class="button form-control" value="<?php esc_attr_e( 'Upload Property 360 Image', 'luxus-core' ); ?>"/>
                        <!-- Hidden -->
                        <input type="hidden" name="property_three[url]" id="property_three_url" value="<?php echo esc_attr(!empty( $panorama ) ? $panorama['url'] : ''); ?>">
                        <input type="hidden" name="property_three[id]" id="property_three_id" value="<?php echo esc_attr(!empty( $panorama ) ? $panorama['id'] : ''); ?>">
                        <input type="hidden" name="property_three[width]" id="property_three_width" value="<?php echo esc_attr(!empty( $panorama ) ? $panorama['width'] : ''); ?>">
                        <input type="hidden" name="property_three[height]" id="property_three_height" value="<?php echo esc_attr(!empty( $panorama ) ? $panorama['height'] : ''); ?>">
                        <input type="hidden" name="property_three[thumbnail]" id="property_three_thumbnail" value="<?php echo esc_attr(!empty( $panorama ) ? $panorama['thumbnail'] : ''); ?>">
                        <input type="hidden" name="property_three[alt]" id="property_three_alt" value="<?php echo esc_attr(!empty( $panorama ) ? $panorama['alt'] : ''); ?>">
                        <input type="hidden" name="property_three[title]" id="property_three_title" value="<?php echo esc_attr(!empty( $panorama ) ? $panorama['title'] : ''); ?>">
                        <input type="hidden" name="property_three[description]" id="property_three_description" value="<?php echo esc_attr(!empty( $panorama ) ? $panorama['description'] : ''); ?>">
                    </div>
                    <div class="col-lg-12">
                        <?php
                            $placeholder_upload_gallery = SL_PLUGIN_URL . 'public/images/placholder-upload-gallery.jpg';
                        ?>
                        <div id="property_images" style="background-image: url('<?php echo esc_url($placeholder_upload_gallery); ?>'); ">
                        <?php
                        if( !empty( $property_gallery ) ){
                            foreach ( $property_gallery as $key => $id ) { 
                                $img_url = wp_get_attachment_url( $id );
                                echo '<div class="property_images_preview"><span class="removebtn">X</span><img src="' . esc_url($img_url) . '" ><input id="property_images_ids' . esc_attr($id) . '" type="hidden" name="property_images_ids[]"  value="' . esc_attr($id) . '"></div>';
                            }
                        }
                        ?>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <input type="button" class="form-control" name="upload_property_images"  id="upload_property_images" value="<?php esc_attr_e('Upload Property Images', 'luxus-core'); ?>"/>
                    </div>
                </div>
            </div>
            <div class="sl-box">
                <div class="col-lg-12">
                    <h6 class="heading"><?php esc_html_e('Property Address', 'luxus-core'); ?></h6>
                </div>
                <div class="col-lg-12">
                    <div class="row gx-3">
                        <div class="col-lg-4">
                            <label for="address"><?php esc_html_e('Street Address', 'luxus-core'); ?></label>
                            <input type="text" class="form-control" name="address" value="<?php echo esc_attr(isset($address) ? $address : ''); ?>" id="address">
                        </div>
                        <div class="col-lg-4">
                            <?php
                            //User City Taxonomy
                            $property_cities = get_terms( array( 'taxonomy' => 'property_city', 'hide_empty' => false ) );
                            ?>
                            <label for="city"><?php esc_html_e('City', 'luxus-core'); ?></label>
                            <div class="sl-select">
                                <select name="city" class="form-control"  id="city">
                                        <option value=""><?php esc_html_e('Select City', 'luxus-core'); ?></option>
                                    <?php
                                        if( $property_cities != NULL ):
                                            foreach($property_cities as $p_city) { ?>
                                            <option value="<?php echo esc_attr($p_city->term_id); ?>" <?php echo esc_attr( $city == $p_city->term_id ? 'selected' : '' ); ?>>
                                                <?php echo esc_html($p_city->name); ?>  
                                            </option>
                                        <?php } else: ?>
                                            <option value="none"><?php esc_html_e('None', 'luxus-core'); ?></option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <?php
                            //User Province Taxonomy
                            $property_states = get_terms( array( 'taxonomy' => 'property_province', 'hide_empty' => false ) );
                            ?>
                            <label for="state"><?php esc_html_e('State / Province', 'luxus-core'); ?></label>
                            <div class="sl-select">
                                <select name="state" class="form-control"  id="state">
                                        <option value=""><?php esc_html_e('Select State/Province', 'luxus-core'); ?></option>
                                    <?php
                                        if( $property_states != NULL ):
                                            foreach($property_states as $p_state) { ?>
                                            <option value="<?php echo esc_attr($p_state->term_id); ?>" <?php echo esc_attr( $state == $p_state->term_id ? 'selected' : '' ); ?>>
                                                <?php echo esc_html($p_state->name); ?>  
                                            </option>
                                        <?php } else: ?>
                                            <option value="none"><?php esc_html_e('None', 'luxus-core'); ?></option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="row gx-3">
                        <div class="col-lg-4">
                            <label for="zip"><?php esc_html_e('Zip / Postal Code', 'luxus-core'); ?></label>
                            <input type="text" class="form-control" name="zip" value="<?php echo esc_attr(isset($zip) ? $zip : ''); ?>" id="zip">
                        </div>
                        <div class="col-lg-4">
                            <label for="nearby"><?php esc_html_e('Near By', 'luxus-core'); ?></label>
                            <input type="text" class="form-control" name="nearby" value="<?php echo esc_attr(isset($nearby) ? $nearby : ''); ?>" id="nearby">
                        </div>
                        <div class="col-lg-4">
                            <?php
                                //User Country Taxonomy
                                $property_countries = get_terms( array( 'taxonomy' => 'property_country', 'hide_empty' => false ) );
                            ?>
                            <label for="country"><?php esc_html_e('Country', 'luxus-core'); ?></label>
                            <div class="sl-select">
                                <select name="country" class="form-control"  id="country">
                                        <option value=""><?php esc_html_e('Select Country', 'luxus-core'); ?></option>
                                    <?php
                                        if( $property_countries != NULL ):
                                            foreach($property_countries as $p_country) { ?>
                                            <option value="<?php echo esc_attr($p_country->term_id); ?>" <?php echo esc_attr( $country == $p_country->term_id ? 'selected' : '' ); ?>>
                                                <?php echo esc_html($p_country->name); ?>
                                            </option>
                                        <?php } else: ?>
                                            <option value="none"><?php esc_html_e('None', 'luxus-core'); ?></option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sl-box">
                <div class="col-lg-12">
                    <h6 class="heading"><?php esc_html_e('Property Map', 'luxus-core'); ?></h6>
                </div>
                <div class="col-lg-12 add-property-map">
                    <div id="map"></div>
                    <input type="hidden" name="property_map[address]" id="st_address" value="<?php echo esc_attr($property_map['address']); ?>" />
                    <input type="hidden" name="property_map[latitude]" id="lat" value="<?php echo esc_attr($property_map['latitude']); ?>" />
                    <input type="hidden" name="property_map[longitude]" id="lng" value="<?php echo esc_attr($property_map['longitude']); ?>" />
                    <input type="hidden" name="property_map[zoom]" id="zoom" value="<?php echo esc_attr($property_map['zoom']); ?>" />
                </div>
            </div>

            <?php if( $free_premium == 'premium' && $remaining_posts <= 0 ): ?>

                <div class="sl-box">
                    <div class="alert-message alert-message-info">
                        <h6><?php esc_html_e('Your can not post property.', 'luxus-core'); ?></h6>
                        <p><?php esc_html_e('Please Subscribe to submit new properties. To subscribe please go to ', 'luxus-core'); ?> <a href="<?php echo esc_url(site_url() . '/packages'); ?>"><?php esc_html_e('Packages', 'luxus-core'); ?></a>.</p>
                    </div>
                </div>

            <?php else:


                if ( $remaining_posts <= 0 ) {

                ?>

                <div class="sl-box">
                    <div class="alert-message alert-message-info">
                        <h6><?php esc_html_e('Your can not post property.', 'luxus-core'); ?></h6>
                        <p><?php esc_html_e('Please Subscribe to submit new properties. To subscribe please go to ', 'luxus-core'); ?> <a href="<?php echo esc_url(site_url() . '/packages'); ?>"><?php esc_html_e('Packages', 'luxus-core'); ?></a>.</p>
                    </div>
                </div>

                <?php } else { ?>

                    <div class="sl-box">
                        <div class="col-lg-12">
                            <button type="submit" id="submit-property" class="sl-btn-fill"><?php esc_html_e('Submit Property', 'luxus-core'); ?></button>
                            <?php wp_nonce_field( "add_property_action", "add_property_nonce" ); ?>
                            <input name="action" type="hidden" id="action" value="new-property" />
                        </div>
                    </div>

                <?php }

            endif; ?>

        </form>
    </div>

<?php } else { ?>

    <div class="container">
        <div class="sl-box">
            <div class="alert-message alert-message-info">
                <h6><?php esc_html_e('Your can not post property.', 'luxus-core'); ?></h6>
                <p><?php esc_html_e('Fronted property posting is disabled.', 'luxus-core'); ?></p>
            </div>
        </div>
    </div>

<?php } ?>

</div>
<!-- Main Content End -->

<?php

if ( $enable_frontend_posting ) {

    // Getting Values from From
    $mLocationLat = $property_map['latitude'];
    $mLocationLon = $property_map['longitude'];

    // Add Property Script
    wp_register_script( 'luxus-add-property', '', array("jquery"), '', true );
    wp_enqueue_script( 'luxus-add-property'  );

    wp_add_inline_script( 'luxus-add-property', "

        jQuery( document ).ready( function( $ ) {

            // Lat Long
            var markerLocation = [{$mLocationLat}, {$mLocationLon}];
            // Zoom Level
            var mapZoom = 5;

            // Default Marker Position
            if (markerLocation[0] == 0 && markerLocation[1] == 0) {
                markerLocation = [30.0497935, 60.3349021];
            }

            var map = L.map('map', {
                center: markerLocation,
                zoom: mapZoom,
            });

            L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href=\"https://osm.org/copyright\">OpenStreetMap</a> contributors'
            }).addTo(map);

            map.attributionControl.setPrefix(false);


            // create custom icon
            var mapMarker = L.icon({
                iconUrl: '{$map_marker}',
                iconSize: [40, 48], // size of the icon
            });

            var marker = new L.marker(markerLocation, {
                icon: mapMarker,
                draggable: 'true'
            });

            function addValueToTextBox(lt,ln){
                document.getElementById('lat').value = lt;
                document.getElementById('lng').value = ln;
            }

            document.getElementById('zoom').value = mapZoom;

            marker.on('dragend', function(event){
                var marker = event.target;
                var location = marker.getLatLng();
                var lat = location.lat;
                var lon = location.lng;
                addValueToTextBox(lat,lon);
            });

            marker.addTo(map);

            // Additional Features //

            var index = 99;
            jQuery('.add-more').on('click', function(){
                index++;

                var html = \"<div class='row'><div class='col-lg-5'><input type='text' name='additional_feature[\"+ index +\"][add_feature_label]' id='feature_title' class='form-control' placeholder='Enter Feature Title'></div><div class='col-lg-5'><input type='text' name='additional_feature[\"+ index +\"][add_feature_value]' id='feature_value' class='form-control' placeholder='Enter Feature Value'></div><div class='col-lg-2'><button class='btn btn-danger remove form-control' type='button'><i class='fa fa-times'></i>Remove</button></div></div>\";

                jQuery('.additional-features').append(html);
            });

            jQuery('body').on('click','.remove',function(){ 
                jQuery(this).parents('.row').remove();
            });

        });

    ");

}

// Custom User Footer
require dirname( __FILE__ ) . '/template-parts/footer-user.php';
