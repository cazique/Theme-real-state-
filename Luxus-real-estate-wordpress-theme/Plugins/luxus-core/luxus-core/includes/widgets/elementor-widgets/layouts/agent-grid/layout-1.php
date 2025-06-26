<?php

// User Meta
$agent_logo = get_user_meta( $agent->ID, 'luxus_user_profile_img', true );
$img_placeholder = SL_PLUGIN_URL . 'public/images/agent-profile.jpg';
$agent_pic_url = !empty($agent_logo['url']) ? $agent_logo['url'] : $img_placeholder;

$agent_fname = $agent->first_name;
$agent_lname = $agent->last_name;
$agent_name = $agent_fname .' '. $agent_lname;
$agent_email = $agent->user_email;
$agent_phone = $agent->luxus_user_phone;
$agent_mobile = $agent->luxus_user_mobile;
$agent_city = $agent->luxus_user_city;
$agent_permalink = get_author_posts_url($agent->ID);

?>

<div class="agent-item agent-one sl-box">
    <div class="picture">
            <img src="<?php echo esc_url($agent_pic_url); ?>" alt="<?php esc_attr($agent_name); ?>">
        <a href="<?php echo esc_url($agent_permalink); ?>" class="view-profile"><i class="fa fa-link"></i></a>
    </div>
    <a href="<?php echo esc_url($agent_permalink); ?>"><h5 class="name"><?php echo esc_html($agent_name); ?></h5></a>
    <div class="contect-info">
        <ul>
            <li><span>Mobile:</span>
                <?php echo esc_html( $agent_mobile != NULL ? $agent_mobile : __('NA', 'luxus-core') ); ?>
            </li>
            <li><span>Office:</span>
                <?php echo esc_html( $agent_phone != NULL ? $agent_phone : __('NA', 'luxus-core') ); ?>
            </li>
            <li><span>Email:</span>
                <?php echo esc_html( $agent_email != NULL ? $agent_email : __('NA', 'luxus-core') ); ?>
            </li>
            <li><span>Location:</span>
                <?php echo esc_html( $agent_city != NULL ? $agent_city : __('NA', 'luxus-core') ); ?>
            </li>
        </ul>
    </div>

    <!-- Social Icons -->

    <?php if ($agent_show_icons == 'yes') :

        $social_icons = array(); 

        if (!empty($agent->luxus_user_facebook)) {
            $social_icons['fa-facebook-f'] = $agent->luxus_user_facebook;
        }
        if (!empty($agent->luxus_user_instagram)) {
            $social_icons['fa-instagram'] = $agent->luxus_user_instagram;
        }
        if (!empty($agent->luxus_user_twitter)) {
            $social_icons['fa-twitter'] = $agent->luxus_user_twitter;
        }
        if (!empty($agent->luxus_user_linkedin)) {
            $social_icons['fa-linkedin-in'] = $agent->luxus_user_linkedin;
        }
        if (!empty($agent->luxus_user_pinterest)) {
            $social_icons['fa-pinterest-p'] = $agent->luxus_user_pinterest;
        }
        if (!empty($agent->luxus_user_youtube)) {
            $social_icons['fa-youtube'] = $agent->luxus_user_youtube;
        }
        
        echo '<div class="social"><ul>';
            foreach ( $social_icons as $key => $value ) {
              echo '<li><a href="'.esc_url($value).'" target="_blank"><i class="fab '.esc_attr($key).'"></i></a></li>';
           }
        echo '</ul></div>';

    endif; ?>
</div>