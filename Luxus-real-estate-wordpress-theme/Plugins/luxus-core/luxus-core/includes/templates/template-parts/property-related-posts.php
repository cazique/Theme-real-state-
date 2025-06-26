<?php

// fetch taxonomy terms for current Property
$property_terms = get_the_terms( get_the_ID(), 'property_type' );

if( $property_terms ) {
     
    $property_term_names[] = 0;
             
    foreach( $property_terms as $property_term ) {  
         
        $property_term_names[] = $property_term->name;
     
    }
                 
    // set up the query arguments
    $args = array (
        'post_type' => 'property',
        'post_status' => 'publish',
	    'posts_per_page' => 2,
	    'orderby' => 'rand',
        'tax_query' => array(
            array(
                'taxonomy' => 'property_type',
                'field'    => 'slug',
                'terms'    => $property_term_names,
            ),
        ),
    );
     
    // run the query
    $related_posts = new WP_Query( $args ); 

    if( $related_posts->have_posts() ) {

		// Loop
    	while ( $related_posts->have_posts() ) : $related_posts->the_post();

			$property_thumb = get_the_post_thumbnail_url( get_the_ID(),'luxus-thumb-md');
			$thumb_placeholder = SL_PLUGIN_URL . 'public/images/agency-cover1.jpg';
			$property_thumb_url = ( !empty($property_thumb) ? $property_thumb : $thumb_placeholder );

			// Property Meta Boxes
			$property_label = luxus_post_meta( '_property_label' );
			$_property_type = luxus_post_meta( '_property_type' );
			$property_type = !empty( $_property_type ) ? get_term( $_property_type ) : null;
			$_property_status = luxus_post_meta( '_property_status' );
			$property_status = !empty( $_property_status ) ? get_term( $_property_status ) : null;
			$property_price = luxus_post_meta( '_property_price' );
			$property_price_prefix = luxus_post_meta( '_property_price_prefix' );
			$property_price_postfix = luxus_post_meta( '_property_price_postfix' );
			$property_bedrooms = luxus_post_meta( '_property_bedrooms' );
			$property_bathrooms = luxus_post_meta( '_property_bathrooms' );
			$property_parking = luxus_post_meta( '_property_parking' );
			$property_area = luxus_post_meta( '_property_area' );
			$property_area_postfix = luxus_post_meta( '_property_area_postfix' );
			$property_address = luxus_post_meta( '_property_st_address' );
			$_property_city = luxus_post_meta( '_property_city' );
			$property_city = !empty( $_property_city ) ? get_term( $_property_city ) : null;

    		?>
            <div class="sl-col col-md-6 col-lg-6">
                <div class="sl-item property-grid">
					<div class="image">
						<a href="<?php the_permalink(); ?>" class="view-detail"><i class="sl-icon sl-next-arrow"></i></a>
					    <img src="<?php echo $property_thumb_url; ?>">
					    <?php if( $property_label ): ?>
					        <div class="featured-ribbon"><span><?php esc_html_e('Featured', 'luxus-core'); ?></span></div> 
					    <?php endif; ?>
					    <div class="image-top">
					        <?php if( $property_type != NULL ):

					        	// Property Type Color
					            $type_meta_rel = get_term_meta( $_property_type, 'property_type_options', true );
					            $type_color_rel = isset($type_meta_rel['type_color']) ? $type_meta_rel['type_color'] : '';

					        ?>
					            <a href="<?php echo esc_url(get_term_link( $property_type->term_id )); ?>" class="type" <?php if (!empty($type_color_rel)) { echo 'style="background-color:'.$type_color_rel.';"'; } ?>><?php echo esc_html($property_type->name); ?></a>
					        <?php endif;

					        if( $property_status != NULL ):

					        	// Property Status Color
					            $status_meta_rel = get_term_meta( $_property_status, 'property_status_options', true );
					            $status_color_rel = isset($status_meta_rel['status_color']) ? $status_meta_rel['status_color'] : '';

					        ?>
					            <a href="<?php echo esc_url(get_term_link( $property_status->term_id )); ?>" class="status" <?php if (!empty($status_color_rel)) { echo 'style="background-color:'.$status_color_rel.';"'; } ?>><?php echo __('For', 'luxus-core') . ' ' . esc_html($property_status->name); ?></a>
					        <?php endif; ?>
					    </div>
					    <div class="image-bottom">
					        <div class="left">
					            <?php if( $property_area != NULL ): ?>
					                <p class="area">
					                    <?php
					                        echo esc_html($property_area) . ' ' . esc_html(luxus_area_units());
					                        if( $property_area_postfix != NULL ) {
					                            echo '<span class="area-postfix"> ' . esc_html($property_area_postfix) . '</span>';
					                        }
					                    ?>
					                </p>
					            <?php endif;

					            if( $property_price != NULL ): ?>
					                <p class="price">
					                    <?php 

					                    if( $property_price_prefix != NULL ) {
					                        echo '<span class="price-prefix">' . esc_html($property_price_prefix) . '</span> ';
					                    }

					                    echo esc_html(luxus_currency_symbol()) . esc_html($property_price);

					                    if( $property_price_postfix != NULL ) {
					                        echo '<span class="price-postfix"> ' . esc_html($property_price_postfix) . '</span>';
					                    }

					                    ?>
					                </p>
					            <?php endif; ?>
					        </div> 
					    </div>
					</div>
					<div class="property-info">
					    <div class="content">
					        <a href="<?php the_permalink(); ?>"><h6 class="title"><?php the_title(); ?></h6></a>
					        <p class="address"><i class="sl-icon sl-place"></i>
					            <?php echo esc_html( !is_null( $property_city ) ? $property_city->name : __('NA', 'luxus-core') ); ?>
					        </p>
					        <ul class="features">
					            <li>
					                <p><?php esc_html_e('Bedrooms', 'luxus-core'); ?></p>
					                <p><i class="sl-icon sl-bedroom"></i>
					                    <span>
					                        <?php echo esc_html( !empty( $property_bedrooms ) ? $property_bedrooms : __('NA', 'luxus-core') ); ?>
					                    </span>
					                </p>
					            </li>
					            <li>
					                <p><?php esc_html_e('Bathrooms', 'luxus-core'); ?></p>
					                <p><i class="sl-icon sl-bathroom"></i>
					                    <span>
					                        <?php echo esc_html( !empty( $property_bathrooms ) ? $property_bathrooms : __('NA', 'luxus-core') ); ?>
					                    </span>
					                </p>
					            </li>
					            <li>
					                <p><?php esc_html_e('Parking', 'luxus-core'); ?></p>
					                <p><i class="sl-icon sl-car"></i>
					                    <span>
					                        <?php echo esc_html( !empty( $property_parking ) ? $property_parking : __('NA', 'luxus-core') ); ?>
					                    </span>
					                </p>
					            </li>
					        </ul>
					    </div>
					    <div class="footer">
					        <span class="agent">
					            <i class="sl-icon sl-user-o"></i>
					            <?php

					                $author  = ucfirst( get_the_author() );
					                $link = get_author_posts_url( get_the_author_meta('ID') );

					                $link = sprintf( '<a href="%1$s"> %3$s </a>',
					                   esc_url( add_query_arg('post_type', 'property', $link )),
					                   esc_attr( sprintf( $author ) ),
					                   $author
					                );
					                echo $link;
					            ?>
					        </span>
					        <span class="date">
					            <i class="sl-icon sl-calendar"></i>
					            <?php 

					                $archive_year  = get_the_time( 'Y' ); 
					                $archive_month = get_the_time( 'm' ); 
					                $archive_day   = get_the_time( 'd' );
					                $get_day_link  = get_day_link( $archive_year, $archive_month, $archive_day );

					                $date_url = add_query_arg('post_type', 'property', $get_day_link );

					                echo '<a href="'. esc_url( $date_url ) .'">'. esc_html(get_the_date()) .'</a>';

					            ?>
					        </span>
					    </div>
					</div>
				</div>
             </div>

       <?php endwhile;

       wp_reset_postdata();
    }
    
}
