<?php
namespace SLElementorWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Luxus_Blog_Grid extends Widget_Base {

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
		return 'luxus-blog-grid';
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
		return __( 'Blog Grid', 'luxus' );
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
		return 'sl-theme-widget-icon blog-grid';
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

		$this->luxus_content_layout_options();
		$this->luxus_content_query_options();
		$this->luxus_style_layout_options();
		$this->luxus_style_blog_item_options();
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
			'blog_style',
			[
				'label' => __( 'Blog Style', 'luxus' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Style 1', 'luxus' ),
					'2' => esc_html__( 'Style 2', 'luxus' ),
					'3' => esc_html__( 'Style 3', 'luxus' ),
					'4' => esc_html__( 'Style 4', 'luxus' ),
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => __( 'Columns', 'luxus' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
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
				'label' => __( 'Posts Per Page', 'luxus' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 3,
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label' => __( 'Excerpt Length', 'luxus' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 14,
			]
		);

		$this->add_control(
			'read_more_text',
			[
				'label' => __( 'Read More Text', 'luxus' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Read More', 'luxus' ),
			]
		);

		$this->end_controls_section();

	}

	// Content Query Options
	private function luxus_content_query_options() {

		$this->start_controls_section(
			'section_query_options',
			[
				'label' => __( 'Query', 'luxus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'post_categories',
			[
				'label'       => __( 'Categories', 'luxus' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => $this->luxus_post_categories( 'post' ),
				
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order By', 'luxus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'post_date',
				'options' => [
					'post_date' => __( 'Date', 'luxus' ),
					'post_title' => __( 'Title', 'luxus' ),
					'rand' => __( 'Random', 'luxus' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __( 'Order', 'luxus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc' => __( 'ASC', 'luxus' ),
					'desc' => __( 'DESC', 'luxus' ),
				],
			]
		);

		$this->end_controls_section();
		
	}

	// Style Layout Options
	private function luxus_style_layout_options() {

		$this->start_controls_section(
			'section_layout_style',
			[
				'label' => __( 'Layout', 'luxus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'grid_columns_margin',
			[
				'label'     => __( 'Columns margin', 'luxus' ),
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
				'label'     => __( 'Rows margin', 'luxus' ),
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

	private function luxus_style_blog_item_options() {

		$this->start_controls_section(
			'section_blog_item',
			[
				'label' => __( 'Blog Item', 'luxus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'blog_border',
			[
				'label'      => __( 'Border Size', 'luxus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .sl-grid-container .blog-item' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .sl-grid-container .blog-four .blog-grid-content' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],				
			]
		);

		$this->add_control(
			'blog_border_radius',
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
					'{{WRAPPER}} .sl-grid-container .blog-item' => 'border-radius: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .sl-grid-container .blog-four .blog-grid-content' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'blog_content_padding',
			[
				'label'      => __( 'Content Padding', 'luxus' ),
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
					'{{WRAPPER}} .sl-grid-container .blog-item .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .sl-grid-container .blog-four .blog-grid-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
				'label'      => __( 'Bottom Bar Padding', 'luxus' ),
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
					'{{WRAPPER}} .sl-grid-container .blog-item.blog-two .meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'condition' => ['blog_style' => '2'],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'blog_title_typography',
				'label' => __( 'Title Typography', 'luxus' ),
				
				'fields_options'  => [
		            'typography'  => [ 'default' => 'yes' ],
		            'font_size'   => [ 'default' => [ 'size' => 20 ] ],
		            'font_weight' => [ 'default' => 600 ],
		            'line_height' => [ 'default' => [ 'size' => 24 ] ],
		        ],
				'selector' => '{{WRAPPER}} .sl-grid-container .blog-item .title',
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
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'blog_four_title_typography',
				'label' => __( 'Title Typography', 'luxus' ),
				
				'fields_options'  => [
		            'typography'  => [ 'default' => 'yes' ],
		            'font_size'   => [ 'default' => [ 'size' => 20 ] ],
		            'font_weight' => [ 'default' => 600 ],
		            'line_height' => [ 'default' => [ 'size' => 24 ] ],
		        ],
				'selector' => '{{WRAPPER}} .blog-four .blog-grid-content .title',
				'condition' => ['blog_style' => '4'],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'blog_content_typography',
				'label' => __( 'Description Typography', 'luxus' ),
				
				'fields_options'  => [
		            'typography'  => [ 'default' => 'yes' ],
		            'font_size'   => [ 'default' => [ 'size' => 15 ] ],
		            'font_weight' => [ 'default' => 'normal' ],
		            'line_height' => [ 'default' => [ 'size' => 24 ] ],
		        ],
				'selector' => '{{WRAPPER}} .sl-grid-container .blog-item .excerpt',
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
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'blog_four_content_typography',
				'label' => __( 'Description Typography', 'luxus' ),
				
				'fields_options'  => [
		            'typography'  => [ 'default' => 'yes' ],
		            'font_size'   => [ 'default' => [ 'size' => 15 ] ],
		            'font_weight' => [ 'default' => 'normal' ],
		            'line_height' => [ 'default' => [ 'size' => 24 ] ],
		        ],
				'selector' => '{{WRAPPER}} .blog-four .blog-grid-content .discription',
				'condition' => ['blog_style' => '4'],
			]
		);

		$this->start_controls_tabs( 'blog_item_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'blog_item_normal_tab',
			[
				'label'     => __( 'Normal', 'luxus' ),
			]
		);

		$this->add_control(
			'blog_title_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'luxus' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .blog-item .title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .blog-four .title' => 'color: {{VALUE}};',
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
				        ],
						[
				            'name' => 'blog_style',
				            'operator' => '==',
				            'value' => '4'
				        ]
				    ]
				]
			]
		);

		$this->add_control(
			'blog_three_title_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'luxus' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .blog-item.blog-three .content .title' => 'color: {{VALUE}};',
				],
				'condition' => ['blog_style' => '3'],
			]
		);

		$this->add_control(
			'blog_text_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Description Color', 'luxus' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .blog-item .excerpt' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .blog-four .discription' => 'color: {{VALUE}};',
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
				        ],
						[
				            'name' => 'blog_style',
				            'operator' => '==',
				            'value' => '4'
				        ]
				    ]
				]
			]
		);

		$this->add_control(
			'blog_link_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Link Color', 'luxus' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .blog-item .more' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .blog-item.blog-two .meta .date a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .blog-four .blog-grid-content .more' => 'color: {{VALUE}};',
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
				        ],
						[
				            'name' => 'blog_style',
				            'operator' => '==',
				            'value' => '4'
				        ]
				    ]
				]
			]
		);

		$this->add_control(
			'blog_cat_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Catagory Color', 'luxus' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .blog-item.blog-one .tags a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .blog-item.blog-two .tags a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .blog-item.blog-three .tags a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .blog-four .blog-grid-content .meta' => 'color: {{VALUE}};',
				],
// 				'condition' => ['blog_style' => '3'],
			]
		);

		$this->add_control(
			'blog_cat_bg_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Catagory Background', 'luxus' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .blog-item.blog-one .tags a' => 'background: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .blog-item.blog-two .tags a' => 'background: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .blog-item.blog-three .tags a' => 'background: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .blog-four .blog-grid-content .meta' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'blog_bg_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'luxus' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .blog-item.blog-one' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .blog-item.blog-two' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .blog-four .blog-grid-content' => 'background-color: {{VALUE}};',
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
				        ],
						 [
				            'name' => 'blog_style',
				            'operator' => '==',
				            'value' => '4'
				        ]
				    ]
				]
			]
		);

		$this->add_control(
			'blog_border_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'luxus' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .blog-item' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .blog-four .blog-grid-content' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'blog_box_shadow_normal',
				'selector' => '{{WRAPPER}} .sl-grid-container .blog-item',
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
						],
						[
							'name' => 'blog_style',
							'operator' => '==',
							'value' => '3'
						]
					]
				]
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'blog_four_box_shadow_normal',
				'selector' => '{{WRAPPER}} .sl-grid-container .blog-four .blog-grid-content',
				'condition' => ['blog_style' => '4'],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'blog_item_hover_tab',
			[
				'label'     => __( 'Hover', 'luxus' ),
			]
		);

		$this->add_control(
			'blog_title_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'luxus' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .blog-item:hover .title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .blog-four:hover .title' => 'color: {{VALUE}};',
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
				        ],
						[
				            'name' => 'blog_style',
				            'operator' => '==',
				            'value' => '4'
				        ]
				    ]
				]
			]
		);

		$this->add_control(
			'blog_three_title_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'luxus' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .blog-item.blog-three:hover .content .title' => 'color: {{VALUE}};',
				],
				'condition' => ['blog_style' => '3'],
			]
		);

		$this->add_control(
			'blog_text_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Description Color', 'luxus' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .blog-item:hover .excerpt' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .blog-four:hover .discription' => 'color: {{VALUE}};',
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
				        ],
						[
				            'name' => 'blog_style',
				            'operator' => '==',
				            'value' => '4'
				        ]
				    ]
				]
			]
		);

		$this->add_control(
			'blog_link_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Link Color', 'luxus' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .blog-item:hover .more' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .blog-four:hover .more' => 'color: {{VALUE}};',
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
				        ],
						[
				            'name' => 'blog_style',
				            'operator' => '==',
				            'value' => '4'
				        ]
				    ]
				]
			]
		);

		$this->add_control(
			'blog_cat_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Catagory Color', 'luxus' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .blog-item.blog-one:hover .tags a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .blog-item.blog-two:hover .tags a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .blog-item.blog-three:hover .tags a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .blog-four .blog-grid-content .meta:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'blog_cat_bg_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Catagory Background', 'luxus' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .blog-item.blog-one:hover .tags a' => 'background: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .blog-item.blog-two:hover .tags a' => 'background: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .blog-item.blog-three:hover .tags a' => 'background: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .blog-four .blog-grid-content .meta:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'blog_bg_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'luxus' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .blog-item.blog-one:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .blog-item.blog-two:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .blog-item.blog-two:hover .meta' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .blog-four:hover .blog-grid-content' => 'background-color: {{VALUE}};',
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
				        ],
						[
				            'name' => 'blog_style',
				            'operator' => '==',
				            'value' => '4'
				        ]
				    ]
				]
			]
		);

		$this->add_control(
			'blog_border_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'luxus' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .blog-item:hover' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .sl-grid-container .blog-four .blog-grid-content:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'blog_box_shadow_hover',
				'selectors' => '{{WRAPPER}} .sl-grid-container .blog-item:hover',
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
				        ],
						[
				            'name' => 'blog_style',
				            'operator' => '==',
				            'value' => '3'
				        ]
				    ]
				]
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'blog_four_box_shadow_hover',
				'selector' => '{{WRAPPER}} .sl-grid-container .blog-four:hover .blog-grid-content',
				'condition' => ['blog_style' => '4'],
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
		$posts_per_page = ( ! empty( $settings['posts_per_page'] ) ?  $settings['posts_per_page'] : 3 );
		$excerpt_length = ( ! empty( $settings['excerpt_length'] ) ?  $settings['excerpt_length'] : 14 );
		$read_more_text = $settings['read_more_text'];

		$sl_columns_desktop = ( ! empty( $settings['columns'] ) ? 'sl-grid-desktop-' . $settings['columns'] : 'sl-grid-desktop-3' );

		$sl_columns_tablet = ( ! empty( $settings['sl_columns_tablet'] ) ? ' sl-grid-tablet-' . $settings['sl_columns_tablet'] : ' sl-grid-tablet-2' );

		$sl_columns_mobile = ( ! empty( $settings['sl_columns_mobile'] ) ? ' sl-grid-mobile-' . $settings['sl_columns_mobile'] : ' sl-grid-mobile-1' );

	?>
		<div class="sl-grid-container elementor-grid <?php echo esc_attr($sl_columns_desktop.$sl_columns_tablet.$sl_columns_mobile); ?>">

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

			$luxus_blog_grid = new \WP_Query( $query_args );

            if ($luxus_blog_grid->have_posts()) :

            	if( 4 == $blog_style ){

	        		include get_template_directory() . '/inc/widgets/layouts/blog-grid/layout-4.php';

	        	}elseif( 3 == $blog_style ){

	        		include get_template_directory() . '/inc/widgets/layouts/blog-grid/layout-3.php';

	        	}elseif( 2 == $blog_style ){

	        		include get_template_directory() . '/inc/widgets/layouts/blog-grid/layout-2.php';

	        	}else{

	        		include get_template_directory() . '/inc/widgets/layouts/blog-grid/layout-1.php';

	        	}
            
            endif;

            wp_reset_postdata();
	    ?>

	 	</div>

	<?php
	}
}
