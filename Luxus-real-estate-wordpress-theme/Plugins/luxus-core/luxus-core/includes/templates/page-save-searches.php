<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * Template Name: Reviews Page
 */

// Custom Page Title
function luxus_save_searches_page_title() {
    return esc_html__('Save Searches', 'luxus-core') . ' - ' . get_bloginfo();
}
add_action( 'pre_get_document_title', 'luxus_save_searches_page_title' );

// Custom User Header
require dirname( __FILE__ ) . '/template-parts/header-user.php';

$current_user = wp_get_current_user();

$schedule_img = SL_PLUGIN_URL . 'public/images/calendar.png';

?>

<!-- Main Content -->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="heading-one"><?php esc_html_e('Save Searches', 'luxus-core'); ?></h2>
            </div>
        </div>
    	<div class="row">
            <div class="col-xl-12">
            <?php
                
            $table_name = $wpdb->prefix . "save_searches";

            $query = "SELECT * FROM $table_name";
            $total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
            $total = $wpdb->get_var( $total_query );
            $items_per_page = 10;
            $page = isset( $_GET['page'] ) ? abs( (int) $_GET['page'] ) : 1;
            $offset = ( $page * $items_per_page ) - $items_per_page;

            $searches = $wpdb->get_results( $query . " ORDER BY time DESC LIMIT ${offset}, ${items_per_page}" );
            
            if ( count($searches) > 0 ) {

                foreach ( $searches as $search ) :

                $search_id = $search->id;
                $search_time = $search->time;
                $search_data = $search->ss_data;
                $search_arr = array();
                parse_str($search_data, $search_arr);

                $search_name = isset($search_arr['search_name']) ? $search_arr['search_name'] : null;
                $search_title = isset($search_arr['search_title']) ? $search_arr['search_title'] : null;
                $property_status = isset($search_arr['property_status']) ? $search_arr['property_status'] : null;
                $property_type = isset($search_arr['property_type']) ? $search_arr['property_type'] : null;
                $property_city = isset($search_arr['property_city']) ? $search_arr['property_city'] : null;
                $min_area = isset($search_arr['min_area']) ? $search_arr['min_area'] : null;
                $max_area = isset($search_arr['max_area']) ? $search_arr['max_area'] : null;
                $bedrooms = isset($search_arr['bedrooms']) ? $search_arr['bedrooms'] : null;
                $bathrooms = isset($search_arr['bathrooms']) ? $search_arr['bathrooms'] : null;
                $build_year = isset($search_arr['build_year']) ? $search_arr['build_year'] : null;
                $min_price = isset($search_arr['min_price']) ? $search_arr['min_price'] : null;
                $max_price = isset($search_arr['max_price']) ? $search_arr['max_price'] : null;
                $property_amenty = isset($search_arr['property_amenty']) ? $search_arr['property_amenty'] : null;

                $sort_by = isset($search_arr['sort_by']) ? $search_arr['sort_by'] : null;

                ?>
                <div id="save-search-form-<?php echo esc_attr($search_id); ?>" class="save-search-form">
                    <p class="search-name"><strong><?php echo esc_html($search_name); ?></strong></p>
                    <p class="search-time"><?php echo esc_html($search_time); ?></p>
                    <form id="search_form_<?php echo esc_attr($search_id); ?>" method="GET" action="<?php echo esc_url(home_url('/properties')); ?>">
                        <input type="hidden" name="search_title" value="<?php echo esc_attr($search_title) ?>">
                        <input type="hidden" name="property_status" value="<?php echo esc_attr($property_status) ?>">
                        <input type="hidden" name="property_type" value="<?php echo esc_attr($property_type); ?>">
                        <input type="hidden" name="property_city" value="<?php echo esc_attr($property_city); ?>">
                        <input type="hidden" name="min_area" value="<?php echo esc_attr($min_area); ?>">
                        <input type="hidden" name="max_area" value="<?php echo esc_attr($max_area) ?>">
                        <input type="hidden" name="bedrooms" value="<?php echo esc_attr($bedrooms); ?>">
                        <input type="hidden" name="bathrooms" value="<?php echo esc_attr($bathrooms); ?>">
                        <input type="hidden" name="build_year" value="<?php echo esc_attr($build_year); ?>">
                        <input type="hidden" name="min_price" value="<?php echo esc_attr($min_price); ?>">
                        <input type="hidden" name="max_price" value="<?php echo esc_attr($max_price); ?>">

                        <?php if($property_amenty != NULL) :
                                foreach($search_arr['property_amenty'] as $single_amenty) :
                        ?>
                            <input type="hidden" name="property_amenty[]" value="<?php echo esc_attr($single_amenty); ?>">

                        <?php endforeach;   
                            endif;
                        ?>

                        <input type="hidden" name="sort_by" value="<?php echo $sort_by; ?>">
                        <button type="submit" class="view-search"><?php esc_html_e('View Search', 'luxus-core'); ?></button>
                        <a id="<?php echo esc_attr($search_id); ?>" class="delete-search" data-bs-toggle="modal" data-bs-target="#confirm-delete-model"><i class="fa fa-times"></i></a>
                    </form>
                </div>
            <?php endforeach;

            } else { ?>
                <div class="alert-message alert-message-info">
                    <h6><?php esc_html_e('Save Searches not found.', 'luxus-core'); ?></h6>
                    <p><?php esc_html_e('You do not save any serach yet.', 'luxus-core'); ?></p>
                </div>
           <?php } ?>
            </div>
            <?php
                // Pagination
                $pagination = paginate_links( array(
                    'base' => add_query_arg( 'page', '%#%' ),
                    'format' => '',
                    'prev_text' => __('&laquo;'),
                    'next_text' => __('&raquo;'),
                    'total' => ceil($total / $items_per_page),
                    'current' => $page
                ));

                if ($pagination) :

            ?>
                <div class="col-xl-12">
                    <div class="custom-pagination dash-pages-pagination">
                        <div class="sl-pagination">
                            <?php echo $pagination; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
    	</div>
    </div>
</div>
<!-- Main Content End -->


<!-- Delete Confirm Modal -->
<div class="modal fade" id="confirm-delete-model" tabindex="-1" aria-labelledby="Delete Search" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php esc_html_e('Are you sure?', 'luxus-core'); ?></h5>
        <span type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php esc_attr_e('Close', 'luxus-core'); ?>"></span>
      </div>
      <div class="modal-body">
        <strong><?php esc_html_e('Do you really want to delete this Search?', 'luxus-core'); ?></strong>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><?php esc_html_e('Close', 'luxus-core'); ?></button>
        <button type="button" class="btn btn-danger confirm-delete-search"><?php esc_html_e('Confirm', 'luxus-core'); ?></button>
      </div>
    </div>
  </div>
</div>

<?php

// Custom User Footer
require dirname( __FILE__ ) . '/template-parts/footer-user.php';
