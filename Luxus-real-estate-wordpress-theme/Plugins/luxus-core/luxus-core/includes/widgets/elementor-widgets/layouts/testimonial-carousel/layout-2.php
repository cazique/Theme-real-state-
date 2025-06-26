<?php

if ( $settings['testimonial'] ) :

    foreach (  $settings['testimonial'] as $item ) {
 ?>
 
	<div class="sl-item <?php echo 'elementor-repeater-item-' . esc_attr($item['_id']); ?>">
		<div class="review-item review-two">
		    <div class="info">
		        <?php
	                if ( !empty( $item['testimonial_image'] ) ) {
	                    echo '<img class="img" src="' . esc_url($item['testimonial_image']['url']) . '" alt="'. esc_attr($item['testimonial_title']) .'">';
	                }
	            ?>
		        <h6 class="name"><?php echo esc_html($item['testimonial_title']); ?></h6>
		        <p class="possition"><?php echo esc_html($item['testimonial_designation']); ?></p>
		    </div>
		    <div class="content">
		        <p class="text"><?php echo esc_html($item['testimonial_content']); ?></p>
		    </div>
		    <i class="sl-icon sl-quote-right"></i>
		</div>
	</div>

<?php

    }

endif; ?>