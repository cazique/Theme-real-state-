<?php

// User Meta
$agency_logo = get_user_meta( $agency->ID, 'luxus_user_profile_img', true );
$img_placeholder = SL_PLUGIN_URL . 'public/images/agency-profile.jpg';
$agency_pic_url = !empty($agency_logo['url']) ? $agency_logo['url'] : $img_placeholder;

$agency_fname = $agency->first_name;
$agency_lname = $agency->last_name;
$agency_name = $agency_fname .' '. $agency_lname;
$agency_email = $agency->user_email;
$agency_phone = $agency->luxus_user_phone;
$agency_mobile = $agency->luxus_user_mobile;
$agency_city = $agency->luxus_user_city;
$agency_description = $agency->description;
$agency_permalink = get_author_posts_url($agency->ID);

?>

<div class="agency-item agency-one">
    <div class="picture" style="background-image: url('<?php echo esc_url($agency_pic_url); ?>');">
        <a href="<?php echo esc_url($agency_permalink); ?>" class="view-profile"><i class="fa fa-link"></i></a>
    </div>
    <div class="agency-information">
        <a href="<?php echo esc_url($agency_permalink); ?>"><h5 class="name"><?php echo esc_html($agency_name); ?></h5></a>
        <div class="contect-info">
            <ul>
                <li><span><?php esc_html_e('Mobile:', 'luxus-core') ?></span>
                    <?php echo esc_html( $agency_mobile != NULL ? $agency_mobile : __('NA', 'luxus-core') ); ?>
                </li>
                <li><span><?php esc_html_e('Office:', 'luxus-core') ?></span>
                    <?php echo esc_html( $agency_phone != NULL ? $agency_phone : __('NA', 'luxus-core') ); ?>
                </li>
                <li><span><?php esc_html_e('Email:', 'luxus-core') ?></span>
                    <?php echo esc_html( $agency_email != NULL ? $agency_email : __('NA', 'luxus-core') ); ?>
                </li>
                <li><span><?php esc_html_e('Location:', 'luxus-core') ?></span>
                    <?php echo esc_html( $agency_city != NULL ? $agency_city : __('NA', 'luxus-core') ); ?>
                </li>
            </ul>
        </div>

        <!-- Social Icons -->
        
        <?php if ($agency_show_icons == 'yes') :

            $social_icons = array(); 

            if (!empty($agency->luxus_user_facebook)) {
                $social_icons['fa-facebook-f'] = $agency->luxus_user_facebook;
            }
            if (!empty($agency->luxus_user_instagram)) {
                $social_icons['fa-instagram'] = $agency->luxus_user_instagram;
            }
            if (!empty($agency->luxus_user_twitter)) {
                $social_icons['fa-twitter'] = $agency->luxus_user_twitter;
            }
            if (!empty($agency->luxus_user_linkedin)) {
                $social_icons['fa-linkedin-in'] = $agency->luxus_user_linkedin;
            }
            if (!empty($agency->luxus_user_pinterest)) {
                $social_icons['fa-pinterest-p'] = $agency->luxus_user_pinterest;
            }
            if (!empty($agency->luxus_user_youtube)) {
                $social_icons['fa-youtube'] = $agency->luxus_user_youtube;
            }

            echo '<div class="social"><ul>';
                foreach ( $social_icons as $key => $value ) {
                  echo '<li><a href="'.esc_url($value).'" target="_blank"><i class="fab '.esc_attr($key).'"></i></a></li>';
               }
            echo '</ul></div>';

        endif; ?>
        
    </div>
</div>