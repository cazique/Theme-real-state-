<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * Template Name: Schedule Tour Sent
 */

// Custom Page Title
function luxus_schedule_tour_sent_page_title() {
    return esc_html__('Schedule Tour Sent', 'luxus-core') . ' - ' . get_bloginfo();
}
add_action( 'pre_get_document_title', 'luxus_schedule_tour_sent_page_title' );

global $wpdb;

$current_user = wp_get_current_user();

// Delete Sent schedules
require dirname( __FILE__ ) . '/template-parts/delete-sent-schedules.php';

// Custom User Header
require dirname( __FILE__ ) . '/template-parts/header-user.php';

$schedule_img = SL_PLUGIN_URL . 'public/images/calendar.png';

?>

<!-- Main Content -->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="heading-one"><?php esc_html_e('Schedules: Sent', 'luxus-core'); ?></h2>
            </div>
            <div class="col-lg-12">
            <?php

                $del_sch_success = isset($del_sch_alert['success']) ? $del_sch_alert['success'] : null;
                if( !$del_sch_success == null ){

                    echo '<script type="text/javascript">toastr.success("'. __('Schedule Deleated Successfully.', 'luxus-core') .'");</script>';
                }

                $del_sch_failed = isset($del_sch_alert['error']) ? $del_sch_alert['error'] : null;
                if( !$del_sch_failed == null ){

                    echo '<script type="text/javascript">toastr.error("'. __('Sorry! Schedule not delete.', 'luxus-core') .'");</script>';
                }

            ?>
            </div>
        </div>
    	<div class="row">
            <div class="col-xl-12">
                <?php
                    
                    $table_name = $wpdb->prefix . "luxus_schedule_tour";

                    $query = "SELECT * FROM $table_name WHERE sender_id = $current_user->ID AND del_sender = 0";
                    $total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
                    $total = $wpdb->get_var( $total_query );
                    $items_per_page = !empty( luxus_options('messages-show') ) ? luxus_options('messages-show') : '10';
                    $page = isset( $_GET['page'] ) ? abs( (int) $_GET['page'] ) : 1;
                    $offset = ( $page * $items_per_page ) - $items_per_page;

                    $schedules = $wpdb->get_results( $query . " ORDER BY time DESC LIMIT ${offset}, ${items_per_page}" );

                    if ( count($schedules) > 0 ) {

                        foreach ( $schedules as $schedule ) :

                            $sch_id = $schedule->id;
                            $sender_id = $schedule->sender_id;
                            $sch_url = site_url('schedule/?sch=sent&id=') . $sch_id;

                            $reciever_data = get_userdata( $schedule->receiver_id );

                            $sch_status = $schedule->status;

                        ?>

                            <div class="msg-container <?php echo esc_attr($sch_status); ?>">
                                <div class="profile-img">
                                    <img src="<?php echo esc_url($schedule_img); ?>">
                                </div>
                                <p class="name" ><strong><?php echo esc_html($reciever_data->first_name) .' '. esc_html($reciever_data->last_name); ?></strong></p>
                                <p class="date" ><?php echo esc_html($schedule->time);?></p>
                                <p class="msg-content" >
                                    <?php echo substr($schedule->message, 0, 55) . ' ...';?>
                                </p>
                                <div class="action">
                                    <a href="<?php echo esc_url($sch_url); ?>" class="read-more"><i class="fa fa-eye"></i></a>
                                    <form method='post' name='del-msg-<?php echo esc_attr($sch_id); ?>' id='del-msg-<?php echo esc_attr($sch_id); ?>' action=''>
                                        <input type="hidden" name='delete_id' value="<?php echo esc_attr($sch_id); ?>"/>
                                        <input type="hidden" name='sender_id' value="<?php echo esc_attr($sender_id); ?>"/>
                                        <a id="<?php echo esc_attr($sch_id); ?>" class="delete" data-bs-toggle="modal" data-bs-target="#confirm-delete-model"><i class="fa fa-times"></i></a>
                                        <input type="hidden" id="action" name="action" value="delete-schedule" />
                                    </form>
                                </div>
                            </div>

                    <?php endforeach;


                    } else {  ?>
                        <div class="alert-message alert-message-info">
                            <h6><?php esc_html_e('Sent Schedules Empty', 'luxus-core'); ?></h6>
                            <p><?php esc_html_e('Sorry! No schedules Sent yet!.', 'luxus-core'); ?></p>
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
<div class="modal fade" id="confirm-delete-model" tabindex="-1" role="dialog" aria-labelledby="confirm-delete-modelLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php esc_html_e('Are you sure?', 'luxus-core'); ?></h5>
        <span type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php esc_attr_e('Close', 'luxus-core'); ?>"></span>
      </div>
      <div class="modal-body">
        <strong><?php esc_html_e('Do you really want to delete this schedule?', 'luxus-core'); ?></strong>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><?php esc_html_e('Cancel: Sent', 'luxus-core'); ?></button>
        <button type="button" class="btn btn-danger confirm-delete"><?php esc_html_e('Confirm', 'luxus-core'); ?></button>
      </div>
    </div>
  </div>
</div>

<?php

wp_register_script( 'luxus-schedule-sent', '', array('jquery'), '', true );
wp_enqueue_script( 'luxus-schedule-sent'  );

wp_add_inline_script( 'luxus-schedule-sent', '

    jQuery(document).ready(function($) {
        // On Click Delete Button
        $(".delete").on("click", function(){

            var formid = $(this).closest("form").attr("id");

            // Get Delete Button ID
            var id = $(this).attr("id");

            // Remove Old ID from Confirm button in model
            $(".confirm-delete").removeAttr("id");

            // Add fetched ID to Confirm button in model
            $(".confirm-delete").attr("id","confirm-delete-" + id);

            // Get Confirm button ID
            var confirmDeleteID = $(".confirm-delete").attr("id");

            // On Click Confirm Button Delete schedule
            $($("#" + confirmDeleteID)).on("click", function(){
                
                $($("#" + formid)).submit();
                // history.back(); 
              
            });

        });

    });

');

// Custom User Footer
require dirname( __FILE__ ) . '/template-parts/footer-user.php';
