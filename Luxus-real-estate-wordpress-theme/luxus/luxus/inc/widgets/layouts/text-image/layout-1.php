<?php

$btn_target = $settings['text_image_link']['is_external'] ? ' target="_blank"' : '';
$btn_nofollow = $settings['text_image_link']['nofollow'] ? ' rel="nofollow"' : '';

?>

<div class="sl-text-image text-image-one">

        <?php
            if ( !empty($settings['text_image_link']['url']) ) {

                echo '<a href="' . esc_url($settings['text_image_link']['url']) . '"' . esc_attr($btn_target) . esc_attr($btn_nofollow) . '>';
                echo '<div class="image-container">';
                echo    '<div class="image" style="background-image: url(' . esc_url($settings['text_image_image']['url']) . ');">';
                echo        '<div class="img-overlay" style="width:100%; height:100%">';
                echo        '</div>';
                echo    '</div>';
                echo '</div>';
                echo '</a>';


            } else {

                echo '<div class="image-container">';
                echo    '<div class="image" style="background-image: url(' . esc_url($settings['text_image_image']['url']) . ');">';
                echo        '<div class="img-overlay" style="width:100%; height:100%">';
                echo        '</div>';
                echo    '</div>';
                echo '</div>';

            }
        ?>

    <div class="content">
        <?php if ( 'yes' == $settings['show_badge'] ) { ?>
        
            <div class="icon">

                <?php

                if ( 'icon' == $settings['badge_image_icon'] ) {

                   \Elementor\Icons_Manager::render_icon( $settings['badge_icon'], [ 'aria-hidden' => 'true' ] );
                }

                if ( 'image' == $settings['badge_image_icon'] ) {

                   echo '<img class="icon-image" src="' . esc_url($settings['badge_image']['url']) . '">';
                }

                ?>

            </div>
        <?php } ?>
        <h2><?php echo esc_html($settings['text_image_title']); ?></h2>
        <p class="text"><?php echo esc_html($settings['text_image_description']); ?></p>
        <?php if ( 'yes' === $settings['show_btn'] ) { ?>
	        <p class="action">
	            <?php echo '<a class="elementor-animation-' . esc_attr($settings['btn_hover_animation']) . '" href="' . esc_url($settings['text_image_link']['url']) . '"' . esc_attr($btn_target) . esc_attr($btn_nofollow) . '>' . esc_html($settings['btn_text']) . '</a>'; ?>
	        </p>
    	<?php } ?>
    </div>
</div>