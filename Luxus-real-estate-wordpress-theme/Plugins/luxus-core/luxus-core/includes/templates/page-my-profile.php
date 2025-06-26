<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * Template Name: My Profile
 */

// Custom Page Title
function luxus_my_profile_page_title() {
    return esc_html__('My Profile', 'luxus-core') . ' - ' . get_bloginfo();
}
add_action( 'pre_get_document_title', 'luxus_my_profile_page_title' );

// Enqueue Scripts
function luxus_my_profile_enqueue() {
	
	// Media
    wp_enqueue_media();
    wp_register_script('mediaelement', plugins_url('wp-mediaelement.min.js', __FILE__), array('jquery'), '4.8.2', true);
    wp_enqueue_script('mediaelement');
    wp_enqueue_script('media-profile', SL_PLUGIN_URL . 'public/js/media-profile.js', array('jquery'), '1.0', true);
	
	// Leaflet Js
	wp_enqueue_script( 'leaflet', SL_PLUGIN_URL . 'public/js/leaflet.min.js', array( 'jquery' ), '1.7.1', true );
	
	// Leaflet Js Css
	wp_enqueue_style( 'leaflet', SL_PLUGIN_URL . 'public/css/leaflet.min.css', array(), '1.7.1', 'all' );
	
}
add_action('wp_enqueue_scripts', 'luxus_my_profile_enqueue');

// Profile Update
$error = array();

$current_user = wp_get_current_user();

$user_role = $current_user->roles['0'];

// Profile Update
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {
 
    // Update User Profile
    if ( !empty( $_POST['firstname'] ) ) {
        update_user_meta( $current_user->ID, 'first_name', esc_attr( $_POST['firstname'] ) );
    }
    if ( !empty( $_POST['lastname'] ) ){
        update_user_meta( $current_user->ID, 'last_name', esc_attr( $_POST['lastname'] ) );
    }
    if ( !empty( $_POST['designation'] ) ){
        update_user_meta( $current_user->ID, 'luxus_user_designation', esc_attr( $_POST['designation'] ) );
    }
    if ( !empty( $_POST['license'] ) ){
        update_user_meta( $current_user->ID, 'luxus_user_license', esc_attr( $_POST['license'] ) );
    }
    if ( !empty( $_POST['taxnumber'] ) ){
        update_user_meta( $current_user->ID, 'luxus_user_tax', esc_attr( $_POST['taxnumber'] ) );
    }
    if ( !empty( $_POST['phone'] ) ){
        update_user_meta( $current_user->ID, 'luxus_user_phone', esc_attr( $_POST['phone'] ) );
    }
    if ( !empty( $_POST['mobile'] ) ){
        update_user_meta( $current_user->ID, 'luxus_user_mobile', esc_attr( $_POST['mobile'] ) );
    }
    if ( !empty( $_POST['fax'] ) ){
        update_user_meta( $current_user->ID, 'luxus_user_fax', esc_attr( $_POST['fax'] ) );
    }
    if ( !empty( $_POST['city'] ) ){
        update_user_meta( $current_user->ID, 'luxus_user_city', esc_attr( $_POST['city'] ) );
    }
    if ( !empty( $_POST['state'] ) ){
        update_user_meta( $current_user->ID, 'luxus_user_state', esc_attr( $_POST['state'] ) );
    }
    if ( !empty( $_POST['zip'] ) ){
        update_user_meta( $current_user->ID, 'luxus_user_postcode', esc_attr( $_POST['zip'] ) );
    }
    if ( !empty( $_POST['staddressone'] ) ){
        update_user_meta( $current_user->ID, 'luxus_user_address_one', esc_attr( $_POST['staddressone'] ) );
    }
    if ( !empty( $_POST['staddresstwo'] ) ){
        update_user_meta( $current_user->ID, 'luxus_user_address_two', esc_attr( $_POST['staddresstwo'] ) );
    }
    if ( !empty( $_POST['country'] ) ){
        update_user_meta( $current_user->ID, 'luxus_user_country', esc_attr( $_POST['country'] ) );
    }
    if ( !empty( $_POST['about'] ) ){
        update_user_meta( $current_user->ID, 'description', esc_attr( $_POST['about'] ) );
    }

    // Update User Profile Social Accounts
    if ( !empty( $_POST['website'] ) ){
        update_user_meta( $current_user->ID, 'user_url', esc_attr( $_POST['website'] ) );
    }
    if ( !empty( $_POST['facebook'] ) ){
        update_user_meta( $current_user->ID, 'luxus_user_facebook', esc_attr( $_POST['facebook'] ) );
    }
    if ( !empty( $_POST['twitter'] ) ){
        update_user_meta( $current_user->ID, 'luxus_user_twitter', esc_attr( $_POST['twitter'] ) );
    }
    if ( !empty( $_POST['linkedin'] ) ){
        update_user_meta( $current_user->ID, 'luxus_user_linkedin', esc_attr( $_POST['linkedin'] ) );
    }
    if ( !empty( $_POST['instagram'] ) ){
        update_user_meta( $current_user->ID, 'luxus_user_instagram', esc_attr( $_POST['instagram'] ) );
    }
    if ( !empty( $_POST['pinterest'] ) ){
        update_user_meta( $current_user->ID, 'luxus_user_pinterest', esc_attr( $_POST['pinterest'] ) );
    }
    if ( !empty( $_POST['youtube'] ) ){
        update_user_meta( $current_user->ID, 'luxus_user_youtube', esc_attr( $_POST['youtube'] ) );
    }

    // User Profile Image

    if ( !empty( $_POST['user_img'] ) ) {

        $user_profile_img_data = $_POST['user_img'] ;

        update_user_meta( $current_user->ID, 'luxus_user_profile_img', $user_profile_img_data );
    }

    // User Cover Image

    if ( !empty( $_POST['user_cover'] ) ) {

        $user_thumbnail_img_data = $_POST['user_cover'] ;

        update_user_meta( $current_user->ID, 'luxus_user_profile_thumbnail', $user_thumbnail_img_data );
    }

    // Agents

    if ( !empty( $_POST['agency_agents'] ) ) {

        $agency_agents_data = $_POST['agency_agents'] ;

        update_user_meta( $current_user->ID, 'luxus_user_agents', $agency_agents_data );
    }

    // Map

    if ( !empty( $_POST['user_map'] ) ) {

        $user_map_data = $_POST['user_map'] ;

        update_user_meta( $current_user->ID, 'luxus_user_map', $user_map_data );
    }

    if ( !empty( $_POST['email'] ) ) {

        $args = array(
            'ID'         => $current_user->ID,
            'user_email' => esc_attr( $_POST['email'] ),
            'user_url' => esc_attr( $_POST['website'] ),
        );
        wp_update_user( $args );
    }

    // If NO Errors Update User Profile Database
    if ( count($error) == 0 ) {

        // Update User Profile
        do_action('luxus_edit_user_profile_update', $current_user->ID);

        // Redirect to Current Page
        wp_redirect( get_bloginfo('url').'/my-profile/');
        exit;
    }

}

// Password Update

$password_error = array();

if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'change-password' ) {
 
    $_POST = array_map( 'stripslashes_deep', $_POST );
    $current_password = sanitize_text_field( $_POST['current_password'] );
    $new_password = sanitize_text_field( $_POST['new_password'] );
    $confirm_new_password = sanitize_text_field( $_POST['confirm_new_password'] );

    // Check for errors
    if ( empty( $current_password ) && empty( $new_password ) && empty( $confirm_new_password ) ) {
        $password_error[] = __('All Fields Are Requires.', 'luxus-core');
    }

    if( $current_user && wp_check_password( $current_password, $current_user->data->user_pass, $current_user->ID )){
        //match
    } else {
        $password_error[] = __('Password is incorrect', 'luxus-core');
    }

    if( $new_password != $confirm_new_password ) {
        $password_error[] = __('Password does not match', 'luxus-core');
    }

    if(strlen( $new_password ) < 6){
        $password_error[] = __('Password is too short, minimum of 6 characters', 'luxus-core');
    }

    // If NO Errors Update User Password
    if ( count( $password_error ) == 0 ) {
        // Update User Password
        wp_set_password( $new_password, $current_user->ID );
        // Redirect to Current Page
        wp_redirect( get_bloginfo('url').'/my-profile/');
        exit;
    }
}

// Custom User Header

require dirname( __FILE__ ) . '/template-parts/header-user.php';

// Getting User Meta

$username = $current_user->user_nicename;
$email = $current_user->user_email;
$firstname = get_user_meta( $current_user->ID, 'first_name', true );
$lastname = get_user_meta( $current_user->ID, 'last_name', true );
$about = get_user_meta( $current_user->ID, 'description', true );
$profile_link = get_author_posts_url( $current_user->ID );

$designation = get_user_meta( $current_user->ID, 'luxus_user_designation', true );
$license = get_user_meta( $current_user->ID, 'luxus_user_license', true );
$taxnumber  = get_user_meta( $current_user->ID, 'luxus_user_tax', true );
$phone = get_user_meta( $current_user->ID, 'luxus_user_phone', true );
$mobile = get_user_meta( $current_user->ID, 'luxus_user_mobile', true );
$fax = get_user_meta( $current_user->ID, 'luxus_user_fax', true );
$address_one = get_user_meta( $current_user->ID, 'luxus_user_address_one', true );
$address_two = get_user_meta( $current_user->ID, 'luxus_user_address_two', true );
$city = get_user_meta( $current_user->ID, 'luxus_user_city', true );
$user_state = get_user_meta( $current_user->ID, 'luxus_user_state', true );
$zip = get_user_meta( $current_user->ID, 'luxus_user_postcode', true );
$country = get_user_meta( $current_user->ID, 'luxus_user_country', true );
$agency_agents = get_user_meta( $current_user->ID, 'luxus_user_agents', true );

// Social Accounts

$website = $current_user->user_url;
$facebook = get_user_meta( $current_user->ID, 'luxus_user_facebook', true );
$twitter = get_user_meta( $current_user->ID, 'luxus_user_twitter', true );
$linkedin = get_user_meta( $current_user->ID, 'luxus_user_linkedin', true );
$instagram = get_user_meta( $current_user->ID, 'luxus_user_instagram', true );
$pinterest = get_user_meta( $current_user->ID, 'luxus_user_pinterest', true );
$youtube = get_user_meta( $current_user->ID, 'luxus_user_youtube', true );

// Map

$map_marker = SL_PLUGIN_URL . 'public/images/map-pin.png';
$user_map_meta = get_user_meta( $current_user->ID, 'luxus_user_map', true );
$map_latitude = !empty( $user_map_meta['latitude'] ) ? $user_map_meta['latitude'] : 0 ;
$map_longitude = !empty( $user_map_meta['longitude'] ) ? $user_map_meta['longitude'] : 0 ;
$map_zoom = !empty( $user_map_meta['zoom'] ) ? $user_map_meta['zoom'] : 6 ;

// Custom Functions

$countries = luxus_countries_list();
$states = luxus_states_list();
$agents = luxus_agents_list();

?>

<!-- Main Content -->
<div class="main-content my-profile-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="heading-one"><?php esc_html_e('Profile Settings', 'luxus-core'); ?></h2>
            </div>
            <div class="col-lg-12">
                <form class="update-user-form" method="post" action="<?php esc_url(get_bloginfo('url').'/my-profile/') ?>" enctype="multipart/form-data">
                    <div class="sl-box">
                        <div class="col-lg-12">
                            <div class="row profile-top">
                                <div class="form-group col-lg-3">
                                    <div class="user-profile-image">
                                        <?php

                                        // $profile_pic = get_post_meta( $cpt_post_id, '_user_profile_img', TRUE);
                                        $profile_pic = get_user_meta( $current_user->ID, 'luxus_user_profile_img', true );

                                        $user_image_url = isset($profile_pic['url']) ? $profile_pic['url'] : '';
                                        $user_image_id = isset($profile_pic['id']) ? $profile_pic['id'] : '';
                                        $user_image_width = isset($profile_pic['width']) ? $profile_pic['width'] : '';
                                        $user_image_height = isset($profile_pic['height']) ? $profile_pic['height'] : '';
                                        $user_image_thumbnail = isset($profile_pic['thumbnail']) ? $profile_pic['thumbnail'] : '';
                                        $user_image_alt = isset($profile_pic['alt']) ? $profile_pic['alt'] : '';
                                        $user_image_title = isset($profile_pic['title']) ? $profile_pic['title'] : '';
                                        $user_image_description = isset($profile_pic['description']) ? $profile_pic['description'] : '';

                                        $profile_placeholder = SL_PLUGIN_URL . 'public/images/agency-profile.jpg';

                                        ?>

                                        <div id='profile-image-preview-wrapper' style="background-image: url('<?php echo esc_url( $user_image_url != NULL ) ? $user_image_url : $profile_placeholder; ?>'); ">
                                        </div>
                                        <button id="upload_profile_image"><i class="sl-icon sl-image-o"></i></button>

                                        <input type="hidden" name="user_img[url]" id="user_img_url" value="<?php echo esc_attr($user_image_url); ?>">
                                        <input type="hidden" name="user_img[id]" id="user_img_id" value="<?php echo esc_attr($user_image_id); ?>">
                                        <input type="hidden" name="user_img[width]" id="user_img_width" value="<?php echo esc_attr($user_image_width); ?>">
                                        <input type="hidden" name="user_img[height]" id="user_img_height" value="<?php echo esc_attr($user_image_height); ?>">
                                        <input type="hidden" name="user_img[thumbnail]" id="user_img_thumbnail" value="<?php echo esc_attr($user_image_thumbnail); ?>">
                                        <input type="hidden" name="user_img[alt]" id="user_img_alt" value="<?php echo esc_attr($user_image_alt); ?>">
                                        <input type="hidden" name="user_img[title]" id="user_img_title" value="<?php echo esc_attr($user_image_title); ?>">
                                        <input type="hidden" name="user_img[description]" id="user_img_description" value="<?php echo esc_attr($user_image_description); ?>">
                                    </div>
                                </div>
                                <div class="form-group col-lg-9">
                                    <div class="user-profile-thumbnail">
                                        <?php

                                            $profile_cover = get_user_meta( $current_user->ID, 'luxus_user_profile_thumbnail', true );

                                            $user_cover_url = isset($profile_cover['url']) ? $profile_cover['url'] : '';
                                            $user_cover_id = isset($profile_cover['id']) ? $profile_cover['id'] : '';
                                            $user_cover_width = isset($profile_cover['width']) ? $profile_cover['width'] : '';
                                            $user_cover_height = isset($profile_cover['height']) ? $profile_cover['height'] : '';
                                            $user_cover_thumbnail = isset($profile_cover['thumbnail']) ? $profile_cover['thumbnail'] : '';
                                            $user_cover_alt = isset($profile_cover['alt']) ? $profile_cover['alt'] : '';
                                            $user_cover_title = isset($profile_cover['title']) ? $profile_cover['title'] : '';
                                            $user_cover_description = isset($profile_cover['description']) ? $profile_cover['description'] : '';

                                            $cover_placeholder = SL_PLUGIN_URL . 'public/images/placholder-upload-gallery.jpg';
                                        ?>
                                        
                                        <div id='profile-thumbnail-preview-wrapper' style="background-image: url('<?php echo esc_url( $user_cover_url != NULL ) ? $user_cover_url : $cover_placeholder; ?>'); ">
                                            <?php $fullname = $firstname . ' ' . $lastname; ?>
                                            <a href="<?php echo esc_url($profile_link); ?>" class="view-user-profile"><h3 class="profile-name"><?php echo esc_attr( $fullname ); ?></h3></a>
                                        </div>
                                        <button id="upload_profile_thumbnail"><i class="sl-icon sl-image-o"></i></button>

                                        <input type="hidden" name="user_cover[url]" id="user_cover_url" value="<?php echo esc_attr($user_cover_url); ?>">
                                        <input type="hidden" name="user_cover[id]" id="user_cover_id" value="<?php echo esc_attr($user_cover_id); ?>">
                                        <input type="hidden" name="user_cover[width]" id="user_cover_width" value="<?php echo esc_attr($user_cover_width); ?>">
                                        <input type="hidden" name="user_cover[height]" id="user_cover_height" value="<?php echo esc_attr($user_cover_height); ?>">
                                        <input type="hidden" name="user_cover[thumbnail]" id="user_cover_thumbnail" value="<?php echo esc_attr($user_cover_thumbnail); ?>">
                                        <input type="hidden" name="user_cover[alt]" id="user_cover_alt" value="<?php echo esc_attr($user_cover_alt); ?>">
                                        <input type="hidden" name="user_cover[title]" id="user_cover_title" value="<?php echo esc_attr($user_cover_title); ?>">
                                        <input type="hidden" name="user_cover[description]" id="user_cover_description" value="<?php echo esc_attr($user_cover_description); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <h6 class="heading">Profile</h6>
                            <input type="hidden" name="action" value="plp_general_details" />
                        </div>
                        <div class="col-lg-12">
                            <label for="username"><?php esc_html_e('Username cannot be changed.', 'luxus-core'); ?></label>
                            <input type="text" class="form-control" name="username" disabled value="<?php echo esc_attr( $username ); ?>" id="username">
                        </div>
                        <div class="col-lg-12">
                            <div class="row gx-3">
                                <div class="form-group col-lg-4">
                                    <label for="firstname"><?php esc_html_e('First Name', 'luxus-core'); ?></label>
                                    <input type="text" class="form-control" name="firstname" value="<?php echo esc_attr( $firstname ); ?>" id="firstname">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="lastname"><?php esc_html_e('Last Name', 'luxus-core'); ?></label>
                                    <input type="text" class="form-control" name="lastname" value="<?php echo esc_attr( $lastname ); ?>" id="lastname">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="email"><?php esc_html_e('Email', 'luxus-core'); ?></label>
                                    <input type="text" class="form-control" name="email" value="<?php echo esc_attr( $email ); ?>" id="email">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row gx-3">
                                <div class="form-group col-lg-4">
                                    <label for="designation"><?php esc_html_e('Designation', 'luxus-core'); ?></label>
                                    <input type="text" class="form-control" name="designation" value="<?php echo esc_attr( $designation ); ?>" id="designation">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="license"><?php esc_html_e('License', 'luxus-core'); ?></label>
                                    <input type="text" class="form-control" name="license" value="<?php echo esc_attr( $license ); ?>" id="license">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="taxnumber"><?php esc_html_e('Tax Number', 'luxus-core'); ?></label>
                                    <input type="text" class="form-control" name="taxnumber" value="<?php echo esc_attr( $taxnumber ); ?>" id="taxnumber">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row gx-3">
                                <div class="form-group col-lg-4">
                                    <label for="phone"><?php esc_html_e('Office Phone', 'luxus-core'); ?></label>
                                    <input type="text" class="form-control" name="phone" value="<?php echo esc_attr( $phone ); ?>" id="phone">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="fax"><?php esc_html_e('Fax Number', 'luxus-core'); ?></label>
                                    <input type="text" class="form-control" name="fax" value="<?php echo $fax; ?>" id="fax">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="mobile"><?php esc_html_e('Mobile', 'luxus-core'); ?></label>
                                    <input type="text" class="form-control" name="mobile" value="<?php echo $mobile; ?>" id="mobile">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="about"><?php esc_html_e('About Me', 'luxus-core'); ?></label>
                            <textarea class="form-control" name="about" id="about" rows="7"><?php echo esc_html($about); ?></textarea>
                        </div>

                        <?php

                        if ( $user_role == 'agency' ) : ?>

                        <div class="col-lg-12 agency-agents-col">
                            <label for="agents"><?php esc_html_e('Our Agents', 'luxus-core'); ?></label>
                            <select name="agency_agents[]" class="agency-agents form-control"  id="agents" multiple="multiple">
                            <?php 
                                foreach ($agents as $key => $value) {

                                    echo '<option value="'. esc_attr($key) .'"'. esc_attr( !empty( $agency_agents ) && in_array( $key, $agency_agents ) ? 'selected' : '' ) .'>'. esc_html($key) .' - '. esc_html($value) .'</option>';
                                }
                            ?>
                            </select>
                        </div>

                        <?php endif; ?>

                        <div class="col-md-12">
                            <h6 class="heading"><?php esc_html_e('Social Accounts', 'luxus-core'); ?></h6>
                        </div>
                        <div class="col-lg-12">
                            <div class="row gx-3">
                                <div class="form-group col-lg-12">
                                    <label for="website"><?php esc_html_e('Website', 'luxus-core'); ?></label>
                                    <input type="text" class="form-control" name="website" value="<?php echo esc_attr( $website ); ?>" id="website">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="facebook"><?php esc_html_e('Facebook', 'luxus-core'); ?></label>
                                    <input type="text" class="form-control" name="facebook" value="<?php echo esc_attr( $facebook ); ?>" id="facebook">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="twitter"><?php esc_html_e('Twitter', 'luxus-core'); ?></label>
                                    <input type="text" class="form-control" name="twitter" value="<?php echo esc_attr($twitter); ?>" id="twitter">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="linkedin"><?php esc_html_e('Linkedin', 'luxus-core'); ?></label>
                                    <input type="text" class="form-control" name="linkedin" value="<?php echo esc_attr($linkedin); ?>" id="linkedin">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="instagram"><?php esc_html_e('Instagram', 'luxus-core'); ?></label>
                                    <input type="text" class="form-control" name="instagram" value="<?php echo esc_attr($instagram); ?>" id="instagram">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="pinterest"><?php esc_html_e('Pinterest', 'luxus-core'); ?></label>
                                    <input type="text" class="form-control" name="pinterest" value="<?php echo esc_attr($pinterest); ?>" id="pinterest">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="youtube"><?php esc_html_e('Youtube', 'luxus-core'); ?></label>
                                    <input type="youtube" class="form-control" name="youtube" value="<?php echo esc_attr($youtube); ?>" id="youtube">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <h6 class="heading"><?php esc_html_e('User Address', 'luxus-core'); ?></h6>
                        </div>
                        <div class="col-lg-12">
                            <div class="row gx-3">
                                <div class="col-lg-6">
                                    <label for="address-one"><?php esc_html_e('Street Address One', 'luxus-core'); ?></label>
                                    <input type="text" class="form-control" name="staddressone" value="<?php echo esc_attr($address_one); ?>" id="address-one">
                                </div>
                                <div class="col-lg-6">
                                    <label for="address-two"><?php esc_html_e('Street Address Two', 'luxus-core'); ?></label>
                                    <input type="text" class="form-control" name="staddresstwo" value="<?php echo esc_attr($address_two); ?>" id="address-two">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row gx-3">
                                <div class="col-lg-3">
                                    <label for="city"><?php esc_html_e('City', 'luxus-core'); ?></label>
                                    <input type="text" class="form-control" name="city" value="<?php echo esc_attr($city); ?>" id="city">
                                </div>
                                <div class="col-lg-3">
                                    <label for="state"><?php esc_html_e('State / Province', 'luxus-core'); ?></label>
                                    <div class="sl-select">
                                        <select name="state" class="form-control"  id="state">
                                            <option value=" "><?php esc_html_e('Select State/Province', 'luxus-core'); ?></option>
                                            <?php 
                                                foreach ( $states as $key => $state ) {
                                                    echo '<optgroup label="'.$key.'">';
                                                        foreach ($state as $key => $value) {
                                                            echo '<option value="'. esc_attr($key) .'"'. esc_attr( $user_state == $key ? 'selected' : '' ) .'>'. esc_html($value) .'</option>';
                                                        }
                                                    echo '</optgroup>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <label for="zip"><?php esc_html_e('Zip / Postal Code', 'luxus-core'); ?></label>
                                    <input type="text" class="form-control" name="zip" value="<?php echo esc_attr($zip); ?>" id="zip">
                                </div>
                                <div class="col-lg-3">
                                    <label for="country"><?php esc_html_e('Country', 'luxus-core'); ?></label>
                                    <div class="sl-select">
                                        <select name="country" class="form-control"  id="country">
                                            <option value=" "><?php esc_html_e('Select Country', 'luxus-core'); ?></option>
                                            <?php 
                                                foreach ($countries as $key => $value) {

                                                    echo '<option value="'. esc_attr($key) .'"'. esc_attr( $country == $key ? 'selected' : '' ) .'>'. esc_html($value) .'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <label for="map"><?php esc_html_e('Map', 'luxus-core'); ?></label>
                            <div id="map"></div>
                            <input type="hidden" name="user_map[address]" id="st_address" value="" /> 
                            <input type="hidden" name="user_map[latitude]" id="lat" value="<?php echo esc_attr($map_latitude); ?>" /> 
                            <input type="hidden" name="user_map[longitude]" id="lng" value="<?php echo esc_attr($map_longitude); ?>" />
                            <input type="hidden" name="user_map[zoom]" id="zoom" value="<?php echo esc_attr($map_zoom); ?>" />
                        </div>

                        <div class="col-lg-12">
                            <button id="update-user" type="submit" class="sl-btn-fill"><?php esc_html_e('Update Settings', 'luxus-core'); ?></button>
                            <?php wp_nonce_field( 'update-user' ) ?>
                            <input name="action" type="hidden" id="action" value="update-user" />
                        </div>
                    </div>
                </form>
            </div>

            <!-- Change / Reset Password -->
            <div class="col-lg-12">
                <form class="change-password-form" method="post" action="<?php esc_url(get_bloginfo('url').'/my-profile/') ?>" enctype="multipart/form-data">
                    <div class="sl-box">
                        <div class="col-lg-12">
                            <h6 class="heading"><?php esc_html_e('Change Password', 'luxus-core'); ?></h6>
                            <input type="hidden" name="action" value="plp_general_details" />
                        </div>
                        <div class="col-lg-12">
                            <div class="row gx-3">
                                <div class="form-group col-lg-4">
                                    <label for="current_password"><?php esc_html_e('Current Password', 'luxus-core'); ?></label>
                                    <input type="text" class="form-control" name="current_password" value="<?php echo esc_attr(isset( $_POST['current_password']) ? $current_password : null); ?>" id="current_password">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="new_password"><?php esc_html_e('New Password', 'luxus-core'); ?></label>
                                    <input type="text" class="form-control" name="new_password" value="<?php echo esc_attr(isset( $_POST['new_password']) ? $new_password : null); ?>" id="new_password">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="confirm_new_password"><?php esc_html_e('Confirm New Password', 'luxus-core'); ?></label>
                                    <input type="text" class="form-control" name="confirm_new_password" value="<?php echo esc_attr(isset( $_POST['confirm_new_password']) ? $confirm_new_password : null); ?>" id="confirm_new_password">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button id="update-password" type="submit" class="sl-btn-outline"><?php esc_html_e('Change Password', 'luxus-core'); ?></button>

                            <?php wp_nonce_field( 'change-password' ) ?>
                            
                            <input name="action" type="hidden" id="action" value="change-password" />
                        </div>
                        
                        <!-- Print Change Password Errors -->
                        <?php

                            if ( !empty($password_error) ){

                                // Echo Errors
                                echo '<div class="col-lg-12 profile-errors">';
                                echo '<h5>'. esc_html_e('Errors:', 'luxus-core').'</h5>';

                                foreach($password_error as $error){

                                    echo '<p>';
                                    echo "<strong>". $error ."</strong>";
                                    echo '</p>';

                                }

                                echo '</div>';
                            }
                       ?>

                    </div>
                </form>
            </div>

            <!-- Change / Reset Password -->
        </div>
        <div class="row"></div>
    </div>
</div>
<!-- Main Content End -->

<?php

// getting Values From Meta
$latitude = isset( $user_map_meta['latitude'] ) ? $user_map_meta['latitude'] : 0;
$longtitude = isset( $user_map_meta['longitude'] ) ? $user_map_meta['longitude'] : 0;

// Agent Map Script
wp_register_script( 'luxus-my-profile', '', array("jquery"), '', true );
wp_enqueue_script( 'luxus-my-profile'  );

wp_add_inline_script( 'luxus-my-profile', "
    jQuery( document ).ready( function( $ ) {
        // Lat Long
        var markerLocation = [{$latitude}, {$longtitude}];
        // Zoom Level
        var mapZoom = 6;

        // Default Marker Position
        if (markerLocation[0] == 0 && markerLocation[1] == 0) {
            markerLocation = [30.0497935, 60.3349021];
        }

        var map = L.map('map', {
            center: markerLocation,
            zoom: mapZoom,
        });

        L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href=\"https://osm.org/copyright\">OpenStreetMap</a> contributors'
        }).addTo(map);

        map.attributionControl.setPrefix(false);

        // create custom icon
        var mapMarker = L.icon({
            iconUrl: '{$map_marker}',
            iconSize: [40, 48], // size of the icon
        });

        var marker = new L.marker(markerLocation, {
            icon: mapMarker,
            draggable: 'true'
        });

        function addValueToTextBox(lt,ln){
            document.getElementById('lat').value = lt;
            document.getElementById('lng').value = ln;
        }

        document.getElementById('zoom').value = mapZoom;

        marker.on('dragend', function(event){
            var marker = event.target;
            var location = marker.getLatLng();
            var lat = location.lat;
            var lon = location.lng;
            addValueToTextBox(lat,lon);
        });

        marker.addTo(map);
    });
");

// Custom User Footer

require dirname( __FILE__ ) . '/template-parts/footer-user.php';
