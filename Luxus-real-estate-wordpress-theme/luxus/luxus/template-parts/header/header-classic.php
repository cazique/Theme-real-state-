<?php
/**
 * Template part for displaying Classic Header
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Luxus
 */

$classic_header_width = luxus_options('header-width');

// Options Logo
$brand_logo_opt = luxus_options('brand-logo');
$brand_logo_url = !$brand_logo_opt == null ? $brand_logo_opt['url'] : null;
$brand_opt_logo = !$brand_logo_url == null ? $brand_logo_url : null;

// Page Logo
$brand_logo_meta = luxus_page_meta( '_page_logo' );
$brand_logo_meta_url = !$brand_logo_meta == null ? $brand_logo_meta['url'] : null;
$brand_page_logo = !$brand_logo_meta_url == null ? $brand_logo_meta_url : null;

// Site Logo Url
$brand_logo = !$brand_page_logo == null ? $brand_page_logo : $brand_opt_logo;

// Menu Area Opt
$main_menu_position_opt = luxus_options('main-menu-position');
$main_menu_position = !empty( $main_menu_position_opt ) ? $main_menu_position_opt : "right";
$classic_user_avatar = luxus_options('user-avatar');
$classic_right_btn = luxus_options('right-btn');
$classic_right_btn_text = luxus_options('right-btn-text');
$classic_right_btn_link = luxus_options('right-btn-link');

?> 
<div class="classic-header">
	<div class="<?php echo esc_attr(!$classic_header_width == null ? $classic_header_width : 'container'); ?>">
		<div class="classic-header-inner">
			<div class="box brand">
				<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
				<?php if (!$brand_logo == null) : ?>
					<!-- Brand Logo -->
					<img class="brand-logo" src="<?php echo esc_url( $brand_logo ); ?>" alt="<?php esc_attr( bloginfo( 'name' ) ); ?>">
				<?php else:
					if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
 						the_custom_logo();
					} else {
						echo '<h2>' . esc_html( get_bloginfo('name') ) . '</h2>';
					}
				endif; ?>
				</a>
			</div>
		    <div class="box menu-area">
		    	<div class="main-menu" style="text-align: <?php  echo esc_attr( $main_menu_position ); ?>">
		    		<div class="stellarnav">
			    		<?php
			    			wp_nav_menu( array(
			    				'theme_location' => 'primary-menu',
			    				'container'=>'',
			    				'fallback_cb'    => false
			    			) );
			    		?>
			    	</div>
		    	</div>
		    	<div class="menu-right">
		    		<?php

		    			if( $classic_user_avatar == true ) {

		                    if( is_user_logged_in() ):

		                        $user = wp_get_current_user();

		                        $avatar_placeholder = get_template_directory_uri() . '/assets/images/luxus-avatar.png';

		                        if (class_exists('Luxus_Core')) {

		                        	$user_meta_img = get_user_meta( $user->ID, 'luxus_user_profile_img', true );
									$user_img_url = !empty($user_meta_img['url']) ? $user_meta_img['url'] : $avatar_placeholder;

		                        } else {

		                        	$user_img_url = $avatar_placeholder;
		                        }

		                       	if ( current_user_can( 'administrator' ) ) {

						        	$dashboard_url = get_dashboard_url();
						        	$profile_link = get_edit_user_link();

						        } else {

						        	$dashboard_url = home_url( '/user-dashboard' );
						        	$profile_link = home_url( '/my-profile' );
						        }

		                     ?>

		                        <div class="user-loged-in">
		                            <img src="<?php echo esc_url( $user_img_url );  ?>" class="user-pic" alt="<?php echo esc_attr( $user->display_name ); ?>">
		                            <div class="quick-links">
		                                <div class="user-name"><?php echo esc_html( $user->display_name ); ?></div>
		                                <ul>
	                                		<li>
	                                			<a href="<?php echo esc_url($dashboard_url); ?>"><i class="fas fa-list"></i><?php esc_html_e('Dashboard', 'luxus'); ?></a>
	                                		</li>
	                                    	<li>
	                                    		<a href="<?php echo esc_url($profile_link); ?>"><i class="far fa-user"></i><?php esc_html_e('Profile settings', 'luxus'); ?></a>
	                                    	</li>
		                                    <li>
		                                    	<a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>"><i class="fas fa-sign-out-alt"></i><?php esc_html_e('Logout', 'luxus'); ?></a>
		                                    </li>
		                                </ul>
		                            </div>
		                        </div>

		                    <?php else:

		                    	$user_avatar_text_opt = luxus_options('user-avatar-text');
		                    	$user_avatar_text = !empty( $user_avatar_text_opt ) ? $user_avatar_text_opt : __('Login', 'luxus');

		                    	echo '<a class="sl-ajax-login" href=""><i class="sl-icon sl-avatar-o"></i>' . esc_html($user_avatar_text) . '</a>';

		                    endif;
		    			}
 
						if( class_exists( 'CSF' ) ) {

			    			if( $classic_right_btn == true ) { 

			    				echo '<a href="' . esc_url( $classic_right_btn_link ) . '" class="right-btn">' . esc_html( $classic_right_btn_text ) . '</a>';

			    			}
		    			}
		    		?>
		    	</div>
	    	</div>
		</div>
	</div>
</div>