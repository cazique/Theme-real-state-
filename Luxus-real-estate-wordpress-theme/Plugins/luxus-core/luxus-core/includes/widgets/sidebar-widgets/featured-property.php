<?php

//custom property widget*/
class luxus_featured_property extends WP_Widget {

	function __construct() {
		parent::__construct(
			'luxus_featured_property', // Base ID
			__('Featured Property', 'luxus-core'), // Name
			array('description' => __('Displays your Featured Property listings.', 'luxus-core'))
		);
	}

	function widget($args, $instance) { //output
		extract( $args );
		// these are the widget options
		$title = apply_filters('widget_title', $instance['title']);
		$numberOfListings = $instance['numberOfListings'];
		echo $before_widget;
		// Check if title is set
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		$this->luxus_featured_property_widget($numberOfListings);
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['numberOfListings'] = strip_tags($new_instance['numberOfListings']);
		return $instance;
	}	
    
    // widget form creation
	function form($instance) {

	// Check values
	if( $instance) {
		$title = esc_attr($instance['title']);
		$numberOfListings = esc_attr($instance['numberOfListings']);
	} else {
		$title = '';
		$numberOfListings = '';
	}
	?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'luxus-core'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('numberOfListings'); ?>"><?php _e('Number of Listings:', 'luxus-core'); ?></label>		
		<select id="<?php echo $this->get_field_id('numberOfListings'); ?>"  name="<?php echo $this->get_field_name('numberOfListings'); ?>">
			<?php for( $x=1; $x<=10; $x++ ): ?>
			<option <?php echo $x == $numberOfListings ? 'selected="selected"' : '';?> value="<?php echo $x;?>"><?php echo $x; ?></option>
			<?php endfor;?>
		</select>
		</p>		 
	<?php
	}
	
	function luxus_featured_property_widget($numberOfListings) { //html
		global $post;

		add_image_size( 'luxus_featured_property_size', 100, 67, false );

		$featured_listings = new WP_Query(array(
			'post_type' => 'property',
			'posts_per_page' => esc_html($numberOfListings),
        	'meta_query' => array(
		       	array(
					'key' => '_property_label',
					'value' => '1',
					'compare' => '=',
		     	)
		   )
		)); ?>
		<ul class="sl-widget-properties">
			<?php if( $featured_listings->have_posts() ) :
					while ( $featured_listings->have_posts() ) :
						$featured_listings->the_post();

				$_status = luxus_post_meta( '_property_city' );
				$status = !empty( $_status ) ? get_term( $_status ) : null;
				$address = luxus_post_meta( '_property_st_address' );
				$_city = luxus_post_meta( '_property_city' );
				$city = !empty( $_city ) ? get_term( $_city ) : null;
				$_state = luxus_post_meta( '_property_state' );
				$state = !empty( $_state ) ? get_term( $_state ) : null;
				$before_price = luxus_post_meta( '_property_price_prefix' );
				$price = luxus_post_meta( '_property_price' );
        		$after_price = luxus_post_meta( '_property_price_postfix' );

				$featured_img_url = get_the_post_thumbnail_url( get_the_ID(),'luxus-thumb-md' );

			?>
				<li>
					<a href="<?php the_permalink() ?>">
						<img src="<?php echo esc_url($featured_img_url); ?>" alt="<?php esc_attr(the_title()); ?>">
					</a>
					<div class="sl-widget-property-info">
						<a href="<?php the_permalink() ?>"><h6 class="title"><?php the_title(); ?></h6></a>
						<span><i class="sl-icon sl-pin"></i>
							<?php echo esc_html((!empty( $city )) ? $city->name : ''); ?>, <?php echo esc_html((!empty( $state )) ? $state->name : ''); ?>
						</span>
						<p class="price">
							<?php 
			                    if( $before_price != NULL ) {
			                        echo '<span class="price-prefix">' . esc_html($before_price) . '</span> ';
			                    }

			                    echo esc_html(luxus_currency_symbol()) . esc_html($price);

			                    if( $after_price != NULL ) {
			                        echo '<span class="price-postfix"> - ' . esc_html($after_price) . '</span>';
			                    }
		                    ?>
						</p>
					</div>
				</li>

				<?php wp_reset_postdata();

				endwhile;
			endif; ?>
		</ul>	
		<?php
	}
	
} //end class luxus_featured_property

// Registering Featured Property Widget
add_action( 'widgets_init', 'luxus_register_featured_property_widget' );
function luxus_register_featured_property_widget() {

	register_widget('luxus_featured_property');

}