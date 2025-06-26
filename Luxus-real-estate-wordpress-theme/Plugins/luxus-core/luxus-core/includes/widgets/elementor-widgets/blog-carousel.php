<?php
namespace SLElementorWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Luxus_Blog_Carousel extends Widget_Base {

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
		return 'luxus-blog-caousel';
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
		return __( 'Blog Carousel', 'luxus-core' );
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
		return 'sl-widget-icon blog-carousel';
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
	private function luxus_post_categories( $post_type ) {
		
		$options = array();

		$taxonomy = 'category';

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
		$this->luxus_blog_query_options();
		$this->luxus_style_blog_carousel_options();
		$this->luxus_style_blog_carousel_item_options();
		$this->luxus_style_blog_carousel_content_options();
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
			'blog_style',
			[
				'label' => __( 'Blog Style', 'luxus-core' ),
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

	// Content Query Options
	private function luxus_blog_query_options() {

		$this->start_controls_section(
			'section_blog_query',
			[
				'label' => __( 'Query Options', 'luxus-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'post_categories',
			[
				'label'       => __( 'Categories', 'luxus-core' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => $this->luxus_post_categories( 'post' ),
				
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

		$this->add_control(
			'excerpt_length',
			[
				'label' => __( 'Excerpt Length', 'luxus-core' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 14,
			]
		);

		$this->add_control(
			'read_more_text',
			[
				'label' => __( 'Read More Text', 'luxus-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Read More', 'luxus-core' ),
			]
		);

		$this->end_controls_section();
		
	}

	private function luxus_style_blog_carousel_options() {

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
					'{{WRAPPER}} .sl-blog-carousel .slick-prev' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .sl-blog-carousel .slick-next' => 'right: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .sl-blog-carousel .slick-prev' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .sl-blog-carousel .slick-next' => 'width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .sl-blog-carousel .slick-prev' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .sl-blog-carousel .slick-next' => 'height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .sl-blog-carousel .slick-prev' => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .sl-blog-carousel .slick-next' => 'border-radius: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .sl-blog-carousel .slick-prev:before' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .sl-blog-carousel .slick-next:before' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .sl-blog-carousel .slick-dots li button:before, .sl-blog-carousel .slick-dots li button:hover, .slick-dots li button:focus, .sl-blog-carousel .slick-dots li.slick-active button' => 'background-color: {{VALUE}};',
				],
				'condition' => ['dots' => 'true'],
			]
		);


		$this->start_controls_tabs( 'blog_carousel_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'blog_carousel_normal_tab',
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
					'{{WRAPPER}} .sl-blog-carousel .slick-prev:before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-blog-carousel .slick-next:before' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .sl-blog-carousel .slick-prev' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .sl-blog-carousel .slick-next' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .sl-blog-carousel .slick-prev' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .sl-blog-carousel .slick-next' => 'border-color: {{VALUE}};',
				],
				'condition' => ['arrows' => 'true'],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'blog_carousel_hover_tab',
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
					'{{WRAPPER}} .sl-blog-carousel .slick-prev:hover:before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-blog-carousel .slick-next:hover:before' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .sl-blog-carousel .slick-prev:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .sl-blog-carousel .slick-next:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .sl-blog-carousel .slick-prev:hover' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .sl-blog-carousel .slick-next:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => ['arrows' => 'true'],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	private function luxus_style_blog_carousel_item_options() {

		$this->start_controls_section(
			'section_blog_item_style',
			[
				'label' => __( 'Blog Item Style', 'luxus-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'blog_item_margin',
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
					'{{WRAPPER}} .sl-blog-carousel .slick-list' => 'margin: 0 -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .sl-blog-carousel .sl-item' => 'padding: 0 {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'blog_item_border',
			[
				'label'      => __( 'Border Size', 'luxus-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .sl-blog-carousel .blog-item' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],				
			]
		);

		$this->add_control(
			'blog_item_border_radius',
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
					'{{WRAPPER}} .sl-blog-carousel .blog-item' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'blog_item_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'blog_item_normal_tab',
			[
				'label'     => __( 'Normal', 'luxus-core' ),
			]
		);

		$this->add_control(
			'blog_item_bg_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-blog-carousel .blog-item.blog-one' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .sl-blog-carousel .blog-item.blog-two' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .sl-blog-carousel .blog-item.blog-two .meta' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'blog_item_border_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'luxus-core' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .sl-blog-carousel .blog-item' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'blog_item_box_shadow_normal',
				'selector'  => '{{WRAPPER}} .sl-blog-carousel .blog-item',
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'blog_item_hover_tab',
			[
				'label'     => __( 'Hover', 'luxus-core' ),
			]
		);

		$this->add_control(
			'blog_item_bg_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'luxus-core' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .sl-blog-carousel .blog-item.blog-one:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .sl-blog-carousel .blog-item.blog-two:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .sl-blog-carousel .blog-item.blog-two:hover .meta' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'blog_item_border_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'luxus-core' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .sl-blog-carousel .blog-item:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'blog_item_box_shadow_hover',
				'selector'  => '{{WRAPPER}} .sl-blog-carousel .blog-item:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	private function luxus_style_blog_carousel_content_options() {

		$this->start_controls_section(
			'section_blog_content_style',
			[
				'label' => __( 'Blog Content Style', 'luxus-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'blog_content_padding',
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
					'{{WRAPPER}} .sl-blog-carousel .blog-item .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'conditions' => [
				    'relation' => 'or',
				    'terms' => [
				        [
				            'name' => 'blog_style',
				            'operator' => '==',
				            'value' => '1'
				        ],
				        [
				            'name' => 'blog_style',
				            'operator' => '==',
				            'value' => '2'
				        ]
				    ]
				]
			]
		);

		$this->add_control(
			'blog_two_meta_padding',
			[
				'label'      => __( 'Bottom Bar Padding', 'luxus-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => '10',
					'right' => '20',
					'bottom' => '10',
					'left' => '20',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .sl-blog-carousel .blog-item.blog-two .meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'condition' => ['blog_style' => '2'],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'blog_title_typography',
				'label' => __( 'Title Typography', 'luxus-core' ),
				
				'fields_options'  => [
		            'typography'  => [ 'default' => 'yes' ],
		            'font_size'   => [ 'default' => [ 'size' => 20 ] ],
		            'font_weight' => [ 'default' => 600 ],
		            'line_height' => [ 'default' => [ 'size' => 24 ] ],
		        ],
				'selector' => '{{WRAPPER}} .sl-blog-carousel .blog-item .title',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'blog_content_typography',
				'label' => __( 'Description Typography', 'luxus-core' ),
				
				'fields_options'  => [
		            'typography'  => [ 'default' => 'yes' ],
		            'font_size'   => [ 'default' => [ 'size' => 15 ] ],
		            'font_weight' => [ 'default' => 'normal' ],
		            'line_height' => [ 'default' => [ 'size' => 24 ] ],
		        ],
				'selector' => '{{WRAPPER}} .sl-blog-carousel .blog-item .excerpt',
				'conditions' => [
				    'relation' => 'or',
				    'terms' => [
				        [
				            'name' => 'blog_style',
				            'operator' => '==',
				            'value' => '1'
				        ],
				        [
				            'name' => 'blog_style',
				            'operator' => '==',
				            'value' => '2'
				        ]
				    ]
				]
			]
		);

		$this->start_controls_tabs( 'blog_content_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'blog_content_normal_tab',
			[
				'label'     => __( 'Normal', 'luxus-core' ),
			]
		);

		$this->add_control(
			'blog_title_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'luxus-core' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-blog-carousel .blog-item .title' => 'color: {{VALUE}};',
				],
				'conditions' => [
				    'relation' => 'or',
				    'terms' => [
				        [
				            'name' => 'blog_style',
				            'operator' => '==',
				            'value' => '1'
				        ],
				        [
				            'name' => 'blog_style',
				            'operator' => '==',
				            'value' => '2'
				        ]
				    ]
				]
			]
		);

		$this->add_control(
			'blog_three_title_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-blog-carousel .blog-item.blog-three .content .title' => 'color: {{VALUE}};',
				],
				'condition' => ['blog_style' => '3'],
			]
		);

		$this->add_control(
			'blog_text_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Description Color', 'luxus-core' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-blog-carousel .blog-item .excerpt' => 'color: {{VALUE}};',
				],
				'conditions' => [
				    'relation' => 'or',
				    'terms' => [
				        [
				            'name' => 'blog_style',
				            'operator' => '==',
				            'value' => '1'
				        ],
				        [
				            'name' => 'blog_style',
				            'operator' => '==',
				            'value' => '2'
				        ]
				    ]
				]
			]
		);

		$this->add_control(
			'blog_link_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Link Color', 'luxus-core' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-blog-carousel .blog-item .more' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-blog-carousel .blog-item.blog-two .meta .date a' => 'color: {{VALUE}};',
				],
				'conditions' => [
				    'relation' => 'or',
				    'terms' => [
				        [
				            'name' => 'blog_style',
				            'operator' => '==',
				            'value' => '1'
				        ],
				        [
				            'name' => 'blog_style',
				            'operator' => '==',
				            'value' => '2'
				        ]
				    ]
				]
			]
		);
	
		$this->add_control(
			'blog_cat_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Catagory Color', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-blog-carousel .blog-item.blog-one .tags a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-blog-carousel .blog-item.blog-two .tags a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-blog-carousel .blog-item.blog-three .tags a' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'blog_cat_bg_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Catagory Background', 'luxus-core' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-blog-carousel .blog-item.blog-one .tags a' => 'background: {{VALUE}};',
					'{{WRAPPER}} .sl-blog-carousel .blog-item.blog-two .tags a' => 'background: {{VALUE}};',
					'{{WRAPPER}} .sl-blog-carousel .blog-item.blog-three .tags a' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'blog_content_hover_tab',
			[
				'label'     => __( 'Hover', 'luxus-core' ),
			]
		);

		$this->add_control(
			'blog_title_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'luxus-core' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-blog-carousel .blog-item:hover .title' => 'color: {{VALUE}};',
				],
				'conditions' => [
				    'relation' => 'or',
				    'terms' => [
				        [
				            'name' => 'blog_style',
				            'operator' => '==',
				            'value' => '1'
				        ],
				        [
				            'name' => 'blog_style',
				            'operator' => '==',
				            'value' => '2'
				        ]
				    ]
				]
			]
		);
		
		$this->add_control(
			'blog_three_title_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-blog-carousel .blog-item.blog-three:hover .content .title' => 'color: {{VALUE}};',
				],
				'condition' => ['blog_style' => '3'],
			]
		);

		$this->add_control(
			'blog_text_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Description Color', 'luxus-core' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-blog-carousel .blog-item:hover .excerpt' => 'color: {{VALUE}};',
				],
				'conditions' => [
				    'relation' => 'or',
				    'terms' => [
				        [
				            'name' => 'blog_style',
				            'operator' => '==',
				            'value' => '1'
				        ],
				        [
				            'name' => 'blog_style',
				            'operator' => '==',
				            'value' => '2'
				        ]
				    ]
				]
			]
		);

		$this->add_control(
			'blog_link_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Link Color', 'luxus-core' ),
				'default' => '#00BBFF',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-blog-carousel .blog-item:hover .more' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-blog-carousel .blog-item.blog-two:hover .meta .date a' => 'color: {{VALUE}};',
				],
				'conditions' => [
				    'relation' => 'or',
				    'terms' => [
				        [
				            'name' => 'blog_style',
				            'operator' => '==',
				            'value' => '1'
				        ],
				        [
				            'name' => 'blog_style',
				            'operator' => '==',
				            'value' => '2'
				        ]
				    ]
				]
			]
		);
		
		$this->add_control(
			'blog_cat_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Catagory Color', 'luxus-core' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-blog-carousel .blog-item.blog-one:hover .tags a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-blog-carousel .blog-item.blog-two:hover .tags a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-blog-carousel .blog-item.blog-three:hover .tags a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'blog_cat_bg_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Catagory Background', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-blog-carousel .blog-item.blog-one:hover .tags a' => 'background: {{VALUE}};',
					'{{WRAPPER}} .sl-blog-carousel .blog-item.blog-two:hover .tags a' => 'background: {{VALUE}};',
					'{{WRAPPER}} .sl-blog-carousel .blog-item.blog-three:hover .tags a' => 'background: {{VALUE}};',
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
		$blog_style = $settings['blog_style'];
		$posts_per_page = ( ! empty( $settings['posts_per_page'] ) ?  $settings['posts_per_page'] : 6 );
		$excerpt_length = ( ! empty( $settings['excerpt_length'] ) ?  $settings['excerpt_length'] : 14 );
		$read_more_text = $settings['read_more_text'];

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
            'blog_carousel_attr',
            [
                'id'          => 'sl-blog-carousel-' . $this->get_id(),
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
		<div class="sl-blog-carousel">
			<div class="luxus-carousel" <?php echo $this->get_render_attribute_string( 'blog_carousel_attr' ); ?>>

			<?php
		
			$post_categories = is_array( $settings['post_categories'] ) ? implode( ',', $settings['post_categories'] ) : $settings['post_categories'];

        	$query_args = array(
	        	'posts_per_page' 		=> absint( $posts_per_page ),
	        	'no_found_rows'  		=> true,
	        	'post__not_in'          => get_option( 'sticky_posts' ),
	        	'ignore_sticky_posts'   => true,
	        	'category_name' 		=> $post_categories
        	);

	        if ( ! empty( $settings['orderby'] ) ) {
	        	$query_args['orderby'] = $settings['orderby'];
	        }

	        if ( ! empty( $settings['order'] ) ) {
	        	$query_args['order'] = $settings['order'];
	        }

			$luxus_blog_carousel = new \WP_Query( $query_args );

            if ($luxus_blog_carousel->have_posts()) :

            	while ( $luxus_blog_carousel->have_posts() ) :

			    $luxus_blog_carousel->the_post();

            	if( 3 == $blog_style ){

            		include( __DIR__ . '/layouts/blog-carousel/layout-3.php' );

	        	}elseif( 2 == $blog_style ){

	        		include( __DIR__ . '/layouts/blog-carousel/layout-2.php' );

	        	}else{

	        		include( __DIR__ . '/layouts/blog-carousel/layout-1.php' );

	        	}

				endwhile;
            
            endif;

            wp_reset_postdata();

            ?>

			</div>

		</div>
    	<?php
	}
}
