<?php

// User Meta
$agent_profile = get_user_meta( $agent->ID, 'luxus_user_profile_img', true );
$img_placeholder = SL_PLUGIN_URL . 'public/images/agent-profile.jpg';
$agent_pic_url = !empty($agent_profile['url']) ? $agent_profile['url'] : $img_placeholder;

$agent_fname = $agent->first_name;
$agent_lname = $agent->last_name;
$agent_name = $agent_fname .' '. $agent_lname;
$agent_permalink = get_author_posts_url($agent->ID);

$show_social_icons = luxus_options('agent-enable-social-icons');
$social_icons_on = $show_social_icons == true ? 'social_icons_on' : 'social_icons_off';

// Social Icons

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

?>

<div class="<?php echo esc_attr($sl_col); ?>">
	<div class="team-two">
		<img class="img" src="<?php echo esc_url($agent_pic_url); ?>" alt="<?php esc_attr($agent_name); ?>">
		<div class="info <?php echo esc_attr($social_icons_on); ?>">
			<h6 class="name"><?php echo $agent_name; ?></h6>
			<p class="possition"><?php esc_html_e('Agent', 'luxus-core'); ?></p>
			<a href="<?php echo esc_url($agent_permalink); ?>" class="more"><?php esc_html_e('View Profile', 'luxus-core'); ?></a>

			<?php
				if ( $show_social_icons == true ) {

					echo '<div class="social"><ul>';
			            foreach ( $social_icons as $key => $value ) {
			              echo '<li><a href="'.esc_url($value).'" target="_blank"><i class="fab '.esc_attr($key).'"></i></a></li>';
			           }
			        echo '</ul></div>';

			    }
		    ?>
		</div>
	</div>
</div>
