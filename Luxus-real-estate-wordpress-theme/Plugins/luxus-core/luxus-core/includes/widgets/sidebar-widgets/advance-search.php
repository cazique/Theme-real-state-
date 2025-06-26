<?php

//Advance Search Widget
class luxus_advance_search extends WP_Widget {
	
	function __construct() {
		parent::__construct(
			'luxus_advance_search', // Base ID
			__('Advance Search', 'luxus-core'), // Name
			array('description' => __('Displays Advance Search On Sidebar.', 'luxus-core'))
		);
	}

	function widget($args, $instance) { //output
		extract( $args );
		// these are the widget options
		$title = apply_filters('widget_title', $instance['title']);
		$slug = empty( $instance['slug'] ) ? '' : $instance['slug'];

		echo $before_widget;
		// Check if title is set
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		$this->luxus_advance_search_widget($slug);
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['slug'] = strip_tags($new_instance['slug']);
		return $instance;
	}	
    
    // widget form creation
	function form($instance) {

	// Check values
	if( $instance) {
		$title = esc_attr($instance['title']);
		$slug = esc_attr($instance['slug']);
	} else {
		$title = '';
		$slug = '';
	}

	?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'luxus-core'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id('slug'); ?>"><?php _e('Page Slug', 'luxus-core'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('slug'); ?>" name="<?php echo $this->get_field_name('slug'); ?>" type="text" value="<?php echo esc_attr($slug); ?>" />
		</p>

	<?php

	}
	
	function luxus_advance_search_widget() { //html

		wp_enqueue_script('jquery-ui-slider');
		wp_enqueue_style( 'jquery-ui', SL_PLUGIN_URL . 'public/css/jquery-ui.min.css','1.12.1', 'all' );
		
		//Property Status Texonomy
		$property_status = get_terms(array('taxonomy'=>'property_status'));

		//Property Cities Texonomy
		$property_cities = get_terms(array('taxonomy'=>'property_city'));

		//Property Type Texonomt
		$property_types = get_terms(array('taxonomy'=>'property_type'));

		//Property Features Texonomt
		$property_features = get_terms(array('taxonomy'=>'property_feature'));

		$meta_query = array();
		$tax_query = array();

		//Search By Title
		if( isset( $_GET['search_title'] ) AND !empty( $_GET['search_title'] ) ) {
		    $search_title = $_GET['search_title'];
		}
		else {
		   $search_title = '';    
		}

		// Status
		if( isset( $_GET['property_status'] ) AND !empty( $_GET['property_status'] ) ) {
		    $sl_property_status = $_GET['property_status'];
		    $tax_query [] = array(
		        'taxonomy'  => 'property_status',
		        'terms'     => $_GET['property_status'],
		        'field'     => 'slug',
		        'operator'  => 'IN'
		    );
		}else{
		    $sl_property_status = '';
		}

		// Type
		if( isset( $_GET['property_type'] ) AND !empty( $_GET['property_type'] ) ) {
		    $sl_property_type = $_GET['property_type'];
		    $tax_query [] = array(
		        'taxonomy'  => 'property_type',
		        'terms'     => $_GET['property_type'],
		        'field'     => 'slug',
		        'operator'  => 'IN'
		    );
		}else{
		    $sl_property_type = '';
		}

		// Location
		if( isset( $_GET['property_city'] ) AND !empty( $_GET['property_city'] ) ) {
		    $sl_property_city = $_GET['property_city'];
		    $tax_query [] = array(
		        'taxonomy'  => 'property_city',
		        'terms'     => $_GET['property_city'],
		        'field'     => 'slug',
		        'operator'  => 'IN'
		    );
		}else{
		    $sl_property_city = '';
		}

		// Bedrooms
		if( isset( $_GET['bedrooms'] ) AND !empty( $_GET['bedrooms'] ) ) {
		    $sl_bedrooms = $_GET['bedrooms'];
		    $meta_query [] =   array(
		        'key'       => '_property_bedrooms',
		        'value'     =>  $_GET['bedrooms'],
		        'compare'   => '='
		    );
		}else{
		    $sl_bedrooms = '';
		}

		// Bathrooms
		if( isset( $_GET['bathrooms'] ) AND !empty( $_GET['bathrooms'] ) ) {
		    $sl_bathrooms = $_GET['bathrooms'];
		    $meta_query [] =   array(
		        'key'       => '_property_bathrooms',
		        'value'     =>  $_GET['bathrooms'],
		        'compare'   => '='
		    );
		}else{
		    $sl_bathrooms = '';
		}

		// Build Year
		if( isset( $_GET['build_year'] ) AND !empty( $_GET['build_year'] ) ) {
		    $sl_build_year = $_GET['build_year'];
		    $meta_query [] =   array(
		        'key'       => '_property_build',
		        'value'     =>  $_GET['build_year'],
		        'compare'   => '='
		    );
		}else{
		    $sl_build_year = '';
		}

		// Min Area
		if( isset( $_GET['min_area'] ) AND !empty( $_GET['min_area'] ) ) {
		    $min_area = $_GET['min_area'];
		}else{
		    $min_area = 0;
		}
		// Max Area
		if( isset( $_GET['max_area'] ) AND !empty( $_GET['max_area'] ) ) {
		    $max_area = $_GET['max_area'];
		}else{
		    $max_area = 999999999;
		}
		// Min - Max Area
		$meta_query [] =   array(
		    'key'       => '_property_area',
		    'type'      => 'NUMERIC',
		    'value'     =>  array( $min_area, $max_area ),
		    'compare'   => 'BETWEEN'
		);

		// Min Price
		if( isset( $_GET['min_price'] ) AND !empty( $_GET['min_price'] ) ) {
		    $min_price = $_GET['min_price'];
		}else{
		    $min_price = 0;
		}
		// Max Price
		if( isset( $_GET['max_price'] ) AND !empty( $_GET['max_price'] ) ) {
		    $max_price = $_GET['max_price'];
		}else{
		    $max_price = 999999999;
		}
		// Min - Max Price
		$meta_query [] =   array(
		    'key'       => '_property_price',
		    'type'      => 'NUMERIC',
		    'value'     =>  array( $min_price, $max_price ),
		    'compare'   => 'BETWEEN'
		);

		// Property Amenity
		if( isset( $_GET['property_amenty'] ) AND !empty( $_GET['property_amenty'] ) ) {
		    $property_feature = array_values( $_GET['property_amenty'] );
		     
		    $tax_query [] = array(
		        'taxonomy' => 'property_feature',
		        'terms' => $property_feature,
		        'field' => 'slug',
		        'operator' => 'IN'
		    );
		}else{
		    $property_feature = array();
		}

 	?>

	<!-- Advance Search Form Start -->

	<?php $page_slug = !empty($slug) ? $slug : 'properties'; ?>
	
	<form action="<?php echo esc_url( site_url($page_slug) ); ?>" method="GET" novalidate="novalidate">
	    <!-- Advance Search Main Bar Start -->
        <div class="sl-advance-search">
            <div class="row gx-3">
                <div class="col-lg-12 col-md-12">
                    <input type="text" name="search_title" value="<?php echo esc_attr( isset($_GET['search_title']) ? $search_title : NULL ); ?>" class="form-control" placeholder="<?php esc_html_e('Search properties by title ...', 'luxus-core')?>">
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="sl-select">
                        <select name="property_status" class="form-control" title="<?php esc_html_e('Select Status', 'luxus-core')?>">
                            <option value=""><?php esc_html_e('Select Status', 'luxus-core')?></option>
                            <?php 
                                if($property_status != NULL) {
                                    foreach ($property_status as $status) {
                            ?>
                                    <option value="<?php echo esc_attr($status->slug); ?>" <?php echo esc_attr( $sl_property_status == $status->slug ? 'selected' : '' ); ?>>
                                        <?php echo esc_html($status->name); ?>
                                    </option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="sl-select">
                        <select name="property_type" class="form-control" title="<?php esc_html_e('Select Type', 'luxus-core')?>">
                            <option value=""><?php esc_html_e('Select Type', 'luxus-core')?></option>
                            <?php 
                                if($property_types != NULL) {
                                    foreach ($property_types as $types) {
                            ?>
                                    <option value="<?php echo esc_attr( $types->slug ); ?>" <?php echo esc_attr( $sl_property_type == $types->slug ? 'selected' : '' ); ?>>
                                        <?php echo esc_html( $types->name ); ?>
                                    </option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
	                <div class="sl-select">
	                    <select name="property_city" id="property_city" class="form-control">
	                        <option value=""><?php esc_html_e('Select City', 'luxus-core')?></option>
	                        <?php 
		                        if($property_cities != NULL) {
		                            foreach ($property_cities as $city) {
		                    ?>
		                            <option value="<?php echo esc_attr( $city->name ); ?>" <?php echo esc_attr( $sl_property_city == $city->name ? 'selected' : '' ); ?>>
		                                <?php echo esc_html( $city->name ); ?>
		                            </option>
		                    <?php
		                            }
		                        }
	                       ?>
	                    </select>
	                </div>
	            </div>
	            <div class="col-lg-6 col-md-6">
	                <input type="number" name="min_area" value="<?php echo esc_attr(!empty( $_GET['min_area'] ) ? $min_area : NULL); ?>" class="form-control" placeholder="<?php esc_html_e('Min Area', 'luxus-core')?> (<?php echo luxus_area_units(); ?>)">
	            </div>
	            <div class="col-lg-6 col-md-6">
	                <input type="number" name="max_area" value="<?php echo esc_attr(!empty( $_GET['max_area'] ) ? $max_area : NULL); ?>" class="form-control" placeholder="<?php esc_html_e('Max Area', 'luxus-core')?> (<?php echo luxus_area_units(); ?>)">
	            </div>
	            <div class="col-lg-6 col-md-6">
	                <input type="number" name="bedrooms" value="<?php echo esc_attr(isset( $_GET['bedrooms'] ) ? $sl_bedrooms : NULL); ?>" class="form-control" placeholder="<?php esc_html_e('Bedrooms', 'luxus-core')?>">
	            </div>
	            <div class="col-lg-6 col-md-6">
	                <input type="number" name="bathrooms" value="<?php echo esc_attr(isset( $_GET['bathrooms'] ) ? $sl_bathrooms : NULL); ?>" class="form-control" placeholder="<?php esc_html_e('Bathrooms', 'luxus-core')?>">
	            </div>
	            <div class="col-lg-6 col-md-6">
	            	<div id="min_max_price">
	                <input type="number" name="min_price" value="<?php echo esc_attr(!empty( $_GET['min_price'] ) ? $min_price : NULL); ?>" class="min_price form-control" placeholder="<?php esc_html_e('Min Price', 'luxus-core')?> (<?php echo luxus_currency_symbol(); ?>)">
	                </div>
	            </div>
	            <div class="col-lg-6 col-md-6">
	            	<div id="min_max_price" >
	                <input type="number" name="max_price" value="<?php echo esc_attr(!empty( $_GET['max_price'] ) ? $max_price : NULL); ?>" class="max_price form-control" placeholder="<?php esc_html_e('Max Price', 'luxus-core')?> (<?php echo luxus_currency_symbol(); ?>)">
	            	</div>
	            </div>
	            <div class="col-lg-12 col-md-12">
		            <div id="price_range">
		                <label><?php esc_html_e('Price Range:', 'luxus-core')?></label>
		                <?php echo luxus_currency_symbol(); ?><span id="min_price_output_widget"></span> - 
		                <?php echo luxus_currency_symbol(); ?><span id="max_price_output_widget"></span>
		                <div id="sl_price_range_widget"></div>
		            </div>
	            </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="submit_btn input-group ">
                        <i class="adv-search-btn-widget sl-icon sl-settings"></i>
                        <button type="submit" class="sl-btn search-btn"><?php esc_html_e('Search', 'luxus-core')?></button>
                    </div>
                </div>
            </div>
        </div>
	    <!-- Advance Search Main Bar End -->

	    <!-- Advance Search Fields Start -->
	    <div class="advance-search-opt-widget">
            <p class="features heading"><?php esc_html_e('Amenities', 'luxus-core')?></p>
            <ul class="pro-amu-list">
                <?php 
                if($property_features != NULL) {
                    foreach($property_features as $single_feature) {   
                ?>
			            <li>
			                <label>
			                    <input type="checkbox" name="property_amenty[]" value="<?php echo esc_attr($single_feature->name); ?>" <?php echo esc_attr(in_array( $single_feature->name, $property_feature ) ? "checked='checked'" : NULL); ?>> 
			                    <span class="label-text"><?php echo esc_html($single_feature->name); ?></span>
			                </label>
			            </li>
                <?php            
                    }    
                }
                ?>
            </ul>
            <input type="hidden" name="sort_by" value="new" />
	    </div>
	    <!-- Advance Search Fields End -->
	</form>
	<!-- Advance Search Form End -->

	<?php

	$min_val = !empty($_GET['min_price']) ? $_GET['min_price'] : 0;
	$max_val = !empty($_GET['max_price']) ? $_GET['max_price'] : 500000;

	// jQuery UI Script
	wp_register_script( 'luxus-advance-search-widget-slider', '', array("jquery"), '', true );
    wp_enqueue_script( 'luxus-advance-search-widget-slider'  );
    
    wp_add_inline_script( 'luxus-advance-search-widget-slider', '
		(function($){
			"use strict";
			$(function () {

			    var min_max_values = ['. $min_val .', '. $max_val .'];

			    $("#sl_price_range_widget").slider({
			        range: true,
			        min: 0,
			        max: 1000000,
			        values: min_max_values,
			        slide: function(event, ui) {
			            //return false;
			            if ((ui.values[1] - ui.values[0]) < 5) {
			                return false;
			            }
			            $("#min_price_output_widget").text(ui.values[0]);
			            $("#max_price_output_widget").text(ui.values[1]);

			            $( ".min_price" ).val(ui.values[0]);
			            $( ".max_price" ).val(ui.values[1]);
			        },
			        create: function(event, ui) {
			            $("#min_price_output_widget").text(min_max_values[0]);
			            $("#max_price_output_widget").text(min_max_values[1]);
			        }
			    }).trigger("slide");
			});
		})(jQuery);
    ');

	}
	
} //end class luxus_advance_search

// Registering Mortgage Calculator Widget
add_action( 'widgets_init', 'luxus_register_advance_search_widget' );
function luxus_register_advance_search_widget() {

	register_widget('luxus_advance_search');

}