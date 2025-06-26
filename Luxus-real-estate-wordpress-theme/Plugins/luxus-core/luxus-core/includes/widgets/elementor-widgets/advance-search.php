<?php
namespace SLElementorWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Luxus_Advance_Search extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
        wp_register_style( 'jquery-ui', SL_PLUGIN_URL . 'public/css/jquery-ui.min.css','1.12.1', 'all' );
	}

	public function get_script_depends() {
		return [ 'jquery-ui-slider' ];
	}

	public function get_style_depends() {
    	return [ 'jquery-ui' ];
  	}

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
		return 'luxus-advance-search';
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
		return __( 'Advance Search', 'luxus-core' );
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
		return 'sl-widget-icon advance-search';
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
		$this->luxus_style_text_image_box_options();

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
			'form_action_slug',
			[
				'label' => __( 'Form Action Slug (page slug)', 'luxus-core' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'default' => __( 'properties', 'luxus-core' ),
				'placeholder' => __( 'Type your page slug here', 'luxus-core' ),
			]
		);


		$this->add_control(
			'search_form_style',
			[
				'label' => __( 'Search Form Style', 'luxus-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => esc_html__( 'Horizontal', 'luxus-core' ),
					'vertical' => esc_html__( 'Vertical', 'luxus-core' ),
				],
			]
		);

		$this->add_control(
			'search_form_btn_text',
			[
				'label' => __( 'Button Text', 'luxus-core' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Search', 'luxus-core' ),
			]
		);

		$this->add_control(
			'search_form_description',
			[
				'label' => __( 'Description', 'luxus-core' ),
				'type' => Controls_Manager::WYSIWYG,
				'rows' => 10,
				'placeholder' => __( 'Type your description here', 'luxus-core' ),
				'condition' => ['search_form_style' => 'vertical'],

			]
		);

		$this->end_controls_section();

	}

	private function luxus_style_text_image_box_options() {

		$this->start_controls_section(
			'section_box_style',
			[
				'label' => __( 'Box Style', 'luxus-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'advance_search_padding',
			[
				'label'      => __( 'Padding', 'luxus-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => '10',
					'right' => '10',
					'bottom' => '10',
					'left' => '10',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .sl-advance-search-container .sl-advance-search' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'advance_search_border',
			[
				'label'      => __( 'Border Size', 'luxus-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
						'top' => '7',
						'right' => '7',
						'bottom' => '7',
						'left' => '7',
						'unit' => 'px',
						'isLinked' => true,
					],

				'selectors'  => [
					'{{WRAPPER}} .sl-advance-search-container .sl-advance-search-outer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'advance_search_border_radius',
			[
				'label'     => __( 'Border Radius', 'luxus-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 3,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 3,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 3,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .sl-advance-search-container .sl-advance-search-outer' => 'border-radius: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .sl-advance-search-container .sl-advance-search-outer .sl-advance-search' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'advance_search_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'luxus-core' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .sl-advance-search-container .sl-advance-search' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'advance_search_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'luxus-core' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .sl-advance-search-container .sl-advance-search-outer' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_boxes_bg',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Boxes Background', 'luxus-core' ),
				'default' => '#f7f7ff',
				'selectors' => [
					'{{WRAPPER}} .sl-advance-search-container .sl-advance-search-outer .form-control' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .select2-container--default .select2-selection--single' => 'background-color: {{VALUE}} !important',
				],
				'condition' => ['search_form_style' => 'vertical'],
			]
		);

		$this->add_control(
			'select_options_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Select Box Selected Color', 'luxus-core' ),
				'default' => '#00BBFF',
				'selectors' => [
					'.select2-container--default .select2-results__option--highlighted[aria-selected]' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'price_range_slider_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Price Range Slider Color', 'luxus-core' ),
				'default' => '#00BBFF',
				'selectors' => [
					'{{WRAPPER}} .ui-widget-header' => 'background: {{VALUE}} !important; border: 1px solid{{VALUE}} !important;',
					'{{WRAPPER}} .ui-button, .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-state-active, .ui-widget-content .ui-state-active, .ui-state-hover, .ui-widget-content .ui-state-hover, html .ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active' => 'border: 1px solid{{VALUE}} !important;',
				],
				'condition' => ['search_form_style' => 'horizontal'],
			]
		);

		$this->add_control(
			'features_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Property Amenities Color', 'luxus-core' ),
				'default' => '#00BBFF',
				'selectors' => [
					'{{WRAPPER}} .advance-search-opt ul.pro-amu-list li input[type="checkbox"]:checked + .label-text:before' => 'color: {{VALUE}};',
				],
				'condition' => ['search_form_style' => 'horizontal'],
			]
		);

		$this->add_control(
			'advance_search_button_icon_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Advance Search Icon', 'luxus-core' ),
				'default' => '#00BBFF',
				'selectors' => [
					'{{WRAPPER}} .sl-advance-search-container .sl-advance-search .adv-search-btn' => 'color: {{VALUE}};',
				],
				'condition' => ['search_form_style' => 'horizontal'],
			]
		);

		$this->add_responsive_control(
			'advance_search_textboxes_mb',
			[
				'label'     => __( 'Text Boxes Margin', 'luxus-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 15,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 15,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 15,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .sl-advance-search-container .sl-advance-search-outer .form-control' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .sl-advance-search-container .sl-advance-search-outer .sl-select' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
				'condition' => ['search_form_style' => 'vertical'],
			]
		);

		$this->add_responsive_control(
			'advance_search_button_border_radius',
			[
				'label'      => __( 'Search Button Radius', 'luxus-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
						'top' => '3',
						'right' => '3',
						'bottom' => '3',
						'left' => '3',
						'unit' => 'px',
						'isLinked' => true,
				],
				'tablet_default' => [
						'top' => '3',
						'right' => '3',
						'bottom' => '3',
						'left' => '3',
						'unit' => 'px',
						'isLinked' => true,
				],
				'mobile_default' => [
						'top' => '3',
						'right' => '3',
						'bottom' => '3',
						'left' => '3',
						'unit' => 'px',
						'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .sl-advance-search .sl-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'search_button_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'search_button_normal_tab',
			[
				'label'     => __( 'Normal', 'luxus-core' ),
			]
		);

		$this->add_control(
			'search_btn_bg_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Search Button Background', 'luxus-core' ),
				'default' => '#00BBFF',
				'selectors' => [
					'{{WRAPPER}} .sl-advance-search-container .sl-advance-search .sl-btn' => 'background: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'search_btn_color_normail',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Search Button Color', 'luxus-core' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .sl-advance-search-container .sl-advance-search .sl-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'search_button_hover_tab',
			[
				'label'     => __( 'Hover', 'luxus-core' ),
			]
		);

		$this->add_control(
			'search_btn_bg_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Search Button Background', 'luxus-core' ),
				'default' => '#00ABEF',
				'selectors' => [
					'{{WRAPPER}} .sl-advance-search-container .sl-advance-search .sl-btn:hover' => 'background: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'search_btn_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Search Button Color', 'luxus-core' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .sl-advance-search-container .sl-advance-search .sl-btn:hover' => 'color: {{VALUE}};',
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
		$action_slug = $settings['form_action_slug'];
		$search_form_style = $settings['search_form_style'];
		$form_btn_text = $settings['search_form_btn_text'];
		
		//Calling Property Status Taxonomy
		$property_status = get_terms(array('taxonomy'=>'property_status'));

		//Calling Property Cities Taxonomy
		$property_cities = get_terms(array('taxonomy'=>'property_city'));

		//Calling Property Types Taxonomy
		$property_types = get_terms(array('taxonomy'=>'property_type'));

		//Calling Property Features Taxonomy
		$Property_features = get_terms(array('taxonomy'=>'property_feature'));

		?>
			<div class="sl-advance-search-container">
			
			<?php

				if( 'vertical' == $search_form_style ){

            		include( __DIR__ . '/layouts/advance-search/layout-2.php' );

	        	}else{

	        		include( __DIR__ . '/layouts/advance-search/layout-1.php' );

	        	}

			?>

			</div>
    	<?php
	}
}
