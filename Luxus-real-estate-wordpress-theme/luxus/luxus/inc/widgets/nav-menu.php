<?php
namespace SLElementorWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Luxus_Nav_Menu extends Widget_Base {

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
		return 'luxus-nav-menu';
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
		return __( 'Nav Menu', 'luxus' );
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
		return 'sl-theme-widget-icon nav-menu';
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

	// Get Menus
	private function luxus_nav_menus() {
		
		$options = array();

        $sl_menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

        if ( is_array( $sl_menus ) && ! empty( $sl_menus ) ) {

            foreach ( $sl_menus as $menu ) {

                if ( is_object( $menu ) && isset( $menu->name, $menu->term_id ) ) {
                    $options[ $menu->term_id ] = $menu->name;
                }

            }
        }

		return $options;

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
		$this->luxus_style_main_menu_options();

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
			'select_nav_menu',
			[
				'label'       => __( 'Select Nav Menu', 'luxus' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => $this->luxus_nav_menus(),
				'description' => empty( $this->luxus_nav_menus() ) ? sprintf( esc_html__( 'Menus not found. Please visit %sAppearance > Menus%s page to create new menu.', 'luxus' ), '<b>', '</b>' ) : esc_html__( 'Select menu to display.', 'luxus' ),
			]
		);

		$this->add_control(
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
					'{{WRAPPER}} .nav-menu-widget .stellarnav.desktop>ul>li>a' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'nav_menu_align',
			[
				'label' => __( 'Menu Alignment', 'luxus' ),
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
					'{{WRAPPER}} .nav-menu-widget' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

	}

	private function luxus_style_main_menu_options() {

		// Desktop Menu

		$this->start_controls_section(
			'section_main_menu_style',
			[
				'label' => __( 'Desktop Menu Style', 'luxus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'nav_sub_menu_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Sub Menu Background', 'luxus' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .nav-menu-widget .stellarnav.desktop ul li ul.sub-menu' => 'background: {{VALUE}};',
					'{{WRAPPER}} .nav-menu-widget .stellarnav.desktop>ul>li>ul.sub-menu:before' => 'background: {{VALUE}};',
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
			'nav_main_menu_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Main Menu Color', 'luxus' ),
				'default' => '#00072D',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .nav-menu-widget .stellarnav.desktop ul li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nav_sub_menu_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Sub Menu Color', 'luxus' ),
				'default' => '#6e7488',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .nav-menu-widget .stellarnav.desktop ul li ul.sub-menu li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nav_sub_menu_links_bg_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Sub Menu Links Background', 'luxus' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .nav-menu-widget .stellarnav.desktop li.has-sub>ul.sub-menu li a' => 'background: {{VALUE}};',
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
			'nav_main_menu_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Main Menu Color', 'luxus' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .nav-menu-widget .stellarnav.desktop ul li a:hover' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .nav-menu-widget .stellarnav.desktop .current-menu-item > a' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .nav-menu-widget .stellarnav.desktop .current-menu-ancestor > a' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'nav_sub_menu_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Sub Menu Color', 'luxus' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .nav-menu-widget .stellarnav.desktop ul li ul.sub-menu li a:hover' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .nav-menu-widget .stellarnav.desktop ul.sub-menu .current-menu-item > a' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .nav-menu-widget .stellarnav.desktop ul.sub-menu .current-menu-ancestor > a' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_control(
			'nav_sub_menu_links_bg_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Sub Menu Links Background', 'luxus' ),
				'default' => '#f5f5ff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .nav-menu-widget .stellarnav.desktop li.has-sub>ul.sub-menu li a:hover' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .nav-menu-widget .stellarnav.desktop ul.sub-menu .current-menu-item > a' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .nav-menu-widget .stellarnav.desktop ul.sub-menu .current-menu-ancestor > a' => 'background: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// Mobile Menu

		$this->start_controls_section(
			'section_mobile_menu_style',
			[
				'label' => __( 'Mobile Menu Style', 'luxus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'mobile_nav_menu_background',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Menu Background', 'luxus' ),
				'default' => '#000144',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .nav-menu-widget .stellarnav.mobile.dark ul' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_nav_sub_menu_background',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Sub Menu Background', 'luxus' ),
				'default' => '',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .nav-menu-widget .stellarnav.mobile.dark ul ul' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'mobile_nav_menu_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'mobile_nav_menu_normal',
			[
				'label'     => __( 'Normal', 'luxus' ),
			]
		);

		$this->add_control(
			'mobile_breadcrumbs_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Breadcrumbs Color', 'luxus' ),
				'default' => '#00072D',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .nav-menu-widget .stellarnav.mobile .menu-toggle span.bars span' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_nav_menu_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Main Menu Color', 'luxus' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .nav-menu-widget .stellarnav.mobile li a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .nav-menu-widget .stellarnav.mobile a' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_control(
			'mobile_nav_sub_menu_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Sub Menu Color', 'luxus' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .nav-menu-widget .stellarnav.mobile ul li ul.sub-menu li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_nav_icons_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Menu Icons Color', 'luxus' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .nav-menu-widget .stellarnav.mobile .icon-close:before' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .nav-menu-widget .stellarnav.mobile .icon-close:after' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .nav-menu-widget .stellarnav.mobile a.dd-toggle .icon-plus:before' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .nav-menu-widget .stellarnav.mobile a.dd-toggle .icon-plus:after' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'mobile_nav_menu_hover',
			[
				'label'     => __( 'Hover', 'luxus' ),
			]
		);

		$this->add_control(
			'mobile_breadcrumbs_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Breadcrumbs Color', 'luxus' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .nav-menu-widget .stellarnav.mobile .menu-toggle span.bars:hover span' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_nav_menu_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Main Menu Color', 'luxus' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .nav-menu-widget .stellarnav.mobile li a:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .nav-menu-widget .stellarnav.mobile a:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .nav-menu-widget .stellarnav.mobile .current-menu-item > a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .nav-menu-widget .stellarnav.mobile .current-menu-ancestor > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_nav_sub_menu_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Sub Menu Color', 'luxus' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .nav-menu-widget .stellarnav.mobile ul li ul.sub-menu li a:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .nav-menu-widget .stellarnav.mobile ul.sub-menu .current-menu-item > a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .nav-menu-widget .stellarnav.mobile ul.sub-menu .current-menu-ancestor > a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mobile_nav_menu_icons_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Menu Icons Color', 'luxus' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .nav-menu-widget .stellarnav.mobile .icon-close:hover:before' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .nav-menu-widget .stellarnav.mobile .icon-close:hover:after' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .nav-menu-widget .stellarnav.mobile a.dd-toggle:hover .icon-plus:before' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .nav-menu-widget .stellarnav.mobile a.dd-toggle:hover .icon-plus:after' => 'border-color: {{VALUE}};',
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
		$select_nav_menu = $settings['select_nav_menu'];

		?>

		<div class="nav-menu-widget">
			<div class="main-menu">
				<div class="stellarnav">
		            <?php
		                wp_nav_menu( array(
		                	'theme_location' => 'primary-menu',
		                    'menu' => $select_nav_menu,
		                    'container'	=> '',
		              	) );
		            ?>
		        </div>
	        </div>
	    </div>

    	<?php
	}
}
