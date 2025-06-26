<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * Template Name: Edit Property
 */

//Redirect Subscriber to dashboard
if( current_user_can( 'subscriber' ) ) { wp_redirect( site_url( 'user-dashboard' ) ); }

// Custom Page Title
function luxus_edit_property_page_title() {
    return esc_html__('Edit Property', 'luxus-core') . ' - ' . get_bloginfo();
}
add_action( 'pre_get_document_title', 'luxus_edit_property_page_title' );

// Enqueue Scripts
function luxus_edit_property_enqueue() {
	
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
add_action('wp_enqueue_scripts', 'luxus_edit_property_enqueue');

if( isset( $_GET['edit_property'] ) ) {
    if ( current_user_can( 'edit_post', $_GET['edit_property'] ) ) {
        $post_id =  $_GET['edit_property'];
    }
    else {
        wp_redirect('published-properties');
    }
} else {
    wp_redirect('published-properties');
}

$current_user = wp_get_current_user();

// Error Msgs
$luxus_error = array();

$map_marker = SL_PLUGIN_URL . 'public/images/map-pin.png';

if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'edit-property' ) {

    // Getting Values From Form
    $title = $_POST['title'];
    $content = $_POST['description'];
    $thumbnail = $_POST['property_thumbnail_id'];
    $panorama = $_POST['property_three'];
    $label = isset( $_POST['label'] ) ? $_POST['label'] : '';
    $expiry_date = $_POST['expiry_date'];
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
    $property_gallery = $_POST['property_images_ids'];
    $property_gallery_str = implode( ',', $property_gallery );
    $features = isset( $_POST['features'] ) ? $_POST['features'] : '';

    $property_add_features = $_POST['additional_feature'];

    if (!empty($property_add_features)) {

        $additional_features_array = array_map('array_filter', $property_add_features);
        $additional_features = array_filter($additional_features_array);

    } else {
        
        $additional_features = $_POST['additional_feature'];
    }

    $property_map = $_POST['property_map'];

    // Form Validation
    global $luxus_error;
    $luxus_error = new WP_Error;

    if ( empty( $title ) ) {
        $luxus_error->add( 'title', ' Please Enter your post title.' );
    }
    if ( ! wp_verify_nonce( $_POST['edit_property_nonce'], 'edit_property_action' ) ) {
        $luxus_error->add( 'nonce', ' Something is wrong, Please try again.' );
    }

    // If No Errors Insert Post
    if ( 1 > count( $luxus_error->get_error_messages() ) ) {

        $post_status = get_post_status( $post_id );

        wp_update_post(array (
            'ID' => esc_sql( $post_id ),
            'post_title' => sanitize_text_field( $title ),
            'post_content' => sanitize_textarea_field( $content ),
            'post_status' => $post_status,
        ));

        // insert post taxonomies
        wp_set_post_terms( $post_id, $features, 'property_feature' );
        wp_set_post_terms( $post_id, $type, 'property_type' );
        wp_set_post_terms( $post_id, $status, 'property_status');
        wp_set_post_terms( $post_id, $city, 'property_city');
        wp_set_post_terms( $post_id, $state, 'property_province');
        wp_set_post_terms( $post_id, $country, 'property_country');

        // insert post meta
        update_post_meta( $post_id, '_property_type', sanitize_text_field( $type ) );
        update_post_meta( $post_id, '_property_status', sanitize_text_field( $status ) );
        update_post_meta( $post_id, '_property_city', sanitize_text_field( $city ) );
        update_post_meta( $post_id, '_property_state', sanitize_text_field( $state ) );
        update_post_meta( $post_id, '_property_country', sanitize_text_field( $country ) );

        update_post_meta( $post_id, '_property_label', sanitize_text_field( $label ) );
        update_post_meta( $post_id, '_property_label_expiry', sanitize_text_field( $expiry_date ) );
        update_post_meta( $post_id, '_thumbnail_id', sanitize_text_field( $thumbnail ) );
        update_post_meta( $post_id, '_property_panorama', sanitize_text_field( $panorama ) );
        update_post_meta( $post_id, '_property_build', sanitize_text_field( $build_year ) );
        update_post_meta( $post_id, '_property_price_prefix', sanitize_text_field( $price_prefix ) );
        update_post_meta( $post_id, '_property_price', sanitize_text_field( $price ) );
        update_post_meta( $post_id, '_property_price_postfix', sanitize_text_field( $price_postfix ) );
        update_post_meta( $post_id, '_property_bedrooms', sanitize_text_field( $bedrooms ) );
        update_post_meta( $post_id, '_property_bathrooms', sanitize_text_field( $bathrooms ) );
        update_post_meta( $post_id, '_property_parking', sanitize_text_field( $parking ) );
        update_post_meta( $post_id, '_property_area', sanitize_text_field( $area_size ) );
        update_post_meta( $post_id, '_property_area_postfix', sanitize_text_field( $area_postfix ) );
        update_post_meta( $post_id, '_property_larea', sanitize_text_field( $land_area ) );
        update_post_meta( $post_id, '_property_larea_postfix', sanitize_text_field( $land_area_postfix ) );
        update_post_meta( $post_id, '_property_video', esc_url_raw( $property_video ) );
        update_post_meta( $post_id, '_property_zip', sanitize_text_field( $zip ) );
        update_post_meta( $post_id, '_property_st_address', sanitize_text_field( $address ) );
        update_post_meta( $post_id, '_property_nearby', sanitize_text_field( $nearby ) );
        update_post_meta( $post_id, '_property_add_features', $additional_features );
        update_post_meta( $post_id, '_property_map', $property_map );
        update_post_meta( $post_id, '_property_gallery', $property_gallery_str );

        // Redirect to current page
        wp_redirect( get_bloginfo('url').'/edit-property?edit_property=' . $post_id );
        exit;
    }
}

// Custom user Header
require dirname( __FILE__ ) . '/template-parts/header-user.php';

//Fetching Post Data
$post_data = get_post( $post_id);

$property_label = luxus_post_meta( '_property_label', $post_id );
$featured_expiry = luxus_post_meta( '_property_label_expiry', $post_id );
$property_build = luxus_post_meta( '_property_build', $post_id );
$property_thumbnail = luxus_post_meta( '_thumbnail_id', $post_id );
$property_panorama = luxus_post_meta( '_property_panorama', $post_id );
$property_area_size = luxus_post_meta( '_property_area', $post_id );
$property_area_postfix = luxus_post_meta( '_property_area_postfix', $post_id );
$property_land_area = luxus_post_meta( '_property_larea', $post_id );
$property_land_postfix = luxus_post_meta( '_property_larea_postfix', $post_id );
$property_price_prefix = luxus_post_meta( '_property_price_prefix', $post_id );
$property_price = luxus_post_meta( '_property_price', $post_id );
$property_price_postfix = luxus_post_meta( '_property_price_postfix', $post_id );
$property_bedrooms = luxus_post_meta( '_property_bedrooms', $post_id );
$property_bathrooms = luxus_post_meta( '_property_bathrooms', $post_id );
$property_parking = luxus_post_meta( '_property_parking', $post_id );
$property_video_url = luxus_post_meta( '_property_video', $post_id );
$property_zip_code = luxus_post_meta( '_property_zip', $post_id );
$property_street = luxus_post_meta( '_property_st_address', $post_id );
$property_nearby = luxus_post_meta( '_property_nearby', $post_id );
$property_gallery_imgs = luxus_post_meta( '_property_gallery', $post_id );
$property_add_feature = luxus_post_meta( '_property_add_features', $post_id );

$property_map_meta = luxus_post_meta( '_property_map', $post_id );

$map_address = isset( $property_map_meta['address'] ) ? $property_map_meta['address'] : '' ;
$map_latitude = isset( $property_map_meta['latitude'] ) ? $property_map_meta['latitude'] : '' ;
$map_longitude = isset( $property_map_meta['longitude'] ) ? $property_map_meta['longitude'] : '' ;
$map_zoom = isset( $property_map_meta['zoom'] ) ? $property_map_meta['zoom'] : '' ;

$free_premium_opt = luxus_options('can-posts-from-dashboard');
$free_premium = $free_premium_opt != NULL ? $free_premium_opt : 'free';

?>

<!-- Main Content -->
<div class="main-content">
    <div class="container">
        <h2 class="heading-one"><?php esc_html_e('Edit Property', 'luxus-core'); ?></h2>

        <?php
            // Print Errors
            if ( is_wp_error( $luxus_error ) ) {
                echo '<div class="errors sl-box">';
                foreach ( $luxus_error->get_error_messages() as $error ) {
                    echo '<strong class="text-danger">'. __('Errors:', 'luxus-core') .' </strong>';
                    echo $error . '<br/>';
                }
                echo '</div>';
            }
        ?>
        <form class="property-submit-form" method="post" action="<?php esc_url(get_bloginfo('url').'/add-property/') ?>" enctype="multipart/form-data">
            <div class="row sl-box">
                <div class="col-lg-12">
                    <h6 class="heading"><?php esc_html_e('General Information', 'luxus-core'); ?></h6>
                </div>

                <?php

                // Number of posts user can
                $number_of_posts = array();
                $package_posts = 0;
                $user_published_posts = 0;
                $remaining_posts = 0;

                // Number of Featured posts user can
                $number_of_featured_posts = array();
                $package_featured_posts = 0;
                $featured_posts_duration = 0;

                if( $free_premium == 'premium' ) {

                    echo '<div class="col-lg-12">';

                    if ( class_exists( 'woocommerce' ) ) {
                        // Getting current customer orders
                        $customer_orders = wc_get_orders( array(
                            'customer_id' => $current_user->ID,
                            'post_status' => 'wc-completed',
                            'numberposts' => -1
                        ) );

                        // Loop through each customer WC_Order objects
                        foreach( $customer_orders as $order ){
                            // Iterating through current orders items
                            foreach( $order->get_items() as $item_id => $item ){

                                // Get Value from Order
                                $item_quantity = $item->get_quantity(); 
                                $item_number_of_posts  = $item->get_meta( '_subscription_number_of_posts', true );
                                $total_number_of_posts  = $item_number_of_posts * $item_quantity;

                                $number_of_posts[]  = $total_number_of_posts;

                                // Get Value from Order
                                $item_quantity_featured = $item->get_quantity(); 
                                $item_number_of_featured_posts  = $item->get_meta( '_subscription_number_of_featured_posts', true );
                                $total_number_of_featured_posts  = $item_number_of_featured_posts * $item_quantity_featured;

                                $number_of_featured_posts[]  = $total_number_of_featured_posts;
                                $featured_posts_duration  = $item->get_meta( '_subscription_featured_posts_duration', true );
                            }
                        }

                        // Total Number of Posts from Orders
                        $package_posts = $number_of_posts != NULL ? array_sum($number_of_posts) : 0;
                        // Count Published Properties
                        $user_published_posts = count_user_posts( $current_user->ID , 'property' );
                        // Remaining Posts
                        $remaining_posts = $package_posts - $user_published_posts;
                        $package_featured_posts = $number_of_featured_posts != NULL ? array_sum($number_of_featured_posts) : 0;

                    }

                    // Getting Current User Featured Posts Count
                    $featured_posts_args = array(
                        'author'        =>  $current_user->ID, 
                        'post_type'     => 'property',
                        'meta_key'      => '_property_label',
                        'meta_value'    => '1',
                        'posts_per_page' => -1 // no limit
                    );

                    $current_user_featured_posts = get_posts( $featured_posts_args );
                    $user_featured_posts = count($current_user_featured_posts);

                    $label_checked = '';

                    if( $property_label == true ) {
                        $label_checked = 'checked';
                    }

                    if ( $user_featured_posts < $package_featured_posts ) { ?>

                        <div class="custom-control custom-switch">
                          <input type="checkbox" name="label" <?php echo esc_attr($label_checked); ?> class="custom-control-input" id="property_label" value="<?php echo esc_attr($property_label); ?>">
                          <label class="custom-control-label" for="property_label"><?php esc_html_e('Make This Property Featured?', 'luxus-core'); ?></label>
                        </div>

                        <!-- Expiry Date -->
                        <input type="text" class="form-control" name="expiry_date" value="<?php echo esc_attr($featured_expiry); ?>" id="expiry_date" readonly>

                    <?php

                    } else {

                        if ( $property_label == '1' ) { ?>

                            <div class="custom-control custom-switch">
                              <input type="checkbox" name="label" <?php echo esc_attr($label_checked); ?> class="custom-control-input" id="property_label" value="<?php echo esc_attr($property_label); ?>">
                              <label class="custom-control-label" for="property_label"><?php esc_html_e('Make This Property Featured?', 'luxus-core'); ?></label>
                            </div>

                            <!-- Expiry Date -->
                            <input type="text" class="form-control" name="expiry_date" value="<?php echo esc_attr($featured_expiry); ?>" id="expiry_date">

                        <?php } else { ?>

                            <p><?php esc_html_e('Your featured property limit is exceed, To Make this property featured please upgrade your package.', 'luxus-core'); ?></p>
                            <input type="hidden" name="label" value="<?php echo esc_attr($property_label); ?>">
                            <input type="hidden" name="expiry_date" value="<?php echo esc_attr($featured_expiry); ?>">

                        <?php }

                    }

                    echo '</div><hr/>';

                } else {

                    $featured_posts_duration = 0;

                }

                ?>

                <div class="col-lg-12 ">
                    <label for="title"><?php esc_html_e('Property Title', 'luxus-core'); ?></label>
                    <input type="text" class="form-control" name="title" value="<?php echo esc_attr($post_data->post_title); ?>" id="title">
                </div>
                <div class="col-lg-12">
                    <label for="description"><?php esc_html_e('Property Description', 'luxus-core'); ?></label>
                    <textarea class="form-control" name="description" id="description" rows="7"><?php echo esc_html($post_data->post_content); ?></textarea>
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-3">
                            <?php
                                //Property Type Taxonomy
                                $property_types = get_terms( array( 'taxonomy' => 'property_type', 'hide_empty' => false ) );

                                // Getting Post Taxonomy BY ID
    							$post_property_type = get_the_terms( $post_id, 'property_type' );

                                $property_type_id = !empty($post_property_type) ? $post_property_type[0]->term_id : NULL;
                            ?>
                            <label for="type"><?php esc_html_e('Property Type', 'luxus-core'); ?></label>
                            <select name="type" class="form-control"  id="type">
                                    <option value="none"><?php esc_html_e('Select Property Type', 'luxus-core'); ?></option>
                                <?php
                                    if( $property_types != NULL ):
                                        foreach($property_types as $type) { ?>
                                    <option <?php echo esc_attr($property_type_id == $type->term_id ? 'selected' : ''); ?> value="<?php echo esc_attr($type->term_id); ?>"><?php echo esc_html($type->name); ?></option>
                                    <?php } else: ?>
                                    <option value="none"><?php esc_html_e('None', 'luxus-core'); ?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                        	<?php
                                //Property Status Taxonomy
                                $property_status = get_terms( array( 'taxonomy' => 'property_status', 'hide_empty' => false ) );
                                // Getting Post Taxonomy BY ID
    							$post_property_status = get_the_terms( $post_id, 'property_status' );
                                $property_status_id = !empty($post_property_status) ? $post_property_status[0]->term_id : NULL;
                            ?>
                            <label for="status"><?php esc_html_e('Property Status', 'luxus-core'); ?></label>
                            <select name="status" class="form-control"  id="status">
                            		<option value="none"><?php esc_html_e('Select Property Status', 'luxus-core'); ?></option>
                                <?php
                                    if( $property_status != NULL ):
                                        foreach($property_status as $status) { ?>
                                    <option <?php echo esc_attr($property_status_id == $status->term_id ? 'selected' : ''); ?> value="<?php echo esc_attr($status->term_id); ?>"><?php echo esc_html($status->name); ?></option>
                                    <?php } else: ?>
                                    <option value="none"><?php esc_html_e('None', 'luxus-core'); ?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="area_size"><?php esc_html_e('Area Size', 'luxus-core'); ?> (<?php echo luxus_area_units(); ?>)</label>
                            <input type="text" class="form-control" name="area_size" value="<?php echo esc_attr($property_area_size); ?>" id="area_size" placeholder="<?php esc_attr_e('eg. 140', 'luxus-core'); ?>">
                            <input type="hidden" name="area_postfix" value="Sqft" id="area_postfix">
                        </div>
                        <div class="col-lg-3">
                            <label for="land_area"><?php esc_html_e('Land Area', 'luxus-core'); ?> (<?php echo luxus_area_units(); ?>)</label>
                            <input type="text" class="form-control" name="land_area" value="<?php echo esc_attr($property_land_area); ?>" id="land_area" placeholder="<?php esc_attr_e('eg. 160', 'luxus-core'); ?>">
                            <input type="hidden" name="land_area_postfix" value="Sqft" id="land_area_postfix">
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="price_prefix"><?php esc_html_e('Price Prefix', 'luxus-core'); ?></label>
                            <input type="text" class="form-control" name="price_prefix" value="<?php echo esc_attr($property_price_prefix); ?>" id="price_prefix">
                        </div>
                        <div class="col-lg-3">
                            <label for="price"><?php esc_html_e('Price', 'luxus-core'); ?> (<?php echo luxus_currency_symbol(); ?>)</label>
                            <input type="text" class="form-control" name="price" value="<?php echo esc_attr($property_price); ?>" id="price" placeholder="<?php esc_attr_e('(currency) eg. 15000000', 'luxus-core'); ?>">
                        </div>
                        <div class="col-lg-3">
                            <label for="price_postfix"><?php esc_html_e('Price Postfix', 'luxus-core'); ?></label>
                            <input type="text" class="form-control" name="price_postfix" value="<?php echo esc_attr($property_price_postfix); ?>" id="price_postfix" placeholder="<?php esc_attr_e('(duration) eg. MO, YE, OT', 'luxus-core'); ?>">
                        </div>
                        <div class="col-lg-3">
                            <label for="build_year"><?php esc_html_e('Build Year', 'luxus-core'); ?></label>
                            <input type="text" class="form-control" name="build_year" value="<?php echo esc_attr($property_build); ?>" id="build_year" placeholder="<?php esc_attr_e('eg. 2015', 'luxus-core'); ?>">
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="bedrooms"><?php esc_html_e('Bedrooms', 'luxus-core'); ?></label>
                            <input type="text" class="form-control" name="bedrooms" value="<?php echo esc_attr($property_bedrooms); ?>" id="bedrooms" placeholder="<?php esc_attr_e('eg. 5', 'luxus-core'); ?>">
                        </div>
                        <div class="col-lg-3">
                            <label for="bathrooms"><?php esc_html_e('Bathrooms', 'luxus-core'); ?></label>
                            <input type="text" class="form-control" name="bathrooms" value="<?php echo esc_attr($property_bathrooms); ?>" id="bathrooms" placeholder="<?php esc_attr_e('eg. 2', 'luxus-core'); ?>">
                        </div>
                        <div class="col-lg-3">
                            <label for="parking"><?php esc_html_e('Parking', 'luxus-core'); ?></label>
                            <input type="text" class="form-control" name="parking" value="<?php echo esc_attr($property_parking); ?>" id="parking" placeholder="<?php esc_attr_e('eg. 1', 'luxus-core'); ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row sl-box">
                <div class="col-lg-12">
                    <h6 class="heading"><?php esc_html_e('Property Features', 'luxus-core'); ?></h6>
                </div>
                <div class="col-lg-12">
                <?php
                    //Property Features Taxonomy
                    $property_feature = get_terms( array( 'taxonomy' => 'property_feature', 'hide_empty' => false ) );
                    // Getting Post Taxonomy BY ID
    				$post_property_features = get_the_terms( $post_id, 'property_feature' );

                    if( $property_feature != NULL ): ?>
                        <ul class="frontend_features">
                            <?php foreach( $property_feature as $feature ) :
                            	$checked = '';

                                if( $post_property_features != NULL) {
                                    foreach( $post_property_features as $post_feature ){  
                                        if( $post_feature->term_id == $feature->term_id ){
                                            $checked = 'checked';
                                        }
                                    }
                                }
                            ?>
                            <li>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" <?php echo esc_attr($checked); ?> class="custom-control-input" name="features[]" value="<?php echo esc_attr($feature->term_id); ?>" id="feature-<?php echo esc_attr($feature->term_id); ?>">
                                <label class="custom-control-label" for="feature-<?php echo esc_attr($feature->term_id); ?>"> <?php echo esc_html($feature->name); ?> </label>
                            </div>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                <?php endif; ?>
                </div>
            </div>
            <div class="sl-box">
                <div class="additional-features">
                    <div class="row">
                        <div class="col-lg-12">
                            <h6 class="heading"><?php esc_html_e('Property Additional Features', 'luxus-core'); ?></h6>
                        </div>
                    </div>

                    <?php $index = 0;
					if ( !empty($property_add_feature) ) :
                    	foreach($property_add_feature as $key => $value):
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
                            <button class="btn btn-danger remove form-control" type="button"><i class="fa fa-times"></i> <?php esc_html_e('Remove', 'luxus-core'); ?></button>
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
            <div class="row sl-box">
                <div class="col-lg-12">
                    <h6 class="heading"><?php esc_html_e('Property Media', 'luxus-core'); ?></h6>
                </div>
                <div class="col-lg-12">
                    <label for="property_video"><?php esc_html_e('Property Video URL:', 'luxus-core'); ?></label>
                    <input type="text" class="form-control" name="property_video" value="<?php echo esc_attr($property_video_url); ?>" id="property_video">
                </div>
                <div class="col-lg-6">
                    <?php
                        $thumbnail_placeholder = SL_PLUGIN_URL . 'public/images/user-title-bg.jpg';

                        $get_thumbnail_url = !empty($property_thumbnail) ? wp_get_attachment_image_src( $property_thumbnail, 'full' ) : '';
                        
                        $thumbnail_url = !empty($get_thumbnail_url) ? $get_thumbnail_url[0] : '';
                    ?>
                    <div id='property-thumbnail-preview-wrapper' style="background-image: url('<?php echo esc_url($thumbnail_url != NULL ? $thumbnail_url : $thumbnail_placeholder); ?>'); ">
                    </div>
                    <input id="upload_property_thumbnail" type="button" class="button form-control" value="<?php esc_attr_e( 'Upload Property Thumbnail', 'luxus-core' ); ?>"/>
                    <input type="hidden" name="property_thumbnail_id" id="property_thumbnail_id" value="<?php echo esc_attr($property_thumbnail); ?>">
                </div>
                <div class="col-lg-6">
                    <?php

                        $three_placeholder = SL_PLUGIN_URL . 'public/images/user-title-bg.jpg';
                        $three_url = isset($property_panorama['url']) ? $property_panorama['url'] : $three_placeholder;
                        $three_id = isset($property_panorama['id']) ? $property_panorama['id'] : '';
                        $three_width = isset($property_panorama['width']) ? $property_panorama['width'] : '';
                        $three_height = isset($property_panorama['height']) ? $property_panorama['height'] : '';
                        $three_thumbnail = isset($property_panorama['thumbnail']) ? $property_panorama['thumbnail'] : '';
                        $three_alt = isset($property_panorama['alt']) ? $property_panorama['alt'] : '';
                        $three_title = isset($property_panorama['title']) ? $property_panorama['title'] : '';
                        $three_description = isset($property_panorama['description']) ? $property_panorama['description'] : '';
                    ?>
                    <div id='property-three-preview-wrapper' style="background-image: url('<?php echo esc_url($three_url); ?>'); ">
                    </div>
                    <input id="upload_property_three" type="button" class="button form-control" value="<?php _e( 'Upload Property 360 Image' ); ?>"/>
                    <!-- Hidden -->
                    <input type="hidden" name="property_three[url]" id="property_three_url" value="<?php echo esc_attr($three_url); ?>">
                    <input type="hidden" name="property_three[id]" id="property_three_id" value="<?php echo esc_attr($three_id); ?>">
                    <input type="hidden" name="property_three[width]" id="property_three_width" value="<?php echo esc_attr($three_width); ?>">
                    <input type="hidden" name="property_three[height]" id="property_three_height" value="<?php echo esc_attr($three_height); ?>">
                    <input type="hidden" name="property_three[thumbnail]" id="property_three_thumbnail" value="<?php echo esc_attr($three_thumbnail); ?>">
                    <input type="hidden" name="property_three[alt]" id="property_three_alt" value="<?php echo esc_attr($three_alt); ?>">
                    <input type="hidden" name="property_three[title]" id="property_three_title" value="<?php echo esc_attr($three_title); ?>">
                    <input type="hidden" name="property_three[description]" id="property_three_description" value="<?php echo esc_attr($three_description); ?>">
                </div>
                <div class="col-lg-12">
                    <div id="property_images">
                    <?php
                    $gallery_ids = explode( ',', $property_gallery_imgs );

                    if ( ! empty( $gallery_ids ) ) :
                        foreach ( $gallery_ids as $gallery_item_id ) :
                        $image_src = wp_get_attachment_image_src( $gallery_item_id , 'full' );
                    ?>
                        <div class="property_images_preview">
                            <span class="removebtn">X</span>
                            <img src="<?php echo esc_url($image_src[0]); ?>">
                            <input id="property_images_ids_<?php echo esc_attr($gallery_item_id); ?>" type="hidden" name="property_images_ids[]" value="<?php echo esc_attr($gallery_item_id); ?>">
                        </div>
                    <?php 
                        endforeach;
					endif;
                    ?>
                    </div>
                </div>
                <div class="col-lg-12">
                    <input type="button" class="form-control" name="upload_property_images"  id="upload_property_images" value="<?php esc_attr_e('Upload Property Images', 'luxus-core'); ?>"/>
                </div>
            </div>
            <div class="row sl-box">
                <div class="col-lg-12">
                    <h6 class="heading"><?php esc_html_e('Property Address', 'luxus-core'); ?></h6>
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="address"><?php esc_html_e('Street Address', 'luxus-core'); ?></label>
                            <input type="text" class="form-control" name="address" value="<?php echo esc_attr($property_street); ?>" id="address">
                        </div>
                        <div class="col-lg-4">
                            <?php

                            //Property City Taxonomy
                            $property_cities = get_terms( array( 'taxonomy' => 'property_city', 'hide_empty' => false ) );

                            // Getting Post Taxonomy BY ID
    						$post_property_city = get_the_terms( $post_id, 'property_city' );

                            $property_city_id = !empty($post_property_city) ? $post_property_city[0]->term_id : NULL;

                            ?>
                            <label for="city"><?php esc_html_e('City', 'luxus-core'); ?></label>
                            <select name="city" class="form-control"  id="city">
                                    <option value="none"><?php esc_html_e('Select City', 'luxus-core'); ?></option>
                                <?php
                                    if( $property_cities != NULL ):
                                        foreach($property_cities as $city) { ?>
                                    <option <?php echo esc_attr($property_city_id == $city->term_id ? 'selected' : ''); ?> value="<?php echo esc_attr($city->term_id); ?>"><?php echo esc_html($city->name); ?></option>
                                    <?php } else: ?>
                                    <option value="none"><?php esc_html_e('None', 'luxus-core'); ?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-lg-4">

                            <?php

                            //Property Province Taxonomy
                            $property_states = get_terms( array( 'taxonomy' => 'property_province', 'hide_empty' => false ) );

                            // Getting Post Taxonomy BY ID
                            $post_property_state = get_the_terms( $post_id, 'property_province' );

                            $property_state_id = !empty($post_property_state) ? $post_property_state[0]->term_id : NULL;

                            ?>
                            <label for="state"><?php esc_html_e('State / Province', 'luxus-core'); ?></label>
                            <select name="state" class="form-control"  id="state">
                                <option value="none"><?php esc_html_e('Select State/Province', 'luxus-core'); ?></option>
                                <?php
                                if( $property_states != NULL ):
                                    foreach($property_states as $state) { ?>
                                <option <?php echo esc_attr($property_state_id == $state->term_id ? 'selected' : ''); ?> value="<?php echo esc_attr($state->term_id); ?>"><?php echo esc_html($state->name); ?></option>
                                <?php } else: ?>
                                <option value="none"><?php esc_html_e('None', 'luxus-core'); ?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="zip"><?php esc_html_e('Zip / Postal Code', 'luxus-core'); ?></label>
                            <input type="text" class="form-control" name="zip" value="<?php echo esc_attr($property_zip_code); ?>" id="zip">
                        </div>
                        <div class="col-lg-4">
                            <label for="nearby"><?php esc_html_e('Near By', 'luxus-core'); ?></label>
                            <input type="text" class="form-control" name="nearby" value="<?php echo esc_attr($property_nearby); ?>" id="nearby">
                        </div>
                        <div class="col-lg-4">
                            <?php
                            //Property Country Taxonomy
                            $property_countries = get_terms( array( 'taxonomy' => 'property_country', 'hide_empty' => false ) );
                            // Getting Post Taxonomy BY ID
    						$post_property_country = get_the_terms( $post_id, 'property_country' );
                            $property_country_id = !empty($post_property_country) ? $post_property_country[0]->term_id : NULL;
                            ?>
                            <label for="country"><?php esc_html_e('Country', 'luxus-core'); ?></label>
                            <select name="country" class="form-control"  id="country">
                                    <option value="none"><?php esc_html_e('Select Country', 'luxus-core'); ?></option>
                                <?php
                                    if( $property_countries != NULL ):
                                        foreach($property_countries as $country) { ?>
                                    <option <?php echo esc_attr($property_country_id == $country->term_id ? 'selected' : ''); ?> value="<?php echo esc_attr($country->term_id); ?>"><?php echo esc_html($country->name); ?></option>
                                    <?php } else: ?>
                                    <option value="none"><?php esc_html_e('None', 'luxus-core'); ?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row sl-box">
                <div class="col-lg-12">
                    <h6 class="heading"><?php esc_html_e('Property Map', 'luxus-core'); ?></h6>
                </div>
                <div class="col-lg-12 edit-property-map">
                    <div id="map"></div>
                    <input type="hidden" name="property_map[address]" id="st_address" value="<?php echo esc_attr($map_address); ?>" /> 
                    <input type="hidden" name="property_map[latitude]" id="lat" value="<?php echo esc_attr($map_latitude); ?>" /> 
                    <input type="hidden" name="property_map[longitude]" id="lng" value="<?php echo esc_attr($map_longitude); ?>" />
                    <input type="hidden" name="property_map[zoom]" id="zoom" value="<?php echo esc_attr($map_zoom); ?>" />
                </div>
            </div>

            <?php if( $remaining_posts < 0 ): ?>
                <div class="row sl-box">
                    <div class="col-xl-12">
                        <div class="alert-message alert-message-info alert-error">
                            <h6><?php esc_html_e('Your can not edit this property.', 'luxus-core'); ?></h6>
                            <p><?php esc_html_e('To Edit Property Please Upgrade Package', 'luxus-core'); ?></p>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="row sl-box">
                    <div class="col-lg-12">
                        <button type="submit" id="update-property" class="sl-btn-fill"><?php esc_html_e('Update Property', 'luxus-core'); ?></button>
                        <?php wp_nonce_field( "edit_property_action", "edit_property_nonce" ); ?>
                        <input name="action" type="hidden" id="action" value="edit-property" />
                    </div>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>
<!-- Main Content End -->

<?php
// getting Values From Meta

$Latitude_meta = $property_map_meta['latitude'];
$Longtitude_meta = $property_map_meta['longitude'];
$Latitude = ( $Latitude_meta != NULL ? $Latitude_meta : 0 );
$Longtitude = ( $Longtitude_meta != NULL ? $Longtitude_meta : 0 );
$featured_posts_days = ( !$featured_posts_duration == null ? $featured_posts_duration : 0 ) ;

// Edit Property Script
wp_register_script( 'luxus-edit-property', '', array("jquery"), '', true );
wp_enqueue_script( 'luxus-edit-property'  );

wp_add_inline_script( 'luxus-edit-property', "

    jQuery( document ).ready( function( $ ) {

        // Property Map //

        // Lat Long
        var markerLocation = [{$Latitude}, {$Longtitude}];
        // Zoom Level
        var mapZoom = 6;

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

        // Change Property Label //

        jQuery('#property_label').on('change', function(){

            // Change Value Of Featured ChexkBox
            jQuery('#property_label').val(this.checked ? 1 : 0);

            // Update Featured Post Expiry Date
            var today = new Date(); //Today's Date
            var numberOfDaysToAdd = '{$featured_posts_days}'; //number of days to add.

            requiredDate = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 1 + numberOfDaysToAdd); // YYYY-MM-DD
            var expiry_date = requiredDate.toISOString().substr(0,10); // Formate Date

            if(jQuery('#property_label').is(':checked')) { 
                jQuery('#expiry_date').val(expiry_date);
            } else {
                jQuery('#expiry_date').val('');
            }

        });

    });

");

// Custom user Footer
require dirname( __FILE__ ) . '/template-parts/footer-user.php';
