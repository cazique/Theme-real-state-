<?php
namespace SLElementorWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Luxus_Property_Carousel_Featured extends Widget_Base {

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
		return 'luxus-property-caousel-featured';
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
		return __( 'Featured Property Carousel', 'luxus-core' );
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
		return 'sl-widget-icon property-carousel';
		// return 'fa fa-pencil';
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

	// Get Post Categories
	private function luxus_custom_taxonomy( $custom_taxonomy ) {
		
		$options = array();

		$taxonomy = $custom_taxonomy;

		if ( ! empty( $taxonomy ) ) {

			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => false,
				)
			);
			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( isset( $term ) ) {
						if ( isset( $term->slug ) && isset( $term->name ) ) {
							$options[ $term->slug ] = $term->name;
						}
					}
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
		$this->luxus_property_query_options();
		$this->luxus_style_property_carousel_options();
		$this->luxus_style_property_carousel_item_options();
	}

	// Content Layout Options
	private function luxus_genetal_layout_options() {

		$this->start_controls_section(
			'section_layout_options',
			[
				'label' => __( 'Carousel Options', 'luxus-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'slides_to_show_xl',
			[
				'label' => __( 'Posts To Show XL', 'luxus-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '3', 'luxus-core' ),
				'placeholder' => __( 'Posts show on screen', 'luxus-core' ),
			]
		);
		$this->add_control(
			'slides_to_show_lg',
			[
				'label' => __( 'Posts To Show LG', 'luxus-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '3', 'luxus-core' ),
				'placeholder' => __( 'Posts show on screen', 'luxus-core' ),
			]
		);
		$this->add_control(
			'slides_to_show',
			[
				'label' => __( 'Posts To Show', 'luxus-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '3', 'luxus-core' ),
				'placeholder' => __( 'Posts show on screen', 'luxus-core' ),
			]
		);

		$this->add_control(
			'slides_to_scroll',
			[
				'label' => __( 'Posts To Scroll', 'luxus-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '1', 'luxus-core' ),
				'placeholder' => __( 'Posts show on scroll', 'luxus-core' ),
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
			'centerpaddinglg',
			[
				'label' => __( 'Center Padding Desktop', 'luxus-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '60px', 'luxus-core' ),
				'placeholder' => __( 'in Px or % (e.g: 60px)', 'luxus-core' ),
				'condition' => ['centermode' => 'true' ],
			]
		);
        $this->add_control(
			'centerpaddingmd',
			[
				'label' => __( 'Center Padding Tablet', 'luxus-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '30px', 'luxus-core' ),
				'placeholder' => __( 'in Px or % (e.g: 30px)', 'luxus-core' ),
				'condition' => ['centermode' => 'true' ],
			]
		);
        $this->add_control(
			'centerpaddingsm',
			[
				'label' => __( 'Center Padding Mobile', 'luxus-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '15px', 'luxus-core' ),
				'placeholder' => __( 'in Px or % (e.g: 15px)', 'luxus-core' ),
				'condition' => ['centermode' => 'true' ],
			]
		);

		$this->end_controls_section();

	}

	// Content Query Options
	private function luxus_property_query_options() {

		$this->start_controls_section(
			'section_property_query',
			[
				'label' => __( 'Query Options', 'luxus-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => __( 'Posts Per Page', 'luxus-core' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 9,
			]
		);

		$this->add_control(
			'property_type',
			[
				'label'       => __( 'Property Type', 'luxus-core' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => $this->luxus_custom_taxonomy( 'property_type' ),
			]
		);

		$this->add_control(
			'property_status',
			[
				'label'       => __( 'Property Status', 'luxus-core' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => $this->luxus_custom_taxonomy( 'property_status' ),
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order By', 'luxus-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'post_date',
				'options' => [
					'post_date' => __( 'Date', 'luxus-core' ),
					'post_title' => __( 'Title', 'luxus-core' ),
					'rand' => __( 'Random', 'luxus-core' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __( 'Order', 'luxus-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc' => __( 'ASC', 'luxus-core' ),
					'desc' => __( 'DESC', 'luxus-core' ),
				],
			]
		);

		$this->end_controls_section();
		
	}

	private function luxus_style_property_carousel_options() {

		$this->start_controls_section(
			'section_carousel_style',
			[
				'label' => __( 'Carousel Style', 'luxus-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'slide_margin',
			[
				'label' => __( 'Slide Padding', 'luxus-core' ),
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
					'{{WRAPPER}} .sl-property-carousel .slick-list' => 'margin: 0 -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .sl-property-carousel .sl-item' => 'padding: 0 {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'slide_border',
			[
				'label'      => __( 'Slide Border Size', 'luxus-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .sl-property-carousel .featured-property' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],				
			]
		);

		$this->add_control(
			'slide_border_radius',
			[
				'label'     => __( 'Slide Border Radius', 'luxus-core' ),
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
					'{{WRAPPER}} .sl-property-carousel .featured-property' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'carousel_slide_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'carousel_slide_normal_tab',
			[
				'label'     => __( 'Normal', 'luxus-core' ),
				'condition' => ['arrows' => 'true'],
			]
		);

		$this->add_control(
			'slide_border_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'luxus-core' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .sl-property-carousel .featured-property' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'slide_box_shadow_normal',
				'selector'  => '{{WRAPPER}} .sl-property-carousel .featured-property',
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'carousel_slide_hover_tab',
			[
				'label'     => __( 'Hover', 'luxus-core' ),
				'condition' => ['arrows' => 'true'],
			]
		);

		$this->add_control(
			'slide_border_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'luxus-core' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .sl-property-carousel .featured-property:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'slide_box_shadow_hover',
				'selector'  => '{{WRAPPER}} .sl-property-carousel .featured-property:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

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
					'{{WRAPPER}} .sl-property-carousel .slick-prev' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .sl-property-carousel .slick-next' => 'right: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .sl-property-carousel .slick-prev' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .sl-property-carousel .slick-next' => 'width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .sl-property-carousel .slick-prev' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .sl-property-carousel .slick-next' => 'height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .sl-property-carousel .slick-prev' => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .sl-property-carousel .slick-next' => 'border-radius: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .sl-property-carousel .slick-prev:before' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .sl-property-carousel .slick-next:before' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .sl-property-carousel .slick-dots li button:before, .sl-property-carousel .slick-dots li button:hover, .slick-dots li button:focus, .sl-property-carousel .slick-dots li.slick-active button' => 'background-color: {{VALUE}};',
				],
				'condition' => ['dots' => 'true'],
			]
		);

		$this->start_controls_tabs( 'carousel_arrows_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'carousel_arrows_normal_tab',
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
					'{{WRAPPER}} .sl-property-carousel .slick-prev:before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-property-carousel .slick-next:before' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .sl-property-carousel .slick-prev' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .sl-property-carousel .slick-next' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .sl-property-carousel .slick-prev' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .sl-property-carousel .slick-next' => 'border-color: {{VALUE}};',
				],
				'condition' => ['arrows' => 'true'],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'carousel_arrows_hover_tab',
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
					'{{WRAPPER}} .sl-property-carousel .slick-prev:hover:before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-property-carousel .slick-next:hover:before' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .sl-property-carousel .slick-prev:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .sl-property-carousel .slick-next:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .sl-property-carousel .slick-prev:hover' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .sl-property-carousel .slick-next:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => ['arrows' => 'true'],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	private function luxus_style_property_carousel_item_options() {

		$this->start_controls_section(
			'section_property_item',
			[
				'label' => __( 'Property Item', 'luxus-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'property_height',
			[
				'label'     => __( 'Property Height', 'luxus-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 285,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 285,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 245,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 245,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .sl-property-carousel .featured-property' => 'min-height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'property_border',
			[
				'label'      => __( 'Border Size', 'luxus-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .sl-property-carousel .featured-property' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],				
			]
		);

		$this->add_control(
			'property_border_radius',
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
					'{{WRAPPER}} .sl-property-carousel .featured-property' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'featured_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Featured Ribbon Background', 'luxus-core' ),
				'default' => '#00BBFF',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-property-carousel .featured-property .featured-ribbon span' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'address_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Address Color', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-property-carousel .featured-property .bottom .address' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'area_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Area Color', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-property-carousel .featured-property .bottom .area' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'features_icon_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Features Icon Color', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-property-carousel .featured-property .bottom .features span .sl-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title Typography', 'luxus-core' ),
				
				'fields_options'  => [
		            'typography'  => [ 'default' => 'yes' ],
		            'font_size'   => [ 'default' => [ 'size' => 18 ] ],
		            'font_weight' => [ 'default' => 600 ],
		            'line_height' => [ 'default' => [ 'size' => 22 ] ],
		        ],
				'selector' => '{{WRAPPER}} .sl-property-carousel .featured-property .title',
			]
		);

		$this->start_controls_tabs( 'property_item_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'property_item_normal_tab',
			[
				'label'     => __( 'Normal', 'luxus-core' ),
			]
		);

		$this->add_control(
			'property_bg_size_normal',
			[
				'label'     => __( 'Background Size', 'luxus-core' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 110,
				],
				'selectors' => [
					'{{WRAPPER}} .sl-property-carousel .featured-property' => 'background-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'bookmark_compare_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Bookmark / Compare Icon Color', 'luxus-core' ),
				'default' => '#00BBFF',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-property-carousel .featured-property .right .sl-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'bookmark_compare_bg_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Bookmark / Compare Background', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-property-carousel .featured-property .right a' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-property-carousel .featured-property .title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'property_item_hover_tab',
			[
				'label'     => __( 'Hover', 'luxus-core' ),
			]
		);

		$this->add_control(
			'property_bg_size_hover',
			[
				'label'     => __( 'Background Size', 'luxus-core' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 130,
				],
				'selectors' => [
					'{{WRAPPER}} .sl-property-carousel .featured-property:hover' => 'background-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'bookmark_compare_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Bookmark / Compare Icon Color', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-property-carousel .featured-property .right a:hover .sl-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'bookmark_compare_bg_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Bookmark / Compare Background', 'luxus-core' ),
				'default' => '#00BBFF',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-property-carousel .featured-property .right a:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-property-carousel .featured-property .title:hover' => 'color: {{VALUE}};',
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
		$posts_per_page = ( ! empty( $settings['posts_per_page'] ) ?  $settings['posts_per_page'] : 6 );

		// Slick Data Attributes
		$dots = ( $settings['dots'] == 'true' ? 'true' : 'false' );
		$arrows = ( $settings['arrows'] == 'true' ? 'true' : 'false' );
		$infinite = ( $settings['infinite'] == 'true' ? 'true' : 'false' );
		$autoplay = ( $settings['autoplay'] == 'true' ? 'true' : 'false' );
		$autoplayspeed = ( $settings['autoplay'] == 'true' && !empty( $settings['autoplayspeed'] ) ? $settings['autoplayspeed'] : '10000000' );
		$swipe = ( $settings['swipe'] == 'true' ? 'true' : 'false' );
		$centermode = ( $settings['centermode'] == 'true' ? 'true' : 'false' );
		$centerpaddinglg = ( $settings['centermode'] == 'true' && !empty( $settings['centerpaddinglg'] ) ? $settings['centerpaddinglg'] : '50px' );
		$centerpaddingmd = ( $settings['centermode'] == 'true' && !empty( $settings['centerpaddingmd'] ) ? $settings['centerpaddingmd'] : '30px' );
		$centerpaddingsm = ( $settings['centermode'] == 'true' && !empty( $settings['centerpaddingsm'] ) ? $settings['centerpaddingsm'] : '15px' );

		$this->add_render_attribute(
            'property_carousel_attr',
            [
                'id'          => 'sl-property-carousel-' . $this->get_id(),
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
                'data-stshowlg'   => $settings[ 'slides_to_show_lg' ],
                'data-stshowxl'   => $settings[ 'slides_to_show_xl' ],
                'data-stscroll'   => $settings[ 'slides_to_scroll' ],
                'data-cpaddinglg'   => $centerpaddinglg,
                'data-cpaddingmd'   => $centerpaddingmd,
                'data-cpaddingsm'   => $centerpaddingsm,
            ]
        );

        ?>
		<div class="sl-property-carousel">
			<div class="luxus-carousel" <?php echo $this->get_render_attribute_string( 'property_carousel_attr' ); ?>>

			<?php
		
			$tax_query = array();

			// Property Type
			if( !empty( $settings['property_type'] ) ) {
			    $tax_query [] = array(
					'taxonomy' => 'property_type',
		            'field'    => 'slug',
		            'terms'    => $settings['property_type'],
		            'operator' => 'IN',
			    );
			}
			// Property Status
			if( !empty( $settings['property_status'] ) ) {
			    $tax_query [] = array(
					'taxonomy' => 'property_status',
		            'field'    => 'slug',
		            'terms'    => $settings['property_status'],
		            'operator' => 'IN',
			    );
			}

        	$query_args = array(
	        	'post_type' 			=> 'property',
	        	'posts_per_page' 		=> absint( $posts_per_page ),
	        	'no_found_rows'  		=> true,
	        	'post__not_in'          => get_option( 'sticky_posts' ),
	        	'ignore_sticky_posts'   => true,
	        	'tax_query' 			=> $tax_query,
	        	'meta_key' 				=> '_property_label',
                'meta_value' 			=> '1'
        	);

	        if ( ! empty( $settings['orderby'] ) ) {
	        	$query_args['orderby'] = $settings['orderby'];
	        }

	        if ( ! empty( $settings['order'] ) ) {
	        	$query_args['order'] = $settings['order'];
	        }

			$luxus_property_carousel_featured = new \WP_Query( $query_args );

            if ($luxus_property_carousel_featured->have_posts()) :

            	while ( $luxus_property_carousel_featured->have_posts() ) :

			    $luxus_property_carousel_featured->the_post();

					include( __DIR__ . '/layouts/property-carousel-featured/layout-1.php' );

				endwhile;
            
            endif;

            wp_reset_postdata();

            ?>

			</div>

		</div>
    	<?php
	}
}
