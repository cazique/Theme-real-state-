<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * Template Name: Compare Properties
 */

// Custom Page Title
function luxus_compare_properties_page_title() {
    return esc_html__('Compair Properties', 'luxus-core') . ' - ' . get_bloginfo();
}
add_action( 'pre_get_document_title', 'luxus_compare_properties_page_title' );

if( !isset( $_COOKIE['luxus_compare_prop'] ) ) {
  echo wp_redirect(site_url('/'));
  exit();
}

$data = $_COOKIE['luxus_compare_prop'];
$exploded_data = explode('|',$data);
$exploded_data = array_filter($exploded_data);

get_header();

?>
<div class="compare-content">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <section class="sl-properties-comparison-table">
          <div class="sl-properties-table">
            <div class="features">
              <?php
                //FETCHING THE AMENITIES
                $default_features = get_terms([
                      'taxonomy' => 'property_feature',
                      'hide_empty' => false,
                  ]);
              ?>
                <div class="top-info"><?php esc_html_e('PROPERTIES', 'luxus-core'); ?></div>
                <ul class="sl-features-list">
                    <li><?php esc_html_e('Property ID', 'luxus-core'); ?></li>
                    <li><?php esc_html_e('Status', 'luxus-core'); ?></li>
                    <li><?php esc_html_e('Type', 'luxus-core'); ?></li>
                    <li><?php esc_html_e('Area Size', 'luxus-core'); ?></li>
                    <li><?php esc_html_e('Lot Size', 'luxus-core'); ?></li>
                    <li><?php esc_html_e('Built Year', 'luxus-core'); ?></li>
                    <li><?php esc_html_e('Parking', 'luxus-core'); ?></li>
                    <li><?php esc_html_e('Bedrooms', 'luxus-core'); ?></li>
                    <li><?php esc_html_e('Bathrooms', 'luxus-core'); ?></li>
                    <?php 
                      if($default_features != NULL):
                        foreach ($default_features as $single_feature):
                    ?>
                             <li><?php echo $single_feature->name; ?></li> 
                    <?php      
                        endforeach;
                      endif;
                    ?>
                     <li>Action</li>
                </ul>
            </div> <!-- .features -->
              
            <div class="sl-properties-wrapper">
                <ul class="sl-properties-columns">
                <?php 
                  foreach ( $exploded_data as $single_id ) {

                    //Post Data
                    $data_post = get_post( $single_id );

                    $luxus_badge = get_post_meta( $single_id, 'property_label',TRUE );
                    $property_price = get_post_meta( $single_id, '_property_price',TRUE );
                    $property_price_prefix = get_post_meta( $single_id, '_property_price_prefix',TRUE );
                    $property_price_postfix = get_post_meta( $single_id, '_property_price_postfix',TRUE );
                    $property_area = get_post_meta( $single_id, '_property_area',TRUE );
                    $property_larea = get_post_meta( $single_id, '_property_larea',TRUE );
                    $property_build = get_post_meta( $single_id, '_property_build',TRUE );
                    $property_area_postfix = get_post_meta( $single_id, '_property_area_postfix',TRUE );
                    $property_larea_postfix  = get_post_meta( $single_id, '_property_larea_postfix',TRUE );
                    $property_address = get_post_meta( $single_id, '_property_address',TRUE );
                    $property_bedrooms = get_post_meta( $single_id, '_property_bedrooms',TRUE );
                    $property_bathrooms = get_post_meta( $single_id, '_property_bathrooms',TRUE );
                    $property_parking   = get_post_meta( $single_id, '_property_parking',TRUE );

    								$thumb_placeholder = SL_PLUGIN_URL . 'public/images/agency-cover1.jpg';
    								$property_thumb = get_the_post_thumbnail_url( $single_id,'luxus-thumb-md');
    								$property_thumb_url = ( !empty($property_thumb) ? $property_thumb : $thumb_placeholder );

                    $property_status = get_the_terms( $single_id, 'property_status' );
                    $property_types = get_the_terms( $single_id, 'property_type' );
                    $property_features = get_the_terms( $single_id ,'property_feature' );

                    if( $property_status != NULL ) {

                        $label_status =  'For '.$property_status[0]->name;

                    } else {

                        $label_status = '';
                    }

                ?>
                    <li class="product">
                        <div class="top-info">
                          <a href="<?php echo esc_url($data_post->guid); ?>"><img src="<?php echo esc_url($property_thumb_url); ?>" alt="<?php echo esc_attr(!empty($data_post->post_title) ? $data_post->post_title : ''); ?>"></a>
                          <h5 class="title"><?php echo esc_html(!empty($data_post->post_title) ? $data_post->post_title : ''); ?></h5>
                          <?php 
                            if( !empty( $property_price ) ):
                              echo '<p class="price">'; 
                              if( $property_price_prefix != NULL ) {
                                  echo '<span class="price-prefix">' . esc_html($property_price_prefix) . '</span> ';
                              }

                              echo esc_html(luxus_currency_symbol()) . esc_html($property_price);

                              if( $property_price_postfix != NULL ) {
                                  echo '<span class="price-postfix"> - ' . esc_html($property_price_postfix) . '</span>';
                              }
                              echo '</p>';
                            endif;
                          ?>
                        </div> <!-- .top-info -->
                        <ul class="sl-features-list">
                          <li><?php echo esc_html($single_id); ?></li>
                          <li><?php echo esc_html(!empty( $label_status ) ? $label_status : '-'); ?></li>
                          <li><?php echo esc_html(!empty( $property_types[0]->name ) ? $property_types[0]->name : '-'); ?></li>
                          <li><?php echo esc_html($property_area).'/'.esc_html(luxus_area_units()); ?></li>
                          <li><?php echo esc_html($property_larea).'/'.esc_html(luxus_area_units()); ?></li>
                          <li><?php echo esc_html(!empty( $property_build ) ? $property_build : '-'); ?></li>
                          <li><?php echo esc_html(!empty( $property_bedrooms ) ? $property_bedrooms : '-'); ?></li>
                          <li><?php echo esc_html(!empty( $property_bathrooms ) ? $property_bathrooms : '-'); ?></li>
                          <li><?php echo esc_html(!empty( $property_parking ) ? $property_parking : '-'); ?></li>

                          <?php
                          if( $default_features != NULL ) {
                            foreach ($default_features as $default_feature) {
                              $found = 'no';

                              if ($property_features != NULL) {

                                foreach ( $property_features as $assigned_feature ) {
                                  if( $default_feature->name == $assigned_feature->name ) {
                                    $found = 'yes';
                                    break;
                                  }
                                }
                              }
                                       
                              if( $found == 'yes' ) {
                                echo '<li><i class="sl-icon sl-check"></i></li>';
                              } else {
                                echo '<li><i class="sl-icon sl-cross"></i></li>';
                              }   
                            }
                          }
                          ?>

                          <li><a href="<?php echo esc_url(admin_url('admin-ajax.php/?delete_compare_property=delete_cookie&property_id='.$single_id)); ?>"> Delete </a></li>
                        </ul>
                    </li> <!-- .product -->
                  <?php 
                    }
                  ?>
                </ul> <!-- .sl-properties-columns -->
            </div> <!-- .sl-properties-wrapper -->
          </div> <!-- .sl-properties-table -->
        </section> <!-- .sl-properties-comparison-table -->
      </div>
    </div>
  </div>
</div>
<!-- page-wrapper -->
<?php
get_footer();
