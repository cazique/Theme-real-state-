<?php
namespace SLElementorWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Luxus_Property_Gmap extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);

        wp_register_script( 'markerclusterer', SL_PLUGIN_URL . 'public/js/markerclusterer.min.js', array(), '', true );
        wp_register_script( 'gmap-properties', plugin_dir_url( __FILE__ ) . 'assets/js/gmap-properties.js','1.0', true );

	}

	public function get_script_depends() {
		return [ 'markerclusterer', 'gmap-properties' ];
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
		return 'luxus-property-gmap';
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
		return __( 'GMap Properties', 'luxus-core' );
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
		return 'sl-widget-icon property-map';
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
		$this->luxus_style_property_map_box_options();
		$this->luxus_map_query_options();

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

		$this->add_responsive_control(
			'map_height',
			[
				'label'     => __( 'Map Height', 'luxus-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 550,
				],
				'range'     => [
					'px' => [
						'min' => 100,
						'max' => 1440,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 750,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 650,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 550,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .sl-peoperty-map-container #sl_properties_gmap' => 'height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'map_zoom',
			[
				'label' => __( 'Map Zoom', 'luxus-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'map_center_heading',
			[
				'label' => __( 'Map Center', 'luxus-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'map_lat',
			[
				'label' => __( 'Map Latitude', 'luxus-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Type your Map Latitude here', 'luxus-core' ),
			]
		);

		$this->add_control(
			'map_lng',
			[
				'label' => __( 'Map Longitude', 'luxus-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Type your Map Longitude here', 'luxus-core' ),
			]
		);

		$this->add_control(
			'hr',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'marker_image',
			[
				'label' => __( 'Marker Image', 'luxus-core' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => SL_PLUGIN_URL . 'public/images/google-pin.png',
					// 'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'marker_width',
			[
				'label' => __( 'Marker Icon Width', 'luxus-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 40,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'marker_height',
			[
				'label' => __( 'Marker Icon Height', 'luxus-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 48,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'map_api',
			[
				'label' => __( 'Map API', 'luxus-core' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => __( 'Enter your Google Map API here', 'luxus-core' ),
			]
		);

		$this->end_controls_section();

	}

	// Content Query Options
	private function luxus_map_query_options() {

		$this->start_controls_section(
			'section_query_options',
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
				'default' => 16,
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

		$this->end_controls_section();

	}

	private function luxus_style_property_map_box_options() {

		$this->start_controls_section(
			'section_box_style',
			[
				'label' => __( 'Box Style', 'luxus-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_image_box_border',
			[
				'label'      => __( 'Border Size', 'luxus-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => '1',
					'right' => '1',
					'bottom' => '1',
					'left' => '1',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .sl-text-image-container .sl-text-image' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
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

		global $post,$wpdb;

	    $m1 = SL_PLUGIN_URL . 'public/images/m1.png';
	    $m2 = SL_PLUGIN_URL . 'public/images/m2.png';
	    $m3 = SL_PLUGIN_URL . 'public/images/m3.png';
	    $m4 = SL_PLUGIN_URL . 'public/images/m4.png';
	    $m5 = SL_PLUGIN_URL . 'public/images/m5.png';

	    $marker_img_pholder = SL_PLUGIN_URL . 'public/images/map-pin.png';
	    $thumb_placeholder = SL_PLUGIN_URL . 'public/images/agency-cover1.jpg';

	    $widget_map_api = $settings['map_api'];
		$opt_map_api = !empty( $widget_map_api ) ? $widget_map_api : luxus_options('sl-map-api');
	    $map_api= !$opt_map_api == null ? $opt_map_api : 'AIzaSyDyDdOsUkUKONAziAAoIBJgqVo4_uvYY1E';

		$opt_marker_img = $settings['marker_image']['url'];
	    $marker_img_url = ( !empty( $opt_marker_img ) ? $opt_marker_img : $marker_img_pholder );

	    $opt_mareker_width = $settings['marker_width']['size'];
	    $marker_width = ( !empty( $opt_mareker_width ) ? $opt_mareker_width : 40 );

	   	$opt_mareker_height = $settings['marker_height']['size'];
	    $marker_height = ( !empty( $opt_mareker_height ) ? $opt_mareker_height : 48 );

	    $opt_map_lat = $settings['map_lat'];
	    $opt_map_lng = $settings['map_lng'];

	    $opt_map_zoom = $settings['map_zoom']['size'];
	    $map_zoom = ( !empty( $opt_map_zoom ) ? $opt_map_zoom : 5 );

	    $property_status = '';
	    $property_type = '';

	    $sl_properties_data = [];
	   	$gmap_map_settings = [];
	    $sl_counter     = 0;

	    $map_tax_query = array();

    	// Property Type
	    if( !empty( $settings['property_type'] ) ) {
	        $map_tax_query [] = array(
	            'taxonomy' => 'property_type',
	            'field'    => 'slug',
	            'terms'    => $settings['property_type'],
	            'operator' => 'IN',
	        );
	    }
	    // Property Status
	    if( !empty( $settings['property_status'] ) ) {
	        $map_tax_query [] = array(
	            'taxonomy' => 'property_status',
	            'field'    => 'slug',
	            'terms'    => $settings['property_status'],
	            'operator' => 'IN',
	        );
	    }

	    $posts_per_page = ( !empty( $settings['posts_per_page'] ) ? $settings['posts_per_page'] : 16 );

	    $map_args = array(
	        'post_type'             => 'property',
	        'posts_per_page'        => absint( $posts_per_page ),
	        'no_found_rows'         => true,
	        'post__not_in'          => get_option( 'sticky_posts' ),
	        'ignore_sticky_posts'   => true,
	        'tax_query'             => $map_tax_query,
	    );

	    $properties = get_posts( $map_args );

		?>

		<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $map_api;?>"></script>

		<div class="sl-peoperty-map-container">
			
		<?php

		    if( ! empty( $properties ) ){

		    	foreach ( $properties as $property ){

					$author_name = get_the_author_meta( 'display_name', $property->post_author );

					$property_map = get_post_meta( $property->ID, '_property_map',true );;
					$latitude = isset( $property_map['latitude'] ) ? $property_map['latitude'] : 0 ;
	        		$longtitude = isset( $property_map['longitude'] ) ? $property_map['longitude'] : 0 ;

		            $sl_property_data['lat'] = $latitude;
		            $sl_property_data['lng'] = $longtitude;
		            $sl_property_data['iconUrl'] = $marker_img_url;

		            $feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $property->ID ), 'luxus-thumb-md' ); 
		            $feature_image_url = ( $feature_image[0] != "" ? $feature_image[0] : $thumb_placeholder );

		            $property_status = get_the_terms( $property->ID, 'property_status' );
            		if( !empty( $property_status ) ) {
		                foreach( $property_status as $status ) {
		                    $property_status_name = $status->name;
		                }
		            }

            		$property_types = get_the_terms( $property->ID, 'property_type' );
		            if( !empty( $property_types) ) {
		                foreach( $property_types as $type ) {
		                    $property_type_name = $type->name;
		                }
		            }

		            $sl_property_data['infoWin'] = array(

		            	'title' => $property->post_title,
		            	'image' => $feature_image_url,
		            	'type' 	=> $property_type_name,
		            	'status' 	=> $property_status_name,
		            	'author' 	=> $author_name,
		            	'link' 	=> get_post_permalink( $property->ID ),
		            	'date' 	=> get_the_date( 'm-d-Y', $property->ID ),
		            	'address' => get_post_meta( $property->ID, '_property_st_address', true ),
		            	'bedrooms' => get_post_meta( $property->ID, '_property_bedrooms', true ),
		            	'bathrooms' => get_post_meta( $property->ID, '_property_bathrooms', true ),
		            	'parking' => get_post_meta( $property->ID, '_property_parking', true ),

		            );

		            $sl_properties_data[] = $sl_property_data;

		            $sl_counter++;

					if ( 1 === $sl_counter ) {
						$gmap_map_settings['lat'] = ( !empty( $opt_map_lat ) ? $opt_map_lat : $sl_property_data['lat'] );
						$gmap_map_settings['lng'] = ( !empty( $opt_map_lng ) ? $opt_map_lng : $sl_property_data['lng'] );
					}
					
					$gmap_map_settings['zoom'] = $map_zoom;
					$gmap_map_settings['iconWidth'] = $marker_width;
					$gmap_map_settings['iconHeight'] = $marker_height;
					$gmap_map_settings['m1'] = $m1;
					$gmap_map_settings['m2'] = $m2;
					$gmap_map_settings['m3'] = $m3;
					$gmap_map_settings['m4'] = $m4;
					$gmap_map_settings['m5'] = $m5;
				}

				$this->add_render_attribute( 'properties-gmap', 'data-settings', wp_json_encode( $gmap_map_settings ) );
				$this->add_render_attribute( 'properties-gmap', 'data-properties', wp_json_encode( $sl_properties_data ) );

			} else {

		        $broken_marker = SL_PLUGIN_URL . 'public/images/map-nothing-found.png';

                $sl_property_data['post_id'] = 'notFound';
                $sl_property_data['broken_icon'] = $broken_marker;

                $sl_properties_data[] = $sl_property_data;

				$gmap_map_settings['lat'] = ( !empty( $opt_map_lat ) ? $opt_map_lat : 30.277762 );
				$gmap_map_settings['lng'] = ( !empty( $opt_map_lng ) ? $opt_map_lng : 66.5421775 );
				$gmap_map_settings['zoom'] = $map_zoom;
				$gmap_map_settings['iconWidth'] = $marker_width;
				$gmap_map_settings['iconHeight'] = $marker_height;
				$gmap_map_settings['m1'] = $m1;
				$gmap_map_settings['m2'] = $m2;
				$gmap_map_settings['m3'] = $m3;
				$gmap_map_settings['m4'] = $m4;
				$gmap_map_settings['m5'] = $m5;

				$this->add_render_attribute( 'properties-gmap', 'data-settings', wp_json_encode( $gmap_map_settings ) );
				$this->add_render_attribute( 'properties-gmap', 'data-properties', wp_json_encode( $sl_properties_data ) );
			}
		    
		?>

			<div id="sl_properties_gmap" <?php echo $this->get_render_attribute_string('properties-gmap'); ?>></div>

		</div>
    	<?php
	}
}