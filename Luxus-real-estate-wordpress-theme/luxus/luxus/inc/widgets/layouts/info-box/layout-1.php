<?php

$btn_target = isset( $settings['info_box_btn_link']['is_external'] ) ? ' target="_blank"' : '';
$btn_nofollow = isset( $settings['info_box_btn_link']['nofollow'] ) ? ' rel="nofollow"' : '';
$box_link = !empty( $settings['info_box_link']['url'] ) ? $settings['info_box_link']['url'] : '';

?>

<div class="sl-info-box info-box-one"> 
    <?php

    if ( !empty( $box_link ) ) {

        echo '<div class="infobox-overlay"><a href="'. esc_url( $box_link) .'"></a></div>';
    }

    if ( 'yes' == $settings['info_box_show_icon'] ) { ?>
    
        <div class="icon">

            <?php

                if ( 'icon' == $settings['info_box_image_icon'] ) {

                   \Elementor\Icons_Manager::render_icon( $settings['info_box_icon'], [ 'aria-hidden' => 'true' ] );
                }

                if ( 'image' == $settings['info_box_image_icon'] ) {
					
					$image_url = $settings['info_box_image']['url'];
					$image_width = $settings['image_size_custom_dimension']['width'];
					$image_height = $settings['image_size_custom_dimension']['height'];
					
                    echo '<img class="icon-image" src="'. esc_url($image_url) .'" alt="'. esc_attr($settings['info_box_title']) .'" width="'. esc_attr($image_width) .'" height="' . esc_attr($image_height) .'">';
                }

            ?>

        </div>
    <?php } ?>

    <div class="content">
        <h2 class="title"><?php echo esc_html($settings['info_box_title']); ?></h2>
        <p class="text"><?php echo esc_html($settings['info_box_description']); ?></p>
        <?php if ( 'yes' === $settings['info_box_show_btn'] ) { ?>
            <p class="action">
                <?php echo '<a class="elementor-animation-' . esc_attr($settings['btn_hover_animation']) . '" href="' . esc_url($box_link) . '"' . esc_attr($btn_target) . esc_attr($btn_nofollow) . '>' . esc_html($settings['info_box_btn_text']) . '</a>'; ?>
            </p>
        <?php } ?>   
    </div>
</div>