<?php
namespace SLElementorWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Luxus_Video_Popup extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);

		wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/assets/css/magnific-popup.min.css','1.0', 'all' );

		wp_register_script( 'magnific-popup-js', get_template_directory_uri() . '/assets/js/jquery.magnific-popup.min.js', array(), '1.0', true );
	}

	public function get_script_depends() {
		return [ 'magnific-popup-js' ];
	}

	public function get_style_depends() {
    	return [ 'magnific-popup' ];
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
		return 'luxus-video-popup';
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
		return __( 'Video Popup', 'luxus' );
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
		return 'sl-theme-widget-icon video-popup';
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
		$this->luxus_style_video_popup_options();

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
			'video_popup_link',
			[
				'label' => __( 'Youtube/Vimeo Video URL', 'luxus' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'luxus' ),
				'show_external' => true,
				'default' => [
					'url' => '',
				],
			]
		);

		$this->add_control(
			'video_popup_show_pulse',
			[
				'label' => __( 'Show Pulse Animation', 'luxus' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show Pulse', 'luxus' ),
				'label_off' => __( 'Hide Pulse', 'luxus' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'video_popup_btn_width',
			[
				'label' => __( 'Button Width', 'luxus' ),
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
					'size' => 70,
				],
				'selectors' => [
					'{{WRAPPER}} .sl-video-popup-container .sl-video-popup .play-btn' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'video_popup_btn_height',
			[
				'label' => __( 'Button Height', 'luxus' ),
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
					'size' => 70,
				],
				'selectors' => [
					'{{WRAPPER}} .sl-video-popup-container .sl-video-popup .play-btn' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .sl-video-popup-container .sl-video-popup .play-btn i' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'video_popup_content_align',
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
					'{{WRAPPER}} .sl-video-popup' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

	}

	private function luxus_style_video_popup_options() {

		$this->start_controls_section(
			'section_button_style',
			[
				'label' => __( 'Button Style', 'luxus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'video_popup_pulse_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Pulse Animation Color', 'luxus' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-video-popup-container .sl-video-popup .sl-pulse:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'video_popup_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'video_popup_normal',
			[
				'label'     => __( 'Normal', 'luxus' ),
			]
		);

		$this->add_control(
			'video_popup_radius_normal',
			[
				'label'      => __( 'Button Border Radius', 'luxus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'       => [
					'top' => '50',
					'right' => '50',
					'bottom' => '50',
					'left' => '50',
					'unit' => 'px',
					'isLinked' => 'true',
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .sl-video-popup-container .sl-video-popup .play-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],				
			]
		);

		$this->add_control(
			'video_popup_bg_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Button Background Color', 'luxus' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-video-popup-container .sl-video-popup .play-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'video_popup_normal_icon_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Button Icon Color', 'luxus' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-video-popup-container .sl-video-popup .play-btn i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'video_popup_hover',
			[
				'label'     => __( 'Hover', 'luxus' ),
			]
		);
		
		$this->add_control(
			'video_popup_radius_hover',
			[
				'label'      => __( 'Button Border Radius', 'luxus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'       => [
					'top' => '50',
					'right' => '50',
					'bottom' => '50',
					'left' => '50',
					'unit' => 'px',
					'isLinked' => 'true',
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .sl-video-popup-container .sl-video-popup .play-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],				
			]
		);

		$this->add_control(
			'video_popu_bg_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Button Background Color', 'luxus' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-video-popup-container .sl-video-popup .play-btn:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'video_popup_hover_icon_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Button Icon Color', 'luxus' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-video-popup-container .sl-video-popup .play-btn:hover i' => 'color: {{VALUE}};',
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

		$video_popup_link = $settings['video_popup_link']['url'];
		$video_pulse = $settings['video_popup_show_pulse'] == 'yes' ? 'sl-pulse' : null;

		?>
			<div class="sl-video-popup-container">
				<div class="sl-video-popup">
		            <a href="<?php echo esc_url($video_popup_link); ?>" class="video-popup play-btn <?php echo esc_attr($video_pulse); ?>">
		            	<i class="sl-icon sl-play-t"></i>
		            </a>
		        </div>

			</div>
    	<?php
	}
}