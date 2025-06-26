<?php

$post_author_id = get_post_field ( 'post_author', get_the_ID() );
$author_info = get_userdata($post_author_id);

?>

<div id="printableArea" class="property-single property-style-one">
	<?php while ( have_posts() ) : the_post();

	// Property Images Area
	if( $property_gallery != NULL): ?>
	<div class="property-single-images slick-center">
		<?php
		    $gallery_ids = explode( ',', $property_gallery );

		    if ( ! empty( $gallery_ids ) ) :
		        foreach ( $gallery_ids as $gallery_item_id ) :
		            $image_preview = wp_get_attachment_image_src( $gallery_item_id , 'luxus-thumb-md' );
		            $image_full = wp_get_attachment_url( $gallery_item_id );
		            echo '<div class="slider-item"><a class="sl-popup" href="', esc_url($image_full), '"><i class="sl-icon sl-fullscreen"></i><img src="', esc_url($image_preview[0]), '"></a></div>';
		        endforeach;
			endif;
		?> 
	</div>
	<?php endif; ?>

	<div class="title-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<div class="title-left">

						<?php luxus_set_post_view(); ?>
						
						<h2 class="title"><?php the_title(); ?></h2>
						<?php if( !empty( $propery_address ) ): ?>
							<p class="address">
								<i class="sl-icon sl-place"></i>
								<?php echo esc_html($propery_address); ?>
							</p>
						<?php endif; ?>
					</div>
				</div>
		        <?php 
		            $have_compared = FALSE;
		            if( isset( $_COOKIE['luxus_compare_prop'] ) ) {
		                $data          = $_COOKIE['luxus_compare_prop'];
		                $exploded_data = explode('|',$data);

		                foreach ( $exploded_data as $compare_id ) {
		                    if($compare_id == get_the_ID()){
		                        $have_compared = TRUE;
		                    }
		                }
		            }

		            $is_favourite = FALSE;
		            if( $get_user_data != '' ) {
		                if ( in_array( get_the_ID(), $get_user_data) ) {
		                    $is_favourite = TRUE;
		                }
		            }
		               
		        ?>
				<div id="noPrintableArea" class="col-lg-4">
					<div class="title-right">
						<div class="icons">
							<a data-userLogin="<?php echo esc_attr(is_user_logged_in() ? 'Yes' : 'No'); ?>" data-heartValue="<?php echo esc_attr($is_favourite ? 'Yes' : 'No'); ?>" class="<?php echo esc_attr($is_favourite ? 'already-selected' : ''); ?>" id="heartbtn<?php echo esc_attr(get_the_ID()); ?>" onclick="save_heart('<?php echo esc_js(get_the_ID()); ?>'); return false;"  href="#"  data-toggle="tooltip" title="<?php esc_attr_e('Bookmark', 'luxus-core'); ?>" ><i class="sl-icon sl-heart"></i></a>

                    		<a data-compareValue="<?php echo esc_attr($have_compared ? 'Yes' : 'No'); ?>" class="<?php echo esc_attr($have_compared ? 'already-selected' : ''); ?>" id="comparebtn<?php echo esc_attr(get_the_ID()); ?>" onclick="save_compare('<?php echo esc_js(get_the_ID()); ?>'); return false;" href="#" data-toggle="tooltip" title="<?php esc_attr_e('Compare', 'luxus-core'); ?>"><i class="sl-icon sl-compare"></i></a>

							<a href="#" data-toggle="tooltip" title="<?php esc_attr_e('Print', 'luxus-core'); ?>" onclick="sl_print('printableArea'); return false;"><i class="sl-icon sl-print-t"></i></a>
						</div>
						<p class="date"><i class="sl-icon sl-calendar"></i><?php echo esc_html(get_the_date()); ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-lg-8">

				<!-- Property Discription -->
				<div class="sl-box property-description">
					<h6 class="heading"><?php esc_html_e('Property Description', 'luxus-core'); ?></h6>
					<div class="price-area">
						<?php

						if( $property_status != NULL ): ?>
							<span class="status">
								<?php echo esc_html__('For', 'luxus-core') . ' ' . esc_html($property_status->name); ?>
							</span>
						<?php endif;

						if( !empty( $property_price ) ): ?>
							<span class="price <?php echo is_null($property_status) ? 'left' : ''; ?>">
								<?php
									if( $property_price_prefix != NULL ) {
					                    echo '<span class="price-prefix">' . esc_html($property_price_prefix) . '</span>';
					                }

									echo esc_html(luxus_currency_symbol()) . esc_html($property_price);

									if( $property_price_postfix != NULL ) {
				                        echo '<span class="price-postfix"> ' . esc_html($property_price_postfix) . '</span>';
				                    }
								?>
							</span>
						<?php endif; ?>
					</div>
					<div class="text"><?php the_content(); ?></div>
					<div class="main-features">
						<ul>
							<li>
								<div class="single-feature">
						    		<p><?php echo esc_html__('Type', 'luxus-core'); ?></p>
						    		<span><?php echo esc_html( $property_type != NULL ? $property_type->name : __('NA', 'luxus-core') ); ?></span>
						    		<i class="sl-icon sl-building"></i>
						    	</div>
						    </li>
							<li>
								<div class="single-feature">
						    		<p><?php echo esc_html__('Build', 'luxus-core'); ?></p>
						    		<span><?php echo esc_html( !empty( $property_build ) ? $property_build : __('NA', 'luxus-core') ); ?></span>
						    		<i class="sl-icon sl-blueprint"></i>
						    	</div>
						    </li>
							<li>
								<div class="single-feature">
						    		<p><?php echo esc_html__('Size', 'luxus-core'); ?></p>
						    		<?php if( !empty( $property_area ) ): ?>
						    			<span>
						    				<?php 
						    					echo esc_html($property_area) . ' ' . esc_html(luxus_area_units());
							    				if( $property_area_postfix != NULL ) {
					                            echo '<span class="area-postfix"> ' . esc_html($property_area_postfix) . '</span>';
					                        	}
				                        	?>
						    			</span>
						    		<?php
						    			else: ?>
											<span><?php esc_html_e('NA', 'luxus-core'); ?></span>
						    		<?php
						    		endif; ?>
						    		<i class="sl-icon sl-ruler-o"></i>
						    	</div>
						    </li>
							<li>
								<div class="single-feature">
						    		<p><?php echo esc_html__('Lot Size', 'luxus-core'); ?></p>
						    		<?php if( !empty( $property_larea ) ): ?>
						    			<span>
						    				<?php 
						    					echo esc_html($property_larea) . ' ' . esc_html(luxus_area_units());
							    				if( $property_larea_postfix != NULL ) {
					                            echo '<span class="larea-postfix"> ' . esc_html($property_larea_postfix) . '</span>';
					                        	}
				                        	?>
						    			</span>
						    		<?php
						    			else: ?>
											<span><?php esc_html_e('NA', 'luxus-core'); ?></span>
						    		<?php
						    		endif; ?>
						    		<i class="sl-icon sl-area"></i>
						    	</div>
						    </li>
						</ul>
					</div>
				</div>

				<!-- Property Features -->
				<?php if( $property_features != NULL ): ?>
					<div class="sl-box property-features">
					    <h6 class="heading"><?php esc_html_e('Property Amenities', 'luxus-core'); ?></h6>
					    <div class="features-list">
					        <ul>
					            <?php
					                foreach($property_features as $single_feature):
					                	$feature_link = get_term_link( $single_feature );
					            ?>
					                    <li>
					                        <i class="sl-icon sl-check-o"></i>
					                        <a href="<?php echo esc_url( $feature_link ); ?>"><span><?php echo esc_html($single_feature->name); ?></span></a>
					                    </li>
					            <?php
					                endforeach;
					            ?>
					        </ul>
					    </div>
					</div>
				<?php endif;

				// Additional Features
				if( $property_add_features != NULL ): ?>
					<div class="sl-box additional-features">
						<h6 class="heading"><?php esc_html_e('Additional Features', 'luxus-core'); ?></h6>
						<div class="add-features-list">
							<ul>
								<?php
									foreach ( $property_add_features as $additional_feature ):
									echo '<li><span class="title">',esc_html($additional_feature['add_feature_label']),'</span><span class="value">',esc_html($additional_feature['add_feature_value']),'</span></li>';
									endforeach;
								?>
							</ul>
						</div>
					</div>
				<?php endif; 

				// Property Video 
				if( $enable_video == true && $property_video != NULL ): ?>
					<div id="noPrintableArea" class="sl-box property-video">
						<h6 class="heading"><?php esc_html_e('Property Video', 'luxus-core'); ?></h6>
						<div class="sl-video-popup" style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url()); ?>');">
				            <a href="<?php echo esc_url($property_video); ?>" class="video-popup play-btn">
				            	<i class="sl-icon sl-play-t"></i>
				            </a>
				        </div>
					</div>
				<?php
				endif;

				// Property 360 Image / Virtual Tour
				$panorama_url = isset($property_panorama['url']) ? $property_panorama['url'] : '';

				if( $enable_virtual_tour == true && $panorama_url != NULL ): ?>
				<div id="noPrintableArea" class="sl-box">
					<h6 class="heading"><?php esc_html_e('Property Virtual Tour', 'luxus-core'); ?></h6>
					<div class="luxus-360-image" id="luxus-360-image"></div>

					<script>
					  var viewer = new PhotoSphereViewer.Viewer({
					    container: document.querySelector('#luxus-360-image'),
					    panorama: '<?php echo $panorama_url; ?>',
					    defaultZoomLvl: 0,
					    mousewheelCtrlKey: true,
		  				touchmoveTwoFingers: true,
		  				navbar: ['autorotate', 'zoom', 'move', 'fullscreen'],
					  });
					</script>
				</div>
				<?php endif;

				//Property Map
				if($enable_map == true && $property_map != NULL ): ?>
					<div id="noPrintableArea" class="sl-box property-map">
						<h6 class="heading"><?php esc_html_e('Property Map', 'luxus-core'); ?></h6>
						<div id="property-map"></div>
					</div>
				<?php endif;

				// Schedule Tour
				if ( $enable_schedule_tour == true && $author_info->roles[0] !== 'administrator' ) :
					require dirname( __FILE__ ) . '/schedule-tour-form.php';
				endif;

				// Related Properties
				if ( $enable_relative_posts == true ) :
                ?>
	            	<h6 id="noPrintableArea" class="heading"><?php esc_html_e('Related Properties', 'luxus-core'); ?></h6>
	                <div id="noPrintableArea" class="row">
	                    <?php require dirname( __FILE__ ) . '/property-related-posts.php'; ?>
	                </div>
                <?php endif;
                
                // Reviews
                if ( $enable_reviews == true ) :
	                // If comments are open or we have at least one comment, load up the comment template.
	                if ( comments_open() || get_comments_number() ) {
	                    echo '<h6 class="heading">'. esc_html__('Reviews', 'luxus-core') .'</h6>';
	                	comments_template('/template-parts/reviews.php', true);
	                }
                endif;
                ?>
			</div>

			<!-- Side Area -->
			<div class="col-lg-4 sl-sticky <?php echo esc_attr( $sidebar_position == 'left-sidebar' ? 'order-lg-first' : '' ); ?>">

				<!-- Agency Info -->
				<?php

				$author_img_placeholder = SL_PLUGIN_URL . 'public/images/agency-profile.jpg';

				$author_pic = get_the_author_meta( 'luxus_user_profile_img', $post_author_id );
				$author_pic_url = !empty($author_pic['url']) ? $author_pic['url'] : $author_img_placeholder;
				$author_displayname = get_the_author_meta( 'display_name', $post_author_id );
				$author_email = get_the_author_meta( 'user_email', $post_author_id ); 
				$author_license = get_the_author_meta( 'luxus_user_license', $post_author_id );
				$author_phone = get_the_author_meta( 'luxus_user_phone', $post_author_id );
				$author_mobile = get_the_author_meta( 'luxus_user_mobile', $post_author_id );
				$author_city = get_the_author_meta( 'luxus_user_city', $post_author_id );
				$author_permalink = get_author_posts_url( $post_author_id );

				?>
				<div class="sl-box agent-info">
					<div class="picture" style="background-image: url(<?php echo esc_url($author_pic_url); ?>);"></div>
					<h6 class="name"><?php echo esc_html($author_displayname); ?></h6>
					<div class="contect-info">
						<ul>
							<?php if (!is_null( $author_email )): ?>
								<li><span><?php esc_html_e('Email:', 'luxus-core'); ?></span>
									<?php echo esc_html( $author_email ); ?>
								</li>
							<?php endif;

							if (!empty( $author_license )): ?>
								<li><span><?php esc_html_e('Licance:', 'luxus-core'); ?></span>
									<?php echo esc_html( $author_license ); ?>
								</li>
							<?php endif;

							if (!empty( $author_phone )): ?>
								<li><span><?php esc_html_e('Phone:', 'luxus-core'); ?></span>
									<?php echo esc_html( $author_phone ); ?>
								</li>
							<?php endif;

							if (!empty( $author_mobile )): ?>
								<li><span><?php esc_html_e('Mobile:', 'luxus-core'); ?></span>
									<?php echo esc_html( $author_mobile ); ?>
								</li>
							<?php endif;

							if (!empty( $author_city )): ?>
								<li><span><?php esc_html_e('Location:', 'luxus-core'); ?></span>
									<?php echo esc_html( $author_city ); ?>
								</li>
							<?php endif ?>
						</ul>
					</div>
					<a class="sl-btn-fill" href="<?php echo esc_url($author_permalink); ?>"><?php esc_html_e('View Profile', 'luxus-core'); ?></a>
				</div>

				<?php

				// Contact User
				if ( $enable_contact_form == true ) :

					require dirname( __FILE__ ) . '/contact-user-form.php';

				endif;
				
				if( is_active_sidebar( 'property-pages-widget' ) ) : ?>
				<div id="noPrintableArea">
					<aside id="secondary" class="widget-area">
	                    <?php dynamic_sidebar( 'property-pages-widget' ); ?>
	                </aside><!-- #secondary -->
                </div>
            	<?php endif; ?>
                
			</div>
		</div>
	</div>
	<?php
	    
	    wp_reset_postdata();

	    endwhile;
	?>
</div>
<!-- Single End -->

<!-- Property Map Script -->
<?php if ( $enable_map == true && $property_map != NULL ) {

	// getting Values From Meta
	$latitude = isset( $property_map['latitude'] ) ? $property_map['latitude'] : 0 ;
	$longtitude = isset( $property_map['longitude'] ) ? $property_map['longitude'] : 0 ;
	$map_marker = SL_PLUGIN_URL . 'public/images/map-pin.png';

	// Single Property Map Script
	wp_register_script( 'luxus-single-property', '', array("jquery"), '', true );
	wp_enqueue_script( 'luxus-single-property'  );

	wp_add_inline_script( 'luxus-single-property', "

		jQuery( document ).ready( function( $ ) {

		    var markerLocation = [{$latitude}, {$longtitude}];
		    var mapZoom = 11;

		    var map = L.map('property-map', {
		        center: markerLocation,
		        zoom: mapZoom,
		        scrollWheelZoom: false,
		        'layers': [
			        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			            attribution: '&copy; <a href=\"https://osm.org/copyright\">OpenStreetMap</a> contributors'
			        })
			    ]
		    });

		    map.attributionControl.setPrefix(false);

		    // create custom icon
		    var mapMarker = L.icon({
		        iconUrl: '{$map_marker}',
		        iconSize: [40, 48], // size of the icon
		    });

		    var marker = new L.marker(markerLocation, {
		        icon: mapMarker,
		        draggable: false
		    }).bindPopup('{$propery_address}').openPopup();

		    marker.addTo(map);

		});

	");

}
