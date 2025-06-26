<?php
namespace SLElementorWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Luxus_Property_Grid extends Widget_Base {

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
		return 'luxus-property-grid';
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
		return __( 'Property Grid', 'luxus-core' );
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
		return 'sl-widget-icon property-grid';
		// return 'far fa-heart';
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

		$this->luxus_content_layout_options();
		$this->luxus_style_layout_options();
		$this->luxus_style_property_item_options();
	}

	// Content Layout Options
	private function luxus_content_layout_options() {

		$this->start_controls_section(
			'section_layout_options',
			[
				'label' => __( 'Layout', 'luxus-core' ),
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

	// Style Layout Options
	private function luxus_style_layout_options() {

		$this->start_controls_section(
			'section_layout_style',
			[
				'label' => __( 'Layout', 'luxus-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'grid_columns_margin',
			[
				'label'     => __( 'Columns margin', 'luxus-core' ),
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
				'label'     => __( 'Rows margin', 'luxus-core' ),
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

	private function luxus_style_property_item_options() {

		$this->start_controls_section(
			'section_property_item',
			[
				'label' => __( 'Property Item', 'luxus-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'property_border',
			[
				'label'      => __( 'Border Size', 'luxus-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .sl-grid-container .property-item' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
					'{{WRAPPER}} .sl-grid-container .property-item' => 'border-radius: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .sl-grid-container .property-item .featured-ribbon span' => 'background: {{VALUE}};',
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
					'{{WRAPPER}} .sl-grid-container .property-item .image-bottom .left .area' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Price Color', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .property-item .image-bottom .left .price' => 'color: {{VALUE}};',
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
				'selector' => '{{WRAPPER}} .sl-grid-container .property-item .title',
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
			'bookmark_compare_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Bookmark / Compare Icon Color', 'luxus-core' ),
				'default' => '#00BBFF',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .property-item .image .image-bottom .sl-icon' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .sl-grid-container .property-item .image .image-bottom .right a' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'luxus-core' ),
				'default' => '#333333',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .property-item .title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'features_icon_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Features Icon Color', 'luxus-core' ),
				'default' => '#c6c6ff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .property-item .features li .sl-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'author_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Author Color', 'luxus-core' ),
				'default' => '#333333',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .property-item .footer .agent a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'luxus-core' ),
				'default' => '',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .property-item' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'property_box_shadow_normal',
				'selector'  => '{{WRAPPER}} .sl-grid-container .property-item',
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
			'bookmark_compare_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Bookmark / Compare Icon Color', 'luxus-core' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .property-item .image .image-bottom a:hover .sl-icon' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .sl-grid-container .property-item .image .image-bottom a:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'luxus-core' ),
				'default' => '#00BBFF',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .property-item .title:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'features_icon_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Features Icon Color', 'luxus-core' ),
				'default' => '#00BBFF',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .property-item:hover .features li .sl-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'author_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Author Color', 'luxus-core' ),
				'default' => '#00BBFF',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .property-item .footer .agent a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'luxus-core' ),
				'default' => '',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-grid-container .property-item:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'property_box_shadow_hover',
				'selector'  => '{{WRAPPER}} .sl-grid-container .property-item:hover',
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
		// $property_style = $settings['property_style'];
		$posts_per_page = ( ! empty( $settings['posts_per_page'] ) ?  $settings['posts_per_page'] : 3 );

		$sl_columns_desktop = ( ! empty( $settings['columns'] ) ? 'sl-grid-desktop-' . $settings['columns'] : 'sl-grid-desktop-3' );

		$sl_columns_tablet = ( ! empty( $settings['sl_columns_tablet'] ) ? ' sl-grid-tablet-' . $settings['sl_columns_tablet'] : ' sl-grid-tablet-2' );

		$sl_columns_mobile = ( ! empty( $settings['sl_columns_mobile'] ) ? ' sl-grid-mobile-' . $settings['sl_columns_mobile'] : ' sl-grid-mobile-1' );

	?>
		<div class="sl-grid-container elementor-grid <?php echo $sl_columns_desktop . $sl_columns_tablet . $sl_columns_mobile; ?>">

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
        	);

	        if ( ! empty( $settings['orderby'] ) ) {
	        	$query_args['orderby'] = $settings['orderby'];
	        }

	        if ( ! empty( $settings['order'] ) ) {
	        	$query_args['order'] = $settings['order'];
	        }

			$luxus_property_grid = new \WP_Query( $query_args );

            if ($luxus_property_grid->have_posts()) :

	        	include( __DIR__ . '/layouts/property-grid/layout-1.php' );
            
            endif;

            wp_reset_postdata();
	    ?>

	 	</div>

	<?php
	}
}
