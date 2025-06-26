<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * Template Name: Schedule Tour Detail
 */

// Custom Page Title
function luxus_schedule_detail_page_title() {
    return esc_html__('Schedule Tour Detail', 'luxus-core') . ' - ' . get_bloginfo();
}
add_action( 'pre_get_document_title', 'luxus_schedule_detail_page_title' );

global $wpdb;

$current_user = wp_get_current_user();

if ( isset( $_GET['sch'] ) ) {
    $sch = $_GET['sch'];
}else{
    $sch = null;
}
if ( isset( $_GET['id'] ) ) {
    $sch_id = $_GET['id'];
}else{
    $sch_id = null;
}

$current_user_id = $current_user->ID;

$tablename = $wpdb->prefix."luxus_messages";

if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'send-message' )
{
    $created_by = $current_user_id;

    if( isset( $_POST['sender_id'] ) AND !empty( $_POST['sender_id'] ) ) {
        $sender_id = $_POST['sender_id'];
    }
    else {
       $sender_id = '';    
    }

    if( isset( $_POST['receiver_id'] ) AND !empty( $_POST['receiver_id'] ) ) {
        $receiver_id = $_POST['receiver_id'];
    }
    else {
       $reciver_id = '';    
    }

    if( isset( $_POST['sender_message'] ) AND !empty( $_POST['sender_message'] ) ) {
        $sender_message = $_POST['sender_message'];
    }
    else {
       $sender_message = '';    
    }

    $time = current_time('mysql', 1);

    $data = array(
        'created_by' => $created_by,
        'sender_id' => $sender_id,
        'receiver_id' => $receiver_id,
        'message' => $sender_message,
        'time' => $time,
    );

    if ( !empty( $sender_message ) ) {

        //field formats: %s = string, %d = integer, %f = float
        // A string is a sequence of characters, like "Hello world!".
        // An integer data type is a non-decimal number between -2,147,483,648 and 2,147,483,647.

        $format = array(
            '%s', '%s', '%s', '%s', '%s'
        );

        $success = $wpdb->insert( $tablename, $data, $format );

    } else {

        $success = '';

    }

    if($success){
        $sent_msg_alert['success'] = __('Message Sent Successfully!', 'luxus-core');
        $sender_message = '';

    }else{
        $sent_msg_alert ['error'] = __('Error: Message Sent Failed!', 'luxus-core');
    }
}


if ( $sch == 'inbox' || $sch == 'sent' && !$sch_id == null ) {

// Custom User Header
require dirname( __FILE__ ) . '/template-parts/header-user.php';

?>

<!-- Main Content -->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="heading-one"><?php esc_html_e('Schedule Tour Detail', 'luxus-core'); ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <?php

                    $sent_msg_success = isset($sent_msg_alert['success']) ? $sent_msg_alert['success'] : null;
                    if( !$sent_msg_success == null ){

                        echo '<script type="text/javascript">toastr.success("'. __('Message Sent Successfully.', 'luxus-core') .'");</script>';
                    }

                    $sent_msg_failed = isset($sent_msg_alert['error']) ? $sent_msg_alert['error'] : null;
                    if( !$sent_msg_failed == null ){

                        echo '<script type="text/javascript">toastr.error("'. __('Message Sent Failed!', 'luxus-core') .'");</script>';
                    }

                    $table_name = $wpdb->prefix . "luxus_schedule_tour";
                    // this will get the data from your table
                    $schedule = $wpdb->get_results( "SELECT * FROM $table_name WHERE id = $sch_id" );

                    if ( count($schedule)> 0 ) {

                        $sender_phone = $schedule[0]->sender_phone;
                        $property_id = $schedule[0]->property_id;
                        $property_title = get_the_title( $property_id );
                        $property_link = get_post_permalink( $property_id );

                    ?>
                        <div class="message-detail">
                            <div class="msg-top">
                            <?php

                                $sender_data = get_userdata( $schedule[0]->sender_id );
                                $sender_fn = $sender_data->first_name;
                                $sender_ln = $sender_data->last_name;
                                $email = $sender_data->user_email;

                                $sch_receiver_id = $sender_data->ID;

                                if ( $sch == 'inbox' ) {

                                    $sender_data = get_userdata( $schedule[0]->sender_id );
                                    $sender_fn = $sender_data->first_name;
                                    $sender_ln = $sender_data->last_name;
                                    $email = $sender_data->user_email;

                                    $sch_receiver_id = $sender_data->ID;

                                    echo '<div class="name"><strong>'.$sender_fn .' '.$sender_ln.'</strong></div>';
                                }

                                if ( $sch == 'sent' ) {

                                    $receiver_data = get_userdata( $schedule[0]->receiver_id );
                                    $receiver_fn = $receiver_data->first_name;
                                    $receiver_ln = $receiver_data->last_name;
                                    $email = $receiver_data->user_email;

                                    $sch_receiver_id = $receiver_data->ID;

                                    echo '<div class="name"><strong>'. esc_html($receiver_fn) .' '. esc_html($receiver_ln) .'</strong></div>';
                                }

                                echo '<div class="time">' . esc_html($schedule[0]->time) . '</div>';
                            ?>
                            </div>
                            <div class="msg-body">
                                <div class="contact">
                                    <?php 
                                        if ( $sch == 'inbox' && !$sender_phone == null ) {
                                            echo '<a href="tel:'. esc_url($sender_phone) .'" class="phone">'. esc_html($sender_phone) .'</a>';
                                        }

                                       echo '<a href="mailto:'. esc_url($email) .'" class="email">'. esc_html($email) .'</a>';
                                    ?>
                                </div>

                                <p><strong><?php esc_html_e('Tour Date:', 'luxus-core'); ?> </strong><?php echo esc_html($schedule[0]->tour_date); ?></p>
                                <p><strong><?php esc_html_e('Tour Time:', 'luxus-core'); ?> </strong><?php echo esc_html($schedule[0]->tour_time); ?></p>
                                <p><strong><?php esc_html_e('Property:', 'luxus-core'); ?> </strong><a href="<?php echo esc_url($property_link); ?>"><?php echo esc_html($property_title); ?></a></p>

                                <p><strong><?php esc_html_e('Message:', 'luxus-core'); ?> </strong></p>
                                <?php echo $schedule[0]->message; ?>
                            </div>
                            <div class="msg-form">
                                <p><strong><?php esc_html_e('Reply:', 'luxus-core'); ?></strong></p>
                                <form action="" method="post">
                                    <input type="hidden" id="reciver_id" name="receiver_id" value="<?php echo esc_attr($sch_receiver_id); ?>" />

                                    <input type="hidden" id="sender_id" name="sender_id" value="<?php echo esc_attr($current_user_id); ?>" />

                                    <textarea class="form-control" id="sender_message" name="sender_message" value="<?php echo esc_attr( isset( $_POST['sender_message'] ) ? $sender_message : null ) ?>"placeholder="<?php esc_attr_e('Message', 'luxus-core'); ?>"><?php echo esc_attr( isset( $_POST['sender_message'] ) ? $sender_message : null ) ?></textarea>

                                    <button type="submit" class="sl-btn-fill"><?php esc_html_e('Send Message', 'luxus-core'); ?></button>
                                    <?php wp_nonce_field( 'new-message' ) ?>
                                    <input type="hidden" id="action" name="action" value="send-message" />
                                </form>
                            </div>
                        </div>
                    <?php

                        $receiver_id = $schedule[0]->receiver_id;

                        if ( $current_user->ID == $receiver_id ) {

                            $table = $wpdb->prefix . 'luxus_schedule_tour';

                            $wpdb->update( $table, array( 'status' => 'read' ), array( 'id' => $sch_id ), array( '%s' ), array( '%d' ) );
                        }

                    }else{
                        $url = home_url() . '/schedules';
                        echo "<h5>". esc_html__('Nothing Found!', 'luxus-core') ."</h5>";
                        echo "<a href='$url' class='sl-btn-fill'>". esc_html__('Back to schedule tours', 'luxus-core') ."</a>";
                    }
                ?>
            </div>
        </div>
	</div>
</div>
<!-- Main Content End -->

<?php

}else{

   wp_redirect( home_url('/schedules') ); exit;
}

// Custom User Footer
require dirname( __FILE__ ) . '/template-parts/footer-user.php';