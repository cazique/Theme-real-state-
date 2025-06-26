<?php
namespace SLElementorWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Luxus_Text_Image extends Widget_Base {

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
		return 'luxus-text-image';
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
		return __( 'Text With Image', 'luxus' );
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
		return 'sl-theme-widget-icon text-image';
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

		$this->luxus_content_layout_options();
		$this->luxus_style_text_image_box_options();
		$this->luxus_style_text_image_img_options();
		$this->luxus_style_text_image_content_options();
		$this->luxus_style_text_image_badge_options();
		$this->luxus_style_text_image_button_options();

	}

	// Content Layout Options
	private function luxus_content_layout_options() {

		$this->start_controls_section(
			'section_text_image_layout',
			[
				'label' => __( 'Layout', 'luxus' ),
			]
		);

		$this->add_control(
			'text_image_title',
			[
				'label' => __( 'Title', 'luxus' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Default title', 'luxus' ),
				'placeholder' => __( 'Type your title here', 'luxus' ),
			]
		);

		$this->add_control(
			'text_image_description',
			[
				'label' => __( 'Description', 'luxus' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.', 'luxus' ),
				'placeholder' => __( 'Type your description here', 'luxus' ),
			]
		);

		$this->add_control(
			'text_image_image',
			[
				'label' => __( 'Choose Image', 'luxus' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'show_badge',
			[
				'label' => __( 'Show Badge', 'luxus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'luxus' ),
				'label_off' => __( 'Hide', 'luxus' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'badge_image_icon',
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
				'condition' => ['show_badge' => 'yes',],

			]
		);

		$this->add_control(
			'badge_image',
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
				            'name' => 'show_badge',
				            'operator' => '==',
				            'value' => 'yes'
				        ],
				        [
				            'name' => 'badge_image_icon',
				            'operator' => '==',
				            'value' => 'image'
				        ]
				    ]
				]
			]
		);

		$this->add_control(
			'badge_icon',
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
				            'name' => 'show_badge',
				            'operator' => '==',
				            'value' => 'yes'
				        ],
				        [
				            'name' => 'badge_image_icon',
				            'operator' => '==',
				            'value' => 'icon'
				        ]
				    ]
				]
			]
		);

		$this->add_control(
			'show_btn',
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
			'btn_text',
			[
				'label' => __( 'Button Text', 'luxus' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Learn More', 'luxus' ),
				'condition' => ['show_btn' => 'yes',],
			]
		);

		$this->add_control(
			'btn_hover_animation',
			[
				'label' => __( 'Button Hover Animation', 'luxus' ),
				'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
				'condition' => ['show_btn' => 'yes',],
			]
		);

		$this->add_control(
			'text_image_link',
			[
				'label' => __( 'Link', 'luxus' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'luxus' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

		$this->add_control(
			'content_align',
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
					'{{WRAPPER}} .sl-text-image' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

	}

	private function luxus_style_text_image_box_options() {

		$this->start_controls_section(
			'section_text_image_box_tabs',
			[
				'label' => __( 'Box Style', 'luxus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'box_border',
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
					'{{WRAPPER}} .sl-text-image-container .sl-text-image' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'box_border_radius',
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
					'{{WRAPPER}} .sl-text-image-container .sl-text-image' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'text_image_box_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'text_image_box_normal',
			[
				'label'     => __( 'Normal', 'luxus' ),
			]
		);

		$this->add_control(
			'box_bg_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'luxus' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-text-image-container .sl-text-image' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'box_border_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'luxus' ),
				'default' => '#f7f7ff',
				'selectors' => [
					'{{WRAPPER}} .sl-text-image-container .sl-text-image' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'box_shadow_normal',
				'selector'  => '{{WRAPPER}} .sl-text-image-container .sl-text-image',
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'text_image_box_hover',
			[
				'label'     => __( 'Hover', 'luxus' ),
			]
		);

		$this->add_control(
			'box_bg_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'luxus' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .sl-text-image-container .sl-text-image:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Hover border color.
		$this->add_control(
			'box_border_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'luxus' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .sl-text-image-container .sl-text-image:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'box_shadow_hover',
				'selector'  => '{{WRAPPER}} .sl-text-image-container .sl-text-image:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	private function luxus_style_text_image_img_options() {

		// Layout.
		$this->start_controls_section(
			'section_text_image_style',
			[
				'label' => __( 'Image Style', 'luxus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_height',
			[
				'label'     => __( 'Image Height', 'luxus' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 240,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sl-text-image-container .sl-text-image .image-container' => 'height: {{SIZE}}{{UNIT}}',
					
				],
			]
		);

		$this->add_control(
			'image_overlay_heading',
			[
				'label' => __( 'Image Overlay', 'luxus' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'text_image_image_overlay',
				'label' => __( 'Image Overlay', 'luxus' ),
				'types' => [ 'gradient' ],
				'fields_options' => [
					'background' => [
						'frontend_available' => true,
					],
					'color' => [
						'dynamic' => [],
					],
					'color_b' => [
						'dynamic' => [],
					],
				],
				'selector' => '{{WRAPPER}} .sl-text-image-container .sl-text-image .image-container .img-overlay',
			]
		);

		$this->end_controls_section();

	}

	private function luxus_style_text_image_content_options() {

		$this->start_controls_section(
			'section_text_image_content',
			[
				'label' => __( 'Content Style', 'luxus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_padding',
			[
				'label'      => __( 'Padding', 'luxus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'       => [
					'top' => '20',
					'right' => '20',
					'bottom' => '20',
					'left' => '20',
					'unit' => 'px',
					'isLinked' => 'true',
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .sl-text-image-container .sl-text-image .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],				
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
				'selector' => '{{WRAPPER}} .sl-text-image-container .sl-text-image .content h2',
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
				'selector' => '{{WRAPPER}} .sl-text-image-container .sl-text-image .content .text',
			]
		);

		$this->start_controls_tabs( 'text_image_content_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'text_image_content_normal',
			[
				'label'     => __( 'Normal', 'luxus' ),
			]
		);

		$this->add_control(
			'content_title_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'luxus' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-text-image-container .sl-text-image .content h2' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_text_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Description Color', 'luxus' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-text-image-container .sl-text-image .content .text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'text_image_content_hover',
			[
				'label'     => __( 'Hover', 'luxus' ),
			]
		);

		$this->add_control(
			'content_title_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'luxus' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-text-image-container .sl-text-image:hover .content h2' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_text_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Description Color', 'luxus' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-text-image-container .sl-text-image:hover .content .text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	private function luxus_style_text_image_badge_options() {

		$this->start_controls_section(
			'section_text_image_badge_tabs',
			[
				'label' => __( 'Badge Style', 'luxus' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['show_badge' => 'yes'],
			]
		);

		$this->add_control(
			'badge_padding',
			[
				'label'      => __( 'Badge Padding', 'luxus' ),
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
					'{{WRAPPER}} .sl-text-image-container .sl-text-image .icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'badge_icon_size',
			[
				'label'     => __( 'Icon Size', 'luxus' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 24,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sl-text-image-container .sl-text-image .icon i' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'condition' => ['badge_image_icon' => 'icon'],
			]
		);

		$this->start_controls_tabs( 'text_image_badge_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'text_image_badge_normal',
			[
				'label'     => __( 'Normal', 'luxus' ),
			]
		);

		$this->add_control(
			'badge_border_normal',
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
					'{{WRAPPER}} .sl-text-image-container .sl-text-image .icon' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'badge_border_radius_normal',
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
					'{{WRAPPER}} .sl-text-image-container .sl-text-image .icon' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'badge_border_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'luxus' ),
				'default' => '',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-text-image-container .sl-text-image .icon' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_icon_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Icon Color', 'luxus' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-text-image-container .sl-text-image .icon i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_bg_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'luxus' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .sl-text-image-container .sl-text-image .icon' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'text_image_badge_hover',
			[
				'label'     => __( 'Hover', 'luxus' ),
			]
		);

		$this->add_control(
			'badge_border_hover',
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
					'{{WRAPPER}} .sl-text-image-container .sl-text-image:hover .icon' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'badge_border_radius_hover',
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
					'{{WRAPPER}} .sl-text-image-container .sl-text-image:hover .icon' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'badge_border_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'luxus' ),
				'default' => '',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-text-image-container .sl-text-image:hover .icon' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_icon_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Icon Color', 'luxus' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-text-image-container .sl-text-image:hover .icon i' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'text_image_badge_hover_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'luxus' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .sl-text-image-container .sl-text-image:hover .icon' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	private function luxus_style_text_image_button_options() {

		$this->start_controls_section(
			'section_text_image_button_style',
			[
				'label' => __( 'Button Style', 'luxus' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['show_btn' => 'yes'],
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
					'{{WRAPPER}} .sl-text-image-container .sl-text-image .action' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
					'{{WRAPPER}} .sl-text-image-container .sl-text-image .action a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'text_image_btn_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'text_image_btn_normal',
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
					'{{WRAPPER}} .sl-text-image-container .sl-text-image .action a' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
					'{{WRAPPER}} .sl-text-image-container .sl-text-image .action a' => 'border-radius: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .sl-text-image-container .sl-text-image .action a' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .sl-text-image-container .sl-text-image .action a' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .sl-text-image-container .sl-text-image .action a' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'text_image_btn_hover',
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
					'{{WRAPPER}} .sl-text-image-container .sl-text-image .action a:hover' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
					'{{WRAPPER}} .sl-text-image-container .sl-text-image .action a:hover' => 'border-radius: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .sl-text-image-container .sl-text-image .action a:hover' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .sl-text-image-container .sl-text-image .action a:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .sl-text-image-container .sl-text-image .action a:hover' => 'background: {{VALUE}};',
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
		// $text_image_style = $settings['text_image_style'];

	?>
		<div class="sl-text-image-container">
		
		<?php

			include get_template_directory() . '/inc/widgets/layouts/text-image/layout-1.php';

    	?>

		</div>
    <?php
	}
}