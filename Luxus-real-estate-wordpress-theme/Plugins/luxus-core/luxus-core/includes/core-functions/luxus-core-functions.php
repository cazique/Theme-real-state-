<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

// Luxus Custom wp_mail
if( !function_exists('luxus_wp_mail') ) {
 
    function luxus_wp_mail($from, $to, $subject, $template, $cc = null, $bcc = null) {
 
        $headers[] = 'From: '. $from . "\r\n";
        $headers[] = 'Reply-To: ' . $from . "\r\n";
 
        if (!empty($cc)) :
 
            if (is_array($cc)) :
 
                foreach ($cc as $key => $value) :
                    $headers[] = 'Cc: ' . $value . "\r\n";    
                endforeach;
 
            else:
                $headers[] = 'Cc: ' . $cc . "\r\n";    
            endif;
 
        endif;
 
 
        if (!empty($bcc)) :
             
            if (is_array($bcc)) :
 
                foreach ($bcc as $key => $value) :
                    $headers[] = 'Bcc: ' . $value . "\r\n";    
                endforeach;
 
            else:
                $headers[] = 'Bcc: ' . $bcc . "\r\n";    
            endif;
             
        endif;
 
        $headers[] = 'Content-Type: text/html; charset=UTF-8';
 
        $is_mail_sent = wp_mail($to, $subject, $template, $headers);
 
        return $is_mail_sent;
    }

}

// Custom function for get page meta
if ( ! function_exists( 'luxus_page_meta' ) ) {

  function luxus_page_meta( $key = '', $default = null ) {

    $meta = get_post_meta( get_the_ID(), 'sl_page_options', true );
    return ( isset( $meta[$key] ) ) ? $meta[$key] : $default;

  }

}

// Custom function for get post meta
if ( ! function_exists( 'luxus_post_meta' ) ) {

  function luxus_post_meta( $key = '', $id = '', $default = null ) {

    $get_the_id = ( !empty( $id ) ? $id : get_the_ID() );

    $meta = get_post_meta( $get_the_id, $key, true );
    return ( isset( $meta ) ) ? $meta : $default;

  }

}

// Custom function for get currency symbole
function luxus_currency_symbol() {

    if ( class_exists( 'CSF' ) ) {

        $curr_symbol_opt = luxus_options( 'property-currency' );
        $luxus_currency_symbol = !empty($curr_symbol_opt) ? $curr_symbol_opt : __( '$', 'luxus-core' );

    } else {

        $luxus_currency_symbol = __( '$', 'luxus-core' );

    }

    return $luxus_currency_symbol;
}

// Custom function for get area units
function luxus_area_units() {

    if ( class_exists( 'CSF' ) ) {

        $area_units_opt = luxus_options( 'property-area-units' );
        $luxus_area_units = !empty($area_units_opt) ? $area_units_opt : __( 'm²', 'luxus-core' );

    } else {

        $luxus_area_units = __( 'm²', 'luxus-core' );
        
    }

    return $luxus_area_units;
}

// Single Agent / Agency Properties Reditect (Pagination)
add_filter('redirect_canonical','luxus_redirect_single_page_agent');
function luxus_redirect_single_page_agent($redirect_url) {
    if (is_singular('agent')) $redirect_url = false;
    return $redirect_url;
}

add_filter('redirect_canonical','luxus_redirect_single_page_agency');
function luxus_redirect_single_page_agency($redirect_url) {
    if (is_singular('agency')) $redirect_url = false;
    return $redirect_url;
}

// User View Count
function luxus_set_user_view($user_id) {
    $profile_count_key = 'profile_views_count';
    $profile_count = get_user_meta( $user_id, $profile_count_key, true );
    if( $profile_count == '' ){
        $profile_count = 0;
        delete_user_meta( $user_id, $profile_count_key );
        add_user_meta( $user_id, $profile_count_key, '0' );
    } else {
        $profile_count++;
        update_user_meta( $user_id, $profile_count_key, $profile_count );
    }
}

// Post View Count
function luxus_set_post_view() {

    $key = 'post_views_count';

    $post_id = get_the_ID();

    $count = (int) get_post_meta( $post_id, $key, true );

    $count++;

    update_post_meta( $post_id, $key, $count );

}

function luxus_get_post_view() {

    $count = get_post_meta( get_the_ID(), 'post_views_count', true );

    return "$count views";

}

function luxus_posts_column_views( $columns ) {

    $columns['post_views'] = __('Views', 'luxus-core');

    return $columns;

}

add_filter( 'manage_posts_columns', 'luxus_posts_column_views' );
add_filter( 'manage_property_posts_columns', 'luxus_posts_column_views' );
add_filter( 'manage_agent_posts_columns', 'luxus_posts_column_views' );
add_filter( 'manage_agency_posts_columns', 'luxus_posts_column_views' );

function luxus_posts_custom_column_views( $column ) {

    if ( $column === 'post_views') {
        echo luxus_get_post_view();    
    }

}

add_action( 'manage_posts_custom_column', 'luxus_posts_custom_column_views' );
add_action( 'manage_property_posts_custom_column', 'luxus_posts_custom_column_views' );
add_action( 'manage_agent_posts_custom_column', 'luxus_posts_custom_column_views' );
add_action( 'manage_agency_posts_custom_column', 'luxus_posts_custom_column_views' );

function luxus_reviews_on( $data ) {

    if( $data['post_type'] == 'property' ) {

        $data['comment_status'] = "open";

    }

    return $data;

}

add_filter( 'wp_insert_post_data', 'luxus_reviews_on' );

// Lost / Forget Password
remove_filter( 'lostpassword_url', 'wc_lostpassword_url', 10 );

function luxus_reset_pass_url() {
    $siteURL = get_option('siteurl');
    return "{$siteURL}/wp-login.php?action=lostpassword";
}

add_filter( 'lostpassword_url', 'luxus_reset_pass_url', 10, 2 );

// Disable Postal Code Validation Woocommerce
function luxus_disable_postcode_validation( $address_fields ) {
    $address_fields['postcode']['required'] = false;
    return $address_fields;
}
add_filter( 'woocommerce_default_address_fields' , 'luxus_disable_postcode_validation' );

// Heart Property Localize Script
function luxus_heart_property_script(){

    wp_enqueue_script( 'luxus-core-localize', SL_PLUGIN_URL . 'public/js/luxus-core-localize.js', array( 'jquery' ) );
    wp_localize_script( 'luxus-core-localize', 'heart_property_object', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
    ));

}

add_action( 'wp_enqueue_scripts', 'luxus_heart_property_script' );

// Heart Property Action
function luxus_heart_property_action(){

    $property_id = $_POST['property_id'];

    if( is_user_logged_in() ) {
        // Current User ID
        $user_id    =  get_current_user_id();   
        
        $data_array = array();

        // Current User Meta
        $get_user_data = get_user_meta( $user_id, '_luxus_user_favourite_properties', TRUE );

        if (!empty($get_user_data)) {

            if ( in_array( $property_id, $get_user_data ) ) {

                $index = array_search( $property_id, $get_user_data );
                
                unset( $get_user_data[$index] );

                $get_user_data = array_values( $get_user_data );

                $data_array = $get_user_data;

                // Responce
                echo 'removed_from_favourite';

            }
            else {
                if( $get_user_data != NULL ) {
                    foreach ($get_user_data as $single_id) {
                        $data_array [] = $single_id;
                    }
                }

                $data_array[] = $property_id;

                // Responce
                echo 'marked_as_favourite';
            }

            // Updating User Meta
            update_user_meta( $user_id , '_luxus_user_favourite_properties', $data_array );

        } else {

            $data_array[] = $property_id;

            update_user_meta( $user_id , '_luxus_user_favourite_properties', $data_array );

        }
    }
    
    exit();
} 

add_action('wp_ajax_luxus_heart_property_action','luxus_heart_property_action');
add_action('wp_ajax_nopriv_luxus_heart_property_action','luxus_heart_property_action');

// Comapre Property Localize Script
function luxus_compare_property_script(){

    wp_enqueue_script( 'luxus-core-localize', SL_PLUGIN_URL . 'public/js/luxus-core-localize.js', array( 'jquery' ) );
    wp_localize_script( 'luxus-core-localize', 'compare_property_object', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
    ));

}

add_action( 'wp_enqueue_scripts', 'luxus_compare_property_script' );

// Compare Property Action
function luxus_compare_property_action(){ 

    $property_id = $_POST['property_id'];

    $data = '';
     
    if( !isset( $_COOKIE['luxus_compare_prop'] ) ) {
        $data = $data.$property_id;

        setcookie( 'luxus_compare_prop', $data,  time() + (86400), "/" ); // 86400 = 1 day
    }
    else {
        $data = $_COOKIE['luxus_compare_prop'];

        $exploded_data = explode( '|', $data );
        $exploded_data = array_filter( $exploded_data );

        if ( in_array( $property_id, $exploded_data ) ) {
            echo "already_added";
            exit();
        }
        elseif( count($exploded_data ) >= 3 ) {
            echo 'full';
            exit();
        }
        else {

            $data = $data.'|'.$property_id;
            setcookie( 'luxus_compare_prop', $data,  time() + (86400), "/" ); // 86400 = 1 day
        }
    }

    $data = $_COOKIE['luxus_compare_prop'];

    $exploded_data = explode( '|', $data );
    $exploded_data = array_filter( $exploded_data );
    $count = count( $exploded_data ) + 1;

    echo $count;
    exit();

} 

add_action('wp_ajax_luxus_compare_property_action','luxus_compare_property_action');
add_action('wp_ajax_nopriv_luxus_compare_property_action','luxus_compare_property_action');

// Delete Compare Property
function luxus_delete_compare_property() { 

    // Delete Compare Properties
    if( isset( $_GET['delete_compare_property'] ) ){
        
       $value = $_GET['delete_compare_property'];
       
       $property_id  = $_GET['property_id']; 

       if( $value == 'delete_cookie' ) {

            $cookie        = $_COOKIE['luxus_compare_prop'];
            $exploded_data = explode( '|', $cookie );
            
            $data = '';

            if( count( $exploded_data ) > 0 ) {

                $i = 1;

                foreach ( $exploded_data as $value ) {
                    if( $value != '' AND $property_id != $value ) {
                        $data = $data.'|'.$value;

                        $i++;
                    }
                }
                
                if( $data != '' ) {

                    setcookie( 'luxus_compare_prop', $data,  time() + (86400), "/" ); // 86400 = 1 day
                }
                else {
                    unset( $_COOKIE['luxus_compare_prop'] );
                    setcookie( "luxus_compare_prop", "", time() - 3600, "/" );
                }

                if( $data == '' ) {
                    echo wp_redirect(site_url('/properties'));
                    exit();
                }
                else {
                    echo wp_redirect(site_url('/compare-properties'));
                    exit();
                }
            }
       }
    }
}
add_action( 'init', 'luxus_delete_compare_property' );

// Properties Save Searches Localize Script
function luxus_save_searches_scripts(){

    wp_enqueue_script( 'luxus-core-localize', SL_PLUGIN_URL . 'public/js/luxus-core-localize.js', array( 'jquery' ) );
    wp_localize_script( 'luxus-core-localize', 'save_searches_object', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'loadingmessage' => esc_html__('Please wait ...', 'luxus-core')
    ));

}
add_action( 'wp_enqueue_scripts', 'luxus_save_searches_scripts' );

// Properties Save Searches Action
function luxus_save_search_action(){

    global $wpdb;

    $table_name = $wpdb->prefix . "save_searches";

    $saved_by = get_current_user_id();

    $formData = $_POST["formData"];

    $time = current_time('mysql', 1);

    $data = array(
        'saved_by' => $saved_by,
        'ss_data' => $formData,
        'time' => $time,
    );

    //field formats: %s = string, %d = integer, %f = float
    // A string is a sequence of characters, like "Hello world!".
    // An integer data type is a non-decimal number between -2,147,483,648 and 2,147,483,647.

    $format = array(
        '%s', '%s', '%s'
    );

    $success = $wpdb->insert( $table_name, $data, $format );

    if($success){

        $contact_msg_alert = esc_html__('Save Search Successfully!', 'luxus-core');

    }else{

        $contact_msg_alert = esc_html__('Save Search Failed!', 'luxus-core');

    }

    wp_die(); 
}
// Call when user logged in
add_action('wp_ajax_luxus_save_search_action', 'luxus_save_search_action');
// Call when user in not logged in
add_action('wp_ajax_nopriv_luxus_save_search_action', 'luxus_save_search_action');

// Properties Delete Searches Localize Script
function luxus_delete_searches_scripts(){

    wp_enqueue_script( 'luxus-core-localize', SL_PLUGIN_URL . 'public/js/luxus-core-localize.js', array( 'jquery' ) );
    wp_localize_script( 'luxus-core-localize', 'delete_searches_object', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' )
    ));

}
add_action( 'wp_enqueue_scripts', 'luxus_delete_searches_scripts' );

// Properties Delete Searches Action
function luxus_delete_search_action(){
    global $wpdb;

    $del_id = isset( $_POST["del_id"] ) ? $_POST["del_id"] : null;

    $table_name = $wpdb->prefix . "save_searches";

    if ( !$del_id == null ) {
        
        $wpdb->delete( $table_name , array( 'id' => $del_id ) );

    }

    wp_die(); 

}
// Call when user logged in
add_action('wp_ajax_luxus_delete_search_action', 'luxus_delete_search_action');
// Call when user in not logged in
add_action('wp_ajax_nopriv_luxus_delete_search_action', 'luxus_delete_search_action');

// Compare Property Script
add_action('wp_footer', 'luxus_compare_property_popup');
function luxus_compare_property_popup() {

    // Check If Compare Properties
    if( !isset( $_COOKIE['luxus_compare_prop'] ) ) {
        $props = '';
    }
    else {

        $data = $_COOKIE[ 'luxus_compare_prop' ];
        $exploded_data = explode( '|',$data );
        $exploded_data = array_filter( $exploded_data );
        $props =  count( $exploded_data );

    }

    $properties = ( $props != null  ? 'compare-animate' : '' );

    ?>

    <!-- Compare Properties Popup -->
    <a href="<?php echo esc_url( home_url( 'compare-properties' ) ); ?>">
        <div class="compaire-popup <?php echo esc_attr( $properties ); ?>">
            <span id="compare_icons"><?php echo esc_html( $props ); ?></span>
            <i class="sl-icon sl-compare"></i>
        </div>
    </a>

    <?php
}

// Updating CPT Term by getting post meta vale during Creating and updating post

add_action( 'wp_insert_post', 'luxus_update_cpt_term_from_meta_value', 10, 3 );
function luxus_update_cpt_term_from_meta_value($post_id, $post, $update) {

    if ( $post->post_type == 'property' ) {

        // Get Property Status Meta
        $property_status_meta = get_post_meta( $post_id, '_property_status', true );

        // Check if the meta has a value.
        if ( ! empty( $property_status_meta ) ) {

            // Update Status Taxonomy
            wp_set_post_terms( $post_id, $property_status_meta, 'property_status');
        }

        // Get Property Type Meta
        $property_type_meta = get_post_meta( $post_id, '_property_type', true );

        // Check if the meta has a value.
        if ( ! empty( $property_type_meta ) ) {

            // Update Type Taxonomy
            wp_set_post_terms( $post_id, $property_type_meta, 'property_type');
        }

        // Get Property City Meta
        $property_city_meta = get_post_meta( $post_id, '_property_city', true );

        // Check if the meta has a value.
        if ( ! empty( $property_city_meta ) ) {

            // Update City Taxonomy
            wp_set_post_terms( $post_id, $property_city_meta, 'property_city');
        }

        // Get Property Province Meta
        $property_state_meta = get_post_meta( $post_id, '_property_state', true );

        // Check if the meta has a value.
        if ( ! empty( $property_state_meta ) ) {

            // Update City Taxonomy
            wp_set_post_terms( $post_id, $property_state_meta, 'property_province');
        }

        // Get Property Country Meta
        $property_country_meta = get_post_meta( $post_id, '_property_country', true );

        // Check if the meta has a value.
        if ( ! empty( $property_country_meta ) ) {

            // Update City Taxonomy
            wp_set_post_terms( $post_id, $property_country_meta, 'property_country');
        }

    }

}

// Dash Icons For Ratings
function luxus_reviews_styles() {
    wp_enqueue_style( 'dashicons' );
}
add_action( 'wp_enqueue_scripts', 'luxus_reviews_styles' );

//Display the rating on a submitted comment.
function luxus_reviews_display_rating( $comment_text ){
    if ( $rating = get_comment_meta( get_comment_ID(), 'rating', true )  ) {
        $stars = '<p class="stars">';
        for ( $i = 1; $i <= $rating; $i++ ) {
            $stars .= '<span class="sl-icons sl-star-t"></span>';
        }
        $stars .= '</p>';
        $comment_text = $stars . $comment_text;
        return $comment_text;
    } else {
        return $comment_text;
    }
}
add_filter( 'comment_text', 'luxus_reviews_display_rating' );

//Get the average rating of a post.
function luxus_reviews_get_average_ratings() {
    global $post;
    $reviews = get_approved_comments( $post->ID );
    
    if ( $reviews ) {

        $total_reviews = 0;
        $total_rates = 0;
        foreach( $reviews as $review ){
            $rate = get_comment_meta( $review->comment_ID, 'rating', true );

            if( isset( $rate ) && '' !== $rate ) {
                $total_reviews++;
                $total_rates += $rate;
            }
        }

        if ( 0 === $total_reviews ) {
            $average_number = null;
        } else {
            $average_number = round( $total_rates / $total_reviews, 1 );
        }

        $stars   = '';
        $average = $average_number;

        for ( $i = 1; $i <= $average + 1; $i++ ) {
            
            $width = intval( $i - $average > 0 ? 20 - ( ( $i - $average ) * 20 ) : 20 );

            if ( 0 === $width ) {
                continue;
            }

            $stars .= '<span style="overflow:hidden; width:' . esc_attr($width) . 'px"><i class="sl-icons sl-star-t"></i></span>';

            if ( $i - $average > 0 ) {
                $stars .= '<span style="position:relative; left:-' . esc_attr($width) .'px; overflow:hidden;"><i class="sl-icons sl-star-o"></i></span>';
            }
        }
        
        $custom_content  = '<p class="average-rating">'. $stars .'</br>'. __('Average rating: ', 'luxus-core') . $average .'</p>';
        return $custom_content;

    } else {
        return false;
    }
}

// Pagination for Custom User Query
if ( !function_exists( 'luxus_user_query_pagination' ) ) {
    
    function luxus_user_query_pagination( $custom_query, $posts_per_page ) {

        $prev_arrow = is_rtl() ? '<i class="sl-icon sl-next-arrow"></i>' : '<i class="sl-icon sl-back-arrow"></i>';
        $next_arrow = is_rtl() ? '<i class="sl-icon sl-back-arrow"></i>' : '<i class="sl-icon sl-next-arrow"></i>';

        $total_query = $custom_query->total_users;
        $total_posts_per_page = $posts_per_page;
        $total_pages = ceil($total_query / $total_posts_per_page);
        $big = 999999999;

        if( $total_pages > 1 )  {

            echo '<div class="custom-pagination"><div class="sl-pagination">';

             if( !$current_page = get_query_var('paged') )
                 $current_page = 1;
             if( get_option('permalink_structure') ) {
                 $format = 'page/%#%/';
             } else {
                 $format = '&paged=%#%';
             }
            echo paginate_links(array(
                'base'          => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format'        => $format,
                'current'       => max( 1, get_query_var('paged') ),
                'total'         => $total_pages,
                'mid_size'      => 3,
                'type'          => 'plain',
                'prev_text'     => $prev_arrow,
                'next_text'     => $next_arrow,
             ) );

            echo '</div></div>';
        }
    }   
}

/**
 * Agents List
 */
function luxus_agents_list() {

    $agents = array();

    $args = array(
        'role'    => 'agent',
    );

    $users = get_users( $args );

    if ( count($users) > 0 ) {
        foreach ($users as $user) {
            $agents[$user->ID] = $user->display_name;
        }
    }

    return $agents;
}

/**
 * Countries List
 */
function luxus_countries_list() {

  $countries = array(
    'AF' => __( 'Afghanistan', 'luxus-core' ),
    'AX' => __( 'Åland Islands', 'luxus-core' ),
    'AL' => __( 'Albania', 'luxus-core' ),
    'DZ' => __( 'Algeria', 'luxus-core' ),
    'AS' => __( 'American Samoa', 'luxus-core' ),
    'AD' => __( 'Andorra', 'luxus-core' ),
    'AO' => __( 'Angola', 'luxus-core' ),
    'AI' => __( 'Anguilla', 'luxus-core' ),
    'AQ' => __( 'Antarctica', 'luxus-core' ),
    'AG' => __( 'Antigua and Barbuda', 'luxus-core' ),
    'AR' => __( 'Argentina', 'luxus-core' ),
    'AM' => __( 'Armenia', 'luxus-core' ),
    'AW' => __( 'Aruba', 'luxus-core' ),
    'AU' => __( 'Australia', 'luxus-core' ),
    'AT' => __( 'Austria', 'luxus-core' ),
    'AZ' => __( 'Azerbaijan', 'luxus-core' ),
    'BS' => __( 'Bahamas', 'luxus-core' ),
    'BH' => __( 'Bahrain', 'luxus-core' ),
    'BD' => __( 'Bangladesh', 'luxus-core' ),
    'BB' => __( 'Barbados', 'luxus-core' ),
    'BY' => __( 'Belarus', 'luxus-core' ),
    'BE' => __( 'Belgium', 'luxus-core' ),
    'PW' => __( 'Belau', 'luxus-core' ),
    'BZ' => __( 'Belize', 'luxus-core' ),
    'BJ' => __( 'Benin', 'luxus-core' ),
    'BM' => __( 'Bermuda', 'luxus-core' ),
    'BT' => __( 'Bhutan', 'luxus-core' ),
    'BO' => __( 'Bolivia', 'luxus-core' ),
    'BQ' => __( 'Bonaire, Saint Eustatius and Saba', 'luxus-core' ),
    'BA' => __( 'Bosnia and Herzegovina', 'luxus-core' ),
    'BW' => __( 'Botswana', 'luxus-core' ),
    'BV' => __( 'Bouvet Island', 'luxus-core' ),
    'BR' => __( 'Brazil', 'luxus-core' ),
    'IO' => __( 'British Indian Ocean Territory', 'luxus-core' ),
    'BN' => __( 'Brunei', 'luxus-core' ),
    'BG' => __( 'Bulgaria', 'luxus-core' ),
    'BF' => __( 'Burkina Faso', 'luxus-core' ),
    'BI' => __( 'Burundi', 'luxus-core' ),
    'KH' => __( 'Cambodia', 'luxus-core' ),
    'CM' => __( 'Cameroon', 'luxus-core' ),
    'CA' => __( 'Canada', 'luxus-core' ),
    'CV' => __( 'Cape Verde', 'luxus-core' ),
    'KY' => __( 'Cayman Islands', 'luxus-core' ),
    'CF' => __( 'Central African Republic', 'luxus-core' ),
    'TD' => __( 'Chad', 'luxus-core' ),
    'CL' => __( 'Chile', 'luxus-core' ),
    'CN' => __( 'China', 'luxus-core' ),
    'CX' => __( 'Christmas Island', 'luxus-core' ),
    'CC' => __( 'Cocos (Keeling) Islands', 'luxus-core' ),
    'CO' => __( 'Colombia', 'luxus-core' ),
    'KM' => __( 'Comoros', 'luxus-core' ),
    'CG' => __( 'Congo (Brazzaville)', 'luxus-core' ),
    'CD' => __( 'Congo (Kinshasa)', 'luxus-core' ),
    'CK' => __( 'Cook Islands', 'luxus-core' ),
    'CR' => __( 'Costa Rica', 'luxus-core' ),
    'HR' => __( 'Croatia', 'luxus-core' ),
    'CU' => __( 'Cuba', 'luxus-core' ),
    'CW' => __( 'Cura&ccedil;ao', 'luxus-core' ),
    'CY' => __( 'Cyprus', 'luxus-core' ),
    'CZ' => __( 'Czech Republic', 'luxus-core' ),
    'DK' => __( 'Denmark', 'luxus-core' ),
    'DJ' => __( 'Djibouti', 'luxus-core' ),
    'DM' => __( 'Dominica', 'luxus-core' ),
    'DO' => __( 'Dominican Republic', 'luxus-core' ),
    'EC' => __( 'Ecuador', 'luxus-core' ),
    'EG' => __( 'Egypt', 'luxus-core' ),
    'SV' => __( 'El Salvador', 'luxus-core' ),
    'GQ' => __( 'Equatorial Guinea', 'luxus-core' ),
    'ER' => __( 'Eritrea', 'luxus-core' ),
    'EE' => __( 'Estonia', 'luxus-core' ),
    'ET' => __( 'Ethiopia', 'luxus-core' ),
    'FK' => __( 'Falkland Islands', 'luxus-core' ),
    'FO' => __( 'Faroe Islands', 'luxus-core' ),
    'FJ' => __( 'Fiji', 'luxus-core' ),
    'FI' => __( 'Finland', 'luxus-core' ),
    'FR' => __( 'France', 'luxus-core' ),
    'GF' => __( 'French Guiana', 'luxus-core' ),
    'PF' => __( 'French Polynesia', 'luxus-core' ),
    'TF' => __( 'French Southern Territories', 'luxus-core' ),
    'GA' => __( 'Gabon', 'luxus-core' ),
    'GM' => __( 'Gambia', 'luxus-core' ),
    'GE' => __( 'Georgia', 'luxus-core' ),
    'DE' => __( 'Germany', 'luxus-core' ),
    'GH' => __( 'Ghana', 'luxus-core' ),
    'GI' => __( 'Gibraltar', 'luxus-core' ),
    'GR' => __( 'Greece', 'luxus-core' ),
    'GL' => __( 'Greenland', 'luxus-core' ),
    'GD' => __( 'Grenada', 'luxus-core' ),
    'GP' => __( 'Guadeloupe', 'luxus-core' ),
    'GU' => __( 'Guam', 'luxus-core' ),
    'GT' => __( 'Guatemala', 'luxus-core' ),
    'GG' => __( 'Guernsey', 'luxus-core' ),
    'GN' => __( 'Guinea', 'luxus-core' ),
    'GW' => __( 'Guinea-Bissau', 'luxus-core' ),
    'GY' => __( 'Guyana', 'luxus-core' ),
    'HT' => __( 'Haiti', 'luxus-core' ),
    'HM' => __( 'Heard Island and McDonald Islands', 'luxus-core' ),
    'HN' => __( 'Honduras', 'luxus-core' ),
    'HK' => __( 'Hong Kong', 'luxus-core' ),
    'HU' => __( 'Hungary', 'luxus-core' ),
    'IS' => __( 'Iceland', 'luxus-core' ),
    'IN' => __( 'India', 'luxus-core' ),
    'ID' => __( 'Indonesia', 'luxus-core' ),
    'IR' => __( 'Iran', 'luxus-core' ),
    'IQ' => __( 'Iraq', 'luxus-core' ),
    'IE' => __( 'Ireland', 'luxus-core' ),
    'IM' => __( 'Isle of Man', 'luxus-core' ),
    'IL' => __( 'Israel', 'luxus-core' ),
    'IT' => __( 'Italy', 'luxus-core' ),
    'CI' => __( 'Ivory Coast', 'luxus-core' ),
    'JM' => __( 'Jamaica', 'luxus-core' ),
    'JP' => __( 'Japan', 'luxus-core' ),
    'JE' => __( 'Jersey', 'luxus-core' ),
    'JO' => __( 'Jordan', 'luxus-core' ),
    'KZ' => __( 'Kazakhstan', 'luxus-core' ),
    'KE' => __( 'Kenya', 'luxus-core' ),
    'KI' => __( 'Kiribati', 'luxus-core' ),
    'KW' => __( 'Kuwait', 'luxus-core' ),
    'KG' => __( 'Kyrgyzstan', 'luxus-core' ),
    'LA' => __( 'Laos', 'luxus-core' ),
    'LV' => __( 'Latvia', 'luxus-core' ),
    'LB' => __( 'Lebanon', 'luxus-core' ),
    'LS' => __( 'Lesotho', 'luxus-core' ),
    'LR' => __( 'Liberia', 'luxus-core' ),
    'LY' => __( 'Libya', 'luxus-core' ),
    'LI' => __( 'Liechtenstein', 'luxus-core' ),
    'LT' => __( 'Lithuania', 'luxus-core' ),
    'LU' => __( 'Luxembourg', 'luxus-core' ),
    'MO' => __( 'Macao', 'luxus-core' ),
    'MK' => __( 'North Macedonia', 'luxus-core' ),
    'MG' => __( 'Madagascar', 'luxus-core' ),
    'MW' => __( 'Malawi', 'luxus-core' ),
    'MY' => __( 'Malaysia', 'luxus-core' ),
    'MV' => __( 'Maldives', 'luxus-core' ),
    'ML' => __( 'Mali', 'luxus-core' ),
    'MT' => __( 'Malta', 'luxus-core' ),
    'MH' => __( 'Marshall Islands', 'luxus-core' ),
    'MQ' => __( 'Martinique', 'luxus-core' ),
    'MR' => __( 'Mauritania', 'luxus-core' ),
    'MU' => __( 'Mauritius', 'luxus-core' ),
    'YT' => __( 'Mayotte', 'luxus-core' ),
    'MX' => __( 'Mexico', 'luxus-core' ),
    'FM' => __( 'Micronesia', 'luxus-core' ),
    'MD' => __( 'Moldova', 'luxus-core' ),
    'MC' => __( 'Monaco', 'luxus-core' ),
    'MN' => __( 'Mongolia', 'luxus-core' ),
    'ME' => __( 'Montenegro', 'luxus-core' ),
    'MS' => __( 'Montserrat', 'luxus-core' ),
    'MA' => __( 'Morocco', 'luxus-core' ),
    'MZ' => __( 'Mozambique', 'luxus-core' ),
    'MM' => __( 'Myanmar', 'luxus-core' ),
    'NA' => __( 'Namibia', 'luxus-core' ),
    'NR' => __( 'Nauru', 'luxus-core' ),
    'NP' => __( 'Nepal', 'luxus-core' ),
    'NL' => __( 'Netherlands', 'luxus-core' ),
    'NC' => __( 'New Caledonia', 'luxus-core' ),
    'NZ' => __( 'New Zealand', 'luxus-core' ),
    'NI' => __( 'Nicaragua', 'luxus-core' ),
    'NE' => __( 'Niger', 'luxus-core' ),
    'NG' => __( 'Nigeria', 'luxus-core' ),
    'NU' => __( 'Niue', 'luxus-core' ),
    'NF' => __( 'Norfolk Island', 'luxus-core' ),
    'MP' => __( 'Northern Mariana Islands', 'luxus-core' ),
    'KP' => __( 'North Korea', 'luxus-core' ),
    'NO' => __( 'Norway', 'luxus-core' ),
    'OM' => __( 'Oman', 'luxus-core' ),
    'PK' => __( 'Pakistan', 'luxus-core' ),
    'PS' => __( 'Palestinian Territory', 'luxus-core' ),
    'PA' => __( 'Panama', 'luxus-core' ),
    'PG' => __( 'Papua New Guinea', 'luxus-core' ),
    'PY' => __( 'Paraguay', 'luxus-core' ),
    'PE' => __( 'Peru', 'luxus-core' ),
    'PH' => __( 'Philippines', 'luxus-core' ),
    'PN' => __( 'Pitcairn', 'luxus-core' ),
    'PL' => __( 'Poland', 'luxus-core' ),
    'PT' => __( 'Portugal', 'luxus-core' ),
    'PR' => __( 'Puerto Rico', 'luxus-core' ),
    'QA' => __( 'Qatar', 'luxus-core' ),
    'RE' => __( 'Reunion', 'luxus-core' ),
    'RO' => __( 'Romania', 'luxus-core' ),
    'RU' => __( 'Russia', 'luxus-core' ),
    'RW' => __( 'Rwanda', 'luxus-core' ),
    'BL' => __( 'Saint Barth&eacute;lemy', 'luxus-core' ),
    'SH' => __( 'Saint Helena', 'luxus-core' ),
    'KN' => __( 'Saint Kitts and Nevis', 'luxus-core' ),
    'LC' => __( 'Saint Lucia', 'luxus-core' ),
    'MF' => __( 'Saint Martin (French part)', 'luxus-core' ),
    'SX' => __( 'Saint Martin (Dutch part)', 'luxus-core' ),
    'PM' => __( 'Saint Pierre and Miquelon', 'luxus-core' ),
    'VC' => __( 'Saint Vincent and the Grenadines', 'luxus-core' ),
    'SM' => __( 'San Marino', 'luxus-core' ),
    'ST' => __( 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe', 'luxus-core' ),
    'SA' => __( 'Saudi Arabia', 'luxus-core' ),
    'SN' => __( 'Senegal', 'luxus-core' ),
    'RS' => __( 'Serbia', 'luxus-core' ),
    'SC' => __( 'Seychelles', 'luxus-core' ),
    'SL' => __( 'Sierra Leone', 'luxus-core' ),
    'SG' => __( 'Singapore', 'luxus-core' ),
    'SK' => __( 'Slovakia', 'luxus-core' ),
    'SI' => __( 'Slovenia', 'luxus-core' ),
    'SB' => __( 'Solomon Islands', 'luxus-core' ),
    'SO' => __( 'Somalia', 'luxus-core' ),
    'ZA' => __( 'South Africa', 'luxus-core' ),
    'GS' => __( 'South Georgia/Sandwich Islands', 'luxus-core' ),
    'KR' => __( 'South Korea', 'luxus-core' ),
    'SS' => __( 'South Sudan', 'luxus-core' ),
    'ES' => __( 'Spain', 'luxus-core' ),
    'LK' => __( 'Sri Lanka', 'luxus-core' ),
    'SD' => __( 'Sudan', 'luxus-core' ),
    'SR' => __( 'Suriname', 'luxus-core' ),
    'SJ' => __( 'Svalbard and Jan Mayen', 'luxus-core' ),
    'SZ' => __( 'Eswatini', 'luxus-core' ),
    'SE' => __( 'Sweden', 'luxus-core' ),
    'CH' => __( 'Switzerland', 'luxus-core' ),
    'SY' => __( 'Syria', 'luxus-core' ),
    'TW' => __( 'Taiwan', 'luxus-core' ),
    'TJ' => __( 'Tajikistan', 'luxus-core' ),
    'TZ' => __( 'Tanzania', 'luxus-core' ),
    'TH' => __( 'Thailand', 'luxus-core' ),
    'TL' => __( 'Timor-Leste', 'luxus-core' ),
    'TG' => __( 'Togo', 'luxus-core' ),
    'TK' => __( 'Tokelau', 'luxus-core' ),
    'TO' => __( 'Tonga', 'luxus-core' ),
    'TT' => __( 'Trinidad and Tobago', 'luxus-core' ),
    'TN' => __( 'Tunisia', 'luxus-core' ),
    'TR' => __( 'Turkey', 'luxus-core' ),
    'TM' => __( 'Turkmenistan', 'luxus-core' ),
    'TC' => __( 'Turks and Caicos Islands', 'luxus-core' ),
    'TV' => __( 'Tuvalu', 'luxus-core' ),
    'UG' => __( 'Uganda', 'luxus-core' ),
    'UA' => __( 'Ukraine', 'luxus-core' ),
    'AE' => __( 'United Arab Emirates', 'luxus-core' ),
    'GB' => __( 'United Kingdom (UK)', 'luxus-core' ),
    'US' => __( 'United States (US)', 'luxus-core' ),
    'UM' => __( 'United States (US) Minor Outlying Islands', 'luxus-core' ),
    'UY' => __( 'Uruguay', 'luxus-core' ),
    'UZ' => __( 'Uzbekistan', 'luxus-core' ),
    'VU' => __( 'Vanuatu', 'luxus-core' ),
    'VA' => __( 'Vatican', 'luxus-core' ),
    'VE' => __( 'Venezuela', 'luxus-core' ),
    'VN' => __( 'Vietnam', 'luxus-core' ),
    'VG' => __( 'Virgin Islands (British)', 'luxus-core' ),
    'VI' => __( 'Virgin Islands (US)', 'luxus-core' ),
    'WF' => __( 'Wallis and Futuna', 'luxus-core' ),
    'EH' => __( 'Western Sahara', 'luxus-core' ),
    'WS' => __( 'Samoa', 'luxus-core' ),
    'YE' => __( 'Yemen', 'luxus-core' ),
    'ZM' => __( 'Zambia', 'luxus-core' ),
    'ZW' => __( 'Zimbabwe', 'luxus-core' ),
  );

  return $countries;
}

/**
 * Country Name
 */
function luxus_country_name( $country_key ) {

    $countries = luxus_countries_list();

    foreach ( $countries as $key => $value ) {

        if ( $key == $country_key ) {
            return $value;
        }
    }
}

/**
 * States List
 */
function luxus_states_list() {

    $states = array(
    'AF' => array( // Afghanistan states.

        'AF-BDS' => __( 'Badakhshan', 'luxus-core' ),
        'AF-BDG' => __( 'Badghis', 'luxus-core' ),
        'AF-BGL' => __( 'Baghlan', 'luxus-core' ),
        'AF-BAL' => __( 'Balkh', 'luxus-core' ),
        'AF-BAM' => __( 'Bamyan', 'luxus-core' ),
        'AF-DAY' => __( 'Daykundi', 'luxus-core' ),
        'AF-FRA' => __( 'Farah', 'luxus-core' ),
        'AF-FYB' => __( 'Faryab ', 'luxus-core' ),
        'AF-GHA' => __( 'Ghazni', 'luxus-core' ),
        'AF-GHO' => __( 'Ghor', 'luxus-core' ),
        'AF-HEL' => __( 'Helmand', 'luxus-core' ),
        'AF-HER' => __( 'Herat', 'luxus-core' ),
        'AF-JOW' => __( 'Jowzjan', 'luxus-core' ),
        'AF-KAB' => __( 'Kabul', 'luxus-core' ),
        'AF-KAN' => __( 'Kandahar', 'luxus-core' ),
        'AF-KAP' => __( 'Kapisa', 'luxus-core' ),
        'AF-KHO' => __( 'Khost', 'luxus-core' ),
        'AF-KNR' => __( 'Kunar', 'luxus-core' ),
        'AF-KDZ' => __( 'Kunduz', 'luxus-core' ),
        'AF-LAG' => __( 'Laghman', 'luxus-core' ),
        'AF-LOG' => __( 'Logar', 'luxus-core' ),
        'AF-NAN' => __( 'Nangarhar', 'luxus-core' ),
        'AF-NIM' => __( 'Nimruz', 'luxus-core' ),
        'AF-NUR' => __( 'Nuristan', 'luxus-core' ),
        'AF-PIA' => __( 'Paktia', 'luxus-core' ),
        'AF-PKA' => __( 'Paktika', 'luxus-core' ),
        'AF-PAN' => __( 'Panjshir', 'luxus-core' ),
        'AF-PAR' => __( 'Parwan', 'luxus-core' ),
        'AF-SAM' => __( 'Samangan', 'luxus-core' ),
        'AF-SAR' => __( 'Sar-e Pol', 'luxus-core' ),
        'AF-TAK' => __( 'Takhar', 'luxus-core' ),
        'AF-URU' => __( 'Uruzgan', 'luxus-core' ),
        'AF-WAR' => __( 'Wardak', 'luxus-core' ),
        'AF-ZAB' => __( 'Zabul', 'luxus-core' ),

    ),
    'AL' => array( // Albanian states.
        'AL-01' => __( 'Berat', 'luxus-core' ),
        'AL-09' => __( 'Dibër', 'luxus-core' ),
        'AL-02' => __( 'Durrës', 'luxus-core' ),
        'AL-03' => __( 'Elbasan', 'luxus-core' ),
        'AL-04' => __( 'Fier', 'luxus-core' ),
        'AL-05' => __( 'Gjirokastër', 'luxus-core' ),
        'AL-06' => __( 'Korçë', 'luxus-core' ),
        'AL-07' => __( 'Kukës', 'luxus-core' ),
        'AL-08' => __( 'Lezhë', 'luxus-core' ),
        'AL-10' => __( 'Shkodër', 'luxus-core' ),
        'AL-11' => __( 'Tirana', 'luxus-core' ),
        'AL-12' => __( 'Vlorë', 'luxus-core' ),
    ),
    'AO' => array( // Angolan states.
        'AO-BGO' => __( 'Bengo', 'luxus-core' ),
        'AO-BLU' => __( 'Benguela', 'luxus-core' ),
        'AO-BIE' => __( 'Bié', 'luxus-core' ),
        'AO-CAB' => __( 'Cabinda', 'luxus-core' ),
        'AO-CNN' => __( 'Cunene', 'luxus-core' ),
        'AO-HUA' => __( 'Huambo', 'luxus-core' ),
        'AO-HUI' => __( 'Huíla', 'luxus-core' ),
        'AO-CCU' => __( 'Kuando Kubango', 'luxus-core' ),
        'AO-CNO' => __( 'Kwanza-Norte', 'luxus-core' ),
        'AO-CUS' => __( 'Kwanza-Sul', 'luxus-core' ),
        'AO-LUA' => __( 'Luanda', 'luxus-core' ),
        'AO-LNO' => __( 'Lunda-Norte', 'luxus-core' ),
        'AO-LSU' => __( 'Lunda-Sul', 'luxus-core' ),
        'AO-MAL' => __( 'Malanje', 'luxus-core' ),
        'AO-MOX' => __( 'Moxico', 'luxus-core' ),
        'AO-NAM' => __( 'Namibe', 'luxus-core' ),
        'AO-UIG' => __( 'Uíge', 'luxus-core' ),
        'AO-ZAI' => __( 'Zaire', 'luxus-core' ),
    ),
    'AR' => array( // Argentinian provinces.
        'AR-C' => __( 'Ciudad Autónoma de Buenos Aires', 'luxus-core' ),
        'AR-B' => __( 'Buenos Aires', 'luxus-core' ),
        'AR-K' => __( 'Catamarca', 'luxus-core' ),
        'AR-H' => __( 'Chaco', 'luxus-core' ),
        'AR-U' => __( 'Chubut', 'luxus-core' ),
        'AR-X' => __( 'Córdoba', 'luxus-core' ),
        'AR-W' => __( 'Corrientes', 'luxus-core' ),
        'AR-E' => __( 'Entre Ríos', 'luxus-core' ),
        'AR-P' => __( 'Formosa', 'luxus-core' ),
        'AR-Y' => __( 'Jujuy', 'luxus-core' ),
        'AR-L' => __( 'La Pampa', 'luxus-core' ),
        'AR-F' => __( 'La Rioja', 'luxus-core' ),
        'AR-M' => __( 'Mendoza', 'luxus-core' ),
        'AR-N' => __( 'Misiones', 'luxus-core' ),
        'AR-Q' => __( 'Neuquén', 'luxus-core' ),
        'AR-R' => __( 'Río Negro', 'luxus-core' ),
        'AR-A' => __( 'Salta', 'luxus-core' ),
        'AR-J' => __( 'San Juan', 'luxus-core' ),
        'AR-D' => __( 'San Luis', 'luxus-core' ),
        'AR-Z' => __( 'Santa Cruz', 'luxus-core' ),
        'AR-S' => __( 'Santa Fe', 'luxus-core' ),
        'AR-G' => __( 'Santiago del Estero', 'luxus-core' ),
        'AR-V' => __( 'Tierra del Fuego', 'luxus-core' ),
        'AR-T' => __( 'Tucumán', 'luxus-core' ),
    ),
    'AT' => array( // Austria states.
        'AT-01' => __( 'Burgenland', 'luxus-core' ),
        'AT-02' => __( 'Carinthia (Kärnten)', 'luxus-core' ),
        'AT-03' => __( 'Lower Austria (Niederösterreich)', 'luxus-core' ),
        'AT-04' => __( 'Salzburg', 'luxus-core' ),
        'AT-05' => __( 'Styria (Steiermark)', 'luxus-core' ),
        'AT-06' => __( 'Tyrol (Tirol)', 'luxus-core' ),
        'AT-07' => __( 'Upper Austria (Oberösterreich)', 'luxus-core' ),
        'AT-08' => __( 'Vienna (Wien)', 'luxus-core' ),
        'AT-09' => __( 'Vorarlberg', 'luxus-core' ),
    ),
    'AU' => array( // Australian states.
        'AU-ACT' => __( 'Australian Capital Territory', 'luxus-core' ),
        'AU-NSW' => __( 'New South Wales', 'luxus-core' ),
        'AU-NT'  => __( 'Northern Territory', 'luxus-core' ),
        'AU-QLD' => __( 'Queensland', 'luxus-core' ),
        'AU-SA'  => __( 'South Australia', 'luxus-core' ),
        'AU-TAS' => __( 'Tasmania', 'luxus-core' ),
        'AU-VIC' => __( 'Victoria', 'luxus-core' ),
        'AU-WA'  => __( 'Western Australia', 'luxus-core' ),
    ),
    'AX' => array( // Åland Islands Municipalities
        'AX-BR' => __( 'Brändö', 'luxus-core' ),
        'AX-EC' => __( 'Eckerö', 'luxus-core' ),
        'AX-FN' => __( 'Finström', 'luxus-core' ),
        'AX-FG' => __( 'Föglö', 'luxus-core' ),
        'AX-GT' => __( 'Geta', 'luxus-core' ),
        'AX-HM' => __( 'Hammarland', 'luxus-core' ),
        'AX-JM' => __( 'Jomala', 'luxus-core' ),
        'AX-KK' => __( 'Kökar', 'luxus-core' ),
        'AX-KM' => __( 'Kumlinge', 'luxus-core' ),
        'AX-LM' => __( 'Lemland', 'luxus-core' ),
        'AX-LU' => __( 'Lumparland', 'luxus-core' ),
        'AX-MH' => __( 'Mariehamn', 'luxus-core' ),
        'AX-SV' => __( 'Saltvik', 'luxus-core' ),
        'AX-ST' => __( 'Sottunga', 'luxus-core' ),
        'AX-SD' => __( 'Sund', 'luxus-core' ),
        'AX-VR' => __( 'Vårdö', 'luxus-core' ),

    ),
    'BD' => array( // Bangladeshi districts.
        'BD-05' => __( 'Bagerhat', 'luxus-core' ),
        'BD-01' => __( 'Bandarban', 'luxus-core' ),
        'BD-02' => __( 'Barguna', 'luxus-core' ),
        'BD-06' => __( 'Barishal', 'luxus-core' ),
        'BD-07' => __( 'Bhola', 'luxus-core' ),
        'BD-03' => __( 'Bogura', 'luxus-core' ),
        'BD-04' => __( 'Brahmanbaria', 'luxus-core' ),
        'BD-09' => __( 'Chandpur', 'luxus-core' ),
        'BD-10' => __( 'Chattogram', 'luxus-core' ),
        'BD-12' => __( 'Chuadanga', 'luxus-core' ),
        'BD-11' => __( "Cox's Bazar", 'luxus-core' ),
        'BD-08' => __( 'Cumilla', 'luxus-core' ),
        'BD-13' => __( 'Dhaka', 'luxus-core' ),
        'BD-14' => __( 'Dinajpur', 'luxus-core' ),
        'BD-15' => __( 'Faridpur ', 'luxus-core' ),
        'BD-16' => __( 'Feni', 'luxus-core' ),
        'BD-19' => __( 'Gaibandha', 'luxus-core' ),
        'BD-18' => __( 'Gazipur', 'luxus-core' ),
        'BD-17' => __( 'Gopalganj', 'luxus-core' ),
        'BD-20' => __( 'Habiganj', 'luxus-core' ),
        'BD-21' => __( 'Jamalpur', 'luxus-core' ),
        'BD-22' => __( 'Jashore', 'luxus-core' ),
        'BD-25' => __( 'Jhalokati', 'luxus-core' ),
        'BD-23' => __( 'Jhenaidah', 'luxus-core' ),
        'BD-24' => __( 'Joypurhat', 'luxus-core' ),
        'BD-29' => __( 'Khagrachhari', 'luxus-core' ),
        'BD-27' => __( 'Khulna', 'luxus-core' ),
        'BD-26' => __( 'Kishoreganj', 'luxus-core' ),
        'BD-28' => __( 'Kurigram', 'luxus-core' ),
        'BD-30' => __( 'Kushtia', 'luxus-core' ),
        'BD-31' => __( 'Lakshmipur', 'luxus-core' ),
        'BD-32' => __( 'Lalmonirhat', 'luxus-core' ),
        'BD-36' => __( 'Madaripur', 'luxus-core' ),
        'BD-37' => __( 'Magura', 'luxus-core' ),
        'BD-33' => __( 'Manikganj ', 'luxus-core' ),
        'BD-39' => __( 'Meherpur', 'luxus-core' ),
        'BD-38' => __( 'Moulvibazar', 'luxus-core' ),
        'BD-35' => __( 'Munshiganj', 'luxus-core' ),
        'BD-34' => __( 'Mymensingh', 'luxus-core' ),
        'BD-48' => __( 'Naogaon', 'luxus-core' ),
        'BD-43' => __( 'Narail', 'luxus-core' ),
        'BD-40' => __( 'Narayanganj', 'luxus-core' ),
        'BD-42' => __( 'Narsingdi', 'luxus-core' ),
        'BD-44' => __( 'Natore', 'luxus-core' ),
        'BD-45' => __( 'Nawabganj', 'luxus-core' ),
        'BD-41' => __( 'Netrakona', 'luxus-core' ),
        'BD-46' => __( 'Nilphamari', 'luxus-core' ),
        'BD-47' => __( 'Noakhali', 'luxus-core' ),
        'BD-49' => __( 'Pabna', 'luxus-core' ),
        'BD-52' => __( 'Panchagarh', 'luxus-core' ),
        'BD-51' => __( 'Patuakhali', 'luxus-core' ),
        'BD-50' => __( 'Pirojpur', 'luxus-core' ),
        'BD-53' => __( 'Rajbari', 'luxus-core' ),
        'BD-54' => __( 'Rajshahi', 'luxus-core' ),
        'BD-56' => __( 'Rangamati', 'luxus-core' ),
        'BD-55' => __( 'Rangpur', 'luxus-core' ),
        'BD-58' => __( 'Satkhira', 'luxus-core' ),
        'BD-62' => __( 'Shariatpur', 'luxus-core' ),
        'BD-57' => __( 'Sherpur', 'luxus-core' ),
        'BD-59' => __( 'Sirajganj', 'luxus-core' ),
        'BD-61' => __( 'Sunamganj', 'luxus-core' ),
        'BD-60' => __( 'Sylhet', 'luxus-core' ),
        'BD-63' => __( 'Tangail', 'luxus-core' ),
        'BD-64' => __( 'Thakurgaon', 'luxus-core' ),
    ),
    'BG' => array( // Bulgarian states.
      'BG-01' => __( 'Blagoevgrad', 'luxus-core' ),
      'BG-02' => __( 'Burgas', 'luxus-core' ),
      'BG-08' => __( 'Dobrich', 'luxus-core' ),
      'BG-07' => __( 'Gabrovo', 'luxus-core' ),
      'BG-26' => __( 'Haskovo', 'luxus-core' ),
      'BG-09' => __( 'Kardzhali', 'luxus-core' ),
      'BG-10' => __( 'Kyustendil', 'luxus-core' ),
      'BG-11' => __( 'Lovech', 'luxus-core' ),
      'BG-12' => __( 'Montana', 'luxus-core' ),
      'BG-13' => __( 'Pazardzhik', 'luxus-core' ),
      'BG-14' => __( 'Pernik', 'luxus-core' ),
      'BG-15' => __( 'Pleven', 'luxus-core' ),
      'BG-16' => __( 'Plovdiv', 'luxus-core' ),
      'BG-17' => __( 'Razgrad', 'luxus-core' ),
      'BG-18' => __( 'Ruse', 'luxus-core' ),
      'BG-27' => __( 'Shumen', 'luxus-core' ),
      'BG-19' => __( 'Silistra', 'luxus-core' ),
      'BG-20' => __( 'Sliven', 'luxus-core' ),
      'BG-21' => __( 'Smolyan', 'luxus-core' ),
      'BG-23' => __( 'Sofia', 'luxus-core' ),
      'BG-22' => __( 'Sofia-Grad', 'luxus-core' ),
      'BG-24' => __( 'Stara Zagora', 'luxus-core' ),
      'BG-25' => __( 'Targovishte', 'luxus-core' ),
      'BG-03' => __( 'Varna', 'luxus-core' ),
      'BG-04' => __( 'Veliko Tarnovo', 'luxus-core' ),
      'BG-05' => __( 'Vidin', 'luxus-core' ),
      'BG-06' => __( 'Vratsa', 'luxus-core' ),
      'BG-28' => __( 'Yambol', 'luxus-core' ),
    ),
    'BJ' => array( // Beninese states.
      'BJ-AL' => __( 'Alibori', 'luxus-core' ),
      'BJ-AK' => __( 'Atakora', 'luxus-core' ),
      'BJ-AQ' => __( 'Atlantique', 'luxus-core' ),
      'BJ-BO' => __( 'Borgou', 'luxus-core' ),
      'BJ-CO' => __( 'Collines', 'luxus-core' ),
      'BJ-KO' => __( 'Kouffo', 'luxus-core' ),
      'BJ-DO' => __( 'Donga', 'luxus-core' ),
      'BJ-LI' => __( 'Littoral', 'luxus-core' ),
      'BJ-MO' => __( 'Mono', 'luxus-core' ),
      'BJ-OU' => __( 'Ouémé', 'luxus-core' ),
      'BJ-PL' => __( 'Plateau', 'luxus-core' ),
      'BJ-ZO' => __( 'Zou', 'luxus-core' ),
    ),
    'BO' => array( // Bolivian states.
      'BO-B' => __( 'Beni', 'luxus-core' ),
      'BO-H' => __( 'Chuquisaca', 'luxus-core' ),
      'BO-C' => __( 'Cochabamba', 'luxus-core' ),
      'BO-L' => __( 'La Paz', 'luxus-core' ),
      'BO-O' => __( 'Oruro', 'luxus-core' ),
      'BO-N' => __( 'Pando', 'luxus-core' ),
      'BO-P' => __( 'Potosí', 'luxus-core' ),
      'BO-S' => __( 'Santa Cruz', 'luxus-core' ),
      'BO-T' => __( 'Tarija', 'luxus-core' ),
    ),
    'BR' => array( // Brazilian states.
      'BR-AC' => __( 'Acre', 'luxus-core' ),
      'BR-AL' => __( 'Alagoas', 'luxus-core' ),
      'BR-AP' => __( 'Amapá', 'luxus-core' ),
      'BR-AM' => __( 'Amazonas', 'luxus-core' ),
      'BR-BA' => __( 'Bahia', 'luxus-core' ),
      'BR-CE' => __( 'Ceará', 'luxus-core' ),
      'BR-DF' => __( 'Distrito Federal', 'luxus-core' ),
      'BR-ES' => __( 'Espírito Santo', 'luxus-core' ),
      'BR-GO' => __( 'Goiás', 'luxus-core' ),
      'BR-MA' => __( 'Maranhão', 'luxus-core' ),
      'BR-MT' => __( 'Mato Grosso', 'luxus-core' ),
      'BR-MS' => __( 'Mato Grosso do Sul', 'luxus-core' ),
      'BR-MG' => __( 'Minas Gerais', 'luxus-core' ),
      'BR-PA' => __( 'Pará', 'luxus-core' ),
      'BR-PB' => __( 'Paraíba', 'luxus-core' ),
      'BR-PR' => __( 'Paraná', 'luxus-core' ),
      'BR-PE' => __( 'Pernambuco', 'luxus-core' ),
      'BR-PI' => __( 'Piauí', 'luxus-core' ),
      'BR-RJ' => __( 'Rio de Janeiro', 'luxus-core' ),
      'BR-RN' => __( 'Rio Grande do Norte', 'luxus-core' ),
      'BR-RS' => __( 'Rio Grande do Sul', 'luxus-core' ),
      'BR-RO' => __( 'Rondônia', 'luxus-core' ),
      'BR-RR' => __( 'Roraima', 'luxus-core' ),
      'BR-SC' => __( 'Santa Catarina', 'luxus-core' ),
      'BR-SP' => __( 'São Paulo', 'luxus-core' ),
      'BR-SE' => __( 'Sergipe', 'luxus-core' ),
      'BR-TO' => __( 'Tocantins', 'luxus-core' ),
    ),
    'CA' => array( // Canadian states.
      'CA-AB' => __( 'Alberta', 'luxus-core' ),
      'CA-BC' => __( 'British Columbia', 'luxus-core' ),
      'CA-MB' => __( 'Manitoba', 'luxus-core' ),
      'CA-NB' => __( 'New Brunswick', 'luxus-core' ),
      'CA-NL' => __( 'Newfoundland and Labrador', 'luxus-core' ),
      'CA-NT' => __( 'Northwest Territories', 'luxus-core' ),
      'CA-NS' => __( 'Nova Scotia', 'luxus-core' ),
      'CA-NU' => __( 'Nunavut', 'luxus-core' ),
      'CA-ON' => __( 'Ontario', 'luxus-core' ),
      'CA-PE' => __( 'Prince Edward Island', 'luxus-core' ),
      'CA-QC' => __( 'Quebec', 'luxus-core' ),
      'CA-SK' => __( 'Saskatchewan', 'luxus-core' ),
      'CA-YT' => __( 'Yukon Territory', 'luxus-core' ),
    ),
    'CH' => array( // Swiss cantons.
      'CH-AG' => __( 'Aargau', 'luxus-core' ),
      'CH-AR' => __( 'Appenzell Ausserrhoden', 'luxus-core' ),
      'CH-AI' => __( 'Appenzell Innerrhoden', 'luxus-core' ),
      'CH-BL' => __( 'Basel-Landschaft', 'luxus-core' ),
      'CH-BS' => __( 'Basel-Stadt', 'luxus-core' ),
      'CH-BE' => __( 'Bern', 'luxus-core' ),
      'CH-FR' => __( 'Fribourg', 'luxus-core' ),
      'CH-GE' => __( 'Geneva', 'luxus-core' ),
      'CH-GL' => __( 'Glarus', 'luxus-core' ),
      'CH-GR' => __( 'Graubünden', 'luxus-core' ),
      'CH-JU' => __( 'Jura', 'luxus-core' ),
      'CH-LU' => __( 'Luzern', 'luxus-core' ),
      'CH-NE' => __( 'Neuchâtel', 'luxus-core' ),
      'CH-NW' => __( 'Nidwalden', 'luxus-core' ),
      'CH-OW' => __( 'Obwalden', 'luxus-core' ),
      'CH-SH' => __( 'Schaffhausen', 'luxus-core' ),
      'CH-SZ' => __( 'Schwyz', 'luxus-core' ),
      'CH-SO' => __( 'Solothurn', 'luxus-core' ),
      'CH-SG' => __( 'St. Gallen', 'luxus-core' ),
      'CH-TG' => __( 'Thurgau', 'luxus-core' ),
      'CH-TI' => __( 'Ticino', 'luxus-core' ),
      'CH-UR' => __( 'Uri', 'luxus-core' ),
      'CH-VS' => __( 'Valais', 'luxus-core' ),
      'CH-VD' => __( 'Vaud', 'luxus-core' ),
      'CH-ZG' => __( 'Zug', 'luxus-core' ),
      'CH-ZH' => __( 'Zürich', 'luxus-core' ),
    ),
    'CL' => array( // Chilean states.
      'CL-AI' => __( 'Aisén del General Carlos Ibañez del Campo', 'luxus-core' ),
      'CL-AN' => __( 'Antofagasta', 'luxus-core' ),
      'CL-AP' => __( 'Arica y Parinacota', 'luxus-core' ),
      'CL-AR' => __( 'La Araucanía', 'luxus-core' ),
      'CL-AT' => __( 'Atacama', 'luxus-core' ),
      'CL-BI' => __( 'Biobío', 'luxus-core' ),
      'CL-CO' => __( 'Coquimbo', 'luxus-core' ),
      'CL-LI' => __( 'Libertador General Bernardo O\'Higgins', 'luxus-core' ),
      'CL-LL' => __( 'Los Lagos', 'luxus-core' ),
      'CL-LR' => __( 'Los Ríos', 'luxus-core' ),
      'CL-MA' => __( 'Magallanes', 'luxus-core' ),
      'CL-ML' => __( 'Maule', 'luxus-core' ),
      'CL-NB' => __( 'Ñuble', 'luxus-core' ),
      'CL-RM' => __( 'Región Metropolitana de Santiago', 'luxus-core' ),
      'CL-TA' => __( 'Tarapacá', 'luxus-core' ),
      'CL-VS' => __( 'Valparaíso', 'luxus-core' ),
    ),
    'CN' => array( // Chinese states.
      'CN-1'  => __( 'Yunnan / 云南', 'luxus-core' ),
      'CN-2'  => __( 'Beijing / 北京', 'luxus-core' ),
      'CN-3'  => __( 'Tianjin / 天津', 'luxus-core' ),
      'CN-4'  => __( 'Hebei / 河北', 'luxus-core' ),
      'CN-5'  => __( 'Shanxi / 山西', 'luxus-core' ),
      'CN-6'  => __( 'Inner Mongolia / 內蒙古', 'luxus-core' ),
      'CN-7'  => __( 'Liaoning / 辽宁', 'luxus-core' ),
      'CN-8'  => __( 'Jilin / 吉林', 'luxus-core' ),
      'CN-9'  => __( 'Heilongjiang / 黑龙江', 'luxus-core' ),
      'CN-10' => __( 'Shanghai / 上海', 'luxus-core' ),
      'CN-11' => __( 'Jiangsu / 江苏', 'luxus-core' ),
      'CN-12' => __( 'Zhejiang / 浙江', 'luxus-core' ),
      'CN-13' => __( 'Anhui / 安徽', 'luxus-core' ),
      'CN-14' => __( 'Fujian / 福建', 'luxus-core' ),
      'CN-15' => __( 'Jiangxi / 江西', 'luxus-core' ),
      'CN-16' => __( 'Shandong / 山东', 'luxus-core' ),
      'CN-17' => __( 'Henan / 河南', 'luxus-core' ),
      'CN-18' => __( 'Hubei / 湖北', 'luxus-core' ),
      'CN-19' => __( 'Hunan / 湖南', 'luxus-core' ),
      'CN-20' => __( 'Guangdong / 广东', 'luxus-core' ),
      'CN-21' => __( 'Guangxi Zhuang / 广西壮族', 'luxus-core' ),
      'CN-22' => __( 'Hainan / 海南', 'luxus-core' ),
      'CN-23' => __( 'Chongqing / 重庆', 'luxus-core' ),
      'CN-24' => __( 'Sichuan / 四川', 'luxus-core' ),
      'CN-25' => __( 'Guizhou / 贵州', 'luxus-core' ),
      'CN-26' => __( 'Shaanxi / 陕西', 'luxus-core' ),
      'CN-27' => __( 'Gansu / 甘肃', 'luxus-core' ),
      'CN-28' => __( 'Qinghai / 青海', 'luxus-core' ),
      'CN-29' => __( 'Ningxia Hui / 宁夏', 'luxus-core' ),
      'CN-30' => __( 'Macao / 澳门', 'luxus-core' ),
      'CN-31' => __( 'Tibet / 西藏', 'luxus-core' ),
      'CN-32' => __( 'Xinjiang / 新疆', 'luxus-core' ),
    ),
    'CO' => array( // Colombian states.
      'CO-AMA' => __( 'Amazonas', 'luxus-core' ),
      'CO-ANT' => __( 'Antioquia', 'luxus-core' ),
      'CO-ARA' => __( 'Arauca', 'luxus-core' ),
      'CO-ATL' => __( 'Atlántico', 'luxus-core' ),
      'CO-BOL' => __( 'Bolívar', 'luxus-core' ),
      'CO-BOY' => __( 'Boyacá', 'luxus-core' ),
      'CO-CAL' => __( 'Caldas', 'luxus-core' ),
      'CO-CAQ' => __( 'Caquetá', 'luxus-core' ),
      'CO-CAS' => __( 'Casanare', 'luxus-core' ),
      'CO-CAU' => __( 'Cauca', 'luxus-core' ),
      'CO-CES' => __( 'Cesar', 'luxus-core' ),
      'CO-CHO' => __( 'Chocó', 'luxus-core' ),
      'CO-COR' => __( 'Córdoba', 'luxus-core' ),
      'CO-CUN' => __( 'Cundinamarca', 'luxus-core' ),
      'CO-DC' => __( 'Capital District', 'luxus-core' ),
      'CO-GUA' => __( 'Guainía', 'luxus-core' ),
      'CO-GUV' => __( 'Guaviare', 'luxus-core' ),
      'CO-HUI' => __( 'Huila', 'luxus-core' ),
      'CO-LAG' => __( 'La Guajira', 'luxus-core' ),
      'CO-MAG' => __( 'Magdalena', 'luxus-core' ),
      'CO-MET' => __( 'Meta', 'luxus-core' ),
      'CO-NAR' => __( 'Nariño', 'luxus-core' ),
      'CO-NSA' => __( 'Norte de Santander', 'luxus-core' ),
      'CO-PUT' => __( 'Putumayo', 'luxus-core' ),
      'CO-QUI' => __( 'Quindío', 'luxus-core' ),
      'CO-RIS' => __( 'Risaralda', 'luxus-core' ),
      'CO-SAN' => __( 'Santander', 'luxus-core' ),
      'CO-SAP' => __( 'San Andrés & Providencia', 'luxus-core' ),
      'CO-SUC' => __( 'Sucre', 'luxus-core' ),
      'CO-TOL' => __( 'Tolima', 'luxus-core' ),
      'CO-VAC' => __( 'Valle del Cauca', 'luxus-core' ),
      'CO-VAU' => __( 'Vaupés', 'luxus-core' ),
      'CO-VID' => __( 'Vichada', 'luxus-core' ),
    ),
    'CR' => array( // Costa Rican states.
      'CR-A' => __( 'Alajuela', 'luxus-core' ),
      'CR-C' => __( 'Cartago', 'luxus-core' ),
      'CR-G' => __( 'Guanacaste', 'luxus-core' ),
      'CR-H' => __( 'Heredia', 'luxus-core' ),
      'CR-L' => __( 'Limón', 'luxus-core' ),
      'CR-P' => __( 'Puntarenas', 'luxus-core' ),
      'CR-SJ' => __( 'San José', 'luxus-core' ),
    ),
    'DE' => array( // German states.
      'DE-BW' => __( 'Baden-Württemberg', 'luxus-core' ),
      'DE-BY' => __( 'Bavaria', 'luxus-core' ),
      'DE-BE' => __( 'Berlin', 'luxus-core' ),
      'DE-BB' => __( 'Brandenburg', 'luxus-core' ),
      'DE-HB' => __( 'Bremen', 'luxus-core' ),
      'DE-HH' => __( 'Hamburg', 'luxus-core' ),
      'DE-HE' => __( 'Hesse', 'luxus-core' ),
      'DE-MV' => __( 'Mecklenburg-Vorpommern', 'luxus-core' ),
      'DE-NI' => __( 'Lower Saxony', 'luxus-core' ),
      'DE-NW' => __( 'North Rhine-Westphalia', 'luxus-core' ),
      'DE-RP' => __( 'Rhineland-Palatinate', 'luxus-core' ),
      'DE-SL' => __( 'Saarland', 'luxus-core' ),
      'DE-SN' => __( 'Saxony', 'luxus-core' ),
      'DE-ST' => __( 'Saxony-Anhalt', 'luxus-core' ),
      'DE-SH' => __( 'Schleswig-Holstein', 'luxus-core' ),
      'DE-TH' => __( 'Thuringia', 'luxus-core' ),
    ),
    'DO' => array( // Dominican states.
      'DO-01' => __( 'Distrito Nacional', 'luxus-core' ),
      'DO-02' => __( 'Azua', 'luxus-core' ),
      'DO-03' => __( 'Baoruco', 'luxus-core' ),
      'DO-04' => __( 'Barahona', 'luxus-core' ),
      'DO-33' => __( 'Cibao Nordeste', 'luxus-core' ),
      'DO-34' => __( 'Cibao Noroeste', 'luxus-core' ),
      'DO-35' => __( 'Cibao Norte', 'luxus-core' ),
      'DO-36' => __( 'Cibao Sur', 'luxus-core' ),
      'DO-05' => __( 'Dajabón', 'luxus-core' ),
      'DO-06' => __( 'Duarte', 'luxus-core' ),
      'DO-08' => __( 'El Seibo', 'luxus-core' ),
      'DO-37' => __( 'El Valle', 'luxus-core' ),
      'DO-07' => __( 'Elías Piña', 'luxus-core' ),
      'DO-38' => __( 'Enriquillo', 'luxus-core' ),   
      'DO-09' => __( 'Espaillat', 'luxus-core' ),
      'DO-30' => __( 'Hato Mayor', 'luxus-core' ),
      'DO-19' => __( 'Hermanas Mirabal', 'luxus-core' ),
      'DO-39' => __( 'Higüamo', 'luxus-core' ),
      'DO-10' => __( 'Independencia', 'luxus-core' ),
      'DO-11' => __( 'La Altagracia', 'luxus-core' ),
      'DO-12' => __( 'La Romana', 'luxus-core' ),
      'DO-13' => __( 'La Vega', 'luxus-core' ),
      'DO-14' => __( 'María Trinidad Sánchez', 'luxus-core' ),
      'DO-28' => __( 'Monseñor Nouel', 'luxus-core' ),
      'DO-15' => __( 'Monte Cristi', 'luxus-core' ),
      'DO-29' => __( 'Monte Plata', 'luxus-core' ),
      'DO-40' => __( 'Ozama', 'luxus-core' ),
      'DO-16' => __( 'Pedernales', 'luxus-core' ),
      'DO-17' => __( 'Peravia', 'luxus-core' ),
      'DO-18' => __( 'Puerto Plata', 'luxus-core' ),
      'DO-20' => __( 'Samaná', 'luxus-core' ),
      'DO-21' => __( 'San Cristóbal', 'luxus-core' ),
      'DO-31' => __( 'San José de Ocoa', 'luxus-core' ),
      'DO-22' => __( 'San Juan', 'luxus-core' ),
      'DO-23' => __( 'San Pedro de Macorís', 'luxus-core' ),
      'DO-24' => __( 'Sánchez Ramírez', 'luxus-core' ),
      'DO-25' => __( 'Santiago', 'luxus-core' ),
      'DO-26' => __( 'Santiago Rodríguez', 'luxus-core' ),
      'DO-32' => __( 'Santo Domingo', 'luxus-core' ),
      'DO-41' => __( 'Valdesia', 'luxus-core' ),
      'DO-27' => __( 'Valverde', 'luxus-core' ),
      'DO-42' => __( 'Yuma', 'luxus-core' ),
    ),
    'DZ' => array( // Algerian states.
      'DZ-01' => __( 'Adrar', 'luxus-core' ),
      'DZ-02' => __( 'Chlef', 'luxus-core' ),
      'DZ-03' => __( 'Laghouat', 'luxus-core' ),
      'DZ-04' => __( 'Oum El Bouaghi', 'luxus-core' ),
      'DZ-05' => __( 'Batna', 'luxus-core' ),
      'DZ-06' => __( 'Béjaïa', 'luxus-core' ),
      'DZ-07' => __( 'Biskra', 'luxus-core' ),
      'DZ-08' => __( 'Béchar', 'luxus-core' ),
      'DZ-09' => __( 'Blida', 'luxus-core' ),
      'DZ-10' => __( 'Bouira', 'luxus-core' ),
      'DZ-11' => __( 'Tamanghasset', 'luxus-core' ),
      'DZ-12' => __( 'Tébessa', 'luxus-core' ),
      'DZ-13' => __( 'Tlemcen', 'luxus-core' ),
      'DZ-14' => __( 'Tiaret', 'luxus-core' ),
      'DZ-15' => __( 'Tizi Ouzou', 'luxus-core' ),
      'DZ-16' => __( 'Algiers', 'luxus-core' ),
      'DZ-17' => __( 'Djelfa', 'luxus-core' ),
      'DZ-18' => __( 'Jijel', 'luxus-core' ),
      'DZ-19' => __( 'Sétif', 'luxus-core' ),
      'DZ-20' => __( 'Saïda', 'luxus-core' ),
      'DZ-21' => __( 'Skikda', 'luxus-core' ),
      'DZ-22' => __( 'Sidi Bel Abbès', 'luxus-core' ),
      'DZ-23' => __( 'Annaba', 'luxus-core' ),
      'DZ-24' => __( 'Guelma', 'luxus-core' ),
      'DZ-25' => __( 'Constantine', 'luxus-core' ),
      'DZ-26' => __( 'Médéa', 'luxus-core' ),
      'DZ-27' => __( 'Mostaganem', 'luxus-core' ),
      'DZ-28' => __( 'M’Sila', 'luxus-core' ),
      'DZ-29' => __( 'Mascara', 'luxus-core' ),
      'DZ-30' => __( 'Ouargla', 'luxus-core' ),
      'DZ-31' => __( 'Oran', 'luxus-core' ),
      'DZ-32' => __( 'El Bayadh', 'luxus-core' ),
      'DZ-33' => __( 'Illizi', 'luxus-core' ),
      'DZ-34' => __( 'Bordj Bou Arréridj', 'luxus-core' ),
      'DZ-35' => __( 'Boumerdès', 'luxus-core' ),
      'DZ-36' => __( 'El Tarf', 'luxus-core' ),
      'DZ-37' => __( 'Tindouf', 'luxus-core' ),
      'DZ-38' => __( 'Tissemsilt', 'luxus-core' ),
      'DZ-39' => __( 'El Oued', 'luxus-core' ),
      'DZ-40' => __( 'Khenchela', 'luxus-core' ),
      'DZ-41' => __( 'Souk Ahras', 'luxus-core' ),
      'DZ-42' => __( 'Tipasa', 'luxus-core' ),
      'DZ-43' => __( 'Mila', 'luxus-core' ),
      'DZ-44' => __( 'Aïn Defla', 'luxus-core' ),
      'DZ-45' => __( 'Naama', 'luxus-core' ),
      'DZ-46' => __( 'Aïn Témouchent', 'luxus-core' ),
      'DZ-47' => __( 'Ghardaïa', 'luxus-core' ),
      'DZ-48' => __( 'Relizane', 'luxus-core' ),
    ),
    'EC' => array( // Ecuadorian states.
      'EC-A' => __( 'Azuay', 'luxus-core' ),
      'EC-B' => __( 'Bolívar', 'luxus-core' ),
      'EC-F' => __( 'Cañar', 'luxus-core' ),
      'EC-C' => __( 'Carchi', 'luxus-core' ),
      'EC-H' => __( 'Chimborazo', 'luxus-core' ),
      'EC-X' => __( 'Cotopaxi', 'luxus-core' ),
      'EC-O' => __( 'El Oro', 'luxus-core' ),
      'EC-E' => __( 'Esmeraldas', 'luxus-core' ),
      'EC-W' => __( 'Galápagos', 'luxus-core' ),
      'EC-G' => __( 'Guayas', 'luxus-core' ),
      'EC-I' => __( 'Imbabura', 'luxus-core' ),
      'EC-L' => __( 'Loja', 'luxus-core' ),
      'EC-R' => __( 'Los Ríos', 'luxus-core' ),
      'EC-M' => __( 'Manabí', 'luxus-core' ),
      'EC-S' => __( 'Morona-Santiago', 'luxus-core' ),
      'EC-N' => __( 'Napo', 'luxus-core' ),
      'EC-D' => __( 'Orellana', 'luxus-core' ),
      'EC-Y' => __( 'Pastaza', 'luxus-core' ),
      'EC-P' => __( 'Pichincha', 'luxus-core' ),
      'EC-SE' => __( 'Santa Elena', 'luxus-core' ),
      'EC-SD' => __( 'Santo Domingo de los Tsáchilas', 'luxus-core' ),
      'EC-U' => __( 'Sucumbíos', 'luxus-core' ),
      'EC-T' => __( 'Tungurahua', 'luxus-core' ),
      'EC-Z' => __( 'Zamora-Chinchipe', 'luxus-core' ),
    ),
    'EG' => array( // Egyptian states.
      'EG-ALX' => __( 'Alexandria', 'luxus-core' ),
      'EG-ASN' => __( 'Aswan', 'luxus-core' ),
      'EG-AST' => __( 'Asyut', 'luxus-core' ),
      'EG-BA'  => __( 'Red Sea', 'luxus-core' ),
      'EG-BH'  => __( 'Beheira', 'luxus-core' ),
      'EG-BNS' => __( 'Beni Suef', 'luxus-core' ),
      'EG-C'   => __( 'Cairo', 'luxus-core' ),
      'EG-DK'  => __( 'Dakahlia', 'luxus-core' ),
      'EG-DT'  => __( 'Damietta', 'luxus-core' ),
      'EG-FYM' => __( 'Faiyum', 'luxus-core' ),
      'EG-GH'  => __( 'Gharbia', 'luxus-core' ),
      'EG-GZ'  => __( 'Giza', 'luxus-core' ),
      'EG-IS'  => __( 'Ismailia', 'luxus-core' ),
      'EG-JS'  => __( 'South Sinai', 'luxus-core' ),
      'EG-KB'  => __( 'Qalyubia', 'luxus-core' ),
      'EG-KFS' => __( 'Kafr el-Sheikh', 'luxus-core' ),
      'EG-KN'  => __( 'Qena', 'luxus-core' ),
      'EG-LX'  => __( 'Luxor', 'luxus-core' ),
      'EG-MN'  => __( 'Minya', 'luxus-core' ),
      'EG-MNF' => __( 'Monufia', 'luxus-core' ),
      'EG-MT'  => __( 'Matrouh', 'luxus-core' ),
      'EG-PTS' => __( 'Port Said', 'luxus-core' ),
      'EG-SHG' => __( 'Sohag', 'luxus-core' ),
      'EG-SHR' => __( 'Al Sharqia', 'luxus-core' ),
      'EG-SIN' => __( 'North Sinai', 'luxus-core' ),
      'EG-SUZ' => __( 'Suez', 'luxus-core' ),
      'EG-WAD' => __( 'New Valley', 'luxus-core' ),
    ),
    'ES' => array( // Spanish states.
      'ES-C'  => __( 'A Coruña', 'luxus-core' ),
      'ES-VI' => __( 'Araba/Álava', 'luxus-core' ),
      'ES-AB' => __( 'Albacete', 'luxus-core' ),
      'ES-A'  => __( 'Alicante', 'luxus-core' ),
      'ES-AL' => __( 'Almería', 'luxus-core' ),
      'ES-O'  => __( 'Asturias', 'luxus-core' ),
      'ES-AV' => __( 'Ávila', 'luxus-core' ),
      'ES-BA' => __( 'Badajoz', 'luxus-core' ),
      'ES-PM' => __( 'Baleares', 'luxus-core' ),
      'ES-B'  => __( 'Barcelona', 'luxus-core' ),
      'ES-BU' => __( 'Burgos', 'luxus-core' ),
      'ES-CC' => __( 'Cáceres', 'luxus-core' ),
      'ES-CA' => __( 'Cádiz', 'luxus-core' ),
      'ES-S'  => __( 'Cantabria', 'luxus-core' ),
      'ES-CS' => __( 'Castellón', 'luxus-core' ),
      'ES-CE' => __( 'Ceuta', 'luxus-core' ),
      'ES-CR' => __( 'Ciudad Real', 'luxus-core' ),
      'ES-CO' => __( 'Córdoba', 'luxus-core' ),
      'ES-CU' => __( 'Cuenca', 'luxus-core' ),
      'ES-GI' => __( 'Girona', 'luxus-core' ),
      'ES-GR' => __( 'Granada', 'luxus-core' ),
      'ES-GU' => __( 'Guadalajara', 'luxus-core' ),
      'ES-SS' => __( 'Gipuzkoa', 'luxus-core' ),
      'ES-H'  => __( 'Huelva', 'luxus-core' ),
      'ES-HU' => __( 'Huesca', 'luxus-core' ),
      'ES-J'  => __( 'Jaén', 'luxus-core' ),
      'ES-LO' => __( 'La Rioja', 'luxus-core' ),
      'ES-GC' => __( 'Las Palmas', 'luxus-core' ),
      'ES-LE' => __( 'León', 'luxus-core' ),
      'ES-L'  => __( 'Lleida', 'luxus-core' ),
      'ES-LU' => __( 'Lugo', 'luxus-core' ),
      'ES-M'  => __( 'Madrid', 'luxus-core' ),
      'ES-MA' => __( 'Málaga', 'luxus-core' ),
      'ES-ML' => __( 'Melilla', 'luxus-core' ),
      'ES-MU' => __( 'Murcia', 'luxus-core' ),
      'ES-NA' => __( 'Navarra', 'luxus-core' ),
      'ES-OR' => __( 'Ourense', 'luxus-core' ),
      'ES-P'  => __( 'Palencia', 'luxus-core' ),
      'ES-PO' => __( 'Pontevedra', 'luxus-core' ),
      'ES-SA' => __( 'Salamanca', 'luxus-core' ),
      'ES-TF' => __( 'Santa Cruz de Tenerife', 'luxus-core' ),
      'ES-SG' => __( 'Segovia', 'luxus-core' ),
      'ES-SE' => __( 'Sevilla', 'luxus-core' ),
      'ES-SO' => __( 'Soria', 'luxus-core' ),
      'ES-T'  => __( 'Tarragona', 'luxus-core' ),
      'ES-TE' => __( 'Teruel', 'luxus-core' ),
      'ES-TO' => __( 'Toledo', 'luxus-core' ),
      'ES-V'  => __( 'Valencia', 'luxus-core' ),
      'ES-VA' => __( 'Valladolid', 'luxus-core' ),
      'ES-BI' => __( 'Biscay', 'luxus-core' ),
      'ES-ZA' => __( 'Zamora', 'luxus-core' ),
      'ES-Z'  => __( 'Zaragoza', 'luxus-core' ),
    ),
    'GH' => array( // Ghanaian regions.
      'GH-AF' => __( 'Ahafo', 'luxus-core' ),
      'GH-AH' => __( 'Ashanti', 'luxus-core' ),
      'GH-BA' => __( 'Brong-Ahafo', 'luxus-core' ),
      'GH-BO' => __( 'Bono', 'luxus-core' ),
      'GH-BE' => __( 'Bono East', 'luxus-core' ),
      'GH-CP' => __( 'Central', 'luxus-core' ),
      'GH-EP' => __( 'Eastern', 'luxus-core' ),
      'GH-AA' => __( 'Greater Accra', 'luxus-core' ),
      'GH-NE' => __( 'North East', 'luxus-core' ),
      'GH-NP' => __( 'Northern', 'luxus-core' ),
      'GH-OT' => __( 'Oti', 'luxus-core' ),
      'GH-SV' => __( 'Savannah', 'luxus-core' ),
      'GH-UE' => __( 'Upper East', 'luxus-core' ),
      'GH-UW' => __( 'Upper West', 'luxus-core' ),
      'GH-TV' => __( 'Volta', 'luxus-core' ),
      'GH-WP' => __( 'Western', 'luxus-core' ),
      'GH-WN' => __( 'Western North', 'luxus-core' ),
    ),
    'GR' => array( // Greek regions.
      'GR-I' => __( 'Attica', 'luxus-core' ),
      'GR-A' => __( 'East Macedonia and Thrace', 'luxus-core' ),
      'GR-B' => __( 'Central Macedonia', 'luxus-core' ),
      'GR-C' => __( 'West Macedonia', 'luxus-core' ),
      'GR-D' => __( 'Epirus', 'luxus-core' ),
      'GR-E' => __( 'Thessaly', 'luxus-core' ),
      'GR-F' => __( 'Ionian Islands', 'luxus-core' ),
      'GR-G' => __( 'West Greece', 'luxus-core' ),
      'GR-H' => __( 'Central Greece', 'luxus-core' ),
      'GR-J' => __( 'Peloponnese', 'luxus-core' ),
      'GR-K' => __( 'North Aegean', 'luxus-core' ),
      'GR-L' => __( 'South Aegean', 'luxus-core' ),
      'GR-M' => __( 'Crete', 'luxus-core' ),
    ),
    'GT' => array( // Guatemalan states.
      'GT-AV' => __( 'Alta Verapaz', 'luxus-core' ),
      'GT-BV' => __( 'Baja Verapaz', 'luxus-core' ),
      'GT-CM' => __( 'Chimaltenango', 'luxus-core' ),
      'GT-CQ' => __( 'Chiquimula', 'luxus-core' ),
      'GT-PR' => __( 'El Progreso', 'luxus-core' ),
      'GT-ES' => __( 'Escuintla', 'luxus-core' ),
      'GT-GU' => __( 'Guatemala', 'luxus-core' ),
      'GT-HU' => __( 'Huehuetenango', 'luxus-core' ),
      'GT-IZ' => __( 'Izabal', 'luxus-core' ),
      'GT-JA' => __( 'Jalapa', 'luxus-core' ),
      'GT-JU' => __( 'Jutiapa', 'luxus-core' ),
      'GT-PE' => __( 'Petén', 'luxus-core' ),
      'GT-QZ' => __( 'Quetzaltenango', 'luxus-core' ),
      'GT-QC' => __( 'Quiché', 'luxus-core' ),
      'GT-RE' => __( 'Retalhuleu', 'luxus-core' ),
      'GT-SA' => __( 'Sacatepéquez', 'luxus-core' ),
      'GT-SM' => __( 'San Marcos', 'luxus-core' ),
      'GT-SR' => __( 'Santa Rosa', 'luxus-core' ),
      'GT-SO' => __( 'Sololá', 'luxus-core' ),
      'GT-SU' => __( 'Suchitepéquez', 'luxus-core' ),
      'GT-TO' => __( 'Totonicapán', 'luxus-core' ),
      'GT-ZA' => __( 'Zacapa', 'luxus-core' ),
    ),
    'HK' => array( // Hong Kong states.
      'HK-HKI'       => __( 'Hong Kong Island', 'luxus-core' ),
      'HK-KO'         => __( 'Kowloon', 'luxus-core' ),
      'HK-NT' => __( 'New Territories', 'luxus-core' ),
    ),
    'HN' => array( // Honduran states.
      'HN-AT' => __( 'Atlántida', 'luxus-core' ),
      'HN-IB' => __( 'Bay Islands', 'luxus-core' ),
      'HN-CH' => __( 'Choluteca', 'luxus-core' ),
      'HN-CL' => __( 'Colón', 'luxus-core' ),
      'HN-CM' => __( 'Comayagua', 'luxus-core' ),
      'HN-CP' => __( 'Copán', 'luxus-core' ),
      'HN-CR' => __( 'Cortés', 'luxus-core' ),
      'HN-EP' => __( 'El Paraíso', 'luxus-core' ),
      'HN-FM' => __( 'Francisco Morazán', 'luxus-core' ),
      'HN-GD' => __( 'Gracias a Dios', 'luxus-core' ),
      'HN-IN' => __( 'Intibucá', 'luxus-core' ),
      'HN-LE' => __( 'Lempira', 'luxus-core' ),
      'HN-LP' => __( 'La Paz', 'luxus-core' ),
      'HN-OC' => __( 'Ocotepeque', 'luxus-core' ),
      'HN-OL' => __( 'Olancho', 'luxus-core' ),
      'HN-SB' => __( 'Santa Bárbara', 'luxus-core' ),
      'HN-VA' => __( 'Valle', 'luxus-core' ),
      'HN-YO' => __( 'Yoro', 'luxus-core' ),
    ),
    'HU' => array( // Hungarian states.
      'HU-BK' => __( 'Bács-Kiskun', 'luxus-core' ),
      'HU-BE' => __( 'Békés', 'luxus-core' ),
      'HU-BA' => __( 'Baranya', 'luxus-core' ),
      'HU-BZ' => __( 'Borsod-Abaúj-Zemplén', 'luxus-core' ),
      'HU-BU' => __( 'Budapest', 'luxus-core' ),
      'HU-CS' => __( 'Csongrád-Csanád', 'luxus-core' ),
      'HU-FE' => __( 'Fejér', 'luxus-core' ),
      'HU-GS' => __( 'Győr-Moson-Sopron', 'luxus-core' ),
      'HU-HB' => __( 'Hajdú-Bihar', 'luxus-core' ),
      'HU-HE' => __( 'Heves', 'luxus-core' ),
      'HU-JN' => __( 'Jász-Nagykun-Szolnok', 'luxus-core' ),
      'HU-KE' => __( 'Komárom-Esztergom', 'luxus-core' ),
      'HU-NO' => __( 'Nógrád', 'luxus-core' ),
      'HU-PE' => __( 'Pest', 'luxus-core' ),
      'HU-SO' => __( 'Somogy', 'luxus-core' ),
      'HU-SZ' => __( 'Szabolcs-Szatmár-Bereg', 'luxus-core' ),
      'HU-TO' => __( 'Tolna', 'luxus-core' ),
      'HU-VA' => __( 'Vas', 'luxus-core' ),
      'HU-VE' => __( 'Veszprém', 'luxus-core' ),
      'HU-ZA' => __( 'Zala', 'luxus-core' ),
    ),
    'ID' => array( // Indonesian provinces.
      'ID-AC' => __( 'Daerah Istimewa Aceh', 'luxus-core' ),
      'ID-SU' => __( 'Sumatera Utara', 'luxus-core' ),
      'ID-SB' => __( 'Sumatera Barat', 'luxus-core' ),
      'ID-RI' => __( 'Riau', 'luxus-core' ),
      'ID-KR' => __( 'Kepulauan Riau', 'luxus-core' ),
      'ID-JA' => __( 'Jambi', 'luxus-core' ),
      'ID-SS' => __( 'Sumatera Selatan', 'luxus-core' ),
      'ID-BB' => __( 'Bangka Belitung', 'luxus-core' ),
      'ID-BE' => __( 'Bengkulu', 'luxus-core' ),
      'ID-LA' => __( 'Lampung', 'luxus-core' ),
      'ID-JK' => __( 'DKI Jakarta', 'luxus-core' ),
      'ID-JB' => __( 'Jawa Barat', 'luxus-core' ),
      'ID-BT' => __( 'Banten', 'luxus-core' ),
      'ID-JT' => __( 'Jawa Tengah', 'luxus-core' ),
      'ID-JI' => __( 'Jawa Timur', 'luxus-core' ),
      'ID-YO' => __( 'Daerah Istimewa Yogyakarta', 'luxus-core' ),
      'ID-BA' => __( 'Bali', 'luxus-core' ),
      'ID-NB' => __( 'Nusa Tenggara Barat', 'luxus-core' ),
      'ID-NT' => __( 'Nusa Tenggara Timur', 'luxus-core' ),
      'ID-KB' => __( 'Kalimantan Barat', 'luxus-core' ),
      'ID-KT' => __( 'Kalimantan Tengah', 'luxus-core' ),
      'ID-KI' => __( 'Kalimantan Timur', 'luxus-core' ),
      'ID-KS' => __( 'Kalimantan Selatan', 'luxus-core' ),
      'ID-KU' => __( 'Kalimantan Utara', 'luxus-core' ),
      'ID-SA' => __( 'Sulawesi Utara', 'luxus-core' ),
      'ID-ST' => __( 'Sulawesi Tengah', 'luxus-core' ),
      'ID-SG' => __( 'Sulawesi Tenggara', 'luxus-core' ),
      'ID-SR' => __( 'Sulawesi Barat', 'luxus-core' ),
      'ID-SN' => __( 'Sulawesi Selatan', 'luxus-core' ),
      'ID-GO' => __( 'Gorontalo', 'luxus-core' ),
      'ID-MA' => __( 'Maluku', 'luxus-core' ),
      'ID-MU' => __( 'Maluku Utara', 'luxus-core' ),
      'ID-PA' => __( 'Papua', 'luxus-core' ),
      'ID-PB' => __( 'Papua Barat', 'luxus-core' ),
    ),
    'IE' => array( // Irish states.
      'IE-CW' => __( 'Carlow', 'luxus-core' ),
      'IE-CN' => __( 'Cavan', 'luxus-core' ),
      'IE-CE' => __( 'Clare', 'luxus-core' ),
      'IE-CO' => __( 'Cork', 'luxus-core' ),
      'IE-DL' => __( 'Donegal', 'luxus-core' ),
      'IE-D'  => __( 'Dublin', 'luxus-core' ),
      'IE-G'  => __( 'Galway', 'luxus-core' ),
      'IE-KY' => __( 'Kerry', 'luxus-core' ),
      'IE-KE' => __( 'Kildare', 'luxus-core' ),
      'IE-KK' => __( 'Kilkenny', 'luxus-core' ),
      'IE-LS' => __( 'Laois', 'luxus-core' ),
      'IE-LM' => __( 'Leitrim', 'luxus-core' ),
      'IE-LK' => __( 'Limerick', 'luxus-core' ),
      'IE-LD' => __( 'Longford', 'luxus-core' ),
      'IE-LH' => __( 'Louth', 'luxus-core' ),
      'IE-MO' => __( 'Mayo', 'luxus-core' ),
      'IE-MH' => __( 'Meath', 'luxus-core' ),
      'IE-MN' => __( 'Monaghan', 'luxus-core' ),
      'IE-OY' => __( 'Offaly', 'luxus-core' ),
      'IE-RN' => __( 'Roscommon', 'luxus-core' ),
      'IE-SO' => __( 'Sligo', 'luxus-core' ),
      'IE-TA' => __( 'Tipperary', 'luxus-core' ),
      'IE-WD' => __( 'Waterford', 'luxus-core' ),
      'IE-WH' => __( 'Westmeath', 'luxus-core' ),
      'IE-WX' => __( 'Wexford', 'luxus-core' ),
      'IE-WW' => __( 'Wicklow', 'luxus-core' ),
    ),
    'IN' => array( // Indian states.
      'IN-AP' => __( 'Andhra Pradesh', 'luxus-core' ),
      'IN-AR' => __( 'Arunachal Pradesh', 'luxus-core' ),
      'IN-AS' => __( 'Assam', 'luxus-core' ),
      'IN-BR' => __( 'Bihar', 'luxus-core' ),
      'IN-CT' => __( 'Chhattisgarh', 'luxus-core' ),
      'IN-GA' => __( 'Goa', 'luxus-core' ),
      'IN-GJ' => __( 'Gujarat', 'luxus-core' ),
      'IN-HR' => __( 'Haryana', 'luxus-core' ),
      'IN-HP' => __( 'Himachal Pradesh', 'luxus-core' ),
      'IN-JK' => __( 'Jammu and Kashmir', 'luxus-core' ),
      'IN-JH' => __( 'Jharkhand', 'luxus-core' ),
      'IN-KA' => __( 'Karnataka', 'luxus-core' ),
      'IN-KL' => __( 'Kerala', 'luxus-core' ),
      'IN-LA' => __( 'Ladakh', 'luxus-core' ),
      'IN-MP' => __( 'Madhya Pradesh', 'luxus-core' ),
      'IN-MH' => __( 'Maharashtra', 'luxus-core' ),
      'IN-MN' => __( 'Manipur', 'luxus-core' ),
      'IN-ML' => __( 'Meghalaya', 'luxus-core' ),
      'IN-MZ' => __( 'Mizoram', 'luxus-core' ),
      'IN-NL' => __( 'Nagaland', 'luxus-core' ),
      'IN-OR' => __( 'Odisha', 'luxus-core' ),
      'IN-PB' => __( 'Punjab', 'luxus-core' ),
      'IN-RJ' => __( 'Rajasthan', 'luxus-core' ),
      'IN-SK' => __( 'Sikkim', 'luxus-core' ),
      'IN-TN' => __( 'Tamil Nadu', 'luxus-core' ),
      'IN-TS' => __( 'Telangana', 'luxus-core' ),
      'IN-TR' => __( 'Tripura', 'luxus-core' ),
      'IN-UK' => __( 'Uttarakhand', 'luxus-core' ),
      'IN-UP' => __( 'Uttar Pradesh', 'luxus-core' ),
      'IN-WB' => __( 'West Bengal', 'luxus-core' ),
      'IN-AN' => __( 'Andaman and Nicobar Islands', 'luxus-core' ),
      'IN-CH' => __( 'Chandigarh', 'luxus-core' ),
      'IN-DN' => __( 'Dadra and Nagar Haveli', 'luxus-core' ),
      'IN-DD' => __( 'Daman and Diu', 'luxus-core' ),
      'IN-DL' => __( 'Delhi', 'luxus-core' ),
      'IN-LD' => __( 'Lakshadeep', 'luxus-core' ),
      'IN-PY' => __( 'Pondicherry (Puducherry)', 'luxus-core' ),
    ),
    'IR' => array( // Irania states.
      'IR-KHZ' => __( 'Khuzestan (خوزستان)', 'luxus-core' ),
      'IR-THR' => __( 'Tehran (تهران)', 'luxus-core' ),
      'IR-ILM' => __( 'Ilaam (ایلام)', 'luxus-core' ),
      'IR-BHR' => __( 'Bushehr (بوشهر)', 'luxus-core' ),
      'IR-ADL' => __( 'Ardabil (اردبیل)', 'luxus-core' ),
      'IR-ESF' => __( 'Isfahan (اصفهان)', 'luxus-core' ),
      'IR-YZD' => __( 'Yazd (یزد)', 'luxus-core' ),
      'IR-KRH' => __( 'Kermanshah (کرمانشاه)', 'luxus-core' ),
      'IR-KRN' => __( 'Kerman (کرمان)', 'luxus-core' ),
      'IR-HDN' => __( 'Hamadan (همدان)', 'luxus-core' ),
      'IR-GZN' => __( 'Ghazvin (قزوین)', 'luxus-core' ),
      'IR-ZJN' => __( 'Zanjan (زنجان)', 'luxus-core' ),
      'IR-LRS' => __( 'Luristan (لرستان)', 'luxus-core' ),
      'IR-ABZ' => __( 'Alborz (البرز)', 'luxus-core' ),
      'IR-EAZ' => __( 'East Azarbaijan (آذربایجان شرقی)', 'luxus-core' ),
      'IR-WAZ' => __( 'West Azarbaijan (آذربایجان غربی)', 'luxus-core' ),
      'IR-CHB' => __( 'Chaharmahal and Bakhtiari (چهارمحال و بختیاری)', 'luxus-core' ),
      'IR-SKH' => __( 'South Khorasan (خراسان جنوبی)', 'luxus-core' ),
      'IR-RKH' => __( 'Razavi Khorasan (خراسان رضوی)', 'luxus-core' ),
      'IR-NKH' => __( 'North Khorasan (خراسان شمالی)', 'luxus-core' ),
      'IR-SMN' => __( 'Semnan (سمنان)', 'luxus-core' ),
      'IR-FRS' => __( 'Fars (فارس)', 'luxus-core' ),
      'IR-QHM' => __( 'Qom (قم)', 'luxus-core' ),
      'IR-KRD' => __( 'Kurdistan / کردستان)', 'luxus-core' ),
      'IR-KBD' => __( 'Kohgiluyeh and BoyerAhmad (کهگیلوییه و بویراحمد)', 'luxus-core' ),
      'IR-GLS' => __( 'Golestan (گلستان)', 'luxus-core' ),
      'IR-GIL' => __( 'Gilan (گیلان)', 'luxus-core' ),
      'IR-MZN' => __( 'Mazandaran (مازندران)', 'luxus-core' ),
      'IR-MKZ' => __( 'Markazi (مرکزی)', 'luxus-core' ),
      'IR-HRZ' => __( 'Hormozgan (هرمزگان)', 'luxus-core' ),
      'IR-SBN' => __( 'Sistan and Baluchestan (سیستان و بلوچستان)', 'luxus-core' ),
    ),
    'IT' => array( // Italian provinces.
      'IT-AG' => __( 'Agrigento', 'luxus-core' ),
      'IT-AL' => __( 'Alessandria', 'luxus-core' ),
      'IT-AN' => __( 'Ancona', 'luxus-core' ),
      'IT-AO' => __( 'Aosta', 'luxus-core' ),
      'IT-AR' => __( 'Arezzo', 'luxus-core' ),
      'IT-AP' => __( 'Ascoli Piceno', 'luxus-core' ),
      'IT-AT' => __( 'Asti', 'luxus-core' ),
      'IT-AV' => __( 'Avellino', 'luxus-core' ),
      'IT-BA' => __( 'Bari', 'luxus-core' ),
      'IT-BT' => __( 'Barletta-Andria-Trani', 'luxus-core' ),
      'IT-BL' => __( 'Belluno', 'luxus-core' ),
      'IT-BN' => __( 'Benevento', 'luxus-core' ),
      'IT-BG' => __( 'Bergamo', 'luxus-core' ),
      'IT-BI' => __( 'Biella', 'luxus-core' ),
      'IT-BO' => __( 'Bologna', 'luxus-core' ),
      'IT-BZ' => __( 'Bolzano', 'luxus-core' ),
      'IT-BS' => __( 'Brescia', 'luxus-core' ),
      'IT-BR' => __( 'Brindisi', 'luxus-core' ),
      'IT-CA' => __( 'Cagliari', 'luxus-core' ),
      'IT-CL' => __( 'Caltanissetta', 'luxus-core' ),
      'IT-CB' => __( 'Campobasso', 'luxus-core' ),
      'IT-CE' => __( 'Caserta', 'luxus-core' ),
      'IT-CT' => __( 'Catania', 'luxus-core' ),
      'IT-CZ' => __( 'Catanzaro', 'luxus-core' ),
      'IT-CH' => __( 'Chieti', 'luxus-core' ),
      'IT-CO' => __( 'Como', 'luxus-core' ),
      'IT-CS' => __( 'Cosenza', 'luxus-core' ),
      'IT-CR' => __( 'Cremona', 'luxus-core' ),
      'IT-KR' => __( 'Crotone', 'luxus-core' ),
      'IT-CN' => __( 'Cuneo', 'luxus-core' ),
      'IT-EN' => __( 'Enna', 'luxus-core' ),
      'IT-FM' => __( 'Fermo', 'luxus-core' ),
      'IT-FE' => __( 'Ferrara', 'luxus-core' ),
      'IT-FI' => __( 'Firenze', 'luxus-core' ),
      'IT-FG' => __( 'Foggia', 'luxus-core' ),
      'IT-FC' => __( 'Forlì-Cesena', 'luxus-core' ),
      'IT-FR' => __( 'Frosinone', 'luxus-core' ),
      'IT-GE' => __( 'Genova', 'luxus-core' ),
      'IT-GO' => __( 'Gorizia', 'luxus-core' ),
      'IT-GR' => __( 'Grosseto', 'luxus-core' ),
      'IT-IM' => __( 'Imperia', 'luxus-core' ),
      'IT-IS' => __( 'Isernia', 'luxus-core' ),
      'IT-SP' => __( 'La Spezia', 'luxus-core' ),
      'IT-AQ' => __( "L'Aquila", 'luxus-core' ),
      'IT-LT' => __( 'Latina', 'luxus-core' ),
      'IT-LE' => __( 'Lecce', 'luxus-core' ),
      'IT-LC' => __( 'Lecco', 'luxus-core' ),
      'IT-LI' => __( 'Livorno', 'luxus-core' ),
      'IT-LO' => __( 'Lodi', 'luxus-core' ),
      'IT-LU' => __( 'Lucca', 'luxus-core' ),
      'IT-MC' => __( 'Macerata', 'luxus-core' ),
      'IT-MN' => __( 'Mantova', 'luxus-core' ),
      'IT-MS' => __( 'Massa-Carrara', 'luxus-core' ),
      'IT-MT' => __( 'Matera', 'luxus-core' ),
      'IT-ME' => __( 'Messina', 'luxus-core' ),
      'IT-MI' => __( 'Milano', 'luxus-core' ),
      'IT-MO' => __( 'Modena', 'luxus-core' ),
      'IT-MB' => __( 'Monza e della Brianza', 'luxus-core' ),
      'IT-NA' => __( 'Napoli', 'luxus-core' ),
      'IT-NO' => __( 'Novara', 'luxus-core' ),
      'IT-NU' => __( 'Nuoro', 'luxus-core' ),
      'IT-OR' => __( 'Oristano', 'luxus-core' ),
      'IT-PD' => __( 'Padova', 'luxus-core' ),
      'IT-PA' => __( 'Palermo', 'luxus-core' ),
      'IT-PR' => __( 'Parma', 'luxus-core' ),
      'IT-PV' => __( 'Pavia', 'luxus-core' ),
      'IT-PG' => __( 'Perugia', 'luxus-core' ),
      'IT-PU' => __( 'Pesaro e Urbino', 'luxus-core' ),
      'IT-PE' => __( 'Pescara', 'luxus-core' ),
      'IT-PC' => __( 'Piacenza', 'luxus-core' ),
      'IT-PI' => __( 'Pisa', 'luxus-core' ),
      'IT-PT' => __( 'Pistoia', 'luxus-core' ),
      'IT-PN' => __( 'Pordenone', 'luxus-core' ),
      'IT-PZ' => __( 'Potenza', 'luxus-core' ),
      'IT-PO' => __( 'Prato', 'luxus-core' ),
      'IT-RG' => __( 'Ragusa', 'luxus-core' ),
      'IT-RA' => __( 'Ravenna', 'luxus-core' ),
      'IT-RC' => __( 'Reggio Calabria', 'luxus-core' ),
      'IT-RE' => __( 'Reggio Emilia', 'luxus-core' ),
      'IT-RI' => __( 'Rieti', 'luxus-core' ),
      'IT-RN' => __( 'Rimini', 'luxus-core' ),
      'IT-RM' => __( 'Roma', 'luxus-core' ),
      'IT-RO' => __( 'Rovigo', 'luxus-core' ),
      'IT-SA' => __( 'Salerno', 'luxus-core' ),
      'IT-SS' => __( 'Sassari', 'luxus-core' ),
      'IT-SV' => __( 'Savona', 'luxus-core' ),
      'IT-SI' => __( 'Siena', 'luxus-core' ),
      'IT-SR' => __( 'Siracusa', 'luxus-core' ),
      'IT-SO' => __( 'Sondrio', 'luxus-core' ),
      'IT-SU' => __( 'Sud Sardegna', 'luxus-core' ),
      'IT-TA' => __( 'Taranto', 'luxus-core' ),
      'IT-TE' => __( 'Teramo', 'luxus-core' ),
      'IT-TR' => __( 'Terni', 'luxus-core' ),
      'IT-TO' => __( 'Torino', 'luxus-core' ),
      'IT-TP' => __( 'Trapani', 'luxus-core' ),
      'IT-TN' => __( 'Trento', 'luxus-core' ),
      'IT-TV' => __( 'Treviso', 'luxus-core' ),
      'IT-TS' => __( 'Trieste', 'luxus-core' ),
      'IT-UD' => __( 'Udine', 'luxus-core' ),
      'IT-VA' => __( 'Varese', 'luxus-core' ),
      'IT-VE' => __( 'Venezia', 'luxus-core' ),
      'IT-VB' => __( 'Verbano-Cusio-Ossola', 'luxus-core' ),
      'IT-VC' => __( 'Vercelli', 'luxus-core' ),
      'IT-VR' => __( 'Verona', 'luxus-core' ),
      'IT-VV' => __( 'Vibo Valentia', 'luxus-core' ),
      'IT-VI' => __( 'Vicenza', 'luxus-core' ),
      'IT-VT' => __( 'Viterbo', 'luxus-core' ),
    ),
    'JM' => array( // Jamaican parishes.
      'JM-01' => __( 'Kingston', 'luxus-core' ),
      'JM-02' => __( 'Saint Andrew', 'luxus-core' ),
      'JM-03' => __( 'Saint Thomas', 'luxus-core' ),
      'JM-04' => __( 'Portland', 'luxus-core' ),
      'JM-05' => __( 'Saint Mary', 'luxus-core' ),
      'JM-06' => __( 'Saint Ann', 'luxus-core' ),
      'JM-07' => __( 'Trelawny', 'luxus-core' ),
      'JM-08' => __( 'Saint James', 'luxus-core' ),
      'JM-09' => __( 'Hanover', 'luxus-core' ),
      'JM-10' => __( 'Westmoreland', 'luxus-core' ),
      'JM-11' => __( 'Saint Elizabeth', 'luxus-core' ),
      'JM-12' => __( 'Manchester', 'luxus-core' ),
      'JM-13' => __( 'Clarendon', 'luxus-core' ),
      'JM-14' => __( 'Saint Catherine', 'luxus-core' ),
    ),

    /**
     * Japanese states.
     *
     * English notation of prefectures conform to the notation of Japan Post.
     * The suffix corresponds with the Japanese translation file.
     */
    'JP' => array(
      'JP-01' => __( 'Hokkaido', 'luxus-core' ),
      'JP-02' => __( 'Aomori', 'luxus-core' ),
      'JP-03' => __( 'Iwate', 'luxus-core' ),
      'JP-04' => __( 'Miyagi', 'luxus-core' ),
      'JP-05' => __( 'Akita', 'luxus-core' ),
      'JP-06' => __( 'Yamagata', 'luxus-core' ),
      'JP-07' => __( 'Fukushima', 'luxus-core' ),
      'JP-08' => __( 'Ibaraki', 'luxus-core' ),
      'JP-09' => __( 'Tochigi', 'luxus-core' ),
      'JP-10' => __( 'Gunma', 'luxus-core' ),
      'JP-11' => __( 'Saitama', 'luxus-core' ),
      'JP-12' => __( 'Chiba', 'luxus-core' ),
      'JP-13' => __( 'Tokyo', 'luxus-core' ),
      'JP-14' => __( 'Kanagawa', 'luxus-core' ),
      'JP-15' => __( 'Niigata', 'luxus-core' ),
      'JP-16' => __( 'Toyama', 'luxus-core' ),
      'JP-17' => __( 'Ishikawa', 'luxus-core' ),
      'JP-18' => __( 'Fukui', 'luxus-core' ),
      'JP-19' => __( 'Yamanashi', 'luxus-core' ),
      'JP-20' => __( 'Nagano', 'luxus-core' ),
      'JP-21' => __( 'Gifu', 'luxus-core' ),
      'JP-22' => __( 'Shizuoka', 'luxus-core' ),
      'JP-23' => __( 'Aichi', 'luxus-core' ),
      'JP-24' => __( 'Mie', 'luxus-core' ),
      'JP-25' => __( 'Shiga', 'luxus-core' ),
      'JP-26' => __( 'Kyoto', 'luxus-core' ),
      'JP-27' => __( 'Osaka', 'luxus-core' ),
      'JP-28' => __( 'Hyogo', 'luxus-core' ),
      'JP-29' => __( 'Nara', 'luxus-core' ),
      'JP-30' => __( 'Wakayama', 'luxus-core' ),
      'JP-31' => __( 'Tottori', 'luxus-core' ),
      'JP-32' => __( 'Shimane', 'luxus-core' ),
      'JP-33' => __( 'Okayama', 'luxus-core' ),
      'JP-34' => __( 'Hiroshima', 'luxus-core' ),
      'JP-35' => __( 'Yamaguchi', 'luxus-core' ),
      'JP-36' => __( 'Tokushima', 'luxus-core' ),
      'JP-37' => __( 'Kagawa', 'luxus-core' ),
      'JP-38' => __( 'Ehime', 'luxus-core' ),
      'JP-39' => __( 'Kochi', 'luxus-core' ),
      'JP-40' => __( 'Fukuoka', 'luxus-core' ),
      'JP-41' => __( 'Saga', 'luxus-core' ),
      'JP-42' => __( 'Nagasaki', 'luxus-core' ),
      'JP-43' => __( 'Kumamoto', 'luxus-core' ),
      'JP-44' => __( 'Oita', 'luxus-core' ),
      'JP-45' => __( 'Miyazaki', 'luxus-core' ),
      'JP-46' => __( 'Kagoshima', 'luxus-core' ),
      'JP-47' => __( 'Okinawa', 'luxus-core' ),
    ),
    'KE' => array( // Kenyan counties.
      'KE-01' => __( 'Baringo', 'luxus-core' ),
      'KE-02' => __( 'Bomet', 'luxus-core' ),
      'KE-03' => __( 'Bungoma', 'luxus-core' ),
      'KE-04' => __( 'Busia', 'luxus-core' ),
      'KE-05' => __( 'Elgeyo-Marakwet', 'luxus-core' ),
      'KE-06' => __( 'Embu', 'luxus-core' ),
      'KE-07' => __( 'Garissa', 'luxus-core' ),
      'KE-08' => __( 'Homa Bay', 'luxus-core' ),
      'KE-09' => __( 'Isiolo', 'luxus-core' ),
      'KE-10' => __( 'Kajiado', 'luxus-core' ),
      'KE-11' => __( 'Kakamega', 'luxus-core' ),
      'KE-12' => __( 'Kericho', 'luxus-core' ),
      'KE-13' => __( 'Kiambu', 'luxus-core' ),
      'KE-14' => __( 'Kilifi', 'luxus-core' ),
      'KE-15' => __( 'Kirinyaga', 'luxus-core' ),
      'KE-16' => __( 'Kisii', 'luxus-core' ),
      'KE-17' => __( 'Kisumu', 'luxus-core' ),
      'KE-18' => __( 'Kitui', 'luxus-core' ),
      'KE-19' => __( 'Kwale', 'luxus-core' ),
      'KE-20' => __( 'Laikipia', 'luxus-core' ),
      'KE-21' => __( 'Lamu', 'luxus-core' ),
      'KE-22' => __( 'Machakos', 'luxus-core' ),
      'KE-23' => __( 'Makueni', 'luxus-core' ),
      'KE-24' => __( 'Mandera', 'luxus-core' ),
      'KE-25' => __( 'Marsabit', 'luxus-core' ),
      'KE-26' => __( 'Meru', 'luxus-core' ),
      'KE-27' => __( 'Migori', 'luxus-core' ),
      'KE-28' => __( 'Mombasa', 'luxus-core' ),
      'KE-29' => __( 'Murang’a', 'luxus-core' ),
      'KE-30' => __( 'Nairobi County', 'luxus-core' ),
      'KE-31' => __( 'Nakuru', 'luxus-core' ),
      'KE-32' => __( 'Nandi', 'luxus-core' ),
      'KE-33' => __( 'Narok', 'luxus-core' ),
      'KE-34' => __( 'Nyamira', 'luxus-core' ),
      'KE-35' => __( 'Nyandarua', 'luxus-core' ),
      'KE-36' => __( 'Nyeri', 'luxus-core' ),
      'KE-37' => __( 'Samburu', 'luxus-core' ),
      'KE-38' => __( 'Siaya', 'luxus-core' ),
      'KE-39' => __( 'Taita-Taveta', 'luxus-core' ),
      'KE-40' => __( 'Tana River', 'luxus-core' ),
      'KE-41' => __( 'Tharaka-Nithi', 'luxus-core' ),
      'KE-42' => __( 'Trans Nzoia', 'luxus-core' ),
      'KE-43' => __( 'Turkana', 'luxus-core' ),
      'KE-44' => __( 'Uasin Gishu', 'luxus-core' ),
      'KE-45' => __( 'Vihiga', 'luxus-core' ),
      'KE-46' => __( 'Wajir', 'luxus-core' ),
      'KE-47' => __( 'West Pokot', 'luxus-core' ),
    ),
    'LA' => array( // Laotian provinces.
      'LA-AT' => __( 'Attapeu', 'luxus-core' ),
      'LA-BK' => __( 'Bokeo', 'luxus-core' ),
      'LA-BL' => __( 'Bolikhamsai', 'luxus-core' ),
      'LA-CH' => __( 'Champasak', 'luxus-core' ),
      'LA-HO' => __( 'Houaphanh', 'luxus-core' ),
      'LA-KH' => __( 'Khammouane', 'luxus-core' ),
      'LA-LM' => __( 'Luang Namtha', 'luxus-core' ),
      'LA-LP' => __( 'Luang Prabang', 'luxus-core' ),
      'LA-OU' => __( 'Oudomxay', 'luxus-core' ),
      'LA-PH' => __( 'Phongsaly', 'luxus-core' ),
      'LA-SL' => __( 'Salavan', 'luxus-core' ),
      'LA-SV' => __( 'Savannakhet', 'luxus-core' ),
      'LA-VI' => __( 'Vientiane Province', 'luxus-core' ),
      'LA-VT' => __( 'Vientiane', 'luxus-core' ),
      'LA-XA' => __( 'Sainyabuli', 'luxus-core' ),
      'LA-XE' => __( 'Sekong', 'luxus-core' ),
      'LA-XI' => __( 'Xiangkhouang', 'luxus-core' ),
      'LA-XS' => __( 'Xaisomboun', 'luxus-core' ),
    ),
    'LR' => array( // Liberian provinces.
      'LR-BM' => __( 'Bomi', 'luxus-core' ),
      'LR-BN' => __( 'Bong', 'luxus-core' ),
      'LR-GA' => __( 'Gbarpolu', 'luxus-core' ),
      'LR-GB' => __( 'Grand Bassa', 'luxus-core' ),
      'LR-GC' => __( 'Grand Cape Mount', 'luxus-core' ),
      'LR-GG' => __( 'Grand Gedeh', 'luxus-core' ),
      'LR-GK' => __( 'Grand Kru', 'luxus-core' ),
      'LR-LO' => __( 'Lofa', 'luxus-core' ),
      'LR-MA' => __( 'Margibi', 'luxus-core' ),
      'LR-MY' => __( 'Maryland', 'luxus-core' ),
      'LR-MO' => __( 'Montserrado', 'luxus-core' ),
      'LR-NM' => __( 'Nimba', 'luxus-core' ),
      'LR-RV' => __( 'Rivercess', 'luxus-core' ),
      'LR-RG' => __( 'River Gee', 'luxus-core' ),
      'LR-SN' => __( 'Sinoe', 'luxus-core' ),
    ),
    'MD' => array( // Moldovan states.
      'MD-C'  => __( 'Chișinău', 'luxus-core' ),
      'MD-BL' => __( 'Bălți', 'luxus-core' ),
      'MD-AN' => __( 'Anenii Noi', 'luxus-core' ),
      'MD-BS' => __( 'Basarabeasca', 'luxus-core' ),
      'MD-BR' => __( 'Briceni', 'luxus-core' ),
      'MD-CH' => __( 'Cahul', 'luxus-core' ),
      'MD-CT' => __( 'Cantemir', 'luxus-core' ),
      'MD-CL' => __( 'Călărași', 'luxus-core' ),
      'MD-CS' => __( 'Căușeni', 'luxus-core' ),
      'MD-CM' => __( 'Cimișlia', 'luxus-core' ),
      'MD-CR' => __( 'Criuleni', 'luxus-core' ),
      'MD-DN' => __( 'Dondușeni', 'luxus-core' ),
      'MD-DR' => __( 'Drochia', 'luxus-core' ),
      'MD-DB' => __( 'Dubăsari', 'luxus-core' ),
      'MD-ED' => __( 'Edineț', 'luxus-core' ),
      'MD-FL' => __( 'Fălești', 'luxus-core' ),
      'MD-FR' => __( 'Florești', 'luxus-core' ),
      'MD-GE' => __( 'UTA Găgăuzia', 'luxus-core' ),
      'MD-GL' => __( 'Glodeni', 'luxus-core' ),
      'MD-HN' => __( 'Hîncești', 'luxus-core' ),
      'MD-IL' => __( 'Ialoveni', 'luxus-core' ),
      'MD-LV' => __( 'Leova', 'luxus-core' ),
      'MD-NS' => __( 'Nisporeni', 'luxus-core' ),
      'MD-OC' => __( 'Ocnița', 'luxus-core' ),
      'MD-OR' => __( 'Orhei', 'luxus-core' ),
      'MD-RZ' => __( 'Rezina', 'luxus-core' ),
      'MD-RS' => __( 'Rîșcani', 'luxus-core' ),
      'MD-SG' => __( 'Sîngerei', 'luxus-core' ),
      'MD-SR' => __( 'Soroca', 'luxus-core' ),
      'MD-ST' => __( 'Strășeni', 'luxus-core' ),
      'MD-SD' => __( 'Șoldănești', 'luxus-core' ),
      'MD-SV' => __( 'Ștefan Vodă', 'luxus-core' ),
      'MD-TR' => __( 'Taraclia', 'luxus-core' ),
      'MD-TL' => __( 'Telenești', 'luxus-core' ),
      'MD-UN' => __( 'Ungheni', 'luxus-core' ),
    ),
    'MX' => array( // Mexican states.
      'MX-DF' => __( 'Ciudad de México', 'luxus-core' ),
      'MX-JA' => __( 'Jalisco', 'luxus-core' ),
      'MX-NL' => __( 'Nuevo León', 'luxus-core' ),
      'MX-AG' => __( 'Aguascalientes', 'luxus-core' ),
      'MX-BC' => __( 'Baja California', 'luxus-core' ),
      'MX-BS' => __( 'Baja California Sur', 'luxus-core' ),
      'MX-CM' => __( 'Campeche', 'luxus-core' ),
      'MX-CS' => __( 'Chiapas', 'luxus-core' ),
      'MX-CH' => __( 'Chihuahua', 'luxus-core' ),
      'MX-CO' => __( 'Coahuila', 'luxus-core' ),
      'MX-CL' => __( 'Colima', 'luxus-core' ),
      'MX-DG' => __( 'Durango', 'luxus-core' ),
      'MX-GT' => __( 'Guanajuato', 'luxus-core' ),
      'MX-GR' => __( 'Guerrero', 'luxus-core' ),
      'MX-HG' => __( 'Hidalgo', 'luxus-core' ),
      'MX-MX' => __( 'Estado de México', 'luxus-core' ),
      'MX-MI' => __( 'Michoacán', 'luxus-core' ),
      'MX-MO' => __( 'Morelos', 'luxus-core' ),
      'MX-NA' => __( 'Nayarit', 'luxus-core' ),
      'MX-OA' => __( 'Oaxaca', 'luxus-core' ),
      'MX-PU' => __( 'Puebla', 'luxus-core' ),
      'MX-QT' => __( 'Querétaro', 'luxus-core' ),
      'MX-QR' => __( 'Quintana Roo', 'luxus-core' ),
      'MX-SL' => __( 'San Luis Potosí', 'luxus-core' ),
      'MX-SI' => __( 'Sinaloa', 'luxus-core' ),
      'MX-SO' => __( 'Sonora', 'luxus-core' ),
      'MX-TB' => __( 'Tabasco', 'luxus-core' ),
      'MX-TM' => __( 'Tamaulipas', 'luxus-core' ),
      'MX-TL' => __( 'Tlaxcala', 'luxus-core' ),
      'MX-VE' => __( 'Veracruz', 'luxus-core' ),
      'MX-YU' => __( 'Yucatán', 'luxus-core' ),
      'MX-ZA' => __( 'Zacatecas', 'luxus-core' ),
    ),
    'MY' => array( // Malaysian states.
      'MY-JHR' => __( 'Johor', 'luxus-core' ),
      'MY-KDH' => __( 'Kedah', 'luxus-core' ),
      'MY-KTN' => __( 'Kelantan', 'luxus-core' ),
      'MY-LBN' => __( 'Labuan', 'luxus-core' ),
      'MY-MLK' => __( 'Malacca (Melaka)', 'luxus-core' ),
      'MY-NSN' => __( 'Negeri Sembilan', 'luxus-core' ),
      'MY-PHG' => __( 'Pahang', 'luxus-core' ),
      'MY-PNG' => __( 'Penang (Pulau Pinang)', 'luxus-core' ),
      'MY-PRK' => __( 'Perak', 'luxus-core' ),
      'MY-PLS' => __( 'Perlis', 'luxus-core' ),
      'MY-SBH' => __( 'Sabah', 'luxus-core' ),
      'MY-SWK' => __( 'Sarawak', 'luxus-core' ),
      'MY-SGR' => __( 'Selangor', 'luxus-core' ),
      'MY-TRG' => __( 'Terengganu', 'luxus-core' ),
      'MY-PJY' => __( 'Putrajaya', 'luxus-core' ),
      'MY-KUL' => __( 'Kuala Lumpur', 'luxus-core' ),
    ),
    'MZ' => array( // Mozambican provinces.
      'MZ-MZP'   => __( 'Cabo Delgado', 'luxus-core' ),
      'MZ-MZG'   => __( 'Gaza', 'luxus-core' ),
      'MZ-MZI'   => __( 'Inhambane', 'luxus-core' ),
      'MZ-MZB'   => __( 'Manica', 'luxus-core' ),
      'MZ-MZL'   => __( 'Maputo Province', 'luxus-core' ),
      'MZ-MZMPM' => __( 'Maputo', 'luxus-core' ),
      'MZ-MZN'   => __( 'Nampula', 'luxus-core' ),
      'MZ-MZA'   => __( 'Niassa', 'luxus-core' ),
      'MZ-MZS'   => __( 'Sofala', 'luxus-core' ),
      'MZ-MZT'   => __( 'Tete', 'luxus-core' ),
      'MZ-MZQ'   => __( 'Zambézia', 'luxus-core' ),
    ),
    'NA' => array( // Namibian regions.
      'NA-ER' => __( 'Erongo', 'luxus-core' ),
      'NA-HA' => __( 'Hardap', 'luxus-core' ),
      'NA-KA' => __( 'Karas', 'luxus-core' ),
      'NA-KE' => __( 'Kavango East', 'luxus-core' ),
      'NA-KW' => __( 'Kavango West', 'luxus-core' ),
      'NA-KH' => __( 'Khomas', 'luxus-core' ),
      'NA-KU' => __( 'Kunene', 'luxus-core' ),
      'NA-OW' => __( 'Ohangwena', 'luxus-core' ),
      'NA-OH' => __( 'Omaheke', 'luxus-core' ),
      'NA-OS' => __( 'Omusati', 'luxus-core' ),
      'NA-ON' => __( 'Oshana', 'luxus-core' ),
      'NA-OT' => __( 'Oshikoto', 'luxus-core' ),
      'NA-OD' => __( 'Otjozondjupa', 'luxus-core' ),
      'NA-CA' => __( 'Zambezi', 'luxus-core' ),
    ),
    'NG' => array( // Nigerian provinces.
      'NG-AB' => __( 'Abia', 'luxus-core' ),
      'NG-FC' => __( 'Abuja', 'luxus-core' ),
      'NG-AD' => __( 'Adamawa', 'luxus-core' ),
      'NG-AK' => __( 'Akwa Ibom', 'luxus-core' ),
      'NG-AN' => __( 'Anambra', 'luxus-core' ),
      'NG-BA' => __( 'Bauchi', 'luxus-core' ),
      'NG-BY' => __( 'Bayelsa', 'luxus-core' ),
      'NG-BE' => __( 'Benue', 'luxus-core' ),
      'NG-BO' => __( 'Borno', 'luxus-core' ),
      'NG-CR' => __( 'Cross River', 'luxus-core' ),
      'NG-DE' => __( 'Delta', 'luxus-core' ),
      'NG-EB' => __( 'Ebonyi', 'luxus-core' ),
      'NG-ED' => __( 'Edo', 'luxus-core' ),
      'NG-EK' => __( 'Ekiti', 'luxus-core' ),
      'NG-EN' => __( 'Enugu', 'luxus-core' ),
      'NG-GO' => __( 'Gombe', 'luxus-core' ),
      'NG-IM' => __( 'Imo', 'luxus-core' ),
      'NG-JI' => __( 'Jigawa', 'luxus-core' ),
      'NG-KD' => __( 'Kaduna', 'luxus-core' ),
      'NG-KN' => __( 'Kano', 'luxus-core' ),
      'NG-KT' => __( 'Katsina', 'luxus-core' ),
      'NG-KE' => __( 'Kebbi', 'luxus-core' ),
      'NG-KO' => __( 'Kogi', 'luxus-core' ),
      'NG-KW' => __( 'Kwara', 'luxus-core' ),
      'NG-LA' => __( 'Lagos', 'luxus-core' ),
      'NG-NA' => __( 'Nasarawa', 'luxus-core' ),
      'NG-NI' => __( 'Niger', 'luxus-core' ),
      'NG-OG' => __( 'Ogun', 'luxus-core' ),
      'NG-ON' => __( 'Ondo', 'luxus-core' ),
      'NG-OS' => __( 'Osun', 'luxus-core' ),
      'NG-OY' => __( 'Oyo', 'luxus-core' ),
      'NG-PL' => __( 'Plateau', 'luxus-core' ),
      'NG-RI' => __( 'Rivers', 'luxus-core' ),
      'NG-SO' => __( 'Sokoto', 'luxus-core' ),
      'NG-TA' => __( 'Taraba', 'luxus-core' ),
      'NG-YO' => __( 'Yobe', 'luxus-core' ),
      'NG-ZA' => __( 'Zamfara', 'luxus-core' ),
    ),
    'NP' => array( // Nepalese zones.
      'NP-BAG' => __( 'Bagmati', 'luxus-core' ),
      'NP-BHE' => __( 'Bheri', 'luxus-core' ),
      'NP-DHA' => __( 'Dhaulagiri', 'luxus-core' ),
      'NP-GAN' => __( 'Gandaki', 'luxus-core' ),
      'NP-JAN' => __( 'Janakpur', 'luxus-core' ),
      'NP-KAR' => __( 'Karnali', 'luxus-core' ),
      'NP-KOS' => __( 'Koshi', 'luxus-core' ),
      'NP-LUM' => __( 'Lumbini', 'luxus-core' ),
      'NP-MAH' => __( 'Mahakali', 'luxus-core' ),
      'NP-MEC' => __( 'Mechi', 'luxus-core' ),
      'NP-NAR' => __( 'Narayani', 'luxus-core' ),
      'NP-RAP' => __( 'Rapti', 'luxus-core' ),
      'NP-SAG' => __( 'Sagarmatha', 'luxus-core' ),
      'NP-SET' => __( 'Seti', 'luxus-core' ),
    ),
    'NI' => array( // Nicaraguan states.
      'NI-AN' => __( 'Atlántico Norte', 'luxus-core' ),
      'NI-AS' => __( 'Atlántico Sur', 'luxus-core' ),
      'NI-BO' => __( 'Boaco', 'luxus-core' ),
      'NI-CA' => __( 'Carazo', 'luxus-core' ),
      'NI-CI' => __( 'Chinandega', 'luxus-core' ),
      'NI-CO' => __( 'Chontales', 'luxus-core' ),
      'NI-ES' => __( 'Estelí', 'luxus-core' ),
      'NI-GR' => __( 'Granada', 'luxus-core' ),
      'NI-JI' => __( 'Jinotega', 'luxus-core' ),
      'NI-LE' => __( 'León', 'luxus-core' ),
      'NI-MD' => __( 'Madriz', 'luxus-core' ),
      'NI-MN' => __( 'Managua', 'luxus-core' ),
      'NI-MS' => __( 'Masaya', 'luxus-core' ),
      'NI-MT' => __( 'Matagalpa', 'luxus-core' ),
      'NI-NS' => __( 'Nueva Segovia', 'luxus-core' ),
      'NI-RI' => __( 'Rivas', 'luxus-core' ),
      'NI-SJ' => __( 'Río San Juan', 'luxus-core' ),
    ),
    'NZ' => array( // New Zealand states.
      'NZ-NL' => __( 'Northland', 'luxus-core' ),
      'NZ-AK' => __( 'Auckland', 'luxus-core' ),
      'NZ-WA' => __( 'Waikato', 'luxus-core' ),
      'NZ-BP' => __( 'Bay of Plenty', 'luxus-core' ),
      'NZ-TK' => __( 'Taranaki', 'luxus-core' ),
      'NZ-GI' => __( 'Gisborne', 'luxus-core' ),
      'NZ-HB' => __( 'Hawke’s Bay', 'luxus-core' ),
      'NZ-MW' => __( 'Manawatu-Wanganui', 'luxus-core' ),
      'NZ-WE' => __( 'Wellington', 'luxus-core' ),
      'NZ-NS' => __( 'Nelson', 'luxus-core' ),
      'NZ-MB' => __( 'Marlborough', 'luxus-core' ),
      'NZ-TM' => __( 'Tasman', 'luxus-core' ),
      'NZ-WC' => __( 'West Coast', 'luxus-core' ),
      'NZ-CT' => __( 'Canterbury', 'luxus-core' ),
      'NZ-OT' => __( 'Otago', 'luxus-core' ),
      'NZ-SL' => __( 'Southland', 'luxus-core' ),
    ),
    'PA' => array( // Panamanian states.
      'PA-1' => __( 'Bocas del Toro', 'luxus-core' ),
      'PA-2' => __( 'Coclé', 'luxus-core' ),
      'PA-3' => __( 'Colón', 'luxus-core' ),
      'PA-4' => __( 'Chiriquí', 'luxus-core' ),
      'PA-5' => __( 'Darién', 'luxus-core' ),
      'PA-6' => __( 'Herrera', 'luxus-core' ),
      'PA-7' => __( 'Los Santos', 'luxus-core' ),
      'PA-8' => __( 'Panamá', 'luxus-core' ),
      'PA-9' => __( 'Veraguas', 'luxus-core' ),
      'PA-10' => __( 'West Panamá', 'luxus-core' ),
      'PA-EM' => __( 'Emberá', 'luxus-core' ),
      'PA-KY' => __( 'Guna Yala', 'luxus-core' ),
      'PA-NB' => __( 'Ngöbe-Buglé', 'luxus-core' ),
    ),
    'PE' => array( // Peruvian states.
      'PE-CAL' => __( 'El Callao', 'luxus-core' ),
      'PE-LMA' => __( 'Municipalidad Metropolitana de Lima', 'luxus-core' ),
      'PE-AMA' => __( 'Amazonas', 'luxus-core' ),
      'PE-ANC' => __( 'Ancash', 'luxus-core' ),
      'PE-APU' => __( 'Apurímac', 'luxus-core' ),
      'PE-ARE' => __( 'Arequipa', 'luxus-core' ),
      'PE-AYA' => __( 'Ayacucho', 'luxus-core' ),
      'PE-CAJ' => __( 'Cajamarca', 'luxus-core' ),
      'PE-CUS' => __( 'Cusco', 'luxus-core' ),
      'PE-HUV' => __( 'Huancavelica', 'luxus-core' ),
      'PE-HUC' => __( 'Huánuco', 'luxus-core' ),
      'PE-ICA' => __( 'Ica', 'luxus-core' ),
      'PE-JUN' => __( 'Junín', 'luxus-core' ),
      'PE-LAL' => __( 'La Libertad', 'luxus-core' ),
      'PE-LAM' => __( 'Lambayeque', 'luxus-core' ),
      'PE-LIM' => __( 'Lima', 'luxus-core' ),
      'PE-LOR' => __( 'Loreto', 'luxus-core' ),
      'PE-MDD' => __( 'Madre de Dios', 'luxus-core' ),
      'PE-MOQ' => __( 'Moquegua', 'luxus-core' ),
      'PE-PAS' => __( 'Pasco', 'luxus-core' ),
      'PE-PIU' => __( 'Piura', 'luxus-core' ),
      'PE-PUN' => __( 'Puno', 'luxus-core' ),
      'PE-SAM' => __( 'San Martín', 'luxus-core' ),
      'PE-TAC' => __( 'Tacna', 'luxus-core' ),
      'PE-TUM' => __( 'Tumbes', 'luxus-core' ),
      'PE-UCA' => __( 'Ucayali', 'luxus-core' ),
    ),
    'PH' => array( // Philippine provinces.
      'PH-ABR' => __( 'Abra', 'luxus-core' ),
      'PH-AGN' => __( 'Agusan del Norte', 'luxus-core' ),
      'PH-AGS' => __( 'Agusan del Sur', 'luxus-core' ),
      'PH-AKL' => __( 'Aklan', 'luxus-core' ),
      'PH-ALB' => __( 'Albay', 'luxus-core' ),
      'PH-ANT' => __( 'Antique', 'luxus-core' ),
      'PH-APA' => __( 'Apayao', 'luxus-core' ),
      'PH-AUR' => __( 'Aurora', 'luxus-core' ),
      'PH-BAS' => __( 'Basilan', 'luxus-core' ),
      'PH-BAN' => __( 'Bataan', 'luxus-core' ),
      'PH-BTN' => __( 'Batanes', 'luxus-core' ),
      'PH-BTG' => __( 'Batangas', 'luxus-core' ),
      'PH-BEN' => __( 'Benguet', 'luxus-core' ),
      'PH-BIL' => __( 'Biliran', 'luxus-core' ),
      'PH-BOH' => __( 'Bohol', 'luxus-core' ),
      'PH-BUK' => __( 'Bukidnon', 'luxus-core' ),
      'PH-BUL' => __( 'Bulacan', 'luxus-core' ),
      'PH-CAG' => __( 'Cagayan', 'luxus-core' ),
      'PH-CAN' => __( 'Camarines Norte', 'luxus-core' ),
      'PH-CAS' => __( 'Camarines Sur', 'luxus-core' ),
      'PH-CAM' => __( 'Camiguin', 'luxus-core' ),
      'PH-CAP' => __( 'Capiz', 'luxus-core' ),
      'PH-CAT' => __( 'Catanduanes', 'luxus-core' ),
      'PH-CAV' => __( 'Cavite', 'luxus-core' ),
      'PH-CEB' => __( 'Cebu', 'luxus-core' ),
      'PH-COM' => __( 'Compostela Valley', 'luxus-core' ),
      'PH-NCO' => __( 'Cotabato', 'luxus-core' ),
      'PH-DAV' => __( 'Davao del Norte', 'luxus-core' ),
      'PH-DAS' => __( 'Davao del Sur', 'luxus-core' ),
      'PH-DAC' => __( 'Davao Occidental', 'luxus-core' ),
      'PH-DAO' => __( 'Davao Oriental', 'luxus-core' ),
      'PH-DIN' => __( 'Dinagat Islands', 'luxus-core' ),
      'PH-EAS' => __( 'Eastern Samar', 'luxus-core' ),
      'PH-GUI' => __( 'Guimaras', 'luxus-core' ),
      'PH-IFU' => __( 'Ifugao', 'luxus-core' ),
      'PH-ILN' => __( 'Ilocos Norte', 'luxus-core' ),
      'PH-ILS' => __( 'Ilocos Sur', 'luxus-core' ),
      'PH-ILI' => __( 'Iloilo', 'luxus-core' ),
      'PH-ISA' => __( 'Isabela', 'luxus-core' ),
      'PH-KAL' => __( 'Kalinga', 'luxus-core' ),
      'PH-LUN' => __( 'La Union', 'luxus-core' ),
      'PH-LAG' => __( 'Laguna', 'luxus-core' ),
      'PH-LAN' => __( 'Lanao del Norte', 'luxus-core' ),
      'PH-LAS' => __( 'Lanao del Sur', 'luxus-core' ),
      'PH-LEY' => __( 'Leyte', 'luxus-core' ),
      'PH-MAG' => __( 'Maguindanao', 'luxus-core' ),
      'PH-MAD' => __( 'Marinduque', 'luxus-core' ),
      'PH-MAS' => __( 'Masbate', 'luxus-core' ),
      'PH-MSC' => __( 'Misamis Occidental', 'luxus-core' ),
      'PH-MSR' => __( 'Misamis Oriental', 'luxus-core' ),
      'PH-MOU' => __( 'Mountain Province', 'luxus-core' ),
      'PH-NEC' => __( 'Negros Occidental', 'luxus-core' ),
      'PH-NER' => __( 'Negros Oriental', 'luxus-core' ),
      'PH-NSA' => __( 'Northern Samar', 'luxus-core' ),
      'PH-NUE' => __( 'Nueva Ecija', 'luxus-core' ),
      'PH-NUV' => __( 'Nueva Vizcaya', 'luxus-core' ),
      'PH-MDC' => __( 'Occidental Mindoro', 'luxus-core' ),
      'PH-MDR' => __( 'Oriental Mindoro', 'luxus-core' ),
      'PH-PLW' => __( 'Palawan', 'luxus-core' ),
      'PH-PAM' => __( 'Pampanga', 'luxus-core' ),
      'PH-PAN' => __( 'Pangasinan', 'luxus-core' ),
      'PH-QUE' => __( 'Quezon', 'luxus-core' ),
      'PH-QUI' => __( 'Quirino', 'luxus-core' ),
      'PH-RIZ' => __( 'Rizal', 'luxus-core' ),
      'PH-ROM' => __( 'Romblon', 'luxus-core' ),
      'PH-WSA' => __( 'Samar', 'luxus-core' ),
      'PH-SAR' => __( 'Sarangani', 'luxus-core' ),
      'PH-SIQ' => __( 'Siquijor', 'luxus-core' ),
      'PH-SOR' => __( 'Sorsogon', 'luxus-core' ),
      'PH-SCO' => __( 'South Cotabato', 'luxus-core' ),
      'PH-SLE' => __( 'Southern Leyte', 'luxus-core' ),
      'PH-SUK' => __( 'Sultan Kudarat', 'luxus-core' ),
      'PH-SLU' => __( 'Sulu', 'luxus-core' ),
      'PH-SUN' => __( 'Surigao del Norte', 'luxus-core' ),
      'PH-SUR' => __( 'Surigao del Sur', 'luxus-core' ),
      'PH-TAR' => __( 'Tarlac', 'luxus-core' ),
      'PH-TAW' => __( 'Tawi-Tawi', 'luxus-core' ),
      'PH-ZMB' => __( 'Zambales', 'luxus-core' ),
      'PH-ZAN' => __( 'Zamboanga del Norte', 'luxus-core' ),
      'PH-ZAS' => __( 'Zamboanga del Sur', 'luxus-core' ),
      'PH-ZSI' => __( 'Zamboanga Sibugay', 'luxus-core' ),
      'PH-00'  => __( 'Metro Manila', 'luxus-core' ),
    ),
    'PK' => array( // Pakistani states.
      'PK-JK' => __( 'Azad Kashmir', 'luxus-core' ),
      'PK-BA' => __( 'Balochistan', 'luxus-core' ),
      'PK-TA' => __( 'FATA', 'luxus-core' ),
      'PK-GB' => __( 'Gilgit Baltistan', 'luxus-core' ),
      'PK-IS' => __( 'Islamabad Capital Territory', 'luxus-core' ),
      'PK-KP' => __( 'Khyber Pakhtunkhwa', 'luxus-core' ),
      'PK-PB' => __( 'Punjab', 'luxus-core' ),
      'PK-SD' => __( 'Sindh', 'luxus-core' ),
    ),
    'PY' => array( // Paraguayan states.
      'PY-ASU' => __( 'Asunción', 'luxus-core' ),
      'PY-1'   => __( 'Concepción', 'luxus-core' ),
      'PY-2'   => __( 'San Pedro', 'luxus-core' ),
      'PY-3'   => __( 'Cordillera', 'luxus-core' ),
      'PY-4'   => __( 'Guairá', 'luxus-core' ),
      'PY-5'   => __( 'Caaguazú', 'luxus-core' ),
      'PY-6'   => __( 'Caazapá', 'luxus-core' ),
      'PY-7'   => __( 'Itapúa', 'luxus-core' ),
      'PY-8'   => __( 'Misiones', 'luxus-core' ),
      'PY-9'   => __( 'Paraguarí', 'luxus-core' ),
      'PY-10'  => __( 'Alto Paraná', 'luxus-core' ),
      'PY-11'  => __( 'Central', 'luxus-core' ),
      'PY-12'  => __( 'Ñeembucú', 'luxus-core' ),
      'PY-13'  => __( 'Amambay', 'luxus-core' ),
      'PY-14'  => __( 'Canindeyú', 'luxus-core' ),
      'PY-15'  => __( 'Presidente Hayes', 'luxus-core' ),
      'PY-16'  => __( 'Alto Paraguay', 'luxus-core' ),
      'PY-17'  => __( 'Boquerón', 'luxus-core' ),
    ),
    'RO' => array( // Romanian states.
      'RO-AB' => __( 'Alba', 'luxus-core' ),
      'RO-AR' => __( 'Arad', 'luxus-core' ),
      'RO-AG' => __( 'Argeș', 'luxus-core' ),
      'RO-BC' => __( 'Bacău', 'luxus-core' ),
      'RO-BH' => __( 'Bihor', 'luxus-core' ),
      'RO-BN' => __( 'Bistrița-Năsăud', 'luxus-core' ),
      'RO-BT' => __( 'Botoșani', 'luxus-core' ),
      'RO-BR' => __( 'Brăila', 'luxus-core' ),
      'RO-BV' => __( 'Brașov', 'luxus-core' ),
      'RO-B'  => __( 'București', 'luxus-core' ),
      'RO-BZ' => __( 'Buzău', 'luxus-core' ),
      'RO-CL' => __( 'Călărași', 'luxus-core' ),
      'RO-CS' => __( 'Caraș-Severin', 'luxus-core' ),
      'RO-CJ' => __( 'Cluj', 'luxus-core' ),
      'RO-CT' => __( 'Constanța', 'luxus-core' ),
      'RO-CV' => __( 'Covasna', 'luxus-core' ),
      'RO-DB' => __( 'Dâmbovița', 'luxus-core' ),
      'RO-DJ' => __( 'Dolj', 'luxus-core' ),
      'RO-GL' => __( 'Galați', 'luxus-core' ),
      'RO-GR' => __( 'Giurgiu', 'luxus-core' ),
      'RO-GJ' => __( 'Gorj', 'luxus-core' ),
      'RO-HR' => __( 'Harghita', 'luxus-core' ),
      'RO-HD' => __( 'Hunedoara', 'luxus-core' ),
      'RO-IL' => __( 'Ialomița', 'luxus-core' ),
      'RO-IS' => __( 'Iași', 'luxus-core' ),
      'RO-IF' => __( 'Ilfov', 'luxus-core' ),
      'RO-MM' => __( 'Maramureș', 'luxus-core' ),
      'RO-MH' => __( 'Mehedinți', 'luxus-core' ),
      'RO-MS' => __( 'Mureș', 'luxus-core' ),
      'RO-NT' => __( 'Neamț', 'luxus-core' ),
      'RO-OT' => __( 'Olt', 'luxus-core' ),
      'RO-PH' => __( 'Prahova', 'luxus-core' ),
      'RO-SJ' => __( 'Sălaj', 'luxus-core' ),
      'RO-SM' => __( 'Satu Mare', 'luxus-core' ),
      'RO-SB' => __( 'Sibiu', 'luxus-core' ),
      'RO-SV' => __( 'Suceava', 'luxus-core' ),
      'RO-TR' => __( 'Teleorman', 'luxus-core' ),
      'RO-TM' => __( 'Timiș', 'luxus-core' ),
      'RO-TL' => __( 'Tulcea', 'luxus-core' ),
      'RO-VL' => __( 'Vâlcea', 'luxus-core' ),
      'RO-VS' => __( 'Vaslui', 'luxus-core' ),
      'RO-VN' => __( 'Vrancea', 'luxus-core' ),
    ),
    'SV' => array( // Salvadoran states.
      'SV-AH' => __( 'Ahuachapán', 'luxus-core' ),
      'SV-CA' => __( 'Cabañas', 'luxus-core' ),
      'SV-CH' => __( 'Chalatenango', 'luxus-core' ),
      'SV-CU' => __( 'Cuscatlán', 'luxus-core' ),
      'SV-LI' => __( 'La Libertad', 'luxus-core' ),
      'SV-MO' => __( 'Morazán', 'luxus-core' ),
      'SV-PA' => __( 'La Paz', 'luxus-core' ),
      'SV-SA' => __( 'Santa Ana', 'luxus-core' ),
      'SV-SM' => __( 'San Miguel', 'luxus-core' ),
      'SV-SO' => __( 'Sonsonate', 'luxus-core' ),
      'SV-SS' => __( 'San Salvador', 'luxus-core' ),
      'SV-SV' => __( 'San Vicente', 'luxus-core' ),
      'SV-UN' => __( 'La Unión', 'luxus-core' ),
      'SV-US' => __( 'Usulután', 'luxus-core' ),
    ),
    'TH' => array( // Thai states.
      'TH-37' => __( 'Amnat Charoen', 'luxus-core' ),
      'TH-15' => __( 'Ang Thong', 'luxus-core' ),
      'TH-14' => __( 'Ayutthaya', 'luxus-core' ),
      'TH-10' => __( 'Bangkok', 'luxus-core' ),
      'TH-38' => __( 'Bueng Kan', 'luxus-core' ),
      'TH-31' => __( 'Buri Ram', 'luxus-core' ),
      'TH-24' => __( 'Chachoengsao', 'luxus-core' ),
      'TH-18' => __( 'Chai Nat', 'luxus-core' ),
      'TH-36' => __( 'Chaiyaphum', 'luxus-core' ),
      'TH-22' => __( 'Chanthaburi', 'luxus-core' ),
      'TH-50' => __( 'Chiang Mai', 'luxus-core' ),
      'TH-57' => __( 'Chiang Rai', 'luxus-core' ),
      'TH-20' => __( 'Chonburi', 'luxus-core' ),
      'TH-86' => __( 'Chumphon', 'luxus-core' ),
      'TH-46' => __( 'Kalasin', 'luxus-core' ),
      'TH-62' => __( 'Kamphaeng Phet', 'luxus-core' ),
      'TH-71' => __( 'Kanchanaburi', 'luxus-core' ),
      'TH-40' => __( 'Khon Kaen', 'luxus-core' ),
      'TH-81' => __( 'Krabi', 'luxus-core' ),
      'TH-52' => __( 'Lampang', 'luxus-core' ),
      'TH-51' => __( 'Lamphun', 'luxus-core' ),
      'TH-42' => __( 'Loei', 'luxus-core' ),
      'TH-16' => __( 'Lopburi', 'luxus-core' ),
      'TH-58' => __( 'Mae Hong Son', 'luxus-core' ),
      'TH-44' => __( 'Maha Sarakham', 'luxus-core' ),
      'TH-49' => __( 'Mukdahan', 'luxus-core' ),
      'TH-26' => __( 'Nakhon Nayok', 'luxus-core' ),
      'TH-73' => __( 'Nakhon Pathom', 'luxus-core' ),
      'TH-48' => __( 'Nakhon Phanom', 'luxus-core' ),
      'TH-30' => __( 'Nakhon Ratchasima', 'luxus-core' ),
      'TH-60' => __( 'Nakhon Sawan', 'luxus-core' ),
      'TH-80' => __( 'Nakhon Si Thammarat', 'luxus-core' ),
      'TH-55' => __( 'Nan', 'luxus-core' ),
      'TH-96' => __( 'Narathiwat', 'luxus-core' ),
      'TH-39' => __( 'Nong Bua Lam Phu', 'luxus-core' ),
      'TH-43' => __( 'Nong Khai', 'luxus-core' ),
      'TH-12' => __( 'Nonthaburi', 'luxus-core' ),
      'TH-13' => __( 'Pathum Thani', 'luxus-core' ),
      'TH-94' => __( 'Pattani', 'luxus-core' ),
      'TH-82' => __( 'Phang Nga', 'luxus-core' ),
      'TH-93' => __( 'Phatthalung', 'luxus-core' ),
      'TH-56' => __( 'Phayao', 'luxus-core' ),
      'TH-67' => __( 'Phetchabun', 'luxus-core' ),
      'TH-76' => __( 'Phetchaburi', 'luxus-core' ),
      'TH-66' => __( 'Phichit', 'luxus-core' ),
      'TH-65' => __( 'Phitsanulok', 'luxus-core' ),
      'TH-54' => __( 'Phrae', 'luxus-core' ),
      'TH-83' => __( 'Phuket', 'luxus-core' ),
      'TH-25' => __( 'Prachin Buri', 'luxus-core' ),
      'TH-77' => __( 'Prachuap Khiri Khan', 'luxus-core' ),
      'TH-85' => __( 'Ranong', 'luxus-core' ),
      'TH-70' => __( 'Ratchaburi', 'luxus-core' ),
      'TH-21' => __( 'Rayong', 'luxus-core' ),
      'TH-45' => __( 'Roi Et', 'luxus-core' ),
      'TH-27' => __( 'Sa Kaeo', 'luxus-core' ),
      'TH-47' => __( 'Sakon Nakhon', 'luxus-core' ),
      'TH-11' => __( 'Samut Prakan', 'luxus-core' ),
      'TH-74' => __( 'Samut Sakhon', 'luxus-core' ),
      'TH-75' => __( 'Samut Songkhram', 'luxus-core' ),
      'TH-19' => __( 'Saraburi', 'luxus-core' ),
      'TH-91' => __( 'Satun', 'luxus-core' ),
      'TH-17' => __( 'Sing Buri', 'luxus-core' ),
      'TH-33' => __( 'Sisaket', 'luxus-core' ),
      'TH-90' => __( 'Songkhla', 'luxus-core' ),
      'TH-64' => __( 'Sukhothai', 'luxus-core' ),
      'TH-72' => __( 'Suphan Buri', 'luxus-core' ),
      'TH-84' => __( 'Surat Thani', 'luxus-core' ),
      'TH-32' => __( 'Surin', 'luxus-core' ),
      'TH-63' => __( 'Tak', 'luxus-core' ),
      'TH-92' => __( 'Trang', 'luxus-core' ),
      'TH-23' => __( 'Trat', 'luxus-core' ),
      'TH-34' => __( 'Ubon Ratchathani', 'luxus-core' ),
      'TH-41' => __( 'Udon Thani', 'luxus-core' ),
      'TH-61' => __( 'Uthai Thani', 'luxus-core' ),
      'TH-53' => __( 'Uttaradit', 'luxus-core' ),
      'TH-95' => __( 'Yala', 'luxus-core' ),
      'TH-35' => __( 'Yasothon', 'luxus-core' ),
    ),
    'TR' => array( // Turkish states.
      'TR-01' => __( 'Adana', 'luxus-core' ),
      'TR-02' => __( 'Adıyaman', 'luxus-core' ),
      'TR-03' => __( 'Afyon', 'luxus-core' ),
      'TR-04' => __( 'Ağrı', 'luxus-core' ),
      'TR-05' => __( 'Amasya', 'luxus-core' ),
      'TR-06' => __( 'Ankara', 'luxus-core' ),
      'TR-07' => __( 'Antalya', 'luxus-core' ),
      'TR-08' => __( 'Artvin', 'luxus-core' ),
      'TR-09' => __( 'Aydın', 'luxus-core' ),
      'TR-10' => __( 'Balıkesir', 'luxus-core' ),
      'TR-11' => __( 'Bilecik', 'luxus-core' ),
      'TR-12' => __( 'Bingöl', 'luxus-core' ),
      'TR-13' => __( 'Bitlis', 'luxus-core' ),
      'TR-14' => __( 'Bolu', 'luxus-core' ),
      'TR-15' => __( 'Burdur', 'luxus-core' ),
      'TR-16' => __( 'Bursa', 'luxus-core' ),
      'TR-17' => __( 'Çanakkale', 'luxus-core' ),
      'TR-18' => __( 'Çankırı', 'luxus-core' ),
      'TR-19' => __( 'Çorum', 'luxus-core' ),
      'TR-20' => __( 'Denizli', 'luxus-core' ),
      'TR-21' => __( 'Diyarbakır', 'luxus-core' ),
      'TR-22' => __( 'Edirne', 'luxus-core' ),
      'TR-23' => __( 'Elazığ', 'luxus-core' ),
      'TR-24' => __( 'Erzincan', 'luxus-core' ),
      'TR-25' => __( 'Erzurum', 'luxus-core' ),
      'TR-26' => __( 'Eskişehir', 'luxus-core' ),
      'TR-27' => __( 'Gaziantep', 'luxus-core' ),
      'TR-28' => __( 'Giresun', 'luxus-core' ),
      'TR-29' => __( 'Gümüşhane', 'luxus-core' ),
      'TR-30' => __( 'Hakkari', 'luxus-core' ),
      'TR-31' => __( 'Hatay', 'luxus-core' ),
      'TR-32' => __( 'Isparta', 'luxus-core' ),
      'TR-33' => __( 'İçel', 'luxus-core' ),
      'TR-34' => __( 'İstanbul', 'luxus-core' ),
      'TR-35' => __( 'İzmir', 'luxus-core' ),
      'TR-36' => __( 'Kars', 'luxus-core' ),
      'TR-37' => __( 'Kastamonu', 'luxus-core' ),
      'TR-38' => __( 'Kayseri', 'luxus-core' ),
      'TR-39' => __( 'Kırklareli', 'luxus-core' ),
      'TR-40' => __( 'Kırşehir', 'luxus-core' ),
      'TR-41' => __( 'Kocaeli', 'luxus-core' ),
      'TR-42' => __( 'Konya', 'luxus-core' ),
      'TR-43' => __( 'Kütahya', 'luxus-core' ),
      'TR-44' => __( 'Malatya', 'luxus-core' ),
      'TR-45' => __( 'Manisa', 'luxus-core' ),
      'TR-46' => __( 'Kahramanmaraş', 'luxus-core' ),
      'TR-47' => __( 'Mardin', 'luxus-core' ),
      'TR-48' => __( 'Muğla', 'luxus-core' ),
      'TR-49' => __( 'Muş', 'luxus-core' ),
      'TR-50' => __( 'Nevşehir', 'luxus-core' ),
      'TR-51' => __( 'Niğde', 'luxus-core' ),
      'TR-52' => __( 'Ordu', 'luxus-core' ),
      'TR-53' => __( 'Rize', 'luxus-core' ),
      'TR-54' => __( 'Sakarya', 'luxus-core' ),
      'TR-55' => __( 'Samsun', 'luxus-core' ),
      'TR-56' => __( 'Siirt', 'luxus-core' ),
      'TR-57' => __( 'Sinop', 'luxus-core' ),
      'TR-58' => __( 'Sivas', 'luxus-core' ),
      'TR-59' => __( 'Tekirdağ', 'luxus-core' ),
      'TR-60' => __( 'Tokat', 'luxus-core' ),
      'TR-61' => __( 'Trabzon', 'luxus-core' ),
      'TR-62' => __( 'Tunceli', 'luxus-core' ),
      'TR-63' => __( 'Şanlıurfa', 'luxus-core' ),
      'TR-64' => __( 'Uşak', 'luxus-core' ),
      'TR-65' => __( 'Van', 'luxus-core' ),
      'TR-66' => __( 'Yozgat', 'luxus-core' ),
      'TR-67' => __( 'Zonguldak', 'luxus-core' ),
      'TR-68' => __( 'Aksaray', 'luxus-core' ),
      'TR-69' => __( 'Bayburt', 'luxus-core' ),
      'TR-70' => __( 'Karaman', 'luxus-core' ),
      'TR-71' => __( 'Kırıkkale', 'luxus-core' ),
      'TR-72' => __( 'Batman', 'luxus-core' ),
      'TR-73' => __( 'Şırnak', 'luxus-core' ),
      'TR-74' => __( 'Bartın', 'luxus-core' ),
      'TR-75' => __( 'Ardahan', 'luxus-core' ),
      'TR-76' => __( 'Iğdır', 'luxus-core' ),
      'TR-77' => __( 'Yalova', 'luxus-core' ),
      'TR-78' => __( 'Karabük', 'luxus-core' ),
      'TR-79' => __( 'Kilis', 'luxus-core' ),
      'TR-80' => __( 'Osmaniye', 'luxus-core' ),
      'TR-81' => __( 'Düzce', 'luxus-core' ),
    ),
    'TZ' => array( // Tanzanian states.
      'TZ-01' => __( 'Arusha', 'luxus-core' ),
      'TZ-02' => __( 'Dar es Salaam', 'luxus-core' ),
      'TZ-03' => __( 'Dodoma', 'luxus-core' ),
      'TZ-04' => __( 'Iringa', 'luxus-core' ),
      'TZ-05' => __( 'Kagera', 'luxus-core' ),
      'TZ-06' => __( 'Pemba North', 'luxus-core' ),
      'TZ-07' => __( 'Zanzibar North', 'luxus-core' ),
      'TZ-08' => __( 'Kigoma', 'luxus-core' ),
      'TZ-09' => __( 'Kilimanjaro', 'luxus-core' ),
      'TZ-10' => __( 'Pemba South', 'luxus-core' ),
      'TZ-11' => __( 'Zanzibar South', 'luxus-core' ),
      'TZ-12' => __( 'Lindi', 'luxus-core' ),
      'TZ-13' => __( 'Mara', 'luxus-core' ),
      'TZ-14' => __( 'Mbeya', 'luxus-core' ),
      'TZ-15' => __( 'Zanzibar West', 'luxus-core' ),
      'TZ-16' => __( 'Morogoro', 'luxus-core' ),
      'TZ-17' => __( 'Mtwara', 'luxus-core' ),
      'TZ-18' => __( 'Mwanza', 'luxus-core' ),
      'TZ-19' => __( 'Coast', 'luxus-core' ),
      'TZ-20' => __( 'Rukwa', 'luxus-core' ),
      'TZ-21' => __( 'Ruvuma', 'luxus-core' ),
      'TZ-22' => __( 'Shinyanga', 'luxus-core' ),
      'TZ-23' => __( 'Singida', 'luxus-core' ),
      'TZ-24' => __( 'Tabora', 'luxus-core' ),
      'TZ-25' => __( 'Tanga', 'luxus-core' ),
      'TZ-26' => __( 'Manyara', 'luxus-core' ),
      'TZ-27' => __( 'Geita', 'luxus-core' ),
      'TZ-28' => __( 'Katavi', 'luxus-core' ),
      'TZ-29' => __( 'Njombe', 'luxus-core' ),
      'TZ-30' => __( 'Simiyu', 'luxus-core' ),
    ),
    'RS' => array( // Serbian districts.
      'RS-00' => _x( 'Belgrade', 'district', 'luxus-core' ),
      'RS-14' => _x( 'Bor', 'district', 'luxus-core' ),
      'RS-11' => _x( 'Braničevo', 'district', 'luxus-core' ),
      'RS-02' => _x( 'Central Banat', 'district', 'luxus-core' ),
      'RS-10' => _x( 'Danube', 'district', 'luxus-core' ),
      'RS-23' => _x( 'Jablanica', 'district', 'luxus-core' ),
      'RS-09' => _x( 'Kolubara', 'district', 'luxus-core' ),
      'RS-08' => _x( 'Mačva', 'district', 'luxus-core' ),
      'RS-17' => _x( 'Morava', 'district', 'luxus-core' ),
      'RS-20' => _x( 'Nišava', 'district', 'luxus-core' ),
      'RS-01' => _x( 'North Bačka', 'district', 'luxus-core' ),
      'RS-03' => _x( 'North Banat', 'district', 'luxus-core' ),
      'RS-24' => _x( 'Pčinja', 'district', 'luxus-core' ),
      'RS-22' => _x( 'Pirot', 'district', 'luxus-core' ),
      'RS-13' => _x( 'Pomoravlje', 'district', 'luxus-core' ),
      'RS-19' => _x( 'Rasina', 'district', 'luxus-core' ),
      'RS-18' => _x( 'Raška', 'district', 'luxus-core' ),
      'RS-06' => _x( 'South Bačka', 'district', 'luxus-core' ),
      'RS-04' => _x( 'South Banat', 'district', 'luxus-core' ),
      'RS-07' => _x( 'Srem', 'district', 'luxus-core' ),
      'RS-12' => _x( 'Šumadija', 'district', 'luxus-core' ),
      'RS-21' => _x( 'Toplica', 'district', 'luxus-core' ),
      'RS-05' => _x( 'West Bačka', 'district', 'luxus-core' ),
      'RS-15' => _x( 'Zaječar', 'district', 'luxus-core' ),
      'RS-16' => _x( 'Zlatibor', 'district', 'luxus-core' ),
      'RS-25' => _x( 'Kosovo', 'district', 'luxus-core' ),
      'RS-26' => _x( 'Peć', 'district', 'luxus-core' ),
      'RS-27' => _x( 'Prizren', 'district', 'luxus-core' ),
      'RS-28' => _x( 'Kosovska Mitrovica', 'district', 'luxus-core' ),
      'RS-29' => _x( 'Kosovo-Pomoravlje', 'district', 'luxus-core' ),
      'RS-KM' => _x( 'Kosovo-Metohija', 'district', 'luxus-core' ),
      'RS-VO' => _x( 'Vojvodina', 'district', 'luxus-core' ),
    ),
    'UA' => array( // Ukrainian oblasts.
      'UA-VN' => __( 'Vinnytsia Oblast', 'luxus-core' ),
      'UA-VL' => __( 'Volyn Oblast', 'luxus-core' ),
      'UA-DP' => __( 'Dnipropetrovsk Oblast', 'luxus-core' ),
      'UA-DT' => __( 'Donetsk Oblast', 'luxus-core' ),
      'UA-ZT' => __( 'Zhytomyr Oblast', 'luxus-core' ),
      'UA-ZK' => __( 'Zakarpattia Oblast', 'luxus-core' ),
      'UA-ZP' => __( 'Zaporizhzhia Oblast', 'luxus-core' ),
      'UA-IF' => __( 'Ivano-Frankivsk Oblast', 'luxus-core' ),
      'UA-KV' => __( 'Kyiv Oblast', 'luxus-core' ),
      'UA-KH' => __( 'Kirovohrad Oblast', 'luxus-core' ),
      'UA-LH' => __( 'Luhansk Oblast', 'luxus-core' ),
      'UA-LV' => __( 'Lviv Oblast', 'luxus-core' ),
      'UA-MY' => __( 'Mykolaiv Oblast', 'luxus-core' ),
      'UA-OD' => __( 'Odessa Oblast', 'luxus-core' ),
      'UA-PL' => __( 'Poltava Oblast', 'luxus-core' ),
      'UA-RV' => __( 'Rivne Oblast', 'luxus-core' ),
      'UA-SM' => __( 'Sumy Oblast', 'luxus-core' ),
      'UA-TP' => __( 'Ternopil Oblast', 'luxus-core' ),
      'UA-KK' => __( 'Kharkiv Oblast', 'luxus-core' ),
      'UA-KS' => __( 'Kherson Oblast', 'luxus-core' ),
      'UA-KM' => __( 'Khmelnytskyi Oblast', 'luxus-core' ),
      'UA-CK' => __( 'Cherkasy Oblast', 'luxus-core' ),
      'UA-CH' => __( 'Chernihiv Oblast', 'luxus-core' ),
      'UA-CV' => __( 'Chernivtsi Oblast', 'luxus-core' ),
    ),
    'UG' => array( // Ugandan districts.
      'UG-314' => __( 'Abim', 'luxus-core' ),
      'UG-301' => __( 'Adjumani', 'luxus-core' ),
      'UG-322' => __( 'Agago', 'luxus-core' ),
      'UG-323' => __( 'Alebtong', 'luxus-core' ),
      'UG-315' => __( 'Amolatar', 'luxus-core' ),
      'UG-324' => __( 'Amudat', 'luxus-core' ),
      'UG-216' => __( 'Amuria', 'luxus-core' ),
      'UG-316' => __( 'Amuru', 'luxus-core' ),
      'UG-302' => __( 'Apac', 'luxus-core' ),
      'UG-303' => __( 'Arua', 'luxus-core' ),
      'UG-217' => __( 'Budaka', 'luxus-core' ),
      'UG-218' => __( 'Bududa', 'luxus-core' ),
      'UG-201' => __( 'Bugiri', 'luxus-core' ),
      'UG-235' => __( 'Bugweri', 'luxus-core' ),
      'UG-420' => __( 'Buhweju', 'luxus-core' ),
      'UG-117' => __( 'Buikwe', 'luxus-core' ),
      'UG-219' => __( 'Bukedea', 'luxus-core' ),
      'UG-118' => __( 'Bukomansimbi', 'luxus-core' ),
      'UG-220' => __( 'Bukwa', 'luxus-core' ),
      'UG-225' => __( 'Bulambuli', 'luxus-core' ),
      'UG-416' => __( 'Buliisa', 'luxus-core' ),
      'UG-401' => __( 'Bundibugyo', 'luxus-core' ),
      'UG-430' => __( 'Bunyangabu', 'luxus-core' ),
      'UG-402' => __( 'Bushenyi', 'luxus-core' ),
      'UG-202' => __( 'Busia', 'luxus-core' ),
      'UG-221' => __( 'Butaleja', 'luxus-core' ),
      'UG-119' => __( 'Butambala', 'luxus-core' ),
      'UG-233' => __( 'Butebo', 'luxus-core' ),
      'UG-120' => __( 'Buvuma', 'luxus-core' ),
      'UG-226' => __( 'Buyende', 'luxus-core' ),
      'UG-317' => __( 'Dokolo', 'luxus-core' ),
      'UG-121' => __( 'Gomba', 'luxus-core' ),
      'UG-304' => __( 'Gulu', 'luxus-core' ),
      'UG-403' => __( 'Hoima', 'luxus-core' ),
      'UG-417' => __( 'Ibanda', 'luxus-core' ),
      'UG-203' => __( 'Iganga', 'luxus-core' ),
      'UG-418' => __( 'Isingiro', 'luxus-core' ),
      'UG-204' => __( 'Jinja', 'luxus-core' ),
      'UG-318' => __( 'Kaabong', 'luxus-core' ),
      'UG-404' => __( 'Kabale', 'luxus-core' ),
      'UG-405' => __( 'Kabarole', 'luxus-core' ),
      'UG-213' => __( 'Kaberamaido', 'luxus-core' ),
      'UG-427' => __( 'Kagadi', 'luxus-core' ),
      'UG-428' => __( 'Kakumiro', 'luxus-core' ),
      'UG-101' => __( 'Kalangala', 'luxus-core' ),
      'UG-222' => __( 'Kaliro', 'luxus-core' ),
      'UG-122' => __( 'Kalungu', 'luxus-core' ),
      'UG-102' => __( 'Kampala', 'luxus-core' ),
      'UG-205' => __( 'Kamuli', 'luxus-core' ),
      'UG-413' => __( 'Kamwenge', 'luxus-core' ),
      'UG-414' => __( 'Kanungu', 'luxus-core' ),
      'UG-206' => __( 'Kapchorwa', 'luxus-core' ),
      'UG-236' => __( 'Kapelebyong', 'luxus-core' ),
      'UG-126' => __( 'Kasanda', 'luxus-core' ),
      'UG-406' => __( 'Kasese', 'luxus-core' ),
      'UG-207' => __( 'Katakwi', 'luxus-core' ),
      'UG-112' => __( 'Kayunga', 'luxus-core' ),
      'UG-407' => __( 'Kibaale', 'luxus-core' ),
      'UG-103' => __( 'Kiboga', 'luxus-core' ),
      'UG-227' => __( 'Kibuku', 'luxus-core' ),
      'UG-432' => __( 'Kikuube', 'luxus-core' ),
      'UG-419' => __( 'Kiruhura', 'luxus-core' ),
      'UG-421' => __( 'Kiryandongo', 'luxus-core' ),
      'UG-408' => __( 'Kisoro', 'luxus-core' ),
      'UG-305' => __( 'Kitgum', 'luxus-core' ),
      'UG-319' => __( 'Koboko', 'luxus-core' ),
      'UG-325' => __( 'Kole', 'luxus-core' ),
      'UG-306' => __( 'Kotido', 'luxus-core' ),
      'UG-208' => __( 'Kumi', 'luxus-core' ),
      'UG-333' => __( 'Kwania', 'luxus-core' ),
      'UG-228' => __( 'Kween', 'luxus-core' ),
      'UG-123' => __( 'Kyankwanzi', 'luxus-core' ),
      'UG-422' => __( 'Kyegegwa', 'luxus-core' ),
      'UG-415' => __( 'Kyenjojo', 'luxus-core' ),
      'UG-125' => __( 'Kyotera', 'luxus-core' ),
      'UG-326' => __( 'Lamwo', 'luxus-core' ),
      'UG-307' => __( 'Lira', 'luxus-core' ),
      'UG-229' => __( 'Luuka', 'luxus-core' ),
      'UG-104' => __( 'Luwero', 'luxus-core' ),
      'UG-124' => __( 'Lwengo', 'luxus-core' ),
      'UG-114' => __( 'Lyantonde', 'luxus-core' ),
      'UG-223' => __( 'Manafwa', 'luxus-core' ),
      'UG-320' => __( 'Maracha', 'luxus-core' ),
      'UG-105' => __( 'Masaka', 'luxus-core' ),
      'UG-409' => __( 'Masindi', 'luxus-core' ),
      'UG-214' => __( 'Mayuge', 'luxus-core' ),
      'UG-209' => __( 'Mbale', 'luxus-core' ),
      'UG-410' => __( 'Mbarara', 'luxus-core' ),
      'UG-423' => __( 'Mitooma', 'luxus-core' ),
      'UG-115' => __( 'Mityana', 'luxus-core' ),
      'UG-308' => __( 'Moroto', 'luxus-core' ),
      'UG-309' => __( 'Moyo', 'luxus-core' ),
      'UG-106' => __( 'Mpigi', 'luxus-core' ),
      'UG-107' => __( 'Mubende', 'luxus-core' ),
      'UG-108' => __( 'Mukono', 'luxus-core' ),
      'UG-334' => __( 'Nabilatuk', 'luxus-core' ),
      'UG-311' => __( 'Nakapiripirit', 'luxus-core' ),
      'UG-116' => __( 'Nakaseke', 'luxus-core' ),
      'UG-109' => __( 'Nakasongola', 'luxus-core' ),
      'UG-230' => __( 'Namayingo', 'luxus-core' ),
      'UG-234' => __( 'Namisindwa', 'luxus-core' ),
      'UG-224' => __( 'Namutumba', 'luxus-core' ),
      'UG-327' => __( 'Napak', 'luxus-core' ),
      'UG-310' => __( 'Nebbi', 'luxus-core' ),
      'UG-231' => __( 'Ngora', 'luxus-core' ),
      'UG-424' => __( 'Ntoroko', 'luxus-core' ),
      'UG-411' => __( 'Ntungamo', 'luxus-core' ),
      'UG-328' => __( 'Nwoya', 'luxus-core' ),
      'UG-331' => __( 'Omoro', 'luxus-core' ),
      'UG-329' => __( 'Otuke', 'luxus-core' ),
      'UG-321' => __( 'Oyam', 'luxus-core' ),
      'UG-312' => __( 'Pader', 'luxus-core' ),
      'UG-332' => __( 'Pakwach', 'luxus-core' ),
      'UG-210' => __( 'Pallisa', 'luxus-core' ),
      'UG-110' => __( 'Rakai', 'luxus-core' ),
      'UG-429' => __( 'Rubanda', 'luxus-core' ),
      'UG-425' => __( 'Rubirizi', 'luxus-core' ),
      'UG-431' => __( 'Rukiga', 'luxus-core' ),
      'UG-412' => __( 'Rukungiri', 'luxus-core' ),
      'UG-111' => __( 'Sembabule', 'luxus-core' ),
      'UG-232' => __( 'Serere', 'luxus-core' ),
      'UG-426' => __( 'Sheema', 'luxus-core' ),
      'UG-215' => __( 'Sironko', 'luxus-core' ),
      'UG-211' => __( 'Soroti', 'luxus-core' ),
      'UG-212' => __( 'Tororo', 'luxus-core' ),
      'UG-113' => __( 'Wakiso', 'luxus-core' ),
      'UG-313' => __( 'Yumbe', 'luxus-core' ),
      'UG-330' => __( 'Zombo', 'luxus-core' ),
    ),
    'UM' => array(
      'UM-81' => __( 'Baker Island', 'luxus-core' ),
      'UM-84' => __( 'Howland Island', 'luxus-core' ),
      'UM-86' => __( 'Jarvis Island', 'luxus-core' ),
      'UM-67' => __( 'Johnston Atoll', 'luxus-core' ),
      'UM-89' => __( 'Kingman Reef', 'luxus-core' ),
      'UM-71' => __( 'Midway Atoll', 'luxus-core' ),
      'UM-76' => __( 'Navassa Island', 'luxus-core' ),
      'UM-95' => __( 'Palmyra Atoll', 'luxus-core' ),
      'UM-79' => __( 'Wake Island', 'luxus-core' ),
    ),
    'US' => array( // U.S. states.
      'US-AL' => __( 'Alabama', 'luxus-core' ),
      'US-AK' => __( 'Alaska', 'luxus-core' ),
      'US-AZ' => __( 'Arizona', 'luxus-core' ),
      'US-AR' => __( 'Arkansas', 'luxus-core' ),
      'US-CA' => __( 'California', 'luxus-core' ),
      'US-CO' => __( 'Colorado', 'luxus-core' ),
      'US-CT' => __( 'Connecticut', 'luxus-core' ),
      'US-DE' => __( 'Delaware', 'luxus-core' ),
      'US-DC' => __( 'District Of Columbia', 'luxus-core' ),
      'US-FL' => __( 'Florida', 'luxus-core' ),
      'US-GA' => _x( 'Georgia', 'US state of Georgia', 'luxus-core' ),
      'US-HI' => __( 'Hawaii', 'luxus-core' ),
      'US-ID' => __( 'Idaho', 'luxus-core' ),
      'US-IL' => __( 'Illinois', 'luxus-core' ),
      'US-IN' => __( 'Indiana', 'luxus-core' ),
      'US-IA' => __( 'Iowa', 'luxus-core' ),
      'US-KS' => __( 'Kansas', 'luxus-core' ),
      'US-KY' => __( 'Kentucky', 'luxus-core' ),
      'US-LA' => __( 'Louisiana', 'luxus-core' ),
      'US-ME' => __( 'Maine', 'luxus-core' ),
      'US-MD' => __( 'Maryland', 'luxus-core' ),
      'US-MA' => __( 'Massachusetts', 'luxus-core' ),
      'US-MI' => __( 'Michigan', 'luxus-core' ),
      'US-MN' => __( 'Minnesota', 'luxus-core' ),
      'US-MS' => __( 'Mississippi', 'luxus-core' ),
      'US-MO' => __( 'Missouri', 'luxus-core' ),
      'US-MT' => __( 'Montana', 'luxus-core' ),
      'US-NE' => __( 'Nebraska', 'luxus-core' ),
      'US-NV' => __( 'Nevada', 'luxus-core' ),
      'US-NH' => __( 'New Hampshire', 'luxus-core' ),
      'US-NJ' => __( 'New Jersey', 'luxus-core' ),
      'US-NM' => __( 'New Mexico', 'luxus-core' ),
      'US-NY' => __( 'New York', 'luxus-core' ),
      'US-NC' => __( 'North Carolina', 'luxus-core' ),
      'US-ND' => __( 'North Dakota', 'luxus-core' ),
      'US-OH' => __( 'Ohio', 'luxus-core' ),
      'US-OK' => __( 'Oklahoma', 'luxus-core' ),
      'US-OR' => __( 'Oregon', 'luxus-core' ),
      'US-PA' => __( 'Pennsylvania', 'luxus-core' ),
      'US-RI' => __( 'Rhode Island', 'luxus-core' ),
      'US-SC' => __( 'South Carolina', 'luxus-core' ),
      'US-SD' => __( 'South Dakota', 'luxus-core' ),
      'US-TN' => __( 'Tennessee', 'luxus-core' ),
      'US-TX' => __( 'Texas', 'luxus-core' ),
      'US-UT' => __( 'Utah', 'luxus-core' ),
      'US-VT' => __( 'Vermont', 'luxus-core' ),
      'US-VA' => __( 'Virginia', 'luxus-core' ),
      'US-WA' => __( 'Washington', 'luxus-core' ),
      'US-WV' => __( 'West Virginia', 'luxus-core' ),
      'US-WI' => __( 'Wisconsin', 'luxus-core' ),
      'US-WY' => __( 'Wyoming', 'luxus-core' ),
      'US-AA' => __( 'Armed Forces (AA)', 'luxus-core' ),
      'US-AE' => __( 'Armed Forces (AE)', 'luxus-core' ),
      'US-AP' => __( 'Armed Forces (AP)', 'luxus-core' ),
    ),
    'UY' => array( // Uruguayan states.
      'UY-AR' => __( 'Artigas', 'luxus-core' ),
      'UY-CA' => __( 'Canelones', 'luxus-core' ),
      'UY-CL' => __( 'Cerro Largo', 'luxus-core' ),
      'UY-CO' => __( 'Colonia', 'luxus-core' ),
      'UY-DU' => __( 'Durazno', 'luxus-core' ),
      'UY-FS' => __( 'Flores', 'luxus-core' ),
      'UY-FD' => __( 'Florida', 'luxus-core' ),
      'UY-LA' => __( 'Lavalleja', 'luxus-core' ),
      'UY-MA' => __( 'Maldonado', 'luxus-core' ),
      'UY-MO' => __( 'Montevideo', 'luxus-core' ),
      'UY-PA' => __( 'Paysandú', 'luxus-core' ),
      'UY-RN' => __( 'Río Negro', 'luxus-core' ),
      'UY-RV' => __( 'Rivera', 'luxus-core' ),
      'UY-RO' => __( 'Rocha', 'luxus-core' ),
      'UY-SA' => __( 'Salto', 'luxus-core' ),
      'UY-SJ' => __( 'San José', 'luxus-core' ),
      'UY-SO' => __( 'Soriano', 'luxus-core' ),
      'UY-TA' => __( 'Tacuarembó', 'luxus-core' ),
      'UY-TT' => __( 'Treinta y Tres', 'luxus-core' ),
    ),
    'VE' => array( // Venezuelan states.
      'VE-A' => __( 'Capital', 'luxus-core' ),
      'VE-B' => __( 'Anzoátegui', 'luxus-core' ),
      'VE-C' => __( 'Apure', 'luxus-core' ),
      'VE-D' => __( 'Aragua', 'luxus-core' ),
      'VE-E' => __( 'Barinas', 'luxus-core' ),
      'VE-F' => __( 'Bolívar', 'luxus-core' ),
      'VE-G' => __( 'Carabobo', 'luxus-core' ),
      'VE-H' => __( 'Cojedes', 'luxus-core' ),
      'VE-I' => __( 'Falcón', 'luxus-core' ),
      'VE-J' => __( 'Guárico', 'luxus-core' ),
      'VE-K' => __( 'Lara', 'luxus-core' ),
      'VE-L' => __( 'Mérida', 'luxus-core' ),
      'VE-M' => __( 'Miranda', 'luxus-core' ),
      'VE-N' => __( 'Monagas', 'luxus-core' ),
      'VE-O' => __( 'Nueva Esparta', 'luxus-core' ),
      'VE-P' => __( 'Portuguesa', 'luxus-core' ),
      'VE-R' => __( 'Sucre', 'luxus-core' ),
      'VE-S' => __( 'Táchira', 'luxus-core' ),
      'VE-T' => __( 'Trujillo', 'luxus-core' ),
      'VE-U' => __( 'Yaracuy', 'luxus-core' ),
      'VE-V' => __( 'Zulia', 'luxus-core' ),
      'VE-W' => __( 'Federal Dependencies', 'luxus-core' ),
      'VE-X' => __( 'La Guaira (Vargas)', 'luxus-core' ),
      'VE-Y' => __( 'Delta Amacuro', 'luxus-core' ),
      'VE-Z' => __( 'Amazonas', 'luxus-core' ),
    ),
    'ZA' => array( // South African states.
      'ZA-EC'  => __( 'Eastern Cape', 'luxus-core' ),
      'ZA-FS'  => __( 'Free State', 'luxus-core' ),
      'ZA-GP'  => __( 'Gauteng', 'luxus-core' ),
      'ZA-KZN' => __( 'KwaZulu-Natal', 'luxus-core' ),
      'ZA-LP'  => __( 'Limpopo', 'luxus-core' ),
      'ZA-MP'  => __( 'Mpumalanga', 'luxus-core' ),
      'ZA-NC'  => __( 'Northern Cape', 'luxus-core' ),
      'ZA-NW'  => __( 'North West', 'luxus-core' ),
      'ZA-WC'  => __( 'Western Cape', 'luxus-core' ),
    ),
    'ZM' => array( // Zambian provinces.
      'ZM-01' => __( 'Western', 'luxus-core' ),
      'ZM-02' => __( 'Central', 'luxus-core' ),
      'ZM-03' => __( 'Eastern', 'luxus-core' ),
      'ZM-04' => __( 'Luapula', 'luxus-core' ),
      'ZM-05' => __( 'Northern', 'luxus-core' ),
      'ZM-06' => __( 'North-Western', 'luxus-core' ),
      'ZM-07' => __( 'Southern', 'luxus-core' ),
      'ZM-08' => __( 'Copperbelt', 'luxus-core' ),
      'ZM-09' => __( 'Lusaka', 'luxus-core' ),
      'ZM-10' => __( 'Muchinga', 'luxus-core' ),
    ),
  );

  return $states;
}

/**
 * State Name
 */
function luxus_state_name( $state_key ) {

    $states = luxus_states_list();
    
    foreach ( $states as $state ) {

        foreach ($state as $key => $value) {

            if ( $key == $state_key ) {
                return $value;
            }
        }
    }
}
