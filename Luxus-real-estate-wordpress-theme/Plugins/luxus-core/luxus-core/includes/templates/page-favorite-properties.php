<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * Template Name: Favorite Properties
 */

// Custom Page Title
function luxus_favorite_properties_page_title() {
    return esc_html__('Favorite Properties', 'luxus-core') . ' - ' . get_bloginfo();
}
add_action( 'pre_get_document_title', 'luxus_favorite_properties_page_title' );

// Custom User Header
require dirname( __FILE__ ) . '/template-parts/header-user.php';

$user_id = get_current_user_id();

$property_ids = get_user_meta( $user_id, '_luxus_user_favourite_properties' , true );

?>

<!-- Main Content -->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="heading-one"><?php esc_html_e('Favorite Properties', 'luxus-core'); ?></h2>
            </div>
        </div>
        <div id="properties">
            <div class="row">
                <?php

                if ( $property_ids != NULL ){

                    $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

                    $posts_per_page = luxus_options( 'fav-properties-show' );
                    
                    // the query
                    $properties = new WP_Query( array(
                        'post_type' => 'property',
                        'post_status' => 'publish',
                        'post__in' => $property_ids,
                        'posts_per_page' => $posts_per_page,
                        'paged' => $paged,
                    ));

                    if ( $properties->have_posts() ) :
                        while ( $properties->have_posts() ) :
                            $properties->the_post();
                ?>
                        <div class="sl-col col-xl-4">
                            <div class="sl-item property-grid">
                                <?php

                                // Property Template Parts
                                require dirname( __FILE__ ) . '/template-parts/property-style-one.php';

                                ?>
                            </div>
                        </div>
                <?php

                        endwhile;

                            // Custom Pagination
                            luxus_pagination_bar( $properties );

                        else :

                        $not_found_img = SL_PLUGIN_URL . 'public/images/error.png';
                ?>
                        <div class="col-xl-12">
                            <div class="not-found-result">
                                <img src="<?php echo esc_url($not_found_img); ?>">
                                <h6><?php esc_html_e( 'Sorry, No Properties Found.', 'luxus-core' ); ?></h6>
                            </div>
                        </div>

                <?php 

                    endif;

                    wp_reset_postdata();

                } else{
                ?>
                <div class="col-lg-12">
	                <div class="alert-message alert-message-info">
                        <h6><?php esc_html_e('Favorite Properties not found.', 'luxus-core'); ?></h6>
                        <p><?php esc_html_e('Sorry! You do not added property in your favorite list', 'luxus-core'); ?></p>
                    </div>
                </div>
            	<?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- Main Content End -->

<?php

// Custom User Footer
require dirname( __FILE__ ) . '/template-parts/footer-user.php';
