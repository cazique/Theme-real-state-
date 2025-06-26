<?php
namespace SLElementorWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Luxus_Testimonial_Carousel extends Widget_Base {

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
		return 'luxus-testimonial-caousel';
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
		return __( 'Luxus Testimonial Caousel', 'luxus-core' );
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
		return 'sl-widget-icon testimonial-carousel';
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

		$this->section_testimonials_repeater_options();
		$this->luxus_general_layout_options();
		$this->luxus_style_testimonial_carousel_options();
		$this->luxus_style_testimonial_carousel_item_options();
		$this->luxus_style_testimonial_carousel_content_options();
	}

	// Content Layout Options
	private function section_testimonials_repeater_options() {

		$this->start_controls_section(
			'section_testimonials_repeater_options',
			[
				'label' => __( 'Testimonials', 'luxus-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'testimonial_title', [
				'label' => __( 'Title', 'luxus-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'John Doe' , 'luxus-core' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'testimonial_designation', [
				'label' => __( 'Designation', 'luxus-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Customer' , 'luxus-core' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'testimonial_content', [
				'label' => __( 'Content', 'luxus-core' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nec pharetra arcu. Aenean auctor eu ligula vitae cursus. Quisque eu massa quis ex eleifend condimentum ac id augue. Integer rhoncus pretium lacus eget maximus. Suspendisse consequat magna quis cursus pulvinar. Morbi nec ipsum leo. Sed eu tellus eu lacus finibus aliquet.' , 'luxus-core' ),
				'show_label' => false,
			]
		);

		$repeater->add_control(
			'testimonial_image',
			[
				'label' => __( 'Choose Image', 'luxus-core' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'testimonial',
			[
				'label' => __( 'Repeater List', 'luxus-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'testimonial_title' => __( 'John Doe', 'luxus-core' ),
						'testimonial_designation' => __( 'Customer', 'luxus-core' ),
						'testimonial_content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nec pharetra arcu. Aenean auctor eu ligula vitae cursus. Quisque eu massa quis ex eleifend condimentum ac id augue. Integer rhoncus pretium lacus eget maximus. Suspendisse consequat magna quis cursus pulvinar. Morbi nec ipsum leo. Sed eu tellus eu lacus finibus aliquet.',
					],
					[
						'testimonial_title' => __( 'Jane Doe', 'luxus-core' ),
						'testimonial_designation' => __( 'Customer', 'luxus-core' ),
						'testimonial_content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nec pharetra arcu. Aenean auctor eu ligula vitae cursus. Quisque eu massa quis ex eleifend condimentum ac id augue. Integer rhoncus pretium lacus eget maximus. Suspendisse consequat magna quis cursus pulvinar. Morbi nec ipsum leo. Sed eu tellus eu lacus finibus aliquet.',
					],
					[
						'testimonial_title' => __( 'John Doe', 'luxus-core' ),
						'testimonial_designation' => __( 'Customer', 'luxus-core' ),
						'testimonial_content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nec pharetra arcu. Aenean auctor eu ligula vitae cursus. Quisque eu massa quis ex eleifend condimentum ac id augue. Integer rhoncus pretium lacus eget maximus. Suspendisse consequat magna quis cursus pulvinar. Morbi nec ipsum leo. Sed eu tellus eu lacus finibus aliquet.',
					],
					[
						'testimonial_title' => __( 'Jane Doe', 'luxus-core' ),
						'testimonial_designation' => __( 'Customer', 'luxus-core' ),
						'testimonial_content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nec pharetra arcu. Aenean auctor eu ligula vitae cursus. Quisque eu massa quis ex eleifend condimentum ac id augue. Integer rhoncus pretium lacus eget maximus. Suspendisse consequat magna quis cursus pulvinar. Morbi nec ipsum leo. Sed eu tellus eu lacus finibus aliquet.',
					],
				],
				'title_field' => '{{{ testimonial_title }}}',
			]
		);

		$this->end_controls_section();

	}
	// Content Layout Options
	private function luxus_general_layout_options() {

		$this->start_controls_section(
			'section_layout_options',
			[
				'label' => __( 'Carousel Options', 'luxus-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'testimonial_style',
			[
				'label' => __( 'Testimonial Style', 'luxus-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Style 1', 'luxus-core' ),
					'2' => esc_html__( 'Style 2', 'luxus-core' ),
					'3' => esc_html__( 'Style 3', 'luxus-core' ),
				],
			]
		);

		$this->add_control(
			'slides_to_show',
			[
				'label' => __( 'Slides To Show', 'luxus-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '3', 'luxus-core' ),
				'placeholder' => __( 'Slides show on screen', 'luxus-core' ),
			]
		);

		$this->add_control(
			'slides_to_scroll',
			[
				'label' => __( 'Slides To Scroll', 'luxus-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '1', 'luxus-core' ),
				'placeholder' => __( 'Slides show on scroll', 'luxus-core' ),
			]
		);

		$this->add_control(
            'autoplay',
            [
                'label' => __( 'Autoplay', 'luxus-core' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'luxus-core' ),
                'label_off' => __( 'No', 'luxus-core' ),
                'return_value' => 'true',
                'default' => '',
            ]
        );

        $this->add_control(
			'autoplayspeed',
			[
				'label' => __( 'Autoplay Speed', 'luxus-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '3000', 'luxus-core' ),
				'placeholder' => __( 'in seconds (e.g: 3000)', 'luxus-core' ),
				'condition' => ['autoplay' => 'true' ],
			]
		);

		$this->add_control(
            'infinite',
            [
                'label' => __( 'Infinite Scroll', 'luxus-core' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'luxus-core' ),
                'label_off' => __( 'No', 'luxus-core' ),
                'return_value' => 'true',
                'default' => 'true',
            ]
        );

		$this->add_control(
            'swipe',
            [
                'label' => __( 'Enables touch swipe', 'luxus-core' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'luxus-core' ),
                'label_off' => __( 'No', 'luxus-core' ),
                'return_value' => 'true',
                'default' => 'true',
            ]
        );

		$this->add_control(
            'dots',
            [
                'label' => __( 'Dots', 'luxus-core' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'luxus-core' ),
                'label_off' => __( 'No', 'luxus-core' ),
                'return_value' => 'true',
                'default' => 'true',
            ]
        );

		$this->add_control(
            'arrows',
            [
                'label' => __( 'Arrows', 'luxus-core' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'luxus-core' ),
                'label_off' => __( 'No', 'luxus-core' ),
                'return_value' => 'true',
                'default' => 'true',
            ]
        );

		$this->add_control(
            'centermode',
            [
                'label' => __( 'Center Mode', 'luxus-core' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'luxus-core' ),
                'label_off' => __( 'No', 'luxus-core' ),
                'return_value' => 'true',
                'default' => '',
            ]
        );

        $this->add_control(
			'centerpadding',
			[
				'label' => __( 'Center Padding', 'luxus-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '60px', 'luxus-core' ),
				'placeholder' => __( 'in Px or % (e.g: 30px)', 'luxus-core' ),
				'condition' => ['centermode' => 'true' ],
			]
		);
		
		$this->add_control(
			'content_alignment',
			[
				'label' => __( 'Alignment', 'luxus-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'luxus-core' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'luxus-core' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'luxus-core' ),
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

	private function luxus_style_testimonial_carousel_options() {

		$this->start_controls_section(
			'section_carousel_style',
			[
				'label' => __( 'Carousel Style', 'luxus-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'arrows_possition',
			[
				'label' => __( 'Arrows Possition', 'luxus-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => -60,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => -40,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => -10,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .luxus-carousel .slick-prev' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .luxus-carousel .slick-next' => 'right: {{SIZE}}{{UNIT}};',
				],
				'condition' => ['arrows' => 'true'],
			]
		);

		$this->add_control(
			'arrows_width',
			[
				'label' => __( 'Arrows Width', 'luxus-core' ),
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
					'size' => 40,
				],
				'selectors' => [
					'{{WRAPPER}} .luxus-carousel .slick-prev' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .luxus-carousel .slick-next' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => ['arrows' => 'true'],
			]
		);

		$this->add_control(
			'arrows_height',
			[
				'label' => __( 'Arrows Height', 'luxus-core' ),
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
					'size' => 40,
				],
				'selectors' => [
					'{{WRAPPER}} .luxus-carousel .slick-prev' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .luxus-carousel .slick-next' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => ['arrows' => 'true'],
			]
		);

		$this->add_control(
			'arrows_radius',
			[
				'label' => __( 'Arrows Border Radius', 'luxus-core' ),
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
					'size' => 3,
				],
				'selectors' => [
					'{{WRAPPER}} .luxus-carousel .slick-prev' => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .luxus-carousel .slick-next' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'condition' => ['arrows' => 'true'],
			]
		);

		$this->add_control(
			'arrows_icon_size',
			[
				'label' => __( 'Arrows Icon Size', 'luxus-core' ),
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
					'size' => 18,
				],
				'selectors' => [
					'{{WRAPPER}} .luxus-carousel .slick-prev:before' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .luxus-carousel .slick-next:before' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => ['arrows' => 'true'],
			]
		);

		$this->add_control(
			'bullets_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Bullets Color', 'luxus-core' ),
				'default' => '#00BBFF',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .luxus-carousel .slick-dots li button:before, .luxus-carousel .slick-dots li button:hover, .slick-dots li button:focus, .luxus-carousel .slick-dots li.slick-active button' => 'background-color: {{VALUE}};',
				],
				'condition' => ['dots' => 'true'],
			]
		);

		$this->start_controls_tabs( 'testimonial_carousel_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'testimonial_carousel_normal_tab',
			[
				'label'     => __( 'Normal', 'luxus-core' ),
				'condition' => ['arrows' => 'true'],
			]
		);

		$this->add_control(
			'arrows_icon_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Arrows Icon Color', 'luxus-core' ),
				'default' => '#00BBFF',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .luxus-carousel .slick-prev:before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .luxus-carousel .slick-next:before' => 'color: {{VALUE}};',
				],
				'condition' => ['arrows' => 'true'],
			]
		);

		$this->add_control(
			'arrows_bg_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Arrows Background Color', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .luxus-carousel .slick-prev' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .luxus-carousel .slick-next' => 'background-color: {{VALUE}};',
				],
				'condition' => ['arrows' => 'true'],
			]
		);

		$this->add_control(
			'arrows_border_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Arrows Border Color', 'luxus-core' ),
				'default' => '#00BBFF',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .luxus-carousel .slick-prev' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .luxus-carousel .slick-next' => 'border-color: {{VALUE}};',
				],
				'condition' => ['arrows' => 'true'],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'testimonial_carousel_hover_tab',
			[
				'label'     => __( 'Hover', 'luxus-core' ),
				'condition' => ['arrows' => 'true'],
			]
		);

		$this->add_control(
			'arrows_icon_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Arrows Icon Color', 'luxus-core' ),
				'default' => '#00BBFF',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .luxus-carousel .slick-prev:hover:before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .luxus-carousel .slick-next:hover:before' => 'color: {{VALUE}};',
				],
				'condition' => ['arrows' => 'true'],
			]
		);

		$this->add_control(
			'arrows_bg_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Arrows Background Color', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .luxus-carousel .slick-prev:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .luxus-carousel .slick-next:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => ['arrows' => 'true'],
			]
		);

		$this->add_control(
			'arrows_border_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Arrows Border Color', 'luxus-core' ),
				'default' => '#00BBFF',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .luxus-carousel .slick-prev:hover' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .luxus-carousel .slick-next:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => ['arrows' => 'true'],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	private function luxus_style_testimonial_carousel_item_options() {

		$this->start_controls_section(
			'section_testimonial_item_style',
			[
				'label' => __( 'Testimonial Item Style', 'luxus-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'testimonial_item_margin',
			[
				'label' => __( 'Posts Padding', 'luxus-core' ),
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
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .luxus-carousel .slick-list' => 'margin: 0 -{{SIZE}}{{UNIT}}; padding: 0 0;',
					'{{WRAPPER}} .luxus-carousel .sl-item' => 'padding: 0 {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'testimonial_item_border',
			[
				'label'      => __( 'Border Sizei', 'luxus-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .luxus-carousel .review-item.review-one .content' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .luxus-carousel .review-item.review-two' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .luxus-carousel .review-item.review-three' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],				
			]
		);

		$this->add_control(
			'testimonial_item_border_radius',
			[
				'label'     => __( 'Border Radius', 'luxus-core' ),
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
					'{{WRAPPER}} .luxus-carousel .review-item.review-one .content' => 'border-radius: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .luxus-carousel .review-item.review-two' => 'border-radius: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .luxus-carousel .review-item.review-three' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'testimonial_item_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'testimonial_item_normal_tab',
			[
				'label'     => __( 'Normal', 'luxus-core' ),
			]
		);

		$this->add_control(
			'testimonial_item_bg_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .luxus-carousel .review-item.review-one .content' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .luxus-carousel .review-item.review-two' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .luxus-carousel .review-item.review-three' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'testimonial_item_border_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'luxus-core' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .luxus-carousel .review-item.review-one .content' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .luxus-carousel .review-item.review-two' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .luxus-carousel .review-item.review-three' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'testimonial_one_item_box_shadow_normal',
				'selector'  => '{{WRAPPER}} .luxus-carousel .review-item.review-one .content',
				'condition' => ['testimonial_style' => '1' ],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'testimonial_two_item_box_shadow_normal',
				'selector'  => '{{WRAPPER}} .luxus-carousel .review-item.review-two',
				'condition' => ['testimonial_style' => '2' ],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'testimonial_three_item_box_shadow_normal',
				'selector'  => '{{WRAPPER}} .luxus-carousel .review-item.review-three',
				'condition' => ['testimonial_style' => '3' ],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'testimonial_item_hover_tab',
			[
				'label'     => __( 'Hover', 'luxus-core' ),
			]
		);

		$this->add_control(
			'testimonial_item_bg_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'luxus-core' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .luxus-carousel .review-item.review-one:hover .content' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .luxus-carousel .review-item.review-two:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .luxus-carousel .review-item.review-three:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'testimonial_item_border_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'luxus-core' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .luxus-carousel .review-item.review-one:hover .content' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .luxus-carousel .review-item.review-two:hover' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .luxus-carousel .review-item.review-three:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'testimonial_one_item_box_shadow_hover',
				'selector'  => '{{WRAPPER}} .luxus-carousel .review-item.review-one:hover .content',
				'condition' => ['testimonial_style' => '1' ],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'testimonial_two_item_box_shadow_hover',
				'selector'  => '{{WRAPPER}} .luxus-carousel .review-item.review-two:hover',
				'condition' => ['testimonial_style' => '2' ],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'testimonial_three_item_box_shadow_hover',
				'selector'  => '{{WRAPPER}} .luxus-carousel .review-item.review-three:hover',
				'condition' => ['testimonial_style' => '3' ],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	private function luxus_style_testimonial_carousel_content_options() {

		$this->start_controls_section(
			'section_testimonial_content_style',
			[
				'label' => __( 'Testimonial Content Style', 'luxus-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'testimonial_content_padding',
			[
				'label'      => __( 'Content Padding', 'luxus-core' ),
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
					'{{WRAPPER}} .luxus-carousel .review-item.review-one .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .luxus-carousel .review-item.review-two' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .luxus-carousel .review-item.review-three' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'testimonial_title_typography',
				'label' => __( 'Title Typography', 'luxus-core' ),
				
				'fields_options'  => [
		            'typography'  => [ 'default' => 'yes' ],
		            'font_size'   => [ 'default' => [ 'size' => 20 ] ],
		            'font_weight' => [ 'default' => 600 ],
		            'line_height' => [ 'default' => [ 'size' => 24 ] ],
		        ],
				'selector' => '{{WRAPPER}} .luxus-carousel .review-item .name',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'testimonial_designation_typography',
				'label' => __( 'Designation Typography', 'luxus-core' ),
				
				'fields_options'  => [
		            'typography'  => [ 'default' => 'yes' ],
		            'font_size'   => [ 'default' => [ 'size' => 16 ] ],
		            'font_weight' => [ 'default' => 400 ],
		            'line_height' => [ 'default' => [ 'size' => 20 ] ],
		        ],
				'selector' => '{{WRAPPER}} .luxus-carousel .review-item .possition',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'testimonial_content_typography',
				'label' => __( 'Description Typography', 'luxus-core' ),
				
				'fields_options'  => [
		            'typography'  => [ 'default' => 'yes' ],
		            'font_size'   => [ 'default' => [ 'size' => 15 ] ],
		            'font_weight' => [ 'default' => 'normal' ],
		            'line_height' => [ 'default' => [ 'size' => 24 ] ],
		        ],
				'selector' => '{{WRAPPER}} .luxus-carousel .review-item .text',
			]
		);

		$this->start_controls_tabs( 'testimonial_content_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'testimonial_content_normal_tab',
			[
				'label'     => __( 'Normal', 'luxus-core' ),
			]
		);

		$this->add_control(
			'testimonial_title_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'luxus-core' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .luxus-carousel .review-item .name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'testimonial_designation_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Designation Color', 'luxus-core' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .luxus-carousel .review-item .possition' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'testimonial_text_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Description Color', 'luxus-core' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .luxus-carousel .review-item .text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'testimonial_quote_icon_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Quote Icon Color', 'luxus-core' ),
				'default' => '#00BBFF',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .luxus-carousel .review-item .sl-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'testimonial_content_hover_tab',
			[
				'label'     => __( 'Hover', 'luxus-core' ),
			]
		);

		$this->add_control(
			'testimonial_title_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'luxus-core' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .luxus-carousel .review-item:hover .name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'testimonial_designation_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Designation Color', 'luxus-core' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .luxus-carousel .review-item:hover .possition' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'testimonial_text_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Description Color', 'luxus-core' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .luxus-carousel .review-item:hover .text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'testimonial_quote_icon_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Quote Icon Color', 'luxus-core' ),
				'default' => '#00BBFF',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .luxus-carousel .review-item:hover .sl-icon' => 'color: {{VALUE}};',
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
		$testimonial_style = $settings['testimonial_style'];

		// Slick Data Attributes
		$dots = ( $settings['dots'] == 'true' ? 'true' : 'false' );
		$arrows = ( $settings['arrows'] == 'true' ? 'true' : 'false' );
		$infinite = ( $settings['infinite'] == 'true' ? 'true' : 'false' );
		$autoplay = ( $settings['autoplay'] == 'true' ? 'true' : 'false' );
		$autoplayspeed = ( $settings['autoplay'] == 'true' && !empty( $settings['autoplayspeed'] ) ? $settings['autoplayspeed'] : '10000000' );
		$swipe = ( $settings['swipe'] == 'true' ? 'true' : 'false' );
		$centermode = ( $settings['centermode'] == 'true' ? 'true' : 'false' );
		$centerpadding = ( $settings['centermode'] == 'true' && !empty( $settings['centerpadding'] ) ? $settings['centerpadding'] : '50px' );

		$this->add_render_attribute(
            'testimonial_carousel_attr',
            [
                'id'          => 'sl-testimonial-carousel-' . $this->get_id(),
                'data-slick'   => ['{',
						'"dots":' . $dots . ',',
						'"arrows":' . $arrows . ',',
						'"infinite":' . $infinite . ',',
						'"autoplay":' . $autoplay . ',',
						'"autoplaySpeed":' . $autoplayspeed . ',',
						'"centerMode":' . $centermode . ',',
						'"swipe":' . $swipe,
					'}'],
                'data-stshow'   => $settings[ 'slides_to_show' ],
                'data-stscroll'   => $settings[ 'slides_to_scroll' ],
                'data-cpadding'   => $centerpadding,
            ]
        );

        ?>
		<div class="sl-testimonial-carousel-container">
			<div class="luxus-carousel" <?php echo $this->get_render_attribute_string( 'testimonial_carousel_attr' ); ?>>

			<?php

            	if( 3 == $testimonial_style ){

	        		include( __DIR__ . '/layouts/testimonial-carousel/layout-3.php' );

	        	}elseif( 2 == $testimonial_style ){

					include( __DIR__ . '/layouts/testimonial-carousel/layout-2.php' );

	        	}else{

	        		include( __DIR__ . '/layouts/testimonial-carousel/layout-1.php' );

	        	}

            ?>

			</div>
		</div>
    	<?php
	}
}
