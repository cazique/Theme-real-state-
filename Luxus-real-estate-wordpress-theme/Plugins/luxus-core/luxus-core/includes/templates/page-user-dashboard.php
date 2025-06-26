<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * Template Name: User Dashboard
 */

// Custom Page Title
function luxus_dashboard_page_title() {
    return esc_html__('Dashboard', 'luxus-core') . ' - ' . get_bloginfo();
}
add_action( 'pre_get_document_title', 'luxus_dashboard_page_title' );

$current_user = wp_get_current_user();

if ( !current_user_can('subscriber') ) {

    // Count Published Properties
    $published_properties = count_user_posts( $current_user->ID ,array(
        'post_type' =>'property',
        'post_status'=> 'publish'
    ));
    $user_published_properties = $published_properties != NULL ? $published_properties : 0 ;

    // Count Draft Properties
    $draft_properties = count_user_posts( $current_user->ID ,array(
        'post_type' =>'property',
        'post_status'=> 'draft'
    ));
    $user_draft_properties = $draft_properties != NULL ? $draft_properties : 0 ;

    // Count Draft Properties
    $pending_properties = count_user_posts( $current_user->ID ,array(
        'post_type' =>'property',
        'post_status'=> 'pending'
    ));
    $user_pending_properties = $pending_properties != NULL ? $pending_properties : 0 ;

    // Count Fav Properties
    $fav_properties = get_user_meta( $current_user->ID, '_luxus_user_favourite_properties' , true );
    $user_fav_properties = $fav_properties != NULL ? count( $fav_properties ) : 0 ;

    // Count User Profile Views

    $profile_views = get_user_meta( $current_user->ID, 'profile_views_count' , true );
    $total_profile_view = $profile_views != NULL ? $profile_views : 0 ;

    // Count User Property Views
    $current_user_posts = get_posts(
            array(
                'author'      =>  $current_user->ID,
                'post_type'   => 'property'
            )
    );

    $posts_view = array();
    foreach ($current_user_posts as $user_posts ) {

        $posts_view[] = get_post_meta( $user_posts->ID, 'post_views_count', true );;
    }

    $total_posts_view = $posts_view != NULL ? array_sum($posts_view) : 0;

}

// Custom User Header
require dirname( __FILE__ ) . '/template-parts/header-user.php';

?>

<!-- main-content -->
<div class="main-content">
    <div class="container">
        <?php if ( !current_user_can('subscriber') ) : ?>
            <!-- Quick Ovewview -->
            <div class="quick-overview">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <a href="<?php echo esc_url(site_url().'/published-properties'); ?>">
                            <div class="card-counter sl-gra-blue">
                                <i class="fa fa-home"></i>
                                <span class="count-numbers"><?php echo esc_html($user_published_properties); ?></span>
                                <span class="count-name"><?php esc_html_e('Properties', 'luxus-core'); ?></span>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card-counter sl-gra-yellow">
                            <i class="fa fa-users"></i>
                            <span class="count-numbers"><?php echo esc_html($total_profile_view); ?></span>
                            <span class="count-name"><?php esc_html_e('Profile Views', 'luxus-core'); ?></span>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card-counter sl-gra-purple">
                            <i class="fa fa-eye"></i>
                            <span class="count-numbers"><?php echo esc_html($total_posts_view); ?></span>
                            <span class="count-name"><?php esc_html_e('Total Visitors', 'luxus-core'); ?></span>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <a href="<?php echo esc_url(site_url().'/favorite-properties'); ?>">
                            <div class="card-counter sl-gra-red">
                                <i class="fa fa-heart"></i>
                                <span class="count-numbers"><?php echo esc_html($user_fav_properties); ?></span>
                                <span class="count-name"><?php esc_html_e('Bookmarks', 'luxus-core'); ?></span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Recent Properties -->
        <div class="recent-properties">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="heading-one"><?php esc_html_e('Recent Properties', 'luxus-core'); ?></h3>
                </div>
            </div>
            <div class="row">
                
                <?php

                    $posts_per_page = luxus_options( 'my-properties-show' );

                    // the query
                    $property = new WP_Query( array(
                        'post_type' => 'property',
                        'post_status' => 'publish',
                        'posts_per_page' => esc_html($posts_per_page),
                    ));
                ?>

                <?php if ( $property->have_posts() ) :
                	while ( $property->have_posts() ) :
                		$property->the_post();
                ?>

                <div class="col-lg-6 col-xl-4">
                    <div class="sl-item property-grid">
                        <?php

                            // Property Template Parts
                            require dirname( __FILE__ ) . '/template-parts/property-style-one.php';

                        ?>
                    </div>
                </div>

                <?php endwhile; ?>

                <?php else : ?>
 
                <div class="col-lg-12">
                    <div class="alert-message alert-message-info">
                        <h6><?php esc_html_e('Properties Not Found!', 'luxus-core'); ?></h6>
                        <p><?php esc_html_e('Sorry! No Published Properties Found.', 'luxus-core'); ?></p>
                    </div>
                </div>

                <?php endif; ?>

                <?php wp_reset_postdata(); ?>

            </div>
        </div>
    </div>
</div>
<!-- main-content -->

<?php

// Custom User Footer
require dirname( __FILE__ ) . '/template-parts/footer-user.php';
