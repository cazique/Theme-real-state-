<?php

$fallback_defaults = [
    'fa fa-facebook',
    'fa fa-twitter',
    'fa fa-instagram',
];

$migration_allowed = \Elementor\Icons_Manager::is_migration_allowed();
$team_link = $settings['team_link']['url'];

?>

<div class="sl-team team-one">
    <div class="img">
        <?php
        if (!empty($team_link)) { echo '<a href="' . esc_url($team_link) . '">'; }
        
        echo '<img src="' . esc_url($settings['team_image']['url']) . '" alt="'. esc_attr($settings['team_title']) .'">';

        if (!empty($team_link)) { echo '</a>'; }
        
        if ( 'yes' == $settings['team_show_icons'] ) :

        ?>
            <div class="social">
                <ul>
                <?php
                    foreach ( $settings['social_icon_list'] as $index => $item ) :
                        $migrated = isset( $item['__fa4_migrated']['social_icon'] );
                        $is_new = empty( $item['social'] ) && $migration_allowed;
                        $social = '';

                        // add old default
                        if ( empty( $item['social'] ) && ! $migration_allowed ) {
                            $item['social'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-wordpress';
                        }

                        if ( ! empty( $item['social'] ) ) {
                            $social = str_replace( 'fa fa-', '', $item['social'] );
                        }

                        if ( ( $is_new || $migrated ) && 'svg' !== $item['social_icon']['library'] ) {
                            $social = explode( ' ', $item['social_icon']['value'], 2 );
                            if ( empty( $social[1] ) ) {
                                $social = '';
                            } else {
                                $social = str_replace( 'fa-', '', $social[1] );
                            }
                        }
                        if ( 'svg' === $item['social_icon']['library'] ) {
                            $social = get_post_meta( $item['social_icon']['value']['id'], '_wp_attachment_image_alt', true );
                        }

                        $link_key = 'link_' . $index;

                        $this->add_render_attribute( $link_key, 'class', ['social-link'] );

                        $this->add_link_attributes( $link_key, $item['link'] );

                ?>

                        <li>
                            <?php echo '<a ' . $this->get_render_attribute_string( $link_key ) . '>'; ?>
                                <span class="elementor-screen-only"><?php echo ucwords( $social ); ?></span>
                                <?php
                                if ( $is_new || $migrated ) {
                                    \Elementor\Icons_Manager::render_icon( $item['social_icon'] );
                                } else { ?>
                                    <i class="<?php echo esc_attr( $item['social'] ); ?>"></i>
                                <?php }
                                echo '</a>';
                            ?>
                        </li>
                <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
    <?php if (!empty($team_link)) { echo '<a href="' . esc_url($team_link) . '">'; } ?>
    <h2 class="name"><?php echo esc_html($settings['team_title']); ?></h2>
    <?php if (!empty($team_link)) { echo '</a>'; } ?>
    <p class="possition"><?php echo esc_html($settings['team_designation']); ?></p>
</div>