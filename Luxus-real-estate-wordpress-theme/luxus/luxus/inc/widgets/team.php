<?php
namespace SLElementorWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Luxus_Team extends Widget_Base {

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
		return 'luxus-team';
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
		return __( 'Team Box', 'luxus' );
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
		return 'sl-theme-widget-icon team';
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
		$this->luxus_style_team_box_options();
		$this->luxus_style_team_social_options();

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
			'team_style',
			[
				'label' => __( 'Team Style', 'luxus' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Style 1', 'luxus' ),
					'2' => esc_html__( 'Style 2', 'luxus' ),
				],
			]
		);

		$this->add_control(
			'team_title',
			[
				'label' => __( 'Title', 'luxus' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'John Doe', 'luxus' ),
				'placeholder' => __( 'Type your title here', 'luxus' ),
			]
		);

		$this->add_control(
			'team_designation',
			[
				'label' => __( 'Designation', 'luxus' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'CEO', 'luxus' ),
				'placeholder' => __( 'Type your Designation here', 'luxus' ),
			]
		);

		$this->add_control(
			'team_image',
			[
				'label' => __( 'Choose Image', 'luxus' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'team_show_icons',
			[
				'label' => __( 'Show Social Icons', 'luxus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'luxus' ),
				'label_off' => __( 'Hide', 'luxus' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'social_icon',
			[
				'label' => __( 'Icon', 'luxus' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'social',
				'default' => [
					'value' => 'fab fa-wordpress',
					'library' => 'fa-brands',
				],
				'recommended' => [
					'fa-brands' => [
						'android',
						'apple',
						'behance',
						'bitbucket',
						'codepen',
						'delicious',
						'deviantart',
						'digg',
						'dribbble',
						'elementor',
						'facebook',
						'flickr',
						'foursquare',
						'free-code-camp',
						'github',
						'gitlab',
						'globe',
						'houzz',
						'instagram',
						'jsfiddle',
						'linkedin',
						'medium',
						'meetup',
						'mix',
						'mixcloud',
						'odnoklassniki',
						'pinterest',
						'product-hunt',
						'reddit',
						'shopping-cart',
						'skype',
						'slideshare',
						'snapchat',
						'soundcloud',
						'spotify',
						'stack-overflow',
						'steam',
						'telegram',
						'thumb-tack',
						'tripadvisor',
						'tumblr',
						'twitch',
						'twitter',
						'viber',
						'vimeo',
						'vk',
						'weibo',
						'weixin',
						'whatsapp',
						'wordpress',
						'xing',
						'yelp',
						'youtube',
						'500px',
					],
					'fa-solid' => [
						'envelope',
						'link',
						'rss',
					],
				],
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => __( 'Link', 'luxus' ),
				'type' => Controls_Manager::URL,
				'default' => [
					'is_external' => 'true',
				],
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'luxus' ),
			]
		);

		$this->add_control(
			'social_icon_list',
			[
				'label' => __( 'Social Icons', 'luxus' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'social_icon' => [
							'value' => 'fab fa-facebook-f',
							'library' => 'fa-brands',
						],
					],
					[
						'social_icon' => [
							'value' => 'fab fa-twitter',
							'library' => 'fa-brands',
						],
					],
					[
						'social_icon' => [
							'value' => 'fab fa-instagram',
							'library' => 'fa-brands',
						],
					],
				],
				'title_field' => '<# var migrated = "undefined" !== typeof __fa4_migrated, social = ( "undefined" === typeof social ) ? false : social; #>{{{ elementor.helpers.getSocialNetworkNameFromIcon( social_icon, social, true, migrated, true ) }}}',
				'condition' => ['team_show_icons' => 'yes',],
			]
		);

		$this->add_control(
			'team_link',
			[
				'label' => __( 'Link', 'luxus' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'luxus' ),
				'show_external' => true,
			]
		);

		$this->end_controls_section();

	}

	private function luxus_style_team_box_options() {

		$this->start_controls_section(
			'section_team_style',
			[
				'label' => __( 'Team Style', 'luxus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'team_title_typography',
				'label' => __( 'Title Typography', 'luxus' ),
				 
				'fields_options'  => [
		            'typography'  => [ 'default' => 'yes' ],
		            'font_size'   => [ 'default' => [ 'size' => 22 ] ],
		            'font_weight' => [ 'default' => 600 ],
		            'line_height' => [ 'default' => [ 'size' => 26 ] ],
		        ],
				'selector' => '{{WRAPPER}} .sl-team-container .sl-team .name',
			]
		);

		$this->add_control(
			'team_title_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'luxus' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-team-container .sl-team .name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'team_designatio_typography',
				'label' => __( 'Designation Typography', 'luxus' ),
				 
				'fields_options'  => [
		            'typography'  => [ 'default' => 'yes' ],
		            'font_size'   => [ 'default' => [ 'size' => 16 ] ],
		            'font_weight' => [ 'default' => 600 ],
		            'line_height' => [ 'default' => [ 'size' => 22 ] ],
		        ],
				'selector' => '{{WRAPPER}} .sl-team-container .sl-team .possition',
			]
		);

		$this->add_control(
			'team_designation_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Description Color', 'luxus' ),
				'default' => '#555555',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-team-container .sl-team .possition' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'team_title_area_bg',
				'label' => __( 'Title Area Background', 'luxus' ),
				'types' => [ 'gradient' ],
				'fields_options' => [
					'background' => [
						'frontend_available' => true,
					],
					'color' => [
						'type' => Controls_Manager::COLOR,
						'default' => '#00000000',
						'condition' => [
							'background' => [ 'gradient' ],
						],
					],
					'color_stop' => [
						'type' => Controls_Manager::SLIDER,
						'size_units' => [ '%' ],
						'default' => [
							'unit' => '%',
							'size' => 0,
						],
						'render_type' => 'ui',
						'condition' => [
							'background' => [ 'gradient' ],
						],
						'of_type' => 'gradient',
					],
					'color_b' => [
						'type' => Controls_Manager::COLOR,
						'default' => '#000000',
						'render_type' => 'ui',
						'condition' => [
							'background' => [ 'gradient' ],
						],
						'of_type' => 'gradient',
					],
					'color_b_stop' => [
						'type' => Controls_Manager::SLIDER,
						'size_units' => [ '%' ],
						'default' => [
							'unit' => '%',
							'size' => 100,
						],
						'render_type' => 'ui',
						'condition' => [
							'background' => [ 'gradient' ],
						],
						'of_type' => 'gradient',
					],			],
				'selector' => '{{WRAPPER}} .sl-team-container .sl-team .info',
				'condition' => ['team_style' => '2'],
			]
		);

		$this->add_control(
			'team_image_radius',
			[
				'label' => __( 'Image Radius', 'luxus' ),
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
					'{{WRAPPER}} .sl-team-container .sl-team .img' => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .sl-team-container .sl-team.team-two' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'team_box_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'team_box_normal',
			[
				'label'     => __( 'Normal', 'luxus' ),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'team_box_shadow_normal',
				'label' => __( 'Box Shadow', 'luxus' ),
				'selector' => '{{WRAPPER}} .sl-team-container .sl-team .img',
				'condition' => ['team_style' => '1'],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'team_two_box_shadow_normal',
				'label' => __( 'Box Shadow', 'luxus' ),
				'selector' => '{{WRAPPER}} .sl-team-container .sl-team',
				'condition' => ['team_style' => '2'],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'team_box_hover',
			[
				'label'     => __( 'Hover', 'luxus' ),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'team_box_shadow_hover',
				'label' => __( 'Box Shadow', 'luxus' ),
				'selector' => '{{WRAPPER}} .sl-team-container .sl-team:hover .img',
				'condition' => ['team_style' => '1'],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'team_two_box_shadow_hover',
				'label' => __( 'Box Shadow', 'luxus' ),
				'selector' => '{{WRAPPER}} .sl-team-container .sl-team:hover:hover',
				'condition' => ['team_style' => '2'],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	private function luxus_style_team_social_options() {

		$this->start_controls_section(
			'section_social_style',
			[
				'label' => __( 'Social Icons Style', 'luxus' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['team_show_icons' => 'yes',],
			]
		);

		$this->add_control(
			'team_social_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'luxus' ),
				'default' => '#00bbff80',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-team-container .sl-team .img .social' => 'background-color: {{VALUE}};',
				],
				'condition' => ['team_style' => '1',],
			]
		);


		$this->start_controls_tabs( 'team_social_icons_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'team_social_icons_normal',
			[
				'label'     => __( 'Normal', 'luxus' ),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'social_icons_border_normal',
				'label' => __( 'Border', 'luxus' ),
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' => [
							'top' => '1',
							'right' => '1',
							'bottom' => '1',
							'left' => '1',
							'isLinked' => true,
						],
					],
					'color' => [
						'default' => '#ffffff',
					],
				],
				'selector' => '{{WRAPPER}} .sl-team-container .sl-team .social ul li i, .sl-team-container .sl-team .social ul li svg',
			]
		);

		$this->add_control(
			'social_icons_border_radius_normal',
			[
				'label'     => __( 'Border Radius', 'luxus' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 100,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sl-team-container .sl-team .social ul li i' => 'border-radius: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .sl-team-container .sl-team .social ul li svg' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'social_icons_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Icon Color', 'luxus' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-team-container .sl-team .social ul li i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-team-container .sl-team .social ul li svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_icons_bg_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background', 'luxus' ),
				'default' => '',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-team-container .sl-team .social ul li i' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .sl-team-container .sl-team .social ul li svg' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'team_social_icons_hover',
			[
				'label'     => __( 'Hover', 'luxus' ),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'social_icons_border_hover',
				'label' => __( 'Border', 'luxus' ),
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' => [
							'top' => '1',
							'right' => '1',
							'bottom' => '1',
							'left' => '1',
							'isLinked' => true,
						],
					],
					'color' => [
						'default' => '#ffffff',
					],
				],
				'selector' => '{{WRAPPER}} .sl-team-container .sl-team .social ul li i:hover, .sl-team-container .sl-team .social ul li svg:hover',
			]
		);

		$this->add_control(
			'social_icons_border_radius_hover',
			[
				'label'     => __( 'Border Radius', 'luxus' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 100,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sl-team-container .sl-team .social ul li i:hover' => 'border-radius: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .sl-team-container .sl-team .social ul li svg:hover' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'social_icons_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Icon Color', 'luxus' ),
				'default' => '#00bbff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-team-container .sl-team .social ul li i:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sl-team-container .sl-team .social ul li svg:hover' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_icons_bg_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background', 'luxus' ),
				'default' => '#ffffff',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .sl-team-container .sl-team .social ul li i:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .sl-team-container .sl-team .social ul li svg:hover' => 'background-color: {{VALUE}};',
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
		$team_style = $settings['team_style'];

	?>
		<div class="sl-team-container">
		
		<?php

	    	if( 2 == $team_style ){

	    		include get_template_directory() . '/inc/widgets/layouts/team/layout-2.php';

	    	}else{

	    		include get_template_directory() . '/inc/widgets/layouts/team/layout-1.php';

	    	}

    	?>

		</div>
	<?php
	}
}