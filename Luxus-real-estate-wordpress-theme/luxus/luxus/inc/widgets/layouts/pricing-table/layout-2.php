<?php

$btn_target = $settings['btn_link']['is_external'] ? ' target="_blank"' : '';
$btn_nofollow = $settings['btn_link']['nofollow'] ? ' rel="nofollow"' : '';

?>

<div class="sl-pricing pricing-two">
    <div class="price">
        <?php echo esc_html($settings['pricing_price']); ?>
        <?php if ( 'yes' === $settings['pricing_show_badge'] ) { ?>
            <div class="badge">
                <?php \Elementor\Icons_Manager::render_icon( $settings['badge_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                <span class="badge-after"></span>
            </div>
        <?php } ?>
    </div>
    <div class="title">
        <h2><?php echo esc_html($settings['pricing_title']); ?></h2>
    </div>
    <div class="features">
        <ul>
            <?php
                if ( $settings['features_list'] ) {
                    foreach (  $settings['features_list'] as $item ) {
                        echo '<li class="elementor-repeater-item-' . esc_attr($item['_id']) . '">' . esc_html($item['features_list_title']) . '</li>';
                    }
                }
            ?>
        </ul>
    </div>
    <?php if ( 'yes' === $settings['show_btn'] ) { ?>
        <div class="action">
            <?php echo '<a class="elementor-animation-' . esc_attr($settings['btn_hover_animation']) . '" href="' . esc_url($settings['btn_link']['url']) . '"' . esc_attr($btn_target) . esc_attr($btn_nofollow) . '>' . esc_html($settings['btn_text']) . '</a>'; ?>
        </div>
    <?php } ?>
</div>