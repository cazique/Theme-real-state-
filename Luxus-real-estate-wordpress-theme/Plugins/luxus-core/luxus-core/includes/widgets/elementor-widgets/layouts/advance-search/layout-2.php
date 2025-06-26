<?php ?>

<!-- Advance Search Form Start -->

<form action="<?php echo esc_url( site_url( $action_slug ) ); ?>" method="GET" novalidate="novalidate">
    <!-- Advance Search Main Bar Start -->
    <div class="sl-advance-search-outer">
        <div class="sl-advance-search fotm-vertical">
            <div class="row sl-m0">
                <?php

                    $form_description = $settings['search_form_description'];

                    if (!empty($form_description)) {

                         echo '<div class="col-lg-12 form-description">' . $form_description .'</div>';
                    }

                ?>
                <div class="col-lg-12">
                    <input type="text" name="search_title" class="form-control" placeholder="<?php esc_attr_e('Enter Keywords ...', 'luxus-core') ?>">
                </div>
                <div class="col-lg-12">
                    <div class="sl-select property_status">
                        <select name="property_status" class="form-control" title="<?php esc_attr_e('Select Status', 'luxus-core') ?>">
                            <option value=""><?php esc_attr_e('Select Status', 'luxus-core') ?></option>
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
                <div class="col-lg-12">
                    <div class="sl-select property_type">
                        <select name="property_type" class="form-control" title="<?php esc_attr_e('Select Type', 'luxus-core') ?>">
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
                <div class="col-lg-12">
                    <div class="sl-select property_cities">
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
                <div class="col-lg-6">
                    <input type="number" name="min_area" class="form-control" placeholder="<?php esc_attr_e('Min Area', 'luxus-core') ?> (<?php echo luxus_area_units(); ?>)">
                </div>
                <div class="col-lg-6">
                    <input type="number" name="max_area" class="form-control" placeholder="<?php esc_attr_e('Max Area', 'luxus-core') ?> (<?php echo luxus_area_units(); ?>)">
                </div>
                <div class="col-lg-12">
                    <button type="submit" class="sl-btn search-btn"><?php echo esc_html(!empty($form_btn_text) ? $form_btn_text : __('Search', 'luxus-core')); ?></button>
                </div>
            </div>
        </div>
    </div>
    <!-- Advance Search Main Bar End -->
</form>
<!-- Advance Search Form End -->
