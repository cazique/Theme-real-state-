<?php
namespace SLElementorWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Luxus_Info_Box extends Widget_Base {

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
		return 'luxus-info-box';
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
		return __( 'Info Box', 'luxus' );
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
		return 'sl-theme-widget-icon info-box';
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
		$this->luxus_style_info_box_options();
		$this->luxus_style_info_box_icon_options();
		$this->luxus_style_info_box_content_options();
		$this->luxus_style_info_box_button_options();

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
			'info_box_style',
			[
				'label' => __( 'Info Box Style', 'luxus' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Style 1', 'luxus' ),
					'2' => esc_html__( 'Style 2', 'luxus' ),
				],
			]
		);

		$this->add_control(
			'info_box_show_icon',
			[
				'label' => __( 'Show Icon', 'luxus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'luxus' ),
				'label_off' => __( 'Hide', 'luxus' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'info_box_image_icon_possition',
			[
				'label' => __( 'Icon / Image Possition', 'luxus' ),
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
					'{{WRAPPER}} .sl-info-box-container .sl-info-box .icon' => 'float: {{VALUE}};',
				],
				'separator' => 'before',
				'conditions' => [
				    'relation' => 'and',
				    'terms' => [
				        [
				            'name' => 'info_box_show_icon',
				            'operator' => '==',
				            'value' => 'yes'
				        ],
				        [
				            'name' => 'info_box_style',
				            'operator' => '==',
				            'value' => '1'
				        ]
				    ]
				]
			]
		);

		$this->add_control(
			'info_box_image_icon',
			[
				'label' => __( 'Image / Icon', 'luxus' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'image' => [
						'title' => __( 'Image', 'luxus' ),
						'icon' => 'fa fa-picture-o',
					],
					'icon' => [
						'title' => __( 'Icon', 'luxus' ),
						'icon' => 'fa fa-star-o',
					],
				],
				'default' => 'icon',
				'toggle' => true,
				'condition' => ['info_box_show_icon' => 'yes'],

			]
		);

		$this->add_control(
			'info_box_image',
			[
				'label' => __( 'Choose Image', 'luxus' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'conditions' => [
				    'relation' => 'and',
				    'terms' => [
				        [
				            'name' => 'info_box_show_icon',
				            'operator' => '==',
				            'value' => 'yes'
				        ],
				        [
				            'name' => 'info_box_image_icon',
				            'operator' => '==',
				            'value' => 'image'
				        ]
				    ]
				]
			]
		);

		$this->add_control(
			'info_box_icon',
			[
				'label' => __( 'Icon', 'luxus' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
				'conditions' => [
				    'relation' => 'and',
				    'terms' => [
				        [
				            'name' => 'info_box_show_icon',
				            'operator' => '==',
				            'value' => 'yes'
				        ],
				        [
				            'name' => 'info_box_image_icon',
				            'operator' => '==',
				            'value' => 'icon'
				        ]
				    ]
				]
			]
		);

		$this->add_control(
			'info_box_title',
			[
				'label' => __( 'Title', 'luxus' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Default title', 'luxus' ),
				'placeholder' => __( 'Type your title here', 'luxus' ),
			]
		);

		$this->add_control(
			'info_box_description',
			[
				'label' => __( 'Description', 'luxus' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.', 'luxus' ),
				'placeholder' => __( 'Type your description here', 'luxus' ),
			]
		);

		$this->add_control(
			'info_box_show_btn',
			[
				'label' => __( 'Show Button', 'luxus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'luxus' ),
				'label_off' => __( 'Hide', 'luxus' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'btn_hover_animation',
			[
				'label' => __( 'Button Hover Animation', 'luxus' ),
				'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
				'condition' => ['info_box_show_btn' => 'yes'],
			]
		);

		$this->add_control(
			'info_box_btn_text',
			[
				'label' => __( 'Button Text', 'luxus' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Learn More', 'luxus' ),
				'condition' => ['info_box_show_btn' => 'yes'],
			]
		);

		$this->add_control(
			'info_box_btn_link',
			[
				'label' => __( 'Button Link', 'luxus' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'luxus' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
				'condition' => ['info_box_show_btn' => 'yes'],
			]
		);

		$this->add_control(
			'info_box_link',
			[
				'label' => __( 'Info Box Link', 'luxus' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'luxus' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
				'condition' => ['info_box_show_btn' => ''],
			]
		);

		$this->add_control(
			'info_box_content_align',
			[
				'label' => __( 'Alignment', 'luxus' ),
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
					'{{WRAPPER}} .sl-info-box' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

	}

	private function luxus_style_info_box_options() {

		$this->start_controls_section(
			'section_info_box_style',
			[
				'label' => __( 'Box Style', 'luxus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'info_box_padding',
			[
				'label'      => __( 'Padding', 'luxus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => '20',
					'right' => '20',
					'bottom' => '20',
					'left' => '20',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'info_box_border',
			[
				'label'      => __( 'Border Size', 'luxus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => '1',
					'right' => '1',
					'bottom' => '1',
					'left' => '1',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		// Border Radius.
		$this->add_control(
			'info_box_border_radius',
			[
				'label'     => __( 'Border Radius', 'luxus' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 5,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'info_box_box_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'info_box_style_normal',
			[
				'label'     => __( 'Normal', 'luxus' ),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'bg_color_normal',
				'label' => esc_html__( 'Background', 'luxus' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .sl-info-box-container .sl-info-box',
			]
		);

		$this->add_control(
			'border_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'luxus' ),
				'default' => '#f7f7ff',
				'selectors' => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'box_shadow_normal',
				'selector'  => '{{WRAPPER}} .sl-info-box-container .sl-info-box',
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'info_box_style_hover',
			[
				'label'     => __( 'Hover', 'luxus' ),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'bg_color_hover',
				'label' => esc_html__( 'Background', 'luxus' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .sl-info-box-container .sl-info-box:hover',
			]
		);

		$this->add_control(
			'border_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'luxus' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'box_shadow_hover',
				'selector'  => '{{WRAPPER}} .sl-info-box-container .sl-info-box:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	private function luxus_style_info_box_icon_options() {

		$this->start_controls_section(
			'section_info_box_icon_tabs',
			[
				'label' => __( 'Icon / Image Style', 'luxus' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['info_box_show_icon' => 'yes'],
			]
		);

		$this->add_control(
			'icon_margin',
			[
				'label'      => __( 'Margin', 'luxus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'       => [
					'top' => '',
					'right' => '',
					'bottom' => '10',
					'left' => '',
					'unit' => 'px',
					'isLinked' => 'true',
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box .icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],				
			]
		);

		$this->add_control(
			'icon_padding',
			[
				'label'      => __( 'Icon / Image Padding', 'luxus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default' => [
					'top' => '10',
					'right' => '10',
					'bottom' => '10',
					'left' => '10',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box .icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'condition' => ['info_box_style' => '1'],
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label'     => __( 'Icon Size', 'luxus' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 60,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box .icon i' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'condition' => ['info_box_image_icon' => 'icon'],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'image_size',
				'exclude' => [ 'medium_large', 'large', '1536x1536', '2048x2048', 'luxus-thumb-lg', 'luxus-thumb-md' ],
				'default' => 'thumbnail',
				'condition' => ['info_box_image_icon' => 'image'],
			]
		);

		$this->start_controls_tabs( 'info_box_icon_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'info_box_icon_normal',
			[
				'label'     => __( 'Normal', 'luxus' ),
			]
		);

		$this->add_control(
			'icon_border_normal',
			[
				'label'      => __( 'Border', 'luxus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default' => [
						'top' => '0',
						'right' => '0',
						'bottom' => '0',
						'left' => '0',
						'unit' => 'px',
						'isLinked' => true,
					],

				'selectors'  => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box .icon' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'condition' => ['info_box_style' => '1'],
			]
		);

		$this->add_control(
			'icon_border_radius_normal',
			[
				'label'     => __( 'Border Radius', 'luxus' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 50,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box .icon' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
				'condition' => ['info_box_style' => '1'],
			]
		);

		$this->add_control(
			'icon_border_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'luxus' ),
				'default' => '',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box .icon' => 'border-color: {{VALUE}};',
				],
				'condition' => ['info_box_style' => '1'],
			]
		);

		$this->add_control(
			'icon_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Icon Color', 'luxus' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box .icon i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_bg_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'luxus' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box .icon' => 'background: {{VALUE}};',
				],
				'condition' => ['info_box_style' => '1'],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'info_box_icon_hover',
			[
				'label'     => __( 'Hover', 'luxus' ),
			]
		);

		$this->add_control(
			'icon_border_hover',
			[
				'label'      => __( 'Border', 'luxus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '0',
					'left' => '0',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box:hover .icon' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'condition' => ['info_box_style' => '1'],
			]
		);

		$this->add_control(
			'icon_border_radius_hover',
			[
				'label'     => __( 'Border Radius', 'luxus' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 50,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box:hover .icon' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
				'condition' => ['info_box_style' => '1'],
			]
		);

		$this->add_control(
			'icon_border_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'luxus' ),
				'default' => '',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box:hover .icon' => 'border-color: {{VALUE}};',
				],
				'condition' => ['info_box_style' => '1'],
			]
		);

		$this->add_control(
			'icon_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Icon Color', 'luxus' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box:hover .icon i' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'icon_bg_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'luxus' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box:hover .icon' => 'background: {{VALUE}};',
				],
				'condition' => ['info_box_style' => '1'],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	private function luxus_style_info_box_content_options() {

		$this->start_controls_section(
			'section_info_box_content',
			[
				'label' => __( 'Content Style', 'luxus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title Typography', 'luxus' ),
				
				'fields_options'  => [
		            'typography'  => [ 'default' => 'yes' ],
		            'font_size'   => [ 'default' => [ 'size' => 22 ] ],
		            'font_weight' => [ 'default' => 600 ],
		            'line_height' => [ 'default' => [ 'size' => 26 ] ],
		        ],
				'selector' => '{{WRAPPER}} .sl-info-box-container .sl-info-box .title',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Description Typography', 'luxus' ),
				'fields_options'  => [
		            'typography'  => [ 'default' => 'yes' ],
		            'font_size'   => [ 'default' => [ 'size' => 15 ] ],
		            'font_weight' => [ 'default' => 'normal' ],
		            'line_height' => [ 'default' => [ 'size' => 24 ] ],
		        ],
				'selector' => '{{WRAPPER}} .sl-info-box-container .sl-info-box .text',
			]
		);
		
		$this->start_controls_tabs( 'info_box_content_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'info_box_content_normal',
			[
				'label'     => __( 'Normal', 'luxus' ),
			]
		);

		$this->add_control(
			'title_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'luxus' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box .title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Description Color', 'luxus' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box .text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'info_box_content_hover',
			[
				'label'     => __( 'Hover', 'luxus' ),
			]
		);

		$this->add_control(
			'title_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'luxus' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box:hover .title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Description Color', 'luxus' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box:hover .text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	private function luxus_style_info_box_button_options() {

		$this->start_controls_section(
			'section_info_box_button_style',
			[
				'label' => __( 'Button Style', 'luxus' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['info_box_show_btn' => 'yes'],
			]
		);

		$this->add_control(
			'btn_margin',
			[
				'label'      => __( 'Button Margin', 'luxus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default' => [
					'top' => '10',
					'right' => '0',
					'bottom' => '0',
					'left' => '0',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box .action' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'btn_padding',
			[
				'label'      => __( 'Button Padding', 'luxus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default' => [
					'top' => '8',
					'right' => '16',
					'bottom' => '8',
					'left' => '16',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box .action a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'info_box_btn_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'info_box_btn_normal',
			[
				'label'     => __( 'Normal', 'luxus' ),
			]
		);

		$this->add_control(
			'btn_border_normal',
			[
				'label'      => __( 'Border', 'luxus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default' => [
					'top' => '2',
					'right' => '2',
					'bottom' => '2',
					'left' => '2',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box .action a' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'btn_border_radius_normal',
			[
				'label'     => __( 'Border Radius', 'luxus' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 3,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box .action a' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'btn_border_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'luxus' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box .action a' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_txt_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Text Color', 'luxus' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box .action a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_bg_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'luxus' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box .action a' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'info_box_btn_hover',
			[
				'label'     => __( 'Hover', 'luxus' ),
			]
		);

		$this->add_control(
			'btn_border_hover',
			[
				'label'      => __( 'Border', 'luxus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default' => [
					'top' => '2',
					'right' => '2',
					'bottom' => '2',
					'left' => '2',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box .action a:hover' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'btn_border_radius_hover',
			[
				'label'     => __( 'Border Radius', 'luxus' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 3,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box .action a:hover' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'btn_border_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'luxus' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box .action a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_txt_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Text Color', 'luxus' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box .action a:hover' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'btn_bg_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'luxus' ),
				'default' => '#00bbff',
				'selectors' => [
					'{{WRAPPER}} .sl-info-box-container .sl-info-box .action a:hover' => 'background: {{VALUE}};',
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
		$info_box_style = $settings['info_box_style'];

		?>
			<div class="sl-info-box-container">
			<?php

		    	if( 2 == $info_box_style ){

		    		include get_template_directory() . '/inc/widgets/layouts/info-box/layout-2.php';

		    	}else{

		    		include get_template_directory() . '/inc/widgets/layouts/info-box/layout-1.php';

		    	}

	    	?>
			</div>
    	<?php
	}
}
