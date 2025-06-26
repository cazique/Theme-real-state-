<?php

// Schedule Tour Form Request

$schedule_tour_table_name = $wpdb->prefix."luxus_schedule_tour";
$schedule_tour_msg_alert = '';
$schedule_tour_error = '';

$schedule_notify_admin = luxus_options('schedule-notify-admin');
$schedule_notify_author = luxus_options('schedule-notify-author');

if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['schedule_action'] ) && $_POST['schedule_action'] == 'send-schedule' )
{
    global $schedule_tour_error;
    $schedule_tour_error = new WP_Error;

    $sch_created_by = $current_user_id;

    $sch_sender_phone_isset = sanitize_text_field( $_POST['sch_sender_phone'] );
    $sch_tour_date_isset = $_POST['sch_tour_date'];
    $sch_tour_time_isset = $_POST['sch_tour_time'];
    $sch_sender_message_isset = sanitize_text_field( $_POST['sch_sender_message'] );

    if ( empty( $sch_sender_phone_isset ) || empty( $sch_tour_date_isset ) || empty( $sch_tour_time_isset ) || empty( $sch_sender_message_isset ) ) {
        $schedule_tour_error->add( 'field', __('Please fill all Required fields.', 'luxus-core') );
    }
    if ( ! wp_verify_nonce( $_POST['sch_tour_nonce'], 'sch_tour_action' ) ) {
        $schedule_tour_error->add( 'nonce', __('Something is wrong, Please try again.', 'luxus-core') );
    }


    if( isset( $_POST['sch_sender_id'] ) AND !empty( $_POST['sch_sender_id'] ) ) {
        $sch_sender_id = sanitize_text_field( $_POST['sch_sender_id'] );
    }
    else {
       $sch_sender_id = '';    
    }

    if( isset( $_POST['sch_receiver_id'] ) AND !empty( $_POST['sch_receiver_id'] ) ) {
        $sch_receiver_id = sanitize_text_field( $_POST['sch_receiver_id'] );
    }
    else {
       $sch_receiver_id = '';    
    }

    if( isset( $sch_sender_phone_isset ) AND !empty( $sch_sender_phone_isset ) ) {
        $sch_sender_phone = $sch_sender_phone_isset;
    }
    else {
       $sch_sender_phone = '';
    }

    if( isset( $_POST['sch_property_id'] ) AND !empty( $_POST['sch_property_id'] ) ) {
        $sch_property_id = sanitize_text_field( $_POST['sch_property_id'] );
    }
    else {
       $sch_property_id = '';
    }

    if( isset( $sch_tour_date_isset ) AND !empty( $sch_tour_date_isset ) ) {
        $sch_tour_date = $sch_tour_date_isset;
    }
    else {
       $sch_tour_date = '';
    }

    if( isset( $sch_tour_time_isset ) AND !empty( $sch_tour_time_isset ) ) {
        $sch_tour_time = $sch_tour_time_isset;
    }
    else {
       $sch_tour_time = '';
    }

    if( isset( $sch_sender_message_isset ) AND !empty( $sch_sender_message_isset ) ) {
        $sch_sender_message = $sch_sender_message_isset;
    }
    else {
       $sch_sender_message = '';    
    }

    $sch_time = current_time('mysql', 1);

    if ( 1 > count( $schedule_tour_error->get_error_messages() ) ) {

        $data = array(
            'created_by' => $sch_created_by,
            'sender_id' => $sch_sender_id,
            'receiver_id' => $sch_receiver_id,
            'sender_phone' => $sch_sender_phone,
            'property_id' => $sch_property_id,
            'tour_date' => $sch_tour_date,
            'tour_time' => $sch_tour_time,
            'message' => $sch_sender_message,
            'time' => $sch_time,
        );

        //field formats: %s = string, %d = integer, %f = float
        // A string is a sequence of characters, like "Hello world!".
        // An integer data type is a non-decimal number between -2,147,483,648 and 2,147,483,647.

        $format = array(
            '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'
        );

        $success = $wpdb->insert( $schedule_tour_table_name, $data, $format );

        // Notify Schedule Form Email to Admin and Agent/Agency

        if ( $schedule_notify_author || $schedule_notify_admin ) {

            if ( $schedule_notify_author ) {

                $to = get_the_author_meta( 'user_email' ); // Author Email

            } else {

                $to = get_option( 'admin_email' ); // Admin Email

            }

            if ( $schedule_notify_admin && $schedule_notify_author ) {

                $cc = get_option( 'admin_email' ); // Admin Email

            } else {

                $cc = '';
            }

            $bcc = ''; // Bcc Email
            $from = $current_user_email; // From Email
            $subject = 'New Sheduled Tour Request Recieved!'; //Email Subject

            // Message
            $template = 'You have a new Schedule Tour Request on <a href=' . get_permalink() . '>' . get_the_title() . '</a><br><br>
                <b>Name:</b> ' . $current_user_name . '<br>
                <b>Email:</b> ' . $current_user_email . '<br>
                <b>Phone:</b> ' .  $sch_sender_phone . ' <br>
                <b>Tour Date:</b> ' . $sch_tour_date . ' <br>
                <b>Tour Time:</b> ' . $sch_tour_time . ' <br><br>
                <b>Message:</b><br> ' . $sch_sender_message;
            
            // Send Email
            luxus_wp_mail( $from, $to, $subject, $template, $cc, $bcc);
        }

        // Success
        $schedule_tour_msg_alert = 'success';

        // Reset Form
        $sch_sender_phone = '';
        $sch_tour_date = '';
        $sch_tour_time = '';
        $sch_sender_message = '';

    }else{
        $schedule_tour_msg_alert = 'failed';
    }
}

$sch_property_id = get_the_ID();

?>

<!-- Schedule Tour Form -->
<div id="noPrintableArea" class="sl-box request-schedule-tour">
    <h6 class="heading"><?php esc_html_e('Schedule a Tour', 'luxus-core'); ?></h6>
    <div class="contect-form">
        <form action="" method="post">
            <input type="hidden" id="sch_receiver_id" name="sch_receiver_id" value="<?php echo esc_attr($author_id); ?>" />
            <input type="hidden" id="sch_sender_id" name="sch_sender_id" value="<?php echo esc_attr($current_user_id); ?>" />

            <input type="hidden" id="sch_property_id" name="sch_property_id" value="<?php echo esc_attr($sch_property_id); ?>" />

            <?php if( !is_user_logged_in() ) { ?>

                <input type="text" class="form-control" id="sch_sender_name" placeholder="<?php esc_html_e('Name', 'luxus-core'); ?>">

                <input type="text" class="form-control" id="sch_sender_email" placeholder="<?php esc_html_e('Email', 'luxus-core'); ?>">

            <?php } else {
                echo "<p>".esc_html__('Logged in as', 'luxus-core')."<strong>".$current_user_name."</strong></p>";
            } ?>

            <input type="text" class="form-control" id="sch_sender_phone" name="sch_sender_phone" value="<?php echo esc_attr( isset( $_POST['sch_sender_phone'] ) ? $sch_sender_phone : null ) ?>" placeholder="<?php esc_attr_e('Phone', 'luxus-core'); ?>">

              <div class="row gx-3">
                <div class="col-lg-8">
                  <input type="text" class="form-control" id="date_picker" name="sch_tour_date" value="" placeholder="<?php esc_attr_e('Date', 'luxus-core'); ?>">
                </div>
                <div class="col-lg-4">
                  <input type="text" class="form-control" id="time_picker" name="sch_tour_time" value="" placeholder="<?php esc_attr_e('Time', 'luxus-core'); ?>">
                </div>
              </div>

            <textarea class="form-control" id="sch_sender_message" name="sch_sender_message" value="<?php echo esc_attr( isset( $_POST['sch_sender_message'] ) ? $sch_sender_message : null ) ?>"placeholder="<?php esc_attr_e('Message', 'luxus-core'); ?>"><?php echo esc_attr( isset( $_POST['sch_sender_message'] ) ? $sch_sender_message : null ) ?></textarea>

            <?php if( !is_user_logged_in() ) {

                echo "<a href='' class='sl-ajax-login sl-btn-outline'>". esc_html__('Submit Request', 'luxus-core')."</a>";

            } else { ?>
                
                <button type="submit" class="schedule-submit sl-btn-outline"><?php esc_html_e('Submit Request', 'luxus-core'); ?></button>
                <?php wp_nonce_field( "sch_tour_action", "sch_tour_nonce" ); ?>
                <input type="hidden" id="schedule_action" name="schedule_action" value="send-schedule" />

            <?php } ?>
        </form>
        <?php
            // Print Errors
            if ( is_wp_error( $schedule_tour_error ) ) {
                echo '<div class="schedule-errors">';
                    foreach ( $schedule_tour_error->get_error_messages() as $error ) {
                        echo '<strong class="text-danger">'. esc_html__('Error:', 'luxus-core') .' </strong>' . $error . '<br/>';
                    }
                echo '</div>';
            }
        ?>
    </div>
</div>

<!-- Schedule Tour Succes Alert -->
<?php

if ( !empty($schedule_tour_msg_alert) && $schedule_tour_msg_alert == 'success' ) :
     echo '<script type="text/javascript">toastr.success("'. esc_html__('Schedule Tour Submited Successfully', 'luxus-core') .'");</script>';
endif;

// Schedule Tour Failed Alert
if ( !empty($schedule_tour_msg_alert) && $schedule_tour_msg_alert == 'failed' ) :
     echo '<script type="text/javascript">toastr.error("'. esc_html__('Schedule Tour Submited Failed!', 'luxus-core') .'");</script>';
endif;
