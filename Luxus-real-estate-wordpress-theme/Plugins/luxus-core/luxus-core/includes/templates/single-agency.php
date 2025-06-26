<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * The template for displaying all single posts of 'agency post type'
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package luxus
 */

get_header();

global $wpdb;

// Get options
$is_active_sidebar = ( is_active_sidebar( 'agency-pages-widget' ) ? true : false );
$active_col = ( $is_active_sidebar == true ? '8' : '12' );
$sidebar_position = luxus_options('agency-single-sidebar-position');
$agency_enable_address = luxus_options('agency-enable-address');
$agency_enable_map = luxus_options('agency-enable-map');

$agency = get_user_by('slug', get_query_var('author_name'));

// Agency Meta
$agency_id = $agency->ID;
$agency_name = $agency->first_name .' '. $agency->last_name;
$agency_email = $agency->user_email;
$agency_phone = $agency->luxus_user_phone;
$agency_fax = $agency->luxus_user_fax;
$agency_mobile = $agency->luxus_user_mobile;
$agency_website = $agency->user_url;
$agency_licence = $agency->luxus_user_licence;
$agency_tax_number = $agency->luxus_user_tax;
$agency_position = $agency->luxus_user_designation;
$agency_description = $agency->description;
$agency_agents = $agency->luxus_user_agents;

$agency_street = $agency->luxus_user_address_one . (!empty($agency->luxus_user_address_two) ? ' ' . $agency->luxus_user_address_two : '');
$agency_city = $agency->luxus_user_city;
$agency_state = $agency->luxus_user_state;
$agency_zip_code = $agency->luxus_user_postcode;
$agency_country = $agency->luxus_user_country;
$agency_address = ( !empty( $agency_street ) ? $agency_street . ', ' : null ) . ( isset( $agency_city ) ? $agency_city . ', ' : null ) . ( !empty( $agency_zip_code ) ? $agency_zip_code . ', ' : null ) . ( isset( $agency_state ) ? luxus_state_name($agency_state) . ', ' : null ) . ( isset( $agency_country ) ? luxus_country_name($agency_country) : null );

// Social
$social_icons = array();

if (!empty($agency->luxus_user_facebook)) {
    $social_icons['fa-facebook-f'] = $agency->luxus_user_facebook;
}
if (!empty($agency->luxus_user_instagram)) {
    $social_icons['fa-instagram'] = $agency->luxus_user_instagram;
}
if (!empty($agency->luxus_user_twitter)) {
    $social_icons['fa-twitter'] = $agency->luxus_user_twitter;
}
if (!empty($agency->luxus_user_linkedin)) {
    $social_icons['fa-linkedin-in'] = $agency->luxus_user_linkedin;
}
if (!empty($agency->luxus_user_pinterest)) {
    $social_icons['fa-pinterest-p'] = $agency->luxus_user_pinterest;
}
if (!empty($agency->luxus_user_youtube)) {
    $social_icons['fa-youtube'] = $agency->luxus_user_youtube;
}

// Agency Image
$agency_pic = get_user_meta( $agency->ID, 'luxus_user_profile_img', true );
$img_placeholder = SL_PLUGIN_URL . 'public/images/agency-profile.jpg';
$agency_pic_url = !empty($agency_pic['url']) ? $agency_pic['url'] : $img_placeholder;

// Map Meta
if ( $agency_enable_map == true ){

    $agency_map = get_user_meta( $agency->ID, 'luxus_user_map', true );
}

// Page Meta
$thumbnail = get_the_post_thumbnail_url(get_the_ID(),'full');
$agency_title_bg = luxus_options('agency-single-title-bg');
$background_gradient_direction = $agency_title_bg['background-gradient-direction'];
$background_color = $agency_title_bg['background-color'];
$background_gradient_color = $agency_title_bg['background-gradient-color'];
$title_background = !empty( $thumbnail ) ? 'background-image: linear-gradient('.$background_gradient_direction.','.$background_color.','.$background_gradient_color.'), url('.$thumbnail.');' : null;

// Contact Form Schedule Tour Form
$current_user = wp_get_current_user();
$current_user_id = $current_user->ID;
$current_user_name = $current_user->display_name;
$current_user_email = $current_user->user_email;

luxus_set_user_view( $agency->ID );

?>

<div class="agency-single-page-header" style="<?php echo esc_attr($title_background); ?>">
    <div class="container">

        <?php

        echo '<div class="title-left">';

        echo '<h2 class="agency-singel-title">'.esc_html($agency_name).'</h2>';

        if ($agency_enable_address == true ) :

        ?>
        <p class="address">
            <i class="sl-icon sl-place"></i>
            <?php echo esc_html($agency_address); ?>
        </p>
        <?php

        endif;

        echo '</div>';

        ?>
    </div>
</div><!-- .page-header -->

<!-- Main Content -->
<div class="page-content agency-single-content">
    <div class="container">
        <div class="sl-box agency-info">
            <div class="row">
                <div class="col-lg-4">
                    <div class="agency-img" style="background-image: url('<?php echo esc_url($agency_pic_url); ?>');">
                    </div>
                </div>
                <div class="col-lg-4">
                    <h6 class="heading"><?php esc_html_e('Contact Information', 'luxus-core'); ?></h6>
                    <div class="agency-contect-info">
                        <ul>
                            <?php if( $agency_mobile != NULL): ?>
                                <li><i class="sl-icon sl-phone-o"></i> <?php echo esc_html($agency_mobile); ?></li>
                            <?php endif;
                            if( $agency_phone != NULL): ?>
                                <li><i class="sl-icon sl-phone-t"></i> <?php echo esc_html($agency_phone); ?></li>
                            <?php endif;
                            if( $agency_fax != NULL): ?>
                                <li><i class="sl-icon sl-fax"></i> <?php echo esc_html($agency_fax); ?></li>
                            <?php endif;
                            if( $agency_email != NULL): ?>
                                <li><i class="sl-icon sl-mail-o"></i> <?php echo esc_html($agency_email); ?></li>
                            <?php endif;
                            if( $agency_website != NULL): ?>
                                <li><i class="sl-icon sl-world"></i> <?php echo esc_html($agency_website); ?></li>
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
                <div class="col-lg-4">
                    <div class="contact-agency">
                        <form action="" method="post">
                            <input type="hidden" id="reciver_id" name="receiver_id" value="<?php echo esc_attr($agency_id); ?>" />
                            <input type="hidden" id="sender_id" name="sender_id" value="<?php echo esc_attr($current_user_id); ?>" />

                            <?php if( !is_user_logged_in() ) { ?>

                                <input type="text" class="form-control" id="sender_name" placeholder="<?php esc_attr_e('Name', 'luxus-core'); ?>">

                                <input type="text" class="form-control" id="sender_email" placeholder="<?php esc_attr_e('Email', 'luxus-core'); ?>">

                            <?php } else {
                                echo '<h6 class="heading">'. __('Logged in as', 'luxus-core') .' <span>'. esc_html($current_user_name) .'</span></h6>';

                                ?>
                                <input type="text" class="form-control" id="sender_phone" name="sender_phone" value="<?php echo esc_attr( isset( $_POST['sender_phone'] ) ? $sender_phone : null ) ?>" placeholder="<?php esc_attr_e('Phone', 'luxus-core'); ?>">
                            <?php } ?>

                            <textarea class="form-control" id="sender_message" name="sender_message" value="<?php echo esc_attr( isset( $_POST['sender_message'] ) ? $sender_message : null ) ?>"placeholder="<?php esc_attr_e('Message', 'luxus-core'); ?>"><?php echo esc_html( isset( $_POST['sender_message'] ) ? $sender_message : null ) ?></textarea>

                            <?php if( !is_user_logged_in() ) {

                                echo "<a href='' class='sl-ajax-login sl-btn-fill'>". __('Send Message', 'luxus-core') ."</a>";

                            } else { ?>
                                
                                <button type="submit" class="sl-btn-fill"><?php esc_html_e('Contact with', 'luxus-core'); ?></button>
                                <?php wp_nonce_field( "user_message_action", "user_message_nonce" ); ?>
                                <input type="hidden" id="send_message_action" name="send_message_action" value="send-message" />

                            <?php } ?>
                        </form>
                        <?php
                            // Print Errors
                            if ( is_wp_error( $contact_user_error ) ) {
                                echo '<div class="agency-errors">';
                                    foreach ( $contact_user_error->get_error_messages() as $error ) {
                                        echo '<strong class="text-danger">'. __('Error: ') .'</strong>' . $error . '<br/>';
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

                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-<?php echo esc_attr($active_col); ?>">

                <!-- Agency Detail -->
                <div id="overview" class="sl-box">
                    <h6 class="heading"><?php esc_html_e('Agency Detail', 'luxus-core'); ?></h6>
                    <?php echo wpautop($agency_description); ?>
                </div>

                <!-- Agency Agents -->
                <h6 class="heading"><?php esc_html_e('Our Agents', 'luxus-core'); ?></h6>
                <div id="agents">
                    <div class="row">
                        <?php

                        if ( !$agency_agents == null ) {

                            // WP_User_Query arguments
                            $args = array (
                                'include' => $agency_agents,
                                'role' => 'agent',
                                'order' => 'ASC',
                                'number' => 24, 
                            );

                            // Create the WP_User_Query object
                            $agents_query = new WP_User_Query($args);

                            // Get the results
                            $agents = $agents_query->get_results();

                            $agents_count = count($agents);

                            // Check for results
                            if ( !empty($agency_agents) && $agents_count > 0 ) {

                                // loop through each users
                                foreach ( $agents as $agent ) {

                                    $sl_col = $is_active_sidebar ? 'col-lg-6 col-md-6' : 'col-lg-4 col-md-6';

                                    // Agent Template Parts
                                    require dirname( __FILE__ ) . '/template-parts/agent-style-one.php';
                                }

                            } else {

                            ?>
                                <div class="col-xl-12">
                                    <div class="alert-message alert-message-info">
                                        <h6><?php esc_html_e('Agents not found.', 'luxus-core'); ?></h6>
                                        <p><?php esc_html_e('Sorry! No Agents added by', 'luxus-core'); ?> <strong><?php echo esc_html($agency_name); ?>.</strong></p>
                                    </div>
                                </div>

                            <?php

                            }
                                wp_reset_postdata();

                        }

                        ?>
                    </div>
                </div>

                <!-- Agency Properties -->
                <h6 class="heading"><?php esc_html_e('Properties By', 'luxus-core'); ?> <span><?php echo esc_html($agency_name); ?></span></h6>
                <div id="properties">
                    <div class="row">
                        <?php

                            $post_view = luxus_options('agency-single-post-view');

                            if ($is_active_sidebar) {
                                $sl_prop_col = ( $post_view == 'grid-view' ? 'col-md-6 col-lg-6' : 'col-md-12 col-lg-12' );
                            } else {
                                $sl_prop_col = ( $post_view == 'grid-view' ? 'col-md-6 col-lg-4' : 'col-md-12 col-lg-12' );
                            }
                            
                            $sl_prop_col_item = ( $post_view == 'grid-view' ? 'property-grid' : 'property-list' );

                            $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

                            $current_agency_id = array( $agency_id );
                            $agency_agents_ids = !empty($agency_agents) ? $agency_agents : array();
                            
                            $author_in_ids = array_merge( $current_agency_id, $agency_agents_ids );

                            // the query
                            $properties = new WP_Query( array(
                                'author__in'=> $author_in_ids,
                                'post_type' => 'property',
                                'posts_per_page' => 12,
                                'paged' => $paged
                            ));

                            if ( $properties->have_posts() ) :
                                while ( $properties->have_posts() ) :
                                    $properties->the_post();
                        ?>
                                    <div class="sl-col <?php echo esc_attr($sl_prop_col); ?>">
                                        <div class="sl-item <?php echo esc_attr($sl_prop_col_item); ?>">
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

                                else :
                            ?>
                                <div class="col-xl-12">
                                    <div class="alert-message alert-message-info">
                                        <h6><?php esc_html_e('Properties not found.', 'luxus-core'); ?></h6>
                                        <p><?php esc_html_e('Sorry! No Properties added by', 'luxus-core'); ?> <strong><?php echo esc_html($agency_name); ?>.</strong></p>
                                    </div>
                                </div>
                        <?php 

                            endif;

                            wp_reset_postdata();
                        ?>
                    </div>
                </div>

                <!-- Agency Map -->
                <?php
                if ( $agency_enable_map == true ) :

                    echo '<div class="agency-map sl-box">';
                        echo '<h6 class="heading">'. __('Agency Location', 'luxus-core') .'</h6>';
                        echo '<div id="agency-map"></div>';
                    echo '</div>';

                endif;
                ?>

            </div>

            <?php if( $is_active_sidebar == true ) : ?>
            <!-- This Class order-xl-first is for float sidebar left -->
            <div class="col-lg-4 sl-sticky <?php echo esc_attr( $sidebar_position == 'left-sidebar' ? 'order-lg-first' : '' ); ?>">
                <aside id="secondary" class="widget-area">
                    <?php dynamic_sidebar( 'agency-pages-widget' ); ?>
                </aside><!-- #secondary -->
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- Main Content End -->

<?php if ( $agency_enable_map == true ){

    // getting Values From Meta
    $latitude = isset( $agency_map['latitude'] ) ? $agency_map['latitude'] : 0 ;
    $longtitude = isset( $agency_map['longitude'] ) ? $agency_map['longitude'] : 0 ;
    $zoom = 11;
    $map_marker = SL_PLUGIN_URL . 'public/images/map-pin.png';

    // Agent Map Script
    wp_register_script( 'luxus-agency-map', '', array("jquery"), '', true );
    wp_enqueue_script( 'luxus-agency-map'  );

    wp_add_inline_script( 'luxus-agency-map', "

        jQuery( document ).ready( function( $ ) {

            var markerLocation = [{$latitude}, {$longtitude}];

            var map = L.map('agency-map', {
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
            }).bindPopup('{$agency_address}').openPopup();

            marker.addTo(map);

        });
    ");

}

get_footer();