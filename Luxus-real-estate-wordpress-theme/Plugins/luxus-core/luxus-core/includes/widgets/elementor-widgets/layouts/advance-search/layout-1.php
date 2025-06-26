<?php ?>

<!-- Advance Search Form Start -->

<form action="<?php echo esc_url( site_url( $action_slug ) ); ?>" method="GET" novalidate="novalidate">
    <!-- Advance Search Main Bar Start -->
    <div class="sl-advance-search-outer">
        <div class="sl-advance-search">
            <div class="row sl-m0">
                <div class="col-lg-6 col-md-12">
                    <input type="text" name="search_title" class="form-control sl-search-input" placeholder="<?php esc_attr_e('Search properties by title ...', 'luxus-core') ?>">
                </div>
                <div class="col-lg-2 col-md-12 sl-p0">
                    <div class="sl-select property_status">
                        <select name="property_status" class="form-control sl-search-input" title="<?php esc_attr_e('Select Status', 'luxus-core') ?>">
                            <option value=""><?php esc_html_e('Select Status', 'luxus-core') ?></option>
                            <?php 
                                if($property_status != NULL)
                                {
                                    foreach ($property_status as $status) 
                                    {
                            ?>
                                        <option value="<?php echo esc_attr($status->slug); ?>">
                                            <?php echo esc_html($status->name); ?>
                                        </option>
                            <?php
                                    }
                                }
                           ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-12 sl-p0">
                    <div class="sl-select property_type">
                        <select name="property_type" class="form-control sl-search-input" title="<?php esc_attr_e('Select Type', 'luxus-core') ?>">
                            <option value=""><?php esc_html_e('Select Type', 'luxus-core') ?></option>
                            <?php 
                                if($property_types != NULL)
                                {
                                    foreach ($property_types as $types) 
                                    {
                            ?>
                                        <option value="<?php echo esc_attr($types->slug); ?>">
                                            <?php echo esc_html($types->name); ?>
                                        </option>
                            <?php
                                    }
                                }
                           ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-12 sl-p0">
                    <div class="btn-group">
                      <i class="adv-search-btn sl-icon sl-settings"></i>
                      <button type="submit" class="sl-btn search-btn"><?php echo esc_html(!empty($form_btn_text) ? $form_btn_text : __('Search', 'luxus-core')); ?></button>
                    </div>
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
                        <option value=""><?php esc_html_e('Select City', 'luxus-core') ?></option>
                        <?php 
                        if($property_cities != NULL)
                        {
                            foreach ($property_cities as $city) 
                            {
                        ?>
                                <option value="<?php echo esc_attr($city->name); ?>">
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
                <input type="number" name="min_area" class="form-control" placeholder="<?php esc_attr_e('Min Area', 'luxus-core') ?> (<?php echo luxus_area_units(); ?>)">
            </div>
            <div class="col-lg-4">
                <input type="number" name="max_area" class="form-control" placeholder="<?php esc_attr_e('Max Area', 'luxus-core') ?> (<?php echo luxus_area_units(); ?>)">
            </div>
        </div>
        <div class="row gx-3">
            <div class="col-lg-4">
                <input type="number" name="bedrooms" class="form-control" placeholder="<?php esc_attr_e('Bedrooms', 'luxus-core') ?>">
            </div>
            <div class="col-lg-4">
                <input type="number" name="bathrooms" class="form-control" placeholder="<?php esc_attr_e('Bathrooms', 'luxus-core') ?>">
            </div>
            <div class="col-lg-4">
                <input type="number" name="build_year" class="form-control" placeholder="<?php esc_attr_e('Built Year', 'luxus-core') ?>">
            </div>
        </div>
        <div id="min_max_price" class="row">
            <div class="col-lg-6">
                <input type="number" name="min_price" value="" class="min_price form-control" placeholder="<?php esc_attr_e('Min Price', 'luxus-core') ?> (<?php echo luxus_currency_symbol(); ?>)">
            </div>
            <div class="col-lg-6">
                <input type="number" name="max_price" value="" class="max_price form-control" placeholder="<?php esc_attr_e('Max Price', 'luxus-core') ?> (<?php echo luxus_currency_symbol(); ?>)">
            </div>
        </div>
        <div id="price_range" class="row">
            <div class="col-lg-12">
                <label><?php esc_html_e('Price Range:', 'luxus-core')?></label>
                <?php echo luxus_currency_symbol(); ?><span id="min_price_output"></span> - 
                <?php echo luxus_currency_symbol(); ?><span id="max_price_output"></span>
                <div id="sl_price_range"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <p class="features heading"><?php echo esc_html_e('Amenities', 'luxus-core'); ?></p>
                <ul class="pro-amu-list">
                    <?php 
                        if($Property_features != NULL)
                        {
                            foreach($Property_features as $single_feature)
                            {   
                    ?>
                    <li>
                        <label>
                            <input type="checkbox" name="property_amenty[]" value="<?php echo esc_attr($single_feature->name); ?>"> 
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
        </div>
    </div>
    <!-- Advance Search Fields End -->
</form>
<!-- Advance Search Form End -->


<?php

    // jQuery UI Script
    wp_register_script( 'luxus-advance-search-slider', '', array("jquery"), '', true );
    wp_enqueue_script( 'luxus-advance-search-slider'  );

    wp_add_inline_script( 'luxus-advance-search-slider', '
        (function($){
            "use strict";
            jQuery(document).ready(function () {

                var min_max_values = [0, 500000];

                $("#sl_price_range").slider({
                    range: true,
                    min: 0,
                    max: 1000000,
                    values: min_max_values,
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
                        $("#min_price_output").text(min_max_values[0]);
                        $("#max_price_output").text(min_max_values[1]);
                    }
                }).trigger("slide");
            });
        })(jQuery);
    ');

?>