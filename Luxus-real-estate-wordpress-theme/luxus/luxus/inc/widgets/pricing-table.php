<?php
namespace SLElementorWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Luxus_Pricing_Table extends Widget_Base {

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
		return 'luxus-pricing-table';
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
		return __( 'Pricing Table', 'luxus' );
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
		return 'sl-theme-widget-icon pricing-table';
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
		$this->luxus_style_pricing_box_options();
		$this->luxus_style_pricing_title_options();
		$this->luxus_style_pricing_header_options();
		$this->luxus_style_pricing_badge_options();
		$this->luxus_style_pricing_price_options();
		$this->luxus_style_pricing_features_options();
		$this->luxus_style_pricing_btn_options();

	}

	// Content Layout Options
	private function luxus_content_layout_options() {

		$this->start_controls_section(
			'section_layout_options',
			[
				'label' => __( 'Layout', 'luxus' ),
			]
		);

		$this->add_control(
			'pricing_style',
			[
				'label' => __( 'Pricing Style', 'luxus' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Style 1', 'luxus' ),
					'2' => esc_html__( 'Style 2', 'luxus' ),
					'3' => esc_html__( 'Style 3', 'luxus' ),
				],
			]
		);

		$this->add_control(
			'pricing_title',
			[
				'label' => __( 'Title', 'luxus' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Premium', 'luxus' ),
				'placeholder' => __( 'Type your title here', 'luxus' ),
			]
		);

		$this->add_control(
			'pricing_show_badge',
			[
				'label' => __( 'Show Badge', 'luxus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'luxus' ),
				'label_off' => __( 'Hide', 'luxus' ),
				'return_value' => 'yes',
				'default' => 'no',
				'conditions' => [
				    'relation' => 'or',
				    'terms' => [
				        [
				            'name' => 'pricing_style',
				            'operator' => '==',
				            'value' => 1
				        ],
				        [
				            'name' => 'pricing_style',
				            'operator' => '==',
				            'value' => 2
				        ]
				    ]
				]
			]
		);

		$this->add_control(
			'badge_icon',
			[
				'label' => __( 'Badge Icon', 'luxus' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
				'condition' => ['pricing_show_badge' => 'yes'],
			]
		);

		$this->add_control(
			'pricing_price',
			[
				'label' => __( 'Price', 'luxus' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( '$99 / Yearly', 'luxus' ),
				'placeholder' => __( 'Type your description here', 'luxus' ),
			]
		);

		// Repeater Start
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'features_list_title', [
				'label' => __( 'Title', 'luxus' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Features List Title' , 'luxus' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'features_list',
			[
				'label' => __( 'Features List', 'luxus' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => __( 'Title #1', 'luxus' ),
					],
				],
				'title_field' => '{{{ features_list_title }}}',
			]
		);

		// Repeater end

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
			'btn_hover_animation',
			[
				'label' => __( 'Button Hover Animation', 'luxus' ),
				'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
				'condition' => ['show_btn' => 'yes',],
			]
		);

		$this->add_control(
			'btn_text',
			[
				'label' => __( 'Button Text', 'luxus' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Subscribe Now', 'luxus' ),
				'condition' => ['show_btn' => 'yes',],
			]
		);

		$this->add_control(
			'btn_link',
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
				'condition' => ['show_btn' => 'yes',],
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
					'{{WRAPPER}} .sl-pricing' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

	}

	private function luxus_style_pricing_box_options() {

		$this->start_controls_section(
			'section_box_style',
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
					'{{WRAPPER}} .sl-pricing-container .sl-pricing' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
					'{{WRAPPER}} .sl-pricing-container .sl-pricing' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'pricing_box_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'pricing_box_normal',
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
					'{{WRAPPER}} .sl-pricing-container .sl-pricing' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .sl-pricing-container .sl-pricing' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'box_box_shadow_normal',
				'selector'  => '{{WRAPPER}} .sl-pricing-container .sl-pricing',
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'pricing_box_hover',
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
					'{{WRAPPER}} .sl-pricing-container .sl-pricing:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'box_border_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'luxus' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .sl-pricing-container .sl-pricing:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'box_box_shadow_hover',
				'selector'  => '{{WRAPPER}} .sl-pricing-container .sl-pricing:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	private function luxus_style_pricing_title_options() {

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => __( 'Title Style', 'luxus' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'conditions' => [
				    'relation' => 'or',
				    'terms' => [
				        [
				            'name' => 'pricing_style',
				            'operator' => '==',
				            'value' => '1'
				        ],
				        [
				            'name' => 'pricing_style',
				            'operator' => '==',
				            'value' => '2'
				        ]
				    ]
				]
			]
		);

		$this->add_control(
			'title_area_padding',
			[
				'label'      => __( 'Padding', 'luxus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default' => [
						'top' => '20',
						'right' => '20',
						'bottom' => '20',
						'left' => '20',
						'unit' => 'px',
						'isLinked' => true,
					],

				'selectors'  => [
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Typography', 'luxus' ),
				 
				'selector' => '{{WRAPPER}} .sl-pricing-container .sl-pricing .title h2',
			]
		);

		$this->add_control(
			'title_area_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'luxus' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .title h2' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	private function luxus_style_pricing_header_options() {

		$this->start_controls_section(
			'section_header_style',
			[
				'label' => __( 'Header Style', 'luxus' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'pricing_style' => '3' ],
			]
		);

		$this->add_control(
			'title_header_padding',
			[
				'label'      => __( 'Padding', 'luxus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default' => [
					'top' => '20',
					'right' => '20',
					'bottom' => '20',
					'left' => '20',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'header_title_typography',
				'label' => __( 'Title Typography', 'luxus' ),
				'selector' => '{{WRAPPER}} .sl-pricing-container .sl-pricing .title h2',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'header_price_typography',
				'label' => __( 'Price Typography', 'luxus' ),
				'selector' => '{{WRAPPER}} .sl-pricing-container .sl-pricing .h-price',
			]
		);


		$this->start_controls_tabs( 'pricing_header_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'pricing_header_normal',
			[
				'label'     => __( 'Normal', 'luxus' ),
			]
		);

		$this->add_control(
			'header_title_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'luxus' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .title h2' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'header_price_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Price Color', 'luxus' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .header .h-price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'header_bg_normal',
				'label' => __( 'Background', 'luxus' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .sl-pricing-container .sl-pricing .header',
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'pricing_header_hover',
			[
				'label'     => __( 'Hover', 'luxus' ),
			]
		);

		$this->add_control(
			'header_title_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'luxus' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-pricing-container .sl-pricing:hover .title h2' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'header_price_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Price Color', 'luxus' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-pricing-container .sl-pricing:hover .header .h-price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'header_bg_hover',
				'label' => __( 'Background', 'luxus' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .sl-pricing-container .sl-pricing:hover .header',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	private function luxus_style_pricing_badge_options() {

		$this->start_controls_section(
			'section_badge_style',
			[
				'label' => __( 'Badge Style', 'luxus' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['pricing_show_badge' => 'yes'],
			]
		);

		$this->add_control(
			'badge_area_padding',
			[
				'label'      => __( 'Padding', 'luxus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default' => [
						'top' => '12',
						'right' => '12',
						'bottom' => '12',
						'left' => '12',
						'unit' => 'px',
						'isLinked' => true,
					],

				'selectors'  => [
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .title .badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'condition' => ['pricing_style' => '1'],
			]
		);

		$this->add_control(
			'badge_area_icon_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Icon Color', 'luxus' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .title .badge i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_area_icon_color_2',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Icon Color', 'luxus' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .badge i' => 'color: {{VALUE}};',
				],
				'condition' => ['pricing_style' => '2'],
			]
		);

		$this->add_control(
			'badge_area_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'luxus' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_area_icon_size',
			[
				'label'     => __( 'Icon Size', 'luxus' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 20,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .badge i' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'badge_area_border_radius',
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
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .title .badge' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
				'condition' => ['pricing_style' => '1'],
			]
		);

		$this->end_controls_section();

	}

	private function luxus_style_pricing_price_options() {

		$this->start_controls_section(
			'section_price_style',
			[
				'label' => __( 'Price Area Style', 'luxus' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'conditions' => [
				    'relation' => 'or',
				    'terms' => [
				        [
				            'name' => 'pricing_style',
				            'operator' => '==',
				            'value' => '1'
				        ],
				        [
				            'name' => 'pricing_style',
				            'operator' => '==',
				            'value' => '2'
				        ]
				    ]
				]
			]
		);

		$this->add_control(
			'price_area_padding',
			[
				'label'      => __( 'Padding', 'luxus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default' => [
					'top' => '20',
					'right' => '20',
					'bottom' => '20',
					'left' => '20',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'price_area_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'price_area_normal',
			[
				'label'     => __( 'Normal', 'luxus' ),
			]
		);

		$this->add_control(
			'price_area_txt_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Text Color', 'luxus' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_area_bg_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'luxus' ),
				'default' => '#f7f7ff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .price' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .badge .badge-after' => '    border-bottom: 8px solid {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'price_area_hover',
			[
				'label'     => __( 'Hover', 'luxus' ),
			]
		);

		$this->add_control(
			'price_area_txt_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Text Color', 'luxus' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-pricing-container .sl-pricing:hover .price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_area_bg_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'luxus' ),
				'default' => '#00bbff',
				'selectors' => [
					'{{WRAPPER}} .sl-pricing-container .sl-pricing:hover .price' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .sl-pricing-container .sl-pricing:hover .badge .badge-after' => '    border-bottom: 8px solid {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	private function luxus_style_pricing_features_options() {

		$this->start_controls_section(
			'section_features_style',
			[
				'label' => __( 'Features List Style', 'luxus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'features_list_padding',
			[
				'label'      => __( 'Padding', 'luxus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default' => [
					'top' => '20',
					'right' => '20',
					'bottom' => '20',
					'left' => '20',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .features' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'features_list_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'features_list_normal',
			[
				'label'     => __( 'Normal', 'luxus' ),
			]
		);

		$this->add_control(
			'list_txt_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Text Color', 'luxus' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .features ul li' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'features_list_hover',
			[
				'label'     => __( 'Hover', 'luxus' ),
			]
		);

		$this->add_control(
			'list_txt_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Text Color', 'luxus' ),
				'default' => '#555555',
				'selectors' => [
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .features ul li:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'list_bg_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'luxus' ),
				'default' => '#f7f7ff',
				'selectors' => [
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .features ul li:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	private function luxus_style_pricing_btn_options() {

		$this->start_controls_section(
			'section_btn_style',
			[
				'label' => __( 'Button Style', 'luxus' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['show_btn' => 'yes'],
			]
		);

		$this->add_control(
			'btn_area_margin',
			[
				'label'      => __( 'Margin', 'luxus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default' => [
					'top' => '20',
					'right' => '20',
					'bottom' => '20',
					'left' => '20',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .action' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'btn_padding',
			[
				'label'      => __( 'Padding', 'luxus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default' => [
					'top' => '10',
					'right' => '20',
					'bottom' => '10',
					'left' => '20',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .action a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'pricing_btn_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'pricing_btn_normal',
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
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .action a' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .action a' => 'border-radius: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .action a' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .action a' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .action a' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'pricing_btn_hover',
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
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .action a:hover' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .action a:hover' => 'border-radius: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .action a:hover' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .action a:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .sl-pricing-container .sl-pricing .action a:hover' => 'background: {{VALUE}};',
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
		$pricing_style = $settings['pricing_style'];

		?>
			<div class="sl-pricing-container">
			
			<?php

		    	if( 3 == $pricing_style ){

		    		include get_template_directory() . '/inc/widgets/layouts/pricing-table/layout-3.php';

		    	}elseif( 2 == $pricing_style ){

		    		include get_template_directory() . '/inc/widgets/layouts/pricing-table/layout-2.php';

		    	}else{

		    		include get_template_directory() . '/inc/widgets/layouts/pricing-table/layout-1.php';

		    	}

	    	?>

			</div>
    	<?php
	}
}