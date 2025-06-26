<?php

// Contact User Form Request

$contact_user_table_name = $wpdb->prefix."luxus_messages";
$contact_user_msg_alert = '';
$contact_user_error = '';

$contact_notify_admin = luxus_options('contact-notify-admin');
$contact_notify_author = luxus_options('contact-notify-author');

$ptoperty_single_page = is_singular('property' );
$authot_single_page = is_author();

if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_message_action'] ) && $_POST['send_message_action'] == 'send-message' )
{
    global $contact_user_error;
    $contact_user_error = new WP_Error;

    $created_by = $current_user_id;

    $sender_phone_isset = sanitize_text_field( $_POST['sender_phone'] );
    $sender_message_isset = sanitize_text_field( $_POST['sender_message'] );

    if ( empty( $sender_phone_isset ) || empty( $sender_message_isset ) ) {
        $contact_user_error->add( 'field', __(' Please fill all Required fields.', 'luxus-core') );
    }
    if ( ! wp_verify_nonce( $_POST['user_message_nonce'], 'user_message_action' ) ) {
        $contact_user_error->add( 'nonce', __(' Something is wrong, Please try again.', 'luxus-core') );
    }

    if( !empty( $sender_phone_isset ) ) {
        $sender_phone = $sender_phone_isset;
    }else{
        $sender_phone = '';
    }

    if( !empty( $sender_message_isset ) ) {
        $sender_message = $sender_message_isset;
    }else{
        $sender_message = '';
    }

    if( isset( $_POST['sender_id'] ) AND !empty( $_POST['sender_id'] ) ) {
        $sender_id = sanitize_text_field( $_POST['sender_id'] );
    }
    else {
       $sender_id = '';    
    }

    if( isset( $_POST['receiver_id'] ) AND !empty( $_POST['receiver_id'] ) ) {
        $receiver_id = sanitize_text_field( $_POST['receiver_id'] );
    }
    else {
       $reciver_id = '';    
    }

    $time = current_time('mysql', 1);

    $data = array(
        'created_by' => $created_by,
        'sender_id' => $sender_id,
        'receiver_id' => $receiver_id,
        'sender_phone' => $sender_phone,
        'message' => $sender_message,
        'time' => $time,
    );

    //field formats: %s = string, %d = integer, %f = float
    // A string is a sequence of characters, like "Hello world!".
    // An integer data type is a non-decimal number between -2,147,483,648 and 2,147,483,647.

    $format = array(
        '%s', '%s', '%s', '%s', '%s', '%s'
    );

    if ( 1 > count( $contact_user_error->get_error_messages() ) ) {

        $success = $wpdb->insert( $contact_user_table_name, $data, $format );


        // Notify COntact Form Email to Admin and Agent/Agency

        if ( $contact_notify_author || $contact_notify_admin ) {

            if ( $contact_notify_author ) {

                $to = get_the_author_meta( 'user_email' ); // Author Email

            } else {

                $to = get_option( 'admin_email' ); // Admin Email

            }

            if ( $contact_notify_admin && $contact_notify_author ) {

                $cc = get_option( 'admin_email' ); // Admin Email

            } else {

                $cc = '';
            }

            if ( $ptoperty_single_page ) {

                $mial_page_text = get_the_title();
                $mial_page_link = get_permalink();

            } else {

                if ( $authot_single_page ) {

                    $author_data = get_user_by('slug', get_query_var('author_name'));

                    $mial_page_text = $author_data->first_name .' '. $author_data->last_name ;
                    $mial_page_link = get_author_posts_url( $author_data->ID );

                } 

            }
            
            $bcc = ''; // Bcc Email
            $from = $current_user_email; // From Email
            $subject = 'New Contact Form Message Recieved!'; //Email Subject
            
            // Message
            $template = 'You have a new Contact Form Message on <a href=' . $mial_page_link . '>' . $mial_page_text . '</a><br><br>
                <b>Name:</b> ' . $current_user_name . '<br>
                <b>Email:</b> ' . $current_user_email . '<br>
                <b>Phone:</b> ' .  $sender_phone . ' <br><br>
                <b>Message:</b><br> ' . $sender_message;
            
            // Send Email
            luxus_wp_mail( $from, $to, $subject, $template, $cc, $bcc);
        }

        // Success
        $contact_user_msg_alert = 'success';
        
        // Reset Form
        $sender_phone = '';
        $sender_message = '';

    }else{
        $contact_user_msg_alert = 'failed';
    }
}
