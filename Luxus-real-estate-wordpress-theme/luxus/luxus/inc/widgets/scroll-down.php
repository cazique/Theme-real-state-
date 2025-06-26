<?php
namespace SLElementorWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Luxus_Scroll_Down extends Widget_Base {

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
		return 'luxus-scroll-down';
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
		return __( 'Scroll Down Button', 'luxus' );
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
		return 'sl-theme-widget-icon scroll-down';
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
			'sl_scroll_down_id',
			[
				'label' => __( 'Target ID', 'luxus' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '#', 'luxus' ),
				'placeholder' => __( 'Target ID (eg: #about)', 'luxus' ),
			]
		);
		
		$this->add_control(
			'sl_scroll_down_mouse_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Mouse Color', 'luxus' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-scroll-down-container .sl-mouse' => 'border-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'sl_scroll_down_wheel_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Wheel Color', 'luxus' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-scroll-down-container .sl-wheel' => 'border-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'sl_scroll_down_arrows_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Arrows Color', 'luxus' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-scroll-down-container .sl_scroll_arrows' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'user_login_align',
			[
				'label' => __( 'Avatar Alignment', 'luxus' ),
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
					'{{WRAPPER}} .sl-scroll-down-container' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

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
		$sl_scroll_down_id = $settings['sl_scroll_down_id'];

		?>
			<div class="sl-scroll-down-container">
				<a href="<?php echo esc_url( $sl_scroll_down_id ); ?>" class="sl-scroll-down">
					<div class="mouse_scroll">
						<div class="sl-mouse">
							<div class="sl-wheel"></div>
						</div>
						<div>
							<span class="sl_scroll_arrows one"></span>
							<span class="sl_scroll_arrows two"></span>
						</div>
					</div>
				</a>
			</div>
    	<?php
	}
}