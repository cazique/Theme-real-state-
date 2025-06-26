<?php
namespace SLElementorWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Luxus_User_Login extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'luxus-user-login';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'User Avatar', 'luxus' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'sl-theme-widget-icon user-avatar';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'luxus-widgets' ];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.1.0
	 *
	 * @access protected
	 */
	protected function register_controls() {

		$this->luxus_genetal_layout_options();
	}

	// Content Layout Options
	private function luxus_genetal_layout_options() {

		$this->start_controls_section(
			'section_layout_options',
			[
				'label' => __( 'Layout', 'luxus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'user_login_text',
			[
				'label' => __( 'User Login Text', 'luxus' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Login', 'luxus' ),
				'placeholder' => __( 'User login text here', 'luxus' ),
			]
		);
		
		$this->add_control(
			'user_login_text_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'User Login Text Color', 'luxus' ),
				'default' => '#00072D',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-user-login-container .sl-ajax-login' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'user_login_text_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'User Login Hover Text Color', 'luxus' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-user-login-container .sl-ajax-login:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'line_height',
			[
				'label' => __( 'Line Height', 'luxus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 80,
				],
				'selectors' => [
					'{{WRAPPER}} .sl-user-login-container .user-loged-in' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'user_login_align',
			[
				'label' => __( 'Avatar Alignment', 'luxus' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'luxus' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'luxus' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'luxus' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .sl-user-login-container' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'user_login_dropdown_background',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Dropdown Background', 'luxus' ),
				'default' => '#000522',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-user-login-container .user-loged-in .quick-links' => 'background: {{VALUE}};',
					'{{WRAPPER}} .sl-user-login-container .user-loged-in .quick-links:before' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'user_login_dd_username_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'User Name Color', 'luxus' ),
				'default' => '#f7f7ff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-user-login-container .user-loged-in .quick-links .user-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'nav_menu_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'nav_menu_normal',
			[
				'label'     => __( 'Normal', 'luxus' ),
			]
		);

		$this->add_control(
			'user_login_dd_links_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Links Color', 'luxus' ),
				'default' => '#f7f7f7',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-user-login-container .user-loged-in .quick-links ul li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'user_login_dd_links_bg_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Links Bsvkground Color', 'luxus' ),
				'default' => '',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-user-login-container .user-loged-in .quick-links ul li a' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'nav_menu_hover',
			[
				'label'     => __( 'Hover', 'luxus' ),
			]
		);

		$this->add_control(
			'user_login_dd_links_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Links Color', 'luxus' ),
				'default' => '#f7f7f7',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-user-login-container .user-loged-in .quick-links ul li a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'user_login_dd_links_bg_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Links Bsvkground Color', 'luxus' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-user-login-container .user-loged-in .quick-links ul li a:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.1.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		?>
			<div class="sl-user-login-container">
				<?php

                //CHECKING THE USER LOGED IN OR USER EXISTS OR NOT IN DATABASE
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

		            $user_login_text_opt = $settings['user_login_text'];
                	$user_login_text = !empty( $user_login_text_opt ) ? $user_login_text_opt : __('Login', 'luxus');

                	echo '<a class="sl-ajax-login" href=""><i class="sl-icon sl-avatar-o"></i>' . esc_html($user_login_text) . '</a>';

		        endif;

				?>
			</div>
    	<?php
	}
}