<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * The template for displaying all single posts of 'agent post type'
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package luxus
 */

get_header();

global $wpdb;

// Get options
$is_active_sidebar = ( is_active_sidebar( 'agent-pages-widget' ) ? true : false );
$sidebar_position = luxus_options('agent-single-sidebar-position');
$agent_enable_address = luxus_options('agent-enable-address');
$agent_enable_map = luxus_options('agent-enable-map');

$agent = get_user_by('slug', get_query_var('author_name'));

// Agent Meta Boxes
$agent_id = $agent->ID;
$agent_name = $agent->first_name .' '. $agent->last_name ;
$agent_email = $agent->user_email;
$agent_phone = $agent->luxus_user_phone;
$agent_fax = $agent->luxus_user_fax;
$agent_mobile = $agent->luxus_user_mobile;
$agent_website = $agent->user_url;
$agent_licence = $agent->luxus_user_licence;
$agent_tax_number = $agent->luxus_user_tax;
$agent_position = $agent->luxus_user_designation;
$agent_description = $agent->description;

$agent_street = $agent->luxus_user_address_one . (!empty($agent->luxus_user_address_two) ? ' ' . $agent->luxus_user_address_two : '');
$agent_city = $agent->luxus_user_city;
$agent_state = $agent->luxus_user_state;
$agent_zip_code = $agent->luxus_user_postcode;
$agent_country = $agent->luxus_user_country;
$agent_address = ( !empty( $agent_street ) ? $agent_street . ', ' : null ) . ( isset( $agent_city ) ? $agent_city . ', ' : null ) . ( !empty( $agent_zip_code ) ? $agent_zip_code . ', ' : null ) . ( isset( $agent_state ) ? luxus_state_name($agent_state) . ', ' : null ) . ( isset( $agent_country ) ? luxus_country_name($agent_country) : null );

// Social
$social_icons = array();

if (!empty($agent->luxus_user_facebook)) {
    $social_icons['fa-facebook-f'] = $agent->luxus_user_facebook;
}
if (!empty($agent->luxus_user_instagram)) {
    $social_icons['fa-instagram'] = $agent->luxus_user_instagram;
}
if (!empty($agent->luxus_user_twitter)) {
    $social_icons['fa-twitter'] = $agent->luxus_user_twitter;
}
if (!empty($agent->luxus_user_linkedin)) {
    $social_icons['fa-linkedin-in'] = $agent->luxus_user_linkedin;
}
if (!empty($agent->luxus_user_pinterest)) {
    $social_icons['fa-pinterest-p'] = $agent->luxus_user_pinterest;
}
if (!empty($agent->luxus_user_youtube)) {
    $social_icons['fa-youtube'] = $agent->luxus_user_youtube;
}

// Agent Image
$agent_pic = get_user_meta( $agent->ID, 'luxus_user_profile_img', true );
$img_placeholder = SL_PLUGIN_URL . 'public/images/agent-profile.jpg';
$agent_pic_url = !empty($agent_pic['url']) ? $agent_pic['url'] : $img_placeholder;

// Map Meta
if ( $agent_enable_map == true ){

    $agent_map = get_user_meta( $agent->ID, 'luxus_user_map', true );
}

// Page Meta
$thumbnail = get_the_post_thumbnail_url(get_the_ID(),'full');
$agent_title_bg = luxus_options('agent-single-title-bg');
$background_gradient_direction = $agent_title_bg['background-gradient-direction'];
$background_color = $agent_title_bg['background-color'];
$background_gradient_color = $agent_title_bg['background-gradient-color'];
$title_background = !empty( $thumbnail ) ? 'background-image: linear-gradient('.$background_gradient_direction.','.$background_color.','.$background_gradient_color.'), url('.$thumbnail.');' : null;

// Contact Form 7 Schedule Tour Form
$current_user_id = $current_user->ID;
$current_user_name = $current_user->display_name;
$current_user_email = $current_user->user_email;

luxus_set_user_view( $agent->ID );

?>

<div class="agent-single-page-header" style="<?php echo esc_attr($title_background); ?>">
    <div class="container">
        <?php 

            echo '<h2 class="agent-singel-title">'.esc_html($agent_name).'</h2>';

            if ( $agent_enable_address == true ) :

        ?>
        <p class="address">
            <i class="sl-icon sl-place"></i>
            <?php echo esc_html($agent_address); ?>
        </p>
        <?php endif; ?>
    </div>
</div><!-- .page-header -->

<!-- Main Content -->
<div class="page-content agent-single-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                
                <div class="sl-box agent-description">
                    <h6 class="heading"><?php esc_html_e('Agent Detail', 'luxus-core'); ?></h6>
                    <?php echo wpautop($agent_description); ?>
                </div>

                <h6 class="heading"><?php esc_html_e('Properties By', 'luxus-core'); ?> <span><?php echo esc_html($agent_name); ?></span></h6>
                
                <div id="properties">
                    <div class="row">
                        <?php

                            $post_view = luxus_options('agent-single-post-view');
                            $sl_col = ( $post_view == 'grid-view' ? 'col-md-6 col-lg-6' : 'col-md-12 col-lg-12' );
                            $sl_col_item = ( $post_view == 'grid-view' ? 'property-grid' : 'property-list' );

                            $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

                            // the query
                            $properties = new WP_Query( array(
                                'post_type' => 'property',
                                'author' => $agent_id,
                                'posts_per_page' => 6,
                                'paged' => $paged,
                            ));  

                            if ( $properties->have_posts() ) :
                                while ( $properties->have_posts() ) :
                                    $properties->the_post();
                        ?>
                                <div class="sl-col <?php echo $sl_col; ?>">
                                    <div class="sl-item <?php echo $sl_col_item; ?>">
                                        <?php

                                        // Property Template Parts
                                        require dirname( __FILE__ ) . '/template-parts/property-style-one.php';

                                        ?>
                                    </div>
                                 </div>
                            <?php

                                endwhile;

                                    // Custom Pagination
                                    luxus_pagination_bar($properties);

                                else:
                        ?>
                                <div class="col-xl-12">
                                    <div class="alert-message alert-message-info">
                                        <h6><?php esc_html_e('Properties not found.', 'luxus-core'); ?></h6>
                                        <p><?php esc_html_e('Sorry! No Properties added by', 'luxus-core'); ?> <strong><?php echo esc_html($agent_name); ?>.</strong></p>
                                    </div>
                                </div>
                        <?php 

                            endif;

                            wp_reset_postdata();
                        ?>
                    </div>
                </div>

                <!-- Agent Map -->
                <?php
                if ( $agent_enable_map == true ) :

                    echo '<div class="agent-map sl-box">';
                        echo '<h6 class="heading">'. __('Agent Location', 'luxus-core') .'</h6>';
                        echo '<div id="agent-map"></div>';
                    echo '</div>';

                endif;
                ?>

            </div>

            <!-- This Class order-xl-first is for float sidebar left -->
            <div class="col-lg-4 sl-sticky <?php echo esc_attr( $sidebar_position == 'left-sidebar' ? 'order-lg-first' : '' ); ?>">

                <div class="sl-box agent-info">
                    <div class="picture">
                        <img src="<?php echo esc_url($agent_pic_url); ?>" alt="<?php esc_attr($agent_name); ?>">
                    </div>
                    <h6 class="name"><?php echo esc_html($agent_name); ?></h6>
                    <div class="contect-info">
                        <ul>
                            <?php if( $agent_email != NULL) : ?>
                                <li><span><?php echo esc_html_e('Email:', 'luxus-core'); ?> </span> <?php echo esc_html($agent_email); ?></li>
                            <?php endif;
                            if( $agent_licence != NULL) : ?>
                                <li><span><?php echo esc_html_e('Licence:', 'luxus-core'); ?> </span> <?php echo esc_html($agent_licence); ?></li>
                            <?php endif;
                            if( $agent_phone != NULL) : ?>
                                <li><span><?php echo esc_html_e('Office:', 'luxus-core'); ?> </span> <?php echo esc_html($agent_phone); ?></li>
                            <?php endif;
                            if( $agent_mobile != NULL) : ?>
                                <li><span><?php echo esc_html_e('Mobile:', 'luxus-core'); ?> </span> <?php echo esc_html($agent_mobile); ?></li>
                            <?php endif;
                            if( $agent_city != NULL) : ?>
                                <li><span><?php echo esc_html_e('Location:', 'luxus-core'); ?> </span> <?php echo esc_html($agent_city); ?></li>
                            <?php endif;
                            if( $agent_website != NULL) : ?>
                                <li><span><?php echo esc_html_e('Url:', 'luxus-core'); ?> </span> <?php echo esc_html($agent_website); ?></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <?php if (!empty($social_icons)): ?>
                    <div class="social">
                        <ul>
                            <?php

                                foreach ( $social_icons as $key => $value ) {
                                  
                                  echo '<li><a href="'.esc_attr($value).'" target="_blank"><i class="fab '.esc_attr($key).'"></i></a></li>';

                               }
                            ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
                <?php 

                // Contact User Form Action
                require dirname( __FILE__ ) . '/template-parts/contact-user-form-action.php';

                ?>
                <div class="sl-box contect-agent">
                    <h6 class="heading"><?php esc_html_e('Contact with', 'luxus-core'); ?> <span><?php echo esc_html($agent_name); ?></span></h6>
                    <div class="contect-form">
                        <form action="" method="post">
                            <input type="hidden" id="reciver_id" name="receiver_id" value="<?php echo esc_attr($agent_id); ?>" />
                            <input type="hidden" id="sender_id" name="sender_id" value="<?php echo esc_attr($current_user_id); ?>" />

                            <?php if( !is_user_logged_in() ) { ?>

                                <input type="text" class="form-control" id="sender_name" placeholder="<?php esc_attr_e('Name', 'luxus-core'); ?>">

                                <input type="text" class="form-control" id="sender_email" placeholder="<?php esc_attr_e('Email', 'luxus-core'); ?>">

                            <?php } else {
                                echo "<p>". __('Logged in as', 'luxus-core') ." <strong>". esc_html($current_user_name) ."</strong></p>";
                            } ?>

                            <input type="text" class="form-control" id="sender_phone" name="sender_phone" value="<?php echo esc_attr( isset( $_POST['sender_phone'] ) ? $sender_phone : null ) ?>" placeholder="<?php esc_attr_e('Phone', 'luxus-core'); ?>">

                            <textarea class="form-control" id="sender_message" name="sender_message" value="<?php echo esc_attr( isset( $_POST['sender_message'] ) ? $sender_message : null ) ?>"placeholder="<?php esc_attr_e('Message', 'luxus-core'); ?>"><?php echo esc_html( isset( $_POST['sender_message'] ) ? $sender_message : null ) ?></textarea>

                            <?php if( !is_user_logged_in() ) {

                                echo "<a href='' class='sl-ajax-login sl-btn-fill'>". __('Send Message', 'luxus-core') ."</a>";

                            } else { ?>
                                
                                <button type="submit" class="sl-btn-fill"><?php esc_html_e('Send Message', 'luxus-core'); ?></button>
                                <?php wp_nonce_field( "user_message_action", "user_message_nonce" ); ?>
                                <input type="hidden" id="send_message_action" name="send_message_action" value="send-message" />

                            <?php } ?>
                        </form>
                        <?php
                            // Print Errors
                            if ( is_wp_error( $contact_user_error ) ) {
                                echo '<div class="agent-errors">';
                                    foreach ( $contact_user_error->get_error_messages() as $error ) {
                                        echo '<strong class="text-danger">'. __('Error:', 'luxus-core') .' </strong>' . $error . '<br/>';
                                    }
                                echo '</div>';
                            }
                        ?>
                    </div>
                </div>

                <!-- Contact User Succes Alert -->
                <?php

                if ( !empty($contact_user_msg_alert) && $contact_user_msg_alert == 'success' ) :
                    echo '<script type="text/javascript">toastr.success("'. __('Message Sent Successfully.', 'luxus-core') .'");</script>';
                endif;

                // Contact User Failed Alert
                if ( !empty($contact_user_msg_alert) && $contact_user_msg_alert == 'failed' ) :
                     echo '<script type="text/javascript">toastr.error("'. __('Message Sent Failed!', 'luxus-core') .'");</script>';
                endif;

                if( $is_active_sidebar == true ) : ?>
                <aside id="secondary" class="widget-area">
                    <?php dynamic_sidebar( 'agent-pages-widget' ); ?>
                </aside><!-- #secondary -->
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>
<!-- Main Content End -->

<?php if ( $agent_enable_map == true ) {

    // getting Values From Meta
    $latitude = isset( $agent_map['latitude'] ) ? $agent_map['latitude'] : 0 ;
    $longtitude = isset( $agent_map['longitude'] ) ? $agent_map['longitude'] : 0 ;
    $zoom = 11;
    $map_marker = SL_PLUGIN_URL . 'public/images/map-pin.png';

    // Agent Map Script
    wp_register_script( 'luxus-agent-map', '', array("jquery"), '', true );
    wp_enqueue_script( 'luxus-agent-map'  );

    wp_add_inline_script( 'luxus-agent-map', "

        jQuery( document ).ready( function( $ ) {

            var markerLocation = [{$latitude}, {$longtitude}];

            var map = L.map('agent-map', {
                center: markerLocation,
                zoom: {$zoom},
                scrollWheelZoom: false,
                'layers': [
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href=\"https://osm.org/copyright\">OpenStreetMap</a> contributors'
                    })
                ]
            });

            map.attributionControl.setPrefix(false);

            // create custom icon
            var mapMarker = L.icon({
                iconUrl: '{$map_marker}',
                iconSize: [40, 48], // size of the icon
            });

            var marker = new L.marker(markerLocation, {
                icon: mapMarker,
                draggable: false
            }).bindPopup('{$agent_address}').openPopup();

            marker.addTo(map);

        });
    ");

}

get_footer();