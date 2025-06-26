
<?php
/**
 * Header For User Pannel
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package luxus
 */

//CHECKING THE USER LOGED IN OR USER EXISTS OR NOT IN DATABASE
if( !is_user_logged_in() ){ wp_redirect( site_url( 'login' ) ); }

// A Custom function for get an option
if ( ! function_exists( 'luxus_options' ) ) {

  function luxus_options( $option = '', $default = null ) {

    $options = get_option( 'luxus_options' ); // Unique id of the framework
    return ( isset( $options[$option] ) ) ? $options[$option] : $default;

  }

}

// Get options
$brand_logo_opt = luxus_options('brand-logo');
$brand_logo_url = !$brand_logo_opt == null ? $brand_logo_opt['url'] : null;
$dashboard_brand_logo_opt = luxus_options('dashboard-logo');
$dashboard_brand_logo_url = !$dashboard_brand_logo_opt == null ? $dashboard_brand_logo_opt['url'] : null ;
$dashboard_logo_url = !$dashboard_brand_logo_url == null ? $dashboard_brand_logo_url : $brand_logo_url;
$dashboard_logo = !$dashboard_logo_url == null ? $dashboard_logo_url : null;

$dashboard_user_avatar = luxus_options('dashboard-user-avatar');

$main_menu_position_opt = luxus_options('dash-main-menu-position');
$main_menu_position = !empty( $main_menu_position_opt ) ? $main_menu_position_opt : "left";
$dashboard_right_btn = luxus_options('dashboard-right-btn');
$dashboard_right_btn_text = luxus_options('dashboard-right-btn-text');
$dashboard_right_btn_link = luxus_options('dashboard-right-btn-link');

$frontend_can_posting = luxus_options('can-posts-from-dashboard');
$free_premium_posting = $frontend_can_posting != NULL ? $frontend_can_posting : 'free';

  // Header Breakpoint
if ( class_exists('CSF') ) {
	$dash_header_breakpoint = luxus_options('dash-mob-header-breakpoint');
} else {
	$dash_header_breakpoint = 1200;
}

?> 

<!doctype html>
<html <?php language_attributes(); ?> >
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> >
    <div class="page-wrapper default-theme toggled">

		<!-- Toogle Btn -->
		<a id="show-sidebar" class="btn btn-sm btn-dark" href="">
		    <i class="fa fa-bars"></i>
		</a>
		<nav id="sidebar" class="sidebar-wrapper">
		    <div class="sidebar-content">

		        <!-- sidebar-brand  -->
		        <div class="sidebar-item sidebar-brand">
		            <a href="<?php echo esc_url( get_home_url() ); ?>">
		 				<?php if (!$dashboard_logo == null) : ?>
                        	<img src="<?php echo esc_url( $dashboard_logo ); ?>">
                    	<?php else:
                        	echo '<h3>' . esc_html( get_bloginfo() ) . '<h3>';
                    	endif; ?>
		            </a>
		            <div id="close-sidebar">
		                <i class="fa fa-times"></i>
		            </div>
		        </div>

		        <!-- sidebar-menu  -->
		        <div class=" sidebar-item sidebar-menu">
		            <ul>
		                <li class="header-menu">
		                    <span><?php esc_html_e('MAIN', 'luxus-core'); ?></span>
		                </li>
		                <li>
		                    <a href="<?php echo esc_url(site_url('user-dashboard')); ?>">
		                        <i class="fas fa-th-large"></i>
		                        <span><?php esc_html_e('Dashboard', 'luxus-core'); ?></span>
		                    </a>
		                </li>
		               	<li class="sidebar-dropdown">
		                    <a href="#">
		                        <i class="far fa-envelope"></i>
		                        <span><?php esc_html_e('Messages', 'luxus-core'); ?></span>
		                    </a>
		                    <div class="sidebar-submenu">
		                        <ul>
		                            <li>
		                                <a href="<?php echo esc_url(site_url('inbox')); ?>"><?php esc_html_e('Inbox', 'luxus-core'); ?></a>
		                            </li>
		                            <li>
		                                <a href="<?php echo esc_url(site_url('sent')); ?>"><?php esc_html_e('Sent', 'luxus-core'); ?></a>
		                            </li>
		                        </ul>
		                    </div>
		                </li>
		                <?php if ( !current_user_can('subscriber') ) : ?>
		                <li class="sidebar-dropdown">
		                    <a href="#">
		                        <i class="far fa-calendar-check"></i>
		                        <span><?php esc_html_e('Schedule Tours', 'luxus-core'); ?></span>
		                    </a>
		                    <div class="sidebar-submenu">
		                        <ul>
		                            <li>
		                                <a href="<?php echo esc_url(site_url('schedules')); ?>"><?php esc_html_e('Schedules Inbox', 'luxus-core'); ?></a>
		                            </li>
		                            <li>
		                                <a href="<?php echo esc_url(site_url('schedule-requests')); ?>"><?php esc_html_e('Schedules Sent', 'luxus-core'); ?></a>
		                            </li>
		                        </ul>
		                    </div>
		                </li>
		              	<?php else: ?>
		              	<li>
		                    <a href="<?php echo esc_url(site_url('schedule-requests')); ?>">
		                        <i class="far fa-calendar-check"></i>
		                        <span><?php esc_html_e('Schedule Tours', 'luxus-core'); ?></span>
		                    </a>
		                </li>

		              	<?php endif; ?>
		                <li class="header-menu">
		                    <span><?php esc_html_e('PROPERTIES', 'luxus-core'); ?></span>
		                </li>
		                <?php if ( !current_user_can('subscriber') ) : ?>
		                <li>
		                    <a href="<?php echo esc_url(site_url('add-property')); ?>">
		                        <i class="far fa-edit"></i>
		                        <span><?php esc_html_e('Add Property', 'luxus-core'); ?></span>
		                    </a>
		                </li>
		                <li class="sidebar-dropdown">
		                    <a href="#">
		                        <i class="far fa-building"></i>
		                        <span><?php esc_html_e('My Properties', 'luxus-core'); ?></span>
		                    </a>
		                    <div class="sidebar-submenu">
		                        <ul>
		                            <li>
		                                <a href="<?php echo esc_url(site_url('published-properties')); ?>"><?php esc_html_e('Published', 'luxus-core'); ?></a>
		                            </li>
		                            <li>
		                                <a href="<?php echo esc_url(site_url('pending-properties')); ?>"><?php esc_html_e('Pending', 'luxus-core'); ?></a>
		                            </li>
		                            <li>
		                                <a href="<?php echo esc_url(site_url('draft-properties')); ?>"><?php esc_html_e('Draft', 'luxus-core'); ?></a>
		                            </li>
		                            <li>
		                                <a href="<?php echo esc_url(site_url('trash-properties')); ?>"><?php esc_html_e('Trashed', 'luxus-core'); ?></a>
		                            </li>
		                        </ul>
		                    </div>
		                </li>
		                <?php endif; ?>
		                <li>
		                    <a href="<?php echo esc_url(site_url('favorite-properties')); ?>">
		                        <i class="far fa-heart"></i>
		                        <span><?php esc_html_e('My Favourites', 'luxus-core'); ?></span>
		                    </a>
		                </li>
		                <li>
		                    <a href="<?php echo esc_url(site_url('searches')); ?>">
		                        <i class="far fa-save"></i>
		                        <span><?php esc_html_e('Saved Search', 'luxus-core'); ?></span>
		                    </a>
		                </li>
		                <?php if ( !current_user_can('subscriber') ) : ?>
		                <li>
		                    <a href="<?php echo esc_url(site_url('posts-ratings')); ?>">
		                        <i class="far fa-star"></i>
		                        <span><?php esc_html_e('Post Reviews', 'luxus-core'); ?></span>
		                    </a>
		                </li>
		                <?php endif; ?>
		                <li class="header-menu">
		                    <span><?php esc_html_e('ACCOUNT', 'luxus-core'); ?></span>
		                </li>
		                <?php if ( $free_premium_posting == 'premium' ) : ?>
		                <li>
		                    <a href="<?php echo esc_url(site_url('packages')); ?>">
		                        <i class="far fa-clone"></i>
		                        <span><?php esc_html_e('Packages', 'luxus-core'); ?></span>
		                    </a>
		                </li>
		                <?php endif;
		                if ( !current_user_can('subscriber') ) : ?>
		                <li>
		                    <a href="<?php echo esc_url(site_url('my-orders')); ?>">
		                        <i class="far fa-file-alt"></i>
		                        <span><?php esc_html_e('My Orders', 'luxus-core'); ?></span>
		                    </a>
		                </li>
		                <li>
		                    <a href="<?php echo esc_url(site_url('my-profile')); ?>">
		                        <i class="far fa-user"></i>
		                        <span><?php esc_html_e('My Profile', 'luxus-core'); ?></span>
		                    </a>
		                </li>
		              	<?php else: ?>
		                <li>
		                    <a href="<?php echo esc_url(site_url('my-account/edit-account/')); ?>">
		                        <i class="far fa-user"></i>
		                        <span><?php esc_html_e('My Profile', 'luxus-core'); ?></span>
		                    </a>
		                </li>
		              	<?php endif; ?>
		                <li>
		                    <a href="<?php echo esc_url( wp_logout_url() ); ?>">
		                        <i class="fas fa-sign-out-alt"></i>
		                        <span><?php esc_html_e('Logout', 'luxus-core'); ?></span>
		                    </a>
		                </li>
		            </ul>
		        </div>
		        <!-- sidebar-menu  -->

		    </div>
		</nav>

		<!-- Page Container -->
		<div class="page-content user-header-container">
	        <!-- Header -->
			<header class="luxus-header user-header sticky-top" data-breakpoint="<?php echo esc_attr($dash_header_breakpoint); ?>">
			    <div class="container">
			      <div class="classic-header">
							<div class="classic-header-inner">

						    <div class="menu-area">
						    	<div class="main-menu" style="text-align: <?php  echo esc_attr( $main_menu_position ); ?>">
					        	<div class="stellarnav">
					        		<?php

					        			if ( has_nav_menu( 'dashboard-menu' ) ){

					        				wp_nav_menu( array(
						        				'theme_location' => 'dashboard-menu',
						        				'container'=>'',
						        				'fallback_cb'    => false
						        			) );

					        			} else {
					        				wp_nav_menu( array(
								    				'theme_location' => 'primary-menu',
								    				'container'=>'',
								    				'fallback_cb'    => false
								    			) );
					        			}

					        		?>
					        	</div>
						    	</div>

						    	<div class="menu-right">
						    		<?php

						    		if( $dashboard_user_avatar == true ) {

		                  if( is_user_logged_in() ) {

                        $user = wp_get_current_user();

                        $avatar_placeholder = get_template_directory_uri() . '/assets/images/luxus-avatar.png';
                        $user_meta_img = get_user_meta( $user->ID, 'luxus_user_profile_img', true );
												$user_img_url = !empty($user_meta_img['url']) ? $user_meta_img['url'] : $avatar_placeholder;

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
                            			<a href="<?php echo esc_url($dashboard_url); ?>"><i class="fas fa-list"></i><?php esc_html_e('Dashboard', 'luxus-core'); ?></a>
                            		</li>
                                	<li>
                                		<a href="<?php echo esc_url($profile_link); ?>"><i class="far fa-user"></i><?php esc_html_e('Profile settings', 'luxus-core'); ?></a>
                                	</li>
                                  <li>
                                  	<a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>"><i class="fas fa-sign-out-alt"></i><?php esc_html_e('Logout', 'luxus-core'); ?></a>
                                  </li>
                              </ul>
                          </div>
                      </div>

						        <?php

					        		}
					    			}

										if( class_exists( 'CSF' ) ) {

							    			if( $dashboard_right_btn == true && !current_user_can('subscriber') ) { 

							    				echo '<a href="' . esc_url( $dashboard_right_btn_link ) . '" class="right-btn">' . esc_html( $dashboard_right_btn_text ) . '</a>';

							    			}
						    			}

						    		?>

						    	</div>
					    	</div>
							</div>
						</div>
			    </div>
			</header>
	    <!-- Header -->
			