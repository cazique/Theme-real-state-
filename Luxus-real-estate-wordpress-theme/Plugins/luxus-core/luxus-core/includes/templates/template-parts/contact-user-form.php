<?php

// Contact User Form Action

require dirname( __FILE__ ) . '/contact-user-form-action.php';

?>

<!-- Contact User Form -->
<div id="noPrintableArea" class="sl-box contect-agent">
    <h6 class="heading"><?php esc_html_e('Contact with', 'luxus-core'); ?> <span><?php echo esc_html($author_info->display_name); ?></span></h6>
    <div class="contect-form">
        <form id="contact_user_form" action="" method="post">
            <input type="hidden" id="reciver_id" name="receiver_id" value="<?php echo esc_attr($author_id); ?>" />
            <input type="hidden" id="sender_id" name="sender_id" value="<?php echo esc_attr($current_user_id); ?>" />

            <?php if( !is_user_logged_in() ) { ?>

                <input type="text" class="form-control" id="sender_name" placeholder="<?php esc_attr_e('Name', 'luxus-core'); ?>">

                <input type="text" class="form-control" id="sender_email" placeholder="<?php esc_attr_e('Email', 'luxus-core'); ?>">

            <?php } else {
                echo "<p>". esc_html__('Logged in as', 'luxus-core') ." <strong>". esc_html($current_user_name) ."</strong></p>";
            } ?>

            <input type="text" class="form-control" id="sender_phone" name="sender_phone" value="<?php echo esc_attr( isset( $_POST['sender_phone'] ) ? $sender_phone : null ) ?>" placeholder="<?php esc_attr_e('Phone', 'luxus-core'); ?>">

            <textarea class="form-control" id="sender_message" name="sender_message" value="<?php echo esc_attr( isset( $_POST['sender_message'] ) ? $sender_message : null ) ?>"placeholder="<?php esc_attr_e('Message', 'luxus-core'); ?>"><?php echo esc_html( isset( $_POST['sender_message'] ) ? $sender_message : null ) ?></textarea>

            <?php if( !is_user_logged_in() ) {

                echo "<a href='' class='sl-ajax-login sl-btn-fill'>". esc_html__('Send Message', 'luxus-core') ."</a>";

            } else { ?>
                
                <button type="submit" class="sl-btn-fill"><?php esc_html_e('Send Message', 'luxus-core'); ?></button>
                <?php wp_nonce_field( "user_message_action", "user_message_nonce" ); ?>
                <input type="hidden" id="send_message_action" name="send_message_action" value="send-message" />

            <?php } ?>
        </form>
        <?php
            // Print Errors
            if ( is_wp_error( $contact_user_error ) ) {
                echo '<div class="contact-user-errors">';
                    foreach ( $contact_user_error->get_error_messages() as $error ) {
                        echo '<strong class="text-danger">'. esc_html__('Error:', 'luxus-core') .' </strong>' . $error . '<br/>';
                    }
                echo '</div>';
            }
        ?>
    </div>
</div>

<!-- Contact User Succes Alert -->
<?php

if ( !empty($contact_user_msg_alert) && $contact_user_msg_alert == 'success' ) :
    echo '<script type="text/javascript">toastr.success("'. esc_html__('Message Sent Successfully.', 'luxus-core') .'");</script>';
endif;

// Contact User Failed Alert
if ( !empty($contact_user_msg_alert) && $contact_user_msg_alert == 'failed' ) :
     echo '<script type="text/javascript">toastr.error("'. esc_html__('Message Sent Failed!', 'luxus-core') .'");</script>';
endif;
