<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * Change Status of property in user dashboard
 */
add_action( 'init', 'luxus_change_post_status' );
function luxus_change_post_status() {
    //GET THE RESPONSE STATUS
    if( isset( $_GET[ 'change_status' ] ) ) {
        $status =  $_GET[ 'status' ];
        $postid =  $_GET[ 'postid' ];

        if( $status != '' && $postid != '' && $status != 'edit' && $status != 'delete' ) {
            wp_update_post(
                array(
                'ID'	=>	$postid,
                'post_status'	=>	$status
                )
            );

            if( $status == 'publish' ) {
                wp_redirect( 'published-properties' );
                exit;
            } else if( $status == 'pending' ) {
                wp_redirect( 'pending-properties' );
                exit;
            } else if( $status == 'draft' ) {
                wp_redirect( 'draft-properties' );
                exit;
            } else if( $status == 'trash' ) {
                wp_redirect( 'trash-properties' );
                exit;
            }
        } else if( $status == 'edit' ) {
            
            if ( current_user_can( 'edit_post', $postid ) ) {
                include_once esc_url(get_template_directory()) . '/user_content/edit_property.php';
               
               // wp_redirect('user-trash-properties');
                //exit;
            }
        } else if( $status == 'delete' ) {
        
            if ( current_user_can( 'edit_post', $postid ) ) {
                wp_delete_post( $postid );

                wp_redirect( 'trash-properties' );
                exit;
            }
        }
    }
}

/**
 * Block wp-admin access for non-admins
 */
add_action( 'admin_init', 'luxus_block_wp_admin' );
function luxus_block_wp_admin() {
	if ( is_admin() && ! current_user_can( 'administrator' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
		wp_safe_redirect( home_url( '/user-dashboard' ) );
		exit;
	}
}

/**
 * Hide admin bar for non-admins
 */
add_filter( 'show_admin_bar', 'luxus_hide_admin_bar' );
function luxus_hide_admin_bar( $show ) {
	if ( ! current_user_can( 'administrator' ) ) {
		return false;
	}

	return $show;
}

/**
 * Redirect users after login
 */
add_filter( 'login_redirect', 'luxus_login_redirect' );
function luxus_login_redirect( $url ) {
    return esc_url(home_url( '/user-dashboard' ));
}

/**
 * Redirect users after logout
 */
add_filter( 'logout_redirect', 'luxus_logout_redirect' );
function luxus_logout_redirect( $url ) {
    return esc_url(home_url());
}

/**
 * Add Upload file capability to users
 */
add_action( 'admin_init', 'luxus_agency_upload_file_cap');
function luxus_agency_upload_file_cap() {
    // gets the agency role
    $role = get_role( 'agency' );

    $role->add_cap( 'upload_files' ); 
}

add_action( 'admin_init', 'luxus_agent_upload_file_cap');
function luxus_agent_upload_file_cap() {
    // gets the agent role
    $role = get_role( 'agent' );

    $role->add_cap( 'upload_files' );
    $role->add_cap('unfiltered_upload');
}

/**
 * Limit media library access
 */
add_filter( 'posts_where', 'luxus_hide_media_by_other' );
function luxus_hide_media_by_other( $where ){
    global $current_user;

    if( is_user_logged_in() ){
         // logged in user, but are we viewing the library?
         if( isset( $_POST['action'] ) && ( $_POST['action'] == 'query-attachments' ) ){
            // here you can add some extra logic if you'd want to.
            $where .= ' AND post_author='.$current_user->data->ID;
        }
    }

    return $where;
}