<?php

// User Meta
$agent_logo = get_user_meta( $agent->ID, 'luxus_user_profile_img', true );
$img_placeholder = SL_PLUGIN_URL . 'public/images/agent-profile.jpg';
$agent_pic_url = !empty($agent_logo['url']) ? $agent_logo['url'] : $img_placeholder;

$agent_fname = $agent->first_name;
$agent_lname = $agent->last_name;
$agent_name = $agent_fname .' '. $agent_lname;
$agent_permalink = get_author_posts_url($agent->ID);

$social_icons_visibility = $agent_show_icons == 'yes' ? 'agent_social_icons_on' : 'agent_social_icons_off';

?>

<div class="agent-item team-two" style="background-image: url('<?php echo esc_url($agent_pic_url); ?>');">
    <div class="info <?php echo esc_attr($social_icons_visibility); ?>">
        <h6 class="name"><?php echo esc_html($agent_name); ?></h6>
        <p class="possition"><?php esc_html_e('Agent', 'luxus-core'); ?></p>
        <a href="<?php echo esc_url($agent_permalink); ?>" class="more"><?php esc_html_e('View Profile', 'luxus-core'); ?></a>

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
</div>