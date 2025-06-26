<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * Template Name: Properties Template
 */

get_header();

// Get options
$sidebar_position = luxus_options('properties-sidebar-position');
$is_active_sidebar = ( is_active_sidebar( 'properties-page-widget' ) ? true : false );
$active_col = ( $is_active_sidebar == true ? '8' : '12' );

$header_bg = SL_PLUGIN_URL . 'public/images/search-header-bg.jpg';

?>

<div class="properties-page-header">
    <div class="container">
        <?php
            require dirname( __FILE__ ) . '/template-parts/search-properties-form.php';
            require dirname( __FILE__ ) . '/template-parts/property-sorting.php';
        ?> 
    </div>
</div><!-- .page-header -->

<!-- Main Content -->
<div class="page-content properties-page-content">
    <div class="container">
        <div class="row">


            <?php

            $url_parts = parse_url( home_url() );
            $current_url_with_query_string = $url_parts['scheme'] . "://" . $url_parts['host'] . add_query_arg( NULL, NULL );
            // echo $current_url_with_query_string;

            ?>





            <div class="col-lg-<?php echo esc_attr($active_col); ?>">
                <div  class="filter-properties">
                    <!-- List View / Grid View -->
                    <div class="list-grid-view">
                        <a href="#" id="grid"><i class="sl-icon sl-grid-view"></i></a>
                        <a href="#" id="list"><i class="sl-icon sl-list-view"></i></a>
                    </div>
                    <!-- Save Search -->
                    <?php

                        $save_searches_allow = luxus_options('enable-save-search');

                        if( isset( $_GET['save_search'] ) ) {
                            $save_search = $_GET['save_search'];
                        }
                        else {
                           $save_search = null;    
                        }

                        if ( $save_searches_allow && !$save_search == null ){
                            require dirname( __FILE__ ) . '/template-parts/save-search.php';
                        }

                    ?>
                    <div class="sort-by">
                        <form id="set_sort_filter" action="" method="GET" novalidate="novalidate">
                            <div class="sl-select">
							<select name="sort_by" class="sort-by-select form-control col-md-12 ">
                                <option value="default"><?php esc_html_e('Default Order', 'luxus-core'); ?></option>         
                                <option value="featured" <?php echo esc_attr($sort_by == 'featured' ? 'selected' : ''); ?> ><?php esc_html_e('Featured Properties', 'luxus-core'); ?></option>         
                                <option value="low_high" <?php echo esc_attr($sort_by == 'low_high' ? 'selected' : ''); ?> ><?php esc_html_e('Price (Low to Hight)', 'luxus-core'); ?></option>         
                                <option value="high_low" <?php echo esc_attr($sort_by == 'high_low' ? 'selected' : ''); ?> ><?php esc_html_e('Price (High to Low)', 'luxus-core'); ?></option>
                                <option value="new" <?php echo esc_attr($sort_by == 'new' ? 'selected' : ''); ?> ><?php esc_html_e('Date New to Old', 'luxus-core'); ?></option>       
                                <option value="old" <?php echo esc_attr($sort_by == 'old' ? 'selected' : ''); ?> ><?php esc_html_e('Date Old to New', 'luxus-core'); ?></option>
                            </select>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="properties">
                    <div class="row">
                        <?php

                            $post_view = luxus_options('properties-post-view');

                            if ($is_active_sidebar) {
                                $sl_col = ( $post_view == 'grid-view' ? 'col-md-6 col-lg-6' : 'col-md-12 col-lg-12' );
                            } else {
                                $sl_col = ( $post_view == 'grid-view' ? 'col-md-6 col-lg-4' : 'col-md-12 col-lg-12' );
                            }

                            $sl_col_item = ( $post_view == 'grid-view' ? 'property-grid' : 'property-list' );

                            $posts_per_page= luxus_options('properties-show');

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
                        ?>
                                <div class="sl-col <?php echo esc_attr($sl_col); ?>">
                                    <div class="sl-item <?php echo esc_attr($sl_col_item); ?>">
                                        <?php

                                        // Property Template Parts
                                        require dirname( __FILE__ ) . '/template-parts/property-style-one.php';

                                        ?>
                                    </div>
                                </div>
                        <?php

                                endwhile;

                                    // Custom Pagination
                                    echo '<div class="col-lg-12">';
                                    luxus_pagination_bar( $properties );
                                    echo '</div>';

                                else :

                                $nothing_found_img = SL_PLUGIN_URL . 'public/images/nothing-found.png';
                        ?>
                                <div class="col-xl-12 content-none">
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

            <?php if( $is_active_sidebar == true ) : ?>
            <!-- This Class order-xl-first is for float sidebar left -->
            <div class="col-lg-4 sl-sticky <?php echo esc_attr( $sidebar_position == 'left-sidebar' ? 'order-lg-first' : '' ); ?>">
                <aside id="secondary" class="widget-area">
                    <?php dynamic_sidebar( 'properties-page-widget' ); ?>
                </aside><!-- #secondary -->
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<!-- Main Content End -->

<?php
get_footer();