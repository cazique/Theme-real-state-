<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * Template Name: Message Detail
 */

// Custom Page Title
function luxus_message_detail_page_title() {
    return esc_html__('Message Detail', 'luxus-core') . ' - ' . get_bloginfo();
}
add_action( 'pre_get_document_title', 'luxus_message_detail_page_title' );

global $wpdb;

$current_user = wp_get_current_user();

if ( isset( $_GET['msg'] ) ) {
    $msg = $_GET['msg'];
}else{
    $msg = null;
}
if ( isset( $_GET['id'] ) ) {
    $msg_id = $_GET['id'];
}else{
    $msg_id = null;
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

if ( $msg == 'inbox' || $msg == 'sent' && !$msg_id == null ) {

// Custom User Header
require dirname( __FILE__ ) . '/template-parts/header-user.php';

?>

<!-- Main Content -->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="heading-one"><?php esc_html_e('Message Detail', 'luxus-core'); ?></h2>
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

                    $table_name = $wpdb->prefix . "luxus_messages";
                    // this will get the data from your table
                    $message = $wpdb->get_results( "SELECT * FROM $table_name WHERE id = $msg_id" );

                    if ( count($message)> 0 ) {

                        $sender_phone = $message[0]->sender_phone;

                    ?>
                        <div class="message-detail">
                            <div class="msg-top">
                            <?php

                                if ( $msg == 'inbox' ) {

                                    $sender_data = get_userdata( $message[0]->sender_id );
                                    $sender_fn = $sender_data->first_name;
                                    $sender_ln = $sender_data->last_name;
                                    $email = $sender_data->user_email;

                                    $msg_receiver_id = $sender_data->ID;

                                    echo '<div class="name"><strong>'. esc_html($sender_fn) .' '. esc_html($sender_ln) .'</strong></div>';
                                }

                                if ( $msg == 'sent' ) {

                                    $receiver_data = get_userdata( $message[0]->receiver_id );
                                    $receiver_fn = $receiver_data->first_name;
                                    $receiver_ln = $receiver_data->last_name;
                                    $email = $receiver_data->user_email;

                                    $msg_receiver_id = $receiver_data->ID;

                                    echo '<div class="name"><strong>'. esc_html($receiver_fn) .' '. esc_html($receiver_ln) .'</strong></div>';
                                }

                                echo '<div class="time">' . esc_html($message[0]->time) . '</div>';
                            ?>
                            </div>
                            <div class="msg-body">
                                <div class="contact">
                                    <?php 
                                        if ( $msg == 'inbox' && !$sender_phone == null ) {
                                            echo '<a href="tel:'. esc_url($sender_phone) .'" class="phone">'. esc_html($sender_phone) .'</a>';
                                        }

                                       echo '<a href="mailto:'. esc_url($email) .'" class="email">'. esc_html($email) .'</a>';
                                    ?>
                                </div>
                                <p><strong>Message:</strong></p>
                                <?php echo $message[0]->message; ?>
                            </div>
                            <div class="msg-form">
                                <p><strong>Reply:</strong></p>
                                <form action="" method="post">
                                    <input type="hidden" id="reciver_id" name="receiver_id" value="<?php echo esc_attr($msg_receiver_id); ?>" />

                                    <input type="hidden" id="sender_id" name="sender_id" value="<?php echo esc_attr($current_user_id); ?>" />

                                    <textarea class="form-control" id="sender_message" name="sender_message" value="<?php echo esc_attr( isset( $_POST['sender_message'] ) ? $sender_message : null ) ?>"placeholder="<?php esc_html_e('Message', 'luxus-core'); ?>"><?php echo esc_attr( isset( $_POST['sender_message'] ) ? $sender_message : null ) ?></textarea>

                                    <button type="submit" class="sl-btn-fill"><?php esc_html_e('Send Message', 'luxus-core'); ?></button>
                                    <?php wp_nonce_field( 'new-message' ) ?>
                                    <input type="hidden" id="action" name="action" value="send-message" />
                                </form>
                            </div>
                        </div>
                    <?php

                        $receiver_id = $message[0]->receiver_id;

                        if ( $current_user->ID == $receiver_id ) {

                            $table = $wpdb->prefix . 'luxus_messages';

                            $wpdb->update( $table, array( 'status' => 'read' ), array( 'id' => $msg_id ), array( '%s' ), array( '%d' ) );
                        }

                    }else{
                        $url = home_url() . '/inbox';
                        echo "<h5>". esc_html__('Nothing Found!', 'luxus-core') ."</h5>";
                        echo "<a href='esc_url($url)' class='sl-btn-fill'>". esc_html__('Back to inbox', 'luxus-core') ."</a>";
                    }

                ?>

            </div>
        </div>
	</div>
</div>
<!-- Main Content End -->

<?php

}else{

   wp_redirect( home_url('/inbox') ); exit;
}

// Custom User Footer
require dirname( __FILE__ ) . '/template-parts/footer-user.php';
