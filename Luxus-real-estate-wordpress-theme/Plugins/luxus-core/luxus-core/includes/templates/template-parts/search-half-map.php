<?php

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
} else {
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
} else {
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
} else {
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
} else {
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
} else {
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
} else {
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
} else {
    $sl_build_year = '';
}

// Min Area
if( isset( $_GET['min_area'] ) AND !empty( $_GET['min_area'] ) ) {
    $min_area = $_GET['min_area'];
} else {
    $min_area = 0;
}

// Max Area
if( isset( $_GET['max_area'] ) AND !empty( $_GET['max_area'] ) ) {
    $max_area = $_GET['max_area'];
} else {
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
} else {
    $min_price = 0;
}

// Max Price
if( isset( $_GET['max_price'] ) AND !empty( $_GET['max_price'] ) ) {
    $max_price = $_GET['max_price'];
} else {
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
} else {
    $property_feature = array();
}

?>

<!-- Advance Search Form Start -->

<form class="properties-search-form" action="<?php echo esc_url( get_the_permalink() ); ?>" method="GET" novalidate="novalidate">
    <!-- Advance Search Main Bar Start -->
    <div class="sl-advance-search">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <input type="text" name="search_title" value="<?php echo esc_attr(isset($_GET['search_title']) ? esc_attr($search_title) : NULL); ?>" class="form-control" placeholder="<?php esc_attr_e('Search properties by title ...', 'luxus-core'); ?>">
            </div>
        </div>
        <div class="row gx-3">
            <div class="col-lg-4 col-md-4">
                <div class="sl-select">
                    <select name="property_status" class="form-control" title="Select Status">
                        <option value=""><?php esc_html_e('Select Status', 'luxus-core'); ?></option>
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
            <div class="col-lg-4 col-md-4">
                <div class="sl-select">
                    <select name="property_type" class="form-control" title="<?php esc_attr_e('Select Type', 'luxus-core'); ?>">
                        <option value=""><?php esc_html_e('Select Type', 'luxus-core'); ?></option>
                        <?php 
                            if($property_types != NULL) {
                                foreach ($property_types as $types) {
                        ?>
                                    <option value="<?php echo esc_attr($types->slug); ?>" <?php echo esc_attr( $sl_property_type == $types->slug ? 'selected' : '' ); ?>>
                                        <?php echo esc_html($types->name); ?>
                                    </option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="btn-group">
                  <i class="adv-search-btn sl-icon sl-settings"></i>
                  <button type="submit" class="sl-btn search-btn"><?php esc_html_e('Search', 'luxus-core'); ?></button>
                </div>
            </div>
        </div>
    </div>
    <!-- Advance Search Main Bar End -->

    <!-- Advance Search Fields Start -->
    <div class="advance-search-opt">
        <div class="row gx-3">
            <div class="col-lg-4">
                <div class="sl-select">
                    <select name="property_city" id="property_cities" class="form-control">
                        <option value=""><?php esc_html_e('Select City', 'luxus-core'); ?></option>
                        <?php 
                        if($property_cities != NULL) {
                            foreach ($property_cities as $city) {
                        ?>
                                <option value="<?php echo esc_attr($city->name); ?>" <?php echo esc_attr( $sl_property_city == $city->name ? 'selected' : '' ); ?>>
                                    <?php echo esc_html($city->name); ?>
                                </option>
                        <?php
                            }
                        }
                       ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-4">
                <input type="text" name="min_area" value="<?php echo esc_attr(!empty( $_GET['min_area'] ) ? $min_area : NULL); ?>" class="form-control" placeholder="<?php esc_attr_e('Min Area', 'luxus-core'); ?> (<?php echo luxus_area_units(); ?>)">
            </div>
            <div class="col-lg-4">
                <input type="text" name="max_area" value="<?php echo esc_attr(!empty( $_GET['max_area'] ) ? $max_area : NULL); ?>" class="form-control" placeholder="<?php esc_attr_e('Max Area', 'luxus-core'); ?> (<?php echo luxus_area_units(); ?>)">
            </div>
        </div>
        <div class="row gx-3">
            <div class="col-lg-4">
                <input type="text" name="bedrooms" value="<?php echo esc_attr(isset( $_GET['bedrooms'] ) ? $sl_bedrooms : NULL); ?>" class="form-control" placeholder="<?php esc_attr_e('Bedrooms', 'luxus-core'); ?>">
            </div>
            <div class="col-lg-4">
                <input type="text" name="bathrooms" value="<?php echo esc_attr(isset( $_GET['bathrooms'] ) ? $sl_bathrooms : NULL); ?>" class="form-control" placeholder="<?php esc_attr_e('Bathrooms', 'luxus-core'); ?>">
            </div>
            <div class="col-lg-4">
                <input type="text" name="build_year" value="<?php echo esc_attr(isset( $_GET['build_year'] ) ? $sl_build_year : NULL); ?>" class="form-control" placeholder="<?php esc_attr_e('Built Year', 'luxus-core'); ?>">
            </div>
        </div>
        <div id="min_max_price" class="row">
            <div class="col-lg-6">
                <input type="text" name="min_price" value="<?php echo esc_attr(!empty( $_GET['min_price'] ) ? $min_price : NULL); ?>" class="min_price form-control" placeholder="<?php esc_attr_e('Min Price', 'luxus-core'); ?> (<?php echo luxus_currency_symbol(); ?>)">
            </div>
            <div class="col-lg-6">
                <input type="text" name="max_price" value="<?php echo esc_attr(!empty( $_GET['max_price'] ) ? $max_price : NULL); ?>" class="max_price form-control" placeholder="<?php esc_attr_e('Max Price', 'luxus-core'); ?> (<?php echo luxus_currency_symbol(); ?>)">
            </div>
        </div>
        <div id="price_range" class="row">
            <div class="col-lg-12">
                <label><?php esc_html_e('Price Range:', 'luxus-core'); ?></label>
                <?php echo luxus_currency_symbol(); ?><span id="min_price_output"></span> - 
                <?php echo luxus_currency_symbol(); ?><span id="max_price_output"></span>
                <div id="sl_price_range"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <p class="features heading"><?php esc_html_e('Amenities', 'luxus-core'); ?></p>
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
                <input type="hidden" name="save_search" value="yes" />
            </div>
        </div>
    </div>
    <!-- Advance Search Fields End -->
</form>
<!-- Advance Search Form End -->

<?php

$min_val = ( !empty($_GET['min_price']) ? $_GET['min_price'] : 0 );
$max_val = ( !empty($_GET['max_price']) ? $_GET['max_price'] : 500000 );

// Search Form UI Slider Script
wp_register_script( 'luxus-halfmap-form-slider', '', array("jquery"), '', true );
wp_enqueue_script( 'luxus-halfmap-form-slider'  );

wp_add_inline_script( 'luxus-halfmap-form-slider', '

    (function($){
        $(function () {

            var sl_value = ['. $min_val .', '. $max_val .'];

            $("#sl_price_range").slider({
                range: true,
                min: 0,
                max: 1000000,
                values: sl_value,
                slide: function(event, ui) {
                    //return false;
                    if ((ui.values[1] - ui.values[0]) < 5) {
                        return false;
                    }
                    $("#min_price_output").text(ui.values[0]);
                    $("#max_price_output").text(ui.values[1]);

                    $( ".min_price" ).val(ui.values[0]);
                    $( ".max_price" ).val(ui.values[1]);
                },
                create: function(event, ui) {
                    $("#min_price_output").text(sl_value[0]);
                    $("#max_price_output").text(sl_value[1]);
                }
            }).trigger("slide");

        });
    })(jQuery);

');
