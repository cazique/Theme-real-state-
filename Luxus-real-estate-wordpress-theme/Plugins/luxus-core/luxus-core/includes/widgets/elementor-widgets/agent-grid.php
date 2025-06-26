<?php
namespace SLElementorWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Luxus_Agent_Grid extends Widget_Base {

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
		return 'luxus-agent-grid';
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
		return __( 'Agents Grid', 'luxus-core' );
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
		return 'sl-widget-icon agent-grid';
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
		$this->luxus_style_agent_box_options();
		$this->luxus_style_agent_social_options();

	}

	// Content Layout Options
	private function luxus_genetal_layout_options() {

		$this->start_controls_section(
			'section_layout_options',
			[
				'label' => __( 'Layout', 'luxus-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'agent_style',
			[
				'label' => __( 'Agents Style', 'luxus-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Style 1', 'luxus-core' ),
					'2' => esc_html__( 'Style 2', 'luxus-core' ),
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => __( 'Columns', 'luxus-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
				],
				'prefix_class' => 'elementor-grid%s-',
				'frontend_available' => true,
				'selectors' => [
					'.elementor-msie {{WRAPPER}} .elementor-portfolio-item' => 'width: calc( 100% / {{SIZE}} )',
				],
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => __( 'Posts Per Page', 'luxus-core' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 6,
			]
		);


		$this->add_control(
			'agent_show_icons',
			[
				'label' => __( 'Show Social Icons', 'luxus-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'luxus-core' ),
				'label_off' => __( 'Hide', 'luxus-core' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'grid_columns_margin',
			[
				'label'     => __( 'Columns Margin', 'luxus-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 15,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container' => 'grid-column-gap: {{SIZE}}{{UNIT}}',
					
				],
			]
		);

		$this->add_control(
			'grid_rows_margin',
			[
				'label'     => __( 'Rows Margin', 'luxus-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 15,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

	}

	private function luxus_style_agent_box_options() {

		$this->start_controls_section(
			'section_agent_style',
			[
				'label' => __( 'agent Style', 'luxus-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'agent_image_height',
			[
				'label'     => __( 'Image Height', 'luxus-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 185,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .agent-item.agent-one .picture' => 'height: {{SIZE}}{{UNIT}}',
				],
				'condition' => ['agent_style' => '1',],
			]
		);

		$this->add_control(
			'agent_image_height_two',
			[
				'label'     => __( 'Image Height', 'luxus-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 400,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 800,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .agent-item.team-two' => 'height: {{SIZE}}{{UNIT}}',
				],
				'condition' => ['agent_style' => '2',],
			]
		);

		$this->add_control(
			'agent_image_width',
			[
				'label'     => __( 'Image Width', 'luxus-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 185,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .agent-item.agent-one .picture' => 'width: {{SIZE}}{{UNIT}}',
				],
				'condition' => ['agent_style' => '1',],
			]
		);

		$this->add_control(
			'agent_hover_image_overlay',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Image Overlay Color', 'luxus-core' ),
				'default' => '#00072d99',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .agent-item.agent-one .picture .view-profile' => 'background-color: {{VALUE}};',
				],
				'condition' => ['agent_style' => '1',],
			]
		);

		$this->add_control(
			'agent_link_icon_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Link Icon Color', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .agent-item.agent-one:hover .picture .view-profile i.fa' => 'color: {{VALUE}};',
				],
				'condition' => ['agent_style' => '1',],
			]
		);

		$this->add_control(
			'agent_border_radius',
			[
				'label' => __( 'Border Radius', 'luxus-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .agent-item.agent-one' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'condition' => ['agent_style' => '1',],
			]
		);

		$this->add_control(
			'agent_border_radius_two',
			[
				'label' => __( 'Border Radius', 'luxus-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .agent-item.team-two' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'condition' => ['agent_style' => '2',],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'agent_title_typography',
				'label' => __( 'Title Typography', 'luxus-core' ),
				'fields_options'  => [
		            'typography'  => [ 'default' => 'yes' ],
		            'font_size'   => [ 'default' => [ 'size' => 20 ] ],
		            'font_weight' => [ 'default' => 600 ],
		            'line_height' => [ 'default' => [ 'size' => 22 ] ],
		        ],
				'selector' => '{{WRAPPER}} .sl-grid-container .agent-item.agent-one .name, {{WRAPPER}} .sl-grid-container .agent-item.team-two .info .name',
			]
		);

		$this->start_controls_tabs( 'agent_box_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'agent_box_normal',
			[
				'label'     => __( 'Normal', 'luxus-core' ),
			]
		);

		$this->add_control(
			'agent_title_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'luxus-core' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .agent-item.agent-one .name' => 'color: {{VALUE}};',
				],
				'condition' => ['agent_style' => '1',],
			]
		);

		$this->add_control(
			'agent_link_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Link Color', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .agent-item.team-two .info .more' => 'color: {{VALUE}};',
				],
				'condition' => ['agent_style' => '2',],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'agent_box_shadow_normal',
				'label' => __( 'Box Shadow', 'luxus-core' ),
				'selector' => '{{WRAPPER}} .sl-grid-container .agent-item.agent-one, {{WRAPPER}} .sl-grid-container .agent-item.team-two',
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'agent_box_hover',
			[
				'label'     => __( 'Hover', 'luxus-core' ),
			]
		);

		$this->add_control(
			'agent_title_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'luxus-core' ),
				'default' => '#00BBFF',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .agent-item.agent-one .name:hover' => 'color: {{VALUE}};',
				],
				'condition' => ['agent_style' => '1',],
			]
		);

		$this->add_control(
			'agent_link_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Link Color', 'luxus-core' ),
				'default' => '#00BBFF',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .agent-item.team-two .info .more:hover' => 'color: {{VALUE}};',
				],
				'condition' => ['agent_style' => '2',],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'agent_box_shadow_hover',
				'label' => __( 'Box Shadow', 'luxus-core' ),
				'selector' => '{{WRAPPER}} .sl-grid-container .agent-item.agent-one:hover, {{WRAPPER}} .sl-grid-container .agent-item.team-two:hover',
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	private function luxus_style_agent_social_options() {

		$this->start_controls_section(
			'section_social_style',
			[
				'label' => __( 'Social Icons Style', 'luxus-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['agent_show_icons' => 'yes',],
			]
		);

		$this->start_controls_tabs( 'agent_social_icons_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'social_icons_normal',
			[
				'label'     => __( 'Normal', 'luxus-core' ),
			]
		);

		$this->add_control(
			'social_icons_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Icon Color', 'luxus-core' ),
				'default' => '#00BBFF',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .agent-item.agent-one .social ul li i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .agent-item.team-two .social ul li i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_icons_bg_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .agent-item.agent-one .social ul li i' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .agent-item.team-two .social ul li i' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'social_icons_border_normal',
				'label' => __( 'Border Size', 'luxus-core' ),
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' => [
							'top' => '1',
							'right' => '1',
							'bottom' => '1',
							'left' => '1',
							'isLinked' => true,
						],
					],
					'color' => [
						'default' => '#00BBFF',
					],
				],
				'selector' => '{{WRAPPER}} .sl-grid-container .agent-item.agent-one .social ul li i, {{WRAPPER}} .sl-grid-container .agent-item.team-two .social ul li i',
			]
		);

		$this->add_control(
			'social_icons_border_radius_normal',
			[
				'label'     => __( 'Border Radius', 'luxus-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 100,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .agent-item.agent-one .social ul li i' => 'border-radius: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .sl-grid-container .agent-item.team-two .social ul li i' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'agent_social_icons_hover',
			[
				'label'     => __( 'Hover', 'luxus-core' ),
			]
		);

		$this->add_control(
			'social_icons_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Icon Color', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .agent-item.agent-one .social ul li i:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .agent-item.team-two .social ul li i:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_icons_bg_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background', 'luxus-core' ),
				'default' => '#00BBFF',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .agent-item.agent-one .social ul li i:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .agent-item.team-two .social ul li i:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'social_icons_border_hover',
				'label' => __( 'Border Size', 'luxus-core' ),
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' => [
							'top' => '1',
							'right' => '1',
							'bottom' => '1',
							'left' => '1',
							'isLinked' => true,
						],
					],
					'color' => [
						'default' => '#00BBFF',
					],
				],
				'selector' => '{{WRAPPER}} .sl-grid-container .agent-item.agent-one .social ul li i:hover, {{WRAPPER}} .sl-grid-container .agent-item.team-two .social ul li i:hover',
			]
		);

		$this->add_control(
			'social_icons_border_radius_hover',
			[
				'label'     => __( 'Border Radius', 'luxus-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 100,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .agent-item.agent-one .social ul li i:hover' => 'border-radius: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .sl-grid-container .agent-item.team-two .social ul li i:hover' => 'border-radius: {{SIZE}}{{UNIT}}',
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
		$agent_style = $settings['agent_style'];
		$agent_show_icons = $settings['agent_show_icons'];
		$posts_per_page = ( ! empty( $settings['posts_per_page'] ) ?  $settings['posts_per_page'] : 3 );

		$sl_columns_desktop = ( ! empty( $settings['columns'] ) ? 'sl-grid-desktop-' . $settings['columns'] : 'sl-grid-desktop-3' );

		$sl_columns_tablet = ( ! empty( $settings['sl_columns_tablet'] ) ? ' sl-grid-tablet-' . $settings['sl_columns_tablet'] : ' sl-grid-tablet-2' );

		$sl_columns_mobile = ( ! empty( $settings['sl_columns_mobile'] ) ? ' sl-grid-mobile-' . $settings['sl_columns_mobile'] : ' sl-grid-mobile-1' );

	?>
		<div class="sl-grid-container elementor-grid <?php echo $sl_columns_desktop . $sl_columns_tablet . $sl_columns_mobile; ?>">
			
       	<?php

            $query_args = array(
                'role' => 'agent',
                'number' => esc_html($posts_per_page),
            );

            // Create the WP_User_Query object
            $agent_query = new \WP_User_Query($query_args);

            // Get the results
            $agents = $agent_query->get_results();

            // Check for results
            if (!empty($agents)) :

    	        // loop through each users
                foreach ( $agents as $agent ) {

                    // Agency Template Parts

                    if( 2 == $agent_style ){

			    		include( __DIR__ . '/layouts/agent-grid/layout-2.php' );

			    	}else{

			    		include( __DIR__ . '/layouts/agent-grid/layout-1.php' );

			    	}
                    
                }

            else: ?>

            	<p><?php esc_html_e( 'Sorry, No agents found.', 'luxus-core' ); ?></p>

            <?php endif;

            wp_reset_postdata();
            
        ?>

		</div>

    	<?php
	}
}
