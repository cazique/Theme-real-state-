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

$agency_agents = $agency->luxus_user_agents;

$agency_excerpt_opt = luxus_options('agency-excerpt-length');
$agency_excerpt_length = !empty( $agency_excerpt_opt ) ? $agency_excerpt_opt : 20;

$show_social_icons = luxus_options('agency-enable-social-icons');

// Social Icons

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

?>

<div class="col-xl-12 col-md-6">
	<div class="agent-three">
		<div class="img" style="background-image: url('<?php echo esc_url($agency_pic_url); ?>');">
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
		<div class="content">
			<h6 class="name heading"><?php echo $agency_name; ?></h6>
			<ul class="contect-info">
				<li><i class="sl-icon sl-mail-o"></i>
					<?php echo esc_html( $agency_email != NULL ? $agency_email : __('NA', 'luxus-core') ); ?>
				</li>
				<li><i class="sl-icon sl-phone-t"></i>
					<?php echo esc_html( $agency_phone != NULL ? $agency_phone : __('NA', 'luxus-core') ); ?>
				</li>
				<li><i class="sl-icon sl-phone-o"></i>
					<?php echo esc_html( $agency_mobile != NULL ? $agency_mobile : __('NA', 'luxus-core') ); ?>
				</li>
				<li><i class="sl-icon sl-place"></i>
					<?php echo esc_html( $agency_city != NULL ? $agency_city : __('NA', 'luxus-core') ); ?>
				</li>
			</ul>
			<p class="text"><?php echo wp_trim_words( $agency_description, $agency_excerpt_length, __(' ...', 'luxus-core') ); ?></p>
			<a class="more" href="<?php echo esc_url($agency_permalink); ?>"><?php esc_html_e('View Profile', 'luxus-core'); ?></a>
		</div>
	</div>
</div>
