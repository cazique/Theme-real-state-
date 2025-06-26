<?php

// Delete Inbox Messages

$del_msg_alert = array();

if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'delete-message' )
{

    if ( isset( $_POST['delete_id'] ) ) {
        $msg_del_id = $_POST['delete_id'];
    }else{
        $msg_del_id = null;
    }

    if ( isset( $_POST['receiver_id'] ) ) {
        $msg_receiver_id = $_POST['receiver_id'];
    }else{
        $msg_receiver_id = null;
    }

    if ( !$msg_del_id == null && $msg_receiver_id == $current_user->ID ) {

        $table = $wpdb->prefix . 'luxus_messages';

        $success = $wpdb->update( $table,
            array( 'del_receiver' => 1 ),
            array( 'id' => $msg_del_id ),
            array( '%d' ),
            array( '%d' )
        );

        if($success){

            $del_msg_alert['success'] = __('Message Deleated Successfully!', 'luxus-core');

        }else{

            $del_msg_alert ['error'] = __('Error: Sorry! Message not delete.', 'luxus-core');

        }
    }
}