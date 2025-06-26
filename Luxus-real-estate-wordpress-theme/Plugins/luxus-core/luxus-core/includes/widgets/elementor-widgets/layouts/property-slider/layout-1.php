<?php 

$user_id = '';
$get_user_data = '';

if(is_user_logged_in())
{
    // Loged in User Id
    $user_id    =  get_current_user_id();

    // User Meta
    $get_user_data = get_user_meta( $user_id, '_luxus_user_favourite_properties', TRUE);
}

$property_thumb = get_the_post_thumbnail_url( get_the_ID(),'luxus-thumb-lg');
$thumb_placeholder = SL_PLUGIN_URL . 'public/images/agency-cover1.jpg';
$property_thumb_url = ( !empty($property_thumb) ? $property_thumb : $thumb_placeholder );

// Property Meta Boxes
$property_label = luxus_post_meta( '_property_label' );
$_property_type = luxus_post_meta( '_property_type' );
$property_type = !empty( $_property_type ) ? get_term( $_property_type, 'property_type' ) : null;
$_property_status = luxus_post_meta( '_property_status' );
$property_status = !empty( $_property_status ) ? get_term( $_property_status, 'property_status' ) : null;
$property_price = luxus_post_meta( '_property_price' );
$property_price_prefix = luxus_post_meta( '_property_price_prefix' );
$property_price_postfix = luxus_post_meta( '_property_price_postfix' );
$property_bedrooms = luxus_post_meta( '_property_bedrooms' );
$property_bathrooms = luxus_post_meta( '_property_bathrooms' );
$property_parking = luxus_post_meta( '_property_parking' );
$property_area = luxus_post_meta( '_property_area' );
$property_area_postfix = luxus_post_meta( '_property_area_postfix' );
$property_address = luxus_post_meta( '_property_st_address' );
$property_city = luxus_post_meta( '_property_city' );

?>

<div class="property-item sl-property-slider" style="background-image: url('<?php echo esc_url($property_thumb_url); ?>');">
    <div class="property-slider-overlay"></div>
    <div class="property-slider-content ">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="slider-content animated <?php echo esc_attr($settings['slider_content_animate']); ?>">
                        <div class="top">
                            <?php if( $property_type != NULL ):

                                // Property Type Color
                                $type_meta = get_term_meta( $_property_type, 'property_type_options', true );
                                $type_color = isset($type_meta['type_color']) ? $type_meta['type_color'] : '';

                            ?>
                                <a href="<?php echo esc_url(get_term_link( $property_type->term_id )); ?>" class="type" <?php if (!empty($type_color)) { echo 'style="background-color:'.$type_color.';"'; } ?>><?php echo esc_html($property_type->name); ?></a>
                            <?php endif;

                            if( $property_status != NULL ):

                                // Property Status Color
                                $status_meta = get_term_meta( $_property_status, 'property_status_options', true );
                                $status_color = isset($status_meta['status_color']) ? $status_meta['status_color'] : '';

                            ?>
                                <a href="<?php echo esc_url(get_term_link( $property_status->term_id )); ?>" class="status" <?php if (!empty($status_color)) { echo 'style="background-color:'.$status_color.';"'; } ?>><?php echo __('For', 'luxus-core') . ' ' . esc_html($property_status->name); ?></a>
                            <?php endif; ?>
                        </div>

                        <h2 class="title"><?php the_title(); ?></h2>

                        <div class="features">
                            <span><i class="sl-icon sl-bedroom"></i><?php echo esc_html( !empty( $property_bedrooms ) ? $property_bedrooms : __('NA', 'luxus-core') ); ?></span>
                            <span><i class="sl-icon sl-bathroom"></i><?php echo esc_html( !empty( $property_bathrooms ) ? $property_bathrooms : __('NA', 'luxus-core') ); ?></span>
                            <span><i class="sl-icon sl-car"></i><?php echo esc_html( !empty( $property_parking ) ? $property_parking : __('NA', 'luxus-core') ); ?></span>
                        </div>

                        <div class="area-price">
                        <?php 
                            // Area
                            if( $property_area != NULL ):
                                echo '<span class="area">';
                                echo esc_html($property_area) . ' ' . esc_html(luxus_area_units());
                                if( $property_area_postfix != NULL ) {
                                    echo ' ' . esc_html($property_area_postfix);
                                }
                                echo '</span>';
                            endif;

                            // Price
                            if( $property_price != NULL ):
                                echo '<span class="price">';
                                if( $property_price_prefix != NULL ) {
                                    echo esc_html($property_price_prefix) . ' ';
                                }

                                echo esc_html(luxus_currency_symbol()) . esc_html($property_price);

                                if( $property_price_postfix != NULL ) {
                                    echo ' - ' . esc_html($property_price_postfix). ' ';
                                }
                                echo '</span>';
                            endif;
                        ?>
                        </div>

                        <a href="<?php the_permalink() ?>" class="more"><?php esc_html_e('Learn More ', 'luxus-core') ?><i class="sl-icon sl-next-arrow"></i></a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
