<?php
namespace SLElementorWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Luxus_Property_Category extends Widget_Base {

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
		return 'luxus-property_category';
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
		return __( 'Property Category', 'luxus-core' );
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
		return 'sl-widget-icon property-category';
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
		$this->luxus_style_category_box_options();
		$this->luxus_style_category_box_options_two();
		
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
			'category_style',
			[
				'label' => __( 'Category Style', 'luxus-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Style 1', 'luxus-core' ),
					'2' => esc_html__( 'Style 2', 'luxus-core' ),
				],
			]
		);

		$this->add_control(
			'select_category',
			[
				'label' => __( 'Slect Taxonomy', 'luxus-core' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [
					'property_type'  => __( 'Property Types', 'luxus-core' ),
					'property_feature' => __( 'Property Features', 'luxus-core' ),
					'property_status' => __( 'Property Status', 'luxus-core' ),
					'property_city' => __( 'Property Cities', 'luxus-core' ),
					'property_province' => __( 'Property Provinces', 'luxus-core' ),
					'property_country' => __( 'Property Countries', 'luxus-core' ),
				],
				// 'default' => [ 'property_type', 'description' ],
			]
		);

		$this->add_control(
			'property_type',
			[
				'label'       => __( 'Select Property Type', 'luxus-core' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'options'     => $this->luxus_custom_taxonomy( 'property_type' ),
				'condition' => ['select_category' => 'property_type',],
				
			]
		);

		$this->add_control(
			'property_feature',
			[
				'label'       => __( 'Select Property Feature', 'luxus-core' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'options'     => $this->luxus_custom_taxonomy( 'property_feature' ),
				'condition' => ['select_category' => 'property_feature',],
				
			]
		);

		$this->add_control(
			'property_status',
			[
				'label'       => __( 'Select Property Status', 'luxus-core' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'options'     => $this->luxus_custom_taxonomy( 'property_status' ),
				'condition' => ['select_category' => 'property_status',],
				
			]
		);

		$this->add_control(
			'property_city',
			[
				'label'       => __( 'Select Property City', 'luxus-core' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'options'     => $this->luxus_custom_taxonomy( 'property_city' ),
				'condition' => ['select_category' => 'property_city',],
				
			]
		);

		$this->add_control(
			'property_province',
			[
				'label'       => __( 'Select Property Province', 'luxus-core' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'options'     => $this->luxus_custom_taxonomy( 'property_province' ),
				'condition' => ['select_category' => 'property_province',],
				
			]
		);

		$this->add_control(
			'property_country',
			[
				'label'       => __( 'Select Property Country', 'luxus-core' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'options'     => $this->luxus_custom_taxonomy( 'property_country' ),
				'condition' => ['select_category' => 'property_country',],
				
			]
		);

		$this->add_control(
			'posts_count_postfix',
			[
				'label' => __( 'Posts Count Postfix (e.g Properties)', 'luxus-core' ),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Properties', 'luxus-core' ),
				'placeholder' => __( 'Type your Postfix here', 'luxus-core' ),
			]
		);

		$this->add_control(
			'link_text',
			[
				'label' => __( 'Link Text', 'luxus-core' ),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'View All Properties', 'luxus-core' ),
				'placeholder' => __( 'Type your text here', 'luxus-core' ),
			]
		);

		$this->add_control(
			'category_image',
			[
				'label' => __( 'Choose Image', 'luxus-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->end_controls_section();

	}

	private function luxus_style_category_box_options() {

		$this->start_controls_section(
			'section_category_style',
			[
				'label' => __( 'Category Box Style', 'luxus-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['category_style' => '1'],
			]
		);

		$this->add_control(
			'category_image_radius',
			[
				'label' => __( 'Border Radius', 'luxus-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
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
					'{{WRAPPER}} .sl-category-container .sl-cat' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'category_typography',
				'label' => __( 'Category Typography', 'luxus-core' ),
				
				'fields_options'  => [
		            'typography'  => [ 'default' => 'yes' ],
		            'font_size'   => [ 'default' => [ 'size' => 20 ] ],
		            'font_weight' => [ 'default' => 600 ],
		            'line_height' => [ 'default' => [ 'size' => 20 ] ],
		        ],
				'selector' => '{{WRAPPER}} .sl-category-container .sl-cat .cat-info .cat-name',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'counter_typography',
				'label' => __( 'Counter Typography', 'luxus-core' ),
				
				'fields_options'  => [
		            'typography'  => [ 'default' => 'yes' ],
		            'font_size'   => [ 'default' => [ 'size' => 18 ] ],
		            'font_weight' => [ 'default' => 500 ],
		            'line_height' => [ 'default' => [ 'size' => 22 ] ],
		        ],
				'selector' => '{{WRAPPER}} .sl-category-container .sl-cat .cat-info .cat-count',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'link_typography',
				'label' => __( 'Link Typography', 'luxus-core' ),
				
				'fields_options'  => [
		            'typography'  => [ 'default' => 'yes' ],
		            'font_size'   => [ 'default' => [ 'size' => 16 ] ],
		            'font_weight' => [ 'default' => 500 ],
		            'line_height' => [ 'default' => [ 'size' => 18 ] ],
		        ],
				'selector' => '{{WRAPPER}} .sl-category-container .sl-cat .cat-info .tax-explore',
			]
		);

		$this->add_control(
			'category_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Category Color', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-category-container .sl-cat .cat-info .cat-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'counter_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Counter Color', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-category-container .sl-cat .cat-info .cat-count' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'link_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Link Color', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-category-container .sl-cat .cat-info .tax-explore' => 'color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'category_box_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'category_box_normal',
			[
				'label'     => __( 'Normal', 'luxus-core' ),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow_normal',
				'label' => __( 'Box Shadow', 'luxus-core' ),
				'selector' => '{{WRAPPER}} .sl-category-container .sl-cat',
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'category_box_hover',
			[
				'label'     => __( 'Hover', 'luxus-core' ),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow_hover',
				'label' => __( 'Box Shadow', 'luxus-core' ),
				'selector' => '{{WRAPPER}} .sl-category-container .sl-cat:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	private function luxus_style_category_box_options_two() {

		$this->start_controls_section(
			'section_category_style_two',
			[
				'label' => __( 'Category Box Style', 'luxus-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['category_style' => '2'],
			]
		);

		$this->add_control(
			'category_image_radius_two',
			[
				'label' => __( 'Border Radius', 'luxus-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
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
					'{{WRAPPER}} .sl-category-container .sl-cat-two' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'category_typography_two',
				'label' => __( 'Category Typography', 'luxus-core' ),
				
				'fields_options'  => [
		            'typography'  => [ 'default' => 'yes' ],
		            'font_size'   => [ 'default' => [ 'size' => 20 ] ],
		            'font_weight' => [ 'default' => 600 ],
		            'line_height' => [ 'default' => [ 'size' => 20 ] ],
		        ],
				'selector' => '{{WRAPPER}} .sl-category-container .sl-cat-two .cat-info .cat-name',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'counter_typography_two',
				'label' => __( 'Counter Typography', 'luxus-core' ),
				
				'fields_options'  => [
		            'typography'  => [ 'default' => 'yes' ],
		            'font_size'   => [ 'default' => [ 'size' => 16 ] ],
		            'font_weight' => [ 'default' => 500 ],
		            'line_height' => [ 'default' => [ 'size' => 16 ] ],
		        ],
				'selector' => '{{WRAPPER}} .sl-category-container .sl-cat-two .cat-count',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'link_typography_two',
				'label' => __( 'Link Typography', 'luxus-core' ),
				
				'fields_options'  => [
		            'typography'  => [ 'default' => 'yes' ],
		            'font_size'   => [ 'default' => [ 'size' => 16 ] ],
		            'font_weight' => [ 'default' => 500 ],
		            'line_height' => [ 'default' => [ 'size' => 18 ] ],
		        ],
				'selector' => '{{WRAPPER}} .sl-category-container .sl-cat-two .cat-info .tax-explore',
			]
		);

		$this->add_control(
			'category_color_two',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Category Color', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-category-container .sl-cat-two .cat-info .cat-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'link_color_two',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Link Color', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-category-container .sl-cat-two .cat-info .tax-explore' => 'color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'category_box_tabs_two' );

		// Normal tab.
		$this->start_controls_tab(
			'category_box_normal_two',
			[
				'label'     => __( 'Normal', 'luxus-core' ),
			]
		);

		$this->add_control(
			'counter_border_radius_normal_two',
			[
				'label'     => __( 'Counter Border Radius', 'luxus-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 3,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sl-category-container .sl-cat-two .cat-count' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'counter_color_normal_two',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Counter Color', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-category-container .sl-cat-two .cat-count' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'counter_background_normal_two',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Counter Background', 'luxus-core' ),
				'default' => '#00BBFF',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-category-container .sl-cat-two .cat-count' => 'background: {{VALUE}};',
					'{{WRAPPER}} .sl-category-container .sl-cat-two .cat-info .tax-explore:after' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow_normal_two',
				'label' => __( 'Box Shadow', 'luxus-core' ),
				'selector' => '{{WRAPPER}} .sl-category-container .sl-cat-two',
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'category_box_hover_two',
			[
				'label'     => __( 'Hover', 'luxus-core' ),
			]
		);

		$this->add_control(
			'counter_border_radius_hover_two',
			[
				'label'     => __( 'Counter Border Radius', 'luxus-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 3,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sl-category-container .sl-cat-two:hover .cat-count' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'counter_color_hover_two',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Counter Color', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-category-container .sl-cat-two:hover .cat-count' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'counter_background_hover_two',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Counter Background', 'luxus-core' ),
				'default' => '#00BBFF',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-category-container .sl-cat-two:hover .cat-count' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow_hover_two',
				'label' => __( 'Box Shadow', 'luxus-core' ),
				'selector' => '{{WRAPPER}} .sl-category-container .sl-cat-two:hover',
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
		$category_style = $settings['category_style'];

		?>
			<div class="sl-category-container">
			
			<?php

	    	if( 2 == $category_style ){

	    		include( __DIR__ . '/layouts/property-category/layout-2.php' );

	    	}else{

	    		include( __DIR__ . '/layouts/property-category/layout-1.php' );

	    	}

	    	?>

			</div>
    	<?php
	}
}