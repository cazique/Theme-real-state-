<?php

// Delete Sent Schedule

$del_sch_alert = array();

if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'delete-schedule' )
{

    if ( isset( $_POST['delete_id'] ) ) {
        $sch_del_id = $_POST['delete_id'];
    }else{
        $sch_del_id = null;
    }

    if ( isset( $_POST['sender_id'] ) ) {
        $sch_sender_id = $_POST['sender_id'];
    }else{
        $sch_sender_id = null;
    }

    if ( !$sch_del_id == null && $sch_sender_id == $current_user->ID ) {

        $table = $wpdb->prefix . 'luxus_schedule_tour';

        $success = $wpdb->update( $table,
            array( 'del_sender' => 1 ),
            array( 'id' => $sch_del_id ),
            array( '%d' ),
            array( '%d' )
        );

        if($success){

            $del_sch_alert['success'] = __('Schedule Deleated Successfully!', 'luxus-core');

        }else{

            $del_sch_alert ['error'] = __('Error: Sorry! Schedule not delete.', 'luxus-core');

        }
    }
}