<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * Template Name: Trash Properties
 */

//Redirect Subscriber to dashboard
if( current_user_can( 'subscriber' ) ) { wp_redirect( site_url( 'user-dashboard' ) ); }

// Custom Page Title
function luxus_trash_properties_page_title() {
    return esc_html__('Trash Properties', 'luxus-core') . ' - ' . get_bloginfo();
}
add_action( 'pre_get_document_title', 'luxus_trash_properties_page_title' );

// Custom User Header
require dirname( __FILE__ ) . '/template-parts/header-user.php';

// Count Draft Properties
$publish_properties = count( get_posts( array( 
    'post_type' => 'property', 
    'author'    => $current_user->ID, 
    'post_status'=> 'publish',
) ) );
$user_publish_properties = $publish_properties != NULL ? $publish_properties : 0 ;

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

// Count Trash Properties
$trash_properties = count( get_posts( array( 
    'post_type' => 'property', 
    'author'    => $current_user->ID, 
    'post_status'=> 'trash',
) ) );
$user_trash_properties = $trash_properties != NULL ? $trash_properties : 0 ;

?>

<!-- Main Content -->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Quick Ovewview -->
                <div class="quick-overview">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <a href="<?php echo esc_url(site_url().'/published-properties'); ?>">
                                <div class="card-counter sl-gra-blue">
                                    <i class="sl-icon sl-published"></i>
                                    <span class="count-numbers"><?php echo esc_html($user_publish_properties !== null ? $user_publish_properties : '0'); ?></span>
                                    <span class="count-name"><?php esc_html_e('Published Posts', 'luxus-core'); ?></span>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <a href="<?php echo esc_url(site_url().'/draft-properties'); ?>">
                                <div class="card-counter sl-gra-yellow">
                                    <i class="sl-icon sl-draft"></i>
                                    <span class="count-numbers"><?php echo esc_html($user_draft_properties !== null ? $user_draft_properties : '0'); ?></span>
                                    <span class="count-name"><?php esc_html_e('Draft Posts', 'luxus-core'); ?></span>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <a href="<?php echo esc_url(site_url().'/pending-properties'); ?>">
                                <div class="card-counter sl-gra-purple">
                                    <i class="sl-icon sl-pending"></i>
                                    <span class="count-numbers"><?php echo esc_html($user_pending_properties !== null ? $user_pending_properties : '0'); ?></span>
                                    <span class="count-name"><?php esc_html_e('Pending Posts', 'luxus-core'); ?></span>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <a href="<?php echo esc_url(site_url().'/trash-properties'); ?>">
                                <div class="card-counter sl-gra-red">
                                    <i class="sl-icon sl-trash"></i>
                                    <span class="count-numbers"><?php echo esc_html($user_trash_properties !== null ? $user_trash_properties : '0'); ?></span>
                                    <span class="count-name"><?php esc_html_e('Trash Posts', 'luxus-core'); ?></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <h2 class="heading-one"><?php esc_html_e('Trash Properties', 'luxus-core'); ?></h2>
            </div>
        </div>
        <div class="row">
            <?php

                $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

                $posts_per_page = luxus_options( 'my-properties-show' );

                // the query
                $property = new WP_Query( array(
                    'post_type' => 'property',
                    'post_author' => get_current_user_id(),
                    'post_status' => 'trash',
                    'posts_per_page' => esc_html($posts_per_page),
                    'paged' => $paged,
                ));

                if ( $property->have_posts() ) :
                    while ( $property->have_posts() ) :
                        $property->the_post();

                $property_thumb = get_the_post_thumbnail_url( get_the_ID(),'luxus-thumb-md');
                $thumb_placeholder = SL_PLUGIN_URL . 'public/images/agency-cover1.jpg';
                $property_thumb_url = ( !empty($property_thumb) ? $property_thumb : $thumb_placeholder );

                // Property Meta Boxes
                $property_label = luxus_post_meta( '_property_label' );
                $_property_type = luxus_post_meta( '_property_type' );
                $property_type = !empty( $_property_type ) ? get_term( $_property_type ) : null;
                $_property_status = luxus_post_meta( '_property_status' );
                $property_status = !empty( $_property_status ) ? get_term( $_property_status ) : null;
                $property_price = luxus_post_meta( '_property_price' );
                $property_price_prefix = luxus_post_meta( '_property_price_prefix' );
                $property_price_postfix = luxus_post_meta( '_property_price_postfix' );
                $property_bedrooms = luxus_post_meta( '_property_bedrooms' );
                $property_bathrooms = luxus_post_meta( '_property_bathrooms' );
                $property_parking = luxus_post_meta( '_property_parking' );
                $property_area = luxus_post_meta( '_property_area' );
                $property_area_postfix = luxus_post_meta( '_property_area_postfix' );
                $property_address = luxus_post_meta( '_property_st_address' );

            ?>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="property-grid">
                    <div class="image">
                        <img src="<?php echo esc_url($property_thumb_url); ?>">
                        <?php if( $property_label ): ?>
                            <div class="featured-ribbon"><span><?php esc_html_e('Featured', 'luxus-core'); ?></span></div> 
                        <?php endif; ?>
                        <div class="image-top">
                            <?php if( $property_type != NULL ): ?>
                                <a href="<?php echo esc_url(get_term_link( $property_type->term_id )); ?>" class="type"><?php echo esc_html($property_type->name); ?></a>
                            <?php endif;

                            if( $property_status != NULL ): ?>
                                <a href="<?php echo esc_url(get_term_link( $property_status->term_id )); ?>" class="status">For <?php echo esc_html($property_status->name); ?></a>
                            <?php endif; ?>
                        </div>
                        <div class="image-bottom">
                            <div class="left">
                                <?php if( $property_area != NULL ): ?>
                                    <p class="area">
                                        <?php
                                            echo esc_html($property_area) . '/' . esc_html(luxus_area_units());
                                            if( $property_area_postfix != NULL ) {
                                                echo '<span class="area-postfix"> - ' . esc_html($property_area_postfix) . '</span>';
                                            }
                                        ?>
                                            
                                    </p>
                                <?php endif;

                                if( $property_price != NULL ): ?>
                                    <p class="price">
                                        <?php 

                                        if( $property_price_prefix != NULL ) {
                                            echo '<span class="price-prefix">' . esc_html($property_price_prefix) . '</span> ';
                                        }

                                        echo esc_html(luxus_currency_symbol()) . esc_html($property_price);

                                        if( $property_price_postfix != NULL ) {
                                            echo '<span class="price-postfix"> - ' . esc_html($property_price_postfix) . '</span>';
                                        }

                                        ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="property-info">
                        <div class="content">
                            <a href="<?php the_permalink(); ?>"><h6 class="title"><?php the_title(); ?></h6></a>
                            <p class="address"><i class="sl-icon sl-place"></i>
                                <?php echo esc_html( !empty( $property_address ) ? $property_address : __('NA', 'luxus-core') ); ?>
                            </p>
                            <ul class="features">
                                <li>
                                    <p><?php esc_html_e('Bedrooms', 'luxus-core'); ?></p>
                                    <p><i class="sl-icon sl-bedroom"></i>
                                        <span>
                                            <?php echo esc_html( !empty( $property_bedrooms ) ? $property_bedrooms : __('NA', 'luxus-core') ); ?>
                                        </span>
                                    </p>
                                </li>
                                <li>
                                    <p><?php esc_html_e('Bathrooms', 'luxus-core'); ?></p>
                                    <p><i class="sl-icon sl-bathroom"></i>
                                        <span>
                                            <?php echo esc_html( !empty( $property_bathrooms ) ? $property_bathrooms : __('NA', 'luxus-core') ); ?>
                                        </span>
                                    </p>
                                </li>
                                <li>
                                    <p><?php esc_html_e('Parking', 'luxus-core'); ?></p>
                                    <p><i class="sl-icon sl-car"></i>
                                        <span>
                                            <?php echo esc_html( !empty( $property_parking ) ? $property_parking : __('NA', 'luxus-core') ); ?>
                                        </span>
                                    </p>
                                </li>
                            </ul>
                        </div>
                        <div class="footer">
                            <span class="agent"><i class="sl-icon sl-user-o"></i>
                                <?php echo get_the_Author(); ?>
                            </span>
                            <span class="date"><i class="sl-icon sl-calendar"></i>
                                <?php echo esc_html(get_the_Date()); ?>
                            </span>
                        </div>
                        <div class="sl-crud">
                            <span class="c-btn">
                                <a href="<?php echo esc_url(site_url().'/edit-property?edit_property='.get_the_ID()); ?>" ><?php esc_html_e('Edit', 'luxus-core'); ?></a>
                            </span>
                            <span class="c-btn">
                                <a href="<?php echo esc_url(site_url().'?change_status=change_status&status=pending&postid='.get_the_ID()); ?>"><?php esc_html_e('Pending', 'luxus-core'); ?></a>
                            </span>
                            <span class="c-btn">
                                <a href="<?php echo esc_url(site_url().'?change_status=change_status&status=draft&postid='.get_the_ID()); ?>"><?php esc_html_e('Draft', 'luxus-core'); ?></a>
                            </span>
                            <span class="c-btn">
                                <a href="<?php echo esc_url(get_delete_post_link( get_the_ID(), '', true )); ?>"><?php esc_html_e('Delete', 'luxus-core'); ?></a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile;

                // Custom Pagination
                luxus_pagination_bar( $property );

            else : ?>
                <div class="col-lg-12">
                    <div class="alert-message alert-message-info">
                        <h6><?php esc_html_e('Properties not found.', 'luxus-core'); ?></h6>
                        <p><?php esc_html_e('Sorry! No Properties found in Trash.', 'luxus-core'); ?></p>
                    </div>
                </div>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div> 
    </div>
</div>
<!-- Main Content End -->

<?php

// Custom User Footer
require dirname( __FILE__ ) . '/template-parts/footer-user.php';
