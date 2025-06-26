<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * Template Name: Users Agents
 */

get_header();

// Get options
$is_active_sidebar = ( is_active_sidebar( 'agents-page-widget' ) ? true : false );
$active_col = ( $is_active_sidebar == true ? '8' : '12' );
$sidebar_position = luxus_options('agents-sidebar-position');
$agent_enable_page_title = luxus_options('agent-enable-page-title');
$agent_enable_breadcrumb  = luxus_options('agent-enable-breadcrumb');

// Search Form
if( isset( $_GET['agent-name'] ) AND !empty( $_GET['agent-name'] ) ) {

    $search_name = $_GET['agent-name'];

}else {

   $search_name = '';    
}

if( isset( $_GET['agent-city'] ) AND !empty( $_GET['agent-city'] ) ) {

    $search_city = $_GET['agent-city'];

    $meta_query [] = array(
        // 'relation' => 'OR',
        array(
            'key'     => 'luxus_user_city',
            'value'   => $search_city,
            'compare' => 'LIKE'
        ),
    );

} else {
    
   $search_city = '';    
   $meta_query = '';    
}

// Agent Title
if( $agent_enable_page_title == true ): ?>

<div class="agent-page-header">
    <div class="container">
        <?php

            the_title( '<h2 class="agent-page-title">', '</h2>' );

            if( $agent_enable_breadcrumb == true ): ?>

                <p class="sl_breadcrumb agent-breadcrumb"><?php echo luxus_get_breadcrumb(); ?></p>

            <?php endif;?>
    </div>
</div><!-- .page-header -->

<?php endif; ?>

<!-- Main Content -->
<div class="page-content agents-page-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-<?php echo esc_attr($active_col); ?>">
                <div class="row">

                    <!-- Agent Search form -->
                    <div class="col-lg-12">
                        <div class="role-search-form">
                            <form action="<?php echo esc_url( get_the_permalink() ); ?>" method="GET" novalidate="novalidate">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <input type="text" name="agent-name" value="<?php echo esc_attr(isset($_GET['agent-name']) ? $search_name : NULL); ?>" class="form-control sl-search-input search_name" placeholder="<?php esc_attr_e('Search agent by name ...', 'luxus-core'); ?>">
                                    </div>
                                    <div class="col-lg-4 col-md-12 sl-p0">
                                        <input type="text" name="agent-city" value="<?php echo esc_attr(isset($_GET['agent-city']) ? $search_city : NULL); ?>" class="form-control sl-search-input search_city" placeholder="<?php esc_attr_e('Enter city name ...', 'luxus-core'); ?>">
                                    </div>
                                    <div class="col-lg-2 col-md-12">
                                        <div class="submit_btn">
                                            <button type="submit" class="sl-btn-fill search-btn"><?php esc_html_e('Search', 'luxus-core'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Agent Search Form End -->

                    <?php

                    $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
                    $posts_per_page = luxus_options('agents-show');
                    $post_style = luxus_options('agents-post-style');
                    
                    // WP_User_Query arguments
                    $args = array (
                        'role' => 'agent',
                        'search' => '*'.esc_attr( $search_name ).'*',
                        'meta_query' => $meta_query,
                        'order' => 'ASC',
                        'number' => $posts_per_page,
                        'paged' => $paged,
                    );

                    // Create the WP_User_Query object
                    $agents_query = new WP_User_Query($args);

                    // Get the results
                    $agents = $agents_query->get_results();

                    // Check for results
                    if (!empty($agents)) {

                        // loop through each users
                        foreach ( $agents as $agent ) {

                            $sl_col = ( is_active_sidebar( 'agents-page-widget' ) ? 'col-lg-6 col-md-6' : 'col-lg-4 col-md-6' );

                            // Agency Template Parts
                            require dirname( __FILE__ ) . '/template-parts/agent-' .$post_style. '.php';
                            
                        }

                    } else {
                        
                        $nothing_found_img = SL_PLUGIN_URL . 'public/images/nothing-found.png';
                    ?>
                        <div class="col-xl-12 content-none">
                            <div class="fzf-error sl-box text-center">
                                <img src="<?php echo esc_url($nothing_found_img); ?>">
                                <h2 class="fzf-title"><?php esc_html_e( 'OOPS! NOTHING FOUND.', 'luxus-core' ); ?></h2>
                                <p class="error-text">
                                    <?php esc_html_e( 'Sorry, Agents not found. Please try again with some different keywords.', 'luxus-core' ); ?>
                                </p>
                            </div>
                        </div><!-- .page-content -->
                    <?php

                    }

                    // Custom Pagination Accepts Two Parameters
                    // Parameters 1: Custom Query Object
                    // Parameters 2: Total Number of posts showing in page
                    echo '<div class="col-lg-12">';
                    luxus_user_query_pagination( $agents_query, $posts_per_page );
                    echo '</div>';

                    wp_reset_postdata();

                    ?>
                </div>
            </div>

            <?php if( $is_active_sidebar == true ) : ?>
            <!-- This Class order-xl-first is for float sidebar left -->
            <div class="col-lg-4 sl-sticky <?php echo esc_attr( $sidebar_position == 'left-sidebar' ? 'order-lg-first' : '' ); ?>">
                <aside id="secondary" class="widget-area">
                    <?php dynamic_sidebar( 'agents-page-widget' ); ?>
                </aside><!-- #secondary -->
            </div>
            <?php endif; ?>
 
        </div>
    </div>
</div>
<!-- Main Content End -->

<?php
get_footer();