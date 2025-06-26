<?php
namespace SLElementorWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Luxus_Content_Block extends Widget_Base {

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
		return 'luxus-content-block';
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
		return __( 'Content Block', 'luxus-core' );
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
		return 'sl-widget-icon content-block';
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

	// Get Content Blocks 'reusable_block'
	private function luxus_content_blocks( $post_type ) {
		
		$options = array();

		$args = array(
		    'post_type'  => 'luxus_content_block',
		    'meta_query' => array(
		        array(
		            'key'   => 'luxus_content_block_type',
		            'value' => 'reusable_block',
		        )
		    )
		);
		$block_list = get_posts( $args );

		if ( $block_list ) {
		    foreach ( $block_list as $post ) {
		        setup_postdata( $post );

				if ( isset( $post ) ) {
					if ( isset( $post->ID ) && isset( $post->post_title ) ) {
						$options[ $post->ID ] = $post->post_title;
					}
				}
		    }
		    wp_reset_postdata();
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

		$this->luxus_content_block_options();
	}

	// Content Query Options
	private function luxus_content_block_options() {

		$this->start_controls_section(
			'section_query_options',
			[
				'label' => __( 'Content Block', 'luxus-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'content_block_id',
			[
				'label'       => __( 'Select Content Blocks', 'luxus-core' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'options'     => $this->luxus_content_blocks( 'luxus_content_block_type' ),
				
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

		$content_block_id = $settings['content_block_id'];

		if ( ! empty( $content_block_id ) ) {

			$content_block_shortcode = '[luxus_content_block id="' . $content_block_id . '"]';

			$content_block_shortcode = do_shortcode( shortcode_unautop( $content_block_shortcode ) );

			echo '<div class="sl-shortcode">' . $content_block_shortcode . '</div>';

		} else {

			echo "Please, Select Content Block";

		}
	}

	/**
	 * Render shortcode widget as plain content.
	 *
	 * Override the default behavior by printing the shortcode instead of rendering it.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function render_plain_content() {
		$settings = $this->get_settings_for_display();

		$content_block_id = $settings['content_block_id'];

		if ( ! empty( $content_block_id ) ) {

			$content_block_shortcode = '[luxus_content_block id="' . $content_block_id . '"]';

		} else {

			$content_block_shortcode = " ";

		}
		
		// In plain mode, render without shortcode
		echo esc_html( $this->get_settings( $content_block_shortcode ) );
	}
}