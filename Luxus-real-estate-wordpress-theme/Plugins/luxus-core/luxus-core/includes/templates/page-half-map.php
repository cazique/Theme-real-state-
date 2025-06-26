<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * Template Name: Half Map
 */

get_header();

// 'gmap' or 'osmap'
$half_map_opt = ( !empty( luxus_options('half-map-map') ) ? luxus_options('half-map-map') : 'osmap');

$opt_map_api = luxus_options('sl-map-api');
$sl_map_api = ( !empty( $opt_map_api ) ? $opt_map_api : 'AIzaSyDyDdOsUkUKONAziAAoIBJgqVo4_uvYY1E' );

$opt_map_lat = luxus_options('half-map-lat');
$latitude = ( !empty( $opt_map_lat ) ? $opt_map_lat : 30.277762 );

$opt_map_lng = luxus_options('half-map-lng');
$longtitude = ( !empty( $opt_map_lng ) ? $opt_map_lng : 66.5421775 );

$opt_map_zoom = luxus_options('half-map-zoom');
$zoom = ( !empty( $opt_map_zoom ) ? $opt_map_zoom : 5 );

$opt_marker_img = luxus_options('half-map-marker');
$marker_img_pholder = SL_PLUGIN_URL . 'public/images/map-pin.png';
$marker_img = ( !empty( $opt_marker_img ) ? $opt_marker_img['thumbnail'] : $marker_img_pholder );

$opt_marker_width = luxus_options('marker-img-width');
$marker_width = ( !empty( $opt_marker_width ) ? $opt_marker_width : 40 );

$opt_marker_height = luxus_options('marker-img-height');
$marker_height = ( !empty( $opt_marker_height ) ? $opt_marker_height : 40 );

$opt_posts_per_page = luxus_options('half-map-properties-show');
$posts_per_page = ( !empty( $opt_posts_per_page ) ? $opt_posts_per_page : 12 );

$map_possition = ( !empty( luxus_options('half-map-possition') ) ? luxus_options('half-map-possition') : 'right' );
$map_show_mobile = ( !empty( luxus_options('half-map-show-mobile') ) ? luxus_options('half-map-show-mobile') : 'yes' );

if ( $half_map_opt == 'gmap' ) {

    wp_enqueue_script( 'markerclusterer', SL_PLUGIN_URL . 'public/js/markerclusterer.min.js', array(), '', true );

    // Google Map Cluster Icons
    $m1 = SL_PLUGIN_URL . 'public/images/m1.png';
    $m2 = SL_PLUGIN_URL . 'public/images/m2.png';
    $m3 = SL_PLUGIN_URL . 'public/images/m3.png';
    $m4 = SL_PLUGIN_URL . 'public/images/m4.png';
    $m5 = SL_PLUGIN_URL . 'public/images/m5.png';

}

require dirname( __FILE__ ) . '/template-parts/property-sorting.php';

?>

<!-- Main Content -->
<div class="container-fluid halfmap-page-content">
    <div class="row">
        <div class="col-xl-6 col-lg-7 half-map-posts">
            <div class="half-map-search">
                <?php

                    require dirname( __FILE__ ) . '/template-parts/search-half-map.php';
                ?>
            </div>
            <div  class="filter-properties">
                <!-- List View / Grid View -->
                <div class="list-grid-view">
                    <a href="#" id="grid"><i class="sl-icon sl-grid-view"></i></a>
                    <a href="#" id="list"><i class="sl-icon sl-list-view"></i></a>
                </div>
                <!-- Save Search -->
                <?php

                    $save_searches_allow = luxus_options('enable-save-search');

                    if( isset( $_POST['save_search'] ) ) {
                        $save_search = $_POST['save_search'];
                    }
                    else {
                       $save_search = null;    
                    }

                    if ( $save_searches_allow && !$save_search == null ){
                        require dirname( __FILE__ ) . '/template-parts/save-search.php';
                    }

                ?>
                <div class="sort-by">
                    <form id="set_sort_filter" action="" method="get" novalidate="novalidate">
                        <div class="sl-select">
                            <select name="sort_by" class="sort-by-select form-control col-md-12 ">
                                <option value="default"><?php esc_html_e('Default Order', 'luxus-core'); ?></option>         
                                <option value="low_high" <?php echo esc_attr($sort_by == 'low_high' ? 'selected' : ''); ?> ><?php esc_html_e('Price (Low to Hight)', 'luxus-core'); ?></option>         
                                <option value="high_low" <?php echo esc_attr($sort_by == 'high_low' ? 'selected' : ''); ?> ><?php esc_html_e('Price (High to Low)', 'luxus-core'); ?></option>
                                <option value="new" <?php echo esc_attr($sort_by == 'new' ? 'selected' : ''); ?> ><?php esc_html_e('Date Old to New', 'luxus-core'); ?></option>       
                                <option value="old" <?php echo esc_attr($sort_by == 'old' ? 'selected' : ''); ?> ><?php esc_html_e('Date New to Old', 'luxus-core'); ?></option>       
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div id="properties">
                <div class="row">
                    <?php

                    $sl_properties_data = [];
                    $sl_counter     = 0;

                    $post_view = luxus_options('half-map-properties-post-view');
                    $sl_col = ( $post_view == 'grid-view' ? 'col-md-6 col-lg-6' : 'col-md-12 col-lg-12' );
                    $sl_col_item = ( $post_view == 'grid-view' ? 'property-grid' : 'property-list' );

                    $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
                    
                    // the query
                    $properties = new WP_Query( array(
                        'post_type' => 'property',
                        'post_status' => 'publish',
                        'posts_per_page' => $posts_per_page,
                        's' => $search_title,
                        'meta_query' => $meta_query,
                        'tax_query' => $tax_query,
                        'meta_key' => $meta_key, 
                        'orderby' => $order_by,
                        'order' => $order, 
                        'paged' => $paged,
                    ));

                    if ( $properties->have_posts() ) :
                        while ( $properties->have_posts() ) :
                            $properties->the_post();

                            $property_map = luxus_post_meta( '_property_map' );
                            $property_lat = isset($property_map['latitude']) ? $property_map['latitude'] : NULL;
                            $property_lng = isset($property_map['longitude']) ? $property_map['longitude'] : NULL;

                            $index = $properties->current_post;
                    ?>
                            <div class="sl-col <?php echo esc_attr($sl_col); ?>">
                                <div class="property-inner" data-lat="<?php echo esc_attr($property_lat);?>" data-lng="<?php echo esc_attr($property_lng);?>" data-index="<?php echo esc_attr($index); ?>">
                                    <div class="sl-item <?php echo $sl_col_item; ?>">
                                    <?php

                                        // Property Template Parts
                                        require dirname( __FILE__ ) . '/template-parts/property-map.php';

                                    ?>
                                    </div>
                                </div>
                            </div>

                    <?php

                        // Map Properties Array
                        $sl_property_data['post_index'] = $index;
                        $sl_property_data['post_id'] = get_the_ID();
                        $sl_property_data['link'] = get_post_permalink();
                        $sl_property_data['title'] = $post->post_title;
                        $sl_property_data['type'] = $property_type_name;
                        $sl_property_data['status'] = $property_status_name;
                        $sl_property_data['lat'] = $property_lat;
                        $sl_property_data['lng'] = $property_lng;
                        $sl_property_data['address'] = $property_address;
                        $sl_property_data['bedrooms'] = $property_bedrooms;
                        $sl_property_data['bathrooms'] = $property_bathrooms;
                        $sl_property_data['parking'] = $property_parking;
                        $sl_property_data['author'] = get_the_author();
                        $sl_property_data['date'] = get_the_date();
                        $sl_property_data['image'] = $property_thumb_url;
                        
                        array_push( $sl_properties_data, $sl_property_data );

                        endwhile;

                        ?>

                        <div class="col-lg-12 half-map-pagination">

                            <?php

                                $sl_properties_json = ( !empty( $sl_properties_data ) ? wp_json_encode( $sl_properties_data ) : '' );

                                // Map Settings
                                $half_map_settings['lat'] = $latitude;
                                $half_map_settings['lng'] = $longtitude;
                                $half_map_settings['zoom'] = $zoom;
                                $half_map_settings['iconImg'] = $marker_img;
                                $half_map_settings['iconWidth'] = $marker_width;
                                $half_map_settings['iconHeight'] = $marker_height;

                                if ( $half_map_opt == 'gmap' ) {
                                    $half_map_settings['m1'] = $m1;
                                    $half_map_settings['m2'] = $m2;
                                    $half_map_settings['m3'] = $m3;
                                    $half_map_settings['m4'] = $m4;
                                    $half_map_settings['m5'] = $m5;
                                }

                                $half_map_settings_json = ( !empty( $half_map_settings ) ? wp_json_encode( $half_map_settings ) : '' );

                                // Custom Pagination
                                luxus_pagination_bar( $properties );
                            ?>

                        </div>
                        <?php
                        else :

                        $broken_marker = SL_PLUGIN_URL . 'public/images/map-nothing-found.png';

                        $sl_property_data['post_id'] = 'notFound';
                        $sl_property_data['broken_icon'] = $broken_marker;
                        array_push( $sl_properties_data, $sl_property_data );

                        $sl_properties_json = ( !empty( $sl_properties_data ) ? wp_json_encode( $sl_properties_data ) : '' );

                        $nothing_found_img = SL_PLUGIN_URL . 'public/images/nothing-found.png';
                    ?>
                        <div class="col-lg-12 content-none">
                            <div class="fzf-error sl-box text-center">
                                <img src="<?php echo esc_url($nothing_found_img); ?>">
                                <h2 class="fzf-title"><?php esc_html_e( 'OOPS! NOTHING FOUND.', 'luxus-core' ); ?></h2>
                                <p class="error-text">
                                    <?php esc_html_e( 'Sorry, Properties not found. Please try again with some different keywords.', 'luxus-core' ); ?>
                                </p>
                            </div>
                        </div><!-- .page-content -->

                    <?php 

                    endif;
                    
                    wp_reset_postdata();

                    ?>
                </div>
            </div>
        </div>

        <!-- This Class order-xl-first is for float sidebar left -->
        <div class="col-xl-6 col-lg-5 <?php echo esc_attr($map_possition == 'left' ? 'order-lg-first' : ''); ?> half-map-area">
            <div class="half-map_outer">
                <div id="half_map" data-settings="<?php echo esc_attr($half_map_settings_json); ?>" data-properties="<?php echo esc_attr($sl_properties_json); ?>"></div>
            </div>
        </div>

        <?php if ( $map_show_mobile == 'no' ) : ?>
            <style> @media (max-width: 1200px) {.half-map-area{ display: none !important;}} </style>
        <?php endif; ?>
        <?php if ( $map_possition == 'left' ) : ?>
            <style> 
                @media (max-width: 1200px) {.half-map-area{ padding: 20px !important;}}
                @media (min-width: 1200px) {.half-map-area{ padding-left: 0 !important;}} 
            </style>
        <?php endif; ?>
    </div>
</div>
<!-- Main Content End -->

<?php

// Property Half Map OSM Script
if ( $half_map_opt == 'osmap' ) {

    wp_enqueue_script( 'luxus-half-map-osm', SL_PLUGIN_URL . 'public/js/luxus-half-map-osm.js', array(), '', true );
}

// Property Half Map Script
if ( $half_map_opt == 'gmap' ) {

    wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?key='.$sl_map_api, array(), '', true );
    wp_enqueue_script( 'luxus-half-map-gmap', SL_PLUGIN_URL . 'public/js/luxus-half-map-gmap.js', array(), '', true );
}

// Property Template Parts
require dirname( __FILE__ ) . '/template-parts/footer-map.php';
